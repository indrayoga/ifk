<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller {

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
		$this->load->helper('cookie');
		$this->load->model('mutility');

	}
	public function index()
	{
		$this->session->sess_destroy();
		$cssfileheader=array('bootstrap.min.css');
		$jsfileheader=array(
							'vendor/jquery-1.9.1.min.js',
							'spin.js');

		$data=array(
			'jsfile'=>$jsfileheader,
			'cssfile'=>$cssfileheader,
			'dataaplikasi'=>$this->muser->ambilData('aplikasi'),
			'dataakses'=>$this->muser->ambilData('akses','aktif=1')
			);
		$this->load->view('login',$data);
	}
	
	public function periksalogin(){
			$aplikasi=$this->input->post('aplikasi');
			$poli=$this->input->post('poli');
			$username=$this->input->post('username');
			$password=$this->input->post('password');
			//debugvar($aplikasi);
			$msg['status']=1;
			$msg['clearform']=0;
			$msg['pesan']="";
			$jumlaherror=0;
			if(empty($username) || empty($password)){
				$jumlaherror++;
				$msg['pesan']="Username dan Password Harus di Isi";
			}

			//$item=$this->muser->isUserPasswordMatch($username,$password);
			if(!$this->muser->isUserPasswordMatch($username,$password)){
				$jumlaherror++;
				$msg['pesan']="Kombinasi Username dan Password tidak cocok";
			}else{
				$item=$this->muser->ambilItemData('user','username="'.$username.'" and password="'.md5($password).'"');
				
			}

			if($jumlaherror>0){
				$msg['status']=0;
				$msg['error']=$jumlaherror;
			}				
			echo json_encode($msg);

	}	

	public function login(){


		$msg['status']=1;
		$default=$this->input->post('default');
		$aplikasi=50;
		//	debugvar($aplikasi);
		$akses=$this->input->post('akses');
		$username=$this->input->post('username');
		$password=$this->input->post('password');
		$loket=$this->input->post('loket');
		$kasir=$this->input->post('kasir');
		$unit=$this->input->post('unit');
		$apt_unit=$this->input->post('apt_unit');
		$logistik=$this->input->post('logistik');
		$poli=$this->input->post('poli');
		$poliinap=$this->input->post('poliinap');
		$item=$this->muser->ambilItemData('user','username="'.$username.'" and password="'.md5($password).'"');
		//debugvar($item);
		//$pegawai=$this->muser->ambilItemData('pegawai','id_pegawai="'.$item['id_pegawai'].'" ');
		$data=array(
			'username'=>$item['username'],
			'id_user'=>$item['id_user'],
		//	'id_pegawai'=>$item['id_pegawai'],
		//	'nama_pegawai'=>$pegawai['nama_pegawai'],
			'loket'=>$loket,
			'kasir'=>$kasir,
			'unit'=>$unit,
			'kd_lokasi'=>$logistik,
			'kd_lokasi_gudang'=>'01',
			'kd_unit_apt'=>$apt_unit,
			'kd_unit_apt_gudang'=>'U01',
			'kd_unit_apt2'=>'U02',
			'ruangan'=>$poliinap,
			'aplikasi'=>$aplikasi
			);


		if($aplikasi==1 || $aplikasi==4 || $aplikasi==5){
			$data['unitshift']="RWJ";
		}else if($aplikasi==2){
			$data['unitshift']="IGD";
		}else if($aplikasi==3 || $aplikasi==7){
			$data['unitshift']="RWI";
		}else{
			$data['unitshift']="RWJ";
		}

		$msg['poli']='';

		if($akses=='115'){
			$poliinap="87";
			$poli=87;
			$data['poli']=$poli;
			$msg['poli']=$poli;
		}
		if($akses=='112' || $akses=='101'){
			$poli="1";
			$kasir="1";
			$data['poli']=$poli;
			$msg['poli']=$poli;
			$data['kasir']=$kasir;
		}
		if($akses=='113'){
			$data['poli']=$poli;
			$msg['poli']=$poli;
		}
		if($aplikasi=='4'){
			$kasirpoli=$this->mutility->ambilItemData('kasir_unit','kd_unit_kerja="'.$poli.'"');
			$kasir=$kasirpoli['kd_kasir'];
			$loket=1;
			$data['poli']=$poli;
			$data['kasir']=$kasir;
			$data['loket']=$loket;
			$msg['poli']=$poli;
		}

		if($aplikasi=='5'){
			$data['kd_unit_apt']='U02';
		}

		if($aplikasi=='7'){
			$kasirpoli=$this->mutility->ambilItemData('kasir_unit','kd_unit_kerja="'.$poli.'"');
			$kasir=0;
			$loket=1;
			$data['poli']=$poliinap;
			$data['kasir']=$kasir;
			$data['loket']=$loket;
			$msg['poli']=$poliinap;
		}

		if($aplikasi=='2'){
			$kasirpoli=$this->mutility->ambilItemData('kasir_unit','kd_unit_kerja="100"');
			$kasir=$kasirpoli['kd_kasir'];
			$loket=1;
			$data['poli']=100;
			$data['kasir']=$kasir;
			$data['loket']=$loket;
			$msg['poli']=$poli;
			//debugvar($kasir);
		}

		if($aplikasi=='6'){
			$data['poli']=102;
			$msg['poli']=$poli;
			//debugvar($kasir);
		}


		if(!empty($poliinap)){
			$poli=$poliinap;
			$data['poli']=$poli;
			$msg['poli']=$poli;
		}
		$this->session->set_userdata($data);
		//debugvar($data['poli']);
		if($default){
			//debugvar($akses);

		$year = time() + 31536000;

   		 setcookie("aplikasi", $aplikasi, time()+31536000);
   		 setcookie("poli", $poli, time()+31536000);
		}

		$msg['aplikasi']=$aplikasi;
		$msg['kd_unit_apt']='D02';
		echo json_encode($msg);

	}

	public function logout(){
		$this->index();
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
							'spin.js',
							'main.js');
		$this->title="Dashboard ";
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
			);
		//debugvar($this->pagination->create_links());
		$this->load->view('reg/rwj/header',$dataheader);
		$this->load->view('restricted',$data);
		$this->load->view('footer',$datafooter);
	}

	public function dashboard(){
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
							'spin.js',
							'main.js');
		$this->title="Dashboard ";
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
			);
		//debugvar($this->pagination->create_links());
		$this->load->view('reg/rwj/header',$dataheader);
		$this->load->view('dashboard',$data);
		$this->load->view('footer',$datafooter);

	}


}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
