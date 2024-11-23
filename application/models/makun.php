<?



class Makun extends CI_Model {

	function __construct() {
		
		parent::__construct();
	}

	function ambilData($table,$condition=""){
		if(!empty($condition)){
			$this->db->where($condition,null,false);
		}
		$query= $this->db->get($table);
		return $query->result_array();
	}

	function ambilDataTahunACCValue(){
		$query= $this->db->query("select distinct years from acc_value");
		return $query->result_array();
	}

	function ambilItemData($table,$condition=""){
		if(!empty($condition)){
			$this->db->where($condition,null,false);
		}
		$query= $this->db->get($table);
		return $query->row_array();
	}

    function insertId($table,$data) {
		$this->db->insert($table, $data);
		return $this->db->insert_id();
    }
	function insert($table,$data) {
		$this->db->insert($table, $data);
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
	function comboLevel($value=""){
		$htmlcmb='<select id="level" name="level" class="input-small">';
			$htmlcmb.='<option value="">Level</option>';
			$i=1;
			while($i <= 9){
				if(!empty($value)){
					$sql=$this->db->query("SELECT levels FROM accounts WHERE levels=".$value);
					$items=$sql->row_array();
					if($items['levels']==$i){
						$htmlcmb.='<option value="'.$i.'" selected="selected">'.$i.'</option>';
					}else{
						$htmlcmb.='<option value="'.$i.'">'.$i.'</option>';
					}
				}else{
					$htmlcmb.='<option value="'.$i.'">'.$i.'</option>';
				}
				$i++;
			}
		$htmlcmb.='</select>';	
		return $htmlcmb;
	}
	
	function duplicateCek($table,$where){
		$this->db->where($where,null,false);
		$query=$this->db->get($table);
		if($query->num_rows() > 0){
			return true;
		}else{
			return false;
		}
	}
}
	
?>
