
<!-- Done 11 -->
<?php 
require_once("includes/config.php");

if(!empty($_POST["emailid"])) {
echo $email= $_POST["emailid"];
exit();
	if (filter_var($email, FILTER_VALIDATE_EMAIL)===false) {

		echo "error : You did not enter a valid email.";
	}
else {
$sql ="SELECT EmailId FROM tbljobseekers WHERE EmailId=:email";
$query= $dbh -> prepare($sql);
$query-> bindParam(':email', $email, PDO::PARAM_STR);
$query-> execute();
$results = $query -> fetchAll(PDO::FETCH_OBJ);
if($query -> rowCount() > 0)
{
echo "<div class='flex items-center space-x-2 mt-2'>
        <div class='flex-shrink-0'>
            <div class='w-5 h-5 bg-red-100 rounded-full flex items-center justify-center'>
                <i class='fas fa-times text-red-500 text-xs'></i>
            </div>
        </div>
        <span class='text-sm text-red-600 font-medium'>Email already exists</span>
      </div>";
 echo "<script>$('#submit').prop('disabled',true).removeClass('bg-primary hover:bg-primary-dark').addClass('bg-gray-300 cursor-not-allowed');</script>";
} else{
	
	echo "<div class='flex items-center space-x-2 mt-2'>
            <div class='flex-shrink-0'>
                <div class='w-5 h-5 bg-green-100 rounded-full flex items-center justify-center'>
                    <i class='fas fa-check text-green-500 text-xs'></i>
                </div>
            </div>
            <span class='text-sm text-green-600 font-medium'>Email available for registration</span>
          </div>";
 echo "<script>$('#submit').prop('disabled',false).removeClass('bg-gray-300 cursor-not-allowed').addClass('bg-primary hover:bg-primary-dark');</script>";
}
}
}