<?php
if (! defined('BASEPATH'))
    exit('No direct script access allowed');

class chat extends Front_Controller
{

    // ------------------------------------------------------------
    /**
     */
    public function __construct()
    {
        parent::__construct();
    }

    // ------------------------------------------------------------

    /**
     */
    public function index()
    {
        $this->load->view('chat/testchat');
    }
}
?>