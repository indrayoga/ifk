<?

class Mpaymentap extends CI_Model {

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
		$this->db->where('ap_number',$nomor);
		$this->db->where('posted',1);
		$query=$this->db->get('acc_ap_detail');
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

	function getAllPaymentAP($nomor,$vendor,$periodeawal,$periodeakhir,$periodeawaljatuhtempo,$periodeakhirjatuhtempo,$posted){
		//if(!empty($nama)) $this->db->like('nama_pasien',$nama);
		if(!empty($nomor))$this->db->like('a.ap_number',$nomor,'both');
		if(!empty($vendor))$this->db->where('a.vend_code',$vendor);
		if(!empty($periodeawal))$this->db->where('date(a.ap_date)>=',$periodeawal);
		if(!empty($periodeakhir))$this->db->where('date(a.ap_date)<=',$periodeakhir);
		if(!empty($periodeawaljatuhtempo))$this->db->where('date(a.due_date)>=',$periodeawaljatuhtempo);
		if(!empty($periodeakhirjatuhtempo))$this->db->where('date(a.due_date)<=',$periodeakhirjatuhtempo);
		if($posted)$this->db->where('ap_number in (select ap_number from acc_ap_detail where posted=1)',null,false);

		$this->db->join('acc_vendors b','a.vend_code=b.vend_code');
		$query=$this->db->get("acc_ap_trans a");
		return $query->result_array();
	}

	function getPaymentAP($nomor){
		//if(!empty($nama)) $this->db->like('nama_pasien',$nama);
		if(!empty($nomor))$this->db->where('ap_number',$nomor);

		$this->db->join('acc_vendors b','a.vend_code=b.vend_code');
		//$this->db->limit($limit,$offset);
		
		$query=$this->db->get("acc_ap_trans a");
		return $query->row_array();
	}

	function getAllDetailPayment($nomorar){
		$this->db->order_by('line','asc');
		$this->db->where('ap_number',$nomorar);
		$this->db->join('accounts b','a.account=b.account');
		//$this->db->limit($limit,$offset);
		$query=$this->db->get("acc_ap_detail a");
		return $query->result_array();		
	}

	function getJumlahTransaksiBulan($tahun,$bulan){
		//if(!empty($nama)) $this->db->like('nama_pasien',$nama);
		$this->db->select('max(right(ap_number,3)) as urut',false);
		$this->db->where('year(ap_date)',$tahun);
		$this->db->where('month(ap_date)',$bulan);
		$query=$this->db->get("acc_ap_trans a");
		$item= $query->row_array();
		return $item['urut'];
	}

	function getJumlahTransaksiAPFIBulan($tahun,$bulan){
		//if(!empty($nama)) $this->db->like('nama_pasien',$nama);
		$this->db->select('max(right(apfi_number,3)) as urut',false);
		$this->db->where('year(date)',$tahun);
		$this->db->where('month(date)',$bulan);
		$query=$this->db->get("acc_apfak_int a");
		$item= $query->row_array();
		return $item['urut'];
	}

	function isNumberExist($number){
		$this->db->where('ap_number',$number);
		$query=$this->db->get('acc_ap_trans');
		$count=$query->num_rows();
		if($count){
			return true;
		}
		return false;
	}

	function getAPFIbyVendor($q){
		$this->db->select('a.*');
		$this->db->where('b.vend_code',$q);
		$this->db->where('a.remain >',0);
		$this->db->where('a.paid =',0);

		$this->db->join('acc_ap_faktur b','a.apf_number=b.apf_number');
		$query=$this->db->get('acc_apfak_int a');
		return $query->result_array();
	}
	
}
	
?>