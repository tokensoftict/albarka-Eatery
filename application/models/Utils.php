<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


Class Utils extends CI_Model{
	
	public function generateUniqueID($for_table,$column){		
		$unique_id = $this->random_num(7);
		$this->db->from($for_table);
		$this->db->where($column,$unique_id);
		$result = $this->db->get();
		if($result->num_rows() > 0){
			return $this->generateUniqueID($for_table,$column);
		}
			return $unique_id;
		
	}
		
	function random_num($size) {
	$alpha_key = '';
	$keys = range('A', 'Z');
	for ($i = 0; $i < 2; $i++) {
		$alpha_key .= $keys[array_rand($keys)];
	}
	$length = $size - 2;
	$key = '';
	$keys = range(0, 9);
	for ($i = 0; $i < $length; $i++) {
		$key .= $keys[array_rand($keys)];
	}
	return time();
	}

	
function random_color_part() {
    return str_pad( dechex( mt_rand( 0, 255 ) ), 2, '0', STR_PAD_LEFT);
}

public function random_color() {
    return "#".$this->random_color_part() . $this->random_color_part() . $this->random_color_part();
}

public function countWorkingDays($start, $end)
{
    $iter = 24*60*60; // whole day in seconds
    $count = 0; // keep a count of Sats & Suns

    for($i = $start; $i <= $end; $i=$i+$iter)
    {
        if(Date('D',$i) != 'Sun')
        {
            $count++;
        }
    }
    return $count;
}

public function getWorkingDaysinRange($start, $end)
{
	$return_date = array();
    $iter = 24*60*60; // whole day in seconds
    $count = 0; // keep a count of Sats & Suns

    for($i = $start; $i <= $end; $i=$i+$iter)
    {
        if(Date('D',$i) != 'Sun')
        {
           $return_date[] = date('Y-m-d',$i);
        }
    }
    return $return_date;
}



public function generate_detailed_report(){
	$last_month = date('Y-m', strtotime('last month'));
	$start = $last_month.'-'.date('27');
	$stop = date('Y').'-'.date('m').'-'."27";
	
	$ranking = array();
	
	$all_daily_total = 0;
	$branch_total = array();
	
	$header =array(
					'SN',
					'DATE'
				);
	$data = array();
	$units = $this->employee->getUnits();
	foreach($units as $unit){
		$unit_name=explode("->",$unit['unit_name']);	
		$header[] = $unit_name[0];
		$branch_total[$unit['SN']] =0;
	}
	$header[] = "DAILY TOTAL";

	$begin = new DateTime($start);
	$end = new DateTime($stop);
	
	$interval = DateInterval::createFromDateString('1 day');
	$period = new DatePeriod($begin, $interval, $end);
	$sn =1;
	foreach ($period as $dt){
		$data[$sn] = array(
							$sn,
							$dt->format('M-d'),
							
						);
		$daily_total =0;
		foreach($units as $unit){
			$this->db->select('sum(amount) as total_sale')->from('tbl_income');
			$this->db->where("department_id",$unit['department_id']);
			$this->db->where("branch_id",$unit['branch_id']);
			$this->db->where("date",$dt->format('Y-m-d'));
			$getIncome_ =$this->db->get()->result_array();
			$sale =($getIncome_[0]['total_sale']=="" ? 0 : $getIncome_[0]['total_sale']);
			$data[$sn][] =number_format($sale,2);
			$daily_total +=$sale;
			$branch_total[$unit['SN']]+=$sale;
		}
		$data[$sn][] =number_format($daily_total,2);
		$all_daily_total+=number_format($daily_total,2);
		$sn ++;
	}
	
	//calculating Gross Total
	$index = $sn++;
	$data[$index]=array(
				"GROSS",
				"TOTAL",
			);
	foreach($branch_total as $br_total){
		$data[$index][] =number_format($br_total,2);
	}
	$data[$index][] =number_format($all_daily_total,2);
	
	//Adding Less Refund
	$index++;
	
	$data[$index] = array(
							"LESS",
							"REFUND",
						);
	$all_total_refund =0;
	foreach($units as $unit){
		$refund =$this->getRefund($unit['department_id'],$unit['branch_id']);
		$data[$index][]=number_format($refund,2);
		$all_total_refund+=$refund;
	}
	$data[$index][]=number_format($all_total_refund,2);
	
	
	
	//Adding Unit Target
	$total_target = 0;
	$index++;
	$data[$index] = array(
						"UNIT",
						"TARGET"
				);
	foreach($units as $unit){
	$data[$index][]	=number_format($unit['target'],2);
	$total_target+=$unit['target'];
	}
	$data[$index][] =number_format($total_target,2);
	
	//Adding Percentage
	$index++;
	$data[$index] = array(
						"UNIT",
						"PERCENTAGE"
				);
	
	$all_branch_sale_total =0;
	foreach($units as $unit){
		//$branch_total
		$per =@($branch_total[$unit['SN']]!=0 ? ceil(($branch_total[$unit['SN']]/$unit['target'])*100) : 0);
		$data[$index][] =$per."%";
		$ranking[$unit['SN']] = $per;		
		$all_branch_sale_total+=$branch_total[$unit['SN']];
	}
	
	$percentage =@(ceil(($all_branch_sale_total-$all_total_refund)/$total_target * 100));
	$data[$index][] = $percentage."%";
	
	//Adding Position to the Excel
	$index++;
	$data[$index] = array(
						"UNIT",
						"REMARK"
				);
	arsort($ranking);
	
	$rank_user = array();

	foreach($units as $unit){
	  $rank_user[$unit['SN']] =$ranking[$unit['SN']];	
	}

	$cache =null;
    $pos=0;
	$re_arrange = array();
	foreach($rank_user as $key=>$value){               
               if($cache!=$value){
                   $pos++;
				   $cache = $value;
                }
				$re_arrange[$key] = $pos;
		
	}
	$data[$index][] = "";
	$data =$this->array_to_csv($header,$data);
	$this->load->helper('file');
	$this->load->helper('download');
	$filename = "detailed_monthly_report.csv";
	force_download($filename, $data);
}


public function getRefund($department_id,$branch_id){
	$last_month = date('Y-m', strtotime('last month'));
	$start_ = $last_month.'-'.date('27');
	$stop_ = date('Y').'-'.date('m').'-'."27";
	$this->db->select('sum(amount) as total_refund')->from('tbl_refund');
	$this->db->where("date BETWEEN '".$start_."' AND '".$stop_."'");
	$this->db->where("department_id",$department_id);
	$this->db->where("branch_id",$branch_id);
	$getRefund_  =$this->db->get()->result_array();
	return ($getRefund_[0]['total_refund']=="" ? 0 : $getRefund_[0]['total_refund']);
}


function array_to_csv($fields,$query, $delim = ",",  $newline = "\r\n", $enclosure = '"'){
$out = '';
foreach ($fields as $name)
{
$out .= $enclosure.str_replace($enclosure, $enclosure.$enclosure, $name).$enclosure.$delim;
}
$out = rtrim($out);
$out .= $newline;
foreach ($query as $row)
{
foreach ($row as $item)
{
$out .= $enclosure.str_replace($enclosure, $enclosure.$enclosure, $item).$enclosure.$delim;
}
$out = rtrim($out);
$out .= $newline;
}
return $out;
}




}
?>