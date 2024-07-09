<?php
// Start output buffering to prevent any output before PDF generation
ob_start();

// Include the phpqrcode library
include('phpqrcode/qrlib.php');
// Include the TCPDF library
require_once('assets/plugins/TCPDF/tcpdf.php');
require("/Send_Mail.php");
include('../auto_load.php');
// Invoice number
// $invoiceNumber = $_GET['ino'];
$mail = new Send_Mail();
    // $invoiceNumber = $_POST['invoices'];
    if(!isset($_GET['ino'])){
        $invoiceNumber=$_POST['invoices'];
        }else{
            $invoiceNumber = $_GET['ino'];
        }
    // Example processing: Generate PDF for selected invoices
    // Implement your PDF generation logic here based on $selectedInvoices


// Execute SQL query
$sql = sqlsrv_query($conn, "SELECT Invoice_No 
                            FROM Sales_Placement_Invoice_Details 
                            WHERE Invoice_No IN (SELECT * FROM SPLIT_STRING('".$invoiceNumber."', ',')) 
                            GROUP BY Invoice_No");

// Fetch and display Invoice_No values
$i = 0;
while ($row = sqlsrv_fetch_array($sql, SQLSRV_FETCH_ASSOC)) {
    $invo[] = $row['Invoice_No'];
}
foreach ($invo as $ineNumber) {
    // Perform actions for each invoice number

    // Example: Generate QR code for each invoice number
      $filePath = 'qrcodes/invoice_' . $ineNumber . '.png';

    // Create a directory for storing QR codes if it doesn't exist
    if (!file_exists('qrcodes')) {
        mkdir('qrcodes', 0777, true);
    }

    // Generate the QR code
    QRcode::png($ineNumber, $filePath);
}

// exit;
class CustomPDF extends TCPDF {
    private $invoiceno;
    private $invoicedate;
    public $qrCodePath;

    public function __construct($invoiceno, $invoicedate, $orientation = 'P', $unit = 'mm', $format = 'A4', $unicode = true, $encoding = 'UTF-8', $diskcache = false, $pdfa = false) {
        parent::__construct($orientation, $unit, $format, $unicode, $encoding, $diskcache, $pdfa);
        $this->invoiceno = $invoiceno;
        $this->invoicedate = $invoicedate;
    }

    public function setInvoiceDetails($invoiceno, $invoicedate) {
        $this->invoiceno = $invoiceno;
        $this->invoicedate = $invoicedate;
    }

    public function Header() {
        // "Original for the recipient" at the top
        $this->SetFont('helvetica', 'B', 10);
        $this->Cell(0, 0, 'Original for the recipient', 0, 1, 'R', 0, '', 0, false, 'T', 'M');
    
        // Define the coordinates and dimensions for the box
        $boxX = 5;        // X position of the box
        $boxY = 10;        // Y position of the box (adjusted to move below the recipient text)
        $boxWidth = 200;   // Width of the box
        $boxHeight = 22;   // Height of the box
        $boxLineWidth = 0.5; // Line width of the box
    
        // Draw the box
        $this->Rect($boxX, $boxY, $boxWidth, $boxHeight);
    
        // Logo on the right side
        $image_file = K_PATH_IMAGES . PDF_HEADER_LOGO;
        $this->Image($image_file, $boxX + 5, $boxY + 5, 25, '', 'PNG', '', 'L', false, 300, '', false, false, 0, false, false, false);
    
        // Title in the center
        $this->SetFont('helvetica', 'B', 16);
        $this->SetXY($boxX, $boxY); // Set position to box top
        $this->Cell(150, 10, PDF_HEADER_TITLE, 0, 1, 'C', 0, '', 0, false, 'T', 'M');
    
        // Invoice details on the right
        $PDF_HEADER_STRING = "Invoice No  : $this->invoiceno\nInvoice Date : $this->invoicedate\nS.O.Ref.NO :\n";
        $this->SetFont('helvetica', 'B', 10);
        $this->SetXY($boxX + $boxWidth - 100, $boxY + 5); // Adjust position within the box
        $this->MultiCell(75, 12, $PDF_HEADER_STRING, 0, 'L', 0, 1, '', '', true);
    
        // QR code image after the header text
        $this->Image($this->qrCodePath, $boxX + $boxWidth - 50, $boxY + 5, 15, 15, 'PNG');
    
        // Page number at the top right
        $pageNumberWidth = 80; // Width for the page number cell
        $this->SetXY($boxX + 210 - $pageNumberWidth, $boxY + $boxHeight - 10);
        $this->Cell($pageNumberWidth, 10, 'Page ' . $this->getAliasNumPage() . ' of ' . $this->getAliasNbPages(), 0, 0, 'R', 0, '', 0, false, 'M', 'M');
    }
    

    // Page footer
    public function Footer() {
        // Add underline before the terms and conditions
        $this->Cell(0, 0, '', 'T', 1, 'C');
    
        // Terms and Conditions as a single line with bold heading
        $terms = "<b>Terms & Conditions:</b><br>
                  <span style='font-size: 5pt;'>1. To be paid in full by Demand Draft Payable at Attur, / RTGS / NEFT / IM. 2. Interest will be charged @ 24% P.A. if payment is not made as per term. 3. This Sales is subject to Attur jurisdiction only. 4. Our responsibility ceases when goods have been delivered to the customer or carriers and no claims for damage or shortage can be accepted later. 5. Please mention distributor code allotted to you in all DD's and transactions. 6. Please return the copy of invoice after affixing your seal and sign.</span>";
    
        // Adjust position above the page number
        $this->SetY(-60); // Adjusted to leave room for the terms and conditions and underline
    
        // Set font for the content
        $this->SetFont('helvetica', '', 7);
    
        // Write the terms and conditions with inline HTML for bold text and smaller size
        $this->writeHTMLCell(0, 10, '', '', $terms, 0, 1, false, true, 'L', true);

        // Example: Drawing an underline
        $this->SetLineWidth(0); // Set line width
        $this->Line(15, $this->GetY(), 195, $this->GetY()); // Draw a horizontal line

        // Additional text lines
        $this->SetY(-45); // Adjusted position for additional lines
    
        // Add the text aligned to the right with bold formatting
        $this->SetFont('helvetica', 'B', 8); // Set font to bold
        $this->Cell(0, 5, 'For Rasi Seeds(P) Ltd.', 0, 1, 'R', false);
    
        // Line 2: Seeds For Sowing Purpose Only (Center align)
        $this->Cell(0, 10, 'Seeds For Sowing Purpose Only', 0, 1, 'C');
    
        // Line 3: Authorised Signatory (Right align)
        $this->Cell(0, 5, 'Authorised Signatory', 0, 1, 'R');
    
        // Additional lines
        // Example: Drawing an underline
        $this->SetLineWidth(0); // Set line width
        $this->Line(15, $this->GetY(), 195, $this->GetY()); // Draw a horizontal line
        
        // Adjust Y position for the next content block
        $this->SetY(-25); // Move Y position down by 10 units for spacing
    
        // Define the Y position for both cells
        $y = $this->getY();

        // Set font size
        $this->SetFont('helvetica', '', 6);
        
        // First cell on the left (aligned left)
        $textLeft = 'This is to certify that we have received<br>' .
                    '__________ nos of C/B in good <br>condition as per D.C on Dated ___________';
        
        $this->writeHTMLCell(0, 10, '', $y, $textLeft, 0, 0, false, true, 'L', true);

        // Set font size
        $this->SetFont('helvetica', '', 8);

        // Second cell on the right (aligned center)
        // Adjust X position to move content towards the right
        $x = 30; // Set X position if needed, or leave empty for current position
        
        // Example content with right-aligned text
        $textRight = "<div style='text-align: right;'>"
                   . "<b>Registered Office: <br>Rasi Seeds (p) Ltd,</b><br>"
                   . "<b>Rasi Enclave, Green Fields, 737 C Puliyakulam Road, Coimbatore-641045</b><br>"
                   . "CIN No: U01112TZ1986PTC001864 PAN No:AABCR2871C"
                   . "</div>";
        
        // Write HTML content with adjusted X position
        $this->writeHTMLCell(0, 10, $x, $y, $textRight, 0, 1, false, true, 'C', true);

        // Position at 5 mm from bottom
        $this->SetY(-10); // Adjusted to leave room for the footer text
    
        // Set font for the footer text
        $this->SetFont('helvetica', 'I', 10);
        // Footer text
        $this->Cell(0, 10, 'Breeding Excellence®', 0, 1, 'C', 0, '', 0, false, 'T', 'M');
    }
     
}

function convertNumberToWords($number) {
    if ($number == 0) {
        return "ZERO RUPEES ONLY";
    }

    $no = floor($number);
    $point = round($number - $no, 2) * 100;
    $hundred = null;
    $digits_1 = strlen($no);
    $i = 0;
    $str = array();
    $words = array(
        '0' => '', '1' => 'one', '2' => 'two',
        '3' => 'three', '4' => 'four', '5' => 'five', '6' => 'six',
        '7' => 'seven', '8' => 'eight', '9' => 'nine',
        '10' => 'ten', '11' => 'eleven', '12' => 'twelve',
        '13' => 'thirteen', '14' => 'fourteen',
        '15' => 'fifteen', '16' => 'sixteen', '17' => 'seventeen',
        '18' => 'eighteen', '19' => 'nineteen', '20' => 'twenty',
        '30' => 'thirty', '40' => 'forty', '50' => 'fifty',
        '60' => 'sixty', '70' => 'seventy',
        '80' => 'eighty', '90' => 'ninety'
    );
    $digits = array('', 'hundred', 'thousand', 'lakh', 'crore');
    while ($i < $digits_1) {
        $divider = ($i == 2) ? 10 : 100;
        $number = floor($no % $divider);
        $no = floor($no / $divider);
        $i += $divider == 10 ? 1 : 2;
        if ($number) {
            $plural = (($counter = count($str)) && $number > 9) ? 's' : null;
            $hundred = ($counter == 1 && $str[0]) ? ' and ' : null;
            $str[] = ($number < 21) ? $words[$number] . " " . $digits[$counter] . $plural . " " . $hundred : $words[floor($number / 10) * 10] . " " . $words[$number % 10] . " " . $digits[$counter] . $plural . " " . $hundred;
        } else {
            $str[] = null;
        }
    }
    $str = array_reverse($str);
    $result = implode('', $str);

    $points = ($point) ? " and " . $words[$point / 10] . " " . $words[$point % 10] . " paise only" : '';

    return strtoupper($result . "rupees only" . $points);
}
// $taxvalue = 0; // Example value

// echo $taxvalue_in_words;




// $customer_id = $_POST['invoices'];
if(!isset($_GET['ino'])){
    $customer_id=$_POST['invoices'];
    }else{
        $customer_id = $_GET['ino'];
    }
$invoice_numbers = explode(',', $customer_id);

// Create a new PDF document
$pdf = new CustomPDF('', '');
// Set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Your Name');
$pdf->SetTitle('Invoice smart form');
$pdf->SetSubject('Sample PDF');
$pdf->SetKeywords('TCPDF, PDF, example, sample, dynamic');

// Set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// Set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// Set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

foreach ($invoice_numbers as $invoice_no) {
    $sql = "SELECT Invoice_No, Invoice_Date, LR_Number, LR_Date, Vehicle 
            FROM Sales_Placement_Invoice_Details 
            WHERE Invoice_No = ?";
    $params = array($invoice_no);
    $options = array("Scrollable" => SQLSRV_CURSOR_KEYSET);
    $stmt = sqlsrv_query($conn, $sql, $params, $options);

    if ($stmt === false) {
        die(print_r(sqlsrv_errors(), true));
    }

    if (sqlsrv_num_rows($stmt) > 0) {
        $row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
        $invoiceno = $row['Invoice_No'];
        $invoicedate = $row['Invoice_Date']->format('d-m-Y'); // Assuming Invoice_Date is a DateTime object

        // Update the invoice number and date for the header
        $pdf->setInvoiceDetails($invoiceno, $invoicedate);
        $pdf->qrCodePath = 'qrcodes/invoice_' . $invoiceno . '.png';


        // Add a new page for each invoice
        $pdf->AddPage();

        // Set margins
        $leftMargin = 5; // Left margin in millimeters
        $topMargin = 27; // Top margin in millimeters
        $rightMargin = 15; // Right margin in millimeters
        $pdf->SetMargins($leftMargin, $topMargin, $rightMargin);

        // Set some content to display
        // Adjust the margins and width to match the header box
        $content = '<br>';
        $content .= '<div style="margin-left: 10mm; margin-top: 20mm; width: 200mm;">'; // Match header box alignment
        $content .= '<table cellpadding="4" cellspacing="0" style="width:105.3%; border-collapse: collapse;">';
        $content .= '<tr>';
        
        // Consignor details
        $content .= '<td style="border: 1px solid #000000; font-size: 8px; padding-left: 8px; padding-right: 8px; width:33%;">';
        $content .= '<b>Consignor name:<br>';
        $content .= 'Rasi Seeds (P) Ltd</b><br>';
        $content .= 'C/O. SILICON ENTERPRISES<br>';
        $content .= 'SCF-63, PHASE-1 MODEL TOWN<br>';
        $content .= 'State: Punjab, State Code: 03<br>';
        $content .= 'Telephone: 9463333165<br>';
        $content .= 'GST No: 03AABCR2871C1ZV<br>';
        $content .= 'Seed Lic No: JDA(HYVP)/351<br>';
        $content .= 'Seed Lic Expiry Date: 21.03.2025</td>';
        
        // Consignee details
            //Customer region get and set in session
        $region_sql = "SELECT * FROM SD_CUS_MASTER WHERE PAN_No = '".$_SESSION['EmpID']."'"; 
        $region_sql_exec = sqlsrv_query($conn, $region_sql);
        $customer_region_id = sqlsrv_fetch_array($region_sql_exec,SQLSRV_FETCH_ASSOC);


        $Cust_no = $_SESSION['customer_no'];
		$sql11 = "SELECT * FROM SD_CUS_MASTER WHERE Customer = '$Cust_no'";
		$params11 = array();
		$options11 = array("Scrollable" => SQLSRV_CURSOR_KEYSET);
		$stmt11 = sqlsrv_prepare($conn, $sql11, $params11, $options11);
		sqlsrv_execute($stmt11);
		$row11 = sqlsrv_fetch_array($stmt11);

        $content .= '<td style="border: 1px solid #000000; font-size: 8px; padding-left: 8px; padding-right: 8px; width:33%;">';
        $content .= '<b>Consignee Name -'.$row11['Customer'].'<br>';
        $content .= ''.$row11['Customer_Name'].'</b><br>';
        $content .= ''.$row11['Address'].',<br>';
        // $content .= 'ABOHAR - 152116<br>';
        $content .= 'State: '.$row11['State'].'<br>';
        $content .= 'GST No: '.$row11['GST_No'].'<br>';
        $content .= 'PAN No: '.$row11['PAN_No'].'<br>';
        $content .= 'Mobile No: '.$row11['Tel_Number'].'<br>';
        $content .= 'Seed Lic No: '.$row11['Seed_Licence_No'].'<br>';
        $content .= 'Seed Lic Expiry Date: 06.05.2025</td>';
        
        // Delivery details
        $content .= '<td style="border: 1px solid #000000; font-size: 8px; padding-left: 8px; padding-right: 8px; width:34%;">';
        $content .= '<b>Delivery At:<br>';
        $content .= 'ZIMIDARA PESTICIDES-ABOHAR</b><br>';
        $content .= 'HAQIQAT RAI CHOWK,<br>';
        $content .= 'ABOHAR - 152116<br>';
        $content .= 'State: Punjab, State Code: 03<br>';
        $content .= 'GST No: 03ACGPP6026R1Z7</td>';
        
        $content .= '</tr>';
        $content .= '</table>';
       
        $content .= '<table cellpadding="4" cellspacing="0" style="width:100%; border-collapse: collapse;">';
        $content .= '<tr>';
        $content .= '<td style="font-size: 8px;"><b>L.R.No:</b></td>';
        $content .= '<td style="font-size: 8px;"><b>LR Date:</b></td>';
        $content .= '<td style="font-size: 8px;"><b>Vehicle No:</b></td>';
        $content .= '<td style="font-size: 8px;"><b>Drv No:</b></td>';
        $content .= '<td style="font-size: 8px;"><b>Transporter Name:</b></td>';
        $content .= '</tr>';
        $content .= '</table>';

        // Add a horizontal rule (underline)
        $content .= '<hr style="margin-top: 5mm; width: 200mm; border-width: 1px; color: #000000;">';
        $content .= '<table cellpadding="4" cellspacing="0" style="width:82%; border-collapse: collapse; border: none;">';

        // Table header
        $content .= '<thead>';
        $content .= '<tr>';
        $content .= '<th style="width:5%;  font-size: 8px;"><b>SR No</b></th>';
        $content .= '<th style="width:30%; font-size: 8px;"><b>Crop & Variety</b></th>';
        $content .= '<th style="width:15%; font-size: 8px; text-align: center;"><b>Lot No</b></th>';
        $content .= '<th style="width:10%; font-size: 8px; text-align: center;"><b>Expiry Date</b></th>';
        $content .= '<th style="width:8%;  font-size: 8px; text-align: center;"><b>No of Bags</b></th>';
        $content .= '<th style="width:8%;  font-size: 8px; text-align: center;"><b>Qty-In Pkts</b></th>';
        $content .= '<th style="width:8%;  font-size: 8px; text-align: center;"><b>Rate (Rs.P)</b></th>';
        $content .= '<th style="width:15%; font-size: 8px; text-align: center;"><b>Gross Amount (Rs.P)</b></th>';
        $content .= '<th style="width:6%;  font-size: 8px; text-align: center;"><b>Disc %</b></th>';
        $content .= '<th style="width:10%; font-size: 8px; text-align: center;"><b>Discount (Rs.P)</b></th>';
        $content .= '<th style="width:14%; font-size: 8px; text-align: center;"><b>Taxable Value (Rs.P)</b></th>';
        // $content .= '<hr style="margin-top: 0mm; width: 200mm; border-width: 1px; color: #000000;">';
        $content .= '</tr>';
        $content .= '</thead>';
        $content .= '</table>'; // Close the table if you need the underline outside the table
        
        // Add the underline after the table header
        $content .= '<hr style="margin-top: 0mm; width: 200mm; border-width: 1px; color: #000000;">';


        $i = 1;
		$bag = 0;
		$gross_amount = 0;
		$discount = 0;
		$taxvalue = 0;
		$sql1 = "SELECT Sales_Placement_Invoice_Details.Invoice_No,Sales_Placement_Invoice_Details.Product,Sales_Placement_Invoice_Details.Item_Code,
		Sales_Placement_Invoice_Details.QtyInSalesUnit,Sales_Placement_Invoice_Details.Lot_NO,
		Sales_Placement_Invoice_Details.Sales_Price,Sales_Placement_Invoice_Details.Base_Value,Sales_Placement_Invoice_Details.Net_Amount,Sales_Placement_Invoice_Details.Discount_Percent,
		Sales_Placement_Invoice_Details.Discount_Amount,Master_Product_demo.QtyInPkt,Master_Product_demo.ProductName 
		FROM Sales_Placement_Invoice_Details  inner join Master_Product_demo
		ON Sales_Placement_Invoice_Details.Item_Code = Master_Product_demo.ProductName 
		WHERE Sales_Placement_Invoice_Details.Invoice_No IN (SELECT * FROM SPLIT_STRING('".$invoiceno."',',')) 
		
		GROUP BY Sales_Placement_Invoice_Details.Invoice_No,Sales_Placement_Invoice_Details.Product,Sales_Placement_Invoice_Details.Item_Code,
		Sales_Placement_Invoice_Details.QtyInSalesUnit,Sales_Placement_Invoice_Details.Lot_NO,
		Sales_Placement_Invoice_Details.Sales_Price,Sales_Placement_Invoice_Details.Base_Value,Sales_Placement_Invoice_Details.Net_Amount,Sales_Placement_Invoice_Details.Discount_Percent,
		Sales_Placement_Invoice_Details.Discount_Amount,Master_Product_demo.QtyInPkt,Master_Product_demo.ProductName ";
		$params1 = array();
		$options1 = array("Scrollable" => SQLSRV_CURSOR_KEYSET);
		$stmt1 = sqlsrv_prepare($conn, $sql1, $params1, $options1);
		sqlsrv_execute($stmt1);
		while ($row1 = sqlsrv_fetch_array($stmt1)) {
			$one = $row1['QtyInSalesUnit'];
			$two = $row1['QtyInPkt'];
			$number = ($one / $two );
			//no of bag
			$bag += $number;
			// gross amount
			$gross = $row1['Base_Value'];
			$gross_amount += $gross;
			//discount
			$dis = $row1['Discount_Amount'];
			$discount += $dis;
			//taxvalue
			$tax = $row1['Net_Amount'];
			$taxvalue += $tax;


            $taxvalue_in_words = convertNumberToWords($taxvalue);
            // echo $taxvalue_in_words;
            // Table body (this should be filled with your actual data)
            $content .= '<table cellpadding="4" cellspacing="0" style="width:82%; border-collapse: collapse; border: none;">';
            $content .= '<tbody>';
            
            //Example row (replace with your actual data rows)
            $content .= '<tr>';
            $content .= '<td  style="width:5%;   font-size: 7px;">'.$i++.'</td>';
            $content .= '<td  style="width:30%;  font-size: 5.7px;  ">'.$row1['Product'].','.$row1['Item_Code'].'</td>';
            $content .= '<td  style="width:15%;  font-size: 6px; text-align: center;">'.$row1['Lot_NO'].'</td>';
            $content .= '<td  style="width:10%;  font-size: 7px; text-align: center;">01/01/2025</td>';
            $content .= '<td  style="width:8%;   font-size: 7px; text-align: right;">'.round($number).'</td>'; // Assuming $row1['No_of_Bags'] contains the number
            $content .= '<td  style="width:8%;   font-size: 7px; text-align: right;">'.$row1['QtyInSalesUnit'].'</td>';
            $content .= '<td  style="width:8%;   font-size: 7px; text-align: right;">'.$row1['Sales_Price'].'</td>'; // Fixed missing closing </td> tag
            $content .= '<td  style="width:15%;  font-size: 7px; text-align: right;">'.$row1['Base_Value'].'</td>';
            $content .= '<td  style="width:6%;   font-size: 7px; text-align: right;">'.$row1['Discount_Percent'].'</td>';
            $content .= '<td  style="width:9%;   font-size: 7px; text-align: right;">'.$row1['Discount_Amount'].'</td>';
            $content .= '<td  style="width:14%;  font-size: 7px; text-align: right;">'.$row1['Net_Amount'].'</td>';
            $content .= '</tr>';
            
            }
            $content .= '</tbody>';
            $content .= '</table>';
            $content .= '<br>';
            $content .= '<hr style="margin-top: 20mm; width: 200mm; border-width: 1px; color: #000000;">';
            
            $content .= '<tr>';
            $content .= '<td></td>';
            $content .= '<td></td>';
            $content .= '<td style="font-size: 9px; text-align: right;"><b>Total</b></td>';
            $content .= '<td></td>';
            $content .= '<td style="font-size: 9px; text-align: right;"><b>'.$bag.'</b></td>'; // Example value
            $content .= '<td></td>';
            $content .= '<td></td>';
            $content .= '<td style="font-size: 9px; text-align: right;"><b>'.$gross_amount.'</b></td>'; // Example value
            $content .= '<td></td>';
            $content .= '<td style="font-size: 9px; text-align: right;"><b>'.$discount.'</b></td>'; // Example value
            $content .= '<td style="font-size: 9px; text-align: right;"><b>'.$taxvalue.'</b></td>'; // Example value
            $content .= '</tr>';
            
            // $content .= '</br>';
            // New row for SGST, CGST, IGST, TCS, and HSN No
            $content .= '<tr>';
            $content .= '<td colspan="11" style="border: 1px solid #000000; padding: 8px; font-size: 9px;">';
            $content .= '<b>SGST @ 0.00 %: 0.00 , CGST @ 0.00 %: 0.00 , IGST @ 0.00 %: 0.00 , TCS : 0.00&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;, HSN No : 12072010</b>';
            $content .= '</td>';
            $content .= '</tr>';
            // New row for Net Invoice Amount
            $content .= '<tr>';
            $content .= '<td colspan="6" style=""></td>'; // Empty cells
            $content .= '<td colspan="6" style="text-align: right; font-size: 9px;"><b>Net Invoice Amount&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' . $taxvalue.'</b></td>'; // Net Invoice Amount
            $content .= '</tr>';
            
            
            // New row for Net Invoice Amount Word
            $content .= '<table cellpadding="4" cellspacing="0" style="width:100%; border-collapse: collapse;">';
            $content .= '<tr>';
            $content .= '<td colspan="12" style="font-size: 9px; background-color: #d1cccc; width: 200mm; text-align: left;">
                        <b>AMOUNT IN WORDS:</b> '.$taxvalue_in_words.'</td>';
            $content .= '</tr>';
            $content .= '</table>';
            
            $content .= '</div>'; // Match header box alignment

        // Write HTML content into PDF
        $pdf->writeHTML($content, true, false, true, false, '');
    }

    sqlsrv_free_stmt($stmt);
}

sqlsrv_close($conn);

// End output buffering and clean any previous output
ob_end_clean();

// Output the PDF to the browser (inline)
$pdf->Output('Invoice_smart_form.pdf', 'I');

$attachment = $pdf->Output('', 'S');
// echo json_encode(base64_encode($a));exit;
$template = "<div>
    <p>Dear ".$customer_name.",</p>
</div>
<div>
    <p>Please find the attachment of your Invoice History</p>
</div>
<br>
<p>Best regards,<p>
<p style='font-weight:bold;'>Rasi Seeds</p>
";
$filename = "Invoice History.pdf";
$mail->Send_Mail_Details('Invoice History',$attachment,$filename,$template);
?>

