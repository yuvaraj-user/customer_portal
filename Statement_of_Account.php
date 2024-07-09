<?php 

require_once('assets/plugins/TCPDF/tcpdf.php');

class CustomPDF extends TCPDF {
	private $customerAddress;
	private $dateRange;

	public function __construct($customerAddress, $dateRange, $orientation = 'L', $unit = 'mm', $format = 'A4', $unicode = true, $encoding = 'UTF-8', $diskcache = false, $pdfa = false) {
		parent::__construct($orientation, $unit, $format, $unicode, $encoding, $diskcache, $pdfa);
		$this->customerAddress = $customerAddress;
		$this->dateRange = $dateRange;
	}

	public function Header() {
        // Logo on the right side
		$image_file = K_PATH_IMAGES . PDF_HEADER_LOGO;
		$this->Image($image_file, 6, 10, 25, '', 'PNG', '', 'L', false, 300, '', false, false, 0, false, false, false);

        // Address next to the logo
        $this->SetFont('helvetica', '', 10); // Bold font for the address
        $this->SetXY(35, 8); // Set the position for the address text
        $address = "RASI SEEDS (P) LTD\nRASI ENCLAVE, GREEN FIELDS,\n737 C PULIYAKULAM ROAD,\nCOIMBATORE - 641045.\nTel-0422 - 4239800\nFax-04282-242558";
        $this->MultiCell(0, 5, $address, 0, 'L', 0, 1, '', '', true);

        $this->SetFont('helvetica', '', 10);
        $this->SetXY(6, 37);
        $this->MultiCell(0, 20, "DATE: " . $this->dateRange, 0, 'L', 0, 1, '', '', true);

        // Customer address on the right side
        $this->SetXY(230, 8); // Adjust the position as needed
        $this->MultiCell(0, 5, $this->customerAddress, 0, 'L', 0, 1, '', '', true);

        // Title centered
        $this->SetFont('helvetica', 'B', 12); // Reduce font size for the title
        $this->SetXY(25,5); // Reset Y position to ensure title is centered correctly
        $this->Cell(0, 10, 'CUSTOMER STATEMENTS OF ACCOUNT', 0, 1, 'C', 0, '', 0, false, 'T', 'M');

        // Draw a horizontal line
        $this->Line(5, 45, $this->getPageWidth() - 5, 45);

        // Draw border around the page
        $this->Rect(5, 5, $this->getPageWidth() - 10, $this->getPageHeight() - 10);
    }
}

function formatIndianCurrency($num) {
    $num = round($num, 2); // Ensure the number has two decimal places
    $num_parts = explode('.', $num); // Split into integer and decimal parts

    
    $integer_part = $num_parts[0];
    $decimal_part = isset($num_parts[1]) ? '.' . $num_parts[1] : '.00';

    // Convert integer part to string
    $integer_part_str = (string) $integer_part;

    // Separate last three digits
    $lastThree = substr($integer_part_str, -3);

    // Remaining digits
    $otherNumbers = substr($integer_part_str, 0, -3);

    // Insert comma every two digits in the remaining numbers
    if (!empty($otherNumbers)) {
    	$otherNumbers = implode(',', str_split(strrev($otherNumbers), 3));
        // $otherNumbers = implode(',', str_split(strrev($otherNumbers)));
    	$otherNumbers = strrev($otherNumbers);
    }

    // Combine with the last three digits and add decimal part if any
    if($otherNumbers)
    {
    	$formatted_num = $otherNumbers . ','.$lastThree . $decimal_part; 
    }
    else
    {
    	$formatted_num = $otherNumbers .$lastThree . $decimal_part;
    }
    
    // print_r($formatted_num);
    // exit;

    return $formatted_num;
}


// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	// echo "<pre>";
	// print_r($_POST);
	// exit;

	include '../auto_load.php';  

	$pan_no = $_SESSION['EmpID'];

	$qry = "select * from SD_CUS_MASTER where PAN_No='".$pan_no."'";
	$qryExec = sqlsrv_query($conn, $qry);
	while ($row = sqlsrv_fetch_array($qryExec, SQLSRV_FETCH_ASSOC)) {
		$customer_id = $row['Customer'];
	}




    // $customer_id = $_POST['customer_id'];
	$customer_id = '0020000873';

	$fdate = date('d-m-Y', strtotime($_POST['fdate']));
	$tdate = date('d-m-Y', strtotime($_POST['tdate']));

	$fromdate = date('Ymd', strtotime($_POST['fdate']));
	$todate = date('Ymd', strtotime($_POST['tdate']));

    // echo $fdate;
    // exit;
    //http://192.168.162.213:8081/Customer_SOA/PRD/ZIN_RFC_GET_CUS_SOA.php?FROM_DATE=20230601&TO_DATE=20240625&CUSTOMER_CODE=0020000873

	$url ='http://192.168.162.213:8081/Customer_SOA/PRD/ZIN_RFC_GET_CUS_SOA.php?FROM_DATE='.$fromdate.'&TO_DATE='.$todate.'&CUSTOMER_CODE='.$customer_id.'&TOP_RECORD=0';

	// $url = '192.168.162.213:8081/Customer_SOA/DEV/ZIN_RFC_GET_CUS_SOA.php?FROM_DATE=20181113&TO_DATE=20240307&CUSTOMER_CODE=0010001363&TOP_RECORD=0';

    // echo $url;
    // exit;

	$ch = curl_init();
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
	$response = curl_exec($ch);

	if(curl_errno($ch)) {
		echo 'Curl error: ' . curl_error($ch);
		return null;
	}

	curl_close($ch);

	$data = json_decode($response, true);
	if(isset($data['cod']) && $data['cod'] != 200) {
		echo 'API error: ' . $data['message'];
		return null;
	}

        // echo "<pre>";print_r($data);exit;

	if (!empty($data['result'])) {
		$lastCLBAL = null;
		foreach ($data['result'] as $record) {
			$date2 = DateTime::createFromFormat('Ymd', $record["DATE2"]);
			$DATE2 = $date2->format('d-m-Y');

			$date3 = DateTime::createFromFormat('Ymd', $record["DATE3"]);
			$DATE3 = $date3->format('d-m-Y');

			$uniqueValues['OPENB'] = $record['OPENB'];
			$uniqueValues['NAME1'] = $record['NAME1'];
			$uniqueValues['STRAS'] = $record['STRAS'];
			$uniqueValues['ORT01'] = $record['ORT01'];
			$uniqueValues['PSTLZ'] = $record['PSTLZ'];
			$uniqueValues['TELF1'] = $record['TELF1'];
			$uniqueValues['DATE2'] = $DATE2;
			$uniqueValues['DATE3'] = $DATE3;
			$lastCLBAL = $record['CLBAL'];
		}
		$uniqueValues['CLBAL'] = $lastCLBAL;
	} else {
		echo json_encode(array('status' => 'empty'));
		exit;
	}


    // echo "<pre>";
    // print_r($uniqueValues);
    // echo "</pre>";
    // exit;
    if($_POST['submit'] == 'pdf')
    {

		$id="Customer no: ".$customer_id;

		$dateRange = "$fdate to $tdate";

	    // Create the customer address string
		$customerAddress = "$id\n{$uniqueValues['NAME1']}\n{$uniqueValues['STRAS']}\n{$uniqueValues['ORT01']} - {$uniqueValues['PSTLZ']}\n{$uniqueValues['TELF1']}";
	    // Create new PDF document
		$pdf = new CustomPDF($customerAddress,$dateRange);

	    // Create new PDF document
	    // $pdf = new CustomPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

	    // Set document information
		$pdf->SetCreator(PDF_CREATOR);
		$pdf->SetAuthor('Rasi Seeds');
		$pdf->SetTitle('Invoice');
		$pdf->SetSubject('Invoice');

	    // Set default header data
		$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, '');

	    // Set header and footer fonts
		$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
		$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

	    // Set default monospaced font
		$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

	    // Set margins
	    // $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
		$pdf->SetMargins(PDF_MARGIN_LEFT, 47, PDF_MARGIN_RIGHT);
		$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
	    // $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

	    // Set auto page breaks
		$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

	    // Set image scale factor
		$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

	    // Set font
		$pdf->SetFont('dejavusans', '', 10);

	    // Add first page with basic information
		$pdf->AddPage();

	    // <tr class="hr-line" style="border-bottom: 1px solid #000;">
	    //             <td colspan="7"><hr></td>
	    //     </tr>

	        //<td>'.$uniqueValues['OPENB'].'</td>  <td>'.$uniqueValues['CLBAL'].'</td><td>'.$fdate.'</td>


		$html = '
		<table cellpadding="5">
		<thead style="font-size:12px; font-weight:bold;">
		<tr>
		<th>Date</th>
		<th>Description</th>
		<th>Debit</th>
		<th>Credit</th>
		<th>Balance</th>
		<th>Document/ Invoice.No</th>
		<th>Reference</th>
		</tr>
		<tr class="hr-line" style="border-bottom: 1px solid #000;">
		<td colspan="7"><hr></td>
		</tr>
		</thead>

		<tbody style="font-size:10px">

		<tr>
		<td>'.$uniqueValues["DATE2"].'</td>
		<td>Opening Balance</td>
		<td></td>
		<td></td>
		<td>'.formatIndianCurrency($uniqueValues["OPENB"]).'</td>
		<td></td>
		<td></td>
		</tr>
		<tr class="hr-line" style="border-bottom: 1px solid #000;">
		<td colspan="7"><hr></td>
		</tr>';

		foreach ($data['result'] as $td) {
			$date = DateTime::createFromFormat('Ymd', $td["BUDAT"]);
			$formattedDate = $date->format('d-m-Y');
			$formattedDedit = formatIndianCurrency($td["DEBIT"]);
			$formattedCredit = formatIndianCurrency($td["CREDIT"]);
			$formattedBalance = formatIndianCurrency($td["BALANCE"]);
			$html .= '<tr>
			<td>'.$formattedDate.'</td>
			<td>'.$td["TEXT"].'</td>
			<td>'.$formattedDedit.'</td>
			<td>'.$formattedCredit.'</td>
			<td>'.$formattedBalance.'</td>
			<td>'.$td["VBELN"].'</td>
			<td>'.$td["REFITEM"].'</td>
			</tr>';
		}

		$html .= '<tr class="hr-line" style="border-bottom: 1px solid #000;">
		<td colspan="7"><hr></td>
		</tr>
		<tr>
		<td>'.$uniqueValues["DATE3"].'</td>
		<td>Closing Balance</td>
		<td></td>
		<td></td>
		<td>'.formatIndianCurrency($uniqueValues["CLBAL"]).'</td>
		<td></td>
		<td></td>
		</tr>
		<tr class="hr-line" style="border-bottom: 1px solid #000;">
		<td colspan="7"><hr></td>
		</tr>

		</tbody>

		</table>
		<p style="font-size:12px;">The above balance of <b>Rs. '.formatIndianCurrency($uniqueValues["CLBAL"]).' </b>payable to Rasi seeds (p) Ltd is confirmed</p>
		<br>
		<p>______________________</p>
		<p>&nbsp;&nbsp;Name:<br>
		Designation:<br>
		Date:<br>
		</p>
		';

		$pdf->writeHTML($html, true, false, true, false, '');
	    ob_end_clean(); // Clear any previous output
	    // $pdf->Line(5, 50, $pdf->getPageWidth() - 5, 50);

	    // $pdf->Line(5, 58, $pdf->getPageWidth() - 5, 58); // Line after header row
	    // $pdf->Line(5, 67, $pdf->getPageWidth() - 5, 67); // Line after Opening Balance row


	    // Output the PDF to the browser for preview
	    // $pdf->Output('Customer_Statement.pdf', 'I');
	    // exit;

	    $pdfContent = $pdf->Output('', 'S');

	    // Encode PDF content as base64
	    $pdfBase64 = base64_encode($pdfContent);

	    // Send response as JSON
	    echo json_encode(array('status' => 'success','name' => 'pdf','pdfBase64' => $pdfBase64));
	    exit;
	}
	else if($_POST['submit'] == 'excel')
	{
		echo json_encode(array('status' => 'success','name' => 'excel','excel' => $data,'unique' => $uniqueValues));
	    exit;
	}
}

include_once('top_head.php');

include_once('header.php'); 


?>
<style type="text/css">

	/*.loader {
		border: 16px solid #f3f3f3;
		border-top: 16px solid #3498db;
		border-radius: 50%;
		width: 120px;
		height: 120px;
		animation: spin 2s linear infinite;
		position: fixed;
		top: 50%;
		left: 50%;
		margin-top: -60px;
		margin-left: -60px;
		z-index: 9999;
		display: none;
	}

	@keyframes spin {
		0% { transform: rotate(0deg); }
		100% { transform: rotate(360deg); }
	}*/

/*	@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;700;900&display=swap');*/

/**, body {
    font-family: 'Poppins', sans-serif;
    font-weight: 400;
    -webkit-font-smoothing: antialiased;
    text-rendering: optimizeLegibility;
    -moz-osx-font-smoothing: grayscale;
}

html, body {
    height: 100%;
    
/*    overflow: hidden;*/
}*/


/*.container{
	height: 30vh;
}*/

.form-holder {
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      text-align: center;
      min-height: 46vh;
}

.form-holder .form-content {
    position: relative;
    text-align: center;
    display: -webkit-box;
    display: -moz-box;
    display: -ms-flexbox;
    display: -webkit-flex;
    display: flex;
    -webkit-justify-content: center;
    justify-content: center;
    -webkit-align-items: center;
    align-items: center;
    padding: 60px;
}

.form-content .form-items {
  background-color: #152733;
    border: 3px solid #152733;
    padding: 40px;
    display: inline-block;
    width: 34%;
    min-width: 540px;
    -webkit-border-radius: 10px;
    -moz-border-radius: 10px;
    border-radius: 10px;
    text-align: left;
    -webkit-transition: all 0.4s ease;
    transition: all 0.4s ease;
}

.form-content h3 {
    color: #fff;
    text-align: left;
    font-size: 28px;
    font-weight: 600;
    margin-bottom: 5px;
}

.form-content h3.form-title {
    margin-bottom: 30px;
}

.form-content p {
    color: #fff;
    text-align: left;
    font-size: 17px;
    font-weight: 300;
    line-height: 20px;
    margin-bottom: 30px;
}


.form-content label, .was-validated .form-check-input:invalid~.form-check-label, .was-validated .form-check-input:valid~.form-check-label{
    color: #fff;
}

.form-content input[type=date], .form-content select {
    width: 100%;
    padding: 9px 20px;
    text-align: left;
    border: 0;
    outline: 0;
    border-radius: 6px;
    background-color: #fff;
    font-size: 15px;
    font-weight: 300;
    color: #8D8D8D;
    -webkit-transition: all 0.3s ease;
    transition: all 0.3s ease;
    margin-top: 16px;
}


.btn-primary{
    background-color: #6C757D;
    outline: none;
    border: 0px;
     box-shadow: none;
}

.btn-primary:hover, .btn-primary:focus, .btn-primary:active{
    background-color: #495056;
    outline: none !important;
    border: none !important;
     box-shadow: none;
}

/* Button Submit*/

.btn_sub {
  width: 180px;
  height: 60px;
  cursor: pointer;
  background: transparent;
  border: 1px solid #91C9FF;
  outline: none;
  transition: 1s ease-in-out;
}

svg {
  position: absolute;
  left: 0;
  top: 0;
  fill: none;
  stroke: #fff;
  stroke-dasharray: 150 480;
  stroke-dashoffset: 150;
  transition: 1s ease-in-out;
  color: #0d6efd;
}

.btn_sub:hover {
  transition: 1s ease-in-out;
  background: #4F95DA;
}

.btn_sub:hover svg {
  stroke-dashoffset: -480;
}

.btn_sub span {
  color: white;
  font-size: 18px;
  font-weight: 100;
}

.center {
/*  width: 180px;*/
  height: 60px;
/*  position: absolute;*/
}


.select2-container .select2-selection--single {
    box-sizing: border-box;
    cursor: pointer;
    display: block;
    height: 40px !important;
    user-select: none;
    -webkit-user-select: none;
}

.select2-container--default .select2-selection--single .select2-selection__rendered {
    color: #444;
    line-height: 38px !important;
}

.select2-container--default .select2-selection--single .select2-selection__arrow {
	height: 40px !important;
	position: absolute;
	top: 1px;
	right: 1px;
	width: 20px;
}

.empty-state {
	display: flex;
	flex-direction: column;
	align-items: center;
	justify-content: center;
	height: 60vh;
	text-align: center;
	color: #6c757d;
}

.empty-state i {
	font-size: 48px;
	margin-bottom: 20px;
}

.offcanvas-full-height {
	height: 47vh;

}
.offcanvas {
	top:30vh !important;
	width: 18% !important;
	/*border-top-left-radius: 15px;
	border-bottom-left-radius: 15px;*/
/*	background-color: rgb(0 114 45);*/
}

.form-check {
	display: block;
	min-height: 1.5rem;
	padding-left: 17px !important;
	margin-bottom: 0;
	line-height: 1;
}


</style>

<style>
  .checkbox-wrapper-30 .checkbox {
    --bg: #fff;
    --brdr: #d1d6ee;
    --brdr-actv: #1e2235;
    --brdr-hovr: #bbc1e1;
    --dur: calc((var(--size, 2)/2) * 0.6s);
    display: inline-block;
    width: calc(var(--size, 1) * 22px);
    position: relative;
  }
  .checkbox-wrapper-30 .checkbox:after {
    content: "";
    width: 100%;
    padding-top: 100%;
    display: block;
    margin-top: 7px !important;
  }
  .checkbox-wrapper-30 .checkbox > * {
    position: absolute;
  }
  .checkbox-wrapper-30 .checkbox input {
    -webkit-appearance: none;
    -moz-appearance: none;
    -webkit-tap-highlight-color: transparent;
    cursor: pointer;
    background-color: var(--bg);
    border-radius: calc(var(--size, 1) * 4px);
    border: calc(var(--newBrdr, var(--size, 1)) * 1px) solid;
    color: var(--newBrdrClr, var(--brdr));
    outline: none;
    margin: 0;
    padding: 0;
    transition: all calc(var(--dur) / 3) linear;
  }
  .checkbox-wrapper-30 .checkbox input:hover,
  .checkbox-wrapper-30 .checkbox input:checked {
    --newBrdr: calc(var(--size, 1) * 2);
  }
  .checkbox-wrapper-30 .checkbox input:hover {
    --newBrdrClr: var(--brdr-hovr);
  }
  .checkbox-wrapper-30 .checkbox input:checked {
/*    --newBrdrClr: var(--brdr-actv);*/
        --newBrdrClr: #0d6efd;
    transition-delay: calc(var(--dur) /1.3);
  }
  .checkbox-wrapper-30 .checkbox input:checked + svg {
    --dashArray: 16 93;
    --dashOffset: 109;
  }
  .checkbox-wrapper-30 .checkbox svg {
    fill: none;
    left: 0;
    pointer-events: none;
    stroke: var(--stroke, var(--border-active));
    stroke-dasharray: var(--dashArray, 93);
    stroke-dashoffset: var(--dashOffset, 94);
    stroke-linecap: round;
    stroke-linejoin: round;
    stroke-width: 2px;
    top: 0;
    transition: stroke-dasharray var(--dur), stroke-dashoffset var(--dur);
  }
  .checkbox-wrapper-30 .checkbox svg,
  .checkbox-wrapper-30 .checkbox input {
    display: block;
    height: 77%;
    width: 100%;
    margin-top: 14px;
  }
</style>

<style>

.btn_div{
	    padding: 20px;
    margin-left: 50px;
}

#filterOffcanvasLabel {
    font-size:15px; 
    font-weight:bold; 
    color:#fff; 
    letter-spacing:1px;
    text-transform: uppercase;
    align-items: center;
    margin-left: 24px;
    /*padding-left: 15px;
    background-color: #fff;
    border-radius: 5px;
    padding-right: 15px;
    
    margin-top: 5px;*/
}
.form-check-label{
	 font-size:13px; 
	 font-weight:bold; 
/*	 color:#fff; */
/*	 letter-spacing:1px;*/
}

.offcanvas-header {
	background-color:blue !important;

}
.cls_btn{
	border: 3px solid #ccc;
    border-radius: 20px;
    font-size: 12px;
    background-color:#fff !important;
}

.btn_filter {
  background-color: #0d6efd;
  background-size: 200% 100%;
  background-position: 100% 0;
  transition: background-position .5s;
  border: none;
  padding-left: 25px;
  padding-right: 25px;
  border-radius: 5px;
  color: #fff;
  padding-top: 10px;
  padding-bottom: 10px;
}
.btn_apply {
	font-size: 12px;
  background-color: #0d6efd;
  background-size: 200% 100%;
  background-position: 100% 0;
  transition: background-position .5s;
  border: none;
  padding-left: 25px;
  padding-right: 25px;
  border-radius: 5px;
  color: #fff;
  padding-top: 7px;
  padding-bottom: 7px;
}

input[type=date] {
    width: 72%;
    padding: 5px 20px;
    text-align: left;
    border: 1px solid #ccc;
    border-radius:1px;
    outline: 0;
    border-radius: 6px;
    background-color: #fff;
/*    font-size: 12px;*/
    font-weight: 300;
    color: #8D8D8D;
    -webkit-transition: all 0.3s ease;
    transition: all 0.3s ease;
    margin-top: 16px;
    margin-left: 50px;
}
.card_container {
	display: flex;
	flex-direction: column;
	align-items: center;
	justify-content: center;
	height: 80vh;
	text-align: center;
	color: #6c757d;
}

.card_det {
	display: flex;
	justify-content: center;
	margin-top: 20px;
}
.card {
/*	width: 18rem;*/
	transition: transform 0.5s ease-out;
}
.card.animate {
	transform: scale(2);
}

.pdf_card {
  width: 50% !important;
  height: 55vh !important;
  border-radius: 10px;
  border-left: 5px solid red;
  margin-bottom: 20px;
}

.card_head {
  font-size:12px; 
  float:left; 
  color: black; 
  font-weight: bold;
}

.card_data {
  font-size: 11px;
  font-weight: bolder;
  color: grey; 
}

.btn_apply1, .btn_apply2 {
  font-size: 12px;
  background-size: 200% 100%;
  background-position: 100% 0;
  transition: background-position .5s;
  border: none;
  padding-left: 25px;
  padding-right: 25px;
  border-radius: 5px;
  color: #fff;
  padding-top: 7px;
  padding-bottom: 7px;
}

.btn_apply1 {
  background-color: #0d6efd;
  margin-left: 25px;
}

.btn_apply2 {
  background-color: darkred;
  margin-right: 25px;
}

.mt-2 {
  margin-top: -0.5rem !important;
}
.tooltip_btn{
	color: black;
    background: none;
    border: none;
    font-size: 20px;
    float: right;
}
.tooltip_btn:hover{
	color: black !important;
    background: none !important;
    border: none !important;
}

@media only screen and (min-width: 425px) and (max-width: 768px) {
	.offcanvas {
		width: 55% !important;
	}
}

@media only screen and (max-width: 425px) {
	.offcanvas {
		width: 80% !important;
	}
}


</style>

<section class="invoice_head_bg">
</section>

<section>
    <hr style="border:1px solid #082012;">
   <!--  <div class="container">
    	<div class="row">
    		<div class="col-sm first">
    			One of three columns
    		</div>
    		<div class="col-sm second">
    			One of three columns
    		</div>
    		<div class="col-sm third">
    			One of three columns
    		</div>
    	</div>
    </div> -->

    <div class="container">
    	<!-- Filter Icon -->
    	<!-- <div class="d-flex justify-content-end">
    		<i class="fas fa-filter" data-bs-toggle="offcanvas" data-bs-target="#filterOffcanvas" style="cursor: pointer; font-size: 20px;"><label style="font-size: 12px; font-weight: bolder;">Filter</label></i>
    	</div> -->

        <div class="d-flex justify-content-between">
            <h4 class="site-head ms-auto me-auto">Statement of Account</h4>
        </div>

    	 <div class="d-flex justify-content-end">
            <div class="filter-icon-container" data-bs-toggle="offcanvas" data-bs-target="#filterOffcanvas">
            	<button class="btn btn-primary btn_filter"><i class="fas fa-filter"></i> Filter</button>
            </div>
        </div>

    	<!-- Filter Offcanvas -->
    	<div class="offcanvas offcanvas-end offcanvas-full-height" tabindex="-1" id="filterOffcanvas" aria-labelledby="filterOffcanvasLabel">
    		<div class="offcanvas-header">
    			<h5 class="offcanvas-title" id="filterOffcanvasLabel">Select Range Types</h5>
    			<button type="button" class="btn-close cls_btn" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    		</div>
    		<div class="offcanvas-body">
    			<div class="form-check">
    				<div class="checkbox-wrapper-30">
    					<span class="checkbox">
    						<input type="checkbox" value="cd" id="cd"/>
    						<svg>
    							<use xlink:href="#checkbox-30" class="checkbox"></use>
    						</svg>
    					</span>
    					<svg xmlns="http://www.w3.org/2000/svg" style="display:none">
    						<symbol id="checkbox-30" viewBox="0 0 22 22">
    							<path fill="none" stroke="currentColor" d="M5.5,11.3L9,14.8L20.2,3.3l0,0c-0.5-1-1.5-1.8-2.7-1.8h-13c-1.7,0-3,1.3-3,3v13c0,1.7,1.3,3,3,3h13 c1.7,0,3-1.3,3-3v-13c0-0.4-0.1-0.8-0.3-1.2"/>
    						</symbol>
    					</svg>
    					<label class="form-check-label" for="cd">
    						Current Date
    					</label>
    				</div>

    			</div>
                <div class="form-check">
                	<div class="checkbox-wrapper-30">
    					<span class="checkbox">
    						<input type="checkbox" value="ltm" id="ltm"/>
    						<svg>
    							<use xlink:href="#checkbox-30" class="checkbox"></use>
    						</svg>
    					</span>
    					<svg xmlns="http://www.w3.org/2000/svg" style="display:none">
    						<symbol id="checkbox-30" viewBox="0 0 22 22">
    							<path fill="none" stroke="currentColor" d="M5.5,11.3L9,14.8L20.2,3.3l0,0c-0.5-1-1.5-1.8-2.7-1.8h-13c-1.7,0-3,1.3-3,3v13c0,1.7,1.3,3,3,3h13 c1.7,0,3-1.3,3-3v-13c0-0.4-0.1-0.8-0.3-1.2"/>
    						</symbol>
    					</svg>
                    <label class="form-check-label" for="ltm">
                       Last Three Month
                    </label>
    				</div>
                </div>
                <div class="form-check">
                	<div class="checkbox-wrapper-30">
    					<span class="checkbox">
    						<input type="checkbox" value="cdr" id="cdr"/>
    						<svg>
    							<use xlink:href="#checkbox-30" class="checkbox"></use>
    						</svg>
    					</span>
    					<svg xmlns="http://www.w3.org/2000/svg" style="display:none">
    						<symbol id="checkbox-30" viewBox="0 0 22 22">
    							<path fill="none" stroke="currentColor" d="M5.5,11.3L9,14.8L20.2,3.3l0,0c-0.5-1-1.5-1.8-2.7-1.8h-13c-1.7,0-3,1.3-3,3v13c0,1.7,1.3,3,3,3h13 c1.7,0,3-1.3,3-3v-13c0-0.4-0.1-0.8-0.3-1.2"/>
    						</symbol>
    					</svg>
    					
                    <label class="form-check-label" for="cdr">
                        Custom Date Range
                    </label>
    				</div>
                </div>

                <div class="col-md-12 from_date" style="display: none;">
                	<input type="date" class="form-control" id="from_date" placeholder="From Date" name="from_date" required>
                </div>

                <div class="col-md-12 to_date" style="display: none;">
                	<input type="date" class="form-control" id="to_date" name="to_date" placeholder="To Date" required>
                </div>

                <div class="btn_div">
                <!-- <button type="button" class="btn btn-primary">Apply</button> -->
                <button class="btn_apply" role="button" id="applyFilters"><span class="text">Apply</span></button>
            </div>
            </div>
            <!-- <div class="offcanvas-footer">
                
            </div> -->
        </div>

        <div class="no_invoice">
        	<div class="empty-state">
        		<!-- <i class="fas fa-box-open"></i> -->
                <i class="fa-regular fa-file-lines"></i>
        		<p>No data available. Please select filters to view data.</p>
        	</div>
        </div>
         <div class='card_container' style="display:none">
         	<div class='card_det'>
         	</div>
        </div>

        <!-- <div class="container-fluid pdf_fluid" style="display:none">
            <div class="pdf_preview_container" style="display:none">
                <iframe id="pdfPreviewFrame" width="100%" height="700px"></iframe>
            </div>
        </div> -->

         <!-- Add a modal or popup container -->
		<div id="pdfPreviewModal" class="modal fade">
		    <div class="modal-dialog modal-lg">
		        <div class="modal-content" style="margin-top:170px">
		            <div class="modal-header">
		                <h5 class="modal-title">PDF Preview</h5>
		                <!-- <button type="button" class="close" data-dismiss="modal">&times;</button> -->
		                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
		            </div>
		            <div class="modal-body">
		                <iframe id="pdfPreviewFrame" width="100%" height="460px"></iframe>
		            </div>
		        </div>
		    </div>
		</div>
    </div>
</section>
<?php include_once('footer.php') ?>
<?php include_once('bottom_script.php') ?>

<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.0/xlsx.full.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/2.0.5/FileSaver.min.js"></script>

<script type="text/javascript">

	$(document).ready(function() {

		var fdate='';
		var tdate='';
		var submitValue = '';
	

		var panNo = '<?= $_SESSION['EmpID']; ?>';
		// console.log(panNo)

		$('.date_type').select2();

		$('input[type="checkbox"]').on('change', function() {
            $('input[type="checkbox"]').not(this).prop('checked', false);
            var type = $("input:checkbox:checked").val();
            if (type === 'cdr') {
	            $('.from_date, .to_date').show();
	        }
	        else
	        {
	        	$('.from_date, .to_date').hide();
	        }
        });

		$(document).on('click','#applyFilters', function() {
			var type = $("input:checkbox:checked").val();
			if(type)
			{
				var today = new Date();
		        var firstDayOfMonth = new Date(today.getFullYear(), today.getMonth(), 1);
		        var lastDayOfMonth = new Date(today.getFullYear(), today.getMonth() + 1, 0);
		        var threeMonthsAgo = new Date(today.getFullYear(), today.getMonth() - 2, 1);

		        if (type === 'cd') {
		            fdate = tdate = today.toISOString().split('T')[0]; // Current date
		            $('.from_date, .to_date').hide();
		        } else if (type === 'cm') {
		            fdate = firstDayOfMonth.toISOString().split('T')[0];
		            tdate = lastDayOfMonth.toISOString().split('T')[0];
		            $('.from_date, .to_date').hide();
		        } else if (type === 'ltm') {
		            fdate = threeMonthsAgo.toISOString().split('T')[0];
		            tdate = today.toISOString().split('T')[0];
		            $('.from_date, .to_date').hide();
		        } else if (type === 'cdr') {
		            $('.from_date, .to_date').show();
		            fdate = $('#from_date').val();
		            tdate = $('#to_date').val();
		        }

		        $.ajax({
				url: 'common_ajax.php',
				type: 'POST',
				data: {'panNo': panNo, 'fdate': fdate, 'tdate': tdate, 'Action': 'getCustomerDetails'},
				dataType: 'json',
				success: function(response) {
					// var res = JSON.parse(response);
					// cNo = response[0].Customer;
				
		        console.log(response.result.length)
		         console.log(response)
		        // '<div class="d-flex justify-content-between">' +
                //     '<div class="card_head">Customer No: <label class="card_data">'+ response[0].Customer + '</label></div>' +
                //     '<div class="card_head">Name: <label class="card_data">'+ response[0].Customer_Name + '</label></div>' +
                // '</div>' +

		        $('.card_det').empty();
		        if(response.result!='')
		        {
						for (var i = 0; i < response.result.length; i++) {
						    var card = '<div class="card pdf_card">' +
						                  '<div class="card-body">' +
						                  '<form id="pdfForm" action="Statement_of_Account.php" method="post" class="needs-validation" novalidate>' +
						                    '<h5 class="card-title">CUSTOMER STATEMENTS OF ACCOUNT</h5>' +
						                    '<hr style="border:1px solid #666;">' +
						                      '<div class="row"><div style="display: flex;"><span class="card_head">Cus No: </span>&nbsp;<span class="card_data">' + response.result[0].KUNNR + '</span></div></div>' +
						                      '<div class="row"><div style="display: flex;"><span class="card_head">Opening Bal: </span>&nbsp;<span class="card_data"> Rs. ' + response.result[0].OPENB + '</span></div></div>' +
						                    '<table cellpadding="5" style="width: 100%; font-size:10px;">' +
						                      '<thead style="font-size: 10px; font-weight: bold;">' +
						                        '<tr>' +
						                          '<th>Date</th>' +
						                          '<th>Description</th>' +
						                          '<th>Debit</th>' +
						                          '<th>Credit</th>' +
						                          '<th>Balance</th>' +
						                          '<th>Document/ Invoice.No</th>' +
						                          '<th>Reference</th>' +
						                        '</tr>' +
						                        '<tr class="hr-line">' +
						                          '<td colspan="7" style="border-bottom: 1px solid #000;"><hr></td>' +
						                        '</tr>' +
						                      '</thead>' +
						                      '<tbody style="font-size: 9px;">' +
						                        '<tr>' +
						                          '<td>' + fdate + '</td>' +
						                          '<td>Opening Balance</td>' +
						                          '<td></td>' +
						                          '<td></td>' +
						                          '<td>' + response.result[0].OPENB + '</td>' +
						                          '<td></td>' +
						                          '<td></td>' +
						                        '</tr>' +
						                        '<tr class="hr-line">' +
						                          '<td colspan="7" style="border-bottom: 1px solid #000;"><hr></td>' +
						                        '</tr>' +
						                        '<tr>' +
						                          '<td>' + response.result[0].BUDAT + '</td>' +
						                          '<td>' + response.result[0].TEXT + '</td>' +
						                          '<td>' + response.result[0].DEBIT + '</td>' +
						                          '<td>' + response.result[0].CREDIT + '</td>' +
						                          '<td>' + response.result[0].BALANCE + '</td>' +
						                          '<td>' + response.result[0].VBELN + '</td>' +
						                          '<td>' + response.result[0].REFITEM + '</td>' +
						                        '</tr>' +
						                        '<tr>' +
						                          '<td>' + response.result[1].BUDAT + '</td>' +
						                          '<td>' + response.result[1].TEXT + '</td>' +
						                          '<td>' + response.result[1].DEBIT + '</td>' +
						                          '<td>' + response.result[1].CREDIT + '</td>' +
						                          '<td>' + response.result[1].BALANCE + '</td>' +
						                          '<td>' + response.result[1].VBELN + '</td>' +
						                          '<td>' + response.result[1].REFITEM + '</td>' +
						                        '</tr>' +
						                        '<tr class="hr-line">' +
						                          '<td colspan="7" style="border-bottom: 1px solid #000;"><hr></td>' +
						                        '</tr>' +
						                      '</tbody>' +
						                    '</table>' +
						                    '<input type="hidden" class="form-control" id="fdate" name="fdate" value="'+ fdate +'" required>' +
						                    '<input type="hidden" class="form-control" id="tdate" name="tdate" value="'+ tdate +'" required>' +
						                    '<input type="hidden" class="form-control" id="type" name="type" value="'+ type +'" required>' +
						                    '<div><button type="button" class="tooltip_btn" data-bs-toggle="tooltip" data-bs-placement="top" title="View Full Details Click PDF or Excel Btn">...</button></div><br>' +
						                    '<div class="d-flex justify-content-between mt-3">' +
						                      '<button class="btn_apply1" type="submit" name="submit" value="pdf">View PDF</button>' +
						                      '<div id="hiddenDiv" style="display:none;"></div>' +
						                      '<button class="btn_apply2" type="submit" name="submit" value="excel">View Excel</button>' +
						                    '</div>' +
						                  '</form>' +
						                  '</div>' +
						                '</div>';

						}

						$('.no_invoice').css('display','none');
						    $('.card_det').append(card);
						$('.cls_btn').trigger('click');
						$('.card_container').css('display','block');
					}
					else
					{
						swal({
							title: "Warning",
							text: "No Data For this Date Range",
							icon: "warning"
						});

						setTimeout(function() {
							window.location.reload();
						}, 1000);
					}



	        	// $('#filterModal').modal('hide');
			}
		});
	}
	else
	{
		swal({
			title: "Error",
			text: "Please Select CheckBox",
			icon: "error"
		});
		var empty = '<i class="fas fa-box-open"></i>' +
		'<p>No data available. Please select filters to view data.</p>';
		$('.empty-state').empty();
		$('.empty-state').append(empty);

	}
			
   });

		    // Store the button value on click
		    // $(document).on('click', '.btn_apply1', function() {
		    // 	 $('.btn_apply2').prop('disabled', true);
		    //     submitValue = $(this).val();
		    //     formSubmit(submitValue);
		    // });

 $(document).on('click', '.btn_apply1, .btn_apply2', function() {
        submitValue = $(this).val();
        // Disable the other button to prevent multiple clicks
        // $('.btn_apply1, .btn_apply2').prop('disabled', true);
    });

		// function formSubmit(submitValue){
			$(document).on('submit','#pdfForm',function(e) {
			e.preventDefault();

			console.log(submitValue)


                    // Show loader or loading message if needed
			function showLoader() {
				$('.ajaxloader').show();
				// $('.loader').show();
			}

                    // Function to hide the loader
			function hideLoader() {
				$('.ajaxloader').hide();
				// $('.loader').hide();
			}

			var formData = new FormData(this);
        // Append the submit value to the FormData object
          formData.append('submit', submitValue);


            // Submit form via AJAX
			$.ajax({
				url: $(this).attr('action'),
				type: 'POST',
				// data: new FormData(this),
				data: formData,
				contentType: false,
				cache: false,
				processData: false,
				beforeSend: function(){
					showLoader();
				},
				success: function(response) {
                         // console.log(response);
					try {
						var responseData = JSON.parse(response);
						if(responseData.status=='success')
						{
							if(responseData.name=='pdf')
							{
								var pdfBase64 = responseData.pdfBase64;

								if(pdfBase64)
								{
									$('#pdfPreviewFrame').empty();
									$('.pdf_preview_container').css('display','block');
									$('.pdf_fluid').css('display','block');
		                                // Set iframe src to display PDF
									var pdfDataUri = 'data:application/pdf;base64,' + pdfBase64;
									$('#pdfPreviewFrame').attr('src', pdfDataUri);

									// Show the modal
		                            $('#pdfPreviewModal').modal('show');

		                            // var filename = 'SOA.pdf'; // Get filename from response
									// var link = document.createElement('a');
									// link.href = pdfDataUri;
									// link.download = filename;
									// link.click();
								}
							}
							else if(responseData.name=='excel')
							{
								var data = responseData.excel;
								var unique = responseData.unique;

								// console.log(data)
								// console.log(unique)

								 // var dateString = data.result[j].BUDAT;

								    // Parse the date string to create a Date object
								    // var year = parseInt(dateString.substring(0, 4), 10);
								    // var month = parseInt(dateString.substring(4, 6), 10) - 1; // Months are 0-based in JavaScript
								    // var day = parseInt(dateString.substring(6, 8), 10);

								    // var date = new Date(year, month, day);

								    // // Format the date to 'DD-MM-YYYY'
								    // var options = { day: '2-digit', month: '2-digit', year: 'numeric' };
								    // var formattedDate = date.toLocaleDateString('en-GB', options);

								$('#hiddenDiv').empty();
								// var htmlTable = $("#dataTable");
								// if ($.fn.DataTable.isDataTable(htmlTable)) {
								// 	htmlTable.DataTable().destroy();
								// }

								var table = '<table id="dataTable" cellpadding="5">' +
								    '<thead style="font-size:12px; font-weight:bold; text-align:center;">' +
								    '<tr>' +
								    '<th colspan="7">CUSTOMER STATEMENTS OF ACCOUNT</th>' +
								    '</tr>' +

								    '<tr>' +
								    '<th colspan="3">CusNo: ' + data.result[0].KUNNR + '</th><th colspan="4">CusName: ' + data.result[0].NAME1 + '</th>' +
								    '</tr>' +

								    '<tr>' +
								    '<th>Date</th><th>Description</th><th>Debit</th><th>Credit</th><th>Balance</th><th>Document/ Invoice.No</th><th>Reference</th>' +
								    '</tr>' +
								    '</thead>' +
								    '<tbody style="font-size:10px;">' +
								    '<tr>' +
								    '<td>' + unique.DATE2 + '</td>' +
								    '<td>Opening Balance</td>' +
								    '<td></td>' +
								    '<td></td>' +
								    '<td>' + formatIndianCurrency(unique.OPENB) + '</td>' +
								    '<td></td>' +
								    '<td></td>' +
								    '</tr>';

								for (var j = 0; j < data.result.length; j++) {
								    var rawDate = data.result[j].BUDAT; // Assuming rawDate is in 'YYYYMMDD' format
								    var year = rawDate.substring(0, 4);
								    var month = rawDate.substring(4, 6);
								    var day = rawDate.substring(6, 8);

								    var date = new Date(year, month - 1, day); // month is zero-based in JavaScript
								    var formattedDate = date.toLocaleDateString('en-GB'); // Format as 'DD/MM/YYYY'

								    var formattedDedit = formatIndianCurrency(data.result[j].DEBIT);
								    var formattedCredit = formatIndianCurrency(data.result[j].CREDIT);
								    var formattedBalance = formatIndianCurrency(data.result[j].BALANCE);
								    table += '<tr>' +
								        '<td>' + formatDateToDDMMYYYYHyp(formattedDate) + '</td>' +
								        '<td>' + data.result[j].TEXT + '</td>' +
								        '<td>' + formattedDedit + '</td>' +
								        '<td>' + formattedCredit + '</td>' +
								        '<td>' + formattedBalance + '</td>' +
								        '<td>' + data.result[j].VBELN + '</td>' +
								        '<td>' + data.result[j].REFITEM + '</td>' +
								        '</tr>';
								}

								table += '</tbody>' +
								    '<tfoot>' +
								    '<tr>' +
								    '<td>' + unique.DATE3 + '</td>' +
								    '<td>Closing Balance</td>' +
								    '<td></td>' +
								    '<td></td>' +
								    '<td>' + formatIndianCurrency(unique.CLBAL) + '</td>' +
								    '<td></td>' +
								    '<td></td>' +
								    '</tr>' +
								    '</tfoot>' +
								    '</table>';

								$('#hiddenDiv').html(table);
								$('#dataTable').DataTable();

								// Convert the table to an Excel file and trigger the download
								var wb = XLSX.utils.table_to_book(document.getElementById('dataTable'), { sheet: "CUSTOMER STATEMENTS OF ACCOUNT" });
								var wbout = XLSX.write(wb, { bookType: 'xlsx', type: 'binary' });

								function s2ab(s) {
								    var buf = new ArrayBuffer(s.length);
								    var view = new Uint8Array(buf);
								    for (var i = 0; i < s.length; i++) view[i] = s.charCodeAt(i) & 0xFF;
								    return buf;
								}

								// Save the Excel file
								saveAs(new Blob([s2ab(wbout)], { type: "application/octet-stream" }), 'SOA.xlsx');
				            }
							// console.log(table);
						}
						else if(responseData.status=='empty')
						{
							// alert('No Data For this daterange')
							swal({
							  title: "Warning",
							  text: "No Data For this Daterange!",
							  icon: "warning"
							});
						}


					} catch (error) {
						console.error('Error parsing JSON:', error);
					}
				},
				complete: function(){
					hideLoader();
				},
				error: function(xhr, status, error) {
					console.error('Error:', error);
				}
			});
		});
		// }

			function formatIndianCurrency(num) {
			    // Ensure the number has two decimal places
			    num = parseFloat(num);
			    num = num.toFixed(2);

			    // Split into integer and decimal parts
			    var num_parts = num.split('.');
			    var integer_part = num_parts[0];
			    var decimal_part = num_parts[1] ? '.' + num_parts[1] : '.00';

			    // Convert integer part to string
			    var integer_part_str = String(integer_part);

			    // Separate last three digits
			    var lastThree = integer_part_str.substring(integer_part_str.length - 3);

			    // Remaining digits
			    var otherNumbers = integer_part_str.substring(0, integer_part_str.length - 3);

			    // Insert comma every two digits in the remaining numbers
			    if (otherNumbers !== '') {
			        otherNumbers = otherNumbers.split('').reverse().join('');
			        otherNumbers = otherNumbers.match(/.{1,2}/g).join(',');
			        otherNumbers = otherNumbers.split('').reverse().join('');
			    }

			    // Combine with the last three digits and add decimal part if any
			    var formatted_num = otherNumbers ? otherNumbers + ',' + lastThree + decimal_part : lastThree + decimal_part;

			    return formatted_num;
			}

			function formatDateToDDMMYYYY(dateString) {
				var dateParts = dateString.split("-");
				return dateParts[2] + "-" + dateParts[1] + "-" + dateParts[0];
			}

			function formatDateToDDMMYYYYHyp(dateString) {
				var dateParts = dateString.split("/");
				return dateParts[0] + "-" + dateParts[1] + "-" + dateParts[2];
			}


		// var end = moment();
		// $('#daterange').daterangepicker({
		// 	autoUpdateInput: false,
		// 	maxDate: end,
		// 	showDropdowns: true,
		// }, function(start, end, label) {
		// 	// console.log("A new date selection was made: " + start.format('YYYY-MM-DD') + '-' + end.format('YYYY-MM-DD'));
		// 	var text = start.format('YYYY-MM-DD') + ' To ' + end.format('YYYY-MM-DD');
		// 	$('#daterange').val(text);
		// });

		
		
	// 	$(document).on('change', '.date_type', function() {
    //     var type = $(this).val();
    //     var today = new Date();
    //     var firstDayOfMonth = new Date(today.getFullYear(), today.getMonth(), 1);
    //     var lastDayOfMonth = new Date(today.getFullYear(), today.getMonth() + 1, 0);
    //     var threeMonthsAgo = new Date(today.getFullYear(), today.getMonth() - 2, 1);

    //     if (type === 'cd') {
    //         fdate = tdate = today.toISOString().split('T')[0]; // Current date
    //         $('.f_date, .t_date').hide();
    //     } else if (type === 'cm') {
    //         fdate = firstDayOfMonth.toISOString().split('T')[0];
    //         tdate = lastDayOfMonth.toISOString().split('T')[0];
    //         $('.f_date, .t_date').hide();
    //     } else if (type === 'ltm') {
    //         fdate = threeMonthsAgo.toISOString().split('T')[0];
    //         tdate = today.toISOString().split('T')[0];
    //         $('.f_date, .t_date').hide();
    //     } else if (type === 'cdr') {
    //         $('.f_date, .t_date').show();
    //         fdate = '';
    //         tdate = '';
    //     }

    //     $('#fdate').val(fdate);
    //     $('#tdate').val(tdate);
    // });

	});
	
</script>
</body>

