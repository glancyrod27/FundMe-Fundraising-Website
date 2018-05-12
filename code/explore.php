<?php session_start();?>
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
            </nav></br>


            <?php
            $con=mysqli_connect("localhost", "root","","Fund_Raising") or die(mysqli_connect_error());  
          
            $query = "select count(pid) from tags where tags='Technology'";
            $result=mysqli_query($con,$query); 
                while($row = mysqli_fetch_array($result,MYSQLI_ASSOC)) 
                {
                  $tech = $row['count(pid)']; 
                }
                $query = "select count(pid) from tags where tags='Dance'";
            $result=mysqli_query($con,$query); 
                while($row = mysqli_fetch_array($result,MYSQLI_ASSOC)) 
                {
                  $dance = $row['count(pid)']; 
                }
                $query = "select count(pid) from tags where tags='Music'";
            $result=mysqli_query($con,$query); 
                while($row = mysqli_fetch_array($result,MYSQLI_ASSOC)) 
                {
                  $music = $row['count(pid)']; 
                }
                $query = "select count(pid) from tags where tags='Arts'";
            $result=mysqli_query($con,$query); 
                while($row = mysqli_fetch_array($result,MYSQLI_ASSOC)) 
                {
                  $art = $row['count(pid)']; 
                }
                $query = "select count(pid) from tags where tags='Fashion'";
            $result=mysqli_query($con,$query); 
                while($row = mysqli_fetch_array($result,MYSQLI_ASSOC)) 
                {
                  $fashion= $row['count(pid)']; 
                }
                $query = "select count(pid) from tags where tags='Food'";
            $result=mysqli_query($con,$query); 
                while($row = mysqli_fetch_array($result,MYSQLI_ASSOC)) 
                {
                  $food = $row['count(pid)']; 
                }
                $query = "select count(pid) from tags where tags='Film'";
            $result=mysqli_query($con,$query); 
                while($row = mysqli_fetch_array($result,MYSQLI_ASSOC)) 
                {
                  $film = $row['count(pid)']; 
                }
                $query = "select count(pid) from tags where tags='Games'";
            $result=mysqli_query($con,$query); 
                while($row = mysqli_fetch_array($result,MYSQLI_ASSOC)) 
                {
                  $games = $row['count(pid)']; 
                }

            ?>


            <ul class="list-group">
             <li class="list-group-item"><a href="search.php?tag=Fashion"><b style="font-size: 25">Fashion</b> <span class="badge"><?php echo $fashion ?></span></a></li>
              <li class="list-group-item"><a href="search.php?tag=Dance"><b style="font-size: 25">Dance </b><span class="badge"><?php echo $dance ?></span></a></li>
              <li class="list-group-item"><a href="search.php?tag=Arts"><b style="font-size: 25">Arts </b><span class="badge"><?php echo $art ?></span></a></li>
              <li class="list-group-item"><a href="search.php?tag=Music"><b style="font-size: 25">Music </b><span class="badge"><?php echo $music ?></span></a></li>
              <li class="list-group-item"><a href="search.php?tag=Food"><b style="font-size: 25">Food </b><span class="badge"><?php echo $food?></span></a></li>
              <li class="list-group-item"><a href="search.php?tag=Technology"><b style="font-size: 25">Technology </b><span class="badge"><?php echo $tech ?></span></a></li>
              <li class="list-group-item"><a href="search.php?tag=Games"><b style="font-size: 25">Games </b><span class="badge"><?php echo $games ?></span></a></li>
              <li class="list-group-item"><a href="search.php?tag=Film"><b style="font-size: 25">Film </b><span class="badge"><?php echo $film?></span></a></li>
              
            </ul>


           





     </body>
</html>