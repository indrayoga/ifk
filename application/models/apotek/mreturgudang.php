<?



class Mreturgudang extends CI_Model {

	function __construct() {
		
		parent::__construct();
	}

	/*function ambilDataDistribusi($nama_unit_tujuan){ 
		/*$this->db->select("apt_penjualan.no_penjualan, date_format(apt_penjualan.tgl_penjualan,'%d-%m-%Y') as tglpenjualan, apt_penjualan.nama_pasien, apt_customers.customer, apt_penjualan.is_lunas, format(apt_penjualan.total_transaksi,0) as totaltransaksi",FALSE);
		$this->db->join('apt_customers','apt_customers.cust_code=apt_penjualan.cust_code');
		if(!empty($nama_pasien)) $this->db->like('apt_penjualan.nama_pasien',$nama_pasien);
			$this->db->order_by('apt_penjualan.no_penjualan','asc');
		$query=$this->db->get('apt_penjualan');*/
		/*$query=$this->db->query("select apt_retur_gudang.no_retur, date_format(apt_retur_gudang.tgl_retur, '%d-%m-%Y') as tgl_retur, apt_unit.nama_unit_apt as unit_tujuan
								from apt_retur_gudang, apt_unit where apt_retur_gudang.kd_unit_tujuan=apt_unit.kd_unit_apt and 
								apt_unit.nama_unit_apt like '%$nama_unit_tujuan%'");
		return $query->result_array(); 
	}*/
	
	function ambilDataRetur($no_retur,$kd_unit_apt,$periodeawal,$periodeakhir){ 
		$kd_unit_apt=$this->session->userdata('kd_unit_apt');
		$this->db->select("apt_retur_gudang.no_retur, date_format(apt_retur_gudang.tgl_retur,'%d-%m-%Y %H:%i:%s') as tgl_retur, apt_unit.nama_unit_apt as unit_asal,apt_retur_gudang.posting,
							apt_retur_gudang.kd_unit_tujuan as kd_unit_tujuan1,(select nama_unit_apt from apt_unit where kd_unit_apt=kd_unit_tujuan1) as unit_tujuan",FALSE);
		if(!empty($no_retur))$this->db->like('apt_retur_gudang.no_retur',$no_retur,'both');
		if(!empty($kd_unit_apt))$this->db->where('apt_retur_gudang.kd_unit_asal',$kd_unit_apt);
		if(!empty($periodeawal))$this->db->where('date(apt_retur_gudang.tgl_retur)>=',convertDate($periodeawal));
		if(!empty($periodeakhir))$this->db->where('date(apt_retur_gudang.tgl_retur)<=',convertDate($periodeakhir));		
		
		//$this->db->join('apt_unit','apt_unit.kd_unit_apt=apt_retur_gudang.kd_unit_tujuan');
		$this->db->join('apt_unit','apt_unit.kd_unit_apt=apt_retur_gudang.kd_unit_asal','left');		
		$this->db->order_by('apt_retur_gudang.no_retur','desc');
		
		$query=$this->db->get("apt_retur_gudang");		
		return $query->result_array(); 
	}
	
	function ambilItemData3($kd_unit_asal,$value){
		$this->db->select('harga_pokok',FALSE);
		if(!empty($kd_unit_apt)) $this->db->where('kd_unit_apt',$kd_unit_asal);
		if(!empty($value)) $this->db->where('kd_obat',$value);
		$query= $this->db->get("apt_stok_unit");
		$harga_pokok=$query->row_array();
		return $harga_pokok['harga_pokok'];
	}
	
	function ambilPembanding($value){
		$this->db->select('pembanding',FALSE);
		if(!empty($value)) $this->db->where('kd_obat',$value);
		$query= $this->db->get("apt_obat");
		$pembanding=$query->row_array();
		return $pembanding['pembanding'];
	}
	
	/*function ambilStokAsal($kd_unit_asal,$value){
		$this->db->select('jml_stok',FALSE);
		if(!empty($kd_unit_asal)) $this->db->where('kd_unit_apt',$kd_unit_asal);
		if(!empty($value)) $this->db->where('kd_obat',$value);
		$query= $this->db->get("apt_stok_unit");
		$jml_stok_asal=$query->row_array();
		return $jml_stok_asal['jml_stok'];
	}*/
	
	/*function ambilStokTujuan($kd_unit_tujuan,$value){
		$this->db->select('jml_stok',FALSE);
		if(!empty($kd_unit_tujuan)) $this->db->where('kd_unit_apt',$kd_unit_tujuan);
		if(!empty($value)) $this->db->where('kd_obat',$value);
		$query= $this->db->get("apt_stok_unit");
		$jml_stok_tujuan=$query->row_array();
		return $jml_stok_tujuan['jml_stok'];
	}*/
	
	function ambilStokAsal($kd_unit_asal,$value,$tglexpire){
		$kd_unit_asal=$this->session->userdata('kd_unit_apt');
		$query=$this->db->query("select jml_stok from apt_stok_unit where kd_unit_apt='$kd_unit_asal' and kd_obat='$value' and tgl_expire='$tglexpire'");
		$jml_stok_asal=$query->row_array();
		//debugvar($jml_stok_asal);
		if(empty($jml_stok_asal)) return 0;
		return $jml_stok_asal['jml_stok'];
	}
	
	function ambilStokTujuan($kd_unit_tujuan,$value,$tglexpire){
		$query=$this->db->query("select jml_stok from apt_stok_unit where kd_unit_apt='$kd_unit_tujuan' and kd_obat='$value' and tgl_expire='$tglexpire'");
		$jml_stok_tujuan=$query->row_array();
		if(empty($jml_stok_tujuan)) return 0;
		return $jml_stok_tujuan['jml_stok'];
	}

	function isPosted($no_retur)
	{
		$this->db->where('no_retur',$no_retur);
		$this->db->where('posting',1);
		$query=$this->db->get('apt_retur_gudang');
		$item=$query->num_rows();
		if($item)return true;
		return false;
	}
	
	function ambilData1($kd_unit_asal,$kd_obat){ 
		$query=$this->db->query("select apt_stok_unit.kd_obat,apt_obat.nama_obat,apt_satuan_kecil.satuan_kecil,date_format(apt_stok_unit.tgl_expire,'%d-%m-%Y') as tgl_expire,apt_obat.pembanding, 
								substring_index(apt_stok_unit.jml_stok,'.',1) as jml_stok,ifnull(apt_obat.min_stok,0) as min_stok from apt_obat,apt_stok_unit,apt_satuan_kecil,apt_unit where apt_obat.kd_obat=apt_stok_unit.kd_obat and 
								apt_obat.kd_satuan_kecil=apt_satuan_kecil.kd_satuan_kecil and apt_stok_unit.kd_unit_apt=apt_unit.kd_unit_apt and apt_stok_unit.jml_stok>0
								and apt_stok_unit.kd_unit_apt='$kd_unit_asal' and apt_obat.kd_obat like '%$kd_obat%' order by apt_obat.kd_obat asc");
		return $query->result_array();
	}
	
	function ambilData2($kd_unit_asal,$nama_obat){ 
		$query=$this->db->query("select apt_stok_unit.kd_obat,apt_obat.nama_obat,apt_satuan_kecil.satuan_kecil,date_format(apt_stok_unit.tgl_expire,'%d-%m-%Y') as tgl_expire,apt_obat.pembanding, 
								substring_index(apt_stok_unit.jml_stok,'.',1) as jml_stok,ifnull(apt_obat.min_stok,0) as min_stok from apt_obat,apt_stok_unit,apt_satuan_kecil,apt_unit where apt_obat.kd_obat=apt_stok_unit.kd_obat and 
								apt_obat.kd_satuan_kecil=apt_satuan_kecil.kd_satuan_kecil and apt_stok_unit.kd_unit_apt=apt_unit.kd_unit_apt and apt_stok_unit.jml_stok>0
								and apt_stok_unit.kd_unit_apt='$kd_unit_asal' and apt_obat.nama_obat like '%$nama_obat%' order by apt_obat.kd_obat asc");
		return $query->result_array(); 			
	}
	
	function autoNumber($tahun,$bulan){ 
		$this->db->select('max(right(no_retur,5)) as a',FALSE);
		$this->db->where('year(tgl_retur)',$tahun);
		$this->db->where('month(tgl_retur)',$bulan);
		$query = $this->db->get('apt_retur_gudang');
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
	
	function ambilDataTujuan($kd_unit_apt){
		$kd_unit_apt=$this->session->userdata('kd_unit_apt');
		if(!empty($kd_unit_apt)){
			$this->db->where('kd_unit_apt !=', $kd_unit_apt);
		}
		$query= $this->db->get('apt_unit');
		return $query->result_array();
	}

	function ambilItemData($table,$condition=""){
		if(!empty($condition)){
			$this->db->where($condition,null,false);
		}
		$query= $this->db->get($table);
		return $query->row_array();
	}
	
	function ambilItemData1($table,$condition=""){
		$this->db->select('kd_unit_apt',FALSE);
		if(!empty($condition)){
			$this->db->where($condition,null,false);
		}
		$query= $this->db->get($table);
		$kd_unit_apt=$query->row_array();
		return $kd_unit_apt['kd_unit_apt'];
	}
	
	function ambilItemData2($table,$condition=""){
		$this->db->select('kd_milik',FALSE);
		if(!empty($condition)){
			$this->db->where($condition,null,false);
		}
		$query= $this->db->get($table);
		$kd_milik=$query->row_array();
		return $kd_milik['kd_milik'];
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
	
	function getAllDetailRetur($no_retur){
		/*$query=$this->db->query("select apt_obat.kd_obat, apt_obat.nama_obat, apt_satuan_kecil.satuan_kecil, apt_stok_unit.tgl_expire, 
								apt_obat.pembanding, apt_retur_gudang_detail.qty from apt_obat, apt_satuan_kecil, apt_stok_unit, 
								apt_unit, apt_retur_gudang_detail, apt_retur_gudang where apt_obat.kd_satuan_kecil=apt_satuan_kecil.kd_satuan_kecil 
								and apt_obat.kd_obat=apt_stok_unit.kd_obat and apt_obat.kd_obat=apt_retur_gudang_detail.kd_obat and 
								apt_stok_unit.kd_unit_apt=apt_unit.kd_unit_apt and apt_stok_unit.kd_obat=apt_retur_gudang_detail.kd_obat 
								and apt_stok_unit.kd_unit_apt=apt_retur_gudang.kd_unit_asal and apt_stok_unit.kd_unit_apt=apt_retur_gudang.kd_unit_tujuan 
								and apt_unit.kd_unit_apt=apt_retur_gudang.kd_unit_asal and apt_unit.kd_unit_apt=apt_retur_gudang.kd_unit_tujuan 
								and apt_retur_gudang_detail.no_retur=apt_retur_gudang.no_retur  and apt_retur_gudang.no_retur='$no_retur'
								order by apt_obat.kd_obat asc");*/
		/*$query=$this->db->query("select apt_retur_gudang_detail.kd_obat, apt_obat.nama_obat, apt_satuan_kecil.satuan_kecil, date_format(apt_retur_gudang_detail.tgl_expire,'%d-%m-%Y') as tgl_expire, 
								apt_obat.pembanding, apt_retur_gudang_detail.qty,apt_stok_unit.jml_stok from apt_obat, apt_satuan_kecil, apt_stok_unit, apt_retur_gudang_detail, 
								apt_retur_gudang,apt_unit where apt_obat.kd_satuan_kecil=apt_satuan_kecil.kd_satuan_kecil and apt_obat.kd_obat=apt_stok_unit.kd_obat 
								and apt_obat.kd_obat=apt_retur_gudang_detail.kd_obat and apt_retur_gudang.kd_unit_asal=apt_unit.kd_unit_apt and apt_stok_unit.kd_unit_apt=apt_unit.kd_unit_apt and 
								apt_retur_gudang.no_retur=apt_retur_gudang_detail.no_retur and apt_retur_gudang.no_retur='$no_retur'
								order by apt_obat.kd_obat asc");*/
		$query=$this->db->query("select apt_retur_gudang_detail.kd_obat as kdobat, apt_obat.nama_obat, apt_satuan_kecil.satuan_kecil,ifnull(apt_obat.min_stok,0) as min_stok, 
								apt_retur_gudang_detail.tgl_expire as tglexpire, apt_obat.pembanding, apt_retur_gudang_detail.qty, apt_retur_gudang.kd_unit_asal as kd_unit_asal,
								(select jml_stok from apt_stok_unit where kd_unit_apt=kd_unit_asal and kd_obat=kdobat and tgl_expire=tglexpire) as jml_stok
								from apt_retur_gudang, apt_retur_gudang_detail, apt_obat, apt_satuan_kecil where
								apt_retur_gudang.no_retur=apt_retur_gudang_detail.no_retur and apt_retur_gudang.no_retur='$no_retur'
								and apt_retur_gudang_detail.kd_obat=apt_obat.kd_obat and apt_obat.kd_satuan_kecil=apt_satuan_kecil.kd_satuan_kecil");
		return $query->result_array(); 		
	}
	
	function ambilKodeUnitAsal($no_retur){
		$this->db->select('kd_unit_asal',FALSE);
		if(!empty($no_retur)) $this->db->where('no_retur',$no_retur);
		$query= $this->db->get("apt_retur_gudang");
		$kd_unit_asal=$query->row_array();
		return $kd_unit_asal['kd_unit_asal'];
	}
	
	function ambilKodeUnitTujuan($no_retur){
		$this->db->select('kd_unit_tujuan',FALSE);
		if(!empty($no_retur)) $this->db->where('no_retur',$no_retur);
		$query= $this->db->get("apt_retur_gudang");
		$kd_unit_tujuan=$query->row_array();
		return $kd_unit_tujuan['kd_unit_tujuan'];
	}

	function isNumberExist($number){
		$this->db->where('no_retur',$number);
		$query=$this->db->get('apt_retur_gudang');
		$count=$query->num_rows();
		if($count){
			return true;
		}
		return false;
	}
	
	function cekStok($value,$kd_unit_tujuan,$tglexpire){
		$this->db->where('kd_obat',$value);
		$this->db->where('kd_unit_apt',$kd_unit_tujuan);
		$this->db->where('tgl_expire',$tglexpire);
		$query=$this->db->get('apt_stok_unit');
		$count=$query->num_rows();
		if($count){
			return true;
		}
		else{
			return false;
		}
	}
	
	function isObat($kd_obat)
	{
		$this->db->where('kd_obat',$kd_obat);
		//$this->db->where('type','D');
		$query=$this->db->get('apt_obat');
		$item=$query->num_rows();
		if($item)return true;
		return false;
	}
	
	function getRetur1($no_retur){
		$this->db->select("apt_retur_gudang.no_retur, apt_unit.nama_unit_apt as unit_asal",FALSE);
		if(!empty($no_retur))$this->db->like('apt_retur_gudang.no_retur',$no_retur,'both');

		$this->db->join('apt_unit','apt_retur_gudang.kd_unit_asal=apt_unit.kd_unit_apt');
		
		$query=$this->db->get("apt_retur_gudang");
		return $query->row_array();
	}
	
	function getRetur2($no_retur){
		$this->db->select("date_format(apt_retur_gudang.tgl_retur,'%d-%m-%Y') as tgl_retur,apt_retur_gudang.shift,apt_unit.nama_unit_apt as unit_tujuan",FALSE);
		if(!empty($no_retur))$this->db->like('apt_retur_gudang.no_retur',$no_retur,'both');

		$this->db->join('apt_unit','apt_retur_gudang.kd_unit_tujuan=apt_unit.kd_unit_apt');
		
		$query=$this->db->get("apt_retur_gudang");
		return $query->row_array();
	}
	
	function ambilNama($value){
		$query=$this->db->query("select nama_obat from apt_obat where kd_obat='$value'");
		$nama=$query->row_array();
		return $nama['nama_obat'];
	}
	
	function ambilNamaUnit($kd_unit_apt){
		//$kd_unit_apt=$this->session->userdata('kd_unit_apt');
		$query=$this->db->query("select nama_unit_apt from apt_unit where kd_unit_apt='$kd_unit_apt'");
		$unit=$query->row_array();
		return $unit['nama_unit_apt'];
	}
	
	function ambilItemDataRetur($no_retur){
		$query=$this->db->query("select no_retur,shift,date_format(tgl_retur,'%Y-%m-%d') as tgl_retur,
								date_format(tgl_retur,'%H:%i:%s') as jam_retur,posting,kd_unit_asal,kd_unit_tujuan
								from apt_retur_gudang where no_retur='$no_retur'");
		return $query->row_array();
	}
	
	function ambilApp(){
		$id_user=$this->session->userdata('id_user'); 
		$query=$this->db->query("select kd_app from approval where id_user='$id_user'");
		$kd_applogin=$query->row_array();
		if(empty($kd_applogin))return 0;
		return $kd_applogin['kd_app'];
	}
	
	function nomor(){
		$query=$this->db->query("select max(nomor) as kode from apt_log_returgudang");
		$kode=$query->row_array();
		if(empty($kode)) return 0;
		return $kode['kode'];
	}
}
	
?>