<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

include_once(APPPATH.'controllers/rumahsakit.php');
class Customer extends Rumahsakit {

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
		$this->load->model('mcustomer');
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
		if(!$this->muser->isAkses("912")){
			$this->restricted();
			return false;
		}
		$cari=$this->input->post('cari');
		$customer=$this->input->post('customer');
		$config['per_page'] =25;
		$config['uri_segment'] = 3;
		$this->pagination->initialize($config);		
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
		$dataheader=array('jsfile'=>$jsfileheader,'cssfile'=>$cssfileheader,'title'=>$this->title);
		$jsfooter=array();
		$datafooter=array('jsfile'=>$jsfooter);
		$data=array(
			'items'=>$this->mcustomer->ambilDataCustomer($customer)				
			);
		$this->load->view('master/header',$dataheader);
		$this->load->view('customer',$data);
		$this->load->view('footer',$datafooter);
	}
		
	public function tambahcustomer(){
		if(!$this->muser->isAkses("913")){
			$this->restricted();
			return false;
		}
		$type="D"; $kode=""; $cust_code="";
		
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
		$dataheader=array('jsfile'=>$jsfileheader,'cssfile'=>$cssfileheader,'title'=>$this->title);
		$jsfooter=array();
		$datafooter=array('jsfile'=>$jsfooter);
		
		$kode=$this->mcustomer->autoNumber();
		$kodebaru=$kode+1;
		$kodebaru=str_pad($kodebaru,6,0,STR_PAD_LEFT);
		$cust_code="CUST".$kodebaru;
		
		$data=array('cust_code'=>$cust_code,
					'dataakun'=>$this->mcustomer->ambilData('accounts','type="'.$type.'"'));		
		$this->load->view('master/header',$dataheader);
		$this->load->view('tambahcustomer',$data);
		$this->load->view('footer',$datafooter);		
	}
	
	public function simpancustomer(){
		$type="D";
		$submit=$this->input->post('submit');
		$reset=$this->input->post('reset');
		$cust_code=$this->input->post('cust_code');
		$customer=$this->input->post('customer');
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
		
		$baris=$this->mcustomer->countCustomer($customer);
		
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
		$dataheader=array('jsfile'=>$jsfileheader,'cssfile'=>$cssfileheader,'title'=>$this->title);

		$jsfooter=array();
		$datafooter=array('jsfile'=>$jsfooter);
		
		$data=array('cust_code'=>$cust_code,'customer'=>$customer,'contact'=>$contact,'address'=>$address,
					'city'=>$city,'state'=>$state,'zip'=>$zip,'country'=>$country,'phone1'=>$phone1,
					'phone2'=>$phone2,'fax'=>$fax,'account'=>$account); 
					
		if($submit=="submit1"){ //simpan & keluar
			if(trim($customer) == ''){
				$data2=array('cust_code'=>$cust_code,'customer'=>$customer,'contact'=>$contact,'address'=>$address,
						'city'=>$city,'state'=>$state,'zip'=>$zip,'country'=>$country,'phone1'=>$phone1,
						'phone2'=>$phone2,'fax'=>$fax,'account'=>$account,'dataakun'=>$this->mcustomer->ambilData('accounts','type="'.$type.'"'));
				echo"<script>alert('Nama customer harus diisi !')</script>";
				$this->load->view('master/header',$dataheader);
				$this->load->view('tambahcustomer',$data2);
				$this->load->view('footer',$datafooter);
			}
			else if($account==""){
				$data3=array('cust_code'=>$cust_code,'customer'=>$customer,'contact'=>$contact,'address'=>$address,
						'city'=>$city,'state'=>$state,'zip'=>$zip,'country'=>$country,'phone1'=>$phone1,
						'phone2'=>$phone2,'fax'=>$fax,'account'=>$account,'dataakun'=>$this->mcustomer->ambilData('accounts','type="'.$type.'"'));
				echo"<script>alert('Account belum dipilih !')</script>";
				$this->load->view('master/header',$dataheader);
				$this->load->view('tambahcustomer',$data3);
				$this->load->view('footer',$datafooter);
			}
			else {
				/*if($baris=='1'){
					$dataa=array('cust_code'=>$cust_code,'customer'=>$customer,'contact'=>$contact,'address'=>$address,'city'=>$city,'state'=>$state,'zip'=>$zip,'country'=>$country,'phone1'=>$phone1,
						'phone2'=>$phone2,'fax'=>$fax,'account'=>$account, 'dataakun'=>$this->mcustomer->ambilData('accounts','type="'.$type.'"'));
					echo"<script>alert('Customer $customer sudah ada!')</script>";
					$this->load->view('header',$dataheader);
					$this->load->view('tambahcustomer',$dataa);
					$this->load->view('footer',$datafooter);
				}*/
				//else if($baris=='0'){
					$this->mcustomer->insert('acc_customers',$data);
					//echo"<script>alert('Data berhasil di simpan.');window.location='customer'</script>";
					redirect('/customer/');
			//	}
			}
		}
		if($submit=="submit"){ //simpan
			if(trim($customer) == ''){
				$data2=array('cust_code'=>$cust_code,'customer'=>$customer,'contact'=>$contact,'address'=>$address,
						'city'=>$city,'state'=>$state,'zip'=>$zip,'country'=>$country,'phone1'=>$phone1,
						'phone2'=>$phone2,'fax'=>$fax,'account'=>$account,'dataakun'=>$this->mcustomer->ambilData('accounts','type="'.$type.'"'));
				echo"<script>alert('Nama customer harus diisi !')</script>";
				$this->load->view('master/header',$dataheader);
				$this->load->view('tambahcustomer',$data2);
				$this->load->view('footer',$datafooter);
			}
			else if($account==""){
				$data3=array('cust_code'=>$cust_code,'customer'=>$customer,'contact'=>$contact,'address'=>$address,
						'city'=>$city,'state'=>$state,'zip'=>$zip,'country'=>$country,'phone1'=>$phone1,
						'phone2'=>$phone2,'fax'=>$fax,'account'=>$account,'dataakun'=>$this->mcustomer->ambilData('accounts','type="'.$type.'"'));
				echo"<script>alert('Account belum dipilih !')</script>";
				$this->load->view('master/header',$dataheader);
				$this->load->view('tambahcustomer',$data3);
				$this->load->view('footer',$datafooter);
			}
			else {
				/*if($baris=='1'){
					$dataa=array('cust_code'=>$cust_code,'customer'=>$customer,'contact'=>$contact,'address'=>$address,'city'=>$city,'state'=>$state,'zip'=>$zip,'country'=>$country,'phone1'=>$phone1,
						'phone2'=>$phone2,'fax'=>$fax,'account'=>$account,'dataakun'=>$this->mcustomer->ambilData('accounts','type="'.$type.'"'));
					echo"<script>alert('Customer $customer sudah ada!')</script>";
					$this->load->view('header',$dataheader);
					$this->load->view('tambahcustomer',$dataa);
					$this->load->view('footer',$datafooter);
				}*/
				//else if($baris=='0'){
					$this->mcustomer->insert('acc_customers',$data);
					//echo"<script>alert('Data berhasil di simpan.');window.location='customer'</script>";
					redirect('/customer/tambahcustomer/');
				//}
			}
		}
		if($reset=="reset"){
			$customer1=""; $contact1=""; $address1=""; $city1=""; $state1=""; $zip1=""; $country1=""; $phone1a=""; $phone2a=""; $fax1=""; $account1=""; 
			$datab=array('cust_code'=>$cust_code,'customer'=>$customer1,'contact'=>$contact1,'address'=>$address1,'city'=>$city1,'state'=>$state1,'zip'=>$zip1,'country'=>$country1,'phone1'=>$phone1a,
						'phone2'=>$phone2a,'fax'=>$fax1,'account'=>$account1,'dataakun'=>$this->mcustomer->ambilData('accounts','type="'.$type.'"'));
			$this->load->view('master/header',$dataheader);
			$this->load->view('tambahcustomer',$datab);
			$this->load->view('footer',$datafooter);
		}
	}
	
	public function hapuscustomer($id){
		$this->db->delete('acc_customers', array('cust_code' => $id));
		redirect('/customer/');
		//echo"<script>alert('Data berhasil di hapus.');window.location='unitkerja'</script>";
	}
	
	public function ubahcustomer($cust_code=""){
		if(!$this->muser->isAkses("914")){
			$this->restricted();
			return false;
		}
		$type="D";
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
		$dataheader=array('jsfile'=>$jsfileheader,'cssfile'=>$cssfileheader,'title'=>$this->title);
		$jsfooter=array();
		$datafooter=array('jsfile'=>$jsfooter);
		$items=$this->mcustomer->ambilItemData('acc_customers','cust_code="'.$cust_code.'"');
		$data=array('cust_code'=>$cust_code,'customer'=>$items['customer'],'contact'=>$items['contact'],
					'address'=>$items['address'],'city'=>$items['city'],'state'=>$items['state'],
					'zip'=>$items['zip'],'country'=>$items['country'],'phone1'=>$items['phone1'],
					'phone2'=>$items['phone2'],'fax'=>$items['fax'],'account'=>$items['account'],
					'dataakun'=>$this->mcustomer->ambilData('accounts','type="'.$type.'"'));
		
		$this->load->view('master/header',$dataheader);
		$this->load->view('ubahcustomer',$data);
		$this->load->view('footer',$datafooter);
	}
	
	public function editcustomer(){
		$type="D";
		$submit=$this->input->post('submit');
		$cust_code=$this->input->post('cust_code');
		$customer=$this->input->post('customer');
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
		$dataheader=array('jsfile'=>$jsfileheader,'cssfile'=>$cssfileheader,'title'=>$this->title);

		$jsfooter=array();
		$datafooter=array('jsfile'=>$jsfooter);
		
		$data=array('cust_code'=>$cust_code,'customer'=>$customer,'contact'=>$contact,'address'=>$address,
					'city'=>$city,'state'=>$state,'zip'=>$zip,'country'=>$country,'phone1'=>$phone1,
					'phone2'=>$phone2,'fax'=>$fax,'account'=>$account);
		
		if($submit=="submit"){
			if(trim($customer) == ''){
				$data2=array('cust_code'=>$cust_code,'customer'=>$customer,'contact'=>$contact,'address'=>$address,
						'city'=>$city,'state'=>$state,'zip'=>$zip,'country'=>$country,'phone1'=>$phone1,
						'phone2'=>$phone2,'fax'=>$fax,'account'=>$account,'dataakun'=>$this->mcustomer->ambilData('accounts','type="'.$type.'"'));
				echo"<script>alert('Nama customer harus diisi !')</script>";
				$this->load->view('master/header',$dataheader);
				$this->load->view('ubahcustomer',$data2);
				$this->load->view('footer',$datafooter);
			}
			else{
				$this->mcustomer->update('acc_customers',$data,'cust_code="'.$cust_code.'"');
				//echo"<script>alert('Data berhasil di edit.');window.location='customer'</script>";
				redirect('/customer/');
			}
		}
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */