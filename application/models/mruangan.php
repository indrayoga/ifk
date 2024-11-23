<?



//include_once(APPPATH.'models/mutility.php');
include_once(APPPATH.'models/master/munit.php');

class Mruangan extends Munit {

	function __construct() {
		
		parent::__construct();
		$unit=$this->session->userdata('poli');
		parent::setUnit($unit);
		//debugvar($unit);
	}

    function isKasurEmpty($no_kamar,$no_bed){
    	$this->db->where('no_bed',$no_bed);
    	$this->db->where('no_kamar',$no_kamar);
    	$this->db->where('status_bed','K');
    	$query=$this->db->get('status_bed');
    	$item=$query->num_rows();
    	if($item){
    		return true;
    	}
    	return false;
    }

	function getMaxUrutOperasi($no_pendaftaran){
		$this->db->select('ifnull(max(urut),0) as urut');
		$this->db->where('no_pendaftaran',$no_pendaftaran);
		$query=$this->db->get('rencana_operasi');
		$item = $query->row_array();
		return $item['urut'];
	}    

	function isDiagnosaLama($kd_pasien,$kd_sub_icd)
	{
		$this->db->where('kd_pasien',$kd_pasien);
		$this->db->where('kd_sub_icd',$kd_sub_icd);
		$query=$this->db->get('periksa_diagnosa');
		$item=$query->num_rows();
		if($item)return true;
		return false;
	}

	function isSudahDiagnosa($no_pendaftaran)
	{
		$this->db->where('no_pendaftaran',$no_pendaftaran);
		$query=$this->db->get('periksa_diagnosa');
		$item=$query->num_rows();
		if($item)return true;
		return false;
	}

	function isBayar($no_pendaftaran,$urut)
	{
		$this->db->where('no_pendaftaran',$no_pendaftaran);
		$this->db->where('urut',$urut);
		$query=$this->db->get('struk_pelayanan');
		$item=$query->num_rows();
		if($item)return true;
		return false;
	}
	
	function getAllHistoryDaftar($kd_pasien){

		$this->db->select('a.no_pendaftaran,tgl_pendaftaran,kelas,nama_unit_kerja');
		$this->db->join('kelas_pelayanan b','a.kd_kelas=b.kd_kelas','left');
		$this->db->join('unit_kerja c','a.kd_unit_kerja=c.kd_unit_kerja','left');
		$this->db->where('a.kd_pasien',$kd_pasien);
		//$this->db->limit($limit,$offset);
		$query=$this->db->get("pendaftaran a");
		return $query->result_array();
	}

	function getAllPasien($kd_pasien,$nama_pasien,$periodeawal,$periodeakhir,$jns_kelamin,$limit,$offset){
		//if(!empty($nama)) $this->db->like('nama_pasien',$nama);
		if(!empty($kd_pasien) && $kd_pasien !='NULL')$this->db->like('kd_pasien',$kd_pasien,'both');
		if(!empty($nama_pasien) && $nama_pasien !='NULL')$this->db->like('nama_pasien',$nama_pasien,'both');
		if(!empty($jns_kelamin) && $jns_kelamin !='NULL')$this->db->where('jns_kelamin',$jns_kelamin);
		if(!empty($periodeawal) && $periodeawal !='NULL')$this->db->where('date(tgl_membership)>=',$periodeawal);
		if(!empty($periodeakhir) && $periodeakhir !='NULL')$this->db->where('date(tgl_membership)<=',$periodeakhir);

		$this->db->join('propinsi b','a.kd_propinsi=b.kd_propinsi','left');
		$this->db->join('kabupaten c','a.kd_kabupaten=c.kd_kabupaten','left');
		$this->db->join('kecamatan d','a.kd_kabupaten=d.kd_kecamatan','left');
		$this->db->join('kelurahan e','a.kd_kecamatan=e.kd_kelurahan','left');
		//$this->db->limit($limit,$offset);
		$query=$this->db->get("pasien a");
		return $query->result_array();
	}


	function getItemDaftarPasien($no_pendaftaran,$kd_pasien){
		//if(!empty($nama)) $this->db->like('nama_pasien',$nama);
		$this->db->select('a.*,f.*,b.nama_unit_kerja,c.nama_dokter,d.customer');
		$this->db->where('a.no_pendaftaran',$no_pendaftaran);
		$this->db->where('a.kd_pasien',$kd_pasien);
		$this->db->join('pasien f','a.kd_pasien=f.kd_pasien','left');
		$this->db->join('unit_kerja b','a.kd_unit_kerja=b.kd_unit_kerja','left');
		$this->db->join('apt_dokter c','a.kd_dokter=c.kd_dokter','left');
		$this->db->join('apt_customers d','a.cust_code=d.cust_code','left');

		$query=$this->db->get("pendaftaran a");
		return $query->row_array();
	}

	function getMaxUrutDiagnosa($no_pendaftaran){
		//if(!empty($nama)) $this->db->like('nama_pasien',$nama);
		$this->db->select('max(urut) as urut',false);
		$this->db->where('no_pendaftaran',$no_pendaftaran);
		$query=$this->db->get("periksa_diagnosa a");
		$item= $query->row_array();
		return $item['urut'];
	}


	function isAdaDiagnosa($icd){
		$this->db->where('kd_sub_icd',$icd);
		$query=$this->db->get('sub_diagnosa_icd');
		$count=$query->num_rows();
		if($count){
			return true;
		}
		return false;
	}


	
}
	
?>
