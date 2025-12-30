<style>
    .modern-sidebar {
        background: linear-gradient(180deg, var(--card-white) 0%, #FEFBF8 100%);
        border-right: 1px solid rgba(255, 107, 0, 0.1);
        box-shadow: 4px 0 15px rgba(0, 0, 0, 0.05);
        width: 280px;
        height: 100vh;
        position: fixed;
        left: 0;
        top: 0;
        z-index: 1000;
        overflow-y: auto;
        transition: all 0.3s ease;
    }

    .sidebar-header {
        padding: 2rem 1.5rem 1.5rem;
        border-bottom: 1px solid rgba(255, 107, 0, 0.1);
        background: linear-gradient(135deg, var(--primary-orange), #FF8F42);
        color: white;
        position: relative;
        overflow: hidden;
    }

    .sidebar-header::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -50%;
        width: 200%;
        height: 200%;
        background: radial-gradient(circle, rgba(255, 255, 255, 0.1) 0%, transparent 70%);
        animation: pulse 4s ease-in-out infinite;
    }

    .sidebar-logo {
        display: flex;
        align-items: center;
        gap: 12px;
        position: relative;
        z-index: 1;
    }

    .logo-icon {
        width: 48px;
        height: 48px;
        background: rgba(255, 255, 255, 0.2);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
        backdrop-filter: blur(10px);
    }

    .logo-text {
        flex: 1;
    }

    .logo-title {
        font-size: 1.5rem;
        font-weight: 700;
        margin: 0;
        line-height: 1.2;
    }

    .logo-subtitle {
        font-size: 0.875rem;
        opacity: 0.9;
        margin: 0;
        font-weight: 400;
    }

    .sidebar-user {
        padding: 1.5rem;
        text-align: center;
        border-bottom: 1px solid rgba(255, 107, 0, 0.1);
    }

    .user-avatar-large {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        background: linear-gradient(135deg, var(--primary-orange), #FF8F42);
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1rem;
        color: white;
        font-size: 24px;
        font-weight: 700;
        box-shadow: 0 8px 20px rgba(255, 107, 0, 0.3);
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .user-avatar-large:hover {
        transform: translateY(-2px);
        box-shadow: 0 12px 25px rgba(255, 107, 0, 0.4);
    }

    .user-welcome {
        font-size: 14px;
        color: var(--text-gray);
        margin: 0 0 4px 0;
    }

    .user-name-large {
        font-size: 16px;
        font-weight: 600;
        color: var(--text-dark);
        margin: 0 0 8px 0;
    }

    .user-actions {
        display: flex;
        justify-content: center;
        gap: 8px;
        margin-top: 12px;
    }

    .user-action-btn {
        width: 32px;
        height: 32px;
        border-radius: 8px;
        border: none;
        background: rgba(255, 107, 0, 0.1);
        color: var(--primary-orange);
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.3s ease;
        font-size: 14px;
    }

    .user-action-btn:hover {
        background: var(--primary-orange);
        color: white;
        transform: translateY(-1px);
    }

    .sidebar-nav {
        padding: 1rem 0;
        flex: 1;
    }

    .nav-section-title {
        padding: 1rem 1.5rem 0.5rem;
        font-size: 12px;
        font-weight: 600;
        color: var(--text-gray);
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin: 0;
    }

    .nav-menu {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .nav-item {
        margin: 0 1rem 4px;
    }

    .nav-link {
        display: flex;
        align-items: center;
        padding: 12px 16px;
        color: var(--text-dark);
        text-decoration: none;
        border-radius: 12px;
        transition: all 0.3s ease;
        position: relative;
        gap: 12px;
        font-weight: 500;
    }

    .nav-link:hover {
        background: rgba(255, 107, 0, 0.1);
        color: var(--primary-orange);
        text-decoration: none;
        transform: translateX(4px);
    }

    .nav-link.active {
        background: linear-gradient(135deg, var(--primary-orange), #FF8F42);
        color: white;
        box-shadow: 0 4px 12px rgba(255, 107, 0, 0.3);
    }

    .nav-link.active:hover {
        transform: translateX(0);
    }

    .nav-icon {
        width: 20px;
        height: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 16px;
        flex-shrink: 0;
    }

    .nav-text {
        flex: 1;
        font-size: 14px;
    }

    .nav-badge {
        background: #EF4444;
        color: white;
        font-size: 10px;
        font-weight: 600;
        padding: 2px 6px;
        border-radius: 6px;
        min-width: 18px;
        text-align: center;
    }

    .nav-arrow {
        font-size: 12px;
        transition: transform 0.3s ease;
        opacity: 0.7;
    }

    .nav-submenu {
        list-style: none;
        padding: 0;
        margin: 4px 0 0 0;
        max-height: 0;
        overflow: hidden;
        transition: all 0.3s ease;
    }

    .nav-item.open .nav-submenu {
        max-height: 300px;
        margin: 8px 0 0 0;
    }

    .nav-item.open .nav-arrow {
        transform: rotate(90deg);
    }

    .nav-submenu-item {
        margin: 2px 0;
    }

    .nav-submenu-link {
        display: flex;
        align-items: center;
        padding: 8px 16px 8px 44px;
        color: var(--text-gray);
        text-decoration: none;
        border-radius: 8px;
        transition: all 0.3s ease;
        font-size: 13px;
        position: relative;
    }

    .nav-submenu-link::before {
        content: '';
        position: absolute;
        left: 28px;
        top: 50%;
        transform: translateY(-50%);
        width: 4px;
        height: 4px;
        background: currentColor;
        border-radius: 50%;
        opacity: 0.5;
    }

    .nav-submenu-link:hover {
        background: rgba(255, 107, 0, 0.08);
        color: var(--primary-orange);
        text-decoration: none;
        transform: translateX(4px);
    }

    .nav-submenu-link.active {
        background: rgba(255, 107, 0, 0.15);
        color: var(--primary-orange);
        font-weight: 600;
    }

    /* Stats Cards in Sidebar */
    .sidebar-stats {
        padding: 1rem 1.5rem;
        border-top: 1px solid rgba(255, 107, 0, 0.1);
    }

    .stat-mini-card {
        background: rgba(255, 107, 0, 0.05);
        border-radius: 12px;
        padding: 12px;
        margin-bottom: 8px;
        display: flex;
        align-items: center;
        gap: 12px;
        transition: all 0.3s ease;
        cursor: pointer;
    }

    .stat-mini-card:hover {
        background: rgba(255, 107, 0, 0.1);
        transform: translateY(-1px);
    }

    .stat-mini-icon {
        width: 36px;
        height: 36px;
        border-radius: 8px;
        background: var(--primary-orange);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 14px;
    }

    .stat-mini-content {
        flex: 1;
        min-width: 0;
    }

    .stat-mini-value {
        font-size: 16px;
        font-weight: 700;
        color: var(--text-dark);
        margin: 0;
        line-height: 1.2;
    }

    .stat-mini-label {
        font-size: 11px;
        color: var(--text-gray);
        margin: 0;
        line-height: 1.2;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .modern-sidebar {
            width: 100%;
            transform: translateX(-100%);
        }

        .modern-sidebar.open {
            transform: translateX(0);
        }
    }

    /* Scrollbar Styling */
    .modern-sidebar::-webkit-scrollbar {
        width: 4px;
    }

    .modern-sidebar::-webkit-scrollbar-track {
        background: transparent;
    }

    .modern-sidebar::-webkit-scrollbar-thumb {
        background: rgba(255, 107, 0, 0.3);
        border-radius: 4px;
    }

    .modern-sidebar::-webkit-scrollbar-thumb:hover {
        background: rgba(255, 107, 0, 0.5);
    }
</style>

<nav id="sidebar" class="modern-sidebar">
    <!-- Sidebar Header -->
    <div class="sidebar-header">
        <div class="sidebar-logo">
            <div class="logo-icon">
                <i class="fas fa-briefcase"></i>
            </div>
            <div class="logo-text">
                <h1 class="logo-title">Hanap-Kita</h1>
                <p class="logo-subtitle">Admin Portal</p>
            </div>
        </div>
    </div>

    <!-- User Section -->
    <div class="sidebar-user">
        <?php
        $aid=$_SESSION['jpaid'];
        $sql="SELECT AdminName from tbladmin where ID=:aid";
        $query = $dbh -> prepare($sql);
        $query->bindParam(':aid',$aid,PDO::PARAM_STR);
        $query->execute();
        $results=$query->fetchAll(PDO::FETCH_OBJ);
        $cnt=1;
        if($query->rowCount() > 0)
        {
        foreach($results as $row)
        {               ?>
        <a href="admin-profile.php" class="user-avatar-large">
            <?php echo strtoupper(substr($row->AdminName, 0, 2)); ?>
        </a>
        <p class="user-welcome">Welcome back,</p>
        <h3 class="user-name-large"><?php echo $row->AdminName; ?></h3>
        <?php $cnt=$cnt+1;}} ?>
        
        <div class="user-actions">
            <button class="user-action-btn" title="Profile" onclick="location.href='admin-profile.php'">
                <i class="fas fa-user"></i>
            </button>
            <button class="user-action-btn" title="Settings" onclick="location.href='change-password.php'">
                <i class="fas fa-cog"></i>
            </button>
            <button class="user-action-btn" title="Logout" onclick="location.href='logout.php'">
                <i class="fas fa-sign-out-alt"></i>
            </button>
        </div>
    </div>

    <!-- Navigation Menu -->
    <div class="sidebar-nav">
        <ul class="nav-menu">
            <!-- Dashboard -->
            <li class="nav-item">
                <a href="dashboard.php" class="nav-link active">
                    <span class="nav-icon"><i class="fas fa-tachometer-alt"></i></span>
                    <span class="nav-text">Dashboard</span>
                </a>
            </li>
        </ul>

        <!-- Main Navigation -->
        <h6 class="nav-section-title">Management</h6>
        <ul class="nav-menu">
            <!-- Job Categories -->
            <li class="nav-item">
                <a href="#" class="nav-link" onclick="toggleSubmenu(this)">
                    <span class="nav-icon"><i class="fas fa-tags"></i></span>
                    <span class="nav-text">Job Categories</span>
                    <span class="nav-arrow"><i class="fas fa-chevron-right"></i></span>
                </a>
                <ul class="nav-submenu">
                    <li class="nav-submenu-item">
                        <a href="add-category.php" class="nav-submenu-link">Add Category</a>
                    </li>
                    <li class="nav-submenu-item">
                        <a href="manage-category.php" class="nav-submenu-link">Manage Categories</a>
                    </li>
                </ul>
            </li>

            <!-- Employers -->
            <li class="nav-item">
                <a href="employer-list.php" class="nav-link">
                    <span class="nav-icon"><i class="fas fa-building"></i></span>
                    <span class="nav-text">Employers</span>
                    <span class="nav-badge">
                        <?php 
                        $sql2 ="SELECT id from tblemployers";
                        $query2 = $dbh -> prepare($sql2);
                        $query2->execute();
                        echo $query2->rowCount();
                        ?>
                    </span>
                </a>
            </li>

            <!-- Job Seekers -->
            <li class="nav-item">
                <a href="reg-jobseekers.php" class="nav-link">
                    <span class="nav-icon"><i class="fas fa-users"></i></span>
                    <span class="nav-text">Job Seekers</span>
                    <span class="nav-badge">
                        <?php 
                        $sql3 ="SELECT id from tbljobseekers";
                        $query3 = $dbh -> prepare($sql3);
                        $query3->execute();
                        echo $query3->rowCount();
                        ?>
                    </span>
                </a>
            </li>

            <!-- Jobs -->
            <li class="nav-item">
                <a href="all-listed-jobs.php" class="nav-link">
                    <span class="nav-icon"><i class="fas fa-briefcase"></i></span>
                    <span class="nav-text">All Jobs</span>
                    <span class="nav-badge">
                        <?php 
                        $sql4 ="SELECT jobId from tbljobs";
                        $query4 = $dbh -> prepare($sql4);
                        $query4->execute();
                        echo $query4->rowCount();
                        ?>
                    </span>
                </a>
            </li>
        </ul>

        <!-- Content Management -->
        <h6 class="nav-section-title">Content</h6>
        <ul class="nav-menu">
            <li class="nav-item">
                <a href="#" class="nav-link" onclick="toggleSubmenu(this)">
                    <span class="nav-icon"><i class="fas fa-file-alt"></i></span>
                    <span class="nav-text">Pages</span>
                    <span class="nav-arrow"><i class="fas fa-chevron-right"></i></span>
                </a>
                <ul class="nav-submenu">
                    <li class="nav-submenu-item">
                        <a href="aboutus.php" class="nav-submenu-link">About Us</a>
                    </li>
                    <li class="nav-submenu-item">
                        <a href="contactus.php" class="nav-submenu-link">Contact Us</a>
                    </li>
                </ul>
            </li>
        </ul>

        <!-- Reports & Analytics -->
        <h6 class="nav-section-title">Analytics</h6>
        <ul class="nav-menu">
            <li class="nav-item">
                <a href="#" class="nav-link" onclick="toggleSubmenu(this)">
                    <span class="nav-icon"><i class="fas fa-chart-bar"></i></span>
                    <span class="nav-text">Reports</span>
                    <span class="nav-arrow"><i class="fas fa-chevron-right"></i></span>
                </a>
                <ul class="nav-submenu">
                    <li class="nav-submenu-item">
                        <a href="employer-report.php" class="nav-submenu-link">Employer Report</a>
                    </li>
                    <li class="nav-submenu-item">
                        <a href="candidates-report.php" class="nav-submenu-link">Candidates Report</a>
                    </li>
                </ul>
            </li>

            <li class="nav-item">
                <a href="#" class="nav-link" onclick="toggleSubmenu(this)">
                    <span class="nav-icon"><i class="fas fa-search"></i></span>
                    <span class="nav-text">Search</span>
                    <span class="nav-arrow"><i class="fas fa-chevron-right"></i></span>
                </a>
                <ul class="nav-submenu">
                    <li class="nav-submenu-item">
                        <a href="employer-search.php" class="nav-submenu-link">Employer Search</a>
                    </li>
                    <li class="nav-submenu-item">
                        <a href="candidates-search.php" class="nav-submenu-link">Candidates Search</a>
                    </li>
                </ul>
            </li>

            <li class="nav-item">
                <a href="activity-logs.php" class="nav-link">
                    <span class="nav-icon"><i class="fas fa-history"></i></span>
                    <span class="nav-text">Activity Logs</span>
                    <span class="nav-badge">New</span>
                </a>
            </li>
        </ul>
    </div>

    <!-- Sidebar Stats -->
    <div class="sidebar-stats">
        <h6 class="nav-section-title">Quick Stats</h6>
        
        <div class="stat-mini-card" onclick="location.href='all-listed-jobs.php'">
            <div class="stat-mini-icon">
                <i class="fas fa-briefcase"></i>
            </div>
            <div class="stat-mini-content">
                <p class="stat-mini-value">
                    <?php 
                    $sql_jobs ="SELECT jobId from tbljobs WHERE isActive=1";
                    $query_jobs = $dbh -> prepare($sql_jobs);
                    $query_jobs->execute();
                    echo $query_jobs->rowCount();
                    ?>
                </p>
                <p class="stat-mini-label">Active Jobs</p>
            </div>
        </div>

        <div class="stat-mini-card" onclick="location.href='#'">
            <div class="stat-mini-icon">
                <i class="fas fa-users"></i>
            </div>
            <div class="stat-mini-content">
                <p class="stat-mini-value">
                    <?php 
                    $sql_apps ="SELECT ID from tblapplyjob WHERE DATE(Applydate) = CURDATE()";
                    $query_apps = $dbh -> prepare($sql_apps);
                    $query_apps->execute();
                    echo $query_apps->rowCount();
                    ?>
                </p>
                <p class="stat-mini-label">Today's Applications</p>
            </div>
        </div>

        <div class="stat-mini-card" onclick="location.href='employer-list.php'">
            <div class="stat-mini-icon">
                <i class="fas fa-building"></i>
            </div>
            <div class="stat-mini-content">
                <p class="stat-mini-value">
                    <?php 
                    $sql_new_emp ="SELECT id from tblemployers WHERE DATE(RegDtae) >= DATE_SUB(CURDATE(), INTERVAL 7 DAY)";
                    $query_new_emp = $dbh -> prepare($sql_new_emp);
                    $query_new_emp->execute();
                    echo $query_new_emp->rowCount();
                    ?>
                </p>
                <p class="stat-mini-label">New Employers</p>
            </div>
        </div>
    </div>
</nav>

<script>
function toggleSubmenu(element) {
    const navItem = element.parentElement;
    const isOpen = navItem.classList.contains('open');
    
    // Close all other submenus
    document.querySelectorAll('.nav-item.open').forEach(item => {
        if (item !== navItem) {
            item.classList.remove('open');
        }
    });
    
    // Toggle current submenu
    navItem.classList.toggle('open', !isOpen);
}

// Auto-open submenu if child is active
document.addEventListener('DOMContentLoaded', function() {
    const activeSubmenuLink = document.querySelector('.nav-submenu-link.active');
    if (activeSubmenuLink) {
        const parentNavItem = activeSubmenuLink.closest('.nav-item');
        if (parentNavItem) {
            parentNavItem.classList.add('open');
        }
    }
    
    // Highlight current page in navigation
    const currentPage = window.location.pathname.split('/').pop();
    const navLinks = document.querySelectorAll('.nav-link, .nav-submenu-link');
    
    navLinks.forEach(link => {
        const linkHref = link.getAttribute('href');
        if (linkHref && linkHref.includes(currentPage)) {
            link.classList.add('active');
            
            // If it's a submenu link, also open the parent menu
            if (link.classList.contains('nav-submenu-link')) {
                const parentNavItem = link.closest('.nav-item');
                if (parentNavItem) {
                    parentNavItem.classList.add('open');
                }
                // Remove active from main nav items
                document.querySelectorAll('.nav-link.active').forEach(mainLink => {
                    if (!mainLink.classList.contains('nav-submenu-link')) {
                        mainLink.classList.remove('active');
                    }
                });
            }
        }
    });
});
</script>

<!--Draft 3 -->