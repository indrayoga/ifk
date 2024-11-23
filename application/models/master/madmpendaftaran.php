<?



class Madmpendaftaran extends CI_Model {

	function __construct() {
		
		parent::__construct();
	}
	
	function ambilPelayanan($nama_pelayanan){
		if($nama_pelayanan!=''){$a1=" and list_pelayanan.nama_pelayanan like '%$nama_pelayanan%'";}
		else{$a1="";} $a=$a1;
		$query=$this->db->query("select distinct list_pelayanan_obat.kd_pelayanan,list_pelayanan.nama_pelayanan from list_pelayanan,list_pelayanan_obat where
								list_pelayanan_obat.kd_pelayanan=list_pelayanan.kd_pelayanan $a ");
		return $query->result_array(); 			
	}

	/*function ambilData($table,$condition=""){
		if(!empty($condition)){
			$this->db->where($condition,null,false);
		}
		$query= $this->db->get($table);
		return $query->result_array();
	}*/
	
	function ambilData(){
		$query=$this->db->query("select * from list_pelayanan order by nama_pelayanan");
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
		$this->db->where('kd_pelayanan',$number);
		$query=$this->db->get('list_pelayanan_obat');
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
	
	/*function ambilData1(){
		$query=$this->db->query("select kd_pelayanan,nama_pelayanan from list_pelayanan where kd_jenis_pelayanan='014'");
		return $query->result_array();
		//return $tanggal['tanggal'];
	}*/
	
	function ambilData2($nama_obat){
		$query=$this->db->query("select apt_obat.kd_obat,apt_obat.nama_obat,apt_satuan_kecil.satuan_kecil from apt_obat,apt_satuan_kecil where 
								apt_obat.kd_satuan_kecil=apt_satuan_kecil.kd_satuan_kecil and apt_obat.nama_obat like '%$nama_obat%'");
		return $query->result_array();
		//return $tanggal['tanggal'];
	}
	
	function ambilData3($kd_obat){
		$query=$this->db->query("select apt_obat.kd_obat,apt_obat.nama_obat,apt_satuan_kecil.satuan_kecil from apt_obat,apt_satuan_kecil where 
								apt_obat.kd_satuan_kecil=apt_satuan_kecil.kd_satuan_kecil and apt_obat.kd_obat like '%$kd_obat%'");
		return $query->result_array();
		//return $tanggal['tanggal'];
	}
	
	function isExist($tabel,$where,$id)
	{
		$this->db->where($where,$id);
		$query=$this->db->get($tabel);
		$item=$query->num_rows();
		if($item)return true;
		return false;
	}
	
	function ambilNama($value){
		$query=$this->db->query("select nama_obat from apt_obat where kd_obat='$value'");
		$nama=$query->row_array();
		return $nama['nama_obat'];
	}
	
	function getAllDetailPelayanan($kd_pelayanan){ 
		$query=$this->db->query("select list_pelayanan_obat.kd_pelayanan,list_pelayanan_obat.kd_obat,apt_obat.nama_obat,list_pelayanan_obat.qty,apt_satuan_kecil.satuan_kecil 
								from list_pelayanan,list_pelayanan_obat,apt_obat,apt_satuan_kecil where list_pelayanan.kd_pelayanan=list_pelayanan_obat.kd_pelayanan 
								and apt_obat.kd_satuan_kecil=apt_satuan_kecil.kd_satuan_kecil and list_pelayanan_obat.kd_obat=apt_obat.kd_obat and list_pelayanan_obat.kd_pelayanan='$kd_pelayanan'");
		return $query->result_array(); 		
	}
	
	function ambilItemDataPelayanan($kd_pelayanan){
		$query=$this->db->query("select distinct kd_pelayanan from list_pelayanan_obat where kd_pelayanan='$kd_pelayanan'");
		return $query->row_array();
	}
	
	function getBMHP($kode1){
		$query=$this->db->query("select list_pelayanan_obat.kd_obat,apt_obat.nama_obat,apt_satuan_kecil.satuan_kecil,list_pelayanan_obat.qty
								from list_pelayanan_obat,list_pelayanan,apt_obat,apt_satuan_kecil where list_pelayanan_obat.kd_pelayanan=list_pelayanan.kd_pelayanan
								and list_pelayanan_obat.kd_obat=apt_obat.kd_obat and apt_obat.kd_satuan_kecil=apt_satuan_kecil.kd_satuan_kecil and 
								list_pelayanan_obat.kd_pelayanan='$kode1'");
		return $query->result_array();
	}
	
	function getAllPelayananUnit($unit1){
		$query=$this->db->query("select administrasi_pendaftaran.kd_pelayanan,list_pelayanan.nama_pelayanan from administrasi_pendaftaran,list_pelayanan where
								administrasi_pendaftaran.kd_pelayanan=list_pelayanan.kd_pelayanan and administrasi_pendaftaran.unit='$unit1'");
		return $query->result_array();
	}
	
}
	
?>