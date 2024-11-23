<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

include_once(APPPATH.'controllers/rumahsakit.php');
class Tarif extends Rumahsakit {

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
	protected $akses='109';

	public function __construct()
	{
		parent::__construct();

		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->helper('utilities');
		$this->load->library('pagination');
		$this->load->model('master/mmaster');

		
		if(!$this->muser->isLogin()){
			redirect('/home/');
			return false;
		}

	}

	public function restricted(){
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

		$this->load->view('master/header',$dataheader);
		$data=array();
		parent::view_restricted($data);
		$this->load->view('footer');
	}

	public function index()
	{
		if(!$this->muser->isAkses("959")){
			$this->restricted();
			return false;
		}
		$kd_jenis_tarif=$this->input->post('kd_jenis_tarif');
		$kd_pelayanan=$this->input->post('kd_pelayanan');
		$kd_kelas=$this->input->post('kd_kelas');
		//debugvar($kd_kelas);
		$cssfileheader=array('bootstrap.min.css','bootstrap-responsive.min.css','font-awesome.min.css','style.css','prettify.css','jquery-ui.css','DT_bootstrap.css','responsive-tables.css','theme.css');
		$jsfileheader=array('vendor/modernizr-2.6.2-respond-1.1.0.min.js',
							'vendor/jquery-1.9.1.min.js',
							'vendor/jquery-migrate-1.1.1.min.js',
							'vendor/jquery-ui-1.10.0.custom.min.js',
							'vendor/bootstrap.min.js',
							'lib/jquery.tablesorter.min.js',
							'lib/jquery.dataTables.min.js',
							'lib/DT_bootstrap.js',
							'lib/responsive-tables.js',
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
			'items'=>$this->mmaster->ambilDataTarif($kd_jenis_tarif,$kd_pelayanan,$kd_kelas),
			'kd_jenis_tarif'=>$kd_jenis_tarif,
			'kd_pelayanan'=>$kd_pelayanan,
			'kd_kelas'=>$kd_kelas,
			'datajenistarif'=>$this->mmaster->ambilData('jenis_tarif'),
			'datapelayanan'=>$this->mmaster->ambilData('list_pelayanan'),			
			'datakelas'=>$this->mmaster->ambilData('kelas_pelayanan')			
		);
		$this->load->view('master/header',$dataheader);
		$this->load->view('master/tarif',$data);
		$this->load->view('footer',$datafooter);
	}
	
	public function tambah($unit="")
	{
		if(!$this->muser->isAkses("960")){
			$this->restricted();
			return false;
		}
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

		$data=array(
			'dataunitkerja'=>$this->mmaster->ambilData('unit_kerja','kd_unit_kerja not in(10,8) '),
			'datajenistarif'=>$this->mmaster->ambilData('jenis_tarif'),
			'datapelayanan'=>$this->mmaster->ambilData('list_pelayanan'),			
			'datakelas'=>$this->mmaster->ambilData('kelas_pelayanan'),			
			'datacustomer'=>$this->mmaster->ambilData('apt_customers'),			
			'datacomponent'=>$this->mmaster->ambilData('component_tarif'),
			'unit'=>$unit			
		);
		if(!empty($unit)){
			$data['datapelayanan']=$this->mmaster->ambilData('list_pelayanan','kd_pelayanan in (select kd_pelayanan from tarif_mapping where kd_unit_kerja="'.$unit.'")');
		}
		$this->load->view('master/header',$dataheader);
		$this->load->view('master/tambahtarif',$data);
		$this->load->view('footer',$datafooter);
	}

	public function periksa()
	{
		$msg=array();
		$mode=$this->input->post('mode');
		$submit=$this->input->post('submit');
		$kd_jenis_tarif=$this->input->post('kd_jenis_tarif');
		$kd_pelayanan=$this->input->post('kd_pelayanan');
		$kd_kelas=$this->input->post('kd_kelas');
		$cust_code=$this->input->post('cust_code');
		$tarif=$this->input->post('tarif');
		$tgl_berlaku=$this->input->post('tgl_berlaku');
		$tgl_berakhir=$this->input->post('tgl_berakhir');
		$kd_component=$this->input->post('component');
		$jumlaherror=0;
		$msg['status']=1;
		$msg['clearform']=0;
		$msg['pesanatas']="";
		$msg['pesanlain']="";

		if(empty($kd_component)){
			$jumlaherror++;
			$msg['id'][]="tarif";
			$msg['pesan'][]="Komponen Tarif Harus di Isi";
		}


		if(empty($kd_jenis_tarif)){
			$jumlaherror++;
			$msg['id'][]="kd_jenis_tarif";
			$msg['pesan'][]="Jenis Tarif Harus di Isi";
		}

		if(empty($kd_pelayanan)){
			$jumlaherror++;
			$msg['id'][]="kd_pelayanan";
			$msg['pesan'][]="Pelayanan Harus di Isi";
		}

		if(empty($kd_kelas)){
			$jumlaherror++;
			$msg['id'][]="kd_kelas";
			$msg['pesan'][]="Kelas Harus di Isi";
		}


		if(empty($tgl_berlaku)){
			$jumlaherror++;
			$msg['id'][]="tgl_berlaku";
			$msg['pesan'][]="tgl berlaku Harus di Isi";
		}

		if($mode!="edit"){
			if($this->mmaster->isExistTarif($kd_jenis_tarif,$kd_pelayanan,$kd_kelas,convertDate($tgl_berlaku))){
				$jumlaherror++;
				$msg['id'][]="kd_jenis_tarif";
				$msg['pesan'][]="Tarif Sudah Ada";
			}			
		}

		if($jumlaherror>0){
			$msg['status']=0;
			$msg['error']=$jumlaherror;
			$msg['pesanatas']="Terdapat beberapa kesalahan input silahkan cek inputan anda";
		}

		echo json_encode($msg);

	}

	public function simpan(){
		$kd_jenis_tarif=$this->input->post('kd_jenis_tarif');
		$kd_pelayanan=$this->input->post('kd_pelayanan');
		$kd_kelas=$this->input->post('kd_kelas');
		$cust_code=$this->input->post('cust_code');
		$tarif=$this->input->post('tarif');
		$tgl_berlaku=$this->input->post('tgl_berlaku');
		$tgl_berakhir=$this->input->post('tgl_berakhir');
		$kd_component=$this->input->post('component');

		$this->mmaster->customQuery("replace into tarif_customers set kd_jenis_tarif='".$kd_jenis_tarif."',cust_code='".$cust_code."' ");

		$totaltarif=0;
		foreach ($kd_component as $key => $value) {
			# code...
			$this->mmaster->customQuery("replace into tarif_component set kd_jenis_tarif='".$kd_jenis_tarif."',kd_pelayanan='".$kd_pelayanan."',
						kd_kelas='".$kd_kelas."',kd_component='".$key."',tgl_berlaku='".convertDate($tgl_berlaku)."',tarif_component='".$value."' ");

			$totaltarif=$totaltarif+$value;
		}

		$this->mmaster->customQuery("replace into tarif set kd_jenis_tarif='".$kd_jenis_tarif."',kd_pelayanan='".$kd_pelayanan."',
					kd_kelas='".$kd_kelas."',tgl_berlaku='".convertDate($tgl_berlaku)."',tarif='".$totaltarif."',tgl_berakhir='".convertDate($tgl_berakhir)."' ");


		$msg['pesan']="Data Berhasil Di Simpan";
		$msg['status']=1;

		echo json_encode($msg);
	}

	public function update(){
		$kd_jenis_tarif_lama=$this->input->post('kd_jenis_tarif_lama');
		$kd_pelayanan_lama=$this->input->post('kd_pelayanan_lama');
		$kd_kelas_lama=$this->input->post('kd_kelas_lama');
		$tgl_berlaku_lama=$this->input->post('tgl_berlaku_lama');
		$kd_jenis_tarif=$this->input->post('kd_jenis_tarif');
		$kd_pelayanan=$this->input->post('kd_pelayanan');
		$kd_unit_kerja=$this->input->post('kd_unit_kerja');
		$tarif=$this->input->post('tarif');
		$tgl_berlaku=$this->input->post('tgl_berlaku');
		$tgl_berakhir=$this->input->post('tgl_berakhir');
		$data=array(
			'kd_jenis_tarif'=>$kd_jenis_tarif,
			'kd_pelayanan'=>$kd_pelayanan,
			'kd_kelas'=>$kd_kelas,
			'tarif'=>$tarif,
			'tgl_berlaku'=>convertDate($tgl_berlaku),
			'tgl_berakhir'=>convertDate($tgl_berakhir)
		);
		$this->mmaster->update('tarif',$data,'kd_jenis_tarif="'.$kd_jenis_tarif_lama.'" and kd_pelayanan="'.$kd_pelayanan_lama.'" and kd_kelas="'.$kd_kelas_lama.'" and tgl_berlaku="'.convertDate($tgl_berlaku_lama).'"');		
		$msg['pesan']="Data Berhasil Di Simpan";
		$msg['status']=1;

		echo json_encode($msg);
	}

	public function edit(){
		if(!$this->muser->isAkses("961")){
			$this->restricted();
			return false;
		}
		$id = $this->input->get("id");
		$kd_pelayanan = $this->input->get("kd_pelayanan");
		$kd_kelas = $this->input->get("kd_kelas");
		$tgl_berlaku = $this->input->get("tgl_berlaku");

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

		$data=array(
			'item'=>$this->mmaster->ambilItemData('tarif','kd_jenis_tarif="'.$id.'" and kd_pelayanan="'.$kd_pelayanan.'" and kd_kelas="'.$kd_kelas.'" and tgl_berlaku="'.$tgl_berlaku.'"'),
			'itemtarifcustomer'=>$this->mmaster->ambilItemData('tarif_customers','kd_jenis_tarif="'.$id.'"'),
			'datajenistarif'=>$this->mmaster->ambilData('jenis_tarif'),
			'datapelayanan'=>$this->mmaster->ambilData('list_pelayanan'),			
			'datakelas'=>$this->mmaster->ambilData('kelas_pelayanan'),			
			'datacustomer'=>$this->mmaster->ambilData('apt_customers'),			
			'datacomponent'=>$this->mmaster->ambilData('component_tarif'),
			'itemskomponen'=>$this->mmaster->getTarifComponentItem($id,$kd_pelayanan,$kd_kelas,$tgl_berlaku)			
		);
		//debugvar($data['itemtarifcustomer']);
		$this->load->view('master/header',$dataheader);
		$this->load->view('master/edittarif',$data);
		$this->load->view('footer',$datafooter);

	}
	public function hapus($id="",$kd_pelayanan="",$kd_kelas="",$tgl_berlaku=""){
		if(!$this->muser->isAkses("962")){
			$this->restricted();
			return false;
		}
		if(!empty($id)){
			$this->mmaster->delete('tarif','kd_jenis_tarif="'.$id.'" and kd_pelayanan="'.$kd_pelayanan.'" and kd_kelas="'.$kd_kelas.'" and tgl_berlaku="'.convertDate($tgl_berlaku).'"');
			redirect('/master/tarif');
		}
	}

	//backup simpan
	/*
		$kd_jenis_tarif=$this->input->post('kd_jenis_tarif');
		$kd_pelayanan=$this->input->post('kd_pelayanan');
		$kd_kelas=$this->input->post('kd_kelas');
		$cust_code=$this->input->post('cust_code');
		$tarif=$this->input->post('tarif');
		$tgl_berlaku=$this->input->post('tgl_berlaku');
		$tgl_berakhir=$this->input->post('tgl_berakhir');
		$kd_component=$this->input->post('component');

		if(!$this->mmaster->isExistTarifCustomer($kd_jenis_tarif,$cust_code)){
			$datatarifcustomer=array(
				'kd_jenis_tarif'=>$kd_jenis_tarif,
				'cust_code'=>$cust_code
				);
			$this->mmaster->insert('tarif_customers',$datatarifcustomer);
		}

		$totaltarif=0;
		foreach ($kd_component as $key => $value) {
			# code...
			if($this->mmaster->isExistComponentTarif($kd_jenis_tarif,$kd_pelayanan,$kd_kelas,convertDate($tgl_berlaku),$key)){
				$datakomponentarif=array(
					'kd_jenis_tarif'=>$kd_jenis_tarif,
					'kd_pelayanan'=>$kd_pelayanan,
					'kd_kelas'=>$kd_kelas,
					'kd_component'=>$key,
					'tgl_berlaku'=>convertDate($tgl_berlaku),
					'tarif_component'=>$value
				);				
				$this->mmaster->update('tarif_component',$datakomponentarif,'kd_jenis_tarif="'.$kd_jenis_tarif.'" and kd_pelayanan="'.$kd_pelayanan.'" and kd_kelas="'.$kd_kelas.'" and kd_component="'.$key.'" and tgl_berlaku="'.convertDate($tgl_berlaku).'"');
			}else{
				$datakomponentarif=array(
					'kd_jenis_tarif'=>$kd_jenis_tarif,
					'kd_pelayanan'=>$kd_pelayanan,
					'kd_kelas'=>$kd_kelas,
					'kd_component'=>$key,
					'tgl_berlaku'=>convertDate($tgl_berlaku),
					'tarif_component'=>$value
				);				
				$this->mmaster->insert('tarif_component',$datakomponentarif);				
			}
			$totaltarif=$totaltarif+$value;
		}

		if($this->mmaster->isExistTarif($kd_jenis_tarif,$kd_pelayanan,$kd_kelas,convertDate($tgl_berlaku))){
			$data=array(
				'kd_jenis_tarif'=>$kd_jenis_tarif,
				'kd_pelayanan'=>$kd_pelayanan,
				'kd_kelas'=>$kd_kelas,
				'tarif'=>$totaltarif,
				'tgl_berlaku'=>convertDate($tgl_berlaku),
				'tgl_berakhir'=>convertDate($tgl_berakhir)
			);
			$this->mmaster->update('tarif','kd_jenis_tarif="'.$kd_jenis_tarif.'" and kd_pelayanan="'.$kd_pelayanan.'" and kd_kelas="'.$kd_kelas.'" and tgl_berlaku="'.convertDate($tgl_berlaku).'"');

		}else{
			$data=array(
				'kd_jenis_tarif'=>$kd_jenis_tarif,
				'kd_pelayanan'=>$kd_pelayanan,
				'kd_kelas'=>$kd_kelas,
				'tarif'=>$totaltarif,
				'tgl_berlaku'=>convertDate($tgl_berlaku),
				'tgl_berakhir'=>convertDate($tgl_berakhir)
			);
			$this->mmaster->insert('tarif',$data);
		}
		$msg['pesan']="Data Berhasil Di Simpan";
		$msg['status']=1;

		echo json_encode($msg);
	*/
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */