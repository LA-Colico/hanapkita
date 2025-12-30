<?php
session_start();
//Database Configuration File
include('includes/config.php');
error_reporting(0);
if(isset($_POST['signup']))
{
//Getting Post Values
$conrnper=$_POST['concernperson'];  
$emaill=$_POST['email']; 
$cmpnyname=$_POST['companyname']; 
$tagline=$_POST['tagline'];
$description=$_POST['description'];
$website=$_POST['website'];
//Password hashing
$password=$_POST['empppassword'];
$options = ['cost' => 12];
$hashedpass=password_hash($password, PASSWORD_BCRYPT, $options);
//getting logo
$logo=$_FILES["logofile"]["name"];
// get the image extension
$extension = substr($logo,strlen($logo)-4,strlen($logo));
// allowed extensions
$allowed_extensions = array(".jpg","jpeg",".png",".gif");
// Validation for allowed extensions .in_array() function searches an array for a specific value.
if(!in_array($extension,$allowed_extensions))
{
echo "<script>alert('Invalid logo format. Only jpg / jpeg/ png /gif format allowed');</script>";
}
else
{
//rename the image file
$logoname=md5($logo).$extension;
// Code for move image into directory
move_uploaded_file($_FILES["logofile"]["tmp_name"],"employerslogo/".$logoname);

// Query for validation of  email-id
$ret="SELECT * FROM  tblemployers where (EmpEmail=:uemail)";
$queryt = $dbh -> prepare($ret);
$queryt->bindParam(':uemail',$emaill,PDO::PARAM_STR);

$queryt -> execute();
$results = $queryt -> fetchAll(PDO::FETCH_OBJ);
if($queryt -> rowCount() == 0)
{
// Query for Insertion
$isactive=1;
$sql="INSERT INTO tblemployers(ConcernPerson,EmpEmail,EmpPassword,CompnayName,CompanyTagline,CompnayDescription,CompanyUrl,CompnayLogo,Is_Active) VALUES(:conrnper,:emaill,:hashedpass,:cmpnyname,:tagline,:description,:website,:logoname,:isactive)";
$query = $dbh->prepare($sql);
// Binding Post Values
$query->bindParam(':conrnper',$conrnper,PDO::PARAM_STR);
$query->bindParam(':emaill',$emaill,PDO::PARAM_STR);
$query->bindParam(':hashedpass',$hashedpass,PDO::PARAM_STR);
$query->bindParam(':cmpnyname',$cmpnyname,PDO::PARAM_STR);
$query->bindParam(':tagline',$tagline,PDO::PARAM_STR);
$query->bindParam(':description',$description,PDO::PARAM_STR);
$query->bindParam(':website',$website,PDO::PARAM_STR);
$query->bindParam(':logoname',$logoname,PDO::PARAM_STR);
$query->bindParam(':isactive',$isactive,PDO::PARAM_STR);
$query->execute();
$lastInsertId = $dbh->lastInsertId();
if($lastInsertId)
{
$msg="You have signup Successfully";
}
else 
{
$error="Something went wrong.Please try again";
}
}
 else
{
$error="Email-id already exist. Please try again";
}
}
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employers | Signup - Hanap-Kita</title>
    
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

<body class="bg-gray-50 text-gray-900 font-sans min-h-screen">
    
    <!-- Header -->
    <header class="bg-white shadow-sm border-b border-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center">
                    <a href="../index.php" class="text-2xl font-bold text-primary">Hanap-Kita</a>
                </div>
                <nav class="hidden md:flex space-x-6">
                    <a href="../index.php" class="text-gray-700 hover:text-primary font-medium transition-colors">Home</a>
                    <a href="emp-login.php" class="text-primary font-medium">Sign In</a>
                </nav>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        
        <!-- Header Section -->
        <div class="text-center mb-12">
            <h1 class="text-4xl font-bold text-gray-900 mb-4">Join as an Employer</h1>
            <p class="text-xl text-gray-600 mb-8">Connect with talented job seekers in your local community</p>
            
            <!-- Sign In CTA -->
            <div class="bg-blue-50 border border-blue-200 rounded-2xl p-6 mb-8">
                <div class="flex flex-col md:flex-row items-center justify-between">
                    <div class="text-left mb-4 md:mb-0">
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Already have an account?</h3>
                        <p class="text-gray-600">Sign in to access your employer dashboard and manage job postings.</p>
                    </div>
                    <a href="emp-login.php" class="bg-primary text-white px-6 py-3 rounded-xl font-semibold hover:bg-primary-dark transition-colors">
                        <i class="fas fa-sign-in-alt mr-2"></i>Sign In Now
                    </a>
                </div>
            </div>
        </div>

        <!-- Success/Error Messages -->
        <?php if(@$error){ ?>
        <div class="bg-red-50 border border-red-200 rounded-xl p-4 mb-6">
            <div class="flex items-center">
                <i class="fas fa-exclamation-circle text-red-500 mr-3"></i>
                <div>
                    <strong class="text-red-800">Error:</strong>
                    <span class="text-red-700"><?php echo htmlentities($error);?></span>
                </div>
            </div>
        </div>
        <?php } ?>

        <?php if(@$msg){ ?>
        <div class="bg-green-50 border border-green-200 rounded-xl p-4 mb-6">
            <div class="flex items-center">
                <i class="fas fa-check-circle text-green-500 mr-3"></i>
                <div>
                    <strong class="text-green-800">Success:</strong>
                    <span class="text-green-700"><?php echo htmlentities($msg);?></span>
                </div>
            </div>
        </div>
        <?php } ?>

        <!-- Signup Form -->
        <div class="bg-white rounded-2xl shadow-lg p-8">
            <form name="empsignup" enctype="multipart/form-data" method="post" class="space-y-8">
                
                <!-- Company Information -->
                <div>
                    <h2 class="text-2xl font-bold text-gray-900 mb-6 flex items-center">
                        <i class="fas fa-building text-primary mr-3"></i>
                        Company Information
                    </h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Concern Person Name *</label>
                            <input type="text" name="concernperson" placeholder="Enter your full name" required autocomplete="off"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-transparent transition-all">
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Email Address *</label>
                            <input type="email" name="email" id="email" onBlur="userAvailability()" placeholder="company@example.com" autocomplete="off" required
                                   class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-transparent transition-all">
                            <span id="user-availability-status1" class="text-xs mt-1 block"></span>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Password *</label>
                            <input type="password" name="empppassword" placeholder="Enter secure password" autocomplete="off" 
                                   pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,}" 
                                   title="At least one number, one uppercase, one lowercase letter, and 6+ characters" required
                                   class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-transparent transition-all">
                            <p class="text-xs text-gray-500 mt-1">Must contain uppercase, lowercase, number and be 6+ characters</p>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Company Name *</label>
                            <input type="text" name="companyname" placeholder="Enter company name" autocomplete="off" required
                                   class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-transparent transition-all">
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Company Tagline *</label>
                            <input type="text" name="tagline" placeholder="Brief company description" autocomplete="off" required
                                   class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-transparent transition-all">
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Website</label>
                            <input type="url" name="website" placeholder="https://www.yourcompany.com" autocomplete="off"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-transparent transition-all">
                        </div>
                    </div>
                </div>

                <!-- Company Description -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Company Description *</label>
                    <div class="border border-gray-300 rounded-xl">
                        <textarea name="description" autocomplete="off" required rows="6" placeholder="Describe your company, mission, and what makes you unique..."
                                  class="w-full px-4 py-3 border-0 rounded-xl focus:ring-2 focus:ring-primary focus:outline-none resize-none"></textarea>
                    </div>
                </div>

                <!-- Company Logo -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Company Logo *</label>
                    <div class="border-2 border-dashed border-gray-300 rounded-xl p-8 text-center hover:border-primary transition-colors">
                        <div class="space-y-4">
                            <div class="text-gray-400">
                                <i class="fas fa-cloud-upload-alt text-4xl mb-2"></i>
                                <p class="text-lg">Upload your company logo</p>
                            </div>
                            <div class="flex items-center justify-center">
                                <label for="logofile" class="bg-primary text-white px-6 py-3 rounded-xl cursor-pointer hover:bg-primary-dark transition-colors">
                                    <i class="fas fa-upload mr-2"></i>Choose File
                                    <input type="file" name="logofile" id="logofile" required class="hidden" accept=".jpg,.jpeg,.png,.gif">
                                </label>
                            </div>
                            <p class="text-sm text-gray-500">Supported formats: JPG, JPEG, PNG, GIF</p>
                        </div>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="flex justify-center pt-6">
                    <button type="submit" name="signup" id="submit" 
                            class="bg-primary text-white px-12 py-4 rounded-xl font-semibold hover:bg-primary-dark transition-colors text-lg">
                        <i class="fas fa-user-plus mr-2"></i>Create Employer Account
                    </button>
                </div>
            </form>
        </div>

        <!-- Back to Home -->
        <div class="text-center mt-8">
            <a href="../index.php" class="text-gray-600 hover:text-primary transition-colors">
                <i class="fas fa-arrow-left mr-2"></i>Back to Home
            </a>
        </div>
    </div>

    <script src="../js/jquery-1.11.3.min.js"></script>
    <script>
        function userAvailability() {
            $("#loaderIcon").show();
            jQuery.ajax({
                url: "check_emailavailability.php",
                data:'email='+$("#email").val(),
                type: "POST",
                success:function(data){
                    $("#user-availability-status1").html(data);
                    $("#loaderIcon").hide();
                },
                error:function (){}
            });
        }

        // File upload preview
        document.getElementById('logofile').addEventListener('change', function(e) {
            const fileName = e.target.files[0]?.name;
            if (fileName) {
                const uploadText = e.target.parentElement.querySelector('i').nextElementSibling;
                uploadText.textContent = fileName;
            }
        });
    </script>

</body>
</html>

<!-- Done 13 -->