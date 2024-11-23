<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

include_once(APPPATH.'controllers/rumahsakit.php');
//class Aptpengajuan extends CI_Controller {
class Aptpengajuan extends Rumahsakit {

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
		$this->load->model('apotek/mpengajuan');
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
		if(!$this->muser->isAkses("29")){
			$this->restricted();
			return false;
		}
		
		$no_pengajuan='';
		$periodeawal=date('d-m-Y');
		$periodeakhir=date('d-m-Y');
		
		if($this->input->post('no_pengajuan')!=''){
			$no_pengajuan=$this->input->post('no_pengajuan');
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
		
		$data=array('no_pengajuan'=>$no_pengajuan,
					'periodeawal'=>$periodeawal,
					'periodeakhir'=>$periodeakhir,
					'items'=>$this->mpengajuan->ambilDataPengajuan($no_pengajuan,$periodeawal,$periodeakhir));
		
		//debugvar($items);
		$this->load->view('headerapotek',$dataheader);
		$this->load->view('apotek/transaksi/pengajuan/aptpengajuan',$data);
		$this->load->view('footer',$datafooter);
	}
		
	public function tambahpengajuan(){	
		if(!$this->muser->isAkses("30")){
			$this->restricted();
			return false;
		}
		
		$kode=""; $no_pengajuan=""; $kd_applogin="";
		
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
		
		$kd_applogin=$this->mpengajuan->ambilApp();
		
		$data=array('no_pengajuan'=>'',
					//'datasupplier'=>$this->mpengajuan->ambilData('apt_supplier'),
					//'itemtransaksi'=>$this->mpengajuan->ambilItemData('apt_pengajuan','no_pengajuan="'.$no_pengajuan.'"'),
					'itemtransaksi'=>$this->mpengajuan->getPengajuan($no_pengajuan),
					'itemsdetiltransaksi'=>$this->mpengajuan->getAllDetailPengajuan($no_pengajuan),
					'items'=>$this->mpengajuan->ambilDataPengajuan('','',''),
					'itemapprove'=>$this->mpengajuan->ambilApprover(),
					//'applogin'=>$this->mpengajuan->ambilApp()
					'kd_applogin'=>$kd_applogin
					);
		
		$this->load->view('headerapotek',$dataheader);
		$this->load->view('apotek/transaksi/pengajuan/tambahpengajuan',$data);
		$this->load->view('footer',$datafooter);	
	}
	
	public function ubahpengajuan($no_pengajuan=""){
		if(!$this->muser->isAkses("31")){
			$this->restricted();
			return false;
		}
		
		$sum="";
		$kd_applogin="";
		if(empty($no_pengajuan))return false;
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
		
		$kd_applogin=$this->mpengajuan->ambilApp();
		
		$data=array(//'datasupplier'=>$this->mpengajuan->ambilData('apt_supplier'),
					'no_pengajuan'=>$no_pengajuan,
					//'itemtransaksi'=>$this->mpengajuan->ambilItemData('apt_pengajuan','no_pengajuan="'.$no_pengajuan.'"'),
					'itemtransaksi'=>$this->mpengajuan->getPengajuan($no_pengajuan),
					'itemsdetiltransaksi'=>$this->mpengajuan->getAllDetailPengajuan($no_pengajuan),
					'items'=>$this->mpengajuan->ambilDataPengajuan('','',''),
					'itemapprove'=>$this->mpengajuan->tampilApprover($no_pengajuan),
					//'applogin'=>$this->mpengajuan->ambilApp()
					'kd_applogin'=>$kd_applogin
					);
		//debugvar($no_pengajuan);
		$this->load->view('headerapotek',$dataheader);
		$this->load->view('apotek/transaksi/pengajuan/tambahpengajuan',$data);
		$this->load->view('footer',$datafooter);
	}
	
	public function simpanpengajuan(){
		$msg=array();
		$submit=$this->input->post('submit');
		$no_pengajuan=$this->input->post('no_pengajuan');
		$tgl_pengajuan=$this->input->post('tgl_pengajuan');
		//$tgl_tempo=$this->input->post('tgl_tempo');
		//$kd_supplier=$this->input->post('kd_supplier');
		//$nama=$this->input->post('nama');
		$keterangan=$this->input->post('keterangan');
		
		$kd_obat=$this->input->post('kd_obat');
		$nama_obat=$this->input->post('nama_obat');
		$satuan_kecil=$this->input->post('satuan_kecil');
		$pembanding=$this->input->post('pembanding');
		$qty_box=$this->input->post('qty_box'); 
		$qty_kcl=$this->input->post('qty_kcl');
		$harga_beli=$this->input->post('harga_beli');
		$jam_pengajuan=$this->input->post('jam_pengajuan');
		$jam_pengajuan1=$this->input->post('jam_pengajuan1');
		//$diskon=$this->input->post('diskon');
		//$ppn=$this->input->post('ppn');
		
		$nama_pegawai=$this->input->post('nama_pegawai');
		$status=$this->input->post('status');
		$kd_app=$this->input->post('kd_app');
		$kd_applogin=$this->input->post('kd_applogin');
		
		//$kd_user=$this->session->userdata('id_user'); 
		
		$msg['no_pengajuan']=$no_pengajuan;
		$msg['posting']=0;
		
		if($this->mpengajuan->isNumberExist($no_pengajuan)){ //edit
			$this->db->trans_start();
			$this->db->query("SELECT * FROM apt_pengajuan where no_pengajuan='".$no_pengajuan."' FOR UPDATE");
			$tgl_pengajuan1=convertDate($tgl_pengajuan)." ".$jam_pengajuan1;
		    $datapengajuananedit=array(//'tgl_pengajuan'=>convertDate($tgl_pengajuan),
										'tgl_pengajuan'=>$tgl_pengajuan1,
										'keterangan'=>$keterangan);
				
			$this->mpengajuan->update('apt_pengajuan',$datapengajuananedit,'no_pengajuan="'.$no_pengajuan.'"');
			$urut=1;
			
			$this->mpengajuan->delete('apt_pengajuan_detail','no_pengajuan="'.$no_pengajuan.'"');
			
			if(!empty($kd_obat)){
				foreach ($kd_obat as $key => $value){
					if(empty($value))continue;					
					$datadetiledit=array('no_pengajuan'=>$no_pengajuan,
										'urut_pengajuan'=>$urut,
										'kd_obat'=>$value,
										'qty_kcl'=>$qty_kcl[$key],
										'harga_beli'=>$harga_beli[$key]);
					$this->mpengajuan->insert('apt_pengajuan_detail',$datadetiledit);										
					$urut++;
				}
			}
			$this->db->trans_complete();
			$msg['pesan']="Data Berhasil Di Update";
		}else { //simpan baru
			$this->db->trans_start();
			$tgl=explode("-", $tgl_pengajuan);
			$kode=$this->mpengajuan->autoNumber($tgl[2],$tgl[1]);
			$kodebaru=$kode+1;
			$kodebaru=str_pad($kodebaru,4,0,STR_PAD_LEFT); 
			$no_pengajuan="PG.".$tgl[2].".".$tgl[1].".".$kodebaru;
			$msg['no_pengajuan']=$no_pengajuan;
			$tgl_pengajuan1=convertDate($tgl_pengajuan)." ".$jam_pengajuan;
			$datapengajuan=array('no_pengajuan'=>$no_pengajuan,
									//'kd_supplier'=>$kd_supplier,
									//'tgl_pengajuan'=>convertDate($tgl_pengajuan),
									'tgl_pengajuan'=>$tgl_pengajuan1,
									'keterangan'=>$keterangan,
									'is_grouping'=>0,
									'status_approve'=>0);
			
			$this->mpengajuan->insert('apt_pengajuan',$datapengajuan);
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
					$this->mpengajuan->insert('apt_pengajuan_detail',$datadetil);	
										
					$urut++;
				}
			}
			
			if(!empty($kd_app)){
				foreach ($kd_app as $key => $value){
					if(empty($value))continue;
					$dataapp=array('kd_app'=>$value,
							'no_pengajuan'=>$no_pengajuan,
							'is_app'=>0);
					$this->mpengajuan->insert('apt_app_pengajuan',$dataapp);
				}
			}	
			
			$msg['pesan']="Data Berhasil Di Simpan";
			$msg['posting']=3;
			$this->db->trans_complete();
		}
		$msg['status']=1;
		$msg['keluar']=0;
		
		if($submit=="approve"){
			$this->db->trans_start();
			if(empty($no_pengajuan))return false;
			$updateapprove=array('is_app'=>1);
			$this->mpengajuan->update('apt_app_pengajuan',$updateapprove,'kd_app="'.$kd_applogin.'" and no_pengajuan="'.$no_pengajuan.'"');
			
			$count=$this->mpengajuan->countApprover($no_pengajuan);
			$countisap=$this->mpengajuan->countIsApp($no_pengajuan);
			if($countisap==$count){
				$up=array('status_approve'=>1);
				$this->mpengajuan->update('apt_pengajuan',$up,'no_pengajuan="'.$no_pengajuan.'"');
			}
			$this->db->trans_complete();
			$msg['status']=1;
			$msg['posting']=1;
			$msg['pesan']="Approve Berhasil";
			echo json_encode($msg);

			return false;
		}
		if($submit=="unapprove"){
			if(empty($no_pengajuan))return false;
			$this->db->trans_start();
			$updateapprove=array('is_app'=>0);
			$this->mpengajuan->update('apt_app_pengajuan',$updateapprove,'kd_app="'.$kd_applogin.'" and no_pengajuan="'.$no_pengajuan.'"');
			
			$count=$this->mpengajuan->countApprover($no_pengajuan);
			$countisap=$this->mpengajuan->countIsApp($no_pengajuan);
			if($countisap!=$count){
				$up=array('status_approve'=>0);
				$this->mpengajuan->update('apt_pengajuan',$up,'no_pengajuan="'.$no_pengajuan.'"');
			}
			$this->db->trans_complete();
			$msg['status']=1;
			$msg['posting']=2;
			$msg['pesan']="Batal approve berhasil";
			echo json_encode($msg);
			return false;
		}

		
		echo json_encode($msg);
	}
	public function hapuspengajuan($no_pengajuan=""){
		if(!$this->muser->isAkses("32")){
			$this->restricted();
			return false;
		}
		//$kd_unit_apt="";
		$msg=array();
		$error=0;
		if(empty($no_pengajuan)){
			$msg['pesan']="Pilih Transaksi yang akan di hapus";
			echo "<script>Alert('".$msg['pesan']."')</script>";
		}else{		
			$this->db->trans_start();
			$this->mpengajuan->delete('apt_pengajuan','no_pengajuan="'.$no_pengajuan.'"');
			$this->mpengajuan->delete('apt_pengajuan_detail','no_pengajuan="'.$no_pengajuan.'"');	
			$this->db->trans_complete();		
			redirect('/transapotek/aptpengajuan/');
		}
	}
		
	/*public function ambildaftarobatbynama(){
		$nama_obat=$this->input->post('nama_obat');
		
		$this->datatables->select("apt_obat.kd_obat, apt_obat.nama_obat, apt_satuan_kecil.satuan_kecil, ifnull( sum(substring_index( apt_stok_unit.jml_stok, '.', 1 )) , 0 ) as jml_stok, 'Pilihan' as pilihan,apt_obat.pembanding,nama_unit_apt",false);
		
		$this->datatables->from("apt_obat");
		$this->datatables->edit_column('pilihan', '<a class="btn" onclick=\'pilihobat("$1","$2","$3","$4","$5","$6")\'>Pilih</a>','apt_obat.kd_obat, apt_obat.nama_obat, apt_satuan_kecil.satuan_kecil, apt_obat.pembanding, jml_stok, nama_unit_apt');		
		if(!empty($nama_obat))$this->datatables->like('apt_obat.nama_obat',$nama_obat,'both');
		
		$this->datatables->where('apt_stok_unit.kd_unit_apt','U01');
		
		$this->datatables->join('apt_satuan_kecil','apt_obat.kd_satuan_kecil=apt_satuan_kecil.kd_satuan_kecil','left');
		$this->datatables->join('apt_stok_unit','apt_obat.kd_obat=apt_stok_unit.kd_obat','left');
		$this->datatables->join('apt_unit','apt_stok_unit.kd_unit_apt=apt_unit.kd_unit_apt','left');
		$this->db->group_by("apt_stok_unit.kd_obat");
		$results = $this->datatables->generate();
		echo ($results);	
	}*/
	
	public function ambildaftarobatbynama(){
		$nama_obat=$this->input->post('nama_obat');
		$kd_unit_apt=$this->session->userdata('kd_unit_apt_gudang');
		
		$this->datatables->select("apt_obat.kd_obat as kd_obat1, apt_obat.nama_obat, apt_satuan_kecil.satuan_kecil, 'Pilihan' as pilihan,apt_obat.pembanding,
								(select if( count(kd_obat)>0, max_stok, 0 ) from apt_setting_obat where kd_obat=kd_obat1 and kd_unit_apt='$kd_unit_apt') as max_stok,
								apt_obat.harga_beli",false);
		
		$this->datatables->from("apt_obat");
		$this->datatables->edit_column('pilihan', '<a class="btn" onclick=\'pilihobat("$1","$2","$3","$4","$5","$6","$7")\'>Pilih</a>','kd_obat1, apt_obat.nama_obat, apt_satuan_kecil.satuan_kecil, apt_obat.pembanding,max_stok,apt_obat.harga_beli');		
		if(!empty($nama_obat))$this->datatables->like('apt_obat.nama_obat',$nama_obat,'both');
		
		$this->datatables->join('apt_satuan_kecil','apt_obat.kd_satuan_kecil=apt_satuan_kecil.kd_satuan_kecil','left');
		$this->db->group_by("apt_obat.kd_obat");
		$results = $this->datatables->generate();
		echo ($results);	
	}
	
	public function ambildaftarobatbykode(){
		$kd_obat=$this->input->post('kd_obat');
		$kd_unit_apt=$this->session->userdata('kd_unit_apt_gudang');
		
		$this->datatables->select("apt_obat.kd_obat as kd_obat1, apt_obat.nama_obat, apt_satuan_kecil.satuan_kecil, 'Pilihan' as pilihan,apt_obat.pembanding,
								(select if( count(kd_obat)>0, max_stok, 0 ) from apt_setting_obat where kd_obat=kd_obat1 and kd_unit_apt='$kd_unit_apt') as max_stok,
								apt_obat.harga_beli",false);
		
		$this->datatables->from("apt_obat");
		$this->datatables->edit_column('pilihan', '<a class="btn" onclick=\'pilihobat("$1","$2","$3","$4","$5","$6","$7")\'>Pilih</a>','kd_obat1, apt_obat.nama_obat, apt_satuan_kecil.satuan_kecil, apt_obat.pembanding,max_stok,apt_obat.harga_beli');			
		if(!empty($kd_obat))$this->datatables->like('apt_obat.kd_obat',$kd_obat,'both');
		
		$this->datatables->join('apt_satuan_kecil','apt_obat.kd_satuan_kecil=apt_satuan_kecil.kd_satuan_kecil','left');
		$this->db->group_by("apt_obat.kd_obat");
		$results = $this->datatables->generate();
		echo ($results);			
	}
	
	public function ambilsupplierbykode(){
		$q=$this->input->get('query');
		$items=$this->mpengajuan->ambilData3($q);
		echo json_encode($items);
	}
	
	public function ambilsupplierbynama(){
		$q=$this->input->get('query');
		$items=$this->mpengajuan->ambilData4($q);
		echo json_encode($items);
	}
	
	public function periksapengajuan() {
		$msg=array();
		$submit=$this->input->post('submit');
		$no_pengajuan=$this->input->post('no_pengajuan');
		$tgl_pengajuan=$this->input->post('tgl_pengajuan');
		//$tgl_tempo=$this->input->post('tgl_tempo');
		//$kd_supplier=$this->input->post('kd_supplier');
		//$nama=$this->input->post('nama');
		$keterangan=$this->input->post('keterangan');
		
		$kd_obat=$this->input->post('kd_obat');
		$nama_obat=$this->input->post('nama_obat');
		$satuan_kecil=$this->input->post('satuan_kecil');
		$pembanding=$this->input->post('pembanding');
		$qty_box=$this->input->post('qty_box'); 
		$qty_kcl=$this->input->post('qty_kcl');
		$harga_beli=$this->input->post('harga_beli');
		
		$nama_pegawai=$this->input->post('nama_pegawai');
		$status=$this->input->post('status');
		$kd_app=$this->input->post('kd_app');
		$kd_applogin=$this->input->post('kd_applogin');
		
		$jumlaherror=0;
		$msg['status']=1;
		$msg['clearform']=0;
		$msg['pesanatas']="";
		$msg['pesanlain']="";
		
		if($submit=="approve"){
			if($this->mpengajuan->isAppExist($no_pengajuan,$kd_applogin)){ //ngecek, yg login bs approve pengajuan nomor ini apa ga...kalo bisa : 				
				$isapp=$this->mpengajuan->statusisaplogin($no_pengajuan,$kd_applogin); //ngecek yg login udh pernah approve ke no pengajuan ini apa blm
				//debugvar($isapp);
				if($isapp==1){ //kalo udh pernah approve
					$jumlaherror++;
					$msg['id'][]="no_pengajuan";
					$msg['pesan'][]="Anda telah melakukan approve untuk nomor pengajuan ".$no_pengajuan;
				}
				else { //kalo blm pernah approve
					$urutapp=$this->mpengajuan->urutapprover($kd_applogin); //urutnya yang login				
					if($urutapp!=1){ //kalo yg login, bukan urut 1
						$urutapp1=$this->mpengajuan->urutapprover1($urutapp,$no_pengajuan); //ambil is_app sebelumnya
						//debugvar($urutapp1);
						if($urutapp1==0){ //cek is_app sebelumnya
							$namapegawai=$this->mpengajuan->pegawai($urutapp,$no_pengajuan); //ambil nama pegawai sbelumnya
							$jumlaherror++;
							$msg['id'][]="no_pengajuan";
							$msg['pesan'][]="Anda tidak bisa melakukan approve, karena user ".$namapegawai." belum melakukan approve.";
						}						
					}
				}
			}
			else{ //kalo yg login ga bs ngelakukan approve
				$jumlaherror++;
				$msg['id'][]="no_pengajuan";
				$msg['pesan'][]="Anda tidak bisa melakukan approve untuk nomor pengajuan ini.";
			}
		}
		if($submit=="unapprove"){
			$urutapp=$this->mpengajuan->urutapprover($kd_applogin); //urutnya yang login				
			if($urutapp!=1){ //kalo yg login, bukan urut 1
				$urutapp1=$this->mpengajuan->urutapprover1($urutapp,$no_pengajuan); //ambil is_app sebelumnya
				//debugvar($urutapp1);
				if($urutapp1==1){ //cek is_app sebelumnya
					$namapegawai=$this->mpengajuan->pegawai($urutapp,$no_pengajuan); //ambil nama pegawai sbelumnya
					$jumlaherror++;
					$msg['id'][]="no_pengajuan";
					$msg['pesan'][]="Anda belum bisa melakukan batal approve, karena user ".$namapegawai." sudah melakukan approve.";
				}						
			}
		}
		if($submit=="hapus"){
			if(empty($no_pengajuan)){
				$msg['pesanatas']="Pilih Transaksi yang akan di hapus";
			}else{
				$this->mpengajuan->delete('apt_pengajuan','no_pengajuan="'.$no_pengajuan.'"');
				$this->mpengajuan->delete('apt_pengajuan_detail','no_pengajuan="'.$no_pengajuan.'"');
				$this->mpengajuan->delete('apt_app_pengajuan','no_pengajuan="'.$no_pengajuan.'"');
				$msg['pesanatas']="Data Berhasil Di Hapus";
			}
			$msg['status']=0;
			$msg['clearform']=1;
			echo json_encode($msg);
		}		
		else{			
			if(!empty($kd_obat)){
				foreach ($kd_obat as $key => $value) {
					# code...
					if(empty($value))continue;
					if(empty($qty_kcl[$key])){
						$msg['status']=0;
						$msg['pesanlain'].="Qty".$value." tidak boleh Kosong <br/>";					
					}
					if(empty($harga_beli[$key])){
						$msg['status']=0;
						$msg['pesanlain'].="Harga".$value." tidak boleh Kosong <br/>";					
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
		$items=$this->mpengajuan->getPengajuan($q);
		//$items=$this->mpengajuan->ambilItemData('apt_pengajuan','no_pengajuan="'.$q.'"');

		echo json_encode($items);
	}
	
	public function ambilitems()
	{
		$q=$this->input->get('query');
		$items=$this->mpengajuan->getAllDetailPengajuan($q);

		echo json_encode($items);
	}

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
