<?php session_start();
if (! empty($_SESSION['logged_in']))
{
	$_SESSION['logged_in'] = true;
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

<?php
  if($_SERVER["REQUEST_METHOD"]=="GET")
  {
    $user = $_GET['user'];
    $_SESSION['user'] =$user;
  }
  else
  {
    $user=$_SESSION['user'] ;
  }
  if($_SERVER["REQUEST_METHOD"]=="POST")
  {
        if($_POST['to_do']=='follow')
        {
         $query1= "insert into follow values('$user', '$username')";
         mysqli_query($con,$query1); 
         $_SESSION['user'] =$user;
    
        }
  } 

  print "<div class='container'; style='position:absolute; left:10px'>";
  print "<h3><b>User Info:</b></h3>";
  $query= "select *  from users where username='$user'";
  $result=mysqli_query($con,$query); 
  $followed=false;
  while($row = mysqli_fetch_array($result,MYSQLI_ASSOC))  
  { 
      $user = $row['username'];
      $fname = $row['fname']; 
      $lname = $row['lname']; 
      $email = $row['email'];
      $city = $row['city'];
      $state=$row['state'];
      $zipcode=$row['zipcode'];
      
      print "<table class='table table-bordered table-hover' style='width:40%'>
        <col style='width:5%'>
        <col style='width:10%'>
        <thead>
      <tr>
        <th>Username:</th>
      <td><a href='Users.php?user=".$user."' target='_top'>".$user."</a></td>
      </tr>
      <tr>
      <th>First Name:</th>
      <td>".$fname."</td>
      </tr>
      <tr>
      <th>Last Name:</th>
      <td>".$lname."</td>
      </tr>
      <tr>
      <th>Email:</th>
      <td>".$email."</td>
      </tr>
      <tr>
      <th>City:</th>
      <td>".$city."</td>
      </tr>
      <tr>
      <th>State:</th>
      <td>".$state."</td>
      </tr>
      <tr>
      <th>Zipcode:</th>
      <td>".$zipcode."</td>
      </tr>
      <tr>
      <th>Interests:</th>";
      $query1= "select * from interest where username='$user'";
      $result1=mysqli_query($con,$query1); 
      $temp=0;
      while($row1 = mysqli_fetch_array($result1,MYSQLI_ASSOC)) 
      {
          $interest=$row1['interests'];
          if($temp==0)
          {
               print "<td>".$interest."</td></tr>";
               $temp=$temp+1;
          }
          else
          {
              print "<tr><td></td><td>".$interest."</td></tr>";
          }
         
    }
    if($temp==0)
    {
      print "<td></td></tr>";
    }
    print "<tr>
      <th>Followers:</th>";
    $query1= "select * from follow where username='$user'";
      $result1=mysqli_query($con,$query1); 
      $temp=0;
      while($row1 = mysqli_fetch_array($result1,MYSQLI_ASSOC)) 
      {
          $follows=$row1['f_username'];

          if($temp==0)
          {
               print "<td><a href='Users.php?user=".$follows."' target='_top'>".$follows."</a></td></tr>";
               $temp=$temp+1;
          }
          else
          {
              print "<tr><td></td><td><a href='Users.php?user=".$follows."' target='_top'>".$follows."</a></td></tr>";
          }
        
         
    }
    if($temp==0)
    {
      print "<td>None</td></tr>";
    }

    print "<tr>
    <th>Following:</th>";
    $query1= "select * from follow where f_username='$user'";
    $result1=mysqli_query($con,$query1); 
    $temp1=0;
    while($row1 = mysqli_fetch_array($result1,MYSQLI_ASSOC)) 
      {
          $following=$row1['username'];
          if($temp1==0)
          {
            print "<td><a href='Users.php?user=".$following."' target='_top'>".$following."</a></td></tr>";
            $temp1=$temp1+1;
          }
          else
          {
            print "<tr><td></td><td><a href='Users.php?user=".$following."' target='_top'>".$following."</a></td></tr>";
          }
      }
      if($temp1==0)
      {
        print "<td>None</td></tr>";
      }
      print "</table>";
  }


   $query1= "select count(*) as counter1 from follow  where username='$user' and f_username='$username'";
    $result1=mysqli_query($con,$query1); 
    while($row1 = mysqli_fetch_array($result1,MYSQLI_ASSOC)) 
    {
      $counter1=$row1['counter1'];
    }
    if($counter1!=0)
    {
      $followed=true;
    }
    if ($followed==true || $user==$username)
    { 
      print "<button class='btn btn-info disabled' title='Already Followed or Cannot Follow Yourself' class='btn btn-primary'>Follow User!</button></br></br>";
    }
    else
    { 
      print "<form class='form-horizontal' action='Users.php' method='POST'>
      <input type='hidden' name='to_do' value='follow'>

      <button  type='submit' class='btn btn-info'>Follow User!</button></form>";
    

    }



    $query= "select count(*) as counter from projects where powner='$user'";
    $result=mysqli_query($con,$query); 
    while($row = mysqli_fetch_array($result,MYSQLI_ASSOC)) 
    {
      $counter = $row['counter'];
    }
    if($counter!=0) 
    {
      if($username==$user)
      {
        print "<h4><b>My Projects:</b></h4>";
      }
      else
      {
      print "<h4><b>Projects of User $user:</b></h4>";
      }
      print "<div class='row'>";
      $query= "select p.pid as proj_id, p.pname as proj_name, p.powner as owner, pm.media_path as med_path, p.maxfund as maxfund from projects p  natural join proj_media pm  where p.powner='$user' order by p.pcreate_time desc";
      $result=mysqli_query($con,$query); 
      $temp=0;
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
        if ($pid != $temp && ($imageFileType == "jpg" || $imageFileType == "png" || $imageFileType == "jpeg" || $imageFileType == "gif" ))
        {
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
      print "</div>";
    }
    
    print"</div>";

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
    