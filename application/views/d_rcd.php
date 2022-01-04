
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
                <h2><i class="glyphicon glyphicon-home"></i> Project wise Renewal Collection & Due Stamtement</h2>

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
   


<form action="rcd" method="post">
 <div class="row">
  <div class="col-sm-3">  
<input name="fdate" class="datepicker-here" data-language="en" data-min-view="months" data-view="months" data-date-format="MM yyyy" type="text" required="required">
</div>
  <div class="col-sm-3">
   <div class="form-group">

  <select name="proj_co" class="form-control" id="sel1" onchange="this.form.submit()">
			<option :selected>Choose a Project</option>
  <?php
			$query_proj_co = "select PRJ_CODE,PROJECT,INCHARGE from ipl.PROJECT where STATUS='A' and INCHARGE is not null";
			$stid_proj_co = OCIParse($conn, $query_proj_co);
			OCIExecute($stid_proj_co);
			while($row_proj_co= oci_fetch_array($stid_proj_co)){?>
			
    <option value="<?php echo $row_proj_co[0].$row_proj_co[1]; ?>"><?php echo $row_proj_co[1]; ?></option>

    <?php }?>
  </select>
</div> 
  </div>
</div> 
</form>
<?php
if(isset($_POST['proj_co']))  {  
$fdate= $_POST['fdate'];
$frdate=date('Ym', strtotime($fdate));
$p_code= substr($_POST['proj_co'],0,2);
//echo $frdate."</br>".$p_code;
?>

  <div class="row">
    <div class="col-xs-6">Project : <?php echo substr($_POST['proj_co'],2);?></div>
    <div class="col-xs-6"><?php echo $fdate;?></div>
  </div>


 <table class="table table-bordered" style="font-size: 13px !important;">
  <tr>
    <th rowspan="2" class="rotate-45"><div><span>Commancement</br>Year.</span></div></th>
    <th colspan="6"><div align="center">Due</div></th>
    <th colspan="12"><div align="center">Collection</div></th>
    </tr>
  <tr>
    <th><div align="center">Previous</br>yr. Prem.</div></th>
    <th><div align="center">Prev.</br>yr. pol</div></th>
    <th><div align="center">Current</br>yr. Prem.</div></th>
    <th><div align="center">Currnt</br>yr.Pol.</div></th>
    <th><div align="center">Total</br>Prem.</div></th>
    <th><div align="center">Total</br>Policy</div></th>
    <th><div align="center">Previous</br>Yr. Prem.</div></th>
    <th><div align="center">Prev.</br>Yr. Pol</div></th>
    <th><div align="center">Current</br>Yr. Prem.</div></th>
    <th><div align="center">Currnt</div></th>
    <th><div align="center">Total</br>Prem.</div></th>
    <th><div align="center">Total</br>Pol.</div></th>
    <th><div align="center">Prev.</br>Prem.</div></th>
    <th><div align="center">Prev.</br>Pol.</div></th>
    <th><div align="center">Currnt</div></th>
    <th><div align="center">Currnt</br>Pol.</div></th>
    <th><div align="center">Total</br>Prem.</div></th>
    <th><div align="center">Total</br>Pol.</div></th>
  </tr>

  <?php 
			
					$row_rcd_co3=0;
                    $row_rcd_co4=0;
					$row_rcd_co5=0;
					$row_rcd_co6=0;
					$row_rcd_co7=0;
					$row_rcd_co8=0;
					$row_rcd_co9=0;
					$row_rcd_co10=0;
					$row_rcd_co11=0;
					$row_rcd_co12=0;
					$row_rcd_co13=0;
					$row_rcd_co14=0;
					$row_rcd_co15=0;
					$row_rcd_co16=0;
					$row_rcd_co17=0;
					$row_rcd_co18=0;
					$row_rcd_co19=0;
					$row_rcd_co20=0;
					
			$query_code_co = "call ipl.ren_due_new('$p_code','$frdate')";
			$stid_code_co = OCIParse($conn, $query_code_co);
			OCIExecute($stid_code_co);
			
			$query_rcd_co = "select prj_code,mm, '2012 (Up to)' year,
								sum(dprem)dprem,
								sum(dpol) dpol,
								sum (rprem) rprem,
								sum(rpol)rpol,
								sum(ppold)ppold,
								sum(nvl(ppremd,0))ppremd,
								sum(ppolc) ppolc,
								sum(ppremc)ppremc,
								sum(nvl(dprem,0)+nvl(ppremd,0))tdprem,
								sum(nvl(dpol,0)+nvl(ppold,0)) tdpol,
								sum (nvl(rprem,0)+nvl(ppremc,0)) trprem,
								sum(nvl(rpol,0)+nvl(ppolc,0))trpol,
								round(sum(nvl(ppremc,0))/sum(nvl(ppremd,0))*100,0) prmp_r,
								round(sum(ppolc)/sum(ppold)*100,0)polp_r,
								round(sum (rprem)/sum(dprem)*100,0) premc_r,
								round(sum(rpol)/sum(nvl(dpol,0))*100,0) polc_r,
								round(sum (nvl(rprem,0)+nvl(ppremc,0))/sum(nvl(dprem,0)+nvl(ppremd,0))*100,0) prmtt_r,
								round(sum(nvl(rpol,0)+nvl(ppolc,0))/ sum(nvl(dpol,0)+nvl(ppold,0))*100,0 )poltt_r
								from ipl.REN_DUE_RCV where year<='2012' group by prj_code, mm,'2012'
								union all
								select prj_code, mm, year ,
								nvl(dprem,0),
								nvl(dpol,0),
								nvl(rprem,0),
								nvl(rpol,0),
								nvl(ppold,0),
								nvl(ppremd,0),
								nvl(ppolc,0),
								nvl(ppremc,0),
								nvl(dprem,0)+nvl(ppremd,0) tdprem,
								nvl(dpol,0)+nvl(ppold,0)  tdpol,
								nvl(rprem,0)+nvl(ppremc,0)  trprem,
								nvl(rpol,0)+nvl(ppolc,0) trpol ,
								round(nvl(ppremc,0)/(case when nvl(ppremd,0)=0 then
															1 
													   else
													   nvl(ppremd,0)
													  end)
								*100,0) prmp_r,
								round(nvl(ppolc,0)/(case when nvl(ppold,0)=0  then
																	  1
																 else
																nvl(ppold,0)                  
															   end)
									 *100,0)polp_r,
								round(nvl(rprem,0)/nvl(dprem,1)*100,0) premc_r,
								round(nvl(rpol,0)/nvl(dpol,1)*100,0) polc_r,
								round((nvl(rprem,0)+nvl(ppremc,0))/(nvl(dprem,0)+nvl(ppremd,0))*100,0) prmtt_r,
								round((nvl(rpol,0)+nvl(ppolc,0))/(nvl(dpol,0)+nvl(ppold,0))*100,0 )poltt_r
								from ipl.REN_DUE_RCV where year>
								'2012'  and  year< substr(mm,1,4)
								order by year";
			$stid_rcd_co = OCIParse($conn, $query_rcd_co);
			OCIExecute($stid_rcd_co);
			while($row_rcd_co= oci_fetch_array($stid_rcd_co)){
				
				
				    $row_rcd_co3+=$row_rcd_co[3];
                    $row_rcd_co4+=$row_rcd_co[4];
					$row_rcd_co5+=$row_rcd_co[5];
					$row_rcd_co6+=$row_rcd_co[6];
					$row_rcd_co7+=$row_rcd_co[7];
					$row_rcd_co8+=$row_rcd_co[8];
					$row_rcd_co9+=$row_rcd_co[9];
					$row_rcd_co10+=$row_rcd_co[10];
					$row_rcd_co11+=$row_rcd_co[11];
					$row_rcd_co12+=$row_rcd_co[12];
					$row_rcd_co13+=$row_rcd_co[13];
					$row_rcd_co14+=$row_rcd_co[14];
					$row_rcd_co15+=$row_rcd_co[15];
					$row_rcd_co16+=$row_rcd_co[16];
					$row_rcd_co17+=$row_rcd_co[17];
					$row_rcd_co18+=$row_rcd_co[18];
					$row_rcd_co19+=$row_rcd_co[19];
					$row_rcd_co20+=$row_rcd_co[20];
				
				
				
				
				?>
                  <tr>
                    <td><?php echo $row_rcd_co[2];?></td>
                    <td><div align="right"><?php echo $row_rcd_co[3];?></div></td>
                    <td><div align="right"><?php echo $row_rcd_co[4];?></div></td>
                    <td><div align="right"><?php echo $row_rcd_co[5];?></div></td>
                    <td><div align="right"><?php echo $row_rcd_co[6];?></div></td>
                    <td><div align="right"><?php echo $row_rcd_co[7];?></div></td>
                    <td><div align="right"><?php echo $row_rcd_co[8];?></div></td>
                    <td><div align="right"><?php echo $row_rcd_co[9];?></div></td>
                    <td><div align="right"><?php echo $row_rcd_co[10];?></div></td>
                    <td><div align="right"><?php echo $row_rcd_co[11];?></div></td>
                    <td><div align="right"><?php echo $row_rcd_co[12];?></div></td>
                    <td><div align="right"><?php echo $row_rcd_co[13];?></div></td>
                    <td><div align="right"><?php echo $row_rcd_co[14];?></div></td>
                    <td><div align="right"><?php echo $row_rcd_co[15];?></div></td>
                    <td><div align="right"><?php echo $row_rcd_co[16];?></div></td>
                    <td><div align="right"><?php echo $row_rcd_co[17];?></div></td>
                    <td><div align="right"><?php echo $row_rcd_co[18];?></div></td>
                    <td><div align="right"><?php echo $row_rcd_co[19];?></div></td>
                    <td><div align="right"><?php echo $row_rcd_co[20];?></div></td>
                  </tr>
                <?php
			}
		 ?> 

                  <tr>
                    <td>Total</td>
                    <td><div align="right"><?php echo $row_rcd_co3;?></div></td>
                    <td><div align="right"><?php echo $row_rcd_co4;?></div></td>
                    <td><div align="right"><?php echo $row_rcd_co5;?></div></td>
                    <td><div align="right"><?php echo $row_rcd_co6;?></div></td>
                    <td><div align="right"><?php echo $row_rcd_co7;?></div></td>
                    <td><div align="right"><?php echo $row_rcd_co8;?></div></td>
                    <td><div align="right"><?php echo $row_rcd_co9;?></div></td>
                    <td><div align="right"><?php echo $row_rcd_co10;?></div></td>
                    <td><div align="right"><?php echo $row_rcd_co11;?></div></td>
                    <td><div align="right"><?php echo $row_rcd_co12;?></div></td>
                    <td><div align="right"><?php echo $row_rcd_co13;?></div></td>
                    <td><div align="right"><?php echo $row_rcd_co14;?></div></td>
                    <td><div align="right"><?php echo $row_rcd_co15;?></div></td>
                    <td><div align="right"><?php echo $row_rcd_co16;?></div></td>
                    <td><div align="right"><?php echo $row_rcd_co17;?></div></td>
                    <td><div align="right"><?php echo $row_rcd_co18;?></div></td>
                    <td><div align="right"><?php echo $row_rcd_co19;?></div></td>
                    <td><div align="right"><?php echo $row_rcd_co20;?></div></td>
                  </tr>


</table>
<?php }?>

    </div>
</div>  

