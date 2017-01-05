<?php
session_start();
include '../libraries/database.php';
	
//special method. updates friends and returns false if there are none, true otherwise.
    function hasFriends() 
    {
		$userId = $_SESSION['userid'];
		$friends = array();    	
        $stmt = null;
        $conn = dbConnect();
        $control = false;
        $connections = array();
            
        $getfrnd1 = "SELECT friend_id2 FROM connections WHERE friend_id1 = ".$userId." AND deleted = 0 AND rqstatus = 1 AND blocked=0"; //
        $getfrnd2 = "SELECT friend_id1 FROM connections WHERE friend_id2 = ".$userId." AND deleted = 0 AND rqstatus = 1 AND blocked=0"; //AND rqstatus = 1
            //execute select SQL statement
        $rs = $conn->query($getfrnd1);
        $rs2 = $conn->query($getfrnd2);
            //check whether the next exists (ie username exists)
		if ($rs->num_rows > 0) 
		{
		    // output data of each row
		    while($row = $rs->fetch_assoc()) 
		    {
		        //echo "id: " . $row["id"]. " - Name: " . $row["firstname"]. " " . $row["lastname"]. "<br>";
				array_push($connections,$row['friend_id2']);
		    }
		} 
		else 
		{
		    //echo "0 results";
		}
		if ($rs2->num_rows > 0) 
		{
		    // output data of each row
		    while($row = $rs2->fetch_assoc()) 
		    {
		        //echo "id: " . $row["id"]. " - Name: " . $row["firstname"]. " " . $row["lastname"]. "<br>";
				array_push($connections,$row['friend_id1']);
		    }
		} 
		else 
		{
		    //echo "0 results";
		}		            
        for($i=0;$i<count($connections);$i++)
        {
        	$stmt = "Select uid, firstname, lastname from users where uid =".$connections[$i];
        	$rs = $conn->query($stmt);
        	if($rs->num_rows == 1)
        	{
        		$row = $rs->fetch_assoc();
				array_push($friends,$row);
        		//friends.add($rs.getString("username"));
        		$control = true;
        	}
        }
        return $control;
    }

    function getFriends()
    {
		$userId = $_SESSION['userid'];
		$friends = array();    	
        $stmt = null;
        $conn = dbConnect();
        $connections = array();
            
        $getfrnd1 = "SELECT friend_id2 FROM connections WHERE friend_id1 = ".$userId." AND deleted = 0 AND rqstatus = 1 AND blocked=0"; //
        $getfrnd2 = "SELECT friend_id1 FROM connections WHERE friend_id2 = ".$userId." AND deleted = 0 AND rqstatus = 1 AND blocked=0"; //AND rqstatus = 1
        
        //execute select SQL statement
        $rs = $conn->query($getfrnd1);
        $rs2 = $conn->query($getfrnd2);
        //check whether the next exists (ie username exists)
		if ($rs->num_rows > 0) 
		{
		    // output data of each row
		    while($row = $rs->fetch_assoc()) 
		    {
		        //echo "id: " . $row["id"]. " - Name: " . $row["firstname"]. " " . $row["lastname"]. "<br>";
				array_push($connections,$row['friend_id2']);
		    }
		} 
		else 
		{
		    //echo "0 results";
		}
		if ($rs2->num_rows > 0) 
		{
		    // output data of each row
		    while($row = $rs2->fetch_assoc()) 
		    {
		        //echo "id: " . $row["id"]. " - Name: " . $row["firstname"]. " " . $row["lastname"]. "<br>";
				array_push($connections,$row['friend_id1']);
		    }
		} 
		else 
		{
		    //echo "0 results";
		}		            
        for($i=0;$i<count($connections);$i++)
        {
        	$stmt = "Select uid, firstname, lastname from users where uid =".$connections[$i];
        	$rs = $conn->query($stmt);
        	if($rs->num_rows == 1)
        	{
        		$row = $rs->fetch_assoc();
				array_push($friends,$row);
        		$control = true;
        	}
        }    	
    	return $friends;
    }

	function blockContact($uid)
	{
		$conn = dbConnect();
		$stmt1 = "Update connections Set blocked = 1,rqstatus=0 where friend_id1=".$uid." And friend_id2=".$_SESSION['userid']." And blocked = 0 AND deleted=0 AND rqstatus=1";
		$stmt2 = "Update connections Set blocked = 1,rqstatus=0 where friend_id2=".$uid." And friend_id1=".$_SESSION['userid']." And blocked = 0 AND deleted=0 AND rqstatus=1";
		if($conn->query($stmt1)===TRUE)
		{
			//return TRUE;
			header('Location: ../views/Profile.php');
		}
		elseif($conn->query($stmt2)===TRUE)
		{
			//return TRUE;
			header('Location: ../views/Profile.php');
		}
		else 
		{
			return FALSE;
		}
	}
	
	function unblockContact($uid)
	{
		$conn = dbConnect();
		$stmt1 = "Update connections Set blocked = 0,rqstatus=1 where friend_id1=".$uid." And friend_id2=".$_SESSION['userid']." And blocked = 1 AND deleted=0 AND rqstatus=0";
		$stmt2 = "Update connections Set blocked = 0,rqstatus=1 where friend_id2=".$uid." And friend_id1=".$_SESSION['userid']." And blocked = 1 AND deleted=0 AND rqstatus=0";
		if($conn->query($stmt1)===TRUE)
		{
			//return TRUE;
			header('Location: ../views/Profile.php');
		}
		elseif($conn->query($stmt2)===TRUE)
		{
			//return TRUE;
			header('Location: ../views/Profile.php');
		}
		else 
		{
			return FALSE;
		}
	}
	
    function hasRequests() 
    {
    	$userId = $_SESSION['userid'];
		$friends = array();    	
        $stmt = null;
        $conn = dbConnect();
        $control = false;
        $connections = array();
            
        $getfrnd = "SELECT friend_id1 FROM connections WHERE friend_id2 = ".$userId." AND deleted = 0 AND rqstatus = 0 AND blocked=0"; //AND rqstatus = 1
        //execute select SQL statement
        $rs = $conn->query($getfrnd);
       
        //check whether the next exists (ie username exists)
		if ($rs->num_rows > 0) 
		{
		    // output data of each row
		    while($row = $rs->fetch_assoc()) 
		    {
		        //echo "id: " . $row["id"]. " - Name: " . $row["firstname"]. " " . $row["lastname"]. "<br>";
				array_push($connections,$row['friend_id1']);
		    }
		} 
		else 
		{
		    //echo "0 results";
		}
				            
        for($i=0;$i<count($connections);$i++)
        {
        	$stmt = "Select uid, firstname, lastname from users where uid =".$connections[$i];
        	$rs = $conn->query($stmt);
        	if($rs->num_rows == 1)
        	{
        		$row = $rs->fetch_assoc();
				array_push($friends,$row);
        		//friends.add($rs.getString("username"));
        		$control = true;
        	}
        }
        return $control;
    }
    
    function getRequests() 
    {
    	$userId = $_SESSION['userid'];
		$friends = array();    	
        $stmt = null;
        $conn = dbConnect();
        $control = false;
        $connections = array();
            
        $getfrnd = "SELECT friend_id1 FROM connections WHERE friend_id2 = ".$userId." AND deleted = 0 AND rqstatus = 0 AND blocked=0"; //AND rqstatus = 1
        //execute select SQL statement
        $rs = $conn->query($getfrnd);
       
        //check whether the next exists (ie username exists)
		if ($rs->num_rows > 0) 
		{
		    // output data of each row
		    while($row = $rs->fetch_assoc()) 
		    {
		        //echo "id: " . $row["id"]. " - Name: " . $row["firstname"]. " " . $row["lastname"]. "<br>";
				array_push($connections,$row['friend_id1']);
		    }
		} 
		else 
		{
		    //echo "0 results";
		}
				            
        for($i=0;$i<count($connections);$i++)
        {
        	$stmt = "Select uid, firstname, lastname from users where uid =".$connections[$i];
        	$rs = $conn->query($stmt);
        	if($rs->num_rows === 1)
        	{
        		$row = $rs->fetch_assoc();
				array_push($friends,$row);
        		//friends.add($rs.getString("username"));
        		$control = true;
        	}
        }
        return $friends;
    }
    
    function acceptRequest($uid)
	{
		$conn = dbConnect();
		$stmt = "Update connections Set rqstatus = 1 where friend_id1=".$uid." And friend_id2=".$_SESSION['userid']." And deleted = 0 AND blocked=0";
		if($conn->query($stmt)===TRUE)
		{
			//send mail
			$emailQuery ='select email, firstname from users where uid ="'.$uid.'"';
			$emailRs = $conn->query($emailQuery);
			if($emailRs->num_rows == 1)
			{
				$row = $emailRs->fetch_assoc();
				$email = $row['email'];
				$first =  $row['firstname'];
				$subject =$_SESSION['firstname']." ".$_SESSION['lastname']."  has accepted your connection request!";
	
				 $message = "
				 <html>
				 <head>
				 <title>".$_SESSION['firstname']." ".$_SESSION['lastname']." has accepted your connection request!</title>
				 </head>
				 <body>
				 <br>
				 Hey ".$first.",<br><br>
				
				         Your connection request was accepted and you are now connected to ".$_SESSION['firstname']."&nbsp;".$_SESSION['lastname']
					 ."!<br>
				         Now that you are connected, you can send each other private audio messages <br>
				         and listen to audios that are only accessable to each other's connections.<br>
				         You may log in to your account at <a href='www.Duplicate App.com'>Duplicate App.com</a> and click on <br>
				         Connections from the sidebar to view all your connections. <br>
				         
						 <br><br>
				         -------------------------------------------------<br>
				         ©&nbsp;".date("Y")."&nbsp;Duplicate App<br>
				         -------------------------------------------------<br>
				 </body>
				 </html>
				 ";
				  // Always set content-type when sending HTML email
				 $headers = "MIME-Version: 1.0" . "\r\n";
				 $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
				
				 // More headers
				 $headers .= 'From: <donotreply@Duplicate App.com>' . "\r\n";
	
				 //send mail
				 mail($email,$subject,$message,$headers);
			}
			else
			{
				//$headers = 'From: <donotreply@Duplicate App.com>' . "\r\n";
				//mail("dineshjangam@outlook.com","Duplicate App email error","the email did not send because nom_rows!=1 line 254 ConnectionsDao.php.<br>".$conn->error,$headers);
			}
			return TRUE;
		}
		else 
		{
			return FALSE;
		}
	}
	
function rejectRequest($uid)
{
$conn = dbConnect();
$stmt = "Update connections Set deleted = 1, blocked=1 where friend_id1=".$uid." And friend_id2=".$_SESSION['userid']." And deleted = 0 AND blocked=0";
if($conn->query($stmt)===TRUE)
{
	return TRUE;
}
else 
{
	return FALSE;
}
}	
	
?>
