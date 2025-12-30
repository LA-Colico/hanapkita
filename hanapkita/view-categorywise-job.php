<?php
session_start();
error_reporting(0);

include('includes/config.php');
$vid=$_GET['viewid'];
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hanap-Kita - <?php echo htmlentities($vid); ?> Jobs</title>
    
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
                
                <!-- Mobile menu button -->
                <div class="md:hidden">
                    <button class="text-gray-500 hover:text-gray-700">
                        <i class="fas fa-bars text-xl"></i>
                    </button>
                </div>
            </div>
        </div>
    </header>

    <!-- Category Header -->
    <section class="bg-gradient-to-br from-blue-50 to-indigo-100 py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <div class="inline-flex items-center space-x-2 bg-white rounded-full px-4 py-2 text-sm text-gray-600 mb-4">
                    <a href="index.php" class="hover:text-primary transition-colors">Home</a>
                    <i class="fas fa-chevron-right text-xs"></i>
                    <span>Job Categories</span>
                    <i class="fas fa-chevron-right text-xs"></i>
                    <span class="text-primary font-medium"><?php echo htmlentities($vid); ?></span>
                </div>
                <h1 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4">
                    <span class="text-primary"><?php echo htmlentities($vid); ?></span> Jobs
                </h1>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                    Discover amazing career opportunities in <?php echo htmlentities($vid); ?> category
                </p>
            </div>
        </div>
    </section>

    <!-- Jobs Listing -->
    <section class="py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <?php
            if (isset($_GET['page_no']) && $_GET['page_no']!="") {
                $page_no = $_GET['page_no'];
            } else {
                $page_no = 1;
            }
            
            $no_of_records_per_page = 12; // Show 12 jobs per page
            $offset = ($page_no-1) * $no_of_records_per_page;
            $previous_page = $page_no - 1;
            $next_page = $page_no + 1;
            $adjacents = "2"; 
            
            $ret = "SELECT jobId FROM tbljobs where isActive='1' and tbljobs.jobCategory=:vid ";
            $query1 = $dbh -> prepare($ret);
            $query1->bindParam(':vid',$vid,PDO::PARAM_STR);
            $query1->execute();
            $results1=$query1->fetchAll(PDO::FETCH_OBJ);
            $total_rows=$query1->rowCount();
            $total_no_of_pages = ceil($total_rows / $no_of_records_per_page);
            $second_last = $total_no_of_pages - 1;
            
            $sql="SELECT tbljobs.*,tblemployers.CompnayLogo,tblemployers.CompnayName from tbljobs join tblemployers on tblemployers.id=tbljobs.employerId where tbljobs.jobCategory=:vid and isActive='1' LIMIT $offset, $no_of_records_per_page";
            $query = $dbh -> prepare($sql);
            $query->bindParam(':vid',$vid,PDO::PARAM_STR);
            $query->execute();
            $results=$query->fetchAll(PDO::FETCH_OBJ);
            ?>

            <!-- Results Header -->
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8">
                <div>
                    <h2 class="text-2xl font-bold text-gray-900 mb-2">Available Positions</h2>
                    <p class="text-gray-600">
                        Showing <?php echo $total_rows; ?> job<?php echo $total_rows != 1 ? 's' : ''; ?> 
                        in <?php echo htmlentities($vid); ?> category
                    </p>
                </div>
                
                <!-- Filter/Sort could be added here -->
                <div class="mt-4 sm:mt-0">
                    <select class="bg-white border border-gray-300 rounded-lg px-4 py-2 text-gray-700 focus:ring-2 focus:ring-primary focus:border-transparent">
                        <option>Sort by: Latest</option>
                        <option>Sort by: Salary High to Low</option>
                        <option>Sort by: Salary Low to High</option>
                    </select>
                </div>
            </div>

            <?php if($query->rowCount() > 0) { ?>
            
            <!-- Jobs Grid -->
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6 mb-12">
                <?php
                $cnt=1;
                foreach($results as $row) {
                    // Job type badge colors
                    $badgeClass = 'bg-green-100 text-green-800';
                    if($row->jobType == "Part Time") $badgeClass = 'bg-blue-100 text-blue-800';
                    if($row->jobType == "Contract") $badgeClass = 'bg-purple-100 text-purple-800';
                    if($row->jobType == "Freelance") $badgeClass = 'bg-orange-100 text-orange-800';
                    if($row->jobType == "Internship") $badgeClass = 'bg-indigo-100 text-indigo-800';
                    if($row->jobType == "Temporary") $badgeClass = 'bg-yellow-100 text-yellow-800';
                ?>
                <div class="bg-white rounded-2xl p-6 shadow-sm hover:shadow-lg transition-all border border-gray-100 group cursor-pointer">
                    <div class="flex items-start justify-between mb-4">
                        <div class="w-14 h-14 bg-gray-100 rounded-xl flex items-center justify-center overflow-hidden flex-shrink-0">
                            <?php if($row->CompnayLogo): ?>
                                <img src="employers/employerslogo/<?php echo $row->CompnayLogo;?>" 
                                     alt="<?php echo htmlentities($row->CompnayName);?>" 
                                     class="w-12 h-12 object-cover rounded-lg">
                            <?php else: ?>
                                <i class="fas fa-building text-gray-400 text-xl"></i>
                            <?php endif; ?>
                        </div>
                        <span class="<?php echo $badgeClass; ?> text-xs font-medium px-3 py-1 rounded-full">
                            <?php echo htmlentities($row->jobType); ?>
                        </span>
                    </div>
                    
                    <h3 class="text-xl font-semibold text-gray-900 mb-2 group-hover:text-primary transition-colors">
                        <a href="jobs-details.php?jid=<?php echo ($row->jobId);?>" class="block">
                            <?php echo htmlentities($row->jobTitle); ?>
                        </a>
                    </h3>
                    
                    <p class="text-gray-600 mb-4 font-medium"><?php echo htmlentities($row->CompnayName); ?></p>
                    
                    <div class="space-y-2 mb-6">
                        <div class="flex items-center text-sm text-gray-500">
                            <i class="fas fa-map-marker-alt mr-2 text-primary"></i>
                            <span><?php echo htmlentities($row->jobLocation); ?></span>
                        </div>
                        <div class="flex items-center text-sm text-gray-500">
                            <i class="fas fa-calendar mr-2 text-primary"></i>
                            <span>Posted <?php echo htmlentities($row->postinDate); ?></span>
                        </div>
                    </div>
                    
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs text-gray-500 mb-1">Salary</p>
                            <span class="text-2xl font-bold text-primary">₱<?php echo htmlentities($row->salaryPackage); ?></span>
                        </div>
                        <a href="jobs-details.php?jid=<?php echo ($row->jobId);?>" 
                           class="bg-primary text-white px-6 py-2 rounded-lg hover:bg-primary-dark transition-colors font-medium">
                            View Details
                        </a>
                    </div>
                </div>
                <?php $cnt=$cnt+1; } ?>
            </div>

            <!-- Pagination -->
            <?php if($total_no_of_pages > 1) { ?>
            <div class="flex justify-center">
                <nav class="flex items-center space-x-2">
                    <?php if($page_no > 1) { ?>
                    <a href="?viewid=<?php echo urlencode($vid); ?>&page_no=<?php echo $previous_page; ?>" 
                       class="flex items-center space-x-2 px-4 py-2 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
                        <i class="fas fa-chevron-left"></i>
                        <span>Previous</span>
                    </a>
                    <?php } ?>
                    
                    <?php
                    if ($total_no_of_pages <= 10) {
                        for ($counter = 1; $counter <= $total_no_of_pages; $counter++) {
                            if ($counter == $page_no) {
                                echo "<span class='px-4 py-2 bg-primary text-white rounded-lg font-medium'>$counter</span>";
                            } else {
                                echo "<a href='?viewid=" . urlencode($vid) . "&page_no=$counter' class='px-4 py-2 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors'>$counter</a>";
                            }
                        }
                    } elseif($total_no_of_pages > 10) {
                        if($page_no <= 4) {
                            for ($counter = 1; $counter < 8; $counter++) {
                                if ($counter == $page_no) {
                                    echo "<span class='px-4 py-2 bg-primary text-white rounded-lg font-medium'>$counter</span>";
                                } else {
                                    echo "<a href='?viewid=" . urlencode($vid) . "&page_no=$counter' class='px-4 py-2 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors'>$counter</a>";
                                }
                            }
                            echo "<span class='px-2'>...</span>";
                            echo "<a href='?viewid=" . urlencode($vid) . "&page_no=$second_last' class='px-4 py-2 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors'>$second_last</a>";
                            echo "<a href='?viewid=" . urlencode($vid) . "&page_no=$total_no_of_pages' class='px-4 py-2 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors'>$total_no_of_pages</a>";
                        } elseif($page_no > 4 && $page_no < $total_no_of_pages - 4) {
                            echo "<a href='?viewid=" . urlencode($vid) . "&page_no=1' class='px-4 py-2 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors'>1</a>";
                            echo "<a href='?viewid=" . urlencode($vid) . "&page_no=2' class='px-4 py-2 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors'>2</a>";
                            echo "<span class='px-2'>...</span>";
                            for ($counter = $page_no - $adjacents; $counter <= $page_no + $adjacents; $counter++) {
                                if ($counter == $page_no) {
                                    echo "<span class='px-4 py-2 bg-primary text-white rounded-lg font-medium'>$counter</span>";
                                } else {
                                    echo "<a href='?viewid=" . urlencode($vid) . "&page_no=$counter' class='px-4 py-2 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors'>$counter</a>";
                                }
                            }
                            echo "<span class='px-2'>...</span>";
                            echo "<a href='?viewid=" . urlencode($vid) . "&page_no=$second_last' class='px-4 py-2 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors'>$second_last</a>";
                            echo "<a href='?viewid=" . urlencode($vid) . "&page_no=$total_no_of_pages' class='px-4 py-2 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors'>$total_no_of_pages</a>";
                        } else {
                            echo "<a href='?viewid=" . urlencode($vid) . "&page_no=1' class='px-4 py-2 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors'>1</a>";
                            echo "<a href='?viewid=" . urlencode($vid) . "&page_no=2' class='px-4 py-2 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors'>2</a>";
                            echo "<span class='px-2'>...</span>";
                            for ($counter = $total_no_of_pages - 6; $counter <= $total_no_of_pages; $counter++) {
                                if ($counter == $page_no) {
                                    echo "<span class='px-4 py-2 bg-primary text-white rounded-lg font-medium'>$counter</span>";
                                } else {
                                    echo "<a href='?viewid=" . urlencode($vid) . "&page_no=$counter' class='px-4 py-2 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors'>$counter</a>";
                                }
                            }
                        }
                    }
                    ?>
                    
                    <?php if($page_no < $total_no_of_pages) { ?>
                    <a href="?viewid=<?php echo urlencode($vid); ?>&page_no=<?php echo $next_page; ?>" 
                       class="flex items-center space-x-2 px-4 py-2 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
                        <span>Next</span>
                        <i class="fas fa-chevron-right"></i>
                    </a>
                    <?php } ?>
                    
                    <?php if($page_no < $total_no_of_pages) { ?>
                    <a href="?viewid=<?php echo urlencode($vid); ?>&page_no=<?php echo $total_no_of_pages; ?>" 
                       class="flex items-center space-x-2 px-4 py-2 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
                        <span>Last</span>
                        <i class="fas fa-angle-double-right"></i>
                    </a>
                    <?php } ?>
                </nav>
            </div>
            <?php } ?>

            <?php } else { ?>
            <!-- No Jobs Found -->
            <div class="text-center py-16">
                <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6">
                    <i class="fas fa-briefcase text-gray-400 text-3xl"></i>
                </div>
                <h3 class="text-2xl font-semibold text-gray-900 mb-4">No Jobs Found</h3>
                <p class="text-gray-600 mb-8 max-w-md mx-auto">
                    We couldn't find any jobs in the <?php echo htmlentities($vid); ?> category at the moment. 
                    Please check back later or explore other categories.
                </p>
                <div class="flex flex-col sm:flex-row justify-center space-y-4 sm:space-y-0 sm:space-x-4">
                    <a href="index.php" class="bg-primary text-white px-6 py-3 rounded-lg hover:bg-primary-dark transition-colors font-medium">
                        Browse All Jobs
                    </a>
                    <a href="index.php#categories" class="bg-white border border-gray-300 text-gray-700 px-6 py-3 rounded-lg hover:bg-gray-50 transition-colors font-medium">
                        View Categories
                    </a>
                </div>
            </div>
            <?php } ?>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-20 bg-primary">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h2 class="text-4xl font-bold text-white mb-6">
                    Ready to Take the Next Step?
                </h2>
                <p class="text-xl text-blue-100 mb-8 max-w-3xl mx-auto">
                    Don't let your dream job slip away. Join thousands of job seekers who found their perfect match through Hanap-Kita.
                </p>
                <div class="flex flex-col sm:flex-row justify-center space-y-4 sm:space-y-0 sm:space-x-6">
                    <a href="sign-up.php" class="bg-white text-primary px-8 py-4 rounded-xl font-semibold hover:bg-gray-50 transition-colors">
                        Create Your Profile
                    </a>
                    <a href="index.php" class="bg-transparent border-2 border-white text-white px-8 py-4 rounded-xl font-semibold hover:bg-white hover:text-primary transition-colors">
                        Browse All Jobs
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white py-16">
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
                        <?php if (strlen($_SESSION['jsid']==0)) {?>
                        <li><a href="admin/index.php" class="text-gray-400 hover:text-white transition-colors">Admin</a></li>
                        <li><a href="sign-up.php" class="text-gray-400 hover:text-white transition-colors">Job Seeker</a></li>
                        <li><a href="employers/emp-login.php" class="text-gray-400 hover:text-white transition-colors">Employer</a></li>
                        <?php } ?>
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

</body>
</html>