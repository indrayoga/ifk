<?



class Mpenerimaan extends CI_Model {

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

	function isPosted($nopenerimaan)
	{
		$this->db->join('acc_cso b','a.cso_number=b.cso_number');
		$this->db->where('b.cso_number',$nopenerimaan);
		$this->db->where('posted',1);
		$this->db->where('b.type',1);
		$query=$this->db->get('acc_cso_detail a');
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

	function getAllPenerimaan($nopenerimaan,$unitkerja,$periodeawal,$periodeakhir,$posted){
		//if(!empty($nama)) $this->db->like('nama_pasien',$nama);
		if(!empty($nopenerimaan))$this->db->like('a.cso_number',$nopenerimaan,'both');
		if(!empty($unitkerja))$this->db->where('a.kd_unit_kerja',$unitkerja);
		if(!empty($posted))$this->db->where('a.cso_number in (select cso_number from acc_cso_detail where posted="'.$posted.'")');
		if(!empty($periodeawal))$this->db->where('date(a.cso_date)>=',convertDate($periodeawal));
		if(!empty($periodeakhir))$this->db->where('date(a.cso_date)<=',convertDate($periodeakhir));

		$this->db->where('a.type',1);
		$this->db->join('unit_kerja b','a.kd_unit_kerja=b.kd_unit_kerja','left');
		$this->db->join('acc_payment c','a.pay_code=c.pay_code','left');
		$this->db->join('accounts d','a.account=d.account','left');
		$this->db->order_by('a.cso_date','desc');
		//$this->db->limit($limit,$offset);
		
		$query=$this->db->get("acc_cso a");
		return $query->result_array();
	}

	function getPendapatan(){

		$this->db->where('a.type',3);
		$this->db->where('a.status_pendapatan',0);
		$this->db->join('accounts d','a.account=d.account','left');
		$this->db->order_by('a.cso_date','desc');
		//$this->db->limit($limit,$offset);
		
		$query=$this->db->get("acc_cso a");
		return $query->result_array();
	}

	function getPenerimaan($nopenerimaan){
		//if(!empty($nama)) $this->db->like('nama_pasien',$nama);
		if(!empty($nopenerimaan))$this->db->like('a.cso_number',$nopenerimaan,'both');

		$this->db->where('a.type',1);
		$this->db->join('acc_payment c','a.pay_code=c.pay_code');
		$this->db->join('accounts d','a.account=d.account');
		//$this->db->limit($limit,$offset);
		
		$query=$this->db->get("acc_cso a");
		return $query->row_array();
	}

	function getAllDetailPenerimaan($nopenerimaan){
		if(substr($nopenerimaan,0,3)=="BPD"){
		$this->db->select('*,amount as value,notes as description');
		$this->db->where('cso_number',$nopenerimaan);
		//$this->db->limit($limit,$offset);
		$this->db->join('accounts b','a.account=b.account');
		$query=$this->db->get("acc_cso a");
		
		}else{
		$this->db->order_by('line','asc');
		$this->db->where('cso_number',$nopenerimaan);
		//$this->db->limit($limit,$offset);
		$this->db->join('accounts b','a.account=b.account');
		$query=$this->db->get("acc_cso_detail a");
		}
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
		$this->db->select('max(mid(cso_number,5,3)) as urut',false);
		$this->db->where('year(cso_date)',$tahun);
		$this->db->where('month(cso_date)',$bulan);
		if($this->isAkunBank($akunbank)){
			$this->db->where('left(cso_number,3)','BBM');
		}else{
			$this->db->where('left(cso_number,3)','PNM');
			$this->db->where('a.type',1);
		}
		$query=$this->db->get("acc_cso a");
		$item= $query->row_array();
		return $item['urut'];
	}

	function isNumberExist($number){
		$this->db->where('cso_number',$number);
		$this->db->where('type !=',3,null,false);
		$query=$this->db->get('acc_cso');
		$count=$query->num_rows();
		if($count){
			return true;
		}
		return false;
	}
	
	function isPendapatan($number){
		$this->db->where('cso_number',$number);
		$this->db->where('type',3);
		$this->db->where('status_pendapatan',0);
		$query=$this->db->get('acc_cso');
		$count=$query->num_rows();
		if($count){
			return true;
		}
		return false;
	}
	
}
	
?>
