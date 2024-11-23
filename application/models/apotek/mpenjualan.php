<?



class Mpenjualan extends CI_Model {

	function __construct() {
		
		parent::__construct();
	}

	function jasamedis(){
		$query=$this->db->query("select sum(setting) as jasamedis from sys_setting where key_data in('JASA_MEDIS','BIAYA_ADM','BIAYA_KARTU') ");
		$item=$query->row_array();
		if (empty($item))return 0;
		return $item['jasamedis'];
	}

	function nilaijasamedis(){
		$query=$this->db->query("select sum(setting) as jasamedis from sys_setting where key_data in('JASA_MEDIS') ");
		$item=$query->row_array();
		if (empty($item))return 0;
		return $item['jasamedis'];
	}

	function nilaibiayakartu(){
		$query=$this->db->query("select sum(setting) as jasamedis from sys_setting where key_data in('BIAYA_KARTU') ");
		$item=$query->row_array();
		if (empty($item))return 0;
		return $item['jasamedis'];
	}

	function nilaibiayaadm(){
		$query=$this->db->query("select sum(setting) as jasamedis from sys_setting where key_data in('BIAYA_ADM') ");
		$item=$query->row_array();
		if (empty($item))return 0;
		return $item['jasamedis'];
	}

	function ambilDataPenjualan($no_penjualan,$kd_unit_apt,$periodeawal,$periodeakhir){
		$this->db->select("apt_penjualan.no_penjualan,date_format(apt_penjualan.tgl_penjualan,'%Y-%m-%d') as tgl_penjualan,jenis_pasien.jenis,apt_penjualan.tutup,apt_penjualan.nama_pasien,apt_penjualan.total_transaksi",FALSE);
		if(!empty($no_penjualan))$this->db->like('apt_penjualan.no_penjualan',$no_penjualan,'both');
		if(!empty($periodeawal))$this->db->where("date_format(date(apt_penjualan.tgl_penjualan),'%Y-%m-%d')>=",convertDate($periodeawal));
		if(!empty($periodeakhir))$this->db->where("date_format(date(apt_penjualan.tgl_penjualan),'%Y-%m-%d')<=",convertDate($periodeakhir));
		//$this->db->join('jenis_pasien','jenis_pasien.kd_jenis_pasien=apt_penjualan.cust_code','left');
		$this->db->join('pasien_asp','pasien_asp.id_asp=apt_penjualan.kd_pasien','left');
		$this->db->join('jenis_pasien','jenis_pasien.kd_jenis_pasien=pasien_asp.kd_jenis_pasien','left');
		$this->db->order_by('apt_penjualan.no_penjualan','desc');
		$query=$this->db->get("apt_penjualan");		
		return $query->result_array(); 
	}
	
	function ambilDataPenjualan1($no_penjualan,$kd_unit_apt,$periodeawal,$periodeakhir){
		
		$this->db->select("apt_penjualan.no_penjualan,date_format(apt_penjualan.tgl_penjualan,'%Y-%m-%d') as tgl_penjualan,apt_customers.customer,apt_penjualan.tutup,apt_penjualan.nama_pasien,apt_penjualan.total_transaksi",FALSE);
		if(!empty($no_penjualan))$this->db->like('apt_penjualan.no_penjualan',$no_penjualan,'both');
	
		if(!empty($periodeawal))$this->db->where("date_format(date(apt_penjualan.tgl_penjualan),'%Y-%m-%d')>=",convertDate($periodeawal));
		if(!empty($periodeakhir))$this->db->where("date_format(date(apt_penjualan.tgl_penjualan),'%Y-%m-%d')<=",convertDate($periodeakhir));
		$this->db->join('apt_customers','apt_customers.cust_code=apt_penjualan.cust_code','left');
		$this->db->order_by('apt_penjualan.no_penjualan','desc');
		
		$query=$this->db->get("apt_penjualan");		
		return $query->result_array(); 
	}
	
	
	
	
	function ambilItemData3($kd_unit_apt,$value){
		$kd_unit_apt=$this->session->userdata('kd_unit_apt');
		$this->db->select('harga_pokok',FALSE);
		if(!empty($kd_unit_apt)) $this->db->where('kd_unit_apt',$kd_unit_apt);
		if(!empty($value)) $this->db->where('kd_obat',$value);
		$query= $this->db->get("apt_stok_unit");
		$harga_pokok=$query->row_array();
		return $harga_pokok['harga_pokok'];
	}
	
	function ambilUrut($no_penjualan){
		$this->db->select('urut_bayar',FALSE);
		if(!empty($no_penjualan)) $this->db->where('no_penjualan',$no_penjualan);
		$this->db->order_by('urut_bayar','desc');
		$query= $this->db->get("apt_penjualan_bayar");
		$no=$query->row_array();
		if(empty($no))return 0;
		return $no['urut_bayar'];
	}
	
	/*function ambilUrutbiaya($no_pendaftaran){
		$this->db->select('urut',FALSE);
		if(!empty($no_pendaftaran)) $this->db->where('no_pendaftaran',$no_pendaftaran);
		$query= $this->db->get("biaya_pelayanan");
		$urut=$query->row_array();
		return $urut['urut'];
	}*/
	
	function ambilkodecomponent($kd_jenis_tarif,$kd_pelayanan,$kd_kelas){
		$this->db->select('kd_component',FALSE);
		if(!empty($kd_jenis_tarif)) $this->db->where('kd_jenis_tarif',$kd_jenis_tarif);
		if(!empty($kd_pelayanan)) $this->db->where('kd_pelayanan',$kd_pelayanan);
		if(!empty($kd_kelas)) $this->db->where('kd_kelas',$kd_kelas);
		$query= $this->db->get("tarif_component");
		$kd_component=$query->row_array();
		return $kd_component['kd_component'];
	}
	
	function ambilUrutbiayacomponent($no_pendaftaran){
		$this->db->select('urut',FALSE);
		if(!empty($no_pendaftaran)) $this->db->where('no_pendaftaran',$no_pendaftaran);
		$query= $this->db->get("biaya_pelayanan_component");
		$urut1=$query->row_array();
		return $urut1['urut'];
	}
	
	function ambilunit($no_pendaftaran){
		/*$this->db->select('kd_unit_kerja',FALSE);
		if(!empty($no_pendaftaran)) $this->db->where('no_pendaftaran',$no_pendaftaran);
		$query= $this->db->get("pendaftaran");
		$kd_unit_kerja=$query->row_array();
		return $kd_unit_kerja['kd_unit_kerja'];*/
		//$query=$this->db->query("select kd_unit_kerja from masuk_ruangan where no_pendaftaran='$no_pendaftaran' and tgl_keluar is null");
		$query=$this->db->query("select kd_unit_kerja from pendaftaran where no_pendaftaran='$no_pendaftaran'");
		$kd_unit_kerja=$query->row_array();
		if(empty($kd_unit_kerja)) return 0;
		return $kd_unit_kerja['kd_unit_kerja'];
	}
	
	function ambilunit1($no_pendaftaran){
		//$this->db->select('kd_unit_kerja',FALSE);
		//if(!empty($no_pendaftaran)) $this->db->where('no_pendaftaran',$no_pendaftaran);
		//$query= $this->db->get("masuk_ruangan");
		//$kodeunitkerja=$query->row_array();
		//if(empty($kodeunitkerja)) return 0;
		//return $kodeunitkerja['kd_unit_kerja'];
		$query=$this->db->query("select kd_unit_kerja from masuk_ruangan where no_pendaftaran='$no_pendaftaran' and tgl_keluar is null");
		$kodeunitkerja=$query->row_array();
		if(empty($kodeunitkerja)) return 0;
		return $kodeunitkerja['kd_unit_kerja'];
		
	}
	
	function ambilkodejenistarif($cust_code){
		$this->db->select('kd_jenis_tarif');
		//if(!empty($cust_code)) $this->db->where('cust_code',$cust_code);
		$this->db->where('cust_code',$cust_code);
		$query= $this->db->get("tarif_customers");
		$kd_jenis_tarif=$query->row_array();
		return $kd_jenis_tarif['kd_jenis_tarif'];
	}
	
	/*function ambilkodekelas($no_pendaftaran){
		$this->db->select('kd_kelas');
		if(!empty($no_pendaftaran)) $this->db->where('no_pendaftaran',$no_pendaftaran);
		$query= $this->db->get("pendaftaran");
		$kd_kelas=$query->row_array();
		return $kd_kelas['kd_kelas'];
	}*/
	
	function ambilkodekelas($no_pendaftaran){
		$query=$this->db->query("select kd_kelas from pendaftaran where no_pendaftaran='$no_pendaftaran'");
		$kd_kelas=$query->row_array();
		if(empty($kd_kelas)) return 0;
		return $kd_kelas['kd_kelas'];
	}
	
	function ambiltglberlaku($kd_pelayanan){
		$this->db->select('tgl_berlaku');
		if(!empty($kd_pelayanan)) $this->db->where('kd_pelayanan',$kd_pelayanan);
		$query= $this->db->get("tarif");
		$tgl_berlaku=$query->row_array();
		if(empty($tgl_berlaku)) return 0;
		return $tgl_berlaku['tgl_berlaku'];
	}
	
	function ambilkodepelayanan(){
		$kd_unit_apt=$this->session->userdata('kd_unit_apt');
		//$query=$this->db->query("select kd_pelayanan from list_pelayanan where nama_pelayanan like '%transfer%apotek%'");
		$query=$this->db->query("select kd_pelayanan from apt_unit where kd_unit_apt='$kd_unit_apt'");
		$kd_pelayanan=$query->row_array();
		return $kd_pelayanan['kd_pelayanan'];
	}
	
	function ambilKodeUnit($no_penjualan){
		$this->db->select('kd_unit_apt',FALSE);
		if(!empty($no_penjualan)) $this->db->where('no_penjualan',$no_penjualan);
		$query= $this->db->get("apt_penjualan");
		$kd_unit_apt=$query->row_array();
		return $kd_unit_apt['kd_unit_apt'];
	}
	
	function ambilStok($kd_unit_apt,$value,$tgl_expire,$kd_pabrik="",$batch="",$harga=""){
		$this->db->select('jml_stok',FALSE);
		if(!empty($kd_unit_apt)) $this->db->where('kd_unit_apt',$kd_unit_apt);
		if(!empty($value)) $this->db->where('kd_obat',$value);
		if(!empty($tgl_expire)) $this->db->where('tgl_expire',$tgl_expire);
		if(!empty($kd_pabrik)) $this->db->where('kd_pabrik',$kd_pabrik);
		if(!empty($batch)) $this->db->where('batch',$batch);
		if(!empty($harga)) $this->db->where('harga_pokok',$harga);
		$query= $this->db->get("apt_stok_unit");
		$jml_stok=$query->row_array();
		if(empty($jml_stok)) return 0;
		return $jml_stok['jml_stok'];
	}
	
	function jenisbayar($no_penjualan){
		$this->db->select('kd_jenis_bayar',FALSE);
		if(!empty($no_penjualan)) $this->db->where('no_penjualan',$no_penjualan);
		$query= $this->db->get("apt_penjualan_bayar");
		$id_bayar=$query->row_array();
		if(empty($id_bayar)) return 0;
		return $id_bayar['kd_jenis_bayar'];
	}

	function isPosted($no_penjualan)
	{
		$this->db->where('no_penjualan',$no_penjualan);
		$this->db->where('tutup',1);
		$query=$this->db->get('apt_penjualan');
		$item=$query->num_rows();
		if($item)return true;
		return false;
	}

	function isSaved($no_penjualan)
	{
		$this->db->where('no_penjualan',$no_penjualan);
		$query=$this->db->get('apt_penjualan');
		$item=$query->num_rows();
		if($item)return true;
		return false;
	}

	function isPosted1($no_penjualan)
	{
		$this->db->where('no_penjualan',$no_penjualan);
		$this->db->where('is_lunas',1);
		$query=$this->db->get('apt_penjualan');
		$item=$query->num_rows();
		if($item)return true;
		return false;
	}
	
	/*function cek($no_penjualan){
		$query=$this->db->query("select count(*) as cek from apt_penjualan_bayar where no_penjualan='no_penjualan'");
		$a=$query->row_array();
		if(empty($a)) return 0;
		return $a['cek']; 
	}*/
	
	function ngecek($no_penjualan)
	{
		$this->db->where('no_penjualan',$no_penjualan);
		//$this->db->where('tutup',1);
		$query=$this->db->get('apt_penjualan');
		$item=$query->num_rows();
		if($item)return true;
		return false;
	}
	
	function ambilTotal($no_penjualan){
		$query=$this->db->query("select sum(total) as totalsum from apt_penjualan_bayar where no_penjualan='$no_penjualan'");
		$itembayarform=$query->row_array();
		if(empty($itembayarform)) return 0;
		return $itembayarform['totalsum']; 	
	}
	
	function ambilTotalBayar($no_penjualan){
		$this->db->select('SUM(total) as total_bayar');
		$this->db->where('no_penjualan',$no_penjualan);
		$query = $this->db->get('apt_penjualan_bayar');
		$jumbayar=$query->row_array();
		if(empty($jumbayar))return 0;
		return $jumbayar['total_bayar'];
	}
	
	function ambilData2($kd_unit_apt,$nama_obat){ 
		//if($this->session->userdata('kd_lokasi')!=$this->session->userdata('kd_lokasi_gudang')) {
			$kd_unit_apt=$this->session->userdata('kd_unit_apt');
			//if(!empty($kd_lokasi))$this->db->where('log_request_order.kd_lokasi',$kd_lokasi);
		//}
		
		$query=$this->db->query("select apt_stok_unit.kd_obat, apt_obat.nama_obat, apt_satuan_kecil.satuan_kecil, date_format(apt_stok_unit.tgl_expire,'%d-%m-%Y') as tgl_expire,
						(apt_stok_unit.harga_pokok * apt_margin_harga.nilai_margin) as harga_jual,apt_stok_unit.jml_stok,ifnull(apt_obat.min_stok,0) as min_stok
						from apt_obat,apt_stok_unit,apt_unit,apt_margin_harga,apt_golongan,apt_jenis_obat,apt_satuan_kecil where 
						apt_obat.kd_satuan_kecil=apt_satuan_kecil.kd_satuan_kecil and apt_obat.kd_obat=apt_stok_unit.kd_obat 
						and apt_obat.kd_golongan=apt_golongan.kd_golongan and apt_obat.kd_jenis_obat=apt_jenis_obat.kd_jenis_obat
						and apt_stok_unit.kd_unit_apt=apt_unit.kd_unit_apt and apt_margin_harga.kd_golongan=apt_golongan.kd_golongan and apt_obat.is_aktif='1'
						and apt_margin_harga.kd_jenis_obat=apt_jenis_obat.kd_jenis_obat and apt_stok_unit.jml_stok>0 and apt_stok_unit.kd_unit_apt='$kd_unit_apt' 
						and apt_obat.nama_obat like '%$nama_obat%' order by apt_obat.kd_obat asc");
		return $query->result_array(); 			
	}
	
	function ambilDatakode($kd_unit_apt,$kd_obat){ 
		//if($this->session->userdata('kd_lokasi')!=$this->session->userdata('kd_lokasi_gudang')) {
			$kd_unit_apt=$this->session->userdata('kd_unit_apt');
			//if(!empty($kd_lokasi))$this->db->where('log_request_order.kd_lokasi',$kd_lokasi);
		//}
		
		$query=$this->db->query("select apt_stok_unit.kd_obat, apt_obat.nama_obat, apt_satuan_kecil.satuan_kecil, date_format(apt_stok_unit.tgl_expire,'%d-%m-%Y') as tgl_expire,
						(apt_stok_unit.harga_pokok * apt_margin_harga.nilai_margin) as harga_jual,apt_stok_unit.jml_stok,ifnull(apt_obat.min_stok,0) as min_stok
						from apt_obat,apt_stok_unit,apt_unit,apt_margin_harga,apt_golongan,apt_jenis_obat,apt_satuan_kecil where 
						apt_obat.kd_satuan_kecil=apt_satuan_kecil.kd_satuan_kecil and apt_obat.kd_obat=apt_stok_unit.kd_obat 
						and apt_obat.kd_golongan=apt_golongan.kd_golongan and apt_obat.kd_jenis_obat=apt_jenis_obat.kd_jenis_obat
						and apt_stok_unit.kd_unit_apt=apt_unit.kd_unit_apt and apt_margin_harga.kd_golongan=apt_golongan.kd_golongan and apt_obat.is_aktif='1'
						and apt_margin_harga.kd_jenis_obat=apt_jenis_obat.kd_jenis_obat and apt_stok_unit.jml_stok>0 and apt_stok_unit.kd_unit_apt='$kd_unit_apt' 
						and apt_obat.kd_obat like '%$kd_obat%' order by apt_obat.kd_obat asc");
		return $query->result_array(); 			
	}
	
	function autoNumber($tahun,$bulan){ 	//P.2013.08.00001	
		$this->db->select('max(right(no_penjualan,5)) as a',false);
		$this->db->where('MID(no_penjualan,3,4)',$tahun);
		$this->db->where('mid(no_penjualan,8,2)',$bulan);
		$query=$this->db->get("apt_penjualan");
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
	
	function getAllDetailPenjualan($no_penjualan){ 
		$query=$this->db->query("select apt_obat.kd_obat, 
								apt_obat.nama_obat, 
								apt_penjualan_detail.kd_unit_apt, 
								apt_satuan_kecil.satuan_kecil, 
								date_format(apt_penjualan_detail.tgl_expire,'%d-%m-%Y') as tgl_expire, 
								apt_penjualan_detail.harga_jual, 
								apt_unit.nama_unit_apt,  
								apt_penjualan_detail.qty,ifnull(apt_obat.min_stok,0) as min_stok, 
								apt_penjualan_detail.racikan, 
								apt_penjualan_detail.adm_resep,
								apt_penjualan_detail.racikan,
								apt_penjualan_detail.total,
								apt_penjualan_detail.kd_pabrik,
								apt_penjualan_detail.batch,
								apt_penjualan_detail.harga_jual,
								apt_stok_unit.jml_stok from apt_obat, 
								apt_satuan_kecil, 
								apt_stok_unit, 
								apt_penjualan, apt_penjualan_detail, 
								apt_unit 
								where 
								apt_obat.kd_satuan_kecil=apt_satuan_kecil.kd_satuan_kecil 
								and apt_obat.kd_obat=apt_stok_unit.kd_obat 
								and apt_obat.kd_obat=apt_penjualan_detail.kd_obat and 
								apt_stok_unit.kd_unit_apt=apt_penjualan_detail.kd_unit_apt 
								and apt_stok_unit.kd_obat=apt_penjualan_detail.kd_obat  
								and apt_stok_unit.kd_unit_apt=apt_unit.kd_unit_apt 
								and apt_penjualan_detail.kd_unit_apt=apt_stok_unit.kd_unit_apt 
								and apt_penjualan_detail.kd_obat=apt_stok_unit.kd_obat  
								and apt_penjualan_detail.kd_pabrik=apt_stok_unit.kd_pabrik 
								and apt_penjualan_detail.tgl_expire=apt_stok_unit.tgl_expire 
								and apt_penjualan_detail.harga_pokok=apt_stok_unit.harga_pokok 
								and apt_penjualan_detail.batch=apt_stok_unit.batch 
								and apt_penjualan.no_penjualan=apt_penjualan_detail.no_penjualan 
								and apt_penjualan.no_penjualan='$no_penjualan' 
								order by apt_obat.kd_obat asc");
		return $query->result_array(); 		
	}
	
	function ambilItemDataPenjualan($no_penjualan){
		$query=$this->db->query("select no_penjualan, date_format(tgl_penjualan,'%Y-%m-%d') as tgl_penjualan,
								date_format(tgl_penjualan,'%H:%i:%s') as jampenjualan,kd_unit_apt,cust_code,resep,shiftapt,berdasarkan,nomor_surat,
								no_resep,kd_dokter,dokter,kd_pasien,nama_pasien,discount,total_transaksi,total_bayar,adm_racik,adm_resep,adm_tuslah,jasa_medis,
								jum_item_obat,is_lunas,tutup,returapt,no_pendaftaran,bhp,kd_unit_apt from apt_penjualan where no_penjualan='$no_penjualan'");
		return $query->row_array();
	}
	
	function getAllDataPembayaran($no_penjualan){
		$query=$this->db->query("select date_format(apt_penjualan_bayar.tgl_bayar,'%d-%m-%Y') as tgl_bayar,apt_penjualan_bayar.kd_jenis_bayar,apt_jenis_bayar.jenis_bayar,apt_penjualan_bayar.total from apt_penjualan,apt_penjualan_bayar,apt_jenis_bayar
								 where apt_penjualan_bayar.no_penjualan=apt_penjualan.no_penjualan and apt_jenis_bayar.kd_jenis_bayar=apt_penjualan_bayar.kd_jenis_bayar and
								 apt_penjualan.no_penjualan='$no_penjualan'");
		return $query->result_array();
	}

	function isNumberExist($number){
		$this->db->where('no_penjualan',$number);
		$query=$this->db->get('apt_penjualan');
		$count=$query->num_rows();
		if($count){
			return true;
		}
		return false;
	}
	
	function cek($number){
		$this->db->where('no_penjualan',$number);
		$query=$this->db->get('apt_penjualan_bayar');
		$count=$query->num_rows();
		if($count){
			return true;
		}
		return false;
	}
	
	function countObat($number){
		$this->db->select('count(kd_obat) as count');
		$this->db->where('no_penjualan',$number);
		$query=$this->db->get('apt_penjualan_detail');
		$count=$query->row_array();
		return $count['count'];
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
	
	function getPenjualan($no_penjualan){
		$this->db->select("apt_penjualan.no_penjualan,apt_penjualan.resep,apt_penjualan.bhp,apt_penjualan.is_lunas,
							date_format(apt_penjualan.tgl_penjualan,'%d-%m-%Y') as tgl_penjualan,apt_penjualan.shiftapt,
							apt_penjualan.tutup,apt_penjualan.nama_pasien,apt_penjualan.adm_resep,
							apt_unit.nama_unit_apt,jenis_pasien.jenis,apt_penjualan.total_transaksi,dokter.nm_dokter,
							apt_penjualan.total_bayar",FALSE);
		if(!empty($no_penjualan))$this->db->like('apt_penjualan.no_penjualan',$no_penjualan,'both');
		$this->db->join('apt_unit','apt_penjualan.kd_unit_apt=apt_unit.kd_unit_apt','left');
		//$this->db->join('jenis_pasien','apt_penjualan.cust_code=jenis_pasien.kd_jenis_pasien','left');
		$this->db->join('pasien_asp','apt_penjualan.kd_pasien=pasien_asp.id_asp','left');
		$this->db->join('dokter','pasien_asp.kd_dokter=dokter.kd_dokter','left');
		$this->db->join('jenis_pasien','jenis_pasien.kd_jenis_pasien=pasien_asp.kd_jenis_pasien','left');
		
		$query=$this->db->get("apt_penjualan");
		return $query->row_array();
	}

	function getPenjualanWithPuskesmas($no_penjualan){
		$this->db->select("apt_penjualan.no_penjualan,apt_penjualan.resep,apt_penjualan.bhp,apt_penjualan.is_lunas,
							date_format(apt_penjualan.tgl_penjualan,'%d-%m-%Y') as tgl_penjualan,apt_penjualan.shiftapt,
							apt_penjualan.tutup,apt_penjualan.nama_pasien,apt_penjualan.adm_resep,apt_penjualan.jenis_sbbk,
							apt_unit.nama_unit_apt,jenis_pasien.jenis,apt_penjualan.total_transaksi,dokter.nm_dokter,
							apt_penjualan.total_bayar, gfk_puskesmas.nama as nama_puskesmas, apt_penjualan.no_sbbk, apt_penjualan.user_id,apt_penjualan.berdasarkan,apt_penjualan.nomor_surat,gfk_puskesmas.kode as kode_puskesmas,kd_jenis_transaksi,no_penerimaan_simo",FALSE);
		if(!empty($no_penjualan))$this->db->like('apt_penjualan.no_penjualan',$no_penjualan,'both');
		$this->db->join('apt_unit','apt_penjualan.kd_unit_apt=apt_unit.kd_unit_apt','left');
		//$this->db->join('jenis_pasien','apt_penjualan.cust_code=jenis_pasien.kd_jenis_pasien','left');
		$this->db->join('pasien_asp','apt_penjualan.kd_pasien=pasien_asp.id_asp','left');
		$this->db->join('dokter','pasien_asp.kd_dokter=dokter.kd_dokter','left');
		$this->db->join('jenis_pasien','jenis_pasien.kd_jenis_pasien=pasien_asp.kd_jenis_pasien','left');
		$this->db->join('gfk_puskesmas', 'gfk_puskesmas.id = apt_penjualan.customer_id', 'left');
		
		$query=$this->db->get("apt_penjualan");
		return $query->row_array();
	}
	
	function ambilNama($value){
		$query=$this->db->query("select nama_obat from apt_obat where kd_obat='$value'");
		$nama=$query->row_array();
		return $nama['nama_obat'];
	}
	
	function ambilparent($kd_unit_kerja){
		$query=$this->db->query("select parent from unit_kerja where kd_unit_kerja='$kd_unit_kerja'");
		$parent=$query->row_array();
		if(empty($parent)) return 0;
		return $parent['parent'];
	}
	
	function ambilData3($kd_dokter){
		$query=$this->db->query("select kd_dokter,nama_dokter as dokter from apt_dokter where kd_dokter like '%$kd_dokter%'");
		return $query->result_array();
	}
	
	function ambilData4($dokter){
		$query=$this->db->query("select kd_dokter,nama_dokter as dokter from apt_dokter where nama_dokter like '%$dokter%'");
		return $query->result_array();
	}
	
	function ambilDataPasien($nama_pasien,$kd_unit_kerja,$tgl_entry){ 
			$query=$this->db->query("select pasien_asp.id_asp,
									pasien_asp.kd_pasien,
									master_pasien.no_reg,
									replace(master_pasien.nama_pasien,\"'\",'') as nama_pasien,
									pasien_asp.tanggal,
									pasien_asp.kd_unit,
									unit.nm_unit,
									pasien_asp.no_daftar   
									from pasien_asp,
									master_pasien, 
									unit 
									where 
									pasien_asp.kd_pasien=master_pasien.kd_pasien and   
									date_format(pasien_asp.tanggal,'%Y-%m-%d') like '$tgl_entry%' and  
									master_pasien.nama_pasien like '%$nama_pasien%' and 
									unit.kd_unit=pasien_asp.kd_unit
									");
		
		return $query->result_array();
	}
	
	function getMaxUrutPelayanan($no_pendaftaran){
		
		$this->db->select('max(urut) as urt');
		$this->db->where('no_pendaftaran',$no_pendaftaran);
		$this->db->join('list_pelayanan b','a.kd_pelayanan=b.kd_pelayanan');
		$this->db->group_by('no_pendaftaran');
		$query=$this->db->get("biaya_pelayanan a");
		$item = $query->row_array();
		if(empty($item)) return 0;
		return $item['urt'];

	}
	
	function ambilJasaBungkus(){
		$query=$this->db->query("select setting as jasabungkus from sys_setting where key_data='TARIF_PERBUNGKUS'");
		$itembungkus = $query->row_array();
		if(empty($itembungkus)) return 0;
		return $itembungkus['jasabungkus'];
	}
	
	function getdetil($no_penjualan){
		$query=$this->db->query("select apt_obat.nama_obat,apt_penjualan_detail.harga_jual,apt_penjualan_detail.qty,(apt_penjualan_detail.qty*apt_penjualan_detail.harga_jual) as total
								from apt_penjualan,apt_penjualan_detail,apt_obat where apt_penjualan.no_penjualan=apt_penjualan_detail.no_penjualan and 
								apt_penjualan_detail.kd_obat=apt_obat.kd_obat and apt_penjualan.no_penjualan='$no_penjualan'");
		return $query->result_array();
	}
	
	function ambilnamauser(){
		$kd_user=$this->session->userdata('id_user');
		$query=$this->db->query("select pegawai.nama_pegawai from user,pegawai where user.id_pegawai=pegawai.id_pegawai and user.id_user='$kd_user'");
		$user = $query->row_array();
		if(empty($user)) return "-";
		return $user['nama_pegawai'];
	}

	function ambilDataObatKeluar($no_sbbk,$periodeawal,$periodeakhir,$id_puskesmas="",$kd_jenis_transaksi=""){
		$query = "select pj.no_penjualan,jt.nama, date_format(pj.tgl_penjualan, '%Y-%m-%d') as tgl_penjualan, 
pj.no_sbbk, pc.id as id_puskesmas, 
pc.nama as puskesmas, pj.tutup , pj.kirim
from apt_penjualan pj 
JOIN gfk_puskesmas pc ON pj.customer_id = pc.id ";
		if(!empty($periodeawal)) {
			$query .= "AND date_format(date(pj.tgl_penjualan), '%Y-%m-%d') >= '" . convertDate($periodeawal) . "' ";
		}
		if(!empty($periodeakhir)) {
			$query .= "AND date_format(date(pj.tgl_penjualan), '%Y-%m-%d') <= '" . convertDate($periodeakhir) . "' ";
		} 
		if(!empty($no_sbbk)) {
			$query .= "AND pj.no_sbbk LIKE '%" . $no_sbbk . "%' ";
		}
		if(!empty($id_puskesmas)) {
			$query .= "AND pj.customer_id = '" . $id_puskesmas . "' ";
		}
		if(!empty($kd_jenis_transaksi)) {
			$query .= "AND pj.kd_jenis_transaksi = '" . $kd_jenis_transaksi . "' ";
		}
		$query .= ' LEFT JOIN jenis_transaksi jt ON pj.kd_jenis_transaksi = jt.kode  ORDER BY pj.no_penjualan DESC  ';
		// $query .= ' ORDER BY pj.no_penjualan DESC  ';
		
		return $this->db->query($query)->result_array(); 
	}

	function updatekirim($no_penjualan){
		$this->db->update('apt_penjualan',array('tanggal_kirim'=>date('Y-m-d H:i:s')),array('no_penjualan'=>$no_penjualan));
	}
	function ambilItemDataObatKeluar($no_penjualan){
		$query=$this->db->query("select no_penjualan, date_format(tgl_penjualan,'%Y-%m-%d') as tgl_penjualan,berdasarkan,nomor_surat,jenis_sbbk,
								date_format(tgl_penjualan,'%H:%i:%s') as jampenjualan,kd_unit_apt,cust_code,resep,shiftapt,
								no_resep,kd_dokter,dokter,customer_id,discount,total_transaksi,total_bayar,adm_racik,adm_resep,adm_tuslah,jasa_medis,
								jum_item_obat,is_lunas,tutup,returapt,no_pendaftaran,bhp,no_sbbk,kd_jenis_transaksi,kirim from apt_penjualan where no_penjualan='$no_penjualan'");
		return $query->row_array();
	}

	function getAllDetailObatKeluar($no_penjualan){ 
		$query=$this->db->query(
			"select apt_obat.kd_obat, 
			apt_obat.nama_obat, 
			apt_penjualan_detail.kd_unit_apt, 
			apt_satuan_kecil.satuan_kecil, 
			date_format(apt_penjualan_detail.tgl_expire,'%d-%m-%Y') as tgl_expire, 
			round(apt_penjualan_detail.harga_jual) as harga_jual, 
			apt_unit.nama_unit_apt,  
			apt_penjualan_detail.qty,ifnull(apt_obat.min_stok,0) as min_stok, 
			apt_penjualan_detail.racikan, 
			apt_penjualan_detail.adm_resep,
			apt_penjualan_detail.racikan,
			apt_penjualan_detail.total,
			apt_penjualan_detail.kd_pabrik,
			apt_penjualan_detail.batch,
			date_format(apt_penjualan_detail.tgl_keluar, '%d-%m-%Y') as tgl_keluar, 
			apt_stok_unit.jml_stok from apt_obat, 
			apt_satuan_kecil, 
			apt_stok_unit, 
			apt_penjualan, apt_penjualan_detail, 
			apt_unit 
			where 
			apt_obat.kd_satuan_kecil=apt_satuan_kecil.kd_satuan_kecil 
			and apt_obat.kd_obat=apt_stok_unit.kd_obat 
			and apt_obat.kd_obat=apt_penjualan_detail.kd_obat and 
			apt_penjualan_detail.kd_unit_apt=apt_stok_unit.kd_unit_apt 
			and apt_penjualan_detail.kd_obat=apt_stok_unit.kd_obat  
			and apt_penjualan_detail.kd_pabrik=apt_stok_unit.kd_pabrik 
			and apt_penjualan_detail.tgl_expire=apt_stok_unit.tgl_expire 
			and apt_penjualan_detail.harga_pokok=apt_stok_unit.harga_pokok 
			and apt_penjualan_detail.batch=apt_stok_unit.batch 
			and apt_stok_unit.kd_unit_apt=apt_unit.kd_unit_apt 
			and apt_penjualan.no_penjualan=apt_penjualan_detail.no_penjualan 
			and apt_penjualan.no_penjualan='$no_penjualan' 
			order by urut asc");
		return $query->result_array();
	}

	function getAllDetailObatKeluar2($no_penjualan){ 
		$query=$this->db->query(
			"select apt_obat.kd_obat, 
			apt_obat.nama_obat, 
			apt_penjualan_detail.kd_unit_apt, 
			apt_satuan_kecil.satuan_kecil, 
			date_format(apt_penjualan_detail.tgl_expire,'%d-%m-%Y') as tgl_expire, 
			apt_penjualan_detail.harga_jual, 
			apt_unit.nama_unit_apt,  
			apt_penjualan_detail.qty,
			apt_obat.isi_kemasan,
			apt_penjualan_detail.qty_kecil,
			ifnull(apt_obat.min_stok,0) as min_stok, 
			apt_penjualan_detail.racikan, 
			apt_penjualan_detail.adm_resep,
			apt_penjualan_detail.harga_pokok,
			apt_penjualan_detail.kd_milik,
			apt_penjualan_detail.racikan,
			apt_penjualan_detail.total,
			apt_penjualan_detail.kd_pabrik,
			apt_penjualan_detail.batch,
			date_format(apt_penjualan_detail.tgl_keluar, '%d-%m-%Y') as tgl_keluar, 
			apt_stok_unit.jml_stok from apt_obat, 
			apt_satuan_kecil, 
			apt_stok_unit, 
			apt_penjualan, apt_penjualan_detail, 
			apt_unit 
			where 
			apt_obat.kd_satuan_kecil=apt_satuan_kecil.kd_satuan_kecil 
			and apt_obat.kd_obat=apt_stok_unit.kd_obat 
			and apt_obat.kd_obat=apt_penjualan_detail.kd_obat and 
			apt_penjualan_detail.kd_unit_apt=apt_stok_unit.kd_unit_apt 
			and apt_penjualan_detail.kd_obat=apt_stok_unit.kd_obat  
			and apt_penjualan_detail.kd_pabrik=apt_stok_unit.kd_pabrik 
			and apt_penjualan_detail.tgl_expire=apt_stok_unit.tgl_expire 
			and apt_penjualan_detail.harga_pokok=apt_stok_unit.harga_pokok 
			and apt_penjualan_detail.batch=apt_stok_unit.batch 
			and apt_stok_unit.kd_unit_apt=apt_unit.kd_unit_apt 
			and apt_penjualan.no_penjualan=apt_penjualan_detail.no_penjualan 
			and apt_penjualan.no_penjualan='$no_penjualan' 
			order by urut asc");
		return $query->result_array();
	}

	function getTotalPenjualan($no_penjualan){
		$query=$this->db->query('select sum(qty*harga_jual) as total from apt_penjualan_detail where no_penjualan="'.$no_penjualan.'" ');
		$res=$query->row_array();
		if(empty($res))return 0;
		return $res['total']; 
	}
}
	
?>