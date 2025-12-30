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
  if(isset($_GET['del']))
{
$id=$_GET['del'];
$sql = "delete from tbljobs  WHERE jobId=:id";
$query = $dbh->prepare($sql);
$query -> bindParam(':id',$id, PDO::PARAM_STR);
$query -> execute();
$msg="Job Deleted Successfully";
}
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Job Listings | Hanap-Kita</title>
  
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
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <!-- Page Title & Actions -->
      <div class="mb-10 flex flex-col md:flex-row md:items-center md:justify-between">
        <div>
          <h1 class="text-3xl font-bold text-gray-900">Manage Job Listings</h1>
          <p class="mt-2 text-lg text-gray-600">View, edit, and manage all your job postings</p>
        </div>
        <div class="mt-4 md:mt-0">
          <a href="post-job.php" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-primary hover:bg-primary-dark focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary transition-colors">
            <i class="fas fa-plus-circle mr-2"></i> Post New Job
          </a>
        </div>
      </div>
      
      <!-- Success/Error Messages -->
      <?php if(@$error){ ?>
      <div class="mb-6 rounded-lg bg-red-50 p-4 border-l-4 border-red-400">
        <div class="flex items-center">
          <div class="flex-shrink-0">
            <i class="fas fa-exclamation-circle text-red-500"></i>
          </div>
          <div class="ml-3">
            <p class="text-sm text-red-700">
              <strong>ERROR:</strong> <?php echo htmlentities($error);?>
            </p>
          </div>
        </div>
      </div>
      <?php } ?>
      
      <?php if(@$msg){ ?>
      <div class="mb-6 rounded-lg bg-green-50 p-4 border-l-4 border-green-400">
        <div class="flex items-center">
          <div class="flex-shrink-0">
            <i class="fas fa-check-circle text-green-500"></i>
          </div>
          <div class="ml-3">
            <p class="text-sm text-green-700">
              <strong>Success:</strong> <?php echo htmlentities($msg);?>
            </p>
          </div>
        </div>
      </div>
      <?php } ?>
      
      <!-- Jobs Table Card -->
      <div class="bg-white rounded-xl shadow-sm overflow-hidden">
        <div class="px-6 py-5 border-b border-gray-100">
          <h2 class="text-xl font-semibold text-gray-900">Your Posted Jobs</h2>
        </div>
        
        <div class="overflow-x-auto">
          <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
              <tr>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">#</th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Job Title</th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Job Type</th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Creation Date</th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Expiry Date</th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
              </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
              <?php
              // Get Employer Id
              $empid=$_SESSION['emplogin'];
              if (isset($_GET['page_no']) && $_GET['page_no']!="") {
                $page_no = $_GET['page_no'];
              } else {
                $page_no = 1;
              }
              
              // Formula for pagination
              $no_of_records_per_page = 10;
              $offset = ($page_no-1) * $no_of_records_per_page;
              $previous_page = $page_no - 1;
              $next_page = $page_no + 1;
              $adjacents = "2";
              
              // Get total records
              $sql = "SELECT jobId from tbljobs where employerId=:empid";
              $query = $dbh -> prepare($sql);
              $query->bindParam(':empid',$empid,PDO::PARAM_STR);
              $query->execute();
              $results=$query->fetchAll(PDO::FETCH_OBJ);
              $total_rows=$query->rowCount();
              $total_no_of_pages = ceil($total_rows / $no_of_records_per_page);
              $second_last = $total_no_of_pages - 1;
              
              // Fetch jobs with pagination
              $sql = "SELECT tbljobs.* from tbljobs where employerId=:empid order by jobId desc LIMIT $offset, $no_of_records_per_page";
              $query = $dbh -> prepare($sql);
              $query->bindParam(':empid',$empid,PDO::PARAM_STR);
              $query->execute();
              $results=$query->fetchAll(PDO::FETCH_OBJ);
              
              $cnt=1;
              if($query->rowCount() > 0) {
                foreach($results as $result) {
              ?>
              <tr>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?php echo htmlentities($cnt);?></td>
                <td class="px-6 py-4 whitespace-nowrap">
                  <span class="text-sm font-medium text-gray-900"><?php echo htmlentities($result->jobTitle);?></span>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                  <span class="text-sm text-gray-500"><?php echo htmlentities($result->jobType);?></span>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                  <?php echo htmlentities($result->postinDate);?>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                  <?php echo htmlentities($result->JobExpdate);?>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                  <?php if($result->isActive==1) { ?>
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                      Active
                    </span>
                  <?php } elseif($result->isActive==0) { ?>
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                      Inactive
                    </span>
                  <?php } else { ?>
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                      Job Filled
                    </span>
                  <?php } ?>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-2">
                  <a href="edit-job.php?jobid=<?php echo ($result->jobId);?>" class="text-indigo-600 hover:text-indigo-900">
                    <i class="fas fa-edit"></i> Edit
                  </a>
                  <a href="job-listing.php?del=<?php echo ($result->jobId);?>" class="text-red-600 hover:text-red-900" onclick="return confirm('Do you want to delete this job?');">
                    <i class="fas fa-trash-alt"></i> Delete
                  </a>
                  <a href="job-details.php?jobid=<?php echo ($result->jobId);?>" class="text-gray-600 hover:text-gray-900">
                    <i class="fas fa-eye"></i> View
                  </a>
                </td>
              </tr>
              <?php 
                $cnt=$cnt+1;
                }
              } else { ?>
              <tr>
                <td colspan="7" class="px-6 py-4 text-center text-sm text-gray-500">
                  No job listings found. <a href="post-job.php" class="text-primary hover:underline">Post your first job now</a>.
                </td>
              </tr>
              <?php } ?>
            </tbody>
          </table>
        </div>
        
        <!-- Pagination -->
        <?php if($total_no_of_pages > 1) { ?>
        <div class="px-6 py-4 bg-white border-t border-gray-200">
          <div class="flex items-center justify-between">
            <div class="flex-1 flex justify-between sm:hidden">
              <?php if($page_no > 1){ ?>
              <a href="?page_no=<?php echo $previous_page; ?>" class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                Previous
              </a>
              <?php } else { ?>
              <span class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-500 bg-gray-100 cursor-not-allowed">
                Previous
              </span>
              <?php } ?>
              
              <?php if($page_no < $total_no_of_pages){ ?>
              <a href="?page_no=<?php echo $next_page; ?>" class="ml-3 relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                Next
              </a>
              <?php } else { ?>
              <span class="ml-3 relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-500 bg-gray-100 cursor-not-allowed">
                Next
              </span>
              <?php } ?>
            </div>
            
            <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-center">
              <div>
                <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px" aria-label="Pagination">
                  <?php if($page_no > 1){ ?>
                  <a href="?page_no=<?php echo $previous_page; ?>" class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
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
                  if ($total_no_of_pages <= 10){
                    for ($counter = 1; $counter <= $total_no_of_pages; $counter++){
                      if ($counter == $page_no) { ?>
                  <span class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-primary text-sm font-medium text-white">
                    <?php echo $counter; ?>
                  </span>
                  <?php } else { ?>
                  <a href="?page_no=<?php echo $counter; ?>" class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50">
                    <?php echo $counter; ?>
                  </a>
                  <?php }
                    }
                  } elseif ($total_no_of_pages > 10) {
                    if ($page_no <= 4) {
                      for ($counter = 1; $counter < 8; $counter++) {
                        if ($counter == $page_no) { ?>
                  <span class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-primary text-sm font-medium text-white">
                    <?php echo $counter; ?>
                  </span>
                  <?php } else { ?>
                  <a href="?page_no=<?php echo $counter; ?>" class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50">
                    <?php echo $counter; ?>
                  </a>
                  <?php }
                      }
                  ?>
                  <span class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700">
                    ...
                  </span>
                  <a href="?page_no=<?php echo $second_last; ?>" class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50">
                    <?php echo $second_last; ?>
                  </a>
                  <a href="?page_no=<?php echo $total_no_of_pages; ?>" class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50">
                    <?php echo $total_no_of_pages; ?>
                  </a>
                  <?php
                    } elseif ($page_no > 4 && $page_no < $total_no_of_pages - 4) {
                  ?>
                  <a href="?page_no=1" class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50">
                    1
                  </a>
                  <a href="?page_no=2" class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50">
                    2
                  </a>
                  <span class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700">
                    ...
                  </span>
                  <?php
                      for ($counter = $page_no - $adjacents; $counter <= $page_no + $adjacents; $counter++) {
                        if ($counter == $page_no) { ?>
                  <span class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-primary text-sm font-medium text-white">
                    <?php echo $counter; ?>
                  </span>
                  <?php } else { ?>
                  <a href="?page_no=<?php echo $counter; ?>" class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50">
                    <?php echo $counter; ?>
                  </a>
                  <?php }
                      }
                  ?>
                  <span class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700">
                    ...
                  </span>
                  <a href="?page_no=<?php echo $second_last; ?>" class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50">
                    <?php echo $second_last; ?>
                  </a>
                  <a href="?page_no=<?php echo $total_no_of_pages; ?>" class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50">
                    <?php echo $total_no_of_pages; ?>
                  </a>
                  <?php
                    } else {
                  ?>
                  <a href="?page_no=1" class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50">
                    1
                  </a>
                  <a href="?page_no=2" class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50">
                    2
                  </a>
                  <span class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700">
                    ...
                  </span>
                  <?php
                      for ($counter = $total_no_of_pages - 6; $counter <= $total_no_of_pages; $counter++) {
                        if ($counter == $page_no) { ?>
                  <span class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-primary text-sm font-medium text-white">
                    <?php echo $counter; ?>
                  </span>
                  <?php } else { ?>
                  <a href="?page_no=<?php echo $counter; ?>" class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50">
                    <?php echo $counter; ?>
                  </a>
                  <?php }
                      }
                    }
                  }
                  ?>
                  
                  <?php if($page_no < $total_no_of_pages){ ?>
                  <a href="?page_no=<?php echo $next_page; ?>" class="relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
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
<?php } ?>

<!-- Done 17 -->
 