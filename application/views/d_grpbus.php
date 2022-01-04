
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
		<script src="<?php echo base_url();?>asset/code/highcharts-3d.js"></script>
        <script src="<?php echo base_url();?>asset/code/modules/exporting.js"></script>
        <script src="<?php echo base_url();?>asset/code/modules/export-data.js"></script>
<div class="row">
    <div class="box col-md-12">

        <div class="box-inner">
            <div class="box-header well" data-original-title="">
                <h2><i class="glyphicon glyphicon-home"></i> hjg</h2>

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
        <th style="text-align: right;">Amount</th>
        
      </tr>
    </thead>
    <tbody>
<?php
setlocale(LC_MONETARY, 'en_IN');





if(isset($_GET['btd']))
{
	$query_td_bus = "SELECT substr(D.COLL_TYPE_CODE,1,2) COLL_TYPE_CODE,COLL_TYPE,SUM(D.AMOUNT) AMOUNT
FROM  GRP.GRP_MRECEIPT H,
          GRP.GRP_MRECEIPT_DTL D,
          GRP.GRP_COLL_TYPE_MST CT
WHERE H.RECEIPTNO=D.RECEIPTNO and TO_CHAR(H.RECEIPTDATE,'DDMMYYYY')=ltrim(rtrim(to_char(add_months(trunc(sysdate),-1),'DDYYYYMM')))
AND substr(D.COLL_TYPE_CODE,1,2)=CT.COLL_TYPE_CODE
AND substr(D.COLL_TYPE_CODE,1,2)<>'V1'  -- <-- (To Check Vat Close This  Line)
GROUP BY substr(D.COLL_TYPE_CODE,1,2) ,COLL_TYPE";
}
else if(isset($_GET['btm']))
{
	$query_td_bus = "SELECT substr(D.COLL_TYPE_CODE,1,2) COLL_TYPE_CODE,COLL_TYPE,SUM(D.AMOUNT) AMOUNT
FROM  GRP.GRP_MRECEIPT H,
          GRP.GRP_MRECEIPT_DTL D,
          GRP.GRP_COLL_TYPE_MST CT
WHERE H.RECEIPTNO=D.RECEIPTNO and TO_CHAR(H.RECEIPTDATE,'MMYYYY')=TO_CHAR(SYSDATE,'MMYYYY')
AND substr(D.COLL_TYPE_CODE,1,2)=CT.COLL_TYPE_CODE
AND substr(D.COLL_TYPE_CODE,1,2)<>'V1'  -- <-- (To Check Vat Close This  Line)
GROUP BY substr(D.COLL_TYPE_CODE,1,2) ,COLL_TYPE";
}
else if(isset($_GET['blm']))
{
	$query_td_bus = "SELECT substr(D.COLL_TYPE_CODE,1,2) COLL_TYPE_CODE,COLL_TYPE,SUM(D.AMOUNT) AMOUNT
FROM  GRP.GRP_MRECEIPT H,
          GRP.GRP_MRECEIPT_DTL D,
          GRP.GRP_COLL_TYPE_MST CT
WHERE H.RECEIPTNO=D.RECEIPTNO and TO_CHAR(H.RECEIPTDATE,'MMYYYY')=ltrim(rtrim(to_char(add_months(trunc(sysdate),-1),'YYYYMM')))
AND substr(D.COLL_TYPE_CODE,1,2)=CT.COLL_TYPE_CODE
AND substr(D.COLL_TYPE_CODE,1,2)<>'V1'  -- <-- (To Check Vat Close This  Line)
GROUP BY substr(D.COLL_TYPE_CODE,1,2) ,COLL_TYPE";
}
else if(isset($_GET['bty']))
{
	$query_td_bus = "SELECT substr(D.COLL_TYPE_CODE,1,2) COLL_TYPE_CODE,COLL_TYPE,SUM(D.AMOUNT) AMOUNT
FROM  GRP.GRP_MRECEIPT H,
          GRP.GRP_MRECEIPT_DTL D,
          GRP.GRP_COLL_TYPE_MST CT
WHERE H.RECEIPTNO=D.RECEIPTNO and TO_CHAR(H.RECEIPTDATE,'YYYY')=TO_CHAR(SYSDATE,'YYYY')
AND substr(D.COLL_TYPE_CODE,1,2)=CT.COLL_TYPE_CODE
AND substr(D.COLL_TYPE_CODE,1,2)<>'V1'  -- <-- (To Check Vat Close This  Line)
GROUP BY substr(D.COLL_TYPE_CODE,1,2) ,COLL_TYPE";
}



$stid_td_bus = OCIParse($conn, $query_td_bus);
OCIExecute($stid_td_bus); 
$newsum = 0;
while($row_td_bus= oci_fetch_array($stid_td_bus))
{
$newsum += $row_td_bus[2];
//$item[]= "{name: '".$row_td_bus[0]."',y: ".$row_td_bus[2]."}, ";
//['Firefox', 45.0],	
$item[]="['".$row_td_bus[1]."', ".$row_td_bus[2]."],";
	
	?>
      <tr>
        <td><?php echo $row_td_bus[1];?></td>
        <td style="text-align: right;"><?php echo number_format((float)$row_td_bus[2]);?></td>
        
      </tr>
	<?php }?>
	  <tr>
        <td><strong>Total </br>
          </strong></td>
        <td style="text-align: right;"><strong><?php echo number_format((float)$newsum);?></strong></td>
        
      </tr>
    </tbody>
  </table>
  
  <div id="container" style="height: 400px"></div>


		<script type="text/javascript">

Highcharts.chart('container', {
    chart: {
        type: 'pie',
        options3d: {
            enabled: true,
            alpha: 45,
            beta: 0
        }
    },
    title: {
        text: ''
    },
    tooltip: {
        pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
    },
    plotOptions: {
        pie: {
            allowPointSelect: true,
            cursor: 'pointer',
            depth: 35,
            dataLabels: {
                enabled: true,
                format: '{point.name}'
            }
        }
    },
    series: [{
        type: 'pie',
        name: 'Browser share',
        data: [
           <?php
			for($x = 0; $x < count($item); $x++) {
				echo $item[$x];
			}
			?> 

        ]
    }]
});
		</script>

</div>
  </div>
</div>  

