<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

include_once(APPPATH.'controllers/rumahsakit.php');
class Unit extends Rumahsakit {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -  
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	public $unit;
	protected $title='SIM RS - Sistem Informasi Rumah Sakit';
	public function __construct()
	{
		parent::__construct();

		$this->load->model('master/munit');
		$this->load->model('master/mlayanan');

		//debugvar($poli);
	}

	public function index($kd_pasien="NULL",$nama_pasien="NULL",$periodeawal="NULL",$periodeakhir="NULL",$jns_kelamin="NULL")
	{
		if($this->input->post('kd_pasien')!='')$kd_pasien=$this->input->post('kd_pasien');
		if($this->input->post('nama_pasien')!='')$nama_pasien=$this->input->post('nama_pasien');
		if($this->input->post('jns_kelamin')!='')$jns_kelamin=$this->input->post('jns_kelamin');
		if($this->input->post('periodeawal')!='')$periodeawal=$this->input->post('periodeawal'); else $periodeawal=date('d-m-Y');
		if($this->input->post('periodeakhir')!='')$periodeakhir=$this->input->post('periodeakhir'); else $periodeakhir=date('d-m-Y');

		$cssfileheader=array('bootstrap.css','bootstrap-responsive.min.css','font-awesome.min.css','style.css','prettify.css','jquery-ui.css','DT_bootstrap.css','responsive-tables.css','datepicker.css','theme.css');
		$jsfileheader=array('vendor/modernizr-2.6.2-respond-1.1.0.min.js',
							'vendor/jquery-1.9.1.min.js',
							'vendor/jquery-migrate-1.1.1.min.js',
							'vendor/jquery-ui-1.10.0.custom.min.js',
							'vendor/bootstrap.min.js',
							'lib/jquery.tablesorter.min.js',
							'lib/jquery.dataTables.min.js',
							'lib/DT_bootstrap.js',
							'lib/responsive-tables.js',
							'lib/bootstrap-datepicker.js',
							'lib/bootstrap-inputmask.js',
							'main.js');
		$dataheader=array(
			'jsfile'=>$jsfileheader,
			'cssfile'=>$cssfileheader,
			'title'=>$this->title
			);

		$jsfooter=array();
		$datafooter=array(
			'jsfile'=>$jsfooter
			);

		$data=array(
			'periodeawal'=>$periodeawal,
			'periodeakhir'=>$periodeakhir,
			'kd_pasien'=>$kd_pasien,
			'nama_pasien'=>$nama_pasien,
			'jns_kelamin'=>$jns_kelamin
			);
		//debugvar($this->pagination->create_links());
		$this->load->view('poli/header',$dataheader);
		$this->load->view('poli/daftar',$data);
		$this->load->view('footer',$datafooter);
	}

	public function pasienpoli($kd_pasien="NULL",$nama_pasien="NULL",$periodeawal="NULL",$periodeakhir="NULL",$jns_kelamin="NULL")
	{

		$this->datatables->select('a.no_pendaftaran as checkbox,a.tgl_pendaftaran,a.no_pendaftaran,a.kd_pasien,f.nama_pasien,f.jns_kelamin,case when g.no_pendaftaran is not null then i.nama_unit_kerja else b.nama_unit_kerja end as unit_kerja,concat("Rujukan Dari ",h.nama_unit_kerja),CASE when is_baru_rs in (1) then "B" else "L" end as status,CASE when a.no_pendaftaran in (select no_pendaftaran from periksa_diagnosa) then "Pulang" else "Belum Pulang" end as stat ',false);
		$this->datatables->from("pendaftaran a");
		$this->datatables->add_column('pilihan', '<a class="btn btn-info" href="'.base_url().'index.php/poli/periksa/$1/$2">Periksa</a>|| <a class="btn btn-info" href="'.base_url().'index.php/poli/konsul/$1/$2">Rujukan Internal</a>', 'a.kd_pasien,a.no_pendaftaran');		
		$this->datatables->edit_column('checkbox', '<input type="checkbox" value="$1" pasien="$2" class="checkedpasien" />', 'a.no_pendaftaran,a.kd_pasien');
		if(!empty($kd_pasien) && $kd_pasien !='NULL')$this->datatables->like('a.kd_pasien',$kd_pasien,'both');
		if(!empty($nama_pasien) && $nama_pasien !='NULL')$this->datatables->like('nama_pasien',$nama_pasien,'both');
		if(!empty($jns_kelamin) && $jns_kelamin !='NULL')$this->datatables->where('jns_kelamin',$jns_kelamin);
		if(!empty($periodeawal) && $periodeawal !='NULL')$this->datatables->where('date(tgl_pendaftaran)>=',convertDate($periodeawal));
		if(!empty($periodeakhir) && $periodeakhir !='NULL')$this->datatables->where('date(tgl_pendaftaran)<=',convertDate($periodeakhir));
		$this->datatables->where('(b.kd_unit_kerja="'.$this->poli.'" or g.kd_unit_tujuan="'.$this->poli.'")');
		$this->datatables->where('b.parent','10');
		$this->datatables->join('pasien_rujukan g','a.no_pendaftaran=g.no_pendaftaran','left');
		$this->datatables->join('unit_kerja h','g.kd_unit_asal=h.kd_unit_kerja','left');
		$this->datatables->join('unit_kerja i','g.kd_unit_tujuan=i.kd_unit_kerja','left');
		$this->datatables->join('pasien f','a.kd_pasien=f.kd_pasien','left');
		$this->datatables->join('unit_kerja b','a.kd_unit_kerja=b.kd_unit_kerja','left');
		$this->datatables->join('apt_dokter c','a.kd_dokter=c.kd_dokter','left');
		$this->datatables->join('apt_customers d','a.cust_code=d.cust_code','left');

		//$this->db->order_by('a.tgl_pendaftaran','desc');

		//$data['result'] = $this->datatables->generate();
		$results = $this->datatables->generate();
		//$data['aaData'] = $results['aaData']->;
		$x=json_decode($results);
		$b=$x->aaData;
		echo ($results);
	}
	
	public function periksa($no_pendaftaran="")
	{

		$data=array(
			'datapelayanan'=>$this->mlayanan->getTarifLayanan(),			
			'datadokter'=>$this->mpoli->getDokterUnit(),
			'datajenisdiagnosa'=>$this->mpoli->ambilData('jenis_diagnosa'),
			'item'=>$this->mpoli->getItemDaftarPasien($no_pendaftaran,$kd_pasien),
			'itemslayanan'=>$this->mlayanan->getPelayananPasien($no_pendaftaran),
			'itemsdiagnosa'=>$this->mpoli->getDiagnosaByNoDaftar($no_pendaftaran),
			'no_pendaftaran'=>$no_pendaftaran
		);

	}

	public function simpandiagnosa()
	{
		$msg=array();
		$no_pendaftaran=$this->input->post('no_pendaftaran');
		$urut=$this->input->post('urut');
		$tgldiagnosa=$this->input->post('tgldiagnosa');
		$jampoli=$this->input->post('jampoli');
		$kdpasien=$this->input->post('kdpasien');
		$kd_jenis_diagnosa=$this->input->post('kd_jenis_diagnosa');
		$kd_dokter=$this->input->post('kd_dokter');
		$kd_sub_icd=$this->input->post('kd_sub_icd');
		$kd_unit_kerja=$this->input->post('kd_unit_kerja');
		$kd_kelas=$this->input->post('kd_kelas');
		$msg['status']=1;
		$msg['urut']='';
		if($this->mpoli->isDataDiagnosaExist($no_pendaftaran,$urut)){
			//debugvar(json_encode($msg));
			echo json_encode($msg);
			return false;
		}
		$pesan='';
		//debugvar($msg['status']);
		if($no_pendaftaran==''){
			$pesan='No Pendaftaran tidak boleh kosong';
			$msg['status']=0;
		}
		if($tgldiagnosa==''){
			$pesan='Tanggal diagnosa tidak boleh kosong';
			$msg['status']=0;
		}
		if($jampoli==''){
			$pesan='Jam diagnosa tidak boleh kosong';
			$msg['status']=0;
		}
		if($kdpasien==''){
			$pesan='Kode Pasien tidak boleh kosong';
			$msg['status']=0;
		}
		if($kd_sub_icd==''){
			$pesan='Kode ICD tidak boleh kosong';
			$msg['status']=0;
		}
		//
		$msg['pesan']=$pesan;
		if(!$msg['status']){
			echo json_encode($msg);
			return false;			
		}
		if($this->mpoli->isDiagnosaLama($no_pendaftaran,$kd_sub_icd)){
			$status="Lama";
		}else{
			$status="Baru";
		}
		$urut=$this->mpoli->getMaxUrutDiagnosa($no_pendaftaran);
		$urut=$urut+1;
		$data_diagnosa=array(
			'no_pendaftaran'=>$no_pendaftaran,
			'urut'=>$urut,
			'tgl_diagnosa'=>convertDate($tgldiagnosa).' '.$jampoli,
			'kd_pasien'=>$kdpasien,
			'kd_jenis_diagnosa'=>$kd_jenis_diagnosa,
			'kd_dokter'=>$kd_dokter,
			'kd_sub_icd'=>$kd_sub_icd,
			'kd_unit_kerja'=>$kd_unit_kerja,
			'kd_kelas'=>$kd_kelas,
			'status_kasus'=>$status
			);				

		$this->mpoli->insert('periksa_diagnosa',$data_diagnosa);
		$msg['urut']=$urut;
		//$urut=1;
		//$msg['pesan']="Data Berhasil Di Simpan";


		echo json_encode($msg);
	}

	public function simpanpelayanan()
	{
		$msg=array();
		$no_pendaftaran=$this->input->post('no_pendaftaran');
		$tglpelayanan=$this->input->post('tglpelayanan');
		$jampelayanan=$this->input->post('jampelayanan');
		$cust_code=$this->input->post('cust_code');
		$kodetarif=$this->input->post('kodetarif');
		$kd_dokter=$this->input->post('kd_dokter');
		$qty=$this->input->post('qty');
		$tarif=$this->input->post('tarif');

		$msg['status']=1;
		$msg['urut']='';

		$pesan='';
		//debugvar($msg['status']);
		if($no_pendaftaran==''){
			$pesan='No Pendaftaran tidak boleh kosong';
			$msg['status']=0;
		}
		if($tglpelayanan==''){
			$pesan='Tanggal tidak boleh kosong';
			$msg['status']=0;
		}
		if($jampelayanan==''){
			$pesan='Jam tidak boleh kosong';
			$msg['status']=0;
		}
		if($kodetarif==''){
			$pesan='Kode Tarif tidak boleh kosong';
			$msg['status']=0;
		}
		if($qty==''){
			$pesan='Qty tidak boleh kosong';
			$msg['status']=0;
		}
		//
		$msg['pesan']=$pesan;
		if(!$msg['status']){
			echo json_encode($msg);
			return false;			
		}
		
		$kd=explode("#", $kodetarif);
		$itemlayanan1=$this->mkasir->ambilItemData('biaya_pelayanan','no_pendaftaran = "'.$no_pendaftaran.'" and kd_jenis_tarif="'.$kd[0].'" and kd_pelayanan="'.$kd[1].'" and kd_kelas="'.$kd[2].'" and tgl_berlaku="'.$kd[3].'"');
		if(count($itemlayanan1) > 0){
			//debugvar(json_encode($msg));
			echo json_encode($msg);
			return false;
		}

		$kode=explode("#", $kodetarif);
		$urut=$this->mkasir->getMaxUrutPelayanan($no_pendaftaran);
		$itemlayanan=$this->mkasir->ambilItemData('tarif','kd_jenis_tarif="'.$kode[0].'" and kd_pelayanan="'.$kode[1].'" and kd_kelas="'.$kode[2].'" and tgl_berlaku="'.$kode[3].'"');
		//debugvar($itemlayanan);
		$tanggal=convertDate($tglpelayanan);
		$urut=$urut+1;
		$data_pelayanan=array(
			'no_pendaftaran'=>$no_pendaftaran,
			'urut'=>$urut,
			'kd_kasir'=>0,
			'tgl_pelayanan'=>$tanggal.' '.$jampelayanan,
			'kd_jenis_tarif'=>$itemlayanan['kd_jenis_tarif'],
			'kd_pelayanan'=>$itemlayanan['kd_pelayanan'],
			'kd_kelas'=>$itemlayanan['kd_kelas'],
			'tgl_berlaku'=>$itemlayanan['tgl_berlaku'],
			'qty'=>$qty,
			'harga'=>$itemlayanan['tarif'],
			'total'=>$itemlayanan['tarif']*$qty,
			'kd_dokter'=>$kd_dokter,
			'cust_code'=>$cust_code,
			'harga_asli'=>$itemlayanan['tarif']
			);				

		$this->mkasir->insert('biaya_pelayanan',$data_pelayanan);
		$this->mkasir->insertbiayapelayanancomponent(0,$no_pendaftaran,$urut,$itemlayanan['kd_jenis_tarif'],$itemlayanan['kd_pelayanan'],$itemlayanan['kd_kelas'],$itemlayanan['tgl_berlaku']);

		$msg['urut']=$urut;
		//$urut=1;
		//$msg['pesan']="Data Berhasil Di Simpan";


		echo json_encode($msg);
	}


	public function konsul($kd_pasien="",$no_pendaftaran="")
	{
		//if(empty($kd_pasien))return false;
		$cssfileheader=array('bootstrap.css','bootstrap-responsive.min.css','font-awesome.min.css','style.css','prettify.css','jquery-ui.css','DT_bootstrap.css','responsive-tables.css','datepicker.css','timepicker.css','theme.css');
		$jsfileheader=array('vendor/modernizr-2.6.2-respond-1.1.0.min.js',
							'vendor/jquery-1.9.1.min.js',
							'vendor/jquery-migrate-1.1.1.min.js',
							'vendor/jquery-ui-1.10.0.custom.min.js',
							'vendor/bootstrap.min.js',
							'lib/jquery.tablesorter.min.js',
							'lib/jquery.dataTables.min.js',
							'lib/DT_bootstrap.js',
							'lib/responsive-tables.js',
							'lib/bootstrap-datepicker.js',
							'lib/bootstrap-timepicker.js',
							'lib/bootstrap-inputmask.js',
							'lib/bootstrap-modal.js',
							'spin.js',
							'main.js');
		$dataheader=array(
			'jsfile'=>$jsfileheader,
			'cssfile'=>$cssfileheader,
			'title'=>$this->title
			);

		$jsfooter=array();
		$datafooter=array(
			'jsfile'=>$jsfooter
			);

		$data=array(
			'datadokter'=>$this->mpoli->ambilData('apt_dokter'),
			'item'=>$this->mpoli->getItemDaftarPasien($no_pendaftaran,$kd_pasien),
			'no_pendaftaran'=>$no_pendaftaran,
			'kd_pasien'=>$kd_pasien,
			'unittujuan'=>$this->mpoli->ambilData("unit_kerja")
		);
		$this->load->view('poli/header',$dataheader);
		$this->load->view('poli/konsul',$data);
		$this->load->view('footer',$datafooter);
	}

	public function periksakonsul()
	{
		$msg=array();
		$no_pendaftaran=$this->input->post('no_pendaftaran');
		$kd_pasien=$this->input->post('kd_pasien');
		$submit=$this->input->post('submit');
		$tanggalkonsul=$this->input->post('tanggalkonsul');
		$unittujuan=$this->input->post('unittujuan');
		$dokterkonsul=$this->input->post('dokterkonsul');

		$jumlaherror=0;
		$msg['status']=1;
		$msg['clearform']=0;
		$msg['pesanatas']="";
		$msg['pesanlain']="";

		if(empty($no_pendaftaran)){
			$jumlaherror++;
			$msg['id'][]="no_pendaftaran";
			$msg['pesan'][]="No Pendaftaran Harus di Isi";
		}

		$itemkonsul=$this->mpoli->ambilItemData('pasien_rujukan','no_pendaftaran="'.$no_pendaftaran.'"');
		if(!empty($itemkonsul)){
			$jumlaherror++;
			$msg['id'][]="no_pendaftaran";
			$msg['pesan'][]="Pasien sudah di rujuk";
		}

		if(empty($kd_pasien)){
			$jumlaherror++;
			$msg['id'][]="kd_pasien";
			$msg['pesan'][]="No RM Harus di Isi";
		}

		if(empty($unittujuan)){
			$jumlaherror++;
			$msg['id'][]="unittujuan";
			$msg['pesan'][]="Unit Tujuan Harus di Isi";
		}

		if(empty($dokterkonsul)){
			$jumlaherror++;
			$msg['id'][]="dokterkonsul";
			$msg['pesan'][]="Dokter Konsul Harus di Isi";
		}


		if($jumlaherror>0){
			$msg['status']=0;
			$msg['error']=$jumlaherror;
			$msg['pesanatas']="Terdapat beberapa kesalahan input silahkan cek inputan anda";
		}

		echo json_encode($msg);

	}

	public function simpankonsul()
	{
		$msg=array();
		$no_pendaftaran=$this->input->post('no_pendaftaran');
		$kdpasien=$this->input->post('kdpasien');
		$tanggalkonsul=$this->input->post('tanggalkonsul');
		$kd_unit_asal=$this->input->post('kd_unit_asal');
		$unittujuan=$this->input->post('unittujuan');
		$dokterkonsul=$this->input->post('dokterkonsul');
		$msg['status']=1;
		//$urut=1;
		//$msg['pesan']="Data Berhasil Di Simpan";

		$data=array(
			'no_pendaftaran'=>$no_pendaftaran,
			'kd_unit_asal'=>$kd_unit_asal,
			'kd_unit_tujuan'=>$unittujuan,
			'kd_dokter'=>$dokterkonsul,
			'tanggal'=>convertDate($tanggalkonsul)
		);
		$this->mpoli->insert('pasien_rujukan',$data);
		echo json_encode($msg);
	}


	public function hapusdiagnosa()
	{
		$msg=array();
		$no_pendaftaran=$this->input->post('no_pendaftaran');
		$urut=$this->input->post('urut');

		$this->mpoli->delete('periksa_diagnosa','no_pendaftaran = "'.$no_pendaftaran.'" and urut="'.$urut.'"');

		//$urut=1;
		//$msg['pesan']="Data Berhasil Di Simpan";


		echo json_encode($msg);
	}

	public function hapuspelayanan()
	{
		$msg=array();
		$no_pendaftaran=$this->input->post('no_pendaftaran');
		$kodetarif=$this->input->post('kodetarif');
		$urut=$this->input->post('urut');

		$this->mpoli->delete('biaya_pelayanan','no_pendaftaran = "'.$no_pendaftaran.'" and urut="'.$urut.'"');
		$this->mpoli->delete('biaya_pelayanan_component','no_pendaftaran = "'.$no_pendaftaran.'" and urut="'.$urut.'"');


		echo json_encode($msg);
	}




	public function listpelayanan(){
		$cust=$this->input->post('cust');
		$kelas=$this->input->post('kelas');
		$items=$this->mpoli->getAllDataLayanan($cust,$kelas);

		echo json_encode($items);
	}

	public function listpelayanan2(){
		$kode_uraian=$this->input->post('kode_uraian');
		$q=$this->input->post('query');
		$cust=$this->input->post('cust');
		$kelas=$this->input->post('kelas');
		$unit=$this->input->post('unit');
		$this->datatables->select('a.kd_jenis_tarif,a.kd_kelas,a.tgl_berlaku,a.kd_pelayanan,a.tarif,b.nama_pelayanan',false);
		$this->datatables->from("tarif a");
		//$this->datatables->edit_column('pilihan', '<a class="btn" onclick=\'pilihakun("$1","$2","$3","$4","$5","$6")\'>Pilih</a>', 'a.kd_jenis_tarif,a.kd_kelas,a.tgl_berlaku,a.kd_pelayanan,a.tarif,b.nama_pelayanan');		
		$this->datatables->join('list_pelayanan b','a.kd_pelayanan = b.kd_pelayanan');
		$this->datatables->join('kelas_pelayanan c','a.kd_kelas = c.kd_kelas');
		$this->datatables->join('jenis_tarif d','a.kd_jenis_tarif = d.kd_jenis_tarif');
		$this->datatables->join('tarif_customers e','d.kd_jenis_tarif = e.kd_jenis_tarif');
		$this->datatables->join('tarif_mapping f',' b.kd_pelayanan = f.kd_pelayanan');
		$this->datatables->where('e.cust_code',$cust);
		$this->datatables->where('a.kd_kelas',$kelas);
		$this->datatables->where('f.kd_unit_kerja',$unit);
		//$this->db->where('f.kd_unit_kerja',$unit);
		//$this->datatables->like('b.nama_pelayanan',$q,'both');
		$this->datatables->where('(b.nama_pelayanana like "%'.$q.'%" or b.kd_pelayanan like "%'.$kode_uraian.'%" )',null,false);
		//$data['result'] = $this->datatables->generate();
		$results = $this->datatables->generate();
		//$data['aaData'] = $results['aaData']->;
		$x=json_decode($results);
		$b=$x->aaData;
		echo ($results);
	}

	public function datatableslistpelayanan()
	{
		$q=$this->input->post('query');
		$cust=$this->input->post('cust');
		$kelas=$this->input->post('kelas');
		$unit=$this->input->post('unit');
		$this->datatables->select('b.nama_pelayanan,a.tarif,"pilihan" as pilihan,a.kd_jenis_tarif,a.kd_kelas,a.tgl_berlaku,a.kd_pelayanan',false);
		$this->datatables->from("tarif a");
		$this->datatables->edit_column('pilihan', '<a class="btn" onclick=\'pilihakun("$1","$2","$3","$4","$5","$6")\'>Pilih</a>', 'a.kd_jenis_tarif,a.kd_kelas,a.tgl_berlaku,a.kd_pelayanan,a.tarif,b.nama_pelayanan');		
		$this->datatables->join('list_pelayanan b','a.kd_pelayanan = b.kd_pelayanan');
		$this->datatables->join('kelas_pelayanan c','a.kd_kelas = c.kd_kelas');
		$this->datatables->join('jenis_tarif d','a.kd_jenis_tarif = d.kd_jenis_tarif');
		$this->datatables->join('tarif_customers e','d.kd_jenis_tarif = e.kd_jenis_tarif');
		$this->datatables->join('tarif_mapping f',' b.kd_pelayanan = f.kd_pelayanan');
		$this->datatables->where('e.cust_code',$cust);
		$this->datatables->where('a.kd_kelas',$kelas);
		$this->datatables->where('f.kd_unit_kerja',$unit);
		//$this->db->where('f.kd_unit_kerja',$unit);
		$this->datatables->like('b.nama_pelayanan',$q,'both');
		//$data['result'] = $this->datatables->generate();
		$results = $this->datatables->generate();
		//$data['aaData'] = $results['aaData']->;
		$x=json_decode($results);
		$b=$x->aaData;
		echo ($results);
	}

	public function listdiagnosa($param){
		$q=$this->input->post('query');
		
		if($param==1){
			$items=$this->mpoli->ambilData('sub_diagnosa_icd','kd_sub_icd like "%'.$q.'%"','500');			
		}else{
			$items=$this->mpoli->ambilData('sub_diagnosa_icd','sub_diagnosa_icd like "%'.$q.'%"','500');						
		}		

		echo json_encode($items);
	}

	public function datatableslistdiagnosa($param="")
	{
		$q=$this->input->post('query');
		$this->datatables->select('kd_sub_icd,sub_diagnosa_icd',false);
		$this->datatables->from("sub_diagnosa_icd a");
		$this->datatables->add_column('pilihan', '<a class="btn" onclick=\'pilihdiagnosa("$1","$2")\'>Pilih</a>', 'kd_sub_icd,sub_diagnosa_icd');		
		if($param==1){
			$this->datatables->like('kd_sub_icd',$q,'both');
		}else{
			$this->datatables->like('sub_diagnosa_icd',$q,'both');			
		}
		//$data['result'] = $this->datatables->generate();
		$results = $this->datatables->generate();
		//$data['aaData'] = $results['aaData']->;
		$x=json_decode($results);
		$b=$x->aaData;
		echo ($results);
	}

	public function caripasien()
	{
		$nama=$this->input->post('nama');
		$alamat=$this->input->post('alamat');
		$keluarga=$this->input->post('keluarga');
		$telepon=$this->input->post('telepon');

		$items=$this->mpoli->ambilData('pasien','nama_pasien like "%'.$nama.'%" and nama_keluarga like "%'.$keluarga.'%" and alamat like "%'.$alamat.'%" and telepon like "%'.$telepon.'%" ');

		echo json_encode($items);
	}

	public function hitungUmur(){
		$q=$this->input->post('query');
		$item=hitungumur($q);
		echo json_encode($item);
	}

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */