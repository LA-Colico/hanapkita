<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
if (strlen($_SESSION['jpaid']==0)) {
  header('location:logout.php');
  } else{
?>
<!doctype html>
<html lang="en" class="no-focus">
<head>
    <title>Hanap-Kita - Jobseeker Lists</title>
    <link rel="stylesheet" href="assets/js/plugins/datatables/dataTables.bootstrap4.min.css">
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
            --error-red: #EF4444;
            --shadow-soft: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            --shadow-card: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
            --shadow-hover: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
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

        /* Header Section */
        .dashboard-header {
            background: linear-gradient(135deg, var(--card-white) 0%, #FEFBF8 100%);
            border-radius: 20px;
            padding: 2.5rem;
            margin-bottom: 2rem;
            box-shadow: var(--shadow-card);
            border: 1px solid rgba(255, 107, 0, 0.1);
            position: relative;
            overflow: hidden;
        }

        .dashboard-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 5px;
            background: linear-gradient(90deg, var(--primary-orange), #FF8F42, #FFB366);
        }

        .header-content {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            flex-wrap: wrap;
            gap: 2rem;
        }

        .header-text {
            flex: 1;
            min-width: 300px;
        }

        .page-title {
            font-size: 3rem;
            font-weight: 800;
            margin: 0 0 1rem 0;
            background: linear-gradient(135deg, var(--primary-orange), #FF8F42);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            line-height: 1.1;
        }

        .page-description {
            font-size: 1.1rem;
            color: var(--text-gray);
            margin: 0 0 2rem 0;
            line-height: 1.6;
            max-width: 500px;
        }

        .header-stats {
            display: flex;
            gap: 2rem;
            flex-wrap: wrap;
        }

        .header-stat {
            text-align: center;
            padding: 1rem;
            background: rgba(255, 107, 0, 0.05);
            border-radius: 16px;
            border: 1px solid rgba(255, 107, 0, 0.1);
            min-width: 120px;
        }

        .stat-number {
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--primary-orange);
            margin: 0;
            line-height: 1;
        }

        .stat-label {
            font-size: 0.875rem;
            color: var(--text-gray);
            margin: 0.5rem 0 0 0;
            font-weight: 500;
        }

        .header-actions {
            display: flex;
            gap: 1rem;
            align-items: flex-start;
        }

        .primary-btn {
            background: linear-gradient(135deg, var(--primary-orange), #FF8F42);
            color: white;
            border: none;
            border-radius: 14px;
            padding: 14px 28px;
            font-weight: 600;
            font-size: 1rem;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            transition: all 0.3s ease;
            box-shadow: 0 6px 20px rgba(255, 107, 0, 0.3);
            cursor: pointer;
        }

        .primary-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(255, 107, 0, 0.4);
            color: white;
            text-decoration: none;
        }

        .secondary-btn {
            background: rgba(255, 107, 0, 0.1);
            color: var(--primary-orange);
            border: 2px solid rgba(255, 107, 0, 0.2);
            border-radius: 14px;
            padding: 12px 26px;
            font-weight: 600;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            transition: all 0.3s ease;
        }

        .secondary-btn:hover {
            background: rgba(255, 107, 0, 0.2);
            border-color: var(--primary-orange);
            color: var(--primary-orange);
            text-decoration: none;
            transform: translateY(-2px);
        }

        /* Search and Filter Panel */
        .control-panel {
            background: var(--card-white);
            border-radius: 20px;
            padding: 2rem;
            margin-bottom: 2rem;
            box-shadow: var(--shadow-soft);
            border: 1px solid rgba(255, 107, 0, 0.1);
        }

        .panel-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid rgba(255, 107, 0, 0.1);
        }

        .panel-title {
            font-size: 1.25rem;
            font-weight: 600;
            color: var(--text-dark);
            margin: 0;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .panel-icon {
            width: 32px;
            height: 32px;
            background: linear-gradient(135deg, var(--primary-orange), #FF8F42);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 16px;
        }

        .search-grid {
            display: grid;
            grid-template-columns: 2fr 1fr 1fr auto;
            gap: 1.5rem;
            align-items: end;
        }

        .search-group {
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
        }

        .search-label {
            font-size: 0.875rem;
            font-weight: 600;
            color: var(--text-dark);
            margin: 0;
        }

        .search-input, .search-select {
            padding: 14px 18px;
            border: 2px solid rgba(255, 107, 0, 0.1);
            border-radius: 12px;
            background: var(--card-white);
            font-size: 1rem;
            transition: all 0.3s ease;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
            font-weight: 500;
        }

        .search-input:focus, .search-select:focus {
            outline: none;
            border-color: var(--primary-orange);
            box-shadow: 0 0 0 4px rgba(255, 107, 0, 0.1);
            background: #FEFEFE;
        }

        .search-btn {
            background: linear-gradient(135deg, var(--primary-orange), #FF8F42);
            color: white;
            border: none;
            border-radius: 12px;
            padding: 14px 20px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 12px rgba(255, 107, 0, 0.3);
            font-size: 1rem;
        }

        .search-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(255, 107, 0, 0.4);
        }

        /* Main Content Area */
        .content-container {
            background: var(--card-white);
            border-radius: 20px;
            overflow: hidden;
            box-shadow: var(--shadow-card);
            border: 1px solid rgba(255, 107, 0, 0.1);
        }

        .content-header {
            background: linear-gradient(135deg, rgba(255, 107, 0, 0.05), rgba(255, 143, 66, 0.03));
            padding: 2rem;
            border-bottom: 1px solid rgba(255, 107, 0, 0.1);
        }

        .content-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--text-dark);
            margin: 0;
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .title-badge {
            background: linear-gradient(135deg, var(--primary-orange), #FF8F42);
            color: white;
            padding: 8px 16px;
            border-radius: 12px;
            font-size: 0.875rem;
            font-weight: 600;
        }

        /* List Layout */
        .seekers-list {
            padding: 0;
        }

        .seeker-item {
            display: flex;
            align-items: center;
            padding: 2rem;
            border-bottom: 1px solid rgba(255, 107, 0, 0.05);
            transition: all 0.3s ease;
            position: relative;
        }

        .seeker-item:last-child {
            border-bottom: none;
        }

        .seeker-item:hover {
            background: linear-gradient(135deg, rgba(255, 107, 0, 0.02), rgba(255, 143, 66, 0.01));
            transform: translateX(8px);
        }

        .seeker-avatar {
            width: 80px;
            height: 80px;
            border-radius: 20px;
            background: linear-gradient(135deg, var(--primary-orange), #FF8F42);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.75rem;
            font-weight: 700;
            margin-right: 1.5rem;
            flex-shrink: 0;
            position: relative;
            overflow: hidden;
            box-shadow: 0 8px 20px rgba(255, 107, 0, 0.2);
        }

        .avatar-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 20px;
        }

        .seeker-info {
            flex: 1;
            display: grid;
            grid-template-columns: 2fr 1fr 1fr 1fr;
            gap: 2rem;
            align-items: center;
        }

        .seeker-main {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }

        .seeker-name {
            font-size: 1.25rem;
            font-weight: 700;
            color: var(--text-dark);
            margin: 0;
            line-height: 1.2;
        }

        .seeker-email {
            font-size: 1rem;
            color: var(--text-gray);
            margin: 0;
            font-weight: 500;
        }

        .seeker-meta {
            font-size: 0.875rem;
            color: var(--text-light);
            margin: 0.25rem 0 0 0;
        }

        .seeker-contact {
            display: flex;
            flex-direction: column;
            gap: 0.25rem;
        }

        .contact-label {
            font-size: 0.75rem;
            color: var(--text-gray);
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin: 0;
        }

        .contact-value {
            font-size: 1rem;
            color: var(--text-dark);
            font-weight: 600;
            margin: 0;
        }

        .seeker-status {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 0.5rem;
        }

        .status-indicator {
            width: 16px;
            height: 16px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 8px;
            color: white;
            font-weight: 600;
        }

        .status-active .status-indicator {
            background: var(--success-green);
            box-shadow: 0 0 0 4px rgba(72, 187, 120, 0.2);
        }

        .status-inactive .status-indicator {
            background: var(--error-red);
            box-shadow: 0 0 0 4px rgba(239, 68, 68, 0.2);
        }

        .status-text {
            font-size: 0.875rem;
            font-weight: 600;
            margin: 0;
        }

        .status-active .status-text {
            color: var(--success-green);
        }

        .status-inactive .status-text {
            color: var(--error-red);
        }

        .seeker-date {
            text-align: center;
        }

        .date-day {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--primary-orange);
            margin: 0;
            line-height: 1;
        }

        .date-month {
            font-size: 0.875rem;
            color: var(--text-gray);
            margin: 0;
            font-weight: 600;
        }

        .seeker-actions {
            display: flex;
            gap: 1.75rem;
            margin-left: 1.5rem;
        }

        .action-btn {
            padding: 10px 16px;
            border-radius: 5px;
            font-size: 0.875rem;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 6px;
            border: none;
            cursor: pointer;
        }

        .action-view {
            background: linear-gradient(135deg, var(--primary-orange), #FF8F42);
            color: white;
            padding: 20px 45px;
            box-shadow: 0 4px 12px rgba(255, 107, 0, 0.3);
        }

        .action-view:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(255, 107, 0, 0.4);
            color: white;
            text-decoration: none;
        }

        .action-jobs {
            background: rgba(255, 107, 0, 0.1);
            color: var(--primary-orange);
            padding: 20px 55px;
            border: 1px solid rgba(255, 107, 0, 0.2);
        }

        .action-jobs:hover {
            background: rgba(255, 107, 0, 0.2);
            color: var(--primary-orange);
            text-decoration: none;
            transform: translateY(-1px);
        }

        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 6rem 2rem;
        }

        .empty-illustration {
            width: 120px;
            height: 120px;
            margin: 0 auto 2rem;
            background: linear-gradient(135deg, rgba(255, 107, 0, 0.1), rgba(255, 143, 66, 0.05));
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 3rem;
            color: var(--primary-orange);
        }

        .empty-title {
            font-size: 2rem;
            font-weight: 700;
            color: var(--text-dark);
            margin: 0 0 1rem 0;
        }

        .empty-message {
            font-size: 1.1rem;
            color: var(--text-gray);
            margin: 0;
            max-width: 400px;
            margin-left: auto;
            margin-right: auto;
            line-height: 1.6;
        }

        /* Responsive Design */
        @media (max-width: 1200px) {
            .seeker-info {
                grid-template-columns: 2fr 1fr 1fr;
                gap: 1.5rem;
            }
            
            .seeker-date {
                display: none;
            }
        }

        @media (max-width: 992px) {
            .search-grid {
                grid-template-columns: 1fr 1fr;
                gap: 1rem;
            }

            .seeker-info {
                grid-template-columns: 2fr 1fr;
                gap: 1rem;
            }

            .seeker-contact {
                display: none;
            }
        }

        @media (max-width: 768px) {
            .main-content {
                padding: 1rem;
            }

            .dashboard-header {
                padding: 2rem;
            }

            .header-content {
                flex-direction: column;
                align-items: stretch;
            }

            .search-grid {
                grid-template-columns: 1fr;
                gap: 1rem;
            }

            .seeker-item {
                flex-direction: column;
                align-items: stretch;
                gap: 1.5rem;
                padding: 1.5rem;
            }

            .seeker-info {
                grid-template-columns: 1fr;
                gap: 1rem;
            }

            .seeker-avatar {
                align-self: center;
                margin-right: 0;
            }

            .seeker-actions {
                margin-left: 0;
                justify-content: center;
            }
        }

        @media (max-width: 480px) {
            .page-title {
                font-size: 2rem;
            }

            .header-stats {
                justify-content: center;
                gap: 1rem;
            }

            .seeker-actions {
                flex-direction: column;
            }
        }

        /* Animation Classes */
        .fade-in {
            animation: fadeIn 0.6s ease-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .slide-in {
            animation: slideIn 0.8s ease-out;
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateX(-30px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }
    </style>
</head>
<body>
    <div id="page-container" class="sidebar-o sidebar-inverse side-scroll page-header-fixed main-content-narrow">
        <?php include_once('includes/sidebar.php');?>
        <?php include_once('includes/header.php');?>

        <main id="main-container">
            <div class="content main-content">
                <!-- Dashboard Header -->
                <div class="dashboard-header fade-in">
                    <div class="header-content">
                        <div class="header-text">
                            <h1 class="page-title">Job Seekers</h1>
                            <p class="page-description">
                                Manage and monitor all registered candidates in your platform. 
                                View profiles, track applications, and connect talent with opportunities.
                            </p>
                            
                            <div class="header-stats">
                                <?php 
                                // Get statistics
                                $sql_total = "SELECT COUNT(*) as total FROM tbljobseekers";
                                $query_total = $dbh->prepare($sql_total);
                                $query_total->execute();
                                $total_seekers = $query_total->fetch(PDO::FETCH_OBJ)->total;
                                
                                $sql_active = "SELECT COUNT(*) as active FROM tbljobseekers WHERE IsActive=1";
                                $query_active = $dbh->prepare($sql_active);
                                $query_active->execute();
                                $active_seekers = $query_active->fetch(PDO::FETCH_OBJ)->active;
                                
                                $sql_new = "SELECT COUNT(*) as new_count FROM tbljobseekers WHERE MONTH(RegDate) = MONTH(CURDATE()) AND YEAR(RegDate) = YEAR(CURDATE())";
                                $query_new = $dbh->prepare($sql_new);
                                $query_new->execute();
                                $new_seekers = $query_new->fetch(PDO::FETCH_OBJ)->new_count;
                                
                                $sql_applied = "SELECT COUNT(DISTINCT UserId) as applied FROM tblapplyjob";
                                $query_applied = $dbh->prepare($sql_applied);
                                $query_applied->execute();
                                $applied_seekers = $query_applied->fetch(PDO::FETCH_OBJ)->applied;
                                ?>
                                
                                <div class="header-stat">
                                    <p class="stat-number" data-count="<?php echo $total_seekers; ?>">0</p>
                                    <p class="stat-label">Total</p>
                                </div>
                                <div class="header-stat">
                                    <p class="stat-number" data-count="<?php echo $active_seekers; ?>">0</p>
                                    <p class="stat-label">Active</p>
                                </div>
                                <div class="header-stat">
                                    <p class="stat-number" data-count="<?php echo $new_seekers; ?>">0</p>
                                    <p class="stat-label">New</p>
                                </div>
                                <div class="header-stat">
                                    <p class="stat-number" data-count="<?php echo $applied_seekers; ?>">0</p>
                                    <p class="stat-label">Applied</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="header-actions">
                            <a href="candidates-search.php" class="secondary-btn">
                                <i class="fas fa-search"></i>
                                Advanced Search
                            </a>
                            <a href="candidates-report.php" class="primary-btn">
                                <i class="fas fa-chart-line"></i>
                                Generate Report
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Control Panel -->
                <div class="control-panel slide-in">
                    <div class="panel-header">
                        <h3 class="panel-title">
                            <div class="panel-icon">
                                <i class="fas fa-filter"></i>
                            </div>
                            Search & Filter
                        </h3>
                        <span style="color: var(--text-gray); font-size: 0.875rem;">
                            <span id="resultCount"><?php echo $total_seekers; ?></span> candidates found
                        </span>
                    </div>
                    
                    <div class="search-grid">
                        <div class="search-group">
                            <label class="search-label">Search Candidates</label>
                            <input type="text" class="search-input" id="candidateSearch" 
                                   placeholder="Search by name, email, or contact number...">
                        </div>
                        
                        <div class="search-group">
                            <label class="search-label">Status</label>
                            <select class="search-select" id="statusFilter">
                                <option value="">All Status</option>
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>
                        </div>
                        
                        <div class="search-group">
                            <label class="search-label">Period</label>
                            <select class="search-select" id="periodFilter">
                                <option value="">All Time</option>
                                <option value="today">Today</option>
                                <option value="week">This Week</option>
                                <option value="month">This Month</option>
                                <option value="year">This Year</option>
                            </select>
                        </div>
                        
                        <button class="search-btn" onclick="clearAllFilters()">
                            <i class="fas fa-refresh"></i>
                        </button>
                    </div>
                </div>

                <!-- Main Content -->
                <div class="content-container">
                    <div class="content-header">
                        <h2 class="content-title">
                            Registered Candidates
                            <span class="title-badge" id="titleBadge"><?php echo $total_seekers; ?> Total</span>
                        </h2>
                    </div>
                    
                    <div class="seekers-list" id="seekersList">
                        <?php
                        $sql="SELECT * from tbljobseekers ORDER BY RegDate DESC";
                        $query = $dbh -> prepare($sql);
                        $query->execute();
                        $results=$query->fetchAll(PDO::FETCH_OBJ);

                        $cnt=1;
                        if($query->rowCount() > 0) {
                            foreach($results as $row) {
                        ?>
                        <div class="seeker-item" 
                             data-name="<?php echo htmlentities($row->FullName); ?>"
                             data-email="<?php echo htmlentities($row->EmailId); ?>"
                             data-contact="<?php echo htmlentities($row->ContactNumber); ?>"
                             data-status="<?php echo htmlentities($row->IsActive); ?>"
                             data-regdate="<?php echo $row->RegDate; ?>">
                            
                            <div class="seeker-avatar">
                                <?php if(!empty($row->ProfilePic)): ?>
                                    <img src="../images/<?php echo $row->ProfilePic; ?>" 
                                         alt="<?php echo htmlentities($row->FullName); ?>" 
                                         class="avatar-img"
                                         onerror="this.style.display='none'; this.parentElement.innerHTML='<?php echo strtoupper(substr($row->FullName, 0, 2)); ?>';">
                                <?php else: ?>
                                    <?php echo strtoupper(substr($row->FullName, 0, 2)); ?>
                                <?php endif; ?>
                            </div>
                            
                            <div class="seeker-info">
                                <div class="seeker-main">
                                    <h4 class="seeker-name"><?php echo htmlentities($row->FullName); ?></h4>
                                    <p class="seeker-email"><?php echo htmlentities($row->EmailId); ?></p>
                                    <p class="seeker-meta">
                                        ID: #<?php echo str_pad($row->id, 4, '0', STR_PAD_LEFT); ?> • 
                                        Registered <?php echo date('M j, Y', strtotime($row->RegDate)); ?>
                                    </p>
                                </div>
                                
                                <div class="seeker-contact">
                                    <p class="contact-label">Contact</p>
                                    <p class="contact-value"><?php echo htmlentities($row->ContactNumber); ?></p>
                                </div>
                                
                                <div class="seeker-status <?php echo ($row->IsActive == '1') ? 'status-active' : 'status-inactive'; ?>">
                                    <div class="status-indicator">
                                        <i class="fas fa-check"></i>
                                    </div>
                                    <p class="status-text"><?php echo ($row->IsActive == '1') ? 'Active' : 'Inactive'; ?></p>
                                </div>
                                
                                <div class="seeker-date">
                                    <p class="date-day"><?php echo date('d', strtotime($row->RegDate)); ?></p>
                                    <p class="date-month"><?php echo date('M Y', strtotime($row->RegDate)); ?></p>
                                </div>
                            </div>
                            
                            <div class="seeker-actions">
                                <a href="view-jobseeker-details.php?viewid=<?php echo htmlentities($row->id); ?>" 
                                   class="action-btn action-view">
                                    <i class="fas fa-eye"></i>
                                    View Profile
                                </a>
                                <a href="jobsapplied-jobseekers.php?jobsid=<?php echo htmlentities($row->id); ?>&&jsname=<?php echo htmlentities($row->FullName); ?>" 
                                   class="action-btn action-jobs" target="_blank">
                                    <i class="fas fa-briefcase"></i>
                                    Applications
                                </a>
                            </div>
                        </div>
                        <?php 
                            $cnt = $cnt + 1;
                            }
                        } else {
                        ?>
                        <div class="empty-state">
                            <div class="empty-illustration">
                                <i class="fas fa-users"></i>
                            </div>
                            <h3 class="empty-title">No Job Seekers Yet</h3>
                            <p class="empty-message">
                                No candidates have registered on your platform yet. 
                                New job seekers will appear here once they create their profiles.
                            </p>
                        </div>
                        <?php } ?>
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
        // Advanced search and filtering
        const searchInput = document.getElementById('candidateSearch');
        const statusFilter = document.getElementById('statusFilter');
        const periodFilter = document.getElementById('periodFilter');
        const resultCount = document.getElementById('resultCount');
        const titleBadge = document.getElementById('titleBadge');

        // Add event listeners
        searchInput.addEventListener('input', filterCandidates);
        statusFilter.addEventListener('change', filterCandidates);
        periodFilter.addEventListener('change', filterCandidates);

        function filterCandidates() {
            const searchTerm = searchInput.value.toLowerCase().trim();
            const statusValue = statusFilter.value;
            const periodValue = periodFilter.value;
            
            const seekerItems = document.querySelectorAll('.seeker-item');
            let visibleCount = 0;

            seekerItems.forEach(item => {
                const name = item.dataset.name.toLowerCase();
                const email = item.dataset.email.toLowerCase();
                const contact = item.dataset.contact.toLowerCase();
                const status = item.dataset.status;
                const regDate = new Date(item.dataset.regdate);
                
                // Search matching
                const matchesSearch = !searchTerm || 
                    name.includes(searchTerm) || 
                    email.includes(searchTerm) || 
                    contact.includes(searchTerm);
                
                // Status matching
                const matchesStatus = !statusValue || status === statusValue;
                
                // Period matching
                let matchesPeriod = true;
                if (periodValue) {
                    const now = new Date();
                    const today = new Date(now.getFullYear(), now.getMonth(), now.getDate());
                    
                    switch(periodValue) {
                        case 'today':
                            matchesPeriod = regDate >= today;
                            break;
                        case 'week':
                            const weekAgo = new Date(today.getTime() - 7 * 24 * 60 * 60 * 1000);
                            matchesPeriod = regDate >= weekAgo;
                            break;
                        case 'month':
                            matchesPeriod = regDate.getMonth() === now.getMonth() && 
                                          regDate.getFullYear() === now.getFullYear();
                            break;
                        case 'year':
                            matchesPeriod = regDate.getFullYear() === now.getFullYear();
                            break;
                    }
                }
                
                if (matchesSearch && matchesStatus && matchesPeriod) {
                    item.style.display = 'flex';
                    visibleCount++;
                } else {
                    item.style.display = 'none';
                }
            });

            // Update counters
            updateCounters(visibleCount);
            
            // Show/hide empty state
            toggleEmptyState(visibleCount === 0 && seekerItems.length > 0);
        }

        function updateCounters(count) {
            resultCount.textContent = count;
            titleBadge.textContent = `${count} ${count === 1 ? 'Candidate' : 'Candidates'}`;
        }

        function toggleEmptyState(show) {
            let emptyState = document.querySelector('.empty-state.search-empty');
            
            if (show && !emptyState) {
                const emptyHTML = `
                    <div class="empty-state search-empty">
                        <div class="empty-illustration">
                            <i class="fas fa-search"></i>
                        </div>
                        <h3 class="empty-title">No Results Found</h3>
                        <p class="empty-message">
                            No candidates match your current search criteria. 
                            Try adjusting your filters or search terms.
                        </p>
                    </div>
                `;
                document.getElementById('seekersList').insertAdjacentHTML('beforeend', emptyHTML);
            } else if (!show && emptyState) {
                emptyState.remove();
            }
        }

        function clearAllFilters() {
            searchInput.value = '';
            statusFilter.value = '';
            periodFilter.value = '';
            filterCandidates();
        }

        // Animated counters
        function animateCounters() {
            const counters = document.querySelectorAll('.stat-number[data-count]');
            
            counters.forEach(counter => {
                const target = parseInt(counter.dataset.count);
                let current = 0;
                const increment = target / 30;
                
                const timer = setInterval(() => {
                    current += increment;
                    if (current >= target) {
                        current = target;
                        clearInterval(timer);
                    }
                    counter.textContent = Math.floor(current);
                }, 50);
            });
        }

        // Enhanced animations on load
        document.addEventListener('DOMContentLoaded', function() {
            // Animate counters
            setTimeout(animateCounters, 500);
            
            // Staggered animation for seeker items
            const seekerItems = document.querySelectorAll('.seeker-item');
            seekerItems.forEach((item, index) => {
                item.style.opacity = '0';
                item.style.transform = 'translateX(-20px)';
                
                setTimeout(() => {
                    item.style.transition = 'all 0.6s cubic-bezier(0.4, 0, 0.2, 1)';
                    item.style.opacity = '1';
                    item.style.transform = 'translateX(0)';
                }, 200 + (index * 100));
            });
        });

        // Enhanced hover effects
        document.querySelectorAll('.seeker-item').forEach(item => {
            item.addEventListener('mouseenter', function() {
                this.style.background = 'linear-gradient(135deg, rgba(255, 107, 0, 0.04), rgba(255, 143, 66, 0.02))';
            });
            
            item.addEventListener('mouseleave', function() {
                this.style.background = '';
            });
        });
    </script>
</body>
</html>
<?php }  ?>

<!-- Done 22 -->