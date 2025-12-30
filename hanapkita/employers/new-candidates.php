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
  <title>Hanap-Kita - Latest Candidates</title>
  
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

  <!-- Page Hero -->
  <div class="bg-gradient-to-r from-primary-light to-primary py-12 px-4 sm:px-6 lg:px-8 text-center">
    <div class="max-w-7xl mx-auto">
      <h1 class="text-4xl font-bold text-white mb-2">Latest Resumes</h1>
      <p class="text-xl text-white opacity-90">Review and contact qualified candidates who have applied to your jobs</p>
    </div>
  </div>

  <!-- Search Section -->
  <div class="bg-white shadow-sm border-b border-gray-100 py-6">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
      <form action="candidates-search.php" method="post" class="flex flex-col sm:flex-row gap-4">
        <div class="flex-grow">
          <div class="relative rounded-md shadow-sm">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
              <i class="fas fa-search text-gray-400"></i>
            </div>
            <input type="text" name="jobtitle" placeholder="Search by job title" 
                   class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg focus:ring-primary focus:border-primary">
          </div>
        </div>
        <div>
          <button type="submit" name="search" 
                  class="w-full sm:w-auto px-6 py-3 bg-primary text-white font-medium rounded-lg hover:bg-primary-dark focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary transition-colors">
            Search
          </button>
        </div>
      </form>
    </div>
  </div>

  <!-- Main Content -->
  <div class="py-12 bg-gray-50">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="mb-8">
        <h2 class="text-2xl font-bold text-gray-900">Showing Resumes by Applied Candidates</h2>
        <p class="text-gray-600 mt-1">View and manage candidates who have applied to your job listings</p>
      </div>
      
      <!-- Candidates List -->
      <div class="space-y-6">
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
        if($query->rowCount() > 0)
        {
        foreach($results as $row)
        {
        ?>
        <!-- Candidate Card -->
        <div class="bg-white rounded-xl shadow-sm overflow-hidden border border-gray-100 hover:shadow-md transition-shadow">
          <div class="p-6">
            <div class="md:flex items-start">
              <!-- Profile Picture -->
              <div class="flex-shrink-0 mr-6 mb-4 md:mb-0">
                <div class="w-20 h-20 rounded-full overflow-hidden bg-gray-100 border border-gray-200">
                  <?php if($row->ProfilePic==''): ?>
                    <img src="../images/account.png" class="w-full h-full object-cover">
                  <?php else: ?>
                    <img src="../images/<?php echo $row->ProfilePic;?>" class="w-full h-full object-cover">
                  <?php endif; ?>
                </div>
              </div>
              
              <!-- Candidate Info -->
              <div class="flex-grow">
                <div class="flex flex-wrap items-center justify-between mb-2">
                  <h3 class="text-xl font-bold text-gray-900"><?php echo htmlentities($row->FullName);?></h3>
                  
                  <!-- Status Badge -->
                  <div>
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
                
                <p class="text-primary font-medium mb-1">Applied For: <?php echo htmlentities($row->jobTitle);?> (<?php echo htmlentities($row->jobType);?>)</p>
                <p class="text-gray-600 text-sm mb-3">Applied Date: <?php echo htmlentities($row->Applydate);?></p>
                
                <div class="flex flex-wrap gap-4 text-sm text-gray-600 mb-5">
                  <div class="flex items-center">
                    <i class="fas fa-phone text-gray-400 mr-2"></i>
                    <span><?php echo htmlentities($row->ContactNumber);?></span>
                  </div>
                  <div class="flex items-center">
                    <i class="fas fa-envelope text-gray-400 mr-2"></i>
                    <span><?php echo htmlentities($row->EmailId);?></span>
                  </div>
                </div>
                
                <!-- Action Buttons -->
                <div class="flex flex-wrap gap-3">
                  <a href="../Jobseekersresumes/<?php echo htmlentities($row->Resume);?>" target="_blank" 
                     class="inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary transition-colors">
                    <i class="fas fa-file-pdf text-gray-500 mr-2"></i> Resume
                  </a>
                  <a href="candidates-details.php?canid=<?php echo ($row->id);?>" target="_blank" 
                     class="inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary transition-colors">
                    <i class="fas fa-user text-gray-500 mr-2"></i> View Details
                  </a>
                  <a href="app-details.php?jobid=<?php echo ($row->JobId);?> && name=<?php echo htmlentities ($row->FullName);?>&& jsid=<?php echo htmlentities ($row->id);?>" target="_blank" 
                     class="inline-flex items-center px-3 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-primary hover:bg-primary-dark focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary transition-colors">
                    <i class="fas fa-clipboard-check mr-2"></i> Application Details
                  </a>
                </div>
              </div>
            </div>
          </div>
        </div>
        <?php $cnt=$cnt+1;}} else { ?>
        <div class="bg-white rounded-xl shadow-sm p-8 text-center">
          <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-gray-100 mb-4">
            <i class="fas fa-search text-gray-400 text-2xl"></i>
          </div>
          <h4 class="text-xl font-medium text-gray-900 mb-2">No Candidates Found</h4>
          <p class="text-gray-600">There are no candidates that have applied to your job listings yet.</p>
        </div>
        <?php } ?>
      </div>
      
      <!-- Pagination -->
      <?php if($total_no_of_pages > 1): ?>
      <div class="mt-8 flex items-center justify-center">
        <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px" aria-label="Pagination">
          <?php if($page_no > 1): ?>
          <a href="?page_no=<?php echo $previous_page; ?>" class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
            <span class="sr-only">Previous</span>
            <i class="fas fa-chevron-left text-xs"></i>
          </a>
          <?php else: ?>
          <span class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 bg-gray-100 text-sm font-medium text-gray-400 cursor-not-allowed">
            <span class="sr-only">Previous</span>
            <i class="fas fa-chevron-left text-xs"></i>
          </span>
          <?php endif; ?>
          
          <?php
          if ($total_no_of_pages <= 10) {
            for ($counter = 1; $counter <= $total_no_of_pages; $counter++) {
              if ($counter == $page_no) {
                echo '<span class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-primary text-sm font-medium text-white">'.$counter.'</span>';
              } else {
                echo '<a href="?page_no='.$counter.'" class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50">'.$counter.'</a>';
              }
            }
          } elseif ($total_no_of_pages > 10) {
            // Logic for showing pagination when total pages are more than 10
            if($page_no <= 4) {
              for ($counter = 1; $counter < 8; $counter++) {
                if ($counter == $page_no) {
                  echo '<span class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-primary text-sm font-medium text-white">'.$counter.'</span>';
                } else {
                  echo '<a href="?page_no='.$counter.'" class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50">'.$counter.'</a>';
                }
              }
              echo '<span class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700">...</span>';
              echo '<a href="?page_no='.$second_last.'" class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50">'.$second_last.'</a>';
              echo '<a href="?page_no='.$total_no_of_pages.'" class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50">'.$total_no_of_pages.'</a>';
            } elseif($page_no > 4 && $page_no < $total_no_of_pages - 4) {
              echo '<a href="?page_no=1" class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50">1</a>';
              echo '<a href="?page_no=2" class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50">2</a>';
              echo '<span class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700">...</span>';
              
              for ($counter = $page_no - $adjacents; $counter <= $page_no + $adjacents; $counter++) {
                if ($counter == $page_no) {
                  echo '<span class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-primary text-sm font-medium text-white">'.$counter.'</span>';
                } else {
                  echo '<a href="?page_no='.$counter.'" class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50">'.$counter.'</a>';
                }
              }
              
              echo '<span class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700">...</span>';
              echo '<a href="?page_no='.$second_last.'" class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50">'.$second_last.'</a>';
              echo '<a href="?page_no='.$total_no_of_pages.'" class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50">'.$total_no_of_pages.'</a>';
            } else {
              echo '<a href="?page_no=1" class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50">1</a>';
              echo '<a href="?page_no=2" class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50">2</a>';
              echo '<span class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700">...</span>';
              
              for ($counter = $total_no_of_pages - 6; $counter <= $total_no_of_pages; $counter++) {
                if ($counter == $page_no) {
                  echo '<span class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-primary text-sm font-medium text-white">'.$counter.'</span>';
                } else {
                  echo '<a href="?page_no='.$counter.'" class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50">'.$counter.'</a>';
                }
              }
            }
          }
          ?>
          
          <?php if($page_no < $total_no_of_pages): ?>
          <a href="?page_no=<?php echo $next_page; ?>" class="relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
            <span class="sr-only">Next</span>
            <i class="fas fa-chevron-right text-xs"></i>
          </a>
          <?php else: ?>
          <span class="relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 bg-gray-100 text-sm font-medium text-gray-400 cursor-not-allowed">
            <span class="sr-only">Next</span>
            <i class="fas fa-chevron-right text-xs"></i>
          </span>
          <?php endif; ?>
        </nav>
      </div>
      <?php endif; ?>
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

<!-- Done 20 -->