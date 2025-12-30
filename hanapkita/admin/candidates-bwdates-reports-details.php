<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
if (strlen($_SESSION['jpaid']==0)) {
  header('location:logout.php');
  } else{

// Get date parameters
$fdate = isset($_POST['fromdate']) ? $_POST['fromdate'] : '';
$tdate = isset($_POST['todate']) ? $_POST['todate'] : '';

// Pagination setup
$limit = 15;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

// Additional filters
$search_term = isset($_GET['search']) ? $_GET['search'] : '';
$status_filter = isset($_GET['status']) ? $_GET['status'] : 'all';

?>
<!doctype html>
<html lang="en" class="no-focus">
<head>
    <title>Hanap-Kita - Candidates Between Dates Report</title>
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
            --info-blue: #4299E1;
            --warning-yellow: #F6E05E;
            --danger-red: #F56565;
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

        .header-left {
            display: flex;
            align-items: center;
            gap: 1.5rem;
        }

        .header-icon {
            width: 64px;
            height: 64px;
            border-radius: 16px;
            background: linear-gradient(135deg, var(--primary-orange), #FF8F42);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            box-shadow: 0 8px 20px rgba(255, 107, 0, 0.3);
        }

        .header-text h1 {
            font-size: 2rem;
            font-weight: 700;
            color: var(--text-dark);
            margin: 0 0 0.5rem 0;
            background: linear-gradient(135deg, var(--primary-orange), #FF8F42);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .header-text p {
            color: var(--text-gray);
            font-size: 1.1rem;
            margin: 0;
        }

        .date-range-badge {
            background: linear-gradient(135deg, rgba(255, 107, 0, 0.1), rgba(255, 107, 0, 0.05));
            border: 2px solid rgba(255, 107, 0, 0.2);
            border-radius: 12px;
            padding: 1rem 1.5rem;
            text-align: center;
            box-shadow: 0 4px 8px rgba(255, 107, 0, 0.1);
        }

        .date-range-title {
            font-size: 0.75rem;
            font-weight: 600;
            color: var(--primary-orange);
            margin: 0 0 0.25rem 0;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .date-range-text {
            font-size: 1rem;
            font-weight: 600;
            color: var(--text-dark);
            margin: 0;
        }

        /* Statistics Cards */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .stat-card {
            background: var(--card-white);
            border-radius: 16px;
            padding: 1.5rem;
            box-shadow: var(--shadow-soft);
            border: 1px solid rgba(255, 107, 0, 0.1);
            display: flex;
            align-items: center;
            gap: 1rem;
            transition: all 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-card);
        }

        .stat-icon {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            color: white;
            flex-shrink: 0;
        }

        .stat-icon.total { background: linear-gradient(135deg, var(--primary-orange), #FF8F42); }
        .stat-icon.active { background: linear-gradient(135deg, var(--success-green), #38A169); }
        .stat-icon.inactive { background: linear-gradient(135deg, var(--text-gray), #4A5568); }
        .stat-icon.recent { background: linear-gradient(135deg, var(--info-blue), #3182CE); }

        .stat-content h3 {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--text-dark);
            margin: 0;
            line-height: 1.2;
        }

        .stat-content p {
            font-size: 0.875rem;
            color: var(--text-gray);
            margin: 0;
        }

        /* Filters Section */
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
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
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

        .btn-success {
            background: linear-gradient(135deg, var(--success-green), #38A169);
            color: white;
            box-shadow: 0 2px 8px rgba(72, 187, 120, 0.3);
        }

        .btn-success:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(72, 187, 120, 0.4);
            color: white;
            text-decoration: none;
        }

        /* Candidates List */
        .candidates-card {
            background: var(--card-white);
            border-radius: 20px;
            padding: 2rem;
            box-shadow: var(--shadow-card);
            border: 1px solid rgba(255, 107, 0, 0.1);
        }

        .candidates-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
            padding-bottom: 1rem;
            border-bottom: 2px solid rgba(255, 107, 0, 0.1);
        }

        .candidates-title {
            font-size: 1.5rem;
            font-weight: 600;
            color: var(--text-dark);
            margin: 0;
        }

        .view-toggle {
            display: flex;
            gap: 0.5rem;
            background: rgba(255, 107, 0, 0.1);
            border-radius: 8px;
            padding: 0.25rem;
        }

        .view-btn {
            padding: 0.5rem 0.75rem;
            border: none;
            border-radius: 6px;
            background: transparent;
            color: var(--text-gray);
            cursor: pointer;
            transition: all 0.3s ease;
            font-size: 0.875rem;
        }

        .view-btn.active {
            background: var(--primary-orange);
            color: white;
            box-shadow: 0 2px 4px rgba(255, 107, 0, 0.3);
        }

        /* Cards View */
        .candidates-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
            gap: 1.5rem;
        }

        .candidate-card {
            background: rgba(255, 107, 0, 0.02);
            border: 1px solid rgba(255, 107, 0, 0.1);
            border-radius: 16px;
            padding: 1.5rem;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .candidate-card:hover {
            background: rgba(255, 107, 0, 0.05);
            transform: translateY(-4px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
        }

        .candidate-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: linear-gradient(90deg, var(--primary-orange), #FF8F42);
        }

        .candidate-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 1rem;
        }

        .candidate-avatar {
            width: 48px;
            height: 48px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--primary-orange), #FF8F42);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.125rem;
            font-weight: 700;
            color: white;
            margin-right: 1rem;
            flex-shrink: 0;
        }

        .candidate-info {
            flex: 1;
        }

        .candidate-name {
            font-size: 1.125rem;
            font-weight: 600;
            color: var(--text-dark);
            margin: 0 0 0.25rem 0;
            line-height: 1.3;
        }

        .candidate-email {
            font-size: 0.875rem;
            color: var(--text-gray);
            margin: 0;
        }

        .status-badge {
            padding: 0.25rem 0.75rem;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .status-active { background: rgba(72, 187, 120, 0.1); color: var(--success-green); }
        .status-inactive { background: rgba(113, 128, 150, 0.1); color: var(--text-gray); }

        .candidate-details {
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
            margin-bottom: 1rem;
        }

        .candidate-detail-row {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.875rem;
            color: var(--text-gray);
        }

        .candidate-detail-row i {
            color: var(--primary-orange);
            width: 16px;
            text-align: center;
        }

        .candidate-actions {
            display: flex;
            gap: 0.75rem;
            padding-top: 1rem;
            border-top: 1px solid rgba(255, 107, 0, 0.1);
        }

        .action-btn-small {
            padding: 0.5rem 1rem;
            border-radius: 8px;
            font-size: 0.75rem;
            font-weight: 500;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            transition: all 0.3s ease;
            flex: 1;
            justify-content: center;
        }

        /* Table View */
        .candidates-table-container {
            overflow-x: auto;
            border-radius: 12px;
            border: 1px solid rgba(255, 107, 0, 0.1);
        }

        .candidates-table {
            width: 100%;
            border-collapse: collapse;
            background: var(--card-white);
        }

        .candidates-table th {
            background: linear-gradient(135deg, rgba(255, 107, 0, 0.1), rgba(255, 107, 0, 0.05));
            color: var(--text-dark);
            font-weight: 600;
            padding: 1rem;
            text-align: left;
            font-size: 0.875rem;
            border-bottom: 2px solid rgba(255, 107, 0, 0.1);
        }

        .candidates-table td {
            padding: 1rem;
            border-bottom: 1px solid rgba(255, 107, 0, 0.05);
            font-size: 0.875rem;
            vertical-align: middle;
        }

        .candidates-table tr:hover {
            background: rgba(255, 107, 0, 0.02);
        }

        .name-cell {
            font-weight: 600;
            color: var(--text-dark);
        }

        .contact-cell {
            color: var(--text-gray);
        }

        .email-cell {
            color: var(--info-blue);
        }

        .date-cell {
            color: var(--text-gray);
            font-size: 0.8rem;
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
            justify-content: space-between;
            align-items: center;
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

        .pagination-info {
            font-size: 0.875rem;
            color: var(--text-gray);
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

        /* Export Section */
        .export-section {
            background: rgba(72, 187, 120, 0.05);
            border: 1px solid rgba(72, 187, 120, 0.2);
            border-radius: 12px;
            padding: 1rem;
            margin-bottom: 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .export-info {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .export-icon {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            background: var(--success-green);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
        }

        .export-text h4 {
            font-size: 1rem;
            font-weight: 600;
            color: var(--text-dark);
            margin: 0;
        }

        .export-text p {
            font-size: 0.875rem;
            color: var(--text-gray);
            margin: 0;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .main-content { padding: 1rem; }
            .header-content { flex-direction: column; gap: 1rem; }
            .filters-grid { grid-template-columns: 1fr; }
            .candidates-grid { grid-template-columns: 1fr; }
            .view-toggle { display: none; }
            .pagination-card { flex-direction: column; gap: 1rem; }
            .export-section { flex-direction: column; gap: 1rem; text-align: center; }
        }

        @media (max-width: 480px) {
            .candidate-card { padding: 1rem; }
            .candidates-table-container { font-size: 0.8rem; }
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
                            <div class="header-icon">
                                <i class="fas fa-chart-line"></i>
                            </div>
                            <div class="header-text">
                                <h1>Candidates Between Dates Report</h1>
                                <p>Comprehensive analysis of job seeker registrations within specified date range</p>
                            </div>
                        </div>
                        <?php if ($fdate && $tdate): ?>
                        <div class="date-range-badge">
                            <p class="date-range-title">Report Period</p>
                            <p class="date-range-text">
                                <?php echo date('M j, Y', strtotime($fdate)); ?> - <?php echo date('M j, Y', strtotime($tdate)); ?>
                            </p>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>

                <?php if ($fdate && $tdate): ?>
                
                <!-- Statistics Cards -->
                <div class="stats-grid">
                    <?php
                    // Get statistics for the date range
                    $sql_total = "SELECT COUNT(*) as count FROM tbljobseekers WHERE date(RegDate) between '$fdate' and '$tdate'";
                    $query_total = $dbh->prepare($sql_total);
                    $query_total->execute();
                    $total_candidates = $query_total->fetch(PDO::FETCH_OBJ)->count;

                    $sql_active = "SELECT COUNT(*) as count FROM tbljobseekers WHERE date(RegDate) between '$fdate' and '$tdate' AND IsActive = 1";
                    $query_active = $dbh->prepare($sql_active);
                    $query_active->execute();
                    $active_candidates = $query_active->fetch(PDO::FETCH_OBJ)->count;

                    $sql_inactive = "SELECT COUNT(*) as count FROM tbljobseekers WHERE date(RegDate) between '$fdate' and '$tdate' AND (IsActive = 0 OR IsActive IS NULL)";
                    $query_inactive = $dbh->prepare($sql_inactive);
                    $query_inactive->execute();
                    $inactive_candidates = $query_inactive->fetch(PDO::FETCH_OBJ)->count;

                    $sql_recent = "SELECT COUNT(*) as count FROM tbljobseekers WHERE date(RegDate) between '$fdate' and '$tdate' AND date(RegDate) >= DATE_SUB(CURDATE(), INTERVAL 7 DAY)";
                    $query_recent = $dbh->prepare($sql_recent);
                    $query_recent->execute();
                    $recent_candidates = $query_recent->fetch(PDO::FETCH_OBJ)->count;
                    ?>
                    
                    <div class="stat-card">
                        <div class="stat-icon total">
                            <i class="fas fa-users"></i>
                        </div>
                        <div class="stat-content">
                            <h3><?php echo $total_candidates; ?></h3>
                            <p>Total Registrations</p>
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon active">
                            <i class="fas fa-user-check"></i>
                        </div>
                        <div class="stat-content">
                            <h3><?php echo $active_candidates; ?></h3>
                            <p>Active Candidates</p>
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon inactive">
                            <i class="fas fa-user-times"></i>
                        </div>
                        <div class="stat-content">
                            <h3><?php echo $inactive_candidates; ?></h3>
                            <p>Inactive Candidates</p>
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon recent">
                            <i class="fas fa-user-plus"></i>
                        </div>
                        <div class="stat-content">
                            <h3><?php echo $recent_candidates; ?></h3>
                            <p>Recent (Last 7 Days)</p>
                        </div>
                    </div>
                </div>

                <!-- Export Section -->
                <?php if ($total_candidates > 0): ?>
                <div class="export-section">
                    <div class="export-info">
                        <div class="export-icon">
                            <i class="fas fa-download"></i>
                        </div>
                        <div class="export-text">
                            <h4>Export Report Data</h4>
                            <p>Download this report in various formats for further analysis</p>
                        </div>
                    </div>
                    <div style="display: flex; gap: 0.75rem;">
                        <!--<button onclick="exportToPDF()" class="filter-btn btn-success">
                            <i class="fas fa-file-pdf"></i>
                            Export PDF
                        </button>-->
                        <button onclick="exportToExcel()" class="filter-btn btn-secondary">
                            <i class="fas fa-file-excel"></i>
                            Export Excel
                        </button>
                        <button onclick="window.print()" class="filter-btn btn-secondary">
                            <i class="fas fa-print"></i>
                            Print
                        </button>
                    </div>
                </div>
                <?php endif; ?>

                <!-- Filters -->
                <div class="filters-card">
                    <div class="filters-header">
                        <h3 class="filters-title">
                            <i class="fas fa-filter"></i>
                            Additional Filters
                        </h3>
                    </div>
                    <form method="GET" class="filters-grid">
                        <input type="hidden" name="fdate" value="<?php echo htmlentities($fdate); ?>">
                        <input type="hidden" name="tdate" value="<?php echo htmlentities($tdate); ?>">
                        <div class="filter-group">
                            <label class="filter-label">Search Candidates</label>
                            <input type="text" name="search" class="filter-input" placeholder="Search by name, email..." value="<?php echo htmlentities($search_term); ?>">
                        </div>
                        <div class="filter-group">
                            <label class="filter-label">Status Filter</label>
                            <select name="status" class="filter-select">
                                <option value="all" <?php echo ($status_filter == 'all') ? 'selected' : ''; ?>>All Status</option>
                                <option value="active" <?php echo ($status_filter == 'active') ? 'selected' : ''; ?>>Active Only</option>
                                <option value="inactive" <?php echo ($status_filter == 'inactive') ? 'selected' : ''; ?>>Inactive Only</option>
                            </select>
                        </div>
                        <div class="filter-group">
                            <button type="submit" class="filter-btn btn-primary">
                                <i class="fas fa-search"></i>
                                Apply Filters
                            </button>
                        </div>
                        <div class="filter-group">
                            <a href="?fdate=<?php echo $fdate; ?>&tdate=<?php echo $tdate; ?>" class="filter-btn btn-secondary">
                                <i class="fas fa-times"></i>
                                Clear Filters
                            </a>
                        </div>
                    </form>
                </div>

                <!-- Candidates List -->
                <div class="candidates-card">
                    <div class="candidates-header">
                        <h2 class="candidates-title">
                            Registered Candidates 
                            <?php if ($total_candidates > 0): ?>
                                <span style="color: var(--primary-orange); font-size: 1rem;">(<?php echo $total_candidates; ?> found)</span>
                            <?php endif; ?>
                        </h2>
                        <div class="view-toggle">
                            <button type="button" class="view-btn active" onclick="switchView('cards')" id="cardsBtn">
                                <i class="fas fa-th-large"></i> Cards
                            </button>
                            <button type="button" class="view-btn" onclick="switchView('table')" id="tableBtn">
                                <i class="fas fa-table"></i> Table
                            </button>
                        </div>
                    </div>

                    <?php
                    // Build additional filters
                    $additional_where = [];
                    if ($search_term) {
                        $additional_where[] = "(FullName LIKE '%$search_term%' OR EmailId LIKE '%$search_term%' OR ContactNumber LIKE '%$search_term%')";
                    }
                    if ($status_filter == 'active') {
                        $additional_where[] = "IsActive = 1";
                    } elseif ($status_filter == 'inactive') {
                        $additional_where[] = "(IsActive = 0 OR IsActive IS NULL)";
                    }
                    
                    $additional_clause = !empty($additional_where) ? ' AND ' . implode(' AND ', $additional_where) : '';

                    // Get candidates data
                    $sql = "SELECT * FROM tbljobseekers WHERE date(RegDate) between '$fdate' and '$tdate' $additional_clause ORDER BY RegDate DESC LIMIT $limit OFFSET $offset";
                    $query = $dbh->prepare($sql);
                    $query->execute();
                    $results = $query->fetchAll(PDO::FETCH_OBJ);

                    if(empty($results)) {
                    ?>
                        <div class="empty-state">
                            <i class="fas fa-users"></i>
                            <h3>No candidates found</h3>
                            <p>No candidates registered between <?php echo date('M j, Y', strtotime($fdate)); ?> and <?php echo date('M j, Y', strtotime($tdate)); ?> match your current filters.</p>
                        </div>
                    <?php
                    } else {
                    ?>

                    <!-- Cards View -->
                    <div class="candidates-grid" id="cardsView">
                        <?php
                        foreach($results as $row) {
                            $status_class = ($row->IsActive == 1) ? 'status-active' : 'status-inactive';
                            $status_text = ($row->IsActive == 1) ? 'Active' : 'Inactive';
                        ?>
                        <div class="candidate-card">
                            <div class="candidate-header">
                                <div style="display: flex; align-items: center;">
                                    <div class="candidate-avatar">
                                        <?php echo strtoupper(substr($row->FullName, 0, 2)); ?>
                                    </div>
                                    <div class="candidate-info">
                                        <h3 class="candidate-name"><?php echo htmlentities($row->FullName); ?></h3>
                                        <p class="candidate-email"><?php echo htmlentities($row->EmailId); ?></p>
                                    </div>
                                </div>
                                <span class="status-badge <?php echo $status_class; ?>">
                                    <?php echo $status_text; ?>
                                </span>
                            </div>
                            
                            <div class="candidate-details">
                                <div class="candidate-detail-row">
                                    <i class="fas fa-phone"></i>
                                    <span><?php echo htmlentities($row->ContactNumber); ?></span>
                                </div>
                                <div class="candidate-detail-row">
                                    <i class="fas fa-calendar-alt"></i>
                                    <span>Registered: <?php echo date('M j, Y g:i A', strtotime($row->RegDate)); ?></span>
                                </div>
                                <?php if ($row->LastUpdationDate): ?>
                                <div class="candidate-detail-row">
                                    <i class="fas fa-clock"></i>
                                    <span>Last Updated: <?php echo date('M j, Y', strtotime($row->LastUpdationDate)); ?></span>
                                </div>
                                <?php endif; ?>
                            </div>
                            
                            <div class="candidate-actions">
                                <a href="view-jobseeker-details.php?viewid=<?php echo htmlentities($row->id); ?>" class="action-btn-small btn-primary" target="_blank">
                                    <i class="fas fa-eye"></i>
                                    View Details
                                </a>
                                <a href="jobsapplied-jobseekers.php?jobsid=<?php echo htmlentities($row->id); ?>&&jsname=<?php echo htmlentities($row->FullName); ?>" class="action-btn-small btn-secondary" target="_blank">
                                    <i class="fas fa-briefcase"></i>
                                    Applications
                                </a>
                            </div>
                        </div>
                        <?php } ?>
                    </div>

                    <!-- Table View -->
                    <div class="candidates-table-container" id="tableView" style="display: none;">
                        <table class="candidates-table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Full Name</th>
                                    <th>Contact Number</th>
                                    <th>Email</th>
                                    <th>Status</th>
                                    <th>Registration Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $cnt = $offset + 1;
                                foreach($results as $row) {
                                    $status_class = ($row->IsActive == 1) ? 'status-active' : 'status-inactive';
                                    $status_text = ($row->IsActive == 1) ? 'Active' : 'Inactive';
                                ?>
                                <tr>
                                    <td><?php echo $cnt; ?></td>
                                    <td class="name-cell"><?php echo htmlentities($row->FullName); ?></td>
                                    <td class="contact-cell"><?php echo htmlentities($row->ContactNumber); ?></td>
                                    <td class="email-cell"><?php echo htmlentities($row->EmailId); ?></td>
                                    <td>
                                        <span class="status-badge <?php echo $status_class; ?>">
                                            <?php echo $status_text; ?>
                                        </span>
                                    </td>
                                    <td class="date-cell"><?php echo date('M j, Y g:i A', strtotime($row->RegDate)); ?></td>
                                    <td>
                                        <div style="display: flex; gap: 0.5rem;">
                                            <a href="view-jobseeker-details.php?viewid=<?php echo htmlentities($row->id); ?>" class="filter-btn btn-primary" target="_blank" style="padding: 0.5rem 0.75rem;">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="jobsapplied-jobseekers.php?jobsid=<?php echo htmlentities($row->id); ?>&&jsname=<?php echo htmlentities($row->FullName); ?>" class="filter-btn btn-secondary" target="_blank" style="padding: 0.5rem 0.75rem;">
                                                <i class="fas fa-briefcase"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                <?php 
                                    $cnt++;
                                } 
                                ?>
                            </tbody>
                        </table>
                    </div>

                    <?php } ?>
                </div>

                <!-- Pagination -->
                <?php if ($total_candidates > $limit): ?>
                <div class="pagination-card">
                    <div class="pagination-info">
                        <?php
                        $total_pages = ceil($total_candidates / $limit);
                        $start_record = $offset + 1;
                        $end_record = min($offset + $limit, $total_candidates);
                        ?>
                        Showing <?php echo $start_record; ?>-<?php echo $end_record; ?> of <?php echo $total_candidates; ?> candidates
                    </div>
                    
                    <div class="pagination">
                        <?php
                        $query_string = http_build_query(array_filter([
                            'fdate' => $fdate,
                            'tdate' => $tdate,
                            'search' => $search_term,
                            'status' => $status_filter !== 'all' ? $status_filter : null
                        ]));
                        $query_string = $query_string ? '&' . $query_string : '';

                        if ($page > 1): ?>
                            <a href="?page=<?php echo $page-1; ?><?php echo $query_string; ?>" class="page-btn">
                                <i class="fas fa-chevron-left"></i> Previous
                            </a>
                        <?php endif; ?>

                        <?php for ($i = max(1, $page-2); $i <= min($total_pages, $page+2); $i++): ?>
                            <a href="?page=<?php echo $i; ?><?php echo $query_string; ?>" 
                               class="page-btn <?php echo $i == $page ? 'active' : ''; ?>">
                                <?php echo $i; ?>
                            </a>
                        <?php endfor; ?>

                        <?php if ($page < $total_pages): ?>
                            <a href="?page=<?php echo $page+1; ?><?php echo $query_string; ?>" class="page-btn">
                                Next <i class="fas fa-chevron-right"></i>
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
                <?php endif; ?>

                <?php else: ?>
                <!-- No Date Range Selected -->
                <div class="empty-state">
                    <i class="fas fa-calendar-times"></i>
                    <h3>No Date Range Selected</h3>
                    <p>Please select a date range from the <a href="candidates-report.php" style="color: var(--primary-orange);">Candidates Report</a> page to view the data.</p>
                </div>
                <?php endif; ?>
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
        // View switching functionality
        function switchView(viewType) {
            const cardsView = document.getElementById('cardsView');
            const tableView = document.getElementById('tableView');
            const cardsBtn = document.getElementById('cardsBtn');
            const tableBtn = document.getElementById('tableBtn');
            
            if (viewType === 'cards') {
                cardsView.style.display = 'grid';
                tableView.style.display = 'none';
                cardsBtn.classList.add('active');
                tableBtn.classList.remove('active');
                localStorage.setItem('candidatesViewPreference', 'cards');
            } else {
                cardsView.style.display = 'none';
                tableView.style.display = 'block';
                tableBtn.classList.add('active');
                cardsBtn.classList.remove('active');
                localStorage.setItem('candidatesViewPreference', 'table');
            }
        }

        // Load saved view preference
        document.addEventListener('DOMContentLoaded', function() {
            const savedView = localStorage.getItem('candidatesViewPreference') || 'cards';
            switchView(savedView);
        });

        // Export functions
        function exportToPDF() {
            alert('PDF export functionality - to be implemented');
            // You can implement PDF generation here
        }

        function exportToExcel() {
            // Simple CSV export
            const table = document.querySelector('.candidates-table');
            if (table) {
                let csv = [];
                const rows = table.querySelectorAll('tr');
                
                for (let i = 0; i < rows.length; i++) {
                    const row = [], cols = rows[i].querySelectorAll('td, th');
                    
                    for (let j = 0; j < cols.length - 1; j++) { // Exclude action column
                        let text = cols[j].innerText.replace(/"/g, '""');
                        row.push('"' + text + '"');
                    }
                    
                    csv.push(row.join(','));
                }

                const csvContent = csv.join('\n');
                const blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8;' });
                const link = document.createElement('a');
                
                if (link.download !== undefined) {
                    const url = URL.createObjectURL(blob);
                    link.setAttribute('href', url);
                    link.setAttribute('download', 'candidates_report.csv');
                    link.style.visibility = 'hidden';
                    document.body.appendChild(link);
                    link.click();
                    document.body.removeChild(link);
                }
            }
        }

        // Auto-submit form on filter changes
        document.querySelectorAll('.filter-select').forEach(select => {
            select.addEventListener('change', function() {
                // this.form.submit();
            });
        });

        // Search with debouncing
        let searchTimeout;
        document.querySelector('input[name="search"]').addEventListener('input', function() {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(() => {
                // this.form.submit();
            }, 1000);
        });

        // Print styles
        const printStyles = `
            @media print {
                .page-header, .filters-card, .export-section, .view-toggle, .candidates-actions, .pagination-card { display: none !important; }
                .candidates-card { box-shadow: none; border: 1px solid #ddd; }
                .candidates-table { font-size: 12px; }
                body { background: white !important; }
            }
        `;
        
        const styleSheet = document.createElement('style');
        styleSheet.textContent = printStyles;
        document.head.appendChild(styleSheet);
    </script>
</body>
</html>
<?php }  ?>

<!-- Done 7 -->