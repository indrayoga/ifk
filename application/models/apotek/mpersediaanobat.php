<?



class Mpersediaanobat extends CI_Model {

	function __construct() {
		
		parent::__construct();
	}
	
	/*function ambilDataObat($kd_obat,$nama_obat,$kd_sub_jenis){
		if(!empty($kd_obat)) $this->db->like('apt_obat.kd_obat',$kd_obat);
		if(!empty($nama_obat)) $this->db->like('apt_obat.nama_obat',$nama_obat);
		if(!empty($kd_sub_jenis)) $this->db->like('apt_sub_jenis.kd_sub_jenis',$kd_sub_jenis);
		
		$this->db->join('apt_jenis_obat','apt_jenis_obat.kd_jenis_obat=apt_obat.kd_jenis_obat','left');
		$this->db->join('apt_sub_jenis','apt_sub_jenis.kd_sub_jenis=apt_obat.kd_sub_jenis','left');
		$this->db->join('apt_golongan','apt_golongan.kd_golongan=apt_obat.kd_golongan','left');
		
		$this->db->order_by('apt_obat.kd_obat','asc');
		$query=$this->db->get('apt_obat');
		/*$query=$this->db->query("select apt_obat.kd_obat,apt_obat.nama_obat,apt_jenis_obat.jenis_obat,apt_sub_jenis.sub_jenis,apt_golongan.golongan from apt_obat,apt_sub_jenis,
								apt_golongan,apt_jenis_obat where apt_obat.kd_sub_jenis=apt_sub_jenis.kd_sub_jenis and apt_obat.kd_jenis_obat=apt_jenis_obat.kd_jenis_obat and
								apt_obat.kd_golongan=apt_golongan.kd_golongan and apt_obat.kd_obat like '%$kd_obat%' and apt_obat.nama_obat like '%$nama_obat%' 
								and apt_sub_jenis.kd_sub_jenis like '$kd_sub_jenis' order by apt_obat.kd_obat");*/
		/*return $query->result_array(); 			
	}*/
	
	function ambilDataObat($nama_obat,$kd_satuan_kecil){
		if($kd_satuan_kecil==''){$a1="";}
		else{$a1="and apt_obat.kd_satuan_kecil='$kd_satuan_kecil'";} $a=$a1;
		$query=$this->db->query("select apt_obat.kd_obat,apt_obat.nama_obat,apt_satuan_kecil.satuan_kecil from apt_obat,apt_satuan_kecil
								where apt_obat.kd_satuan_kecil=apt_satuan_kecil.kd_satuan_kecil and apt_obat.nama_obat like '%$nama_obat%' $a");
		return $query->result_array(); 
	}
	
	function autoNumber(){
		$this->db->select('max(right(kd_obat,8)) as a',FALSE);
		$query = $this->db->get('apt_obat');
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

	function ambilItemData($table,$condition=""){
		if(!empty($condition)){
			$this->db->where($condition,null,false);
		}
		$query= $this->db->get($table);
		return $query->row_array();
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

	function isNumberExist($number){
		$this->db->where('kd_obat',$number);
		$query=$this->db->get('apt_obat');
		$count=$query->num_rows();
		if($count){
			return true;
		}
		return false;
	}
	
	function isParent($tabelrelasi,$where,$id)
	{
		$this->db->where($where,$id);
		$query=$this->db->get($tabelrelasi);
		$item=$query->num_rows();
		if($item)return true;
		return false;
	}
	
	function muncultanggal(){
		$query=$this->db->query("select date_format(sysdate(),'%Y-%m-%d') as tanggal");
		$tanggal=$query->row_array();
		return $tanggal['tanggal'];
	}
	
	function isExist($tabel,$where,$id)
	{
		$this->db->where($where,$id);
		$query=$this->db->get($tabel);
		$item=$query->num_rows();
		if($item)return true;
		return false;
	}
	
	function ambilexpire($kd_obat){
		$query=$this->db->query("select tgl_expire from apt_stok_unit where kd_unit_apt='U01' and kd_obat='$kd_obat'");
		$tgl=$query->row_array();
		if(empty($tgl)) return '0000-00-00';
		return $tgl['tgl_expire'];
	}
	
	function ambilStok($kd_obat){
		$kd_unit_apt=$this->session->userdata('kd_unit_apt');
		$query=$this->db->query("select sum(jml_stok) as jml_stok from apt_stok_unit where kd_unit_apt='$kd_unit_apt' and kd_obat='$kd_obat'");
		$stok=$query->row_array();
		if(empty($stok)) return 0;
		return $stok['jml_stok'];
	}
	
	function cekObat($kd_obat,$kd_unit_apt){
		$this->db->where('kd_obat',$kd_obat);
		$this->db->where('kd_unit_apt',$kd_unit_apt);
		$query=$this->db->get('apt_setting_obat');
		$count=$query->num_rows();
		if($count){
			return true;
		}
		return false;
	}
	
	function ambilNamaUnit($kd_unit_apt){
		$kd_unit_apt=$this->session->userdata('kd_unit_apt');
		$query=$this->db->query("select nama_unit_apt from apt_unit where kd_unit_apt='$kd_unit_apt'");
		$unit=$query->row_array();
		if(empty($unit)) return 0;
		return $unit['nama_unit_apt'];
	}
	
	function ambilPersediaan($nama_obat,$stok,$isistok,$kd_unit){
		//$kd_unit_apt=$this->session->userdata('kd_unit_apt');
		
		$stok1="";
		if($stok==1){$stok1=">=";}
		if($stok==2){$stok1=">";}
		if($stok==3){$stok1="<=";}
		if($stok==4){$stok1="<";}
		if($stok==5){$stok1="=";}
		
		if($isistok=='' or $isistok=='null'){$isistok1=0;}
		else{$isistok1=$isistok;}
		if(!empty($kd_unit))$unit=' and apt_stok_unit.kd_unit_apt="'.$kd_unit.'" '; else $unit="";
		$query=$this->db->query("select apt_stok_unit.kd_obat as kd_obat1,apt_obat.nama_obat,apt_satuan_kecil.satuan_kecil,apt_stok_unit.harga_pokok,
								sum(apt_stok_unit.jml_stok) as jml_stok,(select min_stok from apt_setting_obat where kd_obat=kd_obat1 $unit limit 1) as min_stok, 
								apt_obat.harga_dasar from apt_obat,apt_satuan_kecil,apt_stok_unit where apt_obat.kd_satuan_kecil=apt_satuan_kecil.kd_satuan_kecil
								and apt_stok_unit.kd_obat=apt_obat.kd_obat $unit and apt_stok_unit.jml_stok $stok1 $isistok1
								and apt_obat.nama_obat like '%$nama_obat%' group by apt_obat.kd_obat order by apt_obat.nama_obat");
		return $query->result_array(); 
	}

	function ambilMinstok($kd_obat){
		$kd_unit_apt=$this->session->userdata('kd_unit_apt');
		$query=$this->db->query("select min_stok from apt_setting_obat where kd_unit_apt='$kd_unit_apt' and kd_obat='$kd_obat'");
		$minstok=$query->row_array();
		if(empty($minstok)) return 0;
		return $minstok['min_stok'];
	}
	
	/*function ambilMinstok($kd_obat){
		$kd_unit_apt=$this->session->userdata('kd_unit_apt');
		$query=$this->db->query("select min_stok from apt_setting_obat where kd_unit_apt='$kd_unit_apt' and kd_obat='$kd_obat'");
		$minstok=$query->row_array();
		if(empty($minstok)) return 0;
		return $minstok['min_stok'];
	}*/
	
	function ambilexpireobat($kd_obat){
		$kd_unit_apt=$this->session->userdata('kd_unit_apt');
		$query=$this->db->query("select max(tgl_expire) as tgl_expire,kd_obat from apt_stok_unit where kd_obat='$kd_obat' and kd_unit_apt='$kd_unit_apt'");
		$tglexpire=$query->row_array();
		if(empty($tglexpire)) return '0000-00-00';
		return $tglexpire['tgl_expire'];
	}
	
	function autoNumberPengajuan($tahun,$bulan){ 
		$this->db->select('max(right(apt_pengajuan.no_pengajuan,3)) as a',false);
		$this->db->where('year(apt_pengajuan.tgl_pengajuan)',$tahun);
		$this->db->where('month(apt_pengajuan.tgl_pengajuan)',$bulan);
		$query=$this->db->get("apt_pengajuan");
		$item= $query->row_array();
		return $item['a'];
	}
	
	function autoNumberPermintaan($tahun,$bulan){ 
		$this->db->select('max(right(apt_permintaan_obat.no_permintaan,3)) as a',false);
		$this->db->where('year(apt_permintaan_obat.tgl_permintaan)',$tahun);
		$this->db->where('month(apt_permintaan_obat.tgl_permintaan)',$bulan);
		$query=$this->db->get("apt_permintaan_obat");
		$item= $query->row_array();
		return $item['a'];
		
	}
	
	/*function autoNumberPermintaan($tahun,$bulan){ 
		$this->db->select('max(right(apt_permintaan_obat.no_permintaan,3)) as a',false);
		$this->db->where('year(apt_permintaan_obat.tgl_permintaan)',$tahun);
		$this->db->where('month(apt_permintaan_obat.tgl_permintaan)',$bulan);
		$query=$this->db->get("apt_permintaan_obat");
		$item= $query->row_array();
		return $item['a'];
		
	}*/
	
	function ambildetilobat($kd_obat){
		$kd_unit_apt=$this->session->userdata('kd_unit_apt');
		$query=$this->db->query("select (select if( count(kd_obat)>0, max_stok, 0 ) from apt_setting_obat where kd_obat='$kd_obat' and kd_unit_apt='$kd_unit_apt') as max_stok,
								harga_beli,harga_dasar from apt_obat where kd_obat='$kd_obat'");
		return $query->row_array(); 
	}
	
	function ambilApprover(){
		$query=$this->db->query("select pegawai.nama_pegawai,'-' as status,approval.kd_app,approval.urut,0 as is_app from user,pegawai,approval where user.id_pegawai=pegawai.id_pegawai 
								and approval.id_user=user.id_user order by approval.urut");
		return $query->result_array(); 
	}
	
	function sisdet(){
		$query=$this->db->query("select date_format(sysdate(),'%H:%i:%s') as jam");
		$jam=$query->row_array();
		if(empty($jam)) return '00:00:00';
		return $jam['jam'];
	}
	
	function autonumbersubmit(){
		$query=$this->db->query("select max(no_submit) as a from apt_submit");
		$kode=$query->row_array();
		if(empty($kode)) return 0;
		return $kode['a'];
	}
	
	function autonumbersubmit1(){
		$query=$this->db->query("select max(no_submit) as a from apt_submit_permintaan");
		$kode=$query->row_array();
		if(empty($kode)) return 0;
		return $kode['a'];
	}
	
	function ambilItemDataSubmit($no_submit){
		$query=$this->db->query("select no_submit,date_format(tgl_submit,'%Y-%m-%d') as tgl_submit,date_format(tgl_submit,'%H:%i:%s') as jam_submit,keterangan 
								from apt_submit where no_submit='$no_submit'");
		return $query->row_array();
	}
	
	function ambilItemDataSubmitPermintaan($no_submit){
		$query=$this->db->query("select no_submit,date_format(tgl_submit,'%Y-%m-%d') as tgl_submit,date_format(tgl_submit,'%H:%i:%s') as jam_submit,keterangan 
								from apt_submit_permintaan where no_submit='$no_submit'");
		return $query->row_array();
	}
	
	function getAllDetailSubmit($no_submit){ 
		$query=$this->db->query("select apt_submit_detail.kd_obat,apt_obat.nama_obat,apt_satuan_kecil.satuan_kecil,apt_obat.pembanding,
								apt_submit_detail.qty_kcl,apt_submit_detail.qty_kcl,apt_submit_detail.harga_beli,
								(apt_submit_detail.qty_kcl*apt_submit_detail.harga_beli) as jumlah
								from apt_submit,apt_submit_detail,apt_obat,apt_satuan_kecil where apt_submit.no_submit=apt_submit_detail.no_submit
								and apt_submit_detail.kd_obat=apt_obat.kd_obat and apt_obat.kd_satuan_kecil=apt_satuan_kecil.kd_satuan_kecil and 
								apt_submit.no_submit='$no_submit'"); 
		return $query->result_array(); 		
	}
	
	function getAllDetailSubmitPermintaan($no_submit){ 
		$query=$this->db->query("select apt_submit_permintaan_detail.kd_obat,apt_obat.nama_obat,apt_satuan_kecil.satuan_kecil,apt_submit_permintaan_detail.jml_req
								from apt_submit_permintaan,apt_submit_permintaan_detail,apt_obat,apt_satuan_kecil where apt_submit_permintaan_detail.no_submit=apt_submit_permintaan.no_submit
								and apt_submit_permintaan_detail.kd_obat=apt_obat.kd_obat and apt_obat.kd_satuan_kecil=apt_satuan_kecil.kd_satuan_kecil and 
								apt_submit_permintaan.no_submit='$no_submit'"); 
		return $query->result_array(); 		
	}
	
}
	
?>