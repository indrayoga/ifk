<?



class Mlaporan extends CI_Model {

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

	function isPosted($nopenerimaan)
	{
		$this->db->where('cso_number',$nopenerimaan);
		$this->db->where('posted',1);
		$query=$this->db->get('acc_cso_detail');
		$item=$query->num_rows();
		if($item)return true;
		return false;
	}

	function isAccount($akun)
	{
		$this->db->where('account',$akun);
		$query=$this->db->get('accounts');
		$item=$query->num_rows();
		if($item)return true;
		return false;
	}

	function getAllKasUmumPenerimaan($periodeawal,$periodeakhir,$status){
		//if(!empty($nama)) $this->db->like('nama_pasien',$nama);
		$this->db->select('*,f.name as uraian');
		if($status==2)$this->db->where('a.cso_number in (select cso_number from acc_cso_detail where posted=1)');
		if($status==3)$this->db->where('a.cso_number in (select cso_number from acc_cso_detail where posted=0)');
		if(!empty($periodeawal))$this->db->where('a.cso_date >=',$periodeawal);
		if(!empty($periodeakhir))$this->db->where('a.cso_date <=',$periodeakhir);

		$this->db->where('a.type',1);
		//$this->db->limit($limit,$offset);
		$this->db->join('acc_cso_detail e','a.cso_number=e.cso_number','left');
		$this->db->join('unit_kerja b','a.kd_unit_kerja=b.kd_unit_kerja','left');
		$this->db->join('acc_payment c','a.pay_code=c.pay_code','left');
		$this->db->join('accounts d','a.account=d.account','left');
		$this->db->join('accounts f','e.account=f.account','left');
		
		$query=$this->db->get("acc_cso a");
		return $query->result_array();
	}

	function getAllJurnal($tahun,$bulan,$jurnal,$periode_awal,$periode_akhir){
		//if(!empty($nama)) $this->db->like('nama_pasien',$nama);

		if(!empty($tahun))$this->db->where('year(a.gl_date)',$tahun);
		if(!empty($bulan))$this->db->where('month(a.gl_date)',$bulan);
		if(!empty($periode_awal))$this->db->where('a.gl_date >=',$periode_awal);
		if(!empty($periode_akhir))$this->db->where('a.gl_date <=',$periode_akhir);
		if(count($jurnal)>1){
			//$jurnal = array_map('apply_quotes', $jurnal);
			if(!empty($jurnal))$this->db->where('a.journal_code in ('.implode('",', $jurnal).'")');			
		}else{
			//$jurnal = array_map('apply_quotes', $jurnal);
			if(!empty($jurnal))$this->db->where('a.journal_code in ("'.$jurnal[0].'")');						
		}
		//$this->db->limit($limit,$offset);
		$this->db->order_by('a.gl_date');
		$this->db->order_by('b.gl_number');
		$this->db->order_by('line');
		$this->db->join('acc_gl_detail b','a.gl_number=b.gl_number');
		$this->db->join('accounts c','b.account=c.account','left');
		
		$query=$this->db->get("acc_gl_trans a");
		return $query->result_array();
	}

	function getAllBukuBesar($akun_dari,$akun_sampai,$tahun,$periode_awal,$periode_akhir){
		$qakun1="AND account between '".$akun_dari."' and '".$akun_sampai."'";
		$qakun2="AND av.account between '".$akun_dari."' and '".$akun_sampai."'";
		$db=array('01'=>'DB0','02'=>'DB1','03'=>'DB2','04'=>'DB3','05'=>'DB4','06'=>'DB5','07'=>'DB6','08'=>'DB7','09'=>'DB8','10'=>'DB9','11'=>'DB10','12'=>'DB11');
		$cr=array('01'=>'CR0','02'=>'CR1','03'=>'CR2','04'=>'CR3','05'=>'CR4','06'=>'CR5','07'=>'CR6','08'=>'CR7','09'=>'CR8','10'=>'CR9','11'=>'CR10','12'=>'CR11');
		$query=$this->db->query("SELECT 2 AS Nom, Journal_Code, Number, Tanggal, Reference, Name, Account, Description, Value, Years, Debit, Kredit, Posted
						FROM viRptGeneralLedger
						WHERE Year( Tanggal ) = '".$tahun."'
						AND Month( Tanggal ) >= '".$periode_awal."'
						AND Month( Tanggal ) <= '".$periode_akhir."'
						".$qakun1."
						UNION SELECT 1 AS Nom, '' AS Journal_Code, '' AS Number, '' AS Date, '' AS Reff, a.Name, av.Account, 'SALDO AWAL ' AS Description, CASE WHEN a.Groups
						IN ( 1, 5 )
						THEN av.".$db[$periode_awal]." - av.".$cr[$periode_awal]."
						ELSE av.".$cr[$periode_awal]." - av.".$db[$periode_awal]."
						END as value , av.Years,
						CASE WHEN a.Groups
						IN ( 1, 5 )
						THEN ".$db[$periode_awal]." - av.".$cr[$periode_awal]."
						ELSE 0
						END as Debit,
						CASE WHEN a.Groups
						IN ( 1, 5 )
						THEN 0
						ELSE ".$cr[$periode_awal]." - av.".$db[$periode_awal]."
						END as Kredit , 0 AS Posted
						FROM ACC_VALUE av
						LEFT JOIN viRptGeneralLedger v ON v.Account = av.account
						AND av.Years = v.Years
						INNER JOIN Accounts a ON a.Account = av.Account
						WHERE av.Years = '".$tahun."'
						".$qakun2."
						ORDER BY account, `Nom` ASC");
		$items=$query->result_array();
		return $items;
	}

	function getAllAktifitas($tahun,$bulan,$level){
		$bulan=intval($bulan);
		$db=array('0'=>'DB0','1'=>'DB1','2'=>'DB2','3'=>'DB3','4'=>'DB4','5'=>'DB5','6'=>'DB6','7'=>'DB7','8'=>'DB8','9'=>'DB9','10'=>'DB10','11'=>'DB11','12'=>'DB12');
		$cr=array('0'=>'CR0','1'=>'CR1','2'=>'CR2','3'=>'CR3','4'=>'CR4','5'=>'CR5','6'=>'CR6','7'=>'CR7','8'=>'CR8','9'=>'CR9','10'=>'CR10','11'=>'CR11','12'=>'CR12');
		$kreditfirst="";
		$debitfirst="";
		for ($i=0; $i <=$bulan ; $i++) { 
			# code...
			$debitfirst.=$db[$i].'-'.$cr[$i];
			$kreditfirst.=$cr[$i].'-'.$db[$i];
			if($i!=$bulan){
				$debitfirst.='+';
				$kreditfirst.='+';
			}

		}
		if(!empty($level))$lvl="AND (a.Levels <= ".$level.")"; else $lvl="";
			//debugvar($debitfirst);
		$query=$this->db->query("SELECT v.Years, v.Account, a.Name, a.Type, a.Levels, IFNULL(a.Parent, '*') AS Parent, a.Groups, 
				CASE a.Groups WHEN 5 THEN (".$debitfirst.") 
				ELSE (".$kreditfirst.") 
				END AS B, CASE a.Groups WHEN 5 THEN (".$db[$bulan]." - ".$cr[$bulan].") ELSE (".$cr[$bulan]." - ".$db[$bulan].") END AS DB, 
				CASE a.Groups WHEN 5 THEN (".$debitfirst.") 
				ELSE (".$kreditfirst.") END AS E
				FROM ACCOUNTS AS a INNER JOIN
				ACC_VALUE AS v ON v.Account = a.Account
				WHERE (a.Groups IN (4, 5)) ".$lvl." AND (a.Type = 'G') AND 
				(CASE a.Groups WHEN 5 THEN (".$debitfirst.") 
				ELSE (".$kreditfirst.") END > 0) and v.Years=".$tahun."
				ORDER BY a.Groups, v.Account");
		$items=$query->result_array();
		return $items;
	}

	function getAllNeracaSaldo($tahun,$bulan,$akun_dari,$akun_sampai){

			//debugvar($debitfirst);
		$query=$this->db->query("SELECT a.account,b.name,ifnull(debit,0) debit,ifnull(kredit,0) kredit FROM acc_gl_detail a inner join accounts b on a.account=b.account
		left join
		(SELECT a.account,sum(value) as debit FROM acc_gl_detail a where a.is_debit=1 and year(gl_date)=".$tahun." and month(gl_date)='".$bulan."' and a.account between '".$akun_dari."' and '".$akun_sampai."' group by a.account) c on a.account=c.account
		left join
		(SELECT a.account,sum(value) as kredit FROM acc_gl_detail a where a.is_debit=0 and year(gl_date)=".$tahun." and month(gl_date)=".$bulan." and a.account between '".$akun_dari."' and '".$akun_sampai."' group by a.account) d on a.account=d.account
		where year(gl_date)=".$tahun." and month(gl_date)=".$bulan." and a.account between '".$akun_dari."' and '".$akun_sampai."'
		group by a.account");
		$items=$query->result_array();
		return $items;
	}

	function getAllDetailPenerimaan($nopenerimaan){
		$this->db->order_by('line','asc');
		$this->db->where('cso_number',$nopenerimaan);
		//$this->db->limit($limit,$offset);
		$this->db->join('accounts b','a.account=b.account');
		$query=$this->db->get("acc_cso_detail a");
		return $query->result_array();		
	}

	function getJumlahTransaksiBulan($tahun,$bulan){
		//if(!empty($nama)) $this->db->like('nama_pasien',$nama);
		$this->db->select('max(mid(cso_number,5,3)) as urut',false);
		$this->db->where('year(cso_date)',$tahun);
		$this->db->where('month(cso_date)',$bulan);
		$this->db->where('a.type',1);
		$query=$this->db->get("acc_cso a");
		$item= $query->row_array();
		return $item['urut'];
	}

	function isNumberExist($number){
		$this->db->where('cso_number',$number);
		$query=$this->db->get('acc_cso');
		$count=$query->num_rows();
		if($count){
			return true;
		}
		return false;
	}

	function getAccValueAkhir($tahun,$account){
		$query = $this->db->query("SELECT ifnull( sum( DB13 ) , 0 ) AS totaldb13, ifnull( sum( CR13 ) , 0 ) AS totalcr13, ifnull( ifnull( sum( DB13 ) , 0 ) - ifnull( sum( CR13 ) , 0 ) , 0 ) AS total, ifnull( ifnull( sum( CR13 ) , 0 ) - ifnull( sum( DB13 ) , 0 ) , 0 ) AS total1
		FROM acc_value
		WHERE 
		years = '".$tahun."'
		and
		account
		IN (
		".$account."
		)");

		$item=$query->row_array();
		return $item;
	}

	function getAccValueAwal($tahun,$account){
		$query = $this->db->query("SELECT ifnull( sum( DB0 ) , 0 ) AS totaldb0, ifnull( sum( CR0 ) , 0 ) AS totalcr0, ifnull( ifnull( sum( DB0 ) , 0 ) - ifnull( sum( CR0 ) , 0 ) , 0 ) AS total, ifnull( ifnull( sum( CR0 ) , 0 ) - ifnull( sum( DB0 ) , 0 ) , 0 ) AS total1
		FROM acc_value
		WHERE 
		years = '".$tahun."'
		and
		account
		IN (
		".$account."
		)");

		$item=$query->row_array();
		return $item;
	}

	function getAccNeraca($tahunlalu,$tahunsekarang){
		$query = $this->db->query(" SELECT a.account, b.name, sum(
				CASE WHEN a.years =".$tahunlalu."
				AND b.Groups =1
				THEN DB13 - CR13
				WHEN a.years =".$tahunlalu."
				AND b.Groups <>1
				THEN cr13 - db13
				ELSE 0
				END ) AS TahunLalu, sum(
				CASE WHEN a.years =".$tahunsekarang."
				AND b.Groups =1
				THEN DB13 - CR13
				WHEN a.years =".$tahunsekarang."
				AND b.Groups <>1
				THEN cr13 - db13
				ELSE 0
				END ) AS TahunSekarang, b.type, b.groups
				FROM acc_value a
				INNER JOIN accounts b ON b.account = a.account
				WHERE b.Groups
				IN (
				'1', '2', '3'
				)
				AND a.Years
				IN ( ".$tahunsekarang.", ".$tahunlalu." )
				GROUP BY a.account, b.name, b.type, b.Groups
				ORDER BY account");

		$items=$query->result_array();
		return $items;
	}
	
	function getAccNeracaSAP($tahunsekarang){
		$query = $this->db->query(" SELECT a.account, a.name, sum( c.TahunSekarang ) AS jumlah
				FROM accounts_sap a
				JOIN account_mapping b ON a.account = b.account_sap
				JOIN (

				SELECT a.account, b.name, sum(
				CASE WHEN a.years ='".$tahunsekarang."'
				AND b.Groups =1
				THEN DB13 - CR13
				WHEN a.years ='".$tahunsekarang."'
				AND b.Groups <>1
				THEN cr13 - db13
				ELSE 0
				END ) AS TahunSekarang, b.type, b.groups
				FROM acc_value a
				INNER JOIN accounts b ON b.account = a.account
				WHERE b.Groups
				IN (
				'1', '2', '3'
				)
				AND a.Years
				IN ( '".$tahunsekarang."' )
				GROUP BY a.account, b.name, b.type, b.Groups
				ORDER BY account
				) AS c ON b.account_sak = c.account
				GROUP BY a.account, a.name, a.type, a.groups
				ORDER BY a.account");

		$items=$query->result_array();
		return $items;
	}
	
}
	
?> 
