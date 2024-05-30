<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class HomeController extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		
		$this->load->library('ion_auth');

		// if (!$this->ion_auth->logged_in()) {
		// 	$this->session->set_flashdata('message_warning', 'You must be logged in to access this page');
		// 	redirect('auth', 'refresh');
		// }
	}

	public function index()
	{
		$this->data = [];
		$this->data['title'] = 'Survei IKK';

		return view('home/index', $this->data);
	}

	public function survei_saat_ini()
	{
		$this->data = [];
		$this->data['title'] = 'Survei Berlangsung Saat Ini';

		$this->data['data_survei'] = $this->db->query("
			SELECT * 
			FROM manage_survey
			JOIN users ON users.id = manage_survey.id_user
			");

		return view('home/survei_berlangsung', $this->data);
	}

	public function about()
	{
		$this->data = [];
		$this->data['title'] = 'About';

		return view('home/about', $this->data);
	}

	public function team()
	{
		$this->data = [];
		$this->data['title'] = 'Team';

		return view('home/team', $this->data);
	}

	public function contact()
	{
		$this->data = [];
		$this->data['title'] = 'Contact';

		return view('home/contact', $this->data);
	}

	public function privacy()
	{
		$this->data = [];
		$this->data['title'] = 'Privacy';

		return view('home/privacy', $this->data);
	}

	public function legal()
	{
		$this->data = [];
		$this->data['title'] = 'Legal';

		return view('home/legal', $this->data);
	}

}

/* End of file HomeController.php */
/* Location: ./application/controllers/HomeController.php */