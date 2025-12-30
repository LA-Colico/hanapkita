<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
include('includes/activity-logger.php'); // Include activity logger

if (strlen($_SESSION['jpaid']==0)) {
  header('location:logout.php');
  } else{

// Get admin info for logging
$admin_id = $_SESSION['jpaid'];
$sql_admin = "SELECT AdminName FROM tbladmin WHERE ID=:aid";
$query_admin = $dbh->prepare($sql_admin);
$query_admin->bindParam(':aid', $admin_id, PDO::PARAM_STR);
$query_admin->execute();
$admin_info = $query_admin->fetch(PDO::FETCH_OBJ);
$admin_name = $admin_info ? $admin_info->AdminName : 'Unknown Admin';

// Code for deleting the job category
if(isset($_GET['delid']))
{
    $rid=intval($_GET['delid']);
    
    // Get category name before deletion for logging
    $sql_get_cat = "SELECT CategoryName FROM tblcategory WHERE ID=:rid";
    $query_get_cat = $dbh->prepare($sql_get_cat);
    $query_get_cat->bindParam(':rid', $rid, PDO::PARAM_STR);
    $query_get_cat->execute();
    $category_info = $query_get_cat->fetch(PDO::FETCH_OBJ);
    $category_name = $category_info ? $category_info->CategoryName : 'Unknown Category';
    
    $sql="delete from tblcategory where ID=:rid";
    $query=$dbh->prepare($sql);
    $query->bindParam(':rid',$rid,PDO::PARAM_STR);
    $query->execute();
    
    // Log the deletion activity
    logAdminAction($dbh, $admin_id, $admin_name, 'delete', 'Deleted job category: ' . $category_name, 'tblcategory', $rid);
    
    echo "<script>alert('Data deleted');</script>"; 
    echo "<script>window.location.href = 'manage-category.php'</script>";     
}

// Log page view
logAdminAction($dbh, $admin_id, $admin_name, 'view', 'Viewed manage categories page', 'tblcategory', null);

?>
<!doctype html>
<html lang="en" class="no-focus">
<head>
    <title>Hanap-Kita - Manage Category</title>
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
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .page-title {
            font-size: 2rem;
            font-weight: 700;
            color: var(--text-dark);
            margin: 0;
            background: linear-gradient(135deg, var(--primary-orange), #FF8F42);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .page-subtitle {
            color: var(--text-gray);
            font-size: 1rem;
            margin: 0.5rem 0 0 0;
        }

        .add-btn {
            background: linear-gradient(135deg, var(--primary-orange), #FF8F42);
            color: white;
            border: none;
            border-radius: 12px;
            padding: 0.75rem 1.5rem;
            font-weight: 600;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            transition: all 0.3s ease;
            box-shadow: 0 4px 8px rgba(255, 107, 0, 0.3);
        }

        .add-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 12px rgba(255, 107, 0, 0.4);
            text-decoration: none;
            color: white;
        }

        .data-card {
            background: var(--card-white);
            border-radius: 20px;
            padding: 2rem;
            box-shadow: var(--shadow-card);
            border: 1px solid rgba(255, 107, 0, 0.1);
        }

        .data-header {
            display: flex;
            justify-content: between;
            align-items: center;
            margin-bottom: 1.5rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid rgba(255, 107, 0, 0.1);
        }

        .data-title {
            font-size: 1.25rem;
            font-weight: 600;
            color: var(--text-dark);
            margin: 0;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .data-icon {
            width: 32px;
            height: 32px;
            border-radius: 8px;
            background: rgba(255, 107, 0, 0.1);
            color: var(--primary-orange);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
        }

        .modern-table {
            width: 100%;
            border-collapse: collapse;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        }

        .modern-table thead {
            background: linear-gradient(135deg, var(--primary-orange), #FF8F42);
            color: white;
        }

        .modern-table th {
            padding: 1rem;
            text-align: left;
            font-weight: 600;
            font-size: 14px;
            letter-spacing: 0.5px;
        }

        .modern-table td {
            padding: 1rem;
            border-bottom: 1px solid rgba(255, 107, 0, 0.1);
            color: var(--text-gray);
            font-size: 14px;
        }

        .modern-table tbody tr {
            transition: all 0.3s ease;
        }

        .modern-table tbody tr:hover {
            background: rgba(255, 107, 0, 0.05);
            transform: translateY(-1px);
        }

        .modern-table tbody tr:last-child td {
            border-bottom: none;
        }

        .action-buttons {
            display: flex;
            gap: 0.5rem;
        }

        .btn-action {
            padding: 0.5rem 1rem;
            border-radius: 8px;
            border: none;
            font-size: 12px;
            font-weight: 600;
            text-decoration: none;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            transition: all 0.3s ease;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 0.25rem;
        }

        .btn-delete {
            background: rgba(239, 68, 68, 0.1);
            color: #EF4444;
            border: 1px solid rgba(239, 68, 68, 0.2);
        }

        .btn-delete:hover {
            background: #EF4444;
            color: white;
            text-decoration: none;
            transform: translateY(-1px);
            box-shadow: 0 4px 8px rgba(239, 68, 68, 0.3);
        }

        .btn-edit {
            background: rgba(59, 130, 246, 0.1);
            color: #3B82F6;
            border: 1px solid rgba(59, 130, 246, 0.2);
        }

        .btn-edit:hover {
            background: #3B82F6;
            color: white;
            text-decoration: none;
            transform: translateY(-1px);
            box-shadow: 0 4px 8px rgba(59, 130, 246, 0.3);
        }

        .category-name {
            font-weight: 600;
            color: var(--text-dark);
        }

        .creation-date {
            color: var(--text-gray);
            font-size: 13px;
        }

        .row-number {
            font-weight: 600;
            color: var(--primary-orange);
            background: rgba(255, 107, 0, 0.1);
            width: 32px;
            height: 32px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 14px;
        }

        .stats-bar {
            display: flex;
            gap: 1rem;
            margin-bottom: 1rem;
            flex-wrap: wrap;
        }

        .stat-item {
            background: rgba(255, 107, 0, 0.1);
            padding: 0.75rem 1rem;
            border-radius: 8px;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            color: var(--primary-orange);
            font-weight: 500;
            font-size: 14px;
        }

        .stat-icon {
            font-size: 16px;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .main-content { padding: 1rem; }
            .page-header { 
                flex-direction: column; 
                align-items: flex-start; 
                gap: 1rem; 
            }
            .action-buttons { 
                flex-direction: column; 
            }
            .stats-bar { 
                flex-direction: column; 
            }
        }

        /* Loading Animation */
        .loading {
            opacity: 0.6;
            pointer-events: none;
        }

        .loading::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 20px;
            height: 20px;
            margin: -10px 0 0 -10px;
            border: 2px solid transparent;
            border-top: 2px solid var(--primary-orange);
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
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
                    <div>
                        <h2 class="page-title">
                            <i class="fas fa-tags" style="margin-right: 0.5rem; color: var(--primary-orange);"></i>
                            Manage Categories
                        </h2>
                        <p class="page-subtitle">Organize and manage job categories for better job classification</p>
                    </div>
                    <a href="add-category.php" class="add-btn">
                        <i class="fas fa-plus"></i>
                        Add New Category
                    </a>
                </div>

                <!-- Statistics Bar -->
                <div class="stats-bar">
                    <div class="stat-item">
                        <i class="fas fa-tags stat-icon"></i>
                        <span>Total Categories: 
                            <?php 
                            $sql_count = "SELECT COUNT(*) as count FROM tblcategory";
                            $query_count = $dbh->prepare($sql_count);
                            $query_count->execute();
                            $total_categories = $query_count->fetch(PDO::FETCH_OBJ);
                            echo $total_categories->count;
                            ?>
                        </span>
                    </div>
                    <div class="stat-item">
                        <i class="fas fa-briefcase stat-icon"></i>
                        <span>Active Jobs: 
                            <?php 
                            $sql_jobs = "SELECT COUNT(*) as count FROM tbljobs WHERE isActive = 1";
                            $query_jobs = $dbh->prepare($sql_jobs);
                            $query_jobs->execute();
                            $active_jobs = $query_jobs->fetch(PDO::FETCH_OBJ);
                            echo $active_jobs->count;
                            ?>
                        </span>
                    </div>
                    <div class="stat-item">
                        <i class="fas fa-clock stat-icon"></i>
                        <span>Last Updated: <?php echo date('M j, Y'); ?></span>
                    </div>
                </div>

                <!-- Data Table Card -->
                <div class="data-card">
                    <div class="data-header">
                        <h3 class="data-title">
                            <div class="data-icon">
                                <i class="fas fa-list"></i>
                            </div>
                            Category List
                        </h3>
                    </div>

                    <!-- Table Container -->
                    <div style="overflow-x: auto;">
                        <table class="modern-table" id="categoriesTable">
                            <thead>
                                <tr>
                                    <th style="width: 60px; text-align: center;">#</th>
                                    <th>Category Name</th>
                                    <th style="width: 200px;">Creation Date</th>
                                    <th style="width: 200px; text-align: center;">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $sql="SELECT * from tblcategory ORDER BY PostingDate DESC";
                                $query = $dbh -> prepare($sql);
                                $query->execute();
                                $results=$query->fetchAll(PDO::FETCH_OBJ);

                                $cnt=1;
                                if($query->rowCount() > 0)
                                {
                                foreach($results as $row)
                                {               ?>
                                <tr data-category-id="<?php echo $row->id; ?>">
                                    <td style="text-align: center;">
                                        <div class="row-number"><?php echo htmlentities($cnt);?></div>
                                    </td>
                                    <td>
                                        <div class="category-name"><?php echo htmlentities($row->CategoryName);?></div>
                                        <div style="font-size: 12px; color: var(--text-gray); margin-top: 0.25rem;">
                                            <?php echo htmlentities(substr($row->Description, 0, 80)); ?>...
                                        </div>
                                    </td>
                                    <td>
                                        <div class="creation-date">
                                            <i class="fas fa-calendar-alt" style="margin-right: 0.25rem;"></i>
                                            <?php echo date('M j, Y', strtotime($row->PostingDate)); ?>
                                        </div>
                                        <div style="font-size: 11px; color: var(--text-light); margin-top: 0.125rem;">
                                            <?php echo date('g:i A', strtotime($row->PostingDate)); ?>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="action-buttons">
                                            <a href="edit-category.php?editid=<?php echo htmlentities($row->id);?>" 
                                               class="btn-action btn-edit"
                                               title="Edit Category">
                                                <i class="fas fa-edit"></i>
                                                Edit
                                            </a>
                                            <button onclick="confirmDelete(<?php echo $row->id; ?>, '<?php echo htmlentities($row->CategoryName); ?>')" 
                                                    class="btn-action btn-delete"
                                                    title="Delete Category">
                                                <i class="fas fa-trash"></i>
                                                Delete
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                <?php $cnt=$cnt+1;}} else { ?>
                                <tr>
                                    <td colspan="4" style="text-align: center; padding: 3rem; color: var(--text-gray);">
                                        <i class="fas fa-inbox fa-3x" style="margin-bottom: 1rem; opacity: 0.5;"></i>
                                        <div>No categories found</div>
                                        <div style="font-size: 14px; margin-top: 0.5rem;">
                                            <a href="add-category.php" style="color: var(--primary-orange);">Create your first category</a>
                                        </div>
                                    </td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
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
        // Enhanced delete confirmation with better UX
        function confirmDelete(categoryId, categoryName) {
            if (confirm(`Are you sure you want to delete the category "${categoryName}"?\n\nThis action cannot be undone.`)) {
                // Add loading state
                const row = document.querySelector(`tr[data-category-id="${categoryId}"]`);
                row.classList.add('loading');
                
                // Redirect to delete
                window.location.href = `manage-category.php?delid=${categoryId}`;
            }
        }

        // Add hover effects and animations
        document.addEventListener('DOMContentLoaded', function() {
            // Animate table rows on load
            const rows = document.querySelectorAll('.modern-table tbody tr');
            rows.forEach((row, index) => {
                row.style.animationDelay = `${index * 0.1}s`;
                row.style.animation = 'fadeInUp 0.6s ease-out forwards';
            });

            // Add search functionality
            const searchInput = document.createElement('input');
            searchInput.type = 'text';
            searchInput.placeholder = 'Search categories...';
            searchInput.style.cssText = `
                padding: 0.75rem 1rem;
                border: 2px solid rgba(255, 107, 0, 0.1);
                border-radius: 8px;
                margin-bottom: 1rem;
                width: 300px;
                font-size: 14px;
            `;

            searchInput.addEventListener('input', function(e) {
                const searchTerm = e.target.value.toLowerCase();
                const tableRows = document.querySelectorAll('.modern-table tbody tr');
                
                tableRows.forEach(row => {
                    const categoryName = row.querySelector('.category-name');
                    if (categoryName) {
                        const text = categoryName.textContent.toLowerCase();
                        row.style.display = text.includes(searchTerm) ? '' : 'none';
                    }
                });
            });

            // Insert search input before the table
            const dataCard = document.querySelector('.data-card');
            const table = document.querySelector('.modern-table').parentNode;
            table.insertBefore(searchInput, table.firstChild);
        });

        // Add CSS animation for fadeInUp
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
        `;
        document.head.appendChild(style);
    </script>
</body>
</html>
<?php }  ?>

<!-- Done 21 -->