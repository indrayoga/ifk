<?



class Mpermintaan extends CI_Model {

	function __construct() {
		
		parent::__construct();
	}

	function ambilDataPermintaan($no_permintaan,$periodeawal,$periodeakhir){
		$kd_unit_apt=$this->session->userdata('kd_unit_apt');
		$kd_unit_apt_gudang=$this->session->userdata('kd_unit_apt_gudang');
		if(!empty($no_permintaan))$this->db->like('no_permintaan',$no_permintaan,'both');
		if(!empty($periodeawal))$this->db->where('date(tgl_permintaan)>=',convertDate($periodeawal));
		if(!empty($periodeakhir))$this->db->where('date(tgl_permintaan)<=',convertDate($periodeakhir));
		
		if($kd_unit_apt!=$kd_unit_apt_gudang){
			$this->db->where('kd_unit_apt',$kd_unit_apt);
		}
		$this->db->join('apt_unit b','a.kd_unit_apt=b.kd_unit_apt');
		$this->db->order_by('no_permintaan','desc');
		
		$query=$this->db->get("apt_permintaan_obat a");		
		return $query->result_array(); 
	}
	
	function isPosted($nopermintaan)
	{
		$this->db->where('no_permintaan',$nopermintaan);
		$this->db->where('status_approve',1);
		$query=$this->db->get('apt_permintaan_obat');
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
	
	function autoNumber($tahun,$bulan){ 
		$this->db->select('max(right(apt_permintaan_obat.no_permintaan,3)) as a',false);
		$this->db->where('year(apt_permintaan_obat.tgl_permintaan)',$tahun);
		$this->db->where('month(apt_permintaan_obat.tgl_permintaan)',$bulan);
		$query=$this->db->get("apt_permintaan_obat");
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
	
	function getAllDetailPermintaan($no_permintaan){ 
		$query=$this->db->query("select apt_permintaan_obat_det.kd_obat,apt_obat.nama_obat,apt_satuan_kecil.satuan_kecil,apt_permintaan_obat_det.jml_req,apt_permintaan_obat_det.tgl_expire,date_format(apt_permintaan_obat_det.tgl_expire,'%d-%m-%Y') as tgl_expire1
								from apt_permintaan_obat_det,apt_permintaan_obat,apt_obat,apt_satuan_kecil where apt_permintaan_obat_det.no_permintaan=apt_permintaan_obat.no_permintaan
								and apt_permintaan_obat_det.kd_obat=apt_obat.kd_obat and apt_obat.kd_satuan_kecil=apt_satuan_kecil.kd_satuan_kecil and 
								apt_permintaan_obat.no_permintaan='$no_permintaan'"); 
		return $query->result_array(); 		
	}

	function isAppExist($number,$number1){
		$this->db->where('no_permintaan',$number);
		$this->db->where('kd_app',$number1);
		$query=$this->db->get('apt_app_permintaan');
		$count=$query->num_rows();
		if($count){
			return true;
		}
		return false;
	}
	
	function isNumberExist($number){
		$this->db->where('no_permintaan',$number);
		$query=$this->db->get('apt_permintaan_obat');
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
	
	function ambilApprover(){
		$query=$this->db->query("select pegawai.nama_pegawai,'-' as status,approval.kd_app,approval.urut,0 as is_app from user,pegawai,approval where user.id_pegawai=pegawai.id_pegawai 
								and approval.id_user=user.id_user order by approval.urut");
		return $query->result_array(); 
	}
	
	function tampilApprover($no_permintaan){
		$query=$this->db->query("select pegawai.nama_pegawai,'-' as status,approval.kd_app,approval.urut,apt_app_permintaan.is_app from user,pegawai,approval,
								apt_permintaan_obat,apt_app_permintaan where user.id_pegawai=pegawai.id_pegawai and approval.id_user=user.id_user and 
								apt_app_permintaan.no_permintaan=apt_permintaan_obat.no_permintaan and apt_permintaan_obat.no_permintaan='$no_permintaan' 
								and apt_app_permintaan.kd_app=approval.kd_app order by approval.urut");
		return $query->result_array();
	}
	
	function cek($number){
		$this->db->where('no_permintaan',$number);
		$query=$this->db->get('apt_permintaan_obat');
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
	
	function statusisaplogin($no_permintaan,$kd_applogin){
		$query=$this->db->query("select is_app from apt_app_permintaan where kd_app='$kd_applogin' and no_permintaan='$no_permintaan'");
		$isapp=$query->row_array();
		return $isapp['is_app'];
	}
	
	function urutapprover($kd_applogin){
		$query=$this->db->query("select urut from approval where kd_app='$kd_applogin'");
		$urutapp=$query->row_array();
		return $urutapp['urut'];
	}
	
	function urutapprover1($urutapp,$no_permintaan){
		//$a=$urutapp-1;
		/*$query=$this->db->query("select app_pemesanan.is_app from app_pemesanan,approval where approval.urut<$urutapp and 
								app_pemesanan.no_pemesanan='$no_pemesanan' and app_pemesanan.kd_app=approval.kd_app");*/
		$query=$this->db->query("select apt_app_permintaan.is_app from apt_app_permintaan,approval where approval.urut<$urutapp and 
									apt_app_permintaan.no_permintaan='$no_permintaan' and apt_app_permintaan.kd_app=approval.kd_app
									order by approval.urut desc limit 1");
		$urutapp1=$query->row_array();
		return $urutapp1['is_app'];
	}
	
	function pegawai($urutapp,$no_permintaan){
		$a=$urutapp-1;
		/*$query=$this->db->query("select pegawai.nama_pegawai from app_pemesanan,approval,pegawai,user where approval.urut='$a' and 
								app_pemesanan.no_pemesanan='$no_pemesanan' and app_pemesanan.kd_app=approval.kd_app and pegawai.id_pegawai=user.id_pegawai and
								approval.id_user=user.id_user");*/
		$query=$this->db->query("select pegawai.nama_pegawai from apt_app_permintaan,approval,pegawai,user where approval.urut<$urutapp and 
								apt_app_permintaan.no_permintaan='$no_permintaan' and apt_app_permintaan.kd_app=approval.kd_app and pegawai.id_pegawai=user.id_pegawai and
								approval.id_user=user.id_user order by approval.urut desc limit 1");
		$namapegawai=$query->row_array();
		return $namapegawai['nama_pegawai'];
	}
	
	function countApprover($number){
		$this->db->select('count(kd_app) as count');
		$this->db->where('no_permintaan',$number);
		$query=$this->db->get('apt_app_permintaan');
		$count=$query->row_array();
		return $count['count'];
	}
	
	function countIsApp($no_permintaan){
		$query=$this->db->query("select count(kd_app) as countisap from apt_app_permintaan where no_permintaan='$no_permintaan' and is_app='1'");
		$countisap=$query->row_array();
		return $countisap['countisap'];
	}
	
	function ambilNamaUnit($kd_unit_apt){
		$kd_unit_apt=$this->session->userdata('kd_unit_apt');
		$query=$this->db->query("select nama_unit_apt from apt_unit where kd_unit_apt='$kd_unit_apt'");
		$unit=$query->row_array();
		if(empty($unit)) return 0;
		return $unit['nama_unit_apt'];
	}
	
	function ItemPermintaan($no_permintaan){
		$query=$this->db->query("select no_permintaan,a.kd_unit_apt,nama_unit_apt,date_format(tgl_permintaan,'%Y-%m-%d') as tgl_permintaan,date_format(tgl_permintaan,'%d-%m-%Y') as tgl_permintaan1,
								date_format(tgl_permintaan,'%H:%i:%s') as jam_permintaan,keterangan from apt_permintaan_obat a,apt_unit b where 
								a.kd_unit_apt=b.kd_unit_apt and no_permintaan='$no_permintaan'");
		return $query->row_array();
	}
	
}
	
?>