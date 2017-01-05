<?php
    //session_start();
	include '../models/MusicDao.php';
	
	function getMusic()
	{
		return loadPage('m');
	}
	function getMetaData()
	{
		return loadPage('d');
	}
?>