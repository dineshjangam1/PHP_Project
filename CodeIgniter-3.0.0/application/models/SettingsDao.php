<?php
session_start();
include 'SaltHash.php';
include '../libraries/database.php';

//Delete Account
//Change Password

    /*
    * Changes the password in the database
    *
    */
    function changePassword($oldPass, $newPass)
    {
		   //check whether newUsername already exists
        $conn = dbConnect();
        $stmt = "SELECT Password, Salt FROM users WHERE uid = ".$_SESSION['userid']." And deleted = 0"; 	    
        $password="";
		$salt="";
		$rs = $conn->query($stmt);
        if ($rs->num_rows == 0)
        {
            return false; 
        } 
        else
        {
            $row = $rs->fetch_assoc();
			$password = $row['Password'];
            $salt = $row['Salt'];
        }
        
        //check whether passwords are the same
        $saltHash = new SaltHash;
        if ($saltHash->checkPassword($oldPass, $password, $salt))
        {
			$stmt = "UPDATE users SET Password = '".$saltHash->hashWithSalt($newPass, $salt)."' WHERE uid = ".$_SESSION['userid']." AND deleted = 0";
        	if($conn->query($stmt))
			{
				return true;
			}
			else 
			{
				return false;
			}
        }
		else 
		{
			return false;
		}
    }

	function deleteAccount($dpassword)
	{
		$conn = dbConnect(); 
        $stmt = "SELECT Password, Salt FROM users WHERE uid = ".$_SESSION['userid']." And deleted = 0"; 	    
        $password="";
		$salt="";
		$rs = $conn->query($stmt);
        if ($rs->num_rows == 0)
        {
            return false; 
        } 
        else
        {
            $row = $rs->fetch_assoc();
            
            $password = $row['Password'];
            $salt = $row['Salt'];
        }
        
        //check whether passwords are the same
        $saltHash = new SaltHash;
        if ($saltHash->checkPassword($dpassword, $password, $salt))
        {
        	$stmt = "UPDATE users SET deleted = 1 WHERE uid = ".$_SESSION['userid']." AND deleted = 0";
        	$stmt2 = "UPDATE audio SET deleted = 1 WHERE uid = ".$_SESSION['userid']." AND deleted = 0";
        	if($conn->query($stmt))
			{
				if($conn->query($stmt2))
				{
					return true;
				}
				else
				{
					return false;
				}
			}
			else 
			{
				return false;
			}
        }
		else 
		{
			return false;
		}	
	}    

?>