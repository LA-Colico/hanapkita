<?php
/**
 * Activity Logger Functions
 * This file contains functions to log user activities across the application
 */

class ActivityLogger {
    private $dbh;
    
    public function __construct($database_connection) {
        $this->dbh = $database_connection;
    }
    
    /**
     * Get user's IP address
     */
    private function getUserIP() {
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            return $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            return $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            return $_SERVER['REMOTE_ADDR'];
        }
    }
    
    /**
     * Get user agent
     */
    private function getUserAgent() {
        return $_SERVER['HTTP_USER_AGENT'] ?? 'Unknown';
    }
    
    /**
     * Generate session ID
     */
    private function generateSessionId() {
        return 'sess_' . uniqid() . '_' . time();
    }
    
    /**
     * Log employer activity (login/logout)
     */
    public function logEmployerActivity($employer_id, $employer_email, $company_name, $action_type, $session_id = null) {
        try {
            if (!$session_id) {
                $session_id = $this->generateSessionId();
            }
            
            $sql = "INSERT INTO tbl_employer_logs (employer_id, employer_email, company_name, action_type, 
                    ip_address, user_agent, session_id, login_time, logout_time, status, created_at) 
                    VALUES (:employer_id, :employer_email, :company_name, :action_type, 
                    :ip_address, :user_agent, :session_id, :login_time, :logout_time, :status, NOW())";
            
            $login_time = null;
            $logout_time = null;
            $status = 'active';
            
            if ($action_type === 'login') {
                $login_time = date('Y-m-d H:i:s');
                $status = 'active';
            } elseif ($action_type === 'logout') {
                $logout_time = date('Y-m-d H:i:s');
                $status = 'completed';
                
                // Update the corresponding login record with logout time and duration
                $this->updateEmployerLogout($session_id, $logout_time);
            }
            
            $query = $this->dbh->prepare($sql);
            $query->bindParam(':employer_id', $employer_id, PDO::PARAM_INT);
            $query->bindParam(':employer_email', $employer_email, PDO::PARAM_STR);
            $query->bindParam(':company_name', $company_name, PDO::PARAM_STR);
            $query->bindParam(':action_type', $action_type, PDO::PARAM_STR);
            $query->bindParam(':ip_address', $this->getUserIP(), PDO::PARAM_STR);
            $query->bindParam(':user_agent', $this->getUserAgent(), PDO::PARAM_STR);
            $query->bindParam(':session_id', $session_id, PDO::PARAM_STR);
            $query->bindParam(':login_time', $login_time, PDO::PARAM_STR);
            $query->bindParam(':logout_time', $logout_time, PDO::PARAM_STR);
            $query->bindParam(':status', $status, PDO::PARAM_STR);
            
            $query->execute();
            
            return $session_id;
        } catch (Exception $e) {
            error_log("Error logging employer activity: " . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Update employer logout information
     */
    private function updateEmployerLogout($session_id, $logout_time) {
        try {
            // Find the corresponding login record
            $sql_find = "SELECT id, login_time FROM tbl_employer_logs 
                        WHERE session_id = :session_id AND action_type = 'login' AND status = 'active'
                        ORDER BY created_at DESC LIMIT 1";
            $query_find = $this->dbh->prepare($sql_find);
            $query_find->bindParam(':session_id', $session_id, PDO::PARAM_STR);
            $query_find->execute();
            $login_record = $query_find->fetch(PDO::FETCH_OBJ);
            
            if ($login_record) {
                // Calculate duration
                $login_timestamp = strtotime($login_record->login_time);
                $logout_timestamp = strtotime($logout_time);
                $duration_minutes = round(($logout_timestamp - $login_timestamp) / 60);
                
                // Update the login record
                $sql_update = "UPDATE tbl_employer_logs 
                              SET logout_time = :logout_time, duration_minutes = :duration_minutes, status = 'completed'
                              WHERE id = :id";
                $query_update = $this->dbh->prepare($sql_update);
                $query_update->bindParam(':logout_time', $logout_time, PDO::PARAM_STR);
                $query_update->bindParam(':duration_minutes', $duration_minutes, PDO::PARAM_INT);
                $query_update->bindParam(':id', $login_record->id, PDO::PARAM_INT);
                $query_update->execute();
            }
        } catch (Exception $e) {
            error_log("Error updating employer logout: " . $e->getMessage());
        }
    }
    
    /**
     * Log job seeker activity
     */
    public function logJobSeekerActivity($jobseeker_id, $jobseeker_email, $jobseeker_name, $action_type, $session_id = null) {
        try {
            if (!$session_id) {
                $session_id = $this->generateSessionId();
            }
            
            $sql = "INSERT INTO tbl_jobseeker_logs (jobseeker_id, jobseeker_email, jobseeker_name, action_type, 
                    ip_address, user_agent, session_id, login_time, logout_time, status, created_at) 
                    VALUES (:jobseeker_id, :jobseeker_email, :jobseeker_name, :action_type, 
                    :ip_address, :user_agent, :session_id, :login_time, :logout_time, :status, NOW())";
            
            $login_time = null;
            $logout_time = null;
            $status = 'active';
            
            if ($action_type === 'login') {
                $login_time = date('Y-m-d H:i:s');
                $status = 'active';
            } elseif ($action_type === 'logout') {
                $logout_time = date('Y-m-d H:i:s');
                $status = 'completed';
                $this->updateJobSeekerLogout($session_id, $logout_time);
            }
            
            $query = $this->dbh->prepare($sql);
            $query->bindParam(':jobseeker_id', $jobseeker_id, PDO::PARAM_INT);
            $query->bindParam(':jobseeker_email', $jobseeker_email, PDO::PARAM_STR);
            $query->bindParam(':jobseeker_name', $jobseeker_name, PDO::PARAM_STR);
            $query->bindParam(':action_type', $action_type, PDO::PARAM_STR);
            $query->bindParam(':ip_address', $this->getUserIP(), PDO::PARAM_STR);
            $query->bindParam(':user_agent', $this->getUserAgent(), PDO::PARAM_STR);
            $query->bindParam(':session_id', $session_id, PDO::PARAM_STR);
            $query->bindParam(':login_time', $login_time, PDO::PARAM_STR);
            $query->bindParam(':logout_time', $logout_time, PDO::PARAM_STR);
            $query->bindParam(':status', $status, PDO::PARAM_STR);
            
            $query->execute();
            
            return $session_id;
        } catch (Exception $e) {
            error_log("Error logging job seeker activity: " . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Update job seeker logout information
     */
    private function updateJobSeekerLogout($session_id, $logout_time) {
        try {
            $sql_find = "SELECT id, login_time FROM tbl_jobseeker_logs 
                        WHERE session_id = :session_id AND action_type = 'login' AND status = 'active'
                        ORDER BY created_at DESC LIMIT 1";
            $query_find = $this->dbh->prepare($sql_find);
            $query_find->bindParam(':session_id', $session_id, PDO::PARAM_STR);
            $query_find->execute();
            $login_record = $query_find->fetch(PDO::FETCH_OBJ);
            
            if ($login_record) {
                $login_timestamp = strtotime($login_record->login_time);
                $logout_timestamp = strtotime($logout_time);
                $duration_minutes = round(($logout_timestamp - $login_timestamp) / 60);
                
                $sql_update = "UPDATE tbl_jobseeker_logs 
                              SET logout_time = :logout_time, duration_minutes = :duration_minutes, status = 'completed'
                              WHERE id = :id";
                $query_update = $this->dbh->prepare($sql_update);
                $query_update->bindParam(':logout_time', $logout_time, PDO::PARAM_STR);
                $query_update->bindParam(':duration_minutes', $duration_minutes, PDO::PARAM_INT);
                $query_update->bindParam(':id', $login_record->id, PDO::PARAM_INT);
                $query_update->execute();
            }
        } catch (Exception $e) {
            error_log("Error updating job seeker logout: " . $e->getMessage());
        }
    }
    
    /**
     * Log admin activity
     */
    public function logAdminActivity($admin_id, $admin_name, $action_type, $action_description, $target_table = null, $target_id = null) {
        try {
            $sql = "INSERT INTO tbl_admin_logs (admin_id, admin_name, action_type, action_description, 
                    target_table, target_id, ip_address, user_agent, session_id, created_at) 
                    VALUES (:admin_id, :admin_name, :action_type, :action_description, 
                    :target_table, :target_id, :ip_address, :user_agent, :session_id, NOW())";
            
            $session_id = session_id();
            
            $query = $this->dbh->prepare($sql);
            $query->bindParam(':admin_id', $admin_id, PDO::PARAM_INT);
            $query->bindParam(':admin_name', $admin_name, PDO::PARAM_STR);
            $query->bindParam(':action_type', $action_type, PDO::PARAM_STR);
            $query->bindParam(':action_description', $action_description, PDO::PARAM_STR);
            $query->bindParam(':target_table', $target_table, PDO::PARAM_STR);
            $query->bindParam(':target_id', $target_id, PDO::PARAM_INT);
            $query->bindParam(':ip_address', $this->getUserIP(), PDO::PARAM_STR);
            $query->bindParam(':user_agent', $this->getUserAgent(), PDO::PARAM_STR);
            $query->bindParam(':session_id', $session_id, PDO::PARAM_STR);
            
            $query->execute();
            
            return true;
        } catch (Exception $e) {
            error_log("Error logging admin activity: " . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Get recent activities for dashboard
     */
    public function getRecentActivities($limit = 10) {
        try {
            $sql = "
                SELECT 'employer' as user_type, company_name as user_name, action_type, created_at
                FROM tbl_employer_logs
                UNION ALL
                SELECT 'admin' as user_type, admin_name as user_name, action_type, created_at
                FROM tbl_admin_logs
                UNION ALL
                SELECT 'jobseeker' as user_type, jobseeker_name as user_name, action_type, created_at
                FROM tbl_jobseeker_logs
                ORDER BY created_at DESC
                LIMIT :limit
            ";
            
            $query = $this->dbh->prepare($sql);
            $query->bindParam(':limit', $limit, PDO::PARAM_INT);
            $query->execute();
            
            return $query->fetchAll(PDO::FETCH_OBJ);
        } catch (Exception $e) {
            error_log("Error getting recent activities: " . $e->getMessage());
            return [];
        }
    }
    
    /**
     * Get activity statistics
     */
    public function getActivityStats() {
        try {
            $stats = [];
            
            // Today's activities
            $sql = "SELECT COUNT(*) as count FROM tbl_employer_logs WHERE DATE(created_at) = CURDATE()";
            $query = $this->dbh->prepare($sql);
            $query->execute();
            $stats['today_activities'] = $query->fetch(PDO::FETCH_OBJ)->count;
            
            // Active sessions
            $sql = "SELECT COUNT(*) as count FROM tbl_employer_logs WHERE status = 'active'";
            $query = $this->dbh->prepare($sql);
            $query->execute();
            $stats['active_sessions'] = $query->fetch(PDO::FETCH_OBJ)->count;
            
            // Average session duration
            $sql = "SELECT AVG(duration_minutes) as avg_duration FROM tbl_employer_logs WHERE duration_minutes IS NOT NULL";
            $query = $this->dbh->prepare($sql);
            $query->execute();
            $result = $query->fetch(PDO::FETCH_OBJ);
            $stats['avg_duration'] = $result->avg_duration ? round($result->avg_duration) : 0;
            
            // This week's activities
            $sql = "SELECT COUNT(*) as count FROM tbl_employer_logs WHERE created_at >= DATE_SUB(NOW(), INTERVAL 7 DAY)";
            $query = $this->dbh->prepare($sql);
            $query->execute();
            $stats['week_activities'] = $query->fetch(PDO::FETCH_OBJ)->count;
            
            return $stats;
        } catch (Exception $e) {
            error_log("Error getting activity stats: " . $e->getMessage());
            return [];
        }
    }
    
    /**
     * Clean old logs (older than specified days)
     */
    public function cleanOldLogs($days = 90) {
        try {
            $tables = ['tbl_employer_logs', 'tbl_admin_logs', 'tbl_jobseeker_logs'];
            $deleted = 0;
            
            foreach ($tables as $table) {
                $sql = "DELETE FROM $table WHERE created_at < DATE_SUB(NOW(), INTERVAL :days DAY)";
                $query = $this->dbh->prepare($sql);
                $query->bindParam(':days', $days, PDO::PARAM_INT);
                $query->execute();
                $deleted += $query->rowCount();
            }
            
            return $deleted;
        } catch (Exception $e) {
            error_log("Error cleaning old logs: " . $e->getMessage());
            return false;
        }
    }
}

// Helper functions for easy use across the application

/**
 * Initialize activity logger
 */
function initActivityLogger($dbh) {
    return new ActivityLogger($dbh);
}

/**
 * Quick function to log admin actions
 */
function logAdminAction($dbh, $admin_id, $admin_name, $action_type, $description, $target_table = null, $target_id = null) {
    $logger = new ActivityLogger($dbh);
    return $logger->logAdminActivity($admin_id, $admin_name, $action_type, $description, $target_table, $target_id);
}

/**
 * Quick function to log employer login/logout
 */
function logEmployerAction($dbh, $employer_id, $employer_email, $company_name, $action_type, $session_id = null) {
    $logger = new ActivityLogger($dbh);
    return $logger->logEmployerActivity($employer_id, $employer_email, $company_name, $action_type, $session_id);
}

/**
 * Quick function to log job seeker login/logout
 */
function logJobSeekerAction($dbh, $jobseeker_id, $jobseeker_email, $jobseeker_name, $action_type, $session_id = null) {
    $logger = new ActivityLogger($dbh);
    return $logger->logJobSeekerActivity($jobseeker_id, $jobseeker_email, $jobseeker_name, $action_type, $session_id);
}

// Example usage in your existing files:
/*
// In admin login
include('includes/activity-logger.php');
logAdminAction($dbh, $_SESSION['jpaid'], $admin_name, 'login', 'Admin logged into the system');

// In employer registration
logEmployerAction($dbh, $employer_id, $email, $company_name, 'register');

// In job creation
logAdminAction($dbh, $_SESSION['jpaid'], $admin_name, 'create', 'Created new job listing', 'tbljobs', $job_id);

// In category deletion
logAdminAction($dbh, $_SESSION['jpaid'], $admin_name, 'delete', 'Deleted job category: ' . $category_name, 'tblcategory', $category_id);
*/
?>

<!-- New Created File 2 -->