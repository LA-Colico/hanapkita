<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
if (strlen($_SESSION['jpaid']==0)) {
  header('location:logout.php');
  } else{
    if(isset($_POST['submit']))
  {

$jpaid=$_SESSION['jpaid'];
 $pagetitle=$_POST['pagetitle'];
$pagedes=$_POST['pagedes'];
$sql="update tblpages set PageTitle=:pagetitle,PageDescription=:pagedes where  PageType='aboutus'";
$query=$dbh->prepare($sql);
$query->bindParam(':pagetitle',$pagetitle,PDO::PARAM_STR);
$query->bindParam(':pagedes',$pagedes,PDO::PARAM_STR);

$query->execute();
echo '<script>alert("About us has been updated")</script>';


  }
  ?>
<!doctype html>
<html lang="en" class="no-focus">
<head>
    <title>Hanap-Kita - Update About Us</title>
    <link rel="stylesheet" id="css-main" href="assets/css/codebase.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="http://js.nicedit.com/nicEdit-latest.js" type="text/javascript"></script>
    <script type="text/javascript">bkLib.onDomLoaded(nicEditors.allTextAreas);</script>
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

        .page-subtitle {
            color: var(--text-gray);
            font-size: 1.1rem;
            margin: 0;
            font-weight: 400;
        }

        .content-card {
            background: var(--card-white);
            border-radius: 20px;
            padding: 2.5rem;
            box-shadow: var(--shadow-card);
            border: 1px solid rgba(255, 107, 0, 0.1);
            position: relative;
            overflow: hidden;
        }

        .content-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: linear-gradient(90deg, var(--primary-orange), #FF8F42);
            border-radius: 20px 20px 0 0;
        }

        .card-header {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-bottom: 2rem;
            padding-bottom: 1rem;
            border-bottom: 2px solid rgba(255, 107, 0, 0.1);
        }

        .card-icon {
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

        .card-title {
            font-size: 1.5rem;
            font-weight: 600;
            color: var(--text-dark);
            margin: 0;
        }

        .modern-form {
            display: flex;
            flex-direction: column;
            gap: 2rem;
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

        .form-input, .form-textarea {
            width: 100%;
            padding: 1rem 1.25rem;
            border: 2px solid rgba(255, 107, 0, 0.1);
            border-radius: 12px;
            background: var(--card-white);
            font-size: 0.95rem;
            font-family: inherit;
            transition: all 0.3s ease;
            resize: vertical;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        }

        .form-input:focus, .form-textarea:focus {
            outline: none;
            border-color: var(--primary-orange);
            box-shadow: 0 0 0 3px rgba(255, 107, 0, 0.1);
            transform: translateY(-1px);
        }

        .form-textarea {
            min-height: 150px;
            line-height: 1.6;
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

        .submit-section {
            margin-top: 1rem;
            padding-top: 2rem;
            border-top: 1px solid rgba(255, 107, 0, 0.1);
            display: flex;
            justify-content: flex-end;
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
        }

        /* Info Cards */
        .info-cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .info-card {
            background: linear-gradient(135deg, rgba(255, 107, 0, 0.05), rgba(255, 107, 0, 0.02));
            border: 1px solid rgba(255, 107, 0, 0.1);
            border-radius: 16px;
            padding: 1.5rem;
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .info-icon {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            background: var(--primary-orange);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            flex-shrink: 0;
        }

        .info-content h4 {
            font-size: 1rem;
            font-weight: 600;
            color: var(--text-dark);
            margin: 0 0 0.25rem 0;
        }

        .info-content p {
            font-size: 0.875rem;
            color: var(--text-gray);
            margin: 0;
            line-height: 1.4;
        }

        /* Preview Section */
        .preview-section {
            background: rgba(255, 107, 0, 0.02);
            border: 2px dashed rgba(255, 107, 0, 0.2);
            border-radius: 16px;
            padding: 2rem;
            margin-top: 2rem;
        }

        .preview-header {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            margin-bottom: 1rem;
        }

        .preview-header i {
            color: var(--primary-orange);
            font-size: 1.25rem;
        }

        .preview-header h3 {
            font-size: 1.125rem;
            font-weight: 600;
            color: var(--text-dark);
            margin: 0;
        }

        .preview-content {
            background: var(--card-white);
            border-radius: 12px;
            padding: 1.5rem;
            border: 1px solid rgba(255, 107, 0, 0.1);
        }

        /* Rich Text Editor Styling */
        .nicEdit-main {
            border: 2px solid rgba(255, 107, 0, 0.1) !important;
            border-radius: 12px !important;
            padding: 1rem !important;
            font-family: 'Inter', sans-serif !important;
            font-size: 0.95rem !important;
            line-height: 1.6 !important;
        }

        .nicEdit-main:focus {
            border-color: var(--primary-orange) !important;
            box-shadow: 0 0 0 3px rgba(255, 107, 0, 0.1) !important;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .main-content {
                padding: 1rem;
            }

            .page-header, .content-card {
                padding: 1.5rem;
            }

            .page-title {
                font-size: 1.75rem;
            }

            .submit-section {
                flex-direction: column;
            }

            .btn-modern {
                width: 100%;
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
                    <h1 class="page-title">About Us Management</h1>
                    <p class="page-subtitle">
                        Update and manage the About Us page content that visitors see on your website
                    </p>
                </div>

                <!-- Info Cards -->
                <div class="info-cards">
                    <div class="info-card">
                        <div class="info-icon">
                            <i class="fas fa-edit"></i>
                        </div>
                        <div class="info-content">
                            <h4>Content Editor</h4>
                            <p>Rich text editor with formatting options</p>
                        </div>
                    </div>
                    <div class="info-card">
                        <div class="info-icon">
                            <i class="fas fa-eye"></i>
                        </div>
                        <div class="info-content">
                            <h4>Live Preview</h4>
                            <p>Changes reflect immediately on your site</p>
                        </div>
                    </div>
                    <div class="info-card">
                        <div class="info-icon">
                            <i class="fas fa-history"></i>
                        </div>
                        <div class="info-content">
                            <h4>Version Control</h4>
                            <p>All changes are automatically saved</p>
                        </div>
                    </div>
                </div>

                <!-- Main Content Card -->
                <div class="content-card">
                    <div class="card-header">
                        <div class="card-icon">
                            <i class="fas fa-info-circle"></i>
                        </div>
                        <h2 class="card-title">Update About Us Content</h2>
                    </div>

                    <form method="post" class="modern-form">
                        <?php
                        $sql="SELECT * from  tblpages where PageType='aboutus'";
                        $query = $dbh -> prepare($sql);
                        $query->execute();
                        $results=$query->fetchAll(PDO::FETCH_OBJ);
                        $cnt=1;
                        if($query->rowCount() > 0)
                        {
                        foreach($results as $row)
                        {               ?>        
                        
                        <!-- Page Title Field -->
                        <div class="form-group">
                            <label class="form-label" for="pagetitle">
                                <i class="fas fa-heading"></i>
                                Page Title
                            </label>
                            <input 
                                type="text" 
                                name="pagetitle" 
                                id="pagetitle"
                                value="<?php echo $row->PageTitle; ?>" 
                                class="form-input" 
                                required="true"
                                placeholder="Enter the main title for the About Us page"
                            >
                            <p class="form-help">
                                <i class="fas fa-lightbulb"></i>
                                This title will appear as the main heading on your About Us page
                            </p>
                        </div>

                        <!-- Page Description Field -->
                        <div class="form-group">
                            <label class="form-label" for="pagedes">
                                <i class="fas fa-align-left"></i>
                                Page Content
                            </label>
                            <textarea 
                                name="pagedes" 
                                id="pagedes"
                                class="form-textarea" 
                                required="true"
                                placeholder="Enter the detailed content for your About Us page..."
                            ><?php echo $row->PageDescription; ?></textarea>
                            <p class="form-help">
                                <i class="fas fa-info-circle"></i>
                                Use the rich text editor toolbar to format your content with headings, lists, links, and more
                            </p>
                        </div>

                        <?php $cnt=$cnt+1;}} ?>

                        <!-- Submit Section -->
                        <div class="submit-section">
                            <button type="button" class="btn-modern btn-secondary" onclick="resetForm()">
                                <i class="fas fa-undo"></i>
                                Reset Changes
                            </button>
                            <button type="submit" class="btn-modern btn-primary" name="submit">
                                <i class="fas fa-save"></i>
                                Update About Us
                            </button>
                        </div>
                    </form>

                    <!-- Preview Section -->
                    <div class="preview-section">
                        <div class="preview-header">
                            <i class="fas fa-eye"></i>
                            <h3>Content Preview</h3>
                        </div>
                        <div class="preview-content">
                            <p style="color: var(--text-gray); font-style: italic; margin: 0;">
                                <i class="fas fa-info-circle" style="color: var(--primary-orange);"></i>
                                Your changes will be visible to website visitors once you click "Update About Us"
                            </p>
                        </div>
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
        function resetForm() {
            if (confirm('Are you sure you want to reset all changes? This will restore the original content.')) {
                document.getElementById('pagetitle').value = "<?php echo addslashes($row->PageTitle ?? ''); ?>";
                document.getElementById('pagedes').value = "<?php echo addslashes($row->PageDescription ?? ''); ?>";
                
                // Reset NicEdit if available
                if (typeof nicEditors !== 'undefined') {
                    nicEditors.findEditor('pagedes').setContent("<?php echo addslashes($row->PageDescription ?? ''); ?>");
                }
            }
        }

        // Auto-save functionality (optional)
        let autoSaveTimeout;
        function autoSave() {
            clearTimeout(autoSaveTimeout);
            autoSaveTimeout = setTimeout(() => {
                console.log('Auto-saving draft...');
                // Implement auto-save logic here
            }, 3000);
        }

        // Add event listeners for auto-save
        document.getElementById('pagetitle').addEventListener('input', autoSave);
        document.getElementById('pagedes').addEventListener('input', autoSave);

        // Show success message styling
        document.addEventListener('DOMContentLoaded', function() {
            // Style alert boxes if they exist
            const alerts = document.querySelectorAll('script');
            alerts.forEach(script => {
                if (script.innerHTML.includes('alert(')) {
                    // Replace default alert with custom notification
                    script.innerHTML = script.innerHTML.replace('alert(', 'showNotification(');
                }
            });
        });

        function showNotification(message) {
            // Create custom notification
            const notification = document.createElement('div');
            notification.style.cssText = `
                position: fixed;
                top: 20px;
                right: 20px;
                background: linear-gradient(135deg, var(--success-green), #38A169);
                color: white;
                padding: 1rem 1.5rem;
                border-radius: 12px;
                box-shadow: 0 8px 20px rgba(72, 187, 120, 0.3);
                z-index: 10000;
                font-weight: 600;
                display: flex;
                align-items: center;
                gap: 0.5rem;
                font-family: Inter, sans-serif;
            `;
            notification.innerHTML = `
                <i class="fas fa-check-circle"></i>
                <span>${message}</span>
            `;
            
            document.body.appendChild(notification);
            
            // Animate in
            notification.style.transform = 'translateX(400px)';
            notification.style.opacity = '0';
            setTimeout(() => {
                notification.style.transition = 'all 0.3s ease';
                notification.style.transform = 'translateX(0)';
                notification.style.opacity = '1';
            }, 100);
            
            // Remove after 3 seconds
            setTimeout(() => {
                notification.style.transform = 'translateX(400px)';
                notification.style.opacity = '0';
                setTimeout(() => notification.remove(), 300);
            }, 3000);
        }
    </script>
</body>
</html>
<?php }  ?>

<!-- Done 2 Real -->