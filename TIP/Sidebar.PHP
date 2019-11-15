<?php

      if(session_status() != PHP_SESSION_ACTIVE) {
      session_start();
    }
  
    $Name=$_SESSION['Name'];
    $Usertype=$_SESSION['UserType'];
    if($_SESSION['UserImage']!="" and $_SESSION['UserImage']!="NULL"){
      $UserImage=$_SESSION['UserImage'];  
    }else{
      $UserImage="User.png";
    }

    $strDisplay="<div class='user-panel'>";
        $strDisplay.="<div class='pull-left image'>";
            $strDisplay.="<img src='images/" .$UserImage. "' class='img-circle' alt='User Image'>";
        $strDisplay.="</div>";
        $strDisplay.="<div class='pull-left info'>";
            $strDisplay.="<p> ".substr($Name, 0,20)." </p>";
            $strDisplay.="<a href='#'><i class='fa fa-user text-success'></i> ".substr($Usertype,0,19). "..."." </a>";
        $strDisplay.="</div>";
    $strDisplay.="</div>";

      echo $strDisplay;
?>

<ul class="sidebar-menu">
    <li class="header">MAIN NAVIGATION</li>
    <?php
     
      if($Usertype=="Credit and Collection Supervisor" or $Usertype=="Credit Analyst"){
          $StrLi="<li class='treeview'>";
            $StrLi.="<a href='Index.php'>";
              $StrLi.="<i class='fa fa-tasks'></i></i> <span>Dashboard</span>";
            $StrLi.="</a>";
          $StrLi.="</li>";


        $StrLi.="<li class='treeview'>";
          $StrLi.="<a href='TIR.php'>";
            $StrLi.="<i class='fa fa-book'></i></i> <span>TIR Data</span>";
          $StrLi.="</a>";
        $StrLi.="</li>";

        $StrLi.="<li class='treeview'>";
          $StrLi.="<a href='InProgress.php'>";
            $StrLi.="<i class='fa fa-hourglass-end'></i><span>In Progress</span>";
          $StrLi.="</a>";
        $StrLi.="</li>";

        $StrLi.="<li class='treeview'>";
          $StrLi.="<a href='approved.php'>";
            $StrLi.="<i class='fa fa-check'></i><span>Approved</span>";
          $StrLi.="</a>";
        $StrLi.="</li>";


        $StrLi.="<li class='treeview'>";
          $StrLi.="<a href='Disapproved.php'>";
            $StrLi.="<i class='fa fa-table'></i><span>Disapproved</span>";
          $StrLi.="</a>";
        $StrLi.="</li>";

        $StrLi.="<li class='treeview'>";
          $StrLi.="<a href='ApproveAB.php'>";
            $StrLi.="<i class='fa fa-circle-o'></i><span> Add Back</span>";
          $StrLi.="</a>";
        $StrLi.="</li>";

        $StrLi.="<li class='treeview'>";
          $StrLi.="<a href='ExcelEntryTIR.php'>";
            $StrLi.="<i class='fa fa-file-excel-o'></i><span> Excel File</span>";
          $StrLi.="</a>";
        $StrLi.="</li>";

      

      }elseif($Usertype=="Sales Finance Assistant" or $Usertype=="Sales Controller"){// to know if this is SALES finance

     //    $StrLi="<li class='treeview'>";
     //       $StrLi.="<a href='Index.php'>";
     //         $StrLi.="<i class='fa fa-tasks'></i></i> <span>Dashboard</span>";
     //       $StrLi.="</a>";
     //     $StrLi.="</li>";


          $StrLi="<li class='treeview'>";
            $StrLi.="<a href='Index.php'>";
              $StrLi.="<i class='fa fa-tasks'></i></i> <span>Dashboard</span>";
            $StrLi.="</a>";
          $StrLi.="</li>";


        $StrLi.="<li class='treeview'>";
          $StrLi.="<a href='TIR.php'>";
            $StrLi.="<i class='fa fa-book'></i></i> <span>TIR Data</span>";
          $StrLi.="</a>";
        $StrLi.="</li>";

          $StrLi.="<li class='treeview'>";
            $StrLi.="<a href='InProgress.php'>";
              $StrLi.="<i class='fa fa-hourglass-end'></i><span>In Progress</span>";
            $StrLi.="</a>";
          $StrLi.="</li>";

          $StrLi.="<li class='treeview'>";
            $StrLi.="<a href='Rejected.php'>";
              $StrLi.="<i class='fa fa-file'></i><span>Rejected</span>";
            $StrLi.="</a>";
          $StrLi.="</li>";

          $StrLi.="<li class='treeview'>";
            $StrLi.="<a href='Approved.php'>";
              $StrLi.="<i class='fa fa-check'></i><span>Submitted</span>";
            $StrLi.="</a>";
          $StrLi.="</li>";

          $StrLi.="<li class='treeview'>";
            $StrLi.="<a href='Disapproved.php'>";
              $StrLi.="<i class='fa fa-times'></i><span>Disapproved</span>";
            $StrLi.="</a>";
          $StrLi.="</li>";

          $StrLi.="<li class='treeview'>";
            $StrLi.="<a href='BDMTagging.php'>";
              $StrLi.="<i class='fa fa-users'></i><span>BDM Tagging</span>";
            $StrLi.="</a>";
          $StrLi.="</li>";
/**
          $StrLi.="<li class='treeview'>";
            $StrLi.="<a href='BPTagging.php'>";
              $StrLi.="<i class='fa fa-clone'></i><span>BP Tagging</span>";
            $StrLi.="</a>";
          $StrLi.="</li>";
**/
          $StrLi.="<li class='treeview'>";
          $StrLi.="<a href='ApproveAB.php'>";
            $StrLi.="<i class='fa fa-circle-o'></i><span> Add Back</span>";
          $StrLi.="</a>";
        $StrLi.="</li>";

        $StrLi.="<li class='treeview'>";
          $StrLi.="<a href='ExcelEntryTIR.php'>";
            $StrLi.="<i class='fa fa-file-excel-o'></i><span> Excel File</span>";
          $StrLi.="</a>";
        $StrLi.="</li>";


      }elseif($Usertype=="District Business Development Manager"){// to know if this is SALES finance

       //  $StrLi="<li class='treeview'>";
      //      $StrLi.="<a href='Index.php'>";
      //        $StrLi.="<i class='fa fa-tasks'></i></i> <span>Dashboard</span>";
      //      $StrLi.="</a>";
      //    $StrLi.="</li>";


          $StrLi="<li class='treeview'>";
            $StrLi.="<a href='TIR.php'>";
              $StrLi.="<i class='fa fa-book'></i></i> <span>TIR Data</span>";
            $StrLi.="</a>";
          $StrLi.="</li>";

          $StrLi.="<li class='treeview'>";
            $StrLi.="<a href='InProgress.php'>";
              $StrLi.="<i class='fa fa-hourglass-end'></i><span>In Progress</span>";
            $StrLi.="</a>";
          $StrLi.="</li>";
    
          $StrLi.="<li class='treeview'>";
            $StrLi.="<a href='Approved.php'>";
              $StrLi.="<i class='fa fa-check'></i><span>Submitted</span>";
            $StrLi.="</a>";
          $StrLi.="</li>";

          $StrLi.="<li class='treeview'>";
            $StrLi.="<a href='ApproveAB.php'>";
              $StrLi.="<i class='fa fa-circle-o'></i><span> Add Back</span>";
            $StrLi.="</a>";
          $StrLi.="</li>";

          $StrLi.="<li class='treeview'>";
            $StrLi.="<a href='ExcelEntryTIR.php'>";
              $StrLi.="<i class='fa fa-file-excel-o'></i><span> Excel File</span>";
            $StrLi.="</a>";
          $StrLi.="</li>";

      }else{


         $StrLi="<li class='treeview'>";
            $StrLi.="<a href='Index.php'>";
              $StrLi.="<i class='fa fa-tasks'></i></i> <span>Dashboard</span>";
            $StrLi.="</a>";
          $StrLi.="</li>";


        $StrLi.="<li class='treeview'>";
          $StrLi.="<a href='TIR.php'>";
            $StrLi.="<i class='fa fa-book'></i></i> <span>TIR Data</span>";
          $StrLi.="</a>";
        $StrLi.="</li>";

        $StrLi.="<li class='treeview'>";
          $StrLi.="<a href='InProgress.php'>";
            $StrLi.="<i class='fa fa-hourglass-end'></i><span>In Progress</span>";
          $StrLi.="</a>";
        $StrLi.="</li>";

        $StrLi.="<li class='treeview'>";
          $StrLi.="<a href='Rejected.php'>";
            $StrLi.="<i class='fa fa-file'></i><span>Rejected</span>";
          $StrLi.="</a>";
        $StrLi.="</li>";

        $StrLi.="<li class='treeview'>";
          $StrLi.="<a href='Approved.php'>";
            $StrLi.="<i class='fa fa-check'></i><span>Submitted</span>";
          $StrLi.="</a>";
        $StrLi.="</li>";

        $StrLi.="<li class='treeview'>";
          $StrLi.="<a href='ApproveAB.php'>";
            $StrLi.="<i class='fa fa-circle-o'></i><span> Add Back</span>";
          $StrLi.="</a>";
        $StrLi.="</li>";

        $StrLi.="<li class='treeview'>";
          $StrLi.="<a href='ExcelEntryTIR.php'>";
            $StrLi.="<i class='fa fa-file-excel-o'></i><span> Excel File</span>";
          $StrLi.="</a>";
        $StrLi.="</li>";

      }

      echo $StrLi;
    ?>  
    

    


<!--
    <li class="treeview">
      <a href="#">
        <i class="fa fa-pie-chart"></i><span>Performance Statistics</span>
      </a>
    </li>
-->
  
</ul>