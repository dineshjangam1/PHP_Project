<?php
include '../libraries/database.php';
include 'SaltHash.php';

/*package com.webalternatives.model;

import java.sql.Connection;
import java.sql.DriverManager;
import java.sql.PreparedStatement;
import java.sql.ResultSet;
import java.sql.SQLException;
import java.util.logging.Logger;

import org.zkoss.zk.ui.select.SelectorComposer;
import org.zkoss.zk.ui.select.annotation.Listen;
import org.zkoss.zul.Window;

import com.webalternatives.controller.Login;
 * 
 */


//static $e = SQLiteException();


function submitFunction($userName, $userPass)
{
	$conn = dbConnect();
	$sh = new SaltHash;
	$password="Test";
	$salt="";
	$uid=-1;
	$rs = $conn->query("SELECT uid, Password, Salt FROM users WHERE username = '".mysqli_real_escape_string($conn,$userName)
	."' AND deleted = 0");
 
    //check whether username already exists by checking if no value was found
	if ($rs->num_rows === 1)
	{
	        while($row = $rs->fetch_assoc())
			{
	        	$uid = $row['uid'];
	        	$password = $row['Password']; 
	        	$salt = $row['Salt'];
			}		
	}
	else
	{
		//the username doesn't exist
		//die("query failed");
		$uid =-1;
	}
            
    //check whether passwords are the same 
    if (!$sh->checkPassword($userPass, $password, $salt))
    {
    	//passwords are incorrect;
    	$uid = -2;
		//die();
    }

    return $uid;
} 
  
    /*
     * Accessor method for password
     * 
     * @return password
     
    function getPass()
    {
        
   
    	return $password;
    }*/
    
    /*
     * Accessor method for salt
     * 
     * @return salt
    
     function getSalt()
    {
    	return $salt;
    } */

?>