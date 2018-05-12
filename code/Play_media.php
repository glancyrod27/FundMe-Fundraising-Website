<?php session_start();
$con=mysqli_connect("localhost", "root","","Fund_Raising") or die(mysqli_connect_error());  
	if($_SERVER["REQUEST_METHOD"]=="GET")
	{
 		$media_path = $_GET['path'];
 		$imageFileType = pathinfo($media_path,PATHINFO_EXTENSION);
 		if($imageFileType == "mp4")
 		{
 			print "<video  controls autoplay>
  			<source src=".$media_path." type='video/mp4'>
  			</video>";
  		}
  		if($imageFileType == "mp3")
  		{
			print "<audio controls autoplay>
  			<source src=".$media_path." type='audio/mpeg'>
  			</audio>";
  		}

  	}
  	?>