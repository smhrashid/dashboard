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
        
		<script src="<?php echo base_url();?>asset/code/modules/data.js"></script>
        <script src="<?php echo base_url();?>asset/code/modules/drilldown.js"></script>
<div class="row">
    <div class="box col-md-12">

        <div class="box-inner">
            <div class="box-header well" data-original-title="">
                <h2><i class="glyphicon glyphicon-home"></i> Commission (<?php echo $stat;?>)</h2>

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
        <th style="text-align: right;">First Year</th>
        <th style="text-align: right;">Renewal</th>
        <th style="text-align: right;">Other Allowance</th>
        <th style="text-align: right;">Target Bonus</th>
        <th style="text-align: right;">Renewal Conveyance</th>
        <th style="text-align: right;">Total</th>
      </tr>
    </thead>
    <tbody>
<?php
setlocale(LC_MONETARY, 'en_IN');
if(isset($_GET['btd']))
{
	$query_td_com = "SELECT * FROM (
SELECT 
DECODE(PRJ_CODE,'01','POLASH','08','BOKUL','20','TAKAFUL-EKHLAS','09','METRO','04','IDPS','17','KRISHNACHURA','OTHERS') PROJECT,PTYPE,SUM(COMM) COMM FROM(
SELECT CASE WHEN PRJ_CODE IN('01','08','05','24','04','20','09','17') 
THEN PRJ_CODE ELSE 'XX' END PRJ_CODE  ,BMON,PTYPE,ROUND(SUM(COMM),0)COMM FROM (
SELECT PRJ_CODE, TO_CHAR(B.TIMSTAMP,'YYYYMM')BMON, 'F' PTYPE, C10_11+C12_14+C15_19+C20_ABOVE+C_SING COMM FROM IPL.ORG_EARNING_IDRA B WHERE TO_CHAR(B.TIMSTAMP,'YYYYMM')=ltrim(rtrim(to_char(add_months(trunc(sysdate),-1),'YYYYMM'))) AND NVL(SND_COMM,0)+NVL(THRD_COMM,0)=0
UNION ALL
SELECT PRJ_CODE, TO_CHAR(TIMSTAMP,'YYYYMM')BMON, 'F' PTYPE, C10_11+C12_14+C15_19+C20_ABOVE+C_SING COMM FROM IPL.ORG_EARNING_IDRA_TEST B WHERE TO_CHAR(B.TIMSTAMP,'YYYYMM')=ltrim(rtrim(to_char(add_months(trunc(sysdate),-1),'YYYYMM'))) AND NVL(SND_COMM,0)+NVL(THRD_COMM,0)=0
UNION ALL
select prj_code,TO_CHAR(TIMSTAMP,'YYYYMM')BMON, 'F' PTYPE,C10_11+C12_14+C15_19+C20_ABOVE+C_SING COMM from ipl.org_earning_idra_IDPS WHERE  nvl(SND_PREM,0)+nvl(THRD_PREM,0)=0 AND STATUS='P' AND PRINT_STATUS='Y' AND TO_CHAR(TIMSTAMP,'YYYYMM')=ltrim(rtrim(to_char(add_months(trunc(sysdate),-1),'YYYYMM'))) AND ACC_NO IS NOT NULL AND PRJ_CODE='04'
UNION ALL
select prj_code,TO_CHAR(TIMSTAMP,'YYYYMM')BMON,'F' PTYPE,nvl(C10_11,0)+nvl(C12_14,0)+nvl(C15_19,0)+nvl(C20_above,0)+NVL(C_SING,0)+NVL(DEV_ALLOW,0) COMM  from PBPIB.ORG_EARNING_PBPIB where  nvl(SND_COMM,0)+nvl(THRD_COMM,0)=0AND TO_CHAR(TIMSTAMP,'YYYYMM')=ltrim(rtrim(to_char(add_months(trunc(sysdate),-1),'YYYYMM'))) AND rtrim(ACC_NO) IS NOT  NULL and prj_code in('05','24')
UNION ALL
select prj_code,TO_CHAR(TIMSTAMP,'YYYYMM')BMON,'F' PTYPE,nvl(C10_11,0)+nvl(C12_14,0)+nvl(C15_19,0)+nvl(C20_above,0)+NVL(C_SING,0)+NVL(OTHER_ALLOW,0) COMM  from PBPIB.SPB_ORG_EARNING_PBPIB   where nvl(SND_PREM,0)+nvl(THRD_PREM,0)=0   AND TO_CHAR(TIMSTAMP,'YYYYMM')=ltrim(rtrim(to_char(add_months(trunc(sysdate),-1),'YYYYMM'))) AND rtrim(ACC_NO) IS NOT  NULL and prj_code in('05','24')
UNION ALL
SELECT PRJ_CODE,TO_CHAR(B.TIMSTAMP,'YYYYMM')BMON,'R' PTYPE, NVL(SND_COMM,0)+NVL(THRD_COMM,0) RENCOMM FROM IPL.ORG_EARNING_IDRA B WHERE TO_CHAR(B.TIMSTAMP,'YYYYMM')=ltrim(rtrim(to_char(add_months(trunc(sysdate),-1),'YYYYMM'))) AND C10_11+C12_14+C15_19+C20_ABOVE+C_SING=0
UNION ALL
SELECT PRJ_CODE,TO_CHAR(B.TIMSTAMP,'YYYYMM')BMON,'R' PTYPE, NVL(SND_COMM,0)+NVL(THRD_COMM,0) RENCOMM FROM IPL.ORG_EARNING_IDRA_TEST B WHERE TO_CHAR(B.TIMSTAMP,'YYYYMM')=ltrim(rtrim(to_char(add_months(trunc(sysdate),-1),'YYYYMM'))) AND C10_11+C12_14+C15_19+C20_ABOVE+C_SING=0
UNION ALL
select prj_code,TO_CHAR(TIMSTAMP,'YYYYMM')BMON,'R' PTYPE,nvl(SND_COMM,0)+nvl(thrd_comm,0) COMM from ipl.org_earning_ren where  nvl(C10_11,0)+nvl(C12_14,0)+nvl(C15_19,0)+nvl(C20_above,0)+nvl(C_sing,0)=0 AND TO_CHAR(TIMSTAMP,'YYYYMM')=ltrim(rtrim(to_char(add_months(trunc(sysdate),-1),'YYYYMM'))) and ACC_NO IS NOT NULL AND PRINT_STATUS='Y' AND PRJ_CODE='04'
UNION ALL
select prj_code,TO_CHAR(TIMSTAMP,'YYYYMM')BMON,'R'PTYPE,ROUND(nvl(SND_COMM,0)+nvl(thrd_comm,0),0)COMM  from PBPIB.ORG_EARNING_PBPIB_REN where nvl(t10_11,0)+nvl(t12_14,0)+nvl(t15_19,0)+nvl(t20_above,0)+nvl(sing,0)=0  AND TO_CHAR(TIMSTAMP,'YYYYMM')=ltrim(rtrim(to_char(add_months(trunc(sysdate),-1),'YYYYMM'))) AND rtrim(ACC_NO) IS NOT  NULL and prj_code in('05','24')
UNION ALL
SELECT PRJ_CODE,TO_CHAR(BMON),PTYPE,BONUS FROM IPL.DEV_EXPENSE B WHERE BMON=ltrim(rtrim(to_char(add_months(trunc(sysdate),-1),'YYYYMM'))) AND LTRIM(RTRIM(PTYPE)) IN('RC','OA','TB')
) GROUP BY CASE WHEN PRJ_CODE IN('01','08','05','24','04','20','09','17') THEN PRJ_CODE ELSE 'XX' END,BMON,PTYPE
) GROUP BY PRJ_CODE,BMON,PTYPE ORDER BY PTYPE asc
) PIVOT
( SUM(COMM)
  FOR (PTYPE) IN ('F' as fyp,'R','OA','TB','RC') 
) order by fyp desc";
}
else if(isset($_GET['btm']))
{
	$query_td_com = "SELECT * FROM (
SELECT 
DECODE(PRJ_CODE,'01','POLASH','08','BOKUL','20','TAKAFUL-EKHLAS','09','METRO','04','IDPS','17','KRISHNACHURA','OTHERS') PROJECT,PTYPE,SUM(COMM) COMM FROM(
SELECT CASE WHEN PRJ_CODE IN('01','08','05','24','04','20','09','17') 
THEN PRJ_CODE ELSE 'XX' END PRJ_CODE  ,BMON,PTYPE,ROUND(SUM(COMM),0)COMM FROM (
SELECT PRJ_CODE, TO_CHAR(B.TIMSTAMP,'YYYYMM')BMON, 'F' PTYPE, C10_11+C12_14+C15_19+C20_ABOVE+C_SING COMM FROM IPL.ORG_EARNING_IDRA B WHERE TO_CHAR(B.TIMSTAMP,'YYYYMM')=TO_CHAR(SYSDATE, 'YYYYMM') AND NVL(SND_COMM,0)+NVL(THRD_COMM,0)=0
UNION ALL
SELECT PRJ_CODE, TO_CHAR(TIMSTAMP,'YYYYMM')BMON, 'F' PTYPE, C10_11+C12_14+C15_19+C20_ABOVE+C_SING COMM FROM IPL.ORG_EARNING_IDRA_TEST B WHERE TO_CHAR(B.TIMSTAMP,'YYYYMM')=TO_CHAR(SYSDATE, 'YYYYMM') AND NVL(SND_COMM,0)+NVL(THRD_COMM,0)=0
UNION ALL
select prj_code,TO_CHAR(TIMSTAMP,'YYYYMM')BMON, 'F' PTYPE,C10_11+C12_14+C15_19+C20_ABOVE+C_SING COMM from ipl.org_earning_idra_IDPS WHERE  nvl(SND_PREM,0)+nvl(THRD_PREM,0)=0 AND STATUS='P' AND PRINT_STATUS='Y' AND TO_CHAR(TIMSTAMP,'YYYYMM')=TO_CHAR(SYSDATE, 'YYYYMM') AND ACC_NO IS NOT NULL AND PRJ_CODE='04'
UNION ALL
select prj_code,TO_CHAR(TIMSTAMP,'YYYYMM')BMON,'F' PTYPE,nvl(C10_11,0)+nvl(C12_14,0)+nvl(C15_19,0)+nvl(C20_above,0)+NVL(C_SING,0)+NVL(DEV_ALLOW,0) COMM  from PBPIB.ORG_EARNING_PBPIB where  nvl(SND_COMM,0)+nvl(THRD_COMM,0)=0AND TO_CHAR(TIMSTAMP,'YYYYMM')=TO_CHAR(SYSDATE, 'YYYYMM') AND rtrim(ACC_NO) IS NOT  NULL and prj_code in('05','24')
UNION ALL
select prj_code,TO_CHAR(TIMSTAMP,'YYYYMM')BMON,'F' PTYPE,nvl(C10_11,0)+nvl(C12_14,0)+nvl(C15_19,0)+nvl(C20_above,0)+NVL(C_SING,0)+NVL(OTHER_ALLOW,0) COMM  from PBPIB.SPB_ORG_EARNING_PBPIB   where nvl(SND_PREM,0)+nvl(THRD_PREM,0)=0   AND TO_CHAR(TIMSTAMP,'YYYYMM')=TO_CHAR(SYSDATE, 'YYYYMM')   AND rtrim(ACC_NO) IS NOT  NULL and prj_code in('05','24')
UNION ALL
SELECT PRJ_CODE,TO_CHAR(B.TIMSTAMP,'YYYYMM')BMON,'R' PTYPE, NVL(SND_COMM,0)+NVL(THRD_COMM,0) RENCOMM FROM IPL.ORG_EARNING_IDRA B WHERE TO_CHAR(B.TIMSTAMP,'YYYYMM')=TO_CHAR(SYSDATE, 'YYYYMM') AND C10_11+C12_14+C15_19+C20_ABOVE+C_SING=0
UNION ALL
SELECT PRJ_CODE,TO_CHAR(B.TIMSTAMP,'YYYYMM')BMON,'R' PTYPE, NVL(SND_COMM,0)+NVL(THRD_COMM,0) RENCOMM FROM IPL.ORG_EARNING_IDRA_TEST B WHERE TO_CHAR(B.TIMSTAMP,'YYYYMM')=TO_CHAR(SYSDATE, 'YYYYMM') AND C10_11+C12_14+C15_19+C20_ABOVE+C_SING=0
UNION ALL
select prj_code,TO_CHAR(TIMSTAMP,'YYYYMM')BMON,'R' PTYPE,nvl(SND_COMM,0)+nvl(thrd_comm,0) COMM from ipl.org_earning_ren where  nvl(C10_11,0)+nvl(C12_14,0)+nvl(C15_19,0)+nvl(C20_above,0)+nvl(C_sing,0)=0 AND TO_CHAR(TIMSTAMP,'YYYYMM')=TO_CHAR(SYSDATE, 'YYYYMM') and ACC_NO IS NOT NULL AND PRINT_STATUS='Y' AND PRJ_CODE='04'
UNION ALL
select prj_code,TO_CHAR(TIMSTAMP,'YYYYMM')BMON,'R'PTYPE,ROUND(nvl(SND_COMM,0)+nvl(thrd_comm,0),0)COMM  from PBPIB.ORG_EARNING_PBPIB_REN where nvl(t10_11,0)+nvl(t12_14,0)+nvl(t15_19,0)+nvl(t20_above,0)+nvl(sing,0)=0  AND TO_CHAR(TIMSTAMP,'YYYYMM')=TO_CHAR(SYSDATE, 'YYYYMM')   AND rtrim(ACC_NO) IS NOT  NULL and prj_code in('05','24')
UNION ALL
SELECT PRJ_CODE,TO_CHAR(BMON),PTYPE,BONUS FROM IPL.DEV_EXPENSE B WHERE BMON=TO_CHAR(SYSDATE, 'YYYYMM') AND LTRIM(RTRIM(PTYPE)) IN('RC','OA','TB')
) GROUP BY CASE WHEN PRJ_CODE IN('01','08','05','24','04','20','09','17') THEN PRJ_CODE ELSE 'XX' END,BMON,PTYPE
) GROUP BY PRJ_CODE,BMON,PTYPE ORDER BY PRJ_CODE
) PIVOT
( SUM(COMM)
  FOR (PTYPE) IN ('F' fyp,'R','OA','TB','RC')
) order by fyp desc";
}
else if(isset($_GET['blm']))
{
	$query_td_com = "SELECT * FROM (
SELECT 
DECODE(PRJ_CODE,'01','POLASH','08','BOKUL','20','TAKAFUL-EKHLAS','09','METRO','04','IDPS','17','KRISHNACHURA','OTHERS') PROJECT,PTYPE,SUM(COMM) COMM FROM(
SELECT CASE WHEN PRJ_CODE IN('01','08','05','24','04','20','09','17') 
THEN PRJ_CODE ELSE 'XX' END PRJ_CODE  ,BMON,PTYPE,ROUND(SUM(COMM),0)COMM FROM (
SELECT PRJ_CODE, TO_CHAR(B.TIMSTAMP,'YYYYMM')BMON, 'F' PTYPE, C10_11+C12_14+C15_19+C20_ABOVE+C_SING COMM FROM IPL.ORG_EARNING_IDRA B WHERE TO_CHAR(B.TIMSTAMP,'YYYYMM')=ltrim(rtrim(to_char(add_months(trunc(sysdate),-1),'YYYYMM'))) AND NVL(SND_COMM,0)+NVL(THRD_COMM,0)=0
UNION ALL
SELECT PRJ_CODE, TO_CHAR(TIMSTAMP,'YYYYMM')BMON, 'F' PTYPE, C10_11+C12_14+C15_19+C20_ABOVE+C_SING COMM FROM IPL.ORG_EARNING_IDRA_TEST B WHERE TO_CHAR(B.TIMSTAMP,'YYYYMM')=ltrim(rtrim(to_char(add_months(trunc(sysdate),-1),'YYYYMM'))) AND NVL(SND_COMM,0)+NVL(THRD_COMM,0)=0
UNION ALL
select prj_code,TO_CHAR(TIMSTAMP,'YYYYMM')BMON, 'F' PTYPE,C10_11+C12_14+C15_19+C20_ABOVE+C_SING COMM from ipl.org_earning_idra_IDPS WHERE  nvl(SND_PREM,0)+nvl(THRD_PREM,0)=0 AND STATUS='P' AND PRINT_STATUS='Y' AND TO_CHAR(TIMSTAMP,'YYYYMM')=ltrim(rtrim(to_char(add_months(trunc(sysdate),-1),'YYYYMM'))) AND ACC_NO IS NOT NULL AND PRJ_CODE='04'
UNION ALL
select prj_code,TO_CHAR(TIMSTAMP,'YYYYMM')BMON,'F' PTYPE,nvl(C10_11,0)+nvl(C12_14,0)+nvl(C15_19,0)+nvl(C20_above,0)+NVL(C_SING,0)+NVL(DEV_ALLOW,0) COMM  from PBPIB.ORG_EARNING_PBPIB where  nvl(SND_COMM,0)+nvl(THRD_COMM,0)=0AND TO_CHAR(TIMSTAMP,'YYYYMM')=ltrim(rtrim(to_char(add_months(trunc(sysdate),-1),'YYYYMM'))) AND rtrim(ACC_NO) IS NOT  NULL and prj_code in('05','24')
UNION ALL
select prj_code,TO_CHAR(TIMSTAMP,'YYYYMM')BMON,'F' PTYPE,nvl(C10_11,0)+nvl(C12_14,0)+nvl(C15_19,0)+nvl(C20_above,0)+NVL(C_SING,0)+NVL(OTHER_ALLOW,0) COMM  from PBPIB.SPB_ORG_EARNING_PBPIB   where nvl(SND_PREM,0)+nvl(THRD_PREM,0)=0   AND TO_CHAR(TIMSTAMP,'YYYYMM')=ltrim(rtrim(to_char(add_months(trunc(sysdate),-1),'YYYYMM'))) AND rtrim(ACC_NO) IS NOT  NULL and prj_code in('05','24')
UNION ALL
SELECT PRJ_CODE,TO_CHAR(B.TIMSTAMP,'YYYYMM')BMON,'R' PTYPE, NVL(SND_COMM,0)+NVL(THRD_COMM,0) RENCOMM FROM IPL.ORG_EARNING_IDRA B WHERE TO_CHAR(B.TIMSTAMP,'YYYYMM')=ltrim(rtrim(to_char(add_months(trunc(sysdate),-1),'YYYYMM'))) AND C10_11+C12_14+C15_19+C20_ABOVE+C_SING=0
UNION ALL
SELECT PRJ_CODE,TO_CHAR(B.TIMSTAMP,'YYYYMM')BMON,'R' PTYPE, NVL(SND_COMM,0)+NVL(THRD_COMM,0) RENCOMM FROM IPL.ORG_EARNING_IDRA_TEST B WHERE TO_CHAR(B.TIMSTAMP,'YYYYMM')=ltrim(rtrim(to_char(add_months(trunc(sysdate),-1),'YYYYMM'))) AND C10_11+C12_14+C15_19+C20_ABOVE+C_SING=0
UNION ALL
select prj_code,TO_CHAR(TIMSTAMP,'YYYYMM')BMON,'R' PTYPE,nvl(SND_COMM,0)+nvl(thrd_comm,0) COMM from ipl.org_earning_ren where  nvl(C10_11,0)+nvl(C12_14,0)+nvl(C15_19,0)+nvl(C20_above,0)+nvl(C_sing,0)=0 AND TO_CHAR(TIMSTAMP,'YYYYMM')=ltrim(rtrim(to_char(add_months(trunc(sysdate),-1),'YYYYMM'))) and ACC_NO IS NOT NULL AND PRINT_STATUS='Y' AND PRJ_CODE='04'
UNION ALL
select prj_code,TO_CHAR(TIMSTAMP,'YYYYMM')BMON,'R'PTYPE,ROUND(nvl(SND_COMM,0)+nvl(thrd_comm,0),0)COMM  from PBPIB.ORG_EARNING_PBPIB_REN where nvl(t10_11,0)+nvl(t12_14,0)+nvl(t15_19,0)+nvl(t20_above,0)+nvl(sing,0)=0  AND TO_CHAR(TIMSTAMP,'YYYYMM')=ltrim(rtrim(to_char(add_months(trunc(sysdate),-1),'YYYYMM'))) AND rtrim(ACC_NO) IS NOT  NULL and prj_code in('05','24')
UNION ALL
SELECT PRJ_CODE,TO_CHAR(BMON),PTYPE,BONUS FROM IPL.DEV_EXPENSE B WHERE BMON=ltrim(rtrim(to_char(add_months(trunc(sysdate),-1),'YYYYMM'))) AND LTRIM(RTRIM(PTYPE)) IN('RC','OA','TB')
) GROUP BY CASE WHEN PRJ_CODE IN('01','08','05','24','04','20','09','17') THEN PRJ_CODE ELSE 'XX' END,BMON,PTYPE
) GROUP BY PRJ_CODE,BMON,PTYPE ORDER BY PTYPE asc
) PIVOT
( SUM(COMM)
  FOR (PTYPE) IN ('F' as fyp,'R','OA','TB','RC') 
) order by fyp desc";
}
else if(isset($_GET['bty']))
{
	$query_td_com = "SELECT * FROM (
SELECT 
DECODE(PRJ_CODE,'01','POLASH','08','BOKUL','20','TAKAFUL-EKHLAS','09','METRO','04','IDPS','17','KRISHNACHURA','OTHERS') PROJECT,PTYPE,SUM(COMM) COMM FROM(
SELECT CASE WHEN PRJ_CODE IN('01','08','05','24','04','20','09','17') 
THEN PRJ_CODE ELSE 'XX' END PRJ_CODE  ,BMON,PTYPE,ROUND(SUM(COMM),0)COMM FROM (
SELECT PRJ_CODE, TO_CHAR(B.TIMSTAMP,'YYYYMM')BMON, 'F' PTYPE, C10_11+C12_14+C15_19+C20_ABOVE+C_SING COMM FROM IPL.ORG_EARNING_IDRA B WHERE TO_CHAR(B.TIMSTAMP,'YYYYMM')=TO_CHAR(SYSDATE, 'YYYYMM') AND NVL(SND_COMM,0)+NVL(THRD_COMM,0)=0
UNION ALL
SELECT PRJ_CODE, TO_CHAR(TIMSTAMP,'YYYYMM')BMON, 'F' PTYPE, C10_11+C12_14+C15_19+C20_ABOVE+C_SING COMM FROM IPL.ORG_EARNING_IDRA_TEST B WHERE TO_CHAR(B.TIMSTAMP,'YYYYMM')=TO_CHAR(SYSDATE, 'YYYYMM') AND NVL(SND_COMM,0)+NVL(THRD_COMM,0)=0
UNION ALL
select prj_code,TO_CHAR(TIMSTAMP,'YYYYMM')BMON, 'F' PTYPE,C10_11+C12_14+C15_19+C20_ABOVE+C_SING COMM from ipl.org_earning_idra_IDPS WHERE  nvl(SND_PREM,0)+nvl(THRD_PREM,0)=0 AND STATUS='P' AND PRINT_STATUS='Y' AND TO_CHAR(TIMSTAMP,'YYYYMM')=TO_CHAR(SYSDATE, 'YYYYMM') AND ACC_NO IS NOT NULL AND PRJ_CODE='04'
UNION ALL
select prj_code,TO_CHAR(TIMSTAMP,'YYYYMM')BMON,'F' PTYPE,nvl(C10_11,0)+nvl(C12_14,0)+nvl(C15_19,0)+nvl(C20_above,0)+NVL(C_SING,0)+NVL(DEV_ALLOW,0) COMM  from PBPIB.ORG_EARNING_PBPIB where  nvl(SND_COMM,0)+nvl(THRD_COMM,0)=0AND TO_CHAR(TIMSTAMP,'YYYYMM')=TO_CHAR(SYSDATE, 'YYYYMM') AND rtrim(ACC_NO) IS NOT  NULL and prj_code in('05','24')
UNION ALL
select prj_code,TO_CHAR(TIMSTAMP,'YYYYMM')BMON,'F' PTYPE,nvl(C10_11,0)+nvl(C12_14,0)+nvl(C15_19,0)+nvl(C20_above,0)+NVL(C_SING,0)+NVL(OTHER_ALLOW,0) COMM  from PBPIB.SPB_ORG_EARNING_PBPIB   where nvl(SND_PREM,0)+nvl(THRD_PREM,0)=0   AND TO_CHAR(TIMSTAMP,'YYYYMM')=TO_CHAR(SYSDATE, 'YYYYMM')   AND rtrim(ACC_NO) IS NOT  NULL and prj_code in('05','24')
UNION ALL
SELECT PRJ_CODE,TO_CHAR(B.TIMSTAMP,'YYYYMM')BMON,'R' PTYPE, NVL(SND_COMM,0)+NVL(THRD_COMM,0) RENCOMM FROM IPL.ORG_EARNING_IDRA B WHERE TO_CHAR(B.TIMSTAMP,'YYYYMM')=TO_CHAR(SYSDATE, 'YYYYMM') AND C10_11+C12_14+C15_19+C20_ABOVE+C_SING=0
UNION ALL
SELECT PRJ_CODE,TO_CHAR(B.TIMSTAMP,'YYYYMM')BMON,'R' PTYPE, NVL(SND_COMM,0)+NVL(THRD_COMM,0) RENCOMM FROM IPL.ORG_EARNING_IDRA_TEST B WHERE TO_CHAR(B.TIMSTAMP,'YYYYMM')=TO_CHAR(SYSDATE, 'YYYYMM') AND C10_11+C12_14+C15_19+C20_ABOVE+C_SING=0
UNION ALL
select prj_code,TO_CHAR(TIMSTAMP,'YYYYMM')BMON,'R' PTYPE,nvl(SND_COMM,0)+nvl(thrd_comm,0) COMM from ipl.org_earning_ren where  nvl(C10_11,0)+nvl(C12_14,0)+nvl(C15_19,0)+nvl(C20_above,0)+nvl(C_sing,0)=0 AND TO_CHAR(TIMSTAMP,'YYYYMM')=TO_CHAR(SYSDATE, 'YYYYMM') and ACC_NO IS NOT NULL AND PRINT_STATUS='Y' AND PRJ_CODE='04'
UNION ALL
select prj_code,TO_CHAR(TIMSTAMP,'YYYYMM')BMON,'R'PTYPE,ROUND(nvl(SND_COMM,0)+nvl(thrd_comm,0),0)COMM  from PBPIB.ORG_EARNING_PBPIB_REN where nvl(t10_11,0)+nvl(t12_14,0)+nvl(t15_19,0)+nvl(t20_above,0)+nvl(sing,0)=0  AND TO_CHAR(TIMSTAMP,'YYYYMM')=TO_CHAR(SYSDATE, 'YYYYMM')   AND rtrim(ACC_NO) IS NOT  NULL and prj_code in('05','24')
UNION ALL
SELECT PRJ_CODE,TO_CHAR(BMON),PTYPE,BONUS FROM IPL.DEV_EXPENSE B WHERE BMON=TO_CHAR(SYSDATE, 'YYYYMM') AND LTRIM(RTRIM(PTYPE)) IN('RC','OA','TB')
) GROUP BY CASE WHEN PRJ_CODE IN('01','08','05','24','04','20','09','17') THEN PRJ_CODE ELSE 'XX' END,BMON,PTYPE
) GROUP BY PRJ_CODE,BMON,PTYPE ORDER BY PRJ_CODE
) PIVOT
( SUM(COMM)
  FOR (PTYPE) IN ('F','R','OA','TB','RC')
)";
}

$stid_td_com = OCIParse($conn, $query_td_com);
OCIExecute($stid_td_com); 
$fysum = 0;
$rensum = 0;
$oasum = 0;
$tbsum = 0;
$rcsum = 0;
while($row_td_com= oci_fetch_array($stid_td_com))
{
$fysum += $row_td_com[1];
$rensum += $row_td_com[2];
$oasum += $row_td_com[3];
$tbsum += $row_td_com[4];
$rcsum += $row_td_com[5];
$item[]= "{'name': '".$row_td_com[0]."','y': ".($row_td_com[1]+$row_td_com[2]+$row_td_com[3]+$row_td_com[4]+$row_td_com[5]).",'drilldown': '".$row_td_com[0]."'},";	
$det[]="{'name': '".$row_td_com[0]."','id': '".$row_td_com[0]."','data': [['First Year',".$row_td_com[1]."],['Renewal',".$row_td_com[2]."],['Other Allowance',".$row_td_com[3]."],['Target Bonus',".$row_td_com[4]."],['Renewal Conveyance',".$row_td_com[5]."]]},";


	?>
      <tr>
        <td><?php echo $row_td_com[0];?></td>
        <td style="text-align: right;"><?php echo number_format((float)$row_td_com[1]);?></td>
        <td style="text-align: right;"><?php echo number_format((float)$row_td_com[2]);?></td>
        <td style="text-align: right;"><?php echo number_format((float)$row_td_com[3]);?></td>
        <td style="text-align: right;"><?php echo number_format((float)$row_td_com[4]);?></td>
        <td style="text-align: right;"><?php echo number_format((float)$row_td_com[5]);?></td>
        <td style="text-align: right;"><?php echo number_format((float)($row_td_com[1]+$row_td_com[2]+$row_td_com[3]+$row_td_com[4]+$row_td_com[5]));?></td>
      </tr>
	<?php }?>
	  <tr>
        <td><strong>Total</strong></td>
        <td style="text-align: right;"><strong><?php echo number_format((float)$fysum);?></strong></td>
        <td style="text-align: right;"><strong><?php echo number_format((float)$rensum);?></strong></td>
        <td style="text-align: right;"><strong><?php echo number_format((float)$oasum);?></strong></td>
        <td style="text-align: right;"><strong><?php echo number_format((float)$tbsum);?></strong></td>
        <td style="text-align: right;"><strong><?php echo number_format((float)$rcsum);?></strong></td>
        <td style="text-align: right;"><strong><?php echo number_format((float)($fysum+$rensum+$oasum+$tbsum+$rcsum));?></strong></td>
      </tr>
    </tbody>
  </table>
  

 <div id="container" style="min-width: 310px; height: 400px; margin: 0 auto"></div>


		<script type="text/javascript">

// Create the chart
Highcharts.chart('container', {
    chart: {
        type: 'column'
    },
    title: {
        text: ''
    },
    subtitle: {
        text: 'Click the columns to view details'
    },
    xAxis: {
        type: 'category'
    },
    yAxis: {
        title: {
            text: ' '
        }

    },
    legend: {
        enabled: false
    },
    plotOptions: {
        series: {
            borderWidth: 0,
            dataLabels: {
                enabled: true,
                format: '{point.y:.1f}'
            }
        }
    },

    tooltip: {
        headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
        pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:.2f}</b> of total<br/>'
    },

    "series": [
        {
            "name": "Total Business",
            "colorByPoint": true,
            "data": [
            <?php
			for($x = 0; $x < count($item); $x++) {
				echo $item[$x];
			}
			?> 
            ]
        }
    ],
    "drilldown": {
        "series": [
		
            <?php
			for($x = 0; $x < count($item); $x++) {
				echo $det[$x];
			}
			?> 
					
            
        ]
    }
});
		</script>
		
  </div>
</div>  

