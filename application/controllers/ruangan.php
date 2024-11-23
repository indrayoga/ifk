<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

include_once(APPPATH.'controllers/master/unit.php');
class Ruangan extends Unit {

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

	protected $title='SIM RS - Sistem Informasi Rumah Sakit';
	protected $akses='112';
	public $poli;
	public $namapoli;
	public $pasien;

	public function __construct()
	{
		parent::__construct();

		if(!$this->muser->isLogin()){
			redirect('/home/');
			return false;
		}

		$this->load->model('master/mlayanan');
		$this->load->model('reg/mrwi');
		$this->load->model('mruangan');

		$this->poli=$this->mruangan->getKdUnit();
		$this->namapoli=$this->mruangan->getUnit();
		
        $queryunitshift=$this->db->query('select * from unit_shift where kd_unit="RWI"'); 
        $unitshift=$queryunitshift->row_array();
		$this->shift=$unitshift['shift'];
	}

	public function restricted(){
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
							'lib/jquery.dualListBox-1.3.min.js',
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

		$this->load->view('ruangan/header',$dataheader);
		$data=array();
		parent::view_restricted($data);
		$this->load->view('footer');
	}

	public function index($kd_pasien="NULL",$nama_pasien="NULL",$periodeawal="NULL",$periodeakhir="NULL",$jns_kelamin="NULL")
	{
		if(!$this->muser->isAkses("700",$this->poli)){
			$this->restricted();
			return false;
		}

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
		$this->load->view('ruangan/header',$dataheader);
		$this->load->view('ruangan/daftar',$data);
		$this->load->view('footer',$datafooter);
	}

	public function pasienruangan($kd_pasien="NULL",$nama_pasien="NULL",$periodeawal="NULL",$periodeakhir="NULL",$jns_kelamin="NULL")
	{

		$this->datatables->select('a.no_pendaftaran as checkbox,a.tgl_pendaftaran,a.no_pendaftaran,a.kd_pasien,f.nama_pasien,f.jns_kelamin,j.nama_unit_kerja  as unit_kerja,CASE when is_baru_rs in (1) then "B" else "L" end as status ',false);
		$this->datatables->from("pendaftaran a");
		$this->datatables->add_column('pilihan', '<a class="btn btn-info" href="'.base_url().'index.php/ruangan/periksa/$2">Periksa</a> <a class="btn btn-info" href="'.base_url().'index.php/ruangan/pindah/$2">Pindah</a> <a class="btn btn-info" href="'.base_url().'index.php/ruangan/pulang/$2">Pulang</a>', 'a.kd_pasien,a.no_pendaftaran');		
		$this->datatables->edit_column('checkbox', '<input type="checkbox" value="$1" pasien="$2" class="checkedpasien" />', 'a.no_pendaftaran,a.kd_pasien');
		$this->datatables->join('pasien_rujukan g','a.no_pendaftaran=g.no_pendaftaran','left');
		$this->datatables->join('unit_kerja h','g.kd_unit_asal=h.kd_unit_kerja','left');
		$this->datatables->join('unit_kerja i','g.kd_unit_tujuan=i.kd_unit_kerja','left');
		$this->datatables->join('pasien f','a.kd_pasien=f.kd_pasien','left');
		$this->datatables->join('unit_kerja b','a.kd_unit_kerja=b.kd_unit_kerja','left');
		$this->datatables->join('apt_dokter c','a.kd_dokter=c.kd_dokter','left');
		$this->datatables->join('apt_customers d','a.cust_code=d.cust_code','left');
		$this->datatables->join('masuk_ruangan e','a.no_pendaftaran=e.no_pendaftaran');
		$this->datatables->join('unit_kerja j','e.kd_unit_kerja=j.kd_unit_kerja','left');
		if(!empty($kd_pasien) && $kd_pasien !='NULL')$this->datatables->like('a.kd_pasien',$kd_pasien,'both');
		if(!empty($nama_pasien) && $nama_pasien !='NULL')$this->datatables->like('nama_pasien',$nama_pasien,'both');
		if(!empty($jns_kelamin) && $jns_kelamin !='NULL')$this->datatables->where('jns_kelamin',$jns_kelamin);
		if(!empty($periodeawal) && $periodeawal !='NULL')$this->datatables->where('date(tgl_pendaftaran)>=',convertDate($periodeawal));
		if(!empty($periodeakhir) && $periodeakhir !='NULL')$this->datatables->where('date(tgl_pendaftaran)<=',convertDate($periodeakhir));
		$this->datatables->where('e.kd_unit_kerja',$this->poli);
		//$this->datatables->where('(e.kd_unit_kerja in(8) or e.parent=8)');
		$this->datatables->where('(e.tgl_keluar ="0000-00-00 00:00:00" or e.tgl_keluar is null)');

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
		if(!$this->muser->isAkses("710",$this->poli)){
			$this->restricted();
			return false;
		}
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

		$this->mrwi->setPasien($no_pendaftaran);
		$this->pasien=$this->mrwi->pasien;
		//var_dump($this->pasien);
		$data=array(
			'datapelayanan'=>$this->mlayanan->getTarifLayanan(),			
			'datadokter'=>$this->mruangan->getDokterUnit(),
			'datajenisdiagnosa'=>$this->mruangan->ambilData('jenis_diagnosa'),
			//'item'=>$this->mpoli->getItemDaftarPasien($no_pendaftaran,$kd_pasien),
			'itemslayanan'=>$this->mrwi->pelayananpasien(),
			'itemsdiagnosa'=>$this->mrwi->diagnosapasien(),
			'no_pendaftaran'=>$no_pendaftaran
		);
		$this->load->view('ruangan/header',$dataheader);
		$this->load->view('ruangan/periksapasien',$data);
		$this->load->view('footer',$datafooter);
	}

	public function pindah($no_pendaftaran="")
	{
		if(!$this->muser->isAkses("712",$this->poli)){
			$this->restricted();
			return false;
		}
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

		$this->mrwi->setPasien($no_pendaftaran);
		$this->pasien=$this->mrwi->pasien;
		//var_dump($this->pasien);
		$data=array(
			'datapoli'=>$this->mruangan->getlistUnit('8'),			
			'datakelaspelayanan'=>$this->mrwi->ambilData('kelas_pelayanan',' kd_kelas not in("00","07")'),			
			//'item'=>$this->mpoli->getItemDaftarPasien($no_pendaftaran,$kd_pasien),
			'no_pendaftaran'=>$no_pendaftaran
		);
		$this->load->view('ruangan/header',$dataheader);
		$this->load->view('ruangan/pindah',$data);
		$this->load->view('footer',$datafooter);
	}

	public function pulang($no_pendaftaran="")
	{
		if(!$this->muser->isAkses("713",$this->poli)){
			$this->restricted();
			return false;
		}
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

		$this->mrwi->setPasien($no_pendaftaran);
		$this->pasien=$this->mrwi->pasien;
		//var_dump($this->pasien);
		$data=array(
			'datakondisipulang'=>$this->mruangan->ambilData('kondisi_pulang'),
			'datastatuspulang'=>$this->mruangan->ambilData('status_pulang'),
			'no_pendaftaran'=>$no_pendaftaran
		);
		$this->load->view('ruangan/header',$dataheader);
		$this->load->view('ruangan/pulang',$data);
		$this->load->view('footer',$datafooter);
	}

	public function simpandiagnosa()
	{
		$msg=array();
		$no_pendaftaran=$this->input->post('no_pendaftaran');
		$urut=$this->input->post('urut');
		$tgldiagnosa=$this->input->post('tgldiagnosa');
		$jampoli=$this->input->post('jampoli');
		//debugvar($kdpasien);
		$kd_jenis_diagnosa=$this->input->post('kd_jenis_diagnosa');
		$kd_dokter=$this->input->post('kd_dokter');
		$kd_sub_icd=$this->input->post('kd_sub_icd');
		$msg['status']=1;
		$msg['urut']='';
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

		if($kd_sub_icd==''){
			$pesan='Kode ICD tidak boleh kosong';
			$msg['status']=0;
		}
		//
		$this->mrwi->setPasien($no_pendaftaran);
		$this->pasien=$this->mrwi->pasien;
		if($this->mrwi->isPasienDiagnosaExist($urut)){
			//debugvar(json_encode($msg));
			echo json_encode($msg);
			return false;
		}

		$msg['pesan']=$pesan;
		if(!$msg['status']){
			echo json_encode($msg);
			return false;			
		}

		if($this->mrwi->isPasienDiagnosaLama($kd_sub_icd)){
			$status="Lama";
		}else{
			$status="Baru";
		}
		$urut=$this->mrwi->getNextNoUrutDiagnosa();
		//$urut=$urut+1;
		$data_diagnosa=array(
			'no_pendaftaran'=>$this->pasien->no_pendaftaran,
			'urut'=>$urut,
			'tgl_diagnosa'=>convertDate($tgldiagnosa).' '.$jampoli,
			'kd_pasien'=>$this->pasien->kd_pasien,
			'kd_jenis_diagnosa'=>$kd_jenis_diagnosa,
			'kd_dokter'=>$kd_dokter,
			'kd_sub_icd'=>$kd_sub_icd,
			'kd_unit_kerja'=>$this->poli,
			'kd_kelas'=>$this->pasien->kd_kelas,
			'status_kasus'=>$status
			);				

		$this->mruangan->insert('periksa_diagnosa',$data_diagnosa);
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
		
		$this->mrwi->setPasien($no_pendaftaran);
		$kd=explode("#", $kodetarif);
		$itemlayanan1=$this->mruangan->ambilItemData('biaya_pelayanan','no_pendaftaran = "'.$no_pendaftaran.'" and kd_jenis_tarif="'.$kd[0].'" and kd_pelayanan="'.$kd[1].'" and kd_kelas="'.$kd[2].'" and tgl_berlaku="'.$kd[3].'"');
		if(count($itemlayanan1) > 0){
			//debugvar(json_encode($msg));
			echo json_encode($msg);
			return false;
		}

		$kode=explode("#", $kodetarif);
		$urut=$this->mrwi->getNextNoUrutPelayanan();
		$itemlayanan=$this->mruangan->ambilItemData('tarif','kd_jenis_tarif="'.$kode[0].'" and kd_pelayanan="'.$kode[1].'" and kd_kelas="'.$kode[2].'" and tgl_berlaku="'.$kode[3].'"');
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

		$this->mruangan->insert('biaya_pelayanan',$data_pelayanan);
		$this->mrwi->insertbiayapelayanancomponent(0,$no_pendaftaran,$urut,$itemlayanan['kd_jenis_tarif'],$itemlayanan['kd_pelayanan'],$itemlayanan['kd_kelas'],$itemlayanan['tgl_berlaku']);

		$msg['urut']=$urut;
		//$urut=1;
		//$msg['pesan']="Data Berhasil Di Simpan";


		echo json_encode($msg);
	}

	public function periksapindah()
	{
		$msg=array();
		$submit=$this->input->post('submit');
		$tanggal=$this->input->post('tanggal');
		$jam=$this->input->post('jam');
		$no_pendaftaran=$this->input->post('no_pendaftaran');
		$kd_kelas=$this->input->post('kd_kelas');
		$no_kamar=$this->input->post('no_kamar');
		$no_bed=$this->input->post('no_bed');
		$jumlaherror=0;
		$msg['status']=1;
		$msg['clearform']=0;
		$msg['pesanatas']="";
		$msg['pesanlain']="";

		if(empty($tanggal)){
			$jumlaherror++;
			$msg['id'][]="tanggal";
			$msg['pesan'][]="Tanggal Harus di Isi";
		}

		if(empty($jam)){
			$jumlaherror++;
			$msg['id'][]="jam";
			$msg['pesan'][]="Kolom Jam Harus di Isi";
		}

		if(empty($no_pendaftaran)){
			$jumlaherror++;
			$msg['id'][]="no_pendaftaran";
			$msg['pesan'][]="No Pendaftaran Harus di Isi";
		}

		if(empty($kd_kelas)){
			$jumlaherror++;
			$msg['id'][]="kd_kelas";
			$msg['pesan'][]="Kelas Harus di Isi";
		}

		if(empty($no_kamar)){
			$jumlaherror++;
			$msg['id'][]="no_kamar";
			$msg['pesan'][]="No Kamar Harus di Isi";
		}

		if(empty($no_bed)){
			$jumlaherror++;
			$msg['id'][]="no_bed";
			$msg['pesan'][]="No Bed Harus di Isi";
		}

		if(!$this->mruangan->isKasurEmpty($no_kamar,$no_bed)){
			$jumlaherror++;
			$msg['id'][]="no_bed";
			$msg['pesan'][]="No Bed Sudah Terisi";
		}

		if($jumlaherror>0){
			$msg['status']=0;
			$msg['error']=$jumlaherror;
			$msg['pesanatas']="Terdapat beberapa kesalahan input silahkan cek inputan anda";
		}

		echo json_encode($msg);

	}

	public function periksapulang()
	{
		$msg=array();
		$submit=$this->input->post('submit');
		$tanggal=$this->input->post('tanggal');
		$jam=$this->input->post('jam');
		$no_pendaftaran=$this->input->post('no_pendaftaran');
		$kd_kondisi_pulang=$this->input->post('kd_kondisi_pulang');
		$kd_status_pulang=$this->input->post('kd_status_pulang');
		$jumlaherror=0;
		$msg['status']=1;
		$msg['clearform']=0;
		$msg['pesanatas']="";
		$msg['pesanlain']="";

		if(empty($tanggal)){
			$jumlaherror++;
			$msg['id'][]="tanggal";
			$msg['pesan'][]="Tanggal Harus di Isi";
		}

		if(empty($jam)){
			$jumlaherror++;
			$msg['id'][]="jam";
			$msg['pesan'][]="Kolom Jam Harus di Isi";
		}

		if(empty($no_pendaftaran)){
			$jumlaherror++;
			$msg['id'][]="no_pendaftaran";
			$msg['pesan'][]="No Pendaftaran Harus di Isi";
		}

		if(empty($kd_kondisi_pulang)){
			$jumlaherror++;
			$msg['id'][]="kd_kondisi_pulang";
			$msg['pesan'][]="Kondisi PUlang Harus di Isi";
		}

		if(empty($kd_status_pulang)){
			$jumlaherror++;
			$msg['id'][]="kd_status_pulang";
			$msg['pesan'][]="Status Pulang Harus di Isi";
		}

		if($jumlaherror>0){
			$msg['status']=0;
			$msg['error']=$jumlaherror;
			$msg['pesanatas']="Terdapat beberapa kesalahan input silahkan cek inputan anda";
		}

		echo json_encode($msg);

	}

	public function simpanpindah()
	{
		$msg=array();
		//data diri pasien
		$tanggal=$this->input->post('tanggal');
		$jam=$this->input->post('jam');
		$no_pendaftaran=$this->input->post('no_pendaftaran');
		$kd_unit_kerja=$this->input->post('kd_unit_kerja');
		$kd_kelas=$this->input->post('kd_kelas');
		$no_kamar=$this->input->post('no_kamar');
		$no_bed=$this->input->post('no_bed');
		$tanggaloperasi=$this->input->post('tanggaloperasi');
		$jamoperasi=$this->input->post('jamoperasi');
		$jenisoperasi=$this->input->post('jenisoperasi');

		$submit=$this->input->post('submit');

		$this->mrwi->setPasien($no_pendaftaran);
		$this->pasien=$this->mrwi->pasien;

		//$item=$this->madmruangan->getItemPasienRawatInap($no_pendaftaran);
		$this->db->trans_start();
		if($kd_unit_kerja=='87'){
			$no_kamar=1;
			$no_bed=1;
		}
		$urut_sekarang=$this->pasien->urut_sekarang;
		$data_masuk_ruangan=array(
			'no_pendaftaran'=>$no_pendaftaran,
			'urut'=>$urut_sekarang+1,
			'kd_unit_kerja'=>$kd_unit_kerja,
			'kd_kelas'=>$kd_kelas,
			'no_kamar'=>$no_kamar,
			'no_bed'=>$no_bed,
			'tgl_masuk'=>convertDate($tanggal).' '.$jam
			);				

		$this->mruangan->insert('masuk_ruangan',$data_masuk_ruangan);

		$data_keluar_ruangan=array(
			'tgl_keluar'=>convertDate($tanggal).' '.$jam
			);
		$this->mruangan->update('masuk_ruangan',$data_keluar_ruangan,'no_pendaftaran="'.$no_pendaftaran.'" and urut="'.$urut_sekarang.'"');

		//update bed jadi isi
		//$data_status_bed=array(
		//	'status_bed'=>'I'
		//	);
		//$this->mruangan->update('status_bed',$data_status_bed,'no_kamar="'.$no_kamar.'" and no_bed="'.$no_bed.'"');

		if($kd_unit_kerja=='87'){
			$dataoperasi=array(
				'no_pendaftaran'=>$no_pendaftaran,
				'urut'=>1,
				'tanggal'=>convertDate($tanggaloperasi).' '.$jamoperasi,
				'jenis_operasi'=>$jenisoperasi
				);
			$this->mruangan->insert('rencana_operasi',$dataoperasi);
		}

		//update bed lama jadi kosong
		//$data_status_bed=array(
		//	'status_bed'=>'K'
		//	);
		//$this->mruangan->update('status_bed',$data_status_bed,'no_kamar="'.$this->pasien->no_kamar.'" and no_bed="'.$this->pasien->no_bed.'"');


		$this->db->trans_complete();
		$msg['pesan']="Data Berhasil Di Simpan";

		$msg['no_pendaftaran']=$no_pendaftaran;
		$msg['status']=1;
		$msg['keluar']=0;

		echo json_encode($msg);
	}

	public function simpanpulang()
	{
		$msg=array();
		//data diri pasien
		$submit=$this->input->post('submit');
		$tanggal=$this->input->post('tanggal');
		$jam=$this->input->post('jam');
		$no_pendaftaran=$this->input->post('no_pendaftaran');
		$kd_kondisi_pulang=$this->input->post('kd_kondisi_pulang');
		$kd_status_pulang=$this->input->post('kd_status_pulang');

		$submit=$this->input->post('submit');
		
		$this->mrwi->setPasien($no_pendaftaran);
		$this->pasien=$this->mrwi->pasien;
		//$item=$this->madmruangan->getItemPasienRawatInap($no_pendaftaran);
		$this->db->trans_start();
		$urut_sekarang=$this->pasien->urut_sekarang;
		$data_masuk_ruangan=array(
			'tgl_keluar'=>convertDate($tanggal).' '.$jam
			);
		$this->mruangan->update('masuk_ruangan',$data_masuk_ruangan,'no_pendaftaran="'.$no_pendaftaran.'" and urut="'.$urut_sekarang.'"');

		//$data_status_bed=array(
		//	'status_bed'=>'K'
		//	);
		//$this->mruangan->update('status_bed',$data_status_bed,'no_kamar="'.$this->pasien->no_kamar.'" and no_bed="'.$this->pasien->no_bed.'"');

		$data_pasien_pulang=array(
			'no_pendaftaran'=>$no_pendaftaran,
			'kd_kondisi_pulang'=>$kd_kondisi_pulang,
			'kd_status_pulang'=>$kd_status_pulang,
			'kd_user'=>$this->session->userdata("id_user"),
			'tgl_pulang'=>convertDate($tanggal).' '.$jam
			);				

		$this->mruangan->insert('pasien_pulang',$data_pasien_pulang);
		$this->db->trans_complete();
		$msg['pesan']="Data Berhasil Di Simpan";

		$msg['no_pendaftaran']=$no_pendaftaran;
		$msg['status']=1;
		$msg['keluar']=0;

		echo json_encode($msg);
	}

	public function hapusdiagnosa()
	{
		$msg=array();
		$no_pendaftaran=$this->input->post('no_pendaftaran');
		$urut=$this->input->post('urut');

		$this->mruangan->delete('periksa_diagnosa','no_pendaftaran = "'.$no_pendaftaran.'" and urut="'.$urut.'"');

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

		$this->mruangan->delete('biaya_pelayanan','no_pendaftaran = "'.$no_pendaftaran.'" and urut="'.$urut.'"');
		$this->mruangan->delete('biaya_pelayanan_component','no_pendaftaran = "'.$no_pendaftaran.'" and urut="'.$urut.'"');


		echo json_encode($msg);
	}

	public function listkamar(){
		$unit=$this->input->post('unit');
		$kelas=$this->input->post('kelas');
		$kamar=$this->input->post('kamar');
		$items=$this->mrwi->ambilDataKamar($unit,$kelas,$kamar);

		echo json_encode($items);
	}

	public function listkasur(){
		$kamar=$this->input->post('kamar');
		$kasur=$this->input->post('kasur');
		$items=$this->mrwi->ambilDataKasur($kamar,$kasur);

		echo json_encode($items);
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

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */