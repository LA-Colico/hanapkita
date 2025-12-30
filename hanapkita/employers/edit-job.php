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
if (empty($_SESSION['token2'])) {
    $_SESSION['token2'] = bin2hex(random_bytes(32));
}

if(isset($_POST['update']))
{

//Verifying CSRF Token
if (!empty($_POST['csrftoken2'])) {
if (hash_equals($_SESSION['token2'], $_POST['csrftoken2'])) {

//Getting Jobid
$jid=intval($_GET['jobid']);
//Geeting Employer Id
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
$isactive=$_POST['status'];



$sql="Update tbljobs set jobCategory=:category,jobTitle=:jontitle,jobType=:jobtype,salaryPackage=:salpackg,skillsRequired=:skills,experience=:exprnce,jobLocation=:joblocation,jobDescription=:jobdesc,JobExpdate=:jed,isActive=:isactive where employerId=:eid and jobId=:jid";
$query = $dbh->prepare($sql);
// Binding Post Values
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
$query->bindParam(':jid',$jid,PDO::PARAM_STR);
$query->bindParam(':eid',$empid,PDO::PARAM_STR);
$query->execute();

$msg=" Job updated Successfully";
unset( $_SESSION['token2']);




}}}

?>

<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Edit Job | Hanap-Kita</title>
  
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
  
  <!-- Rich Text Editor -->
  <script src="http://js.nicedit.com/nicEdit-latest.js" type="text/javascript"></script>
  <script type="text/javascript">
    // Wait for DOM to be fully loaded
    document.addEventListener('DOMContentLoaded', function() {
      // Initialize nicEditor specifically on the description textarea
      new nicEditor({fullPanel : true}).panelInstance('description');
    });
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

  <?php
  //Getting Jobid
  $jid=intval($_GET['jobid']);
  //Geeting Employer Id
  $empid=$_SESSION['emplogin'];
  // Fetching jobs
  $sql = "SELECT tbljobs.*,tblemployers.CompnayLogo from tbljobs join tblemployers on tblemployers.id=tbljobs.employerId  where tbljobs.employerId=:eid and tbljobs.jobId=:jid";
  $query = $dbh -> prepare($sql);
  $query-> bindParam(':eid', $empid, PDO::PARAM_STR);
  $query-> bindParam(':jid', $jid, PDO::PARAM_STR);
  $query->execute();
  $results=$query->fetchAll(PDO::FETCH_OBJ);
  if($query->rowCount() > 0)
  {
  foreach($results as $result)
  {
  ?>

  <!-- Main Content -->
  <div class="py-12 bg-gray-50">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
      <!-- Page Title -->
      <div class="mb-10 text-center">
        <h1 class="text-3xl font-bold text-gray-900">Edit Job: <?php echo htmlentities($result->jobTitle);?></h1>
        <p class="mt-2 text-lg text-gray-600">Update job details and requirements</p>
      </div>
      
      <!-- Alert Messages -->
      <?php if(@$error){ ?>
      <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4 rounded-md">
        <div class="flex">
          <div class="flex-shrink-0">
            <i class="fas fa-exclamation-circle text-red-500"></i>
          </div>
          <div class="ml-3">
            <h3 class="text-sm font-medium text-red-800">Error</h3>
            <p class="text-sm text-red-700"><?php echo htmlentities($error);?></p>
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
            <h3 class="text-sm font-medium text-green-800">Success</h3>
            <p class="text-sm text-green-700"><?php echo htmlentities($msg);?></p>
          </div>
        </div>
      </div>
      <?php } ?>
      
      <!-- Job Edit Form -->
      <div class="bg-white rounded-xl shadow-sm overflow-hidden">
        <div class="border-b border-gray-100 bg-gradient-to-r from-primary-light to-primary px-6 py-4">
          <h2 class="text-xl font-semibold text-white">Job Information</h2>
        </div>
        
        <div class="p-6">
          <form name="empsignup" enctype="multipart/form-data" method="post" onSubmit="return valid();">
            <input type="hidden" name="csrftoken2" value="<?php echo htmlentities($_SESSION['token2']); ?>" />
            
            <div class="grid md:grid-cols-2 gap-6 mb-6">
              <!-- Category -->
              <div>
                <label for="category" class="block text-sm font-medium text-gray-700 mb-1">Category*</label>
                <select name="category" id="category" class="block w-full rounded-md border-gray-300 shadow-sm focus:ring-primary focus:border-primary sm:text-sm">
                  <option value="<?php echo htmlentities($result->jobCategory);?>"><?php echo htmlentities($result->jobCategory);?></option>
                  <?php 
                  $sqlt = "SELECT CategoryName FROM tblcategory order by CategoryName asc";
                  $queryt = $dbh -> prepare($sqlt);
                  $queryt -> execute();
                  $results = $queryt -> fetchAll(PDO::FETCH_OBJ);
                  $cnt=1;
                  if($queryt -> rowCount() > 0)
                  {
                  foreach($results as $row)
                  {?>
                  <option value="<?php echo htmlentities($row->CategoryName);?>"><?php echo htmlentities($row->CategoryName);?></option>
                  <?php  }} ?>
                </select>
              </div>
              
              <!-- Job Title -->
              <div>
                <label for="jobtitle" class="block text-sm font-medium text-gray-700 mb-1">Job Title*</label>
                <input type="text" name="jobtitle" id="jobtitle" required value="<?php echo htmlentities($result->jobTitle);?>" autocomplete="off" 
                       class="block w-full rounded-md border-gray-300 shadow-sm focus:ring-primary focus:border-primary sm:text-sm">
              </div>
              
              <!-- Job Type -->
              <div>
                <label for="jobtype" class="block text-sm font-medium text-gray-700 mb-1">Job Type</label>
                <select name="jobtype" id="jobtype" class="block w-full rounded-md border-gray-300 shadow-sm focus:ring-primary focus:border-primary sm:text-sm">
                  <option value="<?php echo htmlentities($result->jobType);?>"><?php echo htmlentities($result->jobType);?></option>
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
                <label for="salarypackage" class="block text-sm font-medium text-gray-700 mb-1">Salary Package</label>
                <input type="text" name="salarypackage" id="salarypackage" value="<?php echo htmlentities($result->salaryPackage);?>" required 
                       class="block w-full rounded-md border-gray-300 shadow-sm focus:ring-primary focus:border-primary sm:text-sm">
              </div>
              
              <!-- Skills Required -->
              <div>
                <label for="skills" class="block text-sm font-medium text-gray-700 mb-1">Skills Required</label>
                <input type="text" name="skills" id="skills" value="<?php echo htmlentities($result->skillsRequired);?>" required 
                       class="block w-full rounded-md border-gray-300 shadow-sm focus:ring-primary focus:border-primary sm:text-sm">
              </div>
              
              <!-- Experience -->
              <div>
                <label for="experience" class="block text-sm font-medium text-gray-700 mb-1">Experience</label>
                <input type="text" name="experience" id="experience" value="<?php echo htmlentities($result->experience);?>" required 
                       class="block w-full rounded-md border-gray-300 shadow-sm focus:ring-primary focus:border-primary sm:text-sm">
              </div>
              
              <!-- Job Location -->
              <div>
                <label for="joblocation" class="block text-sm font-medium text-gray-700 mb-1">Job Location</label>
                <input type="text" name="joblocation" id="joblocation" value="<?php echo htmlentities($result->jobLocation);?>" required 
                       class="block w-full rounded-md border-gray-300 shadow-sm focus:ring-primary focus:border-primary sm:text-sm">
              </div>
              
              <!-- Job Expiration Date -->
              <div>
                <label for="jed" class="block text-sm font-medium text-gray-700 mb-1">Job Expiration Date</label>
                <input type="date" name="jed" id="jed" value="<?php echo htmlentities($result->JobExpdate);?>" required 
                       class="block w-full rounded-md border-gray-300 shadow-sm focus:ring-primary focus:border-primary sm:text-sm">
              </div>
              
              <!-- Job Status -->
              <div>
                <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Job Status</label>
                <select name="status" id="status" class="block w-full rounded-md border-gray-300 shadow-sm focus:ring-primary focus:border-primary sm:text-sm">
                  <!-- if job is active -->
                  <?php if($result->isActive==1):?>                 
                  <option value="<?php echo htmlentities($result->isActive);?>">Active</option>
                  <option value="0">In Active</option>
                  <option value="2">Job Filled</option>
                  <?php endif;?>

                  <!-- if job is Inactive -->
                  <?php if($result->isActive==0):?>                 
                  <option value="<?php echo htmlentities($result->isActive);?>">In Active</option>
                  <option value="1">Active</option>
                  <option value="2">Job Filled</option>
                  <?php endif;?>
                    
                  <!-- if job is Filled -->
                  <?php if($result->isActive==2):?>                 
                  <option value="<?php echo htmlentities($result->isActive);?>">Job Filled</option>
                  <option value="1">Active</option>
                  <?php endif;?>
                </select>
              </div>
            </div>
            
            <!-- Job Description -->
            <div class="mb-6">
              <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Job Description</label>
              <div class="nicEdit-container">
                <textarea name="description" id="description" required autocomplete="off" rows="8" 
                        class="block w-full rounded-md border-gray-300 shadow-sm focus:ring-primary focus:border-primary sm:text-sm"><?php echo htmlentities($result->jobDescription);?></textarea>
              </div>
              <style>
                .nicEdit-main { background-color: white !important; }
                .nicEdit-panel { background-color: #f8f9fa !important; border-bottom: 1px solid #e2e8f0 !important; }
                div.nicEdit-container { padding: 0 !important; margin-top: 0.5rem !important; }
              </style>
            </div>
            
            <?php }} ?>
            
            <!-- Submit Button -->
            <div class="flex justify-center mt-8">
              <button type="submit" name="update" 
                      class="inline-flex justify-center py-3 px-6 border border-transparent shadow-sm text-base font-medium rounded-md text-white bg-primary hover:bg-primary-dark focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary transition-colors">
                <i class="fas fa-save mr-2"></i> Update Job
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

  <!-- Include original scripts to preserve functionality -->
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

<!-- Done 10 -->