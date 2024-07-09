<?php
require_once('assets/plugins/TCPDF/tcpdf.php');

require("/Send_Mail.php");
require("../auto_load.php");

$mail = new Send_Mail();

$invoice_nos = isset($_POST['invoices']) ? $_POST['invoices'] : '7000000076,7000000080';

$invoice_nos  = explode(',',$invoice_nos);

// Create a custom TCPDF class
class CustomPDF extends TCPDF {
    // Page header
    public function Header() {
    // Set font
    $this->SetFont('helvetica', '', 10);

    // Start border around header content
    $this->SetLineStyle(array('width' => 0.3, 'color' => array(255, 255, 255))); // Border style
    $this->SetFillColor(255, 255, 255); // Background color (white)
    $this->SetDrawColor(0, 0, 0); // Border color
    $this->SetY(0);
    $this->SetX(0);
    // $this->Cell(190, 33, '', 1, 0, 'C', 1); // Border box dimensions

        // Logo
        $logo = '<img src="assets/plugins/TCPDF/examples/images/logo.png" />';
        // $logo = K_PATH_IMAGES . PDF_HEADER_LOGO;

        $this->SetY(3);
        $this->SetX(8);
        $this->writeHTMLCell(30, 0, '', '', $logo, 0, 1, 0, true, 'L', true);

        $title = '<h1 style="margin: 5px 0; font-size: 18pt; color: #333333;">Rasi Seeds (P) Limited</h1>';
        $this->SetY(3);
        $this->SetX(50);
        $this->writeHTMLCell(110, 0, '', '', $title, 0, 1, 0, true, 'C', true);

        // Paragraphs
        $paragraph1 = '<p>C/O.SILICON ENTERPRISESSCF-63</p>';
        $this->SetY(10);
        $this->SetX(50);
        $this->writeHTMLCell(110, 0, '', '', $paragraph1, 0, 1, 0, true, 'C', true);

        $paragraph2 = '<p>PHASE-1 MODEL TOWN</p>';
        $this->SetY(15);
        $this->SetX(50);
        $this->writeHTMLCell(110, 0, '', '', $paragraph2, 0, 1, 0, true, 'C', true);

        $paragraph3 = '<p>Ph: 9463333165 , Pin Code : 151001</p>';
        $this->SetY(23);
        $this->SetX(50);
        $this->writeHTMLCell(110, 0, '', '', $paragraph3, 0, 1, 0, true, 'C', true);

        $paragraph4 = '<p>Cell : 9463333165 , GST IN: 03AABCR2871C1ZV</p>';
        $this->SetY(28);
        $this->SetX(50);
        $this->writeHTMLCell(110, 0, '', '', $paragraph4, 0, 1, 0, true, 'C', true);


       //  // Page number
        $pageNumber = '<h5>Page ' . $this->getAliasNumPage() . ' of ' . $this->getAliasNbPages() . '</h5>';
        $this->SetY(5);
        $this->SetX(150);
        $this->writeHTMLCell(60, 0, '', '', $pageNumber, 0, 0, 0, true, 'R', true);

       // $this->SetLineStyle( array( 'width' => 0.40, 'color' => array(0, 0, 0)));

        // page border around the page  
       $this->Line(1.5, 1.5, $this->getPageWidth()-1.5, 1.5); 
       $this->Line($this->getPageWidth()-1.5, 1.5, $this->getPageWidth()-1.5,  $this->getPageHeight()-1.5);
       $this->Line(1.5, $this->getPageHeight()-1.5, $this->getPageWidth()-1.5, $this->getPageHeight()-1.5);
       $this->Line(1.5, 1.5, 1.5, $this->getPageHeight()-1.5);

        $html = '<hr>';
        $this->SetY(34);
        $this->SetX(50);
        $this->writeHTML($html, true, false, true, false, '');
    }


    // Page footer
    public function Footer() {
        $html = '<hr>';
        $this->SetY(-72);
        $this->SetX(50);
        $this->writeHTML($html, true, false, true, false, '');

         $footerContent1 = '
            <div>
                <span style="margin: 0;font-weight: bold;">Terms & Conditions</span><br>
                <span border: 1px solid black; >1. To be paid in full by Demand Draft Payable at Attur, / RTGS / NEFT /IM 2. Interest will be charged @ 24% P.A. if payment is not made as per term. 3. This</span> <br>
                <span>Sales is subject to Attur jurisdiction only. 4. Our responsibility ceases when goods have been delivered to the customer or carriers and no claims for damage or</span><br>
                <span>shortage can be accepted later.5.Please mention distributor code alloted to you in all DDs and transactions.6.Please return the copy of invoice after affixing</span><br>
                <span>your seal and sign.</span>
            </div>
        ';
        $this->SetY(-71);
        $this->SetX(0.5);  
        $this->writeHTMLCell(200, 0, '', '', $footerContent1, 0, 1, 0, true, 'L', true);

        $html = '<hr>';
        $this->SetY(-53);
        $this->SetX(50);
        $this->writeHTML($html, true, false, true, false, '');

        $footerContentD1 = '<p class="text-end" style="margin-bottom: 50px; text-align: right;">For Rasi Seeds (P) Ltd.</p>';
        $this->SetY(-51);
        $this->SetX(10);  
        $this->writeHTMLCell(190, 0, '', '', $footerContentD1, 0, 1, 0, true, 'R', true);

        $footerContentC1 = '<p class="text-end" style="text-align: right;">Authorized Signatory</p>';
        $this->SetY(-38);
        $this->SetX(10);  
        $this->writeHTMLCell(190, 0, '', '', $footerContentC1, 0, 1, 0, true, 'R', true);

        $html = '<hr>';
        $this->SetY(-34);
        $this->SetX(50);
        $this->writeHTML($html, true, false, true, false, '');

        $footerContentA1 = '<p style="margin: 0;">This is to certify that we have received __________ Nos. of C/B in good condition as per D.C on Dated _________</p>';
        $this->SetY(-33);
        $this->SetX(10);  
        $this->writeHTMLCell(34, 0, '', '', $footerContentA1, 0, 1, 0, true, 'L', true);

        $footerContentA2One = '<p class="margin-bottom-only">Registered Office:</p>';
        $this->SetY(-33);
        $this->SetX(70);  
        $this->writeHTMLCell(80, 0, '', '', $footerContentA2One, 0, 1, 0, true, 'C', true);

        $footerContentA2Two = '<p class="margin-bottom-only">Rasi Seeds (P) Ltd.,</p>';
        $this->SetY(-29);
        $this->SetX(70);  
        $this->writeHTMLCell(80, 0, '', '', $footerContentA2Two, 0, 1, 0, true, 'C', true);

        $footerContentA2Three = '<p class="margin-bottom-only">Rasi Enclave, Green Fields, 737 C Puliyakulam Road, Coimbatore-641045</p>';
        $this->SetY(-25);
        $this->SetX(35);  
        $this->writeHTMLCell(150, 0, '', '', $footerContentA2Three, 0, 1, 0, true, 'C', true);

        $footerContentA2Four = '<p class="margin-bottom-only">CIN No: U01112TZ1986PTC001864 PAN No: AABCR2871C</p>';
        $this->SetY(-21);
        $this->SetX(70);  
        $this->writeHTMLCell(80, 0, '', '', $footerContentA2Four, 0, 1, 0, true, 'C', true);

        $html = '<div style="border-bottom:1px solid black;"></div>';
        $this->SetY(-14);
        $this->SetX(50);
        $this->writeHTML($html, true, false, true, false, '');

        $footerContentA1One = '<h3 style="font-style: italic;">Breeding For Excellence ®</h3>';
        $this->SetY(-9);
        $this->SetX(10);  
        $this->writeHTMLCell(190, 0, '', '', $footerContentA1One, 0, 1, 0, true, 'C', true);
    }
}

// Instantiate the custom class
$pdf = new CustomPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// Set document information
$pdf->setCreator(PDF_CREATOR);
$pdf->setAuthor('Owen Leibman');
$pdf->setTitle('TCPDF Example');
$pdf->setSubject('TCPDF Tutorial');
$pdf->setKeywords('TCPDF, PDF, example, test, guide');

// Set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// Set default monospaced font
$pdf->setDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// Set margins
$pdf->setMargins(2, 0, 2);
$pdf->setHeaderMargin(20);
$pdf->setFooterMargin(PDF_MARGIN_FOOTER);

// Set auto page breaks
$pdf->setAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// Set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// Set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
    require_once(dirname(__FILE__).'/lang/eng.php');
    $pdf->setLanguageArray($l);
}
// set font
$pdf->SetFont('helvetica', '', 8);

foreach($invoice_nos as $invoice_nos) {
// Add a page
$pdf->AddPage();

$credit_note = '<h2 class="text-center" style="border-right: 1px solid black;margin: 0;padding: 7px;">CREDIT NOTE</h2>';

    $pdf->SetY(34.5);
    $pdf->SetX(15);
    $pdf->writeHTMLCell(90, 0, '', '', $credit_note, 0, 1, 0, true, 'C', true);

$original_recp = '<h2 class="text-center" style="margin: 0;padding: 7px;">Original For recepient</h2>';
    $pdf->SetY(34.5);
    $pdf->SetX(110);
    $pdf->writeHTMLCell(90, 0, '', '', $original_recp, 0, 1, 0, true, 'C', true);

    $html = '<hr>';
    $pdf->SetY(40);
    $pdf->SetX(50);
    $pdf->writeHTML($html, true, false, true, false, '');

$userQuery = "SELECT Customer_No FROM Sales_Placement_Invoice_Details WHERE Invoice_No IN (SELECT * FROM SPLIT_STRING('".$invoice_nos."', ','))";
$stmtuser = sqlsrv_query($conn, $userQuery);

if ($stmtuser === false) {
    die(print_r(sqlsrv_errors(), true));
}

// Fetch the Customer value
$customer = null;
if (sqlsrv_fetch($stmtuser)) {
    $customer = sqlsrv_get_field($stmtuser, 0);
}

$address = "";
$state = "";
$customer_name = "";
$gst_no = "";
$zone_code = "";
$customer_mail_id = ''; 

if ($customer) {
    // SQL query to get address and state from SD_cus_master
    $sdQuery = "SELECT Address, State, Customer_Name, GST_No, Customer, City, Zone_Code, Email_ID FROM SD_cus_master WHERE Customer = '".$customer."'";
    $stmtsd = sqlsrv_query($conn, $sdQuery);

    if ($stmtsd === false) {
        die(print_r(sqlsrv_errors(), true));
    }

    // Fetch the address and state
    if (sqlsrv_fetch($stmtsd)) {
        $address = sqlsrv_get_field($stmtsd, 0);
        $state = sqlsrv_get_field($stmtsd, 1);
        $customer_name = sqlsrv_get_field($stmtsd, 2);
        $gst_no = sqlsrv_get_field($stmtsd, 3);
        $cust_account = sqlsrv_get_field($stmtsd, 4);
        $city = sqlsrv_get_field($stmtsd, 5);
        $zone_code = sqlsrv_get_field($stmtsd, 6);
        $customer_mail_id = sqlsrv_get_field($stmtsd, 7);
    }

    sqlsrv_free_stmt($stmtsd);
}


$credit_note_table ='
        <table style="font-weight: bold;font-size: 10px;border-right: 1px solid black;">
            <tr>
                <th class="border-none" style="line-height: 20px;">Credit Note No</th>
                <td class="border-none" style="line-height: 20px;">:</td>
                <td class="border-none" style="line-height: 20px;">'. $invoice_nos .'</td>
            </tr>
            <tr>
                <th class="border-none"  style="line-height: 20px;">Credit Note Date</th>
                <td class="border-none" style="line-height: 20px;">:</td>
                <td class="border-none" style="line-height: 20px;">'.date("d.m.Y").'</td>
            </tr>
            <tr>
                <th class="border-none"  style="line-height: 20px;">State</th>
                <td class="border-none" style="line-height: 20px;">:</td>
                <td class="border-none" style="line-height: 20px;">'.$state.'</td>
            </tr>
            <tr>
                <th class="border-none"  style="line-height: 20px;">State Code</th>
                <td class="border-none" style="line-height: 20px;">:</td>
                <td class="border-none" style="line-height: 20px;">'.$state.'</td>
            </tr>
        </table>';


    $pdf->SetY(40);
    $pdf->SetX(3);
    $pdf->writeHTMLCell(102.1, 0, '', '', $credit_note_table, 0, 1, 0, true, 'L', true);

$original_recp_table = '
    <table  style="font-weight: bold;font-size: 10px;">
        <tr>
            <th class="border-none" style="width: 50%;line-height: 20px;">Corresponding Document</th>
            <td class="border-none" style="line-height: 20px;">:</td>
            <td class="border-none" style="line-height: 20px;">BILL OF SUPPLY</td>
        </tr>
        <tr>
            <th class="border-none" style="line-height: 20px;">Document No</th>
            <td class="border-none" style="line-height: 20px;">:</td>
            <td class="border-none" style="line-height: 20px;">IPT Return Order</td>
        </tr>
        <tr>
            <th class="border-none" style="line-height: 20px;">Document Date</th>
            <td class="border-none" style="line-height: 20px;">:</td>
            <td class="border-none" style="line-height: 20px;">-</td>
        </tr>
        <tr>
            <th  style="line-height: 20px;"></th>
        </tr>
    </table>';

    $pdf->SetY(40);
    $pdf->SetX(105);
    $pdf->writeHTMLCell(85, 0, '', '', $original_recp_table, 0, 1, 0, true, 'L', true);


    $html = '<hr>';
    $pdf->SetY(58.6);
    $pdf->SetX(50);
    $pdf->writeHTML($html, true, false, true, false, '');

$detail_title = '<h2>Details of Receiver / Billed To</h2>';

    $pdf->SetY(59);
    $pdf->SetX(60);
    $pdf->writeHTMLCell(99, 0, '', '', $detail_title, 0, 1, 0, true, 'C', true);

    $html = '<hr>';
    $pdf->SetY(65);
    $pdf->SetX(50);
    $pdf->writeHTML($html, true, false, true, false, '');

$detail_table_one ='
        <table style="font-weight: bold;font-size: 10px;border-right: 1px solid black;">
            <tr>
                <th class="border-none" style="width: 30%;line-height: 20px;">Cust Account</th>
                <td class="border-none" style="width: 5%;line-height: 20px;">:</td>
                <td class="border-none" style="width: 75%;line-height: 20px;">'.$cust_account.'</td>
            </tr>
            <tr>
                <th class="border-none" style="width: 30%;line-height: 20px;">Address</th>
                <td class="border-none" style="width: 5%;line-height: 20px;">:</td>
                <td class="border-none" style="width: 75%;line-height: 20px;margin: 30px;">'.$customer_name.'</td>
            </tr>
            <tr>
                <th style="line-height: 20px;"></th>
                <td style="line-height: 20px;"></td>
                <td style="line-height: 20px;">'.$city.'</td>
            </tr>
             <tr>
                <th  style="line-height: 20px;height:26px;"></th>
                <td style="line-height: 20px;"></td>
                <td style="line-height: 20px;">'.$state.'</td>
            </tr>
        </table>';


    $pdf->SetY(65.3);
    $pdf->SetX(3);
    $pdf->writeHTMLCell(93, 0, '', '', $detail_table_one, 0, 1, 0, true, 'L', true);

$detail_table_two = '
    <table  style="font-weight: bold;font-size: 10px;">
        <tr>
            <th class="border-none" style="width: 20%;line-height: 20px;">Cust Name</th>
            <td class="border-none" style="width: 5%;line-height: 20px;">:</td>
            <td class="border-none" style="width: 75%;line-height: 20px;">'.$customer_name.'</td>
        </tr>
        <tr>
            <th class="border-none" style="line-height: 20px;">State</th>
            <td class="border-none" style="line-height: 20px;">:</td>
            <td class="border-none" style="line-height: 20px;">'.$state.'</td>
        </tr>
        <tr>
            <th class="border-none" style="line-height: 20px;">State Code</th>
            <td class="border-none" style="line-height: 20px;">:</td>
            <td class="border-none" style="line-height: 20px;">'.$state.'</td>
        </tr>
        <tr>
            <th style="line-height: 20px;height:26px;">GSTIN</th>
            <td style="line-height: 20px;">:</td>
            <td style="line-height: 20px;">'. $gst_no .'</td>
        </tr>
    </table>';

    $pdf->SetY(65.3);
    $pdf->SetX(105);
    $pdf->writeHTMLCell(99, 0, '', '', $detail_table_two, 0, 1, 0, true, 'L', true);

    $html = '<hr>';
    $pdf->SetY(85.5);
    $pdf->SetX(50);
    $pdf->writeHTML($html, true, false, true, false, '');

$query = "SELECT 
        Item_Code,
        Lot_NO,
        Product,
        LR_Date,
        Sales_Price,
        Discount_Percent,
        Discount_Amount,
        QtyInSalesUnit,
        Net_Amount
        FROM Sales_Placement_Invoice_Details 
        WHERE Invoice_No IN (SELECT * FROM SPLIT_STRING('".$invoice_nos."', ',')) AND  QtyInSalesUnit < 0 AND Customer_No = '".$cust_account."'";

$stmt = sqlsrv_query($conn, $query);

if ($stmt === false) {
    die(print_r(sqlsrv_errors(), true)); // Print SQL errors for debugging
}

$data = [];
while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
    $data[] = $row;
}

$tbodyContent = '';
$totalNetAmount = 0;
$totalQtySalesUnit = 0;
$totalDiscountAmount = 0;
$sNo = 1;
foreach ($data as $row) {

    $netAmount = abs($row['Net_Amount']);
    $qtyInSalesUnit = abs($row['QtyInSalesUnit']);
    
    $totalNetAmount += $netAmount;
    $totalQtySalesUnit += $qtyInSalesUnit;
    $totalDiscountAmount += $row['Discount_Amount'];

    $tbodyContent .= '<tr>
                        <td class="fw-size-small" style="line-height: 18px;white-space: nowrap;">' . $sNo++ . '</td>
                        <td class="fw-size-small" style="line-height: 18px;white-space: nowrap;">' . htmlspecialchars($row['Product'] . "," . $row['Item_Code']) . '</td>
                        <td class="fw-size-small" style="line-height: 18px;white-space: nowrap;">' . htmlspecialchars($row['Lot_NO']) . '</td>
                        <td class="fw-size-small" style="line-height: 18px;">' . htmlspecialchars($row['LR_Date']) . '</td>
                        <td class="fw-size-small" style="line-height: 18px;"> - </td>
                        <td class="fw-size-small" style="line-height: 18px;"> '. htmlspecialchars((int)$qtyInSalesUnit) .' </td>
                        <td class="fw-size-small" style="line-height: 18px;">' . htmlspecialchars(number_format($row['Sales_Price'], 2)) . '</td>
                        <td class="fw-size-small" style="line-height: 18px;">' . htmlspecialchars(number_format($netAmount, 2)) . '</td>
                        <td class="fw-size-small" style="line-height: 18px;">' . htmlspecialchars($row['Discount_Percent']) . '</td>
                        <td class="fw-size-small" style="line-height: 18px;">' . htmlspecialchars($row['Discount_Amount']) . '</td>
                        <td class="fw-size-small" style="line-height: 18px;">' . htmlspecialchars(number_format($netAmount, 2)) . '</td>
                    </tr>';
}

$tableData = '
            <table style="font-size: 8px;">
                <tr style="font-weight: bold;">
                    <th class="fw-size-small" style="border-bottom: 1px solid black;line-height: 10px;width: 3%;height:28px;">S.no</th>
                    <th class="fw-size-small" style="border-bottom: 1px solid black;line-height: 10px;width: 30%;">Crop & Variety</th>
                    <th class="fw-size-small" style="border-bottom: 1px solid black;line-height: 10px;width: 13%;">Lot No</th>
                    <th class="fw-size-small" style="border-bottom: 1px solid black;line-height: 10px;">Expiry Date</th>
                    <th class="fw-size-small" style="border-bottom: 1px solid black;line-height: 10px;width: 6%;">No of Bags</th>
                    <th class="fw-size-small" style="border-bottom: 1px solid black;line-height: 10px;width: 7%;">Qty-In Pkts</th>
                    <th class="fw-size-small" style="border-bottom: 1px solid black;line-height: 10px;width: 7%;">Rate (Rs.P)</th>
                    <th class="fw-size-small" style="border-bottom: 1px solid black;line-height: 10px;width: 12%;">Gross Amount (Rs.P)</th>
                    <th class="fw-size-small" style="border-bottom: 1px solid black;line-height: 10px;width: 6%;">Disc %</th>
                    <th class="fw-size-small" style="border-bottom: 1px solid black;line-height: 10px;">Discount (Rs.P)</th>
                    <th class="fw-size-small" style="border-bottom: 1px solid black;line-height: 10px;width: 11%;">Taxable Value (Rs.P)</th>
                </tr>
                     ' . $tbodyContent .' 
                <tr>
                    <th style="font-weight: bold;border-top: 1px solid black;"></th>
                    <th style="font-weight: bold;border-top: 1px solid black;text-align: right;line-height: 20px;font-size: 8px;">Total:</th>
                    <th style="font-weight: bold;border-top: 1px solid black;"></th>
                    <th style="font-weight: bold;border-top: 1px solid black;"></th>
                    <th style="font-weight: bold;border-top: 1px solid black;"></th>
                    <th style="font-weight: bold;border-top: 1px solid black;line-height: 20px;font-size: 8px;">'.(int)$totalQtySalesUnit.'</th>
                    <th style="font-weight: bold;border-top: 1px solid black;"></th>
                    <th style="font-weight: bold;border-top: 1px solid black;line-height: 20px;font-size: 8px;">'.number_format($totalNetAmount, 2).'</th>
                    <th style="font-weight: bold;border-top: 1px solid black;"></th>
                    <th style="font-weight: bold;border-top: 1px solid black;line-height: 20px;font-size: 8px;">'.number_format($totalDiscountAmount, 2).'</th>
                    <th style="font-weight: bold;border-top: 1px solid black;line-height: 20px;font-size: 8px;height:30px;">'.number_format($totalNetAmount, 2).'</th>
                </tr>
                <tr>
                    <th style="font-weight: bold;line-height: 20px;font-size: 8px;height:30px;" colspan="8">HSN Code :12092990 SGST@0.00%:0.00 ,CGST@0.00%:0.00 , IGST@0.00%:0.00 ,TCS@0.100%:0.00
                    </th>
                </tr>
                <tr>
                    <th colspan="8" style="text-align: right;font-weight: bold;font-size: 8px;"></th>

                    <th colspan="2" style="text-align: left;font-weight: bold;font-size: 8px;">Net Invoice Amount :</th>
                    <th style="text-align: left;font-weight: bold;font-size: 8px;">'.number_format($totalNetAmount, 2).'</th>

                </tr>
            </table>';

    $pdf->SetY(87);
    $pdf->SetX(3);
    $pdf->writeHTMLCell(180, 0, '', '', $tableData, 0, 1, 0, true, 'L', true);

// $pdf->writeHTML($tableData, true, false, true, false, '');

$pdf->SetFont('helvetica', '', 8);
}
// Close and output PDF document
$pdf->Output('Credit Note.pdf', 'I');
$attachment = $pdf->Output('', 'S');
// echo json_encode(base64_encode($a));exit;
$template = "<div>
    <p>Dear ".$customer_name.",</p>
</div>
<div>
    <p>Please find the attachment of your credit note</p>
</div>
<br>
<p>Best regards,<p>
<p style='font-weight:bold;'>Rasi Seeds</p>
";
$filename = "Credit Note.pdf";
$mail->Send_Mail_Details('Credit note',$attachment,$filename,$template);

?>
