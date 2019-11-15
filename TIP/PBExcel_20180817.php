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

	$con="";
	$ServerName="cp-trdcomsys-sql.database.secure.windows.net";
	$password='@cc3s$d3v123';
	$ConnectInfo=array("DATABASE"=>"TCS_MAIN","UID"=>"jlucero","PWD"=>$password);
	$con=sqlsrv_connect($ServerName,$ConnectInfo);

	// SAVE TO AUDIT TRAIL
	$SqlAudit="insert into tip.Audittrail(Description,Usertype,NameofUser) values('Successfully Download Partial Balance Excel file : ".gmdate('YMd').'.xlsx'."  for  Partial Balance Report','".$UserType."','".$parentCode."')";
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
			->setCellValue('A1', 'Report Type     : Partial Balance')
			->setCellValue('A2', 'Reporting Month   : '.(gmdate('m')-1))
			->setCellValue('A3', 'Date & Time    : '.date('l jS \of F Y h:i:s A'))

			// CREDIT DATA
			->setCellValue('A6', 'Parent and Customer Details')
			->setCellValue('B6', 'Invoice Details')
			->setCellValue('C6', 'District / Division / BP ')
			->setCellValue('D6', 'PR Number / Transaction ID')
			->setCellValue('E6', 'Nature / Classification')
			->setCellValue('F6', 'Amount')
			//->setCellValue('F6', 'Amount / Budget Type')
			->setCellValue('H6', 'OR Date / Expense Year / Remarks')
			->setCellValue('I6', 'SYSTEM ID')

			// SHOULD BE ENTRY
			->setCellValue('J6', 'Reference Type') 
			->setCellValue('K6', 'CM/Addback') 
			->setCellValue('L6', 'Amount Budget') 
			->setCellValue('M6', 'Year') 
			->setCellValue('N6', 'Type') 
			->setCellValue('O6', 'Correct Division') 
			->setCellValue('P6', 'Correct Classification') 
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
			->setCellValue('AB6', 'TAF is CORP?') 


			;
				 	
		 	$sqlModal="select dim4_Cd,bp_type_Cd,cast(invoice_Date as nvarchar)  as invoice_Date,budget_desc,invoice_month,ID,dim5_desc_division,bp_code,business_partner_name,parent_name,parent_Cd,district,name,invoice,pr_number,cast(or_Date as nvarchar)  as or_Date,transaction_Amount,dim1_Desc,remarks,dim4_Cd,invoice_year,division,transaction_sid from tip.V_PARTIAL_BALANCE  where bdm_username='".$parentCode."' and IsStatusSubmitted='Pending'  and  IsStatus in ('Pending','Draft') and dim5_Cd IN (". $BusinessUnit .") and  ischeck='Checked' and actual_month in (select max(actual_month) from [TIP].[V_PARTIAL_BALANCE] where actual_year in (select max(actual_year) from [TIP].[V_PARTIAL_BALANCE] ) )"; 	
		 	//echo $sqlModal;

		 	//where bdm_username='".$parentCode."' and company_Cd in (". $BusinessUnit .")  and IsStatusSubmitted='Pending' and reporting_period in (select max(reporting_period) from [TIP].[Vw_BDMUserTagging] where reporting_year in (select max(reporting_year) from [TIP].[Vw_BDMUserTagging] ) )
			$stmt=sqlsrv_query($con,$sqlModal);

			$x=7;
			$alphabet = range('A', 'Z');			

			while($row=sqlsrv_fetch_array($stmt,SQLSRV_FETCH_ASSOC)){
				$objPHPExcel->getActiveSheet()->getStyle('A'.$x)
    			->getNumberFormat()
    			->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
    			

				$objPHPExcel->getActiveSheet()->setCellValueExplicit ('A'.$x, '('.$row['parent_Cd'].')'.$row['parent_name'] . ' / ' .'('.$row['bp_code'].')'.$row['business_partner_name'],PHPExcel_Cell_DataType::TYPE_STRING);	
				$objPHPExcel->getActiveSheet()->setCellValue ('B'.$x,$row['invoice'] . ' / ' . '('.$row['invoice_month'].')'.$row['invoice_Date']);	
				$objPHPExcel->getActiveSheet()->setCellValue ('C'.$x,$row['district'] . ' / ' .$row['dim5_desc_division'] . ' / '.$row['bp_type_Cd']);	
				$objPHPExcel->getActiveSheet()->setCellValue ('D'.$x,$row['pr_number'] . ' / ' .$row['transaction_sid'] );	
				$objPHPExcel->getActiveSheet()->setCellValue ('E'.$x,$row['dim1_Desc']);	
				$objPHPExcel->getActiveSheet()->setCellValue ('F'.$x,$row['transaction_Amount']);	
				//$objPHPExcel->getActiveSheet()->setCellValue ('F'.$x,number_format($row['transaction_Amount'],2));	
				//$objPHPExcel->getActiveSheet()->setCellValue ('F'.$x,number_format($row['transaction_Amount'],2) . ' / ' .$row['budget_desc'] );	
				$objPHPExcel->getActiveSheet()->setCellValue ('H'.$x,$row['or_Date'] . ' / ' .substr($row['dim4_Cd'],2,4)  . ' / ' .$row['remarks'] );	
				$objPHPExcel->getActiveSheet()->setCellValue ('I'.$x,$row['ID']);	

				//compare data for HAS VALIDATION FIELD
				$objPHPExcel->getActiveSheet()->setCellValue ('G'.$x,substr($row['dim4_Cd'],2,4) .' / '. $row['division']);	
				
				//should be and DATA ID
				$objPHPExcel->getActiveSheet()->setCellValue ('J'.$x,'--');					
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
				$objPHPExcel->getActiveSheet()->setCellValue ('Y'.$x,'=IF(AND(P'.$x.'="--",J'.$x.'="--",K'.$x.'="--",L'.$x.'="--",M'.$x.'="--",N'.$x.'="--",O'.$x.'="--"),"Pending",IF(OR(P'.$x.'="--",J'.$x.'="--",K'.$x.'="--",L'.$x.'="--",M'.$x.'="--",N'.$x.'="--",O'.$x.'="--",P'.$x.'="",J'.$x.'="",K'.$x.'="",L'.$x.'="",M'.$x.'="",N'.$x.'="",O'.$x.'=""),"Draft",IF(OR(AND(AB'.$x.'="FALSE",AA'.$x.'=0),(AND(AB'.$x.'="TRUE",AA'.$x.'=F'.$x.'))),"Accomplished","Draft")))');
				$objPHPExcel->getActiveSheet()->setCellValue ('Z'.$x,'=IF(M'.$x.' & " / " & O'.$x.'=G'.$x.',"NO","YES")');
				$objPHPExcel->getActiveSheet()->setCellValue ('AA'.$x,'=SUM(R'.$x.': X'.$x.')');
				
				$objPHPExcel->getActiveSheet()->setCellValue ('AB'.$x,'=IF(ISNUMBER(SEARCH("CORP",J'.$x.')),"TRUE","FALSE")');	
				//$objPHPExcel->getActiveSheet()->setCellValue ('AB'.$x,'=IF(COUNTIF(J'.$x.',"*???CORP???*")=1,"TRUE","FALSE")');	
				



				//NUMBER FORMAT
				$objPHPExcel->getActiveSheet()->getStyle('R'.$x.':X'.$x)->getNumberFormat()->setFormatCode('#,##0.00');
				$objPHPExcel->getActiveSheet()->getStyle('AA'.$x)->getNumberFormat()->setFormatCode('#,##0.00');
		
				
				//$objPHPExcel->getActiveSheet()->setCellValue ('Z'.$x,'=AB'.$x);
				//$objPHPExcel->getActiveSheet()->setCellValue ('P'.$x,'=IF(AND(I'.$x.'="--",J'.$x.'="--",K'.$x.'="--",L'.$x.'="--",M'.$x.'="--",N'.$x.'="--",O'.$x.'="--"),"Pending",
				//IF(OR(I'.$x.'="--",J'.$x.'="--",K'.$x.'="--",L'.$x.'="--",M'.$x.'="--",N'.$x.'="--",O'.$x.'="--",I'.$x.'="",J'.$x.'="",K'.$x.'="",L'.$x.'="",M'.$x.'="",N'.$x.'="",O'.$x.'=""),"Draft","Accomplished"))
				//	');
				$x=$x+1;

				


				



				
				// CREDIT DETAILS FORM -----------------------------------------------------------------------
				//TO GET THE NUMBER OF COLUMNS
				$intCounterLtr=0;
				for($intCount=1;$intCount<=9;$intCount++){
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
				$intCounterLtr=9;
				for($intCount=0;$intCount<=14;$intCount++){
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

					
					// FOR Y AND Z COLUMN
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

// HIDE COLUMNS
$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setVisible(false);

// Rename worksheet
$objPHPExcel->getActiveSheet()->setTitle('PB DATA');




//LOCK SPECIFIC CELL
$objPHPExcel->getActiveSheet()->getProtection()->setPassword('KAMOTE');
$objPHPExcel->getActiveSheet()->getProtection()->setSheet(true);


// SET BACKGROUND COLOR OF CELL
$objPHPExcel->getActiveSheet()->getStyle('A6:I6')->applyFromArray(
    array(	
        'fill' => array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'color' => array('rgb' => '999966')
        )
    )
);


$objPHPExcel->getActiveSheet()->getStyle('J6:X6')->applyFromArray(
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
$objPHPExcel->getActiveSheet()->setCellValue ('R5',"If Reference Type is CORPORATE");
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
header('Content-Disposition: attachment;filename="Partial Balance Data '.gmdate('YMd').'.xlsx"');
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
