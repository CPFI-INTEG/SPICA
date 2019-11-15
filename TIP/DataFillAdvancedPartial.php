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

         //Should Data HERE!
    //        $sqlShould="select id,dataid,year,type,correctexpense,expense,correctdivision,divsion,remarks,promoid from TIR_ShouldBE  where dataid=" .$ID. "";
  //          ECHO $sqlShould . "<BR>";
      //      $stmtShould=sqlsrv_query($con,$sqlShould);
        //    while($rowShould=sqlsrv_fetch_array($stmtShould,SQLSRV_FETCH_ASSOC)){
          //      $StrID=$rowShould['id'];
            //    $StrYear=$rowShould['year'];
              //  $StrType=$rowShould['type'];
//                $StrCorrectExpense=$rowShould['correctexpense'];
  //              $StrExpense=$rowShould['expense'];
    //            $StrCorrectDivision=$rowShould['correctdivision'];
    //            $StrDivision=$rowShould['divsion'];
    //            $StrRemarks=$rowShould['remarks'];
    //            $StrPromoID=$rowShould['promoid'];
      //      }
          





    $parentCode=$_SESSION['BDM_USERNAME']; // THIS IS THE FIELD OF BDM NAME
    if(isset($_GET['ID'])){
      $id=$_GET['ID'];
      include("model/dbcon.php");
      $sql="select  DIM4_CD,status,bp_type_Cd,cast(invoice_Date as nvarchar)  as invoice_Date,budget_desc,invoice_month,ID,dim5_desc_division,bp_code,business_partner_name,parent_name,parent_Cd,district,name,invoice,pr_number,cast(or_Date as nvarchar)  as or_Date,transaction_Amount,dim1_Desc,remarks,dim4_Cd,invoice_year,division,transaction_sid from tip.V_PARTIAL_BALANCE where id=" .$id. "";

      echo $sql;
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
        $Field21=$row['status'];
        $Field22=$row['DIM4_CD'];
        
        


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
       ECHO  $StrExpenseDisplay;
    }
?>

<!DOCTYPE html>
<html>
  <head>
      <link rel="shortcut icon" type="image/png" href="images/CPG Logo.png"/>
      <?php include("linkScriptPagesPartial.php");?>
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
      
  </head>
<body class="hold-transition skin-blue sidebar-mini" onload='DisabledEntry()'>
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
  

    <!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) -->
        <!-- Left col -->
      <div class="row">
        <div class="col-md-12">

          
            <?php
              $strTab="<div class='nav-tabs-custom'>";
                $strTab.="<div class='tab-content'>";
        
                    $trBoolTab="false";
                    $Counter=0;
                    $IterationNext="";
                    $IterationBack="";

                     
                    include("model/dbcon.php");
                    //Counter of Data

                    $CounterHolder='';
                    $sqlCount="select count(id) as counter from tip.V_PARTIAL_BALANCE where bdm_username='".$parentCode."' and IsStatusSubmitted='Pending' and DATEPART(month, or_Date)=DATEPART(month, getdate())-1";
                    $stmtCount=sqlsrv_query($con,$sqlCount);
                    $rowCount=sqlsrv_fetch_array($stmtCount,SQLSRV_FETCH_ASSOC);
                    $CounterHolder=$rowCount['counter'];


                    //FIRST ROW DATA IN ENTRIES PER BDM
                    //select TOP 1 bp_type_Cd,cast(invoice_Date as nvarchar)  as invoice_Date,budget_desc,invoice_month,ID,dim5_desc_division,bp_code,business_partner_name,parent_name,parent_Cd,district,name,invoice,pr_number,cast(or_Date as nvarchar)  as or_Date,transaction_Amount,dim1_Desc,remarks,dim4_Cd,invoice_year,division,transaction_sid from tip.V_PARTIAL_BALANCE where  bdm_username='".$parentCode."' and IsStatusSubmitted='Pending' UNION ALL 
                    $sql="select TOP 1 DIM4_CD,status,bp_type_Cd,cast(invoice_Date as nvarchar)  as invoice_Date,budget_desc,invoice_month,ID,dim5_desc_division,bp_code,business_partner_name,parent_name,parent_Cd,district,name,invoice,pr_number,cast(or_Date as nvarchar)  as or_Date,transaction_Amount,dim1_Desc,remarks,dim4_Cd,invoice_year,division,transaction_sid from tip.V_PARTIAL_BALANCE where  bdm_username='".$parentCode."' and IsStatusSubmitted='Pending' and DATEPART(month, or_Date)=DATEPART(month, getdate())-1 
                    UNION ALL  select DIM4_CD,status,bp_type_Cd,cast(invoice_Date as nvarchar)  as invoice_Date,budget_desc,invoice_month,ID,dim5_desc_division,bp_code,business_partner_name,parent_name,parent_Cd,district,name,invoice,pr_number,cast(or_Date as nvarchar)  as or_Date,transaction_Amount,dim1_Desc,remarks,dim4_Cd,invoice_year,division,transaction_sid from tip.V_PARTIAL_BALANCE where  bdm_username='".$parentCode."' and IsStatusSubmitted='Pending' and DATEPART(month, or_Date)=DATEPART(month, getdate())-1";
                    //and DATEPART(month, or_Date)=DATEPART(month, getdate())-1
                    
                    $stmt=sqlsrv_query($con,$sql);

                 // echo $sql;  
                    $rowFirst=sqlsrv_fetch_array($stmt,SQLSRV_FETCH_ASSOC);
                    $IDFirst=$rowFirst['ID'];  

                   //Should Data HERE! FIRST ROW DATA
                    if($IDFirst!=""){
                      $sqlShouldFirst="select id,dataid,year,type,correctexpense,description,correctdivision,remarks,promoid from tip.PB_ShouldBE  where dataid=" .$IDFirst. "";
                      $stmtShouldFirst=sqlsrv_query($con,$sqlShouldFirst);
                      while($rowShouldFirst=sqlsrv_fetch_array($stmtShouldFirst,SQLSRV_FETCH_ASSOC)){
                        $StrID=$rowShouldFirst['id'];
                      }  
                    }
                    

                    //echo $StrID;

                    $strTab.="<div class='tab-pane active' id='0'>";  
                    $strTab.="<div class='alert alert-info alert-dismissible'>";
                      $strTab.="<h4><i class='icon fa fa-info'></i> Notice!</h4>";
                      $strTab.="Clicking the <b>Next Entry button</b> will automatically saved the  data.";
                    $strTab.="</div>";

                    //NEXT AND BACK
                    $strTab.="<div class='box-footer'>";
                      $strTab.="<a href='indexPartial.php'><button  class='btn medium bg-blue btn-mg'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Back to home page&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</button></a>";
                      //$StrID=$StrID-1;
                      $strTab.="<a href='#1' data-toggle='tab'><button name='SaveData' onclick='EnabledEntry()' data-id='DataID".$IDFirst.";ShouldID".$StrID."' class='btn-mg btn medium bg-blue pull-right'>&nbsp;&nbsp;&nbsp;Start&nbsp;&nbsp;&nbsp;</button></a>";
                  
                    $strTab.="</div>"; // END NG ITERATION  OF footer
                    $strTab.="</div>";  

                    while($row=sqlsrv_fetch_array($stmt,SQLSRV_FETCH_ASSOC)){
                      $Counter=$Counter+1;
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
                      $Field21=$row['status'];
                      $Field22=$row['DIM4_CD'];

                      //Should Data HERE!
                      $sqlShould="select id,dataid,year,type,correctexpense,description,correctdivision,remarks,promoid from tip.PB_ShouldBE  where dataid=" .$ID. "";
                      $stmtShould=sqlsrv_query($con,$sqlShould);
                      while($rowShould=sqlsrv_fetch_array($stmtShould,SQLSRV_FETCH_ASSOC)){
                          $StrID=$rowShould['id'];
                      }
                     
      //                if($trBoolTab=="false"){
    //                    $trBoolTab="True";
  //                      $strTab.="<div class='tab-pane' id='".$Counter."'>";  
//                      }else{
                        $strTab.="<div class='tab-pane' id='".$Counter."'>";
                    //  }
                       // $strTab.=$Counter;
                      
                      $IterationNext=$Counter+1;
                      $IterationBack=$Counter-1;

                        //  SELECTED DETAILS ********************************************************************************************************************************
                          $strTab.="<div class='box box-info'>";
                            $strTab.="<div class='box-header with-border'>";
                              $strTab.="<i class='fa fa-book'></i>";

                              $strTab.="<h3 class='box-title'>Selected Details</h3>";
                              $strTab.="<h3 class='box-title pull-right'>Number of Data : ".$Counter." out of ".$CounterHolder."</h3>";
                            $strTab.="</div>"; //END HEADER TITLE 
                            $strTab.="<br>";

                              $strTab.="<form class='form-horizontal' >";
                                $strTab.="<div class='box-body'>";
                                  $strTab.="<div class='col-xs-6'>";
                                            $strTab.="<div class='form-group'>";
                                              $strTab.="<label class='col-sm-4 control-label'>Parent Details :</label>";

                                              $strTab.="<div class='col-sm-8'>";
                                                $strTab.="<input type='hidden' class='form-control'  id='SelectedID' name='SelectedID' value='".$ID ."'>";
                                                $strTab.="<input type='text' class='form-control'  disabled value='(".$Field5 .") ".$Field4."'>";
                                              $strTab.="</div>";
                                            $strTab.="</div>";

                                            $strTab.="<div class='form-group'>";
                                              $strTab.="<label class='col-sm-4 control-label'>Customer Details :</label>";

                                              $strTab.="<div class='col-sm-8'>";
                                                $strTab.="<input type='text' class='form-control'  disabled value='(".$Field2.")".$Field3." ' >";
                                              $strTab.="</div>";
                                            $strTab.="</div>";

                                            $strTab.="<div class='form-group'>";
                                              $strTab.="<label class='col-sm-4 control-label'>District :</label>";

                                              $strTab.="<div class='col-sm-8'>";
                                                  
                                                $strTab.="<input type='text' class='form-control'  disabled value='".$Field6."'>";
                                              $strTab.="</div>";
                                            $strTab.="</div>";    


                                            $strTab.="<div class='form-group'>";
                                              $strTab.="<label class='col-sm-4 control-label'>Division:</label>";

                                              $strTab.="<div class='col-sm-5'>";
                                                
                                                $strTab.="<input type='text' class='form-control'  disabled value='".$Field1."'>";
                                              $strTab.="</div>";

                                              $strTab.="<label class='col-sm-1 control-label'>BP:</label>";

                                              $strTab.="<div class='col-sm-2'>";
                                                
                                                $strTab.="<input type='text' class='form-control'  disabled value='".$Field19."'>";
                                              $strTab.="</div>";
                                            $strTab.="</div>";


                                            $strTab.="<div class='form-group'>";
                                              $strTab.="<label class='col-sm-4 control-label'>Amount :</label>";

                                              $strTab.="<div class='col-sm-8'>";
                                                
                                                $strTab.="<input type='text' class='form-control'  disabled value='".$Field11."'>";
                                              $strTab.="</div>";
                                            $strTab.="</div>";

                                            //$strTab.="<div class='form-group'>";
                                              //$strTab.="<label class='col-sm-4 control-label'>Transaction Count :</label>";

                                              //$strTab.="<div class='col-sm-8'>";
                                                
//                                                $strTab.="<input type='text' class='form-control'  disabled value='".$Field5."'>";
                                              //$strTab.="</div>";
                                            //$strTab.="</div>"; 

                                            $strTab.="<div class='form-group'>";
                                              $strTab.="<label class='col-sm-4 control-label'>Remarks :</label>";

                                              $strTab.="<div class='col-sm-8'>";
                                                
                                                $strTab.="<textarea class='form-control'  disabled >".$Field13."</textarea>";
                                              $strTab.="</div>";
                                            $strTab.="</div>";    


//                                            $strTab.="<div class='form-group'>";
  //                                            $strTab.="<label class='col-sm-4 control-label'>BDM Name :</label>";

    //                                          $strTab.="<div class='col-sm-8'>";
                                                
      //                                          $strTab.="<input type='text' class='form-control'  disabled value='".$Field7."'>";
        //                                      $strTab.="</div>";
          //                                  $strTab.="</div>";        
                                  $strTab.="</div>"; //end of FIRST COLUMN
  


                                  $strTab.="<div class='col-xs-6'>";
                                            $strTab.="<div class='form-group'>";
                                              $strTab.="<label class='col-sm-4 control-label'>Invoice Details:</label>";

                                              $strTab.="<div class='col-sm-8'>";
                                                
                                                $strTab.="<input type='text' class='form-control'  disabled value='".$Field8." and ".$Field17."/".$Field20."'>";
                                              $strTab.="</div>";
                                            $strTab.="</div>";

                                             $strTab.="<div class='form-group'>";
                                              $strTab.="<label class='col-sm-4 control-label'>PR Number :</label>";

                                              $strTab.="<div class='col-sm-8'>";
                                                
                                                $strTab.="<input type='text' class='form-control'  disabled value='".$Field9."'>";
                                              $strTab.="</div>";
                                            $strTab.="</div>";


                                            $strTab.="<div class='form-group'>";
                                              $strTab.="<label class='col-sm-4 control-label'>Transaction ID  :</label>";

                                              $strTab.="<div class='col-sm-8'>";
                                                
                                                $strTab.="<input type='text' class='form-control'  disabled value='".$Field16."'>";
                                              $strTab.="</div>";
                                            $strTab.="</div>";

                                            //$strTab.="<div class='form-group'>";
                                              //$strTab.="<label class='col-sm-4 control-label'>Transaction Count  :</label>";

                                              //$strTab.="<div class='col-sm-8'>";
                                                
//                                                $strTab.="<input type='text' class='form-control'  disabled value='".$Field11."'>";
                                              //$strTab.="</div>";
                                            //$strTab.="</div>";

                                            $strTab.="<div class='form-group'>";
                                              $strTab.="<label class='col-sm-4 control-label'>Nature / Classification  :</label>";

                                              $strTab.="<div class='col-sm-8'>";
                                                
                                                $strTab.="<input type='text' class='form-control'  disabled value='".$Field12."'>";
                                              $strTab.="</div>";
                                            $strTab.="</div>";

                                             $strTab.="<div class='form-group'>";
                                              $strTab.="<label class='col-sm-4 control-label'>Budget Type  :</label>";

                                              $strTab.="<div class='col-sm-8'>";
                                                
                                                $strTab.="<input type='text' class='form-control'  disabled value='".$Field18."'>";
                                                $strTab.="<input type='hidden' class='form-control' name='BudgetType' id='BudgetType'  disabled value='".$Field18."'>";
                                              $strTab.="</div>";
                                            $strTab.="</div>";



                                            $strTab.="<div class='form-group'>";
                                              $strTab.="<label class='col-sm-4 control-label'>OR Date :</label>";

                                              $strTab.="<div class='col-sm-5'>";
                                                $strTab.="<input type='text' class='form-control'  disabled value='".$Field10."'>";
                                              $strTab.="</div>";
                                            $strTab.="</div>";

                                            $strTab.="<div class='form-group'>";
                                              $strTab.="<label class='col-sm-4 control-label'>Expense Yr:</label>";

                                              $strTab.="<div class='col-sm-5'>";
                                             // $strTab.=substr($Field22,0,4);
                                                $strTab.="<input type='text' class='form-control'  disabled value='".substr($Field22,2,6)."'>";
                                              $strTab.="</div>";
                                            $strTab.="</div>";

                                            

                                  $strTab.="</div>"; //end of SECOND COLUMN
                                $strTab.="</div>"; // END OF BOX BODY
                  
                                $strTab.="<div class='box-footer'>";
                                 // $strTab.="<a href='#".$IterationBack."' data-toggle='tab'><button  class='btn medium bg-blue btn-mg'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Back&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</button></a>";

                                  if($CounterHolder==$Counter){
                                    $strTab.="<a href='test.php'><button name='SaveData' data-id='DataID".$ID.";ShouldID".$StrID."' data-value='Done' class='btn-mg btn medium bg-blue pull-right'>&nbsp;&nbsp;Done Entry&nbsp;&nbsp;</button></a>";
                                  }else{
                                    $strTab.="<a href='#".$IterationNext."' data-toggle='tab'><button name='SaveData' data-whatever='".$Field18."' data-id='DataID".$ID.";ShouldID".$StrID."' class='btn-mg btn medium bg-blue pull-right'>&nbsp;&nbsp;Next Entry&nbsp;&nbsp;</button></a>";
                                  }

                                $strTab.="</div>"; // END NG ITERATION  OF footer
                             $strTab.="</form>"; // END FORM
                         $strTab.="</div>"; // END BOX INFO

                        
                        
                      $strTab.="</div>"; // END NG ITERATION  OF TAB
                    }
                $strTab.="</div>"; // endig of tab content
              $strTab.="</div>";



              echo $strTab;

            ?>
      </div>

      <div class="col-xs-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                  <i class="fa fa-book"></i>

                  <h3 class="box-title">SHOULD BE</h3>
                </div>
                <!-- form start -->
                <form class="form-horizontal" action='function/SaveShouldPartial.php' method='POST' onsubmit="return InputClassification1()">
                  <div class="box-body">
                    <div class="col-xs-6">

                              <div class="form-group">
                                <label for="inputEmail3" class="col-sm-4 control-label">Year :</label>

                                <div class="col-sm-8">
                                  <input type="hidden"  class="form-control" id="DataID" name="DataID"  value="<?php echo $ID ?>">
                                  <input type="hidden"  class="form-control" id="ActualID" name="ActualID"  value="<?php echo $StrID ?>">
                                  <input type="text" required class="form-control" id="StrYear" name="StrYear" onkeypress="return isNumber(event)" placeholder="Input Year"  maxlength="4" value="<?php echo $StrYear ?>">
                                </div>
                              </div>

                             
                              <div class="form-group">
                                <label for="inputPassword3" class="col-sm-4 control-label">Description :</label>

                                <div class="col-sm-8">
                                   <select required class="form-control" name="StrCMAddback" id="StrCMAddback" >
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

                              

                              





                              <div class="form-group">
                                <label for="inputPassword3" class="col-sm-4 control-label">Remarks :</label>

                                <div class="col-sm-8">
                                   <textarea  class="form-control" rows="3" name="StrRemarks" id="StrRemarks" placeholder="Input Remarks"><?PHP if(isset($StrRemarks)){ echo $StrRemarks;} ?></textarea>
                                </div>
                              </div>
                    </div>


                    <div class="col-xs-6">
                        <!-- TYPE FIELD -->
                       <div class="form-group">
                              <label for="inputPassword3" class="col-sm-5 control-label">Type :</label>

                             <div class="col-sm-7">
                                 <select required class="form-control" name="StrType" id="StrType">

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
                                  <select required class="form-control" name="StrInputClassification" id="StrInputClassification">
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
                                      <option>Bundling</option>
                                      <option>Convention</option>
                                      <option>Display Allowance</option>
                                      <option>Efficiency Discount</option>
                                      <option>Guaranteed Discount</option>
                                      <option>Listing Fee</option>
                                      <option>Mailer</option>
                                      <option>Merchandising Cost</option>
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
                                      <option>Seasonal Event</option>
                                      <option>Short Payment</option>
                                      <option>Volume Discount</option>
                                  </select>
                                </div>
                          </div>


                          <!-- CIORRECT DIVISION-->
                          <div class="form-group">
                                <label for="inputPassword3" class="col-sm-5 control-label">Correct Division :</label>

                                <div class="col-sm-7" >
                                   <select required class="form-control" name="StrInputDivision" id="StrInputDivision">
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
                                <label for="inputPassword3" class="col-sm-5 control-label">TAF Reference / Promo ID :</label>

                                <div class="col-sm-7">
                                  <?php
                                    if($Field18="Trade Support"){
                                      echo "<input required type='text' class='form-control' id='StrPromoID' NAME='StrPromoID' placeholder='Input TAF Reference or Promo ID' VALUE=" .$StrPromoID. ">";
                                    }else{
                                      echo "<input type='text' class='form-control' id='StrPromoID' NAME='StrPromoID' placeholder='Input TAF Reference or Promo ID' VALUE=" .$StrPromoID. ">";
                                    }
                                  ?>

                                </div>
                                <div class="col-sm-7">
                                  <input type="hidden" class="form-control" id="FLAG" NAME="FLAG">
                                </div>
                          </div>
                          <input type="text" class="form-control" id="TestQuery" NAME="TestQuery">

                    </div>
                  </div>
                </form>
              </div>
            
        </div>


  


    </section>
    <!-- /.content -->
  </div>



<?php include("footer.php"); //THIS IS FOOTER---------------------------------------------------------------------- ?>

  
</div>
<!-- ./wrapper -->

<!-- jQuery 2.2.3 -->
<script>
  function GetID(){
    var ID=$('button[name=SaveData]').data("id");
    var ActualID=ID;
    var LenActual=ID.length;

    FirstActual=ActualID.search(";")+9;
    ShouldID=ActualID.substring(FirstActual,LenActual); // to get the SHOULD BE ID in Should module
    GetYear(ShouldID);
  }


  function GetYear(ID){
    $.ajax({
        method: "POST",
        url: "Function/GetSelectedDataPartial.php?test",
        data: {ShouldYear:ID},
        Success : GetCMAddBack(ID)
    }).done(function(msg){
        $('input[name=StrYear]').val(msg);
          //alert(msg);
    });
  }

  function GetCMAddBack(ID){
      //alert(ID);
    $.ajax({
        method: "POST",
        url: "Function/GetSelectedDataPartial.php?test",
        data: {ShouldCMAddBACK:ID},
        Success : GetRemarks(ID)
    }).done(function(msg){
       $("#StrCMAddback").html('<option>'+msg+'</option><option>--</option><option>Credit Memo</option><option>Add Back</option>'); 
    
       
       //$('input[name=TestQuery').val(msg);
    });
  }


  function GetRemarks(ID){
      //alert(ID);
    $.ajax({
        method: "POST",
        url: "Function/GetSelectedDataPartial.php?test",
        data: {ShouldRemarks:ID},
        Success : GetType(ID)
    }).done(function(msg){
        $('textarea[name=StrRemarks]').val(msg);
    });
  }

  function GetType(ID){
      //alert(ID);
    $.ajax({
        method: "POST",
        url: "Function/GetSelectedDataPartial.php?test",
        data: {ShouldType:ID},
        Success : GetClassification(ID)
    }).done(function(msg){
        $("#StrType").html('<option>'+msg+'</option><option>--</option><option>BEVERAGE</option><option>CANNED</option><option>FROZEN</option>'); 
    });
  }

  function GetClassification(ID){
      //alert(ID);
    $.ajax({
        method: "POST",
        url: "Function/GetSelectedDataPartial.php?test",
        data: {ShouldClassification:ID},
        Success : GetDivision(ID)
    }).done(function(msg){
    //  $('input[name=TestQuery').val(msg);
      $("#StrInputClassification").html('<option>'+msg+'</option><option>--</option><option>Additional Discount</option><option>Anniversary Support</option><option>Bad Orders</option><option>Backload</option><option>Bunding</option><option>Convention</option><option>Display Allowance</option><option>Efficiency Discount</option><option>Guaranteed Discount</option><option>Listing Free</option><option>Mailer</option><option>Mercadising Cost</option><option>Near Expiry</option><option>Opening Support</option><option>Penalties</option><option>Penalties-Service level</option><option>Price Adjustment</option><option>Price Change Rebates</option><option>Price Difference</option><option>Price Off</option><option>Product Highlight</option><option>Promotional Support</option><option>Prompt Payment</option><option>Seasonnal Event</option><option>Short Delivery</option><option>Short Landed</option><option>Short Payment</option><option>Volumne Discount</option>'); 
    });
  }

  function GetDivision(ID){
      //alert(ID);
    $.ajax({
        method: "POST",
        url: "Function/GetSelectedDataPartial.php?test",
        data: {ShouldDivision:ID},
        Success : GetTAF(ID)
    }).done(function(msg){
        $("#StrInputDivision").html('<option>'+msg+'</option><option>--</option><option>DPD</option><option>MEAT</option><option>MILK</option><option>PMCI</option><option>SARDINES</option><option>TUNA</option>'); 
    });
  }

  function GetTAF(ID){
      //alert(ID);
    $.ajax({
        method: "POST",
        url: "Function/GetSelectedDataPartial.php?test",
        data: {ShouldTAF:ID}
    }).done(function(msg){
        $('input[name=StrPromoID]').val(msg);
    });
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


    $('button[name=SaveData]').click(function(){      
        var DataValue=$(this).data("value")
        var DataID=$(this).data("id");     

        var HolderID=DataID;  
        var ActualID=DataID;
        var LenActual=DataID.length;

        HolderID=HolderID.substring(6,HolderID.search(";")); // to get the DATAID in entries
        FirstActual=ActualID.search(";")+9;
        ShouldID=ActualID.substring(FirstActual,LenActual); // to get the SHOULD BE ID in Should module



        var ActualID=$('input[name=ActualID]').val();
        var Year=$('input[name=StrYear').val();
        var CMAddback=$('select[name=StrCMAddback]').val();
        var Remarks=$('textarea[name=StrRemarks]').val();
        var Type=$('select[name=StrType]').val();
        var InputClassification=$('select[name=StrInputClassification]').val();
        var InputDivision=$('select[name=StrInputDivision]').val();
        var PromoID=$('input[name=StrPromoID]').val();
        var FLAGHERE=$('input[name=FLAG]').val();

        var ok = true;
        //&& CorrectExpense=="" && CorrectDivision=="" && Type=="" && InputClassification=="" && InputDivision==""
      //  alert(Year);
      //  alert(FLAGHERE);
        if (Year=="" ){
          if(FLAGHERE!="TRUE"){ // TO GO AGAD NEXT TAB.
            document.getElementById("StrYear").style.borderColor = "#E34234";
            alert("Please fill the Year field.");
            ok = false;
          }else{ // etong else na to is isang beses lang mag load kasi may condition na FLAG
            document.getElementById("FLAG").value="FALSE";     
            var BudgetTYPE = $(this).data("whatever");
            if(BudgetTYPE=="TRADE SUPPORT"){
              if(PromoID!=""){ // PAG ANG BUDGET TYPE IS TRADE SUPPORT
                  alert(ShouldID);
                  GetYear(ShouldID); // call the function to display the recordss

                  if(DataValue=='Done'){
                    window.open('indexPartial.php','_self');
                  }

              }else{  // apg hindi ng input kahit TRADE SUPPORT NAMAN.
                document.getElementById("StrPromoID").style.borderColor = "#E34234";
                alert("Please fill the TAF ID.");
                ok = false;
              }
            }else{ // pag ang budget type ay HINDI TRADE SUPPORT
                alert(ShouldID);
                GetYear(ShouldID); // call the function to display the recordss

                if(DataValue=='Done'){
                  window.open('indexPartial.php','_self');
                }
            }       
          }
            
        }else{

            var BudgetTYPE = $(this).data("whatever");
            if(BudgetTYPE=="TRADE SUPPORT"){
              if(PromoID!=""){ // PAG ANG BUDGET TYPE IS TRADE SUPPORT
                //  alert(ShouldID);
                  $.ajax({
                      method: "POST",
                      url: "Function/SaveShouldPartial.php?test",
                      data: {DataID:HolderID,ActualID:ShouldID,Year:Year,CMAddback:CMAddback,Remarks:Remarks,Type:Type,InputClassification:InputClassification,InputDivision:InputDivision,PromoID:PromoID},
                      Success : GetYear(ShouldID)
                  }).done(function(msg){
                    $('input[name=TestQuery]').val(msg);
                      //$('input[name=ActualID').val(''); 
                      //$('input[name=StrYear').val('');
                      //$('select[name=StrCorrectExpense').val('--');
                      //$('select[name=StrCorrectDivision').val('--');
                      //$('textarea[name=StrRemarks').val('');
                      //$('select[name=StrType').val('--');
                      //$('select[name=StrInputClassification').val('--');
                      //$('select[name=StrInputDivision').val('--');
                      //$('input[name=StrPromoID').val('');

                      if(DataValue=='Done'){
                        window.open('indexPartial.php','_self');
                      }
                  });
              }else{  // apg hindi ng input kahit TRADE SUPPORT NAMAN.
                document.getElementById("StrPromoID").style.borderColor = "#E34234";
                alert("Please fill the TAF ID.");
                ok = false;
              }
            }else{ // pag ang budget type ay HINDI TRADE SUPPORT
                alert(ShouldID);
                $.ajax({
                    method: "POST",
                    url: "Function/SaveShouldPartial.php?test",
                    data: {DataID:HolderID,ActualID:ShouldID,Year:Year,CMAddback:CMAddback,Remarks:Remarks,Type:Type,InputClassification:InputClassification,InputDivision:InputDivision,PromoID:PromoID},
                    Success : GetYear(ShouldID)
                }).done(function(msg){
                  $('input[name=TestQuery]').val(msg);
                    //$('input[name=ActualID').val(''); 
                    //$('input[name=StrYear').val('');
                    //$('select[name=StrCorrectExpense').val('--');
                    //$('select[name=StrCorrectDivision').val('--');
                    //$('textarea[name=StrRemarks').val('');
                    //$('select[name=StrType').val('--');
                    //$('select[name=StrInputClassification').val('--');
                    //$('select[name=StrInputDivision').val('--');
                    //$('input[name=StrPromoID').val('');

                    if(DataValue=='Done'){
                      window.open('indexPartial.php','_self');
                    }
                });
            }
        }
          
          
          



            //alert("Passwords Do not match");
            
         //   document.getElementById("StrCorrectExpense").style.borderColor = "#E34234";
         //   document.getElementById("StrCorrectDivision").style.borderColor = "#E34234";
         //   document.getElementById("StrType").style.borderColor = "#E34234";
         //   document.getElementById("StrInputClassification").style.borderColor = "#E34234";
        //    document.getElementById("StrInputDivision").style.borderColor = "#E34234";

        //}else{
          return ok;
    });

  function InputClassification1() {
    var HolderClassification = document.getElementById("InputClassification").value;
    var HolderTAF = document.getElementById("PromoID").value;
    var HolderBudgetType = document.getElementById("BudgetType").value;
    
    //alert(HolderTAF);
    //alert(HolderBudgetType);
    var ok = true;

    if(HolderBudgetType=="TRADE SUPPORT"){
      if (HolderClassification == "Display Allowance" || HolderClassification == "Contractual Trade Terms" || HolderClassification == "Trade Operational Inefficiency" ) {
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
</script>


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


  function DisabledEntry(){
    document.getElementById("FLAG").value="TRUE";

    document.getElementById("StrYear").disabled=true;
    document.getElementById("StrPromoID").disabled=true;
    document.getElementById("StrRemarks").disabled=true;  
    document.getElementById("StrCMAddback").disabled=true;  
    document.getElementById("StrType").disabled=true;  
    document.getElementById("StrInputClassification").disabled=true;  
    document.getElementById("StrInputDivision").disabled=true;  

    document.getElementById("StrInputClassification").value="--";
    document.getElementById("StrInputDivision").value="--";
  }

  function EnabledEntry(){
    document.getElementById("StrYear").disabled=false;
    document.getElementById("StrPromoID").disabled=false;
    document.getElementById("StrRemarks").disabled=false;  
    document.getElementById("StrCMAddback").disabled=false;  
    document.getElementById("StrType").disabled=false;  
    document.getElementById("StrInputClassification").disabled=false;  
    document.getElementById("StrInputDivision").disabled=false;  

    document.getElementById("StrInputClassification").value="--";
    document.getElementById("StrInputDivision").value="--";
  }


</script>







</body>
</html>

