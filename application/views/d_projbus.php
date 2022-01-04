<?php
if(isset($_GET['btd']))
{
	$stat="Today";
}
else if(isset($_GET['btm']))
{
	 	$stat="This Month";
}
else if(isset($_GET['blm']))
{
	 	$stat="Last Month"; 	
}
else if(isset($_GET['bty']))
{
	$stat="This year";
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
                <h2><i class="glyphicon glyphicon-home"></i> IPL Business (<?php echo $stat;?>)</h2>

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
        <th style="text-align: right;">New Business</th>
        <th style="text-align: right;">Deferred</th>
        <th style="text-align: right;">Single</th>
        <th style="text-align: right;">First Year</th>
        <th style="text-align: right;">Target</th>
        <th style="text-align: right;">Achieve(%)</th>
        <th style="text-align: right;">Renewal</th>
        <th style="text-align: right;">Target</th>
        <th style="text-align: right;">Achieve(%)</th>
        <th style="text-align: right;">Total</th>
        <th style="text-align: right;">Target</th>
        <th style="text-align: right;">Achieve(%)</th>
      </tr>
    </thead>
    <tbody>
<?php
setlocale(LC_MONETARY, 'en_IN');
if(isset($_GET['btd']))
{
	$query_td_bus = "SELECT T.PROJECT,T.NEW_BUSINESS,T.DEFERRED,T.SING,T.TOTAL_FIRSTYEAR,T.RENEWAL,b.FY_MONTLY/30,b.REN_MONTLY/30 FROM (
SELECT prj_code,DECODE(A.PRJ_CODE,'01','POLASH','08','BOKUL','20','TAKAFUL-EKHLAS','09','METRO','04','IDPS','17','KRISHNACHURA','OTHERS') PROJECT,
SUM(NVL(A.NEW_BUSINESS,0)) NEW_BUSINESS,SUM(NVL(A.DEFERRED,0)) DEFERRED,SUM(NVL(A.SING,0)) SING, SUM(NVL(NEW_BUSINESS,0)+NVL(DEFERRED,0)+NVL(SING,0)) AS TOTAL_FIRSTYEAR,ROUND(SUM(NVL(A.RENEWAL,0))) RENEWAL,
ROUND(SUM(NVL(NEW_BUSINESS,0)+NVL(DEFERRED,0)+NVL(SING,0)+ NVL(A.RENEWAL,0))) TOTAL_BUSINESS
FROM IPL.BUSINESS_STAT A WHERE TO_CHAR(RECPTDT,'YYYYMMDD') =TO_CHAR(SYSDATE,'YYYYMMDD')
GROUP BY prj_code,DECODE(A.PRJ_CODE,'01','POLASH','08','BOKUL','20','TAKAFUL-EKHLAS','09','METRO','04','IDPS','17','KRISHNACHURA','OTHERS')
UNION ALL
SELECT decode(prj_code,'05','05','24','05')  prj_code, 'PBPIB' PROJECT,
SUM(NVL(A.NEW_BUSINESS,0)) NEW_BUSINESS,SUM(NVL(A.DEFERRED,0)) DEFERRED,SUM(NVL(A.SING,0)) SING, SUM(NVL(NEW_BUSINESS,0)+NVL(DEFERRED,0)+NVL(SING,0)) AS TOTAL_FIRSTYEAR,ROUND(SUM(NVL(A.RENEWAL,0))) RENEWAL
,ROUND(SUM(NVL(NEW_BUSINESS,0)+NVL(DEFERRED,0)+NVL(SING,0)+ NVL(A.RENEWAL,0))) TOTAL_BUSINESS
FROM PBPIB.BUSINESS_STAT A WHERE TO_CHAR(RECPTDT,'YYYYMMDD') =TO_CHAR(SYSDATE,'YYYYMMDD') group by decode(prj_code,'05','05','24','05') 
) T, (SELECT prj_code,FY_MONTLY,REN_MONTLY FROM IPL.PI_HR_BSC_TERGET  where PRJ_CODE= CODE) b 
where T.PRJ_CODE=b.PRJ_CODE 
ORDER BY TOTAL_BUSINESS DESC";
}
else if(isset($_GET['btm']))
{
	$query_td_bus = "SELECT T.PROJECT,T.NEW_BUSINESS,T.DEFERRED,T.SING,T.TOTAL_FIRSTYEAR,T.RENEWAL,b.FY_MONTLY,b.REN_MONTLY FROM (
SELECT prj_code,DECODE(A.PRJ_CODE,'01','POLASH','08','BOKUL','20','TAKAFUL-EKHLAS','09','METRO','04','IDPS','17','KRISHNACHURA','OTHERS') PROJECT,
SUM(NVL(A.NEW_BUSINESS,0)) NEW_BUSINESS,SUM(NVL(A.DEFERRED,0)) DEFERRED,SUM(NVL(A.SING,0)) SING, SUM(NVL(NEW_BUSINESS,0)+NVL(DEFERRED,0)+NVL(SING,0)) AS TOTAL_FIRSTYEAR,ROUND(SUM(NVL(A.RENEWAL,0))) RENEWAL,
ROUND(SUM(NVL(NEW_BUSINESS,0)+NVL(DEFERRED,0)+NVL(SING,0)+ NVL(A.RENEWAL,0))) TOTAL_BUSINESS
FROM IPL.BUSINESS_STAT A WHERE BMON =TO_CHAR(SYSDATE,'YYYYMM')
GROUP BY prj_code,DECODE(A.PRJ_CODE,'01','POLASH','08','BOKUL','20','TAKAFUL-EKHLAS','09','METRO','04','IDPS','17','KRISHNACHURA','OTHERS')
UNION ALL
SELECT decode(prj_code,'05','05','24','05')  prj_code, 'PBPIB' PROJECT,
SUM(NVL(A.NEW_BUSINESS,0)) NEW_BUSINESS,SUM(NVL(A.DEFERRED,0)) DEFERRED,SUM(NVL(A.SING,0)) SING, SUM(NVL(NEW_BUSINESS,0)+NVL(DEFERRED,0)+NVL(SING,0)) AS TOTAL_FIRSTYEAR,ROUND(SUM(NVL(A.RENEWAL,0))) RENEWAL
,ROUND(SUM(NVL(NEW_BUSINESS,0)+NVL(DEFERRED,0)+NVL(SING,0)+ NVL(A.RENEWAL,0))) TOTAL_BUSINESS
FROM PBPIB.BUSINESS_STAT A WHERE BMON =TO_CHAR(SYSDATE,'YYYYMM') group by decode(prj_code,'05','05','24','05') 
) T, (SELECT prj_code,FY_MONTLY,REN_MONTLY FROM IPL.PI_HR_BSC_TERGET  where PRJ_CODE= CODE) b 
where T.PRJ_CODE=b.PRJ_CODE 
ORDER BY TOTAL_BUSINESS DESC";
}
else if(isset($_GET['blm']))
{
	$query_td_bus = "SELECT T.PROJECT,T.NEW_BUSINESS,T.DEFERRED,T.SING,T.TOTAL_FIRSTYEAR,T.RENEWAL,b.FY_MONTLY,b.REN_MONTLY FROM (
SELECT prj_code,DECODE(A.PRJ_CODE,'01','POLASH','08','BOKUL','20','TAKAFUL-EKHLAS','09','METRO','04','IDPS','17','KRISHNACHURA','OTHERS') PROJECT,
SUM(NVL(A.NEW_BUSINESS,0)) NEW_BUSINESS,SUM(NVL(A.DEFERRED,0)) DEFERRED,SUM(NVL(A.SING,0)) SING, SUM(NVL(NEW_BUSINESS,0)+NVL(DEFERRED,0)+NVL(SING,0)) AS TOTAL_FIRSTYEAR,ROUND(SUM(NVL(A.RENEWAL,0))) RENEWAL,
ROUND(SUM(NVL(NEW_BUSINESS,0)+NVL(DEFERRED,0)+NVL(SING,0)+ NVL(A.RENEWAL,0))) TOTAL_BUSINESS
FROM IPL.BUSINESS_STAT A WHERE BMON =ltrim(rtrim(to_char(add_months(trunc(sysdate),-1),'YYYYMM')))
GROUP BY prj_code,DECODE(A.PRJ_CODE,'01','POLASH','08','BOKUL','20','TAKAFUL-EKHLAS','09','METRO','04','IDPS','17','KRISHNACHURA','OTHERS')
UNION ALL
SELECT decode(prj_code,'05','05','24','05')  prj_code, 'PBPIB' PROJECT,
SUM(NVL(A.NEW_BUSINESS,0)) NEW_BUSINESS,SUM(NVL(A.DEFERRED,0)) DEFERRED,SUM(NVL(A.SING,0)) SING, SUM(NVL(NEW_BUSINESS,0)+NVL(DEFERRED,0)+NVL(SING,0)) AS TOTAL_FIRSTYEAR,ROUND(SUM(NVL(A.RENEWAL,0))) RENEWAL
,ROUND(SUM(NVL(NEW_BUSINESS,0)+NVL(DEFERRED,0)+NVL(SING,0)+ NVL(A.RENEWAL,0))) TOTAL_BUSINESS
FROM PBPIB.BUSINESS_STAT A WHERE BMON =ltrim(rtrim(to_char(add_months(trunc(sysdate),-1),'YYYYMM'))) group by decode(prj_code,'05','05','24','05') 
) T, (SELECT prj_code,FY_MONTLY,REN_MONTLY FROM IPL.PI_HR_BSC_TERGET  where PRJ_CODE= CODE) b 
where T.PRJ_CODE=b.PRJ_CODE 
ORDER BY TOTAL_BUSINESS DESC";
}
else if(isset($_GET['bty']))
{
	$query_td_bus = "SELECT T.PROJECT,T.NEW_BUSINESS,T.DEFERRED,T.SING,T.TOTAL_FIRSTYEAR,T.RENEWAL,b.FY_MONTLY*to_char(sysdate, 'mm'),b.REN_MONTLY*to_char(sysdate, 'mm') FROM (
SELECT prj_code,DECODE(A.PRJ_CODE,'01','POLASH','08','BOKUL','20','TAKAFUL-EKHLAS','09','METRO','04','IDPS','17','KRISHNACHURA','OTHERS') PROJECT,
SUM(NVL(A.NEW_BUSINESS,0)) NEW_BUSINESS,SUM(NVL(A.DEFERRED,0)) DEFERRED,SUM(NVL(A.SING,0)) SING, SUM(NVL(NEW_BUSINESS,0)+NVL(DEFERRED,0)+NVL(SING,0)) AS TOTAL_FIRSTYEAR,ROUND(SUM(NVL(A.RENEWAL,0))) RENEWAL,
ROUND(SUM(NVL(NEW_BUSINESS,0)+NVL(DEFERRED,0)+NVL(SING,0)+ NVL(A.RENEWAL,0))) TOTAL_BUSINESS
FROM IPL.BUSINESS_STAT A WHERE SUBSTR(BMON,0,4) =TO_CHAR(SYSDATE,'YYYY')
GROUP BY prj_code,DECODE(A.PRJ_CODE,'01','POLASH','08','BOKUL','20','TAKAFUL-EKHLAS','09','METRO','04','IDPS','17','KRISHNACHURA','OTHERS')
UNION ALL
SELECT decode(prj_code,'05','05','24','05')  prj_code, 'PBPIB' PROJECT,
SUM(NVL(A.NEW_BUSINESS,0)) NEW_BUSINESS,SUM(NVL(A.DEFERRED,0)) DEFERRED,SUM(NVL(A.SING,0)) SING, SUM(NVL(NEW_BUSINESS,0)+NVL(DEFERRED,0)+NVL(SING,0)) AS TOTAL_FIRSTYEAR,ROUND(SUM(NVL(A.RENEWAL,0))) RENEWAL
,ROUND(SUM(NVL(NEW_BUSINESS,0)+NVL(DEFERRED,0)+NVL(SING,0)+ NVL(A.RENEWAL,0))) TOTAL_BUSINESS
FROM PBPIB.BUSINESS_STAT A WHERE SUBSTR(BMON,0,4) =TO_CHAR(SYSDATE,'YYYY') group by decode(prj_code,'05','05','24','05') 
) T, (SELECT prj_code,FY_MONTLY,REN_MONTLY FROM IPL.PI_HR_BSC_TERGET  where PRJ_CODE= CODE) b 
where T.PRJ_CODE=b.PRJ_CODE 
ORDER BY TOTAL_BUSINESS DESC";
}

$stid_td_bus = OCIParse($conn, $query_td_bus);
OCIExecute($stid_td_bus); 
$newsum = 0;
$defsum = 0;
$sinsum = 0;
$fsysum = 0;
$renwsum = 0;
while($row_td_bus= oci_fetch_array($stid_td_bus))
{
$newsum += $row_td_bus[1];
$defsum += $row_td_bus[2];
$sinsum += $row_td_bus[3];
$fsysum += $row_td_bus[4];
$renwsum += $row_td_bus[5];
$item[]= "{name: '".$row_td_bus[0]."',y: ".$row_td_bus[1]."}, ";	
$def[]= "{name: '".$row_td_bus[0]."',y: ".$row_td_bus[2]."}, ";	
$sin[]= "{name: '".$row_td_bus[0]."',y: ".$row_td_bus[3]."}, ";	
$fsy[]= "{name: '".$row_td_bus[0]."',y: ".$row_td_bus[4]."}, ";	
$renw[]= "{name: '".$row_td_bus[0]."',y: ".$row_td_bus[5]."}, ";
$totl[]= "{name: '".$row_td_bus[0]."',y: ".($row_td_bus[5]+$row_td_bus[4])."}, ";
	?>
      <tr>
        <td><?php echo $row_td_bus[0];?></td>
        <td style="text-align: right;"><?php echo number_format((float)$row_td_bus[1]);?></td>
        <td style="text-align: right;"><?php echo number_format((float)$row_td_bus[2]);?></td>
        <td style="text-align: right;"><?php echo number_format((float)$row_td_bus[3]);?></td>
        <td style="text-align: right;"><?php echo number_format((float)$row_td_bus[4]);?></td>
        <td style="text-align: right;"><?php echo number_format((float)$row_td_bus[6]);?></td>
        <td style="text-align: right;"><?php echo number_format((float)($row_td_bus[4]*100/$row_td_bus[6]));?></td>
        <td style="text-align: right;"><?php echo number_format((float)$row_td_bus[5]);?></td>
        <td style="text-align: right;"><?php echo number_format((float)$row_td_bus[7]);?></td>
        <td style="text-align: right;"><?php echo number_format((float)($row_td_bus[5]*100/$row_td_bus[7]));?></td>
        <td style="text-align: right;"><?php echo number_format((float)($row_td_bus[5]+$row_td_bus[4]));?></td>
        <td style="text-align: right;"><?php echo number_format((float)$row_td_bus[6]+$row_td_bus[7]);?></td>
        <td style="text-align: right;"><?php echo number_format((float)($row_td_bus[5]+$row_td_bus[4])*100/((float)$row_td_bus[6]+$row_td_bus[7]));?></td>
      </tr>
	<?php }?>
	  <tr>
        <td><strong>Total</strong></td>
        <td style="text-align: right;"><strong><?php echo number_format((float)$newsum);?></strong></td>
        <td style="text-align: right;"><strong><?php echo number_format((float)$defsum);?></strong></td>
        <td style="text-align: right;"><strong><?php echo number_format((float)$sinsum);?></strong></td>
        <td style="text-align: right;"><strong><?php echo number_format((float)$fsysum);?></strong></td>
        <td style="text-align: right;"><strong></strong></td>
        <td style="text-align: right;"><strong></strong></td>
        <td style="text-align: right;"><strong><?php echo number_format((float)$renwsum);?></strong></td>
        <td style="text-align: right;"><strong></strong></td>
        <td style="text-align: right;"><strong></strong></td>
        <td style="text-align: right;"><strong><?php echo number_format((float)($fsysum+$renwsum));?></strong></td>
        <td style="text-align: right;"></td>
        <td style="text-align: right;"></td>
      </tr>
    </tbody>
  </table>
  

 <div class="row">
  <div class="col-sm-6" id="container"></div>
  <div class="col-sm-6" id="def"></div>
</div> 
  <div class="row">
  <div class="col-sm-6" id="sin"></div>
  <div class="col-sm-6" id="fsy"></div>
</div>

  <div class="row">
  <div class="col-sm-6" id="renw"></div>
  <div class="col-sm-6" id="totl"></div>
</div>

  <script type="text/javascript">

Highcharts.chart('container', {
    chart: {
        plotBackgroundColor: null,
        plotBorderWidth: null,
        plotShadow: false,
        type: 'pie'
    },
    title: {
        text: 'New Business'
    },
    tooltip: {
        pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
    },
    plotOptions: {
        pie: {
            allowPointSelect: true,
            cursor: 'pointer',
            dataLabels: {
                enabled: true,
                format: '<b>{point.name}</b>: {point.percentage:.1f} %',
                style: {
                    color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                }
            }
        }
    },
    series: [{
        name: 'Brands',
        colorByPoint: true,
        data: [
			 <?php
			for($x = 0; $x < count($item); $x++) {
				echo $item[$x];
			}
			?> 
		]
    }]
});

Highcharts.chart('def', {
    chart: {
        plotBackgroundColor: null,
        plotBorderWidth: null,
        plotShadow: false,
        type: 'pie'
    },
    title: {
        text: 'Deferred'
    },
    tooltip: {
        pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
    },
    plotOptions: {
        pie: {
            allowPointSelect: true,
            cursor: 'pointer',
            dataLabels: {
                enabled: true,
                format: '<b>{point.name}</b>: {point.percentage:.1f} %',
                style: {
                    color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                }
            }
        }
    },
    series: [{
        name: 'Brands',
        colorByPoint: true,
        data: [
			 <?php
			for($x = 0; $x < count($item); $x++) {
				echo $def[$x];
			}
			?> 
		]
    }]
});

Highcharts.chart('sin', {
    chart: {
        plotBackgroundColor: null,
        plotBorderWidth: null,
        plotShadow: false,
        type: 'pie'
    },
    title: {
        text: 'Single'
    },
    tooltip: {
        pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
    },
    plotOptions: {
        pie: {
            allowPointSelect: true,
            cursor: 'pointer',
            dataLabels: {
                enabled: true,
                format: '<b>{point.name}</b>: {point.percentage:.1f} %',
                style: {
                    color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                }
            }
        }
    },
    series: [{
        name: 'Brands',
        colorByPoint: true,
        data: [
			 <?php
			for($x = 0; $x < count($item); $x++) {
				echo $sin[$x];
			}
			?> 
		]
    }]
});


Highcharts.chart('fsy', {
    chart: {
        plotBackgroundColor: null,
        plotBorderWidth: null,
        plotShadow: false,
        type: 'pie'
    },
    title: {
        text: 'First Year'
    },
    tooltip: {
        pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
    },
    plotOptions: {
        pie: {
            allowPointSelect: true,
            cursor: 'pointer',
            dataLabels: {
                enabled: true,
                format: '<b>{point.name}</b>: {point.percentage:.1f} %',
                style: {
                    color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                }
            }
        }
    },
    series: [{
        name: 'Brands',
        colorByPoint: true,
        data: [
			 <?php
			for($x = 0; $x < count($item); $x++) {
				echo $fsy[$x];
			}
			?> 
		]
    }]
});

Highcharts.chart('renw', {
    chart: {
        plotBackgroundColor: null,
        plotBorderWidth: null,
        plotShadow: false,
        type: 'pie'
    },
    title: {
        text: 'Renewal'
    },
    tooltip: {
        pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
    },
    plotOptions: {
        pie: {
            allowPointSelect: true,
            cursor: 'pointer',
            dataLabels: {
                enabled: true,
                format: '<b>{point.name}</b>: {point.percentage:.1f} %',
                style: {
                    color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                }
            }
        }
    },
    series: [{
        name: 'Brands',
        colorByPoint: true,
        data: [
			 <?php
			for($x = 0; $x < count($item); $x++) {
				echo $renw[$x];
			}
			?> 
		]
    }]
});


Highcharts.chart('totl', {
    chart: {
        plotBackgroundColor: null,
        plotBorderWidth: null,
        plotShadow: false,
        type: 'pie'
    },
    title: {
        text: 'Total Business'
    },
    tooltip: {
        pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
    },
    plotOptions: {
        pie: {
            allowPointSelect: true,
            cursor: 'pointer',
            dataLabels: {
                enabled: true,
                format: '<b>{point.name}</b>: {point.percentage:.1f} %',
                style: {
                    color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                }
            }
        }
    },
    series: [{
        name: 'Brands',
        colorByPoint: true,
        data: [
			 <?php
			for($x = 0; $x < count($item); $x++) {
				echo $totl[$x];
			}
			?> 
		]
    }]
});
		</script>


</div>
  </div>
</div>  

