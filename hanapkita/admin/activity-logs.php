<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
if (strlen($_SESSION['jpaid']==0)) {
  header('location:logout.php');
  } else{

// Helper function for time ago
function timeAgo($datetime) {
    $time = time() - strtotime($datetime);
    
    if ($time < 60) return 'just now';
    if ($time < 3600) return floor($time/60) . ' min ago';
    if ($time < 86400) return floor($time/3600) . ' hr ago';
    if ($time < 2592000) return floor($time/86400) . ' days ago';
    if ($time < 31536000) return floor($time/2592000) . ' months ago';
    return floor($time/31536000) . ' years ago';
}

// Pagination setup
$limit = 15;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

// Filter setup
$filter_type = isset($_GET['type']) ? $_GET['type'] : 'all';
$filter_date = isset($_GET['date']) ? $_GET['date'] : '';
$search_term = isset($_GET['search']) ? $_GET['search'] : '';

?>
<!doctype html>
<html lang="en" class="no-focus">
<head>
    <title>Hanap-Kita - Activity Logs</title>
    <link rel="stylesheet" id="css-main" href="assets/css/codebase.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root {
            --primary-orange: #FF6B00;
            --light-orange: #FFE5D1;
            --bg-peach: #FEF7F0;
            --card-white: #FFFFFF;
            --text-dark: #2D3748;
            --text-gray: #718096;
            --text-light: #A0AEC0;
            --success-green: #48BB78;
            --warning-yellow: #F6E05E;
            --danger-red: #F56565;
            --info-blue: #4299E1;
            --shadow-soft: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            --shadow-card: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        }

        * { font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif; }

        body {
            background: linear-gradient(135deg, var(--bg-peach) 0%, #FAF5F0 100%);
            min-height: 100vh;
        }

        .main-content {
            padding: 2rem;
            margin-left: 0;
        }

        .page-header {
            background: var(--card-white);
            border-radius: 20px;
            padding: 2rem;
            margin-bottom: 2rem;
            box-shadow: var(--shadow-card);
            border: 1px solid rgba(255, 107, 0, 0.1);
            position: relative;
            overflow: hidden;
        }

        .page-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, var(--primary-orange), #FF8F42);
            border-radius: 20px 20px 0 0;
        }

        .header-content {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 2rem;
        }

        .header-left h1 {
            font-size: 2rem;
            font-weight: 700;
            color: var(--text-dark);
            margin: 0 0 0.5rem 0;
            background: linear-gradient(135deg, var(--primary-orange), #FF8F42);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .header-left p {
            color: var(--text-gray);
            font-size: 1.1rem;
            margin: 0;
        }

        .header-stats {
            display: flex;
            gap: 1.5rem;
        }

        .stat-box {
            text-align: center;
            background: rgba(255, 107, 0, 0.05);
            border-radius: 12px;
            padding: 1rem;
            min-width: 80px;
        }

        .stat-number {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--primary-orange);
            margin: 0;
        }

        .stat-label {
            font-size: 0.75rem;
            color: var(--text-gray);
            margin: 0;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        /* Filter Section */
        .filters-card {
            background: var(--card-white);
            border-radius: 16px;
            padding: 1.5rem;
            margin-bottom: 2rem;
            box-shadow: var(--shadow-soft);
            border: 1px solid rgba(255, 107, 0, 0.1);
        }

        .filters-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
        }

        .filters-title {
            font-size: 1.125rem;
            font-weight: 600;
            color: var(--text-dark);
            margin: 0;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .filters-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
            align-items: end;
        }

        .filter-group {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }

        .filter-label {
            font-size: 0.875rem;
            font-weight: 500;
            color: var(--text-dark);
            margin: 0;
        }

        .filter-input, .filter-select {
            padding: 0.75rem 1rem;
            border: 2px solid rgba(255, 107, 0, 0.1);
            border-radius: 8px;
            background: var(--card-white);
            font-size: 0.875rem;
            transition: all 0.3s ease;
        }

        .filter-input:focus, .filter-select:focus {
            outline: none;
            border-color: var(--primary-orange);
            box-shadow: 0 0 0 3px rgba(255, 107, 0, 0.1);
        }

        .filter-btn {
            padding: 0.75rem 1.5rem;
            border: none;
            border-radius: 8px;
            font-size: 0.875rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            text-decoration: none;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary-orange), #FF8F42);
            color: white;
            box-shadow: 0 2px 8px rgba(255, 107, 0, 0.3);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(255, 107, 0, 0.4);
            color: white;
            text-decoration: none;
        }

        .btn-secondary {
            background: rgba(255, 107, 0, 0.1);
            color: var(--primary-orange);
            border: 1px solid rgba(255, 107, 0, 0.2);
        }

        .btn-secondary:hover {
            background: rgba(255, 107, 0, 0.2);
            color: var(--primary-orange);
            text-decoration: none;
        }

        /* Activity Logs */
        .logs-card {
            background: var(--card-white);
            border-radius: 20px;
            padding: 2rem;
            box-shadow: var(--shadow-card);
            border: 1px solid rgba(255, 107, 0, 0.1);
        }

        .logs-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
            padding-bottom: 1rem;
            border-bottom: 2px solid rgba(255, 107, 0, 0.1);
        }

        .logs-title {
            font-size: 1.5rem;
            font-weight: 600;
            color: var(--text-dark);
            margin: 0;
        }

        .activity-list {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .activity-item {
            display: flex;
            align-items: flex-start;
            gap: 1rem;
            padding: 1.5rem;
            background: rgba(255, 107, 0, 0.02);
            border: 1px solid rgba(255, 107, 0, 0.1);
            border-radius: 12px;
            transition: all 0.3s ease;
        }

        .activity-item:hover {
            background: rgba(255, 107, 0, 0.05);
            transform: translateY(-1px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05);
        }

        .activity-icon {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            flex-shrink: 0;
            color: white;
        }

        .activity-icon.application { background: linear-gradient(135deg, var(--primary-orange), #FF8F42); }
        .activity-icon.register { background: linear-gradient(135deg, var(--info-blue), #3182CE); }
        .activity-icon.job { background: linear-gradient(135deg, var(--warning-yellow), #D69E2E); }
        .activity-icon.message { background: linear-gradient(135deg, var(--success-green), #38A169); }

        .activity-content {
            flex: 1;
            min-width: 0;
        }

        .activity-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 0.5rem;
        }

        .activity-title {
            font-size: 1rem;
            font-weight: 600;
            color: var(--text-dark);
            margin: 0;
            line-height: 1.4;
        }

        .activity-time {
            font-size: 0.75rem;
            color: var(--text-gray);
            white-space: nowrap;
            background: rgba(255, 107, 0, 0.1);
            padding: 0.25rem 0.5rem;
            border-radius: 6px;
        }

        .activity-description {
            font-size: 0.875rem;
            color: var(--text-gray);
            margin: 0;
            line-height: 1.5;
        }

        .activity-meta {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-top: 0.75rem;
            font-size: 0.75rem;
            color: var(--text-light);
        }

        .activity-meta span {
            display: flex;
            align-items: center;
            gap: 0.25rem;
        }

        /* Pagination */
        .pagination-card {
            background: var(--card-white);
            border-radius: 12px;
            padding: 1rem;
            margin-top: 2rem;
            box-shadow: var(--shadow-soft);
            border: 1px solid rgba(255, 107, 0, 0.1);
            display: flex;
            justify-content: center;
        }

        .pagination {
            display: flex;
            gap: 0.5rem;
            align-items: center;
        }

        .page-btn {
            padding: 0.5rem 0.75rem;
            border: 1px solid rgba(255, 107, 0, 0.2);
            border-radius: 6px;
            background: var(--card-white);
            color: var(--text-dark);
            text-decoration: none;
            font-size: 0.875rem;
            transition: all 0.3s ease;
        }

        .page-btn:hover, .page-btn.active {
            background: var(--primary-orange);
            color: white;
            text-decoration: none;
        }

        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 3rem 2rem;
            color: var(--text-gray);
        }

        .empty-state i {
            font-size: 3rem;
            color: var(--text-light);
            margin-bottom: 1rem;
        }

        .empty-state h3 {
            font-size: 1.25rem;
            font-weight: 600;
            color: var(--text-dark);
            margin: 0 0 0.5rem 0;
        }

        .empty-state p {
            margin: 0;
            font-size: 0.875rem;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .main-content { padding: 1rem; }
            .header-content { flex-direction: column; gap: 1rem; }
            .header-stats { flex-wrap: wrap; }
            .filters-grid { grid-template-columns: 1fr; }
            .activity-item { flex-direction: column; gap: 0.75rem; }
            .activity-header { flex-direction: column; gap: 0.5rem; align-items: flex-start; }
        }
    </style>
</head>
<body>
    <div id="page-container" class="sidebar-o sidebar-inverse side-scroll page-header-fixed main-content-narrow">
        <?php include_once('includes/sidebar.php');?>
        <?php include_once('includes/header.php');?>

        <main id="main-container">
            <div class="content main-content">
                <!-- Page Header -->
                <div class="page-header">
                    <div class="header-content">
                        <div class="header-left">
                            <h1>Activity Logs</h1>
                            <p>Monitor system activities and user interactions across the platform</p>
                        </div>
                        <div class="header-stats">
                            <div class="stat-box">
                                <p class="stat-number">
                                    <?php
                                    $sql_today = "SELECT COUNT(*) as count FROM tblapplyjob WHERE DATE(Applydate) = CURDATE()";
                                    $query_today = $dbh->prepare($sql_today);
                                    $query_today->execute();
                                    $result_today = $query_today->fetch(PDO::FETCH_OBJ);
                                    echo $result_today ? $result_today->count : 0;
                                    ?>
                                </p>
                                <p class="stat-label">Today</p>
                            </div>
                            <div class="stat-box">
                                <p class="stat-number">
                                    <?php
                                    $sql_week = "SELECT COUNT(*) as count FROM tblapplyjob WHERE DATE(Applydate) >= DATE_SUB(CURDATE(), INTERVAL 7 DAY)";
                                    $query_week = $dbh->prepare($sql_week);
                                    $query_week->execute();
                                    $result_week = $query_week->fetch(PDO::FETCH_OBJ);
                                    echo $result_week ? $result_week->count : 0;
                                    ?>
                                </p>
                                <p class="stat-label">This Week</p>
                            </div>
                            <div class="stat-box">
                                <p class="stat-number">
                                    <?php
                                    $sql_total = "SELECT COUNT(*) as count FROM tblapplyjob";
                                    $query_total = $dbh->prepare($sql_total);
                                    $query_total->execute();
                                    $result_total = $query_total->fetch(PDO::FETCH_OBJ);
                                    echo $result_total ? $result_total->count : 0;
                                    ?>
                                </p>
                                <p class="stat-label">Total</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Filters -->
                <div class="filters-card">
                    <div class="filters-header">
                        <h3 class="filters-title">
                            <i class="fas fa-filter"></i>
                            Filter Activities
                        </h3>
                    </div>
                    <form method="GET" class="filters-grid">
                        <div class="filter-group">
                            <label class="filter-label">Activity Type</label>
                            <select name="type" class="filter-select">
                                <option value="all" <?php echo ($filter_type == 'all') ? 'selected' : ''; ?>>All Activities</option>
                                <option value="applications" <?php echo ($filter_type == 'applications') ? 'selected' : ''; ?>>Job Applications</option>
                                <option value="registrations" <?php echo ($filter_type == 'registrations') ? 'selected' : ''; ?>>User Registrations</option>
                                <option value="jobs" <?php echo ($filter_type == 'jobs') ? 'selected' : ''; ?>>Job Postings</option>
                                <option value="messages" <?php echo ($filter_type == 'messages') ? 'selected' : ''; ?>>Messages</option>
                            </select>
                        </div>
                        <div class="filter-group">
                            <label class="filter-label">Date</label>
                            <input type="date" name="date" class="filter-input" value="<?php echo htmlentities($filter_date); ?>">
                        </div>
                        <div class="filter-group">
                            <label class="filter-label">Search</label>
                            <input type="text" name="search" class="filter-input" placeholder="Search activities..." value="<?php echo htmlentities($search_term); ?>">
                        </div>
                        <div class="filter-group">
                            <button type="submit" class="filter-btn btn-primary">
                                <i class="fas fa-search"></i>
                                Filter
                            </button>
                        </div>
                        <div class="filter-group">
                            <a href="activity-logs.php" class="filter-btn btn-secondary">
                                <i class="fas fa-times"></i>
                                Clear
                            </a>
                        </div>
                    </form>
                </div>

                <!-- Activity Logs -->
                <div class="logs-card">
                    <div class="logs-header">
                        <h2 class="logs-title">Recent Activities</h2>
                        <button onclick="window.location.reload()" class="filter-btn btn-secondary">
                            <i class="fas fa-sync-alt"></i>
                            Refresh
                        </button>
                    </div>

                    <div class="activity-list">
                        <?php
                        $activities = [];

                        // Get Job Applications (always show some unless filtered)
                        if ($filter_type == 'all' || $filter_type == 'applications') {
                            $where_apps = [];
                            if ($filter_date) {
                                $where_apps[] = "DATE(a.Applydate) = '$filter_date'";
                            }
                            if ($search_term) {
                                $where_apps[] = "(js.FullName LIKE '%$search_term%' OR j.jobTitle LIKE '%$search_term%' OR e.CompnayName LIKE '%$search_term%')";
                            }
                            $where_clause_apps = !empty($where_apps) ? 'WHERE ' . implode(' AND ', $where_apps) : '';

                            $sql_applications = "SELECT 
                                'application' as activity_type,
                                CONCAT(js.FullName, ' applied for \"', j.jobTitle, '\" at ', e.CompnayName) as description,
                                js.FullName as user_name,
                                a.Applydate as activity_date,
                                a.Status as status,
                                j.jobTitle as job_title,
                                e.CompnayName as company_name
                            FROM tblapplyjob a
                            JOIN tbljobseekers js ON js.id = a.UserId
                            JOIN tbljobs j ON j.jobId = a.JobId
                            JOIN tblemployers e ON e.id = j.employerId
                            $where_clause_apps
                            ORDER BY a.Applydate DESC
                            LIMIT 10";

                            $query_applications = $dbh->prepare($sql_applications);
                            $query_applications->execute();
                            $app_results = $query_applications->fetchAll(PDO::FETCH_ASSOC);
                            $activities = array_merge($activities, $app_results);
                        }

                        // Get Job Seeker Registrations
                        if ($filter_type == 'all' || $filter_type == 'registrations') {
                            $where_js = [];
                            if ($filter_date) {
                                $where_js[] = "DATE(RegDate) = '$filter_date'";
                            }
                            if ($search_term) {
                                $where_js[] = "(FullName LIKE '%$search_term%' OR EmailId LIKE '%$search_term%')";
                            }
                            $where_clause_js = !empty($where_js) ? 'WHERE ' . implode(' AND ', $where_js) : '';

                            $sql_jobseekers = "SELECT 
                                'register' as activity_type,
                                CONCAT('New job seeker registered: ', FullName) as description,
                                FullName as user_name,
                                RegDate as activity_date,
                                'Active' as status,
                                EmailId as email
                            FROM tbljobseekers
                            $where_clause_js
                            ORDER BY RegDate DESC
                            LIMIT 8";

                            $query_jobseekers = $dbh->prepare($sql_jobseekers);
                            $query_jobseekers->execute();
                            $js_results = $query_jobseekers->fetchAll(PDO::FETCH_ASSOC);
                            $activities = array_merge($activities, $js_results);
                        }

                        // Get Employer Registrations
                        if ($filter_type == 'all' || $filter_type == 'registrations') {
                            $where_emp = [];
                            if ($filter_date) {
                                $where_emp[] = "DATE(RegDtae) = '$filter_date'";
                            }
                            if ($search_term) {
                                $where_emp[] = "(CompnayName LIKE '%$search_term%' OR ConcernPerson LIKE '%$search_term%')";
                            }
                            $where_clause_emp = !empty($where_emp) ? 'WHERE ' . implode(' AND ', $where_emp) : '';

                            $sql_employers = "SELECT 
                                'register' as activity_type,
                                CONCAT('New employer registered: ', CompnayName) as description,
                                ConcernPerson as user_name,
                                RegDtae as activity_date,
                                'Active' as status,
                                CompnayName as company_name
                            FROM tblemployers
                            $where_clause_emp
                            ORDER BY RegDtae DESC
                            LIMIT 8";

                            $query_employers = $dbh->prepare($sql_employers);
                            $query_employers->execute();
                            $emp_results = $query_employers->fetchAll(PDO::FETCH_ASSOC);
                            $activities = array_merge($activities, $emp_results);
                        }

                        // Get Job Postings
                        if ($filter_type == 'all' || $filter_type == 'jobs') {
                            $where_jobs = [];
                            if ($filter_date) {
                                $where_jobs[] = "DATE(j.postinDate) = '$filter_date'";
                            }
                            if ($search_term) {
                                $where_jobs[] = "(j.jobTitle LIKE '%$search_term%' OR e.CompnayName LIKE '%$search_term%')";
                            }
                            $where_clause_jobs = !empty($where_jobs) ? 'WHERE ' . implode(' AND ', $where_jobs) : '';

                            $sql_jobs = "SELECT 
                                'job' as activity_type,
                                CONCAT('New job posted: \"', j.jobTitle, '\" by ', e.CompnayName) as description,
                                e.ConcernPerson as user_name,
                                j.postinDate as activity_date,
                                'Posted' as status,
                                j.jobTitle as job_title,
                                e.CompnayName as company_name
                            FROM tbljobs j
                            JOIN tblemployers e ON e.id = j.employerId
                            $where_clause_jobs
                            ORDER BY j.postinDate DESC
                            LIMIT 8";

                            $query_jobs = $dbh->prepare($sql_jobs);
                            $query_jobs->execute();
                            $job_results = $query_jobs->fetchAll(PDO::FETCH_ASSOC);
                            $activities = array_merge($activities, $job_results);
                        }

                        // Get Messages (Response messages)
                        if ($filter_type == 'all' || $filter_type == 'messages') {
                            $where_msg = [];
                            if ($filter_date) {
                                $where_msg[] = "DATE(m.ResponseDate) = '$filter_date'";
                            }
                            if ($search_term) {
                                $where_msg[] = "(m.Message LIKE '%$search_term%' OR js.FullName LIKE '%$search_term%')";
                            }
                            $where_clause_msg = !empty($where_msg) ? 'WHERE ' . implode(' AND ', $where_msg) : '';

                            $sql_messages = "SELECT 
                                'message' as activity_type,
                                CONCAT('Message sent to ', js.FullName, ': ', LEFT(m.Message, 50), '...') as description,
                                'Admin' as user_name,
                                m.ResponseDate as activity_date,
                                m.Status as status,
                                js.FullName as recipient_name
                            FROM tblmessage m
                            JOIN tbljobseekers js ON js.id = m.UserID
                            $where_clause_msg
                            ORDER BY m.ResponseDate DESC
                            LIMIT 5";

                            $query_messages = $dbh->prepare($sql_messages);
                            $query_messages->execute();
                            $msg_results = $query_messages->fetchAll(PDO::FETCH_ASSOC);
                            $activities = array_merge($activities, $msg_results);
                        }

                        // Sort all activities by date
                        if (!empty($activities)) {
                            usort($activities, function($a, $b) {
                                return strtotime($b['activity_date']) - strtotime($a['activity_date']);
                            });

                            // Limit to pagination
                            $activities = array_slice($activities, $offset, $limit);
                        }

                        if (empty($activities)) {
                        ?>
                            <div class="empty-state">
                                <i class="fas fa-history"></i>
                                <h3>No activities found</h3>
                                <p>No activities match your current filters. Try adjusting your search criteria.</p>
                            </div>
                        <?php
                        } else {
                            foreach ($activities as $activity) {
                                $icon_class = $activity['activity_type'];
                                
                                // Determine icon based on activity type
                                switch($activity['activity_type']) {
                                    case 'application':
                                        $icon_name = 'file-alt';
                                        break;
                                    case 'register':
                                        $icon_name = isset($activity['company_name']) ? 'building' : 'user-plus';
                                        break;
                                    case 'job':
                                        $icon_name = 'briefcase';
                                        break;
                                    case 'message':
                                        $icon_name = 'envelope';
                                        break;
                                    default:
                                        $icon_name = 'circle';
                                }
                        ?>
                        <div class="activity-item">
                            <div class="activity-icon <?php echo $icon_class; ?>">
                                <i class="fas fa-<?php echo $icon_name; ?>"></i>
                            </div>
                            <div class="activity-content">
                                <div class="activity-header">
                                    <h4 class="activity-title"><?php echo htmlentities($activity['description']); ?></h4>
                                    <span class="activity-time">
                                        <?php echo date('M j, Y g:i A', strtotime($activity['activity_date'])); ?>
                                    </span>
                                </div>
                                <p class="activity-description">
                                    User: <strong><?php echo htmlentities($activity['user_name']); ?></strong>
                                    <?php if (isset($activity['status']) && $activity['status']): ?>
                                        • Status: <span style="color: var(--primary-orange);"><?php echo ucfirst(htmlentities($activity['status'])); ?></span>
                                    <?php endif; ?>
                                </p>
                                <div class="activity-meta">
                                    <span><i class="fas fa-clock"></i> <?php echo timeAgo($activity['activity_date']); ?></span>
                                    <span><i class="fas fa-tag"></i> <?php echo ucfirst($activity['activity_type']); ?></span>
                                    <?php if (isset($activity['company_name'])): ?>
                                        <span><i class="fas fa-building"></i> <?php echo htmlentities($activity['company_name']); ?></span>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                        <?php
                            }
                        }
                        ?>
                    </div>
                </div>

                <!-- Simple Pagination -->
                <div class="pagination-card">
                    <div class="pagination">
                        <?php
                        $query_string = http_build_query(array_filter([
                            'type' => $filter_type !== 'all' ? $filter_type : null,
                            'date' => $filter_date,
                            'search' => $search_term
                        ]));
                        $query_string = $query_string ? '&' . $query_string : '';

                        if ($page > 1): ?>
                            <a href="?page=<?php echo $page-1; ?><?php echo $query_string; ?>" class="page-btn">
                                <i class="fas fa-chevron-left"></i> Previous
                            </a>
                        <?php endif; ?>

                        <span class="page-btn active"><?php echo $page; ?></span>

                        <?php if (count($activities) == $limit): ?>
                            <a href="?page=<?php echo $page+1; ?><?php echo $query_string; ?>" class="page-btn">
                                Next <i class="fas fa-chevron-right"></i>
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </main>

        <?php include_once('includes/footer.php');?>
    </div>

    <!-- Scripts -->
    <script src="assets/js/core/jquery.min.js"></script>
    <script src="assets/js/core/popper.min.js"></script>
    <script src="assets/js/core/bootstrap.min.js"></script>
    <script src="assets/js/core/jquery.slimscroll.min.js"></script>
    <script src="assets/js/core/jquery.scrollLock.min.js"></script>
    <script src="assets/js/core/jquery.appear.min.js"></script>
    <script src="assets/js/core/jquery.countTo.min.js"></script>
    <script src="assets/js/core/js.cookie.min.js"></script>
    <script src="assets/js/codebase.js"></script>

    <script>
        // Auto-refresh functionality
        setInterval(function() {
            if (document.hasFocus() && !window.location.search) {
                // Only refresh if no filters are applied and page is focused
                console.log('Auto-refresh check...');
            }
        }, 60000); // Check every minute

        // Real-time clock update
        function updateClock() {
            const timeElements = document.querySelectorAll('.activity-time');
            // Update relative times every minute
        }
        setInterval(updateClock, 60000);
    </script>
</body>
</html>
<?php }  ?>

<!-- Done 3-->