<?



class Mpabrik extends CI_Model {

	function __construct() {
		
		parent::__construct();
	}

	function ambilDataPabrik($nama_pabrik){
		if(!empty($nama_pabrik)) $this->db->like('nama_pabrik',$nama_pabrik);
			$this->db->order_by('kd_pabrik','asc');
			
			$query=$this->db->get('apt_pabrik');
			return $query->result_array(); 			
	}
	
	function autoNumber(){
		$this->db->select('max(right(kd_pabrik,3)) as a',FALSE);
		$query = $this->db->get('apt_pabrik');
		$kode=$query->row_array();
		return $kode['a'];
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
	
    function insert($table,$data) {  
		$this->db->insert($table,$data);
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

	function isNumberExist($number){
		$this->db->where('kd_satuan_kecil',$number);
		$query=$this->db->get('apt_satuan_kecil');
		$count=$query->num_rows();
		if($count){
			return true;
		}
		return false;
	}
	
	function isParent($tabelrelasi,$where,$id)
	{
		$this->db->where($where,$id);
		$query=$this->db->get($tabelrelasi);
		$item=$query->num_rows();
		if($item)return true;
		return false;
	}
	
	function isExist($tabel,$where,$id)
	{
		$this->db->where($where,$id);
		$query=$this->db->get($tabel);
		$item=$query->num_rows();
		if($item)return true;
		return false;
	}
	
}
	
?>