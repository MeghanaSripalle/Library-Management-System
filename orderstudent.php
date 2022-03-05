<?php
session_start();
 #echo "<script>alert('Welcome User ".$_SESSION['userid']."!');</script>"; 
 $userid = $_SESSION['userid'];
 $userpassword = $_SESSION['password'];

/*$servername = "localhost";
$username = "root";
$password = "";
$dbname = "Library";
$conn = new mysqli($servername, $username, $password,$dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$queryuser = "CREATE TABLE '$userid'(
  OrderId int(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  Title varchar(120) UNIQUE,
  Author varchar(120) NOT NULL,
  Publisher varchar(120) NOT NULL,
  Genre varchar(50)  

)";
$conn->query($queryuser);
$conn->close();*/
 
?>

<!DOCTYPE html>
<html>
<head>
    <title>Place Order for Books</title>
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
        <li ><a href="homestudent.php">Home</a></li>
        <li ><a href="orderstudent.php">Order</a></li>
        <li ><a href="finestudent.php">Fine</a></li>
        <li ><a href="viewstudent.php">View</a></li>
        <li ><a href="main.php">Logout</a></li>
        <!-- <li class="menubar"> <a href="searchstudent.php">Search</a></li> -->
        <!-- <div class="search-container"> -->
            <form method="post" action="homestudent.php" class="search-form">
                <input type="text" placeholder="Search" name="searc" id="searc">
                <button type="submit" id="search" name="search">Search</button>
            </form>
        <!-- </div> -->
        </ul>
         
    </nav>
    </div>
    <h3>Place Order for Books</h3>
    <div style="color:rgb(148, 108, 85);">Please enter the title of the book you would like to order here:</div><br>
    <form method="post" action="orderstudent.php">
        <input type="text" name="title" id="title" style="background-color:rgb(66, 43, 22);" class=details><br><br>
        <input type="submit" value="Place an order" name="order" style="background-color:rgb(66, 43, 22);" >
    </form>
    <br>
    <br>
    <form method="post" action="orderstudent.php">
        <input type="submit" value="View the orders" name="vieworder" style="background-color:rgb(66, 43, 22);" >
    </form>
    <br>
    <br>
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
 if(isset($_POST['order'])){
     $title = $_POST['title'];
     $query = "SELECT * FROM Books WHERE Title='$title' AND Quantity>0";
        $result1 = $conn->query($query);
        if($result1->num_rows==0){
           echo "<script>alert('The book is not available or you have entered the wrong title.');</script>";
           
        }else{
     $queryorder = " INSERT INTO Orders (Title,Author,Publisher,Genre) SELECT Title,Author,Publisher,Genre FROM Books WHERE Title='$title'";
     $conn->query($queryorder);
     $order1 = $conn->insert_id;
    $order2 = "UPDATE Orders SET Customer = '$userid',Duedate = ADDDATE(CURDATE(), INTERVAL 7 DAY),Fine = 0 WHERE Title='$title'AND BookId = $order1 ";
    $conn->query($order2);
    $quer = "UPDATE Books SET Quantity = Quantity-1 WHERE Title = '$title'";
    $conn->query($quer);
    echo "<script>alert('Your order has been placed successfully!');</script>";
    }
 }

 if(isset($_POST['vieworder'])){

    $viewquery = "SELECT Title,Author,Publisher,Genre,Duedate FROM Orders WHERE Customer='$userid'";
    $resultsview = $conn->query($viewquery);
    if ($resultsview->num_rows > 0) {
        echo "<table class='books'><tr><th>Title</th><th>Author</th><th>Publisher</th><th>Genre</th><th>Duedate</th></tr>";
        while($row = $resultsview->fetch_assoc()) {
          echo "<tr><td>".$row["Title"]."</td><td>".$row["Author"]."</td><td>".$row["Publisher"]."</td><td>".$row["Genre"]."</td><td>".$row["Duedate"]."</td><tr>";
        }
        echo "</table>";
      }

 }

$conn->close();
?>