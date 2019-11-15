

<?php
  include("model/dbcon.php");  
  if(session_status() != PHP_SESSION_ACTIVE) {
      session_start();
  }
  $UserType=$_SESSION['UserType']; // THIS IS THE FIELD OF BDM NAME
  $BDM_USERNAME=$_SESSION['BDM_USERNAME']; // THIS IS THE FIELD OF BDM NAME
  $channel=$_SESSION['channel']; // THIS IS THE FIELD OF BDM NAME
  $BusinessUnit=$_SESSION['BU']; // THIS IS THE FIELD OF BDM NAME
  $HoldBatch=$BDM_USERNAME.date('Ym') ;
  $BDMName=$_SESSION['Name']; // THIS IS THE FIELD OF BDM NAME
  //----------------------------------------------------------------------------------
//echo $HoldBatch;
  date_default_timezone_set('Asia/Manila');


  //TO CHECK IF THE BDM HAS ALREADY UPLOAD A TIR DATA
  $strHasUploadedData="";
  $sqlHasData = "select top 1 id from TIP.TIR_UPLOAD_EXCEL WHERE LASTUPLOAD='".$HoldBatch."'";          
  $stmtHasData=sqlsrv_query($con,$sqlHasData);

 // echo $HoldBatch;
  while($row=sqlsrv_fetch_array($stmtHasData,SQLSRV_FETCH_ASSOC)){
    $strHasUploadedData=$row['id'];
  }





  // EXCEL FILE FUNCTION FOR UPLOADING DATA

  include 'Classes/PHPExcel/IOFactory.php';

    if(isset($_FILES['file']['name'])){
        
      $file_name = $_FILES['file']['name'];
      $ext = pathinfo($file_name, PATHINFO_EXTENSION);
      
      //Checking the file extension
      if($ext == "xlsx"){

          
          $file_name = $_FILES['file']['tmp_name'];
          $inputFileName = $file_name;

        //  Read your Excel workbook
        try {
          $inputFileType = PHPExcel_IOFactory::identify($inputFileName);
          $objReader = PHPExcel_IOFactory::createReader($inputFileType);
          $objPHPExcel = $objReader->load($inputFileName);
        } catch (Exception $e) {
          die('Error loading file "' . pathinfo($inputFileName, PATHINFO_BASENAME) 
          . '": ' . $e->getMessage());
        }

        //Table used to display the contents of the file
        
        
        //  Get worksheet dimensions
        $sheet = $objPHPExcel->getSheet(0);
        $highestRow = $sheet->getHighestRow();
        $highestColumn = $sheet->getHighestColumn();

        //echo $highestColumn;
        
        //if($highestColumn=='E'){
          //  Loop through each row of the worksheet in turn

          

          //TO REPLACE THE LAST UPLOADED DATA
          $queryDelete = "dELETE FROM TIP.TIR_TEMPORARY_UPLOAD_EXCEL WHERE LASTUPLOAD='".$HoldBatch."'";          
          $stmtDelete=sqlsrv_prepare($con,$queryDelete);
          sqlsrv_execute($stmtDelete);
          sqlsrv_free_stmt($stmtDelete);

          //To isnert data in database

          for ($row =7; $row <= $highestRow; $row++) {
          
            $param1=$sheet->getCell('Y'.$row)->getOldCalculatedValue();
            $param2= $sheet->getCell('Z'.$row)->getOldCalculatedValue();
            $param3= $sheet->getCell('AA'.$row)->getOldCalculatedValue();
            $param4= $sheet->getCell('AB'.$row)->getOldCalculatedValue();
        //  echo $sheet->getActiveSheet()->getCell('AB'.$row)->getFormattedValue();
          // echo $objPHPExcel->getActiveSheet()->getCell('AB'.$row)->getOldCalculatedValue();
            //  Read a row of data into an array
            $rowData = $sheet->rangetoArray('J' . $row . ':' . 'X' . $row, null, true, false);
           


           // $objPHPExcel->getActiveSheet()->getCellByColumnAndRow('AB7')->getValue();
            $strData="";
            foreach($rowData[0] as $k=>$v)
            $strData.="'".$v."'" . ",";
            $strData=substr($strData,0,strlen($strData)-1);
            

            // INSERT TO TEMPORARY TABLE
            $query = "insert into TIP.TIR_TEMPORARY_UPLOAD_EXCEL(DataID,PromoID,Amount,year,type,correctDivision,CorrectExpense,Remarks,corp_meat,corp_sardines,corp_dairy,corp_tuna,corp_hunts,corp_vitacoco,corp_rmb,statusAccomplished,HasValidation,InputTotalBudget,IsCorp,bdm_bu,bdm_name,LastUpload) VALUES(".str_replace("t's", "ts", $strData).",'".$param1."','".$param2."','".$param3."','".$param4."','".$BusinessUnit."','".$BDMName."','".$HoldBatch."')";          
            $stmtUpload=sqlsrv_prepare($con,$query);
            sqlsrv_execute($stmtUpload);
            sqlsrv_free_stmt($stmtUpload);

        // ECHO $query;
          }
          
      
     //   }else{
     //     echo '<p style="color:red;">Invalid Data. Please check the format or Employee Informtion.</p>';   
     //   }
      }else{
        echo '<p style="color:red;">Please upload file with xlsx extension only</p>'; 
      } 
        
    }
?>


<!DOCTYPE html>
<html>
  <head>
      <link rel="shortcut icon" type="image/png" href="images/CPG Logo.png"/>
    <!--  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
      <script src="js/bootstrap.min.js"></script> -->
      <?php include("linkScriptPages.php");?>
      
  </head>
<body class="hold-transition skin-blue sidebar-mini" onload="myFunction()">
<div class="wrapper">

  <header class="main-header">
    <!-- Logo -->
    <a  class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b>SPICA</b></span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b>SPICA</b> System</span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>


      <!-- header this code-->
      <div class="navbar-custom-menu">
        <?php include("HeaderUser-03222019.php");?>
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

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->

   <section class="content">
      

     <div class="box-footer">
        <input type=hidden value="<?php echo $strHasUploadedData ?>" id="HasDataUploaded" name="HasDataUploaded">
        <a href='TIRExcel.php'><button type='submit' class='btn btn-primary btn-lg'>Download Excel File</button></a>
        <button type='submit' class='btn btn-primary pull-right btn-lg' onclick="HasData()">Upload TIR Data</button>
     </div>

     
      

      <div class="row">

        <div class="col-xs-12"><br><br>
            <div class="box">
              <div class="box-body">
                <form enctype="multipart/form-data" action="ExcelEntryTIR.php" method="post" >
                  
                    <table>
                      <tr>
                        <td width="10%"><input type='File' name="file" id="file" required accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet"   class='btn btn-primary btn-sm' value='Upload Excel File '></td>
                        <td width="8%"><input class="btn btn-primary btn-sm  pull-right" type="submit" value="Read Data" /></td>                        
                        <td width="80%"></td>
                      <tr>
                    </table>
                    <!-- onchange="onLoadExcel()" -->
                </form><br>
              
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                    <tr>
                      <?php
                          $strHeader="<th>System ID</th>";
                          $strHeader.="<th>Reference Type</th>";
                          $strHeader.="<th>Amount Budget</th>";
                          $strHeader.="<th>Year</th>";
                          $strHeader.="<th>Type</th>";
                          $strHeader.="<th>Correct Division</th>";
                          $strHeader.="<th>Correct Classfication</th>";
                          $strHeader.="<th>Status</th>";
                        echo $strHeader;
                      ?>
                    </tr>
                  </thead>

                  <tbody >

                    <?php
                        include("model/dbcon.php");
                        $sql="select * from TIP.TIR_TEMPORARY_UPLOAD_EXCEL WHERE LASTUPLOAD='" .$HoldBatch. "'";
                        $stmt=sqlsrv_query($con,$sql);

                        $strDisplay="";
                         while($row=sqlsrv_fetch_array($stmt,SQLSRV_FETCH_ASSOC)){
                            $strDisplay.="<tr>";
                               $strDisplay.="<td>$row[DataID]</td>";
                               $strDisplay.="<td>$row[PromoID]</td>";
                               $strDisplay.="<td>$row[Amount]</td>";
                               $strDisplay.="<td>$row[Year]</td>";
                               $strDisplay.="<td>$row[Type]</td>";
                               $strDisplay.="<td>$row[CorrectDivision]</td>";
                               $strDisplay.="<td>$row[correctExpense]</td>";
                               $strDisplay.="<td>$row[StatusAccomplished]</td>";
                            $strDisplay.="</tr>";
                        }
                        echo $strDisplay;
                    ?>
                  </tbody>


                    

                  
                  
                </table>
              </div>
            </div>
          </div>
      </div>
      <!-- /.row (main row) -->

    </section>



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
<script src="plugins/slimScroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="plugins/fastclick/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/app.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>

<script>
  $("button[name=Poke]").click(function(){
    //alert($(this).data("id"));  
      $.ajax({
          method: "POST",
          url: "UpdatePoke.php",
          data: {DataID:$(this).data("id")}
      }).done(function(msg){
          $("#ViewDetails").html(msg);
      });
  });
</script>


<script>
function myFunction(){
    var PendingNumber = document.getElementById('PendingNumber').value;
    var IsUpdate= document.getElementById('BoolUpdate').value;

      var x = document.getElementById('myDIV');
      if (x.style.display === 'none') { // to validate if theres pending item

          if(PendingNumber==""){
           //  alert(IsUpdate); 
           // if(IsUpdate=="true"){ // to validate if displaying of ALERT is okay na
           //  x.style.display = 'block';  
          //  }else{
              window.open('Function/UpdateSubmitted.php','_self') ;
          //  }
          }else{
            alert('Kindly complete all status per row.');
          }
      } else {
          x.style.display = 'none';
          if(IsUpdate=="true"){ // to validate if displaying of ALERT is okay na}
            x.style.display = 'block';  
          }
          
      }
    
}

</script>

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
  function onLoadExcel(){
    location.reload();
  }

  function HasData(){
    var HasDataUploaded=document.getElementById("HasDataUploaded").value;

    if(HasDataUploaded!=""){
        var Answer=confirm("Do you want to modify the uploaded data?");
        if(Answer){
            window.open('function/UploadExcelTIR.php','_self');
        }
    }else{
      window.open('function/UploadExcelTIR.php','_self');
    }
  }

</script>


</body>
</html>



