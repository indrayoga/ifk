<?



class Mreturpenjualan extends CI_Model {

	function __construct() {
		
		parent::__construct();
	}

	function ambilDataRetur($no_retur_penjualan,$periodeawal,$periodeakhir){ 
		$kd_unit_apt=$this->session->userdata('kd_unit_apt');
		if(!empty($no_retur_penjualan))$this->db->like('retur_penjualan.no_retur_penjualan',$no_retur_penjualan,'both');
		if(!empty($periodeawal))$this->db->where("date_format(date(retur_penjualan.tgl_returpenjualan),'%Y-%m-%d')>=",convertDate($periodeawal));
		if(!empty($periodeakhir))$this->db->where("date_format(date(retur_penjualan.tgl_returpenjualan),'%Y-%m-%d')<=",convertDate($periodeakhir));
		$this->db->where('retur_penjualan.kd_unit_apt',$kd_unit_apt);
		//$this->db->join('apt_penerimaan','apt_penerimaan.no_penerimaan=apt_retur_obat.no_penerimaan','left');
		$this->db->order_by('retur_penjualan.no_retur_penjualan','desc');
		
		$query=$this->db->get("retur_penjualan");		
		return $query->result_array(); 
	}
	
	function ambilStokAwal($kd_unit_apt,$value,$tgl_expire){
		//$kd_unit_apt=$this->session->userdata('kd_unit_apt');
		$query=$this->db->query("select jml_stok from apt_stok_unit where kd_unit_apt='$kd_unit_apt' and kd_obat='$value' and tgl_expire='$tgl_expire'");
		$jml_stok_awal=$query->row_array();
		//debugvar($jml_stok_asal);
		if(empty($jml_stok_awal)) return 0;
		return $jml_stok_awal['jml_stok'];
	}
	
	function isPosted($no_retur_penjualan)
	{
		$this->db->where('no_retur_penjualan',$no_retur_penjualan);
		$this->db->where('tutup',1);
		$query=$this->db->get('retur_penjualan');
		$item=$query->num_rows();
		if($item)return true;
		return false;
	}
	
	function ambilData2($kd_unit_apt,$nama_obat){ 
		$query=$this->db->query("select apt_stok_unit.kd_obat, apt_obat.nama_obat, apt_satuan_kecil.satuan_kecil,
						substring_index((apt_stok_unit.harga_pokok * apt_margin_harga.nilai_margin),'.',1) as harga_jual,substring_index(apt_stok_unit.jml_stok,'.',1) as jml_stok,
						apt_stok_unit.tgl_expire from apt_obat,apt_stok_unit,apt_unit,apt_margin_harga,apt_golongan,apt_jenis_obat,apt_satuan_kecil where 
						apt_obat.kd_satuan_kecil=apt_satuan_kecil.kd_satuan_kecil and apt_obat.kd_obat=apt_stok_unit.kd_obat 
						and apt_obat.kd_golongan=apt_golongan.kd_golongan and apt_obat.kd_jenis_obat=apt_jenis_obat.kd_jenis_obat
						and apt_stok_unit.kd_unit_apt=apt_unit.kd_unit_apt and apt_margin_harga.kd_golongan=apt_golongan.kd_golongan and apt_obat.is_aktif='1'
						and apt_margin_harga.kd_jenis_obat=apt_jenis_obat.kd_jenis_obat and apt_stok_unit.jml_stok>0 and apt_stok_unit.kd_unit_apt='$kd_unit_apt' 
						and apt_obat.nama_obat like '%$nama_obat%' order by apt_obat.kd_obat asc");
		return $query->result_array(); 			
	}
	
	function autoNumber($tahun,$bulan){ 		
		$this->db->select('max(right(no_retur_penjualan,3)) as a',false); //RET.2013.07.001
		$this->db->where('year(tgl_returpenjualan)',$tahun);
		$this->db->where('month(tgl_returpenjualan)',$bulan);
		$query=$this->db->get("retur_penjualan");
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
	
	function ambilItemDataTrans($no_retur_penjualan){
		$query=$this->db->query("select retur_penjualan.no_retur_penjualan,retur_penjualan.no_penjualan,retur_penjualan.alasan,retur_penjualan.cust_code,
						apt_customers.customer,retur_penjualan.resep,retur_penjualan.shiftapt,apt_penjualan.kd_dokter,retur_penjualan.dokter,retur_penjualan.kd_pasien,
						retur_penjualan.nama_pasien,retur_penjualan.total,retur_penjualan.jml_item_obat as jum_item_obat,date_format(retur_penjualan.tgl_returpenjualan,'%Y-%m-%d') as tgl_returpenjualan,date_format(apt_penjualan.tgl_penjualan,'%d-%m-%Y') as tgl_penjualan,
						retur_penjualan.tutup,date_format(retur_penjualan.tgl_returpenjualan,'%H:%i:%s') as jamretur from retur_penjualan,apt_customers,apt_penjualan where apt_customers.cust_code=retur_penjualan.cust_code and 
						retur_penjualan.no_penjualan=apt_penjualan.no_penjualan and retur_penjualan.no_retur_penjualan='$no_retur_penjualan'");
		return $query->row_array();
	}
	
	function ambilItemDataTrans1($no_retur_penjualan){
		$query=$this->db->query("select retur_penjualan.no_retur_penjualan,retur_penjualan.no_penjualan,retur_penjualan.alasan,retur_penjualan.cust_code,
						apt_customers.customer,retur_penjualan.resep,retur_penjualan.shiftapt,retur_penjualan.dokter,retur_penjualan.kd_pasien,
						retur_penjualan.nama_pasien,retur_penjualan.total,retur_penjualan.jml_item_obat as jum_item_obat,date_format(retur_penjualan.tgl_returpenjualan,'%d-%m-%Y') as tgl_returpenjualan,date_format(apt_penjualan.tgl_penjualan,'%d-%m-%Y') as tgl_penjualan,
						retur_penjualan.tutup,date_format(retur_penjualan.tgl_returpenjualan,'%H:%i:%s') as jamretur,apt_unit.nama_unit_apt from retur_penjualan,apt_customers,apt_penjualan,apt_unit where apt_customers.cust_code=retur_penjualan.cust_code and 
						retur_penjualan.no_penjualan=apt_penjualan.no_penjualan and retur_penjualan.no_retur_penjualan='$no_retur_penjualan' and retur_penjualan.kd_unit_apt=apt_unit.kd_unit_apt");
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
	
	function getAllDetailRetur($no_retur_penjualan){ 
		/*$query=$this->db->query("select retur_penjualan_detail.kd_obat,apt_obat.nama_obat,apt_satuan_kecil.satuan_kecil,
								retur_penjualan_detail.harga_jual,retur_penjualan_detail.qty,(retur_penjualan_detail.harga_jual*retur_penjualan_detail.qty) as totalgrid 
								from retur_penjualan,retur_penjualan_detail,apt_obat,apt_satuan_kecil where retur_penjualan.no_retur_penjualan=retur_penjualan_detail.no_retur_penjualan and
								retur_penjualan_detail.kd_obat=apt_obat.kd_obat and apt_obat.kd_satuan_kecil=apt_satuan_kecil.kd_satuan_kecil and retur_penjualan.no_retur_penjualan='$no_retur_penjualan'");*/
		$query=$this->db->query("select retur_penjualan_detail.kd_obat,apt_obat.nama_obat,apt_satuan_kecil.satuan_kecil,
								retur_penjualan_detail.harga_jual,retur_penjualan_detail.qty,retur_penjualan_detail.total as totalgrid,retur_penjualan_detail.racikan,retur_penjualan_detail.adm_resep, 
								retur_penjualan_detail.kd_unit_apt as kd_unit_apt1,(select nama_unit_apt from apt_unit where kd_unit_apt=kd_unit_apt1) as unitstok,date_format(retur_penjualan_detail.tgl_expire,'%d-%m-%Y') as tgl_expire from retur_penjualan,retur_penjualan_detail,apt_obat,apt_satuan_kecil where retur_penjualan.no_retur_penjualan=retur_penjualan_detail.no_retur_penjualan and
								retur_penjualan_detail.kd_obat=apt_obat.kd_obat and apt_obat.kd_satuan_kecil=apt_satuan_kecil.kd_satuan_kecil and retur_penjualan.no_retur_penjualan='$no_retur_penjualan'");
		return $query->result_array(); 		
	}
	
	function isNumberExist($number){
		$this->db->where('no_retur_penjualan',$number);
		$query=$this->db->get('retur_penjualan');
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
	
	function ambilData3($no_penjualan){
		$kd_unit_apt=$this->session->userdata('kd_unit_apt');
		/*$query=$this->db->query("select apt_penjualan.no_penjualan as no_penjualan1,apt_customers.customer,apt_penjualan.resep,date_format(apt_penjualan.tgl_penjualan,'%d-%m-%Y') as tgl_penjualan,apt_penjualan.shiftapt,
								apt_penjualan.dokter,apt_penjualan.kd_pasien,apt_penjualan.nama_pasien,apt_penjualan.jum_item_obat,apt_penjualan.total_transaksi,apt_penjualan.cust_code,
								(select ifnull(sum(apt_penjualan_detail.adm_resep),0) from apt_penjualan,apt_penjualan_detail
								where apt_penjualan.no_penjualan=apt_penjualan_detail.no_penjualan and apt_penjualan.no_penjualan=no_penjualan1) as adm_resep,
								(apt_penjualan.total_transaksi-(select ifnull(sum(apt_penjualan_detail.adm_resep),0) from apt_penjualan,apt_penjualan_detail
								where apt_penjualan.no_penjualan=apt_penjualan_detail.no_penjualan and apt_penjualan.no_penjualan=no_penjualan1)) as total,apt_unit.nama_unit_apt
								from apt_penjualan,apt_customers,apt_unit where apt_penjualan.cust_code=apt_customers.cust_code and
								apt_penjualan.kd_unit_apt=apt_unit.kd_unit_apt and apt_penjualan.kd_unit_apt='$kd_unit_apt' and apt_penjualan.no_penjualan like '%$no_penjualan%'");*/
		$query=$this->db->query("select apt_penjualan.no_penjualan as no_penjualan1,apt_customers.customer,apt_penjualan.resep,date_format(apt_penjualan.tgl_penjualan,'%d-%m-%Y') as tgl_penjualan,apt_penjualan.shiftapt,
								apt_penjualan.dokter,apt_penjualan.kd_pasien,apt_penjualan.nama_pasien,apt_penjualan.jum_item_obat,apt_penjualan.total_transaksi,apt_penjualan.cust_code,
								apt_penjualan.adm_racik,apt_penjualan.total_transaksi as total,apt_unit.nama_unit_apt from apt_penjualan,apt_customers,apt_unit where apt_penjualan.cust_code=apt_customers.cust_code and
								apt_penjualan.kd_unit_apt=apt_unit.kd_unit_apt and apt_penjualan.kd_unit_apt='$kd_unit_apt' and apt_penjualan.no_penjualan like '%$no_penjualan%'");
		return $query->result_array();
	}
	
	function getdetilpenjualan($no_penjualan){
		$kd_unit_apt=$this->session->userdata('kd_unit_apt');
		/*$query=$this->db->query("select apt_penjualan_detail.kd_obat,apt_obat.nama_obat,apt_satuan_kecil.satuan_kecil,
								apt_penjualan_detail.harga_jual,apt_penjualan_detail.qty,(apt_penjualan_detail.qty*apt_penjualan_detail.harga_jual) as totalgrid  
								from apt_obat,apt_satuan_kecil,apt_penjualan,
								apt_penjualan_detail,apt_unit where apt_penjualan.no_penjualan=apt_penjualan_detail.no_penjualan and 
								apt_penjualan.kd_unit_apt=apt_unit.kd_unit_apt and apt_penjualan_detail.kd_obat=apt_obat.kd_obat and 
								apt_obat.kd_satuan_kecil=apt_satuan_kecil.kd_satuan_kecil and apt_penjualan.kd_unit_apt='$kd_unit_apt' and 
								apt_penjualan.no_penjualan='$no_penjualan'");*/
		$query=$this->db->query("select apt_obat.kd_obat as kd_obat1, apt_obat.nama_obat, apt_penjualan.kd_unit_apt, apt_satuan_kecil.satuan_kecil,
								apt_penjualan_detail.harga_jual, apt_unit.nama_unit_apt, apt_milik.milik, apt_penjualan_detail.qty,ifnull(apt_obat.min_stok,0) as min_stok,apt_penjualan_detail.kd_unit_apt as kd_unit_apt1, 
								apt_penjualan_detail.racikan, apt_penjualan_detail.adm_resep,apt_penjualan_detail.racikan,apt_penjualan_detail.total as totalgrid,(select jml_stok from apt_stok_unit where kd_obat=kd_obat1 and kd_unit_apt=kd_unit_apt1) as jml_stok,
								(select nama_unit_apt from apt_unit where kd_unit_apt=kd_unit_apt1) as unitstok,date_format(apt_penjualan_detail.tgl_expire,'%d-%m-%Y') as tgl_expire from apt_obat, apt_satuan_kecil, 
								apt_stok_unit, apt_penjualan, apt_penjualan_detail, apt_milik, apt_unit where apt_obat.kd_satuan_kecil=apt_satuan_kecil.kd_satuan_kecil and apt_obat.kd_obat=apt_stok_unit.kd_obat and 
								apt_obat.kd_obat=apt_penjualan_detail.kd_obat and apt_stok_unit.kd_unit_apt=apt_penjualan_detail.kd_unit_apt and 
								apt_stok_unit.kd_milik=apt_milik.kd_milik and apt_stok_unit.kd_unit_apt=apt_unit.kd_unit_apt and 
								apt_penjualan.no_penjualan=apt_penjualan_detail.no_penjualan and apt_penjualan.no_penjualan='$no_penjualan' 
								order by apt_penjualan_detail.urut asc");
		return $query->result_array();
	}
	
	function getMaxUrutPelayanan($no_pendaftaran){
		//if(!empty($nama)) $this->db->like('nama_pasien',$nama);
		$this->db->select('max(urut) as urt');
		$this->db->where('no_pendaftaran',$no_pendaftaran);

		$this->db->join('list_pelayanan b','a.kd_pelayanan=b.kd_pelayanan');
		$this->db->group_by('no_pendaftaran');
		//$this->db->limit($limit,$offset);
		
		$query=$this->db->get("biaya_pelayanan a");
		$item = $query->row_array();
		if(empty($item)) return 0;
		return $item['urt'];
	}
	
	function ambilunit($no_pendaftaran){
		$this->db->select('kd_unit_kerja',FALSE);
		if(!empty($no_pendaftaran)) $this->db->where('no_pendaftaran',$no_pendaftaran);
		$query= $this->db->get("pendaftaran");
		$kd_unit_kerja=$query->row_array();
		return $kd_unit_kerja['kd_unit_kerja'];
	}
	
	function ambilunit1($no_pendaftaran){
		$query=$this->db->query("select kd_unit_kerja from masuk_ruangan where no_pendaftaran='$no_pendaftaran' and tgl_keluar is null");
		$kodeunitkerja=$query->row_array();
		if(empty($kodeunitkerja)) return 0;
		return $kodeunitkerja['kd_unit_kerja'];
		
	}
	
	function ambilkodejenistarif($cust_code){
		$this->db->select('kd_jenis_tarif',FALSE);
		if(!empty($cust_code)) $this->db->where('cust_code',$cust_code);
		$query= $this->db->get("tarif_customers");
		$kd_jenis_tarif=$query->row_array();
		return $kd_jenis_tarif['kd_jenis_tarif'];
	}
	
	function ambilkodekelas($no_pendaftaran){
		$this->db->select('kd_kelas',FALSE);
		if(!empty($no_pendaftaran)) $this->db->where('no_pendaftaran',$no_pendaftaran);
		$query= $this->db->get("pendaftaran");
		$kd_kelas=$query->row_array();
		return $kd_kelas['kd_kelas'];
	}
	
	function ambiltglberlaku($kd_pelayanan){
		$this->db->select('tgl_berlaku',FALSE);
		if(!empty($kd_pelayanan)) $this->db->where('kd_pelayanan',$kd_pelayanan);
		$query= $this->db->get("tarif");
		$tgl_berlaku=$query->row_array();
		if(empty($tgl_berlaku)) return '0000-00-00 00:00:00';
		return $tgl_berlaku['tgl_berlaku'];
	}
	
	function ambilkodepelayanan(){
		$kd_unit_apt=$this->session->userdata('kd_unit_apt');
		//$query=$this->db->query("select kd_pelayanan from list_pelayanan where nama_pelayanan like '%transfer%apotek%'");
		$query=$this->db->query("select kd_pelayanan from apt_unit where kd_unit_apt='$kd_unit_apt'");
		$kd_pelayanan=$query->row_array();
		return $kd_pelayanan['kd_pelayanan'];
	}
	
	function ambilpendaftaran($no_penjualan){
		$query=$this->db->query("select no_pendaftaran from apt_penjualan where no_penjualan='$no_penjualan'");
		$no_pendaftaran=$query->row_array();
		return $no_pendaftaran['no_pendaftaran'];
	}
	
	function tanggalpelayanan(){
		$query=$this->db->query("select sysdate() as tgl");
		$tglpelayanan=$query->row_array();
		return $tglpelayanan['tgl'];
	}
	
	function ambilparent($kd_unit_kerja){
		$query=$this->db->query("select parent from unit_kerja where kd_unit_kerja='$kd_unit_kerja'");
		$parent=$query->row_array();
		if(empty($parent)) return 0;
		return $parent['parent'];
	}
	
	function ambilNama($value){
		$query=$this->db->query("select nama_obat from apt_obat where kd_obat='$value'");
		$nama=$query->row_array();
		if(empty($nama))return '-';
		return $nama['nama_obat'];
	}
	
}
	
?>