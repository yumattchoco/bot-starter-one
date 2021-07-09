<?php
	require_once __DIR__ . '/vemdor/autoload.php';

	$inputString = file_get_contents('php://input');
	error_log($inputString);
	
?>