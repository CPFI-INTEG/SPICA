<!DOCTYPE html>
<html>
<head>
  <link rel="shortcut icon" type="image/png" href="images/CPG Logo.png"/>
        <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>TRADE INVESTMENT</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="plugins/iCheck/flat/blue.css">
  <!-- Morris chart -->
  <link rel="stylesheet" href="plugins/morris/morris.css">
  <!-- jvectormap -->
  <link rel="stylesheet" href="plugins/jvectormap/jquery-jvectormap-1.2.2.css">
  <!-- Date Picker -->
  <link rel="stylesheet" href="plugins/datepicker/datepicker3.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="plugins/daterangepicker/daterangepicker.css">
  <!-- bootstrap wysihtml5 - text editor -->
  <link rel="stylesheet" href="plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
  <link rel="stylesheet" href="plugins/datatables/dataTables.bootstrap.css">
   <link rel="stylesheet" href="plugins/iCheck/all.css">
   <link rel="stylesheet" href="plugins/select2/select2.min.css">
      
</head>
<body class="hold-transition lockscreen">
<!-- Automatic element centering -->

<div class="lockscreen-logo"><BR><BR><BR><BR>
    <h1><b>SPICA </b> IS TEMPORARILY OFFLINE</h1>
</div>
<?php
   include("model/dbcon.php");
 $sqlData="select top 1 * from TIP.Setting "; 
 // echo $sqlData;
  $stmt=sqlsrv_query($con,$sqlData);  
 


                        $strDisplay="";
                         while($row=sqlsrv_fetch_array($stmt,SQLSRV_FETCH_ASSOC)){
                            $strDisplay.=$row[Message];
                           
                          }?>
<center>
  <div class="error-content">
    <h5><i class="fa fa-warning text-yellow"></i> <?php echo $strDisplay;?></h5>
  </div>
 <!--Messege-->
  
  <div class="lockscreen-footer text-center">
    <BR><BR><BR><BR>
    Copyright &copy; 2018 <b>Century Pacific Food, Inc.</b><br>
    All rights reserved
  </div>
</center>
<!-- /.center -->

<!-- jQuery 2.2.3 -->
<script src="plugins/jQuery/jquery-2.2.3.min.js"></script>
<!-- Bootstrap 3.3.6 -->
<script src="bootstrap/js/bootstrap.min.js"></script>
</body>
</html>
