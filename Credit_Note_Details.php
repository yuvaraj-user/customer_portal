<?php 
/**
 * 
 */
class Credit_Note_Details
{
	public $conn;
	public $site_division;
	public $pan_no;
	public $customer_no;
	function __construct($conn,$site_division,$pan_no)
	{
		$this->conn 		 = $conn; 
		$this->site_division = $site_division; 
		$this->pan_no		 = $pan_no;
		$this->customer_no	 = $_SESSION['customer_no'];  
	}

	public function get_credit_note_data($request)
	{
		$invoice_no  = isset($request['invoice_no']) ? $request['invoice_no'] : '';
		$from_date   = isset($request['from_date']) ? $request['from_date'] : '';
		$to_date     = isset($request['to_date']) ? $request['to_date'] : '';

		$fetch_count = (isset($request['limit']) && ($request['limit'] > 0)) ? $request['limit'] : '';

		// $query = "SELECT TOP ".$fetch_count." invoice_details.Invoice_No,FORMAT(invoice_details.Invoice_Date,'dd-MM-yyyy') as Invoice_Date,invoice_details.Actual_Item_ID,ABS(invoice_details.Qty_In_Kgs) as invoice_QtyInKgs,ABS(invoice_details.QtyInSalesUnit) as invoice_QtyInPkts,ABS(invoice_details.Net_Amount) as invoice_NetAmount,Master_Product_demo.QtyInPkt as bag_of_packets from SD_CUS_MASTER 
		// inner join Sales_Placement_Invoice_Details as invoice_details ON invoice_details.Customer_No = SD_CUS_MASTER.Customer and invoice_details.Sales_Organisation = '".$this->site_division."'
		// left join Master_Product_demo ON Master_Product_demo.ZoneCode = SD_CUS_MASTER.Zone_Code and Master_Product_demo.ProductName = invoice_details.Item_Code
		// where SD_CUS_MASTER.PAN_No = '".$this->emp_id."' AND SD_CUS_MASTER.Sales_Organization = '".$this->site_division."' AND invoice_details.QtyInSalesUnit < 0";

		// echo $query;exit;


		$query = "SELECT invoice_details.Invoice_No,FORMAT(invoice_details.Invoice_Date,'dd-MM-yyyy') as Invoice_Date,SUM(ABS(invoice_details.Qty_In_Kgs)) as invoice_QtyInKgs,SUM(ABS(invoice_details.QtyInSalesUnit)) as invoice_QtyInPkts,SUM(ABS(invoice_details.Net_Amount)) as invoice_NetAmount from SD_CUS_MASTER inner join Sales_Placement_Invoice_Details as invoice_details ON invoice_details.Customer_No = SD_CUS_MASTER.Customer and invoice_details.Sales_Organisation = '".$this->site_division."'
		WHERE SD_CUS_MASTER.Customer = '".$this->customer_no."' AND SD_CUS_MASTER.Sales_Organization = '".$this->site_division."' AND invoice_details.QtyInSalesUnit < 0";

		if($invoice_no != '') {
			$query .= " AND invoice_details.Invoice_No IN (SELECT * FROM SPLIT_STRING('".$invoice_no."',','))";
		}

		if($from_date != '' && $to_date != '') {
			$query .= " AND invoice_details.Invoice_Date BETWEEN '".$from_date."' AND '".$to_date."'";	
		}

		$query .= " GROUP by invoice_details.Invoice_No,invoice_details.Invoice_Date";

		if($fetch_count != '') {
			$query .= " ORDER BY invoice_details.Invoice_No ASC OFFSET 0 ROWS FETCH NEXT ".$fetch_count." ROWS ONLY";
		}


		$stmt = sqlsrv_query($this->conn, $query);

		if ($stmt === false) {
		    die(print_r(sqlsrv_errors(), true)); 
		}

		$result = [];
		$final_result = [];	
		while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
			$result['Invoice_No'] = $row['Invoice_No'];
			$result['Invoice_Date'] = $row['Invoice_Date'];
			$result['invoice_QtyInKgs'] = $row['invoice_QtyInKgs'];
			$result['invoice_QtyInPkts'] = (int) $row['invoice_QtyInPkts'];
			$result['invoice_NetAmount'] = $row['invoice_NetAmount'];

			$bag_of_packets_qry = "SELECT invoice_details.Invoice_No,FORMAT(invoice_details.Invoice_Date,'dd-MM-yyyy') as Invoice_Date,ABS(invoice_details.QtyInSalesUnit) as invoice_QtyInPkts,COALESCE(Master_Product_demo.QtyInPkt,0) as bag_of_packet from SD_CUS_MASTER inner join Sales_Placement_Invoice_Details as invoice_details ON invoice_details.Customer_No = SD_CUS_MASTER.Customer and invoice_details.Sales_Organisation = '".$this->site_division."'
			left join Master_Product_demo ON Master_Product_demo.ZoneCode = SD_CUS_MASTER.Zone_Code and Master_Product_demo.ProductName = invoice_details.Item_Code 
			where SD_CUS_MASTER.Customer = '".$this->customer_no."' AND SD_CUS_MASTER.Sales_Organization = '".$this->site_division."' AND invoice_details.QtyInSalesUnit < 0 AND invoice_details.Invoice_No = '".$row['Invoice_No']."' 
			GROUP by invoice_details.Invoice_No,invoice_details.Invoice_Date,invoice_details.QtyInSalesUnit,Master_Product_demo.QtyInPkt"; 


			$stmt1 = sqlsrv_query($this->conn, $bag_of_packets_qry);
			$no_of_bags = 0;
			while ($row1 = sqlsrv_fetch_array($stmt1, SQLSRV_FETCH_ASSOC)) {
				$bags  = ($row1['bag_of_packet'] > 0 && $row1['invoice_QtyInPkts'] > 0) ? $row1['invoice_QtyInPkts']/$row1['bag_of_packet'] : 0; 
				$no_of_bags += $bags;
			}

			$result['no_of_bags'] = $no_of_bags;
			
			$final_result[] = $result;
		}

		return $final_result; 
	}
}
?>
