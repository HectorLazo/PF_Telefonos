<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Person_model extends CI_Model {

	// add new pos
	var $table_tab_device = 'TAB_DEVICE';
	var $column_order_tab_device = array('POS_IMEI','POS_DEVICE','POS_ESTADO'); //set column field database for datatable orderable
	var $column_search_tab_device = array('POS_IMEI','POS_DEVICE','POS_ESTADO'); //set column field database for datatable searchable just firstname , lastname , address are searchable
	var $order_tab_device = array('POS_ESTADO' => 'asc'); // default order 

	var $table_tab_admin_pos = 'TAB_ADMIN_POS';
	var $column_order_tab_admin_pos = array('POS_IMEI','POS_DEVICE','POS_NOMBRE','POS_CELULAR','POS_EMAIL','POS_OFFICE_ID','POS_NAME_OFFICE','ESTADO'); //set column field database for datatable orderable
	var $column_search_tab_admin_pos = array('POS_IMEI','POS_VDDR_ID','POS_DEVICE','POS_NOMBRE','POS_CELULAR','POS_EMAIL','POS_OFFICE_ID','POS_NAME_OFFICE','ESTADO'); //set column field database for datatable searchable just firstname , lastname , address are searchable
	var $order = array('ESTADO' => 'asc'); // default order 


	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}


	private function _get_datatables_query_tab_device($id)
	{
		
		if($id==1){
			$this->db->from($this->table_tab_device);
			$this->db->where('POS_ESTADO','0');
		}else{
			$this->db->from($this->table_tab_device);
			$this->db->where('POS_ESTADO','1');
		}


		$i = 0;
	
		foreach ($this->column_search_tab_device as $item) // loop column 
		{
			if($_POST['search']['value']) // if datatable send POST for search
			{
				
				if($i===0) // first loop
				{
					$this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
					$this->db->like($item, $_POST['search']['value']);
				}
				else
				{
					$this->db->or_like($item, $_POST['search']['value']);
				}

				if(count($this->column_search_tab_device) - 1 == $i) //last loop
					$this->db->group_end(); //close bracket
			}
			$i++;
		}
		
		if(isset($_POST['order'])) // here order processing
		{
			$this->db->order_by($this->column_order_tab_device[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
		} 
		else if(isset($this->order))
		{
			$order = $this->order_tab_device;
			$this->db->order_by(key($order), $order[key($order)]);
		}
	}


	function get_datatables_tab_device($id)
	{
		$this->_get_datatables_query_tab_device($id);
		if($_POST['length'] != -1)
		$this->db->limit($_POST['length'], $_POST['start']);
		$query = $this->db->get();
		return $query->result();
	}

	private function _get_datatables_query_tab_admin_pos($id)
	{
		if(strlen($id) == 3){
			$this->db->from($this->table_tab_admin_pos);
			$this->db->where('POS_VDDR_ID',$id);

		}
		
		elseif($id==0){
			$this->db->from($this->table_tab_admin_pos);
			$this->db->where('ESTADO','0');

		}else{
			$this->db->from($this->table_tab_admin_pos);
		}



		$i = 0;
	
		foreach ($this->column_search_tab_admin_pos as $item) // loop column 
		{
			if($_POST['search']['value']) // if datatable send POST for search
			{
				
				if($i===0) // first loop
				{
					$this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
					$this->db->like($item, $_POST['search']['value']);
				}
				else
				{
					$this->db->or_like($item, $_POST['search']['value']);
				}

				if(count($this->column_search_tab_admin_pos) - 1 == $i) //last loop
					$this->db->group_end(); //close bracket
			}
			$i++;
		}
		
		if(isset($_POST['order'])) // here order processing
		{
			$this->db->order_by($this->column_order_tab_admin_pos[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
		} 
		else if(isset($this->order))
		{
			$order = $this->order;
			$this->db->order_by(key($order), $order[key($order)]);
		}
	}

	function get_datatables_tab_admin_pos($id)
	{
		$this->_get_datatables_query_tab_admin_pos($id);
		if($_POST['length'] != -1)
		$this->db->limit($_POST['length'], $_POST['start']);
		$query = $this->db->get();
		return $query->result();
	}

	public function count_all($id)
	{
		if($id==0){
		$this->db->from($this->table_tab_device);
		return $this->db->count_all_results();			
		}elseif ($id==1) {
			$this->db->from($this->table_tab_admin_pos);
			return $this->db->count_all_results();
		}

	}

	function count_filtered($id)
	{
		if($id==0){
		$this->_get_datatables_query_tab_device(0);
		$query = $this->db->get();
		return $query->num_rows();			
		}elseif ($id==1) {
			$this->_get_datatables_query_tab_admin_pos(0);
			$query = $this->db->get();
		}

	}

	public function save_tab_device($data)
	{
		$this->db->insert($this->table_tab_device, $data);
		return $data;
		//return $this->db->insert_id();
	}

	public function save_tab_admin_pos($data)
	{
		$this->db->insert($this->table_tab_admin_pos, $data);
		return $data;
		//return $this->db->insert_id();
	}

	public function update_tab_device($where, $data)
	{
		$this->db->update($this->table_tab_device, $data, $where);
		return $this->db->affected_rows();
	}

	public function update_tab_admin_pos($where, $data)
	{
		$this->db->update($this->table_tab_admin_pos, $data, $where);
		return $this->db->affected_rows();
	}

	public function get_by_imei_tab_device($id)
	{

		$this->db->from($this->table_tab_device);
		$this->db->where('POS_IMEI',$id);
		$query = $this->db->get();

		return $query->row();
	}

	public function get_by_imei_tab_admin_pos_val($id)
	{
		if(strlen($id) == 3){
			$this->db->from($this->table_tab_admin_pos);
			$this->db->where('POS_VDDR_ID',$id);
			$this->db->where('ESTADO',0);

		}else{

		$this->db->from($this->table_tab_admin_pos);
		$this->db->where('POS_IMEI',$id);
		$this->db->where('ESTADO',0);

		}
		$query = $this->db->get();

		return $query->row();
	}

	public function get_by_imei_tab_admin_pos($id)
	{
		if(strlen($id)==3){
		$this->db->from($this->table_tab_admin_pos);
		$this->db->where('POS_VDDR_ID',$id);
		$this->db->where('ESTADO',0);
		$query = $this->db->get();
		}
		else{
		$this->db->from($this->table_tab_admin_pos);
		$this->db->where('POS_IMEI',$id);
		$query = $this->db->get();
		}
		return $query->row();
	}

	public function get_by_tab_pos($id)
	{
		$this->db->select('*');
		$this->db->from(' TAB_OFFICE p');
		$this->db->join(' TAB_POS v','p.OFF_ID=v.POS_OFFICE_ID');
		$this->db->where('POS_VDDR_ID',$id);
		$query = $this->db->get();

		return $query->row();
	}

}
