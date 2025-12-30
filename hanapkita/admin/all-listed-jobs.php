<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
if (strlen($_SESSION['jpaid']==0)) {
  header('location:logout.php');
  } else{

// Pagination setup
$limit = 15;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

// Filter setup
$filter_category = isset($_GET['category']) ? $_GET['category'] : 'all';
$filter_type = isset($_GET['type']) ? $_GET['type'] : 'all';
$filter_company = isset($_GET['company']) ? $_GET['company'] : 'all';
$search_term = isset($_GET['search']) ? $_GET['search'] : '';
$sort_by = isset($_GET['sort']) ? $_GET['sort'] : 'newest';

// Build WHERE clause for filters
$where_conditions = [];
$params = [];

if ($filter_category !== 'all') {
    $where_conditions[] = "tbljobs.jobCategory = :category";
    $params[':category'] = $filter_category;
}

if ($filter_type !== 'all') {
    $where_conditions[] = "tbljobs.jobType = :jobtype";
    $params[':jobtype'] = $filter_type;
}

if ($filter_company !== 'all') {
    $where_conditions[] = "tblemployers.id = :company";
    $params[':company'] = $filter_company;
}

if ($search_term) {
    $where_conditions[] = "(tbljobs.jobTitle LIKE :search OR tblemployers.CompnayName LIKE :search OR tbljobs.skillsRequired LIKE :search OR tbljobs.jobLocation LIKE :search)";
    $params[':search'] = "%$search_term%";
}

$where_clause = !empty($where_conditions) ? 'WHERE ' . implode(' AND ', $where_conditions) : '';

// Order clause
$order_clause = '';
switch($sort_by) {
    case 'newest':
        $order_clause = 'ORDER BY tbljobs.postinDate DESC';
        break;
    case 'oldest':
        $order_clause = 'ORDER BY tbljobs.postinDate ASC';
        break;
    case 'company':
        $order_clause = 'ORDER BY tblemployers.CompnayName ASC';
        break;
    case 'title':
        $order_clause = 'ORDER BY tbljobs.jobTitle ASC';
        break;
    case 'category':
        $order_clause = 'ORDER BY tbljobs.jobCategory ASC';
        break;
    default:
        $order_clause = 'ORDER BY tbljobs.postinDate DESC';
}

?>
<!doctype html>
<html lang="en" class="no-focus">
<head>
    <title>Hanap-Kita - All Listed Jobs</title>
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

        /* Jobs List */
        .jobs-card {
            background: var(--card-white);
            border-radius: 20px;
            padding: 2rem;
            box-shadow: var(--shadow-card);
            border: 1px solid rgba(255, 107, 0, 0.1);
        }

        .jobs-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
            padding-bottom: 1rem;
            border-bottom: 2px solid rgba(255, 107, 0, 0.1);
        }

        .jobs-title {
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

        /* Job Cards View */
        .jobs-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
            gap: 1.5rem;
        }

        .job-card {
            background: rgba(255, 107, 0, 0.02);
            border: 1px solid rgba(255, 107, 0, 0.1);
            border-radius: 16px;
            padding: 1.5rem;
            transition: all 0.3s ease;
            cursor: pointer;
            position: relative;
            overflow: hidden;
        }

        .job-card:hover {
            background: rgba(255, 107, 0, 0.05);
            transform: translateY(-4px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
        }

        .job-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: linear-gradient(90deg, var(--primary-orange), #FF8F42);
        }

        .job-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 1rem;
        }

        .job-title {
            font-size: 1.125rem;
            font-weight: 600;
            color: var(--text-dark);
            margin: 0 0 0.25rem 0;
            line-height: 1.3;
        }

        .job-company {
            font-size: 0.875rem;
            color: var(--primary-orange);
            margin: 0;
            font-weight: 500;
        }

        .job-type-badge {
            padding: 0.25rem 0.75rem;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .job-type-full { background: rgba(72, 187, 120, 0.1); color: var(--success-green); }
        .job-type-part { background: rgba(66, 153, 225, 0.1); color: var(--info-blue); }
        .job-type-contract { background: rgba(246, 224, 94, 0.2); color: #D69E2E; }

        .job-details {
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
            margin-bottom: 1rem;
        }

        .job-detail-row {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.875rem;
            color: var(--text-gray);
        }

        .job-detail-row i {
            color: var(--primary-orange);
            width: 16px;
            text-align: center;
        }

        .job-meta {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-top: 1rem;
            border-top: 1px solid rgba(255, 107, 0, 0.1);
        }

        .job-category {
            background: rgba(255, 107, 0, 0.1);
            color: var(--primary-orange);
            padding: 0.25rem 0.75rem;
            border-radius: 12px;
            font-size: 0.75rem;
            font-weight: 500;
        }

        .job-date {
            font-size: 0.75rem;
            color: var(--text-light);
        }

        /* Table View */
        .jobs-table-container {
            overflow-x: auto;
            border-radius: 12px;
            border: 1px solid rgba(255, 107, 0, 0.1);
        }

        .jobs-table {
            width: 100%;
            border-collapse: collapse;
            background: var(--card-white);
        }

        .jobs-table th {
            background: linear-gradient(135deg, rgba(255, 107, 0, 0.1), rgba(255, 107, 0, 0.05));
            color: var(--text-dark);
            font-weight: 600;
            padding: 1rem;
            text-align: left;
            font-size: 0.875rem;
            border-bottom: 2px solid rgba(255, 107, 0, 0.1);
        }

        .jobs-table td {
            padding: 1rem;
            border-bottom: 1px solid rgba(255, 107, 0, 0.05);
            font-size: 0.875rem;
            vertical-align: top;
        }

        .jobs-table tr:hover {
            background: rgba(255, 107, 0, 0.02);
        }

        .company-cell {
            font-weight: 600;
            color: var(--primary-orange);
        }

        .job-title-cell {
            font-weight: 600;
            color: var(--text-dark);
            max-width: 200px;
        }

        .salary-cell {
            font-weight: 600;
            color: var(--success-green);
        }

        .location-cell {
            color: var(--text-gray);
            font-size: 0.8rem;
            max-width: 150px;
            line-height: 1.4;
        }

        .skills-cell {
            color: var(--text-gray);
            font-size: 0.8rem;
            max-width: 180px;
            line-height: 1.4;
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

        /* Responsive Design */
        @media (max-width: 768px) {
            .main-content { padding: 1rem; }
            .header-content { flex-direction: column; gap: 1rem; }
            .header-stats { flex-wrap: wrap; }
            .filters-grid { grid-template-columns: 1fr; }
            .jobs-grid { grid-template-columns: 1fr; }
            .view-toggle { display: none; }
            .pagination-card { flex-direction: column; gap: 1rem; }
        }

        @media (max-width: 480px) {
            .job-card { padding: 1rem; }
            .jobs-table-container { font-size: 0.8rem; }
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
                                <i class="fas fa-briefcase"></i>
                            </div>
                            <div class="header-text">
                                <h1>All Listed Jobs</h1>
                                <p>Comprehensive overview of all job listings across the platform</p>
                            </div>
                        </div>
                        <div class="header-stats">
                            <div class="stat-box">
                                <p class="stat-number">
                                    <?php
                                    $sql_total = "SELECT COUNT(*) as count FROM tbljobs JOIN tblemployers ON tblemployers.id = tbljobs.employerId";
                                    $query_total = $dbh->prepare($sql_total);
                                    $query_total->execute();
                                    echo $query_total->fetch(PDO::FETCH_OBJ)->count;
                                    ?>
                                </p>
                                <p class="stat-label">Total Jobs</p>
                            </div>
                            <div class="stat-box">
                                <p class="stat-number">
                                    <?php
                                    $sql_active = "SELECT COUNT(*) as count FROM tbljobs JOIN tblemployers ON tblemployers.id = tbljobs.employerId WHERE tbljobs.isActive = 1";
                                    $query_active = $dbh->prepare($sql_active);
                                    $query_active->execute();
                                    echo $query_active->fetch(PDO::FETCH_OBJ)->count;
                                    ?>
                                </p>
                                <p class="stat-label">Active</p>
                            </div>
                            <div class="stat-box">
                                <p class="stat-number">
                                    <?php
                                    $sql_today = "SELECT COUNT(*) as count FROM tbljobs JOIN tblemployers ON tblemployers.id = tbljobs.employerId WHERE DATE(tbljobs.postinDate) = CURDATE()";
                                    $query_today = $dbh->prepare($sql_today);
                                    $query_today->execute();
                                    echo $query_today->fetch(PDO::FETCH_OBJ)->count;
                                    ?>
                                </p>
                                <p class="stat-label">Today</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Filters -->
                <div class="filters-card">
                    <div class="filters-header">
                        <h3 class="filters-title">
                            <i class="fas fa-filter"></i>
                            Filter & Search Jobs
                        </h3>
                    </div>
                    <form method="GET" class="filters-grid">
                        <div class="filter-group">
                            <label class="filter-label">Search Jobs</label>
                            <input type="text" name="search" class="filter-input" placeholder="Search by title, company, skills..." value="<?php echo htmlentities($search_term); ?>">
                        </div>
                        <div class="filter-group">
                            <label class="filter-label">Category</label>
                            <select name="category" class="filter-select">
                                <option value="all" <?php echo ($filter_category == 'all') ? 'selected' : ''; ?>>All Categories</option>
                                <?php
                                $sql_categories = "SELECT DISTINCT jobCategory FROM tbljobs WHERE jobCategory IS NOT NULL ORDER BY jobCategory";
                                $query_categories = $dbh->prepare($sql_categories);
                                $query_categories->execute();
                                $categories = $query_categories->fetchAll(PDO::FETCH_OBJ);
                                foreach($categories as $cat) {
                                    $selected = ($filter_category == $cat->jobCategory) ? 'selected' : '';
                                    echo "<option value='" . htmlentities($cat->jobCategory) . "' $selected>" . htmlentities($cat->jobCategory) . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="filter-group">
                            <label class="filter-label">Job Type</label>
                            <select name="type" class="filter-select">
                                <option value="all" <?php echo ($filter_type == 'all') ? 'selected' : ''; ?>>All Types</option>
                                <option value="Full Time" <?php echo ($filter_type == 'Full Time') ? 'selected' : ''; ?>>Full Time</option>
                                <option value="Part Time" <?php echo ($filter_type == 'Part Time') ? 'selected' : ''; ?>>Part Time</option>
                                <option value="Contract" <?php echo ($filter_type == 'Contract') ? 'selected' : ''; ?>>Contract</option>
                            </select>
                        </div>
                        <div class="filter-group">
                            <label class="filter-label">Company</label>
                            <select name="company" class="filter-select">
                                <option value="all" <?php echo ($filter_company == 'all') ? 'selected' : ''; ?>>All Companies</option>
                                <?php
                                $sql_companies = "SELECT DISTINCT e.id, e.CompnayName FROM tblemployers e JOIN tbljobs j ON e.id = j.employerId ORDER BY e.CompnayName";
                                $query_companies = $dbh->prepare($sql_companies);
                                $query_companies->execute();
                                $companies = $query_companies->fetchAll(PDO::FETCH_OBJ);
                                foreach($companies as $comp) {
                                    $selected = ($filter_company == $comp->id) ? 'selected' : '';
                                    echo "<option value='" . $comp->id . "' $selected>" . htmlentities($comp->CompnayName) . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="filter-group">
                            <label class="filter-label">Sort By</label>
                            <select name="sort" class="filter-select">
                                <option value="newest" <?php echo ($sort_by == 'newest') ? 'selected' : ''; ?>>Newest First</option>
                                <option value="oldest" <?php echo ($sort_by == 'oldest') ? 'selected' : ''; ?>>Oldest First</option>
                                <option value="company" <?php echo ($sort_by == 'company') ? 'selected' : ''; ?>>Company A-Z</option>
                                <option value="title" <?php echo ($sort_by == 'title') ? 'selected' : ''; ?>>Job Title A-Z</option>
                                <option value="category" <?php echo ($sort_by == 'category') ? 'selected' : ''; ?>>Category</option>
                            </select>
                        </div>
                        <div class="filter-group">
                            <button type="submit" class="filter-btn btn-primary">
                                <i class="fas fa-search"></i>
                                Apply Filters
                            </button>
                        </div>
                        <div class="filter-group">
                            <a href="all-listed-jobs.php" class="filter-btn btn-secondary">
                                <i class="fas fa-times"></i>
                                Clear All
                            </a>
                        </div>
                    </form>
                </div>

                <!-- Jobs List -->
                <div class="jobs-card">
                    <div class="jobs-header">
                        <h2 class="jobs-title">Job Listings</h2>
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
                    // Get jobs data
                    $sql = "SELECT tbljobs.*, tblemployers.CompnayName, tblemployers.CompnayLogo 
                            FROM tbljobs 
                            JOIN tblemployers ON tblemployers.id = tbljobs.employerId 
                            $where_clause 
                            $order_clause 
                            LIMIT $limit OFFSET $offset";

                    $query = $dbh->prepare($sql);
                    foreach ($params as $key => $value) {
                        $query->bindValue($key, $value);
                    }
                    $query->execute();
                    $results = $query->fetchAll(PDO::FETCH_OBJ);

                    if(empty($results)) {
                    ?>
                        <div class="empty-state">
                            <i class="fas fa-briefcase"></i>
                            <h3>No jobs found</h3>
                            <p>No jobs match your current filters. Try adjusting your search criteria.</p>
                        </div>
                    <?php
                    } else {
                    ?>

                    <!-- Cards View -->
                    <div class="jobs-grid" id="cardsView">
                        <?php
                        foreach($results as $row) {
                            $jobTypeClass = '';
                            switch(strtolower($row->jobType)) {
                                case 'full time': $jobTypeClass = 'job-type-full'; break;
                                case 'part time': $jobTypeClass = 'job-type-part'; break;
                                case 'contract': $jobTypeClass = 'job-type-contract'; break;
                                default: $jobTypeClass = 'job-type-full';
                            }
                        ?>
                        <div class="job-card" onclick="viewJobDetails(<?php echo $row->jobId; ?>)">
                            <div class="job-header">
                                <div>
                                    <h3 class="job-title"><?php echo htmlentities($row->jobTitle); ?></h3>
                                    <p class="job-company"><?php echo htmlentities($row->CompnayName); ?></p>
                                </div>
                                <span class="job-type-badge <?php echo $jobTypeClass; ?>">
                                    <?php echo htmlentities($row->jobType); ?>
                                </span>
                            </div>
                            
                            <div class="job-details">
                                <div class="job-detail-row">
                                    <i class="fas fa-tags"></i>
                                    <span><?php echo htmlentities($row->jobCategory); ?></span>
                                </div>
                                <div class="job-detail-row">
                                    <i class="fas fa-money-bill-wave"></i>
                                    <span><?php echo htmlentities($row->salaryPackage); ?></span>
                                </div>
                                <div class="job-detail-row">
                                    <i class="fas fa-map-marker-alt"></i>
                                    <span><?php echo htmlentities($row->jobLocation); ?></span>
                                </div>
                                <div class="job-detail-row">
                                    <i class="fas fa-tools"></i>
                                    <span><?php echo htmlentities(substr($row->skillsRequired, 0, 60)) . (strlen($row->skillsRequired) > 60 ? '...' : ''); ?></span>
                                </div>
                            </div>
                            
                            <div class="job-meta">
                                <span class="job-category"><?php echo htmlentities($row->jobCategory); ?></span>
                                <span class="job-date"><?php echo date('M j, Y', strtotime($row->postinDate)); ?></span>
                            </div>
                        </div>
                        <?php } ?>
                    </div>

                    <!-- Table View -->
                    <div class="jobs-table-container" id="tableView" style="display: none;">
                        <table class="jobs-table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Company</th>
                                    <th>Job Title</th>
                                    <th>Category</th>
                                    <th>Type</th>
                                    <th>Package</th>
                                    <th>Skills Required</th>
                                    <th>Location</th>
                                    <th>Posted Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $cnt = $offset + 1;
                                foreach($results as $row) {
                                ?>
                                <tr onclick="viewJobDetails(<?php echo $row->jobId; ?>)" style="cursor: pointer;">
                                    <td><?php echo $cnt; ?></td>
                                    <td class="company-cell"><?php echo htmlentities($row->CompnayName); ?></td>
                                    <td class="job-title-cell"><?php echo htmlentities($row->jobTitle); ?></td>
                                    <td><?php echo htmlentities($row->jobCategory); ?></td>
                                    <td>
                                        <span class="job-type-badge <?php 
                                            switch(strtolower($row->jobType)) {
                                                case 'full time': echo 'job-type-full'; break;
                                                case 'part time': echo 'job-type-part'; break;
                                                case 'contract': echo 'job-type-contract'; break;
                                                default: echo 'job-type-full';
                                            }
                                        ?>">
                                            <?php echo htmlentities($row->jobType); ?>
                                        </span>
                                    </td>
                                    <td class="salary-cell"><?php echo htmlentities($row->salaryPackage); ?></td>
                                    <td class="skills-cell"><?php echo htmlentities(substr($row->skillsRequired, 0, 80)) . (strlen($row->skillsRequired) > 80 ? '...' : ''); ?></td>
                                    <td class="location-cell"><?php echo htmlentities($row->jobLocation); ?></td>
                                    <td><?php echo date('M j, Y', strtotime($row->postinDate)); ?></td>
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
                <div class="pagination-card">
                    <div class="pagination-info">
                        <?php
                        $total_sql = "SELECT COUNT(*) as total FROM tbljobs JOIN tblemployers ON tblemployers.id = tbljobs.employerId $where_clause";
                        $total_query = $dbh->prepare($total_sql);
                        foreach ($params as $key => $value) {
                            $total_query->bindValue($key, $value);
                        }
                        $total_query->execute();
                        $total_records = $total_query->fetch(PDO::FETCH_OBJ)->total;
                        $total_pages = ceil($total_records / $limit);
                        
                        $start_record = $offset + 1;
                        $end_record = min($offset + $limit, $total_records);
                        ?>
                        Showing <?php echo $start_record; ?>-<?php echo $end_record; ?> of <?php echo $total_records; ?> jobs
                    </div>
                    
                    <div class="pagination">
                        <?php
                        $query_string = http_build_query(array_filter([
                            'category' => $filter_category !== 'all' ? $filter_category : null,
                            'type' => $filter_type !== 'all' ? $filter_type : null,
                            'company' => $filter_company !== 'all' ? $filter_company : null,
                            'search' => $search_term,
                            'sort' => $sort_by !== 'newest' ? $sort_by : null
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
                localStorage.setItem('jobsViewPreference', 'cards');
            } else {
                cardsView.style.display = 'none';
                tableView.style.display = 'block';
                tableBtn.classList.add('active');
                cardsBtn.classList.remove('active');
                localStorage.setItem('jobsViewPreference', 'table');
            }
        }

        // Load saved view preference
        document.addEventListener('DOMContentLoaded', function() {
            const savedView = localStorage.getItem('jobsViewPreference') || 'cards';
            switchView(savedView);
        });

        // Job details function (placeholder)
        function viewJobDetails(jobId) {
            // You can implement a modal or redirect to job details page
            console.log('View job details for job ID:', jobId);
            // For now, just show an alert
            alert('Job details feature - to be implemented. Job ID: ' + jobId);
        }

        // Auto-submit form on select changes
        document.querySelectorAll('.filter-select').forEach(select => {
            select.addEventListener('change', function() {
                // Auto-submit form when filters change
                // this.form.submit();
            });
        });

        // Search with debouncing
        let searchTimeout;
        document.querySelector('input[name="search"]').addEventListener('input', function() {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(() => {
                // Auto-submit form after 1 second of no typing
                // this.form.submit();
            }, 1000);
        });

        // Keyboard shortcuts
        document.addEventListener('keydown', function(e) {
            // Ctrl/Cmd + K to focus search
            if ((e.ctrlKey || e.metaKey) && e.key === 'k') {
                e.preventDefault();
                document.querySelector('input[name="search"]').focus();
            }
            
            // V to toggle view
            if (e.key === 'v' && !e.ctrlKey && !e.metaKey) {
                const currentView = localStorage.getItem('jobsViewPreference') || 'cards';
                switchView(currentView === 'cards' ? 'table' : 'cards');
            }
        });

        // Export functionality (placeholder)
        function exportJobs() {
            alert('Export functionality - to be implemented');
        }

        // Refresh data
        function refreshJobs() {
            window.location.reload();
        }
    </script>
</body>
</html>
<?php }  ?>

<!-- Done 6 -->