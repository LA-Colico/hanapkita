<?php
 session_start();
//Database Configuration File
include('includes/config.php');
error_reporting(0);
if(isset($_POST['signin']))
  {
 
    // Getting username/ email and password
    $uname=$_POST['email'];
    $password=$_POST['password'];
    // Fetch data from database on the basis of username/email and password
    $sql ="SELECT id,ConcernPerson,EmpEmail,EmpPassword FROM tblemployers WHERE (EmpEmail=:usname )";
    $query= $dbh -> prepare($sql);
    $query-> bindParam(':usname', $uname, PDO::PARAM_STR);
    $query-> execute();
    $results=$query->fetchAll(PDO::FETCH_OBJ);
if($query->rowCount() > 0)
{
foreach ($results as $row) {
$hashpass=$row->EmpPassword;
$_SESSION['emplogin']=$row->id;
}
//verifying Password
if (password_verify($password, $hashpass)) {
$_SESSION['userlogin']=$_POST['username'];echo "<script type='text/javascript'> document.location = 'job-listing.php'; </script>";
  } else {
echo "<script>alert('Inavlid login details');</script>";
 
  }
}
//if username or email not found in database
else{
echo "<script>alert('User not registered with us');</script>";
  }
 
}
?>

<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Employer SignIn | Hanap-Kita</title>
  
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
</head>

<body class="bg-gray-50 text-gray-900 font-sans">
  <!-- Header -->
  <header class="bg-white shadow-sm border-b border-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="flex justify-between items-center h-16">
        <!-- Logo -->
        <div class="flex items-center">
          <div class="flex-shrink-0">
            <a href="../index.php" class="text-2xl font-bold text-primary">Hanap-Kita</a>
          </div>
        </div>
        
        <!-- Navigation -->
        <nav class="hidden md:flex space-x-8">
          <a href="../index.php" class="text-gray-700 hover:text-primary font-medium transition-colors">Home</a>
          <a href="../about-us.php" class="text-gray-700 hover:text-primary font-medium transition-colors">About</a>
          <a href="../contact.php" class="text-gray-700 hover:text-primary font-medium transition-colors">Contact</a>
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
      <div class="text-center mb-10">
        <h1 class="text-3xl font-bold text-gray-900">Login To Your Account</h1>
      </div>
      
      <!-- Login Card -->
      <div class="bg-white rounded-xl shadow-sm overflow-hidden">
        <div class="p-8">
          <!-- Login Illustration -->
          <div class="flex justify-center mb-6">
            <img src="../images/account.png" alt="Login" class="h-32">
          </div>
          
          <!-- Login Form -->
          <form method="post" name="emplsignin" class="space-y-6">
            <!-- Email Field -->
            <div>
              <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
              <div class="relative rounded-md shadow-sm">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                  <i class="fas fa-user text-gray-400"></i>
                </div>
                <input type="email" name="email" id="email" required
                       class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg focus:ring-primary focus:border-primary"
                       placeholder="example@company.com">
              </div>
            </div>
            
            <!-- Password Field -->
            <div>
              <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
              <div class="relative rounded-md shadow-sm">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                  <i class="fas fa-lock text-gray-400"></i>
                </div>
                <input type="password" name="password" id="password" required
                       class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg focus:ring-primary focus:border-primary"
                       placeholder="••••••••">
              </div>
            </div>
            
            <!-- Sign In Button -->
            <div>
              <button type="submit" name="signin" 
                      class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-sm text-base font-medium text-white bg-primary hover:bg-primary-dark focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary transition-colors">
                Sign In
              </button>
            </div>
            
            <!-- Forgot Password Link -->
            <div class="text-center">
              <a href="forgot-password.php" class="text-sm font-medium text-primary hover:text-primary-dark">
                Forgot your password?
              </a>
            </div>
            
            <!-- Divider -->
            <div class="relative">
              <div class="absolute inset-0 flex items-center">
                <div class="w-full border-t border-gray-200"></div>
              </div>
              <div class="relative flex justify-center text-sm">
                <span class="px-3 bg-white text-gray-500">OR</span>
              </div>
            </div>
            
            <!-- Sign Up Link -->
            <div class="text-center">
              <p class="text-sm text-gray-600">
                Don't have an account?
                <a href="employers-signup.php" class="font-medium text-primary hover:text-primary-dark">
                  SIGN UP NOW
                </a>
              </p>
            </div>
          </form>
          
          <!-- Back to Home -->
          <div class="mt-8 pt-4 border-t border-gray-200 text-center">
            <a href="../index.php" class="inline-flex items-center text-primary hover:text-primary-dark">
              <i class="fas fa-home text-xl mr-2"></i> Back Home
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
            <li><a href="emp-login.php" class="text-gray-400 hover:text-white transition-colors">Login</a></li>
            <li><a href="#" class="text-gray-400 hover:text-white transition-colors">Post a Job</a></li>
            <li><a href="#" class="text-gray-400 hover:text-white transition-colors">Find Candidates</a></li>
          </ul>
        </div>
        
        <!-- Resources -->
        <div>
          <h4 class="font-semibold mb-4">For Job Seekers</h4>
          <ul class="space-y-2">
            <li><a href="../index.php" class="text-gray-400 hover:text-white transition-colors">Find Jobs</a></li>
            <li><a href="../job-search.php" class="text-gray-400 hover:text-white transition-colors">Browse Categories</a></li>
            <li><a href="../job-listing.php" class="text-gray-400 hover:text-white transition-colors">Latest Opportunities</a></li>
            <li><a href="../career-advice.php" class="text-gray-400 hover:text-white transition-colors">Career Advice</a></li>
          </ul>
        </div>
        
        <!-- Newsletter -->
        <div>
          <h4 class="font-semibold mb-4">Stay Connected</h4>
          <p class="text-gray-400 mb-4">Follow us on social media for updates.</p>
          <div class="flex space-x-4">
            <a href="#" class="text-gray-400 hover:text-white transition-colors">
              <i class="fab fa-facebook-f text-xl"></i>
            </a>
            <a href="#" class="text-gray-400 hover:text-white transition-colors">
              <i class="fab fa-twitter text-xl"></i>
            </a>
            <a href="#" class="text-gray-400 hover:text-white transition-colors">
              <i class="fab fa-linkedin-in text-xl"></i>
            </a>
            <a href="#" class="text-gray-400 hover:text-white transition-colors">
              <i class="fab fa-instagram text-xl"></i>
            </a>
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

<!-- Done 12 -->