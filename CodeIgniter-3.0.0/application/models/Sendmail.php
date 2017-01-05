<?php
//include '../libraries/database.php';
function Sendmail($email)
{

		//die( '<a href="Verify.php?email='.$userName.'">click here</a>' );

		//database stuff
		$user_email ="";
		$activation_code="";
		$conn = dbConnect();
		$userInDB = $conn->query("SELECT email, activation_code FROM users WHERE email = '".mysqli_real_escape_string($conn,$email)."'AND deleted = 0");
		if ($userInDB->num_rows > 0)
		{
		        while($row = $userInDB->fetch_assoc())
				{
					$user_email = $row['email'];
					$activation_code= $row['activation_code'];
				}
		}
	/*
	  $this->load->library('email'); 	//load email library
      $this->email->from('donotreply@Duplicate App.com', 'Do NotReply'); //sender's email
      $subject="Welcome to Duplicate App!";	//subject
      $message= //-----------email body starts-----------
        'Thanks for signing up!

        Your account has been created.
        Here are your details.
        -------------------------------------------------
        Email   : ' . $user_email . '
        UserName   : ' . $userName . '
        -------------------------------------------------

        Please click this link to activate your account:

        '.'<a href="http://www.Duplicate App.com/verify.php?email='.$userName.'&v='.$activation_code.'">click here</a>';
		//-----------email body ends-----------
*/

 $to = $user_email;
 $subject = "Welcome to Duplicate App! Please Activate Your Account.";

 $message = "
 <html>
 <head>
 <title>Duplicate App welcome and account activation email</title>
 </head>
 <body>
 <br>
 Thanks for signing up!<br><br>

         Your account has been created.<br>
         Here are your details.<br>
         -------------------------------------------------<br>
         Email   : " . $user_email . "<br>
         -------------------------------------------------<br><br>

        Please click this link to activate your account:<br>

 <br><a href='http://Duplicate App.com/views/verify.php?email=".$email."&v=".$activation_code."'>click here</a>
 </body>
 </html>
 ";

 // Always set content-type when sending HTML email
 $headers = "MIME-Version: 1.0" . "\r\n";
 $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

 // More headers
 $headers .= 'From: <donotreply@Duplicate App.com>' . "\r\n";



	//send mail
	mail($to,$subject,$message,$headers);

}