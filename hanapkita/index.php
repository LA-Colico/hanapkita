<?php
session_start();
error_reporting(0);
include('includes/config.php');
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hanap-Kita - Get The Right Job You Deserve</title>
    
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

<body class="bg-white text-gray-900 font-sans">
    
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
                    <a href="index.php" class="text-primary font-medium border-b-2 border-primary pb-1">Home</a>
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

    <!-- Hero Section -->
    <section class="bg-gradient-to-br from-blue-50 to-indigo-100 py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h1 class="text-5xl md:text-6xl font-bold text-gray-900 mb-6">
                    Search Jobs
                    <span class="text-primary">Near You</span>
                </h1>
                <p class="text-xl text-gray-600 mb-12 max-w-3xl mx-auto">
                    Your community-focused job portal connecting local talent with opportunity in Balic-Balic, Sampaloc, Manila. Find blue-collar jobs that match your skills.
                </p>
                
                <!-- Search Bar -->
                <div class="max-w-4xl mx-auto bg-white rounded-2xl shadow-lg p-2">
                    <form action="job-search.php" method="post" class="flex flex-col md:flex-row gap-2">
                        <div class="flex-1 relative">
                            <i class="fas fa-search absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                            <input type="text" name="jobtitle" placeholder="Enter Job Title" required
                                   class="w-full pl-12 pr-4 py-4 border-0 rounded-xl focus:ring-2 focus:ring-primary focus:outline-none text-lg">
                        </div>
                        <div class="flex-1 relative">
                            <i class="fas fa-building absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                            <input type="text" name="company" placeholder="Enter Company" 
                                   class="w-full pl-12 pr-4 py-4 border-0 rounded-xl focus:ring-2 focus:ring-primary focus:outline-none text-lg">
                        </div>
                        <button type="submit" name="search" class="bg-primary text-white px-8 py-4 rounded-xl font-semibold hover:bg-primary-dark transition-colors text-lg">
                            <i class="fas fa-search mr-2"></i>Search
                        </button>
                    </form>
                </div>
                
                <!-- Quick Actions -->
                <?php if (strlen($_SESSION['jsid']==0)) {?>
                <div class="flex flex-col sm:flex-row justify-center space-y-4 sm:space-y-0 sm:space-x-6 mt-8">
                    <a href="sign-up.php" class="flex items-center justify-center space-x-2 bg-white border-2 border-dashed border-primary text-primary px-6 py-3 rounded-xl hover:bg-primary hover:text-white transition-all">
                        <i class="fas fa-user"></i>
                        <span class="font-medium">I'm a Job Seeker</span>
                    </a>
                    <a href="employers/emp-login.php" class="flex items-center justify-center space-x-2 bg-primary text-white px-6 py-3 rounded-xl hover:bg-primary-dark transition-colors">
                        <i class="fas fa-building"></i>
                        <span class="font-medium">I'm an Employer</span>
                    </a>
                </div>
                <?php } ?>
            </div>
        </div>
    </section>

    <!-- Job Categories -->
    <section class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold text-gray-900 mb-4">Popular Job Categories</h2>
                <p class="text-xl text-gray-600">Find opportunities in your field of expertise</p>
            </div>
            
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                <?php
                $sql="SELECT jobCategory,count(jobId) as totaljobs from tbljobs where isActive='1' group by jobCategory";
                $query = $dbh -> prepare($sql);
                $query->execute();
                $results=$query->fetchAll(PDO::FETCH_OBJ);
                
                $icons = [
                    'Construction' => 'fas fa-hard-hat',
                    'Food Service' => 'fas fa-utensils', 
                    'Food' => 'fas fa-utensils',
                    'Logistics' => 'fas fa-truck',
                    'Security' => 'fas fa-shield-alt',
                    'Retail' => 'fas fa-shopping-cart',
                    'Waste Management' => 'fas fa-recycle',
                    'Cash Handler' => 'fas fa-money-bill-wave',
                    'Automotive Service' => 'fas fa-car'
                ];
                
                foreach($results as $row) {
                    $categoryIcon = isset($icons[$row->jobCategory]) ? $icons[$row->jobCategory] : 'fas fa-briefcase';
                ?>
                <a href="view-categorywise-job.php?viewid=<?php echo htmlentities($row->jobCategory);?>" 
                   class="bg-white border border-gray-200 rounded-2xl p-6 hover:shadow-lg hover:border-primary transition-all cursor-pointer group">
                    <div class="text-primary text-3xl mb-4 group-hover:scale-110 transition-transform">
                        <i class="<?php echo $categoryIcon; ?>"></i>
                    </div>
                    <h3 class="font-semibold text-gray-900 mb-2"><?php echo htmlentities($row->jobCategory); ?></h3>
                    <p class="text-sm text-gray-500"><?php echo htmlentities($row->totaljobs); ?> jobs</p>
                </a>
                <?php } ?>
            </div>
        </div>
    </section>

    <!-- Featured Jobs -->
    <section class="py-20 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center mb-12">
                <div>
                    <h2 class="text-4xl font-bold text-gray-900 mb-4">Recent Hot Jobs</h2>
                    <p class="text-xl text-gray-600">Discover your next career opportunity</p>
                </div>
            </div>
            
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6 mb-12">
                <?php
                if (isset($_GET['page_no']) && $_GET['page_no']!="") {
                    $page_no = $_GET['page_no'];
                } else {
                    $page_no = 1;
                }
                
                $no_of_records_per_page = 9; // Show 9 jobs in grid
                $offset = ($page_no-1) * $no_of_records_per_page;
                $previous_page = $page_no - 1;
                $next_page = $page_no + 1;
                $adjacents = "2"; 
                
                $ret = "SELECT jobId FROM tbljobs where isActive='1'";
                $query1 = $dbh -> prepare($ret);
                $query1->execute();
                $results1=$query1->fetchAll(PDO::FETCH_OBJ);
                $total_rows=$query1->rowCount();
                $total_no_of_pages = ceil($total_rows / $no_of_records_per_page);
                $second_last = $total_no_of_pages - 1;
                
                $sql="SELECT tbljobs.*,tblemployers.CompnayLogo,tblemployers.CompnayName from tbljobs join tblemployers on tblemployers.id=tbljobs.employerId where isActive='1' order by jobId desc LIMIT $offset, $no_of_records_per_page";
                $query = $dbh -> prepare($sql);
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
                <div class="bg-white rounded-2xl p-6 shadow-sm hover:shadow-lg transition-shadow border border-gray-100 group">
                    <div class="flex items-start justify-between mb-4">
                        <div class="w-12 h-12 bg-gray-100 rounded-xl flex items-center justify-center overflow-hidden">
                            <img src="employers/employerslogo/<?php echo $row->CompnayLogo;?>" alt="<?php echo htmlentities($row->CompnayName);?>" class="w-10 h-10 object-cover rounded">
                        </div>
                        <span class="<?php echo $badgeClass; ?> text-xs font-medium px-3 py-1 rounded-full">
                            <?php echo htmlentities($row->jobType); ?>
                        </span>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">
                        <a href="jobs-details.php?jid=<?php echo ($row->jobId);?>" class="hover:text-primary transition-colors">
                            <?php echo htmlentities($row->jobTitle); ?>
                        </a>
                    </h3>
                    <p class="text-gray-600 mb-4"><?php echo htmlentities($row->CompnayName); ?></p>
                    <div class="flex items-center text-sm text-gray-500 mb-4">
                        <i class="fas fa-map-marker-alt mr-2"></i>
                        <span><?php echo htmlentities($row->jobLocation); ?></span>
                    </div>
                    <div class="flex items-center text-sm text-gray-500 mb-4">
                        <i class="fas fa-calendar mr-2"></i>
                        <span><?php echo htmlentities($row->postinDate); ?></span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-2xl font-bold text-primary">₱<?php echo htmlentities($row->salaryPackage); ?></span>
                        <a href="jobs-details.php?jid=<?php echo ($row->jobId);?>" 
                           class="bg-primary text-white px-4 py-2 rounded-lg hover:bg-primary-dark transition-colors">
                            View Details
                        </a>
                    </div>
                </div>
                <?php $cnt=$cnt+1; }} ?>
            </div>
            
            <!-- Pagination -->
            <?php if($total_no_of_pages > 1) { ?>
            <div class="flex justify-center">
                <nav class="flex items-center space-x-2">
                    <?php if($page_no > 1) { ?>
                    <a href="?page_no=<?php echo $previous_page; ?>" 
                       class="px-4 py-2 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
                        <i class="fas fa-chevron-left mr-1"></i>Previous
                    </a>
                    <?php } ?>
                    
                    <?php
                    if ($total_no_of_pages <= 10) {
                        for ($counter = 1; $counter <= $total_no_of_pages; $counter++) {
                            if ($counter == $page_no) {
                                echo "<span class='px-4 py-2 bg-primary text-white rounded-lg'>$counter</span>";
                            } else {
                                echo "<a href='?page_no=$counter' class='px-4 py-2 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors'>$counter</a>";
                            }
                        }
                    }
                    ?>
                    
                    <?php if($page_no < $total_no_of_pages) { ?>
                    <a href="?page_no=<?php echo $next_page; ?>" 
                       class="px-4 py-2 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
                        Next<i class="fas fa-chevron-right ml-1"></i>
                    </a>
                    <?php } ?>
                </nav>
            </div>
            <?php } ?>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-20 bg-primary">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h2 class="text-4xl font-bold text-white mb-6">
                    Connecting Local Talent with Opportunity
                </h2>
                <p class="text-xl text-blue-100 mb-8 max-w-3xl mx-auto">
                    Your quality of hire increases when you treat everyone fairly and equally. 
                    Having multiple recruiters working on your hiring is beneficial.
                </p>
                <a href="sign-up.php" class="bg-white text-primary px-8 py-4 rounded-xl font-semibold hover:bg-gray-50 transition-colors">
                    Get Registered & Try Now
                </a>
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

<!-- Done 1 -->