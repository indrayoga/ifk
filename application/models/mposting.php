<?



class Mposting extends CI_Model {

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

    function updateValue($value,$akun,$bulan,$tahun,$isdebit=1){
    	$kolomdebit=array('01'=>'DB1','02'=>'DB2','03'=>'DB3','04'=>'DB4','05'=>'DB5','06'=>'DB6','07'=>'DB7','08'=>'DB8','09'=>'DB9','10'=>'DB10','11'=>'DB11','12'=>'DB12');
		$kolomkredit=array('01'=>'CR1','02'=>'CR2','03'=>'CR3','04'=>'CR4','05'=>'CR5','06'=>'CR6','07'=>'CR7','08'=>'CR8','09'=>'CR9','10'=>'CR10','11'=>'CR11','12'=>'CR12');
    	if($isdebit){
	    	$query=$this->db->query('update acc_value set '.$kolomdebit[$bulan].'='.$kolomdebit[$bulan].'+'.$value.' where account="'.$akun.'" and years="'.$tahun.'" ');    		
    	}else{
	    	$query=$this->db->query('update acc_value set '.$kolomkredit[$bulan].'='.$kolomkredit[$bulan].'+'.$value.' where account="'.$akun.'" and years="'.$tahun.'" ');    		    		
    	}

    	$this->updateValue13($akun);
    	return true;
    }

    function updateValue13($akun){
    	$this->db->query('update acc_value set DB13=(DB0+DB1+DB2+DB3+DB4+DB5+DB6+DB7+DB8+DB9+DB10+DB11+DB12),CR13=(CR0+CR1+CR2+CR3+CR4+CR5+CR6+CR7+CR8+CR9+CR10+CR11+CR12) where account="'.$akun.'"');
    	return true;
    }

    function updateValue13versi1(){
    	$this->db->query('update acc_value set DB13=(DB0+DB1+DB2+DB3+DB4+DB5+DB6+DB7+DB8+DB9+DB10+DB11+DB12),CR13=(CR0+CR1+CR2+CR3+CR4+CR5+CR6+CR7+CR8+CR9+CR10+CR11+CR12) ');
    	return true;
    }

    function updateValue0($value,$akun,$tahun,$isdebit=1){
    	if($isdebit){
    		if(!empty($value)){
    			$this->db->query('update acc_value set DB0=(DB0+'.$value.') where account="'.$akun.'" and years="'.$tahun.'"');
    		}
    	}else{
    		if(!empty($value)){
	    		$this->db->query('update acc_value set CR0=(CR0+'.$value.') where account="'.$akun.'" and years="'.$tahun.'"');    			
    		}
    	}
    	return true;
    }

    function updateValue0versi1($value,$akun,$tahun,$isdebit=1){
    	if($isdebit){
    		if(!empty($value)){
    			$this->db->query('update acc_value set DB0='.$value.' where account="'.$akun.'" and years="'.$tahun.'"');
    		}
    	}else{
    		if(!empty($value)){
	    		$this->db->query('update acc_value set CR0='.$value.' where account="'.$akun.'" and years="'.$tahun.'"');    			
    		}
    	}
    	return true;
    }

    function updateValueDBCR0($tahun){
    	$this->db->query("UPDATE acc_value,
		(
		SELECT y.parent, sum( x.DB0 ) AS z
		FROM acc_value x
		JOIN accounts y ON x.account = y.account
		WHERE x.years ='".$tahun."'
		GROUP BY y.parent
		) AS total,
		(
		SELECT y.parent, sum( x.CR0 ) AS z
		FROM acc_value x
		JOIN accounts y ON x.account = y.account
		WHERE x.years ='".$tahun."'
		GROUP BY y.parent
		) AS totalcr
		SET acc_value.DB0 = total.z,acc_value.CR0 = totalcr.z WHERE acc_value.account = total.parent AND years ='".$tahun."'");
    	return true;
    }

    function delete($table,$id) {
		$this->db->where($id,null,false);
		$this->db->delete($table);
		return true;
    }	

	function isPosted($tahun,$bulan)
	{
		$this->db->where('tahun',$tahun);
		$this->db->where('bulan',$bulan);
		$this->db->where('posted',1);
		$query=$this->db->get('acc_posting');
		$item=$query->num_rows();
		if($item)return true;
		return false;
	}

	function isMonthPosted($bulan)
	{
		$this->db->where('month(gl_date)',$bulan);
		$this->db->where('posted',1);
		$query=$this->db->get('acc_gl_detail');
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

	function isChild($account)
	{
		$this->db->where('account',$account);
		$query=$this->db->get('accounts');
		$item=$query->row_array();
		if(!empty($item['parent']) && $item['parent']!=null && $item['parent']!="Null")return true;
		return false;
	}

	function getAllValueByMonth($month,$debit=1){
		$this->db->select('*,sum(value) as total');
		$this->db->where('a.is_debit',$debit);
		$this->db->where('a.posted',0);
		$this->db->where('month(a.gl_date)',$month);
		$this->db->join('accounts b','a.account=b.account');
		$this->db->group_by('a.account');
		$query=$this->db->get("acc_gl_detail a");
		return $query->result_array();
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
		$this->db->select('max(right(cso_number,3)) as urut',false);
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

	function creataccvalue($tahun){
		$tahundepan=$tahun+1;
		$this->db->query("insert into acc_value(years,account,DB0,CR0) select ".$tahundepan.",account,DB13,CR13 from acc_value where years=".$tahun." ");
		return true;
	}
	
}
	
?>
