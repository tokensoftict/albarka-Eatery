<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard extends CI_Controller
{
	function __construct()
	{
		parent::__construct();

		$this->load->helper('url');
		$this->load->library('tank_auth');
		$this->load->model("utils");
		$this->load->model("users");
		$this->load->model("stock");
		$this->load->model("settings");
		$this->load->model("invoice");
		if (!$this->tank_auth->is_logged_in()) {
			redirect('/auth/login/');
		}
	}

	function index()
	{
			$data = array();
			$data['page'] = 'dashboard';
			$this->load->view('page/heading',$data);
			$this->load->view('page/footer',$data);
	
	}
	
	public function view_sales($id){
	 $data['page'] = 'view_sales';
	  $this->load->view('page/heading',$data);
	  $this->load->view('page/footer',$data);
	}


	public function list_sales(){
	    $data = [];
        $this->load->view('page/dailysales',$data);
    }

    public function list_order(){
        $data = [];
        $this->load->view('page/dailyorder',$data);
    }

	public function mark_as_paid($id){
	    $in = $this->stock->getOrder($id);
	    if($in['status'] !="1") {
            unset($in['status']);
            $user = $this->tank_auth->get_user_id();
            if($this->stock->getSale($id) == false) {
                $this->db->insert('sales', $in);
                $this->db->insert("tbl_payment", array(
                    'payment_id' => $this->utils->generateUniqueID('tbl_payment', 'payment_id'),
                    'amount' => $in['total_amount'],
                    'invoice_id' => $in['reciept_id'],
                    'type' => 'Canteen',
                    'department' => 'Sales Arena',
                    'payment_type' => 'Direct',
                    'payment_date' => date('Y-m-d'),
                    'user' => $user,
                    'payment_method_id'=>$in['total_amount'],
                    'branch_id' => $this->stock->getBranch_id(),
                    'vat' => $in['vat'],
                    'scharge' => $in['scharge']
                ));
            }
            $this->db->where('SN', $id)->update('tbl_invoice_history', ['status' => 1]);
        }
        $this->session->set_flashdata("success","Operation Successfull!!...");
        if($_GET['back'] == "dash"){
            redirect('dashboard/view_orders/'.$in['reciept_id']);
        }else{
            redirect('dashboard/pos');
        }

    }

	public function view_orders($id){
	 $data['page'] = 'view_orders';
	  $this->load->view('page/heading',$data);
	  $this->load->view('page/footer',$data);
	}
	
	function stock()
	{
			$data = array();
			$data['page'] = 'stock';
			$this->load->model("stock");
			$data['stocks'] = $this->stock->getStocks();
			$this->load->view('page/heading',$data);
			$this->load->view('page/footer',$data);
		
	}
	
	function set_availability($product_id,$status){
		$this->db->where("SN",$product_id)->update("stock",array('status'=>$status));
		$this->session->set_flashdata("success","Operation Successfull!!...");
		redirect('dashboard/stock');
	}
	function new_stock()
	{
			$data = array();
			$this->load->model("stock");
			$data['page'] = 'new_stock';
			$this->load->view('page/heading',$data);
			$this->load->view('page/footer',$data);
		
	}
	
	
	function save_new_stock(){
		
		$data = $_POST;
		
		$this->session->set_flashdata("success","Stock Added Successfully!!...");
		$this->load->model("stock");
		$this->stock->add($data);
		redirect('dashboard/new_stock');
	}
	
	function edit_stock($stock_id){
		$data = array();
		$this->load->model("stock");
		$data['page'] = 'edit_stock';
		$stock = $this->stock->getStock($stock_id);
		$data['stock'] = $stock[0];
		$this->load->view('page/heading',$data);
		$this->load->view('page/footer',$data);
	}
	
	function update_stock($stock_id){
		$this->load->model("stock");
		$stock =$this->stock->getStock($stock_id);


	
		$data = $_POST;
		

		
		$this->session->set_flashdata("success","Stock Updated Successfully!!...");
		
		$this->stock->update($stock_id,$data);
		redirect('dashboard/stock');
	}
	
	function move_to_sales_arena($stock_id){
		$this->load->model("stock");
		if(count($_POST)){
			$stock =$this->stock->getStock($stock_id);
			$qty = ( $stock['quantity'] -$_POST['qty_to_move'] );
			$new_m_qty =  $stock['quantity_arena']+ $_POST['qty_to_move'] ;
			
			if(!($qty < 0)){
				$this->db->where("branch_id",$this->stock->getBranch_id())->where("stock_id",$stock_id)->update("stock_branch",array("quantity"=>$qty,"quantity_arena"=>$new_m_qty));
				$array_insert = array(
										'stock_id'=>$stock_id,
										'from'=>'Store',
										'to'=> 'Sales Arena',
										'date'=>date('Y-m-d'),
										'qty_moved'=>$_POST['qty_to_move'],
										'remaining_qty'=>$qty
									);
				$this->db->insert("moved_history",$array_insert);
				$this->session->set_flashdata("success","Stock Moved to Sales Arena Successfully!!..");
				redirect("dashboard/stock");
			}else{
				$this->session->set_flashdata("error ","Insufficient Quantity to Moved, Check and try Again..");
				redirect("dashboard/move_to_sales_arena/".$stock_id);
			}
		}
		$this->load->model("stock");
		$data['page'] = 'move_to_sales_arena';
		$data['stock'] = $this->stock->getStock($stock_id);
		$this->load->view('page/heading',$data);
		$this->load->view('page/footer',$data);
	}
	
	function move_to_store($stock_id){
		$this->load->model("stock");
		if(count($_POST)){
			$stock =$this->stock->getStock($stock_id);
			$qty = ($stock['quantity_arena'] - $_POST['qty_to_move']);
			$new_m_qty =  $stock['quantity']+ $_POST['qty_to_move'] ;
			if(!($qty < 0)){
				$this->db->where("branch_id",$this->stock->getBranch_id())->where("stock_id",$stock_id)->update("stock_branch",array("quantity"=>$new_m_qty,"quantity_arena"=>$qty));
				
				$array_insert = array(
										'stock_id'=>$stock_id,
										'from'=>'Sales Arena',
										'to'=> 'Store',
										'date'=>date('Y-m-d'),
										'qty_moved'=>$_POST['qty_to_move'],
										'remaining_qty'=>$new_m_qty
									);
				$this->db->insert("moved_history",$array_insert);
				$this->session->set_flashdata("success","Stock Moved back to Store Successfully!!..");
				redirect("dashboard/stock");
			}else{
				$this->session->set_flashdata("error","Insufficient Quantity to Moved, Check and try Again..");
				redirect("dashboard/move_to_store/".$stock_id);
			}
		}
		$this->load->model("stock");
		$data['page'] = 'move_to_store';
		$data['stock'] = $this->stock->getStock($stock_id);
		$this->load->view('page/heading',$data);
		$this->load->view('page/footer',$data);
	}
	
	function settings($user_id=FALSE){
	 if(isset($_GET['del']) && $user_id!=FALSE){
			$this->db->set('activated', $_GET['del']);
			$this->db->where('id', $user_id);
			$this->db->update('users');
			redirect('dashboard/settings');
		}
		
		if(count($_POST)>0){
			$this->load->library("tank_auth");		
			$this->tank_auth->create_user($_POST['username'],$_POST['email'],$_POST['password'],0,$_POST['role'],$this->config->item('email_activation', 'tank_auth'));
			redirect('dashboard/settings');
		}
		$data = array();
		$data['page'] = 'settings';
		$this->load->view('page/heading',$data);
		$this->load->view('page/footer',$data);
	}
	
	function user_manager(){
	redirect('dashboard/settings');
	}
	
	
	function manufacturer(){
		$this->load->model('stock');
		if(count($_POST)>0){
			$this->stock->addManufacturer($_POST);
			$this->session->set_flashdata("success","Manufacturer Added Successfully!!...");
			redirect('dashboard/manufacturer');
		}
		if(isset($_GET['del'])){
			$this->db->where("SN",$this->uri->segment(3))->delete("manufacturer");
			$this->session->set_flashdata("success","Manufacturer deleted Successfully!!...");
			redirect('dashboard/manufacturer');
		}
		$data = array();
		$data['page'] = 'manufacturer';
		$this->load->view('page/heading',$data);
		$this->load->view('page/footer',$data);
	}
	
	
	function supplier(){
		
		$this->load->model('stock');
		if(count($_POST)>0){
			$this->stock->addSupplier($_POST);
			$this->session->set_flashdata("success","Supplier Added Successfully!!...");
			redirect('dashboard/supplier');
		}
		if(isset($_GET['del'])){
			$this->db->where("SN",$this->uri->segment(3))->delete("supplier");
			$this->session->set_flashdata("success","Supplier deleted Successfully!!...");
			redirect('dashboard/supplier');
		}
		
		$data = array();
		$data['page'] = 'supplier';
		$this->load->view('page/heading',$data);
		$this->load->view('page/footer',$data);
		
	}
	
	
	function branch(){
			$this->load->model('stock');
		if(count($_POST)>0){
			$this->stock->addBranch($_POST);
			$this->session->set_flashdata("success","Branch Added Successfully!!...");
			redirect('dashboard/branch');
		}
		if(isset($_GET['del'])){
			$this->db->where("SN",$this->uri->segment(3))->update("branch",array("delete_status"=>"1"));
			$this->session->set_flashdata("success","Branch deleted Successfully!!...");
			redirect('dashboard/branch');
		}
		
		$data = array();
		$data['page'] = 'branch';
		$this->load->view('page/heading',$data);
		$this->load->view('page/footer',$data);
		
	}
	
	
	public function stock_transfer(){
		$this->load->model("stock");
		$data = array();
		$data['page'] = 'stock_transfer';
		$this->load->view('page/heading',$data);
		$this->load->view('page/footer',$data);
	}
	
	public function new_transfer(){
		$this->load->model("stock");
		if(count($_POST)){
			$this->stock->transfer_stock($_POST);
			$this->session->set_flashdata("success","Stock Transfer has been added Successfully!!...");
			redirect('dashboard/new_transfer');
		}
		$this->load->model("stock");
		$data = array();
		$data['page'] = 'new_transfer';
		$this->load->view('page/heading',$data);
		$this->load->view('page/footer',$data);
	}
	
	
	public function viewtransfer(){
		$this->load->model("stock");
		$data = array();
		$data['page'] = 'view_transfer';
		$data['transfer'] = $this->stock->getTransferByTransferID($this->uri->segment(3));
		$this->load->view('page/heading',$data);
		$this->load->view('page/footer',$data);
	}
	
	public function edit_transfer(){
		$this->load->model("stock");
		$data = array();
		$data['page'] = 'edit_transfer';
		$data['transfer'] = $this->stock->getTransferByTransferID($this->uri->segment(3));
		
		$this->load->view('page/heading',$data);
		$this->load->view('page/footer',$data);
	}
	
	public function update_transfer($transfer_id){
		$this->load->model("stock");
		$this->stock->update_stock($transfer_id,$_POST);
		$this->session->set_flashdata("success","Stock Transfer has been updated Successfully!!...");
		redirect("dashboard/viewtransfer/".$transfer_id);
	}
	
	public function stock_recieved(){
		$this->load->model("stock");
		$data = array();
		$data['page'] = 'stock_recieved';
		$this->load->view('page/heading',$data);
		$this->load->view('page/footer',$data);
	}
	
	
	public function new_recieved_supplier(){
		$this->load->model("stock");
		if(count($_POST) >0){
			$this->stock->recieve_stock($_POST);
			$this->session->set_flashdata("success","Stock Received has been added Successfully!!...");
			redirect('dashboard/new_recieved_supplier');
		}
		$data = array();
		$data['page'] = 'new_recieved_supplier';
		$this->load->view('page/heading',$data);
		$this->load->view('page/footer',$data);
		
	}
	public function new_recieved_branch(){
		$this->load->model("stock");
		if(count($_POST) >0){
			$this->stock->recieve_stock($_POST);
			$this->session->set_flashdata("success","Stock Received has been added Successfully!!...");
			redirect('dashboard/new_recieved_branch');
		}
		$data = array();
		$data['page'] = 'new_recieved_branch';
		$this->load->view('page/heading',$data);
		$this->load->view('page/footer',$data);
		
	}
	
	
	public function view_received(){
		$this->load->model("stock");
		$data = array();
		$data['page'] = 'view_received';
		$data['transfer'] = $this->stock->getReceiveByReceiveID($this->uri->segment(3));
		$this->load->view('page/heading',$data);
		$this->load->view('page/footer',$data);
	}
	
	
	
	public function edit_received(){
		$this->load->model("stock");
		$data = array();
		$data['page'] = 'edit_recieved';
		$data['transfer'] = $this->stock->getReceiveByReceiveID($this->uri->segment(3));
		$this->load->view('page/heading',$data);
		$this->load->view('page/footer',$data);
	}
	
	public function update_received($transfer_id){
		$this->load->model("stock");
		$this->stock->update_stock_recieved($transfer_id,$_POST);
		$this->session->set_flashdata("success","Stock Received has been updated Successfully!!...");
		redirect("dashboard/view_received/".$transfer_id);
	}
	
	
	public function transfer_stock_report(){
		$this->load->model("stock");
		$data = array();
		$data['page'] = 'transfer_stock_report';
		$this->load->view('page/heading',$data);
		$this->load->view('page/footer',$data);
	}
	public function recieved_stock_report(){
		$this->load->model("stock");
		$data = array();
		$data['page'] = 'recieved_stock_report';
		$this->load->view('page/heading',$data);
		$this->load->view('page/footer',$data);
	}
	public function stock_pick_up_report(){
		$this->load->model("stock");
		$data = array();
		$data['page'] = 'stock_pick_up_report';
		$this->load->view('page/heading',$data);
		$this->load->view('page/footer',$data);
	}
	
	public function rma(){
		$this->load->model("stock");
		$data = array();
		$data['page'] = 'rma';
		$this->load->view('page/heading',$data);
		$this->load->view('page/footer',$data);
		
	}
	public function newrma(){
		$this->load->model("stock");
		if(count($_POST) >0){
			$this->stock->addRMA($_POST);
			$this->session->set_flashdata("success","RMA Data has been added Successfully!!...");
			redirect("dashboard/newrma");
		}
		$this->load->model("stock");
		$data = array();
		$data['page'] = 'newrma';
		$this->load->view('page/heading',$data);
		$this->load->view('page/footer',$data);
		
	}
	
	
	public function perform_rma_action($rma_id,$action){
		$this->load->model("stock");
		$data = array();
		if(count($_POST) >0){
			if($_POST['btn'] =="Draft"){
				unset($_POST['btn']);
				$_POST['rma_action'] = $action;
				$this->db->where('rma_id',$rma_id)->update("rma_data",$_POST);
			}else{
				
			}
		}
		$data['page'] = 'rma_operation';
		$data['rma'] = $this->stock->getRMA($rma_id);
		$data['action']= $action;
		$this->load->view('page/heading',$data);
		$this->load->view('page/footer',$data);
	}
	
	public function rma_forms($rma_id){
		//0 ---> engineer Form
		//1 ---> Back to Supplier form
		//2 ---> Replaced for the customer form
		$data = array();
		$data['rma'] = $this->stock->getRMA($rma_id);
		$form_id = $_GET['id'];
		if($form_id == "1"){
			$this->load->view('page/rma_engineer',$data);
		}else{
			$this->load->view('page/rma_customer_form',$data);
		}
	
	}
	
	
	public function load_replaced_by_form($rma_id=0,$which = FALSE){
		$data = array();
		$data['rma'] = $this->stock->getRMA($rma_id);
		if($which != FALSE){
			if($which =="1"){
				$this->load->view('page/replace_by_femtechit',$data);
			}else{
				$this->load->view('page/replace_by_supplier',$data);
			}
		}
	}
	
	public function load_sent_to_engineer($rma_id=0,$which = FALSE){
		$data = array();
		$data['rma'] = $this->stock->getRMA($rma_id);
		if($which != FALSE){
			if($which =="1"){
				$this->load->view('page/femtechit_engineer',$data);
			}else{
				$this->load->view('page/warranty_engineer',$data);
			}
		}
	}
	
	public function getProductAssociatedWithBarcode(){
		$barcode= $_GET['barcode'];
		$product = $this->stock->getProductAssociatedWithBarcode($barcode);
		if($product!=false){
			if($product['stock_bar_status'] == "1"){
				die(json_encode(array('status'=>false,'message'=>'Product has been sold already')));
			}else if($product['stock_bar_status'] == "2"){
					die(json_encode(array('status'=>false,'message'=>'Product has already been transferred')));
			}else{
				die(json_encode($product));
			}
		}else{
			die(json_encode(array('status'=>false,'message'=>'Product not Found!!...')));
		}
	}
	
	public function getProductAssociatedWithBarcodePickup(){
		$barcode= $_GET['barcode'];
		$product = $this->stock->getProductAssociatedWithBarcode($barcode);
		if($product!=false){
			if($product['stock_bar_status'] == "1"){
				die(json_encode(array('status'=>false,'message'=>'Product has been sold already')));
			}else if($product['stock_bar_status'] == "2"){
					die(json_encode(array('status'=>false,'message'=>'Product has already been transferred')));
			}else{
				$check_if_exist =$this->db->from("stock_pickup_items")->where("product_barcode",$barcode)->where("status","0")->get();
				if($check_if_exist->num_rows() >0){
					foreach($check_if_exist->result_array() as $exist);
					die(json_encode(array('status'=>false,'message'=>'Product has been pick by '.$exist['pickUpstaff'].' on '.$exist['pickup_date'])));
				}else{
					die(json_encode($product));
				}
			}
		}else{
			die(json_encode(array('status'=>false,'message'=>'Product not Found!!...')));
		}
	}
	
	
	public function view_stock_list($stock_id=0){
		$this->load->model("stock");
		$data = array();
		$data['page'] = 'view_stock_list';
		$this->load->view('page/heading',$data);
		$this->load->view('page/footer',$data);	
	}
	
	public function addPickUp(){
		$this->load->model("stock");
		$this->stock->addPickUp($_POST);
		die(json_encode(array("status"=>true, 'msg'=>"Stock pickup data was saved successfully")));
	}
	
	
	public function update_pick_up_status($sn=false){
		if($sn!=false){
			$this->load->model("stock");
			if($_POST['value'] == "returned"){				
				$pick =$this->stock->getPick($sn);
				$stock =$this->stock->getStock($pick['product']);
				$this->stock->addStock($pick['product'],1);
				$this->db->where("SN",$sn)->update("stock_pickup_items",array("status"=>"1"));
				if(!empty($pick['product_barcode'])){
					$this->db->where("bar_code")->update(array('status'=>0));
				}
				die(json_encode(array("status"=>true,"message"=>'<span class="label label-primary">Returned</span>')));
			}else if($_POST['value'] == "sold"){
				$pick =$this->stock->getPick($sn);
				$stock =$this->stock->getStock($pick['product']);
				$this->db->where("SN",$sn)->update("stock_pickup_items",array("status"=>"3"));
				if(!empty($pick['product_barcode'])){
					$this->db->where("bar_code")->update(array('status'=>1));
				}
				die(json_encode(array("status"=>true,"message"=>'<span class="label label-success">Sold</span>')));
			}else{
				$pick =$this->stock->getPick($sn);
				$stock =$this->stock->getStock($pick['product']);
				$this->stock->addArenaStock($pick['product'],1);
				$this->db->where("SN",$sn)->update("stock_pickup_items",array("status"=>"2"));
				if(!empty($pick['product_barcode'])){
					$this->db->where("bar_code")->update(array('status'=>0));
				}
				//status of pick up
											//0 ---> pending
											//1----> returned
											//2----> moved to arena
											//3----> sold
				die(json_encode(array("status"=>true,"message"=>'<span class="label label-primary">In-Arena</span>')));
			}
		}
	}
	
	
	public function mark_rma_as_completed($rma_id=FALSE,$extra){
		if($rma_id!=false){
			$this->db->where("rma_id",$rma_id)->update("rma",array("status"=>"1"));
				$this->session->set_flashdata("success","RMA Operation Marked Completed");
			redirect(base_url('dashboard/perform_rma_action/'.$rma_id.'/'.$extra));
		}
	}
	
	
	public function pos(){
		$this->load->view("pos/terminal");
	}
	
	
	public function posSave(){
	    $split_method_id = 'SPLIT';
		$cart = $_POST['cart'];
		$user = $this->tank_auth->get_user_id();
		$save_array['reciept_id'] = $this->utils->generateUniqueID('sales','reciept_id');
		$save_array['discount_type'] = $_POST['discount_type'];
		$save_array['comment'] = $_POST['comment'];
		$save_array['date'] = date('Y-m-d');
		$save_array['order_type'] = $_POST['order_type'];
		$save_array['discount'] = $_POST['discount'];
		$save_array['waiter_id'] = $_POST['waiter_id'];
		$save_array['payment_method'] = $_POST['payment_method'];
		$save_array['user_id'] =$user;
		$save_array['time_'] =date("h:i a");
		$total = 0;
		$savings = array();
		if(isset($_POST['branch_id'])){
			$branch_id = $_POST['branch_id'];
		}else{
			$branch_id = $this->stock->getBranch_id();
		}
		$save_array['branch_id'] = $branch_id;
		foreach($cart as $key=>$value){
			$item = $this->stock->getStock($key);
			$item = $item[0];
			if($item['countable'] == "1") {
                $this->stock->removeStock($item['SN'], $value);
            }
			$savings[]=array(
							'item_name'=>$item['product_name'],
							'item_price'=>$item['price'],
							'item_qty'=>$value,
							'total'=>($value*$item['price']),
							'manu'=>$item['manufacturer_date'],
							'exp'=>$item['expired_date']
						);
			$total+=($value*$item['price']);
		}
		if($_POST['discount']!=0){
			if($_POST['discount_type']=="1"){
				$save_array['discount']=($_POST['discount']/100)+$total;
			}
		}
		$vat = ($this->settings->getSettings()['vat']/100)*$total;
		$scharge =($this->settings->getSettings()['scharge']/100)*$total;
		$othertotal = $total - $save_array['discount'];
		$othertotal = $othertotal+$vat+$scharge;
		$save_array['total_amount'] = $total;
		$save_array['items'] = json_encode($savings);
		if(isset($_POST['invoice'])){
			$save_array['payment_type'] = "Invoice";
		}
		if(isset($_POST['customer_id'])){
			$save_array['customer'] = $_POST['customer_id'];
		}else{
			$save_array['customer'] = "Walking Customer"; 
		}
		$save_array['vat'] = $this->settings->getSettings()['vat'];
		$save_array['scharge'] = $this->settings->getSettings()['scharge'];
		if($_POST['order_type'] == "ORDER"){
            $this->db->insert("tbl_invoice_history",$save_array);
        }else{
            $this->db->insert("sales",$save_array);
        }
		if(isset($_POST['invoice'])){
			$this->db->insert("tbl_invoice_history",array(
				'type'=>'Canteen',
				'invoice_id'=>$save_array['reciept_id'],
				'department'=>'Sales Arena',
				'amount'=>$othertotal,
				'user_created'=>$user,
				'last_modeified_user'=>$user,
				'date_added'=>date('Y-m-d'),
				'customer'=>$_POST['customer_id'],
				'invoice_item'=>json_encode($savings),
				'branch_id'=>$branch_id,
				'vat'=>$this->settings->getSettings()['vat'],
				'scharge'=>$this->settings->getSettings()['scharge']
			));
		}else{
		    if($save_array['payment_method'] == $split_method_id){
                $splits = $_POST['split_method'];
                foreach ($splits as $key=>$split){
                    $this->db->insert("tbl_payment", array(
                        'payment_id' => $this->utils->generateUniqueID('tbl_payment', 'payment_id'),
                        'amount' => $split,
                        'invoice_id' => $save_array['reciept_id'],
                        'type' => 'Canteen',
                        'department' => 'Sales Arena',
                        'payment_type' => 'Direct',
                        'payment_date' => date('Y-m-d'),
                        'user' => $user,
                        'payment_method_id'=>$key,
                        'branch_id' => $branch_id,
                        'vat' => $this->settings->getSettings()['vat'],
                        'scharge' => $this->settings->getSettings()['scharge']
                    ));
                }
            }else {
                $this->db->insert("tbl_payment", array(
                    'payment_id' => $this->utils->generateUniqueID('tbl_payment', 'payment_id'),
                    'amount' => $othertotal,
                    'invoice_id' => $save_array['reciept_id'],
                    'type' => 'Canteen',
                    'department' => 'Sales Arena',
                    'payment_type' => 'Direct',
                    'payment_date' => date('Y-m-d'),
                    'user' => $user,
                    'payment_method_id'=>$save_array['payment_method'],
                    'branch_id' => $branch_id,
                    'vat' => $this->settings->getSettings()['vat'],
                    'scharge' => $this->settings->getSettings()['scharge']
                ));
            }
		}
		if(!isset($_POST['invoice'])){
            if($_POST['order_type'] == "ORDER"){
                die(json_encode(array('status'=>true,'print'=>base_url('dashboard/print_order/'.$save_array['reciept_id']))));
            }else{
                die(json_encode(array('status'=>true,'print'=>base_url('dashboard/print_recipt/'.$save_array['reciept_id']))));
            }
		}else{
		die(json_encode(array('status'=>true)));	
		}
	}
	
	public function refresh_stock_list(){
		$items = $this->stock->getSellable();
	   if(count($items) >0){
	   foreach($items as $item){
		echo '<div data-qty="'.$item['quantity'].'" data-track="1" data-amount="'.$item['price'] .'" data-id="'.$item['SN'].'" data-item-name="'.$item['product_name'].'" onclick="addTocart(this)" class="col-lg-3 col-md-3 col-xs-6 shop-items filter-add-product noselect text-center" style="padding:5px; border-right: solid 1px #DEDEDE;border-top: solid 1px #DEDEDE;border-bottom: solid 1px #DEDEDE;" data-design="velvet v-neck body suit"><img data-original="'.$this->settings->getSettings()['slogo'].'" style="max-height: 64px; display: block;" class="img-responsive img-rounded lazy" src="'.$this->settings->getSettings()['slogo'] .'"><div class="caption text-center" style="padding:2px;overflow:hidden;"><strong class="item-grid-title"><span class="marquee_me">'.$item['product_name'] .'</span></strong><br><span class="align-center">&#8358;'. number_format($item['price'],2).'</span></div></div>'; 
	   }
	   }else{
		   echo '<h2 align="center" style="margin-top:28%;">No Available Product!..<h2>';
	   }
	}
	
	public function print_recipt($reciept_id){
			$res = $this->stock->getSale($reciept_id);
			$data['payment'] = $res;
			$this->load->view('print/pos_recipt_print',$data);
	}

	public function print_order($reciept_id){
			$res = $this->stock->getOrder($reciept_id);
			$data['payment'] = $res;
			$this->load->view('print/pos_order_print',$data);
	}
	
	public function sales(){
		$this->load->model("stock");
		$data = array();
		$data['page'] = 'sales';
		$this->load->view('page/heading',$data);
		$this->load->view('page/footer',$data);
	}

	public function order(){
		$this->load->model("stock");
		$data = array();
		$data['page'] = 'order';
		$this->load->view('page/heading',$data);
		$this->load->view('page/footer',$data);
	}
	
	 public function Invoice($invoice_id=false){
	   if($invoice_id==false){
		   redirect('dashboard/invoices');
	   }
	   if(isset($_GET['markAspaid'])){
		 $invoice= $this->invoice->getInvoice($invoice_id);
		 $this->invoice->markAspaid($invoice_id);
		 $this->session->set_flashdata("success","Operation Successfull!!...");
		 redirect('dashboard/Invoice/'.$invoice_id);
	   }
	   $data = array();
	   $data['invoice'] = $this->invoice->getInvoice($invoice_id);
	   $this->load->view("print/invoice.print_canteen.php",$data); 
   }
   
   
   public function invoices(){
	  $this->load->model("stock");
	  $data = array();
	  $data['page'] = 'invoices';
	  $this->load->view('page/heading',$data);
	  $this->load->view('page/footer',$data); 
   }
   
   
   public function sales_report(){
	  $data['page'] = 'sales_report';
	  $this->load->view('page/heading',$data);
	  $this->load->view('page/footer',$data); 
   }

   public function order_report(){
	  $data['page'] = 'order_report';
	  $this->load->view('page/heading',$data);
	  $this->load->view('page/footer',$data);
   }
   
   public function invoice_report(){
	  $data['page'] = 'invoice_report';
	  $this->load->view('page/heading',$data);
	  $this->load->view('page/footer',$data); 
   }
   
   public function myprofile(){
	   if(count($_POST) >0){
		   $this->db->where("id",$this->session->userdata("user_id"));
		   $this->db->update("users",array("username"=>$_POST['username'],'email'=>$_POST['email']));
		   $this->session->set_flashdata("success","Operation Successful!!...");
		   if(isset($_POST['password']) && !(empty($_POST['password']))){
			   $this->users->change_password($this->session->userdata("user_id"),$_POST['password']);
			   $this->session->set_flashdata("success","Operation Successful!!... Password has been Updated Successfully too.");
		   }
	   }
	   
	  $data['page'] = 'myprofile';
	  $this->load->view('page/heading',$data);
	  $this->load->view('page/footer',$data); 
	  
   }


  public function extra_charges(){
	  if(count($_POST)){		  
		if(!empty($_FILES['slogo']['name'])){ 
			if(getimagesize($_FILES['slogo']['tmp_name'])){
				$getImage = explode("/",$this->settings->getSettings()['slogo']);
				$getImage = $getImage[count($getImage)-1];
				if($getImage!="default.png"){
				@unlink("store_assets/".$getImage);
				}
				$extenstion = pathinfo($_FILES['slogo']['name'])['extension'];
				$store_image_name = time().'-'.'store_logo.'.$extenstion;
				move_uploaded_file($_FILES['slogo']['tmp_name'],'store_assets/'.$store_image_name);
				$_POST['slogo'] = base_url("store_assets/".$store_image_name);
			}
		}
		$this->db->where("SN","1")->update("others",$_POST);
		 $this->session->set_flashdata("success","Operation Successful!!...");
		redirect("dashboard/extra_charges");
	  }
	  $data['page'] = 'extra_charges';
	  $this->load->view('page/heading',$data);
	  $this->load->view('page/footer',$data); 
  }
  
  public function edit_settings($user_id){
		if(count($_POST)>0){
			$this->load->library("tank_auth");		
			$this->tank_auth->create_user($_POST['username'],$_POST['email'],$_POST['password'],$_POST['branch_id'],$_POST['role'],$this->config->item('email_activation', 'tank_auth'));
			redirect('dashboard/settings');
		}
		$data = array();
		$data['page'] = 'edit_settings';
		$this->load->view('page/heading',$data);
		$this->load->view('page/footer',$data);
  		
  }

  public function branch_has_been_deleted(){
	 $this->load->view('page/branch_has_been_deleted',$data);
  }
  
  
  public function backup(){
	 $data['page'] = 'backup';
	  $this->load->view('page/heading',$data);
	  $this->load->view('page/footer',$data);  
  }
  
     public function restore_database(){
		if(isset($_POST['restore_btn'])){
			if(file_exists($_FILES['restore']['tmp_name']) && is_uploaded_file($_FILES['restore']['tmp_name'])){
				$ext = pathinfo($_FILES['restore']['name']);
				if($ext['extension'] == "sql"){
					$filename=$_FILES['restore']['name'];
					$filepath=$_FILES['restore']['tmp_name'];	
					move_uploaded_file($filepath,'application/'.$filename);
					if($lines=file_get_contents('application/'.$filename)){
						$num =0;
						$sql ='';
						$clean_query = str_replace('## TABLE STRUCTURE FOR: branch#','',$lines);
						$clean_query = str_replace('## TABLE STRUCTURE FOR: ci_sessions#','',$clean_query);
						$clean_query = str_replace('## TABLE STRUCTURE FOR: login_attempts#','',$clean_query);
						$clean_query = str_replace('## TABLE STRUCTURE FOR: manufacturer#','',$clean_query);
						$clean_query = str_replace('## TABLE STRUCTURE FOR: moved_history#','',$clean_query);
						$clean_query = str_replace('## TABLE STRUCTURE FOR: others#','',$clean_query);
						$clean_query = str_replace('## TABLE STRUCTURE FOR: product_bar_code#','',$clean_query);
						$clean_query = str_replace('## TABLE STRUCTURE FOR: sales#','',$clean_query);
						$clean_query = str_replace('## TABLE STRUCTURE FOR: stock#','',$clean_query);
						$clean_query = str_replace('## TABLE STRUCTURE FOR: stock_branch#','',$clean_query);
						$clean_query = str_replace('## TABLE STRUCTURE FOR: stock_recieved#','',$clean_query);
						$clean_query = str_replace('## TABLE STRUCTURE FOR: stock_transfer#','',$clean_query);
						$clean_query = str_replace('## TABLE STRUCTURE FOR: supplier#','',$clean_query);
						$clean_query = str_replace('## TABLE STRUCTURE FOR: tbl_customers#','',$clean_query);
						$clean_query = str_replace('## TABLE STRUCTURE FOR: tbl_expenses#','',$clean_query);
						$clean_query = str_replace('## TABLE STRUCTURE FOR: tbl_invoice_history#','',$clean_query);
						$clean_query = str_replace('## TABLE STRUCTURE FOR: tbl_payment#','',$clean_query);
						$clean_query = str_replace('## TABLE STRUCTURE FOR: users#','',$clean_query);
						$clean_query = str_replace('## TABLE STRUCTURE FOR: user_autologin#','',$clean_query);
						$clean_query = str_replace('## TABLE STRUCTURE FOR: user_profiles#','',$clean_query);
						$clean_query =explode(";",$clean_query);
						foreach($clean_query as $_query){
						if(!empty($_query)){
						$this->db->query($_query);
						$num++;
						}
						}
						if($num > 0){
						$this->session->set_flashdata("success","Database Restore was Successful!... enjoy - (".$num.") query was executed successfully!!..");			
						}else{
							$this->session->set_flashdata("error","Unable to restore database, seems you don't have any content in the file or you uploaded an invalid file !!.. Please try again");	
						}
					}else{
						$this->session->set_flashdata("error","Unable to restore database, we can not read the file you upload!!.. Please try again");	
					}
				}else{
						$this->session->set_flashdata("error","The file you uploaded seems not be an sql file... Please try again");	
				}
			}else{
						$this->session->set_flashdata("error","You did not upload anything!!..");	
			}
		}else{
			redirect('dashboard/backup');
		}
	 $data['page'] = 'backup';
	  $this->load->view('page/heading',$data);
	  $this->load->view('page/footer',$data);  

   } 
   public function backupandUpload(){
	$this->load->dbutil();
	$this->load->helper('file');
	$backup=$this->dbutil->backup(array('format'=>'txt','filename'=>'mybackup.sql','add_drop'=> TRUE,'add_insert'=> TRUE,'newline'=> ""));
	write_file('mybackup.sql', $backup);
	$this->session->set_flashdata("success","BackUp successfull!!..");
	$this->load->helper('download');
	force_download('mybackup-'.date('d-m-Y').'.sql', $backup);	
	redirect('dashboard/backup');
   }
  
  public function addCustomer(){
			$this->settings->addCustomer($_POST);
			$id =$this->db->insert_id();
			$customer =$this->settings->getCustomer($id);
			$customer['status'] = true;
			die(json_encode($customer));
  }
  
  public function report_sales_rep(){
	  $data['page'] = 'report_sales_rep';
	  $this->load->view('page/heading',$data);
	  $this->load->view('page/footer',$data); 
   }

   public function order_report_sales_rep(){
	  $data['page'] = 'report_order_rep';
	  $this->load->view('page/heading',$data);
	  $this->load->view('page/footer',$data);
   }

 public function report_by_waiter(){
	  $data['page'] = 'report_waiter';
	  $this->load->view('page/heading',$data);
	  $this->load->view('page/footer',$data); 
   }

   public function order_report_by_waiter(){
	  $data['page'] = 'order_report_waiter';
	  $this->load->view('page/heading',$data);
	  $this->load->view('page/footer',$data);
   }

  public function stock_expiry()
	{
			$data = array();
			$data['page'] = 'stock_expiry';
			$this->load->model("stock");
			$data['stocks'] = $this->stock->getStocks();
			$this->load->view('page/heading',$data);
			$this->load->view('page/footer',$data);
		
	} 


public function list_waiter(){
		$data = array();
		$data['page'] = 'list_waiter';
		$this->load->model("stock");
		$data['stocks'] = $this->stock->getStocks();
		$this->load->view('page/heading',$data);
		$this->load->view('page/footer',$data);	
}


public function new_waiter(){
		if(count($_POST) > 0){
			$this->db->insert("waiter_name",$_POST);
			redirect('dashboard/list_waiter');
		}
		$data = array();
		$data['page'] = 'add_waiter';
		$this->load->model("stock");
		$data['stocks'] = $this->stock->getStocks();
		$this->load->view('page/heading',$data);
		$this->load->view('page/footer',$data);		
}


public function delete_waiter($sn){
$this->db->where("SN",$sn)->delete("waiter_name");
redirect('dashboard/list_waiter');	
}
	
}	
/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
