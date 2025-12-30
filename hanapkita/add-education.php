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
    $quali=trim($_POST['qualification']);  
    $sorcname=trim($_POST['schorclgname']); 
    $yop=trim($_POST['yop']);  
    $stream=trim($_POST['stream']); 
    $per=trim($_POST['percentage']);  
    $cgpa=trim($_POST['cgpa']);
    //Getting User Id
    $uid=$_SESSION['jsid'];

    // Validate required fields
    if(empty($quali) || empty($sorcname) || empty($cgpa)) {
        $error = "Please fill in all required fields.";
    } else {
        // Check if qualification already exists
        $ret="select Qualification from tbleducation where Qualification=:quali and UserID=:uid";
        $query= $dbh -> prepare($ret);
        $query-> bindParam(':quali', $quali, PDO::PARAM_STR);
        $query-> bindParam(':uid', $uid, PDO::PARAM_STR);
        $query-> execute();
        $results = $query -> fetchAll(PDO::FETCH_OBJ);
        
        if($query->rowCount() > 0)
        {
            $error = "Qualification details already exist. Please try again";
        } else {
            // Handle percentage field - convert to numeric or set to 0 if not numeric
            $percentage_numeric = 0;
            if(!empty($per) && is_numeric($per)) {
                $percentage_numeric = floatval($per);
            }
            
            // Handle CGPA - ensure it's numeric
            $cgpa_numeric = 0;
            if(!empty($cgpa) && is_numeric($cgpa)) {
                $cgpa_numeric = floatval($cgpa);
            } else {
                $error = "GPA must be a numeric value (e.g., 3.5)";
            }
            
            if(empty($error)) {
                // Insert new education record
                $sql="INSERT INTO tbleducation(UserID,Qualification,ClgorschName,PassingYear,Stream,CGPA,Percentage) VALUES(:uid,:quali,:sorcname,:yop,:stream,:cgpa,:per)";
                $query = $dbh->prepare($sql);
                
                // Binding Post Values
                $query->bindParam(':quali', $quali, PDO::PARAM_STR);
                $query->bindParam(':uid', $uid, PDO::PARAM_STR);
                $query->bindParam(':sorcname', $sorcname, PDO::PARAM_STR);
                $query->bindParam(':yop', $yop, PDO::PARAM_STR);
                $query->bindParam(':stream', $stream, PDO::PARAM_STR);
                $query->bindParam(':per', $percentage_numeric, PDO::PARAM_STR);
                $query->bindParam(':cgpa', $cgpa_numeric, PDO::PARAM_STR);
                
                if($query->execute()) {
                    $LastInsertId = $dbh->lastInsertId();
                    if ($LastInsertId > 0) {
                        $msg = "Education details have been added successfully.";
                        echo "<script>setTimeout(function(){ window.location.href ='my-profile.php'; }, 2000);</script>";
                    } else {
                        $error = "Failed to insert record. Please try again.";
                    }
                } else {
                    $error = "Database execution failed. Please try again.";
                }
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
    <title>Add Education Details - Hanap-Kita</title>
    
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
            const qualification = document.querySelector('select[name="qualification"]').value;
            const schoolName = document.querySelector('input[name="schorclgname"]').value;
            const cgpa = document.querySelector('input[name="cgpa"]').value;
            
            if (!qualification || !schoolName || !cgpa) {
                alert('Please fill in all required fields.');
                return false;
            }
            
            // Validate CGPA is numeric
            if (isNaN(cgpa) || cgpa < 0 || cgpa > 5) {
                alert('Please enter a valid GPA (0.0 - 5.0)');
                return false;
            }
            
            // Validate percentage if provided
            const percentage = document.querySelector('input[name="percentage"]').value;
            if (percentage && (isNaN(percentage) || percentage < 0 || percentage > 100)) {
                alert('Please enter a valid percentage (0-100)');
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
                <span class="text-gray-900 font-medium">Add Education</span>
            </nav>
        </div>
    </div>

    <!-- Main Content -->
    <main class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <!-- Page Header -->
        <div class="text-center mb-12">
            <div class="w-16 h-16 bg-primary/10 rounded-2xl flex items-center justify-center mx-auto mb-6">
                <i class="fas fa-graduation-cap text-primary text-2xl"></i>
            </div>
            <h1 class="text-4xl font-bold text-gray-900 mb-4">Add Education Details</h1>
            <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                Share your educational background to help employers understand your qualifications
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

        <!-- Education Form -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="bg-gradient-to-r from-primary to-primary-light p-6 text-white">
                <h2 class="text-2xl font-bold">Educational Information</h2>
                <p class="text-primary-light mt-2">Please fill in your educational details accurately</p>
            </div>
            
            <form method="post" class="p-8" onsubmit="return validateForm()">
                <div class="grid md:grid-cols-2 gap-8">
                    <!-- Qualification -->
                    <div class="md:col-span-2">
                        <label class="block text-sm font-semibold text-gray-700 mb-3">
                            <i class="fas fa-certificate text-primary mr-2"></i>
                            Qualification <span class="text-red-500">*</span>
                        </label>
                        <select name="qualification" required class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-colors">
                            <option value="">Select Level of Education</option>
                            <option value="Elementary">Elementary</option>
                            <option value="High School Graduate">High School Graduate</option>
                            <option value="Senior High School Graduate">Senior High School Graduate</option>
                            <option value="College Graduate">College Graduate</option>
                            <option value="Others">Others</option>
                        </select>
                    </div>

                    <!-- School/College Name -->
                    <div class="md:col-span-2">
                        <label class="block text-sm font-semibold text-gray-700 mb-3">
                            <i class="fas fa-school text-primary mr-2"></i>
                            School/College Name <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="schorclgname" required 
                               placeholder="Enter the name of your school or college"
                               class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-colors">
                    </div>

                    <!-- Year Graduated -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-3">
                            <i class="fas fa-calendar text-primary mr-2"></i>
                            Year Graduated
                        </label>
                        <input type="text" name="yop" required 
                               placeholder="e.g. 2023"
                               pattern="[0-9]+" maxlength="4"
                               class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-colors">
                    </div>

                    <!-- Course -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-3">
                            <i class="fas fa-book text-primary mr-2"></i>
                            Course/Program
                        </label>
                        <input type="text" name="stream" 
                               placeholder="e.g. Computer Science, STEM, etc."
                               class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-colors">
                    </div>

                    <!-- Honors/Awards -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-3">
                            <i class="fas fa-percentage text-primary mr-2"></i>
                            Percentage/Grade
                        </label>
                        <input type="number" name="percentage" step="0.01" min="0" max="100"
                               placeholder="e.g. 85.5 (optional)"
                               class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-colors">
                        <p class="text-xs text-gray-500 mt-1">Enter your percentage or grade if applicable</p>
                    </div>

                    <!-- GPA -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-3">
                            <i class="fas fa-chart-line text-primary mr-2"></i>
                            GPA <span class="text-red-500">*</span>
                        </label>
                        <input type="number" name="cgpa" required step="0.01" min="0" max="5"
                               placeholder="e.g. 3.5"
                               class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-colors">
                        <p class="text-xs text-gray-500 mt-1">Enter your GPA on a scale (e.g., 4.0 scale)</p>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex flex-col sm:flex-row gap-4 mt-12 pt-8 border-t border-gray-200">
                    <button type="submit" name="submit" 
                            class="flex-1 bg-primary text-white py-4 px-8 rounded-xl font-semibold hover:bg-primary-dark transition-colors flex items-center justify-center space-x-2">
                        <i class="fas fa-plus"></i>
                        <span>Add Education Details</span>
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
                    <h3 class="text-lg font-semibold text-blue-900 mb-2">Tips for Adding Education</h3>
                    <ul class="text-blue-800 space-y-1">
                        <li class="flex items-center space-x-2">
                            <i class="fas fa-check text-blue-600 text-sm"></i>
                            <span>Include your highest level of education completed</span>
                        </li>
                        <li class="flex items-center space-x-2">
                            <i class="fas fa-check text-blue-600 text-sm"></i>
                            <span>Be accurate with graduation years and school names</span>
                        </li>
                        <li class="flex items-center space-x-2">
                            <i class="fas fa-check text-blue-600 text-sm"></i>
                            <span>Enter GPA and percentage as numeric values only</span>
                        </li>
                        <li class="flex items-center space-x-2">
                            <i class="fas fa-check text-blue-600 text-sm"></i>
                            <span>Percentage field is optional - leave blank if not applicable</span>
                        </li>
                        <li class="flex items-center space-x-2">
                            <i class="fas fa-check text-blue-600 text-sm"></i>
                            <span>You can add multiple education entries for different qualifications</span>
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