<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Sysadmin extends CI_Controller {


    /**
     * sysadmin constructor.
     */
    public function __construct() {

        parent::__construct();

        // load the library
        $this->load->library('layout');
        // load the helper
        $this->load->helper('url');

    }



    /**
	 * Valid URL
	 *
	 * @param	string	$str
	 * @return	bool
	 */
	public function valid_url($str) {

		if (filter_var($str, FILTER_VALIDATE_URL)) {
		    return true;
		} else {
		    return false;
		}
	}

    /**
     * @param $element
     */
    private function pre($element) {

		echo '<pre>';
			print_r($element);
		echo '</pre>';
	}

	 /**
	 * Return unical name without extension. 
	 * Ex: 45f7fd76
	 *
	 * @access public
	 * @return string
	 */
	private function uname() {
		
	 	return substr(md5(time() . rand()), 3, 8);
	 	
	} // End func uname


    /**
     * @return string
     */
    private function default_lng() {
		return 'hy';
	}

    /**
     * @return array
     */
    // TODO MULTI LANGUAGE MOD
    private function languages() {
		return array('hy', 'ru', 'en');
	}



	


    /**
     * @return mixed
     */
    private function upload_config() {

        
        $config['allowed_types']        = 'gif|jpg|png';
        $config['max_size'] 			= '4097152'; //4 MB
        $config['file_name']			= $this->uname();
        $config['max_width']            = '2048';
        $config['max_height']           = '1200';

        $this->load->library('upload', $config);	

        $this->upload->initialize($config);

        return $config;

    }



    /**
     * @param $url
     * @return bool
     */
    private function youtube_id_from_url($url) {

        $result = preg_match('%^# Match any youtube URL
			(?:https?://)?  # Optional scheme. Either http or https
			(?:www\.)?      # Optional www subdomain
			(?:             # Group host alternatives
			  youtu\.be/    # Either youtu.be,
			| youtube\.com  # or youtube.com
			  (?:           # Group path alternatives
				/embed/     # Either /embed/
			  | /v/         # or /v/
			  | /watch\?v=  # or /watch\?v=
			  )             # End path alternatives.
			)               # End host alternatives.
			([\w-]{10,12})  # Allow 10-12 for 11 char youtube id.
			$%x', $url, $matches);

        if (!isset($matches[1])) {
            return false;
        }

        if ($result) {
            return $matches[1];
        }

        return false;
    }

    /**
     * @return mixed
     */
    public function pagination_config() {
		//pagination config
		$config['use_page_numbers'] = TRUE;
		$config['per_page'] = 20;
		$config['full_tag_open'] = '<div class="pgn">';
		$config['full_tag_close'] = '</div>';
        $config['next_link'] = '&gt;';
        $config['next_tag_open'] = '<span class="pg_n">';
        $config['next_tag_close'] = '</span>';
        $config['prev_link'] = '&lt;';
        $config['prev_tag_open'] = '<span class="pg_s">';
        $config['prev_tag_close'] = '</span>';
        $config['cur_tag_open'] = '<span class="pg_s">';
		$config['cur_tag_close'] = '</span>';
		$config['num_tag_open'] = '<span class="pg_s">';
		$config['num_tag_close'] = '</span>';

		return $config;
	}



    public function config() {
		$this->authorisation();
		$this->load->helper('form');
		$this->layout->view('config');
		   
		
	}

    /**
     * @return bool
     */
    public function access_denied() {
		$message = 'Մուտքը արգելված է';
		show_error($message, '403', $heading = '403');
		return false;
	}


    /**
     * @param $data
     * @return string
     */
    public function hash($data) {
		return md5($data);
	}


    /**
     * @param null $value
     * @return string
     */
    public function db_value($value = NULL) {

		$this->load->helper('form');

		$value = str_replace("'", "\'", $value);

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
	 * @passive mode $type = '1' for links // return bool
	 * @active mode $type = '2'

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

	public function sidebar() {
		$this->authorisation();
		$this->load->view('sidebar/sidebar');
	}


	public function add_user() {

		$this->authorisation();
        $this->load->helper('url');
        $this->load->helper('form');
        $data = array();

        $sql_role = "SELECT `id`, `title` FROM `role` WHERE `status` = '1'";

        $query = $this->db->query($sql_role);
        $result_role = $query->result_array();
        $data['result_role'] = $result_role;

        $this->layout->view('user/add_user', $data, 'add');

    }

	public function add_user_ax() {

		$messages = array('success' => '0', 'message' => '', 'error' => '', 'fields' => '');
		$n = 0;

		if ($this->input->server('REQUEST_METHOD') != 'POST') {
            // Return error
            $messages['error'] = 'error_message';
            $this->access_denied();
            return false;
        }


         $this->load->library('form_validation');
        // $this->config->set_item('language', 'armenian');
         $this->form_validation->set_error_delimiters('<div>', '</div>');
    	 $this->form_validation->set_rules('username', 'Username', 'required');
    	 $this->form_validation->set_rules('first_name', 'First name', 'required');
    	 $this->form_validation->set_rules('role', 'Role', 'required');
    	 $this->form_validation->set_rules('password','Password','required|min_length[6]');
    	 $this->form_validation->set_rules('email','Email','valid_email');


    
		if($this->form_validation->run() == false){
			//validation errors
			$n = 1;

			$validation_errors = array(
			                            'username' => form_error('username'),
                                        'first_name' => form_error('first_name'),
                                        'role' => form_error('role'),
                                        'password' => form_error('password'),
                                        'email' => form_error('email')
            );
		    $messages['error']['elements'][] = $validation_errors;
		}



        $password = $this->hash($this->input->post('password'));
        $role = $this->input->post('role');
        $email = $this->input->post('email');
        $first_name = $this->input->post('first_name');
        $last_name = $this->input->post('last_name');
        $username = $this->input->post('username');
        $status = $this->input->post('status');

        $sql_unique = "SELECT `username` FROM `user` WHERE `username` = '".$username."'";

		$query = $this->db->query($sql_unique);
		$num_rows = $query->num_rows();
		

		if($num_rows > '0') {
			$n = 1;
			$validation_errors = array('username' => "Username is not unique");
		    $messages['error']['elements'][] = $validation_errors;
		}

		if($n == 1) {
			echo json_encode($messages);
		    return false;
		}


		$sql = "INSERT INTO `user`
					SET 
					 `role_id` = ".$this->db_value($role).",
					 `username` = ".$this->db_value($username).",
					 `first_name` = ".$this->db_value($first_name).",
					 `last_name` = ".$this->db_value($last_name).",
					 `email` = ".$this->db_value($email).",
					 `password` = ".$this->db_value($password).",
					 `status` = ".$this->db_value($status)."";


		$result = $this->db->query($sql);

		if ($result){
            $messages['success'] = 1;
            $messages['message'] = 'Success';
        } else {
            $messages['success'] = 0;
            $messages['error'] = 'Error';
        }

        // Return success or error message
        echo json_encode($messages);
        return true;
	}

	public function user() {

		$this->authorisation();
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->library('pagination');


        $data = array();
        $add_sql = '';
        $data['url_array'] = array('id' => '', 'role' => '', 'name' => '', 'username' => '', 'status' => '');



        // Filters

        $sql_role = "SELECT `id`, `title` FROM `role` WHERE `status` = '1'";

        $query = $this->db->query($sql_role);
        $result_role = $query->result_array();
        $data['result_role'] = $result_role;
		
		// ID
		if ($this->input->get('id') or $this->input->post('id')) {
			if ($this->input->get('id')) {
				$id = $this->input->get('id');
			} else {
				$id = $this->input->post('id');
			}
			$add_sql.= " AND `user`.`id` = '".$id."'";
			$data['url_array'] = array_merge($data['url_array'], array('id'=>$id));
		}

		// Is admin
		if ($this->input->get('role') or $this->input->post('role')) {
			if ($this->input->get('role')) {
				$role = $this->input->get('role');
			} else {
				$role = $this->input->post('role');
			}
			$add_sql.= " AND `user`.`role_id` = '".$role."'";
			$data['url_array'] = array_merge($data['url_array'], array('role'=>$role));
		}

		// Username
		if ($this->input->get('username') or $this->input->post('username')) {
			if ($this->input->get('username')) {
				$username = $this->input->get('username');
			} else {
				$username = $this->input->post('username');
			}
			$add_sql.= " AND `user`.`username` LIKE '%".$username."%'";
			$data['url_array'] = array_merge($data['url_array'], array('username'=>$username));
		}

        // Name
        if ($this->input->get('name') or $this->input->post('name')) {
            if ($this->input->get('name')) {
                $name = $this->input->get('name');
            } else {
                $name = $this->input->post('name');
            }
            $arr = explode(' ', preg_replace('/ {2,}/', ' ', $name));
            foreach($arr AS $value){
                $add_sql.= " `first_name` LIKE '%".$value."%' OR `last_name` LIKE '%".$value."%' OR ";
            }

            $add_sql = "AND (".substr($add_sql, 0, -3).")";
            $data['url_array'] = array_merge($data['url_array'], array('name'=>$name));
        }

		// Status
		if ($this->input->get('status') or $this->input->post('status')) {
			if ($this->input->get('status')) {
				$status = $this->input->get('status');
			} else {
				$status = $this->input->post('status');
			}
			$add_sql.= " AND `user`.`status` = '".$status."'";
			$data['url_array'] = array_merge($data['url_array'], array('status'=>$status));
		}


		// Ordering

		if ($this->input->get('by_id')) {
			if ($this->input->get('by_id') == 1) {
				$order = " ORDER BY `user`.`id` ";
				$val = 1;
			} else {
				$order = " ORDER BY `user`.`id` DESC ";
				$val = 2;
			}
			$data['url_array'] = array_merge($data['url_array'], array('by_id'=>$val));
			
		} elseif($this->input->get('by_role')) {
			if ($this->input->get('by_role') == 1) {
				$order = " ORDER BY `user`.`role_id` ";
				$val = 1;
			} else {
				$order = " ORDER BY `user`.`role_id` DESC ";
				$val = 2;
			}
			$data['url_array'] = array_merge($data['url_array'], array('by_role'=>$val));

		} elseif($this->input->get('by_username')) {
			if ($this->input->get('by_username') == 1) {
				$order = " ORDER BY `user`.`username` ";
				$val = 1;
			} else {
				$order = " ORDER BY `user`.`username` DESC ";
				$val = 2;
			}
			$data['url_array'] = array_merge($data['url_array'], array('by_username'=>$val));

		} elseif($this->input->get('by_name')) {
			if ($this->input->get('by_name') == 1) {
				$order = " ORDER BY `user`.`first_name` ";
				$val = 1;
			} else {
				$order = " ORDER BY  `user`.`first_name` DESC ";
				$val = 2;
			}
			$data['url_array'] = array_merge($data['url_array'], array('by_password'=>$val));

		} elseif($this->input->get('by_status')) {
			if ($this->input->get('by_status') == 1) {
				$order = " ORDER BY `user`.`status` ";
				$val = 1;
			} else {
				$order = " ORDER BY `user`.`status` DESC ";
				$val = 2;
			}
			$data['url_array'] = array_merge($data['url_array'], array('by_status'=>$val));

		} else {
			$order = "ORDER BY `user`.`id` DESC";
		}

        $start =  $this->uri->segment(3);

        if (!is_numeric($start) or !$start) {
            $start = 1;
        }
        $config['per_page'] = 20;
        $page_content_count = $config['per_page'];
        $page_start = ($start - 1)*$page_content_count;


       $sql = "SELECT
				  `user`.`id`,
				  `role`.`title`,
				  `user`.`username`,
				  CONCAT_WS(' ', `user`.`first_name`, `user`.`last_name`) AS `user_name`,
				  `user`.`status`
				FROM 
					`user`
				LEFT JOIN `role` ON `role`.`id` = `user`.`role_id`
				WHERE 1 
				".$add_sql." 
				".$order."
				LIMIT ".$page_start.", ".$page_content_count."  
				
		";

		$query = $this->db->query($sql);
        $num_rows = $query->num_rows();
        $result = $query->result_array();
        $data['result'] = $result;
        $data['num_rows'] = $num_rows;

        $sql_all = "SELECT
				  `id`
				FROM 
					`user`
				WHERE 1 
				".$add_sql."
				
				
		";

        $query_all = $this->db->query($sql_all);
        $num_rows_all = $query_all->num_rows();


        $config['base_url'] = base_url().'sysadmin/user/';
        $config['total_rows'] = $num_rows_all;


        $this->pagination->initialize($config);



		
		//$this->load->view('user/user', $data);
		$this->layout->view('user/user', $data);
	}


	public function edit_user($id=NULL) {

		$this->authorisation();
        $this->load->helper('url');
        $this->load->helper('form');
		$id = $this->uri->segment(4);
		$data = array();

		if($id == NULL) {
			$message = 'Undifined ID';
			show_error($message, '404', $heading = '404 Page Not Found');
			return false;
		}

        $sql_role = "SELECT `id`, `title` FROM `role` WHERE `status` = '1'";

        $query = $this->db->query($sql_role);
        $result_role = $query->result_array();
        $data['result_role'] = $result_role;

		$sql = "SELECT
				  `id`,
				  `username`,
				  `first_name`,
				  `last_name`,
				  `email`,
				  `role_id`,
				  `status`
				FROM `user`
				WHERE `id` = '".$id."'";

		$query = $this->db->query($sql);
		$row = $query->row_array();	
		
		if(!is_array($row)) {
			$message = 'Undifined ID';
			show_error($message, '404', $heading = '404 Page Not Found');
			return false;
		}

		$data['id'] = $row['id'];
		$data['username'] = $row['username'];
		$data['first_name'] = $row['first_name'];
		$data['last_name'] = $row['last_name'];
		$data['email'] = $row['email'];
		$data['role_id'] = $row['role_id'];
		$data['status'] = $row['status'];

		$this->layout->view('user/edit_user', $data, 'edit');
	}


	public function edit_user_ax() {

		$messages = array('success' => '0', 'message' => '', 'error' => '');
		$n = 0;

		if ($this->input->server('REQUEST_METHOD') != 'POST') {
            // Return error
            $messages['error'] = 'error_message';
            $this->access_denied();
            return false;
        }


        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div>', '</div>');
    	$this->form_validation->set_rules('username', 'Username', 'required');
    	$this->form_validation->set_rules('first_name', 'First name', 'required');
    	$this->form_validation->set_rules('role', 'Role', 'required');
    	$this->form_validation->set_rules('email','Email','valid_email');


    
		if($this->form_validation->run() == false){
			//validation errors
			$n = 1;

			$validation_errors = array(
				'username' => form_error('username'), 
				'first_name' => form_error('first_name'), 
				'role' => form_error('role'), 
				'email' => form_error('email')
			);
		    $messages['error']['elements'][] = $validation_errors;
		}

		$id = $this->input->post('id');
		$username = $this->input->post('username');
		$first_name = $this->input->post('first_name');
		$last_name = $this->input->post('last_name');
        $email = $this->input->post('email');
        $role = $this->input->post('role');
        $status = $this->input->post('status');



		$sql_unic = "SELECT `username` FROM `user` WHERE `username` = '".$username."' AND `id` <> '".$id."'";

		$query = $this->db->query($sql_unic);
		$num_rows = $query->num_rows();
		

		if($num_rows > '0') {
			$n = 1;
			$validation_errors = array('username' => "Username is not unicue");
		    $messages['error']['elements'][] = $validation_errors;
		}


		if($n == 1) {
			echo json_encode($messages);
		    return false;
		}

        
        $sql = "UPDATE `user`
					SET 
					 `role_id` = ".$this->db_value($role).",
					 `username` = ".$this->db_value($username).",
					 `first_name` = ".$this->db_value($first_name).",
					 `last_name` = ".$this->db_value($last_name).",
					 `email` = ".$this->db_value($email).",
					 `status` = ".$this->db_value($status)."
				WHERE `id` = ".$this->db_value($id)."";


		$result = $this->db->query($sql);


		if ($result){
            $messages['success'] = 1;
            $messages['message'] = 'Success';
        } else {
            $messages['success'] = 0;
            $messages['error'] = 'Error';
        }

        // Return success or error message
        echo json_encode($messages);
        return true;

	}

	// Add permission
	public function add_permission() {

		$this->authorisation();
        $this->load->helper('url');
        $this->load->helper('form');

		$this->layout->view('permission/add_permission', '', 'add');

	}

	// Add permission ajax
	public function add_permission_ax() {

		$messages = array('success' => '0', 'message' => '', 'error' => '', 'fields' => '');

		if ($this->input->server('REQUEST_METHOD') != 'POST') {
            // Return error
            $messages['error'] = 'error_message';
            $this->access_denied();
            return false;
        }

        $n = 0;
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div>', '</div>');
    	$this->form_validation->set_rules('title', 'Title', 'required');
    	$this->form_validation->set_rules('controller', 'Controller', 'required');
    	$this->form_validation->set_rules('page', 'Page', 'required');
    

    
		if($this->form_validation->run() == false){
			//validation errors
			$n = 1;
			$validation_errors = array('title' => form_error('title'), 'controller' => form_error('controller'), 'page' => form_error('page'));
		    $messages['error']['elements'][] = $validation_errors;

		}



        $title = $this->input->post('title');
        $controller = $this->input->post('controller');
        $page = $this->input->post('page');
        $status = $this->input->post('status');


        $sql_unic_c_p = "SELECT `title` FROM `permission` WHERE `controller` = '".$controller."' AND `page` = '".$page."'  AND `status` = '1'";

		$query = $this->db->query($sql_unic_c_p);
		$num_rows_c_p = $query->num_rows();
		

		if($num_rows_c_p > '0') {
			$n = 1;
			$validation_errors = array('page' => "Page is not unicue");
		    $messages['error']['elements'][] = $validation_errors;
		}

		if($n == 1) {
			echo json_encode($messages);
		    return false;
		}


        

		
		$sql = "INSERT INTO `permission`
					SET 
					 `title` = ".$this->db_value($title).",
					 `controller` = ".$this->db_value($controller).",
					 `page` = ".$this->db_value($page).",
					 `status` = ".$this->db_value($status)."";


		$result = $this->db->query($sql);

		if ($result){
            $messages['success'] = 1;
            $messages['message'] = 'Success';
        } else {
            $messages['success'] = 0;
            $messages['error'] = 'Error';
        }

        // Return success or error message
        echo json_encode($messages);
        return true;
	}


	public function permission() {

		$this->authorisation();
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->library('pagination');
		



        $data = array();
        $add_sql = '';
        $data['url_array'] = array('id' => '', 'title' => '', 'controller' => '', 'page' => '', 'status' => '');



        // Filters
		
		// ID
		if ($this->input->get('id') or $this->input->post('id')) {
			if ($this->input->get('id')) {
				$id = $this->input->get('id');
			} else {
				$id = $this->input->post('id');
			}
			$add_sql.= " AND `permission`.`id` = '".$id."'";
			$data['url_array'] = array_merge($data['url_array'], array('id'=>$id));
		}


		// title
		if ($this->input->get('title') or $this->input->post('title')) {
			if ($this->input->get('title')) {
				$title = $this->input->get('title');
			} else {
				$title = $this->input->post('title');
			}
			$add_sql.= " AND `permission`.`title` LIKE '%".$title."%'";
			$data['url_array'] = array_merge($data['url_array'], array('title'=>$title));
		}

		// Controller
		if ($this->input->get('controller') or $this->input->post('controller')) {
			if ($this->input->get('controller')) {
				$controller = $this->input->get('controller');
			} else {
				$controller = $this->input->post('controller');
			}
			$add_sql.= " AND `permission`.`controller` = '".$controller."'";
			$data['url_array'] = array_merge($data['url_array'], array('controller'=>$controller));
		}


		// Page
		if ($this->input->get('page') or $this->input->post('page')) {
			if ($this->input->get('page')) {
				$page = $this->input->get('page');
			} else {
				$page = $this->input->post('page');
			}
			$add_sql.= " AND `permission`.`page` = '".$page."'";
			$data['url_array'] = array_merge($data['url_array'], array('page'=>$page));
		}

        

		// Status
		if ($this->input->get('status') or $this->input->post('status')) {
			if ($this->input->get('status')) {
				$status = $this->input->get('status');
			} else {
				$status = $this->input->post('status');
			}
			$add_sql.= " AND `permission`.`status` = '".$status."'";
			$data['url_array'] = array_merge($data['url_array'], array('status'=>$status));
		}


		// Ordering

		if ($this->input->get('by_id')) {
			if ($this->input->get('by_id') == 1) {
				$order = " ORDER BY `permission`.`id` ";
				$val = 1;
			} else {
				$order = " ORDER BY `permission`.`id` DESC ";
				$val = 2;
			}
			$data['url_array'] = array_merge($data['url_array'], array('by_id'=>$val));
			
		} elseif($this->input->get('by_title')) {
			if ($this->input->get('by_title') == 1) {
				$order = " ORDER BY `permission`.`title` ";
				$val = 1;
			} else {
				$order = " ORDER BY `permission`.`title` DESC ";
				$val = 2;
			}
			$data['url_array'] = array_merge($data['url_array'], array('by_title'=>$val));

		} elseif($this->input->get('by_controller')) {
			if ($this->input->get('by_controller') == 1) {
				$order = " ORDER BY `permission`.`controller` ";
				$val = 1;
			} else {
				$order = " ORDER BY `permission`.`controller` DESC ";
				$val = 2;
			}
			$data['url_array'] = array_merge($data['url_array'], array('by_controller'=>$val));

		} elseif($this->input->get('by_page')) {
			if ($this->input->get('by_page') == 1) {
				$order = " ORDER BY `permission`.`page` ";
				$val = 1;
			} else {
				$order = " ORDER BY  `permission`.`page` DESC ";
				$val = 2;
			}
			$data['url_array'] = array_merge($data['url_array'], array('by_page'=>$val));

		} elseif($this->input->get('by_status')) {
			if ($this->input->get('by_status') == 1) {
				$order = " ORDER BY `permission`.`status` ";
				$val = 1;
			} else {
				$order = " ORDER BY `permission`.`status` DESC ";
				$val = 2;
			}
			$data['url_array'] = array_merge($data['url_array'], array('by_status'=>$val));

		} else {
			$order = "ORDER BY `permission`.`id` DESC";
		}

		//pagination start

        $start =  $this->uri->segment(4);

        if (!is_numeric($start) or !$start) {
            $start = 1;
        }
       

       	$config = $this->pagination_config();
        $page_content_count = $config['per_page'];
        $page_start = ($start - 1)*$page_content_count;


       $sql = "SELECT
				  `permission`.`id`,
				  `permission`.`title`,
				  `permission`.`controller`,
				  `permission`.`page`,
				  `permission`.`status`
				FROM 
					`permission`
				WHERE 1 
				".$add_sql." 
				".$order."
				LIMIT ".$page_start.", ".$page_content_count."  
				
		";

		$query = $this->db->query($sql);
        $num_rows = $query->num_rows();
        $result = $query->result_array();
        $data['result'] = $result;
        $data['num_rows'] = $num_rows;

        $sql_all = "SELECT
				  `id`
				FROM 
					`permission`
				WHERE 1 
				".$add_sql."
				
				
		";

        $query_all = $this->db->query($sql_all);
        $num_rows_all = $query_all->num_rows();


        $config['base_url'] = base_url().'admin/sysadmin/permission/';
        $config['total_rows'] = $num_rows_all;
		$config["uri_segment"] = 4;


        $this->pagination->initialize($config);

		
		$this->layout->view('permission/permission', $data);
	
	}




	public function edit_permission($id=NULL) {

		$this->authorisation();
        $this->load->helper('url');
        $this->load->helper('form');
		$id = $this->uri->segment(4);
		$data = array();

		if($id == NULL) {
			$message = 'Undifined ID';
			show_error($message, '404', $heading = '404 Page Not Found');
			return false;
		}

		$sql = "SELECT
				  `permission`.`id`,
				  `permission`.`title`,
				  `permission`.`controller`,
				  `permission`.`page`,
				  `permission`.`status`
				FROM 
					`permission`
				WHERE `id` = '".$id."'";

		$query = $this->db->query($sql);
		$row = $query->row_array();	
		
		if(!is_array($row)) {
			$message = 'Undifined ID';
			show_error($message, '404', $heading = '404 Page Not Found');
			return false;
		}

		$data['id'] = $row['id'];
		$data['title'] = $row['title'];
		$data['controller'] = $row['controller'];
		$data['page'] = $row['page'];
		$data['status'] = $row['status'];

		$this->layout->view('permission/edit_permission', $data, 'edit');
	}


	public function edit_permission_ax() {

		$messages = array('success' => '0', 'message' => '', 'error' => '');
		$n = 0;

		if ($this->input->server('REQUEST_METHOD') != 'POST') {
            // Return error
            $messages['error'] = 'error_message';
            $this->access_denied();
            return false;
        }


        $n = 0;
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div>', '</div>');
    	$this->form_validation->set_rules('title', 'Title', 'required');
    	$this->form_validation->set_rules('controller', 'Controller', 'required');
    	$this->form_validation->set_rules('page', 'Page', 'required');
    

    
		if($this->form_validation->run() == false){
			//validation errors
			$n = 1;
			$validation_errors = array('title' => form_error('title'), 'controller' => form_error('controller'), 'page' => form_error('page'));
		    $messages['error']['elements'][] = $validation_errors;

		}


  		$id = $this->input->post('id');
        $title = $this->input->post('title');
        $controller = $this->input->post('controller');
        $page = $this->input->post('page');
        $status = $this->input->post('status');


        $sql_unic_c_p = "SELECT `title` FROM `permission` WHERE `controller` = '".$controller."' AND `page` = '".$page."' AND `id` <> '".$id."' AND `status` = '1'";

		$query = $this->db->query($sql_unic_c_p);
		$num_rows_c_p = $query->num_rows();
		

		if($num_rows_c_p > '0') {
			$n = 1;
			$validation_errors = array('page' => "Page is not unicue");
		    $messages['error']['elements'][] = $validation_errors;
		}

		if($n == 1) {
			echo json_encode($messages);
		    return false;
		}


        

		
		$sql = "UPDATE `permission`
					SET 
					 `title` = ".$this->db_value($title).",
					 `controller` = ".$this->db_value($controller).",
					 `page` = ".$this->db_value($page).",
					 `status` = ".$this->db_value($status)."
				WHERE `id` = ".$this->db_value($id)."";

		$result = $this->db->query($sql);
				


		if ($result){
            $messages['success'] = 1;
            $messages['message'] = 'Success';
        } else {
            $messages['success'] = 0;
            $messages['error'] = 'Error';
        }


        // Return success or error message
        echo json_encode($messages);
        return true;

	}

	public function copy_permission() {
		$this->edit_permission();
	}

	public function copy_permission_ax() {
		$this->add_permission_ax();
	}


	public function add_role() {

		$this->authorisation();
        $this->load->helper('url');
        $this->load->helper('form');

        $sql_per = "SELECT `id`, `title` FROM `permission` WHERE `status` = '1' ORDER BY `title` DESC ";

        $query = $this->db->query($sql_per);
        $result_per = $query->result_array();
        $data['result_permission'] = $result_per;

		$this->layout->view('role/add_role', $data, 'add');

	}

	public function add_role_ax() {

		$messages = array('success' => '0', 'message' => '', 'error' => '', 'fields' => '');

		if ($this->input->server('REQUEST_METHOD') != 'POST') {
            // Return error
            $messages['error'] = 'error_message';
            $this->access_denied();
            return false;
        }

   

        $n = 0;
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div>', '</div>');
    	$this->form_validation->set_rules('title', 'Title', 'required');
    	//$this->form_validation->set_rules('permission', 'Permission', 'required');
    

    
		if($this->form_validation->run() == false){
			//validation errors
			$n = 1;
			$validation_errors = array(
				'title' => form_error('title'),
			   //'permission' => form_error('permission')
		    );
		    $messages['error']['elements'][] = $validation_errors;

		}


		if($n == 1) {
			echo json_encode($messages);
		    return false;
		}

		    




        $title = $this->input->post('title');
        $permission_array = $this->input->post('permission');
        $status = $this->input->post('status');

		
		$sql = "INSERT INTO `role`
					SET 
					 `title` = ".$this->db_value($title).",
					 `status` = ".$this->db_value($status)."";


		$result = $this->db->query($sql);

		if ($result){
            $role_id = $this->db->insert_id();
        } else {
            $messages['success'] = 0;
            $messages['error'] = 'Error';
        }
		

		$sql_p_r = "INSERT INTO `role_permission` (
					  `role_id`,
					  `permission_id`,
					  `status`
					) 
					VALUES";

		foreach ($permission_array as  $permission_id) {
				$sql_p_r .= "(
					".$this->db_value($role_id).",
					".$this->db_value($permission_id).",
					'1'
				),";		
		}

		$sql_p_r = substr($sql_p_r, 0, -1);

		$result_p_r = $this->db->query($sql_p_r);

		if ($result_p_r){
            $messages['success'] = 1;
            $messages['message'] = 'Success';
        } else {
            $messages['success'] = 0;
            $messages['error'] = 'Error';
        }

        // Return success or error message
        echo json_encode($messages);
        return true;
	}



	public function role() {

		$this->authorisation();
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->library('pagination');
		



        $data = array();
        $add_sql = '';
        $data['url_array'] = array('id' => '', 'title' => '', 'permission' => '', 'status' => '');



        // Filters


        $sql_pm ="SELECT 
				`id`,
				`title` 
				FROM
				  `permission` 
				WHERE `status` = 1 
				ORDER BY `title`";

		$query = $this->db->query($sql_pm);
        $result_pm = $query->result_array();
        $data['result_pm'] = $result_pm;
		
		// ID
		if ($this->input->get('id') or $this->input->post('id')) {
			if ($this->input->get('id')) {
				$id = $this->input->get('id');
			} else {
				$id = $this->input->post('id');
			}
			$add_sql.= " AND `role`.`id` = '".$id."'";
			$data['url_array'] = array_merge($data['url_array'], array('id'=>$id));
		}


		// title
		if ($this->input->get('title') or $this->input->post('title')) {
			if ($this->input->get('title')) {
				$title = $this->input->get('title');
			} else {
				$title = $this->input->post('title');
			}
			$add_sql.= " AND `role`.`title` LIKE '%".$title."%'";
			$data['url_array'] = array_merge($data['url_array'], array('title'=>$title));
		}

		// Permission
		if ($this->input->get('permission') or $this->input->post('permission')) {
			if ($this->input->get('permission')) {
				$permission = $this->input->get('permission');
			} else {
				$permission = $this->input->post('permission');
			}
			$add_sql.= " AND `role_permission`.`permission_id` = '".$permission."'";
			$data['url_array'] = array_merge($data['url_array'], array('permission'=>$permission));
		}

        

		// Status
		if ($this->input->get('status') or $this->input->post('status')) {
			if ($this->input->get('status')) {
				$status = $this->input->get('status');
			} else {
				$status = $this->input->post('status');
			}
			$add_sql.= " AND `role`.`status` = '".$status."'";
			$data['url_array'] = array_merge($data['url_array'], array('status'=>$status));
		}


		// Ordering

		if ($this->input->get('by_id')) {
			if ($this->input->get('by_id') == 1) {
				$order = " ORDER BY `role`.`id` ";
				$val = 1;
			} else {
				$order = " ORDER BY `role`.`id` DESC ";
				$val = 2;
			}
			$data['url_array'] = array_merge($data['url_array'], array('by_id'=>$val));
			
		} elseif($this->input->get('by_title')) {
			if ($this->input->get('by_title') == 1) {
				$order = " ORDER BY `role`.`title` ";
				$val = 1;
			} else {
				$order = " ORDER BY `role`.`title` DESC ";
				$val = 2;
			}
			$data['url_array'] = array_merge($data['url_array'], array('by_title'=>$val));

		} elseif($this->input->get('by_permission')) {
			if ($this->input->get('by_permission') == 1) {
				$order = " ORDER BY `role`.`permission` ";
				$val = 1;
			} else {
				$order = " ORDER BY `role`.`permission` DESC ";
				$val = 2;
			}
			$data['url_array'] = array_merge($data['url_array'], array('by_permission'=>$val));

		} elseif($this->input->get('by_status')) {
			if ($this->input->get('by_status') == 1) {
				$order = " ORDER BY `role`.`status` ";
				$val = 1;
			} else {
				$order = " ORDER BY `role`.`status` DESC ";
				$val = 2;
			}
			$data['url_array'] = array_merge($data['url_array'], array('by_status'=>$val));

		} else {
			$order = "ORDER BY `role`.`id` DESC";
		}

		//pagination start

        $start =  $this->uri->segment(4);

        if (!is_numeric($start) or !$start) {
            $start = 1;
        }
       

       	$config = $this->pagination_config();
        $page_content_count = $config['per_page'];
        $page_start = ($start - 1)*$page_content_count;

        $this->db->query("SET SESSION group_concat_max_len = 10000000;");

         $sql = "SELECT 
					`role`.`id`,
					`role`.`title`,
				    GROUP_CONCAT(
					   CONCAT('\<span class=\"tl_p\">', `permission`.`title`, '\</span>' )SEPARATOR ''
					) AS `permission`,
					`role`.`status` 
				FROM
				  `role` 
				LEFT JOIN `role_permission` 
					ON `role_permission`.`role_id` = `role`.`id` 
				LEFT JOIN `permission` 
					ON `role_permission`.`permission_id` = `permission`.`id`
				WHERE 1 
				".$add_sql."
				GROUP BY `role`.`id` 
				".$order."
				LIMIT ".$page_start.", ".$page_content_count." ";	

		$query = $this->db->query($sql);
        $num_rows = $query->num_rows();
        $result = $query->result_array();
        $data['result'] = $result;
        $data['num_rows'] = $num_rows;

        $sql_all = "SELECT
				 `role`.`id`
				FROM 
					`role`
				LEFT JOIN `role_permission` 
					ON `role_permission`.`role_id` = `role`.`id` 
				LEFT JOIN `permission` 
					ON `role_permission`.`permission_id` = `permission`.`id`
				WHERE 1 	
				".$add_sql."
				GROUP BY `role`.`id` 
				
				
		";

        $query_all = $this->db->query($sql_all);
        $num_rows_all = $query_all->num_rows();


        $config['base_url'] = base_url().'admin/sysadmin/role/';
        $config['total_rows'] = $num_rows_all;
		$config["uri_segment"] = 4;


        $this->pagination->initialize($config);

		
		$this->layout->view('role/role', $data);
	
	}


    /**
     * @param null $id
     * @return bool
     */
    public function edit_role($id=NULL) {

		$this->authorisation();
        $this->load->helper('url');
        $this->load->helper('form');
		$id = $this->uri->segment(4);
		$data = array();

		$sql_per = "SELECT `id`, `title` FROM `permission` WHERE `status` = '1'";

        $query = $this->db->query($sql_per);
        $result_per = $query->result_array();
        $data['result_permission'] = $result_per;

		if($id == NULL) {
			$message = 'Undifined ID';
			show_error($message, '404', $heading = '404 Page Not Found');
			return false;
		}

		$sql = "SELECT
				  `role`.`id`,
				  `role`.`title`,
				  GROUP_CONCAT(`role_permission`.`permission_id`) AS `permission_ids`,
				  `role`.`status`
				FROM 
					`role`
				LEFT JOIN `role_permission` ON `role_permission`.`role_id` = `role`.`id`
				WHERE `role`.`id` = '".$id."'
				GROUP BY `role`.`id`
				";
		$query = $this->db->query($sql);
		$row = $query->row_array();	

	
		
		if(!is_array($row)) {
			$message = 'Undifined ID';
			show_error($message, '404', $heading = '404 Page Not Found');
			return false;
		}

		$data['id'] = $row['id'];
		$data['title'] = $row['title'];
		$data['permission_ids'] = explode(',', $row['permission_ids']);
		$data['status'] = $row['status'];

		$this->layout->view('role/edit_role', $data, 'edit');
	}


	public function edit_role_ax() {

		$messages = array('success' => '0', 'message' => '', 'error' => '');
		$n = 0;

		if ($this->input->server('REQUEST_METHOD') != 'POST') {
            // Return error
            $messages['error'] = 'error_message';
            $this->access_denied();
            return false;
        }


         $n = 0;
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div>', '</div>');
    	$this->form_validation->set_rules('title', 'Title', 'required');
    	//$this->form_validation->set_rules('permission', 'Permission', 'required');
    

    
		if($this->form_validation->run() == false){
			//validation errors
			$n = 1;
			$validation_errors = array(
				'title' => form_error('title'),
			   //'permission' => form_error('permission')
		    );
		    $messages['error']['elements'][] = $validation_errors;

		}

		    




        $role_id = $this->input->post('id');
        $title = $this->input->post('title');
        $permission_array = $this->input->post('permission');
        $status = $this->input->post('status');

		
		$sql = "UPDATE `role`
					SET 
					 `title` = ".$this->db_value($title).",
					 `status` = ".$this->db_value($status)."
				WHERE `id` = ".$this->db_value($role_id)."
				";
		$result = $this->db->query($sql);

		if (!$result){
             $messages['success'] = 0;
             $messages['error'] = 'Error';
             echo json_encode($messages);
             return false;
        } 

        // TODO status -2 is deleted 
        $sql_p_r_update = "UPDATE `role_permission` SET `status` = '-2' WHERE `role_id` = ".$this->db_value($role_id)."";
		$result_p_r_update = $this->db->query($sql_p_r_update);

		if(!$result_p_r_update) {
			 $messages['success'] = 0;
             $messages['error'] = 'Error';
             echo json_encode($messages);
             return false;
		}

		$sql_p_r_delate = "DELETE FROM `role_permission` WHERE `status` = '-2'";
		$result_p_r_delate = $this->db->query($sql_p_r_delate);

		if(!$result_p_r_delate) {
			 $messages['success'] = 0;
             $messages['error'] = 'Error';
             echo json_encode($messages);
             return false;
		}

		$sql_p_r = "INSERT INTO `role_permission` (
					  `role_id`,
					  `permission_id`,
					  `status`
					) 
					VALUES";

		foreach ($permission_array as  $permission_id) {
				$sql_p_r .= "(
					".$this->db_value($role_id).",
					".$this->db_value($permission_id).",
					'1'
				),";		
		}

		$sql_p_r = substr($sql_p_r, 0, -1);

		$result_p_r = $this->db->query($sql_p_r);

		if ($result_p_r){
            $messages['success'] = 1;
            $messages['message'] = 'Success';
        } else {
            $messages['success'] = 0;
            $messages['error'] = 'Error';
        }


        // Return success or error message
        echo json_encode($messages);
        return true;

	}



	


	public function add_video() {

		$this->authorisation();
		$this->load->helper('url');
		$this->load->helper('form');
		$lng = $this->input->get('lng');
		if(!$lng){
			$lng = $this->default_lng();
		}
		$data = array();
		$data['lng'] = $lng;

		$sql_video_list = "SELECT `id`, `title_".$lng."` AS `title` FROM `video_list` WHERE `status` = '1'";

		$query = $this->db->query($sql_video_list);
        $result_video_list = $query->result_array();
        $data['result_video_list'] = $result_video_list;

		$this->layout->view('video/add_video', $data, 'add');
	}


	public function add_video_ax() {

		$messages = array('success' => '0', 'message' => '', 'error' => '', 'fields' => '');

		if ($this->input->server('REQUEST_METHOD') != 'POST') {
            // Return error
            $messages['error'] = 'error_message';
            echo json_encode($messages);
            return false;
        }

        $this->load->library('image_lib');
        $config = $this->upload_config();
 		$config['upload_path'] = set_realpath('uploads/original');
 		$image_data = array();

        // Form validation
        $n = 0;
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div>', '</div>');
    	$this->form_validation->set_rules('title', 'Title', 'required');
    	$this->form_validation->set_rules('alias', 'Alias', 'required');
    	$this->form_validation->set_rules('date', 'Date', 'required');
    	$this->form_validation->set_rules('video_list', 'Video category', 'required');

      
		if($this->form_validation->run() == false) {
			$n = 1;
			//validation errors
			$validation_errors = array(
				'title' => form_error('title'), 
				'alias' => form_error('alias'), 
				'date' => form_error('date'),
				'video_list' => form_error('video_list')
			);

		    $messages['error']['elements'][] = $validation_errors;
		    
		}

        $lng = $this->input->post('lng');
        $title = $this->input->post('title');
        $alias = $this->input->post('alias');
        $youtube_link = $this->input->post('youtube_link');
        $iframe_link = $this->input->post('iframe_link');
        $an = $this->input->post('an');
        $video_list = $this->input->post('video_list');
        $date = $this->input->post('date');
        $text = $this->input->post('text');
        $status = $this->input->post('status');
 		$ImagePath = $config['upload_path'];

 		if($youtube_link == '' AND $iframe_link == '') {
 			$n = 1;
			$validation_errors = array('youtube_link' => "Youtube link: This field is required<br>", 'iframe_link' => "Iframe link: This field is required<br>");
			$messages['error']['elements'][] = $validation_errors;
			   
 		}



 		if(!$this->valid_url($youtube_link) AND $youtube_link != '') {
 			$n = 1;
			$validation_errors = array('youtube_link' => "Youtube link: Enter valid url<br>");
			$messages['error']['elements'][] = $validation_errors;
			
 		}

 		if($youtube_link == '') {
 			if(!isset($_FILES['photo']['name']) or $_FILES['photo']['name'] == '') {
	 			$n = 1;
				$validation_errors = array('photo' => "Photo: This field is required<br>");
				$messages['error']['elements'][] = $validation_errors;
 			}
 		}

 		if($n == 1) {
 			echo json_encode($messages);
		    return false;
 		}

 		



        $youtube_id = $this->youtube_id_from_url($youtube_link);
        $url = "http://img.youtube.com/vi/".$youtube_id."/hqdefault.jpg";

        if(isset($_FILES['photo']['name']) AND $_FILES['photo']['name'] != '') {
			 $this->load->library('upload', $config);
			 $this->upload->initialize($config);

			if (!$this->upload->do_upload('photo')) {
	            $validation_errors = array('photo' => $this->upload->display_errors());
			    $messages['error']['elements'][] = $validation_errors;
			    echo json_encode($messages);
		    	return false;
			}



			$photo_arr = $this->upload->data();

			$image = $photo_arr['file_name'];

		} else {



	        $file = file_get_contents($url);
	       
	        $save = file_put_contents($ImagePath .'/'. $youtube_id.'.jpg', $file);
	        $image = $youtube_id.'.jpg';
		}


		if($youtube_link != '' or (isset($_FILES['photo']['name']) AND $_FILES['photo']['name'] != '')) {	
	        // resize 
	       
	       
	        $config_r = array(
	            'image_library' => 'gd2',
	            'source_image' => set_realpath('uploads/original').$image,
	            'new_image' => set_realpath('uploads/thumbs').$image,
	            'maintain_ratio' => TRUE,
	            'create_thumb' => TRUE,
	            'thumb_marker' => '',
	            'width' => 480,
	            'height' => 360
	        );
	        
	        $this->image_lib->clear();
	        $this->image_lib->initialize($config_r);
	        $this->image_lib->resize();

	        // end resize

	        if (!$this->image_lib->resize()) {
	            $validation_errors = array('image' => $this->image_lib->display_errors());
	            $messages['error']['elements'][] = $validation_errors;
	            echo json_encode($messages);
			    return false;
	        } else {
	        	$image_data = $this->upload->data();
	        }

	       // $this->pre($image_data);die;

	        // watermark
	        $config_wm['image_library'] = 'gd2'; //default value
	        $config_wm['source_image'] = set_realpath('uploads/thumbs').$image_data['file_name']; //get thumb image
	        $config_wm['wm_type'] = 'overlay';
	        $config_wm['wm_overlay_path'] = set_realpath('icons').'play.png';
	        $config['wm_opacity'] = '50';
	        $config_wm['wm_vrt_alignment'] = 'middle';
	        $config_wm['wm_hor_alignment'] = 'center';
	        $this->load->library('image_lib', $config_wm);
	        $this->image_lib->initialize($config_wm);
	        // end watermark
	       
	        if (!$this->image_lib->watermark()) {
		        $validation_errors = array('watermark' => $this->image_lib->display_errors());
				$messages['error']['elements'][] = $validation_errors;
				echo json_encode($messages);
			    return false;
	        } else {
	        	if(isset($_FILES['photo']['name']) AND $_FILES['photo']['name'] != '') {
		        	// watermark 2
			        $config_wm2['image_library'] = 'gd2'; //default value
			        $config_wm2['source_image'] = set_realpath('uploads/thumbs').$image_data['file_name']; //get thumb image
			        $config_wm2['wm_type'] = 'overlay';
			        $config_wm2['wm_overlay_path'] = set_realpath('icons').'rsz_logo.png';
			        $config_wm2['wm_hor_alignment'] = 'right';

			        $this->image_lib->clear();
			        $this->load->library('image_lib', $config_wm2);
			        $this->image_lib->initialize($config_wm2);
			        // end watermark 2

			        if (!$this->image_lib->watermark()) {
			            $validation_errors = array('watermark' => $this->image_lib->display_errors());
			            $messages['error']['elements'][] = $validation_errors;
			            echo json_encode($messages);
			            return false;
			        }
			    }
	        }
	    }    


		$sql = "INSERT INTO 
					  `video` 
					SET 
				      `title_".$lng."` = ".$this->db_value($title).",
				      `alias_".$lng."` = ".$this->db_value($alias).",
				      `text_".$lng."` = ".$this->db_value($text).",
				      `video_id` = ".$this->db_value($youtube_id).",
				      `iframe_link` = ".$this->db_value($iframe_link).",
				      `photo` = ".$this->db_value($image).",
				      `date` = ".$this->db_value($date).",
				      `an` = ".$this->db_value($an).",
				      `video_list_id` = ".$this->db_value($video_list).",
				      `status` = ".$this->db_value($status)."
		";

		$result = $this->db->query($sql);

		if ($result){
            $messages['success'] = 1;
            $messages['message'] = 'Success';
        } else {
            $messages['success'] = 0;
            $messages['error'] = 'Error';
        }

        // Return success or error message
        echo json_encode($messages);
        return true;
	}


    public function video() {

        $this->authorisation();
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->library('pagination');

        $lng = $this->input->get('lng');

        if(!$lng){
            $lng = $this->default_lng();
        }




        $data = array();
        $add_sql = '';
        $data['url_array'] = array('id' => '', 'title' => '', 'video_list' => '', 'status' => '');



        // Filters


        $sql_video_list = "SELECT `id`, `title_".$lng."` AS `title` FROM `video_list` WHERE `status` = '1'";

        $query = $this->db->query($sql_video_list);
        $result_video_list = $query->result_array();
        $data['result_video_list'] = $result_video_list;

        // ID
        if ($this->input->get('id') or $this->input->post('id')) {
            if ($this->input->get('id')) {
                $id = $this->input->get('id');
            } else {
                $id = $this->input->post('id');
            }
            $add_sql.= " AND `video`.`id` = '".$id."'";
            $data['url_array'] = array_merge($data['url_array'], array('id'=>$id));
        }


        // title
        if ($this->input->get('title') or $this->input->post('title')) {
            if ($this->input->get('title')) {
                $title = $this->input->get('title');
            } else {
                $title = $this->input->post('title');
            }
            $add_sql.= " AND `video`.`title_".$lng."` LIKE '%".$title."%'";
            $data['url_array'] = array_merge($data['url_array'], array('title'=>$title));
        }

        // Video list
        if ($this->input->get('video_list') or $this->input->post('video_list')) {
            if ($this->input->get('video_list')) {
                $video_list = $this->input->get('video_list');
            } else {
                $video_list = $this->input->post('video_list');
            }
            $add_sql.= " AND `video`.`video_list_id` = '".$video_list."'";
            $data['url_array'] = array_merge($data['url_array'], array('video_list'=>$video_list));
        }

     

        // Status
        if ($this->input->get('status') or $this->input->post('status')) {
            if ($this->input->get('status')) {
                $status = $this->input->get('status');
            } else {
                $status = $this->input->post('status');
            }
            $add_sql.= " AND `video`.`status` = '".$status."'";
            $data['url_array'] = array_merge($data['url_array'], array('status'=>$status));
        }


        // Ordering

        if ($this->input->get('by_id')) {
            if ($this->input->get('by_id') == 1) {
                $order = " ORDER BY `video`.`id` ";
                $val = 1;
            } else {
                $order = " ORDER BY `video`.`id` DESC ";
                $val = 2;
            }
            $data['url_array'] = array_merge($data['url_array'], array('by_id'=>$val));

        } elseif($this->input->get('by_title')) {
            if ($this->input->get('by_title') == 1) {
                $order = " ORDER BY `video`.`title_".$lng."` ";
                $val = 1;
            } else {
                $order = " ORDER BY `video`.`title_".$lng."` DESC ";
                $val = 2;
            }
            $data['url_array'] = array_merge($data['url_array'], array('by_title'=>$val));

        } elseif($this->input->get('by_video_list')) {
            if ($this->input->get('by_video_list') == 1) {
                $order = " ORDER BY `video`.`video_list_id` ";
                $val = 1;
            } else {
                $order = " ORDER BY `video`.`video_list_id` DESC ";
                $val = 2;
            }
            $data['url_array'] = array_merge($data['url_array'], array('by_video_list'=>$val));

        } elseif($this->input->get('by_status')) {
            if ($this->input->get('by_status') == 1) {
                $order = " ORDER BY `video`.`status` ";
                $val = 1;
            } else {
                $order = " ORDER BY `video`.`status` DESC ";
                $val = 2;
            }
            $data['url_array'] = array_merge($data['url_array'], array('by_status'=>$val));

        } else {
            $order = "ORDER BY `video`.`id` DESC";
        }

        //pagination start

        $start =  $this->uri->segment(4);

        if (!is_numeric($start) or !$start) {
            $start = 1;
        }


        $config = $this->pagination_config();
        $page_content_count = $config['per_page'];
        $page_start = ($start - 1)*$page_content_count;


       $sql = "SELECT 
					`video`.`id`,
					`video`.`title_".$lng."` AS `title`,
				    `video_list`.`title_".$lng."` AS `video_list`,
					`video`.`status` 
				FROM
				  `video` 
				LEFT JOIN `video_list` 
					ON `video`.`video_list_id` = `video_list`.`id` 
				WHERE 1 
				".$add_sql."
				".$order."
				LIMIT ".$page_start.", ".$page_content_count." ";

        $query = $this->db->query($sql);
        $num_rows = $query->num_rows();
        $result = $query->result_array();
        $data['result'] = $result;
        

        $sql_all = "SELECT
				 `video`.`id`
				FROM 
					`video`
				LEFT JOIN `video_list` 
					ON `video`.`video_list_id` = `video_list`.`id` 
				WHERE 1 	
				".$add_sql."
				
				
		";

        $query_all = $this->db->query($sql_all);
        $num_rows_all = $query_all->num_rows();


        $config['base_url'] = base_url().'admin/sysadmin/video/';
        $config['total_rows'] = $num_rows_all;
        $data['num_rows'] = $num_rows_all;
        $config["uri_segment"] = 4;


        $this->pagination->initialize($config);


        $this->layout->view('video/video', $data);

    }


    public function edit_video($id=NULL) {

        $this->authorisation();
        $id = $this->uri->segment(4);
        $this->load->helper('url');
        $this->load->helper('form');
        $lng = $this->input->get('lng');

        if(!$lng){
            $lng = $this->default_lng();
        }

        if($id == NULL) {
            $message = 'Undifined ID';
            show_error($message, '404', $heading = '404 Page Not Found');
            return false;
        }
        $data = array();
        $data['lng'] = $lng;

         $sql = "SELECT
                  `id`,
                  `title_".$lng."` AS `title`,
                  `alias_".$lng."` AS `alias`,
                  `text_".$lng."` AS `text`,
                  `video_id`,
                  `iframe_link`,
                  `an`,
                  `photo`,
                   DATE_FORMAT(`date`, '%Y-%m-%d') AS `date`,
                  `video_list_id`,
                  `status`
                FROM 
                   `video`
                WHERE `id` =  ".$this->db_value($id)."
                LIMIT 1";

        $query = $this->db->query($sql);
        $row = $query->row_array();

        $data['id'] = $row['id'];
        $data['title'] = $row['title'];
        $data['alias'] = $row['alias'];
        $data['text'] = $row['text'];
        $data['video_id'] = $row['video_id'];
        $data['iframe_link'] = $row['iframe_link'];
        $data['an'] = $row['an'];
        $data['date'] = $row['date'];
        $data['photo'] =  $row['photo'];
        $data['video_list_id'] =  $row['video_list_id'];
        $data['status'] =  $row['status'];
        $data['photo_url'] = base_url().'uploads/thumbs/';

        $sql_video_list = "SELECT `id`, `title_".$lng."` AS `title` FROM `video_list` WHERE `status` = '1'";

        $query_vl = $this->db->query($sql_video_list);
        $result_video_list = $query_vl->result_array();
        $data['result_video_list'] = $result_video_list;

        $this->layout->view('video/edit_video', $data, 'edit');
    }


    public function edit_video_ax() {

        $messages = array('success' => '0', 'message' => '', 'error' => '', 'fields' => '');

        if ($this->input->server('REQUEST_METHOD') != 'POST') {
            // Return error
            $messages['error'] = 'error_message';
            $this->access_denied();
            return false;
        }

        $this->load->library('image_lib');
        $config = $this->upload_config();
        $config['upload_path'] = set_realpath('uploads/original');
        $image_data = array();

        // Form validation
        $n = 0;
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div>', '</div>');
        $this->form_validation->set_rules('title', 'Title', 'required');
        $this->form_validation->set_rules('alias', 'Alias', 'required');
        $this->form_validation->set_rules('date', 'Date', 'required');
        $this->form_validation->set_rules('video_list', 'Video category', 'required');



        if($this->form_validation->run() == false){
            //validation errors
            $validation_errors = array(
                'title' => form_error('title'),
                'alias' => form_error('alias'),
                'date' => form_error('date'),
                'video_list' => form_error('video_list')
            );
            $messages['error']['elements'][] = $validation_errors;
            echo json_encode($messages);
            return false;
        }

        $lng = $this->input->post('lng');
        $photo = $this->input->post('photo');
        $id = $this->input->post('id');
        $title = $this->input->post('title');
        $alias = $this->input->post('alias');
        $youtube_link = $this->input->post('youtube_link');
        $iframe_link = $this->input->post('iframe_link');
        $video_list = $this->input->post('video_list');
        $an = $this->input->post('an');
        $date = $this->input->post('date');
        $text = $this->input->post('text');
        $status = $this->input->post('status');
        $ImagePath = $config['upload_path'];


        if($youtube_link == '' AND $iframe_link == '') {
 			$n = 1;
			$validation_errors = array('youtube_link' => "Youtube link: This field is required<br>", 'iframe_link' => "Iframe link: This field is required<br>");
			$messages['error']['elements'][] = $validation_errors;
			   
 		}



 		if(!$this->valid_url($youtube_link) AND $youtube_link != '') {
 			$n = 1;
			$validation_errors = array('youtube_link' => "Youtube link: Enter valid url<br>");
			$messages['error']['elements'][] = $validation_errors;
			
 		}

 		if($youtube_link == '' AND $photo == '') {
 			if(!isset($_FILES['photo']['name']) or $_FILES['photo']['name'] == '') {
	 			$n = 1;
				$validation_errors = array('photo' => "Photo: This field is required<br>");
				$messages['error']['elements'][] = $validation_errors;
 			}
 		}

 		if($n == 1) {
 			echo json_encode($messages);
		    return false;
 		}



        $youtube_id = $this->youtube_id_from_url($youtube_link);
        $url = "http://img.youtube.com/vi/".$youtube_id."/hqdefault.jpg";

        if(isset($_FILES['photo']['name']) AND $_FILES['photo']['name'] != '') {
            $this->load->library('upload', $config);
            $this->upload->initialize($config);

            if (!$this->upload->do_upload('photo')) {
                $validation_errors = array('photo' => $this->upload->display_errors());
                $messages['error']['elements'][] = $validation_errors;
                echo json_encode($messages);
                return false;
            }



            $photo_arr = $this->upload->data();

            $image = $photo_arr['file_name'];

        } elseif (!$photo or $photo == ''){

            $file = file_get_contents($url);
            $save = file_put_contents($ImagePath .'/'. $youtube_id.'.jpg', $file);
            $image = $youtube_id.'.jpg';

        } else {
            $image = $photo;
        }


    if($youtube_link != '' or (isset($_FILES['photo']['name']) AND $_FILES['photo']['name'] != '')) {

        // resize


        $config_r = array(
            'image_library' => 'gd2',
            'source_image' => set_realpath('uploads/original').$image,
            'new_image' => set_realpath('uploads/thumbs').$image,
            'maintain_ratio' => TRUE,
            'create_thumb' => TRUE,
            'thumb_marker' => '',
            'width' => 480,
            'height' => 360
        );

 		$this->image_lib->clear();
        $this->image_lib->initialize($config_r);
        $this->image_lib->resize();



        // end resize

        if (!$this->image_lib->resize()) {
            $validation_errors = array('image' => $this->image_lib->display_errors());
            $messages['error']['elements'][] = $validation_errors;
            echo json_encode($messages);
            return false;
        } else {
            $image_data = $this->upload->data();
        }

        // watermark
        $config_wm['image_library'] = 'gd2'; //default value
        $config_wm['source_image'] = set_realpath('uploads/thumbs').$image_data['file_name']; //get thumb image
        $config_wm['wm_type'] = 'overlay';
        $config_wm['wm_overlay_path'] = set_realpath('icons').'play.png';
        $config['wm_opacity'] = '50';
        $config_wm['wm_vrt_alignment'] = 'middle';
        $config_wm['wm_hor_alignment'] = 'center';

        $this->load->library('image_lib', $config_wm);
        $this->image_lib->initialize($config_wm);
        // end watermark

        if (!$this->image_lib->watermark()) {
            $validation_errors = array('watermark' => $this->image_lib->display_errors());
            $messages['error']['elements'][] = $validation_errors;
            echo json_encode($messages);
            return false;
        } else {
        	
        	if(isset($_FILES['photo']['name']) AND $_FILES['photo']['name'] != '') {
		        	// watermark 2
			        $config_wm2['image_library'] = 'gd2'; //default value
			        $config_wm2['source_image'] = set_realpath('uploads/thumbs').$image_data['file_name']; //get thumb image
			        $config_wm2['wm_type'] = 'overlay';
			        $config_wm2['wm_overlay_path'] = set_realpath('icons').'rsz_logo.png';
			        $config_wm2['wm_hor_alignment'] = 'right';

			        $this->image_lib->clear();
			        $this->load->library('image_lib', $config_wm2);
			        $this->image_lib->initialize($config_wm2);
			        // end watermark 2

			        if (!$this->image_lib->watermark()) {
			            $validation_errors = array('watermark' => $this->image_lib->display_errors());
			            $messages['error']['elements'][] = $validation_errors;
			            echo json_encode($messages);
			            return false;
			        }
			}

        }

    }


        $sql = "UPDATE 
					  `video` 
					SET 
				      `title_".$lng."` = ".$this->db_value($title).",
				      `alias_".$lng."` = ".$this->db_value($alias).",
				      `text_".$lng."` = ".$this->db_value($text).",
				      `video_id` = ".$this->db_value($youtube_id).",
				      `photo` = ".$this->db_value($image).",
				      `iframe_link` = ".$this->db_value($iframe_link).",
				      `an` = ".$this->db_value($an).",
				      `date` = ".$this->db_value($date).",
				      `video_list_id` = ".$this->db_value($video_list).",
				      `status` = ".$this->db_value($status)."
				WHERE `id` = ".$this->db_value($id)."
		";

        $result = $this->db->query($sql);

        if ($result){
            $messages['success'] = 1;
            $messages['message'] = 'Success';
        } else {
            $messages['success'] = 0;
            $messages['error'] = 'Error';
        }

        // Return success or error message
        echo json_encode($messages);
        return true;
    }
    
    
    public function copy_video() {
        $this->edit_video();
    }

    public function copy_video_ax() {
        $this->add_video_ax();
    }


    public function add_video_list() {

        $this->authorisation();
        $this->load->helper('url');
        $this->load->helper('form');
        $lng = $this->input->get('lng');
        if(!$lng){
            $lng = $this->default_lng();
        }
        $data = array();
        $data['lng'] = $lng;



        $this->layout->view('video_list/add_video_list', $data, 'add');
    }


    public function add_video_list_ax() {

        $messages = array('success' => '0', 'message' => '', 'error' => '', 'fields' => '');

        if ($this->input->server('REQUEST_METHOD') != 'POST') {
            // Return error
            $messages['error'] = 'error_message';
            $this->access_denied();
            return false;
        }

        $this->load->library('image_lib');
        $config = $this->upload_config();
        $config['upload_path'] = set_realpath('uploads/original');
        $image_data = array();

        // Form validation
        $n = 0;
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div>', '</div>');
        $this->form_validation->set_rules('title', 'Title', 'required');
        $this->form_validation->set_rules('alias', 'Alias', 'required');




        if($this->form_validation->run() == false){
            //validation errors
            $validation_errors = array(
                'title' => form_error('title'),
                'alias' => form_error('alias'),
            );
            $messages['error']['elements'][] = $validation_errors;
            echo json_encode($messages);
            return false;
        }

        $lng = $this->input->post('lng');
        $title = $this->input->post('title');
        $alias = $this->input->post('alias');

        $text = $this->input->post('text');
        $status = $this->input->post('status');



        $sql = "INSERT INTO 
					  `video_list` 
					SET 
				      `title_".$lng."` = ".$this->db_value($title).",
				      `alias_".$lng."` = ".$this->db_value($alias).",
				      `text_".$lng."` = ".$this->db_value($text).",
				      `status` = ".$this->db_value($status)."
		";

        $result = $this->db->query($sql);

        if ($result){
            $messages['success'] = 1;
            $messages['message'] = 'Success';
        } else {
            $messages['success'] = 0;
            $messages['error'] = 'Error';
        }

        // Return success or error message
        echo json_encode($messages);
        return true;
    }


    public function video_list() {

        $this->authorisation();
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->library('pagination');

        //TODO mtacel
        $lng = $this->default_lng();




        $data = array();
        $add_sql = '';
        $data['url_array'] = array('id' => '', 'title' => '', 'status' => '');



        // Filters


        // ID
        if ($this->input->get('id') or $this->input->post('id')) {
            if ($this->input->get('id')) {
                $id = $this->input->get('id');
            } else {
                $id = $this->input->post('id');
            }
            $add_sql.= " AND `video_list`.`id` = '".$id."'";
            $data['url_array'] = array_merge($data['url_array'], array('id'=>$id));
        }


        // title
        if ($this->input->get('title') or $this->input->post('title')) {
            if ($this->input->get('title')) {
                $title = $this->input->get('title');
            } else {
                $title = $this->input->post('title');
            }
            $add_sql.= " AND `video_list`.`title_".$lng."` LIKE '%".$title."%'";
            $data['url_array'] = array_merge($data['url_array'], array('title'=>$title));
        }


        // Status
        if ($this->input->get('status') or $this->input->post('status')) {
            if ($this->input->get('status')) {
                $status = $this->input->get('status');
            } else {
                $status = $this->input->post('status');
            }
            $add_sql.= " AND `video_list`.`status` = '".$status."'";
            $data['url_array'] = array_merge($data['url_array'], array('status'=>$status));
        }


        // Ordering

        if ($this->input->get('by_id')) {
            if ($this->input->get('by_id') == 1) {
                $order = " ORDER BY `video_list`.`id` ";
                $val = 1;
            } else {
                $order = " ORDER BY `video_list`.`id` DESC ";
                $val = 2;
            }
            $data['url_array'] = array_merge($data['url_array'], array('by_id'=>$val));

        } elseif($this->input->get('by_title')) {
            if ($this->input->get('by_title') == 1) {
                $order = " ORDER BY `video_list`.`title_".$lng."` ";
                $val = 1;
            } else {
                $order = " ORDER BY `video_list`.`title_".$lng."` DESC ";
                $val = 2;
            }
            $data['url_array'] = array_merge($data['url_array'], array('by_title'=>$val));

        } elseif($this->input->get('by_status')) {
            if ($this->input->get('by_status') == 1) {
                $order = " ORDER BY `video_list`.`status` ";
                $val = 1;
            } else {
                $order = " ORDER BY `video_list`.`status` DESC ";
                $val = 2;
            }
            $data['url_array'] = array_merge($data['url_array'], array('by_status'=>$val));

        } else {
            $order = "ORDER BY `video_list`.`id` DESC";
        }

        //pagination start

        $start =  $this->uri->segment(4);

        if (!is_numeric($start) or !$start) {
            $start = 1;
        }


        $config = $this->pagination_config();
        $page_content_count = $config['per_page'];
        $page_start = ($start - 1)*$page_content_count;


        $sql = "SELECT 
					`video_list`.`id`,
					`video_list`.`title_".$lng."` AS `title`,
					`video_list`.`status` 
				FROM
				  `video_list` 
				WHERE 1 
				".$add_sql."
				".$order."
				LIMIT ".$page_start.", ".$page_content_count." ";

        $query = $this->db->query($sql);
        $num_rows = $query->num_rows();
        $result = $query->result_array();
        $data['result'] = $result;
        $data['num_rows'] = $num_rows;

        $sql_all = "SELECT
				 `video_list`.`id`
				FROM 
					`video_list`
				WHERE 1 	
				".$add_sql."
				
				
		";

        $query_all = $this->db->query($sql_all);
        $num_rows_all = $query_all->num_rows();


        $config['base_url'] = base_url().'admin/sysadmin/video_list/';
        $config['total_rows'] = $num_rows_all;
        $config["uri_segment"] = 4;


        $this->pagination->initialize($config);


        $this->layout->view('video_list/video_list', $data);

    }

    public function edit_video_list($id=NULL) {

        $this->authorisation();
        $id = $this->uri->segment(4);
        $this->load->helper('url');
        $this->load->helper('form');
        $lng = $this->input->get('lng');

        if(!$lng){
            $lng = $this->default_lng();
        }

        if($id == NULL) {
            $message = 'Undifined ID';
            show_error($message, '404', $heading = '404 Page Not Found');
            return false;
        }
        $data = array();
        $data['lng'] = $lng;

        $sql = "SELECT
                  `id`,
                  `title_".$lng."` AS `title`,
                  `alias_".$lng."` AS `alias`,
                  `text_".$lng."` AS `text`,
                  `status`
                FROM 
                   `video_list`
                WHERE `id` =  ".$this->db_value($id)."
                LIMIT 1";

        $query = $this->db->query($sql);
        $row = $query->row_array();

        $data['id'] = $row['id'];
        $data['title'] = $row['title'];
        $data['alias'] = $row['alias'];
        $data['text'] = $row['text'];
        $data['status'] =  $row['status'];



        $this->layout->view('video_list/edit_video_list', $data, 'edit');
    }


    public function edit_video_list_ax() {

        $messages = array('success' => '0', 'message' => '', 'error' => '', 'fields' => '');

        if ($this->input->server('REQUEST_METHOD') != 'POST') {
            // Return error
            $messages['error'] = 'error_message';
            $this->access_denied();
            return false;
        }

        $this->load->library('image_lib');
        $config = $this->upload_config();
        $config['upload_path'] = set_realpath('uploads/original');
        $image_data = array();

        // Form validation
        $n = 0;
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div>', '</div>');
        $this->form_validation->set_rules('title', 'Title', 'required');
        $this->form_validation->set_rules('alias', 'Alias', 'required');



        if($this->form_validation->run() == false){
            //validation errors
            $validation_errors = array(
                'title' => form_error('title'),
                'alias' => form_error('alias'),

            );
            $messages['error']['elements'][] = $validation_errors;
            echo json_encode($messages);
            return false;
        }

        $lng = $this->input->post('lng');
        $id = $this->input->post('id');
        $title = $this->input->post('title');
        $alias = $this->input->post('alias');
        $text = $this->input->post('text');
        $status = $this->input->post('status');



        $sql = "UPDATE 
					  `video_list` 
					SET 
				      `title_".$lng."` = ".$this->db_value($title).",
				      `alias_".$lng."` = ".$this->db_value($alias).",
				      `text_".$lng."` = ".$this->db_value($text).",
				      `status` = ".$this->db_value($status)."
				WHERE `id` = ".$this->db_value($id)."
		";

        $result = $this->db->query($sql);

        if ($result){
            $messages['success'] = 1;
            $messages['message'] = 'Success';
        } else {
            $messages['success'] = 0;
            $messages['error'] = 'Error';
        }

        // Return success or error message
        echo json_encode($messages);
        return true;
    }


    public function copy_video_list() {
        $this->edit_video_list();
    }

    public function copy_video_list_ax() {
        $this->add_video_list_ax();
    }



    // menu
    public function edit_menu() {

		$this->authorisation();
        $this->load->helper('url');
        $this->load->helper('form');
        $lng = $this->input->get('lng');

        if(!$lng){
            $lng = $this->default_lng();
        }
        $data = array();

        $sql = "
        	SELECT 
        	  `id`,
			  `title_hy` AS `title`,
			  `alias_hy` AS `alias`,
			  `image`,
			  `ordering`
			FROM
			  `menu` 
			WHERE `status` = '1' 
			ORDER BY `ordering` 
        ";

         $query = $this->db->query($sql);
         $result = $query->result_array();
         $data['result'] = $result;

		$this->layout->view('menu/edit_menu', $data, 'menu');

	}

	public function edit_menu_ax() {

		$messages = array('success' => '0', 'message' => '', 'error' => '', 'fields' => '');

		if ($this->input->server('REQUEST_METHOD') != 'POST') {
            // Return error
            $messages['error'] = 'error_message';
            echo json_encode($messages);
            return false;
        }

        $this->load->library('image_lib');
        $config = $this->upload_config();
 		$config['upload_path'] = set_realpath('uploads/menu');
 		$image_data = array();

 		echo json_encode('-_-_-_-_-_-_-');
	    print_r($_FILES);die;

	    if(isset($_FILES['photo']['name']) AND $_FILES['photo']['name'] != '') {


			$this->load->library('upload', $config);
			$this->upload->initialize($config);

			if (!$this->upload->do_upload('photo')) {
		        $validation_errors = array('photo' => $this->upload->display_errors());
				$messages['error']['elements'][] = $validation_errors;
				echo json_encode($messages);
			    return false;
			}

			$photo_arr = $this->upload->data();
			$image = $photo_arr['file_name'];

		} 

	   

	}

	// upload video in server 
	public function upload_video() {

		$this->authorisation();
		$this->load->helper('url');
        $this->load->helper('form');
        $data = array();

        $this->layout->view('video/upload_video', $data, 'custom');
	}

	public function upload_video_ax() {

		// $messages = array('success' => '0', 'message' => '', 'error' => '', 'fields' => '');

		if ($this->input->server('REQUEST_METHOD') != 'POST') {
            // Return error
            $messages['error'] = 'error_message';
            $this->access_denied();
            return false;
        }


        $fileName = $_FILES["video"]["name"]; // The file name
		$fileTmpLoc = $_FILES["video"]["tmp_name"]; // File in the PHP tmp folder
		$fileType = $_FILES["video"]["type"]; // The type of file it is
		$fileSize = $_FILES["video"]["size"]; // File size in bytes
		$fileErrorMsg = $_FILES["video"]["error"]; // 0 for false... and 1 for true

		if (!$fileTmpLoc) { // if file not chosen
		    echo "ERROR: Please browse for a file before clicking the upload button.";
		    exit();
		}
		if(move_uploaded_file($fileTmpLoc, "uploads/video/".$fileName)){
		    echo $fileName." upload is complete";
		} else {
		    echo "move_uploaded_file function failed";
		}

	}
	
	public function cron($token=NULL){
	    
	    $date = date("Y-m-d");

        //decrement 1 month
        $mod_date = strtotime($date."- 1 months");
        $del_date = date("Y-m-d",$mod_date);
        
        
	    if($token == 30165177) {
	        
	        $sql = "UPDATE `video_viewer` SET `status` = '-1' WHERE `date` < ".$this->db_value($del_date)."";
            $result = $this->db->query($sql);

	    }
	    return true;
	}



	public function news() {

        $this->authorisation();
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->library('pagination');


        $lng = $this->input->get('lng');

        if(!$lng){
            $lng = $this->default_lng();
        }




        $data = array();
        $add_sql = '';
        $data['url_array'] = array('id' => '', 'title' => '', 'status' => '');



        // Filters


        // ID
        if ($this->input->get('id') or $this->input->post('id')) {
            if ($this->input->get('id')) {
                $id = $this->input->get('id');
            } else {
                $id = $this->input->post('id');
            }
            $add_sql.= " AND `content`.`id` = '".$id."'";
            $data['url_array'] = array_merge($data['url_array'], array('id'=>$id));
        }


        // title
        if ($this->input->get('title') or $this->input->post('title')) {
            if ($this->input->get('title')) {
                $title = $this->input->get('title');
            } else {
                $title = $this->input->post('title');
            }
            $add_sql.= " AND `content`.`title_".$lng."` LIKE '%".$title."%'";
            $data['url_array'] = array_merge($data['url_array'], array('title'=>$title));
        }


        // Status
        if ($this->input->get('status') or $this->input->post('status')) {
            if ($this->input->get('status')) {
                $status = $this->input->get('status');
            } else {
                $status = $this->input->post('status');
            }
            $add_sql.= " AND `content`.`status` = '".$status."'";
            $data['url_array'] = array_merge($data['url_array'], array('status'=>$status));
        }


        // Ordering

        if ($this->input->get('by_id')) {
            if ($this->input->get('by_id') == 1) {
                $order = " ORDER BY `content`.`id` ";
                $val = 1;
            } else {
                $order = " ORDER BY `content`.`id` DESC ";
                $val = 2;
            }
            $data['url_array'] = array_merge($data['url_array'], array('by_id'=>$val));

        } elseif($this->input->get('by_title')) {
            if ($this->input->get('by_title') == 1) {
                $order = " ORDER BY `content`.`title_".$lng."` ";
                $val = 1;
            } else {
                $order = " ORDER BY `content`.`title_".$lng."` DESC ";
                $val = 2;
            }
            $data['url_array'] = array_merge($data['url_array'], array('by_title'=>$val));

        } elseif($this->input->get('by_status')) {
            if ($this->input->get('by_status') == 1) {
                $order = " ORDER BY `content`.`status` ";
                $val = 1;
            } else {
                $order = " ORDER BY `content`.`status` DESC ";
                $val = 2;
            }
            $data['url_array'] = array_merge($data['url_array'], array('by_status'=>$val));

        } else {
            $order = "ORDER BY `content`.`id` DESC";
        }

        //pagination start

        $start =  $this->uri->segment(4);

        if (!is_numeric($start) or !$start) {
            $start = 1;
        }


        $config = $this->pagination_config();
        $page_content_count = $config['per_page'];
        $page_start = ($start - 1)*$page_content_count;


        $sql = "SELECT 
				  `id`,
				  `title_".$lng."` AS `title`,
				  `short_text_".$lng."` AS `short_text`,
				  `date`,
				  `image`,
				  `status` 
				FROM
				  `content` 
				WHERE 1 
				".$add_sql."
				".$order."
				LIMIT ".$page_start.", ".$page_content_count." ";

        $query = $this->db->query($sql);
        $num_rows = $query->num_rows();
        $result = $query->result_array();
        $data['result'] = $result;
        $data['num_rows'] = $num_rows;

        $sql_all = "SELECT
				 `content`.`id`
				FROM 
					`content`
				WHERE 1 	
				".$add_sql."
				
				
		";

        $query_all = $this->db->query($sql_all);
        $num_rows_all = $query_all->num_rows();


        $config['base_url'] = base_url().'admin/sysadmin/news/';
        $config['total_rows'] = $num_rows_all;
        $config["uri_segment"] = 4;


        $this->pagination->initialize($config);


        $this->layout->view('news/news', $data);

    }


    public function add_news() {

        $this->authorisation();
        $this->load->helper('url');
        $this->load->helper('form');
        $lng = $this->input->get('lng');
        if(!$lng){
            $lng = $this->default_lng();
        }
        $data = array();
        $data['lng'] = $lng;



        $this->layout->view('news/add_news', $data, 'add');
    }


    public function add_news_ax() {

        $messages = array('success' => '0', 'message' => '', 'error' => '', 'fields' => '');

        if ($this->input->server('REQUEST_METHOD') != 'POST') {
            // Return error
            $messages['error'] = 'error_message';
            $this->access_denied();
            return false;
        }

        $this->load->library('image_lib');
        $config = $this->upload_config();
        $config['upload_path'] = set_realpath('uploads/original');
        $image_data = array();

        // Form validation
        $n = 0;
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div>', '</div>');
        $this->form_validation->set_rules('title', 'Title', 'required');
        $this->form_validation->set_rules('alias', 'Alias', 'required');
        $this->form_validation->set_rules('short_text', 'Short text', 'required');




        if($this->form_validation->run() == false){
            //validation errors
            $validation_errors = array(
                'title' => form_error('title'),
                'alias' => form_error('alias'),
                'short_text' => form_error('short_text')
            );
            $messages['error']['elements'][] = $validation_errors;
            echo json_encode($messages);
            return false;
        }

        $lng = $this->input->post('lng');
        $title = $this->input->post('title');
        $alias = $this->input->post('alias');

        $date = $this->input->post('date');
        $short_text = $this->input->post('short_text');
        $text = $this->input->post('text');
        $status = $this->input->post('status');

        $meta_desc = $this->input->post('meta_desc');
        $meta_tag = $this->input->post('meta_tag');
        $image = '';



        if(isset($_FILES['photo']['name']) AND $_FILES['photo']['name'] != '') {
            $this->load->library('upload', $config);
            $this->upload->initialize($config);

            if (!$this->upload->do_upload('photo')) {
                $validation_errors = array('photo' => $this->upload->display_errors());
                $messages['error']['elements'][] = $validation_errors;
                echo json_encode($messages);
                return false;
            }



            $photo_arr = $this->upload->data();

            $image = $photo_arr['file_name'];

        }


        if((isset($_FILES['photo']['name']) AND $_FILES['photo']['name'] != '')) {
            // resize


            $config_r = array(
                'image_library' => 'gd2',
                'source_image' => set_realpath('uploads/original') . $image,
                'new_image' => set_realpath('uploads/thumbs') . $image,
                'maintain_ratio' => TRUE,
                'create_thumb' => TRUE,
                'thumb_marker' => '',
                'width' => 480,
                'height' => 360
            );

            $this->image_lib->clear();
            $this->image_lib->initialize($config_r);
            $this->image_lib->resize();

            // end resize

            if (!$this->image_lib->resize()) {
                $validation_errors = array('image' => $this->image_lib->display_errors());
                $messages['error']['elements'][] = $validation_errors;
                echo json_encode($messages);
                return false;
            } else {
                $image_data = $this->upload->data();
            }

        }

        $sql = "INSERT INTO 
					  `content` 
					SET 
				      `title_".$lng."` = ".$this->db_value($title).",
				      `alias_".$lng."` = ".$this->db_value($alias).",
				      `date` = ".$this->db_value($date).",
				      `image` = ".$this->db_value($image).",
				      `meta_desc_".$lng."` = ".$this->db_value($meta_desc).",
				      `meta_tag_".$lng."` = ".$this->db_value($meta_tag).",
				      `short_text_".$lng."` = ".$this->db_value($short_text).",
				      `text_".$lng."` = ".$this->db_value($text).",
				      `status` = ".$this->db_value($status)."
		";

        $result = $this->db->query($sql);

        if ($result){
            $messages['success'] = 1;
            $messages['message'] = 'Success';
        } else {
            $messages['success'] = 0;
            $messages['error'] = 'Error';
        }

        // Return success or error message
        echo json_encode($messages);
        return true;
    }



    public function edit_news($id=NULL) {

        $this->authorisation();
        $id = $this->uri->segment(4);
        $this->load->helper('url');
        $this->load->helper('form');
        $lng = $this->input->get('lng');

        if(!$lng){
            $lng = $this->default_lng();
        }

        if($id == NULL) {
            $message = 'Undifined ID';
            show_error($message, '404', $heading = '404 Page Not Found');
            return false;
        }
        $data = array();
        $data['lng'] = $lng;

        $sql = "SELECT
                  `id`,
                  `title_".$lng."` AS `title`,
                  `alias_".$lng."` AS `alias`,
                  `image`,
                  `date`,
                  `short_text_".$lng."` AS `short_text`,
                  `text_".$lng."` AS `text`,
                  `meta_desc_".$lng."` AS `meta_desc`,
                  `meta_tag_".$lng."` AS `meta_tag`,
                  `status`
                FROM 
                   `content`
                WHERE `id` =  ".$this->db_value($id)."
                LIMIT 1";

        $query = $this->db->query($sql);
        $row = $query->row_array();

        $data['id'] = $row['id'];
        $data['title'] = $row['title'];
        $data['alias'] = $row['alias'];
        $data['photo'] = $row['image'];
        $data['date'] = $row['date'];
        $data['short_text'] = $row['short_text'];
        $data['text'] = $row['text'];
        $data['meta_desc'] = $row['meta_desc'];
        $data['meta_tag'] = $row['meta_tag'];
        $data['status'] =  $row['status'];
        $data['photo_url'] = base_url().'uploads/thumbs/';



        $this->layout->view('news/edit_news', $data, 'edit');
    }


    public function edit_news_ax() {

        $messages = array('success' => '0', 'message' => '', 'error' => '', 'fields' => '');

        if ($this->input->server('REQUEST_METHOD') != 'POST') {
            // Return error
            $messages['error'] = 'error_message';
            $this->access_denied();
            return false;
        }

        $this->load->library('image_lib');
        $config = $this->upload_config();
        $config['upload_path'] = set_realpath('uploads/original');
        $image_data = array();

        // Form validation
        $n = 0;
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div>', '</div>');
        $this->form_validation->set_rules('title', 'Title', 'required');
        $this->form_validation->set_rules('alias', 'Alias', 'required');
        $this->form_validation->set_rules('short_text', 'Short text', 'required');




        if($this->form_validation->run() == false){
            //validation errors
            $validation_errors = array(
                'title' => form_error('title'),
                'alias' => form_error('alias'),
                'short_text' => form_error('short_text')
            );
            $messages['error']['elements'][] = $validation_errors;
            echo json_encode($messages);
            return false;
        }

        $lng = $this->input->post('lng');
        $id = $this->input->post('id');
        $title = $this->input->post('title');
        $alias = $this->input->post('alias');

        $date = $this->input->post('date');
        $short_text = $this->input->post('short_text');
        $text = $this->input->post('text');
        $status = $this->input->post('status');

        $meta_desc = $this->input->post('meta_desc');
        $meta_tag = $this->input->post('meta_tag');
        $image = $this->input->post('photo');



        if(isset($_FILES['photo']['name']) AND $_FILES['photo']['name'] != '') {
            $this->load->library('upload', $config);
            $this->upload->initialize($config);

            if (!$this->upload->do_upload('photo')) {
                $validation_errors = array('photo' => $this->upload->display_errors());
                $messages['error']['elements'][] = $validation_errors;
                echo json_encode($messages);
                return false;
            }



            $photo_arr = $this->upload->data();

            $image = $photo_arr['file_name'];

        }


        if((isset($_FILES['photo']['name']) AND $_FILES['photo']['name'] != '')) {
            // resize


            $config_r = array(
                'image_library' => 'gd2',
                'source_image' => set_realpath('uploads/original') . $image,
                'new_image' => set_realpath('uploads/thumbs') . $image,
                'maintain_ratio' => TRUE,
                'create_thumb' => TRUE,
                'thumb_marker' => '',
                'width' => 480,
                'height' => 360
            );

            $this->image_lib->clear();
            $this->image_lib->initialize($config_r);
            $this->image_lib->resize();

            // end resize

            if (!$this->image_lib->resize()) {
                $validation_errors = array('image' => $this->image_lib->display_errors());
                $messages['error']['elements'][] = $validation_errors;
                echo json_encode($messages);
                return false;
            } else {
                $image_data = $this->upload->data();
            }

        }

        $sql = "UPDATE
					  `content` 
					SET 
				      `title_".$lng."` = ".$this->db_value($title).",
				      `alias_".$lng."` = ".$this->db_value($alias).",
				      `date` = ".$this->db_value($date).",
				      `image` = ".$this->db_value($image).",
				      `meta_desc_".$lng."` = ".$this->db_value($meta_desc).",
				      `meta_tag_".$lng."` = ".$this->db_value($meta_tag).",
				      `short_text_".$lng."` = ".$this->db_value($short_text).",
				      `text_".$lng."` = ".$this->db_value($text).",
				      `status` = ".$this->db_value($status)."
			    WHERE `id`  = ".$this->db_value($id)."   
		";

        $result = $this->db->query($sql);

        if ($result){
            $messages['success'] = 1;
            $messages['message'] = 'Success';
        } else {
            $messages['success'] = 0;
            $messages['error'] = 'Error';
        }

        // Return success or error message
        echo json_encode($messages);
        return true;
    }









    
}
//end of class