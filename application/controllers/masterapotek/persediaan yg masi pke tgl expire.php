<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Persediaan extends CI_Controller {

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
		$this->load->model('apotek/mpersediaanobat');
		$kd_unit_apt=$this->session->userdata('kd_unit_apt');
		if(empty($kd_unit_apt)){
			redirect('/home/');
		}
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
	
	public function persediaanobat(){
		$nama_obat='';
		$stok='1';
		$isistok='';
		$kd_unit_apt=$this->session->userdata('kd_unit_apt');
		$submit=$this->input->post('submit');
		$submit1=$this->input->post('submit1');
		
		if($this->input->post('nama_obat')!=''){
			$nama_obat=$this->input->post('nama_obat');
		}
		if($this->input->post('stok')!=''){
			$stok=$this->input->post('stok');
		}
		if($this->input->post('isistok')!=''){
			$isistok=$this->input->post('isistok');
		}
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
		
		//debugvar($nomor);
		$data=array('nama_obat'=>$nama_obat,
					'stok'=>$stok,
					'isistok'=>$isistok,
					'items'=>$this->mpersediaanobat->ambilPersediaan($nama_obat,$stok,$isistok),
					'kd_unit_apt'=>$kd_unit_apt
		);
		//debugvar($data);
		$this->load->view('headerapotek',$dataheader);
		$this->load->view('apotek/master/persediaan/persediaanobat',$data);
		$this->load->view('footer',$datafooter);
	}
	
	public function simpanpengajuanobat(){	
		$an=$this->input->post('query');
		$tglhrini=date('d-m-Y');
		$jam=$this->mpersediaanobat->sisdet();
		$an1=explode(",", $an);
		$i=count($an1)-1; //maxnya
		
		$tgl=explode("-", $tglhrini);
		$kode=$this->mpersediaanobat->autoNumberPengajuan($tgl[2],$tgl[1]);
		$kodebaru=$kode+1;
		$kodebaru=str_pad($kodebaru,4,0,STR_PAD_LEFT); 
		$no_pengajuan="PG.".$tgl[2].".".$tgl[1].".".$kodebaru;
		$tglhrini1=convertDate($tglhrini)." ".$jam;
		$datapengajuan=array('no_pengajuan'=>$no_pengajuan,
								//'kd_supplier'=>$kd_supplier,
								//'tgl_pengajuan'=>convertDate($tglhrini),
								'tgl_pengajuan'=>$tglhrini1,
								'keterangan'=>'-',
								'is_grouping'=>0,
								'status_approve'=>0);
		
		$this->mpersediaanobat->insert('apt_pengajuan',$datapengajuan);
		$urut=1;
		for($a=0;$a<$i;$a++){
			$an2=explode(".", $an1[$a]);
			$kd_obat=$an2[0];
			$tgl_expire=$an2[1];
			$item=$this->mpersediaanobat->ambildetilobat($kd_obat);
			$qty=$item['max_stok'];
			//$harga_beli=$item['harga_beli'];
			$harga_dasar=$item['harga_dasar'];
			$datadetil=array('no_pengajuan'=>$no_pengajuan,
							'urut_pengajuan'=>$urut,
							'kd_obat'=>$kd_obat,
							'qty_kcl'=>$qty,
							//'harga_beli'=>$harga_beli);
							'harga_beli'=>$harga_dasar);
			//debugvar($datadetil);
			$this->mpersediaanobat->insert('apt_pengajuan_detail',$datadetil);								
			$urut++;
		}
		$items=$this->mpersediaanobat->ambilApprover();
		foreach($items as $itemapprove){
			$kd_app=$itemapprove['kd_app'];
			$is_app=$itemapprove['is_app'];
			$dataapprove=array('kd_app'=>$kd_app,
								'no_pengajuan'=>$no_pengajuan,
								'is_app'=>$is_app);
			$this->mpersediaanobat->insert('apt_app_pengajuan',$dataapprove);								
		}
	}
	
	public function submitpengajuanobat(){
		$msg=array();
		$an=$this->input->post('query');
		$tglhrini=date('d-m-Y');
		$jam=$this->mpersediaanobat->sisdet();
		$an1=explode(",", $an);
		$i=count($an1)-1; //maxnya
		
		$tgl=explode("-", $tglhrini);
		$kode=$this->mpersediaanobat->autonumbersubmit();
		$kodebaru=$kode+1;
		//$kodebaru=str_pad($kodebaru,4,0,STR_PAD_LEFT); 
		$no_submit=$kodebaru;
		$tglhrini1=convertDate($tglhrini)." ".$jam;
		$datasubmit=array('no_submit'=>$no_submit,
								'tgl_submit'=>$tglhrini1,
								'keterangan'=>'-');
		
		$this->mpersediaanobat->insert('apt_submit',$datasubmit);
		$urut=1;
		for($a=0;$a<$i;$a++){
			$an2=explode(".", $an1[$a]);
			$kd_obat=$an2[0];
			$tgl_expire=$an2[1];
			$item=$this->mpersediaanobat->ambildetilobat($kd_obat);
			$qty=$item['max_stok'];
			//$harga_beli=$item['harga_beli'];
			$harga_dasar=$item['harga_dasar'];
			$datadetil=array('no_submit'=>$no_submit,
							'urut_submit'=>$urut,
							'kd_obat'=>$kd_obat,
							'qty_kcl'=>$qty,
							'harga_beli'=>$harga_dasar);
			$this->mpersediaanobat->insert('apt_submit_detail',$datadetil);								
			$urut++;
		}
		$msg['no_submit']=$no_submit;
		echo json_encode($msg);
	}
	
	public function editsubmit(){
		$msg=array();
		$submit=$this->input->post('submit');
		$no_submit=$this->input->post('no_submit');
		$tgl_submit=$this->input->post('tgl_submit');
		$jam_submit=$this->input->post('jam_submit');
		$jam_submit1=$this->input->post('jam_submit1');
		$keterangan=$this->input->post('keterangan');
		$kd_obat=$this->input->post('kd_obat');
		$nama_obat=$this->input->post('nama_obat');
		$satuan_kecil=$this->input->post('satuan_kecil');
		$pembanding=$this->input->post('pembanding');
		$qty_box=$this->input->post('qty_box'); 
		$qty_kcl=$this->input->post('qty_kcl');
		$harga_beli=$this->input->post('harga_beli');
		
		if($submit=="simpan"){
			$tgl=explode("-", $tgl_submit);
			$kode=$this->mpersediaanobat->autoNumberPengajuan($tgl[2],$tgl[1]);
			$kodebaru=$kode+1;
			$kodebaru=str_pad($kodebaru,4,0,STR_PAD_LEFT); 
			$no_pengajuan="PG.".$tgl[2].".".$tgl[1].".".$kodebaru;
			$msg['no_pengajuan']=$no_pengajuan;
			$tgl_pengajuan1=convertDate($tgl_submit)." ".$jam_submit;
			$datapengajuan=array('no_pengajuan'=>$no_pengajuan,
								'tgl_pengajuan'=>$tgl_pengajuan1,
								'keterangan'=>$keterangan,
								'is_grouping'=>0,
								'status_approve'=>0);
			
			$this->mpersediaanobat->insert('apt_pengajuan',$datapengajuan);
			$urut=1;
			if(!empty($kd_obat)){
				foreach ($kd_obat as $key => $value){
					# code...
					if(empty($value))continue;
					//if($qty_kcl[$key]==''){$qty_kcl[$key]=0;}
					$datadetil=array('no_pengajuan'=>$no_pengajuan,
									'urut_pengajuan'=>$urut,
									'kd_obat'=>$value,
									'qty_kcl'=>$qty_kcl[$key],
									'harga_beli'=>$harga_beli[$key]);
					//debugvar($datadetil);
					$this->mpersediaanobat->insert('apt_pengajuan_detail',$datadetil);
										
					$urut++;
				}
			}
			$items=$this->mpersediaanobat->ambilApprover();
			foreach($items as $itemapprove){
				$kd_app=$itemapprove['kd_app'];
				$is_app=$itemapprove['is_app'];
				$dataapprove=array('kd_app'=>$kd_app,
									'no_pengajuan'=>$no_pengajuan,
									'is_app'=>$is_app);
				$this->mpersediaanobat->insert('apt_app_pengajuan',$dataapprove);								
			}
			$msg['keluar']=0;
			$msg['posting']=3;
		}
		
		//redirect('/masterapotek/persediaan/persediaanobat');
		$msg['status']=1;
		
		echo json_encode($msg);
	}
	
	public function simpanpermintaanobat(){	
		$an=$this->input->post('query');
		$tglhrini=date('d-m-Y');
		$jam=$this->mpersediaanobat->sisdet();
		$an1=explode(",", $an);
		$i=count($an1)-1; //maxnya
		
		$kd_unit_apt=$this->session->userdata('kd_unit_apt');
		$kd_user=$this->session->userdata('id_user'); 
		
		$tgl=explode("-", $tglhrini);
		$kode=$this->mpersediaanobat->autoNumberPermintaan($tgl[2],$tgl[1]);
		$kodebaru=$kode+1;
		$kodebaru=str_pad($kodebaru,4,0,STR_PAD_LEFT); 
		$no_permintaan="OD.".$tgl[2].".".$tgl[1].".".$kodebaru;
		//debugvar($jam);
		$tglhrini1=convertDate($tglhrini)." ".$jam;
		$datapermintaan=array('no_permintaan'=>$no_permintaan,
								'kd_unit_apt'=>$kd_unit_apt,
								//'tgl_permintaan'=>convertDate($tglhrini),
								'tgl_permintaan'=>$tglhrini1,
								'keterangan'=>'-',
								'permintaan_status'=>0,
								'status_approve'=>0,
								'kd_user'=>$kd_user);
			
		$this->mpersediaanobat->insert('apt_permintaan_obat',$datapermintaan);
		$urut=1;
		for($a=0;$a<$i;$a++){
			$an2=explode(".", $an1[$a]);
			$kd_obat=$an2[0];
			$tgl_expire=$an2[1];
			$item=$this->mpersediaanobat->ambildetilobat($kd_obat);
			$qty=$item['max_stok'];
			//$harga_beli=$item['harga_beli'];
			$harga_dasar=$item['harga_dasar'];
			$datadetil=array('no_permintaan'=>$no_permintaan,
							'urut'=>$urut,
							'kd_obat'=>$kd_obat,
							'tgl_expire'=>$tgl_expire,
							'jml_req'=>$qty,
							'jml_distribusi'=>0);
			//debugvar($datadetil);
			$this->mpersediaanobat->insert('apt_permintaan_obat_det',$datadetil);	
			$urut++;
		}
		/*$items=$this->mpersediaanobat->ambilApprover();
		foreach($items as $itemapprove){
			$kd_app=$itemapprove['kd_app'];
			$is_app=$itemapprove['is_app'];
			$dataapprove=array('kd_app'=>$kd_app,
								'no_permintaan'=>$no_permintaan,
								'is_app'=>$is_app);
			$this->mpersediaanobat->insert('apt_app_permintaan',$dataapprove);								
		}*/
	}
	
	public function submit($no_submit=""){
	if(empty($no_submit))return false;
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
							'lib/bootstrap-timepicker.js',
							'lib/bootstrap-inputmask.js',
							'lib/bootstrap-modal.js',
							'spin.js',
							'main.js');
		$dataheader=array('jsfile'=>$jsfileheader,'cssfile'=>$cssfileheader,'title'=>$this->title);
		$jsfooter=array();
		$datafooter=array('jsfile'=>$jsfooter);
		
		$data=array('no_submit'=>$no_submit,
					'itemtransaksi'=>$this->mpersediaanobat->ambilItemDataSubmit($no_submit),
					'itemsdetiltransaksi'=>$this->mpersediaanobat->getAllDetailSubmit($no_submit));
		$this->load->view('headerapotek',$dataheader);
		$this->load->view('apotek/master/persediaan/submitpengajuan',$data);
		$this->load->view('footer',$datafooter);	
	}
	
	public function hapussubmit(){
		$q=$this->input->post('query');	//no_submit
		$this->mpersediaanobat->delete('apt_submit','no_submit="'.$q.'"');
		$this->mpersediaanobat->delete('apt_submit_detail','no_submit="'.$q.'"');
		//echo json_encode($items);
	}
	
	public function periksasubmit() {
		$msg=array();
		$submit=$this->input->post('submit');
		$no_submit=$this->input->post('no_submit');
		$tgl_submit=$this->input->post('tgl_submit');
		$jam_submit=$this->input->post('jam_submit');
		$jam_submit1=$this->input->post('jam_submit1');
		$keterangan=$this->input->post('keterangan');
		
		$kd_obat=$this->input->post('kd_obat');
		$nama_obat=$this->input->post('nama_obat');
		$satuan_kecil=$this->input->post('satuan_kecil');
		$pembanding=$this->input->post('pembanding');
		$qty_box=$this->input->post('qty_box'); 
		$qty_kcl=$this->input->post('qty_kcl');
		$harga_beli=$this->input->post('harga_beli');
		
		$jumlaherror=0;
		$msg['status']=1;
		$msg['clearform']=0;
		$msg['pesanatas']="";
		$msg['pesanlain']="";
		
		echo json_encode($msg);
	}
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */