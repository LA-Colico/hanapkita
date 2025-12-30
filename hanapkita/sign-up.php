<?php
session_start();
//Database Configuration File
include('includes/config.php');
error_reporting(0);
if(isset($_POST['signup']))
{
//Getting Post Values
$fname=$_POST['fullname'];  
$emaill=$_POST['emailid']; 
$cnumber=$_POST['contactnumber']; 
//Password hashing
$password=$_POST['jspassword'];
$options = ['cost' => 12];
$hashedpass=password_hash($password, PASSWORD_BCRYPT, $options);
//getting logo
$logo=$_FILES["resume"]["name"];
// get the image extension
$extension = substr($logo,strlen($logo)-4,strlen($logo));
// allowed extensions
$allowed_extensions = array(".pdf","docx",".doc");
// Validation for allowed extensions .in_array() function searches an array for a specific value.
if(!in_array($extension,$allowed_extensions))
{
echo "<script>alert('Invalid logo format. Only jpg / jpeg/ png /gif format allowed');</script>";
}
else
{
//rename the image file
$resumename=md5($logo).time().$extension;
// Code for move image into directory
move_uploaded_file($_FILES["resume"]["tmp_name"],"Jobseekersresumes/".$resumename);

// Query for validation of  email-id
$ret="SELECT * FROM  tbljobseekers where (EmailId=:uemail || ContactNumber=:cnumber)";
$queryt = $dbh -> prepare($ret);
$queryt->bindParam(':uemail',$emaill,PDO::PARAM_STR);
$queryt->bindParam(':cnumber',$cnumber,PDO::PARAM_STR);
$queryt -> execute();
$results = $queryt -> fetchAll(PDO::FETCH_OBJ);
if($queryt -> rowCount() == 0)
{
// Query for Insertion
$isactive=1;
$sql="INSERT INTO tbljobseekers(FullName,EmailId,ContactNumber,Password,Resume,IsActive) VALUES(:fname,:emaill,:cnumber,:hashedpass,:resumename,:isactive)";
$query = $dbh->prepare($sql);
// Binding Post Values
$query->bindParam(':fname',$fname,PDO::PARAM_STR);
$query->bindParam(':emaill',$emaill,PDO::PARAM_STR);
$query->bindParam(':cnumber',$cnumber,PDO::PARAM_STR);
$query->bindParam(':hashedpass',$hashedpass,PDO::PARAM_STR);
$query->bindParam(':resumename',$resumename,PDO::PARAM_STR);
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
$error="Email-id or Contact Number  already exist. Please try again";
}
}
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up - Hanap-Kita</title>
    
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
    <script>
        function useremailAvailability() {
            jQuery.ajax({
                url: "check_availability.php",
                data:'emailid='+$("#emailid").val(),
                type: "POST",
                success:function(data){
                    $("#user-emailavailability-status").html(data);
                },
                error:function (){}
            });
        }
    </script>
</head>

<body class="bg-gradient-to-br from-blue-50 to-indigo-100 min-h-screen py-8">
    
    <div class="max-w-2xl mx-auto px-4">
        <!-- Back to Home -->
        <div class="text-center mb-8">
            <a href="index.php" class="inline-flex items-center text-primary hover:text-primary-dark transition-colors">
                <i class="fas fa-arrow-left mr-2"></i>
                <span class="font-medium">Back to Home</span>
            </a>
        </div>
        
        <!-- Sign Up Card -->
        <div class="bg-white shadow-xl rounded-2xl p-8">
            <!-- Logo -->
            <div class="text-center mb-8">
                <h1 class="text-3xl font-bold text-primary mb-2">Hanap-Kita</h1>
                <h2 class="text-2xl font-semibold text-gray-900 mb-2">Create Your Account</h2>
                <p class="text-gray-600">Join thousands of job seekers</p>
            </div>

            <!-- Already have account -->
            <div class="bg-blue-50 border border-blue-200 rounded-xl p-4 mb-8">
                <div class="flex items-center justify-between">
                    <div>
                        <h4 class="font-semibold text-gray-900">Already have an account?</h4>
                        <p class="text-sm text-gray-600">Sign in to access your profile</p>
                    </div>
                    <a href="sign-in.php" class="bg-primary text-white px-4 py-2 rounded-lg hover:bg-primary-dark transition-colors">
                        <i class="fas fa-sign-in-alt mr-2"></i>Sign In
                    </a>
                </div>
            </div>

            <!-- Success and error messages -->
            <?php if(@$error){ ?>
                <div class="bg-red-50 border border-red-200 rounded-xl p-4 mb-6">
                    <div class="flex items-center">
                        <i class="fas fa-exclamation-circle text-red-500 mr-2"></i>
                        <span class="text-red-700 font-medium">Error:</span>
                        <span class="text-red-600 ml-2"><?php echo htmlentities($error);?></span>
                    </div>
                </div>
            <?php } ?>

            <?php if(@$msg){ ?>
                <div class="bg-green-50 border border-green-200 rounded-xl p-4 mb-6">
                    <div class="flex items-center">
                        <i class="fas fa-check-circle text-green-500 mr-2"></i>
                        <span class="text-green-700 font-medium">Success:</span>
                        <span class="text-green-600 ml-2"><?php echo htmlentities($msg);?></span>
                    </div>
                </div>
            <?php } ?>
            
            <!-- Sign Up Form -->
            <form name="empsignup" enctype="multipart/form-data" method="post" class="space-y-6">
                <!-- Full Name -->
                <div>
                    <label for="fullname" class="block text-sm font-medium text-gray-700 mb-2">
                        Full Name <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-user text-gray-400"></i>
                        </div>
                        <input type="text" 
                               id="fullname"
                               name="fullname" 
                               placeholder="Enter your full name" 
                               required 
                               autocomplete="off"
                               class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-colors">
                    </div>
                </div>

                <!-- Email -->
                <div>
                    <label for="emailid" class="block text-sm font-medium text-gray-700 mb-2">
                        Email Address <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-envelope text-gray-400"></i>
                        </div>
                        <input type="email" 
                               id="emailid"
                               name="emailid" 
                               onBlur="useremailAvailability()"
                               placeholder="you@example.com" 
                               autocomplete="off" 
                               required
                               class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-colors">
                    </div>
                    <span id="user-emailavailability-status" class="text-sm mt-1"></span>
                </div>

                <!-- Contact Number -->
                <div>
                    <label for="contactnumber" class="block text-sm font-medium text-gray-700 mb-2">
                        Contact Number <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-phone text-gray-400"></i>
                        </div>
                        <input type="text" 
                               id="contactnumber"
                               name="contactnumber" 
                               placeholder="09XXXXXXXXX" 
                               autocomplete="off" 
                               pattern="[0-9]+" 
                               title="only numeric digit allowed" 
                               maxlength="11" 
                               required
                               class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-colors">
                    </div>
                </div>

                <!-- Password -->
                <div>
                    <label for="jspassword" class="block text-sm font-medium text-gray-700 mb-2">
                        Password <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-lock text-gray-400"></i>
                        </div>
                        <input type="password" 
                               id="jspassword"
                               name="jspassword" 
                               placeholder="Create a strong password" 
                               autocomplete="off" 
                               pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,}" 
                               title="at least one number and one uppercase and lowercase letter, and at least 6 or more characters" 
                               required
                               class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-colors">
                    </div>
                    <p class="text-sm text-gray-500 mt-1">At least 6 characters with uppercase, lowercase, and numbers</p>
                </div>

                <!-- Resume Upload -->
                <div>
                    <label for="resume" class="block text-sm font-medium text-gray-700 mb-2">
                        Resume <span class="text-red-500">*</span>
                    </label>
                    <div class="border-2 border-dashed border-gray-300 rounded-xl p-6 text-center hover:border-primary transition-colors">
                        <div class="mb-4">
                            <i class="fas fa-file-upload text-4xl text-gray-400"></i>
                        </div>
                        <input type="file" 
                               id="resume"
                               name="resume" 
                               required
                               accept=".pdf,.doc,.docx"
                               class="hidden">
                        <label for="resume" class="cursor-pointer">
                            <span class="text-primary font-medium">Click to upload</span>
                            <span class="text-gray-600"> or drag and drop</span>
                        </label>
                        <p class="text-sm text-gray-500 mt-2">PDF, DOC, DOCX up to 10MB</p>
                    </div>
                </div>

                <!-- Sign Up Button -->
                <button type="submit" 
                        name="signup" 
                        id="submit"
                        class="w-full bg-primary text-white py-3 rounded-xl font-semibold hover:bg-primary-dark transition-colors focus:ring-2 focus:ring-primary focus:ring-offset-2">
                    Create Account
                </button>
            </form>

            <!-- Sign In Link -->
            <div class="text-center mt-8">
                <p class="text-gray-600">
                    Already have an account? 
                    <a href="sign-in.php" class="text-primary hover:text-primary-dark font-semibold transition-colors">
                        Sign in now
                    </a>
                </p>
            </div>
        </div>
    </div>

    <!-- jQuery for email availability check -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

</body>
</html>


<!-- Done 4 -->