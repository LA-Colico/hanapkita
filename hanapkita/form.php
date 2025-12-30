<?php
    // EDIT THE 2 LINES BELOW AS REQUIRED
    $email_to = "crunchpress@info.com";
    $email_subject = "New Membership Form Submission";
	$error_message = '';

    // validation
    if(
        !isset($_POST['name']) ||
		!isset($_POST['email']) ||
		!isset($_POST['website']) ||
		!isset($_POST['comments']))
		{
			echo "Fields are not filled properly";
			die();
    }

    $name = $_POST['name']; // required
	$email = $_POST['email']; // required
	$subject = $_POST['website']; // required
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
$email_message .= "<tr><td><strong>website:</strong> </td><td>" . strip_tags($_POST['website']) . "</td></tr>";
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
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Hanap-Kita - Thank You</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: #fafbfc;
            line-height: 1.6;
            color: #374151;
        }

        /* Header Styles */
        .modern-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 1rem 0;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }

        .navbar {
            background: transparent !important;
            padding: 0.5rem 0;
        }

        .navbar-brand {
            font-size: 1.8rem;
            font-weight: 800;
            color: white !important;
            text-decoration: none;
        }

        .navbar-nav .nav-link {
            color: rgba(255, 255, 255, 0.9) !important;
            font-weight: 500;
            margin: 0 0.5rem;
            padding: 0.5rem 1rem !important;
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .navbar-nav .nav-link:hover {
            background: rgba(255, 255, 255, 0.1);
            color: white !important;
        }

        .navbar-toggler {
            border: none;
            color: white;
        }

        .navbar-toggler:focus {
            box-shadow: none;
        }

        /* Hero Section */
        .hero-section {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 4rem 0;
            text-align: center;
            color: white;
        }

        .hero-title {
            font-size: 3.5rem;
            font-weight: 800;
            margin-bottom: 1rem;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .hero-subtitle {
            font-size: 1.25rem;
            font-weight: 400;
            opacity: 0.9;
            max-width: 600px;
            margin: 0 auto;
        }

        /* Thank You Section */
        .thank-you-section {
            padding: 5rem 0;
            background: white;
        }

        .thank-you-card {
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
            padding: 3rem;
            text-align: center;
            max-width: 600px;
            margin: 0 auto;
            border: 1px solid rgba(0, 0, 0, 0.05);
        }

        .thank-you-icon {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 2rem;
            color: white;
            font-size: 2rem;
        }

        .thank-you-title {
            font-size: 2.5rem;
            font-weight: 700;
            color: #1f2937;
            margin-bottom: 1rem;
        }

        .thank-you-message {
            font-size: 1.1rem;
            color: #6b7280;
            line-height: 1.8;
            margin-bottom: 2rem;
        }

        .back-home-btn {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 0.75rem 2rem;
            border-radius: 12px;
            text-decoration: none;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            transition: all 0.3s ease;
            border: none;
        }

        .back-home-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(102, 126, 234, 0.4);
            color: white;
        }

        /* Footer */
        .modern-footer {
            background: #1f2937;
            color: white;
            padding: 3rem 0 1rem;
        }

        .footer-section {
            margin-bottom: 2rem;
        }

        .footer-title {
            font-size: 1.25rem;
            font-weight: 700;
            margin-bottom: 1rem;
            color: white;
        }

        .footer-links {
            list-style: none;
            padding: 0;
        }

        .footer-links li {
            margin-bottom: 0.5rem;
        }

        .footer-links a {
            color: #d1d5db;
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .footer-links a:hover {
            color: #667eea;
        }

        .footer-text {
            color: #d1d5db;
            line-height: 1.8;
        }

        .newsletter-form {
            display: flex;
            gap: 0.5rem;
            margin-top: 1rem;
        }

        .newsletter-input {
            flex: 1;
            padding: 0.75rem;
            border: 1px solid #374151;
            border-radius: 8px;
            background: #374151;
            color: white;
        }

        .newsletter-input::placeholder {
            color: #9ca3af;
        }

        .newsletter-btn {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            padding: 0.75rem 1.5rem;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .newsletter-btn:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
        }

        .footer-bottom {
            border-top: 1px solid #374151;
            padding-top: 2rem;
            margin-top: 2rem;
            text-align: center;
        }

        .social-links {
            display: flex;
            justify-content: center;
            gap: 1rem;
            margin-bottom: 1rem;
        }

        .social-links a {
            width: 40px;
            height: 40px;
            background: #374151;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .social-links a:hover {
            background: #667eea;
            transform: translateY(-2px);
        }

        .copyright {
            color: #9ca3af;
            font-size: 0.9rem;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .hero-title {
                font-size: 2.5rem;
            }

            .hero-subtitle {
                font-size: 1.1rem;
            }

            .thank-you-card {
                padding: 2rem;
                margin: 0 1rem;
            }

            .thank-you-title {
                font-size: 2rem;
            }

            .newsletter-form {
                flex-direction: column;
            }
        }
    </style>
</head>

<body>
    <!-- Modern Header -->
    <header class="modern-header">
        <div class="container">
            <nav class="navbar navbar-expand-lg">
                <a class="navbar-brand" href="index.php">
                    <i class="fas fa-briefcase me-2"></i>Hanap-Kita
                </a>
                
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                    <i class="fas fa-bars"></i>
                </button>
                
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="index.php">
                                <i class="fas fa-home me-1"></i>Home
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="about.php">
                                <i class="fas fa-info-circle me-1"></i>About
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="contact.php">
                                <i class="fas fa-envelope me-1"></i>Contact
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container">
            <h1 class="hero-title">Thank You!</h1>
            <p class="hero-subtitle">Your message has been received successfully</p>
        </div>
    </section>

    <!-- Thank You Content -->
    <section class="thank-you-section">
        <div class="container">
            <div class="thank-you-card">
                <div class="thank-you-icon">
                    <i class="fas fa-check"></i>
                </div>
                <h2 class="thank-you-title">Thank You</h2>
                <p class="thank-you-message">
                    Thank you for your form submission. We have received your message and will get back to you shortly. 
                    Our team will review your submission and respond as soon as possible.
                </p>
                <a href="index.php" class="back-home-btn">
                    <i class="fas fa-home"></i>
                    Back to Home
                </a>
            </div>
        </div>
    </section>

    <!-- Modern Footer -->
    <footer class="modern-footer">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-md-6 footer-section">
                    <h4 class="footer-title">About Hanap-Kita</h4>
                    <p class="footer-text">
                        Connecting local talent with opportunities. We help job seekers find their perfect career match 
                        and assist employers in discovering the right candidates for their organization.
                    </p>
                </div>
                
                <div class="col-lg-2 col-md-6 footer-section">
                    <h4 class="footer-title">Quick Links</h4>
                    <ul class="footer-links">
                        <li><a href="index.php">Home</a></li>
                        <li><a href="about.php">About</a></li>
                        <li><a href="contact.php">Contact</a></li>
                        <li><a href="sign-up.php">Sign Up</a></li>
                    </ul>
                </div>
                
                <div class="col-lg-2 col-md-6 footer-section">
                    <h4 class="footer-title">For Job Seekers</h4>
                    <ul class="footer-links">
                        <li><a href="sign-up.php">Create Profile</a></li>
                        <li><a href="index.php">Browse Jobs</a></li>
                        <li><a href="applied-jobs.php">Applied Jobs</a></li>
                        <li><a href="my-profile.php">My Profile</a></li>
                    </ul>
                </div>
                
                <div class="col-lg-2 col-md-6 footer-section">
                    <h4 class="footer-title">For Employers</h4>
                    <ul class="footer-links">
                        <li><a href="employers/emp-login.php">Employer Login</a></li>
                        <li><a href="employers/employers-signup.php">Post a Job</a></li>
                        <li><a href="employers/candidates-listings.php">Find Candidates</a></li>
                        <li><a href="employers/job-listing.php">Manage Jobs</a></li>
                    </ul>
                </div>
                
                <div class="col-lg-2 col-md-6 footer-section">
                    <h4 class="footer-title">Stay Updated</h4>
                    <p class="footer-text">Subscribe for latest job alerts</p>
                    <form class="newsletter-form" action="#">
                        <input type="email" class="newsletter-input" placeholder="Your email" required>
                        <button type="submit" class="newsletter-btn">
                            <i class="fas fa-paper-plane"></i>
                        </button>
                    </form>
                </div>
            </div>
            
            <div class="footer-bottom">
                <div class="social-links">
                    <a href="#"><i class="fab fa-facebook-f"></i></a>
                    <a href="#"><i class="fab fa-twitter"></i></a>
                    <a href="#"><i class="fab fa-linkedin-in"></i></a>
                    <a href="#"><i class="fab fa-instagram"></i></a>
                </div>
                <p class="copyright">
                    &copy; 2024 Hanap-Kita. All rights reserved. | 
                    <a href="#" style="color: #667eea;">Privacy Policy</a> | 
                    <a href="#" style="color: #667eea;">Terms of Service</a>
                </p>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<!-- Done 15 -->