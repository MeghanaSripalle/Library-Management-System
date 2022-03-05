<?php
session_start();
$adminusername = $_SESSION['adminusername'];
$adminpassword = $_SESSION['adminpassword'];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Welcome to the Admin Home Page</title>
    <link rel="stylesheet" href="viewstudent.css">
</head>

<body>

    <div class="container">
        <div class="welcome"><h1 style="font-size:50px;">WELCOME TO THE HOME PAGE</h1></div>
        <div class="line"><h1 style="font-size:20px;">the portal to unlimited knowledge</h1></div>
    </div>
    <div style="height: 30px;"></div>
    <div class="topnav">
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
            <button type="submit" name="search" id="search">Search</button>
            </form>
        </ul>
         
    </nav>
    <br><br>
    </div>
    <form method="post" action="fineadmin.php">
    <input type="submit" value="View Fines" name="view" style="background-color:rgb(66, 43, 22);color:white" >
</form>
<br><br>
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

if(isset($_POST['view'])) 
{
    $query = "UPDATE Orders SET Fine = DATEDIFF(CURDATE(),Duedate)*30 WHERE CURDATE()>Duedate";
    $conn->query($query);


    $viewquery = "SELECT * FROM Orders WHERE Fine > 0";
    $resultsview = $conn->query($viewquery);
    if ($resultsview->num_rows > 0) {
        echo "<table class='books'><tr><th>Student Id</th><th>Title</th><th>Author</th><th>Publisher</th><th>Genre</th><th>Duedate</th><th>Fine</th></tr>";
        while($row = $resultsview->fetch_assoc()) {
          echo "<tr><td>".$row["Customer"]."</td><td>".$row["Title"]."</td><td>".$row["Author"]."</td><td>".$row["Publisher"]."</td><td>".$row["Genre"]."</td><td>".$row["Duedate"]."</td><td>".$row["Fine"]."</td><tr>";
        }
        echo "</table>";
      }

}


$conn->close(); 

?>