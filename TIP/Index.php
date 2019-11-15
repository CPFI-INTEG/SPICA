<?php
  if(session_status() != PHP_SESSION_ACTIVE) {
      session_start();
  }

  $parentCode=$_SESSION['BDM_USERNAME']; // THIS IS THE FIELD OF BDM NAME
  $UserType=$_SESSION['UserType']; // THIS IS THE FIELD OF BDM NAME
  $channel=$_SESSION['channel']; // THIS IS THE FIELD OF BDM NAME
  $BusinessUnit=$_SESSION['BU']; // THIS IS THE FIELD OF BDM NAME
  $DBDM_Name=$_SESSION['Name']; 




  $strNumberPending="";
  $strNoData="";


  include("model/dbcon.php");
  //TO KNOW IF THERES RECORD
  $sqlNoData="select id from tip.Vw_BDMUserTagging where bdm_username='".$parentCode."' AND  company_Cd in (". $BusinessUnit .")  and isstatussubmitted<>'Submitted' and reporting_period in (select max(reporting_period) from [TIP].[Vw_BDMUserTagging] where reporting_year in (select max(reporting_year) from [TIP].[Vw_BDMUserTagging] ) )";
  //and DATEPART(month, document_Date)=DATEPART(month, getdate())-2
  //echo $sqlNoData;
  $stmtNoData=sqlsrv_query($con,$sqlNoData);  
  if($stmtNoData){
    $rowsNoData = sqlsrv_has_rows($stmtNoData); // number of rows OR (true or false)
    $strNoData= $rowsNoData;  
  }



  //TO KNOW IF THERES PENDING
  $sqlData="select id from tip.Vw_BDMUserTagging where  bdm_username='".$parentCode."'  AND  company_Cd in (". $BusinessUnit .") and reporting_period in (select max(reporting_period) from [TIP].[Vw_BDMUserTagging] where reporting_year in (select max(reporting_year) from [TIP].[Vw_BDMUserTagging] ) ) and (isstatus='Pending' or isstatus='Draft')"; 
 // echo $sqlData;
  $stmt=sqlsrv_query($con,$sqlData);  
  if($stmt){
    $rows = sqlsrv_has_rows($stmt); // number of rows OR (true or false)
    $strNumberPending= $rows;  
  }

  //and company_Cd ='". $BU ."'
  // NEED ILAGAY TO

  function CountData($sql){
    //ECHO $sql;
    include("model/dbcon.php");

    $stmtCounter=sqlsrv_query($con,$sql);
    while($row=sqlsrv_fetch_array($stmtCounter,SQLSRV_FETCH_NUMERIC)){
      echo $row[0];
    }
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
     
      
      <h1>Dashboard</h1>
    
      <div class="row">
        <div class="col-xs-12">
                <!-- Small boxes (Stat box) -->
                            <div class="row">

                               <div class="col-lg-3 col-xs-6">
                                <!-- small box -->
                                <div class="small-box bg-navy">
                                  <div class="inner">
                                    <h3>
                                      <?PHP
                                          if($UserType=="Sales Finance Assistant"  or $UserType=="Sales Controller" ){// to know if this is SALES finance
                                            CountData("select count(id) from tip.Vw_BDMUserTagging where  reporting_period in (select max(reporting_period) from [TIP].[Vw_BDMUserTagging] where reporting_year in (select max(reporting_year) from [TIP].[Vw_BDMUserTagging] ) )");
                                          }elseif($UserType=="Credit and Collection Supervisor"){ // credit and collection to!
                                            //id in (select dataid from tip.TIR_ShouldBE where hasvalidation='YES') 
                                            CountData("select COUNT(id) from tip.Vw_BDMUserTagging where isstatuscomplete='Completed' and id in (select dataid from tip.TIR_ShouldBE where hasvalidation='YES') and reporting_period in (select max(reporting_period) from [TIP].[Vw_BDMUserTagging] where reporting_year in (select max(reporting_year) from [TIP].[Vw_BDMUserTagging] ) )");
                                          }elseif($UserType=="District Business Development Manager"){ 
                                            CountData("select count(id) from tip.Vw_BDMUserTagging where  reporting_period in (select max(reporting_period) from [TIP].[Vw_BDMUserTagging] where reporting_year in (select max(reporting_year) from [TIP].[Vw_BDMUserTagging] ) )");
                                          }elseif($UserType=="Credit Analyst"){ // credit and collection to!
                                            CountData("select COUNT(id) from tip.Vw_BDMUserTagging where isstatuscomplete='Completed' and id in (select dataid from tip.TIR_ShouldBE where hasvalidation='YES') and reporting_period in (select max(reporting_period) from [TIP].[Vw_BDMUserTagging] where reporting_year in (select max(reporting_year) from [TIP].[Vw_BDMUserTagging] ) ) and [analyst username]='" .$parentCode. "'");
                                          }else{ 
                                            CountData("select count(id) from tip.Vw_BDMUserTagging where bdm_username='".$parentCode."' and company_Cd in (". $BusinessUnit .")   and reporting_period in (select max(reporting_period) from [TIP].[Vw_BDMUserTagging] where reporting_year in (select max(reporting_year) from [TIP].[Vw_BDMUserTagging] ) )");
                                          }
                                      ?>
                                    </h3>

                                    <p>Total No. of CM</p>
                                  </div>
                                  <div class="icon">
                                    <i class="fa fa-cogs"></i>
                                  </div>
                                  <a href="MoreInfoTIR.php?Info=Total" class="small-box-footer">
                                    More info <i class="fa fa-arrow-circle-right"></i>
                                  </a>
                                </div>
                              </div>
                              <!-- ./col -->
                                      <!-- ./col -->
                              <div class="col-lg-3 col-xs-6">
                                <!-- small box -->
                                <div class="small-box bg-teal">
                                  <div class="inner">
                                    <h3>
                                      <?PHP
                                          if($UserType=="Sales Finance Assistant" or $UserType=="Sales Controller"){// to know if this is SALES finance
                                            CountData("select count(id) from tip.Vw_BDMUserTagging where  IsStatusSubmitted='Submitted'   and reporting_period in (select max(reporting_period) from [TIP].[Vw_BDMUserTagging] where reporting_year in (select max(reporting_year) from [TIP].[Vw_BDMUserTagging] ) )");
                                          }elseif($UserType=="Credit and Collection Supervisor"){ // credit and collection to!
                                            CountData("select 0");
                                          }elseif($UserType=="District Business Development Manager"){ 
                                            CountData("select count(id) from tip.Vw_BDMUserTagging where  IsStatusSubmitted='Submitted'   and reporting_period in (select max(reporting_period) from [TIP].[Vw_BDMUserTagging] where reporting_year in (select max(reporting_year) from [TIP].[Vw_BDMUserTagging] ) )");
                                          }elseif($UserType=="Credit Analyst"){ // credit and collection to!
                                            CountData("select 0");
                                          }else{ 
                                            CountData("select count(id) from tip.Vw_BDMUserTagging where bdm_username='".$parentCode."' and company_Cd in (". $BusinessUnit .") AND IsStatusSubmitted='Submitted'  and reporting_period in (select max(reporting_period) from [TIP].[Vw_BDMUserTagging] where reporting_year in (select max(reporting_year) from [TIP].[Vw_BDMUserTagging] ) )");
                                          }
                                      ?>
                                    </h3>

                                    <p>No. of Submitted</p>
                                  </div>
                                  <div class="icon">
                                    <i class="fa fa-inbox"></i>
                                  </div>
                                  <a href="MoreInfoTIR.php?Info=Draft" class="small-box-footer">
                                    More info <i class="fa fa-arrow-circle-right"></i>
                                  </a>
                                </div>
                              </div>


                              <div class="col-lg-3 col-xs-6">
                                <!-- small box -->
                                <div class="small-box bg-aqua">
                                  <div class="inner">
                                    <h3>
                                      <?PHP
                                          if($UserType=="Sales Finance Assistant" or $UserType=="Sales Controller"){// to know if this is SALES finance
                                            CountData("select count(id) from tip.Vw_BDMUserTagging where  ISSTATUS='Accomplished'   and reporting_period in (select max(reporting_period) from [TIP].[Vw_BDMUserTagging] where reporting_year in (select max(reporting_year) from [TIP].[Vw_BDMUserTagging] ) )");
                                          }elseif($UserType=="Credit and Collection Supervisor"){ // credit and collection to!
                                            CountData("select COUNT(id) from tip.Vw_BDMUserTagging where isstatuscomplete ='Completed' and IsStatusSubmitted in('Approved','Disapproved') and reporting_period in (select max(reporting_period) from [TIP].[Vw_BDMUserTagging] where reporting_year in (select max(reporting_year) from [TIP].[Vw_BDMUserTagging] ) )");
                                            //and id in (select dataid from tip.TIR_ShouldBE where hasvalidation='YES')
                                          }elseif($UserType=="District Business Development Manager"){ 
                                            CountData("select count(id) from tip.Vw_BDMUserTagging where  ISSTATUS='Accomplished'   and reporting_period in (select max(reporting_period) from [TIP].[Vw_BDMUserTagging] where reporting_year in (select max(reporting_year) from [TIP].[Vw_BDMUserTagging] ) )");
                                          }elseif($UserType=="Credit Analyst"){ // credit and collection to!
                                            CountData("select COUNT(id) from tip.Vw_BDMUserTagging where isstatuscomplete ='Completed' and IsStatusSubmitted in('Approved','Disapproved') and id in (select dataid from tip.TIR_ShouldBE where hasvalidation='YES') and reporting_period in (select max(reporting_period) from [TIP].[Vw_BDMUserTagging] where reporting_year in (select max(reporting_year) from [TIP].[Vw_BDMUserTagging] ) ) and [analyst username]='" .$parentCode. "'");
                                          }else{ 
                                            CountData("select count(id) from tip.Vw_BDMUserTagging where bdm_username='".$parentCode."' and company_Cd in (". $BusinessUnit .") AND ISSTATUS='Accomplished'   and reporting_period in (select max(reporting_period) from [TIP].[Vw_BDMUserTagging] where reporting_year in (select max(reporting_year) from [TIP].[Vw_BDMUserTagging] ) )");
                                          }
                                      ?>
                                    </h3>

                                    <p>No. of Accomplished</p>
                                  </div>
                                  <div class="icon">
                                    <i class="fa fa-check"></i>
                                  </div>
                                  <a href="MoreInfoTIR.php?Info=Accomplished" class="small-box-footer">
                                    More info <i class="fa fa-arrow-circle-right"></i>
                                  </a>
                                </div>
                              </div>
                      
                              <!-- ./col -->
                              <div class="col-lg-3 col-xs-6">
                                <!-- small box -->
                                <div class="small-box bg-gray">
                                  <div class="inner">
                                    <h3>
                                      <?PHP
                                            if($UserType=="Sales Finance Assistant" or $UserType=="Sales Controller"){// to know if this is SALES finance
                                              CountData("select count(id) from tip.Vw_BDMUserTagging where  IsStatus in('Pending','Draft') and reporting_period in (select max(reporting_period) from [TIP].[Vw_BDMUserTagging] where reporting_year in (select max(reporting_year) from [TIP].[Vw_BDMUserTagging] ) )");
                                            }elseif($UserType=="Credit and Collection Supervisor"){ // credit and collection to!
                                              CountData("select COUNT(id) from tip.Vw_BDMUserTagging where isstatuscomplete ='Completed' and id in (select dataid from tip.TIR_ShouldBE where hasvalidation='YES') and reporting_period in (select max(reporting_period) from [TIP].[Vw_BDMUserTagging] where reporting_year in (select max(reporting_year) from [TIP].[Vw_BDMUserTagging] ) )");
                                            }elseif($UserType=="District Business Development Manager"){ 
                                              CountData("select count(id) from tip.Vw_BDMUserTagging where  IsStatus in('Pending','Draft') and reporting_period in (select max(reporting_period) from [TIP].[Vw_BDMUserTagging] where reporting_year in (select max(reporting_year) from [TIP].[Vw_BDMUserTagging] ) )");
                                            }elseif($UserType=="Credit Analyst"){ // credit and collection to!
                                              CountData("select COUNT(id) from tip.Vw_BDMUserTagging where isstatuscomplete ='Completed' and id in (select dataid from tip.TIR_ShouldBE where hasvalidation='YES') and reporting_period in (select max(reporting_period) from [TIP].[Vw_BDMUserTagging] where reporting_year in (select max(reporting_year) from [TIP].[Vw_BDMUserTagging] ) ) and [analyst username]='" .$parentCode. "'");
                                            }else{ 
                                              CountData("select count(id) from tip.Vw_BDMUserTagging where bdm_username='".$parentCode."' and company_Cd in (". $BusinessUnit .")  and IsStatus in('Pending','Draft') and reporting_period in (select max(reporting_period) from [TIP].[Vw_BDMUserTagging] where reporting_year in (select max(reporting_year) from [TIP].[Vw_BDMUserTagging] ) )");
                                              
                                            }
                                        
                                      ?>
                                    </h3>

                                    <p>No. of Pending/Draft</p>
                                  </div>
                                  <div class="icon">
                                    <i class="fa fa-hourglass"></i>
                                  </div>
                                  <a href="MoreInfoTIR.php?Info=Pending" class="small-box-footer">
                                    More info <i class="fa fa-arrow-circle-right"></i>
                                  </a>
                                </div>
                              </div>
                              <!-- ./col -->
                             
                            </div>  
                            <!-- /.row -->

                               <div class="row">
                                    <div class="col-md-9">
                                      <div class="box">
                                        <div class="box-header with-border">
                                          <h3 class="box-title">Monthly Statistics</h3>
                                        </div>
                                        <!-- /.box-header -->
                                        <div class="box-body">
                                          <div class="row">
                                            <div class="col-md-12">
                                              <p class="text-center">
                                                <strong>2018 : January - December</strong>
                                              </p>

                                              <div class="chart">
                                                <canvas id="salesChart" style="height: 220px;"></canvas>
                                              </div>
                                            </div>
                                          </div>
                                          <!-- /.row -->
                                        </div>
                                      </div>
                                    </div>



                                     <div class="col-md-3">
                                        <div class="box">
                                          <div class="box-header with-border">
                                            <h3 class="box-title">Actual Deductions</h3>
                                          </div>
                                          <!-- /.box-header -->
                                          <div class="box-body">
                                            <ul class="products-list product-list-in-box">

                                              <?PHP
                                                  $STRRejcted="";
                                                  include("model/dbcon.php");

                                                //COUNTING NAMAN TO
                                                  if($Usertype=="Sales Finance Assistant" or $UserType=="Sales Controller" or $UserType=="Credit and Collection Supervisor" or $UserType=="Credit Analyst"){// to know if this is SALES finance
                                                      $sqlSummary="select SUM(TOTAL_AMOUNT) as total,FISCAL_YEAR,FISCAL_PERIOD,BUDGET_BUCKET from dbo.TIP_BDM_TIR_SUMMARY WHERE  FISCAL_YEAR in (select max(reporting_year) from [TIP].[Vw_BDMUserTagging] ) AND FISCAL_PERIOD in (select max(reporting_period) from [TIP].[Vw_BDMUserTagging] where reporting_year in (select max(reporting_year) from [TIP].[Vw_BDMUserTagging] ) )  GROUP BY FISCAL_YEAR,FISCAL_PERIOD,BUDGET_BUCKET ";
                                                  }else{
                                                      $sqlSummary="select SUM(TOTAL_AMOUNT) as total,FISCAL_YEAR,FISCAL_PERIOD,BDM_USERNAME,BDM_NAME,DBDM,CHANNEL,BUDGET_BUCKET from dbo.TIP_BDM_TIR_SUMMARY WHERE  bdm_username='".$parentCode."' AND FISCAL_YEAR in (select max(reporting_year) from [TIP].[Vw_BDMUserTagging] ) AND FISCAL_PERIOD in (select max(reporting_period) from [TIP].[Vw_BDMUserTagging] where reporting_year in (select max(reporting_year) from [TIP].[Vw_BDMUserTagging] ) )  GROUP BY FISCAL_YEAR,FISCAL_PERIOD,BDM_USERNAME,BDM_NAME,DBDM,CHANNEL,BUDGET_BUCKET";
                                                      
                                                  }
                                                 //echo $sqlSummary;
                                                  $stmtSummary=sqlsrv_query($con,$sqlSummary);  
                                                  while($row=sqlsrv_fetch_array($stmtSummary,SQLSRV_FETCH_ASSOC)){
                                                    $STRRejcted.="<li class='item'>";
                                                        //$STRRejcted.="<a href='ViewSalesFinance.php?ID=".$row['ID']."&Type=RejectUpdate' class='product-title'>Document Number : ".$row['DOCUMENT_NO']."</a>";
                                                        $STRRejcted.="<b>".$row['BUDGET_BUCKET']."</b>";
                                                        $STRRejcted.="<br>";
                                                        $STRRejcted.=number_format($row['total'],2);
                                                    $STRRejcted.="</li>";
                                                  }
                                                  
                                                  echo $STRRejcted;
                                              ?>
                                              
                                            </ul>
                                          </div>
                                                     
                                      </div>

                                            
                                      </div>
                                  </div>

                                
















          </div>
      </div>

            <!-- /.row (main row) -->

    </section>



  </div>

<?php include("footer.php"); //THIS IS FOOTER---------------------------------------------------------------------- ?>

  
</div>


<!--  TO GET THE LABELS IN STATISTICS-->
<?PHP
   include("model/dbcon.php");
   $strHoldLabel="";$strCtrAccom="";$strCtrTotal="";

   
   if($UserType=="Sales Finance Assistant" or $UserType=="Sales Controller"){// to know if this is SALES finance
      $sqlLabel="select Month,reporting_period,sum(CtrTotal) as CtrTotal,sum(CtrAcomplished) as CtrAcomplished from TIP.Vw_Statistics where  reporting_year in (select max(reporting_year) from [TIP].[Vw_BDMUserTagging] ) group by Month ,reporting_period order by reporting_period";
    }elseif($UserType=="Credit and Collection Supervisor" or $UserType=="Credit Analyst" ){ // credit and collection to!
      $sqlLabel="select Month,reporting_period,sum(CtrTotal) as CtrTotal,sum(CtrAcomplished) as CtrAcomplished from TIP.Vw_Statistics where  reporting_year in (select max(reporting_year) from [TIP].[Vw_BDMUserTagging] ) group by Month ,reporting_period order by reporting_period";
    }elseif($UserType=="District Business Development Manager"){ 
      $sqlLabel="select Month,reporting_period,sum(CtrTotal) as CtrTotal,sum(CtrAcomplished) as CtrAcomplished from TIP.Vw_Statistics where  reporting_year in (select max(reporting_year) from [TIP].[Vw_BDMUserTagging] ) group by Month ,reporting_period order by reporting_period";

    }elseif($UserType=="Credit Analyst"){ // credit and collection to!
      //$sqlLabel="select Month,sum(CtrTotal) as CtrTotal,sum(CtrAcomplished) as CtrAcomplished from TIP.Vw_Statistics  where [analyst username]='" .$parentCode. "' group by Month order by Month";
    }
    else{ 
      $sqlLabel="select Month,CtrTotal,CtrAcomplished from TIP.Vw_Statistics where bdm_username='" .$parentCode. "' AND reporting_year in (select max(reporting_year) from [TIP].[Vw_BDMUserTagging] ) order by reporting_period";
     // $sqlLabel="select * from TIP.Vw_Statistics where bdm_username='" .$parentCode. "' AND reporting_period in (select max(reporting_period) from [TIP].[Vw_BDMUserTagging] where reporting_year in (select max(reporting_year) from [TIP].[Vw_BDMUserTagging] ) )";
    }
   //echo $sqlLabel;
   $stmtLabel=sqlsrv_query($con,$sqlLabel);
   while($rowLabel=sqlsrv_fetch_array($stmtLabel,SQLSRV_FETCH_ASSOC)){
      $strHoldLabel.='"' .$rowLabel['Month'].'",';
      $strCtrTotal.=$rowLabel['CtrTotal'].",";
      $strCtrAccom.=$rowLabel['CtrAcomplished'].",";
   }

  // echo $strCtrTotal;
  // echo $strCtrAccom;

?>









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
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="plugins/chartjs/Chart.min.js"></script>
<script src="dist/js/app.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
<script src="plugins/iCheck/icheck.min.js"></script>


<script>
  //iCheck for checkbox and radio inputs
  $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
    checkboxClass: 'icheckbox_minimal-blue',
    radioClass: 'iradio_minimal-blue'
  });

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

function isNoEntries(){
  var NoData = document.getElementById('NoData').value;

  if(NoData==""){ // to know if theres data
    alert('No records are available'); 
  }else{
    window.open('DataFillAdvanced.php','_self')
  }
}

function myFunction(){
    var PendingNumber = document.getElementById('PendingNumber').value;
    var NoData = document.getElementById('NoData').value;
    var IsUpdate= document.getElementById('BoolUpdate').value;

      var x = document.getElementById('myDIV');
      if (x.style.display === 'none') { // to validate if theres pending item

      //  if(NoData!=""){ // to know if theres data
          if(PendingNumber==""){ // to know if theres pending
           //  alert(IsUpdate); 
           // if(IsUpdate=="true"){ // to validate if displaying of ALERT is okay na
           //  x.style.display = 'block';  
          //  }else{
              window.open('Function/UpdateSubmitted.php','_self') ;
          //  }
          }else{
            alert('Kindly fill-in all data to Accomplish.');
          }
     //   }else{
     //      alert('No records are available'); 
      //  }

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

  $('#exampleModal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget) // Button that triggered the modal
    var recipient = button.data('whatever') // Extract info from data-* attributes
    // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
    // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.

    
    
    $("#image_from_url").attr('src','images/'+recipient);
  //  modal.find('.modal-body input').val(recipient)
  })

</script>

<script>
          $(function () {

          'use strict';

          /* ChartJS
           * -------
           * Here we will create a few charts using ChartJS
           */

          //-----------------------
          //- MONTHLY SALES CHART -
          //-----------------------

          // Get context with jQuery - using jQuery's .get() method.
          var salesChartCanvas = $("#salesChart").get(0).getContext("2d");
          // This will get the first returned node in the jQuery collection.
          var salesChart = new Chart(salesChartCanvas);

          var salesChartData = {
            labels: [<?php echo substr($strHoldLabel, 0,strlen($strHoldLabel)-1); ?>],
            datasets: [
              {
                label: "Total No. of CM",
                fillColor: "rgb(210, 214, 222)",
                strokeColor: "rgb(210, 214, 222)",
                pointColor: "rgb(210, 214, 222)",
                pointStrokeColor: "#c1c7d1",
                pointHighlightFill: "#fff",
                pointHighlightStroke: "rgb(220,220,220)",
                data: [<?php echo substr($strCtrTotal, 0,strlen($strCtrTotal)-1); ?>]
              },
              {
                label: "Accomplished",
                fillColor: "rgba(60,141,188,0.9)",
                strokeColor: "rgba(60,141,188,0.8)",
                pointColor: "#3b8bba",
                pointStrokeColor: "rgba(60,141,188,1)",
                pointHighlightFill: "#fff",
                pointHighlightStroke: "rgba(60,141,188,1)",
                data: [<?php echo substr($strCtrAccom, 0,strlen($strCtrAccom)-1); ?>]
              }
            ]
          };

          var salesChartOptions = {
            //Boolean - If we should show the scale at all
            showScale: true,
            //Boolean - Whether grid lines are shown across the chart
            scaleShowGridLines: false,
            //String - Colour of the grid lines
            scaleGridLineColor: "rgba(0,0,0,.05)",
            //Number - Width of the grid lines
            scaleGridLineWidth: 1,
            //Boolean - Whether to show horizontal lines (except X axis)
            scaleShowHorizontalLines: true,
            //Boolean - Whether to show vertical lines (except Y axis)
            scaleShowVerticalLines: true,
            //Boolean - Whether the line is curved between points
            bezierCurve: true,
            //Number - Tension of the bezier curve between points
            bezierCurveTension: 0.3,
            //Boolean - Whether to show a dot for each point
            pointDot: false,
            //Number - Radius of each point dot in pixels
            pointDotRadius: 4,
            //Number - Pixel width of point dot stroke
            pointDotStrokeWidth: 1,
            //Number - amount extra to add to the radius to cater for hit detection outside the drawn point
            pointHitDetectionRadius: 20,
            //Boolean - Whether to show a stroke for datasets
            datasetStroke: true,
            //Number - Pixel width of dataset stroke
            datasetStrokeWidth: 2,
            //Boolean - Whether to fill the dataset with a color
            datasetFill: true,
            //String - A legend template
            legendTemplate: "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<datasets.length; i++){%><li><span style=\"background-color:<%=datasets[i].lineColor%>\"></span><%=datasets[i].label%></li><%}%></ul>",
            //Boolean - whether to maintain the starting aspect ratio or not when responsive, if set to false, will take up entire container
            maintainAspectRatio: true,
            //Boolean - whether to make the chart responsive to window resizing
            responsive: true
          };

          //Create the line chart
          salesChart.Line(salesChartData, salesChartOptions);

          //------------------
          //- SPARKLINE LINE -
          //------------------
          $('.sparkline').each(function () {
            var $this = $(this);
            $this.sparkline('html', {
              type: 'line',
              height: $this.data('height') ? $this.data('height') : '90',
              width: '100%',
              lineColor: $this.data('linecolor'),
              fillColor: $this.data('fillcolor'),
              spotColor: $this.data('spotcolor')
            });
          });
        });

</script>


</body>
</html>


