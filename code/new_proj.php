<?php session_start();
if (! empty($_SESSION['logged_in']))
{
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
          <link href="css/bootstrap.min.css" rel="stylesheet">
          <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
          <link rel="stylesheet" href="http://bootswatch.com/flatly/bootstrap.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
		  <script type="text/javascript" src="https://code.jquery.com/jquery-1.11.3.min.js"></script>
		  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/js/bootstrap-datepicker.min.js"></script>
		  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/css/bootstrap-datepicker3.css"/>

       <script>
  		var dateToday = new Date();
  		
        $(document).ready(function(){
        var date_input=$('input[name="efcomp"]');
        var container=$('.bootstrap-iso form').length>0 ? $('.bootstrap-iso form').parent() : "body";
        date_input.datepicker({
            format: 'yyyy-mm-dd',
			startDate: dateToday,           
            container: container,
            todayHighlight: true,
            autoclose: true,    
         });
       

        var date_input1=$('input[name="epcomp"]'); 
        var container=$('.bootstrap-iso form').length>0 ? $('.bootstrap-iso form').parent() : "body";
        date_input1.datepicker({
            format: 'yyyy-mm-dd',
			startDate:dateToday,           
            container: container,
            todayHighlight: true,
            autoclose: true,   
           });
       });      
      </script>

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
            </nav> </br>

         <div class="container"; style="max-width: 1000px">
          <form class="form-horizontal" action="new_proj.php" method="POST" enctype="multipart/form-data">
          <fieldset>
          <div class="col-sm-offset-2 col-sm-10">

            <legend>Enter Project Details: </legend>
           </div> 
            <div class="form-group">
               <label class="control-label col-sm-2" for="Title">Project Title:</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" id="pnmae" placeholder="Project Title" name="pname" required>
              </div>
            </div>
            <div class="form-group">
               <label class="control-label col-sm-2" for="Description">Description:</label>
               <div class="col-sm-10">
                <input type="text" class="form-control"  placeholder="Brief Description" name="pdesc" required>
              </div>
            </div>
            <div class="form-group">
               <label class="control-label col-sm-2" for="Fund Completion Date">Fund Completion:</label>
               <div class="col-sm-10">
                <input  class="form-control" placeholder="YYYY-MM-DD" name="efcomp" type="text" required>
              </div>
            </div>
            <div class="form-group">
               <label class="control-label col-sm-2" for="Project Completion Date" >Project Completion:</label>
               <div class="col-sm-10">
                <input class="form-control" placeholder="YYYY-MM-DD"  name="epcomp" type="text" required>
              </div>
            </div>
            <div class="form-group">
               <label class="control-label col-sm-2" for="Min Fund">Minimum Fund:</label>
               <div class="col-sm-10">
                <input class="form-control"  placeholder="Minimum Required Fund" type="number" name="minfund" required>
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-sm-2" for="Max Fund">Maximum Fund:</label>
              <div class="col-sm-10">          
              <input class="form-control" placeholder="Maximum Required Fund" type="number" name="maxfund" required>
              </div>
             </div> 
        
            <label class="control-label col-sm-2" for="tags">Select Tags: </label>
        	<div class="checkbox" >

        	<label>
             <table border=0 width=40%>
               <tr>
               <td><input  type="checkbox" style="position:absolute; left:19.5%"; name="tag[]" value="Arts">&nbsp;&nbsp;Arts</td>
               <td><input  type="checkbox" style="position:absolute; left:27%"; name="tag[]" value="Dance">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Dance</td>
               <td><input  type="checkbox" style="position:absolute; left:35%"; name="tag[]" value="Fashion">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Fashion</td>
               <td><input  type="checkbox" style="position:absolute; left:46%"; name="tag[]" value="Food">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Food</td>
               </tr>
               <tr>
               <td><input  type="checkbox" style="position:absolute; left:19.5%"; name="tag[]" value="Games">&nbsp;&nbsp;Games</td>
               <td><input  type="checkbox" style="position:absolute; left:27%"; name="tag[]" value="Music">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Music</td>
               <td><input  type="checkbox" style="position:absolute; left:35%"; name="tag[]" value="Technology">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Technology</td>
               <td><input  type="checkbox" style="position:absolute; left:46%"; name="tag[]" value="Film">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Film</td>
               </tr>
               </table></br>
               </label>
               </div>

            <div class="form-group">
              <label class="control-label col-sm-2">Cover Image:</label>
              <div class="col-sm-10"> 
    		  <input class="form-control" type="file" name="fileToUpload" id="fileToUpload" required>
    		   <input type="hidden" name="fileToUpload" value="fileToUpload">
           	  </div>
            </div></br>
           	   
           
            <div class="form-group">
              <div class="col-sm-offset-2 col-sm-10">
                <button type="reset" class="btn btn-default">Cancel</button>&nbsp;&nbsp;&nbsp;
                <button type="submit" name='submit' class="btn btn-primary">Create Project</button>
              </div>
            </div>
          </fieldset>
        </form>
        </div>


<?php
if($_SERVER["REQUEST_METHOD"]=="POST")
{
	$con=mysqli_connect("localhost", "root","","Fund_Raising") or die(mysqli_connect_error());	
		$username=$_SESSION['username'] ;

		$project_exists=false;
		$proper=true;

		$pname=mysqli_real_escape_string($con,$_POST['pname']);
		$pdesc=mysqli_real_escape_string($con,$_POST['pdesc']);
		$epcomp=mysqli_real_escape_string($con,$_POST['epcomp']);
		$efcomp=mysqli_real_escape_string($con,$_POST['efcomp']);
		$minfund=mysqli_real_escape_string($con,$_POST['minfund']);
		$maxfund=mysqli_real_escape_string($con,$_POST['maxfund']);
		$query = "Select pname,powner from projects";
		$result=mysqli_query($con,$query); 

		
		while($row = mysqli_fetch_array($result,MYSQLI_ASSOC)) 
		{
			$table_project = $row['pname']; 
			$table_owner = $row['powner'];
			if($username == $table_owner && $pname == $table_project) 
			{
				$project_exists = true; 
				Print '<script>alert("Project already present!");</script>'; 
			}

		}
		if($epcomp<$efcomp)
		{
			$proper=false;
			Print '<script>alert("Project Completion Date Must be Greater than Fund Completion Date!");</script>'; 
		}

		elseif($minfund<0 || $maxfund<0)
		{	
			$proper=false;
			Print '<script>alert("Funding amount must be greater than zero!");</script>'; 
			exit;
		}
		elseif($minfund > $maxfund)
		{
			$proper=false;
			Print '<script>alert("Maximum Fund Should be Greater than Minimum Fund!");</script>'; 
			exit;
		}
		elseif(empty($_POST['tag']))
		{
			$proper=false;
			Print '<script>alert("Please select atleast one tag!");</script>'; 
			exit;
		}


		 $location = '/Applications/XAMPP/xamppfiles/htdocs/Fund_Raising/Media/'.$username;

         if (!is_dir($location))
          {
              mkdir($location,0755);
          }
          
          $target_dir = $location;
          $target_file = $target_dir.basename($_FILES["fileToUpload"]["name"]);
          $uploadOk = 1;
          $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
          if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") 
          {
              Print '<script>alert("Invalid File Format, please upload .jpg/ .jpeg/ .gif/ .png only!");</script>';  
              $uploadOk = 0;
              exit;
          }
          if ($uploadOk == 0) 
          {
            Print '<script>alert("Sorry, your file was not uploaded!");</script>'; 
            exit;
          }
          else 
          {
          	$fileupload = true;
          }
		
		
		if($project_exists==false && $proper==true && $fileupload==true)
		{
			$query = "insert into projects values (null,'$pname','$pdesc','$username',default,'$epcomp','$efcomp','$minfund','$maxfund',default,default)";
			mysqli_query($con,$query); 
			Print '<script>alert("Successfully added new project!");</script>'; 
			$query="select max(pid) as c_pid from projects where powner='$username'";
			$result=mysqli_query($con,$query);
			while($row = mysqli_fetch_array($result,MYSQLI_ASSOC))
    		{
       			$pid=$row['c_pid'];
       		}

       		if(!empty($_POST['tag']))
			{
				foreach ($_POST['tag'] as $check) 
				{
					$query = "insert into tags values ('$pid','$check')";
					mysqli_query($con,$query); 
				}
			}

			$location1 = $location.'/'.$pid.'/';
            if (!is_dir($location1))
            {
              mkdir($location1,0755);
            }
          	$target_dir = $location1;
          	$target_file = $target_dir.basename($_FILES["fileToUpload"]["name"]);

       		if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) 
             {
               $targetfile1 = '.'.substr($target_file,50);
				$query2 = "insert into proj_media values('$pid','$targetfile1',default)";
               mysqli_query($con,$query2);  
             } 
             else 
             {
               Print '<script>alert("Sorry, there was an error uploading your file!");</script>'; 
               exit;
             }

			Print '<script>window.location.assign("first_page.php");</script>'; 
		}
		
}
?>
<?php 
 }
 else
 {
  Print '<script>alert("Please login first!");</script>'; 
  Print '<script>window.location.assign("index.php");</script>'; 
 }?>
 </body>
</html>