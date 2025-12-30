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
    <title>Hanap-Kita - View Employer Detail</title>
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
            flex-wrap: wrap;
            gap: 1rem;
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
            margin: 0.25rem 0 0 0;
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

        .employer-container {
            display: grid;
            grid-template-columns: 1fr 2fr;
            gap: 2rem;
            margin-bottom: 2rem;
        }

        .company-profile-card {
            background: var(--card-white);
            border-radius: 20px;
            padding: 2rem;
            box-shadow: var(--shadow-card);
            border: 1px solid rgba(255, 107, 0, 0.1);
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .company-profile-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, var(--primary-orange), #FF8F42);
            border-radius: 20px 20px 0 0;
        }

        .company-logo {
            width: 120px;
            height: 120px;
            border-radius: 20px;
            object-fit: cover;
            margin: 0 auto 1.5rem;
            box-shadow: 0 8px 20px rgba(255, 107, 0, 0.2);
            border: 4px solid white;
        }

        .company-name {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--text-dark);
            margin: 0 0 0.5rem 0;
        }

        .company-tagline {
            color: var(--text-gray);
            font-size: 1rem;
            margin: 0 0 1.5rem 0;
            font-style: italic;
        }

        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 8px 16px;
            border-radius: 12px;
            font-size: 0.875rem;
            font-weight: 600;
            margin-bottom: 1.5rem;
        }

        .status-active {
            background: rgba(72, 187, 120, 0.1);
            color: var(--success-green);
        }

        .status-inactive {
            background: rgba(239, 68, 68, 0.1);
            color: #EF4444;
        }

        .company-details-card {
            background: var(--card-white);
            border-radius: 20px;
            padding: 2rem;
            box-shadow: var(--shadow-card);
            border: 1px solid rgba(255, 107, 0, 0.1);
        }

        .details-header {
            display: flex;
            justify-content: between;
            align-items: center;
            margin-bottom: 2rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid rgba(255, 107, 0, 0.1);
        }

        .details-title {
            font-size: 1.25rem;
            font-weight: 600;
            color: var(--text-dark);
            margin: 0;
        }

        .info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .info-item {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }

        .info-label {
            font-size: 0.875rem;
            font-weight: 600;
            color: var(--text-gray);
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .info-value {
            font-size: 1rem;
            font-weight: 500;
            color: var(--text-dark);
            background: rgba(255, 107, 0, 0.05);
            padding: 12px 16px;
            border-radius: 12px;
            border-left: 4px solid var(--primary-orange);
        }

        .info-value.large {
            font-size: 1.125rem;
        }

        .description-section {
            background: var(--card-white);
            border-radius: 20px;
            padding: 2rem;
            box-shadow: var(--shadow-card);
            border: 1px solid rgba(255, 107, 0, 0.1);
            margin-bottom: 2rem;
        }

        .section-title {
            font-size: 1.25rem;
            font-weight: 600;
            color: var(--text-dark);
            margin: 0 0 1.5rem 0;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .section-icon {
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

        .description-content {
            color: var(--text-gray);
            line-height: 1.6;
            font-size: 1rem;
            padding: 1.5rem;
            background: rgba(255, 107, 0, 0.03);
            border-radius: 12px;
            border-left: 4px solid var(--primary-orange);
        }

        .contact-info {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
        }

        .contact-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 1rem;
            background: rgba(255, 107, 0, 0.05);
            border-radius: 12px;
            transition: all 0.3s ease;
        }

        .contact-item:hover {
            background: rgba(255, 107, 0, 0.1);
            transform: translateY(-2px);
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
            min-width: 0;
        }

        .contact-label {
            font-size: 0.75rem;
            font-weight: 600;
            color: var(--text-gray);
            margin: 0;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .contact-value {
            font-size: 0.875rem;
            font-weight: 500;
            color: var(--text-dark);
            margin: 2px 0 0 0;
            word-break: break-word;
        }

        .actions-section {
            margin-top: 2rem;
            padding-top: 2rem;
            border-top: 1px solid rgba(255, 107, 0, 0.1);
        }

        .action-cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 1.5rem;
        }

        .action-card {
            background: linear-gradient(135deg, rgba(255, 107, 0, 0.05), rgba(255, 143, 66, 0.05));
            border: 2px solid rgba(255, 107, 0, 0.1);
            border-radius: 16px;
            padding: 1.5rem;
            text-decoration: none;
            color: inherit;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            display: flex;
            align-items: center;
            gap: 1rem;
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

        .action-card:hover .action-icon {
            background: white;
            color: var(--primary-orange);
            transform: scale(1.1);
        }

        .action-card:hover .action-title {
            color: white;
        }

        .action-card:hover .action-description {
            color: rgba(255, 255, 255, 0.9);
        }

        .action-icon {
            width: 56px;
            height: 56px;
            border-radius: 14px;
            background: linear-gradient(135deg, var(--primary-orange), #FF8F42);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            flex-shrink: 0;
            transition: all 0.3s ease;
            box-shadow: 0 6px 15px rgba(255, 107, 0, 0.3);
            position: relative;
            z-index: 2;
        }

        .action-content {
            flex: 1;
            position: relative;
            z-index: 2;
        }

        .action-title {
            font-size: 1.125rem;
            font-weight: 600;
            color: var(--text-dark);
            margin: 0 0 0.25rem 0;
            transition: all 0.3s ease;
        }

        .action-description {
            font-size: 0.875rem;
            color: var(--text-gray);
            margin: 0;
            line-height: 1.4;
            transition: all 0.3s ease;
        }

        .action-meta {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin-top: 0.5rem;
        }

        .action-badge {
            background: rgba(255, 107, 0, 0.1);
            color: var(--primary-orange);
            padding: 4px 8px;
            border-radius: 6px;
            font-size: 0.75rem;
            font-weight: 600;
        }

        .action-arrow {
            color: var(--text-light);
            font-size: 14px;
            transition: all 0.3s ease;
            position: relative;
            z-index: 2;
        }

        .action-card:hover .action-arrow {
            color: white;
            transform: translateX(4px);
        }

        /* Responsive Design */
        @media (max-width: 1024px) {
            .employer-container {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 768px) {
            .main-content {
                padding: 1rem;
            }

            .page-header {
                padding: 1.5rem;
                text-align: center;
            }

            .info-grid {
                grid-template-columns: 1fr;
            }

            .contact-info {
                grid-template-columns: 1fr;
            }

            .action-cards {
                grid-template-columns: 1fr;
                gap: 1rem;
            }
        }

        @media (max-width: 480px) {
            .page-title {
                font-size: 1.5rem;
            }

            .company-name {
                font-size: 1.25rem;
            }

            .company-logo {
                width: 100px;
                height: 100px;
            }

            .action-card {
                padding: 1rem;
            }

            .action-icon {
                width: 48px;
                height: 48px;
                font-size: 18px;
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
                    <div>
                        <h1 class="page-title">Employer Details</h1>
                        <p class="page-subtitle">Complete company information and profile</p>
                    </div>
                    <a href="employer-list.php" class="back-btn">
                        <i class="fas fa-arrow-left"></i>
                        Back to Employers
                    </a>
                </div>

                <?php
                $vid=$_GET['viewid'];
                $sql="SELECT * from tblemployers where id=:vid";
                $query = $dbh -> prepare($sql);
                $query-> bindParam(':vid', $vid, PDO::PARAM_STR);
                $query->execute();
                $results=$query->fetchAll(PDO::FETCH_OBJ);

                $cnt=1;
                if($query->rowCount() > 0)
                {
                foreach($results as $row)
                {               ?>

                <!-- Employer Profile Section -->
                <div class="employer-container">
                    <!-- Company Profile Card -->
                    <div class="company-profile-card">
                        <img src="../employers/employerslogo/<?php echo $row->CompnayLogo;?>" 
                             alt="<?php echo htmlentities($row->CompnayName);?>" 
                             class="company-logo"
                             onerror="this.src='assets/img/default-company.png'">
                        
                        <h2 class="company-name"><?php echo htmlentities($row->CompnayName);?></h2>
                        
                        <?php if(!empty($row->CompanyTagline)): ?>
                        <p class="company-tagline">"<?php echo htmlentities($row->CompanyTagline);?>"</p>
                        <?php endif; ?>

                        <div class="status-badge <?php echo ($row->Is_Active == '1') ? 'status-active' : 'status-inactive'; ?>">
                            <i class="fas fa-circle"></i>
                            <?php echo ($row->Is_Active == '1') ? 'Active' : 'Inactive'; ?>
                        </div>

                        <!-- Contact Info -->
                        <div class="contact-info">
                            <div class="contact-item">
                                <div class="contact-icon">
                                    <i class="fas fa-user-tie"></i>
                                </div>
                                <div class="contact-details">
                                    <p class="contact-label">Contact Person</p>
                                    <p class="contact-value"><?php echo htmlentities($row->ConcernPerson);?></p>
                                </div>
                            </div>

                            <div class="contact-item">
                                <div class="contact-icon">
                                    <i class="fas fa-envelope"></i>
                                </div>
                                <div class="contact-details">
                                    <p class="contact-label">Email</p>
                                    <p class="contact-value"><?php echo htmlentities($row->EmpEmail);?></p>
                                </div>
                            </div>

                            <?php if(!empty($row->CompanyUrl)): ?>
                            <div class="contact-item">
                                <div class="contact-icon">
                                    <i class="fas fa-globe"></i>
                                </div>
                                <div class="contact-details">
                                    <p class="contact-label">Website</p>
                                    <p class="contact-value">
                                        <a href="<?php echo htmlentities($row->CompanyUrl);?>" 
                                           target="_blank" 
                                           style="color: var(--primary-orange); text-decoration: none;">
                                            <?php echo htmlentities($row->CompanyUrl);?>
                                        </a>
                                    </p>
                                </div>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Company Details Card -->
                    <div class="company-details-card">
                        <div class="details-header">
                            <h3 class="details-title">Company Information</h3>
                        </div>

                        <div class="info-grid">
                            <?php if(!empty($row->industry)): ?>
                            <div class="info-item">
                                <span class="info-label">Industry</span>
                                <div class="info-value"><?php echo htmlentities($row->industry);?></div>
                            </div>
                            <?php endif; ?>

                            <?php if(!empty($row->typeBusinessEntity)): ?>
                            <div class="info-item">
                                <span class="info-label">Business Entity</span>
                                <div class="info-value"><?php echo htmlentities($row->typeBusinessEntity);?></div>
                            </div>
                            <?php endif; ?>

                            <?php if(!empty($row->lcation)): ?>
                            <div class="info-item">
                                <span class="info-label">Location</span>
                                <div class="info-value"><?php echo htmlentities($row->lcation);?></div>
                            </div>
                            <?php endif; ?>

                            <?php if(!empty($row->noOfEmployee)): ?>
                            <div class="info-item">
                                <span class="info-label">Number of Employees</span>
                                <div class="info-value large"><?php echo htmlentities($row->noOfEmployee);?></div>
                            </div>
                            <?php endif; ?>

                            <?php if(!empty($row->establishedIn)): ?>
                            <div class="info-item">
                                <span class="info-label">Established</span>
                                <div class="info-value"><?php echo htmlentities($row->establishedIn);?></div>
                            </div>
                            <?php endif; ?>

                            <div class="info-item">
                                <span class="info-label">Registration Date</span>
                                <div class="info-value"><?php echo date('F j, Y', strtotime($row->RegDtae));?></div>
                            </div>
                        </div>

                        <!-- Actions Section -->
                        <div class="actions-section">
                            <div class="action-cards">
                                <a href="listed-jobs.php?compid=<?php echo htmlentities($row->id);?>&&cname=<?php echo htmlentities($row->CompnayName);?>" 
                                   class="action-card" target="_blank">
                                    <div class="action-icon">
                                        <i class="fas fa-briefcase"></i>
                                    </div>
                                    <div class="action-content">
                                        <h4 class="action-title">View Listed Jobs</h4>
                                        <p class="action-description">Browse all active job postings by this company</p>
                                        <div class="action-meta">
                                            <span class="action-badge">Active Jobs</span>
                                        </div>
                                    </div>
                                    <div class="action-arrow">
                                        <i class="fas fa-arrow-right"></i>
                                    </div>
                                </a>

                                <a href="employer-list.php" class="action-card">
                                    <div class="action-icon">
                                        <i class="fas fa-list"></i>
                                    </div>
                                    <div class="action-content">
                                        <h4 class="action-title">All Employers</h4>
                                        <p class="action-description">Return to complete employers directory</p>
                                        <div class="action-meta">
                                            <span class="action-badge">View All</span>
                                        </div>
                                    </div>
                                    <div class="action-arrow">
                                        <i class="fas fa-arrow-right"></i>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Company Description -->
                <?php if(!empty($row->CompnayDescription)): ?>
                <div class="description-section">
                    <h3 class="section-title">
                        <div class="section-icon">
                            <i class="fas fa-info-circle"></i>
                        </div>
                        Company Description
                    </h3>
                    <div class="description-content">
                        <?php echo $row->CompnayDescription;?>
                    </div>
                </div>
                <?php endif; ?>

                <?php $cnt=$cnt+1;}} ?>
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
        // Add smooth animations on page load
        document.addEventListener('DOMContentLoaded', function() {
            const cards = document.querySelectorAll('.company-profile-card, .company-details-card, .description-section');
            cards.forEach((card, index) => {
                card.style.opacity = '0';
                card.style.transform = 'translateY(20px)';
                
                setTimeout(() => {
                    card.style.transition = 'all 0.6s ease';
                    card.style.opacity = '1';
                    card.style.transform = 'translateY(0)';
                }, index * 150);
            });
        });

        // Handle broken images
        document.querySelectorAll('img').forEach(img => {
            img.addEventListener('error', function() {
                this.style.background = 'linear-gradient(135deg, var(--primary-orange), #FF8F42)';
                this.style.display = 'flex';
                this.style.alignItems = 'center';
                this.style.justifyContent = 'center';
                this.style.color = 'white';
                this.style.fontSize = '2rem';
                this.innerHTML = '<i class="fas fa-building"></i>';
            });
        });
    </script>
</body>
</html>
<?php }  ?>

<!-- Done 23 -->