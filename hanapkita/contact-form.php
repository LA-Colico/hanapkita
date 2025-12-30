<?php
    // EDIT THE 2 LINES BELOW AS REQUIRED
    $email_to = "crunchpress@info.com";
    $email_subject = "New Membership Form Submission";
	$error_message = '';

    // validation
    if(
        !isset($_POST['name']) ||
		!isset($_POST['email']) ||
		!isset($_POST['subject']) ||
		!isset($_POST['comments']))
		
		{
			echo "Fields are not filled properly";
			die();
    }

    $name = $_POST['name']; // required
	$email = $_POST['email']; // required
	$subject = $_POST['subject']; // required
	$comments = $_POST['comments'];

$email_message = '<html>';
$email_message = '<body>';
$email_message = '<head>';
$email_message = '<title>Your Details Are Below</title>';
$email_message = '</head>';
$email_message .= '<h1>Your Details Are Below</h1>';
$email_message .= '<table rules="all" style="border-color: #666;" cellpadding="10">';
$email_message .= "<tr style='background: #eee;'><td><strong>Name:</strong> </td><td>" . strip_tags($_POST['name']) . "</td></tr>";
$email_message .= "<tr><td><strong>Email:</strong> </td><td>" . strip_tags($_POST['email']) . "</td></tr>";
$email_message .= "<tr><td><strong>subject:</strong> </td><td>" . strip_tags($_POST['subject']) . "</td></tr>";
$email_message .= "<tr><td><strong>Comments:</strong> </td><td>" . strip_tags($_POST['comments']) . "</td></tr>";
$email_message .= "</table>";
$email_message .= "</body></html>";	

$headers = "From: " . $email . "\r\n";
$headers .= "Reply-To: ". $email . "\r\n";
$headers .= "CC: susan@example.com\r\n";
$headers .= "MIME-Version: 1.0\r\n";
$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

@mail($email_to, $email_subject, $email_message, $headers); 
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thank You - Hanap-Kita</title>
    
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
                
                <!-- Mobile menu button -->
                <div class="md:hidden">
                    <button class="text-gray-500 hover:text-gray-700">
                        <i class="fas fa-bars text-xl"></i>
                    </button>
                </div>
            </div>
        </div>
    </header>

    <!-- Thank You Section -->
    <section class="min-h-screen bg-gradient-to-br from-green-50 to-blue-50 flex items-center justify-center py-20">
        <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <!-- Success Icon -->
            <div class="w-24 h-24 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-8">
                <i class="fas fa-check text-green-600 text-4xl"></i>
            </div>
            
            <!-- Thank You Message -->
            <h1 class="text-4xl md:text-5xl font-bold text-gray-900 mb-6">
                Thank <span class="text-primary">You!</span>
            </h1>
            
            <div class="bg-white rounded-2xl shadow-lg p-8 mb-8">
                <div class="w-16 h-16 bg-primary bg-opacity-10 rounded-full flex items-center justify-center mx-auto mb-6">
                    <i class="fas fa-envelope text-primary text-2xl"></i>
                </div>
                
                <h2 class="text-2xl font-semibold text-gray-900 mb-4">Message Sent Successfully</h2>
                <p class="text-lg text-gray-600 mb-6">
                    Thank you for your form submission. We have received your message and will get back to you shortly.
                </p>
                
                <div class="bg-gray-50 rounded-xl p-6 mb-6">
                    <h3 class="font-semibold text-gray-900 mb-3">What happens next?</h3>
                    <div class="space-y-3 text-left">
                        <div class="flex items-center space-x-3">
                            <div class="w-6 h-6 bg-primary rounded-full flex items-center justify-center flex-shrink-0">
                                <span class="text-white text-xs font-bold">1</span>
                            </div>
                            <span class="text-gray-600">Our team will review your message</span>
                        </div>
                        <div class="flex items-center space-x-3">
                            <div class="w-6 h-6 bg-primary rounded-full flex items-center justify-center flex-shrink-0">
                                <span class="text-white text-xs font-bold">2</span>
                            </div>
                            <span class="text-gray-600">We'll respond within 24-48 hours</span>
                        </div>
                        <div class="flex items-center space-x-3">
                            <div class="w-6 h-6 bg-primary rounded-full flex items-center justify-center flex-shrink-0">
                                <span class="text-white text-xs font-bold">3</span>
                            </div>
                            <span class="text-gray-600">Check your email for our response</span>
                        </div>
                    </div>
                </div>
                
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="index.php" 
                       class="bg-primary text-white px-6 py-3 rounded-xl font-semibold hover:bg-primary-dark transition-colors inline-flex items-center justify-center">
                        <i class="fas fa-home mr-2"></i>Back to Home
                    </a>
                    <a href="contact.php" 
                       class="bg-white border-2 border-primary text-primary px-6 py-3 rounded-xl font-semibold hover:bg-primary hover:text-white transition-colors inline-flex items-center justify-center">
                        <i class="fas fa-envelope mr-2"></i>Send Another Message
                    </a>
                </div>
            </div>
            
            <!-- Additional Resources -->
            <div class="grid md:grid-cols-3 gap-6 mt-12">
                <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
                    <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-search text-blue-600 text-xl"></i>
                    </div>
                    <h3 class="font-semibold text-gray-900 mb-2">Browse Jobs</h3>
                    <p class="text-gray-600 text-sm mb-4">Explore our latest job opportunities while you wait.</p>
                    <a href="index.php" class="text-primary hover:text-primary-dark font-medium text-sm">
                        View Jobs <i class="fas fa-arrow-right ml-1"></i>
                    </a>
                </div>
                
                <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
                    <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-user-plus text-green-600 text-xl"></i>
                    </div>
                    <h3 class="font-semibold text-gray-900 mb-2">Join Us</h3>
                    <p class="text-gray-600 text-sm mb-4">Create an account to access exclusive features.</p>
                    <a href="sign-up.php" class="text-primary hover:text-primary-dark font-medium text-sm">
                        Sign Up <i class="fas fa-arrow-right ml-1"></i>
                    </a>
                </div>
                
                <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
                    <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-info-circle text-purple-600 text-xl"></i>
                    </div>
                    <h3 class="font-semibold text-gray-900 mb-2">Learn More</h3>
                    <p class="text-gray-600 text-sm mb-4">Discover how Hanap-Kita can help your career.</p>
                    <a href="about.php" class="text-primary hover:text-primary-dark font-medium text-sm">
                        About Us <i class="fas fa-arrow-right ml-1"></i>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h3 class="text-2xl font-bold text-primary mb-4">Hanap-Kita</h3>
                <p class="text-gray-400 mb-8">Connecting Local Talent with Opportunity</p>
                
                <div class="flex justify-center space-x-6 mb-8">
                    <a href="#" class="text-gray-400 hover:text-white transition-colors">
                        <i class="fab fa-facebook-f text-xl"></i>
                    </a>
                    <a href="#" class="text-gray-400 hover:text-white transition-colors">
                        <i class="fab fa-twitter text-xl"></i>
                    </a>
                    <a href="#" class="text-gray-400 hover:text-white transition-colors">
                        <i class="fab fa-linkedin-in text-xl"></i>
                    </a>
                    <a href="#" class="text-gray-400 hover:text-white transition-colors">
                        <i class="fab fa-instagram text-xl"></i>
                    </a>
                </div>
                
                <div class="border-t border-gray-800 pt-8">
                    <p class="text-gray-400">&copy; 2024 Hanap-Kita. All rights reserved.</p>
                </div>
            </div>
        </div>
    </footer>

</body>
</html>

<!-- Done 13 -->