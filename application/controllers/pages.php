<?php
/**
 * Created by IntelliJ IDEA.
 * User: yoyojyv
 * Date: 2013. 12. 19.
 * Time: 오후 9:20
 */

class Pages extends CI_Controller {

    public function view($page = 'home') {

        log_message('debug', '**page : '.$page);  // 'debug' 레벨로 로그 찍기

        if ( ! file_exists('application/views/pages/'.$page.'.php'))
        {
            // Whoops, we don't have a page for that!
            show_404();
        }

        $data['title'] = ucfirst($page); // Capitalize the first letter

        $this->load->view('templates/header', $data);
        $this->load->view('pages/'.$page, $data);
        $this->load->view('templates/footer', $data);
    }

} 