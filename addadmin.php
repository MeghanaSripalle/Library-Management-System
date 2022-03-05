<?php
session_start();
$adminusername = $_SESSION['adminusername'];
$adminpassword = $_SESSION['adminpassword'];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add New Books Page</title>
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
            <button type="submit" name="search" id="search">Search</button>
            </form>
        </ul>
         
    </nav>
    </div>
    <div>
    <h3>Add New Books to the Inventory</h3>
    <div style="color:rgb(148, 108, 85);">Enter the details of the book you wish to add to the inventory:<br><br></div>
<!-- <script>
function big(x) {
  x.style.height = "50px";
  x.style.width = "100px";
}

function normal(x) {
  x.style.height = "30px";
  x.style.width = "100px";
}
</script> -->
    <form method="post" action="addadmin.php">
        Title: <input type="text" name="booktitle" id="booktitle" class=details ><br><br>
        Quantity: <input type="number" name="bookquantity" id="bookquantity" min=1 max=1000 class=details><br><br>
        Author: <input type="text" name="bookauthor" id="bookauthor" class=details><br><br>
        Publisher: <input type="text" name="bookpublisher" id="bookpublisher" class=details><br><br>
        Genre: <input type="text" name="bookgenre" id="bookgenre" class=details><br><br>
        <input type="submit" value="Add Book" name="add" class="doom" id="add" style="color:white;background-color:rgb(71, 45, 15)">
    </form>
    <h3>Update quantity of pre-existing books<h3>
    <form method="post" action="addadmin.php">
        Title: <input type="text" name="booktitl" id="booktitl" class=details ><br><br>
        Quantity: <input type="number" name="bookquantit" id="bookquantit" min=1 max=1000 class=details><br><br>
        <input type="submit" value="Update Quantity" name="update" class="doom" id="update" style="color:white;background-color:rgb(71, 45, 15)">
    </form>
    
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
if(isset($_POST['update']))
{
    $title = ucfirst($_POST['booktitl']);
    $quantity = $_POST['bookquantit'];
    if(is_string($title) && strlen($title)<=120 && strlen($title)>0)
    {
        $newvar = "UPDATE Books SET Quantity = $quantity WHERE Title = '$title'";
        $conn->query($newvar);
        $select = "SELECT Title,Quantity FROM Books WHERE Title ='$title'";
        $resultsvie = $conn->query($select);
        if ($resultsvie->num_rows > 0) {
            echo "<table class='books' ><tr><th>Title</th><th>Quantity</th></tr>";
            while($row = $resultsvie->fetch_assoc()) {
              echo "<tr><td>".strtolower($row["Title"])."</td><td>".$row["Quantity"]."</td></tr>";
            }
            echo "</table>";
          } else {
            echo "<script>alert('Book not existing.');</script>";
          }
    }

}

if(isset($_POST['add'])){
    $title = ucfirst($_POST['booktitle']);
    $quantity = $_POST['bookquantity'];
    $author= $_POST['bookauthor'];
    $publisher = $_POST['bookpublisher'];
    $genre = $_POST['bookgenre'];

    if(is_string($author) && strlen($author)<=120 && strlen($author)>0 && is_string($publisher) && strlen($publisher)>0 && strlen($publisher)<=120 
    && is_string($title) && strlen($title)<=120 && strlen($title)>0 && is_string($genre) && strlen($genre)<=50 && strlen($genre)>0)
    {
     $search = "SELECT * FROM Books WHERE Title='$title'";
    if($conn->query($search)->num_rows>0){
        echo "<script>alert('Book is already in the inventory.');</script>";
    }else{
     $query = "INSERT INTO Books (Title,Quantity,Author,Publisher,Genre)
     VALUES ('$title', $quantity,'$author','$publisher','$genre')";
 
        if ($conn->query($query) === TRUE) {
           echo "<script>alert('New book added successfully!');</script>";
     }
    }
    }
    else{
       echo"<script>alert('There is a data type mismatch or some details haven't been filled.');</script>";
    }
}
$conn->close();


?>