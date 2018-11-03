<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class User extends CI_Controller {


	public function __construct() {

        parent::__construct();

        // load the library
        $this->load->library('layout');
    }


	public function pre($element) {

		echo '<pre>';
			print_r($element);
		echo '</pre>';
	}




	public function config() {
		$this->authorisation();
		$this->load->helper('form');
		$this->load->view('config');
		   
		
	}

	public function access_denied() {
		$message = 'Access Denied';
		show_error($message, '403', $heading = '403 Access is prohibited');
		return false;
	}


	public function hash($data) {
		return md5($data);
	}




	public function db_value($value = NULL) {

		$this->load->helper('form');

		if(is_null($value)){
			return "NULL";
		}

		if($value != ''){
			return "'".$value."'";
		} else {
			return "NULL";
		}
	}

	 /**
	 * Check authorisation
     * @param null $controller
     * @param null $page
     * @param string $type
     * @return bool
	 * Passive mode $type = '1' for links // return bool
	 * Active mode $type = '2'

	*/
    public function authorisation($controller = NULL, $page = NULL, $type = '2') {
		
		$this->load->library('session');
		$this->load->helper('url');
		$user_id = $this->session->user_id;
		
		
		
		if (is_null($controller)) {
			$controller = $this->router->fetch_class();
		}
		
		if (is_null($page)) {
			$page = $this->router->fetch_method();
		}
		
		if(!$this->session->username) {
        	redirect('admin/login', 'location');
        	$this->session->sess_destroy();
        }
		

        $sql = "SELECT 
					`permission`.`id`,
				    `permission`.`controller`,
					`permission`.`page`,
					`permission`.`status`
				FROM 
					`permission`
				LEFT JOIN `role_permission` ON `role_permission`.`permission_id` = `permission`.`id`	
				LEFT JOIN `role` ON `role_permission`.`role_id` = `role`.`id`
				LEFT JOIN `user` ON `user`.`role_id` = `role`.`id`
				WHERE `user`.`id` = '".$user_id."' AND `permission`.`status` = '1' AND `controller` = '".$controller."' AND `page` = '".$page."'
		";

        $query = $this->db->query($sql);
		
		if($query->num_rows() != 1) {
			if ($type == '1') {
				return false;
			} elseif ($type == '2') {
				redirect('admin/access_denied', 'location');
				return false;
			}
		}


        

       
		
		return true;
	}


	public function index() {

		//$this->authorisation();
		$this->load->helper('url');
        $this->load->helper('form');
        $this->load->library('session');
        $array = array();
        

  
        $this->layout->view('dashboard', $array);
        
        
	}

	public function login() {

		$this->load->library('session');
		$this->load->helper('url');
        $this->load->helper('form');
		$data[] = array();

		$username = $this->input->post('name');
		$pass = $this->input->post('password');
		$password = $this->hash($this->input->post('password'));

		$sql = "SELECT 
					`user`.`id`,
					`user`.`username`,
					`user`.`password`,
					`user`.`role_id`,
					`user`.`status`
				FROM 
					`user`				
				WHERE (`username` = '".$username."' 
					OR `email` = '".$username."')
				LIMIT 1
				";

		$query = $this->db->query($sql);

		$account = $query->row_array();	
		$num = $query->num_rows();

		$data['username'] = $username;
		$data['password'] = $pass;

		$sql_per = "SELECT 
					`permission`.`id`,
					`permission`.`controller`,
					`permission`.`page`,
					`permission`.`status`
				FROM 
					`role_permission`
				LEFT JOIN `role` ON  `role_permission`.`role_id` = `role`.`id` 			
				LEFT JOIN `permission` ON  `role_permission`.`permission_id` = `permission`.`id` 			
				WHERE `role`.`id` = '".$account['role_id']."'
		";
		$query_per = $this->db->query($sql_per);

		$permission = $query_per->result_array();
		$per = array();
		foreach($permission as $row_per) {
			$per['controller'][] = $row_per['controller'];	
			$per['page'][] = $row_per['page'];	
		}

		

		if($username != '') {

			if ($username != $account['username'] or $password != $account['password']) {

				$data['error'] = 'You were not logged in because you entered an invalid username/password combination';
				$this->load->view('login/login', $data);
				return false;
			}
		}

		if($num == 1) {

			if (!isset($account['username']) or !isset($account['password']) or $account['username'] != $username or $account['password'] != $password) {
				 $data['error'] = 'You were not logged in because you entered an invalid username/password combination';
				 $this->load->view('login/login', $data);
				 return false;
			}

			if($account['status'] == -2) {
				 $data['error'] = 'Your account suspended';
				 $this->load->view('login/login', $data);
				 return false;

			}
		
			if($account['status'] == -1) {
				$data['error'] = 'Your account is not active';
				$this->load->view('login/login', $data);
				return false;
			}

			

			$sess = array(
				'user_id' => $account['id'],
	        	'username'  => $account['username'],
	        	'password'  => $account['password']
			);

		
			$session = array_merge($sess, $per);

			
			$this->session->set_userdata($session);
			redirect('admin/', 'location');

		} else {
			$data['error'] = '';
			$this->load->view('login/login', $data);
		}
		

		
	}

    /**
     * @return bool
     */
    public function logout() {

		$this->load->library('session');
		$this->session->sess_destroy();
		redirect('admin/login', 'location');
	
		return true;
	}


}
//end of class