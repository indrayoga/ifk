<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

include_once(APPPATH.'controllers/rumahsakit.php');
class Akun extends Rumahsakit {

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
		$this->load->model('makun');

	}

	public function restricted(){
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

		$this->load->view('master/header',$dataheader);
		$data=array();
		parent::view_restricted($data);
		$this->load->view('footer');
	}

	public function index()
	{
		if(!$this->muser->isAkses("910")){
			$this->restricted();
			return false;
		}
		$akun=$this->input->post('akun');
		$group=$this->input->post('group');
		$cssfileheader=array('bootstrap.min.css','bootstrap-responsive.min.css','font-awesome.min.css','style.css','prettify.css','jquery-ui.css','DT_bootstrap.css','responsive-tables.css','theme.css');
		$jsfileheader=array('vendor/modernizr-2.6.2-respond-1.1.0.min.js',
							'vendor/jquery-1.9.1.min.js',
							'vendor/jquery-migrate-1.1.1.min.js',
							'vendor/jquery-ui-1.10.0.custom.min.js',
							'vendor/bootstrap.min.js',
							'lib/jquery.tablesorter.min.js',
							'lib/jquery.dataTables.min.js',
							'lib/DT_bootstrap.js',
							'lib/responsive-tables.js',
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
			'items'=>$this->makun->ambilData("accounts",'name like "%'.$akun.'%" and groups like "%'.$group.'%"'),
			
		);
		$this->load->view('header',$dataheader);
		$this->load->view('akun',$data);
		$this->load->view('footer',$datafooter);
	}

	public function sap()
	{
		$akun=$this->input->post('akun');
		$group=$this->input->post('group');
		$cssfileheader=array('bootstrap.min.css','bootstrap-responsive.min.css','font-awesome.min.css','style.css','prettify.css','jquery-ui.css','DT_bootstrap.css','responsive-tables.css','theme.css');
		$jsfileheader=array('vendor/modernizr-2.6.2-respond-1.1.0.min.js',
							'vendor/jquery-1.9.1.min.js',
							'vendor/jquery-migrate-1.1.1.min.js',
							'vendor/jquery-ui-1.10.0.custom.min.js',
							'vendor/bootstrap.min.js',
							'lib/jquery.tablesorter.min.js',
							'lib/jquery.dataTables.min.js',
							'lib/DT_bootstrap.js',
							'lib/responsive-tables.js',
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
			'items'=>$this->makun->ambilData("accounts_sap",'name like "%'.$akun.'%" and groups like "%'.$group.'%"'),
			
		);
		$this->load->view('header',$dataheader);
		$this->load->view('akunsap',$data);
		$this->load->view('footer',$datafooter);
	}
		
	public function tambahakun()
	{
		$cssfileheader=array('bootstrap.min.css','bootstrap-responsive.min.css','font-awesome.min.css','style.css','prettify.css','jquery-ui.css','DT_bootstrap.css','responsive-tables.css','theme.css');
		$jsfileheader=array('vendor/modernizr-2.6.2-respond-1.1.0.min.js',
							'vendor/jquery-1.9.1.min.js',
							'vendor/jquery-migrate-1.1.1.min.js',
							'vendor/jquery-ui-1.10.0.custom.min.js',
							'vendor/bootstrap.min.js',
							'lib/jquery.tablesorter.min.js',
							'lib/jquery.dataTables.min.js',
							'lib/DT_bootstrap.js',
							'lib/responsive-tables.js',
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
			'comboLevel'=>$this->makun->comboLevel(),
		);
		$this->load->view('header',$dataheader);
		$this->load->view('tambahakun',$data);
		$this->load->view('footer',$datafooter);
	}

	public function tambahakunsap()
	{
		$cssfileheader=array('bootstrap.min.css','bootstrap-responsive.min.css','font-awesome.min.css','style.css','prettify.css','jquery-ui.css','DT_bootstrap.css','responsive-tables.css','theme.css');
		$jsfileheader=array('vendor/modernizr-2.6.2-respond-1.1.0.min.js',
							'vendor/jquery-1.9.1.min.js',
							'vendor/jquery-migrate-1.1.1.min.js',
							'vendor/jquery-ui-1.10.0.custom.min.js',
							'vendor/bootstrap.min.js',
							'lib/jquery.tablesorter.min.js',
							'lib/jquery.dataTables.min.js',
							'lib/DT_bootstrap.js',
							'lib/responsive-tables.js',
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
			'comboLevel'=>$this->mmaster->comboLevel(),
		);
		$this->load->view('header',$dataheader);
		$this->load->view('tambahakunsap',$data);
		$this->load->view('footer',$datafooter);
	}
	
	public function simpanAkun(){
		$akunlama=$this->input->post('akunlama');
		$akun=$this->input->post('akun');
		$nama_akun=$this->input->post('nama_akun');
		$type=$this->input->post('type');
		$level=$this->input->post('level');
		$induk=$this->input->post('induk');
		$group=$this->input->post('group');
		$id=$this->input->post('id');
		$cekDuplicate=$this->makun->duplicateCek('accounts','account='.$akun);
		$data=array(
			'account'=>$akun,
			'name'=>$nama_akun,
			'type'=>$type,
			'levels'=>$level,
			'parent'=>$induk,
			'groups'=>$group
		);
		if(empty($id)){
			$execute=$this->makun->insert('accounts',$data);
			
			$itm=$this->makun->ambilDataTahunACCValue();
			foreach($itm as $thn){
				$dataaccvalue=array(
					'years'=>$thn['years'],
					'account'=>$akun
				);
				$execute1=$this->makun->insert('acc_value',$dataaccvalue);
			}
			/*else{
				$data=array(
					'akun'=>'Nomor Akun Sudah Ada !',
					'nama_akun'=>$nama_akun,
					'type'=>$type,
					'comboLevel'=>$this->makun->comboLevel($level),
					'induk'=>$induk,
					'group'=>$group
				);
				$this->load->view('header',$dataheader);
				$this->load->view('tambahakun',$data);
				$this->load->view('footer',$datafooter);
			}*/
		}else{
			$execute=$this->makun->update('accounts',$data,'account='.$akunlama);
			$dataaccval=array('account'=>$akun);
			$execute1=$this->makun->update('acc_value',$dataaccval,'account='.$akunlama);
		}
		if($execute){
			redirect('/akun/');
		}
	}
	
	public function simpanAkunsap(){
		$akun=$this->input->post('akun');
		$nama_akun=$this->input->post('nama_akun');
		$type=$this->input->post('type');
		$level=$this->input->post('level');
		$induk=$this->input->post('induk');
		$group=$this->input->post('group');
		$id=$this->input->post('id');
		$cekDuplicate=$this->makun->duplicateCek('accounts_sap','account='.$akun);
		$data=array(
			'account'=>$akun,
			'name'=>$nama_akun,
			'type'=>$type,
			'levels'=>$level,
			'parent'=>$induk,
			'groups'=>$group
		);
		if(empty($id)){
			$execute=$this->makun->insert('accounts_sap',$data);
				
			/*else{
				$data=array(
					'akun'=>'Nomor Akun Sudah Ada !',
					'nama_akun'=>$nama_akun,
					'type'=>$type,
					'comboLevel'=>$this->makun->comboLevel($level),
					'induk'=>$induk,
					'group'=>$group
				);
				$this->load->view('header',$dataheader);
				$this->load->view('tambahakun',$data);
				$this->load->view('footer',$datafooter);
			}*/
		}else{
			$execute=$this->makun->update('accounts_sap',$data,'account='.$akun);
		}
		if($execute){
			redirect('/akun/');
		}
	}
	
	public function editAkun($id=""){
		$cssfileheader=array('bootstrap.min.css','bootstrap-responsive.min.css','font-awesome.min.css','style.css','prettify.css','jquery-ui.css','DT_bootstrap.css','responsive-tables.css','theme.css');
		$jsfileheader=array('vendor/modernizr-2.6.2-respond-1.1.0.min.js',
							'vendor/jquery-1.9.1.min.js',
							'vendor/jquery-migrate-1.1.1.min.js',
							'vendor/jquery-ui-1.10.0.custom.min.js',
							'vendor/bootstrap.min.js',
							'lib/jquery.tablesorter.min.js',
							'lib/jquery.dataTables.min.js',
							'lib/DT_bootstrap.js',
							'lib/responsive-tables.js',
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
			'comboLevel'=>$this->makun->comboLevel(),
		);
		if(!empty($id)){
			$items=$this->makun->ambilItemData('accounts','account='.$id);
			$data=array(
				'akun'=>$items['account'],
				'nama_akun'=>$items['name'],
				'type'=>$items['type'],
				'comboLevel'=>$this->makun->comboLevel($items['levels']),
				'induk'=>$items['parent'],
				'group'=>$items['groups'],
				'id'=>$items['account']
			);
				$this->load->view('header',$dataheader);
				$this->load->view('tambahakun',$data);
				$this->load->view('footer',$datafooter);
		}
	}
	
	public function editAkunsap($id=""){
		$cssfileheader=array('bootstrap.min.css','bootstrap-responsive.min.css','font-awesome.min.css','style.css','prettify.css','jquery-ui.css','DT_bootstrap.css','responsive-tables.css','theme.css');
		$jsfileheader=array('vendor/modernizr-2.6.2-respond-1.1.0.min.js',
							'vendor/jquery-1.9.1.min.js',
							'vendor/jquery-migrate-1.1.1.min.js',
							'vendor/jquery-ui-1.10.0.custom.min.js',
							'vendor/bootstrap.min.js',
							'lib/jquery.tablesorter.min.js',
							'lib/jquery.dataTables.min.js',
							'lib/DT_bootstrap.js',
							'lib/responsive-tables.js',
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
			'comboLevel'=>$this->makun->comboLevel(),
		);
		if(!empty($id)){
			$items=$this->makun->ambilItemData('accounts_sap','account='.$id);
			$data=array(
				'akun'=>$items['account'],
				'nama_akun'=>$items['name'],
				'type'=>$items['type'],
				'comboLevel'=>$this->makun->comboLevel($items['levels']),
				'induk'=>$items['parent'],
				'group'=>$items['groups'],
				'id'=>$items['account']
			);
				$this->load->view('header',$dataheader);
				$this->load->view('tambahakunsap',$data);
				$this->load->view('footer',$datafooter);
		}
	}
		
	public function deleteAkun($id=""){
		if(!empty($id)){
			$this->makun->delete('accounts','account='.$id);
			redirect('/akun/');
		}
	}
	
	public function deleteAkunsap($id=""){
		if(!empty($id)){
			$this->makun->delete('accounts_sap','account='.$id);
			redirect('/akun/');
		}
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
