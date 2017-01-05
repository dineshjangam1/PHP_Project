<?php
include '../models/Signupdao.php';
include '../models/Sendmail.php';

 if(isset($_GET))
 {
	//echo 'before err check<br>';
	//var_dump($_GET);
 	$err = array();
 	//check that each variables are set
 	if(!isset($_GET['firstName']))
	{
		$err['err1'] = TRUE;
	}
	if(!isset($_GET['lastName']))
	{
		$err['err2'] = TRUE;
	}
	if(!isset($_GET['currentCity']))
	{
		$err['err3'] = TRUE;
	}
	if(!isset($_GET['email']))
	{
		$err['err4'] = TRUE;
	}/*
	if(!isset($_GET['sex']))
	{
		$err['err5'] = TRUE;
	}*/
	if(!isset($_GET['password1']))
	{
		$err['err6'] = TRUE;
	}
	if(!isset($_GET['password2']))
	{
		$err['err7'] = TRUE;
	}
	//check that email meets critera
	$emailpatt = '/^[A-z0-9_]+([.][A-z0-9_]+)*[@][A-z0-9_]+([.][A-z0-9_]+)*[.][A-z]{2,}$/';
	if(!preg_match($emailpatt, $_GET['email']))
	{
		$err['err8'] = TRUE;
	}

 	//check that passwords match
 	if(!(strcmp($_GET['password1'], $_GET['password2'])==0))
	{
		$err['err9'] = TRUE;
	}
 	//check that password meets critera
 	/*
	$passwordpatt = '/^.*(?=.{8,15})(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[_&@!\*\/]).*$/';
	if(!preg_match($passwordpatt, $_GET['password2']))
	{
		$err['err10'] = TRUE;
	} 	*/
 	//
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
		header('Location: ../views/SignUp.php'.$getString);
		die();
	}
	else
	{
		//no errors occured to enter data into database
		if(submit($_GET['currentCity'], $_GET['firstName'], $_GET['lastName'], $_GET['email'],$_GET['password2']))
		{
			//var_dump($_GET);
			Sendmail($_GET['email']);
			header('Location: ../views/Login.php?veri=TRUE');
			die();
		}
		else
		{
			//var_dump($_GET);
			//email already exists
			header('Location: ../views/SignUp.php?err11=TRUE');
			die();
		}
	}



 }
else
{
	header('Location: ../views/SignUp.php?err12=TRUE');
	die();
}


?>
