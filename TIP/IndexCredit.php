<?php
  if(session_status() != PHP_SESSION_ACTIVE) {
      session_start();
  }

  $parentCode=$_SESSION['BDM_USERNAME']; // THIS IS THE FIELD OF BDM NAME
  $BU=$_SESSION['BU']; // THIS IS THE FIELD OF BDM NAME
  $UserType=$_SESSION['UserType']; // THIS IS THE FIELD OF BDM NAME

  $strNumberPending="";
  include("model/dbcon.php");
  $sqlData="select * from tip.Vw_BDMUserTagging where isstatus='Pending' and bdm_username='".$parentCode."' ";
  //echo $sqlData;
  $stmt=sqlsrv_query($con,$sqlData);  
  if($stmt){
    $rows = sqlsrv_has_rows($stmt); // number of rows OR (true or false)
    $strNumberPending= $rows;  
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
      <span class="logo-mini"><b>TIR</b></span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b>TIR</b> System</span>
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

    <input type=hidden name='PendingNumber' id='PendingNumber' value="<?php echo $strNumberPending ?>">
    <input type=hidden name='BoolUpdate' id='BoolUpdate' value="<?php    if(isset($_GET['Update'])){echo $_GET['Update'];}   ?>"   >

    <div class="alert alert-danger alert-dismissible" id="myDIV">
      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
      <h4><i class="icon fa fa-ban"></i> Alert!</h4>
      The Filtered Data is successfully submitted to Sales Admin.
    </div>

  
      <table class="table table-bordered">
          <tr>
              <td class="text-left"><h1>Submitted Data</h1></td>
              <td><br><button type="button" onclick="myFunction()" class="btn btn-block btn-primary btn-lg">Submit</button></td>
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
                        if($UserType=="Credit and Collection Supervisor"){ // credit and collection to!
                          $strHeader="<th>Company Code</th>";
                          $strHeader.="<th>CM JV Document No.</th>";
                          $strHeader.="<th>Transaction Amount</th>";
                          $strHeader.="<th>Fiscal Year</th>";
                          $strHeader.="<th>Account Status</th>";
                          $strHeader.="<th>Action</th>";
                        }else{
                          $strHeader="<th>Company Code</th>";
                          $strHeader.="<th>CM JV Document No.</th>";
                          $strHeader.="<th>Transaction Amount</th>";
                          $strHeader.="<th>Account Status</th>";
                          $strHeader.="<th>Submitted Status</th>";
                          $strHeader.="<th>Action</th>";
                        }
                        echo $strHeader;
                      ?>
                    </tr>
                  </thead>

                  <tbody >

                    <?php
                        include("model/dbcon.php");
                        if($UserType=="Credit and Collection Supervisor"){ // credit and collection to!
                          $sql="select ID,company_Cd,cm_jv_doc_no,Transaction_amount,isstatus,IsStatusSubmitted,ispoke from tip.Vw_BDMUserTagging";
                        }else{
                          $sql="select ID,company_Cd,cm_jv_doc_no,Transaction_amount,fiscal_year,isstatus,ispoke from tip.Vw_BDMUserTagging where bdm_username='".$parentCode."' and IsStatusSubmitted='Pending' ";
                        }

                        
                        //echo $sql;
                        $stmt=sqlsrv_query($con,$sql);

                        $strDisplay="";
                         while($row=sqlsrv_fetch_array($stmt,SQLSRV_FETCH_ASSOC)){
                            $strDisplay.="<tr>";
                                $strDisplay.="<td>$row[company_Cd]</td>";
                                $strDisplay.="<td>$row[cm_jv_doc_no]</td>";
                                $strDisplay.="<td>$row[Transaction_amount]</td>";
                                
                                if($CompanyCode=="0"){ // to know if this is SALES ADMIN
                                  $strDisplay.="<td>$row[isstatus]</td>";
                                  $strDisplay.="<td>$row[IsStatusSubmitted]</td>";
                                  if($row['IsStatusSubmitted']=="Submitted" or $row['ispoke']==1){ //to know if the data is submitted then no need to POKE
                                    if($row['IsStatusSubmitted']=="Submitted"){
                                      $strDisplay.="<td>
                                          &nbsp;&nbsp;&nbsp;--&nbsp;&nbsp;&nbsp;
                                      </td>";  
                                    }else{
                                      $strDisplay.="<td>
                                          &nbsp;&nbsp;&nbsp;<B>Already Poke</B>&nbsp;&nbsp;&nbsp;
                                      </td>";  
                                    }
                                  }else{
                                    $strDisplay.="<td>
                                        <a href='Function/UpdatePoke.php?ID=$row[ID]' class='btn medium bg-red tooltip-button' data-placement='top'>
                                            &nbsp;&nbsp;&nbsp;Poke&nbsp;&nbsp;&nbsp;
                                        </a>                                   
                                    </td>";  
                                  }
                                  
                                }else{
                                  $strDisplay.="<td>$row[fiscal_year]</td>";
                                  $strDisplay.="<td>$row[isstatus]</td>";
                                  $strDisplay.="<td>
                                    <a href='DataFill.php?ID=$row[ID]' class='btn medium bg-green tooltip-button' data-placement='top' title='Edit'>
                                        &nbsp;&nbsp;&nbsp;Fill-in&nbsp;&nbsp;&nbsp;
                                    </a>                                   
                                </td>";
                                }
                                
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


