<?


include_once(APPPATH.'models/mutility.php');
class Mpasien extends Mutility {

	public $pasien;
	function __construct() {
		parent::__construct();
	}

	function setPasien($kd_pasien){
		$this->db->join('propinsi b','a.kd_propinsi=b.kd_propinsi','left');
		$this->db->join('kabupaten c','a.kd_kabupaten=c.kd_kabupaten','left');
		$this->db->join('kecamatan d','a.kd_kabupaten=d.kd_kecamatan','left');
		$this->db->join('kelurahan e','a.kd_kecamatan=e.kd_kelurahan','left');
		$this->db->where('a.kd_pasien',$kd_pasien);
		$query=$this->db->get("pasien a");
		if ($query->num_rows() > 0)
		{
		   $this->pasien = $query->row();
		} 		
	}

	function ambilNoAntrian($kd_dokter,$tanggal){
		$this->db->select('ifnull(max(no_antrian),0) as antrian',false);
		$this->db->where('kd_dokter',$kd_dokter);
		$this->db->where('tanggal',$tanggal);
		$this->db->group_by('tanggal');
		$this->db->group_by('kd_dokter');

		$query=$this->db->get('antrian_dokter');
		$item=$query->row_array();
		if(empty($item))$item['antrian']=0;
		$antrian=$item['antrian']+1;
		return $antrian;
	}

	function pelayananpasien($no_pendaftaran){
		//if(!empty($nama)) $this->db->like('nama_pasien',$nama);
		$this->db->select('*,date(tgl_pelayanan) as tanggal, time(tgl_pelayanan) as jam');
		$this->db->where('no_pendaftaran',$no_pendaftaran);

		$this->db->join('list_pelayanan b','a.kd_pelayanan=b.kd_pelayanan');
		$this->db->join('apt_dokter c','a.kd_dokter=c.kd_dokter');
		//$this->db->limit($limit,$offset);
		$this->db->order_by('urut');
		$query=$this->db->get("biaya_pelayanan a");
		return $query->result_array();
	}

	function isPasienDiagnosaExist($urut){
		$this->db->where('no_pendaftaran',$this->pasien->no_pendaftaran);
		$this->db->where('urut',$urut);
		$query=$this->db->get('periksa_diagnosa');
		$count=$query->num_rows();
		if($count){
			return true;
		}
		return false;
	}

	function isPasienDiagnosaLama($kd_sub_icd)
	{
		$this->db->where('kd_pasien',$this->pasien->kd_pasien);
		$this->db->where('kd_sub_icd',$kd_sub_icd);
		$query=$this->db->get('periksa_diagnosa');
		$item=$query->num_rows();
		if($item)return true;
		return false;
	}

	function getAnamnesaPasien($no_pendaftaran){
		$this->db->where('no_pendaftaran',$no_pendaftaran);
		$query=$this->db->get("anamnesa_pasien a");
		return $query->row_array();
	}

	function diagnosapasien($no_pendaftaran){
		//if(!empty($nama)) $this->db->like('nama_pasien',$nama);
		$this->db->select('a.no_pendaftaran,a.urut,tgl_diagnosa,a.kd_jenis_diagnosa,a.kd_dokter,a.kd_sub_icd,a.kd_unit_kerja,b.jenis_diagnosa,c.nama_dokter,d.sub_diagnosa_icd,e.nama_unit_kerja');
		$this->db->where('no_pendaftaran',$no_pendaftaran);

		$this->db->join('jenis_diagnosa b','a.kd_jenis_diagnosa=b.kd_jenis_diagnosa');
		$this->db->join('apt_dokter c','a.kd_dokter=c.kd_dokter');
		$this->db->join('sub_diagnosa_icd d','a.kd_sub_icd=d.kd_sub_icd');
		$this->db->join('unit_kerja e','a.kd_unit_kerja=e.kd_unit_kerja');
		//$this->db->limit($limit,$offset);
		
		$query=$this->db->get("periksa_diagnosa a");
		return $query->result_array();
	}

	function getNextNoUrutDiagnosa(){
		//if(!empty($nama)) $this->db->like('nama_pasien',$nama);
		$this->db->select('max(urut) as urut',false);
		$this->db->where('no_pendaftaran',$this->pasien->no_pendaftaran);
		$query=$this->db->get("periksa_diagnosa a");
		$item= $query->row_array();
		if(empty($item))return 1;
		return $item['urut']+1;
	}

	function getNextNoUrutPelayanan(){
		//if(!empty($nama)) $this->db->like('nama_pasien',$nama);
		$this->db->select('ifnull(max(urut),0) as urt',false);
		$this->db->where('no_pendaftaran',$this->pasien->no_pendaftaran);

		$this->db->join('list_pelayanan b','a.kd_pelayanan=b.kd_pelayanan');
		$this->db->group_by('no_pendaftaran');
		//$this->db->limit($limit,$offset);
		
		$query=$this->db->get("biaya_pelayanan a");
		$item = $query->row_array();
		if(empty($item))return 1;
		return $item['urt']+1;

	}

    function insertbiayapelayanancomponent($kd_kasir,$no_pendaftaran,$urut,$kd_jenis_tarif,$kd_pelayanan,$kd_kelas,$tgl_berlaku) {
		$this->db->query('insert into biaya_pelayanan_component select "'.$kd_kasir.'","'.$no_pendaftaran.'","'.$urut.'",kd_component,tarif_component,0,0 from tarif_component where kd_jenis_tarif="'.$kd_jenis_tarif.'" and kd_pelayanan="'.$kd_pelayanan.'" and kd_kelas="'.$kd_kelas.'" and tgl_berlaku="'.$tgl_berlaku.'"');
		return true;
    }	

	function getJumlahTransaksiBulan(){
		//if(!empty($nama)) $this->db->like('nama_pasien',$nama);
		$this->db->select('max(kd_pasien) as urut',false);
		$this->db->where('kd_pasien!=kd_pasien_lama or kd_pasien_lama is null',null,false);
		$query=$this->db->get("pasien a");
		$item= $query->row_array();
		return $item['urut'];
	}

	function getJumlahTransaksiRegBulan($tahun,$bulan){
		//if(!empty($nama)) $this->db->like('nama_pasien',$nama);
		$this->db->select('max(right(no_pendaftaran,4)) as urut',false);
		$this->db->where('year(tgl_pendaftaran)',$tahun);
		$this->db->where('month(tgl_pendaftaran)',$bulan);
		$query=$this->db->get("pendaftaran a");
		$item= $query->row_array();
		return $item['urut'];
	}

	function getJumlahTransaksiRegHari($kdunit,$tanggal){
		//if(!empty($nama)) $this->db->like('nama_pasien',$nama);
		$this->db->select('max(right(no_pendaftaran,3)) as urut',false);
		$this->db->where('date(tgl_pendaftaran)',$tanggal);
		$this->db->where('kd_unit_kerja',$kdunit);
		$query=$this->db->get("pendaftaran a");
		$item= $query->row_array();
		return $item['urut'];
	}

	function getNextNoDaftar($kdunit){
		//if(!empty($nama)) $this->db->like('nama_pasien',$nama);
		$query = $this->db->query("SELECT ifnull(max(no_pendaftaran),0) as no_pendaftaran
			FROM `pendaftaran`
			WHERE left( no_pendaftaran, 9 ) = concat( '".$kdunit."', date_format( '".date('Y-m-d')."', '%y%m%d' ) )");

		$item= $query->row_array();
		if(empty($item)){
			$next = $kdunit.date('ymd').'001';
		}else{
			if(empty($item['no_pendaftaran'])){
				$next = $kdunit.date('ymd').'001';
			}else{
				$next = $item['no_pendaftaran']+1;
			}
			
		}
		return $next;
	}

	function getAllHistoryDaftar($kd_pasien){

		$this->db->select('a.no_pendaftaran,tgl_pendaftaran,kelas,nama_unit_kerja');
		$this->db->join('kelas_pelayanan b','a.kd_kelas=b.kd_kelas','left');
		$this->db->join('unit_kerja c','a.kd_unit_kerja=c.kd_unit_kerja','left');
		$this->db->where('a.kd_pasien',$kd_pasien);
		//$this->db->limit($limit,$offset);
		$query=$this->db->get("pendaftaran a");
		return $query->result_array();
	}

	function getAllPasien($kd_pasien,$nama_pasien,$periodeawal,$periodeakhir,$jns_kelamin,$limit,$offset){
		//if(!empty($nama)) $this->db->like('nama_pasien',$nama);
		if(!empty($kd_pasien) && $kd_pasien !='NULL')$this->db->like('kd_pasien',$kd_pasien,'both');
		if(!empty($nama_pasien) && $nama_pasien !='NULL')$this->db->like('nama_pasien',$nama_pasien,'both');
		if(!empty($jns_kelamin) && $jns_kelamin !='NULL')$this->db->where('jns_kelamin',$jns_kelamin);
		if(!empty($periodeawal) && $periodeawal !='NULL')$this->db->where('date(tgl_membership)>=',$periodeawal);
		if(!empty($periodeakhir) && $periodeakhir !='NULL')$this->db->where('date(tgl_membership)<=',$periodeakhir);

		$this->db->join('propinsi b','a.kd_propinsi=b.kd_propinsi','left');
		$this->db->join('kabupaten c','a.kd_kabupaten=c.kd_kabupaten','left');
		$this->db->join('kecamatan d','a.kd_kabupaten=d.kd_kecamatan','left');
		$this->db->join('kelurahan e','a.kd_kecamatan=e.kd_kelurahan','left');
		//$this->db->limit($limit,$offset);
		$query=$this->db->get("pasien a");
		return $query->result_array();
	}

	function countAllPasien($kd_pasien,$nama_pasien,$periodeawal,$periodeakhir,$jns_kelamin){
		//if(!empty($nama)) $this->db->like('nama_pasien',$nama);
		if(!empty($kd_pasien) && $kd_pasien !='NULL')$this->db->like('kd_pasien',$kd_pasien,'both');
		if(!empty($nama_pasien) && $nama_pasien !='NULL')$this->db->like('nama_pasien',$nama_pasien,'both');
		if(!empty($jns_kelamin) && $jns_kelamin !='NULL')$this->db->where('jns_kelamin',$jns_kelamin);
		if(!empty($periodeawal) && $periodeawal !='NULL')$this->db->where('date(tgl_membership)>=',$periodeawal);
		if(!empty($periodeakhir) && $periodeakhir !='NULL')$this->db->where('date(tgl_membership)<=',$periodeakhir);
		//$this->db->limit($limit,$offset);
		$query=$this->db->get("pasien a");
		return $query->num_rows();
	}

	function isKdPasienSama($kd_pasien)
	{
		$this->db->where('kd_pasien',$kd_pasien);
		$this->db->where('kd_pasien=kd_pasien_lama',null,false);
		$query=$this->db->get('pasien');
		$item=$query->num_rows();
		if($item)return true;
		return false;
	}

	function isNumberExist($number){
		$this->db->where('kd_pasien',$number);
		$query=$this->db->get('pasien');
		$count=$query->num_rows();
		if($count){
			return true;
		}
		return false;
	}

	function isBaruRS($kd_pasien){
		if($this->isFromOldApp($kd_pasien)){
			return false;
		}
		$this->db->where('kd_pasien',$kd_pasien);
		$query=$this->db->get('pendaftaran');
		$count=$query->num_rows();
		if($count){
			return false;
		}
		return true;
	}

	function isFromOldApp($kd_pasien){
		
		$this->db->where('kd_pasien_lama',$kd_pasien);
		$query=$this->db->get('pasien');
		$count=$query->num_rows();
		if($count){
			return true;
		}
		return false;
	}

	function isBaruUnit($kd_pasien,$nuit){
		$this->db->where('kd_pasien',$kd_pasien);
		$this->db->where('kd_unit_kerja',$nuit);
		$query=$this->db->get('pendaftaran');
		$count=$query->num_rows();
		if($count){
			return false;
		}
		return true;
	}

	function isSudahBayar($no_pendaftaran)
	{
		$this->db->where('no_pendaftaran',$no_pendaftaran);
		$query=$this->db->get('struk_bayar');
		$item=$query->num_rows();
		if($item)return true;
		return false;
	}

	function isTindakanSebelumnyaSudahBayar($kd_pasien)
	{
		$query=$this->db->query('SELECT *
				FROM pasien a
				LEFT JOIN pendaftaran b ON a.kd_pasien = b.kd_pasien
				LEFT JOIN biaya_pelayanan c ON b.no_pendaftaran = c.no_pendaftaran
				LEFT JOIN struk_bayar d ON c.no_pendaftaran = d.no_pendaftaran
				WHERE a.kd_pasien="'.$kd_pasien.'"
				HAVING (
				c.no_pendaftaran IS NULL
				AND no_struk IS NULL
				)
				OR (
				c.no_pendaftaran IS NOT NULL
				AND no_struk IS NOT NULL
				)');
		$item=$query->num_rows();
		if($item)return true;
		return false;
	}

	function isSudahPeriksa($no_pendaftaran)
	{
		$this->db->where('no_pendaftaran',$no_pendaftaran);
		$query=$this->db->get('periksa_diagnosa');
		$item=$query->num_rows();
		if($item)return true;
		return false;
	}

	function isNoDaftarExist($no_pendaftaran)
	{
		$this->db->where('no_pendaftaran',$no_pendaftaran);
		$query=$this->db->get('pendaftaran');
		$item=$query->num_rows();
		if($item)return true;
		return false;
	}
	
	function isKdRujukanExist($kd_rujukan)
	{
		$this->db->where('kd_rujukan',$kd_rujukan);
		$query=$this->db->get('rujukan');
		$item=$query->num_rows();
		if($item)return true;
		return false;
	}

	function getPelayananAdministrasiPasien($no_pendaftaran,$unit){
		//if(!empty($nama)) $this->db->like('nama_pasien',$nama);
		$this->db->select('a.*,b.nama_pelayanan');
		//if(!empty($no_pendaftaran))$this->db->where('a.no_pendaftaran',$no_pendaftaran);
		$this->db->where('a.no_pendaftaran',$no_pendaftaran);
		$this->db->where('d.unit',$unit);
		$this->db->where('e.no_struk is NULL');

		$this->db->join('list_pelayanan b','a.kd_pelayanan=b.kd_pelayanan');
		$this->db->join('administrasi_pendaftaran d','a.kd_pelayanan=d.kd_pelayanan');
		$this->db->join('struk_pelayanan e','a.kd_kasir=e.kd_kasir and a.no_pendaftaran=e.no_pendaftaran and a.urut=e.urut','left');
		//$this->db->limit($limit,$offset);
		
		$query=$this->db->get("biaya_pelayanan a");
		return $query->result_array();
	}

    function hapusBiayaPelayananAdministrasiPasien($no_pendaftaran){
    	$this->db->query("delete a from biaya_pelayanan a left join struk_pelayanan e on a.kd_kasir=e.kd_kasir and a.no_pendaftaran=e.no_pendaftaran and a.urut=e.urut
    		where a.no_pendaftaran='".$no_pendaftaran."' and kd_pelayanan in(select kd_pelayanan from administrasi_pendaftaran) and e.no_struk is NULL");
    	
    	//$this->db->query("delete from biaya_pelayanan
    	//	where a.no_pendaftaran='".$no_pendaftaran."' and kd_kasir not in (select kd_kasir from struk_pelayanan where no_pendaftaran='".$no_pendaftaran."') 
    	//	and urut not in (select urut from struk_pelayanan where no_pendaftaran='".$no_pendaftaran."') 
    		//");

    }
	//laporan
	function getAllHistoryPasien($kd_pasien){
		$this->db->select('*,date_format(b.tgl_pendaftaran,"%d-%m-%Y") as tgl_daftar',false);
		$this->db->join('pendaftaran b','a.kd_pasien=b.kd_pasien');
		$this->db->join('apt_dokter c','b.kd_dokter=c.kd_dokter');
		$this->db->join('unit_kerja d','b.kd_unit_kerja=d.kd_unit_kerja');
		$this->db->where('a.kd_pasien',$kd_pasien);
		$this->db->order_by('b.tgl_pendaftaran','desc');
		//$this->db->where('d.kd_unit_kerja','kd_unit_kerja not in(1,8) and (parent not in (1,8) or parent is null)');

		$query=$this->db->get('pasien a');
		return $query->result_array();
	}	

	function getAllPelayananPasien($no_pendaftaran){
		$this->db->select('c.nama_pelayanan,date(b.tgl_pelayanan) as tanggal');
		$this->db->join('biaya_pelayanan b','a.no_pendaftaran=b.no_pendaftaran');
		$this->db->join('list_pelayanan c','b.kd_pelayanan=c.kd_pelayanan');
		$this->db->where('a.no_pendaftaran',$no_pendaftaran);

		$query=$this->db->get('pendaftaran a');
		return $query->result_array();
	}

	function getAllPeriksaDiagnosa($no_pendaftaran){
		//$this->db->select('c.nama_pelayanan,date(b.tgl_pelayanan) as tanggal');
		$this->db->join('sub_diagnosa_icd b','a.kd_sub_icd=b.kd_sub_icd');
		$this->db->where('a.no_pendaftaran',$no_pendaftaran);

		$query=$this->db->get('periksa_diagnosa a');
		return $query->result_array();
	}

	function getAllRegistrasi($tgl_awal,$tgl_akhir,$kd_unit_kerja,$cust_code,$status,$shift){
		//if(!empty($nama)) $this->db->like('nama_pasien',$nama);
		$this->db->select('no_pendaftaran,a.kd_pasien,date(a.tgl_pendaftaran) as tgl_pendaftaran,,is_baru_rs,is_baru_unit,c.nama_pasien,c.alamat,c.jns_kelamin,c.tgl_lahir,a.is_baru_rs,b.nama_unit_kerja');
		$this->db->where('date(tgl_pendaftaran) >=',$tgl_awal);
		$this->db->where('date(tgl_pendaftaran) <=',$tgl_akhir);

		if($status!='')$this->db->where('is_baru_rs',$status);
		if($shift!='')$this->db->where('shift',$shift);
		if($kd_unit_kerja!='')$this->db->where('a.kd_unit_kerja',$kd_unit_kerja);
		if($cust_code!='')$this->db->where('a.cust_code',$cust_code);
		//$this->db->limit($limit,$offset);
		$this->db->join('unit_kerja b','a.kd_unit_kerja=b.kd_unit_kerja');
		$this->db->join('pasien c','a.kd_pasien=c.kd_pasien');
		
		$query=$this->db->get("pendaftaran a");
		return $query->result_array();
	}

	function getAllRekapitulasi($tgl_awal,$tgl_akhir,$param,$shift){
		if(!empty($shift)) $shft=" and shift='".$shift."'";else $shft="";

		if($param==1){
			$query=$this->db->query('SELECT a.kd_unit_kerja, nama_unit_kerja as uraian, ifnull( t_baru_laki.jumlah, 0 ) AS baru_laki, ifnull( t_baru_perempuan.jumlah, 0 ) AS baru_perempuan, ifnull( t_lama_laki.jumlah, 0 ) AS lama_laki, ifnull( t_lama_perempuan.jumlah, 0 ) AS lama_perempuan
				FROM `pendaftaran` a
				LEFT JOIN (

				SELECT kd_unit_kerja, count( 1 ) AS jumlah
				FROM pendaftaran join pasien on pendaftaran.kd_pasien=pasien.kd_pasien
				WHERE is_baru_rs =1
				and jns_kelamin="L"
				and date(tgl_pendaftaran)>="'.$tgl_awal.'"
				and date(tgl_pendaftaran)<="'.$tgl_akhir.'"
				'.$shft.'
				GROUP BY kd_unit_kerja
				) AS t_baru_laki ON a.kd_unit_kerja = t_baru_laki.kd_unit_kerja
				LEFT JOIN (

				SELECT kd_unit_kerja, count( 1 ) AS jumlah
				FROM pendaftaran join pasien on pendaftaran.kd_pasien=pasien.kd_pasien
				WHERE is_baru_rs =1
				and jns_kelamin="P"
				and date(tgl_pendaftaran)>="'.$tgl_awal.'"
				and date(tgl_pendaftaran)<="'.$tgl_akhir.'"
				'.$shft.'
				GROUP BY kd_unit_kerja
				) AS t_baru_perempuan ON a.kd_unit_kerja = t_baru_perempuan.kd_unit_kerja
				LEFT JOIN (

				SELECT kd_unit_kerja, count( 1 ) AS jumlah
				FROM pendaftaran join pasien on pendaftaran.kd_pasien=pasien.kd_pasien
				WHERE is_baru_rs =0
				and jns_kelamin="L"
				and date(tgl_pendaftaran)>="'.$tgl_awal.'"
				and date(tgl_pendaftaran)<="'.$tgl_akhir.'"
				'.$shft.'
				GROUP BY kd_unit_kerja
				) AS t_lama_laki ON a.kd_unit_kerja = t_lama_laki.kd_unit_kerja
				LEFT JOIN (

				SELECT kd_unit_kerja, count( 1 ) AS jumlah
				FROM pendaftaran join pasien on pendaftaran.kd_pasien=pasien.kd_pasien
				WHERE is_baru_rs =0
				and jns_kelamin="P"
				and date(tgl_pendaftaran)>="'.$tgl_awal.'"
				and date(tgl_pendaftaran)<="'.$tgl_akhir.'"
				'.$shft.'
				GROUP BY kd_unit_kerja
				) AS t_lama_perempuan ON a.kd_unit_kerja = t_lama_perempuan.kd_unit_kerja
				JOIN unit_kerja b ON a.kd_unit_kerja = b.kd_unit_kerja
				where 
				date(tgl_pendaftaran)>="'.$tgl_awal.'"
				and date(tgl_pendaftaran)<="'.$tgl_akhir.'"
				'.$shft.'
				
				GROUP BY a.kd_unit_kerja order by b.kd_unit_kerja');
		}else if($param==2){
			$query=$this->db->query('SELECT a.cust_code, customer as uraian, ifnull( t_baru_laki.jumlah, 0 ) AS baru_laki, ifnull( t_baru_perempuan.jumlah, 0 ) AS baru_perempuan, ifnull( t_lama_laki.jumlah, 0 ) AS lama_laki, ifnull( t_lama_perempuan.jumlah, 0 ) AS lama_perempuan
			FROM `pendaftaran` a
			LEFT JOIN (

			SELECT cust_code, count( 1 ) AS jumlah
			FROM pendaftaran join pasien on pendaftaran.kd_pasien=pasien.kd_pasien
			WHERE is_baru_rs =1
			and jns_kelamin="L"
			and date(tgl_pendaftaran)>="'.$tgl_awal.'"
			and date(tgl_pendaftaran)<="'.$tgl_akhir.'"
				'.$shft.'
			GROUP BY cust_code
			) AS t_baru_laki ON a.cust_code = t_baru_laki.cust_code
			LEFT JOIN (

			SELECT cust_code, count( 1 ) AS jumlah
			FROM pendaftaran join pasien on pendaftaran.kd_pasien=pasien.kd_pasien
			WHERE is_baru_rs =1
			and jns_kelamin="P"
			and date(tgl_pendaftaran)>="'.$tgl_awal.'"
			and date(tgl_pendaftaran)<="'.$tgl_akhir.'"
				'.$shft.'
			GROUP BY cust_code
			) AS t_baru_perempuan ON a.cust_code = t_baru_perempuan.cust_code
			LEFT JOIN (

			SELECT cust_code, count( 1 ) AS jumlah
			FROM pendaftaran join pasien on pendaftaran.kd_pasien=pasien.kd_pasien
			WHERE is_baru_rs =0
			and jns_kelamin="L"
			and date(tgl_pendaftaran)>="'.$tgl_awal.'"
			and date(tgl_pendaftaran)<="'.$tgl_akhir.'"
				'.$shft.'
			GROUP BY cust_code
			) AS t_lama_laki ON a.cust_code = t_lama_laki.cust_code
			LEFT JOIN (

			SELECT cust_code, count( 1 ) AS jumlah
			FROM pendaftaran join pasien on pendaftaran.kd_pasien=pasien.kd_pasien
			WHERE is_baru_rs =0
			and jns_kelamin="P"
			and date(tgl_pendaftaran)>="'.$tgl_awal.'"
			and date(tgl_pendaftaran)<="'.$tgl_akhir.'"
				'.$shft.'
			GROUP BY cust_code
			) AS t_lama_perempuan ON a.cust_code = t_lama_perempuan.cust_code
			JOIN apt_customers b ON a.cust_code = b.cust_code
			where date(tgl_pendaftaran)>="'.$tgl_awal.'"
			and date(tgl_pendaftaran)<="'.$tgl_akhir.'"
				'.$shft.'
			
			GROUP BY a.cust_code order by b.cust_code');

		}else{
			return false;
		}
		return $query->result_array();
	}

	function getAllSummary($tgl_awal,$tgl_akhir,$param,$shift){
		if(!empty($shift)) $shft=" and shift='".$shift."'";else $shft="";

		if($param==1){
			$query=$this->db->query('SELECT a.kd_unit_kerja, nama_unit_kerja as uraian, ifnull( t_baru.jumlah, 0 ) AS baru, ifnull( t_lama.jumlah, 0 ) AS lama
				FROM `pendaftaran` a
				LEFT JOIN (

				SELECT kd_unit_kerja, count( 1 ) AS jumlah
				FROM pendaftaran
				WHERE is_baru_rs =1
				and date(tgl_pendaftaran)>="'.$tgl_awal.'"
				and date(tgl_pendaftaran)<="'.$tgl_akhir.'"
				'.$shft.'
				GROUP BY kd_unit_kerja
				) AS t_baru ON a.kd_unit_kerja = t_baru.kd_unit_kerja
				LEFT JOIN (

				SELECT kd_unit_kerja, count( 1 ) AS jumlah
				FROM pendaftaran
				WHERE is_baru_rs =0
				and date(tgl_pendaftaran)>="'.$tgl_awal.'"
				and date(tgl_pendaftaran)<="'.$tgl_akhir.'"
				'.$shft.'
				GROUP BY kd_unit_kerja
				) AS t_lama ON a.kd_unit_kerja = t_lama.kd_unit_kerja
				JOIN unit_kerja b ON a.kd_unit_kerja = b.kd_unit_kerja
				where 
				date(tgl_pendaftaran)>="'.$tgl_awal.'"
				and date(tgl_pendaftaran)<="'.$tgl_akhir.'"
				'.$shft.'
				GROUP BY a.kd_unit_kerja');
		}else if($param==2){
			$query=$this->db->query('SELECT a.cust_code, customer as uraian, ifnull( t_baru.jumlah, 0 ) AS baru, ifnull( t_lama.jumlah, 0 ) AS lama
			FROM `pendaftaran` a
			LEFT JOIN (

			SELECT cust_code, count( 1 ) AS jumlah
			FROM pendaftaran
			WHERE is_baru_rs =1
			and date(tgl_pendaftaran)>="'.$tgl_awal.'"
			and date(tgl_pendaftaran)<="'.$tgl_akhir.'"
			'.$shft.'
			GROUP BY cust_code
			) AS t_baru ON a.cust_code = t_baru.cust_code
			LEFT JOIN (

			SELECT cust_code, count( 1 ) AS jumlah
			FROM pendaftaran
			WHERE is_baru_rs =0
			and date(tgl_pendaftaran)>="'.$tgl_awal.'"
			and date(tgl_pendaftaran)<="'.$tgl_akhir.'"
				'.$shft.'
			GROUP BY cust_code
			) AS t_lama ON a.cust_code = t_lama.cust_code
			JOIN apt_customers b ON a.cust_code = b.cust_code
			where date(tgl_pendaftaran)>="'.$tgl_awal.'"
			and date(tgl_pendaftaran)<="'.$tgl_akhir.'"
				'.$shft.'
			GROUP BY a.cust_code');

		}else if($param==3){
			$query=$this->db->query('SELECT a.kd_dokter, nama_dokter as uraian, ifnull( t_baru.jumlah, 0 ) AS baru, ifnull( t_lama.jumlah, 0 ) AS lama
			FROM `pendaftaran` a
			LEFT JOIN (

			SELECT kd_dokter, count( 1 ) AS jumlah
			FROM pendaftaran
			WHERE is_baru_rs =1
			and date(tgl_pendaftaran)>="'.$tgl_awal.'"
			and date(tgl_pendaftaran)<="'.$tgl_akhir.'"
				'.$shft.'
			GROUP BY kd_dokter
			) AS t_baru ON a.kd_dokter = t_baru.kd_dokter
			LEFT JOIN (

			SELECT kd_dokter, count( 1 ) AS jumlah
			FROM pendaftaran
			WHERE is_baru_rs =0
			and date(tgl_pendaftaran)>="'.$tgl_awal.'"
			and date(tgl_pendaftaran)<="'.$tgl_akhir.'"
				'.$shft.'
			GROUP BY cust_code
			) AS t_lama ON a.kd_dokter = t_lama.kd_dokter
			JOIN apt_dokter b ON a.kd_dokter = b.kd_dokter
			where date(tgl_pendaftaran)>="'.$tgl_awal.'"
			and date(tgl_pendaftaran)<="'.$tgl_akhir.'"
				'.$shft.'
			GROUP BY a.kd_dokter');			
		}else{
			return false;
		}
		return $query->result_array();
	}

	function getTopTindakan($tgl_awal,$tgl_akhir,$top){
		$query = $this->db->query("select nama_pelayanan,count(1) total from biaya_pelayanan a join list_pelayanan b on a.kd_pelayanan=b.kd_pelayanan where
						date(tgl_pelayanan)>='".$tgl_awal."' and date(tgl_pelayanan)<='".$tgl_akhir."' group by a.kd_pelayanan
						order by total desc limit ".$top." ");
		$items = $query->result_array();
		return $items;
	}

	function getTopDiagnosa($tgl_awal,$tgl_akhir,$top){
		$query = $this->db->query("select sub_diagnosa_icd,count(1) total from periksa_diagnosa a join sub_diagnosa_icd b on a.kd_sub_icd=b.kd_sub_icd where
						date(tgl_diagnosa)>='".$tgl_awal."' and date(tgl_diagnosa)<='".$tgl_akhir."' group by a.kd_sub_icd
						order by total desc limit ".$top." ");
		$items = $query->result_array();
		return $items;
	}

	function getAllSummaryPendapatan($tgl_awal,$tgl_akhir,$param,$shift){
		if($param==1){
			$this->db->select('a.kd_unit_kerja, nama_unit_kerja as uraian, sum( total ) AS total');
		}else if($param==2){
			$this->db->select('a.cust_code,customer as uraian, sum( total ) AS total');
		}else{
			return false;
		}
		$this->db->where('a.no_pendaftaran = b.no_pendaftaran');
		$this->db->where('a.kd_unit_kerja = c.kd_unit_kerja');
		$this->db->where('a.cust_code = d.cust_code');

		$this->db->where('date(tgl_pelayanan) >=',$tgl_awal);
		$this->db->where('date(tgl_pelayanan) <=',$tgl_akhir);
		if($shift!='')$this->db->where('a.shift',$shift);

		if($param==1){
			$this->db->group_by('a.kd_unit_kerja');			
		}else if($param==2){
			$this->db->group_by('a.cust_code');
		}else{
			return false;
		}

		$query=$this->db->get('pendaftaran a, `biaya_pelayanan` b, unit_kerja c,apt_customers d');
		return $query->result_array();
	}		

	function getAllPendapatanTindakan($tgl_awal,$tgl_akhir,$kd_unit_kerja,$shift){
		$this->db->select(' f.nama_unit_kerja, a.no_struk, tgl_struk, b.kd_pelayanan, nama_pelayanan, qty, harga, a.total');
		$this->db->where('d.no_struk = a.no_struk');
		$this->db->where('a.no_pendaftaran = b.no_pendaftaran');
		$this->db->where('a.urut = b.urut');
		$this->db->where('b.kd_pelayanan = c.kd_pelayanan');
		$this->db->where('d.no_pendaftaran = e.no_pendaftaran');
		$this->db->where('e.kd_unit_kerja = f.kd_unit_kerja');
		if($shift!='')$this->db->where('e.shift',$shift);
		if($kd_unit_kerja!='')$this->db->where('e.kd_unit_kerja',$kd_unit_kerja);
		$this->db->where('date(tgl_struk) >=',$tgl_awal);
		$this->db->where('date(tgl_struk) <=',$tgl_akhir);

		$query=$this->db->get(' struk_bayar d, `struk_pelayanan` a, biaya_pelayanan b, list_pelayanan c, pendaftaran e, unit_kerja f');
		return $query->result_array();
	}

	function getAllPendapatanKasir($tgl_awal,$tgl_akhir,$kd_unit_kerja,$shift){
		$this->db->select('date(d.tgl_struk) as tgl_struk, d.no_struk, nama_pasien, c.customer, d.total');
		$this->db->where('a.kd_pasien = b.kd_pasien');
		$this->db->where('a.cust_code = c.cust_code');
		$this->db->where('a.no_pendaftaran = d.no_pendaftaran');
		$this->db->where('a.kd_unit_kerja = e.kd_unit_kerja');
		if($shift!='')$this->db->where('a.shift',$shift);
		if($kd_unit_kerja!='')$this->db->where('a.kd_unit_kerja',$kd_unit_kerja);
		$this->db->where('date(tgl_struk) >=',$tgl_awal);
		$this->db->where('date(tgl_struk) <=',$tgl_akhir);

		$query=$this->db->get('pendaftaran a, pasien b, apt_customers c, struk_bayar d, unit_kerja e');
		return $query->result_array();
	}

}
	
?>
