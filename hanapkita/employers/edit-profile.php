<?php
session_start();
//Database Configuration File
include('includes/config.php');
//error_reporting(0);
//verifying Session
if(strlen($_SESSION['emplogin'])==0)
  { 
header('location:emp-login.php');
}
else{
if(isset($_POST['update']))
{
//Getting Post Values
$conrnper=$_POST['concernperson'];  
$emaill=$_POST['emailid']; 
$cmpnyname=$_POST['companyname']; 
$tagline=$_POST['tagline'];
$description=$_POST['description'];
$website=$_POST['website'];
$nemp=$_POST['noofempl'];
$industry=$_POST['industry'];
$bentity=$_POST['typebusinessentity'];
$location=$_POST['location'];
$estin=$_POST['estin'];
//Getting Employer Id
$empid=$_SESSION['emplogin'];

$sql="update  tblemployers set ConcernPerson=:conrnper,CompnayName=:cmpnyname,CompanyTagline=:tagline,CompnayDescription=:description,CompanyUrl=:website,noOfEmployee=:nemp,industry=:industry,typeBusinessEntity=:bentity,lcation=:location,establishedIn=:estin where id=:eid";
$query = $dbh->prepare($sql);
// Binding Post Values
$query->bindParam(':conrnper',$conrnper,PDO::PARAM_STR);
$query->bindParam(':cmpnyname',$cmpnyname,PDO::PARAM_STR);
$query->bindParam(':tagline',$tagline,PDO::PARAM_STR);
$query->bindParam(':description',$description,PDO::PARAM_STR);
$query->bindParam(':website',$website,PDO::PARAM_STR);
$query->bindParam(':nemp',$nemp,PDO::PARAM_STR);
$query->bindParam(':industry',$industry,PDO::PARAM_STR);
$query->bindParam(':bentity',$bentity,PDO::PARAM_STR);
$query->bindParam(':location',$location,PDO::PARAM_STR);
$query->bindParam(':estin',$estin,PDO::PARAM_STR);
$query-> bindParam(':eid', $empid, PDO::PARAM_STR);
$query->execute();

$msg="Account details updated Successfully";

}
?>

<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Employers | Update Account Details</title>
  
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
  
  <!-- Original scripts for rich text editor functionality -->
  <script src="http://js.nicedit.com/nicEdit-latest.js" type="text/javascript"></script>
  <script type="text/javascript">bkLib.onDomLoaded(nicEditors.allTextAreas);</script>
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
          <a href="job-listing.php" class="text-gray-700 hover:text-primary font-medium transition-colors">Jobs</a>
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
              <a href="edit-profile.php" class="block px-4 py-2 text-primary hover:bg-gray-50 rounded-t-lg">Edit Profile</a>
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

  <!-- Page Title Section -->
  <section class="bg-gradient-to-r from-primary-light to-primary py-12 text-white text-center">
    <div class="container mx-auto px-4">
      <h1 class="text-3xl font-bold">Company Profile</h1>
      <p class="mt-2 text-lg opacity-90">Update your employer account information</p>
    </div>
  </section>

  <!-- Main Content -->
  <div class="py-12 bg-gray-50">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
      <!-- Form Card -->
      <div class="bg-white rounded-xl shadow-sm overflow-hidden">
        <div class="p-6">
          <!-- Success and error message -->
          <?php if(@$error){ ?>
          <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4 text-red-700">
            <p class="font-medium">Error</p>
            <p><?php echo htmlentities($error);?></p>
          </div>
          <?php } ?>

          <?php if(@$msg){ ?>
          <div class="mb-6 bg-green-50 border-l-4 border-green-500 p-4 text-green-700">
            <p class="font-medium">Success</p>
            <p><?php echo htmlentities($msg);?></p>
          </div>
          <?php } ?>

          <!-- Profile Form -->
          <form name="empsignup" enctype="multipart/form-data" method="post" class="space-y-8">
            <?php
            //Getting Employer Id
            $empid=$_SESSION['emplogin'];
            // Fetching jobs
            $sql = "SELECT * from  tblemployers  where id=:eid";
            $query = $dbh -> prepare($sql);
            $query-> bindParam(':eid', $empid, PDO::PARAM_STR);
            $query->execute();
            $results=$query->fetchAll(PDO::FETCH_OBJ);
            if($query->rowCount() > 0)
            {
            foreach($results as $result)
            {
            ?>
            
            <!-- Basic Information Section -->
            <div>
              <h2 class="text-xl font-semibold text-gray-900 mb-4">Basic Information</h2>
              <div class="grid md:grid-cols-2 gap-6">
                <div>
                  <label for="concernperson" class="block text-sm font-medium text-gray-700 mb-1">Concern Person Name *</label>
                  <input type="text" name="concernperson" id="concernperson" required 
                         class="block w-full rounded-md border-gray-300 shadow-sm focus:ring-primary focus:border-primary sm:text-sm"
                         value="<?php echo htmlentities($result->ConcernPerson)?>">
                </div>
                
                <div>
                  <label for="emailid" class="block text-sm font-medium text-gray-700 mb-1">Your Email *</label>
                  <input type="email" name="emailid" id="emailid" readonly
                         class="block w-full rounded-md border-gray-300 bg-gray-100 shadow-sm focus:ring-primary focus:border-primary sm:text-sm"
                         value="<?php echo htmlentities($result->EmpEmail)?>">
                </div>
                
                <div>
                  <label for="companyname" class="block text-sm font-medium text-gray-700 mb-1">Company Name *</label>
                  <input type="text" name="companyname" id="companyname" required
                         class="block w-full rounded-md border-gray-300 shadow-sm focus:ring-primary focus:border-primary sm:text-sm"
                         value="<?php echo htmlentities($result->CompnayName)?>">
                </div>
                
                <div>
                  <label for="tagline" class="block text-sm font-medium text-gray-700 mb-1">Tagline *</label>
                  <input type="text" name="tagline" id="tagline" required
                         class="block w-full rounded-md border-gray-300 shadow-sm focus:ring-primary focus:border-primary sm:text-sm"
                         value="<?php echo htmlentities($result->CompanyTagline)?>">
                </div>
              </div>
            </div>
            
            <!-- Company Description -->
            <div>
              <h2 class="text-xl font-semibold text-gray-900 mb-4">Company Description</h2>
              <div>
                <textarea name="description" id="description" rows="6" required
                          class="block w-full rounded-md border-gray-300 shadow-sm focus:ring-primary focus:border-primary sm:text-sm"><?php echo $result->CompnayDescription; ?></textarea>
              </div>
            </div>
            
            <!-- Company Details Section -->
            <div>
              <h2 class="text-xl font-semibold text-gray-900 mb-4">Company Details</h2>
              <div class="grid md:grid-cols-2 gap-6">
                <div>
                  <label for="website" class="block text-sm font-medium text-gray-700 mb-1">Website</label>
                  <input type="url" name="website" id="website" 
                         class="block w-full rounded-md border-gray-300 shadow-sm focus:ring-primary focus:border-primary sm:text-sm"
                         value="<?php echo htmlentities($result->CompanyUrl)?>">
                </div>
                
                <div>
                  <label for="noofempl" class="block text-sm font-medium text-gray-700 mb-1">No. of Employees</label>
                  <input type="text" name="noofempl" id="noofempl"
                         class="block w-full rounded-md border-gray-300 shadow-sm focus:ring-primary focus:border-primary sm:text-sm"
                         value="<?php echo htmlentities($result->noOfEmployee)?>">
                </div>
                
                <div>
                  <label for="industry" class="block text-sm font-medium text-gray-700 mb-1">Industry</label>
                  <input type="text" name="industry" id="industry"
                         class="block w-full rounded-md border-gray-300 shadow-sm focus:ring-primary focus:border-primary sm:text-sm"
                         value="<?php echo htmlentities($result->industry)?>">
                </div>
                
                <div>
                  <label for="typebusinessentity" class="block text-sm font-medium text-gray-700 mb-1">Type of Business Entity</label>
                  <input type="text" name="typebusinessentity" id="typebusinessentity"
                         class="block w-full rounded-md border-gray-300 shadow-sm focus:ring-primary focus:border-primary sm:text-sm"
                         value="<?php echo htmlentities($result->typeBusinessEntity)?>">
                </div>
                
                <div>
                  <label for="location" class="block text-sm font-medium text-gray-700 mb-1">Location</label>
                  <input type="text" name="location" id="location"
                         class="block w-full rounded-md border-gray-300 shadow-sm focus:ring-primary focus:border-primary sm:text-sm"
                         value="<?php echo htmlentities($result->lcation)?>">
                </div>
                
                <div>
                  <label for="estin" class="block text-sm font-medium text-gray-700 mb-1">Established In</label>
                  <input type="text" name="estin" id="estin"
                         class="block w-full rounded-md border-gray-300 shadow-sm focus:ring-primary focus:border-primary sm:text-sm"
                         value="<?php echo htmlentities($result->establishedIn)?>">
                </div>
              </div>
            </div>
            
            <!-- Company Logo Section -->
            <div>
              <h2 class="text-xl font-semibold text-gray-900 mb-4">Company Logo</h2>
              <div class="flex items-center space-x-6">
                <div class="w-32 h-32 rounded-lg overflow-hidden bg-gray-100 flex items-center justify-center">
                  <img src="employerslogo/<?php echo htmlentities($result->CompnayLogo)?>" alt="Company Logo" class="max-w-full max-h-full">
                </div>
                
                <div>
                  <a href="change-logo.php" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-primary hover:bg-primary-dark focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary transition-colors">
                    <i class="fas fa-image mr-2"></i> Change Logo
                  </a>
                </div>
              </div>
            </div>
            
            <?php 
            }}
            ?>
            
            <!-- Submit Button -->
            <div class="pt-4 border-t border-gray-200">
              <button type="submit" name="update" 
                      class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-primary hover:bg-primary-dark focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary transition-colors">
                <i class="fas fa-save mr-2"></i> Update Profile
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
  
  <!-- Footer -->
  <footer class="bg-gray-900 text-white py-12">
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

<!-- Done 11 -->