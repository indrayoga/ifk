<?



class Mgrouping extends CI_Model {

	function __construct() {
		
		parent::__construct();
	}

	function ambilDataGrouping($no_grouping,$periodeawal,$periodeakhir){ 
		$this->db->select("no_grouping, date_format(tgl_grouping,'%d-%m-%Y') as tgl_grouping,keterangan,status_pesan",FALSE);
		if(!empty($no_grouping))$this->db->like('no_grouping',$no_grouping,'both');
		if(!empty($periodeawal))$this->db->where('date(tgl_grouping)>=',convertDate($periodeawal));
		if(!empty($periodeakhir))$this->db->where('date(tgl_grouping)<=',convertDate($periodeakhir));		
		
		//$this->db->join('apt_unit','apt_unit.kd_unit_apt=apt_distribusi.kd_unit_tujuan');
		$this->db->order_by('no_grouping','desc');
		
		$query=$this->db->get("apt_grouping_pengajuan");		
		return $query->result_array(); 
	}
	
	function isPosted($no_grouping)
	{
		$this->db->where('no_grouping',$no_grouping);
		$this->db->where('status_pesan',1);
		$query=$this->db->get('apt_grouping_pengajuan');
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
		$this->db->select('max(right(no_grouping,5)) as a',FALSE);
		$this->db->where('year(tgl_grouping)',$tahun);
		$this->db->where('month(tgl_grouping)',$bulan);
		$query = $this->db->get('apt_grouping_pengajuan');
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
		$this->db->where('no_grouping',$number);
		$query=$this->db->get('apt_grouping_pengajuan');
		$count=$query->num_rows();
		if($count){
			return true;
		}
		return false;
	}

	function ambilNama($value){
		$query=$this->db->query("select nama_obat from apt_obat where kd_obat='$value'");
		$nama=$query->row_array();
		return $nama['nama_obat'];
	}
	
	function getPengajuanDetil(){
		$query=$this->db->query("select apt_pengajuan_detail.kd_obat as kd_obat1,(select apt_pemesanan.kd_supplier from apt_pemesanan,apt_pemesanan_detail
								where apt_pemesanan.no_pemesanan=apt_pemesanan_detail.no_pemesanan and apt_pemesanan_detail.kd_obat=kd_obat1 
								order by apt_pemesanan.no_pemesanan desc limit 1) as kd_supplier,apt_obat.nama_obat,apt_satuan_kecil.satuan_kecil,apt_pengajuan_detail.qty_kcl,
								apt_pengajuan_detail.harga_beli,(apt_pengajuan_detail.qty_kcl*apt_pengajuan_detail.harga_beli) as total, 0 as jml_penerimaan
								from apt_pengajuan,apt_pengajuan_detail,apt_obat,apt_satuan_kecil where apt_pengajuan.no_pengajuan=apt_pengajuan_detail.no_pengajuan
								and apt_pengajuan_detail.kd_obat=apt_obat.kd_obat and apt_obat.kd_satuan_kecil=apt_satuan_kecil.kd_satuan_kecil and
								apt_pengajuan.is_grouping='0' and apt_pengajuan.status_approve='1'");
		return $query->result_array();
	}
	
	function getPengajuanDetil1($no_grouping){
		$query=$this->db->query("select apt_grouping_pengajuan_det.kd_supplier,apt_grouping_pengajuan_det.kd_obat as kd_obat1,apt_obat.nama_obat,apt_satuan_kecil.satuan_kecil,
								apt_grouping_pengajuan_det.qty_kcl,apt_grouping_pengajuan_det.harga_beli,apt_grouping_pengajuan.status_pesan,
								(apt_grouping_pengajuan_det.qty_kcl*apt_grouping_pengajuan_det.harga_beli) as total,apt_grouping_pengajuan_det.jml_penerimaan from apt_grouping_pengajuan,
								apt_grouping_pengajuan_det,apt_obat,apt_satuan_kecil where apt_grouping_pengajuan.no_grouping=apt_grouping_pengajuan_det.no_grouping
								and apt_grouping_pengajuan_det.kd_obat=apt_obat.kd_obat and apt_obat.kd_satuan_kecil=apt_satuan_kecil.kd_satuan_kecil and
								apt_grouping_pengajuan.no_grouping='$no_grouping'");
		return $query->result_array();
	}
	
	function getPengajuanDetil2($no_grouping){
		$query=$this->db->query("select apt_grouping_pengajuan_det.kd_supplier as kd_supplier1,(select nama from apt_supplier where kd_supplier=kd_supplier1) as nama,apt_grouping_pengajuan_det.kd_obat,apt_obat.nama_obat,apt_satuan_kecil.satuan_kecil,
								apt_grouping_pengajuan_det.qty_kcl,apt_grouping_pengajuan_det.harga_beli,
								(apt_grouping_pengajuan_det.qty_kcl*apt_grouping_pengajuan_det.harga_beli) as total from apt_grouping_pengajuan,
								apt_grouping_pengajuan_det,apt_obat,apt_satuan_kecil where apt_grouping_pengajuan.no_grouping=apt_grouping_pengajuan_det.no_grouping
								and apt_grouping_pengajuan_det.kd_obat=apt_obat.kd_obat and apt_obat.kd_satuan_kecil=apt_satuan_kecil.kd_satuan_kecil and
								apt_grouping_pengajuan.no_grouping='$no_grouping'");
		return $query->result_array();
	}
	
	function getAllSupplier($no_grouping){
		$query=$this->db->query("select distinct apt_grouping_pengajuan_det.kd_supplier from apt_grouping_pengajuan_det,apt_grouping_pengajuan where 
								apt_grouping_pengajuan_det.no_grouping=apt_grouping_pengajuan.no_grouping and apt_grouping_pengajuan.no_grouping='$no_grouping'");
		return $query->result_array(); 		
	}
	
	function autoNumberPemesanan($tahun,$bulan){ 
		$this->db->select('max(right(apt_pemesanan.no_pemesanan,3)) as a',false);
		$this->db->where('year(apt_pemesanan.tgl_pemesanan)',$tahun);
		$this->db->where('month(apt_pemesanan.tgl_pemesanan)',$bulan);
		$query=$this->db->get("apt_pemesanan");
		$item= $query->row_array();
		return $item['a'];		
	}
	
	function ambilObat($no_grouping,$kd_supp){
		$query=$this->db->query("select apt_grouping_pengajuan_det.kd_obat,apt_grouping_pengajuan_det.qty_kcl,apt_grouping_pengajuan_det.harga_beli 
								from apt_grouping_pengajuan,apt_grouping_pengajuan_det where apt_grouping_pengajuan_det.no_grouping=apt_grouping_pengajuan.no_grouping
								and apt_grouping_pengajuan_det.kd_supplier='$kd_supp' and apt_grouping_pengajuan.no_grouping='$no_grouping'");
		return $query->result_array();
	}
	
	function ItemGrouping($no_grouping){
		$query=$this->db->query("select no_grouping,date_format(tgl_grouping,'%Y-%m-%d') as tgl_grouping,date_format(tgl_grouping,'%H:%i:%s') as jam_grouping,
								date_format(tgl_grouping,'%d-%m-%Y') as tgl_grouping1,keterangan,status_pesan from apt_grouping_pengajuan where no_grouping='$no_grouping'");
		return $query->row_array();
	}
	
	function jamsekarang(){
		$query=$this->db->query("select date_format(sysdate(),'%H:%i:%s') as jam");
		$jambuat=$query->row_array();
		if(empty($jambuat)) return '00:00:00';
		return $jambuat['jam'];
	}
	
	function tglsekarang(){
		$query=$this->db->query("select date_format(sysdate(),'%d-%m-%Y') as tgl");
		$tglbuat=$query->row_array();
		if(empty($tglbuat)) return '00-00-0000';
		return $tglbuat['tgl'];
	}
}
	
?>