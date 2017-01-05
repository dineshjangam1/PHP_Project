<?php
include '../libraries/database.php';
function verify($uname,$acode)
{
	$conn = dbConnect();
	//"UPDATE `users` SET `activation_code` = NULL WHERE `Email` = ?";

	$sql = "Update users SET activation_code = NULL WHERE Email = '".mysqli_real_escape_string($conn,$uname)."'AND activation_code = '".mysqli_real_escape_string($conn,$acode)."'";
 if($conn->query($sql)=== TRUE)
        {
        	echo "Thank you for verifying plz wait while you are automatically redirected";
			//header( "refresh:5;url=../views/Login.php" );
			return TRUE;
        }
		else
		{
			die("Error: <br> :( Sorry cannot update. Please contact support at support@Duplicate App.com");
		}
  }
?>