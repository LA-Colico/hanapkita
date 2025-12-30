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
else{?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Candidates Reports | Hanap-Kita</title>
  
  <!-- Tailwind CSS -->
  <script src="https://cdn.tailwindcss.com"></script>
  <!-- Font Awesome -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
  <!-- Chart.js for Graphs -->
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <!-- SheetJS for Excel Export -->
  <script src="https://cdn.jsdelivr.net/npm/xlsx@0.18.5/dist/xlsx.full.min.js"></script>
  <!-- html2pdf.js for PDF Export -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
  
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
  
  <style>
    @media print {
      .no-print {
        display: none;
      }
      .print-only {
        display: block;
      }
    }
    .print-only {
      display: none;
    }
  </style>
</head>

<body class="bg-gray-50 text-gray-900 font-sans">
  <!-- Header -->
  <header class="bg-white shadow-sm border-b border-gray-100 sticky top-0 z-50 no-print">
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
          <a href="candidates-reports.php" class="text-primary font-medium transition-colors">Reports</a>
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
      <?php
      $fdate=$_POST['fromdate'];
      $tdate=$_POST['todate'];
      ?>
      
      <!-- Page Title -->
      <div class="mb-10 text-center">
        <h1 class="text-3xl font-bold text-gray-900">Candidates Report</h1>
        <p class="mt-2 text-lg text-gray-600">Report from <?php echo date('M d, Y', strtotime($fdate))?> to <?php echo date('M d, Y', strtotime($tdate))?></p>
      </div>
      
      <!-- Export Options and Stats Cards -->
      <div class="mb-8 no-print">
        <div class="flex flex-wrap justify-between items-center gap-4 mb-6">
          <!-- Export Buttons -->
          <div class="flex space-x-3">
            <button onclick="exportToExcel()" class="inline-flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg shadow-sm transition-colors">
              <i class="fas fa-file-excel mr-2"></i> Export to Excel
            </button>
            <button onclick="window.print()" class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg shadow-sm transition-colors">
              <i class="fas fa-print mr-2"></i> Print
            </button>
          </div>
          
          <!-- Search Input -->
          <div class="relative">
            <input type="text" id="searchInput" placeholder="Search candidates..." 
                   class="pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-primary focus:border-primary">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
              <i class="fas fa-search text-gray-400"></i>
            </div>
          </div>
        </div>
        
        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
          <?php
          $eid=$_SESSION['emplogin'];
          
          // Total Applications
          $sql = "SELECT COUNT(*) as total FROM tblapplyjob JOIN tbljobs ON tblapplyjob.JobId=tbljobs.jobId WHERE tbljobs.employerId=:eid AND date(tblapplyjob.Applydate) BETWEEN :fdate AND :tdate";
          $query = $dbh->prepare($sql);
          $query->bindParam(':eid', $eid, PDO::PARAM_STR);
          $query->bindParam(':fdate', $fdate, PDO::PARAM_STR);
          $query->bindParam(':tdate', $tdate, PDO::PARAM_STR);
          $query->execute();
          $totalApplications = $query->fetch(PDO::FETCH_OBJ)->total;
          
          // Hired Candidates
          $sql = "SELECT COUNT(*) as total FROM tblapplyjob JOIN tbljobs ON tblapplyjob.JobId=tbljobs.jobId WHERE tbljobs.employerId=:eid AND tblapplyjob.Status='Hired' AND date(tblapplyjob.Applydate) BETWEEN :fdate AND :tdate";
          $query = $dbh->prepare($sql);
          $query->bindParam(':eid', $eid, PDO::PARAM_STR);
          $query->bindParam(':fdate', $fdate, PDO::PARAM_STR);
          $query->bindParam(':tdate', $tdate, PDO::PARAM_STR);
          $query->execute();
          $hiredCandidates = $query->fetch(PDO::FETCH_OBJ)->total;
          
          // Shortlisted Candidates
          $sql = "SELECT COUNT(*) as total FROM tblapplyjob JOIN tbljobs ON tblapplyjob.JobId=tbljobs.jobId WHERE tbljobs.employerId=:eid AND tblapplyjob.Status='Sort Listed' AND date(tblapplyjob.Applydate) BETWEEN :fdate AND :tdate";
          $query = $dbh->prepare($sql);
          $query->bindParam(':eid', $eid, PDO::PARAM_STR);
          $query->bindParam(':fdate', $fdate, PDO::PARAM_STR);
          $query->bindParam(':tdate', $tdate, PDO::PARAM_STR);
          $query->execute();
          $shortlistedCandidates = $query->fetch(PDO::FETCH_OBJ)->total;
          
          // Rejected Candidates
          $sql = "SELECT COUNT(*) as total FROM tblapplyjob JOIN tbljobs ON tblapplyjob.JobId=tbljobs.jobId WHERE tbljobs.employerId=:eid AND tblapplyjob.Status='Rejected' AND date(tblapplyjob.Applydate) BETWEEN :fdate AND :tdate";
          $query = $dbh->prepare($sql);
          $query->bindParam(':eid', $eid, PDO::PARAM_STR);
          $query->bindParam(':fdate', $fdate, PDO::PARAM_STR);
          $query->bindParam(':tdate', $tdate, PDO::PARAM_STR);
          $query->execute();
          $rejectedCandidates = $query->fetch(PDO::FETCH_OBJ)->total;
          ?>
          
          <div class="bg-white rounded-xl shadow-sm p-5 border-l-4 border-blue-500">
            <h3 class="text-gray-500 text-sm font-medium">Total Applications</h3>
            <div class="mt-1 flex items-baseline justify-between">
              <h2 class="text-3xl font-semibold text-gray-900"><?php echo $totalApplications; ?></h2>
              <div class="bg-blue-100 p-2 rounded-full">
                <i class="fas fa-users text-blue-500"></i>
              </div>
            </div>
          </div>
          
          <div class="bg-white rounded-xl shadow-sm p-5 border-l-4 border-green-500">
            <h3 class="text-gray-500 text-sm font-medium">Hired</h3>
            <div class="mt-1 flex items-baseline justify-between">
              <h2 class="text-3xl font-semibold text-gray-900"><?php echo $hiredCandidates; ?></h2>
              <div class="bg-green-100 p-2 rounded-full">
                <i class="fas fa-user-check text-green-500"></i>
              </div>
            </div>
          </div>
          
          <div class="bg-white rounded-xl shadow-sm p-5 border-l-4 border-yellow-500">
            <h3 class="text-gray-500 text-sm font-medium">Shortlisted</h3>
            <div class="mt-1 flex items-baseline justify-between">
              <h2 class="text-3xl font-semibold text-gray-900"><?php echo $shortlistedCandidates; ?></h2>
              <div class="bg-yellow-100 p-2 rounded-full">
                <i class="fas fa-list-check text-yellow-500"></i>
              </div>
            </div>
          </div>
          
          <div class="bg-white rounded-xl shadow-sm p-5 border-l-4 border-red-500">
            <h3 class="text-gray-500 text-sm font-medium">Rejected</h3>
            <div class="mt-1 flex items-baseline justify-between">
              <h2 class="text-3xl font-semibold text-gray-900"><?php echo $rejectedCandidates; ?></h2>
              <div class="bg-red-100 p-2 rounded-full">
                <i class="fas fa-user-times text-red-500"></i>
              </div>
            </div>
          </div>
        </div>
        
        <!-- Summary Section -->
        <div class="bg-white rounded-xl shadow-sm p-6 mb-8">
          <h3 class="text-lg font-semibold text-gray-900 mb-4">Report Summary</h3>
          <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
              <p class="text-gray-600 mb-1">Total Date Range:</p>
              <p class="font-medium"><?php echo date('M d, Y', strtotime($fdate))?> to <?php echo date('M d, Y', strtotime($tdate))?></p>
              
              <p class="text-gray-600 mt-4 mb-1">Total Applications:</p>
              <p class="font-medium"><?php echo $totalApplications; ?> candidates</p>
            </div>
            
            <div>
              <p class="text-gray-600 mb-1">Status Breakdown:</p>
              <ul class="space-y-2">
                <li class="flex items-center">
                  <span class="inline-block w-3 h-3 bg-green-500 rounded-full mr-2"></span>
                  <span>Hired: <?php echo $hiredCandidates; ?> candidates</span>
                </li>
                <li class="flex items-center">
                  <span class="inline-block w-3 h-3 bg-blue-500 rounded-full mr-2"></span>
                  <span>Shortlisted: <?php echo $shortlistedCandidates; ?> candidates</span>
                </li>
                <li class="flex items-center">
                  <span class="inline-block w-3 h-3 bg-red-500 rounded-full mr-2"></span>
                  <span>Rejected: <?php echo $rejectedCandidates; ?> candidates</span>
                </li>
                <li class="flex items-center">
                  <span class="inline-block w-3 h-3 bg-gray-400 rounded-full mr-2"></span>
                  <span>Not Responded: <?php echo $totalApplications - ($shortlistedCandidates + $hiredCandidates + $rejectedCandidates); ?> candidates</span>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </div>
      
      <!-- Candidates List Card -->
      <div class="bg-white rounded-xl shadow-sm overflow-hidden mb-8" id="candidatesTable">
        <div class="border-b border-gray-100 bg-gradient-to-r from-primary-light to-primary px-6 py-4 flex justify-between items-center">
          <h2 class="text-xl font-semibold text-white">Candidates List</h2>
          <div class="text-white text-sm">
            Showing <?php echo isset($_GET['page_no']) ? $_GET['page_no'] : 1; ?> of 
            <?php 
            $eid=$_SESSION['emplogin'];
            $ret = "SELECT COUNT(*) as total FROM tblapplyjob join tbljobs on tblapplyjob.JobId=tbljobs.jobId join tbljobseekers on tblapplyjob.UserId=tbljobseekers.id where tbljobs.employerId=:eid && date(tblapplyjob.Applydate) between :fdate and :tdate";
            $query1 = $dbh->prepare($ret);
            $query1->bindParam(':eid', $eid, PDO::PARAM_STR);
            $query1->bindParam(':fdate', $fdate, PDO::PARAM_STR);
            $query1->bindParam(':tdate', $tdate, PDO::PARAM_STR);
            $query1->execute();
            $row = $query1->fetch(PDO::FETCH_OBJ);
            $total_pages = ceil($row->total / 5);
            echo $total_pages;
            ?> pages
          </div>
        </div>
        
        <div class="overflow-x-auto">
          <table class="min-w-full divide-y divide-gray-200" id="dataTable">
            <thead class="bg-gray-50">
              <tr>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Candidate</th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Applied For</th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Contact</th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Apply Date</th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider no-print">Actions</th>
              </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200" id="tableBody">
              <?php
              $eid=$_SESSION['emplogin'];
              if (isset($_GET['page_no']) && $_GET['page_no']!="") {
                $page_no = $_GET['page_no'];
              } else {
                $page_no = 1;
              }
              
              $no_of_records_per_page = 5;
              $offset = ($page_no-1) * $no_of_records_per_page;
              $previous_page = $page_no - 1;
              $next_page = $page_no + 1;
              $adjacents = "2";
              
              $sql="SELECT tbljobseekers.*,tbljobs.*,tblapplyjob.Status, tblapplyjob.UserId, tblapplyjob.JobId,tblapplyjob.Applydate, tblapplyjob.ResponseDate from tblapplyjob join tbljobs on tblapplyjob.JobId=tbljobs.jobId join tbljobseekers on tblapplyjob.UserId=tbljobseekers.id where tbljobs.employerId=:eid && date(tblapplyjob.Applydate) between :fdate and :tdate LIMIT $offset, $no_of_records_per_page";
              $query = $dbh->prepare($sql);
              $query->bindParam(':eid', $eid, PDO::PARAM_STR);
              $query->bindParam(':fdate', $fdate, PDO::PARAM_STR);
              $query->bindParam(':tdate', $tdate, PDO::PARAM_STR);
              $query->execute();
              $results=$query->fetchAll(PDO::FETCH_OBJ);
              
              $cnt=1;
              if($query->rowCount() > 0) {
                foreach($results as $row) { 
              ?>
              <tr>
                <td class="px-6 py-4">
                  <div class="flex items-center">
                    <div class="flex-shrink-0 h-10 w-10">
                      <?php if($row->ProfilePic==''): ?>
                        <img class="h-10 w-10 rounded-full object-cover" src="../images/account.png" alt="Profile">
                      <?php else: ?>
                        <img class="h-10 w-10 rounded-full object-cover" src="../images/<?php echo $row->ProfilePic;?>" alt="Profile">
                      <?php endif; ?>
                    </div>
                    <div class="ml-4">
                      <div class="text-sm font-medium text-gray-900"><?php echo htmlentities($row->FullName);?></div>
                      <div class="text-sm text-gray-500"><?php echo htmlentities($row->EmailId);?></div>
                    </div>
                  </div>
                </td>
                <td class="px-6 py-4">
                  <div class="text-sm text-gray-900"><?php echo htmlentities($row->jobTitle);?></div>
                  <div class="text-sm text-gray-500"><?php echo htmlentities($row->jobType);?></div>
                </td>
                <td class="px-6 py-4">
                  <div class="text-sm text-gray-900"><?php echo htmlentities($row->ContactNumber);?></div>
                </td>
                <td class="px-6 py-4">
                  <div class="text-sm text-gray-900"><?php echo date('M d, Y', strtotime($row->Applydate));?></div>
                </td>
                <td class="px-6 py-4">
                  <?php if($row->Status==""): ?>
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                      Not Responded
                    </span>
                  <?php elseif($row->Status=="Sort Listed"): ?>
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                      Shortlisted
                    </span>
                  <?php elseif($row->Status=="Hired"): ?>
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                      Hired
                    </span>
                  <?php elseif($row->Status=="Rejected"): ?>
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                      Rejected
                    </span>
                  <?php else: ?>
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                      <?php echo htmlentities($row->Status);?>
                    </span>
                  <?php endif; ?>
                </td>
                <td class="px-6 py-4 text-sm font-medium no-print">
                  <div class="flex space-x-2">
                    <a href="../Jobseekersresumes/<?php echo htmlentities($row->Resume);?>" target="_blank" 
                       class="text-indigo-600 hover:text-indigo-900" title="View Resume">
                      <i class="fas fa-file-alt"></i>
                    </a>
                    <a href="candidates-details.php?canid=<?php echo ($row->id);?>" target="_blank" 
                       class="text-blue-600 hover:text-blue-900" title="View Profile">
                      <i class="fas fa-user"></i>
                    </a>
                    <a href="app-details.php?jobid=<?php echo ($row->JobId);?>&name=<?php echo htmlentities($row->FullName);?>&jsid=<?php echo htmlentities($row->id);?>" target="_blank" 
                       class="text-green-600 hover:text-green-900" title="Application Details">
                      <i class="fas fa-clipboard-check"></i>
                    </a>
                  </div>
                </td>
              </tr>
              <?php $cnt++; } } else { ?>
              <tr>
                <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                  No records found for the selected date range
                </td>
              </tr>
              <?php } ?>
            </tbody>
          </table>
        </div>
        
        <!-- Pagination -->
        <?php if($query->rowCount() > 0) { ?>
        <div class="bg-white px-4 py-3 flex items-center justify-between border-t border-gray-200 sm:px-6 no-print">
          <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
            <div>
              <p class="text-sm text-gray-700">
                Showing <span class="font-medium"><?php echo $offset + 1; ?></span> to 
                <span class="font-medium"><?php echo min($offset + $no_of_records_per_page, $row->total); ?></span> of 
                <span class="font-medium"><?php echo $row->total; ?></span> results
              </p>
            </div>
            <div>
              <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px" aria-label="Pagination">
                <?php if($page_no > 1) { ?>
                <a href="?page_no=1" class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                  <span class="sr-only">First</span>
                  <i class="fas fa-angle-double-left"></i>
                </a>
                <?php } ?>
                
                <a <?php if($page_no > 1) { echo "href='?page_no=$previous_page'"; } ?> 
                   class="<?php if($page_no <= 1){ echo "opacity-50 cursor-not-allowed"; } ?> relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50">
                  Previous
                </a>
                
                <?php
                if ($total_pages <= 10) {
                  for ($counter = 1; $counter <= $total_pages; $counter++) {
                    if ($counter == $page_no) {
                      echo "<a class='relative inline-flex items-center px-4 py-2 border border-gray-300 bg-primary text-sm font-medium text-white'>$counter</a>";
                    } else {
                      echo "<a href='?page_no=$counter' class='relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50'>$counter</a>";
                    }
                  }
                } elseif ($total_pages > 10) {
                  // Implementation for when there are more than 10 pages
                  // (This is complex pagination logic which I'm simplifying here)
                  for ($counter = max(1, $page_no - 2); $counter <= min($page_no + 2, $total_pages); $counter++) {
                    if ($counter == $page_no) {
                      echo "<a class='relative inline-flex items-center px-4 py-2 border border-gray-300 bg-primary text-sm font-medium text-white'>$counter</a>";
                    } else {
                      echo "<a href='?page_no=$counter' class='relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50'>$counter</a>";
                    }
                  }
                }
                ?>
                
                <a <?php if($page_no < $total_pages) { echo "href='?page_no=$next_page'"; } ?> 
                   class="<?php if($page_no >= $total_pages){ echo "opacity-50 cursor-not-allowed"; } ?> relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50">
                  Next
                </a>
                
                <?php if($page_no < $total_pages) { ?>
                <a href="?page_no=<?php echo $total_pages; ?>" class="relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                  <span class="sr-only">Last</span>
                  <i class="fas fa-angle-double-right"></i>
                </a>
                <?php } ?>
              </nav>
            </div>
          </div>
        </div>
        <?php } ?>
      </div>
      
      <!-- Print-only version of data -->
      <div class="print-only" id="printContent">
        <div class="text-center mb-8">
          <h1 class="text-2xl font-bold">Candidates Report</h1>
          <p>From <?php echo date('M d, Y', strtotime($fdate))?> to <?php echo date('M d, Y', strtotime($tdate))?></p>
        </div>
        
        <!-- Summary section -->
        <div id="pdfSummary" class="mb-6"></div>
        
        <!-- Print-friendly table -->
        <table class="min-w-full border border-gray-300">
          <thead>
            <tr>
              <th class="border border-gray-300 px-4 py-2">Name</th>
              <th class="border border-gray-300 px-4 py-2">Email</th>
              <th class="border border-gray-300 px-4 py-2">Contact</th>
              <th class="border border-gray-300 px-4 py-2">Job Title</th>
              <th class="border border-gray-300 px-4 py-2">Apply Date</th>
              <th class="border border-gray-300 px-4 py-2">Status</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $sql="SELECT tbljobseekers.*,tbljobs.*,tblapplyjob.Status, tblapplyjob.UserId, tblapplyjob.JobId,tblapplyjob.Applydate, tblapplyjob.ResponseDate from tblapplyjob join tbljobs on tblapplyjob.JobId=tbljobs.jobId join tbljobseekers on tblapplyjob.UserId=tbljobseekers.id where tbljobs.employerId=:eid && date(tblapplyjob.Applydate) between :fdate and :tdate ORDER BY tblapplyjob.Applydate DESC";
            $query = $dbh->prepare($sql);
            $query->bindParam(':eid', $eid, PDO::PARAM_STR);
            $query->bindParam(':fdate', $fdate, PDO::PARAM_STR);
            $query->bindParam(':tdate', $tdate, PDO::PARAM_STR);
            $query->execute();
            $printResults=$query->fetchAll(PDO::FETCH_OBJ);
            
            if($query->rowCount() > 0) {
              foreach($printResults as $row) {
            ?>
            <tr>
              <td class="border border-gray-300 px-4 py-2"><?php echo htmlentities($row->FullName);?></td>
              <td class="border border-gray-300 px-4 py-2"><?php echo htmlentities($row->EmailId);?></td>
              <td class="border border-gray-300 px-4 py-2"><?php echo htmlentities($row->ContactNumber);?></td>
              <td class="border border-gray-300 px-4 py-2"><?php echo htmlentities($row->jobTitle);?> (<?php echo htmlentities($row->jobType);?>)</td>
              <td class="border border-gray-300 px-4 py-2"><?php echo date('M d, Y', strtotime($row->Applydate));?></td>
              <td class="border border-gray-300 px-4 py-2">
                <?php echo ($row->Status=="") ? "Not Responded" : htmlentities($row->Status); ?>
              </td>
            </tr>
            <?php } } else { ?>
            <tr>
              <td colspan="6" class="border border-gray-300 px-4 py-2 text-center">No records found</td>
            </tr>
            <?php } ?>
          </tbody>
        </table>
        
        <div class="mt-4 text-right text-sm">
          <p>Report generated on: <?php echo date('F d, Y h:i A'); ?></p>
        </div>
      </div>
    </div>
  </div>
  
  <!-- Footer -->
  <footer class="bg-gray-900 text-white py-12 no-print">
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

  <!-- JavaScript for Chart Generation and Export Functions -->
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      // Status Distribution Chart
      const statusCtx = document.getElementById('statusChart');
      if (statusCtx) {
        const statusChart = new Chart(statusCtx, {
          type: 'doughnut',
          data: {
            labels: ['Not Responded', 'Shortlisted', 'Hired', 'Rejected'],
            datasets: [{
              data: [
                <?php echo $totalApplications - ($shortlistedCandidates + $hiredCandidates + $rejectedCandidates); ?>,
                <?php echo $shortlistedCandidates; ?>, 
                <?php echo $hiredCandidates; ?>, 
                <?php echo $rejectedCandidates; ?>
              ],
              backgroundColor: [
                'rgba(209, 213, 219, 0.8)',
                'rgba(59, 130, 246, 0.8)',
                'rgba(16, 185, 129, 0.8)',
                'rgba(239, 68, 68, 0.8)'
              ],
              borderColor: [
                'rgba(209, 213, 219, 1)',
                'rgba(59, 130, 246, 1)',
                'rgba(16, 185, 129, 1)',
                'rgba(239, 68, 68, 1)'
              ],
              borderWidth: 1
            }]
          },
          options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
              legend: {
                position: 'bottom'
              }
            }
          }
        });
      }
      
      // Search functionality
      document.getElementById('searchInput').addEventListener('keyup', function() {
        const searchValue = this.value.toLowerCase();
        const tableRows = document.getElementById('tableBody').getElementsByTagName('tr');
        
        for (let i = 0; i < tableRows.length; i++) {
          const rowText = tableRows[i].textContent.toLowerCase();
          tableRows[i].style.display = rowText.includes(searchValue) ? '' : 'none';
        }
      });
    });
    
    // Export to Excel function
    function exportToExcel() {
      // Create a workbook with a worksheet
      const wb = XLSX.utils.book_new();
      
      // Get data from all candidates (not just visible ones)
      <?php
      $sql="SELECT tbljobseekers.FullName, tbljobseekers.EmailId, tbljobseekers.ContactNumber, tbljobs.jobTitle, tbljobs.jobType, tblapplyjob.Applydate, tblapplyjob.Status FROM tblapplyjob join tbljobs on tblapplyjob.JobId=tbljobs.jobId join tbljobseekers on tblapplyjob.UserId=tbljobseekers.id where tbljobs.employerId=:eid && date(tblapplyjob.Applydate) between :fdate and :tdate ORDER BY tblapplyjob.Applydate DESC";
      $query = $dbh->prepare($sql);
      $query->bindParam(':eid', $eid, PDO::PARAM_STR);
      $query->bindParam(':fdate', $fdate, PDO::PARAM_STR);
      $query->bindParam(':tdate', $tdate, PDO::PARAM_STR);
      $query->execute();
      $excelData = $query->fetchAll(PDO::FETCH_ASSOC);
      ?>
      
      // Convert PHP data to JavaScript
      const excelRows = <?php echo json_encode($excelData); ?>;
      
      // Create headers row
      const headers = [
        'Full Name', 'Email', 'Contact', 'Job Title', 'Job Type', 'Apply Date', 'Status'
      ];
      
      // Format data for Excel
      const data = [
        headers,
        ...excelRows.map(row => [
          row.FullName,
          row.EmailId,
          row.ContactNumber, 
          row.jobTitle,
          row.jobType,
          new Date(row.Applydate).toLocaleDateString(),
          row.Status === "" ? "Not Responded" : row.Status
        ])
      ];
      
      // Add a summary section
      data.push([]);
      data.push(['Report Summary']);
      data.push(['Date Range:', '<?php echo date('M d, Y', strtotime($fdate))?> to <?php echo date('M d, Y', strtotime($tdate))?>']);
      data.push(['Total Applications:', '<?php echo $totalApplications; ?>']);
      data.push(['Hired:', '<?php echo $hiredCandidates; ?>']);
      data.push(['Shortlisted:', '<?php echo $shortlistedCandidates; ?>']);
      data.push(['Rejected:', '<?php echo $rejectedCandidates; ?>']);
      data.push(['Not Responded:', '<?php echo $totalApplications - ($shortlistedCandidates + $hiredCandidates + $rejectedCandidates); ?>']);
      
      // Create worksheet from data
      const ws = XLSX.utils.aoa_to_sheet(data);
      
      // Add column widths
      const wscols = [
        {wch: 20}, // Full Name
        {wch: 30}, // Email
        {wch: 15}, // Contact
        {wch: 25}, // Job Title
        {wch: 15}, // Job Type
        {wch: 12}, // Apply Date
        {wch: 12}  // Status
      ];
      ws['!cols'] = wscols;
      
      // Add formulas for the data table
      const lastDataRow = excelRows.length + 1; // +1 for headers
      
      // Add formulas in cell A[lastDataRow+2]
      ws['A' + (lastDataRow + 2)] = {t:'s', v:'FORMULAS', s:{bold:true, sz:14}};
      
      // Count of total applications
      ws['A' + (lastDataRow + 3)] = {t:'s', v:'Total Applications:'};
      ws['B' + (lastDataRow + 3)] = {t:'f', v:'COUNTA(A2:A' + lastDataRow + ')'};
      
      // Count by status
      ws['A' + (lastDataRow + 4)] = {t:'s', v:'Hired Count:'};
      ws['B' + (lastDataRow + 4)] = {t:'f', v:'COUNTIF(G2:G' + lastDataRow + ',"Hired")'};
      
      ws['A' + (lastDataRow + 5)] = {t:'s', v:'Shortlisted Count:'};
      ws['B' + (lastDataRow + 5)] = {t:'f', v:'COUNTIF(G2:G' + lastDataRow + ',"Sort Listed")'};
      
      ws['A' + (lastDataRow + 6)] = {t:'s', v:'Rejected Count:'};
      ws['B' + (lastDataRow + 6)] = {t:'f', v:'COUNTIF(G2:G' + lastDataRow + ',"Rejected")'};
      
      ws['A' + (lastDataRow + 7)] = {t:'s', v:'Not Responded Count:'};
      ws['B' + (lastDataRow + 7)] = {t:'f', v:'COUNTIF(G2:G' + lastDataRow + ',"Not Responded")'};
      
      // Add worksheet to workbook
      XLSX.utils.book_append_sheet(wb, ws, 'Candidates Report');
      
      // Generate Excel file and trigger download
      XLSX.writeFile(wb, `Candidates_Report_${new Date().toISOString().slice(0,10)}.xlsx`);
    }
    
    // Export to PDF function
    function exportToPDF() {
      // Additional table data for PDF
      document.getElementById('pdfSummary').innerHTML = `
        <h3 class="text-lg font-bold mb-2">Report Summary</h3>
        <table class="mb-4 w-full">
          <tr>
            <td class="font-medium">Date Range:</td>
            <td><?php echo date('M d, Y', strtotime($fdate))?> to <?php echo date('M d, Y', strtotime($tdate))?></td>
          </tr>
          <tr>
            <td class="font-medium">Total Applications:</td>
            <td><?php echo $totalApplications; ?></td>
          </tr>
          <tr>
            <td class="font-medium">Hired:</td>
            <td><?php echo $hiredCandidates; ?></td>
          </tr>
          <tr>
            <td class="font-medium">Shortlisted:</td>
            <td><?php echo $shortlistedCandidates; ?></td>
          </tr>
          <tr>
            <td class="font-medium">Rejected:</td>
            <td><?php echo $rejectedCandidates; ?></td>
          </tr>
          <tr>
            <td class="font-medium">Not Responded:</td>
            <td><?php echo $totalApplications - ($shortlistedCandidates + $hiredCandidates + $rejectedCandidates); ?></td>
          </tr>
        </table>
      `;
      
      const element = document.getElementById('printContent');
      const opt = {
        margin: 0.5,
        filename: `Candidates_Report_${new Date().toISOString().slice(0,10)}.pdf`,
        image: { type: 'jpeg', quality: 0.98 },
        html2canvas: { scale: 2 },
        jsPDF: { unit: 'in', format: 'letter', orientation: 'landscape' }
      };
      
      // Generate PDF
      html2pdf().set(opt).from(element).save();
    }
  </script>

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

<!-- Done 2 -->