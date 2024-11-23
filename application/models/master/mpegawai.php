<?


include_once(APPPATH.'models/master/mmaster.php');
class Mpegawai extends mmaster {

	function __construct() {
		
		parent::__construct();
	}

	function daftarPegawai(){
		$this->db->select('a.*,b.jenis_pegawai');
		$this->db->join('jenis_pegawai b','a.jenis_pegawai=b.id_jenis_pegawai');
		$query = $this->db->get('pegawai a');
		return $query->result_array();
	}

}
	
?>