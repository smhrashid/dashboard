
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
   


<form action="codekpi" method="post">
 <div class="row">
  <div class="col-sm-3">  
<input name="fdate" class="datepicker-here" data-language="en" data-min-view="months" data-view="months" data-date-format="MM yyyy" type="text" required="required">
</div>
  <div class="col-sm-3">
<input name="tdate"  class="datepicker-here" data-language="en" data-min-view="months" data-view="months" data-date-format="MM yyyy" type="text" required="required">
  </div>
  <div class="col-sm-3">
    <input name="kpicode"  required="required">
  </div>
  <div class="col-sm-3">
  <button class="btn-u btn-u-green" type="submit" name="pinsubmit" value="submit" style="height: 38px; width:255px;">Submit</button>
  </div>
</div> 
</form>
  <?php 
        if(isset($_POST['pinsubmit'])) {
			$fdate= $_POST['fdate'];
			$tdate= $_POST['tdate'];
			$kcode=$_POST['kpicode'];
                        
			$frdate=date('Ym', strtotime($fdate));
			$todate=date('Ym', strtotime($tdate));
                      //  echo $frdate.'<br>'.$todate.'<br>'.$kcode;
			$fytar=0;
			$rentar=0;
			$type=0;
			
			$prevfysum=0;
			$presfysum=0;
			$prevrensum=0;
			$presrensum=0;
		
			$min_date = min((strtotime(date('Y-m', strtotime($fdate)))), (strtotime(date('Y-m', strtotime($tdate)))));
			$max_date = max((strtotime(date('Y-m', strtotime($fdate)))), (strtotime(date('Y-m', strtotime($tdate)))));
			$i = 0;
			while (($min_date = strtotime("+1 MONTH", $min_date)) <= $max_date) {
				$i++;
			}
			$monthdef=$i+1;
			
			$d=cal_days_in_month(CAL_GREGORIAN,(substr($todate,-2)),(substr($todate,0,4)));
			$pardate= $d.(substr($todate,-2)).(substr($todate,0,4));
                        
                        
			//------------------------------------------------------------------------Active FA for PB HR-----------------------------------------------------------------------
			$query_afa_pb_hr="select count(distinct fa) active_fa

							from 
							
							(
							
							select code,fa,name,sum(policy_count) policy_count,sum(commission) commission
							
							from
							
							(
							
							select d.code,a.oc1 fa,c.name,count(distinct policy)as policy_count, sum(nvl(TOTPAID,0))as amount,
							
							(select sum(nvl(C10_11,0)+nvl(C12_14,0)+nvl(C15_19,0)+nvl(C20_ABOVE,0)+nvl(C_SING,0)) as commission from PBPIB.ORG_EARNING_PBPIB b
							
							where a.oc1=b.code and bmon between '$frdate' and '$todate' )as commission  from PBPIB.pb_policy a,pbpib.pb_organiser c,IT.HR_STAFF_PROJECT_DETAILS d
							
							where  a.oc1=c.code and a.oc4=d.oc1
							
							and to_char(a.DATCOM,'YYYYMM') between '$frdate' and '$todate'
							
							group by a.oc1,c.name,d.code
							
							union all
							
							select d.code,a.oc1 fa,c.name,count(distinct policy)as policy_count, sum(nvl(TOTPAID,0))as amount,
							
							(select sum(nvl(C10_11,0)+nvl(C12_14,0)+nvl(C15_19,0)+nvl(C20_ABOVE,0)+nvl(C_SING,0)) as commission from PBPIB.SPB_ORG_EARNING_PBPIB b
							
							where a.oc1=b.code and bmon between '$frdate' and '$todate' )as commission  from PBPIB.pb_policy a,pbpib.pb_organiser c,IT.HR_STAFF_PROJECT_DETAILS d
							
							where  a.oc1=c.code and a.oc4=d.oc1
							
							and to_char(a.DATCOM,'YYYYMM') between '$frdate' and '$todate'
							
							group by a.oc1,c.name,d.code
							
							)
							
							group by code,fa,name
							
							having sum(policy_count)>=11 and sum(commission) >= 20000
							
							) A,IT.HR_STAFF_PROJECT_DETAILS D
							
							where a.code = d.code and d.code = '$kcode'";
			
			//------------------------------------------------------------------------Active FA for PB PI-----------------------------------------------------------------------
			$query_afa_pb_pi="select count(*) from
								(select oc1,c.name,count(distinct policy)as policy_count , sum(nvl(TOTPAID,0))as amount ,(select  sum(nvl(TOTCOMM,0)) as commission from  pbpib.ORG_EARNING_PBPIB b
								  where a.oc1=b.code and bmon between '$frdate' and '$todate')as commission  from pbpib.pb_policy a,pbpib.pb_organiser c
								  where a.oc1=c.code
								  and to_char(DATCOM,'YYYYMM') between '$frdate' and '$todate'
								  group by oc1,c.name
								  having count(distinct policy)>=11 and (select  sum(nvl(TOTCOMM,0)) as commission from  pbpib.ORG_EARNING_PBPIB b
								  where a.oc1=b.code and bmon between '$frdate' and '$todate') >=20000)";			
			
			//------------------------------------------------------------------------Active FA for ALL HR-----------------------------------------------------------------------
			$query_afa_all_hr="select count(distinct fa) active_fa

								from 
								
								(
								
								select d.code,a.oc1 fa,c.name,count(distinct policy)as policy_count,
								
								(select  sum(nvl(C10_11,0)+nvl(C12_14,0)+nvl(C15_19,0)+nvl(C20_ABOVE,0)+nvl(C_SING,0)) as commission from  ipl.ORG_EARNING_IDRA b
								
								where a.oc1=b.code and bmon between '$frdate' and '$todate' )as commission  from IPL.policy a,ipl.organiser_ipl c,IT.HR_STAFF_PROJECT_DETAILS d
								
								where  a.oc1=c.code and a.oc7=d.oc1
								
								and to_char(a.DATCOM,'YYYYMM') between '$frdate' and '$todate'
								
								group by a.oc1,c.name,d.code
								
								having count(distinct policy)>=11 and
								
								(select sum(nvl(C10_11,0)+nvl(C12_14,0)+nvl(C15_19,0)+nvl(C20_ABOVE,0)+nvl(C_SING,0)) as commission 
								
								from  ipl.ORG_EARNING_IDRA b
								
								where a.oc1=b.code and bmon between '$frdate' and '$todate') >=20000
								
								) A,IT.HR_STAFF_PROJECT_DETAILS D
								
								where a.code = d.code and d.code = '$kcode'";	
			//------------------------------------------------------------------------Active FA for ALL PI-----------------------------------------------------------------------
			$query_afa_all_pi="select count(*) from
								(select oc1,c.name,count(distinct policy)as policy_count , sum(nvl(TOTPAID,0))as amount ,(select  sum(nvl(TOTCOMM,0)) as commission from  ipl.ORG_EARNING_IDRA b
								  where a.oc1=b.code and bmon between '$frdate' and '$todate' )as commission  from IPL.policy a,ipl.organiser_ipl c
								  where a.oc1=c.code
								  and to_char(DATCOM,'YYYYMM') between '$frdate' and '$todate' and a.prj_code='$kcode'
								  group by oc1,c.name
								  having count(distinct policy)>=11 and (select  sum(nvl(TOTCOMM,0)) as commission from  ipl.ORG_EARNING_IDRA b
								  where a.oc1=b.code and bmon between '$frdate' and '$todate' ) >=20000)";	
			//------------------------------------------------------------------------Active FA for ALL BSM-----------------------------------------------------------------------
			$query_afa_all_bsm="select count(*) from
								(select oc1,c.name,count(distinct policy)as policy_count,(select  sum(nvl(C10_11,0)+nvl(C12_14,0)+nvl(C15_19,0)+nvl(C20_ABOVE,0)+nvl(C_SING,0)) as commission from  ipl.ORG_EARNING_IDRA b
								  where a.oc1=b.code and bmon between '$frdate' and '$todate' and DESIG='FA')as commission  from IPL.policy a,ipl.organiser_ipl c
								  where '$kcode' in(rtrim(oc1),rtrim(oc2),rtrim(oc3),rtrim(oc4),rtrim(oc5),rtrim(oc6),rtrim(oc7),rtrim(oc8),rtrim(oc9),rtrim(oc10)) and a.oc1=c.code
								  and to_char(DATCOM,'YYYYMM') between '$frdate' and '$todate'
								  group by oc1,c.name
								  having count(distinct policy)>=11 and (select  sum(nvl(C10_11,0)+nvl(C12_14,0)+nvl(C15_19,0)+nvl(C20_ABOVE,0)+nvl(C_SING,0)) as commission from  ipl.ORG_EARNING_IDRA b
								  where a.oc1=b.code and bmon between '$frdate' and '$todate' ) >=20000)";			
			//------------------------------------------------------------------------Business PB HR-----------------------------------------------------------------------			
			$query_td_bus_pb_hr="SELECT to_char(to_date( B.BMON,'yyyymm'),'Monthyyyy') bomon,
                                    round(SUM(NVL(B.FYEAR,0)+NVL(B.SING0_5*0.15,0)+NVL(B.SING6_ABOVE*.20,0)))CREDIT_FIRST_YEAR,round(SUM(NVL(B.RENEWAL,0))) AS RENEWAL
                                    FROM PBPIB.HR_STAFF_PROJECT_PB A,PBPIB.HR_STAFF_BUSINESS_PB B WHERE A.CODE=B.CODE
                                    and b.bmon BETWEEN to_char(add_months(to_date('$frdate'||'01','rrrrmmdd'),-12),'rrrrmm') and '$todate' and
                                     (a.code='$kcode' OR '$kcode' IS NULL)
                                    GROUP BY A.PRJ_CODE,DECODE(A.PRJ_CODE,'01','IPL-POLASH','02','IEB','03','TAKAFUL','04','IDPS','05','PBPIB','08','IPL-BOKUL','99','NOT MENTIONED') ,
                                    A.CODE, A.NAME, A.DESIG, B.BMON order by B.BMON";
			//------------------------------------------------------------------------Business All HR-----------------------------------------------------------------------						
			$query_td_bus_all_hr="SELECT bmon bomon,SUM((NVL(NEW_BUSINESS,0)+NVL(DEFERRED,0)+(NVL(SING0_5,0)*.15)+NVL(SING6_ABOVE,0)*.2)*b.percent/100) AS newbus,SUM(NVL(RENEWAL,0)*b.percent/100) AS RENEWAL
								 FROM IPL.ORG_HEAD_BUSINESS A,IT.HR_STAFF_PROJECT_DETAILS B
								WHERE A.BMON between to_char(add_months(to_date('$frdate'||'01','rrrrmmdd'),-12),'rrrrmm') and '$todate'  AND A.ORG_HEAD IS NOT NULL AND A.ORG_HEAD=B.OC1  AND B.CODE='$kcode'
								GROUP BY B.CODE,A.BMON order by A.BMON";						
			//------------------------------------------------------------------------Business PI PB-----------------------------------------------------------------------						
			$query_td_bus_pb_pi="select to_char(to_date(bmon,'yyyymm'),'Monthyyyy') bomon,sum(NEW_BUSINESS+DEFERRED+SING0_5+SING6_ABOVE)fyp,sum(renewal) from(
									SELECT prj_code, POLICY, PLAN, receipt, recptdt,bmon, week,term, oc1, oc2, oc3,oc4,oc5,oc6,oc7, oc8,oc9, oc10,oc11, office AS entry_office, dcs_office, print_status,
									 CASE
												 WHEN SUBSTR (premcode, 1, INSTR (premcode, '-') - 1) = '1'
													  AND NVL (paymode, '1') <> '0'
												 THEN
													totprem * 1
												 ELSE   0
											  END
												 AS new_business,
											  CASE WHEN NVL (paymode, '1') = '0' THEN totprem * instl ELSE 0 END
												 AS sing,
												   CASE
													  WHEN NVL (PAYMODE, '1') = '0' AND TERM <= 5
													  THEN
														 (TOTPREM * INSTL)*.15
													  ELSE 0
												   END
												   AS SING0_5,
												   CASE
													  WHEN NVL (PAYMODE, '1') = '0' AND TERM >= 6
													  THEN
														 (TOTPREM * INSTL)*.2
													  ELSE  0
												   END
												   AS SING6_ABOVE,
											  CASE WHEN TO_CHAR (datcom, 'RRRRMM') = bmon THEN 1 ELSE 0 END
												 AS new_pol,
											  CASE
												 WHEN (TO_CHAR (datcom, 'RRRRMM') <> bmon
													   AND SUBSTR (premcode, 1, INSTR (premcode, '-') - 1) = '1')
													  OR (TO_CHAR (datcom, 'RRRRMM') <> bmon
														  AND RTRIM (premcode) = '1')
												 THEN  1
												 ELSE   0
											  END
												 AS deferr_pol,
											  totprem * pbpib.pb_def_inst_cnt (paymode, premcode, instl)
												 AS DEFERRED,
											  totprem * pbpib.pb_ren_inst_cnt (paymode, premcode, instl)
												 AS renewal,
											  CASE
												 WHEN MONTHS_BETWEEN (pnextpay, datcom) > 12
													  AND SUBSTR (premcode, 1, INSTR (premcode, '-') - 1) <> '1'
												 THEN 1
												 ELSE  0
											  END
												 AS ren_pol,latefee, sprem * instl AS sprem,
											  extprem * instl AS extprem,policy_type,reconciled,datcom,luserdt,premcode,paymode, DUEDT,PNEXTPAY,
											  CASE
												 WHEN MONTHS_BETWEEN (pnextpay, datcom) >= 25
												 THEN
												   totprem * pbpib.pb_ren_inst_cnt (paymode, premcode, instl)
											  END
												 AS RENEWAL_THANDAB,SUSP,PSUSP,LPREM,TOTPREM,INSTL
										 FROM pbpib.pb_collection where bmon between to_char(add_months(to_date('$frdate'||'01','rrrrmmdd'),-12),'rrrrmm') and '$todate' and prj_code='$kcode' )
										 group by bmon order by bmon";
			//------------------------------------------------------------------------Business PI ALL-----------------------------------------------------------------------						
			$query_td_bus_all_pi="select bmon,sum(NEW_BUSINESS+DEFERRED+SING0_5+SING6_ABOVE)fyp,sum(renewal) from(
                                    SELECT prj_code, POLICY, PLAN, receipt, recptdt,bmon, week,term, oc1, oc2, oc3,oc4,oc5,oc6,oc7, oc8,oc9, oc10,oc11, office AS entry_office, dcs_office, print_status,
                                     CASE
                                                 WHEN SUBSTR (premcode, 1, INSTR (premcode, '-') - 1) = '1'
                                                      AND NVL (paymode, '1') <> '0'
                                                 THEN
                                                    totprem * 1
                                                 ELSE   0
                                              END
                                                 AS new_business,
                                              CASE WHEN NVL (paymode, '1') = '0' THEN totprem * instl ELSE 0 END
                                                 AS sing,
                                                   CASE
                                                      WHEN NVL (PAYMODE, '1') = '0' AND TERM <= 5
                                                      THEN
                                                         (TOTPREM * INSTL)*.15
                                                      ELSE 0
                                                   END
                                                   AS SING0_5,
                                                   CASE
                                                      WHEN NVL (PAYMODE, '1') = '0' AND TERM >= 6
                                                      THEN
                                                         (TOTPREM * INSTL)*.2
                                                      ELSE  0
                                                   END
                                                   AS SING6_ABOVE,
                                              CASE WHEN TO_CHAR (datcom, 'RRRRMM') = bmon THEN 1 ELSE 0 END
                                                 AS new_pol,
                                              CASE
                                                 WHEN (TO_CHAR (datcom, 'RRRRMM') <> bmon
                                                       AND SUBSTR (premcode, 1, INSTR (premcode, '-') - 1) = '1')
                                                      OR (TO_CHAR (datcom, 'RRRRMM') <> bmon
                                                          AND RTRIM (premcode) = '1')
                                                 THEN  1
                                                 ELSE   0
                                              END
                                                 AS deferr_pol,
                                              totprem * pbpib.pb_def_inst_cnt (paymode, premcode, instl)
                                                 AS DEFERRED,
                                              totprem * pbpib.pb_ren_inst_cnt (paymode, premcode, instl)
                                                 AS renewal,
                                              CASE
                                                 WHEN MONTHS_BETWEEN (pnextpay, datcom) > 12
                                                      AND SUBSTR (premcode, 1, INSTR (premcode, '-') - 1) <> '1'
                                                 THEN 1
                                                 ELSE  0
                                              END
                                                 AS ren_pol,latefee, sprem * instl AS sprem,
                                              extprem * instl AS extprem,policy_type,reconciled,datcom,luserdt,premcode,paymode, DUEDT,PNEXTPAY,
                                              CASE
                                                 WHEN MONTHS_BETWEEN (pnextpay, datcom) >= 25
                                                 THEN
                                                   totprem * pbpib.pb_ren_inst_cnt (paymode, premcode, instl)
                                              END
                                                 AS RENEWAL_THANDAB,SUSP,PREV_NEW_BUSINESS,PSUSP,LPREM,TOTPREM,INSTL
                                         FROM ipl.collection where bmon between to_char(add_months(to_date('$frdate'||'01','yyyy/mm/dd'),-12),'rrrrmm') and '$todate' and prj_code='$kcode' )
                                         group by  bmon order by  bmon";

			//------------------------------------------------------------------------Business BSM ALL-----------------------------------------------------------------------						
			$query_td_bus_all_bsm="select to_char(to_date(bmon,'yyyymm'),'Monthyyyy') bomon,sum(NEW_BUSINESS+DEFERRED+SING0_5+SING6_ABOVE)fyp,sum(renewal) from(
									SELECT prj_code, POLICY, PLAN, receipt, recptdt,bmon, week,term, oc1, oc2, oc3,oc4,oc5,oc6,oc7, oc8,oc9, oc10,oc11, office AS entry_office, dcs_office, print_status,
									 CASE
												 WHEN SUBSTR (premcode, 1, INSTR (premcode, '-') - 1) = '1'
													  AND NVL (paymode, '1') <> '0'
												 THEN
													totprem * 1
												 ELSE   0
											  END
												 AS new_business,
											  CASE WHEN NVL (paymode, '1') = '0' THEN totprem * instl ELSE 0 END
												 AS sing,
												   CASE
													  WHEN NVL (PAYMODE, '1') = '0' AND TERM <= 5
													  THEN
														 (TOTPREM * INSTL)*.15
													  ELSE 0
												   END
												   AS SING0_5,
												   CASE
													  WHEN NVL (PAYMODE, '1') = '0' AND TERM >= 6
													  THEN
														 (TOTPREM * INSTL)*.2
													  ELSE  0
												   END
												   AS SING6_ABOVE,
											  CASE WHEN TO_CHAR (datcom, 'RRRRMM') = bmon THEN 1 ELSE 0 END
												 AS new_pol,
											  CASE
												 WHEN (TO_CHAR (datcom, 'RRRRMM') <> bmon
													   AND SUBSTR (premcode, 1, INSTR (premcode, '-') - 1) = '1')
													  OR (TO_CHAR (datcom, 'RRRRMM') <> bmon
														  AND RTRIM (premcode) = '1')
												 THEN  1
												 ELSE   0
											  END
												 AS deferr_pol,
											  totprem * pbpib.pb_def_inst_cnt (paymode, premcode, instl)
												 AS DEFERRED,
											  totprem * pbpib.pb_ren_inst_cnt (paymode, premcode, instl)
												 AS renewal,
											  CASE
												 WHEN MONTHS_BETWEEN (pnextpay, datcom) > 12
													  AND SUBSTR (premcode, 1, INSTR (premcode, '-') - 1) <> '1'
												 THEN 1
												 ELSE  0
											  END
												 AS ren_pol,latefee, sprem * instl AS sprem,
											  extprem * instl AS extprem,policy_type,reconciled,datcom,luserdt,premcode,paymode, DUEDT,PNEXTPAY,
											  CASE
												 WHEN MONTHS_BETWEEN (pnextpay, datcom) >= 25
												 THEN
												   totprem * pbpib.pb_ren_inst_cnt (paymode, premcode, instl)
											  END
												 AS RENEWAL_THANDAB,SUSP,PREV_NEW_BUSINESS,PREV_SND_YEAR,PREV_THRD_ABOVE,PSUSP,LPREM,TOTPREM,INSTL
										 FROM ipl.collection where bmon between to_char(add_months(to_date('$frdate'||'01','rrrrmmdd'),-12),'rrrrmm') and '$todate' and '$kcode' in(oc1,oc2,oc3,oc4,oc5,oc6,oc7,oc8,oc9,oc10))
										 group by bmon order by bmon";
			
			//------------------------------------------------------------------------Expance HR ALL-----------------------------------------------------------------------						
			$query_exp_all="select --a.hr_code,b.total_office_exp,a.dev_expense,
							
							nvl(b.total_office_exp,0)+nvl(a.dev_expense,0) total_expense
							
							from
							
							(
							
							select a.hr_code,sum(nvl(F,0)) FYEAR_COMM,sum(nvl(FY,0)) FY_Conveyance,sum(nvl(OA,0)) Other_Allow,
							
							sum(nvl(TB,0)) Target_Bonus,sum(nvl(F,0)+nvl(FY,0)+nvl(OA,0)+nvl(TB,0)) EXP_FY,sum(nvl(R,0)) Ren_Comm,sum(nvl(F,0)+nvl(R,0)) TOTAL_COMM,
							
							sum(nvl(RC,0)) Ren_Conveyance,sum(nvl(R,0)+nvl(RC,0)) EXP_REN,sum(nvl(R,0)+nvl(RC,0)+nvl(F,0)+nvl(FY,0)+nvl(OA,0)+nvl(TB,0)) dev_expense
							
							from IT.HR_STAFF_PROJECT h,
							
							(
							
							SELECT prj_code,CODE hr_code,
							
							nvl(TRUNC(R,0),0)R,nvl(TRUNC(RC,0),0)RC,nvl(TRUNC(F,0),0)F,nvl(TRUNC(FY,0),0)FY,nvl(TRUNC(OA,0),0)OA,nvl(TRUNC(TB,0),0)TB
							
							FROM
							
							(
							
							SELECT c.prj_code,c.CODE,a.PTYPE,NVL(SUM(a.BONUS),0) BONUS 
							
							FROM ipl.organiser_ipl b,IT.HR_STAFF_PROJECT_DETAILS c,ipl.dev_expense a
							
							where b.FAVP=c.oc1 and c.code='$kcode' and a.code=b.code and a.bmon between '$frdate' and '$todate'
							
							and NVL(a.BONUS,0)>0
							
							GROUP BY c.prj_code,c.CODE,a.PTYPE
							
							) A
							
							PIVOT( SUM(BONUS) FOR PTYPE IN ( 'R'R, 'RC'RC, 'F'F,'OA'OA,'TB'TB,'FY'FY,'RN'RN))
							
							) A
							
							where h.code = a.hr_code(+) and upper(h.status)='A' and h.code = '$kcode'
							
							group by a.hr_code
							
							) A,
							
							(
							
							select distinct a.hr_code,nvl(sum(nvl(STAFF_SALARY,0)+nvl(RENT,0)+nvl(a.ELECTRIC_BILL,0)+nvl(a.OTHERS_BILL,0)+nvl(a.TA_DA,0)+
							
							nvl(a.MOBILE_BILL,0)+nvl(a.ENTERTAINMENT,0)+nvl(a.DEV_METTING,0)+nvl(a.CAR_EXPENSE,0)+nvl(a.OTHER_EXPENSE,0)),0) total_office_exp
							
							from
							
							(
							
							select h.prj_code,h.code hr_code,a.sccode,max(nvl(a.NO_STAFF,0)) NO_HR_STAFF,max(nvl(a.NO_CAR,0)) NO_CAR,
							
							sum(nvl(a.STAFF_BENEFIT,0)+nvl(a.PEON_SALARY,0)+nvl(a.PEON_BONUS,0)) STAFF_SALARY,
							
							sum(nvl(a.NET_PAYMENT,0)) RENT,sum(nvl(a.ELECTRIC_BILL,0)) ELECTRIC_BILL,
							
							sum(nvl(a.OTHERS_BILL,0)+nvl(a.POSTAGE_COURIER,0)+nvl(a.STATIONARY,0)+nvl(a.REPAIR_MAINTENANCE,0)+nvl(a.PHOTOSTAT,0)+nvl(INT_EXPENSE,0)) OTHERS_BILL,
							
							sum(nvl(a.TA_DA,0)) TA_DA,sum(nvl(a.MOBILE_BILL,0)) MOBILE_BILL,sum(nvl(a.ENTERTAINMENT,0)) ENTERTAINMENT,
							
							sum(nvl(a.DEV_METTING,0)) DEV_METTING,sum(nvl(CAR_ALLOWANCE,0)+nvl(a.CAR_EXPENSE,0)) CAR_EXPENSE,sum(nvl(a.OTHER_EXPENSE,0)) OTHER_EXPENSE,
							
							sum(nvl(a.INCENTIVE,0))  INCENTIVE,sum(nvl(a.BUS_DEV_EXPENSE,0)) BUS_DEV_EXPENSE
							
							from ipl.all_office_expense a, IT.HR_STAFF_PROJECT_DETAILS h, IPL.SC_SLNO S
							
							where a.sccode = s.sccode and s.INCHARGE_CODE = h.oc1 and h.code = '$kcode' and
							
							a.BILL_MONTH between '$frdate' and '$todate'
							
							group by h.prj_code,h.code,a.sccode
							
							) A
							
							group by a.prj_code,a.hr_code
							
							) B
							
							where a.hr_code = b.hr_code(+)";
			//------------------------------------------------------------------------Expance HR PB-----------------------------------------------------------------------						
			$query_exp_pb="select --a.hr_code,b.total_office_exp,a.dev_expense,
							
							nvl(b.total_office_exp,0)+nvl(a.dev_expense,0) total_expense
							
							from
							
							(
							
							select a.hr_code,sum(nvl(F,0)) FYEAR_COMM,sum(nvl(FY,0)) FY_Conveyance,sum(nvl(OA,0)) Other_Allow,
							
							sum(nvl(TB,0)) Target_Bonus,sum(nvl(F,0)+nvl(FY,0)+nvl(OA,0)+nvl(TB,0)) EXP_FY,sum(nvl(R,0)) Ren_Comm,sum(nvl(F,0)+nvl(R,0)) TOTAL_COMM,
							
							sum(nvl(RC,0)) Ren_Conveyance,sum(nvl(R,0)+nvl(RC,0)) EXP_REN,sum(nvl(R,0)+nvl(RC,0)+nvl(F,0)+nvl(FY,0)+nvl(OA,0)+nvl(TB,0)) dev_expense
							
							from IT.HR_STAFF_PROJECT h,
							
							(
							
							SELECT prj_code,CODE hr_code,
							
							nvl(TRUNC(R,0),0)R,nvl(TRUNC(RC,0),0)RC,nvl(TRUNC(F,0),0)F,nvl(TRUNC(FY,0),0)FY,nvl(TRUNC(OA,0),0)OA,nvl(TRUNC(TB,0),0)TB
							
							FROM
							
							(
							
							SELECT c.prj_code,c.CODE,a.PTYPE,NVL(SUM(a.BONUS),0) BONUS 
							
							FROM pbpib.pb_organiser b,IT.HR_STAFF_PROJECT_DETAILS c,ipl.dev_expense a
							
							where b.dc=c.oc1 and c.code='$kcode' and a.code=b.code and a.bmon between '$frdate' and '$todate'
							
							and NVL(a.BONUS,0)>0
							
							GROUP BY c.prj_code,c.CODE,a.PTYPE
							
							) A
							
							PIVOT( SUM(BONUS) FOR PTYPE IN ( 'R'R, 'RC'RC, 'F'F,'OA'OA,'TB'TB,'FY'FY,'RN'RN))
							
							) A
							
							where h.code = a.hr_code(+) and upper(h.status)='A' and h.code = '$kcode'
							
							group by a.hr_code
							
							) A,
							
							(
							
							select distinct a.hr_code,nvl(sum(nvl(STAFF_SALARY,0)+nvl(RENT,0)+nvl(a.ELECTRIC_BILL,0)+nvl(a.OTHERS_BILL,0)+nvl(a.TA_DA,0)+
							
							nvl(a.MOBILE_BILL,0)+nvl(a.ENTERTAINMENT,0)+nvl(a.DEV_METTING,0)+nvl(a.CAR_EXPENSE,0)+nvl(a.OTHER_EXPENSE,0)),0) total_office_exp
							
							from
							
							(
							
							select h.code hr_code,a.sccode,max(nvl(a.NO_STAFF,0)) NO_HR_STAFF,max(nvl(a.NO_CAR,0)) NO_CAR,
							
							sum(nvl(a.STAFF_BENEFIT,0)+nvl(a.PEON_SALARY,0)+nvl(a.PEON_BONUS,0)) STAFF_SALARY,
							
							sum(nvl(a.NET_PAYMENT,0)) RENT,sum(nvl(a.ELECTRIC_BILL,0)) ELECTRIC_BILL,
							
							sum(nvl(a.OTHERS_BILL,0)+nvl(a.POSTAGE_COURIER,0)+nvl(a.STATIONARY,0)+nvl(a.REPAIR_MAINTENANCE,0)+nvl(a.PHOTOSTAT,0)+nvl(INT_EXPENSE,0)) OTHERS_BILL,
							
							sum(nvl(a.TA_DA,0)) TA_DA,sum(nvl(a.MOBILE_BILL,0)) MOBILE_BILL,sum(nvl(a.ENTERTAINMENT,0)) ENTERTAINMENT,
							
							sum(nvl(a.DEV_METTING,0)) DEV_METTING,sum(nvl(CAR_ALLOWANCE,0)+nvl(a.CAR_EXPENSE,0)) CAR_EXPENSE,sum(nvl(a.OTHER_EXPENSE,0)) OTHER_EXPENSE,
							
							sum(nvl(a.INCENTIVE,0)) INCENTIVE,sum(nvl(a.BUS_DEV_EXPENSE,0)) BUS_DEV_EXPENSE
							
							from ipl.all_office_expense a, IT.HR_STAFF_PROJECT_DETAILS h, pbpib.pb_office S
							
							where a.sccode = s.sccode and s.INCHARGE_CODE = h.oc1 and h.code = '$kcode' and
							
							a.BILL_MONTH between '$frdate' and '$todate'
							
							group by h.code,a.sccode
							
							) A
							
							group by a.hr_code
							
							) B
							
							where a.hr_code = b.hr_code(+)";
			
			$query_tar_det="SELECT PRJ_CODE,CODE,DSGN,NAME,FY_MONTLY,REN_MONTLY,BMON,TYPE,BSCHEME_STATU,PROJECT FROM IPL.PI_HR_BSC_TERGET WHERE CODE='$kcode' and ((bmon between '$frdate'and'$todate') or bmon is null) and not (PRJ_CODE='08' and CODE='05')";
			$stid_tar_det = OCIParse($conn, $query_tar_det);
			OCIExecute($stid_tar_det);
			while($row_tar_det= oci_fetch_array($stid_tar_det))
			{
						$fytar += $row_tar_det[4];
						$rentar += $row_tar_det[5];
						$prj_code=$row_tar_det[0];
						$dsgn=$row_tar_det[2];
						$name=$row_tar_det[3];
						$type=$row_tar_det[7];
						$project=$row_tar_det[9];
				}
				
				
				if ($type=="BSM")
				{
					$par_t="F";
					if ($prj_code=="05"){
						//--------------PB BSM-------------
						}
					else {
						//--------------ALL BSM-------------
						$fytar = $fytar*$monthdef;
						$rentar = $rentar*$monthdef;
						$query_afa=$query_afa_all_bsm;
						$bus_td=" FROM ipl.collection where bmon between to_char(add_months(to_date('$frdate'||'01','rrrrmmdd'),-12),'rrrrmm') and '$todate' and prj_code='$kcode' ) group by bmon order by bmon";
						$query_td_bus=$query_td_bus_all_bsm;
						$ftype="`B` Scheme";
						$fytp=300000;
						$rentp=500000;
						}
				}
				else if($type=="HR")
				{
					$par_t="H";
					if ($prj_code=="05"){
						//--------------PB HR-------------
						$fytar = $fytar*$monthdef;
						$rentar = $rentar*$monthdef;
						$query_afa=$query_afa_pb_hr;
						$query_td_bus=$query_td_bus_pb_hr;
						$ftype="HR";
						$fytp=300000;
						$rentp=500000;
						$query_exp=$query_exp_pb;
								$stid_exp = OCIParse($conn, $query_exp);
								OCIExecute($stid_exp);
								while($row_exp= oci_fetch_array($stid_exp))
								{ $st_exp=$row_exp[0]; }
						
						}
					else {
						//--------------ALL HR-------------
						$fytar = $fytar*1;
						$rentar = $rentar*1;
						$query_afa=$query_afa_all_hr;
						$bus_td=" FROM ipl.collection where bmon between to_char(add_months(to_date('$frdate'||'01','rrrrmmdd'),-12),'rrrrmm') and '$todate' and prj_code='$kcode' ) group by bmon order by bmon";
						$query_td_bus=$query_td_bus_all_hr;
						$ftype="HR";
						$fytp=300000;
						$rentp=500000;
						$query_exp=$query_exp_all;
								$stid_exp = OCIParse($conn, $query_exp);
								OCIExecute($stid_exp);
								while($row_exp= oci_fetch_array($stid_exp))
								{ $st_exp=$row_exp[0]; }
						}
				}
				else if($type=="PI")
				{
					$par_t="P";
					if ($prj_code=="05"){
						//--------------PB PI-------------
						$fytar = $fytar*$monthdef;
						$rentar = $rentar*$monthdef;
						$query_afa=$query_afa_pb_pi;
						$query_td_bus=$query_td_bus_pb_pi;
						$ftype="PI";
						$fytp=300000;
						$rentp=1000000;
						
						}
					else {
						//--------------ALL PI-------------
						$fytar = $fytar*$monthdef;
						$rentar = $rentar*$monthdef;
						$query_afa=$query_afa_all_pi;
						$query_td_bus=$query_td_bus_all_pi;
						$ftype="PI";
						$fytp=300000;
						$rentp=1000000;
						}
				}
				else if (!isset($type))
				{
					$type="xx";
				}
				
				//invalid or valid warning
				if ($type=="xx"){
				echo "Warning";
				}
				else
				{
					//--------------Parcestancy-------------
					if ($prj_code=="05"){
						$parscim="PBD";
					}
					else {
						$parscim="IPL";
						}
					$query_par="SELECT 
						(IPL.PERSISTENCY_CAL_$parscim ('$kcode',add_months(TO_DATE('$pardate','DD/MM/YYYY'),-0),'$prj_code','$par_t','POL_PERSIST',add_months(TO_DATE('$pardate','DD/MM/YYYY'),-36),add_months(TO_DATE('$pardate','DD/MM/YYYY'),-24))+
						IPL.PERSISTENCY_CAL_$parscim ('$kcode',add_months(TO_DATE('$pardate','DD/MM/YYYY'),-0),'$prj_code','$par_t','PRM_PERSIST',add_months(TO_DATE('$pardate','DD/MM/YYYY'),-36),add_months(TO_DATE('$pardate','DD/MM/YYYY'),-24)))/2 TOT_PERSIST
						FROM SYS.DUAL";
					
					
							$stid_td_bus = OCIParse($conn, $query_td_bus);
								OCIExecute($stid_td_bus);
								$newsum = 0;
								while($row_td_bus= oci_fetch_array($stid_td_bus))
								{
								$kpimon[]=$row_td_bus[0];
								$kpfy[]=$row_td_bus[1];
								$kpren[]=$row_td_bus[2];
								 }
								 
									for($x = 0; $x < $monthdef; $x++) {
										$prev_y_m[]= $kpimon[$x];
										$prev_fy[]= $kpfy[$x];
										$prev_ren[]= $kpren[$x];
										$prevfysum += $kpfy[$x];
										$prevrensum += $kpren[$x];
									}
									for($x = count($kpimon)-$monthdef; $x < count($kpimon); $x++) {
										$pres_y_m[]= $kpimon[$x];
										$pres_fy[]= $kpfy[$x];
										$pres_ren[]= $kpren[$x];
										$presfysum += $kpfy[$x];
										$presrensum += $kpren[$x];
									}
									$pdd=substr($frdate,0,-2);
									$prdd=(substr($frdate,0,-2))-1;
									$fmonn=date("F", mktime(0, 0, 0, (substr($frdate,-2)), 10));
									$tmonn=date("F", mktime(0, 0, 0, (substr($todate,-2)), 10));
									$fygro=((($presfysum-$prevfysum)/$prevfysum)*100);
									$rengro=((($presrensum-$prevrensum)/$prevrensum)*100);
									$totgro=(100*((($presfysum+$presrensum)-($prevfysum+$prevrensum))/($prevfysum+$prevrensum)));
									if ($fygro>0){
										$fygr=(2/5)*$fygro;
										}
									if ($fygro<0){
										$fygr=(1/2)*$fygro;
										}
									if ($rengro>0){
										$regr=(2/3)*$rengro;
										}
									if ($rengro<0){
										$regr=(1/1)*$rengro;
										}
						
										
										$grrat=$fygr+$regr;
										if ($grrat>=75){
										$grrat=75;
										}?>

					
					         <div class="table-responsive">
                             <input type="button" onclick="tableToExcel('testTable', 'W3C Example Table')" value="Export to Excel">
                             
    <table class="table table-bordered" id='testTable'>

 
 
   <td colspan="7" valign="bottom" nowrap="nowrap">
 <p>KPI for <?php echo $ftype;?>    (<?php echo $fmonn."-".$tmonn."-".$pdd;?>)   </p>
 <p>NAME OF EMPLOYEE : <?php echo $name;?>   </p>
 <p>PROJECT:  <?php echo $project;?>   </p>
 <p>DESIGNATION: <?php echo $dsgn;?>  </p>
 </td>
        <tr>
        <td width="127" nowrap="nowrap" rowspan="2"><p align="center">Particulars</p></td>
        <td nowrap="nowrap" colspan="2" valign="bottom"><p align="center">Credit Premium (<?php echo $fmonn."-".$tmonn;?>)</p></td>
        <td width="73" rowspan="2"><p align="center">Growth Ratio %</p></td>
        <td width="69" nowrap="nowrap" rowspan="2"><p align="center">Target</p></td>
        <td width="68" rowspan="2" valign="bottom"><p align="center">Achieve-<br />
          ment (%)</p></td>
        <td width="130" rowspan="2"><p align="center">KPI Point</p>
          <p align="center">(<?php echo $fmonn."-".$tmonn."-".$pdd;?>)</p></td>
      </tr>
      <tr>
        <td width="127" nowrap="nowrap" valign="bottom"><p align="center"><?php echo $prdd;?></p></td>
        <td width="95" nowrap="nowrap" valign="bottom"><p align="center"><?php echo $pdd;?></p></td>
      </tr>
      <tr>
        <td width="127" nowrap="nowrap" valign="bottom"><p>First Year</p></td>
        <td width="127" nowrap="nowrap" valign="bottom"><p align="right"><?php echo number_format($prevfysum);?></p></td>
        <td width="95" nowrap="nowrap" valign="bottom"><p align="right"><?php echo number_format($presfysum);?></p></td>
        <td width="73" nowrap="nowrap"><p align="right"><?php echo round($fygro,2)."%";?></p></td>
        <td width="69" nowrap="nowrap" valign="bottom"><p align="right"><?php echo number_format($fytar);?></p></td>
        <td width="68" nowrap="nowrap" valign="bottom"><p align="right">
		<?php 
				if ($fytar==0)
		{
			echo 0;
			}
			else{
		echo round((($presfysum*100)/$fytar),2);
			}
		?></p></td>
        <td width="130" nowrap="nowrap"><p align="right"><?php echo round(($presfysum/$fytp),2);?></p></td>
      </tr>
      <tr>
        <td width="127" nowrap="nowrap" valign="bottom"><p>Renewal</p></td>
        <td width="127" nowrap="nowrap" valign="bottom"><p align="right"><?php echo number_format($prevrensum);?></p></td>
        <td width="95" nowrap="nowrap" valign="bottom"><p align="right"><?php echo number_format($presrensum);?></p></td>
        <td width="73" nowrap="nowrap"><p align="right"><?php echo round($rengro,2)."%";?></p></td>
        <td width="69" nowrap="nowrap"><p align="right"><?php echo number_format($rentar);?></p></td>
        <td width="68" nowrap="nowrap" valign="bottom"><p align="right">
		<?php 
		if ($rentar==0)
		{
			echo 0;
			}
			else{
		echo round((($presrensum*100)/$rentar),2);
			}
		?>
        </p></td>
        <td width="130" nowrap="nowrap"><p align="right"><?php echo round(($presrensum/$rentp),2);?></p></td>
      </tr>
      <tr>
        <td width="127" nowrap="nowrap" valign="bottom"><p>Total</p></td>
        <td width="127" nowrap="nowrap" valign="bottom"><p align="right"><?php echo number_format($prevfysum+$prevrensum);?></p></td>
        <td width="95" nowrap="nowrap" valign="bottom"><p align="right"><?php echo number_format($presfysum+$presrensum);?></p></td>
        <td width="73" nowrap="nowrap"><p align="right"><?php echo round($totgro,2)."%"?></p></td>
        <td width="69" nowrap="nowrap" valign="bottom"><p>&nbsp;</p></td>
        <td width="68" nowrap="nowrap" valign="bottom"><p>&nbsp;</p></td>
        <td width="130" nowrap="nowrap"><p align="right">
		<?php 
		$buskpi=round((($presfysum/$fytp)+($presrensum/$rentp)),2);
		echo $buskpi;
		?></p></td>
      </tr>
      <tr>
        <td width="127" nowrap="nowrap" valign="bottom"><p>Growth Ratio</p></td>
        <td width="127" nowrap="nowrap" valign="bottom"><p align="right">&nbsp;</p></td>
        <td width="95" nowrap="nowrap" valign="bottom"><p align="right">&nbsp;</p></td>
        <td width="73" nowrap="nowrap"><p align="right"><?php echo round($grrat,2);?></p></td>
        <td width="69" nowrap="nowrap"><p>&nbsp;</p></td>
        <td width="68" nowrap="nowrap"><p>&nbsp;</p></td>
        <td width="130" nowrap="nowrap"><p align="right"><?php echo round($grrat,2);?></p></td>
      </tr>
      <tr>
        <td width="127" nowrap="nowrap" valign="bottom"><p>Persistency as </p>
          <p>per    IDRA Formula</p></td>
        <td width="127" nowrap="nowrap" valign="bottom"><p>&nbsp;</p></td>
        <td width="95" nowrap="nowrap" valign="bottom"><p align="right">
        				<?php
        						$stid_par = OCIParse($conn, $query_par);
								OCIExecute($stid_par);
								while($row_par= oci_fetch_array($stid_par))
								{
								$par_idra= $row_par[0];
								 }
								 echo round($par_idra,2);
						?>
        </p></td>
        <td width="73" nowrap="nowrap" valign="bottom"><p>&nbsp;</p></td>
        <td width="69" nowrap="nowrap" valign="bottom"><p>&nbsp;</p></td>
        <td width="68" nowrap="nowrap" valign="bottom"><p>&nbsp;</p></td>
        <td width="130" nowrap="nowrap"><p align="right">
		<?php 
		
		$parkpi=$par_idra-50;
		echo $parkpi;
		?></p></td>
      </tr>
      <tr>
        <td width="127" nowrap="nowrap" valign="bottom"><p>Active FA</p></td>
        <td width="127" nowrap="nowrap" valign="bottom"><p>&nbsp;</p></td>
        <td width="95" nowrap="nowrap" valign="bottom"><p align="right">
		<?php
        						$stid_afa = OCIParse($conn, $query_afa);
								OCIExecute($stid_afa);
								while($row_afa= oci_fetch_array($stid_afa))
								{
								$afa_idra= $row_afa[0];
								 }
								 echo $afa_idra;
						?>
        </p></td>
        <td width="73" nowrap="nowrap" valign="bottom"><p>&nbsp;</p></td>
        <td width="69" nowrap="nowrap" valign="bottom"><p>&nbsp;</p></td>
        <td width="68" nowrap="nowrap" valign="bottom"><p>&nbsp;</p></td>
        <td width="130" nowrap="nowrap"><p align="right"><?php echo $afa_idra;?></p></td>
      </tr>
      <tr>
        <td width="127" nowrap="nowrap" valign="bottom"><p>Expense Ratio </p></td>
        <td width="127" nowrap="nowrap" valign="bottom"><p>&nbsp;</p></td>
        <td width="95" nowrap="nowrap" valign="bottom"><p align="right">
          <?php 
                    if ($ftype=="HR")
                    {
                    $tot_bus=$presfysum+$presrensum;
					//echo (($st_exp+($tot_bus*0.05))/$tot_bus)*100;
					$exppt= round((((($presfysum*0.87)+($presrensum*0.15))/$tot_bus)*100)-((($st_exp+($tot_bus*0.05))/$tot_bus)*100),2);
					echo $exppt;
                    }
                    else
                    {
                        $exppt=0;
						echo $exppt;
						}
                    ?>
          </p></td>
        <td width="73" nowrap="nowrap" valign="bottom"><p>&nbsp;</p></td>
        <td width="69" nowrap="nowrap" valign="bottom"><p>&nbsp;</p></td>
        <td width="68" nowrap="nowrap" valign="bottom"><p>&nbsp;</p></td>
        <td width="130" nowrap="nowrap"><p align="right">
          <?php 
		if ($exppt<0){
			$kexppt=$exppt*2;
		}
		else
		{
			$kexppt=$exppt*5;
			}
			echo $kexppt;
		?>
          </p></td>
      </tr>
      <tr>
        <td width="127" nowrap="nowrap" valign="bottom"><p>Pyramid </p>
          <p>Structure    Point</p></td>
        <td width="127" nowrap="nowrap" valign="bottom"><p>&nbsp;</p></td>
        <td width="95" nowrap="nowrap" valign="bottom"><p align="right">0.00</p></td>
        <td width="73" nowrap="nowrap" valign="bottom"><p>&nbsp;</p></td>
        <td width="69" nowrap="nowrap" valign="bottom"><p>&nbsp;</p></td>
        <td width="68" nowrap="nowrap" valign="bottom"><p>&nbsp;</p></td>
        <td width="130" nowrap="nowrap"><p align="right">0.00</p></td>
      </tr>
      <tr>
        <td nowrap="nowrap" colspan="6" valign="bottom"><p align="center"><strong>Total KPI Point</strong></p></td>
        <td width="130" nowrap="nowrap" valign="bottom"><p align="right"><strong>
		<?php 
		$totkapi=$grrat+$buskpi+$parkpi+$kexppt; 
		echo round(($totkapi+$afa_idra),2);
		?></strong></p></td>
      </tr>
    </table>
    
    
    <script src="https://code.jquery.com/jquery-3.3.1.js"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.flash.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.print.min.js"></script>
    
    <script>
	$(document).ready(function() {
    $('#example').DataTable( {
        dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
    } );
} );
	</script>
    
  </div>
  
  <div id="tocol" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
  <div id="tocolr" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
  <div id="container" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
    <div id="containerr" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
  <div id="renwal" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
    <div id="renwalr" style="min-width: 310px; height: 400px; margin: 0 auto"></div>

		<script type="text/javascript">

Highcharts.chart('container', {
    chart: {
        type: 'line'
    },
    title: {
        text: 'Monthly First Year Business'
    },
    subtitle: {
        text: ''
    },
    xAxis: {
        categories: [	
		<?php				
		for($x = 0; $x < $monthdef; $x++) {
		echo "'".(substr($kpimon[$x],0,-6))."',";
		}
		?>
				]
    },
    yAxis: {
        title: {
            text: 'Business (BDT)'
        }
    },
    plotOptions: {
        line: {
            dataLabels: {
                enabled: true
            },
            enableMouseTracking: false
        }
    },
    series: [{
        name: '<?php echo substr($todate,0,-2)-1;?>',
        data: [
				<?php				
		for($x = 0; $x < $monthdef; $x++) {
		echo $prev_fy[$x].",";
		}
		?>
			  ]
    }, {
        name: '<?php echo substr($todate,0,-2);?>',
        data: [
						<?php				
		for($x = 0; $x < $monthdef; $x++) {
		echo $pres_fy[$x].",";
		}
		?>
		]
    }]
});


Highcharts.chart('renwal', {
    chart: {
        type: 'line'
    },
    title: {
        text: 'Monthly Renewal Business'
    },
    subtitle: {
        text: ''
    },
    xAxis: {
        categories: [	
		<?php				
		for($x = 0; $x < $monthdef; $x++) {
		echo "'".(substr($kpimon[$x],0,-6))."',";
		}
		?>
				]
    },
    yAxis: {
        title: {
            text: 'Business (BDT)'
        }
    },
    plotOptions: {
        line: {
            dataLabels: {
                enabled: true
            },
            enableMouseTracking: false
        }
    },
    series: [{
        name: '<?php echo substr($todate,0,-2)-1;?>',
        data: [
				<?php				
		for($x = 0; $x < $monthdef; $x++) {
		echo $prev_ren[$x].",";
		}
		?>
			  ]
    }, {
        name: '<?php echo substr($todate,0,-2);?>',
        data: [
						<?php				
		for($x = 0; $x < $monthdef; $x++) {
		echo $pres_ren[$x].",";
		}
		?>
		]
    }]
});		

Highcharts.chart('tocol', {
    chart: {
        type: 'line'
    },
    title: {
        text: 'Monthly Total Business'
    },
    subtitle: {
        text: ''
    },
    xAxis: {
        categories: [	
		<?php				
		for($x = 0; $x < $monthdef; $x++) {
		echo "'".(substr($kpimon[$x],0,-6))."',";
		}
		?>
				]
    },
    yAxis: {
        title: {
            text: 'Business (BDT)'
        }
    },
    plotOptions: {
        line: {
            dataLabels: {
                enabled: true
            },
            enableMouseTracking: false
        }
    },
    series: [{
        name: '<?php echo substr($todate,0,-2)-1;?>',
        data: [
				<?php				
		for($x = 0; $x < $monthdef; $x++) {
		echo $prev_ren[$x]+$prev_fy[$x].",";
		}
		?>
			  ]
    }, {
        name: '<?php echo substr($todate,0,-2);?>',
        data: [
						<?php				
		for($x = 0; $x < $monthdef; $x++) {
		echo $pres_ren[$x]+$pres_fy[$x].",";
		}
		?>
		]
    }]
});        
        </script>


<script type="text/javascript">

Highcharts.chart('containerr', {
    chart: {
        type: 'line'
    },
    title: {
        text: 'Monthly First Year Business (Cumulative)'
    },
    subtitle: {
        text: ''
    },
    xAxis: {
        categories: [	
		<?php				
		for($x = 0; $x < $monthdef; $x++) {
		echo "'".(substr($kpimon[$x],0,-6))."',";
		}
		?>
				]
    },
    yAxis: {
        title: {
            text: 'Business (BDT)'
        }
    },
    plotOptions: {
        line: {
            dataLabels: {
                enabled: true
            },
            enableMouseTracking: false
        }
    },
    series: [{
        name: '<?php echo substr($todate,0,-2)-1;?>',
        data: [
								<?php
		$total_prev_fy = array();
		$runningSum_prev_fy = 0;			
		for($x_prev_fy = 0; $x_prev_fy < $monthdef; $x_prev_fy++) {
		$original_prev_fy[]= $prev_fy[$x_prev_fy];
		}
		foreach ($original_prev_fy as $number_prev_fy) {
			$runningSum_prev_fy += $number_prev_fy;
			$total_prev_fy[] = $runningSum_prev_fy;
		}
		
		for($x_prev_fy = 0; $x_prev_fy < $monthdef; $x_prev_fy++) {
			echo $total_prev_fy[$x_prev_fy].",";
			}

		?>
			  ]
    }, {
        name: '<?php echo substr($todate,0,-2);?>',
        data: [
							<?php
		$total_pres_fy = array();
		$runningSum_pres_fy = 0;			
		for($x_pres_fy = 0; $x_pres_fy < $monthdef; $x_pres_fy++) {
		$original_pres_fy[]= $pres_fy[$x_pres_fy];
		}
		foreach ($original_pres_fy as $number_pres_fy) {
			$runningSum_pres_fy += $number_pres_fy;
			$total_pres_fy[] = $runningSum_pres_fy;
		}
		
		for($x_pres_fy = 0; $x_pres_fy < $monthdef; $x_pres_fy++) {
			echo $total_pres_fy[$x_pres_fy].",";
			}

		?>
		]
    }]
});


Highcharts.chart('renwalr', {
    chart: {
        type: 'line'
    },
    title: {
        text: 'Monthly Renewal Business (Cumulative)'
    },
    subtitle: {
        text: ''
    },
    xAxis: {
        categories: [	
		<?php				
		for($x = 0; $x < $monthdef; $x++) {
		echo "'".(substr($kpimon[$x],0,-6))."',";
		}
		?>
				]
    },
    yAxis: {
        title: {
            text: 'Business (BDT)'
        }
    },
    plotOptions: {
        line: {
            dataLabels: {
                enabled: true
            },
            enableMouseTracking: false
        }
    },
    series: [{
        name: '<?php echo substr($todate,0,-2)-1;?>',
        data: [
	
		
								<?php
		$total_prev_ren = array();
		$runningSum_prev_ren = 0;			
		for($x_prev_ren = 0; $x_prev_ren < $monthdef; $x_prev_ren++) {
		$original_prev_ren[]= $prev_ren[$x_prev_ren];
		}
		foreach ($original_prev_ren as $number_prev_ren) {
			$runningSum_prev_ren += $number_prev_ren;
			$total_prev_ren[] = $runningSum_prev_ren;
		}
		
		for($x_prev_ren = 0; $x_prev_ren < $monthdef; $x_prev_ren++) {
			echo $total_prev_ren[$x_prev_ren].",";
			}

		?>
		
		
	
			  ]
    }, {
        name: '<?php echo substr($todate,0,-2);?>',
        data: [
		
						<?php
		$total_pres_ren = array();
		$runningSum_pres_ren = 0;			
		for($x_pres_ren = 0; $x_pres_ren < $monthdef; $x_pres_ren++) {
		$original_pres_ren[]= $pres_ren[$x_pres_ren];
		}
		foreach ($original_pres_ren as $number_pres_ren) {
			$runningSum_pres_ren += $number_pres_ren;
			$total_pres_ren[] = $runningSum_pres_ren;
		}
		
		for($x_pres_ren = 0; $x_pres_ren < $monthdef; $x_pres_ren++) {
			echo $total_pres_ren[$x_pres_ren].",";
			}

		?>
		
		]
    }]
});		

Highcharts.chart('tocolr', {
    chart: {
        type: 'line'
    },
    title: {
        text: 'Monthly Total Business (Cumulative)'
    },
    subtitle: {
        text: ''
    },
    xAxis: {
        categories: [	
		<?php				
		for($x = 0; $x < $monthdef; $x++) {
		echo "'".(substr($kpimon[$x],0,-6))."',";
		}
		?>
				]
    },
    yAxis: {
        title: {
            text: 'Business (BDT)'
        }
    },
    plotOptions: {
        line: {
            dataLabels: {
                enabled: true
            },
            enableMouseTracking: false
        }
    },
    series: [{
        name: '<?php echo substr($todate,0,-2)-1;?>',
        data: [
		
						<?php
		$total_prev = array();
		$runningSum_prev = 0;			
		for($x_prev = 0; $x_prev < $monthdef; $x_prev++) {
		$original_prev[]= $prev_ren[$x_prev]+$prev_fy[$x_prev];
		}
		foreach ($original_prev as $number_prev) {
			$runningSum_prev += $number_prev;
			$total_prev[] = $runningSum_prev;
		}
		
		for($x_prev = 0; $x_prev < $monthdef; $x_prev++) {
			echo $total_prev[$x_prev].",";
			}

		?>
			  ]
    }, {
        name: '<?php echo substr($todate,0,-2);?>',
        data: [
				<?php
		$total_pres = array();
		$runningSum_pres = 0;			
		for($x_pres = 0; $x_pres < $monthdef; $x_pres++) {
		$original_pres[]= $pres_ren[$x_pres]+$pres_fy[$x_pres];
		}
		foreach ($original_pres as $number_pres) {
			$runningSum_pres += $number_pres;
			$total_pres[] = $runningSum_pres;
		}
		
		for($x_pres = 0; $x_pres < $monthdef; $x_pres++) {
			echo $total_pres[$x_pres].",";
			}

		?>
		]
    }]
});        
        </script>


<script>
	var tableToExcel = (function() {
		  var uri = 'data:application/vnd.ms-excel;base64,'
			, template = '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40"><head><!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name>{worksheet}</x:Name><x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions></x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]--></head><body><table>{table}</table></body></html>'
			, base64 = function(s) { return window.btoa(unescape(encodeURIComponent(s))) }
			, format = function(s, c) { return s.replace(/{(\w+)}/g, function(m, p) { return c[p]; }) }
		  return function(table, name) {
			if (!table.nodeType) table = document.getElementById(table)
			var ctx = {worksheet: name || 'Worksheet', table: table.innerHTML}
			window.location.href = uri + base64(format(template, ctx))
		  }
		})()
</script>

    </div>
					
					<?php }

				
			 } ?> 

</div>  

