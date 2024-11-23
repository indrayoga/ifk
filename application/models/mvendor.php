<?



class Mvendor extends CI_Model {

	function __construct() {
		
		parent::__construct();
	}

	function ambilDataVendor($nama){
		$this->db->select('acc_vendors.vend_code, acc_vendors.vendor ,CONCAT(acc_vendors.address," ",acc_vendors.city,", ",acc_vendors.state) as gabung1, CONCAT(acc_vendors.phone1," / ",acc_vendors.phone2) as telp, acc_vendors.fax,accounts.name',FALSE);
		$this->db->join('accounts','accounts.account=acc_vendors.account');
		if(!empty($nama)) $this->db->like('acc_vendors.vendor',$nama);
			$this->db->order_by('acc_vendors.vend_code','asc');
		$query=$this->db->get('acc_vendors');
		return $query->result_array(); 			
	}
	
	function autoNumber(){
		$this->db->select('max(right(vend_code,6)) as a',FALSE);
		$query = $this->db->get('acc_vendors');
		$kode=$query->row_array();
		return $kode['a'];
	}

	function getVendor($nama,$limit,$offset){
		if(!empty($nama)) $this->db->like('vendor',$nama);
		$this->db->limit($limit,$offset);
		$query=$this->db->get("acc_vendors");
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
	
	function countVendor($vendor){
		//if(!empty($nama)) $this->db->like('nama_pasien',$nama);
		//debugvar($vendor);
		if(!empty($vendor))$this->db->like('vendor',$vendor);
		$query=$this->db->get("acc_vendors");
		return $query->num_rows();
	}
	
	/*function ambilItemData1($table,$condition=""){
		$this->db->select('acc_vendors.vend_code, acc_vendors.vendor ,acc_vendors.contact, acc_vendors.address, acc_vendors.city, acc_vendors.state, 
							acc_vendors.zip, acc_vendors.country, acc_vendors.phone1, acc_vendors.phone2, acc_vendors.fax,accounts.account',FALSE);
		$this->db->join('accounts','accounts.account=acc_vendors.account');
		if(!empty($condition)){
			$this->db->where($condition,null,false);
		}
		$query= $this->db->get($table);
		return $query->row_array();
	}*/

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

	function delete($table,$a){
		$this->db->delete($table, array('vend_code' => $a)); 
		return true;
	}

	/*function isItemTest($kode_pelayanan,$kode_item)
	{
		$this->db->where('kode_pelayanan',$kode_pelayanan);
		$this->db->where('kode_item',$kode_item);
		$query=$this->db->get('lab_item_test');
		$ada= $query->num_rows();
		if($ada)return true;
		return false;
	}
	function getAllPasien($ktp_pasien,$nama_pasien,$order,$limit,$offset){
		//if(!empty($nama)) $this->db->like('nama_pasien',$nama);
		if(!empty($ktp_pasien))$this->db->like('ktp_pasien',$ktp_pasien,'both');
		if(!empty($nama_pasien))$this->db->like('nama_pasien',$nama_pasien,'both');
		if($order==1)$this->db->order_by('ktp_pasien','asc');
		if($order==2)$this->db->order_by('nama_pasien','asc');
		$this->db->limit($limit,$offset);
		$query=$this->db->get("lab_master_pasien");
		return $query->result_array();
	}

	function getAllItemPelayanan($jenispelayanan,$itempelayanan,$limit,$offset){
		//if(!empty($nama)) $this->db->like('nama_pasien',$nama);
		$this->db->limit($limit,$offset);
		if(!empty($jenispelayanan)){
			$this->db->where('a.kode_jenis_pelayanan',$jenispelayanan);			
		}
		if(!empty($itempelayanan))$this->db->like('a.nama_item_pelayanan',$itempelayanan,'both');
		$this->db->join('lab_jenis_pelayanan b','a.kode_jenis_pelayanan=b.kode_jenis_pelayanan');
		$query=$this->db->get("lab_item_pelayanan a");
		return $query->result_array();
	}

	function countAllPasien($ktp_pasien,$nama_pasien){
		//if(!empty($nama)) $this->db->like('nama_pasien',$nama);
		if(!empty($ktp_pasien))$this->db->like('ktp_pasien',$ktp_pasien,'both');
		if(!empty($nama_pasien))$this->db->like('nama_pasien',$nama_pasien,'both');
		$query=$this->db->get("lab_master_pasien");
		return $query->num_rows();
	}

	function countAllItemPelayanan($jenispelayanan,$itempelayanan){
		//if(!empty($nama)) $this->db->like('nama_pasien',$nama);
		if(!empty($jenispelayanan)){
			$this->db->where('a.kode_jenis_pelayanan',$jenispelayanan);			
		}
		if(!empty($itempelayanan))$this->db->like('a.nama_item_pelayanan',$itempelayanan,'both');
		$this->db->join('lab_jenis_pelayanan b','a.kode_jenis_pelayanan=b.kode_jenis_pelayanan');
		$query=$this->db->get("lab_item_pelayanan a");
		return $query->num_rows();
	}*/
	
}
	
?>