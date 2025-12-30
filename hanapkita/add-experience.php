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

if(isset($_POST['submit']))
{
try {
    //Getting Post Values
    $employername = trim($_POST['employername']);  
    $toe = trim($_POST['toe']); 
    $desi = trim($_POST['designation']);  
    $ctc = trim($_POST['ctc']); 
    $fdate = trim($_POST['fdate']);  
    $tdate = trim($_POST['tdate']);
    $skills = trim($_POST['skills']);
    
    //Getting User Id
    $uid = $_SESSION['jsid'];
    
    // Validate required fields
    if(empty($employername) || empty($toe) || empty($desi)) {
        $error = "Please fill in all required fields.";
    } else {
        // Validate CTC is numeric if provided
        if(!empty($ctc) && !is_numeric($ctc)) {
            $error = "CTC must be a numeric value.";
        } else {
            // Convert CTC to decimal or set to 0 if empty
            $ctc_numeric = empty($ctc) ? 0 : floatval($ctc);
            
            $sql="INSERT INTO tblexperience(UserID,EmployerName,EmployementType,Designation,Ctc,FromDate,ToDate,Skills) VALUES(:uid,:employername,:toe,:desi,:ctc,:fdate,:tdate,:skills)";
            $query = $dbh->prepare($sql);
            
            // Binding Post Values
            $query->bindParam(':employername', $employername, PDO::PARAM_STR);
            $query->bindParam(':uid', $uid, PDO::PARAM_STR);
            $query->bindParam(':toe', $toe, PDO::PARAM_STR);
            $query->bindParam(':desi', $desi, PDO::PARAM_STR);
            $query->bindParam(':ctc', $ctc_numeric, PDO::PARAM_STR);
            $query->bindParam(':fdate', $fdate, PDO::PARAM_STR);
            $query->bindParam(':tdate', $tdate, PDO::PARAM_STR);
            $query->bindParam(':skills', $skills, PDO::PARAM_STR);

            if($query->execute()) {
                $LastInsertId = $dbh->lastInsertId();
                if ($LastInsertId > 0) {
                    $msg = "Experience details have been added successfully.";
                    echo "<script>setTimeout(function(){ window.location.href ='my-profile.php'; }, 2000);</script>";
                } else {
                    $error = "Failed to insert record. Please try again.";
                }
            } else {
                $error = "Database execution failed. Please try again.";
            }
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
    <title>Add Experience Details - Hanap-Kita</title>
    
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
            const employerName = document.querySelector('input[name="employername"]').value;
            const empType = document.querySelector('input[name="toe"]').value;
            const designation = document.querySelector('input[name="designation"]').value;
            
            if (!employerName || !empType || !designation) {
                alert('Please fill in all required fields.');
                return false;
            }
            
            // Validate CTC if provided
            const ctc = document.querySelector('input[name="ctc"]').value;
            if (ctc && (isNaN(ctc) || ctc < 0)) {
                alert('Please enter a valid CTC amount');
                return false;
            }
            
            // Validate dates if provided
            const fromDate = document.querySelector('input[name="fdate"]').value;
            const toDate = document.querySelector('input[name="tdate"]').value;
            
            if (fromDate && toDate && new Date(fromDate) > new Date(toDate)) {
                alert('From date cannot be later than To date');
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
                    <a href="my-profile.php" class="text-primary font-medium border-b-2 border-primary pb-1">My Profile</a>
                    <a href="applied-jobs.php" class="text-gray-700 hover:text-primary font-medium transition-colors">Applied Jobs</a>
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
                <span class="text-gray-900 font-medium">Add Experience</span>
            </nav>
        </div>
    </div>

    <!-- Main Content -->
    <main class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <!-- Page Header -->
        <div class="text-center mb-12">
            <div class="w-16 h-16 bg-primary/10 rounded-2xl flex items-center justify-center mx-auto mb-6">
                <i class="fas fa-briefcase text-primary text-2xl"></i>
            </div>
            <h1 class="text-4xl font-bold text-gray-900 mb-4">Add Work Experience</h1>
            <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                Share your professional experience to showcase your skills and career progression
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

        <!-- Experience Form -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="bg-gradient-to-r from-primary to-primary-light p-6 text-white">
                <h2 class="text-2xl font-bold">Professional Experience</h2>
                <p class="text-primary-light mt-2">Please provide details about your work experience</p>
            </div>
            
            <form method="post" class="p-8" onsubmit="return validateForm()">
                <div class="grid md:grid-cols-2 gap-8">
                    <!-- Employer Name -->
                    <div class="md:col-span-2">
                        <label class="block text-sm font-semibold text-gray-700 mb-3">
                            <i class="fas fa-building text-primary mr-2"></i>
                            Employer Name <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="employername" required
                               placeholder="Name of Employer" 
                               autocomplete="off"
                               class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-colors">
                    </div>

                    <!-- Type of Employment -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-3">
                            <i class="fas fa-clock text-primary mr-2"></i>
                            Type of Employment <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="toe" required
                               placeholder="e.g. Full Time, Part Time, Contract"
                               autocomplete="off"
                               class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-colors">
                    </div>

                    <!-- Designation -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-3">
                            <i class="fas fa-user-tie text-primary mr-2"></i>
                            Designation <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="designation" required
                               placeholder="Enter Job Title/Position"
                               autocomplete="off"
                               class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-colors">
                    </div>

                    <!-- CTC -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-3">
                            <i class="fas fa-peso-sign text-primary mr-2"></i>
                            CTC (per month)
                        </label>
                        <input type="number" name="ctc" step="0.01" min="0"
                               placeholder="Enter monthly salary"
                               autocomplete="off"
                               class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-colors">
                        <p class="text-xs text-gray-500 mt-1">Optional - Enter amount in Philippine Peso</p>
                    </div>

                    <!-- From Date -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-3">
                            <i class="fas fa-calendar-plus text-primary mr-2"></i>
                            From Date
                        </label>
                        <input type="date" name="fdate"
                               autocomplete="off"
                               class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-colors">
                    </div>

                    <!-- To Date -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-3">
                            <i class="fas fa-calendar-minus text-primary mr-2"></i>
                            To Date
                        </label>
                        <input type="date" name="tdate"
                               autocomplete="off"
                               class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-colors">
                        <p class="text-xs text-gray-500 mt-1">Leave blank if this is your current position</p>
                    </div>

                    <!-- Skills -->
                    <div class="md:col-span-2">
                        <label class="block text-sm font-semibold text-gray-700 mb-3">
                            <i class="fas fa-tools text-primary mr-2"></i>
                            Skills & Technologies
                        </label>
                        <textarea name="skills" rows="3"
                                  placeholder="e.g. Project Management, Customer Service, Microsoft Office, etc."
                                  class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-colors resize-none"></textarea>
                        <p class="text-xs text-gray-500 mt-1">List the key skills you used or developed in this role</p>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex flex-col sm:flex-row gap-4 mt-12 pt-8 border-t border-gray-200">
                    <button type="submit" name="submit" 
                            class="flex-1 bg-primary text-white py-4 px-8 rounded-xl font-semibold hover:bg-primary-dark transition-colors flex items-center justify-center space-x-2">
                        <i class="fas fa-plus"></i>
                        <span>Add Experience</span>
                    </button>
                    <a href="my-profile.php" 
                       class="flex-1 bg-gray-100 text-gray-700 py-4 px-8 rounded-xl font-semibold hover:bg-gray-200 transition-colors flex items-center justify-center space-x-2">
                        <i class="fas fa-arrow-left"></i>
                        <span>Back to Profile</span>
                    </a>
                </div>
            </form>
        </div>

        <!-- Help Section -->
        <div class="mt-12 bg-blue-50 rounded-2xl p-8">
            <div class="flex items-start space-x-4">
                <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center flex-shrink-0">
                    <i class="fas fa-info-circle text-blue-600"></i>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-blue-900 mb-2">Tips for Adding Experience</h3>
                    <ul class="text-blue-800 space-y-1">
                        <li class="flex items-center space-x-2">
                            <i class="fas fa-check text-blue-600 text-sm"></i>
                            <span>Include all relevant work experience, including part-time jobs</span>
                        </li>
                        <li class="flex items-center space-x-2">
                            <i class="fas fa-check text-blue-600 text-sm"></i>
                            <span>Be accurate with company names and job titles</span>
                        </li>
                        <li class="flex items-center space-x-2">
                            <i class="fas fa-check text-blue-600 text-sm"></i>
                            <span>List key skills and technologies you used or learned</span>
                        </li>
                        <li class="flex items-center space-x-2">
                            <i class="fas fa-check text-blue-600 text-sm"></i>
                            <span>You can add multiple experience entries for different positions</span>
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