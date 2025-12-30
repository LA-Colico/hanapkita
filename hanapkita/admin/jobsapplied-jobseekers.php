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
    <title>Hanap-Kita - Job Applications</title>
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
            font-size: 1.75rem;
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
            font-size: 1rem;
            margin: 0;
        }

        .applicant-info {
            background: rgba(255, 107, 0, 0.05);
            border: 1px solid rgba(255, 107, 0, 0.2);
            border-radius: 12px;
            padding: 1rem 1.5rem;
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .applicant-avatar {
            width: 48px;
            height: 48px;
            border-radius: 50%;
            background: var(--primary-orange);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 1.125rem;
        }

        .applicant-details h3 {
            font-size: 1.125rem;
            font-weight: 600;
            color: var(--text-dark);
            margin: 0;
        }

        .applicant-details p {
            font-size: 0.875rem;
            color: var(--text-gray);
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
        .stat-icon.hired { background: linear-gradient(135deg, var(--success-green), #38A169); }
        .stat-icon.pending { background: linear-gradient(135deg, var(--warning-yellow), #D69E2E); }
        .stat-icon.shortlisted { background: linear-gradient(135deg, var(--info-blue), #3182CE); }

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

        /* Applications List */
        .applications-card {
            background: var(--card-white);
            border-radius: 20px;
            padding: 2rem;
            box-shadow: var(--shadow-card);
            border: 1px solid rgba(255, 107, 0, 0.1);
        }

        .applications-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
            padding-bottom: 1rem;
            border-bottom: 2px solid rgba(255, 107, 0, 0.1);
        }

        .applications-title {
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
        .applications-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
            gap: 1.5rem;
        }

        .application-card {
            background: rgba(255, 107, 0, 0.02);
            border: 1px solid rgba(255, 107, 0, 0.1);
            border-radius: 16px;
            padding: 1.5rem;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .application-card:hover {
            background: rgba(255, 107, 0, 0.05);
            transform: translateY(-4px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
        }

        .application-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: linear-gradient(90deg, var(--primary-orange), #FF8F42);
        }

        .application-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 1rem;
        }

        .job-info h3 {
            font-size: 1.125rem;
            font-weight: 600;
            color: var(--text-dark);
            margin: 0 0 0.25rem 0;
        }

        .job-category {
            font-size: 0.875rem;
            color: var(--info-blue);
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

        .status-hired { background: rgba(72, 187, 120, 0.1); color: var(--success-green); }
        .status-pending { background: rgba(246, 224, 94, 0.2); color: #D69E2E; }
        .status-shortlisted { background: rgba(66, 153, 225, 0.1); color: var(--info-blue); }
        .status-null { background: rgba(113, 128, 150, 0.1); color: var(--text-gray); }

        .application-details {
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
            margin-bottom: 1rem;
        }

        .application-detail-row {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.875rem;
            color: var(--text-gray);
        }

        .application-detail-row i {
            color: var(--primary-orange);
            width: 16px;
            text-align: center;
        }

        /* Table View */
        .applications-table-container {
            overflow-x: auto;
            border-radius: 12px;
            border: 1px solid rgba(255, 107, 0, 0.1);
        }

        .applications-table {
            width: 100%;
            border-collapse: collapse;
            background: var(--card-white);
        }

        .applications-table th {
            background: linear-gradient(135deg, rgba(255, 107, 0, 0.1), rgba(255, 107, 0, 0.05));
            color: var(--text-dark);
            font-weight: 600;
            padding: 1rem;
            text-align: left;
            font-size: 0.875rem;
            border-bottom: 2px solid rgba(255, 107, 0, 0.1);
        }

        .applications-table td {
            padding: 1rem;
            border-bottom: 1px solid rgba(255, 107, 0, 0.05);
            font-size: 0.875rem;
            vertical-align: middle;
        }

        .applications-table tr:hover {
            background: rgba(255, 107, 0, 0.02);
        }

        .job-cell {
            font-weight: 600;
            color: var(--text-dark);
        }

        .category-cell {
            color: var(--info-blue);
        }

        .company-cell {
            color: var(--text-gray);
        }

        .date-cell {
            color: var(--text-gray);
            font-size: 0.8rem;
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

        /* Quick Actions */
        .quick-actions {
            background: rgba(72, 187, 120, 0.05);
            border: 1px solid rgba(72, 187, 120, 0.2);
            border-radius: 12px;
            padding: 1rem;
            margin-bottom: 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .quick-actions-info {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .quick-actions-icon {
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

        .quick-actions-text h4 {
            font-size: 1rem;
            font-weight: 600;
            color: var(--text-dark);
            margin: 0;
        }

        .quick-actions-text p {
            font-size: 0.875rem;
            color: var(--text-gray);
            margin: 0;
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

        /* Responsive Design */
        @media (max-width: 768px) {
            .main-content { padding: 1rem; }
            .header-content { flex-direction: column; gap: 1rem; }
            .applications-grid { grid-template-columns: 1fr; }
            .view-toggle { display: none; }
            .quick-actions { flex-direction: column; gap: 1rem; text-align: center; }
            .applicant-info { flex-direction: column; text-align: center; }
        }

        @media (max-width: 480px) {
            .application-card { padding: 1rem; }
            .applications-table-container { font-size: 0.8rem; }
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
                                <i class="fas fa-file-alt"></i>
                            </div>
                            <div class="header-text">
                                <h1>Job Applications</h1>
                                <p>View all job applications submitted by <?php echo htmlentities($_GET['jsname'] ?? 'this candidate'); ?></p>
                            </div>
                        </div>
                        <div class="applicant-info">
                            <div class="applicant-avatar">
                                <?php 
                                $jsname = $_GET['jsname'] ?? 'User';
                                echo strtoupper(substr($jsname, 0, 2)); 
                                ?>
                            </div>
                            <div class="applicant-details">
                                <h3><?php echo htmlentities($_GET['jsname'] ?? 'Job Seeker'); ?></h3>
                                <p>Job Seeker Profile</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Statistics Cards -->
                <div class="stats-grid">
                    <?php
                    $jsid = intval($_GET['jobsid']);
                    
                    // Get statistics
                    $sql_total = "SELECT COUNT(*) as count FROM tblapplyjob WHERE UserId = :jsid";
                    $query_total = $dbh->prepare($sql_total);
                    $query_total->bindParam(':jsid', $jsid, PDO::PARAM_INT);
                    $query_total->execute();
                    $total_applications = $query_total->fetch(PDO::FETCH_OBJ)->count;

                    $sql_hired = "SELECT COUNT(*) as count FROM tblapplyjob WHERE UserId = :jsid AND Status = 'Hired'";
                    $query_hired = $dbh->prepare($sql_hired);
                    $query_hired->bindParam(':jsid', $jsid, PDO::PARAM_INT);
                    $query_hired->execute();
                    $hired_applications = $query_hired->fetch(PDO::FETCH_OBJ)->count;

                    $sql_pending = "SELECT COUNT(*) as count FROM tblapplyjob WHERE UserId = :jsid AND (Status IS NULL OR Status = '')";
                    $query_pending = $dbh->prepare($sql_pending);
                    $query_pending->bindParam(':jsid', $jsid, PDO::PARAM_INT);
                    $query_pending->execute();
                    $pending_applications = $query_pending->fetch(PDO::FETCH_OBJ)->count;

                    $sql_shortlisted = "SELECT COUNT(*) as count FROM tblapplyjob WHERE UserId = :jsid AND Status = 'Sort Listed'";
                    $query_shortlisted = $dbh->prepare($sql_shortlisted);
                    $query_shortlisted->bindParam(':jsid', $jsid, PDO::PARAM_INT);
                    $query_shortlisted->execute();
                    $shortlisted_applications = $query_shortlisted->fetch(PDO::FETCH_OBJ)->count;
                    ?>
                    
                    <div class="stat-card">
                        <div class="stat-icon total">
                            <i class="fas fa-file-alt"></i>
                        </div>
                        <div class="stat-content">
                            <h3><?php echo $total_applications; ?></h3>
                            <p>Total Applications</p>
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon hired">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <div class="stat-content">
                            <h3><?php echo $hired_applications; ?></h3>
                            <p>Hired</p>
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon pending">
                            <i class="fas fa-clock"></i>
                        </div>
                        <div class="stat-content">
                            <h3><?php echo $pending_applications; ?></h3>
                            <p>Pending Review</p>
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon shortlisted">
                            <i class="fas fa-star"></i>
                        </div>
                        <div class="stat-content">
                            <h3><?php echo $shortlisted_applications; ?></h3>
                            <p>Shortlisted</p>
                        </div>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="quick-actions">
                    <div class="quick-actions-info">
                        <div class="quick-actions-icon">
                            <i class="fas fa-user"></i>
                        </div>
                        <div class="quick-actions-text">
                            <h4>View Candidate Profile</h4>
                            <p>Access detailed information about this job seeker</p>
                        </div>
                    </div>
                    <a href="view-jobseeker-details.php?viewid=<?php echo htmlentities($jsid); ?>" class="filter-btn btn-secondary" target="_blank">
                        <i class="fas fa-external-link-alt"></i>
                        View Profile
                    </a>
                </div>

                <!-- Applications List -->
                <div class="applications-card">
                    <div class="applications-header">
                        <h2 class="applications-title">
                            Application History
                            <?php if ($total_applications > 0): ?>
                                <span style="color: var(--primary-orange); font-size: 1rem;">(<?php echo $total_applications; ?> applications)</span>
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
                    $sql="SELECT tbljobseekers.FullName,tbljobs.jobTitle,tbljobs.jobCategory,tblapplyjob.Applydate,tblapplyjob.Status,tblemployers.CompnayName from tblapplyjob
join tbljobseekers on tbljobseekers.id=tblapplyjob.UserId
join tbljobs on tbljobs.jobId=tblapplyjob.JobId
join tblemployers on tblemployers.id=tbljobs.employerId
where tblapplyjob.UserId='$jsid'";
                    $query = $dbh->prepare($sql);
                    $query->execute();
                    $results = $query->fetchAll(PDO::FETCH_OBJ);

                    if(empty($results)) {
                    ?>
                        <div class="empty-state">
                            <i class="fas fa-clipboard-list"></i>
                            <h3>No Applications Found</h3>
                            <p>This candidate hasn't applied for any jobs yet.</p>
                        </div>
                    <?php
                    } else {
                    ?>

                    <!-- Cards View -->
                    <div class="applications-grid" id="cardsView">
                        <?php
                        foreach($results as $row) {
                            $status_class = 'status-null';
                            $status_text = 'Under Review';
                            
                            if ($row->Status == 'Hired') {
                                $status_class = 'status-hired';
                                $status_text = 'Hired';
                            } elseif ($row->Status == 'Sort Listed') {
                                $status_class = 'status-shortlisted';
                                $status_text = 'Shortlisted';
                            } elseif (!empty($row->Status)) {
                                $status_class = 'status-pending';
                                $status_text = $row->Status;
                            }
                        ?>
                        <div class="application-card">
                            <div class="application-header">
                                <div class="job-info">
                                    <h3><?php echo htmlentities($row->jobTitle); ?></h3>
                                    <p class="job-category"><?php echo htmlentities($row->jobCategory); ?></p>
                                </div>
                                <span class="status-badge <?php echo $status_class; ?>">
                                    <?php echo $status_text; ?>
                                </span>
                            </div>
                            
                            <div class="application-details">
                                <div class="application-detail-row">
                                    <i class="fas fa-building"></i>
                                    <span><?php echo htmlentities($row->CompnayName); ?></span>
                                </div>
                                <div class="application-detail-row">
                                    <i class="fas fa-calendar-alt"></i>
                                    <span>Applied: <?php echo date('M j, Y g:i A', strtotime($row->Applydate)); ?></span>
                                </div>
                                <div class="application-detail-row">
                                    <i class="fas fa-user"></i>
                                    <span>Applicant: <?php echo htmlentities($row->FullName); ?></span>
                                </div>
                            </div>
                        </div>
                        <?php } ?>
                    </div>

                    <!-- Table View -->
                    <div class="applications-table-container" id="tableView" style="display: none;">
                        <table class="applications-table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Full Name</th>
                                    <th>Job Title</th>
                                    <th>Job Category</th>
                                    <th>Company Name</th>
                                    <th>Applied Date</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $cnt = 1;
                                foreach($results as $row) {
                                    $status_class = 'status-null';
                                    $status_text = 'Under Review';
                                    
                                    if ($row->Status == 'Hired') {
                                        $status_class = 'status-hired';
                                        $status_text = 'Hired';
                                    } elseif ($row->Status == 'Sort Listed') {
                                        $status_class = 'status-shortlisted';
                                        $status_text = 'Shortlisted';
                                    } elseif (!empty($row->Status)) {
                                        $status_class = 'status-pending';
                                        $status_text = $row->Status;
                                    }
                                ?>
                                <tr>
                                    <td><?php echo $cnt; ?></td>
                                    <td class="job-cell"><?php echo htmlentities($row->FullName); ?></td>
                                    <td class="job-cell"><?php echo htmlentities($row->jobTitle); ?></td>
                                    <td class="category-cell"><?php echo htmlentities($row->jobCategory); ?></td>
                                    <td class="company-cell"><?php echo htmlentities($row->CompnayName); ?></td>
                                    <td class="date-cell"><?php echo date('M j, Y g:i A', strtotime($row->Applydate)); ?></td>
                                    <td>
                                        <span class="status-badge <?php echo $status_class; ?>">
                                            <?php echo $status_text; ?>
                                        </span>
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
                localStorage.setItem('applicationsViewPreference', 'cards');
            } else {
                cardsView.style.display = 'none';
                tableView.style.display = 'block';
                tableBtn.classList.add('active');
                cardsBtn.classList.remove('active');
                localStorage.setItem('applicationsViewPreference', 'table');
            }
        }

        // Load saved view preference
        document.addEventListener('DOMContentLoaded', function() {
            const savedView = localStorage.getItem('applicationsViewPreference') || 'cards';
            switchView(savedView);
        });

        // Add smooth animations
        document.querySelectorAll('.application-card').forEach((card, index) => {
            card.style.animationDelay = `${index * 0.1}s`;
            card.style.animation = 'fadeInUp 0.6s ease-out forwards';
        });

        // CSS for animations
        const style = document.createElement('style');
        style.textContent = `
            @keyframes fadeInUp {
                from {
                    opacity: 0;
                    transform: translateY(20px);
                }
                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }
            
            .application-card {
                opacity: 0;
            }
        `;
        document.head.appendChild(style);
    </script>
</body>
</html>
<?php }  ?>

<!-- Done 19 -->