<?php



class Muser extends CI_Model {

	function __construct() {
		
		parent::__construct();
	}

	function ambilData($table,$condition=""){
		if(!empty($condition)){
			$this->db->where($condition,null,false);
		}
		$query= $this->db->get($table);
		return $query->result_array();
	}

	function ambilItemData($table,$condition=""){
		if(!empty($condition)){
			$this->db->where($condition,null,false);
		}
		$query= $this->db->get($table);
		return $query->row_array();
	}

    function insertId($table,$data) {
		$this->db->insert($table, $data);
		return $this->db->insert_id();
    }
	function insert($table,$data) {
		$this->db->insert($table, $data);
		return true;
    }	

    function update($table,$data,$id) {
    	if(!empty($id)){
    		$this->db->where($id,null,false);
    	}
		
		$this->db->update($table, $data);
		return true;
    }	

    function delete($table,$id) {
		$this->db->where($id,null,false);
		$this->db->delete($table);
		return true;
    }	
	
	function isUserPasswordMatch($user,$password){
		$this->db->where('username',$user);
		$this->db->where('password',md5($password));
		$query=$this->db->get('user a');
		$item=$query->num_rows();
		if($item)return true;
		return false;
	}

	function isHaveAccess($user,$aplikasi){
		$this->db->where('id_user',$user);
		$this->db->where('kd_aplikasi',$aplikasi);
		$query=$this->db->get('user_aplikasi a');
		$item=$query->num_rows();
		//debugvar($item);
		if($item)return true;
		return false;
	}

	function isLogin(){
		$id_user=$this->session->userdata('id_user');
		if(empty($id_user))return false;
		$this->db->where('id_user',$id_user);
		$query=$this->db->get('user a');
		$item=$query->num_rows();
		if($item)return true;
		return false;
	}
	
	function isAkses($aksesApp){
		//$akses=$this->session->userdata('akses');
		$id_user=$this->session->userdata('id_user');
		//$this->isHaveAccess($id_user,$aksesApp);
		$this->db->where('id_user',$id_user);
		$this->db->where('id_akses',$aksesApp);
		$query=$this->db->get('user_akses a');
		$item=$query->num_rows();
		//debugvar($item);
		if($item)return true;
		return false;
	}
	
	function isParent($a){
		$query=$this->db->query('select * from unit_kerja where parent="'.$a.'" ');
		$item= $query->num_rows(); 
		if($item)return true;
		return false;
	}
	/*public function getItemUser($user,$password){
		$this->db->select('a.id_user,a.user');
		$query=$this->db->get('user a');
	}*/
}
	
?>