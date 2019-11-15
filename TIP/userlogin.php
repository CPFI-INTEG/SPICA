<?php
   
   
   if(session_status() != PHP_SESSION_ACTIVE) {
       session_start();
   }
   require_once('model/LibDAO.php');
   require_once('model/LibHandler.php');

   require_once "simplesaml/www/_include.php";

   $as = new SimpleSAML_Auth_Simple("default-sp");
   
   $as->requireAuth();

   $attributes = $as->getAttributes();
   
   $session = SimpleSAML_Session::getSessionFromRequest();
   
   //var_dump($session);
   $session->cleanup();

   $session->doLogout("default-sp");

   str_replace("'", "''", str_replace("`", "'", $code));

   $userName = trim(str_replace("@centurypacific.com.ph", "", str_replace("'", "''", str_replace("`", "'", $attributes["http://schemas.xmlsoap.org/ws/2005/05/identity/claims/name"][0]))));
echo $userName;
   
   //FOR HANDLE LOGIN
   //$Handler= new libHandler();
   //$result = $Handler->loginAuthenticator($Username);
   

   // SAVE TO AUDIT TRAIL
   include("model/dbcon.php");
   $sql="exec [sp_Display_updated] '".$userName."'";
   //ECHO $sql;
   $stmt=sqlsrv_query($con,$sql);                     

   if ($stmt) {
      $rows = sqlsrv_has_rows($stmt);
      if($rows!=true){
            session_unset();
            session_destroy();
            $logOutURL = $as->getLogoutURL();
            header("Location: " . $logOutURL);
            exit;
         return false;
      } 
      else{
         $Result=sqlsrv_fetch_array($stmt,SQLSRV_FETCH_ASSOC);
         $_SESSION=$Result;
         //var_dump($Result);
         sqlsrv_free_stmt($stmt);
         error_log("Successfully retrieve");
         

         //to insert in audit trail
         $SqlAudit="insert into tip.Audittrail(Description,Usertype,NameofUser) values('Successfully UAT Login : ".$Username."  ,'".$UserType."','".$Username."')";
         $stmtAudit=sqlsrv_prepare($con,$SqlAudit);
         sqlsrv_execute($stmtAudit);
         sqlsrv_free_stmt($stmtAudit);


         header("Location: index.php");
         return true;
      }  
   }





?>
