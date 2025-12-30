<?php
session_start();
//Database Configuration File
include('includes/config.php');
error_reporting(0);
//verifying Session
if(strlen($_SESSION['jsid'])==0)
  { 
header('location:logout.php');
}
else{
if(isset($_POST['change']))
{
//Getting User Id
$uid=$_SESSION['jsid'];
// Getting Post Values
$currentpassword=$_POST['currentpassword'];
$newpassword=$_POST['newpassword'];
//new password hasing 
$options = ['cost' => 12];
$hashednewpass=password_hash($newpassword, PASSWORD_BCRYPT, $options);

  // Fetch data from database on the basis of Employee session if
    $sql ="SELECT Password FROM tbljobseekers WHERE (id=:uid )";
    $query= $dbh -> prepare($sql);
    $query-> bindParam(':uid', $uid, PDO::PARAM_STR);
    $query-> execute();
    $results=$query->fetchAll(PDO::FETCH_OBJ);
if($query->rowCount() > 0)
{
foreach ($results as $row) {
$hashpass=$row->Password;
}
//if current password verfied new password wil be updated in the databse
if (password_verify($currentpassword, $hashpass)) {
$sql="update  tbljobseekers set Password=:hashednewpass where id=:uid";
$query = $dbh->prepare($sql);
// Binding Post Values
$query->bindParam(':hashednewpass',$hashednewpass,PDO::PARAM_STR);
$query-> bindParam(':uid', $uid, PDO::PARAM_STR);
$query->execute();


echo '<script>alert("Your password successully changed")</script>';
} else {
echo '<script>alert("Your current password is wrong")</script>';

}
}


}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change Password - Hanap-Kita</title>
    
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
    function valid()
    {
    if(document.chngpwd.newpassword.value!= document.chngpwd.confirmpassword.value)
    {
    alert("New Password and Confirm Password Field do not match  !!");
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
                    <a href="index.php" class="text-gray-700 hover:text-primary font-medium transition-colors">Home</a>
                    <a href="about.php" class="text-gray-700 hover:text-primary font-medium transition-colors">About Us</a>
                    <a href="contact.php" class="text-gray-700 hover:text-primary font-medium transition-colors">Contact</a>
                </nav>
                
                <!-- User Menu -->
                <div class="flex items-center space-x-4">
                    <div class="relative group">
                        <?php
                        $uid= $_SESSION['jsid'];
                        $sql="SELECT * from tbljobseekers where id='$uid'";
                        $query = $dbh -> prepare($sql);
                        $query->execute();
                        $results=$query->fetchAll(PDO::FETCH_OBJ);
                        $cnt=1;
                        if($query->rowCount() > 0) {
                            foreach($results as $row) {
                        ?>
                        <button class="flex items-center space-x-2 text-gray-700 hover:text-primary transition-colors">
                            <?php if($row->ProfilePic==''): ?>
                                <img src="images/account.png" class="w-8 h-8 rounded-full">
                            <?php else: ?>
                                <img src="images/<?php echo $row->ProfilePic;?>" class="w-8 h-8 rounded-full">
                            <?php endif;?>
                            <span class="font-medium"><?php echo htmlentities($row->FullName); ?></span>
                            <i class="fas fa-chevron-down text-xs"></i>
                        </button>
                        <div class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg border border-gray-200 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all">
                            <a href="my-profile.php" class="block px-4 py-2 text-gray-700 hover:bg-gray-50 rounded-t-lg">My Profile</a>
                            <a href="change-password.php" class="block px-4 py-2 text-primary bg-blue-50 font-medium">Change Password</a>
                            <a href="profile.php" class="block px-4 py-2 text-gray-700 hover:bg-gray-50">Edit Profile</a>
                            <a href="applied-jobs.php" class="block px-4 py-2 text-gray-700 hover:bg-gray-50">Applied Jobs</a>
                            <a href="logout.php" class="block px-4 py-2 text-gray-700 hover:bg-gray-50 rounded-b-lg">Log Out</a>
                        </div>
                        <?php $cnt=$cnt+1;}} ?>
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

    <!-- Page Header -->
    <section class="bg-gradient-to-br from-blue-50 to-indigo-100 py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <div class="inline-flex items-center justify-center w-16 h-16 bg-primary rounded-2xl mb-6">
                    <i class="fas fa-key text-white text-2xl"></i>
                </div>
                <h1 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4">
                    Change Password
                </h1>
                <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                    Keep your account secure by updating your password regularly
                </p>
            </div>
        </div>
    </section>

    <!-- Main Content -->
    <main class="py-16">
        <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Success/Error Messages -->
            <?php if(@$error){ ?>
            <div class="mb-6 p-4 border-l-4 border-red-400 bg-red-50 rounded-lg">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <i class="fas fa-exclamation-triangle text-red-400"></i>
                    </div>
                    <div class="ml-3">
                        <p class="text-red-700 font-medium">Error</p>
                        <p class="text-red-600"><?php echo htmlentities($error);?></p>
                    </div>
                </div>
            </div>
            <?php } ?>

            <?php if(@$msg){ ?>
            <div class="mb-6 p-4 border-l-4 border-green-400 bg-green-50 rounded-lg">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <i class="fas fa-check-circle text-green-400"></i>
                    </div>
                    <div class="ml-3">
                        <p class="text-green-700 font-medium">Success</p>
                        <p class="text-green-600"><?php echo htmlentities($msg);?></p>
                    </div>
                </div>
            </div>
            <?php } ?>

            <!-- Password Change Form -->
            <div class="bg-white rounded-2xl shadow-lg border border-gray-200 overflow-hidden">
                <div class="px-8 py-6 border-b border-gray-200">
                    <h2 class="text-2xl font-bold text-gray-900">Security Settings</h2>
                    <p class="text-gray-600 mt-1">Update your password to keep your account secure</p>
                </div>
                
                <form name="chngpwd" method="post" onSubmit="return valid();" class="px-8 py-6 space-y-6">
                    <!-- Current Password -->
                    <div class="space-y-2">
                        <label for="currentpassword" class="block text-sm font-semibold text-gray-700">
                            Current Password <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-lock text-gray-400"></i>
                            </div>
                            <input type="password" 
                                   id="currentpassword"
                                   name="currentpassword" 
                                   required
                                   class="block w-full pl-10 pr-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-colors"
                                   placeholder="Enter your current password">
                        </div>
                    </div>

                    <!-- New Password -->
                    <div class="space-y-2">
                        <label for="newpassword" class="block text-sm font-semibold text-gray-700">
                            New Password <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-key text-gray-400"></i>
                            </div>
                            <input type="password" 
                                   id="newpassword"
                                   name="newpassword" 
                                   required
                                   class="block w-full pl-10 pr-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-colors"
                                   placeholder="Enter your new password">
                        </div>
                        <p class="text-xs text-gray-500">
                            Password should be at least 8 characters long and include uppercase, lowercase, and numbers.
                        </p>
                    </div>

                    <!-- Confirm Password -->
                    <div class="space-y-2">
                        <label for="confirmpassword" class="block text-sm font-semibold text-gray-700">
                            Confirm New Password <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-check-circle text-gray-400"></i>
                            </div>
                            <input type="password" 
                                   id="confirmpassword"
                                   name="confirmpassword" 
                                   required
                                   class="block w-full pl-10 pr-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-colors"
                                   placeholder="Confirm your new password">
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="pt-6">
                        <button type="submit" 
                                name="change" 
                                class="w-full bg-primary text-white py-3 px-6 rounded-xl font-semibold hover:bg-primary-dark focus:ring-4 focus:ring-primary/20 transition-all">
                            <i class="fas fa-save mr-2"></i>
                            Update Password
                        </button>
                    </div>
                </form>
            </div>

            <!-- Security Tips -->
            <div class="mt-8 bg-blue-50 rounded-2xl p-6 border border-blue-200">
                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        <i class="fas fa-info-circle text-blue-500 text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-lg font-semibold text-blue-900 mb-2">Password Security Tips</h3>
                        <ul class="text-blue-800 space-y-1 text-sm">
                            <li class="flex items-center">
                                <i class="fas fa-check text-blue-600 mr-2"></i>
                                Use a combination of uppercase and lowercase letters
                            </li>
                            <li class="flex items-center">
                                <i class="fas fa-check text-blue-600 mr-2"></i>
                                Include numbers and special characters
                            </li>
                            <li class="flex items-center">
                                <i class="fas fa-check text-blue-600 mr-2"></i>
                                Make it at least 8 characters long
                            </li>
                            <li class="flex items-center">
                                <i class="fas fa-check text-blue-600 mr-2"></i>
                                Avoid using personal information
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Back to Profile -->
            <div class="mt-8 text-center">
                <a href="my-profile.php" class="inline-flex items-center text-primary hover:text-primary-dark font-medium transition-colors">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Back to Profile
                </a>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid md:grid-cols-4 gap-8">
                <!-- Brand -->
                <div class="md:col-span-1">
                    <h3 class="text-2xl font-bold text-primary mb-4">Hanap-Kita</h3>
                    <?php
                    $sql="SELECT * from tblpages where PageType='contactus'";
                    $query = $dbh -> prepare($sql);
                    $query->execute();
                    $results=$query->fetchAll(PDO::FETCH_OBJ);
                    $cnt=1;
                    if($query->rowCount() > 0) {
                        foreach($results as $row) {
                    ?>
                    <ul class="space-y-2 text-gray-400">
                        <li class="flex items-center space-x-2">
                            <i class="fas fa-phone"></i>
                            <span>+<?php echo htmlentities($row->MobileNumber);?></span>
                        </li>
                        <li class="flex items-center space-x-2">
                            <i class="fas fa-envelope"></i>
                            <span><?php echo htmlentities($row->Email);?></span>
                        </li>
                        <li class="flex items-center space-x-2">
                            <i class="fas fa-map-marker-alt"></i>
                            <span><?php echo htmlentities($row->PageDescription);?></span>
                        </li>
                    </ul>
                    <?php $cnt=$cnt+1;}} ?>
                </div>
                
                <!-- Quick Links -->
                <div>
                    <h4 class="font-semibold mb-4">Quick Links</h4>
                    <ul class="space-y-2">
                        <li><a href="about.php" class="text-gray-400 hover:text-white transition-colors">About</a></li>
                        <li><a href="contact.php" class="text-gray-400 hover:text-white transition-colors">Contact</a></li>
                        <li><a href="index.php" class="text-gray-400 hover:text-white transition-colors">Home</a></li>
                        <li><a href="my-profile.php" class="text-gray-400 hover:text-white transition-colors">My Profile</a></li>
                        <li><a href="applied-jobs.php" class="text-gray-400 hover:text-white transition-colors">Applied Jobs</a></li>
                    </ul>
                </div>
                
                <!-- Account -->
                <div>
                    <h4 class="font-semibold mb-4">Account</h4>
                    <ul class="space-y-2">
                        <li><a href="profile.php" class="text-gray-400 hover:text-white transition-colors">Edit Profile</a></li>
                        <li><a href="change-password.php" class="text-gray-400 hover:text-white transition-colors">Change Password</a></li>
                        <li><a href="add-education.php" class="text-gray-400 hover:text-white transition-colors">Add Education</a></li>
                        <li><a href="add-experience.php" class="text-gray-400 hover:text-white transition-colors">Add Experience</a></li>
                    </ul>
                </div>
                
                <!-- Support -->
                <div>
                    <h4 class="font-semibold mb-4">Need Help?</h4>
                    <p class="text-gray-400 mb-4">Contact our support team for assistance with your account.</p>
                    <a href="contact.php" class="bg-primary text-white px-4 py-2 rounded-lg hover:bg-primary-dark transition-colors">
                        Get Support
                    </a>
                </div>
            </div>
            
            <div class="border-t border-gray-800 mt-12 pt-8 text-center">
                <p class="text-gray-400">&copy; 2024 Hanap-Kita. All rights reserved.</p>
            </div>
        </div>
    </footer>

</body>
</html>
<?php }
?>

<!-- Done 9 -->