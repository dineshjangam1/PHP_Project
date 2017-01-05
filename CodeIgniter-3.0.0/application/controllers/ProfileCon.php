<?php
include '../models/ProfileDao.php';

$profi = array();
if((count($_GET)) > 0)
{
	if(isset($_GET['request']))
	{
		If(makeRequest($_GET['u']))
		{
			header('Location: ../views/connections.php');
			die();
		}
		else 
		{
			die("couldn't make request");
		}
	}
	else
	{
		foreach ($_GET as $key => $value) 
		{
			if(strcmp($value, '')!=0)
			{
				$profi[$key] = $value;
			}
		}
		if(updateProfile($profi))
		{
			header('Location: ../views/ProfileUi.php?pro_update=1');
			die();
		}
	}
}
//to get the profile
function getPro($uid)
{
	return getProfile($uid);
}

function getPro1($uid)
{
	return getProfile1($uid);
}
function testConn($uid)
{
	return testConnection($uid);
}
?>