<?



class Mpemesananapt extends CI_Model {

	function __construct() {
		
		parent::__construct();
	}

	function ambilDataPemesanan($no_pemesanan,$periodeawal,$periodeakhir){
		$this->db->select("apt_pemesanan.no_pemesanan,apt_supplier.nama,date_format(apt_pemesanan.tgl_pemesanan,'%d-%m-%Y %H:%i:%s') as tgl_pemesanan,
						apt_pemesanan.keterangan,apt_pemesanan.tgl_tempo",FALSE);
		if(!empty($no_pemesanan))$this->db->like('apt_pemesanan.no_pemesanan',$no_pemesanan,'both');
		if(!empty($periodeawal))$this->db->where('date(apt_pemesanan.tgl_pemesanan)>=',convertDate($periodeawal));
		if(!empty($periodeakhir))$this->db->where('date(apt_pemesanan.tgl_pemesanan)<=',convertDate($periodeakhir));
		
		$this->db->join('apt_supplier','apt_supplier.kd_supplier=apt_pemesanan.kd_supplier','left');
		$this->db->order_by('apt_pemesanan.no_pemesanan','desc');
		
		$query=$this->db->get("apt_pemesanan");		
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
	
	function isPosted($nopemesanan)
	{
		$this->db->where('no_pemesanan',$nopemesanan);
		//$this->db->where('posting',1);
		$query=$this->db->get('apt_pemesanan');
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
		$query=$this->db->query("select kd_supplier,nama,alamat from apt_supplier where kd_supplier like '%$kd_supplier%' and is_aktif='1'");
		return $query->result_array();
	}
	
	function ambilData4($nama){
		$query=$this->db->query("select kd_supplier,nama,alamat from apt_supplier where nama like '%$nama%' and is_aktif='1'");
		return $query->result_array();
	}
	
	function ambilHarga(){
		//$query=$this->db->query("select format(SUM(harga_beli),0) as hr from apt_penerimaan_detail");
		//return $query->row_array();
		$this->db->select('SUM(harga_beli) as sum');
		$query = $this->db->get('apt_penerimaan_detail');
		$sum=$query->row_array();
		return $sum['sum'];
	}
	
	
	function autoNumber($tahun,$bulan){ 
		/*$this->db->select('max(right(no_penerimaan,12)) as a',FALSE);
		$query = $this->db->get('apt_penerimaan');
		$kode=$query->row_array();
		return $kode['a'];*/
		$this->db->select('max(right(apt_pemesanan.no_pemesanan,3)) as a',false);
		$this->db->where('year(apt_pemesanan.tgl_pemesanan)',$tahun);
		$this->db->where('month(apt_pemesanan.tgl_pemesanan)',$bulan);
		//$this->db->join('apt_penerimaan_detail','apt_penerimaan_detail.no_penerimaan=apt_penerimaan.no_penerimaan');
		//$this->db->where('a.type',1);
		$query=$this->db->get("apt_pemesanan");
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

	function ambilItemData($no_pemesanan){
		$query=$this->db->query("select apt_pemesanan.no_pemesanan,date_format(apt_pemesanan.tgl_pemesanan,'%Y-%m-%d') as tgl_pemesanan,apt_pemesanan.tgl_tempo,apt_pemesanan.kd_supplier,apt_supplier.nama,apt_pemesanan.keterangan,
								date_format(apt_pemesanan.tgl_pemesanan,'%H:%i:%s') as jam_pemesanan from apt_pemesanan,apt_supplier where apt_pemesanan.kd_supplier=apt_supplier.kd_supplier and apt_pemesanan.no_pemesanan='$no_pemesanan'");
		return $query->row_array();
	}
	
	/*function ambilItemData($table,$condition=""){
		
		if(!empty($condition)){
			$this->db->where($condition,null,false);
		}
		$query= $this->db->get($table);
		return $query->row_array();
	}*/
	
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
	
	function getAllDetailPemesanan($no_pemesanan){ 
		$query=$this->db->query("select apt_pemesanan_detail.kd_obat,apt_obat.nama_obat,apt_satuan_kecil.satuan_kecil,apt_obat.pembanding,
								apt_pemesanan_detail.qty_box,apt_pemesanan_detail.qty_kcl,apt_pemesanan_detail.harga_beli,
								apt_pemesanan_detail.diskon,apt_pemesanan_detail.ppn,
								(((apt_pemesanan_detail.qty_kcl*apt_pemesanan_detail.harga_beli)-((apt_pemesanan_detail.diskon/100)*apt_pemesanan_detail.harga_beli*apt_pemesanan_detail.qty_kcl))+(((apt_pemesanan_detail.qty_kcl*apt_pemesanan_detail.harga_beli)-((apt_pemesanan_detail.diskon/100)*apt_pemesanan_detail.harga_beli*apt_pemesanan_detail.qty_kcl))*(apt_pemesanan_detail.ppn/100))) as jumlah
								from apt_pemesanan,apt_pemesanan_detail,apt_obat,apt_satuan_kecil where apt_pemesanan.no_pemesanan=apt_pemesanan_detail.no_pemesanan
								and apt_pemesanan_detail.kd_obat=apt_obat.kd_obat and apt_obat.kd_satuan_kecil=apt_satuan_kecil.kd_satuan_kecil and 
								apt_pemesanan.no_pemesanan='$no_pemesanan'"); 
		return $query->result_array(); 		
	}

	function isAppExist($number,$number1){
		$this->db->where('no_pemesanan',$number);
		$this->db->where('kd_app',$number1);
		$query=$this->db->get('app_pemesanan');
		$count=$query->num_rows();
		if($count){
			return true;
		}
		return false;
	}
	
	function isNumberExist($number){
		$this->db->where('no_pemesanan',$number);
		$query=$this->db->get('apt_pemesanan');
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
	
	function getPemesanan($no_pemesanan){
		$this->db->select("apt_pemesanan.no_pemesanan,date_format(apt_pemesanan.tgl_pemesanan,'%d-%m-%Y') as tgl_pemesanan,date_format(apt_pemesanan.tgl_tempo,'%d-%m-%Y') as tgl_tempo,apt_pemesanan.kd_supplier,apt_supplier.nama,apt_pemesanan.keterangan",FALSE);
		if(!empty($no_pemesanan))$this->db->like('apt_pemesanan.no_pemesanan',$no_pemesanan,'both');

		$this->db->join('apt_pemesanan_detail','apt_pemesanan_detail.no_pemesanan=apt_pemesanan.no_pemesanan');
		$this->db->join('apt_supplier','apt_pemesanan.kd_supplier=apt_supplier.kd_supplier');
		
		$query=$this->db->get("apt_pemesanan");
		return $query->row_array();
	}
	
	function ambilApprover(){
		$query=$this->db->query("select pegawai.nama_pegawai,'-' as status,approval.kd_app,approval.urut,0 as is_app from user,pegawai,approval where user.id_pegawai=pegawai.id_pegawai 
								and approval.id_user=user.id_user order by approval.urut");
		return $query->result_array(); 
	}
	
	function tampilApprover($no_pemesanan){
		$query=$this->db->query("select pegawai.nama_pegawai,'-' as status,approval.kd_app,approval.urut,app_pemesanan.is_app from user,pegawai,approval,
								apt_pemesanan,app_pemesanan where user.id_pegawai=pegawai.id_pegawai and approval.id_user=user.id_user and 
								app_pemesanan.no_pemesanan=apt_pemesanan.no_pemesanan and apt_pemesanan.no_pemesanan='$no_pemesanan' 
								and app_pemesanan.kd_app=approval.kd_app order by approval.urut");
		return $query->result_array();
	}
	
	function cek($number){
		$this->db->where('no_pemesanan',$number);
		$query=$this->db->get('apt_pemesanan');
		$count=$query->num_rows();
		if($count){
			return true;
		}
		return false;
	}
	
	function ambilApp(){
		$id_user=$this->session->userdata('id_user'); 
		$query=$this->db->query("select kd_app from approval where id_user='$id_user'");
		return $query->row_array();
	}
	
	function statusisaplogin($no_pemesanan,$kd_applogin){
		$query=$this->db->query("select is_app from app_pemesanan where kd_app='$kd_applogin' and no_pemesanan='$no_pemesanan'");
		$isapp=$query->row_array();
		return $isapp['is_app'];
	}
	
	function urutapprover($kd_applogin){
		$query=$this->db->query("select urut from approval where kd_app='$kd_applogin'");
		$urutapp=$query->row_array();
		return $urutapp['urut'];
	}
	
	function urutapprover1($urutapp,$no_pemesanan){
		//$a=$urutapp-1;
		/*$query=$this->db->query("select app_pemesanan.is_app from app_pemesanan,approval where approval.urut<$urutapp and 
								app_pemesanan.no_pemesanan='$no_pemesanan' and app_pemesanan.kd_app=approval.kd_app");*/
		$query=$this->db->query("select app_pemesanan.is_app from app_pemesanan,approval where approval.urut<$urutapp and 
									app_pemesanan.no_pemesanan='$no_pemesanan' and app_pemesanan.kd_app=approval.kd_app
									order by approval.urut desc limit 1");
		$urutapp1=$query->row_array();
		return $urutapp1['is_app'];
	}
	
	function pegawai($urutapp,$no_pemesanan){
		$a=$urutapp-1;
		/*$query=$this->db->query("select pegawai.nama_pegawai from app_pemesanan,approval,pegawai,user where approval.urut='$a' and 
								app_pemesanan.no_pemesanan='$no_pemesanan' and app_pemesanan.kd_app=approval.kd_app and pegawai.id_pegawai=user.id_pegawai and
								approval.id_user=user.id_user");*/
		$query=$this->db->query("select pegawai.nama_pegawai from app_pemesanan,approval,pegawai,user where approval.urut<$urutapp and 
								app_pemesanan.no_pemesanan='$no_pemesanan' and app_pemesanan.kd_app=approval.kd_app and pegawai.id_pegawai=user.id_pegawai and
								approval.id_user=user.id_user order by approval.urut desc limit 1");
		$namapegawai=$query->row_array();
		return $namapegawai['nama_pegawai'];
	}
	
	function countApprover($number){
		$this->db->select('count(kd_app) as count');
		$this->db->where('no_pemesanan',$number);
		$query=$this->db->get('app_pemesanan');
		$count=$query->row_array();
		return $count['count'];
	}
	
	function countIsApp($no_pemesanan){
		$query=$this->db->query("select count(kd_app) as countisap from app_pemesanan where no_pemesanan='$no_pemesanan' and is_app='1'");
		$countisap=$query->row_array();
		return $countisap['countisap'];
	}
}
	
?>