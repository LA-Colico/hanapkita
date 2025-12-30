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
            --shadow-elevated: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }

        * { font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif; }

        body {
            background: linear-gradient(135deg, var(--bg-peach) 0%, #FAF5F0 100%);
            min-height: 100vh;
        }

        .main-content {
            padding: 2rem;
            margin-left: 0;
            max-width: 1200px;
            margin: 0 auto;
        }

        /* Page Header */
        .page-header {
            background: var(--card-white);
            border-radius: 24px;
            padding: 3rem 2rem;
            margin-bottom: 2rem;
            box-shadow: var(--shadow-elevated);
            border: 1px solid rgba(255, 107, 0, 0.1);
            position: relative;
            overflow: hidden;
            text-align: center;
        }

        .page-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 6px;
            background: linear-gradient(90deg, var(--primary-orange), #FF8F42, #FFB366);
            border-radius: 24px 24px 0 0;
        }

        .header-icon {
            width: 80px;
            height: 80px;
            border-radius: 20px;
            background: linear-gradient(135deg, var(--primary-orange), #FF8F42);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 32px;
            margin: 0 auto 1.5rem auto;
            box-shadow: 0 12px 24px rgba(255, 107, 0, 0.3);
        }

        .page-title {
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--text-dark);
            margin: 0 0 1rem 0;
            background: linear-gradient(135deg, var(--primary-orange), #FF8F42);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .page-subtitle {
            color: var(--text-gray);
            font-size: 1.2rem;
            margin: 0;
            line-height: 1.6;
        }

        /* Statistics Overview */
        .stats-overview {
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
            transform: translateY(-4px);
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
        .stat-icon.recent { background: linear-gradient(135deg, var(--info-blue), #3182CE); }
        .stat-icon.pending { background: linear-gradient(135deg, var(--warning-yellow), #D69E2E); }

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

        /* Report Form */
        .report-form-card {
            background: var(--card-white);
            border-radius: 20px;
            padding: 2.5rem;
            box-shadow: var(--shadow-card);
            border: 1px solid rgba(255, 107, 0, 0.1);
            position: relative;
            overflow: hidden;
        }

        .report-form-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, var(--success-green), #38A169);
        }

        .form-header {
            text-align: center;
            margin-bottom: 2rem;
        }

        .form-icon {
            width: 64px;
            height: 64px;
            border-radius: 16px;
            background: linear-gradient(135deg, var(--success-green), #38A169);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            margin: 0 auto 1rem auto;
            box-shadow: 0 8px 20px rgba(72, 187, 120, 0.3);
        }

        .form-title {
            font-size: 1.75rem;
            font-weight: 600;
            color: var(--text-dark);
            margin: 0 0 0.5rem 0;
        }

        .form-description {
            color: var(--text-gray);
            font-size: 1rem;
            margin: 0;
        }

        /* Form Layout */
        .date-form {
            display: grid;
            gap: 2rem;
        }

        .date-inputs-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 2rem;
            margin-bottom: 2rem;
        }

        .form-group {
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
        }

        .form-label {
            font-size: 1rem;
            font-weight: 600;
            color: var(--text-dark);
            margin: 0;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .form-label i {
            color: var(--primary-orange);
            font-size: 0.875rem;
        }

        .date-input-wrapper {
            position: relative;
        }

        .date-input {
            width: 100%;
            padding: 1rem 1.25rem;
            border: 2px solid rgba(255, 107, 0, 0.1);
            border-radius: 12px;
            background: var(--card-white);
            font-size: 1rem;
            font-weight: 500;
            color: var(--text-dark);
            transition: all 0.3s ease;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        }

        .date-input:focus {
            outline: none;
            border-color: var(--primary-orange);
            box-shadow: 0 0 0 4px rgba(255, 107, 0, 0.1), 0 4px 8px rgba(0, 0, 0, 0.1);
            transform: translateY(-2px);
        }

        .date-input:hover {
            border-color: rgba(255, 107, 0, 0.2);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        /* Submit Button */
        .submit-section {
            text-align: center;
            padding-top: 1rem;
            border-top: 2px solid rgba(255, 107, 0, 0.1);
        }

        .submit-btn {
            background: linear-gradient(135deg, var(--primary-orange), #FF8F42);
            color: white;
            border: none;
            border-radius: 12px;
            padding: 1rem 3rem;
            font-size: 1.1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 12px rgba(255, 107, 0, 0.3);
            display: inline-flex;
            align-items: center;
            gap: 0.75rem;
            text-transform: none;
            min-width: 200px;
            justify-content: center;
        }

        .submit-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(255, 107, 0, 0.4);
            background: linear-gradient(135deg, #FF8F42, var(--primary-orange));
        }

        .submit-btn:active {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(255, 107, 0, 0.3);
        }

        .submit-btn i {
            font-size: 1.2rem;
        }

        /* Quick Actions */
        .quick-actions {
            background: rgba(255, 107, 0, 0.05);
            border: 1px solid rgba(255, 107, 0, 0.1);
            border-radius: 16px;
            padding: 1.5rem;
            margin-bottom: 2rem;
        }

        .quick-actions-header {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            margin-bottom: 1rem;
        }

        .quick-actions-title {
            font-size: 1.125rem;
            font-weight: 600;
            color: var(--text-dark);
            margin: 0;
        }

        .quick-actions-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 0.75rem;
        }

        .quick-action-btn {
            background: var(--card-white);
            border: 1px solid rgba(255, 107, 0, 0.2);
            border-radius: 8px;
            padding: 0.75rem 1rem;
            font-size: 0.875rem;
            font-weight: 500;
            color: var(--text-dark);
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            justify-content: center;
            text-decoration: none;
        }

        .quick-action-btn:hover {
            background: rgba(255, 107, 0, 0.1);
            border-color: var(--primary-orange);
            color: var(--primary-orange);
            text-decoration: none;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(255, 107, 0, 0.2);
        }

        .quick-action-btn i {
            color: var(--primary-orange);
        }

        /* Tips Section */
        .tips-card {
            background: linear-gradient(135deg, rgba(66, 153, 225, 0.1), rgba(66, 153, 225, 0.05));
            border: 1px solid rgba(66, 153, 225, 0.2);
            border-radius: 16px;
            padding: 1.5rem;
            margin-bottom: 2rem;
        }

        .tips-header {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            margin-bottom: 1rem;
        }

        .tips-icon {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            background: var(--info-blue);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
        }

        .tips-title {
            font-size: 1.125rem;
            font-weight: 600;
            color: var(--text-dark);
            margin: 0;
        }

        .tips-list {
            list-style: none;
            padding: 0;
            margin: 0;
            display: grid;
            gap: 0.75rem;
        }

        .tips-list li {
            display: flex;
            align-items: flex-start;
            gap: 0.75rem;
            font-size: 0.875rem;
            color: var(--text-gray);
            line-height: 1.5;
        }

        .tips-list li i {
            color: var(--info-blue);
            margin-top: 0.125rem;
            flex-shrink: 0;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .main-content {
                padding: 1rem;
            }
            
            .page-header {
                padding: 2rem 1.5rem;
            }
            
            .page-title {
                font-size: 2rem;
            }
            
            .date-inputs-grid {
                grid-template-columns: 1fr;
                gap: 1.5rem;
            }
            
            .stats-overview {
                grid-template-columns: 1fr;
            }
            
            .quick-actions-grid {
                grid-template-columns: 1fr;
            }
            
            .submit-btn {
                padding: 1rem 2rem;
                font-size: 1rem;
                min-width: auto;
                width: 100%;
            }
        }

        @media (max-width: 480px) {
            .report-form-card {
                padding: 1.5rem;
            }
            
            .form-icon {
                width: 48px;
                height: 48px;
                font-size: 20px;
            }
            
            .form-title {
                font-size: 1.5rem;
            }
        }

        /* Animation classes */
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
    </style>
</head>
<body>
    <div id="page-container" class="sidebar-o sidebar-inverse side-scroll page-header-fixed main-content-narrow">
        <?php include_once('includes/sidebar.php');?>
        <?php include_once('includes/header.php');?>

        <main id="main-container">
            <div class="content main-content">
                <!-- Page Header -->
                <div class="page-header fade-in">
                    <div class="header-icon">
                        <i class="fas fa-chart-bar"></i>
                    </div>
                    <h1 class="page-title">Candidates Between Dates Report</h1>
                    <p class="page-subtitle">Generate comprehensive reports of job seeker registrations within your specified date range</p>
                </div>

                <!-- Statistics Overview -->
                <div class="stats-overview fade-in">
                    <?php
                    // Get overall statistics
                    $sql_total = "SELECT COUNT(*) as count FROM tbljobseekers";
                    $query_total = $dbh->prepare($sql_total);
                    $query_total->execute();
                    $total_candidates = $query_total->fetch(PDO::FETCH_OBJ)->count;

                    $sql_active = "SELECT COUNT(*) as count FROM tbljobseekers WHERE IsActive = 1";
                    $query_active = $dbh->prepare($sql_active);
                    $query_active->execute();
                    $active_candidates = $query_active->fetch(PDO::FETCH_OBJ)->count;

                    $sql_recent = "SELECT COUNT(*) as count FROM tbljobseekers WHERE date(RegDate) >= DATE_SUB(CURDATE(), INTERVAL 30 DAY)";
                    $query_recent = $dbh->prepare($sql_recent);
                    $query_recent->execute();
                    $recent_candidates = $query_recent->fetch(PDO::FETCH_OBJ)->count;

                    $sql_pending = "SELECT COUNT(*) as count FROM tbljobseekers WHERE (IsActive = 0 OR IsActive IS NULL)";
                    $query_pending = $dbh->prepare($sql_pending);
                    $query_pending->execute();
                    $pending_candidates = $query_pending->fetch(PDO::FETCH_OBJ)->count;
                    ?>
                    
                    <div class="stat-card">
                        <div class="stat-icon total">
                            <i class="fas fa-users"></i>
                        </div>
                        <div class="stat-content">
                            <h3><?php echo number_format($total_candidates); ?></h3>
                            <p>Total Candidates</p>
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon active">
                            <i class="fas fa-user-check"></i>
                        </div>
                        <div class="stat-content">
                            <h3><?php echo number_format($active_candidates); ?></h3>
                            <p>Active Candidates</p>
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon recent">
                            <i class="fas fa-user-plus"></i>
                        </div>
                        <div class="stat-content">
                            <h3><?php echo number_format($recent_candidates); ?></h3>
                            <p>Recent (30 Days)</p>
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon pending">
                            <i class="fas fa-user-clock"></i>
                        </div>
                        <div class="stat-content">
                            <h3><?php echo number_format($pending_candidates); ?></h3>
                            <p>Pending Verification</p>
                        </div>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="quick-actions fade-in">
                    <div class="quick-actions-header">
                        <i class="fas fa-bolt" style="color: var(--primary-orange);"></i>
                        <h3 class="quick-actions-title">Quick Date Selections</h3>
                    </div>
                    <div class="quick-actions-grid">
                        <button type="button" class="quick-action-btn" onclick="setDateRange('today')">
                            <i class="fas fa-calendar-day"></i>
                            Today
                        </button>
                        <button type="button" class="quick-action-btn" onclick="setDateRange('yesterday')">
                            <i class="fas fa-calendar-minus"></i>
                            Yesterday
                        </button>
                        <button type="button" class="quick-action-btn" onclick="setDateRange('week')">
                            <i class="fas fa-calendar-week"></i>
                            This Week
                        </button>
                        <button type="button" class="quick-action-btn" onclick="setDateRange('month')">
                            <i class="fas fa-calendar-alt"></i>
                            This Month
                        </button>
                        <button type="button" class="quick-action-btn" onclick="setDateRange('quarter')">
                            <i class="fas fa-calendar"></i>
                            This Quarter
                        </button>
                        <button type="button" class="quick-action-btn" onclick="setDateRange('year')">
                            <i class="fas fa-calendar-year"></i>
                            This Year
                        </button>
                    </div>
                </div>

                <!-- Report Form -->
                <div class="report-form-card fade-in">
                    <div class="form-header">
                        <div class="form-icon">
                            <i class="fas fa-calendar-check"></i>
                        </div>
                        <h2 class="form-title">Select Date Range</h2>
                        <p class="form-description">Choose the start and end dates to generate your candidates report</p>
                    </div>

                    <form method="post" name="bwdatesreport" action="candidates-bwdates-reports-details.php" class="date-form">
                        <div class="date-inputs-grid">
                            <div class="form-group">
                                <label class="form-label" for="fromdate">
                                    <i class="fas fa-calendar-plus"></i>
                                    From Date
                                </label>
                                <div class="date-input-wrapper">
                                    <input type="date" 
                                           class="date-input" 
                                           id="fromdate" 
                                           name="fromdate" 
                                           value="" 
                                           required 
                                           max="<?php echo date('Y-m-d'); ?>">
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label class="form-label" for="todate">
                                    <i class="fas fa-calendar-minus"></i>
                                    To Date
                                </label>
                                <div class="date-input-wrapper">
                                    <input type="date" 
                                           class="date-input" 
                                           id="todate" 
                                           name="todate" 
                                           value="" 
                                           required 
                                           max="<?php echo date('Y-m-d'); ?>">
                                </div>
                            </div>
                        </div>

                        <div class="submit-section">
                            <button type="submit" class="submit-btn" name="submit">
                                <i class="fas fa-chart-line"></i>
                                Generate Report
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Tips Section -->
                <div class="tips-card fade-in">
                    <div class="tips-header">
                        <div class="tips-icon">
                            <i class="fas fa-lightbulb"></i>
                        </div>
                        <h3 class="tips-title">Report Generation Tips</h3>
                    </div>
                    <ul class="tips-list">
                        <li>
                            <i class="fas fa-check"></i>
                            The report will include all candidates who registered between your selected dates
                        </li>
                        <li>
                            <i class="fas fa-check"></i>
                            You can filter results by status (Active/Inactive) in the generated report
                        </li>
                        <li>
                            <i class="fas fa-check"></i>
                            Export options are available for PDF, Excel, and Print formats
                        </li>
                        <li>
                            <i class="fas fa-check"></i>
                            Use quick date selections above for common reporting periods
                        </li>
                        <li>
                            <i class="fas fa-check"></i>
                            Large date ranges may take longer to process - consider smaller ranges for faster results
                        </li>
                    </ul>
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
        // Quick date range setting functionality
        function setDateRange(period) {
            const fromDate = document.getElementById('fromdate');
            const toDate = document.getElementById('todate');
            const today = new Date();
            
            let startDate, endDate;
            
            switch(period) {
                case 'today':
                    startDate = endDate = today;
                    break;
                case 'yesterday':
                    startDate = endDate = new Date(today.getTime() - 24 * 60 * 60 * 1000);
                    break;
                case 'week':
                    const firstDayOfWeek = new Date(today.setDate(today.getDate() - today.getDay()));
                    startDate = firstDayOfWeek;
                    endDate = new Date();
                    break;
                case 'month':
                    startDate = new Date(today.getFullYear(), today.getMonth(), 1);
                    endDate = new Date();
                    break;
                case 'quarter':
                    const quarter = Math.floor(today.getMonth() / 3);
                    startDate = new Date(today.getFullYear(), quarter * 3, 1);
                    endDate = new Date();
                    break;
                case 'year':
                    startDate = new Date(today.getFullYear(), 0, 1);
                    endDate = new Date();
                    break;
            }
            
            fromDate.value = startDate.toISOString().split('T')[0];
            toDate.value = endDate.toISOString().split('T')[0];
            
            // Add visual feedback
            fromDate.style.transform = 'scale(1.02)';
            toDate.style.transform = 'scale(1.02)';
            setTimeout(() => {
                fromDate.style.transform = '';
                toDate.style.transform = '';
            }, 200);
        }

        // Form validation
        document.querySelector('form[name="bwdatesreport"]').addEventListener('submit', function(e) {
            const fromDate = document.getElementById('fromdate').value;
            const toDate = document.getElementById('todate').value;
            
            if (!fromDate || !toDate) {
                e.preventDefault();
                alert('Please select both from and to dates.');
                return false;
            }
            
            if (new Date(fromDate) > new Date(toDate)) {
                e.preventDefault();
                alert('From date cannot be later than to date.');
                return false;
            }
            
            // Show loading state
            const submitBtn = this.querySelector('.submit-btn');
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Generating Report...';
            submitBtn.disabled = true;
        });

        // Auto-adjust "to date" when "from date" changes
        document.getElementById('fromdate').addEventListener('change', function() {
            const fromDate = this.value;
            const toDate = document.getElementById('todate');
            
            if (fromDate && !toDate.value) {
                toDate.value = fromDate;
            } else if (fromDate && toDate.value && new Date(fromDate) > new Date(toDate.value)) {
                toDate.value = fromDate;
            }
        });

        // Fade in animations on scroll
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver(function(entries) {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }
            });
        }, observerOptions);

        // Observe all fade-in elements
        document.querySelectorAll('.fade-in').forEach(el => {
            el.style.opacity = '0';
            el.style.transform = 'translateY(20px)';
            el.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
            observer.observe(el);
        });

        // Set max date to today for both inputs
        const maxDate = new Date().toISOString().split('T')[0];
        document.getElementById('fromdate').setAttribute('max', maxDate);
        document.getElementById('todate').setAttribute('max', maxDate);

        // Add hover effects to form inputs
        document.querySelectorAll('.date-input').forEach(input => {
            input.addEventListener('focus', function() {
                this.parentElement.style.transform = 'translateY(-2px)';
            });
            
            input.addEventListener('blur', function() {
                this.parentElement.style.transform = '';
            });
        });
    </script>
</body>
</html>
<?php }  ?>

<!-- Done 8 -->