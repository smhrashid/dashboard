<style>
.col-md-3 {
    width: 23% !important;
}
.container {
    width: 100% !important;
}
.athis {
    color: #000;
    text-decoration: none;
}
.athis:hover {
    color: #fff;
	font-weight:bold;
    
}
</style>
<?php
setlocale(LC_MONETARY, 'en_IN');
$query_td_bus = "select * from BILLAL.DASHBOARD";
$stid_td_bus = OCIParse($conn, $query_td_bus);
OCIExecute($stid_td_bus); 
while($row_td_bus= oci_fetch_array($stid_td_bus))
{
	$item[]= $row_td_bus[0];
	$td[]= $row_td_bus[1];
	$tm[]= $row_td_bus[2];
	$lm[]= $row_td_bus[3];
	$ty[]= $row_td_bus[4];

	
}
?>
	<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>asset/fonts/font-awesome-4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>asset/vendor/animate/animate.css">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>asset/vendor/select2/select2.min.css">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>asset/vendor/perfect-scrollbar/perfect-scrollbar.css">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>asset/css/util.css">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>asset/css/main.css">
    




				<div class="table100 ver2 m-b-110">
					<table data-vertable="ver2">
						<thead>
							<tr class="row100 head">
								<th class="column100 column1" data-column="column1"></th>
								<th class="column100 column2" data-column="column2">Today</th>
								<th class="column100 column3" data-column="column3">This Month</th>
								<th class="column100 column4" data-column="column4">Last Month</th>
								<th class="column100 column5" data-column="column5">This year</th>

							</tr>
						</thead>
						<tbody>
							<tr class="row100">
								<td class="column100 column1" data-column="column1">IPL Business</td>
								<td class="column100 column2" data-column="column2">
                                <a href="projbus?btd" class="athis"><div style="height:100%;width:100%"><?php echo number_format($td[0]);?></div></a>
                                </td>
								<td class="column100 column3" data-column="column3">
                                <a href="projbus?btm" class="athis"><div style="height:100%;width:100%"><?php echo number_format($tm[0]);?></div></a>
                                </td>
								<td class="column100 column4" data-column="column4">
								<a href="projbus?blm" class="athis"><div style="height:100%;width:100%"><?php echo number_format($lm[0]);?></div></a>
                                </td>
								<td class="column100 column5" data-column="column5">
								<a href="projbus?bty" class="athis"><div style="height:100%;width:100%"><?php echo number_format($ty[0]);?></div></a>
                                </td>

							</tr>
                            
                            <tr class="row100">
								<td class="column100 column1" data-column="column1">Group Business</td>
								<td class="column100 column2" data-column="column2">
                                <a href="grpbus?btd" class="athis"><div style="height:100%;width:100%">000</div></a>
                                </td>
								<td class="column100 column3" data-column="column3">
                                <a href="grpbus?btm" class="athis"><div style="height:100%;width:100%">000</div></a>
                                </td>
								<td class="column100 column4" data-column="column4">
								<a href="grpbus?blm" class="athis"><div style="height:100%;width:100%">000</div></a>
                                </td>
								<td class="column100 column5" data-column="column5">
								<a href="grpbus?bty" class="athis"><div style="height:100%;width:100%">000</div></a>
                                </td>

							</tr>

							<tr class="row100">
								<td class="column100 column1" data-column="column1">Commission</td>
								<td class="column100 column2" data-column="column2">
								<a href="projcom?btd" class="athis"><div style="height:100%;width:100%"><?php echo number_format($td[9]);?></div></a>
                                </td>
								<td class="column100 column3" data-column="column3">
								<a href="projcom?btm" class="athis"><div style="height:100%;width:100%"><?php echo number_format($tm[9]);?></div></a>
                                </td>
								<td class="column100 column4" data-column="column4">
								<a href="projcom?blm" class="athis"><div style="height:100%;width:100%"><?php echo number_format($lm[9]);?></div></a>
                                </td>
								<td class="column100 column5" data-column="column5">
								<a href="projcom?bty" class="athis"><div style="height:100%;width:100%"><?php echo number_format($ty[9]);?></div></a>
                                </td>

							</tr>

	

							<tr class="row100">
								<td class="column100 column1" data-column="column1">Policy</td>
								<td class="column100 column2" data-column="column2">
								<a href="dpol?btd" class="athis"><div style="height:100%;width:100%"><?php echo number_format($td[2]);?></div></a>
                                </td>
								<td class="column100 column3" data-column="column3">
								<a href="dpol?btm" class="athis"><div style="height:100%;width:100%"><?php echo number_format($tm[2]);?></div></a>
                                </td>
								<td class="column100 column4" data-column="column4">
								<a href="dpol?blm" class="athis"><div style="height:100%;width:100%"><?php echo number_format($lm[2]);?></div></a>
                                </td>
								<td class="column100 column5" data-column="column5">
								<a href="dpol?bty" class="athis"><div style="height:100%;width:100%"><?php echo number_format($ty[2]);?></div></a>
                                </td>

							</tr>

							<tr class="row100">
								<td class="column100 column1" data-column="column1">SB</td>
								<td class="column100 column2" data-column="column2">
								<a href="dsb?sb" class="athis"><div style="height:100%;width:100%"><?php echo number_format($td[3]);?></div></a>
                                </td>
								<td class="column100 column3" data-column="column3">
								<a href="dsb?sb" class="athis"><div style="height:100%;width:100%"><?php echo number_format($tm[3]);?></div></a>
                                </td>
								<td class="column100 column4" data-column="column4">
								<a href="dsb?sb" class="athis"><div style="height:100%;width:100%"><?php echo number_format($lm[3]);?></div></a>
                                </td>
								<td class="column100 column5" data-column="column5">
								<a href="dsb?sb" class="athis"><div style="height:100%;width:100%"><?php echo number_format($ty[3]);?></div></a>
                                </td>

							</tr>

							<tr class="row100">
								<td class="column100 column1" data-column="column1">Maturity</td>
								<td class="column100 column2" data-column="column2">
								<a href="dsb?mc" class="athis"><div style="height:100%;width:100%"><?php echo number_format($td[4]);?></div></a>
                                </td>
								<td class="column100 column3" data-column="column3">
								<a href="dsb?mc" class="athis"><div style="height:100%;width:100%"><?php echo number_format($tm[4]);?></div></a>
                                </td>
								<td class="column100 column4" data-column="column4">
								<a href="dsb?mc" class="athis"><div style="height:100%;width:100%"><?php echo number_format($lm[4]);?></div></a>
                                </td>
								<td class="column100 column5" data-column="column5">
								<a href="dsb?mc" class="athis"><div style="height:100%;width:100%"><?php echo number_format($ty[4]);?></div></a>
                                </td>

							</tr>

							<tr class="row100">
								<td class="column100 column1" data-column="column1">Surrender</td>
								<td class="column100 column2" data-column="column2">
								<a href="dsb?sr" class="athis"><div style="height:100%;width:100%"><?php echo number_format($td[5]);?></div></a>
                                </td>
								<td class="column100 column3" data-column="column3">
								<a href="dsb?sr" class="athis"><div style="height:100%;width:100%"><?php echo number_format($tm[5]);?></div></a>
                                </td>
								<td class="column100 column4" data-column="column4">
								<a href="dsb?sr" class="athis"><div style="height:100%;width:100%"><?php echo number_format($lm[5]);?></div></a>
                                </td>
								<td class="column100 column5" data-column="column5">
								<a href="dsb?sr" class="athis"><div style="height:100%;width:100%"><?php echo number_format($ty[5]);?></div></a>
                                </td>

							</tr>

							<tr class="row100">
								<td class="column100 column1" data-column="column1">Loan</td>
								<td class="column100 column2" data-column="column2">
								<a href="dsb?ln" class="athis"><div style="height:100%;width:100%"><?php echo number_format($td[6]);?></div></a>
                                </td>
								<td class="column100 column3" data-column="column3">
								<a href="dsb?ln" class="athis"><div style="height:100%;width:100%"><?php echo number_format($tm[6]);?></div></a>
                                </td>
								<td class="column100 column4" data-column="column4">
								<a href="dsb?ln" class="athis"><div style="height:100%;width:100%"><?php echo number_format($lm[6]);?></div></a>
                                </td>
								<td class="column100 column5" data-column="column5">
								<a href="dsb?ln" class="athis"><div style="height:100%;width:100%"><?php echo number_format($ty[6]);?></div></a>
                                </td>

							</tr>
                            							<tr class="row100">
								<td class="column100 column1" data-column="column1">Investment</td>
								<td class="column100 column2" data-column="column2">
								<a href="#" class="athis"><div style="height:100%;width:100%"><?php echo number_format($td[7]);?></div></a>
                                </td>
								<td class="column100 column3" data-column="column3">
								<a href="#" class="athis"><div style="height:100%;width:100%"><?php echo number_format($tm[7]);?></div></a>
                                </td>
								<td class="column100 column4" data-column="column4">
								<a href="#" class="athis"><div style="height:100%;width:100%"><?php echo number_format($lm[7]);?></div></a>
                                </td>
								<td class="column100 column5" data-column="column5">
								<a href="#" class="athis"><div style="height:100%;width:100%"><?php echo number_format($ty[7]);?></div></a>
                                </td>

							</tr>
                            							<tr class="row100">
								<td class="column100 column1" data-column="column1">Death Claim</td>
								<td class="column100 column2" data-column="column2">
								<a href="#" class="athis"><div style="height:100%;width:100%"><?php echo number_format($td[8]);?></div></a>
                                </td>
								<td class="column100 column3" data-column="column3">
								<a href="#" class="athis"><div style="height:100%;width:100%"><?php echo number_format($tm[8]);?></div></a>
                                </td>
								<td class="column100 column4" data-column="column4">
								<a href="#" class="athis"><div style="height:100%;width:100%"><?php echo number_format($lm[8]);?></div></a>
                                </td>
								<td class="column100 column5" data-column="column5">
								<a href="#" class="athis"><div style="height:100%;width:100%"><?php echo number_format($ty[8]);?></div></a>
                                </td>

							</tr>
						</tbody>
					</table>
				</div>
	<script src="<?php echo base_url();?>asset/vendor/jquery/jquery-3.2.1.min.js"></script>
	<script src="<?php echo base_url();?>asset/vendor/bootstrap/js/popper.js"></script>
	<script src="<?php echo base_url();?>asset/vendor/bootstrap/js/bootstrap.min.js"></script>
	<script src="<?php echo base_url();?>asset/vendor/select2/select2.min.js"></script>
	<script src="<?php echo base_url();?>asset/js/main.js"></script>