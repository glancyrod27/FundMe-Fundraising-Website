<?php session_start();

if (! empty($_SESSION['logged_in']))
{
	$_SESSION['logged_in'] = true;
?>
<html>
    <head>
    	  <meta charset="utf-8">
          <meta http-equiv="X-UA-Compatible" content="IE=edge">
          <meta name="viewport" content="width=device-width, initial-scale=1">
          <title>FundMe_Website</title>
          <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
		  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
		  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	      <link rel="stylesheet" href="http://bootswatch.com/flatly/bootstrap.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
    </head>
    <body>


    <?php        
		$con=mysqli_connect("localhost", "root","","Fund_Raising") or die(mysqli_connect_error());  
		$username=$_SESSION['username'] ;?>
 
      		  <nav class="navbar navbar-default">
              <div class="container-fluid", style="background-color: #2c3e50">
                <div class="navbar-header">
                  <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                  </button>
                  <a class="navbar-brand" href="index.php">FundMe &nbsp;<b>|</b></a>
                </div>

                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                   <ul class="nav navbar-nav">
                     <li><a href="explore.php">Explore</a></li>
                   </ul>
                   <ul class="nav navbar-nav">
                     <li><a href="aboutus.php">About Us</a></li>
                   </ul>
                   <ul class="nav navbar-nav">
                     <li><a href="first_page.php">Your World</a></li>
                   </ul>
		    
   
				   <ul class="nav navbar-nav">
				      <li class="dropdown">
				      <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="true">Things To Do <span class="caret"></span></a>
				        <ul class="dropdown-menu" role="menu">
				            <li><a href="new_proj.php",  target="_top">Create Project</a></li>
				            <li><a href="my_projects.php", target="_top">Update My Projects</a></li>
				            <li><a href="update_profile.php", target="_top">Update Profile</a></li>
				            <li><a href="manage_payment.php", target="_top">Manage Payments</a></li>
				         </ul>
				       </li>
				    </ul>
      

                   <ul class="nav navbar-nav navbar-right">
                    <li><a href="logout.php">Log Out</a></li>
                   </ul>
                   <ul class="nav navbar-nav navbar-right">
                   <li><img src = "user2.png" alt="user pic" style="position:absolute; TOP:6px;RIGHT:-8px; "></li>
                    <li><a href="Users.php?user=<?php echo $username?>"><b><?php echo $username?></b></a></li>
                   </ul>
                   <form class="navbar-form navbar-left" role="search" action="search.php" method="POST">
                   <div class="form-group">
                      <input type="text", name="keyword" style="text-align: center", class="form-control" placeholder="Search Projects">
                   </div>
                     <button type="submit" class="btn btn-default">Search</button>
                   </form>
              
                </div>
              </div>
            </nav> 


            <?php 
 		$con=mysqli_connect("localhost", "root","","Fund_Raising") or die(mysqli_connect_error());  
		$username=$_SESSION['username'] ;

		print "<div class='container'><h3>Trending:</h3>";
			print "<div class='row'>";
			$query= "select likes1 , x.pid as proj_id, x.pname as proj_name, x.powner as owner, pm.media_path as med_path, x.maxfund as maxfund from (select count(*) as likes1 , p.pid , p.pname , p.powner , p.maxfund  from projects p natural join  likes l where p.pstatus<>'FAILED' group by p.pid)x natural join proj_media pm order by likes1 desc";
			$result=mysqli_query($con,$query); 
			$temp=0;
			$temp1=0;	
		while($row = mysqli_fetch_array($result,MYSQLI_ASSOC)) 
			{
				$likes1=$row['likes1'];
				$pid = $row['proj_id'];
				$pname = $row['proj_name']; 
    			$powner = $row['owner'];
				$media_path = $row['med_path']; 
				$maxfund=$row['maxfund'];
				$query1= "select count(*) as likes from projects p natural join likes l where p.pid='$pid'";
				$result1=mysqli_query($con,$query1); 
				while($row1 = mysqli_fetch_array($result1,MYSQLI_ASSOC)) 
				{
					$likes=$row1['likes'];
				}
				$query1= "select sum(pledged_amount) as fund from pledge where pid=$pid";
				$result1=mysqli_query($con,$query1); 
				while($row1 = mysqli_fetch_array($result1,MYSQLI_ASSOC)) 
				{
					$fund=$row1['fund'];
				}
				$imageFileType = pathinfo($media_path,PATHINFO_EXTENSION);
				if ($pid != $temp && $temp1!=4 && ($imageFileType == "jpg" || $imageFileType == "png" || $imageFileType == "jpeg" || $imageFileType == "gif" ))
				{
					$temp1=$temp1+1;
					$temp2=($fund * 100)/$maxfund;
					print "<div class='col-md-3'>
					<div class= 'thumbnail' style='max-height:50%'>
      				<a href='Projects.php?id=".$pid."' target='_top'>
        			<img src='".$media_path."' alt='image' style='max-height:35%'>
        			<div class='caption'>
          			<p><b>".$pname."</br>".$powner."</b></br><b>Likes: ".$likes."</b></p>
        			</div>
        			<p>Pledge Status:</p>
        			<div class='progress'>
  						<div class='progress-bar progress-bar-success' style='width: ".$temp2."%'></div>
					</div>
     				 </a>
     				 </div></div>";
     				 $temp=$pid;
				}
				
			}
			print "</div></div>";

		
		
			$query="select count(*) as counter1 from projects p  natural join proj_media pm natural join search_history h where h.username='$username' order by h.s_time desc";
		$result=mysqli_query($con,$query); 
		while($row = mysqli_fetch_array($result,MYSQLI_ASSOC)) 
		{
			$counter = $row['counter1'];
		}
		if($counter!=0)	
		{
			print "</br></br><div class='container'><h3>Recent Searches:</h3>";
			print "<div class='row'>";
			$query= "select distinct(p.pid) as proj_id, p.pname as proj_name,  p.powner as owner, pm.media_path as med_path ,p.maxfund as maxfund from projects p  natural join proj_media pm natural join search_history h where h.username='$username' order by h.s_time desc";
			$result=mysqli_query($con,$query); 
			$temp=0;
			$temp1=0;	
			while($row = mysqli_fetch_array($result,MYSQLI_ASSOC)) 
			{
				$pid = $row['proj_id'];
				$pname = $row['proj_name']; 
    			$powner = $row['owner'];
				$media_path = $row['med_path']; 
				$maxfund=$row['maxfund'];
				$query1= "select count(*) as likes from projects p natural join likes l where p.pid='$pid'";
				$result1=mysqli_query($con,$query1); 
				while($row1 = mysqli_fetch_array($result1,MYSQLI_ASSOC)) 
				{
					$likes=$row1['likes'];
				}
				$query1= "select sum(pledged_amount) as fund from pledge where pid=$pid";
				$result1=mysqli_query($con,$query1); 
				while($row1 = mysqli_fetch_array($result1,MYSQLI_ASSOC)) 
				{
					$fund=$row1['fund'];
				}
				$imageFileType = pathinfo($media_path,PATHINFO_EXTENSION);
				if ($pid != $temp && $temp1!=4 && ($imageFileType == "jpg" || $imageFileType == "png" || $imageFileType == "jpeg" || $imageFileType == "gif" ))
				{
					$temp1=$temp1+1;
					$temp2=($fund * 100)/$maxfund;
					print "<div class='col-md-3'>
					<div class= 'thumbnail' style='max-height:50%'>
      				<a href='Projects.php?id=".$pid."' target='_top'>
        			<img src='".$media_path."' alt='image' style='max-height:35%'>
        			<div class='caption'>
        			<p><b>".$pname."</br>".$powner."</br>Likes: ".$likes."</b></p>
        			</div>
        			<p>Pledge Status:</p>
        			<div class='progress'>
  						<div class='progress-bar progress-bar-success' style='width: ".$temp2."%'></div>
					</div>
     				 </a>
     				 </div></div>";
     				 $temp=$pid;
				}
				
			}
			print "</div></div>";
		}


		$query="select count(*) as counter1 from projects p  natural join proj_media pm natural join likes l where l.username='$username' and p.pstatus<>'FAILED'";
		$result=mysqli_query($con,$query); 
		while($row = mysqli_fetch_array($result,MYSQLI_ASSOC)) 
		{
			$counter = $row['counter1'];
		}
		if($counter!=0)	
		{
			print "</br></br><div class='container'><h3>Liked Projects:</h3>";
			print "<div class='row'>";
			$query= "select distinct(p.pid) as proj_id, p.pname as proj_name,  p.powner as owner, pm.media_path as med_path ,p.maxfund as maxfund from projects p  natural join proj_media pm natural join likes l where l.username='$username' and p.pstatus<>'FAILED' order by p.pcreate_time desc";
			$result=mysqli_query($con,$query); 
			$temp=0;
			$temp1=0;	
			while($row = mysqli_fetch_array($result,MYSQLI_ASSOC)) 
			{
				$pid = $row['proj_id'];
				$pname = $row['proj_name']; 
    			$powner = $row['owner'];
				$media_path = $row['med_path']; 
				$maxfund=$row['maxfund'];
				$query1= "select count(*) as likes from projects p natural join likes l where p.pid='$pid'";
				$result1=mysqli_query($con,$query1); 
				while($row1 = mysqli_fetch_array($result1,MYSQLI_ASSOC)) 
				{
					$likes=$row1['likes'];
				}
				$query1= "select sum(pledged_amount) as fund from pledge where pid=$pid";
				$result1=mysqli_query($con,$query1); 
				while($row1 = mysqli_fetch_array($result1,MYSQLI_ASSOC)) 
				{
					$fund=$row1['fund'];
				}
				$imageFileType = pathinfo($media_path,PATHINFO_EXTENSION);
				if ($pid != $temp && $temp1!=4 && ($imageFileType == "jpg" || $imageFileType == "png" || $imageFileType == "jpeg" || $imageFileType == "gif" ))
				{
					$temp1=$temp1+1;
					$temp2=($fund * 100)/$maxfund;
					print "<div class='col-md-3'>
					<div class= 'thumbnail' style='max-height:50%'>
      				<a href='Projects.php?id=".$pid."' target='_top'>
        			<img src='".$media_path."' alt='image' style='max-height:35%'>
        			<div class='caption'>
        			<p><b>".$pname."</br>".$powner."</br>Likes: ".$likes."</b></p>
        			</div>
        			<p>Pledge Status:</p>
        			<div class='progress'>
  						<div class='progress-bar progress-bar-success' style='width: ".$temp2."%'></div>
					</div>
     				 </a>
     				 </div></div>";
     				 $temp=$pid;
				}
				
			}
			print "</div></div>";
		}


		$query="select count(*) as counter3 from projects p ,proj_media pm, pledge pl where pl.username='$username'";
		$result=mysqli_query($con,$query); 
		while($row = mysqli_fetch_array($result,MYSQLI_ASSOC)) 
		{
			$counter = $row['counter3'];
		}
		if($counter!=0)	
		{
			print "</br></br><div class='container'><h3>Funded By You:</h3>";
			print "<div class='row'>";
			$query= "select distinct(p.pid) as proj_id, p.pname as proj_name, p.powner as owner, pm.media_path as med_path , p.maxfund as maxfund from projects p natural join proj_media pm natural join pledge pl where pl.username='$username' order by p.pcreate_time desc";
			$result=mysqli_query($con,$query); 
			$temp=0;
			$temp1=0;	
			while($row = mysqli_fetch_array($result,MYSQLI_ASSOC)) 
			{
				$pid = $row['proj_id'];
				$pname = $row['proj_name']; 
    			$powner = $row['owner'];
				$media_path = $row['med_path'];
				$maxfund=$row['maxfund'];
				$query1= "select count(*) as likes from projects p natural join likes l where p.pid='$pid'";
				$result1=mysqli_query($con,$query1); 
				while($row1 = mysqli_fetch_array($result1,MYSQLI_ASSOC)) 
				{
					$likes=$row1['likes'];
				}
				$query1= "select sum(pledged_amount) as fund from pledge where pid=$pid";
				$result1=mysqli_query($con,$query1); 
				while($row1 = mysqli_fetch_array($result1,MYSQLI_ASSOC)) 
				{
					$fund=$row1['fund'];
				} 
				$imageFileType = pathinfo($media_path,PATHINFO_EXTENSION);
				if ($pid != $temp && $temp1!=4 && ($imageFileType == "jpg" || $imageFileType == "png" || $imageFileType == "jpeg" || $imageFileType == "gif" ))
				{
					$temp1=$temp1+1;
					$temp2=($fund * 100)/$maxfund;
					print "<div class='col-md-3'>
					<div class= 'thumbnail' style='max-height:50%'>
      				<a href='Projects.php?id=".$pid."' target='_top'>
        			<img src='".$media_path."' alt='image' style='max-height:35%'>
        			<div class='caption'>
          			<p><b>".$pname."</br>".$powner."</br>Likes: ".$likes."</b></p>
        			</div>
        			<p>Pledge Status:</p>
        			<div class='progress'>
  						<div class='progress-bar progress-bar-success' style='width: ".$temp2."%'></div>
					</div>
     				 </a>
     				 </div></div>";
     				 $temp=$pid;
				}
				
			}
			print "</div></div>";
		}


		$query= "select count(*) as counter from projects p  natural join tags t natural join proj_media pm , interest i where t.tags=i.interests and i.username='$username' and p.pstatus<>'FAILED'";
		$result=mysqli_query($con,$query); 
		while($row = mysqli_fetch_array($result,MYSQLI_ASSOC)) 
		{
			$counter = $row['counter'];
		}
		if($counter!=0)	
		{
			print "</br></br><div class='container'><h3>You May Be Interested In:</h3>";
			print "<div class='row'>";
			$query= "select distinct(p.pid) as proj_id, p.pname as proj_name, p.powner as owner, pm.media_path as med_path, p.maxfund as maxfund from projects p  natural join tags t natural join proj_media pm , interest i where t.tags=i.interests and i.username='$username' and p.pstatus<>'FAILED' order by p.pcreate_time desc";
			$result=mysqli_query($con,$query); 
			$temp=0;
			$temp1=0;	
			while($row = mysqli_fetch_array($result,MYSQLI_ASSOC)) 
			{
				$pid = $row['proj_id'];
				$pname = $row['proj_name']; 
    			$powner = $row['owner'];
				$media_path = $row['med_path']; 
				$maxfund=$row['maxfund'];
				$query1= "select count(*) as likes from projects p natural join likes l where p.pid='$pid'";
				$result1=mysqli_query($con,$query1); 
				while($row1 = mysqli_fetch_array($result1,MYSQLI_ASSOC)) 
				{
					$likes=$row1['likes'];
				}
				$query1= "select sum(pledged_amount) as fund from pledge where pid=$pid";
				$result1=mysqli_query($con,$query1); 
				while($row1 = mysqli_fetch_array($result1,MYSQLI_ASSOC)) 
				{
					$fund=$row1['fund'];
				}
				$imageFileType = pathinfo($media_path,PATHINFO_EXTENSION);
				if ($pid != $temp && $temp1!=4 && ($imageFileType == "jpg" || $imageFileType == "png" || $imageFileType == "jpeg" || $imageFileType == "gif" ))
				{
					$temp1=$temp1+1;
					$temp2=($fund * 100)/$maxfund;
					print "<div class='col-md-3'>
					<div class= 'thumbnail' style='max-height:50%'>
      				<a href='Projects.php?id=".$pid."' target='_top'>
        			<img src='".$media_path."' alt='image' style='max-height:35%'>
        			<div class='caption'>
          			<p><b>".$pname."</br>".$powner."</br>Likes: ".$likes."</b></p>
        			</div>
        			<p>Pledge Status:</p>
        			<div class='progress'>
  						<div class='progress-bar progress-bar-success' style='width: ".$temp2."%'></div>
					</div>
     				 </a>
     				 </div></div>";
     				 $temp=$pid;
				}
				
			}
			print "</div></div>";
		}


		$query= "select count(*) as counter from projects p ,proj_media pm, follow f where f.f_username='$username' and p.pstatus<>'FAILED' and p.powner=f.username and p.pid=pm.pid";
		$result=mysqli_query($con,$query); 
		while($row = mysqli_fetch_array($result,MYSQLI_ASSOC)) 
		{
			$counter = $row['counter'];
		}
		if($counter!=0)	
		{
			print "</br></br><div class='container'><h3>Projects By People You Follow:</h3>";
			print "<div class='row'>";
			$query= "select distinct(p.pid) as proj_id, p.pname as proj_name, p.powner as owner, pm.media_path as med_path , p.maxfund as maxfund from projects p ,proj_media pm, follow f where f.f_username='$username' and p.pstatus<>'FAILED' and p.powner=f.username and p.pid=pm.pid order by p.pcreate_time desc";
			$result=mysqli_query($con,$query); 
			$temp=0;
			$temp1=0;	
			while($row = mysqli_fetch_array($result,MYSQLI_ASSOC)) 
			{
				$pid = $row['proj_id'];
				$pname = $row['proj_name']; 
    			$powner = $row['owner'];
				$media_path = $row['med_path']; 
				$maxfund=$row['maxfund'];
				$query1= "select count(*) as likes from projects p natural join likes l where p.pid='$pid'";
				$result1=mysqli_query($con,$query1); 
				while($row1 = mysqli_fetch_array($result1,MYSQLI_ASSOC)) 
				{
					$likes=$row1['likes'];
				}
				$query1= "select sum(pledged_amount) as fund from pledge where pid=$pid";
				$result1=mysqli_query($con,$query1); 
				while($row1 = mysqli_fetch_array($result1,MYSQLI_ASSOC)) 
				{
					$fund=$row1['fund'];
				}
				$imageFileType = pathinfo($media_path,PATHINFO_EXTENSION);
				if ($pid != $temp && $temp1!=4 && ($imageFileType == "jpg" || $imageFileType == "png" || $imageFileType == "jpeg" || $imageFileType == "gif" ))
				{
					$temp1=$temp1+1;
					$temp2=($fund * 100)/$maxfund;
					print "<div class='col-md-3'>
					<div class= 'thumbnail' style='max-height:50%'>
      				<a href='Projects.php?id=".$pid."' target='_top'>
        			<img src='".$media_path."' alt='image' style='max-height:35%'>
        			<div class='caption'>
          			<p><b>".$pname."</br>".$powner."</br>Likes: ".$likes."</b></p>
        			</div>
        			<p>Pledge Status:</p>
        			<div class='progress'>
  						<div class='progress-bar progress-bar-success' style='width: ".$temp2."%'></div>
					</div>
     				 </a>
     				 </div></div>";
     				 $temp=$pid;
				}
				
			}
			print "</div></div>";
		}
		
	}
 	else
 	{
 	 	Print '<script>alert("Please login first!");</script>'; 
  		Print '<script>window.location.assign("index.php");</script>'; 
 	}
 ?>
    </body>
</html>
