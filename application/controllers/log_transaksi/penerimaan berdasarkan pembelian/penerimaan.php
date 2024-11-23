<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Penerimaan extends CI_Controller {

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
		$this->load->model('logistik/mpenerimaan');
	}
	
	public function index()	{
		//$no_penerimaan=$this->input->post('no_penerimaan');
		//$periodeawal=$this->input->post('periodeawal');
		//$periodeakhir=$this->input->post('periodeakhir');
		
		$no_penerimaan='';
		$periodeawal=date('d-m-Y');
		$periodeakhir=date('d-m-Y');
		
		if($this->input->post('no_penerimaan')!=''){
			$no_penerimaan=$this->input->post('no_penerimaan');
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
		$data=array('no_penerimaan'=>$no_penerimaan,
					'periodeawal'=>$periodeawal,
					'periodeakhir'=>$periodeakhir,
					'items'=>$this->mpenerimaan->ambilDataPenerimaan($no_penerimaan,$periodeawal,$periodeakhir));
		
		$this->load->view('headerlogistik',$dataheader);
		$this->load->view('logistik/transaksi/penerimaan/penerimaan',$data);
		$this->load->view('footer',$datafooter);
	}
		
	public function tambahpenerimaan(){	
		$kode=""; $no_penerimaan="";
		
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
		
		$data=array('no_penerimaan'=>'',	
					'itemsdetiltransaksi'=>$this->mpenerimaan->getAllDetailPenerimaan($no_penerimaan),
					'itemtransaksi'=>$this->mpenerimaan->ambilItemPenerimaan($no_penerimaan),
					'items'=>$this->mpenerimaan->ambilDataPenerimaan('','','',''));
		//debugvar($data);
		$this->load->view('headerlogistik',$dataheader);
		$this->load->view('logistik/transaksi/penerimaan/tambahpenerimaan',$data);
		$this->load->view('footer',$datafooter);	
	}
	
	public function ubahpenerimaan($no_penerimaan=""){
		if(empty($no_penerimaan))return false;
		
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
			'no_penerimaan'=>$no_penerimaan,
			'itemtransaksi'=>$this->mpenerimaan->ambilItemPenerimaan($no_penerimaan),
			'itemsdetiltransaksi'=>$this->mpenerimaan->getAllDetailPenerimaan($no_penerimaan),
			'items'=>$this->mpenerimaan->ambilDataPenerimaan('','','','')	
		);
		//debugvar($data);
		$this->load->view('headerlogistik',$dataheader);
		$this->load->view('logistik/transaksi/penerimaan/tambahpenerimaan',$data);
		$this->load->view('footer',$datafooter);
	}
	
	public function simpanpenerimaan(){
		$msg=array();
		$submit=$this->input->post('submit');
		$no_penerimaan=$this->input->post('no_penerimaan');
		$tgl_penerimaan=$this->input->post('tgl_penerimaan');
		$keterangan=$this->input->post('keterangan');
		$status_penerimaan=$this->input->post('status_penerimaan');
		$kd_user=$this->input->post('kd_user');
		
		$no_pembelian=$this->input->post('no_pembelian');
		$no_ro=$this->input->post('no_ro');
		$kd_barang=$this->input->post('kd_barang');
		$nama_barang=$this->input->post('nama_barang');
		$satuan=$this->input->post('satuan');
		$harga=$this->input->post('harga');
		$jml_penerimaan=$this->input->post('jml_penerimaan');
		$jumlah=$this->input->post('jumlah');
		$jml_req=$this->input->post('jml_req');
		$kd_lokasi=$this->mpenerimaan->ambilKodeLokasi();
		
		$msg['no_penerimaan']=$no_penerimaan;
		
		if($submit=="tutuptrans"){
			if(empty($no_penerimaan))return false;
			$updatepenerimaan=array('status_penerimaan'=>1);
			$this->mpenerimaan->update('log_penerimaan_beli',$updatepenerimaan,'no_penerimaan="'.$no_penerimaan.'"');
			
			if(!empty($kd_barang)){
				foreach ($kd_barang as $key => $value){
					if(empty($value))continue;
					//update ke log_pembelian
					$urut=$this->mpenerimaan->ambilUrutPembelian($no_pembelian[$key],$no_ro[$key],$value);
					$dataa=array('jml_penerimaan'=>$jml_penerimaan[$key]);
					$this->mpenerimaan->update('log_pembelian_det',$dataa,'no_pembelian="'.$no_pembelian[$key].'" and no_ro="'.$no_ro[$key].'" and urut_pembelian="'.$urut.'" and kd_barang="'.$value.'"');
					
					//update stok
					if($this->mpenerimaan->cekStok($value,$kd_lokasi)){//kalo datanya ada
						$jml_stok=$this->mpenerimaan->ambilStok($kd_lokasi,$value);
						$sisastok=$jml_stok+$jml_penerimaan[$key];
						$datastok=array('jml_stok'=>$sisastok);
						$this->mpenerimaan->update('log_stok_barang',$datastok,'kd_lokasi="'.$kd_lokasi.'" and kd_barang="'.$value.'"');
					}
					else{ //kalo datanya ga ada
						$jml_stok=$jml_penerimaan[$key];
						$data1=array('kd_barang'=>$value,
									'kd_lokasi'=>$kd_lokasi,
									'jml_stok'=>$jml_penerimaan[$key]);
						$this->mpenerimaan->insert('log_stok_barang',$data1);						
					}
				}
			}
			
			$msg['status']=1;
			$msg['posting']=1;
			$msg['pesan']="Tutup Transksi Berhasil";
			echo json_encode($msg);
			return false;
		}
		if($submit=="bukatrans"){
			if(empty($no_penerimaan))return false;
			$updatepenerimaan=array('status_penerimaan'=>0);
			$this->mpenerimaan->update('log_penerimaan_beli',$updatepenerimaan,'no_penerimaan="'.$no_penerimaan.'"');
			
			if(!empty($kd_barang)){
				foreach ($kd_barang as $key => $value){
					if(empty($value))continue;					
					if($no_pembelian[$key]!=''){			
						//untuk ngembaliin jml_pembelian awal di log_requestny
						$urut=$this->mpenerimaan->ambilUrutbeli($no_pembelian[$key],$value);
						$jml_penerimaanawal=$this->mpenerimaan->jumpenerimaanawal($no_pembelian[$key],$value);
						$jumbalik=$jml_penerimaanawal-$jml_penerimaan[$key];
						$dataa=array('jml_penerimaan'=>$jumbalik);
						$this->mpenerimaan->update('log_pembelian_det',$dataa,'no_pembelian="'.$no_pembelian[$key].'" and urut_pembelian="'.$urut.'" and kd_barang="'.$value.'"');			
					}
				}
			}
			
			$items=$this->mpenerimaan->getAllDetailPenerimaan($no_penerimaan);
			foreach($items as $itemdetil){
				$kode=$itemdetil['kd_barang'];
				$kiteye=$itemdetil['jml_penerimaan']; //bwt ngembaliin stok awalnya, dy dikurang dulu
				$stokawal=$this->mpenerimaan->ambilStok($kd_lokasi,$kode);
				$stokakhir=$stokawal-$kiteye;
				$datastoka=array('jml_stok'=>$stokakhir);
				$this->mpenerimaan->update('log_stok_barang',$datastoka,'kd_lokasi="'.$kd_lokasi.'" and kd_barang="'.$kode.'"');
			}			
			//$this->mpenerimaan->delete('log_penerimaan_beli_det','no_penerimaan="'.$no_penerimaan.'"');
			
			$msg['status']=1;
			$msg['posting']=2;
			$msg['pesan']="Buka Transksi Berhasil";
			echo json_encode($msg);
			return false;
		}

		if($this->mpenerimaan->isNumberExist($no_penerimaan)){ //edit
		    $datapenerimaanedit=array('tgl_penerimaan'=>convertDate($tgl_penerimaan),'kd_lokasi'=>$kd_lokasi,
										'keterangan'=>$keterangan,'status_penerimaan'=>$status_penerimaan,'kd_user'=>0);
				
			$this->mpenerimaan->update('log_penerimaan_beli',$datapenerimaanedit,'no_penerimaan="'.$no_penerimaan.'"');
			
			/*$items=$this->mpenerimaan->getAllDetailPenerimaan($no_penerimaan);
			foreach($items as $itemdetil){
				$kode=$itemdetil['kd_barang'];
				$kiteye=$itemdetil['jml_penerimaan']; //bwt ngembaliin stok awalnya, dy dikurang dulu
				$stokawal=$this->mpenerimaan->ambilStok($kd_lokasi,$kode);
				$stokakhir=$stokawal-$kiteye;
				$datastoka=array('jml_stok'=>$stokakhir);
				$this->mpenerimaan->update('log_stok_barang',$datastoka,'kd_lokasi="'.$kd_lokasi.'" and kd_barang="'.$kode.'"');
			}*/
			
			$this->mpenerimaan->delete('log_penerimaan_beli_det','no_penerimaan="'.$no_penerimaan.'"');
			$urutpenerimaan=1;
			$urutpembelian=1;			
			
			if(!empty($kd_barang)){
				foreach ($kd_barang as $key => $value){
					# code...
					if(empty($value))continue;
					$datadetil=array('no_penerimaan'=>$no_penerimaan,
									'urut_penerimaan'=>$urutpenerimaan,
									'no_pembelian'=>$no_pembelian[$key],
									'urut_pembelian'=>$urutpembelian,
									'kd_barang'=>$value,
									'jml_penerimaan'=>$jml_penerimaan[$key],
									'harga'=>$harga[$key]);
					$this->mpenerimaan->insert('log_penerimaan_beli_det',$datadetil);
					$urutpenerimaan++;
					$urutpembelian++;
				}
			}			
			$msg['pesan']="Data Berhasil Di Update";
		}
		else { //simpan baru			
			$tanggal=date('d-m-Y');
			$tgl=explode("-", $tanggal);
			$kode=$this->mpenerimaan->autoNumber($tgl[2],$tgl[1]);
			$kodebaru=$kode+1;
			$kodebaru=str_pad($kodebaru,5,0,STR_PAD_LEFT); 
			$no_penerimaan="PNR.".substr($tgl[2],2,2)."".$tgl[1].".".$kodebaru;
			$msg['no_penerimaan']=$no_penerimaan;
			
			$datapenerimaan=array('no_penerimaan'=>$no_penerimaan,
									'tgl_penerimaan'=>convertDate($tgl_penerimaan),
									'kd_lokasi'=>$kd_lokasi,
									'keterangan'=>$keterangan,
									'status_penerimaan'=>$status_penerimaan,'kd_user'=>0);
			
			$this->mpenerimaan->insert('log_penerimaan_beli',$datapenerimaan);
			$urutpenerimaan=1;
			$urutpembelian=1;
			if(!empty($kd_barang)){
				foreach ($kd_barang as $key => $value){
					# code...
					if(empty($value))continue;
					//if($no_ro[$key]==''){$urutrequest='';}
					$datadetil=array('no_penerimaan'=>$no_penerimaan,
									'urut_penerimaan'=>$urutpenerimaan,
									'no_pembelian'=>$no_pembelian[$key],
									'urut_pembelian'=>$urutpembelian,
									'kd_barang'=>$value,
									'jml_penerimaan'=>$jml_penerimaan[$key],
									'harga'=>$harga[$key]);
					$this->mpenerimaan->insert('log_penerimaan_beli_det',$datadetil);					
					$urutpenerimaan++;
					$urutpembelian++;
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

	public function hapuspenerimaan($no_penerimaan=""){
		$msg=array();
		$error=0;
		if(empty($no_penerimaan)){
			$msg['pesan']="Pilih Transaksi yang akan di hapus";
			echo "<script>Alert('".$msg['pesan']."')</script>";
		}else{			
			$this->mpenerimaan->delete('log_penerimaan_beli','no_penerimaan="'.$no_penerimaan.'"');
			$this->mpenerimaan->delete('log_penerimaan_beli_det','no_penerimaan="'.$no_penerimaan.'"');	
			redirect('/log_transaksi/penerimaan/');
		}
	}
	
	public function ambildaftarbarangbynama(){
		$q=$this->input->get('query');
		$items=$this->mpenerimaan->ambilData2($q);
		echo json_encode($items);
	}
	
	public function periksapenerimaan() {
		$msg=array();
		$submit=$this->input->post('submit');
		$no_penerimaan=$this->input->post('no_penerimaan');
		$tgl_penerimaan=$this->input->post('tgl_penerimaan');
		$keterangan=$this->input->post('keterangan');
		$kd_user=$this->input->post('kd_user');
		
		$no_pembelian=$this->input->post('no_pembelian');
		$no_ro=$this->input->post('no_ro');
		$kd_barang=$this->input->post('kd_barang');
		$nama_barang=$this->input->post('nama_barang');
		$satuan=$this->input->post('satuan');
		$harga=$this->input->post('harga');
		$jml_penerimaan=$this->input->post('jml_penerimaan');
		$jumlah=$this->input->post('jumlah');		
		$jml_req=$this->input->post('jml_req');
		
		$jumlaherror=0;
		$msg['status']=1;
		$msg['clearform']=0;
		$msg['pesanatas']="";
		$msg['pesanlain']="";
		
		if($submit=="hapus"){
			if(empty($no_penerimaan)){
				$msg['pesanatas']="Pilih Transaksi yang akan di hapus";
			}else{
				$this->mpenerimaan->delete('log_penerimaan_beli','no_penerimaan="'.$no_penerimaan.'"');
				$this->mpenerimaan->delete('log_penerimaan_beli_det','no_penerimaan="'.$no_penerimaan.'"');
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
			if(empty($tgl_penerimaan)){
				$jumlaherror++;
				$msg['id'][]="tgl_penerimaan";
				$msg['pesan'][]="Kolom Tanggal Harus di Isi";
			}			
			if(!empty($kd_barang)){
				foreach ($kd_barang as $key => $value) {
					# code...
					if(empty($value))continue;
					if(empty($harga[$key])){
						$msg['status']=0;
						$nama=$this->mpenerimaan->ambilNama($value);
						$msg['pesanlain'].="Harga Beli ".$nama." Tidak boleh Kosong <br/>";					
					}
					if(empty($jml_penerimaan[$key])){
						$msg['status']=0;
						$nama=$this->mpenerimaan->ambilNama($value);
						$msg['pesanlain'].="Qty ".$nama." Tidak boleh Kosong <br/>";					
					}
					if(empty($jumlah[$key])){
						$msg['status']=0;
						$nama=$this->mpenerimaan->ambilNama($value);
						$msg['pesanlain'].="jumlah ".$nama." Tidak boleh Kosong <br/>";					
					}
					if($jml_penerimaan[$key]>$jml_req[$key]){
						$msg['status']=0;
						$nama=$this->mpenerimaan->ambilNama($value);
						$msg['pesanlain'].="Qty ".$nama." Tidak boleh melebihi Jml. Request <br/>";					
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
		$items=$this->mpenerimaan->ambilItemPenerimaan($q);
		echo json_encode($items);
	}
	
	public function ambilitems()
	{
		$q=$this->input->get('query');
		$items=$this->mpenerimaan->getAllDetailPenerimaan($q);

		echo json_encode($items);
	}
	
	public function ambilrequestbykode(){
		$q=$this->input->get('query');
		$tes=$this->input->get('tes');
		$items=$this->mpenerimaan->datarequest($tes,$q);
		echo json_encode($items);
	}
	
	public function ambildetilrequest()
	{
		$q=$this->input->get('query');
		$q=rtrim($q, ",");
		//debugvar($q);
		$itemdetil=$this->mpenerimaan->getdetilrequest($q);
		echo json_encode($itemdetil);
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */