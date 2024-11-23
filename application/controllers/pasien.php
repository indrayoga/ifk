<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

include_once(APPPATH.'controllers/rumahsakit.php');
class Pasien extends Rumahsakit {

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

	public function __construct()
	{
		parent::__construct();

		$this->load->model('pasien/mpasien');
		$this->load->model('master/mdaerah');
		//$x=$this->muser->isAkses($this->akses2);
		//debugvar($x);
	}
	public function index($kd_pasien="NULL",$nama_pasien="NULL",$periodeawal="NULL",$periodeakhir="NULL",$jns_kelamin="NULL",$nama_ayah="NULL",$nama_ibu="NULL",$nama_suami="NULL",$alamat="NULL")
	{
		if($this->input->post('kd_pasien')!='')$kd_pasien=$this->input->post('kd_pasien');
		if($this->input->post('nama_pasien')!='')$nama_pasien=$this->input->post('nama_pasien');
		if($this->input->post('jns_kelamin')!='')$jns_kelamin=$this->input->post('jns_kelamin');
		if($this->input->post('periodeawal')!='')$periodeawal=$this->input->post('periodeawal'); //else $periodeawal=date('d-m-Y');
		if($this->input->post('periodeakhir')!='')$periodeakhir=$this->input->post('periodeakhir'); //else $periodeakhir=date('d-m-Y');
		if($this->input->post('nama_ayah')!='')$nama_ayah=$this->input->post('nama_ayah');
		if($this->input->post('nama_ibu')!='')$nama_ibu=$this->input->post('nama_ibu');
		if($this->input->post('nama_suami')!='')$nama_pasien=$this->input->post('nama_suami');
		if($this->input->post('alamat')!='')$alamat=$this->input->post('alamat');

		$cssfileheader=array('bootstrap.min.css','bootstrap-responsive.min.css','font-awesome.min.css','style.css','prettify.css','jquery-ui.css','DT_bootstrap.css','responsive-tables.css','datepicker.css','theme.css');
		$jsfileheader=array('vendor/modernizr-2.6.2-respond-1.1.0.min.js',
							'vendor/jquery-1.9.1.min.js',
							//'vendor/jquery-migrate-1.1.1.min.js',
							'vendor/jquery-ui-1.10.0.custom.min.js',
							'vendor/bootstrap.min.js',
							'lib/jquery.tablesorter.min.js',
							'lib/jquery.dataTables.min.js',
							'lib/DT_bootstrap.js',
							'lib/responsive-tables.js',
							'lib/bootstrap-datepicker.js',
							'lib/bootstrap-inputmask.js',
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
			'periodeawal'=>$periodeawal,
			'periodeakhir'=>$periodeakhir,
			'kd_pasien'=>$kd_pasien,
			'nama_pasien'=>$nama_pasien,
			'nama_ayah'=>$nama_ayah,
			'nama_ibu'=>$nama_ibu,
			'nama_suami'=>$nama_suami,
			'alamat'=>$alamat,
			'jns_kelamin'=>$jns_kelamin,
			//'items'=>$this->mpasien->getAllPasien($kd_pasien,$nama_pasien,convertDate($periodeawal),convertDate($periodeakhir),$jns_kelamin,2,$this->uri->segment(9))
			);
		return $data;
 			
		//debugvar($this->pagination->create_links());
		/*
		$this->load->view($this->header,$dataheader);
		$this->load->view('pasien/daftarpasien',$data);
		$this->load->view('footer',$datafooter);
		*/
	}

	public function cekantrian(){
		$kd_dokter=$this->input->post('kd_dokter');
		$tanggal=$this->input->post('tanggal');
		$antrian=$this->mpasien->ambilNoAntrian($kd_dokter,convertDate($tanggal));
		$msg['antrian']=$antrian;
		echo json_encode($msg);
	}

	public function ajaxdatapasien($kd_pasien="NULL",$nama_pasien="NULL",$periodeawal="NULL",$periodeakhir="NULL",$jns_kelamin="NULL",$nama_ayah="NULL",$nama_ibu="NULL",$nama_suami="NULL",$alamat="NULL")
	{
		$this->datatables->select("kd_pasien,nama_pasien,jns_kelamin,alamat,kelurahan,tgl_lahir,nama_suami,nama_ayah,nama_ibu");
		$this->datatables->from("pasien a");
		$this->datatables->add_column('edit1', '<a class="btn btn-info" href="'.base_url().'index.php/pasien/editpasien/$1"><i class="icon-edit"></i> Edit</a>', 'kd_pasien,kd_pasien');		
		//$this->datatables->edit_column('edit', '<input type="checkbox" value="$1" class="checkedpasien" />', 'kd_pasien');
		if(!empty($kd_pasien) && $kd_pasien !='NULL')$this->datatables->like('kd_pasien',$kd_pasien,'both');
		if(!empty($nama_pasien) && $nama_pasien !='NULL')$this->datatables->like('nama_pasien',$nama_pasien,'both');
		if(!empty($jns_kelamin) && $jns_kelamin !='NULL')$this->datatables->where('jns_kelamin',$jns_kelamin);
		if(!empty($periodeawal) && $periodeawal !='NULL')$this->datatables->where('date(tgl_lahir)>=',convertDate($periodeawal));
		if(!empty($periodeakhir) && $periodeakhir !='NULL')$this->datatables->where('date(tgl_lahir)<=',convertDate($periodeakhir));
		if(!empty($nama_ayah) && $nama_ayah !='NULL')$this->datatables->like('nama_ayah',$nama_ayah,'both');
		if(!empty($nama_ibu) && $nama_ibu !='NULL')$this->datatables->like('nama_ibu',$nama_ibu,'both');
		if(!empty($nama_suami) && $nama_suami !='NULL')$this->datatables->like('nama_suami',$nama_suami,'both');
		if(!empty($alamat) && $alamat !='NULL')$this->datatables->like('alamat',$alamat,'both');

		$this->datatables->join('propinsi b','a.kd_propinsi=b.kd_propinsi','left');
		$this->datatables->join('kabupaten c','a.kd_kabupaten=c.kd_kabupaten','left');
		$this->datatables->join('kecamatan d','a.kd_kecamatan=d.kd_kecamatan','left');
		$this->datatables->join('kelurahan e','a.kd_kelurahan=e.kd_kelurahan','left');
		//$this->db->limit($limit,$offset);

		//$data['result'] = $this->datatables->generate();
		$results = $this->datatables->generate();
		//$data['aaData'] = $results['aaData']->;
		$x=json_decode($results);
		$b=$x->aaData;
		echo ($results);
	}
		
	public function tambahpasien($kd_pasien="")
	{
		if(!$this->muser->isAkses("302")){
			redirect('/home/restricted/');
			//redirect('/home/');
			//return false;			
		}
		/*
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
		*/
		$data=array(
			'datastatusnikah'=>$this->mpasien->ambilData('status_nikah'),			
			'dataagama'=>$this->mpasien->ambilData('agama'),			
			'datasuku'=>$this->mpasien->ambilData('suku'),
			'kd_pasien'=>$kd_pasien,
			'item'=>$this->mpasien->ambilItemData('pasien','kd_pasien="'.$kd_pasien.'"'),
			'datapekerjaan'=>$this->mpasien->ambilData('pekerjaan'),
			'datakabupaten'=>$this->mpasien->ambilData('kabupaten'),
			'datakecamatan'=>$this->mpasien->ambilData('kecamatan'),
			'datakelurahan'=>$this->mpasien->ambilData('kelurahan'),
			'datapropinsi'=>$this->mdaerah->ambilDataPropinsi(),
			'datapendidikan'=>$this->mpasien->ambilData('pendidikan')
		);
				return $data;
		
		//$this->load->view($this->header,$dataheader);
		//$this->load->view('pasien/tambahpasien',$data);
		//$this->load->view('footer',$datafooter);
		
	}
		
	public function editpasien($kd_pasien="")
	{
		if(!$this->muser->isAkses("309")){
			redirect('/home/restricted/');
			//redirect('/home/');
			//return false;			
		}
		/*
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
		*/
		$data=array(
			'datastatusnikah'=>$this->mpasien->ambilData('status_nikah'),			
			'dataagama'=>$this->mpasien->ambilData('agama'),			
			'datasuku'=>$this->mpasien->ambilData('suku'),
			'kd_pasien'=>$kd_pasien,
			'item'=>$this->mpasien->ambilItemData('pasien','kd_pasien="'.$kd_pasien.'"'),
			'datapekerjaan'=>$this->mpasien->ambilData('pekerjaan'),
			'datakabupaten'=>$this->mpasien->ambilData('kabupaten'),
			'datakecamatan'=>$this->mpasien->ambilData('kecamatan'),
			'datakelurahan'=>$this->mpasien->ambilData('kelurahan'),
			'datapropinsi'=>$this->mdaerah->ambilDataPropinsi(),
			'datapendidikan'=>$this->mpasien->ambilData('pendidikan')
		);
				return $data;
		
		//$this->load->view($this->header,$dataheader);
		//$this->load->view('pasien/tambahpasien',$data);
		//$this->load->view('footer',$datafooter);
		
	}	
	public function periksapasien()
	{
		$msg=array();
		$submit=$this->input->post('submit');
		$tanggal=$this->input->post('tanggal');
		$jam=$this->input->post('jam');
		$nama_pasien=$this->input->post('nama_pasien');
		$tempat_lahir=$this->input->post('tempat_lahir');
		$tgl_lahir=$this->input->post('tgl_lahir');
		$kd_agama=$this->input->post('kd_agama');
		$jumlaherror=0;
		$msg['status']=1;
		$msg['clearform']=0;
		$msg['pesanatas']="";
		$msg['pesanlain']="";

		if(empty($tanggal)){
			$jumlaherror++;
			$msg['id'][]="tanggal";
			$msg['pesan'][]="Tanggal Harus di Isi";
		}

		if(empty($jam)){
			$jumlaherror++;
			$msg['id'][]="jam";
			$msg['pesan'][]="Kolom Jam Harus di Isi";
		}

		if(empty($nama_pasien)){
			$jumlaherror++;
			$msg['id'][]="nama_pasien";
			$msg['pesan'][]="Nama Pasien Harus di Isi";
		}

		if(empty($tempat_lahir)){
			$jumlaherror++;
			$msg['id'][]="tempat_lahir";
			$msg['pesan'][]="Tempat Lahir Harus di Isi";
		}

		if(empty($tgl_lahir)){
			$jumlaherror++;
			$msg['id'][]="tgl_lahir";
			$msg['pesan'][]="Tanggal Lahir Harus di Isi";
		}

		if(empty($kd_agama)){
			$jumlaherror++;
			$msg['id'][]="kd_agama";
			$msg['pesan'][]="Agama Harus di Isi";
		}

		if($jumlaherror>0){
			$msg['status']=0;
			$msg['error']=$jumlaherror;
			$msg['pesanatas']="Terdapat beberapa kesalahan input silahkan cek inputan anda";
		}

		echo json_encode($msg);

	}

	public function simpanpasien()
	{
		$msg=array();
		//data diri pasien
		$kd_pasien=$this->input->post('kd_pasien');
		$tanggal=$this->input->post('tanggal');
		$jam=$this->input->post('jam');
		$biaya_kartu=$this->input->post('biaya_kartu');
		$tgl_membership=convertDate($tanggal).' '.$jam;
		$kd_unit_kerja=$this->input->post('kd_unit_kerja');
		$nama_pasien=$this->input->post('nama_pasien');
		$jns_kelamin=$this->input->post('jns_kelamin');
		$gol_darah=$this->input->post('gol_darah');
		$rhesus=$this->input->post('rhesus');
		$tempat_lahir=$this->input->post('tempat_lahir');
		$tgl_lahir=$this->input->post('tgl_lahir');
		$nama_ayah=$this->input->post('nama_ayah');
		$nama_ibu=$this->input->post('nama_ibu');

		//alamat pasien
		$alamat=$this->input->post('alamat');
		$rtrw=$this->input->post('rtrw');
		$kodepos=$this->input->post('kodepos');
		$telepon=$this->input->post('telepon');
		$kd_propinsi=($this->input->post('kd_propinsi') != FALSE) ? $this->input->post('kd_propinsi') : NULL;
		$kd_kabupaten=($this->input->post('kd_kabupaten') != FALSE) ? $this->input->post('kd_kabupaten') : NULL;
		$kd_kecamatan=($this->input->post('kd_kecamatan') != FALSE) ? $this->input->post('kd_kecamatan') : NULL;
		$kd_kelurahan=($this->input->post('kd_kelurahan') != FALSE) ? $this->input->post('kd_kelurahan') : NULL;

		//detail pasien
		$no_identitas=$this->input->post('no_identitas');
		$no_hp=$this->input->post('no_hp');
		$warga_negara=$this->input->post('warga_negara');
		$kd_pekerjaan=($this->input->post('kd_pekerjaan') != FALSE) ? $this->input->post('kd_pekerjaan') : NULL;
		$kd_pendidikan=($this->input->post('kd_pendidikan') != FALSE) ? $this->input->post('kd_pendidikan') : NULL;
		$kd_suku=($this->input->post('kd_suku') != FALSE) ? $this->input->post('kd_suku') : NULL;
		$kd_status_nikah=($this->input->post('kd_status_nikah') != FALSE) ? $this->input->post('kd_status_nikah') : NULL;
		$kd_agama=($this->input->post('kd_agama') != FALSE) ? $this->input->post('kd_agama') : NULL;

		//detail suami
		$nama_suami=$this->input->post('nama_suami');
		$tgl_lahir_suami=$this->input->post('tgl_lahir_suami');
		$alamat_suami=$this->input->post('alamat_suami');
		$pekerjaan_suami= ($this->input->post('pekerjaan_suami') != FALSE) ? $this->input->post('pekerjaan_suami') : NULL;
		$pendidikan_suami= ($this->input->post('pendidikan_suami') != FALSE) ? $this->input->post('pendidikan_suami') : NULL;
		$suku_suami=($this->input->post('suku_suami') != FALSE) ? $this->input->post('suku_suami') : NULL;
		$agama_suami=($this->input->post('agama_suami') != FALSE) ? $this->input->post('agama_suami') : NULL;

		$submit=$this->input->post('submit');

		$msg['kd_pasien']=$kd_pasien;
		$msg['nama_pasien']=$nama_pasien;

		$this->db->trans_start();
		if($this->mpasien->isNumberExist($kd_pasien)){
			$data_pasien_update=array(
				'kd_pasien'=>$kd_pasien,
				'kd_pendidikan'=>$kd_pendidikan,
				'no_identitas'=>$no_identitas,
				'tgl_membership'=>$tgl_membership,
				'nama_pasien'=>$nama_pasien,
				'tempat_lahir'=>$tempat_lahir,
				'tgl_lahir'=>convertDate($tgl_lahir),
				'jns_kelamin'=>$jns_kelamin,
				'kd_status_nikah'=>$kd_status_nikah,
				'kd_agama'=>$kd_agama,
				'kd_suku'=>$kd_suku,
				'alamat'=>$alamat,
				'telepon'=>$telepon,
				'kd_pekerjaan'=>$kd_pekerjaan,
				'no_hp'=>$no_hp,
				'warga_negara'=>$warga_negara,
				'gol_darah'=>$gol_darah,
				'rhesus'=>$rhesus,
				'kd_propinsi'=>$kd_propinsi,
				'kd_kabupaten'=>$kd_kabupaten,
				'kd_kecamatan'=>$kd_kecamatan,
				'kd_kelurahan'=>$kd_kelurahan,
				'rtrw'=>$rtrw,
				'nama_ayah'=>$nama_ayah,
				'nama_ibu'=>$nama_ibu,
				'nama_suami'=>$nama_suami,
				'tgl_lahir_suami'=>convertDate($tgl_lahir_suami),
				'pekerjaan_suami'=>$pekerjaan_suami,
				'pendidikan_suami'=>$pendidikan_suami,
				'alamat_suami'=>$alamat_suami,
				'agama_suami'=>$agama_suami,
				'suku_suami'=>$suku_suami,
				'kodepos'=>$kodepos
				);				
			$this->mpasien->update('pasien',$data_pasien_update,'kd_pasien="'.$kd_pasien.'"');		
			$msg['pesan']="Data Berhasil Di Update";

		}else{
			$tgl=explode("-", $tanggal);
			$jml_transaksi_bulan_ini=$this->mpasien->getJumlahTransaksiBulan();
			$no_transaksi=$jml_transaksi_bulan_ini+1;
			$no_transaksi=str_pad($no_transaksi,6,0,STR_PAD_LEFT);
			$kd_pasien=$no_transaksi;
			$msg['kd_pasien']=$kd_pasien;
			$data_pasien=array(
				'kd_pasien'=>$kd_pasien,
				'kd_pendidikan'=>$kd_pendidikan,
				'no_identitas'=>$no_identitas,
				'tgl_membership'=>$tgl_membership,
				'nama_pasien'=>$nama_pasien,
				'tempat_lahir'=>$tempat_lahir,
				'tgl_lahir'=>convertDate($tgl_lahir),
				'jns_kelamin'=>$jns_kelamin,
				'kd_status_nikah'=>$kd_status_nikah,
				'kd_agama'=>$kd_agama,
				'kd_suku'=>$kd_suku,
				'alamat'=>$alamat,
				'telepon'=>$telepon,
				'kd_pekerjaan'=>$kd_pekerjaan,
				'no_hp'=>$no_hp,
				'warga_negara'=>$warga_negara,
				'gol_darah'=>$gol_darah,
				'rhesus'=>$rhesus,
				'kd_propinsi'=>$kd_propinsi,
				'kd_kabupaten'=>$kd_kabupaten,
				'kd_kecamatan'=>$kd_kecamatan,
				'kd_kelurahan'=>$kd_kelurahan,
				'rtrw'=>$rtrw,
				'nama_ayah'=>$nama_ayah,
				'nama_ibu'=>$nama_ibu,
				'nama_suami'=>$nama_suami,
				'tgl_lahir_suami'=>convertDate($tgl_lahir_suami),
				'pekerjaan_suami'=>$pekerjaan_suami,
				'pendidikan_suami'=>$pendidikan_suami,
				'alamat_suami'=>$alamat_suami,
				'agama_suami'=>$agama_suami,
				'suku_suami'=>$suku_suami,
				'kodepos'=>$kodepos
				);				

			$this->mpasien->insert('pasien',$data_pasien);
			$msg['pesan']="Data Berhasil Di Simpan";
			//$this->cetakstruk($kd_pasien,$nama_pasien);			
		}
		$this->db->trans_complete();
		$msg['status']=1;
		$msg['keluar']=0;
		echo json_encode($msg);
	}


	public function cetakstruk($kd_pasien){
		$item=$this->mpasien->ambilItemData('pasien','kd_pasien="'.$kd_pasien.'"');
		$tmpdir = sys_get_temp_dir(); # ambil direktori temporary untuk simpan file. 
		$file = tempnam($tmpdir, 'struk'); # nama file temporary yang akan dicetak 
		$handle = fopen($file, 'w'); 
		$condensed = Chr(27) . Chr(33) . Chr(4); 
		$pagelength = Chr(27) . Chr(67) . Chr(48). Chr(6); 
		$bold1 = Chr(27) . Chr(69); 
		$bold0 = Chr(27) . Chr(70); 
		$initialized = chr(27).chr(64); 
		$condensed1 = chr(15); 
		$condensed0 = chr(18); 
		$right = chr(27).chr(97).chr(2); 
		$left = chr(27).chr(97).chr(0); 
		$center = chr(27).chr(97).chr(1); 
		$arrdata=array();
		$Data = $initialized; 
		$Data .= $condensed1; 
		//$Data .= $pagelength; 
		$Data .= "\n"; 
		$Data .= "POLIKLINIK IBNUSINA (MUARA RAPAK BALIKPAPAN)\n"; 
		$Data .= "Struk Untuk Pembuatan Kartu Baru\n"; 
		$Data .= "Tanggal Cetak : ".date('d-m-Y h:i:s')."    \n"; 
		$Data .= "No RM         : ".$item['kd_pasien']."             \n"; 
		$Data .= "Nama          : ".urldecode($item['nama_pasien'])."           \n"; 
		$Data .= "--------------Terima Kasih ----------------\n\n\n\n"; 
		//die($data);
		fwrite($handle, $Data); 
		fclose($handle); 
		//copy($file.'images/logo.png', "//192.168.1.3/EPSONLX"); # Lakukan cetak 
		copy($file, "//PLANET-IT/EPSONLX"); # Lakukan cetak 
		//copy($file, "//PLANET-IT/History"); # Lakukan cetak 
		unlink($file);
	}

	public function cetakstruk2($kd_pasien)
	{
		$msg=array();
		$item=$this->mpasien->ambilItemData('pasien','kd_pasien="'.$kd_pasien.'"');
		$tmpdir = sys_get_temp_dir(); # ambil direktori temporary untuk simpan file. 
		$file = tempnam($tmpdir, 'struk'); # nama file temporary yang akan dicetak 
		$handle = fopen($file, 'w'); 
		$condensed = Chr(27) . Chr(33) . Chr(4); 
		$pagelength = Chr(27) . Chr(67) . Chr(48). Chr(6); 
		$bold1 = Chr(27) . Chr(69); 
		$bold0 = Chr(27) . Chr(70); 
		$initialized = chr(27).chr(64); 
		$condensed1 = chr(15); 
		$condensed0 = chr(18); 
		$right = chr(27).chr(97).chr(2); 
		$left = chr(27).chr(97).chr(0); 
		$center = chr(27).chr(97).chr(1); 
		$arrdata=array();
		$Data = $initialized; 
		$Data .= $condensed1; 
		//$Data .= $pagelength; 
		$Data .= "\n"; 
		$Data .= "POLIKLINIK IBNUSINA (MUARA RAPAK BALIKPAPAN)\n"; 
		$Data .= "Struk Untuk Pembuatan Kartu Baru\n"; 
		$Data .= "Tanggal Cetak : ".date('d-m-Y h:i:s')."    \n"; 
		$Data .= "No RM         : ".$item['kd_pasien']."             \n"; 
		$Data .= "Nama          : ".urldecode($item['nama_pasien'])."           \n"; 
		$Data .= "--------------Terima Kasih ----------------\n\n\n\n"; 
		fwrite($handle, $Data); 
		fclose($handle); 
		//copy($file.'images/logo.png', "//192.168.1.3/EPSONLX"); # Lakukan cetak 
		copy($file, "//PLANET-IT/EPSONLX"); # Lakukan cetak 
		unlink($file);

		$msg['status']=1;
		$msg['pesanatas']="";

		echo json_encode($msg);

	}


	public function listpelayanan(){
		$cust=$this->input->post('cust');
		$kelas=$this->input->post('kelas');
		$unit=$this->input->post('unit');
		$items=$this->mpasien->getAllDataLayanan($cust,$kelas,$unit);

		echo json_encode($items);
	}

	public function listkamar(){
		$unit=$this->input->post('unit');
		$kelas=$this->input->post('kelas');
		$items=$this->mpasien->ambilDataKamar($unit,$kelas);

		echo json_encode($items);
	}

	public function listkasur(){
		$kamar=$this->input->post('kamar');
		$items=$this->mpasien->ambilDataKasur($kamar);

		echo json_encode($items);
	}

	public function ambildatakecamatan()
	{
		$q=$this->input->post('query');
		//$items=$this->mpengeluaran->ambilData('accounts','account like "%'.$q.'%" and type="d" and groups=5');
		$items=$this->mpasien->ambilData('kecamatan','kd_kabupaten = "'.$q.'"');

		echo json_encode($items);
	}

	public function ambildatakelurahan()
	{
		$q=$this->input->post('query');
		//$items=$this->mpengeluaran->ambilData('accounts','account like "%'.$q.'%" and type="d" and groups=5');
		$items=$this->mpasien->ambilData('kelurahan','kd_kecamatan = "'.$q.'"');

		echo json_encode($items);
	}

	public function hitungUmur(){
		$q=$this->input->post('query');
		if(empty($q)){
			$item['tahun']=0;
			$item['bulan']=0;
			$item['hari']=0;
		}else{
			$item=hitungumur($q);			
		}
		echo json_encode($item);
	}

	public function kabupatenpasien()
	{
		$q=$this->input->post('query');
		//$items=$this->mpengeluaran->ambilData('accounts','account like "%'.$q.'%" and type="d" and groups=5');
		$items=$this->mdaerah->ambilData('kabupaten','kd_propinsi = "'.$q.'"');

		echo json_encode($items);
	}	

	public function kecamatanpasien()
	{
		$q=$this->input->post('query');
		//$items=$this->mpengeluaran->ambilData('accounts','account like "%'.$q.'%" and type="d" and groups=5');
		$items=$this->mdaerah->ambilData('kecamatan','kd_kabupaten = "'.$q.'"');

		echo json_encode($items);
	}

	public function kelurahanpasien()
	{
		$q=$this->input->post('query');
		//$items=$this->mpengeluaran->ambilData('accounts','account like "%'.$q.'%" and type="d" and groups=5');
		$items=$this->mdaerah->ambilData('kelurahan','kd_kecamatan = "'.$q.'"');

		echo json_encode($items);
	}

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
