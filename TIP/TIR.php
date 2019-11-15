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
  



    <input type=hidden name='NoData' id='NoData' value="<?php echo $strNoData?>">
    <input type=hidden name='PendingNumber' id='PendingNumber' value="<?php echo $strNumberPending ?>">
    <input type=hidden name='BoolUpdate' id='BoolUpdate' value="<?php    if(isset($_GET['Update'])){echo $_GET['Update'];}   ?>"   >

    <div class="alert alert-danger alert-dismissible" id="myDIV">
      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
      <h4><i class="icon fa fa-check"></i> You have completely submitted the entries!</h4>
    </div>


  
      <table class="table table-bordered">
          <tr>
              <td class="text-left"><h1>TIR Data</h1></td>
              <?php
                $strButton="";
                if($UserType=="Business Development Manager"){ // to know if this is BDM
                  $strButton.="<td><br><button type='button' class='btn btn-block btn-primary btn-lg'  data-toggle='modal' data-target='#exampleModal'>Filter By</button></td>";
                  $strButton.="<td><br><button type='button' onclick='myFunction()' class='btn btn-block btn-primary btn-lg'>Submit</button></td>";

                  
                }elseif($UserType=="Sales Finance Assistant" or $UserType=="Sales Controller"){
                  $strButton.="<td><br><a href='Function/UpdateSubmitted.php?Index=1'><button type='button' class='btn btn-block btn-primary btn-lg'>Submit</button></td></a>";
                }
                echo $strButton;
              ?>
              
          </tr>
      </table>

      <div class="row">
        <div class="col-xs-12">
            <div class="box">


                     <div class="modal fade" id="exampleModal"  tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
                        <div class="modal-dialog" role="document">
                          <div class="modal-content">
                            <div class="modal-header">
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                              <h4 class="modal-title" id="mySmallModalLabel"> List of Account </h4>
                            </div>
                            <div class="modal-body">

                              <form class="form-horizontal" action='DatafillFiltered.php' method='POST' enctype="multipart/form-data">
                                  <div class="box-body">
                                      <div class="form-group">
                                          <?php
                                              include("model/dbcon.php");
                                              $sqlData="select   parent_cd,parent_name, count(*) as COUNTER from tip.Vw_BDMUserTagging  where bdm_username='".$parentCode."' and company_Cd in (". $BusinessUnit .")  and IsStatus IN ('Pending','draft') and reporting_period in (select max(reporting_period) from [TIP].[Vw_BDMUserTagging] where reporting_year in (select max(reporting_year) from [TIP].[Vw_BDMUserTagging] ) ) group by parent_cd,parent_name"; 
                                              //echo $sqlData;
                                              $stmt=sqlsrv_query($con,$sqlData);  
                                              
                                              $strAccount="";
                                              while($row=sqlsrv_fetch_array($stmt,SQLSRV_FETCH_ASSOC)){
                                                $strAccount.="<label><input required type='radio' name='AccountHandled' id='AccountHandled' class='minimal' value=".$row['parent_cd'].">  ".$row['parent_name']. "  (".$row['COUNTER'].")"."</label></br>";
                                              }
                                                
                                              echo $strAccount;
                                          ?>
                                      </div>
                                  </div>


                                    <div class="modal-footer">
                                      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                      <button type="submit" class="btn btn-primary" >Proceed</button>
                                    </div>
                              </form>

                               


                            </div>
                            
                          </div>
                        </div>
                      </div>

              <div class="box-body">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                    <tr>
                      <?php
                        
                        if($UserType=="Business Development Manager"){ // to know if this is SALES ADMIN
                          $strHeader="<th>Business Unit</th>";
                          $strHeader.="<th>Customer Name</th>";
                          $strHeader.="<th>Budget</th>";
                          $strHeader.="<th>Amount</th>";
                          $strHeader.="<th>Document Number</th>";
                          $strHeader.="<th>Account Status</th>";
                          $strHeader.="<th>Action</th>";
                        }elseif($UserType=="Sales Finance Assistant" or $UserType=="Sales Controller"){ // to know if this is BDM
                          $strHeader="<th>Business Unit</th>";
                          $strHeader.="<th>Customer  Name</th>";
                          $strHeader.="<th>BDM Name</th>";
                          $strHeader.="<th>District</th>";
                          $strHeader.="<th>Account Status</th>";
                          $strHeader.="<th>Submitted Status</th>";
                          $strHeader.="<th>Action</th>";
                        }elseif($UserType=="District Business Development Manager"){ 
                          $strHeader="<th>Business Unit</th>";
                          $strHeader.="<th>Customer  Name</th>";
                          $strHeader.="<th>Budget Type</th>";
                          $strHeader.="<th>BDM Name</th>";
                          $strHeader.="<th>Account Status</th>";
                          $strHeader.="<th>Submitted Status</th>";
                          $strHeader.="<th>Action</th>";
                        }elseif($UserType=="Credit and Collection Supervisor" or $UserType=="Credit Analyst"){ // to know if this is BDM
                          $strHeader="<th>Business Unit</th>";
                          $strHeader.="<th>Customer  Name</th>";
                          $strHeader.="<th>Budget Type</th>";
                          $strHeader.="<th>Amount</th>";
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
                        if($UserType=="Sales Finance Assistant" or $UserType=="Sales Controller"){// to KNOW if this is SALES finance
                          $sql="select distinct dim5_Desc,ID,division,dim4_Cd,PARENT_NAME,NAME,bp_parent_name,district,isstatus,IsStatusSubmitted,ispoke from tip.Vw_BDMUserTagging where isstatuscomplete<>'Completed' and reporting_period in (select max(reporting_period) from [TIP].[Vw_BDMUserTagging] where reporting_year in (select max(reporting_year) from [TIP].[Vw_BDMUserTagging] ) )";
                        }

                        elseif($UserType=="Credit and Collection Supervisor"){ // credit and collection to!
                          $sql="select distinct dim5_Desc,ID,division,target_Company,bp_parent_Cd,bp_parent_name,budget_desc,transaction_Amount,dim4_Cd ,isstatus,ispoke,IsStatusSubmitted from tip.Vw_BDMUserTagging where IsStatuscomplete='Completed' and IsStatusSubmitted not in('Approved','Disapproved') and id in (select dataid from tip.TIR_ShouldBE where   hasvalidation='YES' or correctexpense='YES' or correctDIVISION='YES' ) and reporting_period in (select max(reporting_period) from [TIP].[Vw_BDMUserTagging] where reporting_year in (select max(reporting_year) from [TIP].[Vw_BDMUserTagging] ) )  ";                            
                          //and id in (select dataid from tip.TIR_ShouldBE where hasvalidation='YES' )
                        }elseif($UserType=="Credit Analyst"){ // credit and collection to!
                          $sql="select distinct dim5_Desc,ID,division,target_Company,bp_parent_Cd,bp_parent_name,budget_desc,transaction_Amount,dim4_Cd ,isstatus,ispoke,IsStatusSubmitted from tip.Vw_BDMUserTagging where IsStatuscomplete='Completed' and IsStatusSubmitted not in('Approved','Disapproved') and id in (select dataid from tip.TIR_ShouldBE where   hasvalidation='YES' or correctexpense='YES' or correctDIVISION='YES' ) and reporting_period in (select max(reporting_period) from [TIP].[Vw_BDMUserTagging] where reporting_year in (select max(reporting_year) from [TIP].[Vw_BDMUserTagging] ) ) and [analyst username]='" .$parentCode. "'";                            
                          // IsStatuscomplete='Completed' and
                        }
                        elseif($UserType=="District Business Development Manager"){ 
                          $sql="select distinct name,dim5_Desc,ID,division,target_Company,bp_parent_Cd,bp_parent_name,budget_desc,transaction_Amount,dim4_Cd ,isstatus,ispoke,IsStatusSubmitted from tip.Vw_BDMUserTagging where [DBDM Name]='".$DBDM_Name."' and IsStatusSubmitted<>'Submitted'  and reporting_period in (select max(reporting_period) from [TIP].[Vw_BDMUserTagging] where reporting_year in (select max(reporting_year) from [TIP].[Vw_BDMUserTagging] ) )";
                        }
                        else{
                          $sql="select document_no,dim5_Desc,ID,division,target_Company,bp_parent_Cd,bp_parent_name,budget_desc,transaction_Amount,dim4_Cd ,isstatus,ispoke,IsStatusSubmitted from tip.Vw_BDMUserTagging where bdm_username='".$parentCode."' and company_Cd in (". $BusinessUnit .")  and IsStatusSubmitted='Pending' and reporting_period in (select max(reporting_period) from [TIP].[Vw_BDMUserTagging] where reporting_year in (select max(reporting_year) from [TIP].[Vw_BDMUserTagging] ) )";
                          //and bp_type_cd='".$channel."'
                        }
                        
                        //and company_Cd='". $BU ."'
                        // NEED ILAGAY TO


                       //echo $sql;
                        $stmt=sqlsrv_query($con,$sql);

                        $strDisplay="";
                         while($row=sqlsrv_fetch_array($stmt,SQLSRV_FETCH_ASSOC)){
                            $strDisplay.="<tr>";
                                if($UserType=="Sales Finance Assistant" or $UserType=="Sales Controller"){ // to know if this is SALES ADMIN
                                  $strDisplay.="<td>$row[dim5_Desc]</td>";
                                  $strDisplay.="<td>$row[bp_parent_name]</td>";
                                  $strDisplay.="<td>$row[NAME]</td>";
                                  $strDisplay.="<td>$row[district]</td>";
                                  $strDisplay.="<td>$row[isstatus]</td>";
                                  $strDisplay.="<td>$row[IsStatusSubmitted]</td>";

                                  if($row['IsStatusSubmitted']=="Submitted" or $row['ispoke']==1){ //to know if the data is submitted then no need to POKE
                                    if($row['IsStatusSubmitted']=="Submitted"){
                                      $strDisplay.="<td>
                                          <a href='ViewSalesFinance.php?ID=$row[ID]' class='btn medium bg-blue tooltip-button' data-placement='top' title='Edit'>
                                            &nbsp;&nbsp;&nbsp;View &nbsp;&nbsp;&nbsp;
                                          </a>
                                      </td>";  
                                    }else{
                                      $strDisplay.="<td>
                                          &nbsp;&nbsp;&nbsp;<B>Already Nudge</B>&nbsp;&nbsp;&nbsp;
                                      </td>";  
                                    }
                                  }else{ 
                                    $strDisplay.="<td>
                                        <a href='Function/UpdatePoke.php?ID=$row[ID]' class='btn medium bg-red tooltip-button' data-placement='top'>
                                            &nbsp;&nbsp;&nbsp;Nudge&nbsp;&nbsp;&nbsp;
                                        </a>                                   
                                    </td>";  
                                  }
                                  
                                }else{ // PAG eto ay BD,
                                  //<a href='Reclass.php?ID=$row[ID]'>
//                                    &nbsp;&nbsp;&nbsp;Re-class&nbsp;&nbsp;&nbsp;</a>  
                                  $strDisplay.="<td>$row[dim5_Desc]</td>";
                                  $strDisplay.="<td>$row[bp_parent_name]</td>";
                                  $strDisplay.="<td>$row[budget_desc]</td>";
                                  if($UserType=="District Business Development Manager"){ 
                                    $strDisplay.="<td>$row[name]</td>";
                                  }else{
                                    $strDisplay.="<td>".number_format($row['transaction_Amount'],2)."</td>";
                                  }

                                  if($UserType=="Credit and Collection Supervisor" or $UserType=="Credit Analyst" or $UserType=="District Business Development Manager"){ // credit and collection to!
                                    $strDisplay.="<td>$row[isstatus]</td>";
                                    $strDisplay.="<td>$row[IsStatusSubmitted]</td>";
                                  }else{
                                   $strDisplay.="<td>$row[document_no]</td>";
                                  $strDisplay.="<td>$row[isstatus]</td>"; 
                                  }


                                  if($UserType=="Credit and Collection Supervisor" or $UserType=="Credit Analyst"){
                                    $strDisplay.="<td>  
                                        <a href='ViewCredit.php?ID=$row[ID]' class='btn medium bg-red tooltip-button' data-placement='top'>
                                            &nbsp;&nbsp;&nbsp;View&nbsp;&nbsp;&nbsp;
                                        </a>
                                    </td>";
                                    
                                  }elseif($UserType=="District Business Development Manager"){
                                    $strDisplay.="<td>  
                                        <a href='ViewApproved.php?ID=$row[ID]' class='btn medium bg-red tooltip-button' data-placement='top'>
                                            &nbsp;&nbsp;&nbsp;View&nbsp;&nbsp;&nbsp;
                                        </a>
                                    </td>";
                                  }else{
                                    $strDisplay.="<td>
                                      <a href='DataFill.php?ID=$row[ID]' class='btn medium bg-green tooltip-button' data-placement='top' title='Edit'>
                                          &nbsp;&nbsp;&nbsp;Fill-in&nbsp;&nbsp;&nbsp;
                                      </a>                                   
                                    </td>";
                                  }

                                }

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





</body>
</html>


