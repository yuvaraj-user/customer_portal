<?php 
include_once('top_head.php');

include_once('header.php');  
?>
<style type="text/css">
	.table-striped > tbody >tr:nth-of-type(odd) > * {
    	--bs-table-accent-bg: rgb(47 192 114 / 8%) !important;
	}

	.dt-length > label {
		margin-left: 10px;
		color: black;
	}

	.dt-input {
		height: 30px;
	}

	.dt-search > label {
		color: black;
	}
	.dt-paging-button.current {
		background: rgb(47 192 114 / 8%);
		color: black !important;
		border: none;
		box-shadow: 0px 0px 3px #127412c9;
	}

	.table td, .table th , .dt-info {
		font-size: 15px;
	}
	.dt-buttons {
		display: flex;
	}

	.dt-button {
		height: 30px;
		display: flex !important;
		align-items: center;
	}

	.dt-button:hover {
		background: rgb(47 192 114 / 8%);
		color: black !important;
		border: none;
		box-shadow: 0px 0px 3px #127412c9;
	}
</style>

<section class="invoice_head_bg">
</section>

<section>
	<div class="card filter-bg">
		<div class="card-body">
			<div class="row justify-content-center">
				<div class="col-md-12 col-lg-2 col-xl-2 d-flex">
					<label for="season" class="form-label text-white text-nowrap me-3">Season</label>
					<select class="form-control form-control-lg selectbox" name="season" id="season"/>
					</select>
				</div>
				<div class="col-md-12 col-lg-3 col-xl-3 d-flex">
					<label for="daterange" class="form-label text-white text-nowrap me-3">Choose Date Range</label>
					<input type="text" class="form-control form-control-lg" name="daterange" value="" id="daterange"/>
				</div>
				<div class="col-md-12 col-lg-3 col-xl-3 d-flex">
					<button class="btn btn-primary filter"><i class="fa fa-search" aria-hidden="true"></i> Filter</button>
				</div>
		</div>
	</div>

</section>

<section>
	<div class="container tbl_container pt-5 pb-5" >
		<table class="table table-striped table-bordered table-hover table-responsive dt_table" id= "table-id">
		  
		  <thead>
			<tr>
				<th class="text-center">Invoice No</th>
				<th class="text-center">Invoice Date</th>
				<th class="text-left">Product</th>
				<th class="text-left">Qty In Bag</th>
				<th class="text-left">Qty In Pkt</th>
				<th class="text-left">Qty In Kg</th>
				<th class="text-left">Net Amount</th>
			</tr>
		    
		  </thead>

		  <tbody class="invoice_body">
		  </tbody>

		</table>
	</div>
</section>
<?php include_once('footer.php') ?>
<?php include_once('bottom_script.php') ?>

<script type="text/javascript">
	$(document).ready(function(){	
		var end = moment();
		$('#daterange').daterangepicker({
			autoUpdateInput: false,
			maxDate: end,
			 changeYear: true 
		}, function(start, end, label) {
			// console.log("A new date selection was made: " + start.format('YYYY-MM-DD') + '-' + end.format('YYYY-MM-DD'));
			var text = start.format('YYYY-MM-DD') + ' To ' + end.format('YYYY-MM-DD');
			$('#daterange').val(text);
		});

		get_season_code();
		datatable();

		$('.selectbox').select2();
	});

	function datatable()
	{
		$('.dt_table').DataTable({
	        paging: true, // Enable pagination
	        searching: true, // Enable search box
	        ordering: true, // Enable column sorting
	        responsive: true,
  			pageLength: 10,
	        layout: {
	        	topStart: {
	        		buttons: ['copy', 'csv', 'excel', 'pdf', 'print']
	        	}
	        }
	    });
	}


	function get_season_code()
	{
		$.ajax({
			url  : 'common_ajax.php',
			type : 'POST',
			data : { Action : 'get_division_based_season'},
			dataType : 'json',
			success:function(response){
				var html = '<option value"">Select Season</option>';
				for(i in response) {
					html += `<option value="${ response[i].Season_Code }">${ response[i].Season_Code }</option>`;
				}
				$('#season').html(html);
			}
		});
	}

	$(document).on('click','.filter',function(){		
		var season = $('#season').val();
		var date = $('#daterange').val();

		var from_date = (date != '') ? date.split('To')[0] : '';
		var to_date   = (date != '') ? date.split('To')[1] : '';

		$.ajax({
			url  : 'common_ajax.php',
			type : 'POST',
			data : { Action : 'filter_history_of_invoice',season : season, from_date : from_date,to_date : to_date },
			dataType : 'json',
			beforeSend: function(){
				$('.ajaxloader').show();
			},
			success:function(response){
				$('.dt_table').DataTable().destroy();
				var html = '';
				for(i in response) {
					html += `<tr>
						<td class="text-center">${ response[i].Invoice_No }</td>
						<td class="text-center">${ response[i].Invoice_Date }</td>
						<td>${ response[i].Actual_Item_ID }</td>
						<td>${ (response[i].bag_of_packets > 0) ? (response[i].invoice_QtyInPkts/response[i].bag_of_packets) : 0 }</td>
						<td>${ parseInt(response[i].invoice_QtyInPkts) }</td>
						<td>${ response[i].invoice_QtyInKgs }</td>
						<td>${ response[i].invoice_NetAmount }</td>

					</tr>`;
				}
				$('.invoice_body').html(html);
				datatable();
				$('.tbl_container').css('visibility','visible');
				$('.ajaxloader').hide();

			}
		});
	});	



</script>
</body>

