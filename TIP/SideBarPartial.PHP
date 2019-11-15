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
         $StrLi="<li class='active treeview'>";
          $StrLi.="<a href='indexPartial.php'>";
            $StrLi.="<i class='fa fa-tasks'></i></i> <span>Dashboard</span>";
          $StrLi.="</a>";
        $StrLi.="</li>";

         $StrLi.="<li class='active treeview'>";
          $StrLi.="<a href='PB.php'>";
            $StrLi.="<i class='fa fa-book'></i></i> <span>Partial Balance Data</span>";
          $StrLi.="</a>";
        $StrLi.="</li>";

        $StrLi.="<li class='treeview'>";
          $StrLi.="<a href='InProgressPartial.php'>";
            $StrLi.="<i class='fa fa-hourglass-end'></i><span>In Progress</span>";
          $StrLi.="</a>";
        $StrLi.="</li>";


        $StrLi.="<li class='treeview'>";
          $StrLi.="<a href=''>";
            $StrLi.="<i class='fa fa-check'></i><span>Approved</span>";
          $StrLi.="</a>";

          $StrLi.="<ul class='treeview-menu'>";
            $StrLi.="<li><a href='ApprovePartialCM.php'><i class='fa fa-circle-o'></i> Credit Memo</a></li>";
            $StrLi.="<li><a href='ApprovePartialAB.php'><i class='fa fa-circle-o'></i> Add Back</a></li>";
          $StrLi.="</ul>";
        $StrLi.="</li>";



        $StrLi.="<li class='treeview'>";
          $StrLi.="<a href='DisapprovedPartial.php'>";
            $StrLi.="<i class='fa fa-times'></i><span>Disapproved</span>";
          $StrLi.="</a>";
        $StrLi.="</li>";

        if($Usertype<>"Credit Analyst"){
            $StrLi.="<li class='treeview'>";
              $StrLi.="<a href='AnalystTagging.php'>";
                $StrLi.="<i class='fa fa-user'></i><span>Analyst Tagging</span>";
              $StrLi.="</a>";
            $StrLi.="</li>";

        }
        


       }elseif($Usertype=="District Business Development Manager"){// to know if this is SALES finance

          $StrLi="<li class='active treeview'>";
            $StrLi.="<a href='PB.php'>";
              $StrLi.="<i class='fa fa-book'></i></i> <span>Partial Balance Data</span>";
            $StrLi.="</a>";
          $StrLi.="</li>";

           $StrLi.="<li class='treeview'>";
              $StrLi.="<a href='InProgressPartial.php'>";
                $StrLi.="<i class='fa fa-hourglass-end'></i><span>In Progress</span>";
              $StrLi.="</a>";
            $StrLi.="</li>";

            $StrLi.="<li class='treeview'>";
              $StrLi.="<a href='ApprovedPartial.php'>";
                $StrLi.="<i class='fa fa-check'></i><span>Submitted</span>";
              $StrLi.="</a>";
            $StrLi.="</li>";

            $StrLi.="<li class='treeview'>";
              $StrLi.="<a href='ApprovePartialAB.php'>";
                $StrLi.="<i class='fa fa-circle-o'></i><span> Add Back</span>";
              $StrLi.="</a>";
            $StrLi.="</li>";

            $StrLi.="<li class='treeview'>";
              $StrLi.="<a href='ExcelEntryPB.php'>";
                $StrLi.="<i class='fa fa-file-excel-o'></i><span> Excel File</span>";
              $StrLi.="</a>";
            $StrLi.="</li>";

       

      }elseif($Usertype=="Sales Finance Assistant"  or $Usertype=="Sales Controller"){// to know if this is SALES finance
         $StrLi="<li class='active treeview'>";
          $StrLi.="<a href='indexPartial.php'>";
            $StrLi.="<i class='fa fa-tasks'></i></i> <span>Dashboard</span>";
          $StrLi.="</a>";
        $StrLi.="</li>";

          $StrLi.="<li class='active treeview'>";
            $StrLi.="<a href='PB.php'>";
              $StrLi.="<i class='fa fa-book'></i></i> <span>Partial Balance Data</span>";
            $StrLi.="</a>";
          $StrLi.="</li>";


          $StrLi.="<li class='treeview'>";
            $StrLi.="<a href='InProgressPartial.php'>";
              $StrLi.="<i class='fa fa-hourglass-end'></i><span>In Progress</span>";
            $StrLi.="</a>";
          $StrLi.="</li>";

          $StrLi.="<li class='treeview'>";
            $StrLi.="<a href='RejectedPartial.php'>";
              $StrLi.="<i class='fa fa-file'></i><span>Rejected</span>";
            $StrLi.="</a>";
          $StrLi.="</li>";

          $StrLi.="<li class='treeview'>";
            $StrLi.="<a href='ApprovedPartial.php'>";
              $StrLi.="<i class='fa fa-check'></i><span>Submitted</span>";
            $StrLi.="</a>";

            $StrLi.="<ul class='treeview-menu'>";
              $StrLi.="<li><a href='ApprovePartialCM.php'><i class='fa fa-circle-o'></i> Credit Memo</a></li>";
              $StrLi.="<li><a href='ApprovePartialAB.php'><i class='fa fa-circle-o'></i> Add Back</a></li>";
            $StrLi.="</ul>";
          $StrLi.="</li>";

          $StrLi.="<li class='treeview'>";
            $StrLi.="<a href='DisapprovedPartial.php'>";
              $StrLi.="<i class='fa fa-times'></i><span>Disapproved</span>";
            $StrLi.="</a>";
          $StrLi.="</li>";


          $StrLi.="<li class='treeview'>";
            $StrLi.="<a href='BDMTagging.php'>";
              $StrLi.="<i class='fa fa-users'></i><span>BDM Tagging</span>";
            $StrLi.="</a>";
          $StrLi.="</li>";

          $StrLi.="<li class='treeview'>";
            $StrLi.="<a href='BPTagging.php'>";
              $StrLi.="<i class='fa fa-clone'></i><span>BP Tagging</span>";
            $StrLi.="</a>";
          $StrLi.="</li>";

          $StrLi.="<li class='treeview'>";
            $StrLi.="<a href='ExcelEntryPB.php'>";
              $StrLi.="<i class='fa fa-file-excel-o'></i><span> Excel File</span>";
            $StrLi.="</a>";
          $StrLi.="</li>";

      }else{

        $StrLi="<li class='active treeview'>";
          $StrLi.="<a href='indexPartial.php'>";
            $StrLi.="<i class='fa fa-tasks'></i></i> <span>Dashboard</span>";
          $StrLi.="</a>";
        $StrLi.="</li>";

        $StrLi.="<li class='treeview'>";
          $StrLi.="<a href='PB.php'>";
            $StrLi.="<i class='fa fa-book'></i></i> <span>Partial Balance Data</span>";
          $StrLi.="</a>";
        $StrLi.="</li>";


        $StrLi.="<li class='treeview'>";
          $StrLi.="<a href='InProgressPartial.php'>";
            $StrLi.="<i class='fa fa-hourglass-end'></i><span>In Progress</span>";
          $StrLi.="</a>";
        $StrLi.="</li>";

        $StrLi.="<li class='treeview'>";
          $StrLi.="<a href='RejectedPartial.php'>";
            $StrLi.="<i class='fa fa-file'></i><span>Rejected</span>";
          $StrLi.="</a>";
        $StrLi.="</li>";

        $StrLi.="<li class='treeview'>";
          $StrLi.="<a href='ApprovedPartial.php'>";
            $StrLi.="<i class='fa fa-check'></i><span>Submitted</span>";
          $StrLi.="</a>";
        $StrLi.="</li>";

        $StrLi.="<li class='treeview'>";
          $StrLi.="<a href='ApprovePartialAB.php'>";
            $StrLi.="<i class='fa fa-circle-o'></i><span> Add Back</span>";
          $StrLi.="</a>";
        $StrLi.="</li>";

        $StrLi.="<li class='treeview'>";
          $StrLi.="<a href='ExcelEntryPB.php'>";
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