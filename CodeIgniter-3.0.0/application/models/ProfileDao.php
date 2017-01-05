<?php
session_start();
include '../libraries/database.php';

//$profile associative array holds profile values
function updateProfile($profile)
{
	$user = $_SESSION['userid'];
	$conn = dbConnect();
	$pkeys = array_keys($profile);
	$pkcount = count($profile);
	//$cols ='';
	//$vals ='';
	$set='';

	//populate colums
	/*
	for ($i=0; $i < $pkcount; $i++) 
	{ 
		$cols= $cols.$pkeys[$i];
		if($i< ($pkcount-1))
		{
			$cols= $cols.',';
		}
	}*/
	
	//populate values
	foreach ($profile as $key => $value) 
	{
		//$vals = $vals."'".mysqli_real_escape_string($conn, $value)."'";
		if(strcmp($value,'')!=0)
		{
			$set = $set.$key."='".mysqli_real_escape_string($conn, $value)."'";
		
			if(strcmp($key, $pkeys[($pkcount-1)])!=0)
			{
				//$vals = $vals.",";
				$set = $set.",";
			}
		}
	}
	
	//$sqlinsert= "INSERT INTO users (".$cols.") VALUES (".$vals.")";
	$sqledit="UPDATE users  SET ".$set." WHERE uid =".$user." AND deleted=0";
	
	if ($conn->query($sqledit) === TRUE) 
	{
		$conn->close();		
	    //echo "Record updated successfully";
		//echo $sqledit;
		return TRUE;
	} 
	else 
	{
	    //echo "Error: " . $sqledit . "<br>" . $conn->error;
		$conn->close();
		return FALSE;
	}
}
/*
function editprof()
{
	$conn = dbConnect();
	$sqledit="UPDATE userprofile  SET lastname='Doeafterediting' WHERE email='john@example.com'";
	if ($conn->query($sqledit) === TRUE) 
	{
	    echo "New record updated successfully";
	} 
	else 
	{
	    echo " Upadtion Error : " . $sqledit . "<br>" . $conn->error;
	}
	$conn->close();
}*/
/**
 * Retuns an associative array with the values for the profile identified with the user id number specified by $user
 */
function getProfile($user){
$conn = dbConnect();
$sqlshow="SELECT firstname as 'First Name', lastname as 'Last Name', Work, Education, currentcity as 'Current City',
 Website, Languages FROM users WHERE uid=".$user." AND deleted= 0";

 $result = $conn->query($sqlshow);
$row= $result->fetch_assoc();

//echo "email id: " . $row["email"]. " - Name: " . $row["firstname"]. " " . $row["lastname"]. "<br>";
//echo "Name :" .$row["firstname"]. "<br>" ."Last Name :" .$row["lastname"]. "<br>";
$conn->close();
return $row;
}

function getProfile1($user){
$conn = dbConnect();
$sqlshow="SELECT Work, Education, currentcity as 'Current City', Hometown, Nickname, Website, Languages FROM users WHERE uid=".$user." AND deleted= 0";

 $result = $conn->query($sqlshow);
$row= $result->fetch_assoc();

//echo "email id: " . $row["email"]. " - Name: " . $row["firstname"]. " " . $row["lastname"]. "<br>";
//echo "Name :" .$row["firstname"]. "<br>" ."Last Name :" .$row["lastname"]. "<br>";
$conn->close();
return $row;
}

function makeRequest($uid)
{
	$conn = dbConnect();
	$test = "Select * from connections where friend_id1=".$_SESSION['userid']." AND friend_id2=".$uid." AND deleted = 0";
	$test2 = "Select * from connections where friend_id2=".$_SESSION['userid']." AND friend_id1=".$uid." AND deleted = 0";
	$stmt = "Insert into connections (friend_id1,friend_id2,rqstatus,blocked) values(".$_SESSION['userid'].",".$uid.",0,0)";
	$rs = $conn->query($test);
	$rs2 = $conn->query($test2);
	if(($rs->num_rows == 0) AND ($rs2->num_rows == 0))
	{
		if($conn->query($stmt)==TRUE)
		{
			//send mail
			$emailQuery ='select email, firstname, lastname from users where uid ="'.$uid.'"';
			$emailRs = $conn->query($emailQuery);
			if($emailRs->num_rows == 1)
			{
				$row = $emailRs->fetch_assoc();
				$email = $row['email'];
				$first =  $row['firstname'];
				$subject = $_SESSION['firstname']." ".$_SESSION['lastname']." sent a request for a connection with you.";
	
				 $message = "
				 <html>
				 <head>
				 <title>".$_SESSION['firstname']." ".$_SESSION['lastname']." sent a request for a connection with you.</title>
				 </head>
				 <body>
				 <br>
				 Hey ".$first.",<br><br>
				
				         You've just received a new connection request from ".$_SESSION['firstname']."&nbsp;".$_SESSION['lastname']."&nbsp;("
					 .$_SESSION['email'].").<br>
				         Please log in to your account at Duplicate App, click on <br>
				         Connections from the sidebar and then click on the 'Go to Connection Requests' button <br>
				         to respond to your connection requests. Don't worry, rejecting a request will not notify <br>
				         the other user.
						 <br><br>
				         -------------------------------------------------<br>
				         ©&nbsp;".date("Y")."&nbsp;Duplicate App<br>
				         -------------------------------------------------<br>
				 </body>
				 </html>
				 ";
				  // Always set content-type when sending HTML email
				 $headers = "MIME-Version: 1.0" . "\r\n";
				 $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
				
				 // More headers
				 $headers .= 'From: <donotreply@DuplicateApp.com>' . "\r\n";
	
				 //send mail
				 mail($email,$subject,$message,$headers);
			}
			else
			{
				die("query failed:<br>".$emailQuery);
			}
			return TRUE;
		}
		else 
		{
			return FALSE;
		}
	}
	else 
	{
		return false;
	}
}

function testConnection($uid)
{
	$conn = dbConnect();
	$test = "Select * from connections where friend_id1=".$_SESSION['userid']." AND friend_id2=".$uid." AND deleted = 0";
	$test2 = "Select * from connections where friend_id2=".$_SESSION['userid']." AND friend_id1=".$uid." AND deleted = 0";
	$rs = $conn->query($test);
	$rs2 = $conn->query($test2);
	if(($rs->num_rows === 1) OR ($rs2->num_rows === 1))
	{
		return true;
	}
	else 
	{
		return false;
	}	
} 
?>
