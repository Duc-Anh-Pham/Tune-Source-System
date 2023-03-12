<?php
// Phần thông tin kết nối dữ liệu giữa mysql workbench
    $dsn = "mysql:host=localhost; dbname=msw";
	$username = "root";
	$password = "";
	try{
		$conn = new PDO($dsn, $username, $password);
		$conn->setAttribute(PDO::ATTR_PERSISTENT, true);
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);            
	}catch(PDOException $ex) {
		echo "Connection error: " . $ex->getMessage();	
	}
?>
