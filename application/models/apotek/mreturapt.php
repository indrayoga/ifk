<?



class Mreturapt extends CI_Model {

	function __construct() {
		
		parent::__construct();
	}

	function ambilDataRetur($no_retur,$periodeawal,$periodeakhir){
		$this->db->select("apt_retur_obat.no_retur,apt_retur_obat.tgl_retur,apt_retur_obat.no_penerimaan,apt_retur_obat.jumlah,apt_retur_obat.status_approve,apt_retur_obat.posting",FALSE);
		if(!empty($no_retur))$this->db->like('apt_penjualan.no_retur',$no_retur,'both');
		if(!empty($periodeawal))$this->db->where('date(apt_retur_obat.tgl_retur)>=',convertDate($periodeawal));
		if(!empty($periodeakhir))$this->db->where('date(apt_retur_obat.tgl_retur)<=',convertDate($periodeakhir));
		
		$this->db->join('apt_penerimaan','apt_penerimaan.no_penerimaan=apt_retur_obat.no_penerimaan','left');
		$this->db->order_by('apt_retur_obat.no_retur','desc');
		
		$query=$this->db->get("apt_retur_obat");		
		return $query->result_array(); 
	}
	
	function ambilItemData3($kd_unit_apt,$value){
		$this->db->select('harga_pokok',FALSE);
		if(!empty($kd_unit_apt)) $this->db->where('kd_unit_apt',$kd_unit_apt);
		if(!empty($value)) $this->db->where('kd_obat',$value);
		$query= $this->db->get("apt_stok_unit");
		$harga_pokok=$query->row_array();
		return $harga_pokok['harga_pokok'];
	}
	
	function ambilKodeUnit(){
		$query=$this->db->query("select kd_unit_apt as kode from apt_unit where nama_unit_apt like '%gudang farmasi%'");
		$kd_unit_apt=$query->row_array();
		return $kd_unit_apt['kode'];
	}
	
	function ambilStok($kd_unit_apt,$value,$tgl){
		$this->db->select('jml_stok',FALSE);
		if(!empty($kd_unit_apt)) $this->db->where('kd_unit_apt',$kd_unit_apt);
		if(!empty($value)) $this->db->where('kd_obat',$value);
		if(!empty($tgl)) $this->db->where('tgl_expire',$tgl);
		$query= $this->db->get("apt_stok_unit");
		$jml_stok=$query->row_array();
		return $jml_stok['jml_stok'];
	}

	function isPosted($no_retur)
	{
		$this->db->where('no_retur',$no_retur);
		$this->db->where('posting',1);
		$query=$this->db->get('apt_retur_obat');
		$item=$query->num_rows();
		if($item)return true;
		return false;
	}
	
	function ambilTotal($no_penjualan){
		$query=$this->db->query("select sum(total) as totalsum from apt_penjualan_bayar where no_penjualan='$no_penjualan'");
		return $query->row_array(); 	
	}
	
	function ambilTotalBayar(){
		$this->db->select('SUM(total) as total_bayar');
		$query = $this->db->get('apt_penjualan_bayar');
		$jumbayar=$query->row_array();
		return $jumbayar['total_bayar'];
	}
	
	function ambilData2($kd_unit_apt,$nama_obat){ 
		$query=$this->db->query("select apt_stok_unit.kd_obat, apt_obat.nama_obat, apt_satuan_kecil.satuan_kecil, date_format(apt_stok_unit.tgl_expire,'%d-%m-%Y') as tgl_expire,
						substring_index((apt_stok_unit.harga_pokok * apt_margin_harga.nilai_margin),'.',1) as harga_jual,substring_index(apt_stok_unit.jml_stok,'.',1) as jml_stok
						from apt_obat,apt_stok_unit,apt_unit,apt_margin_harga,apt_golongan,apt_jenis_obat,apt_satuan_kecil where 
						apt_obat.kd_satuan_kecil=apt_satuan_kecil.kd_satuan_kecil and apt_obat.kd_obat=apt_stok_unit.kd_obat 
						and apt_obat.kd_golongan=apt_golongan.kd_golongan and apt_obat.kd_jenis_obat=apt_jenis_obat.kd_jenis_obat
						and apt_stok_unit.kd_unit_apt=apt_unit.kd_unit_apt and apt_margin_harga.kd_golongan=apt_golongan.kd_golongan and apt_obat.is_aktif='1'
						and apt_margin_harga.kd_jenis_obat=apt_jenis_obat.kd_jenis_obat and apt_stok_unit.jml_stok>0 and apt_stok_unit.kd_unit_apt='$kd_unit_apt' 
						and apt_obat.nama_obat like '%$nama_obat%' order by apt_obat.kd_obat asc");
		return $query->result_array(); 			
	}
	
	function autoNumber($tahun,$bulan){ 		
		$this->db->select('max(right(no_retur,3)) as a',false); //RTR.2013.07.001
		$this->db->where('year(tgl_retur)',$tahun);
		$this->db->where('month(tgl_retur)',$bulan);
		$query=$this->db->get("apt_retur_obat");
		$item= $query->row_array();
		return $item['a'];
	}
	
	function getAllDetailPenerimaan($no_penerimaan){ 
		$query=$this->db->query("select apt_obat.kd_obat, apt_obat.nama_obat, apt_satuan_kecil.satuan_kecil, date_format(apt_penerimaan_detail.tgl_expire,'%d-%m-%Y') as tgl_expire, 
				apt_penerimaan_detail.kd_unit_apt, apt_obat.pembanding, apt_penerimaan_detail.qty_box, apt_penerimaan_detail.qty_kcl, 
				apt_penerimaan_detail.harga_beli, apt_penerimaan_detail.harga_avg as sum, (apt_penerimaan_detail.qty_kcl*apt_penerimaan_detail.harga_beli) as jum, 
				apt_penerimaan_detail.ppn_item,
				substring_index(((((apt_penerimaan_detail.qty_kcl * apt_penerimaan_detail.harga_beli) +((apt_penerimaan_detail.qty_kcl * apt_penerimaan_detail.harga_beli)*(apt_penerimaan_detail.ppn_item/100))))),'.',1) as total1	
				from apt_obat, apt_satuan_kecil, apt_penerimaan_detail, apt_penerimaan, apt_unit 
				where apt_obat.kd_satuan_kecil=apt_satuan_kecil.kd_satuan_kecil and apt_obat.kd_obat=apt_penerimaan_detail.kd_obat 
				and apt_penerimaan_detail.no_penerimaan=apt_penerimaan.no_penerimaan and apt_penerimaan_detail.kd_unit_apt=apt_unit.kd_unit_apt 
				and apt_penerimaan.kd_unit_apt=apt_unit.kd_unit_apt and apt_penerimaan.no_penerimaan='$no_penerimaan'");
		return $query->result_array(); 		
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
	
	/*function ambilItemDataTrans($no_retur){
		$this->db->select("apt_retur_obat.no_retur,date_format(apt_retur_obat.tgl_retur,'%Y-%m-%d') as tgl_retur,date_format(apt_retur_obat.tgl_retur,'%H:%i:%s') as jam_retur,apt_retur_obat.shift,apt_retur_obat.posting,
							apt_penerimaan.no_penerimaan,apt_penerimaan.kd_supplier,apt_supplier.nama,date_format(apt_penerimaan.tgl_penerimaan,'%Y-%m-%d') as tgl_penerimaan,apt_retur_obat.keterangan,
							apt_retur_obat.jumlah",FALSE);
		if(!empty($no_retur))$this->db->where('apt_retur_obat.no_retur',$no_retur);
		$this->db->join('apt_penerimaan','apt_penerimaan.no_penerimaan=apt_retur_obat.no_penerimaan','left');
		$this->db->join('apt_supplier','apt_supplier.kd_supplier=apt_penerimaan.kd_supplier','left');
		$query= $this->db->get('apt_retur_obat');
		return $query->row_array();
	}*/
	
	function ambilItemDataTrans($no_retur){
		$query=$this->db->query("select apt_retur_obat.no_retur,date_format(apt_retur_obat.tgl_retur,'%Y-%m-%d') as tgl_retur,date_format(apt_retur_obat.tgl_retur,'%H:%i:%s') as jam_retur,apt_retur_obat.shift,apt_retur_obat.posting,
							apt_penerimaan.no_penerimaan,apt_penerimaan.kd_supplier,apt_supplier.nama,date_format(apt_penerimaan.tgl_penerimaan,'%Y-%m-%d') as tgl_penerimaan,apt_retur_obat.keterangan,
							apt_retur_obat.jumlah,apt_retur_obat.no_batch from apt_retur_obat,apt_penerimaan,apt_supplier where apt_penerimaan.no_penerimaan=apt_retur_obat.no_penerimaan and 
							apt_supplier.kd_supplier=apt_penerimaan.kd_supplier and apt_retur_obat.no_retur='$no_retur'");
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
		/*$query=$this->db->query("select apt_retur_obat.no_batch as no_batch1,apt_retur_obat_detail.tgl_expire as tgl_expire1,apt_retur_obat_detail.kd_obat as kd_obat1,apt_retur_obat.no_penerimaan,apt_retur_obat_detail.kd_obat,apt_obat.nama_obat,apt_satuan_kecil.satuan_kecil,apt_retur_obat_detail.kd_milik,date_format(apt_retur_obat_detail.tgl_expire,'%d-%m-%Y') as tgl_expire,apt_obat.pembanding,apt_retur_obat_detail.qty_kcl,
								apt_retur_obat_detail.harga_beli,apt_retur_obat_detail.qty_box,apt_retur_obat_detail.ppn_item,apt_penerimaan_detail.harga_belidisc,apt_penerimaan_detail.bonus, 
								((apt_retur_obat_detail.qty_kcl*apt_retur_obat_detail.harga_beli)-apt_penerimaan_detail.harga_belidisc) as jum, 
								substring_index((((apt_retur_obat_detail.qty_kcl*apt_retur_obat_detail.harga_beli)-apt_penerimaan_detail.harga_belidisc))+((((apt_retur_obat_detail.qty_kcl*apt_retur_obat_detail.harga_beli)-apt_penerimaan_detail.harga_belidisc))*(apt_retur_obat_detail.ppn_item/100)),'.',1) as total1
								from apt_obat,apt_milik,apt_retur_obat_detail,apt_satuan_kecil,apt_retur_obat,apt_penerimaan,apt_penerimaan_detail
								where apt_obat.kd_obat=apt_retur_obat_detail.kd_obat and apt_milik.kd_milik=apt_retur_obat_detail.kd_milik
								and  apt_retur_obat.no_retur=apt_retur_obat_detail.no_retur and apt_obat.kd_satuan_kecil=apt_satuan_kecil.kd_satuan_kecil 
								and apt_penerimaan.no_penerimaan=apt_penerimaan_detail.no_penerimaan and apt_penerimaan.no_penerimaan=apt_retur_obat.no_penerimaan and 
								apt_penerimaan_detail.kd_obat=apt_obat.kd_obat and apt_retur_obat.no_retur='$no_retur'");*/
		$query=$this->db->query("select apt_retur_obat.no_batch as no_batch1,apt_retur_obat_detail.tgl_expire as tgl_expire1,apt_retur_obat_detail.kd_obat as kd_obat1,apt_retur_obat.no_penerimaan,apt_retur_obat_detail.kd_obat,apt_obat.nama_obat,apt_satuan_kecil.satuan_kecil,apt_retur_obat_detail.kd_milik,date_format(apt_retur_obat_detail.tgl_expire,'%d-%m-%Y') as tgl_expire,apt_obat.pembanding,apt_retur_obat_detail.qty_kcl,
								apt_retur_obat_detail.harga_beli,apt_retur_obat_detail.qty_box,apt_retur_obat_detail.ppn_item,apt_penerimaan_detail.harga_belidisc,apt_penerimaan_detail.bonus, 
								((apt_retur_obat_detail.qty_kcl*apt_retur_obat_detail.harga_beli)-apt_penerimaan_detail.harga_belidisc) as jum, 
								substring_index((((apt_retur_obat_detail.qty_kcl*apt_retur_obat_detail.harga_beli)-apt_penerimaan_detail.harga_belidisc))+((((apt_retur_obat_detail.qty_kcl*apt_retur_obat_detail.harga_beli)-apt_penerimaan_detail.harga_belidisc))*(apt_retur_obat_detail.ppn_item/100)),'.',1) as total1,
								if((select count(apt_penjualan_detail.no_penjualan) from apt_penjualan,apt_penjualan_detail,apt_obat,apt_penerimaan,apt_penerimaan_detail where 
								apt_penjualan_detail.no_penjualan=apt_penjualan.no_penjualan and apt_penjualan_detail.kd_obat=apt_obat.kd_obat  and 
								apt_penerimaan_detail.kd_obat=apt_penjualan_detail.kd_obat and apt_penjualan_detail.tgl_expire=apt_penerimaan_detail.tgl_expire and
								apt_penerimaan_detail.kd_obat=apt_obat.kd_obat and apt_penerimaan.no_penerimaan=apt_penerimaan_detail.no_penerimaan and
								apt_penerimaan_detail.no_batch=no_batch1 and apt_penjualan_detail.kd_obat=kd_obat1 and apt_penjualan_detail.tgl_expire=tgl_expire1)>0,
								'ada','tidak ada') as hasil1,
								if((select count(apt_distribusi_detail.no_distribusi) from apt_distribusi,apt_distribusi_detail,apt_obat,apt_penerimaan,apt_penerimaan_detail where 
								apt_distribusi_detail.no_distribusi=apt_distribusi.no_distribusi and apt_distribusi_detail.kd_obat=apt_obat.kd_obat  and 
								apt_penerimaan_detail.kd_obat=apt_distribusi_detail.kd_obat and apt_distribusi_detail.tgl_expire=apt_distribusi_detail.tgl_expire and
								apt_penerimaan_detail.kd_obat=apt_obat.kd_obat and apt_penerimaan.no_penerimaan=apt_penerimaan_detail.no_penerimaan and
								apt_penerimaan_detail.no_batch=no_batch1 and apt_distribusi_detail.kd_obat=kd_obat1 and apt_distribusi_detail.tgl_expire=tgl_expire1)>0,
								'ada','tidak ada') as hasil2
								from apt_obat,apt_milik,apt_retur_obat_detail,apt_satuan_kecil,apt_retur_obat,apt_penerimaan,apt_penerimaan_detail
								where apt_obat.kd_obat=apt_retur_obat_detail.kd_obat and apt_milik.kd_milik=apt_retur_obat_detail.kd_milik
								and  apt_retur_obat.no_retur=apt_retur_obat_detail.no_retur and apt_obat.kd_satuan_kecil=apt_satuan_kecil.kd_satuan_kecil 
								and apt_penerimaan.no_penerimaan=apt_penerimaan_detail.no_penerimaan and apt_penerimaan.no_penerimaan=apt_retur_obat.no_penerimaan and 
								apt_penerimaan_detail.kd_obat=apt_obat.kd_obat and apt_retur_obat.no_retur='$no_retur'");
		return $query->result_array(); 		
	}
	
	function isNumberExist($number){
		$this->db->where('no_retur',$number);
		$query=$this->db->get('apt_retur_obat');
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
	
	function getRetur($no_retur){
		$this->db->select("apt_retur_obat.no_retur,date_format(apt_retur_obat.tgl_retur,'%d-%m-%Y') as tgl_retur,apt_retur_obat.shift,apt_retur_obat.posting,
							apt_penerimaan.no_penerimaan,apt_penerimaan.kd_supplier,apt_supplier.nama,date_format(apt_penerimaan.tgl_penerimaan,'%d-%m-%Y') as tgl_penerimaan,apt_retur_obat.keterangan,
							apt_retur_obat.jumlah,apt_retur_obat.status_approve",FALSE);
		if(!empty($no_retur))$this->db->like('apt_retur_obat.no_retur',$no_retur,'both');
		
		$this->db->join('apt_penerimaan','apt_penerimaan.no_penerimaan=apt_retur_obat.no_penerimaan','left');
		$this->db->join('apt_supplier','apt_supplier.kd_supplier=apt_penerimaan.kd_supplier','left');
		$query= $this->db->get('apt_retur_obat');
		
		return $query->row_array();
	}
	
	//function ambilData3($no_penerimaan){
	function ambilData3($no_batch){
		/*$query=$this->db->query("select apt_penerimaan.no_penerimaan,date_format(apt_penerimaan.tgl_penerimaan,'%d-%m-%Y') as tgl_penerimaan,apt_supplier.kd_supplier,apt_supplier.nama,(apt_penerimaan.jumlah-apt_penerimaan.materai) as jumlah,
								apt_penerimaan.materai from apt_penerimaan,apt_supplier where apt_penerimaan.kd_supplier=apt_supplier.kd_supplier and apt_penerimaan.posting='0' and apt_penerimaan.no_penerimaan like '%$no_penerimaan%'");*/
		$query=$this->db->query("select apt_penerimaan_detail.no_batch,apt_penerimaan.no_penerimaan,date_format(apt_penerimaan.tgl_penerimaan,'%d-%m-%Y') as tgl_penerimaan,apt_supplier.kd_supplier,
								apt_supplier.nama,(apt_penerimaan.jumlah-apt_penerimaan.materai) as jumlah,apt_penerimaan.materai from apt_penerimaan,apt_supplier, 
								apt_penerimaan_detail,apt_obat where apt_penerimaan.kd_supplier=apt_supplier.kd_supplier 
								and apt_penerimaan_detail.no_penerimaan=apt_penerimaan.no_penerimaan and apt_penerimaan_detail.kd_obat=apt_obat.kd_obat and 
								apt_penerimaan_detail.no_batch like '%$no_batch%' and apt_penerimaan.posting='1' and apt_penerimaan.retur='0' order by apt_penerimaan.no_penerimaan desc");
		return $query->result_array();
	}
	
	function getdetilpenerimaan($no_batch){
		/*$query=$this->db->query("select apt_obat.kd_obat, apt_obat.nama_obat, apt_satuan_kecil.satuan_kecil, date_format(apt_penerimaan_detail.tgl_expire,'%d-%m-%Y') as tgl_expire, 
								apt_obat.pembanding, apt_penerimaan_detail.qty_box, apt_penerimaan_detail.qty_kcl, apt_penerimaan_detail.harga_beli,apt_penerimaan_detail.harga_belidisc,
								(apt_penerimaan_detail.qty_kcl*apt_penerimaan_detail.harga_beli) as jum, apt_penerimaan_detail.ppn_item,apt_penerimaan_detail.bonus,				
								substring_index(((((apt_penerimaan_detail.qty_kcl * apt_penerimaan_detail.harga_beli) +((apt_penerimaan_detail.qty_kcl * apt_penerimaan_detail.harga_beli)*(apt_penerimaan_detail.ppn_item/100))))),'.',1) as total1	
								from apt_obat, apt_satuan_kecil, apt_penerimaan_detail, apt_penerimaan, apt_unit 
								where apt_obat.kd_satuan_kecil=apt_satuan_kecil.kd_satuan_kecil and apt_obat.kd_obat=apt_penerimaan_detail.kd_obat 
								and apt_penerimaan_detail.no_penerimaan=apt_penerimaan.no_penerimaan and apt_penerimaan_detail.kd_unit_apt=apt_unit.kd_unit_apt 
								and apt_penerimaan.kd_unit_apt=apt_unit.kd_unit_apt and apt_penerimaan_detail.no_batch='$no_batch'");*/
		$query=$this->db->query("select apt_penerimaan.no_penerimaan,apt_penerimaan_detail.no_batch as no_batch1,apt_penerimaan_detail.tgl_expire as tgl_expire1,
								apt_penerimaan_detail.kd_obat as kd_obat1,apt_obat.kd_obat, apt_obat.nama_obat, apt_satuan_kecil.satuan_kecil, 
								date_format(apt_penerimaan_detail.tgl_expire,'%d-%m-%Y') as tgl_expire,apt_obat.pembanding, apt_penerimaan_detail.qty_box, 
								apt_penerimaan_detail.qty_kcl, apt_penerimaan_detail.harga_beli,apt_penerimaan_detail.harga_belidisc,
								(apt_penerimaan_detail.qty_kcl*apt_penerimaan_detail.harga_beli) as jum, apt_penerimaan_detail.ppn_item,apt_penerimaan_detail.bonus,				
								substring_index(((((apt_penerimaan_detail.qty_kcl * apt_penerimaan_detail.harga_beli) +((apt_penerimaan_detail.qty_kcl * apt_penerimaan_detail.harga_beli)*(apt_penerimaan_detail.ppn_item/100))))),'.',1) as total1,
								if((select count(apt_penjualan_detail.no_penjualan) from apt_penjualan,apt_penjualan_detail,apt_obat,apt_penerimaan,apt_penerimaan_detail where 
								apt_penjualan_detail.no_penjualan=apt_penjualan.no_penjualan and apt_penjualan_detail.kd_obat=apt_obat.kd_obat  and 
								apt_penerimaan_detail.kd_obat=apt_penjualan_detail.kd_obat and apt_penjualan_detail.tgl_expire=apt_penerimaan_detail.tgl_expire and
								apt_penerimaan_detail.kd_obat=apt_obat.kd_obat and apt_penerimaan.no_penerimaan=apt_penerimaan_detail.no_penerimaan and
								apt_penerimaan_detail.no_batch=no_batch1 and apt_penjualan_detail.kd_obat=kd_obat1 and apt_penjualan_detail.tgl_expire=tgl_expire1)>0,
								'ada','tidak ada') as hasil1,
								if((select count(apt_distribusi_detail.no_distribusi) from apt_distribusi,apt_distribusi_detail,apt_obat,apt_penerimaan,apt_penerimaan_detail where 
								apt_distribusi_detail.no_distribusi=apt_distribusi.no_distribusi and apt_distribusi_detail.kd_obat=apt_obat.kd_obat  and 
								apt_penerimaan_detail.kd_obat=apt_distribusi_detail.kd_obat and apt_distribusi_detail.tgl_expire=apt_distribusi_detail.tgl_expire and
								apt_penerimaan_detail.kd_obat=apt_obat.kd_obat and apt_penerimaan.no_penerimaan=apt_penerimaan_detail.no_penerimaan and
								apt_penerimaan_detail.no_batch=no_batch1 and apt_distribusi_detail.kd_obat=kd_obat1 and apt_distribusi_detail.tgl_expire=tgl_expire1)>0,
								'ada','tidak ada') as hasil2
								from apt_obat, apt_satuan_kecil, apt_penerimaan_detail, apt_penerimaan, apt_unit 
								where apt_obat.kd_satuan_kecil=apt_satuan_kecil.kd_satuan_kecil and apt_obat.kd_obat=apt_penerimaan_detail.kd_obat 
								and apt_penerimaan_detail.no_penerimaan=apt_penerimaan.no_penerimaan and apt_penerimaan_detail.kd_unit_apt=apt_unit.kd_unit_apt 
								and apt_penerimaan.kd_unit_apt=apt_unit.kd_unit_apt and apt_penerimaan_detail.no_batch='$no_batch'");
		return $query->result_array();
	}
	
	function ambilItemTransaksi($no_retur){
		$query=$this->db->query("select apt_retur_obat.no_retur,apt_retur_obat.tgl_retur,apt_retur_obat.shift,apt_retur_obat.posting,
								apt_penerimaan.no_penerimaan,apt_penerimaan.kd_supplier,apt_supplier.nama,apt_penerimaan.tgl_penerimaan,apt_retur_obat.keterangan,
								apt_retur_obat.jumlah from apt_retur_obat,apt_penerimaan,apt_supplier where apt_retur_obat.no_penerimaan=apt_penerimaan.no_penerimaan
								and apt_penerimaan.kd_supplier=apt_supplier.kd_supplier and apt_retur_obat.no_retur='$no_retur'");
		return $query->result_array();
	}
	
	function ambilStokAwal($kd_unit_apt,$value,$tgl_expire){
		$kd_unit_apt=$this->session->userdata('kd_unit_apt');
		$query=$this->db->query("select jml_stok from apt_stok_unit where kd_unit_apt='$kd_unit_apt' and kd_obat='$value' and tgl_expire='$tgl_expire'");
		$jml_stok_awal=$query->row_array();
		//debugvar($jml_stok_asal);
		if(empty($jml_stok_awal)) return 0;
		return $jml_stok_awal['jml_stok'];
	}
	
	function isAppExist($number,$number1){
		$this->db->where('no_retur',$number);
		$this->db->where('kd_app',$number1);
		$query=$this->db->get('apt_app_returpenerimaan');
		$count=$query->num_rows();
		if($count){
			return true;
		}
		return false;
	}
	
	function ambilApprover(){
		$query=$this->db->query("select pegawai.nama_pegawai,'-' as status,approval.kd_app,approval.urut,0 as is_app from user,pegawai,approval where user.id_pegawai=pegawai.id_pegawai 
								and approval.id_user=user.id_user order by approval.urut");
		return $query->result_array(); 
	}
	
	function tampilApprover($no_retur){
		$query=$this->db->query("select pegawai.nama_pegawai,'-' as status,approval.kd_app,approval.urut,apt_app_returpenerimaan.is_app from user,pegawai,approval,
								apt_retur_obat,apt_app_returpenerimaan where user.id_pegawai=pegawai.id_pegawai and approval.id_user=user.id_user and 
								apt_app_returpenerimaan.no_retur=apt_retur_obat.no_retur and apt_retur_obat.no_retur='$no_retur' 
								and apt_app_returpenerimaan.kd_app=approval.kd_app order by approval.urut");
		return $query->result_array();
	}
	
	function ambilApp(){
		$id_user=$this->session->userdata('id_user'); 
		$query=$this->db->query("select kd_app from approval where id_user='$id_user'");
		$kd_applogin=$query->row_array();
		if(empty($kd_applogin))return 0;
		return $kd_applogin['kd_app'];
	}
	
	function statusisaplogin($no_retur,$kd_applogin){
		$query=$this->db->query("select is_app from apt_app_returpenerimaan where kd_app='$kd_applogin' and no_retur='$no_retur'");
		$isapp=$query->row_array();
		return $isapp['is_app'];
	}
	
	function urutapprover($kd_applogin){
		$query=$this->db->query("select urut from approval where kd_app='$kd_applogin'");
		$urutapp=$query->row_array();
		return $urutapp['urut'];
	}
	
	function urutapprover1($urutapp,$no_retur){
		//$a=$urutapp-1;
		/*$query=$this->db->query("select app_pemesanan.is_app from app_pemesanan,approval where approval.urut<$urutapp and 
								app_pemesanan.no_pemesanan='$no_pemesanan' and app_pemesanan.kd_app=approval.kd_app");*/
		$query=$this->db->query("select apt_app_returpenerimaan.is_app from apt_app_returpenerimaan,approval where approval.urut<$urutapp and 
									apt_app_returpenerimaan.no_retur='$no_retur' and apt_app_returpenerimaan.kd_app=approval.kd_app
									order by approval.urut desc limit 1");
		$urutapp1=$query->row_array();
		return $urutapp1['is_app'];
	}
	
	function pegawai($urutapp,$no_retur){
		$a=$urutapp-1;
		/*$query=$this->db->query("select pegawai.nama_pegawai from app_pemesanan,approval,pegawai,user where approval.urut='$a' and 
								app_pemesanan.no_pemesanan='$no_pemesanan' and app_pemesanan.kd_app=approval.kd_app and pegawai.id_pegawai=user.id_pegawai and
								approval.id_user=user.id_user");*/
		$query=$this->db->query("select pegawai.nama_pegawai from apt_app_returpenerimaan,approval,pegawai,user where approval.urut<$urutapp and 
								apt_app_returpenerimaan.no_retur='$no_retur' and apt_app_returpenerimaan.kd_app=approval.kd_app and pegawai.id_pegawai=user.id_pegawai and
								approval.id_user=user.id_user order by approval.urut desc limit 1");
		$namapegawai=$query->row_array();
		return $namapegawai['nama_pegawai'];
	}
	
	function countApprover($number){
		$this->db->select('count(kd_app) as count');
		$this->db->where('no_retur',$number);
		$query=$this->db->get('apt_app_returpenerimaan');
		$count=$query->row_array();
		return $count['count'];
	}
	
	function countIsApp($no_retur){
		$query=$this->db->query("select count(kd_app) as countisap from apt_app_returpenerimaan where no_retur='$no_retur' and is_app='1'");
		$countisap=$query->row_array();
		return $countisap['countisap'];
	}
	
	function ambilNama($value){
		$query=$this->db->query("select nama_obat from apt_obat where kd_obat='$value'");
		$nama=$query->row_array();
		return $nama['nama_obat'];
	}
}
	
?>