<?php 
	include("model/dbcon.php");
	if(session_status() != PHP_SESSION_ACTIVE) {
	    session_start();
	}

 	$nameofuser = $_SESSION['Name'];    
    $strDesc='Logout in ' . $nameofuser;
    
	$usertype_Desc = $_SESSION['UserType'];
	$sqlAudit="insert into tip.AuditTrail(Description,Usertype,NameofUser) values('" . $strDesc . "','" . $usertype_Desc . "','" . $nameofuser . "')";

	$stmt=sqlsrv_prepare($con,$sqlAudit);
	sqlsrv_execute($stmt);
	sqlsrv_free_stmt($stmt);
	
	
	session_destroy();
	header("location:login.php");

	
 ?>