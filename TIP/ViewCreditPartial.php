<?php

    if(session_status() != PHP_SESSION_ACTIVE) {
      session_start();
    }
    $UserType=$_SESSION['UserType']; // THIS IS THE FIELD OF BDM NAME

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
    $Field19="";
    $Field20="";
    $Field21="";  
    $Field22="";
    $Field23="";
    $Field24="";
    $Field25="";

    $StrID="";
    $StrYear="";
    $StrType="";
    $StrCorrectExpense="";
    $StrDescription="";
    $StrCorrectDivision="";
    $StrDivision="";
    $StrRemarks="";
    $StrPromoID="";

    $FinalID="";

    if(isset($_GET['CreditID'])){
      $FinalID=$_GET['CreditID'];
    }elseif(isset($_GET['ID'])){
      $FinalID=$_GET['ID'];
    }



    if(isset($FinalID)){
      $id=$FinalID;
      include("model/dbcon.php");

       $sql="select RevisedAttachmentFile,dim4_cd,remarks1,reviseddocumentnumber,[PARTIAL REMARKS] AS partialRemarks,bp_type_Cd,cast(invoice_Date as nvarchar)  as invoice_Date,budget_desc,invoice_month,ID,dim5_desc_division,bp_code,business_partner_name,parent_name,parent_Cd,district,name,invoice,pr_number,cast(or_Date as nvarchar)  as or_Date,transaction_Amount,dim1_Desc,remarks,dim4_Cd,invoice_year,division,transaction_sid from tip.V_PARTIAL_BALANCE where id=" .$id. "";

      //echo $sql;
      $stmt=sqlsrv_query($con,$sql);
      while($row=sqlsrv_fetch_array($stmt,SQLSRV_FETCH_ASSOC)){
        $ID=$row['ID'];
        $Field1=$row['dim5_desc_division'];
        $Field2=$row['bp_code'];
        $Field3=$row['business_partner_name'];
        $Field4=$row['parent_name'];
        $Field5=$row['parent_Cd'];
        $Field6=$row['district'];
        $Field7=$row['name'];
        $Field8=$row['invoice'];
        $Field9=$row['pr_number'];
        $Field10=$row['or_Date'];
        $Field11=$row['transaction_Amount'];
        $Field12=$row['dim1_Desc'];
        $Field13=$row['remarks'];
        $Field14=$row['invoice_year'];
        $Field15=$row['division'];
        $Field16=$row['transaction_sid'];
        $Field17=$row['invoice_month'];
        $Field18=$row['budget_desc'];
        $Field19=$row['bp_type_Cd'];
        $Field20=$row['invoice_Date'];
        $Field21=$row['partialRemarks'];
        $Field22=$row['reviseddocumentnumber'];
        $Field23=$row['remarks1'];
        $Field24=$row['dim4_cd'];
        $Field25=$row['RevisedAttachmentFile'];
        
         
        
        


      }
    }

    if(isset($FinalID)){
      $id=$FinalID;
      include("model/dbcon.php");
      $sqlShould="select id,dataid,year,type,correctexpense,Description,correctdivision,remarks,promoid from tip.PB_ShouldBE  where dataid=" .$id. "";
  //    echo $sqlShould;
      $stmtShould=sqlsrv_query($con,$sqlShould);
      while($rowShould=sqlsrv_fetch_array($stmtShould,SQLSRV_FETCH_ASSOC)){
          $StrID=$rowShould['id'];
          $StrYear=$rowShould['year'];
          $StrType=$rowShould['type'];
          $StrCorrectExpense=$rowShould['correctexpense'];
          $StrDescription=$rowShould['Description'];
          $StrDivision=$rowShould['correctdivision'];
          $StrRemarks=$rowShould['remarks'];
          $StrPromoID=$rowShould['promoid'];
      }
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
    <a href="" class="logo">
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
      <h1>PARTIAL BALANCE DETAILS</h1>
    </section>

    <!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) -->
        <!-- Left col -->   
      <div class="row">

        <div class="col-xs-12">
            <div class="box box-info">
              <div class="box-header with-border">
                <i class="fa fa-book"></i>

                <h3 class="box-title">BDM Entries</h3>
              </div>
                <br>
                <!-- form start -->
                <form class="form-horizontal" action='function/SaveShouldPartial.php' method='POST'>
                  <div class="box-body">
                    <div class="col-xs-6">

                              <div class="form-group">
                                <label for="inputEmail3" class="col-sm-4 control-label">Year :</label>

                                <div class="col-sm-8">
                                  <input type="hidden"  class="form-control" id="DataID" name="DataID"  value="<?php echo $ID ?>">
                                  <input type="hidden"  class="form-control" id="ActualID" name="ActualID"  value="<?php echo $StrID ?>">
                                  <input type="text" disabled required class="form-control" id="Year" name="Year" placeholder="Input Year" value="<?php echo $StrYear ?>">
                                </div>
                              </div>

                             
                              <div class="form-group">
                                <label for="inputPassword3" class="col-sm-4 control-label">Description :</label>

                                <div class="col-sm-8">
                                    <input type="text" disabled required class="form-control" value="<?php echo $StrDescription ?>">
                                </div>
                              </div>

                              

                              





                              <div class="form-group">
                                <label for="inputPassword3" class="col-sm-4 control-label">Remarks :</label>

                                <div class="col-sm-8">
                                   <textarea  disabled class="form-control" rows="3"><?PHP echo $StrRemarks ?></textarea>
                                </div>
                              </div>
                    </div>


                    <div class="col-xs-6">
                        <!-- TYPE FIELD -->
                       <div class="form-group">
                              <label for="inputPassword3" class="col-sm-5 control-label">Type :</label>

                             <div class="col-sm-7">
                                <input type="text" disabled required class="form-control" value="<?php echo $StrType ?>">
                              </div>
                        </div>


                          <!-- CORRECT CLASSIFICATION-->
                          <div class="form-group">
                                <label for="inputPassword3" class="col-sm-5 control-label">Correct Classification :</label>

                                <div class="col-sm-7">
                                  <input type="text" disabled required class="form-control" value="<?php echo $StrCorrectExpense ?>">
                                </div>
                          </div>


                          <!-- CIORRECT DIVISION-->
                          <div class="form-group">
                                <label for="inputPassword3" class="col-sm-5 control-label">Correct Division :</label>

                                <div class="col-sm-7" >
                                  <input type="text" disabled required class="form-control" value="<?php echo $StrDivision ?>">
                                </div>
                          </div>


                          <!-- -PROMO ID -->
                          <div class="form-group">
                                <label for="inputPassword3" class="col-sm-5 control-label">TAF Reference / Promo ID :</label>

                                <div class="col-sm-7">
                                    <input type="text" disabled required class="form-control" value="<?php echo $StrPromoID ?>">
                                </div>
                          </div>

                    </div>


                    
                   
                  </div>
                </form>
              </div>
            
        </div>
           <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                  <h4 class="modal-title" id="exampleModalLabel">Input Data  </h4>
                </div>
                <div class="modal-body">
                  <form class="form-horizontal" action='function/UpdateDisApprovePartial.php' method='POST' enctype="multipart/form-data">
                      <div class="box-body">
                        <div class="form-group">
                          <label class='col-sm-4 control-label'>CM Document No. :</label>
                          <div class='col-sm-6'>
                            
                            <input type='hidden' required class='form-control' id="AppID" name="AppID" VALUE="<?php echo $_GET['ID']?>">
                            <input type='text' required class='form-control' id="DocumentNumber" name="DocumentNumber" value="<?php if(isset($Field22)){ echo $Field22;} ?>">
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

                <h3 class="box-title">Selected Details</h3>
              </div>
                <br>
                <form class='form-horizontal' >
                     <div class='box-body'>
                        <div class='col-xs-6'>
                                  <div class='form-group'>
                                    <label class='col-sm-4 control-label'>Parent Details :</label>

                                    <div class='col-sm-8'>
                                    <input type='hidden' class='form-control'  id='SelectedID' name='SelectedID' value='<?PHP ECHO $ID ?>'>
                                      <input type='text' class='form-control'  disabled value="<?php echo "(".$Field5.") ".$Field4 ?>">
                                    </div>
                                  </div>

                                  <div class='form-group'>
                                    <label class='col-sm-4 control-label'>Customer Details :</label>

                                    <div class='col-sm-8'>
                                      <input type='text' class='form-control'  disabled value='<?php echo "(".$Field2.") ".$Field3 ?>' >
                                    </div>
                                  </div>


                                  <div class='form-group'>
                                    <label class='col-sm-4 control-label'>District :</label>
                                    <div class='col-sm-8'>
                                      <input type='text' class='form-control'  disabled value='<?php echo $Field6 ?>'>
                                    </div>
                                  </div>


                                  <div class='form-group'>
                                    <label class='col-sm-4 control-label'>Division :</label>
                                    <div class='col-sm-5'>
                                      <input type='text' class='form-control'  disabled value='<?php echo $Field1 ?>'>
                                    </div>

                                    <label class='col-sm-1 control-label'>BP:</label>
                                    <div class='col-sm-2'>
                                      <input type='text' class='form-control'  disabled value='<?php echo $Field19 ?>'>
                                    </div>

                                  </div>
                                        
                                  <div class='form-group'>
                                    <label class='col-sm-4 control-label'>Amount :</label>
                                    <div class='col-sm-8'>
                                      <input type='text' class='form-control'  disabled value='<?php echo $Field11 ?>'>
                                    </div>
                                  </div>


                                  <!--
                                  <div class='form-group'>
                                    <label class='col-sm-4 control-label'>Transaction Count :</label>

                                    <div class='col-sm-8'>
                                      
                                      <input type='text' class='form-control'  disabled value='<?php  $Field5 ?>'>
                                    </div>
                                  </div>
                                -->


                                  <div class='form-group'>
                                    <label class='col-sm-4 control-label'>Remarks :</label>
                                    <div class='col-sm-8'>
                                      <textarea name='Remarks' class='form-control'disabled><?php echo $Field13 ?></textarea>
                                    </div>
                                  </div>

                              

                        </div>

                                  



                        <div class='col-xs-6'>
                                  <div class='form-group'>
                                    <label class='col-sm-4 control-label'>Invoice Details:</label>

                                    <div class='col-sm-8'>
                                     <input type='text' class='form-control'  disabled value='<?php echo "".$Field8." and ".$Field17."/".$Field20 ?>'>
                                    </div>
                                  </div>  

                                   <div class='form-group'>
                                    <label class='col-sm-4 control-label'>PR Number :</label>

                                    <div class='col-sm-8'>
                                      <input type='text' class='form-control'  disabled value='<?php echo $Field9 ?>'>
                                    </div>
                                  </div>
                                  
                                  <div class='form-group'>
                                    <label class='col-sm-4 control-label'>Transaction Category :</label>

                                    <div class='col-sm-8'>
                                      <input type='text' class='form-control'  disabled value='<?php echo $Field16 ?>'>
                                    </div>
                                  </div>


                                  <div class='form-group'>

                                    <label class='col-sm-4 control-label'>Nature / Classification :</label>

                                    <div class='col-sm-8'>
                                      
                                    <input type='text' class='form-control'  disabled value='<?php echo $Field12 ?>'>
                                    </div>
                                  </div>

                                  <div class='form-group'>

                                    <label class='col-sm-4 control-label'>Budget Type:</label>

                                    <div class='col-sm-8'>
                                      
                                    <input type='text' class='form-control'  disabled value='<?php echo $Field18 ?>'>
                                    </div>
                                  </div>

                                  <div class='form-group'>
                                    <label class='col-sm-4 control-label'>OR Date :</label>

                                    <div class='col-sm-5'>
                                      <input type='text' class='form-control'  disabled value='<?php echo $Field10 ?>'>
                                    </div>

                                    
                                  </div>

                                  <div class='form-group'>
                                    <label class='col-sm-4 control-label'>Expense Year :</label>
                                    <div class='col-sm-5'>
                                      <input type='text' class='form-control'  disabled value='<?php echo substr($Field24,2,6) ?>'>
                                    </div>
                                  </div>
                        </div>
                      </div>
                </form>
            </div>
        </div>


           <div class="modal fade" id="exampleModal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="exampleModalLabel">DISAPPROVE DETAILS</h4>
                  </div>
                  <div class="modal-body">
                  
                  <?php
                    if($UserType=="Credit and Collection Supervisor" or $UserType=="Credit Analyst"){
                  ?>
                      <form class="form-horizontal" action='function/UpdateDisApprovePartial.php' method='POST' enctype="multipart/form-data">
                  <?php
                    }elseif($UserType=="Sales Finance Assistant"){
                  ?>
                      <form class="form-horizontal" action='function/UpdateReplyDisapprove.php' method='POST' enctype="multipart/form-data">
                  <?php
                    }
                  ?>

                        <div class="box-body">
                            <div class="col-xs-12">
                              <?PHP
                                if($UserType=="Sales Finance Assistant"){// to know if this is SALES finance
                              ?>
                                  <div class="form-group">
                                    <label >Reason why disapprove (Credit and Collection) :</label>
                                    <input type=hidden name="DataID" ID="DataID" VALUE="<?php echo $_GET['ID']?>">
                                    <textarea class="form-control" disabled rows="3"><?php if(isset($Field21)){ echo str_replace("(Disapproved)", "", $Field21);} ?></textarea>
                                  </div>
                              <?PHP
                                }elseif($UserType=="Credit and Collection Supervisor" or $UserType=="Credit Analyst"){
                              ?>
                                <div class="form-group">
                                  <label >Reply (Sales Control Group) :</label>
                                    <input type=hidden name="DataID" ID="DataID" VALUE="<?php echo $_GET['ID']?>">
                                    <textarea class="form-control" disabled  rows="3"><?php if(isset($Field23)){ echo str_replace("(Reply Disapproved)", "", $Field23);} ?> </textarea>
                                </div>
                              <?php
                                }
                              ?>

                              <?PHP
                                if($UserType=="Sales Finance Assistant"){// to know if this is SALES finance
                              ?>
                                <div class="form-group">
                                  <label >Reply (Sales Control Group) :</label>
                                    <input type=hidden name="DataID" ID="DataID" VALUE="<?php echo $_GET['ID']?>">
                                    <textarea class="form-control" name="replyDis" id="replyDis"  rows="3"><?php if(isset($Field23)){ echo str_replace("(Reply Disapproved)", "", $Field23);} ?> </textarea>
                                </div>
                              <?PHP
                                }elseif($UserType=="Credit and Collection Supervisor" or $UserType=="Credit Analyst"){
                              ?>
                                <div class="form-group">
                                  <label >Reason why disapprove (Credit and Collection) :</label>
                                  <input type=hidden name="DisID" ID="DisID" VALUE="<?php echo $_GET['ID']?>">
                                  <textarea class="form-control" name="Disapproved" id="Disapproved"  rows="3"><?php if(isset($Field21)){ echo str_replace("(Disapproved)", "", $Field21);} ?></textarea>
                                </div>
                              <?php
                                }
                              ?>

                                <div class="form-group">
                                    <label > Attachment File :</label>
                                    <input NAME="FileImg"  accept="image/*" type="file" value="<?php echo $Field25 ?>">
                                    <input NAME="HoldIMG"  id="HoldIMG"   type="hidden"  value="<?php echo $Field25 ?>">
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


          <div class="modal fade" id="exampleModal1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                  <h4 class="modal-title" id="exampleModalLabel">REASON FOR DISAPPROVE : </h4>
                </div>
                <div class="modal-body">

                  <form class="form-horizontal" action='function/UpdateDisApprovePartial.php' method='POST' enctype="multipart/form-data">
                        <div class="box-body">
                            <div class="col-xs-12">
                                <div class="form-group">
                                    <input type=hidden name="DisID" ID="DisID" VALUE="<?php echo $_GET['ID']?>">
                                    <textarea class="form-control" name="Disapproved" id="Disapproved"  rows="3" placeholder="Please indicate the reason ..."><?php if(isset($Field21)){ echo $Field21;} ?></textarea>
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

        <?php
          if(isset($_GET['ID'])){
        ?>
        <div class="col-xs-12">
        
                <div class="box-footer">
                  <?php
                      if(isset($_GET['MoreInfoID'])){ // if the source data is from DASHBOARD
                        echo "<a href='IndexPartial.php'><input type=button class='btn medium bg-red' value='Back'></a>    ";
                      }else{ // PAG HINDI PANG DASHBOARD PAG NAG CLICK NG BACK
                             if(isset($_GET['Flag'])){
                                echo "<a href='ApprovedPartial.php'><input type=button class='btn medium bg-blue' value='Cancel'></a>    ";
                             }else{
                                echo "<a href='IndexPartial.php'><input type=button class='btn medium bg-blue' value='Cancel'></a>    ";
                                echo "<a href='function/UpdateDisApprovePartial.php?$_GET[ID]'><button class='btn medium bg-blue'>&nbsp;&nbsp;&nbsp;Approve&nbsp;&nbsp;&nbsp;</button></a>";
                               // echo "<button type='button'  class='btn medium bg-blue' data-toggle='modal' data-target='#exampleModal' data-whatever='<?php echo $Field9 '>For CM</button>";
                                echo "<button type='button'  class='btn medium bg-green' data-toggle='modal' data-target='#exampleModal2' data-whatever='<?php echo $Field6 ?>'>Disapprove</button>";
                             }
                      }
                  ?>
                  
                </div>
                <!-- /.box-body -->
        <?php
            }elseif(isset($_GET['CreditID'])){
              
                ECHO "<div class='box-footer'>";
                    echo "<a href='indexPartial.php'><button class='btn medium bg-blue'>&nbsp;&nbsp;&nbsp;Back&nbsp;&nbsp;&nbsp;</button></a>";
                    echo "<a href='function/UpdateDisApprovePartial.php?$_GET[CreditID]'><button class='btn medium bg-blue'>&nbsp;&nbsp;&nbsp;Approve&nbsp;&nbsp;&nbsp;</button></a>";
                   
                    echo "<button type='button'  class='btn medium bg-green' data-toggle='modal' data-target='#exampleModal2' data-whatever='<?php echo $Field6 ?>'>Disapprove</button>";
                  ECHO "</div>";
              
          }else{
        ?>

          
            
         <div class="col-xs-12">
          <div class="box-footer">
            <a href='indexPartial.php'><button class="btn medium bg-blue">&nbsp;&nbsp;&nbsp;Back&nbsp;&nbsp;&nbsp;</button></a>
            <a href='FUNCTION/UpdatePartialChecked.php?ID=<?PHP ECHO $_GET['ID'] ?>'><button class="btn medium bg-blue">Checked</button></a>
          </div>
        </div>
      </div>

      <?php
        }

      ?>
      <!-- /.row (main row) -->

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

  $('#exampleModal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget) // Button that triggered the modal
    var recipient = button.data('whatever') // Extract info from data-* attributes
    // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
    // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
    var modal = $(this)
    modal.find('.modal-title').text('Actual CM Doument Number')
  //  modal.find('.modal-body input').val(recipient)
  })
</script>





</body>
</html>

