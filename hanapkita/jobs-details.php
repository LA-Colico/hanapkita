<?php
session_start();
error_reporting(0);

include('includes/config.php');


if(isset($_GET['ajid']))
{
  $jobid=$_GET['ajid'];
  $userid= $_SESSION['jsid'];
  $query = "select ID from tblapplyjob where UserId=:uid && JobId=:jobid";
  $query = $dbh -> prepare($query);
  $query-> bindParam(':uid', $userid, PDO::PARAM_STR);
  $query-> bindParam(':jobid', $jobid, PDO::PARAM_STR);
  $query->execute();
  $results=$query->fetchAll(PDO::FETCH_OBJ);
if($query->rowCount() > 0)
{
echo "<script>alert('Already Applied for this job');</script>"; 
echo "<script>window.location.href ='index.php'</script>";
}
else
{
 $query1="INSERT INTO tblapplyjob(UserId,JobId) VALUES(:uid,:jobid)";
 $query1 = $dbh -> prepare($query1);
  $query1-> bindParam(':uid', $userid, PDO::PARAM_STR);
  $query1-> bindParam(':jobid', $jobid, PDO::PARAM_STR);
  $query1->execute();
  $LastInsertId=$dbh->lastInsertId();
   if ($LastInsertId>0) {
    echo '<script>alert("Jobs has been applied.")</script>';
echo "<script>window.location.href ='index.php'</script>";
  }
  else
    {
         echo '<script>alert("Something Went Wrong. Please try again")</script>';
    }

  
}
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hanap-Kita - Job Details</title>
    
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
                    <a href="index.php" class="text-gray-700 hover:text-primary font-medium transition-colors">Home</a>
                    <a href="about.php" class="text-gray-700 hover:text-primary font-medium transition-colors">About Us</a>
                    <a href="contact.php" class="text-gray-700 hover:text-primary font-medium transition-colors">Contact</a>
                </nav>
                
                <!-- Auth Buttons -->
                <div class="flex items-center space-x-4">
                    <?php if (strlen($_SESSION['jsid']==0)) {?>
                        <div class="relative group">
                            <button class="flex items-center space-x-1 text-gray-700 hover:text-primary font-medium transition-colors">
                                <i class="fas fa-user"></i>
                                <span>Account</span>
                                <i class="fas fa-chevron-down text-xs"></i>
                            </button>
                            <div class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg border border-gray-200 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all">
                                <a href="sign-up.php" class="block px-4 py-2 text-gray-700 hover:bg-gray-50 rounded-t-lg">Job Seekers</a>
                                <a href="employers/emp-login.php" class="block px-4 py-2 text-gray-700 hover:bg-gray-50">Employers</a>
                                <a href="admin/index.php" class="block px-4 py-2 text-gray-700 hover:bg-gray-50 rounded-b-lg">Admin</a>
                            </div>
                        </div>
                    <?php } else { ?>
                        <div class="relative group">
                            <?php
                            $uid= $_SESSION['jsid'];
                            $sql="SELECT * from tbljobseekers where id='$uid'";
                            $query = $dbh -> prepare($sql);
                            $query->execute();
                            $results=$query->fetchAll(PDO::FETCH_OBJ);
                            $cnt=1;
                            if($query->rowCount() > 0) {
                                foreach($results as $row) {
                            ?>
                            <button class="flex items-center space-x-2 text-gray-700 hover:text-primary transition-colors">
                                <?php if($row->ProfilePic==''): ?>
                                    <img src="images/account.png" class="w-8 h-8 rounded-full">
                                <?php else: ?>
                                    <img src="images/<?php echo $row->ProfilePic;?>" class="w-8 h-8 rounded-full">
                                <?php endif;?>
                                <i class="fas fa-chevron-down text-xs"></i>
                            </button>
                            <div class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg border border-gray-200 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all">
                                <a href="my-profile.php" class="block px-4 py-2 text-gray-700 hover:bg-gray-50 rounded-t-lg">My Profile</a>
                                <a href="change-password.php" class="block px-4 py-2 text-gray-700 hover:bg-gray-50">Change Password</a>
                                <a href="profile.php" class="block px-4 py-2 text-gray-700 hover:bg-gray-50">Edit Profile</a>
                                <a href="logout.php" class="block px-4 py-2 text-gray-700 hover:bg-gray-50 rounded-b-lg">Log Out</a>
                            </div>
                            <?php $cnt=$cnt+1;}} ?>
                        </div>
                        <a href="applied-jobs.php" class="text-gray-700 hover:text-primary font-medium transition-colors">Applied Jobs</a>
                    <?php } ?>
                </div>
            </div>
        </div>
    </header>

    <!-- Breadcrumb -->
    <div class="bg-white border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
            <nav class="flex items-center space-x-2 text-sm">
                <a href="index.php" class="text-gray-500 hover:text-primary transition-colors">Home</a>
                <i class="fas fa-chevron-right text-gray-400 text-xs"></i>
                <span class="text-gray-900 font-medium">Job Details</span>
            </nav>
        </div>
    </div>

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="grid lg:grid-cols-3 gap-8">
            
            <!-- Main Job Details -->
            <div class="lg:col-span-2">
                <?php  
                $jid=$_GET['jid']; 
                $sql="SELECT tbljobs.*,tblemployers.* from tbljobs join tblemployers on tblemployers.id=tbljobs.employerId where tbljobs.jobId=:jid";
                $query = $dbh -> prepare($sql);
                $query->bindParam(':jid',$jid,PDO::PARAM_STR);
                $query->execute();
                $results=$query->fetchAll(PDO::FETCH_OBJ);

                $cnt=1;
                if($query->rowCount() > 0) {
                    foreach($results as $row) {
                        // Job type badge colors
                        $badgeClass = 'bg-green-100 text-green-800';
                        if($row->jobType == "Part Time") $badgeClass = 'bg-blue-100 text-blue-800';
                        if($row->jobType == "Contract") $badgeClass = 'bg-purple-100 text-purple-800';
                        if($row->jobType == "Freelance") $badgeClass = 'bg-orange-100 text-orange-800';
                ?>
                
                <!-- Job Header Card -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-8 mb-8">
                    <div class="flex flex-col md:flex-row md:items-start md:justify-between mb-6">
                        <div class="flex items-start space-x-4 mb-4 md:mb-0">
                            <div class="w-16 h-16 bg-gray-100 rounded-2xl flex items-center justify-center overflow-hidden flex-shrink-0">
                                <img src="employers/employerslogo/<?php echo $row->CompnayLogo;?>" alt="<?php echo htmlentities($row->CompnayName);?>" class="w-14 h-14 object-cover rounded-xl">
                            </div>
                            <div>
                                <h1 class="text-3xl font-bold text-gray-900 mb-2"><?php echo htmlentities($row->jobTitle);?></h1>
                                <p class="text-lg text-gray-600 mb-2"><?php echo htmlentities($row->CompnayName);?></p>
                                <div class="flex flex-wrap gap-4 text-sm text-gray-500">
                                    <div class="flex items-center">
                                        <i class="fas fa-map-marker-alt mr-1"></i>
                                        <span><?php echo htmlentities($row->jobLocation);?></span>
                                    </div>
                                    <div class="flex items-center">
                                        <i class="fas fa-calendar mr-1"></i>
                                        <span><?php echo htmlentities($row->postinDate);?></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="flex flex-col items-end">
                            <span class="<?php echo $badgeClass; ?> text-sm font-medium px-4 py-2 rounded-full mb-3">
                                <?php echo htmlentities($row->jobType); ?>
                            </span>
                            <div class="text-right">
                                <span class="text-3xl font-bold text-primary">₱<?php echo htmlentities($row->salaryPackage);?></span>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Apply Button -->
                    <div class="flex flex-col sm:flex-row gap-4">
                        <?php if($_SESSION['jsid']==""){?>
                            <a href="sign-up.php" class="flex-1 bg-primary text-white text-center py-4 px-6 rounded-xl font-semibold hover:bg-primary-dark transition-colors">
                                <i class="fas fa-paper-plane mr-2"></i>Apply for this Job
                            </a>
                        <?php } else { ?>
                            <a href="jobs-details.php?ajid=<?php echo ($row->jobId);?>" class="flex-1 bg-primary text-white text-center py-4 px-6 rounded-xl font-semibold hover:bg-primary-dark transition-colors">
                                <i class="fas fa-paper-plane mr-2"></i>Apply for this Job
                            </a>
                        <?php } ?>
                        <a href="index.php" class="flex-1 bg-gray-100 text-gray-700 text-center py-4 px-6 rounded-xl font-semibold hover:bg-gray-200 transition-colors">
                            <i class="fas fa-arrow-left mr-2"></i>View All Jobs
                        </a>
                    </div>
                </div>

                <!-- Job Description -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-8 mb-8">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">Job Overview</h2>
                    <div class="prose max-w-none">
                        <p class="text-gray-700 leading-relaxed mb-6"><?php echo ($row->CompnayDescription);?></p>
                    </div>
                </div>

                <!-- Job Requirements -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-8 mb-8">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">Job Requirements</h2>
                    <div class="grid md:grid-cols-2 gap-6">
                        <div>
                            <h3 class="font-semibold text-gray-900 mb-3">Required Experience</h3>
                            <p class="text-gray-700 bg-gray-50 px-4 py-3 rounded-lg"><?php echo ($row->experience);?> years</p>
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-900 mb-3">Skills Required</h3>
                            <div class="flex flex-wrap gap-2">
                                <?php 
                                $skills = explode(',', $row->skillsRequired);
                                foreach($skills as $skill) {
                                    $skill = trim($skill);
                                    if(!empty($skill)) {
                                ?>
                                <span class="bg-primary/10 text-primary px-3 py-1 rounded-full text-sm font-medium"><?php echo $skill; ?></span>
                                <?php }} ?>
                            </div>
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-900 mb-3">Job Location</h3>
                            <p class="text-gray-700 bg-gray-50 px-4 py-3 rounded-lg"><?php echo ($row->jobLocation);?></p>
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-900 mb-3">Salary Package</h3>
                            <p class="text-gray-700 bg-gray-50 px-4 py-3 rounded-lg">₱<?php echo ($row->salaryPackage);?></p>
                        </div>
                    </div>
                </div>

                <!-- Apply Section -->
                <div class="bg-gradient-to-r from-primary to-primary-light rounded-2xl p-8 text-white text-center">
                    <h2 class="text-2xl font-bold mb-4">Ready to Apply?</h2>
                    <p class="text-blue-100 mb-6">Take the next step in your career journey with us.</p>
                    <?php if($_SESSION['jsid']==""){?>
                        <a href="sign-up.php" class="bg-white text-primary py-4 px-8 rounded-xl font-semibold hover:bg-gray-50 transition-colors inline-block">
                            Apply for this Job Now
                        </a> 
                    <?php } else { ?>
                        <a href="jobs-details.php?ajid=<?php echo ($row->jobId);?>" class="bg-white text-primary py-4 px-8 rounded-xl font-semibold hover:bg-gray-50 transition-colors inline-block">
                            Apply for this Job Now
                        </a> 
                    <?php } ?>
                </div>
                
                <?php $cnt=$cnt+1;}} ?> 
            </div>

            <!-- Sidebar - Company Details -->
            <div class="lg:col-span-1">
                <div class="sticky top-24">
                    <?php  
                    $jid=$_GET['jid']; 
                    $sql="SELECT tbljobs.*,tblemployers.* from tbljobs join tblemployers on tblemployers.id=tbljobs.employerId where tbljobs.jobId=:jid";
                    $query = $dbh -> prepare($sql);
                    $query->bindParam(':jid',$jid,PDO::PARAM_STR);
                    $query->execute();
                    $results=$query->fetchAll(PDO::FETCH_OBJ);

                    $cnt=1;
                    if($query->rowCount() > 0) {
                        foreach($results as $row) {
                    ?>
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
                        <h2 class="text-xl font-bold text-gray-900 mb-6">Company Details</h2>
                        
                        <div class="text-center mb-6">
                            <div class="w-20 h-20 bg-gray-100 rounded-2xl flex items-center justify-center mx-auto mb-4 overflow-hidden">
                                <img src="employers/employerslogo/<?php echo $row->CompnayLogo;?>" alt="<?php echo htmlentities($row->CompnayName);?>" class="w-18 h-18 object-cover rounded-xl">
                            </div>
                            <h3 class="text-lg font-bold text-primary mb-2"><?php echo htmlentities($row->CompnayName);?></h3>
                        </div>

                        <div class="space-y-4">
                            <div>
                                <h4 class="font-semibold text-gray-900 text-sm mb-2">About Company</h4>
                                <p class="text-gray-600 text-sm leading-relaxed"><?php echo substr($row->CompnayDescription, 0, 150) . '...';?></p>
                            </div>
                            
                            <?php if(!empty($row->industry)) { ?>
                            <div>
                                <h4 class="font-semibold text-gray-900 text-sm mb-2">Industry</h4>
                                <p class="text-gray-600 text-sm"><?php echo htmlentities($row->industry);?></p>
                            </div>
                            <?php } ?>
                            
                            <?php if(!empty($row->typeBusinessEntity)) { ?>
                            <div>
                                <h4 class="font-semibold text-gray-900 text-sm mb-2">Business Type</h4>
                                <p class="text-gray-600 text-sm"><?php echo htmlentities($row->typeBusinessEntity);?></p>
                            </div>
                            <?php } ?>
                            
                            <?php if(!empty($row->establishedIn)) { ?>
                            <div>
                                <h4 class="font-semibold text-gray-900 text-sm mb-2">Established</h4>
                                <p class="text-gray-600 text-sm"><?php echo htmlentities($row->establishedIn);?></p>
                            </div>
                            <?php } ?>
                            
                            <?php if(!empty($row->noOfEmployee)) { ?>
                            <div>
                                <h4 class="font-semibold text-gray-900 text-sm mb-2">Company Size</h4>
                                <p class="text-gray-600 text-sm"><?php echo htmlentities($row->noOfEmployee);?> employees</p>
                            </div>
                            <?php } ?>
                            
                            <?php if(!empty($row->lcation)) { ?>
                            <div>
                                <h4 class="font-semibold text-gray-900 text-sm mb-2">Location</h4>
                                <p class="text-gray-600 text-sm"><?php echo htmlentities($row->lcation);?></p>
                            </div>
                            <?php } ?>
                        </div>
                    </div>
                    <?php $cnt=$cnt+1;}} ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white py-16 mt-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid md:grid-cols-4 gap-8">
                <!-- Brand -->
                <div class="md:col-span-1">
                    <h3 class="text-2xl font-bold text-primary mb-4">Hanap-Kita</h3>
                    <?php
                    $sql="SELECT * from tblpages where PageType='contactus'";
                    $query = $dbh -> prepare($sql);
                    $query->execute();
                    $results=$query->fetchAll(PDO::FETCH_OBJ);
                    $cnt=1;
                    if($query->rowCount() > 0) {
                        foreach($results as $row) {
                    ?>
                    <ul class="space-y-2 text-gray-400">
                        <li class="flex items-center space-x-2">
                            <i class="fas fa-phone"></i>
                            <span>+<?php echo htmlentities($row->MobileNumber);?></span>
                        </li>
                        <li class="flex items-center space-x-2">
                            <i class="fas fa-envelope"></i>
                            <span><?php echo htmlentities($row->Email);?></span>
                        </li>
                        <li class="flex items-center space-x-2">
                            <i class="fas fa-map-marker-alt"></i>
                            <span><?php echo htmlentities($row->PageDescription);?></span>
                        </li>
                    </ul>
                    <?php $cnt=$cnt+1;}} ?>
                </div>
                
                <!-- Quick Links -->
                <div>
                    <h4 class="font-semibold mb-4">Quick Links</h4>
                    <ul class="space-y-2">
                        <li><a href="about.php" class="text-gray-400 hover:text-white transition-colors">About</a></li>
                        <li><a href="contact.php" class="text-gray-400 hover:text-white transition-colors">Contact</a></li>
                        <li><a href="index.php" class="text-gray-400 hover:text-white transition-colors">Home</a></li>
                    </ul>
                </div>
                
                <!-- Job Categories -->
                <div>
                    <h4 class="font-semibold mb-4">Job Categories</h4>
                    <ul class="space-y-2">
                        <?php
                        $sql="SELECT jobCategory,count(jobId) as totaljobs from tbljobs group by jobCategory LIMIT 6";
                        $query = $dbh -> prepare($sql);
                        $query->execute();
                        $results=$query->fetchAll(PDO::FETCH_OBJ);
                        foreach($results as $row) {
                        ?>
                        <li>
                            <a href="view-categorywise-job.php?viewid=<?php echo htmlentities($row->jobCategory);?>" 
                               class="text-gray-400 hover:text-white transition-colors">
                                <?php echo htmlentities($row->jobCategory);?>
                            </a>
                        </li>
                        <?php } ?>
                    </ul>
                </div>
                
                <!-- Newsletter -->
                <div>
                    <h4 class="font-semibold mb-4">Stay Updated</h4>
                    <p class="text-gray-400 mb-4">Get the latest job opportunities delivered to your inbox.</p>
                </div>
            </div>
            
            <div class="border-t border-gray-800 mt-12 pt-8 text-center">
                <p class="text-gray-400">&copy; 2024 Hanap-Kita. All rights reserved.</p>
            </div>
        </div>
    </footer>

</body>
</html>

<!-- Done 17 -->