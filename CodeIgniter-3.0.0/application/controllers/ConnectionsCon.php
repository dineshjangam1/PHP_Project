<?php
//session_start();
include '../models/ConnectionsDao.php';

if(isset($_GET['u']))
{
	if(isset($_GET['accept']))
	{
		acceptRequest($_GET['u']);
		header('Location: ../views/connections.php?req=1');
		die();
	}
	elseif(isset($_GET['reject']))
	{
		rejectRequest($_GET['u']);
		header('Location: ../views/connections.php?req=1');
		die();		
	}
	elseif(isset($_GET['block']))
	{
		blockContact($_GET['u']);
		header('Location: ../views/Profile.php');
		die();
	}
	elseif(isset($_GET['unblock']))
	{
		unblockContact($_GET['u']);
		header('Location: ../views/connections.php');
		die();
	}
}

	// Here connections refers to friends and not database or other sorts of connections
	function loadConnections()
	{
		$connections = array();
		$uid = -1;
		if(isset($_SESSION['userid']))
		{
			$uid = $_SESSION['userid'];
		
			if(hasFriends())
			{
				$connections = getFriends();
			}
		}
		else
		{
			header("Location: ../views/Login.php");
			die();
		}
		return $connections;
	}
	
	function loadRequests()
	{
		$connections = array();
		$uid = -1;
		if(isset($_SESSION['userid']))
		{
			$uid = $_SESSION['userid'];
		
			if(hasRequests())
			{
				$connections = getRequests();
			}
		}
		else
		{
			header("Location: ../views/Login.php");
			die();
		}
		return $connections;
	}
?>
