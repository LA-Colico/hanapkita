<?php
session_start();
error_reporting(0);
include('includes/config.php');
if (strlen($_SESSION['jsid']==0)) {
  header('location:logout.php');
} else {
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hanap-Kita | View Applied Job History</title>
    
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
                    <a href="applied-jobs.php" class="text-primary font-medium border-b-2 border-primary pb-1">Applied Jobs</a>
                    <a href="about.php" class="text-gray-700 hover:text-primary font-medium transition-colors">About Us</a>
                    <a href="contact.php" class="text-gray-700 hover:text-primary font-medium transition-colors">Contact</a>
                </nav>
                
                <!-- User Menu -->
                <div class="flex items-center space-x-4">
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
                            <span class="font-medium"><?php echo htmlentities($_SESSION['jsfname']);?></span>
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
                </div>
            </div>
        </div>
    </header>

    <!-- Breadcrumb -->
    <div class="bg-white border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
            <nav class="flex" aria-label="Breadcrumb">
                <ol class="flex items-center space-x-4">
                    <li>
                        <a href="index.php" class="text-gray-500 hover:text-primary transition-colors">
                            <i class="fas fa-home"></i>
                        </a>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <i class="fas fa-chevron-right text-gray-400 mx-2"></i>
                            <a href="applied-jobs.php" class="text-gray-500 hover:text-primary transition-colors">Applied Jobs</a>
                        </div>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <i class="fas fa-chevron-right text-gray-400 mx-2"></i>
                            <span class="text-primary font-medium">Application Details</span>
                        </div>
                    </li>
                </ol>
            </nav>
        </div>
    </div>

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-2"><?php echo htmlentities($_SESSION['jsfname']);?>'s Application</h1>
            <p class="text-gray-600">View your job application details and status updates</p>
        </div>

        <?php
        //Getting User Id
        $jobid=$_GET['jobid'];
        // Fetching User Details
        $sql = "SELECT tbljobs.*,tblapplyjob.*,tblemployers.CompnayName,tblemployers.CompnayLogo from tblapplyjob 
        join tbljobs on tblapplyjob.JobId=tbljobs.jobId 
        join tblemployers on tblemployers.id=tbljobs.employerId 
        where tbljobs.jobId=:jobid";
        $query = $dbh -> prepare($sql);
        $query-> bindParam(':jobid', $jobid, PDO::PARAM_STR);
        $query->execute();
        $results=$query->fetchAll(PDO::FETCH_OBJ);
        foreach($results as $result) {
        ?>

        <!-- Job Details Card -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-8 mb-8">
            <div class="flex items-center mb-6">
                <div class="w-16 h-16 bg-gray-100 rounded-xl flex items-center justify-center overflow-hidden mr-4">
                    <img src="employers/employerslogo/<?php echo $result->CompnayLogo;?>" alt="Company Logo" class="w-12 h-12 object-cover rounded">
                </div>
                <div>
                    <h2 class="text-2xl font-bold text-gray-900 mb-1">Job Application Details</h2>
                    <p class="text-gray-600">Application submitted for <?php echo htmlentities($result->jobTitle);?></p>
                </div>
            </div>

            <div class="grid md:grid-cols-2 gap-6">
                <div class="space-y-4">
                    <div class="flex justify-between items-center py-3 border-b border-gray-100">
                        <span class="font-medium text-gray-700">Company Name</span>
                        <span class="text-gray-900"><?php echo htmlentities($result->CompnayName);?></span>
                    </div>
                    <div class="flex justify-between items-center py-3 border-b border-gray-100">
                        <span class="font-medium text-gray-700">Job Title</span>
                        <span class="text-gray-900"><?php echo htmlentities($result->jobTitle);?></span>
                    </div>
                    <div class="flex justify-between items-center py-3 border-b border-gray-100">
                        <span class="font-medium text-gray-700">Salary Package</span>
                        <span class="text-primary font-semibold">₱<?php echo htmlentities($result->salaryPackage);?></span>
                    </div>
                    <div class="flex justify-between items-center py-3 border-b border-gray-100">
                        <span class="font-medium text-gray-700">Job Location</span>
                        <span class="text-gray-900"><?php echo htmlentities($result->jobLocation);?></span>
                    </div>
                </div>
                
                <div class="space-y-4">
                    <div class="flex justify-between items-center py-3 border-b border-gray-100">
                        <span class="font-medium text-gray-700">Skills Required</span>
                        <span class="text-gray-900"><?php echo htmlentities($result->skillsRequired);?></span>
                    </div>
                    <div class="flex justify-between items-center py-3 border-b border-gray-100">
                        <span class="font-medium text-gray-700">Apply Date</span>
                        <span class="text-gray-900"><?php echo htmlentities($result->Applydate);?></span>
                    </div>
                    <div class="flex justify-between items-center py-3 border-b border-gray-100">
                        <span class="font-medium text-gray-700">Last Date</span>
                        <span class="text-gray-900"><?php echo htmlentities($result->JobExpdate);?></span>
                    </div>
                    <div class="flex justify-between items-center py-3 border-b border-gray-100">
                        <span class="font-medium text-gray-700">Status</span>
                        <span class="<?php 
                        if($result->Status=="") {
                            echo 'bg-yellow-100 text-yellow-800';
                        } elseif($result->Status=="Hired") {
                            echo 'bg-green-100 text-green-800';
                        } elseif($result->Status=="Rejected") {
                            echo 'bg-red-100 text-red-800';
                        } else {
                            echo 'bg-blue-100 text-blue-800';
                        }
                        ?> px-3 py-1 rounded-full text-sm font-medium">
                            <?php  
                            if($result->Status=="") {
                                echo "Not Responded Yet";
                            } else {
                                echo $result->Status;
                            }
                            ?>
                        </span>
                    </div>
                </div>
            </div>

            <!-- Job Description -->
            <div class="mt-8 pt-6 border-t border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Job Description</h3>
                <div class="text-gray-700 leading-relaxed">
                    <?php echo ($result->jobDescription);?>
                </div>
            </div>
        </div>
        <?php } ?>

        <!-- Message History -->
        <?php 
        $uid=$_SESSION['jsid'];
        $ret="select tblmessage.* from tblmessage where tblmessage.UserID=:uid && tblmessage.JobID=:jobid";
        $query1 = $dbh -> prepare($ret);
        $query1-> bindParam(':jobid', $jobid, PDO::PARAM_STR);
        $query1-> bindParam(':uid', $uid, PDO::PARAM_STR);
        $query1->execute();
        $cnt=1;
        $results=$query1->fetchAll(PDO::FETCH_OBJ);
        if($query1->rowCount() > 0) {
        ?>
        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-8">
            <h3 class="text-2xl font-bold text-gray-900 mb-6">Message History</h3>
            
            <div class="overflow-hidden">
                <table class="min-w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">#</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Message</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Time</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <?php  
                        foreach($results as $row1) {
                        ?>
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"><?php echo $cnt;?></td>
                            <td class="px-6 py-4 text-sm text-gray-900"><?php echo htmlentities($row1->Message);?></td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="<?php 
                                if($row1->Status=="Hired") {
                                    echo 'bg-green-100 text-green-800';
                                } elseif($row1->Status=="Rejected") {
                                    echo 'bg-red-100 text-red-800';
                                } else {
                                    echo 'bg-blue-100 text-blue-800';
                                }
                                ?> px-2 py-1 rounded-full text-xs font-medium">
                                    <?php echo htmlentities($row1->Status);?>
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?php echo htmlentities($row1->ResponseDate);?></td>
                        </tr>
                        <?php $cnt=$cnt+1;} ?>
                    </tbody>
                </table>
            </div>
        </div>
        <?php } ?>

        <!-- Back Button -->
        <div class="mt-8">
            <a href="applied-jobs.php" class="inline-flex items-center space-x-2 bg-gray-100 text-gray-700 px-6 py-3 rounded-xl hover:bg-gray-200 transition-colors">
                <i class="fas fa-arrow-left"></i>
                <span>Back to Applied Jobs</span>
            </a>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white py-16 mt-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h3 class="text-2xl font-bold text-primary mb-4">Hanap-Kita</h3>
                <p class="text-gray-400">&copy; 2024 Hanap-Kita. All rights reserved.</p>
            </div>
        </div>
    </footer>

</body>
</html>
<?php } ?>

<!-- Done 7 -->