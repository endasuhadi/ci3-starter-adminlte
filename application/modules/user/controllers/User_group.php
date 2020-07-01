<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_group extends CI_Controller {
	
	public function index(){
		$this->template->load("tmp/template","user_group");
	}

	public function ajax_list()
	{
		$this->load->model("model_user_group","model");
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
                $row[] = ucfirst($data_->nama_user);
                $row[] = $data_->username;
                $row[] = $data_->nama_user;
                $row[] = $data_->create_date;
                $row[] = "<button id='edit' 
                nama_user='".$data_->nama_user."' 
                id_user='".$data_->id_user."' 
                email='".$data_->email."' 
                id_group='".$data_->id_group."' 
                username='".$data_->username."' 
                password='".$data_->password."' 
                class='btn btn-info waves-effect' type='button'><i class='fa fa-edit'></i> Edit</button> <button id='hapus' 
                id_user='".$data_->id_user."'
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
		if($this->input->post("id_user")){
			$this->db->where("id_user",$this->input->post("id_user"));
			$this->db->delete("tbl_user_group");
			echo 1;
		}
	}

    public function check_username($username){
        $this->db->where("username",$username);
        $row = $this->db->get("tbl_user_group")->row();
        return $row;
    }

    public function simpan()
    {   
        $nama_user = $this->input->post("nama_user");
        $is_edit = $this->input->post("id_edit");
        $username = $this->input->post("username");
        $email = $this->input->post("email");
        if(empty($is_edit)){
            if($this->check_username($username)){
                echo 2;
                exit;
            }
        }
        $password = $this->input->post("password");
        $id_group = $this->input->post("id_group");
        $data = array(
                        "id_group"=>$id_group,
                        "nama_user"=>$nama_user,
                        "username"=>$username,
                        "email"=>$email,
                        "create_date"=>date("Y-m-d H:i:s")
                    );
        if($password){
            $this->db->set('password', 'PASSWORD("'.$this->input->post('password', TRUE).'")', FALSE);
        }
        if(empty($is_edit)){
            $save = $this->db->insert("tbl_user_group",$data);
        }else{
            $this->db->where("id_user",$this->input->post("id_edit"));
            $save = $this->db->update("tbl_user_group",$data);
        }
        if($save){
            echo 1;
        }else{
            echo 0;
        }
    }

}
