<?php
  if(session_status() != PHP_SESSION_ACTIVE) {
      session_start();
  }

    $id="";
    $name="";
    $username="";
    $password="";
    $imgpicture="";

  $UserType=$_SESSION['UserType']; // THIS IS THE FIELD OF BDM NAME
  $UserImage=$_SESSION['UserImage']; // THIS IS THE FIELD OF BDM NAME
  $Password=$_SESSION['Password']; // THIS IS THE FIELD OF BDM NAME
 // $id=$_SESSION['id']; // THIS IS THE FIELD OF BDM NAME

  if(isset($_GET['ID'])){
    $id=$_GET['ID'];
    require_once("model/dbcon.php");
    $sqlAccount="select * from TIP.vw_SETUP_TAGGING where USERNAME='".$id."'";
    //ECHO $sqlAccount;
    $stmt=sqlsrv_query($con,$sqlAccount);

    while($row=sqlsrv_Fetch_Array($stmt,SQLSRV_FETCH_ASSOC)){
     // $id=$row['id'];
      $name=$row['FULL_NAME'];
      $username=$row['USERNAME'];
      $password=$row['PASSWORD'];
      $imgpicture=$row['UserImage'];
    }
  }
  if($imgpicture==""){
      $imgpicture="BlackUser.png";
    }
?>

<!DOCTYPE html>
<html>
  <head>
      <link rel="shortcut icon" type="image/png" href="images/CPG Logo.png"/>
      <?php include("linkScriptPagesPartial.php");?>
  </head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

  <header class="main-header">
    <!-- Logo -->
    <a class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b>PB</b></span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b>PB</b> System</span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>

      <div class="navbar-custom-menu">
          <?php include("HeaderUserPartial.php");?>
      </div>
    </nav>
  </header>
  <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
          <?php include("SidebarPartial.php");?>
    </section>
    <!-- /.sidebar -->
  </aside>

 <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>ANALYST TAGGING </h1>
    </section>

    <!-- Main content -->
    <section class="content">

      <div class="row">
         <div class="col-md-7">
          <div class="box box-primary">

            <form class="form-horizontal" action='function/SaveAnalystTagging.php' method="post"  enctype="multipart/form-data">
                <div class="col-md-12">
                    <div class="box-header with-border">
                        <i class="fa fa-book"></i>
                        <h3 class="box-title">DATA ENTRY </h3>
                    </div>
                    <br>

                     <div class="form-group">
                        <label for="inputPassword3" class="col-sm-2 control-label">BP Code :</label>
                         <div class="col-sm-9">
                          <input  type="hidden" class="form-control" id="id" name="id" value="<?php  echo $_GET['ID'] ?>">
                            <input  type="text" class="form-control" id="BPCode1" name="BPCode1" placeholder="Input BP Code" value="">
                          </div>
                      </div>

                      <div class="form-group">
                        <label for="inputPassword3" class="col-sm-2 control-label">BP Code :</label>
                         <div class="col-sm-9">
                            <input  type="text" class="form-control" id="BPCode2" name="BPCode2" placeholder="Input BP Code" value="">
                          </div>
                      </div>

                      <div class="form-group">
                        <label for="inputPassword3" class="col-sm-2 control-label">BP Code :</label>
                         <div class="col-sm-9">
                            <input  type="text" class="form-control" id="BPCode3" name="BPCode3" placeholder="Input BP Code" value="">
                          </div>
                      </div>

                      <div class="form-group">
                        <label for="inputPassword3" class="col-sm-2 control-label">BP Code :</label>
                         <div class="col-sm-9">
                            <input  type="text" class="form-control" id="BPCode4" name="BPCode4" placeholder="Input BP Code" value="">
                          </div>
                      </div>

                      <div class="form-group">
                        <label for="inputPassword3" class="col-sm-2 control-label">BP Code :</label>
                         <div class="col-sm-9">
                            <input  type="text" class="form-control" id="BPCode5" name="BPCode5" placeholder="Input BP Code" value="">
                          </div>
                      </div>

                      <div class="form-group">
                        <label for="inputPassword3" class="col-sm-2 control-label">BP Code :</label>
                         <div class="col-sm-9">
                            <input  type="text" class="form-control" id="BPCode6" name="BPCode6" placeholder="Input BP Code" value="">
                          </div>
                      </div>

                      <div class="form-group">
                        <label for="inputPassword3" class="col-sm-2 control-label">BP Code :</label>
                         <div class="col-sm-9">
                            <input  type="text" class="form-control" id="BPCode7" name="BPCode7" placeholder="Input BP Code" value="">
                          </div>
                      </div>

                      <br><br>
                </div>
                <div class="box-footer">
                  <input type="submit" value="Submit" class="btn btn-info">
                  <a href='AnalystTagging.PHP'>
                    <button type="button" class="btn btn-info">Cancel</button>
                  </a>
                </div>
              
            </form>
           </div>
        </div>




        <div class="col-md-5">
          <div class="box box-primary">
            <div class="box-body box-profile">
              <h3>List of BP Code</h3>
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                    <tr>
                      <?php
                          $strHeader="<th>Name</th>";
                          $strHeader.="<th>Action</th>";
                        echo $strHeader;
                      ?>
                    </tr>
                  </thead>

                  <tbody >

                    <?php
                        include("model/dbcon.php");
                        $sql="select * from dbo.vw_PARTIAL_ANALYSTTagging where username='". $_GET['ID']."'";
                      //  echo $sql;
                        $stmt=sqlsrv_query($con,$sql);

                        $strDisplay="";
                         while($row=sqlsrv_fetch_array($stmt,SQLSRV_FETCH_ASSOC)){
                            $strDisplay.="<tr>";
                                
                                   $strDisplay.="<td>$row[bpcode]</td>";
                                    $strDisplay.="<td>
                                       <a href='function/DeleteRecord.php?delete_id=$row[id]&tableName=PARTIAL_ANALYSTTagging&IDName=id&frmName=../AnalystHandled.php?ID=".$_GET['ID']."&AuditDesc=$rows[bpcode]&TableName=List of Analyst per Account' class='btn medium bg-blue tooltip-button' data-placement='top' title='Edit'>
                                          &nbsp;&nbsp;&nbsp;Delete &nbsp;&nbsp;&nbsp;
                                        </a>";
                                  

                                
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

<script>
  function myFunction() {
      var pass1 = document.getElementById("pass1").value;
      var pass2 = document.getElementById("pass2").value;

      var ok = true;
      if (pass1 != pass2) {
          //alert("Passwords Do not match");
          document.getElementById("pass1").style.borderColor = "#E34234";
          document.getElementById("pass2").style.borderColor = "#E34234";
          alert("Password Mismatch");
          ok = false;
      }
      return ok;
  }
  
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



</body>
</html>


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