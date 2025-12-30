<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');

if(isset($_POST['login'])) 
  {
    $username=$_POST['username'];
    $password=md5($_POST['password']);
    $sql ="SELECT ID FROM tbladmin WHERE UserName=:username and Password=:password";
    $query=$dbh->prepare($sql);
    $query-> bindParam(':username', $username, PDO::PARAM_STR);
$query-> bindParam(':password', $password, PDO::PARAM_STR);
    $query-> execute();
    $results=$query->fetchAll(PDO::FETCH_OBJ);
    if($query->rowCount() > 0)
{
foreach ($results as $result) {
$_SESSION['jpaid']=$result->ID;
}

  if(!empty($_POST["remember"])) {
//COOKIES for username
setcookie ("user_login",$_POST["username"],time()+ (10 * 365 * 24 * 60 * 60));
//COOKIES for password
setcookie ("userpassword",$_POST["password"],time()+ (10 * 365 * 24 * 60 * 60));
} else {
if(isset($_COOKIE["user_login"])) {
setcookie ("user_login","");
if(isset($_COOKIE["userpassword"])) {
setcookie ("userpassword","");
        }
      }
}
$_SESSION['login']=$_POST['username'];
echo "<script type='text/javascript'> document.location ='dashboard.php'; </script>";
} else{
echo "<script>alert('Invalid Details');</script>";
}
}

?>
<!doctype html>
<html lang="en">
    <head>       
        <title>Hanap-Kita - Admin Login</title>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
        <style>
            body {
                font-family: 'Inter', sans-serif;
                background: linear-gradient(135deg, #FEF7F0 0%, #FAF5F0 100%);
                margin: 0;
                padding: 20px;
                min-height: 100vh;
                display: flex;
                align-items: center;
                justify-content: center;
            }
            .login-container {
                background: white;
                padding: 40px;
                border-radius: 16px;
                box-shadow: 0 10px 30px rgba(0,0,0,0.1);
                width: 100%;
                max-width: 400px;
                border-top: 4px solid #FF6B00;
            }
            .logo {
                text-align: center;
                margin-bottom: 30px;
            }
            .logo h1 {
                color: #FF6B00;
                font-size: 28px;
                font-weight: 600;
                margin: 0;
            }
            .logo p {
                color: #718096;
                margin: 5px 0 0 0;
                font-size: 14px;
            }
            .form-group {
                margin-bottom: 20px;
            }
            .form-group label {
                display: block;
                margin-bottom: 8px;
                color: #2D3748;
                font-weight: 500;
                font-size: 14px;
            }
            .form-group input {
                width: 100%;
                padding: 12px 16px;
                border: 2px solid #E2E8F0;
                border-radius: 8px;
                font-size: 14px;
                transition: border-color 0.2s;
                box-sizing: border-box;
            }
            .form-group input:focus {
                outline: none;
                border-color: #FF6B00;
            }
            .checkbox-group {
                display: flex;
                align-items: center;
                gap: 8px;
                margin: 20px 0;
            }
            .checkbox-group label {
                margin: 0;
                font-size: 14px;
                color: #718096;
                cursor: pointer;
            }
            .login-btn {
                width: 100%;
                background: #FF6B00;
                color: white;
                border: none;
                padding: 14px;
                border-radius: 8px;
                font-size: 16px;
                font-weight: 500;
                cursor: pointer;
                transition: background-color 0.2s;
            }
            .login-btn:hover {
                background: #E55B00;
            }
            .links {
                text-align: center;
                margin-top: 20px;
                padding-top: 20px;
                border-top: 1px solid #E2E8F0;
            }
            .links a {
                color: #4299E1;
                text-decoration: none;
                font-size: 14px;
                margin: 0 10px;
            }
            .links a:hover {
                text-decoration: underline;
            }
        </style>
    </head>
    <body>
        <div class="login-container">
            <div class="logo">
                <h1>Hanap-Kita</h1>
                <p>Admin Dashboard</p>
            </div>
            
            <form method="post">
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" 
                           id="username"
                           name="username" 
                           required 
                           value="<?php if(isset($_COOKIE["user_login"])) { echo $_COOKIE["user_login"]; } ?>">
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" 
                           id="password"
                           name="password" 
                           required 
                           value="<?php if(isset($_COOKIE["userpassword"])) { echo $_COOKIE["userpassword"]; } ?>">
                </div>

                <div class="checkbox-group">
                    <input type="checkbox" 
                           id="remember" 
                           name="remember" 
                           <?php if(isset($_COOKIE["user_login"])) { ?> checked <?php } ?>>
                    <label for="remember">Keep me signed in</label>
                </div>

                <button type="submit" class="login-btn" name="login">
                    Sign In
                </button>
            </form>

            <div class="links">
                <a href="forgot-password.php">Forgot Password?</a>
                <a href="../index.php">Back to Home</a>
            </div>
        </div>

        <script>
            // Focus on first empty field
            document.addEventListener('DOMContentLoaded', function() {
                const username = document.getElementById('username');
                const password = document.getElementById('password');
                
                if (!username.value) {
                    username.focus();
                } else if (!password.value) {
                    password.focus();
                }
            });
        </script>
    </body>
</html>

<!-- Done 18 -->