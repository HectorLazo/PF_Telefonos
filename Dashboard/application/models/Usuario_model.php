<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Usuario_model extends CI_Model 
{


	var $table_tab_device = 'USU_ADMIN_DEVICE';
	var $column_order_tab_device = array('USUNOMBRE','ROLNOMBRE','FECHA_INGRESO','CREADO','ACTUALIZADO','LAST_UPDATE'); //set column field database for datatable orderable
	var $column_search_tab_device = array('ROLNOMBRE'); //set column field database for datatable searchable just firstname , lastname , address are searchable
	var $order_tab_device = array('ROLNOMBRE' => 'asc'); // default order 

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	//estado = 0 activo

	//retorno el usuario si es que existe en la base de datos
	public function inicio($nombre ,$password)
	{
		$this->db->select('USUID, USUNOMBRE, ESTADO, ROLID, ROLNOMBRE');
		$this->db->from('USU_ADMIN_DEVICE');
		$this->db->where('USUNOMBRE', $nombre);
		$this->db->where('USUPASSWORD', $password);
		$this->db->where('ESTADO', 0);
		$consulta = $this->db->get();
		$usuario = $consulta->row();
		return $usuario;
	}

	public function update_usuario($where, $data)
	{
		$this->db->update($this->table_tab_device, $data, $where);
		return $this->db->affected_rows();
	}

	public function save_tab_admin_pos($data)
	{
		$this->db->insert('USU_ADMIN_DEVICE', $data);
		return $data;
		//return $this->db->insert_id();
	}

	public function listado()
	{
		$query = $this->db->query('SELECT C.USUID, C.USUNOMBRE, C.ROLNOMBRE, 
			C.FECHA_INGRESO, D.USUNOMBRE AS CREADO, E.USUNOMBRE AS ACTUALIZADO, C.LAST_UPDATE
			FROM USU_ADMIN_DEVICE C
			JOIN USU_ADMIN_DEVICE D
			ON C.CREATE_BY=D.USUID
			JOIN USU_ADMIN_DEVICE E
			ON C.UPDATE_BY=E.USUID');
		return $query->result();
	}

	public function count_all()
	{
		$this->db->from($this->table_tab_device);
		return $this->db->count_all_results();
	}

	function count_filtered()
	{
		$this->_get_datatables_query_tab_user();
		$query = $this->db->get();
		return $query->num_rows();
	}

	function _get_datatables_query_tab_user()
	{
		$this->db->from($this->table_tab_device);
		
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
				{
					$this->db->group_end(); //close bracket
				}
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
}