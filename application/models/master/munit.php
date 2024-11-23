<?


include_once(APPPATH.'models/master/mmaster.php');
class Munit extends mmaster {

	public $unit;
	public $kd_unit;
	public $parent_unit;
	public $unit_apt;

	function __construct() {
		parent::__construct();
	}

	function setUnit($kd_unit){
		$this->db->where('kd_unit_kerja',$kd_unit);
		$query=$this->db->get('unit_kerja');
		$item=$query->row_array();
		if(!empty($item)){
			$this->unit=$item['nama_unit_kerja'];
			$this->kd_unit=$item['kd_unit_kerja'];
			$this->parent_unit=$item['parent'];
			$this->unit_apt=$item['kd_unit_apt'];			
		}
	}

	function getUnit(){
		return $this->unit;
	}

	function getKdUnit(){
		return $this->kd_unit;
	}

	function getParentUnit(){
		return $this->parent_unit;
	}

	function getUnitApt(){
		return $this->unit_apt;
	}

	function getDokterUnit(){
		$this->db->where('a.kd_unit',$this->kd_unit);
		$this->db->join('apt_dokter b','a.kd_dokter=b.kd_dokter');
		$query=$this->db->get('dokter_unit_kerja a');
		return $query->result_array();
	}

	function getlistUnit($parent=""){
		if(!empty($parent))$this->db->where('a.parent',$parent);
		$query=$this->db->get('unit_kerja a');
		return $query->result_array();
	}
}
	
?>