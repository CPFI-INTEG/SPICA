
<?php
   include("model/dbcon.php");
   if(session_status() != PHP_SESSION_ACTIVE) {
       session_start();
   }

   require_once "simplesaml/www/_include.php";

   $as = new SimpleSAML_Auth_Simple("default-sp");
   
   $as->requireAuth();

   $attributes = $as->getAttributes();

   $logOutURL = $as->getLogoutURL();

   $session = SimpleSAML_Session::getSessionFromRequest();

   $session->cleanup();

   $session->doLogout("default-sp");

   $userName = trim(str_replace("@centurypacific.com.ph", "", str_replace("'", "''", $attributes["http://schemas.xmlsoap.org/ws/2005/05/identity/claims/name"][0])));

   $nameofuser = $_SESSION['Name'];    
   $strDesc='Logout ' . $nameofuser;
    
   $usertype_Desc = $_SESSION['UserType'];
   $sqlAudit="insert into tip.AuditTrail(Description,Usertype,NameofUser) values('" . $strDesc . "','" . $usertype_Desc . "','" . $nameofuser . "')";

   $stmt=sqlsrv_prepare($con,$sqlAudit);
   sqlsrv_execute($stmt);
   sqlsrv_free_stmt($stmt);


   session_unset();
   session_destroy();
   header("Location: " . $logOutURL);
   exit;
?>