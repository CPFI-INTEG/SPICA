<?php
  if(session_status() != PHP_SESSION_ACTIVE) {
      session_start();
  }
  $UserType=$_SESSION['UserType']; // THIS IS THE FIELD OF BDM NAME
  $parentCode=$_SESSION['BDM_USERNAME']; // THIS IS THE FIELD OF BDM NAME
  $channel=$_SESSION['channel']; // THIS IS THE FIELD OF BDM NAME
  $BusinessUnit=$_SESSION['BU']; // THIS IS THE FIELD OF BDM NAME
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

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->

   <section class="content">
      
      <table class="table table-bordered">
          <tr>
              <td class="text-left"><h1>List of Accounts</h1></td>
              <?php
                $strButton="";              
                $strButton.="<td><br><a href='BDMTaggingEntry.php'><button type='button' class='btn btn-block btn-primary btn-lg'>New Tagging</button></a></td>";
                echo $strButton;
              ?>
              
          </tr>
      </table>

      <div class="row">
        <div class="col-xs-12">
            <div class="box">
              <div class="box-body">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                    <tr>
                      <?php
                          $strHeader="<th>BDM Username</th>";
                          $strHeader.="<th>BDM Name</th>";
                          $strHeader.="<th>DBDM Name</th>";
                          $strHeader.="<th>Parent Code</th>";
                          $strHeader.="<th>Channel</th>";
                          $strHeader.="<th>BU</th>";
                          $strHeader.="<th>Action</th>";
                        echo $strHeader;
                      ?>
                    </tr>
                  </thead>

                  <tbody >

                    <?php
                        include("model/dbcon.php");
                        $sql="select * from TIP.BDM_Tagging_no_JSA";
                        $stmt=sqlsrv_query($con,$sql);

                        $strDisplay="";
                         while($row=sqlsrv_fetch_array($stmt,SQLSRV_FETCH_ASSOC)){
                            $strDisplay.="<tr>";
                                
                                   $strDisplay.="<td>$row[BDM_Username]</td>";
                                   $strDisplay.="<td>$row[BDM_Name]</td>";
                                   $strDisplay.="<td>$row[DBDM]</td>";
                                   $strDisplay.="<td>$row[Parent_Code]</td>";
                                   $strDisplay.="<td>$row[Channel]</td>";
                                   $strDisplay.="<td>$row[BU]</td>";

                                   
                                   
                                   //<a href='AnalystEntry.php?ID=$row[USERNAME]' class='btn medium bg-blue tooltip-button' data-placement='top' title='Edit'>
                                          //&nbsp;&nbsp;&nbsp;Edit &nbsp;&nbsp;&nbsp;
                                        //</a>
                                        //<a href='function/DeleteRecord.php?delete_id=$row[USERNAME]&tableName=PARTIAL_ANALYST&IDName=id&frmName=../AnalystTagging.php&AuditDesc=$rows[Name]&TableName=List of Analyst' class='btn medium bg-blue tooltip-button' data-placement='top' title='Edit'>
//                                          &nbsp;&nbsp;&nbsp;Delete &nbsp;&nbsp;&nbsp;
                                        //</a>
                                    $strDisplay.="<td>
                                        
                                        <a href='BDMTaggingEdit.php?ID=$row[id]' class='btn medium bg-blue tooltip-button' data-placement='top' title='Edit'>
                                          &nbsp;&nbsp;&nbsp;Edit &nbsp;&nbsp;&nbsp;
                                        </a>

                                        <a href='Function/DeleteBDMTag.php?ID=$row[id]' class='btn medium bg-blue tooltip-button' data-placement='top' title='Edit'>
                                          &nbsp;&nbsp;&nbsp;Delete &nbsp;&nbsp;&nbsp;
                                        </a>
                                    </td>";  

                             
                                  

                                
                                // MODAL BUTTON TO
                                //<button type='button'  class='btn medium bg-green' data-toggle='modal' data-target='#exampleModal' data-whatever='$row[cm_jv_doc_no]'>Re-class</button>
                                
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


</body>
</html>


