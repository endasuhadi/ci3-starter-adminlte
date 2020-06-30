<?php

class Dashboard extends CI_Controller {

    function __construct(){
        parent::__construct();
    }

    public function index(){
        $this->template->load("tmp/template","dashboard");
    }

}