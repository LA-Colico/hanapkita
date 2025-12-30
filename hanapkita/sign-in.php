<?php
 session_start();
//Database Configuration File
include('includes/config.php');
error_reporting(0);
if(isset($_POST['signin']))
  {
 
    // Getting username/ email and password
    $uname=$_POST['emailmbile'];
    $password=$_POST['password'];
    // Fetch data from database on the basis of username/email and password
    $sql ="SELECT id,FullName,Password FROM tbljobseekers WHERE (EmailId=:usname || ContactNumber=:usname)";
    $query= $dbh -> prepare($sql);
    $query-> bindParam(':usname', $uname, PDO::PARAM_STR);
    $query-> execute();
    $results=$query->fetchAll(PDO::FETCH_OBJ);
if($query->rowCount() > 0)
{
foreach ($results as $row) {
$dbhashpass=$row->Password;
$_SESSION['jsid']=$row->id;
$_SESSION['jsfname']=$row->FullName;

}
//verifying Password
if (password_verify($password, $dbhashpass)) {
echo "<script type='text/javascript'> document.location ='my-profile.php'; </script>";
  } else {
echo "<script>alert('Wrong Password');</script>";
 
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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In - Hanap-Kita</title>
    
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

<body class="bg-gradient-to-br from-blue-50 to-indigo-100 min-h-screen flex items-center justify-center">
    
    <div class="max-w-md w-full mx-4">
        <!-- Back to Home -->
        <div class="text-center mb-8">
            <a href="index.php" class="inline-flex items-center text-primary hover:text-primary-dark transition-colors">
                <i class="fas fa-arrow-left mr-2"></i>
                <span class="font-medium">Back to Home</span>
            </a>
        </div>
        
        <!-- Sign In Card -->
        <div class="bg-white shadow-xl rounded-2xl p-8">
            <!-- Logo -->
            <div class="text-center mb-8">
                <h1 class="text-3xl font-bold text-primary mb-2">Hanap-Kita</h1>
                <h2 class="text-2xl font-semibold text-gray-900 mb-2">Welcome Back</h2>
                <p class="text-gray-600">Sign in to your account</p>
            </div>
            
            <!-- Sign In Form -->
            <form method="post" name="emplsignin" class="space-y-6">
                <!-- Email/Mobile Input -->
                <div>
                    <label for="emailmbile" class="block text-sm font-medium text-gray-700 mb-2">
                        Email or Mobile Number
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-user text-gray-400"></i>
                        </div>
                        <input type="text" 
                               id="emailmbile"
                               name="emailmbile" 
                               placeholder="Enter your email or mobile number" 
                               autocomplete="off" 
                               required
                               class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-colors">
                    </div>
                </div>

                <!-- Password Input -->
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                        Password
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-lock text-gray-400"></i>
                        </div>
                        <input type="password" 
                               id="password"
                               name="password" 
                               placeholder="Enter your password" 
                               required
                               class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-colors">
                    </div>
                </div>

                <!-- Sign In Button -->
                <button type="submit" 
                        name="signin" 
                        class="w-full bg-primary text-white py-3 rounded-xl font-semibold hover:bg-primary-dark transition-colors focus:ring-2 focus:ring-primary focus:ring-offset-2">
                    Sign In
                </button>

                <!-- Forgot Password Link -->
                <div class="text-center">
                    <a href="forgot-password.php" class="text-primary hover:text-primary-dark font-medium transition-colors">
                        Forgot your password?
                    </a>
                </div>
            </form>

            <!-- Divider -->
            <div class="relative my-8">
                <div class="absolute inset-0 flex items-center">
                    <div class="w-full border-t border-gray-300"></div>
                </div>
                <div class="relative flex justify-center text-sm">
                    <span class="px-2 bg-white text-gray-500">OR</span>
                </div>
            </div>

            <!-- Sign Up Link -->
            <div class="text-center">
                <p class="text-gray-600">
                    Don't have an account? 
                    <a href="sign-up.php" class="text-primary hover:text-primary-dark font-semibold transition-colors">
                        Sign up now
                    </a>
                </p>
            </div>
        </div>
    </div>

</body>
</html>

<!-- Done 3 -->