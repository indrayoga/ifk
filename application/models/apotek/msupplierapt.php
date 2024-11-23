<?



class Msupplierapt extends CI_Model {

	function __construct() {
		
		parent::__construct();
	}
	
	function ambilDataSupplier($nama,$is_aktif){
		if(!empty($nama))$this->db->like('nama',$nama);
		if(!empty($is_aktif)){
			if($is_aktif=='ga'){
				$this->db->where('is_aktif',0);
			}if($is_aktif=='ya') {
				$this->db->where('is_aktif',1);
			}
		}
		$this->db->order_by('kd_supplier','asc');
			
		$query=$this->db->get('apt_supplier');
		return $query->result_array(); 			
	}
	
	function autoNumber(){
		$this->db->select('max(right(kd_supplier,4)) as a',FALSE);
		$query = $this->db->get('apt_supplier'); 
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
		$this->db->where('kd_supplier',$number);
		$query=$this->db->get('apt_supplier');
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