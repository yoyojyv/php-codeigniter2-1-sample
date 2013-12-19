<?php
/**
 * Created by IntelliJ IDEA.
 * User: yoyojyv
 * Date: 2013. 12. 19.
 * Time: 오후 8:29
 */

class Home extends CI_Controller {

    public function index() {
        $this->load->view('homepage');
    }

} 