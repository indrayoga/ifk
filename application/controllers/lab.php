<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

include_once(APPPATH.'controllers/master/unit.php');
class Lab extends Unit {

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
	protected $akses='113';

	public function __construct()
	{
		parent::__construct();

		if(!$this->muser->isLogin()){
			redirect('/home/');
			return false;
		}

		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->helper('utilities');
		$this->load->library('pagination');

		$this->load->model('mpoli');
		$this->load->model('master/mlayanan');
		$this->load->model('reg/mrwj');
		
		$this->poli=$this->mpoli->getKdUnit();
		$this->namapoli=$this->mpoli->getUnit();

        $queryunitshift=$this->db->query('select * from unit_shift where kd_unit="RWJ"'); 
        $unitshift=$queryunitshift->row_array();
		$this->shift=$unitshift['shift'];
		
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

		$this->load->view('reg/rwj/header',$dataheader);
		$data=array();
		parent::view_restricted($data);
		$this->load->view('footer');
	}

	public function index($kd_pasien="NULL",$nama_pasien="NULL",$periodeawal="NULL",$periodeakhir="NULL",$jns_kelamin="NULL")
	{

		if(!$this->muser->isAkses("600")){
			$this->restricted();
			return false;
		}

		if($this->input->post('kd_pasien')!='')$kd_pasien=$this->input->post('kd_pasien');
		if($this->input->post('nama_pasien')!='')$nama_pasien=$this->input->post('nama_pasien');
		if($this->input->post('jns_kelamin')!='')$jns_kelamin=$this->input->post('jns_kelamin');
		if($this->input->post('periodeawal')!='')$periodeawal=$this->input->post('periodeawal'); else $periodeawal=date('d-m-Y');
		if($this->input->post('periodeakhir')!='')$periodeakhir=$this->input->post('periodeakhir'); else $periodeakhir=date('d-m-Y');

		$cssfileheader=array('bootstrap.css','bootstrap-responsive.min.css','font-awesome.min.css','style.css','prettify.css','jquery-ui.css','DT_bootstrap.css','responsive-tables.css','datepicker.css','theme.css');
		$jsfileheader=array('vendor/modernizr-2.6.2-respond-1.1.0.min.js',
							'vendor/jquery-1.9.1.min.js',
							'vendor/jquery-migrate-1.1.1.min.js',
							'vendor/jquery-ui-1.10.0.custom.min.js',
							'vendor/bootstrap.min.js',
							'lib/jquery.tablesorter.min.js',
							'lib/jquery.dataTables.min.js',
							'lib/bootstrap-datepicker.js',
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
			'jns_kelamin'=>$jns_kelamin			
			);
		//debugvar($this->pagination->create_links());
		$this->load->view('lab/header',$dataheader);
		$this->load->view('lab/daftar',$data);
		$this->load->view('footer',$datafooter);
	}

	public function pasienpoli($kd_pasien="NULL",$nama_pasien="NULL",$periodeawal="NULL",$periodeakhir="NULL",$jns_kelamin="NULL",$kd_dokter="NULL")
	{

		$this->datatables->select('a.no_pendaftaran as checkbox,a.tgl_pendaftaran,a.no_pendaftaran,a.kd_pasien,f.nama_pasien,c.nama_dokter,f.jns_kelamin,case when (g.no_pendaftaran is not null and b.kd_unit_kerja!="'.$this->poli.'" ) then i.nama_unit_kerja else b.nama_unit_kerja end as unit_kerja, case when (g.no_pendaftaran is not null and b.kd_unit_kerja!="'.$this->poli.'" ) then concat("Rujukan Dari ",h.nama_unit_kerja) else "" end as ket,CASE when is_baru_rs in (1) then "B" else "L" end as status,CASE when a.no_pendaftaran in (select no_pendaftaran from periksa_diagnosa) then "Pulang" else "Belum Pulang" end as stat ',false);
		$this->datatables->from("pendaftaran a");
		$this->datatables->add_column('pilihan', '<a class="btn btn-info" href="'.base_url().'index.php/lab/periksa/$2">Periksa</a>|| <a class="btn btn-info" href="'.base_url().'index.php/lab/hasillab/$1/$2">Input Hasil Lab</a>', 'a.kd_pasien,a.no_pendaftaran');		
		$this->datatables->edit_column('checkbox', '<input type="checkbox" value="$1" pasien="$2" class="checkedpasien" />', 'a.no_pendaftaran,a.kd_pasien');
		if(!empty($kd_dokter) && $kd_dokter !='NULL')$this->datatables->where('c.kd_dokter',$kd_dokter);
		if(!empty($kd_pasien) && $kd_pasien !='NULL')$this->datatables->like('a.kd_pasien',$kd_pasien,'both');
		if(!empty($nama_pasien) && $nama_pasien !='NULL')$this->datatables->like('nama_pasien',$nama_pasien,'both');
		if(!empty($jns_kelamin) && $jns_kelamin !='NULL')$this->datatables->where('jns_kelamin',$jns_kelamin);
		if(!empty($periodeawal) && $periodeawal !='NULL')$this->datatables->where('date(tgl_pendaftaran)>=',convertDate($periodeawal));
		if(!empty($periodeakhir) && $periodeakhir !='NULL')$this->datatables->where('date(tgl_pendaftaran)<=',convertDate($periodeakhir));
		$this->datatables->where('(b.kd_unit_kerja="102" or b.parent="10")');
		$this->datatables->join('pasien_rujukan g','a.no_pendaftaran=g.no_pendaftaran','left');
		$this->datatables->join('unit_kerja h','g.kd_unit_asal=h.kd_unit_kerja','left');
		$this->datatables->join('unit_kerja i','g.kd_unit_tujuan=i.kd_unit_kerja','left');
		$this->datatables->join('pasien f','a.kd_pasien=f.kd_pasien','left');
		$this->datatables->join('unit_kerja b','a.kd_unit_kerja=b.kd_unit_kerja','left');
		$this->datatables->join('apt_dokter c','a.kd_dokter=c.kd_dokter','left');
		$this->datatables->join('apt_customers d','a.cust_code=d.cust_code','left');

		//$this->db->order_by('a.tgl_pendaftaran','desc');

		//$data['result'] = $this->datatables->generate();
		$results = $this->datatables->generate();
		//$data['aaData'] = $results['aaData']->;
		$x=json_decode($results);
		$b=$x->aaData;
		echo ($results);
	}

	public function pasienigd($kd_pasien="NULL",$nama_pasien="NULL",$periodeawal="NULL",$periodeakhir="NULL",$jns_kelamin="NULL",$kd_dokter="NULL")
	{

		$this->datatables->select('a.no_pendaftaran as checkbox,a.tgl_pendaftaran,a.no_pendaftaran,a.kd_pasien,f.nama_pasien,c.nama_dokter,f.jns_kelamin,case when (g.no_pendaftaran is not null and b.kd_unit_kerja!="'.$this->poli.'" ) then i.nama_unit_kerja else b.nama_unit_kerja end as unit_kerja, case when (g.no_pendaftaran is not null and b.kd_unit_kerja!="'.$this->poli.'" ) then concat("Rujukan Dari ",h.nama_unit_kerja) else "" end as ket,CASE when is_baru_rs in (1) then "B" else "L" end as status,CASE when a.no_pendaftaran in (select no_pendaftaran from periksa_diagnosa) then "Pulang" else "Belum Pulang" end as stat ',false);
		$this->datatables->from("pendaftaran a");
		$this->datatables->add_column('pilihan', '<a class="btn btn-info" href="'.base_url().'index.php/lab/periksa/$2">Periksa</a>|| <a class="btn btn-info" href="'.base_url().'index.php/lab/hasillab/$1/$2">Input Hasil Lab</a>', 'a.kd_pasien,a.no_pendaftaran');		
		$this->datatables->edit_column('checkbox', '<input type="checkbox" value="$1" pasien="$2" class="checkedpasien" />', 'a.no_pendaftaran,a.kd_pasien');
		if(!empty($kd_dokter) && $kd_dokter !='NULL')$this->datatables->where('c.kd_dokter',$kd_dokter);
		if(!empty($kd_pasien) && $kd_pasien !='NULL')$this->datatables->like('a.kd_pasien',$kd_pasien,'both');
		if(!empty($nama_pasien) && $nama_pasien !='NULL')$this->datatables->like('nama_pasien',$nama_pasien,'both');
		if(!empty($jns_kelamin) && $jns_kelamin !='NULL')$this->datatables->where('jns_kelamin',$jns_kelamin);
		if(!empty($periodeawal) && $periodeawal !='NULL')$this->datatables->where('date(tgl_pendaftaran)>=',convertDate($periodeawal));
		if(!empty($periodeakhir) && $periodeakhir !='NULL')$this->datatables->where('date(tgl_pendaftaran)<=',convertDate($periodeakhir));
		//$this->datatables->where('(b.kd_unit_kerja="'.$this->poli.'" or g.kd_unit_tujuan="'.$this->poli.'")');
		$this->datatables->where('b.kd_unit_kerja','100');
		$this->datatables->join('pasien_rujukan g','a.no_pendaftaran=g.no_pendaftaran','left');
		$this->datatables->join('unit_kerja h','g.kd_unit_asal=h.kd_unit_kerja','left');
		$this->datatables->join('unit_kerja i','g.kd_unit_tujuan=i.kd_unit_kerja','left');
		$this->datatables->join('pasien f','a.kd_pasien=f.kd_pasien','left');
		$this->datatables->join('unit_kerja b','a.kd_unit_kerja=b.kd_unit_kerja','left');
		$this->datatables->join('apt_dokter c','a.kd_dokter=c.kd_dokter','left');
		$this->datatables->join('apt_customers d','a.cust_code=d.cust_code','left');

		//$this->db->order_by('a.tgl_pendaftaran','desc');

		//$data['result'] = $this->datatables->generate();
		$results = $this->datatables->generate();
		//$data['aaData'] = $results['aaData']->;
		$x=json_decode($results);
		$b=$x->aaData;
		echo ($results);
	}

	public function pasienrwi($kd_pasien="NULL",$nama_pasien="NULL",$periodeawal="NULL",$periodeakhir="NULL",$jns_kelamin="NULL",$kd_dokter="NULL")
	{

		$this->datatables->select('a.no_pendaftaran as checkbox,a.tgl_pendaftaran,a.no_pendaftaran,a.kd_pasien,f.nama_pasien,c.nama_dokter,f.jns_kelamin,case when (g.no_pendaftaran is not null and b.kd_unit_kerja!="'.$this->poli.'" ) then i.nama_unit_kerja else b.nama_unit_kerja end as unit_kerja, case when (g.no_pendaftaran is not null and b.kd_unit_kerja!="'.$this->poli.'" ) then concat("Rujukan Dari ",h.nama_unit_kerja) else "" end as ket,CASE when is_baru_rs in (1) then "B" else "L" end as status,CASE when a.no_pendaftaran in (select no_pendaftaran from periksa_diagnosa) then "Pulang" else "Belum Pulang" end as stat ',false);
		$this->datatables->from("pendaftaran a");
		$this->datatables->add_column('pilihan', '<a class="btn btn-info" href="'.base_url().'index.php/lab/periksa/$2">Periksa</a>|| <a class="btn btn-info" href="'.base_url().'index.php/lab/hasillab/$1/$2">Input Hasil Lab</a>', 'a.kd_pasien,a.no_pendaftaran');		
		$this->datatables->edit_column('checkbox', '<input type="checkbox" value="$1" pasien="$2" class="checkedpasien" />', 'a.no_pendaftaran,a.kd_pasien');
		if(!empty($kd_dokter) && $kd_dokter !='NULL')$this->datatables->where('c.kd_dokter',$kd_dokter);
		if(!empty($kd_pasien) && $kd_pasien !='NULL')$this->datatables->like('a.kd_pasien',$kd_pasien,'both');
		if(!empty($nama_pasien) && $nama_pasien !='NULL')$this->datatables->like('nama_pasien',$nama_pasien,'both');
		if(!empty($jns_kelamin) && $jns_kelamin !='NULL')$this->datatables->where('jns_kelamin',$jns_kelamin);
		if(!empty($periodeawal) && $periodeawal !='NULL')$this->datatables->where('date(tgl_pendaftaran)>=',convertDate($periodeawal));
		if(!empty($periodeakhir) && $periodeakhir !='NULL')$this->datatables->where('date(tgl_pendaftaran)<=',convertDate($periodeakhir));
		//$this->datatables->where('(b.kd_unit_kerja="'.$this->poli.'" or g.kd_unit_tujuan="'.$this->poli.'")');
		$this->datatables->where('b.parent','10');
		$this->datatables->join('pasien_rujukan g','a.no_pendaftaran=g.no_pendaftaran','left');
		$this->datatables->join('unit_kerja h','g.kd_unit_asal=h.kd_unit_kerja','left');
		$this->datatables->join('unit_kerja i','g.kd_unit_tujuan=i.kd_unit_kerja','left');
		$this->datatables->join('pasien f','a.kd_pasien=f.kd_pasien','left');
		$this->datatables->join('unit_kerja b','a.kd_unit_kerja=b.kd_unit_kerja','left');
		$this->datatables->join('apt_dokter c','a.kd_dokter=c.kd_dokter','left');
		$this->datatables->join('apt_customers d','a.cust_code=d.cust_code','left');

		//$this->db->order_by('a.tgl_pendaftaran','desc');

		//$data['result'] = $this->datatables->generate();
		$results = $this->datatables->generate();
		//$data['aaData'] = $results['aaData']->;
		$x=json_decode($results);
		$b=$x->aaData;
		echo ($results);
	}

	public function rawatinap($kd_pasien="NULL",$nama_pasien="NULL",$periodeawal="NULL",$periodeakhir="NULL",$jns_kelamin="NULL")
	{
		if($this->input->post('kd_pasien')!='')$kd_pasien=$this->input->post('kd_pasien');
		if($this->input->post('nama_pasien')!='')$nama_pasien=$this->input->post('nama_pasien');
		if($this->input->post('jns_kelamin')!='')$jns_kelamin=$this->input->post('jns_kelamin');
		if($this->input->post('periodeawal')!='')$periodeawal=$this->input->post('periodeawal'); 
		if($this->input->post('periodeakhir')!='')$periodeakhir=$this->input->post('periodeakhir');

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
			'jns_kelamin'=>$jns_kelamin			
		);
		//debugvar($this->pagination->create_links());
		$this->load->view('lab/header',$dataheader);
		$this->load->view('lab/daftarinap',$data);
		$this->load->view('footer',$datafooter);	
	}

	public function rawatigd($kd_pasien="NULL",$nama_pasien="NULL",$periodeawal="NULL",$periodeakhir="NULL",$jns_kelamin="NULL")
	{
		if($this->input->post('kd_pasien')!='')$kd_pasien=$this->input->post('kd_pasien');
		if($this->input->post('nama_pasien')!='')$nama_pasien=$this->input->post('nama_pasien');
		if($this->input->post('jns_kelamin')!='')$jns_kelamin=$this->input->post('jns_kelamin');
		if($this->input->post('periodeawal')!='')$periodeawal=$this->input->post('periodeawal'); else $periodeawal=date('d-m-Y');
		if($this->input->post('periodeakhir')!='')$periodeakhir=$this->input->post('periodeakhir'); else $periodeakhir=date('d-m-Y');

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
			'jns_kelamin'=>$jns_kelamin
			);
		//debugvar($this->pagination->create_links());
		$this->load->view('lab/header',$dataheader);
		$this->load->view('lab/daftarigd',$data);
		$this->load->view('footer',$datafooter);	
	}

	public function periksa($no_pendaftaran="")
	{
		if(!$this->muser->isAkses("602")){
			$this->restricted();
			return false;
		}

		//if(empty($kd_pasien))return false;
		$cssfileheader=array('bootstrap.css','bootstrap-responsive.min.css','font-awesome.min.css','style.css','prettify.css','jquery-ui.css','DT_bootstrap.css','responsive-tables.css','datepicker.css','timepicker.css','theme.css');
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

		$this->mrwj->setPasien($no_pendaftaran);
		$this->pasien=$this->mrwj->pasien;
		//var_dump($this->pasien);
		$data=array(
			'datapelayanan'=>$this->mlayanan->getTarifLayanan(),			
			'datadokter'=>$this->mpoli->getDokterUnit(),
			'datajenisdiagnosa'=>$this->mpoli->ambilData('jenis_diagnosa'),
			//'item'=>$this->mpoli->getItemDaftarPasien($no_pendaftaran,$kd_pasien),
			'itemslayanan'=>$this->mrwj->pelayananpasien(),
			'itemsdiagnosa'=>$this->mrwj->diagnosapasien(),
			'no_pendaftaran'=>$no_pendaftaran
		);
		$this->load->view('lab/header',$dataheader);
		$this->load->view('reg/poli/periksapasien',$data);
		$this->load->view('footer',$datafooter);
	}

	public function daftarperiksapasien($kd_pasien="NULL",$nama_pasien="NULL",$periodeawal="NULL",$periodeakhir="NULL",$jns_kelamin="NULL",$unit="")
	{
		if($this->input->post('unit')!='')$unit=$this->input->post('unit');
		if($this->input->post('kd_pasien')!='')$kd_pasien=$this->input->post('kd_pasien');
		if($this->input->post('nama_pasien')!='')$nama_pasien=$this->input->post('nama_pasien');
		if($this->input->post('jns_kelamin')!='')$jns_kelamin=$this->input->post('jns_kelamin');
		if($this->input->post('periodeawal')!='')$periodeawal=$this->input->post('periodeawal'); else $periodeawal=date('d-m-Y');
		if($this->input->post('periodeakhir')!='')$periodeakhir=$this->input->post('periodeakhir'); else $periodeakhir=date('d-m-Y');

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
			'jns_kelamin'=>$jns_kelamin,
			'unit'=>$unit,
			'items'=>$this->mpoli->getAllPeriksaPasienLab($kd_pasien,$nama_pasien,convertDate($periodeawal),convertDate($periodeakhir),$jns_kelamin,$unit)
			);
		//debugvar($this->pagination->create_links());
		$this->load->view('lab/header',$dataheader);
		$this->load->view('lab/daftarperiksapasien',$data);
		$this->load->view('footer',$datafooter);	
	}

	public function itempelayanan($pelayanan="")
	{

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
		$qpelayanan=$this->db->query('select *,b.kode_mapping,b.kode_item_lab,b.nama_item_lab from lab_item_pelayanan a join (SELECT anak.kode_mapping,anak.kode_item_lab, COUNT( induk.kode_mapping )
				LEVEL , CONCAT( REPEAT( "--", (
				COUNT( induk.kode_mapping ) -1 ) ) , itemlab.nama_item_lab
				) AS nama_item_lab, anak.kiri, anak.kanan
				FROM lab_mapping_item AS induk, (

				SELECT *
				FROM lab_mapping_item
				) AS anak, lab_item_lab AS itemlab
				WHERE anak.kiri
				BETWEEN induk.kiri
				AND induk.kanan
				AND anak.kode_item_lab = itemlab.kode_item_lab
				GROUP BY anak.kode_mapping
				ORDER BY `anak`.`kode_mapping` ASC) as b on a.kode_mapping=b.kode_mapping join list_pelayanan c on a.kd_pelayanan=c.kd_pelayanan where a.kd_pelayanan="'.$pelayanan.'" ');
		$data=array(
			'datapelayanan'=>$this->mrwj->ambilData('list_pelayanan','kd_jenis_pelayanan="15"'),
			'dataitemlab'=>$this->mpoli->getAllItemTest(),
			'dataitempelayanan'=>$qpelayanan->result_array(),
			'layanan'=>$pelayanan
			);

		//debugvar($data['dataitemlab']);

		$this->load->view('lab/header',$dataheader);
		$this->load->view('lab/itempelayanan',$data);
		$this->load->view('footer',$datafooter);

	}

	public function itemlab(){
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
			'items'=>$this->mrwj->ambilData('lab_item_lab')
			);
		//debugvar($this->pagination->create_links());
		$this->load->view('lab/header',$dataheader);
		$this->load->view('lab/itemlab',$data);
		$this->load->view('footer',$datafooter);
	}

	public function updatehemarefrange(){
		$kode_ref_range=$this->input->post('kode_ref_range');
		$kode_item_lab=$this->input->post('kode_item_lab');
		$jenis_umur=$this->input->post('jenis_umur');
		$batas_awal=$this->input->post('batas_awal');
		$batas_akhir=$this->input->post('batas_akhir');
		$jenis_kelamin=$this->input->post('jenis_kelamin');
		$nilai_normal=$this->input->post('nilai_normal');
		$satuan=$this->input->post('satuan');

		if($jenis_kelamin=='NULL'){
			$data=array(
				'kode_item_lab'=>$kode_item_lab,
				'jenis_umur'=>$jenis_umur,
				'batas_awal'=>$batas_awal,
				'batas_akhir'=>$batas_akhir,
				'nilai_normal'=>$nilai_normal,
				'satuan'=>$satuan
				);

		}else{
			$data=array(
				'kode_item_lab'=>$kode_item_lab,
				'jenis_umur'=>$jenis_umur,
				'batas_awal'=>$batas_awal,
				'batas_akhir'=>$batas_akhir,
				'jenis_kelamin'=>$jenis_kelamin,
				'nilai_normal'=>$nilai_normal,
				'satuan'=>$satuan
				);

		}
		$this->mrwj->update('lab_hematology_ref_range',$data,'kode_ref_range="'.$kode_ref_range.'" ');

		$msg['pesan']="Data Berhasil Di Simpan";
		$msg['status']=1;

		echo json_encode($msg);
	}

	public function simpanhemarefrange(){
		$kode_item_lab=$this->input->post('kode_item_lab');
		$jenis_umur=$this->input->post('jenis_umur');
		$batas_awal=$this->input->post('batas_awal');
		$batas_akhir=$this->input->post('batas_akhir');
		$jenis_kelamin=$this->input->post('jenis_kelamin');
		$nilai_normal=$this->input->post('nilai_normal');
		$satuan=$this->input->post('satuan');

		if($jenis_kelamin=='NULL'){
			$data=array(
				'kode_item_lab'=>$kode_item_lab,
				'jenis_umur'=>$jenis_umur,
				'batas_awal'=>$batas_awal,
				'batas_akhir'=>$batas_akhir,
				'nilai_normal'=>$nilai_normal,
				'satuan'=>$satuan
				);

		}else{
			$data=array(
				'kode_item_lab'=>$kode_item_lab,
				'jenis_umur'=>$jenis_umur,
				'batas_awal'=>$batas_awal,
				'batas_akhir'=>$batas_akhir,
				'jenis_kelamin'=>$jenis_kelamin,
				'nilai_normal'=>$nilai_normal,
				'satuan'=>$satuan
				);

		}
		$this->mrwj->insert('lab_hematology_ref_range',$data);

		$msg['pesan']="Data Berhasil Di Simpan";
		$msg['status']=1;

		echo json_encode($msg);
	}

	public function hapushemarefrange($kode){

		$this->mrwj->delete('lab_hematology_ref_range','kode_ref_range="'.$kode.'"');

		$msg['pesan']="Data Berhasil Di hapus";
		$msg['status']=1;

		redirect('/poli/lab/hemarefrange');
	}

	public function hemarefrange(){
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
			'items'=>$this->poli->hemarefrange()
			);
		//debugvar($this->pagination->create_links());
		$this->load->view('lab/header',$dataheader);
		$this->load->view('lab/hemarefrange',$data);
		$this->load->view('footer',$datafooter);
	}

	public function edithemarefrange($kode){
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
			'item'=>$this->mrwj->ambilItemData('lab_hematology_ref_range','kode_ref_range="'.$kode.'" '),
			'dataitemlab'=>$this->mrwj->ambilData('lab_item_lab')
			);
		//debugvar($this->pagination->create_links());
		$this->load->view('lab/header',$dataheader);
		$this->load->view('lab/edithemarefrange',$data);
		$this->load->view('footer',$datafooter);
	}

	public function tambahhemarefrange(){
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
			'dataitemlab'=>$this->mrwj->ambilData('lab_item_lab')
			);
		//debugvar($this->pagination->create_links());
		$this->load->view('lab/header',$dataheader);
		$this->load->view('lab/tambahhemarefrange',$data);
		$this->load->view('footer',$datafooter);
	}

	public function kategorinilainormal(){
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
			'items'=>$this->mrwj->ambilData('lab_kategori_nilai_normal')
			);
		//debugvar($this->pagination->create_links());
		$this->load->view('lab/header',$dataheader);
		$this->load->view('lab/kategorinilainormal',$data);
		$this->load->view('footer',$datafooter);
	}

	public function nilainormal(){
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
		$query=$this->db->query('select * from lab_nilai_normal a join lab_item_lab b on a.kode_item_lab=b.kode_item_lab join lab_kategori_nilai_normal c on a.kode_kategori=c.kode_kategori');

		$data=array(
			'items'=>$query->result_array()
			);
		//debugvar($this->pagination->create_links());
		$this->load->view('lab/header',$dataheader);
		$this->load->view('lab/nilainormal',$data);
		$this->load->view('footer',$datafooter);
	}

	public function tambahitemlab(){
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
			'items'=>$this->mrwj->ambilData('lab_item_lab')
			);
		//debugvar($this->pagination->create_links());
		$this->load->view('lab/header',$dataheader);
		$this->load->view('lab/tambahitemlab',$data);
		$this->load->view('footer',$datafooter);
	}

	public function tambahkategorinilainormal(){
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
			);
		//debugvar($this->pagination->create_links());
		$this->load->view('lab/header',$dataheader);
		$this->load->view('lab/tambahkategorinilainormal',$data);
		$this->load->view('footer',$datafooter);
	}

	public function tambahnilainormal($kode_item_lab="",$kode_kategori=""){
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
			'item'=>$this->mrwj->ambilItemData('lab_nilai_normal','kode_item_lab="'.$kode_item_lab.'" and kode_kategori="'.$kode_kategori.'"'),
			'dataitemlab'=>$this->mrwj->ambilData('lab_item_lab'),
			'datakategori'=>$this->mrwj->ambilData('lab_kategori_nilai_normal')
			);
		//debugvar($this->pagination->create_links());
		$this->load->view('lab/header',$dataheader);
		$this->load->view('lab/tambahnilainormal',$data);
		$this->load->view('footer',$datafooter);
	}

	public function edititemlab($kode){
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
			'kode'=>$kode,
			'itemlab'=>$this->mrwj->ambilItemData('lab_item_lab','kode_item_lab="'.$kode.'"'),
			'items'=>$this->mrwj->ambilData('lab_item_lab')
			);
		//debugvar($this->pagination->create_links());
		$this->load->view('lab/header',$dataheader);
		$this->load->view('lab/edititemlab',$data);
		$this->load->view('footer',$datafooter);
	}

	public function editkategorinilainormal($kode){
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
			'kode'=>$kode,
			'item'=>$this->mrwj->ambilItemData('lab_kategori_nilai_normal','kode_kategori="'.$kode.'"')
			);
		//debugvar($this->pagination->create_links());
		$this->load->view('lab/header',$dataheader);
		$this->load->view('lab/editkategorinilainormal',$data);
		$this->load->view('footer',$datafooter);
	}

	public function periksaitemlab()
	{
		$msg=array();
		$submit=$this->input->post('submit');
		$kode_item_lab=$this->input->post('kode_item_lab');
		$nama_item_lab=$this->input->post('nama_item_lab');
		$parent=$this->input->post('parent');
		$jumlaherror=0;
		$msg['status']=1;
		$msg['clearform']=0;
		$msg['pesanatas']="";
		$msg['pesanlain']="";

		if(empty($kode_item_lab)){
			$jumlaherror++;
			$msg['id'][]="kode_item_lab";
			$msg['pesan'][]="Kode Harus di Isi";
		}

		if(empty($nama_item_lab)){
			$jumlaherror++;
			$msg['id'][]="nama_item_lab";
			$msg['pesan'][]="Nama item Harus di Isi";
		}

		if($jumlaherror>0){
			$msg['status']=0;
			$msg['error']=$jumlaherror;
			$msg['pesanatas']="Terdapat beberapa kesalahan input silahkan cek inputan anda";
		}

		echo json_encode($msg);

	}

	public function periksakategorinilainormal()
	{
		$msg=array();
		$submit=$this->input->post('submit');
		$kategori=$this->input->post('kategori');
		$satuan=$this->input->post('satuan');
		$jumlaherror=0;
		$msg['status']=1;
		$msg['clearform']=0;
		$msg['pesanatas']="";
		$msg['pesanlain']="";

		if(empty($kategori)){
			$jumlaherror++;
			$msg['id'][]="kategori";
			$msg['pesan'][]="Kategori Harus di Isi";
		}

		if(empty($satuan)){
			$jumlaherror++;
			$msg['id'][]="satuan";
			$msg['pesan'][]="Satuan Harus di Isi";
		}

		if($jumlaherror>0){
			$msg['status']=0;
			$msg['error']=$jumlaherror;
			$msg['pesanatas']="Terdapat beberapa kesalahan input silahkan cek inputan anda";
		}

		echo json_encode($msg);

	}

	public function simpanitemlab(){
		$kode_item_lab=$this->input->post('kode_item_lab');
		$nama_item_lab=$this->input->post('nama_item_lab');
		$parent=$this->input->post('parent');
		$data=array(
			'kode_item_lab'=>$kode_item_lab,
			'nama_item_lab'=>$nama_item_lab,
			'parent'=>$parent
			);
		$this->mrwj->insert('lab_item_lab',$data);

		$msg['pesan']="Data Berhasil Di Simpan";
		$msg['status']=1;

		echo json_encode($msg);
	}

	public function simpannilainormal(){
		$kode_item_lab=$this->input->post('kode_item_lab');
		$kode_kategori=$this->input->post('kode_kategori');
		$nilai_normal=$this->input->post('nilai_normal');
		
		$this->db->query('replace into lab_nilai_normal(kode_item_lab,kode_kategori,nilai_normal) values("'.$kode_item_lab.'","'.$kode_kategori.'","'.$nilai_normal.'")');

		$msg['pesan']="Data Berhasil Di Simpan";
		$msg['status']=1;

		echo json_encode($msg);
	}

	public function simpanitempelayanan()
	{
		$msg=array();
		$kd_pelayanan=$this->input->post('kd_pelayanan');
		$itempelayanan=$this->input->post('itempelayanan');
		//debugvar($itempelayanan);
		$this->db->trans_start();

		$this->db->query("delete from lab_item_pelayanan where kd_pelayanan='".$kd_pelayanan."' ");
		if(!empty($itempelayanan)){
			foreach ($itempelayanan as $pelayanan) {
				# code...
				$this->db->query('replace into lab_item_pelayanan(kd_pelayanan,kode_mapping) values("'.$kd_pelayanan.'","'.$pelayanan.'")');
			}			
		}

		$this->db->trans_complete();

		$msg['status']=1;
		$msg['pesan']="Data Berhasil Di Update";

		echo json_encode($msg);
	}

	public function simpankategorinilainormal(){
		$kategori=$this->input->post('kategori');
		$satuan=$this->input->post('satuan');
		$data=array(
			'kategori'=>$kategori,
			'satuan'=>$satuan
			);
		$this->mrwj->insert('lab_kategori_nilai_normal',$data);

		$msg['pesan']="Data Berhasil Di Simpan";
		$msg['status']=1;

		echo json_encode($msg);
	}

	public function simpanhasillab(){
		$jns_kelamin=$this->input->post('jns_kelamin');
		$no_pendaftaran=$this->input->post('no_pendaftaran');
		$tanggaldaftar=$this->input->post('tanggaldaftar');
		$tanggal=$this->input->post('tanggal');
		$tanggal_cetak=$this->input->post('tanggal_cetak');
		$jam=$this->input->post('jam');
		$jam_cetak=$this->input->post('jam_cetak');
		$jenis_pemeriksaan=$this->input->post('jenis_pemeriksaan');
		$itemlab=$this->input->post('itemlab');
		$itemmapping=$this->input->post('itemmapping');
		$lab_pemeriksa=$this->input->post('lab_pemeriksa');
		$lab_checker=$this->input->post('lab_checker');
		$reglab=$this->input->post('no_reg_lab');
			//debugvar($itemlab);
		$this->db->trans_start();
		if(!empty($reglab)){
		$dataperiksapasien=array(
			'no_pendaftaran'=>$no_pendaftaran,
			'tanggal_masuk'=>$tanggaldaftar,
			'tanggal_periksa'=>convertDate($tanggal).' '.$jam,
			'lab_pemeriksa'=>$lab_pemeriksa,
			'tanggal_cetak'=>convertDate($tanggal_cetak).' '.$jam_cetak,			
			'lab_checker'=>$lab_checker,
			'jenis_pemeriksaan'=>$jenis_pemeriksaan
			);
		$this->mrwj->update('lab_periksa_pasien',$dataperiksapasien,'no_reg_lab="'.$reglab.'"');
		$no_reg_lab=$reglab;
		}else{
		$dataperiksapasien=array(
			'no_pendaftaran'=>$no_pendaftaran,
			'tanggal_masuk'=>$tanggaldaftar,
			'tanggal_periksa'=>convertDate($tanggal).' '.$jam,
			'lab_pemeriksa'=>$lab_pemeriksa,
			'lab_checker'=>$lab_checker
			);
		$no_reg_lab=$this->mrwj->insert('lab_periksa_pasien',$dataperiksapasien);

		}
		
		$updatelabbiayapelayanan=array('lab'=>1);
		$this->mrwj->update('biaya_pelayanan',$updatelabbiayapelayanan,'no_pendaftaran="'.$no_pendaftaran.'" and lab=0 ');
		//debugvar($itemlab);
		$this->mrwj->delete('lab_hasil_lab',"no_reg_lab='".$no_reg_lab."'");
		foreach ($itemlab as $kd_pelayanan => $value) {
			# code...
			//debugvar($value);
			//if(empty($value['kd_item_lab']))continue;
			$x=0;
			foreach ($value['kd_item_lab'] as $kd_item_lab) {
				//debugvar($value['kd_item_lab']);
			//if($value[$kd_item_lab]['hasil']=="")continue;
			//if(!isset($value[$kd_item_lab]['hasil']))continue;
			//if(isset($value[$kd_item_lab]['hasil']) && $value[$kd_item_lab]['hasil']=="")continue;
			if(!isset($value[$kd_item_lab]['hasil'])){
				$value[$kd_item_lab]['hasil']="";
				$value[$kd_item_lab]['keterangan']="";
				$value[$kd_item_lab]['status']="";
			}
				//debugvar($value[$kd_item_lab]);
				# code...
				$nilainormal[0]="";
				$nilainormal[1]="";
				$nilainormal[2]="";
				$nilainormal[3]="";
				if(!empty($value[$kd_item_lab]['nilai_normal'])){
					$nilainormal=explode("#", $value[$kd_item_lab]['nilai_normal']);					
				}

				$this->db->query('replace into lab_hasil_lab values("'.$no_reg_lab.'","'.$no_pendaftaran.'","'.$kd_pelayanan.'","'.$kd_item_lab.'","'.$itemmapping[$kd_pelayanan]['kd_item_lab'][$x].'","'.$jns_kelamin.'","'.$value[$kd_item_lab]['hasil'].'","'.$value[$kd_item_lab]['keterangan'].'","'.$value[$kd_item_lab]['status'].'","'.$nilainormal[2].'","'.$nilainormal[3].'")');
				$x++;
			}
		}

		$this->db->trans_complete();

		$msg['pesan']="Data Berhasil Di Simpan";
		$msg['status']=1;
		$msg['no_reg_lab']=$no_reg_lab;

		echo json_encode($msg);
	}

	public function cetakhasillab($nocm='',$no_pendaftaran='',$noreglab='')
	{
		date_default_timezone_set("Asia/Jakarta"); 
		//debugvar(date('H:i:s'));
		$data=array(
		//	'tanggal_cetak'=>date('Y-m-d H:i:s')
			);

		$hari=array('Sunday'=>'Minggu','Monday'=>'Senin','Tuesday'=>'Selasa','Wednesday'=>'Rabu','Thursday'=>'Kamis','Friday'=>'Jumat','Saturday'=>'Sabtu');

		$msg=array();
		//$items=array();
		//$item=$this->mrwj->getItemDaftarPasien($no_pendaftaran,$nocm);
		$this->mrwj->setPasien($no_pendaftaran);
		$this->pasien=$this->mrwj->pasien;

		$itemperiksapasien=$this->mrwj->ambilItemData('lab_periksa_pasien','no_reg_lab="'.$noreglab.'"');
		$tanggalperiksa=explode(" ", $itemperiksapasien['tanggal_periksa']);
		$tanggalcetak=explode(" ", $itemperiksapasien['tanggal_cetak']);
		$row=0;
		//$item=$this->mloket->getDetilRegister($id);
		//$profil=$this->mloket->ambilItemData('lab_profil');
		$this->load->library('phpexcel'); 
		$this->load->library('PHPExcel/iofactory');
		$objPHPExcel = new PHPExcel(); 
		$objPHPExcel->getProperties()->setTitle("title")->setDescription("description");

		//set lebar kolom
		$objPHPExcel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);
		$objPHPExcel->getActiveSheet()->getPageSetup()->setFitToPage(true);		
		$objPHPExcel->getActiveSheet()->getPageSetup()->setScale(90);
		$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(0)->setWidth(8,71);
		$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(1)->setWidth(11,29);
		$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(2)->setWidth(7,86);
		$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(3)->setWidth(10,57);
		$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(4)->setWidth(25,43);
		$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(5)->setWidth(11);
		$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(6)->setWidth(24);
		
		$gdImage = imagecreatefromjpeg('./images/logo.jpg');
		// Add a drawing to the worksheetecho date('H:i:s') . " Add a drawing to the worksheet\n";
		$objDrawing = new PHPExcel_Worksheet_MemoryDrawing();
		$objDrawing->setName('Logo');
		$objDrawing->setDescription('Logo');
		$objDrawing->setImageResource($gdImage);
		$objDrawing->setRenderingFunction(PHPExcel_Worksheet_MemoryDrawing::RENDERING_JPEG);
		$objDrawing->setMimeType(PHPExcel_Worksheet_MemoryDrawing::MIMETYPE_DEFAULT);
		$objDrawing->setHeight(50);
		$objDrawing->setWidth(70);
		$objDrawing->setOffsetX(30);    // setOffsetX works properly

		$objDrawing->setCoordinates('A2');
		$objDrawing->setWorksheet($objPHPExcel->getActiveSheet());

		/*
		$gdImage1 = imagecreatefromjpeg('./images/logokiri.jpg');
		// Add a drawing to the worksheetecho date('H:i:s') . " Add a drawing to the worksheet\n";
		$objDrawing1 = new PHPExcel_Worksheet_MemoryDrawing();
		$objDrawing1->setName('Sample image');
		$objDrawing1->setDescription('Sample image');
		$objDrawing1->setImageResource($gdImage1);
		$objDrawing1->setRenderingFunction(PHPExcel_Worksheet_MemoryDrawing::RENDERING_JPEG);
		$objDrawing1->setMimeType(PHPExcel_Worksheet_MemoryDrawing::MIMETYPE_DEFAULT);
		$objDrawing1->setHeight(50);
		$objDrawing1->setWidth(70);
		$objDrawing1->setOffsetX(100);    // setOffsetX works properly
		$objDrawing1->setCoordinates('G2');
		$objDrawing1->setWorksheet($objPHPExcel->getActiveSheet());
		*/


		$baris=2;
		$total=0;
		//$itemsjenis=$this->mpemeriksaan->getallPemeriksaanPasienGroupByJenis($item['kd_pendaftaran']);
		//debugvar($itemsjenis);
			for($angka=$baris;$angka<=$baris+4;$angka++){
				$objPHPExcel->getActiveSheet()->getStyle("A".$angka)->getAlignment()->applyFromArray(
					array(
						'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
						'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
						'rotation'   => 0,
					'wrap'       => true
					));						
			}

			$objPHPExcel->getActiveSheet()->mergeCells('A'.$baris.':G'.$baris);
			$objPHPExcel->getActiveSheet()->getStyle("A2")->applyFromArray(array(
				'font'    => array(
					'name'      => 'arial',
					'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
					'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
					'rotation'   => 0,
					'wrap'       => true,
					'bold'      => false,
					'size'		=>11,
					'color'     => array(
						'rgb' => '000000'
					)
				),
				'fill' => array(
					'type' => PHPExcel_Style_Fill::FILL_SOLID,
					'color' => array('rgb'=>'FFFFFF'),
				)				 
			));	

			$objPHPExcel->getActiveSheet()->setCellValue ('A'.$baris,'RS BERSALIN ');		

			$baris=$baris+1;
			$objPHPExcel->getActiveSheet()->mergeCells('A'.$baris.':G'.$baris);
			$objPHPExcel->getActiveSheet()->getStyle("A".$baris)->applyFromArray(array(
				'font'    => array(
					'name'      => 'arial',
					'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
					'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
					'rotation'   => 0,
					'wrap'       => true,
					'bold'      => false,
					'size'		=>14,
					'color'     => array(
						'rgb' => '000000'
					)
				),
				'fill' => array(
					'type' => PHPExcel_Style_Fill::FILL_SOLID,
					'color' => array('rgb'=>'FFFFFF'),
				)				 
			));		
			$objPHPExcel->getActiveSheet()->setCellValue ('A'.$baris,strtoupper('"SAYANG IBU"'));		

			$baris=$baris+1;
			$objPHPExcel->getActiveSheet()->mergeCells('A'.$baris.':G'.$baris);
			$objPHPExcel->getActiveSheet()->getStyle("A".$baris)->applyFromArray(array(
				'font'    => array(
					'name'      => 'arial',
					'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
					'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
					'rotation'   => 0,
					'wrap'       => true,
					'bold'      => true,
					'size'		=>18,
					'color'     => array(
						'rgb' => '000000'
					)
				),
				'fill' => array(
					'type' => PHPExcel_Style_Fill::FILL_SOLID,
					'color' => array('rgb'=>'FFFFFF'),
				)				 
			));		
			$objPHPExcel->getActiveSheet()->setCellValue ('A'.$baris,strtoupper('LABORATORIUM'));		

			$baris=$baris+1;
			$objPHPExcel->getActiveSheet()->mergeCells('A'.$baris.':G'.$baris);
			$objPHPExcel->getActiveSheet()->getStyle("A".$baris)->applyFromArray(array(
				'font'    => array(
					'name'      => 'arial',
					'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
					'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
					'rotation'   => 0,
					'wrap'       => true,
					'bold'      => false,
					'size'		=>8,
					'color'     => array(
						'rgb' => '000000'
					)
				),
				'fill' => array(
					'type' => PHPExcel_Style_Fill::FILL_SOLID,
					'color' => array('rgb'=>'FFFFFF'),
				)				 
			));		
			$objPHPExcel->getActiveSheet()->setCellValue ('A'.$baris,'Jl. Wain No 33, Kebun Sayur, Balikpapan.');		

			$baris=$baris+1;
			$objPHPExcel->getActiveSheet()->mergeCells('A'.$baris.':G'.$baris);
			$objPHPExcel->getActiveSheet()->getStyle("A".$baris)->applyFromArray(array(
				'font'    => array(
					'name'      => 'arial',
					'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
					'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
					'rotation'   => 0,
					'wrap'       => true,
					'bold'      => false,
					'size'		=>8,
					'color'     => array(
						'rgb' => '000000'
					)
				),
				'fill' => array(
					'type' => PHPExcel_Style_Fill::FILL_SOLID,
					'color' => array('rgb'=>'FFFFFF'),
				)				 
			));		
			$objPHPExcel->getActiveSheet()->setCellValue ('A'.$baris,'Penanggung Jawab Laboratorium: dr Ratna Sudarti');		

			$styleArray = array( 
								'borders' => array( 
											'bottom' => array( 
														'style' => PHPExcel_Style_Border::BORDER_DOUBLE, 
														'color' => array(
																	'argb' => '000000'), 
														), 
											), 
								); 
			$objPHPExcel->getActiveSheet()->getStyle('A'.$baris.':G'.$baris)->applyFromArray($styleArray);

			$baris=$baris+2;
			$styleArray = array( 
								'borders' => array( 
											'outline' => array( 
														'style' => PHPExcel_Style_Border::BORDER_THIN, 
														'color' => array(
																	'argb' => '000000'), 
														), 
											), 
								); 
			$objPHPExcel->getActiveSheet()->getStyle('A'.$baris.':G'.($baris+6))->applyFromArray($styleArray);


			for($angka=$baris;$angka<=$baris+6;$angka++){
				$objPHPExcel->getActiveSheet()->getStyle("A".$angka)->applyFromArray(array(
					'font'    => array(
						'name'      => 'arial',
						'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
						'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
						'rotation'   => 0,
						'wrap'       => true,
						'bold'      => false,
						'size'		=>10,
						'color'     => array(
							'rgb' => '000000'
						)
					),
					'fill' => array(
						'type' => PHPExcel_Style_Fill::FILL_SOLID,
						'color' => array('rgb'=>'FFFFFF'),
					)				 
				));		
				$objPHPExcel->getActiveSheet()->getStyle("C".$angka)->applyFromArray(array(
					'font'    => array(
						'name'      => 'arial',
						'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
						'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
						'rotation'   => 0,
						'wrap'       => true,
						'bold'      => false,
						'size'		=>10,
						'color'     => array(
							'rgb' => '000000'
						)
					),
					'fill' => array(
						'type' => PHPExcel_Style_Fill::FILL_SOLID,
						'color' => array('rgb'=>'FFFFFF'),
					)				 
				));		
				$objPHPExcel->getActiveSheet()->getStyle("A".$angka)->getAlignment()->applyFromArray(
					array(
						'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
						'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
						'rotation'   => 0,
					'wrap'       => false
					));						
				$objPHPExcel->getActiveSheet()->getStyle("C".$angka)->getAlignment()->applyFromArray(
					array(
						'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
						'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
						'rotation'   => 0,
					'wrap'       => false
					));						
			}


			$objPHPExcel->getActiveSheet()->setCellValue ('A'.$baris,'No. RM ');
			$objPHPExcel->getActiveSheet()->setCellValue ('C'.$baris,"'".$item['kd_pasien']);

			$objPHPExcel->getActiveSheet()->mergeCells('E'.$baris.':F'.$baris);
			$objPHPExcel->getActiveSheet()->getStyle("E".$baris)->getAlignment()->applyFromArray(
				array(
					'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
					'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
					'rotation'   => 0,
				'wrap'       => false
				));						

			$objPHPExcel->getActiveSheet()->getStyle("F".$baris)->getAlignment()->applyFromArray(
				array(
					'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
					'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
					'rotation'   => 0,
				'wrap'       => false
				));						
			$objPHPExcel->getActiveSheet()->setCellValue ('E'.$baris,'Hari/Tgl ');
			$tgl=explode("-", $tanggalperiksa[0]);
			$day=date("l", mktime(0, 0, 0, $tgl[1], $tgl[2], $tgl[0]));
			$objPHPExcel->getActiveSheet()->setCellValue ('G'.$baris,$hari[$day]."/".convertDate($tanggalperiksa[0]));

			$baris=$baris+1;
			$objPHPExcel->getActiveSheet()->setCellValue ('A'.$baris,'Nama ');
			$objPHPExcel->getActiveSheet()->setCellValue ('C'.$baris,$this->pasien->nama_pasien);

			$objPHPExcel->getActiveSheet()->mergeCells('E'.$baris.':F'.$baris);
			$objPHPExcel->getActiveSheet()->getStyle("E".$baris)->getAlignment()->applyFromArray(
				array(
					'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
					'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
					'rotation'   => 0,
				'wrap'       => false
				));						

			$objPHPExcel->getActiveSheet()->getStyle("F".$baris)->getAlignment()->applyFromArray(
				array(
					'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
					'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
					'rotation'   => 0,
				'wrap'       => false
				));						
			$objPHPExcel->getActiveSheet()->setCellValue ('E'.$baris,'Jam Periksa ');
			$objPHPExcel->getActiveSheet()->setCellValue ('G'.$baris,$tanggalperiksa[1].' WITA');

			$baris=$baris+1;
			$objPHPExcel->getActiveSheet()->setCellValue ('A'.$baris,'Jenis Kelamin ');
			if($this->pasien->jns_kelamin=='L'){
				$objPHPExcel->getActiveSheet()->setCellValue ('C'.$baris,'Laki-laki/'.hitungumurSaatDaftar2tahunonly(convertDate($this->pasien->tgl_lahir),convertDate($this->pasien->tgl_daftar)));
			}else{
				$objPHPExcel->getActiveSheet()->setCellValue ('C'.$baris,'Perempuan/'.hitungumurSaatDaftar2tahunonly(convertDate($this->pasien->tgl_lahir),convertDate($this->pasien->tgl_daftar)));
			}

			$objPHPExcel->getActiveSheet()->mergeCells('E'.$baris.':F'.$baris);
			$objPHPExcel->getActiveSheet()->getStyle("E".$baris)->getAlignment()->applyFromArray(
				array(
					'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
					'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
					'rotation'   => 0,
				'wrap'       => false
				));						

			$objPHPExcel->getActiveSheet()->getStyle("F".$baris)->getAlignment()->applyFromArray(
				array(
					'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
					'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
					'rotation'   => 0,
				'wrap'       => false
				));						
			$objPHPExcel->getActiveSheet()->setCellValue ('E'.$baris,'Jam Cetak ');
			$objPHPExcel->getActiveSheet()->setCellValue ('G'.$baris,$tanggalcetak[1].' WITA');


			$baris=$baris+1;
			$objPHPExcel->getActiveSheet()->setCellValue ('A'.$baris,'Umur. ');
			$objPHPExcel->getActiveSheet()->setCellValue ('C'.$baris,hitungumurSaatDaftar2(convertDate($this->pasien->tgl_lahir),convertDate($this->pasien->tgl_daftar)));
			/*
			$baris=$baris+1;
			$objPHPExcel->getActiveSheet()->setCellValue ('A'.$baris,'Tanggal Pemeriksaan. ');
			$objPHPExcel->getActiveSheet()->setCellValue ('C'.$baris,'');
			$baris=$baris+1;
			$objPHPExcel->getActiveSheet()->setCellValue ('A'.$baris,'Alamat. ');
			$objPHPExcel->getActiveSheet()->setCellValue ('C'.$baris,$item['alamat']);
			$baris=$baris+1;
			*/
			$objPHPExcel->getActiveSheet()->setCellValue ('A'.$baris,'Dokter. ');
			$objPHPExcel->getActiveSheet()->setCellValue ('C'.$baris,$this->pasien->nama_dokter);

			$baris=$baris+1;
			$objPHPExcel->getActiveSheet()->mergeCells('A'.$baris.':G'.$baris);
			$objPHPExcel->getActiveSheet()->getStyle("A".$baris)->getAlignment()->applyFromArray(
				array(
					'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
					'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
					'rotation'   => 0,
				'wrap'       => false
				));		
			$objPHPExcel->getActiveSheet()->setCellValue ('A'.$baris,'HASIL PEMERIKSAAN LABORATORIUM');
			// isi header

			//header table
			$baris=14;
			for($abjad="A";$abjad<="G";$abjad++){
				$objPHPExcel->getActiveSheet()->getStyle($abjad.$baris)->applyFromArray(array(
					'font'    => array(
						'name'      => 'arial',
						'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
						'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
						'bold'      => true,
						'size'		=>10,
						'color'     => array(
							'rgb' => '000000'
						)
					),
					'borders' => array(
						'bottom'     => array(
							'style' => PHPExcel_Style_Border::BORDER_THIN,
							'color' => array(
								'rgb' => '000000'
							)
						),
						'top'     => array(
							'style' => PHPExcel_Style_Border::BORDER_THIN,
							'color' => array(
								'rgb' => '000000'
							)
						),
						'left'     => array(
							'style' => PHPExcel_Style_Border::BORDER_THIN,
							'color' => array(
								'rgb' => '000000'
							)
						),
						'right'     => array(
							'style' => PHPExcel_Style_Border::BORDER_THIN,
							'color' => array(
								'rgb' => '000000'
							)
						)
					),
					'fill' => array(
						'type' => PHPExcel_Style_Fill::FILL_SOLID,
						'color' => array('rgb'=>'FFFFFF'),
					)				 
				));	

				$objPHPExcel->getActiveSheet()->getStyle($abjad.$baris)->getAlignment()->applyFromArray(
					array(
						'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
						'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
						'rotation'   => 0,
					'wrap'       => false
					));		

			}

			$objPHPExcel->getActiveSheet()->mergeCells('A'.$baris.':D'.$baris);
			$objPHPExcel->getActiveSheet()->setCellValue ('A'.$baris,'Pemeriksaan. ');
			$objPHPExcel->getActiveSheet()->setCellValue ('E'.$baris,'Hasil. ');
			$objPHPExcel->getActiveSheet()->setCellValue ('F'.$baris,'Satuan. ');
			$objPHPExcel->getActiveSheet()->setCellValue ('G'.$baris,'Nilai Normal. ');

		$qitempelayanan=$this->db->query('select c.urut, ifnull(c.parent_kode_item_lab,"Parent") as parent, "Parent" as no_reg_lab, a.no_pendaftaran, a.kd_pelayanan, a.kode_item_lab, a.jk, a.hasil, a.keterangan, a.status, a.nilai_normal, a.satuan, b.nama_item_lab from (SELECT b.urut,parent_kode_item_lab, a.no_reg_lab, a.no_pendaftaran, a.kd_pelayanan, a.kode_item_lab, a.jk, a.hasil, a.keterangan, a.status, a.nilai_normal, a.satuan, e.nama_item_lab
FROM lab_hasil_lab a
JOIN lab_urut_pemeriksaan b ON a.kode_mapping = b.kode_mapping
JOIN lab_mapping_item d ON b.kode_item_lab = d.kode_item_lab
JOIN lab_item_lab e ON a.kode_item_lab = e.kode_item_lab
LEFT JOIN lab_item_pelayanan c ON a.kd_pelayanan = c.kd_pelayanan
AND a.kode_mapping = c.kode_mapping
WHERE a.no_pendaftaran = "'.$no_pendaftaran.'" and a.no_reg_lab = "'.$noreglab.'"
GROUP BY a.kd_pelayanan, a.kode_mapping) as a
		join lab_item_lab b on a.parent_kode_item_lab=b.kode_item_lab
		join lab_urut_pemeriksaan c on b.kode_item_lab=c.kode_item_lab
		 group by a.parent_kode_item_lab
		union
SELECT b.urut, ifnull( status, "Anak" ) AS parent, a.no_reg_lab, a.no_pendaftaran, a.kd_pelayanan, a.kode_item_lab, a.jk, a.hasil, a.keterangan, a.status, a.nilai_normal, a.satuan, e.nama_item_lab
FROM lab_hasil_lab a
JOIN lab_urut_pemeriksaan b ON a.kode_mapping = b.kode_mapping
JOIN lab_mapping_item d ON b.kode_item_lab = d.kode_item_lab
JOIN lab_item_lab e ON a.kode_item_lab = e.kode_item_lab
LEFT JOIN lab_item_pelayanan c ON a.kd_pelayanan = c.kd_pelayanan
AND a.kode_mapping = c.kode_mapping
WHERE a.no_pendaftaran = "'.$no_pendaftaran.'" and a.no_reg_lab = "'.$noreglab.'"
GROUP BY a.kd_pelayanan, a.kode_mapping
		having parent !="Anak"
		order by urut');

		$itemslayanan=$qitempelayanan->result_array();

		
			$baris=15;

		foreach ($itemslayanan as $itemlayanan) {
			# code...


			for($abjad="A";$abjad<="G";$abjad++){
				$objPHPExcel->getActiveSheet()->getStyle($abjad.$baris)->applyFromArray(array(
					'font'    => array(
						'name'      => 'arial',
						'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
						'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
						'bold'      => true,
						'size'		=>10,
						'color'     => array(
							'rgb' => '000000'
						)
					),
					'borders' => array(

						'left'     => array(
							'style' => PHPExcel_Style_Border::BORDER_THIN,
							'color' => array(
								'rgb' => '000000'
							)
						),
						'right'     => array(
							'style' => PHPExcel_Style_Border::BORDER_THIN,
							'color' => array(
								'rgb' => '000000'
							)
						)
					),
					'fill' => array(
						'type' => PHPExcel_Style_Fill::FILL_SOLID,
						'color' => array('rgb'=>'FFFFFF'),
					)				 
				));		
				$objPHPExcel->getActiveSheet()->getStyle($abjad.$baris)->getAlignment()->setWrapText(false);					
			}

					for($abjad="A";$abjad<="D";$abjad++){
						$objPHPExcel->getActiveSheet()->getStyle($abjad.$baris)->applyFromArray(array(
							'font'    => array(
								'name'      => 'arial',
								'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
								'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
								'bold'      => false,
								'size'		=>10,
								'color'     => array(
									'rgb' => '000000'
								)
							),
							'borders' => array(

								'left'     => array(
									'style' => PHPExcel_Style_Border::BORDER_THIN,
									'color' => array(
										'rgb' => '000000'
									)
								),
								'right'     => array(
									'style' => PHPExcel_Style_Border::BORDER_THIN,
									'color' => array(
										'rgb' => '000000'
									)
								)
							),
							'fill' => array(
								'type' => PHPExcel_Style_Fill::FILL_SOLID,
								'color' => array('rgb'=>'FFFFFF'),
							)				 
						));		
						$objPHPExcel->getActiveSheet()->getStyle($abjad.$baris)->getAlignment()->setWrapText(true);					
					}

					for($abjadx="E";$abjadx<="G";$abjadx++){
						$objPHPExcel->getActiveSheet()->getStyle($abjadx.$baris)->getAlignment()->applyFromArray(
							array(
								'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
								'vertical'   => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
								'rotation'   => 0,
							'wrap'       => true
							));						

						$objPHPExcel->getActiveSheet()->getStyle($abjadx.$baris)->applyFromArray(array(
							'font'    => array(
								'name'      => 'arial',
								'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
								'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
								'rotation'   => 0,
								'wrap'       => true,
								'bold'      => false,
								'size'		=>10,
								'color'     => array(
									'rgb' => '000000'
								)
							),
							'borders' => array(

								'left'     => array(
									'style' => PHPExcel_Style_Border::BORDER_THIN,
									'color' => array(
										'rgb' => '000000'
									)
								),
								'right'     => array(
									'style' => PHPExcel_Style_Border::BORDER_THIN,
									'color' => array(
										'rgb' => '000000'
									)
								)
							),
							'fill' => array(
								'type' => PHPExcel_Style_Fill::FILL_SOLID,
								'color' => array('rgb'=>'FFFFFF'),
							)				 
						));							
	
					}
					$objPHPExcel->getActiveSheet()->mergeCells('A'.$baris.':D'.$baris);
					if($itemlayanan['parent']=="Parent" || $itemlayanan['no_reg_lab']=="Parent"){
						$objPHPExcel->getActiveSheet()->getStyle("A".$baris)->applyFromArray(array(
							'font'    => array(
								'name'      => 'arial',
								'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
								'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
								'bold'      => true,
								'size'		=>10,
								'color'     => array(
									'rgb' => '000000'
								)
							),
							'borders' => array(

								'left'     => array(
									'style' => PHPExcel_Style_Border::BORDER_THIN,
									'color' => array(
										'rgb' => '000000'
									)
								),
								'right'     => array(
									'style' => PHPExcel_Style_Border::BORDER_THIN,
									'color' => array(
										'rgb' => '000000'
									)
								)
							),
							'fill' => array(
								'type' => PHPExcel_Style_Fill::FILL_SOLID,
								'color' => array('rgb'=>'FFFFFF'),
							)				 
						));		
						$objPHPExcel->getActiveSheet()->getStyle($abjad.$baris)->getAlignment()->setWrapText(true);					

						$objPHPExcel->getActiveSheet()->setCellValue ('A'.$baris,$itemlayanan['nama_item_lab']);
					}else{
  						$objPHPExcel->getActiveSheet()->setCellValue ('A'.$baris,$itemlayanan['nama_item_lab']);
						$objPHPExcel->getActiveSheet()->setCellValue ('E'.$baris,$itemlayanan['hasil']);							
						$objPHPExcel->getActiveSheet()->setCellValue ('F'.$baris,$itemlayanan['satuan']);
						$objPHPExcel->getActiveSheet()->setCellValue ('G'.$baris,$itemlayanan['nilai_normal']);																
                        
					}




				//}
					$baris++;


			$double='';


		}

		$objPHPExcel->getActiveSheet()->getStyle('A'.$baris)->applyFromArray(array(
			'font'    => array(
				'name'      => 'arial',
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
				'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
				'bold'      => false,
				'size'		=>9,
				'color'     => array(
					'rgb' => '000000'
				)
			),
			'borders' => array(

				'top'     => array(
					'style' => PHPExcel_Style_Border::BORDER_THIN,
					'color' => array(
						'rgb' => '000000'
					)
				)
			),
			'fill' => array(
				'type' => PHPExcel_Style_Fill::FILL_SOLID,
				'color' => array('rgb'=>'FFFFFF'),
			)				 
		));		
		$objPHPExcel->getActiveSheet()->getStyle('A'.$baris)->getAlignment()->setWrapText(true);					

		$objPHPExcel->getActiveSheet()->mergeCells('A'.$baris.':G'.$baris);
		$objPHPExcel->getActiveSheet()->setCellValue ('A'.$baris,'Jika ada Keraguan hasil Laboratorium, harap menghubungi Laboratorium ');		

			for($abjad="A";$abjad<="G";$abjad++){
				$objPHPExcel->getActiveSheet()->getStyle($abjad.$baris)->applyFromArray(array(
					'font'    => array(
						'name'      => 'arial',
						'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
						'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
						'bold'      => false,
						'size'		=>9,
						'color'     => array(
							'rgb' => '000000'
						)
					),
					'borders' => array(

						'top'     => array(
							'style' => PHPExcel_Style_Border::BORDER_THIN,
							'color' => array(
								'rgb' => '000000'
							)
						)
					),
					'fill' => array(
						'type' => PHPExcel_Style_Fill::FILL_SOLID,
						'color' => array('rgb'=>'FFFFFF'),
					)				 
				));		
				$objPHPExcel->getActiveSheet()->getStyle($abjad.$baris)->getAlignment()->setWrapText(true);					
			}

			$baristandatangan=$baris+2;
							
			$objPHPExcel->getActiveSheet()->getStyle("F".$baristandatangan)->getAlignment()->applyFromArray(
				array(
					'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
					'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
					'rotation'   => 0,
				'wrap'       => true
				));

			$objPHPExcel->getActiveSheet()->getStyle("F".$baristandatangan)->applyFromArray(array(
				'font'    => array(
					'name'      => 'calibri',
					'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
					'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
					'bold'      => FALSE,
					'size'		=>12,
					'color'     => array(
						'rgb' => '000000'
					)
				),
				'fill' => array(
					'type' => PHPExcel_Style_Fill::FILL_SOLID,
					'color' => array('rgb'=>'FFFFFF'),
				)				 
			));								
							
			$objPHPExcel->getActiveSheet()->mergeCells('A'.$baristandatangan.':B'.$baristandatangan);
			$objPHPExcel->getActiveSheet()->setCellValue ('A'.$baristandatangan,'Pemeriksa. ');
			$objPHPExcel->getActiveSheet()->setCellValue ('D'.$baristandatangan,'Checker. ');

			$objPHPExcel->getActiveSheet()->mergeCells('F'.$baristandatangan.':G'.$baristandatangan);
			$objPHPExcel->getActiveSheet()->setCellValue ('F'.$baristandatangan,'Disetujui, ');
			$barisjabatan=$baristandatangan+1;
			$objPHPExcel->getActiveSheet()->getStyle("F".$barisjabatan)->getAlignment()->applyFromArray(
				array(
					'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
					'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
					'rotation'   => 0,
				'wrap'       => true
				));

			$objPHPExcel->getActiveSheet()->getStyle("F".$barisjabatan)->applyFromArray(array(
				'font'    => array(
					'name'      => 'calibri',
					'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
					'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
					'bold'      => FALSE,
					'size'		=>12,
					'color'     => array(
						'rgb' => '000000'
					)
				),
				'fill' => array(
					'type' => PHPExcel_Style_Fill::FILL_SOLID,
					'color' => array('rgb'=>'FFFFFF'),
				)				 
			));				

			$barispasien=$baristandatangan+3;
			$objPHPExcel->getActiveSheet()->getStyle("A".$barispasien)->getAlignment()->applyFromArray(
				array(
					'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
					'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
					'rotation'   => 0,
				'wrap'       => true
				));

			$objPHPExcel->getActiveSheet()->getStyle("A".$barispasien)->applyFromArray(array(
				'font'    => array(
					'name'      => 'calibri',
					'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
					'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
					'bold'      => true,
					'size'		=>12,
					'color'     => array(
						'rgb' => '000000'
					)
				),
				'fill' => array(
					'type' => PHPExcel_Style_Fill::FILL_SOLID,
					'color' => array('rgb'=>'FFFFFF'),
				)				 
			));								
			$objPHPExcel->getActiveSheet()->getStyle("F".$barispasien)->getAlignment()->applyFromArray(
				array(
					'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
					'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
					'rotation'   => 0,
				'wrap'       => true
				));

			$objPHPExcel->getActiveSheet()->getStyle("F".$barispasien)->applyFromArray(array(
				'font'    => array(
					'name'      => 'calibri',
					'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
					'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
					'bold'      => FALSE,
					'size'		=>12,
					'color'     => array(
						'rgb' => '000000'
					)
				),
				'fill' => array(
					'type' => PHPExcel_Style_Fill::FILL_SOLID,
					'color' => array('rgb'=>'FFFFFF'),
				)				 
			));		

			//$objPHPExcel->getActiveSheet()->mergeCells('A'.$barispasien.':B'.$barispasien);
			//$objPHPExcel->getActiveSheet()->setCellValue ('A'.$barispasien,$item['nama_pasien']);
			$objPHPExcel->getActiveSheet()->mergeCells('F'.$barispasien.':G'.$barispasien);
			$objPHPExcel->getActiveSheet()->setCellValue ('F'.$barispasien,'');
			$barisnip=$barispasien+1;
			$objPHPExcel->getActiveSheet()->mergeCells('F'.$barisnip.':G'.$barisnip);
			$objPHPExcel->getActiveSheet()->getStyle("F".$barisnip)->getAlignment()->applyFromArray(
				array(
					'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
					'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
					'rotation'   => 0,
				'wrap'       => true
				));

			$objPHPExcel->getActiveSheet()->getStyle("F".$barisnip)->applyFromArray(array(
				'font'    => array(
					'name'      => 'calibri',
					'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
					'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
					'bold'      => FALSE,
					'size'		=>12,
					'color'     => array(
						'rgb' => '000000'
					)
				),
				'fill' => array(
					'type' => PHPExcel_Style_Fill::FILL_SOLID,
					'color' => array('rgb'=>'FFFFFF'),
				)				 
			));		
			$objPHPExcel->getActiveSheet()->setCellValue ('A'.$barisnip,$itemperiksapasien['lab_pemeriksa']);
			$objPHPExcel->getActiveSheet()->setCellValue ('D'.$barisnip,$itemperiksapasien['lab_checker']);
			$objPHPExcel->getActiveSheet()->setCellValue ('F'.$barisnip,'dr. Ratna Sudarti');



		// Save it as an excel 2003 file 
		$objWriter = IOFactory::createWriter($objPHPExcel, 'Excel5'); 
		$objWriter->save("download/hasil_lab.xls");
		redirect(base_url()."download/hasil_lab.xls");
		//echo json_encode($msg);

	}

	public function updateitemlab(){
		$kode_lama_item_lab=$this->input->post('kode_lama_item_lab');
		$kode_item_lab=$this->input->post('kode_item_lab');
		$nama_item_lab=$this->input->post('nama_item_lab');
		$parent=$this->input->post('parent');
		$data=array(
			'kode_item_lab'=>$kode_item_lab,
			'nama_item_lab'=>$nama_item_lab,
			'parent'=>$parent
			);
		$this->mrwj->update('lab_item_lab',$data,'kode_item_lab="'.$kode_lama_item_lab.'"');

		$msg['pesan']="Data Berhasil Di Simpan";
		$msg['status']=1;

		echo json_encode($msg);
	}

	public function updatekategorinilainormal(){
		$kode_kategori=$this->input->post('kode_kategori');
		$kategori=$this->input->post('kategori');
		$satuan=$this->input->post('satuan');
		$data=array(
			'kategori'=>$kategori,
			'satuan'=>$satuan
			);
		$this->mrwj->update('lab_kategori_nilai_normal',$data,'kode_kategori="'.$kode_kategori.'"');

		$msg['pesan']="Data Berhasil Di Simpan";
		$msg['status']=1;

		echo json_encode($msg);
	}

	public function hapusitemlab($kode){

		$this->mrwj->delete('lab_item_lab','kode_item_lab="'.$kode.'"');

		$msg['pesan']="Data Berhasil Di Simpan";
		$msg['status']=1;

		redirect('/lab/itemlab');
	}

	public function hapusnilainormal($kode_item_lab,$kode_kategori){

		$this->mrwj->delete('lab_nilai_normal','kode_item_lab="'.$kode_item_lab.'" and kode_kategori="'.$kode_kategori.'"');

		$msg['pesan']="Data Berhasil Di Simpan";
		$msg['status']=1;

		redirect('/lab/nilainormal');
	}

	public function hapuskategorinilainormal($kode){

		$this->mrwj->delete('lab_kategori_nilai_normal','kode_kategori="'.$kode.'"');

		$msg['pesan']="Data Berhasil Di Simpan";
		$msg['status']=1;

		redirect('/lab/kategorinilainormal');
	}

	public function tes(){
		$tes=array();
		$tes[0]="a";
		$tes[1]="b";
		$tes[2]=array('21'=>'c1','22'=>'c2');
		foreach ($tes as $t) {
			# code...
			if(is_array($t)){
				foreach ($t as $x) {
					# code...
					print_r($x);
			echo "<br/>";
				}
			}else{
							print_r($t);

			}
			echo "<br/>";
		}

	}

	public function hasillab($kd_pasien="",$no_pendaftaran="",$no_reg_lab="")
	{
		if(!$this->muser->isAkses("601")){
			$this->restricted();
			return false;
		}
		//if(empty($kd_pasien))return false;
		$cssfileheader=array('bootstrap.css','bootstrap-responsive.min.css','font-awesome.min.css','style.css','prettify.css','jquery-ui.css','DT_bootstrap.css','responsive-tables.css','datepicker.css','timepicker.css','theme.css');
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

		//$qitempelayanan=$this->db->query('select * from biaya_pelayanan a join lab_item_pelayanan b on a.kd_pelayanan=b.kd_pelayanan join list_pelayanan c on b.kd_pelayanan=c.kd_pelayanan join lab_item_lab d on b.kode_item_lab=d.kode_item_lab JOIN lab_mapping_item e ON d.kode_item_lab = e.kode_item_lab where a.no_pendaftaran="'.$no_pendaftaran.'"');
		$this->mrwj->setPasien($no_pendaftaran);
		$this->pasien=$this->mrwj->pasien;

		$qitempelayanan=$this->db->query('select * from biaya_pelayanan a join lab_item_pelayanan b on a.kd_pelayanan=b.kd_pelayanan join list_pelayanan c on b.kd_pelayanan=c.kd_pelayanan join lab_mapping_item e on b.kode_mapping=e.kode_mapping join lab_item_lab d on e.kode_item_lab=d.kode_item_lab  where a.no_pendaftaran="'.$no_pendaftaran.'" and a.lab=0  ');

			$data=array(
			//'item'=>$this->mpoli->getItemDaftarPasien($no_pendaftaran,$kd_pasien),
			'no_pendaftaran'=>$no_pendaftaran,
			'kd_pasien'=>$kd_pasien,
			'no_reg_lab'=>$no_reg_lab,
			'itemperiksapasien'=>$this->mpoli->ambilItemData('lab_periksa_pasien','no_reg_lab="'.$no_reg_lab.'"'),
			'itemslayanan'=>$qitempelayanan->result_array()
		);
		$this->load->view('lab/header',$dataheader);
		$this->load->view('lab/hasillab',$data);
		$this->load->view('footer',$datafooter);
	}

	public function edithasillab($kd_pasien="",$no_pendaftaran="",$no_reg_lab="")
	{
		if(!$this->muser->isAkses("601")){
			$this->restricted();
			return false;
		}
		//if(empty($kd_pasien))return false;
		$cssfileheader=array('bootstrap.css','bootstrap-responsive.min.css','font-awesome.min.css','style.css','prettify.css','jquery-ui.css','DT_bootstrap.css','responsive-tables.css','datepicker.css','timepicker.css','theme.css');
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

		//$qitempelayanan=$this->db->query('select * from biaya_pelayanan a join lab_item_pelayanan b on a.kd_pelayanan=b.kd_pelayanan join list_pelayanan c on b.kd_pelayanan=c.kd_pelayanan join lab_item_lab d on b.kode_item_lab=d.kode_item_lab JOIN lab_mapping_item e ON d.kode_item_lab = e.kode_item_lab where a.no_pendaftaran="'.$no_pendaftaran.'"');

		$this->mrwj->setPasien($no_pendaftaran);
		$this->pasien=$this->mrwj->pasien;
		$qitempelayanan=$this->db->query('select * from biaya_pelayanan a join lab_item_pelayanan b on a.kd_pelayanan=b.kd_pelayanan join list_pelayanan c on b.kd_pelayanan=c.kd_pelayanan join lab_mapping_item e on b.kode_mapping=e.kode_mapping join lab_item_lab d on e.kode_item_lab=d.kode_item_lab  where a.no_pendaftaran="'.$no_pendaftaran.'" and a.kd_pelayanan in(select kd_pelayanan from lab_hasil_lab where no_reg_lab="'.$no_reg_lab.'") ');

			$data=array(
			'no_pendaftaran'=>$no_pendaftaran,
			'kd_pasien'=>$kd_pasien,
			'no_reg_lab'=>$no_reg_lab,
			'itemperiksapasien'=>$this->mrwj->ambilItemData('lab_periksa_pasien','no_reg_lab="'.$no_reg_lab.'"'),
			'itemslayanan'=>$qitempelayanan->result_array()
		);
		$this->load->view('lab/header',$dataheader);
		$this->load->view('lab/hasillab',$data);
		$this->load->view('footer',$datafooter);
	}

	public function periksahasillab(){
		$msg['status']=1;

		echo json_encode($msg);		
	}

	public function laporanharian()
	{
		$periodeawal=$this->input->post('periodeawal');
		$periodeakhir=$this->input->post('periodeakhir');

		if($periodeawal=='')$periodeawal=date('d-m-Y');
		if($periodeakhir=='')$periodeakhir=date('d-m-Y');

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
			'periodeakhir'=>$periodeakhir
			);
		$this->load->view('lab/header',$dataheader);
		$this->load->view('lab/laporanharian',$data);
		$this->load->view('footer',$datafooter);
	}
	
	public function laporanpendapatanrwj()
	{
		$periodeawal=$this->input->post('periodeawal');
		$periodeakhir=$this->input->post('periodeakhir');
		$jenis_pasien=$this->input->post('jenis_pasien');

		if($periodeawal=='')$periodeawal=date('d-m-Y');
		if($periodeakhir=='')$periodeakhir=date('d-m-Y');

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
			'jenis_pasien'=>$jenis_pasien,
			'items'=>$this->mpoli->lapPendapatanLabRWJ(convertDate($periodeawal),convertDate($periodeakhir),$jenis_pasien)
			);
		$this->load->view('lab/header',$dataheader);
		$this->load->view('lab/laporanpendapatanrwj',$data);
		$this->load->view('footer',$datafooter);
	}
	
	public function laporanpendapatanrwi()
	{
		$periodeawal=$this->input->post('periodeawal');
		$periodeakhir=$this->input->post('periodeakhir');
		$jenis_pasien=$this->input->post('jenis_pasien');

		if($periodeawal=='')$periodeawal=date('d-m-Y');
		if($periodeakhir=='')$periodeakhir=date('d-m-Y');

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
			'jenis_pasien'=>$jenis_pasien,
			'items'=>$this->mpoli->lapPendapatanLabRWI(convertDate($periodeawal),convertDate($periodeakhir),$jenis_pasien)
			);
		$this->load->view('lab/header',$dataheader);
		$this->load->view('lab/laporanpendapatanrwi',$data);
		$this->load->view('footer',$datafooter);
	}
	
	public function rekapjumlahpasien()
	{
		$bulan=$this->input->post('bulan');
		$tahun=$this->input->post('tahun');

		if($bulan=='')$bulan=date('m');
		if($tahun=='')$tahun=date('Y');

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
			'bulan'=>$bulan,
			'tahun'=>$tahun
			);
		$this->load->view('lab/header',$dataheader);
		$this->load->view('lab/laporanrekapjumlahpasien',$data);
		$this->load->view('footer',$datafooter);
	}

	public function rekaprwjbpjs()
	{
		$tahun=$this->input->post('tahun');

		if($tahun=='')$tahun=date('Y');

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
			'tahun'=>$tahun
			);
		$this->load->view('lab/header',$dataheader);
		$this->load->view('lab/laporanrekaprwjbpjs',$data);
		$this->load->view('footer',$datafooter);
	}

	public function rekaprwibpjs()
	{
		$tahun=$this->input->post('tahun');

		if($tahun=='')$tahun=date('Y');

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
			'tahun'=>$tahun
			);
		$this->load->view('lab/header',$dataheader);
		$this->load->view('lab/laporanrekaprwibpjs',$data);
		$this->load->view('footer',$datafooter);
	}

	public function laporanwaktutunggu()
	{
		$periodeawal=$this->input->post('periodeawal');
		$periodeakhir=$this->input->post('periodeakhir');

		if($periodeawal=='')$periodeawal=date('d-m-Y');
		if($periodeakhir=='')$periodeakhir=date('d-m-Y');

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
			'periodeakhir'=>$periodeakhir
			);
		$this->load->view('lab/header',$dataheader);
		$this->load->view('lab/laporanwaktutunggu',$data);
		$this->load->view('footer',$datafooter);
	}
	

	public function simpanpelayanan()
	{
		$msg=array();
		$no_pendaftaran=$this->input->post('no_pendaftaran');
		$tglpelayanan=$this->input->post('tglpelayanan');
		$jampelayanan=$this->input->post('jampelayanan');
		$cust_code=$this->input->post('cust_code');
		$kodetarif=$this->input->post('kodetarif');
		$kd_dokter=$this->input->post('kd_dokter');
		$qty=$this->input->post('qty');
		$tarif=$this->input->post('tarif');

		$msg['status']=1;
		$msg['urut']='';

		$pesan='';
		//debugvar($msg['status']);
		if($no_pendaftaran==''){
			$pesan='No Pendaftaran tidak boleh kosong';
			$msg['status']=0;
		}
		if($tglpelayanan==''){
			$pesan='Tanggal tidak boleh kosong';
			$msg['status']=0;
		}
		if($jampelayanan==''){
			$pesan='Jam tidak boleh kosong';
			$msg['status']=0;
		}
		if($kodetarif==''){
			$pesan='Kode Tarif tidak boleh kosong';
			$msg['status']=0;
		}
		if($qty==''){
			$pesan='Qty tidak boleh kosong';
			$msg['status']=0;
		}
		//
		$msg['pesan']=$pesan;
		if(!$msg['status']){
			echo json_encode($msg);
			return false;			
		}
		
		$kd=explode("#", $kodetarif);
		$itemlayanan1=$this->mkasir->ambilItemData('biaya_pelayanan','no_pendaftaran = "'.$no_pendaftaran.'" and kd_jenis_tarif="'.$kd[0].'" and kd_pelayanan="'.$kd[1].'" and kd_kelas="'.$kd[2].'" and tgl_berlaku="'.$kd[3].'"');
		if(count($itemlayanan1) > 0){
			//debugvar(json_encode($msg));
			echo json_encode($msg);
			return false;
		}

		$kode=explode("#", $kodetarif);
		$urut=$this->mkasir->getMaxUrutPelayanan($no_pendaftaran);
		$itemlayanan=$this->mkasir->ambilItemData('tarif','kd_jenis_tarif="'.$kode[0].'" and kd_pelayanan="'.$kode[1].'" and kd_kelas="'.$kode[2].'" and tgl_berlaku="'.$kode[3].'"');
		//debugvar($itemlayanan);
		$tanggal=convertDate($tglpelayanan);
		$urut=$urut+1;
		$data_pelayanan=array(
			'no_pendaftaran'=>$no_pendaftaran,
			'urut'=>$urut,
			'kd_kasir'=>0,
			'tgl_pelayanan'=>$tanggal.' '.$jampelayanan,
			'kd_jenis_tarif'=>$itemlayanan['kd_jenis_tarif'],
			'kd_pelayanan'=>$itemlayanan['kd_pelayanan'],
			'kd_kelas'=>$itemlayanan['kd_kelas'],
			'tgl_berlaku'=>$itemlayanan['tgl_berlaku'],
			'qty'=>$qty,
			'harga'=>$itemlayanan['tarif'],
			'total'=>$itemlayanan['tarif']*$qty,
			'kd_dokter'=>$kd_dokter,
			'cust_code'=>$cust_code,
			'harga_asli'=>$itemlayanan['tarif']
			);				

		$this->mkasir->insert('biaya_pelayanan',$data_pelayanan);
		$this->mkasir->insertbiayapelayanancomponent(0,$no_pendaftaran,$urut,$itemlayanan['kd_jenis_tarif'],$itemlayanan['kd_pelayanan'],$itemlayanan['kd_kelas'],$itemlayanan['tgl_berlaku']);

		$msg['urut']=$urut;
		//$urut=1;
		//$msg['pesan']="Data Berhasil Di Simpan";


		echo json_encode($msg);
	}

	public function hapuspelayanan()
	{
		$msg=array();
		$no_pendaftaran=$this->input->post('no_pendaftaran');
		$kodetarif=$this->input->post('kodetarif');
		$urut=$this->input->post('urut');

		$this->mrwj->delete('biaya_pelayanan','no_pendaftaran = "'.$no_pendaftaran.'" and urut="'.$urut.'"');
		$this->mrwj->delete('biaya_pelayanan_component','no_pendaftaran = "'.$no_pendaftaran.'" and urut="'.$urut.'"');


		echo json_encode($msg);
	}



	public function listdiagnosa($param){
		$q=$this->input->post('query');
		
		if($param==1){
			$items=$this->mrwj->ambilData('sub_diagnosa_icd','kd_sub_icd like "%'.$q.'%"','500');			
		}else{
			$items=$this->mrwj->ambilData('sub_diagnosa_icd','sub_diagnosa_icd like "%'.$q.'%"','500');						
		}		

		echo json_encode($items);
	}

	public function caripasien()
	{
		$nama=$this->input->post('nama');
		$alamat=$this->input->post('alamat');
		$keluarga=$this->input->post('keluarga');
		$telepon=$this->input->post('telepon');

		$items=$this->mrwj->ambilData('pasien','nama_pasien like "%'.$nama.'%" and nama_keluarga like "%'.$keluarga.'%" and alamat like "%'.$alamat.'%" and telepon like "%'.$telepon.'%" ');

		echo json_encode($items);
	}

	public function hitungUmur(){
		$q=$this->input->post('query');
		$item=hitungumur($q);
		echo json_encode($item);
	}


	public function laporanharianxls($periodeawal="",$periodeakhir=""){
		//$periodeawal=$this->input->post('periodeawal');
		//$periodeakhir=$this->input->post('periodeakhir');
		//$param=$this->input->post('param');
		//$shift=$this->input->post('shift');
		$query = $this->db->query("
					SELECT c.tanggal_masuk,c.no_reg_lab, date_format( c.tanggal_masuk, '%d' ) AS tgl, date_format( c.tanggal_masuk, '%m' ) AS bulan, date_format( c.tanggal_masuk, '%Y' ) AS tahun, a.rawat_jalan, b.rawat_inap
					FROM lab_periksa_pasien c
					LEFT JOIN (

					SELECT tanggal_masuk,no_reg_lab, nama_pasien AS rawat_jalan
					FROM lab_periksa_pasien a
					JOIN pendaftaran b ON a.no_pendaftaran = b.no_pendaftaran
					JOIN pasien c ON b.kd_pasien = c.kd_pasien
					JOIN unit_kerja d ON b.kd_unit_kerja = d.kd_unit_kerja
					WHERE (
					b.kd_unit_kerja =1
					OR d.parent =10
					) and tanggal_masuk between '".convertDate($periodeawal)."' and '".convertDate($periodeakhir)."'
					ORDER BY a.tanggal_masuk
					) AS a ON c.no_reg_lab = a.no_reg_lab
					LEFT JOIN (

					SELECT tanggal_masuk,no_reg_lab, nama_pasien AS rawat_inap
					FROM lab_periksa_pasien a
					JOIN pendaftaran b ON a.no_pendaftaran = b.no_pendaftaran
					JOIN pasien c ON b.kd_pasien = c.kd_pasien
					JOIN unit_kerja d ON b.kd_unit_kerja = d.kd_unit_kerja
					WHERE (
					d.parent =8
					) and tanggal_masuk between '".convertDate($periodeawal)."' and '".convertDate($periodeakhir)."'
					ORDER BY a.tanggal_masuk
					) AS b ON c.no_reg_lab = b.no_reg_lab
					where c.tanggal_masuk between '".convertDate($periodeawal)."' and '".convertDate($periodeakhir)."'
					ORDER BY tgl
						 ");


		$items=$query->result_array();
		$this->load->library('phpexcel'); 
		$this->load->library('PHPExcel/iofactory');
		//$objPHPExcel = new PHPExcel(); 

		// read in the existing file
		$objPHPExcel = IOFactory::load("./lab/laporanharian.xls");
		//$items=$this->mlaporanrl->getAllRL1(convertDate($periodeawal),convertDate($periodeakhir),$param,$shift);
		$bulan=array(
			'01'=>'Januari',
			'02'=>'Februari',
			'03'=>'Maret',
			'04'=>'April',
			'05'=>'Mei',
			'06'=>'Juni',
			'07'=>'Juli',
			'08'=>'Agustus',
			'09'=>'September',
			'10'=>'Oktober',
			'11'=>'November',
			'12'=>'Desember',
			);
		$objPHPExcel->getActiveSheet()->setCellValue ('A10',"Bulan : ".$bulan[$items[0]['bulan']]." ".$items[0]['tahun']);	
		$baris=12;
		$no=1;
		foreach ($items as $item) {
			for($x='A';$x<='D';$x++){

			
				$objPHPExcel->getActiveSheet()->getStyle($x.$baris)->applyFromArray(array(
					'font'    => array(
						'name'      => 'calibri',
						'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
						'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
						'size'		=>12,
						'color'     => array(
							'rgb' => '000000'
						)
					),
					'borders' => array(
						'bottom'     => array(
							'style' => PHPExcel_Style_Border::BORDER_THIN,
							'color' => array(
								'rgb' => '000000'
							)
						),
						'top'     => array(
							'style' => PHPExcel_Style_Border::BORDER_THIN,
							'color' => array(
								'rgb' => '000000'
							)
						),
						'left'     => array(
							'style' => PHPExcel_Style_Border::BORDER_THIN,
							'color' => array(
								'rgb' => '000000'
							)
						),
						'right'     => array(
							'style' => PHPExcel_Style_Border::BORDER_THIN,
							'color' => array(
								'rgb' => '000000'
							)
						)
					)			 
				));
			}

			$objPHPExcel->getActiveSheet()->setCellValue ('A'.$baris,$no);
			$objPHPExcel->getActiveSheet()->setCellValue ('B'.$baris,$item['tgl']);
			$objPHPExcel->getActiveSheet()->setCellValue ('C'.$baris,$item['rawat_jalan']);
			$objPHPExcel->getActiveSheet()->setCellValue ('D'.$baris,$item['rawat_inap']);
			$baris++;
			$no++;
					# code...
		}		
		//for($baris=5;$baris<=14;$baris++){
		//}

		//$objPHPExcel->getActiveSheet()->setCellValue ('D9',"19090");			

		$objWriter = IOFactory::createWriter($objPHPExcel, 'Excel5'); 
		$objWriter->save("download/laporanharian.xls");
		redirect(base_url()."download/laporanharian.xls");

	}

	public function laporanwaktutungguxls($periodeawal="",$periodeakhir="",$unit=""){
		//$periodeawal=$this->input->post('periodeawal');
		//$periodeakhir=$this->input->post('periodeakhir');
		//$param=$this->input->post('param');
		//$shift=$this->input->post('shift');
		$unit_kerja="";
		if($unit==1)$unit_kerja=" and (d.parent=10 or d.kd_unit_kerja=1)";
		if($unit==2)$unit_kerja=" and (d.parent=8)";

		$query = $this->db->query('
					SELECT date_format( tanggal_masuk, "%d" ) AS tgl, date_format( tanggal_masuk, "%m" ) AS bulan, date_format( tanggal_masuk, "%Y" ) AS tahun, date_format( tanggal_periksa, "%H:%i:%s" ) AS jam_periksa, date_format( tanggal_cetak, "%H:%i:%s" ) AS jam_cetak, a.no_reg_lab, c.kd_pasien, date_format( (
					tanggal_cetak - tanggal_periksa
					), "%H:%i:%s" ) AS jarak
					FROM lab_periksa_pasien a
					JOIN pendaftaran b ON a.no_pendaftaran = b.no_pendaftaran
					JOIN pasien c ON b.kd_pasien = c.kd_pasien
					join unit_kerja d on b.kd_unit_kerja=d.kd_unit_kerja
					where tanggal_masuk between "'.convertDate($periodeawal).'" and "'.convertDate($periodeakhir).'"
					'.$unit_kerja.'
						 ');


		$items=$query->result_array();
		$this->load->library('phpexcel'); 
		$this->load->library('PHPExcel/iofactory');
		//$objPHPExcel = new PHPExcel(); 

		// read in the existing file
		$objPHPExcel = IOFactory::load("./lab/waktutunggu.xls");
		//$items=$this->mlaporanrl->getAllRL1(convertDate($periodeawal),convertDate($periodeakhir),$param,$shift);
		$bulan=array(
			'01'=>'Januari',
			'02'=>'Februari',
			'03'=>'Maret',
			'04'=>'April',
			'05'=>'Mei',
			'06'=>'Juni',
			'07'=>'Juli',
			'08'=>'Agustus',
			'09'=>'September',
			'10'=>'Oktober',
			'11'=>'November',
			'12'=>'Desember',
			);
		$objPHPExcel->getActiveSheet()->setCellValue ('C3',"Bulan : ".$bulan[$items[0]['bulan']]." ".$items[0]['tahun']);	
		$baris=6;
		$no=1;
		foreach ($items as $item) {
			for($x='A';$x<='F';$x++){

			
				$objPHPExcel->getActiveSheet()->getStyle($x.$baris)->applyFromArray(array(
					'font'    => array(
						'name'      => 'calibri',
						'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
						'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
						'size'		=>12,
						'color'     => array(
							'rgb' => '000000'
						)
					),
					'borders' => array(
						'bottom'     => array(
							'style' => PHPExcel_Style_Border::BORDER_THIN,
							'color' => array(
								'rgb' => '000000'
							)
						),
						'top'     => array(
							'style' => PHPExcel_Style_Border::BORDER_THIN,
							'color' => array(
								'rgb' => '000000'
							)
						),
						'left'     => array(
							'style' => PHPExcel_Style_Border::BORDER_THIN,
							'color' => array(
								'rgb' => '000000'
							)
						),
						'right'     => array(
							'style' => PHPExcel_Style_Border::BORDER_THIN,
							'color' => array(
								'rgb' => '000000'
							)
						)
					)			 
				));
			}

			$objPHPExcel->getActiveSheet()->setCellValue ('A'.$baris,$no);
			$objPHPExcel->getActiveSheet()->setCellValue ('B'.$baris,$item['tgl']);
			$objPHPExcel->getActiveSheet()->setCellValue ('C'.$baris,$item['kd_pasien']);
			$objPHPExcel->getActiveSheet()->setCellValue ('D'.$baris,$item['jam_periksa']);
			$objPHPExcel->getActiveSheet()->setCellValue ('E'.$baris,$item['jam_cetak']);
			$objPHPExcel->getActiveSheet()->setCellValue ('F'.$baris,$item['jarak']);
			$baris++;
			$no++;
					# code...
		}		
		//for($baris=5;$baris<=14;$baris++){
		//}

		//$objPHPExcel->getActiveSheet()->setCellValue ('D9',"19090");			

		$objWriter = IOFactory::createWriter($objPHPExcel, 'Excel5'); 
		$objWriter->save("download/waktutunggu.xls");
		redirect(base_url()."download/waktutunggu.xls");

	}

	public function laporanrekaprwjbpjsxls($tahun=""){
		//$periodeawal=$this->input->post('periodeawal');
		//$periodeakhir=$this->input->post('periodeakhir');
		//$param=$this->input->post('param');
		//$shift=$this->input->post('shift');
		$query = $this->db->query('
					SELECT tanggal_masuk,date_format(tanggal_masuk,"%d-%m-%Y") as tgl, nama_pasien, c.kd_pasien, nama_dokter, nama_pelayanan, harga
						FROM `lab_periksa_pasien` a
						JOIN pendaftaran b ON a.no_pendaftaran = b.no_pendaftaran
						JOIN pasien c ON b.kd_pasien = c.kd_pasien
						JOIN biaya_pelayanan d ON b.no_pendaftaran = d.no_pendaftaran
						JOIN list_pelayanan e ON d.kd_pelayanan = e.kd_pelayanan
						JOIN apt_dokter f ON b.kd_dokter = f.kd_dokter
						JOIN unit_kerja g ON b.kd_unit_kerja = g.kd_unit_kerja
						WHERE d.kd_pelayanan
						IN (

						SELECT kd_pelayanan
						FROM lab_item_pelayanan
						)
						AND d.cust_code
						IN ( 5, 6 )
						AND (
						b.kd_unit_kerja =1
						OR g.parent =10
						)
						and year(tanggal_masuk)="'.$tahun.'"
						 ');


		$items=$query->result_array();
		$this->load->library('phpexcel'); 
		$this->load->library('PHPExcel/iofactory');
		//$objPHPExcel = new PHPExcel(); 

		// read in the existing file
		$objPHPExcel = IOFactory::load("./lab/rekapanrwjbpjs.xls");
		//$items=$this->mlaporanrl->getAllRL1(convertDate($periodeawal),convertDate($periodeakhir),$param,$shift);
		$bulan=array(
			'01'=>'Januari',
			'02'=>'Februari',
			'03'=>'Maret',
			'04'=>'April',
			'05'=>'Mei',
			'06'=>'Juni',
			'07'=>'Juli',
			'08'=>'Agustus',
			'09'=>'September',
			'10'=>'Oktober',
			'11'=>'November',
			'12'=>'Desember',
			);
		$objPHPExcel->getActiveSheet()->setCellValue ('A5',"Tahun : ".$tahun);	
		$baris=9;
		$no=1;
		foreach ($items as $item) {
			for($x='A';$x<='G';$x++){

			
				$objPHPExcel->getActiveSheet()->getStyle($x.$baris)->applyFromArray(array(
					'font'    => array(
						'name'      => 'calibri',
						'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
						'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
						'size'		=>12,
						'color'     => array(
							'rgb' => '000000'
						)
					),
					'borders' => array(
						'bottom'     => array(
							'style' => PHPExcel_Style_Border::BORDER_THIN,
							'color' => array(
								'rgb' => '000000'
							)
						),
						'top'     => array(
							'style' => PHPExcel_Style_Border::BORDER_THIN,
							'color' => array(
								'rgb' => '000000'
							)
						),
						'left'     => array(
							'style' => PHPExcel_Style_Border::BORDER_THIN,
							'color' => array(
								'rgb' => '000000'
							)
						),
						'right'     => array(
							'style' => PHPExcel_Style_Border::BORDER_THIN,
							'color' => array(
								'rgb' => '000000'
							)
						)
					)			 
				));
			}

			$objPHPExcel->getActiveSheet()->setCellValue ('A'.$baris,$no);
			$objPHPExcel->getActiveSheet()->setCellValue ('B'.$baris,$item['tgl']);
			$objPHPExcel->getActiveSheet()->setCellValue ('C'.$baris,$item['nama_pasien']);
			$objPHPExcel->getActiveSheet()->setCellValue ('D'.$baris,$item['kd_pasien']);
			$objPHPExcel->getActiveSheet()->setCellValue ('E'.$baris,$item['nama_pelayanan']);
			$objPHPExcel->getActiveSheet()->setCellValue ('F'.$baris,$item['nama_dokter']);
			$objPHPExcel->getActiveSheet()->setCellValue ('G'.$baris,$item['harga']);
			$baris++;
			$no++;
					# code...
		}		
		//for($baris=5;$baris<=14;$baris++){
		//}

		//$objPHPExcel->getActiveSheet()->setCellValue ('D9',"19090");			

		$objWriter = IOFactory::createWriter($objPHPExcel, 'Excel5'); 
		$objWriter->save("download/rekapanrwjbpjs.xls");
		redirect(base_url()."download/rekapanrwjbpjs.xls");

	}

	public function laporanrekaprwibpjsxls($tahun=""){
		//$periodeawal=$this->input->post('periodeawal');
		//$periodeakhir=$this->input->post('periodeakhir');
		//$param=$this->input->post('param');
		//$shift=$this->input->post('shift');
		$query = $this->db->query('
					SELECT tanggal_masuk,date_format(tanggal_masuk,"%d-%m-%Y") as tgl, nama_pasien, c.kd_pasien, nama_dokter, nama_pelayanan, harga
						FROM `lab_periksa_pasien` a
						JOIN pendaftaran b ON a.no_pendaftaran = b.no_pendaftaran
						JOIN pasien c ON b.kd_pasien = c.kd_pasien
						JOIN biaya_pelayanan d ON b.no_pendaftaran = d.no_pendaftaran
						JOIN list_pelayanan e ON d.kd_pelayanan = e.kd_pelayanan
						JOIN apt_dokter f ON b.kd_dokter = f.kd_dokter
						JOIN unit_kerja g ON b.kd_unit_kerja = g.kd_unit_kerja
						WHERE d.kd_pelayanan
						IN (

						SELECT kd_pelayanan
						FROM lab_item_pelayanan
						)
						AND d.cust_code
						IN ( 5, 6 )
						AND (
						g.parent =8
						)
						and year(tanggal_masuk)="'.$tahun.'"
						 ');


		$items=$query->result_array();
		$this->load->library('phpexcel'); 
		$this->load->library('PHPExcel/iofactory');
		//$objPHPExcel = new PHPExcel(); 

		// read in the existing file
		$objPHPExcel = IOFactory::load("./lab/rekapanrwibpjs.xls");
		//$items=$this->mlaporanrl->getAllRL1(convertDate($periodeawal),convertDate($periodeakhir),$param,$shift);
		$bulan=array(
			'01'=>'Januari',
			'02'=>'Februari',
			'03'=>'Maret',
			'04'=>'April',
			'05'=>'Mei',
			'06'=>'Juni',
			'07'=>'Juli',
			'08'=>'Agustus',
			'09'=>'September',
			'10'=>'Oktober',
			'11'=>'November',
			'12'=>'Desember',
			);
		$objPHPExcel->getActiveSheet()->setCellValue ('A2',"Tahun : ".$tahun);	
		$baris=5;
		$no=1;
		foreach ($items as $item) {
			for($x='A';$x<='D';$x++){

			
				$objPHPExcel->getActiveSheet()->getStyle($x.$baris)->applyFromArray(array(
					'font'    => array(
						'name'      => 'calibri',
						'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
						'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
						'size'		=>12,
						'color'     => array(
							'rgb' => '000000'
						)
					),
					'borders' => array(
						'bottom'     => array(
							'style' => PHPExcel_Style_Border::BORDER_THIN,
							'color' => array(
								'rgb' => '000000'
							)
						),
						'top'     => array(
							'style' => PHPExcel_Style_Border::BORDER_THIN,
							'color' => array(
								'rgb' => '000000'
							)
						),
						'left'     => array(
							'style' => PHPExcel_Style_Border::BORDER_THIN,
							'color' => array(
								'rgb' => '000000'
							)
						),
						'right'     => array(
							'style' => PHPExcel_Style_Border::BORDER_THIN,
							'color' => array(
								'rgb' => '000000'
							)
						)
					)			 
				));
			}

			$objPHPExcel->getActiveSheet()->setCellValue ('A'.$baris,$no);
			$objPHPExcel->getActiveSheet()->setCellValue ('B'.$baris,$item['tgl']);
			$objPHPExcel->getActiveSheet()->setCellValue ('C'.$baris,$item['nama_pasien']);
			$objPHPExcel->getActiveSheet()->setCellValue ('D'.$baris,$item['kd_pasien']);
			$baris++;
			$no++;
					# code...
		}		
		//for($baris=5;$baris<=14;$baris++){
		//}

		//$objPHPExcel->getActiveSheet()->setCellValue ('D9',"19090");			

		$objWriter = IOFactory::createWriter($objPHPExcel, 'Excel5'); 
		$objWriter->save("download/rekapanrwibpjs.xls");
		redirect(base_url()."download/rekapanrwibpjs.xls");

	}

	public function laporanpendapatanrwjxls($periodeawal="",$periodeakhir="",$jenis_pasien=""){
		//$periodeawal=$this->input->post('periodeawal');
		//$periodeakhir=$this->input->post('periodeakhir');
		//$param=$this->input->post('param');
		//$shift=$this->input->post('shift');
		$items=$this->mpoli->lapPendapatanLabRWJ(convertDate($periodeawal),convertDate($periodeakhir),$jenis_pasien);

		$this->load->library('phpexcel'); 
		$this->load->library('PHPExcel/iofactory');
		//$objPHPExcel = new PHPExcel(); 

		// read in the existing file
		$objPHPExcel = IOFactory::load("./lab/laporanpendapatanrwj.xls");
		//$items=$this->mlaporanrl->getAllRL1(convertDate($periodeawal),convertDate($periodeakhir),$param,$shift);
		$bulan=array(
			'01'=>'Januari',
			'02'=>'Februari',
			'03'=>'Maret',
			'04'=>'April',
			'05'=>'Mei',
			'06'=>'Juni',
			'07'=>'Juli',
			'08'=>'Agustus',
			'09'=>'September',
			'10'=>'Oktober',
			'11'=>'November',
			'12'=>'Desember',
			);
		if($jenis_pasien==1){
		$objPHPExcel->getActiveSheet()->setCellValue ('A1',"PASIEN LABORATORIUM RAWAT JALAN UMUM");	
		}else if($jenis_pasien==2){
		$objPHPExcel->getActiveSheet()->setCellValue ('A1',"PASIEN LABORATORIUM RAWAT JALAN PIUTANG");	
		}else{
		$objPHPExcel->getActiveSheet()->setCellValue ('A1',"PASIEN LABORATORIUM RAWAT JALAN");	
		}
		$baris=3;
		$no=1;
		foreach ($items as $item) {
			for($x='A';$x<='F';$x++){

			
				$objPHPExcel->getActiveSheet()->getStyle($x.$baris)->applyFromArray(array(
					'font'    => array(
						'name'      => 'calibri',
						'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
						'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
						'size'		=>12,
						'color'     => array(
							'rgb' => '000000'
						)
					),
					'borders' => array(
						'bottom'     => array(
							'style' => PHPExcel_Style_Border::BORDER_THIN,
							'color' => array(
								'rgb' => '000000'
							)
						),
						'top'     => array(
							'style' => PHPExcel_Style_Border::BORDER_THIN,
							'color' => array(
								'rgb' => '000000'
							)
						),
						'left'     => array(
							'style' => PHPExcel_Style_Border::BORDER_THIN,
							'color' => array(
								'rgb' => '000000'
							)
						),
						'right'     => array(
							'style' => PHPExcel_Style_Border::BORDER_THIN,
							'color' => array(
								'rgb' => '000000'
							)
						)
					)			 
				));
			}
			if($item['kd_pelayanan'] == NULL && $item['no_pendaftaran'] != NULL){
				$objPHPExcel->getActiveSheet()->mergeCells('A'.$baris.':E'.$baris);
				$objPHPExcel->getActiveSheet()->setCellValue ('A'.$baris,"Sub Total");
				$objPHPExcel->getActiveSheet()->setCellValue ('F'.$baris,$item['pendapatan']);
				$no=0;
			}else if($item['kd_pelayanan'] == NULL && $item['no_pendaftaran'] == NULL){
				$objPHPExcel->getActiveSheet()->mergeCells('A'.$baris.':E'.$baris);
				$objPHPExcel->getActiveSheet()->setCellValue ('A'.$baris,"Total");
				$objPHPExcel->getActiveSheet()->setCellValue ('F'.$baris,$item['pendapatan']);
				$no=0;
			}else{
				$objPHPExcel->getActiveSheet()->setCellValue ('A'.$baris,$no);
				$objPHPExcel->getActiveSheet()->setCellValue ('B'.$baris,$item['no_pendaftaran']);
				$objPHPExcel->getActiveSheet()->setCellValue ('C'.$baris,$item['kd_pasien']);
				$objPHPExcel->getActiveSheet()->setCellValue ('D'.$baris,$item['nama_pasien']);				
				$objPHPExcel->getActiveSheet()->setCellValue ('E'.$baris,$item['nama_pelayanan']);				
				$objPHPExcel->getActiveSheet()->setCellValue ('F'.$baris,$item['pendapatan']);				
			}
			$baris++;
			$no++;
					# code...
		}		
		//for($baris=5;$baris<=14;$baris++){
		//}

		//$objPHPExcel->getActiveSheet()->setCellValue ('D9',"19090");			

		$objWriter = IOFactory::createWriter($objPHPExcel, 'Excel5'); 
		$objWriter->save("download/laporanpendapatanrwj.xls");
		redirect(base_url()."download/laporanpendapatanrwj.xls");

	}

	public function laporanpendapatanrwixls($periodeawal="",$periodeakhir="",$jenis_pasien=""){
		//$periodeawal=$this->input->post('periodeawal');
		//$periodeakhir=$this->input->post('periodeakhir');
		//$param=$this->input->post('param');
		//$shift=$this->input->post('shift');
		$items=$this->mpoli->lapPendapatanLabRWI(convertDate($periodeawal),convertDate($periodeakhir),$jenis_pasien);

		$this->load->library('phpexcel'); 
		$this->load->library('PHPExcel/iofactory');
		//$objPHPExcel = new PHPExcel(); 

		// read in the existing file
		$objPHPExcel = IOFactory::load("./lab/laporanpendapatanrwi.xls");
		//$items=$this->mlaporanrl->getAllRL1(convertDate($periodeawal),convertDate($periodeakhir),$param,$shift);
		$bulan=array(
			'01'=>'Januari',
			'02'=>'Februari',
			'03'=>'Maret',
			'04'=>'April',
			'05'=>'Mei',
			'06'=>'Juni',
			'07'=>'Juli',
			'08'=>'Agustus',
			'09'=>'September',
			'10'=>'Oktober',
			'11'=>'November',
			'12'=>'Desember',
			);
		if($jenis_pasien==1){
		$objPHPExcel->getActiveSheet()->setCellValue ('A1',"PASIEN LABORATORIUM RAWAT INAP UMUM");	
		}else if($jenis_pasien==2){
		$objPHPExcel->getActiveSheet()->setCellValue ('A1',"PASIEN LABORATORIUM RAWAT INAP PIUTANG");	
		}else{
		$objPHPExcel->getActiveSheet()->setCellValue ('A1',"PASIEN LABORATORIUM RAWAT INAP");	
		}
		$baris=3;
		$no=1;
		foreach ($items as $item) {
			for($x='A';$x<='F';$x++){

			
				$objPHPExcel->getActiveSheet()->getStyle($x.$baris)->applyFromArray(array(
					'font'    => array(
						'name'      => 'calibri',
						'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
						'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
						'size'		=>12,
						'color'     => array(
							'rgb' => '000000'
						)
					),
					'borders' => array(
						'bottom'     => array(
							'style' => PHPExcel_Style_Border::BORDER_THIN,
							'color' => array(
								'rgb' => '000000'
							)
						),
						'top'     => array(
							'style' => PHPExcel_Style_Border::BORDER_THIN,
							'color' => array(
								'rgb' => '000000'
							)
						),
						'left'     => array(
							'style' => PHPExcel_Style_Border::BORDER_THIN,
							'color' => array(
								'rgb' => '000000'
							)
						),
						'right'     => array(
							'style' => PHPExcel_Style_Border::BORDER_THIN,
							'color' => array(
								'rgb' => '000000'
							)
						)
					)			 
				));
			}
			if($item['kd_pelayanan'] == NULL && $item['no_pendaftaran'] != NULL){
				$objPHPExcel->getActiveSheet()->mergeCells('A'.$baris.':E'.$baris);
				$objPHPExcel->getActiveSheet()->setCellValue ('A'.$baris,"Sub Total");
				$objPHPExcel->getActiveSheet()->setCellValue ('F'.$baris,$item['pendapatan']);
				$no=0;
			}else if($item['kd_pelayanan'] == NULL && $item['no_pendaftaran'] == NULL){
				$objPHPExcel->getActiveSheet()->mergeCells('A'.$baris.':E'.$baris);
				$objPHPExcel->getActiveSheet()->setCellValue ('A'.$baris,"Total");
				$objPHPExcel->getActiveSheet()->setCellValue ('F'.$baris,$item['pendapatan']);
				$no=0;
			}else{
				$objPHPExcel->getActiveSheet()->setCellValue ('A'.$baris,$no);
				$objPHPExcel->getActiveSheet()->setCellValue ('B'.$baris,$item['no_pendaftaran']);
				$objPHPExcel->getActiveSheet()->setCellValue ('C'.$baris,$item['kd_pasien']);
				$objPHPExcel->getActiveSheet()->setCellValue ('D'.$baris,$item['nama_pasien']);				
				$objPHPExcel->getActiveSheet()->setCellValue ('E'.$baris,$item['nama_pelayanan']);				
				$objPHPExcel->getActiveSheet()->setCellValue ('F'.$baris,$item['pendapatan']);				
			}
			$baris++;
			$no++;
					# code...
		}		
		//for($baris=5;$baris<=14;$baris++){
		//}

		//$objPHPExcel->getActiveSheet()->setCellValue ('D9',"19090");			

		$objWriter = IOFactory::createWriter($objPHPExcel, 'Excel5'); 
		$objWriter->save("download/laporanpendapatanrwi.xls");
		redirect(base_url()."download/laporanpendapatanrwi.xls");

	}

	public function laporanrekapjumlahpasienxls($bln="",$tahun="",$unit=""){
		//$periodeawal=$this->input->post('periodeawal');
		//$periodeakhir=$this->input->post('periodeakhir');
		//$param=$this->input->post('param');
		//$shift=$this->input->post('shift');
		$lastday = date('t',strtotime('3/'.$bln.'/'.$tahun.''));

		$this->load->library('phpexcel'); 
		$this->load->library('PHPExcel/iofactory');
		$objPHPExcel = new PHPExcel(); 

		// read in the existing file
		//$objPHPExcel = IOFactory::load("./lab/rekapanrwibpjs.xls");
		//$items=$this->mlaporanrl->getAllRL1(convertDate($periodeawal),convertDate($periodeakhir),$param,$shift);
		$bulan=array(
			'01'=>'Januari',
			'02'=>'Februari',
			'03'=>'Maret',
			'04'=>'April',
			'05'=>'Mei',
			'06'=>'Juni',
			'07'=>'Juli',
			'08'=>'Agustus',
			'09'=>'September',
			'10'=>'Oktober',
			'11'=>'November',
			'12'=>'Desember',
			);
		//$objPHPExcel->getActiveSheet()->setCellValue ('A2',"Tahun : ".$tahun);	
		$objPHPExcel->getActiveSheet()->getStyle("A1")->applyFromArray(array(
			'font'    => array(
				'name'      => 'calibri',
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
				'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
				'size'		=>12,
				'color'     => array(
					'rgb' => '000000'
				)
			),
			'borders' => array(
				'bottom'     => array(
					'style' => PHPExcel_Style_Border::BORDER_THIN,
					'color' => array(
						'rgb' => '000000'
					)
				),
				'top'     => array(
					'style' => PHPExcel_Style_Border::BORDER_THIN,
					'color' => array(
						'rgb' => '000000'
					)
				),
				'left'     => array(
					'style' => PHPExcel_Style_Border::BORDER_THIN,
					'color' => array(
						'rgb' => '000000'
					)
				),
				'right'     => array(
					'style' => PHPExcel_Style_Border::BORDER_THIN,
					'color' => array(
						'rgb' => '000000'
					)
				)
			)			 
		));

		$unit_kerja="";
		if($unit==1)$unit_kerja=" and (c.parent=10 or c.kd_unit_kerja=1)";
		if($unit==2)$unit_kerja=" and (c.parent=8)";

		for ($baris=1; $baris <= 12; $baris++) { 
			# code...
			if($baris==1){
				$objPHPExcel->getActiveSheet()->setCellValue ("A".$baris,$bulan[$bln]."-".$tahun);				
			}
			if($baris==2){
				$objPHPExcel->getActiveSheet()->setCellValue ("A".$baris,"Hb/LEUKO");				
			}
			if($baris==3){
				$objPHPExcel->getActiveSheet()->setCellValue ("A".$baris,"Dl");				
			}
			if($baris==4){
				$objPHPExcel->getActiveSheet()->setCellValue ("A".$baris,"CT");				
			}
			if($baris==5){
				$objPHPExcel->getActiveSheet()->setCellValue ("A".$baris,"BT");				
			}
			if($baris==6){
				$objPHPExcel->getActiveSheet()->setCellValue ("A".$baris,"GDS");				
			}
			if($baris==7){
				$objPHPExcel->getActiveSheet()->setCellValue ("A".$baris,"GOLDA");				
			}
			if($baris==8){
				$objPHPExcel->getActiveSheet()->setCellValue ("A".$baris,"UL");				
			}
			if($baris==9){
				$objPHPExcel->getActiveSheet()->setCellValue ("A".$baris,"AG");				
			}
			if($baris==10){
				$objPHPExcel->getActiveSheet()->setCellValue ("A".$baris,"AB");				
			}
			if($baris==11){
				$objPHPExcel->getActiveSheet()->setCellValue ("A".$baris,"HIV");				
			}
			
			if($baris==12){
				$objPHPExcel->getActiveSheet()->setCellValue ("A".$baris,"WIDAL");				
			}
			
			if($baris==13){
				$objPHPExcel->getActiveSheet()->setCellValue ("A".$baris,"PPTEST");				
			}
			
			$kolom="B";
			$kolomtambahan="A";
			for ($i=1; $i <= $lastday ; $i++) { 
				# code...
				$objPHPExcel->getActiveSheet()->getStyle($kolom.$baris)->applyFromArray(array(
					'font'    => array(
						'name'      => 'calibri',
						'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
						'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
						'size'		=>12,
						'color'     => array(
							'rgb' => '000000'
						)
					),
					'borders' => array(
						'bottom'     => array(
							'style' => PHPExcel_Style_Border::BORDER_THIN,
							'color' => array(
								'rgb' => '000000'
							)
						),
						'top'     => array(
							'style' => PHPExcel_Style_Border::BORDER_THIN,
							'color' => array(
								'rgb' => '000000'
							)
						),
						'left'     => array(
							'style' => PHPExcel_Style_Border::BORDER_THIN,
							'color' => array(
								'rgb' => '000000'
							)
						),
						'right'     => array(
							'style' => PHPExcel_Style_Border::BORDER_THIN,
							'color' => array(
								'rgb' => '000000'
							)
						)
					)			 
				));

				//$objPHPExcel->getActiveSheet()->setCellValue ($kolom.1,$bulan.'-'.$tahun);
				if($baris==1){
					$objPHPExcel->getActiveSheet()->setCellValue ($kolom.$baris,$i);					
				}
				if($baris==2){
					$query=$this->db->query("select count(1) as jumlah from biaya_pelayanan a join pendaftaran b on a.no_pendaftaran=b.no_pendaftaran join unit_kerja c on b.kd_unit_kerja=c.kd_unit_kerja where kd_pelayanan='1502' and day(tgl_pelayanan)='".$i."' and month(tgl_pelayanan)='".$bln."' and year(tgl_pelayanan)='".$tahun."' ".$unit_kerja." ");
					$item=$query->row_array();
					$objPHPExcel->getActiveSheet()->setCellValue ($kolom.$baris,$item['jumlah']);				
				}

				if($baris==3){
					$query=$this->db->query("select count(1) as jumlah from biaya_pelayanan a join pendaftaran b on a.no_pendaftaran=b.no_pendaftaran join unit_kerja c on b.kd_unit_kerja=c.kd_unit_kerja where kd_pelayanan='1515' and day(tgl_pelayanan)='".$i."' and month(tgl_pelayanan)='".$bln."' and year(tgl_pelayanan)='".$tahun."' ".$unit_kerja." ");
					$item=$query->row_array();
					$objPHPExcel->getActiveSheet()->setCellValue ($kolom.$baris,$item['jumlah']);				
				}

				if($baris==4){
					$query=$this->db->query("select count(1) as jumlah from biaya_pelayanan a join pendaftaran b on a.no_pendaftaran=b.no_pendaftaran join unit_kerja c on b.kd_unit_kerja=c.kd_unit_kerja where kd_pelayanan='1510' and day(tgl_pelayanan)='".$i."' and month(tgl_pelayanan)='".$bln."' and year(tgl_pelayanan)='".$tahun."' ".$unit_kerja." ");
					$item=$query->row_array();
					$objPHPExcel->getActiveSheet()->setCellValue ($kolom.$baris,$item['jumlah']);				
				}

				if($baris==5){
					$query=$this->db->query("select count(1) as jumlah from biaya_pelayanan a join pendaftaran b on a.no_pendaftaran=b.no_pendaftaran join unit_kerja c on b.kd_unit_kerja=c.kd_unit_kerja where kd_pelayanan='1511' and day(tgl_pelayanan)='".$i."' and month(tgl_pelayanan)='".$bln."' and year(tgl_pelayanan)='".$tahun."' ".$unit_kerja." ");
					$item=$query->row_array();
					$objPHPExcel->getActiveSheet()->setCellValue ($kolom.$baris,$item['jumlah']);				
				}

				if($baris==6){
					$query=$this->db->query("select count(1) as jumlah from biaya_pelayanan a join pendaftaran b on a.no_pendaftaran=b.no_pendaftaran join unit_kerja c on b.kd_unit_kerja=c.kd_unit_kerja where kd_pelayanan='1522' and day(tgl_pelayanan)='".$i."' and month(tgl_pelayanan)='".$bln."' and year(tgl_pelayanan)='".$tahun."' ".$unit_kerja." ");
					$item=$query->row_array();
					$objPHPExcel->getActiveSheet()->setCellValue ($kolom.$baris,$item['jumlah']);				
				}

				if($baris==7){
					$query=$this->db->query("select count(1) as jumlah from biaya_pelayanan a join pendaftaran b on a.no_pendaftaran=b.no_pendaftaran join unit_kerja c on b.kd_unit_kerja=c.kd_unit_kerja where kd_pelayanan in ('1518','1509') and day(tgl_pelayanan)='".$i."' and month(tgl_pelayanan)='".$bln."' and year(tgl_pelayanan)='".$tahun."' ".$unit_kerja." ");
					$item=$query->row_array();
					$objPHPExcel->getActiveSheet()->setCellValue ($kolom.$baris,$item['jumlah']);				
				}

				if($baris==8){
					$query=$this->db->query("select count(1) as jumlah from biaya_pelayanan a join pendaftaran b on a.no_pendaftaran=b.no_pendaftaran join unit_kerja c on b.kd_unit_kerja=c.kd_unit_kerja where kd_pelayanan in ('1551') and day(tgl_pelayanan)='".$i."' and month(tgl_pelayanan)='".$bln."' and year(tgl_pelayanan)='".$tahun."' ".$unit_kerja." ");
					$item=$query->row_array();
					$objPHPExcel->getActiveSheet()->setCellValue ($kolom.$baris,$item['jumlah']);				
				}

				if($baris==9){
					$query=$this->db->query("select count(1) as jumlah from biaya_pelayanan a join pendaftaran b on a.no_pendaftaran=b.no_pendaftaran join unit_kerja c on b.kd_unit_kerja=c.kd_unit_kerja where kd_pelayanan in ('1504') and day(tgl_pelayanan)='".$i."' and month(tgl_pelayanan)='".$bln."' and year(tgl_pelayanan)='".$tahun."' ".$unit_kerja." ");
					$item=$query->row_array();
					$objPHPExcel->getActiveSheet()->setCellValue ($kolom.$baris,$item['jumlah']);				
				}

				if($baris==10){
					$query=$this->db->query("select count(1) as jumlah from biaya_pelayanan a join pendaftaran b on a.no_pendaftaran=b.no_pendaftaran join unit_kerja c on b.kd_unit_kerja=c.kd_unit_kerja where kd_pelayanan in ('1505') and day(tgl_pelayanan)='".$i."' and month(tgl_pelayanan)='".$bln."' and year(tgl_pelayanan)='".$tahun."' ".$unit_kerja." ");
					$item=$query->row_array();
					$objPHPExcel->getActiveSheet()->setCellValue ($kolom.$baris,$item['jumlah']);				
				}

				if($baris==11){
					$query=$this->db->query("select count(1) as jumlah from biaya_pelayanan a join pendaftaran b on a.no_pendaftaran=b.no_pendaftaran join unit_kerja c on b.kd_unit_kerja=c.kd_unit_kerja where kd_pelayanan in ('1550') and day(tgl_pelayanan)='".$i."' and month(tgl_pelayanan)='".$bln."' and year(tgl_pelayanan)='".$tahun."' ".$unit_kerja." ");
					$item=$query->row_array();
					$objPHPExcel->getActiveSheet()->setCellValue ($kolom.$baris,$item['jumlah']);				
				}

				if($baris==12){
					$query=$this->db->query("select count(1) as jumlah from biaya_pelayanan a join pendaftaran b on a.no_pendaftaran=b.no_pendaftaran join unit_kerja c on b.kd_unit_kerja=c.kd_unit_kerja where kd_pelayanan in ('1545','1546') and day(tgl_pelayanan)='".$i."' and month(tgl_pelayanan)='".$bln."' and year(tgl_pelayanan)='".$tahun."' ".$unit_kerja." ");
					$item=$query->row_array();
					$objPHPExcel->getActiveSheet()->setCellValue ($kolom.$baris,$item['jumlah']);				
				}

				if($baris==13){
					$query=$this->db->query("select count(1) as jumlah from biaya_pelayanan a join pendaftaran b on a.no_pendaftaran=b.no_pendaftaran join unit_kerja c on b.kd_unit_kerja=c.kd_unit_kerja where kd_pelayanan in ('1508','1553') and day(tgl_pelayanan)='".$i."' and month(tgl_pelayanan)='".$bln."' and year(tgl_pelayanan)='".$tahun."' ".$unit_kerja." ");
					$item=$query->row_array();
					$objPHPExcel->getActiveSheet()->setCellValue ($kolom.$baris,$item['jumlah']);				
				}


				if($kolom=="Z" || strlen($kolom)==2){
					$kolom="A".$kolomtambahan;
					$kolomtambahan++;
				}else{
					$kolom++;				
				}			
			}			
		}

	
		//for($baris=5;$baris<=14;$baris++){
		//}

		//$objPHPExcel->getActiveSheet()->setCellValue ('D9',"19090");			

		$objWriter = IOFactory::createWriter($objPHPExcel, 'Excel5'); 
		$objWriter->save("download/rekapanjumlahpasien.xls");
		redirect(base_url()."download/rekapanjumlahpasien.xls");

	}

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */