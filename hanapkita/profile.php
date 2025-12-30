<?php
session_start();
//Database Configuration File
include('includes/config.php');
//error_reporting(0);

// Initialize variables
$error = "";
$msg = "";

//verifying Session
if(strlen($_SESSION['jsid'])==0)
  { 
header('location:logout.php');
exit();
}
else{

if(isset($_POST['update']))
{
try {
    //Getting Post Values
    $FullName = trim($_POST['fname']);  
    $aboutme = trim($_POST['aboutme']); 
    $skills = trim($_POST['skills']);
    //Getting User Id
    $uid = $_SESSION['jsid'];

    // Validate required fields
    if(empty($FullName)) {
        $error = "Full Name is required.";
    } else {
        $sql="UPDATE tbljobseekers SET FullName=:fname, AboutMe=:aboutme, Skills=:skills WHERE id=:uid";
        $query = $dbh->prepare($sql);
        
        // Binding Post Values
        $query->bindParam(':fname', $FullName, PDO::PARAM_STR);
        $query->bindParam(':uid', $uid, PDO::PARAM_STR);
        $query->bindParam(':aboutme', $aboutme, PDO::PARAM_STR);
        $query->bindParam(':skills', $skills, PDO::PARAM_STR);
        
        if($query->execute()) {
            // Update session name if changed
            $_SESSION['jsfname'] = $FullName;
            $msg = "Account details have been updated successfully.";
            echo "<script>setTimeout(function(){ window.location.href ='profile.php'; }, 2000);</script>";
        } else {
            $error = "Failed to update account. Please try again.";
        }
    }
} catch(Exception $e) {
    $error = "Database error: " . $e->getMessage();
}
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile - Hanap-Kita</title>
    
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
        
        // Form validation
        function validateForm() {
            const fullName = document.querySelector('input[name="fname"]').value.trim();
            
            if (!fullName) {
                alert('Full Name is required.');
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
                    <a href="my-profile.php" class="text-gray-700 hover:text-primary font-medium transition-colors">My Profile</a>
                    <a href="profile.php" class="text-primary font-medium border-b-2 border-primary pb-1">Edit Profile</a>
                    <a href="applied-jobs.php" class="text-gray-700 hover:text-primary font-medium transition-colors">Applied Jobs</a>
                </nav>
                
                <!-- User Menu -->
                <div class="flex items-center space-x-4">
                    <div class="relative group">
                        <?php
                        $uid= $_SESSION['jsid'];
                        $sql_user="SELECT * from tbljobseekers where id='$uid'";
                        $query_user = $dbh -> prepare($sql_user);
                        $query_user->execute();
                        $results_user=$query_user->fetchAll(PDO::FETCH_OBJ);
                        $cnt=1;
                        if($query_user->rowCount() > 0) {
                            foreach($results_user as $row_user) {
                        ?>
                        <button class="flex items-center space-x-2 text-gray-700 hover:text-primary transition-colors">
                            <?php if($row_user->ProfilePic==''): ?>
                                <img src="images/account.png" class="w-8 h-8 rounded-full">
                            <?php else: ?>
                                <img src="images/<?php echo $row_user->ProfilePic;?>" class="w-8 h-8 rounded-full">
                            <?php endif;?>
                            <span class="font-medium"><?php echo htmlentities($_SESSION['jsfname']); ?></span>
                            <i class="fas fa-chevron-down text-xs"></i>
                        </button>
                        <div class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg border border-gray-200 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all">
                            <a href="my-profile.php" class="block px-4 py-2 text-gray-700 hover:bg-gray-50 rounded-t-lg">My Profile</a>
                            <a href="change-password.php" class="block px-4 py-2 text-gray-700 hover:bg-gray-50">Change Password</a>
                            <a href="profile.php" class="block px-4 py-2 text-gray-700 hover:bg-gray-50">Edit Profile</a>
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

    <!-- Breadcrumb -->
    <div class="bg-white border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
            <nav class="flex items-center space-x-2 text-sm">
                <a href="index.php" class="text-gray-500 hover:text-primary transition-colors">Home</a>
                <i class="fas fa-chevron-right text-gray-400 text-xs"></i>
                <a href="my-profile.php" class="text-gray-500 hover:text-primary transition-colors">My Profile</a>
                <i class="fas fa-chevron-right text-gray-400 text-xs"></i>
                <span class="text-gray-900 font-medium">Edit Profile</span>
            </nav>
        </div>
    </div>

    <!-- Main Content -->
    <main class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <!-- Page Header -->
        <div class="text-center mb-12">
            <div class="w-16 h-16 bg-primary/10 rounded-2xl flex items-center justify-center mx-auto mb-6">
                <i class="fas fa-user-edit text-primary text-2xl"></i>
            </div>
            <h1 class="text-4xl font-bold text-gray-900 mb-4">Edit Profile</h1>
            <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                Update your personal information and professional details
            </p>
        </div>

        <!-- Success and Error Messages -->
        <?php if(!empty($error)){ ?>
        <div class="bg-red-50 border border-red-200 rounded-xl p-4 mb-8">
            <div class="flex items-center space-x-3">
                <i class="fas fa-exclamation-circle text-red-500"></i>
                <div>
                    <h3 class="font-semibold text-red-800">Error</h3>
                    <p class="text-red-700"><?php echo htmlentities($error);?></p>
                </div>
            </div>
        </div>
        <?php } ?>

        <?php if(!empty($msg)){ ?>
        <div class="bg-green-50 border border-green-200 rounded-xl p-4 mb-8">
            <div class="flex items-center space-x-3">
                <i class="fas fa-check-circle text-green-500"></i>
                <div>
                    <h3 class="font-semibold text-green-800">Success</h3>
                    <p class="text-green-700"><?php echo htmlentities($msg);?></p>
                </div>
            </div>
        </div>
        <?php } ?>

        <?php
        //Getting User Details
        $uid=$_SESSION['jsid'];
        $sql = "SELECT * from tbljobseekers where id=:uid";
        $query = $dbh -> prepare($sql);
        $query-> bindParam(':uid', $uid, PDO::PARAM_STR);
        $query->execute();
        $results=$query->fetchAll(PDO::FETCH_OBJ);
        
        if($query->rowCount() > 0) {
            foreach($results as $result) {
        ?>

        <!-- Profile Form -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="bg-gradient-to-r from-primary to-primary-light p-6 text-white">
                <h2 class="text-2xl font-bold">Personal Information</h2>
                <p class="text-primary-light mt-2">Update your profile details and preferences</p>
            </div>
            
            <form method="post" class="p-8" onsubmit="return validateForm()">
                <div class="grid md:grid-cols-2 gap-8">
                    <!-- Full Name -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-3">
                            <i class="fas fa-user text-primary mr-2"></i>
                            Full Name <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="fname" required
                               placeholder="Enter your full name"
                               autocomplete="off"
                               value="<?php echo htmlentities($result->FullName)?>"
                               class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-colors">
                    </div>

                    <!-- Email (Readonly) -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-3">
                            <i class="fas fa-envelope text-gray-400 mr-2"></i>
                            Email Address
                        </label>
                        <input type="email" readonly
                               value="<?php echo htmlentities($result->EmailId)?>"
                               class="w-full px-4 py-3 border border-gray-200 rounded-xl bg-gray-50 text-gray-600 cursor-not-allowed">
                        <p class="text-xs text-gray-500 mt-1">Email cannot be changed</p>
                    </div>

                    <!-- Contact Number (Readonly) -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-3">
                            <i class="fas fa-phone text-gray-400 mr-2"></i>
                            Contact Number
                        </label>
                        <input type="text" readonly
                               value="<?php echo htmlentities($result->ContactNumber)?>"
                               class="w-full px-4 py-3 border border-gray-200 rounded-xl bg-gray-50 text-gray-600 cursor-not-allowed">
                        <p class="text-xs text-gray-500 mt-1">Contact number cannot be changed</p>
                    </div>

                    <!-- Registration Date (Readonly) -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-3">
                            <i class="fas fa-calendar text-gray-400 mr-2"></i>
                            Registration Date
                        </label>
                        <input type="text" readonly
                               value="<?php echo htmlentities($result->RegDate)?>"
                               class="w-full px-4 py-3 border border-gray-200 rounded-xl bg-gray-50 text-gray-600 cursor-not-allowed">
                    </div>

                    <!-- Resume Section -->
                    <div class="md:col-span-2">
                        <label class="block text-sm font-semibold text-gray-700 mb-3">
                            <i class="fas fa-file-pdf text-primary mr-2"></i>
                            Resume
                        </label>
                        <div class="bg-gray-50 border border-gray-200 rounded-xl p-6">
                            <div class="flex items-center space-x-4">
                                <div class="w-12 h-12 bg-red-100 rounded-xl flex items-center justify-center">
                                    <i class="fas fa-file-pdf text-red-600 text-xl"></i>
                                </div>
                                <div class="flex-1">
                                    <h4 class="font-medium text-gray-900">Current Resume</h4>
                                    <?php if(!empty($result->Resume)): ?>
                                        <?php 
                                        // Create folder if it doesn't exist
                                        if (!file_exists('Jobseekersresumes')) {
                                            mkdir('Jobseekersresumes', 0755, true);
                                        }
                                        $resume_path = "Jobseekersresumes/" . $result->Resume;
                                        ?>
                                        <?php if(file_exists($resume_path)): ?>
                                            <p class="text-sm text-gray-600"><?php echo htmlentities($result->Resume); ?></p>
                                        <?php else: ?>
                                            <p class="text-sm text-red-500">Resume file not found</p>
                                        <?php endif; ?>
                                    <?php else: ?>
                                        <p class="text-sm text-gray-500">No resume uploaded</p>
                                    <?php endif; ?>
                                </div>
                                <div class="flex space-x-3">
                                    <?php if(!empty($result->Resume) && file_exists($resume_path)): ?>
                                        <a href="<?php echo htmlentities($resume_path); ?>" target="_blank"
                                           class="bg-primary text-white px-4 py-2 rounded-lg hover:bg-primary-dark transition-colors text-sm">
                                            <i class="fas fa-eye mr-1"></i>View
                                        </a>
                                    <?php endif; ?>
                                    <a href="resume.php?updateid=<?php echo $result->id;?>"
                                       class="bg-gray-200 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-300 transition-colors text-sm">
                                        <i class="fas fa-edit mr-1"></i><?php echo !empty($result->Resume) ? 'Update' : 'Upload'; ?>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Profile Picture Section -->
                    <div class="md:col-span-2">
                        <label class="block text-sm font-semibold text-gray-700 mb-3">
                            <i class="fas fa-image text-primary mr-2"></i>
                            Profile Picture
                        </label>
                        <div class="bg-gray-50 border border-gray-200 rounded-xl p-6">
                            <div class="flex items-center space-x-4">
                                <div class="w-16 h-16 rounded-full overflow-hidden bg-gray-200">
                                    <?php 
                                    // Create folder if it doesn't exist
                                    if (!file_exists('images')) {
                                        mkdir('images', 0755, true);
                                    }
                                    $profile_pic_path = "images/" . $result->ProfilePic;
                                    if(!empty($result->ProfilePic) && file_exists($profile_pic_path)): 
                                    ?>
                                        <img src="<?php echo htmlentities($profile_pic_path); ?>" alt="Profile" class="w-full h-full object-cover">
                                    <?php else: ?>
                                        <img src="images/account.png" alt="Default" class="w-full h-full object-cover">
                                    <?php endif; ?>
                                </div>
                                <div class="flex-1">
                                    <h4 class="font-medium text-gray-900">Profile Photo</h4>
                                    <?php if(!empty($result->ProfilePic)): ?>
                                        <?php if(file_exists($profile_pic_path)): ?>
                                            <p class="text-sm text-gray-600">Photo uploaded successfully</p>
                                        <?php else: ?>
                                            <p class="text-sm text-red-500">Photo file not found</p>
                                        <?php endif; ?>
                                    <?php else: ?>
                                        <p class="text-sm text-gray-500">No photo uploaded</p>
                                    <?php endif; ?>
                                </div>
                                <a href="change-profilepics.php"
                                   class="bg-primary text-white px-4 py-2 rounded-lg hover:bg-primary-dark transition-colors text-sm">
                                    <i class="fas fa-camera mr-1"></i><?php echo !empty($result->ProfilePic) ? 'Change Photo' : 'Upload Photo'; ?>
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- About Me -->
                    <div class="md:col-span-2">
                        <label class="block text-sm font-semibold text-gray-700 mb-3">
                            <i class="fas fa-user-circle text-primary mr-2"></i>
                            About Me
                        </label>
                        <textarea name="aboutme" rows="4"
                                  placeholder="Tell employers about yourself, your experience, and career goals..."
                                  class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-colors resize-none"><?php echo htmlentities($result->AboutMe)?></textarea>
                        <p class="text-xs text-gray-500 mt-1">Write a brief summary about yourself and your professional background</p>
                    </div>

                    <!-- Skills -->
                    <div class="md:col-span-2">
                        <label class="block text-sm font-semibold text-gray-700 mb-3">
                            <i class="fas fa-tools text-primary mr-2"></i>
                            Skills & Expertise
                        </label>
                        <textarea name="skills" rows="3"
                                  placeholder="e.g. Customer Service, Microsoft Office, Project Management, Communication, Problem Solving..."
                                  class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-colors resize-none"><?php echo htmlentities($result->Skills)?></textarea>
                        <p class="text-xs text-gray-500 mt-1">List your key skills separated by commas</p>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex flex-col sm:flex-row gap-4 mt-12 pt-8 border-t border-gray-200">
                    <button type="submit" name="update" 
                            class="flex-1 bg-primary text-white py-4 px-8 rounded-xl font-semibold hover:bg-primary-dark transition-colors flex items-center justify-center space-x-2">
                        <i class="fas fa-save"></i>
                        <span>Update Profile</span>
                    </button>
                    <a href="my-profile.php" 
                       class="flex-1 bg-gray-100 text-gray-700 py-4 px-8 rounded-xl font-semibold hover:bg-gray-200 transition-colors flex items-center justify-center space-x-2">
                        <i class="fas fa-arrow-left"></i>
                        <span>Back to Profile</span>
                    </a>
                </div>
            </form>
        </div>

        <?php }} ?>

        <!-- Quick Actions -->
        <div class="mt-12 grid md:grid-cols-3 gap-6">
            <a href="add-education.php" class="bg-white rounded-xl border border-gray-200 p-6 hover:shadow-lg transition-all group">
                <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                    <i class="fas fa-graduation-cap text-blue-600"></i>
                </div>
                <h3 class="font-semibold text-gray-900 mb-2">Add Education</h3>
                <p class="text-gray-600 text-sm">Add your educational background and qualifications</p>
            </a>

            <a href="add-experience.php" class="bg-white rounded-xl border border-gray-200 p-6 hover:shadow-lg transition-all group">
                <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                    <i class="fas fa-briefcase text-green-600"></i>
                </div>
                <h3 class="font-semibold text-gray-900 mb-2">Add Experience</h3>
                <p class="text-gray-600 text-sm">Share your work experience and professional history</p>
            </a>

            <a href="change-password.php" class="bg-white rounded-xl border border-gray-200 p-6 hover:shadow-lg transition-all group">
                <div class="w-12 h-12 bg-purple-100 rounded-xl flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                    <i class="fas fa-lock text-purple-600"></i>
                </div>
                <h3 class="font-semibold text-gray-900 mb-2">Change Password</h3>
                <p class="text-gray-600 text-sm">Update your account password for security</p>
            </a>
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white py-16 mt-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid md:grid-cols-4 gap-8">
                <!-- Brand -->
                <div class="md:col-span-1">
                    <h3 class="text-2xl font-bold text-primary mb-4">Hanap-Kita</h3>
                    <p class="text-gray-400 mb-4">Connecting local talent with opportunity in Balic-Balic, Sampaloc, Manila.</p>
                    <div class="flex space-x-4">
                        <a href="#" class="w-10 h-10 bg-gray-800 rounded-lg flex items-center justify-center hover:bg-primary transition-colors">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="#" class="w-10 h-10 bg-gray-800 rounded-lg flex items-center justify-center hover:bg-primary transition-colors">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="#" class="w-10 h-10 bg-gray-800 rounded-lg flex items-center justify-center hover:bg-primary transition-colors">
                            <i class="fab fa-linkedin-in"></i>
                        </a>
                    </div>
                </div>
                
                <!-- Quick Links -->
                <div>
                    <h4 class="font-semibold mb-4">Quick Links</h4>
                    <ul class="space-y-2">
                        <li><a href="index.php" class="text-gray-400 hover:text-white transition-colors">Home</a></li>
                        <li><a href="my-profile.php" class="text-gray-400 hover:text-white transition-colors">My Profile</a></li>
                        <li><a href="applied-jobs.php" class="text-gray-400 hover:text-white transition-colors">Applied Jobs</a></li>
                        <li><a href="change-password.php" class="text-gray-400 hover:text-white transition-colors">Change Password</a></li>
                    </ul>
                </div>
                
                <!-- Support -->
                <div>
                    <h4 class="font-semibold mb-4">Support</h4>
                    <ul class="space-y-2">
                        <li><a href="about.php" class="text-gray-400 hover:text-white transition-colors">About Us</a></li>
                        <li><a href="contact.php" class="text-gray-400 hover:text-white transition-colors">Contact Us</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition-colors">Help Center</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition-colors">Privacy Policy</a></li>
                    </ul>
                </div>
                
                <!-- Contact Info -->
                <div>
                    <h4 class="font-semibold mb-4">Contact Info</h4>
                    <ul class="space-y-2 text-gray-400">
                        <li class="flex items-center space-x-2">
                            <i class="fas fa-map-marker-alt"></i>
                            <span>Balic-Balic, Sampaloc, Manila</span>
                        </li>
                        <li class="flex items-center space-x-2">
                            <i class="fas fa-envelope"></i>
                            <span>hanapkita@gmail.com</span>
                        </li>
                        <li class="flex items-center space-x-2">
                            <i class="fas fa-phone"></i>
                            <span>+63 976 754 5211</span>
                        </li>
                    </ul>
                </div>
            </div>
            
            <div class="border-t border-gray-800 mt-12 pt-8 text-center">
                <p class="text-gray-400">&copy; 2024 Hanap-Kita. All rights reserved.</p>
            </div>
        </div>
    </footer>

</body>
</html>
<?php } ?>