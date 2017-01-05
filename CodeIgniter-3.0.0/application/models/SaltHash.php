<?php
/*
package com.webalternatives.model;
import java.math.BigInteger;
import java.security.MessageDigest;
import java.security.NoSuchAlgorithmException;
import java.security.SecureRandom;
import java.util.Arrays;


 * Contains methods to find the hashed + salted version of the password and vice versa.
 * 

*/
class SaltHash{ 
	
	//holds the value of the salt
	var $globalSalt=""; 
	
	public function __contruct()
	{
		$this->globalSalt = $this->salt();
	}
	
	/**
	 * Generates a random salt.
	 * 
	 * @return the random salt that was generated
	 */
	public function salt()
	{
		$rand = '';
		for ($x = 0; $x <= 24; $x++) 
		{
			$rand = $rand.chr(rand(48, 122));
		}		 
		//$salt[16]; byte //create array of bytes which will store the salt
	    //rand.nextBytes(salt); //use random number generator to store random number in bytes
		//return byteToString(salt);
		//die("\$Rand: ".$rand);
		return hash("sha256",$rand);
	}
	
	/**
	 * Finds the hashed version of password + salt. 
	 *  
	 * @param password the password we are trying to hash with salt
	 * @return the hashed bytes of the password + salt
	 */
	public function hashPass( $password)
	{
		$this->globalSalt = $this->salt();
		return hash("sha256",$password.$this->globalSalt);
	}
	
	/**
	 * Accessor method for global salt initialized in hashWithSalt
	 * 
	 * @return salt used in hashWithSalt
	 */
	public function getSalt()
	{
		return $this->globalSalt;
	}
	
	/**
	 * Finds the hashed version of password + salt where salt is a parameter.
	 *  
	 * @param password the password we are trying to hash with salt
	 * @param salt the salt that is saved in the database for the particular user
	 * @return the hashed bytes of the password + salt
	 */
	public function hashWithSalt($password, $salt)
	{
        //MessageDigest md = MessageDigest.getInstance("SHA-256"); //256 bits, 32 bytes
        $passWithSalt = $password.$salt;
        //byte[] hashedBytes = md.digest(passWithSalt.getBytes());
        return hash("sha256",$passWithSalt);
	}
	
	 
	/**
	 * Creates random number and finds the hashedRef for it. 
	 * 
	 * @return hashRef of a random number
	 * @throws NoSuchAlgorithmException
	 */
	public function hashRef()
	{
		//come up with random number
		//SecureRandom rand = new SecureRandom();
		//int randomNumber; //create randomNumber 
		$randomNumber = rand(0,9999999999999999); //use random number generator to store random number in randomNumber
		 
		//hash the number
		//MessageDigest md = MessageDigest.getInstance("SHA-256"); //256 bits, 32 bytes
		//byte[] hashedBytes = md.digest(BigInteger.valueOf(randomNumber).toByteArray());
	     
		//return bytes
		return hash("sha256",$randomNumber);
	}
	
	/**
	 * Checks whether the password entered by the user is correct. To do so, prepend the salt from the database to the given password, hash
	 * and compare the two hashes.
	 * 
	 * @param password the given password we are checking 
	 * @return 
	 */
	public function checkPassword ($password, $hashPass, $salt)
	{
		//compare hashPass from database with hashed given password +salt
		if (strcmp($hashPass, hash("sha256", $password.$salt))== 0)
		{
			return true;
		} 
		else
		{
			//die("HashPass: ".$hashPass."<br>Pass+Salt Hash: ".hash("sha256",$password.$salt)."<br>Password: ".$password."<br>Salt : ".$salt);
			return false;
		}
	}
	
	/**
	 * Converts a byte array into a String
	 * 
	 * @return the String produced from the conversion
	 */
	public function byteToString($input) {
        return STRING_CAST($input);
    }
 }
?>