<?php

class Company extends BaseController
{
    
    public function __construct()
    {
        $this->companyModel = $this->model('Company');
    }

    public function index() //default method and view
    {
        $this->view('company/login');
    }


}