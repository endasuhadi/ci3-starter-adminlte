<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_roles extends CI_Controller {
	
	public function index(){
		$data['title'] = "User group";
		$this->template->load("tmp/template","user_roles",$data);
	}

    public function get_roles(){
        if(!$this->input->post("id_roles")){
            exit;
        }
        $this->db->where("id_roles",$this->input->post("id_roles"));
        $row = $this->db->get("tbl_user_roles")->row();
        echo json_encode(array("role"=>$row->roles,"nama_roles"=>$row->nama_roles,"id_roles"=>$row->id_roles));
    }

	public function ajax_list()
	{
		$this->load->model("model_user_roles","model");
		if($this->input->method(TRUE)=='POST'):
		$list = $this->model->get_datatables();
        $data = array();
        $no = $_POST['start'];
        $url = "";
        $now = strtotime(date("Y-m-d"));
        foreach ($list as $data_) {
            	$no++;
                $row = array();
                $row[] = $no;
                $row[] = $data_->nama_roles;
                $row[] = substr($data_->roles,0,20);
                $row[] = $data_->create_date;
                $row[] = "<button id='edit' 
                nama_roles='".$data_->nama_roles."'
                roles='".$data_->roles."'
                id_roles='".$data_->id_roles."' 
                class='btn btn-info waves-effect' type='button'><i class='fa fa-edit'></i> Edit</button> <button id='hapus' 
                id_roles='".$data_->id_roles."'
                nama_roles='".$data_->nama_roles."'
                class='btn btn-danger waves-effect' type='button'><i class='fa fa-trash'></i> Hapus</button>";
                $data[] = $row;
		}

		$output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => $this->model->count_all(),
                        "recordsFiltered" => $this->model->count_filtered(),
                        "data" => $data,
                );
        //output to json format
        echo json_encode($output);
		endif;
	}

	public function hapus(){
		if($this->input->post("id_roles")){
			$this->db->where("id_roles",$this->input->post("id_roles"));
			$this->db->delete("tbl_user_roles");
			echo 1;
		}
	}

    public function simpan()
    {   
        $nama_roles = $this->input->post("nama_roles");
        $is_edit = $this->input->post("id_edit");
        $roles = $this->input->post("roles");
        
        $data = array(
                        "nama_roles"=>$nama_roles,
                        "roles"=>implode(",",$roles),
                        "create_date"=>date("Y-m-d h:i:s")
                    );
        if(empty($is_edit)){
            $save = $this->db->insert("tbl_user_roles",$data);
        }else{
            $this->db->where("id_roles",$this->input->post("id_edit"));
            $save = $this->db->update("tbl_user_roles",$data);
        }
        if($save){
            echo 1;
        }else{
            echo 0;
        }
    }

}
