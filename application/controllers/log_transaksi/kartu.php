<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Kartu extends CI_Controller {

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

	public function __construct(){
		parent::__construct();
		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->helper('utilities');
		$this->load->library('pagination');
		$this->load->model('logistik/mkartu');
	}
	
	public function index()	{
		$nama_barang='';
		$kd_barang='';
		//$kd_lokasi='';
		$kd_lokasi=$this->session->userdata('kd_lokasi');
		$bulan=date('m');
		$tahun=date('Y');
		
		if($this->input->post('nama_barang')!=''){
			$nama_barang=$this->input->post('nama_barang');
		}
		if($this->input->post('kd_barang')!=''){
			$kd_barang=$this->input->post('kd_barang');
		}
		if($this->input->post('bulan')!=''){
			$bulan=$this->input->post('bulan');
		}
		if($this->input->post('tahun')!=''){
			$tahun=$this->input->post('tahun');
		}		
		$cssfileheader=array('bootstrap.min.css','bootstrap-responsive.min.css','font-awesome.min.css','style.css','prettify.css','jquery-ui.css','DT_bootstrap.css','responsive-tables.css','datepicker.css','theme.css');
		$jsfileheader=array('vendor/modernizr-2.6.2-respond-1.1.0.min.js','vendor/jquery-1.9.1.min.js','vendor/jquery-migrate-1.1.1.min.js','vendor/jquery-ui-1.10.0.custom.min.js','vendor/bootstrap.min.js',
							'lib/jquery.tablesorter.min.js','lib/jquery.dataTables.min.js','lib/DT_bootstrap.js','lib/responsive-tables.js',
							'lib/bootstrap-datepicker.js',
							'lib/bootstrap-inputmask.js',
							'spin.js',
							'main.js');
		$dataheader=array('jsfile'=>$jsfileheader,'cssfile'=>$cssfileheader,'title'=>$this->title);
		$jsfooter=array();
		$datafooter=array('jsfile'=>$jsfooter);
		$data=array('nama_barang'=>$nama_barang,
					'kd_barang'=>$kd_barang,
					'kd_lokasi'=>$kd_lokasi,
					'bulan'=>$bulan,
					'tahun'=>$tahun,					
					'items'=>$this->mkartu->getKartuStok($kd_barang,$bulan,$tahun)
					//'items'=>$this->mkartu->getData($nama_barang,$kd_barang,$kd_lokasi)
					);
		//debugvar($data);
		$this->load->view('headerlogistik',$dataheader);
		$this->load->view('logistik/transaksi/kartu/kartu',$data);
		$this->load->view('footer',$datafooter);
	}
	
	public function ambilbarangbynama(){
		$q=$this->input->get('query');
		$items=$this->mkartu->ambilBarang($q);
		echo json_encode($items);
	}
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */