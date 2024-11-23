<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

include_once(APPPATH.'controllers/rumahsakit.php');
class Vendor extends Rumahsakit {

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
		$this->load->model('mvendor');
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
	
	public function index()	{
		if(!$this->muser->isAkses("915")){
			$this->restricted();
			return false;
		}
		$cari=$this->input->post('cari');
		$vendor=$this->input->post('vendor');
		$config['per_page'] =25;
		$config['uri_segment'] = 3;
		$this->pagination->initialize($config);		
		$cssfileheader=array('bootstrap.min.css','bootstrap-responsive.min.css','font-awesome.min.css','style.css','prettify.css','jquery-ui.css','DT_bootstrap.css','responsive-tables.css','theme.css');
		$jsfileheader=array('vendor/modernizr-2.6.2-respond-1.1.0.min.js','vendor/jquery-1.9.1.min.js','vendor/jquery-migrate-1.1.1.min.js','vendor/jquery-ui-1.10.0.custom.min.js','vendor/bootstrap.min.js',
							'lib/jquery.tablesorter.min.js', 'lib/jquery.dataTables.min.js','lib/DT_bootstrap.js','lib/responsive-tables.js','main.js');
		$dataheader=array('jsfile'=>$jsfileheader,'cssfile'=>$cssfileheader,'title'=>$this->title);
		$jsfooter=array();
		$datafooter=array('jsfile'=>$jsfooter);
		$data=array('items'=>$this->mvendor->ambilDataVendor($vendor));
		//debugvar($items);
		$this->load->view('master/header',$dataheader);
		$this->load->view('vendor',$data);
		$this->load->view('footer',$datafooter);
	}
		
	public function tambahvendor(){	
		if(!$this->muser->isAkses("916")){
			$this->restricted();
			return false;
		}
		$type="D"; $kode=""; $vend_code="";
		
		$cssfileheader=array('bootstrap.min.css','bootstrap-responsive.min.css','font-awesome.min.css','style.css','prettify.css','jquery-ui.css','DT_bootstrap.css','responsive-tables.css','theme.css');
		$jsfileheader=array('vendor/modernizr-2.6.2-respond-1.1.0.min.js','vendor/jquery-1.9.1.min.js','vendor/jquery-migrate-1.1.1.min.js','vendor/jquery-ui-1.10.0.custom.min.js','vendor/bootstrap.min.js',
							'lib/jquery.tablesorter.min.js','lib/jquery.dataTables.min.js','lib/DT_bootstrap.js','lib/responsive-tables.js','main.js');
		$dataheader=array('jsfile'=>$jsfileheader,'cssfile'=>$cssfileheader,'title'=>$this->title);
		$jsfooter=array();
		$datafooter=array('jsfile'=>$jsfooter);
		
		$kode=$this->mvendor->autoNumber();
		$kodebaru=$kode+1;
		$kodebaru=str_pad($kodebaru,6,0,STR_PAD_LEFT);
		$vend_code="VEND".$kodebaru;
		
		$data=array('vend_code'=>$vend_code,
					'dataakun'=>$this->mvendor->ambilData('accounts','type="'.$type.'"'));
		$this->load->view('master/header',$dataheader);
		$this->load->view('tambahvendor',$data);
		$this->load->view('footer',$datafooter);	
	}
	
	public function simpanvendor(){	
		$type="D";
		$submit=$this->input->post('submit');
		$reset=$this->input->post('reset');
		$vend_code=$this->input->post('vend_code');
		$vendor=$this->input->post('vendor');
		$contact=$this->input->post('contact');
		$address=$this->input->post('address');
		$city=$this->input->post('city');
		$state=$this->input->post('state');
		$zip=$this->input->post('zip');
		$country=$this->input->post('country');
		$phone1=$this->input->post('phone1');
		$phone2=$this->input->post('phone2');
		$fax=$this->input->post('fax');
		$account=$this->input->post('account');
		
		$baris=$this->mvendor->countVendor($vendor);
		//$baris=$this->mvendor->countVendor('acc_vendors','vendor="'.$vendor.'"');
		
		$cssfileheader=array('bootstrap.min.css','bootstrap-responsive.min.css','font-awesome.min.css','style.css','prettify.css','jquery-ui.css','DT_bootstrap.css','responsive-tables.css','theme.css');
		$jsfileheader=array('vendor/modernizr-2.6.2-respond-1.1.0.min.js','vendor/jquery-1.9.1.min.js','vendor/jquery-migrate-1.1.1.min.js','vendor/jquery-ui-1.10.0.custom.min.js','vendor/bootstrap.min.js',
							'lib/jquery.tablesorter.min.js','lib/jquery.dataTables.min.js','lib/DT_bootstrap.js','lib/responsive-tables.js','main.js');
		$dataheader=array('jsfile'=>$jsfileheader,'cssfile'=>$cssfileheader,'title'=>$this->title);

		$jsfooter=array();
		$datafooter=array('jsfile'=>$jsfooter);
		
		$data=array('vend_code'=>$vend_code,'vendor'=>$vendor,'contact'=>$contact,'address'=>$address,'city'=>$city,'state'=>$state,'zip'=>$zip,'country'=>$country,'phone1'=>$phone1,
					'phone2'=>$phone2,'fax'=>$fax,'account'=>$account); 
		
		if($submit=="submit1"){ 
			if(trim($vendor) == ''){
				$data2=array('vend_code'=>$vend_code,'vendor'=>$vendor,'contact'=>$contact,'address'=>$address,'city'=>$city,'state'=>$state,'zip'=>$zip,'country'=>$country,'phone1'=>$phone1,
						'phone2'=>$phone2,'fax'=>$fax,'account'=>$account,'dataakun'=>$this->mvendor->ambilData('accounts','type="'.$type.'"'));
				echo"<script>alert('Nama vendor harus diisi !')</script>";
				$this->load->view('master/header',$dataheader);
				$this->load->view('tambahvendor',$data2);
				$this->load->view('footer',$datafooter);
			}
			else if($account==""){
				$data3=array('vend_code'=>$vend_code,'vendor'=>$vendor,'contact'=>$contact,'address'=>$address,'city'=>$city,'state'=>$state,'zip'=>$zip,'country'=>$country,'phone1'=>$phone1,
						'phone2'=>$phone2,'fax'=>$fax,'account'=>$account,'dataakun'=>$this->mvendor->ambilData('accounts','type="'.$type.'"'));
				echo"<script>alert('Account belum dipilih !')</script>";
				$this->load->view('master/header',$dataheader);
				$this->load->view('tambahvendor',$data3);
				$this->load->view('footer',$datafooter);
			}
			else {
				if($baris=='1'){
					$dataa=array('vend_code'=>$vend_code,'vendor'=>$vendor,'contact'=>$contact,'address'=>$address,'city'=>$city,'state'=>$state,'zip'=>$zip,'country'=>$country,'phone1'=>$phone1,
						'phone2'=>$phone2,'fax'=>$fax,'account'=>$account,'dataakun'=>$this->mvendor->ambilData('accounts','type="'.$type.'"'));
					echo"<script>alert('Vendor $vendor sudah ada!')</script>";
					$this->load->view('master/header',$dataheader);
					$this->load->view('tambahvendor',$dataa);
					$this->load->view('footer',$datafooter);
				}
				else if($baris=='0'){
					$this->mvendor->insert('acc_vendors',$data);
					//echo"<script>alert('Data berhasil di simpan.');window.location='customer'</script>";
					redirect('/vendor/');
				}
			}
		}
		if($submit=="submit"){
			if(trim($vendor) == ''){
				$data2=array('vend_code'=>$vend_code,'vendor'=>$vendor,'contact'=>$contact,'address'=>$address, 'city'=>$city,'state'=>$state,'zip'=>$zip,'country'=>$country,'phone1'=>$phone1,
						'phone2'=>$phone2,'fax'=>$fax,'account'=>$account,'dataakun'=>$this->mvendor->ambilData('accounts','type="'.$type.'"'));
				echo"<script>alert('Nama vendor harus diisi !')</script>";
				$this->load->view('master/header',$dataheader);
				$this->load->view('tambahvendor',$data2);
				$this->load->view('footer',$datafooter);
			}
			else if($account==""){
				$data3=array('vend_code'=>$vend_code,'vendor'=>$vendor,'contact'=>$contact,'address'=>$address,'city'=>$city,'state'=>$state,'zip'=>$zip,'country'=>$country,'phone1'=>$phone1,
						'phone2'=>$phone2,'fax'=>$fax,'account'=>$account,'dataakun'=>$this->mvendor->ambilData('accounts','type="'.$type.'"'));
				echo"<script>alert('Account belum dipilih !')</script>";
				$this->load->view('master/header',$dataheader);
				$this->load->view('tambahvendor',$data3);
				$this->load->view('footer',$datafooter);
			}
			else {
				if($baris=='1'){
					$dataa=array('vend_code'=>$vend_code,'vendor'=>$vendor,'contact'=>$contact,'address'=>$address,'city'=>$city,'state'=>$state,'zip'=>$zip,'country'=>$country,'phone1'=>$phone1,
						'phone2'=>$phone2,'fax'=>$fax,'account'=>$account,'dataakun'=>$this->mvendor->ambilData('accounts','type="'.$type.'"'));
					echo"<script>alert('Vendor $vendor sudah ada!')</script>";
					$this->load->view('master/header',$dataheader);
					$this->load->view('tambahvendor',$dataa);
					$this->load->view('footer',$datafooter);
				}
				else if($baris=='0'){
					$this->mvendor->insert('acc_vendors',$data);
					//echo"<script>alert('Data berhasil di simpan.');window.location='customer'</script>";
					redirect('/vendor/tambahvendor/');
				}
			}
		}
		if($reset=="reset"){
			$vendor1=""; $contact1=""; $address1=""; $city1=""; $state1=""; $zip1=""; $country1=""; $phone1a=""; $phone2a=""; $fax1=""; $account1=""; 
			$datab=array('vend_code'=>$vend_code,'vendor'=>$vendor1,'contact'=>$contact1,'address'=>$address1,'city'=>$city1,'state'=>$state1,'zip'=>$zip1,'country'=>$country1,'phone1'=>$phone1a,
						'phone2'=>$phone2a,'fax'=>$fax1,'account'=>$account1,'dataakun'=>$this->mvendor->ambilData('accounts','type="'.$type.'"'));
			$this->load->view('master/header',$dataheader);
			$this->load->view('tambahvendor',$datab);
			$this->load->view('footer',$datafooter);
		}
	}
	
	public function hapusvendor($id){
		$this->db->delete('acc_vendors', array('vend_code' => $id));
		redirect('/vendor/');
		//echo"<script>alert('Data berhasil di hapus.');window.location='unitkerja'</script>";
	}
	
	public function ubahvendor($vend_code=""){
		if(!$this->muser->isAkses("917")){
			$this->restricted();
			return false;
		}
		$type="D";
		$cssfileheader=array('bootstrap.min.css','bootstrap-responsive.min.css','font-awesome.min.css','style.css','prettify.css','jquery-ui.css','DT_bootstrap.css','responsive-tables.css','theme.css');
		$jsfileheader=array('vendor/modernizr-2.6.2-respond-1.1.0.min.js','vendor/jquery-1.9.1.min.js','vendor/jquery-migrate-1.1.1.min.js','vendor/jquery-ui-1.10.0.custom.min.js','vendor/bootstrap.min.js',
							'lib/jquery.tablesorter.min.js','lib/jquery.dataTables.min.js','lib/DT_bootstrap.js','lib/responsive-tables.js','main.js');
		$dataheader=array('jsfile'=>$jsfileheader,'cssfile'=>$cssfileheader,'title'=>$this->title);
		$jsfooter=array();
		$datafooter=array('jsfile'=>$jsfooter);
		$items=$this->mvendor->ambilItemData('acc_vendors','vend_code="'.$vend_code.'"');
		$data=array('vend_code'=>$vend_code,'vendor'=>$items['vendor'],'contact'=>$items['contact'],
					'address'=>$items['address'],'city'=>$items['city'],'state'=>$items['state'],
					'zip'=>$items['zip'],'country'=>$items['country'],'phone1'=>$items['phone1'],
					'phone2'=>$items['phone2'],'fax'=>$items['fax'],'account'=>$items['account'],
					'dataakun'=>$this->mvendor->ambilData('accounts','type="'.$type.'"'));
		//debugvar($data);
		$this->load->view('master/header',$dataheader);
		$this->load->view('ubahvendor',$data);
		$this->load->view('footer',$datafooter);
	}
	
	public function editvendor(){
		$type="D";
		$submit=$this->input->post('submit');
		$vend_code=$this->input->post('vend_code');
		$vendor=$this->input->post('vendor');
		$contact=$this->input->post('contact');
		$address=$this->input->post('address');
		$city=$this->input->post('city');
		$state=$this->input->post('state');
		$zip=$this->input->post('zip');
		$country=$this->input->post('country');
		$phone1=$this->input->post('phone1');
		$phone2=$this->input->post('phone2');
		$fax=$this->input->post('fax');
		$account=$this->input->post('account');	
		$akun=$this->input->post('akun');
				
		$cssfileheader=array('bootstrap.min.css','bootstrap-responsive.min.css','font-awesome.min.css','style.css','prettify.css','jquery-ui.css','DT_bootstrap.css','responsive-tables.css','theme.css');
		$jsfileheader=array('vendor/modernizr-2.6.2-respond-1.1.0.min.js','vendor/jquery-1.9.1.min.js','vendor/jquery-migrate-1.1.1.min.js','vendor/jquery-ui-1.10.0.custom.min.js',
							'vendor/bootstrap.min.js','lib/jquery.tablesorter.min.js','lib/jquery.dataTables.min.js','lib/DT_bootstrap.js','lib/responsive-tables.js','main.js');
		$dataheader=array('jsfile'=>$jsfileheader,'cssfile'=>$cssfileheader,'title'=>$this->title);

		$jsfooter=array();
		$datafooter=array('jsfile'=>$jsfooter);
		
		$data=array('vend_code'=>$vend_code,'vendor'=>$vendor,'contact'=>$contact,'address'=>$address,'city'=>$city,'state'=>$state,'zip'=>$zip,'country'=>$country,'phone1'=>$phone1,
					'phone2'=>$phone2,'fax'=>$fax,'account'=>$account);
		
		if($submit=="submit"){
			if(trim($vend_code) == ''){
				$data1=array('vend_code'=>$vend_code,'vendor'=>$vendor,'contact'=>$contact,'address'=>$address,'city'=>$city,'state'=>$state,'zip'=>$zip,'country'=>$country,'phone1'=>$phone1,
						'phone2'=>$phone2,'fax'=>$fax,'account'=>$account,'dataakun'=>$this->mcustomer->ambilData('accounts','type="'.$type.'"'));
				echo"<script>alert('Kode vendor harus diisi !')</script>";
				$this->load->view('master/header',$dataheader);
				$this->load->view('ubahvendor',$data1);
				$this->load->view('footer',$datafooter);
			}
			else if(trim($vendor) == ''){
				$data2=array('vend_code'=>$vend_code,'vendor'=>$vendor,'contact'=>$contact,'address'=>$address,
						'city'=>$city,'state'=>$state,'zip'=>$zip,'country'=>$country,'phone1'=>$phone1,
						'phone2'=>$phone2,'fax'=>$fax,'account'=>$account,'dataakun'=>$this->mcustomer->ambilData('accounts','type="'.$type.'"'));
				echo"<script>alert('Nama vendor harus diisi !')</script>";
				$this->load->view('master/header',$dataheader);
				$this->load->view('ubahvendor',$data2);
				$this->load->view('footer',$datafooter);
			}
			else{
				$this->mvendor->update('acc_vendors',$data,'vend_code="'.$vend_code.'"');
				//echo"<script>alert('Data berhasil di edit.');window.location='customer'</script>";
				redirect('/vendor/');
			}
		}
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */