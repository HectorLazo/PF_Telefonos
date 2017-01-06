<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set("Chile/Continental");


class Usuario extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('usuario_model','usuario');
		$this->load->helper('url');
	}

//routes page
	public function index()
	{
		$this->load->view('usuario/inicio_sesion_view');
	}

	public function inicio()
	{
		$pass = $this->input->post('usupassword');
		$pass = SHA1($pass);

		$user = $this->usuario->inicio($this->input->post('usunombre'), $pass);

		if($user==NULL)//si el usuario no existe o autentificó erróneamente se devuelve a la página de login (falta mensaje).
		{
			redirect('/');
		}
		else//si se autentica, se setean los atributos de sesión con el id del usuario y el nombre. Posteriormente se redirige al controlador person.
		{
			$newdata = array(
	        'USUID'  	=> $user->USUID,
	        'USUNOMBRE'	=> $user->USUNOMBRE,
	        );
			$this->session->set_userdata($newdata);
			redirect('person');
		}
	}


	/*public function users()
	{
		$this->load->helper('url');
		$this->load->view('admin_user_view');
	}/*

	/*public function user_history($id)
	{
		$data= $this->person->get_by_imei_tab_admin_pos($id);
		$this->load->helper('url');
		$this->load->view('history_user_view',$data);
	}*/
// end routes page


// load tables
	public function ajax_list_index($id)
	{
		$list = $this->person->get_datatables_tab_device($id);
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $person) {
			$no++;
			$row = array();
			$row[] = $person->POS_IMEI;
			$row[] = $person->POS_DEVICE;
			

			//add html for action
			$row[] = '<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Edit" onclick="edit_device('."'".$person->POS_IMEI."'".')"><i class="glyphicon glyphicon-pencil"></i> Edit</a>
				  <a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Hapus" onclick="delete_device('."'".$person->POS_IMEI."'".')"><i class="glyphicon glyphicon-trash"></i> Delete</a>';
		
			$data[] = $row;
		}

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->person->count_all(0),
						"recordsFiltered" => $this->person->count_filtered(0),
						"data" => $data,
				);
		//output to json format
		echo json_encode($output);
	}


	public function listado2($id)
	{
		$list = $this->usuario->listado();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $usuario) 
		{
			$no++;
			$row = array();

			$row[] = $usuario->USUID;
			$row[] = $usuario->USUNOMBRE;
			$row[] = $usuario->ROLNOMBRE;
			$row[] = $usuario->FECHA_INGRESO;
			$row[] = $usuario->CREADO;
			$row[] = $usuario->ACTUALIZADO;
			$row[] = $usuariO->LAST_UPDATE;
			
			//add html for action
			$row[] = '<a class="btn btn-sm btn-warning" href="javascript:void(0)" title="Eliminar" onclick="delete_user('."'".$person->USUID."'".')"><i class="glyphicon glyphicon-trash"></i> Historial</a>';
			
			$data[] = $row;
		}

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->person->count_all(1),
						"recordsFiltered" => $this->person->count_filtered(1),
						"data" => $data,
				);
		//output to json format
		echo json_encode($output);
	}


//end load tables

	
	public function ajax_add_index()
	{
		$var_fecha= date("d-m-Y H:i:s",time());

		$this->_validate_all(0);
		$data = array(
				'POS_IMEI' => $this->input->post('p_id2'),
				'POS_DEVICE' => $this->input->post('p_modelo'),
				'POS_DESCRIPTION' =>$this->input->post('p_descripcion'),
				'POS_ESTADO' => 0,
				'FECHA_INGRESO'=>$var_fecha,	
			);
		$insert = $this->person->save_tab_device($data);
		echo json_encode(array("status" => TRUE));
	}

	public function ajax_add_users()
	{
		$var_fecha= date("d-m-Y H:i:s",time());
		$this->_validate_all(1);
		$data = array(
				'POS_IMEI' 		=> $this->input->post('p_id2'),
				'POS_VDDR_ID' 	=> $this->input->post('p_cod_vendedor'),
				'POS_NOMBRE'	=> $this->input->post('p_nom_vendedor'),
				'POS_CELULAR'	=> $this->input->post('p_numero'),
				'POS_EMAIL'		=> $this->input->post('p_email'),
				'POS_DEVICE' 	=> $this->input->post('p_modelo'),
				'POS_OFFICE_ID'	=> $this->input->post('p_oficina'),
				'POS_NAME_OFFICE'=> $this->input->post('p_nom_oficina'),
				'ESTADO'		=> 0,
				'FECHA_ENTREGA'	=>$var_fecha,
			);
		$insert = $this->person->save_tab_admin_pos($data);
		echo json_encode(array("status" => TRUE));
	}

	public function ajax_edit_index($id)
    {
        $data = $this->person->get_by_imei_tab_device($id);
        //$data->dob = ($data->dob == '0000-00-00') ? '' : $data->dob; // if 0000-00-00 set tu empty for datepicker compatibility
        echo json_encode($data);
    }

    public function ajax_valida_act_imei($id)
    {
        $data = $this->person->get_by_imei_tab_admin_pos_val($id);
        //$data->dob = ($data->dob == '0000-00-00') ? '' : $data->dob; // if 0000-00-00 set tu empty for datepicker compatibility
        echo json_encode($data);
    }

    public function ajax_valida_act_vend($id)
    {
        $data = $this->person->get_by_imei_tab_admin_pos_val($id);
        //$data->dob = ($data->dob == '0000-00-00') ? '' : $data->dob; // if 0000-00-00 set tu empty for datepicker compatibility
        echo json_encode($data);
    }

    public function ajax_edit_users($id)
    {
        $data = $this->person->get_by_imei_tab_admin_pos($id);
        //$data->dob = ($data->dob == '0000-00-00') ? '' : $data->dob; // if 0000-00-00 set tu empty for datepicker compatibility
        echo json_encode($data);
    }

    public function ajax_update_index()
	{
		$this->_validate_all(0);
		$data = array(
				'POS_DEVICE' => $this->input->post('p_modelo'),
				'POS_DESCRIPTION'=>$this->input->post('p_descripcion'),
			);
		$this->person->update_tab_device(array('POS_IMEI' => $this->input->post('p_id2')), $data);
		echo json_encode(array("status" => TRUE));
	}

	public function ajax_delete_index()
	{
		$var_fecha= date("d-m-Y H:i:s",time());
		$data = array(
				'POS_ESTADO' => 1,
				'FECHA_ELIMINADO' => $var_fecha,
				'POS_MOTIVO_DESC'  => $this->input->post('p_motivo'),
			);
		$this->person->update_tab_device(array('POS_IMEI' => $this->input->post('p_id2')), $data);
		echo json_encode(array("status" => TRUE,"imie"=>$this->input->post('p_id2')));
	}

	public function ajax_delete_user_history()
	{
		$var_fecha= date("d-m-Y H:i:s",time());
		$this->_validate_all(2);
		$data = array(
				'ESTADO' => 1,
				'FECHA_DEVOLUCION' => $var_fecha,
				'POS_MOTIVO_DESC'  => $this->input->post('p_motivo')
			);
		$this->person->update_tab_admin_pos(array('POS_IMEI' => $this->input->post('p_id2') ,'POS_VDDR_ID'=>$this->input->post('p_cod_vendedor2'),'FECHA_DEVOLUCION'=> $this->input->post('null')), $data);
		echo json_encode(array("status" => TRUE,"imie"=>$this->input->post('p_id2')));
	}

	public function ajax_pass_user_history()
	{
		$this->_validate_all(3);
		$data = array(
				'PASS_MAIL' => $this->input->post('p_pass'),
			);
		$this->person->update_tab_admin_pos(array('POS_IMEI' => $this->input->post('p_id2'),'POS_VDDR_ID'=>$this->input->post('p_cod_vend2'),'ESTADO'=>0  ), $data);
		echo json_encode(array("status" => TRUE,"imie"=>$this->input->post('p_id2'),"cod_vendedor"=>$this->input->post('p_cod_vend2')));
	}

	public function ajax_find_tab_pos($id)
    {
        $data = $this->person->get_by_tab_pos($id);
        //$data->dob = ($data->dob == '0000-00-00') ? '' : $data->dob; // if 0000-00-00 set tu empty for datepicker compatibility
        echo json_encode($data);
    }


	private function _validate_all($id)
	{
		$data = array();
		$data['error_string'] = array();
		$data['inputerror'] = array();
		$data['status'] = TRUE;
		$len=$this->input->post('p_id2');
		$n=strlen($len);

		if($this->input->post('p_id2') == '')
		{
			$data['inputerror'][] = 'p_id2';
			$data['error_string'][] = 'New IMEI is required';
			$data['status'] = FALSE;
		}
		if($n!=15)
		{
			$data['inputerror'][] = 'p_id2';
			$data['error_string'][] = 'New IMEI error length ';
			$data['status'] = FALSE;
		}

		if ($id==3) {

		if($this->input->post('p_pass') == '')
		{
			$data['inputerror'][] = 'p_pass';
			$data['error_string'][] = 'Password is required';
			$data['status'] = FALSE;
		}
			# code...
		}

		if ($id==0){

		if($this->input->post('p_modelo') == '')
		{
			$data['inputerror'][] = 'p_modelo';
			$data['error_string'][] = 'Model is required';
			$data['status'] = FALSE;
		}

		}elseif ($id==1) {

		if($this->input->post('p_modelo') == '')
		{
			$data['inputerror'][] = 'p_modelo';
			$data['error_string'][] = 'Model is required';
			$data['status'] = FALSE;
		}

			if($this->input->post('p_numero') == '')
			{
				$data['inputerror'][] = 'p_numero';
				$data['error_string'][] = 'number is required';
				$data['status'] = FALSE;
			}

			if($this->input->post('p_cod_vendedor') == '')
			{
				$data['inputerror'][] = 'p_cod_vendedor';
				$data['error_string'][] = 'seller code is required';
				$data['status'] = FALSE;
			}

			if($this->input->post('p_nom_vendedor') == '')
			{
				$data['inputerror'][] = 'p_nom_vendedor';
				$data['error_string'][] = 'name seller is required';
				$data['status'] = FALSE;
			}

			if($this->input->post('p_email') == '')
			{
				$data['inputerror'][] = 'p_email';
				$data['error_string'][] = 'email is required';
				$data['status'] = FALSE;
			}

			if($this->input->post('p_oficina') == '')
			{
			$data['inputerror'][] = 'p_oficina';
			$data['error_string'][] = 'Oficina is required';
			$data['status'] = FALSE;
			}

			if($this->input->post('p_nom_oficina') == '')
			{
			$data['inputerror'][] = 'p_oficina';
			$data['error_string'][] = 'Oficina is required';
			$data['status'] = FALSE;
			}
			
		}
		if($id==2){

		if($this->input->post('p_motivo') == '')
		{
			$data['inputerror'][] = 'p_motivo';
			$data['error_string'][] = 'Motivo is required';
			$data['status'] = FALSE;
		}
		}
		

		if($data['status'] === FALSE)
		{
			echo json_encode($data);
			exit();
		}
	}

}