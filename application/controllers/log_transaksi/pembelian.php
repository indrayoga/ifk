<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pembelian extends CI_Controller {

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
		$this->load->model('logistik/mpembelian');
	}
	
	public function index()	{
		//$no_pembelian=$this->input->post('no_pembelian');
		//$kd_vendor=$this->input->post('kd_vendor');
		//$periodeawal=$this->input->post('periodeawal');
		//$periodeakhir=$this->input->post('periodeakhir');
		
		$no_pembelian='';
		$kd_vendor='';
		$periodeawal=date('d-m-Y');
		$periodeakhir=date('d-m-Y');
		
		if($this->input->post('no_pembelian')!=''){
			$no_pembelian=$this->input->post('no_pembelian');
		}
		if($this->input->post('kd_vendor')!=''){
			$kd_vendor=$this->input->post('kd_vendor');
		}
		if($this->input->post('periodeawal')!=''){
			$periodeawal=$this->input->post('periodeawal');
		}
		if($this->input->post('periodeakhir')!=''){
			$periodeakhir=$this->input->post('periodeakhir');
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
		$data=array('no_pembelian'=>$no_pembelian,
					'kd_vendor'=>$kd_vendor,
					'periodeawal'=>$periodeawal,
					'periodeakhir'=>$periodeakhir,
					'datavendor'=>$this->mpembelian->ambilData('log_vendor'),
					'items'=>$this->mpembelian->ambilDataPembelian($no_pembelian,$kd_vendor,$periodeawal,$periodeakhir));
		
		$this->load->view('headerlogistik',$dataheader);
		$this->load->view('logistik/transaksi/pembelian/pembelian',$data);
		$this->load->view('footer',$datafooter);
	}
		
	public function tambahpembelian(){	
		$kode=""; $no_pembelian="";
		
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
		
		$data=array('no_pembelian'=>'',	
					'itemsdetiltransaksi'=>$this->mpembelian->getAllDetailPembelian($no_pembelian),
					'itemtransaksi'=>$this->mpembelian->ambilItemPembelian($no_pembelian),
					'items'=>$this->mpembelian->ambilDataPembelian('','','',''));
		//debugvar($data);
		$this->load->view('headerlogistik',$dataheader);
		$this->load->view('logistik/transaksi/pembelian/tambahpembelian',$data);
		$this->load->view('footer',$datafooter);	
	}
	
	public function ubahpembelian($no_pembelian=""){
		if(empty($no_pembelian))return false;
		
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
		
		$data=array(
			'no_pembelian'=>$no_pembelian,
			'itemtransaksi'=>$this->mpembelian->ambilItemPembelian($no_pembelian),
			'itemsdetiltransaksi'=>$this->mpembelian->getAllDetailPembelian($no_pembelian),
			'items'=>$this->mpembelian->ambilDataPembelian('','','','')	
		);
		//debugvar($data);
		$this->load->view('headerlogistik',$dataheader);
		$this->load->view('logistik/transaksi/pembelian/tambahpembelian',$data);
		$this->load->view('footer',$datafooter);
	}
	
	public function simpanpembelian(){
		$msg=array();
		$submit=$this->input->post('submit');
		$no_pembelian=$this->input->post('no_pembelian');
		$tgl_pembelian=$this->input->post('tgl_pembelian');
		$kd_vendor=$this->input->post('kd_vendor');
		$keterangan=$this->input->post('keterangan');
		$status_pembelian=$this->input->post('status_pembelian');
		$kd_user=$this->input->post('kd_user');
		
		$no_ro=$this->input->post('no_ro');
		$kd_barang=$this->input->post('kd_barang');
		$nama_barang=$this->input->post('nama_barang');
		$satuan=$this->input->post('satuan');
		$harga_beli=$this->input->post('harga_beli');
		$jml_pembelian=$this->input->post('jml_pembelian');
		$harga_beli=$this->input->post('harga_beli');
		$total=$this->input->post('total');
		$jml_penerimaan=0;
		
		$msg['no_pembelian']=$no_pembelian;
		if($submit=="tutuptrans"){
			if(empty($no_pembelian))return false;
			
			if(!empty($kd_barang)){
				foreach ($kd_barang as $key => $value){
					if(empty($value))continue;
					if($no_ro[$key]!=''){						
						$urut=$this->mpembelian->ambilUrutrequest($no_ro[$key],$value);
						$jml_pembelianawal=$this->mpembelian->jumpembelianawal($no_ro[$key],$value);
						$jumbaru=$jml_pembelianawal+$jml_pembelian[$key];
						$dataa=array('jml_pembelian'=>$jumbaru);
						$this->mpembelian->update('log_request_order_det',$dataa,'no_ro="'.$no_ro[$key].'" and urut_request="'.$urut.'" and kd_barang="'.$value.'"');			
					}
				}
			}
						
			$updatepembelian=array('status_pembelian'=>1);
			$this->mpembelian->update('log_pembelian',$updatepembelian,'no_pembelian="'.$no_pembelian.'"');
			$msg['status']=1;
			$msg['posting']=1;
			$msg['pesan']="Tutup Transksi Berhasil";
			echo json_encode($msg);
			return false;
		}
		if($submit=="bukatrans"){
			if(empty($no_pembelian))return false;
			$updatepembelian=array('status_pembelian'=>0);
			$this->mpembelian->update('log_pembelian',$updatepembelian,'no_pembelian="'.$no_pembelian.'"');
			
			if(!empty($kd_barang)){
				foreach ($kd_barang as $key => $value){
					if(empty($value))continue;					
					if($no_ro[$key]!=''){			
						//untuk ngembaliin jml_pembelian awal di log_requestny
						$urut=$this->mpembelian->ambilUrutrequest($no_ro[$key],$value);
						$jml_pembelianawal=$this->mpembelian->jumpembelianawal($no_ro[$key],$value);
						$jumbalik=$jml_pembelianawal-$jml_pembelian[$key];
						$dataa=array('jml_pembelian'=>$jumbalik);
						$this->mpembelian->update('log_request_order_det',$dataa,'no_ro="'.$no_ro[$key].'" and urut_request="'.$urut.'" and kd_barang="'.$value.'"');			
					}
				}
			}
			
			$msg['status']=1;
			$msg['posting']=2;
			$msg['pesan']="Buka Transksi Berhasil";
			echo json_encode($msg);
			return false;
		}

		if($this->mpembelian->isNumberExist($no_pembelian)){ //edit
		    $datapembelianedit=array('tgl_pembelian'=>convertDate($tgl_pembelian),'kd_vendor'=>$kd_vendor,
										'keterangan'=>$keterangan,'status_pembelian'=>$status_pembelian,'kd_user'=>0);
				
			$this->mpembelian->update('log_pembelian',$datapembelianedit,'no_pembelian="'.$no_pembelian.'"');
			$urutpembelian=1;
			$urutrequest=1;
			
			$this->mpembelian->delete('log_pembelian_det','no_pembelian="'.$no_pembelian.'"');
			
			if(!empty($kd_barang)){
				foreach ($kd_barang as $key => $value){
					if(empty($value))continue;
					if($no_ro[$key]==''){$urutrequest='';}
					$datadetil=array('no_pembelian'=>$no_pembelian,
									'urut_pembelian'=>$urutpembelian,
									'no_ro'=>$no_ro[$key],
									'urut_request'=>$urutrequest, 
									'kd_barang'=>$value,
									'jml_pembelian'=>$jml_pembelian[$key],
									'harga'=>$harga_beli[$key],
									'total'=>$total[$key],
									'jml_penerimaan'=>$jml_penerimaan);
					$this->mpembelian->insert('log_pembelian_det',$datadetil);								
					$urutpembelian++;
					$urutrequest++;
				}
				
			}
			
			$msg['pesan']="Data Berhasil Di Update";
		}
		else { //simpan baru			
			$tanggal=date('d-m-Y');
			$tgl=explode("-", $tanggal);
			$kode=$this->mpembelian->autoNumber($tgl[2],$tgl[1]);
			$kodebaru=$kode+1;
			$kodebaru=str_pad($kodebaru,5,0,STR_PAD_LEFT); 
			$no_pembelian="PMB.".substr($tgl[2],2,2)."".$tgl[1].".".$kodebaru;
			$msg['no_pembelian']=$no_pembelian;
			
			$datapembelian=array('no_pembelian'=>$no_pembelian,
									'tgl_pembelian'=>convertDate($tgl_pembelian),
									'kd_vendor'=>$kd_vendor,
									'keterangan'=>$keterangan,
									'status_pembelian'=>$status_pembelian,'kd_user'=>0);
			
			$this->mpembelian->insert('log_pembelian',$datapembelian);
			$urutpembelian=1;
			$urutrequest=1;
			if(!empty($kd_barang)){
				foreach ($kd_barang as $key => $value){
					# code...
					if(empty($value))continue;
					if($no_ro[$key]==''){$urutrequest='';}
					$datadetil=array('no_pembelian'=>$no_pembelian,
									'urut_pembelian'=>$urutpembelian,
									'no_ro'=>$no_ro[$key],
									'urut_request'=>$urutrequest,
									'kd_barang'=>$value,
									'jml_pembelian'=>$jml_pembelian[$key],
									'harga'=>$harga_beli[$key],
									'total'=>$total[$key],
									'jml_penerimaan'=>$jml_penerimaan);
					$this->mpembelian->insert('log_pembelian_det',$datadetil);						
					$urutpembelian++;
					$urutrequest++;
				}
			}
			$msg['pesan']="Data Berhasil Di Simpan";
		}
		$msg['status']=1;
		$msg['keluar']=0;
		if($submit=="simpankeluar"){
			$msg['keluar']=1;
		}
		echo json_encode($msg);
	}

	public function hapuspembelian($no_pembelian=""){
		$msg=array();
		$error=0;
		if(empty($no_pembelian)){
			$msg['pesan']="Pilih Transaksi yang akan di hapus";
			echo "<script>Alert('".$msg['pesan']."')</script>";
		}else{			
			$this->mpembelian->delete('log_pembelian','no_pembelian="'.$no_pembelian.'"');
			$this->mpembelian->delete('log_pembelian_det','no_pembelian="'.$no_pembelian.'"');	
			redirect('/log_transaksi/pembelian/');
		}
	}
	
	public function ambildaftarbarangbynama(){
		$q=$this->input->get('query');
		$items=$this->mpembelian->ambilData2($q);
		echo json_encode($items);
	}
	
	public function ambilvendorbykode(){
		$q=$this->input->get('query');
		$items=$this->mpembelian->ambilData3($q);
		echo json_encode($items);
	}
	
	public function ambilvendorbynama(){
		$q=$this->input->get('query');
		$items=$this->mpembelian->ambilData4($q);
		echo json_encode($items);
	}
	
	public function ambillokasitujuan()
	{
		$q=$this->input->get('query');
		$items=$this->mpembelian->ambilDataTujuan($q);
		echo json_encode($items);
	}
	
	public function periksapembelian() {
		$msg=array();
		$submit=$this->input->post('submit');
		$no_pembelian=$this->input->post('no_pembelian');
		$tgl_pembelian=$this->input->post('tgl_pembelian');
		$kd_vendor=$this->input->post('kd_vendor');
		$keterangan=$this->input->post('keterangan');
		$status_pembelian=$this->input->post('status_pembelian');
		$kd_user=$this->input->post('kd_user');
		
		$no_ro=$this->input->post('no_ro');
		$kd_barang=$this->input->post('kd_barang');
		$nama_barang=$this->input->post('nama_barang');
		$satuan=$this->input->post('satuan');
		$harga_beli=$this->input->post('harga_beli');
		$jml_pembelian=$this->input->post('jml_pembelian');
		$harga_beli=$this->input->post('harga_beli');
		$total=$this->input->post('total');
		$jml_penerimaan=0;		
		
		$jumlaherror=0;
		$msg['status']=1;
		$msg['clearform']=0;
		$msg['pesanatas']="";
		$msg['pesanlain']="";
		
		if($submit=="hapus"){
			if(empty($no_pembelian)){
				$msg['pesanatas']="Pilih Transaksi yang akan di hapus";
			}else{
				$this->mpembelian->delete('log_pembelian','no_pembelian="'.$no_pembelian.'"');
				$this->mpembelian->delete('log_pembelian_det','no_pembelian="'.$no_pembelian.'"');
				$msg['pesanatas']="Data Berhasil Di Hapus";
			}
			$msg['status']=0;
			$msg['clearform']=1;
			echo json_encode($msg);
		}
		else if($submit=="tutuptrans" or $submit=="bukatrans"){}
		else{
			//if(empty($no_distribusi)){
			//	$jumlaherror++;
			//	$msg['id'][]="no_distribusi";
			//	$msg['pesan'][]="No Distribusi Harus di Isi";
			//}
			if(empty($tgl_pembelian)){
				$jumlaherror++;
				$msg['id'][]="tgl_pembelian";
				$msg['pesan'][]="Kolom Tanggal Harus di Isi";
			}			
			if(!empty($kd_barang)){
				foreach ($kd_barang as $key => $value) {
					# code...
					if(empty($value))continue;
					if(empty($jml_pembelian[$key])){
						$msg['status']=0;
						$nama=$this->mpembelian->ambilNama($value);
						$msg['pesanlain'].="Jml.Beli ".$nama." Tidak boleh Kosong <br/>";					
					}					
				}
			}
			if($jumlaherror>0){
				$msg['status']=0;
				$msg['error']=$jumlaherror;
				$msg['pesanatas']="Terdapat beberapa kesalahan input silahkan cek inputan anda";
			}
		}
		echo json_encode($msg);
	}
	
	public function ambilitem()
	{
		$q=$this->input->get('query');
		$items=$this->mpembelian->ambilItemPembelian($q);
		echo json_encode($items);
	}
	
	public function ambilitems()
	{
		$q=$this->input->get('query');
		$items=$this->mpembelian->getAllDetailPembelian($q);

		echo json_encode($items);
	}
	
	public function ambilrequestbykode(){
		$q=$this->input->get('query');
		//$tes=$this->input->get('tes');
		//$items=$this->mpembelian->datarequest($tes,$q);
		$items=$this->mpembelian->datarequest($q);
		echo json_encode($items);
	}
	
	public function ambildetilrequest()
	{
		$q=$this->input->get('query');
		$q=rtrim($q, ",");
		//debugvar($q);
		$itemdetil=$this->mpembelian->getdetilrequest($q);
		echo json_encode($itemdetil);
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */