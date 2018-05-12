<?php session_start();
$con=mysqli_connect("localhost", "root","","Fund_Raising") or die(mysqli_connect_error());?>
<html>
    <head>
          <meta charset="utf-8">
          <meta http-equiv="X-UA-Compatible" content="IE=edge">
          <meta name="viewport" content="width=device-width, initial-scale=1">
          <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
          <title>FundMe_Website</title>

          <!-- Bootstrap -->

          <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
          <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
          <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
          <link href="css/bootstrap.min.css" rel="stylesheet">
          <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
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
                  
                   <?php
                   if (! empty($_SESSION['logged_in']))
                    {
                      $username=$_SESSION['username'];
                      $_SESSION['logged_in'] = true;
                    ?>
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
                  <?php
                    }
                  else
                  { ?>
                   <ul class="nav navbar-nav navbar-right">
                    <li><a href="sign_up_page.php">Sign Up</a></li>
                   </ul>
                   <ul class="nav navbar-nav navbar-right">
                    <li><a href="login.php">Log In</a></li>
                   </ul>
                   <?php } ?>
                    <form class="navbar-form navbar-nav" role="search" action="search.php" method="POST">
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
            $tags = $_GET['tag'];
          
            if(isset($_GET['tag']))
           {
             $query = "select p.pid as proj_id, p.pname as proj_name, p.powner as owner , pm.media_path as med_path ,p.maxfund as maxfund from projects p natural join proj_media pm natural join tags t where t.tags='$tags'";
           }
          }


if($_SERVER["REQUEST_METHOD"]=="POST")
{
    $keyword=mysqli_real_escape_string($con,$_POST['keyword']);
    if ($keyword == '')
    {
      print "<h3><b>&nbsp;&nbsp;&nbsp;All Projects:</b></h3></br>";
      $query = "select p.pid as proj_id, p.pname as proj_name, p.powner as owner , pm.media_path as med_path , p.maxfund as maxfund from projects p natural join proj_media pm";
    }
    else
    {
       print "<h3>Projects Matching Your Search Criteria:</h3></br>";
       $query2 = "select count(*) from (select p.pid as proj_id, p.pname as proj_name, p.powner as owner , pm.media_path as med_path, p.maxfund as maxfund from projects p natural join proj_media pm where p.pname like '%".$keyword."%' or p.pdesc like '%".$keyword."%') as x";
       $result2=mysqli_query($con,$query2); 
        while($row2 = mysqli_fetch_array($result2,MYSQLI_ASSOC)) 
        {
          $count2=$row2['count(*)'];
        }
        if($count2 <=0)
        {
            print "<h4><b>Sorry No Projects Matching Your Criteria</b></h4>
                   <h4><b>Please Refine Your Search Or Click On Search To View All Projects</b></h4>";
                   exit;
        }
        else
         {
            $query = "select p.pid as proj_id, p.pname as proj_name, p.powner as owner , pm.media_path as med_path, p.maxfund as maxfund from projects p natural join proj_media pm where p.pname like '%".$keyword."%' or p.pdesc like '%".$keyword."%'";
          }
        }
      }

       



     $result = mysqli_query($con,$query);
  $temp=0;
  while($row = mysqli_fetch_array($result,MYSQLI_ASSOC))
  {
    $pid = $row['proj_id'];
    $pname = $row['proj_name'];
    $powner = $row['owner'];
    $path_media = $row['med_path'];
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
  $imageFileType = pathinfo($path_media,PATHINFO_EXTENSION);
    if($temp != $pid && ($imageFileType == "jpg" || $imageFileType == "png" || $imageFileType == "jpeg" || $imageFileType == "gif" ))
    {
      $temp2=($fund * 100)/$maxfund;
    print "<div class='col-md-3'>
    <div class= 'thumbnail' style='max-height:50%'>
        <a href='Projects.php?id=".$pid."' target='_top'>
        <img src='".$path_media."' alt='image' style='max-height:35%'>
        <div class='caption'>
        <p><b>".$pname."</br>".$powner."</b></br><b>Likes: ".$likes."</b></p>
        </div>
        <p>Pledge Status:</p>
        <div class='progress'>
      <div class='progress-bar progress-bar-success' style='width: ".$temp2."%'></div>
    </div>
       </a>
       </div></div>";
    }
    $temp=$pid;
  }
  print "</div></div>";


?>
   </body>
</html>
