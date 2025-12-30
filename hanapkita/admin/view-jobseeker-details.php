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
    <title>Hanap-Kita - View Job Seeker</title>
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

        /* Page Header */
        .page-header {
            background: linear-gradient(135deg, var(--card-white) 0%, #FEFBF8 100%);
            border-radius: 20px;
            padding: 2.5rem;
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

        .header-info {
            flex: 1;
            min-width: 300px;
        }

        .page-title {
            font-size: 2.5rem;
            font-weight: 800;
            margin: 0 0 0.5rem 0;
            background: linear-gradient(135deg, var(--primary-orange), #FF8F42);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            line-height: 1.1;
        }

        .page-subtitle {
            color: var(--text-gray);
            font-size: 1.1rem;
            margin: 0;
            line-height: 1.6;
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
            border-radius: 14px;
            padding: 14px 28px;
            font-weight: 600;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            transition: all 0.3s ease;
            box-shadow: 0 6px 20px rgba(255, 107, 0, 0.3);
        }

        .back-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(255, 107, 0, 0.4);
            color: white;
            text-decoration: none;
        }

        /* Profile Layout */
        .profile-container {
            display: grid;
            grid-template-columns: 400px 1fr;
            gap: 2rem;
            margin-bottom: 2rem;
        }

        /* Profile Card */
        .profile-card {
            background: linear-gradient(135deg, var(--card-white) 0%, #FEFBF8 100%);
            border-radius: 24px;
            padding: 2.5rem;
            box-shadow: var(--shadow-card);
            border: 1px solid rgba(255, 107, 0, 0.1);
            text-align: center;
            position: relative;
            overflow: hidden;
            height: fit-content;
        }

        .profile-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, var(--primary-orange), #FF8F42);
            border-radius: 24px 24px 0 0;
        }

        .profile-avatar {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            margin: 0 auto 2rem;
            position: relative;
            box-shadow: 0 12px 30px rgba(255, 107, 0, 0.3);
            border: 6px solid white;
            background: linear-gradient(135deg, var(--primary-orange), #FF8F42);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 3rem;
            font-weight: 700;
            color: white;
            overflow: hidden;
        }

        .avatar-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 50%;
        }

        .profile-name {
            font-size: 2rem;
            font-weight: 800;
            color: var(--text-dark);
            margin: 0 0 0.5rem 0;
            line-height: 1.2;
        }

        .profile-email {
            font-size: 1.125rem;
            color: var(--text-gray);
            margin: 0 0 1.5rem 0;
            font-weight: 500;
        }

        .profile-status {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 20px;
            border-radius: 12px;
            font-size: 0.875rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 2rem;
        }

        .status-active {
            background: rgba(72, 187, 120, 0.1);
            color: var(--success-green);
            border: 2px solid rgba(72, 187, 120, 0.2);
        }

        .status-inactive {
            background: rgba(239, 68, 68, 0.1);
            color: var(--error-red);
            border: 2px solid rgba(239, 68, 68, 0.2);
        }

        .status-indicator {
            width: 12px;
            height: 12px;
            border-radius: 50%;
            background: currentColor;
            animation: pulse 2s ease-in-out infinite;
        }

        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.5; }
        }

        .contact-section {
            text-align: left;
            margin-top: 2rem;
        }

        .contact-item {
            display: flex;
            align-items: center;
            gap: 1rem;
            padding: 1rem;
            margin-bottom: 0.75rem;
            background: rgba(255, 107, 0, 0.05);
            border-radius: 12px;
            border-left: 4px solid var(--primary-orange);
            transition: all 0.3s ease;
        }

        .contact-item:hover {
            background: rgba(255, 107, 0, 0.1);
            transform: translateX(4px);
        }

        .contact-icon {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            background: linear-gradient(135deg, var(--primary-orange), #FF8F42);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
            flex-shrink: 0;
        }

        .contact-details {
            flex: 1;
        }

        .contact-label {
            font-size: 0.75rem;
            font-weight: 600;
            color: var(--text-gray);
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin: 0;
        }

        .contact-value {
            font-size: 1rem;
            font-weight: 600;
            color: var(--text-dark);
            margin: 2px 0 0 0;
        }

        /* Details Panel */
        .details-panel {
            display: flex;
            flex-direction: column;
            gap: 2rem;
        }

        .detail-card {
            background: var(--card-white);
            border-radius: 20px;
            padding: 2rem;
            box-shadow: var(--shadow-card);
            border: 1px solid rgba(255, 107, 0, 0.1);
            transition: all 0.3s ease;
        }

        .detail-card:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-hover);
        }

        .detail-header {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-bottom: 1.5rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid rgba(255, 107, 0, 0.1);
        }

        .detail-icon {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            background: linear-gradient(135deg, var(--primary-orange), #FF8F42);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
        }

        .detail-title {
            font-size: 1.375rem;
            font-weight: 700;
            color: var(--text-dark);
            margin: 0;
        }

        .detail-content {
            font-size: 1rem;
            color: var(--text-gray);
            line-height: 1.6;
            margin: 0;
        }

        .detail-content.large {
            font-size: 1.125rem;
            padding: 1.5rem;
            background: rgba(255, 107, 0, 0.03);
            border-radius: 12px;
            border-left: 4px solid var(--primary-orange);
        }

        /* Skills Section */
        .skills-container {
            display: flex;
            flex-wrap: wrap;
            gap: 0.75rem;
            margin-top: 1rem;
        }

        .skill-tag {
            background: linear-gradient(135deg, rgba(255, 107, 0, 0.1), rgba(255, 143, 66, 0.05));
            color: var(--primary-orange);
            padding: 8px 16px;
            border-radius: 8px;
            font-size: 0.875rem;
            font-weight: 600;
            border: 1px solid rgba(255, 107, 0, 0.2);
            transition: all 0.3s ease;
        }

        .skill-tag:hover {
            background: linear-gradient(135deg, rgba(255, 107, 0, 0.2), rgba(255, 143, 66, 0.1));
            transform: translateY(-1px);
        }

        /* Action Cards */
        .action-cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 1.5rem;
            margin-top: 2rem;
        }

        .action-card {
            background: linear-gradient(135deg, rgba(255, 107, 0, 0.05), rgba(255, 143, 66, 0.03));
            border: 2px solid rgba(255, 107, 0, 0.1);
            border-radius: 16px;
            padding: 2rem;
            text-decoration: none;
            color: inherit;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            display: flex;
            align-items: center;
            gap: 1.5rem;
        }

        .action-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 4px;
            height: 100%;
            background: linear-gradient(180deg, var(--primary-orange), #FF8F42);
            transition: all 0.3s ease;
        }

        .action-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 25px rgba(255, 107, 0, 0.15);
            border-color: var(--primary-orange);
            text-decoration: none;
            color: inherit;
        }

        .action-card:hover::before {
            width: 100%;
        }

        .action-card-icon {
            width: 64px;
            height: 64px;
            border-radius: 16px;
            background: linear-gradient(135deg, var(--primary-orange), #FF8F42);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            flex-shrink: 0;
            transition: all 0.3s ease;
            box-shadow: 0 8px 20px rgba(255, 107, 0, 0.3);
            position: relative;
            z-index: 2;
        }

        .action-card:hover .action-card-icon {
            background: white;
            color: var(--primary-orange);
            transform: scale(1.1);
        }

        .action-card-content {
            flex: 1;
            position: relative;
            z-index: 2;
        }

        .action-card-title {
            font-size: 1.25rem;
            font-weight: 700;
            color: var(--text-dark);
            margin: 0 0 0.5rem 0;
            transition: all 0.3s ease;
        }

        .action-card-description {
            font-size: 0.875rem;
            color: var(--text-gray);
            margin: 0;
            line-height: 1.4;
            transition: all 0.3s ease;
        }

        .action-card:hover .action-card-title,
        .action-card:hover .action-card-description {
            color: white;
        }

        .resume-link {
            background: linear-gradient(135deg, #4A90E2, #357ABD);
        }

        .resume-link::before {
            background: linear-gradient(180deg, #4A90E2, #357ABD);
        }

        .resume-link:hover {
            border-color: #4A90E2;
        }

        .resume-link .action-card-icon {
            background: linear-gradient(135deg, #4A90E2, #357ABD);
            box-shadow: 0 8px 20px rgba(74, 144, 226, 0.3);
        }

        .resume-link:hover .action-card-icon {
            background: white;
            color: #4A90E2;
        }

        /* Empty State */
        .empty-content {
            text-align: center;
            padding: 3rem;
            color: var(--text-gray);
            font-style: italic;
        }

        /* Responsive Design */
        @media (max-width: 1200px) {
            .profile-container {
                grid-template-columns: 350px 1fr;
                gap: 1.5rem;
            }
        }

        @media (max-width: 992px) {
            .profile-container {
                grid-template-columns: 1fr;
                gap: 2rem;
            }

            .profile-card {
                order: 1;
            }

            .details-panel {
                order: 2;
            }
        }

        @media (max-width: 768px) {
            .main-content {
                padding: 1rem;
            }

            .page-header {
                padding: 2rem;
            }

            .header-content {
                flex-direction: column;
                align-items: stretch;
            }

            .profile-card {
                padding: 2rem;
            }

            .profile-avatar {
                width: 120px;
                height: 120px;
                font-size: 2.5rem;
            }

            .profile-name {
                font-size: 1.5rem;
            }

            .action-cards {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 480px) {
            .page-title {
                font-size: 2rem;
            }

            .profile-avatar {
                width: 100px;
                height: 100px;
                font-size: 2rem;
            }

            .action-card {
                padding: 1.5rem;
                flex-direction: column;
                text-align: center;
                gap: 1rem;
            }

            .action-card-icon {
                width: 56px;
                height: 56px;
                font-size: 20px;
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
                <!-- Page Header -->
                <div class="page-header fade-in">
                    <div class="header-content">
                        <div class="header-info">
                            <h1 class="page-title">Job Seeker Profile</h1>
                            <p class="page-subtitle">Complete candidate information and professional details</p>
                        </div>
                        <div class="header-actions">
                            <a href="reg-jobseekers.php" class="back-btn">
                                <i class="fas fa-arrow-left"></i>
                                Back to Job Seekers
                            </a>
                        </div>
                    </div>
                </div>

                <?php
                $vid=$_GET['viewid'];
                $sql="SELECT * from tbljobseekers where id=:vid";
                $query = $dbh -> prepare($sql);
                $query-> bindParam(':vid', $vid, PDO::PARAM_STR);
                $query->execute();
                $results=$query->fetchAll(PDO::FETCH_OBJ);

                $cnt=1;
                if($query->rowCount() > 0) {
                    foreach($results as $row) {
                ?>

                <!-- Profile Container -->
                <div class="profile-container slide-in">
                    <!-- Profile Card -->
                    <div class="profile-card">
                        <div class="profile-avatar">
                            <?php if(!empty($row->ProfilePic)): ?>
                                <img src="../images/<?php echo $row->ProfilePic; ?>" 
                                     alt="<?php echo htmlentities($row->FullName); ?>" 
                                     class="avatar-img"
                                     onerror="this.style.display='none'; this.parentElement.innerHTML='<?php echo strtoupper(substr($row->FullName, 0, 2)); ?>';">
                            <?php else: ?>
                                <?php echo strtoupper(substr($row->FullName, 0, 2)); ?>
                            <?php endif; ?>
                        </div>

                        <h2 class="profile-name"><?php echo htmlentities($row->FullName); ?></h2>
                        <p class="profile-email"><?php echo htmlentities($row->EmailId); ?></p>

                        <div class="profile-status <?php echo ($row->IsActive == '1') ? 'status-active' : 'status-inactive'; ?>">
                            <div class="status-indicator"></div>
                            <?php echo ($row->IsActive == '1') ? 'Active Profile' : 'Inactive Profile'; ?>
                        </div>

                        <div class="contact-section">
                            <div class="contact-item">
                                <div class="contact-icon">
                                    <i class="fas fa-phone"></i>
                                </div>
                                <div class="contact-details">
                                    <p class="contact-label">Contact Number</p>
                                    <p class="contact-value"><?php echo htmlentities($row->ContactNumber); ?></p>
                                </div>
                            </div>

                            <div class="contact-item">
                                <div class="contact-icon">
                                    <i class="fas fa-calendar-alt"></i>
                                </div>
                                <div class="contact-details">
                                    <p class="contact-label">Registration Date</p>
                                    <p class="contact-value"><?php echo date('F j, Y', strtotime($row->RegDate)); ?></p>
                                </div>
                            </div>

                            <?php if(!empty($row->LastUpdationDate)): ?>
                            <div class="contact-item">
                                <div class="contact-icon">
                                    <i class="fas fa-edit"></i>
                                </div>
                                <div class="contact-details">
                                    <p class="contact-label">Last Updated</p>
                                    <p class="contact-value"><?php echo date('F j, Y', strtotime($row->LastUpdationDate)); ?></p>
                                </div>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Details Panel -->
                    <div class="details-panel">
                        <!-- About Section -->
                        <?php if(!empty($row->AboutMe)): ?>
                        <div class="detail-card">
                            <div class="detail-header">
                                <div class="detail-icon">
                                    <i class="fas fa-user"></i>
                                </div>
                                <h3 class="detail-title">About Candidate</h3>
                            </div>
                            <p class="detail-content large"><?php echo htmlentities($row->AboutMe); ?></p>
                        </div>
                        <?php endif; ?>

                        <!-- Skills Section -->
                        <?php if(!empty($row->Skills)): ?>
                        <div class="detail-card">
                            <div class="detail-header">
                                <div class="detail-icon">
                                    <i class="fas fa-tools"></i>
                                </div>
                                <h3 class="detail-title">Skills & Expertise</h3>
                            </div>
                            <div class="skills-container">
                                <?php 
                                $skills = explode(',', $row->Skills);
                                foreach($skills as $skill) {
                                    $trimmed_skill = trim($skill);
                                    if(!empty($trimmed_skill)) {
                                        echo '<span class="skill-tag">' . htmlentities($trimmed_skill) . '</span>';
                                    }
                                }
                                ?>
                            </div>
                        </div>
                        <?php endif; ?>

                        <!-- Professional Summary -->
                        <div class="detail-card">
                            <div class="detail-header">
                                <div class="detail-icon">
                                    <i class="fas fa-chart-line"></i>
                                </div>
                                <h3 class="detail-title">Professional Summary</h3>
                            </div>
                            <div class="detail-content">
                                <p><strong>Profile ID:</strong> #<?php echo str_pad($row->id, 4, '0', STR_PAD_LEFT); ?></p>
                                <p><strong>Full Name:</strong> <?php echo htmlentities($row->FullName); ?></p>
                                <p><strong>Email Address:</strong> <?php echo htmlentities($row->EmailId); ?></p>
                                <p><strong>Contact Number:</strong> <?php echo htmlentities($row->ContactNumber); ?></p>
                                <p><strong>Account Status:</strong> 
                                    <span style="color: <?php echo ($row->IsActive == '1') ? 'var(--success-green)' : 'var(--error-red)'; ?>; font-weight: 600;">
                                        <?php echo ($row->IsActive == '1') ? 'Active' : 'Inactive'; ?>
                                    </span>
                                </p>
                                <p><strong>Registered:</strong> <?php echo date('F j, Y \a\t g:i A', strtotime($row->RegDate)); ?></p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Action Cards -->
                <div class="action-cards">
                    <?php if(!empty($row->Resume)): ?>
                    <a href="../Jobseekersresumes/<?php echo htmlentities($row->Resume); ?>" 
                       class="action-card resume-link" target="_blank">
                        <div class="action-card-icon">
                            <i class="fas fa-file-pdf"></i>
                        </div>
                        <div class="action-card-content">
                            <h4 class="action-card-title">Download Resume</h4>
                            <p class="action-card-description">View and download the candidate's complete resume and CV</p>
                        </div>
                    </a>
                    <?php else: ?>
                    <div class="action-card" style="opacity: 0.6; cursor: not-allowed;">
                        <div class="action-card-icon" style="background: var(--text-light);">
                            <i class="fas fa-file-pdf"></i>
                        </div>
                        <div class="action-card-content">
                            <h4 class="action-card-title">Resume Not Available</h4>
                            <p class="action-card-description">This candidate hasn't uploaded a resume yet</p>
                        </div>
                    </div>
                    <?php endif; ?>

                    <a href="jobsapplied-jobseekers.php?jobsid=<?php echo htmlentities($row->id); ?>&&jsname=<?php echo htmlentities($row->FullName); ?>" 
                       class="action-card" target="_blank">
                        <div class="action-card-icon">
                            <i class="fas fa-briefcase"></i>
                        </div>
                        <div class="action-card-content">
                            <h4 class="action-card-title">View Applications</h4>
                            <p class="action-card-description">See all job applications submitted by this candidate</p>
                        </div>
                    </a>

                    <a href="reg-jobseekers.php" class="action-card">
                        <div class="action-card-icon">
                            <i class="fas fa-users"></i>
                        </div>
                        <div class="action-card-content">
                            <h4 class="action-card-title">All Job Seekers</h4>
                            <p class="action-card-description">Return to the complete list of registered candidates</p>
                        </div>
                    </a>
                </div>

                <?php 
                    $cnt=$cnt+1;
                    }
                } else {
                ?>
                <div class="detail-card">
                    <div class="empty-content">
                        <h3>Job Seeker Not Found</h3>
                        <p>The requested candidate profile could not be found or may have been removed.</p>
                        <a href="reg-jobseekers.php" class="back-btn" style="margin-top: 1rem;">
                            <i class="fas fa-arrow-left"></i>
                            Back to Job Seekers
                        </a>
                    </div>
                </div>
                <?php } ?>
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
        // Enhanced animations on page load
        document.addEventListener('DOMContentLoaded', function() {
            // Animate detail cards with staggered effect
            const detailCards = document.querySelectorAll('.detail-card');
            detailCards.forEach((card, index) => {
                card.style.opacity = '0';
                card.style.transform = 'translateY(30px)';
                
                setTimeout(() => {
                    card.style.transition = 'all 0.8s cubic-bezier(0.4, 0, 0.2, 1)';
                    card.style.opacity = '1';
                    card.style.transform = 'translateY(0)';
                }, 300 + (index * 200));
            });

            // Animate action cards
            const actionCards = document.querySelectorAll('.action-card');
            actionCards.forEach((card, index) => {
                card.style.opacity = '0';
                card.style.transform = 'translateX(-20px)';
                
                setTimeout(() => {
                    card.style.transition = 'all 0.6s ease';
                    card.style.opacity = '1';
                    card.style.transform = 'translateX(0)';
                }, 800 + (index * 150));
            });

            // Animate skills with staggered effect
            const skillTags = document.querySelectorAll('.skill-tag');
            skillTags.forEach((skill, index) => {
                skill.style.opacity = '0';
                skill.style.transform = 'scale(0.8)';
                
                setTimeout(() => {
                    skill.style.transition = 'all 0.4s ease';
                    skill.style.opacity = '1';
                    skill.style.transform = 'scale(1)';
                }, 1000 + (index * 100));
            });
        });

        // Enhanced hover effects for contact items
        document.querySelectorAll('.contact-item').forEach(item => {
            item.addEventListener('mouseenter', function() {
                this.style.transform = 'translateX(8px)';
                this.style.background = 'rgba(255, 107, 0, 0.12)';
            });
            
            item.addEventListener('mouseleave', function() {
                this.style.transform = 'translateX(4px)';
                this.style.background = 'rgba(255, 107, 0, 0.05)';
            });
        });

        // Handle broken profile images
        document.querySelectorAll('.avatar-img').forEach(img => {
            img.addEventListener('error', function() {
                this.style.display = 'none';
                const initials = this.alt.split(' ').map(word => word.charAt(0)).join('').substring(0, 2).toUpperCase();
                this.parentElement.innerHTML = initials;
                this.parentElement.style.background = 'linear-gradient(135deg, var(--primary-orange), #FF8F42)';
                this.parentElement.style.color = 'white';
            });
        });

        // Smooth scroll for action cards
        document.querySelectorAll('.action-card[href^="#"]').forEach(card => {
            card.addEventListener('click', function(e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });
    </script>
</body>
</html>
<?php }  ?>

<!--- Done 24 -->