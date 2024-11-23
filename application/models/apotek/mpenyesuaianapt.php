<?



class Mpenyesuaianapt extends CI_Model {

	function __construct() {
		
		parent::__construct();
	}
	
	
	
	function ambilData4($nama_obat){
		$kd_unit_apt=$this->session->userdata('kd_unit_apt');
		//$query=$this->db->query("select kd_obat,nama_obat from apt_obat where nama_obat like '%$nama_obat%' order by kd_obat");
		$query=$this->db->query("select apt_stok_unit.kd_obat,apt_obat.nama_obat,apt_satuan_kecil.satuan_kecil,date_format(apt_stok_unit.tgl_expire,'%d-%m-%Y') as tgl_expire from apt_stok_unit,
								apt_satuan_kecil,apt_obat,apt_unit where apt_stok_unit.kd_obat=apt_obat.kd_obat and apt_stok_unit.kd_unit_apt=apt_unit.kd_unit_apt and 
								apt_obat.kd_satuan_kecil=apt_satuan_kecil.kd_satuan_kecil and apt_stok_unit.kd_unit_apt='$kd_unit_apt' and 
								apt_obat.nama_obat like '%$nama_obat%'");
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
	
	function getStokopname($kd_obat,$periodeawal,$periodeakhir,$kd_unit_apt){
		$kd_unit_apt=$this->session->userdata('kd_unit_apt');
		$this->db->select('apt_stok_unit.kd_obat,apt_obat.nama_obat,apt_satuan_kecil.satuan_kecil,apt_stok_unit.tgl_expire,apt_stok_unit.jml_stok,
							apt_stok_unit.kd_unit_apt,apt_unit.nama_unit_apt',FALSE);
		if(!empty($kd_obat))$this->db->like('apt_obat.kd_obat',$kd_obat,'both');
		if(!empty($periodeawal))$this->db->where('date(apt_stok_unit.tgl_expire)>=',convertDate($periodeawal));
		if(!empty($periodeakhir))$this->db->where('date(apt_stok_unit.tgl_expire)<=',convertDate($periodeakhir));
		if(!empty($kd_unit_apt))$this->db->where('apt_unit.kd_unit_apt',$kd_unit_apt);
		
		$this->db->join('apt_obat','apt_obat.kd_obat=apt_stok_unit.kd_obat','left');
		$this->db->join('apt_unit','apt_unit.kd_unit_apt=apt_stok_unit.kd_unit_apt','left');
		$this->db->join('apt_satuan_kecil','apt_satuan_kecil.kd_satuan_kecil=apt_obat.kd_satuan_kecil','left');
		$this->db->order_by('apt_stok_unit.kd_obat');
		
		$query=$this->db->get("apt_stok_unit");		
		return $query->result_array();
	}
	
	function autoNumber($tahun,$bulan){ 		//2013080001
		$this->db->select('max(right(nomor,4)) as a',false);
		$this->db->where('year(tanggal)',$tahun);
		$this->db->where('month(tanggal)',$bulan);
		$query=$this->db->get("history_perubahan_stok");
		$item= $query->row_array();
		return $item['a'];
	}
	
	function nomor(){
		$query=$this->db->query("select max(nomor) as kode from history_perubahan_stok");
		$kode=$query->row_array();
		if(empty($kode)) return 0;
		return $kode['kode'];
	}
	
	function tanggal(){
		$query=$this->db->query("select DATE_FORMAT(sysdate(),'%Y-%m-%d') as tgl");
		$tgl=$query->row_array();
		return $tgl['tgl'];
	}
	
	function ambilData2($kd_obat,$tgl_expire,$kd_unit_apt){ 
		$query=$this->db->query("select apt_stok_unit.kd_obat,apt_obat.nama_obat,apt_stok_unit.jml_stok,date_format(apt_stok_unit.tgl_expire,'%d-%m-%Y') as tgl_expire,apt_stok_unit.kd_unit_apt from apt_obat,apt_stok_unit,
								apt_unit where apt_obat.kd_obat=apt_stok_unit.kd_obat and apt_stok_unit.kd_unit_apt=apt_unit.kd_unit_apt and 
								apt_stok_unit.kd_obat='$kd_obat' and apt_stok_unit.tgl_expire='$tgl_expire' and apt_stok_unit.kd_unit_apt='$kd_unit_apt'");
		return $query->row_array(); 			
	}
	
	function get_all()
    {                   
        $query = $this->db->get('user_account');
        return $query;
    }
}
	
?>