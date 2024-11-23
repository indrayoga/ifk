<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Rumahsakit extends CI_Controller {

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

		$this->load->model('master/mmaster');
		//$x=$this->muser->isAkses($this->akses2);
		//debugvar($x);
	}

	public function view_tutupshift($data){
		$this->load->view('tutupshift',$data);
	}

	public function view_restricted($data){
		$this->load->view('restricted',$data);
	}

	public function view_gantipassword($data){
		$this->load->view('gantipassword',$data);
	}

	public function tutupshift(){
		
	}

	public function updateshift(){
		$shiftselanjutnya=$this->input->post('shiftselanjutnya');
		$unit=$this->input->post('unit');
		$data=array(
			'shift'=>$shiftselanjutnya,
			'tgl_update'=>date('Y-m-d h:i:s')
			);
		$this->mmaster->update('unit_shift',$data,'kd_unit="'.$unit.'" ');
		redirect('/home/');
	}

	public function gantipassword(){
		$id_user=$this->input->post('id_user');
		$username=$this->input->post('username');
		$password=$this->input->post('password');
		$data=array(
			'username'=>$username,
			'password'=>md5($password)
			);
		$this->mmaster->update('user',$data,'id_user="'.$id_user.'" ');
		redirect('/home/');
	}

	protected function getJsFiles() {

	}

	protected function getCssFiles() {
		
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
