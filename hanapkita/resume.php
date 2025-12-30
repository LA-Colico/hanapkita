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
if(isset($_POST['update']))
{
//getting resume
$uid=$_SESSION['jsid'];
$resume=$_FILES["resume"]["name"];
// get the resume extension
$extension = substr($resume,strlen($resume)-4,strlen($resume));
// allowed extensions
$allowed_extensions = array(".pdf",".docx",".doc");
// Validation for allowed extensions .in_array() function searches an array for a specific value.
if(!in_array($extension,$allowed_extensions))
{
echo "<script>alert('Invalid Resume format. Only PDF, DOC, and DOCX format allowed');</script>";
}
else
{
// Create folder if it doesn't exist
if (!file_exists('Jobseekersresumes')) {
    mkdir('Jobseekersresumes', 0755, true);
}

//rename the resume file
$resumename=md5($resume).time().$extension;
// Code for move resume into directory
move_uploaded_file($_FILES["resume"]["tmp_name"],"Jobseekersresumes/".$resumename);

$sql="update tbljobseekers set Resume=:resumename where id=:uid";
$query = $dbh->prepare($sql);
// Binding Post Values
$query-> bindParam(':uid', $uid, PDO::PARAM_STR);
$query->bindParam(':resumename',$resumename,PDO::PARAM_STR);
$query->execute();

echo '<script>alert("Your resume has been updated")</script>';
echo "<script>window.location.href ='profile.php'</script>";

}

}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Resume - Hanap-Kita</title>
    
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
                        if($query_user->rowCount() > 0) {
                            foreach($results_user as $row_user) {
                        ?>
                        <button class="flex items-center space-x-2 text-gray-700 hover:text-primary transition-colors">
                            <?php if($row_user->ProfilePic==''): ?>
                                <img src="images/account.png" class="w-8 h-8 rounded-full">
                            <?php else: ?>
                                <img src="images/<?php echo $row_user->ProfilePic;?>" alt="Profile" class="w-8 h-8 rounded-full">
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
                        <?php }} ?>
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
                <a href="profile.php" class="text-gray-500 hover:text-primary transition-colors">Edit Profile</a>
                <i class="fas fa-chevron-right text-gray-400 text-xs"></i>
                <span class="text-gray-900 font-medium">Update Resume</span>
            </nav>
        </div>
    </div>

    <!-- Main Content -->
    <main class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <!-- Page Header -->
        <div class="text-center mb-12">
            <div class="w-16 h-16 bg-primary/10 rounded-2xl flex items-center justify-center mx-auto mb-6">
                <i class="fas fa-file-pdf text-primary text-2xl"></i>
            </div>
            <h1 class="text-4xl font-bold text-gray-900 mb-4">Update Resume</h1>
            <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                Upload your latest resume to showcase your qualifications to employers
            </p>
        </div>

        <?php
        //Getting User Id
        $uid=$_SESSION['jsid'];
        $sql = "SELECT * from tbljobseekers where id=:uid";
        $query = $dbh -> prepare($sql);
        $query-> bindParam(':uid', $uid, PDO::PARAM_STR);
        $query->execute();
        $results=$query->fetchAll(PDO::FETCH_OBJ);
        if($query->rowCount() > 0)
        {
        foreach($results as $result)
        {
        ?>

        <!-- Resume Management -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="bg-gradient-to-r from-primary to-primary-light p-6 text-white">
                <h2 class="text-2xl font-bold">Resume Management</h2>
                <p class="text-primary-light mt-2">Manage your resume file for job applications</p>
            </div>
            
            <div class="p-8">
                <!-- Current Resume -->
                <div class="mb-8">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Current Resume</h3>
                    <div class="bg-gray-50 border border-gray-200 rounded-xl p-6">
                        <div class="flex items-center space-x-4">
                            <div class="w-12 h-12 bg-red-100 rounded-xl flex items-center justify-center">
                                <i class="fas fa-file-pdf text-red-600"></i>
                            </div>
                            <div class="flex-1">
                                <?php if(!empty($result->Resume)): ?>
                                    <h4 class="font-medium text-gray-900">Resume File</h4>
                                    <p class="text-sm text-gray-600"><?php echo htmlentities($result->Resume); ?></p>
                                    <?php 
                                    $resume_path = "Jobseekersresumes/" . $result->Resume;
                                    if(file_exists($resume_path)): 
                                    ?>
                                        <p class="text-xs text-green-600 mt-1">
                                            <i class="fas fa-check-circle mr-1"></i>File available
                                        </p>
                                    <?php else: ?>
                                        <p class="text-xs text-red-600 mt-1">
                                            <i class="fas fa-exclamation-triangle mr-1"></i>File not found on server
                                        </p>
                                    <?php endif; ?>
                                <?php else: ?>
                                    <h4 class="font-medium text-gray-900">No Resume Uploaded</h4>
                                    <p class="text-sm text-gray-500">Upload your first resume to get started</p>
                                <?php endif; ?>
                            </div>
                            <div class="flex space-x-3">
                                <?php if(!empty($result->Resume) && file_exists($resume_path)): ?>
                                <a href="<?php echo htmlentities($resume_path); ?>" target="_blank"
                                   class="bg-primary text-white px-4 py-2 rounded-lg hover:bg-primary-dark transition-colors text-sm">
                                    <i class="fas fa-eye mr-1"></i>View
                                </a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Upload Form -->
                <form method="post" enctype="multipart/form-data">
                    <div class="mb-6">
                        <label class="block text-sm font-semibold text-gray-700 mb-3">
                            <i class="fas fa-upload text-primary mr-2"></i>
                            Upload New Resume
                        </label>
                        <div class="border-2 border-dashed border-gray-300 rounded-xl p-8 text-center hover:border-primary transition-colors">
                            <div class="mb-4">
                                <i class="fas fa-cloud-upload-alt text-4xl text-gray-400 mb-2"></i>
                                <p class="text-lg font-medium text-gray-700 mb-2">Choose Resume File</p>
                                <p class="text-sm text-gray-500">PDF, DOC, or DOCX files only</p>
                            </div>
                            <input type="file" name="resume" required
                                   class="w-full text-sm text-gray-500 file:mr-4 file:py-3 file:px-6 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-primary file:text-white hover:file:bg-primary-dark transition-colors">
                            <p class="text-xs text-gray-500 mt-3">Maximum file size: 5MB</p>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex flex-col sm:flex-row gap-4 pt-6 border-t border-gray-200">
                        <button type="submit" name="update"
                                class="flex-1 bg-primary text-white py-4 px-8 rounded-xl font-semibold hover:bg-primary-dark transition-colors flex items-center justify-center space-x-2">
                            <i class="fas fa-upload"></i>
                            <span>Update Resume</span>
                        </button>
                        <a href="profile.php"
                           class="flex-1 bg-gray-100 text-gray-700 py-4 px-8 rounded-xl font-semibold hover:bg-gray-200 transition-colors flex items-center justify-center space-x-2">
                            <i class="fas fa-arrow-left"></i>
                            <span>Back to Profile</span>
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <?php }} ?>

        <!-- Help Section -->
        <div class="mt-12 bg-blue-50 rounded-2xl p-8">
            <div class="flex items-start space-x-4">
                <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center flex-shrink-0">
                    <i class="fas fa-info-circle text-blue-600"></i>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-blue-900 mb-2">Resume Upload Tips</h3>
                    <ul class="text-blue-800 space-y-1">
                        <li class="flex items-center space-x-2">
                            <i class="fas fa-check text-blue-600 text-sm"></i>
                            <span>Use PDF format for best compatibility across devices</span>
                        </li>
                        <li class="flex items-center space-x-2">
                            <i class="fas fa-check text-blue-600 text-sm"></i>
                            <span>Keep file size under 5MB for faster loading</span>
                        </li>
                        <li class="flex items-center space-x-2">
                            <i class="fas fa-check text-blue-600 text-sm"></i>
                            <span>Use a clear, professional filename</span>
                        </li>
                        <li class="flex items-center space-x-2">
                            <i class="fas fa-check text-blue-600 text-sm"></i>
                            <span>Ensure your resume is up-to-date with latest experience</span>
                        </li>
                    </ul>
                </div>
            </div>
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