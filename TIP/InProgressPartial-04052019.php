<?php
  if(session_status() != PHP_SESSION_ACTIVE) {
      session_start();
  }
  $UserType=$_SESSION['UserType']; // THIS IS THE FIELD OF BDM NAME
  $parentCode=$_SESSION['BDM_USERNAME']; // THIS IS THE FIELD OF BDM NAME
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
      <?php include("linkScriptPagesPartial.php");?>
      
  </head>
<body class="hold-transition skin-blue sidebar-mini" onload="myFunction()">
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


      <!-- header this code-->
      <div class="navbar-custom-menu">
        <?php include("HeaderUserPartial-03222019.php");?>
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

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->

   <section class="content">
       <table class="table table-bordered">
          <tr>
              <td class="text-left"><h1>In Progress Data</h1></td>
              <?php
                $strButton="";
                if($UserType=="Business Development Manager"){ // to know if this is BDM
                  $strButton="<td><br><a href='Function/UpdateSubmittedPartial.php?Inprogress=1'><button type='button' class='btn btn-block btn-primary btn-lg'>Submit</button></td></a>";
                }
                echo $strButton;
              ?>
              
          </tr>
      </table>


      <div class="row">
        <div class="col-xs-12">
            <div class="box">
              <div class="box-body">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                    <tr>
                          
                          <?php
                        
                            if($UserType<>"District Business Development Manager"){ // to know if this is NOT DBDM
                              $strHeader="<th>Business Unit</th>";
                              $strHeader.="<th>Parent Name</th>";
                              $strHeader.="<th>Expense Year</th>";
                              $strHeader.="<th>District</th>";
                              $strHeader.="<th>Account Status</th>";
                              $strHeader.="<th>Action</th>";
                            }else{
                              $strHeader="<th>Business Unit</th>";
                              $strHeader.="<th>Parent Name</th>";
                              $strHeader.="<th>BDM Name</th>";
                              $strHeader.="<th>Account Status</th>";
                              $strHeader.="<th>Submitted Status</th>";

                            }
                              
                            echo $strHeader;
                        ?>
                    </tr>
                  </thead>

                  <tbody >

                    <?php
                        include("model/dbcon.php");

                        if($UserType=="Sales Finance Assistant" or $UserType=="Sales Controller"){// to know if this is SALES finance
                          $sql="select distinct dim5_Desc_Division,Company_CD,[PARENT_NAME] as parent_name ,DIM4_Cd,DISTRICT,ischeck,isstatus,isstatussubmitted,isstatuscomplete,ID,ispoke from tip.V_PARTIAL_BALANCE where isstatuscomplete<>'Completed'";
                          //and DATEPART(month, or_Date)=DATEPART(month, getdate())-2
                        }

                        elseif($UserType=="Credit and Collection Supervisor"){ // credit and collection to!
                          $sql="select distinct dim5_Desc_Division,Company_CD,[PARENT_NAME] as parent_name ,DIM4_Cd,DISTRICT,ischeck,isstatus,isstatussubmitted,isstatuscomplete,ID,ispoke from tip.V_PARTIAL_BALANCE where isstatuscomplete='Completed'  and  IsStatusSubmitted in('Submitted') and  IsStatus ='Accomplished'";                                 
                          //and bp_type_cd='".$channel."'
                        }elseif($UserType=="District Business Development Manager"){ 
                           $sql="select distinct IsStatusSubmitted,name,dim5_Desc_Division,Company_CD,[PARENT_NAME] as parent_name ,DIM4_Cd,DISTRICT,ischeck,isstatus,isstatussubmitted,isstatuscomplete,ID,ispoke from tip.V_PARTIAL_BALANCE where IsStatusSubmitted='Pending' and [DBDM Name]='".$DBDM_Name."'";                                 

                        }elseif($UserType=="Credit Analyst"){ // credit and collection to!
                          $sql="select distinct transaction_amount,dim5_Desc_Division,Company_CD,[PARENT_NAME] as parent_name ,DIM4_Cd,DISTRICT,ischeck,isstatus,isstatussubmitted,isstatuscomplete,ID,ispoke from tip.V_PARTIAL_BALANCE where isstatuscomplete='Completed'  and IsStatusSubmitted not in('Approved','Disapproved') and id in (select dataid from tip.PB_ShouldBE where description='Credit Memo') and [Analyst Username]='".$parentCode."' ";                            
                          //and DATEPART(month, OR_dATE)=DATEPART(month, getdate())-1
                          //and bp_type_cd='".$channel."' 
                          //and DATEPART(month, or_Date)=DATEPART(month, getdate())-1
                        }
                        else{
                          $sql="select dim5_Desc_Division,Company_CD,[PARENT_NAME] as parent_name ,DIM4_Cd,DISTRICT,ischeck,isstatus,isstatussubmitted,isstatuscomplete,ID,ispoke from tip.V_PARTIAL_BALANCE  where bdm_username='".$parentCode."' and IsStatusSubmitted='Pending'  AND  dim5_Cd in (". $BusinessUnit .") and ischeck='Checked' and IsStatus!='Accomplished'";

                        }
                        


                        
                        //and cast(company_Cd as nvarchar(50)) ='". $BU ."'
                        
                        
                        //echo $sql;
                        $stmt=sqlsrv_query($con,$sql);

                        $strDisplay="";
                         while($row=sqlsrv_fetch_array($stmt,SQLSRV_FETCH_ASSOC)){
                            $strDisplay.="<tr>";
                                if($UserType<>"District Business Development Manager"){ // to know if this is NOT DBDM
                                  $strDisplay.="<td>$row[dim5_Desc_Division]</td>";
                                  $strDisplay.="<td>$row[parent_name]</td>";
                                  $strDisplay.="<td>$row[DIM4_Cd]</td>";
                                  $strDisplay.="<td>$row[DISTRICT]</td>";
                                  $strDisplay.="<td>$row[isstatus]</td>";
                                }else{
                                  $strDisplay.="<td>$row[dim5_Desc_Division]</td>";
                                  $strDisplay.="<td>$row[parent_name]</td>";
                                  $strDisplay.="<td>$row[name]</td>";
                                  $strDisplay.="<td>$row[isstatus]</td>";
                                  $strDisplay.="<td>$row[IsStatusSubmitted]</td>";
                                }
                                
                                 
                                if($UserType<>"District Business Development Manager"){ // to know if this is NOT DBDM
                                    if($UserType=="Credit and Collection Supervisor" OR $UserType=="Credit Analyst"){
                                        $strDisplay.="<td>  
                                            <a href='ViewCreditPartial.php?CreditID=$row[ID]' class='btn medium bg-red tooltip-button' data-placement='top'>
                                                &nbsp;&nbsp;&nbsp;View&nbsp;&nbsp;&nbsp;
                                            </a>
                                        </td>";
                                //      }elseif($UserType=="Credit and Collection Supervisor"){
                               //         $strDisplay.="<td>
                              //            <a href='ViewCreditPartial.php?ID=$row[ID]' class='btn medium bg-green tooltip-button' data-placement='top' title='Edit'>
                                  //            &nbsp;&nbsp;&nbsp;Fill-in&nbsp;&nbsp;&nbsp;
                            //              </a>                                   
                                //        </td>";

                                      }else{
                                        $strDisplay.="<td>
                                          <a href='DataFillPartial.php?InprogressID=$row[ID]' class='btn medium bg-green tooltip-button' data-placement='top' title='Edit'>
                                              &nbsp;&nbsp;&nbsp;Fill-in&nbsp;&nbsp;&nbsp;
                                          </a>                                   
                                        </td>";
                                    }
                                }

                                
                                
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


