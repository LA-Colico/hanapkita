<?php
session_start();
//Database Configuration File
include('includes/config.php');
error_reporting(0);
//verifying Session
if(strlen($_SESSION['emplogin'])==0)
  { 
header('location:emp-login.php');
}
else{

//Genrating CSRF Token
if (empty($_SESSION['token'])) {
    $_SESSION['token'] = bin2hex(random_bytes(32));
}

if(isset($_POST['submit']))
{

//Verifying CSRF Token
if (!empty($_POST['csrftoken'])) {
if (hash_equals($_SESSION['token'], $_POST['csrftoken'])) {

$empid=$_SESSION['emplogin'];  
//Getting Post Values
$category=$_POST['category'];  
$jontitle=$_POST['jobtitle']; 
$jobtype=$_POST['jobtype']; 
$salpackg=$_POST['salarypackage'];
$skills=$_POST['skills'];
$exprnce=$_POST['experience'];
$joblocation=$_POST['joblocation'];
$jobdesc=$_POST['description'];
$jed=$_POST['jed'];
$isactive=1;



$sql="INSERT INTO tbljobs(employerId,jobCategory,jobTitle,jobType,salaryPackage,skillsRequired,experience,jobLocation,jobDescription,JobExpdate,isActive) VALUES(:empid,:category,:jontitle,:jobtype,:salpackg,:skills,:exprnce,:joblocation,:jobdesc,:jed,:isactive)";
$query = $dbh->prepare($sql);
// Binding Post Values
$query->bindParam(':empid',$empid,PDO::PARAM_STR);
$query->bindParam(':category',$category,PDO::PARAM_STR);
$query->bindParam(':jontitle',$jontitle,PDO::PARAM_STR);
$query->bindParam(':jobtype',$jobtype,PDO::PARAM_STR);
$query->bindParam(':salpackg',$salpackg,PDO::PARAM_STR);
$query->bindParam(':skills',$skills,PDO::PARAM_STR);
$query->bindParam(':exprnce',$exprnce,PDO::PARAM_STR);
$query->bindParam(':joblocation',$joblocation,PDO::PARAM_STR);
$query->bindParam(':jobdesc',$jobdesc,PDO::PARAM_STR);
$query->bindParam(':jed',$jed,PDO::PARAM_STR);
$query->bindParam(':isactive',$isactive,PDO::PARAM_STR);
$query->execute();
$lastInsertId = $dbh->lastInsertId();
if($lastInsertId)
{
$msg="Your job posted Successfully";
unset( $_SESSION['token']);
}
else 
{
$error="Something went wrong.Please try again";
}


}}}

?>

<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Employers | Post a Job</title>
  
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
  
  <!-- Custom editor styles -->
  <link href="../css/editor.css" type="text/css" rel="stylesheet"/>
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
          <a href="job-listing.php" class="text-primary font-medium transition-colors">Jobs</a>
          <a href="candidates-listings.php" class="text-gray-700 hover:text-primary font-medium transition-colors">Candidates</a>
          <a href="candidates-reports.php" class="text-gray-700 hover:text-primary font-medium transition-colors">Reports</a>
        </nav>
        
        <!-- Auth Buttons -->
        <div class="flex items-center space-x-4">
          <div class="relative group">
            <button class="flex items-center space-x-2 text-gray-700 hover:text-primary transition-colors">
              <i class="fas fa-user-circle text-xl"></i>
              <span>My Account</span>
              <i class="fas fa-chevron-down text-xs"></i>
            </button>
            <div class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg border border-gray-200 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all">
              <a href="edit-profile.php" class="block px-4 py-2 text-gray-700 hover:bg-gray-50 rounded-t-lg">Edit Profile</a>
              <a href="change-password.php" class="block px-4 py-2 text-gray-700 hover:bg-gray-50">Change Password</a>
              <a href="logout.php" class="block px-4 py-2 text-gray-700 hover:bg-gray-50 rounded-b-lg">Logout</a>
            </div>
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

  <!-- Main Content -->
  <div class="py-12 bg-gray-50">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
      <!-- Page Title -->
      <div class="mb-10 text-center">
        <h1 class="text-3xl font-bold text-gray-900">Post a New Job</h1>
        <p class="mt-2 text-lg text-gray-600">Fill out the form below to create a job listing</p>
      </div>
      
      <!-- Success and Error Messages -->
      <?php if(@$error){ ?>
        <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4 rounded-md">
          <div class="flex">
            <div class="flex-shrink-0">
              <i class="fas fa-times-circle text-red-500"></i>
            </div>
            <div class="ml-3">
              <p class="text-sm text-red-700"><strong>Error:</strong> <?php echo htmlentities($error);?></p>
            </div>
          </div>
        </div>
      <?php } ?>

      <?php if(@$msg){ ?>
        <div class="mb-6 bg-green-50 border-l-4 border-green-500 p-4 rounded-md">
          <div class="flex">
            <div class="flex-shrink-0">
              <i class="fas fa-check-circle text-green-500"></i>
            </div>
            <div class="ml-3">
              <p class="text-sm text-green-700"><strong>Success:</strong> <?php echo htmlentities($msg);?></p>
            </div>
          </div>
        </div>
      <?php } ?>
      
      <!-- Job Post Form -->
      <div class="bg-white rounded-xl shadow-sm overflow-hidden">
        <div class="border-b border-gray-100 bg-gradient-to-r from-primary-light to-primary px-6 py-4">
          <h2 class="text-xl font-semibold text-white">Job Details</h2>
        </div>
        
        <div class="p-6">
          <form name="empsignup" enctype="multipart/form-data" method="post">
            <input type="hidden" name="csrftoken" value="<?php echo htmlentities($_SESSION['token']); ?>" />
            
            <div class="grid md:grid-cols-2 gap-6 mb-6">
              <!-- Category -->
              <div>
                <label for="category" class="block text-sm font-medium text-gray-700 mb-2">Category*</label>
                <select id="category" name="category" required class="block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-primary focus:border-primary sm:text-sm rounded-md">
                  <option value="">Select</option>
                  <?php 
                  $sqlt = "SELECT CategoryName FROM tblcategory order by CategoryName asc";
                  $queryt = $dbh -> prepare($sqlt);
                  $queryt -> execute();
                  $results = $queryt -> fetchAll(PDO::FETCH_OBJ);
                  $cnt=1;
                  if($queryt -> rowCount() > 0)
                  {
                  foreach($results as $result)
                  {?>
                  <option value="<?php echo htmlentities($result->CategoryName);?>"><?php echo htmlentities($result->CategoryName);?></option>
                  <?php }} ?>
                </select>
              </div>
              
              <!-- Job Title -->
              <div>
                <label for="jobtitle" class="block text-sm font-medium text-gray-700 mb-2">Job Title*</label>
                <input type="text" id="jobtitle" name="jobtitle" required placeholder="e.g. Barangay Tanod" autocomplete="off" class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary sm:text-sm">
              </div>
            </div>
            
            <div class="grid md:grid-cols-2 gap-6 mb-6">
              <!-- Job Type -->
              <div>
                <label for="jobtype" class="block text-sm font-medium text-gray-700 mb-2">Job Type</label>
                <select id="jobtype" name="jobtype" class="block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-primary focus:border-primary sm:text-sm rounded-md">
                  <option value="Full Time">Full Time</option>
                  <option value="Part Time">Part Time</option>
                  <option value="Half Time">Half Time</option>
                  <option value="Freelance">Freelance</option>
                  <option value="Contract">Contract</option>
                  <option value="Internship">Internship</option>
                  <option value="Temporary">Temporary</option>
                </select>
              </div>
              
              <!-- Salary Package -->
              <div>
                <label for="salarypackage" class="block text-sm font-medium text-gray-700 mb-2">Salary Package</label>
                <input type="text" id="salarypackage" name="salarypackage" required placeholder="e.g. ₱12,000 - 15,000" class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary sm:text-sm">
              </div>
            </div>
            
            <div class="grid md:grid-cols-2 gap-6 mb-6">
              <!-- Skills Required -->
              <div>
                <label for="skills" class="block text-sm font-medium text-gray-700 mb-2">Skills Required</label>
                <input type="text" id="skills" name="skills" required placeholder="e.g. Basic Security and Patrolling Skills" class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary sm:text-sm">
              </div>
              
              <!-- Experience -->
              <div>
                <label for="experience" class="block text-sm font-medium text-gray-700 mb-2">Experience</label>
                <input type="text" id="experience" name="experience" required placeholder="e.g. 0-5" class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary sm:text-sm">
              </div>
            </div>
            
            <div class="grid md:grid-cols-2 gap-6 mb-6">
              <!-- Job Location -->
              <div>
                <label for="joblocation" class="block text-sm font-medium text-gray-700 mb-2">Job Location</label>
                <input type="text" id="joblocation" name="joblocation" required placeholder="e.g. Barangay 560 Sampaloc, Manila" class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary sm:text-sm">
              </div>
              
              <!-- Job Expiration Date -->
              <div>
                <label for="jed" class="block text-sm font-medium text-gray-700 mb-2">Job Expiration Date</label>
                <input type="date" id="jed" name="jed" required class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary sm:text-sm">
              </div>
            </div>
            
            <!-- Job Description -->
            <div class="mb-6">
              <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Job Description</label>
              <div class="text-editor-box border border-gray-300 rounded-md">
                <textarea id="description" name="description" required class="block w-full p-3 border-gray-300 focus:outline-none focus:ring-primary focus:border-primary sm:text-sm rounded-md"></textarea>
              </div>
            </div>
            
            <!-- Submit Button -->
            <div class="text-center">
              <button type="submit" name="submit" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-primary hover:bg-primary-dark focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary transition-colors">
                <i class="fas fa-paper-plane mr-2"></i> Post Job
              </button>
            </div>
          </form>
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
          <h4 class="font-semibold mb-4">Employer Tools</h4>
          <ul class="space-y-2">
            <li><a href="job-listing.php" class="text-gray-400 hover:text-white transition-colors">Manage Jobs</a></li>
            <li><a href="candidates-listings.php" class="text-gray-400 hover:text-white transition-colors">View Candidates</a></li>
            <li><a href="candidates-reports.php" class="text-gray-400 hover:text-white transition-colors">Reports</a></li>
            <li><a href="edit-profile.php" class="text-gray-400 hover:text-white transition-colors">Company Profile</a></li>
          </ul>
        </div>
        
        <!-- Resources -->
        <div>
          <h4 class="font-semibold mb-4">Resources</h4>
          <ul class="space-y-2">
            <li><a href="#" class="text-gray-400 hover:text-white transition-colors">Hiring Guides</a></li>
            <li><a href="#" class="text-gray-400 hover:text-white transition-colors">Interview Tips</a></li>
            <li><a href="#" class="text-gray-400 hover:text-white transition-colors">Employer FAQs</a></li>
            <li><a href="#" class="text-gray-400 hover:text-white transition-colors">Privacy Policy</a></li>
          </ul>
        </div>
        
        <!-- Newsletter -->
        <div>
          <h4 class="font-semibold mb-4">Stay Updated</h4>
          <p class="text-gray-400 mb-4">Get the latest hiring tips and best practices.</p>
          <div class="flex">
            <input type="email" placeholder="Your email" 
                   class="flex-1 px-4 py-2 bg-gray-800 border border-gray-700 rounded-l-lg focus:outline-none focus:ring-2 focus:ring-primary">
            <button class="bg-primary px-4 py-2 rounded-r-lg hover:bg-primary-dark transition-colors">
              <i class="fas fa-paper-plane"></i>
            </button>
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
  <script src="../js/editor.js"></script> 
  <script src="../js/jquery.accordion.js"></script> 
  <script src="../js/jquery.noconflict.js"></script> 
  <script src="../js/theme-scripts.js"></script> 
  <script src="../js/custom.js"></script>
</body>
</html>
<?php } ?>

<!-- Done 21 -->