<?



class Mprofil extends CI_Model {

	function __construct() {
		
		parent::__construct();
	}
	
	function ambilDataProfil($nama_profil){
		/*$this->db->select("apt_penjualan.no_penjualan,date_format(apt_penjualan.tgl_penjualan,'%Y-%m-%d') as tgl_penjualan,apt_customers.customer,
							apt_unit.nama_unit_apt,apt_penjualan.tutup,apt_penjualan.nama_pasien",FALSE);*/
		if(!empty($nama_profil)) $this->db->like('nama_profil',$nama_profil);
		
		$this->db->order_by('kd_profil');
		$query=$this->db->get('profil');
		return $query->result_array(); 			
	}
	
	function autoNumber(){
		$this->db->select('max(right(kd_profil,5)) as a',FALSE);
		$query = $this->db->get('profil');
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
	
	function ambilProfil($kd_profil){ 
		$query=$this->db->query("select * from profil where profil.kd_profil='$kd_profil'");
		return $query->row_array(); 			
	}
	
	function getKecamatan($kd_kelurahan){
		$query=$this->db->query("select kelurahan.kd_kecamatan,kecamatan.kecamatan from kecamatan,kelurahan where kelurahan.kd_kecamatan=kecamatan.kd_kecamatan
								and kelurahan.kd_kelurahan='$kd_kelurahan'");
		return $query->row_array(); 			
	}
	
}
	
?>