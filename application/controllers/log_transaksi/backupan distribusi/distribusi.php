<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Distribusi extends CI_Controller {

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
		$this->load->model('logistik/mdistribusi');
	}
	
	public function index()	{
		$no_distribusi='';
		//$kd_lokasi='';
		$periodeawal=date('d-m-Y');
		$periodeakhir=date('d-m-Y');
		
		if($this->input->post('no_distribusi')!=''){
			$no_distribusi=$this->input->post('no_distribusi');
		}
		/*if($this->input->post('kd_lokasi')!=''){
			$kd_lokasi=$this->input->post('kd_lokasi');
		}*/
		if($this->input->post('periodeawal')!=''){
			$periodeawal=$this->input->post('periodeawal');
		}
		if($this->input->post('periodeakhir')!=''){
			$periodeakhir=$this->input->post('periodeakhir');
		}
		
		//$config['per_page'] =25;
		//$config['uri_segment'] = 3;
		//$this->pagination->initialize($config);		
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
		$data=array('no_distribusi'=>$no_distribusi,
					//'kd_lokasi'=>$kd_lokasi,
					'periodeawal'=>$periodeawal,
					'periodeakhir'=>$periodeakhir,
					//'unitlokasi'=>$this->mdistribusi->ambilData('log_lokasi'),
					//'items'=>$this->mdistribusi->ambilDataDistribusi($no_distribusi,$kd_lokasi,$periodeawal,$periodeakhir),
					'items'=>$this->mdistribusi->ambilDataDistribusi($no_distribusi,$periodeawal,$periodeakhir));
		//debugvar($data);
		$this->load->view('headerlogistik',$dataheader);
		$this->load->view('logistik/transaksi/distribusi/distribusi',$data);
		$this->load->view('footer',$datafooter);
	}
		
	public function tambahdistribusi(){	
		$kode=""; $no_distribusi=""; $kd_lokasi="";
		
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
		
		$data=array('no_distribusi'=>'',	
					'datalokasiasal'=>$this->mdistribusi->ambilData('log_lokasi'),
					//'datalokasitujuan'=>$this->mdistribusi->ambilDataTujuan('log_lokasi'),
					'datalokasitujuan'=>$this->mdistribusi->ambilDataTujuan($kd_lokasi),
					'itemsdetiltransaksi'=>$this->mdistribusi->getAllDetailDistribusi($no_distribusi),
					'itemtransaksi'=>$this->mdistribusi->ambilItemData('log_distribusi','no_distribusi="'.$no_distribusi.'"'),
					'items'=>$this->mdistribusi->ambilDataDistribusi('','',''));
		
		$this->load->view('headerlogistik',$dataheader);
		$this->load->view('logistik/transaksi/distribusi/tambahdistribusi',$data);
		$this->load->view('footer',$datafooter);	
	}
	
	public function ubahdistribusi($no_distribusi=""){
		if(empty($no_distribusi))return false;
		$kd_lokasi='';
		
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
			'datalokasiasal'=>$this->mdistribusi->ambilData('log_lokasi'),
			//'datalokasitujuan'=>$this->mdistribusi->ambilDataTujuan('log_lokasi'),
			'datalokasitujuan'=>$this->mdistribusi->ambilDataTujuan($kd_lokasi),
			'no_distribusi'=>$no_distribusi,
			'itemtransaksi'=>$this->mdistribusi->ambilItemData('log_distribusi','no_distribusi="'.$no_distribusi.'"'),
			'itemsdetiltransaksi'=>$this->mdistribusi->getAllDetailDistribusi($no_distribusi),
			'items'=>$this->mdistribusi->ambilDataDistribusi('','','')	
		);
		//debugvar($data);
		$this->load->view('headerlogistik',$dataheader);
		$this->load->view('logistik/transaksi/distribusi/tambahdistribusi',$data);
		$this->load->view('footer',$datafooter);
	}
	
	public function simpandistribusi(){
		$msg=array();
		$submit=$this->input->post('submit');
		$no_distribusi=$this->input->post('no_distribusi');
		$tgl_distribusi=$this->input->post('tgl_distribusi');
		$kd_lokasi_asal=$this->input->post('kd_lokasi_asal');
		$nama_lokasi_asal=$this->input->post('nama_lokasi_asal');
		$kd_lokasi_tujuan=$this->input->post('kd_lokasi_tujuan');
		$keterangan=$this->input->post('keterangan');
		$status_distribusi=$this->input->post('status_distribusi');
		$kd_user=$this->input->post('kd_user');
		
		$no_ro=$this->input->post('no_ro');
		$kd_barang=$this->input->post('kd_barang');
		$nama_barang=$this->input->post('nama_barang');
		$satuan=$this->input->post('satuan');
		$jml_req=$this->input->post('jml_req');
		$jml_distribusi=$this->input->post('jml_distribusi');
		$jml_stok=$this->input->post('jml_stok');
		
		$msg['no_distribusi']=$no_distribusi;
		
		if($submit=="tutuptrans"){
			if(empty($no_distribusi))return false;
			$updatedistribusi=array('status_distribusi'=>1);
			$this->mdistribusi->update('log_distribusi',$updatedistribusi,'no_distribusi="'.$no_distribusi.'"');
			
			if(!empty($kd_barang)){
				foreach ($kd_barang as $key => $value){
					if(empty($value))continue;
					
					$urut=$this->mdistribusi->ambilUrutrequest($no_ro[$key],$value);
					$dataa=array('jml_distribusi'=>$jml_distribusi[$key]);
					$this->mdistribusi->update('log_request_order_det',$dataa,'no_ro="'.$no_ro[$key].'" and urut_request="'.$urut.'" and kd_barang="'.$value.'"');			
					
					//ngecek stok barang di tabel stok sesuai dgn kd_barang+kd_lokasi asal
					if($this->mdistribusi->cekStok($value,$kd_lokasi_tujuan)){ //kalo ada
						$jml_stok_asal=$this->mdistribusi->ambilStokAsal($kd_lokasi_asal,$value);
						$sisastokasal=$jml_stok_asal-$jml_distribusi[$key];
						$datastokasal=array('jml_stok'=>$sisastokasal);
						$this->mdistribusi->update('log_stok_barang',$datastokasal,'kd_lokasi="'.$kd_lokasi_asal.'" and kd_barang="'.$value.'"');					
						
						$jml_stok_tujuan=$this->mdistribusi->ambilStokTujuan($kd_lokasi_tujuan,$value);						
						$sisastoktujuan=$jml_stok_tujuan+$jml_distribusi[$key];						
						$datastoktujuan=array('jml_stok'=>$sisastoktujuan);						
						$this->mdistribusi->update('log_stok_barang',$datastoktujuan,'kd_lokasi="'.$kd_lokasi_tujuan.'" and kd_barang="'.$value.'"');
					}
					else{ //kalo ga ada
						$data1=array('kd_barang'=>$value,'kd_lokasi'=>$kd_lokasi_tujuan,'jml_stok'=>$jml_distribusi[$key]);
						$this->mdistribusi->insert('log_stok_barang',$data1);
						
						$jml_stok_asal=$this->mdistribusi->ambilStokAsal($kd_lokasi_asal,$value);
						$sisastokasal=$jml_stok_asal-$jml_distribusi[$key];
						$datastokasal=array('jml_stok'=>$sisastokasal);
						$this->mdistribusi->update('log_stok_barang',$datastokasal,'kd_lokasi="'.$kd_lokasi_asal.'" and kd_barang="'.$value.'"');
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
			if(empty($no_distribusi))return false;
			$updatedistribusi=array('status_distribusi'=>0);
			$this->mdistribusi->update('log_distribusi',$updatedistribusi,'no_distribusi="'.$no_distribusi.'"');
			
			if(!empty($kd_barang)){
				foreach ($kd_barang as $key => $value){
					if(empty($value))continue;					
					if($no_ro[$key]!=''){			
						//untuk ngembaliin jml_pembelian awal di log_requestny
						$urut=$this->mdistribusi->ambilUrutrequest($no_ro[$key],$value);
						$jml_distribusiawal=$this->mdistribusi->jumdistribusiawal($no_ro[$key],$value);
						$jumbalik=$jml_distribusiawal-$jml_distribusi[$key];
						$dataa=array('jml_distribusi'=>$jumbalik);
						$this->mdistribusi->update('log_request_order_det',$dataa,'no_ro="'.$no_ro[$key].'" and urut_request="'.$urut.'" and kd_barang="'.$value.'"');			
					}
				}
			}
			
			$items=$this->mdistribusi->getAllDetailDistribusi($no_distribusi);
			foreach($items as $itemdetil){
				$kode=$itemdetil['kd_barang'];
				$kiteye=$itemdetil['jml_distribusi'];
				
				//ngembaliin stok ke unit asal/nambah
				$stokawalasal=$this->mdistribusi->ambilStokAsal($kd_lokasi_asal,$kode); 
				$stokakhirasal=$kiteye+$stokawalasal;
				$datastokasal=array('jml_stok'=>$stokakhirasal);
				$this->mdistribusi->update('log_stok_barang',$datastokasal,'kd_lokasi="'.$kd_lokasi_asal.'" and kd_barang="'.$kode.'"');
				
				//ngurangin stok di unit tujuan
				$stokawaltujuan=$this->mdistribusi->ambilStokTujuan($kd_lokasi_tujuan,$kode); 
				$stokakhirtujuan=$stokawaltujuan-$kiteye;
				$datastoktujuan=array('jml_stok'=>$stokakhirtujuan);
				$this->mdistribusi->update('log_stok_barang',$datastoktujuan,'kd_lokasi="'.$kd_lokasi_tujuan.'" and kd_barang="'.$kode.'"');
			}
			
			$msg['status']=1;
			$msg['posting']=2;
			$msg['pesan']="Buka Transksi Berhasil";
			echo json_encode($msg);
			return false;
		}

		if($this->mdistribusi->isNumberExist($no_distribusi)){ //edit
		    $datadistribusiedit=array('tgl_distribusi'=>convertDate($tgl_distribusi),'kd_lokasi_asal'=>$kd_lokasi_asal,
										'kd_lokasi_tujuan'=>$kd_lokasi_tujuan,'keterangan'=>$keterangan,'status_distribusi'=>$status_distribusi,
										'kd_user'=>$kd_user);
				
			$this->mdistribusi->update('log_distribusi',$datadistribusiedit,'no_distribusi="'.$no_distribusi.'"');
			$urut_distribusi=1;
			$urut_request=1;
			
			/*$items=$this->mdistribusi->getAllDetailDistribusi($no_distribusi);
			foreach($items as $itemdetil){
				$kode=$itemdetil['kd_barang'];
				$kiteye=$itemdetil['jml_distribusi'];
				
				//ngembaliin stok ke unit asal/nambah
				$stokawalasal=$this->mdistribusi->ambilStokAsal($kd_lokasi_asal,$kode); 
				$stokakhirasal=$kiteye+$stokawalasal;
				$datastokasal=array('jml_stok'=>$stokakhirasal);
				$this->mdistribusi->update('log_stok_barang',$datastokasal,'kd_lokasi="'.$kd_lokasi_asal.'" and kd_barang="'.$kode.'"');
				
				//ngurangin stok di unit tujuan
				$stokawaltujuan=$this->mdistribusi->ambilStokTujuan($kd_lokasi_tujuan,$kode); 
				$stokakhirtujuan=$stokawaltujuan-$kiteye;
				$datastoktujuan=array('jml_stok'=>$stokakhirtujuan);
				$this->mdistribusi->update('log_stok_barang',$datastoktujuan,'kd_lokasi="'.$kd_lokasi_tujuan.'" and kd_barang="'.$kode.'"');
			}*/
			
			$this->mdistribusi->delete('log_distribusi_det','no_distribusi="'.$no_distribusi.'"');
			
			if(!empty($kd_barang)){
				foreach ($kd_barang as $key => $value){
					if(empty($value))continue;
					
					$datadetil=array('no_distribusi'=>$no_distribusi,
									'urut_distribusi'=>$urut_distribusi,
									'no_ro'=>$no_ro[$key],
									'urut_request'=>$urut_request,
									'kd_barang'=>$value,
									'jml_distribusi'=>$jml_distribusi[$key]);
					$this->mdistribusi->insert('log_distribusi_det',$datadetil);	
					
					//ngecek stok barang di tabel stok sesuai dgn kd_barang+kd_lokasi asal
					/*if($this->mdistribusi->cekStok($value,$kd_lokasi_tujuan)){ //kalo ada
						$jml_stok_asal=$this->mdistribusi->ambilStokAsal($kd_lokasi_asal,$value);
						$sisastokasal=$jml_stok_asal-$jml_distribusi[$key];
						$datastokasal=array('jml_stok'=>$sisastokasal);
						$this->mdistribusi->update('log_stok_barang',$datastokasal,'kd_lokasi="'.$kd_lokasi_asal.'" and kd_barang="'.$value.'"');					
						
						$jml_stok_tujuan=$this->mdistribusi->ambilStokTujuan($kd_lokasi_tujuan,$value);						
						$sisastoktujuan=$jml_stok_tujuan+$jml_distribusi[$key];						
						$datastoktujuan=array('jml_stok'=>$sisastoktujuan);						
						$this->mdistribusi->update('log_stok_barang',$datastoktujuan,'kd_lokasi="'.$kd_lokasi_tujuan.'" and kd_barang="'.$value.'"');
					}
					else{ //kalo ga ada
						$data1=array('kd_barang'=>$value,'kd_lokasi'=>$kd_lokasi_tujuan,'jml_stok'=>$jml_distribusi[$key]);
						$this->mdistribusi->insert('log_stok_barang',$data1);
						
						$jml_stok_asal=$this->mdistribusi->ambilStokAsal($kd_lokasi_asal,$value);
						$sisastokasal=$jml_stok_asal-$jml_distribusi[$key];
						$datastokasal=array('jml_stok'=>$sisastokasal);
						$this->mdistribusi->update('log_stok_barang',$datastokasal,'kd_lokasi="'.$kd_lokasi_asal.'" and kd_barang="'.$value.'"');
					}				
					
					$urut=$this->mdistribusi->ambilUrutrequest($no_ro[$key],$value);
					$dataa=array('jml_distribusi'=>$jml_distribusi[$key]);
					$this->mdistribusi->update('log_request_order_det',$dataa,'no_ro="'.$no_ro[$key].'" and urut_request="'.$urut.'" and kd_barang="'.$value.'"');*/
					
					$urut_distribusi++;
					$urut_request++;
				}
			}
			$msg['pesan']="Data Berhasil Di Update";
		}
		else { //simpan baru			
			$tanggal=date('d-m-Y');
			$tgl=explode("-", $tanggal);
			$kode=$this->mdistribusi->autoNumber($tgl[2],$tgl[1]);
			$kodebaru=$kode+1;
			$kodebaru=str_pad($kodebaru,4,0,STR_PAD_LEFT); 
			$no_distribusi="DIST.".substr($tgl[2],2,2)."".$tgl[1].".".$kodebaru;
			$msg['no_distribusi']=$no_distribusi;
			
			$datadistribusi=array('no_distribusi'=>$no_distribusi,'tgl_distribusi'=>convertDate($tgl_distribusi),
				'kd_lokasi_asal'=>$kd_lokasi_asal,'kd_lokasi_tujuan'=>$kd_lokasi_tujuan,'keterangan'=>$keterangan,
				'status_distribusi'=>$status_distribusi,'kd_user'=>$kd_user);
			
			$this->mdistribusi->insert('log_distribusi',$datadistribusi);
			$urut_distribusi=1;
			$urut_request=1;
			if(!empty($kd_barang)){
				foreach ($kd_barang as $key => $value){
					# code...
					if(empty($value))continue;
					
					$datadetil=array('no_distribusi'=>$no_distribusi,
									'urut_distribusi'=>$urut_distribusi,
									'no_ro'=>$no_ro[$key],
									'urut_request'=>$urut_request,
									'kd_barang'=>$value,
									'jml_distribusi'=>$jml_distribusi[$key]);
					$this->mdistribusi->insert('log_distribusi_det',$datadetil);				
					
					//ngecek stok barang di tabel stok sesuai dgn kd_barang+kd_lokasi asal
					/*if($this->mdistribusi->cekStok($value,$kd_lokasi_tujuan)){ //kalo ada
						$jml_stok_asal=$this->mdistribusi->ambilStokAsal($kd_lokasi_asal,$value);
						$sisastokasal=$jml_stok_asal-$jml_distribusi[$key];
						$datastokasal=array('jml_stok'=>$sisastokasal);
						$this->mdistribusi->update('log_stok_barang',$datastokasal,'kd_lokasi="'.$kd_lokasi_asal.'" and kd_barang="'.$value.'"');					
						
						$jml_stok_tujuan=$this->mdistribusi->ambilStokTujuan($kd_lokasi_tujuan,$value);						
						$sisastoktujuan=$jml_stok_tujuan+$jml_distribusi[$key];						
						$datastoktujuan=array('jml_stok'=>$sisastoktujuan);						
						$this->mdistribusi->update('log_stok_barang',$datastoktujuan,'kd_lokasi="'.$kd_lokasi_tujuan.'" and kd_barang="'.$value.'"');
					}
					else{ //kalo ga ada
						$data1=array('kd_barang'=>$value,'kd_lokasi'=>$kd_lokasi_tujuan,'jml_stok'=>$jml_distribusi[$key]);
						$this->mdistribusi->insert('log_stok_barang',$data1);
						
						$jml_stok_asal=$this->mdistribusi->ambilStokAsal($kd_lokasi_asal,$value);
						$sisastokasal=$jml_stok_asal-$jml_distribusi[$key];
						$datastokasal=array('jml_stok'=>$sisastokasal);
						$this->mdistribusi->update('log_stok_barang',$datastokasal,'kd_lokasi="'.$kd_lokasi_asal.'" and kd_barang="'.$value.'"');
					}	
					
					$urut=$this->mdistribusi->ambilUrutrequest($no_ro[$key],$value);
					$dataa=array('jml_distribusi'=>$jml_distribusi[$key]);
					$this->mdistribusi->update('log_request_order_det',$dataa,'no_ro="'.$no_ro[$key].'" and urut_request="'.$urut.'" and kd_barang="'.$value.'"');			*/
					
					$urut_distribusi++;
					$urut_request++;
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

	public function hapusdistribusi($no_distribusi=""){
		$msg=array();
		$error=0;
		if(empty($no_distribusi)){
			$msg['pesan']="Pilih Transaksi yang akan di hapus";
			echo "<script>Alert('".$msg['pesan']."')</script>";
		}else{
			$kd_lokasi_asal=$this->mdistribusi->ambilKodeLokasiAsal($no_distribusi);
			$kd_lokasi_tujuan=$this->mdistribusi->ambilKodeLokasiTujuan($no_distribusi);
			$items=$this->mdistribusi->getAllDetailDistribusi($no_distribusi);
			foreach($items as $itemdetil){
				$kode=$itemdetil['kd_barang'];
				$kiteye=$itemdetil['jml_distribusi'];
				$no_ro=$itemdetil['no_ro'];
				
				//update stok di unit asal-->nambah
				$stokawalasal=$this->mdistribusi->ambilStokAsal($kd_lokasi_asal,$kode); 
				$stokakhirasal=$kiteye+$stokawalasal;
				$datastokasal=array('jml_stok'=>$stokakhirasal);
				$this->mdistribusi->update('log_stok_barang',$datastokasal,'kd_lokasi="'.$kd_lokasi_asal.'" and kd_barang="'.$kode.'"');
				
				//update stok di unit tujuan-->berkurang
				$stokawaltujuan=$this->mdistribusi->ambilStokTujuan($kd_lokasi_tujuan,$kode); 
				$stokakhirtujuan=$stokawaltujuan-$kiteye;
				$datastoktujuan=array('jml_stok'=>$stokakhirtujuan);
				$this->mdistribusi->update('log_stok_barang',$datastoktujuan,'kd_lokasi="'.$kd_lokasi_tujuan.'" and kd_barang="'.$kode.'"');				
			}		
			$this->mdistribusi->delete('log_distribusi','no_distribusi="'.$no_distribusi.'"');
			$this->mdistribusi->delete('log_distribusi_det','no_distribusi="'.$no_distribusi.'"');	
			redirect('/log_transaksi/distribusi/');
		}
	}
	
	public function ambillokasitujuan()
	{
		$q=$this->input->get('query');
		$items=$this->mdistribusi->ambilDataTujuan($q);
		echo json_encode($items);
	}
	
	public function periksadistribusi() {
		$msg=array();
		$submit=$this->input->post('submit');
		$no_distribusi=$this->input->post('no_distribusi');
		$tgl_distribusi=$this->input->post('tgl_distribusi');
		//$kd_lokasi_asal=$this->input->post('kd_lokasi_asal');
		$kd_lokasi_asal=$this->session->userdata('kd_lokasi');
		$nama_lokasi_asal=$this->input->post('nama_lokasi_asal');
		$kd_lokasi_tujuan=$this->input->post('kd_lokasi_tujuan');
		$keterangan=$this->input->post('keterangan');
		$status_distribusi=$this->input->post('status_distribusi');
		$kd_user=$this->input->post('kd_user');
		
		$no_ro=$this->input->post('no_ro');
		$kd_barang=$this->input->post('kd_barang');
		$nama_barang=$this->input->post('nama_barang');
		$satuan=$this->input->post('satuan');
		$jml_req=$this->input->post('jml_req');
		$jml_distribusi=$this->input->post('jml_distribusi');		
		$jml_stok=$this->input->post('jml_stok');		
		
		$jumlaherror=0;
		$msg['status']=1;
		$msg['clearform']=0;
		$msg['pesanatas']="";
		$msg['pesanlain']="";
		
		if($submit=="hapus"){
			if(empty($no_distribusi)){
				$msg['pesanatas']="Pilih Transaksi yang akan di hapus";
			}else{
				$this->mdistribusi->delete('log_distribusi','no_distribusi="'.$no_distribusi.'"');
				$this->mdistribusi->delete('log_distribusi_det','no_distribusi="'.$no_distribusi.'"');
				$msg['pesanatas']="Data Berhasil Di Hapus";
			}
			$msg['status']=0;
			$msg['clearform']=1;
			echo json_encode($msg);
		}
		else if($submit=="tutuptrans" or $submit=="bukatrans"){}
		else{
			if(empty($tgl_distribusi)){
				$jumlaherror++;
				$msg['id'][]="tgl_distribusi";
				$msg['pesan'][]="Kolom Tanggal Harus di Isi";
			}
			
			if(!empty($kd_barang)){
				foreach ($kd_barang as $key => $value) {
					# code...
					if(empty($value))continue;
					if(empty($jml_distribusi[$key])){
						$msg['status']=0;
						$nama=$this->mdistribusi->ambilNama($value);
						$msg['pesanlain'].="Jml.Distribusi ".$nama." Tidak boleh Kosong <br/>";					
					}						
					if($jml_distribusi[$key]>$jml_stok[$key]){
						$msg['status']=0;
						$nama=$this->mdistribusi->ambilNama($value);
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
		$items1=$this->mdistribusi->getDistribusi1($q);
		$items2=$this->mdistribusi->getDistribusi2($q);
		$items=array_merge($items1,$items2);
		echo json_encode($items);
	}
	
	public function ambilitems()
	{
		$q=$this->input->get('query');
		$items=$this->mdistribusi->getAllDetailDistribusi($q);

		echo json_encode($items);
	}

	public function ambildaftarbarangbynama() {
		$q=$this->input->get('query'); //nama barang
		$tes=$this->input->get('tes'); //kd_lokasi tujuan
		$dor=$this->input->get('dor'); //kd_lokasi asal
		$items=$this->mdistribusi->ambilData2($tes,$q,$dor);
		echo json_encode($items);
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */