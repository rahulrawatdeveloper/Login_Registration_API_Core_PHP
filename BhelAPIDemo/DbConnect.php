<?php

//these are the server details
//the username is root by default.
//password is nothing by default.
// and lastly we have the database name.

$servername = "localhost";
$username = "root";
$password = "";
$database = "bhelapidemo";

//creating a new connection object using mysqli_affected_rows
$conn = new mysqli($servername, $username, $password, $database);

//if there is some error connecting to the database
//with die we will stop the further exeduction by displaying a messsage.
if($conn->connect_error){
	die("connection failed: ".$conn->connect_error);
}


?>