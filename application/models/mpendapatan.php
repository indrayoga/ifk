<?



class Mpendapatan extends CI_Model {

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

	function isPosted($nopendapatan)
	{
		$this->db->where('cso_number',$nopendapatan);
		$this->db->where('posted',1);
		$query=$this->db->get('acc_cso_detail');
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

	function import($tanggalawal,$tanggalakhir){
		$this->db->query("delete from acc_biaya_pelayanan where cso_number is null and cso_date is null");

		$this->db->query("replace into acc_biaya_pelayanan SELECT c.kd_kasir, c.no_pendaftaran, c.urut,a.account,null,null
						FROM accounts_pelayanan_unit a
						RIGHT JOIN biaya_pelayanan b ON a.kd_unit_kerja = b.kd_unit_kerja
						AND a.kd_pelayanan = b.kd_pelayanan
						JOIN struk_pelayanan c ON b.kd_kasir = c.kd_kasir
						AND b.no_pendaftaran = c.no_pendaftaran
						AND b.urut = c.urut
						WHERE date( b.tgl_pelayanan )
						BETWEEN '".$tanggalawal."'
						AND '".$tanggalakhir."'
						AND is_import_acc =0
						ORDER BY c.urut ASC");

		$query=$this->db->query("SELECT ifnull( x.account, '' ) AS account, ifnull( accounts.name, 'akun belum di mapping' ) AS name, '' AS keterangan, x.total
								FROM (

								SELECT a.account, sum( c.total ) AS total
								FROM accounts_pelayanan_unit a
								RIGHT JOIN biaya_pelayanan b ON a.kd_unit_kerja = b.kd_unit_kerja AND a.kd_pelayanan = b.kd_pelayanan
								JOIN struk_pelayanan c ON b.kd_kasir = c.kd_kasir
								AND b.no_pendaftaran = c.no_pendaftaran
								AND b.urut = c.urut
								where date( b.tgl_pelayanan )
								BETWEEN '".$tanggalawal."'
								AND '".$tanggalakhir."'
								and is_import_acc=0
								GROUP BY a.account
								) AS x
								LEFT JOIN accounts ON x.account = accounts.account");


		//$this->db->trans_complete(); 

		return $query->result_array();
	}

	function updateaccBiayaPendapatan($akun,$nomor,$tanggal){
		$this->db->query("update acc_biaya_pelayanan set cso_number='".$nomor."',cso_date='".$tanggal."' where account='".$akun."' and cso_number is null and cso_date is null ");
		$this->db->query("update biaya_pelayanan a,acc_biaya_pelayanan b set is_import_acc=1 where a.kd_kasir=b.kd_kasir and a.no_pendaftaran=b.no_pendaftaran and a.urut=b.urut and b.account='".$akun."'");
		return true;
	}

	function deleteaccBiayaPendapatan($nomor,$tanggal){
		$this->db->query("update acc_biaya_pelayanan set cso_number=null,cso_date=null where cso_number='".$nomor."' and cso_date='".$tanggal."' ");
		$this->db->query("update biaya_pelayanan a,acc_biaya_pelayanan b set is_import_acc=0 where a.kd_kasir=b.kd_kasir and a.no_pendaftaran=b.no_pendaftaran and a.urut=b.urut and cso_number is null and cso_date is null ");
		return true;
	}

	function getAllPendapatan($nopendapatan,$unitkerja,$periodeawal,$periodeakhir,$posted){
		//if(!empty($nama)) $this->db->like('nama_pasien',$nama);
		if(!empty($nopendapatan))$this->db->like('a.cso_number',$nopendapatan,'both');
		if(!empty($posted))$this->db->where('a.cso_number in (select cso_number from acc_cso_detail where posted="'.$posted.'")');
		if(!empty($periodeawal))$this->db->where('date(a.cso_date)>=',convertDate($periodeawal));
		if(!empty($periodeakhir))$this->db->where('date(a.cso_date)<=',convertDate($periodeakhir));

		$this->db->where('a.type',3);
		$this->db->join('acc_payment c','a.pay_code=c.pay_code','left');
		$this->db->join('accounts d','a.account=d.account','left');
		$this->db->order_by('a.cso_date','desc');
		//$this->db->limit($limit,$offset);
		
		$query=$this->db->get("acc_cso a");
		return $query->result_array();
	}

	function getAllPendapatan1($nopendapatan,$unitkerja,$periodeawal,$periodeakhir,$posted){
		//if(!empty($nama)) $this->db->like('nama_pasien',$nama);
		if(!empty($nopendapatan))$this->db->like('a.cso_number',$nopendapatan,'both');
		if(!empty($posted))$this->db->where('a.cso_number in (select cso_number from acc_cso_detail where posted="'.$posted.'")');
		if(!empty($periodeawal))$this->db->where('date(a.cso_date)>=',convertDate($periodeawal));
		if(!empty($periodeakhir))$this->db->where('date(a.cso_date)<=',convertDate($periodeakhir));

		$this->db->join('acc_payment c','a.pay_code=c.pay_code','left');
		$this->db->join('accounts d','a.account=d.account','left');
		$this->db->order_by('a.cso_date','desc');
		//$this->db->limit($limit,$offset);
		
		$query=$this->db->get("acc_pdp a");
		return $query->result_array();
	}

	function getPendapatan($nopendapatan){
		//if(!empty($nama)) $this->db->like('nama_pasien',$nama);
		if(!empty($nopendapatan))$this->db->like('a.cso_number',$nopendapatan,'both');

		$this->db->where('a.type',3);
		$this->db->join('accounts d','a.account=d.account');
		//$this->db->limit($limit,$offset);
		
		$query=$this->db->get("acc_cso a");
		return $query->row_array();
	}

	function getAllDetailPendapatan($nopendapatan){
		$this->db->order_by('line','asc');
		$this->db->where('cso_number',$nopendapatan);
		//$this->db->limit($limit,$offset);
		$this->db->join('accounts b','a.account=b.account');
		$query=$this->db->get("acc_cso_detail a");
		return $query->result_array();		
	}

	function getAllDetailPendapatan1($nopendapatan){
		$this->db->order_by('line','asc');
		$this->db->where('cso_number',$nopendapatan);
		//$this->db->limit($limit,$offset);
		$query=$this->db->get("acc_pdp_detail a");
		return $query->result_array();		
	}

	function isAkunBank($akun){
		$query = $this->db->query('select setting from sys_setting where key_data="ACCOUNT_PENDAPATAN"');
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
		$this->db->where('left(cso_number,3)','BPD');
		$this->db->where('a.type',3);
		$query=$this->db->get("acc_cso a");
		$item= $query->row_array();
		return $item['urut'];
	}

	function getJumlahTransaksiBulan1($tahun,$bulan,$akunbank=""){
		//if(!empty($nama)) $this->db->like('nama_pasien',$nama);
		$this->db->select('max(mid(cso_number,5,3)) as urut',false);
		$this->db->where('year(cso_date)',$tahun);
		$this->db->where('month(cso_date)',$bulan);
		$this->db->where('left(cso_number,3)','BPD');
		$query=$this->db->get("acc_pdp a");
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
	
	function isNumberExist1($number){
		$this->db->where('cso_number',$number);
		$query=$this->db->get('acc_pdp');
		$count=$query->num_rows();
		if($count){
			return true;
		}
		return false;
	}
	
}
	
?>
