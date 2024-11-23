<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

include_once(APPPATH.'controllers/rumahsakit.php');
//class Aptdistribusi extends CI_Controller {
class Aptdistribusi extends Rumahsakit {

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
		$this->load->model('apotek/mdistribusiapt');
		$kd_unit_apt=$this->session->userdata('kd_unit_apt');
		
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
	
	public function index()	{
		if(!$this->muser->isAkses("49")){
			$this->restricted();
			return false;
		}
		
		$no_distribusi='';
		$kd_unit_apt='';
		$periodeawal=date('d-m-Y');
		$periodeakhir=date('d-m-Y');
		
		if($this->input->post('no_distribusi')!=''){
			$no_distribusi=$this->input->post('no_distribusi');
		}
		if($this->input->post('kd_unit_apt')!=''){
			$kd_unit_apt=$this->input->post('kd_unit_apt');
		}
		if($this->input->post('periodeawal')!=''){
			$periodeawal=$this->input->post('periodeawal');
		}
		if($this->input->post('periodeakhir')!=''){
			$periodeakhir=$this->input->post('periodeakhir');
		}
		
		$cssfileheader=array('bootstrap.css','bootstrap-responsive.min.css','font-awesome.min.css','style.css','prettify.css','jquery-ui.css','DT_bootstrap.css','responsive-tables.css','datepicker.css','theme.css');
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
					'kd_unit_apt'=>$kd_unit_apt,
					'periodeawal'=>$periodeawal,
					'periodeakhir'=>$periodeakhir,
					'items'=>$this->mdistribusiapt->ambilDataDistribusi($no_distribusi,$kd_unit_apt,$periodeawal,$periodeakhir));
		$this->load->view('headerapotek',$dataheader);
		$this->load->view('apotek/transaksi/distribusi/aptdistribusi',$data);
		$this->load->view('footer',$datafooter);
	}
		
	public function tambahdistribusiapt(){
		if(!$this->muser->isAkses("50")){
			$this->restricted();
			return false;
		}
		
		$kode=""; $no_distribusi=""; $kd_applogin="";
		
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
		
		$kode=$this->mdistribusiapt->autoNumber(date('Y'),date('m'));
		$kodebaru=$kode+1;
		$kodebaru=str_pad($kodebaru,5,0,STR_PAD_LEFT); 
		$no_distribusi="D.".date('Y').".".date('m').".".$kodebaru;
		$kd_applogin=$this->mdistribusiapt->ambilApp();
		$data=array('no_distribusi'=>'',	
					'dataunitasal'=>$this->mdistribusiapt->ambilData('apt_unit'),
					'dataunittujuan'=>$this->mdistribusiapt->ambilDataTujuan('apt_unit'),
					'itemsdetiltransaksi'=>$this->mdistribusiapt->getAllDetailDistribusi($no_distribusi),
					//'itemtransaksi'=>$this->mdistribusiapt->ambilItemData('apt_distribusi','no_distribusi="'.$no_distribusi.'"'),
					'itemtransaksi'=>$this->mdistribusiapt->ItemDistribusi($no_distribusi),
					'items'=>$this->mdistribusiapt->ambilDataDistribusi('','','',''),
					'kd_applogin'=>$kd_applogin);
		
		$this->load->view('headerapotek',$dataheader);
		$this->load->view('apotek/transaksi/distribusi/tambahdistribusiapt',$data);
		$this->load->view('footer',$datafooter);	
	}
	
	public function ubahdistribusi($no_distribusi=""){
		if(!$this->muser->isAkses("51")){
			$this->restricted();
			return false;
		}
		
		$kd_applogin="";
		
		if(empty($no_distribusi))return false;
		
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
							'lib/bootstrap-timepicker.js',
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
		
		$kd_applogin=$this->mdistribusiapt->ambilApp();
		$data=array(
			'dataunitasal'=>$this->mdistribusiapt->ambilData('apt_unit'),
			'dataunittujuan'=>$this->mdistribusiapt->ambilDataTujuan('apt_unit'),
			'no_distribusi'=>$no_distribusi,
			//'itemtransaksi'=>$this->mdistribusiapt->ambilItemData('apt_distribusi','no_distribusi="'.$no_distribusi.'"'),
			'itemtransaksi'=>$this->mdistribusiapt->ItemDistribusi($no_distribusi),
			'itemsdetiltransaksi'=>$this->mdistribusiapt->getAllDetailDistribusi($no_distribusi),
			'items'=>$this->mdistribusiapt->ambilDataDistribusi('','','',''),
			'kd_applogin'=>$kd_applogin
		);
		
		$this->load->view('headerapotek',$dataheader);
		$this->load->view('apotek/transaksi/distribusi/tambahdistribusiapt',$data);
		$this->load->view('footer',$datafooter);
	}
	
	public function simpandistribusi(){
		//debugvar('masuk');
		$msg=array();
		$submit=$this->input->post('submit');
		$no_distribusi=$this->input->post('no_distribusi');
		$no_distribusi1=$this->input->post('no_distribusi1');
		$shift=$this->input->post('shift');
		$tgl_distribusi=$this->input->post('tgl_distribusi');
		$posting=$this->input->post('posting');
		$kd_unit_asal=$this->input->post('kd_unit_asal');
		$nama_unit_asal=$this->input->post('nama_unit_asal');
		$kd_unit_tujuan=$this->input->post('kd_unit_tujuan');
		//$kd_user=$this->input->post('kd_user');
		
		$jam_distribusi=$this->input->post('jam_distribusi');
		$jam_distribusi1=$this->input->post('jam_distribusi1');
		
		$no_permintaan=$this->input->post('no_permintaan');
		$kd_obat=$this->input->post('kd_obat');
		$nama_obat=$this->input->post('nama_obat');
		$satuan_kecil=$this->input->post('satuan_kecil');
		$tgl_expire=$this->input->post('tgl_expire');
		$qty=$this->input->post('qty');
		$tgl_entry=$this->input->post('tgl_entry');
		$kd_milik="01";
		$shift="1";
		
		$alasan=$this->input->post('alasan');
		$tgl_log=$this->input->post('tgl_log');
		$jam_log=$this->input->post('jam_log');
		
		$tgl_history=$tgl_log." ".$jam_log;
		
		$kd_user=$this->session->userdata('id_user'); 
		$msg['no_distribusi']=$no_distribusi;
		$msg['posting']=0;

		$this->db->trans_start();

		if($submit=="tutuptrans"){
			/*$jamhis=date('h:i:s');
			$tglhis=date('Y-m-d');
			$waktu_history=$tglhis." ".$jam_distribusi;
			debugvar($waktu_history);
			$kode=$this->mdistribusiapt->nomor();
			$nomor=$kode+1;
			$datalogtutup=array('nomor'=>$nomor,
						//'tgl'=>$tgl_history,
						'tgl'=>$waktu_history,
						'no_distribusi'=>$no_distribusi,
						//'alasan'=>$alasan,
						'alasan'=>'-',
						'kd_user'=>$kd_user,
						'jenis'=>"T");
			//debugvar($datalogtutup);
			$this->mdistribusiapt->insert('apt_log_distribusi',$datalogtutup);*/
			
			if(empty($no_distribusi))return false;
			$updatedistribusi=array('posting'=>1);
			$this->mdistribusiapt->update('apt_distribusi',$updatedistribusi,'no_distribusi="'.$no_distribusi.'"');
			
			if(!empty($kd_obat)){
				foreach ($kd_obat as $key => $value){
					if(empty($value))continue;
					if($no_permintaan[$key]!=''){
						$urut=$this->mdistribusiapt->ambilUrutrequest($no_permintaan[$key],$value,$tgl_expire[$key]);
						$dataa=array('jml_distribusi'=>$qty[$key]);
						$this->mdistribusiapt->update('apt_permintaan_obat_det',$dataa,'no_permintaan="'.$no_permintaan[$key].'" and urut="'.$urut.'" and kd_obat="'.$value.'" and tgl_expire="'.convertDate($tgl_expire[$key]).'"');
					}
					$tglexpire=convertDate($tgl_expire[$key]);
					if($this->mdistribusiapt->cekStok($value,$kd_unit_tujuan,$tglexpire)){ 
						$jml_stok_asal=$this->mdistribusiapt->ambilStokAsal($kd_unit_asal,$value,$tglexpire);
						$sisastokasal=$jml_stok_asal-$qty[$key];
						$datastokasal=array('jml_stok'=>$sisastokasal);
						$this->mdistribusiapt->update('apt_stok_unit',$datastokasal,'kd_unit_apt="'.$kd_unit_asal.'" and kd_obat="'.$value.'" and tgl_expire="'.$tglexpire.'"');					
						
						$jml_stok_tujuan=$this->mdistribusiapt->ambilStokTujuan($kd_unit_tujuan,$value,$tglexpire);						
						$sisastoktujuan=$jml_stok_tujuan+$qty[$key];						
						$datastoktujuan=array('tgl_expire'=>convertDate($tgl_expire[$key]),'jml_stok'=>$sisastoktujuan);						
						$this->mdistribusiapt->update('apt_stok_unit',$datastoktujuan,'kd_unit_apt="'.$kd_unit_tujuan.'" and kd_obat="'.$value.'" and tgl_expire="'.$tglexpire.'"');
					}
					else{
						$harga_pokok=$this->mdistribusiapt->ambilItemData3($kd_unit_asal,$value);
						$data1=array('kd_unit_apt'=>$kd_unit_tujuan,'kd_obat'=>$value,'kd_milik'=>$kd_milik,'tgl_expire'=>convertDate($tgl_expire[$key]),'harga_pokok'=>$harga_pokok,'jml_stok'=>$qty[$key]);
						$this->mdistribusiapt->insert('apt_stok_unit',$data1);
						
						$jml_stok_asal=$this->mdistribusiapt->ambilStokAsal($kd_unit_asal,$value,$tglexpire);
						$sisastokasal=$jml_stok_asal-$qty[$key];
						$datastokasal=array('jml_stok'=>$sisastokasal);
						$this->mdistribusiapt->update('apt_stok_unit',$datastokasal,'kd_unit_apt="'.$kd_unit_asal.'" and kd_obat="'.$value.'" and tgl_expire="'.$tglexpire.'"');
					}
				}
			}
			
			$items=$this->mdistribusiapt->ambilnomorpermintaan($no_distribusi);
			foreach($items as $itemdetil){
				$nomornya=$itemdetil['no_permintaan'];
				if($nomornya!=''){
					$sumreq=$this->mdistribusiapt->ambilsumreq($nomornya);
					$sumdistribusi=$this->mdistribusiapt->ambilsumdis($nomornya);
					if($sumdistribusi>=$sumreq){
						$datab=array('permintaan_status'=>1);
						$this->mdistribusiapt->update('apt_permintaan_obat',$datab,'no_permintaan="'.$nomornya.'"');
					}					
				}
			}
			
			$this->db->trans_complete();
			$msg['status']=1;
			$msg['posting']=1;
			$msg['pesan']="Tutup Transksi Berhasil";
			echo json_encode($msg);
			return false;
		}
		if($submit=="bukatrans"){
		//if($submit=="simpanbuka"){
			/*$kode=$this->mdistribusiapt->nomor();
			$nomor=$kode+1;
			$datalogbuka=array('nomor'=>$nomor,
						'tgl'=>$tgl_history,
						'no_distribusi'=>$no_distribusi,
						'alasan'=>$alasan,
						'kd_user'=>$kd_user,
						'jenis'=>"B");
			debugvar($datalogbuka);
			$this->mdistribusiapt->insert('apt_log_distribusi',$datalogbuka);*/
			
			if(empty($no_distribusi))return false;
			$updatedistribusi=array('posting'=>0);
			$this->mdistribusiapt->update('apt_distribusi',$updatedistribusi,'no_distribusi="'.$no_distribusi.'"');
			
			$items=$this->mdistribusiapt->getAllDetailDistribusi($no_distribusi);
			foreach($items as $itemdetil){
				$kode=$itemdetil['kdobat'];
				$kiteye=$itemdetil['qty'];
				$tglexpire=$itemdetil['tglexpire'];
				$nomor=$itemdetil['no_permintaan'];
				
				if($nomor!=''){			
					$urut=$this->mdistribusiapt->ambilUrutrequest1($nomor,$kode,$tglexpire);
					$jml_distribusiawal=$this->mdistribusiapt->jumdistribusiawal($nomor,$kode,$tglexpire);
					$jumbalik=$jml_distribusiawal-$kiteye;
					$dataa=array('jml_distribusi'=>$jumbalik);
					$this->mdistribusiapt->update('apt_permintaan_obat_det',$dataa,'no_permintaan="'.$nomor.'" and urut="'.$urut.'" and kd_obat="'.$kode.'" and tgl_expire="'.$tglexpire.'"');			
				}
				
				//ngembaliin stok ke unit asal/nambah
				$stokawalasal=$this->mdistribusiapt->ambilStokAsal($kd_unit_asal,$kode,$tglexpire); 
				$stokakhirasal=$kiteye+$stokawalasal;
				$datastokasal=array('jml_stok'=>$stokakhirasal);
				$this->mdistribusiapt->update('apt_stok_unit',$datastokasal,'kd_unit_apt="'.$kd_unit_asal.'" and kd_obat="'.$kode.'" and tgl_expire="'.$tglexpire.'"');
				
				//ngurangin stok di unit tujuan
				$stokawaltujuan=$this->mdistribusiapt->ambilStokTujuan($kd_unit_tujuan,$kode,$tglexpire); 
				$stokakhirtujuan=$stokawaltujuan-$kiteye;
				$datastoktujuan=array('jml_stok'=>$stokakhirtujuan);
				$this->mdistribusiapt->update('apt_stok_unit',$datastoktujuan,'kd_unit_apt="'.$kd_unit_tujuan.'" and kd_obat="'.$kode.'" and tgl_expire="'.$tglexpire.'"');
			}
			
			$itemsa=$this->mdistribusiapt->ambilnomorpermintaan($no_distribusi);
			foreach($itemsa as $itemdetila){
				$nomornya=$itemdetila['no_permintaan'];
				if($nomornya!=''){
					$sumreq=$this->mdistribusiapt->ambilsumreq($nomornya);
					$sumdistribusi=$this->mdistribusiapt->ambilsumdis($nomornya);
					if($sumdistribusi<$sumreq){
						$datab=array('permintaan_status'=>0);
						$this->mdistribusiapt->update('apt_permintaan_obat',$datab,'no_permintaan="'.$nomornya.'"');
					}					
				}
			}
			
			$this->db->trans_complete();
			$msg['status']=1;
			$msg['posting']=2;
			$msg['pesan']="Buka Transksi Berhasil";
			echo json_encode($msg);
			return false;
		}

		if($this->mdistribusiapt->isNumberExist($no_distribusi)){ //edit
			$tgl_distribusi1=convertDate($tgl_distribusi)." ".$jam_distribusi1;
		    $datadistribusiedit=array('shift'=>$shift,
										//'tgl_distribusi'=>convertDate($tgl_distribusi), 
										'tgl_distribusi'=>$tgl_distribusi1,
										'posting'=>$posting,
										'kd_unit_asal'=>$kd_unit_asal,
										'kd_unit_tujuan'=>$kd_unit_tujuan,
										'kd_user'=>$kd_user);				
			$this->mdistribusiapt->update('apt_distribusi',$datadistribusiedit,'no_distribusi="'.$no_distribusi.'"');
			$urut=1;
			$urut_od=1;
			$this->mdistribusiapt->delete('apt_distribusi_detail','no_distribusi="'.$no_distribusi.'"');
			
			if(!empty($kd_obat)){
				foreach ($kd_obat as $key => $value){
					if(empty($value))continue;
					$pembanding=$this->mdistribusiapt->ambilPembanding($value);
					$qty_box=$qty[$key]/$pembanding;
					
					if($no_permintaan[$key]==''){$urut_od='';}
					$datadetiledit=array('no_distribusi'=>$no_distribusi,
										'urut'=>$urut,
										'kd_obat'=>$value,
										'kd_milik'=>$kd_milik,
										'tgl_expire'=>convertDate($tgl_expire[$key]),
										'qty'=>$qty[$key],
										'qty_box'=>$qty_box,
										'pembanding'=>$pembanding,
										'tgl_entry'=>$tgl_entry,
										'no_permintaan'=>$no_permintaan[$key],
										'urut_od'=>$urut_od);
					$this->mdistribusiapt->insert('apt_distribusi_detail',$datadetiledit);
					$urut++;
					$urut_od++;
				}
			}
			$msg['pesan']="Data Berhasil Di Update";
		}
		else { //simpan baru
			$tgl=explode("-", $tgl_distribusi);
			$kode=$this->mdistribusiapt->autoNumber($tgl[2],$tgl[1]);
			$kodebaru=$kode+1;
			$kodebaru=str_pad($kodebaru,5,0,STR_PAD_LEFT); 
			$no_distribusi="D.".$tgl[2].".".$tgl[1].".".$kodebaru;
			$msg['no_distribusi']=$no_distribusi;
			$tgl_distribusi1=convertDate($tgl_distribusi)." ".$jam_distribusi;
			$datadistribusi=array('no_distribusi'=>$no_distribusi,
								'shift'=>$shift,
								//'tgl_distribusi'=>convertDate($tgl_distribusi),
								'tgl_distribusi'=>$tgl_distribusi1,
								'posting'=>$posting,
								'kd_unit_asal'=>$kd_unit_asal,
								'kd_unit_tujuan'=>$kd_unit_tujuan,
								'kd_user'=>$kd_user);
			
			$this->mdistribusiapt->insert('apt_distribusi',$datadistribusi);
			$urut=1;
			$urut_od=1;
			if(!empty($kd_obat)){
				foreach ($kd_obat as $key => $value){
					# code...
					if(empty($value))continue;
					$pembanding=$this->mdistribusiapt->ambilPembanding($value);
					$qty_box=$qty[$key]/$pembanding;
					if($no_permintaan[$key]==''){$urut_od='';}
					$datadetil=array('no_distribusi'=>$no_distribusi,
									'urut'=>$urut,
									'kd_obat'=>$value,
									'kd_milik'=>$kd_milik,
									'tgl_expire'=>convertDate($tgl_expire[$key]),
									'qty'=>$qty[$key],
									'qty_box'=>$qty_box,
									'pembanding'=>$pembanding,
									'tgl_entry'=>$tgl_entry,
									'no_permintaan'=>$no_permintaan[$key],
									'urut_od'=>$urut_od);
					$this->mdistribusiapt->insert('apt_distribusi_detail',$datadetil);													
					$urut++;
					$urut_od++;
				}
			}
			$msg['pesan']="Data Berhasil Di Simpan";
			$msg['posting']=3;
		}
		$msg['status']=1;
		$msg['keluar']=0;
		if($submit=="simpankeluar"){
			$msg['keluar']=1;
		}
		$this->db->trans_complete();
		echo json_encode($msg);
	}

	public function hapusdistribusi($no_distribusi=""){
		if(!$this->muser->isAkses("52")){
			$this->restricted();
			return false;
		}
		
		$msg=array();
		$error=0;
		if(empty($no_distribusi)){
			$msg['pesan']="Pilih Transaksi yang akan di hapus";
			echo "<script>Alert('".$msg['pesan']."')</script>";
		}else{			
			$this->db->trans_start();
			$this->mdistribusiapt->delete('apt_distribusi','no_distribusi="'.$no_distribusi.'"');
			$this->mdistribusiapt->delete('apt_distribusi_detail','no_distribusi="'.$no_distribusi.'"');	
			$this->db->trans_complete();
			redirect('/transapotek/aptdistribusi/');
		}
	}	
	
	public function ambildaftarobatbykode()	{
		$kd_obat=$this->input->post('kd_obat');
		$kd_unit_apt=$this->session->userdata('kd_unit_apt');		
		
		/*$this->datatables->select("apt_stok_unit.kd_obat,apt_obat.nama_obat,apt_satuan_kecil.satuan_kecil,date_format(apt_stok_unit.tgl_expire,'%d-%m-%Y') as tgl_expire,
		 substring_index(apt_stok_unit.jml_stok,'.',1) as jml_stok,'pilihan' as pilihan,ifnull(apt_setting_obat.min_stok,0) as min_stok,apt_obat.pembanding",false);*/
		 $this->datatables->select("apt_stok_unit.kd_obat as kd_obat1,apt_obat.nama_obat,apt_satuan_kecil.satuan_kecil,date_format(apt_stok_unit.tgl_expire,'%d-%m-%Y') as tgl_expire,
		 apt_stok_unit.jml_stok,'pilihan' as pilihan,(select if( count(kd_obat)>0, min_stok, 0) from apt_setting_obat where kd_obat=kd_obat1 and kd_unit_apt='$kd_unit_apt') as min_stok,apt_obat.pembanding",false);
		
		$this->datatables->from("apt_obat");
		$this->datatables->edit_column('pilihan', '<a class="btn" onclick=\'pilihobat("$1","$2","$3","$4","$5","$6","$7")\'>Pilih</a>','kd_obat1,apt_obat.nama_obat,apt_satuan_kecil.satuan_kecil,tgl_expire,
																																		apt_stok_unit.jml_stok,min_stok,apt_obat.pembanding');		
		if(!empty($kd_obat))$this->datatables->like('apt_obat.kd_obat',$kd_obat,'both');
		
		$this->datatables->where('apt_stok_unit.kd_unit_apt',$kd_unit_apt);
		$this->datatables->where('apt_stok_unit.jml_stok >','0');
		
		$this->datatables->join('apt_satuan_kecil','apt_obat.kd_satuan_kecil=apt_satuan_kecil.kd_satuan_kecil');
		$this->datatables->join('apt_stok_unit','apt_obat.kd_obat=apt_stok_unit.kd_obat');
		$this->datatables->join('apt_unit','apt_stok_unit.kd_unit_apt=apt_unit.kd_unit_apt');
		$results = $this->datatables->generate();
		echo ($results);
	}
	
	public function ambildaftarobatbynama()
	{
		$nama_obat=$this->input->post('nama_obat');
		$kd_unit_apt=$this->session->userdata('kd_unit_apt');		
		
		$this->datatables->select("apt_stok_unit.kd_obat as kd_obat1,apt_obat.nama_obat,apt_satuan_kecil.satuan_kecil,date_format(apt_stok_unit.tgl_expire,'%d-%m-%Y') as tgl_expire,
		 apt_stok_unit.jml_stok,'pilihan' as pilihan,(select if( count(kd_obat)>0, min_stok, 0) from apt_setting_obat where kd_obat=kd_obat1 and kd_unit_apt='$kd_unit_apt') as min_stok,apt_obat.pembanding",false);
		
		$this->datatables->from("apt_obat");
		$this->datatables->edit_column('pilihan', '<a class="btn" onclick=\'pilihobat("$1","$2","$3","$4","$5","$6","$7")\'>Pilih</a>','kd_obat1,apt_obat.nama_obat,apt_satuan_kecil.satuan_kecil,tgl_expire,
																																		apt_stok_unit.jml_stok,min_stok,apt_obat.pembanding');		
		if(!empty($nama_obat))$this->datatables->like('apt_obat.nama_obat',$nama_obat,'both');
		
		$this->datatables->where('apt_stok_unit.kd_unit_apt',$kd_unit_apt);
		$this->datatables->where('apt_stok_unit.jml_stok >','0');
		
		$this->datatables->join('apt_satuan_kecil','apt_obat.kd_satuan_kecil=apt_satuan_kecil.kd_satuan_kecil');
		$this->datatables->join('apt_stok_unit','apt_obat.kd_obat=apt_stok_unit.kd_obat');
		$this->datatables->join('apt_unit','apt_stok_unit.kd_unit_apt=apt_unit.kd_unit_apt');
		$results = $this->datatables->generate();
		echo ($results);
	}
	
	public function ambilunittujuan()
	{
		$q=$this->input->get('query');
		$items=$this->mdistribusiapt->ambilDataTujuan($q);
		echo json_encode($items);
	}
	
	public function periksadistribusi() {
		$msg=array();
		$submit=$this->input->post('submit');
		$no_distribusi=$this->input->post('no_distribusi');
		$shift=$this->input->post('shift');
		$tgl_distribusi=$this->input->post('tgl_distribusi');
		$posting=$this->input->post('posting');
		$kd_unit_asal=$this->input->post('kd_unit_asal');
		$nama_unit_asal=$this->input->post('nama_unit_asal');
		$kd_unit_tujuan=$this->input->post('kd_unit_tujuan');
		//$kd_user=$this->input->post('kd_user');
		
		$kd_obat=$this->input->post('kd_obat');
		$nama_obat=$this->input->post('nama_obat');
		$satuan_kecil=$this->input->post('satuan_kecil');
		$tgl_expire=$this->input->post('tgl_expire');
		$qty=$this->input->post('qty');
		$pembanding=$this->input->post('pembanding');
		$tgl_entry=$this->input->post('tgl_entry');
		$jml_stok=$this->input->post('jml_stok');

		$nilai=$this->mdistribusiapt->isPosted($no_distribusi);
		//debugvar($nilai);
		
		$jumlaherror=0;
		$msg['status']=1;
		$msg['clearform']=0;
		$msg['pesanatas']="";
		$msg['pesanlain']="";
		
		if($submit=="hapus"){
			if(empty($no_distribusi)){
				$msg['pesanatas']="Pilih Transaksi yang akan di hapus";
			}else{
				$this->mdistribusiapt->delete('apt_distribusi','no_distribusi="'.$no_distribusi.'"');
				$this->mdistribusiapt->delete('apt_distribusi_detail','no_distribusi="'.$no_distribusi.'"');
				$msg['pesanatas']="Data Berhasil Di Hapus";
			}
			$msg['status']=0;
			$msg['clearform']=1;
			echo json_encode($msg);
		}
		//else if($submit=="tutuptrans" or $submit=="bukatrans"){}
		else{
			if(empty($tgl_distribusi)){
				$jumlaherror++;
				$msg['id'][]="tgl_distribusi";
				$msg['pesan'][]="Kolom Tanggal Harus di Isi";
			}
			if(empty($kd_unit_tujuan)){
				$jumlaherror++;
				$msg['id'][]="kd_unit_tujuan";
				$msg['pesan'][]="Unit tujuan belum dipilih";
			}
			
			if(!empty($kd_obat)){
				foreach ($kd_obat as $key => $value) {
					# code...
					if(empty($value))continue;
					if(empty($qty[$key])){
						$msg['status']=0;
						$nama=$this->mdistribusiapt->ambilNama($value);
						$msg['pesanlain'].="Qty ".$nama." Tidak boleh Kosong <br/>";					
					}
					if($nilai!=1){
						if($qty[$key]>$jml_stok[$key]){
							$msg['status']=0;
							$nama=$this->mdistribusiapt->ambilNama($value);
							$msg['pesanlain'].="Stok ".$nama." tidak mencukupi <br/>";
						}
					}
				}
			}
			if($jumlaherror>0){
				$msg['status']=0;
				$msg['error']=$jumlaherror;
				//$msg['pesanatas']="Terdapat beberapa kesalahan input silahkan cek inputan anda";
				$msg['pesanatas']="Data masih ada yang kosong, silahkan cek inputan anda !";
			}
		}
		echo json_encode($msg);
	}
	
	public function ambildaftarpermintaan() {		
		$q=$this->input->get('query'); //no permintaan		
		$tes=$this->input->get('tes'); //kd_unit_tujuan		
		//$dor=$this->input->get('dor'); //kd_unit_asal		
		$items=$this->mdistribusiapt->ambilData2($q,$tes); // ngambil daftar request
		echo json_encode($items);
	}
	
	public function ambilitem()
	{
		$q=$this->input->get('query');
		$items1=$this->mdistribusiapt->getDistribusi1($q);
		$items2=$this->mdistribusiapt->getDistribusi2($q);
		$items=array_merge($items1,$items2);
		echo json_encode($items);
	}
	
	public function ambilitems()
	{
		$q=$this->input->get('query');
		$items=$this->mdistribusiapt->getAllDetailDistribusi($q);

		echo json_encode($items);
	}
	
	public function ambildetilpermintaan()
	{
		$q=$this->input->get('query');
		$q=rtrim($q, ",");
		//debugvar($q);
		$itemdetil=$this->mdistribusiapt->getdetilpermintaan($q);
		echo json_encode($itemdetil);
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
