<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Diagnosa extends CI_Controller {

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
	protected $akses='106';

	public function __construct()
	{
		parent::__construct();

		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->helper('utilities');
		$this->load->library('pagination');
		$this->load->model('poli/mdiagnosa');
		$this->load->model('fo/mkasir');

		
	}

	public function index($kd_pasien="NULL",$nama_pasien="NULL",$periodeawal="NULL",$periodeakhir="NULL",$jns_kelamin="NULL")
	{
		if($this->input->post('kd_pasien')!='')$kd_pasien=$this->input->post('kd_pasien');
		if($this->input->post('nama_pasien')!='')$nama_pasien=$this->input->post('nama_pasien');
		if($this->input->post('jns_kelamin')!='')$jns_kelamin=$this->input->post('jns_kelamin');
		if($this->input->post('periodeawal')!='')$periodeawal=$this->input->post('periodeawal'); else $periodeawal=date('d-m-Y');
		if($this->input->post('periodeakhir')!='')$periodeakhir=$this->input->post('periodeakhir'); else $periodeakhir=date('d-m-Y');

		$cssfileheader=array('bootstrap.min.css','bootstrap-responsive.min.css','font-awesome.min.css','style.css','prettify.css','jquery-ui.css','DT_bootstrap.css','responsive-tables.css','datepicker.css','theme.css');
		$jsfileheader=array(
							'vendor/jquery-1.9.1.min.js',
							'vendor/jquery-ui-1.10.0.custom.min.js',
							'vendor/bootstrap.min.js',
							'lib/jquery.tablesorter.min.js',
							'lib/jquery.dataTables.min.js',
							'lib/DT_bootstrap.js',
							'lib/responsive-tables.js',
							'lib/bootstrap-datepicker.js',
							'lib/bootstrap-inputmask.js',
							'main.js','style-switcher.js');
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
			'jns_kelamin'=>$jns_kelamin,
			'items'=>$this->mdiagnosa->getAllDaftarPasien($kd_pasien,$nama_pasien,convertDate($periodeawal),convertDate($periodeakhir),$jns_kelamin,1,50,$this->uri->segment(9))
			);
		//debugvar($this->pagination->create_links());
		$this->load->view('poli/headerRWJ',$dataheader);
		$this->load->view('poli/daftar',$data);
		$this->load->view('footer',$datafooter);
	}

	public function igd($kd_pasien="NULL",$nama_pasien="NULL",$periodeawal="NULL",$periodeakhir="NULL",$jns_kelamin="NULL")
	{
		if($this->input->post('kd_pasien')!='')$kd_pasien=$this->input->post('kd_pasien');
		if($this->input->post('nama_pasien')!='')$nama_pasien=$this->input->post('nama_pasien');
		if($this->input->post('jns_kelamin')!='')$jns_kelamin=$this->input->post('jns_kelamin');
		if($this->input->post('periodeawal')!='')$periodeawal=$this->input->post('periodeawal'); else $periodeawal=date('d-m-Y');
		if($this->input->post('periodeakhir')!='')$periodeakhir=$this->input->post('periodeakhir'); else $periodeakhir=date('d-m-Y');

		$cssfileheader=array('bootstrap.min.css','bootstrap-responsive.min.css','font-awesome.min.css','style.css','prettify.css','jquery-ui.css','DT_bootstrap.css','responsive-tables.css','datepicker.css','theme.css');
		$jsfileheader=array(
							'vendor/jquery-1.9.1.min.js',
							'vendor/jquery-ui-1.10.0.custom.min.js',
							'vendor/bootstrap.min.js',
							'lib/jquery.tablesorter.min.js',
							'lib/jquery.dataTables.min.js',
							'lib/DT_bootstrap.js',
							'lib/responsive-tables.js',
							'lib/bootstrap-datepicker.js',
							'lib/bootstrap-inputmask.js',
							'main.js','style-switcher.js');
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
			'jns_kelamin'=>$jns_kelamin,
			'items'=>$this->mdiagnosa->getAllDaftarPasien($kd_pasien,$nama_pasien,convertDate($periodeawal),convertDate($periodeakhir),$jns_kelamin,2,50,$this->uri->segment(9))
			);
		//debugvar($this->pagination->create_links());
		$this->load->view('poli/headerRWJ',$dataheader);
		$this->load->view('poli/daftar',$data);
		$this->load->view('footer',$datafooter);
	}
	
	public function inap($kd_pasien="NULL",$nama_pasien="NULL",$periodeawal="NULL",$periodeakhir="NULL",$jns_kelamin="NULL")
	{
		if($this->input->post('kd_pasien')!='')$kd_pasien=$this->input->post('kd_pasien');
		if($this->input->post('nama_pasien')!='')$nama_pasien=$this->input->post('nama_pasien');
		if($this->input->post('jns_kelamin')!='')$jns_kelamin=$this->input->post('jns_kelamin');
		if($this->input->post('periodeawal')!='')$periodeawal=$this->input->post('periodeawal'); else $periodeawal=date('d-m-Y');
		if($this->input->post('periodeakhir')!='')$periodeakhir=$this->input->post('periodeakhir'); else $periodeakhir=date('d-m-Y');

		$cssfileheader=array('bootstrap.min.css','bootstrap-responsive.min.css','font-awesome.min.css','style.css','prettify.css','jquery-ui.css','DT_bootstrap.css','responsive-tables.css','datepicker.css','theme.css');
		$jsfileheader=array(
							'vendor/jquery-1.9.1.min.js',
							'vendor/jquery-ui-1.10.0.custom.min.js',
							'vendor/bootstrap.min.js',
							'lib/jquery.tablesorter.min.js',
							'lib/jquery.dataTables.min.js',
							'lib/DT_bootstrap.js',
							'lib/responsive-tables.js',
							'lib/bootstrap-datepicker.js',
							'lib/bootstrap-inputmask.js',
							'main.js','style-switcher.js');
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
			'jns_kelamin'=>$jns_kelamin,
			'items'=>$this->mdiagnosa->getAllDaftarPasien($kd_pasien,$nama_pasien,convertDate($periodeawal),convertDate($periodeakhir),$jns_kelamin,3,50,$this->uri->segment(9))
			);
		//debugvar($this->pagination->create_links());
		$this->load->view('poli/headerRWJ',$dataheader);
		$this->load->view('poli/daftar',$data);
		$this->load->view('footer',$datafooter);
	}
	
	public function periksa($kd_pasien="",$no_pendaftaran="")
	{
		//if(empty($kd_pasien))return false;
		$cssfileheader=array('bootstrap.min.css','bootstrap-responsive.min.css','font-awesome.min.css','style.css','prettify.css','jquery-ui.css','DT_bootstrap.css','responsive-tables.css','datepicker.css','timepicker.css','theme.css');
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
			'datapelayanan'=>$this->mdiagnosa->getTarifLayanan(),			
			'datadokter'=>$this->mdiagnosa->ambilData('apt_dokter'),
			'datajenisdiagnosa'=>$this->mdiagnosa->ambilData('jenis_diagnosa'),
			'item'=>$this->mdiagnosa->getItemDaftarPasien($no_pendaftaran,$kd_pasien),
			'itemslayanan'=>$this->mdiagnosa->getPelayananByNoDaftar($no_pendaftaran),
			'itemsdiagnosa'=>$this->mdiagnosa->getDiagnosaByNoDaftar($no_pendaftaran),
			'no_pendaftaran'=>$no_pendaftaran,
			'kd_pasien'=>$kd_pasien,
			'unittujuan'=>$this->mdiagnosa->ambilData("unit_kerja")
		);
		$this->load->view('poli/headerRWJ',$dataheader);
		$this->load->view('poli/periksapasien',$data);
		$this->load->view('footer',$datafooter);
	}

	public function periksapasienkonsul($kd_pasien="",$no_pendaftaran="")
	{
		//if(empty($kd_pasien))return false;
		$cssfileheader=array('bootstrap.min.css','bootstrap-responsive.min.css','font-awesome.min.css','style.css','prettify.css','jquery-ui.css','DT_bootstrap.css','responsive-tables.css','datepicker.css','timepicker.css','theme.css');
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
			'datapelayanan'=>$this->mdiagnosa->getTarifLayanan(),			
			'datadokter'=>$this->mdiagnosa->ambilData('apt_dokter'),
			'datajenisdiagnosa'=>$this->mdiagnosa->ambilData('jenis_diagnosa'),
			'item'=>$this->mdiagnosa->getItemKonsulPasien($no_pendaftaran,$kd_pasien),
			'itemslayanan'=>$this->mdiagnosa->getPelayananByNoDaftar($no_pendaftaran),
			'itemsdiagnosa'=>$this->mdiagnosa->getDiagnosaByNoDaftar($no_pendaftaran),
			'no_pendaftaran'=>$no_pendaftaran,
			'kd_pasien'=>$kd_pasien,
			'unittujuan'=>$this->mdiagnosa->ambilData("unit_kerja")
		);
		$this->load->view('poli/headerRWJ',$dataheader);
		$this->load->view('poli/periksapasien',$data);
		$this->load->view('footer',$datafooter);
	}

	public function konsul($kd_pasien="",$no_pendaftaran="")
	{
		//if(empty($kd_pasien))return false;
		$cssfileheader=array('bootstrap.min.css','bootstrap-responsive.min.css','font-awesome.min.css','style.css','prettify.css','jquery-ui.css','DT_bootstrap.css','responsive-tables.css','datepicker.css','timepicker.css','theme.css');
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
			'datadokter'=>$this->mdiagnosa->ambilData('apt_dokter'),
			'item'=>$this->mdiagnosa->getItemDaftarPasien($no_pendaftaran,$kd_pasien),
			'no_pendaftaran'=>$no_pendaftaran,
			'kd_pasien'=>$kd_pasien,
			'unittujuan'=>$this->mdiagnosa->ambilData("unit_kerja")
		);
		$this->load->view('poli/headerRWJ',$dataheader);
		$this->load->view('poli/konsul',$data);
		$this->load->view('footer',$datafooter);
	}
	
	public function checkin($kd_pasien="",$no_pendaftaran=""){
		$data=array(
		'tgl_checkin'=>date('Y-m-d H:i:s')
		);
		$this->mdiagnosa->update('pendaftaran',$data,'no_pendaftaran="'.$no_pendaftaran.'"');
		redirect('poli/diagnosa');
	}
	public function registrasi($kd_pasien="",$no_pendaftaran="")
	{
		//if(empty($kd_pasien))return false;
		$cssfileheader=array('bootstrap.min.css','bootstrap-responsive.min.css','font-awesome.min.css','style.css','prettify.css','jquery-ui.css','DT_bootstrap.css','responsive-tables.css','datepicker.css','timepicker.css','theme.css');
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
			'dataunitkerja'=>$this->mdiagnosa->ambilData('unit_kerja'),			
			'datacustomer'=>$this->mdiagnosa->ambilData('apt_customers'),			
			'datadokter'=>$this->mdiagnosa->ambilData('apt_dokter'),			
			'datapelayanan'=>$this->mdiagnosa->getTarifLayanan(),			
			'dataloket'=>$this->mdiagnosa->ambilData('loket'),			
			'datakasir'=>$this->mdiagnosa->ambilData('kasir'),			
			'datakelaspelayanan'=>$this->mdiagnosa->ambilData('kelas_pelayanan'),			
			'item'=>$this->mdiagnosa->ambilItemData('pasien','kd_pasien="'.$kd_pasien.'"'),
			'itemsdaftar'=>$this->mdiagnosa->getAllHistoryDaftar($kd_pasien),
			'no_pendaftaran'=>$no_pendaftaran,
			'itemdaftar'=>$this->mdiagnosa->ambilItemData('pendaftaran','no_pendaftaran="'.$no_pendaftaran.'"'),
			'itemslayanan'=>$this->mdiagnosa->getPelayananByNoDaftar($no_pendaftaran),
			'kd_pasien'=>$kd_pasien
		);
		$this->load->view('poli/headerRWJ',$dataheader);
		$this->load->view('fo/registrasi',$data);
		$this->load->view('footer',$datafooter);
	}

	public function registrasirwj($kd_pasien="",$no_pendaftaran="")
	{
		//if(empty($kd_pasien))return false;
		$cssfileheader=array('bootstrap.min.css','bootstrap-responsive.min.css','font-awesome.min.css','style.css','prettify.css','jquery-ui.css','DT_bootstrap.css','responsive-tables.css','datepicker.css','timepicker.css','theme.css','chosen.css');
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
							'lib/chosen.jquery.min.js',
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
			'dataunitkerja'=>$this->mdiagnosa->ambilData('unit_kerja'),			
			'datacustomer'=>$this->mdiagnosa->ambilData('apt_customers'),			
			'datadokter'=>$this->mdiagnosa->ambilData('apt_dokter'),			
			'datapelayanan'=>$this->mdiagnosa->getTarifLayanan(),			
			'dataloket'=>$this->mdiagnosa->ambilData('loket'),			
			//'datakasir'=>$this->mdiagnosa->ambilData('kasir'),			
			'datakelaspelayanan'=>$this->mdiagnosa->ambilData('kelas_pelayanan'),			
			'item'=>$this->mdiagnosa->ambilItemData('pasien','kd_pasien="'.$kd_pasien.'"'),
			'itemsdaftar'=>$this->mdiagnosa->getAllHistoryDaftar($kd_pasien),
			'no_pendaftaran'=>$no_pendaftaran,
			'itemdaftar'=>$this->mdiagnosa->ambilItemData('pendaftaran','no_pendaftaran="'.$no_pendaftaran.'"'),
			'itemslayanan'=>$this->mdiagnosa->getPelayananByNoDaftar($no_pendaftaran),
			'kd_pasien'=>$kd_pasien
		);
		$this->load->view('poli/headerRWJ',$dataheader);
		$this->load->view('fo/registrasirwj',$data);
		$this->load->view('footer',$datafooter);
	}


	public function editpengeluaran($nomor="",$bulan="",$tahun="")
	{
		if(empty($nomor))return false;
		if(empty($bulan))return false;
		if(empty($tahun))return false;
		$nomor=$nomor.'/'.$bulan.'/'.$tahun;
		$cssfileheader=array('bootstrap.min.css','bootstrap-responsive.min.css','font-awesome.min.css','style.css','prettify.css','jquery-ui.css','DT_bootstrap.css','responsive-tables.css','datepicker.css','theme.css');
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
			'dataunitkerja'=>$this->mpengeluaran->ambilData('unit_kerja'),			
			'dataakun'=>$this->mpengeluaran->ambilData('accounts'),			
			'datajenispembayaran'=>$this->mpengeluaran->ambilData('acc_payment'),
			'nomor'=>$nomor,
			'itemtransaksi'=>$this->mpengeluaran->ambilItemData('acc_cso','cso_number="'.$nomor.'"'),			
			'itemsdetiltransaksi'=>$this->mpengeluaran->getAllDetailPengeluaran($nomor),			
			'dataakunaktiva'=>$this->mpengeluaran->ambilItemData('sys_setting','key_data="ACCOUNT_AKTIVA"'),			
			'items'=>$this->mpengeluaran->getAllPengeluaran('','','','','')
			);
		$this->load->view('poli/headerRWJ',$dataheader);
		$this->load->view('pengeluaran/tambahpengeluaran',$data);
		$this->load->view('footer',$datafooter);
	}
	
	public function periksapasien()
	{
		$msg=array();
		$submit=$this->input->post('submit');
		$tanggal=$this->input->post('tanggal');
		$jam=$this->input->post('jam');
		$nama_pasien=$this->input->post('nama_pasien');
		$tempat_lahir=$this->input->post('tempat_lahir');
		$tgl_lahir=$this->input->post('tgl_lahir');
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

		if(empty($nama_pasien)){
			$jumlaherror++;
			$msg['id'][]="nama_pasien";
			$msg['pesan'][]="Nama Pasien Harus di Isi";
		}

		if(empty($tempat_lahir)){
			$jumlaherror++;
			$msg['id'][]="tempat_lahir";
			$msg['pesan'][]="Tempat Lahir Harus di Isi";
		}

		if(empty($tgl_lahir)){
			$jumlaherror++;
			$msg['id'][]="tgl_lahir";
			$msg['pesan'][]="Tanggal Lahir Harus di Isi";
		}

		if($jumlaherror>0){
			$msg['status']=0;
			$msg['error']=$jumlaherror;
			$msg['pesanatas']="Terdapat beberapa kesalahan input silahkan cek inputan anda";
		}

		echo json_encode($msg);

	}

	public function periksaregistrasi()
	{
		$msg=array();
		$submit=$this->input->post('submit');
		$tanggal=$this->input->post('tanggal');
		$kd_kasir=$this->input->post('kd_kasir');
		$jam=$this->input->post('jam');
		$kd_unit_kerja=$this->input->post('kd_unit_kerja');
		$no_daftar=$this->input->post('no_daftar');
		$kd_pasien=$this->input->post('kd_pasien');
		$kd_loket=$this->input->post('kd_loket');
		$kd_kelas=$this->input->post('kd_kelas');
		$cust_code=$this->input->post('cust_code');
		$kd_dokter=$this->input->post('kd_dokter');
		$rujuk=$this->input->post('rujuk');
		$rujukan=$this->input->post('rujukan');
		$alamat_rujukan=$this->input->post('alamat_rujukan');
		$kota_rujukan=$this->input->post('kota_rujukan');
		$cara_rujukan=$this->input->post('cara_rujukan');
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

		if(empty($kd_pasien)){
			$jumlaherror++;
			$msg['id'][]="kd_pasien";
			$msg['pesan'][]="No CM Harus di Isi";
		}

		if(empty($kd_loket)){
			$jumlaherror++;
			$msg['id'][]="kd_loket";
			$msg['pesan'][]="Loket Harus di Isi";
		}

		if(empty($kd_kelas)){
			$jumlaherror++;
			$msg['id'][]="kd_kelas";
			$msg['pesan'][]="Kelas Harus di Isi";
		}

		if($cust_code==''){
			$jumlaherror++;
			$msg['id'][]="cust_code";
			$msg['pesan'][]="Customer Harus di Isi";
		}

		if(empty($kd_unit_kerja)){
			$jumlaherror++;
			$msg['id'][]="kd_unit_kerja";
			$msg['pesan'][]="Unit Kerja Harus di Isi";
		}

		if(empty($kd_dokter)){
			$jumlaherror++;
			$msg['id'][]="kd_dokter";
			$msg['pesan'][]="Dokter Harus di Isi";
		}

		if($rujuk=='1'){
			if(empty($rujukan)){
				$jumlaherror++;
				$msg['id'][]="rujukan";
				$msg['pesan'][]="Rujukan Harus di Isi";
			}

			if(empty($alamat_rujukan)){
				$jumlaherror++;
				$msg['id'][]="alamat_rujukan";
				$msg['pesan'][]="Alamat Rujukan Harus di Isi";
			}

			if(empty($alamat_rujukan)){
				$jumlaherror++;
				$msg['id'][]="alamat_rujukan";
				$msg['pesan'][]="Alamat Rujukan Harus di Isi";
			}

			if(empty($cara_rujukan)){
				$jumlaherror++;
				$msg['id'][]="cara_rujukan";
				$msg['pesan'][]="Cara Rujukan Harus di Isi";
			}

		}

		if($jumlaherror>0){
			$msg['status']=0;
			$msg['error']=$jumlaherror;
			$msg['pesanatas']="Terdapat beberapa kesalahan input silahkan cek inputan anda";
		}

		echo json_encode($msg);

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
	
	public function simpanpasien()
	{
		$msg=array();
		//data diri pasien
		$kd_pasien=$this->input->post('kd_pasien');
		$tanggal=$this->input->post('tanggal');
		$jam=$this->input->post('jam');
		$tgl_membership=convertDate($tanggal).' '.$jam;
		$kd_unit_kerja=$this->input->post('kd_unit_kerja');
		$nama_pasien=$this->input->post('nama_pasien');
		$jns_kelamin=$this->input->post('jns_kelamin');
		$gol_darah=$this->input->post('gol_darah');
		$rhesus=$this->input->post('rhesus');
		$tempat_lahir=$this->input->post('tempat_lahir');
		$tgl_lahir=$this->input->post('tgl_lahir');

		//alamat pasien
		$alamat=$this->input->post('alamat');
		$rtrw=$this->input->post('rtrw');
		$kodepos=$this->input->post('kodepos');
		$telepon=$this->input->post('telepon');
		$kd_propinsi=$this->input->post('kd_propinsi');
		$kd_kabupaten=$this->input->post('kd_kabupaten');
		$kd_kecamatan=$this->input->post('kd_kecamatan');
		$kd_kelurahan=$this->input->post('kd_kelurahan');

		//detail pasien
		$no_identitas=$this->input->post('no_identitas');
		$no_hp=$this->input->post('no_hp');
		$warga_negara=$this->input->post('warga_negara');
		$kd_pekerjaan=$this->input->post('kd_pekerjaan');
		$kd_pendidikan=$this->input->post('kd_pendidikan');
		$kd_suku=$this->input->post('kd_suku');
		$kd_status_nikah=$this->input->post('kd_status_nikah');
		$kd_agama=$this->input->post('kd_agama');

		$submit=$this->input->post('submit');

		$msg['kd_pasien']=$kd_pasien;


		if($this->mdiagnosa->isNumberExist($kd_pasien)){
			$data_pasien_update=array(
				'kd_pasien'=>$kd_pasien,
				'kd_pendidikan'=>$kd_pendidikan,
				'no_identitas'=>$no_identitas,
				'tgl_membership'=>$tgl_membership,
				'nama_pasien'=>$nama_pasien,
				'tempat_lahir'=>$tempat_lahir,
				'tgl_lahir'=>convertDate($tgl_lahir),
				'jns_kelamin'=>$jns_kelamin,
				'kd_status_nikah'=>$kd_status_nikah,
				'kd_agama'=>$kd_agama,
				'kd_suku'=>$kd_suku,
				'alamat'=>$alamat,
				'telepon'=>$telepon,
				'kd_pekerjaan'=>$kd_pekerjaan,
				'no_hp'=>$no_hp,
				'warga_negara'=>$warga_negara,
				'gol_darah'=>$gol_darah,
				'rhesus'=>$rhesus,
				'kd_propinsi'=>$kd_propinsi,
				'kd_kabupaten'=>$kd_kabupaten,
				'kd_kecamatan'=>$kd_kecamatan,
				'kd_kelurahan'=>$kd_kelurahan,
				'rtrw'=>$rtrw,
				'kodepos'=>$kodepos
				);				
			$this->mdiagnosa->update('pasien',$data_pasien_update,'kd_pasien="'.$kd_pasien.'"');		
			$msg['pesan']="Data Berhasil Di Update";

		}else{
			$tgl=explode("-", $tanggal);
			$jml_transaksi_bulan_ini=$this->mdiagnosa->getJumlahTransaksiBulan($tgl[2],$tgl[1],$tgl[0]);
			$no_transaksi=$jml_transaksi_bulan_ini+1;
			$no_transaksi=str_pad($no_transaksi,3,0,STR_PAD_LEFT);
			$kd_pasien=$tgl[2].$tgl[1].$tgl[0].$no_transaksi;
			$msg['kd_pasien']=$kd_pasien;
			$data_pasien=array(
				'kd_pasien'=>$kd_pasien,
				'kd_pendidikan'=>$kd_pendidikan,
				'no_identitas'=>$no_identitas,
				'tgl_membership'=>$tgl_membership,
				'nama_pasien'=>$nama_pasien,
				'tempat_lahir'=>$tempat_lahir,
				'tgl_lahir'=>convertDate($tgl_lahir),
				'jns_kelamin'=>$jns_kelamin,
				'kd_status_nikah'=>$kd_status_nikah,
				'kd_agama'=>$kd_agama,
				'kd_suku'=>$kd_suku,
				'alamat'=>$alamat,
				'telepon'=>$telepon,
				'kd_pekerjaan'=>$kd_pekerjaan,
				'no_hp'=>$no_hp,
				'warga_negara'=>$warga_negara,
				'gol_darah'=>$gol_darah,
				'rhesus'=>$rhesus,
				'kd_propinsi'=>$kd_propinsi,
				'kd_kabupaten'=>$kd_kabupaten,
				'kd_kecamatan'=>$kd_kecamatan,
				'kd_kelurahan'=>$kd_kelurahan,
				'rtrw'=>$rtrw,
				'kodepos'=>$kodepos
				);				

			$this->mdiagnosa->insert('pasien',$data_pasien);
			$msg['pesan']="Data Berhasil Di Simpan";
		}
		$msg['status']=1;
		$msg['keluar']=0;

		echo json_encode($msg);
	}

	public function simpandiagnosa()
	{
		$msg=array();
		$no_pendaftaran=$this->input->post('no_pendaftaran');
		$urut=$this->input->post('urut');
		$tgldiagnosa=$this->input->post('tgldiagnosa');
		$jamdiagnosa=$this->input->post('jamdiagnosa');
		$kdpasien=$this->input->post('kdpasien');
		$kd_jenis_diagnosa=$this->input->post('kd_jenis_diagnosa');
		$kd_dokter=$this->input->post('kd_dokter');
		$kd_sub_icd=$this->input->post('kd_sub_icd');
		$kd_unit_kerja=$this->input->post('kd_unit_kerja');
		$kd_kelas=$this->input->post('kd_kelas');
		$msg['status']=1;
		$msg['urut']='';
		if($this->mdiagnosa->isDataDiagnosaExist($no_pendaftaran,$urut)){
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
		if($jamdiagnosa==''){
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
		if(!$this->mdiagnosa->isAdaDiagnosa($kd_sub_icd)){
			$pesan='Kode ICD tidak ada';
			$msg['status']=0;
		}
		//
		$msg['pesan']=$pesan;
		if(!$msg['status']){
			echo json_encode($msg);
			return false;			
		}
		if($this->mdiagnosa->isDiagnosaLama($no_pendaftaran,$kd_sub_icd)){
			$status="Lama";
		}else{
			$status="Baru";
		}
		$urut=$this->mdiagnosa->getMaxUrutDiagnosa($no_pendaftaran);
		$urut=$urut+1;
		$data_diagnosa=array(
			'no_pendaftaran'=>$no_pendaftaran,
			'urut'=>$urut,
			'tgl_diagnosa'=>convertDate($tgldiagnosa).' '.$jamdiagnosa,
			'kd_pasien'=>$kdpasien,
			'kd_jenis_diagnosa'=>$kd_jenis_diagnosa,
			'kd_dokter'=>$kd_dokter,
			'kd_sub_icd'=>$kd_sub_icd,
			'kd_unit_kerja'=>$kd_unit_kerja,
			'kd_kelas'=>$kd_kelas,
			'status_kasus'=>$status
			);				

		$this->mdiagnosa->insert('periksa_diagnosa',$data_diagnosa);
		$msg['urut']=$urut;
		//$urut=1;
		//$msg['pesan']="Data Berhasil Di Simpan";


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
		$this->mdiagnosa->insert('pasien_rujukan',$data);
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
		$unit=$this->input->post('unit');

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
			'kd_unit_kerja'=>$unit,
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

	public function hapusdiagnosa()
	{
		$msg=array();
		$no_pendaftaran=$this->input->post('no_pendaftaran');
		$urut=$this->input->post('urut');

		$this->mdiagnosa->delete('periksa_diagnosa','no_pendaftaran = "'.$no_pendaftaran.'" and urut="'.$urut.'"');

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

		$this->mdiagnosa->delete('biaya_pelayanan','no_pendaftaran = "'.$no_pendaftaran.'" and urut="'.$urut.'"');
		$this->mdiagnosa->delete('biaya_pelayanan_component','no_pendaftaran = "'.$no_pendaftaran.'" and urut="'.$urut.'"');


		echo json_encode($msg);
	}





	public function ambilitem()
	{
		$q=$this->input->get('query');
		$items=$this->mpengeluaran->getPengeluaran($q);

		echo json_encode($items);
	}

	public function ambilitems()
	{
		$q=$this->input->get('query');
		$items=$this->mpengeluaran->getAllDetailPengeluaran($q);

		echo json_encode($items);
	}

	public function ambildatakabupaten()
	{
		$q=$this->input->post('query');
		//$items=$this->mpengeluaran->ambilData('accounts','account like "%'.$q.'%" and type="d" and groups=5');
		$items=$this->mdiagnosa->ambilData('kabupaten','kd_propinsi = "'.$q.'"');

		echo json_encode($items);
	}

	public function listpelayanan(){
		$cust=$this->input->post('cust');
		$kelas=$this->input->post('kelas');
		$unit=$this->input->post('unit');
		$q=$this->input->post('query');
		$items=$this->mkasir->getAllDataLayanan($cust,$kelas,$unit,$q);

		echo json_encode($items);
	}

	public function listdiagnosa($param){
		$q=$this->input->post('query');
		$unit=$this->input->post('unit');
		
		/*if($param==1){
			$items=$this->mdiagnosa->ambilData('sub_diagnosa_icd','kd_sub_icd like "%'.$q.'%"','500');			
		}else{
			$items=$this->mdiagnosa->ambilData('sub_diagnosa_icd','sub_diagnosa_icd like "%'.$q.'%"','500');						
		}*/		
		$items=$this->mkasir->getAllDataDiagnosa($param,$unit,$q);

		echo json_encode($items);
	}

	public function listdiagnosa2($param){
		$q=$this->input->post('query');
		$unit=$this->input->post('unit');
		
		/*if($param==1){
			$items=$this->mdiagnosa->ambilData('sub_diagnosa_icd','kd_sub_icd like "%'.$q.'%"','500');			
		}else{
			$items=$this->mdiagnosa->ambilData('sub_diagnosa_icd','sub_diagnosa_icd like "%'.$q.'%"','500');						
		}*/		
		$items=$this->mkasir->ambilData("sub_diagnosa_icd");

		echo json_encode($items);
	}

	public function ambildatakecamatan()
	{
		$q=$this->input->post('query');
		//$items=$this->mpengeluaran->ambilData('accounts','account like "%'.$q.'%" and type="d" and groups=5');
		$items=$this->mdiagnosa->ambilData('kecamatan','kd_kabupaten = "'.$q.'"');

		echo json_encode($items);
	}

	public function ambildatakelurahan()
	{
		$q=$this->input->post('query');
		//$items=$this->mpengeluaran->ambilData('accounts','account like "%'.$q.'%" and type="d" and groups=5');
		$items=$this->mdiagnosa->ambilData('kelurahan','kd_kecamatan = "'.$q.'"');

		echo json_encode($items);
	}

	public function caripasien()
	{
		$nama=$this->input->post('nama');
		$alamat=$this->input->post('alamat');
		$keluarga=$this->input->post('keluarga');
		$telepon=$this->input->post('telepon');

		$items=$this->mdiagnosa->ambilData('pasien','nama_pasien like "%'.$nama.'%" and nama_keluarga like "%'.$keluarga.'%" and alamat like "%'.$alamat.'%" and telepon like "%'.$telepon.'%" ');

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
