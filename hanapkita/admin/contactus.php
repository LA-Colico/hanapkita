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
$mobnum=$_POST['mobnum'];
$email=$_POST['email'];
$sql="update tblpages set PageTitle=:pagetitle,PageDescription=:pagedes,Email=:email,MobileNumber=:mobnum where  PageType='contactus'";
$query=$dbh->prepare($sql);
$query->bindParam(':pagetitle',$pagetitle,PDO::PARAM_STR);
$query->bindParam(':pagedes',$pagedes,PDO::PARAM_STR);
$query->bindParam(':email',$email,PDO::PARAM_STR);
$query->bindParam(':mobnum',$mobnum,PDO::PARAM_STR);
$query->execute();
echo '<script>alert("Contact us has been updated")</script>';


  }
  ?>
<!doctype html>
<html lang="en" class="no-focus">
<head>
    <title>Hanap-Kita - Update Contact Us</title>
    <link rel="stylesheet" id="css-main" href="assets/css/codebase.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            background: #FEF7F0;
            font-family: 'Inter', sans-serif !important;
        }

        .content {
            padding: 2rem !important;
            max-width: 800px;
            margin: 0 auto;
        }

        /* Page Title */
        .page-title {
            background: white;
            padding: 1.5rem;
            border-radius: 12px;
            margin-bottom: 1.5rem;
            border-left: 4px solid #FF6B00;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .page-title h1 {
            color: #2D3748;
            font-size: 1.75rem;
            font-weight: 600;
            margin: 0;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .page-title p {
            color: #718096;
            margin: 0.5rem 0 0 0;
            font-size: 0.9rem;
        }

        /* Form Container */
        .form-container {
            background: white;
            padding: 2rem;
            border-radius: 12px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            margin-bottom: 1.5rem;
        }

        .form-title {
            color: #2D3748;
            font-size: 1.25rem;
            font-weight: 600;
            margin: 0 0 1.5rem 0;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        /* Form Groups */
        .form-group.row {
            margin-bottom: 1.5rem !important;
        }

        .form-group.row label {
            font-weight: 500 !important;
            color: #2D3748 !important;
            margin-bottom: 0.5rem !important;
            font-size: 0.9rem !important;
        }

        /* Form Controls */
        .form-control {
            padding: 0.75rem 1rem !important;
            border: 2px solid #E2E8F0 !important;
            border-radius: 8px !important;
            font-size: 0.9rem !important;
            transition: all 0.2s ease !important;
            background: white !important;
        }

        .form-control:focus {
            outline: none !important;
            border-color: #FF6B00 !important;
            box-shadow: 0 0 0 3px rgba(255, 107, 0, 0.1) !important;
        }

        /* Textarea specific */
        textarea.form-control {
            min-height: 120px !important;
            resize: vertical !important;
        }

        /* Submit Button */
        .btn-alt-success {
            background: #FF6B00 !important;
            border-color: #FF6B00 !important;
            color: white !important;
            padding: 0.75rem 2rem !important;
            border-radius: 8px !important;
            font-weight: 500 !important;
            transition: all 0.2s ease !important;
            display: inline-flex !important;
            align-items: center !important;
            gap: 0.5rem !important;
        }

        .btn-alt-success:hover {
            background: #E55B00 !important;
            border-color: #E55B00 !important;
            color: white !important;
            transform: translateY(-1px) !important;
        }

        /* Contact Info Preview */
        .contact-preview {
            background: #F0F8FF;
            border: 1px solid #BEE3F8;
            border-radius: 8px;
            padding: 1.5rem;
            margin-top: 1.5rem;
        }

        .preview-title {
            color: #2B6CB0;
            font-weight: 600;
            margin: 0 0 1rem 0;
            font-size: 1rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .preview-item {
            color: #2C5282;
            font-size: 0.85rem;
            margin-bottom: 0.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .preview-item i {
            color: #3182CE;
            width: 16px;
            text-align: center;
        }

        /* Form Grid for Contact Details */
        .contact-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1.5rem;
        }

        /* Submit Section */
        .submit-section {
            text-align: center;
            margin-top: 2rem;
            padding-top: 1.5rem;
            border-top: 1px solid #E2E8F0;
        }

        /* Mobile Responsive */
        @media (max-width: 768px) {
            .content {
                padding: 1rem !important;
            }
            
            .page-title,
            .form-container {
                padding: 1.5rem;
            }
            
            .page-title h1 {
                font-size: 1.5rem;
            }

            .contact-grid {
                grid-template-columns: 1fr;
                gap: 1rem;
            }
        }
    </style>
</head>
<body>
    <div id="page-container" class="sidebar-o sidebar-inverse side-scroll page-header-fixed main-content-narrow">
        <?php include_once('includes/sidebar.php');?>
        <?php include_once('includes/header.php');?>

        <main id="main-container">
            <div class="content">
                <!-- Page Title -->
                <div class="page-title">
                    <h1>
                        <i class="fas fa-address-book" style="color: #FF6B00;"></i>
                        Update Contact Us
                    </h1>
                    <p>Manage your contact information displayed to visitors</p>
                </div>

                <!-- Form Container -->
                <div class="form-container">
                    <h2 class="form-title">
                        <i class="fas fa-edit" style="color: #FF6B00;"></i>
                        Contact Information Settings
                    </h2>

                    <form method="post">
                        <?php
                        $sql="SELECT * from  tblpages where PageType='contactus'";
                        $query = $dbh -> prepare($sql);
                        $query->execute();
                        $results=$query->fetchAll(PDO::FETCH_OBJ);
                        $cnt=1;
                        if($query->rowCount() > 0)
                        {
                            foreach($results as $row)
                            {               
                        ?>
                        
                        <!-- Page Title -->
                        <div class="form-group row">
                            <label class="col-12" for="pagetitle">Page Title:</label>
                            <div class="col-12">
                                <input type="text" 
                                       name="pagetitle" 
                                       id="pagetitle" 
                                       required="true" 
                                       value="<?php echo $row->PageTitle;?>" 
                                       class="form-control"
                                       placeholder="Enter the contact page title">
                            </div>
                        </div>

                        <!-- Contact Details Grid -->
                        <div class="contact-grid">
                            <div class="form-group row">
                                <label class="col-12" for="email">Email Address:</label>
                                <div class="col-12">
                                    <input type="email" 
                                           name="email" 
                                           id="email" 
                                           required="true" 
                                           value="<?php echo $row->Email;?>" 
                                           class="form-control"
                                           placeholder="contact@example.com">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-12" for="mobnum">Mobile Number:</label>
                                <div class="col-12">
                                    <input type="text" 
                                           name="mobnum" 
                                           id="mobnum" 
                                           required="true" 
                                           value="<?php echo $row->MobileNumber;?>" 
                                           class="form-control" 
                                           maxlength="15" 
                                           pattern="[0-9+\-\s]+"
                                           placeholder="+1234567890">
                                </div>
                            </div>
                        </div>

                        <!-- Page Description -->
                        <div class="form-group row">
                            <label class="col-12" for="pagedes">Contact Information / Address:</label>
                            <div class="col-12">
                                <textarea name="pagedes" 
                                          id="pagedes"
                                          class="form-control" 
                                          required='true'
                                          placeholder="Enter your full address and any additional contact information..."><?php echo $row->PageDescription;?></textarea>
                            </div>
                        </div>

                        <?php $cnt=$cnt+1;}} ?>

                        <!-- Submit Section -->
                        <div class="submit-section">
                            <button type="submit" class="btn btn-alt-success" name="submit">
                                <i class="fa fa-save"></i> Update Contact Information
                            </button>
                        </div>
                    </form>

                    <!-- Contact Preview -->
                    <div class="contact-preview">
                        <h4 class="preview-title">
                            <i class="fas fa-eye"></i>
                            Contact Information Preview
                        </h4>
                        <div class="preview-item">
                            <i class="fas fa-envelope"></i>
                            <span id="preview-email">Loading...</span>
                        </div>
                        <div class="preview-item">
                            <i class="fas fa-phone"></i>
                            <span id="preview-phone">Loading...</span>
                        </div>
                        <div class="preview-item">
                            <i class="fas fa-map-marker-alt"></i>
                            <span id="preview-address">Loading...</span>
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
        // Live preview functionality
        function updatePreview() {
            const email = document.getElementById('email').value || 'Not provided';
            const phone = document.getElementById('mobnum').value || 'Not provided';
            const address = document.getElementById('pagedes').value || 'Not provided';
            
            document.getElementById('preview-email').textContent = email;
            document.getElementById('preview-phone').textContent = phone;
            document.getElementById('preview-address').textContent = address;
        }

        // Initialize preview and add event listeners
        document.addEventListener('DOMContentLoaded', function() {
            // Focus on first input
            document.getElementById('pagetitle').focus();
            
            // Update preview on page load
            updatePreview();
            
            // Add event listeners for live preview
            document.getElementById('email').addEventListener('input', updatePreview);
            document.getElementById('mobnum').addEventListener('input', updatePreview);
            document.getElementById('pagedes').addEventListener('input', updatePreview);
            
            // Phone number formatting
            document.getElementById('mobnum').addEventListener('input', function(e) {
                let value = e.target.value.replace(/\D/g, ''); // Remove non-digits
                if (value.length > 0) {
                    // Simple formatting for display
                    if (value.length <= 3) {
                        e.target.value = value;
                    } else if (value.length <= 6) {
                        e.target.value = value.slice(0, 3) + '-' + value.slice(3);
                    } else if (value.length <= 10) {
                        e.target.value = value.slice(0, 3) + '-' + value.slice(3, 6) + '-' + value.slice(6);
                    } else {
                        e.target.value = value.slice(0, 10);
                        e.target.value = value.slice(0, 3) + '-' + value.slice(3, 6) + '-' + value.slice(6, 10);
                    }
                }
                updatePreview();
            });
        });
    </script>
</body>
</html>
<?php }  ?>
<!-- Done 11 -->