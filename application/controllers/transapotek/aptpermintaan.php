<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

include_once(APPPATH.'controllers/rumahsakit.php');
//class Aptpermintaan extends CI_Controller {
class Aptpermintaan extends Rumahsakit {

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
		$this->load->model('apotek/mpermintaan');
		$kd_unit_apt=$this->session->userdata('kd_unit_apt');
		if(empty($kd_unit_apt)){
			redirect('/home/');
		}
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
		if(!$this->muser->isAkses("53")){
			$this->restricted();
			return false;
		}
		
		$no_permintaan='';
		$periodeawal=date('d-m-Y');
		$periodeakhir=date('d-m-Y');
		
		if($this->input->post('no_permintaan')!=''){
			$no_permintaan=$this->input->post('no_permintaan');
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
		
		$data=array('no_permintaan'=>$no_permintaan,
					'periodeawal'=>$periodeawal,
					'periodeakhir'=>$periodeakhir,
					'items'=>$this->mpermintaan->ambilDataPermintaan($no_permintaan,$periodeawal,$periodeakhir));
		
		//debugvar($items);
		$this->load->view('headerapotek',$dataheader);
		$this->load->view('apotek/transaksi/permintaan/aptpermintaan',$data);
		$this->load->view('footer',$datafooter);
	}
		
	public function tambahpermintaan(){	
		if(!$this->muser->isAkses("54")){
			$this->restricted();
			return false;
		}
		
		$kode=""; $no_permintaan=""; $kd_applogin="";
		
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
		
		$kd_applogin=$this->mpermintaan->ambilApp();
		
		$data=array('no_permintaan'=>'',
					//'itemtransaksi'=>$this->mpermintaan->ambilItemData('apt_permintaan_obat','no_permintaan="'.$no_permintaan.'"'),
					'itemtransaksi'=>$this->mpermintaan->ItemPermintaan($no_permintaan),
					'itemsdetiltransaksi'=>$this->mpermintaan->getAllDetailPermintaan($no_permintaan),
					'items'=>$this->mpermintaan->ambilDataPermintaan('','','')
					);
		
		$this->load->view('headerapotek',$dataheader);
		$this->load->view('apotek/transaksi/permintaan/tambahpermintaan',$data);
		$this->load->view('footer',$datafooter);	
	}
	
	public function ubahpermintaan($no_permintaan=""){
		if(!$this->muser->isAkses("55")){
			$this->restricted();
			return false;
		}
		
		$kd_applogin="";
		if(empty($no_permintaan))return false;
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
		
		$kd_applogin=$this->mpermintaan->ambilApp();
		
		$data=array('no_permintaan'=>$no_permintaan,
					'itemtransaksi'=>$this->mpermintaan->ItemPermintaan($no_permintaan),
					'itemsdetiltransaksi'=>$this->mpermintaan->getAllDetailPermintaan($no_permintaan),
					'items'=>$this->mpermintaan->ambilDataPermintaan('','','')
					);
		$this->load->view('headerapotek',$dataheader);
		$this->load->view('apotek/transaksi/permintaan/tambahpermintaan',$data);
		$this->load->view('footer',$datafooter);
	}
	
	public function simpanpermintaan(){
		$msg=array();
		$submit=$this->input->post('submit');
		$no_permintaan=$this->input->post('no_permintaan');
		$tgl_permintaan=$this->input->post('tgl_permintaan');
		$keterangan=$this->input->post('keterangan');
		
		$kd_obat=$this->input->post('kd_obat');
		$nama_obat=$this->input->post('nama_obat');
		$satuan_kecil=$this->input->post('satuan_kecil');
		$tgl_expire=$this->input->post('tgl_expire');
		$jml_req=$this->input->post('jml_req');
		
		$jam_permintaan=$this->input->post('jam_permintaan');
		$jam_permintaan1=$this->input->post('jam_permintaan1');
		
		$kd_user=$this->session->userdata('id_user'); 
		$kd_unit_apt=$this->session->userdata('kd_unit_apt');
		
		$msg['no_permintaan']=$no_permintaan;
		$msg['posting']=0;
		
		$this->db->trans_start();
		if($this->mpermintaan->isNumberExist($no_permintaan)){ //edit
			$tgl_permintaan1=convertDate($tgl_permintaan)." ".$jam_permintaan1;
		    $datapermintaananedit=array(//'tgl_permintaan'=>convertDate($tgl_permintaan),
										'tgl_permintaan'=>$tgl_permintaan1,
										'keterangan'=>$keterangan);
				
			$this->mpermintaan->update('apt_permintaan_obat',$datapermintaananedit,'no_permintaan="'.$no_permintaan.'"');
			$urut=1;
			
			$this->mpermintaan->delete('apt_permintaan_obat_det','no_permintaan="'.$no_permintaan.'"');
			
			if(!empty($kd_obat)){
				foreach ($kd_obat as $key => $value){
					# code...
					if(empty($value))continue;										
					$datadetil=array('no_permintaan'=>$no_permintaan,
									'urut'=>$urut,
									'kd_obat'=>$value,
									'tgl_expire'=>convertDate($tgl_expire[$key]),
									'jml_req'=>$jml_req[$key],
									'jml_distribusi'=>0);
					$this->mpermintaan->insert('apt_permintaan_obat_det',$datadetil);	
					$urut++;
				}
			}
			$msg['pesan']="Data Berhasil Di Update";
			$msg['posting']=3;
		}
		else { //simpan baru
			$tgl=explode("-", $tgl_permintaan);
			$kode=$this->mpermintaan->autoNumber($tgl[2],$tgl[1]);
			$kodebaru=$kode+1;
			$kodebaru=str_pad($kodebaru,4,0,STR_PAD_LEFT); 
			$no_permintaan="OD.".$tgl[2].".".$tgl[1].".".$kodebaru;
			$msg['no_permintaan']=$no_permintaan;
			$tgl_permintaan1=convertDate($tgl_permintaan)." ".$jam_permintaan;
			$datapermintaan=array('no_permintaan'=>$no_permintaan,
									'kd_unit_apt'=>$kd_unit_apt,
									//'tgl_permintaan'=>convertDate($tgl_permintaan),
									'tgl_permintaan'=>$tgl_permintaan1,
									'keterangan'=>$keterangan,
									'permintaan_status'=>0,
									'status_approve'=>0,
									'kd_user'=>$kd_user);
			
			$this->mpermintaan->insert('apt_permintaan_obat',$datapermintaan);
			$urut=1;
			if(!empty($kd_obat)){
				foreach ($kd_obat as $key => $value){
					# code...
					if(empty($value))continue;										
					$datadetil=array('no_permintaan'=>$no_permintaan,
									'urut'=>$urut,
									'kd_obat'=>$value,
									'tgl_expire'=>convertDate($tgl_expire[$key]),
									'jml_req'=>$jml_req[$key],
									'jml_distribusi'=>0);
					//debugvar($datadetil);
					$this->mpermintaan->insert('apt_permintaan_obat_det',$datadetil);	
					$urut++;
				}
			}	
			
			$msg['pesan']="Data Berhasil Di Simpan";
			$msg['posting']=3;
		}

		$this->db->trans_complete();
		$msg['status']=1;
		$msg['keluar']=0;
		
		echo json_encode($msg);
	}
	
	public function hapuspermintaan($no_permintaan=""){
		if(!$this->muser->isAkses("56")){
			$this->restricted();
			return false;
		}
		//$kd_unit_apt="";
		$msg=array();
		$error=0;
		if(empty($no_permintaan)){
			$msg['pesan']="Pilih Transaksi yang akan di hapus";
			echo "<script>Alert('".$msg['pesan']."')</script>";
		}else{		
			$this->db->trans_start();
			$this->mpermintaan->delete('apt_permintaan_obat','no_permintaan="'.$no_permintaan.'"');
			$this->mpermintaan->delete('apt_permintaan_obat_det','no_permintaan="'.$no_permintaan.'"');		
			$this->db->trans_complete();	
			redirect('/transapotek/aptpermintaan/');
		}
	}
	
	public function ambildaftarobatbynama(){
		$nama_obat=$this->input->post('nama_obat');
		//$kd_unit_apt=$this->session->userdata('kd_unit_apt_gudang');
		
		$this->datatables->select("apt_obat.kd_obat as kd_obat1, apt_obat.nama_obat, apt_satuan_kecil.satuan_kecil,date_format(apt_obat.tgl_expire,'%d-%m-%Y') as tgl_expire, 'Pilihan' as pilihan",false);
		
		$this->datatables->from("apt_obat");
		$this->datatables->edit_column('pilihan', '<a class="btn" onclick=\'pilihobat("$1","$2","$3","$4","$5")\'>Pilih</a>','kd_obat1, apt_obat.nama_obat, apt_satuan_kecil.satuan_kecil,tgl_expire');			
		if(!empty($nama_obat))$this->datatables->like('apt_obat.nama_obat',$nama_obat,'both');
		
		$this->datatables->join('apt_satuan_kecil','apt_obat.kd_satuan_kecil=apt_satuan_kecil.kd_satuan_kecil','left');
		$this->db->group_by("apt_obat.kd_obat");
		$results = $this->datatables->generate();
		echo ($results);	
	}
	
	public function ambildaftarobatbykode(){
		$kd_obat=$this->input->post('kd_obat');
		//$kd_unit_apt=$this->session->userdata('kd_unit_apt');
		
		$this->datatables->select("apt_obat.kd_obat as kd_obat1, apt_obat.nama_obat, apt_satuan_kecil.satuan_kecil, date_format(apt_obat.tgl_expire,'%d-%m-%Y') as tgl_expire, 'Pilihan' as pilihan",false);
		
		$this->datatables->from("apt_obat");
		$this->datatables->edit_column('pilihan', '<a class="btn" onclick=\'pilihobat("$1","$2","$3","$4","$5")\'>Pilih</a>','kd_obat1, apt_obat.nama_obat, apt_satuan_kecil.satuan_kecil, tgl_expire');			
		if(!empty($kd_obat))$this->datatables->like('apt_obat.kd_obat',$kd_obat,'both');
		
		$this->datatables->join('apt_satuan_kecil','apt_obat.kd_satuan_kecil=apt_satuan_kecil.kd_satuan_kecil','left');
		$this->db->group_by("apt_obat.kd_obat");
		$results = $this->datatables->generate();
		echo ($results);			
	}
	
	public function periksapermintaan() {
		$msg=array();
		$submit=$this->input->post('submit');
		$no_permintaan=$this->input->post('no_permintaan');
		$tgl_permintaan=$this->input->post('tgl_permintaan');
		$keterangan=$this->input->post('keterangan');
		
		$kd_obat=$this->input->post('kd_obat');
		$nama_obat=$this->input->post('nama_obat');
		$satuan_kecil=$this->input->post('satuan_kecil');
		$tgl_expire=$this->input->post('tgl_expire');
		$jml_req=$this->input->post('jml_req');
		
		$jumlaherror=0;
		$msg['status']=1;
		$msg['clearform']=0;
		$msg['pesanatas']="";
		$msg['pesanlain']="";
		
		if($submit=="hapus"){
			if(empty($no_permintaan)){
				$msg['pesanatas']="Pilih Transaksi yang akan di hapus";
			}else{
				$this->mpermintaan->delete('apt_permintaan_obat','no_permintaan="'.$no_permintaan.'"');
				$this->mpermintaan->delete('apt_permintaan_obat_det','no_permintaan="'.$no_permintaan.'"');
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
					if(empty($jml_req[$key])){
						$msg['status']=0;
						$msg['pesanlain'].="Qty ".$value." tidak boleh Kosong <br/>";					
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
		//$items=$this->mpermintaan->ambilItemData('apt_permintaan_obat','no_permintaan="'.$q.'"');
		$items=$this->mpermintaan->ItemPermintaan($q);

		echo json_encode($items);
	}
	
	public function ambilitems()
	{
		$q=$this->input->get('query');
		$items=$this->mpermintaan->getAllDetailPermintaan($q);

		echo json_encode($items);
	}

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */