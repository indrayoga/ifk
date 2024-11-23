<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

include_once(APPPATH.'controllers/rumahsakit.php');
//class Tarifapt extends CI_Controller {
class Tarifapt extends Rumahsakit {

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
		$this->load->model('apotek/mtarif');
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
		$this->load->view('headerapotek',$dataheader);
		$this->load->view('',$data);
		$this->load->view('footer',$datafooter);
	}
	
	public function tarifbungkus(){
		if(!$this->muser->isAkses("27")){
			$this->restricted();
			return false;
		}
		
		$tarif_perbungkus="";
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
		$data=array(//'items'=>$this->mtarif->getMutasiObat($kd_unit_apt,$bulan,$tahun),
					'itembungkus'=>$this->mtarif->ambilItemData('sys_setting','key_data="TARIF_PERBUNGKUS"'),
					'tarif_perbungkus'=>$tarif_perbungkus
					);
		//debugvar($data);
		$this->load->view('headerapotek',$dataheader);
		$this->load->view('apotek/tarifbungkus',$data);
		$this->load->view('footer',$datafooter);
	}
	
	public function caritarifbungkus(){
		$msg=array();
		$submit=$this->input->post('submit');
		$tarif_perbungkus=$this->input->post('tarif_perbungkus');
		
		$msg['setting']=$tarif_perbungkus;
		$kode='TARIF_PERBUNGKUS';
		if($submit=="simpantarif"){
			$data=array('setting'=>$tarif_perbungkus);
			$this->mtarif->update('sys_setting',$data,'key_data="'.$kode.'"');
			
			$msg['pesan']="Data Berhasil Di Update";
			//echo json_encode($msg);
		}
		
		$msg['status']=1;
		$msg['keluar']=0;		
		echo json_encode($msg);
	}
	
	public function tarifresep(){
		if(!$this->muser->isAkses("28")){
			$this->restricted();
			return false;
		}
		
		$tarif_resep="";
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
		$data=array(//'items'=>$this->mtarif->getMutasiObat($kd_unit_apt,$bulan,$tahun),
					'itemresep'=>$this->mtarif->ambilItemData('sys_setting','key_data="TARIF_RESEP"'),
					'tarif_resep'=>$tarif_resep
					);
		//debugvar($data);
		$this->load->view('headerapotek',$dataheader);
		$this->load->view('apotek/tarifresep',$data);
		$this->load->view('footer',$datafooter);
	}
	
	public function caritarifresep(){
		$msg=array();
		$submit=$this->input->post('submit');
		$tarif_resep=$this->input->post('tarif_resep');
		
		$msg['setting']=$tarif_resep;
		$kode='TARIF_RESEP';
		if($submit=="simpantarif"){
			$data=array('setting'=>$tarif_resep);
			$this->mtarif->update('sys_setting',$data,'key_data="'.$kode.'"');
			
			$msg['pesan']="Data Berhasil Di Update";
			//echo json_encode($msg);
		}
		
		$msg['status']=1;
		$msg['keluar']=0;		
		echo json_encode($msg);
	}
	
	public function periksabungkus() {
		$msg=array();
		$submit=$this->input->post('submit');
		$tarif_bungkus=$this->input->post('tarif_bungkus');
		
		$jumlaherror=0;
		$msg['status']=1;
		$msg['clearform']=0;
		$msg['pesanatas']="";
		$msg['pesanlain']="";
		
		if($submit=="simpantarif"){
			/*if(!is_numeric($tarif_bungkus)){
				$jumlaherror++;
				$msg['id'][]="tarif_bungkus";
				$msg['pesan'][]="Tarif perbungkus harus angka";
			}*/
			/*if(empty($tarif_bungkus)){
				$jumlaherror++;
				$msg['id'][]="tarif_bungkus";
				$msg['pesan'][]="Tarif perbungkus harus diisi";
			}
			if($jumlaherror>0){
				$msg['status']=0;
				$msg['error']=$jumlaherror;
				$msg['pesanatas']="Terdapat kesalahan inputan. silahkan cek inputan anda";
			}*/
		}
		echo json_encode($msg);
	}
	
	public function periksaresep() {
		$msg=array();
		$submit=$this->input->post('submit');
		$tarif_resep=$this->input->post('tarif_resep');
		
		$jumlaherror=0;
		$msg['status']=1;
		$msg['clearform']=0;
		$msg['pesanatas']="";
		$msg['pesanlain']="";
		
		if($submit=="simpantarif"){	}
		echo json_encode($msg);
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */