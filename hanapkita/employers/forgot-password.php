<?php
 session_start();
//Database Configuration File
include('includes/config.php');
error_reporting(0);
if(isset($_POST['submit']))
  {
 
    // Getting post values
    $email=$_POST['emailid'];
    $companyname=$_POST['companyname'];
    $password=$_POST['password'];
    //new password hasing 
$options = ['cost' => 12];
$hashednewpass=password_hash($password, PASSWORD_BCRYPT, $options);
    // Fetch data from database on the basis of email and mobile
    $sql ="SELECT id FROM tblemployers WHERE (EmpEmail=:email and CompnayName=:companyname)";
    $query= $dbh -> prepare($sql);
    $query-> bindParam(':email', $email, PDO::PARAM_STR);
    $query-> bindParam(':companyname', $companyname, PDO::PARAM_STR);
    $query-> execute();
    $results=$query->fetchAll(PDO::FETCH_OBJ);
if($query->rowCount() > 0)
{
$sql="update  tblemployers set EmpPassword=:hashednewpass WHERE (EmpEmail=:email and CompnayName=:companyname)";
$query = $dbh->prepare($sql);
// Binding Post Values
$query->bindParam(':hashednewpass',$hashednewpass,PDO::PARAM_STR);
$query-> bindParam(':email', $email, PDO::PARAM_STR);
    $query-> bindParam(':companyname', $companyname, PDO::PARAM_STR);
$query->execute();
echo "<script>alert('Password changed successfully');</script>";
echo "<script type='text/javascript'> document.location ='emp-login.php'; </script>";

}
//if username or email not found in database
else{
echo "<script>alert('Invalid details. Please try again');</script>";
  }
 
}
?>

<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Reset Password | Hanap-Kita</title>
  
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
    function checkpass() {
      if(document.changepassword.newpassword.value!=document.changepassword.confirmpassword.value)
      {
        alert('New Password and Confirm Password field does not match');
        document.changepassword.confirmpassword.focus();
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
          <a href="../index.php" class="text-gray-700 hover:text-primary font-medium transition-colors">Home</a>
          <a href="employers-signup.php" class="text-gray-700 hover:text-primary font-medium transition-colors">Sign Up</a>
          <a href="emp-login.php" class="text-primary font-medium transition-colors">Sign In</a>
        </nav>
        
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
  <div class="py-12">
    <div class="max-w-md mx-auto px-4 sm:px-6 lg:px-8">
      <!-- Page Title -->
      <div class="mb-8 text-center">
        <h1 class="text-3xl font-bold text-gray-900">Reset Your Password</h1>
        <p class="mt-2 text-gray-600">Enter your details to reset your account password</p>
      </div>
      
      <!-- Reset Password Form Card -->
      <div class="bg-white rounded-xl shadow-sm overflow-hidden">
        <div class="p-8">
          <div class="flex justify-center mb-6">
            <div class="h-24 w-24 rounded-full bg-primary-light/10 flex items-center justify-center">
              <i class="fas fa-unlock-alt text-primary text-4xl"></i>
            </div>
          </div>
          
          <form method="post" name="changepassword" onsubmit="return checkpass();">
            <div class="space-y-4">
              <!-- Email Field -->
              <div>
                <label for="emailid" class="block text-sm font-medium text-gray-700 mb-1">Registered Email</label>
                <div class="relative">
                  <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <i class="fas fa-envelope text-gray-400"></i>
                  </div>
                  <input type="email" id="emailid" name="emailid" placeholder="Your registered email address" required 
                         class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-primary focus:border-primary text-sm">
                </div>
              </div>
              
              <!-- Company Name Field -->
              <div>
                <label for="companyname" class="block text-sm font-medium text-gray-700 mb-1">Company Name</label>
                <div class="relative">
                  <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <i class="fas fa-building text-gray-400"></i>
                  </div>
                  <input type="text" id="companyname" name="companyname" placeholder="Your company's registered name" required 
                         class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-primary focus:border-primary text-sm">
                </div>
              </div>
              
              <!-- New Password Field -->
              <div>
                <label for="newpassword" class="block text-sm font-medium text-gray-700 mb-1">New Password</label>
                <div class="relative">
                  <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <i class="fas fa-lock text-gray-400"></i>
                  </div>
                  <input type="password" id="newpassword" name="password" placeholder="Create a new password" required 
                         class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-primary focus:border-primary text-sm">
                </div>
              </div>
              
              <!-- Confirm Password Field -->
              <div>
                <label for="confirmpassword" class="block text-sm font-medium text-gray-700 mb-1">Confirm Password</label>
                <div class="relative">
                  <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <i class="fas fa-lock text-gray-400"></i>
                  </div>
                  <input type="password" id="confirmpassword" name="confirmpassword" placeholder="Confirm your new password" required 
                         class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-primary focus:border-primary text-sm">
                </div>
              </div>
              
              <!-- Submit Button -->
              <div class="pt-2">
                <button type="submit" name="submit" 
                        class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-sm text-base font-medium text-white bg-primary hover:bg-primary-dark focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary transition-colors">
                  Reset Password
                </button>
              </div>
            </div>
          </form>
          
          <!-- Sign In Link -->
          <div class="mt-6 text-center">
            <p class="text-sm text-gray-600">
              Remember your password? 
              <a href="emp-login.php" class="font-medium text-primary hover:text-primary-dark transition-colors">
                Sign In
              </a>
            </p>
          </div>
          
          <!-- Back Home Link -->
          <div class="mt-4 text-center">
            <a href="../index.php" class="inline-flex items-center text-sm text-gray-500 hover:text-primary transition-colors">
              <i class="fas fa-home mr-2"></i>
              Back to Home
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
  
  <!-- Footer -->
  <footer class="bg-gray-900 text-white py-12 mt-12">
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
          <h4 class="font-semibold mb-4">For Employers</h4>
          <ul class="space-y-2">
            <li><a href="employers-signup.php" class="text-gray-400 hover:text-white transition-colors">Register</a></li>
            <li><a href="emp-login.php" class="text-gray-400 hover:text-white transition-colors">Sign In</a></li>
            <li><a href="#" class="text-gray-400 hover:text-white transition-colors">Post a Job</a></li>
            <li><a href="#" class="text-gray-400 hover:text-white transition-colors">Find Candidates</a></li>
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
  <script src="../js/jquery.noconflict.js"></script> 
  <script src="../js/theme-scripts.js"></script> 
  <script src="../js/form.js"></script> 
  <script src="../js/custom.js"></script>
</body>
</html>

<!-- Done 14 -->