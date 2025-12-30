<?php
session_start();
include("includes/config.php");
$_SESSION['login']=="";
session_unset();
session_destroy();
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hanap-Kita - Logging Out</title>
    
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
    
    <!-- Auto-redirect script -->
    <script>
        setTimeout(function() {
            window.location.href = "index.php";
        }, 3000);
    </script>
</head>

<body class="bg-gray-50 text-gray-900 font-sans min-h-screen flex items-center justify-center">
    
    <!-- Logout Container -->
    <div class="max-w-md w-full mx-auto">
        <div class="bg-white rounded-2xl shadow-lg border border-gray-200 p-8 text-center">
            <!-- Logo -->
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-primary">Hanap-Kita</h1>
            </div>
            
            <!-- Logout Animation/Icon -->
            <div class="mb-6">
                <div class="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-check text-3xl text-green-600"></i>
                </div>
                <div class="mb-4">
                    <div class="animate-spin w-8 h-8 border-4 border-primary border-t-transparent rounded-full mx-auto"></div>
                </div>
            </div>
            
            <!-- Logout Message -->
            <h2 class="text-2xl font-bold text-gray-900 mb-4">Logging Out...</h2>
            <p class="text-gray-600 mb-8">
                You have been successfully logged out. Thank you for using Hanap-Kita!
            </p>
            
            <!-- Redirect Info -->
            <div class="bg-blue-50 border border-blue-200 rounded-xl p-4 mb-6">
                <p class="text-blue-800 text-sm">
                    <i class="fas fa-info-circle mr-2"></i>
                    You will be redirected to the home page in 3 seconds...
                </p>
            </div>
            
            <!-- Manual Redirect Button -->
            <div class="space-y-3">
                <a href="index.php" 
                   class="w-full bg-primary text-white py-3 px-6 rounded-xl font-semibold hover:bg-primary-dark transition-colors inline-block">
                    <i class="fas fa-home mr-2"></i>Go to Home Page
                </a>
                <a href="sign-in.php" 
                   class="w-full bg-gray-100 text-gray-700 py-3 px-6 rounded-xl font-semibold hover:bg-gray-200 transition-colors inline-block">
                    <i class="fas fa-sign-in-alt mr-2"></i>Sign In Again
                </a>
            </div>
        </div>
        
        <!-- Additional Options -->
        <div class="mt-6 text-center">
            <p class="text-gray-500 text-sm mb-4">Quick Access</p>
            <div class="flex justify-center space-x-4">
                <a href="sign-up.php" class="text-primary hover:text-primary-dark transition-colors text-sm">
                    Job Seeker Registration
                </a>
                <span class="text-gray-300">|</span>
                <a href="employers/emp-login.php" class="text-primary hover:text-primary-dark transition-colors text-sm">
                    Employer Login
                </a>
            </div>
        </div>
    </div>
    
    <!-- Background Pattern -->
    <div class="fixed inset-0 -z-10">
        <div class="absolute inset-0 bg-gradient-to-br from-blue-50 to-indigo-100 opacity-50"></div>
        <div class="absolute inset-0" style="background-image: radial-gradient(circle at 1px 1px, rgba(95,77,238,0.1) 1px, transparent 0); background-size: 20px 20px;"></div>
    </div>

</body>
</html>

<!-- Done 18 -->