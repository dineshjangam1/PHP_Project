<?php
    //session_start();
	include '../models/BooksDao.php';
	
	function getBooks()
	{
		return loadPage('b');
	}
		function getMetaData()
	{
		return loadPage('d');
	}
?>