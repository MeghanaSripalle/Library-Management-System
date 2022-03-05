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
    <nav class="menu">
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
    <h3>VIEW ALL ORDERS MADE BY STUDENTS</h3>
    <div>
    <form method="post" action="orderadmin.php" >
        <input type="submit" value="View Orders" name="view" style="background-color:rgb(66, 43, 22)" >
    </form>
    <br>
    <br><h3>Returning a book</h3>
    <div>
    <form method="post" action="orderadmin.php" >
        STUDENT ID: <input type="text" name="user_id" style="background-color:rgb(66, 43, 22)" ><br><br>
        BOOK TITLE: <input type="text" name="book_title" style="background-color:rgb(66, 43, 22)" ><br><br>
        <input type="submit" value="Return" name="return" style="background-color:rgb(66, 43, 22)" ><br><Br>
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
if(isset($_POST['return']))
{
    $id = $_POST['user_id'];
    $titl = $_POST['book_title'];
    $resu1 = "SELECT * FROM Orders WHERE Title = '$titl' AND Customer = '$id'";
    $resu = $conn->query($resu1);
    $query4 = "DELETE FROM Orders WHERE Title = '$titl' AND Customer = '$id'";
    $conn->query($query4);
    if($resu->num_rows==1){
    echo "<script>alert('Returned');</script>";
    $quer = "UPDATE Books SET Quantity = Quantity+1 WHERE Title = '$titl'";
    $conn->query($quer);
    }   
    else if ($resu->num_rows>1)
    {
        echo "<script>alert('User borrowed more than one copy of the same Book!');</script>";
    }
    else
    {
        echo "<script>alert('No such book borrowed by the student!');</script>";
    }
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
if(isset($_POST['view'])){

    $viewquery = "SELECT * FROM Orders";
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