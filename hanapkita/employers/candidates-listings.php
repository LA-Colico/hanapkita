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
  <title>Hanap-Kita - Latest Resumes</title>
  
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
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <!-- Page Title -->
      <div class="mb-10 text-center">
        <h1 class="text-3xl font-bold text-gray-900">Latest Resumes</h1>
        <p class="mt-2 text-lg text-gray-600">View and manage candidates who have applied to your job listings</p>
      </div>
      
      <!-- Search Bar -->
      <div class="mb-8">
        <form action="candidates-search.php" method="post" class="flex flex-col md:flex-row gap-4">
          <div class="flex-1">
            <div class="relative rounded-md shadow-sm">
              <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <i class="fas fa-briefcase text-gray-400"></i>
              </div>
              <input type="text" name="jobtitle" placeholder="Search by job title" 
                     class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg focus:ring-primary focus:border-primary">
            </div>
          </div>
          <button type="submit" name="search" 
                  class="px-6 py-3 bg-primary text-white font-medium rounded-lg shadow-sm hover:bg-primary-dark focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary transition-colors">
            Search
          </button>
        </form>
      </div>
      
      <!-- Candidates List -->
      <div class="bg-white rounded-xl shadow-sm overflow-hidden">
        <div class="border-b border-gray-100 bg-gradient-to-r from-primary-light to-primary px-6 py-4">
          <h2 class="text-xl font-semibold text-white">Showing Resumes by Applied Candidates</h2>
        </div>
        
        <div class="divide-y divide-gray-100">
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
          
          $ret = "SELECT tbljobs.jobId FROM tblapplyjob join tbljobs on tblapplyjob.JobId=tbljobs.jobId join tbljobseekers on tblapplyjob.UserId=tbljobseekers.id where tbljobs.employerId=:eid";
          $query1 = $dbh -> prepare($ret);
          $query1-> bindParam(':eid', $eid, PDO::PARAM_STR);
          $query1->execute();
          $results1=$query1->fetchAll(PDO::FETCH_OBJ);
          $total_rows=$query1->rowCount();
          $total_no_of_pages = ceil($total_rows / $no_of_records_per_page);
          $second_last = $total_no_of_pages - 1; // total page minus 1

          $sql="SELECT tbljobseekers.*,tbljobs.*,tblapplyjob.Status, tblapplyjob.UserId, tblapplyjob.JobId,tblapplyjob.Applydate, tblapplyjob.ResponseDate from tblapplyjob join tbljobs on tblapplyjob.JobId=tbljobs.jobId join tbljobseekers on tblapplyjob.UserId=tbljobseekers.id where tbljobs.employerId=:eid order by tblapplyjob.id desc LIMIT $offset, $no_of_records_per_page";
          $query = $dbh -> prepare($sql);
          $query-> bindParam(':eid', $eid, PDO::PARAM_STR);
          $query->execute();
          $results=$query->fetchAll(PDO::FETCH_OBJ);

          $cnt=1;
          if($query->rowCount() > 0) {
            foreach($results as $row) {
          ?>
          <!-- Candidate Card -->
          <div class="p-6">
            <div class="flex flex-col md:flex-row gap-6">
              <!-- Profile Image -->
              <div class="flex-shrink-0">
                <?php if($row->ProfilePic==''): ?>
                  <img src="../images/account.png" alt="Profile" class="w-20 h-20 rounded-full object-cover">
                <?php else: ?>
                  <img src="../images/<?php echo $row->ProfilePic;?>" alt="Profile" class="w-20 h-20 rounded-full object-cover">
                <?php endif;?>
              </div>
              
              <!-- Candidate Info -->
              <div class="flex-1">
                <div class="flex flex-col md:flex-row md:justify-between md:items-start mb-4">
                  <div>
                    <h3 class="text-xl font-semibold text-gray-900"><?php echo htmlentities($row->FullName);?></h3>
                    <p class="text-sm text-gray-500 mt-1">Applied on <?php echo htmlentities($row->Applydate);?></p>
                  </div>
                  
                  <!-- Application Status -->
                  <div class="mt-2 md:mt-0">
                    <?php  
                    if($row->Status=="") {
                      echo '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">Not Responded Yet</span>';
                    } else if($row->Status=="Sort Listed") {
                      echo '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">Sort Listed</span>';
                    } else if($row->Status=="Hired") {
                      echo '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">Hired</span>';
                    } else if($row->Status=="Rejected") {
                      echo '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">Rejected</span>';
                    } else {
                      echo '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">'.$row->Status.'</span>';
                    }
                    ?>
                  </div>
                </div>
                
                <p class="text-gray-700 mb-2"><span class="font-semibold">Applied For:</span> <?php echo htmlentities($row->jobTitle);?> (<?php echo htmlentities($row->jobType);?>)</p>
                
                <div class="flex flex-col md:flex-row md:items-center gap-3 md:gap-6 mb-4">
                  <div class="flex items-center text-gray-600">
                    <i class="fas fa-phone text-primary mr-2"></i>
                    <span><?php echo htmlentities($row->ContactNumber);?></span>
                  </div>
                  <div class="flex items-center text-gray-600">
                    <i class="fas fa-envelope text-primary mr-2"></i>
                    <span><?php echo htmlentities($row->EmailId);?></span>
                  </div>
                </div>
                
                <!-- Action Buttons -->
                <div class="flex flex-wrap gap-3">
                  <a href="../Jobseekersresumes/<?php echo htmlentities($row->Resume);?>" target="_blank"
                     class="inline-flex items-center px-3 py-2 border border-primary text-sm font-medium rounded-md text-primary bg-white hover:bg-primary hover:text-white transition-colors">
                    <i class="fas fa-file-alt mr-2"></i> Resume
                  </a>
                  <a href="candidates-details.php?canid=<?php echo ($row->id);?>" target="_blank"
                     class="inline-flex items-center px-3 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 transition-colors">
                    <i class="fas fa-user mr-2"></i> View Profile
                  </a>
                  <a href="app-details.php?jobid=<?php echo ($row->JobId);?> && name=<?php echo htmlentities ($row->FullName);?>&& jsid=<?php echo htmlentities ($row->id);?>" target="_blank"
                     class="inline-flex items-center px-3 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 transition-colors">
                    <i class="fas fa-clipboard-list mr-2"></i> Application Details
                  </a>
                </div>
              </div>
            </div>
          </div>
          <?php $cnt=$cnt+1;}} else { ?>
          <div class="p-10 text-center">
            <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-gray-100 mb-4">
              <i class="fas fa-search text-gray-400 text-xl"></i>
            </div>
            <h3 class="text-lg font-medium text-gray-900 mb-1">No candidates found</h3>
            <p class="text-gray-500">There are no candidates who have applied to your job postings yet.</p>
          </div>
          <?php } ?>
        </div>
        
        <!-- Pagination -->
        <?php if($total_no_of_pages > 1) { ?>
        <div class="px-6 py-4 bg-gray-50 border-t border-gray-100">
          <div class="flex items-center justify-between">
            <div class="text-sm text-gray-500">
              Showing <span class="font-medium"><?php echo $offset + 1 ?></span> to 
              <span class="font-medium"><?php echo min($offset + $no_of_records_per_page, $total_rows) ?></span> of 
              <span class="font-medium"><?php echo $total_rows ?></span> candidates
            </div>
            
            <nav class="inline-flex rounded-md shadow-sm -space-x-px" aria-label="Pagination">
              <?php if($page_no > 1) { ?>
              <a href="?page_no=<?php echo $previous_page ?>" class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                <span class="sr-only">Previous</span>
                <i class="fas fa-chevron-left text-xs"></i>
              </a>
              <?php } else { ?>
              <span class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 bg-gray-100 text-sm font-medium text-gray-400 cursor-not-allowed">
                <span class="sr-only">Previous</span>
                <i class="fas fa-chevron-left text-xs"></i>
              </span>
              <?php } ?>
              
              <?php
              if ($total_no_of_pages <= 10) {
                for ($counter = 1; $counter <= $total_no_of_pages; $counter++) {
                  if ($counter == $page_no) { ?>
                  <span aria-current="page" class="relative inline-flex items-center px-4 py-2 border border-primary bg-primary text-sm font-medium text-white">
                    <?php echo $counter ?>
                  </span>
                  <?php } else { ?>
                  <a href="?page_no=<?php echo $counter ?>" class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50">
                    <?php echo $counter ?>
                  </a>
                  <?php }
                }
              } else {
                // Complex pagination logic for when there are many pages
                if($page_no <= 4) {
                  for ($counter = 1; $counter < 8; $counter++) {
                    if ($counter == $page_no) { ?>
                    <span aria-current="page" class="relative inline-flex items-center px-4 py-2 border border-primary bg-primary text-sm font-medium text-white">
                      <?php echo $counter ?>
                    </span>
                    <?php } else { ?>
                    <a href="?page_no=<?php echo $counter ?>" class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50">
                      <?php echo $counter ?>
                    </a>
                    <?php }
                  } ?>
                  <span class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700">...</span>
                  <a href="?page_no=<?php echo $second_last ?>" class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50">
                    <?php echo $second_last ?>
                  </a>
                  <a href="?page_no=<?php echo $total_no_of_pages ?>" class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50">
                    <?php echo $total_no_of_pages ?>
                  </a>
                <?php } elseif($page_no > 4 && $page_no < $total_no_of_pages - 4) { ?>
                  <a href="?page_no=1" class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50">1</a>
                  <a href="?page_no=2" class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50">2</a>
                  <span class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700">...</span>
                  <?php
                  for ($counter = $page_no - $adjacents; $counter <= $page_no + $adjacents; $counter++) {
                    if ($counter == $page_no) { ?>
                    <span aria-current="page" class="relative inline-flex items-center px-4 py-2 border border-primary bg-primary text-sm font-medium text-white">
                      <?php echo $counter ?>
                    </span>
                    <?php } else { ?>
                    <a href="?page_no=<?php echo $counter ?>" class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50">
                      <?php echo $counter ?>
                    </a>
                    <?php }
                  } ?>
                  <span class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700">...</span>
                  <a href="?page_no=<?php echo $second_last ?>" class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50">
                    <?php echo $second_last ?>
                  </a>
                  <a href="?page_no=<?php echo $total_no_of_pages ?>" class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50">
                    <?php echo $total_no_of_pages ?>
                  </a>
                <?php } else { ?>
                  <a href="?page_no=1" class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50">1</a>
                  <a href="?page_no=2" class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50">2</a>
                  <span class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700">...</span>
                  <?php
                  for ($counter = $total_no_of_pages - 6; $counter <= $total_no_of_pages; $counter++) {
                    if ($counter == $page_no) { ?>
                    <span aria-current="page" class="relative inline-flex items-center px-4 py-2 border border-primary bg-primary text-sm font-medium text-white">
                      <?php echo $counter ?>
                    </span>
                    <?php } else { ?>
                    <a href="?page_no=<?php echo $counter ?>" class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50">
                      <?php echo $counter ?>
                    </a>
                    <?php }
                  }
                }
              }
              ?>
              
              <?php if($page_no < $total_no_of_pages) { ?>
              <a href="?page_no=<?php echo $next_page ?>" class="relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                <span class="sr-only">Next</span>
                <i class="fas fa-chevron-right text-xs"></i>
              </a>
              <?php } else { ?>
              <span class="relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 bg-gray-100 text-sm font-medium text-gray-400 cursor-not-allowed">
                <span class="sr-only">Next</span>
                <i class="fas fa-chevron-right text-xs"></i>
              </span>
              <?php } ?>
            </nav>
          </div>
        </div>
        <?php } ?>
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
  <script src="../js/form.js"></script> 
  <script src="../js/custom.js"></script>
</body>
</html>
<?php }?>

<!-- Done 4 -->
