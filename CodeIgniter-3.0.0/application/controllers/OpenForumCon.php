<?php
    //session_start();
	include '../models/OpenForumDao.php';
	
	function getOpenForum()
	{
		return loadPage('m');
	}
	function getMetaData()
	{
		return loadPage('d');
	}
?>