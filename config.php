<?php
	// connection
	$host = 'localhost';
	$username = 'root';
	$password = '';
	$database = 'testing';

	$shobhit = mysqli_connect($host,$username,$password);

	if (!$shobhit)
	{
		echo "Can't connect with server";
		exit();
	}

	if(!mysqli_select_db($shobhit, $database))
	{
		echo "Can't Find database";
		exit();
	}
?>