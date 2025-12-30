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
    }

    .modern-header {
        background: linear-gradient(135deg, var(--card-white) 0%, #FEFBF8 100%);
        border-bottom: 1px solid rgba(255, 107, 0, 0.1);
        box-shadow: var(--shadow-soft);
        backdrop-filter: blur(10px);
    }

    .header-content {
        padding: 1rem 2rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .header-left {
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .sidebar-toggle {
        background: linear-gradient(135deg, var(--primary-orange), #FF8F42);
        color: white;
        border: none;
        border-radius: 12px;
        width: 44px;
        height: 44px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.3s ease;
        box-shadow: 0 4px 8px rgba(255, 107, 0, 0.3);
    }

    .sidebar-toggle:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 12px rgba(255, 107, 0, 0.4);
    }

    .header-search {
        position: relative;
        width: 400px;
        max-width: 100%;
    }

    .search-input {
        width: 100%;
        padding: 12px 16px 12px 48px;
        border: 2px solid rgba(255, 107, 0, 0.1);
        border-radius: 16px;
        background: var(--card-white);
        font-size: 14px;
        transition: all 0.3s ease;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
    }

    .search-input:focus {
        outline: none;
        border-color: var(--primary-orange);
        box-shadow: 0 0 0 3px rgba(255, 107, 0, 0.1);
    }

    .search-icon {
        position: absolute;
        left: 16px;
        top: 50%;
        transform: translateY(-50%);
        color: var(--text-gray);
        font-size: 16px;
    }

    .header-right {
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .header-actions {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .action-btn {
        width: 44px;
        height: 44px;
        border-radius: 12px;
        border: none;
        background: rgba(255, 107, 0, 0.1);
        color: var(--primary-orange);
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.3s ease;
        position: relative;
    }

    .action-btn:hover {
        background: var(--primary-orange);
        color: white;
        transform: translateY(-2px);
    }

    .user-profile {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 8px 16px;
        border-radius: 16px;
        background: rgba(255, 107, 0, 0.05);
        cursor: pointer;
        transition: all 0.3s ease;
        border: 1px solid rgba(255, 107, 0, 0.1);
    }

    .user-profile:hover {
        background: rgba(255, 107, 0, 0.1);
        transform: translateY(-1px);
    }

    .user-avatar {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        background: linear-gradient(135deg, var(--primary-orange), #FF8F42);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: 600;
        font-size: 14px;
    }

    .user-info {
        display: flex;
        flex-direction: column;
    }

    .user-name {
        font-weight: 600;
        color: var(--text-dark);
        font-size: 14px;
        margin: 0;
    }

    .user-role {
        font-size: 12px;
        color: var(--text-gray);
        margin: 0;
    }

    .dropdown-arrow {
        color: var(--text-gray);
        font-size: 12px;
        transition: transform 0.3s ease;
    }

    .user-profile:hover .dropdown-arrow {
        transform: rotate(180deg);
    }

    .notification-badge {
        position: absolute;
        top: -4px;
        right: -4px;
        width: 18px;
        height: 18px;
        background: #EF4444;
        color: white;
        border-radius: 50%;
        font-size: 10px;
        font-weight: 600;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 2px solid white;
    }

    /* Dropdown Menu Styles */
    .dropdown-menu {
        background: var(--card-white);
        border: 1px solid rgba(255, 107, 0, 0.1);
        border-radius: 16px;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        padding: 8px;
        margin-top: 8px;
        min-width: 200px;
    }

    .dropdown-item {
        padding: 12px 16px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        gap: 12px;
        color: var(--text-dark);
        text-decoration: none;
        transition: all 0.3s ease;
        font-size: 14px;
    }

    .dropdown-item:hover {
        background: rgba(255, 107, 0, 0.1);
        color: var(--primary-orange);
        text-decoration: none;
    }

    .dropdown-item i {
        width: 16px;
        text-align: center;
    }

    .dropdown-divider {
        height: 1px;
        background: rgba(255, 107, 0, 0.1);
        margin: 8px 0;
    }

    /* Theme Toggle Styles */
    .theme-toggle {
        display: flex;
        align-items: center;
        gap: 8px;
        background: rgba(255, 107, 0, 0.1);
        padding: 6px;
        border-radius: 12px;
    }

    .theme-option {
        width: 32px;
        height: 32px;
        border-radius: 8px;
        border: none;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
        font-size: 12px;
    }

    .theme-option.active {
        background: var(--primary-orange);
        color: white;
        box-shadow: 0 2px 4px rgba(255, 107, 0, 0.3);
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .header-content {
            padding: 1rem;
        }

        .header-search {
            width: 200px;
        }

        .user-info {
            display: none;
        }

        .header-actions {
            gap: 0.25rem;
        }
    }

    @media (max-width: 480px) {
        .header-search {
            display: none;
        }
    }
</style>

<header id="page-header" class="modern-header">
    <div class="header-content">
        <!-- Left Section -->
        <div class="header-left">
            <!-- Sidebar Toggle -->
            <button type="button" class="sidebar-toggle" data-toggle="layout" data-action="sidebar_toggle" aria-label="Toggle Sidebar">
                <i class="fas fa-bars"></i>
            </button>

            <!-- Search Bar -->
            <!--<div class="header-search">
                <div style="position: relative;">
                    <input type="text" class="search-input" placeholder="Search jobs, employers, candidates...">
                    <i class="fas fa-search search-icon"></i>
                </div>
            </div>-->
        </div>

        <!-- Right Section -->
        <div class="header-right">
            <!-- Action Buttons -->
            <div class="header-actions">
                <!-- Notifications -->
                <button type="button" class="action-btn" title="Notifications">
                    <i class="fas fa-bell"></i>
                    <span class="notification-badge">3</span>
                </button>

                <!-- Messages -->
                <button type="button" class="action-btn" title="Messages">
                    <i class="fas fa-envelope"></i>
                    <span class="notification-badge">5</span>
                </button>

                <!-- Theme Options -->
                <div class="theme-toggle">
                    <button type="button" class="theme-option active" data-toggle="theme" data-theme="default" title="Light Theme">
                        <i class="fas fa-sun"></i>
                    </button>
                    <button type="button" class="theme-option" data-toggle="theme" data-theme="dark" title="Dark Theme">
                        <i class="fas fa-moon"></i>
                    </button>
                </div>
            </div>

            <!-- User Profile -->
            <div class="btn-group" role="group">
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
                <button type="button" class="user-profile" id="page-header-user-dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <div class="user-avatar">
                        <?php echo strtoupper(substr($row->AdminName, 0, 2)); ?>
                    </div>
                    <div class="user-info">
                        <p class="user-name"><?php echo $row->AdminName; ?></p>
                        <p class="user-role">Administrator</p>
                    </div>
                    <i class="fas fa-chevron-down dropdown-arrow"></i>
                </button>
                <?php $cnt=$cnt+1;}} ?>
                
                <!-- Dropdown Menu -->
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="page-header-user-dropdown">
                    <a class="dropdown-item" href="admin-profile.php">
                        <i class="fas fa-user-circle"></i>
                        <span>My Profile</span>
                    </a>
                    <a class="dropdown-item" href="dashboard.php">
                        <i class="fas fa-tachometer-alt"></i>
                        <span>Dashboard</span>
                    </a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="change-password.php">
                        <i class="fas fa-key"></i>
                        <span>Change Password</span>
                    </a>
                    <a class="dropdown-item" href="#" onclick="showActivityLogs()">
                        <i class="fas fa-history"></i>
                        <span>Activity Logs</span>
                    </a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="logout.php" style="color: #EF4444;">
                        <i class="fas fa-sign-out-alt"></i>
                        <span>Sign Out</span>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Loading Indicator -->
    <div id="page-header-loader" class="overlay-header bg-primary" style="display: none;">
        <div class="content-header content-header-fullrow text-center">
            <div class="content-header-item">
                <i class="fas fa-spinner fa-spin text-white"></i>
            </div>
        </div>
    </div>
</header>

<script>
function showActivityLogs() {
    // Function to show activity logs modal or navigate to logs page
    alert('Activity Logs feature - to be implemented');
}

// Search functionality
document.querySelector('.search-input').addEventListener('input', function(e) {
    const searchTerm = e.target.value.toLowerCase();
    // Implement search functionality here
    console.log('Searching for:', searchTerm);
});

// Theme toggle functionality
document.querySelectorAll('[data-toggle="theme"]').forEach(button => {
    button.addEventListener('click', function() {
        // Remove active class from all theme buttons
        document.querySelectorAll('.theme-option').forEach(btn => btn.classList.remove('active'));
        // Add active class to clicked button
        this.classList.add('active');
        
        // Apply theme
        const theme = this.dataset.theme;
        if (theme === 'dark') {
            document.documentElement.style.setProperty('--card-white', '#2D3748');
            document.documentElement.style.setProperty('--text-dark', '#FFFFFF');
            document.documentElement.style.setProperty('--bg-peach', '#1A202C');
        } else {
            document.documentElement.style.setProperty('--card-white', '#FFFFFF');
            document.documentElement.style.setProperty('--text-dark', '#2D3748');
            document.documentElement.style.setProperty('--bg-peach', '#FEF7F0');
        }
    });
});
</script>

<!-- Draft 1-->