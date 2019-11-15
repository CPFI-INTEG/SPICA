<?php 

    if(session_status() != PHP_SESSION_ACTIVE) {
      session_start();
    }
    $BDMName=$_SESSION['BDM_USERNAME']; // THIS IS THE FIELD OF BDM NAME
    $Name=$_SESSION['Name'];
    $Usertype=$_SESSION['UserType'];
    $channel=$_SESSION['channel']; // THIS IS THE FIELD OF BDM NAME
    $BusinessUnit=$_SESSION['BU']; // THIS IS THE FIELD OF BDM NAME
    
    if($_SESSION['UserImage']!="" and $_SESSION['UserImage']!="NULL"){
      $UserImage=$_SESSION['UserImage'];  
    }else{
      $UserImage="User.png";
    }

    //echo $UserImage;


  $StrPokeNo="";
  $StrPokeImage="";
  include("model/dbcon.php");
  
  if($Usertype=="Sales Finance Assistant"){// to know if this is SALES finance
    $SqlPoke="select count(distinct (id)) As Poke from tip.Vw_BDMUserTagging where Remarks='Approved' OR Remarks LIKE '%approved%' or Remarks='RejectedSubmitted'";
  }elseif($Usertype=="Credit and Collection Supervisor"){ // credit and collection to!
    $SqlPoke="select count(distinct (id)) As Poke from tip.Vw_BDMUserTagging where  Remarks LIKE '%Reply Disapproved%' or remarks='RejectedSubmitted'";
  }else{
    $SqlPoke="select count(distinct (id)) As Poke from tip.Vw_BDMUserTagging where (ispoke=1 OR IsStatusSubmitted='Rejected') and bdm_username='".$BDMName."' ";
    //NEED ILAGAY TO KASI TYPE TO PARA SA 2BDMS
    // and company_Cd ='". $BU ."'  

  }
  // echo $SqlPoke;
  $stmt=sqlsrv_query($con,$SqlPoke);  
  $rows = sqlsrv_fetch_array($stmt,SQLSRV_FETCH_ASSOC); // number of rows OR (true or false)
    $StrPokeNo= $rows['Poke'];

    if(is_null($StrPokeNo)){ // to know if there is no POKE
    //  ECHO $StrPokeNo ."poke";
      $StrPokeNo= "0";
    }





    $strDisplay="<ul class='nav navbar-nav'>";
          $strDisplay.="<li class='dropdown messages-menu'>";
            $strDisplay.="<a href='#' class='dropdown-toggle' data-toggle='dropdown'>";
              $strDisplay.="<i class='fa fa-envelope-o'></i>";
              $strDisplay.="<span class='label label-success'>" .$StrPokeNo. "</span>";
            $strDisplay.="</a>";

            $strDisplay.="<ul class='dropdown-menu'>";
              $strDisplay.="<li class='header'>You have " .$StrPokeNo. " messages</li>";
              $strDisplay.="<li>";
                $strDisplay.="<ul class='menu'>";



    
                  if($Usertype=="Sales Finance Assistant"){// to know if this is SALES finance
                      $SqlList="select distinct ID,parent_cd,imgpoke,isstatus,IsStatusSubmitted,Document_no,Remarks  from tip.Vw_BDMUserTagging where Remarks LIKE '%approved%'or Remarks='Approved' or Remarks='RejectedSubmitted'";
                  }elseif($Usertype=="Credit and Collection Supervisor"){ // credit and collection to!
                      $SqlList="select distinct ID,parent_cd,imgpoke,isstatus,IsStatusSubmitted,Document_no,Remarks  from tip.Vw_BDMUserTagging  where  Remarks LIKE '%Reply Disapproved%' or remarks='RejectedSubmitted'";
                  }else{
                      $SqlList="select distinct ID,target_Company,parent_cd,budget_desc,transaction_Amount,imgpoke,isstatus,IsStatusSubmitted,Document_no,Remarks   from tip.Vw_BDMUserTagging where ispoke=1 and bdm_username='".$BDMName."'  
                      UNION ALL select distinct ID,target_Company,parent_cd,budget_desc,transaction_Amount,imgpoke,isstatus,IsStatusSubmitted,Document_no,Remarks   from tip.Vw_BDMUserTagging where IsStatusSubmitted='Rejected' and  bdm_username='".$BDMName."' ";
                  }
                  // NEED ILAGAY TO
                  //and company_Cd ='". $BU ."'


//                  ECHO $SqlList;

                  $stmt=sqlsrv_query($con,$SqlList);  
                  while($rows=sqlsrv_fetch_array($stmt,SQLSRV_FETCH_ASSOC)){
                       $StrPokeImage= $rows['imgpoke'];
                       
                      if(is_null($StrPokeImage)){
                        $StrPokeImage= "BlackUser.png";
                      }
                          $StrJVNo= $rows['Document_no'];
                          $StrParentCode= $rows['parent_cd'];
                            
                            $strDisplay.="<li>";
                            if($rows['IsStatusSubmitted']=="Rejected"){ // to go in REJECTED.PHP if the DATA IS REJECTED AND DISAPPROVE
                              $strDisplay.="<a href='ViewRejected.php?ID=$rows[ID]'>";
                            }elseif($rows['IsStatusSubmitted']=="Approved"){
                              $strDisplay.="<a href='Viewapproved.php?ID=$rows[ID]&DisApprove=1''>";
                            }elseif($rows['IsStatusSubmitted']=="Disapproved"){
                              $strDisplay.="<a href='ViewDisapproved.php?ID=$rows[ID]&DisApprove=1''>";
                            }elseif( $rows['Remarks']=="RejectedSubmitted"){
                              $strDisplay.="<a href='ViewSalesFinance.php?ID=$rows[ID]&Type=RejectUpdate'>";
                            }else{ // TO GO IN DATAFILL.PHP
                              $strDisplay.="<a href='DataFill.php?ID=$rows[ID]'>";

                            }
                                $strDisplay.="<div class='pull-left'>";
                                  $strDisplay.="<img src='images/".$StrPokeImage."' class='img-circle' alt='User Image'>";
                                $strDisplay.="</div>";
                                $strDisplay.="<h4>";
                               
                                  if($rows['Remarks']=="RejectedSubmitted"){
                                    $strDisplay.="Reject Submitted(".$StrParentCode.")";  
                                  }elseif($rows['IsStatusSubmitted']=="Rejected"){
                                    $strDisplay.="Account Rejected(".$StrParentCode.")";  
                                  }elseif($rows['IsStatusSubmitted']=="Disapproved"){
                                    $strDisplay.="Account Disapprove(".$StrParentCode.")";  
                                  }elseif($rows['IsStatusSubmitted']=="Approved"){
                                    $strDisplay.="Account Approve(".$StrParentCode.")"; 
                                  }else{
                                    $strDisplay.="Account Pending(".$StrParentCode.")";  
                                  }
                                  $strDisplay.="<small><i></i></small>";
                                $strDisplay.="</h4>";
                                $strDisplay.="<p> Document number of ".$StrJVNo." </p>";
                              $strDisplay.="</a>";
                            $strDisplay.="</li>";
                    } 
                                    
                    





                $strDisplay.="</ul>";
              $strDisplay.="</li>";
              $strDisplay.="<li class='footer'><a href='#'></a></li>";
            $strDisplay.="</ul>";
          $strDisplay.="</li>";
          

        /* for Notification purposes  
          $strDisplay.="<li class='dropdown notifications-menu'>";
            $strDisplay.="<a href='#' class='dropdown-toggle' data-toggle='dropdown'>";
              $strDisplay.="<i class='fa fa-bell-o'></i>";
              $strDisplay.="<span class='label label-warning'>10</span>";
            $strDisplay.="</a>";
            $strDisplay.="<ul class='dropdown-menu'>";
              $strDisplay.="<li class='header'>You have 10 notifications</li>";
              $strDisplay.="<li>";
                

                $strDisplay.="<ul class='menu'>";
                  $strDisplay.="<li>";
                    $strDisplay.="<a href='#'>";
                      $strDisplay.="<i class='fa fa-users text-aqua'></i> Your rating for this month is 9";
                    $strDisplay.="</a>";
                  $strDisplay.="</li>";
                  
                $strDisplay.="</ul>";
              $strDisplay.="</li>";
              $strDisplay.="<li class='footer'><a href='#'>View all</a></li>";
            $strDisplay.="</ul>";
          $strDisplay.="</li>";
        */
          
        //  echo $UserImage;
         
          $strDisplay.="<li class='dropdown user user-menu'>";
            $strDisplay.="<a href='#' class='dropdown-toggle' data-toggle='dropdown'>";
              $strDisplay.="<img src='images/".$UserImage."' class='user-image' alt='User Image'>";
              $strDisplay.="<span class='hidden-xs'>" .$Name. " </span>";
            $strDisplay.="</a>";
            $strDisplay.="<ul class='dropdown-menu'>";
              
              $strDisplay.="<li class='user-header'>";
                $strDisplay.="<img src='images/".$UserImage."' class='img-circle' alt='User Image'>";

                $strDisplay.="<p>";
                  $strDisplay.=$Name;
                  $strDisplay.="<small>" .$Usertype. "</small>";
                $strDisplay.="</p>";
              $strDisplay.="</li>";
              
              $strDisplay.="<li class='user-footer'>";
                $strDisplay.="<div class='pull-left'>";
                  $strDisplay.="<a href='profile.php' class='btn btn-default btn-flat'>Profile</a>";
                $strDisplay.="</div>";
                $strDisplay.="<div class='pull-right'>";
                  $strDisplay.="<a href='logout.php' class='btn btn-default btn-flat'>Sign out</a>";
                $strDisplay.="</div>";
              $strDisplay.="</li>";
            $strDisplay.="</ul>";
          $strDisplay.="</li>";
          
        $strDisplay.="</ul>";

        echo $strDisplay;

?>