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
    <title>Hanap-Kita - Listed Jobs</title>
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
            border-radius: 16px;
            padding: 2rem;
            margin-bottom: 2rem;
            box-shadow: var(--shadow-soft);
            border: 1px solid rgba(255, 107, 0, 0.1);
        }

        .header-top {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 1.5rem;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .header-info {
            flex: 1;
            min-width: 300px;
        }

        .page-title {
            font-size: 2rem;
            font-weight: 700;
            color: var(--text-dark);
            margin: 0 0 0.5rem 0;
            background: linear-gradient(135deg, var(--primary-orange), #FF8F42);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .company-name {
            font-size: 1.25rem;
            font-weight: 600;
            color: var(--primary-orange);
            margin: 0 0 0.5rem 0;
        }

        .page-subtitle {
            color: var(--text-gray);
            font-size: 1rem;
            margin: 0;
        }

        .header-actions {
            display: flex;
            gap: 1rem;
            align-items: flex-start;
        }

        .back-btn {
            background: linear-gradient(135deg, var(--primary-orange), #FF8F42);
            color: white;
            border: none;
            border-radius: 12px;
            padding: 12px 24px;
            font-weight: 600;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 8px rgba(255, 107, 0, 0.3);
        }

        .back-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 12px rgba(255, 107, 0, 0.4);
            color: white;
            text-decoration: none;
        }

        .stats-bar {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 1rem;
            padding: 1.5rem 0;
            border-top: 1px solid rgba(255, 107, 0, 0.1);
        }

        .stat-item {
            text-align: center;
        }

        .stat-number {
            font-size: 2rem;
            font-weight: 700;
            color: var(--primary-orange);
            margin: 0;
        }

        .stat-label {
            font-size: 0.875rem;
            color: var(--text-gray);
            margin: 0;
            font-weight: 500;
        }

        .search-filters {
            background: var(--card-white);
            border-radius: 16px;
            padding: 1.5rem;
            margin-bottom: 2rem;
            box-shadow: var(--shadow-soft);
            border: 1px solid rgba(255, 107, 0, 0.1);
        }

        .filters-grid {
            display: grid;
            grid-template-columns: 2fr 1fr 1fr auto;
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
            font-weight: 600;
            color: var(--text-gray);
            margin: 0;
        }

        .filter-input, .filter-select {
            padding: 12px 16px;
            border: 2px solid rgba(255, 107, 0, 0.1);
            border-radius: 12px;
            background: var(--card-white);
            font-size: 14px;
            transition: all 0.3s ease;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        }

        .filter-input:focus, .filter-select:focus {
            outline: none;
            border-color: var(--primary-orange);
            box-shadow: 0 0 0 3px rgba(255, 107, 0, 0.1);
        }

        .filter-btn {
            background: linear-gradient(135deg, var(--primary-orange), #FF8F42);
            color: white;
            border: none;
            border-radius: 12px;
            padding: 12px 20px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 8px rgba(255, 107, 0, 0.3);
        }

        .filter-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 12px rgba(255, 107, 0, 0.4);
        }

        .jobs-container {
            background: var(--card-white);
            border-radius: 16px;
            box-shadow: var(--shadow-soft);
            border: 1px solid rgba(255, 107, 0, 0.1);
            overflow: hidden;
        }

        .container-header {
            padding: 1.5rem 2rem;
            border-bottom: 1px solid rgba(255, 107, 0, 0.1);
            background: linear-gradient(135deg, rgba(255, 107, 0, 0.05), rgba(255, 143, 66, 0.05));
        }

        .container-title {
            font-size: 1.25rem;
            font-weight: 600;
            color: var(--text-dark);
            margin: 0;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .title-icon {
            width: 32px;
            height: 32px;
            border-radius: 8px;
            background: linear-gradient(135deg, var(--primary-orange), #FF8F42);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 14px;
        }

        .jobs-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(400px, 1fr));
            gap: 1.5rem;
            padding: 2rem;
        }

        .job-card {
            background: var(--card-white);
            border: 2px solid rgba(255, 107, 0, 0.1);
            border-radius: 16px;
            padding: 1.5rem;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .job-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, var(--primary-orange), #FF8F42);
            border-radius: 16px 16px 0 0;
        }

        .job-card:hover {
            transform: translateY(-4px);
            box-shadow: var(--shadow-card);
            border-color: var(--primary-orange);
        }

        .job-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 1rem;
            gap: 1rem;
        }

        .job-title {
            font-size: 1.125rem;
            font-weight: 600;
            color: var(--text-dark);
            margin: 0 0 0.25rem 0;
            line-height: 1.3;
        }

        .job-category {
            font-size: 0.875rem;
            color: var(--text-gray);
            margin: 0;
        }

        .job-type-badge {
            background: linear-gradient(135deg, var(--primary-orange), #FF8F42);
            color: white;
            padding: 6px 12px;
            border-radius: 8px;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            flex-shrink: 0;
        }

        .job-details {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
            margin-bottom: 1rem;
        }

        .job-detail-item {
            display: flex;
            flex-direction: column;
            gap: 0.25rem;
        }

        .detail-label {
            font-size: 0.75rem;
            color: var(--text-gray);
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .detail-value {
            font-size: 0.875rem;
            color: var(--text-dark);
            font-weight: 500;
        }

        .salary-highlight {
            color: var(--success-green);
            font-weight: 600;
        }

        .job-skills {
            margin-bottom: 1rem;
        }

        .skills-container {
            display: flex;
            flex-wrap: wrap;
            gap: 0.5rem;
            margin-top: 0.5rem;
        }

        .skill-tag {
            background: rgba(255, 107, 0, 0.1);
            color: var(--primary-orange);
            padding: 4px 8px;
            border-radius: 6px;
            font-size: 0.75rem;
            font-weight: 500;
        }

        .job-location {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            color: var(--text-gray);
            font-size: 0.875rem;
            margin-bottom: 1rem;
        }

        .location-icon {
            color: var(--primary-orange);
        }

        .job-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-top: 1rem;
            border-top: 1px solid rgba(255, 107, 0, 0.1);
        }

        .job-date {
            font-size: 0.75rem;
            color: var(--text-gray);
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .view-job-btn {
            background: rgba(255, 107, 0, 0.1);
            color: var(--primary-orange);
            border: none;
            border-radius: 8px;
            padding: 8px 16px;
            font-size: 0.875rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
        }

        .view-job-btn:hover {
            background: var(--primary-orange);
            color: white;
            transform: translateY(-1px);
            text-decoration: none;
        }

        .empty-state {
            text-align: center;
            padding: 4rem 2rem;
        }

        .empty-icon {
            width: 80px;
            height: 80px;
            margin: 0 auto 1.5rem;
            background: rgba(255, 107, 0, 0.1);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            color: var(--primary-orange);
        }

        .empty-title {
            font-size: 1.5rem;
            font-weight: 600;
            color: var(--text-dark);
            margin: 0 0 0.5rem 0;
        }

        .empty-message {
            color: var(--text-gray);
            font-size: 1rem;
            margin: 0;
        }

        /* Responsive Design */
        @media (max-width: 1024px) {
            .jobs-grid {
                grid-template-columns: 1fr;
            }

            .filters-grid {
                grid-template-columns: 1fr;
                gap: 1rem;
            }
        }

        @media (max-width: 768px) {
            .main-content {
                padding: 1rem;
            }

            .page-header {
                padding: 1.5rem;
            }

            .header-top {
                flex-direction: column;
                align-items: stretch;
            }

            .stats-bar {
                grid-template-columns: repeat(2, 1fr);
            }

            .job-details {
                grid-template-columns: 1fr;
            }

            .job-footer {
                flex-direction: column;
                gap: 1rem;
                align-items: stretch;
            }
        }

        @media (max-width: 480px) {
            .page-title {
                font-size: 1.5rem;
            }

            .jobs-grid {
                padding: 1rem;
                grid-template-columns: 1fr;
            }

            .job-card {
                padding: 1rem;
            }

            .stats-bar {
                grid-template-columns: 1fr;
            }
        }

        /* DataTable Custom Styles */
        .dataTables_wrapper {
            padding: 0;
        }

        .dataTables_filter {
            margin-bottom: 1rem;
        }

        .dataTables_filter input {
            padding: 8px 12px;
            border: 2px solid rgba(255, 107, 0, 0.1);
            border-radius: 8px;
            margin-left: 0.5rem;
        }

        .dataTables_length select {
            padding: 6px 8px;
            border: 2px solid rgba(255, 107, 0, 0.1);
            border-radius: 6px;
            margin: 0 0.5rem;
        }

        .page-link {
            color: var(--primary-orange);
            border-color: rgba(255, 107, 0, 0.1);
        }

        .page-link:hover {
            background-color: rgba(255, 107, 0, 0.1);
            border-color: var(--primary-orange);
            color: var(--primary-orange);
        }

        .page-item.active .page-link {
            background-color: var(--primary-orange);
            border-color: var(--primary-orange);
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
                    <div class="header-top">
                        <div class="header-info">
                            <h1 class="page-title">Jobs Listed</h1>
                            <h2 class="company-name">by <?php echo htmlentities($_GET['cname']);?></h2>
                            <p class="page-subtitle">Browse all active job postings from this employer</p>
                        </div>
                        <div class="header-actions">
                            <a href="employer-list.php" class="back-btn">
                                <i class="fas fa-arrow-left"></i>
                                Back to Employers
                            </a>
                        </div>
                    </div>

                    <!-- Stats Bar -->
                    <div class="stats-bar">
                        <?php 
                        $compid = intval($_GET['compid']);
                        
                        // Total jobs
                        $sql_total = "SELECT COUNT(*) as total FROM tbljobs WHERE employerId='$compid'";
                        $query_total = $dbh->prepare($sql_total);
                        $query_total->execute();
                        $total_jobs = $query_total->fetch(PDO::FETCH_OBJ)->total;
                        
                        // Active jobs
                        $sql_active = "SELECT COUNT(*) as active FROM tbljobs WHERE employerId='$compid' AND isActive=1";
                        $query_active = $dbh->prepare($sql_active);
                        $query_active->execute();
                        $active_jobs = $query_active->fetch(PDO::FETCH_OBJ)->active;
                        
                        // Job categories
                        $sql_categories = "SELECT COUNT(DISTINCT jobCategory) as categories FROM tbljobs WHERE employerId='$compid'";
                        $query_categories = $dbh->prepare($sql_categories);
                        $query_categories->execute();
                        $job_categories = $query_categories->fetch(PDO::FETCH_OBJ)->categories;
                        
                        // Applications received
                        $sql_apps = "SELECT COUNT(*) as applications FROM tblapplyjob 
                                    JOIN tbljobs ON tbljobs.jobId = tblapplyjob.JobId 
                                    WHERE tbljobs.employerId='$compid'";
                        $query_apps = $dbh->prepare($sql_apps);
                        $query_apps->execute();
                        $applications = $query_apps->fetch(PDO::FETCH_OBJ)->applications;
                        ?>
                        
                        <div class="stat-item">
                            <p class="stat-number"><?php echo $total_jobs; ?></p>
                            <p class="stat-label">Total Jobs</p>
                        </div>
                        <div class="stat-item">
                            <p class="stat-number"><?php echo $active_jobs; ?></p>
                            <p class="stat-label">Active Jobs</p>
                        </div>
                        <div class="stat-item">
                            <p class="stat-number"><?php echo $job_categories; ?></p>
                            <p class="stat-label">Categories</p>
                        </div>
                        <div class="stat-item">
                            <p class="stat-number"><?php echo $applications; ?></p>
                            <p class="stat-label">Applications</p>
                        </div>
                    </div>
                </div>

                <!-- Search and Filters -->
                <div class="search-filters">
                    <div class="filters-grid">
                        <div class="filter-group">
                            <label class="filter-label">Search Jobs</label>
                            <input type="text" class="filter-input" id="jobSearch" placeholder="Search by title, category, or skills...">
                        </div>
                        <div class="filter-group">
                            <label class="filter-label">Job Type</label>
                            <select class="filter-select" id="jobTypeFilter">
                                <option value="">All Types</option>
                                <option value="Full Time">Full Time</option>
                                <option value="Part Time">Part Time</option>
                                <option value="Contract">Contract</option>
                            </select>
                        </div>
                        <div class="filter-group">
                            <label class="filter-label">Category</label>
                            <select class="filter-select" id="categoryFilter">
                                <option value="">All Categories</option>
                                <?php
                                $sql_cat = "SELECT DISTINCT jobCategory FROM tbljobs WHERE employerId='$compid' ORDER BY jobCategory";
                                $query_cat = $dbh->prepare($sql_cat);
                                $query_cat->execute();
                                $categories = $query_cat->fetchAll(PDO::FETCH_OBJ);
                                foreach($categories as $cat) {
                                    echo "<option value='" . htmlentities($cat->jobCategory) . "'>" . htmlentities($cat->jobCategory) . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <button class="filter-btn" onclick="clearFilters()">
                            <i class="fas fa-refresh"></i>
                        </button>
                    </div>
                </div>

                <!-- Jobs Container -->
                <div class="jobs-container">
                    <div class="container-header">
                        <h3 class="container-title">
                            <div class="title-icon">
                                <i class="fas fa-briefcase"></i>
                            </div>
                            Job Listings
                        </h3>
                    </div>

                    <div class="jobs-grid" id="jobsGrid">
                        <?php
                        $emaipid = intval($_GET['compid']);
                        $sql = "SELECT * from tbljobs where employerId='$emaipid' ORDER BY postinDate DESC";
                        $query = $dbh->prepare($sql);
                        $query->execute();
                        $results = $query->fetchAll(PDO::FETCH_OBJ);

                        $cnt = 1;
                        if($query->rowCount() > 0) {
                            foreach($results as $row) {
                        ?>
                        <div class="job-card" data-job-type="<?php echo htmlentities($row->jobType); ?>" 
                             data-category="<?php echo htmlentities($row->jobCategory); ?>"
                             data-title="<?php echo htmlentities($row->jobTitle); ?>"
                             data-skills="<?php echo htmlentities($row->skillsRequired); ?>">
                            
                            <div class="job-header">
                                <div>
                                    <h4 class="job-title"><?php echo htmlentities($row->jobTitle); ?></h4>
                                    <p class="job-category"><?php echo htmlentities($row->jobCategory); ?></p>
                                </div>
                                <div class="job-type-badge"><?php echo htmlentities($row->jobType); ?></div>
                            </div>

                            <div class="job-details">
                                <div class="job-detail-item">
                                    <span class="detail-label">Salary Package</span>
                                    <span class="detail-value salary-highlight">₱<?php echo htmlentities($row->salaryPackage); ?></span>
                                </div>
                                <div class="job-detail-item">
                                    <span class="detail-label">Experience</span>
                                    <span class="detail-value"><?php echo htmlentities($row->experience); ?></span>
                                </div>
                            </div>

                            <?php if(!empty($row->skillsRequired)): ?>
                            <div class="job-skills">
                                <span class="detail-label">Skills Required</span>
                                <div class="skills-container">
                                    <?php 
                                    $skills = explode(',', $row->skillsRequired);
                                    foreach($skills as $skill) {
                                        echo '<span class="skill-tag">' . trim(htmlentities($skill)) . '</span>';
                                    }
                                    ?>
                                </div>
                            </div>
                            <?php endif; ?>

                            <div class="job-location">
                                <i class="fas fa-map-marker-alt location-icon"></i>
                                <span><?php echo htmlentities($row->jobLocation); ?></span>
                            </div>

                            <div class="job-footer">
                                <div class="job-date">
                                    <i class="fas fa-calendar-alt"></i>
                                    <span>Posted <?php echo date('M j, Y', strtotime($row->postinDate)); ?></span>
                                </div>
                                <a href="#" class="view-job-btn" onclick="viewJobDetails(<?php echo $row->jobId; ?>)">
                                    View Details
                                </a>
                            </div>
                        </div>
                        <?php 
                            $cnt = $cnt + 1;
                            }
                        } else {
                        ?>
                        <div class="empty-state">
                            <div class="empty-icon">
                                <i class="fas fa-briefcase"></i>
                            </div>
                            <h3 class="empty-title">No Jobs Found</h3>
                            <p class="empty-message">This employer hasn't posted any jobs yet. Check back later for new opportunities.</p>
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
        // Job search and filter functionality
        document.getElementById('jobSearch').addEventListener('input', filterJobs);
        document.getElementById('jobTypeFilter').addEventListener('change', filterJobs);
        document.getElementById('categoryFilter').addEventListener('change', filterJobs);

        function filterJobs() {
            const searchTerm = document.getElementById('jobSearch').value.toLowerCase();
            const jobType = document.getElementById('jobTypeFilter').value;
            const category = document.getElementById('categoryFilter').value;
            
            const jobCards = document.querySelectorAll('.job-card');
            let visibleCount = 0;

            jobCards.forEach(card => {
                const title = card.dataset.title.toLowerCase();
                const skills = card.dataset.skills.toLowerCase();
                const cardJobType = card.dataset.jobType;
                const cardCategory = card.dataset.category;
                
                const matchesSearch = title.includes(searchTerm) || 
                                    skills.includes(searchTerm) || 
                                    cardCategory.toLowerCase().includes(searchTerm);
                const matchesType = !jobType || cardJobType === jobType;
                const matchesCategory = !category || cardCategory === category;
                
                if (matchesSearch && matchesType && matchesCategory) {
                    card.style.display = 'block';
                    visibleCount++;
                } else {
                    card.style.display = 'none';
                }
            });

            // Show empty state if no jobs match
            const emptyState = document.querySelector('.empty-state');
            if (visibleCount === 0 && !emptyState) {
                showEmptyState('No jobs match your search criteria.');
            } else if (visibleCount > 0 && emptyState) {
                emptyState.remove();
            }
        }

        function clearFilters() {
            document.getElementById('jobSearch').value = '';
            document.getElementById('jobTypeFilter').value = '';
            document.getElementById('categoryFilter').value = '';
            filterJobs();
        }

        function showEmptyState(message) {
            const jobsGrid = document.getElementById('jobsGrid');
            const emptyState = document.createElement('div');
            emptyState.className = 'empty-state';
            emptyState.innerHTML = `
                <div class="empty-icon">
                    <i class="fas fa-search"></i>
                </div>
                <h3 class="empty-title">No Results Found</h3>
                <p class="empty-message">${message}</p>
            `;
            jobsGrid.appendChild(emptyState);
        }

        function viewJobDetails(jobId) {
            // Implementation for viewing job details
            alert('View job details for job ID: ' + jobId);
        }

        // Animate cards on load
        document.addEventListener('DOMContentLoaded', function() {
            const cards = document.querySelectorAll('.job-card');
            cards.forEach((card, index) => {
                card.style.opacity = '0';
                card.style.transform = 'translateY(20px)';
                
                setTimeout(() => {
                    card.style.transition = 'all 0.6s ease';
                    card.style.opacity = '1';
                    card.style.transform = 'translateY(0)';
                }, index * 100);
            });

            // Animate stats numbers
            const statNumbers = document.querySelectorAll('.stat-number');
            statNumbers.forEach(number => {
                const finalValue = parseInt(number.textContent);
                let currentValue = 0;
                const increment = finalValue / 20;
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

<!-- Done 19  View Details Problem --> 