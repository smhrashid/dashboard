
<script src="<?php echo base_url();?>asset/js/jquery-2.1.1.min.js"></script>
<style>
.col-md-3 {
    width: 23% !important;
}
.container {
    width: 100% !important;
}

</style>

<div class="row">
    <div class="box col-md-12">

        <div class="box-inner">
            <div class="box-header well" data-original-title="">
                <h2><i class="glyphicon glyphicon-home"></i> Dev-expense-(IPL,PBPIB)</h2>

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
   


<form action="devexp" method="post">
 <div class="row">
  <div class="col-sm-3">  
<input name="fdate" class="datepicker-here" data-language="en" data-min-view="months" data-view="months" data-date-format="MM yyyy" type="text" required="required">
</div>
  <div class="col-sm-3">
<input name="tdate"  class="datepicker-here" data-language="en" data-min-view="months" data-view="months" data-date-format="MM yyyy" type="text" required="required">
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
						
			$frdate=date('Ym', strtotime($fdate));
			$todate=date('Ym', strtotime($tdate));
		?>
							
                    <div class="container">
                    <table class="table table-bordered">
                                          <tr>
                        <td colspan="7"><div align="center">Payment</div></td>
                        <td colspan="2"><div align="center">Income</div></td>
                        <td colspan="2"><div align="center">Ratio(%)</div></td>
                      </tr>
                      <tr>
                        <td>Project</td>
                        <td>Renewal</br>Commi.</td>
                        <td>Renewal</br>Conv.</td>
                        <td>First yr.</br>Commi.</td>
                        <td>Other</br>allow.</td>
                        <td>Target</br>Bonus.</td>
                        <td>Total</td>
                        <td>First</br>Yr. Prem.</td>
                        <td>Renewal</br>Prem.</td>
                        <td>FYP</br>(%)</td>
                        <td>Renewal</br>(%)</td>
                      </tr>
        <?php	
			$query_dev_exp = "select rr.*,ll.PROJECT from 
							(select prj_code,trunc(r)r,trunc(rc,0)rc,trunc(f,0)f,trunc(oa,0)oa,trunc(tb,0)tb,case when fy=0 then 1 else fy end fy,trunc(rn,0)rn,nvl(r,0)+nvl(rc,0)+nvl(f,0)+nvl(oa,0)+nvl(tb,0) exp,round(((nvl(f,0)+nvl(oa,0)+nvl(tb,0))/(case when fy=0 then 1 else fy end)  )*100,2) pcnt  from (
							SELECT PRJ_CODE,PTYPE,nvl(SUM(BONUS),0) BONUS 
							FROM IPL.DEV_EXPENSE
							WHERE BMON BETWEEN '$frdate' AND '$todate' AND NVL(BONUS,0)>0
							GROUP BY PRJ_CODE,PTYPE
							union all
							select DECODE(prj_code,'05','05','24','05',PRJ_CODE) PRJ_CODE,'FY' ,sum(NEW_BUSINESS+DEFERRED+SING0_5+SING6_ABOVE)  
							from ipl.business_stat_all where BMON BETWEEN '$frdate' AND '$todate' and prj_code<>'07'
							group by DECODE(prj_code,'05','05','24','05',PRJ_CODE),'FY'
							union all
							select DECODE(prj_code,'05','05','24','05',PRJ_CODE) PRJ_CODE,'RN' ,sum(renewal)  
							from ipl.business_stat_all where BMON BETWEEN '$frdate' AND '$todate'  and prj_code<>'07'
							group by DECODE(prj_code,'05','05','24','05',PRJ_CODE),'RN'  
							)pivot( sum(bonus) for ptype in ( 'R'R, 'RC'RC, 'F'F,'OA'OA,'TB'TB,'FY'FY,'RN'RN)
							)where (fy+rn)>0 and (nvl(r,0)+nvl(rc,0)+nvl(f,0)+nvl(oa,0)+nvl(tb,0))>0
							order by pcnt desc) rr
							LEFT OUTER JOIN ipl.project ll 
							ON rr.PRJ_CODE = ll.PRJ_CODE";
			$stid_dev_exp = OCIParse($conn, $query_dev_exp);
			OCIExecute($stid_dev_exp);
			while($row_dev_exp= oci_fetch_array($stid_dev_exp))
					{?>
	
                      <tr>
                        <td><?php echo $row_dev_exp[10];?></td>
                        <td><div align="right"><?php echo $row_dev_exp[1];?></div></td>
                        <td><div align="right"><?php echo $row_dev_exp[2];?></div></td>
                        <td><div align="right"><?php echo $row_dev_exp[3];?></div></td>
                        <td><div align="right"><?php echo $row_dev_exp[4];?></div></td>
                        <td><div align="right"><?php echo $row_dev_exp[5];?></div></td>
                        <td><div align="right"><?php echo $row_dev_exp[1]+$row_dev_exp[2]+$row_dev_exp[3]+$row_dev_exp[4]+$row_dev_exp[5];?></div></td>
                        <td><div align="right"><?php echo $row_dev_exp[6];?></div></td>
                        <td><div align="right"><?php echo $row_dev_exp[7];?></div></td>
                        <td><div align="right"><?php echo $row_dev_exp[9];?></div></td>
                        <td><div align="right"><?php echo round((($row_dev_exp[1]+$row_dev_exp[2])*100/$row_dev_exp[7]),2);?></div></td>
                        
                      </tr>

                        
						<?php }
			
			} ?> 
            

                    </table>

                    
                    </div>


    </div>
</div>  

