<?php
session_start();
//Database Configuration File
include('includes/config.php');
//error_reporting(0);
//verifying Session
if(strlen($_SESSION['jsid'])==0)
  { 
header('location:logout.php');
}
else{ ?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlentities($_SESSION['jsfname']);?>'s Profile | Hanap-Kita</title>
    
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
                    <a href="applied-jobs.php" class="text-gray-700 hover:text-primary font-medium transition-colors">Applied Jobs</a>
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
                            <span class="font-medium"><?php echo htmlentities($_SESSION['jsfname']);?></span>
                            <i class="fas fa-chevron-down text-xs"></i>
                        </button>
                        <div class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg border border-gray-200 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all">
                            <a href="my-profile.php" class="block px-4 py-2 text-primary font-medium bg-blue-50 rounded-t-lg">My Profile</a>
                            <a href="change-password.php" class="block px-4 py-2 text-gray-700 hover:bg-gray-50">Change Password</a>
                            <a href="profile.php" class="block px-4 py-2 text-gray-700 hover:bg-gray-50">Edit Profile</a>
                            <a href="logout.php" class="block px-4 py-2 text-gray-700 hover:bg-gray-50 rounded-b-lg">Log Out</a>
                        </div>
                        <?php $cnt=$cnt+1;}} ?>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Page Header -->
    <div class="bg-gradient-to-r from-primary to-primary-light py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="text-3xl font-bold text-white"><?php echo htmlentities($_SESSION['jsfname']);?>'s Profile</h1>
            <p class="text-blue-100 mt-2">Manage your profile and track your job applications</p>
        </div>
    </div>

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="grid lg:grid-cols-3 gap-8">
            
            <!-- Left Column - Profile Card -->
            <div class="lg:col-span-1">
                <?php
                //Getting User Id
                $jsid=$_SESSION['jsid'];
                // Fetching User Details
                $sql = "SELECT * from  tbljobseekers  where id=:jid";
                $query = $dbh -> prepare($sql);
                $query-> bindParam(':jid', $jsid, PDO::PARAM_STR);
                $query->execute();
                $results=$query->fetchAll(PDO::FETCH_OBJ);
                foreach($results as $result) {
                ?>
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
                    <!-- Profile Header -->
                    <div class="bg-gradient-to-r from-primary to-primary-light p-6 text-center">
                        <div class="w-24 h-24 mx-auto mb-4 rounded-full border-4 border-white overflow-hidden bg-white">
                            <?php if($result->ProfilePic==''): ?>
                                <img src="images/account.png" class="w-full h-full object-cover">
                            <?php else: ?>
                                <img src="images/<?php echo $result->ProfilePic;?>" class="w-full h-full object-cover">
                            <?php endif;?>
                        </div>
                        <h2 class="text-xl font-bold text-white"><?php echo htmlentities($_SESSION['jsfname']);?></h2>
                        <p class="text-blue-100 text-sm">Job Seeker</p>
                    </div>
                    
                    <!-- Profile Info -->
                    <div class="p-6">
                        <div class="space-y-4">
                            <div class="flex items-center text-gray-600">
                                <i class="fas fa-envelope w-5 mr-3"></i>
                                <span class="text-sm"><?php echo htmlentities($result->EmailId);?></span>
                            </div>
                            <div class="flex items-center text-gray-600">
                                <i class="fas fa-phone w-5 mr-3"></i>
                                <span class="text-sm"><?php echo htmlentities($result->ContactNumber);?></span>
                            </div>
                            <div class="flex items-center text-gray-600">
                                <i class="fas fa-calendar w-5 mr-3"></i>
                                <span class="text-sm">Joined <?php echo date('M Y', strtotime($result->RegDate));?></span>
                            </div>
                        </div>
                        
                        <!-- Action Buttons -->
                        <div class="mt-6 space-y-3">
                            <a href="Jobseekersresumes/<?php echo htmlentities($result->Resume);?>" target="_blank" 
                               class="w-full bg-primary text-white px-4 py-2 rounded-lg hover:bg-primary-dark transition-colors flex items-center justify-center">
                                <i class="fas fa-file-pdf mr-2"></i>View Resume
                            </a>
                            <a href="profile.php" 
                               class="w-full bg-gray-100 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-200 transition-colors flex items-center justify-center">
                                <i class="fas fa-edit mr-2"></i>Edit Profile
                            </a>
                            <a href="add-education.php" 
                               class="w-full bg-green-100 text-green-700 px-4 py-2 rounded-lg hover:bg-green-200 transition-colors flex items-center justify-center">
                                <i class="fas fa-plus mr-2"></i>Add Education
                            </a>
                            <a href="add-experience.php" 
                               class="w-full bg-blue-100 text-blue-700 px-4 py-2 rounded-lg hover:bg-blue-200 transition-colors flex items-center justify-center">
                                <i class="fas fa-plus mr-2"></i>Add Experience
                            </a>
                        </div>
                    </div>
                </div>
                <?php } ?>
            </div>
            
            <!-- Right Column - Details -->
            <div class="lg:col-span-2 space-y-8">
                
                <!-- About Me Section -->
                <?php
                $sql = "SELECT * from  tbljobseekers  where id=:jid";
                $query = $dbh -> prepare($sql);
                $query-> bindParam(':jid', $jsid, PDO::PARAM_STR);
                $query->execute();
                $results=$query->fetchAll(PDO::FETCH_OBJ);
                foreach($results as $result) {
                ?>
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
                    <h3 class="text-xl font-semibold text-gray-900 mb-4 flex items-center">
                        <i class="fas fa-user mr-3 text-primary"></i>About Me
                    </h3>
                    <p class="text-gray-600 leading-relaxed">
                        <?php echo htmlentities($result->AboutMe) ?: 'No information provided yet.'; ?>
                    </p>
                </div>
                <?php } ?>
                
                <!-- Education Section -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
                    <h3 class="text-xl font-semibold text-gray-900 mb-6 flex items-center">
                        <i class="fas fa-graduation-cap mr-3 text-primary"></i>Education
                    </h3>
                    
                    <?php
                    //Getting User Id
                    $uid=$_SESSION['jsid'];
                    // Fetching User Education Details
                    $sql = "SELECT * from  tbleducation  where UserID=:uid ORDER BY PassingYear DESC";
                    $query = $dbh -> prepare($sql);
                    $query-> bindParam(':uid', $uid, PDO::PARAM_STR);
                    $query->execute();
                    $results=$query->fetchAll(PDO::FETCH_OBJ);
                    
                    if($query->rowCount() > 0) {
                        foreach($results as $result) {
                    ?>
                    <div class="border-l-4 border-primary pl-6 pb-6 mb-6 last:mb-0 relative">
                        <div class="absolute -left-2 top-0 w-4 h-4 bg-primary rounded-full"></div>
                        <h4 class="font-semibold text-gray-900 text-lg"><?php echo htmlentities($result->Qualification);?></h4>
                        <p class="text-primary font-medium mb-2"><?php echo htmlentities($result->ClgorschName);?></p>
                        <div class="text-sm text-gray-600 space-y-1">
                            <p><span class="font-medium">Year:</span> <?php echo htmlentities($result->PassingYear);?></p>
                            <?php if($result->Stream): ?>
                            <p><span class="font-medium">Course:</span> <?php echo htmlentities($result->Stream);?></p>
                            <?php endif; ?>
                            <?php if($result->CGPA && $result->CGPA != '0'): ?>
                            <p><span class="font-medium">GPA:</span> <?php echo htmlentities($result->CGPA);?></p>
                            <?php endif; ?>
                            <?php if($result->Percentage && $result->Percentage != '0'): ?>
                            <p><span class="font-medium">Percentage:</span> <?php echo htmlentities($result->Percentage);?>%</p>
                            <?php endif; ?>
                        </div>
                    </div>
                    <?php }
                    } else { ?>
                    <div class="text-center py-8">
                        <i class="fas fa-graduation-cap text-gray-300 text-4xl mb-4"></i>
                        <p class="text-gray-500 mb-4">No education details added yet</p>
                        <a href="add-education.php" class="bg-primary text-white px-4 py-2 rounded-lg hover:bg-primary-dark transition-colors">
                            <i class="fas fa-plus mr-2"></i>Add Education
                        </a>
                    </div>
                    <?php } ?>
                </div>
                
                <!-- Experience Section -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
                    <h3 class="text-xl font-semibold text-gray-900 mb-6 flex items-center">
                        <i class="fas fa-briefcase mr-3 text-primary"></i>Work Experience
                    </h3>
                    
                    <?php
                    //Getting User Id
                    $uid=$_SESSION['jsid'];
                    // Fetching User Experience Details
                    $sql = "SELECT * from  tblexperience  where UserID=:uid ORDER BY FromDate DESC";
                    $query = $dbh -> prepare($sql);
                    $query-> bindParam(':uid', $uid, PDO::PARAM_STR);
                    $query->execute();
                    $results=$query->fetchAll(PDO::FETCH_OBJ);
                    
                    if($query->rowCount() > 0) {
                        foreach($results as $result) {
                    ?>
                    <div class="border-l-4 border-green-500 pl-6 pb-6 mb-6 last:mb-0 relative">
                        <div class="absolute -left-2 top-0 w-4 h-4 bg-green-500 rounded-full"></div>
                        <h4 class="font-semibold text-gray-900 text-lg"><?php echo htmlentities($result->Designation);?></h4>
                        <p class="text-green-600 font-medium mb-2"><?php echo htmlentities($result->EmployerName);?></p>
                        <div class="text-sm text-gray-600 space-y-1">
                            <p><span class="font-medium">Duration:</span> <?php echo htmlentities($result->FromDate);?> - <?php echo htmlentities($result->ToDate);?></p>
                            <p><span class="font-medium">Employment Type:</span> <?php echo htmlentities($result->EmployementType);?></p>
                            <?php if($result->Ctc && $result->Ctc != '0'): ?>
                            <p><span class="font-medium">Salary:</span> ₱<?php echo htmlentities($result->Ctc);?> per month</p>
                            <?php endif; ?>
                        </div>
                    </div>
                    <?php }
                    } else { ?>
                    <div class="text-center py-8">
                        <i class="fas fa-briefcase text-gray-300 text-4xl mb-4"></i>
                        <p class="text-gray-500 mb-4">No work experience added yet</p>
                        <a href="add-experience.php" class="bg-primary text-white px-4 py-2 rounded-lg hover:bg-primary-dark transition-colors">
                            <i class="fas fa-plus mr-2"></i>Add Experience
                        </a>
                    </div>
                    <?php } ?>
                </div>
                
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h3 class="text-2xl font-bold text-primary mb-4">Hanap-Kita</h3>
                <p class="text-gray-400">&copy; 2024 Hanap-Kita. All rights reserved.</p>
            </div>
        </div>
    </footer>

</body>
</html>
<?php } ?>