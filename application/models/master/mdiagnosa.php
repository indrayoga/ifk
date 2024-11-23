<?


include_once(APPPATH.'models/master/mmaster.php');
class Mdiagnosa extends mmaster {

	function __construct() {
		
		parent::__construct();
	}

	function getTarifLayanan(){
		$this->db->select('a.kd_jenis_tarif, jenis_tarif, a.kd_pelayanan, nama_pelayanan, a.kd_kelas, kelas, tgl_berlaku, tarif, tgl_berakhir');
		$this->db->join('list_pelayanan b','a.kd_pelayanan = b.kd_pelayanan');
		$this->db->join('kelas_pelayanan c','a.kd_kelas = c.kd_kelas');
		$this->db->join('jenis_tarif d','a.kd_jenis_tarif = d.kd_jenis_tarif');
		$query=$this->db->get("tarif a");
		return $query->result_array();		
	}

	function getPelayananPasien($no_pendaftaran){
		$this->db->select('*,date(tgl_pelayanan) as tanggal, time(tgl_pelayanan) as jam');
		$this->db->where('no_pendaftaran',$no_pendaftaran);

		$this->db->join('list_pelayanan b','a.kd_pelayanan=b.kd_pelayanan');
		$this->db->join('apt_dokter c','a.kd_dokter=c.kd_dokter');
		//$this->db->limit($limit,$offset);
		
		$query=$this->db->get("biaya_pelayanan a");
		return $query->result_array();
	}

	function getDiagnosaPasien($no_pendaftaran){
		//if(!empty($nama)) $this->db->like('nama_pasien',$nama);
		$this->db->select('a.no_pendaftaran,a.urut,tgl_diagnosa,a.kd_jenis_diagnosa,a.kd_dokter,a.kd_sub_icd,a.kd_unit_kerja,b.jenis_diagnosa,c.nama_dokter,d.sub_diagnosa_icd,e.nama_unit_kerja');
		$this->db->where('no_pendaftaran',$no_pendaftaran);

		$this->db->join('jenis_diagnosa b','a.kd_jenis_diagnosa=b.kd_jenis_diagnosa');
		$this->db->join('apt_dokter c','a.kd_dokter=c.kd_dokter');
		$this->db->join('sub_diagnosa_icd d','a.kd_sub_icd=d.kd_sub_icd');
		$this->db->join('unit_kerja e','a.kd_unit_kerja=e.kd_unit_kerja');
		//$this->db->limit($limit,$offset);
		
		$query=$this->db->get("periksa_diagnosa a");
		return $query->result_array();
	}


}
	
?>