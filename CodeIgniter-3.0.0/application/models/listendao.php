<?php
	session_start();
    include '../libraries/database.php';
	function getAudio($href)
	{
		$conn = dbConnect();
		if ($conn->connect_error) 
		{
 		   die("Connection failed: " . $conn->connect_error);
 		} 
		
			
		$sql = "Select Name, HashRef,upload_date, Replyto, audio.deleted as deleted, access_lvl,catid, FirstName, LastName, audio.uid as User"; 
		$sql = $sql." From audio, users where audio.uid = users.uid AND hashref = '".$href."' AND audio.deleted =0 AND users.deleted=0";
		
		$output = "";
		
		$res = $conn->query($sql);
		$isFriendAccessable = FALSE;
		if($res->num_rows > 0)
		{
			//set output to a table of results i.e. audio tags with details.
			$row = $res->fetch_assoc();
			//display if access is allowed
			$sessUid = 0;
			if(isset($_SESSION['userid']))
			{
				$sessUid = $_SESSION['userid'];
			}
			$accessQuery = "Select friend_id1, friend_id2 from (Select * from connections WHERE (friend_id1=".$row['User']." OR friend_id2=".$row['User'].") AND deleted = 0 AND rqstatus = 1 and blocked = 0) AS friends";
			$accessQuery = $accessQuery." WHERE friend_id1 =".$sessUid." OR friend_id2=".$sessUid;
			
			$accessRes = null;
			
			if(isset($_SESSION['userid'])&&(strcmp($_SESSION['userid'], "")!=0))
			{
				$accessRes = $conn->query($accessQuery);
				if($accessRes->num_rows > 0)
				{$isFriendAccessable = TRUE;}
			}

			if($row['access_lvl']==0 || ($row['access_lvl']==1 && $isFriendAccessable) || ($row['access_lvl']==2 && $row['User']==$_SESSION['userid']))
			{
				$output = "<table><th>".$row['Name']."</th>";
				$output = $output."<tr><td><audio controls style='height:60px; width:550px;'><source src='audio/".$row['HashRef'].".mp3' type='audio/mpeg'>Your browser does not support the audio element.</audio></td></tr>";
				$output = $output."<tr><td>Recorded: ".$row['upload_date']." By: ".$row['FirstName']." ".$row['LastName']."</td></tr>";
				$output = $output."<tr><td><button class='btn btn-default' onclick=ReplyRec('".$row['HashRef']."')>Record Reply</button>&nbsp;<button class='btn btn-default' id = 'subComButton_"
				.$row['HashRef']."' onclick=showHide('subCom_".$row['HashRef']."','".$row['HashRef']."') >Display/Hide Audio Comments</button></td></tr>";
				$output = $output."</table><br>Comments:<table><div id='subCom_".$row['HashRef']."' hidden='true'></div></table>";
			} 
			else 
			{
				$output = "Sorry. You do not have permission to access this audio.<br>Either it was set to private or you must connected to it's owner to have access.";
				/*<br>Access level= ".$row['access_lvl'].
				"<br>isFriendAcessable= "
				if($isFriendAccessable)
				{$output=$output."true";}else{$output=$output."false";}*/
			}
		}
		else 
		{
			$output = "Sorry. The specified audio was not found. =(";
		}
		
		return $output;
	}
/*
	function getAudioComments($href)
	{
		$conn = dbConnect();
		if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
 }			
		$sql = "Select Name, Description, HashRef,upload_date, Replyto, audio.deleted as deleted, audio.uid as Auid, access_lvl,catid, FirstName, LastName, Username";
		$sql = $sql."From audio, users where audio.uid = users.uid AND replyto = '".$href."' AND audio.deleted =0 AND users.deleted=0";
		
		$rs = $conn->query($sql);
		
		$output = "";
		
		if($rs->num_rows > 0)
		{
			//set output to a table of results i.e. audio tags with details.
			$output = "<table><th>Comments:</th>";
			//loop through and display audios
			while($row = $rs->fetch_assoc())
			{
				$output = $output."<tr><td>By: <a href='ProfileUi.php?u=".$row['Auid']."'>".$row['Username']."</a></td><td>Recorded: ".$row['upload_date']."</td></tr>";
				$output = $output."<tr><td></td><td colspan ='2'><audio controls class='comments'><source src='audio/".$row['HashRef'].".mp3' type='audio/mpeg'>Your browser does not support the audio element.</audio></td></tr>";
				$output = $output."<tr><td></td><td><button class='btn btn-default' onclick=ReplyRec('".$row['HashRef']."')>Record Reply</button></td><td><button class='btn btn-default' id = 'subComButton_".$row['HashRef']."' onclick=showHide('subCom_".$row['HashRef']."','".$row['HashRef']."') >Display/Hide Audio Comments</button></td></tr>";
				$output = $output."</table><table><div id='subCom_".$row['HashRef']."' hidden='true'></div>";
			}
			$output = $output."</table>";
		}
		else 
		{
			$output = "No Comments on the audio.";
		}
		
		return $output;
	}	*/
?>
