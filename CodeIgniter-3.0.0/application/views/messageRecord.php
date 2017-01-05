<?php
session_start();
include '../models/SaltHash.php';
include '../libraries/database.php';

$salthash = new SaltHash;
$hashref = $salthash->hashRef();

$conn = dbConnect();

$name = $hashref.'.wav';
$path = 'audio/'.$name;
$rpath = "audio/save_file.php?filename=".$name;
$cat =0;
$replyto ='';
if(isset($_POST['cat']))
{
	$c = $_POST['cat'];
	if(strcmp($c,'books')===0)
	{
		$c = 'Books';
		$cat = 1;
	}
	if(strcmp($c,'music')===0)
	{
		$c = 'Music';
		$cat =2;
	}
	if(strcmp($c,'sports')===0)
	{
		$c = 'Sports';
		$cat = 3;
	}
	if(strcmp($c,'message')===0)
	{
		$c = 'Message';
		$cat = 4;
	}
	if(strcmp($c,'misc')===0)
	{
		$c = 'Misc';
		$cat = 5;
	}
//	$results = $conn->query("Select catid from categories where category = ".$c);
//	if($results->num_rows > 0)
//	{
//		$row = $results->fetch_assoc();
//		$cat = $row['catid'];
//	}
}

if(isset($_POST['ref']))
{
	$replyto = $_POST['ref'];
}
?>
<!DOCTYPE html>
<html>
	<head>
		<script type="text/javascript" src="recordingeg/js/main.js"></script>
  		<script type="text/javascript" src="recordingeg/js/recorderjs/recorder.js"></script>
	</head>
	<body>
<div>
<div id="status1">
	<div id="recorder"></div><div id ="isRec"><canvas id="myCanvas" width="12" height="12" hidden ="true"></canvas></div><div id="player1"></div>
			<!--<audio id ="rDing" controls="none" preload="auto" style="display: none;">
				<source src="audio/recordingDing.mp3" type="audio/mpeg">
			</audio>
			<audio id ="sDing" controls="none" preload="auto" style="display: none;">
				<source src="audio/stopDing.mp3" type="audio/mpeg">
			</audio>-->	
            <button id="record" onclick="toggleRecording(this)" alt="Click here to start recording">Record/Stop Recording</button>
            <!--<button id="play" disabled ="true" onclick="buttonHandling('1','<?php print($name);?>')">Play/Stop Playing</button>-->
   	
		<form>
			<input id="recInput1" type="hidden" name="hashref" value="<?php print($hashref); ?>" />
			<input id="recInput2" type="hidden" name="cat" value="<?php print($cat); ?>" />
			<input id="recInput3" type="hidden" name="replyto" value="<?php print($replyto); ?>" />
			<input id="recInput4" type="hidden" name="mess" value="1" />
			<input id="recInput5" type="hidden" name="to" value="<?php print($_POST['to']); ?>" />
			<table>
				<tr>
					<td>Recording Name:</td><td><input id='soundName' name ='name' type="text" alt="recording name"/></td>
				</tr>
				<tr>
					<!--<td>Brief Description:</td><td><input id='soundDesc' name='desc' type="text" "brief decription"/></td>-->
				</tr>
				<tr>
					<td>Access Level:</td>
					<td><select name="access" id = "acclvl">
						<?php
							echo '<option value="3" alt="Only you can access">Private</option>';					
						?>
						</select></td>					
				</tr>
				<tr>
					<td><input type="button" value="Send Message" onclick="sendMessage(<?php print "'".$hashref."'"; ?>)" /></td>
					<td><input type="button" value="Cancel/Close" onclick="hideRec(true)" /></td>
				</tr>
			</table>
		</form>
		<div id="stateD"></div>
	<!--<div id="flash"></div>
	<noscript>WAMI requires Javascript</noscript>-->
</div>
</div>
</body>
</html>
