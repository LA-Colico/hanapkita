<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
if (strlen($_SESSION['jpaid']==0)) {
  header('location:logout.php');
  } else{
    if(isset($_POST['submit']))
  {
    $adminid=$_SESSION['jpaid'];
    $AName=$_POST['adminname'];
  $mobno=$_POST['mobilenumber'];
  $email=$_POST['email'];
  $sql="update tbladmin set AdminName=:adminname,MobileNumber=:mobilenumber,Email=:email where ID=:aid";
     $query = $dbh->prepare($sql);
     $query->bindParam(':adminname',$AName,PDO::PARAM_STR);
     $query->bindParam(':email',$email,PDO::PARAM_STR);
     $query->bindParam(':mobilenumber',$mobno,PDO::PARAM_STR);
     $query->bindParam(':aid',$adminid,PDO::PARAM_STR);
$query->execute();

        echo '<script>alert("Profile has been updated")</script>';
     

  }
  ?>
<!doctype html>
<html lang="en" class="no-focus">
<head>
    <title>Hanap-Kita - Admin Profile</title>
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
            max-width: 1000px;
            margin: 0 auto;
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
            align-items: center;
            gap: 2rem;
        }

        .admin-avatar {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--primary-orange), #FF8F42);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            font-weight: 700;
            color: white;
            box-shadow: 0 8px 20px rgba(255, 107, 0, 0.3);
            flex-shrink: 0;
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
            line-height: 1.5;
        }

        .admin-badges {
            display: flex;
            gap: 0.75rem;
            margin-top: 1rem;
        }

        .badge {
            padding: 0.5rem 1rem;
            border-radius: 8px;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .badge-admin {
            background: linear-gradient(135deg, var(--primary-orange), #FF8F42);
            color: white;
        }

        .badge-active {
            background: rgba(72, 187, 120, 0.1);
            color: var(--success-green);
            border: 1px solid rgba(72, 187, 120, 0.2);
        }

        /* Profile Content Grid */
        .profile-grid {
            display: grid;
            grid-template-columns: 1fr 300px;
            gap: 2rem;
            margin-bottom: 2rem;
        }

        /* Main Form Card */
        .form-card {
            background: var(--card-white);
            border-radius: 20px;
            padding: 2.5rem;
            box-shadow: var(--shadow-card);
            border: 1px solid rgba(255, 107, 0, 0.1);
            position: relative;
            overflow: hidden;
        }

        .form-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: linear-gradient(90deg, var(--primary-orange), #FF8F42);
            border-radius: 20px 20px 0 0;
        }

        .form-header {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-bottom: 2rem;
            padding-bottom: 1.5rem;
            border-bottom: 2px solid rgba(255, 107, 0, 0.1);
        }

        .form-header-icon {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            background: linear-gradient(135deg, var(--primary-orange), #FF8F42);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            box-shadow: 0 4px 8px rgba(255, 107, 0, 0.3);
        }

        .form-header-text h2 {
            font-size: 1.5rem;
            font-weight: 600;
            color: var(--text-dark);
            margin: 0;
        }

        .form-header-text p {
            font-size: 0.875rem;
            color: var(--text-gray);
            margin: 0;
        }

        /* Form Elements */
        .modern-form {
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
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
            width: 16px;
            text-align: center;
        }

        .form-label .readonly-badge {
            background: rgba(113, 128, 150, 0.1);
            color: var(--text-gray);
            padding: 0.25rem 0.5rem;
            border-radius: 4px;
            font-size: 0.675rem;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .form-input {
            width: 100%;
            padding: 1rem 1.25rem;
            border: 2px solid rgba(255, 107, 0, 0.1);
            border-radius: 12px;
            background: var(--card-white);
            font-size: 0.95rem;
            font-family: inherit;
            transition: all 0.3s ease;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        }

        .form-input:focus {
            outline: none;
            border-color: var(--primary-orange);
            box-shadow: 0 0 0 3px rgba(255, 107, 0, 0.1);
            transform: translateY(-1px);
        }

        .form-input:read-only {
            background: rgba(113, 128, 150, 0.05);
            border-color: rgba(113, 128, 150, 0.1);
            color: var(--text-gray);
            cursor: not-allowed;
        }

        .form-help {
            font-size: 0.875rem;
            color: var(--text-gray);
            margin: 0;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .form-help i {
            color: var(--primary-orange);
            font-size: 0.75rem;
        }

        /* Action Buttons */
        .form-actions {
            margin-top: 1.5rem;
            padding-top: 2rem;
            border-top: 1px solid rgba(255, 107, 0, 0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 1rem;
        }

        .btn-modern {
            padding: 0.875rem 2rem;
            border: none;
            border-radius: 12px;
            font-size: 0.95rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            min-width: 140px;
            justify-content: center;
            font-family: inherit;
            text-decoration: none;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary-orange), #FF8F42);
            color: white;
            box-shadow: 0 4px 12px rgba(255, 107, 0, 0.3);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(255, 107, 0, 0.4);
        }

        .btn-secondary {
            background: rgba(255, 107, 0, 0.1);
            color: var(--primary-orange);
            border: 2px solid rgba(255, 107, 0, 0.2);
        }

        .btn-secondary:hover {
            background: rgba(255, 107, 0, 0.2);
            transform: translateY(-1px);
            text-decoration: none;
            color: var(--primary-orange);
        }

        /* Sidebar Info Card */
        .info-sidebar {
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
        }

        .info-card {
            background: var(--card-white);
            border-radius: 16px;
            padding: 1.5rem;
            box-shadow: var(--shadow-soft);
            border: 1px solid rgba(255, 107, 0, 0.1);
        }

        .info-card-header {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            margin-bottom: 1rem;
        }

        .info-card-icon {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            background: linear-gradient(135deg, var(--primary-orange), #FF8F42);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
        }

        .info-card-title {
            font-size: 1.125rem;
            font-weight: 600;
            color: var(--text-dark);
            margin: 0;
        }

        .info-list {
            list-style: none;
            padding: 0;
            margin: 0;
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
        }

        .info-list li {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            font-size: 0.875rem;
            color: var(--text-gray);
            padding: 0.5rem 0;
            border-bottom: 1px solid rgba(255, 107, 0, 0.05);
        }

        .info-list li:last-child {
            border-bottom: none;
        }

        .info-list li i {
            color: var(--primary-orange);
            font-size: 0.875rem;
            width: 16px;
            text-align: center;
        }

        .info-list li strong {
            color: var(--text-dark);
            font-weight: 600;
        }

        /* Quick Actions */
        .quick-actions {
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
        }

        .action-btn {
            padding: 0.75rem 1rem;
            border-radius: 10px;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            font-size: 0.875rem;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .action-btn-primary {
            background: rgba(255, 107, 0, 0.1);
            color: var(--primary-orange);
            border: 1px solid rgba(255, 107, 0, 0.2);
        }

        .action-btn-primary:hover {
            background: rgba(255, 107, 0, 0.2);
            text-decoration: none;
            color: var(--primary-orange);
            transform: translateY(-1px);
        }

        .action-btn-secondary {
            background: rgba(66, 153, 225, 0.1);
            color: var(--info-blue);
            border: 1px solid rgba(66, 153, 225, 0.2);
        }

        .action-btn-secondary:hover {
            background: rgba(66, 153, 225, 0.2);
            text-decoration: none;
            color: var(--info-blue);
            transform: translateY(-1px);
        }

        /* Activity Timeline */
        .activity-timeline {
            border-left: 2px solid rgba(255, 107, 0, 0.2);
            padding-left: 1rem;
            margin-left: 0.5rem;
        }

        .timeline-item {
            position: relative;
            padding-bottom: 1rem;
            margin-bottom: 1rem;
        }

        .timeline-item::before {
            content: '';
            position: absolute;
            left: -1.375rem;
            top: 0.5rem;
            width: 8px;
            height: 8px;
            background: var(--primary-orange);
            border-radius: 50%;
            border: 2px solid white;
            box-shadow: 0 0 0 2px rgba(255, 107, 0, 0.2);
        }

        .timeline-time {
            font-size: 0.75rem;
            color: var(--text-light);
            margin: 0 0 0.25rem 0;
        }

        .timeline-content {
            font-size: 0.875rem;
            color: var(--text-gray);
            margin: 0;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .main-content {
                padding: 1rem;
            }

            .profile-grid {
                grid-template-columns: 1fr;
                gap: 1.5rem;
            }

            .header-content {
                flex-direction: column;
                text-align: center;
                gap: 1rem;
            }

            .admin-badges {
                justify-content: center;
            }

            .form-actions {
                flex-direction: column;
            }

            .btn-modern {
                width: 100%;
            }
        }

        @media (max-width: 480px) {
            .page-header, .form-card, .info-card {
                padding: 1.5rem;
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
                <div class="page-header">
                    <div class="header-content">
                        <?php
                        $sql="SELECT * from  tbladmin";
                        $query = $dbh -> prepare($sql);
                        $query->execute();
                        $results=$query->fetchAll(PDO::FETCH_OBJ);
                        $cnt=1;
                        if($query->rowCount() > 0)
                        {
                        foreach($results as $row)
                        {               ?>
                        <div class="admin-avatar">
                            <?php echo strtoupper(substr($row->AdminName, 0, 2)); ?>
                        </div>
                        <div class="header-text">
                            <h1><?php echo htmlentities($row->AdminName); ?></h1>
                            <p>Administrator • Manage your profile information and account settings</p>
                            <div class="admin-badges">
                                <span class="badge badge-admin">Administrator</span>
                                <span class="badge badge-active">Active</span>
                            </div>
                        </div>
                        <?php $cnt=$cnt+1;}} ?>
                    </div>
                </div>

                <!-- Profile Content Grid -->
                <div class="profile-grid">
                    <!-- Main Form -->
                    <div class="form-card">
                        <div class="form-header">
                            <div class="form-header-icon">
                                <i class="fas fa-user-edit"></i>
                            </div>
                            <div class="form-header-text">
                                <h2>Profile Information</h2>
                                <p>Update your personal information and contact details</p>
                            </div>
                        </div>

                        <?php
                        $sql="SELECT * from  tbladmin";
                        $query = $dbh -> prepare($sql);
                        $query->execute();
                        $results=$query->fetchAll(PDO::FETCH_OBJ);
                        $cnt=1;
                        if($query->rowCount() > 0)
                        {
                        foreach($results as $row)
                        {               ?>
                        <form method="post" class="modern-form" id="profileForm">
                            <!-- Admin Name -->
                            <div class="form-group">
                                <label class="form-label" for="adminname">
                                    <i class="fas fa-user"></i>
                                    Full Name
                                </label>
                                <input 
                                    type="text" 
                                    class="form-input" 
                                    name="adminname" 
                                    id="adminname"
                                    value="<?php echo htmlentities($row->AdminName); ?>" 
                                    required="true"
                                    placeholder="Enter your full name"
                                >
                                <p class="form-help">
                                    <i class="fas fa-info-circle"></i>
                                    This name will be displayed across the admin interface
                                </p>
                            </div>

                            <!-- Username (Read-only) -->
                            <div class="form-group">
                                <label class="form-label" for="username">
                                    <i class="fas fa-at"></i>
                                    Username
                                    <span class="readonly-badge">Read Only</span>
                                </label>
                                <input 
                                    type="text" 
                                    class="form-input" 
                                    name="username" 
                                    id="username"
                                    value="<?php echo htmlentities($row->UserName); ?>" 
                                    readonly="true"
                                >
                                <p class="form-help">
                                    <i class="fas fa-lock"></i>
                                    Username cannot be changed for security reasons
                                </p>
                            </div>

                            <!-- Email -->
                            <div class="form-group">
                                <label class="form-label" for="email">
                                    <i class="fas fa-envelope"></i>
                                    Email Address
                                </label>
                                <input 
                                    type="email" 
                                    class="form-input" 
                                    name="email" 
                                    id="email"
                                    value="<?php echo htmlentities($row->Email); ?>" 
                                    required="true"
                                    placeholder="Enter your email address"
                                >
                                <p class="form-help">
                                    <i class="fas fa-shield-alt"></i>
                                    Used for important notifications and password recovery
                                </p>
                            </div>

                            <!-- Mobile Number -->
                            <div class="form-group">
                                <label class="form-label" for="mobilenumber">
                                    <i class="fas fa-phone"></i>
                                    Contact Number
                                </label>
                                <input 
                                    type="text" 
                                    class="form-input" 
                                    name="mobilenumber" 
                                    id="mobilenumber"
                                    value="<?php echo htmlentities($row->MobileNumber); ?>" 
                                    required="true" 
                                    maxlength="10"
                                    pattern="[0-9]+"
                                    placeholder="Enter your mobile number"
                                >
                                <p class="form-help">
                                    <i class="fas fa-mobile-alt"></i>
                                    10-digit mobile number for contact and verification
                                </p>
                            </div>

                            <!-- Registration Date (Read-only) -->
                            <div class="form-group">
                                <label class="form-label" for="regdate">
                                    <i class="fas fa-calendar-alt"></i>
                                    Registration Date
                                    <span class="readonly-badge">Read Only</span>
                                </label>
                                <input 
                                    type="text" 
                                    class="form-input" 
                                    id="regdate"
                                    value="<?php echo date('F j, Y g:i A', strtotime($row->AdminRegdate)); ?>" 
                                    readonly="true"
                                >
                                <p class="form-help">
                                    <i class="fas fa-history"></i>
                                    Date when this admin account was created
                                </p>
                            </div>

                            <!-- Form Actions -->
                            <div class="form-actions">
                                <div>
                                    <a href="dashboard.php" class="btn-modern btn-secondary">
                                        <i class="fas fa-arrow-left"></i>
                                        Back to Dashboard
                                    </a>
                                </div>
                                <div>
                                    <button type="submit" class="btn-modern btn-primary" name="submit">
                                        <i class="fas fa-save"></i>
                                        Update Profile
                                    </button>
                                </div>
                            </div>
                        </form>
                        <?php $cnt=$cnt+1;}} ?>
                    </div>

                    <!-- Sidebar Info -->
                    <div class="info-sidebar">
                        <!-- Account Info -->
                        <div class="info-card">
                            <div class="info-card-header">
                                <div class="info-card-icon">
                                    <i class="fas fa-info-circle"></i>
                                </div>
                                <h3 class="info-card-title">Account Information</h3>
                            </div>
                            <ul class="info-list">
                                <li>
                                    <i class="fas fa-shield-alt"></i>
                                    <span>Account Type: <strong>Administrator</strong></span>
                                </li>
                                <li>
                                    <i class="fas fa-check-circle"></i>
                                    <span>Status: <strong style="color: var(--success-green);">Active</strong></span>
                                </li>
                                <li>
                                    <i class="fas fa-key"></i>
                                    <span>Security: <strong>Two-Factor Ready</strong></span>
                                </li>
                                <li>
                                    <i class="fas fa-clock"></i>
                                    <span>Last Login: <strong>Today</strong></span>
                                </li>
                            </ul>
                        </div>

                        <!-- Quick Actions 
                        <div class="info-card">
                            <div class="info-card-header">
                                <div class="info-card-icon">
                                    <i class="fas fa-bolt"></i>
                                </div>
                                <h3 class="info-card-title">Quick Actions</h3>
                            </div>
                            <div class="quick-actions">
                                <a href="change-password.php" class="action-btn action-btn-primary">
                                    <i class="fas fa-key"></i>
                                    Change Password
                                </a>
                                <a href="activity-logs.php" class="action-btn action-btn-secondary">
                                    <i class="fas fa-history"></i>
                                    View Activity Logs
                                </a>
                                <a href="dashboard.php" class="action-btn action-btn-secondary">
                                    <i class="fas fa-tachometer-alt"></i>
                                    Dashboard Overview
                                </a>
                            </div>
                        </div> -->

                        <!-- Recent Activity 
                        <div class="info-card">
                            <div class="info-card-header">
                                <div class="info-card-icon">
                                    <i class="fas fa-history"></i>
                                </div>
                                <h3 class="info-card-title">Recent Activity</h3>
                            </div>
                            <div class="activity-timeline">
                                <div class="timeline-item">
                                    <p class="timeline-time">Today, 2:30 PM</p>
                                    <p class="timeline-content">Logged into admin dashboard</p>
                                </div>
                                <div class="timeline-item">
                                    <p class="timeline-time">Yesterday, 4:15 PM</p>
                                    <p class="timeline-content">Updated job category settings</p>
                                </div>
                                <div class="timeline-item">
                                    <p class="timeline-time">2 days ago</p>
                                    <p class="timeline-content">Reviewed new employer registrations</p>
                                </div>
                            </div>
                        </div>-->
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
        // Form validation
        document.getElementById('profileForm').addEventListener('submit', function(e) {
            const adminName = document.getElementById('adminname').value.trim();
            const email = document.getElementById('email').value.trim();
            const mobile = document.getElementById('mobilenumber').value.trim();
            
            // Validate admin name
            if (adminName.length < 2) {
                e.preventDefault();
                alert('Admin name must be at least 2 characters long.');
                document.getElementById('adminname').focus();
                return false;
            }
            
            // Validate email format
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(email)) {
                e.preventDefault();
                alert('Please enter a valid email address.');
                document.getElementById('email').focus();
                return false;
            }
            
            // Validate mobile number
            const mobileRegex = /^[0-9]{10}$/;
            if (!mobileRegex.test(mobile)) {
                e.preventDefault();
                alert('Please enter a valid 10-digit mobile number.');
                document.getElementById('mobilenumber').focus();
                return false;
            }
            
            // Show loading state
            const submitBtn = document.querySelector('button[name="submit"]');
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Updating...';
            submitBtn.disabled = true;
        });

        // Mobile number input formatting
        document.getElementById('mobilenumber').addEventListener('input', function(e) {
            // Remove non-numeric characters
            this.value = this.value.replace(/[^0-9]/g, '');
            
            // Limit to 10 digits
            if (this.value.length > 10) {
                this.value = this.value.slice(0, 10);
            }
        });

        // Real-time form validation feedback
        const inputs = document.querySelectorAll('.form-input[required]');
        inputs.forEach(input => {
            input.addEventListener('blur', function() {
                if (this.value.trim() === '') {
                    this.style.borderColor = '#EF4444';
                } else {
                    this.style.borderColor = 'var(--success-green)';
                }
            });

            input.addEventListener('input', function() {
                if (this.value.trim() !== '') {
                    this.style.borderColor = '';
                }
            });
        });

        // Auto-save to localStorage
        function autoSave() {
            const formData = {
                adminname: document.getElementById('adminname').value,
                email: document.getElementById('email').value,
                mobilenumber: document.getElementById('mobilenumber').value,
                timestamp: Date.now()
            };
            localStorage.setItem('adminProfileDraft', JSON.stringify(formData));
        }

        // Auto-save every 30 seconds
        setInterval(autoSave, 30000);

        // Load draft on page load if available
        document.addEventListener('DOMContentLoaded', function() {
            const draft = localStorage.getItem('adminProfileDraft');
            if (draft) {
                const data = JSON.parse(draft);
                // Only load if draft is less than 1 hour old and different from current values
                if (Date.now() - data.timestamp < 60 * 60 * 1000) {
                    const currentName = document.getElementById('adminname').value;
                    const currentEmail = document.getElementById('email').value;
                    const currentMobile = document.getElementById('mobilenumber').value;
                    
                    if (data.adminname !== currentName || data.email !== currentEmail || data.mobilenumber !== currentMobile) {
                        if (confirm('Found unsaved changes. Would you like to restore them?')) {
                            document.getElementById('adminname').value = data.adminname;
                            document.getElementById('email').value = data.email;
                            document.getElementById('mobilenumber').value = data.mobilenumber;
                        }
                    }
                }
            }
        });

        // Clear draft after successful submission
        window.addEventListener('beforeunload', function() {
            if (document.querySelector('.btn-primary').disabled) {
                localStorage.removeItem('adminProfileDraft');
            }
        });

        // Custom notification system
        function showNotification(message, type = 'success') {
            const notification = document.createElement('div');
            notification.style.cssText = `
                position: fixed;
                top: 20px;
                right: 20px;
                background: ${type === 'success' ? 'linear-gradient(135deg, var(--success-green), #38A169)' : 'linear-gradient(135deg, #EF4444, #DC2626)'};
                color: white;
                padding: 1rem 1.5rem;
                border-radius: 12px;
                box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
                z-index: 10000;
                font-weight: 600;
                display: flex;
                align-items: center;
                gap: 0.5rem;
                font-family: Inter, sans-serif;
                transform: translateX(400px);
                transition: all 0.3s ease;
            `;
            
            notification.innerHTML = `
                <i class="fas fa-${type === 'success' ? 'check-circle' : 'exclamation-circle'}"></i>
                <span>${message}</span>
            `;
            
            document.body.appendChild(notification);
            
            // Animate in
            setTimeout(() => {
                notification.style.transform = 'translateX(0)';
            }, 100);
            
            // Remove after 3 seconds
            setTimeout(() => {
                notification.style.transform = 'translateX(400px)';
                setTimeout(() => notification.remove(), 300);
            }, 3000);
        }

        // Override default alert for profile update success
        if (window.location.search.includes('updated') || document.querySelector('script[src*="alert"]')) {
            setTimeout(() => {
                showNotification('Profile has been updated successfully!');
            }, 500);
        }
    </script>
</body>
</html>
<?php }  ?>

<!-- Done 5 -->