<?php

	$DB_HOST = 'localhost';
	$DB_USER = 'i2319610_wp1';
	$DB_PASS = 'O.PlR9ArLwZOdliBrMS01';
	$DB_NAME = 'crud_2';
	
	try{
		$DB_con = new PDO("mysql:host={$DB_HOST};dbname={$DB_NAME}",$DB_USER,$DB_PASS);
		$DB_con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	}
	catch(PDOException $e){
		echo $e->getMessage();
	}
	
