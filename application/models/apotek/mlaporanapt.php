<?
class Mlaporanapt extends CI_Model {

	function __construct() {
		
		parent::__construct();
	}

	function ambilData($table,$condition=""){
		if(!empty($condition)){
			$this->db->where($condition,null,false);
		}
		$query= $this->db->get($table);
		return $query->result_array();
	}

	function ambilItemData($table,$condition=""){
		if(!empty($condition)){
			$this->db->where($condition,null,false);
		}
		$query= $this->db->get($table);
		return $query->row_array();
	}

    function insert($table,$data) {
		$this->db->insert($table, $data);
		return $this->db->insert_id();
    }	

    function update($table,$data,$id) {
    	if(!empty($id)){
    		$this->db->where($id,null,false);
    	}
		
		$this->db->update($table, $data);
		return true;
    }	

    function delete($table,$id) {
		$this->db->where($id,null,false);
		$this->db->delete($table);
		return true;
    }	
	

	function getAllPenerimaanApotek($periodeawal,$periodeakhir,$kd_unit_apt,$kd_supplier){
		
		$periodeawal1=convertDate($periodeawal);
		$periodeakhir1=convertDate($periodeakhir);
		if($kd_unit_apt!=''){$kd_unit_apt=" and apt_penerimaan.kd_unit_apt='".$kd_unit_apt."'";}else{$kd_unit_apt='';}
		
		if($kd_supplier!=''){$kd_supplier=" and apt_supplier.kd_supplier='".$kd_supplier."'";}
		else{$kd_supplier='';} 
		$query=$this->db->query("select apt_unit.nama_unit_apt,apt_penerimaan.no_penerimaan,apt_penerimaan.no_faktur,date_format(apt_penerimaan.tgl_penerimaan,'%d-%m-%Y %H:%i:%s') as tgl_penerimaan,
								apt_penerimaan.tgl_tempo,apt_penerimaan.kd_supplier,apt_supplier.nama,apt_penerimaan_detail.kd_obat,apt_obat.nama_obat,apt_satuan_kecil.satuan_kecil, 
								apt_penerimaan_detail.qty_kcl,apt_penerimaan_detail.harga_beli,apt_penerimaan_detail.disc_prs,apt_penerimaan_detail.isidiskon,apt_penerimaan_detail.ppn_item
								from apt_penerimaan,apt_supplier,apt_penerimaan_detail,apt_satuan_kecil,apt_obat,apt_unit	
								where apt_penerimaan.kd_unit_apt=apt_unit.kd_unit_apt and apt_penerimaan.kd_supplier=apt_supplier.kd_supplier and apt_obat.kd_satuan_kecil=apt_satuan_kecil.kd_satuan_kecil and 
								date_format(apt_penerimaan.tgl_penerimaan,'%Y-%m-%d') between '$periodeawal1' and '$periodeakhir1' $kd_unit_apt 
								and apt_penerimaan_detail.no_penerimaan=apt_penerimaan.no_penerimaan and 
								apt_penerimaan_detail.kd_obat=apt_obat.kd_obat $kd_supplier order by apt_penerimaan.no_penerimaan");
		return $query->result_array();
	}
	
	function getAllPenjualanApotek($periodeawal,$periodeakhir,$shiftapt,$is_lunas,$resep){
		$periodeawal1=convertDate($periodeawal);
		$periodeakhir1=convertDate($periodeakhir);
		//$kd_unit_apt=$this->session->userdata('kd_unit_apt');
		
		if($shiftapt!=''){$a1=" and apt_penjualan.shiftapt='$shiftapt'";}
		else{$a1="";} $a=$a1;
		
		if($resep!=''){$b1=" and apt_penjualan.resep='$resep'";}
		else{$b1="";} $b=$b1;
		
		if($is_lunas!=''){$c1=" and apt_penjualan.is_lunas='$is_lunas'";}
		else{$c1="";} $c=$c1;
		
		
		
		$query=$this->db->query("select apt_penjualan.no_penjualan,date_format(apt_penjualan.tgl_penjualan,'%d-%m-%Y') as tgl_penjualan,apt_penjualan.nama_pasien,
								apt_penjualan.resep,apt_penjualan.total_transaksi,apt_penjualan.is_lunas from
								apt_penjualan where  date_format(apt_penjualan.tgl_penjualan,'%Y-%m-%d') between
								'$periodeawal1' and '$periodeakhir1'  $c 
								$a $b order by apt_penjualan.no_penjualan");
		return $query->result_array();
	}
	
	
	function getAllPersediaanApotek($stok,$isistok,$kd_unit_apt,$kd_golongan){
		$stok1="";
		if($stok==1){$stok1=">";}
		if($stok==2){$stok1="<";}
		if($stok==3){$stok1=">=";}
		if($stok==4){$stok1="<=";}
		if($stok==5){$stok1="=";}
		
		if($kd_unit_apt!='')
			$kd_unit_apt=" and apt_stok_unit.kd_unit_apt='$kd_unit_apt'"; 
		
		if($kd_golongan !='')
			$kd_golongan=" and apt_obat.kd_golongan='$kd_golongan'"; 

		if($isistok=='')
			$isistok=0;
		
	
		
		$query=$this->db->query("select apt_stok_unit.kd_obat,apt_obat.nama_obat,apt_satuan_kecil.satuan_kecil,apt_stok_unit.tgl_expire,sum(apt_stok_unit.jml_stok) as jml_stok,apt_stok_unit.harga_pokok,apt_unit.nama_unit_apt,apt_unit.kd_unit_apt,
								apt_obat.harga_beli,apt_obat.harga_apbd,apt_obat.harga_p3k,apt_obat.harga_buffer,apt_obat.harga_jpkmm,apt_obat.harga_program,apt_obat.harga_dak,apt_pabrik.nama_pabrik,apt_stok_unit.batch	
					from apt_obat,apt_satuan_kecil,apt_stok_unit,apt_unit,apt_golongan,apt_pabrik
					where apt_stok_unit.kd_obat=apt_obat.kd_obat and apt_stok_unit.kd_unit_apt=apt_unit.kd_unit_apt and apt_obat.kd_satuan_kecil=apt_satuan_kecil.kd_satuan_kecil and apt_stok_unit.kd_pabrik=apt_pabrik.kd_pabrik
					and apt_obat.kd_golongan=apt_golongan.kd_golongan $kd_golongan $kd_unit_apt
					and apt_stok_unit.jml_stok $stok1 $isistok  group by apt_unit.kd_unit_apt,apt_obat.kd_obat,apt_stok_unit.kd_milik,apt_stok_unit.kd_pabrik,apt_stok_unit.tgl_expire,apt_stok_unit.harga_pokok,apt_stok_unit.batch");
		return $query->result_array();
	}
	
	function getAllDistribusiApotek($periodeawal,$periodeakhir,$kd_unit_asal){
		$periodeawal1=convertDate($periodeawal);
		$periodeakhir1=convertDate($periodeakhir);
		$kd_unit_asal=$this->session->userdata('kd_unit_apt');
		$query=$this->db->query("select apt_distribusi_detail.no_distribusi,apt_distribusi.tgl_distribusi,apt_distribusi_detail.kd_obat,apt_obat.nama_obat,apt_satuan_kecil.satuan_kecil,
								apt_distribusi_detail.tgl_expire,apt_distribusi_detail.qty,apt_distribusi.kd_unit_tujuan from apt_distribusi,apt_distribusi_detail,apt_unit,apt_obat,apt_satuan_kecil 
								where apt_distribusi.no_distribusi=apt_distribusi_detail.no_distribusi and
								apt_distribusi.tgl_distribusi between '$periodeawal1' and '$periodeakhir1' and apt_distribusi.kd_unit_asal='$kd_unit_asal'
								and apt_distribusi_detail.kd_obat=apt_obat.kd_obat and apt_obat.kd_satuan_kecil=apt_satuan_kecil.kd_satuan_kecil
								and apt_distribusi.kd_unit_asal=apt_unit.kd_unit_apt
								order by apt_distribusi.no_distribusi asc");
		return $query->result_array();
	}
	
	/*function ambilData4($nama_obat){
		$query=$this->db->query("select kd_obat,nama_obat from apt_obat where nama_obat like '%$nama_obat%'");
		return $query->result_array();
	}*/
	
	function ambilData4($nama_obat){
		$kd_unit_apt=$this->session->userdata('kd_unit_apt');
		$query=$this->db->query("select distinct apt_stok_unit.kd_obat,apt_obat.nama_obat from apt_stok_unit,apt_obat,apt_unit where apt_stok_unit.kd_obat=apt_obat.kd_obat
								and apt_stok_unit.kd_unit_apt=apt_unit.kd_unit_apt and apt_stok_unit.kd_unit_apt='$kd_unit_apt' and apt_obat.nama_obat like '%$nama_obat%'");
		return $query->result_array();
	}
	
	function ambilData5($kd_obat){
		$kd_unit_apt=$this->session->userdata('kd_unit_apt');
		$query=$this->db->query("select distinct apt_stok_unit.kd_obat,apt_obat.nama_obat from apt_stok_unit,apt_obat,apt_unit where apt_stok_unit.kd_obat=apt_obat.kd_obat
								and apt_stok_unit.kd_unit_apt=apt_unit.kd_unit_apt and apt_stok_unit.kd_unit_apt='$kd_unit_apt' and apt_obat.kd_obat like '%$kd_obat%'");
		return $query->result_array();
	}
	
	function getKartuStok($kd_obat,$kd_unit_apt,$bulan,$tahun){
		
		$wow=$tahun.'-'.$bulan.'-01 00:00:00';
		$wow='01-'.$bulan.'-'.$tahun.' 00:00:00';
		//debugvar($kd_unit_apt);
		//kalo dy nerima dr unit lain, brrti pake kd_unit_tujuan
		//kalo dy ngasi ke unit lain, brrti pake kd_unit_asal
		/*select SYSDATE() as tgl,'Saldo Awal' as keterangan,'-' as unitvendor,'-' as no_bukti,'-' as masuk,'-' as keluar,'-' as kode,saldo_awal as saldo
			from apt_mutasi_obat where kd_obat='$kd_obat' and kd_unit_apt='$kd_unit_apt' and bulan='$bulan' and tahun='$tahun'*/
		switch ($bulan) {
			case '01':
				# code...
				$bulanInt=1;
				$bulankemarin=12;
				$tahunkemarin=$tahun-1;
				break;
			
			case '02':
				# code...
				$bulanInt=2;
				$bulankemarin='01';
				$tahunkemarin=$tahun;
				break;
			
			case '03':
				# code...
				$bulanInt=3;
				$bulankemarin='02';
				$tahunkemarin=$tahun;
				break;
			
			case '04':
				# code...
				$bulanInt=4;
				$bulankemarin='03';
				$tahunkemarin=$tahun;
				break;
			
			case '05':
				# code...
				$bulanInt=5;
				$bulankemarin='04';
				$tahunkemarin=$tahun;
				break;
			
			case '06':
				# code...
				$bulanInt=6;
				$bulankemarin='05';
				$tahunkemarin=$tahun;
				break;
			
			case '07':
				# code...
				$bulanInt=7;
				$bulankemarin='06';
				$tahunkemarin=$tahun;
				break;
			
			case '08':
				# code...
				$bulanInt=8;
				$bulankemarin='07';
				$tahunkemarin=$tahun;
				break;
			
			case '09':
				# code...
				$bulanInt=9;
				$bulankemarin='08';
				$tahunkemarin=$tahun;
				break;
			
			case '10':
				# code...
				$bulanInt=10;
				$bulankemarin='09';
				$tahunkemarin=$tahun;
				break;
			
			case '11':
				# code...
				$bulanInt=11;
				$bulankemarin='10';
				$tahunkemarin=$tahun;
				break;
			
			case '12':
				# code...
				$bulanInt=12;
				$bulankemarin='11';
				$tahunkemarin=$tahun;
				break;
			
			default:
				# code...
				debugvar('There is error, script will not work');
				break;
		}

		$query=$this->db->query("select 1 as urut,'$wow' as tgl,'Saldo Awal' as keterangan,'-' as unitvendor,'-' as no_bukti,'-' as masuk,'-' as keluar,'-' as kode,
								ifnull(sum(saldo_akhir),0) as saldo
								from apt_mutasi_obat,apt_obat,apt_unit where apt_mutasi_obat.kd_obat=apt_obat.kd_obat and apt_mutasi_obat.kd_unit_apt=apt_unit.kd_unit_apt and 
								apt_mutasi_obat.kd_unit_apt='$kd_unit_apt' and apt_obat.kd_obat='$kd_obat' and apt_mutasi_obat.tahun='$tahunkemarin' and apt_mutasi_obat.bulan='$bulankemarin' group by apt_mutasi_obat.kd_obat

								union all
								select 2 as urut, date_format(apt_penerimaan.tgl_penerimaan,'%d-%m-%Y %H:%i:%s') as tgl,concat(' ',apt_penerimaan.keterangan) as keterangan,apt_supplier.nama as unitvendor,apt_penerimaan.no_penerimaan as no_bukti,apt_penerimaan_detail.qty_kcl as masuk,
								'-' as keluar,'M' as kode,0 as saldo from apt_penerimaan,apt_penerimaan_detail,apt_supplier,apt_obat,apt_unit where apt_penerimaan.no_penerimaan=apt_penerimaan_detail.no_penerimaan and 
								apt_penerimaan.kd_unit_apt=apt_unit.kd_unit_apt and apt_penerimaan.kd_supplier=apt_supplier.kd_supplier and apt_penerimaan_detail.kd_obat=apt_obat.kd_obat and apt_obat.kd_obat='$kd_obat' and
								apt_penerimaan.kd_unit_apt='$kd_unit_apt' and month(apt_penerimaan.tgl_penerimaan)='$bulan' and year(apt_penerimaan.tgl_penerimaan)='$tahun' and posting=1 
								union all
								select 2 as urut,date_format(apt_distribusi.tgl_distribusi,'%d-%m-%Y %H:%i:%s') as tgl,'Penerimaan dari Unit' as keterangan,apt_distribusi.kd_unit_asal as unitvendor,apt_distribusi.no_distribusi as no_bukti,apt_distribusi_detail.qty as masuk, 
                                '-' as keluar, 'M' as kode, 0 as saldo from apt_unit,apt_distribusi,apt_distribusi_detail,apt_obat 
                                where apt_distribusi.no_distribusi=apt_distribusi_detail.no_distribusi and apt_distribusi.kd_unit_tujuan=apt_unit.kd_unit_apt and apt_distribusi_detail.kd_obat=apt_obat.kd_obat
                                and apt_obat.kd_obat='$kd_obat' and apt_distribusi.kd_unit_tujuan='$kd_unit_apt' and month(apt_distribusi.tgl_distribusi)='$bulan' and year(apt_distribusi.tgl_distribusi)='$tahun'
								union all
								select 2 as urut,apt_distribusi.tgl_distribusi as tgl,'Pengeluaran ke Unit' as keterangan,apt_distribusi.kd_unit_tujuan as unitvendor,apt_distribusi.no_distribusi as no_bukti,'-' as masuk,
								apt_distribusi_detail.qty as keluar,'K' as kode,0 as saldo from apt_distribusi,apt_distribusi_detail,apt_unit,apt_obat where apt_distribusi.no_distribusi=apt_distribusi_detail.no_distribusi
								and apt_distribusi.kd_unit_asal=apt_unit.kd_unit_apt and apt_distribusi_detail.kd_obat=apt_obat.kd_obat and apt_obat.kd_obat='$kd_obat' and apt_distribusi.kd_unit_asal='$kd_unit_apt' and
								month(apt_distribusi.tgl_distribusi)='$bulan' and year(apt_distribusi.tgl_distribusi)='$tahun' 
								
								union all
								select 2 as urut,date_format(apt_disposal.tanggal,'%d-%m-%Y %H:%i:%s') as tgl,'Karantina Obat' as keterangan,'' as unitvendor,apt_disposal.no_disposal as no_bukti,'-' as masuk,
								apt_disposal_detail.qty as keluar,'K' as kode,0 as saldo from apt_disposal,apt_disposal_detail,apt_obat where apt_disposal.no_disposal=apt_disposal_detail.no_disposal
								and apt_disposal_detail.kd_obat=apt_obat.kd_obat and apt_obat.kd_obat='$kd_obat' and approval=1 and apt_disposal_detail.kd_unit_apt='$kd_unit_apt' and
								month(apt_disposal.tanggal)='$bulan' and year(apt_disposal.tanggal)='$tahun' 

								union all
								select 2 as urut,date_format(apt_penjualan.tgl_penjualan,'%d-%m-%Y %H:%i:%s') as tgl,'Pengeluaran Ke Puskesmas' as keterangan,gfk_puskesmas.nama as unitvendor,apt_penjualan.no_penjualan as no_bukti, '-' as masuk,
								apt_penjualan_detail.qty as keluar,'K' as kode,0 as saldo from apt_penjualan,apt_penjualan_detail,apt_unit,apt_obat,gfk_puskesmas where apt_penjualan.no_penjualan=apt_penjualan_detail.no_penjualan and
								apt_penjualan_detail.kd_obat=apt_obat.kd_obat and apt_obat.kd_obat='$kd_obat' and apt_penjualan.customer_id=gfk_puskesmas.id and apt_penjualan_detail.kd_unit_apt=apt_unit.kd_unit_apt and apt_penjualan_detail.kd_unit_apt='$kd_unit_apt' 
                                and month(apt_penjualan.tgl_penjualan)='$bulan' and year(apt_penjualan.tgl_penjualan)='$tahun'
								union all
								select 2 as urut,date_format(history_perubahan_stok.tanggal,'%d-%m-%Y %H:%i:%s') as tgl,'Stokopname' as keterangan,history_perubahan_stok.kd_unit_apt as unitvendor,history_perubahan_stok.nomor as no_bukti,
								sum(history_perubahan_stok.stok_baru) as masuk,'-' as keluar,'S' as kode,0 as saldo from history_perubahan_stok,apt_unit,apt_obat where 
								history_perubahan_stok.kd_obat=apt_obat.kd_obat and history_perubahan_stok.kd_unit_apt=apt_unit.kd_unit_apt and history_perubahan_stok.kd_unit_apt='$kd_unit_apt'
								and history_perubahan_stok.kd_obat='$kd_obat' and month(history_perubahan_stok.tanggal)='$bulan' and year(history_perubahan_stok.tanggal)='$tahun' order by tgl,urut");
								//order by tgl");
		return $query->result_array();
	}
	
	function getKartuStokBatch($kd_obat,$kd_unit_apt){
		
		$query = $this->db->select('obat_history.kode_obat,obat_history.status,obat_history.tanggal,ifnull(apt_supplier.nama,ifnull(gfk_puskesmas.nama,"SO")) as unitvendor,id_join,obat_history.qty',false)
		->join('apt_penerimaan','obat_history.id_join=apt_penerimaan.no_penerimaan','left')
		->join('apt_supplier','apt_penerimaan.kd_supplier=apt_supplier.kd_supplier','left')
		->join('apt_penjualan','obat_history.id_join=apt_penjualan.no_penjualan','left')
		->join('gfk_puskesmas','apt_penjualan.customer_id=gfk_puskesmas.id','left')
		->join('apt_disposal','obat_history.id_join=apt_disposal.no_disposal','left')
					->order_by('obat_history.tanggal','asc')
					->order_by('obat_history.status','desc')
					->get_where('obat_history',array('kode_obat'=>$kd_obat,'obat_history.kd_unit_apt' => $kd_unit_apt));

		return $query->result_array();
	}

	function getObat($kd_unit_apt,$bulan,$tahun){
		
								
		$query=$this->db->query("select apt_obat.kd_obat,apt_obat.nama_obat from apt_obat,apt_penerimaan,apt_penerimaan_detail,apt_unit where apt_obat.kd_obat=apt_penerimaan_detail.kd_obat
								and apt_penerimaan.no_penerimaan=apt_penerimaan_detail.no_penerimaan and apt_unit.kd_unit_apt=apt_penerimaan.kd_unit_apt
								and apt_penerimaan.kd_unit_apt='$kd_unit_apt' and month(apt_penerimaan.tgl_penerimaan)='$bulan' and year(apt_penerimaan.tgl_penerimaan)='$tahun'
								union 
								select apt_obat.kd_obat,apt_obat.nama_obat from apt_obat,apt_distribusi,apt_distribusi_detail,apt_unit where apt_obat.kd_obat=apt_distribusi_detail.kd_obat
								and apt_distribusi.no_distribusi=apt_distribusi_detail.no_distribusi and apt_unit.kd_unit_apt=apt_distribusi.kd_unit_asal 
								and apt_distribusi.kd_unit_asal='$kd_unit_apt' and month(apt_distribusi.tgl_distribusi)='$bulan' and year(apt_distribusi.tgl_distribusi)='$tahun'
								union
								select apt_obat.kd_obat,apt_obat.nama_obat from apt_obat,apt_penjualan,apt_penjualan_detail,apt_unit where apt_obat.kd_obat=apt_penjualan_detail.kd_obat
								and apt_penjualan.no_penjualan=apt_penjualan_detail.no_penjualan and apt_unit.kd_unit_apt=apt_penjualan.kd_unit_apt and 
								apt_penjualan.kd_unit_apt='$kd_unit_apt' and month(apt_penjualan.tgl_penjualan)='$bulan' and year(apt_penjualan.tgl_penjualan)='$tahun'
								union
                                select apt_obat.kd_obat,apt_obat.nama_obat from apt_obat,history_perubahan_stok,apt_unit where apt_obat.kd_obat=history_perubahan_stok.kd_obat 
                                and history_perubahan_stok.kd_unit_apt=apt_unit.kd_unit_apt and history_perubahan_stok.kd_unit_apt='$kd_unit_apt' and month(history_perubahan_stok.tanggal)='$bulan'
                                and year(history_perubahan_stok.tanggal)='$tahun'
								union
								select apt_obat.kd_obat,apt_obat.nama_obat from apt_obat,apt_stok_unit,apt_unit where apt_obat.kd_obat=apt_stok_unit.kd_obat and apt_stok_unit.kd_unit_apt=apt_unit.kd_unit_apt
                                and apt_stok_unit.kd_unit_apt='$kd_unit_apt'
								");
		return $query->result_array();
	}
	
	function ambilMutasiObat($kd_unit_apt,$bulan,$tahun){
		$query=$this->db->query("select apt_mutasi_obat.saldo_awal,apt_mutasi_obat.kd_obat,apt_obat.nama_obat,apt_mutasi_obat.harga_beli,apt_mutasi_obat.in_pbf,apt_mutasi_obat.in_unit,
								apt_mutasi_obat.retur_pbf,apt_mutasi_obat.out_jual,apt_mutasi_obat.out_unit,apt_mutasi_obat.retur_jual,apt_mutasi_obat.saldo_akhir,apt_mutasi_obat.stok_opname 
								from apt_obat,apt_mutasi_obat,apt_unit where apt_obat.kd_obat=apt_mutasi_obat.kd_obat and apt_mutasi_obat.kd_unit_apt=apt_unit.kd_unit_apt 
								and apt_mutasi_obat.kd_unit_apt='$kd_unit_apt' and apt_mutasi_obat.bulan='$bulan' and apt_mutasi_obat.tahun='$tahun'");
		return $query->result_array();
	}
	
	function getSaldoAwal($b,$a1,$nama,$kd_unit_apt){
		$query=$this->db->query("select apt_mutasi_obat.saldo_akhir as saldo_awal from apt_mutasi_obat,apt_obat,apt_unit where apt_obat.kd_obat=apt_mutasi_obat.kd_obat and 
								apt_mutasi_obat.kd_unit_apt=apt_unit.kd_unit_apt and apt_mutasi_obat.tahun='$b' and apt_mutasi_obat.bulan='$a1' and 
								apt_obat.nama_obat='$nama' and apt_mutasi_obat.kd_unit_apt='$kd_unit_apt'");
		 $item=$query->row_array();
		 if(empty($item)) return 0;
		 return $item['saldo_awal'];
	}
	
	function getHarga($kd_unit_apt,$nama){
		$query=$this->db->query("select apt_stok_unit.harga_pokok from apt_obat,apt_stok_unit,apt_unit where apt_obat.kd_obat=apt_stok_unit.kd_obat and
								apt_stok_unit.kd_unit_apt=apt_unit.kd_unit_apt and apt_stok_unit.kd_unit_apt='$kd_unit_apt' and apt_obat.nama_obat='$nama'");
		$item=$query->row_array();
		if(empty($item)) return 0;
		 return $item['harga_pokok'];
	}
	
	function getInPbf($kd_unit_apt,$bulan,$tahun,$nama){
		$query=$this->db->query("select sum(apt_penerimaan_detail.qty_kcl) as in_pbf from apt_obat,apt_penerimaan,apt_penerimaan_detail,apt_unit 
								where apt_penerimaan.no_penerimaan=apt_penerimaan_detail.no_penerimaan and apt_obat.kd_obat=apt_penerimaan_detail.kd_obat
								and apt_penerimaan.kd_unit_apt=apt_unit.kd_unit_apt and apt_penerimaan.kd_unit_apt='$kd_unit_apt' and month(apt_penerimaan.tgl_penerimaan)='$bulan' 
								and year(apt_penerimaan.tgl_penerimaan)='$tahun' and apt_obat.nama_obat='$nama'");
		$item=$query->row_array();
		if(empty($item)) return 0;
		return $item['in_pbf'];
	}
	
	function getInUnit($kd_unit_apt,$bulan,$tahun,$nama){
		$query=$this->db->query("select sum(apt_distribusi_detail.qty) as in_unit from apt_obat,apt_distribusi,apt_distribusi_detail,apt_unit 
								where apt_distribusi.no_distribusi=apt_distribusi_detail.no_distribusi and apt_obat.kd_obat=apt_distribusi_detail.kd_obat
								and apt_distribusi.kd_unit_tujuan=apt_unit.kd_unit_apt and apt_distribusi.kd_unit_tujuan='$kd_unit_apt' and month(apt_distribusi.tgl_distribusi)='$bulan' 
								and year(apt_distribusi.tgl_distribusi)='$tahun' and apt_obat.nama_obat='$nama'");
		$item=$query->row_array();
		if(empty($item)) return 0;
		return $item['in_unit'];
	}
	
	function getReturPbf($kd_unit_apt,$bulan,$tahun,$nama){
		$query=$this->db->query("select sum(apt_retur_obat_detail.qty_kcl) as retur_pbf from apt_obat,apt_retur_obat,apt_retur_obat_detail,apt_unit
								where apt_obat.kd_obat=apt_retur_obat_detail.kd_obat and apt_retur_obat.no_retur=apt_retur_obat_detail.no_retur and 
								apt_retur_obat_detail.kd_unit_apt=apt_unit.kd_unit_apt and apt_retur_obat_detail.kd_unit_apt='$kd_unit_apt' and month(apt_retur_obat.tgl_retur)='$bulan' and year(apt_retur_obat.tgl_retur)='$tahun'
								and apt_obat.nama_obat='$nama'");
		$item=$query->row_array();
		if(empty($item)) return 0;
		return $item['retur_pbf'];
	}
	
	function getOutJual($kd_unit_apt,$bulan,$tahun,$nama){
		$query=$this->db->query("select sum(apt_penjualan_detail.qty) as out_jual from apt_obat,apt_penjualan,apt_penjualan_detail,apt_unit
								where apt_obat.kd_obat=apt_penjualan_detail.kd_obat and apt_penjualan.no_penjualan=apt_penjualan_detail.no_penjualan
								and apt_penjualan.kd_unit_apt=apt_unit.kd_unit_apt and apt_penjualan.kd_unit_apt=apt_penjualan_detail.kd_unit_apt
								and apt_penjualan.kd_unit_apt='$kd_unit_apt' and month(apt_penjualan.tgl_penjualan)='$bulan' and year(apt_penjualan.tgl_penjualan)='$tahun'
								and apt_obat.nama_obat='$nama'");
		$item=$query->row_array();
		if(empty($item)) return 0;
		return $item['out_jual'];
	}
	
	function getHargaJual($kd_unit_apt,$bulan,$tahun,$nama){
		$query=$this->db->query("select apt_penjualan_detail.harga_jual from apt_obat,apt_penjualan,apt_penjualan_detail,apt_unit
								where apt_obat.kd_obat=apt_penjualan_detail.kd_obat and apt_penjualan.no_penjualan=apt_penjualan_detail.no_penjualan
								and apt_penjualan.kd_unit_apt=apt_unit.kd_unit_apt and apt_penjualan.kd_unit_apt=apt_penjualan_detail.kd_unit_apt
								and apt_penjualan.kd_unit_apt='$kd_unit_apt' and month(apt_penjualan.tgl_penjualan)='$bulan' and year(apt_penjualan.tgl_penjualan)='$tahun'
								and apt_obat.nama_obat='$nama'");
		$item=$query->row_array();
		if(empty($item)) return 0;
		return $item['harga_jual'];
	}
	
	function getOutUnit($kd_unit_apt,$bulan,$tahun,$nama){
		$query=$this->db->query("select sum(apt_distribusi_detail.qty) as out_unit from apt_obat,apt_distribusi,apt_distribusi_detail,apt_unit
								where apt_obat.kd_obat=apt_distribusi_detail.kd_obat and apt_distribusi.no_distribusi=apt_distribusi_detail.no_distribusi
								and apt_distribusi.kd_unit_asal=apt_unit.kd_unit_apt and apt_distribusi.kd_unit_asal='$kd_unit_apt' and month(apt_distribusi.tgl_distribusi)='$bulan'
								and year(apt_distribusi.tgl_distribusi)='$tahun' and apt_obat.nama_obat='$nama'");
		$item=$query->row_array();
		if(empty($item)) return 0;
		return $item['out_unit'];
	}
	
	function isNumberExist($kd_unit_apt,$bulan,$tahun){
		$this->db->where('kd_unit_apt',$kd_unit_apt);
		$this->db->where('bulan',$bulan);
		$this->db->where('tahun',$tahun);
		$query=$this->db->get('apt_mutasi_obat');
		$count=$query->num_rows();
		if($count){
			return true;
		}
		return false;
	}
	
	function isObatExist($kd_obat,$bulan,$tahun){
		$kd_unit_apt=$this->session->userdata('kd_unit_apt');
		$this->db->where('kd_unit_apt',$kd_unit_apt);
		$this->db->where('kd_obat',$kd_obat);
		$this->db->where('bulan',$bulan);
		$this->db->where('tahun',$tahun);
		$query=$this->db->get('apt_mutasi_obat');
		$count=$query->num_rows();
		if($count){
			return true;
		}
		return false;
	}
	
	function namaUnit($kd_unit_apt){
		$query=$this->db->query("select nama_unit_apt from apt_unit where kd_unit_apt='$kd_unit_apt'");
		$namaunit=$query->row_array();
		if(empty($namaunit)) return 0;
		return $namaunit['nama_unit_apt'];
	}
	
	function namaObat($kd_obat){
		$query=$this->db->query("select nama_obat from apt_obat where kd_obat='$kd_obat'");
		$namaobat=$query->row_array();
		if(empty($namaobat)) return 0;
		return $namaobat['nama_obat'];
	}
	
	function getStokopname($kd_unit_apt,$bulan,$tahun,$nama){
		$query=$this->db->query("select sum(history_perubahan_stok.qty) as qty from apt_obat,history_perubahan_stok,apt_unit 
								where apt_obat.kd_obat=history_perubahan_stok.kd_obat and history_perubahan_stok.kd_unit_apt=apt_unit.kd_unit_apt
								and history_perubahan_stok.kd_unit_apt='$kd_unit_apt' and month(history_perubahan_stok.tanggal)='$bulan' and
								year(history_perubahan_stok.tanggal)='$tahun' and apt_obat.nama_obat='$nama'");
		$item=$query->row_array();
		if(empty($item)) return 0;
		return $item['qty'];
	}
	
	// function ambilstok($kd_obat,$kd_unit_apt){
	function ambilstok($kd_obat){
		$kd_unit_apt=$this->session->userdata('kd_unit_apt');
		$query=$this->db->query("select sum(jml_stok) as jml_stok from apt_stok_unit where kd_obat='$kd_obat' and kd_unit_apt='$kd_unit_apt'");
		$jml_stok=$query->row_array();
		if(empty($jml_stok)) return 0;
		return $jml_stok['jml_stok'];
	}
	
	function ambilout($kd_obat,$bulan,$tahun){
		$kd_unit_apt=$this->session->userdata('kd_unit_apt');
		$query=$this->db->query("select out_unit as a from apt_mutasi_obat where kd_obat='$kd_obat' and kd_unit_apt='$kd_unit_apt' and bulan='$bulan' and tahun='$tahun'");
		$a=$query->row_array();
		if(empty($a)) return 0;
		return $a['a'];
	}
	
	function ambilin($kd_obat,$bulan,$tahun){
		$kd_unit_apt=$this->session->userdata('kd_unit_apt');
		$query=$this->db->query("select in_pbf as b from apt_mutasi_obat where kd_obat='$kd_obat' and kd_unit_apt='$kd_unit_apt' and bulan='$bulan' and tahun='$tahun'");
		$b=$query->row_array();
		if(empty($b)) return 0;
		return $b['b'];
	}
	
	function ambilHargaBeli($kd_unit_apt,$kd_obat){
		$kd_unit_apt=$this->session->userdata('kd_unit_apt');
		$query=$this->db->query("select harga_pokok from apt_stok_unit where kd_unit_apt='$kd_unit_apt' and kd_obat='$kd_obat'");
		$harga_pokok=$query->row_array();
		if(empty($harga_pokok)) return 0;
		return $harga_pokok['harga_pokok'];
	}
	
	function getDistribusi($bulan,$tahun){ 
		$kd_unit_apt=$this->session->userdata('kd_unit_apt');
		/*$query=$this->db->query("select apt_obat.kd_obat,apt_obat.nama_obat,apt_distribusi.tgl_distribusi,apt_distribusi_detail.qty,apt_stok_unit.harga_pokok as harga_beli from apt_obat,apt_distribusi,apt_distribusi_detail,
                                apt_unit,apt_stok_unit where apt_obat.kd_obat=apt_distribusi_detail.kd_obat and apt_distribusi.kd_unit_asal=apt_stok_unit.kd_unit_apt
								and apt_distribusi.no_distribusi=apt_distribusi_detail.no_distribusi and apt_unit.kd_unit_apt=apt_distribusi.kd_unit_asal 
								and apt_stok_unit.kd_obat=apt_obat.kd_obat 
								and apt_distribusi.kd_unit_asal='$kd_unit_apt' and month(apt_distribusi.tgl_distribusi)='$bulan' and year(apt_distribusi.tgl_distribusi)='$tahun'");*/
		$query=$this->db->query("select apt_obat.kd_obat,apt_obat.nama_obat,apt_distribusi.tgl_distribusi,sum(apt_distribusi_detail.qty) as qty,apt_stok_unit.harga_pokok as harga_beli from apt_obat,apt_distribusi,apt_distribusi_detail,
                                apt_unit,apt_stok_unit where apt_obat.kd_obat=apt_distribusi_detail.kd_obat and apt_distribusi.kd_unit_asal=apt_stok_unit.kd_unit_apt
								and apt_distribusi.no_distribusi=apt_distribusi_detail.no_distribusi and apt_unit.kd_unit_apt=apt_distribusi.kd_unit_asal 
								and apt_stok_unit.kd_obat=apt_obat.kd_obat and apt_distribusi.kd_unit_asal='$kd_unit_apt' and month(apt_distribusi.tgl_distribusi)='$bulan' and year(apt_distribusi.tgl_distribusi)='$tahun'
								group by apt_obat.kd_obat");
		return $query->result_array();
	}
	
	function getDistribusi1($bulan,$tahun){
		$kd_unit_apt=$this->session->userdata('kd_unit_apt');
		/*$query=$this->db->query("select apt_obat.kd_obat,apt_obat.nama_obat,apt_distribusi.tgl_distribusi,apt_distribusi_detail.qty,apt_stok_unit.harga_pokok as harga_beli from apt_obat,apt_distribusi,apt_distribusi_detail,
                                apt_unit,apt_stok_unit where apt_obat.kd_obat=apt_distribusi_detail.kd_obat and apt_distribusi.kd_unit_tujuan=apt_stok_unit.kd_unit_apt
								and apt_distribusi.no_distribusi=apt_distribusi_detail.no_distribusi and apt_unit.kd_unit_apt=apt_distribusi.kd_unit_tujuan 
								and apt_stok_unit.kd_obat=apt_obat.kd_obat 
								and apt_distribusi.kd_unit_tujuan='$kd_unit_apt' and month(apt_distribusi.tgl_distribusi)='$bulan' and year(apt_distribusi.tgl_distribusi)='$tahun'");*/
		$query=$this->db->query("select apt_obat.kd_obat,apt_obat.nama_obat,apt_distribusi.tgl_distribusi,sum(apt_distribusi_detail.qty) as qty,apt_stok_unit.harga_pokok as harga_beli from apt_obat,apt_distribusi,apt_distribusi_detail,
                                apt_unit,apt_stok_unit where apt_obat.kd_obat=apt_distribusi_detail.kd_obat and apt_distribusi.kd_unit_tujuan=apt_stok_unit.kd_unit_apt
								and apt_distribusi.no_distribusi=apt_distribusi_detail.no_distribusi and apt_unit.kd_unit_apt=apt_distribusi.kd_unit_tujuan 
								and apt_stok_unit.kd_obat=apt_obat.kd_obat and apt_distribusi.kd_unit_tujuan='$kd_unit_apt' and month(apt_distribusi.tgl_distribusi)='$bulan' and year(apt_distribusi.tgl_distribusi)='$tahun'
								group by apt_obat.kd_obat");
		return $query->result_array();
	}
	
	function getPenerimaan($bulan,$tahun){
		$kd_unit_apt=$this->session->userdata('kd_unit_apt');
		$query=$this->db->query("select apt_penerimaan_detail.kd_obat,apt_penerimaan.tgl_penerimaan,apt_penerimaan_detail.harga_beli,sum(apt_penerimaan_detail.qty_kcl) as qty_kcl from 
								apt_obat,apt_penerimaan,apt_penerimaan_detail,apt_unit where apt_penerimaan.no_penerimaan=apt_penerimaan_detail.no_penerimaan 
								and apt_penerimaan_detail.kd_obat=apt_obat.kd_obat and apt_penerimaan.kd_unit_apt=apt_unit.kd_unit_apt and
								apt_penerimaan.kd_unit_apt='$kd_unit_apt' and month(apt_penerimaan.tgl_penerimaan)='$bulan' and year(apt_penerimaan.tgl_penerimaan)='$tahun'
								group by apt_obat.kd_obat");
		return $query->result_array();
	}
	
	function getPenjualan($bulan,$tahun){
		$kd_unit_apt=$this->session->userdata('kd_unit_apt');
		/*$query=$this->db->query("select apt_penjualan_detail.kd_obat,apt_penjualan.tgl_penjualan,apt_penjualan_detail.qty,
								apt_penjualan_detail.harga_jual from apt_obat,apt_penjualan,apt_penjualan_detail,apt_unit 
								where apt_penjualan.no_penjualan=apt_penjualan_detail.no_penjualan and 
								apt_penjualan_detail.kd_obat=apt_obat.kd_obat and apt_penjualan.kd_unit_apt=apt_unit.kd_unit_apt 
								and apt_penjualan.kd_unit_apt='$kd_unit_apt' and month(apt_penjualan.tgl_penjualan)='$bulan' and 
								year(apt_penjualan.tgl_penjualan)='$tahun'");*/
		$query=$this->db->query("select apt_penjualan_detail.kd_obat,apt_penjualan.tgl_penjualan,sum(apt_penjualan_detail.qty) as qty,
								apt_penjualan_detail.harga_jual from apt_obat,apt_penjualan,apt_penjualan_detail,apt_unit 
								where apt_penjualan.no_penjualan=apt_penjualan_detail.no_penjualan and 
								apt_penjualan_detail.kd_obat=apt_obat.kd_obat and apt_penjualan.kd_unit_apt=apt_unit.kd_unit_apt 
								and apt_penjualan.kd_unit_apt='$kd_unit_apt' and month(apt_penjualan.tgl_penjualan)='$bulan' and 
								year(apt_penjualan.tgl_penjualan)='$tahun'
								group by apt_obat.kd_obat");
		return $query->result_array();
	}
	
	function getReturPbf1($bulan,$tahun){
		$kd_unit_apt=$this->session->userdata('kd_unit_apt');
		$query=$this->db->query("select apt_retur_obat_detail.kd_obat,apt_retur_obat.tgl_retur,sum(apt_retur_obat_detail.qty_kcl) as qty_kcl
								from apt_obat,apt_retur_obat,apt_retur_obat_detail,apt_unit 
								where apt_retur_obat.no_retur=apt_retur_obat_detail.no_retur and 
								apt_retur_obat_detail.kd_obat=apt_obat.kd_obat and apt_retur_obat_detail.kd_unit_apt=apt_unit.kd_unit_apt 
								and apt_retur_obat_detail.kd_unit_apt='$kd_unit_apt' and month(apt_retur_obat.tgl_retur)='$bulan' and 
								year(apt_retur_obat.tgl_retur)='$tahun'
								group by apt_obat.kd_obat");
		return $query->result_array();
	}
	
		function getMutasiObatTriwulan($tahun,$triwulan){
		if ($triwulan=='1') {
			$bulan_awal = '01';
			$bulan_akhir = '03';
			$triwulan = "and apt_mutasi_obat.bulan in ('01','02','03')";
		}else if($triwulan=='2'){
			$bulan_awal = '04';
			$bulan_akhir = '06';
			$triwulan = "and apt_mutasi_obat.bulan in ('04','05','06')";
		}
		else if($triwulan=='3'){
			$bulan_awal = '07';
			$bulan_akhir = '09';
			$triwulan = "and apt_mutasi_obat.bulan in ('07','08','09')";
		}
		else if($triwulan=='4'){
			$bulan_awal = '10';
			$bulan_akhir = '12';
			$triwulan = "and apt_mutasi_obat.bulan in ('10','11','12')";
		}
		// $query=$this->db->query("select apt_satuan_kecil.satuan_kecil,apt_mutasi_obat.kd_obat,apt_mutasi_obat.kd_unit_apt,apt_obat.nama_obat,ifnull(sum(apt_mutasi_obat.saldo_awal),0) as saldo_awal,ifnull(sum(apt_mutasi_obat.in_pbf),0) as in_pbf,
		// ifnull(sum(apt_mutasi_obat.out_jual),0) as out_jual,ifnull(sum(apt_mutasi_obat.out_disposal),0) as out_disposal,ifnull(sum(apt_mutasi_obat.saldo_akhir),0) as saldo_akhir,ifnull(sum(apt_mutasi_obat.harga_beli),0) as harga_beli,
		// ifnull(sum(apt_mutasi_obat.stok_opname),0) as stok_opname
		// from apt_mutasi_obat,apt_obat,apt_satuan_kecil where apt_obat.kd_satuan_kecil=apt_satuan_kecil.kd_satuan_kecil and obat.saldo_awal),0) as saldo_awal,ifnull(sum(apt_mutasi_obat.in_pbf),0) as in_pbf,
		// ifnull(sum(apt_mutasi_obat.out_jual),0) as out_jual,ifnull(sum(apt_mutasi_obat.out_disposal),0) as out_disposaapt_mutasi_obat.kd_obat=apt_obat.kd_obat and apt_mutasi_obat.tahun='$tahun'
		// 	$triwulan
		// group by apt_mutasi_obat.kd_obat,apt_mutasi_obat.harga_beli
		// having saldo_awal > 0 or in_pbf > 0 or out_jual > 0 or out_disposal > 0 or saldo_akhir >0  or stok_opname > 0
		// order by apt_mutasi_obat.kd_obat");
		$query=$this->db->query("select apt_satuan_kecil.satuan_kecil,apt_mutasi_obat.kd_obat,apt_mutasi_obat.kd_unit_apt,apt_obat.nama_obat,ifnull(sum(if(apt_mutasi_obat.bulan='".$bulan_awal."',apt_mutasi_obat.saldo_awal,0)),0) as saldo_awal,ifnull(sum(apt_mutasi_obat.in_pbf),0) as in_pbf,
		ifnull(sum(apt_mutasi_obat.out_jual),0) as out_jual,ifnull(sum(apt_mutasi_obat.out_disposal),0) as out_disposal,ifnull(sum(if(apt_mutasi_obat.bulan='".$bulan_akhir."',apt_mutasi_obat.saldo_akhir,0)),0) as saldo_akhir,apt_mutasi_obat.harga_beli,
		ifnull(sum(apt_mutasi_obat.stok_opname),0) as stok_opname
		from apt_mutasi_obat,apt_obat,apt_satuan_kecil where apt_obat.kd_satuan_kecil=apt_satuan_kecil.kd_satuan_kecil and apt_mutasi_obat.kd_obat=apt_obat.kd_obat and apt_mutasi_obat.tahun=$tahun
			$triwulan
		group by apt_mutasi_obat.kd_obat,apt_mutasi_obat.kd_unit_apt,apt_mutasi_obat.harga_beli
		having saldo_awal > 0 or in_pbf > 0 or out_jual > 0 or out_disposal > 0 or saldo_akhir >0  or stok_opname > 0
		order by apt_mutasi_obat.kd_obat");
		return $query->result_array();
	}

	function getMutasiObat($kd_unit_apt,$bulan,$tahun){
				if(empty($kd_unit_apt)){
					$query=$this->db->query("select apt_satuan_kecil.satuan_kecil,apt_mutasi_obat.kd_obat,apt_obat.nama_obat,ifnull(sum(apt_mutasi_obat.saldo_awal),0) as saldo_awal,ifnull(sum(apt_mutasi_obat.in_pbf),0) as in_pbf,
					ifnull(sum(apt_mutasi_obat.out_jual),0) as out_jual,ifnull(sum(apt_mutasi_obat.out_disposal),0) as out_disposal,ifnull(sum(apt_mutasi_obat.saldo_akhir),0) as saldo_akhir,ifnull(sum(apt_mutasi_obat.harga_beli),0) as harga_beli,
					ifnull(sum(apt_mutasi_obat.stok_opname),0) as stok_opname
					from apt_mutasi_obat,apt_obat,apt_satuan_kecil where apt_obat.kd_satuan_kecil=apt_satuan_kecil.kd_satuan_kecil and apt_mutasi_obat.kd_obat=apt_obat.kd_obat and
					apt_mutasi_obat.bulan='$bulan' and apt_mutasi_obat.tahun='$tahun'
					group by apt_mutasi_obat.kd_obat,apt_mutasi_obat.harga_beli
					having saldo_awal > 0 or in_pbf > 0 or out_jual > 0 or out_disposal > 0 or saldo_akhir >0  or stok_opname > 0
					order by apt_mutasi_obat.kd_obat");

				}else{
					$query=$this->db->query("select apt_satuan_kecil.satuan_kecil,apt_mutasi_obat.kd_obat,apt_obat.nama_obat,ifnull(sum(apt_mutasi_obat.saldo_awal),0) as saldo_awal,ifnull(sum(apt_mutasi_obat.in_pbf),0) as in_pbf,
					ifnull(sum(apt_mutasi_obat.out_jual),0) as out_jual,ifnull(sum(apt_mutasi_obat.out_disposal),0) as out_disposal,ifnull(sum(apt_mutasi_obat.saldo_akhir),0) as saldo_akhir,ifnull(sum(apt_mutasi_obat.harga_beli),0) as harga_beli,
					ifnull(sum(apt_mutasi_obat.stok_opname),0) as stok_opname
					from apt_mutasi_obat,apt_obat,apt_satuan_kecil where apt_obat.kd_satuan_kecil=apt_satuan_kecil.kd_satuan_kecil and apt_mutasi_obat.kd_obat=apt_obat.kd_obat and apt_mutasi_obat.kd_unit_apt='$kd_unit_apt' and
					apt_mutasi_obat.bulan='$bulan' and apt_mutasi_obat.tahun='$tahun' group by apt_mutasi_obat.kd_obat,apt_mutasi_obat.harga_beli
					having saldo_awal > 0 or in_pbf > 0 or out_jual > 0 or out_disposal > 0 or saldo_akhir >0  or stok_opname > 0
					order by apt_mutasi_obat.kd_obat");

				}

		return $query->result_array();
	}

	function getMutasiObatBulanan($kd_unit_apt,$bulan,$bulan1,$tahun, $kd_nomenklatur = '',$kategori=''){
				if($kd_unit_apt=="null")$kd_unit_apt="";
		        $nomen = (!empty($kd_nomenklatur) ? " and apt_obat.kd_nomenklatur = '$kd_nomenklatur'" : "");
		        if(!empty($kategori)){
                    if($kategori==2){
                        $kat="AND apt_obat.kd_obat like '%c19%'";
                    }else{
                        $kat="AND apt_obat.kd_obat not like '%c19%'";
                    }
                }else{
                    $kat="";
                }
				if(empty($kd_unit_apt)){
					/*$query=$this->db->query("select apt_satuan_kecil.satuan_kecil,apt_mutasi_obat.kd_obat,apt_obat.nama_obat,ifnull(sum(apt_mutasi_obat.in_pbf),0) as in_pbf,ifnull(sum(apt_mutasi_obat.in_unit),0) as in_unit,ifnull(sum(apt_mutasi_obat.retur_jual),0) as retur_jual,
					ifnull(sum(apt_mutasi_obat.out_jual),0) as out_jual,ifnull(sum(apt_mutasi_obat.out_unit),0) as out_unit,ifnull(sum(apt_mutasi_obat.retur_pbf),0) as retur_pbf,ifnull(sum(apt_mutasi_obat.harga_beli),0) as harga_beli,
					ifnull(sum(apt_mutasi_obat.stok_opname),0) as stok_opname,ifnull(sum(apt_mutasi_obat.harga_beli),0) as harga_beli,ifnull(sum((apt_mutasi_obat.saldo_awal*apt_mutasi_obat.harga_beli)),0) as total_awal,
					ifnull(sum(((apt_mutasi_obat.in_pbf+apt_mutasi_obat.in_unit)-apt_mutasi_obat.retur_pbf)),0) as jum_masuk, ifnull(sum((((apt_mutasi_obat.in_pbf+apt_mutasi_obat.in_unit)-apt_mutasi_obat.retur_pbf)*apt_mutasi_obat.harga_beli)),0) as total_masuk,
					ifnull(sum(((apt_mutasi_obat.out_jual+apt_mutasi_obat.out_unit)-apt_mutasi_obat.retur_jual)),0) as jum_keluar,
					ifnull(sum((((apt_mutasi_obat.out_jual+apt_mutasi_obat.out_unit)-apt_mutasi_obat.retur_jual)*apt_mutasi_obat.harga_beli)),0) as total_keluar,
					ifnull(sum((apt_mutasi_obat.saldo_akhir*apt_mutasi_obat.harga_beli)),0) as total_akhir,x.saldo_awal,x1.saldo_akhir
					from apt_obat,apt_satuan_kecil,apt_mutasi_obat left join (select ifnull(sum(apt_mutasi_obat.saldo_awal),0) as saldo_awal,kd_obat from apt_mutasi_obat where apt_mutasi_obat.bulan='$bulan' and apt_mutasi_obat.tahun='$tahun' group by apt_mutasi_obat.kd_obat) as x on apt_mutasi_obat.kd_obat=x.kd_obat
					left join (select ifnull(sum(apt_mutasi_obat.saldo_akhir),0) as saldo_akhir,kd_obat from apt_mutasi_obat where apt_mutasi_obat.bulan='$bulan1' and apt_mutasi_obat.tahun='$tahun' group by apt_mutasi_obat.kd_obat) as x1 on apt_mutasi_obat.kd_obat=x1.kd_obat
					where apt_obat.kd_satuan_kecil=apt_satuan_kecil.kd_satuan_kecil and apt_mutasi_obat.kd_obat=apt_obat.kd_obat and
					apt_mutasi_obat.bulan>='$bulan' and apt_mutasi_obat.bulan<='$bulan1' and apt_mutasi_obat.tahun='$tahun'
					group by apt_mutasi_obat.kd_obat
					having saldo_awal > 0 or in_pbf > 0  or in_unit > 0  or retur_jual > 0  or out_jual > 0  or out_unit > 0  or retur_pbf > 0  or saldo_akhir >0  or stok_opname > 0
					order by apt_mutasi_obat.kd_obat");*/
					$query=$this->db->query("select apt_satuan_kecil.satuan_kecil,apt_mutasi_obat.kd_obat,apt_obat.nama_obat,ifnull(sum(apt_mutasi_obat.in_pbf),0) as in_pbf,ifnull(sum(apt_mutasi_obat.in_unit),0) as in_unit,ifnull(sum(apt_mutasi_obat.retur_jual),0) as retur_jual,
					ifnull(sum(apt_mutasi_obat.out_jual),0) as out_jual,ifnull(sum(apt_mutasi_obat.out_unit),0) as out_unit,ifnull(sum(apt_mutasi_obat.retur_pbf),0) as retur_pbf,ifnull(apt_mutasi_obat.harga_beli,0) as harga_beli,
					ifnull(sum(apt_mutasi_obat.stok_opname),0) as stok_opname,ifnull(apt_mutasi_obat.harga_beli,0) as harga_beli,ifnull(sum((apt_mutasi_obat.saldo_awal*apt_mutasi_obat.harga_beli)),0) as total_awal,
					ifnull(sum(((apt_mutasi_obat.in_pbf+apt_mutasi_obat.in_unit)-apt_mutasi_obat.retur_pbf)),0) as jum_masuk, ifnull(sum((((apt_mutasi_obat.in_pbf+apt_mutasi_obat.in_unit)-apt_mutasi_obat.retur_pbf)*apt_mutasi_obat.harga_beli)),0) as total_masuk,
					ifnull(sum(((apt_mutasi_obat.out_jual+apt_mutasi_obat.out_unit)-apt_mutasi_obat.retur_jual)),0) as jum_keluar,ifnull(sum(apt_mutasi_obat.out_disposal),0) as out_disposal,
					ifnull(sum((((apt_mutasi_obat.out_jual+apt_mutasi_obat.out_unit)-apt_mutasi_obat.retur_jual)*apt_mutasi_obat.harga_beli)),0) as total_keluar,
					ifnull(sum((apt_mutasi_obat.saldo_akhir*apt_mutasi_obat.harga_beli)),0) as total_akhir,x.saldo_awal,x1.saldo_akhir
					from apt_obat,apt_satuan_kecil,apt_mutasi_obat left join (select ifnull(sum(apt_mutasi_obat.saldo_awal),0) as saldo_awal,ceil(apt_mutasi_obat.harga_beli) as harga_beli,kd_obat from apt_mutasi_obat where apt_mutasi_obat.bulan='$bulan' and apt_mutasi_obat.tahun='$tahun' group by apt_mutasi_obat.kd_obat,ceil(apt_mutasi_obat.harga_beli)) as x on apt_mutasi_obat.kd_obat=x.kd_obat and ceil(apt_mutasi_obat.harga_beli)=x.harga_beli
					left join (select ifnull(sum(apt_mutasi_obat.saldo_akhir),0) as saldo_akhir,ceil(apt_mutasi_obat.harga_beli) as harga_beli,kd_obat from apt_mutasi_obat where apt_mutasi_obat.bulan='$bulan1' and apt_mutasi_obat.tahun='$tahun' group by apt_mutasi_obat.kd_obat,ceil(apt_mutasi_obat.harga_beli)) as x1 on apt_mutasi_obat.kd_obat=x1.kd_obat and ceil(apt_mutasi_obat.harga_beli)=x1.harga_beli
					where apt_obat.kd_satuan_kecil=apt_satuan_kecil.kd_satuan_kecil and apt_mutasi_obat.kd_obat=apt_obat.kd_obat and
					apt_mutasi_obat.bulan>='$bulan' and apt_mutasi_obat.bulan<='$bulan1' and apt_mutasi_obat.tahun='$tahun' $nomen $kat
					group by apt_mutasi_obat.kd_obat,ceil(apt_mutasi_obat.harga_beli)
					having saldo_awal > 0 or in_pbf > 0  or in_unit > 0  or retur_jual > 0  or out_jual > 0  or out_unit > 0  or retur_pbf > 0  or saldo_akhir >0  or stok_opname > 0
					order by apt_mutasi_obat.kd_obat
					");

				}else{
					$query=$this->db->query("select apt_satuan_kecil.satuan_kecil,apt_mutasi_obat.kd_obat,apt_obat.nama_obat,ifnull(sum(apt_mutasi_obat.in_pbf),0) as in_pbf,ifnull(sum(apt_mutasi_obat.in_unit),0) as in_unit,ifnull(sum(apt_mutasi_obat.retur_jual),0) as retur_jual,
					ifnull(sum(apt_mutasi_obat.out_jual),0) as out_jual,ifnull(sum(apt_mutasi_obat.out_unit),0) as out_unit,ifnull(sum(apt_mutasi_obat.retur_pbf),0) as retur_pbf,ifnull(apt_mutasi_obat.harga_beli,0) as harga_beli,
					ifnull(sum(apt_mutasi_obat.stok_opname),0) as stok_opname,ifnull(apt_mutasi_obat.harga_beli,0) as harga_beli,ifnull(sum((apt_mutasi_obat.saldo_awal*apt_mutasi_obat.harga_beli)),0) as total_awal,
					ifnull(sum(((apt_mutasi_obat.in_pbf+apt_mutasi_obat.in_unit)-apt_mutasi_obat.retur_pbf)),0) as jum_masuk, ifnull(sum((((apt_mutasi_obat.in_pbf+apt_mutasi_obat.in_unit)-apt_mutasi_obat.retur_pbf)*apt_mutasi_obat.harga_beli)),0) as total_masuk,
					ifnull(sum(((apt_mutasi_obat.out_jual+apt_mutasi_obat.out_unit)-apt_mutasi_obat.retur_jual)),0) as jum_keluar,ifnull(sum(apt_mutasi_obat.out_disposal),0) as out_disposal,
					ifnull(sum((((apt_mutasi_obat.out_jual+apt_mutasi_obat.out_unit)-apt_mutasi_obat.retur_jual)*apt_mutasi_obat.harga_beli)),0) as total_keluar,
					ifnull(sum((apt_mutasi_obat.saldo_akhir*apt_mutasi_obat.harga_beli)),0) as total_akhir,x.saldo_awal,x1.saldo_akhir
					from apt_obat,apt_satuan_kecil,apt_mutasi_obat left join (select ifnull(sum(apt_mutasi_obat.saldo_awal),0) as saldo_awal,ceil(apt_mutasi_obat.harga_beli) as harga_beli,kd_obat from apt_mutasi_obat where apt_mutasi_obat.bulan='$bulan' and apt_mutasi_obat.tahun='$tahun' and apt_mutasi_obat.kd_unit_apt='$kd_unit_apt' group by apt_mutasi_obat.kd_obat,ceil(apt_mutasi_obat.harga_beli)) as x on apt_mutasi_obat.kd_obat=x.kd_obat and ceil(apt_mutasi_obat.harga_beli)=x.harga_beli
					left join (select ifnull(sum(apt_mutasi_obat.saldo_akhir),0) as saldo_akhir,ceil(apt_mutasi_obat.harga_beli) as harga_beli,kd_obat from apt_mutasi_obat where apt_mutasi_obat.bulan='$bulan1' and apt_mutasi_obat.tahun='$tahun' and apt_mutasi_obat.kd_unit_apt='$kd_unit_apt' group by apt_mutasi_obat.kd_obat,ceil(apt_mutasi_obat.harga_beli)) as x1 on apt_mutasi_obat.kd_obat=x1.kd_obat and ceil(apt_mutasi_obat.harga_beli)=x1.harga_beli
					where apt_obat.kd_satuan_kecil=apt_satuan_kecil.kd_satuan_kecil and apt_mutasi_obat.kd_obat=apt_obat.kd_obat and apt_mutasi_obat.kd_unit_apt='$kd_unit_apt' and
					apt_mutasi_obat.bulan>='$bulan' and apt_mutasi_obat.bulan<='$bulan1' and apt_mutasi_obat.tahun='$tahun'  $nomen $kat
					group by apt_mutasi_obat.kd_obat,ceil(apt_mutasi_obat.harga_beli)
					having saldo_awal > 0 or in_pbf > 0  or in_unit > 0  or retur_jual > 0  or out_jual > 0  or out_unit > 0  or retur_pbf > 0  or saldo_akhir >0  or stok_opname > 0
					order by apt_mutasi_obat.kd_obat");

				}
				// die($this->db->last_query());
		return $query->result_array();
	}

	function getMutasiObatSasBulanan($kd_unit_apt,$bulan,$tahun){
				if(empty($kd_unit_apt)){
					$query=$this->db->query(" SELECT apt_obat.kd_obat,apt_obat.nama_obat,apt_stok_unit.kode_sas,apt_satuan_kecil.satuan_kecil,
					ifnull(apbd1.saldo_awal,0) as saldo_awal_apbd1,ifnull(apbd2.saldo_awal,0) as saldo_awal_apbd2,ifnull(lain.saldo_awal,0) as saldo_awal_lain,ifnull(apbn.saldo_awal,0) as saldo_awal_apbn,ifnull(program.saldo_awal,0) as saldo_awal_program,
					ifnull(apbd1.saldo_akhir,0) as saldo_akhir_apbd1,ifnull(apbd2.saldo_akhir,0) as saldo_akhir_apbd2,ifnull(lain.saldo_akhir,0) as saldo_akhir_lain,ifnull(apbn.saldo_akhir,0) as saldo_akhir_apbn,ifnull(program.saldo_akhir,0) as saldo_akhir_program,
					ifnull(apbd1.in_pbf,0) as in_pbf_apbd1,ifnull(apbd2.in_pbf,0) as in_pbf_apbd2,ifnull(lain.in_pbf,0) as in_pbf_lain,ifnull(apbn.in_pbf,0) as in_pbf_apbn,ifnull(program.in_pbf,0) as in_pbf_program,
					penerimaan.*,pengeluaran.*,apt_obat.kd_obat
					FROM apt_obat left join apt_satuan_kecil on apt_obat.kd_satuan_kecil=apt_satuan_kecil.kd_satuan_kecil
					join apt_stok_unit on apt_obat.kd_obat=apt_stok_unit.kd_obat and (apt_stok_unit.kode_sas != '' or apt_stok_unit.kode_sas is not NULL)
					left join (
						select apt_mutasi_obat.kd_obat,
											saldo_awal,
											in_pbf,
											saldo_akhir
											from apt_obat,apt_mutasi_obat
											where apt_mutasi_obat.kd_obat=apt_obat.kd_obat and apt_mutasi_obat.kd_unit_apt='D02' and
											apt_mutasi_obat.bulan='$bulan' and apt_mutasi_obat.tahun='$tahun'
											group by apt_mutasi_obat.kd_obat
						) as apbd1 on apt_obat.kd_obat=apbd1.kd_obat 
					left join (
						select apt_mutasi_obat.kd_obat,
											saldo_awal,
											in_pbf,
											saldo_akhir
											from apt_obat,apt_mutasi_obat
											where apt_mutasi_obat.kd_obat=apt_obat.kd_obat and apt_mutasi_obat.kd_unit_apt='D03' and
											apt_mutasi_obat.bulan='$bulan' and apt_mutasi_obat.tahun='$tahun'
											group by apt_mutasi_obat.kd_obat
						) as apbd2 on apt_obat.kd_obat=apbd2.kd_obat
					left join (
						select apt_mutasi_obat.kd_obat,
											saldo_awal,
											in_pbf,
											saldo_akhir
											from apt_obat,apt_mutasi_obat
											where apt_mutasi_obat.kd_obat=apt_obat.kd_obat and apt_mutasi_obat.kd_unit_apt='D04' and
											apt_mutasi_obat.bulan='$bulan' and apt_mutasi_obat.tahun='$tahun'
											group by apt_mutasi_obat.kd_obat

						) as lain on apt_obat.kd_obat=lain.kd_obat
					left join (
						select apt_mutasi_obat.kd_obat,
											saldo_awal,
											in_pbf,
											saldo_akhir
											from apt_obat,apt_mutasi_obat
											where apt_mutasi_obat.kd_obat=apt_obat.kd_obat and apt_mutasi_obat.kd_unit_apt='apb' and
											apt_mutasi_obat.bulan='$bulan' and apt_mutasi_obat.tahun='$tahun'
											group by apt_mutasi_obat.kd_obat

						) as apbn on apt_obat.kd_obat=apbn.kd_obat
					left join (
						select apt_mutasi_obat.kd_obat,
											saldo_awal,
											in_pbf,
											saldo_akhir
											from apt_obat,apt_mutasi_obat
											where apt_mutasi_obat.kd_obat=apt_obat.kd_obat and apt_mutasi_obat.kd_unit_apt='U02' and
											apt_mutasi_obat.bulan='$bulan' and apt_mutasi_obat.tahun='$tahun'
											group by apt_mutasi_obat.kd_obat
						) as program on apt_obat.kd_obat=program.kd_obat
					left join(
						select kd_obat,no_faktur,date(tgl_penerimaan) as tanggal_masuk,a1.nama as supplier,b.no_batch,b.qty_kcl from apt_penerimaan a join apt_supplier a1 on a.kd_supplier=a1.kd_supplier 
						join apt_penerimaan_detail b on a.no_penerimaan=b.no_penerimaan where month(tgl_penerimaan)='$bulan' and year(tgl_penerimaan)='$tahun' ) as penerimaan on apt_obat.kd_obat=penerimaan.kd_obat
					left join(
						select kd_obat,no_sbbk,date(tgl_penjualan) as tanggal_keluar,a1.nama as customer,b.tgl_expire,b.qty from apt_penjualan a join gfk_puskesmas a1 on a.customer_id=a1.id 
						join apt_penjualan_detail b on a.no_penjualan=b.no_penjualan where month(tgl_penjualan)='$bulan' and year(tgl_penjualan)='$tahun'
						) as pengeluaran on apt_obat.kd_obat=pengeluaran.kd_obat
					");

				}else{
					$query=$this->db->query("select apt_satuan_kecil.satuan_kecil,apt_mutasi_obat.kd_obat,apt_obat.nama_obat,ifnull(sum(apt_mutasi_obat.in_pbf),0) as in_pbf,ifnull(sum(apt_mutasi_obat.in_unit),0) as in_unit,ifnull(sum(apt_mutasi_obat.retur_jual),0) as retur_jual,
					ifnull(sum(apt_mutasi_obat.out_jual),0) as out_jual,ifnull(sum(apt_mutasi_obat.out_unit),0) as out_unit,ifnull(sum(apt_mutasi_obat.retur_pbf),0) as retur_pbf,ifnull(sum(apt_mutasi_obat.harga_beli),0) as harga_beli,
					ifnull(sum(apt_mutasi_obat.stok_opname),0) as stok_opname,ifnull(sum(apt_mutasi_obat.harga_beli),0) as harga_beli,ifnull(sum((apt_mutasi_obat.saldo_awal*apt_mutasi_obat.harga_beli)),0) as total_awal,
					ifnull(sum(((apt_mutasi_obat.in_pbf+apt_mutasi_obat.in_unit)-apt_mutasi_obat.retur_pbf)),0) as jum_masuk, ifnull(sum((((apt_mutasi_obat.in_pbf+apt_mutasi_obat.in_unit)-apt_mutasi_obat.retur_pbf)*apt_mutasi_obat.harga_beli)),0) as total_masuk,
					ifnull(sum(((apt_mutasi_obat.out_jual+apt_mutasi_obat.out_unit)-apt_mutasi_obat.retur_jual)),0) as jum_keluar,
					ifnull(sum((((apt_mutasi_obat.out_jual+apt_mutasi_obat.out_unit)-apt_mutasi_obat.retur_jual)*apt_mutasi_obat.harga_beli)),0) as total_keluar,
					ifnull(sum((apt_mutasi_obat.saldo_akhir*apt_mutasi_obat.harga_beli)),0) as total_akhir,x.saldo_awal,x1.saldo_akhir
					from apt_obat,apt_satuan_kecil,apt_mutasi_obat left join (select ifnull(sum(apt_mutasi_obat.saldo_awal),0) as saldo_awal,kd_obat from apt_mutasi_obat where apt_mutasi_obat.bulan='$bulan' and apt_mutasi_obat.tahun='$tahun' and apt_mutasi_obat.kd_unit_apt='$kd_unit_apt' group by apt_mutasi_obat.kd_obat) as x on apt_mutasi_obat.kd_obat=x.kd_obat
					left join (select ifnull(sum(apt_mutasi_obat.saldo_akhir),0) as saldo_akhir,kd_obat from apt_mutasi_obat where apt_mutasi_obat.bulan='$bulan1' and apt_mutasi_obat.tahun='$tahun' and apt_mutasi_obat.kd_unit_apt='$kd_unit_apt' group by apt_mutasi_obat.kd_obat) as x1 on apt_mutasi_obat.kd_obat=x1.kd_obat
					where apt_obat.kd_satuan_kecil=apt_satuan_kecil.kd_satuan_kecil and apt_mutasi_obat.kd_obat=apt_obat.kd_obat and apt_mutasi_obat.kd_unit_apt='$kd_unit_apt' and
					apt_mutasi_obat.bulan>='$bulan' and apt_mutasi_obat.bulan<='$bulan1' and apt_mutasi_obat.tahun='$tahun'
					group by apt_mutasi_obat.kd_obat
					having saldo_awal > 0 or in_pbf > 0  or in_unit > 0  or retur_jual > 0  or out_jual > 0  or out_unit > 0  or retur_pbf > 0  or saldo_akhir >0  or stok_opname > 0
					order by apt_mutasi_obat.kd_obat");

				}

		return $query->result_array();
	}
	
	function getMutasiObatPsikotropikaBulanan($kd_unit_apt,$bulan,$tahun){
				if(empty($kd_unit_apt)){
					$query=$this->db->query(" SELECT apt_obat.kd_obat,apt_obat.nama_obat,apt_satuan_kecil.satuan_kecil,
					ifnull(apbd1.saldo_awal,0) as saldo_awal_apbd1,ifnull(apbd2.saldo_awal,0) as saldo_awal_apbd2,ifnull(lain.saldo_awal,0) as saldo_awal_lain,ifnull(apbn.saldo_awal,0) as saldo_awal_apbn,ifnull(program.saldo_awal,0) as saldo_awal_program,
					ifnull(apbd1.saldo_akhir,0) as saldo_akhir_apbd1,ifnull(apbd2.saldo_akhir,0) as saldo_akhir_apbd2,ifnull(lain.saldo_akhir,0) as saldo_akhir_lain,ifnull(apbn.saldo_akhir,0) as saldo_akhir_apbn,ifnull(program.saldo_akhir,0) as saldo_akhir_program,
					ifnull(apbd1.in_pbf,0) as in_pbf_apbd1,ifnull(apbd2.in_pbf,0) as in_pbf_apbd2,ifnull(lain.in_pbf,0) as in_pbf_lain,ifnull(apbn.in_pbf,0) as in_pbf_apbn,ifnull(program.in_pbf,0) as in_pbf_program,
					penerimaan.*,pengeluaran.*,apt_obat.kd_obat
					FROM apt_obat left join apt_satuan_kecil on apt_obat.kd_satuan_kecil=apt_satuan_kecil.kd_satuan_kecil
					join lap_sediaan_psikotropika on apt_obat.kd_obat=lap_sediaan_psikotropika.kd_obat
					left join (
						select apt_mutasi_obat.kd_obat,
											saldo_awal,
											in_pbf,
											saldo_akhir
											from apt_obat,apt_mutasi_obat
											where apt_mutasi_obat.kd_obat=apt_obat.kd_obat and apt_mutasi_obat.kd_unit_apt='D02' and
											apt_mutasi_obat.bulan='$bulan' and apt_mutasi_obat.tahun='$tahun'
											group by apt_mutasi_obat.kd_obat
						) as apbd1 on apt_obat.kd_obat=apbd1.kd_obat 
					left join (
						select apt_mutasi_obat.kd_obat,
											saldo_awal,
											in_pbf,
											saldo_akhir
											from apt_obat,apt_mutasi_obat
											where apt_mutasi_obat.kd_obat=apt_obat.kd_obat and apt_mutasi_obat.kd_unit_apt='D03' and
											apt_mutasi_obat.bulan='$bulan' and apt_mutasi_obat.tahun='$tahun'
											group by apt_mutasi_obat.kd_obat
						) as apbd2 on apt_obat.kd_obat=apbd2.kd_obat
					left join (
						select apt_mutasi_obat.kd_obat,
											saldo_awal,
											in_pbf,
											saldo_akhir
											from apt_obat,apt_mutasi_obat
											where apt_mutasi_obat.kd_obat=apt_obat.kd_obat and apt_mutasi_obat.kd_unit_apt='D04' and
											apt_mutasi_obat.bulan='$bulan' and apt_mutasi_obat.tahun='$tahun'
											group by apt_mutasi_obat.kd_obat

						) as lain on apt_obat.kd_obat=lain.kd_obat
					left join (
						select apt_mutasi_obat.kd_obat,
											saldo_awal,
											in_pbf,
											saldo_akhir
											from apt_obat,apt_mutasi_obat
											where apt_mutasi_obat.kd_obat=apt_obat.kd_obat and apt_mutasi_obat.kd_unit_apt='apb' and
											apt_mutasi_obat.bulan='$bulan' and apt_mutasi_obat.tahun='$tahun'
											group by apt_mutasi_obat.kd_obat

						) as apbn on apt_obat.kd_obat=apbn.kd_obat
					left join (
						select apt_mutasi_obat.kd_obat,
											saldo_awal,
											in_pbf,
											saldo_akhir
											from apt_obat,apt_mutasi_obat
											where apt_mutasi_obat.kd_obat=apt_obat.kd_obat and apt_mutasi_obat.kd_unit_apt='U02' and
											apt_mutasi_obat.bulan='$bulan' and apt_mutasi_obat.tahun='$tahun'
											group by apt_mutasi_obat.kd_obat
						) as program on apt_obat.kd_obat=program.kd_obat
					left join(
						select kd_obat,no_faktur,date(tgl_penerimaan) as tanggal_masuk,a1.nama as supplier,b.no_batch,b.qty_kcl from apt_penerimaan a join apt_supplier a1 on a.kd_supplier=a1.kd_supplier 
						join apt_penerimaan_detail b on a.no_penerimaan=b.no_penerimaan where month(tgl_penerimaan)='$bulan' and year(tgl_penerimaan)='$tahun' ) as penerimaan on apt_obat.kd_obat=penerimaan.kd_obat
					left join(
						select kd_obat,no_sbbk,date(tgl_penjualan) as tanggal_keluar,a1.nama as customer,b.tgl_expire,b.qty from apt_penjualan a join gfk_puskesmas a1 on a.customer_id=a1.id 
						join apt_penjualan_detail b on a.no_penjualan=b.no_penjualan where month(tgl_penjualan)='$bulan' and year(tgl_penjualan)='$tahun'
						) as pengeluaran on apt_obat.kd_obat=pengeluaran.kd_obat
						order by urut
					");

				}else{
					$query=$this->db->query("select apt_satuan_kecil.satuan_kecil,apt_mutasi_obat.kd_obat,apt_obat.nama_obat,ifnull(sum(apt_mutasi_obat.in_pbf),0) as in_pbf,ifnull(sum(apt_mutasi_obat.in_unit),0) as in_unit,ifnull(sum(apt_mutasi_obat.retur_jual),0) as retur_jual,
					ifnull(sum(apt_mutasi_obat.out_jual),0) as out_jual,ifnull(sum(apt_mutasi_obat.out_unit),0) as out_unit,ifnull(sum(apt_mutasi_obat.retur_pbf),0) as retur_pbf,ifnull(sum(apt_mutasi_obat.harga_beli),0) as harga_beli,
					ifnull(sum(apt_mutasi_obat.stok_opname),0) as stok_opname,ifnull(sum(apt_mutasi_obat.harga_beli),0) as harga_beli,ifnull(sum((apt_mutasi_obat.saldo_awal*apt_mutasi_obat.harga_beli)),0) as total_awal,
					ifnull(sum(((apt_mutasi_obat.in_pbf+apt_mutasi_obat.in_unit)-apt_mutasi_obat.retur_pbf)),0) as jum_masuk, ifnull(sum((((apt_mutasi_obat.in_pbf+apt_mutasi_obat.in_unit)-apt_mutasi_obat.retur_pbf)*apt_mutasi_obat.harga_beli)),0) as total_masuk,
					ifnull(sum(((apt_mutasi_obat.out_jual+apt_mutasi_obat.out_unit)-apt_mutasi_obat.retur_jual)),0) as jum_keluar,
					ifnull(sum((((apt_mutasi_obat.out_jual+apt_mutasi_obat.out_unit)-apt_mutasi_obat.retur_jual)*apt_mutasi_obat.harga_beli)),0) as total_keluar,
					ifnull(sum((apt_mutasi_obat.saldo_akhir*apt_mutasi_obat.harga_beli)),0) as total_akhir,x.saldo_awal,x1.saldo_akhir
					from apt_obat,apt_satuan_kecil,apt_mutasi_obat left join (select ifnull(sum(apt_mutasi_obat.saldo_awal),0) as saldo_awal,kd_obat from apt_mutasi_obat where apt_mutasi_obat.bulan='$bulan' and apt_mutasi_obat.tahun='$tahun' and apt_mutasi_obat.kd_unit_apt='$kd_unit_apt' group by apt_mutasi_obat.kd_obat) as x on apt_mutasi_obat.kd_obat=x.kd_obat
					left join (select ifnull(sum(apt_mutasi_obat.saldo_akhir),0) as saldo_akhir,kd_obat from apt_mutasi_obat where apt_mutasi_obat.bulan='$bulan1' and apt_mutasi_obat.tahun='$tahun' and apt_mutasi_obat.kd_unit_apt='$kd_unit_apt' group by apt_mutasi_obat.kd_obat) as x1 on apt_mutasi_obat.kd_obat=x1.kd_obat
					where apt_obat.kd_satuan_kecil=apt_satuan_kecil.kd_satuan_kecil and apt_mutasi_obat.kd_obat=apt_obat.kd_obat and apt_mutasi_obat.kd_unit_apt='$kd_unit_apt' and
					apt_mutasi_obat.bulan>='$bulan' and apt_mutasi_obat.bulan<='$bulan1' and apt_mutasi_obat.tahun='$tahun'
					group by apt_mutasi_obat.kd_obat
					having saldo_awal > 0 or in_pbf > 0  or in_unit > 0  or retur_jual > 0  or out_jual > 0  or out_unit > 0  or retur_pbf > 0  or saldo_akhir >0  or stok_opname > 0
					order by apt_mutasi_obat.kd_obat");

				}

		return $query->result_array();
	}

	function getMutasiObatNarkotikaBulanan($kd_unit_apt,$bulan,$tahun){
				if(empty($kd_unit_apt)){
					$query=$this->db->query(" SELECT apt_obat.kd_obat,apt_obat.nama_obat,apt_satuan_kecil.satuan_kecil,
					ifnull(apbd1.saldo_awal,0) as saldo_awal_apbd1,ifnull(apbd2.saldo_awal,0) as saldo_awal_apbd2,ifnull(lain.saldo_awal,0) as saldo_awal_lain,ifnull(apbn.saldo_awal,0) as saldo_awal_apbn,ifnull(program.saldo_awal,0) as saldo_awal_program,
					ifnull(apbd1.saldo_akhir,0) as saldo_akhir_apbd1,ifnull(apbd2.saldo_akhir,0) as saldo_akhir_apbd2,ifnull(lain.saldo_akhir,0) as saldo_akhir_lain,ifnull(apbn.saldo_akhir,0) as saldo_akhir_apbn,ifnull(program.saldo_akhir,0) as saldo_akhir_program,
					ifnull(apbd1.in_pbf,0) as in_pbf_apbd1,ifnull(apbd2.in_pbf,0) as in_pbf_apbd2,ifnull(lain.in_pbf,0) as in_pbf_lain,ifnull(apbn.in_pbf,0) as in_pbf_apbn,ifnull(program.in_pbf,0) as in_pbf_program,
					penerimaan.*,pengeluaran.*,apt_obat.kd_obat
					FROM apt_obat left join apt_satuan_kecil on apt_obat.kd_satuan_kecil=apt_satuan_kecil.kd_satuan_kecil
					join lap_sediaan_narkotika on apt_obat.kd_obat=lap_sediaan_narkotika.kd_obat
					left join (
						select apt_mutasi_obat.kd_obat,
											saldo_awal,
											in_pbf,
											saldo_akhir
											from apt_obat,apt_mutasi_obat
											where apt_mutasi_obat.kd_obat=apt_obat.kd_obat and apt_mutasi_obat.kd_unit_apt='D02' and
											apt_mutasi_obat.bulan='$bulan' and apt_mutasi_obat.tahun='$tahun'
											group by apt_mutasi_obat.kd_obat
						) as apbd1 on apt_obat.kd_obat=apbd1.kd_obat 
					left join (
						select apt_mutasi_obat.kd_obat,
											saldo_awal,
											in_pbf,
											saldo_akhir
											from apt_obat,apt_mutasi_obat
											where apt_mutasi_obat.kd_obat=apt_obat.kd_obat and apt_mutasi_obat.kd_unit_apt='D03' and
											apt_mutasi_obat.bulan='$bulan' and apt_mutasi_obat.tahun='$tahun'
											group by apt_mutasi_obat.kd_obat
						) as apbd2 on apt_obat.kd_obat=apbd2.kd_obat
					left join (
						select apt_mutasi_obat.kd_obat,
											saldo_awal,
											in_pbf,
											saldo_akhir
											from apt_obat,apt_mutasi_obat
											where apt_mutasi_obat.kd_obat=apt_obat.kd_obat and apt_mutasi_obat.kd_unit_apt='D04' and
											apt_mutasi_obat.bulan='$bulan' and apt_mutasi_obat.tahun='$tahun'
											group by apt_mutasi_obat.kd_obat

						) as lain on apt_obat.kd_obat=lain.kd_obat
					left join (
						select apt_mutasi_obat.kd_obat,
											saldo_awal,
											in_pbf,
											saldo_akhir
											from apt_obat,apt_mutasi_obat
											where apt_mutasi_obat.kd_obat=apt_obat.kd_obat and apt_mutasi_obat.kd_unit_apt='apb' and
											apt_mutasi_obat.bulan='$bulan' and apt_mutasi_obat.tahun='$tahun'
											group by apt_mutasi_obat.kd_obat

						) as apbn on apt_obat.kd_obat=apbn.kd_obat
					left join (
						select apt_mutasi_obat.kd_obat,
											saldo_awal,
											in_pbf,
											saldo_akhir
											from apt_obat,apt_mutasi_obat
											where apt_mutasi_obat.kd_obat=apt_obat.kd_obat and apt_mutasi_obat.kd_unit_apt='U02' and
											apt_mutasi_obat.bulan='$bulan' and apt_mutasi_obat.tahun='$tahun'
											group by apt_mutasi_obat.kd_obat
						) as program on apt_obat.kd_obat=program.kd_obat
					left join(
						select kd_obat,no_faktur,date(tgl_penerimaan) as tanggal_masuk,a1.nama as supplier,b.no_batch,b.qty_kcl from apt_penerimaan a join apt_supplier a1 on a.kd_supplier=a1.kd_supplier 
						join apt_penerimaan_detail b on a.no_penerimaan=b.no_penerimaan where month(tgl_penerimaan)='$bulan' and year(tgl_penerimaan)='$tahun' ) as penerimaan on apt_obat.kd_obat=penerimaan.kd_obat
					left join(
						select kd_obat,no_sbbk,date(tgl_penjualan) as tanggal_keluar,a1.nama as customer,b.tgl_expire,b.qty from apt_penjualan a join gfk_puskesmas a1 on a.customer_id=a1.id 
						join apt_penjualan_detail b on a.no_penjualan=b.no_penjualan where month(tgl_penjualan)='$bulan' and year(tgl_penjualan)='$tahun'
						) as pengeluaran on apt_obat.kd_obat=pengeluaran.kd_obat
						order by urut
					");

				}else{
					$query=$this->db->query("select apt_satuan_kecil.satuan_kecil,apt_mutasi_obat.kd_obat,apt_obat.nama_obat,ifnull(sum(apt_mutasi_obat.in_pbf),0) as in_pbf,ifnull(sum(apt_mutasi_obat.in_unit),0) as in_unit,ifnull(sum(apt_mutasi_obat.retur_jual),0) as retur_jual,
					ifnull(sum(apt_mutasi_obat.out_jual),0) as out_jual,ifnull(sum(apt_mutasi_obat.out_unit),0) as out_unit,ifnull(sum(apt_mutasi_obat.retur_pbf),0) as retur_pbf,ifnull(sum(apt_mutasi_obat.harga_beli),0) as harga_beli,
					ifnull(sum(apt_mutasi_obat.stok_opname),0) as stok_opname,ifnull(sum(apt_mutasi_obat.harga_beli),0) as harga_beli,ifnull(sum((apt_mutasi_obat.saldo_awal*apt_mutasi_obat.harga_beli)),0) as total_awal,
					ifnull(sum(((apt_mutasi_obat.in_pbf+apt_mutasi_obat.in_unit)-apt_mutasi_obat.retur_pbf)),0) as jum_masuk, ifnull(sum((((apt_mutasi_obat.in_pbf+apt_mutasi_obat.in_unit)-apt_mutasi_obat.retur_pbf)*apt_mutasi_obat.harga_beli)),0) as total_masuk,
					ifnull(sum(((apt_mutasi_obat.out_jual+apt_mutasi_obat.out_unit)-apt_mutasi_obat.retur_jual)),0) as jum_keluar,
					ifnull(sum((((apt_mutasi_obat.out_jual+apt_mutasi_obat.out_unit)-apt_mutasi_obat.retur_jual)*apt_mutasi_obat.harga_beli)),0) as total_keluar,
					ifnull(sum((apt_mutasi_obat.saldo_akhir*apt_mutasi_obat.harga_beli)),0) as total_akhir,x.saldo_awal,x1.saldo_akhir
					from apt_obat,apt_satuan_kecil,apt_mutasi_obat left join (select ifnull(sum(apt_mutasi_obat.saldo_awal),0) as saldo_awal,kd_obat from apt_mutasi_obat where apt_mutasi_obat.bulan='$bulan' and apt_mutasi_obat.tahun='$tahun' and apt_mutasi_obat.kd_unit_apt='$kd_unit_apt' group by apt_mutasi_obat.kd_obat) as x on apt_mutasi_obat.kd_obat=x.kd_obat
					left join (select ifnull(sum(apt_mutasi_obat.saldo_akhir),0) as saldo_akhir,kd_obat from apt_mutasi_obat where apt_mutasi_obat.bulan='$bulan1' and apt_mutasi_obat.tahun='$tahun' and apt_mutasi_obat.kd_unit_apt='$kd_unit_apt' group by apt_mutasi_obat.kd_obat) as x1 on apt_mutasi_obat.kd_obat=x1.kd_obat
					where apt_obat.kd_satuan_kecil=apt_satuan_kecil.kd_satuan_kecil and apt_mutasi_obat.kd_obat=apt_obat.kd_obat and apt_mutasi_obat.kd_unit_apt='$kd_unit_apt' and
					apt_mutasi_obat.bulan>='$bulan' and apt_mutasi_obat.bulan<='$bulan1' and apt_mutasi_obat.tahun='$tahun'
					group by apt_mutasi_obat.kd_obat
					having saldo_awal > 0 or in_pbf > 0  or in_unit > 0  or retur_jual > 0  or out_jual > 0  or out_unit > 0  or retur_pbf > 0  or saldo_akhir >0  or stok_opname > 0
					order by apt_mutasi_obat.kd_obat");

				}

		return $query->result_array();
	}

	function getMutasiObatPrekursorBulanan($kd_unit_apt,$bulan,$tahun){
				if(empty($kd_unit_apt)){
					$query=$this->db->query(" SELECT apt_obat.kd_obat,apt_obat.nama_obat,apt_satuan_kecil.satuan_kecil,
					ifnull(apbd1.saldo_awal,0) as saldo_awal_apbd1,ifnull(apbd2.saldo_awal,0) as saldo_awal_apbd2,ifnull(lain.saldo_awal,0) as saldo_awal_lain,ifnull(apbn.saldo_awal,0) as saldo_awal_apbn,ifnull(program.saldo_awal,0) as saldo_awal_program,
					ifnull(apbd1.saldo_akhir,0) as saldo_akhir_apbd1,ifnull(apbd2.saldo_akhir,0) as saldo_akhir_apbd2,ifnull(lain.saldo_akhir,0) as saldo_akhir_lain,ifnull(apbn.saldo_akhir,0) as saldo_akhir_apbn,ifnull(program.saldo_akhir,0) as saldo_akhir_program,
					ifnull(apbd1.in_pbf,0) as in_pbf_apbd1,ifnull(apbd2.in_pbf,0) as in_pbf_apbd2,ifnull(lain.in_pbf,0) as in_pbf_lain,ifnull(apbn.in_pbf,0) as in_pbf_apbn,ifnull(program.in_pbf,0) as in_pbf_program,
					penerimaan.*,pengeluaran.*,apt_obat.kd_obat
					FROM apt_obat left join apt_satuan_kecil on apt_obat.kd_satuan_kecil=apt_satuan_kecil.kd_satuan_kecil
					join lap_sediaan_prekursor on apt_obat.kd_obat=lap_sediaan_prekursor.kd_obat
					left join (
						select apt_mutasi_obat.kd_obat,
											saldo_awal,
											in_pbf,
											saldo_akhir
											from apt_obat,apt_mutasi_obat
											where apt_mutasi_obat.kd_obat=apt_obat.kd_obat and apt_mutasi_obat.kd_unit_apt='D02' and
											apt_mutasi_obat.bulan='$bulan' and apt_mutasi_obat.tahun='$tahun'
											group by apt_mutasi_obat.kd_obat
						) as apbd1 on apt_obat.kd_obat=apbd1.kd_obat 
					left join (
						select apt_mutasi_obat.kd_obat,
											saldo_awal,
											in_pbf,
											saldo_akhir
											from apt_obat,apt_mutasi_obat
											where apt_mutasi_obat.kd_obat=apt_obat.kd_obat and apt_mutasi_obat.kd_unit_apt='D03' and
											apt_mutasi_obat.bulan='$bulan' and apt_mutasi_obat.tahun='$tahun'
											group by apt_mutasi_obat.kd_obat
						) as apbd2 on apt_obat.kd_obat=apbd2.kd_obat
					left join (
						select apt_mutasi_obat.kd_obat,
											saldo_awal,
											in_pbf,
											saldo_akhir
											from apt_obat,apt_mutasi_obat
											where apt_mutasi_obat.kd_obat=apt_obat.kd_obat and apt_mutasi_obat.kd_unit_apt='D04' and
											apt_mutasi_obat.bulan='$bulan' and apt_mutasi_obat.tahun='$tahun'
											group by apt_mutasi_obat.kd_obat

						) as lain on apt_obat.kd_obat=lain.kd_obat
					left join (
						select apt_mutasi_obat.kd_obat,
											saldo_awal,
											in_pbf,
											saldo_akhir
											from apt_obat,apt_mutasi_obat
											where apt_mutasi_obat.kd_obat=apt_obat.kd_obat and apt_mutasi_obat.kd_unit_apt='apb' and
											apt_mutasi_obat.bulan='$bulan' and apt_mutasi_obat.tahun='$tahun'
											group by apt_mutasi_obat.kd_obat

						) as apbn on apt_obat.kd_obat=apbn.kd_obat
					left join (
						select apt_mutasi_obat.kd_obat,
											saldo_awal,
											in_pbf,
											saldo_akhir
											from apt_obat,apt_mutasi_obat
											where apt_mutasi_obat.kd_obat=apt_obat.kd_obat and apt_mutasi_obat.kd_unit_apt='U02' and
											apt_mutasi_obat.bulan='$bulan' and apt_mutasi_obat.tahun='$tahun'
											group by apt_mutasi_obat.kd_obat
						) as program on apt_obat.kd_obat=program.kd_obat
					left join(
						select kd_obat,no_faktur,date(tgl_penerimaan) as tanggal_masuk,a1.nama as supplier,b.no_batch,b.qty_kcl from apt_penerimaan a join apt_supplier a1 on a.kd_supplier=a1.kd_supplier 
						join apt_penerimaan_detail b on a.no_penerimaan=b.no_penerimaan where month(tgl_penerimaan)='$bulan' and year(tgl_penerimaan)='$tahun' ) as penerimaan on apt_obat.kd_obat=penerimaan.kd_obat
					left join(
						select kd_obat,no_sbbk,date(tgl_penjualan) as tanggal_keluar,a1.nama as customer,b.tgl_expire,b.qty from apt_penjualan a join gfk_puskesmas a1 on a.customer_id=a1.id 
						join apt_penjualan_detail b on a.no_penjualan=b.no_penjualan where month(tgl_penjualan)='$bulan' and year(tgl_penjualan)='$tahun'
						) as pengeluaran on apt_obat.kd_obat=pengeluaran.kd_obat
						order by urut
					");

				}else{
					$query=$this->db->query("select apt_satuan_kecil.satuan_kecil,apt_mutasi_obat.kd_obat,apt_obat.nama_obat,ifnull(sum(apt_mutasi_obat.in_pbf),0) as in_pbf,ifnull(sum(apt_mutasi_obat.in_unit),0) as in_unit,ifnull(sum(apt_mutasi_obat.retur_jual),0) as retur_jual,
					ifnull(sum(apt_mutasi_obat.out_jual),0) as out_jual,ifnull(sum(apt_mutasi_obat.out_unit),0) as out_unit,ifnull(sum(apt_mutasi_obat.retur_pbf),0) as retur_pbf,ifnull(sum(apt_mutasi_obat.harga_beli),0) as harga_beli,
					ifnull(sum(apt_mutasi_obat.stok_opname),0) as stok_opname,ifnull(sum(apt_mutasi_obat.harga_beli),0) as harga_beli,ifnull(sum((apt_mutasi_obat.saldo_awal*apt_mutasi_obat.harga_beli)),0) as total_awal,
					ifnull(sum(((apt_mutasi_obat.in_pbf+apt_mutasi_obat.in_unit)-apt_mutasi_obat.retur_pbf)),0) as jum_masuk, ifnull(sum((((apt_mutasi_obat.in_pbf+apt_mutasi_obat.in_unit)-apt_mutasi_obat.retur_pbf)*apt_mutasi_obat.harga_beli)),0) as total_masuk,
					ifnull(sum(((apt_mutasi_obat.out_jual+apt_mutasi_obat.out_unit)-apt_mutasi_obat.retur_jual)),0) as jum_keluar,
					ifnull(sum((((apt_mutasi_obat.out_jual+apt_mutasi_obat.out_unit)-apt_mutasi_obat.retur_jual)*apt_mutasi_obat.harga_beli)),0) as total_keluar,
					ifnull(sum((apt_mutasi_obat.saldo_akhir*apt_mutasi_obat.harga_beli)),0) as total_akhir,x.saldo_awal,x1.saldo_akhir
					from apt_obat,apt_satuan_kecil,apt_mutasi_obat left join (select ifnull(sum(apt_mutasi_obat.saldo_awal),0) as saldo_awal,kd_obat from apt_mutasi_obat where apt_mutasi_obat.bulan='$bulan' and apt_mutasi_obat.tahun='$tahun' and apt_mutasi_obat.kd_unit_apt='$kd_unit_apt' group by apt_mutasi_obat.kd_obat) as x on apt_mutasi_obat.kd_obat=x.kd_obat
					left join (select ifnull(sum(apt_mutasi_obat.saldo_akhir),0) as saldo_akhir,kd_obat from apt_mutasi_obat where apt_mutasi_obat.bulan='$bulan1' and apt_mutasi_obat.tahun='$tahun' and apt_mutasi_obat.kd_unit_apt='$kd_unit_apt' group by apt_mutasi_obat.kd_obat) as x1 on apt_mutasi_obat.kd_obat=x1.kd_obat
					where apt_obat.kd_satuan_kecil=apt_satuan_kecil.kd_satuan_kecil and apt_mutasi_obat.kd_obat=apt_obat.kd_obat and apt_mutasi_obat.kd_unit_apt='$kd_unit_apt' and
					apt_mutasi_obat.bulan>='$bulan' and apt_mutasi_obat.bulan<='$bulan1' and apt_mutasi_obat.tahun='$tahun'
					group by apt_mutasi_obat.kd_obat
					having saldo_awal > 0 or in_pbf > 0  or in_unit > 0  or retur_jual > 0  or out_jual > 0  or out_unit > 0  or retur_pbf > 0  or saldo_akhir >0  or stok_opname > 0
					order by apt_mutasi_obat.kd_obat");

				}

		return $query->result_array();
	}

	function getMutasiObatGolonganBulanan($kd_unit_apt,$bulan,$bulan1,$tahun,$golongan){
				if(empty($kd_unit_apt)){
					/*$query=$this->db->query("select apt_satuan_kecil.satuan_kecil,apt_mutasi_obat.kd_obat,apt_obat.nama_obat,ifnull(sum(apt_mutasi_obat.in_pbf),0) as in_pbf,ifnull(sum(apt_mutasi_obat.in_unit),0) as in_unit,ifnull(sum(apt_mutasi_obat.retur_jual),0) as retur_jual,
					ifnull(sum(apt_mutasi_obat.out_jual),0) as out_jual,ifnull(sum(apt_mutasi_obat.out_unit),0) as out_unit,ifnull(sum(apt_mutasi_obat.retur_pbf),0) as retur_pbf,ifnull(sum(apt_mutasi_obat.harga_beli),0) as harga_beli,
					ifnull(sum(apt_mutasi_obat.stok_opname),0) as stok_opname,ifnull(sum(apt_mutasi_obat.harga_beli),0) as harga_beli,ifnull(sum((apt_mutasi_obat.saldo_awal*apt_mutasi_obat.harga_beli)),0) as total_awal,
					ifnull(sum(((apt_mutasi_obat.in_pbf+apt_mutasi_obat.in_unit)-apt_mutasi_obat.retur_pbf)),0) as jum_masuk, ifnull(sum((((apt_mutasi_obat.in_pbf+apt_mutasi_obat.in_unit)-apt_mutasi_obat.retur_pbf)*apt_mutasi_obat.harga_beli)),0) as total_masuk,
					ifnull(sum(((apt_mutasi_obat.out_jual+apt_mutasi_obat.out_unit)-apt_mutasi_obat.retur_jual)),0) as jum_keluar,
					ifnull(sum((((apt_mutasi_obat.out_jual+apt_mutasi_obat.out_unit)-apt_mutasi_obat.retur_jual)*apt_mutasi_obat.harga_beli)),0) as total_keluar,
					ifnull(sum((apt_mutasi_obat.saldo_akhir*apt_mutasi_obat.harga_beli)),0) as total_akhir,x.saldo_awal,x1.saldo_akhir
					from apt_obat,apt_satuan_kecil,apt_mutasi_obat left join (select ifnull(sum(apt_mutasi_obat.saldo_awal),0) as saldo_awal,kd_obat from apt_mutasi_obat where apt_mutasi_obat.bulan='$bulan' and apt_mutasi_obat.tahun='$tahun' group by apt_mutasi_obat.kd_obat) as x on apt_mutasi_obat.kd_obat=x.kd_obat
					left join (select ifnull(sum(apt_mutasi_obat.saldo_akhir),0) as saldo_akhir,kd_obat from apt_mutasi_obat where apt_mutasi_obat.bulan='$bulan1' and apt_mutasi_obat.tahun='$tahun' group by apt_mutasi_obat.kd_obat) as x1 on apt_mutasi_obat.kd_obat=x1.kd_obat
					where apt_obat.kd_satuan_kecil=apt_satuan_kecil.kd_satuan_kecil and apt_mutasi_obat.kd_obat=apt_obat.kd_obat and
					apt_mutasi_obat.bulan>='$bulan' and apt_mutasi_obat.bulan<='$bulan1' and apt_mutasi_obat.tahun='$tahun'
					group by apt_mutasi_obat.kd_obat
					having saldo_awal > 0 or in_pbf > 0  or in_unit > 0  or retur_jual > 0  or out_jual > 0  or out_unit > 0  or retur_pbf > 0  or saldo_akhir >0  or stok_opname > 0
					order by apt_mutasi_obat.kd_obat");*/
					$query=$this->db->query("SELECT apt_obat.kd_obat,apt_obat.nama_obat,apt_satuan_kecil.satuan_kecil,
					ifnull(apbd1.saldo_awal,0) as saldo_awal_apbd1,ifnull(apbd2.saldo_awal,0) as saldo_awal_apbd2,ifnull(lain.saldo_awal,0) as saldo_awal_lain,ifnull(apbn.saldo_awal,0) as saldo_awal_apbn,ifnull(program.saldo_awal,0) as saldo_awal_program,
					ifnull(apbd1.jum_masuk,0) as jum_masuk_apbd1,ifnull(apbd2.jum_masuk,0) as jum_masuk_apbd2,ifnull(lain.jum_masuk,0) as jum_masuk_lain,ifnull(apbn.jum_masuk,0) as jum_masuk_apbn,ifnull(program.jum_masuk,0) as jum_masuk_program,
					ifnull(apbd1.jum_keluar,0) as jum_keluar_apbd1,ifnull(apbd2.jum_keluar,0) as jum_keluar_apbd2,ifnull(lain.jum_keluar,0) as jum_keluar_lain,ifnull(apbn.jum_keluar,0) as jum_keluar_apbn,ifnull(program.jum_keluar,0) as jum_keluar_program,
					ifnull(apbd1.saldo_akhir,0) as saldo_akhir_apbd1,ifnull(apbd2.saldo_akhir,0) as saldo_akhir_apbd2,ifnull(lain.saldo_akhir,0) as saldo_akhir_lain,ifnull(apbn.saldo_akhir,0) as saldo_akhir_apbn,ifnull(program.saldo_akhir,0) as saldo_akhir_program,
					ifnull(apbd1.stok_opname,0) as stok_opname_apbd1,ifnull(apbd2.stok_opname,0) as stok_opname_apbd2,ifnull(lain.stok_opname,0) as stok_opname_lain,ifnull(apbn.stok_opname,0) as stok_opname_apbn,ifnull(program.stok_opname,0) as stok_opname_program,
					ifnull(kpns.total,0) as pengeluaran_kpns,ifnull(bs1.total,0) as pengeluaran_bs1,ifnull(bs2.total,0) as pengeluaran_bs2,ifnull(bu1.total,0) as pengeluaran_bu1,ifnull(bu2.total,0) as pengeluaran_bu2,ifnull(bl.total,0) as pengeluaran_bl,ifnull(bb.total,0) as pengeluaran_bb,ifnull(customerlain.total,0) as pengeluaran_lain
					FROM apt_obat left join apt_satuan_kecil on apt_obat.kd_satuan_kecil=apt_satuan_kecil.kd_satuan_kecil
					left join (
						select apt_mutasi_obat.kd_obat,
											x.saldo_awal,
											x1.saldo_akhir,
											ifnull(sum(apt_mutasi_obat.in_pbf),0) as in_pbf,
											ifnull(sum(apt_mutasi_obat.in_unit),0) as in_unit,
											ifnull(sum(apt_mutasi_obat.retur_jual),0) as retur_jual,
											ifnull(sum(apt_mutasi_obat.out_jual),0) as out_jual,
											ifnull(sum(apt_mutasi_obat.out_unit),0) as out_unit,
											ifnull(sum(apt_mutasi_obat.retur_pbf),0) as retur_pbf,
											ifnull(sum(apt_mutasi_obat.stok_opname),0) as stok_opname,
											ifnull(sum(((apt_mutasi_obat.in_pbf+apt_mutasi_obat.in_unit)-apt_mutasi_obat.retur_pbf)),0) as jum_masuk,
											ifnull(sum(((apt_mutasi_obat.out_jual+apt_mutasi_obat.out_unit)-apt_mutasi_obat.retur_jual)),0) as jum_keluar
											from apt_obat,apt_mutasi_obat
											left join (select ifnull(sum(apt_mutasi_obat.saldo_awal),0) as saldo_awal,kd_obat from apt_mutasi_obat where apt_mutasi_obat.bulan='$bulan' and apt_mutasi_obat.tahun='$tahun' and apt_mutasi_obat.kd_unit_apt='$kd_unit_apt' group by apt_mutasi_obat.kd_obat) as x on apt_mutasi_obat.kd_obat=x.kd_obat
											left join (select ifnull(sum(apt_mutasi_obat.saldo_akhir),0) as saldo_akhir,kd_obat from apt_mutasi_obat where apt_mutasi_obat.bulan='$bulan1' and apt_mutasi_obat.tahun='$tahun' and apt_mutasi_obat.kd_unit_apt='$kd_unit_apt' group by apt_mutasi_obat.kd_obat) as x1 on apt_mutasi_obat.kd_obat=x1.kd_obat
											where apt_mutasi_obat.kd_obat=apt_obat.kd_obat and apt_mutasi_obat.kd_unit_apt='D02' and
											apt_mutasi_obat.bulan>='$bulan' and apt_mutasi_obat.bulan<='$bulan1' and apt_mutasi_obat.tahun='$tahun'
											and kd_golongan='$golongan'
											group by apt_mutasi_obat.kd_obat
						) as apbd1 on apt_obat.kd_obat=apbd1.kd_obat 
					left join (
						select apt_mutasi_obat.kd_obat,
											x.saldo_awal,
											x1.saldo_akhir,
											ifnull(sum(apt_mutasi_obat.in_pbf),0) as in_pbf,
											ifnull(sum(apt_mutasi_obat.in_unit),0) as in_unit,
											ifnull(sum(apt_mutasi_obat.retur_jual),0) as retur_jual,
											ifnull(sum(apt_mutasi_obat.out_jual),0) as out_jual,
											ifnull(sum(apt_mutasi_obat.out_unit),0) as out_unit,
											ifnull(sum(apt_mutasi_obat.retur_pbf),0) as retur_pbf,
											ifnull(sum(apt_mutasi_obat.stok_opname),0) as stok_opname,
											ifnull(sum(((apt_mutasi_obat.in_pbf+apt_mutasi_obat.in_unit)-apt_mutasi_obat.retur_pbf)),0) as jum_masuk,
											ifnull(sum(((apt_mutasi_obat.out_jual+apt_mutasi_obat.out_unit)-apt_mutasi_obat.retur_jual)),0) as jum_keluar
											from apt_obat,apt_mutasi_obat
											left join (select ifnull(sum(apt_mutasi_obat.saldo_awal),0) as saldo_awal,kd_obat from apt_mutasi_obat where apt_mutasi_obat.bulan='$bulan' and apt_mutasi_obat.tahun='$tahun' and apt_mutasi_obat.kd_unit_apt='$kd_unit_apt' group by apt_mutasi_obat.kd_obat) as x on apt_mutasi_obat.kd_obat=x.kd_obat
											left join (select ifnull(sum(apt_mutasi_obat.saldo_akhir),0) as saldo_akhir,kd_obat from apt_mutasi_obat where apt_mutasi_obat.bulan='$bulan1' and apt_mutasi_obat.tahun='$tahun' and apt_mutasi_obat.kd_unit_apt='$kd_unit_apt' group by apt_mutasi_obat.kd_obat) as x1 on apt_mutasi_obat.kd_obat=x1.kd_obat
											where apt_mutasi_obat.kd_obat=apt_obat.kd_obat and apt_mutasi_obat.kd_unit_apt='D03' and
											apt_mutasi_obat.bulan>='$bulan' and apt_mutasi_obat.bulan<='$bulan1' and apt_mutasi_obat.tahun='$tahun'
											and kd_golongan='$golongan'
											group by apt_mutasi_obat.kd_obat) as apbd2 on apt_obat.kd_obat=apbd2.kd_obat
					left join (
						select apt_mutasi_obat.kd_obat,
											x.saldo_awal,
											x1.saldo_akhir,
											ifnull(sum(apt_mutasi_obat.in_pbf),0) as in_pbf,
											ifnull(sum(apt_mutasi_obat.in_unit),0) as in_unit,
											ifnull(sum(apt_mutasi_obat.retur_jual),0) as retur_jual,
											ifnull(sum(apt_mutasi_obat.out_jual),0) as out_jual,
											ifnull(sum(apt_mutasi_obat.out_unit),0) as out_unit,
											ifnull(sum(apt_mutasi_obat.retur_pbf),0) as retur_pbf,
											ifnull(sum(apt_mutasi_obat.stok_opname),0) as stok_opname,
											ifnull(sum(((apt_mutasi_obat.in_pbf+apt_mutasi_obat.in_unit)-apt_mutasi_obat.retur_pbf)),0) as jum_masuk,
											ifnull(sum(((apt_mutasi_obat.out_jual+apt_mutasi_obat.out_unit)-apt_mutasi_obat.retur_jual)),0) as jum_keluar
											from apt_obat,apt_mutasi_obat
											left join (select ifnull(sum(apt_mutasi_obat.saldo_awal),0) as saldo_awal,kd_obat from apt_mutasi_obat where apt_mutasi_obat.bulan='$bulan' and apt_mutasi_obat.tahun='$tahun' and apt_mutasi_obat.kd_unit_apt='$kd_unit_apt' group by apt_mutasi_obat.kd_obat) as x on apt_mutasi_obat.kd_obat=x.kd_obat
											left join (select ifnull(sum(apt_mutasi_obat.saldo_akhir),0) as saldo_akhir,kd_obat from apt_mutasi_obat where apt_mutasi_obat.bulan='$bulan1' and apt_mutasi_obat.tahun='$tahun' and apt_mutasi_obat.kd_unit_apt='$kd_unit_apt' group by apt_mutasi_obat.kd_obat) as x1 on apt_mutasi_obat.kd_obat=x1.kd_obat
											where apt_mutasi_obat.kd_obat=apt_obat.kd_obat and apt_mutasi_obat.kd_unit_apt='D04' and
											apt_mutasi_obat.bulan>='$bulan' and apt_mutasi_obat.bulan<='$bulan1' and apt_mutasi_obat.tahun='$tahun'
											and kd_golongan='$golongan'
											group by apt_mutasi_obat.kd_obat
						) as lain on apt_obat.kd_obat=lain.kd_obat
					left join (
						select apt_mutasi_obat.kd_obat,
											x.saldo_awal,
											x1.saldo_akhir,
											ifnull(sum(apt_mutasi_obat.in_pbf),0) as in_pbf,
											ifnull(sum(apt_mutasi_obat.in_unit),0) as in_unit,
											ifnull(sum(apt_mutasi_obat.retur_jual),0) as retur_jual,
											ifnull(sum(apt_mutasi_obat.out_jual),0) as out_jual,
											ifnull(sum(apt_mutasi_obat.out_unit),0) as out_unit,
											ifnull(sum(apt_mutasi_obat.retur_pbf),0) as retur_pbf,
											ifnull(sum(apt_mutasi_obat.stok_opname),0) as stok_opname,
											ifnull(sum(((apt_mutasi_obat.in_pbf+apt_mutasi_obat.in_unit)-apt_mutasi_obat.retur_pbf)),0) as jum_masuk,
											ifnull(sum(((apt_mutasi_obat.out_jual+apt_mutasi_obat.out_unit)-apt_mutasi_obat.retur_jual)),0) as jum_keluar
											from apt_obat,apt_mutasi_obat
											left join (select ifnull(sum(apt_mutasi_obat.saldo_awal),0) as saldo_awal,kd_obat from apt_mutasi_obat where apt_mutasi_obat.bulan='$bulan' and apt_mutasi_obat.tahun='$tahun' and apt_mutasi_obat.kd_unit_apt='$kd_unit_apt' group by apt_mutasi_obat.kd_obat) as x on apt_mutasi_obat.kd_obat=x.kd_obat
											left join (select ifnull(sum(apt_mutasi_obat.saldo_akhir),0) as saldo_akhir,kd_obat from apt_mutasi_obat where apt_mutasi_obat.bulan='$bulan1' and apt_mutasi_obat.tahun='$tahun' and apt_mutasi_obat.kd_unit_apt='$kd_unit_apt' group by apt_mutasi_obat.kd_obat) as x1 on apt_mutasi_obat.kd_obat=x1.kd_obat
											where apt_mutasi_obat.kd_obat=apt_obat.kd_obat and apt_mutasi_obat.kd_unit_apt='apb' and
											apt_mutasi_obat.bulan>='$bulan' and apt_mutasi_obat.bulan<='$bulan1' and apt_mutasi_obat.tahun='$tahun'
											and kd_golongan='$golongan'
											group by apt_mutasi_obat.kd_obat
						) as apbn on apt_obat.kd_obat=apbn.kd_obat
					left join (
						select apt_mutasi_obat.kd_obat,
											x.saldo_awal,
											x1.saldo_akhir,
											ifnull(sum(apt_mutasi_obat.in_pbf),0) as in_pbf,
											ifnull(sum(apt_mutasi_obat.in_unit),0) as in_unit,
											ifnull(sum(apt_mutasi_obat.retur_jual),0) as retur_jual,
											ifnull(sum(apt_mutasi_obat.out_jual),0) as out_jual,
											ifnull(sum(apt_mutasi_obat.out_unit),0) as out_unit,
											ifnull(sum(apt_mutasi_obat.retur_pbf),0) as retur_pbf,
											ifnull(sum(apt_mutasi_obat.stok_opname),0) as stok_opname,
											ifnull(sum(((apt_mutasi_obat.in_pbf+apt_mutasi_obat.in_unit)-apt_mutasi_obat.retur_pbf)),0) as jum_masuk,
											ifnull(sum(((apt_mutasi_obat.out_jual+apt_mutasi_obat.out_unit)-apt_mutasi_obat.retur_jual)),0) as jum_keluar
											from apt_obat,apt_mutasi_obat
											left join (select ifnull(sum(apt_mutasi_obat.saldo_awal),0) as saldo_awal,kd_obat from apt_mutasi_obat where apt_mutasi_obat.bulan='$bulan' and apt_mutasi_obat.tahun='$tahun' and apt_mutasi_obat.kd_unit_apt='$kd_unit_apt' group by apt_mutasi_obat.kd_obat) as x on apt_mutasi_obat.kd_obat=x.kd_obat
											left join (select ifnull(sum(apt_mutasi_obat.saldo_akhir),0) as saldo_akhir,kd_obat from apt_mutasi_obat where apt_mutasi_obat.bulan='$bulan1' and apt_mutasi_obat.tahun='$tahun' and apt_mutasi_obat.kd_unit_apt='$kd_unit_apt' group by apt_mutasi_obat.kd_obat) as x1 on apt_mutasi_obat.kd_obat=x1.kd_obat
											where apt_mutasi_obat.kd_obat=apt_obat.kd_obat and apt_mutasi_obat.kd_unit_apt='U02' and
											apt_mutasi_obat.bulan>='$bulan' and apt_mutasi_obat.bulan<='$bulan1' and apt_mutasi_obat.tahun='$tahun'
											and kd_golongan='$golongan'
											group by apt_mutasi_obat.kd_obat
						) as program on apt_obat.kd_obat=program.kd_obat
					left join (
						select apt_penjualan_detail.kd_obat,
											ifnull(sum(apt_penjualan_detail.qty),0) as total
											from apt_obat,apt_penjualan,apt_penjualan_detail
											where apt_obat.kd_obat=apt_obat.kd_obat and apt_penjualan.no_penjualan=apt_penjualan_detail.no_penjualan and apt_penjualan.customer_id='5' and
											month(apt_penjualan.tgl_penjualan)>='$bulan' and month(apt_penjualan.tgl_penjualan)<='$bulan1' and year(apt_penjualan.tgl_penjualan)='$tahun'
											and kd_golongan='$golongan'
											group by apt_penjualan_detail.kd_obat
						) as kpns on apt_obat.kd_obat=kpns.kd_obat
					left join (
						select apt_penjualan_detail.kd_obat,
											ifnull(sum(apt_penjualan_detail.qty),0) as total
											from apt_obat,apt_penjualan,apt_penjualan_detail
											where apt_obat.kd_obat=apt_obat.kd_obat and apt_penjualan.no_penjualan=apt_penjualan_detail.no_penjualan and apt_penjualan.customer_id='4' and
											month(apt_penjualan.tgl_penjualan)>='$bulan' and month(apt_penjualan.tgl_penjualan)<='$bulan1' and year(apt_penjualan.tgl_penjualan)='$tahun'
											and kd_golongan='$golongan'
											group by apt_penjualan_detail.kd_obat
						) as bs1 on apt_obat.kd_obat=bs1.kd_obat
					left join (
						select apt_penjualan_detail.kd_obat,
											ifnull(sum(apt_penjualan_detail.qty),0) as total
											from apt_obat,apt_penjualan,apt_penjualan_detail
											where apt_obat.kd_obat=apt_obat.kd_obat and apt_penjualan.no_penjualan=apt_penjualan_detail.no_penjualan and apt_penjualan.customer_id='6' and
											month(apt_penjualan.tgl_penjualan)>='$bulan' and month(apt_penjualan.tgl_penjualan)<='$bulan1' and year(apt_penjualan.tgl_penjualan)='$tahun'
											and kd_golongan='$golongan'
											group by apt_penjualan_detail.kd_obat
						) as bs2 on apt_obat.kd_obat=bs2.kd_obat
					left join (
						select apt_penjualan_detail.kd_obat,
											ifnull(sum(apt_penjualan_detail.qty),0) as total
											from apt_obat,apt_penjualan,apt_penjualan_detail
											where apt_obat.kd_obat=apt_obat.kd_obat and apt_penjualan.no_penjualan=apt_penjualan_detail.no_penjualan and apt_penjualan.customer_id='1' and
											month(apt_penjualan.tgl_penjualan)>='$bulan' and month(apt_penjualan.tgl_penjualan)<='$bulan1' and year(apt_penjualan.tgl_penjualan)='$tahun'
											and kd_golongan='$golongan'
											group by apt_penjualan_detail.kd_obat
						) as bu1 on apt_obat.kd_obat=bu1.kd_obat
					left join (
						select apt_penjualan_detail.kd_obat,
											ifnull(sum(apt_penjualan_detail.qty),0) as total
											from apt_obat,apt_penjualan,apt_penjualan_detail
											where apt_obat.kd_obat=apt_obat.kd_obat and apt_penjualan.no_penjualan=apt_penjualan_detail.no_penjualan and apt_penjualan.customer_id='2' and
											month(apt_penjualan.tgl_penjualan)>='$bulan' and month(apt_penjualan.tgl_penjualan)<='$bulan1' and year(apt_penjualan.tgl_penjualan)='$tahun'
											and kd_golongan='$golongan'
											group by apt_penjualan_detail.kd_obat
						) as bu2 on apt_obat.kd_obat=bu2.kd_obat
					left join (
						select apt_penjualan_detail.kd_obat,
											ifnull(sum(apt_penjualan_detail.qty),0) as total
											from apt_obat,apt_penjualan,apt_penjualan_detail
											where apt_obat.kd_obat=apt_obat.kd_obat and apt_penjualan.no_penjualan=apt_penjualan_detail.no_penjualan and apt_penjualan.customer_id='11' and
											month(apt_penjualan.tgl_penjualan)>='$bulan' and month(apt_penjualan.tgl_penjualan)<='$bulan1' and year(apt_penjualan.tgl_penjualan)='$tahun'
											and kd_golongan='$golongan'
											group by apt_penjualan_detail.kd_obat
						) as bl on apt_obat.kd_obat=bl.kd_obat
					left join (
						select apt_penjualan_detail.kd_obat,
											ifnull(sum(apt_penjualan_detail.qty),0) as total
											from apt_obat,apt_penjualan,apt_penjualan_detail
											where apt_obat.kd_obat=apt_obat.kd_obat and apt_penjualan.no_penjualan=apt_penjualan_detail.no_penjualan and apt_penjualan.customer_id='10' and
											month(apt_penjualan.tgl_penjualan)>='$bulan' and month(apt_penjualan.tgl_penjualan)<='$bulan1' and year(apt_penjualan.tgl_penjualan)='$tahun'
											and kd_golongan='$golongan'
											group by apt_penjualan_detail.kd_obat
						) as bb on apt_obat.kd_obat=bb.kd_obat
					left join (
						select apt_penjualan_detail.kd_obat,
											ifnull(sum(apt_penjualan_detail.qty),0) as total
											from apt_obat,apt_penjualan,apt_penjualan_detail
											where apt_obat.kd_obat=apt_obat.kd_obat and apt_penjualan.no_penjualan=apt_penjualan_detail.no_penjualan and apt_penjualan.customer_id not in ('1','2','4','5','6','10','11') and
											month(apt_penjualan.tgl_penjualan)>='$bulan' and month(apt_penjualan.tgl_penjualan)<='$bulan1' and year(apt_penjualan.tgl_penjualan)='$tahun'
											and kd_golongan='$golongan'
											group by apt_penjualan_detail.kd_obat
						) as customerlain on apt_obat.kd_obat=customerlain.kd_obat
					where kd_golongan='$golongan'
					");

				}else{
					$query=$this->db->query("select apt_satuan_kecil.satuan_kecil,apt_mutasi_obat.kd_obat,apt_obat.nama_obat,ifnull(sum(apt_mutasi_obat.in_pbf),0) as in_pbf,ifnull(sum(apt_mutasi_obat.in_unit),0) as in_unit,ifnull(sum(apt_mutasi_obat.retur_jual),0) as retur_jual,
					ifnull(sum(apt_mutasi_obat.out_jual),0) as out_jual,ifnull(sum(apt_mutasi_obat.out_unit),0) as out_unit,ifnull(sum(apt_mutasi_obat.retur_pbf),0) as retur_pbf,ifnull(sum(apt_mutasi_obat.harga_beli),0) as harga_beli,
					ifnull(sum(apt_mutasi_obat.stok_opname),0) as stok_opname,ifnull(sum(apt_mutasi_obat.harga_beli),0) as harga_beli,ifnull(sum((apt_mutasi_obat.saldo_awal*apt_mutasi_obat.harga_beli)),0) as total_awal,
					ifnull(sum(((apt_mutasi_obat.in_pbf+apt_mutasi_obat.in_unit)-apt_mutasi_obat.retur_pbf)),0) as jum_masuk, ifnull(sum((((apt_mutasi_obat.in_pbf+apt_mutasi_obat.in_unit)-apt_mutasi_obat.retur_pbf)*apt_mutasi_obat.harga_beli)),0) as total_masuk,
					ifnull(sum(((apt_mutasi_obat.out_jual+apt_mutasi_obat.out_unit)-apt_mutasi_obat.retur_jual)),0) as jum_keluar,
					ifnull(sum((((apt_mutasi_obat.out_jual+apt_mutasi_obat.out_unit)-apt_mutasi_obat.retur_jual)*apt_mutasi_obat.harga_beli)),0) as total_keluar,
					ifnull(sum((apt_mutasi_obat.saldo_akhir*apt_mutasi_obat.harga_beli)),0) as total_akhir,x.saldo_awal,x1.saldo_akhir
					from apt_obat,apt_satuan_kecil,apt_mutasi_obat left join (select ifnull(sum(apt_mutasi_obat.saldo_awal),0) as saldo_awal,kd_obat from apt_mutasi_obat where apt_mutasi_obat.bulan='$bulan' and apt_mutasi_obat.tahun='$tahun' and apt_mutasi_obat.kd_unit_apt='$kd_unit_apt' group by apt_mutasi_obat.kd_obat) as x on apt_mutasi_obat.kd_obat=x.kd_obat
					left join (select ifnull(sum(apt_mutasi_obat.saldo_akhir),0) as saldo_akhir,kd_obat from apt_mutasi_obat where apt_mutasi_obat.bulan='$bulan1' and apt_mutasi_obat.tahun='$tahun' and apt_mutasi_obat.kd_unit_apt='$kd_unit_apt' group by apt_mutasi_obat.kd_obat) as x1 on apt_mutasi_obat.kd_obat=x1.kd_obat
					where apt_obat.kd_satuan_kecil=apt_satuan_kecil.kd_satuan_kecil and apt_mutasi_obat.kd_obat=apt_obat.kd_obat and apt_mutasi_obat.kd_unit_apt='$kd_unit_apt' and
					apt_mutasi_obat.bulan>='$bulan' and apt_mutasi_obat.bulan<='$bulan1' and apt_mutasi_obat.tahun='$tahun'
					group by apt_mutasi_obat.kd_obat
					having saldo_awal > 0 or in_pbf > 0  or in_unit > 0  or retur_jual > 0  or out_jual > 0  or out_unit > 0  or retur_pbf > 0  or saldo_akhir >0  or stok_opname > 0
					order by apt_mutasi_obat.kd_obat");

				}

		return $query->result_array();
	}

	function getPenerimaanObat($obat,$harga_pokok="",$bulan,$tahun,$kd_unit_apt){
		//$kd_unit_apt=$this->session->userdata('kd_unit_apt');
		if(empty($harga_pokok))$harga=""; else $harga=" and round(apt_penerimaan_detail.harga_pokok)='".$harga_pokok."'";
		$query=$this->db->query("select apt_penerimaan_detail.kd_obat,apt_penerimaan.tgl_penerimaan,apt_penerimaan_detail.harga_beli,ifnull(sum(apt_penerimaan_detail.qty_kcl),0) as qty_kcl from
				apt_obat,apt_penerimaan,apt_penerimaan_detail,apt_unit where apt_penerimaan.no_penerimaan=apt_penerimaan_detail.no_penerimaan
				and apt_penerimaan_detail.kd_obat=apt_obat.kd_obat and apt_penerimaan.kd_unit_apt=apt_unit.kd_unit_apt and
				apt_obat.kd_obat='$obat' and apt_penerimaan.kd_unit_apt='$kd_unit_apt' and 
				month(apt_penerimaan.tgl_penerimaan) = '". $bulan."' and year(apt_penerimaan.tgl_penerimaan) = '".$tahun."' ".$harga."
						group by apt_obat.kd_obat");
						$item= $query->row_array();
						if(empty($item))return 0;
						return $item['qty_kcl'];
	}
	
	function getPenerimaanObatPKM($obat,$bulan,$tahun,$id_pkm){
		//$kd_unit_apt=$this->session->userdata('kd_unit_apt');
		$query=$this->db->query("select ifnull(sum(apt_penjualan_detail.qty),0) as qty from
				apt_obat,apt_penjualan,apt_penjualan_detail,gfk_puskesmas where apt_penjualan.no_penjualan=apt_penjualan_detail.no_penjualan
				and apt_penjualan_detail.kd_obat=apt_obat.kd_obat and apt_penjualan.customer_id=gfk_puskesmas.id and
				apt_obat.kd_obat='$obat' and apt_penjualan.customer_id='$id_pkm' and 
				month(apt_penjualan.tgl_penjualan) = '". $bulan."' and year(apt_penjualan.tgl_penjualan) = '".$tahun."' 
						group by apt_obat.kd_obat");
						$item= $query->row_array();
						if(empty($item))return 0;
						return $item['qty'];
	}
	
	function getPengeluaranDistribusiObat($obat,$bulan,$tahun,$kd_unit_apt){
		$query=$this->db->query("select apt_obat.kd_obat,apt_obat.nama_obat,apt_distribusi.tgl_distribusi,ifnull(sum(apt_distribusi_detail.qty),0) as qty from apt_obat,apt_distribusi,apt_distribusi_detail,
				apt_unit where apt_obat.kd_obat=apt_distribusi_detail.kd_obat
				and apt_distribusi.no_distribusi=apt_distribusi_detail.no_distribusi and apt_unit.kd_unit_apt=apt_distribusi.kd_unit_asal
				and apt_obat.kd_obat='$obat' and apt_distribusi.kd_unit_asal='$kd_unit_apt' and 
				month(apt_distribusi.tgl_distribusi) = '". $bulan."' and year(apt_distribusi.tgl_distribusi) = '".$tahun."'  
				group by apt_obat.kd_obat");
				$item = $query->row_array();
				if(empty($item))return 0;
				return $item['qty'];
	}
	
	function getReturPbfObat($obat,$bulan,$tahun,$kd_unit_apt){
		
		$query=$this->db->query("select apt_retur_obat_detail.kd_obat,apt_retur_obat.tgl_retur,ifnull(sum(apt_retur_obat_detail.qty_kcl),0) as qty_kcl
				from apt_obat,apt_retur_obat,apt_retur_obat_detail,apt_unit
				where apt_retur_obat.no_retur=apt_retur_obat_detail.no_retur and
				apt_retur_obat_detail.kd_obat=apt_obat.kd_obat and apt_retur_obat_detail.kd_unit_apt=apt_unit.kd_unit_apt
				and apt_obat.kd_obat='$obat' and apt_retur_obat_detail.kd_unit_apt='$kd_unit_apt' and 
				month(apt_retur_obat.tgl_retur) = '". $bulan."' and year(apt_retur_obat.tgl_retur) = '".$tahun."'
				group by apt_obat.kd_obat");
				$item = $query->row_array();
				if(empty($item))return 0;
				return $item['qty_kcl'];
	}
	
	function getReturJualObat($obat,$bulan,$tahun,$kd_unit_apt){
		
		$query=$this->db->query("select retur_penjualan_detail.kd_obat,retur_penjualan.tgl_returpenjualan,ifnull(sum(retur_penjualan_detail.qty),0) as qty_kcl
				from apt_obat,retur_penjualan,retur_penjualan_detail,apt_unit
				where retur_penjualan_detail.no_retur_penjualan=retur_penjualan.no_retur_penjualan and
				retur_penjualan_detail.kd_obat=apt_obat.kd_obat and retur_penjualan_detail.kd_unit_apt=apt_unit.kd_unit_apt and apt_obat.kd_obat='$obat'
				and retur_penjualan_detail.kd_unit_apt='$kd_unit_apt' and 
				month(retur_penjualan.tgl_returpenjualan) = '". $bulan."' and year(retur_penjualan.tgl_returpenjualan) = '".$tahun."' 
				group by apt_obat.kd_obat");
				$item = $query->row_array();
				if(empty($item))return 0;
				return $item['qty_kcl'];
	}
	
	function getPenerimaanDistribusiObat($obat,$harga_pokok="",$bulan,$tahun,$kd_unit_apt){
		
		if(empty($harga_pokok))$harga=""; else $harga=" and apt_penerimaan_detail.harga_pokok='".$harga_pokok."'";
		$query=$this->db->query("select apt_obat.kd_obat,apt_obat.nama_obat,apt_distribusi.tgl_distribusi,ifnull(sum(apt_distribusi_detail.qty),0) as qty from apt_obat,apt_distribusi,apt_distribusi_detail,
				apt_unit where apt_obat.kd_obat=apt_distribusi_detail.kd_obat
				and apt_distribusi.no_distribusi=apt_distribusi_detail.no_distribusi and apt_unit.kd_unit_apt=apt_distribusi.kd_unit_tujuan
				and apt_obat.kd_obat='$obat'
				and apt_distribusi.kd_unit_tujuan='$kd_unit_apt' and 
				month(apt_distribusi.tgl_distribusi) = '". $bulan."' and year(apt_distribusi.tgl_distribusi) = '".$tahun."'  ".$harga."
				group by apt_obat.kd_obat");
				$item =  $query->row_array();
				if(empty($item)) return 0;
				return $item['qty'];
	}
	
	function getPenjualanObat($kd_obat,$harga_pokok="",$bulan,$tahun,$kd_unit_apt){
		
		if(empty($harga_pokok))$harga=""; else $harga=" and round(apt_penjualan_detail.harga_pokok)='".$harga_pokok."'";

		$query=$this->db->query("select apt_penjualan_detail.kd_obat,apt_penjualan.tgl_penjualan,ifnull(sum(apt_penjualan_detail.qty),0) as qty,
				apt_penjualan_detail.harga_jual from apt_obat,apt_penjualan,apt_penjualan_detail,apt_unit
				where apt_penjualan.no_penjualan=apt_penjualan_detail.no_penjualan and
				apt_penjualan_detail.kd_obat=apt_obat.kd_obat and apt_penjualan_detail.kd_unit_apt=apt_unit.kd_unit_apt
				and apt_obat.kd_obat='$kd_obat' and apt_penjualan_detail.kd_unit_apt='$kd_unit_apt' and 
				month(apt_penjualan.tgl_penjualan) = '". $bulan."' and year(apt_penjualan.tgl_penjualan) = '".$tahun."' ".$harga."
				group by apt_obat.kd_obat");
				$item = $query->row_array();
				if(empty($item))return 0;
				return $item['qty'];
	}
	
	function getPemakaianObatPKM($kd_obat,$bulan,$tahun,$id_pkm){
		
		$query=$this->db->query("select sum(jumlah) as qty from nota_keluar_obat_puskesmas a join obat_keluar_puskesmas b on a.id=b.id
				where a.id_puskesmas='".$id_pkm."' and kd_obat='".$kd_obat."' and
				month(a.tgl) = '". $bulan."' and year(a.tgl) = '".$tahun."' 
				group by b.kd_obat");
				$item = $query->row_array();
				if(empty($item))return 0;
				return $item['qty'];
	}
	
	function getDisposalObat($kd_obat,$harga_pokok="",$bulan,$tahun,$kd_unit_apt){
		
		if(empty($harga_pokok))$harga=""; else $harga=" and round(apt_disposal_detail.harga_pokok)='".$harga_pokok."'";
		$query=$this->db->query("select apt_disposal_detail.kd_obat,apt_disposal.tanggal,ifnull(sum(apt_disposal_detail.qty),0) as qty,
				0 as harga_jual from apt_obat,apt_disposal,apt_disposal_detail,apt_unit
				where apt_disposal.no_disposal=apt_disposal_detail.no_disposal and
				apt_disposal_detail.kd_obat=apt_obat.kd_obat and apt_disposal_detail.kd_unit_apt=apt_unit.kd_unit_apt
				and apt_obat.kd_obat='$kd_obat' and apt_disposal_detail.kd_unit_apt='$kd_unit_apt' and 
				month(apt_disposal.tanggal) = '". $bulan."' and year(apt_disposal.tanggal) = '".$tahun."'  ".$harga." and approval=1
				group by apt_obat.kd_obat");
				$item = $query->row_array();
				if(empty($item))return 0;
				return $item['qty'];
	}
	
	function stokopnameObat($obat,$harga_pokok="",$bulan,$tahun,$kd_unit_apt){
		
		//if(empty($harga_pokok))$harga=""; else $harga=" and history_perubahan_stok.harga='".$harga_pokok."'";
		if(empty($harga_pokok))$harga=""; else $harga=" and round(history_perubahan_stok.harga)='".$harga_pokok."'";
		/*$query=$this->db->query("select history_perubahan_stok.kd_obat,ifnull( sum( history_perubahan_stok.stok_baru - history_perubahan_stok.stok_lama ) , 0 ) as jumlah from apt_unit,
				history_perubahan_stok,apt_obat where history_perubahan_stok.kd_obat=apt_obat.kd_obat and
				history_perubahan_stok.kd_unit_apt=apt_unit.kd_unit_apt and history_perubahan_stok.kd_obat='$obat' and
				history_perubahan_stok.kd_unit_apt='$kd_unit_apt' and 
				month(history_perubahan_stok.tanggal) = '". $bulan."' and year(history_perubahan_stok.tanggal) = '".$tahun."' ".$harga."
				GROUP BY history_perubahan_stok.kd_unit_apt, history_perubahan_stok.kd_obat,harga ");*/

		$query=$this->db->query("select history_perubahan_stok.kd_obat,ifnull( sum( history_perubahan_stok.stok_baru ) , 0 ) as jumlah from apt_unit,
				history_perubahan_stok,apt_obat where history_perubahan_stok.kd_obat=apt_obat.kd_obat and
				history_perubahan_stok.kd_unit_apt=apt_unit.kd_unit_apt and history_perubahan_stok.kd_obat='$obat' and
				history_perubahan_stok.kd_unit_apt='$kd_unit_apt' and 
				month(history_perubahan_stok.tanggal) = '". $bulan."' and year(history_perubahan_stok.tanggal) = '".$tahun."' ".$harga."
				GROUP BY history_perubahan_stok.kd_unit_apt, history_perubahan_stok.kd_obat,round(history_perubahan_stok.harga) ");
				$item = $query->row_array();
				if(empty($item))return "-";
				return $item['jumlah'];
	}
	
	function getMutasiPerObat($obat,$harga_pokok="",$bulan,$tahun,$kd_unit_apt){
		//$kd_unit_apt=$this->session->userdata('kd_unit_apt');
		if(empty($harga_pokok)){
			$query=$this->db->query("select * from apt_mutasi_obat where kd_unit_apt='$kd_unit_apt' and bulan='$bulan' and tahun='$tahun' and kd_obat='$obat' ");
		}else{
			$query=$this->db->query("select * from apt_mutasi_obat where kd_unit_apt='$kd_unit_apt' and bulan='$bulan' and tahun='$tahun' and kd_obat='$obat' and harga_pokok='$harga_pokok' ");
		}
		return $query->row_array();
	}
	
	function getMutasiPerObatPKM($obat,$bulan,$tahun,$id_pkm){
		//$kd_unit_apt=$this->session->userdata('kd_unit_apt');
		$query=$this->db->query("select * from apt_mutasi_obat_puskesmas where id_puskesmas='$id_pkm' and bulan='$bulan' and tahun='$tahun' and kd_obat='$obat' ");
		return $query->row_array();
	}
	
	function ambilDataObat($kd_unit_apt=""){
		//$kd_unit_apt=$this->session->userdata('kd_unit_apt');
		//$query=$this->db->query("select * from apt_obat ");
		$query=$this->db->query("select apt_stok_unit.*,apt_obat.nama_obat,round(apt_stok_unit.harga_pokok) as harga_pokok from apt_stok_unit join apt_obat where apt_stok_unit.harga_pokok>0 group by apt_stok_unit.kd_obat,round(apt_stok_unit.harga_pokok) ");
		return $query->result_array();
	}
	
	function stokopname($bulan,$tahun){
		$kd_unit_apt=$this->session->userdata('kd_unit_apt');
		$query=$this->db->query("select history_perubahan_stok.kd_obat,history_perubahan_stok.qty,apt_stok_unit.harga_pokok from apt_unit,
								history_perubahan_stok,apt_obat,apt_stok_unit where history_perubahan_stok.kd_obat=apt_obat.kd_obat and
								apt_stok_unit.kd_obat=apt_obat.kd_obat and history_perubahan_stok.kd_unit_apt=apt_unit.kd_unit_apt and
								apt_stok_unit.kd_unit_apt=apt_unit.kd_unit_apt
								and history_perubahan_stok.kd_unit_apt='$kd_unit_apt' and month(history_perubahan_stok.tanggal)='$bulan'
								and year(history_perubahan_stok.tanggal)='$tahun'");
		return $query->result_array();
	}
	
	function ambilObat($b,$a1){
		$kd_unit_apt=$this->session->userdata('kd_unit_apt');
		$query=$this->db->query("select kd_obat,harga_beli from apt_mutasi_obat where kd_unit_apt='$kd_unit_apt' and bulan='$b' and tahun='$a1'");
		return $query->result_array();
	}
	
	function ambilyesterday($tgl_penjualan){
		$tanggal=convertDate($tgl_penjualan);
		$query=$this->db->query("SELECT DATE_SUB('$tanggal',interval 1 day) as yesterday");
		return $query->row_array();
	}
	
	function saldoawal($b,$a1,$kd_obat){
		$kd_unit_apt=$this->session->userdata('kd_unit_apt');
		$query=$this->db->query("select saldo_akhir as saldoawal from apt_mutasi_obat where bulan='$b' and tahun='$a1' and kd_obat='$kd_obat' and kd_unit_apt='$kd_unit_apt'");
		$saldo_awal=$query->row_array();
		if(empty($saldo_awal)) return '-';
		return $saldo_awal['saldoawal'];
	}
	
	function ambiloutunit($bulan,$tahun,$kd_obat){
		$kd_unit_apt=$this->session->userdata('kd_unit_apt');
		$query=$this->db->query("select out_unit from apt_mutasi_obat where bulan='$bulan' and tahun='$tahun' and kd_obat='$kd_obat' and kd_unit_apt='$kd_unit_apt'");
		$out_unita=$query->row_array();
		if(empty($out_unita)) return 0;
		return $out_unita['out_unit'];
	}
	
	function ambiloutjual($bulan,$tahun,$kd_obat){
		$kd_unit_apt=$this->session->userdata('kd_unit_apt');
		$query=$this->db->query("select out_jual from apt_mutasi_obat where bulan='$bulan' and tahun='$tahun' and kd_obat='$kd_obat' and kd_unit_apt='$kd_unit_apt'");
		$out_juala=$query->row_array();
		if(empty($out_juala)) return 0;
		return $out_juala['out_jual'];
	}
	
	function ambilreturpebef($bulan,$tahun,$kd_obat){
		$kd_unit_apt=$this->session->userdata('kd_unit_apt');
		$query=$this->db->query("select retur_pbf from apt_mutasi_obat where bulan='$bulan' and tahun='$tahun' and kd_obat='$kd_obat' and kd_unit_apt='$kd_unit_apt'");
		$retur_pbfa=$query->row_array();
		if(empty($retur_pbfa)) return 0;
		return $retur_pbfa['retur_pbf'];
	}
	
	function ambilinpebef($bulan,$tahun,$kd_obat){
		$kd_unit_apt=$this->session->userdata('kd_unit_apt');
		$query=$this->db->query("select in_pbf from apt_mutasi_obat where bulan='$bulan' and tahun='$tahun' and kd_obat='$kd_obat' and kd_unit_apt='$kd_unit_apt'");
		$in_pbfa=$query->row_array();
		if(empty($in_pbfa)) return 0;
		return $in_pbfa['in_pbf'];
	}
	
	function ambilinunit($bulan,$tahun,$kd_obat){
		$kd_unit_apt=$this->session->userdata('kd_unit_apt');
		$query=$this->db->query("select in_unit from apt_mutasi_obat where bulan='$bulan' and tahun='$tahun' and kd_obat='$kd_obat' and kd_unit_apt='$kd_unit_apt'");
		$in_unita=$query->row_array();
		if(empty($in_unita)) return 0;
		return $in_unita['in_unit'];
	}
	
	function ambilstokop($bulan,$tahun,$kd_obat){
		$kd_unit_apt=$this->session->userdata('kd_unit_apt');
		$query=$this->db->query("select stok_opname from apt_mutasi_obat where bulan='$bulan' and tahun='$tahun' and kd_obat='$kd_obat' and kd_unit_apt='$kd_unit_apt'");
		$stokop=$query->row_array();
		if(empty($stokop)) return 0;
		return $stokop['stok_opname'];
	}
	
	function ambilNamaUnit($kd_unit_apt){
		//$kd_unit_apt=$this->session->userdata('kd_unit_apt');
		$query=$this->db->query("select nama_unit_apt from apt_unit where kd_unit_apt='$kd_unit_apt'");
		$unit=$query->row_array();
		return $unit['nama_unit_apt'];
	}
	
	function namaSupplier($kd_supplier){
		$query=$this->db->query("select nama from apt_supplier where kd_supplier='$kd_supplier'");
		$supplier=$query->row_array();
		if(empty($supplier)) return 0;
		return $supplier['nama'];
	}
	
	function ambiltotalakhir($tgl_penjualan,$kd_unit_apt,$is_lunas,$resep){
		$kd_unit_apt=$this->session->userdata('kd_unit_apt');
		$tgl_penjualan1=convertDate($tgl_penjualan);
		if($resep!=''){$b1=" and apt_penjualan.resep='$resep'";}
		else{$b1="";} $b=$b1;
		$query=$this->db->query("select sum(total_transaksi-adm_racik) as totalakhir from apt_penjualan where 
					tgl_penjualan between concat((SELECT DATE_SUB('$tgl_penjualan1',interval 1 day) as yesterday),' ','14:00:00') and concat('$tgl_penjualan1',' ','13:59:59') 
					and is_lunas='$is_lunas' and kd_unit_apt='$kd_unit_apt' $b");
		$totalakhir=$query->row_array();
		return $totalakhir['totalakhir'];
	}
	
	
	function getRekapPenjualanApotek($periodeawal,$periodeakhir,$kd_unit_apt){
			
			$query=$this->db->query("select apt_penjualan_detail.kd_obat,apt_obat.nama_obat,
										sum(apt_penjualan_detail.qty) as qty,apt_penjualan_detail.harga_jual,
										apt_satuan_kecil.satuan_kecil,sum(apt_penjualan_detail.total) as totalsemua,0 as diskon from apt_penjualan,apt_penjualan_detail,apt_obat,apt_satuan_kecil 
										where apt_penjualan.no_penjualan=apt_penjualan_detail.no_penjualan
										and  apt_penjualan_detail.kd_obat=apt_obat.kd_obat
										and apt_obat.kd_satuan_kecil=apt_satuan_kecil.kd_satuan_kecil 
										and apt_penjualan_detail.kd_unit_apt='$kd_unit_apt'  and 
										date_format(apt_penjualan.tgl_penjualan,'%Y-%m-%d') between '". convertDate($periodeawal)."' and '".convertDate($periodeakhir)."' 
										group by apt_penjualan_detail.kd_obat");			
		
		
		return $query->result_array();
	}
	
	function getRekapNoPenjualan($periodeawal,$periodeakhir,$kd_unit_apt,$status,$is_lunas,$resep){
		$periodeawal1=convertDate($periodeawal);
		$periodeakhir1=convertDate($periodeakhir);
		$kd_unit_apt=$this->session->userdata('kd_unit_apt');
		
		if($resep!=''){$b1=" and apt_penjualan.resep='$resep'";}
		else{$b1="";} $b=$b1;
		
		$query1=$this->db->query("select adddate('$periodeawal1',1) as tgl");
		$tgl=$query1->row_array();
		$tgltambah=$tgl['tgl'];
		
		if($status==0){
			$query=$this->db->query("select date_format(apt_penjualan.tgl_penjualan,'%d-%m-%Y %H:%m:%s') as tgl_penjualan,apt_penjualan.no_penjualan,apt_penjualan.nama_pasien,apt_customers.customer,
									apt_penjualan.is_lunas,apt_penjualan.status,date_format(apt_penjualan.tgl_tutup,'%d-%m-%Y %H:%m:%s') as tgl_tutup,ifnull((apt_penjualan.total_transaksi-apt_penjualan.adm_racik),0) as total_transaksi 
									from apt_penjualan,apt_customers,apt_unit where apt_penjualan.cust_code=apt_customers.cust_code and apt_penjualan.kd_unit_apt=apt_unit.kd_unit_apt 
									and date_format(apt_penjualan.tgl_penjualan,'%Y-%m-%d') between '$periodeawal1' and '$periodeakhir1' and apt_penjualan.kd_unit_apt='$kd_unit_apt' and 
									apt_penjualan.is_lunas='$is_lunas' $b and apt_penjualan.status='0' and apt_penjualan.tgl_tutup='0000-00-00 00:00:00' ");
		}
		else{
			if($periodeawal==$periodeakhir){
				$query=$this->db->query("select date_format(apt_penjualan.tgl_penjualan,'%d-%m-%Y %H:%m:%s') as tgl_penjualan,apt_penjualan.no_penjualan,apt_penjualan.nama_pasien,apt_customers.customer,
									apt_penjualan.is_lunas,apt_penjualan.status,date_format(apt_penjualan.tgl_tutup,'%d-%m-%Y %H:%m:%s') as tgl_tutup,ifnull((apt_penjualan.total_transaksi-apt_penjualan.adm_racik),0) as total_transaksi
									from apt_penjualan,apt_customers,apt_unit where apt_penjualan.cust_code=apt_customers.cust_code and apt_penjualan.kd_unit_apt=apt_unit.kd_unit_apt and
									date_format(apt_penjualan.tgl_penjualan,'%Y-%m-%d') between '$periodeawal1' and '$periodeakhir1' and
									apt_penjualan.kd_unit_apt='$kd_unit_apt' and apt_penjualan.is_lunas='$is_lunas' $b and apt_penjualan.status='1' and date_format(apt_penjualan.tgl_tutup,'%Y-%m-%d')='$periodeawal1'");
			}
			else{
				$query=$this->db->query("select date_format(apt_penjualan.tgl_penjualan,'%d-%m-%Y %H:%m:%s') as tgl_penjualan,apt_penjualan.no_penjualan,apt_penjualan.nama_pasien,apt_customers.customer,
									apt_penjualan.is_lunas,apt_penjualan.status,date_format(apt_penjualan.tgl_tutup,'%d-%m-%Y %H:%m:%s') as tgl_tutup,ifnull((apt_penjualan.total_transaksi-apt_penjualan.adm_racik),0) as total_transaksi 
									from apt_penjualan,apt_customers,apt_unit where apt_penjualan.cust_code=apt_customers.cust_code and apt_penjualan.kd_unit_apt=apt_unit.kd_unit_apt and
									date_format(apt_penjualan.tgl_penjualan,'%Y-%m-%d') between '$periodeawal1' and '$periodeakhir1' and
									apt_penjualan.kd_unit_apt='$kd_unit_apt' and apt_penjualan.is_lunas='$is_lunas' $b and apt_penjualan.status='1' and date_format(apt_penjualan.tgl_tutup,'%Y-%m-%d') between '$tgltambah' and '$periodeakhir1'");
			}
		}
		return $query->result_array();
	}
	
	function QueryPenjualanObat($periodeawal,$periodeakhir,$kd_unit_apt,$kd_obat){
		$periodeawal1=convertDate($periodeawal);
		$periodeakhir1=convertDate($periodeakhir);
		
		if($kd_unit_apt!=''){$a1=" and apt_penjualan.kd_unit_apt='$kd_unit_apt'";}
		else{$a1="";} $a=$a1;
		
		if($kd_obat!=''){$b1=" and apt_penjualan_detail.kd_obat='$kd_obat'";}
		else{$b1="";} $b=$b1;
		
		$query=$this->db->query("select apt_penjualan_detail.kd_obat as kd_obat1,apt_penjualan.kd_unit_apt,apt_obat.nama_obat,sum(apt_penjualan_detail.qty) as qty, 
								(select ifnull((sum(jml_stok)),0) from apt_stok_unit where kd_unit_apt='u01' and kd_obat=kd_obat1) as jml_stok
								from apt_penjualan,apt_penjualan_detail,apt_obat,
								apt_stok_unit,apt_unit where apt_penjualan.no_penjualan=apt_penjualan_detail.no_penjualan and apt_penjualan.kd_unit_apt=apt_unit.kd_unit_apt 
								and apt_penjualan_detail.kd_obat=apt_obat.kd_obat and apt_stok_unit.kd_obat=apt_obat.kd_obat and apt_penjualan_detail.tgl_expire=apt_stok_unit.tgl_expire
								and apt_stok_unit.kd_unit_apt=apt_unit.kd_unit_apt and date_format(apt_penjualan.tgl_penjualan,'%Y-%m-%d') between '$periodeawal1' and '$periodeakhir1'
								$a $b group by apt_penjualan_detail.kd_obat");
		return $query->result_array();
	}
	
	function detilnyaPenjualanobat($periodeawal,$periodeakhir,$kd_unit_apt,$kd_obat){
		$periodeawal1=convertDate($periodeawal);
		$periodeakhir1=convertDate($periodeakhir);
		
		if($kd_unit_apt!=''){$a1=" and apt_penjualan.kd_unit_apt='$kd_unit_apt'";}
		else{$a1="";} $a=$a1;
		
		$query=$this->db->query("select date_format(apt_penjualan.tgl_penjualan,'%d-%m-%Y') as tgl_penjualan,apt_penjualan.no_penjualan,apt_penjualan.kd_unit_apt,
								apt_unit.nama_unit_apt,apt_penjualan_detail.qty from apt_penjualan,apt_penjualan_detail,apt_obat,apt_unit where
								apt_penjualan.no_penjualan=apt_penjualan_detail.no_penjualan and apt_penjualan.kd_unit_apt=apt_unit.kd_unit_apt and
								apt_penjualan_detail.kd_obat=apt_obat.kd_obat and date_format(apt_penjualan.tgl_penjualan,'%Y-%m-%d') between '$periodeawal1' and '$periodeakhir1'
								$a and apt_penjualan_detail.kd_obat='$kd_obat'");
		return $query->result_array();
	}
	
	function tes($kd_obat){		
		$query=$this->db->query("select kd_obat,nama_obat from apt_obat where kd_obat='$kd_obat'");
		return $query->row_array();
	}
	
	function queryexcel($periodeawal,$periodeakhir,$kd_unit_apt,$kd_obat){
		$periodeawal1=convertDate($periodeawal);
		$periodeakhir1=convertDate($periodeakhir);
		
		if($kd_unit_apt!=''){$a1=" and apt_penjualan.kd_unit_apt='$kd_unit_apt'";}
		else{$a1="";} $a=$a1;
		
		if($kd_obat!=''){$b1=" and apt_penjualan_detail.kd_obat='$kd_obat'";}
		else{$b1="";} $b=$b1;
		
		$query=$this->db->query("select date_format(apt_penjualan.tgl_penjualan,'%d-%m-%Y') as tgl_penjualan,apt_penjualan_detail.kd_obat,apt_obat.nama_obat,apt_penjualan.no_penjualan,
								apt_unit.nama_unit_apt,apt_penjualan_detail.qty from apt_penjualan,apt_penjualan_detail,apt_obat,apt_unit 
								where apt_penjualan.no_penjualan=apt_penjualan_detail.no_penjualan and apt_penjualan.kd_unit_apt=apt_unit.kd_unit_apt and 
								apt_penjualan_detail.kd_obat=apt_obat.kd_obat and date_format(apt_penjualan.tgl_penjualan,'%Y-%m-%d') between '$periodeawal1' and '$periodeakhir1' 
								$a $b");
		return $query->result_array();
	}
	
	function ambiljamsekarang(){
		$query=$this->db->query("select date_format(sysdate(),'%H:%i:%s') as jam");
		$jam=$query->row_array();
		return $jam['jam'];
	}
	
	function ambiltglkmrn($tglskrg){
		//$query=$this->db->query("select date_format(sysdate(),'%Y-%m-%d') as tglskrg");
		$query=$this->db->query("SELECT DATE_SUB('$tglskrg',interval 1 day) as tglkmrn");
		$tglkmrn=$query->row_array();
		return $tglkmrn['tglkmrn'];
	}
	
	function ambilIsiPenjualan($periodeawal,$periodeakhir,$kd_unit_apt){
		$periodeawal1=convertDate($periodeawal);
		$periodeakhir1=convertDate($periodeakhir);
		
		if($kd_unit_apt!=''){$kd_unit_apt=" and apt_penjualan_detail.kd_unit_apt='$kd_unit_apt'";}
		else{$kd_unit_apt="";}
		
		$query=$this->db->query("select apt_penjualan_detail.no_penjualan,
								apt_penjualan_detail.kd_obat,date_format(apt_penjualan.tgl_penjualan,'%Y-%m-%d') as tgl_penjualan,
								apt_obat.nama_obat,
								apt_satuan_kecil.satuan_kecil,
								apt_penjualan_detail.qty,
								apt_penjualan_detail.tgl_expire,
								apt_unit.nama_unit_apt,
								apt_penjualan_detail.harga_jual 
								from apt_penjualan_detail,
								apt_penjualan,
								apt_obat,
								apt_satuan_kecil,
								apt_unit
								where apt_penjualan_detail.no_penjualan=apt_penjualan.no_penjualan 
								and apt_penjualan_detail.kd_obat=apt_obat.kd_obat 
								and apt_obat.kd_satuan_kecil=apt_satuan_kecil.kd_satuan_kecil 
								and date_format(apt_penjualan.tgl_penjualan,'%Y-%m-%d') between '$periodeawal1' and '$periodeakhir1' 
								and apt_penjualan_detail.kd_unit_apt=apt_unit.kd_unit_apt $kd_unit_apt 
								order by apt_penjualan.no_penjualan,apt_penjualan_detail.kd_obat");
		
		return $query->result_array();
	}
	
	function getWow($bulan,$tahun,$kd_unit_apt){
		
		$query=$this->db->query("select history_perubahan_stok.nomor,history_perubahan_stok.tanggal,history_perubahan_stok.kd_obat,apt_obat.nama_obat,apt_pabrik.nama_pabrik,apt_satuan_kecil.satuan_kecil,history_perubahan_stok.stok_lama,
								history_perubahan_stok.stok_baru,harga, history_perubahan_stok.tgl_expired,history_perubahan_stok.batch from history_perubahan_stok left join apt_pabrik on history_perubahan_stok.kd_pabrik=apt_pabrik.kd_pabrik,apt_obat,apt_unit,apt_satuan_kecil
								where history_perubahan_stok.kd_obat=apt_obat.kd_obat and apt_obat.kd_satuan_kecil=apt_satuan_kecil.kd_satuan_kecil and
								month(history_perubahan_stok.tanggal)='$bulan' and year(history_perubahan_stok.tanggal)='$tahun' and history_perubahan_stok.kd_unit_apt=apt_unit.kd_unit_apt
								and history_perubahan_stok.kd_unit_apt='$kd_unit_apt' order by history_perubahan_stok.kd_obat");
		return $query->result_array(); 
	}
	
	function getStatusPermintaan($periodeawal,$periodeakhir,$permintaan_status,$kd_unit_apt){
		$kd_unit_aptA=$this->session->userdata('kd_unit_apt');
		$kd_unit_aptB=$this->session->userdata('kd_unit_apt_gudang');
		$periodeawal1=convertDate($periodeawal);
		$periodeakhir1=convertDate($periodeakhir);
		if($permintaan_status==1){ //kalo sudah didistribusi
			$a1="and apt_permintaan_obat_det.jml_req=apt_permintaan_obat_det.jml_distribusi";
		}
		else if($permintaan_status==2){ //kalo udh didistribusi sebagian
			$a1="and apt_permintaan_obat_det.jml_req>apt_permintaan_obat_det.jml_distribusi and apt_permintaan_obat_det.jml_distribusi>0";
		}
		else if($permintaan_status==3){ //kalo belum didistribusi
			$a1="and apt_permintaan_obat_det.jml_distribusi='0'";
		}
		else{ //kalo semuanya -->permintaan_status=0
			$a1="";
		}
		$a=$a1;
		if($kd_unit_aptA==$kd_unit_aptB){
			if($kd_unit_apt==''){
				$query=$this->db->query("select apt_permintaan_obat.no_permintaan,date_format(apt_permintaan_obat.tgl_permintaan,'%d-%m-%Y %H:%i:%s') as tgl_permintaan,apt_permintaan_obat_det.kd_obat,apt_obat.nama_obat,
									apt_satuan_kecil.satuan_kecil,apt_permintaan_obat_det.tgl_expire,apt_permintaan_obat_det.jml_req,apt_permintaan_obat_det.jml_distribusi,apt_unit.nama_unit_apt
									from apt_permintaan_obat,apt_permintaan_obat_det,apt_obat,apt_satuan_kecil,apt_unit
									where date_format(apt_permintaan_obat.tgl_permintaan,'%Y-%m-%d') between '$periodeawal1' and '$periodeakhir1' and apt_permintaan_obat_det.no_permintaan=apt_permintaan_obat.no_permintaan and apt_permintaan_obat_det.kd_obat=apt_obat.kd_obat
									and apt_permintaan_obat.kd_unit_apt=apt_unit.kd_unit_apt and apt_obat.kd_satuan_kecil=apt_satuan_kecil.kd_satuan_kecil $a order by apt_permintaan_obat.no_permintaan desc");
			}
			else{
				$query=$this->db->query("select apt_permintaan_obat.no_permintaan,date_format(apt_permintaan_obat.tgl_permintaan,'%d-%m-%Y %H:%i:%s') as tgl_permintaan,apt_permintaan_obat_det.kd_obat,apt_obat.nama_obat,
									apt_satuan_kecil.satuan_kecil,apt_permintaan_obat_det.tgl_expire,apt_permintaan_obat_det.jml_req,apt_permintaan_obat_det.jml_distribusi,apt_unit.nama_unit_apt
									from apt_permintaan_obat,apt_permintaan_obat_det,apt_obat,apt_satuan_kecil,apt_unit
									where date_format(apt_permintaan_obat.tgl_permintaan,'%Y-%m-%d') between '$periodeawal1' and '$periodeakhir1' and apt_permintaan_obat_det.no_permintaan=apt_permintaan_obat.no_permintaan and apt_permintaan_obat_det.kd_obat=apt_obat.kd_obat
									and apt_permintaan_obat.kd_unit_apt=apt_unit.kd_unit_apt and apt_obat.kd_satuan_kecil=apt_satuan_kecil.kd_satuan_kecil and apt_permintaan_obat.kd_unit_apt='$kd_unit_apt' $a order by apt_permintaan_obat.no_permintaan desc");
			}
		}
		else {
			$kd_unit_apt=$this->session->userdata('kd_unit_apt');
			$query=$this->db->query("select apt_permintaan_obat.no_permintaan,date_format(apt_permintaan_obat.tgl_permintaan,'%d-%m-%Y %H:%i:%s') as tgl_permintaan,apt_permintaan_obat_det.kd_obat,apt_obat.nama_obat,
									apt_satuan_kecil.satuan_kecil,apt_permintaan_obat_det.tgl_expire,apt_permintaan_obat_det.jml_req,apt_permintaan_obat_det.jml_distribusi,apt_unit.nama_unit_apt
									from apt_permintaan_obat,apt_permintaan_obat_det,apt_obat,apt_satuan_kecil,apt_unit
									where date_format(apt_permintaan_obat.tgl_permintaan,'%Y-%m-%d') between '$periodeawal1' and '$periodeakhir1' and apt_permintaan_obat_det.no_permintaan=apt_permintaan_obat.no_permintaan and apt_permintaan_obat_det.kd_obat=apt_obat.kd_obat
									and apt_permintaan_obat.kd_unit_apt=apt_unit.kd_unit_apt and apt_obat.kd_satuan_kecil=apt_satuan_kecil.kd_satuan_kecil and apt_permintaan_obat.kd_unit_apt='$kd_unit_apt' $a order by apt_permintaan_obat.no_permintaan desc");
		}
		return $query->result_array();
	}
	
	function getStatusPemesanan($periodeawal,$periodeakhir,$pemesanan_status,$kd_supplier){
		//$kd_unit_apt=$this->session->userdata('kd_unit_apt');
		$periodeawal1=convertDate($periodeawal);
		$periodeakhir1=convertDate($periodeakhir);
		if($pemesanan_status==1){ //kalo sudah datang
			$a1="and apt_pemesanan_detail.qty_kcl=apt_pemesanan_detail.jml_penerimaan";
		}
		else if($pemesanan_status==2){ //kalo udh datang sebagian
			$a1="and apt_pemesanan_detail.qty_kcl>apt_pemesanan_detail.jml_penerimaan and apt_pemesanan_detail.jml_penerimaan>0";
		}
		else if($pemesanan_status==3){ //kalo belum datang
			$a1="and apt_pemesanan_detail.jml_penerimaan='0'";
		}
		else{ //kalo semuanya -->pemesanan_status=0
			$a1="";
		}
		$a=$a1;
		if($kd_supplier==''){
			$query=$this->db->query("select apt_pemesanan.no_pemesanan,date_format(apt_pemesanan.tgl_pemesanan,'%d-%m-%Y %H:%i:%s') as tgl_pemesanan,apt_pemesanan_detail.kd_obat,apt_obat.nama_obat,
								apt_satuan_kecil.satuan_kecil,apt_pemesanan_detail.qty_kcl,apt_pemesanan_detail.jml_penerimaan,apt_supplier.nama
								from apt_pemesanan,apt_pemesanan_detail,apt_obat,apt_satuan_kecil,apt_supplier
								where date_format(apt_pemesanan.tgl_pemesanan,'%Y-%m-%d') between '$periodeawal1' and '$periodeakhir1' and apt_pemesanan_detail.no_pemesanan=apt_pemesanan.no_pemesanan and apt_pemesanan_detail.kd_obat=apt_obat.kd_obat
								and apt_pemesanan.kd_supplier=apt_supplier.kd_supplier and apt_obat.kd_satuan_kecil=apt_satuan_kecil.kd_satuan_kecil $a order by apt_pemesanan.no_pemesanan desc");
		}
		else{
			$query=$this->db->query("select apt_pemesanan.no_pemesanan,date_format(apt_pemesanan.tgl_pemesanan,'%d-%m-%Y %H:%i:%s') as tgl_pemesanan,apt_pemesanan_detail.kd_obat,apt_obat.nama_obat,
								apt_satuan_kecil.satuan_kecil,apt_pemesanan_detail.qty_kcl,apt_pemesanan_detail.jml_penerimaan,apt_supplier.nama
								from apt_pemesanan,apt_pemesanan_detail,apt_obat,apt_satuan_kecil,apt_supplier
								where date_format(apt_pemesanan.tgl_pemesanan,'%Y-%m-%d') between '$periodeawal1' and '$periodeakhir1' and apt_pemesanan_detail.no_pemesanan=apt_pemesanan.no_pemesanan and apt_pemesanan_detail.kd_obat=apt_obat.kd_obat
								and apt_pemesanan.kd_supplier=apt_supplier.kd_supplier and apt_obat.kd_satuan_kecil=apt_satuan_kecil.kd_satuan_kecil and apt_pemesanan.kd_supplier='$kd_supplier' $a order by apt_pemesanan.no_pemesanan desc");
		}
		return $query->result_array();
	}
	
	function getLog($periodeawal,$periodeakhir,$kd_supplier,$jenis){
		$periodeawal1=convertDate($periodeawal);
		$periodeakhir1=convertDate($periodeakhir);
		
		if($kd_supplier!=''){$a1="and apt_penerimaan.kd_supplier='$kd_supplier'";}
		else{$a1="";} $a=$a1;
		
		if($jenis!=''){$b1="and apt_log_penerimaan.jenis='$jenis'";}
		else{$b1="";} $b=$b1;
		
		$query=$this->db->query("select apt_penerimaan.no_penerimaan,apt_penerimaan.kd_supplier,apt_supplier.nama,date_format(apt_log_penerimaan.tgl,'%d-%m-%Y %H:%i:%s') as tgl,
								apt_log_penerimaan.alasan,pegawai.nama_pegawai from apt_penerimaan,apt_supplier,apt_log_penerimaan,user,pegawai 
								where apt_log_penerimaan.no_penerimaan=apt_penerimaan.no_penerimaan and apt_penerimaan.kd_supplier=apt_supplier.kd_supplier
								and apt_log_penerimaan.kd_user=user.id_user and user.id_pegawai=pegawai.id_pegawai and 
								date_format(apt_log_penerimaan.tgl,'%Y-%m-%d') between '$periodeawal1' and '$periodeakhir1' $a $b order by apt_log_penerimaan.tgl desc");
		return $query->result_array();
	}
	
	function getReturJual1($bulan,$tahun){
		$kd_unit_apt=$this->session->userdata('kd_unit_apt');
		$query=$this->db->query("select retur_penjualan_detail.kd_obat,retur_penjualan.tgl_returpenjualan,sum(retur_penjualan_detail.qty) as qty_kcl
								from apt_obat,retur_penjualan,retur_penjualan_detail,apt_unit 
								where retur_penjualan_detail.no_retur_penjualan=retur_penjualan.no_retur_penjualan and 
								retur_penjualan_detail.kd_obat=apt_obat.kd_obat and retur_penjualan_detail.kd_unit_apt=apt_unit.kd_unit_apt 
								and retur_penjualan_detail.kd_unit_apt='$kd_unit_apt' and month(retur_penjualan.tgl_returpenjualan)='$bulan' and 
								year(retur_penjualan.tgl_returpenjualan)='$tahun'
								group by apt_obat.kd_obat");
		return $query->result_array();
	}
	
	function ambilbulansisdet(){
		$query=$this->db->query("select month(sysdate()) as sisdet");
		$sisdet=$query->row_array();
		//if(empty($sisdet)) return 0;
		return $sisdet['sisdet'];
	}
	
	function ambiltahunsisdet(){
		$query=$this->db->query("select year(sysdate()) as sisdettahun");
		$sisdettahun=$query->row_array();
		//if(empty($sisdet)) return 0;
		return $sisdettahun['sisdettahun'];
	}
	
	function ambilreturjual($bulan,$tahun,$kd_obat){
		$kd_unit_apt=$this->session->userdata('kd_unit_apt');
		$query=$this->db->query("select retur_jual from apt_mutasi_obat where bulan='$bulan' and tahun='$tahun' and kd_obat='$kd_obat' and kd_unit_apt='$kd_unit_apt'");
		$retur_juala=$query->row_array();
		if(empty($retur_juala)) return 0;
		return $retur_juala['retur_jual'];
	}
	
	function ngambilsaldoakhir($bulan,$tahun,$kd_obat){
		if(strlen($bulan)==1){$bulan1='0'.$bulan;}
		else{$bulan1=$bulan;}
		$kd_unit_apt=$this->session->userdata('kd_unit_apt');
		$query=$this->db->query("select saldo_awal as saldoakhir from apt_mutasi_obat where bulan='$bulan1' and tahun='$tahun' and kd_obat='$kd_obat' and kd_unit_apt='$kd_unit_apt'");
		$saldoakhir=$query->row_array();
		if(empty($saldoakhir)) return '-';
		return $saldoakhir['saldoakhir'];
	}
	
	
	function ngambilbulanmin($tahun,$kd_obat){
		$kd_unit_apt=$this->session->userdata('kd_unit_apt');
		$query=$this->db->query("select min(bulan) as minbulan from apt_mutasi_obat where kd_obat='$kd_obat' and kd_unit_apt='$kd_unit_apt' and tahun='$tahun'");
		$minbulan=$query->row_array();
		if(empty($minbulan)) return '-';
		return $minbulan['minbulan'];
	}
	
	function sumberdana(){
		$query= $this->db->get('apt_unit');
		return $query->result_array();
	}
	
	function getObatDisposal($periode_awal, $periode_akhir, $kd_unit_apt,$status) {
		if(!empty($status))$stat=" and p.status='$status'"; else $stat="";
		$query=$this->db->query("SELECT o.*,pd.kd_obat, o.nama_obat, sk.satuan_kecil,unit.nama_unit_apt,pd.kd_unit_apt,pd.keterangan, pd.qty as jumlah
				FROM apt_disposal p, apt_disposal_detail pd, apt_obat o, apt_satuan_kecil sk,apt_unit unit
				WHERE p.no_disposal = pd.no_disposal 
				AND pd.kd_obat = o.kd_obat 
				AND o.kd_satuan_kecil = sk.kd_satuan_kecil
				and pd.kd_unit_apt=unit.kd_unit_apt
				AND date_format(p.tanggal, '%Y-%m-%d') between '" . convertDate($periode_awal) . "' and '" . convertDate($periode_akhir) . "'"
				. ($kd_unit_apt ? "AND pd.kd_unit_apt = '" . $kd_unit_apt . "'" : "") . "
				".$stat." " 
		);
		
		return $query->result_array();
	}

	function getFastMoving($periode_awal, $periode_akhir, $limit, $kd_unit_apt) {
		$query=$this->db->query("SELECT pd.kd_obat, o.nama_obat, sk.satuan_kecil, SUM(pd.qty) as jumlah
				FROM apt_penjualan p, apt_penjualan_detail pd, apt_obat o, apt_satuan_kecil sk
				WHERE p.no_penjualan = pd.no_penjualan 
				AND pd.kd_obat = o.kd_obat 
				AND o.kd_satuan_kecil = sk.kd_satuan_kecil
				AND date_format(p.tgl_penjualan, '%Y-%m-%d') between '" . convertDate($periode_awal) . "' and '" . convertDate($periode_akhir) . "'"
				. ($kd_unit_apt ? "AND pd.kd_unit_apt = '" . $kd_unit_apt . "'" : "") . "
				GROUP BY pd.kd_obat
				ORDER BY jumlah DESC
				LIMIT " . ($limit ? $limit : '20')
		);
		
		return $query->result_array();
	}

	function getSlowMoving($periode_awal, $periode_akhir, $limit, $kd_unit_apt) {
		$query=$this->db->query("SELECT pd.kd_obat, o.nama_obat, sk.satuan_kecil, SUM(pd.qty) as jumlah
				FROM apt_penjualan p, apt_penjualan_detail pd, apt_obat o, apt_satuan_kecil sk
				WHERE p.no_penjualan = pd.no_penjualan 
				AND pd.kd_obat = o.kd_obat 
				AND o.kd_satuan_kecil = sk.kd_satuan_kecil
				AND date_format(p.tgl_penjualan, '%Y-%m-%d') between '" . convertDate($periode_awal) . "' and '" . convertDate($periode_akhir) . "'"
				. ($kd_unit_apt ? "AND pd.kd_unit_apt = '" . $kd_unit_apt . "'" : "") . "
				GROUP BY pd.kd_obat
				ORDER BY jumlah ASC
				LIMIT " . ($limit ? $limit : '20')
		);
		
		return $query->result_array();
	}
}
?>