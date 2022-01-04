<?php 
if(isset($_GET['sb']))
{
$dtype='SB';
$cap ='Survival Benefit';
}
else if(isset($_GET['mc']))
{
$dtype='MC';
$cap ='Maturity';
}
else if(isset($_GET['sr']))
{
$dtype='SR';
$cap ='Surrender';
}
else if(isset($_GET['ln']))
{
$dtype='LN';
$cap ='Loan';
}
?>
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
                <h2><i class="glyphicon glyphicon-home"></i> <?php echo $cap;?> (Last 3 Months)</h2>

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
        <th style="text-align: right;">Process</th>
        <th style="text-align: right;">Payable</th>
        <th style="text-align: right;">Paid</br>Quantity</th>
        <th style="text-align: right;">Paid</br>Amount</th>
        <th style="text-align: right;">Outstanding</br>Quantity</th>
        <th style="text-align: right;">Outstanding</br>Amount</th>
      </tr>
    </thead>
    <tbody>
<?php
setlocale(LC_MONETARY, 'en_IN');

$query_td_bus = "SELECT DECODE(A.PRJ_CODE,'01','POLASH','08','BOKUL','20','TAKAFUL-EKHLAS','09','METRO','04','IDPS','17','KRISHNACHURA','05','PBPIB','24','PBPIB','OTHERS') PROJECT, COUNT(*) TOTTAL_PROCESS, ROUND(SUM(NVL(NETPAYABLE,0))) NET_PAYABLE,
SUM(CASE WHEN NVL(A.STATUS,'XXX')<>'XXX' THEN 1 ELSE 0 END) PAID_CNT,SUM(CASE WHEN NVL(A.STATUS,'XXX')<>'XXX' THEN ROUND(NVL(NETPAYABLE,0)) ELSE 0 END) PAID_AMOUNT
FROM IPL.ALL_BENEFIT A
WHERE BENEFIT_TYPE='$dtype' AND DUE_MON BETWEEN TO_CHAR(SYSDATE-28*6,'YYYYMM') AND TO_CHAR(SYSDATE-28,'YYYYMM')
GROUP BY DECODE(A.PRJ_CODE,'01','POLASH','08','BOKUL','20','TAKAFUL-EKHLAS','09','METRO','04','IDPS','17','KRISHNACHURA','05','PBPIB','24','PBPIB','OTHERS')
order by NET_PAYABLE desc";
$stid_td_bus = OCIParse($conn, $query_td_bus);
OCIExecute($stid_td_bus); 
	$pross =0;
	$payb =0;
	$payqt =0;
	$payamt =0;
	$outqt=0;
	$outamt =0;
while($row_td_bus= oci_fetch_array($stid_td_bus))
{
	$pross += $row_td_bus[1];
	$payb += $row_td_bus[2];
	$payqt += $row_td_bus[3];
	$payamt +=$row_td_bus[4];
	$outqt += ($row_td_bus[1]-$row_td_bus[3]);
	$outamt += ($row_td_bus[2]-$row_td_bus[4]);
	
	$item[]= "'".$row_td_bus[0]."',";
	$pable[]=$row_td_bus[2].",";
	$pamt[]=$row_td_bus[4].",";
	$pouts[]=($row_td_bus[2]-$row_td_bus[4]).",";
	?>
      <tr>
        <td><?php echo $row_td_bus[0];?></td>
        <td style="text-align: right;"><?php echo number_format((float)$row_td_bus[1]);?></td>
        <td style="text-align: right;"><?php echo number_format((float)$row_td_bus[2]);?></td>
        <td style="text-align: right;"><?php echo number_format((float)$row_td_bus[3]);?></td>
        <td style="text-align: right;"><?php echo number_format((float)$row_td_bus[4]);?></td>
        <td style="text-align: right;"><?php echo number_format((float)($row_td_bus[1]-$row_td_bus[3]));?></td>
        <td style="text-align: right;"><?php echo number_format((float)($row_td_bus[2]-$row_td_bus[4]));?></td>
      </tr>
	<?php }?>
	  <tr>
        <td><strong>Total </br>
          </strong></td>
        <td style="text-align: right;"><?php echo number_format((float)$pross);?></td>
        <td style="text-align: right;"><?php echo number_format((float)$payb);?></td>
        <td style="text-align: right;"><?php echo number_format((float)$payqt);?></td>
        <td style="text-align: right;"><?php echo number_format((float)$payamt);?></td>
        <td style="text-align: right;"><?php echo number_format((float)$outqt);?></td>
         <td style="text-align: right;"><?php echo number_format((float)$outamt);?></td>
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
        text: '<?php echo $cap;?>'
    },
    subtitle: {
        text: ''
    },
    xAxis: {
        categories: [ <?php
			for($x = 0; $x < count($item); $x++) {
				echo $item[$x];
			}
			?>],
        title: {
            text: null
        }
    },
    yAxis: {
        min: 0,
        title: {
            text: 'Population (millions)',
            align: 'high'
        },
        labels: {
            overflow: 'justify'
        }
    },
    tooltip: {
        valueSuffix: ' millions'
    },
    plotOptions: {
        bar: {
            dataLabels: {
                enabled: true
            }
        }
    },
    legend: {
        layout: 'vertical',
        align: 'right',
        verticalAlign: 'top',
        x: -40,
        y: 80,
        floating: true,
        borderWidth: 1,
        backgroundColor: ((Highcharts.theme && Highcharts.theme.legendBackgroundColor) || '#FFFFFF'),
        shadow: true
    },
    credits: {
        enabled: false
    },
    series: [{
        name: 'Payable',
        data: [<?php
			for($x = 0; $x < count($item); $x++) {
				echo $pable[$x];
			}
			?>]
    }, {
        name: 'Payd Amount',
         data: [<?php
			for($x = 0; $x < count($item); $x++) {
				echo $pamt[$x];
			}
			?>]
    }, {
        name: 'Outstanding Amount',
         data: [<?php
			for($x = 0; $x < count($item); $x++) {
				echo $pouts[$x];
			}
			?>]
    }]
});
		</script>

</div>
  </div>
</div>  

