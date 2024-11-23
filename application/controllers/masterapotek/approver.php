<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

include_once(APPPATH.'controllers/rumahsakit.php');
//class Approver extends CI_Controller {
class Approver extends Rumahsakit {

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
		$this->load->model('apotek/mapprover');

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
	
	public function index()
	{
		if(!$this->muser->isAkses("82")){
			$this->restricted();
			return false;
		}
		
		$nama_approver=$this->input->post('nama_approver');
		
		$cssfileheader=array('bootstrap.css','bootstrap-responsive.min.css','font-awesome.min.css','style.css','prettify.css','jquery-ui.css','DT_bootstrap.css','responsive-tables.css','theme.css');
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
		$data=array('nama_approver'=>$nama_approver,
					'items'=>$this->mapprover->ambilDataApprover($nama_approver)
					);
		
		$this->load->view('headerapotek',$dataheader);
		$this->load->view('apotek/master/approver/approver',$data);
		$this->load->view('footer',$datafooter);
	}
	
	public function tambah()
	{
		if(!$this->muser->isAkses("83")){
			$this->restricted();
			return false;
		}
		
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

		$data=array('datakecil'=>$this->mapprover->ambilData('pegawai'),
					'datausername'=>$this->mapprover->ambilData('user'));
					
		$this->load->view('headerapotek',$dataheader);
		$this->load->view('apotek/master/approver/tambahapprover',$data);
		$this->load->view('footer',$datafooter);
	}

	public function periksa()
	{
		$msg=array();
		$mode=$this->input->post('mode');
		$submit=$this->input->post('submit');
		$kd_app=$this->input->post('kd_app');
		$id_user=$this->input->post('id_user');
		$id_pegawai=$this->input->post('id_pegawai');
		$urut=$this->input->post('urut');
		$jumlaherror=0;
		$msg['status']=1;
		$msg['clearform']=0;
		$msg['pesanatas']="";
		$msg['pesanlain']="";

		if($mode!="edit"){
			if($this->mapprover->isExist('approval','kd_app',$kd_app)){
				$jumlaherror++;
				$msg['id'][]="kd_app";
				$msg['pesan'][]="Kd. Approval sudah ada";
			}			
		}
		/*if(empty($kd_obat)){
			$jumlaherror++;
			$msg['id'][]="kd_obat";
			$msg['pesan'][]="Kode obat Harus di Isi";
		}*/
		if(empty($id_pegawai)){
			$jumlaherror++;
			$msg['id'][]="id_pegawai";
			$msg['pesan'][]="Pegawai belum dipilih";
		}	
		if(empty($id_user)){
			$jumlaherror++;
			$msg['id'][]="id_user";
			$msg['pesan'][]="User belum dipilih";
		}
		if($jumlaherror>0){
			$msg['status']=0;
			$msg['error']=$jumlaherror;
			$msg['pesanatas']="Terdapat beberapa kesalahan input silahkan cek inputan anda";
		}
		
		echo json_encode($msg);
	}

	public function simpan(){
		$msg=array();
		$kd_app=$this->input->post('kd_app');
		$id_user=$this->input->post('id_user');
		$id_pegawai=$this->input->post('id_pegawai');
		$urut=$this->input->post('urut');
		
		//$msg['kd_app']=$kd_app;
		
		$kode=$this->mapprover->autoNumber();
		$kodebaru=$kode+1;
		$kd_app=str_pad($kodebaru,3,0,STR_PAD_LEFT);
		$urut=$this->mapprover->ambilurutnya();
		$urut1=$urut+1;
		//debugvar($kodebaru);
		$msg['kd_app']=$kd_app;
		$tambahpegawai=array('kd_app'=>$kd_app,
						  'id_user'=>$id_user,
						  'urut'=>$urut1);
		$this->mapprover->insert('approval',$tambahpegawai);
		
		$msg['pesan']="Data Berhasil Di Simpan";
		$msg['status']=1;
		$msg['posting']=3;

		echo json_encode($msg);
	}

	public function update(){
		$msg=array();
		$kd_app=$this->input->post('kd_app');
		$id_user=$this->input->post('id_user');
		$id_pegawai=$this->input->post('id_pegawai');
		$urut=$this->input->post('urut');
		
		$editapp=array('urut'=>$urut,
					'id_user'=>$id_user);
		$this->mapprover->update('approval',$editapp,'kd_app="'.$kd_app.'"');		
		
		$msg['kd_app']=$kd_app;
		
		$msg['pesan']="Data Berhasil Di Edit";
		$msg['status']=1;
		$msg['posting']=3;

		echo json_encode($msg);
	}

	public function edit($id=""){
		if(!$this->muser->isAkses("84")){
			$this->restricted();
			return false;
		}
		
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
		$data=array('datakecil'=>$this->mapprover->ambilData('pegawai'),
					'datausername'=>$this->mapprover->ambilData('user'),
					'kd_app'=>$id,
					'item'=>$this->mapprover->ambilItemDataApprover($id));
		//debugvar($id);
		$this->load->view('headerapotek',$dataheader);
		$this->load->view('apotek/master/approver/editapprover',$data);
		$this->load->view('footer',$datafooter);

	}
	
	public function hapus($id=""){
		if(!$this->muser->isAkses("85")){
			$this->restricted();
			return false;
		}
		
		if(!empty($id)){
			$this->mapprover->delete('approval','kd_app="'.$id.'"');
			redirect('/masterapotek/approver/');
		}
	}
	
	public function ambilusername()
	{
		$q=$this->input->get('query');
		$items=$this->mapprover->ambilusername1($q);
		echo json_encode($items);
	}
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */