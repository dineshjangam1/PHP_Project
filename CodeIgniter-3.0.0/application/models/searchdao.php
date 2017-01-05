<?php
    include '../libraries/database.php';
	$conn = dbConnect();

	$q = $_POST['query'];
	
	//use string parsing and sql regex
	$sql = "Select uid, firstname, lastname, currentcity, work, education from users where deleted = 0 AND (currentcity REGEXP '^".$q."' OR firstname REGEXP '^".$q."' OR lastname REGEXP '^".$q."'";
	$sql = $sql." OR email REGEXP '^".$q."' OR nickname REGEXP '^".$q."' OR Education REGEXP '^".$q."')";// LIMIT 5
	
	// in the future inlude audio search results
	
	$rs = $conn->query($sql);
	
	$output = "";
	
	if($rs->num_rows > 0)
	{
		//set output to a table of results i.e. audio tags with details.
		$output = "<table style='text-align:center; width:300px;padding:5px;'><th colspan='3'>Suggestions:</th>";
		//loop through and display audios
		while($row = $rs->fetch_assoc())
		{
			$output = $output."<tr><td><a href='ProfileUi.php?u=".$row['uid']."'>".$row['firstname']."&nbsp;".$row['lastname']."&nbsp;-&nbsp;".$row['currentcity'];
			if(strcmp($row['work'],"")!=0)
                        {
                        	$output = $output.'&nbsp;-&nbsp;'.$row['work'];
                        }
                        if(strcmp($row['education'],"")!=0)
                        {
                                $output = $output.'&nbsp;-&nbsp;'.$row['education'];
                        }
			$output = $output."</a></td></tr>";
		}
		$output = $output."</table>";
	}
	else 
	{
		$output = "<table style='text-align: center;'><tr><td>No Suggestions.</td></tr></table>";
	}
	
	echo $output;
?>
