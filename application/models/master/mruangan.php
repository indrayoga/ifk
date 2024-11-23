<?


include_once(APPPATH.'models/master/mmaster.php');
class Mruangan extends mmaster {

	function __construct() {
		
		parent::__construct();
	}

	function historyruanganpasien($no_pendaftaran=""){
		$this->db->select('a.no_pendaftaran,e.kd_pasien,e.nama_pasien,e.alamat,f.nama_unit_kerja,g.namapj,g.teleponpj,b.kd_kelas,b.no_kamar,b.no_bed,b.tgl_masuk,b.tgl_keluar,c.DeskKamar,d.status_bed');
		$this->db->join('masuk_ruangan b','a.no_pendaftaran=b.no_pendaftaran');
		$this->db->join('no_kamar c','b.no_kamar=c.no_kamar');
		$this->db->join('status_bed d','b.no_bed=d.no_bed and b.no_kamar=d.no_kamar');
		$this->db->join('pasien e','a.kd_pasien=e.kd_pasien');
		$this->db->join('unit_kerja f','b.kd_unit_kerja=f.kd_unit_kerja');
		$this->db->join('penanggung_jawab g','a.no_pendaftaran=g.no_pendaftaran');
		$this->db->where('a.no_pendaftaran',$no_pendaftaran);
		$this->db->order_by('urut desc');
		$query = $this->db->get('pendaftaran a');
		return $query->result_array();
	}
}
	
?>