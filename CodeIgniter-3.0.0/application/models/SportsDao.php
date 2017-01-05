<?php
session_start();
include '../libraries/database.php';
include 'SaltHash.php';
  
    /*
    * Loads page with audio files.
    * returns a list of hash references which are the names of the audiofiles without extensions.
    */
    function loadPage($x)
    {
    	$d=FALSE;
    	if(strcmp($x, 'd')==0||strcmp($x, 'D')==0)
		{
			//$x='';
			$d=TRUE;
		}
    	
        $list = array();
		$data = array();
		$conn = dbConnect();
		$stmt = '';
		$cat  = 0;
        //find connections
        $stmt = "Select catid from categories where category = 'Sports'";
		$results = $conn->query($stmt);
		$row = $results->fetch_assoc();
		$cat = $row['catid'];
		
		//find connections
		$stmt = "SELECT hashRef, upload_date, audio.uid as uid, name, firstname, lastname FROM audio,users WHERE audio.uid=users.uid AND audio.uid = '"
		.$_SESSION['userid']."' AND catid=".$cat." AND replyto is NULL AND users.deleted = 0 AND audio.deleted = 0 ORDER BY upload_date DESC";

		
		    //check and save aid's in list
		    $results = $conn->query($stmt);
			if($results->num_rows > 0)
			{
			    while ($row = $results->fetch_assoc())
			    {
			       array_push($list,$row['hashRef']);
				   array_push($data,$row);
			    }
			}
			if($d)
			{
				return $data;
			}			
        return $list;
    }
?>