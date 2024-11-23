<?


include_once(APPPATH.'models/master/mpegawai.php');
class Muser extends mpegawai {

	function __construct() {
		
		parent::__construct();
	}

	function isUserPasswordMatch($user,$password){
		$this->db->where('username',$user);
		$this->db->where('password',md5($password));
		$query=$this->db->get('user a');
		$item=$query->num_rows();
		if($item)return true;
		return false;
	}

	function daftarUser(){
		$this->db->select('*');
		$this->db->join('pegawai b','a.id_pegawai=b.id_pegawai');
		$this->db->join('jenis_pegawai c','b.jenis_pegawai=c.id_jenis_pegawai');
		$query = $this->db->get('user a');
		return $query->result_array();
	}

	function isHaveAccess($user,$akses){
		$this->db->where('id_user',$user);
		$this->db->where('id_akses',$akses);
		$query=$this->db->get('user_akses a');
		$item=$query->num_rows();
		if($item)return true;
		return false;
	}

	function isHaveAccessUnit($user,$akses,$unit){
		$this->db->where('id_user',$user);
		$this->db->where('id_akses',$akses);
		$this->db->where('kd_unit_kerja',$unit);
		$query=$this->db->get('akses_unit a');
		$item=$query->num_rows();
		if($item)return true;
		return false;
	}

	function isHaveUnit($user,$unit){
		$this->db->where('id_user',$user);
		$this->db->where('kd_unit_kerja',$unit);
		$query=$this->db->get('akses_unit a');
		$item=$query->num_rows();
		if($item)return true;
		return false;
	}

	function isHaveApp($user,$aplikasi){
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
	
	function isAkses($aksesApp,$unit=""){
		//$akses=$this->session->userdata('akses');
		$id_user=$this->session->userdata('id_user');
		$this->db->where('id_user',$id_user);
		$this->db->where('id_akses',$aksesApp);
		$query=$this->db->get('user_akses a');
		$item=$query->num_rows();
		//debugvar($item);
		if(empty($unit)){
			if($item){
				if($this->isHaveAccess($id_user,$aksesApp))return true;
				return false;
			}			
		}else{
				if($this->isHaveAccessUnit($id_user,$aksesApp,$unit))return true;
				return false;			
		}
		return false;
	}
	
	function isParent($a){
		$query=$this->db->query('select * from unit_kerja where parent="'.$a.'" ');
		$item= $query->num_rows(); 
		if($item)return true;
		return false;
	}


}
	
?>