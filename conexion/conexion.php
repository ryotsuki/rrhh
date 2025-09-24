<?php

function conectate()
{
	$servername = "127.0.0.1";
	$username = "root";
	$password = "Semper2025";
	$database = "rrhh";

	// Create connection
	$conn = new mysqli($servername, $username, $password, $database);

	// Check connection
	if ($conn->connect_error) {
	die("Connection failed: " . $conn->connect_error);
	}
	return $conn;
	//echo "Connected successfully";
}

?>