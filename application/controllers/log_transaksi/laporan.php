<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Laporan extends CI_Controller {

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

	public function __construct()
	{
		parent::__construct();

		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->helper('utilities');
		$this->load->library('pagination');
		$this->load->model('logistik/mlaporan');
	}
	
	public function index()
	{
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

		$data=array();
		$this->load->view('headerlogistik',$dataheader);
		$this->load->view('',$data);
		$this->load->view('footer',$datafooter);
	}
	
	public function distribusibarang(){
		$kd_lokasi_asal=$this->session->userdata('kd_lokasi');
		$nama_lokasi_asal=$this->input->post('nama_lokasi_asal');
		$kd_kategori=$this->input->post('kd_kategori');
		$periodeawal=date('d-m-Y');
		$periodeakhir=date('d-m-Y');
		
		if($this->input->post('periodeawal')!=''){
			$periodeawal=$this->input->post('periodeawal');
		}
		if($this->input->post('periodeakhir')!=''){
			$periodeakhir=$this->input->post('periodeakhir');
		}
		if($this->input->post('kd_kategori')!=''){
			$kd_kategori=$this->input->post('kd_kategori');
		}
		
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
		
		$data=array('items'=>$this->mlaporan->getAllDistribusiBarang($periodeawal,$periodeakhir,$kd_lokasi_asal,$kd_kategori),
					'unitlokasi'=>$this->mlaporan->ambilData('log_lokasi'),
					'periodeawal'=>$periodeawal,
					'periodeakhir'=>$periodeakhir,
					'kd_lokasi_asal'=>$kd_lokasi_asal,
					'kategoribarang'=>$this->mlaporan->ambilData('log_kategori_barang'),
					'kd_kategori'=>$kd_kategori
			);
		//debugvar($data);
		$this->load->view('headerlogistik',$dataheader);
		$this->load->view('laporanlogistik/distribusibarang',$data);
		$this->load->view('footer',$datafooter);
	}

	public function penerimaanbarang(){
		$periodeawal=date('d-m-Y');
		$periodeakhir=date('d-m-Y');
		$kd_lokasi=$this->session->userdata('kd_lokasi');
		$nama_lokasi=$this->input->post('nama_lokasi');
		$kd_vendor='';
		$kd_kategori='';
		if($this->input->post('periodeawal')!=''){
			$periodeawal=$this->input->post('periodeawal');
		}
		if($this->input->post('periodeakhir')!=''){
			$periodeakhir=$this->input->post('periodeakhir');
		}
		/*if($this->input->post('kd_unit_apt')!=''){
			$kd_unit_apt=$this->input->post('kd_unit_apt');
		}*/
		if($this->input->post('kd_vendor')!=''){
			$kd_vendor=$this->input->post('kd_vendor');
		}
		if($this->input->post('kd_kategori')!=''){
			$kd_kategori=$this->input->post('kd_kategori');
		}
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
		
		$data=array('items'=>$this->mlaporan->getAllPenerimaanBarang($periodeawal,$periodeakhir,$kd_lokasi,$kd_vendor,$kd_kategori),
					'unitlokasi'=>$this->mlaporan->ambilData('log_lokasi'),
					'datavendor'=>$this->mlaporan->ambilData('log_vendor'),
					'periodeawal'=>$periodeawal,
					'periodeakhir'=>$periodeakhir,
					'kd_lokasi'=>$kd_lokasi,
					'kd_vendor'=>$kd_vendor,
					'kategoribarang'=>$this->mlaporan->ambilData('log_kategori_barang'),
					'kd_kategori'=>$kd_kategori
			);

		$this->load->view('headerlogistik',$dataheader);
		$this->load->view('laporanlogistik/penerimaanbarang',$data);
		$this->load->view('footer',$datafooter);
	}
	
	public function pemakaianbarang(){
		$periodeawal=date('d-m-Y');
		$periodeakhir=date('d-m-Y');
		$kd_lokasi=$this->session->userdata('kd_lokasi');
		$nama_lokasi=$this->input->post('nama_lokasi');
		$kd_kategori='';
		
		if($this->input->post('periodeawal')!=''){
			$periodeawal=$this->input->post('periodeawal');
		}
		if($this->input->post('periodeakhir')!=''){
			$periodeakhir=$this->input->post('periodeakhir');
		}
		if($this->input->post('kd_kategori')!=''){
			$kd_kategori=$this->input->post('kd_kategori');
		}
		
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
		
		$data=array('items'=>$this->mlaporan->getAllPemakaianBarang($periodeawal,$periodeakhir,$kd_lokasi,$kd_kategori),					
					'periodeawal'=>$periodeawal,
					'periodeakhir'=>$periodeakhir,
					'unitlokasi'=>$this->mlaporan->ambilData('log_lokasi'),
					'kd_lokasi'=>$kd_lokasi,
					'kategoribarang'=>$this->mlaporan->ambilData('log_kategori_barang'),
					'kd_kategori'=>$kd_kategori
			);
	//debugvar($data);
		$this->load->view('headerlogistik',$dataheader);
		$this->load->view('laporanlogistik/pemakaianbarang',$data);
		$this->load->view('footer',$datafooter);
	}
	
	public function persediaanbarang(){
		$kd_kategori='';
		$stok='';
		$isistok='';
		//$kd_unit_apt='';
		$kd_lokasi=$this->session->userdata('kd_lokasi');
		$nama_lokasi=$this->input->post('nama_lokasi');
		
		if($this->input->post('kd_kategori')!=''){
			$kd_kategori=$this->input->post('kd_kategori');
		}
		if($this->input->post('stok')!=''){
			$stok=$this->input->post('stok');
		}
		if($this->input->post('isistok')!=''){
			$isistok=$this->input->post('isistok');
		}
		/*if($this->input->post('kd_unit_apt')!=''){
			$kd_unit_apt=$this->input->post('kd_unit_apt');
		}*/
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
		
		$data=array('items'=>$this->mlaporan->getAllPersediaanBarang($kd_lokasi,$kd_kategori,$stok,$isistok),
					'kd_kategori'=>$kd_kategori,
					'kategoribarang'=>$this->mlaporan->ambilData('log_kategori_barang'),
					'stok'=>$stok,
					'isistok'=>$isistok,
					'kd_lokasi'=>$kd_lokasi,
					'nama_lokasi'=>$nama_lokasi
			);

		$this->load->view('headerlogistik',$dataheader);
		$this->load->view('laporanlogistik/persediaanbarang',$data);
		$this->load->view('footer',$datafooter);
	}

	public function ambilobatbynama(){
		$q=$this->input->get('query');
		$items=$this->mlaporan->ambilData4($q);
		echo json_encode($items);
	}

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */