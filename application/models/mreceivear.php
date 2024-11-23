<?



class Mreceivear extends CI_Model {

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

	function ambilItemData($table,$condition=""){
		if(!empty($condition)){
			$this->db->where($condition,null,false);
		}
		$query= $this->db->get($table);
		return $query->row_array();
	}

    function insert($table,$data) {
		$this->db->insert($table, $data);
		return $this->db->insert_id();
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

	function isPosted($nomor)
	{
		$this->db->where('ar_number',$nomor);
		$this->db->where('posted',1);
		$query=$this->db->get('acc_ar_detail');
		$item=$query->num_rows();
		if($item)return true;
		return false;
	}

	function isAccount($akun)
	{
		$this->db->where('account',$akun);
		$this->db->where('type','D');
		$query=$this->db->get('accounts');
		$item=$query->num_rows();
		if($item)return true;
		return false;
	}

	function getAllReceiveAR($nomor,$customer,$periodeawal,$periodeakhir,$periodeawaljatuhtempo,$periodeakhirjatuhtempo,$posted){
		//if(!empty($nama)) $this->db->like('nama_pasien',$nama);
		if(!empty($nomor))$this->db->like('a.ar_number',$nomor,'both');
		if(!empty($customer))$this->db->where('a.cust_code',$customer);
		if(!empty($periodeawal))$this->db->where('date(a.ar_date)>=',$periodeawal);
		if(!empty($periodeakhir))$this->db->where('date(a.ar_date)<=',$periodeakhir);
		if(!empty($periodeawaljatuhtempo))$this->db->where('date(a.due_date)>=',$periodeawaljatuhtempo);
		if(!empty($periodeakhirjatuhtempo))$this->db->where('date(a.due_date)<=',$periodeakhirjatuhtempo);
		if($posted)$this->db->where('ar_number in (select ar_number from acc_ar_detail where posted=1)',null,false);

		$this->db->join('acc_customers b','a.cust_code=b.cust_code');
		$query=$this->db->get("acc_ar_trans a");
		return $query->result_array();
	}

	function getReceiveAR($nomor){
		//if(!empty($nama)) $this->db->like('nama_pasien',$nama);
		if(!empty($nomor))$this->db->where('ar_number',$nomor);

		$this->db->join('acc_customers b','a.cust_code=b.cust_code');
		//$this->db->limit($limit,$offset);
		
		$query=$this->db->get("acc_ar_trans a");
		return $query->row_array();
	}

	function getAllDetailReceive($nomorar){
		$this->db->order_by('line','asc');
		$this->db->where('ar_number',$nomorar);
		$this->db->join('accounts b','a.account=b.account');
		//$this->db->limit($limit,$offset);
		$query=$this->db->get("acc_ar_detail a");
		return $query->result_array();		
	}
	
	function isAkunBank($akun){
		$query = $this->db->query('select setting from sys_setting where key_data="ACCOUNT_BANK"');
		$item = $query->row_array();
		$akunbank=explode(",",$item['setting']);
		if(in_array($akun,$akunbank)){
			//debugvar('xx');
				return true;
		}
		return false;
	}

	function getJumlahTransaksiBulan($tahun,$bulan,$akunbank=""){
		//if(!empty($nama)) $this->db->like('nama_pasien',$nama);
		$this->db->select('max(right(ar_number,3)) as urut',false);
		$this->db->where('year(ar_date)',$tahun);
		$this->db->where('month(ar_date)',$bulan);
		if($this->isAkunBank($akunbank)){
			$this->db->where('left(ar_number,3)','BBM');
		}else{
			$this->db->where('left(ar_number,3)','PAR');
		}
		$query=$this->db->get("acc_ar_trans a");
		$item= $query->row_array();
		return $item['urut'];
	}

	function getJumlahTransaksiARFIBulan($tahun,$bulan){
		//if(!empty($nama)) $this->db->like('nama_pasien',$nama);
		$this->db->select('max(right(arfi_number,3)) as urut',false);
		$this->db->where('year(date)',$tahun);
		$this->db->where('month(date)',$bulan);
		$query=$this->db->get("acc_arfak_int a");
		$item= $query->row_array();
		return $item['urut'];
	}

	function isNumberExist($number){
		$this->db->where('ar_number',$number);
		$query=$this->db->get('acc_ar_trans');
		$count=$query->num_rows();
		if($count){
			return true;
		}
		return false;
	}	

	function getARFIbyCustomer($q){
		$this->db->select('a.*');
		$this->db->where('b.cust_code',$q);
		$this->db->where('a.remain >',0);
		$this->db->where('a.paid =',0);

		$this->db->join('acc_ar_faktur b','a.arf_number=b.arf_number');
		$query=$this->db->get('acc_arfak_int a');
		return $query->result_array();
	}
}
	
?>
