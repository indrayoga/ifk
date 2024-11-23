<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

include_once(APPPATH.'controllers/rumahsakit.php');
//class Monitoring extends CI_Controller {
class Monitoring extends Rumahsakit {

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

	protected $title='GFK KOTA BONTANG';

	public function __construct(){
		parent::__construct();
		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->helper('utilities');
		$this->load->library('pagination');
		$this->load->model('apotek/mmonitoring');
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

		//$this->load->view('master/header',$dataheader);
		$this->load->view('headerapotek',$dataheader);
		$data=array();
		parent::view_restricted($data);
		$this->load->view('footer');
	}
	
	public function index()	{
		if(!$this->muser->isAkses("26")){
			$this->restricted();
			return false;
		}
		
		$nama_obat='';
		$kd_obat='';
		
		if($this->input->post('nama_obat')!=''){
			$nama_obat=$this->input->post('nama_obat');
		}
		if($this->input->post('kd_obat')!=''){
			$kd_obat=$this->input->post('kd_obat');
		}
			
		$cssfileheader=array('bootstrap.css','bootstrap-responsive.min.css','font-awesome.min.css','style.css','prettify.css','jquery-ui.css','DT_bootstrap.css','responsive-tables.css','datepicker.css','theme.css');
		$jsfileheader=array('vendor/modernizr-2.6.2-respond-1.1.0.min.js','vendor/jquery-1.9.1.min.js','vendor/jquery-migrate-1.1.1.min.js','vendor/jquery-ui-1.10.0.custom.min.js','vendor/bootstrap.min.js',
							'lib/jquery.tablesorter.min.js','lib/jquery.dataTables.min.js','lib/DT_bootstrap.js','lib/responsive-tables.js',
							'lib/bootstrap-datepicker.js',
							'lib/bootstrap-inputmask.js',
							'spin.js',
							'main.js');
		$dataheader=array('jsfile'=>$jsfileheader,'cssfile'=>$cssfileheader,'title'=>$this->title);
		$jsfooter=array();
		$datafooter=array('jsfile'=>$jsfooter);
		$data=array('nama_obat'=>$nama_obat,
					'kd_obat'=>$kd_obat,
					'items'=>$this->mmonitoring->getData($nama_obat,$kd_obat));
		
		$this->load->view('headerapotek',$dataheader);
		$this->load->view('apotek/master/monitoring/monitoring',$data);
		$this->load->view('footer',$datafooter);
	}
	
	public function ambilobatbynama(){
		$q=$this->input->get('query');
		$items=$this->mmonitoring->ambilObat($q);
		echo json_encode($items);
		/*$nama_obat=$this->input->post('nama_obat');
		$kd_unit_apt=$this->session->userdata('kd_unit_apt');		
		
		$this->datatables->select("apt_stok_unit.kd_obat,apt_obat.nama_obat,apt_satuan_kecil.satuan_kecil,'pilihan' as pilihan",false);
		
		$this->datatables->from("apt_stok_unit");
		$this->datatables->edit_column('pilihan', '<a class="btn" onclick=\'pilihobat("$1","$2","$3","$4")\'>Pilih</a>','apt_stok_unit.kd_obat,apt_obat.nama_obat');		
		if(!empty($nama_obat))$this->datatables->like('apt_obat.nama_obat',$nama_obat,'both');
		
		$this->datatables->where('apt_stok_unit.kd_unit_apt',$kd_unit_apt);
		
		$this->datatables->join('apt_obat','apt_obat.kd_obat=apt_stok_unit.kd_obat');
		$this->datatables->join('apt_satuan_kecil','apt_satuan_kecil.kd_satuan_kecil=apt_obat.kd_satuan_kecil');		
		//$this->datatables->join('apt_unit','apt_stok_unit.kd_unit_apt=apt_unit.kd_unit_apt');
		$results = $this->datatables->generate();
		echo ($results);*/
	}
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */