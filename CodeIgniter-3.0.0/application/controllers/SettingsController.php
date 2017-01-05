<?php
	//session_start();
	include '../models/SettingsDao.php';
	
    $err = array();
    if (isset($_POST['chg']))
	{
		if(strcmp($_POST['retype'],$_POST['new'])!=0)
		{
			header("Location: ../views/Settings.php?err=3");
			die();
		}
		else if(changePassword($_POST['old'],$_POST['new']))
		{
			header("Location: ../views/Settings.php?np=1");
			die();
		}
		else 
		{
			header("Location: ../views/Settings.php?err=1");
			die();
		}
	}
	
	if (isset($_POST['del']))
	{
		if(deleteAccount($_POST['pass']))
		{
			header("Location: ../views/logout.php");
			die();
		}
		else 
		{
			header("Location: ../views/Settings.php?err=2");
			die();
		}
	}

                    

?>