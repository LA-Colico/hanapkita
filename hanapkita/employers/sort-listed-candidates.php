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
else{?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Sort Listed Candidates | Hanap-Kita</title>
  
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

  <!-- Page Title Banner -->
  <div class="bg-gradient-to-r from-primary-light to-primary py-12 px-4">
    <div class="max-w-7xl mx-auto">
      <h1 class="text-3xl font-bold text-white text-center">Sort Listed Candidates</h1>
      <p class="text-center text-white mt-2 opacity-90">Review candidates you've shortlisted for your job postings</p>
    </div>
  </div>

  <!-- Search Bar Section -->
  <div class="bg-white shadow-sm border-b border-gray-100 py-6">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
      <form action="candidates-search.php" method="post" class="flex flex-col md:flex-row gap-4">
        <div class="flex-1">
          <input type="text" placeholder="Search by job title" name="jobtitle" 
                 class="w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent">
        </div>
        <div>
          <button type="submit" name="search" 
                  class="w-full md:w-auto px-6 py-3 bg-primary text-white rounded-lg hover:bg-primary-dark transition-colors shadow-sm">
            <i class="fas fa-search mr-2"></i> Search
          </button>
        </div>
      </form>
    </div>
  </div>

  <!-- Main Content -->
  <div class="py-12">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
      <!-- Section Title -->
      <div class="mb-8">
        <h2 class="text-2xl font-bold text-gray-900">Sort Listed Candidates</h2>
        <p class="text-gray-600 mt-2">Showing candidates you've selected for further consideration</p>
      </div>

      <!-- Candidates Listing -->
      <?php
      $eid=$_SESSION['emplogin'];
      if (isset($_GET['page_no']) && $_GET['page_no']!="") {
        $page_no = $_GET['page_no'];
      } else {
        $page_no = 1;
      }
      
      // Formula for pagination
      $no_of_records_per_page = 5;
      $offset = ($page_no-1) * $no_of_records_per_page;
      $previous_page = $page_no - 1;
      $next_page = $page_no + 1;
      $adjacents = "2"; 
      
      $ret = "SELECT tbljobs.jobId FROM tblapplyjob join tbljobs on tblapplyjob.JobId=tbljobs.jobId join tbljobseekers on tblapplyjob.UserId=tbljobseekers.id where tbljobs.employerId=:eid and (tblapplyjob.Status='Sort Listed')";
      $query1 = $dbh -> prepare($ret);
      $query1-> bindParam(':eid', $eid, PDO::PARAM_STR);
      $query1->execute();
      $results1=$query1->fetchAll(PDO::FETCH_OBJ);
      $total_rows=$query1->rowCount();
      $total_no_of_pages = ceil($total_rows / $no_of_records_per_page);
      $second_last = $total_no_of_pages - 1; // total page minus 1

      $sql="SELECT tbljobseekers.*,tbljobs.*,tblapplyjob.Status, tblapplyjob.UserId, tblapplyjob.JobId,tblapplyjob.Applydate, tblapplyjob.ResponseDate from tblapplyjob join tbljobs on tblapplyjob.JobId=tbljobs.jobId join tbljobseekers on tblapplyjob.UserId=tbljobseekers.id where tbljobs.employerId=:eid and (tblapplyjob.Status='Sort Listed') order by tblapplyjob.id desc LIMIT $offset, $no_of_records_per_page";
      $query = $dbh -> prepare($sql);
      $query-> bindParam(':eid', $eid, PDO::PARAM_STR);
      $query->execute();
      $results=$query->fetchAll(PDO::FETCH_OBJ);
      
      $cnt=1;
      if($query->rowCount() > 0) {
        foreach($results as $row) {
      ?>
      
      <!-- Candidate Card -->
      <div class="bg-white rounded-xl shadow-sm overflow-hidden mb-6 transition-all hover:shadow-md">
        <div class="p-6 flex flex-col md:flex-row gap-6">
          <!-- Candidate Photo -->
          <div class="flex-shrink-0">
            <div class="w-24 h-24 rounded-full overflow-hidden bg-gray-100 border border-gray-200">
              <?php if($row->ProfilePic==''): ?>
                <img src="../images/account.png" alt="Profile" class="w-full h-full object-cover">
              <?php else: ?>
                <img src="../images/<?php echo $row->ProfilePic;?>" alt="Profile" class="w-full h-full object-cover">
              <?php endif;?>
            </div>
          </div>
          
          <!-- Candidate Details -->
          <div class="flex-1">
            <h3 class="text-xl font-bold text-gray-900 mb-2">
              <?php echo htmlentities($row->FullName);?>
            </h3>
            
            <div class="flex flex-wrap gap-x-8 gap-y-2 text-sm text-gray-700 mb-4">
              <div class="flex items-center">
                <i class="fas fa-calendar-alt text-primary mr-2"></i>
                <span>Applied: <?php echo htmlentities($row->Applydate);?></span>
              </div>
              <div class="flex items-center">
                <i class="fas fa-briefcase text-primary mr-2"></i>
                <span>Position: <?php echo htmlentities($row->jobTitle);?> (<?php echo htmlentities($row->jobType);?>)</span>
              </div>
              <div class="flex items-center">
                <i class="fas fa-phone text-primary mr-2"></i>
                <span><?php echo htmlentities($row->ContactNumber);?></span>
              </div>
              <div class="flex items-center">
                <i class="fas fa-envelope text-primary mr-2"></i>
                <span><?php echo htmlentities($row->EmailId);?></span>
              </div>
            </div>
            
            <!-- Status Badge -->
            <div class="mb-4">
              <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                <i class="fas fa-check-circle mr-1"></i> Sort Listed
              </span>
            </div>
            
            <!-- Action Buttons -->
            <div class="flex flex-wrap gap-3">
              <a href="../Jobseekersresumes/<?php echo htmlentities($row->Resume);?>" target="_blank"
                 class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary transition-colors">
                <i class="fas fa-file-alt mr-2 text-primary"></i> Resume
              </a>
              
              <a href="candidates-details.php?canid=<?php echo ($row->id);?>" target="_blank"
                 class="inline-flex items-center px-4 py-2 border border-primary rounded-md shadow-sm text-sm font-medium text-primary bg-white hover:bg-primary hover:text-white focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary transition-colors">
                <i class="fas fa-user mr-2"></i> Candidate Details
              </a>
              
              <a href="app-details.php?jobid=<?php echo ($row->JobId);?> && name=<?php echo htmlentities($row->FullName);?>&& jsid=<?php echo htmlentities($row->id);?>" target="_blank"
                 class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-primary hover:bg-primary-dark focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary transition-colors">
                <i class="fas fa-clipboard-list mr-2"></i> Application Details
              </a>
            </div>
          </div>
        </div>
      </div>
      <?php 
        $cnt=$cnt+1;
        }
      } else { 
      ?>
      <!-- No Results Message -->
      <div class="bg-white rounded-xl shadow-sm p-12 text-center">
        <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-gray-100 mb-4">
          <i class="fas fa-search text-gray-400 text-2xl"></i>
        </div>
        <h3 class="text-xl font-semibold text-gray-900 mb-2">No Sort Listed Candidates Found</h3>
        <p class="text-gray-600">You haven't shortlisted any candidates yet.</p>
      </div>
      <?php } ?>
      
      <!-- Pagination -->
      <?php if($total_no_of_pages > 1) { ?>
      <div class="mt-8 flex justify-center">
        <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px" aria-label="Pagination">
          <!-- Previous Page -->
          <a href="<?php if($page_no > 1){ echo "?page_no=$previous_page"; } else { echo "#"; } ?>" 
             class="<?php if($page_no <= 1){ echo "opacity-50 cursor-not-allowed"; } ?> relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
            <span class="sr-only">Previous</span>
            <i class="fas fa-chevron-left"></i>
          </a>
          
          <!-- Page Numbers -->
          <?php
          if ($total_no_of_pages <= 10){
            for ($counter = 1; $counter <= $total_no_of_pages; $counter++){
              if ($counter == $page_no) {
                echo "<a aria-current='page' class='relative inline-flex items-center px-4 py-2 border border-primary bg-primary text-sm font-medium text-white'>$counter</a>";
              } else {
                echo "<a href='?page_no=$counter' class='relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50'>$counter</a>";
              }
            }
          } elseif($total_no_of_pages > 10) {
            // Logic for handling more than 10 pages
            // Implementation follows the original pagination logic but with new styling
            if($page_no <= 4) {
              for ($counter = 1; $counter < 8; $counter++){
                if ($counter == $page_no) {
                  echo "<a aria-current='page' class='relative inline-flex items-center px-4 py-2 border border-primary bg-primary text-sm font-medium text-white'>$counter</a>";
                } else {
                  echo "<a href='?page_no=$counter' class='relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50'>$counter</a>";
                }
              }
              echo "<a class='relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700'>...</a>";
              echo "<a href='?page_no=$second_last' class='relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50'>$second_last</a>";
              echo "<a href='?page_no=$total_no_of_pages' class='relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50'>$total_no_of_pages</a>";
            } elseif($page_no > 4 && $page_no < $total_no_of_pages - 4) {
              echo "<a href='?page_no=1' class='relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50'>1</a>";
              echo "<a href='?page_no=2' class='relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50'>2</a>";
              echo "<a class='relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700'>...</a>";
              
              for ($counter = $page_no - $adjacents; $counter <= $page_no + $adjacents; $counter++) {
                if ($counter == $page_no) {
                  echo "<a aria-current='page' class='relative inline-flex items-center px-4 py-2 border border-primary bg-primary text-sm font-medium text-white'>$counter</a>";
                } else {
                  echo "<a href='?page_no=$counter' class='relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50'>$counter</a>";
                }
              }
              
              echo "<a class='relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700'>...</a>";
              echo "<a href='?page_no=$second_last' class='relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50'>$second_last</a>";
              echo "<a href='?page_no=$total_no_of_pages' class='relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50'>$total_no_of_pages</a>";
            } else {
              echo "<a href='?page_no=1' class='relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50'>1</a>";
              echo "<a href='?page_no=2' class='relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50'>2</a>";
              echo "<a class='relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700'>...</a>";
              
              for ($counter = $total_no_of_pages - 6; $counter <= $total_no_of_pages; $counter++) {
                if ($counter == $page_no) {
                  echo "<a aria-current='page' class='relative inline-flex items-center px-4 py-2 border border-primary bg-primary text-sm font-medium text-white'>$counter</a>";
                } else {
                  echo "<a href='?page_no=$counter' class='relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50'>$counter</a>";
                }
              }
            }
          }
          ?>
          
          <!-- Next Page -->
          <a href="<?php if($page_no < $total_no_of_pages) { echo "?page_no=$next_page"; } else { echo "#"; } ?>"
             class="<?php if($page_no >= $total_no_of_pages){ echo "opacity-50 cursor-not-allowed"; } ?> relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
            <span class="sr-only">Next</span>
            <i class="fas fa-chevron-right"></i>
          </a>
        </nav>
      </div>
      <?php } ?>
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
  <script src="../js/form.js"></script> 
  <script src="../js/custom.js"></script>
</body>
</html>
<?php }?>

<!-- Done 23 -->