<?php
// Database connection settings - change these to match your server
$host   = "localhost";
$user   = "root";
$pass   = "";          // change this if your MySQL root has a password
$dbname = "inventory_db";

// Create connection
$conn = mysqli_connect($host, $user, $pass, $dbname);

// Check connection and show a clear error message if it fails
if (!$conn) {
    die("<b>Database connection failed.</b><br>
         Error: " . mysqli_connect_error() . "<br><br>
         <b>Please check:</b><br>
         1. XAMPP/WAMP is running (Apache + MySQL both green)<br>
         2. You imported the database.sql file in phpMyAdmin<br>
         3. The database name is inventory_db<br>
         4. The password in db.php matches your MySQL password");
}
?>
