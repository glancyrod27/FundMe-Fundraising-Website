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
	if($_SERVER["REQUEST_METHOD"]=="GET")
	{
		$pid = $_GET['id'];
		$_SESSION['proj_id'] =$pid; 
    $query1= "insert into search_history values('$username',$pid, default)";
         mysqli_query($con,$query1); 
	}
	else
	{
		$pid=$_SESSION['proj_id'] ;
	}
	if($_SERVER["REQUEST_METHOD"]=="POST")
      {
      	if($_POST['to_do']=='like')
      	{
      		 $query1= "insert into likes values('$pid', '$username', default)";
	  		 mysqli_query($con,$query1); 
	  		 $_SESSION['proj_id'] =$pid;
      	}
      	if($_POST['to_do']=='rate')
      	{
      		 $rating=mysqli_real_escape_string($con,$_POST['rating']);
      		 $query1= "update pledge set rating=$rating where username='$username' and pid=$pid";
	  		 mysqli_query($con,$query1); 
	  		 $_SESSION['proj_id'] =$pid;
      	}
      	if($_POST['to_do']=='comment')
      	{
      		 $comment=mysqli_real_escape_string($con,$_POST['comments']);
      		 $query1= "insert into comments values('$pid', '$username', default, '$comment')";
	  		 mysqli_query($con,$query1); 
	  		 $_SESSION['proj_id'] =$pid;
      	}
      }	
	$query= "select *  from projects where pid='$pid'";
	$result=mysqli_query($con,$query); 

	while($row = mysqli_fetch_array($result,MYSQLI_ASSOC)) 	
	{

		$pid = $row['pid'];
		$pname = $row['pname']; 
		$pdesc = $row['pdesc'];
    	$powner = $row['powner'];
    	$pstatus=$row['pstatus'];
		$maxfund=$row['maxfund'];
		$minfund=$row['minfund'];
		$epcomp=$row['est_pcomp'];
		$efcomp=$row['est_fcomp'];
		$liked=false;
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
		if($fund=='')
		{
			$fund=0;
		}
		$temp2=($fund * 100)/$maxfund;
		$query1= "select count(*) as counter from likes where pid=$pid and  username='$username'";
		$result1=mysqli_query($con,$query1); 
		while($row1 = mysqli_fetch_array($result1,MYSQLI_ASSOC)) 
		{
			$counter=$row1['counter'];
		}
		if($counter!=0)
		{
			$liked=true;
		}
		$query3= "select count(*) as counter1 from pledge pl natural join projects p where pl.pid=$pid and  pl.username='$username' and p.pstatus='COMPLETE'";
		$result3=mysqli_query($con,$query3); 
		while($row3 = mysqli_fetch_array($result3,MYSQLI_ASSOC)) 
		{
			$rate=$row3['counter1'];

		}
		$query1= "select avg(rating) as avg_rate from pledge pl natural join projects p where p.pid=$pid and p.pstatus='COMPLETE'";
		$result1=mysqli_query($con,$query1); 
		while($row1 = mysqli_fetch_array($result1,MYSQLI_ASSOC)) 
		{
			$avg_rating=$row1['avg_rate'];
		}
		
print "<div class='container'; style='position:absolute; left:10px'>
		<h3>Summary of Entire Project:</h3>

		<table class='table table-bordered table-hover' style='width:66%'>
        <col style='width:6%'>
        <col style='width:10%'>
        <thead>
    	
    	<tr>
      	<th>Project Name:</th>
      <td>".$pname."</td></tr>
      <tr>
      <th >Project Description:</th>
      <td>".$pdesc."</td>
      </tr>
      <tr>
      <th>Project Owner:</th>
      <td><a href='Users.php?user=".$powner."' target='_top'>".$powner."</a></td>
      </tr>
      <tr>
      <th>Project Status:</th>
      <td >".$pstatus."</td>
      </tr>
      <tr>
      <th>Minimun Fund Required:</th>
      <td >".$minfund."</td>
      </tr>
      <tr>
      <th>Maximum Fund Required:</th>
      <td >".$maxfund."</td>
      </tr>
      <tr>
      <th>Funding Completion Date:</th>
      <td >".$efcomp."</td>
      </tr>
      <tr>
      <th>Project Completion Date:</th>
      <td >".$epcomp."</td>
      </tr>
      
      <tr>
      <th>Total Fund Received:</th>
      <td >".$fund."</td>
      </tr>
      <tr>
      <th>Likes:</th>
      <td >".$likes."</td>
      </tr>";
      if($avg_rating>0)
      {
      		print "<tr>
      		<th>Average Rating:</th>
      		<td >".$avg_rating."</td>
      		</tr>";	
      }
print" </div>


</table>

     <h4><b>Pledge Status:</b></h4>
      <div class='progress' style='width:66%'>
  		<div class='progress-bar progress-bar-success' style='width: ".$temp2."%'></div>
	 </div>

	  <h4><b>Comments:</b></h4>
	 <table class='table table-bordered table-hover' style='width:66%'>
	   <col style='width:6%'>
       <col style='width:10%'>
        <thead>
     <tr>
      <th>Username</th>
      <th>Comment</th>
      </tr>";
      $query1= "select * from comments where pid=$pid";
	  $result1=mysqli_query($con,$query1); 
		while($row1 = mysqli_fetch_array($result1,MYSQLI_ASSOC)) 
		{
			$cuser=$row1['username'];
			$comment=$row1['comments'];
			print "<tr>
    		<td><a href='Users.php?user=".$cuser."' target='_top'>".$cuser."</a></th>
      		<td>".$comment."</td>
      		</tr>";
		}
     print '</table>';

	  print "<div class='container'><h3>Media</h3>";
	 print "<div class='row'>";
	 $query1= "select * from proj_media where pid=$pid";
	  $result1=mysqli_query($con,$query1); 
		while($row1 = mysqli_fetch_array($result1,MYSQLI_ASSOC)) 
		{
			$media_path = $row1['media_path']; 
			$imageFileType = pathinfo($media_path,PATHINFO_EXTENSION);
			if(($imageFileType == "jpg" || $imageFileType == "png" || $imageFileType == "jpeg" || $imageFileType == "gif" ))
			{
				print "<div class='col-md-3'>
					<div class= 'thumbnail' style='max-height:50%'>
      				<a href='".$media_path."' target='_blank'>
        			<img src='".$media_path."' alt='image' style='max-height:35%'>
        			</a>
        			</div>
        			</div>";
        	}
        	if($imageFileType == "mp4" || $imageFileType == "mp3") 
        	{
        		print "<div class='col-md-3'>
					<div class= 'thumbnail' style='max-height:50%'>
					<a href=Play_media.php?path=".$media_path." target='_blank'>
					<img src='images.jpg' alt='image' style='max-height:35%'>
					</a>
					</div>
					</div>";
        	}
		}
		print "</div></div>
		<div style='position:absolute; left:75%;TOP:8%'>";

		if ($liked==true)
		{ 
		
		
			print "<button type='button' class='btn btn-info disabled data-toggle='tooltip' data-placement='right' title='Already Liked!'>&nbsp;&nbsp;&nbsp;Like!&nbsp;&nbsp;&nbsp;</button></br></br>";


		}
		else
		{ 
			print "<form class='form-horizontal' action='Projects.php' method='POST'>
			<input type='hidden' name='to_do' value='like'>
			<button  type='submit' class='btn btn-info'>&nbsp;&nbsp;&nbsp;Like!&nbsp;&nbsp;&nbsp;</button></form>";

		}

		if ($rate == 0)
		{ 
			
			 print "<button class='btn btn-info disabled data-toggle='tooltip' title='Either you have not pledged or the project status is not Complete!'>&nbsp;&nbsp;&nbsp;Rate!&nbsp;&nbsp;</button></br></br>";
	
		}
		else
		{ 
			print "
    			
    			<form class='form-horizontal' action='Projects.php' method='POST'>
    			
  				
  				<fieldset><select class='form-control' id='rating' name='rating'>
  				
     			<option value='1'>1</option>
          		<option value='2'>2</option>
          		<option value='3'>3</option>
          		<option value='4'>4</option>
          		<option value='5'>5</option>
        		</select>
    			<input type='hidden' name='to_do' value='rate'></br>
    			<button type='submit' class='btn btn-info'>&nbsp;&nbsp;&nbsp;Rate!&nbsp;&nbsp;&nbsp;</button></br>
  			</fieldset>
			</form>";

		}

		if($pstatus!='PENDING')
		{
			print "<button class='btn btn-info disabled data-toggle='tooltip' title='Project Status Not in Pending!'>Pledge!</button></br></br>";
		}
		else
		{
			$_SESSION['proj_id'] =$pid;

			print "<form  action='Pledge.php'>
  		<button type='submit' class='btn btn-info'>Pledge!</a></button>
		  </form>";
		}

		print "<form class='form-horizontal' action='Projects.php' method='POST'>
          		<fieldset>
			   <div class='form-group'>
               <div class='col-sm-10'>
                <input type='text' class='form-control' id='comments' placeholder='Comment Here' name='comments' required>
               </div>
               </div>
               </fildset>
              <input type='hidden' name='to_do' value='comment'>
              <button type='submit' class='btn btn-info'>Comment</button>";
		print "</div></div>";

	}
      
 

}
else
{
 	 Print '<script>alert("Please login first!");</script>'; 
  	Print '<script>window.location.assign("index.php");</script>'; 
}

 ?>

 </div>
    </body>
</html>