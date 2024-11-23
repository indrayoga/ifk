<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

include_once(APPPATH.'controllers/rumahsakit.php');
//class Aptreturgudang extends CI_Controller {
class Aptreturgudang extends Rumahsakit {

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
		$this->load->model('apotek/mreturgudang');
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
		if(!$this->muser->isAkses("65")){
			$this->restricted();
			return false;
		}
		$no_retur='';
		$kd_unit_apt='';
		$periodeawal=date('d-m-Y');
		$periodeakhir=date('d-m-Y');
		
		if($this->input->post('no_retur')!=''){
			$no_retur=$this->input->post('no_retur');
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
		$data=array('no_retur'=>$no_retur,
					'kd_unit_apt'=>$kd_unit_apt,
					'periodeawal'=>$periodeawal,
					'periodeakhir'=>$periodeakhir,
					'items'=>$this->mreturgudang->ambilDataRetur($no_retur,$kd_unit_apt,$periodeawal,$periodeakhir));
		$this->load->view('headerapotek',$dataheader);
		$this->load->view('apotek/transaksi/returgudang/aptreturgudang',$data);
		$this->load->view('footer',$datafooter);
	}
		
	public function tambahreturgudang(){
		if(!$this->muser->isAkses("66")){
			$this->restricted();
			return false;
		}
		
		$kode=""; $no_retur=""; $kd_applogin="";
		
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
		
		/*$kode=$this->mreturgudang->autoNumber(date('Y'),date('m'));
		$kodebaru=$kode+1;
		$kodebaru=str_pad($kodebaru,5,0,STR_PAD_LEFT); 
		$no_retur="D.".date('Y').".".date('m').".".$kodebaru;*/
		$kd_applogin=$this->mreturgudang->ambilApp();
		$data=array('no_retur'=>'',
					'kd_applogin'=>$kd_applogin,
					'dataunitasal'=>$this->mreturgudang->ambilData('apt_unit'),
					'dataunittujuan'=>$this->mreturgudang->ambilDataTujuan('apt_unit'),
					'itemsdetiltransaksi'=>$this->mreturgudang->getAllDetailRetur($no_retur),
					'itemtransaksi'=>$this->mreturgudang->ambilItemData('apt_retur_gudang','no_retur="'.$no_retur.'"'),
					'items'=>$this->mreturgudang->ambilDataRetur('','','',''));
		
		$this->load->view('headerapotek',$dataheader);
		$this->load->view('apotek/transaksi/returgudang/tambahreturgudang',$data);
		$this->load->view('footer',$datafooter);	
	}
	
	public function ubahreturgudang($no_retur=""){
		if(!$this->muser->isAkses("67")){
			$this->restricted();
			return false;
		}
		$kd_applogin="";
		if(empty($no_retur))return false;
		
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
		$kd_applogin=$this->mreturgudang->ambilApp();
		$data=array(
			'dataunitasal'=>$this->mreturgudang->ambilData('apt_unit'),
			'dataunittujuan'=>$this->mreturgudang->ambilDataTujuan('apt_unit'),
			'no_retur'=>$no_retur,
			'kd_applogin'=>$kd_applogin,
			//'itemtransaksi'=>$this->mreturgudang->ambilItemData('apt_retur_gudang','no_retur="'.$no_retur.'"'),
			'itemtransaksi'=>$this->mreturgudang->ambilItemDataRetur($no_retur),
			'itemsdetiltransaksi'=>$this->mreturgudang->getAllDetailRetur($no_retur),
			'items'=>$this->mreturgudang->ambilDataRetur('','','','')	
		);
		
		$this->load->view('headerapotek',$dataheader);
		$this->load->view('apotek/transaksi/returgudang/tambahreturgudang',$data);
		$this->load->view('footer',$datafooter);
	}
	
	public function simpanreturgudang(){
		$msg=array();
		$submit=$this->input->post('submit');
		$no_retur=$this->input->post('no_retur');
		$shift=$this->input->post('shift');
		$tgl_retur=$this->input->post('tgl_retur');
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
		
		$alasan=$this->input->post('alasan');
		$tgl_log=$this->input->post('tgl_log');
		$jam_log=$this->input->post('jam_log');
		
		$jam_retur=$this->input->post('jam_retur');
		$jam_retur1=$this->input->post('jam_retur1');
		//$tgl_entry=$this->input->post('tgl_entry');
		$this->db->trans_start();

		$kd_milik="01";
		$shift="1";
		$kd_user=$this->session->userdata('id_user'); 
		$msg['no_retur']=$no_retur;
		$msg['posting']=0;
		
		$tgl_history=$tgl_log." ".$jam_log;
		
		if($submit=="tutuptrans"){
			/*$jamhis=date('h:i:s');
			$tglhis=date('Y-m-d');
			$waktu_history=$tglhis." ".$jam_penerimaan;
			//debugvar($waktu_history);
			$kode=$this->mreturgudang->nomor();
			$nomor=$kode+1;
			$datalogtutup=array('nomor'=>$nomor,
						//'tgl'=>$tgl_history,
						'tgl'=>$waktu_history,
						'no_retur'=>$no_retur,
						//'alasan'=>$alasan,
						'alasan'=>'-',
						'kd_user'=>$kd_user,
						'jenis'=>"T");
			//debugvar($datalogtutup);
			$this->mreturgudang->insert('apt_log_returgudang',$datalogtutup);*/
			
			if(empty($no_retur))return false;
			$updatedistribusi=array('posting'=>1);
			$this->mreturgudang->update('apt_retur_gudang',$updatedistribusi,'no_retur="'.$no_retur.'"');
			
			if(!empty($kd_obat)){
				foreach ($kd_obat as $key => $value){
					if(empty($value))continue;
					$tglexpire=convertDate($tgl_expire[$key]);
					if($this->mreturgudang->cekStok($value,$kd_unit_tujuan,$tglexpire)){ 
						$jml_stok_asal=$this->mreturgudang->ambilStokAsal($kd_unit_asal,$value,$tglexpire);
						$sisastokasal=$jml_stok_asal-$qty[$key];
						$datastokasal=array('jml_stok'=>$sisastokasal);
						$this->mreturgudang->update('apt_stok_unit',$datastokasal,'kd_unit_apt="'.$kd_unit_asal.'" and kd_obat="'.$value.'" and tgl_expire="'.$tglexpire.'"');					
						
						$jml_stok_tujuan=$this->mreturgudang->ambilStokTujuan($kd_unit_tujuan,$value,$tglexpire);						
						$sisastoktujuan=$jml_stok_tujuan+$qty[$key];						
						$datastoktujuan=array('tgl_expire'=>convertDate($tgl_expire[$key]),'jml_stok'=>$sisastoktujuan);						
						$this->mreturgudang->update('apt_stok_unit',$datastoktujuan,'kd_unit_apt="'.$kd_unit_tujuan.'" and kd_obat="'.$value.'" and tgl_expire="'.$tglexpire.'"');
					}
					else{
						$harga_pokok=$this->mreturgudang->ambilItemData3($kd_unit_asal,$value);
						$data1=array('kd_unit_apt'=>$kd_unit_tujuan,'kd_obat'=>$value,'kd_milik'=>$kd_milik,'tgl_expire'=>convertDate($tgl_expire[$key]),'harga_pokok'=>$harga_pokok,'jml_stok'=>$qty[$key]);
						$this->mreturgudang->insert('apt_stok_unit',$data1);
						
						$jml_stok_asal=$this->mreturgudang->ambilStokAsal($kd_unit_asal,$value,$tglexpire);
						$sisastokasal=$jml_stok_asal-$qty[$key];
						$datastokasal=array('jml_stok'=>$sisastokasal);
						$this->mreturgudang->update('apt_stok_unit',$datastokasal,'kd_unit_apt="'.$kd_unit_asal.'" and kd_obat="'.$value.'" and tgl_expire="'.$tglexpire.'"');
					}
				}
			}
			
			$msg['status']=1;
			$msg['posting']=1;
			$msg['pesan']="Tutup Transksi Berhasil";
			$this->db->trans_complete();
			echo json_encode($msg);
			return false;
		}
		if($submit=="bukatrans"){
		//if($submit=="simpanbuka"){
			/*$kode=$this->mreturgudang->nomor();
			$nomor=$kode+1;
			$datalogbuka=array('nomor'=>$nomor,
						'tgl'=>$tgl_history,
						'no_retur'=>$no_retur,
						'alasan'=>$alasan,
						'kd_user'=>$kd_user,
						'jenis'=>"B");
			$this->mreturgudang->insert('apt_log_returgudang',$datalogbuka);			*/
			
			if(empty($no_retur))return false;
			$updatedistribusi=array('posting'=>0);
			$this->mreturgudang->update('apt_retur_gudang',$updatedistribusi,'no_retur="'.$no_retur.'"');
			
			$items=$this->mreturgudang->getAllDetailRetur($no_retur);
			foreach($items as $itemdetil){
				$kode=$itemdetil['kdobat'];
				$kiteye=$itemdetil['qty'];
				$tglexpire=$itemdetil['tglexpire'];
				
				//ngembaliin stok ke unit asal/nambah
				$stokawalasal=$this->mreturgudang->ambilStokAsal($kd_unit_asal,$kode,$tglexpire); 
				$stokakhirasal=$kiteye+$stokawalasal;
				//$stokakhirasal=$stokawalasal-$kiteye;
				$datastokasal=array('jml_stok'=>$stokakhirasal);
				$this->mreturgudang->update('apt_stok_unit',$datastokasal,'kd_unit_apt="'.$kd_unit_asal.'" and kd_obat="'.$kode.'" and tgl_expire="'.$tglexpire.'"');
				
				//nambah stok di unit tujuan //kurang
				$stokawaltujuan=$this->mreturgudang->ambilStokTujuan($kd_unit_tujuan,$kode,$tglexpire); 
				$stokakhirtujuan=$stokawaltujuan-$kiteye;
				$datastoktujuan=array('jml_stok'=>$stokakhirtujuan);
				$this->mreturgudang->update('apt_stok_unit',$datastoktujuan,'kd_unit_apt="'.$kd_unit_tujuan.'" and kd_obat="'.$kode.'" and tgl_expire="'.$tglexpire.'"');
			}
			
			$msg['status']=1;
			$msg['posting']=2;
			$msg['pesan']="Buka Transksi Berhasil";
			$this->db->trans_complete();
			echo json_encode($msg);
			return false;
		}

		if($this->mreturgudang->isNumberExist($no_retur)){ //edit
			$tgl_retur1=convertDate($tgl_retur)." ".$jam_retur1;
		    $datadistribusiedit=array('shift'=>$shift,
									'tgl_retur'=>$tgl_retur1, 
									'posting'=>$posting,
									'kd_unit_asal'=>$kd_unit_asal,
									'kd_unit_tujuan'=>$kd_unit_tujuan,
									'kd_user'=>$kd_user);
				
			$this->mreturgudang->update('apt_retur_gudang',$datadistribusiedit,'no_retur="'.$no_retur.'"');
			$urut=1;			
			$this->mreturgudang->delete('apt_retur_gudang_detail','no_retur="'.$no_retur.'"');
			
			if(!empty($kd_obat)){
				foreach ($kd_obat as $key => $value){
					if(empty($value))continue;
					//$pembanding=$this->mreturgudang->ambilPembanding($value);
					//$qty_box=$qty[$key]/$pembanding;
					
					$datadetiledit=array('no_retur'=>$no_retur,
										'urut'=>$urut,
										'kd_obat'=>$value,
										'kd_milik'=>$kd_milik,
										'tgl_expire'=>convertDate($tgl_expire[$key]),
										'qty'=>$qty[$key]);
					$this->mreturgudang->insert('apt_retur_gudang_detail',$datadetiledit);
					$urut++;
				}
			}
			$msg['pesan']="Data Berhasil Di Update";
			$msg['posting']=3;
		}
		else { //simpan baru
			$tgl=explode("-", $tgl_retur);
			$kode=$this->mreturgudang->autoNumber($tgl[2],$tgl[1]);
			$kodebaru=$kode+1;
			$kodebaru=str_pad($kodebaru,4,0,STR_PAD_LEFT); 
			$no_retur="RETUR".$tgl[2]."".$tgl[1]."".$kodebaru;			
			$msg['no_retur']=$no_retur;
			$tgl_retur1=convertDate($tgl_retur)." ".$jam_retur;
			
			$datadistribusi=array('no_retur'=>$no_retur,
								'shift'=>$shift,
								'tgl_retur'=>$tgl_retur1,
								'posting'=>$posting,
								'kd_unit_asal'=>$kd_unit_asal,
								'kd_unit_tujuan'=>$kd_unit_tujuan,
								'kd_user'=>$kd_user);
			
			$this->mreturgudang->insert('apt_retur_gudang',$datadistribusi);
			$urut=1;
			if(!empty($kd_obat)){
				foreach ($kd_obat as $key => $value){
					# code...
					if(empty($value))continue;
					//$pembanding=$this->mreturgudang->ambilPembanding($value);
					//$qty_box=$qty[$key]/$pembanding;
					
					$datadetil=array('no_retur'=>$no_retur,
									'urut'=>$urut,
									'kd_obat'=>$value,
									'kd_milik'=>$kd_milik,
									'tgl_expire'=>convertDate($tgl_expire[$key]),
									'qty'=>$qty[$key]);
					$this->mreturgudang->insert('apt_retur_gudang_detail',$datadetil);													
					$urut++;
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

	public function hapusreturgudang($no_retur=""){
		if(!$this->muser->isAkses("68")){
			$this->restricted();
			return false;
		}
		
		$msg=array();
		$error=0;
		if(empty($no_retur)){
			$msg['pesan']="Pilih Transaksi yang akan di hapus";
			echo "<script>Alert('".$msg['pesan']."')</script>";
		}else{			
			$this->db->trans_start();
			$this->mreturgudang->delete('apt_retur_gudang','no_retur="'.$no_retur.'"');
			$this->mreturgudang->delete('apt_retur_gudang_detail','no_retur="'.$no_retur.'"');	
			$this->db->trans_complete();
			redirect('/transapotek/aptreturgudang/');
		}
	}
	
	
	public function ambildaftarobatbykode()	{
		$kd_obat=$this->input->post('kd_obat');
		$kd_unit_apt=$this->session->userdata('kd_unit_apt');		
		
		$this->datatables->select("apt_stok_unit.kd_obat,apt_obat.nama_obat,apt_satuan_kecil.satuan_kecil,date_format(apt_stok_unit.tgl_expire,'%d-%m-%Y') as tgl_expire,
		 substring_index(apt_stok_unit.jml_stok,'.',1) as jml_stok,'pilihan' as pilihan,ifnull(apt_obat.min_stok,0) as min_stok",false);
		
		$this->datatables->from("apt_obat");
		$this->datatables->edit_column('pilihan', '<a class="btn" onclick=\'pilihobat("$1","$2","$3","$4","$5","$6")\'>Pilih</a>','apt_stok_unit.kd_obat,apt_obat.nama_obat,apt_satuan_kecil.satuan_kecil,tgl_expire,
																																		jml_stok,min_stok');		
		if(!empty($kd_obat))$this->datatables->like('apt_obat.kd_obat',$kd_obat,'both');
		
		$this->datatables->where('apt_stok_unit.kd_unit_apt',$kd_unit_apt);
		//$this->datatables->where('apt_stok_unit.jml_stok >','0');
		
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
		
		$this->datatables->select("apt_stok_unit.kd_obat,apt_obat.nama_obat,apt_satuan_kecil.satuan_kecil,date_format(apt_stok_unit.tgl_expire,'%d-%m-%Y') as tgl_expire,
		 substring_index(apt_stok_unit.jml_stok,'.',1) as jml_stok,'pilihan' as pilihan,ifnull(apt_obat.min_stok,0) as min_stok",false);
		
		$this->datatables->from("apt_obat");
		$this->datatables->edit_column('pilihan', '<a class="btn" onclick=\'pilihobat("$1","$2","$3","$4","$5","$6")\'>Pilih</a>','apt_stok_unit.kd_obat,apt_obat.nama_obat,apt_satuan_kecil.satuan_kecil,tgl_expire,
																																		jml_stok,min_stok');		
		if(!empty($nama_obat))$this->datatables->like('apt_obat.nama_obat',$nama_obat,'both');
		
		$this->datatables->where('apt_stok_unit.kd_unit_apt',$kd_unit_apt);
		//$this->datatables->where('apt_stok_unit.jml_stok >','0');
		
		$this->datatables->join('apt_satuan_kecil','apt_obat.kd_satuan_kecil=apt_satuan_kecil.kd_satuan_kecil');
		$this->datatables->join('apt_stok_unit','apt_obat.kd_obat=apt_stok_unit.kd_obat');
		$this->datatables->join('apt_unit','apt_stok_unit.kd_unit_apt=apt_unit.kd_unit_apt');
		$results = $this->datatables->generate();
		echo ($results);
	}
	
	public function ambilunittujuan()
	{
		$q=$this->input->get('query');
		$items=$this->mreturgudang->ambilDataTujuan($q);
		echo json_encode($items);
	}
	
	public function periksareturgudang() {
		$msg=array();
		$submit=$this->input->post('submit');
		$no_retur=$this->input->post('no_retur');
		$shift=$this->input->post('shift');
		$tgl_retur=$this->input->post('tgl_retur');
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
		$jml_stok=$this->input->post('jml_stok');		
		
		$jumlaherror=0;
		$msg['status']=1;
		$msg['clearform']=0;
		$msg['pesanatas']="";
		$msg['pesanlain']="";
		
		if($submit=="hapus"){
			if(empty($no_retur)){
				$msg['pesanatas']="Pilih Transaksi yang akan di hapus";
			}else{
				$this->mreturgudang->delete('apt_retur_gudang','no_retur="'.$no_retur.'"');
				$this->mreturgudang->delete('apt_retur_gudang_detail','no_retur="'.$no_retur.'"');
				$msg['pesanatas']="Data Berhasil Di Hapus";
			}
			$msg['status']=0;
			$msg['clearform']=1;
			echo json_encode($msg);
		}
		else if($submit=="tutuptrans" or $submit=="bukatrans"){}
		else{
			if(empty($tgl_retur)){
				$jumlaherror++;
				$msg['id'][]="tgl_retur";
				$msg['pesan'][]="Kolom Tanggal Harus di Isi";
			}
			if(!empty($kd_obat)){
				foreach ($kd_obat as $key => $value) {
					# code...
					if(empty($value))continue;
					if(empty($qty[$key])){
						$msg['status']=0;
						$nama=$this->mreturgudang->ambilNama($value);
						$msg['pesanlain'].="Qty ".$nama." Tidak boleh Kosong <br/>";					
					}
					if($qty[$key]>$jml_stok[$key]){
						$msg['status']=0;
						$nama=$this->mreturgudang->ambilNama($value);
						$msg['pesanlain'].="Stok ".$nama." tidak mencukupi <br/>";
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
	
	public function ambilitem()
	{
		$q=$this->input->get('query');
		$items1=$this->mreturgudang->getRetur1($q);
		$items2=$this->mreturgudang->getRetur2($q);
		$items=array_merge($items1,$items2);
		echo json_encode($items);
	}
	
	public function ambilitems()
	{
		$q=$this->input->get('query');
		$items=$this->mreturgudang->getAllDetailRetur($q);

		echo json_encode($items);
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
