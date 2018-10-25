<?php
/**
 * Created by PhpStorm.
 * User: Tiko
 * Date: 26.11.2017
 * Time: 19:43
 */

class Layout
{

    public $title_separator;

    // the title for the layout
    private $ci;

    // title separator
    // you can change this in the construct
    private $title;

    // holds the css and js files
    private $includes;

    /**
     * Layout constructor.
     */
    public function __construct() {

        $this->ci = &get_instance();

        $this->title = NULL;
        $this->title_separator = ' ';

        $this->includes = array();

    }

    /**
     * @param null $title
     */
    public function set_title($title = NULL) {
        $this->title = $title;
    }

    /**
     * @param $type
     * @param $file
     * @param null $options
     * @param bool $prepend_base_url
     * @return $this
     */
    public function add_includes($type, $file, $options = NULL, $prepend_base_url = TRUE) {

        if ($prepend_base_url) {

            $this->ci->load->helper('url');
            $file = base_url() . $file;

        }

        $this->includes[$type][] = array(

            'file' => $file,
            'options' => $options


        );

        // allows chaining
        return $this;

    }

    /**
     * @param $name
     * @param array $data
     * @param string $layout
     */
    public function view($name, $data = array(), $layout = 'default') {

        // get the contents of the view and store it
        $view = $this->ci->load->view($name, $data, TRUE);

        // set the title
        $title = '';

        if ($this->title !== NULL) {

            $title = $this->title . $this->title_separator;

        }


        $this->ci->load->view('layouts/' . $layout, array(

            'title' => $title,
            'includes' => $this->includes,
            'content' => $view

        ));

    }

}
/* End of file layout.php */
/* Location: ./application/libraries/layout.php */