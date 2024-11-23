<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Requestorder extends CI_Controller {

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
		$this->load->model('logistik/mrequest');
	}
	
	public function index()	{
		//$no_ro=$this->input->post('no_ro');
		//$periodeawal=$this->input->post('periodeawal');
		//$periodeakhir=$this->input->post('periodeakhir');
		
		$no_ro='';
		$kd_lokasi='';
		$periodeawal=date('d-m-Y');
		$periodeakhir=date('d-m-Y');
		
		if($this->input->post('no_ro')!=''){
			$no_ro=$this->input->post('no_ro');
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
							'lib/chosen.jquery.min.js',
							'spin.js',
							'main.js');
		$dataheader=array('jsfile'=>$jsfileheader,'cssfile'=>$cssfileheader,'title'=>$this->title);
		$jsfooter=array();
		$datafooter=array('jsfile'=>$jsfooter);
		
		$data=array('no_ro'=>$no_ro,
					'kd_lokasi'=>$kd_lokasi,
					'periodeawal'=>$periodeawal,
					'periodeakhir'=>$periodeakhir,
					'items'=>$this->mrequest->ambilDataRequest($no_ro,$periodeawal,$periodeakhir,$kd_lokasi));
		
		//debugvar($items);
		$this->load->view('headerlogistik',$dataheader);
		$this->load->view('logistik/transaksi/request/requestorder',$data);
		$this->load->view('footer',$datafooter);
	}
		
	public function tambahrequest(){	
		$kode=""; $no_ro=""; 
		
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
							'lib/bootstrap-timepicker.js',
							'lib/bootstrap-inputmask.js',
							'lib/bootstrap-modal.js',
							'lib/chosen.jquery.min.js',
							'spin.js',
							'main.js');
		$dataheader=array('jsfile'=>$jsfileheader,'cssfile'=>$cssfileheader,'title'=>$this->title);
		$jsfooter=array();
		$datafooter=array('jsfile'=>$jsfooter);
		
		$data=array('no_ro'=>'',
					'datalokasi'=>$this->mrequest->ambilData('log_lokasi'),
					'itemtransaksi'=>$this->mrequest->ambilItemData($no_ro),
					'itemsdetiltransaksi'=>$this->mrequest->getAllDetailRequest($no_ro),
					'items'=>$this->mrequest->ambilDataRequest('','','','')
					);
		
		$this->load->view('headerlogistik',$dataheader);
		$this->load->view('logistik/transaksi/request/tambahrequest',$data);
		$this->load->view('footer',$datafooter);	
	}
	
	public function ubahrequest($no_ro=""){
		
		if(empty($no_ro))return false;
		$cssfileheader=array('bootstrap.min.css','bootstrap-responsive.min.css','font-awesome.min.css','style.css','prettify.css','jquery-ui.css','DT_bootstrap.css','responsive-tables.css','datepicker.css','timepicker.css','theme.css');
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
		$data=array('datalokasi'=>$this->mrequest->ambilData('log_lokasi'),
					'no_ro'=>$no_ro,
					'itemtransaksi'=>$this->mrequest->ambilItemData($no_ro),
					'itemsdetiltransaksi'=>$this->mrequest->getAllDetailRequest($no_ro),
					'items'=>$this->mrequest->ambilDataRequest('','','','')
					);
		
		$this->load->view('headerlogistik',$dataheader);
		$this->load->view('logistik/transaksi/request/tambahrequest',$data);
		$this->load->view('footer',$datafooter);
	}
	
	public function simpanrequest(){
		$msg=array();
		$submit=$this->input->post('submit');
		
		$no_ro=$this->input->post('no_ro');
		$tgl_ro=$this->input->post('tgl_ro');
		$jam_ro=$this->input->post('jam_ro');
		$jam_ro1=$this->input->post('jam_ro1');
		$kd_lokasi=$this->input->post('kd_lokasi');
		$nama_lokasi=$this->input->post('nama_lokasi');
		$keterangan=$this->input->post('keterangan');
		
		$kd_barang=$this->input->post('kd_barang');
		$nama_barang=$this->input->post('nama_barang');
		$satuan=$this->input->post('satuan');
		$harga_beli=$this->input->post('harga_beli');
		$jml_req=$this->input->post('jml_req');
		$req_status=$this->input->post('req_status');
		$kd_user=0;
		//$req_status=0;
		
		$msg['no_ro']=$no_ro;
		if($submit=="tutuptrans"){
			if(empty($no_ro))return false;
			$updaterequest=array('req_status'=>1);
			$this->mrequest->update('log_request_order',$updaterequest,'no_ro="'.$no_ro.'"');
			$msg['status']=1;
			$msg['posting']=1;
			$msg['pesan']="Tutup Transksi Berhasil";
			echo json_encode($msg);
			return false;
		}
		if($submit=="bukatrans"){
			if(empty($no_ro))return false;
			$updaterequest=array('req_status'=>0);
			$this->mrequest->update('log_request_order',$updaterequest,'no_ro="'.$no_ro.'"');
			$msg['status']=1;
			$msg['posting']=2;
			$msg['pesan']="Buka Transksi Berhasil";
			echo json_encode($msg);
			return false;
		}
		
		if($this->mrequest->isNumberExist($no_ro)){ //edit
			$tgl_ro1=convertDate($tgl_ro)." ".$jam_ro1;
		    $datarequestedit=array('kd_lokasi'=>$kd_lokasi,
									'tgl_ro'=>$tgl_ro1,
									'keterangan'=>$keterangan,
									'req_status'=>$req_status,
									'kd_user'=>$kd_user
									);				
			$this->mrequest->update('log_request_order',$datarequestedit,'no_ro="'.$no_ro.'"');
			
			$this->mrequest->delete('log_request_order_det','no_ro="'.$no_ro.'"');
			$urut=1;
			if(!empty($kd_barang)){
				foreach ($kd_barang as $key => $value){
					if(empty($value))continue;					
					$datadetil=array('no_ro'=>$no_ro,
									'urut_request'=>$urut,
									'kd_barang'=>$value,
									'jml_req'=>$jml_req[$key],
									'jml_pembelian'=>0,
									'jml_distribusi'=>0);
					$this->mrequest->insert('log_request_order_det',$datadetil);										
					$urut++;
				}
			}
			$msg['pesan']="Data Berhasil Di Update";
		}else { //simpan baru
			$tanggal=date('d-m-Y');
			$tgl=explode("-", $tanggal);
			$kode=$this->mrequest->autoNumber($tgl[2],$tgl[1]);
			$kodebaru=$kode+1;
			$kodebaru=str_pad($kodebaru,6,0,STR_PAD_LEFT); 
			$no_ro="RO.".substr($tgl[2],2,2)."".$tgl[1].".".$kodebaru;
			
			$tgl_ro1=convertDate($tgl_ro)." ".$jam_ro;
			
			$msg['no_ro']=$no_ro;
			$datarequest=array('no_ro'=>$no_ro,
								'kd_lokasi'=>$kd_lokasi,
								'tgl_ro'=>$tgl_ro1,
								'keterangan'=>$keterangan,
								'req_status'=>$req_status,
								'kd_user'=>$kd_user
								);
			
			$this->mrequest->insert('log_request_order',$datarequest);
			$urut=1;
			if(!empty($kd_barang)){
				foreach ($kd_barang as $key => $value){
					# code...
					if(empty($value))continue;										
					$datadetil=array('no_ro'=>$no_ro,
									'urut_request'=>$urut,
									'kd_barang'=>$value,
									'jml_req'=>$jml_req[$key],
									'jml_pembelian'=>0,
									'jml_distribusi'=>0);

					$this->mrequest->insert('log_request_order_det',$datadetil);										
					$urut++;
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
	
	public function hapusrequest($no_ro=""){
		//$kd_unit_apt="";
		$msg=array();
		$error=0;
		if(empty($no_ro)){
			$msg['pesan']="Pilih Transaksi yang akan di hapus";
			echo "<script>Alert('".$msg['pesan']."')</script>";
		}else{		
			$this->mrequest->delete('log_request_order','no_ro="'.$no_ro.'"');
			$this->mrequest->delete('log_request_order_det','no_ro="'.$no_ro.'"');			
			redirect('/log_transaksi/requestorder/');
		}
	}
		
	public function ambildaftarbarangbynama(){
		$q=$this->input->get('query');
		$items=$this->mrequest->ambilData2($q);
		echo json_encode($items);
	}
	
	public function ambildaftarbarangbykode(){
		$q=$this->input->get('query');
		$items=$this->mrequest->ambilData3($q);
		echo json_encode($items);
	}
	
	public function periksarequest() {
		$msg=array();
		$submit=$this->input->post('submit');
		$no_ro=$this->input->post('no_ro');
		$tgl_ro=$this->input->post('tgl_ro');
		$jam_ro=$this->input->post('jam_ro');
		$jam_ro1=$this->input->post('jam_ro1');
		$kd_lokasi=$this->input->post('kd_lokasi');
		$nama_lokasi=$this->input->post('nama_lokasi');
		$keterangan=$this->input->post('keterangan');
		
		$kd_barang=$this->input->post('kd_barang');
		$nama_barang=$this->input->post('nama_barang');
		$satuan=$this->input->post('satuan');
		$harga_beli=$this->input->post('harga_beli');
		$jml_req=$this->input->post('jml_req');
		$kd_user=0;
		$req_status=0;
		
		$jumlaherror=0;
		$msg['status']=1;
		$msg['clearform']=0;
		$msg['pesanatas']="";
		$msg['pesanlain']="";
		
		if($submit=="hapus"){
			if(empty($no_ro)){
				$msg['pesanatas']="Pilih Transaksi yang akan di hapus";
			}else{
				$this->mrequest->delete('log_request_order','no_ro="'.$no_ro.'"');
				$this->mrequest->delete('log_request_order_det','no_ro="'.$no_ro.'"');
				$msg['pesanatas']="Data Berhasil Di Hapus";
			}
			$msg['status']=0;
			$msg['clearform']=1;
			echo json_encode($msg);
		}
		else{
			if(empty($kd_lokasi)){
				$jumlaherror++;
				$msg['id'][]="kd_lokasi";
				$msg['pesan'][]="Lokasi belum dipilih";
			}
			if(!empty($kd_barang)){
				foreach ($kd_barang as $key => $value) {
					# code...
					if(empty($value))continue;
					/*if(empty($value)){
						$msg['status']=0;
						$msg['pesanlain'].="Nama Barang harus diisi <br/>";					
					}*/
					/*if(empty($kategori[$key])){
						$msg['status']=0;
						$msg['pesanlain'].="Kategori tidak boleh Kosong <br/>";					
					}
					if(empty($harga_beli[$key])){
						$msg['status']=0;
						$msg['pesanlain'].="Harga beli tidak boleh Kosong <br/>";					
					}*/
					if(empty($jml_req[$key])){
						$msg['status']=0;
						$nama=$this->mrequest->ambilNama($value);
						$msg['pesanlain'].="Jml. Request ".$nama." tidak boleh Kosong <br/>";					
					}
				}
			}
			if($jumlaherror>0){
				$msg['status']=0;
				$msg['error']=$jumlaherror;
				$msg['pesanatas']="Terdapat beberapa kesalahan input silahkan cek inputan anda";
			}
			/*if($this->mpemesananapt->isPosted($no_pemesanan) && $submit!="bukatrans"){
				$jumlaherror++;
				$msg['status']=0;
				$msg['pesanatas']="Transaksi ini tidak bisa di Edit atau Hapus,karena sudah di Tutup";
			}*/

		}
		echo json_encode($msg);
	}

	
	public function ambilitem()
	{
		$q=$this->input->get('query');
		$items=$this->mrequest->getRequest($q);
		echo json_encode($items);
	}
	
	public function ambilitems()
	{
		$q=$this->input->get('query');
		$items=$this->mrequest->getAllDetailRequest($q);
		echo json_encode($items);
	}

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */