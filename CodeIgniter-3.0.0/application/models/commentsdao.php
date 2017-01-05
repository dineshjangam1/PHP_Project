<?php 
	//session_start();
    include '../libraries/database.php';
	$conn = dbConnect();
	//$u = 7;
	//if(isset($_GET['uid']))
	//{
		$aud = $_POST['audio'];
		$innerComment = FALSE;
		$innerUid=0;
		$innerUname="";
	//}
	if(isset($_POST['inner']))
	{
		$innerComment = TRUE;
	}
	$sql = "Select audio.uid as Auid, Name, HashRef,upload_date, Replyto, audio.deleted as deleted, access_lvl,catid, FirstName, LastName 
			From audio, users where audio.uid = users.uid AND Replyto = '".$aud."' AND users.deleted=0 AND audio.deleted =0";
	
	$sql2 = "Select audio.uid as Auid, FirstName, LastName 
			From audio, users where audio.uid = users.uid AND hashRef = '".$aud."' AND users.deleted=0 AND audio.deleted =0";
	
	$rs = $conn->query($sql);
	$rs2 = $conn->query($sql2);
	$row2 = $rs2->fetch_assoc();
	$output = "<table>";
	
	if($rs->num_rows > 0)
	{
		//Make the following code coditional on whether or not innerComment is true
		if(!$innerComment)
		{
			//What follows is for original comments
			//set output to a table of results i.e. audio tags with details.
			$output = $output."<tr><td colspan='3'>Comments:</td></tr>";
			//loop through and display audios
			while($row = $rs->fetch_assoc())
			{
				$output = $output."<tr><td>Reply to original post&nbsp;</td><td>By: <a href='ProfileUi.php?u=".$row['Auid']."'>".$row['FirstName']." ".$row['LastName']."</a></td><td>Recorded: ".$row['upload_date']."</td></tr>";
				$output = $output."<tr><td></td><td colspan='2'><audio controls><source src='audio/".$row['HashRef'].".mp3' type='audio/mpeg'>Your browser does not support the audio element.</audio></td></tr>";
				$output = $output."<tr><td></td><td><button class='btn btn-default' onclick=ReplyRec('".$row['HashRef']."')>Record Reply</button></td><td><button class='btn btn-default' id = 'subComButton_".$row['HashRef']."' onclick=showHide('subCom_".$row['HashRef']."','".$row['HashRef']."') >Display/Hide Audio Comments</button></td></tr>";
				$output = $output."</table><table><div id='subCom_".$row['HashRef']."' hidden='true'></div>";
			}
			$output = $output."</table>";
		}
		else
		{
			//What follows is for inner comments
			//set output to a table of results i.e. audio tags with details.
			//$output = $output."<tr><td></td><td colspan='2'>Comments:</th></td><td><td><tr>";
			//loop through and display audios
			$innerUid = $row2['Auid'];
			$innerFname = $row2['FirstName'];
			$innerLname = $row2['LastName'];
			while($row = $rs->fetch_assoc())
			{
				$output = $output."<tr><td>Reply to <a href='ProfileUi.php?u=".$innerUid."'>".$innerFname." ".$innerLname."</a>&nbsp;</td><td>By: <a href='ProfileUi.php?u=".$row['Auid']."'>".$row['FirstName']." ".$row['LastName']."</a></td><td>Recorded: ".$row['upload_date']."</td></tr>";
				$output = $output."<tr><td></td><td colspan ='2'><audio controls class='comments'><source src='audio/".$row['HashRef'].".mp3' type='audio/mpeg'>Your browser does not support the audio element.</audio></td></tr>";
				$output = $output."<tr><td></td><td><button class='btn btn-default' onclick=ReplyRec('".$row['HashRef']."')>Record Reply</button></td><td><button class='btn btn-default' id = 'subComButton_".$row['HashRef']."' onclick=showHide('subCom_".$row['HashRef']."','".$row['HashRef']."') >Display/Hide Audio Comments</button></td></tr>";
				$output = $output."</table><table><div id='subCom_".$row['HashRef']."' hidden='true'></div>";
			}
			$output = $output."</table>";			
		}
	}
	else 
	{
		$output = "<tr><td colspan='3'>There are no comments for this audio.</td></tr>";
		//$output = "attempted:<br>".$sql."<br>Resulting in:<br>".$rs->error();
	}
	$output = $output."</table>";
	echo $output;
?>