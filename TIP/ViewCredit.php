<?php

    if(session_status() != PHP_SESSION_ACTIVE) {
      session_start();
    }

 

    $StrID="";
    $StrYear="";
    $StrType="";
    $StrCorrectExpense="";
    $StrExpense="";
    $StrCorrectDivision="";
    $StrDivision="";
    $StrRemarks="";
    $StrPromoID="";

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

    //JV VARIABLE
    $JVField1="";
    $JVField2="";
    $JVField3="";
    $JVField4="";
    $JVField5="";
    $JVField6="";
    $JVField7="";
    $JVField8="";
    $JVField9="";
    $JVField10="";
    $JVField11="";
    $JVField12="";
    $JVField13="";
    $JVField14="";
    $JVField15="";
    $JVField16="";
    $JVField17="";


    if(isset($_GET['ID'])){
      $id=$_GET['ID'];
      include("model/dbcon.php");
      $sql="select dim5_Desc,division,remarks,ID,parent_Cd,parent_name,bp_parent_cd,bp_parent_name,doc_trans_Type,document_no,bp_Type_cd,cast(document_Date as nvarchar) as document_Date ,transaction_Amount,transaction_Reference,target_company,budget_desc,reporting_year,dim4_Cd,dim1_Desc from tip.Vw_BDMUserTagging where id=" .$id. "";
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
      }
    }

    if(isset($_GET['ID'])){
      $id=$_GET['ID'];
      include("model/dbcon.php");
      $sqlShould="select id,dataid,year,type,correctexpense,expense,correctdivision,divsion,remarks,promoid from tip.TIR_ShouldBE  where dataid=" .$id. "";
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

    //FOR JV DATA
    if(isset($_GET['ID'])){
      $id=$_GET['ID'];
      include("model/dbcon.php");
      $sqlShould="select id,dataid,year,type,correctexpense,expense,correctdivision,divsion,remarks,promoid from tip.TIR_ShouldBE  where dataid=" .$id. "";
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
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
      
  </head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

  <header class="main-header">
    <!-- Logo -->
    <a  class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b>TIP</b></span>
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
        <h1>SHOULD BE</h1>
     </section>
     <section class="content-header">
      
   
    <div class="row">
         <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
            <div class="modal-dialog modal-lg" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                  <!--<h4 class="modal-title" id="exampleModalLabel">Actual CM Dcoumnent Number : </h4>-->
                  <b><h4>JV Details</h2></b>

                </div>
                <div class="modal-body">
                    <form  class='form-horizontal' action='function/UpdateRevised.php' method="post"   enctype="multipart/form-data" >
                       <table id="example1" class="table table-bordered table-striped">
                            <thead>
                              <tr>
                                  <th>Ledger Account</th>
                                  <th>Dim1</th>
                                  <th>Dim2</th>
                                  <th>Dim3</th>
                                  <th>Dim4</th>
                                  <th>Dim5</th>
                                  <th>Amount</th>
                                  <th>Reversal Debit/Credit</th>
                                  <th>Target Company</th>
                              </tr>
                            </thead>

                            <tbody>
                              <?php
                                  include("model/dbcon.php");
                                  $sql="select * from [dbo].[TIP_JV_DOC_FOR_UPLOAD] where ID=".$ID;
                                  //ECHO $sql;
                                  $stmt=sqlsrv_query($con,$sql);

                                  $strDisplay="";
                                   while($row=sqlsrv_fetch_array($stmt,SQLSRV_FETCH_ASSOC)){
                                      $strDisplay.="<tr>";
                                          $strDisplay.="<td>$row[LEDGER_ACCOUNT_CD]</td>";
                                          $strDisplay.="<td>$row[DIM1_CD]</td>";
                                          $strDisplay.="<td>$row[DIM2_CD]</td>";
                                          $strDisplay.="<td>$row[DIM3_CD]</td>";
                                          $strDisplay.="<td>$row[DIM4_CD]</td>";
                                          $strDisplay.="<td>$row[DIM5_CD]</td>";
                                          $strDisplay.="<td>$row[TRANSACTION_AMOUNT]</td>";
                                          $strDisplay.="<td>$row[REVERSAL_DBCR]</td>";
                                          $strDisplay.="<td>$row[TARGET_COMPANY]</td>";
                                      $strDisplay.="</tr>";
                                    }

                                      echo $strDisplay;
                              ?>
                            </tbody>

                            
                        </table>
                    </form>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>
                
              </div>
            </div>
          </div>


          <div class="modal fade" id="exampleModal1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                  <h4 class="modal-title" id="exampleModalLabel">REASON FOR DISAPPROVE : </h4>
                </div>
                <div class="modal-body">

                  <form class="form-horizontal" action='function/UpdateDisApprove.php' method='POST' enctype="multipart/form-data">
                      <div class="box-body">
                          <div class="col-xs-12">
                              <div class="form-group">
                                  <input type=HIDDEN  name="DisID" ID="DisID" VALUE="<?php echo $_GET['ID']?>">
                                  <textarea class="form-control" name="Disapproved" id="Disapproved"  rows="3" placeholder="Please indicate the reason ..."><?php if(isset($Field15)){ echo $Field15;} ?></textarea>
                              </div>    
                          </div>
                        </div>


                        <div class="modal-footer">
                          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                          <button type="submit" class="btn btn-primary" >Submit</button>
                        </div>
                    
                  </form>

                   


                </div>
                
              </div>
            </div>
          </div>



        <div class="col-xs-12">
            <div class="box box-info">
               <div class="box-header with-border">
                  <i class="fa fa-book"></i>

                  <h3 class="box-title">BDM Entries</h3>
                </div>
                <br>
                <!-- form start -->
                <form class="form-horizontal" >
                  <div class="box-body">
                    <div class="col-xs-6">

                              <div class="form-group">
                                <label for="inputEmail3" class="col-sm-4 control-label">Year :</label>

                                <div class="col-sm-8">
                                  
                                  <input type="text" class="form-control" id="inputEmail3" disabled value="<?php echo $StrYear ?>">
                                </div>
                              </div>

                             
                              <div class="form-group">
                                <label for="inputPassword3" class="col-sm-4 control-label">Under Correct Expense:</label>

                                <div class="col-sm-8">
                                  <input type="text" class="form-control" id="inputEmail3" disabled value="<?php echo $StrCorrectExpense ?>">
                                </div>
                              </div>

                              

                              <div class="form-group">
                                <label for="inputPassword3" class="col-sm-4 control-label">Under Correct Division :</label>

                                <div class="col-sm-8">
                                  <input type="text" class="form-control" id="inputEmail3" disabled value="<?php echo $StrCorrectDivision ?>">
                                </div>
                              </div>





                              <div class="form-group">
                                <label for="inputPassword3" class="col-sm-4 control-label">Remarks :</label>

                                <div class="col-sm-8">
                                  <input type="text" class="form-control" id="inputEmail3" disabled value="<?php echo $StrRemarks ?>">
                                </div>
                              </div>
                    </div>


                    <div class="col-xs-6">
                        <!-- TYPE FIELD -->
                       <div class="form-group">
                              <label for="inputPassword3" class="col-sm-5 control-label">Type :</label>

                             <div class="col-sm-7">
                              <input type="text" class="form-control" id="inputEmail3" disabled value="<?php echo $StrType ?>">
                            </div>
                        </div>


                          <!-- CORRECT CLASSIFICATION-->
                          <div class="form-group">
                                <label for="inputPassword3" class="col-sm-5 control-label">Correct Classification :</label>

                                <div class="col-sm-7">
                                  <input type="text" class="form-control" id="inputEmail3" disabled value="<?php echo $StrExpense ?>">
                                </div>
                          </div>


                          <!-- CIORRECT DIVISION-->
                          <div class="form-group">
                                <label for="inputPassword3" class="col-sm-5 control-label">Correct Division :</label>

                                <div class="col-sm-7">
                                  <input type="text" class="form-control" id="inputEmail3" disabled value="<?php echo $StrDivision ?>">
                                </div>
                          </div>


                          <!-- -PROMO ID -->
                          <div class="form-group">
                                <label for="inputPassword3" class="col-sm-5 control-label">Tax Reference / Promo ID :</label>

                                <div class="col-sm-7">
                                  <input type="text" class="form-control" id="inputEmail3" disabled value="<?php echo $StrPromoID ?>">
                                </div>
                          </div>

                    </div>
                  </div>

                </form>
              </div>

              <!--
                <div class="box box-info">
                       <div class="box-header with-border">
                          <i class="fa fa-book"></i>

                          <h3 class="box-title">JV Details</h3>
                        </div>
                        <br>
                        <form class='form-horizontal' >
                             <div class='box-body'>
                                <div class='col-xs-6'>
                                          <div class='form-group'>
                                            <label class='col-sm-4 control-label'>RCJN :</label>

                                            <div class='col-sm-8'>
                                            <input type='hidden' class='form-control'  id='SelectedID' name='SelectedID' value='<?PHP ECHO $ID ?>'>
                                              <input type='text' class='form-control'  disabled value="<?php echo "(".$Field1.") ".$Field2 ?>">
                                            </div>
                                          </div>

                                          <div class='form-group'>
                                            <label class='col-sm-4 control-label'>Line Number :</label>

                                            <div class='col-sm-8'>
                                              <input type='text' class='form-control'  disabled value='<?php echo "(".$Field3.") ".$Field4 ?>' >
                                            </div>
                                          </div>

                                           <div class='form-group'>
                                            <label class='col-sm-4 control-label'>BP Code :</label>

                                            <div class='col-sm-8'>
                                              <input type='text' class='form-control'  disabled value='<?php echo "(".$Field3.") ".$Field4 ?>' >
                                            </div>
                                          </div>

                                           <div class='form-group'>
                                            <label class='col-sm-4 control-label'>Leac :</label>

                                            <div class='col-sm-8'>
                                              <input type='text' class='form-control'  disabled value='<?php echo "(".$Field3.") ".$Field4 ?>' >
                                            </div>
                                          </div>

                                           <div class='form-group'>
                                            <label class='col-sm-4 control-label'>Amount :</label>

                                            <div class='col-sm-8'>
                                              <input type='text' class='form-control'  disabled value='<?php echo "(".$Field3.") ".$Field4 ?>' >
                                            </div>
                                          </div>

                                           <div class='form-group'>
                                            <label class='col-sm-4 control-label'>Cur :</label>

                                            <div class='col-sm-8'>
                                              <input type='text' class='form-control'  disabled value='<?php echo "(".$Field3.") ".$Field4 ?>' >
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
                                            <label class='col-sm-4 control-label'>DIM 1 :</label>

                                            <div class='col-sm-8'>
                                             <input type='text' class='form-control'  disabled value='<?php echo "(".$Field6.") ".$Field8 ?>'>
                                            </div>
                                          </div>

                                           <div class='form-group'>
                                            <label class='col-sm-4 control-label'>DIM 2 :</label>

                                            <div class='col-sm-8'>
                                              <input type='text' class='form-control'  disabled value='<?php echo $Field14 ?>'>
                                            </div>
                                          </div>


                                          <div class='form-group'>
                                            <label class='col-sm-4 control-label'>DIM 3 :</label>

                                            <div class='col-sm-8'>
                                              <input type='text' class='form-control'  disabled value='<?php echo $Field9 ?>'>
                                            </div>
                                          </div>

                                          <div class='form-group'>
                                            <label class='col-sm-4 control-label'>DIM 4 :</label>

                                            <div class='col-sm-8'>
                                              <input type='text' class='form-control'  disabled value='<?php echo $Field9 ?>'>
                                            </div>
                                          </div>

                                          <div class='form-group'>
                                            <label class='col-sm-4 control-label'>DIM 5 :</label>

                                            <div class='col-sm-8'>
                                              <input type='text' class='form-control'  disabled value='<?php echo $Field9 ?>'>
                                            </div>
                                          </div>

                                     
                                          <div class='form-group'>
                                            <label class='col-sm-4 control-label'>Rte 1 :</label>

                                            <div class='col-sm-8'>
                                              <input type='text' class='form-control'  disabled value='<?php echo $Field17 ?>'>
                                            </div>
                                          </div>

                                          <div class='form-group'>
                                            <label class='col-sm-4 control-label'>Rte 2 :</label>

                                            <div class='col-sm-8'>
                                              <input type='text' class='form-control'  disabled value='<?php echo $Field17 ?>'>
                                            </div>
                                          </div>

                                          <div class='form-group'>
                                            <label class='col-sm-4 control-label'>Rte 3 :</label>

                                            <div class='col-sm-8'>
                                              <input type='text' class='form-control'  disabled value='<?php echo $Field17 ?>'>
                                            </div>
                                          </div>
                                </div>
                              </div>
                        </form>
                </div>
              -->

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

              <div class="box-footer">
                <a href='index.php'><button  class="btn medium bg-blue">&nbsp;&nbsp;&nbsp;Back&nbsp;&nbsp;&nbsp;</button></a>
                <button type='button' class='btn medium bg-blue' data-toggle='modal' data-target='#exampleModal' data-whatever='JV Documents'>View JV Documents</button>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

                <a href='function/UpdateRevised.php?ID=<?php echo $_GET['ID']; ?>'><button type='button'  class='btn medium bg-blue'>&nbsp;&nbsp;Approve&nbsp;&nbsp;</button></a>
                <button type='button'  class='btn medium bg-green' data-toggle='modal' data-target='#exampleModal1' data-whatever='<?php echo $Field6 ?>'>Disapporve</button>

                
                
              </div>

             <!-- <div id="divTest">test here</div>-->
          
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
  $('#exampleModal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget) // Button that triggered the modal
    var recipient = button.data('whatever') // Extract info from data-* attributes
    // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
    // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
    var modal = $(this)
    modal.find('.modal-title').text('Actual CM Doument Number : ' + recipient)
  //  modal.find('.modal-body input').val(recipient)
  })

 //$('button[name=UpdateButton]').click(function(){
        
        
        //var DataValue=$('input[name=RevisedValue]').val();
        //var DataID=$(this).data("id");

      //  alert(DataValue);

        //$.ajax({
          //method: "POST",
          //url: "Function/UpdateRevised.php?test",
//          data: {ID:DataID,Value:DataValue}
        //}).done(function(msg){
//          $('#divTest').html(msg);
        //  window.open('index.php','_self') ;
      //  });


    //});










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

