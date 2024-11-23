<?



class Mpengeluaran extends CI_Model {

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
		$this->db->where('cso_number',$nopenerimaan);
		$this->db->where('posted',1);
		$query=$this->db->get('acc_cso_detail');
		$item=$query->num_rows();
		if($item)return true;
		return false;
	}

	function isAccount($akun)
	{
		$this->db->where('account',$akun);
		$query=$this->db->get('accounts');
		$item=$query->num_rows();
		if($item)return true;
		return false;
	}

	function getAllPengeluaran($nomor,$unitkerja,$periodeawal,$periodeakhir,$posted){
		//if(!empty($nama)) $this->db->like('nama_pasien',$nama);
		if(!empty($nomor))$this->db->like('cso_number',$nomor,'both');
		if(!empty($unitkerja))$this->db->where('a.kd_unit_kerja',$unitkerja);
		if(!empty($posted))$this->db->where('a.cso_number in (select cso_number from acc_cso_detail where posted="'.$posted.'")');
		if(!empty($periodeawal))$this->db->where('date(cso_date)>=',$periodeawal);
		if(!empty($periodeakhir))$this->db->where('date(cso_date)<=',$periodeakhir);

		$this->db->where('a.type',0);
		$this->db->join('unit_kerja b','a.kd_unit_kerja=b.kd_unit_kerja','left');
		$this->db->join('acc_payment c','a.pay_code=c.pay_code','left');
		$this->db->join('accounts d','a.account=d.account','left');
		//$this->db->limit($limit,$offset);
		$query=$this->db->get("acc_cso a");
		return $query->result_array();
	}

	function getPengeluaran($nomor){
		//if(!empty($nama)) $this->db->like('nama_pasien',$nama);
		if(!empty($nomor))$this->db->where('cso_number',$nomor);

		$this->db->where('a.type',0);
		$this->db->join('acc_payment c','a.pay_code=c.pay_code');
		$this->db->join('accounts d','a.account=d.account');
		//$this->db->limit($limit,$offset);
		
		$query=$this->db->get("acc_cso a");
		return $query->row_array();
	}

	function getAllDetailPengeluaran($nomor){
		$this->db->order_by('line','asc');
		$this->db->where('cso_number',$nomor);
		//$this->db->limit($limit,$offset);
		$this->db->join('accounts b','a.account=b.account');
		$query=$this->db->get("acc_cso_detail a");
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
		if($akunbank!="110106"){
			if($this->isAkunBank($akunbank)){
				$this->db->where('left(cso_number,3)','BBM');
			}else{
				$this->db->where('left(cso_number,3)','BBK');
				$this->db->where('a.type',0);
			}
		}else{
			$this->db->where('left(cso_number,3)','PNG');
			$this->db->where('a.type',0);			
		}
		$query=$this->db->get("acc_cso a");
		$item= $query->row_array();
		return $item['urut'];
	}

	function isNumberExist($number){
		$this->db->where('cso_number',$number);
		$query=$this->db->get('acc_cso');
		$count=$query->num_rows();
		if($count){
			return true;
		}
		return false;
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
	}
	
}
	
?>
