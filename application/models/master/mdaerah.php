<?


include_once(APPPATH.'models/master/mmaster.php');
class Mdaerah extends mmaster {

	function __construct() {
		
		parent::__construct();
	}

	function ambilDataPropinsi(){
		$this->db->join('kabupaten b','a.kd_propinsi=b.kd_propinsi');
		$this->db->group_by('a.kd_propinsi');
		$query= $this->db->get('propinsi a');
		return $query->result_array();
	}

}
	
?>