<?php
session_start();
//include '../controllers/MessagesCon.php';

if(!isset($_SESSION['userid']))
{
	header("Location: Login.php");
	die();	
}
//if get is not set default to session user version. if u = session user also display session user verion otherwise show public version
//session user version allows or editing of info.

$sessUser = $_SESSION['userid'];
$isSessUser = FALSE; // when false use public view otherwise session user view
$u = $sessUser; 
$outputString = '';
if(isset($_GET['u']))
{
	$u = $_GET['u'];
}
else 
{
	//u  = session user
	$u = $sessUser;	
}

//check if user is session user
if($u == $sessUser)
{
	//set isSessUser to True
	$isSessUser = TRUE;
}
else 
{
	$isSessUser = False;
}	

//
//$prof = getPro($u);
$outputString = '<h4>'.$_SESSION['firstname'].' '.$_SESSION['lastname'].' Messages</h4>
<button class="btn btn-default" onclick="messGet(\'receiver\')">Received</button><button class="btn btn-default" onclick="messGet(\'sent\')">Sent</button><button class="btn btn-default" onclick="messGet(\'comp\')">Compose</button>
<div id="messagecontent"></div>';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Duplicate App</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" type="text/css" href="Pages.css" />
   
   
  <meta content="width=device-width" />
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <link rel="icon" type="image/png" href="images/favicon.png">
    
    <script type="text/javascript" src="recordingeg/js/main.js"></script>
  <script type="text/javascript" src="recordingeg/js/recorderjs/recorder.js"></script>

  <script src="https://code.jquery.com/jquery-1.5.1.min.js"></script>
  <style>
  	body{
    		background-color: #129FEA;
       }
  </style>
 </head>

 <body onload="messGet('receiver')" class="sky_blue">

<div id="overlay"></div><div id="recWindow"></div><div id="rForm"></div><div id="delResult"></div><div id="dterms"></div>
<header>
    <div class="navbar navbar-inverse navbar-fixed-top" style="margin-bottom: 10px;">
        <div class="container" style="background-color:#000; width:100%">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#header-body">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>

            </div>
            <div class="navbar-collapse collapse" id="header-body">
                <div class="voxlogo"  style="float:left; padding-top:10px;margin-left:90px;"><a href="Profile.php"><img src="images/logo2.gif" id="logo" width="140px" height="43px"/> </a> </div>
				<ul class="nav navbar-nav" style="padding-top: 10px; margin-left:50px;">
						<li><a href="Profile.php">HOME</a></li>
						<li><a href="messages.php">MESSAGES</a></li>

						<li><a href="Settings.php">SETTINGS</a></li>
						<li><a href="logout.php">LOGOUT</a></li>

                </ul>
                
                <div id = "searchdiv" class="search">
                	<form method="get" action="search.php">
                		<input type="search" name="search" id="search" style="width: 300px;" onkeyup="getAsyncSearch(this.value)"/>
                		<input type="submit" class="btn btn-primary" value="Search">
                	</form>
                </div>
                <div id="results" style="width: 300px; z-index: 2"></div>                
            </div>
        </div>
    </div>
</header>


<div style="float: left; width: 100%;height:80px"></div>


<div style="margin-left: 100px; margin-right: 100px;">
	<br>
         <div id="vertical" style="float: left;  width: 2%;list-style-type: none;">


            <table class ="sidemenu" style="list-style: none;">


            <tr>
                <td>
                <a href="ProfileUi.php"><img src="images/profiles.png" id="profiles" onmouseover="animate(this)" onmouseout="stopAnimation(this)" style="height:45px;width:45px"></a><br><br>
                </td>
                <td>
                <a href="ProfileUi.php" id="profile" onmouseover="animates(this)" onmouseout="stopAnimations(this)" >About Me</a><br><br>
                </td>
            </tr>


            <tr>
                <td>
	            <a href="connections.php"><img src="images/connections.png" id="connections" onmouseover="animate(this)" onmouseout="stopAnimation(this)" style="width:45px; height:45px" ></a>
	            <br><br>
				</td>

	            <td>
                <a href="connections.php" id="connection" onmouseover="animates(this)" onmouseout="stopAnimations(this)">Connections</a><br><br>
	            </td>
            </tr>
            
			<tr>
                <td>
                <a href="OpenForum.php"><img src="images/miscs.png" id="miscs" onmouseover="animate(this)" onmouseout="stopAnimation(this)" style="width:45px; height:45px" ></a><br><br>
                </td>
                <td>
                <a href="OpenForum.php" id="misc" onmouseover="animates(this)" onmouseout="stopAnimations(this)">Open Forum</a><br><br>
                </td>
            </tr>
			
			<tr>
                <td>
                <a href="Music.php"><img src="images/musics.png" id="musics" onmouseover="animate(this)" onmouseout="stopAnimation(this)" style="width:45px; height:45px" ></a><br><br>
                </td>
                <td>
                <a href="Music.php" id="music" onmouseover="animates(this)" onmouseout="stopAnimations(this)">Music</a><br><br>
                </td>
            </tr>
            <!--
            <tr>
                <td>
                <a href="Profile.php"><img src="images/news.png" id="news" onmouseover="animate(this)" onmouseout="stopAnimation(this)" style="width:45px; height:45px"></a><br><br>
                </td>
                <td>
                <a href="Profile.php" id="new" onmouseover="animates(this)" onmouseout="stopAnimations(this)">News</a><br><br>
                </td>
            </tr>-->
            <tr>
                <td>
	            <a href="Books.php"><img src="images/books.png" id="books" onmouseover="animate(this)" onmouseout="stopAnimation(this)" style="width:45px; height:45px"></a><br><br>
                </td>

	            <td>
	            <a href="Books.php" id="book" onmouseover="animates(this)" onmouseout="stopAnimations(this)">Books</a><br><br>
	            </td>

            </tr>

            <tr>
                <td>
	            <a href="Sports.php"><img src="images/sports.png" id="sports" onmouseover="animate(this)" onmouseout="stopAnimation(this)"  style="width:45px; height:45px" ></a><br><br>
	            </td>
                <td>
	            <a href="Sports.php" id="sport" onmouseover="animates(this)" onmouseout="stopAnimations(this)">Sports</a><br><br>
	            </td>
            </tr>
			
			

  </table>



		 <br>
	<br><br><br>
</div>
<div id="verticalPhone">
            <table class ="sidemenuPhone">
            <tr>
                <td>
                <a href="ProfileUi.php"><img src="images/profiles.png" id="profiles" onmouseover="animate(this)" onmouseout="stopAnimation(this)" style="height:45px;width:45px"></a><br><br>
                </td>
            </tr>
            <tr>
                <td>
	            <a href="connections.php"><img src="images/connections.png" id="connections" onmouseover="animate(this)" onmouseout="stopAnimation(this)" style="width:45px; height:45px" ></a>
	            <br><br>
				</td>
            </tr>            
			<tr>
                <td>
                <a href="OpenForum.php"><img src="images/miscs.png" id="miscs" onmouseover="animate(this)" onmouseout="stopAnimation(this)" style="width:45px; height:45px" ></a><br><br>
                </td>
            </tr>			
			<tr>
                <td>
                <a href="Music.php"><img src="images/musics.png" id="musics" onmouseover="animate(this)" onmouseout="stopAnimation(this)" style="width:45px; height:45px" ></a><br><br>
                </td>
            </tr>
            <tr>
                <td>
	            <a href="Books.php"><img src="images/books.png" id="books" onmouseover="animate(this)" onmouseout="stopAnimation(this)" style="width:45px; height:45px"></a><br><br>
                </td>
            </tr>
            <tr>
                <td>
	            <a href="Sports.php"><img src="images/sports.png" id="sports" onmouseover="animate(this)" onmouseout="stopAnimation(this)"  style="width:45px; height:45px" ></a><br><br>
	            </td>
            </tr>		
  </table>
</div>
<div id="horizon" class="contframe" style=" margin:auto; padding: 10px; ">

	             <div id="content" style="margin-left:20px; overflow: auto;">
	             <?php 
	             	// output string goes here 
	             	echo $outputString;
	             ?>
	           
			      <div id="myDiv"></div>
			  </p>
	             </div>
	      </div>
    </div>

 </div>




  <div style="float: left; width: 100%;height:100px"></div>


   <footer>
    <div class="navbar navbar-default navbar-fixed-bottom">
        <div class="container">
            <div class="navbar-footer">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#footer-body">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>

            </div>
            <div class="navbar-collapse collapse" id="footer-body">
                <ul class="nav navbar-nav">
                  <li><a href="mailto:info@Duplicate App.com">Contact</a></li>
                    <li><a href="#" onclick="displayTerms()">Terms</a></li>
					<li><a href="Profile.php">©<?php echo date("Y").'&nbsp;'; ?>Duplicate App</a></li>
					<!--<li><video width='80' height='50' controls>
		<source src='tutorial.mp4' type='video/mp4'>Your browser does not support the video tag.</video></li>-->
                </ul>
            </div>
        </div>
    </div>
</footer>
<script>
function animate(ele){
	var id = $(ele).attr("id");

	console.log("id - "+id);
	//alert("kya to bhi");

	//$("#"+id).removeAttr("height");

	//$("#"+id).css("height","70px");
	//$("#"+id).removeAttr("width");
	//$("#"+id).css("width","70px");
	$("#"+id).attr("src","images/"+id+".gif");
}
function stopAnimation(ele){
	var id = $(ele).attr("id");

	console.log("id - "+id);
	//$("#"+id).css("height","45px");
	//$("#"+id).removeAttr("width");
	//$("#"+id).css("width","45px");
	//$("#"+id).attr("height","45px");
	//$("#"+id).attr("width","45px");
	$("#"+id).attr("src","images/"+id+".png");
}

function animates(ele){
	var id=$(ele).attr("id");
	console.log("id is"+id);
	//$("#"+id+"s").attr("height","70%");
	//$("#"+id+"s").attr("width","70%");
    $("#"+id+"s").attr("src","images/"+id+"s.gif");
	}
function stopAnimations(ele){
	var id=$(ele).attr("id");
	console.log("id is"+id);
	//$("#"+id+"s").attr("height","45px");
	//$("#"+id+"s").attr("width","45px");
    $("#"+id+"s").attr("src","images/"+id+"s.png");
	}
</script>


</body>
</html>
<?php
//}
?>
