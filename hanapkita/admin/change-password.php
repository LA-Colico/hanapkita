<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
error_reporting(0);
if (strlen($_SESSION['jpaid']==0)) {
  header('location:logout.php');
  } else{
if(isset($_POST['submit']))
{
$adminid=$_SESSION['jpaid'];
$cpassword=md5($_POST['currentpassword']);
$newpassword=md5($_POST['newpassword']);
$sql ="SELECT ID FROM tbladmin WHERE ID=:adminid and Password=:cpassword";
$query= $dbh -> prepare($sql);
$query-> bindParam(':adminid', $adminid, PDO::PARAM_STR);
$query-> bindParam(':cpassword', $cpassword, PDO::PARAM_STR);
$query-> execute();
$results = $query -> fetchAll(PDO::FETCH_OBJ);

if($query -> rowCount() > 0)
{
$con="update tbladmin set Password=:newpassword where ID=:adminid";
$chngpwd1 = $dbh->prepare($con);
$chngpwd1-> bindParam(':adminid', $adminid, PDO::PARAM_STR);
$chngpwd1-> bindParam(':newpassword', $newpassword, PDO::PARAM_STR);
$chngpwd1->execute();

echo '<script>alert("Your password successully changed")</script>';
} else {
echo '<script>alert("Your current password is wrong")</script>';

}
}
 ?>
<!doctype html>
<html lang="en" class="no-focus">
<head>
    <title>Hanap-Kita - Change Password</title>
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
            max-width: 600px;
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
            text-align: center;
        }

        .page-title h1 {
            color: #2D3748;
            font-size: 1.75rem;
            font-weight: 600;
            margin: 0;
            display: flex;
            align-items: center;
            justify-content: center;
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

        /* Security Tips */
        .security-tips {
            background: #F0F8FF;
            border: 1px solid #BEE3F8;
            border-radius: 8px;
            padding: 1.5rem;
            margin-top: 1.5rem;
        }

        .tips-title {
            color: #2B6CB0;
            font-weight: 600;
            margin: 0 0 1rem 0;
            font-size: 1rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .tips-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .tips-list li {
            color: #2C5282;
            font-size: 0.85rem;
            margin-bottom: 0.5rem;
            display: flex;
            align-items: flex-start;
            gap: 0.5rem;
            line-height: 1.4;
        }

        .tips-list i {
            color: #3182CE;
            margin-top: 0.1rem;
            flex-shrink: 0;
        }

        /* Submit Section */
        .submit-section {
            text-align: center;
            margin-top: 1.5rem;
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
        }
    </style>
    <script type="text/javascript">
        function checkpass()
        {
            if(document.changepassword.newpassword.value!= document.changepassword.confirmpassword.value)
            {
                alert("New Password and Confirm Password Field do not match  !!");
                document.changepassword.confirmpassword.focus();
                return false;
            }
            return true;
        }   
    </script>
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
                        <i class="fas fa-key" style="color: #FF6B00;"></i>
                        Change Password
                    </h1>
                    <p>Update your account password to keep your account secure</p>
                </div>

                <!-- Form Container -->
                <div class="form-container">
                    <h2 class="form-title">
                        <i class="fas fa-lock" style="color: #FF6B00;"></i>
                        Password Settings
                    </h2>

                    <form method="post" onsubmit="return checkpass();" name="changepassword">
                        <div class="form-group row">
                            <label class="col-12" for="register1-username">Current Password:</label>
                            <div class="col-12">
                                <input type="password" class="form-control" name="currentpassword" id="currentpassword" required='true' placeholder="Enter your current password">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-12" for="register1-email">New Password:</label>
                            <div class="col-12">
                                <input type="password" class="form-control" name="newpassword" required="true" placeholder="Enter your new password">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-12" for="register1-password">Confirm Password:</label>
                            <div class="col-12">
                                <input type="password" class="form-control" name="confirmpassword" id="confirmpassword" required='true' placeholder="Confirm your new password">
                            </div>
                        </div>
                      
                        <div class="form-group row">
                            <div class="col-12 submit-section">
                                <button type="submit" class="btn btn-alt-success" name="submit">
                                    <i class="fa fa-save"></i> Change Password
                                </button>
                            </div>
                        </div>
                    </form>

                    <!-- Security Tips -->
                    <div class="security-tips">
                        <h4 class="tips-title">
                            <i class="fas fa-shield-alt"></i>
                            Password Security Tips
                        </h4>
                        <ul class="tips-list">
                            <li>
                                <i class="fas fa-check"></i>
                                Use at least 8 characters with a mix of letters, numbers, and symbols
                            </li>
                            <li>
                                <i class="fas fa-check"></i>
                                Avoid using personal information like your name or birthdate
                            </li>
                            <li>
                                <i class="fas fa-check"></i>
                                Don't reuse passwords from other accounts
                            </li>
                            <li>
                                <i class="fas fa-check"></i>
                                Change your password regularly for better security
                            </li>
                        </ul>
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
        // Simple focus enhancement only
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('currentpassword').focus();
        });
    </script>
</body>
</html>
<?php }  ?>
<!-- Done 10 -->