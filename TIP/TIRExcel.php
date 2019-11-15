<?php
  if(session_status() != PHP_SESSION_ACTIVE) {
  	session_start();
  }

  $UserType=$_SESSION['UserType']; // THIS IS THE FIELD OF BDM NAME
  $parentCode=$_SESSION['BDM_USERNAME']; // THIS IS THE FIELD OF BDM NAME
  $channel=$_SESSION['channel']; // THIS IS THE FIELD OF BDM NAME
  $BusinessUnit=$_SESSION['BU']; // THIS IS THE FIELD OF BDM NAME


   

  //----------------------------------------------------------------------------------

/**
 * PHPExcel
 *
 * Copyright (C) 2006 - 2014 PHPExcel
 *
 * This library is free software; you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation; either
 * version 2.1 of the License, or (at your option) any later version.
 *
 * This library is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this library; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301  USA
 *
 * @category   PHPExcel
 * @package    PHPExcel
 * @copyright  Copyright (c) 2006 - 2014 PHPExcel (http://www.codeplex.com/PHPExcel)
 * @license    http://www.gnu.org/licenses/old-licenses/lgpl-2.1.txt	LGPL
 * @version    1.8.0, 2014-03-02
 */

/** Error reporting */
error_reporting(E_ALL);


ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);
date_default_timezone_set('Asia/Manila');




if (PHP_SAPI == 'cli')
	die('This example should only be run from a Web Browser');

/** Include PHPExcel */
include dirname(__FILE__) . '/Classes/PHPExcel.php';
//include dirname(__FILE__) . '/Classes/PHPExcel/Cell/DataType.php';
	//CONNECTION TO DATABASE
	$con="";
	$ServerName="cp-trdcomsys-sql.database.secure.windows.net";
	$password='@cc3s$d3v123';
	$ConnectInfo=array("DATABASE"=>"TCS_MAIN","UID"=>"jlucero","PWD"=>$password);
	$con=sqlsrv_connect($ServerName,$ConnectInfo);


	// SAVE TO AUDIT TRAIL
	$SqlAudit="insert into tip.Audittrail(Description,Usertype,NameofUser) values('Successfully Download TIR Excel file : ". gmdate('YMd').'.xlsx'." for  TIR Report','".$UserType."','".$parentCode."')";
	$stmtAudit=sqlsrv_prepare($con,$SqlAudit);
	sqlsrv_execute($stmtAudit);
	sqlsrv_free_stmt($stmtAudit);


// Create new PHPExcel object
$objPHPExcel = new PHPExcel();

// Set document properties
$objPHPExcel->getProperties()->setCreator("TIR")
							 ->setLastModifiedBy("TIR")
							 ->setTitle("Office 2007 XLSX Test Document")
							 ->setSubject("Office 2007 XLSX Test Document")
							 ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
							 ->setKeywords("office 2007 openxml php")
							 ->setCategory("Test result file");

if(session_status() != PHP_SESSION_ACTIVE) {
	session_start();
}
			
// Add some data
$objPHPExcel->setActiveSheetIndex(0)
			// HEADER
			->setCellValue('A1', 'Report Type     : TIR')
			->setCellValue('A2', 'Reporting Month   : '.(gmdate('m')-1))
			->setCellValue('A3', 'Date & Time    : '.date('l jS \of F Y h:i:s A'))

			// CREDIT DATA
			->setCellValue('A6', 'Parent Details')
			->setCellValue('B6', 'Customer Details')
			->setCellValue('C6', 'Document Details')
			->setCellValue('D6', 'Year / Type / Business Units')
			->setCellValue('E6', 'Budget')
			->setCellValue('F6', 'BP')
			->setCellValue('G6', 'Reference')
			->setCellValue('H6', 'Activity Type')
			->setCellValue('I6', 'Amount')
			->setCellValue('J6', 'SYSTEM ID')

			// SHOULD BE ENTRY
			->setCellValue('K6', 'Reference Type') 
			->setCellValue('L6', 'Amount Budget') 
			->setCellValue('M6', 'Year') 
			->setCellValue('N6', 'Type (Canned/Frozen)') 
			->setCellValue('O6', 'Division') 
			->setCellValue('P6', 'Classification (Program Class)') 
			->setCellValue('Q6', 'Remarks') 

			//CORP BU BREAK DOWN
			->setCellValue('R6', 'Meat') 
			->setCellValue('S6', 'Sardines') 
			->setCellValue('T6', 'Dairy') 
			->setCellValue('U6', 'Tuna') 
			->setCellValue('V6', 'Hunts') 
			->setCellValue('W6', 'Vita Coco') 
			->setCellValue('X6', 'RMB') 

			//STATUS
			->setCellValue('Y6', 'Status') 
			->setCellValue('Z6', 'Has Validation') 
			->setCellValue('AA6', 'Sum of Input Budget') 
			->setCellValue('AB6', 'WITH TAF') 


			;
				 	
		 	$sqlModal="select dim5_Desc,ID,division,parent_Cd,parent_name,bp_parent_cd,bp_parent_name,doc_trans_Type,document_no,bp_Type_cd,cast(document_Date as nvarchar) as document_Date ,transaction_Amount,transaction_Reference,target_company,budget_desc,reporting_year,right(dim4_Cd,4) as dim4_Cd,dim1_Desc FROM [TCS_main].[TIP].[Vw_BDMUserTagging] where bdm_username='".$parentCode."' and company_Cd in (". $BusinessUnit .")  and IsStatusSubmitted='Pending' and IsStatus in ('Pending','Draft') and reporting_period in (select max(reporting_period) from [TIP].[Vw_BDMUserTagging] where reporting_year in (select max(reporting_year) from [TIP].[Vw_BDMUserTagging] ))"; 	
		 	//echo $sqlModal;


		 	//where bdm_username='".$parentCode."' and company_Cd in (". $BusinessUnit .")  and IsStatusSubmitted='Pending' and reporting_period in (select max(reporting_period) from [TIP].[Vw_BDMUserTagging] where reporting_year in (select max(reporting_year) from [TIP].[Vw_BDMUserTagging] ) )
			$stmt=sqlsrv_query($con,$sqlModal);

			$x=7;
			$alphabet = range('A', 'Z');			

			while($row=sqlsrv_fetch_array($stmt,SQLSRV_FETCH_ASSOC)){
				$objPHPExcel->getActiveSheet()->getStyle('A'.$x) 
    			->getNumberFormat()
    			->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
				$objPHPExcel->getActiveSheet()->setCellValueExplicit ('A'.$x, '('.$row['parent_Cd'].')'.$row['parent_name'],PHPExcel_Cell_DataType::TYPE_STRING);	
				$objPHPExcel->getActiveSheet()->setCellValue ('B'.$x,'('.$row['bp_parent_cd'].')'.$row['bp_parent_name']);	
				$objPHPExcel->getActiveSheet()->setCellValue ('C'.$x,$row['doc_trans_Type'] . ' / ' . '('.$row['document_no'].')'.$row['document_Date']);	
				$objPHPExcel->getActiveSheet()->setCellValue ('D'.$x,$row['dim4_Cd'] . ' / ' .$row['division'] . ' / '.$row['dim5_Desc']);	
				$objPHPExcel->getActiveSheet()->setCellValue ('E'.$x,$row['budget_desc']);	
				$objPHPExcel->getActiveSheet()->setCellValue ('F'.$x,$row['bp_Type_cd']);	
				$objPHPExcel->getActiveSheet()->setCellValue ('G'.$x,$row['transaction_Reference']);	
				$objPHPExcel->getActiveSheet()->setCellValue ('H'.$x,$row['dim1_Desc']);	
				$objPHPExcel->getActiveSheet()->setCellValue ('I'.$x,$row['transaction_Amount']);	
				
				
				//should be and DATA ID
				$objPHPExcel->getActiveSheet()->setCellValue ('J'.$x,$row['ID']);					
				$objPHPExcel->getActiveSheet()->setCellValue ('K'.$x,'--');					
				$objPHPExcel->getActiveSheet()->setCellValue ('L'.$x,'--');
				$objPHPExcel->getActiveSheet()->setCellValue ('M'.$x,'--');
				$objPHPExcel->getActiveSheet()->setCellValue ('N'.$x,'--');
				$objPHPExcel->getActiveSheet()->setCellValue ('O'.$x,'--');
				$objPHPExcel->getActiveSheet()->setCellValue ('P'.$x,'--');
				$objPHPExcel->getActiveSheet()->setCellValue ('Q'.$x,'--');

				//CORP BU BREAK DOWN
				$objPHPExcel->getActiveSheet()->setCellValue ('R'.$x,'--');
				$objPHPExcel->getActiveSheet()->setCellValue ('S'.$x,'--');
				$objPHPExcel->getActiveSheet()->setCellValue ('T'.$x,'--');
				$objPHPExcel->getActiveSheet()->setCellValue ('U'.$x,'--');
				$objPHPExcel->getActiveSheet()->setCellValue ('V'.$x,'--');
				$objPHPExcel->getActiveSheet()->setCellValue ('W'.$x,'--');
				$objPHPExcel->getActiveSheet()->setCellValue ('X'.$x,"--");

				//STATUS
				$objPHPExcel->getActiveSheet()->setCellValue ('Y'.$x,'=IF(AND(K'.$x.'="--",L'.$x.'="--",M'.$x.'="--",N'.$x.'="--",O'.$x.'="--",P'.$x.'="--"),"Pending",IF(OR(K'.$x.'="--",L'.$x.'="--",M'.$x.'="--",N'.$x.'="--",O'.$x.'="--",P'.$x.'="--",K'.$x.'="",L'.$x.'="",M'.$x.'="",N'.$x.'="",O'.$x.'="",P'.$x.'=""),"Draft",IF(OR(AND(AB'.$x.'="FALSE",AA'.$x.'="0"),(AND(AB'.$x.'="TRUE",AA'.$x.'=CONCATENATE(I'.$x.',"")))),"Accomplished","Draft")))');
				$objPHPExcel->getActiveSheet()->setCellValue ('Z'.$x,'=IF(M'.$x.' & " / " &N'.$x.' & " / " & O'.$x.'=D'.$x.',"NO","YES")');
				$objPHPExcel->getActiveSheet()->setCellValue ('AA'.$x,'=CONCATENATE(ROUND(SUM(R'.$x.': X'.$x.'),2),"")');

				//=IF(IFERROR(IF((SEARCH("CORP",K'.$x.'))<>0,"TRUE","FALSE"),"FALSE")="TRUE","TRUE",IFERROR(IF((SEARCH("CNFP",K'.$x.'))<>0,"TRUE","FALSE"),IFERROR(IF((SEARCH("CNPF",K'.$x.'))<>0,"TRUE","FALSE"),"FALSE")))');

				


				$objPHPExcel->getActiveSheet()->setCellValue ('AB'.$x,'=IF((SUM(ISNUMBER(SEARCH("CNFP",K'.$x.')),ISNUMBER(SEARCH("CNPF",K'.$x.')),ISNUMBER(SEARCH("CORP",K'.$x.'))))<>0,"TRUE","FALSE")');

				

				
				$objPHPExcel->getActiveSheet()->getStyle('R'.$x.':X'.$x)->getNumberFormat()->setFormatCode('#,##0.00');
				$objPHPExcel->getActiveSheet()->getStyle('AA'.$x)->getNumberFormat()->setFormatCode('#,##0.00');

				//$objPHPExcel->getActiveSheet()->setCellValue ('AB'.$x,'=IF(COUNTIF(K'.$x.',"*???CORP???*")=1,"TRUE","FALSE")');
				//$objPHPExcel->getActiveSheet()->setCellValue ('P'.$x,'=IF(AND(I'.$x.'="--",J'.$x.'="--",K'.$x.'="--",L'.$x.'="--",M'.$x.'="--",N'.$x.'="--",O'.$x.'="--"),"Pending",
				//IF(OR(I'.$x.'="--",J'.$x.'="--",K'.$x.'="--",L'.$x.'="--",M'.$x.'="--",N'.$x.'="--",O'.$x.'="--",I'.$x.'="",J'.$x.'="",K'.$x.'="",L'.$x.'="",M'.$x.'="",N'.$x.'="",O'.$x.'=""),"Draft","Accomplished"))
				//	');
				$x=$x+1;

				


				



				
				// CREDIT DETAILS FORM -----------------------------------------------------------------------
				//TO GET THE NUMBER OF COLUMNS
				$intCounterLtr=0;
				for($intCount=1;$intCount<=10;$intCount++){
					$intCounterLtr=$intCounterLtr+1;

					// SET BACKGROUND COLOR OF CELL
					$objPHPExcel->getActiveSheet()->getStyle($alphabet[$intCounterLtr-1].($x-1))->applyFromArray(
					    array(
					        'fill' => array(
					            'type' => PHPExcel_Style_Fill::FILL_SOLID,
					            'color' => array('rgb' => 'd6d6c2')
					        )
					    )
					);


					//----------------------------------------------------------------------------

					// SET BORDER LINE 
					$objPHPExcel->getActiveSheet()->getStyle($alphabet[$intCounterLtr-1].($x-1))->applyFromArray(
						array(
					  		'borders' => array(
						    	'allborders' => array(
						      	'style' => PHPExcel_Style_Border::BORDER_THIN
						      	)
					    	)
					  	)
					);

					//---------------------------------------------------------------------------

					// SET ALIGNMENT
					$objPHPExcel->getActiveSheet()->getStyle($alphabet[$intCounterLtr-1].($x-1))->applyFromArray(
						array(
					  		'alignment' => array(
						    	'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
					    	)
					  	)
					);


				}


				//  SHOULD BE ENTRIES FORM -----------------------------------------------------------------------
				//TO GET THE NUMBER OF COLUMNS
				$intCounterLtr=10;
				for($intCount=0;$intCount<=13;$intCount++){
					$intCounterLtr=$intCounterLtr+1;

					$objPHPExcel->getActiveSheet()->getStyle($alphabet[$intCounterLtr-1].($x-1))->getProtection()->setLocked(PHPExcel_Style_Protection::PROTECTION_UNPROTECTED);

					// SET BACKGROUND COLOR OF CELL 
					$objPHPExcel->getActiveSheet()->getStyle($alphabet[$intCounterLtr-1].($x-1))->applyFromArray(
					    array(
					        'fill' => array(
					            'type' => PHPExcel_Style_Fill::FILL_SOLID,
					            'color' => array('rgb' => 'ffff80')
					        )
					    )
					);

					// SET BORDER LINE 
					$objPHPExcel->getActiveSheet()->getStyle($alphabet[$intCounterLtr-1].($x-1))->applyFromArray(
						array(
					  		'borders' => array(
						    	'allborders' => array(
						      	'style' => PHPExcel_Style_Border::BORDER_THIN
						      	)
					    	)
					  	)
					);

					// SET ALIGNMENT
					$objPHPExcel->getActiveSheet()->getStyle($alphabet[$intCounterLtr-1].($x-1))->applyFromArray(
						array(
					  		'alignment' => array(
						    	'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
					    	)
					  	)
					);

				}


				//  STATUS ANSWER  -----------------------------------------------------------------------
				//TO GET THE NUMBER OF COLUMNS
				$intCounterLtr=24;
				for($intCount=1;$intCount<=2;$intCount++){
					$intCounterLtr=$intCounterLtr+1;

					

					// SET BACKGROUND COLOR OF CELL 
					$objPHPExcel->getActiveSheet()->getStyle($alphabet[$intCounterLtr-1].($x-1))->applyFromArray(
					    array(
					        'fill' => array(
					            'type' => PHPExcel_Style_Fill::FILL_SOLID,
					            'color' => array('rgb' => '97b1db')
					        )
					    )
					);

					// SET BORDER LINE 
					$objPHPExcel->getActiveSheet()->getStyle($alphabet[$intCounterLtr-1].($x-1))->applyFromArray(
						array(
					  		'borders' => array(
						    	'allborders' => array(
						      	'style' => PHPExcel_Style_Border::BORDER_THIN
						      	)
					    	)
					  	)
					);

					// SET ALIGNMENT
					$objPHPExcel->getActiveSheet()->getStyle($alphabet[$intCounterLtr-1].($x-1))->applyFromArray(
						array(
					  		'alignment' => array(
						    	'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
					    	)
					  	)
					);


					// FOR AA COLUMN - SUM OF INPUT BUDGET
					// SET BACKGROUND COLOR OF CELL 
					$objPHPExcel->getActiveSheet()->getStyle('AA'.($x-1))->applyFromArray(
					    array(
					        'fill' => array(
					            'type' => PHPExcel_Style_Fill::FILL_SOLID,
					            'color' => array('rgb' => '97b1db')
					        )
					    )
					);

					// SET BORDER LINE 
					$objPHPExcel->getActiveSheet()->getStyle('AA'.($x-1))->applyFromArray(
						array(
					  		'borders' => array(
						    	'allborders' => array(
						      	'style' => PHPExcel_Style_Border::BORDER_THIN
						      	)
					    	)
					  	)
					);

					// SET ALIGNMENT
					$objPHPExcel->getActiveSheet()->getStyle('AA'.($x-1))->applyFromArray(
						array(
					  		'alignment' => array(
						    	'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
					    	)
					  	)
					);

					// FOR AA COLUMN - SUM OF INPUT BUDGET
					// SET BACKGROUND COLOR OF CELL 
					$objPHPExcel->getActiveSheet()->getStyle('AA'.($x-1))->applyFromArray(
					    array(
					        'fill' => array(
					            'type' => PHPExcel_Style_Fill::FILL_SOLID,
					            'color' => array('rgb' => '97b1db')
					        )
					    )
					);

					// SET BORDER LINE 
					$objPHPExcel->getActiveSheet()->getStyle('AA'.($x-1))->applyFromArray(
						array(
					  		'borders' => array(
						    	'allborders' => array(
						      	'style' => PHPExcel_Style_Border::BORDER_THIN
						      	)
					    	)
					  	)
					);

					// SET ALIGNMENT
					$objPHPExcel->getActiveSheet()->getStyle('AA'.($x-1))->applyFromArray(
						array(
					  		'alignment' => array(
						    	'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
					    	)
					  	)
					);

					// FOR AB COLUMN - SUM OF INPUT BUDGET
					// SET BACKGROUND COLOR OF CELL 
					$objPHPExcel->getActiveSheet()->getStyle('AB'.($x-1))->applyFromArray(
					    array(
					        'fill' => array(
					            'type' => PHPExcel_Style_Fill::FILL_SOLID,
					            'color' => array('rgb' => '97b1db')
					        )
					    )
					);

					// SET BORDER LINE 
					$objPHPExcel->getActiveSheet()->getStyle('AB'.($x-1))->applyFromArray(
						array(
					  		'borders' => array(
						    	'allborders' => array(
						      	'style' => PHPExcel_Style_Border::BORDER_THIN
						      	)
					    	)
					  	)
					);

					// SET ALIGNMENT
					$objPHPExcel->getActiveSheet()->getStyle('AB'.($x-1))->applyFromArray(
						array(
					  		'alignment' => array(
						    	'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
					    	)
					  	)
					);
				}
			}

			$objPHPExcel->setActiveSheetIndex(0);
			// HEADER


foreach(range('A','Z') as $columnID) {
    $objPHPExcel->getActiveSheet()->getColumnDimension($columnID)
        ->setAutoSize(true);
}
$objPHPExcel->getActiveSheet()->getColumnDimension('AB')->setAutoSize(true);

// Rename worksheet
$objPHPExcel->getActiveSheet()->setTitle('TIR DATA');





//LOCK SPECIFIC CELL
$objPHPExcel->getActiveSheet()->getProtection()->setPassword('KAMOTE');
$objPHPExcel->getActiveSheet()->getProtection()->setSheet(true);


// SET BACKGROUND COLOR OF CELL
$objPHPExcel->getActiveSheet()->getStyle('A6:j6')->applyFromArray(
    array(	
        'fill' => array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'color' => array('rgb' => '999966')
        )
    )
);

$objPHPExcel->getActiveSheet()->getStyle('k6:X6')->applyFromArray(
    array(
        'fill' => array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'color' => array('rgb' => 'ffff1a')
        )
    )
);


$objPHPExcel->getActiveSheet()->getStyle('Y6:AB6')->applyFromArray(
    array(
        'fill' => array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'color' => array('rgb' => '6599ed')
        )
    )
);
// SET BORDER LINE 
$objPHPExcel->getActiveSheet()->getStyle('A6:AB6')->applyFromArray(
	array(
  		'borders' => array(
	    	'allborders' => array(
	      	'style' => PHPExcel_Style_Border::BORDER_THIN
	      	)
    	)
  	)
);

// SET ALIGNMENT
$objPHPExcel->getActiveSheet()->getStyle('A6:AB6')->applyFromArray(
	array(
  		'alignment' => array(
	    	'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
    	)
  	)
);


// MERGE CELLS FOR CORPORATE TAF
$objPHPExcel->getActiveSheet()->mergeCells('R5:X5');
$objPHPExcel->getActiveSheet()->setCellValue ('R5',"REQUIRED FIELDS WITH TAF");
$objPHPExcel->getActiveSheet()->getStyle("R5")->getFont()->setSize(15);

$objPHPExcel->getActiveSheet()->getStyle("A1")->getFont()->setSize(16);
$objPHPExcel->getActiveSheet()->getStyle("A2")->getFont()->setSize(16);
$objPHPExcel->getActiveSheet()->getStyle("A3")->getFont()->setSize(16);

$objPHPExcel->getActiveSheet()->getStyle('R5')->applyFromArray(
	array(
  		'alignment' => array(
	    	'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
    	)
  	)
);

// SET BACKGROUND COLOR OF CELL
$objPHPExcel->getActiveSheet()->getStyle('R5')->applyFromArray(
    array(	
        'fill' => array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'color' => array('rgb' => '28e0d7')
        )
    )
);

//---------------------------



// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);
$objPHPExcel->getActiveSheet()->getStyle('A1:E4')->getFont()->setBold(true);

$objPHPExcel->setActiveSheetIndex(0);
$objPHPExcel->getActiveSheet()->getStyle('F1')->getFont()->setBold(true);

$objPHPExcel->setActiveSheetIndex(0);
$objPHPExcel->getActiveSheet()->getStyle('A6:AB6')->getFont()->setBold(true);

// Redirect output to a client’s web browser (Excel2007)
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="TIR Data '.gmdate('YMd').'.xlsx"');
header('Cache-Control: max-age=0');
// If you're serving to IE 9, then the following may be needed
header('Cache-Control: max-age=1');

// If you're serving to IE over SSL, then the following may be needed
header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
header ('Pragma: public'); // HTTP/1.0

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');
exit;
