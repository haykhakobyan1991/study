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
        $config['max_width']            = '2500';
        $config['max_height']           = '1500';

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

		$this->authorisation();
        $this->load->helper('url');
        $this->load->helper('form');
        $lang = $this->uri->segment(2);
        $data = array();

        $sql = "
            SELECT
                `about_".$lang."` AS `about`,
                `why_apply_".$lang."` AS `why_apply`,
                `why_recruit_".$lang."` AS `why_recruit`,
                `meta_keyword_".$lang."`  AS `meta_keyword`,
                `meta_description_".$lang."`  AS `meta_description`
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
        $data['meta_keyword'] = $row['meta_keyword'];
        $data['meta_description'] = $row['meta_description'];



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
        $meta_keyword = $this->input->post('meta_keyword');
        $meta_description = $this->input->post('meta_description');


        if($n == 1) {
            echo json_encode($messages);
            return false;
        }


        $sql = "UPDATE `about_us`
					SET 
					 `about_".$lang."` = ".$this->db_value($about_us).",
					 `why_apply_".$lang."` = ".$this->db_value($why_apply).",
					 `why_recruit_".$lang."` = ".$this->db_value($why_recruit).",
					 `meta_keyword_".$lang."` = ".$this->db_value($meta_keyword).",
					 `meta_description_".$lang."` = ".$this->db_value($meta_description)."
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

        $this->authorisation();
        $this->load->helper('url');
        $this->load->helper('form');
        $lang = $this->uri->segment(2);
        $data = array();

        $sql = "SELECT * FROM `basic_settings` WHERE `id` = 1";
        $result = $this->db->query($sql);
        $row = $result->row_array();

        $data['logo'] = $row['logo'];
        $data['background_image'] = $row['background_image'];
        $data['meta_keyword'] = $row['meta_keyword_'.$lang];
        $data['meta_description'] = $row['meta_description_'.$lang];

        $this->layout->view('basic_settings', $data, 'add');

    }

    public function basic_settings_ax() {

        $messages = array('success' => '0', 'message' => '', 'error' => '', 'fields' => '');
        $n = 0;

        if ($this->input->server('REQUEST_METHOD') != 'POST') {
            // Return error
            $messages['error']['elements'][] = 'error_message';
            echo json_encode($messages);
            return false;
        }



        $id = '1';
        $meta_keyword = $this->input->post('meta_keyword');
        $meta_description = $this->input->post('meta_description');
        $background_image = '';
        $logo = '';
        $lang = $this->input->post('language');
        $config = $this->upload_config();
        $config['upload_path'] = set_realpath('application/uploads/basic_info');

        if(isset($_FILES['logo']['name']) AND $_FILES['logo']['name'] != '') {
            $this->load->library('upload', $config);
            $this->upload->initialize($config);

            if (!$this->upload->do_upload('logo')) {
                $validation_errors = array('logo' => $this->upload->display_errors());
                $messages['error']['elements'][] = $validation_errors;
                echo json_encode($messages);
                return false;
            }



            $logo_arr = $this->upload->data();

            $logo_img = $logo_arr['file_name'];

            $logo = "`logo` = ".$this->db_value($logo_img).",";

        }


        if(isset($_FILES['background_image']['name']) AND $_FILES['background_image']['name'] != '') {
            $this->load->library('upload', $config);
            $this->upload->initialize($config);

            if (!$this->upload->do_upload('background_image')) {
                $validation_errors = array('background_image' => $this->upload->display_errors());
                $messages['error']['elements'][] = $validation_errors;
                echo json_encode($messages);
                return false;
            }



            $logo_arr = $this->upload->data();

            $background_img = $logo_arr['file_name'];

            $background_image = "`background_image` = ".$this->db_value($background_img).",";

        }



        if($n == 1) {
            echo json_encode($messages);
            return false;
        }


        $sql = "UPDATE `basic_settings`
					SET 
					 ".$background_image."
					 ".$logo."
					 `meta_keyword_".$lang."` = ".$this->db_value($meta_keyword).",
					 `meta_description_".$lang."` = ".$this->db_value($meta_description).",
					 `status` = '1'
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

    public function add_partner_university() {

        //	$this->authorisation();
        $this->load->helper('url');
        $this->load->helper('form');
        $lang = $this->uri->segment(2);
        $data = array();


        $sql_gc = "
            SELECT 
                `id`,
                `title_".$lang."` AS `title`
             FROM
                `grade_converter` 
            WHERE `status` = '1'      
        ";

        $query_gc = $this->db->query($sql_gc);
        $data['grade_converter'] = $query_gc->result_array();




        $this->layout->view('add_partner_university', $data, 'add');

    }

    public function add_partner_university_ax() {

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
        $this->form_validation->set_rules('short_name', 'Short name', 'required');
        $this->form_validation->set_rules('name', 'Name', 'required');
        $this->form_validation->set_rules('overview', 'Overview', 'required');
        $this->form_validation->set_rules('grade_converter', 'Grade Converter', 'required');


        if($this->form_validation->run() == false){
            //validation errors
            $n = 1;

            $validation_errors = array(
                'short_name' => form_error('short_name'),
                'name' => form_error('name'),
                'overview' => form_error('overview'),
                'grade_converter' => form_error('grade_converter'),
            );
            $messages['error']['elements'][] = $validation_errors;
        }

        $background_image = '';




        $lang = $this->input->post('language');
        $short_name = $this->input->post('short_name');
        $name = $this->input->post('name');
        $alias = $this->input->post('alias');
        $grade_converter = $this->input->post('grade_converter');
        $overview = $this->input->post('overview');

        $subject1 = $this->input->post('subject1');
        $subject2 = $this->input->post('subject2');
        $subject3 = $this->input->post('subject3');

        $requirement1 = $this->input->post('requirement1');
        $requirement2 = $this->input->post('requirement2');
        $requirement3 = $this->input->post('requirement3');


        $meta_keyword = $this->input->post('meta_keyword');
        $meta_description = $this->input->post('meta_description');

        $status = '1';
        if($this->input->post('status') != '') {
            $status = $this->input->post('status');
        }

        $config = $this->upload_config();
        $config['upload_path'] = set_realpath('application/uploads/universities');

        if(isset($_FILES['background_image']['name']) AND $_FILES['background_image']['name'] != '' AND $n != 1) {
            $this->load->library('upload', $config);
            $this->upload->initialize($config);

            if (!$this->upload->do_upload('background_image')) {
                $validation_errors = array('background_image' => $this->upload->display_errors());
                $messages['error']['elements'][] = $validation_errors;
                echo json_encode($messages);
                return false;
            }



            $logo_arr = $this->upload->data();

            $background_img = $logo_arr['file_name'];

            $background_image = "`background_image` = ".$this->db_value($background_img).",";

        } else {
            $n = 1;
            $validation_errors = array('background_image' => 'Background image: This field is required.');
            $messages['error']['elements'][] = $validation_errors;
        }


        if($n == 1) {
            echo json_encode($messages);
            return false;
        }




        $sql = "INSERT INTO `partner_university`
                    SET 
                      `short_name_".$lang."` = ".$this->db_value($short_name).",
                      `name_".$lang."` = ".$this->db_value($name).",
                      `alias_".$lang."` = ".$this->db_value($alias).",
                      `overview_".$lang."` = ".$this->db_value($overview).",
                      ".$background_image."
                      `subject1_".$lang."` = ".$this->db_value($subject1).",
                      `subject2_".$lang."` = ".$this->db_value($subject2).",
                      `subject3_".$lang."` = ".$this->db_value($subject3).",
                      `requirement1_".$lang."` = ".$this->db_value($requirement1).",
                      `requirement2_".$lang."` = ".$this->db_value($requirement2).",
                      `requirement3_".$lang."` = ".$this->db_value($requirement3).",
                      `grade_converter_id` = ".$this->db_value($grade_converter).",
                      `meta_keyword_".$lang."` = ".$this->db_value($meta_keyword).",
                      `meta_description_".$lang."` = ".$this->db_value($meta_description).",
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

    public function edit_partner_university() {

        //	$this->authorisation();
        $this->load->helper('url');
        $this->load->helper('form');
        $lng = $this->uri->segment(2);
        $id = $this->uri->segment(4);
        $data = array();

        $sql = "
            SELECT
              `id`,
              `short_name_".$lng."` AS `short_name`,
              `name_".$lng."` AS `name`,
              `alias_".$lng."` AS `alias`,
              `overview_".$lng."` AS `overview`,
              `background_image`,
              `subject1_".$lng."` AS `subject1`,
              `subject2_".$lng."` AS `subject2`,
              `subject3_".$lng."` AS `subject3`,
              `requirement1_".$lng."` AS `requirement1`,
              `requirement2_".$lng."` AS `requirement2`,
              `requirement3_".$lng."` AS `requirement3`,
              `grade_converter_id`,
              `meta_keyword_".$lng."` AS `meta_keyword`,
              `meta_description_".$lng."` AS `meta_description`,
              `status`
            FROM 
              `partner_university`
            WHERE `id` = ".$this->db_value($id)."
            LIMIT 1
        ";

        $query = $this->db->query($sql);
        $num_rows = $query->num_rows();

        if($num_rows != 1) {
            $message = 'Page not found';
            show_error($message, '404', $heading = '404');
            return false;
        }

        $data['result'] = $query->row_array();

        $sql_gc = "
            SELECT 
                `id`,
                `title_".$lng."` AS `title`
             FROM
                `grade_converter` 
            WHERE `status` = '1'      
        ";

        $query_gc = $this->db->query($sql_gc);
        $data['grade_converter'] = $query_gc->result_array();


        $this->layout->view('edit_partner_university', $data, 'add');

    }


    public function edit_partner_university_ax() {

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
        $this->form_validation->set_rules('short_name', 'Short name', 'required');
        $this->form_validation->set_rules('name', 'Name', 'required');
        $this->form_validation->set_rules('overview', 'Overview', 'required');
        $this->form_validation->set_rules('grade_converter', 'Grade Converter', 'required');



        if($this->form_validation->run() == false){
            //validation errors
            $n = 1;

            $validation_errors = array(
                'short_name' => form_error('short_name'),
                'name' => form_error('name'),
                'overview' => form_error('overview'),
                'grade_converter' => form_error('grade_converter'),
            );
            $messages['error']['elements'][] = $validation_errors;
        }

        $background_image = '';

        $lang = $this->input->post('language');
        $id = $this->input->post('partner_university_id');


        $short_name = $this->input->post('short_name');
        $name = $this->input->post('name');
        $alias = $this->input->post('alias');
        $grade_converter = $this->input->post('grade_converter');
        $overview = $this->input->post('overview');

        $subject1 = $this->input->post('subject1');
        $subject2 = $this->input->post('subject2');
        $subject3 = $this->input->post('subject3');

        $requirement1 = $this->input->post('requirement1');
        $requirement2 = $this->input->post('requirement2');
        $requirement3 = $this->input->post('requirement3');


        $meta_keyword = $this->input->post('meta_keyword');
        $meta_description = $this->input->post('meta_description');

        $status = '1';
        if($this->input->post('status') != '') {
            $status = $this->input->post('status');
        }

        $config = $this->upload_config();
        $config['upload_path'] = set_realpath('application/uploads/universities');

        if(isset($_FILES['background_image']['name']) AND $_FILES['background_image']['name'] != '') {
            $this->load->library('upload', $config);
            $this->upload->initialize($config);

            if (!$this->upload->do_upload('background_image')) {
                $validation_errors = array('background_image' => $this->upload->display_errors());
                $messages['error']['elements'][] = $validation_errors;
                echo json_encode($messages);
                return false;
            }



            $logo_arr = $this->upload->data();

            $background_img = $logo_arr['file_name'];

            $background_image = "`background_image` = ".$this->db_value($background_img).",";

        }


        if($n == 1) {
            echo json_encode($messages);
            return false;
        }


        $sql = "UPDATE `partner_university`
                    SET 
                      `short_name_".$lang."` = ".$this->db_value($short_name).",
                      `name_".$lang."` = ".$this->db_value($name).",
                      `alias_".$lang."` = ".$this->db_value($alias).",
                      `overview_".$lang."` = ".$this->db_value($overview).",
                      ".$background_image."
                      `subject1_".$lang."` = ".$this->db_value($subject1).",
                      `subject2_".$lang."` = ".$this->db_value($subject2).",
                      `subject3_".$lang."` = ".$this->db_value($subject3).",
                      `requirement1_".$lang."` = ".$this->db_value($requirement1).",
                      `requirement2_".$lang."` = ".$this->db_value($requirement2).",
                      `requirement3_".$lang."` = ".$this->db_value($requirement3).",
                      `grade_converter_id` = ".$this->db_value($grade_converter).",
                      `meta_keyword_".$lang."` = ".$this->db_value($meta_keyword).",
                      `meta_description_".$lang."` = ".$this->db_value($meta_description).",
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

    public function partner_university() {

        //	$this->authorisation();
        $this->load->helper('url');
        $this->load->helper('form');
        $lang = $this->uri->segment(2);
        $data = array();

        $sql = "
            SELECT
                `partner_university`.`id`,
                `partner_university`.`short_name_".$lang."` AS `short_name`,
                `partner_university`.`name_".$lang."` AS `name`,
                `grade_converter`.`title_".$lang."` AS `grade_converter`,
                `partner_university`.`status`
             FROM
                `partner_university`
             LEFT JOIN `grade_converter` 
                ON `grade_converter`.`id` = `partner_university`.`grade_converter_id`
             WHERE 1      
        ";

        $query = $this->db->query($sql);

        $data['result'] = $query->result_array();


        $this->layout->view('partner_university', $data);

    }


    public function add_grade_converter() {

        //	$this->authorisation();
        $this->load->helper('url');
        $this->load->helper('form');
        $lang = $this->uri->segment(2);
        $data = array();

        $sql = "
            SELECT 
                `id`,
                `title_".$lang."` AS `title`
             FROM
                `grade_converter` 
            WHERE `status` = '1'      
        ";

        $query = $this->db->query($sql);
        $result = $query->result_array();

        $data['grade_converter'] = $result;

        $this->layout->view('add_grade_converter', $data, 'add');

    }


    public function add_grade_converter_ax() {

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
        $this->form_validation->set_rules('title', 'Title', 'required');



        if($this->form_validation->run() == false){
            //validation errors
            $n = 1;

            $validation_errors = array(
                'title' => form_error('title')
            );
            $messages['error']['elements'][] = $validation_errors;
        }


        $lang = $this->input->post('language');
        $title = $this->input->post('title');
        $text = $this->input->post('text');
        $alias = $this->input->post('alias');
        $child = (is_array($this->input->post('child')) ? implode(',', $this->input->post('child')) : '');



        $meta_keyword = $this->input->post('meta_keyword');
        $meta_description = $this->input->post('meta_description');

        $status = '1';
        if($this->input->post('status') != '') {
            $status = $this->input->post('status');
        }


        if($n == 1) {
            echo json_encode($messages);
            return false;
        }



        $sql = "INSERT INTO `grade_converter`
                    SET 
                      `title_".$lang."` = ".$this->db_value($title).",
                      `text_".$lang."` = ".$this->db_value($text).",
                      `alias_".$lang."` = ".$this->db_value($alias).",
                      `child_ids` = ".$this->db_value($child).",
                      `meta_keyword_".$lang."` = ".$this->db_value($meta_keyword).",
                      `meta_description_".$lang."` = ".$this->db_value($meta_description).",
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



    public function edit_grade_converter() {

        //	$this->authorisation();
        $this->load->helper('url');
        $this->load->helper('form');
        $lng = $this->uri->segment(2);
        $id = $this->uri->segment(4);
        $data = array();

        $sql = "
            SELECT
              `id`,
              `title_".$lng."` AS `title`,
              `text_".$lng."` AS `text`,
              `child_ids`,
              `meta_keyword_".$lng."` AS `meta_keyword`,
              `meta_description_".$lng."` AS `meta_description`,
              `status`
            FROM 
              `grade_converter`
            WHERE `id` = ".$this->db_value($id)."
            LIMIT 1
        ";

        $query = $this->db->query($sql);
        $num_rows = $query->num_rows();

        if($num_rows != 1) {
            $message = 'Page not found';
            show_error($message, '404', $heading = '404');
            return false;
        }

        $data['result'] = $query->row_array();

        $sql_gc = "
            SELECT 
                `id`,
                `title_".$lng."` AS `title`
             FROM
                `grade_converter` 
            WHERE `status` = '1'      
        ";

        $query_gc = $this->db->query($sql_gc);
        $data['grade_converter'] = $query_gc->result_array();


        $this->layout->view('edit_grade_converter', $data, 'add');

    }


    public function edit_grade_converter_ax() {

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
        $this->form_validation->set_rules('title', 'Title', 'required');



        if($this->form_validation->run() == false){
            //validation errors
            $n = 1;

            $validation_errors = array(
                'title' => form_error('title')
            );
            $messages['error']['elements'][] = $validation_errors;
        }


        $lang = $this->input->post('language');
        $id = $this->input->post('grade_converter_id');
        $title = $this->input->post('title');
        $text = $this->input->post('text');
        $alias = $this->input->post('alias');
        $child = (is_array($this->input->post('child')) ? implode(',', $this->input->post('child')) : '');



        $meta_keyword = $this->input->post('meta_keyword');
        $meta_description = $this->input->post('meta_description');

        $status = '1';
        if($this->input->post('status') != '') {
            $status = $this->input->post('status');
        }


        if($n == 1) {
            echo json_encode($messages);
            return false;
        }



        $sql = "UPDATE `grade_converter`
                    SET 
                      `title_".$lang."` = ".$this->db_value($title).",
                      `text_".$lang."` = ".$this->db_value($text).",
                      `alias_".$lang."` = ".$this->db_value($alias).",
                      `child_ids` = ".$this->db_value($child).",
                      `meta_keyword_".$lang."` = ".$this->db_value($meta_keyword).",
                      `meta_description_".$lang."` = ".$this->db_value($meta_description).",
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

    public function grade_converter() {

        //	$this->authorisation();
        $this->load->helper('url');
        $this->load->helper('form');
        $lang = $this->uri->segment(2);
        $data = array();

        $sql = "
            SELECT 
                `grade_converter`.`id`,
                `grade_converter`.`title_".$lang."` AS `title`,
                GROUP_CONCAT(CONCAT(\"<span class='badge badge-pill badge-primary m-1'>\", `children`.`title_".$lang."`, \"</span>\") SEPARATOR '' ) AS `children`,
                `grade_converter`.`status`
              FROM 
                `grade_converter`
            LEFT JOIN `grade_converter` AS `children` 
                ON FIND_IN_SET(`children`.`id`, `grade_converter`.`child_ids`)
            WHERE `grade_converter`.`status` = '1'  
             GROUP BY `grade_converter`.`id`     
        ";

        $query = $this->db->query($sql);
        $result = $query->result_array();
        $data['result'] = $result;


        $this->layout->view('grade_converter', $data);

    }


    public function courses() {

        //	$this->authorisation();
        $this->load->helper('url');
        $this->load->helper('form');
        $lang = $this->uri->segment(2);
        $data = array();

        $sql = "
            SELECT 
                `courses`.`id`, 
                `courses`.`title_".$lang."` AS `courses`,
                GROUP_CONCAT(CONCAT(\"<span class='badge badge-pill badge-primary m-1'>\", `special_partners`.`title_".$lang."`, \"</span>\") SEPARATOR '' ) AS `special_partners`,
                `courses`.`status`
              FROM 
                `courses`
            LEFT JOIN `special_partners`  
                ON `special_partners`.`courses_id` = `courses`.`id`
                AND `special_partners`.`status` = '1'
            WHERE 1
            GROUP BY `courses`.`id` 
        ";

        $query = $this->db->query($sql);
        $result = $query->result_array();
        $data['result'] = $result;



        $this->layout->view('courses', $data, 'add');

    }

    public function add_courses() {

        //	$this->authorisation();
        $this->load->helper('url');
        $this->load->helper('form');
        $lang = $this->uri->segment(2);
        $data = array();



        $this->layout->view('add_courses', $data, 'add');

    }


    public function add_courses_ax() {

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
        $this->form_validation->set_rules('title', 'Title', 'required');


        if($this->form_validation->run() == false){
            //validation errors
            $n = 1;

            $validation_errors = array(
                'title' => form_error('title'),
            );
            $messages['error']['elements'][] = $validation_errors;
        }

        $background_image = '';

        $lang = $this->input->post('language');
        $title = $this->input->post('title');
        $alias = $this->input->post('alias');

        $why1 = $this->input->post('why1');
        $why2 = $this->input->post('why2');
        $why3 = $this->input->post('why3');

        $career1 = $this->input->post('career1');
        $career2 = $this->input->post('career2');
        $career3 = $this->input->post('career3');

        $specialist_partners = $this->input->post('specialist_partners');

        $meta_keyword = $this->input->post('meta_keyword');
        $meta_description = $this->input->post('meta_description');

        $status = '1';
        if($this->input->post('status') != '') {
            $status = $this->input->post('status');
        }

        $config = $this->upload_config();
        $config['upload_path'] = set_realpath('application/uploads/courses');

        if(isset($_FILES['background_image']['name']) AND $_FILES['background_image']['name'] != '' AND $n != 1) {
            $this->load->library('upload', $config);
            $this->upload->initialize($config);

            if (!$this->upload->do_upload('background_image')) {
                $validation_errors = array('background_image' => $this->upload->display_errors());
                $messages['error']['elements'][] = $validation_errors;
                echo json_encode($messages);
                return false;
            }



            $logo_arr = $this->upload->data();

            $background_img = $logo_arr['file_name'];

            $background_image = "`background_image` = ".$this->db_value($background_img).",";

        } else {
            $n = 1;
            $validation_errors = array('background_image' => 'Background image: This field is required.');
            $messages['error']['elements'][] = $validation_errors;
        }


        if($n == 1) {
            echo json_encode($messages);
            return false;
        }



        $sql = "INSERT INTO `courses`
                    SET
                      `title_".$lang."` = ".$this->db_value($title).",
                      `alias_".$lang."` = ".$this->db_value($alias).",
                      ".$background_image."
                      `why1_".$lang."` = ".$this->db_value($why1).",
                      `why2_".$lang."` = ".$this->db_value($why2).",
                      `why3_".$lang."` = ".$this->db_value($why3).",
                      `career1_".$lang."` = ".$this->db_value($career1).",
                      `career2_".$lang."` = ".$this->db_value($career2).",
                      `career3_".$lang."` = ".$this->db_value($career3).",
                      `meta_keyword_".$lang."` = ".$this->db_value($meta_keyword).",
                      `meta_description_".$lang."` = ".$this->db_value($meta_description).",
                      `status` = ".$this->db_value($status)."
                ";


        $result = $this->db->query($sql);

        $courses_id = $this->db->insert_id();
        $partner_university_id = $this->input->post('partner_universities_id');

        if(!empty($specialist_partners)) {
            $sql_ = "INSERT INTO `special_partners`
                        (
                         `courses_id`,
                         `title_".$lang."`,
                         `partner_university_id`,
                         `status`
                         )
                    VALUES ";
            foreach ($specialist_partners as $key => $title) {
                $sql_ .= "
                (
                     ".$this->db_value($courses_id).",
                     '".$title."',
                     ".$this->db_value($partner_university_id[$key]).",
                     '1'
                ),";
            }
            $sql_ = substr($sql_, 0, -1);
            $result_ = $this->db->query($sql_);
        }


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


    public function edit_courses() {

        //	$this->authorisation();
        $this->load->helper('url');
        $this->load->helper('form');
        $lang = $this->uri->segment(2);
        $id = $this->uri->segment(4);
        $data = array();

        $sql = "
            SELECT 
              `id`,
              `title_".$lang ."` AS `title`,
              `alias_".$lang ."` AS `alias`,
              `why1_".$lang ."` AS `why1`,
              `why2_".$lang ."` AS `why2`,
              `why3_".$lang ."` AS `why3`,
              `career1_".$lang ."` AS `career1`,
              `career2_".$lang ."` AS `career2`,
              `career3_".$lang ."` AS `career3`,
              `background_image`,
              `meta_keyword_".$lang ."` AS `meta_keyword`,
              `meta_description_".$lang ."` AS `meta_description`,
              `status`
            FROM 
              `courses`
            WHERE `id` = '".$id."'    
        ";

        $query = $this->db->query($sql);
        $num_rows = $query->num_rows();

        if($num_rows != 1) {
            $message = 'Page not found';
            show_error($message, '404', $heading = '404');
            return false;
        }

        $data['result'] = $query->row_array();

        $sql_partners = "
            SELECT 
              `id`,
              `title_".$lang."` AS `title`,
              `partner_university_id`,
              `status` 
            FROM
              `special_partners` 
            WHERE `status` = 1  
             AND `courses_id` = '".$id."' 
        ";

        $query_partners = $this->db->query($sql_partners);
        $data['result_partners'] = $query_partners->result_array();

        $this->layout->view('edit_courses', $data, 'add');

    }


    public function edit_courses_ax() {

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
        $this->form_validation->set_rules('title', 'Title', 'required');


        if($this->form_validation->run() == false){
            //validation errors
            $n = 1;

            $validation_errors = array(
                'title' => form_error('title'),
            );
            $messages['error']['elements'][] = $validation_errors;
        }

        $background_image = '';

        $id = $this->input->post('courses_id');

        $lang = $this->input->post('language');
        $title = $this->input->post('title');
        $alias = $this->input->post('alias');

        $why1 = $this->input->post('why1');
        $why2 = $this->input->post('why2');
        $why3 = $this->input->post('why3');

        $career1 = $this->input->post('career1');
        $career2 = $this->input->post('career2');
        $career3 = $this->input->post('career3');

        $specialist_partners = $this->input->post('specialist_partners');

        $meta_keyword = $this->input->post('meta_keyword');
        $meta_description = $this->input->post('meta_description');

        $status = '1';
        if($this->input->post('status') != '') {
            $status = $this->input->post('status');
        }

        $config = $this->upload_config();
        $config['upload_path'] = set_realpath('application/uploads/courses');

        if(isset($_FILES['background_image']['name']) AND $_FILES['background_image']['name'] != '' AND $n != 1) {
            $this->load->library('upload', $config);
            $this->upload->initialize($config);

            if (!$this->upload->do_upload('background_image')) {
                $validation_errors = array('background_image' => $this->upload->display_errors());
                $messages['error']['elements'][] = $validation_errors;
                echo json_encode($messages);
                return false;
            }



            $logo_arr = $this->upload->data();

            $background_img = $logo_arr['file_name'];

            $background_image = "`background_image` = ".$this->db_value($background_img).",";

        }


        if($n == 1) {
            echo json_encode($messages);
            return false;
        }



        $sql = "UPDATE `courses`
                    SET
                      `title_".$lang."` = ".$this->db_value($title).",
                      `alias_".$lang."` = ".$this->db_value($alias).",
                      ".$background_image."
                      `why1_".$lang."` = ".$this->db_value($why1).",
                      `why2_".$lang."` = ".$this->db_value($why2).",
                      `why3_".$lang."` = ".$this->db_value($why3).",
                      `career1_".$lang."` = ".$this->db_value($career1).",
                      `career2_".$lang."` = ".$this->db_value($career2).",
                      `career3_".$lang."` = ".$this->db_value($career3).",
                      `meta_keyword_".$lang."` = ".$this->db_value($meta_keyword).",
                      `meta_description_".$lang."` = ".$this->db_value($meta_description).",
                      `status` = ".$this->db_value($status)."
                 WHERE `id` =  ".$this->db_value($id)."   
                ";


        $result = $this->db->query($sql);


        $partner_university_id = $this->input->post('partner_universities_id');

        $sql_update = "
            UPDATE  `special_partners` SET `status` = '-2' WHERE `courses_id` = ".$this->db_value($id)." /*todo a mnacac leunere*/ 
        ";

        $this->db->query($sql_update);

        if(!empty($specialist_partners)) {
            $sql_ = "INSERT INTO `special_partners`
                        (
                         `courses_id`,
                         `title_".$lang."`,
                         `partner_university_id`,
                         `status`
                         )
                    VALUES ";
            foreach ($specialist_partners as $key => $title) {
                $sql_ .= "
                (
                     ".$this->db_value($id).",
                     '".$title."',
                     ".$this->db_value($partner_university_id[$key]).",
                     '1'
                ),";
            }
            $sql_ = substr($sql_, 0, -1);
            $result_ = $this->db->query($sql_);
        }


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


    public function search_partner_universities() {
        $lang = $this->uri->segment(2);

        $sql = "SELECT `id`, `name_".$lang."` AS `name` FROM `partner_university` WHERE `status` = 1";
        $query = $this->db->query($sql);

        echo json_encode($query->result_array());
        return true;
    }









    
}
//end of class