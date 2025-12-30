<?php
session_start();
//Database Configuration File
include('includes/config.php');
//error_reporting(0);
//verifying Session
if(strlen($_SESSION['emplogin'])==0)
  { 
header('location:emp-login.php');
}
else{
if(isset($_POST['change']))
{
//Getting Employer Id
$empid=$_SESSION['emplogin'];
// Getting Post Values
$currentpassword=$_POST['currentpassword'];
$newpassword=$_POST['newpassword'];
//new password hasing 
$options = ['cost' => 12];
$hashednewpass=password_hash($newpassword, PASSWORD_BCRYPT, $options);

  // Fetch data from database on the basis of Employee session if
    $sql ="SELECT EmpPassword FROM tblemployers WHERE (id=:empid )";
    $query= $dbh -> prepare($sql);
    $query-> bindParam(':empid', $empid, PDO::PARAM_STR);
    $query-> execute();
    $results=$query->fetchAll(PDO::FETCH_OBJ);
if($query->rowCount() > 0)
{
foreach ($results as $row) {
$hashpass=$row->EmpPassword;
}
//if current password verfied new password wil be updated in the databse
if (password_verify($currentpassword, $hashpass)) {
$sql="update  tblemployers set EmpPassword=:hashednewpass where id=:eid";
$query = $dbh->prepare($sql);
// Binding Post Values
$query->bindParam(':hashednewpass',$hashednewpass,PDO::PARAM_STR);
$query-> bindParam(':eid', $empid, PDO::PARAM_STR);
$query->execute();
$msg='Password changed successfully';

} else {
  $error="Current password is wrong"; 
}
}


}
?>

<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Change Password | Hanap-Kita</title>
  
  <!-- Tailwind CSS -->
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
  
  <script>
    tailwind.config = {
      theme: {
        extend: {
          colors: {
            primary: '#5F4DEE',
            'primary-dark': '#4C3ED8',
            'primary-light': '#7B6EF2',
            secondary: '#F8FAFC',
            accent: '#F59E0B'
          },
          fontFamily: {
            'sans': ['Inter', 'system-ui', 'sans-serif']
          }
        }
      }
    }
  </script>
  
  <script type="text/javascript">
  function valid() {
    if(document.chngpwd.newpassword.value != document.chngpwd.confirmpassword.value) {
      alert("New Password and Confirm Password Field do not match!");
      document.chngpwd.confirmpassword.focus();
      return false;
    }
    return true;
  }
  </script>
</head>

<body class="bg-gray-50 text-gray-900 font-sans">
  <!-- Header -->
  <header class="bg-white shadow-sm border-b border-gray-100 sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="flex justify-between items-center h-16">
        <!-- Logo -->
        <div class="flex items-center">
          <div class="flex-shrink-0">
            <a href="index.php" class="text-2xl font-bold text-primary">Hanap-Kita</a>
          </div>
        </div>
        
        <!-- Navigation -->
        <nav class="hidden md:flex space-x-8">
          <a href="job-listing.php" class="text-gray-700 hover:text-primary font-medium transition-colors">Jobs</a>
          <a href="candidates-listings.php" class="text-gray-700 hover:text-primary font-medium transition-colors">Candidates</a>
          <a href="candidates-reports.php" class="text-gray-700 hover:text-primary font-medium transition-colors">Reports</a>
        </nav>
        
        <!-- Auth Buttons -->
        <div class="flex items-center space-x-4">
          <div class="relative group">
            <button class="flex items-center space-x-2 text-gray-700 hover:text-primary transition-colors">
              <i class="fas fa-user-circle text-xl"></i>
              <span>My Account</span>
              <i class="fas fa-chevron-down text-xs"></i>
            </button>
            <div class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg border border-gray-200 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all">
              <a href="edit-profile.php" class="block px-4 py-2 text-gray-700 hover:bg-gray-50 rounded-t-lg">Edit Profile</a>
              <a href="change-password.php" class="block px-4 py-2 text-primary bg-gray-50 font-medium">Change Password</a>
              <a href="logout.php" class="block px-4 py-2 text-gray-700 hover:bg-gray-50 rounded-b-lg">Logout</a>
            </div>
          </div>
        </div>
        
        <!-- Mobile menu button -->
        <div class="md:hidden">
          <button class="text-gray-500 hover:text-gray-700">
            <i class="fas fa-bars text-xl"></i>
          </button>
        </div>
      </div>
    </div>
  </header>

  <!-- Main Content -->
  <div class="py-12 bg-gray-50">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
      <!-- Page Title -->
      <div class="mb-10 text-center">
        <h1 class="text-3xl font-bold text-gray-900">Change Your Password</h1>
        <p class="mt-2 text-lg text-gray-600">Keep your account secure with a strong password</p>
      </div>
      
      <!-- Alert Messages -->
      <?php if(@$error){ ?>
      <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4 rounded-md">
        <div class="flex">
          <div class="flex-shrink-0">
            <i class="fas fa-exclamation-circle text-red-500"></i>
          </div>
          <div class="ml-3">
            <p class="text-sm text-red-700">
              <strong>Error:</strong> <?php echo htmlentities($error);?>
            </p>
          </div>
        </div>
      </div>
      <?php } ?>

      <?php if(@$msg){ ?>
      <div class="mb-6 bg-green-50 border-l-4 border-green-500 p-4 rounded-md">
        <div class="flex">
          <div class="flex-shrink-0">
            <i class="fas fa-check-circle text-green-500"></i>
          </div>
          <div class="ml-3">
            <p class="text-sm text-green-700">
              <strong>Success:</strong> <?php echo htmlentities($msg);?>
            </p>
          </div>
        </div>
      </div>
      <?php } ?>
      
      <!-- Password Change Form Card -->
      <div class="bg-white rounded-xl shadow-sm overflow-hidden">
        <div class="border-b border-gray-100 bg-gradient-to-r from-primary-light to-primary px-6 py-4">
          <h2 class="text-xl font-semibold text-white">Change Password</h2>
        </div>
        
        <div class="p-6">
          <form name="chngpwd" method="post" onSubmit="return valid();">
            <div class="space-y-6">
              <!-- Current Password -->
              <div>
                <label for="currentpassword" class="block text-sm font-medium text-gray-700 mb-1">Current Password</label>
                <input type="password" name="currentpassword" id="currentpassword" required
                       class="block w-full px-4 py-3 rounded-lg border border-gray-300 shadow-sm focus:ring-primary focus:border-primary sm:text-sm"
                       placeholder="Enter your current password">
              </div>
              
              <!-- New Password -->
              <div>
                <label for="newpassword" class="block text-sm font-medium text-gray-700 mb-1">New Password</label>
                <input type="password" name="newpassword" id="newpassword" required
                       class="block w-full px-4 py-3 rounded-lg border border-gray-300 shadow-sm focus:ring-primary focus:border-primary sm:text-sm"
                       placeholder="Enter new password">
              </div>
              
              <!-- Confirm Password -->
              <div>
                <label for="confirmpassword" class="block text-sm font-medium text-gray-700 mb-1">Confirm Password</label>
                <input type="password" name="confirmpassword" id="confirmpassword" required
                       class="block w-full px-4 py-3 rounded-lg border border-gray-300 shadow-sm focus:ring-primary focus:border-primary sm:text-sm"
                       placeholder="Confirm your new password">
              </div>
              
              <!-- Submit Button -->
              <div class="pt-4">
                <button type="submit" name="change"
                        class="w-full inline-flex justify-center items-center px-6 py-3 border border-transparent text-base font-medium rounded-lg shadow-sm text-white bg-primary hover:bg-primary-dark focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary transition-colors">
                  <i class="fas fa-key mr-2"></i> Change Password
                </button>
              </div>
            </div>
          </form>
        </div>
      </div>
      
      <!-- Password Tips Card -->
      <div class="mt-8 bg-white rounded-xl shadow-sm overflow-hidden">
        <div class="p-6">
          <h3 class="text-lg font-medium text-gray-900 mb-4">Password Security Tips</h3>
          <ul class="space-y-2 text-gray-600">
            <li class="flex items-start">
              <i class="fas fa-check-circle text-primary mt-1 mr-2"></i>
              <span>Use at least 8 characters with a mix of letters, numbers, and symbols</span>
            </li>
            <li class="flex items-start">
              <i class="fas fa-check-circle text-primary mt-1 mr-2"></i>
              <span>Avoid using personal information like birth dates or names</span>
            </li>
            <li class="flex items-start">
              <i class="fas fa-check-circle text-primary mt-1 mr-2"></i>
              <span>Don't reuse passwords across different websites</span>
            </li>
            <li class="flex items-start">
              <i class="fas fa-check-circle text-primary mt-1 mr-2"></i>
              <span>Change your password regularly for enhanced security</span>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </div>
  
  <!-- Footer -->
  <footer class="bg-gray-900 text-white py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="grid md:grid-cols-4 gap-8">
        <!-- Brand -->
        <div class="md:col-span-1">
          <h3 class="text-2xl font-bold text-primary mb-4">Hanap-Kita</h3>
          <ul class="space-y-2 text-gray-400">
            <li class="flex items-center space-x-2">
              <i class="fas fa-phone"></i>
              <span>+63 912 345 6789</span>
            </li>
            <li class="flex items-center space-x-2">
              <i class="fas fa-envelope"></i>
              <span>info@hanapkita.ph</span>
            </li>
            <li class="flex items-center space-x-2">
              <i class="fas fa-map-marker-alt"></i>
              <span>Metro Manila, Philippines</span>
            </li>
          </ul>
        </div>
        
        <!-- Quick Links -->
        <div>
          <h4 class="font-semibold mb-4">Employer Tools</h4>
          <ul class="space-y-2">
            <li><a href="job-listing.php" class="text-gray-400 hover:text-white transition-colors">Manage Jobs</a></li>
            <li><a href="candidates-listings.php" class="text-gray-400 hover:text-white transition-colors">View Candidates</a></li>
            <li><a href="candidates-reports.php" class="text-gray-400 hover:text-white transition-colors">Reports</a></li>
            <li><a href="edit-profile.php" class="text-gray-400 hover:text-white transition-colors">Company Profile</a></li>
          </ul>
        </div>
        
        <!-- Resources -->
        <div>
          <h4 class="font-semibold mb-4">Resources</h4>
          <ul class="space-y-2">
            <li><a href="#" class="text-gray-400 hover:text-white transition-colors">Hiring Guides</a></li>
            <li><a href="#" class="text-gray-400 hover:text-white transition-colors">Interview Tips</a></li>
            <li><a href="#" class="text-gray-400 hover:text-white transition-colors">Employer FAQs</a></li>
            <li><a href="#" class="text-gray-400 hover:text-white transition-colors">Privacy Policy</a></li>
          </ul>
        </div>
        
        <!-- Newsletter -->
        <div>
          <h4 class="font-semibold mb-4">Stay Updated</h4>
          <p class="text-gray-400 mb-4">Get the latest hiring tips and best practices.</p>
          <div class="flex">
            <input type="email" placeholder="Your email" 
                   class="flex-1 px-4 py-2 bg-gray-800 border border-gray-700 rounded-l-lg focus:outline-none focus:ring-2 focus:ring-primary">
            <button class="bg-primary px-4 py-2 rounded-r-lg hover:bg-primary-dark transition-colors">
              <i class="fas fa-paper-plane"></i>
            </button>
          </div>
        </div>
      </div>
      
      <div class="border-t border-gray-800 mt-12 pt-8 text-center">
        <p class="text-gray-400">&copy; 2024 Hanap-Kita. All rights reserved.</p>
      </div>
    </div>
  </footer>

  <!-- Include original scripts -->
  <script src="../js/jquery-1.11.3.min.js"></script> 
  <script src="../js/bootstrap.min.js"></script> 
  <script src="../js/owl.carousel.min.js"></script> 
  <script src="../js/jquery.velocity.min.js"></script> 
  <script src="../js/jquery.kenburnsy.js"></script> 
  <script src="../js/jquery.mCustomScrollbar.concat.min.js"></script> 
  <script src="../js/editor.js"></script> 
  <script src="../js/jquery.accordion.js"></script> 
  <script src="../js/jquery.noconflict.js"></script> 
  <script src="../js/theme-scripts.js"></script> 
  <script src="../js/custom.js"></script>
</body>
</html>
<?php } ?>

<!-- Done 8 -->