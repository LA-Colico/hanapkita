<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');

if(isset($_POST['submit']))
  {
    $email=$_POST['email'];
$mobile=$_POST['mobile'];
$newpassword=md5($_POST['newpassword']);
  $sql ="SELECT Email FROM tbladmin WHERE Email=:email and MobileNumber=:mobile";
$query= $dbh -> prepare($sql);
$query-> bindParam(':email', $email, PDO::PARAM_STR);
$query-> bindParam(':mobile', $mobile, PDO::PARAM_STR);
$query-> execute();
$results = $query -> fetchAll(PDO::FETCH_OBJ);
if($query -> rowCount() > 0)
{
$con="update tbladmin set Password=:newpassword where Email=:email and MobileNumber=:mobile";
$chngpwd1 = $dbh->prepare($con);
$chngpwd1-> bindParam(':email', $email, PDO::PARAM_STR);
$chngpwd1-> bindParam(':mobile', $mobile, PDO::PARAM_STR);
$chngpwd1-> bindParam(':newpassword', $newpassword, PDO::PARAM_STR);
$chngpwd1->execute();
echo "<script>alert('Your Password succesfully changed');</script>";
}
else {
echo "<script>alert('Email id or Mobile no is invalid');</script>"; 
}
}

?>

<!doctype html>
<html lang="en" class="no-focus">
<head>       
    <title>Hanap-Kita - Password Recovery</title>
    <link rel="stylesheet" id="css-main" href="assets/css/codebase.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script type="text/javascript">
function valid()
{
if(document.chngpwd.newpassword.value!= document.chngpwd.confirmpassword.value)
{
alert("New Password and Confirm Password Field do not match  !!");
document.chngpwd.confirmpassword.focus();
return false;
}
return true;
}
</script>
    <style>
        :root {
            --primary-orange: #FF6B00;
            --light-orange: #FFE5D1;
            --bg-peach: #FEF7F0;
            --card-white: #FFFFFF;
            --text-dark: #2D3748;
            --text-gray: #718096;
            --text-light: #A0AEC0;
            --success-green: #48BB78;
            --info-blue: #4299E1;
            --warning-yellow: #F6E05E;
            --danger-red: #F56565;
            --shadow-soft: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            --shadow-card: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
            --shadow-xl: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
        }

        * { 
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            box-sizing: border-box;
        }

        body, html {
            margin: 0;
            padding: 0;
            height: 100%;
            background: linear-gradient(135deg, var(--bg-peach) 0%, #FAF5F0 100%);
            overflow-x: hidden;
        }

        /* Background Pattern */
        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: 
                radial-gradient(circle at 20% 50%, rgba(255, 107, 0, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 80% 20%, rgba(255, 107, 0, 0.05) 0%, transparent 50%),
                radial-gradient(circle at 40% 80%, rgba(255, 107, 0, 0.08) 0%, transparent 50%);
            z-index: -1;
        }

        .main-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem 1rem;
            position: relative;
        }

        /* Floating Elements */
        .floating-element {
            position: absolute;
            border-radius: 50%;
            background: linear-gradient(135deg, rgba(255, 107, 0, 0.1), rgba(255, 107, 0, 0.05));
            animation: float 6s ease-in-out infinite;
        }

        .floating-element:nth-child(1) {
            width: 80px;
            height: 80px;
            top: 10%;
            left: 10%;
            animation-delay: 0s;
        }

        .floating-element:nth-child(2) {
            width: 120px;
            height: 120px;
            top: 20%;
            right: 15%;
            animation-delay: 2s;
        }

        .floating-element:nth-child(3) {
            width: 60px;
            height: 60px;
            bottom: 20%;
            left: 20%;
            animation-delay: 4s;
        }

        .floating-element:nth-child(4) {
            width: 100px;
            height: 100px;
            bottom: 10%;
            right: 10%;
            animation-delay: 1s;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(180deg); }
        }

        .auth-card {
            background: var(--card-white);
            border-radius: 24px;
            padding: 3rem;
            box-shadow: var(--shadow-xl);
            border: 1px solid rgba(255, 107, 0, 0.1);
            width: 100%;
            max-width: 480px;
            position: relative;
            overflow: hidden;
        }

        .auth-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, var(--primary-orange), #FF8F42);
            border-radius: 24px 24px 0 0;
        }

        .auth-header {
            text-align: center;
            margin-bottom: 2rem;
        }

        .auth-icon {
            width: 80px;
            height: 80px;
            border-radius: 20px;
            background: linear-gradient(135deg, var(--primary-orange), #FF8F42);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 32px;
            margin: 0 auto 1.5rem auto;
            box-shadow: 0 8px 20px rgba(255, 107, 0, 0.3);
        }

        .auth-title {
            font-size: 2rem;
            font-weight: 700;
            color: var(--text-dark);
            margin: 0 0 0.5rem 0;
            background: linear-gradient(135deg, var(--primary-orange), #FF8F42);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .auth-subtitle {
            font-size: 1rem;
            color: var(--text-gray);
            margin: 0;
            line-height: 1.5;
        }

        .auth-form {
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
        }

        .form-group {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }

        .form-label {
            font-size: 0.875rem;
            font-weight: 600;
            color: var(--text-dark);
            margin: 0;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .form-label i {
            color: var(--primary-orange);
            font-size: 0.875rem;
        }

        .form-input {
            padding: 1rem 1.25rem;
            border: 2px solid rgba(255, 107, 0, 0.1);
            border-radius: 12px;
            background: var(--card-white);
            font-size: 1rem;
            transition: all 0.3s ease;
            position: relative;
        }

        .form-input:focus {
            outline: none;
            border-color: var(--primary-orange);
            box-shadow: 0 0 0 3px rgba(255, 107, 0, 0.1);
            background: rgba(255, 107, 0, 0.02);
        }

        .form-input::placeholder {
            color: var(--text-light);
        }

        .password-strength {
            font-size: 0.75rem;
            color: var(--text-gray);
            margin-top: 0.25rem;
            display: none;
        }

        .password-strength.show {
            display: block;
        }

        .strength-weak { color: var(--danger-red); }
        .strength-medium { color: var(--warning-yellow); }
        .strength-strong { color: var(--success-green); }

        .form-button {
            padding: 1rem 2rem;
            border: none;
            border-radius: 12px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.75rem;
            margin-top: 1rem;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary-orange), #FF8F42);
            color: white;
            box-shadow: 0 4px 12px rgba(255, 107, 0, 0.3);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(255, 107, 0, 0.4);
        }

        .btn-primary:active {
            transform: translateY(0);
        }

        .auth-links {
            text-align: center;
            margin-top: 2rem;
            padding-top: 1.5rem;
            border-top: 1px solid rgba(255, 107, 0, 0.1);
        }

        .auth-link {
            color: var(--primary-orange);
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            margin: 0 1rem;
        }

        .auth-link:hover {
            color: #FF8F42;
            text-decoration: none;
            transform: translateY(-1px);
        }

        .auth-link i {
            font-size: 0.875rem;
        }

        /* Security Info */
        .security-info {
            background: rgba(72, 187, 120, 0.05);
            border: 1px solid rgba(72, 187, 120, 0.2);
            border-radius: 12px;
            padding: 1rem;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .security-icon {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            background: var(--success-green);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
            flex-shrink: 0;
        }

        .security-text {
            flex: 1;
        }

        .security-text h4 {
            font-size: 0.875rem;
            font-weight: 600;
            color: var(--text-dark);
            margin: 0 0 0.25rem 0;
        }

        .security-text p {
            font-size: 0.75rem;
            color: var(--text-gray);
            margin: 0;
            line-height: 1.4;
        }

        /* Steps Indicator */
        .steps-container {
            display: flex;
            justify-content: center;
            margin-bottom: 2rem;
            gap: 1rem;
        }

        .step {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 500;
            background: rgba(255, 107, 0, 0.1);
            color: var(--primary-orange);
        }

        .step.active {
            background: var(--primary-orange);
            color: white;
        }

        .step i {
            font-size: 0.875rem;
        }

        /* Loading State */
        .loading {
            opacity: 0.7;
            pointer-events: none;
        }

        .loading .form-button {
            background: var(--text-gray);
        }

        /* Success/Error Messages */
        .message {
            padding: 1rem;
            border-radius: 12px;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            font-size: 0.875rem;
            font-weight: 500;
        }

        .message-success {
            background: rgba(72, 187, 120, 0.1);
            border: 1px solid rgba(72, 187, 120, 0.2);
            color: var(--success-green);
        }

        .message-error {
            background: rgba(245, 101, 101, 0.1);
            border: 1px solid rgba(245, 101, 101, 0.2);
            color: var(--danger-red);
        }

        .message i {
            font-size: 1rem;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .main-container {
                padding: 1rem;
            }
            
            .auth-card {
                padding: 2rem 1.5rem;
                border-radius: 16px;
            }
            
            .auth-title {
                font-size: 1.5rem;
            }
            
            .floating-element {
                display: none;
            }
        }

        @media (max-width: 480px) {
            .auth-card {
                padding: 1.5rem 1rem;
            }
            
            .auth-icon {
                width: 60px;
                height: 60px;
                font-size: 24px;
            }
            
            .steps-container {
                flex-direction: column;
                align-items: center;
            }
            
            .auth-links {
                margin-top: 1.5rem;
            }
            
            .auth-link {
                display: block;
                margin: 0.5rem 0;
            }
        }

        /* Animations */
        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .auth-card {
            animation: slideUp 0.6s ease-out;
        }

        .form-group {
            animation: slideUp 0.6s ease-out;
            animation-fill-mode: both;
        }

        .form-group:nth-child(1) { animation-delay: 0.1s; }
        .form-group:nth-child(2) { animation-delay: 0.2s; }
        .form-group:nth-child(3) { animation-delay: 0.3s; }
        .form-group:nth-child(4) { animation-delay: 0.4s; }
        .form-button { animation-delay: 0.5s; }
        .auth-links { animation-delay: 0.6s; }
    </style>
</head>
<body>
    <!-- Floating Background Elements -->
    <div class="floating-element"></div>
    <div class="floating-element"></div>
    <div class="floating-element"></div>
    <div class="floating-element"></div>

    <div class="main-container">
        <div class="auth-card">
            <!-- Header -->
            <div class="auth-header">
                <div class="auth-icon">
                    <i class="fas fa-key"></i>
                </div>
                <h1 class="auth-title">Password Recovery</h1>
                <p class="auth-subtitle">Don't worry, we'll help you reset your password securely</p>
            </div>

            <!-- Steps Indicator -->
            <div class="steps-container">
                <div class="step active">
                    <i class="fas fa-user-check"></i>
                    <span>Verify Identity</span>
                </div>
                <div class="step">
                    <i class="fas fa-lock"></i>
                    <span>New Password</span>
                </div>
            </div>

            <!-- Security Info -->
            <div class="security-info">
                <div class="security-icon">
                    <i class="fas fa-shield-alt"></i>
                </div>
                <div class="security-text">
                    <h4>Secure Password Reset</h4>
                    <p>We'll verify your identity using your registered email and mobile number before allowing password reset.</p>
                </div>
            </div>

            <!-- Password Reset Form -->
            <form class="auth-form" method="post" name="chngpwd" onSubmit="return valid();">
                <div class="form-group">
                    <label class="form-label">
                        <i class="fas fa-envelope"></i>
                        Email Address
                    </label>
                    <input 
                        type="email" 
                        class="form-input" 
                        name="email" 
                        required="true"
                        placeholder="Enter your registered email"
                        autocomplete="email"
                    >
                </div>

                <div class="form-group">
                    <label class="form-label">
                        <i class="fas fa-mobile-alt"></i>
                        Mobile Number
                    </label>
                    <input 
                        type="text" 
                        class="form-input" 
                        name="mobile" 
                        required="true" 
                        maxlength="10" 
                        pattern="[0-9]+"
                        placeholder="Enter your registered mobile number"
                        autocomplete="tel"
                    >
                </div>

                <div class="form-group">
                    <label class="form-label">
                        <i class="fas fa-lock"></i>
                        New Password
                    </label>
                    <input 
                        type="password" 
                        class="form-input" 
                        name="newpassword" 
                        required="true"
                        placeholder="Enter your new password"
                        id="newPassword"
                        autocomplete="new-password"
                    >
                    <div class="password-strength" id="passwordStrength"></div>
                </div>

                <div class="form-group">
                    <label class="form-label">
                        <i class="fas fa-lock"></i>
                        Confirm Password
                    </label>
                    <input 
                        type="password" 
                        class="form-input" 
                        name="confirmpassword" 
                        required="true"
                        placeholder="Confirm your new password"
                        id="confirmPassword"
                        autocomplete="new-password"
                    >
                </div>

                <button type="submit" class="form-button btn-primary" name="submit" id="submitBtn">
                    <i class="fas fa-key"></i>
                    Reset Password
                </button>
            </form>

            <!-- Links -->
            <div class="auth-links">
                <a href="index.php" class="auth-link">
                    <i class="fas fa-sign-in-alt"></i>
                    Back to Sign In
                </a>
                <a href="../index.php" class="auth-link">
                    <i class="fas fa-home"></i>
                    Back to Home
                </a>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="assets/js/core/jquery.min.js"></script>
    <script src="assets/js/core/popper.min.js"></script>
    <script src="assets/js/core/bootstrap.min.js"></script>
    <script src="assets/js/core/jquery.slimscroll.min.js"></script>
    <script src="assets/js/core/jquery.scrollLock.min.js"></script>
    <script src="assets/js/core/jquery.appear.min.js"></script>
    <script src="assets/js/core/jquery.countTo.min.js"></script>
    <script src="assets/js/core/js.cookie.min.js"></script>
    <script src="assets/js/codebase.js"></script>

    <!-- Page JS Plugins -->
    <script src="assets/js/plugins/jquery-validation/jquery.validate.min.js"></script>

    <!-- Page JS Code -->
    <script src="assets/js/pages/op_auth_signin.js"></script>

    <script>
        // Password strength checker
        function checkPasswordStrength(password) {
            const strengthIndicator = document.getElementById('passwordStrength');
            let strength = 0;
            let feedback = '';

            if (password.length >= 8) strength++;
            if (password.match(/[a-z]/)) strength++;
            if (password.match(/[A-Z]/)) strength++;
            if (password.match(/[0-9]/)) strength++;
            if (password.match(/[^a-zA-Z0-9]/)) strength++;

            strengthIndicator.classList.add('show');

            switch (strength) {
                case 0:
                case 1:
                case 2:
                    strengthIndicator.className = 'password-strength show strength-weak';
                    feedback = 'Weak - Use at least 8 characters with numbers and symbols';
                    break;
                case 3:
                case 4:
                    strengthIndicator.className = 'password-strength show strength-medium';
                    feedback = 'Medium - Add more variety to make it stronger';
                    break;
                case 5:
                    strengthIndicator.className = 'password-strength show strength-strong';
                    feedback = 'Strong - Great password!';
                    break;
            }

            strengthIndicator.textContent = feedback;
        }

        // Real-time password validation
        document.getElementById('newPassword').addEventListener('input', function(e) {
            checkPasswordStrength(e.target.value);
        });

        // Confirm password validation
        document.getElementById('confirmPassword').addEventListener('input', function(e) {
            const newPassword = document.getElementById('newPassword').value;
            const confirmPassword = e.target.value;
            
            if (confirmPassword && newPassword !== confirmPassword) {
                e.target.style.borderColor = 'var(--danger-red)';
                e.target.style.backgroundColor = 'rgba(245, 101, 101, 0.05)';
            } else {
                e.target.style.borderColor = 'rgba(255, 107, 0, 0.1)';
                e.target.style.backgroundColor = 'var(--card-white)';
            }
        });

        // Form submission with loading state
        document.querySelector('.auth-form').addEventListener('submit', function(e) {
            const submitBtn = document.getElementById('submitBtn');
            const form = e.target;
            
            // Add loading state
            form.classList.add('loading');
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Processing...';
            
            // Remove loading state after form validation
            setTimeout(() => {
                if (!valid()) {
                    form.classList.remove('loading');
                    submitBtn.innerHTML = '<i class="fas fa-key"></i> Reset Password';
                }
            }, 100);
        });

        // Enhanced input focus effects
        document.querySelectorAll('.form-input').forEach(input => {
            input.addEventListener('focus', function() {
                this.parentElement.style.transform = 'translateY(-2px)';
            });
            
            input.addEventListener('blur', function() {
                this.parentElement.style.transform = 'translateY(0)';
            });
        });

        // Mobile number formatting
        document.querySelector('input[name="mobile"]').addEventListener('input', function(e) {
            // Remove any non-digit characters
            this.value = this.value.replace(/\D/g, '');
        });

        // Auto-focus next field on Enter
        document.querySelectorAll('.form-input').forEach((input, index, inputs) => {
            input.addEventListener('keydown', function(e) {
                if (e.key === 'Enter' && index < inputs.length - 1) {
                    e.preventDefault();
                    inputs[index + 1].focus();
                }
            });
        });

        // Enhanced validation messages
        function showMessage(message, type = 'success') {
            // Remove existing messages
            const existingMessage = document.querySelector('.message');
            if (existingMessage) {
                existingMessage.remove();
            }

            const messageDiv = document.createElement('div');
            messageDiv.className = `message message-${type}`;
            
            const icon = type === 'success' ? 'check-circle' : 'exclamation-triangle';
            messageDiv.innerHTML = `
                <i class="fas fa-${icon}"></i>
                <span>${message}</span>
            `;

            const form = document.querySelector('.auth-form');
            form.insertBefore(messageDiv, form.firstChild);

            // Auto-remove after 5 seconds
            setTimeout(() => {
                messageDiv.style.opacity = '0';
                setTimeout(() => messageDiv.remove(), 300);
            }, 5000);
        }

        // Override default alerts with custom messages
        const originalAlert = window.alert;
        window.alert = function(message) {
            if (message.includes('successfully')) {
                showMessage(message, 'success');
                // Redirect to login after success
                setTimeout(() => {
                    window.location.href = 'index.php';
                }, 2000);
            } else {
                showMessage(message, 'error');
            }
        };
    </script>
</body>
</html>
<!-- Done 18 -->