<?



class Mcustomerapt extends CI_Model {

	function __construct() {
		
		parent::__construct();
	}
		
	function ambilDataCustomer($customer){
		$this->db->select('cust_code, customer');
		if(!empty($customer)) $this->db->like('customer',$customer);
		$this->db->order_by('cust_code','asc');
		
		$query=$this->db->get('apt_customers');
		return $query->result_array(); 			
	}
	
	function autoNumber(){
		$this->db->select('max(right(cust_code,7)) as a',FALSE);
		$query = $this->db->get('apt_customers'); 
		$kode=$query->row_array();
		return $kode['a'];
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

	function isNumberExist($number){
		$this->db->where('cust_code',$number);
		$query=$this->db->get('apt_customers');
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
	
	function isExist($tabel,$where,$id)
	{
		$this->db->where($where,$id);
		$query=$this->db->get($tabel);
		$item=$query->num_rows();
		if($item)return true;
		return false;
	}
	
}
	
?>