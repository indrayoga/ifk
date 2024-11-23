<?



class Mmonitoring extends CI_Model {

	function __construct() {
		
		parent::__construct();
	}

	function getData($nama_obat,$kd_obat){
		if(!empty($kd_obat)){
			$query=$this->db->query("select apt_stok_unit.kd_obat,apt_obat.nama_obat,apt_satuan_kecil.satuan_kecil,apt_unit.nama_unit_apt,sum(apt_stok_unit.jml_stok) as jml_stok
									from apt_stok_unit,apt_obat,apt_satuan_kecil,apt_unit where apt_stok_unit.kd_obat=apt_obat.kd_obat and
									apt_stok_unit.kd_unit_apt=apt_unit.kd_unit_apt and apt_obat.kd_satuan_kecil=apt_satuan_kecil.kd_satuan_kecil and 
									apt_obat.kd_obat='$kd_obat' group by apt_stok_unit.kd_obat,apt_stok_unit.kd_unit_apt");
		}else{
			$query=$this->db->query("select apt_stok_unit.kd_obat,apt_obat.nama_obat,apt_satuan_kecil.satuan_kecil,apt_unit.nama_unit_apt,sum(apt_stok_unit.jml_stok) as jml_stok
									from apt_stok_unit,apt_obat,apt_satuan_kecil,apt_unit where apt_stok_unit.kd_obat=apt_obat.kd_obat and
									apt_stok_unit.kd_unit_apt=apt_unit.kd_unit_apt and apt_obat.kd_satuan_kecil=apt_satuan_kecil.kd_satuan_kecil and 
									apt_obat.nama_obat='$nama_obat' group by apt_stok_unit.kd_obat,apt_stok_unit.kd_unit_apt");			
		}
		return $query->result_array();
	}
	
	function ambilObat($nama_obat){
		//$kd_unit_apt=$this->session->userdata('kd_unit_apt');
		$query=$this->db->query("select distinct apt_stok_unit.kd_obat,replace(apt_obat.nama_obat,\"'\",'') as nama_obat,apt_satuan_kecil.satuan_kecil from apt_stok_unit,apt_obat,apt_satuan_kecil
								where apt_stok_unit.kd_obat=apt_obat.kd_obat and apt_obat.kd_satuan_kecil=apt_satuan_kecil.kd_satuan_kecil  and apt_obat.nama_obat like '%$nama_obat%'");
		return $query->result_array(); 
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
}
	
?>