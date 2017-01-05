<?php
	session_start();
	include '../models/Logindao.php';
	
	//check that the username and password are both set
	if(isset($_GET))
	{
		$user = submitFunction($_GET['username'], $_GET['password']);
		$err = array();
		if(!(isset($_GET['username']) && isset($_GET['password'])))
		{
			$err['err1'] = TRUE;
		}
		elseif($user<0)
		{
			//username or password are incorrect
			$err['err2'] = TRUE;
		}
		
	 	$errlen = count($err);
		$count =0;
		$getString ='?';		
	 	foreach($err as $i => $i_val)
		{
			$count++;
			$getString = $getString.$i.'='.$i_val;
			if($count<$errlen)
			{
				$getString = $getString.'&';
			}
		}
		if($errlen>0)
		{
			header('Location: ../views/Login.php'.$getString);
			die();
		}
		else 
		{
			//Set Session variable and go to profile page
			$_SESSION['userid'] = $user;		
			header('Location: ../views/Profile.php');
			die("It should be working. Idunno what's wrong.");
			
		}
	}
?>