<?php session_start();
if (!empty($_SESSION['logged_in']))
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




       <div class='container'; style='position:absolute; left:10px'>
       <h4><b>Your Credit Cards: </b></h4></br>
       <?php        
       $query = "select ccn from credit_card where username='$username'";
       $result=mysqli_query($con,$query); 
       print "<table class='table table-striped table-hover' style='width:55%'>";
  
    while($row = mysqli_fetch_array($result,MYSQLI_ASSOC)) 
    {
        $ccn= $row['ccn'];


        print "<tr>";
        print "<td>".$ccn."</td>";
        print "<td>";
        print "<form action=manage_payment.php method=POST>";
        print "<input type=submit class='btn btn-info' value=Remove>";
        print "<input type=hidden name=credit_card_no value='".$ccn."'>";
        print "<input type=hidden name=action_select value='remove'>";
        print "</input>";
        print "</form>";
        print "</td></tr>";
    }
    print "</table>";

?>    </br></br>
      <form class="form-horizontal" action="manage_payment.php" method="POST">
      <fildset>
      <label><h4><b>Enter New Credit Card Number:</b></h4></label></br>
   
      <input type="number" class="form control control-label col-sm-4" name="ccn1" required>
      <input type="hidden" name="action_select" value="add">&nbsp;&nbsp;&nbsp;
  
      <input class='btn btn-info' type="submit" value="Add New"/><br/></br>
      </fildset>
      </form>
      </div>

<?php
if($_SERVER["REQUEST_METHOD"]=="POST")
{
    if($_POST['action_select']=='remove')
    {
        $ccn=$_POST['credit_card_no'];
        $query = "select count(ccn) as counter from credit_card where username='$username'";
        $result=mysqli_query($con,$query); 
        while($row = mysqli_fetch_array($result,MYSQLI_ASSOC)) 
        {
          $counter=$row['counter'];
        }
        if($counter<=1)
        {
          Print '<script>alert("At least one credit card should be present!");</script>'; 
        }
        else
        {
          $query = "select count(pl.ccn) as count from pledge pl natural join (select pid from projects where pstatus='PENDING') as x where pl.username='$username' && ccn = '$ccn'";
          $result=mysqli_query($con,$query); 
          while($row = mysqli_fetch_array($result,MYSQLI_ASSOC)) 
          {
            $count=$row['count'];
          }
          if($count>=1)
          {
            Print '<script>alert("You have pledged with this credit card on a PENDING project so cannot delete!");</script>'; 
            exit;
          }
          else
          {
            $query1 = "delete from credit_card where ccn='$ccn' and username='$username'";
            mysqli_query($con,$query1); 
            Print '<script>alert("Successfully Deleted!");</script>';
            Print '<script>window.location.assign("manage_payment.php");</script>'; 
          }
      }
    }
    else
    {
          $newccn=mysqli_real_escape_string($con,$_POST['ccn1']);
          $query = "select count(*) as count from credit_card where username='$username' and ccn='$newccn'";
          $result=mysqli_query($con,$query); 
          while($row = mysqli_fetch_array($result,MYSQLI_ASSOC)) 
          {
            $count=$row['count'];
          }
          if($count>=1)
          {
            Print '<script>alert("Already Exists!");</script>'; 
            exit;
          }
          else
          {


          if(strlen($newccn)!=16 || $newccn < 1)
          {
            Print '<script>alert("Invalid credit card number!");</script>'; 
            exit;
          }
          else
          {
            $query1="insert into credit_card values('$username','$newccn')";
            mysqli_query($con,$query1); 
            Print '<script>alert("Successfully Inserted!");</script>'; 
            Print '<script>window.location.assign("manage_payment.php");</script>'; 
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
