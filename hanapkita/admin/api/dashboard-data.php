<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

// Include database connection
include('../includes/dbconnection.php');
include('../includes/activity-logger.php');

// Check if request is valid
if (!isset($_GET['action'])) {
    http_response_code(400);
    echo json_encode(['error' => 'No action specified']);
    exit;
}

$action = $_GET['action'];

try {
    switch ($action) {
        case 'stats':
            getStats($dbh);
            break;
        
        case 'applications_chart':
            getApplicationsChart($dbh);
            break;
        
        case 'categories_chart':
            getCategoriesChart($dbh);
            break;
        
        case 'status_chart':
            getStatusChart($dbh);
            break;
        
        case 'recent_activities':
            getRecentActivities($dbh);
            break;
        
        case 'activity_stats':
            getActivityStats($dbh);
            break;
        
        case 'hourly_activity':
            getHourlyActivity($dbh);
            break;
        
        case 'user_sessions':
            getUserSessions($dbh);
            break;
        
        default:
            http_response_code(400);
            echo json_encode(['error' => 'Invalid action']);
            break;
    }
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Server error: ' . $e->getMessage()]);
}

/**
 * Get basic dashboard statistics
 */
function getStats($dbh) {
    $stats = [];
    
    // Job Categories
    $sql = "SELECT COUNT(*) as count FROM tblcategory";
    $query = $dbh->prepare($sql);
    $query->execute();
    $stats['categories'] = $query->fetch(PDO::FETCH_OBJ)->count;
    
    // Employers
    $sql = "SELECT COUNT(*) as count FROM tblemployers";
    $query = $dbh->prepare($sql);
    $query->execute();
    $stats['employers'] = $query->fetch(PDO::FETCH_OBJ)->count;
    
    // Job Seekers
    $sql = "SELECT COUNT(*) as count FROM tbljobseekers";
    $query = $dbh->prepare($sql);
    $query->execute();
    $stats['jobseekers'] = $query->fetch(PDO::FETCH_OBJ)->count;
    
    // Jobs
    $sql = "SELECT COUNT(*) as count FROM tbljobs";
    $query = $dbh->prepare($sql);
    $query->execute();
    $stats['jobs'] = $query->fetch(PDO::FETCH_OBJ)->count;
    
    // New registrations today
    $sql = "SELECT 
                (SELECT COUNT(*) FROM tblemployers WHERE DATE(RegDtae) = CURDATE()) as new_employers,
                (SELECT COUNT(*) FROM tbljobseekers WHERE DATE(RegDate) = CURDATE()) as new_jobseekers,
                (SELECT COUNT(*) FROM tbljobs WHERE DATE(postinDate) = CURDATE()) as new_jobs,
                (SELECT COUNT(*) FROM tblapplyjob WHERE DATE(Applydate) = CURDATE()) as new_applications";
    $query = $dbh->prepare($sql);
    $query->execute();
    $today_stats = $query->fetch(PDO::FETCH_OBJ);
    
    $stats['today'] = [
        'employers' => $today_stats->new_employers,
        'jobseekers' => $today_stats->new_jobseekers,
        'jobs' => $today_stats->new_jobs,
        'applications' => $today_stats->new_applications
    ];
    
    echo json_encode($stats);
}

/**
 * Get applications chart data for the last 30 days
 */
function getApplicationsChart($dbh) {
    $data = [];
    $labels = [];
    
    for ($i = 29; $i >= 0; $i--) {
        $date = date('Y-m-d', strtotime("-$i days"));
        $label = date('M j', strtotime("-$i days"));
        
        $sql = "SELECT COUNT(*) as count FROM tblapplyjob WHERE DATE(Applydate) = :date";
        $query = $dbh->prepare($sql);
        $query->bindParam(':date', $date);
        $query->execute();
        $count = $query->fetch(PDO::FETCH_OBJ)->count;
        
        $labels[] = $label;
        $data[] = intval($count);
    }
    
    echo json_encode([
        'labels' => $labels,
        'data' => $data
    ]);
}

/**
 * Get jobs by category chart data
 */
function getCategoriesChart($dbh) {
    $sql = "SELECT c.CategoryName, COUNT(j.jobId) as job_count 
            FROM tblcategory c 
            LEFT JOIN tbljobs j ON c.CategoryName = j.jobCategory 
            GROUP BY c.CategoryName 
            ORDER BY job_count DESC 
            LIMIT 8";
    $query = $dbh->prepare($sql);
    $query->execute();
    $results = $query->fetchAll(PDO::FETCH_OBJ);
    
    $labels = [];
    $data = [];
    
    foreach ($results as $row) {
        $labels[] = $row->CategoryName;
        $data[] = intval($row->job_count);
    }
    
    echo json_encode([
        'labels' => $labels,
        'data' => $data
    ]);
}

/**
 * Get application status chart data
 */
function getStatusChart($dbh) {
    $sql = "SELECT 
                (SELECT COUNT(*) FROM tblapplyjob WHERE Status = 'Hired') as hired,
                (SELECT COUNT(*) FROM tblapplyjob WHERE Status IS NULL OR Status = '') as pending,
                (SELECT COUNT(*) FROM tblapplyjob WHERE Status = 'Rejected') as rejected";
    $query = $dbh->prepare($sql);
    $query->execute();
    $result = $query->fetch(PDO::FETCH_OBJ);
    
    echo json_encode([
        'labels' => ['Hired', 'Pending', 'Rejected'],
        'data' => [
            intval($result->hired),
            intval($result->pending),
            intval($result->rejected)
        ]
    ]);
}

/**
 * Get recent activities
 */
function getRecentActivities($dbh) {
    $limit = isset($_GET['limit']) ? intval($_GET['limit']) : 10;
    
    // Get recent job applications
    $sql = "SELECT 
                tbljobseekers.FullName as user_name,
                tbljobs.jobTitle,
                tblemployers.CompnayName as company_name,
                tblapplyjob.Applydate as created_at,
                'application' as activity_type
            FROM tblapplyjob 
            JOIN tbljobseekers ON tbljobseekers.id = tblapplyjob.UserId 
            JOIN tbljobs ON tbljobs.jobId = tblapplyjob.JobId 
            JOIN tblemployers ON tblemployers.id = tbljobs.employerId
            ORDER BY tblapplyjob.Applydate DESC 
            LIMIT :limit";
    
    $query = $dbh->prepare($sql);
    $query->bindParam(':limit', $limit, PDO::PARAM_INT);
    $query->execute();
    $activities = $query->fetchAll(PDO::FETCH_OBJ);
    
    // Format activities
    $formatted_activities = [];
    foreach ($activities as $activity) {
        $formatted_activities[] = [
            'user_name' => $activity->user_name,
            'action' => "applied for {$activity->jobTitle} at {$activity->company_name}",
            'time' => date('M j, Y g:i A', strtotime($activity->created_at)),
            'type' => $activity->activity_type,
            'timestamp' => strtotime($activity->created_at)
        ];
    }
    
    echo json_encode($formatted_activities);
}

/**
 * Get activity statistics from logs
 */
function getActivityStats($dbh) {
    $stats = [];
    
    // Today's activities
    $sql = "SELECT COUNT(*) as count FROM tbl_employer_logs WHERE DATE(created_at) = CURDATE()";
    $query = $dbh->prepare($sql);
    $query->execute();
    $stats['today_activities'] = intval($query->fetch(PDO::FETCH_OBJ)->count ?? 0);
    
    // Active sessions
    $sql = "SELECT COUNT(*) as count FROM tbl_employer_logs WHERE status = 'active'";
    $query = $dbh->prepare($sql);
    $query->execute();
    $stats['active_sessions'] = intval($query->fetch(PDO::FETCH_OBJ)->count ?? 0);
    
    // Average session duration
    $sql = "SELECT AVG(duration_minutes) as avg_duration FROM tbl_employer_logs WHERE duration_minutes IS NOT NULL";
    $query = $dbh->prepare($sql);
    $query->execute();
    $result = $query->fetch(PDO::FETCH_OBJ);
    $stats['avg_duration'] = $result && $result->avg_duration ? round($result->avg_duration) : 0;
    
    // This week's activities
    $sql = "SELECT COUNT(*) as count FROM tbl_employer_logs WHERE created_at >= DATE_SUB(NOW(), INTERVAL 7 DAY)";
    $query = $dbh->prepare($sql);
    $query->execute();
    $stats['week_activities'] = intval($query->fetch(PDO::FETCH_OBJ)->count ?? 0);
    
    echo json_encode($stats);
}

/**
 * Get hourly activity data for today
 */
function getHourlyActivity($dbh) {
    $data = [];
    $labels = [];
    
    for ($hour = 0; $hour < 24; $hour++) {
        $labels[] = sprintf('%02d:00', $hour);
        
        $sql = "SELECT COUNT(*) as count FROM tbl_employer_logs 
                WHERE DATE(created_at) = CURDATE() 
                AND HOUR(created_at) = :hour";
        $query = $dbh->prepare($sql);
        $query->bindParam(':hour', $hour, PDO::PARAM_INT);
        $query->execute();
        $count = $query->fetch(PDO::FETCH_OBJ)->count ?? 0;
        
        $data[] = intval($count);
    }
    
    echo json_encode([
        'labels' => $labels,
        'data' => $data
    ]);
}

/**
 * Get current user sessions
 */
function getUserSessions($dbh) {
    $sql = "SELECT 
                el.company_name,
                el.ip_address,
                el.login_time,
                TIMESTAMPDIFF(MINUTE, el.login_time, NOW()) as duration_minutes,
                el.user_agent
            FROM tbl_employer_logs el
            WHERE el.status = 'active' 
            AND el.action_type = 'login'
            ORDER BY el.login_time DESC";
    
    $query = $dbh->prepare($sql);
    $query->execute();
    $sessions = $query->fetchAll(PDO::FETCH_OBJ);
    
    $formatted_sessions = [];
    foreach ($sessions as $session) {
        // Parse user agent for browser info
        $user_agent = $session->user_agent;
        $browser = 'Unknown';
        if (strpos($user_agent, 'Chrome') !== false) $browser = 'Chrome';
        elseif (strpos($user_agent, 'Firefox') !== false) $browser = 'Firefox';
        elseif (strpos($user_agent, 'Safari') !== false) $browser = 'Safari';
        elseif (strpos($user_agent, 'Edge') !== false) $browser = 'Edge';
        
        $formatted_sessions[] = [
            'company_name' => $session->company_name,
            'ip_address' => $session->ip_address,
            'login_time' => date('M j, Y g:i A', strtotime($session->login_time)),
            'duration' => $session->duration_minutes . ' minutes',
            'browser' => $browser
        ];
    }
    
    echo json_encode($formatted_sessions);
}

/**
 * Enhanced error handling and logging
 */
function logError($message, $context = []) {
    $log_entry = [
        'timestamp' => date('Y-m-d H:i:s'),
        'message' => $message,
        'context' => $context,
        'ip' => $_SERVER['REMOTE_ADDR'] ?? 'unknown',
        'user_agent' => $_SERVER['HTTP_USER_AGENT'] ?? 'unknown'
    ];
    
    error_log('Dashboard API Error: ' . json_encode($log_entry));
}
?>

<!-- New Created File 4 -->