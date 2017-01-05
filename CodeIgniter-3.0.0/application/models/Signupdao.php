<?php
include '../libraries/database.php';
include 'SaltHash.php';

    //@Listen("onClick = button")
    /*
     * Checks whether username entered does not already exist. If it doesn't, it inserts all the fields into the database.
     *
     * @return true if insertion into db happens; false if username already exists
     */
//    function submit($username, $firstName, $lastName, $email, $passwordDB,$by,$bm,$bd)
    function submit($currentCity, $firstName, $lastName, $email, $passwordDB)
    {
    	$conn = dbConnect();
        $stmt = null;
        $sh = new SaltHash;
        $userInDB = null;
        $control = false;


        //execute select SQL statement
        $userInDB = $conn->query("SELECT count(*) as count FROM users WHERE email = '".mysqli_real_escape_string($conn,$email)."'AND deleted = 0");


            //check whether the next exists (ie email exists)
		if ($userInDB->num_rows > 0)
		{
			$count = -1;
		        while($row = $userInDB->fetch_assoc())
				{
					$count = $row['count'];
				}

	        	if (!($count==0))
	            {
	            	//die('Email already exists.');
	            	return $control; //return false
	            }
	            else
	            {
	            	$control = true;
	            }
		}


        //insert into database
        $stmt = "INSERT INTO users (CurrentCity, FirstName, LastName, Email, Password, Salt, activation_code) ";//VALUES (?,?,?,?,?,?,?)
		$u = mysqli_real_escape_string($conn,$currentCity);
		$f = mysqli_real_escape_string($conn,$firstName);
		$l = mysqli_real_escape_string($conn,$lastName);
		$e = mysqli_real_escape_string($conn,$email);
		$activation_code = md5(uniqid(rand()));
		//echo $activation_code;
		//$g = mysqli_real_escape_string($conn,$gender);
		//$d = date("Y-m-d",mktime(00,00,00,$bm,$bd,$by));
		//$p = mysqli_real_escape_string($conn,$passwordDB);

		$values = "VALUES ('".$u."','".$f."','".$l."','".$e."','".$sh->hashPass($passwordDB)."','".$sh->getSalt()."','".$activation_code."')";
        //insert what end user entered into database table


        if($conn->query($stmt.$values)=== TRUE)
        {
        	$control= TRUE;
        }
		else
		{
			die("Error: " . $conn->error);
		}
        //die("whats up?");


        if ($userInDB != null)
        {
            //if($row->count==-1)
        }

        return $control;
}
?>
