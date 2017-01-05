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
import org.zkoss.zk.ui.select.annotation.Wire;
import org.zkoss.zul.Messagebox;
import org.zkoss.zul.Textbox;
import org.zkoss.zul.Window;

import com.webalternatives.controller.Login;
import com.webalternatives.controller.SignUp;
import com.mysql.jdbc.Driver;
*/
///public class SignUpDao extends SelectorComposer<Window> {
	/*
	 * 
	 
	class signupdao extends AnotherClass {
		
		
	}
	 
    //static $log = Logger.getLogger(SignUpDao.class.getName());
    //variables entered on sign up
    static $username;
    static $firstName;
    static $lastName;
    static $email;
    static $gender;
    static $passwordDB;
    static $salt;*/
 
	
    /*
     * Constructor; initializes the above variables 
    
    function SignUpDao($user, $firstN, $lastN, $emailadd, $sex, $password)
    {
    	$username = $user;
    	$firstName = $firstN;
    	$lastName = $lastN;
    	$email = $emailadd;
    	$gender = $sex;
    	$passwordDB = $password;
    	$salt = "";
    } */
 
    //@Listen("onClick = button")
    /*
     * Checks whether username entered does not already exist. If it doesn't, it inserts all the fields into the database.
     * 
     * @return true if insertion into db happens; false if username already exists
     */
    function submit($username, $firstName, $lastName, $email, $passwordDB,$by,$bm,$bd) 
    {
    	$conn = dbConnect();
        $stmt = null;
        $sh = new SaltHash;
        $userInDB = null;
        $control = false;
       
            
        //execute select SQL statement
        $userInDB = $conn->query("SELECT count(*) as count FROM users WHERE Username = '".mysqli_real_escape_string($conn,$username)."'AND deleted = 0");
            
            
            //check whether the next exists (ie username exists)
		if ($userInDB->num_rows > 0)
		{
			$count = -1;
		        while($row = $userInDB->fetch_assoc())
				{
					$count = $row['count'];
				}
				
	        	if (!($count==0))
	            {
	            	die();
	            	return $control; //return false            	
	            } 
	            else
	            {
	            	$control = true;
	            }
		}            
	            
            
        //insert into database
        $stmt = "INSERT INTO users (Username, FirstName, LastName, Email, Password, Salt, BirthDate) ";//VALUES (?,?,?,?,?,?,?) 
		$u = mysqli_real_escape_string($conn,$username);
		$f = mysqli_real_escape_string($conn,$firstName);
		$l = mysqli_real_escape_string($conn,$lastName);
		$e = mysqli_real_escape_string($conn,$email);
		//$g = mysqli_real_escape_string($conn,$gender);
		$d = date("Y-m-d",mktime(00,00,00,$bm,$bd,$by));
		//$p = mysqli_real_escape_string($conn,$passwordDB);
		
		$values = "VALUES ('".$u."','".$f."','".$l."','".$e."','".$sh->hashPass($passwordDB)."','".$sh->getSalt()."','".$d."')";
        //insert what end user entered into database table
       /* stmt.setString(1, username);
        stmt.setString(2, firstName);
        stmt.setString(3, lastName);
        stmt.setString(4, email);
        stmt.setString(5, gender);
        stmt.setString(6, SaltHash.hashWithSalt(passwordDB));
        stmt.setString(7, SaltHash.getSalt());*/
        
        //execute the statement
        //,array($u, $f, $l, $e, $g, $p,getSalt())
        if($conn->query($stmt.$values)=== TRUE)
        {
        	$control= TRUE;
        }
		else
		{
			die("Error: " . $conn->error);		
		}
        //die("salt was ".$sh->getSalt()); 
        
        
        if ($userInDB != null)
        {
            //if($row->count==-1)   
        }

        return $control;
}   
?>