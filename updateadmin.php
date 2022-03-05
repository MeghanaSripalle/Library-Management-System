<?php
session_start();
 #echo "<script>alert('Welcome User ".$_SESSION['userid']."!');</script>"; 
 $adminusername = $_SESSION['adminusername'];
 $adminpassword = $_SESSION['adminpassword'];
?>

<!DOCTYPE html>
<html>
<head>
    <title>View Books</title>
    <link rel="stylesheet" href="viewstudent.css">
    
</head>
<body>
    <div class="container">
        <div class="welcome"><h1 style="font-size:50px;">IIT DHARWAD LIBRARY SYSTEM</h1></div>
        <div class="line"><h1 style="font-size:20px;">the portal to unlimited knowledge</h1></div>
    </div>
    <div style="height: 30px;"></div>
    <div>
    <nav class="menu">
    <ul >
        <li><a href="homeadmin.php">Home</a></li>
        <li> <a href="orderadmin.php">View Orders</a></li>
        <li> <a href="fineadmin.php">View Fine</a></li>
        <li> <a href="viewadmin.php">View</a></li>
        <li> <a href="updateadmin.php">Update</a></li>
        <!-- <li class="menubar"> <a href="searchadmin.php">Search</a></li> -->
        <li> <a href="main.php">Logout</a></li>
        <form method="post" action="homeadmin.php" class="search-form">
                <input type="text" id="searc" placeholder="Search" name="searc">
            <button type="submit" id="search" name="search">Search</button>
            </form>
        </ul>
         
    </nav>
    </div>
    <div class="cen">
    <h1 style="color:rgb(99, 65, 55)"><u>Update Books</u></h1>
    <form method="post" action="addadmin.php" >
        <input type="submit" value="ADD BOOKS" name="view" style="color:white;background-color:rgb(71, 45, 15)" >
    </form>
    <br><br>
    <form method="post" action="deleteadmin.php" >
        <input type="submit" value="DELETE BOOKS" name="view" style="color:white;background-color:rgb(71, 45, 15)" >
    </form>
    <br>
    <br>
    <h1 style="color:rgb(99, 65, 55)"><u>Update Student Details</u></h1>
    <form method="post" action="addstudent.php" >
        <input type="submit" value="ADD STUDENT" name="view" style="color:white;background-color:rgb(71, 45, 15)" >
    </form>
    <br><br>
    <form method="post" action="delstudent.php" >
        <input type="submit" value="DELETE STUDENT" name="view" style="color:white;background-color:rgb(71, 45, 15)" >
    </form>
    <br>
    <br>
</div>
</body>
</html>
<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "Library";

$conn = new mysqli($servername, $username, $password,$dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
 if(isset($_POST['search'])){
     if($_POST['searc']) {
    $book = $_POST["searc"];
    $viewquery = "SELECT Title,Author,Publisher,Genre FROM Books WHERE Quantity > 0 AND Title LIKE '$book%'";
    $resultsview = $conn->query($viewquery);
    if ($resultsview->num_rows > 0) {
        echo "<table class='books'><tr><th>Title</th><th>Author</th><th>Publisher</th><th>Genre</th></tr>";
        while($row = $resultsview->fetch_assoc()) {
          echo "<tr><td>".strtolower($row["Title"])."</td><td>".$row["Author"]."</td><td>".$row["Publisher"]."</td><td>".$row["Genre"]."</td><tr>";
        }
        echo "</table>";
      } else {
        echo "<script>alert('No book is available currently.');</script>";
      }
    }
}
$conn->close(); 

?>