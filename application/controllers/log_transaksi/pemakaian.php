<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pemakaian extends CI_Controller {

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
		$this->load->model('logistik/mpemakaian');
	}
	
	public function index()	{
		$no_pemakaian='';
		$kd_lokasi='';
		$periodeawal=date('d-m-Y');
		$periodeakhir=date('d-m-Y');
		
		if($this->input->post('no_pemakaian')!=''){
			$no_pemakaian=$this->input->post('no_pemakaian');
		}
		if($this->input->post('kd_lokasi')!=''){
			$kd_lokasi=$this->input->post('kd_lokasi');
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
		$data=array('no_pemakaian'=>$no_pemakaian,
					'kd_lokasi'=>$kd_lokasi,
					'periodeawal'=>$periodeawal,
					'periodeakhir'=>$periodeakhir,
					//'datalokasi'=>$this->mpemakaian->ambilData('log_lokasi'),
					'items'=>$this->mpemakaian->ambilDataPemakaian($no_pemakaian,$kd_lokasi,$periodeawal,$periodeakhir));
		
		$this->load->view('headerlogistik',$dataheader);
		$this->load->view('logistik/transaksi/pemakaian/pemakaian',$data);
		$this->load->view('footer',$datafooter);
	}
		
	public function tambahpemakaian(){	
		$no_pemakaian="";
		
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
		
		$data=array('no_pemakaian'=>'',	
					'datalokasi'=>$this->mpemakaian->ambilData('log_lokasi'),
					'itemsdetiltransaksi'=>$this->mpemakaian->getAllDetailPemakaian($no_pemakaian),
					'itemtransaksi'=>$this->mpemakaian->ambilItemPemakaian($no_pemakaian),
					'items'=>$this->mpemakaian->ambilDataPemakaian('','','',''));
		//debugvar($data);
		$this->load->view('headerlogistik',$dataheader);
		$this->load->view('logistik/transaksi/pemakaian/tambahpemakaian',$data);
		$this->load->view('footer',$datafooter);	
	}
	
	public function ubahpemakaian($no_pemakaian=""){
		if(empty($no_pemakaian))return false;
		
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
			'no_pemakaian'=>$no_pemakaian,
			'datalokasi'=>$this->mpemakaian->ambilData('log_lokasi'),
			'itemtransaksi'=>$this->mpemakaian->ambilItemPemakaian($no_pemakaian),
			'itemsdetiltransaksi'=>$this->mpemakaian->getAllDetailPemakaian($no_pemakaian),
			'items'=>$this->mpemakaian->ambilDataPemakaian('','','','')	
		);
		//debugvar($data);
		$this->load->view('headerlogistik',$dataheader);
		$this->load->view('logistik/transaksi/pemakaian/tambahpemakaian',$data);
		$this->load->view('footer',$datafooter);
	}
	
	public function simpanpemakaian(){
		$msg=array();
		$submit=$this->input->post('submit');
		$no_pemakaian=$this->input->post('no_pemakaian');
		$tgl_pemakaian=$this->input->post('tgl_pemakaian');
		$kd_lokasi=$this->input->post('kd_lokasi');
		$nama_lokasi=$this->input->post('nama_lokasi');
		$keterangan=$this->input->post('keterangan');
		$kd_user=$this->input->post('kd_user');
		
		$no_pemakaian=$this->input->post('no_pemakaian');
		$kd_barang=$this->input->post('kd_barang');
		$nama_barang=$this->input->post('nama_barang');
		$satuan=$this->input->post('satuan');
		$jml_pemakaian=$this->input->post('jml_pemakaian');
		$jml_stok=$this->input->post('jml_stok');
		$status_pemakaian=$this->input->post('status_pemakaian');
		
		$msg['no_pemakaian']=$no_pemakaian;
		//$msg['status_pemakaian']=0;
		if($submit=="tutuptrans"){
			if(empty($no_pemakaian))return false;
			$updatedistribusi=array('status_pemakaian'=>1);
			$this->mpemakaian->update('log_pemakaian',$updatedistribusi,'no_pemakaian="'.$no_pemakaian.'"');
			
			if(!empty($kd_barang)){
				foreach ($kd_barang as $key => $value){
					$jml_stok=$this->mpemakaian->ambilStok($kd_lokasi,$value);
					$sisastok=$jml_stok-$jml_pemakaian[$key];
					$datastok=array('jml_stok'=>$sisastok);
					$this->mpemakaian->update('log_stok_barang',$datastok,'kd_lokasi="'.$kd_lokasi.'" and kd_barang="'.$value.'"');
				}
			}
			
			$msg['status']=1;
			$msg['posting']=1;
			$msg['pesan']="Tutup Transksi Berhasil";
			echo json_encode($msg);
			return false;
		}
		if($submit=="bukatrans"){
			if(empty($no_pemakaian))return false;
			$updatedistribusi=array('status_pemakaian'=>0);
			$this->mpemakaian->update('log_pemakaian',$updatedistribusi,'no_pemakaian="'.$no_pemakaian.'"');
			
			$items=$this->mpemakaian->getAllDetailPemakaian($no_pemakaian);
			foreach($items as $itemdetil){
				$kode=$itemdetil['kd_barang'];
				$kiteye=$itemdetil['jml_pemakaian']; //bwt ngembaliin stok awalnya, dy dikurang dulu
				$stokawal=$this->mpemakaian->ambilStok($kd_lokasi,$kode);
				$stokakhir=$stokawal+$kiteye;
				$datastoka=array('jml_stok'=>$stokakhir);
				$this->mpemakaian->update('log_stok_barang',$datastoka,'kd_lokasi="'.$kd_lokasi.'" and kd_barang="'.$kode.'"');
			}
			
			$msg['status']=1;
			$msg['posting']=2;
			$msg['pesan']="Buka Transksi Berhasil";
			echo json_encode($msg);
			return false;
		}

		if($this->mpemakaian->isNumberExist($no_pemakaian)){ //edit
		    $datapemakaianedit=array('tgl_pemakaian'=>convertDate($tgl_pemakaian),'kd_lokasi'=>$kd_lokasi,
										'keterangan'=>$keterangan,'status_pemakaian'=>$status_pemakaian,'kd_user'=>0);
				
			$this->mpemakaian->update('log_pemakaian',$datapemakaianedit,'no_pemakaian="'.$no_pemakaian.'"');
			
			/*$items=$this->mpemakaian->getAllDetailPemakaian($no_pemakaian);
			foreach($items as $itemdetil){
				$kode=$itemdetil['kd_barang'];
				$kiteye=$itemdetil['jml_pemakaian']; //bwt ngembaliin stok awalnya, dy dikurang dulu
				$stokawal=$this->mpemakaian->ambilStok($kd_lokasi,$kode);
				$stokakhir=$stokawal+$kiteye;
				$datastoka=array('jml_stok'=>$stokakhir);
				$this->mpemakaian->update('log_stok_barang',$datastoka,'kd_lokasi="'.$kd_lokasi.'" and kd_barang="'.$kode.'"');
			}*/
			
			$this->mpemakaian->delete('log_pemakaian_det','no_pemakaian="'.$no_pemakaian.'"');
			$urutpemakaian=1;			
			
			if(!empty($kd_barang)){
				foreach ($kd_barang as $key => $value){
					# code...
					if(empty($value))continue;
					$datadetil=array('no_pemakaian'=>$no_pemakaian,
									'urut_pemakaian'=>$urutpemakaian,
									'kd_barang'=>$value,
									'jml_pemakaian'=>$jml_pemakaian[$key]);
					$this->mpemakaian->insert('log_pemakaian_det',$datadetil);	
					
					/*$jml_stok=$this->mpemakaian->ambilStok($kd_lokasi,$value);
					$sisastok=$jml_stok-$jml_pemakaian[$key];
					$datastok=array('jml_stok'=>$sisastok);
					$this->mpemakaian->update('log_stok_barang',$datastok,'kd_lokasi="'.$kd_lokasi.'" and kd_barang="'.$value.'"');*/
					
					$urutpemakaian++;
				}
			}			
			$msg['pesan']="Data Berhasil Di Update";
		}
		else { //simpan baru			
			$tanggal=date('d-m-Y');
			$tgl=explode("-", $tanggal);
			$kode=$this->mpemakaian->autoNumber($tgl[2],$tgl[1]);
			$kodebaru=$kode+1;
			$kodebaru=str_pad($kodebaru,5,0,STR_PAD_LEFT); 
			$no_pemakaian="PMK.".substr($tgl[2],2,2)."".$tgl[1].".".$kodebaru;
			$msg['no_pemakaian']=$no_pemakaian;
			
			$datapemakaian=array('no_pemakaian'=>$no_pemakaian,
									'tgl_pemakaian'=>convertDate($tgl_pemakaian),
									'kd_lokasi'=>$kd_lokasi,
									'keterangan'=>$keterangan,
									'status_pemakaian'=>$status_pemakaian,'kd_user'=>0);
			
			$this->mpemakaian->insert('log_pemakaian',$datapemakaian);
			$urutpemakaian=1;
			if(!empty($kd_barang)){
				foreach ($kd_barang as $key => $value){
					# code...
					if(empty($value))continue;
					//if($no_ro[$key]==''){$urutrequest='';}
					$datadetil=array('no_pemakaian'=>$no_pemakaian,
									'urut_pemakaian'=>$urutpemakaian,
									'kd_barang'=>$value,
									'jml_pemakaian'=>$jml_pemakaian[$key]);
					$this->mpemakaian->insert('log_pemakaian_det',$datadetil);	
					
					/*$jml_stok=$this->mpemakaian->ambilStok($kd_lokasi,$value);
					$sisastok=$jml_stok-$jml_pemakaian[$key];
					$datastok=array('jml_stok'=>$sisastok);
					$this->mpemakaian->update('log_stok_barang',$datastok,'kd_lokasi="'.$kd_lokasi.'" and kd_barang="'.$value.'"');*/
					
					$urutpemakaian++;
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

	public function hapuspemakaian($no_pemakaian=""){
		$msg=array();
		$error=0;
		if(empty($no_pemakaian)){
			$msg['pesan']="Pilih Transaksi yang akan di hapus";
			echo "<script>Alert('".$msg['pesan']."')</script>";
		}else{			
			$this->mpemakaian->delete('log_pemakaian','no_pemakaian="'.$no_pemakaian.'"');
			$this->mpemakaian->delete('log_pemakaian_det','no_pemakaian="'.$no_pemakaian.'"');	
			redirect('/log_transaksi/pemakaian/');
		}
	}
	
	public function periksapemakaian() {
		$msg=array();
		$submit=$this->input->post('submit');
		$no_pemakaian=$this->input->post('no_pemakaian');
		$tgl_pemakaian=$this->input->post('tgl_pemakaian');
		$kd_lokasi=$this->input->post('kd_lokasi');
		$nama_lokasi=$this->input->post('nama_lokasi');
		$keterangan=$this->input->post('keterangan');
		$kd_user=$this->input->post('kd_user');
		
		$no_pemakaian=$this->input->post('no_pemakaian');
		$kd_barang=$this->input->post('kd_barang');
		$nama_barang=$this->input->post('nama_barang');
		$satuan=$this->input->post('satuan');
		$jml_pemakaian=$this->input->post('jml_pemakaian');
		$jml_stok=$this->input->post('jml_stok');
		$status_pemakaian=$this->input->post('status_pemakaian');
		
		$jumlaherror=0;
		$msg['status']=1;
		$msg['clearform']=0;
		$msg['pesanatas']="";
		$msg['pesanlain']="";
		
		if($submit=="hapus"){
			if(empty($no_pemakaian)){
				$msg['pesanatas']="Pilih Transaksi yang akan di hapus";
			}else{
				$this->mpemakaian->delete('log_pemakaian','no_pemakaian="'.$no_pemakaian.'"');
				$this->mpemakaian->delete('log_pemakaian_det','no_pemakaian="'.$no_pemakaian.'"');
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
			if(empty($tgl_pemakaian)){
				$jumlaherror++;
				$msg['id'][]="tgl_pemakaian";
				$msg['pesan'][]="Kolom Tanggal Harus di Isi";
			}			
			if(!empty($kd_barang)){
				foreach ($kd_barang as $key => $value) {
					# code...
					if(empty($value))continue;
					if(empty($jml_pemakaian[$key])){
						$msg['status']=0;
						$nama=$this->mpemakaian->ambilNama($value);
						$msg['pesanlain'].="Jml. Pemakaian ".$nama." Tidak boleh Kosong <br/>";					
					}
					if($jml_pemakaian[$key]>$jml_stok[$key]){
						$msg['status']=0;
						$nama=$this->mpemakaian->ambilNama($value);
						$msg['pesanlain'].="Stok ".$nama." tidak mencukupi <br/>";
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
		$items=$this->mpemakaian->ambilItemPemakaian($q);
		echo json_encode($items);
	}
	
	public function ambilitems()
	{
		$q=$this->input->get('query');
		$items=$this->mpemakaian->getAllDetailPemakaian($q);

		echo json_encode($items);
	}
	
	public function ambildaftarbarangbynama() {
		$q=$this->input->get('query');
		$tes=$this->input->get('tes');
		$items=$this->mpemakaian->ambilData2($tes,$q);
		echo json_encode($items);
	}
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */