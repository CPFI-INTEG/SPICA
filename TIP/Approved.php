<?php
  if(session_status() != PHP_SESSION_ACTIVE) {
      session_start();
  }

  $parentCode=$_SESSION['BDM_USERNAME']; // THIS IS THE FIELD OF BDM NAME
  $UserType=$_SESSION['UserType']; // THIS IS THE FIELD OF BDM NAME
  $channel=$_SESSION['channel']; // THIS IS THE FIELD OF BDM NAME
  $BusinessUnit=$_SESSION['BU']; // THIS IS THE FIELD OF BDM NAME
  $DBDM_Name=$_SESSION['Name']; 
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
      <h1>Approved Data</h1>

      <div class="row">
        <div class="col-xs-12">
            <div class="box">
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
                          $strHeader.="<th>Expense Year</th>";
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

                        if($UserType=="Sales Finance Assistant" or $UserType=="Sales Controller"){// to know if this is SALES finance
                          $sql="select distinct district,dim5_Desc,ID,division,dim4_Cd,PARENT_NAME,NAME,bp_parent_name,district,isstatus,IsStatusSubmitted,ispoke,IsStatusSubmitted,isstatus  from tip.Vw_BDMUserTagging where IsStatusComplete='Completed' and reporting_period in (select max(reporting_period) from [TIP].[Vw_BDMUserTagging] where reporting_year in (select max(reporting_year) from [TIP].[Vw_BDMUserTagging] ) )";
                        
                        }elseif($UserType=="Credit and Collection Supervisor"){ // credit and collection to!
                          $sql="select  distinct budget_desc,transaction_Amount,dim5_Desc,ID,division,dim4_Cd,PARENT_NAME,NAME,bp_parent_name,district,isstatus,IsStatusSubmitted,ispoke,IsStatusSubmitted,isstatus from tip.Vw_BDMUserTagging where IsStatuscomplete='Completed' and IsStatusSubmitted ='Approved' and reporting_period in (select max(reporting_period) from [TIP].[Vw_BDMUserTagging] where reporting_year in (select max(reporting_year) from [TIP].[Vw_BDMUserTagging] ) )";                            
                          // and DATEPART(month, document_Date)=DATEPART(month, getdate())-2
                        }elseif($UserType=="Credit Analyst"){ // credit and collection to!
                          $sql="select  distinct budget_desc,transaction_Amount,dim5_Desc,ID,division,dim4_Cd,PARENT_NAME,NAME,bp_parent_name,district,isstatus,IsStatusSubmitted,ispoke,IsStatusSubmitted,isstatus from tip.Vw_BDMUserTagging where IsStatuscomplete='Completed' and IsStatusSubmitted ='Approved' and reporting_period in (select max(reporting_period) from [TIP].[Vw_BDMUserTagging] where reporting_year in (select max(reporting_year) from [TIP].[Vw_BDMUserTagging] ) ) and [analyst username]='" .$parentCode. "'";                            
                        }
                        elseif($UserType=="District Business Development Manager"){ 
                            $sql="select  distinct budget_desc,transaction_Amount,dim5_Desc,ID,division,dim4_Cd,PARENT_NAME,NAME,bp_parent_name,district,isstatus,IsStatusSubmitted,ispoke,IsStatusSubmitted,isstatus  from tip.Vw_BDMUserTagging where [DBDM Name]='".$DBDM_Name."' and IsStatusSubmitted='Submitted'  and reporting_period in (select max(reporting_period) from [TIP].[Vw_BDMUserTagging] where reporting_year in (select max(reporting_year) from [TIP].[Vw_BDMUserTagging] ) )";
                        }else{
                          $sql="select  distinct budget_desc,transaction_Amount,dim5_Desc,ID,division,dim4_Cd,PARENT_NAME,NAME,bp_parent_name,district,isstatus,IsStatusSubmitted,ispoke,IsStatusSubmitted,isstatus  from tip.Vw_BDMUserTagging where bdm_username='".$parentCode."' and IsStatusSubmitted='Submitted'  and reporting_period in (select max(reporting_period) from [TIP].[Vw_BDMUserTagging] where reporting_year in (select max(reporting_year) from [TIP].[Vw_BDMUserTagging] ) ) AND  company_Cd in (". $BusinessUnit .") ";
                        }

                        //and cast(company_Cd as nvarchar(50)) ='". $BU ."'

                        
                        
                        
                     //   echo $sql;
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
                                  $strDisplay.="<td>
                                      <a href='ViewApproved.php?ID=$row[ID]&Flag=Submitted' class='btn medium bg-blue tooltip-button' data-placement='top' title='Edit'>
                                        &nbsp;&nbsp;&nbsp;View &nbsp;&nbsp;&nbsp;
                                      </a>
                                  </td>";  
                                  
                                }
                                else{ // PAG eto ay BD,
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

                                  if($UserType=="Credit and Collection Supervisor" or $UserType=="District Business Development Manager"){ // credit and collection to!
                                    $strDisplay.="<td>$row[isstatus]</td>";
                                    $strDisplay.="<td>$row[IsStatusSubmitted]</td>";
                                  }else{
                                   $strDisplay.="<td>$row[dim4_Cd]</td>";
                                  $strDisplay.="<td>$row[isstatus]</td>"; 
                                  }


                                  $strDisplay.="<td>
                                      <a href='ViewApproved.php?ID=$row[ID]&Flag=Submitted' class='btn medium bg-blue tooltip-button' data-placement='top' title='Edit'>
                                        &nbsp;&nbsp;&nbsp;View &nbsp;&nbsp;&nbsp;
                                      </a>
                                  </td>";  

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

<script>
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
function myFunction(){
    var PendingNumber = document.getElementById('PendingNumber').value;
    var IsUpdate= document.getElementById('BoolUpdate').value;

      var x = document.getElementById('myDIV');
      if (x.style.display === 'none') { // to validate if theres pending item

          if(PendingNumber==""){
           //  alert(IsUpdate); 
           // if(IsUpdate=="true"){ // to validate if displaying of ALERT is okay na
           //  x.style.display = 'block';  
          //  }else{
              window.open('Function/UpdateSubmitted.php','_self') ;
          //  }
          }else{
            alert('Kindly complete all status per row.');
          }
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
</script>


</body>
</html>


