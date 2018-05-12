<?php session_start();
if (! empty($_SESSION['logged_in']))
{
    $con=mysqli_connect("localhost", "root","","Fund_Raising") or die(mysqli_connect_error());  
    $username=$_SESSION['username'] ;
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






 <div class='container'; style='position:absolute; left:10px'>
 <h3><b>Projects Till Now: </b></h3>

<?php

    $con=mysqli_connect("localhost", "root","","Fund_Raising") or die(mysqli_connect_error());  
    $username=$_SESSION['username'] ;
    $query = "select pname,pdesc,pstatus from projects where powner='$username'";
    $result=mysqli_query($con,$query); 

    print "<table class='table table-bordered table-hover' style='text-align:center;width:95%'>

        <col style='width:5%'>
        <col style='width:17%'>
        <col style='width:5%'>
        <col style='width:5%'>
        <col style='width:5%'>
        <col style='width:15%'>
       
        <thead>";
      
    print "<tr class='info'>";
    print "<th style='text-align:center' >Project Name</th>";
    print "<th style='text-align:center'>Project Descreption</th>";
    print "<th style='text-align:center'>Project Status</th>";
    print "<th style='text-align:center'>Total Likes</th>";
    print "<th style='text-align:center'>Change Status to Complete</th>";
    print "<th style='text-align:center'>Add Media</th>";
    print "</tr>";

    while($row = mysqli_fetch_array($result,MYSQLI_ASSOC)) 
    {
        $pname= $row['pname'];
        $pdesc=$row['pdesc'];
        $pstatus=$row['pstatus'];
          $query1 = "select pid from projects where powner='$username' and pname='$pname'";
        $result1=mysqli_query($con,$query1); 
        while($row1 = mysqli_fetch_array($result1,MYSQLI_ASSOC)) 
          {
            $pid=$row1['pid'];
          }
        print "<tr>";
        print "<td><a href='Projects.php?id=".$pid."'target='_top'>".$pname."</td>";
        print "<td>".$pdesc."</td>";
        print "<td>".strtoupper($pstatus)."</td>";
        print "<td>";
       
        $query2 = "select count(*) as likes from likes where pid=$pid";
        $result2=mysqli_query($con,$query2); 
        while($row2 = mysqli_fetch_array($result2,MYSQLI_ASSOC)) 
          {
            $likes = $row2['likes']; 
          }
            if($likes > 0)
            {
              print "$likes";
            }
            else
            {
              print "0";
            }
        
        print "</td>";

        print "<td>";
       
        if($pstatus=='EXECUTION')
        {
          
          print "<form class='form-horizontal' action=my_projects.php method=POST>";
          print "<button type='submit' class='btn btn-info'>Change</button>";
          print "<input type=hidden name=project_id value='".$pid."'>";
          print "<input type=hidden name=action_status value='status_change'>";
          print "</input>";
          print "</form>"; 
        }
        else
        {
          print "<p></p>";
        }
        
        print "</td>";
        print "<td>";
        if($pstatus=='EXECUTION' or $pstatus=='PENDING')
        {
          
          print "<form class='form-horizontal' action=my_projects.php method=POST enctype='multipart/form-data'>";
          print "<input class='form-control' type='file' name='fileToUpload' id='fileToUpload'></br>";  
           print "<button type='submit' class='btn btn-info'>Upload</button>";
          print "<input type=hidden name=project_id1 value='".$pid."'>";
          print "</input>";
          print "</form>"; 
        }
        else
        {
          print "<p></p>";
        }
        print "</td>";

  
    }
    print "</div>";

    if($_SERVER["REQUEST_METHOD"]=="POST")
    {
      if($_POST['action_status']=='status_change')
      {
          $pid=$_POST['project_id'];
          $query = "update projects set pstatus='COMPLETE', modification_time=current_timestamp where pid='$pid'";
          mysqli_query($con,$query);
          Print '<script>alert("Status changed successfully!");</script>'; 
          Print '<script>window.location.assign("my_projects.php");</script>'; 
      }
      else
      {
           $pid=$_POST['project_id1'];
           $location = '/Applications/XAMPP/xamppfiles/htdocs/Fund_Raising/Media/'.$username.'/'.$pid.'/';

          if (!is_dir($location))
          {
              Print '<script>alert("Sorry, there was an error uploading your File!");</script>'; 
              Print '<script>window.location.assign("my_projects.php");</script>'; 
          }
         
          $target_dir = $location;
          $target_file = $target_dir.basename($_FILES["fileToUpload"]["name"]);
          $uploadOk = 1;
          $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
         
          if($imageFileType == "")
          {
              Print '<script>alert("Please Choose a File!");</script>'; 
              Print '<script>window.location.assign("my_projects.php");</script>'; 
              $uploadOk = 0;
          }
         
          if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" && $imageFileType != "mp3" && $imageFileType != "mp4" && $imageFileType != "MOV") 
          {
              Print '<script>alert("Invalid File Format!");</script>'; 
              Print '<script>window.location.assign("my_projects.php");</script>'; 
              $uploadOk = 0;
          }
       
          if (file_exists($target_file)) 
          {
              Print '<script>alert("File already exists!");</script>'; 
              Print '<script>window.location.assign("my_projects.php");</script>'; 
              $uploadOk = 0;
          }
          
       
          if ($uploadOk == 0) 
          {
            Print '<script>alert("Sorry, your file was not uploaded!");</script>'; 
            Print '<script>window.location.assign("my_projects.php");</script>';
       
          }
          else 
          {
             if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) 
             {
              $targetfile1 = '.'.substr($target_file,50);
               $query = "insert into proj_media values('$pid','$targetfile1',default)";
               mysqli_query($con,$query);
               Print '<script>alert("File Uploaded Successfully!");</script>'; 
               Print '<script>window.location.assign("my_projects.php");</script>';
             } 
             else 
             {
               Print '<script>alert("Sorry, there was an error uploading your file!");</script>'; 
               Print '<script>window.location.assign("my_projects.php");</script>';
             }
          } 
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
    </div>
    </body>
</html>
