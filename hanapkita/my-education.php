<?php
session_start();
//Database Configuration File
include('includes/config.php');
//error_reporting(0);
//verifying Session
if(strlen($_SESSION['jsid'])==0)
  { 
header('location:logout.php');
}
else{ ?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Education Profile | Hanap-Kita</title>
    
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
                    <a href="my-profile.php" class="text-primary font-medium border-b-2 border-primary pb-1">Profile</a>
                    <a href="applied-jobs.php" class="text-gray-700 hover:text-primary font-medium transition-colors">Applied Jobs</a>
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
    <section class="bg-gradient-to-br from-blue-50 to-indigo-100 py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h1 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4">
                    Education <span class="text-primary">Profile</span>
                </h1>
                <p class="text-xl text-gray-600 mb-6">
                    Manage your educational background and qualifications
                </p>
            </div>
        </div>
    </section>

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="grid lg:grid-cols-3 gap-8">
            
            <!-- Profile Summary Card -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 sticky top-24">
                    <?php
                    //Getting User Id
                    $jsid=$_SESSION['jsid'];
                    // Fetching jobs
                    $sql = "SELECT * from  tbljobseekers  where id=:jid";
                    $query = $dbh -> prepare($sql);
                    $query-> bindParam(':jid', $jsid, PDO::PARAM_STR);
                    $query->execute();
                    $results=$query->fetchAll(PDO::FETCH_OBJ);
                    foreach($results as $result) {
                    ?>
                    <div class="text-center mb-6">
                        <div class="w-24 h-24 mx-auto mb-4 bg-gray-100 rounded-full flex items-center justify-center overflow-hidden">
                            <?php if($result->ProfilePic==''): ?>
                                <img src="images/account.png" class="w-20 h-20 rounded-full">
                            <?php else: ?>
                                <img src="images/<?php echo $result->ProfilePic;?>" class="w-20 h-20 rounded-full object-cover">
                            <?php endif;?>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-2">
                            <?php echo htmlentities($_SESSION['jsfname']);?>
                        </h3>
                        <p class="text-gray-500 mb-4">Registration Date: <?php echo htmlentities($result->RegDate);?></p>
                    </div>
                    
                    <div class="space-y-4">
                        <div class="flex items-center space-x-3 text-gray-600">
                            <i class="fas fa-envelope text-primary"></i>
                            <span class="text-sm"><?php echo htmlentities($result->EmailId);?></span>
                        </div>
                        <div class="flex items-center space-x-3 text-gray-600">
                            <i class="fas fa-phone text-primary"></i>
                            <span class="text-sm"><?php echo htmlentities($result->ContactNumber);?></span>
                        </div>
                    </div>
                    
                    <div class="mt-6 space-y-3">
                        <a href="Jobseekersresumes/<?php echo htmlentities($result->Resume);?>" target="_blank" 
                           class="w-full bg-primary text-white text-center py-2 px-4 rounded-lg hover:bg-primary-dark transition-colors flex items-center justify-center space-x-2">
                            <i class="fas fa-file-pdf"></i>
                            <span>View Resume</span>
                        </a>
                        <a href="my-profile.php" 
                           class="w-full bg-gray-100 text-gray-700 text-center py-2 px-4 rounded-lg hover:bg-gray-200 transition-colors flex items-center justify-center space-x-2">
                            <i class="fas fa-user-edit"></i>
                            <span>Edit Profile</span>
                        </a>
                    </div>
                    <?php } ?>
                </div>
            </div>

            <!-- Education Form -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
                    <div class="mb-8">
                        <h2 class="text-2xl font-bold text-gray-900 mb-2">Educational Background</h2>
                        <p class="text-gray-600">Add and manage your educational qualifications</p>
                    </div>

                    <form name="add_name" id="add_name">
                        <div class="overflow-x-auto">
                            <table class="w-full" id="dynamic_field">
                                <thead>
                                    <tr class="border-b border-gray-200">
                                        <th class="text-left py-3 px-2 font-semibold text-gray-700">Qualification</th>
                                        <th class="text-left py-3 px-2 font-semibold text-gray-700">From Year</th>
                                        <th class="text-left py-3 px-2 font-semibold text-gray-700">To Year</th>
                                        <th class="text-left py-3 px-2 font-semibold text-gray-700">School/College</th>
                                        <th class="text-left py-3 px-2 font-semibold text-gray-700">Percentage</th>
                                        <th class="text-left py-3 px-2 font-semibold text-gray-700">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="border-b border-gray-100">
                                        <td class="py-3 px-2">
                                            <input type="text" name="name[]" placeholder="Enter Qualification Name" 
                                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary transition-colors form-control name_list" />
                                        </td>
                                        <td class="py-3 px-2">
                                            <input type="text" name="fromyear[]" placeholder="From year" 
                                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary transition-colors form-control name_list" />
                                        </td>
                                        <td class="py-3 px-2">
                                            <input type="text" name="toyear[]" placeholder="To year" 
                                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary transition-colors form-control name_list" />
                                        </td>
                                        <td class="py-3 px-2">
                                            <input type="text" name="toyear[]" placeholder="School / College name" 
                                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary transition-colors form-control name_list" />
                                        </td>
                                        <td class="py-3 px-2">
                                            <input type="text" name="percentage[]" placeholder="Percentage" 
                                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary transition-colors form-control name_list" />
                                        </td>
                                        <td class="py-3 px-2">
                                            <button type="button" name="add" id="add" 
                                                    class="bg-green-500 text-white px-4 py-2 rounded-lg hover:bg-green-600 transition-colors flex items-center space-x-2">
                                                <i class="fas fa-plus"></i>
                                                <span>Add More</span>
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        
                        <div class="mt-8 flex justify-end">
                            <button type="button" name="submit" id="submit" 
                                    class="bg-primary text-white px-8 py-3 rounded-lg hover:bg-primary-dark transition-colors font-semibold flex items-center space-x-2">
                                <i class="fas fa-save"></i>
                                <span>Save Education Details</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white py-16 mt-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid md:grid-cols-4 gap-8">
                <!-- Brand -->
                <div class="md:col-span-1">
                    <h3 class="text-2xl font-bold text-primary mb-4">Hanap-Kita</h3>
                    <p class="text-gray-400">Your community-focused job portal connecting local talent with opportunity.</p>
                </div>
                
                <!-- Quick Links -->
                <div>
                    <h4 class="font-semibold mb-4">Quick Links</h4>
                    <ul class="space-y-2">
                        <li><a href="index.php" class="text-gray-400 hover:text-white transition-colors">Home</a></li>
                        <li><a href="my-profile.php" class="text-gray-400 hover:text-white transition-colors">My Profile</a></li>
                        <li><a href="applied-jobs.php" class="text-gray-400 hover:text-white transition-colors">Applied Jobs</a></li>
                        <li><a href="about.php" class="text-gray-400 hover:text-white transition-colors">About</a></li>
                    </ul>
                </div>
                
                <!-- Support -->
                <div>
                    <h4 class="font-semibold mb-4">Support</h4>
                    <ul class="space-y-2">
                        <li><a href="contact.php" class="text-gray-400 hover:text-white transition-colors">Contact Us</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition-colors">Help Center</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition-colors">Privacy Policy</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition-colors">Terms of Service</a></li>
                    </ul>
                </div>
                
                <!-- Contact -->
                <div>
                    <h4 class="font-semibold mb-4">Contact Info</h4>
                    <ul class="space-y-2 text-gray-400">
                        <li class="flex items-center space-x-2">
                            <i class="fas fa-envelope"></i>
                            <span>support@hanap-kita.com</span>
                        </li>
                        <li class="flex items-center space-x-2">
                            <i class="fas fa-phone"></i>
                            <span>+63 123 456 7890</span>
                        </li>
                        <li class="flex items-center space-x-2">
                            <i class="fas fa-map-marker-alt"></i>
                            <span>Sampaloc, Manila</span>
                        </li>
                    </ul>
                </div>
            </div>
            
            <div class="border-t border-gray-800 mt-12 pt-8 text-center">
                <p class="text-gray-400">&copy; 2024 Hanap-Kita. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    <script src="js/jquery-1.11.3.min.js"></script> 
    <script src="js/bootstrap.min.js"></script> 
    <script src="js/owl.carousel.min.js"></script> 
    <script src="js/jquery.velocity.min.js"></script> 
    <script src="js/jquery.kenburnsy.js"></script> 
    <script src="js/jquery.mCustomScrollbar.concat.min.js"></script> 
    <script src="js/form.js"></script> 
    <script src="js/custom.js"></script>
    
    <script>
    $(document).ready(function(){
      var i=1;
      $('#add').click(function(){
        i++;
        $('#dynamic_field tbody').append('<tr id="row'+i+'" class="border-b border-gray-100"><td class="py-3 px-2"><input type="text" name="name[]" placeholder="Enter Qualification Name" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary transition-colors form-control name_list" /></td><td class="py-3 px-2"><input type="text" name="fromyear[]" placeholder="From year" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary transition-colors form-control name_list" /></td><td class="py-3 px-2"><input type="text" name="toyear[]" placeholder="To year" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary transition-colors form-control name_list" /></td><td class="py-3 px-2"><input type="text" name="toyear[]" placeholder="School / College name" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary transition-colors form-control name_list" /></td><td class="py-3 px-2"><input type="text" name="percentage[]" placeholder="Percentage" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary transition-colors form-control name_list" /></td><td class="py-3 px-2"><button type="button" name="remove" id="'+i+'" class="bg-red-500 text-white px-3 py-2 rounded-lg hover:bg-red-600 transition-colors btn_remove"><i class="fas fa-times"></i></button></td></tr>');
      });
      
      $(document).on('click', '.btn_remove', function(){
        var button_id = $(this).attr("id"); 
        $('#row'+button_id+'').remove();
      });
      
      $('#submit').click(function(){    
        $.ajax({
          url:"name.php",
          method:"POST",
          data:$('#add_name').serialize(),
          success:function(data)
          {
            alert(data);
            $('#add_name')[0].reset();
          }
        });
      });
      
    });
    </script>
</body>
</html>
<?php } ?>

<!-- Done 19 -->