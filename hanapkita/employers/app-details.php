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
else{ 
if(isset($_POST['submit']))
  {
    
    
    $jobid=$_GET['jobid'];
    $jsid=$_GET['jsid'];
    $status=$_POST['status'];
 $msg=$_POST['message'];
  

    $sql="insert into tblmessage(JobID,UserID,Message,Status) value(:jobid,:jsid,:msg,:status)";

    $query=$dbh->prepare($sql);
$query->bindParam(':jobid',$jobid,PDO::PARAM_STR); 
$query->bindParam(':jsid',$jsid,PDO::PARAM_STR); 
    $query->bindParam(':msg',$msg,PDO::PARAM_STR); 
    $query->bindParam(':status',$status,PDO::PARAM_STR); 
       $query->execute();
      $sql1= "update tblapplyjob set Status=:status where JobId=:jobid and UserId=:jsid";

    $query1=$dbh->prepare($sql1);
     $query1->bindParam(':jobid',$jobid,PDO::PARAM_STR);
      $query1->bindParam(':jsid',$jsid,PDO::PARAM_STR);
$query1->bindParam(':status',$status,PDO::PARAM_STR);

 $query1->execute();
 echo '<script>alert("Status has been updated")</script>';
 echo "<script>window.location.href ='candidates-listings.php'</script>";
}


  ?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Application Details | Hanap-Kita</title>
  
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
      $jobid=$_GET['jobid'];
      $name=$_GET['name'];
      $jsid=$_GET['jsid'];
      // Fetching User Details
      $sql = "SELECT tbljobs.*,tblapplyjob.*  from tblapplyjob join tbljobs on tblapplyjob.JobId=tbljobs.jobId  where tbljobs.jobId=:jobid and tblapplyjob.UserId=:jsid";
      $query = $dbh -> prepare($sql);
      $query-> bindParam(':jobid', $jobid, PDO::PARAM_STR);
      $query-> bindParam(':jsid', $jsid, PDO::PARAM_STR);
      $query->execute();
      $results=$query->fetchAll(PDO::FETCH_OBJ);
      foreach($results as $result)
      {
      ?>
      
      <!-- Page Title -->
      <div class="mb-10 text-center">
        <h1 class="text-3xl font-bold text-gray-900"><?php echo htmlentities($_GET['name']);?>'s Application</h1>
        <p class="mt-2 text-lg text-gray-600">Review and manage candidate application details</p>
      </div>
      
      <!-- Job Details Card -->
      <div class="bg-white rounded-xl shadow-sm overflow-hidden mb-8">
        <div class="border-b border-gray-100 bg-gradient-to-r from-primary-light to-primary px-6 py-4">
          <h2 class="text-xl font-semibold text-white">Job Details</h2>
        </div>
        
        <div class="p-6">
          <div class="grid md:grid-cols-2 gap-6">
            <div>
              <div class="mb-4">
                <h3 class="text-sm font-medium text-gray-500">Job Title</h3>
                <p class="mt-1 text-gray-900 font-medium"><?php echo $result->jobTitle;?></p>
              </div>
              
              <div class="mb-4">
                <h3 class="text-sm font-medium text-gray-500">Salary Package</h3>
                <p class="mt-1 text-gray-900 font-medium">₱<?php echo $result->salaryPackage;?></p>
              </div>
              
              <div class="mb-4">
                <h3 class="text-sm font-medium text-gray-500">Job Location</h3>
                <p class="mt-1 text-gray-900"><?php echo $result->jobLocation;?></p>
              </div>
              
              <div>
                <h3 class="text-sm font-medium text-gray-500">Apply Date</h3>
                <p class="mt-1 text-gray-900"><?php echo $result->Applydate;?></p>
              </div>
            </div>
            
            <div>
              <div class="mb-4">
                <h3 class="text-sm font-medium text-gray-500">Skills Required</h3>
                <p class="mt-1 text-gray-900"><?php echo $result->skillsRequired;?></p>
              </div>
              
              <div class="mb-4">
                <h3 class="text-sm font-medium text-gray-500">Last Date</h3>
                <p class="mt-1 text-gray-900"><?php echo $result->JobExpdate;?></p>
              </div>
              
              <div>
                <h3 class="text-sm font-medium text-gray-500">Status</h3>
                <div class="mt-1">
                  <?php  
                  if($result->Status=="") {
                    echo '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">Not Responded Yet</span>';
                  } else if($result->Status=="Sort Listed") {
                    echo '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">Sort Listed</span>';
                  } else if($result->Status=="Hired") {
                    echo '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">Hired</span>';
                  } else if($result->Status=="Rejected") {
                    echo '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">Rejected</span>';
                  } else {
                    echo '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">'.$result->Status.'</span>';
                  }
                  ?>
                </div>
              </div>
            </div>
          </div>
          
          <div class="mt-6">
            <h3 class="text-sm font-medium text-gray-500">Job Description</h3>
            <div class="mt-1 text-gray-700 prose max-w-none">
              <?php echo $result->jobDescription;?>
            </div>
          </div>
        </div>
      </div>
      
      <?php  if($result->Status!=''){
      $ret="select tblmessage.* from tblmessage  where tblmessage.JobID=:jobid order by tblmessage.ID desc";
      $query1 = $dbh -> prepare($ret);
      $query1-> bindParam(':jobid', $jobid, PDO::PARAM_STR);
      $query1->execute();
      $cnt=1;
      $results=$query1->fetchAll(PDO::FETCH_OBJ);
      ?>
      
      <!-- Message History Card -->
      <div class="bg-white rounded-xl shadow-sm overflow-hidden mb-8">
        <div class="border-b border-gray-100 bg-gradient-to-r from-primary-light to-primary px-6 py-4">
          <h2 class="text-xl font-semibold text-white">Message History</h2>
        </div>
        
        <div class="p-6">
          <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
              <thead class="bg-gray-50">
                <tr>
                  <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">#</th>
                  <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Message</th>
                  <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                  <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Time</th>
                </tr>
              </thead>
              <tbody class="bg-white divide-y divide-gray-200">
                <?php  
                foreach($results as $row1) {
                ?>
                <tr>
                  <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?php echo $cnt;?></td>
                  <td class="px-6 py-4 text-sm text-gray-900"><?php echo $row1->Message;?></td>
                  <td class="px-6 py-4 whitespace-nowrap">
                    <?php if($row1->Status=="Sort Listed") { ?>
                      <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                        Sort Listed
                      </span>
                    <?php } else if($row1->Status=="Hired") { ?>
                      <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                        Hired
                      </span>
                    <?php } else if($row1->Status=="Rejected") { ?>
                      <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                        Rejected
                      </span>
                    <?php } else { ?>
                      <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                        <?php echo $row1->Status;?>
                      </span>
                    <?php } ?>
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?php echo $row1->ResponseDate;?></td>
                </tr>
                <?php $cnt=$cnt+1;} ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
      <?php }  
      if($result->Status=="" || $result->Status=="Sort Listed") {
      ?> 
      
      <!-- Take Action Button -->
      <div class="text-center">
        <button type="button" data-toggle="modal" data-target="#myModal" 
                class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-primary hover:bg-primary-dark focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary transition-colors">
          <i class="fas fa-clipboard-check mr-2"></i> Take Action
        </button>
      </div>
      <?php } } ?>
      
      <!-- Modal -->
      <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Take Action</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <form method="post" name="submit">
                <div class="mb-4">
                  <label for="message" class="block text-sm font-medium text-gray-700 mb-2">Message:</label>
                  <textarea name="message" id="message" rows="6" 
                           class="block w-full rounded-md border-gray-300 shadow-sm focus:ring-primary focus:border-primary sm:text-sm" 
                           placeholder="Enter your message to the candidate" required></textarea>
                </div>
                
                <div>
                  <label for="status" class="block text-sm font-medium text-gray-700 mb-2">Status:</label>
                  <select name="status" id="status" required
                         class="block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-primary focus:border-primary sm:text-sm rounded-md">
                    <option value="">Select Status</option>
                    <?php if($result->Status==""):?>
                    <option value="Sort Listed">Sort Listed</option>
                    <option value="Hired">Hired</option>
                    <option value="Rejected">Rejected</option>
                    <?php elseif($result->Status=="Sort Listed"): ?>
                    <option value="Hired">Hired</option>
                    <option value="Rejected">Rejected</option>
                    <?php endif;?>
                  </select>
                </div>
                
                <div class="mt-5 flex justify-end">
                  <button type="button" class="mr-3 inline-flex justify-center py-2 px-4 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary" data-dismiss="modal">
                    Cancel
                  </button>
                  <button type="submit" name="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-primary hover:bg-primary-dark focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
                    Update
                  </button>
                </div>
              </form>
            </div>
          </div>
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
  <script src="../js/form.js"></script> 
  <script src="../js/custom.js"></script>
</body>
</html>
<?php } ?>

<!--Done 1 -->