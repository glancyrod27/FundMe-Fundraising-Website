<?php session_start();
if (! empty($_SESSION['logged_in']))
{
?>
<?php
$con=mysqli_connect("localhost", "root","","Fund_Raising") or die(mysqli_connect_error());  
$username=$_SESSION['username'] ;
$query = "select city,state,zipcode from users where username='$username'";
$result=mysqli_query($con,$query); 
    while($row = mysqli_fetch_array($result,MYSQLI_ASSOC)) 
    {
      $table_city = $row['city']; 
      $table_state = $row['state']; 
      $table_zipcode = $row['zipcode'];
    }
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



          <div class="container"; style="max-width: 1000px">
          <form class="form-horizontal" action="update_profile.php" method="POST">
          <fieldset>
          <div class="col-sm-offset-2 col-sm-10">
            <legend>Enter Your Details: </legend>
            <p style="font-size: 13px"> (Current Values are Dispalyed)</p>
           </div> 
            <div class="form-group">
               <label class="control-label col-sm-2" for="city">City:</label>
               <div class="col-sm-10">
                <input type="text" class="form-control" name="city" type="text" value="<?php echo $table_city; ?>">
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-sm-2" for="pwd">State:</label>
              <div class="col-sm-10">          
              <input type="text" class="form-control" name="state" type="text" value="<?php echo $table_state; ?>">
            </div>
            </div>
             <div class="form-group">
              <label class="control-label col-sm-2" for="pwd">Pincode:</label>
              <div class="col-sm-10">          
              <input type="text" class="form-control" name="pincode" type="number" value="<?php echo $table_zipcode;?>">
            </div>
            </div>
           <label class="control-label col-sm-2" for="tags">Select Tags: </label>
          <div class="checkbox" >

          <label>
             <table border=0 width=40%>
               <tr>
               <td><input  type="checkbox" style="position:absolute; left:19.5%"; name="intrst[]" value="Arts">&nbsp;&nbsp;Arts</td>
               <td><input  type="checkbox" style="position:absolute; left:27%"; name="intrst[]" value="Dance">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Dance</td>
               <td><input  type="checkbox" style="position:absolute; left:35%"; name="intrst[]" value="Fashion">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Fashion</td>
               <td><input  type="checkbox" style="position:absolute; left:46%"; name="intrst[]" value="Food">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Food</td>
               </tr>
               <tr>
               <td><input  type="checkbox" style="position:absolute; left:19.5%"; name="intrst[]" value="Games">&nbsp;&nbsp;Games</td>
               <td><input  type="checkbox" style="position:absolute; left:27%"; name="intrst[]" value="Music">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Music</td>
               <td><input  type="checkbox" style="position:absolute; left:35%"; name="intrst[]" value="Technology">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Technology</td>
               <td><input  type="checkbox" style="position:absolute; left:46%"; name="intrst[]" value="Film">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Film</td>
               </tr>
               </table></br>
               </label>
               </div>
            <div class="form-group">
              <div class="col-sm-offset-2 col-sm-10">
                <button type="reset" class="btn btn-default">Cancel</button>&nbsp;&nbsp;&nbsp;
                <button type="submit" class="btn btn-primary">Update Profile!</button>
              </div>
            </div>
            
          </fieldset>
        </form>
        </div>


   

<?php
if($_SERVER["REQUEST_METHOD"]=="POST")
{
	$con=mysqli_connect("localhost", "root","","Fund_Raising") or die(mysqli_connect_error());	

		$city=mysqli_real_escape_string($con,$_POST['city']);
		$state=mysqli_real_escape_string($con,$_POST['state']);
		$pincode=mysqli_real_escape_string($con,$_POST['pincode']);
    if (preg_match("/[\'^£$%&*()}{@#~?><>,|=_+¬]/", $city))
    {
      Print '<script>alert("Please enter Characters Only");</script>'; 
        exit;
    }
    if (preg_match("/[\'^£$%&*()}{@#~?><>,|=_+¬-]/", $state))
    {
      Print '<script>alert("Please enter Characters or Only");</script>'; 
        exit;
    }
    if (preg_match("/[\'^£$%&*()}{@#~?><>,|=_+¬-]/", $pincode))
    {
      Print '<script>alert("Please enter Characters or Numbers only");</script>'; 
        exit;
    }


    if(strlen($pincode)!=5)
    {
      Print '<script>alert("Pincode Must Be 5 digits!");</script>'; 
      exit;
    }
    else
    {
		$query = "update users set city='$city', state='$state', zipcode='$pincode' where username='$username'";
		mysqli_query($con,$query); 
    if(!empty($_POST['intrst']))
      {
        foreach ($_POST['intrst'] as $check) 
        {
          $query = "insert into interest values ('$username','$check')";
          mysqli_query($con,$query); 
        }
      }

		Print '<script>alert("Successfully Updated your profile!");</script>'; 
		//Print '<script>window.location.assign("first_page.php");</script>'; 
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