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
    $StrExpense="";
    $StrCorrectDivision="";
    $StrDivision="";
    $StrRemarks="";
    $StrPromoID="";
    $StrBucketType="";
    $strAmountAlloted="";
    $strValidation="";

    $MEAT="";
    $DAIRY="";
    $TUNA="";
    $SARDINES="";
    $HUNTS="";
    $RMB="";
    $VITACOCO="";

    if(isset($_GET['ID']) or isset($_GET['InprogressID']) or isset($_GET['MoreInfoID'])){
      if(isset($_GET['ID'])){
        $id=$_GET['ID'];  
      }elseif(isset($_GET['InprogressID'])){
        $id=$_GET['InprogressID'];  
      }elseif(isset($_GET['MoreInfoID'])){
        $id=$_GET['MoreInfoID'];  
      }
      
      include("model/dbcon.php");
      $sql="select dim4_Cd,bp_type_Cd,cast(invoice_Date as nvarchar)  as invoice_Date,budget_desc,invoice_month,ID,dim5_desc_division,bp_code,business_partner_name,parent_name,parent_Cd,district,name,invoice,pr_number,cast(or_Date as nvarchar)  as or_Date,transaction_Amount,dim1_Desc,remarks,dim4_Cd,invoice_year,division,transaction_sid from tip.V_PARTIAL_BALANCE where id=" .$id. "";

    //  echo $sql;
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
        $Field21=$row['dim4_Cd'];
      }

      // FOR BUDGET DATA
      $SQLBudget="select * FROM tip.TIR_BudgetBreakdown where dataid=".$id;
      $stmtBudget=sqlsrv_query($con,$SQLBudget);
      while($rowBudget=sqlsrv_fetch_array($stmtBudget,SQLSRV_FETCH_ASSOC)){
        $MEAT=number_format(str_replace("--", "0", $rowBudget['MEAT']),2);
        $DAIRY=number_format(str_replace("--", "0", $rowBudget['DAIRY']),2);
        $TUNA=number_format(str_replace("--", "0", $rowBudget['TUNA']),2);
        $SARDINES=number_format(str_replace("--", "0", $rowBudget['SARDINES']),2);
        $HUNTS=number_format(str_replace("--", "0", $rowBudget['HUNTS']),2);
        $RMB=number_format(str_replace("--", "0", $rowBudget['RMB']),2);
        $VITACOCO=number_format(str_replace("--", "0", $rowBudget['VITACOCO']),2);

      }
    }

    if(isset($_GET['ID']) or isset($_GET['InprogressID']) or isset($_GET['MoreInfoID'])){
      if(isset($_GET['ID'])){
        $id=$_GET['ID'];  
      }elseif(isset($_GET['InprogressID'])){
        $id=$_GET['InprogressID'];  
      }elseif(isset($_GET['MoreInfoID'])){
        $id=$_GET['MoreInfoID'];  
      }
      
      include("model/dbcon.php");
      $sqlShould="select hasvalidation,Amount,BucketType,id,dataid,year,type,correctexpense,Description,correctdivision,remarks,promoid from tip.PB_ShouldBE  where dataid=" .$id. "";
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
          $StrBucketType=$rowShould['BucketType'];
          $strAmountAlloted=$rowShould['Amount'];
          $strValidation=$rowShould['hasvalidation'];
      }
    }


    function ValidationYesNo($strData){
      if(isset($strData)){
          if ($strData=="YES"){
            $StrExpenseDisplay="<option>YES</option>";
            $StrExpenseDisplay.="<option>--</option>";
            $StrExpenseDisplay.="<option>NO</option>";
          }elseif($strData=="NO"){
            $StrExpenseDisplay="<option>NO</option>";
            $StrExpenseDisplay.="<option>--</option>";
            $StrExpenseDisplay.="<option>YES</option>";
          }  
          else{
            $StrExpenseDisplay="<option>--</option>";
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
      <?php include("linkScriptPagesPartial.php");?>
      
  </head>
<body class="hold-transition skin-blue sidebar-mini" onload="Disabled()">
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
          <?php include("SideBarPartial.php");?>
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
                <!-- form start        action='function/SaveShouldPartial.php'        onsubmit="return InputClassification1()"      myFunctionCheckRemarks     -->
                <form class="form-horizontal" action='function/SaveShouldPartial.php' method='POST' onsubmit="return CheckRemarks()">
                      <div class="box-body">
                          <div class="col-xs-6">  

                                    <!-- -PROMO ID -->
                                    <div class="form-group">
                                          <label for="inputPassword3" class="col-sm-5 control-label">Reference Type :</label>
                                          <div class="col-sm-7">
                                            <select required class="form-control select2" style="width: 100%;"  name="PromoID" id="PromoID" onchange="LoadData()">
                                                <?php
                                                  if($StrPromoID!=""){
                                                    echo "<option active>" .$StrPromoID. "</option>";
                                                  }
                                                   echo "<option active>--</option>";
                                                    //echo "<option >ADD BACK</option>";
                                                    echo "<option >CONTRACTUAL TRADE TERMS</option>";
                                                    echo "<option >MERCHANDISING COST</option>";
                                                    echo "<option >OTHERS</option>";
                                                    echo "<option >TRADE OPERATIONAL INEFFICIENCIES</option>";
                                                    echo "<option >MULTIPLE PROMO ID</option>";
                                                    echo "<option >DA-2017</option>";


                                                  $strType="";
                                                  include("model/dbcon.php");
                                                  $sqlType="select distinct taf_Da_id from BDM_TAF_DA  where gt_username='".$parentCode."'";
                                                  echo $sqlType;
                                                  //and bu='".$BusinessUnit."'
                                                  $stmtType=sqlsrv_query($con,$sqlType);
                                                  while($rowType=sqlsrv_fetch_array($stmtType,SQLSRV_FETCH_ASSOC)){
                                                        $strType.="<option value=".str_replace(" ","", $rowType['taf_Da_id']).">" . str_replace(" ","", $rowType['taf_Da_id']). "</option>";
                                                  }

                                                  echo $strType;
                                                ?>
                                            </select>
                                           
                                            <?php

                                           //   if($Field12=="Trade Support"){
                                                //echo "<input required type='text' class='form-control' id='PromoID' NAME='PromoID' placeholder='Input TAF Reference or Promo ID' VALUE=" .$StrPromoID. ">";
                                              //}else{
                                                //echo "<input type='text' class='form-control' id='PromoID' NAME='PromoID' placeholder='Input TAF Reference or Promo ID' VALUE=" .$StrPromoID. ">";
                                              //}

                                            ?>
                                          </div>
                                    </div>


                                     

                                    <div class="form-group">
                                      <label for="inputEmail3" class="col-sm-5 control-label">Amount Budget : </label>

                                      <div class="col-sm-5">
                                        <input type="text"  class="form-control"  id="BudgetAlloted" name="BudgetAlloted"  value="<?php  echo $strAmountAlloted ?>">
                                        <input type="HIDDEN"  class="form-control" id="BudgetAlloted1" name="BudgetAlloted1"  value="<?php  echo $strAmountAlloted ?>">
                                      </div>
                                      
                                      <div class="col-sm-1">
                                        <button type='button' id="ViewDetails" name="ViewDetails"  class='btn medium bg-blue' data-toggle='modal' data-target='#exampleModal1' data-whatever='<?php echo $Field6 ?>'>View</button>
                                      </div>
                                      
                                    </div>
                              



                                    <div class="form-group">
                                      <label for="inputPassword3" class="col-sm-5 control-label">Remarks :</label>

                                      <div class="col-sm-7">
                                         <textarea  class="form-control" rows="6" name="Remarks" id="Remarks" placeholder="Input Remarks"><?PHP echo $StrRemarks ?></textarea>
                                      </div>
                                    </div>


                          </div>


                          <div class="col-xs-6" >
                               
                               
                                <div class="form-group">
                                   <label for="inputEmail3" class="col-sm-5 control-label">Year : *</label>
                                   <div class="col-sm-7">
                                        <input type="hidden"  class="form-control" id="InprogressID" name="InprogressID"  value="<?php if(isset($_GET['InprogressID'])){ echo $_GET['InprogressID'];} ?>">
                                        <input type="hidden"  class="form-control" id="DataID" name="DataID"  value="<?php echo $ID ?>">

                                        <input type="hidden"  class="form-control" id="ActualID" name="ActualID"  value="<?php echo $StrID ?>">
                                      <input type="text" required class="form-control" id="Year" name="Year" onkeypress="return isNumber(event)" maxlength="4" placeholder="Input Year" value="<?php echo $StrYear ?>">
                                      <input type="HIDDEN"  required class="form-control" id="Year1" name="Year1" onkeypress="return isNumber(event)" maxlength="4" placeholder="Input Year" value="<?php echo $StrYear ?>">

                                      <input type='HIDDEN' class='form-control'  NAME="CompareYear" id="CompareYear" value='<?php echo$Field21 ?>'>
                                    </div>
                                </div>

                                <!-- TYPE FIELD -->
                                 <div class="form-group">
                                        <label for="inputPassword3" class="col-sm-5 control-label">Type : *</label>
                                        <select required class="form-control hidden" name="Type1" id="Type1">
                                          <option><?php echo $StrType ?></option>
                                        </select>
                                        <input type='hidden' class='form-control'  name='CompareType' id='CompareType' value='<?php echo $Field15 ?>'>
                                       <div class="col-sm-7">
                                           <select required class="form-control" name="Type" id="Type">

                                            <?php
                                              if($StrType!=""){
                                                  $StrTypeDisplay="<option active>" .$StrType. "</option>";
                                                  $StrTypeDisplay.="<option>--</option>";  
                                                  $StrTypeDisplay.="<option>BEVERAGE</option>";
                                                  $StrTypeDisplay.="<option>CANNED</option>";
                                                  $StrTypeDisplay.="<option>FROZEN</option>";
                                                  $StrTypeDisplay.="<option>HUNTS</option>";
                                               }
                                               else{
                                                $StrTypeDisplay="<option>--</option>";  
                                                  $StrTypeDisplay.="<option>BEVERAGE</option>";
                                                  $StrTypeDisplay.="<option>CANNED</option>";
                                                  $StrTypeDisplay.="<option>FROZEN</option>";
                                                  $StrTypeDisplay.="<option>HUNTS</option>";
                                               }
                                               ECHO $StrTypeDisplay;

                                            ?>
                                          </select>
                                        </div>
                                </div>

                                 <!-- CIORRECT DIVISION-->
                                <div class="form-group">
                                      <label for="inputPassword3" class="col-sm-5 control-label">Correct Division : *</label>

                                      <select required class="form-control hidden" name="InputDivision1" id="InputDivision1">
                                          <option><?php echo $StrDivision ?></option>
                                      </select>
                                      <input type='hidden' class='form-control'  Name="CompareBU" ID="CompareBU" value='<?php echo $Field1 ?>'>

                                      <div class="col-sm-7" >
                                         <select required class="form-control" name="InputDivision" id="InputDivision">
                                          <?php
                                            if($StrDivision!=""){
                                              echo "<option>" .$StrDivision. "</option>";
                                              echo "<option>--</option>";
                                            }else{
                                              echo "<option>--</option>";
                                            }
                                          ?>
                                          
                                          <option>MEAT</option>
                                          <option>MILK</option>
                                          <option>PMCI</option>
                                          <option>SARDINES</option>
                                          <option>TUNA</option>
                                          <option>HUNTS</option>
                                          <option>VITA COCO</option>

                                        </select>
                                      </div>
                                </div>

                                <!-- CORRECT CLASSIFICATION-->
                                <div class="form-group">
                                      <label for="inputPassword3" class="col-sm-5 control-label">Correct Classification : *</label>
                                      
                                      <select required class="form-control hidden" name="InputClassification1" id="InputClassification1">
                                        <option><?php echo $StrCorrectExpense ?></option>
                                      </select>
                                      <div class="col-sm-7">
                                        <select required class="form-control"   name="InputClassification" id="InputClassification" onchange='InputClassification1()'>
                                            <?php
                                              if($StrCorrectExpense!=""){
                                                echo "<option active>" .$StrCorrectExpense. "</option>";
                                                echo "<option>--</option>";
                                              }else{
                                                echo "<option active>--</option>";
                                              }
                                            ?>
                                        </select>
                                      </div>
                                </div>


                                <div class="form-group">
                                  <label for="inputPassword3" class="col-sm-5 control-label">Description :*</label>
                                  <div class="col-sm-7">
                                    <!-- onchange='ValidateCMAddback()' -->
                                     <select required class="form-control" name="CMAddback" id="CMAddback" onchange='ValidateCMAddback()'>
                                      <?php
                                          if(isset($StrDescription)){
                                            echo "<option active>" .$StrDescription. "</option>";
                                            echo "<option>--</option>";
                                          }else{
                                            echo "<option active>--</option>";
                                          }
                                        ?>
                                        
                                        <option>Credit Memo</option>
                                        <option>Add Back</option>
                                    </select>
                                  </div>
                                </div>
                          </div>
                      

                            <!--BUDGET DISPLAY -->
                          <div id="BudgetOutput">
                              <div class="col-xs-6">
                                <div class="box box-warning"></div>
                                    <div class="form-group">
                                      <label for="inputEmail3" class="col-sm-5 control-label">MEAT : </label>
                                      <div class="col-sm-7">
                                        <input type="text" required  class="form-control" id="bMEAT" name="bMEAT"  value="<?PHP if($MEAT==""){ echo "0";}else {ECHO $MEAT;} ?>">
                                      </div>
                                    </div>

                                    <div class="form-group">
                                      <label for="inputEmail3" class="col-sm-5 control-label">SARDINES : </label>
                                      <div class="col-sm-7">
                                        <input type="text" required  class="form-control" id="bSARDINES" name="bSARDINES"   value="<?PHP if($SARDINES==""){ echo "0";}else {ECHO $SARDINES;} ?>">
                                      </div>
                                    </div>

                                    <div class="form-group">
                                      <label for="inputEmail3" class="col-sm-5 control-label">DAIRY : </label>
                                      <div class="col-sm-7">
                                        <input type="text" required  class="form-control" id="bDAIRY" name="bDAIRY"   value="<?PHP if($DAIRY==""){ echo "0";}else {ECHO $DAIRY;} ?>">
                                      </div>
                                    </div>

                                    <div class="form-group">
                                      <label for="inputEmail3" class="col-sm-5 control-label">TUNA : </label>
                                      <div class="col-sm-7">
                                        <input type="text"  required class="form-control" id="bTUNA" name="bTUNA"  value="<?PHP if($TUNA==""){ echo "0";}else {ECHO $TUNA;} ?>">
                                      </div>
                                    </div>
                              </div>

                              <div class="col-xs-6">
                                <div class="box box-warning"></div>
                                 <div class="form-group">
                                    <label for="inputEmail3" class="col-sm-5 control-label">HUNTS : </label>
                                    <div class="col-sm-7">

                                      <input type="text" required   class="form-control" id="bHUNTS" name="bHUNTS" value="<?PHP if($HUNTS==""){ echo "0";}else {ECHO $HUNTS;} ?>">
                                    </div>
                                  </div>

                                  <div class="form-group">
                                    <label for="inputEmail3" class="col-sm-5 control-label">VITA COCO : </label>
                                    <div class="col-sm-7">

                                      <input type="text" required  class="form-control" id="bVITA" name="bVITA"  value="<?PHP if($VITACOCO==""){ echo "0";}else {ECHO $VITACOCO;} ?>">
                                    </div>
                                  </div>

                                   <div class="form-group">
                                    <label for="inputEmail3" class="col-sm-5 control-label">RMB : </label>
                                    <div class="col-sm-7">

                                      <input type="text"  required class="form-control" id="bRMB" name="bRMB"  value="<?PHP if($RMB==""){ echo "0";}else {ECHO $RMB;} ?>">
                                    </div>
                                  </div>
                              </div>
                          </div>


                           <div class="modal fade" id="exampleModal1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
                              <div class="modal-dialog " role="document">
                                <div class="modal-content">
                                  <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <h4 class="modal-title" id="exampleModalLabel">BUDGET BREAKDOWN : </h4>
                                  </div>
                                  <div class="modal-body">
                                        <div class="box-body" id="DisplayDivBudget">
                                        </div>


                                        <div class="modal-footer">
                                          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                        </div>
                                  </div>
                                </div>
                              </div>
                           </div>
                      </div>
     
                      
                      <!-- /.box-body -->
                      <div class="box-footer">
                        <button type="submit" class="btn medium bg-blue">Submit</button>
                         <?php
                          //if(isset($_GET['ID'])){
                       //     echo "<a href='indexPartial.PHP'><button type='button' class='btn medium bg-green'>Home</button></a>";
                        //  }elseif(isset($_GET['InprogressID'])){
                       //     echo "<a href='InProgressPartial.PHP'><button type='button' class='btn medium bg-green'>Home</button></a>";
                       //   }
                        ?>
                      </div>
                      <!-- /.box-footer -->
                </form>
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
                                      <input type='text' class='form-control' id="AmountCompare"  name="AmountCompare"   disabled value='<?php echo $Field11  ?>'>
                                      <?php// echo number_format($Field11,2)  ?>
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

                              
                                  <!--
                                   <div class='form-group'>
                                    <label class='col-sm-4 control-label'>BDM Name :</label>
                                    <div class='col-sm-8'>
                                      <input type='text' class='form-control'  disabled value='<?php //echo $Field7 ?>'>
                                    </div>
                                  </div>
                                -->
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
                                    <label class='col-sm-4 control-label'>Transaction ID :</label>

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
                                      
                                    <input type='text' class='form-control' name="BudgetType" id="BudgetType"  disabled value='<?php echo $Field18 ?>'>
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
                                      <input type='text' class='form-control'  disabled value='<?php echo substr($Field21,2,4) ?>'>
                                    </div>
                                  </div>
                        </div>
                      </div>
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
<script src="plugins/slimScroll/jquery.slimscroll.min.js"></script>
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
    function MyFunction() {
        alert("The form was submitted");
    }

    function CheckRemarks() {
      var TafType=$('select[name=PromoID]').val();
      var HolderRemarks = document.getElementById("Remarks").value;
      var CMAddback=$('select[name=CMAddback]').val();
      
     // alert(HolderBucketType);
      
     // alert(TafType.indexOf("CORP"));

     //

 
      
      if(CMAddback=="Add Back" || TafType=="ADD BACK" || TafType=="MULTIPLE PROMO ID"){
        if (HolderRemarks == "") {
          document.getElementById("Remarks").style.borderColor = "#E34234";
          alert("Please input remarks first.");
          ok = false;
        }
      }else if(TafType.indexOf("CORP")>=1){

        var HolderCompareAmount = document.getElementById("AmountCompare").value;
        var bMeat = document.getElementById("bMEAT").value;
        var bHunts = document.getElementById("bHUNTS").value;
        var bSARDINES = document.getElementById("bSARDINES").value;
        var bVita = document.getElementById("bVITA").value;
        var bDairy = document.getElementById("bDAIRY").value;
        var bRMB = document.getElementById("bRMB").value;
        var bTuna = document.getElementById("bTUNA").value;

      //  alert(TafType.indexOf("CORP"));

        var TotalBudget=parseFloat(bMeat)  + parseFloat(bSARDINES) + parseFloat(bDairy)  + parseFloat(bTuna) + parseFloat(bVita)  + parseFloat(bHunts) +  parseFloat(bRMB);
        TotalBudget=Math.round(TotalBudget* 100) / 100;
        //
      //  alert(TotalBudget);
      //  alert(HolderCompareAmount);
        
        TotalBudget=Math.round(TotalBudget* 100) / 100;
      //  alert(HolderCompareAmount.replace(",",""));

        if(HolderCompareAmount.replace(",","")==TotalBudget){
          var ok = true;  
        }else{
          document.getElementById("bMEAT").style.borderColor = "#E34234";
          document.getElementById("bHUNTS").style.borderColor = "#E34234";
          document.getElementById("bSARDINES").style.borderColor = "#E34234";
          document.getElementById("bVITA").style.borderColor = "#E34234";
          document.getElementById("bDAIRY").style.borderColor = "#E34234";
          document.getElementById("bRMB").style.borderColor = "#E34234";
          document.getElementById("bTUNA").style.borderColor = "#E34234";
          alert("Please check the total amount in all BU's.");
          ok = false;
        }


      }else if(TafType=="--"){
        alert("Please select reference type first. ");
        var  ok = false;
      }else{
        var ok = true;
      }
      return ok;
    }
</script>


<script>
  function isNumber(evt) {
    evt = (evt) ? evt : window.event;
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode > 31 && (charCode < 48 || charCode > 57)) {
        return false;
    }
    return true;
  }

  function InputClassification1() {
    var HolderBucketType = document.getElementById("InputBucket").value;
    var HolderTAF = document.getElementById("PromoID").value;
    var HolderBudgetType = document.getElementById("BudgetType").value;
    
    //alert(HolderTAF);
    //alert(HolderBudgetType)
    var ok = true;

    if(HolderBudgetType=="TRADE SUPPORT"){
      if (HolderBucketType == "DISPLAY ALLOWANCE" || HolderBucketType == "CONTRACTUAL TRADETERMS" || HolderBucketType == "TRADE OPERATIONAL INEFFICIENCIES" ) {
          ok = true;        
      }
      else if (HolderTAF == "") {
        document.getElementById("PromoID").style.borderColor = "#E34234";
        alert("Please input TAF ID first.");
        ok = false;
      }
    }
    return ok;
  }


  function Expense() {
    var CorrectExpense = document.getElementById("CorrectExpense").value;
    
    if(CorrectExpense=="YES" || CorrectExpense=="--"){
      document.getElementById("InputClassification").disabled=true;
      document.getElementById("InputBucket").disabled=true;
      document.getElementById("InputClassification").value="--";
      document.getElementById("InputBucket").value="--";
    }
    else{
      document.getElementById("InputClassification").disabled=false;
      document.getElementById("InputBucket").disabled=false;
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


  
<script>  
  // to filter the data per BUCKEt
    function Bucket(){
      var BucketType=($('select[name=InputBucket]').val());
     // alert(BucketType);
      $.ajax({
          method: "POST",
          url: "Function/DisplayDescription.php",
          data: {Type:BucketType}
      }).done(function(msg){
         // alert(msg);
          $("#InputClassification").html(msg);
      });    
    }
    
</script>

<script>
  function ValidateCMAddback(){
    var CMAddback=$('select[name=CMAddback]').val();
      if(CMAddback=="Add Back"){
        document.getElementById("Type").disabled=true;
        document.getElementById("PromoID").disabled=true;
        document.getElementById("InputDivision").disabled=true;
       // document.getElementById("InputBucket").disabled=true;
        document.getElementById("InputClassification").disabled=true;
        document.getElementById("Year").disabled=true;
        
        $("#InputClassification").html("<option>--</option>");
        $("#InputDivision").html("<option>--</option>");
        $("#Type").html("<option>--</option>");
    //    $("#PromoID").html("<option>--</option>");

        document.getElementById("Year").value="--";
        document.getElementById("BudgetAlloted").value="--";

        document.getElementById("Year1").value="--";
        $("#InputClassification1").html("<option>--</option>");
        $("#InputDivision1").html("<option>--</option>");
        $("#Type1").html("<option>--</option>");
        
      }else{
        document.getElementById("Type").disabled=false;
        document.getElementById("PromoID").disabled=false;
        document.getElementById("InputDivision").disabled=false;
        document.getElementById("InputClassification").disabled=false;
        document.getElementById("Year").disabled=false;

        $("#Type").html("<option>--</option><option>BEVERAGE</option><option>CANNED</option><option>FROZEN</option><option>HUNTS</option>");
        $("#InputDivision").html("<option>--</option><option>MEAT</option><option>MILK</option><option>PMCI</option><option>SARDINES</option><option>TUNA</option><option>HUNTS</option><option>HUNTS</option><option>VITA COCO</option>");
        
      }
    //

    //alert(CMAddback);
  }
</script>

<script>  
  // to filter the data per BUCKEt
    function LoadData(){
      var ID=($('select[name=PromoID]').val());
      var DataID=($('input[name=DataID]').val());

      document.getElementById("Year").value="--";
      $("#InputClassification").html("<option>--</option>");
      $("#InputDivision").html("<option>--</option>");
      $("#Type").html("<option>--</option>");
     // $("#CMAddback").html("<option>--</option>");
      
      //FOR BUDGET PER DIVISION AMOUNT
      $.ajax({
          method: "POST",
          url: "Function/`.php",
          data: {Type:ID}
      }).done(function(msg){
        ///  alert(msg)
          //$("#Year").html('kamote');
          $("#DisplayDivBudget").html(msg);
      });   

     //FOR BUDGET AMOUNT
      $.ajax({
          method: "POST",
          url: "Function/DisplayBudget.php",
          data: {Type:ID}
      }).done(function(msg){
          document.getElementById('BudgetAlloted').value=msg;  
          document.getElementById('BudgetAlloted1').value=msg;  
      });   



      //FOR YEAR
      $.ajax({
          method: "POST",
          url: "Function/DisplayYear.php",
          data: {Type:ID,DataID:DataID}
      }).done(function(msg){
          //alert(msg)
          //$("#Year").html('kamote');
          document.getElementById('Year').value=msg;
          document.getElementById('Year1').value=msg;
      });   

      //FOR TYPE
      $.ajax({
          method: "POST",
          url: "Function/DisplayType.php",
          data: {Type:ID,DataID:DataID}
      }).done(function(msg){
          $("#Type").html(msg);
          $("#Type1").html(msg);
      });  

      //FOR Division
      $.ajax({
          method: "POST",
          url: "Function/DisplayDivision.php",
          data: {Type:ID,DataID:DataID}
      }).done(function(msg){
         var msg=msg.replace(" ","");
        // alert(msg)

          //$("#Year").html('kamote');
        //  alert(msg);
          $("#InputDivision").html(msg);
          $("#InputDivision1").html(msg);
      });   

      //FOR BUCKET DESCRIPTION         
      if(ID!="OTHERS"){
        $.ajax({
            method: "POST",
            url: "Function/DisplayDescription.php",
            data: {Type:ID,DataID:DataID}
        }).done(function(msg){
            $("#InputClassification").html(msg);
            $("#InputClassification1").html(msg);
        });    
      }
      
      
      
      var StrDa=ID.substring(0,2);

      //DISABLED/ENABLED ALL INPUTS
      
      if(ID=="CONTRACTUAL TRADE TERMS" || ID=="MERCHANDISING COST" || ID=="OTHERS"  || ID=="TRADE OPERATIONAL INEFFICIENCIES" || StrDa=="DA" || ID=="MULTIPLE PROMO ID"){
        document.getElementById("Year").value="--";
       // document.getElementById("BudgetAlloted").value="--";
        $("#InputClassification").html("<option>--</option>");
        $("#InputDivision").html("<option>--</option>");
        $("#Type").html("<option>--</option>");

        document.getElementById("Year").disabled=false;
        document.getElementById("BudgetAlloted").disabled=true;
        document.getElementById("InputDivision").disabled=false;
        document.getElementById("InputClassification").disabled=false;
        document.getElementById("Type").disabled=false;
        //document.getElementById("ViewDetails").disabled=true;  
        $("#BudgetOutput").hide();

        if(ID=="OTHERS"){
          document.getElementById("InputClassification").disabled=true;
        }

      }else{
        document.getElementById("Year").disabled=true;
        document.getElementById("BudgetAlloted").disabled=true;
        document.getElementById("InputDivision").disabled=true;
        document.getElementById("InputClassification").disabled=true;
        document.getElementById("Type").disabled=true;
        

       

        if(ID.indexOf("CORP")<=0){
          $("#BudgetOutput").hide();
        }else{
          $("#BudgetOutput").show();
        
        }
      } 

    }


    function Disabled(){
      document.getElementById("BudgetAlloted").disabled=true;
      //document.getElementById("ViewDetails").disabled=true;
      $("#BudgetOutput").hide();
    }
</script>





</body>
</html>


