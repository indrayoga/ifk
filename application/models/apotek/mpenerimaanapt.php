<?



class Mpenerimaanapt extends CI_Model {

	function __construct() {
		
		parent::__construct();
	}

	/*function ambilDataPenerimaan($nama){ 
		$this->db->select("apt_penerimaan.no_penerimaan, apt_supplier.nama, date_format(apt_penerimaan.tgl_penerimaan,'%d-%m-%Y') as tglpenerimaan, apt_penerimaan.keterangan, apt_penerimaan.lunas",FALSE);
		$this->db->join('apt_supplier','apt_supplier.kd_supplier=apt_penerimaan.kd_supplier');
		if(!empty($nama)) $this->db->like('apt_supplier.nama',$nama);
			$this->db->order_by('apt_penerimaan.no_penerimaan','desc');
		$query=$this->db->get('apt_penerimaan');
		return $query->result_array(); 
	}*/
	function updateharga($kd_obat,$hargabeli,$kd_unit){
		$query=$this->db->query("select * from apt_margin_harga where kd_obat='".$kd_obat."' ");
		$harga=$query->row_array();
		$nilaimargin=($harga['margin']/100)*$hargabeli;
		$hargajual=$hargabeli+$nilaimargin;

		$this->db->query("update apt_margin_harga set harga='".$hargajual."' where kd_obat='".$kd_obat."' ");
	}
	
	function ambilDataPenerimaan($no_penerimaan,$kd_supplier,$periodeawal,$periodeakhir){ 
		if(!empty($no_penerimaan))$this->db->like('apt_penerimaan.no_penerimaan',$no_penerimaan,'both');
		if(!empty($kd_supplier))$this->db->where('apt_supplier.kd_supplier',$kd_supplier);
		if(!empty($periodeawal))$this->db->where('date(apt_penerimaan.tgl_penerimaan)>=',convertDate($periodeawal));
		if(!empty($periodeakhir))$this->db->where('date(apt_penerimaan.tgl_penerimaan)<=',convertDate($periodeakhir));
		$this->db->select('*,date_format(tgl_penerimaan,"%d-%m-%Y") as tgl_penerimaan',false);
		$this->db->join('apt_unit','apt_unit.kd_unit_apt=apt_penerimaan.kd_unit_apt');
		$this->db->join('apt_supplier','apt_supplier.kd_supplier=apt_penerimaan.kd_supplier','left');
		$this->db->order_by('apt_penerimaan.no_penerimaan','desc');
		
		$query=$this->db->get("apt_penerimaan");		
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
	
	/*function ambilStok($kd_unit_apt,$value,$tgl_expire){
		//$kd_unit_apt=$this->session->userdata('kd_unit_apt');
		$this->db->select('jml_stok',FALSE);
		if(!empty($kd_unit_apt)) $this->db->where('kd_unit_apt',$kd_unit_apt);
		if(!empty($value)) $this->db->where('kd_obat',$value);
		if(!empty($tgl_expire)) $this->db->where('tgl_expire',$tgl_expire);
		$query= $this->db->get("apt_stok_unit");
		$jml_stok=$query->row_array();
		return $jml_stok['jml_stok'];
	}*/
	
	function ambilStok($kd_unit_apt,$value,$tgl_expire,$kd_pabrik="",$batch="",$harga=""){
		$query=$this->db->query("select jml_stok from apt_stok_unit where kd_unit_apt='$kd_unit_apt' and kd_obat='$value' and tgl_expire='$tgl_expire' and kd_pabrik='$kd_pabrik' and batch='$batch' and harga_pokok='$harga' ");		
		$jml_stok=$query->row_array();
		if(empty($jml_stok)) return 0;
		return $jml_stok['jml_stok'];
	}
	
	function ambildistok($kd_unit_apt,$value,$tgl_expire,$kd_pabrik="",$batch=""){
		$query=$this->db->query("select harga_pokok from apt_stok_unit where kd_unit_apt='$kd_unit_apt' and kd_obat='$value' and tgl_expire='$tgl_expire' and kd_pabrik='$kd_pabrik' and batch='$batch' ");		
		$harga_pokok=$query->row_array();
		if(empty($harga_pokok)) return 0;
		return $harga_pokok['harga_pokok'];
	}
	
	function isPosted($nopenerimaan)
	{
		$this->db->where('no_penerimaan',$nopenerimaan);
		$this->db->where('posting',1);
		$query=$this->db->get('apt_penerimaan');
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
		/*$query=$this->db->query("select apt_obat.kd_obat,apt_obat.nama_obat,apt_satuan_kecil.satuan_kecil,apt_obat.pembanding, ifnull( harga_beli, 0 ) harga_beli from apt_obat LEFT JOIN (

SELECT kd_obat, round( harga_avg + ( harga_avg * ppn_item /100 ) ) AS harga_beli
FROM `apt_penerimaan_detail`
) AS b ON apt_obat.kd_obat = b.kd_obat,apt_satuan_kecil
								where apt_obat.kd_satuan_kecil=apt_satuan_kecil.kd_satuan_kecil and apt_obat.nama_obat like '%$nama_obat%' 
								order by apt_obat.nama_obat asc");*/
								
		/*$query=$this->db->query("SELECT apt_obat.kd_obat, apt_obat.nama_obat, apt_satuan_kecil.satuan_kecil, apt_obat.pembanding, ifnull( substring_index( apt_stok_unit.jml_stok, '.', 1 ) , 0 ) AS jml_stok, nama_unit_apt
									FROM apt_obat
									LEFT JOIN apt_satuan_kecil ON apt_obat.kd_satuan_kecil = apt_satuan_kecil.kd_satuan_kecil
									LEFT JOIN apt_stok_unit ON apt_obat.kd_obat = apt_stok_unit.kd_obat
									LEFT JOIN apt_unit ON apt_unit.kd_unit_apt = apt_stok_unit.kd_unit_apt
									WHERE (
									apt_unit.nama_unit_apt LIKE '%gudang farmasi%'
									OR apt_unit.nama_unit_apt IS NULL
									) 
								and apt_obat.nama_obat like '%$nama_obat%' order by apt_obat.kd_obat asc");*/
		$query=$this->db->query("SELECT distinct apt_obat.kd_obat, apt_obat.nama_obat, apt_satuan_kecil.satuan_kecil, apt_obat.pembanding, sum(ifnull( substring_index( apt_stok_unit.jml_stok, '.', 1 ) , 0 )) AS jml_stok, nama_unit_apt FROM apt_obat LEFT JOIN apt_satuan_kecil ON apt_obat.kd_satuan_kecil = apt_satuan_kecil.kd_satuan_kecil LEFT JOIN apt_stok_unit ON apt_obat.kd_obat = apt_stok_unit.kd_obat
								LEFT JOIN apt_unit ON apt_unit.kd_unit_apt = apt_stok_unit.kd_unit_apt WHERE (apt_unit.nama_unit_apt LIKE '%gudang farmasi%'
								OR apt_unit.nama_unit_apt IS NULL) and apt_obat.nama_obat like '%$nama_obat%' group by apt_obat.kd_obat order by apt_obat.kd_obat asc");
		
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
		$this->db->select('max(right(apt_penerimaan.no_penerimaan,3)) as a',false);
		$this->db->where('mid(apt_penerimaan.no_penerimaan,5,4)',$tahun);
		$this->db->where('mid(apt_penerimaan.no_penerimaan,10,2)',$bulan);
		//$this->db->join('apt_penerimaan_detail','apt_penerimaan_detail.no_penerimaan=apt_penerimaan.no_penerimaan');
		//$this->db->where('a.type',1);
		$query=$this->db->get("apt_penerimaan");
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

	function ambilItemData($no_penerimaan){
		
		$query=$this->db->query("select apt_penerimaan.kd_unit_apt,apt_penerimaan.no_penerimaan, apt_penerimaan.no_faktur as no_faktur1,apt_penerimaan.tgl_faktur,date_format(apt_penerimaan.tgl_penerimaan,'%Y-%m-%d') as tgl_penerimaan, apt_penerimaan.shift, apt_penerimaan.lunas, 
								date_format(apt_penerimaan.tgl_penerimaan,'%H:%i:%s') as jam_penerimaan,apt_penerimaan.posting, apt_penerimaan.tgl_tempo,apt_penerimaan.kd_supplier, apt_supplier.nama, apt_penerimaan.materai, 
								apt_penerimaan.keterangan, apt_penerimaan.jumlah, apt_penerimaan.discount,(select apf_number from acc_ap_faktur where reff=no_faktur1) as apf_number,apt_penerimaan.ppn from apt_penerimaan,apt_supplier 
								where apt_penerimaan.kd_supplier=apt_supplier.kd_supplier and apt_penerimaan.no_penerimaan='$no_penerimaan' ");
		return $query->row_array();
	}
	
	function ambilItemDataxx($table,$condition=""){
		
		if(!empty($condition)){
			$this->db->where($condition,null,false);
		}
		$query= $this->db->get($table);
		return $query->row_array();
	}
	
	function ambilKode($no_penerimaan){
		$this->db->select('kd_unit_apt',FALSE);
		if(!empty($no_penerimaan)) $this->db->where('no_penerimaan',$no_penerimaan);
		$query= $this->db->get("apt_penerimaan");
		$kd_unit_apt=$query->row_array();
		return $kd_unit_apt['kd_unit_apt'];
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

    function updatepemesanan($data,$id) {
	
    	$query=$this->db->query('update apt_pemesanan_detail set jml_penerimaan = jml_penerimaan +'.$data.' where '.$id);
	return true;
    }	

	function delete($table,$id) {
		$this->db->where($id,null,false);
		$this->db->delete($table);
		return true;
    }
	
    function sumberdana(){
    	$query= $this->db->get('apt_unit');
    	return $query->result_array();
    }
    
	function getAllDetailPenerimaan($no_penerimaan){
/*$query1=$this->db->query("select urut from apt_penerimaan_detail where no_penerimaan='$no_penerimaan'");
		$items=$query1->result_array();
		foreach($items as $itemurut){
			$urut=$itemurut['urut'];
			$query2=$this->db->query("select disc_prs from apt_penerimaan_detail where no_penerimaan='' and urut='$urut'");
			$disc=$query2->row_array();
			$disc_prs=$disc['disc_prs'];
			if(){}
		}*/
		$query=$this->db->query("select apt_penerimaan_detail.no_pemesanan,apt_penerimaan_detail.kd_obat,apt_penerimaan_detail.urut,apt_penerimaan_detail.no_penerimaan,apt_penerimaan_detail.kd_pabrik,apt_penerimaan_detail.kode_sas, apt_obat.nama_obat, apt_satuan_kecil.satuan_kecil, date_format(apt_penerimaan_detail.tgl_expire,'%d-%m-%Y') as tgl_expire,
				apt_penerimaan_detail.kd_unit_apt, apt_obat.pembanding, apt_penerimaan_detail.qty_box, apt_penerimaan_detail.qty_kcl, apt_penerimaan_detail.format,apt_penerimaan_detail.barcode,
				apt_penerimaan_detail.harga_beli, apt_penerimaan_detail.harga_avg as sum, apt_penerimaan_detail.disc_prs, apt_penerimaan_detail.harga_belidisc,(apt_penerimaan_detail.qty_kcl*apt_penerimaan_detail.harga_beli) as jum, 
				apt_penerimaan_detail.ppn_item,apt_penerimaan_detail.bonus,apt_penerimaan_detail.update,apt_penerimaan_detail.isidiskon,
				(((apt_penerimaan_detail.qty_kcl*apt_penerimaan_detail.harga_beli)-((apt_penerimaan_detail.disc_prs/100)*apt_penerimaan_detail.harga_beli*apt_penerimaan_detail.qty_kcl))+(((apt_penerimaan_detail.qty_kcl*apt_penerimaan_detail.harga_beli)-((apt_penerimaan_detail.disc_prs/100)*apt_penerimaan_detail.harga_beli*apt_penerimaan_detail.qty_kcl))*(ppn_item/100))) as total1,
				apt_penerimaan_detail.no_batch from apt_obat, apt_satuan_kecil, apt_penerimaan_detail, apt_penerimaan, apt_unit 
				where apt_obat.kd_satuan_kecil=apt_satuan_kecil.kd_satuan_kecil and apt_obat.kd_obat=apt_penerimaan_detail.kd_obat 
				and apt_penerimaan_detail.no_penerimaan=apt_penerimaan.no_penerimaan and apt_penerimaan_detail.kd_unit_apt=apt_unit.kd_unit_apt 
				and apt_penerimaan.kd_unit_apt=apt_unit.kd_unit_apt and apt_penerimaan.no_penerimaan='$no_penerimaan'");
		return $query->result_array(); 		
	}

	function isNumberExist($number){
		$this->db->where('no_penerimaan',$number);
		$query=$this->db->get('apt_penerimaan');
		$count=$query->num_rows();
		if($count){
			return true;
		}
		return false;
	}
	
	function cekStok($value,$kd_unit_apt,$tgl,$kd_pabrik="",$batch="",$harga=""){
		$this->db->where('kd_obat',$value);
		$this->db->where('kd_unit_apt',$kd_unit_apt);
		$this->db->where('kd_pabrik',$kd_pabrik);
		$this->db->where('batch',$batch);
		$this->db->where('tgl_expire',$tgl);
		$this->db->where('harga_pokok',$harga);
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
	
	function getPenerimaan($no_penerimaan){
		$this->db->select("apt_penerimaan.no_penerimaan,date_format(apt_penerimaan.tgl_penerimaan,'%d-%m-%Y') as tgl_penerimaan,apt_penerimaan.no_faktur,date_format(apt_penerimaan.tgl_faktur,'%d-%m-%Y') as tgl_faktur,
							apt_penerimaan.shift,apt_penerimaan.lunas,apt_penerimaan.posting,date_format(apt_penerimaan.tgl_tempo,'%d-%m-%Y') as tgl_tempo,
							apt_penerimaan.kd_supplier,apt_supplier.nama,apt_penerimaan.materai,apt_penerimaan.keterangan,apt_penerimaan.jumlah,apt_penerimaan.discount",FALSE);
		if(!empty($no_penerimaan))$this->db->like('apt_penerimaan.no_penerimaan',$no_penerimaan,'both');

		$this->db->join('apt_unit','apt_penerimaan.kd_unit_apt=apt_unit.kd_unit_apt');
		$this->db->join('apt_supplier','apt_penerimaan.kd_supplier=apt_supplier.kd_supplier');
		
		$query=$this->db->get("apt_penerimaan");
		return $query->row_array();
	}
	
	function datapesanan($kd_supplier,$no_pemesanan){
		/*$query=$this->db->query("select apt_pemesanan.no_pemesanan,date_format(apt_pemesanan.tgl_pemesanan,'%d-%m-%Y') as tgl_pemesanan,apt_supplier.nama from apt_pemesanan,apt_supplier where no_pemesanan not in(select no_pemesanan from apt_penerimaan_detail) and 
								apt_pemesanan.kd_supplier=apt_supplier.kd_supplier and apt_supplier.kd_supplier='$kd_supplier' and apt_pemesanan.no_pemesanan like '%$no_pemesanan%'");*/
		/*$query=$this->db->query("select apt_pemesanan.no_pemesanan,date_format(apt_pemesanan.tgl_pemesanan,'%d-%m-%Y') as tgl_pemesanan,apt_supplier.nama from 
								apt_pemesanan,apt_supplier where no_pemesanan not in(select no_pemesanan from apt_penerimaan_detail) and 
								apt_pemesanan.kd_supplier=apt_supplier.kd_supplier and apt_supplier.kd_supplier='$kd_supplier' and apt_pemesanan.no_pemesanan like '%$no_pemesanan%'
								and apt_pemesanan.status_approve='1'");*/
		//$query=$this->db->query("select apt_pemesanan.no_pemesanan,date_format(apt_pemesanan.tgl_pemesanan,'%d-%m-%Y') as tgl_pemesanan,apt_supplier.nama from apt_pemesanan,apt_supplier where no_pemesanan not in(select no_pemesanan from apt_penerimaan_detail) and apt_pemesanan.kd_supplier=apt_supplier.kd_supplier and apt_supplier.kd_supplier='$kd_supplier' and apt_pemesanan.no_pemesanan like '%$no_pemesanan%'


//////////////////////////// edit by rian : perubahan query agar pesanan yang belum datang semua atau sebagian tetap muncul /////////////

$query=$this->db->query("select apt_pemesanan.no_pemesanan,date_format(apt_pemesanan.tgl_pemesanan,'%d-%m-%Y') as tgl_pemesanan,apt_supplier.nama from apt_pemesanan,apt_supplier where no_pemesanan  in (select no_pemesanan from apt_pemesanan_detail where qty_kcl - jml_penerimaan != 0 group by no_pemesanan) and apt_pemesanan.kd_supplier=apt_supplier.kd_supplier and apt_supplier.kd_supplier='$kd_supplier' and apt_pemesanan.no_pemesanan like '%$no_pemesanan%'								");
		return $query->result_array();
	}
	


	function getdetilpemesanan($no_pemesanan){
		$pecah=explode(',',$no_pemesanan);
		//debugvar($pecah);
		$no_pemesananx="";
		for($x=0;$x<count($pecah);$x++){
			$no_pemesananx.="'".$pecah[$x]."'";
			if($x!=count($pecah)-1){
			$no_pemesananx.=",";			
			}
		}
/**
		$query=$this->db->query("select apt_pemesanan.no_pemesanan,apt_pemesanan_detail.kd_obat,apt_obat.nama_obat,apt_satuan_kecil.satuan_kecil,apt_obat.pembanding,apt_pemesanan_detail.diskon as disc_prs, '0' as diskon,
								apt_pemesanan_detail.qty_box,apt_pemesanan_detail.qty_kcl,apt_pemesanan_detail.harga_beli,(apt_pemesanan_detail.qty_kcl*apt_pemesanan_detail.harga_beli) as jum,
								(((apt_pemesanan_detail.qty_kcl*apt_pemesanan_detail.harga_beli)-((apt_pemesanan_detail.diskon/100)*apt_pemesanan_detail.harga_beli*apt_pemesanan_detail.qty_kcl))+(((apt_pemesanan_detail.qty_kcl*apt_pemesanan_detail.harga_beli)-((apt_pemesanan_detail.diskon/100)*apt_pemesanan_detail.harga_beli*apt_pemesanan_detail.qty_kcl))*(apt_pemesanan_detail.ppn/100))) as total1,
								apt_pemesanan_detail.diskon,apt_pemesanan_detail.ppn,((apt_pemesanan_detail.diskon/100)*apt_pemesanan_detail.harga_beli*apt_pemesanan_detail.qty_kcl) as harga_belidisc
								from apt_pemesanan,apt_pemesanan_detail,apt_obat,apt_satuan_kecil,apt_supplier where apt_pemesanan.no_pemesanan=apt_pemesanan_detail.no_pemesanan and 
								apt_pemesanan_detail.kd_obat=apt_obat.kd_obat and apt_obat.kd_satuan_kecil=apt_satuan_kecil.kd_satuan_kecil and 
								apt_pemesanan.kd_supplier=apt_supplier.kd_supplier and apt_pemesanan.no_pemesanan in ($no_pemesananx)");

**/
///////////////////////////////////// edit by rian : menampilkan sisa pesanan ///////////////////////////////////////
$query=$this->db->query("select apt_pemesanan.no_pemesanan,apt_pemesanan_detail.kd_obat,apt_pemesanan_detail.jml_penerimaan,apt_obat.nama_obat,apt_satuan_kecil.satuan_kecil,apt_obat.pembanding,apt_pemesanan_detail.diskon as disc_prs, '0' as diskon,
								apt_pemesanan_detail.qty_box,(apt_pemesanan_detail.qty_kcl - apt_pemesanan_detail.jml_penerimaan) as qty,apt_pemesanan_detail.harga_beli,((apt_pemesanan_detail.qty_kcl - apt_pemesanan_detail.jml_penerimaan) * apt_pemesanan_detail.harga_beli) as jum,
								((((apt_pemesanan_detail.qty_kcl - apt_pemesanan_detail.jml_penerimaan)*apt_pemesanan_detail.harga_beli)-((apt_pemesanan_detail.diskon/100)*apt_pemesanan_detail.harga_beli* (apt_pemesanan_detail.qty_kcl - apt_pemesanan_detail.jml_penerimaan)))+((((apt_pemesanan_detail.qty_kcl - apt_pemesanan_detail.jml_penerimaan)*apt_pemesanan_detail.harga_beli)-((apt_pemesanan_detail.diskon/100)*apt_pemesanan_detail.harga_beli*(apt_pemesanan_detail.qty_kcl - apt_pemesanan_detail.jml_penerimaan)))*(apt_pemesanan_detail.ppn/100))) as total1,
								apt_pemesanan_detail.diskon,apt_pemesanan_detail.ppn,((apt_pemesanan_detail.diskon/100)*apt_pemesanan_detail.harga_beli*(apt_pemesanan_detail.qty_kcl - apt_pemesanan_detail.jml_penerimaan)) as harga_belidisc
								from apt_pemesanan,apt_pemesanan_detail,apt_obat,apt_satuan_kecil,apt_supplier where apt_pemesanan.no_pemesanan=apt_pemesanan_detail.no_pemesanan and 
								apt_pemesanan_detail.kd_obat=apt_obat.kd_obat and apt_obat.kd_satuan_kecil=apt_satuan_kecil.kd_satuan_kecil and 
								apt_pemesanan.kd_supplier=apt_supplier.kd_supplier and apt_pemesanan.no_pemesanan in ($no_pemesananx) and (apt_pemesanan_detail.qty_kcl - apt_pemesanan_detail.jml_penerimaan > 0)");

		return $query->result_array();
	}
	
	function ambilNama($value){
		$query=$this->db->query("select nama_obat from apt_obat where kd_obat='$value'");
		$nama=$query->row_array();
		return $nama['nama_obat'];
	}
	
	function ambildiskonall($no_penerimaan){
		$query=$this->db->query("select discount from apt_penerimaan where no_penerimaan='$no_penerimaan'");		
		$diskonall=$query->row_array();
		if(empty($diskonall)) return 0;
		return $diskonall['discount'];
	}
	
	function ambildistok1($value){
		$query=$this->db->query("select distinct harga_pokok from apt_stok_unit where kd_obat='$value'");		
		$harga_pokok=$query->row_array();
		if(empty($harga_pokok)) return 0;
		return $harga_pokok['harga_pokok'];
	}
	
	function nogrouping($no_pemesanan){
		$query=$this->db->query("select no_grouping from apt_pemesanan where no_pemesanan='$no_pemesanan'");
		$no_grouping=$query->row_array();
		if(empty($no_grouping)) return '-';
		return $no_grouping['no_grouping'];
	}
	
	function urutgrouping($no_grouping,$kd_supplier,$value){
		$query=$this->db->query("select apt_grouping_pengajuan_det.urut_grouping from apt_grouping_pengajuan,apt_grouping_pengajuan_det 
								where apt_grouping_pengajuan_det.no_grouping=apt_grouping_pengajuan.no_grouping and 
								apt_grouping_pengajuan.no_grouping='$no_grouping' and apt_grouping_pengajuan_det.kd_supplier='$kd_supplier' 
								and apt_grouping_pengajuan_det.kd_obat='$value'");
		$urut_grouping=$query->row_array();
		if(empty($urut_grouping)) return '-';
		return $urut_grouping['urut_grouping'];
	}
	
	function autoNumber1($tahun,$bulan){ 
		$this->db->select('max(right(acc_ap_faktur.apf_number,4)) as a',false);
		$this->db->where('year(acc_ap_faktur.apf_date)',$tahun);
		$this->db->where('month(acc_ap_faktur.apf_date)',$bulan);
		$query=$this->db->get("acc_ap_faktur");
		$item= $query->row_array();
		return $item['a'];
		
	}
	
	function ambilvendor($kd_supplier){
		$query=$this->db->query("select acc_vendors.vend_code from acc_vendors,apt_supplier where acc_vendors.kd_supplier=apt_supplier.kd_supplier
								and apt_supplier.kd_supplier='$kd_supplier'");
		$vend_code=$query->row_array();
		if(empty($vend_code)) return '-';
		return $vend_code['vend_code'];
	}
	
	function ambilaccount($vend_code){
		$query=$this->db->query("select account from acc_vendors where vend_code='$vend_code'");
		$account=$query->row_array();
		if(empty($account)) return '-';
		return $account['account'];
	}
	
	function ambilaccount1(){
		$query=$this->db->query("select account from accounts where name like '%biaya%obat%'");
		$account1=$query->row_array();
		if(empty($account1)) return '-';
		return $account1['account'];
	}
	
	function tanggaltempo($due){
		$due1=convertDate($due);
		$query=$this->db->query("select '$due1'+interval '3' month as due_date");
		$due_date=$query->row_array();
		return $due_date['due_date'];
	}
	
	function ambilApp(){
		$id_user=$this->session->userdata('id_user'); 
		$query=$this->db->query("select kd_app from approval where id_user='$id_user'");
		$kd_applogin=$query->row_array();
		if(empty($kd_applogin))return 0;
		return $kd_applogin['kd_app'];
	}
	
	function nomor(){
		$query=$this->db->query("select max(nomor) as kode from apt_log_penerimaan");
		$kode=$query->row_array();
		if(empty($kode)) return 0;
		return $kode['kode'];
	}
	
	function isPosted1($nopenerimaan)
	{
		$this->db->where('no_penerimaan',$nopenerimaan);
		$this->db->where('is_approve',1);
		$query=$this->db->get('apt_penerimaan');
		$item=$query->num_rows();
		if($item)return true;
		return false;
	}

	function getDigitPertama($kode){
        // query
        $query = "SELECT digitbarcode as digit
                    FROM apt_unit where  kd_unit_apt='".$kode."' ";
        
        // execute query and retrieve item
        $query=$this->db->query($query);
        $item=$query->row_array();
        // return item                       
        return $item['digit'];
    }

   function getMaxBarcode($kode){
        // query
        $query = "SELECT ifnull(max(right(barcode,4)),0) as lastbarcode
                    FROM apt_stok_unit where  left(barcode,3)='".$kode."' ";
        
        // execute query and retrieve item
        $query=$this->db->query($query);
        $item=$query->row_array();
        // return item                       
        return $item['lastbarcode'];
    }

   function getMaxUrut($kode){
        // query
        $query = "SELECT ifnull(max(urut),0) as urut
                    FROM apt_penerimaan_detail where  no_penerimaan='".$kode."' ";
        
        // execute query and retrieve item
        $query=$this->db->query($query);
        $item=$query->row_array();
        // return item                       
        return $item['urut'];
    }

}
	
?>
