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
    <title>Hanap-Kita - Admin Dashboard</title>
    <link rel="stylesheet" id="css-main" href="assets/css/codebase.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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

        .dashboard-header {
            background: var(--card-white);
            border-radius: 16px;
            padding: 2rem;
            margin-bottom: 2rem;
            box-shadow: var(--shadow-soft);
            border: 1px solid rgba(255, 107, 0, 0.1);
        }

        .dashboard-title {
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--text-dark);
            margin: 0;
            background: linear-gradient(135deg, var(--primary-orange), #FF8F42);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .stat-card {
            background: var(--card-white);
            border-radius: 20px;
            padding: 2rem;
            box-shadow: var(--shadow-card);
            border: 1px solid rgba(255, 107, 0, 0.1);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            text-decoration: none;
            color: inherit;
        }

        .stat-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
            text-decoration: none;
            color: inherit;
        }

        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, var(--primary-orange), #FF8F42);
            border-radius: 20px 20px 0 0;
        }

        .stat-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 1.5rem;
        }

        .stat-icon {
            width: 64px;
            height: 64px;
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.75rem;
            color: var(--card-white);
            background: linear-gradient(135deg, var(--primary-orange), #FF8F42);
            box-shadow: 0 8px 16px rgba(255, 107, 0, 0.3);
        }

        .stat-number {
            background: linear-gradient(135deg, var(--primary-orange), #FF8F42);
            color: var(--card-white);
            padding: 0.5rem 1rem;
            border-radius: 12px;
            font-weight: 700;
            font-size: 1.25rem;
            min-width: 60px;
            text-align: center;
            box-shadow: 0 4px 8px rgba(255, 107, 0, 0.2);
        }

        .stat-content {
            margin-top: 1rem;
        }

        .stat-title {
            font-size: 1.125rem;
            font-weight: 600;
            color: var(--text-dark);
            margin: 0;
            line-height: 1.4;
        }

        .stat-description {
            color: var(--text-gray);
            font-size: 0.875rem;
            margin-top: 0.5rem;
            font-weight: 400;
        }

        /* Charts Section */
        .charts-grid {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 2rem;
            margin-bottom: 2rem;
        }

        .chart-card {
            background: var(--card-white);
            border-radius: 20px;
            padding: 2rem;
            box-shadow: var(--shadow-card);
            border: 1px solid rgba(255, 107, 0, 0.1);
        }

        .chart-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid rgba(255, 107, 0, 0.1);
        }

        .chart-title {
            font-size: 1.25rem;
            font-weight: 600;
            color: var(--text-dark);
            margin: 0;
        }

        .chart-subtitle {
            font-size: 0.875rem;
            color: var(--text-gray);
            margin: 0.25rem 0 0 0;
        }

        .chart-container {
            position: relative;
            height: 300px;
        }

        .chart-container.large {
            height: 400px;
        }

        /* Activity Logs Section */
        .activity-section {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 2rem;
            margin-bottom: 2rem;
        }

        .activity-card {
            background: var(--card-white);
            border-radius: 20px;
            padding: 2rem;
            box-shadow: var(--shadow-card);
            border: 1px solid rgba(255, 107, 0, 0.1);
        }

        .activity-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
        }

        .activity-list {
            max-height: 300px;
            overflow-y: auto;
        }

        .activity-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 0;
            border-bottom: 1px solid rgba(255, 107, 0, 0.05);
        }

        .activity-item:last-child {
            border-bottom: none;
        }

        .activity-icon {
            width: 32px;
            height: 32px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 14px;
            flex-shrink: 0;
        }

        .activity-icon.login {
            background: rgba(72, 187, 120, 0.1);
            color: var(--success-green);
        }

        .activity-icon.logout {
            background: rgba(239, 68, 68, 0.1);
            color: #EF4444;
        }

        .activity-icon.register {
            background: rgba(59, 130, 246, 0.1);
            color: #3B82F6;
        }

        .activity-content {
            flex: 1;
            min-width: 0;
        }

        .activity-text {
            font-size: 14px;
            color: var(--text-dark);
            margin: 0;
            font-weight: 500;
        }

        .activity-time {
            font-size: 12px;
            color: var(--text-gray);
            margin: 2px 0 0 0;
        }

        /* Quick Actions */
        .quick-actions {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
            margin-bottom: 2rem;
        }

        .action-btn-card {
            background: var(--card-white);
            border-radius: 16px;
            padding: 1.5rem;
            box-shadow: var(--shadow-soft);
            border: 1px solid rgba(255, 107, 0, 0.1);
            text-decoration: none;
            color: inherit;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .action-btn-card:hover {
            transform: translateY(-4px);
            box-shadow: var(--shadow-card);
            text-decoration: none;
            color: inherit;
        }

        .action-icon {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            background: rgba(255, 107, 0, 0.1);
            color: var(--primary-orange);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            margin-bottom: 1rem;
        }

        .action-title {
            font-size: 14px;
            font-weight: 600;
            color: var(--text-dark);
            margin: 0;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .main-content { padding: 1rem; }
            .charts-grid { grid-template-columns: 1fr; }
            .activity-section { grid-template-columns: 1fr; }
            .quick-actions { grid-template-columns: repeat(2, 1fr); }
        }

        @media (max-width: 480px) {
            .quick-actions { grid-template-columns: 1fr; }
            .stat-header { flex-direction: column; align-items: center; text-align: center; gap: 1rem; }
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
                <div class="dashboard-header">
                    <h2 class="dashboard-title">Dashboard Overview</h2>
                    <p style="color: var(--text-gray); font-size: 1.1rem; margin: 0.5rem 0 0 0;">
                        Welcome back! Here's what's happening with your platform today.
                    </p>
                </div>

                <!-- Statistics Grid -->
                <div class="stats-grid">
                    <!-- Job Categories Card -->
                    <a class="stat-card" href="manage-category.php">
                        <?php 
                        $sql1 ="SELECT id from tblcategory";
                        $query1 = $dbh -> prepare($sql1);
                        $query1->execute();
                        $totcat=$query1->rowCount();
                        ?>
                        <div class="stat-header">
                            <div class="stat-icon">
                                <i class="fas fa-bookmark"></i>
                            </div>
                            <div class="stat-number"><?php echo htmlentities($totcat);?></div>
                        </div>
                        <div class="stat-content">
                            <h3 class="stat-title">Job Categories</h3>
                            <p class="stat-description">Active job categories</p>
                        </div>
                    </a>

                    <!-- Employers Card -->
                    <a class="stat-card" href="employer-list.php">
                        <?php 
                        $sql2 ="SELECT id from tblemployers";
                        $query2 = $dbh -> prepare($sql2);
                        $query2->execute();
                        $totemp=$query2->rowCount();
                        ?>
                        <div class="stat-header">
                            <div class="stat-icon">
                                <i class="fas fa-building"></i>
                            </div>
                            <div class="stat-number"><?php echo htmlentities($totemp);?></div>
                        </div>
                        <div class="stat-content">
                            <h3 class="stat-title">Registered Employers</h3>
                            <p class="stat-description">Companies on platform</p>
                        </div>
                    </a>

                    <!-- Job Seekers Card -->
                    <a class="stat-card" href="reg-jobseekers.php">
                        <?php 
                        $sql3 ="SELECT id from tbljobseekers";
                        $query3 = $dbh -> prepare($sql3);
                        $query3->execute();
                        $totcan=$query3->rowCount();
                        ?>
                        <div class="stat-header">
                            <div class="stat-icon">
                                <i class="fas fa-users"></i>
                            </div>
                            <div class="stat-number"><?php echo htmlentities($totcan);?></div>
                        </div>
                        <div class="stat-content">
                            <h3 class="stat-title">Job Seekers</h3>
                            <p class="stat-description">Registered candidates</p>
                        </div>
                    </a>

                    <!-- Listed Jobs Card -->
                    <a class="stat-card" href="all-listed-jobs.php">
                        <?php 
                        $sql4 ="SELECT jobId from tbljobs";
                        $query4 = $dbh -> prepare($sql4);
                        $query4->execute();
                        $totaljobs=$query4->rowCount();
                        ?> 
                        <div class="stat-header">
                            <div class="stat-icon">
                                <i class="fas fa-briefcase"></i>
                            </div>
                            <div class="stat-number"><?php echo htmlentities($totaljobs);?></div>
                        </div>
                        <div class="stat-content">
                            <h3 class="stat-title">Active Job Listings</h3>
                            <p class="stat-description">Current opportunities</p>
                        </div>
                    </a>
                </div>

                <!-- Charts Section -->
                <div class="charts-grid">
                    <!-- Applications Over Time -->
                    <div class="chart-card">
                        <div class="chart-header">
                            <div>
                                <h3 class="chart-title">Job Applications Trend</h3>
                                <p class="chart-subtitle">Applications received over the last 30 days</p>
                            </div>
                        </div>
                        <div class="chart-container large">
                            <canvas id="applicationsChart"></canvas>
                        </div>
                    </div>

                    <!-- Jobs by Category -->
                    <div class="chart-card">
                        <div class="chart-header">
                            <div>
                                <h3 class="chart-title">Jobs by Category</h3>
                                <p class="chart-subtitle">Distribution of job listings</p>
                            </div>
                        </div>
                        <div class="chart-container">
                            <canvas id="categoriesChart"></canvas>
                        </div>
                    </div>
                </div>

                <!-- Activity and Recent Logs -->
                <div class="activity-section">
                    <!-- Recent Activity -->
                    <div class="activity-card">
                        <div class="activity-header">
                            <h3 class="chart-title">Recent Activity</h3>
                            <a href="activity-logs.php" style="color: var(--primary-orange); font-size: 14px; text-decoration: none;">View All</a>
                        </div>
                        <div class="activity-list">
                            <?php
                            // Get recent applications
                            $sql_recent = "SELECT tbljobseekers.FullName, tbljobs.jobTitle, tblapplyjob.Applydate 
                                          FROM tblapplyjob 
                                          JOIN tbljobseekers ON tbljobseekers.id = tblapplyjob.UserId 
                                          JOIN tbljobs ON tbljobs.jobId = tblapplyjob.JobId 
                                          ORDER BY tblapplyjob.Applydate DESC LIMIT 8";
                            $query_recent = $dbh->prepare($sql_recent);
                            $query_recent->execute();
                            $recent_activities = $query_recent->fetchAll(PDO::FETCH_OBJ);
                            
                            foreach($recent_activities as $activity) {
                            ?>
                            <div class="activity-item">
                                <div class="activity-icon register">
                                    <i class="fas fa-file-alt"></i>
                                </div>
                                <div class="activity-content">
                                    <p class="activity-text"><?php echo htmlentities($activity->FullName); ?> applied for <?php echo htmlentities($activity->jobTitle); ?></p>
                                    <p class="activity-time"><?php echo date('M j, Y g:i A', strtotime($activity->Applydate)); ?></p>
                                </div>
                            </div>
                            <?php } ?>
                        </div>
                    </div>

                    <!-- Application Status -->
                    <div class="activity-card">
                        <div class="activity-header">
                            <h3 class="chart-title">Application Status</h3>
                        </div>
                        <div class="chart-container">
                            <canvas id="statusChart"></canvas>
                        </div>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="quick-actions">
                    <a href="add-category.php" class="action-btn-card">
                        <div class="action-icon">
                            <i class="fas fa-plus"></i>
                        </div>
                        <h4 class="action-title">Add Category</h4>
                    </a>
                    <a href="employer-search.php" class="action-btn-card">
                        <div class="action-icon">
                            <i class="fas fa-search"></i>
                        </div>
                        <h4 class="action-title">Search Employers</h4>
                    </a>
                    <a href="candidates-search.php" class="action-btn-card">
                        <div class="action-icon">
                            <i class="fas fa-user-search"></i>
                        </div>
                        <h4 class="action-title">Search Candidates</h4>
                    </a>
                    <a href="employer-report.php" class="action-btn-card">
                        <div class="action-icon">
                            <i class="fas fa-chart-line"></i>
                        </div>
                        <h4 class="action-title">Generate Report</h4>
                    </a>
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
        // Chart.js Configuration
        Chart.defaults.font.family = 'Inter';
        Chart.defaults.color = '#718096';

        // Applications Over Time Chart
        const ctx1 = document.getElementById('applicationsChart').getContext('2d');
        
        // Get applications data for the last 30 days
        <?php
        $applications_data = [];
        for($i = 29; $i >= 0; $i--) {
            $date = date('Y-m-d', strtotime("-$i days"));
            $sql_daily = "SELECT COUNT(*) as count FROM tblapplyjob WHERE DATE(Applydate) = '$date'";
            $query_daily = $dbh->prepare($sql_daily);
            $query_daily->execute();
            $result = $query_daily->fetch(PDO::FETCH_OBJ);
            $applications_data[] = $result->count;
        }
        ?>
        
        new Chart(ctx1, {
            type: 'line',
            data: {
                labels: [<?php 
                    for($i = 29; $i >= 0; $i--) {
                        echo "'" . date('M j', strtotime("-$i days")) . "'";
                        if($i > 0) echo ",";
                    }
                ?>],
                datasets: [{
                    label: 'Applications',
                    data: [<?php echo implode(',', $applications_data); ?>],
                    borderColor: '#FF6B00',
                    backgroundColor: 'rgba(255, 107, 0, 0.1)',
                    fill: true,
                    tension: 0.4,
                    pointBackgroundColor: '#FF6B00',
                    pointBorderColor: '#fff',
                    pointBorderWidth: 2,
                    pointRadius: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: 'rgba(255, 107, 0, 0.1)'
                        }
                    },
                    x: {
                        grid: {
                            color: 'rgba(255, 107, 0, 0.1)'
                        }
                    }
                }
            }
        });

        // Jobs by Category Chart
        const ctx2 = document.getElementById('categoriesChart').getContext('2d');
        
        <?php
        $sql_categories = "SELECT c.CategoryName, COUNT(j.jobId) as job_count 
                          FROM tblcategory c 
                          LEFT JOIN tbljobs j ON c.CategoryName = j.jobCategory 
                          GROUP BY c.CategoryName 
                          ORDER BY job_count DESC 
                          LIMIT 8";
        $query_categories = $dbh->prepare($sql_categories);
        $query_categories->execute();
        $categories_data = $query_categories->fetchAll(PDO::FETCH_OBJ);
        
        $category_names = [];
        $category_counts = [];
        foreach($categories_data as $cat) {
            $category_names[] = "'" . $cat->CategoryName . "'";
            $category_counts[] = $cat->job_count;
        }
        ?>
        
        new Chart(ctx2, {
            type: 'doughnut',
            data: {
                labels: [<?php echo implode(',', $category_names); ?>],
                datasets: [{
                    data: [<?php echo implode(',', $category_counts); ?>],
                    backgroundColor: [
                        '#FF6B00', '#FF8F42', '#667eea', '#764ba2',
                        '#f093fb', '#f5576c', '#4facfe', '#00f2fe'
                    ],
                    borderWidth: 0,
                    hoverOffset: 10
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            padding: 20,
                            usePointStyle: true
                        }
                    }
                }
            }
        });

        // Application Status Chart
        const ctx3 = document.getElementById('statusChart').getContext('2d');
        
        <?php
        $sql_hired = "SELECT COUNT(*) as count FROM tblapplyjob WHERE Status = 'Hired'";
        $query_hired = $dbh->prepare($sql_hired);
        $query_hired->execute();
        $hired_count = $query_hired->fetch(PDO::FETCH_OBJ)->count;
        
        $sql_pending = "SELECT COUNT(*) as count FROM tblapplyjob WHERE Status IS NULL";
        $query_pending = $dbh->prepare($sql_pending);
        $query_pending->execute();
        $pending_count = $query_pending->fetch(PDO::FETCH_OBJ)->count;
        
        $sql_rejected = "SELECT COUNT(*) as count FROM tblapplyjob WHERE Status = 'Rejected'";
        $query_rejected = $dbh->prepare($sql_rejected);
        $query_rejected->execute();
        $rejected_count = $query_rejected->fetch(PDO::FETCH_OBJ)->count;
        ?>
        
        new Chart(ctx3, {
            type: 'bar',
            data: {
                labels: ['Hired', 'Pending', 'Rejected'],
                datasets: [{
                    label: 'Applications',
                    data: [<?php echo "$hired_count, $pending_count, $rejected_count"; ?>],
                    backgroundColor: ['#48BB78', '#FF6B00', '#EF4444'],
                    borderRadius: 8,
                    borderSkipped: false
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: 'rgba(255, 107, 0, 0.1)'
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        }
                    }
                }
            }
        });

        // Animate numbers on load
        document.addEventListener('DOMContentLoaded', function() {
            const numbers = document.querySelectorAll('.stat-number');
            numbers.forEach(number => {
                const finalValue = parseInt(number.textContent);
                let currentValue = 0;
                const increment = finalValue / 30;
                const timer = setInterval(() => {
                    currentValue += increment;
                    if (currentValue >= finalValue) {
                        currentValue = finalValue;
                        clearInterval(timer);
                    }
                    number.textContent = Math.floor(currentValue);
                }, 50);
            });
        });
    </script>
</body>
</html>
<?php }  ?>
<!-- Done 12 -->