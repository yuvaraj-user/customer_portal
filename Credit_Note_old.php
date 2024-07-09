<?php
ob_start();
include_once ('top_head.php');

include_once ('header.php');

//Customer region get and set in session
$region_sql = "SELECT * FROM SD_CUS_MASTER WHERE PAN_No = '" . $_SESSION['EmpID'] . "'";
$region_sql_exec = sqlsrv_query($conn, $region_sql);
$customer_region_id = sqlsrv_fetch_array($region_sql_exec, SQLSRV_FETCH_ASSOC);


$Cust_no = $customer_region_id['Customer'];

// include('../auto_load.php');
if (isset($_POST["filter"])) {

    // Set memory limit to unlimited (-1)
    ini_set('memory_limit', '-1');

    function add_commas_every_ten_digits($number)
    {
        // Remove any non-digit characters from the input
        $number_str = preg_replace('/\D/', '', (string) $number);

        // Calculate the length of the cleaned string
        $length = strlen($number_str);

        // Initialize an empty result string
        $result = '';

        // Iterate through the string in chunks of 10 from right to left
        for ($i = $length; $i > 0; $i -= 10) {
            // Take a substring of up to 10 characters
            $start = max(0, $i - 10);
            $chunk = substr($number_str, $start, $i - $start);

            // Prepend the chunk to the result, with a comma if result is not empty
            $result = ($result === '') ? $chunk : $chunk . ',' . $result;
        }

        return $result;
    }


    $invoice = implode(',', $_POST['invoice']);
    $number = $invoice;
    $result = add_commas_every_ten_digits($number);

    $From = $_POST['from_date'];
    $To = $_POST['to_date'];


    $sql = sqlsrv_query($conn, "SELECT Invoice_No From Sales_Placement_Invoice_Details WHERE Customer_No ='$Cust_no' AND QtyInSalesUnit > 0 AND 
    Invoice_No IN (SELECT * FROM SPLIT_STRING('$result',',')) 
    GROUP BY Invoice_No");

    if ($sql === false) {
        // Handle query error
        die(print_r(sqlsrv_errors(), true));
    }

    $invo = array();
    while ($row = sqlsrv_fetch_array($sql, SQLSRV_FETCH_ASSOC)) {
        $invo[] = $row['Invoice_No'];
    }

    // print_r($invo);exit;
    $invo_no = implode(',', $invo);

    $query = sqlsrv_query($conn, "SELECT Invoice_No, Invoice_Date FROM Sales_Placement_Invoice_Details WHERE Customer_No ='$Cust_no' 
	AND Invoice_Date between '$From' AND '$To' AND QtyInSalesUnit > 0
     GROUP BY Invoice_No, Invoice_Date");

    if ($query === false) {
        // Handle query error
        die(print_r(sqlsrv_errors(), true));
    }

    $idss = array();
    while ($ids = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC)) {
        $idss[] = $ids['Invoice_No'];
    }


    $implode = implode(',', $idss);
    $array_mearged = $invo_no ? $invo_no : $implode;
    $Final = $array_mearged;

    // Output the result for testing
    // echo $results; // Example output: 9620300654,9620300657


    if ($array_mearged) {
        // Redirect to the invoice page

        header("Location: invoice_history_copy.php?I_NO=" . $Final);
        // exit(); // Ensure the script stops executing after the redirect

    } else {

        // Clear any output buffer content before displaying the alert
        ob_end_clean();

        // Output the alert message
        echo '<script type="text/javascript">';
        echo 'alert("Customer number and Invoice No Not Match. Cannot proceed.");';
        echo 'window.history.back();'; // This will navigate the user back to the previous page
        echo '</script>';
    }
    ob_end_flush();

}
if (!isset($_GET['I_NO'])) {
    $Invoice_No = "";
} else {
    $Invoice_No = $_GET['I_NO'];
}

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
    }

    */ .form-holder {
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


    .form-content label,
    .was-validated .form-check-input:invalid~.form-check-label,
    .was-validated .form-check-input:valid~.form-check-label {
        color: #fff;
    }

    .form-content input[type=date],
    .form-content select {
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


    .btn-primary {
        background-color: #6C757D;
        outline: none;
        border: 0px;
        box-shadow: none;
    }

    .btn-primary:hover,
    .btn-primary:focus,
    .btn-primary:active {
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

    .check-svg {
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

    .btn_sub:hover .check-svg {
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
        top: 30vh !important;
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

    @media only screen and (max-width: 1200px) {
        .invoice_head_bg {
            padding: 40px;
        }
    }


    @media only screen and (max-width: 768px) {
        .btn_filter  {
            padding: 8px !important;
        }
    }

</style>
<link rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/simplePagination.js/1.6/jquery.simplePagination.css">

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

    .checkbox-wrapper-30 .checkbox>* {
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
/*        --newBrdrClr: var(--brdr-actv);*/
        --newBrdrClr: #0d6efd;
        transition-delay: calc(var(--dur) /1.3);
    }

    .checkbox-wrapper-30 .checkbox input:checked+.check-svg {
        --dashArray: 16 93;
        --dashOffset: 109;
    }

    .checkbox-wrapper-30 .checkbox .check-svg {
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

    .checkbox-wrapper-30 .checkbox .check-svg,
    .checkbox-wrapper-30 .checkbox input {
        display: block;
        height: 77%;
        width: 100%;
        margin-top: 14px;
    }

    .btn_div {
        padding: 20px;
        margin-left: 50px;
    }

    #filterOffcanvasLabel {
        font-size: 15px;
        font-weight: bold;
        color: #fff;
        letter-spacing: 1px;
        text-transform: uppercase;
        align-items: center;
        margin-left: 24px;
        /*padding-left: 15px;
    background-color: #fff;
    border-radius: 5px;
    padding-right: 15px;
    
    margin-top: 5px;*/
    }

    .form-check-label {
        font-size: 13px;
        font-weight: bold;
        /*	 color:#fff; */
        /*	 letter-spacing:1px;*/
    }

    .offcanvas-header {
        background-color: blue !important;

    }

    .cls_btn {
        border: 3px solid #ccc;
        border-radius: 20px;
        font-size: 12px;
        background-color: #fff !important;
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
        border-radius: 1px;
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

    input[type=text] {
        width: 72%;
        padding: 5px 20px;
        text-align: left;
        border: 1px solid #ccc;
        border-radius: 1px;
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

    /* body{
    background: #F4F7FD;
    margin-top:20px;
} */

    .card-margin {
        margin-bottom: 1.875rem;
        border-left: 5px solid red !important;
    }

    .card {
        border: 0;
        box-shadow: 0px 0px 10px 0px rgba(82, 63, 105, 0.1);
        -webkit-box-shadow: 0px 0px 10px 0px rgba(82, 63, 105, 0.1);
        -moz-box-shadow: 0px 0px 10px 0px rgba(82, 63, 105, 0.1);
        -ms-box-shadow: 0px 0px 10px 0px rgba(82, 63, 105, 0.1);
    }

    .card {
        position: relative;
        display: flex;
        flex-direction: column;
        min-width: 0;
        word-wrap: break-word;
        background-color: #ffffff;
        background-clip: border-box;
        border: 1px solid #e6e4e9;
        border-radius: 8px;
    }

    .card .card-header.no-border {
        border: 0;
    }

    .card .card-header {
        background: none;
        padding: 0 0.9375rem;
        font-weight: 500;
        display: flex;
        align-items: center;
        min-height: 50px;
    }

    .card-header:first-child {
        border-radius: calc(8px - 1px) calc(8px - 1px) 0 0;
    }

    .widget-49 .widget-49-title-wrapper {
        display: flex;
        align-items: center;
    }

    .widget-49 .widget-49-title-wrapper .widget-49-date-primary {
        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: column;
        background-color: #edf1fc;
        width: 4rem;
        height: 4rem;
        border-radius: 50%;
    }

    .widget-49 .widget-49-title-wrapper .widget-49-date-primary .widget-49-date-day {
        color: #4e73e5;
        font-weight: 500;
        font-size: 1.5rem;
        line-height: 1;
    }

    .widget-49 .widget-49-title-wrapper .widget-49-date-primary .widget-49-date-month {
        color: #4e73e5;
        line-height: 1;
        font-size: 1rem;
        text-transform: uppercase;
    }

    .widget-49 .widget-49-title-wrapper .widget-49-date-secondary {
        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: column;
        background-color: #fcfcfd;
        width: 4rem;
        height: 4rem;
        border-radius: 50%;
    }

    .widget-49 .widget-49-title-wrapper .widget-49-date-secondary .widget-49-date-day {
        color: #dde1e9;
        font-weight: 500;
        font-size: 1.5rem;
        line-height: 1;
    }

    .widget-49 .widget-49-title-wrapper .widget-49-date-secondary .widget-49-date-month {
        color: #dde1e9;
        line-height: 1;
        font-size: 1rem;
        text-transform: uppercase;
    }

    .widget-49 .widget-49-title-wrapper .widget-49-date-success {
        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: column;
        background-color: #e8faf8;
        width: 4rem;
        height: 4rem;
        border-radius: 50%;
    }

    .widget-49 .widget-49-title-wrapper .widget-49-date-success .widget-49-date-day {
        color: #17d1bd;
        font-weight: 500;
        font-size: 1.5rem;
        line-height: 1;
    }

    .widget-49 .widget-49-title-wrapper .widget-49-date-success .widget-49-date-month {
        color: #17d1bd;
        line-height: 1;
        font-size: 1rem;
        text-transform: uppercase;
    }

    .widget-49 .widget-49-title-wrapper .widget-49-date-info {
        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: column;
        background-color: #ebf7ff;
        width: 4rem;
        height: 4rem;
        border-radius: 50%;
    }

    .widget-49 .widget-49-title-wrapper .widget-49-date-info .widget-49-date-day {
        color: #36afff;
        font-weight: 500;
        font-size: 1.5rem;
        line-height: 1;
    }

    .widget-49 .widget-49-title-wrapper .widget-49-date-info .widget-49-date-month {
        color: #36afff;
        line-height: 1;
        font-size: 1rem;
        text-transform: uppercase;
    }

    .widget-49 .widget-49-title-wrapper .widget-49-date-warning {
        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: column;
        background-color: floralwhite;
        width: 4rem;
        height: 4rem;
        border-radius: 50%;
    }

    .widget-49 .widget-49-title-wrapper .widget-49-date-warning .widget-49-date-day {
        color: #FFC868;
        font-weight: 500;
        font-size: 1.5rem;
        line-height: 1;
    }

    .widget-49 .widget-49-title-wrapper .widget-49-date-warning .widget-49-date-month {
        color: #FFC868;
        line-height: 1;
        font-size: 1rem;
        text-transform: uppercase;
    }

    .widget-49 .widget-49-title-wrapper .widget-49-date-danger {
        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: column;
        background-color: #feeeef;
        width: 4rem;
        height: 4rem;
        border-radius: 50%;
    }

    .widget-49 .widget-49-title-wrapper .widget-49-date-danger .widget-49-date-day {
        color: #F95062;
        font-weight: 500;
        font-size: 1.5rem;
        line-height: 1;
    }

    .widget-49 .widget-49-title-wrapper .widget-49-date-danger .widget-49-date-month {
        color: #F95062;
        line-height: 1;
        font-size: 1rem;
        text-transform: uppercase;
    }

    .widget-49 .widget-49-title-wrapper .widget-49-date-light {
        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: column;
        background-color: #fefeff;
        width: 4rem;
        height: 4rem;
        border-radius: 50%;
    }

    .widget-49 .widget-49-title-wrapper .widget-49-date-light .widget-49-date-day {
        color: #f7f9fa;
        font-weight: 500;
        font-size: 1.5rem;
        line-height: 1;
    }

    .widget-49 .widget-49-title-wrapper .widget-49-date-light .widget-49-date-month {
        color: #f7f9fa;
        line-height: 1;
        font-size: 1rem;
        text-transform: uppercase;
    }

    .widget-49 .widget-49-title-wrapper .widget-49-date-dark {
        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: column;
        background-color: #ebedee;
        width: 4rem;
        height: 4rem;
        border-radius: 50%;
    }

    .widget-49 .widget-49-title-wrapper .widget-49-date-dark .widget-49-date-day {
        color: #394856;
        font-weight: 500;
        font-size: 1.5rem;
        line-height: 1;
    }

    .widget-49 .widget-49-title-wrapper .widget-49-date-dark .widget-49-date-month {
        color: #394856;
        line-height: 1;
        font-size: 1rem;
        text-transform: uppercase;
    }

    .widget-49 .widget-49-title-wrapper .widget-49-date-base {
        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: column;
        background-color: #f0fafb;
        width: 4rem;
        height: 4rem;
        border-radius: 50%;
    }

    .widget-49 .widget-49-title-wrapper .widget-49-date-base .widget-49-date-day {
        color: #68CBD7;
        font-weight: 500;
        font-size: 1.5rem;
        line-height: 1;
    }

    .widget-49 .widget-49-title-wrapper .widget-49-date-base .widget-49-date-month {
        color: #68CBD7;
        line-height: 1;
        font-size: 1rem;
        text-transform: uppercase;
    }

    .widget-49 .widget-49-title-wrapper .widget-49-meeting-info {
        display: flex;
        flex-direction: column;
        margin-left: 1rem;
    }

    .widget-49 .widget-49-title-wrapper .widget-49-meeting-info .widget-49-pro-title {
        /* color: #3c4142;
  font-size: 14px; */
    }

    .widget-49 .widget-49-title-wrapper .widget-49-meeting-info .widget-49-meeting-time {
        color: #B1BAC5;
        font-size: 13px;
    }

    .widget-49 .widget-49-meeting-points {
        font-weight: 400;
        font-size: 13px;
        margin-top: .5rem;
    }

    .widget-49 .widget-49-meeting-points .widget-49-meeting-item {
        display: list-item;
        color: #727686;
    }

    .widget-49 .widget-49-meeting-points .widget-49-meeting-item span {
        margin-left: .5rem;
    }

    .widget-49 .widget-49-meeting-action {
        text-align: right;
    }

    .widget-49 .widget-49-meeting-action a {
        text-transform: uppercase;
    }

    /* .container {
    max-width: 600px;
    margin: 0 auto;
    padding: 20px;
  } */
    .item {
        padding: 10px;
        /* background-color: #f0f0f0; */
        margin-bottom: 5px;
    }

    .pagination1 {
        text-align: center;
        margin-top: 20px;
    }

    .pagination1 li {
        display: inline-block;
        margin-right: 5px;
        cursor: pointer;
        padding: 2px 10px;
        background-color: #007bff;
        color: white;
    }

    .pagination1 .active {
        background-color: #0056b3;
    }

    #invoice,#from_date,#to_date {
        color: black;
        font-weight: 400;
    }

    .single_download {
        color: green;
        font-weight: bold;
    }

    .single_download:hover {
        color: white !important;
    }

    .swal-icon img{
      width: 120px;
      height: 120px;
  }
</style>
<!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/simplePagination.js/1.6/jquery.simplePagination.min.js"></script>
<section class="invoice_head_bg">
</section>
<!-- <section class="bannr-section" style="background-image: url(https://via.placeholder.com/1920x490);">
        <div class="container">
            <div class="bannr-text">
                <h2>Our Service</h2>
                <ol class="breadcrumb">
                  <li class="breadcrumb-item">
                    <a href="index.html">Home</a>
                  </li>
                  <li class="breadcrumb-item active" aria-current="page">our Service</li>
                </ol>
            </div>
        </div>
    </section> -->
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
            <h4 class="site-head ms-auto me-auto">Credit Note</h4>
        </div>

        <div class="d-flex justify-content-between">
            <div class="checkbox-wrapper-30">
                <span class="checkbox">
                    <input type="checkbox" id="selectAll"/>
                    <svg class="check-svg">
                        <use xlink:href="#checkbox-30" class="checkbox"></use>
                    </svg>
                </span>&nbsp&nbspSelect All
            </div>
            <div class="filter-icon-container text-end" data-bs-toggle="offcanvas" data-bs-target="#filterOffcanvas">
                <button class="btn btn-primary btn_filter"><i class="fas fa-filter"></i> Filter</button>
            </div>
        </div>

        <!-- Filter Offcanvas -->
        <div class="offcanvas offcanvas-end offcanvas-full-height" tabindex="-1" id="filterOffcanvas"
            aria-labelledby="filterOffcanvasLabel">
            <div class="offcanvas-header">
                <h5 class="offcanvas-title" id="filterOffcanvasLabel">Select Range Types</h5>
                <button type="button" class="btn-close cls_btn filter-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body">
                <form method="POST">
                    <div class="form-check">
                        <div class="checkbox-wrapper-30">
                            <span class="checkbox">
                                <input type="checkbox"  class="filter_checkbox" value="cin" id="cin" />
                                <svg class="check-svg">
                                    <use xlink:href="#checkbox-30" class="checkbox"></use>
                                </svg>
                            </span>
                            <svg xmlns="http://www.w3.org/2000/svg" style="display:none">
                                <symbol id="checkbox-30" viewBox="0 0 22 22">
                                    <path fill="none" stroke="currentColor"
                                        d="M5.5,11.3L9,14.8L20.2,3.3l0,0c-0.5-1-1.5-1.8-2.7-1.8h-13c-1.7,0-3,1.3-3,3v13c0,1.7,1.3,3,3,3h13 c1.7,0,3-1.3,3-3v-13c0-0.4-0.1-0.8-0.3-1.2" />
                                </symbol>
                            </svg>

                            <label class="form-check-label" for="cin">
                                Custom Invoice No
                            </label>
                        </div>
                    </div>

                    <div class="col-md-12 invoice" style="display: none;">
                        <input type="text" class="form-control" multiple="multiple" name="invoice[]" id="invoice" >
                    </div>

                    <div class="form-check">
                        <div class="checkbox-wrapper-30">
                            <span class="checkbox">
                                <input type="checkbox" class="filter_checkbox" value="cdr" id="cdr" />
                                <svg class="check-svg">
                                    <use xlink:href="#checkbox-30" class="checkbox"></use>
                                </svg>
                            </span>
                            <svg xmlns="http://www.w3.org/2000/svg" style="display:none">
                                <symbol id="checkbox-30" viewBox="0 0 22 22">
                                    <path fill="none" stroke="currentColor"
                                        d="M5.5,11.3L9,14.8L20.2,3.3l0,0c-0.5-1-1.5-1.8-2.7-1.8h-13c-1.7,0-3,1.3-3,3v13c0,1.7,1.3,3,3,3h13 c1.7,0,3-1.3,3-3v-13c0-0.4-0.1-0.8-0.3-1.2" />
                                </symbol>
                            </svg>

                            <label class="form-check-label" for="cdr">
                                Custom Date Range
                            </label>
                        </div>
                    </div>

                    <div class="col-md-12 from_date" style="display: none;">
                        <input type="date" class="form-control" id="from_date" placeholder="From Date" name="from_date"
                            >
                    </div>

                    <div class="col-md-12 to_date" style="display: none;">
                        <input type="date" class="form-control" id="to_date" name="to_date" placeholder="To Date" >
                    </div>

                    <div class="btn_div">
                        <!-- <button type="button" class="btn btn-primary">Apply</button> -->

                        <button class="btn_apply" role="submit"  name="filter" id="applyFilters"><span class="text">Apply</span></button>
                    </div>
                </form>
            </div>
            <!-- <div class="offcanvas-footer">
                
            </div> -->
        </div>

        <div class="no_invoice" style="display:none;">
            <div class="empty-state">
                <!-- <i class="fas fa-box-open"></i> -->
                <!-- <i class="fa-solid fa-file-invoice"></i> -->
                <i class="fa-regular fa-file-lines"></i>
                <p>No credit invoices available.</p>
            </div>
        </div>
        <!-- <iframe src="" id="preview"></iframe> -->

        <form id="invoiceForm" style="display:none;">
            <!-- <input type="checkbox" id="selectAll"> Select All -->
<!--             <div class="checkbox-wrapper-30">
                <span class="checkbox">
                    <input type="checkbox" id="selectAll"/>
                    <svg class="check-svg">
                        <use xlink:href="#checkbox-30" class="checkbox"></use>
                    </svg>
                </span>&nbsp&nbspSelect All
            </div> -->
            <br>
<!--             <button type="button" class="btn btn-success" style="float: inline-end;font-size: 12px;"
            onclick="downloadSelectedInvoices()"><i class="fa-solid fa-cloud-arrow-down"></i> Bulk Download</button><br> -->
            <div class="text-end">
                <button type="button" class="btn btn-success btn-sm p-1 ms-auto me-auto" style="font-size: 12px;" onclick="downloadSelectedInvoices()"><i class="fa-solid fa-cloud-arrow-down"></i> Bulk Download</button>
            </div>

            <div class="container">
                <div class="row items-container">
                </div>
                <div id="pagination" class="pagination1 pb-5"></div>

            </div>
        </form>




    </div>
</section>
<?php include_once ('footer.php') ?>
<?php include_once ('bottom_script.php') ?>
<!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> -->

<script type="text/javascript">
        // Show loader or loading message if needed
        function showLoader() {
            $('.ajaxloader').show();
        }

        // Function to hide the loader
        function hideLoader() {
            $('.ajaxloader').hide();
        }

        $(document).ready(function () {
            request_data = { Action : 'get_credit_note_data',limit : 10 };
            get_credit_note(request_data);

        });

        function get_credit_note(data)
        {
            $.ajax({
                url: 'common_ajax.php',
                type: 'POST',
                data: data,
                dataType: 'json',
                success: function(response) {
                    var html = '';
                    var numItems = 0;
                    if(response.length > 0) {
                        for(i in response) {
                            numItems++;
                            html += `<div class="col-lg-4 item">
                            <div class="card card-margin">
                            <div class="card-header no-border">
                            <h5 class="card-title checkbox-wrapper-30">
                            <span class="checkbox">
                            <input type="checkbox" name="invoices"
                            value="${ response[i].Invoice_No }" />
                            <svg class="check-svg">
                            <use xlink:href="#checkbox-30" class="checkbox"></use>
                            </svg>
                            </span>&nbsp;&nbsp;${ response[i].Invoice_No }
                            </h5>
                            </div>
                            <div class="card-body pt-0">
                            <div class="widget-49">
                            <div class="widget-49-title-wrapper justify-content-between">
                            <div class="widget-49-meeting-info col-4">
                            <span class="widget-49-pro-title">Invoice Date</span>
                            <span
                            class="widget-49-meeting-time">${ response[i].Invoice_Date }</span>
                            </div>
                            <div class="widget-49-meeting-info col-3">
                            <span class="widget-49-pro-title">Qty In Kg</span>
                            <span
                            class="widget-49-meeting-time">${ response[i].invoice_QtyInKgs }</span>
                            </div>
                            </div>

                            <div class="widget-49-title-wrapper justify-content-between">
                            <div class="widget-49-meeting-info col-4">
                            <span class="widget-49-pro-title">No of Bags</span>
                            <span class="widget-49-meeting-time">${ response[i].no_of_bags }</span>
                            </div>
                            <div class="widget-49-meeting-info col-3">
                            <span class="widget-49-pro-title">Qty In Pkt</span>
                            <span
                            class="widget-49-meeting-time">${ response[i].invoice_QtyInPkts }</span>
                            </div>
                            </div>
                            <div class="widget-49-title-wrapper">
                            <div class="widget-49-meeting-info">
                            <span class="widget-49-pro-title">Total Amount</span>
                            <span class="widget-49-meeting-time">${ response[i].invoice_NetAmount }</span>
                            </div>
                            </div>
                            <div class="widget-49-meeting-action">
                            <a 
                            class="btn btn-flash-border-primary single_download" data-invoiceno="${ response[i].Invoice_No }"><i class="fa-solid fa-download"></i> Download</a>
                            </div>
                            </div>
                            </div>
                            </div>
                            </div>`;
                        }
                        $('.items-container').html(html);
                        $('#invoiceForm').show();
                        pagination();
                    } else {
                        $('.no_invoice').show();
                    }
                }
            });
        }


        function pagination() {
            var itemsPerPage = 6;
            var items = $(".items-container .item");
            var numItems = items.length;
            var totalPages = Math.ceil(numItems / itemsPerPage);

            items.hide().slice(0, itemsPerPage).show();

            $('#pagination').pagination({
                items: numItems,
                itemsOnPage: itemsPerPage,
                displayedPages: 3,
                edges: 1,
                prevText: '&laquo;',
                nextText: '&raquo;',
                onPageClick: function (pageNumber) {
                    var startIndex = (pageNumber - 1) * itemsPerPage;
                    var endIndex = startIndex + itemsPerPage;

                    items.hide().slice(startIndex, endIndex).show();
                }
            });
        }



        // Function to update Select All checkbox based on individual checkboxes
        function updateSelectAllCheckbox() {
            var $checkboxes = $('input[name="invoices"]');
            var $checkedCheckboxes = $('input[name="invoices"]:checked');

            // Update Select All checkbox based on currently visible checkboxes
            if ($checkedCheckboxes.length === $checkboxes.length) {
                $('#selectAll').prop('checked', true);
            } else {
                $('#selectAll').prop('checked', false);
            }
        }

        // Handle the Select All checkbox
        $('#selectAll').on('click',function () {
            var checked = this.checked;
            $('input[name="invoices"]:visible').each(function () {
                this.checked = checked;
            });
        });

        // Handle individual checkbox changes to update the Select All checkbox
        $(document).on('click', 'input[name="invoices"]', function () {
            updateSelectAllCheckbox();
        });

        // Update Select All checkbox when pagination changes
        $('#pagination').on('click', 'a', function () {
            updateSelectAllCheckbox();
        });


        $('.filter_checkbox').on('change', function () {
            $('.filter_checkbox').not(this).prop('checked', false);
            var type = $(".filter_checkbox:checked").val();
            
            $('.invoice').hide();                
            $('.from_date, .to_date').hide();
            if (type === 'cdr') {
                $('.invoice').hide();                
                $('.from_date, .to_date').show();
            } else if(type === 'cin') {
                $('.from_date, .to_date').hide();
                $('.invoice').show();                
            }
        });


        $(document).on('click', '#applyFilters', function (e) {
            e.preventDefault();
            var type = $(".filter_checkbox:checked").val();
            var today = new Date();
            var firstDayOfMonth = new Date(today.getFullYear(), today.getMonth(), 1);
            var lastDayOfMonth = new Date(today.getFullYear(), today.getMonth() + 1, 0);
            var threeMonthsAgo = new Date(today.getFullYear(), today.getMonth() - 2, 1);

            if (type === 'cin') {
                var invoice_nos = $('#invoice').val();
                request_data = { Action : 'get_credit_note_data',invoice_no : invoice_nos };
                get_credit_note(request_data);
            } else if (type === 'cdr') {
                var from_date = $('#from_date').val();
                var to_date   = $('#to_date').val();
                request_data = { Action : 'get_credit_note_data',from_date : from_date,to_date : to_date };
                get_credit_note(request_data);
            }

            $('.filter-close').trigger('click');
        });
        //END

        $(document).on('click','.single_download',function(){
            var invoice_no = $(this).data('invoiceno');
            downloadSelectedInvoices('single',invoice_no);
        });


        // BULK AND  SINGLE DOWNLOAD
        function downloadSelectedInvoices(type='multiple',invoice_no = '') {
            var invoiceNumber = [];
            if(type == 'multiple') {
                // Get selected checkboxes
                $('input[name="invoices"]:checked').each(function () {
                    invoiceNumber.push($(this).val());
                });
            } else if(type == 'single') {
                invoiceNumber.push(invoice_no);
            }

            // Send selected invoices to the server
            if (invoiceNumber.length > 0) {

                var xhr = new XMLHttpRequest();
                xhr.open("POST", "Credit_Note_Pdf.php", true);
                xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                showLoader();
                xhr.onreadystatechange = function () {
                    if (xhr.readyState === 4) {
                        hideLoader();
                        if (xhr.status === 200) {
                            // On success, create a blob from the response and trigger download
                            var blob = new Blob([xhr.response], { type: "application/pdf" });
                            var link = document.createElement('a');
                            link.href = window.URL.createObjectURL(blob);
                            link.download = "selected_invoices.pdf";
                            link.click();
                        } else {
                            console.error('Error in AJAX request:', xhr.statusText);
                            alert('Error downloading invoices. Please try again.');
                        }
                    }
                };

                xhr.responseType = 'blob'; // Ensure the response is treated as a binary blob
                xhr.send("invoices=" + encodeURIComponent(invoiceNumber.join(',')));
            } else {
                swal({
                    title: "Warning",
                    text: "Please select at least one credit invoice to download.",
                    icon: 'assets/img/rasi/warning.png',
                });
            }
        }



</script>
</body>