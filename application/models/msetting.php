<?



class Msetting extends CI_Model {

	function __construct() {
		
		parent::__construct();
	}

	function ambilData($table,$condition="",$order=""){
		if(!empty($condition)){
			$this->db->where($condition,null,false);
		}
		if(!empty($order)){
			$this->db->order_by($order);
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
		$this->db->insert($table, $data);
		return $this->db->insert_id();
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

	function isItemTest($kode_pelayanan,$kode_item)
	{
		$this->db->where('kode_pelayanan',$kode_pelayanan);
		$this->db->where('kode_item',$kode_item);
		$query=$this->db->get('lab_item_test');
		$ada= $query->num_rows();
		if($ada)return true;
		return false;
	}
	
	function isItemMapping($kd_unit_kerja,$kode_pelayanan)
	{
		$this->db->where('kd_unit_kerja',$kd_unit_kerja);
		$this->db->where('kd_pelayanan',$kd_pelayanan);
		$query=$this->db->get('tarif_mapping');
		$ada= $query->num_rows();
		if($ada)return true;
		return false;
	}
	
	function getAllPasien($ktp_pasien,$nama_pasien,$order,$limit,$offset){
		//if(!empty($nama)) $this->db->like('nama_pasien',$nama);
		if(!empty($ktp_pasien))$this->db->like('ktp_pasien',$ktp_pasien,'both');
		if(!empty($nama_pasien))$this->db->like('nama_pasien',$nama_pasien,'both');
		if($order==1)$this->db->order_by('ktp_pasien','asc');
		if($order==2)$this->db->order_by('nama_pasien','asc');
		$this->db->limit($limit,$offset);
		$query=$this->db->get("lab_master_pasien");
		return $query->result_array();
	}

	function getLayananByUnit($unit){
		$this->db->join('tarif b','a.kd_pelayanan=b.kd_pelayanan');
		//$this->db->where('b.kd_unit_kerja',$unit);
		$this->db->where('a.kd_pelayanan not in(select kd_pelayanan from accounts_pelayanan_unit where kd_unit_kerja="'.$unit.'")',null,false);
		$this->db->group_by('a.kd_pelayanan');

		$query=$this->db->get("list_pelayanan a");
		return $query->result_array();
	}

	function getLayananByUnitAccount($unit,$account){
		$this->db->join('accounts_pelayanan_unit b','a.kd_pelayanan=b.kd_pelayanan');
		$this->db->where('b.kd_unit_kerja',$unit);
		$this->db->where('b.account',$account);

		$query=$this->db->get("list_pelayanan a");
		return $query->result_array();
	}

	function getAllItemPelayanan($jenispelayanan,$itempelayanan,$limit,$offset){
		//if(!empty($nama)) $this->db->like('nama_pasien',$nama);
		$this->db->limit($limit,$offset);
		if(!empty($jenispelayanan)){
			$this->db->where('a.kode_jenis_pelayanan',$jenispelayanan);			
		}
		if(!empty($itempelayanan))$this->db->like('a.nama_item_pelayanan',$itempelayanan,'both');
		$this->db->join('lab_jenis_pelayanan b','a.kode_jenis_pelayanan=b.kode_jenis_pelayanan');
		$query=$this->db->get("lab_item_pelayanan a");
		return $query->result_array();
	}

	function getAllPelayananUnit($kd_unit_kerja){
		$this->db->where('a.kd_unit_kerja',$kd_unit_kerja);			
		$this->db->join('list_pelayanan b','a.kd_pelayanan=b.kd_pelayanan');
		$query=$this->db->get("tarif_mapping a");
		return $query->result_array();
	}

	function getAllDiagnosaUnit($kd_unit_kerja){
		$this->db->where('a.kd_unit_kerja',$kd_unit_kerja);			
		$this->db->join('sub_diagnosa_icd b','a.kd_icd=b.kd_sub_icd');
		$query=$this->db->get("diagnosa_mapping a");
		return $query->result_array();
	}

	function countAllPasien($ktp_pasien,$nama_pasien){
		//if(!empty($nama)) $this->db->like('nama_pasien',$nama);
		if(!empty($ktp_pasien))$this->db->like('ktp_pasien',$ktp_pasien,'both');
		if(!empty($nama_pasien))$this->db->like('nama_pasien',$nama_pasien,'both');
		$query=$this->db->get("lab_master_pasien");
		return $query->num_rows();
	}

	function countAllItemPelayanan($jenispelayanan,$itempelayanan){
		//if(!empty($nama)) $this->db->like('nama_pasien',$nama);
		if(!empty($jenispelayanan)){
			$this->db->where('a.kode_jenis_pelayanan',$jenispelayanan);			
		}
		if(!empty($itempelayanan))$this->db->like('a.nama_item_pelayanan',$itempelayanan,'both');
		$this->db->join('lab_jenis_pelayanan b','a.kode_jenis_pelayanan=b.kode_jenis_pelayanan');
		$query=$this->db->get("lab_item_pelayanan a");
		return $query->num_rows();
	}
	
}
	
?>
