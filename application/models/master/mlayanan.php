<?


include_once(APPPATH.'models/master/mmaster.php');
class Mlayanan extends mmaster {

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

	function getPelayananPendaftaranPasien($no_pendaftaran){
		$this->db->select('*,date(tgl_pelayanan) as tanggal, time(tgl_pelayanan) as jam');
		$this->db->where('no_pendaftaran',$no_pendaftaran);

		$this->db->join('administrasi_pendaftaran d','a.kd_pelayanan=d.kd_pelayanan');
		$this->db->join('list_pelayanan b','d.kd_pelayanan=b.kd_pelayanan');
		$this->db->join('apt_dokter c','a.kd_dokter=c.kd_dokter');
		//$this->db->limit($limit,$offset);
		
		$query=$this->db->get("biaya_pelayanan a");
		return $query->result_array();
	}

}
	
?>