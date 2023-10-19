<?php
// Database connection
$host = "localhost";
$username = "root";
$password = "";
$database = "cake bakery"; // Use underscores for the database name to avoid potential issues
$conn = mysqli_connect($host, $username, $password, $database);

if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

// Retrieve order details from form
$name = $_POST['name'];
$email = $_POST['email'];
$contact = $_POST['contact'];
$cake = $_POST['cake'];
$size = $_POST['size'];


// Retrieve price of the selected cake from the database (assuming a "cakes" table)
$cakePriceQuery = "SELECT price FROM cakes WHERE name = '$cake'";
$cakePriceResult = mysqli_query($conn, $cakePriceQuery);

if ($cakePriceResult) {
  $cakePriceRow = mysqli_fetch_assoc($cakePriceResult);
  $cakePrice = $cakePriceRow['price'];

  // Calculate the amount based on the cake size and price
  $amount = 0;
  if ($size == "Small") {
    $amount = $cakePrice;
  } elseif ($size == "Medium") {
    $amount = $cakePrice + 500;
  } elseif ($size == "Large") {
    $amount = $cakePrice + 1000;
  }

  // Insert order into the database
  $sql = "INSERT INTO orders (name, email, contact, cake, size, amount) VALUES ('$name', '$email', '$contact', '$cake', '$size', $amount)";

  if (mysqli_query($conn, $sql)) {
    echo "Order placed successfully!<br>";
    echo "Name: $name<br>";
    echo "Email: $email<br>";
    echo "Contact: $contact<br>";
    echo "Cake: $cake<br>";
    echo "Size: $size<br>";
    echo "Amount: $amount<br>";
  } else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
  }
} else {
  echo "Error in fetching cake price: " . mysqli_error($conn);
}

mysqli_close($conn);
?>
