<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Main extends CI_Controller {


    public function __construct() {

        parent::__construct();

        // load the library
        $this->load->library('layout');

        // load the helper
        $this->load->helper('language');

        $lng = $this->lng();
        $this->load_lang('translate', $lng);
    }



    /**
     * @return bool
     */
    public function access_denied() {
        $message = 'access denied';
        show_error($message, '403', $heading = '403');
        return false;
    }


    /**
     * @return string
     * @todo loader
     */
    private function lng() {
        if($this->uri->segment(1) != '') {
            return $this->uri->segment(1);
        } else {
            return 'hy';
        }
    }



    /**
     * @param $data
     * @return string
     * @todo loader
     */
    public function hash($data) {
        return md5($data);
    }


    /**
     * @param null $value
     * @return string
     * @todo loader
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
     * @param $file
     * @param $lang
     * @return mixed
     * @todo loader
     */
    public function load_lang($file, $lang) {

        if ($lang == 'hy') {
            return $this->lang->load($file, 'armenian');
        } elseif ($lang == 'fr') {
            return $this->lang->load($file, 'france');
        } elseif ($lang == 'en') {
            return $this->lang->load($file, 'english');
        } else {
            return $this->lang->load($file, 'armenian');
        }

    }

    public function meta_tags() { // todo change



        /*meta tags*/
        $data = array();
        $data['meta_tags'] = meta('description', 'description');
        $data['meta_tags'] .= meta('keywords', 'keywords');
        $data['meta_tags'] .= meta('og:site_name', 'og:site_name');
        $data['meta_tags'] .= meta('og:type', 'og:type');
        $data['meta_tags'] .= meta('og:title', 'og:title');
        $data['meta_tags'] .= meta('og:url', current_url());
        $data['meta_tags'] .= meta('og:image', 'og:image');


        return $data['meta_tags'];


    }


    public function index() {


        // helpers
        $this->load->helper('url');
        $this->load->helper('form');
        // language
        $lng = $this->lng();
        // data
        $data = array();
        // get meta tags
        $data['meta_tags'] = $this->meta_tags();

        $sql = "
            SELECT
                `id`,
                `title_".$lng."` AS `title`,
                `status` 
             FROM 
                `basic_settings`  
            WHERE status = 1
            LIMIT 1 
                 
        ";

        $result = $this->db->query($sql);

        $row = $result->row_array();

        $data['title'] = $row['title'];


        //view
        $this->layout->view('index', $data, 'deff');


    }


    public function about() {

        // helpers
        $this->load->helper('url');
        $this->load->helper('form');
        // language
        $lng = $this->lng();
        // data
        $data = array();
        // get meta tags
        $data['meta_tags'] = $this->meta_tags();

        $sql = "
            SELECT
                `about_".$lng."` AS `about`,
                `why_apply_".$lng."` AS `why_apply`,
                `why_recruit_".$lng."` AS `why_recruit`
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


        //view
        $this->layout->view('about', $data, 'deff');



    }

    public function partner_university() {

        // helpers
        $this->load->helper('url');
        $this->load->helper('form');
        // data
        $data = array();
        // language
        $lng = $this->lng();
        $data['lng'] = $lng;
        // get meta tags
        $data['meta_tags'] = $this->meta_tags();


        $sql = "
            SELECT 
                `short_name_".$lng."` AS `short_name`, 
                `alias_".$lng."` AS `alias`  
              FROM 
                `partner_university` 
            WHERE `status` = '1'
        ";

        $query = $this->db->query($sql);
        $data['result'] = $query->result_array();

        //view
        $this->layout->view('partner_university', $data, 'deff');
    }


    public function courses() {

        // helpers
        $this->load->helper('url');
        $this->load->helper('form');
        // language
        $lng = $this->lng();
        // data
        $data = array();
        // get meta tags
        $data['meta_tags'] = $this->meta_tags();


        //view
        $this->layout->view('courses', $data, 'deff');



    }

    public function testimonials() {

        // helpers
        $this->load->helper('url');
        $this->load->helper('form');
        // language
        $lng = $this->lng();
        // data
        $data = array();
        // get meta tags
        $data['meta_tags'] = $this->meta_tags();


        //view
        $this->layout->view('testimonials', $data, 'deff');

    }

    public function events() {

        // helpers
        $this->load->helper('url');
        $this->load->helper('form');
        // language
        $lng = $this->lng();
        // data
        $data = array();
        // get meta tags
        $data['meta_tags'] = $this->meta_tags();


        //view
        $this->layout->view('events', $data, 'deff');

    }

    public function register() {

        // helpers
        $this->load->helper('url');
        $this->load->helper('form');
        // language
        $lng = $this->lng();
        // data
        $data = array();
        // get meta tags
        $data['meta_tags'] = $this->meta_tags();

        $sql = "
            SELECT 
                `id`,
                `title_".$lng."` AS `title`,
                `status`
            FROM
                `country`
            WHERE `status` = '1'        
        ";

        $query = $this->db->query($sql);
        $data['country'] = $query->result_array();


        //view
        $this->layout->view('register', $data, 'deff');

    }

    public function register_ax() {

        if ($this->input->server('REQUEST_METHOD') != 'POST') {
            // Return error
            $this->access_denied();
            return false;
        }

        $messages = array('success' => '0', 'message' => '', 'error' => '', 'fields' => '');
        $n = 0;
        //todo
        $first_name = $this->input->post('first_name');
        $last_name = $this->input->post('last_name');
        $email = $this->input->post('email');
        $birthday = $this->input->post('birthday');
        $username = $this->input->post('username');
        $password = $this->input->post('password');
        $reg_code = $this->reg_code();

        $lng = $this->lng();
        $this->load_lang('translate', $lng);


        if ($first_name == '') {
            $n = 1;
            $validation_errors = array('first_name' => lang("field_required"));
            $messages['error']['elements'][] = $validation_errors;
        }

        if ($last_name == '') {
            $n = 1;
            $validation_errors = array('last_name' => lang("field_required"));
            $messages['error']['elements'][] = $validation_errors;
        }

        if ($username == '') {
            $n = 1;
            $validation_errors = array('username' => lang("field_required"));
            $messages['error']['elements'][] = $validation_errors;
        }

        if ($email == '') {
            $n = 1;
            $validation_errors = array('email' => lang("field_required"));
            $messages['error']['elements'][] = $validation_errors;
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $n = 1;
            $validation_errors = array('email' => lang("not_valid_email"));
            $messages['error']['elements'][] = $validation_errors;
        }


        if ($password == '') {
            $n = 1;
            $validation_errors = array('password' => lang("field_required"));
            $messages['error']['elements'][] = $validation_errors;
        }


        if (strlen($password) < 6) {
            $n = 1;
            $validation_errors = array('password' => lang("minimum_6_characters"));
            $messages['error']['elements'][] = $validation_errors;
        }



        $sql_email_unique = "
            SELECT `id` FROM `user` WHERE `email` = '".$email."'
        ";

        $query = $this->db->query($sql_email_unique);
        $num_rows = $query->num_rows();

        if($num_rows > '0') {
            $n = 1;
            $validation_errors = array('email' => lang("email_is_not_unique"));
            $messages['error']['elements'][] = $validation_errors;
        }

        $sql_username_unique = "
            SELECT `id` FROM `user` WHERE `username` = '".$username."'
        ";

        $query = $this->db->query($sql_username_unique);
        $num_rows = $query->num_rows();

        if($num_rows > '0') {
            $n = 1;
            $validation_errors = array('username' => lang("username_is_not_unique"));
            $messages['error']['elements'][] = $validation_errors;
        }


        if($n == 1) {
            echo json_encode($messages);
            return false;
        }



        $this->smtp_mailing();

        $this->email->to($email);
        $this->email->subject('Активация аккаунта');
        $this->email->message('
            <div>
                <p>Это письмо отправлено с сайта <a href="http://new.dilemmatik.ru/">http://new.dilemmatik.ru/</a></p>
                <p>------------------------------------------------</p>
                <p> Ваш логин и пароль на сайте:</p>
                <p> ------------------------------------------------</p>
                <p>Логин: '.$username.'</p>
                <p> Пароль: '.$password.'</p>
                <p>Для активации Вашего аккаунта, зайдите по следующей ссылке:</p>
                <p><a href="http://new.dilemmatik.ru/Main/activation/'.$reg_code.'">http://new.dilemmatik.ru/Main/activation/'.$reg_code.'</a></p>
		    </div>
		');

        if(!$this->email->send()) {
            $messages['success'] = 0;
            $messages['error'] = $this->email->print_debugger();
            echo json_encode($messages);
            return false;
        }


        $sql = "INSERT INTO `user`
					SET 
					 `role_id` = '4',
					 `username` = ".$this->db_value($username).",
					 `first_name` = ".$this->db_value($first_name).",
					 `last_name` = ".$this->db_value($last_name).",
					 `email` = ".$this->db_value($email).",
					 `birthday` = ".$this->db_value($birthday).",
					 `reg_code` = ".$this->db_value($reg_code).",
					 `password` = ".$this->db_value($this->hash($password)).",
					 `status` = '-1'";


        $result = $this->db->query($sql);


        if($result) {
            $messages['success'] = 1;
            $messages['message'] = lang('success_reg');

        } else {
            $messages['success'] = 0;
            $messages['error'] = 'Error';
        }


        echo json_encode($messages);
        return true;

    }


    public function contact() {

        // helpers
        $this->load->helper('url');
        $this->load->helper('form');
        // language
        $lng = $this->lng();
        // data
        $data = array();
        // get meta tags
        $data['meta_tags'] = $this->meta_tags();


        //view
        $this->layout->view('contact', $data, 'deff');

    }


    public function university() {

        // helpers
        $this->load->helper('url');
        $this->load->helper('form');
        // data
        $data = array();
        // language
        $lng = $this->lng();
        $data['lng'] = $lng;
        // get meta tags
        $data['meta_tags'] = $this->meta_tags();

        $alias = $this->uri->segment(3);

        $sql = "
            SELECT
              `partner_university`.`id`,
              `partner_university`.`short_name_".$lng."` AS `short_name`,
              `partner_university`.`name_".$lng."` AS `name`,
              `partner_university`.`alias_".$lng."` AS `alias`,
              `partner_university`.`overview_".$lng."` AS `overview`,
              `partner_university`.`background_image`,
              `partner_university`.`subject1_".$lng."` AS `subject1`,
              `partner_university`.`subject2_".$lng."` AS `subject2`,
              `partner_university`.`subject3_".$lng."` AS `subject3`,
              `partner_university`.`requirement1_".$lng."` AS `requirement1`,
              `partner_university`.`requirement2_".$lng."` AS `requirement2`,
              `partner_university`.`requirement3_".$lng."` AS `requirement3`,
              `grade_converter`.`alias_".$lng."` AS `grade_converter`,
              `partner_university`.`meta_keyword_".$lng."` AS `meta_keyword`,
              `partner_university`.`meta_description_".$lng."` AS `meta_description`,
              `partner_university`.`status`
            FROM  
              `partner_university`
            LEFT JOIN `grade_converter`
                ON `grade_converter`.`id` =  `partner_university`.`grade_converter_id`
            WHERE `partner_university`.`status` = '1'
             AND `partner_university`.`alias_".$lng."` = '".$alias."'
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



        //view
        $this->layout->view('single_university', $data, 'deff');

    }

    public function grade_converter() {

        // helpers
        $this->load->helper('url');
        $this->load->helper('form');
        // data
        $data = array();
        // language
        $lng = $this->lng();
        $data['lng'] = $lng;
        // get meta tags
        $data['meta_tags'] = $this->meta_tags();

        $alias = $this->uri->segment(3);


        $sql_num = "
            SELECT
                `id`
              FROM
               `grade_converter`    
            WHERE `grade_converter`.`status` = '1'  
             AND `grade_converter`.`alias_".$lng."` = '".$alias."'
           LIMIT 1  
        ";

        $query_num = $this->db->query($sql_num);
        $num_rows = $query_num->num_rows();

        if($num_rows != 1) {
            $message = 'Page not found';
            show_error($message, '404', $heading = '404');
            return false;
        }

        $sql = "
            SELECT 
                `grade_converter`.`id`,
                `grade_converter`.`title_".$lng."` AS `title`,
                `grade_converter`.`text_".$lng."` AS `text`,
                `children`.`title_".$lng."` AS `children`,
                `children`.`alias_".$lng."` AS `children_alias`,
                `children`.`text_".$lng."` AS `children_text`,
                `grade_converter`.`status`
              FROM 
                `grade_converter`
            LEFT JOIN `grade_converter` AS `children` 
                ON FIND_IN_SET(`children`.`id`, `grade_converter`.`child_ids`)
            WHERE `grade_converter`.`status` = '1'  
             AND `children`.`status` = '1'
             AND `grade_converter`.`alias_".$lng."` = '".$alias."'
        ";

        $query = $this->db->query($sql);
        $result = $query->result_array();

        $result_array = array();

        $grade_converter_id = '';
        foreach ($result as $val) {
            if($grade_converter_id != $val['id']) {
                $result_array['result'] = $query->row_array();
            }
            $grade_converter_id = $val['id'];
            $result_array['children']['title'][] = $val['children'];
            $result_array['children']['alias'][] = $val['children_alias'];
            $result_array['children']['text'][] = $val['children_text'];
        }

        $data['result'] = $result_array['result'];
        $data['children'] = $result_array['children'];


        //view
        $this->layout->view('grade_converter', $data, 'deff');

    }

    public function us_school_diploma_conversion() {

        // helpers
        $this->load->helper('url');
        $this->load->helper('form');
        // language
        $lng = $this->lng();
        // data
        $data = array();
        // get meta tags
        $data['meta_tags'] = $this->meta_tags();


        //view
        $this->layout->view('us_school_diploma_conversion', $data, 'deff');

    }

    public function abitur() {

        // helpers
        $this->load->helper('url');
        $this->load->helper('form');
        // language
        $lng = $this->lng();
        // data
        $data = array();
        // get meta tags
        $data['meta_tags'] = $this->meta_tags();


        //view
        $this->layout->view('abitur', $data, 'deff');

    }

    public function business_management() {

        // helpers
        $this->load->helper('url');
        $this->load->helper('form');
        // language
        $lng = $this->lng();
        // data
        $data = array();
        // get meta tags
        $data['meta_tags'] = $this->meta_tags();


        //view
        $this->layout->view('business_management', $data, 'deff');

    }

    public function visa_information() {

        // helpers
        $this->load->helper('url');
        $this->load->helper('form');
        // language
        $lng = $this->lng();
        // data
        $data = array();
        // get meta tags
        $data['meta_tags'] = $this->meta_tags();


        //view
        $this->layout->view('visa_information', $data, 'deff');

    }

    public function requirements() {

        // helpers
        $this->load->helper('url');
        $this->load->helper('form');
        // language
        $lng = $this->lng();
        // data
        $data = array();
        // get meta tags
        $data['meta_tags'] = $this->meta_tags();


        //view
        $this->layout->view('requirements', $data, 'deff');

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
        $alias = $this->input->post('alias');
        $page = $this->input->post('page');
        $start = 0;
        $new_url = '';
        $url_array = explode(base_url(), $current_url);
        $url = array();
        $all_lang_arr = array('hy', 'fr', 'en');

        if (isset($url_array[1])) {
            $url = explode('/', $url_array[1]);
        }

        if (in_array($url[0], $all_lang_arr)) {
            $start = 1;
        }



        if($page == 'university') {

            $sql = "
                SELECT 
                   `alias_".$new_lang."` AS `new_alias` 
                  FROM 
                    `partner_university`
                WHERE `alias_".$url[0]."` = '".$alias."'
                 AND `status` = '1'
            ";

            $query = $this->db->query($sql);

            $row = $query->row_array();

            $url[2] = $row['new_alias'];

        }


        for ($i = $start; $i < count($url); $i++) {
            $new_url .= '/' . $url[$i];
        }
        echo base_url($new_lang . $new_url);
        return true;
    }










}
//end of class