<?



class Mpengajuan extends CI_Model {

	function __construct() {
		
		parent::__construct();
	}

	function ambilDataPengajuan($no_pengajuan,$periodeawal,$periodeakhir){
		$this->db->select("apt_pengajuan.no_pengajuan, date_format(apt_pengajuan.tgl_pengajuan,'%d-%m-%Y %H:%i:%s') as tgl_pengajuan, apt_pengajuan.keterangan,apt_pengajuan.status_approve",FALSE);
		if(!empty($no_pengajuan))$this->db->like('no_pengajuan',$no_pengajuan,'both');
		if(!empty($periodeawal))$this->db->where('date(tgl_pengajuan)>=',convertDate($periodeawal));
		if(!empty($periodeakhir))$this->db->where('date(tgl_pengajuan)<=',convertDate($periodeakhir));
		
		//$this->db->join('apt_supplier','apt_supplier.kd_supplier=apt_pengajuan.kd_supplier','left');
		$this->db->order_by('no_pengajuan','desc');
		
		$query=$this->db->get("apt_pengajuan");		
		return $query->result_array(); 
	}
	
	function ambilItemData3($kd_unit_apt,$kd_milik,$value){
		$this->db->select('harga_pokok',FALSE);
		if(!empty($kd_unit_apt)) $this->db->where('kd_unit_apt',$kd_unit_apt);
		if(!empty($kd_milik)) $this->db->where('kd_milik',$kd_milik);
		if(!empty($value)) $this->db->where('kd_obat',$value);
		$query= $this->db->get("apt_stok_unit");
		$harga_pokok=$query->row_array();
		return $harga_pokok['harga_pokok'];
	}
	
	function ambilStok($kd_unit_apt,$value){
		$this->db->select('jml_stok',FALSE);
		if(!empty($kd_unit_apt)) $this->db->where('kd_unit_apt',$kd_unit_apt);
		if(!empty($value)) $this->db->where('kd_obat',$value);
		$query= $this->db->get("apt_stok_unit");
		$jml_stok=$query->row_array();
		return $jml_stok['jml_stok'];
	}
	
	function isPosted($nopengajuan)
	{
		$this->db->where('no_pengajuan',$nopengajuan);
		$this->db->where('status_approve',1);
		$query=$this->db->get('apt_pengajuan');
		$item=$query->num_rows();
		if($item)return true;
		return false;
	}
	
	function ambilData1($kd_obat){ 
		/*$query=$this->db->query("select apt_obat.kd_obat,apt_obat.nama_obat,apt_satuan_kecil.satuan_kecil,date_format(apt_stok_unit.tgl_expire,'%d-%m-%Y') as tgl,
								apt_obat.pembanding from apt_unit,apt_obat,
								apt_stok_unit,apt_golongan,apt_jenis_obat,apt_margin_harga,apt_satuan_kecil,apt_milik where apt_unit.kd_unit_apt=apt_stok_unit.kd_unit_apt 
								and apt_obat.kd_obat=apt_stok_unit.kd_obat and apt_obat.kd_golongan=apt_golongan.kd_golongan 
								and apt_obat.kd_jenis_obat=apt_jenis_obat.kd_jenis_obat and apt_obat.kd_golongan=apt_margin_harga.kd_golongan 
								and apt_obat.kd_jenis_obat=apt_margin_harga.kd_jenis_obat and apt_golongan.kd_golongan=apt_margin_harga.kd_golongan 
								and apt_jenis_obat.kd_jenis_obat=apt_margin_harga.kd_jenis_obat and apt_obat.kd_satuan_kecil=apt_satuan_kecil.kd_satuan_kecil 
                                and apt_milik.kd_milik=apt_stok_unit.kd_milik and apt_obat.kd_obat like '%$kd_obat%' 
								order by apt_unit.kd_unit_apt asc");*/
		$query=$this->db->query("select apt_obat.kd_obat,apt_obat.nama_obat,apt_satuan_kecil.satuan_kecil,apt_obat.pembanding from apt_obat,apt_satuan_kecil
								where apt_obat.kd_satuan_kecil=apt_satuan_kecil.kd_satuan_kecil and apt_obat.kd_obat like '%$kd_obat%' 
								order by apt_obat.nama_obat asc");
		return $query->result_array();
	}
	
	function ambilData2($nama_obat){ 
		$query=$this->db->query("SELECT apt_obat.kd_obat, apt_obat.nama_obat, apt_satuan_kecil.satuan_kecil, apt_obat.pembanding, ifnull( substring_index( apt_stok_unit.jml_stok, '.', 1 ) , 0 ) AS jml_stok, nama_unit_apt
									FROM apt_obat
									LEFT JOIN apt_satuan_kecil ON apt_obat.kd_satuan_kecil = apt_satuan_kecil.kd_satuan_kecil
									LEFT JOIN apt_stok_unit ON apt_obat.kd_obat = apt_stok_unit.kd_obat
									LEFT JOIN apt_unit ON apt_unit.kd_unit_apt = apt_stok_unit.kd_unit_apt
									WHERE (
									apt_unit.nama_unit_apt LIKE '%gudang farmasi%'
									OR apt_unit.nama_unit_apt IS NULL
									) 
								and apt_obat.nama_obat like '%$nama_obat%' order by apt_obat.kd_obat asc");
		
		return $query->result_array(); 			
	}
	
	function ambilDatakode($kd_obat){ 
		$query=$this->db->query("SELECT apt_obat.kd_obat, apt_obat.nama_obat, apt_satuan_kecil.satuan_kecil, apt_obat.pembanding, ifnull( substring_index( apt_stok_unit.jml_stok, '.', 1 ) , 0 ) AS jml_stok, nama_unit_apt
									FROM apt_obat
									LEFT JOIN apt_satuan_kecil ON apt_obat.kd_satuan_kecil = apt_satuan_kecil.kd_satuan_kecil
									LEFT JOIN apt_stok_unit ON apt_obat.kd_obat = apt_stok_unit.kd_obat
									LEFT JOIN apt_unit ON apt_unit.kd_unit_apt = apt_stok_unit.kd_unit_apt
									WHERE (
									apt_unit.nama_unit_apt LIKE '%gudang farmasi%'
									OR apt_unit.nama_unit_apt IS NULL
									) 
								and apt_obat.kd_obat like '%$kd_obat%' order by apt_obat.kd_obat asc");
		
		return $query->result_array(); 			
	}
	
	function ambilData3($kd_supplier){
		$query=$this->db->query("select kd_supplier,nama,alamat from apt_supplier where kd_supplier like '%$kd_supplier%'");
		return $query->result_array();
	}
	
	function ambilData4($nama){
		$query=$this->db->query("select kd_supplier,nama,alamat from apt_supplier where nama like '%$nama%'");
		return $query->result_array();
	}
	
	function ambilHarga(){
		//$query=$this->db->query("select format(SUM(harga_beli),0) as hr from apt_penerimaan_detail");
		//return $query->row_array();
		$this->db->select('SUM(harga_beli) as sum');
		$query = $this->db->get('apt_pengajuan_detail');
		$sum=$query->row_array();
		return $sum['sum'];
	}
	
	
	function autoNumber($tahun,$bulan){ 
		/*$this->db->select('max(right(no_penerimaan,12)) as a',FALSE);
		$query = $this->db->get('apt_penerimaan');
		$kode=$query->row_array();
		return $kode['a'];*/
		$this->db->select('max(right(apt_pengajuan.no_pengajuan,3)) as a',false);
		$this->db->where('year(apt_pengajuan.tgl_pengajuan)',$tahun);
		$this->db->where('month(apt_pengajuan.tgl_pengajuan)',$bulan);
		//$this->db->join('apt_penerimaan_detail','apt_penerimaan_detail.no_penerimaan=apt_penerimaan.no_penerimaan');
		//$this->db->where('a.type',1);
		$query=$this->db->get("apt_pengajuan");
		$item= $query->row_array();
		return $item['a'];
		
	}

	function ambilData($table,$condition=""){
		if(!empty($condition)){
			$this->db->where($condition,null,false);
		}
		$query= $this->db->get($table);
		return $query->result_array();
	}

	//function ambilItemData($no_pengajuan){
		/*$query=$this->db->query("select apt_pemesanan.no_pemesanan,apt_pemesanan.tgl_pemesanan,apt_pemesanan.tgl_tempo,apt_pemesanan.kd_supplier,apt_supplier.nama,apt_pemesanan.keterangan
								from apt_pemesanan,apt_supplier where apt_pemesanan.kd_supplier=apt_supplier.kd_supplier and apt_pemesanan.no_pemesanan='$no_pemesanan'");*/
		/*$query=$this->db->query("select no_pengajuan,tgl_pengajuan,keterangan from apt_pengajuan where no_pengajuan='$no_pengajuan'");
		return $query->row_array();
	}*/
	
	function ambilItemData($table,$condition=""){
		if(!empty($condition)){
			$this->db->where($condition,null,false);
		}
		$query= $this->db->get($table);
		return $query->row_array();
	}
	
	function ambilKodeUnit(){
		$query=$this->db->query("select kd_unit_apt as kode from apt_unit where nama_unit_apt like '%gudang farmasi%'");
		$kd_unit_apt=$query->row_array();
		return $kd_unit_apt['kode'];
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
	
	function getAllDetailPengajuan($no_pengajuan){ 
		$query=$this->db->query("select apt_pengajuan_detail.kd_obat,apt_obat.nama_obat,apt_satuan_kecil.satuan_kecil,apt_obat.pembanding,
								apt_pengajuan_detail.qty_kcl,apt_pengajuan_detail.qty_kcl,apt_pengajuan_detail.harga_beli,
								(apt_pengajuan_detail.qty_kcl*apt_pengajuan_detail.harga_beli) as jumlah
								from apt_pengajuan,apt_pengajuan_detail,apt_obat,apt_satuan_kecil where apt_pengajuan.no_pengajuan=apt_pengajuan_detail.no_pengajuan
								and apt_pengajuan_detail.kd_obat=apt_obat.kd_obat and apt_obat.kd_satuan_kecil=apt_satuan_kecil.kd_satuan_kecil and 
								apt_pengajuan.no_pengajuan='$no_pengajuan'"); 
		return $query->result_array(); 		
	}

	function isAppExist($number,$number1){
		$this->db->where('no_pengajuan',$number);
		$this->db->where('kd_app',$number1);
		$query=$this->db->get('apt_app_pengajuan');
		$count=$query->num_rows();
		if($count){
			return true;
		}
		return false;
	}
	
	function isNumberExist($number){
		$this->db->where('no_pengajuan',$number);
		$query=$this->db->get('apt_pengajuan');
		$count=$query->num_rows();
		if($count){
			return true;
		}
		return false;
	}
	
	function cekStok($value,$kd_unit_apt){
		$this->db->where('kd_obat',$value);
		$this->db->where('kd_unit_apt',$kd_unit_apt);
		$query=$this->db->get('apt_stok_unit');
		$count=$query->num_rows();
		if($count){
			return true;
		}
		return false;
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
	
	/*function getPengajuan($no_pengajuan){
		$this->db->select("no_pengajuan,date_format(tgl_pengajuan,'%d-%m-%Y') as tgl_pengajuan,keterangan",FALSE);
		if(!empty($no_pengajuan))$this->db->like('no_pengajuan',$no_pengajuan,'both');

		$this->db->join('apt_pengajuan_detail','apt_pengajuan_detail.no_pengajuan=apt_pengajuan.no_pengajuan');
		//$this->db->join('apt_supplier','apt_pemesanan.kd_supplier=apt_supplier.kd_supplier');
		
		$query=$this->db->get("apt_pengajuan");
		return $query->row_array();
	}*/
	
	function getPengajuan($no_pengajuan){
		$query=$this->db->query("select no_pengajuan,date_format(tgl_pengajuan,'%Y-%m-%d') as tgl_pengajuan,date_format(tgl_pengajuan,'%d-%m-%Y') as tgl_pengajuan1,date_format(tgl_pengajuan,'%H:%i:%s') as jam_pengajuan,keterangan,status_approve
								from apt_pengajuan where no_pengajuan='$no_pengajuan'");
		return $query->row_array(); 
	}
	
	function ambilApprover(){
		$query=$this->db->query("select pegawai.nama_pegawai,'-' as status,approval.kd_app,approval.urut,0 as is_app from user,pegawai,approval where user.id_pegawai=pegawai.id_pegawai 
								and approval.id_user=user.id_user order by approval.urut");
		return $query->result_array(); 
	}
	
	function tampilApprover($no_pengajuan){
		$query=$this->db->query("select pegawai.nama_pegawai,'-' as status,approval.kd_app,approval.urut,apt_app_pengajuan.is_app from user,pegawai,approval,
								apt_pengajuan,apt_app_pengajuan where user.id_pegawai=pegawai.id_pegawai and approval.id_user=user.id_user and 
								apt_app_pengajuan.no_pengajuan=apt_pengajuan.no_pengajuan and apt_pengajuan.no_pengajuan='$no_pengajuan' 
								and apt_app_pengajuan.kd_app=approval.kd_app order by approval.urut");
		return $query->result_array();
	}
	
	function cek($number){
		$this->db->where('no_pengajuan',$number);
		$query=$this->db->get('apt_pengajuan');
		$count=$query->num_rows();
		if($count){
			return true;
		}
		return false;
	}
	
	function ambilApp(){
		$id_user=$this->session->userdata('id_user'); 
		$query=$this->db->query("select kd_app from approval where id_user='$id_user'");
		$kd_applogin=$query->row_array();
		if(empty($kd_applogin))return 0;
		return $kd_applogin['kd_app'];
	}
	
	function statusisaplogin($no_pengajuan,$kd_applogin){
		$query=$this->db->query("select is_app from apt_app_pengajuan where kd_app='$kd_applogin' and no_pengajuan='$no_pengajuan'");
		$isapp=$query->row_array();
		return $isapp['is_app'];
	}
	
	function urutapprover($kd_applogin){
		$query=$this->db->query("select urut from approval where kd_app='$kd_applogin'");
		$urutapp=$query->row_array();
		return $urutapp['urut'];
	}
	
	function urutapprover1($urutapp,$no_pengajuan){
		//$a=$urutapp-1;
		/*$query=$this->db->query("select app_pemesanan.is_app from app_pemesanan,approval where approval.urut<$urutapp and 
								app_pemesanan.no_pemesanan='$no_pemesanan' and app_pemesanan.kd_app=approval.kd_app");*/
		$query=$this->db->query("select apt_app_pengajuan.is_app from apt_app_pengajuan,approval where approval.urut<$urutapp and 
									apt_app_pengajuan.no_pengajuan='$no_pengajuan' and apt_app_pengajuan.kd_app=approval.kd_app
									order by approval.urut desc limit 1");
		$urutapp1=$query->row_array();
		return $urutapp1['is_app'];
	}
	
	function pegawai($urutapp,$no_pengajuan){
		$a=$urutapp-1;
		/*$query=$this->db->query("select pegawai.nama_pegawai from app_pemesanan,approval,pegawai,user where approval.urut='$a' and 
								app_pemesanan.no_pemesanan='$no_pemesanan' and app_pemesanan.kd_app=approval.kd_app and pegawai.id_pegawai=user.id_pegawai and
								approval.id_user=user.id_user");*/
		$query=$this->db->query("select pegawai.nama_pegawai from apt_app_pengajuan,approval,pegawai,user where approval.urut<$urutapp and 
								apt_app_pengajuan.no_pengajuan='$no_pengajuan' and apt_app_pengajuan.kd_app=approval.kd_app and pegawai.id_pegawai=user.id_pegawai and
								approval.id_user=user.id_user order by approval.urut desc limit 1");
		$namapegawai=$query->row_array();
		return $namapegawai['nama_pegawai'];
	}
	
	function countApprover($number){
		$this->db->select('count(kd_app) as count');
		$this->db->where('no_pengajuan',$number);
		$query=$this->db->get('apt_app_pengajuan');
		$count=$query->row_array();
		return $count['count'];
	}
	
	function countIsApp($no_pengajuan){
		$query=$this->db->query("select count(kd_app) as countisap from apt_app_pengajuan where no_pengajuan='$no_pengajuan' and is_app='1'");
		$countisap=$query->row_array();
		return $countisap['countisap'];
	}
	
	
}
	
?>