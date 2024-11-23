<?



include_once(APPPATH.'models/master/mmaster.php');
class Mdokter extends mmaster {

	function __construct() {
		
		parent::__construct();
	}
	
	function ambilDataDokter($nama_dokter){
		if(!empty($nama_dokter)) $this->db->like('nama_dokter',$nama_dokter);
		
		$this->db->order_by('kd_dokter');
		$query=$this->db->get('apt_dokter');
		return $query->result_array(); 			
	}
	
	function autoNumber(){
		$this->db->select('max(right(kd_obat,8)) as a',FALSE);
		$query = $this->db->get('apt_obat');
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
		$this->db->where('kd_dokter',$number);
		$query=$this->db->get('apt_dokter');
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
	
	function isPosted($kd_dokter)
	{
		$this->db->where('kd_dokter',$kd_dokter);
		$query=$this->db->get('apt_dokter');
		$item=$query->num_rows();
		if($item)return true;
		return false;
	}
	
}
	
?>