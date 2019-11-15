    <?php

    if(session_status() != PHP_SESSION_ACTIVE) {
      session_start();
    }




  $parentCode=$_SESSION['BDM_USERNAME']; // THIS IS THE FIELD OF BDM NAME
  $UserType=$_SESSION['UserType']; // THIS IS THE FIELD OF BDM NAME
  $channel=$_SESSION['channel']; // THIS IS THE FIELD OF BDM NAME
  $BusinessUnit=$_SESSION['BU']; // THIS IS THE FIELD OF BDM NAME
  $DBDM_Name=$_SESSION['Name']; 
  $ExactParentCode=$_SESSION['parent_code']; 


  $bpcode="";
  $bpname="";
  $parentcode="";
  $parentname="";
  $channelCode="";
  $ID="";

  // FOR EDIT PURPOSES
  if(isset($_GET['ID'])){
    $HoldID=$_GET['ID'];
    include("model/dbcon.php");
    $sqlEdit="sELECT BUSINESS_PARTNER_SID,BUSINESS_PARTNER_cD,BUSINESS_PARTNER_NAME,PARENT_CD,PARENT_NAME,c_customer_type_Cd,c_customer_type_desc FROM TIP.BUSINESS_PARTNER where BUSINESS_PARTNER_SID=".$HoldID;

    $stmtEdit=sqlsrv_query($con,$sqlEdit);  
    while($row=sqlsrv_fetch_array($stmtEdit,SQLSRV_FETCH_ASSOC)){
      $bpcode=$row['BUSINESS_PARTNER_cD'];
      $bpname=$row['BUSINESS_PARTNER_NAME'];
      $parentcode=$row['PARENT_CD'];
      $parentname=$row['PARENT_NAME'];
      $channelCode=$row['c_customer_type_Cd'];
      $ID=$row['BUSINESS_PARTNER_SID'];
      
    }
  }



?>

<!DOCTYPE html>
<html>
  <head>
      <link rel="shortcut icon" type="image/png" href="images/CPG Logo.png"/>
      <?php include("linkScriptPages.php");?>
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
      
  </head>
<body class="hold-transition skin-blue sidebar-mini" onload="Disabled()">
<div class="wrapper">

  <header class="main-header">
    <!-- Logo -->
    <a class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b>TIR</b></span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b>TIP</b> System</span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>

      <div class="navbar-custom-menu">
          <?php include("HeaderUser.php");?>
      </div>
    </nav>
  </header>
  <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
          <?php include("Sidebar.php");?>
    </section>
    <!-- /.sidebar -->
  </aside>

 <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>BP Tagging Entry</h1>
    </section>

    <!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) -->
        <!-- Left col -->
      <div class="row">

        <div class="col-xs-6">
            <div class="box box-primary">
                
                <!-- form start -->
                <form class="form-horizontal" action='function/UpdateBPTagging.php' method='POST' >
                   <div class="box-body">
                      <div class="col-xs-12">

                                  <input type="hidden"  class="form-control" id="ID" name="ID"   value="<?php echo $ID ?>">
                                  <div class="form-group">
                                    <label for="inputEmail3" class="col-sm-5 control-label">BP Code: </label>

                                    <div class="col-sm-7">
                                      <input type="text"  class="form-control" id="bpcode" name="bpcode"  placeholder="Input BP Code" value="<?php echo $bpcode ?>">
                                    </div>
                                  </div>

                                  <div class="form-group">
                                    <label for="inputEmail3" class="col-sm-5 control-label">BP Name: </label>

                                    <div class="col-sm-7">
                                      <textarea rows=2 class="form-control" id="bpname" name="bpname" placeholder="Input BP Name"><?php echo $bpname ?></textarea>
                                    </div>
                                  </div>

                                 

                                  <div class="form-group">
                                    <label for="inputEmail3" class="col-sm-5 control-label">Parent Code :</label>

                                    <div class="col-sm-7">
                                      <input type="text"  class="form-control" id="parentcode" name="parentcode"  placeholder="Input Parent Code" value="<?php echo $parentcode ?>">
                                    </div>
                                  </div>

                                  <div class="form-group">
                                    <label for="inputEmail3" class="col-sm-5 control-label">Parent Name :</label>

                                    <div class="col-sm-7">
                                      <textarea rows=2 class="form-control" id="parentname" name="parentname" placeholder="Input Parent Name"><?php echo $parentname ?></textarea>
                                    </div>
                                  </div>

                                  <!-- TYPE FIELD -->
                                 <div class="form-group">
                                        <label for="inputPassword3" class="col-sm-5 control-label">Channel : *</label>

                                       <div class="col-sm-7">
                                           <select required class="form-control" name="channelCode" id="channelCode">

                                            <?php
                                              if($channelCode!=""){
                                                  $StrTypeDisplay="<option active>" .$channelCode. "</option>";
                                                  $StrTypeDisplay.="<option>--</option>";  
                                                  $StrTypeDisplay.="<option>GT</option>";
                                                  $StrTypeDisplay.="<option>MT</option>";
                                               }
                                               else{
                                                $StrTypeDisplay="<option>--</option>";  
                                                  $StrTypeDisplay.="<option>GT</option>";
                                                  $StrTypeDisplay.="<option>MT</option>";
                                               }
                                               ECHO $StrTypeDisplay;

                                            ?>
                                          </select>
                                        </div>
                                </div>
                      </div>


                    
                   </div>
                                     
                    <!-- /.box-body -->
                   <div class="box-footer">
                      <button type="submit" class="btn medium bg-blue">Submit</button>
                      <?php
                      //  if(isset($_GET['ID'])){
                      //    echo "<a href='index.PHP'><button type='button' class='btn medium bg-green'>Home</button></a>";
                     //   }elseif(isset($_GET['InprogressID'])){
                     //     echo "<a href='InProgress.PHP'><button type='button' class='btn medium bg-green'>Home</button></a>";
                     //   }
                      ?>
                    </div>
                    <!-- /.box-footer -->
                </form>
              </div>
            
        </div>

     
      </div>
      <!-- /.row (main row) -->

      <!-- Selected Group detail here -->
      <div class="row">
        
      </div>

    </section>
    <!-- /.content -->
  </div>




<?php include("footer.php"); //THIS IS FOOTER---------------------------------------------------------------------- ?>

  
</div>
<!-- ./wrapper -->

<!-- jQuery 2.2.3 -->
<script src="plugins/jQuery/jquery-2.2.3.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button);
</script>


<!-- jQuery 2.2.3 -->
<script src="plugins/jQuery/jquery-2.2.3.min.js"></script>
<!-- Bootstrap 3.3.6 -->
<script src="bootstrap/js/bootstrap.min.js"></script>
<!-- DataTables -->
<script src="plugins/datatables/jquery.dataTables.min.js"></script>
<script src="plugins/datatables/dataTables.bootstrap.min.js"></script>
<!-- SlimScroll -->
<script src="plugins/slimScroll/jquery.slimscroll.min.js"></script>fo
<!-- FastClick -->
<script src="plugins/fastclick/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/app.min.js"></script>
<!-- AdminLTE for demo purposes --> 
<script src="dist/js/demo.js"></script>
<script src="plugins/select2/select2.full.min.js"></script>
<script>
  $(function () {
    $("#example1").DataTable();
    $('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false
    });
  });
</script>

<script>
  $(".select2").select2();

  $(function () {
    $("#example1").DataTable();
    $('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false
    });
  });
</script>

  
<script>  
  // to filter the data per BUCKEt
    function LoadData(){
      var ID=($('select[name=BDM1]').val());
      
     // alert(ID);
      $.ajax({
          method: "POST",
          url: "Function/DisplayBDM.php",
          data: {Type:ID}
      }).done(function(msg){
          msg=msg.substring(2,msg.length);
          //alert(msg);
          document.getElementById('BDMU1').value=msg;
          document.getElementById('BDMU1F').value=msg;
      });  
    }

    function LoadData2(){
      var ID=($('select[name=BDM2]').val());
      
     // alert(ID);
      $.ajax({
          method: "POST",
          url: "Function/DisplayBDM.php",
          data: {Type:ID}
      }).done(function(msg){
          msg=msg.substring(2,msg.length);
          //alert(msg);
          document.getElementById('BDMU2').value=msg;
          document.getElementById('BDMU2F').value=msg;
      });  
    }

    function LoadData3(){
      var ID=($('select[name=BDM3]').val());
      
     // alert(ID);
      $.ajax({
          method: "POST",
          url: "Function/DisplayBDM.php",
          data: {Type:ID}
      }).done(function(msg){
          msg=msg.substring(2,msg.length);
          //alert(msg);
          document.getElementById('BDMU3').value=msg;
          document.getElementById('BDMU3F').value=msg;
      });  
    }

    function LoadData4(){
      var ID=($('select[name=BDM4]').val());
      
     // alert(ID);
      $.ajax({
          method: "POST",
          url: "Function/DisplayBDM.php",
          data: {Type:ID}
      }).done(function(msg){
          msg=msg.substring(2,msg.length);
          //alert(msg);
          document.getElementById('BDMU4').value=msg;
          document.getElementById('BDMU4F').value=msg;
      });  
    }

    function LoadData5(){
      var ID=($('select[name=BDM5]').val());
      
     // alert(ID);
      $.ajax({
          method: "POST",
          url: "Function/DisplayBDM.php",
          data: {Type:ID}
      }).done(function(msg){
          msg=msg.substring(2,msg.length);
          //lert(msg);
          document.getElementById('BDMU5').value=msg;
          document.getElementById('BDMU5F').value=msg;
      });  
    }


    //JSA ACCOUNT HERE
    function LoadDataJSA1(){
      var ID=($('select[name=JSA1]').val());
      
     // alert(ID);
      $.ajax({
          method: "POST",
          url: "Function/DisplayBDM.php",
          data: {Type:ID}
      }).done(function(msg){
          msg=msg.substring(2,msg.length);
          //alert(msg);
          document.getElementById('JSAU1').value=msg;
          document.getElementById('JSAU1F').value=msg;
      });  
    }

     function LoadDataJSA2(){
      var ID=($('select[name=JSA2]').val());
      
     // alert(ID);
      $.ajax({
          method: "POST",
          url: "Function/DisplayBDM.php",
          data: {Type:ID}
      }).done(function(msg){
          msg=msg.substring(2,msg.length);
          //alert(msg);
          document.getElementById('JSAU2').value=msg;
          document.getElementById('JSAU2F').value=msg;
      });  
    }

     function LoadDataJSA3(){
      var ID=($('select[name=JSA3]').val());
      
     // alert(ID);
      $.ajax({
          method: "POST",
          url: "Function/DisplayBDM.php",
          data: {Type:ID}
      }).done(function(msg){
          msg=msg.substring(2,msg.length);
          //alert(msg);
          document.getElementById('JSAU3').value=msg;
          document.getElementById('JSAU3F').value=msg;
      });  
    }

     function LoadDataJSA4(){
      var ID=($('select[name=JSA4]').val());
      
     // alert(ID);
      $.ajax({
          method: "POST",
          url: "Function/DisplayBDM.php",
          data: {Type:ID}
      }).done(function(msg){
          msg=msg.substring(2,msg.length);
          //alert(msg);
          document.getElementById('JSAU4').value=msg;
          document.getElementById('JSAU4F').value=msg;
      });  
    }

     function LoadDataJSA5(){
      var ID=($('select[name=JSA5]').val());
      
     // alert(ID);
      $.ajax({
          method: "POST",
          url: "Function/DisplayBDM.php",
          data: {Type:ID}
      }).done(function(msg){
          msg=msg.substring(2,msg.length);
          //alert(msg);
          document.getElementById('JSAU5').value=msg;
          document.getElementById('JSAU5F').value=msg;
      });  
    }

   


    function Disabled(){
      document.getElementById("BDMU1").disabled=true;
      document.getElementById("BDMU2").disabled=true;
      document.getElementById("BDMU3").disabled=true;
      document.getElementById("BDMU4").disabled=true;
      document.getElementById("BDMU5").disabled=true;

      document.getElementById("JSAU1").disabled=true;
      document.getElementById("JSAU2").disabled=true;
      document.getElementById("JSAU3").disabled=true;
      document.getElementById("JSAU4").disabled=true;
      document.getElementById("JSAU5").disabled=true;
      
    }
</script>






</body>
</html>



