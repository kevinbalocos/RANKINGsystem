<?php
defined('BASEPATH') or exit('No direct script access allowed');

class ConFacultymanual extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('auth_model');
        $this->load->library('session');
        $this->load->library('form_validation');
        $this->load->database();
        $this->load->model('admin_model');
        $this->load->model('home_model');
        $this->load->model('model_faculty');
        $this->load->model('model_faculty_manual');

        date_default_timezone_set('Asia/Manila');
    }



    public function adminManualFaculty()
    {
        $this->load->view('adminHomepage/adminFacultyManual');
    }
    public function userManualFaculty()
    {
        $this->load->view('Homepage/userFacultyManual');
    }


}
