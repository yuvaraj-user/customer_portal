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

	$url ='http://192.168.162.213:8081/Customer_SOA/PRD/ZIN_RFC_GET_CUS_SOA.php?FROM_DATE='.$fromdate.'&TO_DATE='.$todate.'&CUSTOMER_CODE='.$customer_id.'';
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
			$uniqueValues['OPENB'] = $record['OPENB'];
			$uniqueValues['NAME1'] = $record['NAME1'];
			$uniqueValues['STRAS'] = $record['STRAS'];
			$uniqueValues['ORT01'] = $record['ORT01'];
			$uniqueValues['PSTLZ'] = $record['PSTLZ'];
			$uniqueValues['TELF1'] = $record['TELF1'];
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

        //<td>'.$uniqueValues['OPENB'].'</td>  <td>'.$uniqueValues['CLBAL'].'</td>


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
	<td>'.$fdate.'</td>
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
	<td>'.$tdate.'</td>
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
    echo json_encode(array('status' => 'success','pdfBase64' => $pdfBase64));
    exit;
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

	@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;700;900&display=swap');

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


</style>

<section class="invoice_head_bg">
</section>

<section>
	<hr style="border:1px solid #082012;">

	<!-- <div id="loader-wrapper">
		<div class="preloader" style="display:none;"></div>
	</div> -->


	<!-- <div class="card filter-bg">
		<div class="card-body">
			<form id="pdfForm" action="Statement_of_Account.php" method="post" class="needs-validation" novalidate>
				<div class="row justify-content-center" style="padding-left: 260px !important;">

				<div class="col-md-12 col-lg-3 col-xl-3 d-flex">

					<label for="fdate" class="form-label text-white text-nowrap me-3">From Date:</label>
					<input type="date" class="form-control" id="fdate" name="fdate" required>
				</div>
				<div class="col-md-12 col-lg-3 col-xl-3 d-flex">

					<label for="tdate" class="form-label text-white text-nowrap me-3">To Date:</label>
					<input type="date" class="form-control" id="tdate" name="tdate" required>
				</div>
				<div class="col-md-12 col-lg-3 col-xl-3 d-flex">
					<button type="submit" class="btn btn-primary" name="generate_pdf">Generate PDF</button>
				</div>
				</div>
				</form>
				</div>
			</div>

				</section>

				<section>
					<div class="container" style="height:700px !important;">
						<div class="container-fluid pdf_fluid" style="display:none">
							<div class="pdf_preview_container" style="display:none"><div class="pdf_preview_container" style="display:none">
								<iframe id="pdfPreviewFrame" width="100%" height="700px"></iframe>
							</div>
						</div>
					</div>

				</div> -->

		<div class="form-body">
        <div class="row">
            <div class="form-holder">
                <div class="form-content">
                    <div class="form-items">
                        <h3>Select Date Range Type</h3>
                        <form id="pdfForm" action="Statement_of_Account.php" method="post" class="needs-validation" novalidate>

                           <div class="col-md-12">
                                <select class="form-select mt-3 date_type" required>
                                      <option value="">Select</option>
                                      <option value="cd">Current Date</option>
                                      <!-- <option value="cm">Current Month</option> -->
                                      <option value="ltm">Last Three Months</option>
                                      <option value="cdr">Custom Date Range</option>
                               </select>
                           </div>

                            <div class="col-md-12 f_date" style="display: none;">
                               <input type="date" class="form-select" id="fdate" placeholder="From Date" name="fdate" required>
                            </div>

                            <div class="col-md-12 t_date" style="display: none;">
                               <input type="date" class="form-select" id="tdate" name="tdate" placeholder="To Date" required>
                            </div>

                            <div class="center">
                            	<div class="form-button mt-3">
                                <button type="submit" class="btn btn-primary btn_sub" name="generate_pdf"> <svg width="180px" height="60px" viewBox="0 0 180 60" class="border">
							          <polyline points="179,1 179,59 1,59 1,1 179,1" class="bg-line" />
							          <polyline points="179,1 179,59 1,59 1,1 179,1" class="hl-line" />
							        </svg>
						        <span>Go&nbsp;<i class="fa-solid fa-arrow-right"></i></span>
    							</button>
                            </div>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
						<div class="container-fluid pdf_fluid" style="display:none">
							<div class="pdf_preview_container" style="display:none"><div class="pdf_preview_container" style="display:none">
								<iframe id="pdfPreviewFrame" width="100%" height="700px"></iframe>
							</div>
						</div>
					</div>

				</div>

	</section>
<?php include_once('footer.php') ?>
<?php include_once('bottom_script.php') ?>

<script type="text/javascript">

	$(document).ready(function() {

		$('.date_type').select2();

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

		var fdate='';
		var tdate='';
		
		$(document).on('change', '.date_type', function() {
        var type = $(this).val();
        var today = new Date();
        var firstDayOfMonth = new Date(today.getFullYear(), today.getMonth(), 1);
        var lastDayOfMonth = new Date(today.getFullYear(), today.getMonth() + 1, 0);
        var threeMonthsAgo = new Date(today.getFullYear(), today.getMonth() - 2, 1);

        if (type === 'cd') {
            fdate = tdate = today.toISOString().split('T')[0]; // Current date
            $('.f_date, .t_date').hide();
        } else if (type === 'cm') {
            fdate = firstDayOfMonth.toISOString().split('T')[0];
            tdate = lastDayOfMonth.toISOString().split('T')[0];
            $('.f_date, .t_date').hide();
        } else if (type === 'ltm') {
            fdate = threeMonthsAgo.toISOString().split('T')[0];
            tdate = today.toISOString().split('T')[0];
            $('.f_date, .t_date').hide();
        } else if (type === 'cdr') {
            $('.f_date, .t_date').show();
            fdate = '';
            tdate = '';
        }

        $('#fdate').val(fdate);
        $('#tdate').val(tdate);
    });



		$(document).on('submit','#pdfForm',function(e) {
			e.preventDefault();

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

            // Submit form via AJAX
			$.ajax({
				url: $(this).attr('action'),
				type: 'POST',
				data: new FormData(this),
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
							var pdfBase64 = responseData.pdfBase64;

							if(pdfBase64)
							{
								$('#pdfPreviewFrame').empty();
								$('.pdf_preview_container').css('display','block');
								$('.pdf_fluid').css('display','block');
	                                // Set iframe src to display PDF
								var pdfDataUri = 'data:application/pdf;base64,' + pdfBase64;
								$('#pdfPreviewFrame').attr('src', pdfDataUri);
							}
						}
						else if(responseData.status=='empty')
						{
							// alert('No Data For this daterange')
							swal({
							  title: "Error",
							  text: "No Data For this Daterange!",
							  icon: "error"
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
	});
	
</script>
</body>

