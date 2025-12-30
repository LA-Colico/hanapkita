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
    <title>Hanap-Kita - History of Applied Jobs</title>
    
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
                            <span class="text-primary font-medium">Applied Jobs</span>
                        </div>
                    </li>
                </ol>
            </nav>
        </div>
    </div>

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-2">History of Applied Jobs</h1>
            <p class="text-gray-600">Track your job applications and their current status</p>
        </div>

        <!-- Applied Jobs List -->
        <div class="space-y-6">
            <?php  
            $uid=$_SESSION['jsid']; 
            $sql="SELECT tblapplyjob.*,tbljobs.*,tblemployers.* from tblapplyjob join tbljobs on tblapplyjob.JobId=tbljobs.jobId join tblemployers on tblemployers.id=tbljobs.employerId where tblapplyjob.UserId=:uid ORDER BY tblapplyjob.Applydate DESC";
            $query = $dbh -> prepare($sql);
            $query->bindParam(':uid',$uid,PDO::PARAM_STR);
            $query->execute();
            $results=$query->fetchAll(PDO::FETCH_OBJ);

            $cnt=1;
            if($query->rowCount() > 0) {
                foreach($results as $row) {
            ?>
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 hover:shadow-md transition-shadow">
                <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between">
                    <!-- Job Info -->
                    <div class="flex items-start space-x-4 mb-4 lg:mb-0">
                        <!-- Company Logo -->
                        <div class="w-16 h-16 bg-gray-100 rounded-xl flex items-center justify-center overflow-hidden flex-shrink-0">
                            <img src="employers/employerslogo/<?php echo $row->CompnayLogo;?>" alt="<?php echo htmlentities($row->CompnayName);?>" class="w-12 h-12 object-cover rounded">
                        </div>
                        
                        <!-- Job Details -->
                        <div class="flex-1 min-w-0">
                            <h3 class="text-xl font-semibold text-gray-900 mb-1">
                                <?php echo htmlentities($row->jobTitle);?>
                            </h3>
                            <p class="text-gray-600 mb-2"><?php echo htmlentities($row->CompnayName);?></p>
                            
                            <div class="flex flex-wrap items-center gap-4 text-sm text-gray-500 mb-3">
                                <div class="flex items-center space-x-1">
                                    <i class="fas fa-map-marker-alt"></i>
                                    <span><?php echo htmlentities($row->jobLocation);?></span>
                                </div>
                                <div class="flex items-center space-x-1">
                                    <i class="fas fa-calendar"></i>
                                    <span>Posted: <?php echo htmlentities($row->postinDate);?></span>
                                </div>
                                <div class="flex items-center space-x-1">
                                    <i class="fas fa-clock"></i>
                                    <span>Applied: <?php echo htmlentities($row->Applydate);?></span>
                                </div>
                            </div>
                            
                            <div class="flex items-center space-x-4">
                                <span class="text-2xl font-bold text-primary">₱<?php echo htmlentities($row->salaryPackage);?></span>
                                
                                <!-- Status Badge -->
                                <span class="<?php  
                                if($row->Status=="") {
                                    echo 'bg-yellow-100 text-yellow-800';
                                } elseif($row->Status=="Hired") {
                                    echo 'bg-green-100 text-green-800';
                                } elseif($row->Status=="Rejected") {
                                    echo 'bg-red-100 text-red-800';
                                } else {
                                    echo 'bg-blue-100 text-blue-800';
                                }
                                ?> px-3 py-1 rounded-full text-sm font-medium inline-flex items-center">
                                    <i class="<?php  
                                    if($row->Status=="") {
                                        echo 'fas fa-clock';
                                    } elseif($row->Status=="Hired") {
                                        echo 'fas fa-check';
                                    } elseif($row->Status=="Rejected") {
                                        echo 'fas fa-times';
                                    } else {
                                        echo 'fas fa-info';
                                    }
                                    ?> mr-1"></i>
                                    <?php  
                                    if($row->Status=="") {
                                        echo "Not Responded Yet";
                                    } else {
                                        echo $row->Status;
                                    }
                                    ?>
                                </span>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Action Buttons -->
                    <div class="flex flex-col sm:flex-row gap-3 lg:flex-shrink-0">
                        <a href="jobseekersresumes/<?php echo htmlentities($row->Resume);?>" target="_blank"
                           class="inline-flex items-center justify-center space-x-2 bg-gray-100 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-200 transition-colors">
                            <i class="fas fa-file-pdf"></i>
                            <span>Resume</span>
                        </a>
                        <a href="app-details.php?jobid=<?php echo ($row->JobId);?>" 
                           class="inline-flex items-center justify-center space-x-2 bg-primary text-white px-4 py-2 rounded-lg hover:bg-primary-dark transition-colors">
                            <i class="fas fa-eye"></i>
                            <span>View Details</span>
                        </a>
                    </div>
                </div>
            </div>
            <?php $cnt=$cnt+1;
                }
            } else { ?>
            <!-- No Applications State -->
            <div class="text-center py-16">
                <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6">
                    <i class="fas fa-briefcase text-4xl text-gray-400"></i>
                </div>
                <h3 class="text-2xl font-semibold text-gray-900 mb-2">No Applications Yet</h3>
                <p class="text-gray-600 mb-8">You haven't applied for any jobs yet. Start exploring opportunities!</p>
                <a href="index.php" class="inline-flex items-center space-x-2 bg-primary text-white px-6 py-3 rounded-xl hover:bg-primary-dark transition-colors">
                    <i class="fas fa-search"></i>
                    <span>Browse Jobs</span>
                </a>
            </div>
            <?php } ?>
        </div>

        <!-- Back to Home -->
        <?php if($query->rowCount() > 0) { ?>
        <div class="mt-12 text-center">
            <a href="index.php" class="inline-flex items-center space-x-2 bg-gray-100 text-gray-700 px-6 py-3 rounded-xl hover:bg-gray-200 transition-colors">
                <i class="fas fa-arrow-left"></i>
                <span>Back to Job Search</span>
            </a>
        </div>
        <?php } ?>
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

<!-- Done 8 -->