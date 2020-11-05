<?php
  class Forms extends Controller{
    public function __construct(){
      if(!isset($_SESSION['user_id'])){
        redirect('users/login');
      }
      // Load Models
      $this->exposureModel = $this->model('Exposure');
    }


    // Load All Exposures
    public function index(){
      $exposures = $this->exposureModel->getExposures();

      $data = [
        'exposures' => $exposures
      ];
      
      $this->view('forms/index', $data);
    }
  }