<?php if (!defined('BASEPATH')) exit('No direct script access allowed');


class Stock extends CI_Model{
	
	public function add($data){
		$data['id_stock'] = $this->utils->generateUniqueID("stock","id_stock");
		return $this->db->insert("stock",$data);
	}
	
	public function numberofgetexpiredproduct(){
		$num = 0;
		$now = time();
		$stocks = $this->getStocks();
		foreach($stocks as $stock){ 
		$your_date = strtotime($stock['expired_date']);
		$datediff = $your_date - $now ;
		$number_of_days = round($datediff / (60 * 60 * 24));
		$extra_charges=$this->db->from("others")->where("SN","1")->get()->result_array()[0];
		if($stock['expired_date']!="0000-00-00"){
		if($number_of_days <= 0){	
		$num++;
		}
		}
		}
		return $num;	
	}
	
	public function update($stcok_id,$data){
		return $this->db->where("SN",$stcok_id)->update("stock",$data);
	}
	
	public function addStock($product_id,$qty){
			$br = $this->getBranch_id();
			if($br==0){
				$br = $_POST['branch'];
			}
			$stock =$this->getStockByID($product_id);
			$this->db->from("stock_branch");
			$this->db->where("stock_id",$stock['SN']);
			$this->db->where("branch_id",$br);
			$check = $this->db->get();
			if($check->num_rows() >0){
			$stock =$this->getStock($product_id);
			$newqty = $stock['quantity']+$qty;			
			$this->db->where("stock_id",$stock['SN']);
			$this->db->where("branch_id",$br);
			$this->db->update("stock_branch",array('quantity'=>$newqty));
			}else{
				$this->db->insert("stock_branch",array("branch_id"=>$br,"stock_id"=>$stock['SN'],"quantity"=>$qty));
			}
	}
		public function addTohistory($data){
		$insert = array(
							"tracking_id"=>$this->session->userdata("tracking_id"),
							"stock_id"=>$data['stock_id'],
							"amt_in"=>$data['amt_in'],
							"amt_out"=>$data['amt_out'],
							"date_"=>date("Y-m-d"),
							"sold"=>$data['sold'],
							"balance"=>$data['balance'],
							"user"=>$this->users->get_user_by_username($this->session->userdata("username"))->SN
						);
		$this->db->insert("tbl_transfer_recieved",$insert);
	}


	public function removeStock($product_id,$qty,$addtohistroy = TRUE){
			$stock =$this->getStockByID($product_id);
			$newqty = $stock['quantity']-$qty;
			$this->db->where("SN",$stock['SN']);
			$this->db->update("stock",array('quantity'=>$newqty));
	}
	
	public function getStocks($array = false){
		$sts = array();
		$this->db->from("stock");
		if($array!=false){
			foreach($array as $key=>$value){
				$this->db->where($key,$value);
			}
		}
		$this->db->order_by("SN","DESC");
		$stocks = $this->db->get();
		return $stocks->result_array();
	}
	
	
	public function getSellable($array = false){
		$sts = array();
		$this->db->from("stock");
		if($array!=false){
			foreach($array as $key=>$value){
				$this->db->where($key,$value);
			}
		}
		$this->db->where("quantity >","0");
		$this->db->order_by("SN","DESC");
		$stocks = $this->db->get();
		return $stocks->result_array();
	}
	
	
	
	
	public function getStocksToRecieved($array = false){
		$this->db->from("stock");
		if($array!=false){
			foreach($array as $key=>$value){
				$this->db->where($key,$value);
			}
		}
		$history =$this->db->get();
		return $history->result_array();
	
	}
	public function getBranch_id(){
		$get =$this->users->get_user_by_username($this->session->userdata("username"));
		return $get->branch_id;
	}
	
	public function getStock($stock_id){
		$br = $this->getBranch_id();
		$this->db->select("*");
		$this->db->from("stock");
		$this->db->or_where('stock.SN',$stock_id);
		$record =$this->db->get();
		foreach($record->result_array() as $rec);
		return $rec;
	}
	
	public function getStockByID($stock_id){
		$this->db->from("stock");
		$this->db->or_where('SN',$stock_id);
		$this->db->or_where('id_stock',$stock_id);
		$record =$this->db->get();
		foreach($record->result_array() as $rec);
		return $rec;
	
	}
	
	public function stock_data_tables($limit=false,$offset=false,$search=false){
		$_POST['offset'] = ($_POST['offset']=="0" ? false : $_POST['offset']);
		$this->db->from("stock");		
		$this->db->order_by("SN","DESC");
		if($limit!=false && $offset==false){
			$this->db->limit($limit);
		}
		if($limit!=false && $offset!=false){
			$this->db->limit($limit,($offset*$limit));
		}
		if($search!=false){
			$this->db->like('product_name',$search);
		}
		$history =$this->db->get();
		return $history->result_array();
	}
	
	
	public function addManufacturer($data){
		$this->db->insert("manufacturer",$data);
	}
	
	
	public function getManufacturers(){		
		$this->db->from("manufacturer");
		$this->db->order_by("SN","DESC");
		$record =$this->db->get();
		return $record->result_array();
	}
	
	
	public function getManufacturer($id){
		$this->db->from("manufacturer");
		$this->db->order_by("SN","DESC");
		$this->db->where("SN",$id);
		$record =$this->db->get();
		return $record->result_array();
	}
	
	
	
	public function addSupplier($data){
		$this->db->insert("supplier",$data);
	}
	
	
	public function getSuppliers(){		
		$this->db->from("supplier");
		$this->db->order_by("SN","DESC");
		$record =$this->db->get();
		return $record->result_array();
	}
	
	
	public function getSupplier($id){
		$this->db->from("supplier");
		$this->db->order_by("SN","DESC");
		$this->db->where("SN",$id);
		$record =$this->db->get();
		foreach($record->result_array() as $info);
		return $info;
	}
	
	
	
	public function addBranch($data){
		$this->db->insert("branch",$data);
	}
	
	
	public function getBranches(){		
		$this->db->from("branch");
		$this->db->where("delete_status","0");
		$this->db->order_by("SN","DESC");
		$record =$this->db->get();
		return $record->result_array();
	}
	
	
	public function getBranch($id){
		$this->db->from("branch");
		$this->db->order_by("SN","DESC");
		$this->db->where("SN",$id);
		$record =$this->db->get();
		foreach($record->result_array() as $br)
		return $br;
	}
	
	public function getBranch_name($id){
		$this->db->from("branch");
		$this->db->order_by("SN","DESC");
		$this->db->where("SN",$id);
		$record =$this->db->get();
		foreach($record->result_array() as $br)
		return $br['branch_name'];
	}
	
	
	public function update_barcode_status($bar_code,$value){
		// 0 = available
		// 1 = sold
		//2 = transfer
		//3 pickup
		return $this->db->where("bar_code",$bar_code)->update("product_bar_code",array('status'=>$value,'recieved_ref'=>''));
	}
	
	
	public function add_barcode($stock_id,$barcode,$ref_id=FALSE){
		foreach($barcode as $bar){
		$sti =$this->getStock($stock_id);
		$insert_array = array(
								'bar_code'=>$bar,
								'stock_id'=>$sti['SN'],
								'date_available'=>date("Y-m-d"),
								'added_by'=>$this->tank_auth->get_user_id(),
								'recieved_ref' => ($ref_id==FALSE ? '' : $ref_id)
							);
		$this->db->insert("product_bar_code",$insert_array);
		}
	}
	
	public function delete_barcode($bar_code){
		$this->db->where("bar_code",$bar_code)->delete("product_bar_code");
	}
	
	public function transfer_stock($data){
		$product = array();
		
		foreach($data['product'] as $key=>$trns_product){	
			$product[] = array(
								'qty'=>$data['qty'][$key],
								'product'=>$trns_product,
								'remark'=>'transfer',
								'product_barcodes'=>$data['bar_code'][$key]
							);
			}
			$save_data = array();
			$save_data['products']= json_encode($product);
			$save_data['transfer_id'] = $this->utils->generateUniqueID("stock_transfer","transfer_id");
			$save_data['transfer_date'] = $data['transfer_date'];
			$save_data['branch'] = $data['branch'];
			$save_data['reciever_userfullname'] = $data['reciever_userfullname'];
			$save_data['transfer_user'] = $this->tank_auth->get_user_id();
			$save_data['note'] = $data['transfer_note'];
			$save_data['branch_id'] = $this->getBranch_id();
		foreach($product as $key=>$id){
				$this->removeStock($product[$key]['product'],$product[$key]['qty']);
				$product_barcodes = explode(",",$product[$key]['product_barcodes']);
				foreach($product_barcodes as $bar){
				$this->update_barcode_status($bar,2);
				}
			}
		return $this->db->insert("stock_transfer",$save_data);
	}
	
	public function update_stock($transfer_id,$data){
		//first lets reverse what we did to stock list before
		$transfer = $this->getTransferByTransferID($transfer_id);
		$products = json_decode($transfer['products'],TRUE);
		foreach($products  as $key=>$id){
			$this->addStock($products[$key]['product'],$products[$key]['qty']);
			 $barcodes = $products[$key]['product_barcodes'];
			 $barcodes= explode(",",$barcodes);
			 foreach($barcodes as $barcode){
				 $this->update_barcode_status($barcode,0);
			 }
		}
		foreach($data['product'] as $key=>$trns_product){	
			$product[] = array(
								'qty'=>$data['qty'][$key],
								'product'=>$trns_product,
								'remark'=>'transfer',
								'product_barcodes'=>$data['bar_code'][$key]
							);
			}
			$save_data = array();
			$save_data['products']= json_encode($product);
			$save_data['transfer_date'] = $data['transfer_date'];
			$save_data['branch'] = $data['branch'];
			$save_data['reciever_userfullname'] = $data['reciever_userfullname'];
			$save_data['transfer_user'] = $this->tank_auth->get_user_id();
			$save_data['note'] = $data['transfer_note'];
		
		foreach($product as $key=>$id){
				$this->removeStock($product[$key]['product'],$product[$key]['qty']);
				$product_barcodes = explode(",",$product[$key]['product_barcodes']);
				foreach($product_barcodes as $bar){
				$this->update_barcode_status($bar,2);
				}
			}
		return $this->db->where("transfer_id",$transfer_id)->update("stock_transfer",$save_data);
	}
	
	
	
	
	public function getStocktransfers($array=FALSE){
		$br =$this->getBranch_id();
		$this->db->from("stock_transfer");
		if($array!=FALSE){
			foreach($array as $key=>$value){
				$this->db->where($key,$value);
			}
		}
		if($br!=0){
		$this->db->where("branch_id",$br);
		}
		$transfers = $this->db->get();
		return $transfers->result_array();
	}
	
	public function getStocktransfersBetween($from,$to,$array=FALSE){
		$br =$this->getBranch_id();
		$this->db->from("stock_transfer");
		if($array!=FALSE){
			foreach($array as $key=>$value){
				$this->db->where($key,$value);
			}
		}
		if($br==0){
		$this->db->where("(transfer_date BETWEEN '$from' AND '$to')");
		}else{
		$this->db->where("(transfer_date BETWEEN '$from' AND '$to') AND branch_id='$br'");	
		}
		$transfers = $this->db->get();
		return $transfers->result_array();
	}
	
	public function outReport($from,$to,$array=FALSE){
		$br =$this->getBranch_id();
		$total_ =0;
		$this->db->from("stock_transfer");
		if($array!=FALSE){
			foreach($array as $key=>$value){
				$this->db->where($key,$value);
			}
		}
		if($br==0){
		$this->db->where("(transfer_date BETWEEN '$from' AND '$to')");
		}else{
		$this->db->where("(transfer_date BETWEEN '$from' AND '$to') AND branch_id='$br'");	
		}
		$transfers = $this->db->get();
		foreach($transfers->result_array() as $trnx){
			foreach(json_decode($trnx['products'],true) as $pr){
				$total_ = $total_+$pr['qty'];
			}
		}
		return $total_;
	}
	
	public function inReport($from,$to,$array=FALSE){
		$br =$this->getBranch_id();
		$total_ =0;
		$this->db->from("stock_recieved");
		if($array!=FALSE){
			foreach($array as $key=>$value){
				$this->db->where($key,$value);
			}
		}
		if($br==0){
		$this->db->where("(recieved_date BETWEEN '$from' AND '$to')");
		}else{
		$this->db->where("(recieved_date BETWEEN '$from' AND '$to') AND branch_id='$br'");	
		}
		$transfers = $this->db->get();
		foreach($transfers->result_array() as $trnx){
			foreach(json_decode($trnx['products'],true) as $pr){
				$total_ = $total_+$pr['qty'];
			}
		}
		return $total_;
	}
	
	public function getStockrecievedBetween($from,$to,$array=FALSE){
		$br =$this->getBranch_id();
		$this->db->from("stock_recieved");
		if($array!=FALSE){
			foreach($array as $key=>$value){
				$this->db->where($key,$value);
			}
		}
		if($br==0){
		$this->db->where("(recieved_date BETWEEN '$from' AND '$to')");	
		}else{
		$this->db->where("(recieved_date BETWEEN '$from' AND '$to')  AND branch_id='$br'");
		}
		$transfers = $this->db->get();
		return $transfers->result_array();
	}
	
	public function getStockrecieved($array=FALSE){
		$br =$this->getBranch_id();
		$this->db->from("stock_recieved");
		if($array!=FALSE){
			foreach($array as $key=>$value){
				$this->db->where($key,$value);
			}
		}
		if($br!=0){
		$this->db->where("branch_id",$br);
		}
		$transfers = $this->db->get();
		return $transfers->result_array();
	}
	
	
	public function getTransferByTransferID($transfer_id){
		$this->db->from("stock_transfer");
		$this->db->where("transfer_id",$transfer_id);
		$transfer =$this->db->get();
		foreach($transfer->result_array() as $trans);
		return $trans;
	}
	
	public function getReceiveByReceiveID($transfer_id){
		$this->db->from("stock_recieved");
		$this->db->where("recieved_id",$transfer_id);
		$transfer =$this->db->get();
		foreach($transfer->result_array() as $trans);
		return $trans;
	}
	
	public function recieve_stock($data){
		$product = array();
		$recieved_id= $this->utils->generateUniqueID("stock_recieved","recieved_id");
		foreach($data['product'] as $key=>$trns_product){	
					if(isset($data['bar_code'][$key]) && !empty($data['bar_code'][$key])){				
							$product[] = array(
								'qty'=>$data['qty'][$key],
								'product'=>$trns_product,
								'remark'=>'Received',
								'product_barcodes'=>$data['bar_code'][$key]
							);
					$this->add_barcode($trns_product,explode(",",$data['bar_code'][$key]),$recieved_id);
					}else{
						$product[] = array(
								'qty'=>$data['qty'][$key],
								'product'=>$trns_product,
								'remark'=>'Received'
							);
						
					}
			}
			$save_data = array();
			$save_data['products']= json_encode($product);
			$save_data['recieved_id'] = $recieved_id;
			$save_data['recieved_date'] = $data['recieved_date'];
			if(isset($data['branch'])){
			$save_data['branch'] = $data['branch'];
			}else{
			$save_data['supplier'] = $data['supplier'];	
			}
			$save_data['branch_id'] = $this->getBranch_id();
			$save_data['reciever_userfullname'] = $this->tank_auth->get_user_id();;
			$save_data['transfer_user'] = $data['transfer_user'];
			$save_data['note'] = $data['transfer_note'];
			
		foreach($data['product'] as $key=>$id){
				$this->addStock($data['product'][$key],$data['qty'][$key]);
			}
		return $this->db->insert("stock_recieved",$save_data);
	}
	
	public function update_stock_recieved($transfer_id,$data){
		//first lets reverse what we did to stock list before
		$transfer = $this->getReceiveByReceiveID($transfer_id);
		$products = json_decode($transfer['products'],TRUE);
		foreach($products  as $key=>$id){
			$this->removeStock($products[$key]['product'],$products[$key]['qty']);
		}
		foreach($data['product'] as $key=>$trns_product){	
			$product[] = array(
								'qty'=>$data['qty'][$key],
								'product'=>$trns_product,
								'remark'=>'Received'
							);
			}
			$save_data = array();
			$save_data['products']= json_encode($product);
			$save_data['recieved_date'] = $data['recieved_date'];
			if(isset($data['branch'])){
			$save_data['branch'] = $data['branch'];
			}else{
			$save_data['supplier'] = $data['supplier'];	
			}
			$save_data['reciever_userfullname'] = $this->tank_auth->get_user_id();
			$save_data['transfer_user'] = $data['transfer_user'];
			$save_data['note'] = $data['transfer_note'];
		
		
		foreach($product as $key=>$id){
				$this->addStock($data['product'][$key],$data['qty'][$key]);
			}
			
		return $this->db->where("recieved_id",$transfer_id)->update("stock_recieved",$save_data);
	}
	
	
	public function getProductAssociatedWithBarcode($barcode){	
		$this->db->select('*,product_bar_code.status as stock_bar_status');
		$this->db->from("product_bar_code");
		$this->db->where('bar_code', $barcode);
		$this->db->join('stock', 'stock.SN = product_bar_code.stock_id');
		$query = $this->db->get();
		if($query->num_rows() > 0){
		foreach($query->result_array() as $qu);
		return $qu;
		}else{
			return false;
		}
	}
	public function getSale($recipt_id){
		$products =$this->db->from('sales')->where("reciept_id",$recipt_id)->get()->result_array();
		if(count($products) >0){
		foreach($products as $product);
		return $product;
		}
		return false;
	}
	
	
	public function getSales($array=FALSE){
		$br =$this->getBranch_id();
		$this->db->from('sales');
		if($array!=FALSE){
			foreach($array as $key=>$value){
				$this->db->where($key,$value);
			}
		}
		if($br!=0){
		$this->db->where("branch_id",$br);
		}
		$this->db->order_by("SN","DESC");
		return $this->db->get()->result_array();
	}
	public function getSalesRange($from,$to){
		$br =$this->getBranch_id();
		$this->db->from('sales');
		$this->db->where("created BETWEEN '$from' AND '$to'");
		if($br!=0){
		$this->db->where("branch_id",$br);
		}
		$this->db->order_by("SN","DESC");
		return $this->db->get()->result_array();
	}
	public function getSellable_arena($array = false){
		$sts = array();
		$br = $this->getBranch_id();
		$this->db->from("stock");
		$sellable_product = array();
		if($array!=false){
			foreach($array as $key=>$value){
				if($key!="quantity_arena" && $key!="quantity_arena!="){
					$this->db->where($key,$value);
				}
			}
		}
		$stocks = $this->db->get();
		if($stocks->num_rows() > 0){
			$sts = $stocks->result_array();
			foreach($sts as $key=>$value){
				$this->db->from("stock_branch");
				if($array!=false){
					if(array_key_exists("quantity_arena",$array)){
						$this->db->where("quantity_arena",$array['quantity_arena']);
					}
					if(array_key_exists("quantity_arena!=",$array)){
						$this->db->where("quantity_arena!=",$array['quantity_arena!=']);
					}
				}
				if($br!=0){
					$this->db->where("stock_id",$value['SN']);
					$this->db->where("branch_id",$br);
					$quantity_arena =$this->db->get();
					if($quantity_arena->num_rows() > 0){
						foreach($quantity_arena->result_array() as $qty);
						foreach($qty as $key_qty=>$value_qty){
							if($key_qty=="quantity_arena"){
								$sts[$key][$key_qty] = ($value_qty=="" ? "0" : $value_qty);
							}else{
							$sts[$key][$key_qty] =$value_qty;
							}
						}
					}
				}else{
					$this->db->select(" *,SUM(quantity_arena) as quantity_arena");
					$this->db->where("stock_id",$value['SN']);
					$quantity_arena =$this->db->get();
					if($quantity_arena->num_rows() > 0){
						foreach($quantity_arena->result_array() as $qty);
						foreach($qty as $key_qty=>$value_qty){
							if($key_qty=="quantity_arena"){
								$sts[$key][$key_qty] = ($value_qty=="" ? "0" : $value_qty);
							}else{
							$sts[$key][$key_qty] =$value_qty;
							}
						}
					}
				}
			}
		}
		foreach($sts as $s){
			if(isset($s['quantity_arena'])){
			if($s['quantity_arena'] > 0){
			 $sellable_product[] = $s;
			}
			}
		}
		return $sellable_product;
	}
	
}


?>