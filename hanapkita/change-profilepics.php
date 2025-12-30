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
//getting image
$img=$_FILES["image"]["name"];
$uid=$_SESSION['jsid'];
$extension = substr($img,strlen($img)-4,strlen($img));
$allowed_extensions = array(".jpg","jpeg",".png",".gif");
if(!in_array($extension,$allowed_extensions))
{
echo "<script>alert('profile image has Invalid format. Only jpg / jpeg/ png /gif format allowed');</script>";
}
else
{
// Create folder if it doesn't exist
if (!file_exists('images')) {
    mkdir('images', 0755, true);
}

$img=md5($img).time().$extension;
move_uploaded_file($_FILES["image"]["tmp_name"],"images/".$img);

$sql="update tbljobseekers set ProfilePic=:img where id=:uid";
$query = $dbh->prepare($sql);
// Binding Post Values
$query-> bindParam(':uid', $uid, PDO::PARAM_STR);
$query->bindParam(':img',$img,PDO::PARAM_STR);
$query->execute();

echo '<script>alert("Your profile pic has been updated")</script>';
echo "<script>window.location.href ='profile.php'</script>";

}

}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change Profile Picture - Hanap-Kita</title>
    
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

        function previewImage(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('preview-image').src = e.target.result;
                    document.getElementById('preview-container').classList.remove('hidden');
                }
                reader.readAsDataURL(file);
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
                <span class="text-gray-900 font-medium">Change Profile Picture</span>
            </nav>
        </div>
    </div>

    <!-- Main Content -->
    <main class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <!-- Page Header -->
        <div class="text-center mb-12">
            <div class="w-16 h-16 bg-primary/10 rounded-2xl flex items-center justify-center mx-auto mb-6">
                <i class="fas fa-camera text-primary text-2xl"></i>
            </div>
            <h1 class="text-4xl font-bold text-gray-900 mb-4">Change Profile Picture</h1>
            <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                Upload a professional photo to make a great first impression with employers
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

        <!-- Profile Picture Management -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="bg-gradient-to-r from-primary to-primary-light p-6 text-white">
                <h2 class="text-2xl font-bold">Profile Picture Management</h2>
                <p class="text-primary-light mt-2">Update your profile photo for a professional appearance</p>
            </div>
            
            <div class="p-8">
                <!-- Current Profile Picture -->
                <div class="text-center mb-8">
                    <h3 class="text-lg font-semibold text-gray-900 mb-6">Current Profile Picture</h3>
                    <div class="w-32 h-32 mx-auto rounded-full overflow-hidden bg-gray-200 border-4 border-white shadow-lg">
                        <?php if(!empty($result->ProfilePic) && file_exists("images/" . $result->ProfilePic)): ?>
                            <img src="images/<?php echo htmlentities($result->ProfilePic); ?>" alt="Profile" class="w-full h-full object-cover">
                        <?php else: ?>
                            <img src="images/account.png" alt="Default" class="w-full h-full object-cover">
                        <?php endif; ?>
                    </div>
                    
                    <?php if(!empty($result->ProfilePic)): ?>
                        <?php if(file_exists("images/" . $result->ProfilePic)): ?>
                            <p class="text-sm text-green-600 mt-3">
                                <i class="fas fa-check-circle mr-1"></i>Profile picture active
                            </p>
                        <?php else: ?>
                            <p class="text-sm text-red-600 mt-3">
                                <i class="fas fa-exclamation-triangle mr-1"></i>Picture file not found on server
                            </p>
                        <?php endif; ?>
                    <?php else: ?>
                        <p class="text-sm text-gray-500 mt-3">Using default profile picture</p>
                    <?php endif; ?>
                </div>

                <!-- Upload Form -->
                <form method="post" enctype="multipart/form-data">
                    <div class="mb-6">
                        <label class="block text-sm font-semibold text-gray-700 mb-3">
                            <i class="fas fa-upload text-primary mr-2"></i>
                            Upload New Profile Picture
                        </label>
                        <div class="border-2 border-dashed border-gray-300 rounded-xl p-8 text-center hover:border-primary transition-colors">
                            <div class="mb-4">
                                <i class="fas fa-camera text-4xl text-gray-400 mb-2"></i>
                                <p class="text-lg font-medium text-gray-700 mb-2">Choose Profile Photo</p>
                                <p class="text-sm text-gray-500">JPG, JPEG, PNG, or GIF images only</p>
                            </div>
                            <input type="file" name="image" required onchange="previewImage(event)"
                                   class="w-full text-sm text-gray-500 file:mr-4 file:py-3 file:px-6 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-primary file:text-white hover:file:bg-primary-dark transition-colors">
                            <p class="text-xs text-gray-500 mt-3">Maximum file size: 2MB</p>
                        </div>
                    </div>

                    <!-- Image Preview -->
                    <div id="preview-container" class="hidden mb-6">
                        <h4 class="text-sm font-semibold text-gray-700 mb-3">Preview</h4>
                        <div class="text-center">
                            <div class="w-24 h-24 mx-auto rounded-full overflow-hidden bg-gray-200 border-2 border-primary">
                                <img id="preview-image" alt="Preview" class="w-full h-full object-cover">
                            </div>
                            <p class="text-sm text-gray-600 mt-2">New profile picture preview</p>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex flex-col sm:flex-row gap-4 pt-6 border-t border-gray-200">
                        <button type="submit" name="update"
                                class="flex-1 bg-primary text-white py-4 px-8 rounded-xl font-semibold hover:bg-primary-dark transition-colors flex items-center justify-center space-x-2">
                            <i class="fas fa-camera"></i>
                            <span>Update Picture</span>
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
                    <h3 class="text-lg font-semibold text-blue-900 mb-2">Profile Picture Tips</h3>
                    <ul class="text-blue-800 space-y-1">
                        <li class="flex items-center space-x-2">
                            <i class="fas fa-check text-blue-600 text-sm"></i>
                            <span>Use a high-quality photo with good lighting</span>
                        </li>
                        <li class="flex items-center space-x-2">
                            <i class="fas fa-check text-blue-600 text-sm"></i>
                            <span>Ensure your face is clearly visible and centered</span>
                        </li>
                        <li class="flex items-center space-x-2">
                            <i class="fas fa-check text-blue-600 text-sm"></i>
                            <span>Wear professional attire appropriate for your field</span>
                        </li>
                        <li class="flex items-center space-x-2">
                            <i class="fas fa-check text-blue-600 text-sm"></i>
                            <span>Keep the background simple and uncluttered</span>
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