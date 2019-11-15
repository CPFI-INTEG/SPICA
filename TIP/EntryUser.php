<?php
  if(session_status() != PHP_SESSION_ACTIVE) {
      session_start();
  }


    $strUserImage="BlackUser.png";
    $strUserType="-------";
    $strPassword="";
    $strName="-------";
    $strEditName="";
    $bdm_username="";


  

  if(isset($_GET['ID'])){
    $strEditName=$_GET['ID'];

     $Name=$_SESSION['Name']; // THIS IS THE FIELD OF BDM NAME
    $UserType=$_SESSION['UserType']; // THIS IS THE FIELD OF BDM NAME
    $UserImage=$_SESSION['UserImage']; // THIS IS THE FIELD OF BDM NAME
    $Password=$_SESSION['Password']; // THIS IS THE FIELD OF BDM NAME
    $id=$_SESSION['id']; // THIS IS THE FIELD OF BDM NAME

    require_once("model/dbcon.php");
    $sqlAccount="Select NAME,USERTYPE,PASSWORD,USERIMAGE,BU,bdm_username from tip.TIR_Useraccount where NAME='".$strEditName."'";
    //echo $sqlAccount;
    $stmt=sqlsrv_query($con,$sqlAccount);

    while($row=sqlsrv_Fetch_Array($stmt,SQLSRV_FETCH_ASSOC)){
      $strName=$row['NAME'];
      $strUserType=$row['USERTYPE'];
      $strPassword=$row['PASSWORD'];
      $strUserImage=$row['USERIMAGE'];
      $strbu=$row['BU'];
      $bdm_username=$row['bdm_username'];
    }


  }
?>

<!DOCTYPE html>
<html>
  <head>
      <link rel="shortcut icon" type="image/png" href="images/CPG Logo.png"/>
      <?php include("linkScriptPages.php");?>
  </head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

  <header class="main-header">
    <!-- Logo -->
    <a href="index2.html" class="logo">
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
      <h1>USER PROFILE</h1>
    </section>

    <!-- Main content -->
    <section class="content">

      <div class="row">
        <div class="col-md-5">

          <!-- Profile Image -->
          <div class="box box-primary">
            <div class="box-body box-profile">
              <img class="profile-user-img img-responsive img-circle"  src="<?php echo "images/".$strUserImage.""; ?>" alt="User profile picture">


              <h3 class="profile-username text-center"><?php echo $strName ?></h3>

              <p class="text-muted text-center"><?php echo $strUserType ?></p>

              <strong><i class="fa fa-book margin-r-5"></i> Password</strong> 
              <?php
                $CountPassword=strlen($strPassword);
                $strHolderPassword="";

                for($Counter=1;$Counter<=$CountPassword;$Counter++){
                  $strHolderPassword.="*";
                }

                
                echo "<h2>".$strHolderPassword."</h2>";
              ?>
            
            </div>
            <!-- /.box-body -->
          </div>
        

        </div>
        <!-- /.col -->
        <div class="col-md-7">
          <div class="box box-primary">

            <form class="form-horizontal" action='function/SaveProfile.php' method="post" onsubmit="return myFunction()" enctype="multipart/form-data">
                <div class="col-md-12">
                    <div class="box-header with-border">
                        <i class="fa fa-book"></i>
                        <h3 class="box-title">User Entry</h3>
                    </div>
                    <br>
                    <!-- TYPE FIELD -->
                     <div class="form-group">
                        <label for="inputPassword3" class="col-sm-3 control-label">Name :</label>

                         <div class="col-sm-7">
                            <input required type="hidden" class="form-control" id="Userid" name="Userid" value="<?php echo $id ?>">
                            <input required type="text" class="form-control" id="pass1" name="pass1" placeholder="Input Name" value="<?php echo $strName ?>">
                          </div>
                      </div>

                      <div class="form-group">
                          <label for="inputPassword3" class="col-sm-3 control-label">User Name:</label>

                         <div class="col-sm-7">
                            <input required type="password" class="form-control" id="pass2" name="pass2" placeholder="Input Re-type Password" value="<?php echo $bdm_username ?>">
                          </div>
                      </div>
                      <div class="form-group">
                          <label for="inputPassword3" class="col-sm-3 control-label">Password :</label>

                         <div class="col-sm-7">
                            <input required type="password" class="form-control" id="NewPass" name="NewPass" placeholder="Input new Password" value="<?php echo $strPassword ?>">
                          </div>
                      </div>

                       <div class="form-group">
                          <label for="inputPassword3" class="col-sm-3 control-label">Re-Password :</label>

                         <div class="col-sm-7">
                            <input required type="password" class="form-control" id="NewPass" name="NewPass" placeholder="Input new Password" value="<?php echo $strPassword ?>">
                          </div>
                      </div>


                      <div class="form-group">
                          <label for="inputPassword3" class="col-sm-3 control-label">Image :</label>

                         <div class="col-sm-7">
                            <input NAME="FileImg"  accept="image/*" type="file">
                          </div>
                      </div>
                      <br><br><br>

                     
                </div>

                <div class="box-footer">
                  <input type="submit" value="Submit" class="btn btn-info">
                  <a href='UserAccount.PHP'>
                    <button type="button" class="btn btn-info">Cancel</button>
                  </a>
                </div>
              
            </form>
           </div>
        </div>
        <!-- /.col -->

        <div class="col-md-12">
          <div class="box">
              <div class="box-body">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                    <tr>
                      <th>Parent Code</th> 
                      <th>Parent Name</th>
                      <th>Business Units</th>
                      <th>Action</th>
                    </tr>
                  </thead>

                  <tbody >

                    <?php
                        include("model/dbcon.php");
                         $sql="select parent_Code,Parent_Name,id,bu from dbo.TIR_UserAccount where name='".$strEditName."'";
                        
                        
                       // echo $sql;
                        $stmt=sqlsrv_query($con,$sql);

                        $strDisplay="";
                         while($row=sqlsrv_fetch_array($stmt,SQLSRV_FETCH_ASSOC)){
                            $strDisplay.="<tr>";
                                $strDisplay.="<td>$row[parent_Code]</td>";
                                $strDisplay.="<td>$row[Parent_Name]</td>";
                                $strDisplay.="<td>$row[bu]</td>";
                           
                                $strDisplay.="<td>
                                  <a href='DataFill.php?ID=$row[id]' class='btn medium bg-red tooltip-button' data-placement='top' title='Edit'>
                                      &nbsp;&nbsp;&nbsp;Remove&nbsp;&nbsp;&nbsp;
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
      <!-- /.row -->

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

