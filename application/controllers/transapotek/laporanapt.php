<?php if (! defined('BASEPATH')) exit('No direct script access allowed');

include_once(APPPATH . 'controllers/rumahsakit.php');
//class Laporanapt extends CI_Controller {
class Laporanapt extends Rumahsakit
{



	protected $title = 'GFK BALIKPAPAN';

	public function __construct()
	{
		parent::__construct();

		$this->load->helper('form');
		$this->load->helper('utilities');
		$this->load->library('pagination');
		$this->load->model('apotek/mlaporanapt');
		$this->load->helper('url');
	}

	public function restricted()
	{
		$cssfileheader = array('bootstrap.css', 'bootstrap-responsive.min.css', 'font-awesome.min.css', 'style.css', 'prettify.css', 'jquery-ui.css', 'DT_bootstrap.css', 'responsive-tables.css', 'datepicker.css', 'theme.css');
		$jsfileheader = array(
			'vendor/modernizr-2.6.2-respond-1.1.0.min.js',
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
			'main.js'
		);
		$dataheader = array(
			'jsfile' => $jsfileheader,
			'cssfile' => $cssfileheader,
			'title' => $this->title
		);

		$jsfooter = array();
		$datafooter = array(
			'jsfile' => $jsfooter
		);

		//$this->load->view('master/header',$dataheader);
		$this->load->view('headerapotek', $dataheader);
		$data = array();
		parent::view_restricted($data);
		$this->load->view('footer');
	}

	public function index()
	{
		$cssfileheader = array('bootstrap.min.css', 'bootstrap-responsive.min.css', 'font-awesome.min.css', 'style.css', 'prettify.css', 'jquery-ui.css', 'DT_bootstrap.css', 'responsive-tables.css', 'datepicker.css', 'theme.css');
		$jsfileheader = array(
			'vendor/modernizr-2.6.2-respond-1.1.0.min.js',
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
			'main.js',
			'style-switcher.js'
		);
		$dataheader = array('jsfile' => $jsfileheader, 'cssfile' => $cssfileheader, 'title' => $this->title);
		$jsfooter = array();
		$datafooter = array('jsfile' => $jsfooter);
		$data = array();
		$this->load->view('headerapotek', $dataheader);
		$this->load->view('', $data);
		$this->load->view('footer', $datafooter);
	}

	public function penerimaanapotek()
	{
		if (!$this->muser->isAkses("69")) {
			$this->restricted();
			return false;
		}

		//$shift='';
		$periodeawal = date('d-m-Y');
		$periodeakhir = date('d-m-Y');
		//$tgl_tempo='';
		$kd_unit_apt = $this->session->userdata('kd_unit_apt');
		$nama_unit_apt = $this->input->post('nama_unit_apt');
		$kd_supplier = '';
		$kd_pabrik = '';

		/*if($this->input->post('shift')!=''){
			$shift=$this->input->post('shift');
		}*/
		if ($this->input->post('periodeawal') != '') {
			$periodeawal = $this->input->post('periodeawal');
		}
		if ($this->input->post('periodeakhir') != '') {
			$periodeakhir = $this->input->post('periodeakhir');
		}
		/*if($this->input->post('tgl_tempo')!=''){
			$tgl_tempo=$this->input->post('tgl_tempo');
		}*/
		if ($this->input->post('kd_unit_apt') != '') {
			$kd_unit_apt = $this->input->post('kd_unit_apt');
		}
		if ($this->input->post('kd_supplier') != '') {
			$kd_supplier = $this->input->post('kd_supplier');
		}

		$cssfileheader = array('bootstrap.css', 'bootstrap-responsive.min.css', 'font-awesome.min.css', 'style.css', 'prettify.css', 'jquery-ui.css', 'DT_bootstrap.css', 'responsive-tables.css', 'datepicker.css', 'theme.css');
		$jsfileheader = array(
			'vendor/modernizr-2.6.2-respond-1.1.0.min.js',
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
			'lib/bootstrap-modal.js',
			'spin.js',
			'main.js'
		);
		$dataheader = array('jsfile' => $jsfileheader, 'cssfile' => $cssfileheader, 'title' => $this->title);

		$jsfooter = array();
		$datafooter = array('jsfile' => $jsfooter);

		$data = array(
			'sumberdana' => $this->mlaporanapt->sumberdana(),
			'items' => $this->mlaporanapt->getAllPenerimaanApotek($periodeawal, $periodeakhir, $kd_unit_apt, $kd_supplier),
			//'unitapotek'=>$this->mlaporanapt->ambilData('apt_unit'),
			'datasupplier' => $this->mlaporanapt->ambilData("apt_supplier", "is_aktif='1'"),
			'periodeawal' => $periodeawal,
			'periodeakhir' => $periodeakhir,
			'kd_unit_apt' => $kd_unit_apt,
			'kd_supplier' => $kd_supplier
		);

		$this->load->view('headerapotek', $dataheader);
		$this->load->view('laporanapotek/penerimaanapotek', $data);
		$this->load->view('footer', $datafooter);
	}

	public function penjualanobatapotek()
	{
		if (!$this->muser->isAkses("77")) {
			$this->restricted();
			return false;
		}


		$periodeawal = date('d-m-Y');
		$periodeakhir = date('d-m-Y');

		if ($this->input->post('periodeawal') != '') {
			$periodeawal = $this->input->post('periodeawal');
		}
		if ($this->input->post('periodeakhir') != '') {
			$periodeakhir = $this->input->post('periodeakhir');
		}
		if ($this->input->post('kd_unit_apt') != '') {
			$kd_unit_apt = $this->input->post('kd_unit_apt');
		} else {
			$kd_unit_apt = "";
		}

		$cssfileheader = array('bootstrap.css', 'bootstrap-responsive.min.css', 'font-awesome.min.css', 'style.css', 'prettify.css', 'jquery-ui.css', 'DT_bootstrap.css', 'responsive-tables.css', 'datepicker.css', 'theme.css');
		$jsfileheader = array(
			'vendor/modernizr-2.6.2-respond-1.1.0.min.js',
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
			'lib/bootstrap-modal.js',
			'spin.js',
			'main.js'
		);
		$dataheader = array('jsfile' => $jsfileheader, 'cssfile' => $cssfileheader, 'title' => $this->title);

		$jsfooter = array();
		$datafooter = array('jsfile' => $jsfooter);

		$data = array(
			'items' => $this->mlaporanapt->ambilIsiPenjualan($periodeawal, $periodeakhir, $kd_unit_apt),
			'sumberdana' => $this->mlaporanapt->sumberdana(),
			'periodeawal' => $periodeawal,
			'periodeakhir' => $periodeakhir,
			'kd_unit_apt' => $kd_unit_apt
		);

		$this->load->view('headerapotek', $dataheader);
		$this->load->view('laporanapotek/penjualanobatapotek', $data);
		$this->load->view('footer', $datafooter);
	}

	public function penjualanapotek()
	{
		if (!$this->muser->isAkses("76")) {
			$this->restricted();
			return false;
		}

		$periodeawal = date('d-m-Y');
		$periodeakhir = date('d-m-Y');
		$shiftapt = '';
		$is_lunas = '';


		$resep = '';
		if ($this->input->post('periodeawal') != '') {
			$periodeawal = $this->input->post('periodeawal');
		}
		if ($this->input->post('periodeakhir') != '') {
			$periodeakhir = $this->input->post('periodeakhir');
		}
		if ($this->input->post('shiftapt') != '') {
			$shiftapt = $this->input->post('shiftapt');
		}
		if ($this->input->post('is_lunas') != '') {
			$is_lunas = $this->input->post('is_lunas');
		}
		if ($this->input->post('resep') != '') {
			$resep = $this->input->post('resep');
		}
		$cssfileheader = array('bootstrap.css', 'bootstrap-responsive.min.css', 'font-awesome.min.css', 'style.css', 'prettify.css', 'jquery-ui.css', 'DT_bootstrap.css', 'responsive-tables.css', 'datepicker.css', 'theme.css');
		$jsfileheader = array(
			'vendor/modernizr-2.6.2-respond-1.1.0.min.js',
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
			'lib/bootstrap-modal.js',
			'spin.js',
			'main.js'
		);
		$dataheader = array('jsfile' => $jsfileheader, 'cssfile' => $cssfileheader, 'title' => $this->title);

		$jsfooter = array();
		$datafooter = array('jsfile' => $jsfooter);

		$data = array(
			'items' => $this->mlaporanapt->getAllPenjualanApotek($periodeawal, $periodeakhir, $shiftapt, $is_lunas, $resep),
			'periodeawal' => $periodeawal,
			'periodeakhir' => $periodeakhir,
			'shiftapt' => $shiftapt,
			'is_lunas' => $is_lunas,
			'unitapotek' => $this->mlaporanapt->ambilData('apt_unit'),
			'resep' => $resep
		);

		$this->load->view('headerapotek', $dataheader);
		$this->load->view('laporanapotek/penjualanapotek', $data);
		$this->load->view('footer', $datafooter);
	}

	public function distribusiapotek()
	{
		if (!$this->muser->isAkses("71")) {
			$this->restricted();
			return false;
		}

		$kd_unit_asal = $this->session->userdata('kd_unit_apt');
		$periodeawal = date('d-m-Y');
		$periodeakhir = date('d-m-Y');
		if ($this->input->post('periodeawal') != '') {
			$periodeawal = $this->input->post('periodeawal');
		}
		if ($this->input->post('periodeakhir') != '') {
			$periodeakhir = $this->input->post('periodeakhir');
		}
		$cssfileheader = array('bootstrap.css', 'bootstrap-responsive.min.css', 'font-awesome.min.css', 'style.css', 'prettify.css', 'jquery-ui.css', 'DT_bootstrap.css', 'responsive-tables.css', 'datepicker.css', 'theme.css');
		$jsfileheader = array(
			'vendor/modernizr-2.6.2-respond-1.1.0.min.js',
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
			'lib/bootstrap-modal.js',
			'spin.js',
			'main.js'
		);
		$dataheader = array('jsfile' => $jsfileheader, 'cssfile' => $cssfileheader, 'title' => $this->title);

		$jsfooter = array();
		$datafooter = array('jsfile' => $jsfooter);

		$data = array(
			'items' => $this->mlaporanapt->getAllDistribusiApotek($periodeawal, $periodeakhir, $kd_unit_asal),
			'unitapotek' => $this->mlaporanapt->ambilData('apt_unit'),
			'periodeawal' => $periodeawal,
			'periodeakhir' => $periodeakhir,
			'kd_unit_asal' => $kd_unit_asal
		);

		$this->load->view('headerapotek', $dataheader);
		$this->load->view('laporanapotek/distribusiapotek', $data);
		$this->load->view('footer', $datafooter);
	}

	public function persediaanapotek()
	{
		if (!$this->muser->isAkses("72")) {
			$this->restricted();
			return false;
		}
		$kd_golongan = '';
		$stok = '1';
		$isistok = '';
		if ($this->input->post('kd_unit_apt') != '') {
			$kd_unit_apt = $this->input->post('kd_unit_apt');
		} else {
			$kd_unit_apt = '';
		}
		if ($this->input->post('kd_golongan') != '') {
			$kd_golongan = $this->input->post('kd_golongan');
		}
		if ($this->input->post('stok') != '') {
			$stok = $this->input->post('stok');
		}
		if ($this->input->post('isistok') != '') {
			$isistok = $this->input->post('isistok');
		}
		$cssfileheader = array('bootstrap.css', 'bootstrap-responsive.min.css', 'font-awesome.min.css', 'style.css', 'prettify.css', 'jquery-ui.css', 'DT_bootstrap.css', 'responsive-tables.css', 'datepicker.css', 'theme.css');
		$jsfileheader = array(
			'vendor/modernizr-2.6.2-respond-1.1.0.min.js',
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
			'lib/bootstrap-modal.js',
			'spin.js',
			'main.js'
		);
		$dataheader = array('jsfile' => $jsfileheader, 'cssfile' => $cssfileheader, 'title' => $this->title);

		$jsfooter = array();
		$datafooter = array('jsfile' => $jsfooter);

		$data = array(
			'sumberdana' => $this->mlaporanapt->sumberdana(),
			'items' => $this->mlaporanapt->getAllPersediaanApotek($stok, $isistok, $kd_unit_apt, $kd_golongan),
			'golongan' => $this->mlaporanapt->ambilData('apt_golongan'),
			'kd_golongan' => $kd_golongan,
			'stok' => $stok,
			'isistok' => $isistok,
			'unitapotek' => $this->mlaporanapt->ambilData('apt_unit'),
			'kd_unit_apt' => $kd_unit_apt
		);

		$this->load->view('headerapotek', $dataheader);
		$this->load->view('laporanapotek/persediaanapotek', $data);
		$this->load->view('footer', $datafooter);
	}

	public function kartustok()
	{
		if (!$this->muser->isAkses("73")) {
			// $this->restricted();
			// return false;
		}

		$nama_obat = '';
		$kd_obat = '';
		$kd_unit_apt = '';
		$bulan = date('m');
		$tahun = date('Y');
		$submit1 = $this->input->post('submit1');

		if ($this->input->post('kd_unit_apt') != '') {
			$kd_unit_apt = $this->input->post('kd_unit_apt');
		}

		if ($this->input->post('nama_obat') != '') {
			$nama_obat = $this->input->post('nama_obat');
		}
		if ($this->input->post('kd_obat') != '') {
			$kd_obat = $this->input->post('kd_obat');
		}
		if ($this->input->post('bulan') != '') {
			$bulan = $this->input->post('bulan');
		}
		if ($this->input->post('tahun') != '') {
			$tahun = $this->input->post('tahun');
		}
		$cssfileheader = array('bootstrap.css', 'bootstrap-responsive.min.css', 'font-awesome.min.css', 'style.css', 'prettify.css', 'jquery-ui.css', 'DT_bootstrap.css', 'responsive-tables.css', 'datepicker.css', 'theme.css');
		$jsfileheader = array(
			'vendor/modernizr-2.6.2-respond-1.1.0.min.js',
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
			'lib/bootstrap-modal.js',
			'spin.js',
			'main.js'
		);
		$dataheader = array('jsfile' => $jsfileheader, 'cssfile' => $cssfileheader, 'title' => $this->title);

		$jsfooter = array();
		$datafooter = array('jsfile' => $jsfooter);
		$data = array(
			'sumberdana' => $this->mlaporanapt->sumberdana(),
			'items' => $this->mlaporanapt->getKartuStok($kd_obat, $kd_unit_apt, $bulan, $tahun),
			'nama_obat' => $nama_obat,
			'kd_obat' => $kd_obat,
			'kd_unit_apt' => $kd_unit_apt,
			'bulan' => $bulan,
			'tahun' => $tahun
		);

		$this->load->view('headerapotek', $dataheader);
		$this->load->view('laporanapotek/kartustok', $data);
		$this->load->view('footer', $datafooter);
	}

	public function kartustokbatch()
	{
		if (!$this->muser->isAkses("73")) {
			// $this->restricted();
			// return false;
		}

		$nama_obat = '';
		$kd_obat = '';
		$kd_unit_apt = '';
		$batch = $this->input->post('batch');
		$bulan = date('m');
		$tahun = date('Y');
		// die($batch);
		$submit1 = $this->input->post('submit1');

		if ($this->input->post('kd_unit_apt') != '') {
			$kd_unit_apt = $this->input->post('kd_unit_apt');
		}

		if ($this->input->post('nama_obat') != '') {
			$nama_obat = $this->input->post('nama_obat');
		}
		if ($this->input->post('kd_obat') != '') {
			$kd_obat = $this->input->post('kd_obat');
		}
		if ($this->input->post('bulan') != '') {
			$bulan = $this->input->post('bulan');
		}
		if ($this->input->post('tahun') != '') {
			$tahun = $this->input->post('tahun');
		}
		$cssfileheader = array('bootstrap.css', 'bootstrap-responsive.min.css', 'font-awesome.min.css', 'style.css', 'prettify.css', 'jquery-ui.css', 'DT_bootstrap.css', 'responsive-tables.css', 'datepicker.css', 'theme.css');
		$jsfileheader = array(
			'vendor/modernizr-2.6.2-respond-1.1.0.min.js',
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
			'lib/bootstrap-modal.js',
			'spin.js',
			'main.js'
		);
		$dataheader = array('jsfile' => $jsfileheader, 'cssfile' => $cssfileheader, 'title' => $this->title);

		$jsfooter = array();
		$datafooter = array('jsfile' => $jsfooter);
		$data = array(
			'sumberdana' => $this->mlaporanapt->sumberdana(),
			'items' => $this->mlaporanapt->getKartuStokBatch($kd_obat, $batch, $kd_unit_apt),
			'nama_obat' => $nama_obat,
			'kd_obat' => $kd_obat,
			'kd_unit_apt' => $kd_unit_apt,
			'batch' => $batch,
			'bulan' => $bulan,
			'tahun' => $tahun
		);
		// debugvar($data['items']);
		$this->load->view('headerapotek', $dataheader);
		$this->load->view('laporanapotek/kartustokbatch', $data);
		$this->load->view('footer', $datafooter);
	}


	public function ambilobatbynama()
	{
		/*$q=$this->input->get('query');
		$items=$this->mlaporanapt->ambilData4($q);
		echo json_encode($items);*/
		$nama_obat = $this->input->post('nama_obat');

		$this->datatables->select('kd_obat, replace(nama_obat,"\'","") as nama_obat, "Pilihan" as pilihan', false);

		$this->datatables->from("apt_obat");
		$this->datatables->edit_column('pilihan', '<a class="btn" onclick=\'pilihobat("$1","$2","$3")\'>Pilih</a>', 'kd_obat, nama_obat');
		if (!empty($nama_obat)) $this->datatables->like('nama_obat', $nama_obat, 'both');

		$results = $this->datatables->generate();
		echo ($results);
	}

	public function ambilobatbynamabatch()
	{
		/*$q=$this->input->get('query');
		$items=$this->mlaporanapt->ambilData4($q);
		echo json_encode($items);*/
		$nama_obat = $this->input->post('nama_obat');
		$kd_unit_apt = $this->input->post('kd_unit_apt');

		$this->datatables->select('apt_stok_unit.kd_obat, replace(apt_obat.nama_obat,"\'","") as nama_obat,apt_stok_unit.kd_pabrik,apt_stok_unit.batch,apt_stok_unit.tgl_expire,apt_stok_unit.harga_pokok, "Pilihan" as pilihan', false);
		$this->datatables->join('apt_obat', 'apt_stok_unit.kd_obat=apt_obat.kd_obat');
		$this->datatables->from("apt_stok_unit");
		$this->datatables->edit_column('pilihan', '<a class="btn" onclick=\'pilihobat("$1","$2","$3")\'>Pilih</a>', 'apt_stok_unit.kd_obat, nama_obat,apt_stok_unit.batch');
		if (!empty($nama_obat)) $this->datatables->like('nama_obat', $nama_obat, 'both');
		if (!empty($kd_unit_apt)) $this->datatables->where('kd_unit_apt', $kd_unit_apt);

		$results = $this->datatables->generate();
		echo ($results);
	}

	public function ambilobatbykode()
	{
		$q = $this->input->get('query');
		$items = $this->mlaporanapt->ambilData5($q);
		echo json_encode($items);
	}

	public function mutasiobat()
	{
		if (!$this->muser->isAkses("74")) {
			$this->restricted();
			return false;
		}

		$bulan = date('m');
		$tahun = date('Y');
		if ($this->input->post('kd_unit_apt') != '') {
			$kd_unit_apt = $this->input->post('kd_unit_apt');
		} else {
			$kd_unit_apt = '';
		}

		if ($this->input->post('bulan') != '') {
			$bulan = $this->input->post('bulan');
		}
		if ($this->input->post('tahun') != '') {
			$tahun = $this->input->post('tahun');
		}
		$cssfileheader = array('bootstrap.css', 'bootstrap-responsive.min.css', 'font-awesome.min.css', 'style.css', 'prettify.css', 'jquery-ui.css', 'DT_bootstrap.css', 'responsive-tables.css', 'datepicker.css', 'theme.css');
		$jsfileheader = array(
			'vendor/modernizr-2.6.2-respond-1.1.0.min.js',
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
			'lib/bootstrap-modal.js',
			'spin.js',
			'main.js'
		);
		$dataheader = array('jsfile' => $jsfileheader, 'cssfile' => $cssfileheader, 'title' => $this->title);

		$jsfooter = array();
		$datafooter = array('jsfile' => $jsfooter);

		$data = array(
			'sumberdana' => $this->mlaporanapt->sumberdana(),
			'items' => $this->mlaporanapt->getMutasiObat($kd_unit_apt, $bulan, $tahun),
			'unitapotek' => $this->mlaporanapt->ambilData('apt_unit'),
			'bulan' => $bulan,
			'tahun' => $tahun,
			'kd_unit_apt' => $kd_unit_apt
		);

		$this->load->view('headerapotek', $dataheader);
		$this->load->view('laporanapotek/mutasiobat', $data);
		$this->load->view('footer', $datafooter);
	}

	public function mutasiobattriwulan()
	{
		if (!$this->muser->isAkses("74")) {
			$this->restricted();
			return false;
		}

		$bulan = date('m');
		if ($this->input->post('triwulan') != '') {
			$triwulan = $this->input->post('triwulan');
		} else if ($bulan == '01' || $bulan == '02' || $bulan == '03') {
			$triwulan = '1';
		} else if ($bulan == '04' || $bulan == '05' || $bulan == '06') {
			$triwulan = '2';
		} else if ($bulan == '07' || $bulan == '08' || $bulan == '09') {
			$triwulan = '3';
		} else if ($bulan == '10' || $bulan == '11' || $bulan == '12') {
			$triwulan = '4';
		}
		// die($triwulan);
		$tahun = date('Y');
		if ($this->input->post('tahun') != '') {
			$tahun = $this->input->post('tahun');
		}
		$cssfileheader = array('bootstrap.css', 'bootstrap-responsive.min.css', 'font-awesome.min.css', 'style.css', 'prettify.css', 'jquery-ui.css', 'DT_bootstrap.css', 'responsive-tables.css', 'datepicker.css', 'theme.css');
		$jsfileheader = array(
			'vendor/modernizr-2.6.2-respond-1.1.0.min.js',
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
			'lib/bootstrap-modal.js',
			'spin.js',
			'main.js'
		);
		$dataheader = array('jsfile' => $jsfileheader, 'cssfile' => $cssfileheader, 'title' => $this->title);

		$jsfooter = array();
		$datafooter = array('jsfile' => $jsfooter);

		$data = array(
			'sumberdana' => $this->mlaporanapt->sumberdana(),
			'items' => $this->mlaporanapt->getMutasiObatTriwulan($tahun, $triwulan),
			'unitapotek' => $this->mlaporanapt->ambilData('apt_unit'),
			'triwulan' => $triwulan,
			'tahun' => $tahun
		);

		$this->load->view('headerapotek', $dataheader);
		$this->load->view('laporanapotek/mutasiobattriwulan', $data);
		$this->load->view('footer', $datafooter);
	}

	public function indikatorobat()
	{
		if (!$this->muser->isAkses("74")) {
			$this->restricted();
			return false;
		}

		$bulan = date('m');
		$tahun = date('Y');
		if ($this->input->post('kd_unit_apt') != '') {
			$kd_unit_apt = $this->input->post('kd_unit_apt');
		} else {
			$kd_unit_apt = '';
		}

		if ($this->input->post('bulan') != '') {
			$bulan = $this->input->post('bulan');
		}
		if ($this->input->post('tahun') != '') {
			$tahun = $this->input->post('tahun');
		}
		$cssfileheader = array('bootstrap.css', 'bootstrap-responsive.min.css', 'font-awesome.min.css', 'style.css', 'prettify.css', 'jquery-ui.css', 'DT_bootstrap.css', 'responsive-tables.css', 'datepicker.css', 'theme.css');
		$jsfileheader = array(
			'vendor/modernizr-2.6.2-respond-1.1.0.min.js',
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
			'lib/bootstrap-modal.js',
			'spin.js',
			'main.js'
		);
		$dataheader = array('jsfile' => $jsfileheader, 'cssfile' => $cssfileheader, 'title' => $this->title);

		$jsfooter = array();
		$datafooter = array('jsfile' => $jsfooter);

		$data = array(
			'items' => $this->db->join('apt_obat', 'apt_indikator_obat.kd_obat=apt_obat.kd_obat')->get('apt_indikator_obat')->result_array(),
			'puskesmas' => $this->db->where('is_puskesmas', 1)->get('gfk_puskesmas')->result_array(),
			'bulan' => $bulan,
			'tahun' => $tahun
		);

		$this->load->view('headerapotek', $dataheader);
		$this->load->view('laporanapotek/indikatorobat', $data);
		$this->load->view('footer', $datafooter);
	}

	public function mutasiobatbulanan()
	{
		if (!$this->muser->isAkses("74")) {
			$this->restricted();
			return false;
		}

		$bulan = date('m');
		$bulan1 = date('m');
		$tahun = date('Y');
		$kd_nomenklatur = '';
		$bulan_kebutuhan = 18;
		if ($this->input->post('kd_unit_apt') != '') {
			$kd_unit_apt = $this->input->post('kd_unit_apt');
		} else {
			$kd_unit_apt = '';
		}

		$kategori = $this->input->post('kategori');

		if ($this->input->post('bulan') != '') {
			$bulan = $this->input->post('bulan');
		}
		if ($this->input->post('bulan1') != '') {
			$bulan1 = $this->input->post('bulan1');
		}
		if ($this->input->post('tahun') != '') {
			$tahun = $this->input->post('tahun');
		}
		if ($this->input->post('kd_nomenklatur') != '') {
			$kd_nomenklatur = $this->input->post('kd_nomenklatur');
		}
		if ($this->input->post('bulan_kebutuhan') != '') {
			$bulan_kebutuhan = $this->input->post('bulan_kebutuhan');
		}

		$cssfileheader = array('bootstrap.css', 'bootstrap-responsive.min.css', 'font-awesome.min.css', 'style.css', 'prettify.css', 'jquery-ui.css', 'DT_bootstrap.css', 'responsive-tables.css', 'datepicker.css', 'theme.css');
		$jsfileheader = array(
			'vendor/modernizr-2.6.2-respond-1.1.0.min.js',
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
			'lib/bootstrap-modal.js',
			'spin.js',
			'main.js'
		);
		$dataheader = array('jsfile' => $jsfileheader, 'cssfile' => $cssfileheader, 'title' => $this->title);

		$jsfooter = array();
		$datafooter = array('jsfile' => $jsfooter);

		$data = array(
			'sumberdana' => $this->mlaporanapt->sumberdana(),
			'items' => $this->mlaporanapt->getMutasiObatBulanan($kd_unit_apt, $bulan, $bulan1, $tahun, $kd_nomenklatur, $kategori),
			'unitapotek' => $this->mlaporanapt->ambilData('apt_unit'),
			'bulan' => $bulan,
			'bulan1' => $bulan1,
			'tahun' => $tahun,
			'bulan_kebutuhan' => $bulan_kebutuhan,
			'kd_nomenklatur' => $kd_nomenklatur,
			'kategori' => $kategori,
			'kd_unit_apt' => $kd_unit_apt
		);

		$this->load->view('headerapotek', $dataheader);
		$this->load->view('laporanapotek/mutasiobatperbulan', $data);
		$this->load->view('footer', $datafooter);
	}

	public function bulanan()
	{
		if (!$this->muser->isAkses("74")) {
			$this->restricted();
			return false;
		}

		$bulan = date('m');
		$bulan1 = date('m');
		$tahun = date('Y');
		if ($this->input->post('kd_unit_apt') != '') {
			$kd_unit_apt = $this->input->post('kd_unit_apt');
		} else {
			$kd_unit_apt = '';
		}

		if ($this->input->post('bulan1') != '') {
			$bulan1 = $this->input->post('bulan1');
		}
		if ($this->input->post('bulan') != '') {
			$bulan = $this->input->post('bulan');
		}
		if ($this->input->post('tahun') != '') {
			$tahun = $this->input->post('tahun');
		}
		$cssfileheader = array('bootstrap.css', 'bootstrap-responsive.min.css', 'font-awesome.min.css', 'style.css', 'prettify.css', 'jquery-ui.css', 'DT_bootstrap.css', 'responsive-tables.css', 'datepicker.css', 'theme.css');
		$jsfileheader = array(
			'vendor/modernizr-2.6.2-respond-1.1.0.min.js',
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
			'lib/bootstrap-modal.js',
			'spin.js',
			'main.js'
		);
		$dataheader = array('jsfile' => $jsfileheader, 'cssfile' => $cssfileheader, 'title' => $this->title);

		$jsfooter = array();
		$datafooter = array('jsfile' => $jsfooter);

		$data = array(
			'sumberdana' => $this->mlaporanapt->sumberdana(),
			'items' => $this->mlaporanapt->getMutasiObatBulanan($kd_unit_apt, $bulan, $bulan1, $tahun),
			'unitapotek' => $this->mlaporanapt->ambilData('apt_unit'),
			'bulan' => $bulan,
			'bulan1' => $bulan1,
			'tahun' => $tahun,
			'kd_unit_apt' => $kd_unit_apt
		);

		$this->load->view('headerapotek', $dataheader);
		$this->load->view('laporanapotek/mutasiobatbulanan', $data);
		$this->load->view('footer', $datafooter);
	}

	public function obatsas2()
	{
		if (!$this->muser->isAkses("74")) {
			$this->restricted();
			return false;
		}

		$bulan = date('m');
		$bulan1 = date('m');
		$tahun = date('Y');
		$kd_nomenklatur = '';
		$bulan_kebutuhan = 18;
		if ($this->input->post('kd_unit_apt') != '') {
			$kd_unit_apt = $this->input->post('kd_unit_apt');
		} else {
			$kd_unit_apt = '';
		}

		$kategori = $this->input->post('kategori');

		if ($this->input->post('bulan') != '') {
			$bulan = $this->input->post('bulan');
		}
		if ($this->input->post('bulan1') != '') {
			$bulan1 = $this->input->post('bulan1');
		}
		if ($this->input->post('tahun') != '') {
			$tahun = $this->input->post('tahun');
		}
		if ($this->input->post('kd_nomenklatur') != '') {
			$kd_nomenklatur = $this->input->post('kd_nomenklatur');
		}
		if ($this->input->post('bulan_kebutuhan') != '') {
			$bulan_kebutuhan = $this->input->post('bulan_kebutuhan');
		}

		$cssfileheader = array('bootstrap.css', 'bootstrap-responsive.min.css', 'font-awesome.min.css', 'style.css', 'prettify.css', 'jquery-ui.css', 'DT_bootstrap.css', 'responsive-tables.css', 'datepicker.css', 'theme.css');
		$jsfileheader = array(
			'vendor/modernizr-2.6.2-respond-1.1.0.min.js',
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
			'lib/bootstrap-modal.js',
			'spin.js',
			'main.js'
		);
		$dataheader = array('jsfile' => $jsfileheader, 'cssfile' => $cssfileheader, 'title' => $this->title);

		$jsfooter = array();
		$datafooter = array('jsfile' => $jsfooter);

		$data = array(
			'sumberdana' => $this->mlaporanapt->sumberdana(),
			'items' => $this->mlaporanapt->getMutasiObatSasBulanan($kd_unit_apt, $bulan, $bulan1, $tahun, $kd_nomenklatur, $kategori),
			'unitapotek' => $this->mlaporanapt->ambilData('apt_unit'),
			'bulan' => $bulan,
			'bulan1' => $bulan1,
			'tahun' => $tahun,
			'bulan_kebutuhan' => $bulan_kebutuhan,
			'kd_nomenklatur' => $kd_nomenklatur,
			'kategori' => $kategori,
			'kd_unit_apt' => $kd_unit_apt
		);

		$this->load->view('headerapotek', $dataheader);
		$this->load->view('laporanapotek/mutasiobatsasperbulan', $data);
		$this->load->view('footer', $datafooter);
	}

	public function obatsas()
	{
		if (!$this->muser->isAkses("74")) {
			// $this->restricted();
			// return false;
		}

		$bulan = date('m');
		$tahun = date('Y');
		if ($this->input->post('kd_unit_apt') != '') {
			$kd_unit_apt = $this->input->post('kd_unit_apt');
		} else {
			$kd_unit_apt = '';
		}

		if ($this->input->post('bulan') != '') {
			$bulan = $this->input->post('bulan');
		}
		if ($this->input->post('tahun') != '') {
			$tahun = $this->input->post('tahun');
		}
		$cssfileheader = array('bootstrap.css', 'bootstrap-responsive.min.css', 'font-awesome.min.css', 'style.css', 'prettify.css', 'jquery-ui.css', 'DT_bootstrap.css', 'responsive-tables.css', 'datepicker.css', 'theme.css');
		$jsfileheader = array(
			'vendor/modernizr-2.6.2-respond-1.1.0.min.js',
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
			'lib/bootstrap-modal.js',
			'spin.js',
			'main.js'
		);
		$dataheader = array('jsfile' => $jsfileheader, 'cssfile' => $cssfileheader, 'title' => $this->title);

		$jsfooter = array();
		$datafooter = array('jsfile' => $jsfooter);

		$data = array(
			'sumberdana' => $this->mlaporanapt->sumberdana(),
			'items' => $this->mlaporanapt->getMutasiObatSasBulanan2('12', 2024),
			'unitapotek' => $this->mlaporanapt->ambilData('apt_unit'),
			'bulan' => $bulan,
			'tahun' => $tahun,
			'kd_unit_apt' => $kd_unit_apt
		);

		$this->load->view('headerapotek', $dataheader);
		$this->load->view('laporanapotek/obatsas', $data);
		$this->load->view('footer', $datafooter);
	}


	public function sediaanpsikotropika()
	{
		if (!$this->muser->isAkses("74")) {
			$this->restricted();
			return false;
		}

		$bulan = date('m');
		$tahun = date('Y');
		if ($this->input->post('kd_unit_apt') != '') {
			$kd_unit_apt = $this->input->post('kd_unit_apt');
		} else {
			$kd_unit_apt = '';
		}

		if ($this->input->post('bulan') != '') {
			$bulan = $this->input->post('bulan');
		}
		if ($this->input->post('tahun') != '') {
			$tahun = $this->input->post('tahun');
		}
		$cssfileheader = array('bootstrap.css', 'bootstrap-responsive.min.css', 'font-awesome.min.css', 'style.css', 'prettify.css', 'jquery-ui.css', 'DT_bootstrap.css', 'responsive-tables.css', 'datepicker.css', 'theme.css');
		$jsfileheader = array(
			'vendor/modernizr-2.6.2-respond-1.1.0.min.js',
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
			'lib/bootstrap-modal.js',
			'spin.js',
			'main.js'
		);
		$dataheader = array('jsfile' => $jsfileheader, 'cssfile' => $cssfileheader, 'title' => $this->title);

		$jsfooter = array();
		$datafooter = array('jsfile' => $jsfooter);

		$data = array(
			'sumberdana' => $this->mlaporanapt->sumberdana(),
			'items' => $this->mlaporanapt->getMutasiObatPsikotropikaBulanan($kd_unit_apt, $bulan, $tahun),
			'unitapotek' => $this->mlaporanapt->ambilData('apt_unit'),
			'bulan' => $bulan,
			'tahun' => $tahun,
			'kd_unit_apt' => $kd_unit_apt
		);

		$this->load->view('headerapotek', $dataheader);
		$this->load->view('laporanapotek/mutasiobatpsikotropikabulanan', $data);
		$this->load->view('footer', $datafooter);
	}

	public function sediaannarkotika()
	{
		if (!$this->muser->isAkses("74")) {
			$this->restricted();
			return false;
		}

		$bulan = date('m');
		$tahun = date('Y');
		if ($this->input->post('kd_unit_apt') != '') {
			$kd_unit_apt = $this->input->post('kd_unit_apt');
		} else {
			$kd_unit_apt = '';
		}

		if ($this->input->post('bulan') != '') {
			$bulan = $this->input->post('bulan');
		}
		if ($this->input->post('tahun') != '') {
			$tahun = $this->input->post('tahun');
		}
		$cssfileheader = array('bootstrap.css', 'bootstrap-responsive.min.css', 'font-awesome.min.css', 'style.css', 'prettify.css', 'jquery-ui.css', 'DT_bootstrap.css', 'responsive-tables.css', 'datepicker.css', 'theme.css');
		$jsfileheader = array(
			'vendor/modernizr-2.6.2-respond-1.1.0.min.js',
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
			'lib/bootstrap-modal.js',
			'spin.js',
			'main.js'
		);
		$dataheader = array('jsfile' => $jsfileheader, 'cssfile' => $cssfileheader, 'title' => $this->title);

		$jsfooter = array();
		$datafooter = array('jsfile' => $jsfooter);

		$data = array(
			'sumberdana' => $this->mlaporanapt->sumberdana(),
			'items' => $this->mlaporanapt->getMutasiObatNarkotikaBulanan($kd_unit_apt, $bulan, $tahun),
			'unitapotek' => $this->mlaporanapt->ambilData('apt_unit'),
			'bulan' => $bulan,
			'tahun' => $tahun,
			'kd_unit_apt' => $kd_unit_apt
		);

		$this->load->view('headerapotek', $dataheader);
		$this->load->view('laporanapotek/mutasiobatnarkotikabulanan', $data);
		$this->load->view('footer', $datafooter);
	}

	public function sediaanprekursor()
	{
		if (!$this->muser->isAkses("74")) {
			$this->restricted();
			return false;
		}

		$bulan = date('m');
		$tahun = date('Y');
		if ($this->input->post('kd_unit_apt') != '') {
			$kd_unit_apt = $this->input->post('kd_unit_apt');
		} else {
			$kd_unit_apt = '';
		}

		if ($this->input->post('bulan') != '') {
			$bulan = $this->input->post('bulan');
		}
		if ($this->input->post('tahun') != '') {
			$tahun = $this->input->post('tahun');
		}
		$cssfileheader = array('bootstrap.css', 'bootstrap-responsive.min.css', 'font-awesome.min.css', 'style.css', 'prettify.css', 'jquery-ui.css', 'DT_bootstrap.css', 'responsive-tables.css', 'datepicker.css', 'theme.css');
		$jsfileheader = array(
			'vendor/modernizr-2.6.2-respond-1.1.0.min.js',
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
			'lib/bootstrap-modal.js',
			'spin.js',
			'main.js'
		);
		$dataheader = array('jsfile' => $jsfileheader, 'cssfile' => $cssfileheader, 'title' => $this->title);

		$jsfooter = array();
		$datafooter = array('jsfile' => $jsfooter);

		$data = array(
			'sumberdana' => $this->mlaporanapt->sumberdana(),
			'items' => $this->mlaporanapt->getMutasiObatPrekursorBulanan($kd_unit_apt, $bulan, $tahun),
			'unitapotek' => $this->mlaporanapt->ambilData('apt_unit'),
			'bulan' => $bulan,
			'tahun' => $tahun,
			'kd_unit_apt' => $kd_unit_apt
		);

		$this->load->view('headerapotek', $dataheader);
		$this->load->view('laporanapotek/mutasiobatprekursorbulanan', $data);
		$this->load->view('footer', $datafooter);
	}

	public function golongan()
	{
		if (!$this->muser->isAkses("74")) {
			$this->restricted();
			return false;
		}

		$bulan = date('m');
		$bulan1 = date('m');
		$tahun = date('Y');
		if ($this->input->post('kd_unit_apt') != '') {
			$kd_unit_apt = $this->input->post('kd_unit_apt');
		} else {
			$kd_unit_apt = '';
		}
		if ($this->input->post('kd_golongan') != '') {
			$kd_golongan = $this->input->post('kd_golongan');
		} else {
			$kd_golongan = '';
		}

		if ($this->input->post('bulan1') != '') {
			$bulan1 = $this->input->post('bulan1');
		}
		if ($this->input->post('bulan') != '') {
			$bulan = $this->input->post('bulan');
		}
		if ($this->input->post('tahun') != '') {
			$tahun = $this->input->post('tahun');
		}
		$cssfileheader = array('bootstrap.css', 'bootstrap-responsive.min.css', 'font-awesome.min.css', 'style.css', 'prettify.css', 'jquery-ui.css', 'DT_bootstrap.css', 'responsive-tables.css', 'datepicker.css', 'theme.css');
		$jsfileheader = array(
			'vendor/modernizr-2.6.2-respond-1.1.0.min.js',
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
			'lib/bootstrap-modal.js',
			'spin.js',
			'main.js'
		);
		$dataheader = array('jsfile' => $jsfileheader, 'cssfile' => $cssfileheader, 'title' => $this->title);

		$jsfooter = array();
		$datafooter = array('jsfile' => $jsfooter);

		$data = array(
			'sumberdana' => $this->mlaporanapt->sumberdana(),
			'items' => $this->mlaporanapt->getMutasiObatGolonganBulanan($kd_unit_apt, $bulan, $bulan1, $tahun, $kd_golongan),
			'unitapotek' => $this->mlaporanapt->ambilData('apt_unit'),
			'datagolongan' => $this->mlaporanapt->ambilData('apt_golongan'),
			'kd_golongan' => $kd_golongan,
			'bulan' => $bulan,
			'bulan1' => $bulan1,
			'tahun' => $tahun,
			'kd_unit_apt' => $kd_unit_apt
		);

		$this->load->view('headerapotek', $dataheader);
		$this->load->view('laporanapotek/mutasiobatgolongan', $data);
		$this->load->view('footer', $datafooter);
	}

	public function tutuppenjualan()
	{
		if (!$this->muser->isAkses("81")) {
			$this->restricted();
			return false;
		}
		$kd_unit_apt = $this->session->userdata('kd_unit_apt');

		$tglskrg = date('Y-m-d');
		$tglkmrn = $this->mlaporanapt->ambiltglkmrn($tglskrg);
		$periodeawal = convertDate($tglkmrn);
		$periodeakhir = convertDate($tglskrg);
		$kd_unit_apt = $this->session->userdata('kd_unit_apt');
		$nama_unit_apt = $this->input->post('nama_unit_apt');

		if ($this->input->post('shift') != '') {
			$shift = $this->input->post('shift');
		}
		if ($this->input->post('periodeawal') != '') {
			$periodeawal = $this->input->post('periodeawal');
		}
		if ($this->input->post('periodeakhir') != '') {
			$periodeakhir = $this->input->post('periodeakhir');
		}
		$cssfileheader = array('bootstrap.css', 'bootstrap-responsive.min.css', 'font-awesome.min.css', 'style.css', 'prettify.css', 'jquery-ui.css', 'DT_bootstrap.css', 'responsive-tables.css', 'datepicker.css', 'theme.css');
		$jsfileheader = array(
			'vendor/modernizr-2.6.2-respond-1.1.0.min.js',
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
			'lib/bootstrap-modal.js',
			'spin.js',
			'main.js'
		);
		$dataheader = array('jsfile' => $jsfileheader, 'cssfile' => $cssfileheader, 'title' => $this->title);

		$jsfooter = array();
		$datafooter = array('jsfile' => $jsfooter);
		$data = array(
			'kd_unit_apt' => $kd_unit_apt,
			'periodeawal' => $periodeawal,
			'periodeakhir' => $periodeakhir
		);

		$this->load->view('headerapotek', $dataheader);
		$this->load->view('laporanapotek/tutuppenjualan', $data);
		$this->load->view('footer', $datafooter);
	}

	public function simpantutuppenjualan()
	{
		$msg = array();
		$submit = $this->input->post('submit');
		$periodeawal = $this->input->post('periodeawal');
		$periodeakhir = $this->input->post('periodeakhir');
		$kd_unit_apt = $this->session->userdata('kd_unit_apt');

		$this->db->trans_start();

		$status = 1;
		$jam = $this->mlaporanapt->ambiljamsekarang(); //ngambil jam skrg
		$tgl = convertDate($periodeakhir) . " " . $jam; //gabungin tgl periodeakhir sama jam skrg
		$data = array(
			'status' => $status,
			'tgl_tutup' => $tgl
		);
		$this->mlaporanapt->update("apt_penjualan", $data, "date_format(tgl_penjualan,'%Y-%m-%d') between '" . convertDate($periodeawal) . "' and '" . convertDate($periodeakhir) . "' and kd_unit_apt='" . $kd_unit_apt . "' and status is null or status='0'");

		$this->db->trans_complete();
		$msg['pesan'] = "Data Berhasil Di Update";
		$msg['status'] = 1;
		$msg['keluar'] = 0;

		echo json_encode($msg);
	}

	public function periksatutuppenjualan()
	{
		$msg = array();
		//$submit=$this->input->post('submit');		
		$jumlaherror = 0;
		$msg['status'] = 1;
		$msg['clearform'] = 0;
		$msg['pesanatas'] = "";
		$msg['pesanlain'] = "";
		/*if($jumlaherror>0){
			$msg['status']=0;
			$msg['error']=$jumlaherror;
			$msg['pesanatas']="Terdapat beberapa kesalahan input silahkan cek inputan anda";
		}*/
		echo json_encode($msg);
	}

	public function rekappenjualan()
	{
		if (!$this->muser->isAkses("79")) {
			$this->restricted();
			return false;
		}
		$periodeawal = date('d-m-Y');
		$periodeakhir = date('d-m-Y');


		$nama_unit_apt = $this->input->post('nama_unit_apt');
		$kd_unit_apt = '';

		if ($this->input->post('periodeawal') != '') {
			$periodeawal = $this->input->post('periodeawal');
		}
		if ($this->input->post('periodeakhir') != '') {
			$periodeakhir = $this->input->post('periodeakhir');
		}
		if ($this->input->post('kd_unit_apt') != '') {
			$kd_unit_apt = $this->input->post('kd_unit_apt');
		}

		$cssfileheader = array('bootstrap.css', 'bootstrap-responsive.min.css', 'font-awesome.min.css', 'style.css', 'prettify.css', 'jquery-ui.css', 'DT_bootstrap.css', 'responsive-tables.css', 'datepicker.css', 'theme.css');
		$jsfileheader = array(
			'vendor/modernizr-2.6.2-respond-1.1.0.min.js',
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
			'lib/bootstrap-modal.js',
			'spin.js',
			'main.js'
		);
		$dataheader = array(
			'jsfile' => $jsfileheader,
			'cssfile' => $cssfileheader,
			'title' => $this->title
		);

		$jsfooter = array();
		$datafooter = array(
			'jsfile' => $jsfooter
		);

		$data = array(
			'sumberdana' => $this->mlaporanapt->sumberdana(),
			'items' => $this->mlaporanapt->getRekapPenjualanApotek($periodeawal, $periodeakhir, $kd_unit_apt),
			'periodeawal' => $periodeawal,
			'periodeakhir' => $periodeakhir,
			'unitapotek' => $this->mlaporanapt->ambilData('apt_unit'),
			'kd_unit_apt' => $kd_unit_apt
		);

		$this->load->view('headerapotek', $dataheader);
		$this->load->view('laporanapotek/rekappenjualan', $data);
		$this->load->view('footer', $datafooter);
	}

	public function rekapnopenjualan()
	{
		$periodeawal = date('d-m-Y');
		$periodeakhir = date('d-m-Y');
		$kd_unit_apt = $this->session->userdata('kd_unit_apt');
		$nama_unit_apt = $this->input->post('nama_unit_apt');
		$status = '';
		$is_lunas = '';
		$resep = '';

		if ($this->input->post('periodeawal') != '') {
			$periodeawal = $this->input->post('periodeawal');
		}
		if ($this->input->post('periodeakhir') != '') {
			$periodeakhir = $this->input->post('periodeakhir');
		}
		if ($this->input->post('status') != '') {
			$status = $this->input->post('status');
		}
		if ($this->input->post('is_lunas') != '') {
			$is_lunas = $this->input->post('is_lunas');
		}
		if ($this->input->post('resep') != '') {
			$resep = $this->input->post('resep');
		}

		$cssfileheader = array('bootstrap.min.css', 'bootstrap-responsive.min.css', 'font-awesome.min.css', 'style.css', 'prettify.css', 'jquery-ui.css', 'DT_bootstrap.css', 'responsive-tables.css', 'datepicker.css', 'theme.css');
		$jsfileheader = array(
			'vendor/modernizr-2.6.2-respond-1.1.0.min.js',
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
			'lib/bootstrap-modal.js',
			'spin.js',
			'main.js'
		);
		$dataheader = array(
			'jsfile' => $jsfileheader,
			'cssfile' => $cssfileheader,
			'title' => $this->title
		);

		$jsfooter = array();
		$datafooter = array(
			'jsfile' => $jsfooter
		);

		$data = array(
			'items' => $this->mlaporanapt->getRekapNoPenjualan($periodeawal, $periodeakhir, $kd_unit_apt, $status, $is_lunas, $resep),
			'periodeawal' => $periodeawal,
			'periodeakhir' => $periodeakhir,
			'unitapotek' => $this->mlaporanapt->ambilData('apt_unit'),
			'kd_unit_apt' => $kd_unit_apt,
			'status' => $status,
			'is_lunas' => $is_lunas,
			'resep' => $resep,
		);

		$this->load->view('headerapotek', $dataheader);
		$this->load->view('laporanapotek/rekapnopenjualan', $data);
		$this->load->view('footer', $datafooter);
	}

	public function penjualanobat()
	{
		$periodeawal = date('d-m-Y');
		$periodeakhir = date('d-m-Y');
		$kd_unit_apt = '';
		$kd_obat = '';
		$nama_obat = '';
		if ($this->input->post('periodeawal') != '') {
			$periodeawal = $this->input->post('periodeawal');
		}
		if ($this->input->post('periodeakhir') != '') {
			$periodeakhir = $this->input->post('periodeakhir');
		}
		if ($this->input->post('kd_unit_apt') != '') {
			$kd_unit_apt = $this->input->post('kd_unit_apt');
		}
		if ($this->input->post('kd_obat') != '') {
			$kd_obat = $this->input->post('kd_obat');
		}
		if ($this->input->post('nama_obat') != '') {
			$nama_obat = $this->input->post('nama_obat');
		}

		$cssfileheader = array('bootstrap.css', 'bootstrap-responsive.min.css', 'font-awesome.min.css', 'style.css', 'prettify.css', 'jquery-ui.css', 'DT_bootstrap.css', 'responsive-tables.css', 'datepicker.css', 'theme.css');
		$jsfileheader = array(
			'vendor/modernizr-2.6.2-respond-1.1.0.min.js',
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
			'lib/bootstrap-modal.js',
			'spin.js',
			'main.js'
		);
		$dataheader = array(
			'jsfile' => $jsfileheader,
			'cssfile' => $cssfileheader,
			'title' => $this->title
		);

		$jsfooter = array();
		$datafooter = array(
			'jsfile' => $jsfooter
		);

		$data = array(
			'items' => $this->mlaporanapt->QueryPenjualanObat($periodeawal, $periodeakhir, $kd_unit_apt, $kd_obat),
			'unitapotek' => $this->mlaporanapt->ambilData('apt_unit'),
			'periodeawal' => $periodeawal,
			'periodeakhir' => $periodeakhir,
			'kd_unit_apt' => $kd_unit_apt,
			'kd_obat' => $kd_obat,
			'nama_obat' => $nama_obat,
		);
		$this->load->view('headerapotek', $dataheader);
		$this->load->view('laporanapotek/penjualanobat', $data);
		$this->load->view('footer', $datafooter);
	}

	public function ambilitem()
	{
		$q = $this->input->get('query');
		$items = $this->mlaporanapt->tes($q);
		echo json_encode($items);
	}

	public function ambilitems()
	{
		$awal = $this->input->get('awal');
		$akhir = $this->input->get('akhir');
		$unit = $this->input->get('unit');
		$q = $this->input->get('query');
		$items = $this->mlaporanapt->detilnyaPenjualanobat($awal, $akhir, $unit, $q);
		echo json_encode($items);
	}


	public function tutupbulan()
	{
		if (!$this->muser->isAkses("74")) {
			$this->restricted();
			return false;
		}

		$kd_unit_apt = $this->input->post('kd_unit_apt');
		$bulan = date('m');
		$tahun = date('Y');
		if ($this->input->post('bulan') != '') {
			$bulan = $this->input->post('bulan');
		}
		if ($this->input->post('tahun') != '') {
			$tahun = $this->input->post('tahun');
		}
		$cssfileheader = array('bootstrap.css', 'bootstrap-responsive.min.css', 'font-awesome.min.css', 'style.css', 'prettify.css', 'jquery-ui.css', 'DT_bootstrap.css', 'responsive-tables.css', 'datepicker.css', 'theme.css');
		$jsfileheader = array(
			'vendor/modernizr-2.6.2-respond-1.1.0.min.js',
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
			'lib/bootstrap-modal.js',
			'spin.js',
			'main.js'
		);
		$dataheader = array('jsfile' => $jsfileheader, 'cssfile' => $cssfileheader, 'title' => $this->title);

		$jsfooter = array();
		$datafooter = array('jsfile' => $jsfooter);
		$data = array(
			'sumberdana' => $this->mlaporanapt->sumberdana(),
			'items' => $this->mlaporanapt->getMutasiObat($kd_unit_apt, $bulan, $tahun),
			'unitapotek' => $this->mlaporanapt->ambilData('apt_unit'),
			'kd_unit_apt' => $kd_unit_apt,
			'bulan' => $bulan,
			'tahun' => $tahun
		);

		$this->load->view('headerapotek', $dataheader);
		$this->load->view('laporanapotek/tutupbulan', $data);
		$this->load->view('footer', $datafooter);
	}

	public function carimutasiobat2()
	{
		$kd_unit_apt = $this->input->post('kd_unit_apt');
		$bulan = $this->input->post('bulan');
		$bulanInt = 0;
		$tahun = $this->input->post('tahun');
		$bulankemarin = 0;
		$tahunkemarin = 0;
		$submit = $this->input->post('submit');
		$items = array();
		$msg = array();

		switch ($bulan) {
			case '01':
				# code...
				$bulanInt = 1;
				$bulankemarin = '12';
				$tahunkemarin = $tahun - 1;
				break;

			case '02':
				# code...
				$bulanInt = 2;
				$bulankemarin = '01';
				$tahunkemarin = $tahun;
				break;

			case '03':
				# code...
				$bulanInt = 3;
				$bulankemarin = '02';
				$tahunkemarin = $tahun;
				break;

			case '04':
				# code...
				$bulanInt = 4;
				$bulankemarin = '03';
				$tahunkemarin = $tahun;
				break;

			case '05':
				# code...
				$bulanInt = 5;
				$bulankemarin = '04';
				$tahunkemarin = $tahun;
				break;

			case '06':
				# code...
				$bulanInt = 6;
				$bulankemarin = '05';
				$tahunkemarin = $tahun;
				break;

			case '07':
				# code...
				$bulanInt = 7;
				$bulankemarin = '06';
				$tahunkemarin = $tahun;
				break;

			case '08':
				# code...
				$bulanInt = 8;
				$bulankemarin = '07';
				$tahunkemarin = $tahun;
				break;

			case '09':
				# code...
				$bulanInt = 9;
				$bulankemarin = '08';
				$tahunkemarin = $tahun;
				break;

			case '10':
				# code...
				$bulanInt = 10;
				$bulankemarin = '09';
				$tahunkemarin = $tahun;
				break;

			case '11':
				# code...
				$bulanInt = 11;
				$bulankemarin = '10';
				$tahunkemarin = $tahun;
				break;

			case '12':
				# code...
				$bulanInt = 12;
				$bulankemarin = '11';
				$tahunkemarin = $tahun;
				break;

			default:
				# code...
				debugvar('There is error, script will not work');
				break;
		}
		$this->db->query('delete from apt_mutasi_obat where 
							kd_unit_apt="' . $kd_unit_apt . '" and bulan="' . $bulan . '" and tahun="' . $tahun . '"
							');

		$items = $this->mlaporanapt->ambilDataObat($kd_unit_apt);
		//$this->db->trans_start();
		foreach ($items as $item) {

			# code...
			$obatmutasi = $this->mlaporanapt->getMutasiPerObat($item['kd_obat'], $item['harga_pokok'], $bulankemarin, $tahunkemarin, $kd_unit_apt); //stok awal bulan ini adalah stok akhir bulan kemarin
			if (empty($obatmutasi)) {
				$saldo_awal = 0;
			} else {
				$saldo_awal = $obatmutasi['saldo_akhir']; //mengambil saldo akhir bulan kemarin dan di letakkan di saldo awal bulan ini
			}

			//mengambil data penerimaan dari pbf selama satu bulan
			$in_pbf = $this->mlaporanapt->getPenerimaanObat($item['kd_obat'], $item['harga_pokok'], $bulan, $tahun, $kd_unit_apt);
			//mengambil data pengeluaran dari penjualan selama satu bulan
			$out_jual = $this->mlaporanapt->getPenjualanObat($item['kd_obat'], $item['harga_pokok'], $bulan, $tahun, $kd_unit_apt);
			//mengambil data pengeluaran dari penjualan selama satu bulan
			$out_disposal = $this->mlaporanapt->getDisposalObat($item['kd_obat'], $item['harga_pokok'], $bulan, $tahun, $kd_unit_apt);
			//$out_jual=$out_jual+$out_disposal;	
			//mengambil stok opname obat selama sebulan
			$stok_opname = $this->mlaporanapt->stokopnameObat($item['kd_obat'], $item['harga_pokok'], $bulan, $tahun, $kd_unit_apt);
			if ($stok_opname != "-") {
				$saldo_awal = $stok_opname;
			}
			/*if($item['kd_obat']=='Seti001508' && $item['harga_pokok']=='1361800'){
				debugvar($saldo_awal);
			}*/
			//$saldo_akhir=$saldo_awal+$stok_opname+$in_pbf+$in_unit+$retur_jual-$out_jual-$out_unit-$retur_pbf;
			//$saldo_akhir=$saldo_awal+$stok_opname+$in_pbf+$in_unit-$out_jual-$out_unit-$retur_pbf;
			$saldo_akhir = $saldo_awal + $in_pbf - $out_jual - $out_disposal;
			$this->db->query('replace into apt_mutasi_obat set tahun="' . $tahun . '",
								bulan="' . $bulan . '",
								kd_obat="' . $item['kd_obat'] . '",
								kd_unit_apt="' . $kd_unit_apt . '",
								kd_milik="' . $item['kd_milik'] . '",
								kd_pabrik="' . $item['kd_pabrik'] . '",
								tgl_expire="' . $item['tgl_expire'] . '",
								harga_pokok="' . $item['harga_pokok'] . '",
								batch="' . $item['batch'] . '",
								saldo_awal="' . $saldo_awal . '",
								in_pbf="' . $in_pbf . '",
								out_jual="' . $out_jual . '",
								out_disposal="' . $out_disposal . '",
								saldo_akhir="' . $saldo_akhir . '",
								harga_beli="' . $item['harga_pokok'] . '",
								stok_opname="' . $stok_opname . '"
								');
		}
		$this->db->trans_complete();


		$msg['status'] = 1;
		$msg['kd_unit_apt'] = $kd_unit_apt;
		$msg['bulan'] = $bulan;
		$msg['tahun'] = $tahun;
		$msg['pesan'] = "";
		$msg['cetak'] = 0;
		//$msg['items']=$this->mlaporanapt->getMutasiObat($kd_unit_apt,$bulan,$tahun);
		$msg['items'] = array();
		if ($submit == "cetak") {
			$msg['cetak'] = 1;
		}
		echo json_encode($msg);
	}

	public function tutupbulanpkm()
	{
		if (!$this->muser->isAkses("74")) {
			$this->restricted();
			return false;
		}

		$id_puskesmas = $this->input->post('id_puskesmas');
		$bulan = date('m');
		$tahun = date('Y');
		if ($this->input->post('bulan') != '') {
			$bulan = $this->input->post('bulan');
		}
		if ($this->input->post('tahun') != '') {
			$tahun = $this->input->post('tahun');
		}
		$cssfileheader = array('bootstrap.css', 'bootstrap-responsive.min.css', 'font-awesome.min.css', 'style.css', 'prettify.css', 'jquery-ui.css', 'DT_bootstrap.css', 'responsive-tables.css', 'datepicker.css', 'theme.css');
		$jsfileheader = array(
			'vendor/modernizr-2.6.2-respond-1.1.0.min.js',
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
			'lib/bootstrap-modal.js',
			'spin.js',
			'main.js'
		);
		$dataheader = array('jsfile' => $jsfileheader, 'cssfile' => $cssfileheader, 'title' => $this->title);

		$jsfooter = array();
		$datafooter = array('jsfile' => $jsfooter);
		$data = array(
			'datapuskesmas' => $this->mlaporanapt->ambilData('gfk_puskesmas'),
			//'items'=>$this->mlaporanapt->getMutasiObat($kd_unit_apt,$bulan,$tahun),
			'id_puskesmas' => $id_puskesmas,
			'bulan' => $bulan,
			'tahun' => $tahun
		);

		$this->load->view('headerapotek', $dataheader);
		$this->load->view('laporanapotek/tutupbulanpkm', $data);
		$this->load->view('footer', $datafooter);
	}

	public function carimutasiobatpkm()
	{
		$id_puskesmas = $this->input->post('id_puskesmas');
		$bulan = $this->input->post('bulan');
		$bulanInt = 0;
		$tahun = $this->input->post('tahun');
		$bulankemarin = 0;
		$tahunkemarin = 0;
		$submit = $this->input->post('submit');
		$items = array();
		$msg = array();

		switch ($bulan) {
			case '01':
				# code...
				$bulanInt = 1;
				$bulankemarin = '12';
				$tahunkemarin = $tahun - 1;
				break;

			case '02':
				# code...
				$bulanInt = 2;
				$bulankemarin = '01';
				$tahunkemarin = $tahun;
				break;

			case '03':
				# code...
				$bulanInt = 3;
				$bulankemarin = '02';
				$tahunkemarin = $tahun;
				break;

			case '04':
				# code...
				$bulanInt = 4;
				$bulankemarin = '03';
				$tahunkemarin = $tahun;
				break;

			case '05':
				# code...
				$bulanInt = 5;
				$bulankemarin = '04';
				$tahunkemarin = $tahun;
				break;

			case '06':
				# code...
				$bulanInt = 6;
				$bulankemarin = '05';
				$tahunkemarin = $tahun;
				break;

			case '07':
				# code...
				$bulanInt = 7;
				$bulankemarin = '06';
				$tahunkemarin = $tahun;
				break;

			case '08':
				# code...
				$bulanInt = 8;
				$bulankemarin = '07';
				$tahunkemarin = $tahun;
				break;

			case '09':
				# code...
				$bulanInt = 9;
				$bulankemarin = '08';
				$tahunkemarin = $tahun;
				break;

			case '10':
				# code...
				$bulanInt = 10;
				$bulankemarin = '09';
				$tahunkemarin = $tahun;
				break;

			case '11':
				# code...
				$bulanInt = 11;
				$bulankemarin = '10';
				$tahunkemarin = $tahun;
				break;

			case '12':
				# code...
				$bulanInt = 12;
				$bulankemarin = '11';
				$tahunkemarin = $tahun;
				break;

			default:
				# code...
				debugvar('There is error, script will not work');
				break;
		}
		$periodeawal = "25-" . $bulankemarin . "-" . $tahunkemarin;
		$periodeakhir = "25-" . $bulan . "-" . $tahun;
		$items = $this->mlaporanapt->ambilDataObat();
		//$this->db->trans_start();
		foreach ($items as $item) {

			# code...
			$obatmutasi = $this->mlaporanapt->getMutasiPerObatPKM($item['kd_obat'], $bulankemarin, $tahunkemarin, $id_puskesmas); //stok awal bulan ini adalah stok akhir bulan kemarin
			if (empty($obatmutasi)) {
				$saldo_awal = 0;
			} else {
				$saldo_awal = $obatmutasi['saldo_akhir']; //mengambil saldo akhir bulan kemarin dan di letakkan di saldo awal bulan ini
			}

			//mengambil data penerimaan dari pbf selama satu bulan
			$in_pbf = $this->mlaporanapt->getPenerimaanObatPKM($item['kd_obat'], $bulan, $tahun, $id_puskesmas);

			//mengambil data pengeluaran dari penjualan selama satu bulan
			$out_jual = $this->mlaporanapt->getPemakaianObatPKM($item['kd_obat'], $bulan, $tahun, $id_puskesmas);

			//mengambil stok opname obat selama sebulan
			//$stok_opname=$this->mlaporanapt->stokopnameObat($item['kd_obat'],$bulan,$tahun,$kd_unit_apt);

			$saldo_akhir = $saldo_awal + $in_pbf - $out_jual;

			$this->db->query('replace into apt_mutasi_obat_puskesmas set tahun="' . $tahun . '",
								bulan="' . $bulan . '",
								kd_obat="' . $item['kd_obat'] . '",
								id_puskesmas="' . $id_puskesmas . '",
								saldo_awal="' . $saldo_awal . '",
								in_pbf="' . $in_pbf . '",
								out_jual="' . $out_jual . '",
								saldo_akhir="' . $saldo_akhir . '"
								');
		}
		$this->db->trans_complete();


		$msg['status'] = 1;
		$msg['id_puskesmas'] = $id_puskesmas;
		$msg['bulan'] = $bulan;
		$msg['tahun'] = $tahun;
		$msg['pesan'] = "";
		$msg['cetak'] = 0;
		//$msg['items']=$this->mlaporanapt->getMutasiObat($kd_unit_apt,$bulan,$tahun);
		$msg['items'] = array();
		if ($submit == "cetak") {
			$msg['cetak'] = 1;
		}
		echo json_encode($msg);
	}


	public function rl1excel($periodeawal = "", $periodeakhir = "", $kd_unit_apt = "", $kd_obat = "")
	{ //bwt yg penjualan obat
		$this->load->library('phpexcel');
		$this->load->library('PHPExcel/iofactory');
		$objPHPExcel = new PHPExcel();
		$objPHPExcel->getProperties()->setTitle("title")->setDescription("description");
		$objPHPExcel->getActiveSheet()->mergeCells('A2:G2');
		$objPHPExcel->getActiveSheet()->mergeCells('A3:G3');
		$objPHPExcel->getActiveSheet()->mergeCells('A4:G4');
		$objPHPExcel->getActiveSheet()->mergeCells('A5:G5');
		/*$objPHPExcel->getActiveSheet()->mergeCells('C7:D7');
		$objPHPExcel->getActiveSheet()->mergeCells('E7:F7');
		$objPHPExcel->getActiveSheet()->mergeCells('H7:L7');
		$objPHPExcel->getActiveSheet()->mergeCells('M7:O7');*/

		$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(0)->setWidth(4.14); //NO
		$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(1)->setWidth(11.2); //TGL JUAL
		$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(2)->setWidth(16); //NO JUAL
		$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(3)->setWidth(9.5); //KODE
		$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(4)->setWidth(25); //NAMA
		$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(5)->setWidth(20); //UNIT
		$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(6)->setWidth(5.3); //QTY

		for ($x = 'A'; $x <= 'G'; $x++) {
			$objPHPExcel->getActiveSheet()->getStyle($x . '2')->getAlignment()->applyFromArray(
				array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, 'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER, 'rotation'   => 0,)
			);
		}
		for ($x = 'A'; $x <= 'G'; $x++) {
			$objPHPExcel->getActiveSheet()->getStyle($x . '3')->getAlignment()->applyFromArray(
				array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, 'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER, 'rotation'   => 0,)
			);
		}
		for ($x = 'A'; $x <= 'G'; $x++) {
			$objPHPExcel->getActiveSheet()->getStyle($x . '4')->getAlignment()->applyFromArray(
				array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, 'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER, 'rotation'   => 0,)
			);
		}
		for ($x = 'A'; $x <= 'G'; $x++) {
			$objPHPExcel->getActiveSheet()->getStyle($x . '5')->getAlignment()->applyFromArray(
				array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, 'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER, 'rotation'   => 0,)
			);
		}
		$objPHPExcel->getActiveSheet()->setCellValue('A2', 'LAPORAN PENJUALAN OBAT');
		$objPHPExcel->getActiveSheet()->setCellValue('A3', 'RUMAH SAKIT IBNU SINA BALIKPAPAN ');

		if ($kd_unit_apt == '') {
			$objPHPExcel->getActiveSheet()->setCellValue('A4', 'Unit : Semua Unit Apotek');
		} else {
			$namaunit = $this->mlaporanapt->namaUnit($kd_unit_apt);
			$objPHPExcel->getActiveSheet()->setCellValue('A4', 'Unit : ' . $namaunit);
		}
		if ($periodeawal != '' and $periodeakhir != '') {
			$tglawal = substr($periodeawal, 0, 2);
			$tglakhir = substr($periodeakhir, 0, 2);
			$blnawal = substr($periodeawal, 3, 2);
			$blnakhir = substr($periodeakhir, 3, 2);
			$thnawal = substr($periodeawal, 6, 10);
			$thnakhir = substr($periodeakhir, 6, 10);

			if ($blnawal == '01') {
				$blnawal1 = 'Januari';
			}
			if ($blnawal == '02') {
				$blnawal1 = 'Februari';
			}
			if ($blnawal == '03') {
				$blnawal1 = 'Maret';
			}
			if ($blnawal == '04') {
				$blnawal1 = 'April';
			}
			if ($blnawal == '05') {
				$blnawal1 = 'Mei';
			}
			if ($blnawal == '06') {
				$blnawal1 = 'Juni';
			}
			if ($blnawal == '07') {
				$blnawal1 = 'Juli';
			}
			if ($blnawal == '08') {
				$blnawal1 = 'Agustus';
			}
			if ($blnawal == '09') {
				$blnawal1 = 'September';
			}
			if ($blnawal == '10') {
				$blnawal1 = 'Oktober';
			}
			if ($blnawal == '11') {
				$blnawal1 = 'November';
			}
			if ($blnawal == '12') {
				$blnawal1 = 'Desember';
			}

			if ($blnakhir == '01') {
				$blnakhir1 = 'Januari';
			}
			if ($blnakhir == '02') {
				$blnakhir1 = 'Februari';
			}
			if ($blnakhir == '03') {
				$blnakhir1 = 'Maret';
			}
			if ($blnakhir == '04') {
				$blnakhir1 = 'April';
			}
			if ($blnakhir == '05') {
				$blnakhir1 = 'Mei';
			}
			if ($blnakhir == '06') {
				$blnakhir1 = 'Juni';
			}
			if ($blnakhir == '07') {
				$blnakhir1 = 'Juli';
			}
			if ($blnakhir == '08') {
				$blnakhir1 = 'Agustus';
			}
			if ($blnakhir == '09') {
				$blnakhir1 = 'September';
			}
			if ($blnakhir == '10') {
				$blnakhir1 = 'Oktober';
			}
			if ($blnakhir == '11') {
				$blnakhir1 = 'November';
			}
			if ($blnakhir == '12') {
				$blnakhir1 = 'Desember';
			}
			$objPHPExcel->getActiveSheet()->setCellValue('A5', 'Periode : ' . $tglawal . ' ' . $blnawal1 . ' ' . $thnawal . ' s/d ' . $tglakhir . ' ' . $blnakhir1 . ' ' . $thnakhir);
		}

		for ($x = 'A'; $x <= 'G'; $x++) {
			$objPHPExcel->getActiveSheet()->getStyle($x . '7')->getAlignment()->applyFromArray(
				array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, 'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER, 'rotation'   => 0,)
			);

			$objPHPExcel->getActiveSheet()->getStyle($x . '7')->applyFromArray(array(
				'font'    => array(
					'name'      => 'calibri',
					'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
					'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
					'size'		=> 12,
					'color'     => array('rgb' => '000000')
				),
				'borders' => array(
					'bottom'     => array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('rgb' => '000000')),
					'top'     => array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('rgb' => '000000')),
					'left'     => array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('rgb' => '000000')),
					'right'     => array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('rgb' => '000000'))
				)
			));
		}
		$objPHPExcel->getActiveSheet()->setCellValue('A7', 'NO.');
		$objPHPExcel->getActiveSheet()->setCellValue('B7', 'TGL');
		$objPHPExcel->getActiveSheet()->setCellValue('C7', 'NO.PENJUALAN');
		$objPHPExcel->getActiveSheet()->setCellValue('D7', 'KODE');
		$objPHPExcel->getActiveSheet()->setCellValue('E7', 'NAMA OBAT');
		$objPHPExcel->getActiveSheet()->setCellValue('F7', 'UNIT APOTEK');
		$objPHPExcel->getActiveSheet()->setCellValue('G7', 'QTY');
		$items = array();
		$items = $this->mlaporanapt->queryexcel($periodeawal, $periodeakhir, $kd_unit_apt, $kd_obat);
		$baris = 8;
		$nomor = 1;
		$total = 0;
		foreach ($items as $item) {
			# code...
			for ($x = 'A'; $x <= 'G'; $x++) {
				if ($x == 'A') {
					$objPHPExcel->getActiveSheet()->getStyle($x . $baris)->getAlignment()->applyFromArray(
						array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, 'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER, 'rotation'   => 0,)
					);
				} else if ($x == 'B') {
					$objPHPExcel->getActiveSheet()->getStyle($x . $baris)->getAlignment()->applyFromArray(
						array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, 'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER, 'rotation'   => 0,)
					);
				} else if ($x == 'C') {
					$objPHPExcel->getActiveSheet()->getStyle($x . $baris)->getAlignment()->applyFromArray(
						array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, 'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER, 'rotation'   => 0,)
					);
				} else if ($x == 'D') {
					$objPHPExcel->getActiveSheet()->getStyle($x . $baris)->getAlignment()->applyFromArray(
						array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT, 'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER, 'rotation'   => 0,)
					);
				} else if ($x == 'E') {
					$objPHPExcel->getActiveSheet()->getStyle($x . $baris)->getAlignment()->applyFromArray(
						array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT, 'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER, 'rotation'   => 0,)
					);
				} else if ($x == 'F') {
					$objPHPExcel->getActiveSheet()->getStyle($x . $baris)->getAlignment()->applyFromArray(
						array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT, 'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER, 'rotation'   => 0,)
					);
				} else if ($x == 'G') {
					$objPHPExcel->getActiveSheet()->getStyle($x . $baris)->getAlignment()->applyFromArray(
						array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT, 'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER, 'rotation'   => 0,)
					);
				}

				$objPHPExcel->getActiveSheet()->getStyle($x . $baris)->applyFromArray(array(
					'font'    => array(
						'name'      => 'calibri',
						'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
						'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
						'size'		=> 12,
						'color'     => array('rgb' => '000000')
					),
					'borders' => array(
						'bottom'     => array(
							'style' => PHPExcel_Style_Border::BORDER_THIN,
							'color' => array('rgb' => '000000')
						),
						'top'     => array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('rgb' => '000000')),
						'left'     => array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('rgb' => '000000')),
						'right'     => array(
							'style' => PHPExcel_Style_Border::BORDER_THIN,
							'color' => array('rgb' => '000000')
						)
					)
				));
			}

			$objPHPExcel->getActiveSheet()->setCellValue('A' . $baris, $nomor);
			//$objPHPExcel->getActiveSheet()->mergeCells('C'.$baris.':D'.$baris);
			$objPHPExcel->getActiveSheet()->setCellValue('B' . $baris, $item['tgl_penjualan']);
			//$objPHPExcel->getActiveSheet()->mergeCells('E'.$baris.':F'.$baris);
			$objPHPExcel->getActiveSheet()->setCellValue('C' . $baris, $item['no_penjualan']);
			$objPHPExcel->getActiveSheet()->setCellValue('D' . $baris, $item['kd_obat']);
			//$objPHPExcel->getActiveSheet()->mergeCells('H'.$baris.':L'.$baris);
			$objPHPExcel->getActiveSheet()->setCellValue('E' . $baris, $item['nama_obat']);
			//$objPHPExcel->getActiveSheet()->mergeCells('M'.$baris.':O'.$baris);
			$objPHPExcel->getActiveSheet()->setCellValue('F' . $baris, $item['nama_unit_apt']);
			$objPHPExcel->getActiveSheet()->setCellValue('G' . $baris, $item['qty']);
			$nomor = $nomor + 1;
			$baris = $baris + 1;
		}
		$objWriter = IOFactory::createWriter($objPHPExcel, 'Excel5');
		$objWriter->save("download/laporanpenjualanobat.xls");
		header("Location: " . base_url() . "download/laporanpenjualanobat.xls");
	}

	public function rl1excelpenjualanobat($periodeawal = "", $periodeakhir = "", $puskesmas = "")
	{ //bwt yg penjualan obat
		$this->load->library('phpexcel');
		$this->load->library('PHPExcel/iofactory');
		$objPHPExcel = new PHPExcel();
		$objPHPExcel->getProperties()->setTitle("title")->setDescription("description");
		$objPHPExcel->getActiveSheet()->mergeCells('A2:E2');

		$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(0)->setWidth(4); //NO
		$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(1)->setWidth(16); //TGL JUAL
		$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(2)->setWidth(20); //NO JUAL
		$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(3)->setWidth(11); //KODE
		$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(4)->setWidth(29); //NAMA
		$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(5)->setWidth(15); //UNIT

		for ($x = 'A'; $x <= 'F'; $x++) {
			$objPHPExcel->getActiveSheet()->getStyle($x . '2')->getAlignment()->applyFromArray(
				array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, 'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER, 'rotation'   => 0,)
			);
		}

		if ($periodeawal != '' and $periodeakhir != '') {
			$tglawal = substr($periodeawal, 0, 2);
			$tglakhir = substr($periodeakhir, 0, 2);
			$blnawal = substr($periodeawal, 3, 2);
			$blnakhir = substr($periodeakhir, 3, 2);
			$thnawal = substr($periodeawal, 6, 10);
			$thnakhir = substr($periodeakhir, 6, 10);

			if ($blnawal == '01') {
				$blnawal1 = 'Januari';
			}
			if ($blnawal == '02') {
				$blnawal1 = 'Februari';
			}
			if ($blnawal == '03') {
				$blnawal1 = 'Maret';
			}
			if ($blnawal == '04') {
				$blnawal1 = 'April';
			}
			if ($blnawal == '05') {
				$blnawal1 = 'Mei';
			}
			if ($blnawal == '06') {
				$blnawal1 = 'Juni';
			}
			if ($blnawal == '07') {
				$blnawal1 = 'Juli';
			}
			if ($blnawal == '08') {
				$blnawal1 = 'Agustus';
			}
			if ($blnawal == '09') {
				$blnawal1 = 'September';
			}
			if ($blnawal == '10') {
				$blnawal1 = 'Oktober';
			}
			if ($blnawal == '11') {
				$blnawal1 = 'November';
			}
			if ($blnawal == '12') {
				$blnawal1 = 'Desember';
			}

			if ($blnakhir == '01') {
				$blnakhir1 = 'Januari';
			}
			if ($blnakhir == '02') {
				$blnakhir1 = 'Februari';
			}
			if ($blnakhir == '03') {
				$blnakhir1 = 'Maret';
			}
			if ($blnakhir == '04') {
				$blnakhir1 = 'April';
			}
			if ($blnakhir == '05') {
				$blnakhir1 = 'Mei';
			}
			if ($blnakhir == '06') {
				$blnakhir1 = 'Juni';
			}
			if ($blnakhir == '07') {
				$blnakhir1 = 'Juli';
			}
			if ($blnakhir == '08') {
				$blnakhir1 = 'Agustus';
			}
			if ($blnakhir == '09') {
				$blnakhir1 = 'September';
			}
			if ($blnakhir == '10') {
				$blnakhir1 = 'Oktober';
			}
			if ($blnakhir == '11') {
				$blnakhir1 = 'November';
			}
			if ($blnakhir == '12') {
				$blnakhir1 = 'Desember';
			}
			$objPHPExcel->getActiveSheet()->setCellValue('A2', 'LAPORAN SBBK PERIODE  : ' . $tglawal . ' ' . $blnawal1 . ' ' . $thnawal . ' s/d ' . $tglakhir . ' ' . $blnakhir1 . ' ' . $thnakhir);
		}

		for ($x = 'A'; $x <= 'F'; $x++) {
			$objPHPExcel->getActiveSheet()->getStyle($x . '4')->getAlignment()->applyFromArray(
				array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, 'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER, 'rotation'   => 0,)
			);

			$objPHPExcel->getActiveSheet()->getStyle($x . '4')->applyFromArray(array(
				'font'    => array(
					'name'      => 'calibri',
					'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
					'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
					'size'		=> 12,
					'color'     => array('rgb' => '000000')
				),
				'borders' => array(
					'bottom'     => array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('rgb' => '000000')),
					'top'     => array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('rgb' => '000000')),
					'left'     => array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('rgb' => '000000')),
					'right'     => array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('rgb' => '000000'))
				)
			));
		}
		$objPHPExcel->getActiveSheet()->setCellValue('A4', 'NO.');
		$objPHPExcel->getActiveSheet()->setCellValue('B4', 'No Transaksi');
		$objPHPExcel->getActiveSheet()->setCellValue('C4', 'No SBBK');
		$objPHPExcel->getActiveSheet()->setCellValue('D4', 'Tanggal');
		$objPHPExcel->getActiveSheet()->setCellValue('E4', 'Puskesmas');
		$objPHPExcel->getActiveSheet()->setCellValue('F4', 'Total Transaksi');
		$items = array();
		$this->load->model('apotek/mpenjualan');
		$items = $this->mpenjualan->ambilDataObatKeluar('', $periodeawal, $periodeakhir, $id_puskesmas);;
		$baris = 5;
		$nomor = 1;
		$total = 0;
		foreach ($items as $item) {
			# code...
			for ($x = 'A'; $x <= 'F'; $x++) {
				if ($x == 'A') {
					$objPHPExcel->getActiveSheet()->getStyle($x . $baris)->getAlignment()->applyFromArray(
						array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, 'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER, 'rotation'   => 0,)
					);
				} else if ($x == 'B') {
					$objPHPExcel->getActiveSheet()->getStyle($x . $baris)->getAlignment()->applyFromArray(
						array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT, 'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER, 'rotation'   => 0,)
					);
				} else if ($x == 'C') {
					$objPHPExcel->getActiveSheet()->getStyle($x . $baris)->getAlignment()->applyFromArray(
						array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT, 'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER, 'rotation'   => 0,)
					);
				} else if ($x == 'D') {
					$objPHPExcel->getActiveSheet()->getStyle($x . $baris)->getAlignment()->applyFromArray(
						array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT, 'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER, 'rotation'   => 0,)
					);
				} else if ($x == 'E') {
					$objPHPExcel->getActiveSheet()->getStyle($x . $baris)->getAlignment()->applyFromArray(
						array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT, 'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER, 'rotation'   => 0,)
					);
				} else if ($x == 'F') {
					$objPHPExcel->getActiveSheet()->getStyle($x . $baris)->getAlignment()->applyFromArray(
						array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT, 'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER, 'rotation'   => 0,)
					);
				}

				$objPHPExcel->getActiveSheet()->getStyle($x . $baris)->applyFromArray(array(
					'font'    => array(
						'name'      => 'calibri',
						'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
						'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
						'size'		=> 12,
						'color'     => array('rgb' => '000000')
					),
					'borders' => array(
						'bottom'     => array(
							'style' => PHPExcel_Style_Border::BORDER_THIN,
							'color' => array('rgb' => '000000')
						),
						'top'     => array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('rgb' => '000000')),
						'left'     => array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('rgb' => '000000')),
						'right'     => array(
							'style' => PHPExcel_Style_Border::BORDER_THIN,
							'color' => array('rgb' => '000000')
						)
					)
				));
			}
			$item['total_transaksi'] = $this->mpenjualan->getTotalPenjualan($item['no_penjualan']);
			$objPHPExcel->getActiveSheet()->setCellValue('A' . $baris, $nomor);
			$objPHPExcel->getActiveSheet()->setCellValue('B' . $baris, $item['no_penjualan']);
			$objPHPExcel->getActiveSheet()->setCellValue('C' . $baris, $item['no_sbbk']);
			$objPHPExcel->getActiveSheet()->setCellValue('D' . $baris, convertDate($item['tgl_penjualan']));
			$objPHPExcel->getActiveSheet()->setCellValue('E' . $baris, $item['puskesmas']);
			$objPHPExcel->getActiveSheet()->setCellValue('F' . $baris, $item['total_transaksi']);
			$nomor = $nomor + 1;
			$baris = $baris + 1;
		}
		$objWriter = IOFactory::createWriter($objPHPExcel, 'Excel5');
		$objWriter->save("download/lap_sbbk.xls");
		header("Location: " . base_url() . "download/lap_sbbk.xls");
	}


	public function rl1exceldistribusi($periodeawal = "", $periodeakhir = "", $kd_unit_asal = "")
	{
		$this->load->library('phpexcel');
		$this->load->library('PHPExcel/iofactory');
		$objPHPExcel = new PHPExcel();
		$objPHPExcel->getProperties()->setTitle("title")->setDescription("description");
		$objPHPExcel->getActiveSheet()->mergeCells('A2:G2');
		$objPHPExcel->getActiveSheet()->mergeCells('A3:G3');
		$objPHPExcel->getActiveSheet()->mergeCells('A4:G4');
		$objPHPExcel->getActiveSheet()->mergeCells('A6:G6');
		$objPHPExcel->getActiveSheet()->mergeCells('A7:G7');
		$objPHPExcel->getActiveSheet()->mergeCells('A8:G8');

		/*$objPHPExcel->getActiveSheet()->mergeCells('B10:C10');
		$objPHPExcel->getActiveSheet()->mergeCells('D10:E10');
		$objPHPExcel->getActiveSheet()->mergeCells('F10:H10');
		$objPHPExcel->getActiveSheet()->mergeCells('J10:L10');*/

		/*$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(0)->setWidth(2.14); 
		$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(1)->setWidth(6.34); 
		$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(2)->setWidth(10); 
		$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(3)->setWidth(8); 
		$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(4)->setWidth(10); 
		$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(6)->setWidth(10); 
		$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(9)->setWidth(15); //KODE
		$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(10)->setWidth(23); //NAMA OBAT
		$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(11)->setWidth(23); //NAMA OBAT
		$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(12)->setWidth(15); //NAMA OBAT
		$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(13)->setWidth(15); //SATUAN
		$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(14)->setWidth(15); //TGL EXPIRE
		$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(15)->setWidth(12); //QTY*/

		$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(0)->setWidth(4.14); //NO
		$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(1)->setWidth(15); //NODISTRIBUSI
		$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(2)->setWidth(10);  //TGL DISTRIBUSI
		$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(3)->setWidth(20); //UNIT APOTEK
		$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(4)->setWidth(10); //KODE OBAT
		$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(5)->setWidth(26); //NAMA OBAT
		//$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(6)->setWidth(10); //SATUAN
		//$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(7)->setWidth(10); //TGL EXPIRE
		$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(6)->setWidth(6); //QTY

		for ($x = 'A'; $x <= 'G'; $x++) { //bwt judul2nya
			$objPHPExcel->getActiveSheet()->getStyle($x . '2')->getAlignment()->applyFromArray(
				array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT, 'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER, 'rotation'   => 0,)
			);
		}
		for ($x = 'A'; $x <= 'G'; $x++) {
			$objPHPExcel->getActiveSheet()->getStyle($x . '3')->getAlignment()->applyFromArray(
				array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT, 'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER, 'rotation'   => 0,)
			);
		}
		for ($x = 'A'; $x <= 'G'; $x++) {
			$objPHPExcel->getActiveSheet()->getStyle($x . '4')->getAlignment()->applyFromArray(
				array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT, 'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER, 'rotation'   => 0,)
			);
		}
		for ($x = 'A'; $x <= 'G'; $x++) {
			$objPHPExcel->getActiveSheet()->getStyle($x . '6')->getAlignment()->applyFromArray(
				array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, 'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER, 'rotation'   => 0,)
			);
		}
		for ($x = 'A'; $x <= 'G'; $x++) {
			$objPHPExcel->getActiveSheet()->getStyle($x . '7')->getAlignment()->applyFromArray(
				array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, 'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER, 'rotation'   => 0,)
			);
		}
		for ($x = 'A'; $x <= 'G'; $x++) {
			$objPHPExcel->getActiveSheet()->getStyle($x . '8')->getAlignment()->applyFromArray(
				array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, 'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER, 'rotation'   => 0,)
			);
		}
		$objPHPExcel->getActiveSheet()->setCellValue('A2', 'RUMAH SAKIT ');
		$objPHPExcel->getActiveSheet()->setCellValue('A3', 'IBNU SINA');
		$objPHPExcel->getActiveSheet()->setCellValue('A4', 'Kota Balikpapan');
		$objPHPExcel->getActiveSheet()->setCellValue('A6', 'LAPORAN DETAIL DISTRIBUSI OBAT');

		if ($kd_unit_asal == '') {
			$objPHPExcel->getActiveSheet()->setCellValue('A7', 'Unit Asal : Semua Unit Apotek');
		} else {
			$namaunit = $this->mlaporanapt->namaUnit($kd_unit_asal);
			$objPHPExcel->getActiveSheet()->setCellValue('A7', 'Unit Asal : ' . $namaunit);
		}

		if ($periodeawal != '' and $periodeakhir != '') {
			$tglawal = substr($periodeawal, 0, 2);
			$tglakhir = substr($periodeakhir, 0, 2);
			$blnawal = substr($periodeawal, 3, 2);
			$blnakhir = substr($periodeakhir, 3, 2);
			$thnawal = substr($periodeawal, 6, 10);
			$thnakhir = substr($periodeakhir, 6, 10);

			if ($blnawal == '01') {
				$blnawal1 = 'Januari';
			}
			if ($blnawal == '02') {
				$blnawal1 = 'Februari';
			}
			if ($blnawal == '03') {
				$blnawal1 = 'Maret';
			}
			if ($blnawal == '04') {
				$blnawal1 = 'April';
			}
			if ($blnawal == '05') {
				$blnawal1 = 'Mei';
			}
			if ($blnawal == '06') {
				$blnawal1 = 'Juni';
			}
			if ($blnawal == '07') {
				$blnawal1 = 'Juli';
			}
			if ($blnawal == '08') {
				$blnawal1 = 'Agustus';
			}
			if ($blnawal == '09') {
				$blnawal1 = 'September';
			}
			if ($blnawal == '10') {
				$blnawal1 = 'Oktober';
			}
			if ($blnawal == '11') {
				$blnawal1 = 'November';
			}
			if ($blnawal == '12') {
				$blnawal1 = 'Desember';
			}

			if ($blnakhir == '01') {
				$blnakhir1 = 'Januari';
			}
			if ($blnakhir == '02') {
				$blnakhir1 = 'Februari';
			}
			if ($blnakhir == '03') {
				$blnakhir1 = 'Maret';
			}
			if ($blnakhir == '04') {
				$blnakhir1 = 'April';
			}
			if ($blnakhir == '05') {
				$blnakhir1 = 'Mei';
			}
			if ($blnakhir == '06') {
				$blnakhir1 = 'Juni';
			}
			if ($blnakhir == '07') {
				$blnakhir1 = 'Juli';
			}
			if ($blnakhir == '08') {
				$blnakhir1 = 'Agustus';
			}
			if ($blnakhir == '09') {
				$blnakhir1 = 'September';
			}
			if ($blnakhir == '10') {
				$blnakhir1 = 'Oktober';
			}
			if ($blnakhir == '11') {
				$blnakhir1 = 'November';
			}
			if ($blnakhir == '12') {
				$blnakhir1 = 'Desember';
			}

			$objPHPExcel->getActiveSheet()->setCellValue('A8', 'Periode : ' . $tglawal . ' ' . $blnawal1 . ' ' . $thnawal . ' s/d ' . $tglakhir . ' ' . $blnakhir1 . ' ' . $thnakhir);
		}

		for ($x = 'A'; $x <= 'G'; $x++) {
			$objPHPExcel->getActiveSheet()->getStyle($x . '10')->getAlignment()->applyFromArray(
				array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, 'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER, 'rotation'   => 0,)
			);

			$objPHPExcel->getActiveSheet()->getStyle($x . '10')->applyFromArray(array(
				'font'    => array(
					'name'      => 'calibri',
					'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
					'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
					'size'		=> 12 /*untuk ukuran tulisan judul kolom2 di tabel*/,
					'color'     => array('rgb' => '000000')
				),
				'borders' => array(
					'bottom'     => array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('rgb' => '000000')),
					'top'     => array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('rgb' => '000000')),
					'left'     => array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('rgb' => '000000')),
					'right'     => array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('rgb' => '000000'))
				)
			));
		}
		$objPHPExcel->getActiveSheet()->setCellValue('A10', 'NO.');
		$objPHPExcel->getActiveSheet()->setCellValue('B10', 'NO. DIST.');
		$objPHPExcel->getActiveSheet()->setCellValue('C10', 'TGL. DIST.');
		$objPHPExcel->getActiveSheet()->setCellValue('D10', 'UNIT');
		$objPHPExcel->getActiveSheet()->setCellValue('E10', 'KODE');
		$objPHPExcel->getActiveSheet()->setCellValue('F10', 'NAMA OBAT');
		//$objPHPExcel->getActiveSheet()->setCellValue ('G10','SATUAN');
		//$objPHPExcel->getActiveSheet()->setCellValue ('H10','TGL. EXPIRE');
		$objPHPExcel->getActiveSheet()->setCellValue('G10', 'QTY');
		$items = array();
		$items = $this->mlaporanapt->getAllDistribusiApotek($periodeawal, $periodeakhir, $kd_unit_asal);
		$baris = 11;
		$nomor = 1;
		$total = 0;
		foreach ($items as $item) {
			# code...
			for ($x = 'A'; $x <= 'G'; $x++) {
				if ($x == 'A') {
					$objPHPExcel->getActiveSheet()->getStyle($x . $baris)->getAlignment()->applyFromArray(
						array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, 'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER, 'rotation'   => 0,)
					);
				} else if ($x == 'B') {
					$objPHPExcel->getActiveSheet()->getStyle($x . $baris)->getAlignment()->applyFromArray(
						array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, 'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER, 'rotation'   => 0,)
					);
				} else if ($x == 'C') {
					$objPHPExcel->getActiveSheet()->getStyle($x . $baris)->getAlignment()->applyFromArray(
						array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, 'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER, 'rotation'   => 0,)
					);
				} else if ($x == 'D') {
					$objPHPExcel->getActiveSheet()->getStyle($x . $baris)->getAlignment()->applyFromArray(
						array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT, 'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER, 'rotation'   => 0,)
					);
				} else if ($x == 'E') {
					$objPHPExcel->getActiveSheet()->getStyle($x . $baris)->getAlignment()->applyFromArray(
						array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, 'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER, 'rotation'   => 0,)
					);
				} else if ($x == 'F') {
					$objPHPExcel->getActiveSheet()->getStyle($x . $baris)->getAlignment()->applyFromArray(
						array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT, 'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER, 'rotation'   => 0,)
					);
				} else if ($x == 'G') {
					$objPHPExcel->getActiveSheet()->getStyle($x . $baris)->getAlignment()->applyFromArray(
						array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT, 'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER, 'rotation'   => 0,)
					);
				}

				$objPHPExcel->getActiveSheet()->getStyle($x . $baris)->applyFromArray(array(
					'font'    => array(
						'name'      => 'calibri',
						'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
						'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
						'size'		=> 11 /*untuk ukuran tulisan yg hasil query bwt yg di dlm tabel*/,
						'color'     => array('rgb' => '000000')
					),
					'borders' => array(
						'bottom'     => array(
							'style' => PHPExcel_Style_Border::BORDER_THIN,
							'color' => array('rgb' => '000000')
						),
						'top'     => array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('rgb' => '000000')),
						'left'     => array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('rgb' => '000000')),
						'right'     => array(
							'style' => PHPExcel_Style_Border::BORDER_THIN,
							'color' => array('rgb' => '000000')
						)
					)
				));
			}

			$objPHPExcel->getActiveSheet()->setCellValue('A' . $baris, $nomor);
			$objPHPExcel->getActiveSheet()->setCellValue('B' . $baris, $item['no_distribusi']);
			$objPHPExcel->getActiveSheet()->setCellValue('C' . $baris, convertDate($item['tgl_distribusi']));
			$kodetujuan = $item['kd_unit_tujuan'];
			$unittujuan = $this->mlaporanapt->namaUnit($kodetujuan);
			$objPHPExcel->getActiveSheet()->setCellValue('D' . $baris, $unittujuan);
			$objPHPExcel->getActiveSheet()->setCellValue('E' . $baris, $item['kd_obat']);
			$objPHPExcel->getActiveSheet()->setCellValue('F' . $baris, $item['nama_obat']);
			//$objPHPExcel->getActiveSheet()->setCellValue ('G'.$baris,$item['satuan_kecil']);
			//$objPHPExcel->getActiveSheet()->setCellValue ('H'.$baris,convertDate($item['tgl_expire']));
			$objPHPExcel->getActiveSheet()->setCellValue('G' . $baris, $item['qty']);
			$nomor = $nomor + 1;
			$baris = $baris + 1;
		}
		$objWriter = IOFactory::createWriter($objPHPExcel, 'Excel5');
		$objWriter->save("download/laporanpenjualanobat.xls");
		header("Location: " . base_url() . "download/laporanpenjualanobat.xls");
	}

	public function rl1excelpenerimaan($periodeawal = "", $periodeakhir = "", $kd_unit_apt = "", $shift = "", $tgl_tempo = "", $kd_supplier = "")
	{
		$this->load->library('phpexcel');
		$this->load->library('PHPExcel/iofactory');
		$objPHPExcel = new PHPExcel();
		$objPHPExcel->getProperties()->setTitle("title")->setDescription("description");
		$objPHPExcel->getActiveSheet()->mergeCells('A2:I2');
		$objPHPExcel->getActiveSheet()->mergeCells('A3:I3');
		$objPHPExcel->getActiveSheet()->mergeCells('A4:I4');
		$objPHPExcel->getActiveSheet()->mergeCells('A6:I6');
		$objPHPExcel->getActiveSheet()->mergeCells('A7:I7');
		$objPHPExcel->getActiveSheet()->mergeCells('A8:I8');
		$objPHPExcel->getActiveSheet()->mergeCells('A9:I9');

		//$objPHPExcel->getActiveSheet()->mergeCells('G11:I11');

		$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(0)->setWidth(4.14); //kosong
		$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(1)->setWidth(15); //no
		$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(2)->setWidth(10); //no terima
		$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(3)->setWidth(26); //nama
		$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(4)->setWidth(5); //qty
		$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(5)->setWidth(9); //harga
		$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(6)->setWidth(6.5); //DISC
		$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(7)->setWidth(6); //PPN
		$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(8)->setWidth(10); //TOTAL
		/*$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(3)->setWidth(18); //no faktur
		$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(4)->setWidth(12); //tgl_terima
		$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(5)->setWidth(12); //tgl_tempo
		$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(6)->setWidth(18); //nama
		$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(10)->setWidth(10); //qty
		$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(11)->setWidth(15); //harga
		$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(12)->setWidth(8); //disc
		$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(13)->setWidth(8); //ppn
		$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(14)->setWidth(15);  //total*/

		for ($x = 'A'; $x <= 'I'; $x++) { //bwt judul2nya
			$objPHPExcel->getActiveSheet()->getStyle($x . '2')->getAlignment()->applyFromArray(
				array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT, 'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER, 'rotation'   => 0,)
			);
		}
		for ($x = 'A'; $x <= 'I'; $x++) {
			$objPHPExcel->getActiveSheet()->getStyle($x . '3')->getAlignment()->applyFromArray(
				array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT, 'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER, 'rotation'   => 0,)
			);
		}
		for ($x = 'A'; $x <= 'I'; $x++) {
			$objPHPExcel->getActiveSheet()->getStyle($x . '4')->getAlignment()->applyFromArray(
				array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT, 'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER, 'rotation'   => 0,)
			);
		}
		for ($x = 'A'; $x <= 'I'; $x++) {
			$objPHPExcel->getActiveSheet()->getStyle($x . '6')->getAlignment()->applyFromArray(
				array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, 'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER, 'rotation'   => 0,)
			);
		}
		for ($x = 'A'; $x <= 'I'; $x++) {
			$objPHPExcel->getActiveSheet()->getStyle($x . '7')->getAlignment()->applyFromArray(
				array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, 'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER, 'rotation'   => 0,)
			);
		}
		for ($x = 'A'; $x <= 'I'; $x++) {
			$objPHPExcel->getActiveSheet()->getStyle($x . '8')->getAlignment()->applyFromArray(
				array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, 'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER, 'rotation'   => 0,)
			);
		}
		for ($x = 'A'; $x <= 'I'; $x++) {
			$objPHPExcel->getActiveSheet()->getStyle($x . '9')->getAlignment()->applyFromArray(
				array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, 'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER, 'rotation'   => 0,)
			);
		}

		$objPHPExcel->getActiveSheet()->setCellValue('A2', 'RUMAH SAKIT');
		$objPHPExcel->getActiveSheet()->setCellValue('A3', 'IBNU SINA');
		$objPHPExcel->getActiveSheet()->setCellValue('A4', 'Kota Balikpapan');
		$objPHPExcel->getActiveSheet()->setCellValue('A6', 'LAPORAN DETAIL PENERIMAAN OBAT');

		if ($kd_supplier == '') {
			$objPHPExcel->getActiveSheet()->setCellValue('A7', 'Supplier : Semua Supplier');
		} else {
			$namasupplier = $this->mlaporanapt->namaSupplier($kd_supplier);
			$objPHPExcel->getActiveSheet()->setCellValue('A7', 'Supplier : ' . $namasupplier);
		}

		$unit = $this->mlaporanapt->ambilNamaUnit($kd_unit_apt);
		$objPHPExcel->getActiveSheet()->setCellValue('A8', 'Unit : ' . $unit);

		if ($periodeawal != '' and $periodeakhir != '') {
			$tglawal = substr($periodeawal, 0, 2);
			$tglakhir = substr($periodeakhir, 0, 2);
			$blnawal = substr($periodeawal, 3, 2);
			$blnakhir = substr($periodeakhir, 3, 2);
			$thnawal = substr($periodeawal, 6, 10);
			$thnakhir = substr($periodeakhir, 6, 10);

			if ($blnawal == '01') {
				$blnawal1 = 'Januari';
			}
			if ($blnawal == '02') {
				$blnawal1 = 'Februari';
			}
			if ($blnawal == '03') {
				$blnawal1 = 'Maret';
			}
			if ($blnawal == '04') {
				$blnawal1 = 'April';
			}
			if ($blnawal == '05') {
				$blnawal1 = 'Mei';
			}
			if ($blnawal == '06') {
				$blnawal1 = 'Juni';
			}
			if ($blnawal == '07') {
				$blnawal1 = 'Juli';
			}
			if ($blnawal == '08') {
				$blnawal1 = 'Agustus';
			}
			if ($blnawal == '09') {
				$blnawal1 = 'September';
			}
			if ($blnawal == '10') {
				$blnawal1 = 'Oktober';
			}
			if ($blnawal == '11') {
				$blnawal1 = 'November';
			}
			if ($blnawal == '12') {
				$blnawal1 = 'Desember';
			}

			if ($blnakhir == '01') {
				$blnakhir1 = 'Januari';
			}
			if ($blnakhir == '02') {
				$blnakhir1 = 'Februari';
			}
			if ($blnakhir == '03') {
				$blnakhir1 = 'Maret';
			}
			if ($blnakhir == '04') {
				$blnakhir1 = 'April';
			}
			if ($blnakhir == '05') {
				$blnakhir1 = 'Mei';
			}
			if ($blnakhir == '06') {
				$blnakhir1 = 'Juni';
			}
			if ($blnakhir == '07') {
				$blnakhir1 = 'Juli';
			}
			if ($blnakhir == '08') {
				$blnakhir1 = 'Agustus';
			}
			if ($blnakhir == '09') {
				$blnakhir1 = 'September';
			}
			if ($blnakhir == '10') {
				$blnakhir1 = 'Oktober';
			}
			if ($blnakhir == '11') {
				$blnakhir1 = 'November';
			}
			if ($blnakhir == '12') {
				$blnakhir1 = 'Desember';
			}

			$objPHPExcel->getActiveSheet()->setCellValue('A9', 'Periode : ' . $tglawal . ' ' . $blnawal1 . ' ' . $thnawal . ' s/d ' . $tglakhir . ' ' . $blnakhir1 . ' ' . $thnakhir);
		}

		for ($x = 'A'; $x <= 'I'; $x++) {
			$objPHPExcel->getActiveSheet()->getStyle($x . '11')->getAlignment()->applyFromArray(
				array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, 'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER, 'rotation'   => 0,)
			);

			$objPHPExcel->getActiveSheet()->getStyle($x . '11')->applyFromArray(array(
				'font'    => array(
					'name'      => 'calibri',
					'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
					'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
					'size'		=> 11 /*untuk ukuran tulisan judul kolom2 di tabel*/,
					'color'     => array('rgb' => '000000')
				),
				'borders' => array(
					'bottom'     => array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('rgb' => '000000')),
					'top'     => array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('rgb' => '000000')),
					'left'     => array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('rgb' => '000000')),
					'right'     => array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('rgb' => '000000'))
				)
			));
		}

		$objPHPExcel->getActiveSheet()->setCellValue('A11', 'NO.');
		$objPHPExcel->getActiveSheet()->setCellValue('B11', 'NO. TERIMA');
		//$objPHPExcel->getActiveSheet()->setCellValue ('C11','NO. FAKTUR');
		$objPHPExcel->getActiveSheet()->setCellValue('C11', 'TGL');
		//$objPHPExcel->getActiveSheet()->setCellValue ('E11','TGL. TEMPO');
		$objPHPExcel->getActiveSheet()->setCellValue('D11', 'NAMA OBAT');
		$objPHPExcel->getActiveSheet()->setCellValue('E11', 'QTY');
		$objPHPExcel->getActiveSheet()->setCellValue('F11', 'HARGA');
		//$objPHPExcel->getActiveSheet()->setCellValue ('I11','SUBTOTAL');
		$objPHPExcel->getActiveSheet()->setCellValue('G11', 'DISC.%');
		$objPHPExcel->getActiveSheet()->setCellValue('H11', 'PPN %');
		$objPHPExcel->getActiveSheet()->setCellValue('I11', 'TOTAL');

		$items = array();
		$items = $this->mlaporanapt->getAllPenerimaanApotek($periodeawal, $periodeakhir, $kd_unit_apt, $shift, $tgl_tempo, $kd_supplier);
		$baris = 12;
		$nomor = 1;
		$total = 0;
		foreach ($items as $item) {
			# code...
			for ($x = 'A'; $x <= 'I'; $x++) {
				if ($x == 'A') {
					$objPHPExcel->getActiveSheet()->getStyle($x . $baris)->getAlignment()->applyFromArray(
						array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, 'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER, 'rotation'   => 0,)
					);
				} else if ($x == 'B') {
					$objPHPExcel->getActiveSheet()->getStyle($x . $baris)->getAlignment()->applyFromArray(
						array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, 'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER, 'rotation'   => 0,)
					);
				} else if ($x == 'C') {
					$objPHPExcel->getActiveSheet()->getStyle($x . $baris)->getAlignment()->applyFromArray(
						array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, 'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER, 'rotation'   => 0,)
					);
				} else if ($x == 'D') {
					$objPHPExcel->getActiveSheet()->getStyle($x . $baris)->getAlignment()->applyFromArray(
						array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT, 'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER, 'rotation'   => 0,)
					);
				} else if ($x == 'E') {
					$objPHPExcel->getActiveSheet()->getStyle($x . $baris)->getAlignment()->applyFromArray(
						array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT, 'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER, 'rotation'   => 0,)
					);
				} else if ($x == 'F') {
					$objPHPExcel->getActiveSheet()->getStyle($x . $baris)->getAlignment()->applyFromArray(
						array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT, 'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER, 'rotation'   => 0,)
					);
				} else if ($x == 'G') {
					$objPHPExcel->getActiveSheet()->getStyle($x . $baris)->getAlignment()->applyFromArray(
						array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT, 'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER, 'rotation'   => 0,)
					);
				} else if ($x == 'H') {
					$objPHPExcel->getActiveSheet()->getStyle($x . $baris)->getAlignment()->applyFromArray(
						array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT, 'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER, 'rotation'   => 0,)
					);
				} else if ($x == 'I') {
					$objPHPExcel->getActiveSheet()->getStyle($x . $baris)->getAlignment()->applyFromArray(
						array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT, 'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER, 'rotation'   => 0,)
					);
				}
				$objPHPExcel->getActiveSheet()->getStyle($x . $baris)->applyFromArray(array(
					'font'    => array(
						'name'      => 'calibri',
						'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
						'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
						'size'		=> 11 /*untuk ukuran tulisan yg hasil query bwt yg di dlm tabel*/,
						'color'     => array('rgb' => '000000')
					),
					'borders' => array(
						'bottom'     => array(
							'style' => PHPExcel_Style_Border::BORDER_THIN,
							'color' => array('rgb' => '000000')
						),
						'top'     => array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('rgb' => '000000')),
						'left'     => array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('rgb' => '000000')),
						'right'     => array(
							'style' => PHPExcel_Style_Border::BORDER_THIN,
							'color' => array('rgb' => '000000')
						)
					)
				));
			}

			$objPHPExcel->getActiveSheet()->setCellValue('A' . $baris, $nomor);
			$objPHPExcel->getActiveSheet()->setCellValue('B' . $baris, $item['no_penerimaan']);
			/*if($item['no_faktur']==''){$objPHPExcel->getActiveSheet()->setCellValue ('D'.$baris,'-');}
			else{$objPHPExcel->getActiveSheet()->setCellValue ('D'.$baris,$item['no_faktur']);}*/
			$objPHPExcel->getActiveSheet()->setCellValue('C' . $baris, convertDate($item['tgl_penerimaan']));
			//$objPHPExcel->getActiveSheet()->setCellValue ('F'.$baris,convertDate($item['tgl_tempo']));
			//$objPHPExcel->getActiveSheet()->mergeCells('G'.$baris.':I'.$baris);			
			$objPHPExcel->getActiveSheet()->setCellValue('D' . $baris, $item['nama_obat']);
			$objPHPExcel->getActiveSheet()->setCellValue('E' . $baris, number_format($item['qty_kcl']));
			$objPHPExcel->getActiveSheet()->setCellValue('F' . $baris, number_format($item['harga_beli']));
			//$objPHPExcel->getActiveSheet()->setCellValue ('L'.$baris,number_format($item['jumlahharga']));			
			$objPHPExcel->getActiveSheet()->setCellValue('G' . $baris, $item['disc_prs']);
			$objPHPExcel->getActiveSheet()->setCellValue('H' . $baris, $item['ppn_item']);
			$objPHPExcel->getActiveSheet()->setCellValue('I' . $baris, number_format($item['jumlahtotal']));
			$nomor = $nomor + 1;
			$baris = $baris + 1;
		}
		$objWriter = IOFactory::createWriter($objPHPExcel, 'Excel5');
		$objWriter->save("download/laporanpenerimaanobat.xls");
		header("Location: " . base_url() . "download/laporanpenerimaanobat.xls");
	}

	public function rl1excelrekappenjualan($periodeawal = "", $periodeakhir = "", $kd_unit_apt = "", $is_lunas = "", $resep = "", $status = "", $kd_jenis_bayar = "", $cust_code = "")
	{
		$resep1 = "";
		$kd_jenis_bayar1 = "";
		$cust_code1 = "";
		$this->load->library('phpexcel');
		$this->load->library('PHPExcel/iofactory');
		$objPHPExcel = new PHPExcel();
		$objPHPExcel->getProperties()->setTitle("title")->setDescription("description");
		$objPHPExcel->getActiveSheet()->mergeCells('A2:H2');
		$objPHPExcel->getActiveSheet()->mergeCells('A4:H4');

		$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(0)->setWidth(4.34); //no
		$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(1)->setWidth(10); //tgl
		$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(2)->setWidth(10); //kd obat
		$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(3)->setWidth(32); //nama obat
		$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(4)->setWidth(6.5); //jumlah
		$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(5)->setWidth(10); //satuan
		$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(6)->setWidth(8); //service
		$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(7)->setWidth(10); //total

		for ($x = 'A'; $x <= 'H'; $x++) { //bwt judul2nya
			$objPHPExcel->getActiveSheet()->getStyle($x . '2')->getAlignment()->applyFromArray(
				array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT, 'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER, 'rotation'   => 0,)
			);
		}
		for ($x = 'A'; $x <= 'H'; $x++) {
			$objPHPExcel->getActiveSheet()->getStyle($x . '3')->getAlignment()->applyFromArray(
				array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT, 'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER, 'rotation'   => 0,)
			);
		}
		for ($x = 'A'; $x <= 'H'; $x++) {
			$objPHPExcel->getActiveSheet()->getStyle($x . '4')->getAlignment()->applyFromArray(
				array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT, 'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER, 'rotation'   => 0,)
			);
		}
		for ($x = 'A'; $x <= 'H'; $x++) {
			$objPHPExcel->getActiveSheet()->getStyle($x . '6')->getAlignment()->applyFromArray(
				array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, 'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER, 'rotation'   => 0,)
			);
		}
		for ($x = 'A'; $x <= 'H'; $x++) {
			$objPHPExcel->getActiveSheet()->getStyle($x . '7')->getAlignment()->applyFromArray(
				array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, 'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER, 'rotation'   => 0,)
			);
		}
		for ($x = 'A'; $x <= 'H'; $x++) {
			$objPHPExcel->getActiveSheet()->getStyle($x . '8')->getAlignment()->applyFromArray(
				array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, 'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER, 'rotation'   => 0,)
			);
		}
		for ($x = 'A'; $x <= 'H'; $x++) {
			$objPHPExcel->getActiveSheet()->getStyle($x . '9')->getAlignment()->applyFromArray(
				array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, 'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER, 'rotation'   => 0,)
			);
		}

		if ($kd_jenis_bayar == "null") {
			$jenisbayar = '';
		} else {
			$jenis = $this->mlaporanapt->jenisbayar($kd_jenis_bayar);
			if ($cust_code == "null") {
				$cust_code2 = '';
			} else {
				$jenispasien = $this->mlaporanapt->jenispasien($cust_code);
				$cust_code2 = "- " . $jenispasien;
			}
			$jenisbayar = "( " . strtoupper($jenis) . " " . strtoupper($cust_code2) . " )";
		}

		$objPHPExcel->getActiveSheet()->setCellValue('A2', 'APOTEK RUMAH SAKIT IBNU SINA');
		$objPHPExcel->getActiveSheet()->setCellValue('A4', 'L A P O R A N  P E N J U A L A N  O B A T  ' . $jenisbayar);

		for ($x = 'A'; $x <= 'H'; $x++) {
			$objPHPExcel->getActiveSheet()->getStyle($x . '6')->getAlignment()->applyFromArray(
				array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, 'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER, 'rotation'   => 0,)
			);

			$objPHPExcel->getActiveSheet()->getStyle($x . '6')->applyFromArray(array(
				'font'    => array(
					'name'      => 'calibri',
					'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
					'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
					'size'		=> 11 /*untuk ukuran tulisan judul kolom2 di tabel*/,
					'color'     => array('rgb' => '000000')
				),
				'borders' => array(
					'bottom'     => array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('rgb' => '000000')),
					'top'     => array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('rgb' => '000000')),
					'left'     => array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('rgb' => '000000')),
					'right'     => array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('rgb' => '000000'))
				)
			));
		}

		$objPHPExcel->getActiveSheet()->setCellValue('A6', 'NO.');
		$objPHPExcel->getActiveSheet()->setCellValue('B6', 'TGL');
		$objPHPExcel->getActiveSheet()->setCellValue('C6', 'KODE');
		$objPHPExcel->getActiveSheet()->setCellValue('D6', 'NAMA OBAT');
		$objPHPExcel->getActiveSheet()->setCellValue('E6', 'QTY');
		$objPHPExcel->getActiveSheet()->setCellValue('F6', 'SAT');
		$objPHPExcel->getActiveSheet()->setCellValue('G6', 'SERVICE');
		$objPHPExcel->getActiveSheet()->setCellValue('H6', 'TOTAL');
		//debugvar($status);
		if ($resep == 'null') {
			$resep1 = '';
		} else {
			$resep1 = $resep;
		}

		if ($kd_jenis_bayar == 'null') {
			$kd_jenis_bayar1 = '';
		} else {
			$kd_jenis_bayar1 = $kd_jenis_bayar;
		}

		if ($cust_code == 'null') {
			$cust_code1 = '';
		} else {
			$cust_code1 = $cust_code;
		}

		$items = array();
		$items = $this->mlaporanapt->getRekapPenjualanApotek($periodeawal, $periodeakhir, $kd_unit_apt, $is_lunas, $resep1, $status, $kd_jenis_bayar1, $cust_code1);
		$baris = 7;
		$nomor = 1;
		$totaljumlah = 0;
		$totalservice = 0;
		$totalpenjualan = 0;
		foreach ($items as $item) {
			# code...
			for ($x = 'A'; $x <= 'H'; $x++) {
				if ($x == 'A') {
					$objPHPExcel->getActiveSheet()->getStyle($x . $baris)->getAlignment()->applyFromArray(
						array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, 'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER, 'rotation'   => 0,)
					);
				} else if ($x == 'B') {
					$objPHPExcel->getActiveSheet()->getStyle($x . $baris)->getAlignment()->applyFromArray(
						array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, 'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER, 'rotation'   => 0,)
					);
				} else if ($x == 'C') {
					$objPHPExcel->getActiveSheet()->getStyle($x . $baris)->getAlignment()->applyFromArray(
						array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT, 'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER, 'rotation'   => 0,)
					);
				} else if ($x == 'D') {
					$objPHPExcel->getActiveSheet()->getStyle($x . $baris)->getAlignment()->applyFromArray(
						array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT, 'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER, 'rotation'   => 0,)
					);
				} else if ($x == 'E') {
					$objPHPExcel->getActiveSheet()->getStyle($x . $baris)->getAlignment()->applyFromArray(
						array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT, 'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER, 'rotation'   => 0,)
					);
				} else if ($x == 'F') {
					$objPHPExcel->getActiveSheet()->getStyle($x . $baris)->getAlignment()->applyFromArray(
						array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, 'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER, 'rotation'   => 0,)
					);
				} else if ($x == 'G') {
					$objPHPExcel->getActiveSheet()->getStyle($x . $baris)->getAlignment()->applyFromArray(
						array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT, 'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER, 'rotation'   => 0,)
					);
				} else if ($x == 'H') {
					$objPHPExcel->getActiveSheet()->getStyle($x . $baris)->getAlignment()->applyFromArray(
						array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT, 'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER, 'rotation'   => 0,)
					);
				}
				$objPHPExcel->getActiveSheet()->getStyle($x . $baris)->applyFromArray(array(
					'font'    => array(
						'name'      => 'calibri',
						'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
						'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
						'size'		=> 11 /*untuk ukuran tulisan yg hasil query bwt yg di dlm tabel*/,
						'color'     => array('rgb' => '000000')
					),
					'borders' => array(
						'bottom'     => array(
							'style' => PHPExcel_Style_Border::BORDER_THIN,
							'color' => array('rgb' => '000000')
						),
						'top'     => array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('rgb' => '000000')),
						'left'     => array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('rgb' => '000000')),
						'right'     => array(
							'style' => PHPExcel_Style_Border::BORDER_THIN,
							'color' => array('rgb' => '000000')
						)
					)
				));
			}

			$objPHPExcel->getActiveSheet()->setCellValue('A' . $baris, $nomor);
			$objPHPExcel->getActiveSheet()->setCellValue('B' . $baris, $periodeakhir);
			$objPHPExcel->getActiveSheet()->setCellValue('C' . $baris, $item['kd_obat']);
			$objPHPExcel->getActiveSheet()->setCellValue('D' . $baris, $item['nama_obat']);
			$objPHPExcel->getActiveSheet()->setCellValue('E' . $baris, $item['qty']);
			$objPHPExcel->getActiveSheet()->setCellValue('F' . $baris, $item['satuan_kecil']);
			$objPHPExcel->getActiveSheet()->setCellValue('G' . $baris, number_format($item['service'], 2, '.', ','));
			$objPHPExcel->getActiveSheet()->setCellValue('H' . $baris, number_format($item['totalsemua'], 2, '.', ','));
			$nomor = $nomor + 1;
			$baris = $baris + 1;
			$totaljumlah = $totaljumlah + $item['qty'];
			$totalservice = $totalservice + $item['service'];
			$totalpenjualan = $totalpenjualan + $item['totalsemua'];
		}
		for ($x = 'A'; $x <= 'D'; $x++) {
			if ($x == 'A') {
				$objPHPExcel->getActiveSheet()->getStyle($x . ($baris + 1))->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT, 'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER, 'rotation'   => 0,));
				$objPHPExcel->getActiveSheet()->getStyle($x . ($baris + 2))->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT, 'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER, 'rotation'   => 0,));
				$objPHPExcel->getActiveSheet()->getStyle($x . ($baris + 3))->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT, 'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER, 'rotation'   => 0,));
			} else if ($x == 'D') {
				$objPHPExcel->getActiveSheet()->getStyle($x . ($baris + 1))->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT, 'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER, 'rotation'   => 0,));
				$objPHPExcel->getActiveSheet()->getStyle($x . ($baris + 2))->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT, 'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER, 'rotation'   => 0,));
				$objPHPExcel->getActiveSheet()->getStyle($x . ($baris + 3))->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT, 'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER, 'rotation'   => 0,));
			}

			$objPHPExcel->getActiveSheet()->getStyle($x . ($baris + 1))->applyFromArray(array('font'    => array(
				'name'      => 'calibri',
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
				'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
				'size'		=> 13,
				'color'     => array('rgb' => '000000')
			)));
			$objPHPExcel->getActiveSheet()->getStyle($x . ($baris + 2))->applyFromArray(array('font'    => array(
				'name'      => 'calibri',
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
				'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
				'size'		=> 13,
				'color'     => array('rgb' => '000000')
			)));
			$objPHPExcel->getActiveSheet()->getStyle($x . ($baris + 3))->applyFromArray(array('font'    => array(
				'name'      => 'calibri',
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
				'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
				'size'		=> 13,
				'color'     => array('rgb' => '000000')
			)));
		}
		$objPHPExcel->getActiveSheet()->mergeCells('A' . ($baris + 1) . ':C' . ($baris + 1));
		$objPHPExcel->getActiveSheet()->setCellValue('A' . ($baris + 1), "TOTAL JUMLAH :");
		$objPHPExcel->getActiveSheet()->setCellValue('D' . ($baris + 1), number_format($totaljumlah, 2, '.', ','));
		$objPHPExcel->getActiveSheet()->mergeCells('A' . ($baris + 2) . ':C' . ($baris + 2));
		$objPHPExcel->getActiveSheet()->setCellValue('A' . ($baris + 2), "TOTAL SERVICE :");
		$objPHPExcel->getActiveSheet()->setCellValue('D' . ($baris + 2), 'Rp ' . number_format($totalservice, 2, '.', ','));
		$objPHPExcel->getActiveSheet()->mergeCells('A' . ($baris + 3) . ':C' . ($baris + 3));
		$objPHPExcel->getActiveSheet()->setCellValue('A' . ($baris + 3), "TOTAL PENJUALAN :");
		$objPHPExcel->getActiveSheet()->setCellValue('D' . ($baris + 3), 'Rp ' . number_format($totalpenjualan, 2, '.', ','));

		$objPHPExcel->getActiveSheet()->mergeCells('A' . ($baris + 6) . ':B' . ($baris + 6));
		$objPHPExcel->getActiveSheet()->setCellValue('A' . ($baris + 6), "PENYETOR");
		$objPHPExcel->getActiveSheet()->setCellValue('F' . ($baris + 6), "PENERIMA");
		$objPHPExcel->getActiveSheet()->mergeCells('A' . ($baris + 10) . ':B' . ($baris + 10));
		$objPHPExcel->getActiveSheet()->setCellValue('A' . ($baris + 10), "(.............)");
		$objPHPExcel->getActiveSheet()->setCellValue('F' . ($baris + 10), "(.............)");

		$objWriter = IOFactory::createWriter($objPHPExcel, 'Excel5');
		$objWriter->save("download/rekappenjualanobat.xls");
		header("Location: " . base_url() . "download/rekappenjualanobat.xls");
	}

	public function rl1excelkartustok($kd_obat = "", $kd_unit_apt = "", $bulan = "", $tahun = "")
	{
		$queryjudul = mysql_query("select nama from simpus_puskesmas");
		$judul = mysql_fetch_array($queryjudul);
		$this->load->library('phpexcel');
		$this->load->library('PHPExcel/iofactory');
		$objPHPExcel = new PHPExcel();
		$objPHPExcel->getProperties()->setTitle("title")->setDescription("description");
		$objPHPExcel->getActiveSheet()->mergeCells('A2:H2');
		$objPHPExcel->getActiveSheet()->mergeCells('A3:H3');
		//$objPHPExcel->getActiveSheet()->mergeCells('A4:H4');
		$objPHPExcel->getActiveSheet()->mergeCells('A5:H5');
		$objPHPExcel->getActiveSheet()->mergeCells('A6:H6');
		$objPHPExcel->getActiveSheet()->mergeCells('A8:B8');
		$objPHPExcel->getActiveSheet()->mergeCells('A9:B9');
		$objPHPExcel->getActiveSheet()->mergeCells('A10:B10');

		//$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(0)->setWidth(2.14); 
		$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(0)->setWidth(4.34); //NO
		$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(1)->setWidth(18); //TGL
		$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(2)->setWidth(22); //KETERANGAN
		$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(3)->setWidth(25); //UNIT VENDOR
		$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(4)->setWidth(15); //NO BUKTI
		$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(5)->setWidth(7); //MASUK
		$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(6)->setWidth(7); //KELUAR
		$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(7)->setWidth(7); //SALDO

		for ($x = 'A'; $x <= 'H'; $x++) { //bwt judul2nya
			$objPHPExcel->getActiveSheet()->getStyle($x . '2')->getAlignment()->applyFromArray(
				array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT, 'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER, 'rotation'   => 0,)
			);
		}
		for ($x = 'A'; $x <= 'H'; $x++) {
			$objPHPExcel->getActiveSheet()->getStyle($x . '3')->getAlignment()->applyFromArray(
				array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT, 'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER, 'rotation'   => 0,)
			);
		}
		for ($x = 'A'; $x <= 'H'; $x++) {
			$objPHPExcel->getActiveSheet()->getStyle($x . '5')->getAlignment()->applyFromArray(
				array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, 'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER, 'rotation'   => 0,)
			);
		}
		for ($x = 'A'; $x <= 'H'; $x++) {
			$objPHPExcel->getActiveSheet()->getStyle($x . '6')->getAlignment()->applyFromArray(
				array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, 'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER, 'rotation'   => 0,)
			);
		}

		$objPHPExcel->getActiveSheet()->setCellValue('A2', '' . $judul['nama']);

		$objPHPExcel->getActiveSheet()->setCellValue('A3', 'Kota Bontang');
		$objPHPExcel->getActiveSheet()->setCellValue('A5', 'Kartu Stok Obat');
		$bulan1 = "";
		if ($bulan == '01') {
			$bulan1 = 'Januari';
		}
		if ($bulan == '02') {
			$bulan1 = 'Februari';
		}
		if ($bulan == '03') {
			$bulan1 = 'Maret';
		}
		if ($bulan == '04') {
			$bulan1 = 'April';
		}
		if ($bulan == '05') {
			$bulan1 = 'Mei';
		}
		if ($bulan == '06') {
			$bulan1 = 'Juni';
		}
		if ($bulan == '07') {
			$bulan1 = 'Juli';
		}
		if ($bulan == '08') {
			$bulan1 = 'Agustus';
		}
		if ($bulan == '09') {
			$bulan1 = 'September';
		}
		if ($bulan == '10') {
			$bulan1 = 'Oktober';
		}
		if ($bulan == '11') {
			$bulan1 = 'November';
		}
		if ($bulan == '12') {
			$bulan1 = 'Desember';
		}
		$objPHPExcel->getActiveSheet()->setCellValue('A6', $bulan1 . ' ' . $tahun);

		$objPHPExcel->getActiveSheet()->setCellValue('A8', 'Kode Obat');
		$objPHPExcel->getActiveSheet()->setCellValue('A9', 'Nama Obat');
		$objPHPExcel->getActiveSheet()->setCellValue('A10', 'Sumber Dana');

		if ($kd_obat == '') {
			$objPHPExcel->getActiveSheet()->setCellValue('C8', ' : -');
		} else {
			$objPHPExcel->getActiveSheet()->setCellValue('C8', ' : ' . $kd_obat);
		}
		$namaobat = $this->mlaporanapt->namaObat($kd_obat);
		//debugvar($namaobat);
		if ($namaobat == '0' or $namaobat == '') {
			$objPHPExcel->getActiveSheet()->setCellValue('C9', ' : -');
		} else {
			$objPHPExcel->getActiveSheet()->setCellValue('C9', ' : ' . $namaobat);
		}

		$namaunit = $this->mlaporanapt->namaUnit($kd_unit_apt);
		if ($namaunit == '0' or $namaunit == '') {
			$objPHPExcel->getActiveSheet()->setCellValue('C10', ' : -');
		} else {
			$objPHPExcel->getActiveSheet()->setCellValue('C10', ' : ' . $namaunit);
		}


		for ($x = 'A'; $x <= 'H'; $x++) {
			$objPHPExcel->getActiveSheet()->getStyle($x . '11')->getAlignment()->applyFromArray(
				array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, 'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER, 'rotation'   => 0,)
			);

			$objPHPExcel->getActiveSheet()->getStyle($x . '11')->applyFromArray(array(
				'font'    => array(
					'name'      => 'calibri',
					'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
					'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
					'size'		=> 10 /*untuk ukuran tulisan judul kolom2 di tabel*/,
					'color'     => array('rgb' => '000000')
				),
				'borders' => array(
					'bottom'     => array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('rgb' => '000000')),
					'top'     => array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('rgb' => '000000')),
					'left'     => array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('rgb' => '000000')),
					'right'     => array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('rgb' => '000000'))
				)
			));
		}
		$objPHPExcel->getActiveSheet()->setCellValue('A11', 'NO.');
		$objPHPExcel->getActiveSheet()->setCellValue('B11', 'TANGGAL');
		$objPHPExcel->getActiveSheet()->setCellValue('C11', 'KETERANGAN');
		$objPHPExcel->getActiveSheet()->setCellValue('D11', 'UNIT/VENDOR');
		$objPHPExcel->getActiveSheet()->setCellValue('E11', 'NO. BUKTI');
		$objPHPExcel->getActiveSheet()->setCellValue('F11', 'MASUK');
		$objPHPExcel->getActiveSheet()->setCellValue('G11', 'KELUAR');
		$objPHPExcel->getActiveSheet()->setCellValue('H11', 'SALDO');
		$items = array();
		$items = $this->mlaporanapt->getKartuStok($kd_obat, $kd_unit_apt, $bulan, $tahun);
		$baris = 12;
		$nomor = 1;
		$total = 0;
		foreach ($items as $item) {
			# code...
			for ($x = 'A'; $x <= 'H'; $x++) {
				if ($x == 'A') {
					$objPHPExcel->getActiveSheet()->getStyle($x . $baris)->getAlignment()->applyFromArray(
						array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, 'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER, 'rotation'   => 0,)
					);
				} else if ($x == 'B') {
					$objPHPExcel->getActiveSheet()->getStyle($x . $baris)->getAlignment()->applyFromArray(
						array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, 'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER, 'rotation'   => 0,)
					);
				} else if ($x == 'D') {
					$objPHPExcel->getActiveSheet()->getStyle($x . $baris)->getAlignment()->applyFromArray(
						array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, 'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER, 'rotation'   => 0,)
					);
				} else if ($x == 'E') {
					$objPHPExcel->getActiveSheet()->getStyle($x . $baris)->getAlignment()->applyFromArray(
						array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, 'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER, 'rotation'   => 0,)
					);
				} else if ($x == 'F') {
					$objPHPExcel->getActiveSheet()->getStyle($x . $baris)->getAlignment()->applyFromArray(
						array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT, 'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER, 'rotation'   => 0,)
					);
				} else if ($x == 'G') {
					$objPHPExcel->getActiveSheet()->getStyle($x . $baris)->getAlignment()->applyFromArray(
						array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT, 'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER, 'rotation'   => 0,)
					);
				}
				$objPHPExcel->getActiveSheet()->getStyle($x . $baris)->applyFromArray(array(
					'font'    => array(
						'name'      => 'calibri',
						'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
						'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
						'size'		=> 10 /*untuk ukuran tulisan yg hasil query bwt yg di dlm tabel*/,
						'color'     => array('rgb' => '000000')
					),
					'borders' => array(
						'bottom'     => array(
							'style' => PHPExcel_Style_Border::BORDER_THIN,
							'color' => array('rgb' => '000000')
						),
						'top'     => array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('rgb' => '000000')),
						'left'     => array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('rgb' => '000000')),
						'right'     => array(
							'style' => PHPExcel_Style_Border::BORDER_THIN,
							'color' => array('rgb' => '000000')
						)
					)
				));
			}
			if ($item['kode'] == "M") {
				$saldo1 = $item['masuk'] + $saldoakhir;
			} else if ($item['kode'] == "K") {
				$saldo1 = $saldoakhir - $item['keluar'];
			} else {
				if ($item['saldo'] == '') {
					$saldo1 = 0;
				} else {
					$saldo1 = $item['saldo'];
				}
			}
			$saldoakhir = $saldo1;

			$objPHPExcel->getActiveSheet()->setCellValue('A' . $baris, $nomor);
			$objPHPExcel->getActiveSheet()->setCellValue('B' . $baris, $item['tgl']);
			$objPHPExcel->getActiveSheet()->setCellValue('C' . $baris, $item['keterangan']);
			if ($item['keterangan'] == 'Saldo Awal' or $item['keterangan'] == 'Penerimaan Vendor' or $item['keterangan'] == 'Pengeluaran Ke Puskesmas' or $item['kode'] == 'M') {
				$objPHPExcel->getActiveSheet()->setCellValue('D' . $baris, $item['unitvendor']);
			} else {
				$unitvendor = $item['unitvendor'];
				$namaunit = $this->mlaporanapt->namaUnit($unitvendor);
				if ($namaunit == '0' or $namaunit == '') {
					$objPHPExcel->getActiveSheet()->setCellValue('D' . $baris, '-');
				} else {
					$objPHPExcel->getActiveSheet()->setCellValue('D' . $baris, $namaunit);
				}
			}
			$objPHPExcel->getActiveSheet()->setCellValue('E' . $baris, $item['no_bukti']);
			if ($item['masuk'] == 0 or $item['masuk'] == '') {
				$objPHPExcel->getActiveSheet()->setCellValue('F' . $baris, '-');
			} else {
				$objPHPExcel->getActiveSheet()->setCellValue('F' . $baris, number_format($item['masuk']));
			}
			if ($item['keluar'] == 0 or $item['keluar'] == '') {
				$objPHPExcel->getActiveSheet()->setCellValue('G' . $baris, '-');
			} else {
				$objPHPExcel->getActiveSheet()->setCellValue('G' . $baris, number_format($item['keluar']));
			}
			$objPHPExcel->getActiveSheet()->setCellValue('H' . $baris, number_format($saldoakhir));
			$nomor = $nomor + 1;
			$baris = $baris + 1;
		}
		$objWriter = IOFactory::createWriter($objPHPExcel, 'Excel5');
		$objWriter->save("download/kartustokobat.xls");
		header("Location: " . base_url() . "download/kartustokobat.xls");
	}

	public function rl1excelkartustokbatch($kd_obat = "", $kd_unit_apt = "", $batch = "", $bulan = "", $tahun = "")
	{
		// $queryjudul=mysql_query("select nama from simpus_puskesmas");
		// $judul=mysql_fetch_array($queryjudul);
		$this->load->library('phpexcel');
		$this->load->library('PHPExcel/iofactory');
		$objPHPExcel = new PHPExcel();
		$objPHPExcel->getProperties()->setTitle("title")->setDescription("description");
		$objPHPExcel->getActiveSheet()->mergeCells('A2:H2');
		$objPHPExcel->getActiveSheet()->mergeCells('A3:H3');
		//$objPHPExcel->getActiveSheet()->mergeCells('A4:H4');
		$objPHPExcel->getActiveSheet()->mergeCells('A5:H5');
		$objPHPExcel->getActiveSheet()->mergeCells('A6:H6');
		$objPHPExcel->getActiveSheet()->mergeCells('A8:B8');
		$objPHPExcel->getActiveSheet()->mergeCells('A9:B9');
		$objPHPExcel->getActiveSheet()->mergeCells('A10:B10');

		//$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(0)->setWidth(2.14); 
		$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(0)->setWidth(4.34); //NO
		$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(1)->setWidth(18); //TGL
		$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(2)->setWidth(22); //KETERANGAN
		$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(3)->setWidth(25); //UNIT VENDOR
		$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(4)->setWidth(15); //NO BUKTI
		$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(5)->setWidth(7); //MASUK
		$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(6)->setWidth(7); //KELUAR
		$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(7)->setWidth(7); //SALDO

		for ($x = 'A'; $x <= 'H'; $x++) { //bwt judul2nya
			$objPHPExcel->getActiveSheet()->getStyle($x . '2')->getAlignment()->applyFromArray(
				array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT, 'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER, 'rotation'   => 0,)
			);
		}
		for ($x = 'A'; $x <= 'H'; $x++) {
			$objPHPExcel->getActiveSheet()->getStyle($x . '3')->getAlignment()->applyFromArray(
				array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT, 'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER, 'rotation'   => 0,)
			);
		}
		for ($x = 'A'; $x <= 'H'; $x++) {
			$objPHPExcel->getActiveSheet()->getStyle($x . '5')->getAlignment()->applyFromArray(
				array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, 'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER, 'rotation'   => 0,)
			);
		}
		for ($x = 'A'; $x <= 'H'; $x++) {
			$objPHPExcel->getActiveSheet()->getStyle($x . '6')->getAlignment()->applyFromArray(
				array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, 'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER, 'rotation'   => 0,)
			);
		}

		// $objPHPExcel->getActiveSheet()->setCellValue ('A2',''.$judul['nama']);

		$objPHPExcel->getActiveSheet()->setCellValue('A3', 'Kota Balikpapan');
		$objPHPExcel->getActiveSheet()->setCellValue('A5', 'Kartu Stok Obat');
		$bulan1 = "";
		if ($bulan == '01') {
			$bulan1 = 'Januari';
		}
		if ($bulan == '02') {
			$bulan1 = 'Februari';
		}
		if ($bulan == '03') {
			$bulan1 = 'Maret';
		}
		if ($bulan == '04') {
			$bulan1 = 'April';
		}
		if ($bulan == '05') {
			$bulan1 = 'Mei';
		}
		if ($bulan == '06') {
			$bulan1 = 'Juni';
		}
		if ($bulan == '07') {
			$bulan1 = 'Juli';
		}
		if ($bulan == '08') {
			$bulan1 = 'Agustus';
		}
		if ($bulan == '09') {
			$bulan1 = 'September';
		}
		if ($bulan == '10') {
			$bulan1 = 'Oktober';
		}
		if ($bulan == '11') {
			$bulan1 = 'November';
		}
		if ($bulan == '12') {
			$bulan1 = 'Desember';
		}
		$objPHPExcel->getActiveSheet()->setCellValue('A6', $bulan1 . ' ' . $tahun);

		$objPHPExcel->getActiveSheet()->setCellValue('A8', 'Kode Obat');
		$objPHPExcel->getActiveSheet()->setCellValue('A9', 'Nama Obat');
		$objPHPExcel->getActiveSheet()->setCellValue('A10', 'Sumber Dana');

		if ($kd_obat == '') {
			$objPHPExcel->getActiveSheet()->setCellValue('C8', ' : -');
		} else {
			$objPHPExcel->getActiveSheet()->setCellValue('C8', ' : ' . $kd_obat);
		}
		$namaobat = $this->mlaporanapt->namaObat($kd_obat);
		//debugvar($namaobat);
		if ($namaobat == '0' or $namaobat == '') {
			$objPHPExcel->getActiveSheet()->setCellValue('C9', ' : -');
		} else {
			$objPHPExcel->getActiveSheet()->setCellValue('C9', ' : ' . $namaobat);
		}

		$namaunit = $this->mlaporanapt->namaUnit($kd_unit_apt);
		if ($namaunit == '0' or $namaunit == '') {
			$objPHPExcel->getActiveSheet()->setCellValue('C10', ' : -');
		} else {
			$objPHPExcel->getActiveSheet()->setCellValue('C10', ' : ' . $namaunit);
		}


		for ($x = 'A'; $x <= 'H'; $x++) {
			$objPHPExcel->getActiveSheet()->getStyle($x . '11')->getAlignment()->applyFromArray(
				array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, 'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER, 'rotation'   => 0,)
			);

			$objPHPExcel->getActiveSheet()->getStyle($x . '11')->applyFromArray(array(
				'font'    => array(
					'name'      => 'calibri',
					'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
					'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
					'size'		=> 10 /*untuk ukuran tulisan judul kolom2 di tabel*/,
					'color'     => array('rgb' => '000000')
				),
				'borders' => array(
					'bottom'     => array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('rgb' => '000000')),
					'top'     => array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('rgb' => '000000')),
					'left'     => array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('rgb' => '000000')),
					'right'     => array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('rgb' => '000000'))
				)
			));
		}
		$objPHPExcel->getActiveSheet()->setCellValue('A11', 'NO.');
		$objPHPExcel->getActiveSheet()->setCellValue('B11', 'TANGGAL');
		$objPHPExcel->getActiveSheet()->setCellValue('C11', 'KETERANGAN');
		$objPHPExcel->getActiveSheet()->setCellValue('D11', 'UNIT/VENDOR');
		$objPHPExcel->getActiveSheet()->setCellValue('E11', 'NO. BUKTI');
		$objPHPExcel->getActiveSheet()->setCellValue('F11', 'MASUK');
		$objPHPExcel->getActiveSheet()->setCellValue('G11', 'KELUAR');
		$objPHPExcel->getActiveSheet()->setCellValue('H11', 'SALDO');
		$items = array();
		$items = $this->mlaporanapt->getKartuStokBatch($kd_obat, $batch, $kd_unit_apt);
		$baris = 12;
		$nomor = 1;
		$total = 0;
		$saldo1 = 0;
		$saldoakhir = 0;
		$totalkeluar = 0;
		$totalmasuk = 0;
		foreach ($items as $item) {
			# code...
			for ($x = 'A'; $x <= 'H'; $x++) {
				if ($x == 'A') {
					$objPHPExcel->getActiveSheet()->getStyle($x . $baris)->getAlignment()->applyFromArray(
						array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, 'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER, 'rotation'   => 0,)
					);
				} else if ($x == 'B') {
					$objPHPExcel->getActiveSheet()->getStyle($x . $baris)->getAlignment()->applyFromArray(
						array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, 'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER, 'rotation'   => 0,)
					);
				} else if ($x == 'D') {
					$objPHPExcel->getActiveSheet()->getStyle($x . $baris)->getAlignment()->applyFromArray(
						array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, 'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER, 'rotation'   => 0,)
					);
				} else if ($x == 'E') {
					$objPHPExcel->getActiveSheet()->getStyle($x . $baris)->getAlignment()->applyFromArray(
						array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, 'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER, 'rotation'   => 0,)
					);
				} else if ($x == 'F') {
					$objPHPExcel->getActiveSheet()->getStyle($x . $baris)->getAlignment()->applyFromArray(
						array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT, 'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER, 'rotation'   => 0,)
					);
				} else if ($x == 'G') {
					$objPHPExcel->getActiveSheet()->getStyle($x . $baris)->getAlignment()->applyFromArray(
						array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT, 'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER, 'rotation'   => 0,)
					);
				}
				$objPHPExcel->getActiveSheet()->getStyle($x . $baris)->applyFromArray(array(
					'font'    => array(
						'name'      => 'calibri',
						'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
						'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
						'size'		=> 10 /*untuk ukuran tulisan yg hasil query bwt yg di dlm tabel*/,
						'color'     => array('rgb' => '000000')
					),
					'borders' => array(
						'bottom'     => array(
							'style' => PHPExcel_Style_Border::BORDER_THIN,
							'color' => array('rgb' => '000000')
						),
						'top'     => array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('rgb' => '000000')),
						'left'     => array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('rgb' => '000000')),
						'right'     => array(
							'style' => PHPExcel_Style_Border::BORDER_THIN,
							'color' => array('rgb' => '000000')
						)
					)
				));
			}
			// if($item['status']=="M"){ $saldo1=$item['masuk']+$saldoakhir; 
			// }else if($item['status']=="K"){ $saldo1=$saldoakhir-$item['keluar'];
			// }else{ if($item['saldo']==''){ $saldo1=0; }
			// 	   else{ $saldo1=$item['saldo']; }
			// }
			// $saldoakhir=$saldo1;
			if ($item['status'] == "M") {
				$saldo1 = $item['qty'] + $saldoakhir; //nti ditambah ama sebelumnya
				$totalmasuk = $totalmasuk + $item['qty'];
			} else if ($item['status'] == "K") {
				$saldo1 = $saldoakhir - $item['qty']; //nti dikurang ama sebelumnya                                                           
				$totalkeluar = $totalkeluar + $item['qty'];
			} else if ($item['status'] == "SO") {
				$totalmasuk = $totalmasuk + $item['qty'];
				$saldo1 += $item['qty']; //nti ditambah ama sebelumnya
				//$totalkeluar=$totalkeluar+$item['keluar'];
			}
			$saldoakhir = $saldo1;

			$ket = '';
			if ($item['status'] == 'SO') $ket = "SO";
			if ($item['status'] == 'M') $ket = "Penerimaan";
			if ($item['status'] == 'K') $ket = "Pengeluaran";
			if ($item['status'] == 'D') $ket = "Disposal";


			$objPHPExcel->getActiveSheet()->setCellValue('A' . $baris, $nomor);
			$objPHPExcel->getActiveSheet()->setCellValue('B' . $baris, $item['tanggal']);
			$objPHPExcel->getActiveSheet()->setCellValue('C' . $baris, $ket);
			$objPHPExcel->getActiveSheet()->setCellValue('D' . $baris, $item['unitvendor']);
			$objPHPExcel->getActiveSheet()->setCellValue('E' . $baris, $item['id_join']);
			if (in_array($item['status'], array('SO', 'M'))) {
				$objPHPExcel->getActiveSheet()->setCellValue('F' . $baris, $item['qty']);
			}
			if (in_array($item['status'], array('K', 'D'))) {
				$objPHPExcel->getActiveSheet()->setCellValue('G' . $baris, $item['qty']);
			}
			$objPHPExcel->getActiveSheet()->setCellValue('H' . $baris, $saldo1);
			$nomor = $nomor + 1;
			$baris = $baris + 1;
		}
		$objWriter = IOFactory::createWriter($objPHPExcel, 'Excel5');
		$objWriter->save("download/kartustokobat.xls");
		header("Location: " . base_url() . "download/kartustokobat.xls");
	}

	public function excellplpo($bulan = "", $tahun = "", $kd_unit_apt = "")
	{
		if ($kd_unit_apt == "NULL") $kd_unit_apt = "";
		$this->load->library('phpexcel');
		$this->load->library('PHPExcel/iofactory');
		$objPHPExcel = new PHPExcel();
		$objPHPExcel->getProperties()->setTitle("title")->setDescription("description");
		$objPHPExcel->getActiveSheet()->mergeCells('A2:M2');
		$objPHPExcel->getActiveSheet()->mergeCells('A3:M3');
		$objPHPExcel->getActiveSheet()->mergeCells('A4:M4');
		$objPHPExcel->getActiveSheet()->mergeCells('A6:M6');
		$objPHPExcel->getActiveSheet()->mergeCells('A7:M7');
		$objPHPExcel->getActiveSheet()->mergeCells('A8:M8');

		$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(0)->setWidth(4.14); //no
		$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(1)->setWidth(30.5); //nama obat
		$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(2)->setWidth(10); //satuan
		$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(3)->setWidth(10); //saldo awal
		$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(4)->setWidth(10); //penerimaan
		$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(5)->setWidth(10); //persediaan
		$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(6)->setWidth(10); //pemakaian
		$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(7)->setWidth(10); //sisa stok
		$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(8)->setWidth(10); //stok opt
		$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(9)->setWidth(10); //permintaan
		$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(10)->setWidth(10); //harga
		$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(11)->setWidth(10); //total


		for ($x = 'A'; $x <= 'L'; $x++) { //bwt judul2nya
			$objPHPExcel->getActiveSheet()->getStyle($x . '2')->getAlignment()->applyFromArray(
				array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT, 'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER, 'rotation'   => 0,)
			);
		}
		for ($x = 'A'; $x <= 'L'; $x++) {
			$objPHPExcel->getActiveSheet()->getStyle($x . '3')->getAlignment()->applyFromArray(
				array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT, 'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER, 'rotation'   => 0,)
			);
		}
		for ($x = 'A'; $x <= 'L'; $x++) {
			$objPHPExcel->getActiveSheet()->getStyle($x . '4')->getAlignment()->applyFromArray(
				array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT, 'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER, 'rotation'   => 0,)
			);
		}
		for ($x = 'A'; $x <= 'L'; $x++) {
			$objPHPExcel->getActiveSheet()->getStyle($x . '6')->getAlignment()->applyFromArray(
				array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, 'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER, 'rotation'   => 0,)
			);
		}
		for ($x = 'A'; $x <= 'L'; $x++) {
			$objPHPExcel->getActiveSheet()->getStyle($x . '7')->getAlignment()->applyFromArray(
				array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, 'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER, 'rotation'   => 0,)
			);
		}
		for ($x = 'A'; $x <= 'L'; $x++) {
			$objPHPExcel->getActiveSheet()->getStyle($x . '8')->getAlignment()->applyFromArray(
				array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, 'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER, 'rotation'   => 0,)
			);
		}
		$profil = $this->mlaporanapt->ambilItemData('profil');
		$objPHPExcel->getActiveSheet()->setCellValue('A2', '');
		$objPHPExcel->getActiveSheet()->setCellValue('A3', $profil['nama_profil']);
		$objPHPExcel->getActiveSheet()->setCellValue('A4', 'Kota Balikpapan');
		$objPHPExcel->getActiveSheet()->setCellValue('A6', 'LAPORAN MUTASI OBAT OBAT');
		$bulan1 = "";
		if ($bulan == '01') {
			$bulan1 = 'Januari';
		}
		if ($bulan == '02') {
			$bulan1 = 'Februari';
		}
		if ($bulan == '03') {
			$bulan1 = 'Maret';
		}
		if ($bulan == '04') {
			$bulan1 = 'April';
		}
		if ($bulan == '05') {
			$bulan1 = 'Mei';
		}
		if ($bulan == '06') {
			$bulan1 = 'Juni';
		}
		if ($bulan == '07') {
			$bulan1 = 'Juli';
		}
		if ($bulan == '08') {
			$bulan1 = 'Agustus';
		}
		if ($bulan == '09') {
			$bulan1 = 'September';
		}
		if ($bulan == '10') {
			$bulan1 = 'Oktober';
		}
		if ($bulan == '11') {
			$bulan1 = 'November';
		}
		if ($bulan == '12') {
			$bulan1 = 'Desember';
		}
		$objPHPExcel->getActiveSheet()->setCellValue('A7', $bulan1 . ' ' . $tahun);
		$namaunit = $this->mlaporanapt->namaUnit($kd_unit_apt);
		$objPHPExcel->getActiveSheet()->setCellValue('A8', $namaunit);

		for ($x = 'A'; $x <= 'M'; $x++) {
			$objPHPExcel->getActiveSheet()->getStyle($x . '10')->getAlignment()->applyFromArray(
				array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, 'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER, 'rotation'   => 0,)
			);
			$objPHPExcel->getActiveSheet()->getStyle($x . '11')->getAlignment()->applyFromArray(
				array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, 'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER, 'rotation'   => 0,)
			);

			$objPHPExcel->getActiveSheet()->getStyle($x . '10')->applyFromArray(array(
				'font'    => array(
					'name'      => 'calibri',
					'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
					'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
					'size'		=> 11 /*untuk ukuran tulisan judul kolom2 di tabel*/,
					'color'     => array('rgb' => '000000')
				),
				'borders' => array(
					'bottom'     => array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('rgb' => '000000')),
					'top'     => array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('rgb' => '000000')),
					'left'     => array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('rgb' => '000000')),
					'right'     => array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('rgb' => '000000'))
				)
			));
			$objPHPExcel->getActiveSheet()->getStyle($x . '11')->applyFromArray(array(
				'font'    => array(
					'name'      => 'calibri',
					'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
					'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
					'size'		=> 11 /*untuk ukuran tulisan judul kolom2 di tabel*/,
					'color'     => array('rgb' => '000000')
				),
				'borders' => array(
					'bottom'     => array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('rgb' => '000000')),
					'top'     => array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('rgb' => '000000')),
					'left'     => array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('rgb' => '000000')),
					'right'     => array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('rgb' => '000000'))
				)
			));
		}

		$objPHPExcel->getActiveSheet()->setCellValue('A10', 'NO.');
		$objPHPExcel->getActiveSheet()->setCellValue('B10', 'NAMA OBAT');
		$objPHPExcel->getActiveSheet()->setCellValue('C10', 'SATUAN');
		$objPHPExcel->getActiveSheet()->setCellValue('D10', 'SALDO AWAL');
		$objPHPExcel->getActiveSheet()->setCellValue('E10', 'PENERIMAAN');
		$objPHPExcel->getActiveSheet()->setCellValue('F10', 'PERSEDIAAN');
		$objPHPExcel->getActiveSheet()->setCellValue('G10', 'PEMAKAIAN');
		$objPHPExcel->getActiveSheet()->setCellValue('H10', 'KARANTINA');
		$objPHPExcel->getActiveSheet()->setCellValue('I10', 'SISA STOK');
		$objPHPExcel->getActiveSheet()->setCellValue('J10', 'RATA2 PEMAKAIAN');
		$objPHPExcel->getActiveSheet()->setCellValue('K10', 'KECUKUPAN BULAN');
		$objPHPExcel->getActiveSheet()->setCellValue('L10', 'HARGA');
		$objPHPExcel->getActiveSheet()->setCellValue('M10', 'TOTAL');

		$items = array();
		$items = $this->mlaporanapt->getMutasiObat($kd_unit_apt, $bulan, $tahun);
		//debugvar($kd_unit_apt);
		$baris = 11;
		$nomor = 1;
		$totalall = 0;
		foreach ($items as $item) {


			for ($x = 'A'; $x <= 'M'; $x++) {
				if ($x == 'A') {
					$objPHPExcel->getActiveSheet()->getStyle($x . $baris)->getAlignment()->applyFromArray(
						array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, 'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER, 'rotation'   => 0,)
					);
				} else if ($x == 'B') {
					$objPHPExcel->getActiveSheet()->getStyle($x . $baris)->getAlignment()->applyFromArray(
						array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT, 'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER, 'rotation'   => 0,)
					);
				} else if ($x == 'C') {
					$objPHPExcel->getActiveSheet()->getStyle($x . $baris)->getAlignment()->applyFromArray(
						array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT, 'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER, 'rotation'   => 0,)
					);
				} else if ($x == 'D') {
					$objPHPExcel->getActiveSheet()->getStyle($x . $baris)->getAlignment()->applyFromArray(
						array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT, 'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER, 'rotation'   => 0,)
					);
				} else if ($x == 'E') {
					$objPHPExcel->getActiveSheet()->getStyle($x . $baris)->getAlignment()->applyFromArray(
						array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT, 'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER, 'rotation'   => 0,)
					);
				} else if ($x == 'F') {
					$objPHPExcel->getActiveSheet()->getStyle($x . $baris)->getAlignment()->applyFromArray(
						array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT, 'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER, 'rotation'   => 0,)
					);
				} else if ($x == 'G') {
					$objPHPExcel->getActiveSheet()->getStyle($x . $baris)->getAlignment()->applyFromArray(
						array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT, 'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER, 'rotation'   => 0,)
					);
				} else if ($x == 'H') {
					$objPHPExcel->getActiveSheet()->getStyle($x . $baris)->getAlignment()->applyFromArray(
						array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT, 'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER, 'rotation'   => 0,)
					);
				} else if ($x == 'I') {
					$objPHPExcel->getActiveSheet()->getStyle($x . $baris)->getAlignment()->applyFromArray(
						array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT, 'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER, 'rotation'   => 0,)
					);
				} else if ($x == 'J') {
					$objPHPExcel->getActiveSheet()->getStyle($x . $baris)->getAlignment()->applyFromArray(
						array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT, 'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER, 'rotation'   => 0,)
					);
				} else if ($x == 'K') {
					$objPHPExcel->getActiveSheet()->getStyle($x . $baris)->getAlignment()->applyFromArray(
						array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT, 'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER, 'rotation'   => 0,)
					);
				} else if ($x == 'L') {
					$objPHPExcel->getActiveSheet()->getStyle($x . $baris)->getAlignment()->applyFromArray(
						array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT, 'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER, 'rotation'   => 0,)
					);
				} else if ($x == 'M') {
					$objPHPExcel->getActiveSheet()->getStyle($x . $baris)->getAlignment()->applyFromArray(
						array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT, 'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER, 'rotation'   => 0,)
					);
				}
				$objPHPExcel->getActiveSheet()->getStyle($x . $baris)->applyFromArray(array(
					'font'    => array(
						'name'      => 'calibri',
						'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
						'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
						'size'		=> 11 /*untuk ukuran tulisan yg hasil query bwt yg di dlm tabel*/,
						'color'     => array('rgb' => '000000')
					),
					'borders' => array(
						'bottom'     => array(
							'style' => PHPExcel_Style_Border::BORDER_THIN,
							'color' => array('rgb' => '000000')
						),
						'top'     => array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('rgb' => '000000')),
						'left'     => array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('rgb' => '000000')),
						'right'     => array(
							'style' => PHPExcel_Style_Border::BORDER_THIN,
							'color' => array('rgb' => '000000')
						)
					)
				));
			}
			$persediaan = 0;
			$persediaan =	$item['saldo_awal'] + $item['in_pbf'];
			$opt = 0;
			$opt = $item['saldo_akhir'] + $item['out_jual'] + ($item['out_jual'] * 20 / 100);
			$total = 0;
			$total = $item['saldo_akhir'] * $item['harga_beli'];
			$objPHPExcel->getActiveSheet()->setCellValue('A' . $baris, $nomor);
			$objPHPExcel->getActiveSheet()->setCellValue('B' . $baris, $item['nama_obat']);
			$objPHPExcel->getActiveSheet()->setCellValue('C' . $baris, $item['satuan_kecil']);
			$objPHPExcel->getActiveSheet()->setCellValue('D' . $baris, number_format($item['saldo_awal'], 2, '.', ','));
			$objPHPExcel->getActiveSheet()->setCellValue('E' . $baris, number_format($item['in_pbf'], 2, '.', ','));
			$objPHPExcel->getActiveSheet()->setCellValue('F' . $baris, number_format($persediaan, 2, '.', ','));
			$objPHPExcel->getActiveSheet()->setCellValue('G' . $baris, number_format($item['out_jual'], 2, '.', ','));
			$objPHPExcel->getActiveSheet()->setCellValue('H' . $baris, number_format($item['out_disposal'], 2, '.', ','));
			$objPHPExcel->getActiveSheet()->setCellValue('I' . $baris, number_format($item['saldo_akhir'], 2, '.', ','));
			$objPHPExcel->getActiveSheet()->setCellValue('J' . $baris, number_format($opt, 2, '.', ','));
			$objPHPExcel->getActiveSheet()->setCellValue('K' . $baris, number_format($item['saldo_akhir'] / $opt, 2, '.', ','));
			$objPHPExcel->getActiveSheet()->setCellValue('L' . $baris, number_format($item['harga_beli'], 2, '.', ','));
			$objPHPExcel->getActiveSheet()->setCellValue('M' . $baris, number_format($total, 2, '.', ','));
			$nomor = $nomor + 1;
			$baris = $baris + 1;
			$totalall = $totalall + $total;
		}
		for ($x = 'A'; $x <= 'M'; $x++) {
			if ($x == 'A') {
				$objPHPExcel->getActiveSheet()->getStyle($x . $baris)->getAlignment()->applyFromArray(
					array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, 'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER, 'rotation'   => 0,)
				);
			} else if ($x == 'B') {
				$objPHPExcel->getActiveSheet()->getStyle($x . $baris)->getAlignment()->applyFromArray(
					array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT, 'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER, 'rotation'   => 0,)
				);
			} else if ($x == 'C') {
				$objPHPExcel->getActiveSheet()->getStyle($x . $baris)->getAlignment()->applyFromArray(
					array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT, 'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER, 'rotation'   => 0,)
				);
			} else if ($x == 'D') {
				$objPHPExcel->getActiveSheet()->getStyle($x . $baris)->getAlignment()->applyFromArray(
					array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT, 'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER, 'rotation'   => 0,)
				);
			} else if ($x == 'E') {
				$objPHPExcel->getActiveSheet()->getStyle($x . $baris)->getAlignment()->applyFromArray(
					array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT, 'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER, 'rotation'   => 0,)
				);
			} else if ($x == 'F') {
				$objPHPExcel->getActiveSheet()->getStyle($x . $baris)->getAlignment()->applyFromArray(
					array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT, 'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER, 'rotation'   => 0,)
				);
			} else if ($x == 'G') {
				$objPHPExcel->getActiveSheet()->getStyle($x . $baris)->getAlignment()->applyFromArray(
					array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT, 'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER, 'rotation'   => 0,)
				);
			} else if ($x == 'H') {
				$objPHPExcel->getActiveSheet()->getStyle($x . $baris)->getAlignment()->applyFromArray(
					array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT, 'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER, 'rotation'   => 0,)
				);
			} else if ($x == 'I') {
				$objPHPExcel->getActiveSheet()->getStyle($x . $baris)->getAlignment()->applyFromArray(
					array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT, 'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER, 'rotation'   => 0,)
				);
			} else if ($x == 'J') {
				$objPHPExcel->getActiveSheet()->getStyle($x . $baris)->getAlignment()->applyFromArray(
					array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT, 'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER, 'rotation'   => 0,)
				);
			} else if ($x == 'K') {
				$objPHPExcel->getActiveSheet()->getStyle($x . $baris)->getAlignment()->applyFromArray(
					array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT, 'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER, 'rotation'   => 0,)
				);
			} else if ($x == 'L') {
				$objPHPExcel->getActiveSheet()->getStyle($x . $baris)->getAlignment()->applyFromArray(
					array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT, 'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER, 'rotation'   => 0,)
				);
			} else if ($x == 'M') {
				$objPHPExcel->getActiveSheet()->getStyle($x . $baris)->getAlignment()->applyFromArray(
					array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT, 'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER, 'rotation'   => 0,)
				);
			}
			$objPHPExcel->getActiveSheet()->getStyle($x . $baris)->applyFromArray(array(
				'font'    => array(
					'name'      => 'calibri',
					'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
					'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
					'size'		=> 11 /*untuk ukuran tulisan yg hasil query bwt yg di dlm tabel*/,
					'color'     => array('rgb' => '000000')
				),
				'borders' => array(
					'bottom'     => array(
						'style' => PHPExcel_Style_Border::BORDER_THIN,
						'color' => array('rgb' => '000000')
					),
					'top'     => array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('rgb' => '000000')),
					'left'     => array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('rgb' => '000000')),
					'right'     => array(
						'style' => PHPExcel_Style_Border::BORDER_THIN,
						'color' => array('rgb' => '000000')
					)
				)
			));
		}
		$objPHPExcel->getActiveSheet()->mergeCells('A' . $baris . ':L' . $baris);
		$objPHPExcel->getActiveSheet()->setCellValue('A' . $baris, 'T O T A L :');
		$objPHPExcel->getActiveSheet()->setCellValue('M' . $baris, number_format($totalall, 2, '.', ','));
		$objWriter = IOFactory::createWriter($objPHPExcel, 'Excel5');
		$objWriter->save("download/mutasiobat.xls");
		header("Location: " . base_url() . "download/mutasiobat.xls");
	}

	public function indikatorobatxls($bulan = "", $tahun = "")
	{

		$this->load->library('phpexcel');
		$this->load->library('PHPExcel/iofactory');
		$objPHPExcel = new PHPExcel();
		$objPHPExcel->getProperties()->setTitle("title")->setDescription("description");
		$objPHPExcel->getActiveSheet()->mergeCells('A2:M2');
		$objPHPExcel->getActiveSheet()->mergeCells('A3:M3');
		$objPHPExcel->getActiveSheet()->mergeCells('A4:M4');
		$objPHPExcel->getActiveSheet()->mergeCells('A6:M6');
		$objPHPExcel->getActiveSheet()->mergeCells('A7:M7');
		$objPHPExcel->getActiveSheet()->mergeCells('A8:M8');

		$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(0)->setWidth(4.14); //no
		$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(1)->setWidth(30.5); //nama obat


		for ($x = 'A'; $x <= 'L'; $x++) { //bwt judul2nya
			$objPHPExcel->getActiveSheet()->getStyle($x . '2')->getAlignment()->applyFromArray(
				array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT, 'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER, 'rotation'   => 0,)
			);
		}
		for ($x = 'A'; $x <= 'L'; $x++) {
			$objPHPExcel->getActiveSheet()->getStyle($x . '3')->getAlignment()->applyFromArray(
				array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT, 'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER, 'rotation'   => 0,)
			);
		}
		for ($x = 'A'; $x <= 'L'; $x++) {
			$objPHPExcel->getActiveSheet()->getStyle($x . '4')->getAlignment()->applyFromArray(
				array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT, 'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER, 'rotation'   => 0,)
			);
		}
		for ($x = 'A'; $x <= 'L'; $x++) {
			$objPHPExcel->getActiveSheet()->getStyle($x . '6')->getAlignment()->applyFromArray(
				array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, 'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER, 'rotation'   => 0,)
			);
		}
		for ($x = 'A'; $x <= 'L'; $x++) {
			$objPHPExcel->getActiveSheet()->getStyle($x . '7')->getAlignment()->applyFromArray(
				array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, 'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER, 'rotation'   => 0,)
			);
		}
		for ($x = 'A'; $x <= 'L'; $x++) {
			$objPHPExcel->getActiveSheet()->getStyle($x . '8')->getAlignment()->applyFromArray(
				array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, 'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER, 'rotation'   => 0,)
			);
		}
		$profil = $this->mlaporanapt->ambilItemData('profil');
		$objPHPExcel->getActiveSheet()->setCellValue('A2', '');
		$objPHPExcel->getActiveSheet()->setCellValue('A3', $profil['nama_profil']);
		$objPHPExcel->getActiveSheet()->setCellValue('A4', 'Kota Balikpapan');
		$objPHPExcel->getActiveSheet()->setCellValue('A6', 'LAPORAN INDIKATOR OBAT');
		$bulan1 = "";
		if ($bulan == '01') {
			$bulan1 = 'Januari';
		}
		if ($bulan == '02') {
			$bulan1 = 'Februari';
		}
		if ($bulan == '03') {
			$bulan1 = 'Maret';
		}
		if ($bulan == '04') {
			$bulan1 = 'April';
		}
		if ($bulan == '05') {
			$bulan1 = 'Mei';
		}
		if ($bulan == '06') {
			$bulan1 = 'Juni';
		}
		if ($bulan == '07') {
			$bulan1 = 'Juli';
		}
		if ($bulan == '08') {
			$bulan1 = 'Agustus';
		}
		if ($bulan == '09') {
			$bulan1 = 'September';
		}
		if ($bulan == '10') {
			$bulan1 = 'Oktober';
		}
		if ($bulan == '11') {
			$bulan1 = 'November';
		}
		if ($bulan == '12') {
			$bulan1 = 'Desember';
		}
		$objPHPExcel->getActiveSheet()->setCellValue('A7', $bulan1 . ' ' . $tahun);

		$items = $this->db->join('apt_obat', 'apt_indikator_obat.kd_obat=apt_obat.kd_obat')->get('apt_indikator_obat')->result_array();
		$puskesmas = $this->db->where('is_puskesmas', 1)->get('gfk_puskesmas')->result_array();

		for ($x = 'A'; $x <= 'B'; $x++) {
			$objPHPExcel->getActiveSheet()->getStyle($x . '10')->getAlignment()->applyFromArray(
				array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, 'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER, 'rotation'   => 0,)
			);
			$objPHPExcel->getActiveSheet()->getStyle($x . '11')->getAlignment()->applyFromArray(
				array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, 'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER, 'rotation'   => 0,)
			);

			$objPHPExcel->getActiveSheet()->getStyle($x . '10')->applyFromArray(array(
				'font'    => array(
					'name'      => 'calibri',
					'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
					'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
					'size'		=> 11 /*untuk ukuran tulisan judul kolom2 di tabel*/,
					'color'     => array('rgb' => '000000')
				),
				'borders' => array(
					'bottom'     => array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('rgb' => '000000')),
					'top'     => array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('rgb' => '000000')),
					'left'     => array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('rgb' => '000000')),
					'right'     => array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('rgb' => '000000'))
				)
			));
			$objPHPExcel->getActiveSheet()->getStyle($x . '11')->applyFromArray(array(
				'font'    => array(
					'name'      => 'calibri',
					'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
					'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
					'size'		=> 11 /*untuk ukuran tulisan judul kolom2 di tabel*/,
					'color'     => array('rgb' => '000000')
				),
				'borders' => array(
					'bottom'     => array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('rgb' => '000000')),
					'top'     => array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('rgb' => '000000')),
					'left'     => array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('rgb' => '000000')),
					'right'     => array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('rgb' => '000000'))
				)
			));
		}

		$objPHPExcel->getActiveSheet()->setCellValue('A10', 'NO.');
		$objPHPExcel->getActiveSheet()->setCellValue('B10', 'NAMA OBAT');

		$kolompuskesmas = 'C';
		foreach ($puskesmas as $pkm) {
			# code...
			$objPHPExcel->getActiveSheet()->getStyle($kolompuskesmas . '10')->getAlignment()->applyFromArray(
				array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, 'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER, 'rotation'   => 0,)
			);
			$objPHPExcel->getActiveSheet()->getStyle($kolompuskesmas . '11')->getAlignment()->applyFromArray(
				array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, 'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER, 'rotation'   => 0,)
			);

			$objPHPExcel->getActiveSheet()->getStyle($kolompuskesmas . '10')->applyFromArray(array(
				'font'    => array(
					'name'      => 'calibri',
					'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
					'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
					'size'		=> 11 /*untuk ukuran tulisan judul kolom2 di tabel*/,
					'color'     => array('rgb' => '000000')
				),
				'borders' => array(
					'bottom'     => array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('rgb' => '000000')),
					'top'     => array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('rgb' => '000000')),
					'left'     => array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('rgb' => '000000')),
					'right'     => array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('rgb' => '000000'))
				)
			));
			$objPHPExcel->getActiveSheet()->getStyle($kolompuskesmas . '11')->applyFromArray(array(
				'font'    => array(
					'name'      => 'calibri',
					'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
					'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
					'size'		=> 11 /*untuk ukuran tulisan judul kolom2 di tabel*/,
					'color'     => array('rgb' => '000000')
				),
				'borders' => array(
					'bottom'     => array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('rgb' => '000000')),
					'top'     => array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('rgb' => '000000')),
					'left'     => array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('rgb' => '000000')),
					'right'     => array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('rgb' => '000000'))
				)
			));

			$objPHPExcel->getActiveSheet()->setCellValue($kolompuskesmas . '10', $pkm['nama']);
			$kolompuskesmas++;
		}

		$baris = 11;
		$nomor = 1;
		$totalall = 0;
		foreach ($items as $item) {


			for ($x = 'A'; $x <= 'B'; $x++) {
				if ($x == 'A') {
					$objPHPExcel->getActiveSheet()->getStyle($x . $baris)->getAlignment()->applyFromArray(
						array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, 'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER, 'rotation'   => 0,)
					);
				} else if ($x == 'B') {
					$objPHPExcel->getActiveSheet()->getStyle($x . $baris)->getAlignment()->applyFromArray(
						array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT, 'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER, 'rotation'   => 0,)
					);
				}
				$objPHPExcel->getActiveSheet()->getStyle($x . $baris)->applyFromArray(array(
					'font'    => array(
						'name'      => 'calibri',
						'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
						'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
						'size'		=> 11 /*untuk ukuran tulisan yg hasil query bwt yg di dlm tabel*/,
						'color'     => array('rgb' => '000000')
					),
					'borders' => array(
						'bottom'     => array(
							'style' => PHPExcel_Style_Border::BORDER_THIN,
							'color' => array('rgb' => '000000')
						),
						'top'     => array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('rgb' => '000000')),
						'left'     => array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('rgb' => '000000')),
						'right'     => array(
							'style' => PHPExcel_Style_Border::BORDER_THIN,
							'color' => array('rgb' => '000000')
						)
					)
				));
			}

			$objPHPExcel->getActiveSheet()->setCellValue('A' . $baris, $nomor);
			$objPHPExcel->getActiveSheet()->setCellValue('B' . $baris, $item['nama_obat']);
			$kolompuskesmas = 'C';
			foreach ($puskesmas as $pkm) {
				# code...
				# code...
				$objPHPExcel->getActiveSheet()->getStyle($kolompuskesmas . $baris)->getAlignment()->applyFromArray(
					array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, 'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER, 'rotation'   => 0,)
				);
				$objPHPExcel->getActiveSheet()->getStyle($kolompuskesmas . $baris)->getAlignment()->applyFromArray(
					array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, 'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER, 'rotation'   => 0,)
				);

				$objPHPExcel->getActiveSheet()->getStyle($kolompuskesmas . $baris)->applyFromArray(array(
					'font'    => array(
						'name'      => 'calibri',
						'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
						'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
						'size'		=> 11 /*untuk ukuran tulisan judul kolom2 di tabel*/,
						'color'     => array('rgb' => '000000')
					),
					'borders' => array(
						'bottom'     => array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('rgb' => '000000')),
						'top'     => array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('rgb' => '000000')),
						'left'     => array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('rgb' => '000000')),
						'right'     => array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('rgb' => '000000'))
					)
				));
				$objPHPExcel->getActiveSheet()->getStyle($kolompuskesmas . $baris)->applyFromArray(array(
					'font'    => array(
						'name'      => 'calibri',
						'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
						'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
						'size'		=> 11 /*untuk ukuran tulisan judul kolom2 di tabel*/,
						'color'     => array('rgb' => '000000')
					),
					'borders' => array(
						'bottom'     => array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('rgb' => '000000')),
						'top'     => array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('rgb' => '000000')),
						'left'     => array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('rgb' => '000000')),
						'right'     => array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('rgb' => '000000'))
					)
				));
				$indikator = $this->db->query('select sum(qty) as jumlah from apt_penjualan_detail a join apt_penjualan b on a.no_penjualan=b.no_penjualan where b.customer_id="' . $pkm['id'] . '" and a.kd_obat="' . $item['kd_obat'] . '" and month(b.tgl_penjualan)="' . $bulan . '" and year(b.tgl_penjualan)="' . $tahun . '" ')->row_array();
				$objPHPExcel->getActiveSheet()->setCellValue($kolompuskesmas . $baris, $indikator['jumlah']);
				$kolompuskesmas++;
			}

			$nomor = $nomor + 1;
			$baris = $baris + 1;
			$totalall = $totalall + $total;
		}

		$objWriter = IOFactory::createWriter($objPHPExcel, 'Excel5');
		$objWriter->save("download/indikatorobat.xls");
		header("Location: " . base_url() . "download/indikatorobat.xls");
	}

	public function excellplpobulanan2($bulan = "", $bulan1 = "", $tahun = "", $kd_unit_apt = "", $kd_nomenklatur = "", $bulan_kebutuhan = "", $kategori = "")
	{
		if ($kd_unit_apt == "NULL") $kd_unit_apt = "";
		$this->load->library('PHPExcel');
		$this->load->library('PHPExcel/IOFactory');
		$objPHPExcel = new PHPExcel();
		$objPHPExcel->getProperties()->setTitle("title")->setDescription("description");
		$objPHPExcel->getActiveSheet()->mergeCells('A2:M2');
		$objPHPExcel->getActiveSheet()->mergeCells('A3:M3');
		$objPHPExcel->getActiveSheet()->mergeCells('A4:M4');
		$objPHPExcel->getActiveSheet()->mergeCells('A6:M6');
		$objPHPExcel->getActiveSheet()->mergeCells('A7:M7');
		$objPHPExcel->getActiveSheet()->mergeCells('A8:M8');

		$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(0)->setWidth(4.14); //no
		$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(1)->setWidth(30.5); //nama obat
		$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(2)->setWidth(10); //satuan
		$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(3)->setWidth(10); //saldo awal
		$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(4)->setWidth(10); //penerimaan
		$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(5)->setWidth(10); //persediaan
		$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(6)->setWidth(10); //pemakaian
		$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(7)->setWidth(10); //sisa stok
		$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(8)->setWidth(10); //stok opt
		$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(9)->setWidth(10); //permintaan
		$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(10)->setWidth(10); //harga
		$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(11)->setWidth(10); //total


		for ($x = 'A'; $x <= 'L'; $x++) { //bwt judul2nya
			$objPHPExcel->getActiveSheet()->getStyle($x . '2')->getAlignment()->applyFromArray(
				array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT, 'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER, 'rotation'   => 0,)
			);
		}
		for ($x = 'A'; $x <= 'L'; $x++) {
			$objPHPExcel->getActiveSheet()->getStyle($x . '3')->getAlignment()->applyFromArray(
				array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT, 'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER, 'rotation'   => 0,)
			);
		}
		for ($x = 'A'; $x <= 'L'; $x++) {
			$objPHPExcel->getActiveSheet()->getStyle($x . '4')->getAlignment()->applyFromArray(
				array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT, 'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER, 'rotation'   => 0,)
			);
		}
		for ($x = 'A'; $x <= 'L'; $x++) {
			$objPHPExcel->getActiveSheet()->getStyle($x . '6')->getAlignment()->applyFromArray(
				array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, 'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER, 'rotation'   => 0,)
			);
		}
		for ($x = 'A'; $x <= 'L'; $x++) {
			$objPHPExcel->getActiveSheet()->getStyle($x . '7')->getAlignment()->applyFromArray(
				array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, 'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER, 'rotation'   => 0,)
			);
		}
		for ($x = 'A'; $x <= 'L'; $x++) {
			$objPHPExcel->getActiveSheet()->getStyle($x . '8')->getAlignment()->applyFromArray(
				array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, 'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER, 'rotation'   => 0,)
			);
		}
		$profil = $this->mlaporanapt->ambilItemData('profil');
		$objPHPExcel->getActiveSheet()->setCellValue('A2', '');
		$objPHPExcel->getActiveSheet()->setCellValue('A3', $profil['nama_profil']);
		$objPHPExcel->getActiveSheet()->setCellValue('A4', 'Kota Balikpapan');
		$objPHPExcel->getActiveSheet()->setCellValue('A6', 'LAPORAN MUTASI OBAT OBAT');
		//$bulan1="";
		//if($bulan=='01'){$bulan1='Januari';} 	 if($bulan=='02'){$bulan1='Februari';}	if($bulan=='03'){$bulan1='Maret';} 	  if($bulan=='04'){$bulan1='April';}
		//if($bulan=='05'){$bulan1='Mei';} 		 if($bulan=='06'){$bulan1='Juni';} 		if($bulan=='07'){$bulan1='Juli';} 	  if($bulan=='08'){$bulan1='Agustus';}
		//if($bulan=='09'){$bulan1='September';}   if($bulan=='10'){$bulan1='Oktober';}	if($bulan=='11'){$bulan1='November';} if($bulan=='12'){$bulan1='Desember';}
		$objPHPExcel->getActiveSheet()->setCellValue('A7', 'Bulan ' . $bulan . ' Sampai ' . $bulan1 . ' ' . $tahun);
		$namaunit = $this->mlaporanapt->namaUnit($kd_unit_apt);
		$objPHPExcel->getActiveSheet()->setCellValue('A8', $namaunit);

		for ($x = 'A'; $x <= 'N'; $x++) {
			$objPHPExcel->getActiveSheet()->getStyle($x . '10')->getAlignment()->applyFromArray(
				array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, 'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER, 'rotation'   => 0,)
			);
			$objPHPExcel->getActiveSheet()->getStyle($x . '11')->getAlignment()->applyFromArray(
				array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, 'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER, 'rotation'   => 0,)
			);

			$objPHPExcel->getActiveSheet()->getStyle($x . '10')->applyFromArray(array(
				'font'    => array(
					'name'      => 'calibri',
					'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
					'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
					'size'		=> 11 /*untuk ukuran tulisan judul kolom2 di tabel*/,
					'color'     => array('rgb' => '000000')
				),
				'borders' => array(
					'bottom'     => array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('rgb' => '000000')),
					'top'     => array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('rgb' => '000000')),
					'left'     => array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('rgb' => '000000')),
					'right'     => array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('rgb' => '000000'))
				)
			));
			$objPHPExcel->getActiveSheet()->getStyle($x . '11')->applyFromArray(array(
				'font'    => array(
					'name'      => 'calibri',
					'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
					'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
					'size'		=> 11 /*untuk ukuran tulisan judul kolom2 di tabel*/,
					'color'     => array('rgb' => '000000')
				),
				'borders' => array(
					'bottom'     => array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('rgb' => '000000')),
					'top'     => array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('rgb' => '000000')),
					'left'     => array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('rgb' => '000000')),
					'right'     => array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('rgb' => '000000'))
				)
			));
		}

		$objPHPExcel->getActiveSheet()->setCellValue('A10', 'NO.');
		$objPHPExcel->getActiveSheet()->setCellValue('B10', 'NAMA OBAT');
		$objPHPExcel->getActiveSheet()->setCellValue('C10', 'SATUAN');
		$objPHPExcel->getActiveSheet()->setCellValue('D10', 'SALDO AWAL');
		$objPHPExcel->getActiveSheet()->setCellValue('E10', 'PENERIMAAN');
		$objPHPExcel->getActiveSheet()->setCellValue('F10', 'PERSEDIAAN');
		$objPHPExcel->getActiveSheet()->setCellValue('G10', 'PEMAKAIAN');
		$objPHPExcel->getActiveSheet()->setCellValue('H10', 'KARANTINA');
		$objPHPExcel->getActiveSheet()->setCellValue('I10', 'SISA STOK');
		$objPHPExcel->getActiveSheet()->setCellValue('J10', 'RATA2 PEMAKAIAN');
		$objPHPExcel->getActiveSheet()->setCellValue('K10', 'KECUKUPAN BULAN');
		$objPHPExcel->getActiveSheet()->setCellValue('L10', 'KEBUTUHAN');
		$objPHPExcel->getActiveSheet()->setCellValue('M10', 'HARGA');
		$objPHPExcel->getActiveSheet()->setCellValue('N10', 'TOTAL');

		$items = array();
		$items = $this->mlaporanapt->getMutasiObatBulanan($kd_unit_apt, $bulan, $bulan1, $tahun, $kd_nomenklatur, $kategori);
		//debugvar($kd_unit_apt);
		$baris = 11;
		$nomor = 1;
		$totalall = 0;
		foreach ($items as $item) {


			for ($x = 'A'; $x <= 'N'; $x++) {
				if ($x == 'A') {
					$objPHPExcel->getActiveSheet()->getStyle($x . $baris)->getAlignment()->applyFromArray(
						array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, 'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER, 'rotation'   => 0,)
					);
				} else if ($x == 'B') {
					$objPHPExcel->getActiveSheet()->getStyle($x . $baris)->getAlignment()->applyFromArray(
						array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT, 'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER, 'rotation'   => 0,)
					);
				} else if ($x == 'C') {
					$objPHPExcel->getActiveSheet()->getStyle($x . $baris)->getAlignment()->applyFromArray(
						array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT, 'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER, 'rotation'   => 0,)
					);
				} else if ($x == 'D') {
					$objPHPExcel->getActiveSheet()->getStyle($x . $baris)->getAlignment()->applyFromArray(
						array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT, 'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER, 'rotation'   => 0,)
					);
				} else if ($x == 'E') {
					$objPHPExcel->getActiveSheet()->getStyle($x . $baris)->getAlignment()->applyFromArray(
						array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT, 'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER, 'rotation'   => 0,)
					);
				} else if ($x == 'F') {
					$objPHPExcel->getActiveSheet()->getStyle($x . $baris)->getAlignment()->applyFromArray(
						array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT, 'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER, 'rotation'   => 0,)
					);
				} else if ($x == 'G') {
					$objPHPExcel->getActiveSheet()->getStyle($x . $baris)->getAlignment()->applyFromArray(
						array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT, 'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER, 'rotation'   => 0,)
					);
				} else if ($x == 'H') {
					$objPHPExcel->getActiveSheet()->getStyle($x . $baris)->getAlignment()->applyFromArray(
						array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT, 'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER, 'rotation'   => 0,)
					);
				} else if ($x == 'I') {
					$objPHPExcel->getActiveSheet()->getStyle($x . $baris)->getAlignment()->applyFromArray(
						array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT, 'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER, 'rotation'   => 0,)
					);
				} else if ($x == 'J') {
					$objPHPExcel->getActiveSheet()->getStyle($x . $baris)->getAlignment()->applyFromArray(
						array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT, 'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER, 'rotation'   => 0,)
					);
				} else if ($x == 'K') {
					$objPHPExcel->getActiveSheet()->getStyle($x . $baris)->getAlignment()->applyFromArray(
						array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT, 'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER, 'rotation'   => 0,)
					);
				} else if ($x == 'L') {
					$objPHPExcel->getActiveSheet()->getStyle($x . $baris)->getAlignment()->applyFromArray(
						array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT, 'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER, 'rotation'   => 0,)
					);
				} else if ($x == 'M') {
					$objPHPExcel->getActiveSheet()->getStyle($x . $baris)->getAlignment()->applyFromArray(
						array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT, 'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER, 'rotation'   => 0,)
					);
				} else if ($x == 'N') {
					$objPHPExcel->getActiveSheet()->getStyle($x . $baris)->getAlignment()->applyFromArray(
						array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT, 'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER, 'rotation'   => 0,)
					);
				}
				$objPHPExcel->getActiveSheet()->getStyle($x . $baris)->applyFromArray(array(
					'font'    => array(
						'name'      => 'calibri',
						'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
						'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
						'size'		=> 11 /*untuk ukuran tulisan yg hasil query bwt yg di dlm tabel*/,
						'color'     => array('rgb' => '000000')
					),
					'borders' => array(
						'bottom'     => array(
							'style' => PHPExcel_Style_Border::BORDER_THIN,
							'color' => array('rgb' => '000000')
						),
						'top'     => array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('rgb' => '000000')),
						'left'     => array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('rgb' => '000000')),
						'right'     => array(
							'style' => PHPExcel_Style_Border::BORDER_THIN,
							'color' => array('rgb' => '000000')
						)
					)
				));
			}
			$persediaan = 0;
			$persediaan = $item['saldo_awal'] + $item['in_pbf'];
			//$opt=0;
			//$opt=$item['out_jual']/(($bulan1-$bulan)+1);
			$total = 0;
			$total = $item['saldo_akhir'] * $item['harga_beli'];

			if (empty($kd_unit_apt)) {
				$jmlbulanobat = $this->db->query('select sum(saldo_awal) as saldo_awal from apt_mutasi_obat where kd_obat="' . $item['kd_obat'] . '" and tahun ="' . $tahun . '" and bulan between "' . $bulan . '" and "' . $bulan1 . '"  group by bulan having saldo_awal > 0 ')->num_rows();
			} else {

				$jmlbulanobat = $this->db->query('select sum(saldo_awal) as saldo_awal from apt_mutasi_obat where kd_obat="' . $item['kd_obat'] . '" and tahun ="' . $tahun . '" and bulan between "' . $bulan . '" and "' . $bulan1 . '" group by bulan having saldo_awal > 0 ')->num_rows();
			}
			if (empty($jmlbulanobat)) $jmlbulanobat = 1;
			$opt = 0;
			$opt = ($item['out_jual'] / $jmlbulanobat);
			$objPHPExcel->getActiveSheet()->setCellValue('A' . $baris, $nomor);

			$objPHPExcel->getActiveSheet()->setCellValue('B' . $baris, $item['nama_obat']);
			$objPHPExcel->getActiveSheet()->setCellValue('C' . $baris, $item['satuan_kecil']);
			$objPHPExcel->getActiveSheet()->setCellValue('D' . $baris, number_format($item['saldo_awal'], 0, '.', ','));
			$objPHPExcel->getActiveSheet()->setCellValue('E' . $baris, number_format($item['in_pbf'], 0, '.', ','));
			$objPHPExcel->getActiveSheet()->setCellValue('F' . $baris, number_format($persediaan, 0, '.', ','));
			$objPHPExcel->getActiveSheet()->setCellValue('G' . $baris, number_format($item['out_jual'], 0, '.', ','));
			$objPHPExcel->getActiveSheet()->setCellValue('H' . $baris, number_format($item['out_disposal'], 0, '.', ','));
			$objPHPExcel->getActiveSheet()->setCellValue('I' . $baris, number_format($item['saldo_akhir'], 0, '.', ','));
			$objPHPExcel->getActiveSheet()->setCellValue('J' . $baris, number_format($opt, 0, '.', ','));
			if ($opt > 0) {
				$objPHPExcel->getActiveSheet()->setCellValue('K' . $baris, number_format($item['saldo_akhir'] / $opt, 0, '.', ','));
				$objPHPExcel->getActiveSheet()->setCellValue('L' . $baris, number_format($opt / $bulan_kebutuhan, 0, '.', ','));
			} else {
				$objPHPExcel->getActiveSheet()->setCellValue('K' . $baris, number_format(0, 0, '.', ','));
			}
			$objPHPExcel->getActiveSheet()->setCellValue('M' . $baris, number_format($item['harga_beli'], 0, '.', ','));
			$objPHPExcel->getActiveSheet()->setCellValue('N' . $baris, number_format($total, 0, '.', ','));
			$nomor = $nomor + 1;
			$baris = $baris + 1;
			$totalall = $totalall + $total;
		}
		for ($x = 'A'; $x <= 'N'; $x++) {
			if ($x == 'A') {
				$objPHPExcel->getActiveSheet()->getStyle($x . $baris)->getAlignment()->applyFromArray(
					array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, 'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER, 'rotation'   => 0,)
				);
			} else if ($x == 'B') {
				$objPHPExcel->getActiveSheet()->getStyle($x . $baris)->getAlignment()->applyFromArray(
					array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT, 'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER, 'rotation'   => 0,)
				);
			} else if ($x == 'C') {
				$objPHPExcel->getActiveSheet()->getStyle($x . $baris)->getAlignment()->applyFromArray(
					array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT, 'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER, 'rotation'   => 0,)
				);
			} else if ($x == 'D') {
				$objPHPExcel->getActiveSheet()->getStyle($x . $baris)->getAlignment()->applyFromArray(
					array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT, 'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER, 'rotation'   => 0,)
				);
			} else if ($x == 'E') {
				$objPHPExcel->getActiveSheet()->getStyle($x . $baris)->getAlignment()->applyFromArray(
					array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT, 'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER, 'rotation'   => 0,)
				);
			} else if ($x == 'F') {
				$objPHPExcel->getActiveSheet()->getStyle($x . $baris)->getAlignment()->applyFromArray(
					array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT, 'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER, 'rotation'   => 0,)
				);
			} else if ($x == 'G') {
				$objPHPExcel->getActiveSheet()->getStyle($x . $baris)->getAlignment()->applyFromArray(
					array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT, 'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER, 'rotation'   => 0,)
				);
			} else if ($x == 'H') {
				$objPHPExcel->getActiveSheet()->getStyle($x . $baris)->getAlignment()->applyFromArray(
					array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT, 'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER, 'rotation'   => 0,)
				);
			} else if ($x == 'I') {
				$objPHPExcel->getActiveSheet()->getStyle($x . $baris)->getAlignment()->applyFromArray(
					array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT, 'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER, 'rotation'   => 0,)
				);
			} else if ($x == 'J') {
				$objPHPExcel->getActiveSheet()->getStyle($x . $baris)->getAlignment()->applyFromArray(
					array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT, 'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER, 'rotation'   => 0,)
				);
			} else if ($x == 'K') {
				$objPHPExcel->getActiveSheet()->getStyle($x . $baris)->getAlignment()->applyFromArray(
					array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT, 'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER, 'rotation'   => 0,)
				);
			} else if ($x == 'L') {
				$objPHPExcel->getActiveSheet()->getStyle($x . $baris)->getAlignment()->applyFromArray(
					array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT, 'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER, 'rotation'   => 0,)
				);
			} else if ($x == 'M') {
				$objPHPExcel->getActiveSheet()->getStyle($x . $baris)->getAlignment()->applyFromArray(
					array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT, 'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER, 'rotation'   => 0,)
				);
			} else if ($x == 'N') {
				$objPHPExcel->getActiveSheet()->getStyle($x . $baris)->getAlignment()->applyFromArray(
					array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT, 'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER, 'rotation'   => 0,)
				);
			}
			$objPHPExcel->getActiveSheet()->getStyle($x . $baris)->applyFromArray(array(
				'font'    => array(
					'name'      => 'calibri',
					'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
					'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
					'size'		=> 11 /*untuk ukuran tulisan yg hasil query bwt yg di dlm tabel*/,
					'color'     => array('rgb' => '000000')
				),
				'borders' => array(
					'bottom'     => array(
						'style' => PHPExcel_Style_Border::BORDER_THIN,
						'color' => array('rgb' => '000000')
					),
					'top'     => array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('rgb' => '000000')),
					'left'     => array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('rgb' => '000000')),
					'right'     => array(
						'style' => PHPExcel_Style_Border::BORDER_THIN,
						'color' => array('rgb' => '000000')
					)
				)
			));
		}
		$objPHPExcel->getActiveSheet()->mergeCells('A' . $baris . ':L' . $baris);
		$objPHPExcel->getActiveSheet()->setCellValue('A' . $baris, 'T O T A L :');
		$objPHPExcel->getActiveSheet()->setCellValue('N' . $baris, number_format($totalall, 2, '.', ','));
		$objWriter = IOFactory::createWriter($objPHPExcel, 'Excel5');
		$objWriter->save("download/mutasiobat.xls");
		header("Location: " . base_url() . "download/mutasiobat.xls");
	}

	public function excelobatsasbulanan2($bulan = "", $bulan1 = "", $tahun = "", $kd_unit_apt = "", $kd_nomenklatur = "", $bulan_kebutuhan = "", $kategori = "")
	{
		if ($kd_unit_apt == "NULL") $kd_unit_apt = "";
		$this->load->library('PHPExcel');
		$this->load->library('PHPExcel/IOFactory');
		$objPHPExcel = new PHPExcel();
		$objPHPExcel->getProperties()->setTitle("title")->setDescription("description");
		$objPHPExcel->getActiveSheet()->mergeCells('A2:M2');
		$objPHPExcel->getActiveSheet()->mergeCells('A3:M3');
		$objPHPExcel->getActiveSheet()->mergeCells('A4:M4');
		$objPHPExcel->getActiveSheet()->mergeCells('A6:M6');
		$objPHPExcel->getActiveSheet()->mergeCells('A7:M7');
		$objPHPExcel->getActiveSheet()->mergeCells('A8:M8');

		$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(0)->setWidth(4.14); //no
		$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(1)->setWidth(30.5); //nama obat
		$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(2)->setWidth(10); //satuan
		$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(3)->setWidth(10); //saldo awal
		$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(4)->setWidth(10); //penerimaan
		$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(5)->setWidth(10); //persediaan
		$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(6)->setWidth(10); //pemakaian
		$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(7)->setWidth(10); //sisa stok
		$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(8)->setWidth(10); //stok opt
		$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(9)->setWidth(10); //permintaan
		$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(10)->setWidth(10); //harga
		$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(11)->setWidth(10); //total


		for ($x = 'A'; $x <= 'L'; $x++) { //bwt judul2nya
			$objPHPExcel->getActiveSheet()->getStyle($x . '2')->getAlignment()->applyFromArray(
				array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT, 'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER, 'rotation'   => 0,)
			);
		}
		for ($x = 'A'; $x <= 'L'; $x++) {
			$objPHPExcel->getActiveSheet()->getStyle($x . '3')->getAlignment()->applyFromArray(
				array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT, 'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER, 'rotation'   => 0,)
			);
		}
		for ($x = 'A'; $x <= 'L'; $x++) {
			$objPHPExcel->getActiveSheet()->getStyle($x . '4')->getAlignment()->applyFromArray(
				array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT, 'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER, 'rotation'   => 0,)
			);
		}
		for ($x = 'A'; $x <= 'L'; $x++) {
			$objPHPExcel->getActiveSheet()->getStyle($x . '6')->getAlignment()->applyFromArray(
				array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, 'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER, 'rotation'   => 0,)
			);
		}
		for ($x = 'A'; $x <= 'L'; $x++) {
			$objPHPExcel->getActiveSheet()->getStyle($x . '7')->getAlignment()->applyFromArray(
				array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, 'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER, 'rotation'   => 0,)
			);
		}
		for ($x = 'A'; $x <= 'L'; $x++) {
			$objPHPExcel->getActiveSheet()->getStyle($x . '8')->getAlignment()->applyFromArray(
				array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, 'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER, 'rotation'   => 0,)
			);
		}
		$profil = $this->mlaporanapt->ambilItemData('profil');
		$objPHPExcel->getActiveSheet()->setCellValue('A2', '');
		$objPHPExcel->getActiveSheet()->setCellValue('A3', $profil['nama_profil']);
		$objPHPExcel->getActiveSheet()->setCellValue('A4', 'Kota Balikpapan');
		$objPHPExcel->getActiveSheet()->setCellValue('A6', 'LAPORAN MUTASI OBAT SAS');
		//$bulan1="";
		//if($bulan=='01'){$bulan1='Januari';} 	 if($bulan=='02'){$bulan1='Februari';}	if($bulan=='03'){$bulan1='Maret';} 	  if($bulan=='04'){$bulan1='April';}
		//if($bulan=='05'){$bulan1='Mei';} 		 if($bulan=='06'){$bulan1='Juni';} 		if($bulan=='07'){$bulan1='Juli';} 	  if($bulan=='08'){$bulan1='Agustus';}
		//if($bulan=='09'){$bulan1='September';}   if($bulan=='10'){$bulan1='Oktober';}	if($bulan=='11'){$bulan1='November';} if($bulan=='12'){$bulan1='Desember';}
		$objPHPExcel->getActiveSheet()->setCellValue('A7', 'Bulan ' . $bulan . ' Sampai ' . $bulan1 . ' ' . $tahun);
		$namaunit = $this->mlaporanapt->namaUnit($kd_unit_apt);
		$objPHPExcel->getActiveSheet()->setCellValue('A8', $namaunit);

		for ($x = 'A'; $x <= 'J'; $x++) {
			$objPHPExcel->getActiveSheet()->getStyle($x . '10')->getAlignment()->applyFromArray(
				array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, 'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER, 'rotation'   => 0,)
			);
			$objPHPExcel->getActiveSheet()->getStyle($x . '11')->getAlignment()->applyFromArray(
				array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, 'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER, 'rotation'   => 0,)
			);

			$objPHPExcel->getActiveSheet()->getStyle($x . '10')->applyFromArray(array(
				'font'    => array(
					'name'      => 'calibri',
					'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
					'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
					'size'		=> 11 /*untuk ukuran tulisan judul kolom2 di tabel*/,
					'color'     => array('rgb' => '000000')
				),
				'borders' => array(
					'bottom'     => array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('rgb' => '000000')),
					'top'     => array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('rgb' => '000000')),
					'left'     => array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('rgb' => '000000')),
					'right'     => array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('rgb' => '000000'))
				)
			));
			$objPHPExcel->getActiveSheet()->getStyle($x . '11')->applyFromArray(array(
				'font'    => array(
					'name'      => 'calibri',
					'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
					'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
					'size'		=> 11 /*untuk ukuran tulisan judul kolom2 di tabel*/,
					'color'     => array('rgb' => '000000')
				),
				'borders' => array(
					'bottom'     => array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('rgb' => '000000')),
					'top'     => array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('rgb' => '000000')),
					'left'     => array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('rgb' => '000000')),
					'right'     => array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('rgb' => '000000'))
				)
			));
		}

		$objPHPExcel->getActiveSheet()->setCellValue('A10', 'NO.');
		$objPHPExcel->getActiveSheet()->setCellValue('B10', 'NAMA OBAT');
		$objPHPExcel->getActiveSheet()->setCellValue('C10', 'SATUAN');
		$objPHPExcel->getActiveSheet()->setCellValue('D10', 'KODE SAS');
		$objPHPExcel->getActiveSheet()->setCellValue('E10', 'SALDO AWAL');
		$objPHPExcel->getActiveSheet()->setCellValue('F10', 'PENERIMAAN');
		$objPHPExcel->getActiveSheet()->setCellValue('G10', 'PERSEDIAAN');
		$objPHPExcel->getActiveSheet()->setCellValue('H10', 'PEMAKAIAN');
		$objPHPExcel->getActiveSheet()->setCellValue('I10', 'KARANTINA');
		$objPHPExcel->getActiveSheet()->setCellValue('J10', 'SISA STOK');

		$items = array();
		$items = $this->mlaporanapt->getMutasiObatSasBulanan($kd_unit_apt, $bulan, $bulan1, $tahun, $kd_nomenklatur, $kategori);
		//debugvar($kd_unit_apt);
		$baris = 11;
		$nomor = 1;
		$totalall = 0;
		foreach ($items as $item) {


			for ($x = 'A'; $x <= 'J'; $x++) {
				if ($x == 'A') {
					$objPHPExcel->getActiveSheet()->getStyle($x . $baris)->getAlignment()->applyFromArray(
						array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, 'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER, 'rotation'   => 0,)
					);
				} else if ($x == 'B') {
					$objPHPExcel->getActiveSheet()->getStyle($x . $baris)->getAlignment()->applyFromArray(
						array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT, 'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER, 'rotation'   => 0,)
					);
				} else if ($x == 'C') {
					$objPHPExcel->getActiveSheet()->getStyle($x . $baris)->getAlignment()->applyFromArray(
						array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT, 'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER, 'rotation'   => 0,)
					);
				} else if ($x == 'D') {
					$objPHPExcel->getActiveSheet()->getStyle($x . $baris)->getAlignment()->applyFromArray(
						array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT, 'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER, 'rotation'   => 0,)
					);
				} else if ($x == 'E') {
					$objPHPExcel->getActiveSheet()->getStyle($x . $baris)->getAlignment()->applyFromArray(
						array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT, 'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER, 'rotation'   => 0,)
					);
				} else if ($x == 'F') {
					$objPHPExcel->getActiveSheet()->getStyle($x . $baris)->getAlignment()->applyFromArray(
						array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT, 'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER, 'rotation'   => 0,)
					);
				} else if ($x == 'G') {
					$objPHPExcel->getActiveSheet()->getStyle($x . $baris)->getAlignment()->applyFromArray(
						array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT, 'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER, 'rotation'   => 0,)
					);
				} else if ($x == 'H') {
					$objPHPExcel->getActiveSheet()->getStyle($x . $baris)->getAlignment()->applyFromArray(
						array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT, 'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER, 'rotation'   => 0,)
					);
				} else if ($x == 'I') {
					$objPHPExcel->getActiveSheet()->getStyle($x . $baris)->getAlignment()->applyFromArray(
						array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT, 'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER, 'rotation'   => 0,)
					);
				} else if ($x == 'J') {
					$objPHPExcel->getActiveSheet()->getStyle($x . $baris)->getAlignment()->applyFromArray(
						array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT, 'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER, 'rotation'   => 0,)
					);
				} else if ($x == 'K') {
					$objPHPExcel->getActiveSheet()->getStyle($x . $baris)->getAlignment()->applyFromArray(
						array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT, 'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER, 'rotation'   => 0,)
					);
				} else if ($x == 'L') {
					$objPHPExcel->getActiveSheet()->getStyle($x . $baris)->getAlignment()->applyFromArray(
						array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT, 'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER, 'rotation'   => 0,)
					);
				} else if ($x == 'M') {
					$objPHPExcel->getActiveSheet()->getStyle($x . $baris)->getAlignment()->applyFromArray(
						array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT, 'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER, 'rotation'   => 0,)
					);
				} else if ($x == 'N') {
					$objPHPExcel->getActiveSheet()->getStyle($x . $baris)->getAlignment()->applyFromArray(
						array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT, 'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER, 'rotation'   => 0,)
					);
				}
				$objPHPExcel->getActiveSheet()->getStyle($x . $baris)->applyFromArray(array(
					'font'    => array(
						'name'      => 'calibri',
						'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
						'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
						'size'		=> 11 /*untuk ukuran tulisan yg hasil query bwt yg di dlm tabel*/,
						'color'     => array('rgb' => '000000')
					),
					'borders' => array(
						'bottom'     => array(
							'style' => PHPExcel_Style_Border::BORDER_THIN,
							'color' => array('rgb' => '000000')
						),
						'top'     => array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('rgb' => '000000')),
						'left'     => array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('rgb' => '000000')),
						'right'     => array(
							'style' => PHPExcel_Style_Border::BORDER_THIN,
							'color' => array('rgb' => '000000')
						)
					)
				));
			}
			$persediaan = 0;
			$persediaan = $item['saldo_awal'] + $item['in_pbf'];
			//$opt=0;
			//$opt=$item['out_jual']/(($bulan1-$bulan)+1);
			$total = 0;
			$total = $item['saldo_akhir'] * $item['harga_beli'];

			if (empty($kd_unit_apt)) {
				$jmlbulanobat = $this->db->query('select sum(saldo_awal) as saldo_awal from apt_mutasi_obat where kd_obat="' . $item['kd_obat'] . '" and tahun ="' . $tahun . '" and bulan between "' . $bulan . '" and "' . $bulan1 . '"  group by bulan having saldo_awal > 0 ')->num_rows();
			} else {

				$jmlbulanobat = $this->db->query('select sum(saldo_awal) as saldo_awal from apt_mutasi_obat where kd_obat="' . $item['kd_obat'] . '" and tahun ="' . $tahun . '" and bulan between "' . $bulan . '" and "' . $bulan1 . '" group by bulan having saldo_awal > 0 ')->num_rows();
			}
			if (empty($jmlbulanobat)) $jmlbulanobat = 1;
			$opt = 0;
			$opt = ($item['out_jual'] / $jmlbulanobat);
			$objPHPExcel->getActiveSheet()->setCellValue('A' . $baris, $nomor);

			$objPHPExcel->getActiveSheet()->setCellValue('B' . $baris, $item['nama_obat']);
			$objPHPExcel->getActiveSheet()->setCellValue('C' . $baris, $item['satuan_kecil']);
			$objPHPExcel->getActiveSheet()->setCellValue('D' . $baris, $item['kode_sas']);
			$objPHPExcel->getActiveSheet()->setCellValue('E' . $baris, number_format($item['saldo_awal'], 0, '.', ','));
			$objPHPExcel->getActiveSheet()->setCellValue('F' . $baris, number_format($item['in_pbf'], 0, '.', ','));
			$objPHPExcel->getActiveSheet()->setCellValue('G' . $baris, number_format($persediaan, 0, '.', ','));
			$objPHPExcel->getActiveSheet()->setCellValue('H' . $baris, number_format($item['out_jual'], 0, '.', ','));
			$objPHPExcel->getActiveSheet()->setCellValue('I' . $baris, number_format($item['out_disposal'], 0, '.', ','));
			$objPHPExcel->getActiveSheet()->setCellValue('J' . $baris, number_format($item['saldo_akhir'], 0, '.', ','));
			$nomor = $nomor + 1;
			$baris = $baris + 1;
			$totalall = $totalall + $total;
		}
		for ($x = 'A'; $x <= 'J'; $x++) {
			if ($x == 'A') {
				$objPHPExcel->getActiveSheet()->getStyle($x . $baris)->getAlignment()->applyFromArray(
					array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, 'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER, 'rotation'   => 0,)
				);
			} else if ($x == 'B') {
				$objPHPExcel->getActiveSheet()->getStyle($x . $baris)->getAlignment()->applyFromArray(
					array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT, 'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER, 'rotation'   => 0,)
				);
			} else if ($x == 'C') {
				$objPHPExcel->getActiveSheet()->getStyle($x . $baris)->getAlignment()->applyFromArray(
					array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT, 'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER, 'rotation'   => 0,)
				);
			} else if ($x == 'D') {
				$objPHPExcel->getActiveSheet()->getStyle($x . $baris)->getAlignment()->applyFromArray(
					array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT, 'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER, 'rotation'   => 0,)
				);
			} else if ($x == 'E') {
				$objPHPExcel->getActiveSheet()->getStyle($x . $baris)->getAlignment()->applyFromArray(
					array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT, 'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER, 'rotation'   => 0,)
				);
			} else if ($x == 'F') {
				$objPHPExcel->getActiveSheet()->getStyle($x . $baris)->getAlignment()->applyFromArray(
					array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT, 'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER, 'rotation'   => 0,)
				);
			} else if ($x == 'G') {
				$objPHPExcel->getActiveSheet()->getStyle($x . $baris)->getAlignment()->applyFromArray(
					array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT, 'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER, 'rotation'   => 0,)
				);
			} else if ($x == 'H') {
				$objPHPExcel->getActiveSheet()->getStyle($x . $baris)->getAlignment()->applyFromArray(
					array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT, 'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER, 'rotation'   => 0,)
				);
			} else if ($x == 'I') {
				$objPHPExcel->getActiveSheet()->getStyle($x . $baris)->getAlignment()->applyFromArray(
					array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT, 'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER, 'rotation'   => 0,)
				);
			} else if ($x == 'J') {
				$objPHPExcel->getActiveSheet()->getStyle($x . $baris)->getAlignment()->applyFromArray(
					array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT, 'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER, 'rotation'   => 0,)
				);
			} else if ($x == 'K') {
				$objPHPExcel->getActiveSheet()->getStyle($x . $baris)->getAlignment()->applyFromArray(
					array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT, 'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER, 'rotation'   => 0,)
				);
			} else if ($x == 'L') {
				$objPHPExcel->getActiveSheet()->getStyle($x . $baris)->getAlignment()->applyFromArray(
					array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT, 'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER, 'rotation'   => 0,)
				);
			} else if ($x == 'M') {
				$objPHPExcel->getActiveSheet()->getStyle($x . $baris)->getAlignment()->applyFromArray(
					array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT, 'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER, 'rotation'   => 0,)
				);
			} else if ($x == 'N') {
				$objPHPExcel->getActiveSheet()->getStyle($x . $baris)->getAlignment()->applyFromArray(
					array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT, 'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER, 'rotation'   => 0,)
				);
			}
			$objPHPExcel->getActiveSheet()->getStyle($x . $baris)->applyFromArray(array(
				'font'    => array(
					'name'      => 'calibri',
					'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
					'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
					'size'		=> 11 /*untuk ukuran tulisan yg hasil query bwt yg di dlm tabel*/,
					'color'     => array('rgb' => '000000')
				),
				'borders' => array(
					'bottom'     => array(
						'style' => PHPExcel_Style_Border::BORDER_THIN,
						'color' => array('rgb' => '000000')
					),
					'top'     => array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('rgb' => '000000')),
					'left'     => array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('rgb' => '000000')),
					'right'     => array(
						'style' => PHPExcel_Style_Border::BORDER_THIN,
						'color' => array('rgb' => '000000')
					)
				)
			));
		}
		// $objPHPExcel->getActiveSheet()->mergeCells('A' . $baris . ':L' . $baris);
		// $objPHPExcel->getActiveSheet()->setCellValue('A' . $baris, 'T O T A L :');
		// $objPHPExcel->getActiveSheet()->setCellValue('N' . $baris, number_format($totalall, 2, '.', ','));
		$objWriter = IOFactory::createWriter($objPHPExcel, 'Excel5');
		$objWriter->save("download/mutasiobatsas.xls");
		header("Location: " . base_url() . "download/mutasiobatsas.xls");
	}

	public function rl1excelpersediaanobat($stok = "", $isistok = "", $kd_unit_apt = "", $kd_golongan = "")
	{
		$stok1 = "";
		$stoka = "";
		$isistok1 = "";
		$this->load->library('phpexcel');
		$this->load->library('PHPExcel/iofactory');
		$objPHPExcel = new PHPExcel();
		$objPHPExcel->getProperties()->setTitle("title")->setDescription("description");
		$objPHPExcel->getActiveSheet()->mergeCells('A2:H2');
		$objPHPExcel->getActiveSheet()->mergeCells('A3:H3');
		$objPHPExcel->getActiveSheet()->mergeCells('A4:H4');
		$objPHPExcel->getActiveSheet()->mergeCells('A5:H5');
		$objPHPExcel->getActiveSheet()->mergeCells('A6:H6');
		$objPHPExcel->getActiveSheet()->mergeCells('A7:H7');

		//$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(0)->setWidth(2.14); 
		$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(0)->setWidth(4.14); //NO
		$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(1)->setWidth(12); //kode
		$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(2)->setWidth(14); //nama obat
		$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(3)->setWidth(45); //satuan
		$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(4)->setWidth(7); //tgl expire
		$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(5)->setWidth(23); //stok
		$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(6)->setWidth(11); //harga beli
		$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(7)->setWidth(11); //jumlah
		$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(8)->setWidth(8); //jumlah
		$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(9)->setWidth(11); //jumlah
		$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(10)->setWidth(13); //jumlah
		//debugvar($kd_unit_apt);
		for ($x = 'A'; $x <= 'K'; $x++) { //bwt judul2nya
			$objPHPExcel->getActiveSheet()->getStyle($x . '2')->getAlignment()->applyFromArray(
				array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, 'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER, 'rotation'   => 0,)
			);
		}
		for ($x = 'A'; $x <= 'K'; $x++) {
			$objPHPExcel->getActiveSheet()->getStyle($x . '3')->getAlignment()->applyFromArray(
				array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, 'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER, 'rotation'   => 0,)
			);
		}
		for ($x = 'A'; $x <= 'K'; $x++) {
			$objPHPExcel->getActiveSheet()->getStyle($x . '4')->getAlignment()->applyFromArray(
				array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, 'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER, 'rotation'   => 0,)
			);
		}
		for ($x = 'A'; $x <= 'K'; $x++) {
			$objPHPExcel->getActiveSheet()->getStyle($x . '6')->getAlignment()->applyFromArray(
				array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, 'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER, 'rotation'   => 0,)
			);
		}
		for ($x = 'A'; $x <= 'K'; $x++) {
			$objPHPExcel->getActiveSheet()->getStyle($x . '7')->getAlignment()->applyFromArray(
				array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, 'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER, 'rotation'   => 0,)
			);
		}
		for ($x = 'A'; $x <= 'K'; $x++) {
			$objPHPExcel->getActiveSheet()->getStyle($x . '8')->getAlignment()->applyFromArray(
				array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, 'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER, 'rotation'   => 0,)
			);
		}
		$objPHPExcel->getActiveSheet()->setCellValue('A2', 'Gudang Farmasi Kota');
		$objPHPExcel->getActiveSheet()->setCellValue('A3', 'Kota Balikpapan');
		$objPHPExcel->getActiveSheet()->setCellValue('A4', 'LAPORAN PERSEDIAAN OBAT / ALKES');

		$namaunit = $this->mlaporanapt->namaUnit($kd_unit_apt);
		if ($namaunit == '0' or $namaunit == '') {
			$objPHPExcel->getActiveSheet()->setCellValue('A5', 'Unit : Semua Sumber');
		} else {
			$objPHPExcel->getActiveSheet()->setCellValue('A5', 'Unit : ' . $namaunit);
		}

		if ($stok == '1') {
			$stok1 = "lebih besar dari";
			$stoka = ">";
		} else if ($stok == '2') {
			$stok1 = "lebih kecil dari";
			$stoka = "<";
		} else if ($stok == '3') {
			$stok1 = "lebih besar sama dengan";
			$stoka = ">=";
		} else if ($stok == '4') {
			$stok1 = "lebih kecil sama dengan";
			$stoka = "<=";
		} else {
			$stok1 = "sama dengan";
			$stoka = "=";
		}

		if ($isistok == '' or $isistok == 'null') {
			$isistok1 = 0;
		} else {
			$isistok1 = $isistok;
		}
		$objPHPExcel->getActiveSheet()->setCellValue('A6', 'Stok ' . $stok1 . ' ' . $isistok1);

		for ($x = 'A'; $x <= 'K'; $x++) {
			$objPHPExcel->getActiveSheet()->getStyle($x . '8')->getAlignment()->applyFromArray(
				array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, 'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER, 'rotation'   => 0,)
			);

			$objPHPExcel->getActiveSheet()->getStyle($x . '8')->applyFromArray(array(
				'font'    => array(
					'name'      => 'calibri',
					'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
					'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
					'size'		=> 11 /*untuk ukuran tulisan judul kolom2 di tabel*/,
					'color'     => array('rgb' => '000000')
				),
				'borders' => array(
					'bottom'     => array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('rgb' => '000000')),
					'top'     => array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('rgb' => '000000')),
					'left'     => array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('rgb' => '000000')),
					'right'     => array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('rgb' => '000000'))
				)
			));
		}
		$objPHPExcel->getActiveSheet()->setCellValue('A8', 'NO.');
		$objPHPExcel->getActiveSheet()->setCellValue('B8', 'KODE');
		$objPHPExcel->getActiveSheet()->setCellValue('C8', 'SUMBER DANA');
		$objPHPExcel->getActiveSheet()->setCellValue('D8', 'NAMA OBAT');
		$objPHPExcel->getActiveSheet()->setCellValue('E8', 'SAT.');
		$objPHPExcel->getActiveSheet()->setCellValue('F8', 'PABRIK.');
		$objPHPExcel->getActiveSheet()->setCellValue('G8', 'BATCH.');
		$objPHPExcel->getActiveSheet()->setCellValue('H8', 'TGL. EXPIRE');
		$objPHPExcel->getActiveSheet()->setCellValue('I8', 'STOK');
		$objPHPExcel->getActiveSheet()->setCellValue('J8', 'HRG.BELI');
		$objPHPExcel->getActiveSheet()->setCellValue('K8', 'JUMLAH');
		$items = array();
		$items = $this->mlaporanapt->getAllPersediaanApotek($stok, $isistok, $kd_unit_apt, $kd_golongan);
		$baris = 9;
		$nomor = 1;
		$total = 0;
		foreach ($items as $item) {
			# code...
			for ($x = 'A'; $x <= 'K'; $x++) {
				if ($x == 'A') {
					$objPHPExcel->getActiveSheet()->getStyle($x . $baris)->getAlignment()->applyFromArray(
						array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, 'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER, 'rotation'   => 0,)
					);
				} else if ($x == 'B') {
					$objPHPExcel->getActiveSheet()->getStyle($x . $baris)->getAlignment()->applyFromArray(
						array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, 'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER, 'rotation'   => 0,)
					);
				} else if ($x == 'C') {
					$objPHPExcel->getActiveSheet()->getStyle($x . $baris)->getAlignment()->applyFromArray(
						array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, 'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER, 'rotation'   => 0,)
					);
				} else if ($x == 'D') {
					$objPHPExcel->getActiveSheet()->getStyle($x . $baris)->getAlignment()->applyFromArray(
						array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT, 'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER, 'rotation'   => 0,)
					);
				} else if ($x == 'E') {
					$objPHPExcel->getActiveSheet()->getStyle($x . $baris)->getAlignment()->applyFromArray(
						array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, 'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER, 'rotation'   => 0,)
					);
				} else if ($x == 'F') {
					$objPHPExcel->getActiveSheet()->getStyle($x . $baris)->getAlignment()->applyFromArray(
						array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT, 'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER, 'rotation'   => 0,)
					);
				} else if ($x == 'G') {
					$objPHPExcel->getActiveSheet()->getStyle($x . $baris)->getAlignment()->applyFromArray(
						array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT, 'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER, 'rotation'   => 0,)
					);
				} else if ($x == 'H') {
					$objPHPExcel->getActiveSheet()->getStyle($x . $baris)->getAlignment()->applyFromArray(
						array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT, 'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER, 'rotation'   => 0,)
					);
				} else if ($x == 'I') {
					$objPHPExcel->getActiveSheet()->getStyle($x . $baris)->getAlignment()->applyFromArray(
						array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT, 'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER, 'rotation'   => 0,)
					);
				} else if ($x == 'J') {
					$objPHPExcel->getActiveSheet()->getStyle($x . $baris)->getAlignment()->applyFromArray(
						array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT, 'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER, 'rotation'   => 0,)
					);
				} else if ($x == 'K') {
					$objPHPExcel->getActiveSheet()->getStyle($x . $baris)->getAlignment()->applyFromArray(
						array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT, 'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER, 'rotation'   => 0,)
					);
				}
				$objPHPExcel->getActiveSheet()->getStyle($x . $baris)->applyFromArray(array(
					'font'    => array(
						'name'      => 'calibri',
						'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
						'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
						'size'		=> 11 /*untuk ukuran tulisan yg hasil query bwt yg di dlm tabel*/,
						'color'     => array('rgb' => '000000')
					),
					'borders' => array(
						'bottom'     => array(
							'style' => PHPExcel_Style_Border::BORDER_THIN,
							'color' => array('rgb' => '000000')
						),
						'top'     => array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('rgb' => '000000')),
						'left'     => array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('rgb' => '000000')),
						'right'     => array(
							'style' => PHPExcel_Style_Border::BORDER_THIN,
							'color' => array('rgb' => '000000')
						)
					)
				));
			}
			$nilai = $item['jml_stok'] * $item['harga_pokok'];
			$objPHPExcel->getActiveSheet()->setCellValue('A' . $baris, $nomor);
			$objPHPExcel->getActiveSheet()->setCellValue('B' . $baris, $item['kd_obat']);
			$objPHPExcel->getActiveSheet()->setCellValue('C' . $baris, $item['nama_unit_apt']);
			$objPHPExcel->getActiveSheet()->setCellValue('D' . $baris, $item['nama_obat']);
			$objPHPExcel->getActiveSheet()->setCellValue('E' . $baris, $item['satuan_kecil']);
			$objPHPExcel->getActiveSheet()->setCellValue('F' . $baris, $item['nama_pabrik']);
			$objPHPExcel->getActiveSheet()->setCellValue('G' . $baris, $item['batch']);
			$objPHPExcel->getActiveSheet()->setCellValue('H' . $baris, convertDate($item['tgl_expire']));
			$objPHPExcel->getActiveSheet()->setCellValue('I' . $baris, $item['jml_stok']);
			$objPHPExcel->getActiveSheet()->setCellValue('J' . $baris, number_format($item['harga_pokok'], 2, ',', '.'));
			$objPHPExcel->getActiveSheet()->setCellValue('K' . $baris, number_format($nilai, 2, ',', '.'));

			$nomor = $nomor + 1;
			$baris = $baris + 1;
			$total = $total + $nilai;
		}
		for ($x = 'A'; $x <= 'K'; $x++) {
			if ($x == 'A') {
				$objPHPExcel->getActiveSheet()->getStyle($x . $baris)->getAlignment()->applyFromArray(
					array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT, 'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER, 'rotation'   => 0,)
				);
			} else if ($x == 'K') {
				$objPHPExcel->getActiveSheet()->getStyle($x . $baris)->getAlignment()->applyFromArray(
					array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT, 'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER, 'rotation'   => 0,)
				);
			}
			$objPHPExcel->getActiveSheet()->getStyle($x . $baris)->applyFromArray(array(
				'font'    => array(
					'name'      => 'calibri',
					'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
					'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
					'size'		=> 11 /*untuk ukuran tulisan yg hasil query bwt yg di dlm tabel*/,
					'color'     => array('rgb' => '000000')
				),
				'borders' => array(
					'bottom'     => array(
						'style' => PHPExcel_Style_Border::BORDER_THIN,
						'color' => array('rgb' => '000000')
					),
					'top'     => array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('rgb' => '000000')),
					'left'     => array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('rgb' => '000000')),
					'right'     => array(
						'style' => PHPExcel_Style_Border::BORDER_THIN,
						'color' => array('rgb' => '000000')
					)
				)
			));
		}
		//$objPHPExcel->getActiveSheet()->mergeCells('B8:I8');
		$objPHPExcel->getActiveSheet()->mergeCells('A' . $baris . ':J' . $baris);
		$objPHPExcel->getActiveSheet()->setCellValue('A' . $baris, 'T O T A L :');
		$objPHPExcel->getActiveSheet()->setCellValue('K' . $baris, number_format($total, 2, ',', '.'));
		$objWriter = IOFactory::createWriter($objPHPExcel, 'Excel5');
		$objWriter->save("download/persediaanobat.xls");
		header("Location: " . base_url() . "download/persediaanobat.xls");
	}

	public function stokopname()
	{
		$bulan = date('m');
		$tahun = date('Y');
		$stok = '1';
		$isistok = '';
		$kd_unit_apt = '';
		$nama_unit_apt = '';
		if ($this->input->post('bulan') != '') {
			$bulan = $this->input->post('bulan');
		}
		if ($this->input->post('tahun') != '') {
			$tahun = $this->input->post('tahun');
		}
		if ($this->input->post('kd_unit_apt') != '') {
			$kd_unit_apt = $this->input->post('kd_unit_apt');
		}
		$cssfileheader = array('bootstrap.css', 'bootstrap-responsive.min.css', 'font-awesome.min.css', 'style.css', 'prettify.css', 'jquery-ui.css', 'DT_bootstrap.css', 'responsive-tables.css', 'datepicker.css', 'theme.css');
		$jsfileheader = array(
			'vendor/modernizr-2.6.2-respond-1.1.0.min.js',
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
			'lib/bootstrap-modal.js',
			'spin.js',
			'main.js'
		);
		$dataheader = array('jsfile' => $jsfileheader, 'cssfile' => $cssfileheader, 'title' => $this->title);

		$jsfooter = array();
		$datafooter = array('jsfile' => $jsfooter);

		$data = array(
			'sumberdana' => $this->mlaporanapt->sumberdana(),
			'items' => $this->mlaporanapt->getWow($bulan, $tahun, $kd_unit_apt),
			'bulan' => $bulan,
			'tahun' => $tahun,
			'unitapotek' => $this->mlaporanapt->ambilData('apt_unit'),
			'kd_unit_apt' => $kd_unit_apt
		);

		$this->load->view('headerapotek', $dataheader);
		$this->load->view('laporanapotek/lapstokopname', $data);
		$this->load->view('footer', $datafooter);
	}

	public function rl1excelstokopname($bulan = "", $tahun = "", $kd_unit_apt = "")
	{
		//$queryjudul=mysql_query("select nama from simpus_puskesmas");
		$judul = '';
		$bln = "";

		$this->load->library('phpexcel');
		$this->load->library('PHPExcel/iofactory');
		$objPHPExcel = new PHPExcel();
		$objPHPExcel->getProperties()->setTitle("title")->setDescription("description");
		$objPHPExcel->getActiveSheet()->mergeCells('A1:H1');
		$objPHPExcel->getActiveSheet()->mergeCells('A2:H2');
		$objPHPExcel->getActiveSheet()->mergeCells('A3:H3');

		$objPHPExcel->getActiveSheet()->mergeCells('A4:A5');
		$objPHPExcel->getActiveSheet()->getStyle('A4')->getAlignment()->setWrapText(true);
		$objPHPExcel->getActiveSheet()->mergeCells('B4:B5');
		$objPHPExcel->getActiveSheet()->getStyle('B4')->getAlignment()->setWrapText(true);
		$objPHPExcel->getActiveSheet()->mergeCells('C4:C5');
		$objPHPExcel->getActiveSheet()->getStyle('C4')->getAlignment()->setWrapText(true);
		$objPHPExcel->getActiveSheet()->mergeCells('D4:D5');
		$objPHPExcel->getActiveSheet()->getStyle('D4')->getAlignment()->setWrapText(true);
		$objPHPExcel->getActiveSheet()->mergeCells('E4:E5');
		$objPHPExcel->getActiveSheet()->getStyle('E4')->getAlignment()->setWrapText(true);
		$objPHPExcel->getActiveSheet()->mergeCells('F4:F5');
		$objPHPExcel->getActiveSheet()->getStyle('F4')->getAlignment()->setWrapText(true);
		$objPHPExcel->getActiveSheet()->mergeCells('G4:G5');
		$objPHPExcel->getActiveSheet()->getStyle('G4')->getAlignment()->setWrapText(true);
		$objPHPExcel->getActiveSheet()->mergeCells('H4:H5');
		$objPHPExcel->getActiveSheet()->getStyle('H4')->getAlignment()->setWrapText(true);

		//$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(0)->setWidth(2.14); 
		$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(0)->setWidth(5); //NO
		$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(1)->setWidth(17); //tgl stokopname
		$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(2)->setWidth(31); //nama
		$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(3)->setWidth(10); //satuan
		$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(4)->setWidth(15); //stok lama
		$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(5)->setWidth(10); //stok baru
		$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(6)->setWidth(15); //harga
		$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(7)->setWidth(15); //nilai
		$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(8)->setWidth(15); //nilai
		$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(9)->setWidth(15); //nilai

		for ($x = 'A'; $x <= 'H'; $x++) { //bwt judul2nya
			$objPHPExcel->getActiveSheet()->getStyle($x . '1')->getAlignment()->applyFromArray(
				array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, 'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER, 'rotation'   => 0,)
			);
		}
		for ($x = 'A'; $x <= 'I'; $x++) {
			$objPHPExcel->getActiveSheet()->getStyle($x . '2')->getAlignment()->applyFromArray(
				array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, 'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER, 'rotation'   => 0,)
			);
		}
		for ($x = 'A'; $x <= 'I'; $x++) {
			$objPHPExcel->getActiveSheet()->getStyle($x . '3')->getAlignment()->applyFromArray(
				array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, 'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER, 'rotation'   => 0,)
			);
		}

		//debugvar($bulan1);
		if ($bulan == '01') {
			$bln = "Januari";
		}
		if ($bulan == '02') {
			$bln = "Februari";
		}
		if ($bulan == '03') {
			$bln = "Maret";
		}
		if ($bulan == '04') {
			$bln = "April";
		}
		if ($bulan == '05') {
			$bln = "Mei";
		}
		if ($bulan == '06') {
			$bln = "Juni";
		}
		if ($bulan == '07') {
			$bln = "Juli";
		}
		if ($bulan == '08') {
			$bln = "Agustus";
		}
		if ($bulan == '09') {
			$bln = "September";
		}
		if ($bulan == '10') {
			$bln = "Oktober";
		}
		if ($bulan == '11') {
			$bln = "November";
		}
		if ($bulan == '12') {
			$bln = "Desember";
		}

		$objPHPExcel->getActiveSheet()->setCellValue('A1', 'STOCK OPNAME PER ' . strtoupper($bln) . ' ' . $tahun . ' GFK BALIKPAPAN ');

		$unit = $this->mlaporanapt->namaunit($kd_unit_apt);
		$objPHPExcel->getActiveSheet()->setCellValue('A2', strtoupper($unit));

		for ($x = 'A'; $x <= 'K'; $x++) {
			$objPHPExcel->getActiveSheet()->getStyle($x . '4')->getAlignment()->applyFromArray(
				array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, 'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER, 'rotation'   => 0,)
			);

			$objPHPExcel->getActiveSheet()->getStyle($x . '4')->applyFromArray(array(
				'font'    => array(
					'name'      => 'calibri',
					'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
					'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
					'size'		=> 10 /*untuk ukuran tulisan judul kolom2 di tabel*/,
					'color'     => array('rgb' => '000000')
				),
				'borders' => array(
					'bottom'     => array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('rgb' => '000000')),
					'top'     => array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('rgb' => '000000')),
					'left'     => array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('rgb' => '000000')),
					'right'     => array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('rgb' => '000000'))
				)
			));
			$objPHPExcel->getActiveSheet()->getStyle($x . '5')->applyFromArray(array(
				'font'    => array(
					'name'      => 'calibri',
					'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
					'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
					'size'		=> 10 /*untuk ukuran tulisan judul kolom2 di tabel*/,
					'color'     => array('rgb' => '000000')
				),
				'borders' => array(
					'bottom'     => array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('rgb' => '000000')),
					'top'     => array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('rgb' => '000000')),
					'left'     => array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('rgb' => '000000')),
					'right'     => array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('rgb' => '000000'))
				)
			));
		}
		$objPHPExcel->getActiveSheet()->setCellValue('A4', 'NO');
		$objPHPExcel->getActiveSheet()->setCellValue('B4', 'TGL. STOKOPNAME');
		$objPHPExcel->getActiveSheet()->setCellValue('C4', 'NAMA OBAT');
		$objPHPExcel->getActiveSheet()->setCellValue('D4', 'SATUAN');
		$objPHPExcel->getActiveSheet()->setCellValue('E4', 'PABRIK');
		$objPHPExcel->getActiveSheet()->setCellValue('F4', 'TGL EXPIRE');
		$objPHPExcel->getActiveSheet()->setCellValue('G4', 'BATCH');
		$objPHPExcel->getActiveSheet()->setCellValue('H4', 'STOK LAMA');
		$objPHPExcel->getActiveSheet()->setCellValue('I4', 'STOK BARU');
		$objPHPExcel->getActiveSheet()->setCellValue('J4', 'HNA');
		$objPHPExcel->getActiveSheet()->setCellValue('K4', 'NILAI');
		$items = array();
		$items = $this->mlaporanapt->getWow($bulan, $tahun, $kd_unit_apt);
		//debugvar($items);
		$baris = 6;
		$nomor = 1;
		$total = 0;
		//$nilai=0;
		foreach ($items as $item) {

			# code...
			for ($x = 'A'; $x <= 'K'; $x++) {
				if ($x == 'A') {
					$objPHPExcel->getActiveSheet()->getStyle($x . $baris)->getAlignment()->applyFromArray(
						array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, 'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER, 'rotation'   => 0,)
					);
				} else if ($x == 'B') {
					$objPHPExcel->getActiveSheet()->getStyle($x . $baris)->getAlignment()->applyFromArray(
						array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT, 'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER, 'rotation'   => 0,)
					);
				} else if ($x == 'C') {
					$objPHPExcel->getActiveSheet()->getStyle($x . $baris)->getAlignment()->applyFromArray(
						array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT, 'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER, 'rotation'   => 0,)
					);
				} else if ($x == 'D') {
					$objPHPExcel->getActiveSheet()->getStyle($x . $baris)->getAlignment()->applyFromArray(
						array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, 'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER, 'rotation'   => 0,)
					);
				} else if ($x == 'E') {
					$objPHPExcel->getActiveSheet()->getStyle($x . $baris)->getAlignment()->applyFromArray(
						array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT, 'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER, 'rotation'   => 0,)
					);
				} else if ($x == 'F') {
					$objPHPExcel->getActiveSheet()->getStyle($x . $baris)->getAlignment()->applyFromArray(
						array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT, 'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER, 'rotation'   => 0,)
					);
				} else if ($x == 'G') {
					$objPHPExcel->getActiveSheet()->getStyle($x . $baris)->getAlignment()->applyFromArray(
						array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT, 'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER, 'rotation'   => 0,)
					);
				} else if ($x == 'H') {
					$objPHPExcel->getActiveSheet()->getStyle($x . $baris)->getAlignment()->applyFromArray(
						array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT, 'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER, 'rotation'   => 0,)
					);
				} else {
					$objPHPExcel->getActiveSheet()->getStyle($x . $baris)->getAlignment()->applyFromArray(
						array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT, 'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER, 'rotation'   => 0,)
					);
				}
				$objPHPExcel->getActiveSheet()->getStyle($x . $baris)->applyFromArray(array(
					'font'    => array(
						'name'      => 'calibri',
						'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
						'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
						'size'		=> 10,
						'color'     => array('rgb' => '000000')
					),
					'borders' => array(
						'bottom'     => array(
							'style' => PHPExcel_Style_Border::BORDER_THIN,
							'color' => array('rgb' => '000000')
						),
						'top'     => array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('rgb' => '000000')),
						'left'     => array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('rgb' => '000000')),
						'right'     => array(
							'style' => PHPExcel_Style_Border::BORDER_THIN,
							'color' => array('rgb' => '000000')
						)
					)
				));
			}
			$objPHPExcel->getActiveSheet()->setCellValue('A' . $baris, $nomor);
			$objPHPExcel->getActiveSheet()->setCellValue('B' . $baris, $item['tanggal']);
			$objPHPExcel->getActiveSheet()->setCellValue('C' . $baris, $item['nama_obat']);
			$objPHPExcel->getActiveSheet()->setCellValue('D' . $baris, $item['satuan_kecil']);
			$objPHPExcel->getActiveSheet()->setCellValue('E' . $baris, $item['nama_pabrik']);
			$objPHPExcel->getActiveSheet()->setCellValue('F' . $baris, $item['tgl_expired']);
			$objPHPExcel->getActiveSheet()->setCellValue('G' . $baris, $item['batch']);
			$objPHPExcel->getActiveSheet()->setCellValue('H' . $baris, number_format($item['stok_lama'], 2, '.', ','));
			$objPHPExcel->getActiveSheet()->setCellValue('I' . $baris, number_format($item['stok_baru'], 2, '.', ','));
			$objPHPExcel->getActiveSheet()->setCellValue('J' . $baris, 'Rp ' . number_format($item['harga'], 2, '.', ','));
			$nilai = $item['harga'] * $item['stok_baru'];
			//$objPHPExcel->getActiveSheet()->setCellValue ('I'.$baris,'Rp '.number_format($nilai,0,'',','));
			if ($item['stok_baru'] == 0) {
				$objPHPExcel->getActiveSheet()->setCellValue('K' . $baris, 'Rp -');
			} else {
				$objPHPExcel->getActiveSheet()->setCellValue('K' . $baris, 'Rp ' . number_format($nilai, 2, '.', ','));
			}

			$nomor = $nomor + 1;
			$baris = $baris + 1;
			$total = $total + $nilai;
			$nilai = 0;
		}

		for ($x = 'A'; $x <= 'K'; $x++) {
			if ($x == 'A') {
				$objPHPExcel->getActiveSheet()->getStyle($x . $baris)->getAlignment()->applyFromArray(
					array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, 'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER, 'rotation'   => 0,)
				);
			} else if ($x == 'F') {
				$objPHPExcel->getActiveSheet()->getStyle($x . $baris)->getAlignment()->applyFromArray(
					array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT, 'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER, 'rotation'   => 0,)
				);
			}
			$objPHPExcel->getActiveSheet()->getStyle($x . $baris)->applyFromArray(array(
				'font'    => array(
					'name'      => 'calibri',
					'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
					'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
					'size'		=> 10 /*untuk ukuran tulisan yg hasil query bwt yg di dlm tabel*/,
					'color'     => array('rgb' => '000000')
				),
				'borders' => array(
					'bottom'     => array(
						'style' => PHPExcel_Style_Border::BORDER_THIN,
						'color' => array('rgb' => '000000')
					),
					'top'     => array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('rgb' => '000000')),
					'left'     => array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('rgb' => '000000')),
					'right'     => array(
						'style' => PHPExcel_Style_Border::BORDER_THIN,
						'color' => array('rgb' => '000000')
					)
				)
			));
		}

		$objPHPExcel->getActiveSheet()->mergeCells('A' . $baris . ':J' . $baris);
		$objPHPExcel->getActiveSheet()->setCellValue('A' . $baris, 'TOTAL NILAI');
		$objPHPExcel->getActiveSheet()->setCellValue('K' . $baris, 'Rp ' . number_format($total, 2, '.', ','));

		for ($x = 'D'; $x <= 'K'; $x++) {
			if ($x == 'F') {
				$objPHPExcel->getActiveSheet()->getStyle($x . ($baris + 2))->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT, 'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER, 'rotation'   => 0,));
				$objPHPExcel->getActiveSheet()->getStyle($x . ($baris + 1))->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT, 'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER, 'rotation'   => 0,));
				$objPHPExcel->getActiveSheet()->getStyle($x . ($baris + 4))->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT, 'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER, 'rotation'   => 0,));
				$objPHPExcel->getActiveSheet()->getStyle($x . ($baris + 1))->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT, 'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER, 'rotation'   => 0,));
			}

			$objPHPExcel->getActiveSheet()->getStyle($x . ($baris + 2))->applyFromArray(array('font'    => array(
				'name'      => 'calibri',
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
				'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
				'size'		=> 10,
				'color'     => array('rgb' => '000000')
			)));
			$objPHPExcel->getActiveSheet()->getStyle($x . ($baris + 1))->applyFromArray(array('font'    => array(
				'name'      => 'calibri',
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
				'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
				'size'		=> 10,
				'color'     => array('rgb' => '000000')
			)));
			$objPHPExcel->getActiveSheet()->getStyle($x . ($baris + 4))->applyFromArray(array('font'    => array(
				'name'      => 'calibri',
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
				'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
				'size'		=> 10,
				'color'     => array('rgb' => '000000')
			)));
			$objPHPExcel->getActiveSheet()->getStyle($x . ($baris + 1))->applyFromArray(array('font'    => array(
				'name'      => 'calibri',
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
				'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
				'size'		=> 10,
				'color'     => array('rgb' => '000000')
			)));
		}

		/*$baris=$baris+2;
		$objPHPExcel->getActiveSheet()->mergeCells('F'.$baris.':H'.$baris);
		//$objPHPExcel->getActiveSheet()->setCellValue ('D'.$baris,'Balikpapan, '.$tgl.' '.$bln.' '.$tahun);
		$objPHPExcel->getActiveSheet()->setCellValue ('F'.$baris,'Balikpapan, ' .$bln.' '.$tahun);
		
		$baris=$baris+1;
		$objPHPExcel->getActiveSheet()->mergeCells('F'.$baris.':H'.$baris);
		$objPHPExcel->getActiveSheet()->setCellValue ('F'.$baris,'Pengguna Anggaran');
		
		$baris=$baris+4;
		$objPHPExcel->getActiveSheet()->mergeCells('F'.$baris.':H'.$baris);
		$objPHPExcel->getActiveSheet()->setCellValue ('F'.$baris,'Dr. Indah Puspitasari');
		
		$baris=$baris+1;
		$objPHPExcel->getActiveSheet()->mergeCells('F'.$baris.':H'.$baris);
		$objPHPExcel->getActiveSheet()->setCellValue ('F'.$baris,'NIP. 19670530 199803 2 003');*/

		$objWriter = IOFactory::createWriter($objPHPExcel, 'Excel5');
		$objWriter->save("download/lapstokopnameobat.xls");
		header("Location: " . base_url() . "download/lapstokopnameobat.xls");
	}

	public function statuspermintaanobat()
	{
		if (!$this->muser->isAkses("78")) {
			$this->restricted();
			return false;
		}
		//$kd_unit_apt=$this->session->userdata('kd_unit_apt');
		//$nama_unit_apt=$this->input->post('nama_unit_apt');
		$periodeawal = date('d-m-Y');
		$periodeakhir = date('d-m-Y');
		$kd_unit_apt = '';
		$nama_unit_apt = '';
		$permintaan_status = '';

		if ($this->input->post('periodeawal') != '') {
			$periodeawal = $this->input->post('periodeawal');
		}
		if ($this->input->post('periodeakhir') != '') {
			$periodeakhir = $this->input->post('periodeakhir');
		}
		if ($this->input->post('kd_unit_apt') != '') {
			$kd_unit_apt = $this->input->post('kd_unit_apt');
		}
		if ($this->input->post('nama_unit_apt') != '') {
			$kd_unit_apt = $this->input->post('nama_unit_apt');
		}
		if ($this->input->post('permintaan_status') != '') {
			$permintaan_status = $this->input->post('permintaan_status');
		}
		$cssfileheader = array('bootstrap.css', 'bootstrap-responsive.min.css', 'font-awesome.min.css', 'style.css', 'prettify.css', 'jquery-ui.css', 'DT_bootstrap.css', 'responsive-tables.css', 'datepicker.css', 'theme.css');
		$jsfileheader = array(
			'vendor/modernizr-2.6.2-respond-1.1.0.min.js',
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
			'lib/bootstrap-modal.js',
			'spin.js',
			'main.js'
		);
		$dataheader = array('jsfile' => $jsfileheader, 'cssfile' => $cssfileheader, 'title' => $this->title);

		$jsfooter = array();
		$datafooter = array('jsfile' => $jsfooter);

		$data = array(
			'items' => $this->mlaporanapt->getStatusPermintaan($periodeawal, $periodeakhir, $permintaan_status, $kd_unit_apt),
			'unitapotek' => $this->mlaporanapt->ambilData("apt_unit", "kd_unit_apt<>'U01'"),
			'periodeawal' => $periodeawal,
			'periodeakhir' => $periodeakhir,
			'permintaan_status' => $permintaan_status,
			'kd_unit_apt' => $kd_unit_apt,
			'nama_unit_apt' => $nama_unit_apt
		);
		//debugvar($data);
		$this->load->view('headerapotek', $dataheader);
		$this->load->view('laporanapotek/statuspermintaanobat', $data);
		$this->load->view('footer', $datafooter);
	}

	public function statuspemesananobat()
	{
		if (!$this->muser->isAkses("90")) {
			$this->restricted();
			return false;
		}
		$periodeawal = date('d-m-Y');
		$periodeakhir = date('d-m-Y');
		$kd_supplier = '';
		//$nama_unit_apt='';
		$pemesanan_status = '';

		if ($this->input->post('periodeawal') != '') {
			$periodeawal = $this->input->post('periodeawal');
		}
		if ($this->input->post('periodeakhir') != '') {
			$periodeakhir = $this->input->post('periodeakhir');
		}
		if ($this->input->post('kd_supplier') != '') {
			$kd_supplier = $this->input->post('kd_supplier');
		}
		/*if($this->input->post('nama_unit_apt')!=''){
			$kd_unit_apt=$this->input->post('nama_unit_apt');
		}*/
		if ($this->input->post('pemesanan_status') != '') {
			$pemesanan_status = $this->input->post('pemesanan_status');
		}
		$cssfileheader = array('bootstrap.css', 'bootstrap-responsive.min.css', 'font-awesome.min.css', 'style.css', 'prettify.css', 'jquery-ui.css', 'DT_bootstrap.css', 'responsive-tables.css', 'datepicker.css', 'theme.css');
		$jsfileheader = array(
			'vendor/modernizr-2.6.2-respond-1.1.0.min.js',
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
			'lib/bootstrap-modal.js',
			'spin.js',
			'main.js'
		);
		$dataheader = array('jsfile' => $jsfileheader, 'cssfile' => $cssfileheader, 'title' => $this->title);

		$jsfooter = array();
		$datafooter = array('jsfile' => $jsfooter);

		$data = array(
			'items' => $this->mlaporanapt->getStatusPemesanan($periodeawal, $periodeakhir, $pemesanan_status, $kd_supplier),
			'datasupplier' => $this->mlaporanapt->ambilData("apt_supplier", "is_aktif='1'"),
			'periodeawal' => $periodeawal,
			'periodeakhir' => $periodeakhir,
			'pemesanan_status' => $pemesanan_status,
			'kd_supplier' => $kd_supplier
			//'nama_unit_apt'=>$nama_unit_apt
		);
		//debugvar($data);
		$this->load->view('headerapotek', $dataheader);
		$this->load->view('laporanapotek/statuspemesananobat', $data);
		$this->load->view('footer', $datafooter);
	}

	public function logpenerimaan()
	{
		if (!$this->muser->isAkses("70")) {
			$this->restricted();
			return false;
		}
		$periodeawal = date('d-m-Y');
		$periodeakhir = date('d-m-Y');
		$kd_supplier = '';
		$jenis = '';
		$kd_unit_apt = $this->session->userdata('kd_unit_apt');
		$nama_unit_apt = $this->input->post('nama_unit_apt');

		if ($this->input->post('kd_unit_apt') != '') {
			$kd_unit_apt = $this->input->post('kd_unit_apt');
		}
		if ($this->input->post('periodeawal') != '') {
			$periodeawal = $this->input->post('periodeawal');
		}
		if ($this->input->post('periodeakhir') != '') {
			$periodeakhir = $this->input->post('periodeakhir');
		}
		if ($this->input->post('kd_supplier') != '') {
			$kd_supplier = $this->input->post('kd_supplier');
		}
		if ($this->input->post('jenis') != '') {
			$jenis = $this->input->post('jenis');
		}
		$cssfileheader = array('bootstrap.css', 'bootstrap-responsive.min.css', 'font-awesome.min.css', 'style.css', 'prettify.css', 'jquery-ui.css', 'DT_bootstrap.css', 'responsive-tables.css', 'datepicker.css', 'theme.css');
		$jsfileheader = array(
			'vendor/modernizr-2.6.2-respond-1.1.0.min.js',
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
			'lib/bootstrap-modal.js',
			'spin.js',
			'main.js'
		);
		$dataheader = array('jsfile' => $jsfileheader, 'cssfile' => $cssfileheader, 'title' => $this->title);

		$jsfooter = array();
		$datafooter = array('jsfile' => $jsfooter);

		$data = array(
			'items' => $this->mlaporanapt->getLog($periodeawal, $periodeakhir, $kd_supplier, $jenis),
			'unitapotek' => $this->mlaporanapt->ambilData('apt_unit'),
			'periodeawal' => $periodeawal,
			'periodeakhir' => $periodeakhir,
			'kd_supplier' => $kd_supplier,
			'jenis' => $jenis,
			'datasupplier' => $this->mlaporanapt->ambilData("apt_supplier", "is_aktif='1'")
		);
		//debugvar($data);
		$this->load->view('headerapotek', $dataheader);
		$this->load->view('laporanapotek/logpenerimaan', $data);
		$this->load->view('footer', $datafooter);
	}

	public function excelmutasiobat($kd_unit_apt = "", $bulan = "", $tahun = "")
	{
		$this->load->library('phpexcel');
		$this->load->library('PHPExcel/iofactory');
		$objPHPExcel = new PHPExcel();
		$objPHPExcel->getProperties()->setTitle("title")->setDescription("description");
		$objPHPExcel->getActiveSheet()->mergeCells('A2:M2');
		$objPHPExcel->getActiveSheet()->mergeCells('A3:M3');
		$objPHPExcel->getActiveSheet()->mergeCells('A4:M4');
		$objPHPExcel->getActiveSheet()->mergeCells('A6:M6');
		$objPHPExcel->getActiveSheet()->mergeCells('A7:M7');
		$objPHPExcel->getActiveSheet()->mergeCells('A8:M8');

		//$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(0)->setWidth(2.14); 
		$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(0)->setWidth(4.14); //no
		$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(1)->setWidth(32); //nama obat
		$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(2)->setWidth(8); //saldo awal
		//$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(4)->setWidth(9); //harga
		//$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(5)->setWidth(13); //total awal
		$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(3)->setWidth(6); //pbf masuk
		$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(4)->setWidth(6); //unit masuk
		$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(5)->setWidth(6); //retur masuk
		$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(6)->setWidth(7); //jml masuk
		//$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(10)->setWidth(13); //total masuk
		$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(7)->setWidth(6); //resep keluar
		$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(8)->setWidth(6); //unit keluar
		$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(9)->setWidth(6); //retur keluar
		$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(10)->setWidth(7); //jml keluar
		//$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(15)->setWidth(13); //total keluar
		$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(11)->setWidth(7); //stokopname
		$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(12)->setWidth(8); //saldo akhir
		//$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(18)->setWidth(13); //total akhir

		for ($x = 'A'; $x <= 'M'; $x++) { //bwt judul2nya
			$objPHPExcel->getActiveSheet()->getStyle($x . '2')->getAlignment()->applyFromArray(
				array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT, 'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER, 'rotation'   => 0,)
			);
		}
		for ($x = 'A'; $x <= 'M'; $x++) {
			$objPHPExcel->getActiveSheet()->getStyle($x . '3')->getAlignment()->applyFromArray(
				array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT, 'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER, 'rotation'   => 0,)
			);
		}
		for ($x = 'A'; $x <= 'M'; $x++) {
			$objPHPExcel->getActiveSheet()->getStyle($x . '4')->getAlignment()->applyFromArray(
				array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT, 'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER, 'rotation'   => 0,)
			);
		}
		for ($x = 'A'; $x <= 'M'; $x++) {
			$objPHPExcel->getActiveSheet()->getStyle($x . '6')->getAlignment()->applyFromArray(
				array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, 'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER, 'rotation'   => 0,)
			);
		}
		for ($x = 'A'; $x <= 'M'; $x++) {
			$objPHPExcel->getActiveSheet()->getStyle($x . '7')->getAlignment()->applyFromArray(
				array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, 'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER, 'rotation'   => 0,)
			);
		}
		for ($x = 'A'; $x <= 'M'; $x++) {
			$objPHPExcel->getActiveSheet()->getStyle($x . '8')->getAlignment()->applyFromArray(
				array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, 'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER, 'rotation'   => 0,)
			);
		}
		$objPHPExcel->getActiveSheet()->setCellValue('A2', 'RUMAH SAKIT');
		$objPHPExcel->getActiveSheet()->setCellValue('A3', 'IBNU SINA');
		$objPHPExcel->getActiveSheet()->setCellValue('A4', 'Kota Balikpapan');
		$objPHPExcel->getActiveSheet()->setCellValue('A6', 'LAPORAN MUTASI OBAT');
		$bulan1 = "";
		if ($bulan == '01') {
			$bulan1 = 'Januari';
		}
		if ($bulan == '02') {
			$bulan1 = 'Februari';
		}
		if ($bulan == '03') {
			$bulan1 = 'Maret';
		}
		if ($bulan == '04') {
			$bulan1 = 'April';
		}
		if ($bulan == '05') {
			$bulan1 = 'Mei';
		}
		if ($bulan == '06') {
			$bulan1 = 'Juni';
		}
		if ($bulan == '07') {
			$bulan1 = 'Juli';
		}
		if ($bulan == '08') {
			$bulan1 = 'Agustus';
		}
		if ($bulan == '09') {
			$bulan1 = 'September';
		}
		if ($bulan == '10') {
			$bulan1 = 'Oktober';
		}
		if ($bulan == '11') {
			$bulan1 = 'November';
		}
		if ($bulan == '12') {
			$bulan1 = 'Desember';
		}
		$objPHPExcel->getActiveSheet()->setCellValue('A7', $bulan1 . ' ' . $tahun);
		$namaunit = $this->mlaporanapt->namaUnit($kd_unit_apt);
		$objPHPExcel->getActiveSheet()->setCellValue('A8', $namaunit);

		for ($x = 'A'; $x <= 'M'; $x++) {
			$objPHPExcel->getActiveSheet()->getStyle($x . '10')->getAlignment()->applyFromArray(
				array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, 'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER, 'rotation'   => 0,)
			);
			$objPHPExcel->getActiveSheet()->getStyle($x . '11')->getAlignment()->applyFromArray(
				array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, 'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER, 'rotation'   => 0,)
			);

			$objPHPExcel->getActiveSheet()->getStyle($x . '10')->applyFromArray(array(
				'font'    => array(
					'name'      => 'calibri',
					'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
					'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
					'size'		=> 10 /*untuk ukuran tulisan judul kolom2 di tabel*/,
					'color'     => array('rgb' => '000000')
				),
				'borders' => array(
					'bottom'     => array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('rgb' => '000000')),
					'top'     => array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('rgb' => '000000')),
					'left'     => array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('rgb' => '000000')),
					'right'     => array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('rgb' => '000000'))
				)
			));
			$objPHPExcel->getActiveSheet()->getStyle($x . '11')->applyFromArray(array(
				'font'    => array(
					'name'      => 'calibri',
					'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
					'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
					'size'		=> 10 /*untuk ukuran tulisan judul kolom2 di tabel*/,
					'color'     => array('rgb' => '000000')
				),
				'borders' => array(
					'bottom'     => array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('rgb' => '000000')),
					'top'     => array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('rgb' => '000000')),
					'left'     => array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('rgb' => '000000')),
					'right'     => array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('rgb' => '000000'))
				)
			));
		}
		$objPHPExcel->getActiveSheet()->mergeCells('A10:A11'); 	//$objPHPExcel->getActiveSheet()->getStyle('B10')->getAlignment()->setWrapText(true);
		$objPHPExcel->getActiveSheet()->setCellValue('A10', 'NO');
		$objPHPExcel->getActiveSheet()->mergeCells('B10:B11');
		$objPHPExcel->getActiveSheet()->setCellValue('B10', 'NAMA OBAT');
		$objPHPExcel->getActiveSheet()->mergeCells('C10:C11');
		$objPHPExcel->getActiveSheet()->getStyle('C10')->getAlignment()->setWrapText(true);
		$objPHPExcel->getActiveSheet()->setCellValue('C10', 'SLD. AWL');
		/*$objPHPExcel->getActiveSheet()->mergeCells('E10:E11');  $objPHPExcel->getActiveSheet()->setCellValue ('E10','HARGA');
		$objPHPExcel->getActiveSheet()->mergeCells('F10:F11');  $objPHPExcel->getActiveSheet()->getStyle('F10')->getAlignment()->setWrapText(true);
		$objPHPExcel->getActiveSheet()->setCellValue ('F10','TOTAL AWAL');*/
		$objPHPExcel->getActiveSheet()->mergeCells('D10:G10');
		$objPHPExcel->getActiveSheet()->setCellValue('D10', 'MASUK');
		$objPHPExcel->getActiveSheet()->setCellValue('D11', 'PBF');
		$objPHPExcel->getActiveSheet()->setCellValue('E11', 'Unit');
		$objPHPExcel->getActiveSheet()->setCellValue('F11', 'Retur');
		$objPHPExcel->getActiveSheet()->setCellValue('G11', 'Jml.');
		/*$objPHPExcel->getActiveSheet()->mergeCells('K10:K11');  $objPHPExcel->getActiveSheet()->getStyle('K10')->getAlignment()->setWrapText(true);
		$objPHPExcel->getActiveSheet()->setCellValue ('K10','TOTAL MASUK');*/
		$objPHPExcel->getActiveSheet()->mergeCells('H10:K10');
		$objPHPExcel->getActiveSheet()->setCellValue('H10', 'KELUAR');
		$objPHPExcel->getActiveSheet()->setCellValue('H11', 'Resep');
		$objPHPExcel->getActiveSheet()->setCellValue('I11', 'Unit');
		$objPHPExcel->getActiveSheet()->setCellValue('J11', 'Retur');
		$objPHPExcel->getActiveSheet()->setCellValue('K11', 'Jml.');
		/*$objPHPExcel->getActiveSheet()->mergeCells('P10:P11');  $objPHPExcel->getActiveSheet()->getStyle('P10')->getAlignment()->setWrapText(true);
		$objPHPExcel->getActiveSheet()->setCellValue ('P10','TOTAL KELUAR');*/
		$objPHPExcel->getActiveSheet()->mergeCells('L10:L11');
		$objPHPExcel->getActiveSheet()->getStyle('L10')->getAlignment()->setWrapText(true);
		$objPHPExcel->getActiveSheet()->setCellValue('L10', 'STOKOPNAME');
		$objPHPExcel->getActiveSheet()->mergeCells('M10:M11');
		$objPHPExcel->getActiveSheet()->getStyle('M10')->getAlignment()->setWrapText(true);
		$objPHPExcel->getActiveSheet()->setCellValue('M10', 'SLD. AKR');
		/*$objPHPExcel->getActiveSheet()->mergeCells('S10:S11');  $objPHPExcel->getActiveSheet()->getStyle('S10')->getAlignment()->setWrapText(true);
		$objPHPExcel->getActiveSheet()->setCellValue ('S10','TOTAL AKHIR');*/
		$items = array();
		$items = $this->mlaporanapt->ambilMutasiObat($kd_unit_apt, $bulan, $tahun);
		$baris = 12;
		$nomor = 1;
		$sumtotalawal = 0;
		$sumtotalmasuk = 0;
		$sumtotalkeluar = 0;
		$sumtotalakhir = 0;
		foreach ($items as $item) {
			# code...
			for ($x = 'A'; $x <= 'M'; $x++) {
				if ($x == 'A') {
					$objPHPExcel->getActiveSheet()->getStyle($x . $baris)->getAlignment()->applyFromArray(
						array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, 'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER, 'rotation'   => 0,)
					);
				} else if ($x == 'B') {
					$objPHPExcel->getActiveSheet()->getStyle($x . $baris)->getAlignment()->applyFromArray(
						array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT, 'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER, 'rotation'   => 0,)
					);
				} else if ($x == 'C') {
					$objPHPExcel->getActiveSheet()->getStyle($x . $baris)->getAlignment()->applyFromArray(
						array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT, 'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER, 'rotation'   => 0,)
					);
				} else if ($x == 'D') {
					$objPHPExcel->getActiveSheet()->getStyle($x . $baris)->getAlignment()->applyFromArray(
						array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT, 'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER, 'rotation'   => 0,)
					);
				} else if ($x == 'E') {
					$objPHPExcel->getActiveSheet()->getStyle($x . $baris)->getAlignment()->applyFromArray(
						array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT, 'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER, 'rotation'   => 0,)
					);
				} else if ($x == 'F') {
					$objPHPExcel->getActiveSheet()->getStyle($x . $baris)->getAlignment()->applyFromArray(
						array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT, 'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER, 'rotation'   => 0,)
					);
				} else if ($x == 'G') {
					$objPHPExcel->getActiveSheet()->getStyle($x . $baris)->getAlignment()->applyFromArray(
						array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT, 'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER, 'rotation'   => 0,)
					);
				} else if ($x == 'H') {
					$objPHPExcel->getActiveSheet()->getStyle($x . $baris)->getAlignment()->applyFromArray(
						array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT, 'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER, 'rotation'   => 0,)
					);
				} else if ($x == 'I') {
					$objPHPExcel->getActiveSheet()->getStyle($x . $baris)->getAlignment()->applyFromArray(
						array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT, 'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER, 'rotation'   => 0,)
					);
				} else if ($x == 'J') {
					$objPHPExcel->getActiveSheet()->getStyle($x . $baris)->getAlignment()->applyFromArray(
						array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT, 'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER, 'rotation'   => 0,)
					);
				} else if ($x == 'K') {
					$objPHPExcel->getActiveSheet()->getStyle($x . $baris)->getAlignment()->applyFromArray(
						array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT, 'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER, 'rotation'   => 0,)
					);
				} else if ($x == 'L') {
					$objPHPExcel->getActiveSheet()->getStyle($x . $baris)->getAlignment()->applyFromArray(
						array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT, 'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER, 'rotation'   => 0,)
					);
				} else if ($x == 'M') {
					$objPHPExcel->getActiveSheet()->getStyle($x . $baris)->getAlignment()->applyFromArray(
						array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT, 'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER, 'rotation'   => 0,)
					);
				}
				$objPHPExcel->getActiveSheet()->getStyle($x . $baris)->applyFromArray(array(
					'font'    => array(
						'name'      => 'calibri',
						'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
						'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
						'size'		=> 10 /*untuk ukuran tulisan yg hasil query bwt yg di dlm tabel*/,
						'color'     => array('rgb' => '000000')
					),
					'borders' => array(
						'bottom'     => array(
							'style' => PHPExcel_Style_Border::BORDER_THIN,
							'color' => array('rgb' => '000000')
						),
						'top'     => array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('rgb' => '000000')),
						'left'     => array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('rgb' => '000000')),
						'right'     => array(
							'style' => PHPExcel_Style_Border::BORDER_THIN,
							'color' => array('rgb' => '000000')
						)
					)
				));
			}
			$objPHPExcel->getActiveSheet()->setCellValue('A' . $baris, $nomor);
			$objPHPExcel->getActiveSheet()->setCellValue('B' . $baris, $item['nama_obat']);
			$objPHPExcel->getActiveSheet()->setCellValue('C' . $baris, number_format($item['saldo_awal'], 2, '.', ',')); 	/*$sldawl=$item['saldo_awal'];
			$objPHPExcel->getActiveSheet()->setCellValue ('E'.$baris,number_format($item['harga_beli'])); 	$hrg=$item['harga_beli'];	$totalawal=$sldawl*$hrg;
			$objPHPExcel->getActiveSheet()->setCellValue ('F'.$baris,number_format($totalawal));*/
			$objPHPExcel->getActiveSheet()->setCellValue('D' . $baris, number_format($item['in_pbf'], 2, '.', ','));
			$pbf = $item['in_pbf'];
			$objPHPExcel->getActiveSheet()->setCellValue('E' . $baris, number_format($item['in_unit'], 2, '.', ','));
			$inunit = $item['in_unit'];
			$objPHPExcel->getActiveSheet()->setCellValue('F' . $baris, number_format($item['retur_jual'], 2, '.', ','));
			$retkeluar = $item['retur_jual'];
			$jml = $pbf + $inunit + $retkeluar; //$retpbf=$item['retur_pbf'];$jml=($pbf+$inunit)-$retpbf;
			$objPHPExcel->getActiveSheet()->setCellValue('G' . $baris, number_format($jml, 2, '.', ','));					/*$totalmasuk=$hrg*$jml;
			$objPHPExcel->getActiveSheet()->setCellValue ('K'.$baris,number_format($totalmasuk));*/
			$objPHPExcel->getActiveSheet()->setCellValue('H' . $baris, number_format($item['out_jual'], 2, '.', ','));
			$resep = $item['out_jual'];
			$objPHPExcel->getActiveSheet()->setCellValue('I' . $baris, number_format($item['out_unit'], 2, '.', ','));
			$outunit = $item['out_unit'];
			$retpbf = $item['retur_pbf']; //$retkeluar=0;
			$objPHPExcel->getActiveSheet()->setCellValue('J' . $baris, number_format($retpbf, 2, '.', ','));
			$jml1 = $resep + $outunit + $retpbf;
			$objPHPExcel->getActiveSheet()->setCellValue('K' . $baris, number_format($jml1, 2, '.', ',')); 				/*$totalkeluar=$hrg*$jml1;
			$objPHPExcel->getActiveSheet()->setCellValue ('P'.$baris,number_format($totalkeluar));*/
			$objPHPExcel->getActiveSheet()->setCellValue('L' . $baris, number_format($item['stok_opname'], 2, '.', ','));
			$objPHPExcel->getActiveSheet()->setCellValue('M' . $baris, number_format($item['saldo_akhir'], 2, '.', ',')); 	/*$saldoakhir=$item['saldo_akhir']; $totalakhir=$hrg*$saldoakhir;
			$objPHPExcel->getActiveSheet()->setCellValue ('S'.$baris,number_format($totalakhir));*/
			$nomor = $nomor + 1;
			$baris = $baris + 1;
			//$sumtotalawal=$sumtotalawal+$totalawal; $sumtotalmasuk=$sumtotalmasuk+$totalmasuk; $sumtotalkeluar=$sumtotalkeluar+$totalkeluar; $sumtotalakhir=$sumtotalakhir+$totalakhir; 
		}
		$objWriter = IOFactory::createWriter($objPHPExcel, 'Excel5');
		$objWriter->save("download/mutasiobat.xls");
		header("Location: " . base_url() . "download/mutasiobat.xls");
	}

	public function aliranbarang()
	{
		if (!$this->muser->isAkses("79")) {
			$this->restricted();
			return false;
		}
		$periodeawal = date('d-m-Y');
		$periodeakhir = date('d-m-Y');
		$limit = 20;
		$mode = 1; // 1: fastmoving, 2: slowmoving


		$nama_unit_apt = $this->input->post('nama_unit_apt');
		$kd_unit_apt = '';

		if ($this->input->post('periodeawal') != '') {
			$periodeawal = $this->input->post('periodeawal');
		}
		if ($this->input->post('periodeakhir') != '') {
			$periodeakhir = $this->input->post('periodeakhir');
		}
		if ($this->input->post('kd_unit_apt') != '') {
			$kd_unit_apt = $this->input->post('kd_unit_apt');
		}
		if ($this->input->post('limit') != '') {
			$limit = $this->input->post('limit');
		}
		if ($this->input->post('mode')) {
			$mode = (int)$this->input->post('mode');
		}

		$cssfileheader = array('bootstrap.css', 'bootstrap-responsive.min.css', 'font-awesome.min.css', 'style.css', 'prettify.css', 'jquery-ui.css', 'DT_bootstrap.css', 'responsive-tables.css', 'datepicker.css', 'theme.css');
		$jsfileheader = array(
			'vendor/modernizr-2.6.2-respond-1.1.0.min.js',
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
			'lib/bootstrap-modal.js',
			'spin.js',
			'main.js'
		);
		$dataheader = array(
			'jsfile' => $jsfileheader,
			'cssfile' => $cssfileheader,
			'title' => $this->title
		);

		$jsfooter = array();
		$datafooter = array(
			'jsfile' => $jsfooter
		);

		$items = array();

		if ($mode == 1) {
			$items = $this->mlaporanapt->getFastMoving($periodeawal, $periodeakhir, $limit, $kd_unit_apt);
		} elseif ($mode == 2) {
			$items = $this->mlaporanapt->getSlowMoving($periodeawal, $periodeakhir, $limit, $kd_unit_apt);
		}

		$data = array(
			'sumberdana' => $this->mlaporanapt->sumberdana(),
			'items' => $items,
			'periodeawal' => $periodeawal,
			'periodeakhir' => $periodeakhir,
			'kd_unit_apt' => $kd_unit_apt,
			'limit' => $limit,
			'mode' => $mode,
			'modedropdown' => array(
				array('val' => 1, 'label' => 'Fast Moving'),
				array('val' => 2, 'label' => 'Slow Moving'),
			),
		);

		$this->load->view('headerapotek', $dataheader);
		$this->load->view('laporanapotek/aliranbarang', $data);
		$this->load->view('footer', $datafooter);
	}

	public function obatexpire()
	{
		if (!$this->muser->isAkses("79")) {
			$this->restricted();
			return false;
		}
		$periodeawal = date('d-m-Y');
		$periodeakhir = date('d-m-Y');
		$status = ''; // 1: fastmoving, 2: slowmoving


		$nama_unit_apt = $this->input->post('nama_unit_apt');
		$kd_unit_apt = '';

		if ($this->input->post('periodeawal') != '') {
			$periodeawal = $this->input->post('periodeawal');
		}
		if ($this->input->post('periodeakhir') != '') {
			$periodeakhir = $this->input->post('periodeakhir');
		}
		if ($this->input->post('kd_unit_apt') != '') {
			$kd_unit_apt = $this->input->post('kd_unit_apt');
		}
		if ($this->input->post('status')) {
			$status = (int)$this->input->post('status');
		}

		$cssfileheader = array('bootstrap.css', 'bootstrap-responsive.min.css', 'font-awesome.min.css', 'style.css', 'prettify.css', 'jquery-ui.css', 'DT_bootstrap.css', 'responsive-tables.css', 'datepicker.css', 'theme.css');
		$jsfileheader = array(
			'vendor/modernizr-2.6.2-respond-1.1.0.min.js',
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
			'lib/bootstrap-modal.js',
			'spin.js',
			'main.js'
		);
		$dataheader = array(
			'jsfile' => $jsfileheader,
			'cssfile' => $cssfileheader,
			'title' => $this->title
		);

		$jsfooter = array();
		$datafooter = array(
			'jsfile' => $jsfooter
		);

		$items = array();

		$data = array(
			'sumberdana' => $this->mlaporanapt->sumberdana(),
			'items' => $this->mlaporanapt->getObatDisposal($periodeawal, $periodeakhir, $kd_unit_apt, $status),
			'periodeawal' => $periodeawal,
			'periodeakhir' => $periodeakhir,
			'kd_unit_apt' => $kd_unit_apt,
			'status' => $status
		);

		$this->load->view('headerapotek', $dataheader);
		$this->load->view('laporanapotek/obatexpire', $data);
		$this->load->view('footer', $datafooter);
	}

	public function rl1excelaliranbarang($periodeawal, $periodeakhir, $limit, $kd_unit_apt, $mode)
	{
		if ($kd_unit_apt == 'null') {
			$kd_unit_apt = null;
		}
		$this->load->library('phpexcel');
		$this->load->library('PHPExcel/iofactory');
		$objPHPExcel = new PHPExcel();
		$sheet = $objPHPExcel->getActiveSheet();


		// set columns width : 134 total
		$sheet->getColumnDimension('A')->setWidth(5); // no
		$sheet->getColumnDimension('B')->setWidth(20); // kode obat
		$sheet->getColumnDimension('C')->setWidth(40); // nama obat
		$sheet->getColumnDimension('D')->setWidth(10); // satuan kecil
		$sheet->getColumnDimension('E')->setWidth(15); // jumlah

		//merge cells for title and description
		for ($i = 2; $i <= 8; $i++) {
			$sheet->mergeCells('A' . $i . ':E' . $i);
		}

		// cells alignment config for title and description
		$sheet->getStyle('A2:E4')->getAlignment()->applyFromArray(array(
			'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
			'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
			'rotation' => 0,
		));
		$sheet->getStyle('A6:E8')->getAlignment()->applyFromArray(array(
			'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
			'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
			'rotation' => 0,
		));

		// print title and description
		$profil = $this->mlaporanapt->ambilItemData('profil');

		$sheet->setCellValue('A2', '');
		$sheet->setCellValue('A3', $profil['nama_profil']);
		$sheet->setCellValue('A4', 'KOTA BONTANG');

		// change
		$title = '';
		if ($mode == 1) {
			$title = 'LAPORAN FAST MOVING';
		} elseif ($mode == 2) {
			$title = 'LAPORAN SLOW MOVING';
		}
		$sheet->setCellValue('A6', $title);
		$sheet->setCellValue('A7', 'PERIODE ' . $periodeawal .  ' s.d. ' . $periodeakhir);
		$sheet->setCellValue('A8', $kd_unit_apt ? $this->mlaporanapt->namaUnit($kd_unit_apt) : ' SEMUA UNIT');

		// set styles for table
		$styleArray = array(
			'font' => array(
				'bold' => true,
				'name' => 'calibri',
				'size' => 11,
			),
			'alignment' => array(
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
				'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
			),
			'borders' => array(
				'allborders' => array(
					'style' => PHPExcel_Style_Border::BORDER_THIN,
					'color' => array('rgb' => '000000')
				),
			),
		);

		// set the heading style and values
		$sheet->getStyle('A10:E10')->applyFromArray($styleArray);

		$sheet->setCellValue('A10', 'NO.');
		$sheet->setCellValue('B10', 'KODE OBAT');
		$sheet->setCellValue('C10', 'NAMA OBAT');
		$sheet->setCellValue('D10', 'SATUAN KECIL');
		$sheet->setCellValue('E10', 'JUMLAH');

		// datacells value
		$items = null;
		if ($mode == 1) {
			$items = $this->mlaporanapt->getFastMoving($periodeawal, $periodeakhir, $limit, $kd_unit_apt);
		} elseif ($mode == 2) {
			$items = $this->mlaporanapt->getSlowMoving($periodeawal, $periodeakhir, $limit, $kd_unit_apt);
		}

		$rowOffset = 10;
		$counter = 0;

		$styleArray['font']['bold'] = false;
		foreach ($items as $item) {
			$rowCellNum = ++$counter + $rowOffset;
			$styleArray['alignment']['horizontal'] = PHPExcel_Style_Alignment::HORIZONTAL_RIGHT;
			$sheet->getStyle('A' . $rowCellNum)->applyFromArray($styleArray);
			$sheet->setCellValue('A' . $rowCellNum, $counter); 					// col 1: no

			$styleArray['alignment']['horizontal'] = PHPExcel_Style_Alignment::HORIZONTAL_CENTER;
			$sheet->getStyle('B' . $rowCellNum)->applyFromArray($styleArray);
			$sheet->setCellValue('B' . $rowCellNum, $item['kd_obat']); 			// col 2: kode obat

			$styleArray['alignment']['horizontal'] = PHPExcel_Style_Alignment::HORIZONTAL_LEFT;
			$sheet->getStyle('C' . $rowCellNum)->applyFromArray($styleArray);
			$sheet->setCellValue('C' . $rowCellNum, $item['nama_obat']);		// col 3: nama obat

			$styleArray['alignment']['horizontal'] = PHPExcel_Style_Alignment::HORIZONTAL_CENTER;
			$sheet->getStyle('D' . $rowCellNum)->applyFromArray($styleArray);
			$sheet->getStyle('E' . $rowCellNum)->applyFromArray($styleArray);
			$sheet->setCellValue('D' . $rowCellNum, $item['satuan_kecil']);		// col 4: satuan_kecil
			$sheet->setCellValue('E' . $rowCellNum, trim(number_format($item['jumlah'], 0, '.', ',')));			// col 5: jumlah
		}

		// export to file			
		$objWriter = IOFactory::createWriter($objPHPExcel, 'Excel5');
		if ($mode == 1) {
			$objWriter->save("download/fastmoving.xls");
			header("Location: " . base_url() . "download/fastmoving.xls");
		} elseif ($mode == 2) {
			$objWriter->save("download/slowmoving.xls");
			header("Location: " . base_url() . "download/slowmoving.xls");
		}
	}

	public function rl1excelobatexpire($periodeawal, $periodeakhir, $kd_unit_apt, $status)
	{
		if ($kd_unit_apt == 'null') {
			$kd_unit_apt = null;
		}
		$this->load->library('phpexcel');
		$this->load->library('PHPExcel/iofactory');
		$objPHPExcel = new PHPExcel();
		$sheet = $objPHPExcel->getActiveSheet();


		// set columns width : 134 total
		$sheet->getColumnDimension('A')->setWidth(5); // no
		$sheet->getColumnDimension('B')->setWidth(20); // kode obat
		$sheet->getColumnDimension('C')->setWidth(20); // nama obat
		$sheet->getColumnDimension('D')->setWidth(40); // satuan kecil
		$sheet->getColumnDimension('E')->setWidth(12); // jumlah
		$sheet->getColumnDimension('F')->setWidth(12); // jumlah
		$sheet->getColumnDimension('G')->setWidth(12); // jumlah
		$sheet->getColumnDimension('H')->setWidth(12); // jumlah
		$sheet->getColumnDimension('I')->setWidth(30); // jumlah

		//merge cells for title and description
		for ($i = 2; $i <= 8; $i++) {
			$sheet->mergeCells('A' . $i . ':I' . $i);
		}

		// cells alignment config for title and description
		$sheet->getStyle('A2:I4')->getAlignment()->applyFromArray(array(
			'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
			'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
			'rotation' => 0,
		));
		$sheet->getStyle('A6:I8')->getAlignment()->applyFromArray(array(
			'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
			'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
			'rotation' => 0,
		));

		// print title and description
		$profil = $this->mlaporanapt->ambilItemData('profil');

		$sheet->setCellValue('A2', '');
		$sheet->setCellValue('A3', $profil['nama_profil']);
		$sheet->setCellValue('A4', 'KOTA BONTANG');

		// change
		$title = 'LAPORAN OBAT EXPIRE/RUSAK';
		$sheet->setCellValue('A6', $title);
		$sheet->setCellValue('A7', 'PERIODE ' . $periodeawal .  ' s.d. ' . $periodeakhir);
		$sheet->setCellValue('A8', $kd_unit_apt ? $this->mlaporanapt->namaUnit($kd_unit_apt) : ' SEMUA UNIT');

		// set styles for table
		$styleArray = array(
			'font' => array(
				'bold' => true,
				'name' => 'calibri',
				'size' => 11,
			),
			'alignment' => array(
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
				'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
			),
			'borders' => array(
				'allborders' => array(
					'style' => PHPExcel_Style_Border::BORDER_THIN,
					'color' => array('rgb' => '000000')
				),
			),
		);

		// set the heading style and values
		$sheet->getStyle('A10:I10')->applyFromArray($styleArray);

		$sheet->setCellValue('A10', 'NO.');
		$sheet->setCellValue('B10', 'SUMBER DANA');
		$sheet->setCellValue('C10', 'KODE OBAT');
		$sheet->setCellValue('D10', 'NAMA OBAT');
		$sheet->setCellValue('E10', 'SATUAN');
		$sheet->setCellValue('F10', 'JUMLAOTH');
		$sheet->setCellValue('G10', 'HARGA');
		$sheet->setCellValue('H10', 'TOTAL');
		$sheet->setCellValue('I10', 'KET');

		// datacells value
		$items = null;
		$items = $this->mlaporanapt->getObatDisposal($periodeawal, $periodeakhir, $kd_unit_apt, $status);

		$rowOffset = 10;
		$counter = 0;

		$styleArray['font']['bold'] = false;
		$harga = 0;
		foreach ($items as $item) {
			$rowCellNum = ++$counter + $rowOffset;
			$styleArray['alignment']['horizontal'] = PHPExcel_Style_Alignment::HORIZONTAL_RIGHT;
			$sheet->getStyle('A' . $rowCellNum)->applyFromArray($styleArray);
			$sheet->setCellValue('A' . $rowCellNum, $counter); 					// col 1: no

			$styleArray['alignment']['horizontal'] = PHPExcel_Style_Alignment::HORIZONTAL_CENTER;
			$sheet->getStyle('B' . $rowCellNum)->applyFromArray($styleArray);
			$sheet->setCellValue('B' . $rowCellNum, $item['nama_unit_apt']); 			// col 2: kode obat

			$styleArray['alignment']['horizontal'] = PHPExcel_Style_Alignment::HORIZONTAL_CENTER;
			$sheet->getStyle('C' . $rowCellNum)->applyFromArray($styleArray);
			$sheet->setCellValue('C' . $rowCellNum, $item['kd_obat']); 			// col 2: kode obat

			$styleArray['alignment']['horizontal'] = PHPExcel_Style_Alignment::HORIZONTAL_LEFT;
			$sheet->getStyle('D' . $rowCellNum)->applyFromArray($styleArray);
			$sheet->setCellValue('D' . $rowCellNum, $item['nama_obat']);		// col 3: nama obat

			$styleArray['alignment']['horizontal'] = PHPExcel_Style_Alignment::HORIZONTAL_CENTER;
			$sheet->getStyle('E' . $rowCellNum)->applyFromArray($styleArray);
			$sheet->getStyle('F' . $rowCellNum)->applyFromArray($styleArray);
			$sheet->setCellValue('E' . $rowCellNum, $item['satuan_kecil']);		// col 4: satuan_kecil
			$sheet->setCellValue('F' . $rowCellNum, trim(number_format($item['jumlah'], 0, '.', ',')));			// col 5: jumlah

			$styleArray['alignment']['horizontal'] = PHPExcel_Style_Alignment::HORIZONTAL_RIGHT;
			$sheet->getStyle('G' . $rowCellNum)->applyFromArray($styleArray);
			if ($item['kd_unit_apt'] == 'D02') {
				$sheet->setCellValue('G' . $rowCellNum, trim(number_format($item['harga_apbd'], 0, '.', ',')));
				$harga = $item['harga_apbd'];
			}
			if ($item['kd_unit_apt'] == 'D03') {
				$sheet->setCellValue('G' . $rowCellNum, trim(number_format($item['harga_p3k'], 0, '.', ',')));
				$harga = $item['harga_p3k'];
			}
			if ($item['kd_unit_apt'] == 'D04') {
				$sheet->setCellValue('G' . $rowCellNum, trim(number_format($item['harga_buffer'], 0, '.', ',')));
				$harga = $item['harga_buffer'];
			}
			if ($item['kd_unit_apt'] == 'apb') {
				$sheet->setCellValue('G' . $rowCellNum, trim(number_format($item['harga_dak'], 0, '.', ',')));
				$harga = $item['harga_dak'];
			}
			if ($item['kd_unit_apt'] == 'U02') {
				$sheet->setCellValue('G' . $rowCellNum, trim(number_format($item['harga_program'], 0, '.', ',')));
				$harga = $item['harga_program'];
			}

			$styleArray['alignment']['horizontal'] = PHPExcel_Style_Alignment::HORIZONTAL_RIGHT;
			$sheet->getStyle('H' . $rowCellNum)->applyFromArray($styleArray);
			$sheet->setCellValue('H' . $rowCellNum, trim(number_format($item['jumlah'] * $harga, 0, '.', ',')));

			$styleArray['alignment']['horizontal'] = PHPExcel_Style_Alignment::HORIZONTAL_LEFT;
			$sheet->getStyle('I' . $rowCellNum)->applyFromArray($styleArray);
			$sheet->setCellValue('I' . $rowCellNum, $item['keterangan']);
		}

		// export to file			
		$objWriter = IOFactory::createWriter($objPHPExcel, 'Excel5');
		$objWriter->save("download/obatexirerusak.xls");
		header("Location: " . base_url() . "download/obatexirerusak.xls");
	}

	public function excellplpogolonganbulanan($bulan = "", $bulansatu = "", $tahun = "", $kd_golongan = "")
	{
		//if($kd_unit_apt=="NULL")$kd_unit_apt="";
		$this->load->library('phpexcel');
		$this->load->library('PHPExcel/iofactory');
		//$objPHPExcel = new PHPExcel(); 
		$objPHPExcel = IOFactory::load("./template/lapgolonganbulanan.xls");
		$objPHPExcel->getProperties()->setTitle("title")->setDescription("description");
		$items = array();
		$items = $this->mlaporanapt->getMutasiObatGolonganBulanan('', $bulan, $bulansatu, $tahun, $kd_golongan);
		//debugvar($kd_unit_apt);
		$baris = 9;
		$nomor = 1;

		$jum_bulan = ($bulan1 - $bulan) + 1;
		foreach ($items as $item) {


			for ($x = 'A'; $x <= 'Y'; $x++) {
				$objPHPExcel->getActiveSheet()->getStyle($x . $baris)->applyFromArray(array(
					'font'    => array(
						'name'      => 'calibri',
						'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
						'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
						'size'		=> 11 /*untuk ukuran tulisan yg hasil query bwt yg di dlm tabel*/,
						'color'     => array('rgb' => '000000')
					),
					'borders' => array(
						'bottom'     => array(
							'style' => PHPExcel_Style_Border::BORDER_THIN,
							'color' => array('rgb' => '000000')
						),
						'top'     => array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('rgb' => '000000')),
						'left'     => array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('rgb' => '000000')),
						'right'     => array(
							'style' => PHPExcel_Style_Border::BORDER_THIN,
							'color' => array('rgb' => '000000')
						)
					)
				));
			}

			$objPHPExcel->getActiveSheet()->getStyle('Z' . $baris)->applyFromArray(array(
				'font'    => array(
					'name'      => 'calibri',
					'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
					'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
					'size'		=> 11 /*untuk ukuran tulisan yg hasil query bwt yg di dlm tabel*/,
					'color'     => array('rgb' => '000000')
				),
				'borders' => array(
					'bottom'     => array(
						'style' => PHPExcel_Style_Border::BORDER_THIN,
						'color' => array('rgb' => '000000')
					),
					'top'     => array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('rgb' => '000000')),
					'left'     => array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('rgb' => '000000')),
					'right'     => array(
						'style' => PHPExcel_Style_Border::BORDER_THIN,
						'color' => array('rgb' => '000000')
					)
				)
			));

			$objPHPExcel->getActiveSheet()->getStyle('AA' . $baris)->applyFromArray(array(
				'font'    => array(
					'name'      => 'calibri',
					'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
					'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
					'size'		=> 11 /*untuk ukuran tulisan yg hasil query bwt yg di dlm tabel*/,
					'color'     => array('rgb' => '000000')
				),
				'borders' => array(
					'bottom'     => array(
						'style' => PHPExcel_Style_Border::BORDER_THIN,
						'color' => array('rgb' => '000000')
					),
					'top'     => array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('rgb' => '000000')),
					'left'     => array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('rgb' => '000000')),
					'right'     => array(
						'style' => PHPExcel_Style_Border::BORDER_THIN,
						'color' => array('rgb' => '000000')
					)
				)
			));

			$objPHPExcel->getActiveSheet()->getStyle('AB' . $baris)->applyFromArray(array(
				'font'    => array(
					'name'      => 'calibri',
					'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
					'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
					'size'		=> 11 /*untuk ukuran tulisan yg hasil query bwt yg di dlm tabel*/,
					'color'     => array('rgb' => '000000')
				),
				'borders' => array(
					'bottom'     => array(
						'style' => PHPExcel_Style_Border::BORDER_THIN,
						'color' => array('rgb' => '000000')
					),
					'top'     => array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('rgb' => '000000')),
					'left'     => array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('rgb' => '000000')),
					'right'     => array(
						'style' => PHPExcel_Style_Border::BORDER_THIN,
						'color' => array('rgb' => '000000')
					)
				)
			));

			$objPHPExcel->getActiveSheet()->getStyle('AC' . $baris)->applyFromArray(array(
				'font'    => array(
					'name'      => 'calibri',
					'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
					'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
					'size'		=> 11 /*untuk ukuran tulisan yg hasil query bwt yg di dlm tabel*/,
					'color'     => array('rgb' => '000000')
				),
				'borders' => array(
					'bottom'     => array(
						'style' => PHPExcel_Style_Border::BORDER_THIN,
						'color' => array('rgb' => '000000')
					),
					'top'     => array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('rgb' => '000000')),
					'left'     => array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('rgb' => '000000')),
					'right'     => array(
						'style' => PHPExcel_Style_Border::BORDER_THIN,
						'color' => array('rgb' => '000000')
					)
				)
			));

			$objPHPExcel->getActiveSheet()->getStyle('AD' . $baris)->applyFromArray(array(
				'font'    => array(
					'name'      => 'calibri',
					'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
					'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
					'size'		=> 11 /*untuk ukuran tulisan yg hasil query bwt yg di dlm tabel*/,
					'color'     => array('rgb' => '000000')
				),
				'borders' => array(
					'bottom'     => array(
						'style' => PHPExcel_Style_Border::BORDER_THIN,
						'color' => array('rgb' => '000000')
					),
					'top'     => array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('rgb' => '000000')),
					'left'     => array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('rgb' => '000000')),
					'right'     => array(
						'style' => PHPExcel_Style_Border::BORDER_THIN,
						'color' => array('rgb' => '000000')
					)
				)
			));

			$objPHPExcel->getActiveSheet()->getStyle('AE' . $baris)->applyFromArray(array(
				'font'    => array(
					'name'      => 'calibri',
					'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
					'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
					'size'		=> 11 /*untuk ukuran tulisan yg hasil query bwt yg di dlm tabel*/,
					'color'     => array('rgb' => '000000')
				),
				'borders' => array(
					'bottom'     => array(
						'style' => PHPExcel_Style_Border::BORDER_THIN,
						'color' => array('rgb' => '000000')
					),
					'top'     => array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('rgb' => '000000')),
					'left'     => array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('rgb' => '000000')),
					'right'     => array(
						'style' => PHPExcel_Style_Border::BORDER_THIN,
						'color' => array('rgb' => '000000')
					)
				)
			));

			$objPHPExcel->getActiveSheet()->getStyle('AF' . $baris)->applyFromArray(array(
				'font'    => array(
					'name'      => 'calibri',
					'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
					'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
					'size'		=> 11 /*untuk ukuran tulisan yg hasil query bwt yg di dlm tabel*/,
					'color'     => array('rgb' => '000000')
				),
				'borders' => array(
					'bottom'     => array(
						'style' => PHPExcel_Style_Border::BORDER_THIN,
						'color' => array('rgb' => '000000')
					),
					'top'     => array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('rgb' => '000000')),
					'left'     => array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('rgb' => '000000')),
					'right'     => array(
						'style' => PHPExcel_Style_Border::BORDER_THIN,
						'color' => array('rgb' => '000000')
					)
				)
			));

			//debugvar($item);
			if ($item['stok_opname_apbn'] > 0) $item['jum_masuk_apbn'] = $item['jum_masuk_apbn'] + $item['stok_opname_apbn'];
			else $item['jum_keluar_apbn'] = $item['jum_keluar_apbn'] + $item['stok_opname_apbn'];

			if ($item['stok_opname_lain'] > 0) $item['jum_masuk_lain'] = $item['jum_masuk_lain'] + $item['stok_opname_lain'];
			else $item['jum_keluar_lain'] = $item['jum_keluar_lain'] + $item['stok_opname_lain'];

			if ($item['stok_opname_program'] > 0) $item['jum_masuk_program'] = $item['jum_masuk_program'] + $item['stok_opname_program'];
			else $item['jum_keluar_program'] = $item['jum_keluar_program'] + $item['stok_opname_program'];

			if ($item['stok_opname_apbd1'] > 0) $item['jum_masuk_apbd1'] = $item['jum_masuk_apbd1'] + $item['stok_opname_apbd1'];
			else $item['jum_keluar_apbd1'] = $item['jum_keluar_apbd1'] + $item['stok_opname_apbd1'];

			if ($item['stok_opname_apbd2'] > 0) $item['jum_masuk_apbd2'] = $item['jum_masuk_apbd2'] + $item['stok_opname_apbd2'];
			else $item['jum_keluar_apbd2'] = $item['jum_keluar_apbd2'] + $item['stok_opname_apbd2'];

			//$persediaan=0;
			//$persediaan=	$item['saldo_awal'] + $item['jum_masuk'];
			$opt = 0;
			$item['total_jum_keluar'] = $item['jum_keluar_apbn'] + $item['jum_keluar_program'] + $item['jum_keluar_apbd1'] + $item['jum_keluar_apbd2'] + $item['jum_keluar_program'];
			$item['total_saldo_akhir'] = $item['saldo_akhir_apbn'] + $item['saldo_akhir_program'] + $item['saldo_akhir_apbd1'] + $item['saldo_akhir_apbd2'] + $item['saldo_akhir_program'];
			$opt = $item['total_saldo_akhir'] + $item['total_jum_keluar'] + ($item['total_jum_keluar'] * 20 / 100);
			//$total=0;
			//$total=$item['total_saldo_akhir']*$item['harga_beli'];

			if ($item['total_jum_keluar'] != 0) $item['rata_pemakaian'] = $item['total_jum_keluar'] / $jum_bulan;
			else $item['rata_pemakaian'] = 0;
			$item['rata_pemakaian'] = round($item['rata_pemakaian'], 2);
			if ($item['rata_pemakaian'] != 0) {
				$item['kecukupan'] = $item['total_saldo_akhir'] / $item['rata_pemakaian'];
			} else {
				$item['kecukupan'] = 0;
			}
			$item['kecukupan'] = round($item['kecukupan'], 2);

			$objPHPExcel->getActiveSheet()->setCellValue('A' . $baris, $nomor);
			$objPHPExcel->getActiveSheet()->setCellValue('B' . $baris, $item['nama_obat']);
			$objPHPExcel->getActiveSheet()->setCellValue('C' . $baris, $item['satuan_kecil']);
			$objPHPExcel->getActiveSheet()->setCellValue('E' . $baris, number_format($item['saldo_awal_apbn'], 2, '.', ','));
			$objPHPExcel->getActiveSheet()->setCellValue('F' . $baris, number_format($item['saldo_awal_program'], 2, '.', ','));
			$objPHPExcel->getActiveSheet()->setCellValue('G' . $baris, number_format($item['saldo_awal_apbd1'], 2, '.', ','));
			$objPHPExcel->getActiveSheet()->setCellValue('H' . $baris, number_format($item['saldo_awal_apbd2'], 2, '.', ','));
			$objPHPExcel->getActiveSheet()->setCellValue('I' . $baris, number_format($item['saldo_awal_lain'], 2, '.', ','));
			$objPHPExcel->getActiveSheet()->setCellValue('J' . $baris, number_format($item['jum_masuk_apbn'], 2, '.', ','));
			$objPHPExcel->getActiveSheet()->setCellValue('K' . $baris, number_format($item['jum_masuk_program'], 2, '.', ','));
			$objPHPExcel->getActiveSheet()->setCellValue('L' . $baris, number_format($item['jum_masuk_apbd1'], 2, '.', ','));
			$objPHPExcel->getActiveSheet()->setCellValue('M' . $baris, number_format($item['jum_masuk_apbd2'], 2, '.', ','));
			$objPHPExcel->getActiveSheet()->setCellValue('N' . $baris, number_format($item['jum_masuk_lain'], 2, '.', ','));
			$objPHPExcel->getActiveSheet()->setCellValue('O' . $baris, number_format($item['pengeluaran_kpns'], 2, '.', ','));
			$objPHPExcel->getActiveSheet()->setCellValue('P' . $baris, number_format($item['pengeluaran_bs1'], 2, '.', ','));
			$objPHPExcel->getActiveSheet()->setCellValue('Q' . $baris, number_format($item['pengeluaran_bs2'], 2, '.', ','));
			$objPHPExcel->getActiveSheet()->setCellValue('R' . $baris, number_format($item['pengeluaran_bu1'], 2, '.', ','));
			$objPHPExcel->getActiveSheet()->setCellValue('S' . $baris, number_format($item['pengeluaran_bu2'], 2, '.', ','));
			$objPHPExcel->getActiveSheet()->setCellValue('T' . $baris, number_format($item['pengeluaran_bl'], 2, '.', ','));
			$objPHPExcel->getActiveSheet()->setCellValue('U' . $baris, number_format($item['pengeluaran_bb'], 2, '.', ','));
			$objPHPExcel->getActiveSheet()->setCellValue('V' . $baris, number_format($item['pengeluaran_lain'], 2, '.', ','));
			$objPHPExcel->getActiveSheet()->setCellValue('W' . $baris, number_format($item['saldo_akhir_apbn'], 2, '.', ','));
			$objPHPExcel->getActiveSheet()->setCellValue('X' . $baris, number_format($item['saldo_akhir_program'], 2, '.', ','));
			$objPHPExcel->getActiveSheet()->setCellValue('Y' . $baris, number_format($item['saldo_akhir_apbd1'], 2, '.', ','));
			$objPHPExcel->getActiveSheet()->setCellValue('Z' . $baris, number_format($item['saldo_akhir_apbd2'], 2, '.', ','));
			$objPHPExcel->getActiveSheet()->setCellValue('AA' . $baris, number_format($item['saldo_akhir_lain'], 2, '.', ','));
			$objPHPExcel->getActiveSheet()->setCellValue('AB' . $baris, number_format($item['total_saldo_akhir'], 2, '.', ','));
			$objPHPExcel->getActiveSheet()->setCellValue('AC' . $baris, number_format($item['rata_pemakaian'], 2, '.', ','));
			$objPHPExcel->getActiveSheet()->setCellValue('AD' . $baris, number_format($item['kecukupan'], 2, '.', ','));
			$nomor = $nomor + 1;
			$baris = $baris + 1;
		}
		$objWriter = IOFactory::createWriter($objPHPExcel, 'Excel5');
		$objWriter->save("download/lap_program_bulanan.xls");
		header("Location: " . base_url() . "download/lap_program_bulanan.xls");
	}

	public function excellplpobulanan($bulan = "", $bulansatu = "", $tahun = "", $kd_unit_apt = "")
	{
		if ($kd_unit_apt == "NULL") $kd_unit_apt = "";
		$this->load->library('phpexcel');
		$this->load->library('PHPExcel/iofactory');
		//$objPHPExcel = new PHPExcel(); 
		$objPHPExcel = IOFactory::load("./template/lapbulanan.xls");
		$objPHPExcel->getProperties()->setTitle("title")->setDescription("description");
		/*$objPHPExcel->getActiveSheet()->mergeCells('A2:M2');
		$objPHPExcel->getActiveSheet()->mergeCells('A3:M3');
		$objPHPExcel->getActiveSheet()->mergeCells('A4:M4');
		$objPHPExcel->getActiveSheet()->mergeCells('A6:M6');
		$objPHPExcel->getActiveSheet()->mergeCells('A7:M7');
		$objPHPExcel->getActiveSheet()->mergeCells('A8:M8');

		$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(0)->setWidth(4.14); //no
		$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(1)->setWidth(30.5); //nama obat
		$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(2)->setWidth(10); //satuan
		$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(3)->setWidth(10); //saldo awal
		$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(4)->setWidth(10); //penerimaan
		$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(5)->setWidth(10); //persediaan
		$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(6)->setWidth(10); //pemakaian
		$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(7)->setWidth(10); //sisa stok
		$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(8)->setWidth(10); //stok opt
		$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(9)->setWidth(10); //permintaan
		$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(10)->setWidth(10); //harga
		$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(11)->setWidth(10); //total
		*/

		/*for($x='A';$x<='J';$x++){ //bwt judul2nya
			$objPHPExcel->getActiveSheet()->getStyle($x.'2')->getAlignment()->applyFromArray(
				array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,'rotation'   => 0,));
		}	
		for($x='A';$x<='J';$x++){
			$objPHPExcel->getActiveSheet()->getStyle($x.'3')->getAlignment()->applyFromArray(
				array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,'rotation'   => 0,));
		}	
		for($x='A';$x<='J';$x++){
			$objPHPExcel->getActiveSheet()->getStyle($x.'4')->getAlignment()->applyFromArray(
				array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,'rotation'   => 0,));
		}	
		for($x='A';$x<='J';$x++){
			$objPHPExcel->getActiveSheet()->getStyle($x.'6')->getAlignment()->applyFromArray(
				array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,'rotation'   => 0,));
		}
		for($x='A';$x<='J';$x++){
			$objPHPExcel->getActiveSheet()->getStyle($x.'7')->getAlignment()->applyFromArray(
				array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,'rotation'   => 0,));
		}
		for($x='A';$x<='J';$x++){
			$objPHPExcel->getActiveSheet()->getStyle($x.'8')->getAlignment()->applyFromArray(
				array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,'rotation'   => 0,));
		}*/

		/*$profil=$this->mlaporanapt->ambilItemData('profil');		
		$objPHPExcel->getActiveSheet()->setCellValue ('A2','');
		$objPHPExcel->getActiveSheet()->setCellValue ('A3',$profil['nama_profil']);
		$objPHPExcel->getActiveSheet()->setCellValue ('A4','Kota BONTANG');		
		$objPHPExcel->getActiveSheet()->setCellValue ('A6','LAPORAN BULANAN');		
		$bulan1="";
		if($bulan=='01'){$bulan1='Januari';} 	 if($bulan=='02'){$bulan1='Februari';}	if($bulan=='03'){$bulan1='Maret';} 	  if($bulan=='04'){$bulan1='April';}
		if($bulan=='05'){$bulan1='Mei';} 		 if($bulan=='06'){$bulan1='Juni';} 		if($bulan=='07'){$bulan1='Juli';} 	  if($bulan=='08'){$bulan1='Agustus';}
		if($bulan=='09'){$bulan1='September';}   if($bulan=='10'){$bulan1='Oktober';}	if($bulan=='11'){$bulan1='November';} if($bulan=='12'){$bulan1='Desember';}

		$bulan2="";
		if($bulansatu=='01'){$bulan2='Januari';} 	 if($bulansatu=='02'){$bulan2='Februari';}	if($bulansatu=='03'){$bulan2='Maret';} 	  if($bulansatu=='04'){$bulan2='April';}
		if($bulansatu=='05'){$bulan2='Mei';} 		 if($bulansatu=='06'){$bulan2='Juni';} 		if($bulansatu=='07'){$bulan2='Juli';} 	  if($bulansatu=='08'){$bulan2='Agustus';}
		if($bulansatu=='09'){$bulan2='September';}   if($bulansatu=='10'){$bulan2='Oktober';}	if($bulansatu=='11'){$bulan2='November';} if($bulansatu=='12'){$bulan2='Desember';}
		$objPHPExcel->getActiveSheet()->setCellValue ('A7',$bulan1.' Sampai '.$bulan2.' '.$tahun);
		$namaunit=$this->mlaporanapt->namaUnit($kd_unit_apt);
		$objPHPExcel->getActiveSheet()->setCellValue ('A8',$namaunit);
		
		for($x='A';$x<='L';$x++){
			$objPHPExcel->getActiveSheet()->getStyle($x.'10')->getAlignment()->applyFromArray(
				array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,'rotation'   => 0,));
			$objPHPExcel->getActiveSheet()->getStyle($x.'11')->getAlignment()->applyFromArray(
				array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,'rotation'   => 0,));
		
			$objPHPExcel->getActiveSheet()->getStyle($x.'10')->applyFromArray(array('font'    => array('name'      => 'calibri','horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
																			'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,'size'		=>11 ,'color'     => array('rgb' => '000000')),
																			'borders' => array('bottom'     => array('style' => PHPExcel_Style_Border::BORDER_THIN,'color' => array('rgb' => '000000')),
																			'top'     => array('style' => PHPExcel_Style_Border::BORDER_THIN,'color' => array('rgb' => '000000')),
																			'left'     => array('style' => PHPExcel_Style_Border::BORDER_THIN,'color' => array('rgb' => '000000')),
																			'right'     => array('style' => PHPExcel_Style_Border::BORDER_THIN,'color' => array('rgb' => '000000')))));
			$objPHPExcel->getActiveSheet()->getStyle($x.'11')->applyFromArray(array('font'    => array('name'      => 'calibri','horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
																			'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,'size'		=>11 ,'color'     => array('rgb' => '000000')),
																			'borders' => array('bottom'     => array('style' => PHPExcel_Style_Border::BORDER_THIN,'color' => array('rgb' => '000000')),
																			'top'     => array('style' => PHPExcel_Style_Border::BORDER_THIN,'color' => array('rgb' => '000000')),
																			'left'     => array('style' => PHPExcel_Style_Border::BORDER_THIN,'color' => array('rgb' => '000000')),
																			'right'     => array('style' => PHPExcel_Style_Border::BORDER_THIN,'color' => array('rgb' => '000000')))));
		}		
		 	
		$objPHPExcel->getActiveSheet()->setCellValue ('A10','NO.');  
		$objPHPExcel->getActiveSheet()->setCellValue ('B10','NAMA OBAT');
		$objPHPExcel->getActiveSheet()->setCellValue ('C10','SATUAN');
		$objPHPExcel->getActiveSheet()->setCellValue ('D10','SALDO AWAL');
		$objPHPExcel->getActiveSheet()->setCellValue ('E10','PENERIMAAN');
		$objPHPExcel->getActiveSheet()->setCellValue ('F10','PERSEDIAAN');
		$objPHPExcel->getActiveSheet()->setCellValue ('G10','PEMAKAIAN');
		$objPHPExcel->getActiveSheet()->setCellValue ('H10','SISA STOK');
		$objPHPExcel->getActiveSheet()->setCellValue ('I10','RATA RATA PEMAKAIAN');
		$objPHPExcel->getActiveSheet()->setCellValue ('J10','KECUKUPAN BULAN');
		*/
		$items = array();
		$items = $this->mlaporanapt->getMutasiObatBulanan('', $bulan, $bulansatu, $tahun);
		//debugvar($kd_unit_apt);
		$baris = 9;
		$nomor = 1;

		$jum_bulan = ($bulansatu - $bulan) + 1;
		foreach ($items as $item) {


			for ($x = 'A'; $x <= 'Y'; $x++) {
				/*if($x=='A'){
					$objPHPExcel->getActiveSheet()->getStyle($x.$baris)->getAlignment()->applyFromArray(
						array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,'rotation'   => 0,));					
				}else if($x=='B'){
					$objPHPExcel->getActiveSheet()->getStyle($x.$baris)->getAlignment()->applyFromArray(
						array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,'rotation'   => 0,));										
				}else if($x=='C'){
					$objPHPExcel->getActiveSheet()->getStyle($x.$baris)->getAlignment()->applyFromArray(
						array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,'rotation'   => 0,));										
				}else if($x=='D'){
					$objPHPExcel->getActiveSheet()->getStyle($x.$baris)->getAlignment()->applyFromArray(
						array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,'rotation'   => 0,));										
				}else if($x=='E'){
					$objPHPExcel->getActiveSheet()->getStyle($x.$baris)->getAlignment()->applyFromArray(
						array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,'rotation'   => 0,));										
				}else if($x=='F'){
					$objPHPExcel->getActiveSheet()->getStyle($x.$baris)->getAlignment()->applyFromArray(
						array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,'rotation'   => 0,));										
				}else if($x=='G'){
					$objPHPExcel->getActiveSheet()->getStyle($x.$baris)->getAlignment()->applyFromArray(
						array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,'rotation'   => 0,));										
				}else if($x=='H'){
					$objPHPExcel->getActiveSheet()->getStyle($x.$baris)->getAlignment()->applyFromArray(
						array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,'rotation'   => 0,));										
				}else if($x=='I'){
					$objPHPExcel->getActiveSheet()->getStyle($x.$baris)->getAlignment()->applyFromArray(
						array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,'rotation'   => 0,));										
				}else if($x=='J'){
					$objPHPExcel->getActiveSheet()->getStyle($x.$baris)->getAlignment()->applyFromArray(
						array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,'rotation'   => 0,));										
				}*/
				$objPHPExcel->getActiveSheet()->getStyle($x . $baris)->applyFromArray(array(
					'font'    => array(
						'name'      => 'calibri',
						'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
						'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
						'size'		=> 11 /*untuk ukuran tulisan yg hasil query bwt yg di dlm tabel*/,
						'color'     => array('rgb' => '000000')
					),
					'borders' => array(
						'bottom'     => array(
							'style' => PHPExcel_Style_Border::BORDER_THIN,
							'color' => array('rgb' => '000000')
						),
						'top'     => array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('rgb' => '000000')),
						'left'     => array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('rgb' => '000000')),
						'right'     => array(
							'style' => PHPExcel_Style_Border::BORDER_THIN,
							'color' => array('rgb' => '000000')
						)
					)
				));
			}

			$objPHPExcel->getActiveSheet()->getStyle('Z' . $baris)->applyFromArray(array(
				'font'    => array(
					'name'      => 'calibri',
					'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
					'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
					'size'		=> 11 /*untuk ukuran tulisan yg hasil query bwt yg di dlm tabel*/,
					'color'     => array('rgb' => '000000')
				),
				'borders' => array(
					'bottom'     => array(
						'style' => PHPExcel_Style_Border::BORDER_THIN,
						'color' => array('rgb' => '000000')
					),
					'top'     => array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('rgb' => '000000')),
					'left'     => array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('rgb' => '000000')),
					'right'     => array(
						'style' => PHPExcel_Style_Border::BORDER_THIN,
						'color' => array('rgb' => '000000')
					)
				)
			));

			$objPHPExcel->getActiveSheet()->getStyle('AA' . $baris)->applyFromArray(array(
				'font'    => array(
					'name'      => 'calibri',
					'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
					'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
					'size'		=> 11 /*untuk ukuran tulisan yg hasil query bwt yg di dlm tabel*/,
					'color'     => array('rgb' => '000000')
				),
				'borders' => array(
					'bottom'     => array(
						'style' => PHPExcel_Style_Border::BORDER_THIN,
						'color' => array('rgb' => '000000')
					),
					'top'     => array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('rgb' => '000000')),
					'left'     => array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('rgb' => '000000')),
					'right'     => array(
						'style' => PHPExcel_Style_Border::BORDER_THIN,
						'color' => array('rgb' => '000000')
					)
				)
			));

			$objPHPExcel->getActiveSheet()->getStyle('AB' . $baris)->applyFromArray(array(
				'font'    => array(
					'name'      => 'calibri',
					'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
					'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
					'size'		=> 11 /*untuk ukuran tulisan yg hasil query bwt yg di dlm tabel*/,
					'color'     => array('rgb' => '000000')
				),
				'borders' => array(
					'bottom'     => array(
						'style' => PHPExcel_Style_Border::BORDER_THIN,
						'color' => array('rgb' => '000000')
					),
					'top'     => array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('rgb' => '000000')),
					'left'     => array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('rgb' => '000000')),
					'right'     => array(
						'style' => PHPExcel_Style_Border::BORDER_THIN,
						'color' => array('rgb' => '000000')
					)
				)
			));

			$objPHPExcel->getActiveSheet()->getStyle('AC' . $baris)->applyFromArray(array(
				'font'    => array(
					'name'      => 'calibri',
					'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
					'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
					'size'		=> 11 /*untuk ukuran tulisan yg hasil query bwt yg di dlm tabel*/,
					'color'     => array('rgb' => '000000')
				),
				'borders' => array(
					'bottom'     => array(
						'style' => PHPExcel_Style_Border::BORDER_THIN,
						'color' => array('rgb' => '000000')
					),
					'top'     => array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('rgb' => '000000')),
					'left'     => array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('rgb' => '000000')),
					'right'     => array(
						'style' => PHPExcel_Style_Border::BORDER_THIN,
						'color' => array('rgb' => '000000')
					)
				)
			));

			$objPHPExcel->getActiveSheet()->getStyle('AD' . $baris)->applyFromArray(array(
				'font'    => array(
					'name'      => 'calibri',
					'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
					'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
					'size'		=> 11 /*untuk ukuran tulisan yg hasil query bwt yg di dlm tabel*/,
					'color'     => array('rgb' => '000000')
				),
				'borders' => array(
					'bottom'     => array(
						'style' => PHPExcel_Style_Border::BORDER_THIN,
						'color' => array('rgb' => '000000')
					),
					'top'     => array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('rgb' => '000000')),
					'left'     => array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('rgb' => '000000')),
					'right'     => array(
						'style' => PHPExcel_Style_Border::BORDER_THIN,
						'color' => array('rgb' => '000000')
					)
				)
			));

			//debugvar($item);
			if ($item['stok_opname_apbn'] > 0) $item['jum_masuk_apbn'] = $item['jum_masuk_apbn'] + $item['stok_opname_apbn'];
			else $item['jum_keluar_apbn'] = $item['jum_keluar_apbn'] + $item['stok_opname_apbn'];

			if ($item['stok_opname_lain'] > 0) $item['jum_masuk_lain'] = $item['jum_masuk_lain'] + $item['stok_opname_lain'];
			else $item['jum_keluar_lain'] = $item['jum_keluar_lain'] + $item['stok_opname_lain'];

			if ($item['stok_opname_program'] > 0) $item['jum_masuk_program'] = $item['jum_masuk_program'] + $item['stok_opname_program'];
			else $item['jum_keluar_program'] = $item['jum_keluar_program'] + $item['stok_opname_program'];

			if ($item['stok_opname_apbd1'] > 0) $item['jum_masuk_apbd1'] = $item['jum_masuk_apbd1'] + $item['stok_opname_apbd1'];
			else $item['jum_keluar_apbd1'] = $item['jum_keluar_apbd1'] + $item['stok_opname_apbd1'];

			if ($item['stok_opname_apbd2'] > 0) $item['jum_masuk_apbd2'] = $item['jum_masuk_apbd2'] + $item['stok_opname_apbd2'];
			else $item['jum_keluar_apbd2'] = $item['jum_keluar_apbd2'] + $item['stok_opname_apbd2'];

			//$persediaan=0;
			//$persediaan=	$item['saldo_awal'] + $item['jum_masuk'];
			$opt = 0;
			$item['total_jum_keluar'] = $item['jum_keluar_apbn'] + $item['jum_keluar_program'] + $item['jum_keluar_apbd1'] + $item['jum_keluar_apbd2'] + $item['jum_keluar_program'];
			$item['total_saldo_akhir'] = $item['saldo_akhir_apbn'] + $item['saldo_akhir_program'] + $item['saldo_akhir_apbd1'] + $item['saldo_akhir_apbd2'] + $item['saldo_akhir_program'];
			$opt = $item['total_saldo_akhir'] + $item['total_jum_keluar'] + ($item['total_jum_keluar'] * 20 / 100);
			//$total=0;
			//$total=$item['total_saldo_akhir']*$item['harga_beli'];

			if ($item['total_jum_keluar'] != 0) $item['rata_pemakaian'] = $item['total_jum_keluar'] / $jum_bulan;
			else $item['rata_pemakaian'] = 0;
			$item['rata_pemakaian'] = round($item['rata_pemakaian'], 2);
			if ($item['rata_pemakaian'] != 0) {
				$item['kecukupan'] = $item['total_saldo_akhir'] / $item['rata_pemakaian'];
			} else {
				$item['kecukupan'] = 0;
			}
			$item['kecukupan'] = round($item['kecukupan'], 2);

			$objPHPExcel->getActiveSheet()->setCellValue('A' . $baris, $nomor);
			$objPHPExcel->getActiveSheet()->setCellValue('B' . $baris, $item['nama_obat']);
			$objPHPExcel->getActiveSheet()->setCellValue('C' . $baris, $item['satuan_kecil']);
			if ($item['kd_obat'] != '') $objPHPExcel->getActiveSheet()->setCellValue('E' . $baris, number_format($item['saldo_awal_apbn'], 2, '.', ','));
			if ($item['kd_obat'] != '') $objPHPExcel->getActiveSheet()->setCellValue('F' . $baris, number_format($item['saldo_awal_program'], 2, '.', ','));
			if ($item['kd_obat'] != '') $objPHPExcel->getActiveSheet()->setCellValue('G' . $baris, number_format($item['saldo_awal_apbd1'], 2, '.', ','));
			if ($item['kd_obat'] != '') $objPHPExcel->getActiveSheet()->setCellValue('H' . $baris, number_format($item['saldo_awal_apbd2'], 2, '.', ','));
			if ($item['kd_obat'] != '') $objPHPExcel->getActiveSheet()->setCellValue('I' . $baris, number_format($item['saldo_awal_lain'], 2, '.', ','));
			if ($item['kd_obat'] != '') $objPHPExcel->getActiveSheet()->setCellValue('J' . $baris, number_format($item['jum_masuk_apbn'], 2, '.', ','));
			if ($item['kd_obat'] != '') $objPHPExcel->getActiveSheet()->setCellValue('K' . $baris, number_format($item['jum_masuk_program'], 2, '.', ','));
			if ($item['kd_obat'] != '') $objPHPExcel->getActiveSheet()->setCellValue('L' . $baris, number_format($item['jum_masuk_apbd1'], 2, '.', ','));
			if ($item['kd_obat'] != '') $objPHPExcel->getActiveSheet()->setCellValue('M' . $baris, number_format($item['jum_masuk_apbd2'], 2, '.', ','));
			if ($item['kd_obat'] != '') $objPHPExcel->getActiveSheet()->setCellValue('N' . $baris, number_format($item['jum_masuk_lain'], 2, '.', ','));
			if ($item['kd_obat'] != '') $objPHPExcel->getActiveSheet()->setCellValue('O' . $baris, number_format($item['jum_keluar_apbn'], 2, '.', ','));
			if ($item['kd_obat'] != '') $objPHPExcel->getActiveSheet()->setCellValue('P' . $baris, number_format($item['jum_keluar_program'], 2, '.', ','));
			if ($item['kd_obat'] != '') $objPHPExcel->getActiveSheet()->setCellValue('Q' . $baris, number_format($item['jum_keluar_apbd1'], 2, '.', ','));
			if ($item['kd_obat'] != '') $objPHPExcel->getActiveSheet()->setCellValue('R' . $baris, number_format($item['jum_keluar_apbd2'], 2, '.', ','));
			if ($item['kd_obat'] != '') $objPHPExcel->getActiveSheet()->setCellValue('S' . $baris, number_format($item['jum_keluar_lain'], 2, '.', ','));
			if ($item['kd_obat'] != '') $objPHPExcel->getActiveSheet()->setCellValue('T' . $baris, number_format($item['total_jum_keluar'], 2, '.', ','));
			if ($item['kd_obat'] != '') $objPHPExcel->getActiveSheet()->setCellValue('U' . $baris, number_format($item['saldo_akhir_apbn'], 2, '.', ','));
			if ($item['kd_obat'] != '') $objPHPExcel->getActiveSheet()->setCellValue('V' . $baris, number_format($item['saldo_akhir_program'], 2, '.', ','));
			if ($item['kd_obat'] != '') $objPHPExcel->getActiveSheet()->setCellValue('W' . $baris, number_format($item['saldo_akhir_apbd1'], 2, '.', ','));
			if ($item['kd_obat'] != '') $objPHPExcel->getActiveSheet()->setCellValue('X' . $baris, number_format($item['saldo_akhir_apbd2'], 2, '.', ','));
			if ($item['kd_obat'] != '') $objPHPExcel->getActiveSheet()->setCellValue('Y' . $baris, number_format($item['saldo_akhir_lain'], 2, '.', ','));
			if ($item['kd_obat'] != '') $objPHPExcel->getActiveSheet()->setCellValue('Z' . $baris, number_format($item['total_saldo_akhir'], 2, '.', ','));
			if ($item['kd_obat'] != '') $objPHPExcel->getActiveSheet()->setCellValue('AA' . $baris, number_format($item['rata_pemakaian'], 2, '.', ','));
			if ($item['kd_obat'] != '') $objPHPExcel->getActiveSheet()->setCellValue('AB' . $baris, number_format($item['kecukupan'], 2, '.', ','));
			$nomor = $nomor + 1;
			$baris = $baris + 1;
		}
		$objWriter = IOFactory::createWriter($objPHPExcel, 'Excel5');
		$objWriter->save("download/bulanan.xls");
		header("Location: " . base_url() . "download/bulanan.xls");
	}

	public function excellplpobulanansas()
	{
		// if ($kd_unit_apt == "NULL") $kd_unit_apt = "";
		$this->load->library('phpexcel');
		$this->load->library('PHPExcel/iofactory');
		//$objPHPExcel = new PHPExcel(); 
		$objPHPExcel = IOFactory::load("./template/lappsikotropika.xls");
		$objPHPExcel->getProperties()->setTitle("title")->setDescription("description");
		$items = array();
		$items = $this->mlaporanapt->getMutasiObatSasBulanan2('12', 2024);
		//debugvar($kd_unit_apt);
		$baris = 9;
		$nomor = 1;
		$kdobat = "";
		$bl = array('01' => 'Januari', '02' => 'Februari', '03' => 'Maret', '04' => 'April', '05' => 'Mei', '06' => 'Juni', '07' => 'Juli', '08' => 'Agustus', '09' => 'September', '10' => 'Oktober', '11' => 'November', '12' => 'Desember');
		// $objPHPExcel->getActiveSheet()->setCellValue('S4', $bl[$bulan]);
		// $objPHPExcel->getActiveSheet()->setCellValue('S5', $tahun);
		foreach ($items as $item) {


			for ($x = 'A'; $x <= 'S'; $x++) {
				$objPHPExcel->getActiveSheet()->getStyle($x . $baris)->applyFromArray(array(
					'font'    => array(
						'name'      => 'calibri',
						'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
						'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
						'size'		=> 11 /*untuk ukuran tulisan yg hasil query bwt yg di dlm tabel*/,
						'color'     => array('rgb' => '000000')
					),
					'borders' => array(
						'bottom'     => array(
							'style' => PHPExcel_Style_Border::BORDER_THIN,
							'color' => array('rgb' => '000000')
						),
						'top'     => array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('rgb' => '000000')),
						'left'     => array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('rgb' => '000000')),
						'right'     => array(
							'style' => PHPExcel_Style_Border::BORDER_THIN,
							'color' => array('rgb' => '000000')
						)
					)
				));
			}



			if ($item['kd_obat'] != $kdobat) $objPHPExcel->getActiveSheet()->setCellValue('A' . $baris, $nomor);
			if ($item['kd_obat'] != $kdobat) $objPHPExcel->getActiveSheet()->setCellValue('B' . $baris, $item['nama_obat']);
			if ($item['kd_obat'] != $kdobat) $objPHPExcel->getActiveSheet()->setCellValue('C' . $baris, $item['kd_satuan_kecil']);
			$objPHPExcel->getActiveSheet()->setCellValue('E' . $baris, number_format($item['saldo_awal'], 2, '.', ','));
			$objPHPExcel->getActiveSheet()->setCellValue('F' . $baris, convertDate($item['tanggal_masuk']));
			$objPHPExcel->getActiveSheet()->setCellValue('G' . $baris, $item['no_faktur']);
			$objPHPExcel->getActiveSheet()->setCellValue('H' . $baris, $item['supplier']);
			$objPHPExcel->getActiveSheet()->setCellValue('I' . $baris, $item['batch']);
			$objPHPExcel->getActiveSheet()->setCellValue('J' . $baris, $item['jumlah_penerimaan']);
			// if ($item['kd_obat'] != $kdobat) $objPHPExcel->getActiveSheet()->setCellValue('K' . $baris, number_format($persediaan, 2, '.', ','));
			$objPHPExcel->getActiveSheet()->setCellValue('L' . $baris, convertDate($item['tanggal_keluar']));
			$objPHPExcel->getActiveSheet()->setCellValue('M' . $baris, $item['no_sbbk']);
			$objPHPExcel->getActiveSheet()->setCellValue('N' . $baris, $item['customer']);
			$objPHPExcel->getActiveSheet()->setCellValue('O' . $baris, convertDate($item['tgl_expire']));
			$objPHPExcel->getActiveSheet()->setCellValue('P' . $baris, number_format($item['jumlah_keluar'], 2, '.', ','));
			$objPHPExcel->getActiveSheet()->setCellValue('Q' . $baris, number_format($item['jumlah_keluar'], 2, '.', ','));
			// if ($item['kd_obat'] != $kdobat) $objPHPExcel->getActiveSheet()->setCellValue('R' . $baris, number_format($saldoakhir, 2, '.', ','));
			if ($item['kd_obat'] != $kdobat) $nomor = $nomor + 1;
			$baris = $baris + 1;
			$kdobat = $item['kd_obat'];
		}
		$objWriter = IOFactory::createWriter($objPHPExcel, 'Excel5');
		$objWriter->save("download/lappsikotropika.xls");
		header("Location: " . base_url() . "download/lapobatsas.xls");
	}

	public function excellplpobulananpsikotropika($bulan = "", $tahun = "", $kd_unit_apt = "")
	{
		if ($kd_unit_apt == "NULL") $kd_unit_apt = "";
		$this->load->library('phpexcel');
		$this->load->library('PHPExcel/iofactory');
		//$objPHPExcel = new PHPExcel(); 
		$objPHPExcel = IOFactory::load("./template/lappsikotropika.xls");
		$objPHPExcel->getProperties()->setTitle("title")->setDescription("description");
		$items = array();
		$items = $this->mlaporanapt->getMutasiObatPsikotropikaBulanan('', $bulan, $tahun);
		//debugvar($kd_unit_apt);
		$baris = 9;
		$nomor = 1;
		$kdobat = "";
		$bl = array('01' => 'Januari', '02' => 'Februari', '03' => 'Maret', '04' => 'April', '05' => 'Mei', '06' => 'Juni', '07' => 'Juli', '08' => 'Agustus', '09' => 'September', '10' => 'Oktober', '11' => 'November', '12' => 'Desember');
		$objPHPExcel->getActiveSheet()->setCellValue('S4', $bl[$bulan]);
		$objPHPExcel->getActiveSheet()->setCellValue('S5', $tahun);
		foreach ($items as $item) {


			for ($x = 'A'; $x <= 'S'; $x++) {
				$objPHPExcel->getActiveSheet()->getStyle($x . $baris)->applyFromArray(array(
					'font'    => array(
						'name'      => 'calibri',
						'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
						'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
						'size'		=> 11 /*untuk ukuran tulisan yg hasil query bwt yg di dlm tabel*/,
						'color'     => array('rgb' => '000000')
					),
					'borders' => array(
						'bottom'     => array(
							'style' => PHPExcel_Style_Border::BORDER_THIN,
							'color' => array('rgb' => '000000')
						),
						'top'     => array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('rgb' => '000000')),
						'left'     => array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('rgb' => '000000')),
						'right'     => array(
							'style' => PHPExcel_Style_Border::BORDER_THIN,
							'color' => array('rgb' => '000000')
						)
					)
				));
			}


			$saldoawal = $item['saldo_awal_apbn'] + $item['saldo_awal_program'] + $item['saldo_awal_apbd1'] + $item['saldo_awal_apbd2'] + $item['saldo_awal_lain'];
			$saldoakhir = $item['saldo_akhir_apbn'] + $item['saldo_akhir_program'] + $item['saldo_akhir_apbd1'] + $item['saldo_akhir_apbd2'] + $item['saldo_akhir_lain'];
			$penerimaan = $item['in_pbf_apbn'] + $item['in_pbf_program'] + $item['in_pbf_apbd1'] + $item['in_pbf_apbd2'] + $item['in_pbf_lain'];
			$persediaan = $saldoawal + $penerimaan;

			if ($item['kd_obat'] != $kdobat) $objPHPExcel->getActiveSheet()->setCellValue('A' . $baris, $nomor);
			if ($item['kd_obat'] != $kdobat) $objPHPExcel->getActiveSheet()->setCellValue('B' . $baris, $item['nama_obat']);
			if ($item['kd_obat'] != $kdobat) $objPHPExcel->getActiveSheet()->setCellValue('C' . $baris, $item['satuan_kecil']);
			$objPHPExcel->getActiveSheet()->setCellValue('E' . $baris, number_format($saldoawal, 2, '.', ','));
			$objPHPExcel->getActiveSheet()->setCellValue('F' . $baris, convertDate($item['tanggal_masuk']));
			$objPHPExcel->getActiveSheet()->setCellValue('G' . $baris, $item['no_faktur']);
			$objPHPExcel->getActiveSheet()->setCellValue('H' . $baris, $item['supplier']);
			$objPHPExcel->getActiveSheet()->setCellValue('I' . $baris, $item['no_batch']);
			$objPHPExcel->getActiveSheet()->setCellValue('J' . $baris, $item['qty_kcl']);
			if ($item['kd_obat'] != $kdobat) $objPHPExcel->getActiveSheet()->setCellValue('K' . $baris, number_format($persediaan, 2, '.', ','));
			$objPHPExcel->getActiveSheet()->setCellValue('L' . $baris, convertDate($item['tanggal_keluar']));
			$objPHPExcel->getActiveSheet()->setCellValue('M' . $baris, $item['no_sbbk']);
			$objPHPExcel->getActiveSheet()->setCellValue('N' . $baris, $item['customer']);
			$objPHPExcel->getActiveSheet()->setCellValue('O' . $baris, convertDate($item['tgl_expire']));
			$objPHPExcel->getActiveSheet()->setCellValue('P' . $baris, number_format($item['qty'], 2, '.', ','));
			$objPHPExcel->getActiveSheet()->setCellValue('Q' . $baris, number_format($item['qty'], 2, '.', ','));
			if ($item['kd_obat'] != $kdobat) $objPHPExcel->getActiveSheet()->setCellValue('R' . $baris, number_format($saldoakhir, 2, '.', ','));
			if ($item['kd_obat'] != $kdobat) $nomor = $nomor + 1;
			$baris = $baris + 1;
			$kdobat = $item['kd_obat'];
		}
		$objWriter = IOFactory::createWriter($objPHPExcel, 'Excel5');
		$objWriter->save("download/lappsikotropika.xls");
		header("Location: " . base_url() . "download/lappsikotropika.xls");
	}

	public function excellplpobulananprekursor($bulan = "", $tahun = "", $kd_unit_apt = "")
	{
		if ($kd_unit_apt == "NULL") $kd_unit_apt = "";
		$this->load->library('phpexcel');
		$this->load->library('PHPExcel/iofactory');
		//$objPHPExcel = new PHPExcel(); 
		$objPHPExcel = IOFactory::load("./template/lapprekursor.xls");
		$objPHPExcel->getProperties()->setTitle("title")->setDescription("description");
		$items = array();
		$items = $this->mlaporanapt->getMutasiObatPrekursorBulanan('', $bulan, $tahun);
		//debugvar($kd_unit_apt);
		$baris = 9;
		$nomor = 1;
		$kdobat = "";
		$bl = array('01' => 'Januari', '02' => 'Februari', '03' => 'Maret', '04' => 'April', '05' => 'Mei', '06' => 'Juni', '07' => 'Juli', '08' => 'Agustus', '09' => 'September', '10' => 'Oktober', '11' => 'November', '12' => 'Desember');
		$objPHPExcel->getActiveSheet()->setCellValue('S4', $bl[$bulan]);
		$objPHPExcel->getActiveSheet()->setCellValue('S5', $tahun);
		foreach ($items as $item) {


			for ($x = 'A'; $x <= 'S'; $x++) {
				$objPHPExcel->getActiveSheet()->getStyle($x . $baris)->applyFromArray(array(
					'font'    => array(
						'name'      => 'calibri',
						'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
						'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
						'size'		=> 11 /*untuk ukuran tulisan yg hasil query bwt yg di dlm tabel*/,
						'color'     => array('rgb' => '000000')
					),
					'borders' => array(
						'bottom'     => array(
							'style' => PHPExcel_Style_Border::BORDER_THIN,
							'color' => array('rgb' => '000000')
						),
						'top'     => array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('rgb' => '000000')),
						'left'     => array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('rgb' => '000000')),
						'right'     => array(
							'style' => PHPExcel_Style_Border::BORDER_THIN,
							'color' => array('rgb' => '000000')
						)
					)
				));
			}


			$saldoawal = $item['saldo_awal_apbn'] + $item['saldo_awal_program'] + $item['saldo_awal_apbd1'] + $item['saldo_awal_apbd2'] + $item['saldo_awal_lain'];
			$saldoakhir = $item['saldo_akhir_apbn'] + $item['saldo_akhir_program'] + $item['saldo_akhir_apbd1'] + $item['saldo_akhir_apbd2'] + $item['saldo_akhir_lain'];
			$penerimaan = $item['in_pbf_apbn'] + $item['in_pbf_program'] + $item['in_pbf_apbd1'] + $item['in_pbf_apbd2'] + $item['in_pbf_lain'];
			$persediaan = $saldoawal + $penerimaan;

			if ($item['kd_obat'] != $kdobat) $objPHPExcel->getActiveSheet()->setCellValue('A' . $baris, $nomor);
			if ($item['kd_obat'] != $kdobat) $objPHPExcel->getActiveSheet()->setCellValue('B' . $baris, $item['nama_obat']);
			if ($item['kd_obat'] != $kdobat) $objPHPExcel->getActiveSheet()->setCellValue('C' . $baris, $item['satuan_kecil']);
			$objPHPExcel->getActiveSheet()->setCellValue('E' . $baris, number_format($saldoawal, 2, '.', ','));
			$objPHPExcel->getActiveSheet()->setCellValue('F' . $baris, convertDate($item['tanggal_masuk']));
			$objPHPExcel->getActiveSheet()->setCellValue('G' . $baris, $item['no_faktur']);
			$objPHPExcel->getActiveSheet()->setCellValue('H' . $baris, $item['supplier']);
			$objPHPExcel->getActiveSheet()->setCellValue('I' . $baris, $item['no_batch']);
			$objPHPExcel->getActiveSheet()->setCellValue('J' . $baris, $item['qty_kcl']);
			if ($item['kd_obat'] != $kdobat) $objPHPExcel->getActiveSheet()->setCellValue('K' . $baris, number_format($persediaan, 2, '.', ','));
			$objPHPExcel->getActiveSheet()->setCellValue('L' . $baris, convertDate($item['tanggal_keluar']));
			$objPHPExcel->getActiveSheet()->setCellValue('M' . $baris, $item['no_sbbk']);
			$objPHPExcel->getActiveSheet()->setCellValue('N' . $baris, $item['customer']);
			$objPHPExcel->getActiveSheet()->setCellValue('O' . $baris, convertDate($item['tgl_expire']));
			$objPHPExcel->getActiveSheet()->setCellValue('P' . $baris, number_format($item['qty'], 2, '.', ','));
			$objPHPExcel->getActiveSheet()->setCellValue('Q' . $baris, number_format($item['qty'], 2, '.', ','));
			if ($item['kd_obat'] != $kdobat) $objPHPExcel->getActiveSheet()->setCellValue('R' . $baris, number_format($saldoakhir, 2, '.', ','));
			if ($item['kd_obat'] != $kdobat) $nomor = $nomor + 1;
			$baris = $baris + 1;
			$kdobat = $item['kd_obat'];
		}
		$objWriter = IOFactory::createWriter($objPHPExcel, 'Excel5');
		$objWriter->save("download/lapprekursor.xls");
		header("Location: " . base_url() . "download/lapprekursor.xls");
	}

	public function excellplpobulanannarkotika($bulan = "", $tahun = "", $kd_unit_apt = "")
	{
		if ($kd_unit_apt == "NULL") $kd_unit_apt = "";
		$this->load->library('phpexcel');
		$this->load->library('PHPExcel/iofactory');
		//$objPHPExcel = new PHPExcel(); 
		$objPHPExcel = IOFactory::load("./template/lapnarkotika.xls");
		$objPHPExcel->getProperties()->setTitle("title")->setDescription("description");
		$items = array();
		$items = $this->mlaporanapt->getMutasiObatNarkotikaBulanan('', $bulan, $tahun);
		//debugvar($kd_unit_apt);
		$baris = 9;
		$nomor = 1;
		$kdobat = "";
		$bl = array('01' => 'Januari', '02' => 'Februari', '03' => 'Maret', '04' => 'April', '05' => 'Mei', '06' => 'Juni', '07' => 'Juli', '08' => 'Agustus', '09' => 'September', '10' => 'Oktober', '11' => 'November', '12' => 'Desember');
		$objPHPExcel->getActiveSheet()->setCellValue('S4', $bl[$bulan]);
		$objPHPExcel->getActiveSheet()->setCellValue('S5', $tahun);
		foreach ($items as $item) {


			for ($x = 'A'; $x <= 'S'; $x++) {
				$objPHPExcel->getActiveSheet()->getStyle($x . $baris)->applyFromArray(array(
					'font'    => array(
						'name'      => 'calibri',
						'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
						'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
						'size'		=> 11 /*untuk ukuran tulisan yg hasil query bwt yg di dlm tabel*/,
						'color'     => array('rgb' => '000000')
					),
					'borders' => array(
						'bottom'     => array(
							'style' => PHPExcel_Style_Border::BORDER_THIN,
							'color' => array('rgb' => '000000')
						),
						'top'     => array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('rgb' => '000000')),
						'left'     => array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('rgb' => '000000')),
						'right'     => array(
							'style' => PHPExcel_Style_Border::BORDER_THIN,
							'color' => array('rgb' => '000000')
						)
					)
				));
			}


			$saldoawal = $item['saldo_awal_apbn'] + $item['saldo_awal_program'] + $item['saldo_awal_apbd1'] + $item['saldo_awal_apbd2'] + $item['saldo_awal_lain'];
			$saldoakhir = $item['saldo_akhir_apbn'] + $item['saldo_akhir_program'] + $item['saldo_akhir_apbd1'] + $item['saldo_akhir_apbd2'] + $item['saldo_akhir_lain'];
			$penerimaan = $item['in_pbf_apbn'] + $item['in_pbf_program'] + $item['in_pbf_apbd1'] + $item['in_pbf_apbd2'] + $item['in_pbf_lain'];
			$persediaan = $saldoawal + $penerimaan;

			if ($item['kd_obat'] != $kdobat) $objPHPExcel->getActiveSheet()->setCellValue('A' . $baris, $nomor);
			if ($item['kd_obat'] != $kdobat) $objPHPExcel->getActiveSheet()->setCellValue('B' . $baris, $item['nama_obat']);
			if ($item['kd_obat'] != $kdobat) $objPHPExcel->getActiveSheet()->setCellValue('C' . $baris, $item['satuan_kecil']);
			$objPHPExcel->getActiveSheet()->setCellValue('E' . $baris, number_format($saldoawal, 2, '.', ','));
			$objPHPExcel->getActiveSheet()->setCellValue('F' . $baris, convertDate($item['tanggal_masuk']));
			$objPHPExcel->getActiveSheet()->setCellValue('G' . $baris, $item['no_faktur']);
			$objPHPExcel->getActiveSheet()->setCellValue('H' . $baris, $item['supplier']);
			$objPHPExcel->getActiveSheet()->setCellValue('I' . $baris, $item['no_batch']);
			$objPHPExcel->getActiveSheet()->setCellValue('J' . $baris, $item['qty_kcl']);
			if ($item['kd_obat'] != $kdobat) $objPHPExcel->getActiveSheet()->setCellValue('K' . $baris, number_format($persediaan, 2, '.', ','));
			$objPHPExcel->getActiveSheet()->setCellValue('L' . $baris, convertDate($item['tanggal_keluar']));
			$objPHPExcel->getActiveSheet()->setCellValue('M' . $baris, $item['no_sbbk']);
			$objPHPExcel->getActiveSheet()->setCellValue('N' . $baris, $item['customer']);
			$objPHPExcel->getActiveSheet()->setCellValue('O' . $baris, convertDate($item['tgl_expire']));
			$objPHPExcel->getActiveSheet()->setCellValue('P' . $baris, number_format($item['qty'], 2, '.', ','));
			$objPHPExcel->getActiveSheet()->setCellValue('Q' . $baris, number_format($item['qty'], 2, '.', ','));
			if ($item['kd_obat'] != $kdobat) $objPHPExcel->getActiveSheet()->setCellValue('R' . $baris, number_format($saldoakhir, 2, '.', ','));
			if ($item['kd_obat'] != $kdobat) $nomor = $nomor + 1;
			$baris = $baris + 1;
			$kdobat = $item['kd_obat'];
		}
		$objWriter = IOFactory::createWriter($objPHPExcel, 'Excel5');
		$objWriter->save("download/lapnarkotika.xls");
		header("Location: " . base_url() . "download/lapnarkotika.xls");
	}

	public function rl1excelpenerimaanobat($periodeawal = "", $periodeakhir = "", $kd_supplier = "0")
	{

		if ($kd_supplier == "0") {
			$kd_supplier = "";
		}
		$this->load->library('phpexcel');
		$this->load->library('PHPExcel/iofactory');
		$objPHPExcel = new PHPExcel();
		$objPHPExcel->getProperties()->setTitle("title")->setDescription("description");
		$objPHPExcel->getActiveSheet()->mergeCells('A2:E2');

		$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(0)->setWidth(5); //NO
		$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(1)->setWidth(20); //NOMOR
		$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(2)->setWidth(30); //NO FAKTUR
		$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(3)->setWidth(40); //NAMA DISTRIBUTOR
		$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(4)->setWidth(11); //TANGGAL
		$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(5)->setWidth(14); //SUMBER
		$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(6)->setWidth(15); //STATUS
		$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(7)->setWidth(15); //TOTAL

		for ($x = 'A'; $x <= 'H'; $x++) {
			$objPHPExcel->getActiveSheet()->getStyle($x . '2')->getAlignment()->applyFromArray(
				array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, 'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER, 'rotation'   => 0,)
			);
		}

		if ($periodeawal != '' and $periodeakhir != '') {
			$tglawal = substr($periodeawal, 0, 2);
			$tglakhir = substr($periodeakhir, 0, 2);
			$blnawal = substr($periodeawal, 3, 2);
			$blnakhir = substr($periodeakhir, 3, 2);
			$thnawal = substr($periodeawal, 6, 10);
			$thnakhir = substr($periodeakhir, 6, 10);

			if ($blnawal == '01') {
				$blnawal1 = 'Januari';
			}
			if ($blnawal == '02') {
				$blnawal1 = 'Februari';
			}
			if ($blnawal == '03') {
				$blnawal1 = 'Maret';
			}
			if ($blnawal == '04') {
				$blnawal1 = 'April';
			}
			if ($blnawal == '05') {
				$blnawal1 = 'Mei';
			}
			if ($blnawal == '06') {
				$blnawal1 = 'Juni';
			}
			if ($blnawal == '07') {
				$blnawal1 = 'Juli';
			}
			if ($blnawal == '08') {
				$blnawal1 = 'Agustus';
			}
			if ($blnawal == '09') {
				$blnawal1 = 'September';
			}
			if ($blnawal == '10') {
				$blnawal1 = 'Oktober';
			}
			if ($blnawal == '11') {
				$blnawal1 = 'November';
			}
			if ($blnawal == '12') {
				$blnawal1 = 'Desember';
			}

			if ($blnakhir == '01') {
				$blnakhir1 = 'Januari';
			}
			if ($blnakhir == '02') {
				$blnakhir1 = 'Februari';
			}
			if ($blnakhir == '03') {
				$blnakhir1 = 'Maret';
			}
			if ($blnakhir == '04') {
				$blnakhir1 = 'April';
			}
			if ($blnakhir == '05') {
				$blnakhir1 = 'Mei';
			}
			if ($blnakhir == '06') {
				$blnakhir1 = 'Juni';
			}
			if ($blnakhir == '07') {
				$blnakhir1 = 'Juli';
			}
			if ($blnakhir == '08') {
				$blnakhir1 = 'Agustus';
			}
			if ($blnakhir == '09') {
				$blnakhir1 = 'September';
			}
			if ($blnakhir == '10') {
				$blnakhir1 = 'Oktober';
			}
			if ($blnakhir == '11') {
				$blnakhir1 = 'November';
			}
			if ($blnakhir == '12') {
				$blnakhir1 = 'Desember';
			}
			$objPHPExcel->getActiveSheet()->setCellValue('A2', 'LAPORAN PENERIMAAN OBAT PERIODE  : ' . $tglawal . ' ' . $blnawal1 . ' ' . $thnawal . ' s/d ' . $tglakhir . ' ' . $blnakhir1 . ' ' . $thnakhir);
		}

		for ($x = 'A'; $x <= 'H'; $x++) {
			$objPHPExcel->getActiveSheet()->getStyle($x . '4')->getAlignment()->applyFromArray(
				array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, 'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER, 'rotation'   => 0,)
			);

			$objPHPExcel->getActiveSheet()->getStyle($x . '4')->applyFromArray(array(
				'font'    => array(
					'name'      => 'calibri',
					'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
					'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
					'size'		=> 12,
					'color'     => array('rgb' => '000000')
				),
				'borders' => array(
					'bottom'     => array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('rgb' => '000000')),
					'top'     => array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('rgb' => '000000')),
					'left'     => array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('rgb' => '000000')),
					'right'     => array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('rgb' => '000000'))
				)
			));
		}
		$objPHPExcel->getActiveSheet()->setCellValue('A4', 'NO');
		$objPHPExcel->getActiveSheet()->setCellValue('B4', 'Nomor');
		$objPHPExcel->getActiveSheet()->setCellValue('C4', 'No Faktur');
		$objPHPExcel->getActiveSheet()->setCellValue('D4', 'Nama Distributor');
		$objPHPExcel->getActiveSheet()->setCellValue('E4', 'Tanggal');
		$objPHPExcel->getActiveSheet()->setCellValue('F4', 'Sumber');
		$objPHPExcel->getActiveSheet()->setCellValue('G4', 'Status');
		$objPHPExcel->getActiveSheet()->setCellValue('H4', 'Total');
		$items = array();
		$this->load->model('apotek/mpenerimaanapt');

		$items = $this->mpenerimaanapt->ambilDataPenerimaan('', $kd_supplier, $periodeawal, $periodeakhir);
		$baris = 5;
		$nomor = 1;
		$total = 0;
		foreach ($items as $item) {
			# code...
			for ($x = 'A'; $x <= 'F'; $x++) {
				if ($x == 'A') {
					$objPHPExcel->getActiveSheet()->getStyle($x . $baris)->getAlignment()->applyFromArray(
						array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, 'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER, 'rotation'   => 0,)
					);
				} else if ($x == 'B') {
					$objPHPExcel->getActiveSheet()->getStyle($x . $baris)->getAlignment()->applyFromArray(
						array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT, 'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER, 'rotation'   => 0,)
					);
				} else if ($x == 'C') {
					$objPHPExcel->getActiveSheet()->getStyle($x . $baris)->getAlignment()->applyFromArray(
						array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT, 'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER, 'rotation'   => 0,)
					);
				} else if ($x == 'D') {
					$objPHPExcel->getActiveSheet()->getStyle($x . $baris)->getAlignment()->applyFromArray(
						array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT, 'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER, 'rotation'   => 0,)
					);
				} else if ($x == 'E') {
					$objPHPExcel->getActiveSheet()->getStyle($x . $baris)->getAlignment()->applyFromArray(
						array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT, 'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER, 'rotation'   => 0,)
					);
				} else if ($x == 'F') {
					$objPHPExcel->getActiveSheet()->getStyle($x . $baris)->getAlignment()->applyFromArray(
						array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT, 'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER, 'rotation'   => 0,)
					);
				} else if ($x == 'G') {
					$objPHPExcel->getActiveSheet()->getStyle($x . $baris)->getAlignment()->applyFromArray(
						array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT, 'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER, 'rotation'   => 0,)
					);
				} else if ($x == 'H') {
					$objPHPExcel->getActiveSheet()->getStyle($x . $baris)->getAlignment()->applyFromArray(
						array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT, 'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER, 'rotation'   => 0,)
					);
				}

				$objPHPExcel->getActiveSheet()->getStyle($x . $baris)->applyFromArray(array(
					'font'    => array(
						'name'      => 'calibri',
						'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
						'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
						'size'		=> 12,
						'color'     => array('rgb' => '000000')
					),
					'borders' => array(
						'bottom'     => array(
							'style' => PHPExcel_Style_Border::BORDER_THIN,
							'color' => array('rgb' => '000000')
						),
						'top'     => array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('rgb' => '000000')),
						'left'     => array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('rgb' => '000000')),
						'right'     => array(
							'style' => PHPExcel_Style_Border::BORDER_THIN,
							'color' => array('rgb' => '000000')
						)
					)
				));
			}
			// $item['total_transaksi']=$this->mpenjualan->getTotalPenjualan($item['no_penjualan']);
			$query = $this->db->query('select sum(qty_kcl*harga_pokok) as jumlah from apt_penerimaan_detail where no_penerimaan="' . $item['no_penerimaan'] . '"');
			$total = $query->row_array();
			if ($item['posting'] == "1") {
				$item['posting'] = "Tutup Faktur";
			} else {
				$item['posting'] = "";
			}
			$objPHPExcel->getActiveSheet()->setCellValue('A' . $baris, $nomor);
			$objPHPExcel->getActiveSheet()->setCellValue('B' . $baris, $item['no_penerimaan']);
			$objPHPExcel->getActiveSheet()->setCellValue('C' . $baris, $item['no_faktur']);
			$objPHPExcel->getActiveSheet()->setCellValue('D' . $baris, $item['nama']);
			$objPHPExcel->getActiveSheet()->setCellValue('E' . $baris, convertDate($item['tgl_penerimaan']));
			$objPHPExcel->getActiveSheet()->setCellValue('F' . $baris, $item['nama_unit_apt']);
			$objPHPExcel->getActiveSheet()->setCellValue('G' . $baris, $item['posting']);
			$objPHPExcel->getActiveSheet()->setCellValue('H' . $baris, number_format($total['jumlah']));
			$nomor = $nomor + 1;
			$baris = $baris + 1;
		}
		$objWriter = IOFactory::createWriter($objPHPExcel, 'Excel5');
		$objWriter->save("download/lap_penerimaan.xls");
		header("Location: " . base_url() . "download/lap_penerimaan.xls");
	}

	public function rl1excelmutasitriwulan($triwulan = "", $tahun = "")
	{

		if ($triwulan == '1') {
			$per = "PER, 30 MARET " . $tahun;
			$saldo_awal_title = 'SALDO AWAL (Per 01 JANUARI ' . $tahun . ')';
			$saldo_akhir_title = 'SALDO AKHIR (Per 30 MARET ' . $tahun . ')';
		} else if ($triwulan == '2') {
			$per = "PER, 30 JUNI " . $tahun;
			$saldo_awal_title = 'SALDO AWAL (Per 01 APRIL ' . $tahun . ')';
			$saldo_akhir_title = 'SALDO AKHIR (Per 30 JUNI ' . $tahun . ')';
		} else if ($triwulan == '3') {
			$per = "PER, 30 SEPTEMBER " . $tahun;
			$saldo_awal_title = 'SALDO AWAL (Per 01 JULI ' . $tahun . ')';
			$saldo_akhir_title = 'SALDO AKHIR (Per 30 SEPTEMBER ' . $tahun . ')';
		} else if ($triwulan == '4') {
			$per = "PER, 30 DESEMBER " . $tahun;
			$saldo_awal_title = 'SALDO AWAL (Per 01 OKTOBER ' . $tahun . ')';
			$saldo_akhir_title = 'SALDO AKHIR (Per 30 DESEMBER ' . $tahun . ')';
		} else {
			$per = "";
			$saldo_awal_title = 'SALDO AWAL';
			$saldo_akhir_title = 'SALDO AKHIR';
		}
		$this->load->library('phpexcel');
		$this->load->library('PHPExcel/iofactory');
		$objPHPExcel = new PHPExcel();
		$objPHPExcel->getProperties()->setTitle("title")->setDescription("description");
		// $objPHPExcel->getActiveSheet()->mergeCells('A2:E2');
		$objPHPExcel->getActiveSheet()
			->getPageSetup()
			->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);
		$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(0)->setWidth(6); //NO
		$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(1)->setWidth(29); //NOMOR
		$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(2)->setWidth(17); //NO FAKTUR
		$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(3)->setWidth(17); //NAMA DISTRIBUTOR
		$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(4)->setWidth(17); //TANGGAL
		$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(5)->setWidth(17); //SUMBER
		$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(6)->setWidth(17); //STATUS
		$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(7)->setWidth(17); //TOTAL
		$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(8)->setWidth(17); //TOTAL
		$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(9)->setWidth(17); //TOTAL
		$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(10)->setWidth(17); //TOTAL
		$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(11)->setWidth(17); //TOTAL
		$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(12)->setWidth(17); //TOTAL
		$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(13)->setWidth(17); //TOTAL
		$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(14)->setWidth(17); //TOTAL
		$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(15)->setWidth(17); //TOTAL
		$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(16)->setWidth(17); //TOTAL
		$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(17)->setWidth(17); //TOTAL
		$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(18)->setWidth(17); //TOTAL
		// 		$objPHPExcel->getDefaultStyle()
		//     ->getBorders()
		//     ->getTop()
		//         ->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
		// $objPHPExcel->getDefaultStyle()
		//     ->getBorders()
		//     ->getBottom()
		//         ->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
		// $objPHPExcel->getDefaultStyle()
		//     ->getBorders()
		//     ->getLeft()
		//         ->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
		// $objPHPExcel->getDefaultStyle()
		//     ->getBorders()
		//     ->getRight()
		//         ->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
		for ($x = 'A'; $x <= 'R'; $x++) {
			$objPHPExcel->getActiveSheet()->getStyle($x . '7')->getAlignment()->applyFromArray(
				array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, 'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER, 'rotation'   => 0,)
			);
			$objPHPExcel->getActiveSheet()->getStyle($x . '8')->getAlignment()->applyFromArray(
				array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, 'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER, 'rotation'   => 0,)
			);


			$objPHPExcel->getActiveSheet()->getStyle($x . '7')->applyFromArray(array(
				'font'    => array(
					'name'      => 'calibri',
					'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
					'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
					'bold' => true,
					'size'		=> 11,
					'color'     => array('rgb' => '000000')
				),
				'borders' => array(
					'bottom'     => array(
						'style' => PHPExcel_Style_Border::BORDER_THIN,
						'color' => array('rgb' => '000000')
					),
					'top'     => array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('rgb' => '000000')),
					'left'     => array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('rgb' => '000000')),
					'right'     => array(
						'style' => PHPExcel_Style_Border::BORDER_THIN,
						'color' => array('rgb' => '000000')
					)
				)
			));
			$objPHPExcel->getActiveSheet()->getStyle($x . '8')->applyFromArray(array(
				'font'    => array(
					'name'      => 'calibri',
					'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
					'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
					'bold' => true,
					'size'		=> 11,
					'color'     => array('rgb' => '000000')
				),
				'borders' => array(
					'bottom'     => array(
						'style' => PHPExcel_Style_Border::BORDER_THIN,
						'color' => array('rgb' => '000000')
					),
					'top'     => array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('rgb' => '000000')),
					'left'     => array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('rgb' => '000000')),
					'right'     => array(
						'style' => PHPExcel_Style_Border::BORDER_THIN,
						'color' => array('rgb' => '000000')
					)
				)
			));
			$objPHPExcel->getActiveSheet()->getStyle($x . '9')->applyFromArray(array(
				'font'    => array(
					'name'      => 'calibri',
					'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
					'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
					'bold' => false,
					'size'		=> 11,
					'color'     => array('rgb' => '000000')
				),
				'borders' => array(
					'bottom'     => array(
						'style' => PHPExcel_Style_Border::BORDER_THIN,
						'color' => array('rgb' => '000000')
					),
					'top'     => array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('rgb' => '000000')),
					'left'     => array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('rgb' => '000000')),
					'right'     => array(
						'style' => PHPExcel_Style_Border::BORDER_THIN,
						'color' => array('rgb' => '000000')
					)
				)
			));
		}

		// if($periodeawal!='' and $periodeakhir!=''){
		// 	$tglawal=substr($periodeawal,0,2);		$tglakhir=substr($periodeakhir,0,2);
		// 	$blnawal=substr($periodeawal,3,2);		$blnakhir=substr($periodeakhir,3,2);
		// 	$thnawal=substr($periodeawal,6,10);		$thnakhir=substr($periodeakhir,6,10);

		// 	if($blnawal=='01'){$blnawal1='Januari';} if($blnawal=='02'){$blnawal1='Februari';}	if($blnawal=='03'){$blnawal1='Maret';} if($blnawal=='04'){$blnawal1='April';}
		// 	if($blnawal=='05'){$blnawal1='Mei';} if($blnawal=='06'){$blnawal1='Juni';} if($blnawal=='07'){$blnawal1='Juli';} if($blnawal=='08'){$blnawal1='Agustus';}
		// 	if($blnawal=='09'){$blnawal1='September';} if($blnawal=='10'){$blnawal1='Oktober';}	if($blnawal=='11'){$blnawal1='November';} if($blnawal=='12'){$blnawal1='Desember';}

		// 	if($blnakhir=='01'){$blnakhir1='Januari';} if($blnakhir=='02'){$blnakhir1='Februari';} if($blnakhir=='03'){$blnakhir1='Maret';}	if($blnakhir=='04'){$blnakhir1='April';}
		// 	if($blnakhir=='05'){$blnakhir1='Mei';} if($blnakhir=='06'){$blnakhir1='Juni';} if($blnakhir=='07'){$blnakhir1='Juli';} if($blnakhir=='08'){$blnakhir1='Agustus';}
		// 	if($blnakhir=='09'){$blnakhir1='September';} if($blnakhir=='10'){$blnakhir1='Oktober';} if($blnakhir=='11'){$blnakhir1='November';} if($blnakhir=='12'){$blnakhir1='Desember';}			
		// 	$objPHPExcel->getActiveSheet()->setCellValue ('A2','LAPORAN PENERIMAAN OBAT PERIODE  : '.$tglawal.' '.$blnawal1.' '.$thnawal.' s/d '.$tglakhir.' '.$blnakhir1.' '.$thnakhir);
		// }
		$objPHPExcel->getActiveSheet()->setCellValue('A1', 'RINCIAN HASIL INVENTARISASI PERSEDIAAN AKHIR');
		$objPHPExcel->getActiveSheet()->setCellValue('A2', $per);
		$objPHPExcel->getActiveSheet()->setCellValue('A4', 'NAMA SKPD: DINAS KESEHATAN KOTA BALIKPAPAN');
		$objPHPExcel->getActiveSheet()->setCellValue('A5', 'UPTD. INSTALASI FARMASI DAN PERBEKALAN KESEHATAN');
		// for($x='A';$x<='R';$x++){
		// 	$objPHPExcel->getActiveSheet()->getStyle($x.'7')->getAlignment()->applyFromArray(
		// 		array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,'rotation'   => 0,));
		// 	$objPHPExcel->getActiveSheet()->getStyle($x.'8')->getAlignment()->applyFromArray(
		// 		array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,'rotation'   => 0,));
		// }
		// 	$objPHPExcel->getActiveSheet()->getStyle($x.'4')->applyFromArray(array('font'    => array('name'      => 'calibri','horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
		// 																	'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,'size'		=>12,'color'     => array('rgb' => '000000')),
		// 																	'borders' => array('bottom'     => array('style' => PHPExcel_Style_Border::BORDER_THIN,'color' => array('rgb' => '000000')),
		// 																	'top'     => array('style' => PHPExcel_Style_Border::BORDER_THIN,'color' => array('rgb' => '000000')),
		// 																	'left'     => array('style' => PHPExcel_Style_Border::BORDER_THIN,'color' => array('rgb' => '000000')),
		// 																	'right'     => array('style' => PHPExcel_Style_Border::BORDER_THIN,'color' => array('rgb' => '000000')))));
		// }		
		$objPHPExcel->getActiveSheet()->setCellValue('A7', 'NO');
		$objPHPExcel->getActiveSheet()->setCellValue('B7', 'URAIAN BARANG');
		$objPHPExcel->getActiveSheet()->setCellValue('C7', 'Satuan');
		$objPHPExcel->getActiveSheet()->setCellValue('D7', 'SALDO AWAL (Per 01 JANUARI 2019)');
		$objPHPExcel->getActiveSheet()->setCellValue('G7', 'MUTASI BARANG MASUK');
		$objPHPExcel->getActiveSheet()->setCellValue('J7', 'MUTASI BARANG KELUAR');
		$objPHPExcel->getActiveSheet()->setCellValue('M7', 'MUTASI BARANG KARANTINA');
		$objPHPExcel->getActiveSheet()->setCellValue('P7', 'SALDO AKHIR (Per 30 maret 2019)');
		$objPHPExcel->getActiveSheet()->setCellValue('D8', 'Jumlah Satuan');
		$objPHPExcel->getActiveSheet()->setCellValue('E8', 'Harga Satuan (Rp)');
		$objPHPExcel->getActiveSheet()->setCellValue('F8', 'Jumlah (Rp)');
		$objPHPExcel->getActiveSheet()->setCellValue('G8', 'Jumlah Satuan');
		$objPHPExcel->getActiveSheet()->setCellValue('H8', 'Harga Satuan (Rp)');
		$objPHPExcel->getActiveSheet()->setCellValue('I8', 'Jumlah (Rp)');
		$objPHPExcel->getActiveSheet()->setCellValue('J8', 'Jumlah Satuan');
		$objPHPExcel->getActiveSheet()->setCellValue('K8', 'Harga Satuan (Rp)');
		$objPHPExcel->getActiveSheet()->setCellValue('L8', 'Jumlah (Rp)');
		$objPHPExcel->getActiveSheet()->setCellValue('M8', 'Jumlah Satuan');
		$objPHPExcel->getActiveSheet()->setCellValue('N8', 'Harga Satuan (Rp)');
		$objPHPExcel->getActiveSheet()->setCellValue('O8', 'Harga Satuan (Rp)');
		$objPHPExcel->getActiveSheet()->setCellValue('P8', 'Jumlah Satuan');
		$objPHPExcel->getActiveSheet()->setCellValue('Q8', 'Harga Satuan (Rp)');
		$objPHPExcel->getActiveSheet()->setCellValue('R8', 'Harga Satuan (Rp)');

		$objPHPExcel->getActiveSheet()->mergeCells('D7:F7');
		$objPHPExcel->getActiveSheet()->mergeCells('G7:I7');
		$objPHPExcel->getActiveSheet()->mergeCells('J7:L7');
		$objPHPExcel->getActiveSheet()->mergeCells('M7:O7');
		$objPHPExcel->getActiveSheet()->mergeCells('P7:R7');

		$objPHPExcel->getActiveSheet()->mergeCells('A7:A8');
		$objPHPExcel->getActiveSheet()->mergeCells('B7:B8');
		$objPHPExcel->getActiveSheet()->mergeCells('C7:C8');

		$objPHPExcel->getActiveSheet()->setCellValue('A9', '6');
		$objPHPExcel->getActiveSheet()->setCellValue('B9', 'OBAT-OBATAN');

		$objPHPExcel->getActiveSheet()->setCellValue('A10', 'I');
		$objPHPExcel->getActiveSheet()->setCellValue('B10', 'APBD');
		$items = array();
		// $this->load->model('apotek/mpenerimaanapt');

		$baris = 10;
		$nomor = 1;
		$sumberdana = $this->mlaporanapt->sumberdana();
		$items = $this->mlaporanapt->getMutasiObatTriwulan($tahun, $triwulan);
		$no_sd = 1;
		$array_romawi	= array(1 => "I", "II", "III", "IV", "V", "VI", "VII", "VIII", "IX", "X", "XI", "XII");
		foreach ($sumberdana as $sd) {
			for ($x = 'A'; $x <= 'R'; $x++) {
				$objPHPExcel->getActiveSheet()->getStyle($x . $baris)->applyFromArray(array(
					'font'    => array(
						'name'      => 'calibri',
						'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
						'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
						'bold' => true,
						'size'		=> 11,
						'color'     => array('rgb' => '000000')
					),
					'borders' => array(
						'bottom'     => array(
							'style' => PHPExcel_Style_Border::BORDER_THIN,
							'color' => array('rgb' => '000000')
						),
						'top'     => array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('rgb' => '000000')),
						'left'     => array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('rgb' => '000000')),
						'right'     => array(
							'style' => PHPExcel_Style_Border::BORDER_THIN,
							'color' => array('rgb' => '000000')
						)
					)
				));
			}

			$objPHPExcel->getActiveSheet()->setCellValue('A' . $baris, $array_romawi[$no_sd]);
			$no_sd++;
			$objPHPExcel->getActiveSheet()->setCellValue('B' . $baris, $sd['nama_unit_apt']);
			$objPHPExcel->getActiveSheet()->getStyle('A' . $baris)->getAlignment()->applyFromArray(
				array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, 'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER, 'rotation'   => 0,)
			);
			$baris++;
			$hitung_saldo_awal = 0;
			$hitung_harga_saldo_awal = 0;
			$hitung_jumlah_saldo_awal = 0;

			$hitung_mutasi_masuk = 0;
			$hitung_harga_mutasi_masuk = 0;
			$hitung_jumlah_mutasi_masuk = 0;

			$hitung_mutasi_keluar = 0;
			$hitung_harga_mutasi_keluar = 0;
			$hitung_jumlah_mutasi_keluar = 0;

			$hitung_saldo_akhir = 0;
			$hitung_harga_saldo_akhir = 0;
			$hitung_jumlah_saldo_akhir = 0;
			foreach ($items as $item) {
				$objPHPExcel->getActiveSheet()->getStyle('A' . $baris)->getAlignment()->applyFromArray(
					array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, 'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER, 'rotation'   => 0,)
				);
				for ($x = 'A'; $x <= 'C'; $x++) {

					$objPHPExcel->getActiveSheet()->getStyle($x . $baris)->applyFromArray(array(
						'font'    => array(
							'name'      => 'calibri',
							'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
							'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
							'bold' => false,
							'size'		=> 11,
							'color'     => array('rgb' => '000000')
						),
						'borders' => array(
							'bottom'     => array(
								'style' => PHPExcel_Style_Border::BORDER_THIN,
								'color' => array('rgb' => '000000')
							),
							'top'     => array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('rgb' => '000000')),
							'left'     => array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('rgb' => '000000')),
							'right'     => array(
								'style' => PHPExcel_Style_Border::BORDER_THIN,
								'color' => array('rgb' => '000000')
							)
						)
					));
				}
				for ($x = 'D'; $x <= 'R'; $x++) {
					$objPHPExcel->getActiveSheet()->getStyle($x . $baris)->getAlignment()->applyFromArray(
						array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT, 'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER, 'rotation'   => 0,)
					);
					$objPHPExcel->getActiveSheet()->getStyle($x . $baris)->applyFromArray(array(
						'font'    => array(
							'name'      => 'calibri',
							'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
							'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
							'bold' => false,
							'size'		=> 11,
							'color'     => array('rgb' => '000000')
						),
						'borders' => array(
							'bottom'     => array(
								'style' => PHPExcel_Style_Border::BORDER_THIN,
								'color' => array('rgb' => '000000')
							),
							'top'     => array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('rgb' => '000000')),
							'left'     => array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('rgb' => '000000')),
							'right'     => array(
								'style' => PHPExcel_Style_Border::BORDER_THIN,
								'color' => array('rgb' => '000000')
							)
						)
					));
				}
				$persediaan = 0;
				$persediaan = $item['saldo_awal'] + $item['in_pbf'];
				$opt = 0;
				$opt = $item['out_jual'] / 1;
				$total = 0;
				$total = $item['saldo_akhir'] * $item['harga_beli'];

				if ($item['kd_unit_apt'] == $sd['kd_unit_apt']) {
					# code...
					$hitung_saldo_awal = $hitung_saldo_awal + $item['saldo_awal'];
					$hitung_harga_saldo_awal = $hitung_harga_saldo_awal + $item['harga_beli'];
					$hitung_jumlah_saldo_awal = $hitung_jumlah_saldo_awal + ($item['saldo_awal'] * $item['harga_beli']);

					$hitung_mutasi_masuk = $hitung_mutasi_masuk + $item['in_pbf'];
					$hitung_harga_mutasi_masuk = $hitung_harga_mutasi_masuk + $item['harga_beli'];
					$hitung_jumlah_mutasi_masuk = $hitung_jumlah_mutasi_masuk + ($item['in_pbf'] * $item['harga_beli']);

					$hitung_mutasi_keluar = $hitung_mutasi_keluar + $item['out_jual'];
					$hitung_harga_mutasi_keluar = $hitung_harga_mutasi_keluar + $item['harga_beli'];
					$hitung_jumlah_mutasi_keluar = $hitung_jumlah_mutasi_keluar + ($item['out_jual'] * $item['harga_beli']);

					$hitung_mutasi_karantina = $hitung_mutasi_karantina + $item['out_disposal'];
					$hitung_harga_mutasi_karantina = $hitung_harga_mutasi_karantina + $item['harga_beli'];
					$hitung_jumlah_mutasi_karantina = $hitung_jumlah_mutasi_karantina + ($item['out_disposal'] * $item['harga_beli']);

					$hitung_saldo_akhir = $hitung_saldo_akhir + $item['saldo_akhir'];
					$hitung_harga_saldo_akhir = $hitung_harga_saldo_akhir + $item['harga_beli'];
					$hitung_jumlah_saldo_akhir = $hitung_jumlah_saldo_akhir + ($item['saldo_akhir'] * $item['harga_beli']);
					// for ($x='A'; $x <= 'O' ; $x++) { 
					// 	print_r($x.$baris .' - '. $item['kd_obat'].' | ');
					// }
					// echo "<br><br>";
					$objPHPExcel->getActiveSheet()->setCellValue('A' . $baris, $nomor);
					$objPHPExcel->getActiveSheet()->setCellValue('B' . $baris, $item['nama_obat']);
					$objPHPExcel->getActiveSheet()->setCellValue('C' . $baris, $item['satuan_kecil']);
					$objPHPExcel->getActiveSheet()->setCellValue('D' . $baris, number_format($item['saldo_awal'], 2, '.', ','));
					$objPHPExcel->getActiveSheet()->setCellValue('E' . $baris, number_format($item['harga_beli'], 2, '.', ','));
					$objPHPExcel->getActiveSheet()->setCellValue('F' . $baris, number_format($item['saldo_awal'] * $item['harga_beli'], 2, '.', ','));
					$objPHPExcel->getActiveSheet()->setCellValue('G' . $baris, number_format($item['in_pbf'], 2, '.', ','));
					$objPHPExcel->getActiveSheet()->setCellValue('H' . $baris, number_format($item['harga_beli'], 2, '.', ','));
					$objPHPExcel->getActiveSheet()->setCellValue('I' . $baris, number_format($item['in_pbf'] * $item['harga_beli'], 2, '.', ','));
					$objPHPExcel->getActiveSheet()->setCellValue('J' . $baris, number_format($item['out_jual'], 2, '.', ','));
					$objPHPExcel->getActiveSheet()->setCellValue('K' . $baris, number_format($item['harga_beli'], 2, '.', ','));
					$objPHPExcel->getActiveSheet()->setCellValue('L' . $baris, number_format($item['out_jual'] * $item['harga_beli'], 2, '.', ','));
					$objPHPExcel->getActiveSheet()->setCellValue('M' . $baris, number_format($item['out_disposal'], 2, '.', ','));
					$objPHPExcel->getActiveSheet()->setCellValue('N' . $baris, number_format($item['harga_beli'], 2, '.', ','));
					$objPHPExcel->getActiveSheet()->setCellValue('O' . $baris, number_format($item['out_disposal'] * $item['harga_beli'], 2, '.', ','));
					$objPHPExcel->getActiveSheet()->setCellValue('P' . $baris, number_format($item['saldo_akhir'], 2, '.', ','));
					$objPHPExcel->getActiveSheet()->setCellValue('Q' . $baris, number_format($item['harga_beli'], 2, '.', ','));
					$objPHPExcel->getActiveSheet()->setCellValue('R' . $baris, number_format($item['saldo_akhir'] * $item['harga_beli'], 2, '.', ','));
					$nomor++;
					$baris++;
				}
			}
			$objPHPExcel->getActiveSheet()->getStyle('A' . $baris)->getAlignment()->applyFromArray(
				array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, 'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER, 'rotation'   => 0,)
			);
			for ($x = 'A'; $x <= 'R'; $x++) {
				$objPHPExcel->getActiveSheet()->getStyle($x . $baris)->applyFromArray(array(
					'font'    => array(
						'name'      => 'calibri',
						'horizontal' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
						'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
						'bold' => true,
						'size'		=> 11,
						'color'     => array('rgb' => '000000')
					),
					'borders' => array(
						'bottom'     => array(
							'style' => PHPExcel_Style_Border::BORDER_THIN,
							'color' => array('rgb' => '000000')
						),
						'top'     => array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('rgb' => '000000')),
						'left'     => array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('rgb' => '000000')),
						'right'     => array(
							'style' => PHPExcel_Style_Border::BORDER_THIN,
							'color' => array('rgb' => '000000')
						)
					)
				));
			}
			for ($x = 'D'; $x <= 'R'; $x++) {
				$objPHPExcel->getActiveSheet()->getStyle($x . $baris)->getAlignment()->applyFromArray(
					array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT, 'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER, 'rotation'   => 0,)
				);
			}
			// set styles for table
			$styleArray = array(
				'font' => array(
					'bold' => true,
				)
			);
			$objPHPExcel->getActiveSheet()->getStyle('A' . $baris)->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->setCellValue('A' . $baris, 'Sub Total');
			$objPHPExcel->getActiveSheet()->mergeCells('A' . $baris . ':' . 'B' . $baris);

			$objPHPExcel->getActiveSheet()->setCellValue('D' . $baris, number_format($hitung_saldo_awal, 2, '.', ','));
			$objPHPExcel->getActiveSheet()->setCellValue('E' . $baris, number_format($hitung_harga_saldo_awal, 2, '.', ','));
			$objPHPExcel->getActiveSheet()->setCellValue('F' . $baris, number_format($hitung_jumlah_saldo_awal, 2, '.', ','));

			$objPHPExcel->getActiveSheet()->setCellValue('G' . $baris, number_format($hitung_mutasi_masuk, 2, '.', ','));
			$objPHPExcel->getActiveSheet()->setCellValue('H' . $baris, number_format($hitung_harga_mutasi_masuk, 2, '.', ','));
			$objPHPExcel->getActiveSheet()->setCellValue('I' . $baris, number_format($hitung_jumlah_mutasi_masuk, 2, '.', ','));

			$objPHPExcel->getActiveSheet()->setCellValue('J' . $baris, number_format($hitung_mutasi_keluar, 2, '.', ','));
			$objPHPExcel->getActiveSheet()->setCellValue('K' . $baris, number_format($hitung_harga_mutasi_keluar, 2, '.', ','));
			$objPHPExcel->getActiveSheet()->setCellValue('L' . $baris, number_format($hitung_jumlah_mutasi_keluar, 2, '.', ','));

			$objPHPExcel->getActiveSheet()->setCellValue('M' . $baris, number_format($hitung_mutasi_keluar, 2, '.', ','));
			$objPHPExcel->getActiveSheet()->setCellValue('N' . $baris, number_format($hitung_harga_mutasi_keluar, 2, '.', ','));
			$objPHPExcel->getActiveSheet()->setCellValue('O' . $baris, number_format($hitung_jumlah_mutasi_keluar, 2, '.', ','));

			$objPHPExcel->getActiveSheet()->setCellValue('P' . $baris, number_format($hitung_saldo_akhir, 2, '.', ','));
			$objPHPExcel->getActiveSheet()->setCellValue('Q' . $baris, number_format($hitung_harga_saldo_akhir, 2, '.', ','));
			$objPHPExcel->getActiveSheet()->setCellValue('R' . $baris, number_format($hitung_jumlah_saldo_akhir, 2, '.', ','));
			$baris = $baris + 1;
			$nomor = 1;
		}
		$baris = $baris + 3;
		$objPHPExcel->getActiveSheet()->setCellValue('B' . $baris, 'Mengetahui');
		$objPHPExcel->getActiveSheet()->getStyle('B' . $baris)->getAlignment()->applyFromArray(
			array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, 'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER, 'rotation'   => 0,)
		);
		$objPHPExcel->getActiveSheet()->mergeCells('B' . $baris . ':' . 'C' . $baris);
		$baris++;
		$objPHPExcel->getActiveSheet()->setCellValue('B' . $baris, 'Kepala UPTD Instalasi Farmasi dan');
		$objPHPExcel->getActiveSheet()->getStyle('B' . $baris)->getAlignment()->applyFromArray(
			array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, 'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER, 'rotation'   => 0,)
		);
		$objPHPExcel->getActiveSheet()->mergeCells('B' . $baris . ':' . 'C' . $baris);
		$baris++;
		$objPHPExcel->getActiveSheet()->setCellValue('B' . $baris, 'Perbekalan Kesehatan	
');
		$objPHPExcel->getActiveSheet()->getStyle('B' . $baris)->getAlignment()->applyFromArray(
			array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, 'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER, 'rotation'   => 0,)
		);
		$objPHPExcel->getActiveSheet()->mergeCells('B' . $baris . ':' . 'C' . $baris);
		$baris = $baris + 5;
		$objPHPExcel->getActiveSheet()->setCellValue('B' . $baris, 'Endah Rahmawati, S.F.Apt');
		$objPHPExcel->getActiveSheet()->getStyle('B' . $baris)->getAlignment()->applyFromArray(
			array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, 'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER, 'rotation'   => 0,)
		);
		$objPHPExcel->getActiveSheet()->mergeCells('B' . $baris . ':' . 'C' . $baris);
		$baris++;
		$objPHPExcel->getActiveSheet()->setCellValue('B' . $baris, 'NIP. 19800405 2008003 2 001');
		$objPHPExcel->getActiveSheet()->getStyle('B' . $baris)->getAlignment()->applyFromArray(
			array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, 'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER, 'rotation'   => 0,)
		);

		$objPHPExcel->getActiveSheet()->mergeCells('B' . $baris . ':' . 'C' . $baris);
		// die('finish');
		// foreach ($items as $item) {
		// 	# code...
		// 	for($x='A';$x<='F';$x++){
		// 		if($x=='A'){
		// 			$objPHPExcel->getActiveSheet()->getStyle($x.$baris)->getAlignment()->applyFromArray(
		// 				array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,'rotation'   => 0,));					
		// 		}else if($x=='B'){
		// 			$objPHPExcel->getActiveSheet()->getStyle($x.$baris)->getAlignment()->applyFromArray(
		// 				array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,'rotation'   => 0,));										
		// 		}else if($x=='C'){
		// 			$objPHPExcel->getActiveSheet()->getStyle($x.$baris)->getAlignment()->applyFromArray(
		// 				array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,'rotation'   => 0,));										
		// 		}else if($x=='D'){
		// 			$objPHPExcel->getActiveSheet()->getStyle($x.$baris)->getAlignment()->applyFromArray(
		// 				array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,'rotation'   => 0,));										
		// 		}else if($x=='E'){
		// 			$objPHPExcel->getActiveSheet()->getStyle($x.$baris)->getAlignment()->applyFromArray(
		// 				array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,'rotation'   => 0,));										
		// 		}else if($x=='F'){
		// 			$objPHPExcel->getActiveSheet()->getStyle($x.$baris)->getAlignment()->applyFromArray(
		// 				array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,'rotation'   => 0,));										
		// 		}
		// 		else if($x=='G'){
		// 			$objPHPExcel->getActiveSheet()->getStyle($x.$baris)->getAlignment()->applyFromArray(
		// 				array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,'rotation'   => 0,));										
		// 		}
		// 		else if($x=='H'){
		// 			$objPHPExcel->getActiveSheet()->getStyle($x.$baris)->getAlignment()->applyFromArray(
		// 				array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,'rotation'   => 0,));										
		// 		}

		// 		$objPHPExcel->getActiveSheet()->getStyle($x.$baris)->applyFromArray(array(
		// 			'font'    => array('name'      => 'calibri','horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
		// 			'size'		=>12,'color'     => array('rgb' => '000000')),'borders' => array('bottom'     => array('style' => PHPExcel_Style_Border::BORDER_THIN,
		// 			'color' => array('rgb' => '000000')),'top'     => array('style' => PHPExcel_Style_Border::BORDER_THIN,'color' => array('rgb' => '000000')),
		// 			'left'     => array('style' => PHPExcel_Style_Border::BORDER_THIN,'color' => array('rgb' => '000000')),'right'     => array('style' => PHPExcel_Style_Border::BORDER_THIN,
		// 			'color' => array('rgb' => '000000')))));
		// 	}
		// 	// $item['total_transaksi']=$this->mpenjualan->getTotalPenjualan($item['no_penjualan']);
		// 	$query=$this->db->query('select sum(qty_kcl*harga_pokok) as jumlah from apt_penerimaan_detail where no_penerimaan="'.$item['no_penerimaan'].'"');
		// 	$total=$query->row_array();
		// 	if ($item['posting']=="1") {
		// 		$item['posting'] = "Tutup Faktur";
		// 	}else{
		// 		$item['posting'] = "";
		// 	}
		// 	$objPHPExcel->getActiveSheet()->setCellValue ('A'.$baris,$nomor);
		// 	$objPHPExcel->getActiveSheet()->setCellValue ('B'.$baris,$item['no_penerimaan']);
		// 	$objPHPExcel->getActiveSheet()->setCellValue ('C'.$baris,$item['no_faktur']);
		// 	$objPHPExcel->getActiveSheet()->setCellValue ('D'.$baris,$item['nama']);
		// 	$objPHPExcel->getActiveSheet()->setCellValue ('E'.$baris,convertDate($item['tgl_penerimaan']));
		// 	$objPHPExcel->getActiveSheet()->setCellValue ('F'.$baris,$item['nama_unit_apt']);			
		// 	$objPHPExcel->getActiveSheet()->setCellValue ('G'.$baris,$item['posting']);			
		// 	$objPHPExcel->getActiveSheet()->setCellValue ('H'.$baris,number_format($total['jumlah']));
		// 	$nomor=$nomor+1; $baris=$baris+1;
		// }	
		$objWriter = IOFactory::createWriter($objPHPExcel, 'Excel5');
		$objWriter->save("download/lap_mutasi_triwulan.xls");
		header("Location: " . base_url() . "download/lap_mutasi_triwulan.xls");
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
