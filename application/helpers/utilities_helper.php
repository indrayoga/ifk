<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * CodeIgniter
 *
 * An open source application development framework for PHP 5.1.6 or newer
 *
 * @package		CodeIgniter
 * @author		ExpressionEngine Dev Team
 * @copyright	Copyright (c) 2008 - 2011, EllisLab, Inc.
 * @license		http://codeigniter.com/user_guide/license.html
 * @link		http://codeigniter.com
 * @since		Version 1.0
 * @filesource
 */

// ------------------------------------------------------------------------

/**
 * CodeIgniter HTML Helpers
 *
 * @package		CodeIgniter
 * @subpackage	Helpers
 * @category	Helpers
 * @author		ExpressionEngine Dev Team
 * @link		http://codeigniter.com/user_guide/helpers/html_helper.html
 */

// ------------------------------------------------------------------------

/**
 * Heading
 *
 * Generates an HTML heading tag.  First param is the data.
 * Second param is the size of the heading tag.
 *
 * @access	public
 * @param	string
 * @param	integer
 * @return	string
 */
/**
 * Utilities
 * Fungsi-fungsi utility
 *
 * @access public
 * @author Agung Harry Purnama (agung.hp@awakami.com)
 * @since 7/21/2006 3:31PM
 */

/* ----------------------------------------------------------------------
 * DATE AND TIME FUNCTIONS
 * ---------------------------------------------------------------------- */

/**
 * convertDate
 * fungsi untuk melakukan konversi dari format dd-mm-yyyy ke yyyy-mm-dd atau sebaliknya
 * 
 * @author agung.hp
 * @since 09/10/2005 20:39
 * @param string date
 * @return string converted date
 */
 if ( ! function_exists('convertDate'))
{
	function convertDate($date){
		$date = trim($date);
		if (empty($date))    
			return NULL;

		$pieces = explode('-', $date);
		if (count($pieces) != 3)
			return NULL;
		
		return $pieces[2].'-'.$pieces[1].'-'.$pieces[0];    
	}
}

 if ( ! function_exists('convertDateByDelimiter'))
{
	function convertDateByDelimiter($date,$delimiter){
		$date = trim($date);
		if (empty($date))    
			return NULL;

		$pieces = explode($delimiter, $date);
		if (count($pieces) != 3)
			return NULL;
		
		return $pieces[2].'-'.$pieces[1].'-'.$pieces[0];    
	}
}

/* encript password dengan salt*/
 if ( ! function_exists('encryptepass'))
{
	function encryptepass($pass,$salt){
		if (empty($pass) || empty($salt))    
			return false;
		
		return md5($salt . md5($pass . $salt));
	}
}

function romanic_number($integer, $upcase = true)
{
    $table = array('M'=>1000, 'CM'=>900, 'D'=>500, 'CD'=>400, 'C'=>100, 'XC'=>90, 'L'=>50, 'XL'=>40, 'X'=>10, 'IX'=>9, 'V'=>5, 'IV'=>4, 'I'=>1);
    $return = '';
    while($integer > 0)
    {
        foreach($table as $rom=>$arb)
        {
            if($integer >= $arb)
            {
                $integer -= $arb;
                $return .= $rom;
                break;
            }
        }
    }

    return $return;
} 
/**
 * validateDate
 * fungsi untuk memvalidasi nilai tanggal yang diberikan
 * 
 * @author agung.hp
 * @since 09/10/2005 20:40
 * @param string date dengan format dd-mm-yyyy
 * @return boolean true atau false
 */
 if ( ! function_exists('validateDate'))
{
	function validateDate($date){
		// 1. check empty
		$date = trim($date);
		if (empty($date))
			return false;
		
		// 2. check length
		if (strlen($date) < 8){
			return false;
		}
		// 3. check num index
		$pieces = explode('-', $date);
		if (count($pieces) != 3)
			return false;
		
		$day = $pieces[0];
		$month = $pieces[1];
		$year = $pieces[2];
		
		// 4. check data type
		if (!is_numeric($month) || !is_numeric($day) || !is_numeric($year))
			return false;
		
		// 5. check date value
		if (!checkdate($month, $day, $year))
			return false;
		
		// valid beneran gitu lohh....
		return true;
	}
}
/**
 * validateTime
 * fungsi untuk mengvalidasi nilai tanggal yang diberikan
 * 
 * @author Muhamad Heriyana
 * @since 22/09/2006 14:18
 * @param string time dengan format hh-mm-ss
 * @return boolean true atau false
 */
 if ( ! function_exists('validateDate'))
{ 
	function validateTime($time) {
		
	   $time = trim($time);
		//1. Check empty
	   if (empty($time))
		return false;
	   
	   // 2. check length
	   if ((strlen($time) < 8) || (strlen($time) > 8))
		return false;
		
	   //3.Check pieces
	   $pieces = explode(':',$time);
	   if (count($pieces) != 3)
		return false;
		
	   $hour = $pieces[0];
	   $minute = $pieces[1];
	   $second = $pieces[2];
	   
	   //4.Check numerik
	   if (!is_numeric($hour) || !is_numeric($minute) || !is_numeric($second))
		return false;
	   
	   //5.Check hour
	   if ($hour < 0 || $hour > 23)
		return false;
	   
	   //6.Check minute
	   if ($minute < 0 || $minute > 59)
		return false;
		
	   //5.Check second
	   if ($second < 0 || $second > 59)
		return false;
	   //Time is valid ABCD (Aduh Bow Cuape Deehh)
	   return true;
		
	}
}   	

 if ( ! function_exists('debugvar'))
{ 
	function debugvar($var){
		echo '<pre>';
			print_r($var);
		echo '</pre>';
		exit;
	}
}

/**
 * set the session status msg
 *
 * @author agung.hp
 * @return boolean 
 */

/**
 * get the session status msg and do some clean up if exist
 *
 * @author agung.hp
 * @return string 
 */
 if ( !function_exists('validateYear'))
{ 
	function validateYear($year){
		if (strlen($year) != 4)
			return false;
		
		if (!is_numeric($year))
			return false;
			
		return true;
	}
}
 if ( !function_exists('convertToDayName'))
{ 
	function convertToDayName($dayIndex){
		$days = array(0 => 'Minggu',
					  1 => 'Senin',
					  2 => 'Selasa',
					  3 => 'Rabu',
					  4 => 'Kamis',
					  5 => 'Jumat',
					  6 => 'Sabtu');
		return $days[$dayIndex];                  
	}
}
// wara
 if ( !function_exists('convertToDayIndex'))
{ 
	function convertToDayIndex($dayName){
		$dayName = strtolower($dayName);
		$days = array('minggu' => 0,
					  'senin' => 1,
					  'selasa' => 2,
					  'rabu' => 3,
					  'kamis' => 4,
					  'jumat' => 5,
					  'sabtu' => 6);
		return $days[$dayName];                  
	}
}
 if ( !function_exists('indexToBulan'))
{ 
	function indexToBulan($ddmmyyyy){
		$date = trim($ddmmyyyy);
		if (empty($date))    
			return NULL;

		$pieces = explode('-', $date);
		if (count($pieces) != 3)
			return NULL;
		$namabulan = array('01'=> 'Januari',
							'02'=> 'Februari',
							'03'=> 'Maret',
							'04'=> 'April',
							'05'=> 'Mei',
							'06'=> 'Juni',
							'07'=> 'Juli',
							'08'=> 'Agustus',
							'09'=> 'September',
							'10'=> 'Oktober',
							'11'=> 'Nopember',
							'12'=> 'Desember');    
		return $pieces[0].' '.$namabulan[$pieces[1]].' '.$pieces[2];        
	}
}

 if ( !function_exists('indexToMonth'))
{ 
	function indexToMonth($ddmmyyyy){
		$date = trim($ddmmyyyy);
		if (empty($date))    
			return NULL;

		$pieces = explode('-', $date);
		if (count($pieces) != 3)
			return NULL;
		$namabulan = array('01'=> 'January',
							'02'=> 'February',
							'03'=> 'March',
							'04'=> 'April',
							'05'=> 'May',
							'06'=> 'June',
							'07'=> 'July',
							'08'=> 'August',
							'09'=> 'September',
							'10'=> 'October',
							'11'=> 'November',
							'12'=> 'December');    
		return $namabulan[$pieces[1]].' '.$pieces[0].', '.$pieces[2];        
	}
}
 if ( !function_exists('getCurrentDate'))
{ 
function getCurrentDate(){
    $today = getdate(); 
    $month = $today['mon']; 
    $monthday  = $today['mday']; 
    $year  = $today['year'];

    if (strlen($monthday) < 2)
        $monthday = '0'.$monthday;
        
    if (strlen($month) < 2)
        $month = '0'.$month;
                
    return $monthday.'-'.$month.'-'.$year;    
}
}
 if ( !function_exists('dateToString'))
{ 
function dateToString($date){
    $monthname = array(0  => '-',
                       1  => 'Januari',
                       2  => 'Februari',
                       3  => 'Maret',
                       4  => 'April',
                       5  => 'Mei',
                       6  => 'Juni',
                       7  => 'Juli',
                       8  => 'Agustus',
                       9  => 'September',
                       10 => 'Oktober',
                       11 => 'November',
                       12 => 'Desember');    
    
    $pieces = explode('-', $date);
    
    return $pieces[2].' '.$monthname[(int)$pieces[1]].' '.$pieces[0];
}
}
/**
 * compareDate
 *
 * Melakukan perbandingan dua tanggal
 *
 * @param string $from_date : batas tanggal awal dalam format yyyy-mm-dd
 * @param string $to_date   : batas tanggal akhir dalam format yyyy-mm-dd
 * @return 1 jika from_date < to_date, 2 jika from_date > to_date, 3 jika from_date = to_date
 */
 if ( !function_exists('compareDate'))
{  
	function compareDate($from_date, $to_date) {
		$from_date = trim($from_date);
		$to_date = trim($to_date);
		
		if ($from_date == $to_date){
			return 3;
		}
		
		$waktu_awal = explode("-",$from_date);
		$waktu_akhir = explode("-",$to_date);
		if ($waktu_awal[0] > $waktu_akhir[0]){
			return 2;
		}else if ($waktu_awal[0] == $waktu_akhir[0]){
			if ($waktu_awal[1] > $waktu_akhir[1]){
				return 2;
			}else if ($waktu_awal[1] == $waktu_akhir[1]){
				if ($waktu_awal[2] > $waktu_akhir[2]){
					return 2;
				}
			}
		}
		return 1;
	}
}
 if ( !function_exists('getCurrentURL'))
{  
function getCurrentURL(){
    global $_SERVER;
    return "index.php?".$_SERVER['QUERY_STRING'];
}
}
//function for converting if the group of thousand separator is only one digit
 if ( !function_exists('numericToString'))
{  
function numericToString($nilai){
  
  $checkSprtrThousand = explode(".",(number_format($nilai, 0, chr(44), ".")));
  $a = count($checkSprtrThousand)-1;
  $sayValue = "";
  $b=0;
  while($a >= 0)
    {
		
		$b++;
		
		//cari satuan per separator ribuan
    $chars = preg_split('//', $checkSprtrThousand[$a], -1, PREG_SPLIT_NO_EMPTY);
		$x = count($chars)-1;
		$y=0;
		
		switch(count($chars))
			{
				case "1" : $getValue = getOne($chars); 
				           break;
				case "2" : $getValue = getTwo($chars); 
				           break;
				case "3" : $getValue = getThree($chars);
				           break;
			}
    if(!empty($getValue))
        {
        	switch($b)
						{
							case	"2"	:	$getValue=$getValue." Ribu ";
											if($getValue=="Satu Ribu "){$getValue="Seribu ";}
											break;
							case	"3"	:	$getValue=$getValue." Juta ";
											if($getValue=="Satu Juta "){$getValue="Sejuta ";}
											break;
							case	"4"	:	$getValue=$getValue." Milyar ";break;
							case	"5"	:	$getValue=$getValue." Trilyun ";break;
						}
				}
		$sayValue = $getValue.$sayValue;
    $a = $a-1;
        }//endwhile($a < count($checkSprtrThousand))
  return $sayValue;
  }
}

 if ( !function_exists('getOne'))
{  
	function getOne($chars)
	{
		$getValue="";
		$sayNumber = getNumber($chars[0]);
		$getValue = $getValue.$sayNumber;
		return $getValue;
	}
}

//function for converting if the group of thousand separator is two digits
function getTwo($chars)
{
	$getValue="";
	//cek apakah belasan
	if($chars[0] == 1)
		{
			if($chars[1] > 0)
			{
				$sayNumber = getNumber($chars[1]);
				$sayNumber = $sayNumber." Belas ";
				if($sayNumber == "Satu Belas "){$sayNumber="Sebelas ";}
				$getValue = $getValue.$sayNumber;
			}
			else{
				$sayNumber = "Sepuluh";
				$getValue  = $getValue.$sayNumber;
			}
		}
	   else
			{
				if($chars[1] > 0)
					{
						$sayNumber = getNumber($chars[1]);
						$getValue = $getValue.$sayNumber;
					}
				if($chars[0] > 0)
					{
						$sayNumber = getNumber($chars[0]);
						$sayNumber = $sayNumber." Puluh ";
						if($sayNumber=="Satu Puluh "){$sayNumber="Sepuluh ";}
						$getValue = $sayNumber.$getValue;
					}
			}
	return $getValue;
}

//function for converting if the group of thousand separator is three
function getThree($chars)
{
	$getValue="";
	//cek apakah belasan
	if($chars[1]==1)
		{
			if($chars[2] > 0)
			{
				$sayNumber = getNumber($chars[2]);
				$sayNumber = $sayNumber." Belas ";
				if($sayNumber == "Satu Belas "){$sayNumber="Sebelas ";}
				$getValue = $getValue.$sayNumber;
			}
			else{
				$sayNumber = "Sepuluh";
				$getValue  = $getValue.$sayNumber;
			}
		}
	   else
			{
				if($chars[2] <> 0)
					{
						$sayNumber = getNumber($chars[2]);
						$getValue = $getValue.$sayNumber;
					}
				if($chars[1] <> 0)
					{
						$sayNumber = getNumber($chars[1]);
						$sayNumber = $sayNumber." Puluh ";
						if($sayNumber=="Satu Puluh "){$sayNumber="Sepuluh ";}
						$getValue = $sayNumber.$getValue;
					}
			}
    if($chars[0] <> 0)
        {
            $sayNumber = getNumber($chars[0]);
            $sayNumber = $sayNumber." Ratus ";
			if($sayNumber=="Satu Ratus "){$sayNumber="Seratus ";}
            $getValue = $sayNumber.$getValue;
        }
	return $getValue;
}

//function for converting from hexadecimal number to phrase
function getNumber($number){
    
    switch($number)
       {
          case "0" : $sayNumber = "Nol";break;
          case "1" : $sayNumber = "Satu";break;
          case "2" : $sayNumber = "Dua";break;
          case "3" : $sayNumber = "Tiga";break;
          case "4" : $sayNumber = "Empat";break;
          case "5" : $sayNumber = "Lima";break;
          case "6" : $sayNumber = "Enam";break;
          case "7" : $sayNumber = "Tujuh";break;
          case "8" : $sayNumber = "Delapan";break;
          case "9" : $sayNumber = "Sembilan";break;
        }
    return $sayNumber;
    }

/**
 * splitNip
 * fungsi untuk mengformat nip dengan format "XXXYYYZZZ" menjadi "XXX YYY ZZZ"
 * 
 * @author Muhamad Heriyana
 * @since 06/09/2006 11:20
 * @param int nip
 * @return string split_nip
 */
function splitNip($nip){
	
	$nip = trim($nip);
if (empty($nip))
	return NULL;

if (strlen($nip) != 9)
	return $nip;
		
	$tmp = array();
	
	$tmp[0] = substr($nip,0,3);
	$tmp[1] = substr($nip,3,3);
	$tmp[2] = substr($nip,-3);

	$split_nip = $tmp[0]." ".$tmp[1]." ".$tmp[2];
	
	return $split_nip;
}

/**
 * getNamaHari
 * fungsi untuk mendapatkan nama hari dalam bahasa indonesia
 * 
 * @author Dude
 * @since 10/13/2006 11:01AM
 * @param str $ddmmyyyy			tanggal dengan format ddmmyyyy, contoh : '13-10-2006'
 * @return string namahari	
 */
 if ( !function_exists('getNamaHari'))
{   
	function getNamaHari($ddmmyyyy){
		if (empty($ddmmyyyy) || !validateDate($ddmmyyyy))    
        return NULL;
		$dayindex = date('w',strtotime(convertdate(trim($ddmmyyyy))));		
    $namahari = '';
    switch($dayindex)
       {
          case "0" : $namahari = "Minggu";break;
          case "1" : $namahari = "Senin";break;
          case "2" : $namahari = "Selasa";break;
          case "3" : $namahari = "Rabu";break;
          case "4" : $namahari = "Kamis";break;
          case "5" : $namahari = "Jum'at";break;
          case "6" : $namahari = "Sabtu";break;
       }
    return $namahari;
  }
 } 
  /**
 * getNamaTanggal
 * fungsi untuk mendapatkan tanggal dalam format text bahasa indonesia
 * 
 * @author Dude
 * @since 10/13/2006 11:01AM
 * @param str $ddmmyyyy			tanggal dengan format ddmmyyyy, contoh : '13-10-2006'
 * @return string namatanggal	
 */
 if ( !function_exists('getNamaTanggal'))
{    
	function getNamaTanggal($ddmmyyyy){
		if (empty($ddmmyyyy) || !validateDate($ddmmyyyy))    
        return NULL;
		$tgl = date('j',strtotime(convertdate(trim($ddmmyyyy))));		
    return numericToString($tgl);
  }
 }
   /**
 * getNamaTahun
 * fungsi untuk mendapatkan tahun dalam format text bahasa indonesia
 * 
 * @author Dude
 * @since 10/13/2006 11:01AM
 * @param str $ddmmyyyy			tanggal dengan format ddmmyyyy, contoh : '13-10-2006'
 * @return string namatahun	
 */
 if ( !function_exists('getNamaTahun'))
{     
	function getNamaTahun($ddmmyyyy){
		if (empty($ddmmyyyy) || !validateDate($ddmmyyyy))    
        return NULL;
		$tahun = date('Y',strtotime(convertdate(trim($ddmmyyyy))));		
    return numericToString($tahun);
  }
}
  // $date format : yyyy-mm-dd
	function getDateInfo($date){
	    if (empty($date)) return false;
	    
	    $pieces = explode('-', $date);
	    $month = $pieces[1];
	    $day = $pieces[2];
	    $year = $pieces[0];
	    
	    $timestamp = mktime (0, 0, 0, $month , $day , $year);
	    $dateInfo = getdate($timestamp);
	    
	    $data = array('tgl' => $dateInfo['mday'],
	                  'bln_no' => $dateInfo['mon'],
	                  'bln_str' => getMonthNameByID($dateInfo['mon']),
	                  'thn' => $dateInfo['year'],
	                  'hari' => getWeekDayNameByID($dateInfo['wday']));
	                  
        return $data;
	    
	}

	function getMonthNameByID($id){
    $months = array( 1 => 'Januari',
     				 '01' => 'Januari',
    				 '02' => 'Februari',

    				 '03' => 'Maret',

    				 '04' => 'April',

    				 '05' => 'Mei',

    				 '06' => 'Juni',

    				 '07' => 'Juli',

    				 '08' => 'Agustus',

    				 '09' => 'September',
                    2 => 'Februari',
                     3 => 'Maret',
                     4 => 'April',
                     5 => 'Mei',
                     6 => 'Juni',
                     7 => 'Juli',
                     8 => 'Agustus',
                     9 => 'September',
                     10 => 'Oktober',
                     11 => 'November',
                     12 => 'Desember');
                     
    if (isset ($months[$id]))
        return $months[$id];
    else
        return 'Unknown Month ID';                         
	}

	function getShortMonthNameByID($id){
    $months = array( 
    				 1 => 'Jan',
    				 '01' => 'Jan',
                     2 => 'Feb',
    				 '02' => 'Feb',
                     3 => 'Mar',
    				 '03' => 'Mar',
                     4 => 'Apr',
    				 '04' => 'Apr',
                     5 => 'Mei',
    				 '05' => 'Mei',
                     6 => 'Jun',
    				 '06' => 'Jun',
                     7 => 'Jul',
    				 '07' => 'Jul',
                     8 => 'Agust',
    				 '08' => 'Agust',
                     9 => 'Sept',
    				 '09' => 'Sept',
                     10 => 'Okt',
                     11 => 'Nov',
                     12 => 'Des');
                     
    if (isset ($months[$id]))
        return $months[$id];
    else
        return 'Unknown Month ID';                         
	}

	function getWeekDayNameByID($id){
    $weekdays = array( 0 => 'Minggu',
                     1 => 'Senin',
                     2 => 'Selasa',
                     3 => 'Rabu',
                     4 => 'Kamis',
                     5 => 'Jumat',
                     6 => 'Sabtu');
                     
    if (isset ($weekdays[$id]))
        return $weekdays[$id];
    else
        return 'Unknown Week Day ID';                         
	}
  function getNamaBulan($ddmmyyyy){
		if (empty($ddmmyyyy) || !validateDate($ddmmyyyy))    
        return NULL;
		$monthindex = date('n',strtotime(convertdate(trim($ddmmyyyy))));	
		$namabulan = '';
    switch($monthindex)
       {
					case "1"  :$namabulan ='Januari';break;
          case "2"  :$namabulan ='Februari';break;
          case "3"  :$namabulan ='Maret';break;
          case "4"  :$namabulan ='April';break;
          case "5"  :$namabulan ='Mei';break;
          case "6"  :$namabulan ='Juni';break;
          case "7"  :$namabulan ='Juli';break;
          case "8"  :$namabulan ='Agustus';break;
          case "9"  :$namabulan ='September';break;
          case "10" :$namabulan ='Oktober';break;
          case "11" :$namabulan ='November';break;
          case "12" :$namabulan ='Desember';break;
       }
    return $namabulan;
  }
  
 /**
 * function nextDate
 * fungsi untuk mendapatkan tanggal berikutnya
 * 
 * @author Dude
 * @since 10/18/2006 12:38PM
 * @param str $input			tanggal dengan format dd-mm-yyyy, contoh : '13-10-2006'
 * @param str $element		element tanggal yg akan ditambah : d = hari, m = bulan, y = tahun
 * @param int $value			nilai yg akan ditambahkan terhadap element
 * @param str $format			format tanggal output yg diinginkan.
 	 format tanggal yg valid : 	1) "d-m-y" -> 01-08-06
 	 														2) "d-m-Y" -> 01-08-2006
 	 														3) "j-m-Y" -> 1-08-2006
 	 														4) "d/m/Y" -> 01/08/2006
 	 														dan lain-lain (baca manual php tentang date)
 */
function nextDate($input,$element = 'y',$value,$format = "d-m-Y"){
	if (!validateDate($input)) return 0;
	$input = convertDate($input);
	$now = strtotime($input);		
	switch($element)                               
   	{                                              
		case "d"  :$next = mktime(0, 0, 0, date('m',$now),date('d',$now) + $value,date('Y',$now));break;     			
		case "m"  :$next = mktime(0, 0, 0, date('m',$now) + $value,date('d',$now),date('Y',$now));break;     			
		case "y"  :$next = mktime(0, 0, 0, date('m',$now),date('d',$now),date('Y',$now)+$value);break;     			
		default:$next = $now;
	}
	return date($format,$next);
} 
	
/* function showMonthNames
 * get month name from currrent index
 * 
 * author didit
 * since 06/12/2006 16:10
 * param int $mindex	 
 */
	 
function showMonthNames($mindex) {	    		   
    if (!$mindex) return;	    
    $mindex--;
    $month = array('Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember');
    return $month[$mindex];
}
	
function convertDateDMY($date) {
	  
    $date = trim($date);
    //die($date);
    if (empty($date))    
        return NULL;

    $pieces = explode('-', $date);
    if (count($pieces) != 3)
        return NULL;
    
    $month = array('Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember');
    //die($pieces[0]);
    return $pieces[2].'-'.$month[$pieces[1]-1].'-'.$pieces[0];    
}

	if(!function_exists('bulanpembelajaran')){
		function bulanpembelajaran($tahunajaran){
			$bulan=array();
			$bln=array();
			list($thn1,$thn2)=explode("/",$tahunajaran);
			$bulan[1]=array("bulan"=>7,"tahun"=>$thn1);
			$bulan[2]=array("bulan"=>8,"tahun"=>$thn1);
			$bulan[3]=array("bulan"=>9,"tahun"=>$thn1);
			$bulan[4]=array("bulan"=>10,"tahun"=>$thn1);
			$bulan[5]=array("bulan"=>11,"tahun"=>$thn1);
			$bulan[6]=array("bulan"=>12,"tahun"=>$thn1);
			$bulan[7]=array("bulan"=>1,"tahun"=>$thn2);
			$bulan[8]=array("bulan"=>2,"tahun"=>$thn2);
			$bulan[9]=array("bulan"=>3,"tahun"=>$thn2);
			$bulan[10]=array("bulan"=>4,"tahun"=>$thn2);
			$bulan[11]=array("bulan"=>5,"tahun"=>$thn2);
			$bulan[12]=array("bulan"=>6,"tahun"=>$thn2);
			
			foreach($bulan as $key => $item){
				$bln[$key]=getMonthNameByID($item['bulan'])." ".$item['tahun'];
			}
			return $bln;
		}
	}

	
 if ( !function_exists('startExcel'))
{     
	
function startExcel($filename = "laporan.xls") {	    
    header("Content-type: application/vnd.ms-excel");
    header("Content-Disposition: attachment; filename=$filename");
    header("Expires: 0");
    header("Cache-Control: must-revalidate, post-check=0,pre-check=0");
    header("Pragma: public");	    
}
	}
 if ( !function_exists('startDoc'))
{     	
function startDoc($filename = "laporan.doc") {	    
    header("Content-type: application/vnd.ms-word");
    header("Content-Disposition: attachment; filename=$filename");
    header("Expires: 0");
    header("Cache-Control: must-revalidate, post-check=0,pre-check=0");
    header("Pragma: public");	    
}
}	

if(!function_exists('carisemester')){
	function carisemester($angkatan,$tahunajaran,$semester){
		if (empty($angkatan)||empty($tahunajaran)||empty($semester))return NULL;
		$pieces=explode("/",$tahunajaran);
		if(count($pieces)!=2)return null;
		$x=0;
		$x=(($pieces[0]-$angkatan)* 2)+2;
		if(strtolower($semester)=="ganjil")$x--;
		
		return $x;
	}
}

function combotgl($awal, $akhir, $var, $terpilih){
  $tgl= "<select name=$var>";
  for ($i=$awal; $i<=$akhir; $i++){
    $lebar=strlen($i);
    switch($lebar){
      case 1:
      {
        $g="0".$i;
        break;     
      }
      case 2:
      {
        $g=$i;
        break;     
      }      
    }  
    if ($i==$terpilih)
      $tgl.= "<option value=$g selected>$g</option>";
    else
      $tgl.= "<option value=$g>$g</option>";
  }
  $tgl.= "</select> ";
  
  return $tgl;
}

function combobln($awal, $akhir, $var, $terpilih){
  $blnx =  "<select name=$var>";
  for ($bln=$awal; $bln<=$akhir; $bln++){
    $lebar=strlen($bln);
    switch($lebar){
      case 1:
      {
        $b="0".$bln;
        break;     
      }
      case 2:
      {
        $b=$bln;
        break;     
      }      
    }  
      if ($bln==$terpilih)
         $blnx .= "<option value=$b selected>$b</option>";
      else
        $blnx .= "<option value=$b>$b</option>";
  }
  $blnx .= "</select> ";
  
  return $blnx;
}

function combothn($awal, $akhir, $var, $terpilih){
  $thnx = "<select name=$var>";
  for ($i=$awal; $i<=$akhir; $i++){
    if ($i==$terpilih)
      $thnx .= "<option value=$i selected>$i</option>";
    else
      $thnx .= "<option value=$i>$i</option>";
  }
  $thnx .= "</select> ";
  
  return $thnx;
}

function combonamabln($awal, $akhir, $var, $terpilih){
  $nama_bln=array(1=> "Januari", "Februari", "Maret", "April", "Mei", 
                      "Juni", "Juli", "Agustus", "September", 
                      "Oktober", "November", "Desember");
  echo "<select name=$var>";
  for ($bln=$awal; $bln<=$akhir; $bln++){
      if ($bln==$terpilih)
         echo "<option value=$bln selected>$nama_bln[$bln]</option>";
      else
        echo "<option value=$bln>$nama_bln[$bln]</option>";
  }
  echo "</select> ";
}

if(!function_exists('time2seconds')){
	function time2seconds()
	{
		$x=date("h").":".date("m").":".date("s");
		list($hours, $mins, $secs) = explode(':', $x);
		return ($hours * 3600 ) + ($mins * 60 ) + $secs;
	}	
}

function msg($status,$txt)
{
	return '{"status":'.$status.',"txt":"'.$txt.'"}';
}

function initCalendar()
    {
		$base=base_url();
        $output = <<<HEREDOC
    <style type="text/css">@import url("{$base}js/jscalendar/calendar.css");</style>
    <script src="{$base}js/jscalendar/calendar.js" type="text/javascript"></script>
    <script src="{$base}js/jscalendar/lang/calendar-en.js" type="text/javascript"></script>
    <script src="{$base}js/jscalendar/calendar-setup.js" type="text/javascript"></script>
HEREDOC;
        return $output;
    }
    
    /**
     * Add jscalendar text box (jscalendar 0.9.6)
     *
     * @param string $id the id of the input text
     * @param string $button the id of the trigger button
     * @param string $default the default value
     * @param string $str the button text
     * @return string $output
     * @author ahp
     */
function htmlCalendarBox($id = 'tanggal', $button = 'trigger', $default = '', $str = '...', $act=''){
	$output = '';
	$output .= "\t<input type=\"text\" id=\"$id\" name=\"$id\" \"$act\" value=\"$default\" size=\"10\"/>\n";
	$output .= "\t<button id=\"$button\">$str</button>\n";
	$output .= "\t<script type=\"text/javascript\">\n";
	$output .= "\t\tCalendar.setup({inputField: \"$id\", ifFormat: \"%d-%m-%Y\", button: \"$button\"});\n";
	$output .= "\t</script>\n";
	return $output;
}         

function checkExtensi($filename,$extensi=array()){
		$ext = explode(".", $filename);
		
		if (count($ext) == 1)
			return false;
		
		$ext = $ext[count($ext)-1];	
		$ext = strtolower($ext);
		//$this->curr_ext = $ext;
		$found = false;
		
		foreach ($extensi as $key => $value) {
			if ($value == $ext) {
				$found = true;
				break;
			}
		}
		return $found;

	}
// ------------------------------------------------------------------------

function hitungHariDlmBulan($bulan,$tahun){
	$value=0;
	switch ($bulan) {
		case 1:
			$value=31;
			break;
		case 2:
			if($tahun % 4)$value=28; else $value=29;
			break;
		case 3:
			$value=31;
			break;
		case 4:
			$value=30;
			break;
		case 5:
			$value=31;
			break;
		case 6:
			$value=30;
			break;
		case 7:
			$value=31;
			break;
		case 8:
			$value=31;
			break;
		case 9:
			$value=30;
			break;
		case 10:
			$value=31;
			break;
		case 11:
			$value=30;
			break;
		case 12:
			$value=31;
			break;
		
		default:
			$value=31;
			break;
	}

	return $value;
}

function hitungumur($tgl_lahir){
	$tgl_lahir=explode("-", $tgl_lahir);
	$tgllahir=$tgl_lahir[0];
	$bulanlahir=$tgl_lahir[1];
	$tahunlahir=$tgl_lahir[2];

	$tglsekarang=date('d');
	$bulansekarang=date('m');
	$tahunsekarang=date('Y');

	$umurhari=0;
	$umurbulan=0;
	$umurtahun=0;

	if($tgllahir > $tglsekarang){
		$bulansekarang=$bulansekarang-1;
		if ($bulansekarang == 0){
			$bulansekarang=12;
			$tahunsekarang=$tahunsekarang-1;
		}
		$tglsekarang=$tglsekarang+hitungHariDlmBulan($bulansekarang,$tahunsekarang);
		$umurhari=$tglsekarang-$tgllahir;
	}else{
		$umurhari=$tglsekarang-$tgllahir;				
	}

	if($bulanlahir > $bulansekarang){
		$tahunsekarang=$tahunsekarang-1;
		$bulansekarang=$bulansekarang+12;
		$umurbulan=$bulansekarang-$bulanlahir;
	}else{
		$umurbulan=$bulansekarang-$bulanlahir;
	}

	$umurtahun=$tahunsekarang-$tahunlahir;
	/*
	if($umurtahun==0 && $umurbulan==0 && $umurhari==0){
		$umurhari=0;
	}

	if ($umurtahun==0 && $umurbulan==0 && $umurhari!=0) {
		# code...
	}
	*/
	$data=array('hari'=>$umurhari,'bulan'=>$umurbulan,'tahun'=>$umurtahun);
	return $data;
}

function hitungumurSaatDaftar($tgl_lahir,$tgl_daftar){
	$tgl_lahir=explode("-", $tgl_lahir);
	$tgllahir=$tgl_lahir[0];
	$bulanlahir=$tgl_lahir[1];
	$tahunlahir=$tgl_lahir[2];

	$tgl_daftar=explode("-", $tgl_daftar);
	$tglsekarang=$tgl_daftar[0];
	$bulansekarang=$tgl_daftar[1];
	$tahunsekarang=$tgl_daftar[2];

	$umurhari=0;
	$umurbulan=0;
	$umurtahun=0;

	$data='';

	$umurtahun=$tahunsekarang-$tahunlahir;
	$data.=$umurtahun.' Th ';

	if($bulanlahir > $bulansekarang){
		$tahunsekarang=$tahunsekarang-1;
		$bulansekarang=$bulansekarang+12;
		$umurbulan=$bulansekarang-$bulanlahir;
		$data.=$umurbulan.' Bln ';
	}else{
		$umurbulan=$bulansekarang-$bulanlahir;
		$data.=$umurbulan.' Bln ';
	}

	if($tgllahir > $tglsekarang){
		$bulansekarang=$bulansekarang-1;
		if ($bulansekarang == 0){
			$bulansekarang=12;
			$tahunsekarang=$tahunsekarang-1;
		}
		$tglsekarang=$tglsekarang+hitungHariDlmBulan($bulansekarang,$tahunsekarang);
		$umurhari=$tglsekarang-$tgllahir;
		$data.=$umurhari.' Hr ';
	}else{
		$umurhari=$tglsekarang-$tgllahir;				
		$data.=$umurhari.' Hr ';
	}

	return $data;
}

/**
 * validateDate
 * fungsi untuk memvalidasi nilai tanggal yang diberikan
 * 
 * @author indrayogapermana
 * @since Wed Jan 28 09:30:41 2015
 * @param string date dengan format yyyy-mm-dd
 * @return boolean true atau false
 */
 if ( ! function_exists('validateDateMySQL'))
{
	function validateDateMySQL($date){
		// 1. check empty
		$date = trim($date);
		if (empty($date))
			return false;
		
		// 2. check length
		if (strlen($date) < 8){
			return false;
		}
		// 3. check num index
		$pieces = explode('-', $date);
		if (count($pieces) != 3)
			return false;
		
		$day = $pieces[2];
		$month = $pieces[1];
		$year = $pieces[0];
		
		// 4. check data type
		if (!is_numeric($month) || !is_numeric($day) || !is_numeric($year))
			return false;
		
		// 5. check date value
		if (!checkdate($month, $day, $year))
			return false;
		
		// valid beneran gitu lohh....
		return true;
	}
}

/* End of file html_helper.php */
/* Location: ./system/helpers/html_helper.php */
