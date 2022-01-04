<script src="<?php echo base_url();?>asset/js/jquery-2.1.1.min.js"></script>
<style>
.col-md-3 {
    width: 23% !important;
}
.container {
    width: 100% !important;
}

</style>
       <script src="<?php echo base_url();?>asset/code/highcharts.js"></script>
		<script src="<?php echo base_url();?>asset/code/modules/exporting.js"></script>
		<script src="<?php echo base_url();?>asset/code/modules/export-data.js"></script>
<div class="row">
    <div class="box col-md-12">

        <div class="box-inner">
            <div class="box-header well" data-original-title="">
                <h2><i class="glyphicon glyphicon-home"></i> Policy (Last 3 Monts)</h2>

                <div class="box-icon">

                    <a href="#" class="btn btn-minimize btn-round btn-default"><i
                            class="glyphicon glyphicon-chevron-up"></i></a>
                    <a href="#" class="btn btn-close btn-round btn-default"><i
                            class="glyphicon glyphicon-remove"></i></a>
                </div>
            </div>
            <div class="box-content">
            
    <div class="row">
    <div class="container">
<div class="container">         
  <table class="table table-condensed">
    <thead>
      <tr>
        <th>Project</th>
        <th style="text-align: right;">Proposal</th>
        <th style="text-align: right;">Sum Assured</th>
        <th style="text-align: right;">Policy</th>
        <th style="text-align: right;">Sum Assured</th>
        <th style="text-align: right;">Difference</th>
        <th style="text-align: right;">Sum Assured</th>
      </tr>
    </thead>
    <tbody>
<?php
setlocale(LC_MONETARY, 'en_IN');
if(isset($_GET['btd']))
{
	$query_td_bus = "SELECT DECODE(PRJ_CODE,'01','POLASH','08','BOKUL','20','TAKAFUL-EKHLAS','09','METRO','04','IDPS','17','KRISHNACHURA', '05', 'PBPIB', '24', 'PBPIB','OTHERS') PROJECT,
SUM (CASE WHEN PAYMODE='5' THEN SUMASS ELSE 0 END) MONTHLY_SUMASS,
COUNT(*) TOTAL_PROPOSAL, SUM(CASE WHEN POLICY IS NULL THEN 0 ELSE 1 END) POL_CNT, SUM(NVL(SUMASS,0)) SUMASS FROM IPL.ALL_PROPOSAL 
WHERE  TO_CHAR(INDATE,'YYYYMMDD')=TO_CHAR(SYSDATE,'YYYYMMDD') GROUP BY DECODE(PRJ_CODE,'01','POLASH','08','BOKUL','20','TAKAFUL-EKHLAS','09','METRO','04','IDPS','17','KRISHNACHURA', '05', 'PBPIB', '24', 'PBPIB','OTHERS') order by SUMASS desc";
}
else if(isset($_GET['btm']))
{
	$query_td_bus = "SELECT DECODE(PRJ_CODE,'01','POLASH','08','BOKUL','20','TAKAFUL-EKHLAS','09','METRO','04','IDPS','17','KRISHNACHURA', '05', 'PBPIB', '24', 'PBPIB','OTHERS') PROJECT,
SUM (CASE WHEN PAYMODE='5' THEN SUMASS ELSE 0 END) MONTHLY_SUMASS,
COUNT(*) TOTAL_PROPOSAL, SUM(CASE WHEN POLICY IS NULL THEN 0 ELSE 1 END) POL_CNT, SUM(NVL(SUMASS,0)) SUMASS FROM IPL.ALL_PROPOSAL 
WHERE  TO_CHAR(INDATE,'YYYYMM')=TO_CHAR(SYSDATE,'YYYYMM')GROUP BY DECODE(PRJ_CODE,'01','POLASH','08','BOKUL','20','TAKAFUL-EKHLAS','09','METRO','04','IDPS','17','KRISHNACHURA', '05', 'PBPIB', '24', 'PBPIB','OTHERS') order by SUMASS desc";
}
else if(isset($_GET['blm']))
{
	$query_td_bus = "SELECT DECODE(PRJ_CODE,'01','POLASH','08','BOKUL','20','TAKAFUL-EKHLAS','09','METRO','04','IDPS','17','KRISHNACHURA', '05', 'PBPIB', '24', 'PBPIB','OTHERS') PROJECT,
SUM (CASE WHEN PAYMODE='5' THEN SUMASS ELSE 0 END) MONTHLY_SUMASS,
COUNT(*) TOTAL_PROPOSAL, SUM(CASE WHEN POLICY IS NULL THEN 0 ELSE 1 END) POL_CNT, SUM(NVL(SUMASS,0)) SUMASS FROM IPL.ALL_PROPOSAL 
WHERE  TO_CHAR(INDATE,'YYYYMM')=ltrim(rtrim(to_char(add_months(trunc(sysdate),-1),'YYYYMM'))) GROUP BY DECODE(PRJ_CODE,'01','POLASH','08','BOKUL','20','TAKAFUL-EKHLAS','09','METRO','04','IDPS','17','KRISHNACHURA', '05', 'PBPIB', '24', 'PBPIB','OTHERS') order by SUMASS desc";
}
else if(isset($_GET['bty']))
{
	$query_td_bus = "SELECT DECODE(PRJ_CODE,'01','POLASH','08','BOKUL','20','TAKAFUL-EKHLAS','09','METRO','04','IDPS','17','KRISHNACHURA', '05', 'PBPIB', '24', 'PBPIB','OTHERS') PROJECT,
SUM (CASE WHEN PAYMODE='5' THEN SUMASS ELSE 0 END) MONTHLY_SUMASS,
COUNT(*) TOTAL_PROPOSAL, SUM(CASE WHEN POLICY IS NULL THEN 0 ELSE 1 END) POL_CNT, SUM(NVL(SUMASS,0)) SUMASS FROM IPL.ALL_PROPOSAL 
WHERE  TO_CHAR(INDATE,'YYYY')=TO_CHAR(SYSDATE,'YYYY') GROUP BY DECODE(PRJ_CODE,'01','POLASH','08','BOKUL','20','TAKAFUL-EKHLAS','09','METRO','04','IDPS','17','KRISHNACHURA', '05', 'PBPIB', '24', 'PBPIB','OTHERS') order by SUMASS desc";
}

$stid_td_bus = OCIParse($conn, $query_td_bus);
OCIExecute($stid_td_bus); 
$pros = 0;
$prosa = 0;
$pol = 0;
$polsa = 0;
while($row_td_bus= oci_fetch_array($stid_td_bus))
{

$pros += $row_td_bus[2];
$prosa += $row_td_bus[4];
$pol += $row_td_bus[3];
$polsa += $row_td_bus[1];
$item[]= "'".$row_td_bus[0]."',";
$poln[]=$row_td_bus[3].",";
$defno[]=($row_td_bus[2]-$row_td_bus[3]).",";
	?>
      <tr>
        <td><?php echo $row_td_bus[0];?></td>
        <td style="text-align: right;"><?php echo number_format((float)$row_td_bus[2]);?></td>
        <td style="text-align: right;"><?php echo number_format((float)$row_td_bus[4]);?></td>
        <td style="text-align: right;"><?php echo number_format((float)$row_td_bus[3]);?></td>
        <td style="text-align: right;"><?php echo number_format((float)$row_td_bus[1]);?></td>
        <td style="text-align: right;"><?php echo number_format((float)$row_td_bus[2]-$row_td_bus[3]);?></td>
        <td style="text-align: right;"><?php echo number_format((float)$row_td_bus[4]-$row_td_bus[1]);?></td>
      </tr>
	<?php }?>
	  <tr>
        <td><strong>Total</strong></td>
        <td style="text-align: right;"><strong><?php echo number_format((float)$pros);?></strong></td>
        <td style="text-align: right;"><strong><?php echo number_format((float)$prosa);?></strong></td>
        <td style="text-align: right;"><strong><?php echo number_format((float)$pol);?></strong></td>
        <td style="text-align: right;"><strong><?php echo number_format((float)$polsa);?></strong></td>
        <td style="text-align: right;"><strong><?php echo number_format((float)$pros-$pol);?></strong></td>
        <td style="text-align: right;"><strong><?php echo number_format((float)$prosa-$polsa);?></strong></td>
      </tr>
    </tbody>
  </table>
<div id="container"></div>



		<script type="text/javascript">

Highcharts.chart('container', {
    chart: {
        type: 'bar'
    },
    title: {
        text: 'Stacked bar chart'
    },
    xAxis: {
        categories: [			 <?php
			for($x = 0; $x < count($item); $x++) {
				echo $item[$x];
			}
			?> ]
    },
    yAxis: {
        min: 0,
        title: {
            text: 'Total fruit consumption'
        }
    },
    legend: {
        reversed: true
    },
    plotOptions: {
        series: {
            stacking: 'normal'
        }
    },
    series: [{
        name: 'Policy Accepted',
        data: [<?php
			for($x = 0; $x < count($item); $x++) {
				echo $poln[$x];
			}
			?>]
    }, {
        name: 'Policy Not Accepted',
        data: [<?php
			for($x = 0; $x < count($item); $x++) {
				echo $defno[$x];
			}
			?>],
    }, ]
});
		</script>
  


</div>
  </div>
</div>  

