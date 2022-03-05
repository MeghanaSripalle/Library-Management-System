<?php
session_start();
$adminusername = $_SESSION['adminusername'];
$adminpassword = $_SESSION['adminpassword'];
?>
<!DOCTYPE html>
<html>
<head>
    <title>Delete an existing book</title>
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
    <div>
    <h3>Delete an existing book</h3>
    <div style="color:rgb(148, 108, 85);">Enter the title of the books you want to delete from the inventory:<br><br></div>
<script>
function big(x) {
  x.style.height = "50px";
  x.style.width = "100px";
}

function normal(x) {
  x.style.height = "30px";
  x.style.width = "70px";
}
</script>
    <form method="post" action="deleteadmin.php">
        Title: <input type="text" name="booktitle" id="booktitle" class=details ><br><br>
        <input type="submit" value="Delete" name="delete" id="delete" onmouseover="big(this)" onmouseout="normal(this)"  ><br><br>
    </form>
    
</div>
<div>
    <img src="book1.png" style="width:300px;height:200px;border:2px solid rgb(148, 108, 85); " ></div>
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
if(isset($_POST['delete'])){
    $title = $_POST['booktitle'];
    if ($title) {
        $sql = "SELECT Title 
        from Books 
        where Title = '$title'";
        $result  = $conn->query($sql);
         if($result->num_rows !=0){
            $sql = "DELETE FROM Books WHERE Title='$title'";
            if (mysqli_query($conn, $sql))
            echo "Books deleted successfully";
            else
            echo "Error deleting Book: " . mysqli_error($conn);
    }else echo "
    
    NO SUCH BOOK FOUND";
    } else
        echo "The Title block should not be blank!";
}

$conn->close();


?>