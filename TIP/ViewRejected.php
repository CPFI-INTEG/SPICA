<?php

    if(session_status() != PHP_SESSION_ACTIVE) {
      session_start();
    }

    $ID="";
    $Field1="";
    $Field2="";
    $Field3="";
    $Field4="";
    $Field5="";
    $Field6="";
    $Field7="";
    $Field8="";
    $Field9="";
    $Field10="";
    $Field11="";
    $Field12="";
    $Field13="";
    $Field14="";
    $Field15="";
    $Field16="";
    $Field17="";
    $Field18="";

    $StrID="";
    $StrYear="";
    $StrType="";
    $StrCorrectExpense="";
    $StrExpense="";
    $StrCorrectDivision="";
    $StrDivision="";
    $StrRemarks="";
    $StrPromoID="";

    
    if(isset($_GET['ID'])){
      $id=$_GET['ID'];
      include("model/dbcon.php");
      // update REJECTED SUBMITTED
      $sqlUpdateRejected="update tip.credit_memo set ispoke='0' where id=".$id;
      $stmtUpdateReject=sqlsrv_prepare($con,$sqlUpdateRejected);
      sqlsrv_execute($stmtUpdateReject);
      sqlsrv_free_stmt($stmtUpdateReject);
      //echo $sqlUpdateRejected;
    }

    if(isset($_GET['ID'])){
      $id=$_GET['ID'];
      //echo $id;
      include("model/dbcon.php");

      

      $sql="select dim5_Desc,division,attachment,RevisedDocumentNumber,RevisedAttachmentFile,attachment,remarks,ID,parent_Cd,parent_name,bp_parent_cd,bp_parent_name,doc_trans_Type,document_no,bp_Type_cd,cast(document_Date as nvarchar) as document_Date ,transaction_Amount,transaction_Reference,target_company,budget_desc,reporting_year,dim4_Cd,dim1_Desc from tip.Vw_BDMUserTagging where id=" .$id. "";
    //  echo $sql;
      $stmt=sqlsrv_query($con,$sql);
      while($row=sqlsrv_fetch_array($stmt,SQLSRV_FETCH_ASSOC)){
        $ID=$row['ID'];
        $Field1=$row['parent_Cd'];
        $Field2=$row['parent_name'];
        $Field3=$row['bp_parent_cd'];
        $Field4=$row['bp_parent_name'];
        $Field5=$row['doc_trans_Type'];
        $Field6=$row['document_no'];
        $Field7=$row['bp_Type_cd'];
        $Field8=$row['document_Date'];
        $Field9=$row['transaction_Amount'];
        $Field10=$row['transaction_Reference'];
        $Field11=$row['target_company'];
        $Field12=$row['budget_desc'];
        $Field13=$row['dim4_Cd'];
        $Field14=$row['dim1_Desc'];
        $Field15=$row['remarks'];
        $Field16=$row['dim5_Desc'];
        $Field17=$row['division'];
        $Field18=$row['attachment'];
        
      }
    }

    if(isset($_GET['ID'])){
      $id=$_GET['ID'];
      include("model/dbcon.php");
      $sql="select remarks,attachment from tip.Vw_BDMUserTagging where id=" .$id. "";
     // echo $sql;
      $stmt=sqlsrv_query($con,$sql);
      while($row=sqlsrv_fetch_array($stmt,SQLSRV_FETCH_ASSOC)){
        $Field1=$row['remarks'];
        $Field2=$row['attachment'];
      }
    }





    if(isset($_GET['ID'])){
      $id=$_GET['ID'];
      include("model/dbcon.php");
      $sqlShould="select id,dataid,year,type,correctexpense,expense,correctdivision,divsion,remarks,promoid from tip.TIR_ShouldBE  where dataid=" .$id. "";
//      echo $sqlShould;
      $stmtShould=sqlsrv_query($con,$sqlShould);
      while($rowShould=sqlsrv_fetch_array($stmtShould,SQLSRV_FETCH_ASSOC)){
          $StrID=$rowShould['id'];
          $StrYear=$rowShould['year'];
          $StrType=$rowShould['type'];
          $StrCorrectExpense=$rowShould['correctexpense'];
          $StrExpense=$rowShould['expense'];
          $StrCorrectDivision=$rowShould['correctdivision'];
          $StrDivision=$rowShould['divsion'];
          $StrRemarks=$rowShould['remarks'];
          $StrPromoID=$rowShould['promoid'];
      }
    }


    function ValidationYesNo($strData){
      if(isset($strData)){
          if ($strData=="YES"){
            $StrExpenseDisplay="<option active>YES</option>";
            $StrExpenseDisplay.="<option>NO</option>";
          }elseif($strData=="NO"){
            $StrExpenseDisplay="<option active>NO</option>";
            $StrExpenseDisplay.="<option>YES</option>";
          }  
          else{
            $StrExpenseDisplay="<option active>--</option>";
            $StrExpenseDisplay.="<option>YES</option>";
            $StrExpenseDisplay.="<option>NO</option>";
           }                                      
          
       }
       
       ECHO $StrExpenseDisplay;
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
      <h1>SHOULD BE</h1>
    </section>

    <!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) -->
        <!-- Left col -->
      <div class="row">
        <div class="col-xs-12">
            <div class="box box-primary">
                <br>
                <!-- form start -->
                <form class="form-horizontal" action='function/SaveRejected.php' method='POST' enctype="multipart/form-data">
                  <div class="box-body">
                    <div class="col-xs-6">

                              <div class="form-group">
                                <label for="inputEmail3" class="col-sm-4 control-label">Year :</label>

                                <div class="col-sm-8">
                                  <input type="hidden"  class="form-control" id="RejectID" name="RejectID"  value="<?php echo $ID ?>">
                                  <input type="hidden"  class="form-control" id="ActualID" name="ActualID"  value="<?php echo $StrID ?>">
                                  <input type="text" required class="form-control" id="Year" name="Year"  maxlength="4" placeholder="Input Year" value="<?php echo $StrYear ?>">
                                </div>
                              </div>

                             
                              <div class="form-group">
                                <label for="inputPassword3" class="col-sm-4 control-label">Under Correct Expense:</label>

                                <div class="col-sm-8">
                                   <select required class="form-control" name="CorrectExpense" id="CorrectExpense" onchange='Expense()'>
                                    <?php ValidationYesNo($StrCorrectExpense); ?>
                                  </select>
                                </div>
                              </div>

                              

                              <div class="form-group">
                                <label for="inputPassword3" class="col-sm-4 control-label">Under Correct Division :</label>

                                <div class="col-sm-8">
                                   <select  required class="form-control" name="CorrectDivision" id="CorrectDivision" onchange='Division()'>
                                      <?php ValidationYesNo($StrCorrectDivision); ?>
                                  </select>
                                </div>
                              </div>





                              <div class="form-group">
                                <label for="inputPassword3" class="col-sm-4 control-label">Remarks :</label>

                                <div class="col-sm-8">
                                   <textarea required class="form-control" rows="3" name="Remarks" id="Remarks" placeholder="Input Remarks"><?PHP echo $StrRemarks ?></textarea>
                                </div>
                              </div>
                    </div>


                    <div class="col-xs-6">
                        <!-- TYPE FIELD -->
                       <div class="form-group">
                              <label for="inputPassword3" class="col-sm-5 control-label">Type :</label>

                             <div class="col-sm-7">
                                 <select required class="form-control" name="Type" id="Type">

                                  <?php
                                    if($StrType!=""){
                                        $StrTypeDisplay="<option active>" .$StrType. "</option>";
                                        $StrTypeDisplay.="<option>--</option>";  
                                        $StrTypeDisplay.="<option>BEVERAGE</option>";
                                        $StrTypeDisplay.="<option>CANNED</option>";
                                        $StrTypeDisplay.="<option>FROZEN</option>";
                                     }
                                     else{
                                      $StrTypeDisplay="<option>--</option>";  
                                        $StrTypeDisplay.="<option>BEVERAGE</option>";
                                        $StrTypeDisplay.="<option>CANNED</option>";
                                        $StrTypeDisplay.="<option>FROZEN</option>";
                                     }
                                     ECHO $StrTypeDisplay;

                                  ?>
                                </select>
                              </div>
                        </div>


                          <!-- CORRECT CLASSIFICATION-->
                          <div class="form-group">
                                <label for="inputPassword3" class="col-sm-5 control-label">Correct Classification :</label>

                                <div class="col-sm-7">
                                  <select required class="form-control" name="InputClassification" id="InputClassification">
                                      <?php
                                        if(isset($StrExpense)){
                                          echo "<option active>" .$StrExpense. "</option>";
                                          echo "<option>--</option>";
                                        }else{
                                          echo "<option active>--</option>";
                                        }
                                      ?>
                                      
                                      <option>Additional Discount</option>
                                      <option>Anniversary Support</option>
                                      <option>Bad Orders</option>
                                      <option>Backload</option>
                                      <option>Bunding</option>
                                      <option>Convention</option>
                                      <option>Display Allowance</option>
                                      <option>Efficiency Discount</option>
                                      <option>Guaranteed Discount</option>
                                      <option>Listing Free</option>
                                      <option>Mailer</option>
                                      <option>Mercadising Cost</option>
                                      <option>Near Expiry</option>
                                      <option>Opening Support</option>
                                      <option>Penalties</option>
                                      <option>Penalties-Service level</option>
                                      <option>Price Adjustment</option>
                                      <option>Price Change Rebates</option>
                                      <option>Price Difference</option>
                                      <option>Price Off</option>
                                      <option>Product Highlight</option>
                                      <option>Promotional Support</option>
                                      <option>Prompt Payment</option>
                                      <option>Seasonnal Event</option>
                                      <option>Short Delivery</option>
                                      <option>Short Landed</option>
                                      <option>Short Payment</option>
                                      <option>Volumne Discount</option>
                                  </select>
                                </div>
                          </div>


                          <!-- CIORRECT DIVISION-->
                          <div class="form-group">
                                <label for="inputPassword3" class="col-sm-5 control-label">Correct Division :</label>

                                <div class="col-sm-7" >
                                   <select required class="form-control" name="InputDivision" id="InputDivision">
                                    <?php
                                      if(isset($StrDivision)){
                                        echo "<option active>" .$StrDivision. "</option>";
                                        echo "<option>--</option>";
                                      }else{
                                        echo "<option active>--</option>";
                                      }
                                    ?>
                                    <option>DPD</option>
                                    <option>MEAT</option>
                                    <option>MILK</option>
                                    <option>PMCI</option>
                                    <option>SARDINES</option>
                                    <option>TUNA</option>

                                  </select>
                                </div>
                          </div>


                          <!-- -PROMO ID -->
                          <div class="form-group">
                                <label for="inputPassword3" class="col-sm-5 control-label">Tax Reference / Promo ID :</label>

                                <div class="col-sm-7">
                                  <input type="text" class="form-control" id="PromoID" NAME="PromoID" placeholder="Input TAF Reference or Promo ID" VALUE="<?PHP ECHO $StrPromoID; ?>">
                                </div>
                          </div>

                    </div>
                  </div>

                <div class="box box-alert">
                      <div class="box-body">
                          <div class="col-xs-12">
                              <div class="form-group">
                                  <label> Reason for rejection :</label>
                                  <input type=hidden name="UpdateDataID" ID="UpdateDataID" VALUE="<?php echo $_GET['ID']?>">
                                  <textarea disabled class="form-control"   rows="3" ><?php if(isset($Field15)){ echo $Field15;}else{ echo "--";} ?></textarea>
                              </div>

                              <div class="form-group">
                                  <label > Attachment File :</label>
                                  <input NAME="FileImg"  accept="image/*" type="file">
                                  <input NAME="HoldIMG"  id="HoldIMG"   type="hidden"  value="<?php echo $Field18 ?>">
                              </div>  
                          </div>
                      </div>
                      <div class="box-footer">
                          <input type='button'  class='btn medium bg-blue' data-toggle='modal' data-target='#exampleModal' data-whatever='<?php echo $Field18 ?>' value="View Attachment">

                          <button type="submit" class="btn medium bg-blue">Submit</button>
                          <?php
                             if(isset($_GET['Flag'])){
                                echo "<a href='Approved.php'><input type=button class='btn medium bg-red' value='Cancel'></a>    ";
                             }else{
                                echo "<a href='Index.php'><input type=button class='btn medium bg-red' value='Cancel'></a>    ";
                             }
                          ?>
                      </div>
                  </div>

                  <!-- /.box-body -->
                </form>
            </div>
            <div class="box box-info">
              <div class="box-header with-border">
                <i class="fa fa-book"></i>

                <h3 class="box-title">Selected Details</h3>
              </div>
                <br>
                <!-- form start -->
                <form class='form-horizontal' >
                     <div class='box-body'>
                        <div class='col-xs-6'>
                                  <div class='form-group'>
                                    <label class='col-sm-4 control-label'>Parent Details :</label>

                                    <div class='col-sm-8'>
                                    <input type='hidden' class='form-control'  id='SelectedID' name='SelectedID' value='<?PHP ECHO $ID ?>'>
                                      <input type='text' class='form-control'  disabled value="<?php echo "(".$Field1.") ".$Field2 ?>">
                                    </div>
                                  </div>

                                  <div class='form-group'>
                                    <label class='col-sm-4 control-label'>Customer Details :</label>

                                    <div class='col-sm-8'>
                                      <input type='text' class='form-control'  disabled value='<?php echo "(".$Field3.") ".$Field4 ?>' >
                                    </div>
                                  </div>


                                  <div class='form-group'>
                                    <label class='col-sm-4 control-label'>Doc. Type:</label>

                                    <div class='col-sm-5'>
                                      
                                      <input type='text' class='form-control'  disabled value='<?php echo $Field5 ?>'>
                                    </div>

                                    <label class='col-sm-1 control-label'>BP:</label>

                                    <div class='col-sm-2'>
                                      
                                      <input type='text' class='form-control'  disabled value='<?php echo $Field7 ?>'>
                                    </div>
                                  </div>

                                  <div class='form-group'>
                                    <label class='col-sm-4 control-label'>Budget :</label>

                                    <div class='col-sm-5'>
                                      <input type='text' class='form-control'  disabled value='<?php echo $Field12 ?>'>
                                    </div>

                                    <label class='col-sm-1 control-label'>Yr:</label>

                                    <div class='col-sm-2'>
                                      <input type='text' class='form-control'  disabled value='<?php echo$Field13 ?>'>
                                    </div>

                                  </div>
                                  <div class='form-group'>
                                    <label class='col-sm-4 control-label'>Reference :</label>
                                    <div class='col-sm-8'>
                                      <input type='text' class='form-control'  disabled value='<?php echo $Field10 ?>'>
                                    </div>
                                  </div>
                        </div>



                        <div class='col-xs-6'>
                                  <div class='form-group'>
                                    <label class='col-sm-4 control-label'>Document Details:</label>

                                    <div class='col-sm-8'>
                                     <input type='text' class='form-control'  disabled value='<?php echo "(".$Field6.") ".$Field8 ?>'>
                                    </div>
                                  </div>

                                   <div class='form-group'>
                                    <label class='col-sm-4 control-label'>Activity Type :</label>

                                    <div class='col-sm-8'>
                                      <input type='text' class='form-control'  disabled value='<?php echo $Field14 ?>'>
                                    </div>
                                  </div>


                                  <div class='form-group'>
                                    <label class='col-sm-4 control-label'>Amount :</label>

                                    <div class='col-sm-8'>
                                      <input type='text' class='form-control'  disabled value='<?php echo $Field9 ?>'>
                                    </div>
                                  </div>

                                  <div class='form-group'>
                                  <label class='col-sm-4 control-label'>Target Company :</label>

                                    <div class='col-sm-4'>
                                      
                                     <input type='text' class='form-control'  disabled value='<?php echo $Field11 ?>'>
                                    </div>

                                    <label class='col-sm-1 control-label'>Type:</label>

                                    <div class='col-sm-3'>
                                      
                                    <input type='text' class='form-control'  disabled value='<?php echo $Field16 ?>'>
                                    </div>
                                  </div>

                                  <div class='form-group'>
                                    <label class='col-sm-4 control-label'>Business Units :</label>

                                    <div class='col-sm-8'>
                                      <input type='text' class='form-control'  disabled value='<?php echo $Field17 ?>'>
                                    </div>
                                  </div>
                        </div>
                      </div>
                </form>
          </div>

            
          </div>

      </div>
      <!-- /.row (main row) -->

      <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                  <h4 class="modal-title">View Attachment</h4>
                </div>
                <div class="modal-body">
                  <form  class='form-horizontal'>
                      <img src=""   id="image_from_url" width="550px" height="400px">
                    <div class="modal-footer">
                      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                  </form>
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

<script>
  $('#exampleModal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget) // Button that triggered the modal
    var recipient = button.data('whatever') // Extract info from data-* attributes
    // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
    // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.

    
    
    $("#image_from_url").attr('src','images/'+recipient);
  //  modal.find('.modal-body input').val(recipient)
  })

  function Expense() {
    var CorrectExpense = document.getElementById("CorrectExpense").value;
    
    if(CorrectExpense!="YES"){
       document.getElementById("InputClassification").disabled=false;
       document.getElementById("InputClassification").placeholder="Input Correct Classification";
    }
    else{
      document.getElementById("InputClassification").disabled=true;
      document.getElementById("InputClassification").value="--";
      
    }
  }

   function Division() {
    var CorrectDivision = document.getElementById("CorrectDivision").value;    
    
    if(CorrectDivision!="YES"){
       document.getElementById("InputDivision").disabled=false;
    }
    else{
      document.getElementById("InputDivision").disabled=true;
      document.getElementById("InputDivision").value="--";
    }
  }
</script>





</body>
</html>

