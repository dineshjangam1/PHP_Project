<?php 
	//session_start();
    include '../libraries/database.php';
	$conn = dbConnect();
	//$u = 7;
	//if(isset($_GET['uid']))
	//{
		$u = $_POST['uid'];
	//}
	
	$sql = "Select Name, HashRef,upload_date, Replyto, audio.deleted as deleted, access_lvl,catid, FirstName, LastName 
			From audio, users where audio.uid = users.uid 
			AND (audio.uid IN (Select friend_id1 from connections where friend_id1 = ".$u." OR friend_id2= ".$u.")
			OR audio.uid IN (Select friend_id2 as uid from connections where friend_id1 = ".$u." OR friend_id2= ".$u."))
			AND audio.deleted =0 AND users.deleted=0 ORDER BY upload_date DESC";
	
	$rs = $conn->query($sql);
	
	$output = "";
	
	if($rs->num_rows > 0)
	{
		//set output to a table of results i.e. audio tags with details.
		$output = "<table><th colspan='4'>Activity Feed:</th>";
		//loop through and display audios
		while($row = $rs->fetch_assoc())
		{
			$output = $output."<tr><td>".$row['Name']."&nbsp;</td><td>Recorded: ".$row['upload_date']."</td><td>&nbsp;By:"." ".$row['FirstName']." ".$row['LastName']."</td></tr>";
			$output = $output."<tr><td colspan ='4'><audio controls><source src='audio/".$row['HashRef'].".mp3' type='audio/mpeg'>Your browser does not support the audio element.</audio></td></tr>";
		}
		$output = $output."</table>";
		//echo $output;
	}
	else 
	{
		$output = "<table><th><p>Welcome!<br>

You don't have any audio in your feed as yet.<br>

All the recordings of you and your connections will appear here on your audio activity feed. To start recording, click on either the Open Forum, Music, Books, or Sports page. You can also record by replying to posts or by sending personal messages to your connections.
<br>
Use the search bar located above to find people you would like to connect with.<br></p></th>";
		$output=$output."</table>";
	}
	echo $output;
?>
