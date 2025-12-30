<?php
session_start();
//Database Configuration File
include('includes/config.php');
error_reporting(0);
//verifying Session
if(strlen($_SESSION['emplogin'])==0)
  { 
header('location:logout.php');
}
else{ ?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Candidate Profile | Hanap-Kita</title>
  
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
          <a href="job-listing.php" class="text-gray-700 hover:text-primary font-medium transition-colors">Jobs</a>
          <a href="candidates-listings.php" class="text-primary font-medium transition-colors">Candidates</a>
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
      <?php
      //Getting User Id
      $canid=$_GET['canid'];

      // Fetching User Details
      $sql = "SELECT * from  tbljobseekers  where id=:canid";
      $query = $dbh -> prepare($sql);
      $query-> bindParam(':canid', $canid, PDO::PARAM_STR);
      $query->execute();
      $results=$query->fetchAll(PDO::FETCH_OBJ);
      foreach($results as $result)
      {
      ?>
      
      <!-- Page Title -->
      <div class="mb-10 text-center">
        <h1 class="text-3xl font-bold text-gray-900"><?php echo htmlentities($result->FullName);?>'s Profile</h1>
        <p class="mt-2 text-lg text-gray-600">Candidate details and qualifications</p>
      </div>
      
      <!-- Candidate Info Card -->
      <div class="bg-white rounded-xl shadow-sm overflow-hidden mb-8">
        <div class="border-b border-gray-100 bg-gradient-to-r from-primary-light to-primary px-6 py-4">
          <h2 class="text-xl font-semibold text-white">Personal Information</h2>
        </div>
        
        <div class="p-6">
          <div class="flex flex-col md:flex-row items-start gap-6">
            <!-- Profile Image -->
            <div class="flex-shrink-0 mb-4 md:mb-0">
              <div class="w-24 h-24 rounded-full overflow-hidden bg-gray-100 flex items-center justify-center border border-gray-200">
                <?php if($result->ProfilePic==''): ?>
                  <img src="../images/account.png" class="w-full h-full object-cover" alt="Profile Picture">
                <?php else: ?>
                  <img src="../images/<?php echo $result->ProfilePic;?>" class="w-full h-full object-cover" alt="Profile Picture">
                <?php endif;?>
              </div>
            </div>
            
            <!-- Details -->
            <div class="flex-1">
              <h3 class="text-xl font-semibold text-gray-900"><?php echo htmlentities($result->FullName);?></h3>
              
              <div class="mt-2 text-gray-600">
                <p class="mb-1 flex items-center">
                  <i class="fas fa-envelope text-primary mr-2"></i>
                  <?php echo htmlentities($result->EmailId);?>
                </p>
                <p class="mb-1 flex items-center">
                  <i class="fas fa-phone text-primary mr-2"></i>
                  <?php echo htmlentities($result->ContactNumber);?>
                </p>
                <p class="mb-1 flex items-center">
                  <i class="fas fa-calendar text-primary mr-2"></i>
                  Registered on: <?php echo htmlentities($result->RegDate);?>
                </p>
              </div>
              
              <div class="mt-4">
                <a href="../Jobseekersresumes/<?php echo htmlentities($result->Resume);?>" 
                   class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-primary hover:bg-primary-dark focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary transition-colors"
                   target="_blank">
                  <i class="fas fa-file-pdf mr-2"></i>
                  Download Resume
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>
      
      <!-- About Me Card -->
      <div class="bg-white rounded-xl shadow-sm overflow-hidden mb-8">
        <div class="border-b border-gray-100 bg-gradient-to-r from-primary-light to-primary px-6 py-4">
          <h2 class="text-xl font-semibold text-white">About Me</h2>
        </div>
        
        <div class="p-6">
          <p class="text-gray-700 leading-relaxed">
            <?php echo htmlentities($result->AboutMe);?>
          </p>
        </div>
      </div>
      <?php } ?>
      
      <!-- Education Card -->
      <div class="bg-white rounded-xl shadow-sm overflow-hidden mb-8">
        <div class="border-b border-gray-100 bg-gradient-to-r from-primary-light to-primary px-6 py-4">
          <h2 class="text-xl font-semibold text-white">Education</h2>
        </div>
        
        <div class="p-6 space-y-6">
          <?php
          //Getting User Id
          $canid=$_GET['canid'];
          // Fetching User Education Details
          $sql = "SELECT * from  tbleducation  where UserID=:canid";
          $query = $dbh -> prepare($sql);
          $query-> bindParam(':canid', $canid, PDO::PARAM_STR);
          $query->execute();
          $results=$query->fetchAll(PDO::FETCH_OBJ);
          foreach($results as $result)
          {
          ?>
          <div class="bg-gray-50 rounded-lg p-5 border border-gray-100">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-3">
              <h3 class="text-lg font-semibold text-gray-900"><?php echo htmlentities($result->Qualification);?></h3>
              <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-primary-light text-white">
                <?php echo htmlentities($result->PassingYear);?>
              </span>
            </div>
            
            <div class="grid md:grid-cols-2 gap-4 text-sm">
              <div>
                <p class="text-gray-500 mb-1">School/College</p>
                <p class="font-medium text-gray-900"><?php echo htmlentities($result->ClgorschName);?></p>
              </div>
              
              <div>
                <p class="text-gray-500 mb-1">Stream</p>
                <p class="font-medium text-gray-900"><?php echo htmlentities($result->Stream);?></p>
              </div>
              
              <div>
                <p class="text-gray-500 mb-1">CGPA</p>
                <p class="font-medium text-gray-900"><?php echo htmlentities($result->CGPA);?></p>
              </div>
              
              <div>
                <p class="text-gray-500 mb-1">Percentage</p>
                <p class="font-medium text-gray-900"><?php echo htmlentities($result->Percentage);?>%</p>
              </div>
            </div>
          </div>
          <?php } ?>
        </div>
      </div>
      
      <!-- Experience Card -->
      <div class="bg-white rounded-xl shadow-sm overflow-hidden mb-8">
        <div class="border-b border-gray-100 bg-gradient-to-r from-primary-light to-primary px-6 py-4">
          <h2 class="text-xl font-semibold text-white">Work Experience</h2>
        </div>
        
        <div class="p-6 space-y-6">
          <?php
          //Getting User Id
          $canid=$_GET['canid'];
          // Fetching User Education Details
          $sql = "SELECT * from  tblexperience  where UserID=:canid";
          $query = $dbh -> prepare($sql);
          $query-> bindParam(':canid', $canid, PDO::PARAM_STR);
          $query->execute();
          $results=$query->fetchAll(PDO::FETCH_OBJ);
          foreach($results as $result)
          {
          ?>
          <div class="bg-gray-50 rounded-lg p-5 border border-gray-100">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-3">
              <h3 class="text-lg font-semibold text-gray-900"><?php echo htmlentities($result->Designation);?></h3>
              <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-primary-light text-white">
                <?php echo htmlentities($result->FromDate);?> - <?php echo htmlentities($result->ToDate);?>
              </span>
            </div>
            
            <p class="text-primary font-medium mb-4"><?php echo htmlentities($result->EmployerName);?></p>
            
            <div class="grid md:grid-cols-3 gap-4 text-sm">
              <div>
                <p class="text-gray-500 mb-1">Employment Type</p>
                <p class="font-medium text-gray-900"><?php echo htmlentities($result->EmployementType);?></p>
              </div>
              
              <div>
                <p class="text-gray-500 mb-1">Monthly CTC</p>
                <p class="font-medium text-gray-900">₱<?php echo htmlentities($result->Ctc);?></p>
              </div>
              
              <div>
                <p class="text-gray-500 mb-1">Skills</p>
                <div class="flex flex-wrap gap-2 mt-1">
                  <?php 
                  $skills = explode(',', $result->Skills);
                  foreach($skills as $skill) {
                    echo '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">' . trim($skill) . '</span>';
                  }
                  ?>
                </div>
              </div>
            </div>
          </div>
          <?php } ?>
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

  <!-- Include original scripts to preserve functionality -->
  <script src="../js/jquery-1.11.3.min.js"></script> 
  <script src="../js/bootstrap.min.js"></script> 
  <script src="../js/owl.carousel.min.js"></script> 
  <script src="../js/jquery.velocity.min.js"></script> 
  <script src="../js/jquery.kenburnsy.js"></script> 
  <script src="../js/jquery.mCustomScrollbar.concat.min.js"></script> 
  <script src="../js/form.js"></script> 
  <script src="../js/custom.js"></script>
</body>
</html>
<?php } ?>

<!-- Done 3 -->