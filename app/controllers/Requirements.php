<?php
  class Requirements extends Controller{
    public function __construct(){
      if(!isset($_SESSION['user_id'])){
        redirect('users/login');
      }
      // Load Models
      $this->requirementModel = $this->model('Requirement');
      $this->chapterModel = $this->model('Chapter');
      $this->riskModel = $this->model('Risk');
      $this->exposureModel = $this->model('Exposure');
    }

    // Load All Requirements
    public function index(){
      $requirements = $this->requirementModel->getRequirements();

      $data = [
        'requirements' => $requirements
      ];
      
      $this->view('requirements/index', $data);
    }

    // Show Single Requirement
    public function show($id){
      $requirement = $this->requirementModel->getRequirementById($id);
      $relatedRisks = $this->riskModel->getRiskByReq($id);
      $notRelatedRisks = $this->riskModel->getRiskByNotReq($id);
      $relatedExposures = $this->exposureModel->getExposuresByReq($id);
      $notRelatedExposures = $this->exposureModel->getExposuresByNotReq($id);

      $data = [
        'requirement' => $requirement,
        'relatedRisks' => $relatedRisks,
        'notRelatedRisks' => $notRelatedRisks,
        'relatedExposures' => $relatedExposures,
        'notRelatedExposures' => $notRelatedExposures
      ];

      $this->view('requirements/show', $data);
    }

    // Add Requirement
    public function add(){
      if($_SERVER['REQUEST_METHOD'] == 'POST'){
        // Sanitize POST
        $_POST  = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
        $chapters = $this->chapterModel->getChapters();
        $relevant = isset($_POST['relevant']) ? 1 : 0;
        $data = [
          'requirement' => trim($_POST['requirement']),
          'description' => trim($_POST['description']),
          'area' => trim($_POST['area']),
          'standard' => trim($_POST['standard']),
          'examples' => trim($_POST['examples']),
          'chapters_id' => $_POST['chapters_id'],
          'relevant' => $relevant,
          'requirement_err' => '',
          'description_err' => '',
          'area_err' => '',
          'standard_err' => '',
          'examples_err' => '',
          'chapters_id_err' => '',
          'relevant_err' => '',
          'chapters' => $chapters
        ];

         // Validate Requirement
         if(empty($data['requirement'])){
          $data['requirement_err'] = 'Please enter Requirement';
          // Validate Description
          if(empty($data['description'])){
            $data['description_err'] = 'Please enter Description';
          }
        }

        // Make sure there are no errors
        if(empty($data['requirement_err']) && empty($data['description_err'])){
          // Validation passed
          //Execute
          if($this->requirementModel->addRequirement($data)){
            // Redirect to login
            flash('requirement_added', 'Requirement Added');
            redirect('requirements');
          } else {
            die('Something went wrong');
          }
        } else {
          // Load view with errors
          $this->view('requirements/add', $data);
        }

      } else {
        $chapters = $this->chapterModel->getChapters();
        $data = [
          'requirement' => '',
          'description' => '',
          'area' => '',
          'standard' => '',
          'examples' => '',
          'chapters_id' => '',
          'relevant' => '',
          'chapters' => $chapters
          ];

        $this->view('requirements/add', $data);
      }
    }

    // Update related Risks to a specific Requirement
    public function relation($id){
      if($_SERVER['REQUEST_METHOD'] == 'POST'){
        // Sanitize POST
        //$_POST  = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
        
        if($_POST['action'] == 'removeRisk'){
          $id_remove = $_POST['id_remove'];
          $id_remove = array_map('intval',$id_remove); // sanitise the retreived array
          $id = intval($id);
          echo '<pre>' . var_dump($id_remove) . '</pre>';
          $i = 0;
          foreach($id_remove as $risks_id){
            $i++;
            $data = [
              'requirements_id' => $id,
              'risks_id' => $risks_id
            ];
            $this->requirementModel->removeRiskFromReq($data); 
          }
          // Redirect
          flash('requirement_message', $i . ' selected Risk(s) removed');
          redirect('requirements/show', $id);
        }
        elseif($_POST['action'] == 'addRisk'){
          $id_add = $_POST['id_add'];
          $id_add = array_map('intval',$id_add); // sanitise the retreived array
          $id = intval($id);
          $i = 0;
          foreach($id_add as $risks_id){
            $i++;
            $data = [
              'requirements_id' => $id,
              'risks_id' => $risks_id
            ];
            $this->requirementModel->addRiskToReq($data);
          }
          // Redirect
          flash('requirement_message', $i . ' selected Risk(s) added');
          redirect('requirements/show', $id);
        }
        elseif($_POST['action'] == 'removeExposure'){
          $id_remove = $_POST['id_remove'];
          $id_remove = array_map('intval',$id_remove); // sanitise the retreived array
          $id = intval($id);
          echo '<pre>' . var_dump($id_remove) . '</pre>';
          $i = 0;
          foreach($id_remove as $exposures_id){
            $i++;
            $data = [
              'requirements_id' => $id,
              'exposures_id' => $exposures_id
            ];
            $this->requirementModel->removeExposureFromReq($data); 
          }
          // Redirect
          flash('requirement_message', $i . ' selected Exposure(s) removed');
          redirect('requirements/show', $id);
        }
        elseif($_POST['action'] == 'addExposure'){
          $id_add = $_POST['id_add'];
          $id_add = array_map('intval',$id_add); // sanitise the retreived array
          $id = intval($id);
          $i = 0;
          foreach($id_add as $exposures_id){
            $i++;
            $data = [
              'requirements_id' => $id,
              'exposures_id' => $exposures_id
            ];
            echo '<pre>' . var_dump($data) . '</pre>';
            $this->requirementModel->addExposureToReq($data);
          }
          // Redirect
          flash('requirement_message', $i . ' selected Exposure(s) added');
          redirect('requirements/show', $id);
        }
      }
      else{
        exit;
      }
    }
    
    // Edit Requirement
    public function edit($id){
      if($_SERVER['REQUEST_METHOD'] == 'POST'){
        // Sanitize POST
        $_POST  = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

        if($_POST['relevant'] == 1) {
          $relevant = 1;
        }
        else{
          $relevant = 0;
        }
        
        $data = [
          'id' => $id,
          'requirement' => trim($_POST['requirement']),
          'description' => trim($_POST['description']),
          'area' => trim($_POST['area']),
          'standard' => trim($_POST['standard']),
          'examples' => trim($_POST['examples']),
          'chapters_id' => trim($_POST['chapters_id']),
          'relevant' => $relevant,
          'requirement_err' => '',
          'description_err' => '',
          'area_err' => '',
          'standard_err' => '',
          'examples_err' => '',
          'chapters_id_err' => '',
          'relevant_err' => ''
        ];

         // Validate Requirement
         if(empty($data['requirement'])){
          $data['requirement_err'] = 'Please enter requirement';
          // Validate Requirement
          if(empty($data['requirement'])){
            $data['description_err'] = 'Please enter description';
          }
        }

        // Make sure there are no errors
        if(empty($data['requirement_err']) && empty($data['description_err'])){
          // Validation passed
          //Execute
          //echo '<pre>' , var_dump($data) , '</pre>';
          if($this->requirementModel->updateRequirement($data)){
          // Redirect
          flash('requirement_message', 'Requirement Updated');
          redirect('requirements');
          } else {
            die('Something went wrong');
          }
        } else {
          // Load view with errors
          $this->view('requirements/edit', $data);
        }

      } else {
        // Get requirement from model
        $requirement = $this->requirementModel->getRequirementById($id);
        $chapters = $this->chapterModel->getChapters();

        $data = [
          'requirement' => $requirement,
          'chapters' => $chapters
        ];

        $this->view('requirements/edit', $data);
      }
    }

    // Delete Requirements
    public function delete(){
      if($_SERVER['REQUEST_METHOD'] == 'POST'){

        $id = $_POST["id"];
        $id = array_map('intval',$id); // sanitise the retreived array
        $ids = implode(', ', $id); 

        $data = [
          'ids' => $ids
        ];
        //Execute
        if($this->requirementModel->deleteRequirement($data)){
          // Redirect to index
          flash('requirement_message', 'Requirement(s) Removed');
          redirect('requirements');
          } else {
            die('Something went wrong');
          }
      } else {
        redirect('requirements');
      }
    }
  }