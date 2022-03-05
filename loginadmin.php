<!DOCTYPE html>
<html>
<head>
    <title>Admin Login Page</title>
    <link rel="stylesheet" href="loginadmin.css">
    
</head>

<body>
<button style="background-color: rgb(107, 80, 45);color: rgb(77, 45, 22);font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS',sans-serif"><a href="main.php">Back</a></button>
    <div class="container">
        <h1 style="text-align: center;color: antiquewhite;text-indent: 20px;background-color: rgb(77, 45, 22);width: 100%;">Administration Login</h1>
        <div class="container1">
    <form method="post" action="loginadmin.php">
        <div class="vertical-center">Username : <input type="text" name="userad" id="userad" ><span>*</span><br><br></div>
       <div class="vertical-center1">Password : <input type="password" name="passad" id="passad" ><span>*</span><br><br></div>
       <div class="vertical-center2"><input style="color: rgb(77, 45, 22);font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif;background-color:rgb(172, 145, 126) ;"type="submit" value="Login" name="submitadmin" id="submitadmin"></div>
    </form>
    </div>
    </div>
</body>
</html>

<?php
session_start();
     $usernameerror = $passworderror = "";
     $username = $password = "";
  
  function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "Library";

$conn = new mysqli($servername, $username,$password,$dbname);
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

if(isset($_POST['submitadmin'])){

    if((($_POST["userad"]) && ($_POST["passad"])))
    {
      $username = test_input($_POST["userad"]);
      $password = test_input($_POST["passad"]);
      $query2= "SELECT * FROM Admins WHERE Username ='" . $username . "' and Pass = '". $password . "'";
      $result2 = $conn->query($query2);
      if($result2->num_rows==0) 
      {
        echo "<script>alert('Username or Password is wrong. Please enter again.');</script>";
      } 
      else 
      {
        $_SESSION['adminusername'] = $username;
        $_SESSION['adminpassword'] = $password;
        echo "<script>alert('Welcome ".$_SESSION['adminusername']."!');</script>"; 
        header('Location: homeadmin.php');
      }
    }
    else 
    {
      echo "<script>alert('Enter both the fields provided');</script>";
    }

}

$conn->close();
?>