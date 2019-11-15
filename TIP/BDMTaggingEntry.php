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


  $StrBDMList="";
  include("model/dbcon.php");
  $sqlUser="select username,full_name from [SEED_USER_LOGIN]  where POSITION='BDM'";
  //echo $sqlUser;
  //and bu='".$BusinessUnit."'
  $stmtType=sqlsrv_query($con,$sqlUser);
  $StrBDMList.="<option>--</option>";  
  while($bdm=sqlsrv_fetch_array($stmtType,SQLSRV_FETCH_ASSOC)){
        $StrBDMList.="<option value='".$bdm['full_name']."''>".$bdm['full_name']."</option>";
  }

  $StrDBDMList="";
  include("model/dbcon.php");
  $sqlUser="select username,full_name from [SEED_USER_LOGIN]  where POSITION='DBDM' ";
  //echo $sqlUser;
  //and bu='".$BusinessUnit."'
  $stmtDbdm=sqlsrv_query($con,$sqlUser);
  $StrDBDMList.="<option>--</option>";  
  while($dbdm=sqlsrv_fetch_array($stmtDbdm,SQLSRV_FETCH_ASSOC)){
        $StrDBDMList.="<option value='".$dbdm['full_name']."'>".$dbdm['full_name']."</option>";
  }






?>

<!DOCTYPE html>
<html>
  <head>
      <link rel="shortcut icon" type="image/png" href="images/CPG Logo.png"/>
      <?php include("linkScriptPages.php");?>
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
      
  </head>
<body class="hold-transition skin-blue sidebar-mini" onload="Disabled()">
<div class="wrapper">

  <header class="main-header">
    <!-- Logo -->
    <a class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b>TIR</b></span>
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
      <h1>BDM Tagging Entry</h1>
    </section>

    <!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) -->
        <!-- Left col -->
      <div class="row">

        <div class="col-xs-12">
            <div class="box box-primary">
                
                <!-- form start -->
                <form class="form-horizontal" action='function/SaveBDMTagging.php' method='POST' >
                   <div class="box-body">
                      <div class="col-xs-6">

                                <!-- -PROMO ID -->
                                  <div class="form-group">
                                        <label for="inputPassword3" class="col-sm-5 control-label">BDM Name :</label>
                                        <div class="col-sm-7">
                                          <select required class="form-control select2" style="width: 100%;"  name="BDM1" id="BDM1" onchange="LoadData()">
                                              <?php
                                                echo $StrBDMList;
                                              ?>
                                          </select>
                                         
                                       
                                        </div>
                                  </div>

                                  <div class="form-group">
                                    <label for="inputEmail3" class="col-sm-5 control-label">BDM Username : </label>

                                    <div class="col-sm-7">
                                      <input type="hidden"   class="form-control" id="BDMU1F" name="BDMU1F">
                                      <input type="text"  class="form-control" id="BDMU1" name="BDMU1">
                                    </div>
                                  </div>

                                   <div class="form-group">
                                        <label for="inputEmail3" class="col-sm-5 control-label">DBDM Name : </label>
                                        <div class="col-sm-7">
                                          <select required class="form-control select2" style="width: 100%;"  name="DBDM1" id="DBDM1">
                                              <?php
                                                echo $StrDBDMList;
                                              ?>
                                          </select>
                                        </div>
                                    
                                  </div>

                                  <div class="form-group">
                                    <label for="inputEmail3" class="col-sm-5 control-label">Parent Code :</label>


                                    <div class="col-sm-7">
                                      <input type="text"  class="form-control" id="PC1" name="PC1"  placeholder="Input Parent Code" >
                                    </div>
                                  </div>
                      </div>


                      <div class="col-xs-6" >

                             <div class="form-group">
                                <label for="inputPassword3" class="col-sm-5 control-label">JSA Name :</label>
                                <div class="col-sm-7">
                                  <select  class="form-control select2" style="width: 100%;"  name="JSA1" id="JSA1" onchange="LoadDataJSA1()">
                                      <?php
                                        echo $StrBDMList;
                                      ?>
                                  </select>
                                 
                               
                                </div>
                              </div>

                              <div class="form-group">
                                <label for="inputEmail3" class="col-sm-5 control-label">JSA Username : </label>

                                <div class="col-sm-7">
                                  <input type="hidden"  class="form-control" id="JSAU1F" name="JSAU1F">
                                  <input type="text"  class="form-control" id="JSAU1" name="JSAU1">
                                </div>
                              </div>

                          

                            <!-- TYPE FIELD -->
                             <div class="form-group">
                                    <label for="inputPassword3" class="col-sm-5 control-label">Channel : *</label>

                                   <div class="col-sm-7">
                                       <select required class="form-control" name="CHANNEL1" id="CHANNEL1">

                                        <?php
                                          if($StrType!=""){
                                              $StrTypeDisplay="<option active>" .$StrType. "</option>";
                                              $StrTypeDisplay.="<option>--</option>";  
                                              $StrTypeDisplay.="<option>GT</option>";
                                              $StrTypeDisplay.="<option>MT</option>";
                                              $StrTypeDisplay.="<option>RMB</option>";
                                           }
                                           else{
                                            $StrTypeDisplay="<option>--</option>";  
                                              $StrTypeDisplay.="<option>GT</option>";
                                              $StrTypeDisplay.="<option>MT</option>";
                                              $StrTypeDisplay.="<option>RMB</option>";
                                           }
                                           ECHO $StrTypeDisplay;

                                        ?>
                                      </select>
                                    </div>
                            </div>

                             <!-- CIORRECT DIVISION-->
                            <div class="form-group">
                                  <label for="inputPassword3" class="col-sm-5 control-label">Business Unit : *</label>

                                  <div class="col-sm-7" >
                                     <select required class="form-control" name="BU1" id="BU1">
                                      <?php
                                        if($StrDivision!=""){
                                          echo "<option>" .$StrDivision. "</option>";
                                          echo "<option>--</option>";
                                        }else{
                                          echo "<option>--</option>";
                                        }
                                      ?>

                                      <option>111</option>
                                      <option>211</option>
                                      <option>221</option>
                                      <option>271</option>
                                      <option>291</option>
                                      <option>311</option>
                                      <option>491</option>
                                      <option>511</option>
                                      <option>521</option>
                                      <option>871</option>
                                    </select>
                                  </div>
                            </div>
                      </div>
                   </div>
                   <div class="box box-warning"></div>

                   <!-- ROW 2 -->
                    <div class="box-body">
                      <div class="col-xs-6">

                                <!-- -PROMO ID -->
                                  <div class="form-group">
                                        <label for="inputPassword3" class="col-sm-5 control-label">BDM Name :</label>
                                        <div class="col-sm-7">
                                          <select  class="form-control select2" style="width: 100%;"  name="BDM2" id="BDM2" onchange="LoadData2()">
                                              <?php
                                                echo $StrBDMList;
                                              ?>
                                          </select>
                                         
                                       
                                        </div>
                                  </div>

                                  <div class="form-group">
                                    <label for="inputEmail3" class="col-sm-5 control-label">BDM Username : </label>

                                    <div class="col-sm-7">
                                      <input type="hidden"  class="form-control" id="BDMU2F" name="BDMU2F">
                                      <input type="text"  class="form-control" id="BDMU2" name="BDMU2">
                                    </div>
                                  </div>

                                   <div class="form-group">
                                        <label for="inputEmail3" class="col-sm-5 control-label">DBDM Name : </label>
                                        <div class="col-sm-7">
                                          <select required class="form-control select2" style="width: 100%;"  name="DBDM2" id="DBDM2">
                                              <?php
                                                echo $StrDBDMList;
                                              ?>
                                          </select>
                                        </div>
                                    
                                  </div>

                                   <div class="form-group">
                                      <label for="inputEmail3" class="col-sm-5 control-label">Parent Code :</label>


                                      <div class="col-sm-7">
                                        <input type="text"  class="form-control" id="PC2" name="PC2"  placeholder="Input Parent Code" >
                                      </div>
                                    </div>

                      </div>


                      <div class="col-xs-6" >

                           
                              <div class="form-group">
                                <label for="inputPassword3" class="col-sm-5 control-label">JSA Name :</label>
                                <div class="col-sm-7">
                                  <select  class="form-control select2" style="width: 100%;"  name="JSA2" id="JSA2" onchange="LoadDataJSA2()">
                                      <?php
                                        echo $StrBDMList;
                                      ?>
                                  </select>
                                 
                               
                                </div>
                              </div>

                              <div class="form-group">
                                <label for="inputEmail3" class="col-sm-5 control-label">JSA Username : </label>

                                <div class="col-sm-7">
                                  <input type="hidden"  class="form-control" id="JSAU2F" name="JSAU2F">
                                  <input type="text"  class="form-control" id="JSAU2" name="JSAU2">
                                </div>
                              </div>
                            <!-- TYPE FIELD -->
                             <div class="form-group">
                                    <label for="inputPassword3" class="col-sm-5 control-label">Channel : *</label>

                                   <div class="col-sm-7">
                                       <select required class="form-control" name="CHANNEL2" id="CHANNEL2">

                                        <?php
                                          if($StrType!=""){
                                              $StrTypeDisplay="<option active>" .$StrType. "</option>";
                                              $StrTypeDisplay.="<option>--</option>";  
                                              $StrTypeDisplay.="<option>GT</option>";
                                              $StrTypeDisplay.="<option>MT</option>";
                                              $StrTypeDisplay.="<option>RMB</option>";
                                           }
                                           else{
                                            $StrTypeDisplay="<option>--</option>";  
                                              $StrTypeDisplay.="<option>GT</option>";
                                              $StrTypeDisplay.="<option>MT</option>";
                                              $StrTypeDisplay.="<option>RMB</option>";
                                           }
                                           ECHO $StrTypeDisplay;

                                        ?>
                                      </select>
                                    </div>
                            </div>

                             <!-- CIORRECT DIVISION-->
                            <div class="form-group">
                                  <label for="inputPassword3" class="col-sm-5 control-label">Business Unit : *</label>

                                  <div class="col-sm-7" >
                                     <select required class="form-control" name="BU2" id="BU2">
                                      <?php
                                        if($StrDivision!=""){
                                          echo "<option>" .$StrDivision. "</option>";
                                          echo "<option>--</option>";
                                        }else{
                                          echo "<option>--</option>";
                                        }
                                      ?>

                                      <option>111</option>
                                      <option>211</option>
                                      <option>221</option>
                                      <option>271</option>
                                      <option>291</option>
                                      <option>311</option>
                                      <option>491</option>
                                      <option>511</option>
                                      <option>521</option>
                                      <option>871</option>
                                    </select>
                                  </div>
                            </div>
                      </div>
                   </div>
                   <div class="box box-warning"></div>
                   <!-- ROW 3 -->

                   <div class="box-body">
                      <div class="col-xs-6">

                                <!-- -PROMO ID -->
                                  <div class="form-group">
                                        <label for="inputPassword3" class="col-sm-5 control-label">BDM Name :</label>
                                        <div class="col-sm-7">
                                          <select  class="form-control select2" style="width: 100%;"  name="BDM3" id="BDM3" onchange="LoadData3()">
                                              <?php
                                                echo $StrBDMList;
                                              ?>
                                          </select>
                                         
                                       
                                        </div>
                                  </div>

                                  <div class="form-group">
                                    <input type="hidden"  class="form-control" id="BDMU3F" name="BDMU3F">
                                    <label for="inputEmail3" class="col-sm-5 control-label">BDM Username : </label>

                                    <div class="col-sm-7">
                                      <input type="text"  class="form-control" id="BDMU3" name="BDMU3">
                                    </div>
                                  </div>

                                   <div class="form-group">
                                        <label for="inputEmail3" class="col-sm-5 control-label">DBDM Name : </label>
                                        <div class="col-sm-7">
                                          <select required class="form-control select2" style="width: 100%;"  name="DBDM3" id="DBDM3">
                                              <?php
                                                echo $StrDBDMList;
                                              ?>
                                          </select>
                                        </div>
                                    
                                  </div>

                                  <div class="form-group">
                                    <label for="inputEmail3" class="col-sm-5 control-label">Parent Code :</label>


                                    <div class="col-sm-7">
                                      <input type="text"  class="form-control" id="PC3" name="PC3"  placeholder="Input Parent Code" >
                                    </div>
                                  </div>
                      </div>


                      <div class="col-xs-6" >

                            

                            <div class="form-group">
                                <label for="inputPassword3" class="col-sm-5 control-label">JSA Name :</label>
                                <div class="col-sm-7">
                                  <select  class="form-control select2" style="width: 100%;"  name="JSA3" id="JSA3" onchange="LoadDataJSA3()">
                                      <?php
                                        echo $StrBDMList;
                                      ?>
                                  </select>
                                 
                               
                                </div>
                              </div>

                              <div class="form-group">
                                <label for="inputEmail3" class="col-sm-5 control-label">JSA Username : </label>

                                <div class="col-sm-7">
                                  <input type="hidden"  class="form-control" id="JSAU3F" name="JSAU3F">
                                  <input type="text"  class="form-control" id="JSAU3" name="JSAU3">
                                </div>
                              </div>

                            <!-- TYPE FIELD -->
                             <div class="form-group">
                                    <label for="inputPassword3" class="col-sm-5 control-label">Channel : *</label>

                                   <div class="col-sm-7">
                                       <select required class="form-control" name="CHANNEL3" id="CHANNEL3">

                                        <?php
                                          if($StrType!=""){
                                              $StrTypeDisplay="<option active>" .$StrType. "</option>";
                                              $StrTypeDisplay.="<option>--</option>";  
                                              $StrTypeDisplay.="<option>GT</option>";
                                              $StrTypeDisplay.="<option>MT</option>";
                                              $StrTypeDisplay.="<option>RMB</option>";
                                           }
                                           else{
                                            $StrTypeDisplay="<option>--</option>";  
                                              $StrTypeDisplay.="<option>GT</option>";
                                              $StrTypeDisplay.="<option>MT</option>";
                                              $StrTypeDisplay.="<option>RMB</option>";
                                           }
                                           ECHO $StrTypeDisplay;

                                        ?>
                                      </select>
                                    </div>
                            </div>

                             <!-- CIORRECT DIVISION-->
                            <div class="form-group">
                                  <label for="inputPassword3" class="col-sm-5 control-label">Business Unit : *</label>

                                  <div class="col-sm-7" >
                                     <select required class="form-control" name="BU3" id="BU3">
                                      <?php
                                        if($StrDivision!=""){
                                          echo "<option>" .$StrDivision. "</option>";
                                          echo "<option>--</option>";
                                        }else{
                                          echo "<option>--</option>";
                                        }
                                      ?>

                                      <option>111</option>
                                      <option>211</option>
                                      <option>221</option>
                                      <option>271</option>
                                      <option>291</option>
                                      <option>311</option>
                                      <option>491</option>
                                      <option>511</option>
                                      <option>521</option>
                                      <option>871</option>
                                    </select>
                                  </div>
                            </div>
                      </div>
                   </div>
                   <div class="box box-warning"></div>

                   <!-- ROW 4 -->

                   <div class="box-body">
                      <div class="col-xs-6">

                                <!-- -PROMO ID -->
                                  <div class="form-group">
                                        <label for="inputPassword3" class="col-sm-5 control-label">BDM Name :</label>
                                        <div class="col-sm-7">
                                          <select  class="form-control select2" style="width: 100%;"  name="BDM4" id="BDM4" onchange="LoadData4()">
                                              <?php
                                                echo $StrBDMList;
                                              ?>
                                          </select>
                                         
                                       
                                        </div>
                                  </div>

                                  <div class="form-group">
                                    <input type="hidden"  class="form-control" id="BDMU4F" name="BDMU4F">
                                    <label for="inputEmail3" class="col-sm-5 control-label">BDM Username : </label>

                                    <div class="col-sm-7">
                                      <input type="text"  class="form-control" id="BDMU4" name="BDMU4">
                                    </div>
                                  </div>

                                   <div class="form-group">
                                        <label for="inputEmail3" class="col-sm-5 control-label">DBDM Name : </label>
                                        <div class="col-sm-7">
                                          <select required class="form-control select2" style="width: 100%;"  name="DBDM44" id="DBDM4">
                                              <?php
                                                echo $StrDBDMList;
                                              ?>
                                          </select>
                                        </div>
                                    
                                  </div>

                                  <div class="form-group">
                                    <label for="inputEmail3" class="col-sm-5 control-label">Parent Code :</label>


                                    <div class="col-sm-7">
                                      <input type="text"  class="form-control" id="PC4" name="PC4"  placeholder="Input Parent Code" >
                                    </div>
                                  </div>

                      </div>


                      <div class="col-xs-6" >

                            
                            <div class="form-group">
                                <label for="inputPassword3" class="col-sm-5 control-label">JSA Name :</label>
                                <div class="col-sm-7">
                                  <select  class="form-control select2" style="width: 100%;"  name="JSA4" id="JSA4" onchange="LoadDataJSA4()">
                                      <?php
                                        echo $StrBDMList;
                                      ?>
                                  </select>
                                 
                               
                                </div>
                              </div>

                              <div class="form-group">
                                <label for="inputEmail3" class="col-sm-5 control-label">JSA Username : </label>

                                <div class="col-sm-7">
                                  <input type="hidden"  class="form-control" id="JSAU4F" name="JSAU4F">
                                  <input type="text"  class="form-control" id="JSAU4" name="JSAU4">
                                </div>
                              </div>

                            <!-- TYPE FIELD -->
                             <div class="form-group">
                                    <label for="inputPassword3" class="col-sm-5 control-label">Channel : *</label>

                                   <div class="col-sm-7">
                                       <select required class="form-control" name="CHANNEL4" id="CHANNEL4">

                                        <?php
                                          if($StrType!=""){
                                              $StrTypeDisplay="<option active>" .$StrType. "</option>";
                                              $StrTypeDisplay.="<option>--</option>";  
                                              $StrTypeDisplay.="<option>GT</option>";
                                              $StrTypeDisplay.="<option>MT</option>";
                                              $StrTypeDisplay.="<option>RMB</option>";
                                           }
                                           else{
                                            $StrTypeDisplay="<option>--</option>";  
                                              $StrTypeDisplay.="<option>GT</option>";
                                              $StrTypeDisplay.="<option>MT</option>";
                                              $StrTypeDisplay.="<option>RMB</option>";
                                           }
                                           ECHO $StrTypeDisplay;

                                        ?>
                                      </select>
                                    </div>
                            </div>

                             <!-- CIORRECT DIVISION-->
                            <div class="form-group">
                                  <label for="inputPassword3" class="col-sm-5 control-label">Business Unit : *</label>

                                  <div class="col-sm-7" >
                                     <select required class="form-control" name="BU4" id="BU4">
                                      <?php
                                        if($StrDivision!=""){
                                          echo "<option>" .$StrDivision. "</option>";
                                          echo "<option>--</option>";
                                        }else{
                                          echo "<option>--</option>";
                                        }
                                      ?>

                                      <option>111</option>
                                      <option>211</option>
                                      <option>221</option>
                                      <option>271</option>
                                      <option>291</option>
                                      <option>311</option>
                                      <option>491</option>
                                      <option>511</option>
                                      <option>521</option>
                                      <option>871</option>
                                    </select>
                                  </div>
                            </div>
                      </div>
                   </div>
                   <div class="box box-warning"></div>
                   <!-- ROW 5 -->

                   <div class="box-body">
                      <div class="col-xs-6">

                                <!-- -PROMO ID -->
                                  <div class="form-group">
                                        <label for="inputPassword3" class="col-sm-5 control-label">BDM Name :</label>
                                        <div class="col-sm-7">
                                          <select  class="form-control select2" style="width: 100%;"  name="BDM5" id="BDM5" onchange="LoadData5()">
                                              <?php
                                                echo $StrBDMList;
                                              ?>
                                          </select>
                                         
                                       
                                        </div>
                                  </div>

                                  <div class="form-group">
                                    <input type="hidden"  class="form-control" id="BDMU5F" name="BDMU5F">
                                    <label for="inputEmail3" class="col-sm-5 control-label">BDM Username : </label>

                                    <div class="col-sm-7">
                                      <input type="text"  class="form-control" id="BDMU5" name="BDMU5">
                                    </div>
                                  </div>

                                   <div class="form-group">
                                        <label for="inputEmail3" class="col-sm-5 control-label">DBDM Name : </label>
                                        <div class="col-sm-7">
                                          <select required class="form-control select2" style="width: 100%;"  name="DBDM5" id="DBDM5">
                                              <?php
                                                echo $StrDBDMList;
                                              ?>
                                          </select>
                                        </div>
                                    
                                  </div>

                                  <div class="form-group">
                                    <label for="inputEmail3" class="col-sm-5 control-label">Parent Code :</label>


                                    <div class="col-sm-7">
                                      <input type="text"  class="form-control" id="PC5" name="PC5"  placeholder="Input Parent Code" >
                                    </div>
                                  </div>
                      </div>


                      <div class="col-xs-6" >

                            

                             <div class="form-group">
                                <label for="inputPassword3" class="col-sm-5 control-label">JSA Name :</label>
                                <div class="col-sm-7">
                                  <select  class="form-control select2" style="width: 100%;"  name="JSA5" id="JSA5" onchange="LoadDataJSA5()">
                                      <?php
                                        echo $StrBDMList;
                                      ?>
                                  </select>
                                 
                               
                                </div>
                              </div>

                              <div class="form-group">
                                <label for="inputEmail3" class="col-sm-5 control-label">JSA Username : </label>

                                <div class="col-sm-7">
                                  <input type="hidden"  class="form-control" id="JSAU5F" name="JSAU5F">
                                  <input type="text"  class="form-control" id="JSAU5" name="JSAU5">
                                </div>
                              </div>

                            <!-- TYPE FIELD -->
                             <div class="form-group">
                                    <label for="inputPassword3" class="col-sm-5 control-label">Channel : *</label>

                                   <div class="col-sm-7">
                                       <select required class="form-control" name="CHANNEL5" id="CHANNEL5">

                                        <?php
                                          if($StrType!=""){
                                              $StrTypeDisplay="<option active>" .$StrType. "</option>";
                                              $StrTypeDisplay.="<option>--</option>";  
                                              $StrTypeDisplay.="<option>GT</option>";
                                              $StrTypeDisplay.="<option>MT</option>";
                                              $StrTypeDisplay.="<option>RMB</option>";
                                           }
                                           else{
                                            $StrTypeDisplay="<option>--</option>";  
                                              $StrTypeDisplay.="<option>GT</option>";
                                              $StrTypeDisplay.="<option>MT</option>";
                                              $StrTypeDisplay.="<option>RMB</option>";
                                           }
                                           ECHO $StrTypeDisplay;

                                        ?>
                                      </select>
                                    </div>
                            </div>

                             <!-- CIORRECT DIVISION-->
                            <div class="form-group">
                                  <label for="inputPassword3" class="col-sm-5 control-label">Business Unit : *</label>

                                  <div class="col-sm-7" >
                                     <select required class="form-control" name="BU5" id="BU5">
                                      <?php
                                        if($StrDivision!=""){
                                          echo "<option>" .$StrDivision. "</option>";
                                          echo "<option>--</option>";
                                        }else{
                                          echo "<option>--</option>";
                                        }
                                      ?>

                                      <option>111</option>
                                      <option>211</option>
                                      <option>221</option>
                                      <option>271</option>
                                      <option>291</option>
                                      <option>311</option>
                                      <option>491</option>
                                      <option>511</option>
                                      <option>521</option>
                                      <option>871</option>
                                    </select>
                                  </div>
                            </div>
                      </div>
                   </div>
                   <div class="box box-warning"></div>
                    <!-- /.box-body -->
                   <div class="box-footer">
                      <button type="submit" class="btn medium bg-blue">Submit</button>
                      <?php
                      //  if(isset($_GET['ID'])){
                      //    echo "<a href='index.PHP'><button type='button' class='btn medium bg-green'>Home</button></a>";
                     //   }elseif(isset($_GET['InprogressID'])){
                     //     echo "<a href='InProgress.PHP'><button type='button' class='btn medium bg-green'>Home</button></a>";
                     //   }
                      ?>
                    </div>
                    <!-- /.box-footer -->
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
<script src="plugins/slimScroll/jquery.slimscroll.min.js"></script>fo
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
  // to filter the data per BUCKEt
    function LoadData(){
      var ID=($('select[name=BDM1]').val());
      
     // alert(ID);
      $.ajax({
          method: "POST",
          url: "Function/DisplayBDM.php",
          data: {Type:ID}
      }).done(function(msg){
          msg=msg.substring(2,msg.length);
          //alert(msg);
          document.getElementById('BDMU1').value=msg;
          document.getElementById('BDMU1F').value=msg;
      });  
    }

    function LoadData2(){
      var ID=($('select[name=BDM2]').val());
      
     // alert(ID);
      $.ajax({
          method: "POST",
          url: "Function/DisplayBDM.php",
          data: {Type:ID}
      }).done(function(msg){
          msg=msg.substring(2,msg.length);
          //alert(msg);
          document.getElementById('BDMU2').value=msg;
          document.getElementById('BDMU2F').value=msg;
      });  
    }

    function LoadData3(){
      var ID=($('select[name=BDM3]').val());
      
     // alert(ID);
      $.ajax({
          method: "POST",
          url: "Function/DisplayBDM.php",
          data: {Type:ID}
      }).done(function(msg){
          msg=msg.substring(2,msg.length);
          //alert(msg);
          document.getElementById('BDMU3').value=msg;
          document.getElementById('BDMU3F').value=msg;
      });  
    }

    function LoadData4(){
      var ID=($('select[name=BDM4]').val());
      
     // alert(ID);
      $.ajax({
          method: "POST",
          url: "Function/DisplayBDM.php",
          data: {Type:ID}
      }).done(function(msg){
          msg=msg.substring(2,msg.length);
          //alert(msg);
          document.getElementById('BDMU4').value=msg;
          document.getElementById('BDMU4F').value=msg;
      });  
    }

    function LoadData5(){
      var ID=($('select[name=BDM5]').val());
      
     // alert(ID);
      $.ajax({
          method: "POST",
          url: "Function/DisplayBDM.php",
          data: {Type:ID}
      }).done(function(msg){
          msg=msg.substring(2,msg.length);
          //lert(msg);
          document.getElementById('BDMU5').value=msg;
          document.getElementById('BDMU5F').value=msg;
      });  
    }


    //JSA ACCOUNT HERE
    function LoadDataJSA1(){
      var ID=($('select[name=JSA1]').val());
      
     // alert(ID);
      $.ajax({
          method: "POST",
          url: "Function/DisplayBDM.php",
          data: {Type:ID}
      }).done(function(msg){
          msg=msg.substring(2,msg.length);
          //alert(msg);
          document.getElementById('JSAU1').value=msg;
          document.getElementById('JSAU1F').value=msg;
      });  
    }

     function LoadDataJSA2(){
      var ID=($('select[name=JSA2]').val());
      
     // alert(ID);
      $.ajax({
          method: "POST",
          url: "Function/DisplayBDM.php",
          data: {Type:ID}
      }).done(function(msg){
          msg=msg.substring(2,msg.length);
          //alert(msg);
          document.getElementById('JSAU2').value=msg;
          document.getElementById('JSAU2F').value=msg;
      });  
    }

     function LoadDataJSA3(){
      var ID=($('select[name=JSA3]').val());
      
     // alert(ID);
      $.ajax({
          method: "POST",
          url: "Function/DisplayBDM.php",
          data: {Type:ID}
      }).done(function(msg){
          msg=msg.substring(2,msg.length);
          //alert(msg);
          document.getElementById('JSAU3').value=msg;
          document.getElementById('JSAU3F').value=msg;
      });  
    }

     function LoadDataJSA4(){
      var ID=($('select[name=JSA4]').val());
      
     // alert(ID);
      $.ajax({
          method: "POST",
          url: "Function/DisplayBDM.php",
          data: {Type:ID}
      }).done(function(msg){
          msg=msg.substring(2,msg.length);
          //alert(msg);
          document.getElementById('JSAU4').value=msg;
          document.getElementById('JSAU4F').value=msg;
      });  
    }

     function LoadDataJSA5(){
      var ID=($('select[name=JSA5]').val());
      
     // alert(ID);
      $.ajax({
          method: "POST",
          url: "Function/DisplayBDM.php",
          data: {Type:ID}
      }).done(function(msg){
          msg=msg.substring(2,msg.length);
          //alert(msg);
          document.getElementById('JSAU5').value=msg;
          document.getElementById('JSAU5F').value=msg;
      });  
    }

   


    function Disabled(){
      document.getElementById("BDMU1").disabled=true;
      document.getElementById("BDMU2").disabled=true;
      document.getElementById("BDMU3").disabled=true;
      document.getElementById("BDMU4").disabled=true;
      document.getElementById("BDMU5").disabled=true;

      document.getElementById("JSAU1").disabled=true;
      document.getElementById("JSAU2").disabled=true;
      document.getElementById("JSAU3").disabled=true;
      document.getElementById("JSAU4").disabled=true;
      document.getElementById("JSAU5").disabled=true;
      
    }
</script>






</body>
</html>



