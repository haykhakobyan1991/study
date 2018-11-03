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
				LEFT JOIN `role_permission` 
				    ON `role_permission`.`permission_id` = `permission`.`id`	
				LEFT JOIN `role` 
				    ON `role_permission`.`role_id` = `role`.`id`
				LEFT JOIN `user` 
				    ON `user`.`role_id` = `role`.`id`
				WHERE `user`.`id` = '".$user_id."' 
				 AND `permission`.`status` = '1' 
				 AND `controller` = '".$controller."' 
				 AND `page` = '".$page."'
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


	public function about_us() {

	//	$this->authorisation();
        $this->load->helper('url');
        $this->load->helper('form');
        $lang = $this->uri->segment(2);
        $data = array();

        $sql = "
            SELECT
                `about_".$lang."` AS `about`,
                `why_apply_".$lang."` AS `why_apply`,
                `why_recruit_".$lang."` AS `why_recruit`
            FROM
               `about_us`
            WHERE `status` = '1'
            LIMIT 1
         ";

        $result = $this->db->query($sql);

        $row = $result->row_array();

        $data['about'] = $row['about'];
        $data['why_apply'] = $row['why_apply'];
        $data['why_recruit'] = $row['why_recruit'];



        $this->layout->view('about_us', $data, 'add');

    }

	public function about_us_ax() {

		$messages = array('success' => '0', 'message' => '', 'error' => '', 'fields' => '');
		$n = 0;

		if ($this->input->server('REQUEST_METHOD') != 'POST') {
            // Return error
            $messages['error'] = 'error_message';
            $this->access_denied();
            return false;
        }




        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div>', '</div>');
        $this->form_validation->set_rules('about_us', 'About us', 'required');
        $this->form_validation->set_rules('why_apply', 'Why apply with us?', 'required');
        $this->form_validation->set_rules('why_recruit', 'Why recruit with us?', 'required');



        if($this->form_validation->run() == false){
            //validation errors
            $n = 1;

            $validation_errors = array(
                'about_us' => form_error('about_us'),
                'why_apply' => form_error('why_apply'),
                'why_recruit' => form_error('why_recruit')
            );
            $messages['error']['elements'][] = $validation_errors;
        }

        $id = '1';
        $lang = $this->input->post('language');
        $about_us = $this->input->post('about_us');
        $why_apply = $this->input->post('why_apply');
        $why_recruit = $this->input->post('why_recruit');


        if($n == 1) {
            echo json_encode($messages);
            return false;
        }


        $sql = "UPDATE `about_us`
					SET 
					 `about_".$lang."` = ".$this->db_value($about_us).",
					 `why_apply_".$lang."` = ".$this->db_value($why_apply).",
					 `why_recruit_".$lang."` = ".$this->db_value($why_recruit)."
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


    public function basic_settings() {

        //	$this->authorisation();
        $this->load->helper('url');
        $this->load->helper('form');
        $lang = $this->uri->segment(2);
        $data = array();



        $this->layout->view('basic_settings', $data, 'add');

    }

    public function partner_university() {

        //	$this->authorisation();
        $this->load->helper('url');
        $this->load->helper('form');
        $lang = $this->uri->segment(2);
        $data = array();



        $this->layout->view('partner_university', $data, 'add');

    }

    public function grade_converter() {

        //	$this->authorisation();
        $this->load->helper('url');
        $this->load->helper('form');
        $lang = $this->uri->segment(2);
        $data = array();



        $this->layout->view('grade_converter', $data, 'add');

    }


    public function courses() {

        //	$this->authorisation();
        $this->load->helper('url');
        $this->load->helper('form');
        $lang = $this->uri->segment(2);
        $data = array();



        $this->layout->view('courses', $data, 'add');

    }

    public function requirements() {

        //	$this->authorisation();
        $this->load->helper('url');
        $this->load->helper('form');
        $lang = $this->uri->segment(2);
        $data = array();



        $this->layout->view('requirements', $data, 'add');

    }

    public function testimonials() {

        //	$this->authorisation();
        $this->load->helper('url');
        $this->load->helper('form');
        $lang = $this->uri->segment(2);
        $data = array();



        $this->layout->view('testimonials', $data, 'add');

    }

    public function events() {

        //	$this->authorisation();
        $this->load->helper('url');
        $this->load->helper('form');
        $lang = $this->uri->segment(2);
        $data = array();



        $this->layout->view('events', $data, 'add');

    }

    public function contact() {

        //	$this->authorisation();
        $this->load->helper('url');
        $this->load->helper('form');
        $lang = $this->uri->segment(2);
        $data = array();



        $this->layout->view('contact', $data, 'add');

    }



    /**
     * @return bool
     */
    public function change_lang() {

        if ($this->input->server('REQUEST_METHOD') != 'POST') {
            $this->access_denied();
            return false;
        }


        $new_lang = $this->input->post('lang');
        $current_url = $this->input->post('current_url');
        $start = 0;
        $new_url = '';
        $url_array = explode(base_url('admin/'), $current_url);
        $url = array();
        $all_lang_arr = array('hy', 'fr', 'en');
        if (isset($url_array[1])) {
            $url = explode('/', $url_array[1]);
        }
        if (isset($url[0]) && in_array($url[0], $all_lang_arr)) {
            $start = 1;
        }
        for ($i = $start; $i < count($url); $i++) {
            $new_url .= '/' . $url[$i];
        }
        echo base_url('admin/'.$new_lang . $new_url);
        return true;
    }









    
}
//end of class