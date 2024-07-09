<?php
include '../auto_load.php';
include 'Credit_Note_Details.php'; 

$site_division = $_SESSION['selected_division']; 
$emp_id = $_SESSION['EmpID'];
$customer_no = $_SESSION['customer_no'];


$credit_note = new Credit_Note_Details($conn,$site_division,$emp_id);

if(isset($_POST['Action'])){

	if($_POST['Action'] == 'get_division_based_season') {
		$season_sql = "SELECT Sales_Org,Season_Code from Master_Season where Sales_Org = '".$site_division."' group by Sales_Org,Season_Code";
		$season_exec = sqlsrv_query($conn,$season_sql);
		$result = array();
		$i = 0;
		while ($row = sqlsrv_fetch_array($season_exec,SQLSRV_FETCH_ASSOC)) {
			$result[$i]['Season_Code'] = $row['Season_Code']; 
			$i++;
		}

		echo json_encode($result);exit;
	}


	if($_POST['Action'] == 'filter_history_of_invoice') {
		//and Master_Product_demo.Active_Status = '1'

		$invoice_sql = "SELECT invoice_details.Invoice_No,FORMAT(invoice_details.Invoice_Date,'dd-MM-yyyy') as Invoice_Date,invoice_details.Actual_Item_ID,ABS(invoice_details.Qty_In_Kgs) as invoice_QtyInKgs,ABS(invoice_details.QtyInSalesUnit) as invoice_QtyInPkts,ABS(invoice_details.Net_Amount) as invoice_NetAmount,Master_Product_demo.QtyInPkt as bag_of_packets,invoice_details.Item_Code from SD_CUS_MASTER 
		inner join Sales_Placement_Invoice_Details as invoice_details ON invoice_details.Customer_No = SD_CUS_MASTER.Customer and invoice_details.Sales_Organisation = '".$site_division."'
		left join Master_Product_demo ON Master_Product_demo.ZoneCode = SD_CUS_MASTER.Zone_Code and Master_Product_demo.ProductName = invoice_details.Item_Code
		where PAN_No = '".$emp_id."' AND Sales_Organization = '".$site_division."'"; 

		// $invoice_sql = "SELECT TOP 100 Invoice_No,FORMAT(Invoice_Date,'dd-MM-yyyy') as Invoice_Date,Actual_Item_ID,Qty_In_Kgs,Net_Amount from Sales_Placement_Invoice_Details where Sales_Organisation = '".$site_division."'";

		if(isset($_POST['season']) && $_POST['season'] != '') {
			$invoice_sql .= " AND invoice_details.Season_Code = '".$_POST['season']."'";			
		}

		if(isset($_POST['from_date']) && isset($_POST['to_date']) && $_POST['from_date'] != '' && $_POST['to_date'] != '') {
			$invoice_sql .= " AND invoice_details.Invoice_Date BETWEEN '".$_POST['from_date']."' AND '".$_POST['to_date']."'";			
		}


		$invoice_exec = sqlsrv_query($conn,$invoice_sql);
		$result = array();
		while ($row = sqlsrv_fetch_array($invoice_exec,SQLSRV_FETCH_ASSOC)) {
			$result[] = $row; 
		}


		echo json_encode($result);exit;
	}

	//Divya
	if($_POST['Action'] == 'getCustomerDetails') {
		$panNo = $_POST['panNo'];
		$fromdate = date('Ymd', strtotime($_POST['fdate']));
	    $todate = date('Ymd', strtotime($_POST['tdate']));

		// $qry = "select * from SD_CUS_MASTER where PAN_No='".$panNo."'";
		// $qryExec = sqlsrv_query($conn, $qry);
		// while ($row = sqlsrv_fetch_array($qryExec, SQLSRV_FETCH_ASSOC)) {
		// 	$customer_id = $row["Customer"];
			$customer_no = '0020000873';
			// $customer_id = '0010001363';
			//192.168.162.213:8081/Customer_SOA/DEV/ZIN_RFC_GET_CUS_SOA.php?FROM_DATE=20181113&TO_DATE=20240307&CUSTOMER_CODE=0010001363&TOP_RECORD=0

		$url ='http://192.168.162.213:8081/Customer_SOA/PRD/ZIN_RFC_GET_CUS_SOA.php?FROM_DATE='.$fromdate.'&TO_DATE='.$todate.'&CUSTOMER_CODE='.$customer_no.'&TOP_RECORD=5';

			// $url = '192.168.162.213:8081/Customer_SOA/DEV/ZIN_RFC_GET_CUS_SOA.php?FROM_DATE='.$fromdate.'&TO_DATE='.$todate.'&CUSTOMER_CODE='.$customer_id.'&TOP_RECORD=5';

			// $url = '192.168.162.213:8081/Customer_SOA/DEV/ZIN_RFC_GET_CUS_SOA.php?FROM_DATE=20181113&TO_DATE=20240307&CUSTOMER_CODE=0010001363&TOP_RECORD=5';
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
	// }

		echo json_encode($data);exit;
	}

	if($_POST['Action'] == 'single_product_view') {

		$single_product_sql = "SELECT * FROM Customer_portal_product_master where Id='".$_POST['product_id']."' AND Product_division = '".$_POST['site_division']."' AND Status ='active' "; 

		$single_product_exec = sqlsrv_query($conn,$single_product_sql);
		$result = array();
		while ($row = sqlsrv_fetch_array($single_product_exec,SQLSRV_FETCH_ASSOC)) {
			$result[] = $row; 
		}


		echo json_encode($result);exit;
	}


	if($_POST['Action'] == 'get_credit_note_data') 
	{
		$credit_note_data = $credit_note->get_credit_note_data($_POST);
		echo json_encode($credit_note_data);exit;
	}

}

?>