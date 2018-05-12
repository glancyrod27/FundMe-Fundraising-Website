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
    $username=$_SESSION['username'] ;
    $pid=$_SESSION['proj_id'];?>

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

      <div class="container"; style="max-width: 700px">
      <form class="form-horizontal" action="Pledge.php" method="POST">
      <fieldset>
      <div class="col-sm-offset-2 col-sm-10"></br>
      <legend>Make a Pledge</legend>
      </div>
      <div class="form-group">
         <label class="control-label col-sm-2">Enter_Amount:</label>
          <div class="col-sm-10">
            <input type="number" class="form-control" id="amount" placeholder="Amount" name="amount" value="amount" required>
          </div>
      </div></br>
      <div class="form-group">
      <label class="col-sm-2 control-label">Select Credit Card:</label>
      <div class="col-lg-10">
  <?php

            $query = "select ccn from credit_card where username='$username'";
            $result=mysqli_query($con,$query); 
            while($row = mysqli_fetch_array($result,MYSQLI_ASSOC)) 
            {
                $ccn= $row['ccn'];
                print "<div class='radio'>
                    <label>
                    <input type='radio' name='ccn' id='ccn' value='".$ccn."' required>".$ccn."</label>
                    </div>";
              }
?>
        </div>
        </div></br>
  

        <div class="form-group">
              <div class="col-sm-offset-2 col-sm-10">
                <button type="reset" class="btn btn-default">Cancel</button>&nbsp;&nbsp;&nbsp;
                <button type="submit" class="btn btn-primary">Submit!</button>
              </div>
            </div>




      

        </fieldset>
        </form>
        </div>


<?php
         if($_SERVER["REQUEST_METHOD"]=="POST")
      { 

              $amount=mysqli_real_escape_string($con,$_POST['amount']);
              $ccn=mysqli_real_escape_string($con,$_POST['ccn']);
            
              if($amount<=0)
              {
                Print '<script>alert("Funding amount must be greater than zero!");</script>'; 
                exit;
              }
              $query1= "select sum(pledged_amount) as fund from pledge where pid=$pid";
              $result1=mysqli_query($con,$query1); 
              while($row1 = mysqli_fetch_array($result1,MYSQLI_ASSOC)) 
              {
                $fund=$row1['fund'];
              }
              $query1= "select maxfund from projects where pid=$pid";
              $result1=mysqli_query($con,$query1); 
              while($row1 = mysqli_fetch_array($result1,MYSQLI_ASSOC)) 
              {
                $maxfund=$row1['maxfund'];
              }
              if(($fund+$amount) > $maxfund)
              {
                $charged_amount=$maxfund-$fund;
                $query1= "insert into pledge values ($pid,'$username',$ccn,default,$charged_amount,current_timestamp,$charged_amount,default)";
                mysqli_query($con,$query1);
               
                $query1 = "update projects set pstatus='EXECUTION', modification_time=current_timestamp where pid='$pid'";
                mysqli_query($con,$query1);
              
                $query1 = "update pledge set charged_amount=pledged_amount, c_time=current_timestamp where pid='$pid'";
                mysqli_query($con,$query1);
             
                Print '<script>alert("You will be charged only $' .$charged_amount. ' as maximum fund amount reached!");</script>';
               
                Print '<script>window.location.assign("first_page.php");</script>';  
              }
              else
              {
                $charged_amount=$amount;
                print '<script>alert("You have pledged $'.$charged_amount.' !");</script>';
                $query1= "insert into pledge values ($pid,'$username','$ccn',default,'$charged_amount',default,default,default)";
              
                mysqli_query($con,$query1); 
           
                Print '<script>window.location.assign("first_page.php");</script>'; 
              }
              

              
        
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