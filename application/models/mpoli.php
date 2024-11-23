<?



//include_once(APPPATH.'models/mutility.php');
include_once(APPPATH.'models/master/munit.php');

class Mpoli extends Munit {

	function __construct() {
		
		parent::__construct();
		$unit=$this->session->userdata('poli');
		parent::setUnit($unit);
	}

    function insertbiayapelayanancomponent($kd_kasir,$no_pendaftaran,$urut,$kd_jenis_tarif,$kd_pelayanan,$kd_kelas,$tgl_berlaku) {
		$this->db->query('insert into biaya_pelayanan_component select "'.$kd_kasir.'","'.$no_pendaftaran.'","'.$urut.'",kd_component,tarif_component,0,0 from tarif_component where kd_jenis_tarif="'.$kd_jenis_tarif.'" and kd_pelayanan="'.$kd_pelayanan.'" and kd_kelas="'.$kd_kelas.'" and tgl_berlaku="'.$tgl_berlaku.'"');
		return true;
    }	

	function isDiagnosaLama($kd_pasien,$kd_sub_icd)
	{
		$this->db->where('kd_pasien',$kd_pasien);
		$this->db->where('kd_sub_icd',$kd_sub_icd);
		$query=$this->db->get('periksa_diagnosa');
		$item=$query->num_rows();
		if($item)return true;
		return false;
	}

	function isSudahDiagnosa($no_pendaftaran)
	{
		$this->db->where('no_pendaftaran',$no_pendaftaran);
		$query=$this->db->get('periksa_diagnosa');
		$item=$query->num_rows();
		if($item)return true;
		return false;
	}

	function isPasienRuangan($no_pendaftaran,$ruangan)
	{
		$this->db->where('no_pendaftaran',$no_pendaftaran);
		$this->db->where('kd_unit_kerja',$ruangan);
		$query=$this->db->get('masuk_ruangan');
		$item=$query->num_rows();
		if($item)return true;
		return false;
	}
	
	function isSudahPeriksaLab($no_pendaftaran)
	{
		$this->db->where('no_pendaftaran',$no_pendaftaran);
		$query=$this->db->get('lab_periksa_pasien');
		$item=$query->num_rows();
		if($item)return true;
		return false;
	}

	function isBayar($no_pendaftaran,$urut)
	{
		$this->db->where('no_pendaftaran',$no_pendaftaran);
		$this->db->where('urut',$urut);
		$query=$this->db->get('struk_pelayanan');
		$item=$query->num_rows();
		if($item)return true;
		return false;
	}
	
	function getAllHistoryDaftar($kd_pasien){

		$this->db->select('a.no_pendaftaran,tgl_pendaftaran,kelas,nama_unit_kerja');
		$this->db->join('kelas_pelayanan b','a.kd_kelas=b.kd_kelas','left');
		$this->db->join('unit_kerja c','a.kd_unit_kerja=c.kd_unit_kerja','left');
		$this->db->where('a.kd_pasien',$kd_pasien);
		//$this->db->limit($limit,$offset);
		$query=$this->db->get("pendaftaran a");
		return $query->result_array();
	}

	function getAllPasien($kd_pasien,$nama_pasien,$periodeawal,$periodeakhir,$jns_kelamin,$limit,$offset){
		//if(!empty($nama)) $this->db->like('nama_pasien',$nama);
		if(!empty($kd_pasien) && $kd_pasien !='NULL')$this->db->like('kd_pasien',$kd_pasien,'both');
		if(!empty($nama_pasien) && $nama_pasien !='NULL')$this->db->like('nama_pasien',$nama_pasien,'both');
		if(!empty($jns_kelamin) && $jns_kelamin !='NULL')$this->db->where('jns_kelamin',$jns_kelamin);
		if(!empty($periodeawal) && $periodeawal !='NULL')$this->db->where('date(tgl_membership)>=',$periodeawal);
		if(!empty($periodeakhir) && $periodeakhir !='NULL')$this->db->where('date(tgl_membership)<=',$periodeakhir);

		$this->db->join('propinsi b','a.kd_propinsi=b.kd_propinsi','left');
		$this->db->join('kabupaten c','a.kd_kabupaten=c.kd_kabupaten','left');
		$this->db->join('kecamatan d','a.kd_kabupaten=d.kd_kecamatan','left');
		$this->db->join('kelurahan e','a.kd_kecamatan=e.kd_kelurahan','left');
		//$this->db->limit($limit,$offset);
		$query=$this->db->get("pasien a");
		return $query->result_array();
	}

	function getAllDaftarPasien($kd_pasien,$nama_pasien,$periodeawal,$periodeakhir,$jns_kelamin,$unit){
		//if(!empty($nama)) $this->db->like('nama_pasien',$nama);
		if(!empty($kd_pasien) && $kd_pasien !='NULL')$this->db->like('a.kd_pasien',$kd_pasien,'both');
		if(!empty($nama_pasien) && $nama_pasien !='NULL')$this->db->like('nama_pasien',$nama_pasien,'both');
		if(!empty($jns_kelamin) && $jns_kelamin !='NULL')$this->db->where('jns_kelamin',$jns_kelamin);
		if(!empty($periodeawal) && $periodeawal !='NULL')$this->db->where('date(tgl_pendaftaran)>=',$periodeawal);
		if(!empty($periodeakhir) && $periodeakhir !='NULL')$this->db->where('date(tgl_pendaftaran)<=',$periodeakhir);

		if($this->session->userdata('ruangan')!=''){
			$this->db->select('*,date(tgl_pendaftaran) as tanggal_daftar, date(tgl_lahir) as tanggal_lahir,a.no_pendaftaran, ifnull(ops.urut,0) as urutoperasi, ifnull(ops.tanggal,0) as tanggaloperasi,e.kd_unit_kerja,g.nama_unit_kerja',false);
		}else{
			$this->db->select('*,date(tgl_pendaftaran) as tanggal_daftar, date(tgl_lahir) as tanggal_lahir,a.no_pendaftaran, ifnull(ops.urut,0) as urutoperasi, ifnull(ops.tanggal,0) as tanggaloperasi',false);			
		}
		$this->db->join('pasien f','a.kd_pasien=f.kd_pasien','left');
		$this->db->join('unit_kerja b','a.kd_unit_kerja=b.kd_unit_kerja','left');
		$this->db->join('apt_dokter c','a.kd_dokter=c.kd_dokter','left');
		$this->db->join('apt_customers d','a.cust_code=d.cust_code','left');
		if($unit==1){
			$this->db->where('b.parent','10');
		}
		if($unit==2){
			$this->db->where('(a.kd_unit_kerja in(1))');
		}
		if($unit==3){
			$this->db->where('(a.kd_unit_kerja in(8) or b.parent=8)');
		}
		//debugvar($this->session->userdata('ruangan'));
		if($this->session->userdata('ruangan')!=''){
			$this->db->join('masuk_ruangan e','a.no_pendaftaran=e.no_pendaftaran','left');
			$this->db->join('unit_kerja g','e.kd_unit_kerja=g.kd_unit_kerja','left');
			$this->db->where('e.kd_unit_kerja',$this->session->userdata('ruangan'));
			$this->db->where('e.tgl_keluar =','0000-00-00 00:00:00');
		}
		$this->db->join('rencana_operasi ops','a.no_pendaftaran=ops.no_pendaftaran ','left');
		if($this->session->userdata('poli')!=''){
			$this->db->where('b.kd_unit_kerja',$this->session->userdata('poli'));
		}
		//$this->db->limit($limit,$offset);
		$query=$this->db->get("pendaftaran a");
		return $query->result_array();
	}

	function getItemDaftarPasien($no_pendaftaran,$kd_pasien){
		//if(!empty($nama)) $this->db->like('nama_pasien',$nama);
		$this->db->select('a.*,f.*,b.nama_unit_kerja,c.nama_dokter,d.customer');
		$this->db->where('a.no_pendaftaran',$no_pendaftaran);
		$this->db->where('a.kd_pasien',$kd_pasien);
		$this->db->join('pasien f','a.kd_pasien=f.kd_pasien','left');
		$this->db->join('unit_kerja b','a.kd_unit_kerja=b.kd_unit_kerja','left');
		$this->db->join('apt_dokter c','a.kd_dokter=c.kd_dokter','left');
		$this->db->join('apt_customers d','a.cust_code=d.cust_code','left');

		$query=$this->db->get("pendaftaran a");
		return $query->row_array();
	}

	function getAllKonsulPasien($kd_pasien,$nama_pasien,$periodeawal,$periodeakhir,$jns_kelamin,$unit){
		//if(!empty($nama)) $this->db->like('nama_pasien',$nama);
		if(!empty($kd_pasien) && $kd_pasien !='NULL')$this->db->like('a.kd_pasien',$kd_pasien,'both');
		if(!empty($nama_pasien) && $nama_pasien !='NULL')$this->db->like('nama_pasien',$nama_pasien,'both');
		if(!empty($jns_kelamin) && $jns_kelamin !='NULL')$this->db->where('jns_kelamin',$jns_kelamin);
		if(!empty($periodeawal) && $periodeawal !='NULL')$this->db->where('date(f1.tanggal)>=',$periodeawal);
		if(!empty($periodeakhir) && $periodeakhir !='NULL')$this->db->where('date(f1.tanggal)<=',$periodeakhir);

		$this->db->select('*,date(tgl_pendaftaran) as tanggal_daftar, date(tgl_lahir) as tanggal_lahir,a.no_pendaftaran, ifnull(ops.urut,0) as urutoperasi, ifnull(ops.tanggal,0) as tanggaloperasi',false);
		$this->db->join('pasien_rujukan f1','a.no_pendaftaran=f1.no_pendaftaran');
		$this->db->join('pasien f','a.kd_pasien=f.kd_pasien','left');
		$this->db->join('unit_kerja b','f1.kd_unit_tujuan=b.kd_unit_kerja','left');
		$this->db->join('apt_dokter c','a.kd_dokter=c.kd_dokter','left');
		$this->db->join('apt_customers d','a.cust_code=d.cust_code','left');
		if($unit==1){
			$this->db->where('b.parent','10');
		}
		if($unit==2){
			$this->db->where('a.kd_unit_kerja in(1)');
		}
		if($unit==3){
			$this->db->where('a.kd_unit_kerja in(8) or b.parent=8');
		}
		//debugvar($this->session->userdata('ruangan'));
		if($this->session->userdata('ruangan')!=''){
			$this->db->join('masuk_ruangan e','a.no_pendaftaran=e.no_pendaftaran','left');
			$this->db->join('unit_kerja g','e.kd_unit_kerja=g.kd_unit_kerja','left');
			$this->db->where('e.kd_unit_kerja',$this->session->userdata('ruangan'));
			$this->db->where('e.tgl_keluar =','0000-00-00 00:00:00');
		}
		$this->db->join('rencana_operasi ops','a.no_pendaftaran=ops.no_pendaftaran ','left');
		if($this->session->userdata('poli')!=''){
			$this->db->where('b.kd_unit_kerja',$this->session->userdata('poli'));
		}
		//$this->db->limit($limit,$offset);
		$query=$this->db->get("pendaftaran a");
		return $query->result_array();
	}

	function countAllPasien($kd_pasien,$nama_pasien,$periodeawal,$periodeakhir,$jns_kelamin){
		//if(!empty($nama)) $this->db->like('nama_pasien',$nama);
		if(!empty($kd_pasien) && $kd_pasien !='NULL')$this->db->like('kd_pasien',$kd_pasien,'both');
		if(!empty($nama_pasien) && $nama_pasien !='NULL')$this->db->like('nama_pasien',$nama_pasien,'both');
		if(!empty($jns_kelamin) && $jns_kelamin !='NULL')$this->db->where('jns_kelamin',$jns_kelamin);
		if(!empty($periodeawal) && $periodeawal !='NULL')$this->db->where('date(tgl_membership)>=',$periodeawal);
		if(!empty($periodeakhir) && $periodeakhir !='NULL')$this->db->where('date(tgl_membership)<=',$periodeakhir);
		//$this->db->limit($limit,$offset);
		$query=$this->db->get("pasien a");
		return $query->num_rows();
	}

	function countAllDaftarPasien($kd_pasien,$nama_pasien,$periodeawal,$periodeakhir,$jns_kelamin,$unit){
		//if(!empty($nama)) $this->db->like('nama_pasien',$nama);
		if(!empty($kd_pasien) && $kd_pasien !='NULL')$this->db->like('kd_pasien',$kd_pasien,'both');
		if(!empty($nama_pasien) && $nama_pasien !='NULL')$this->db->like('nama_pasien',$nama_pasien,'both');
		if(!empty($jns_kelamin) && $jns_kelamin !='NULL')$this->db->where('f.jns_kelamin',$jns_kelamin);
		if(!empty($periodeawal) && $periodeawal !='NULL')$this->db->where('date(tgl_pendaftaran)>=',$periodeawal);
		if(!empty($periodeakhir) && $periodeakhir !='NULL')$this->db->where('date(tgl_pendaftaran)<=',$periodeakhir);
		//$this->db->limit($limit,$offset);
		$this->db->join('pasien f','a.kd_pasien=f.kd_pasien','left');
		$this->db->join('unit_kerja b','a.kd_unit_kerja=b.kd_unit_kerja','left');
		$this->db->join('apt_dokter c','a.kd_dokter=c.kd_dokter','left');
		$this->db->join('apt_customers d','a.cust_code=d.cust_code','left');
		if($unit==1){
		$this->db->where('a.kd_unit_kerja not in("1,8") and (parent!=8 or parent is null)');			
		}
		if($unit==2){
		$this->db->where('a.kd_unit_kerja not in("1")');			
		}
		if($unit==3){
		$this->db->where('a.kd_unit_kerja not in("8")');			
		}

		$query=$this->db->get("pendaftaran a");
		return $query->num_rows();
	}

	function getPengeluaran($nomor){
		//if(!empty($nama)) $this->db->like('nama_pasien',$nama);
		if(!empty($nomor))$this->db->where('cso_number',$nomor);

		$this->db->where('a.type',0);
		$this->db->join('unit_kerja b','a.kd_unit_kerja=b.kd_unit_kerja');
		$this->db->join('acc_payment c','a.pay_code=c.pay_code');
		$this->db->join('accounts d','a.account=d.account');
		//$this->db->limit($limit,$offset);
		
		$query=$this->db->get("acc_cso a");
		return $query->row_array();
	}


	function getAllDataLayanan($cust_code,$kd_kelas,$unit,$q){
		//$this->db->select('a.kd_jenis_tarif, jenis_tarif, a.kd_pelayanan, nama_pelayanan, a.kd_kelas, kelas, tgl_berlaku, tarif, tgl_berakhir');
		$this->db->select('a.*,b.nama_pelayanan');
		$this->db->join('list_pelayanan b','a.kd_pelayanan = b.kd_pelayanan');
		$this->db->join('kelas_pelayanan c','a.kd_kelas = c.kd_kelas');
		$this->db->join('jenis_tarif d','a.kd_jenis_tarif = d.kd_jenis_tarif');
		$this->db->join('tarif_customers e','d.kd_jenis_tarif = e.kd_jenis_tarif');
		//$this->db->join('tarif_mapping f',' b.kd_pelayanan = f.kd_pelayanan');
		$this->db->where('e.cust_code',$cust_code);
		$this->db->where('a.kd_kelas',$kd_kelas);
		//$this->db->where('f.kd_unit_kerja',$unit);
		$this->db->like('b.nama_pelayanan',$q,'both');
		$query=$this->db->get("tarif a");
		return $query->result_array();		
	}

	function getAllDetailPengeluaran($nomor){
		$this->db->order_by('line','asc');
		$this->db->where('cso_number',$nomor);
		//$this->db->limit($limit,$offset);
		$this->db->join('accounts b','a.account=b.account');
		$query=$this->db->get("acc_cso_detail a");
		return $query->result_array();		
	}

	function getJumlahTransaksiBulan($tahun,$bulan,$hari){
		//if(!empty($nama)) $this->db->like('nama_pasien',$nama);
		$this->db->select('max(right(kd_pasien,3)) as urut',false);
		$this->db->where('year(tgl_membership)',$tahun);
		$this->db->where('month(tgl_membership)',$bulan);
		$this->db->where('day(tgl_membership)',$hari);
		$query=$this->db->get("pasien a");
		$item= $query->row_array();
		return $item['urut'];
	}

	function getJumlahTransaksiRegBulan($tahun,$bulan){
		//if(!empty($nama)) $this->db->like('nama_pasien',$nama);
		$this->db->select('max(right(no_pendaftaran,4)) as urut',false);
		$this->db->where('year(tgl_pendaftaran)',$tahun);
		$this->db->where('month(tgl_pendaftaran)',$bulan);
		$query=$this->db->get("pendaftaran a");
		$item= $query->row_array();
		return $item['urut'];
	}

	function getMaxUrutDiagnosa($no_pendaftaran){
		//if(!empty($nama)) $this->db->like('nama_pasien',$nama);
		$this->db->select('max(urut) as urut',false);
		$this->db->where('no_pendaftaran',$no_pendaftaran);
		$query=$this->db->get("periksa_diagnosa a");
		$item= $query->row_array();
		return $item['urut'];
	}

	function isNumberExist($number){
		$this->db->where('kd_pasien',$number);
		$query=$this->db->get('pasien');
		$count=$query->num_rows();
		if($count){
			return true;
		}
		return false;
	}

	function isAdaDiagnosa($icd){
		$this->db->where('kd_sub_icd',$icd);
		$query=$this->db->get('sub_diagnosa_icd');
		$count=$query->num_rows();
		if($count){
			return true;
		}
		return false;
	}

	function isBaruRS($kd_pasien){
		$this->db->where('kd_pasien',$kd_pasien);
		$query=$this->db->get('pendaftaran');
		$count=$query->num_rows();
		if($count){
			return false;
		}
		return true;
	}

	function isBaruUnit($kd_pasien,$nuit){
		$this->db->where('kd_pasien',$kd_pasien);
		$this->db->where('kd_unit_kerja',$nuit);
		$query=$this->db->get('pendaftaran');
		$count=$query->num_rows();
		if($count){
			return false;
		}
		return true;
	}

	function countAllItemPelayanan($jenispelayanan,$itempelayanan){
		//if(!empty($nama)) $this->db->like('nama_pasien',$nama);
		if(!empty($jenispelayanan)){
			$this->db->where('a.kode_jenis_pelayanan',$jenispelayanan);			
		}
		if(!empty($itempelayanan))$this->db->like('a.nama_item_pelayanan',$itempelayanan,'both');
		$this->db->join('lab_jenis_pelayanan b','a.kode_jenis_pelayanan=b.kode_jenis_pelayanan');
		$query=$this->db->get("lab_item_pelayanan a");
		return $query->num_rows();
	}

	function getItemKonsulPasien($no_pendaftaran,$kd_pasien){
		//if(!empty($nama)) $this->db->like('nama_pasien',$nama);
		$this->db->select('a.*,f.*,b.kd_unit_kerja,b.nama_unit_kerja,c.nama_dokter,d.customer');
		$this->db->where('a.no_pendaftaran',$no_pendaftaran);
		$this->db->where('a.kd_pasien',$kd_pasien);
		$this->db->join('pasien f','a.kd_pasien=f.kd_pasien','left');
		$this->db->join('pasien_rujukan f1','a.no_pendaftaran=f1.no_pendaftaran');
		$this->db->join('unit_kerja b','f1.kd_unit_tujuan=b.kd_unit_kerja','left');
		$this->db->join('apt_dokter c','a.kd_dokter=c.kd_dokter','left');
		$this->db->join('apt_customers d','a.cust_code=d.cust_code','left');
		//$this->db->limit($limit,$offset);
		$this->db->order_by('tgl_pendaftaran asc');
		$query=$this->db->get("pendaftaran a");
		return $query->row_array();
	}

	
	function getDiagnosaOperasiByNoDaftar($no_pendaftaran){
		//if(!empty($nama)) $this->db->like('nama_pasien',$nama);
		$this->db->select('a.no_pendaftaran,a.urut,tgl_diagnosa,a.kd_jenis_diagnosa,a.kd_dokter,a.kd_sub_icd,a.kd_unit_kerja,b.jenis_diagnosa,c.nama_dokter,d.sub_diagnosa_icd,e.nama_unit_kerja');
		$this->db->where('no_pendaftaran',$no_pendaftaran);
		$this->db->where('status_operasi',1);

		$this->db->join('jenis_diagnosa b','a.kd_jenis_diagnosa=b.kd_jenis_diagnosa');
		$this->db->join('apt_dokter c','a.kd_dokter=c.kd_dokter');
		$this->db->join('sub_diagnosa_icd d','a.kd_sub_icd=d.kd_sub_icd');
		$this->db->join('unit_kerja e','a.kd_unit_kerja=e.kd_unit_kerja');
		//$this->db->limit($limit,$offset);
		
		$query=$this->db->get("periksa_diagnosa a");
		return $query->result_array();
	}

	function getDiagnosaSebelumOperasiByNoDaftar($no_pendaftaran){
		//if(!empty($nama)) $this->db->like('nama_pasien',$nama);
		$this->db->select('a.no_pendaftaran,a.urut,tgl_diagnosa,a.kd_jenis_diagnosa,a.kd_dokter,a.kd_sub_icd,a.kd_unit_kerja,b.jenis_diagnosa,c.nama_dokter,d.sub_diagnosa_icd,e.nama_unit_kerja');
		$this->db->where('no_pendaftaran',$no_pendaftaran);
		//$this->db->where('status_operasi !=',1);
		$this->db->where('(status_operasi != 1 or status_operasi is NULL)',null,false);

		$this->db->join('jenis_diagnosa b','a.kd_jenis_diagnosa=b.kd_jenis_diagnosa');
		$this->db->join('apt_dokter c','a.kd_dokter=c.kd_dokter');
		$this->db->join('sub_diagnosa_icd d','a.kd_sub_icd=d.kd_sub_icd');
		$this->db->join('unit_kerja e','a.kd_unit_kerja=e.kd_unit_kerja');
		//$this->db->limit($limit,$offset);
		
		$query=$this->db->get("periksa_diagnosa a");
		return $query->result_array();
	}


	//lab
	function getAllItemTest()
	{
		$query=$this->db->query('SELECT anak.kode_mapping,anak.kode_item_lab, COUNT( induk.kode_mapping )
				LEVEL , CONCAT( REPEAT( "--", (
				COUNT( induk.kode_mapping ) -1 ) ) , itemlab.nama_item_lab
				) AS nama_item_lab, anak.kiri, anak.kanan
				FROM lab_mapping_item AS induk, (

				SELECT *
				FROM lab_mapping_item
				) AS anak, lab_item_lab AS itemlab
				WHERE anak.kiri
				BETWEEN induk.kiri
				AND induk.kanan
				AND anak.kode_item_lab = itemlab.kode_item_lab
				GROUP BY anak.kode_mapping
				ORDER BY `anak`.`kiri` ASC');

		return $query->result_array();
	}	

	function lapPendapatanLabRWJ($periodeawal,$periodeakhir,$jenis_pasien)
	{
		if(!empty($jenis_pasien)){
			if($jenis_pasien==1){
				$jns=" and d.cust_code='0' ";
			}else if ($jenis_pasien==2){
				$jns=" and d.cust_code!='0' ";
			}else{
				$jns="";
			}
		}else{
			$jns="";
		}

		$query=$this->db->query('SELECT a.no_pendaftaran, e.kd_pasien, e.nama_pasien, b.kd_pelayanan, c.nama_pelayanan, sum( harga ) as pendapatan
				FROM `lab_periksa_pasien` a
				JOIN biaya_pelayanan b ON a.no_pendaftaran = b.no_pendaftaran
				JOIN list_pelayanan c ON b.kd_pelayanan = c.kd_pelayanan
				JOIN pendaftaran d ON a.no_pendaftaran = d.no_pendaftaran
				JOIN pasien e ON d.kd_pasien = e.kd_pasien
				JOIN unit_kerja f ON d.kd_unit_kerja = f.kd_unit_kerja
				WHERE c.kd_jenis_pelayanan =15
				AND (
				d.kd_unit_kerja =1
				OR f.parent =10
				)
				AND tanggal_masuk
				BETWEEN "'.$periodeawal.'"
				AND "'.$periodeakhir.'" '.$jns.'
				GROUP BY a.no_pendaftaran, b.kd_pelayanan
				WITH rollup');

		return $query->result_array();
	}	

	function lapPendapatanLabRWI($periodeawal,$periodeakhir,$jenis_pasien)
	{
		if(!empty($jenis_pasien)){
			if($jenis_pasien==1){
				$jns=" and d.cust_code='0' ";
			}else if ($jenis_pasien==2){
				$jns=" and d.cust_code!='0' ";
			}else{
				$jns="";
			}
		}else{
			$jns="";
		}

		$query=$this->db->query('SELECT a.no_pendaftaran, e.kd_pasien, e.nama_pasien, b.kd_pelayanan, c.nama_pelayanan, sum( harga ) as pendapatan
				FROM `lab_periksa_pasien` a
				JOIN biaya_pelayanan b ON a.no_pendaftaran = b.no_pendaftaran
				JOIN list_pelayanan c ON b.kd_pelayanan = c.kd_pelayanan
				JOIN pendaftaran d ON a.no_pendaftaran = d.no_pendaftaran
				JOIN pasien e ON d.kd_pasien = e.kd_pasien
				JOIN unit_kerja f ON d.kd_unit_kerja = f.kd_unit_kerja
				WHERE c.kd_jenis_pelayanan =15
				AND (
				f.parent =8
				)
				AND tanggal_masuk
				BETWEEN "'.$periodeawal.'"
				AND "'.$periodeakhir.'" '.$jns.'
				GROUP BY a.no_pendaftaran, b.kd_pelayanan
				WITH rollup');

		return $query->result_array();
	}	

	function hemarefrange(){
		$this->db->join('lab_item_lab b','a.kode_item_lab=b.kode_item_lab');
		$query= $this->db->get('lab_hematology_ref_range a');

		return $query->result_array();
	}

	function getAllPeriksaPasienLab($kd_pasien,$nama_pasien,$periodeawal,$periodeakhir,$jns_kelamin,$unit){
		//if(!empty($nama)) $this->db->like('nama_pasien',$nama);
		$this->db->select('*,date_format(tanggal_masuk," %d-%m-%Y %h:%i:%s ") as tanggal_masuk,date_format(tanggal_periksa," %d-%m-%Y %h:%i:%s ") as tanggal_periksa',false);
		if(!empty($kd_pasien) && $kd_pasien !='NULL')$this->db->like('a.kd_pasien',$kd_pasien,'both');
		if(!empty($nama_pasien) && $nama_pasien !='NULL')$this->db->like('nama_pasien',$nama_pasien,'both');
		if(!empty($jns_kelamin) && $jns_kelamin !='NULL')$this->db->where('jns_kelamin',$jns_kelamin);
		if($unit==1){
			$this->db->where('(b.kd_unit_kerja=1 or f.parent=10)',null,false);
		}
		if($unit==2){
			$this->db->where('f.parent=8',null,false);
		}
		if(!empty($periodeawal) && $periodeawal !='NULL'){
			$this->db->where('date(a.tanggal_masuk)>=',$periodeawal);
		}
		if(!empty($periodeakhir) && $periodeakhir !='NULL'){
			$this->db->where('date(a.tanggal_masuk)<=',$periodeakhir);						
		}
		$this->db->join('pendaftaran b','a.no_pendaftaran=b.no_pendaftaran','left');
		$this->db->join('pasien c','b.kd_pasien=c.kd_pasien','left');
		$this->db->join('apt_dokter d','b.kd_dokter=d.kd_dokter','left');
		$this->db->join('apt_customers e','b.cust_code=e.cust_code','left');
		$this->db->join('unit_kerja f','b.kd_unit_kerja=f.kd_unit_kerja','left');
		//$this->db->limit($limit,$offset);
		$query=$this->db->get("lab_periksa_pasien a");
		return $query->result_array();
	}

}
	
?>
