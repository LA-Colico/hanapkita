<?php
// DB credentials.
// Copy this file to config.php and update with your actual database credentials
define('DB_HOST','localhost');
define('DB_USER','your_database_username');
define('DB_PASS','your_database_password');
define('DB_NAME','hanapkita');
// Establish database connection.
try
{
$dbh = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME,DB_USER, DB_PASS);
}
catch (PDOException $e)
{
exit("Error: " . $e->getMessage());
}
?>
