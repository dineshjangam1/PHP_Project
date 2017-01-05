<?php
   // session_start();
	include '../models/SportsDao.php';
	
	function getSports()
	{
		return loadPage('s');
	}
		function getMetaData()
	{
		return loadPage('d');
	}
?>