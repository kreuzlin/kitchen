<?php
  class Exposures extends Controller{
    public function __construct(){
      if(!isset($_SESSION['user_id'])){
        redirect('users/login');
      }
      // Load Models
      $this->requirementModel = $this->model('Requirement');
      //$this->chapterModel = $this->model('Chapter');
      //$this->riskModel = $this->model('Risk');
      $this->exposureModel = $this->model('Exposure');
    }

    // Load All Exposures
    public function index(){
      $exposures = $this->exposureModel->getExposures();

      $data = [
        'exposures' => $exposures
      ];
      
      $this->view('exposures/index', $data);
    }

    // Show Single Exposure
    public function show($id){
      $exposure = $this->exposureModel->getExposureById($id);
      $relatedRequirements = $this->requirementModel->getRequirementsByExp($id);
      $notRelatedRequirements = $this->requirementModel->getRequirementsByNotExp($id);

      $data = [
        'exposure' => $exposure,
        'relatedRequirements' => $relatedRequirements,
        'notRelatedRequirements' => $notRelatedRequirements
      ];

      $this->view('exposures/show', $data);
    }

    // Add Exposure
    public function add(){
      if($_SERVER['REQUEST_METHOD'] == 'POST'){
        // Sanitize POST
        $_POST  = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
        $data = [
          'exposure' => trim($_POST['exposure']),
          'description' => trim($_POST['description']),
          'category' => trim($_POST['category']),
          'exposure_err' => '',
          'description_err' => '',
          'category_err' => ''
        ];

         // Validate Exposure
         if(empty($data['exposure'])){
          $data['exposure_err'] = 'Please enter Exposure';
          // Validate Description
          if(empty($data['description'])){
            $data['description_err'] = 'Please enter Description';
          }
        }

        // Make sure there are no errors
        if(empty($data['exposure_err']) && empty($data['description_err'])){
          // Validation passed
          //Execute
          if($this->exposureModel->addExposure($data)){
            // Redirect
            flash('exposure_added', 'Exposure Added');
            redirect('exposures');
          } else {
            die('Something went wrong');
          }
        } else {
          // Load view with errors
          $this->view('exposures/add', $data);
        }

      } else {
        $data = [
          'exposure' => trim($_POST['exposure']),
          'description' => trim($_POST['description']),
          'category' => trim($_POST['category'])
          ];

        $this->view('exposures/add', $data);
      }
    }

    // Update related Requirements to a specific Exposure
    public function relation($id){
      if($_SERVER['REQUEST_METHOD'] == 'POST'){
        // Sanitize POST
        //$_POST  = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

        if($_POST['action'] == 'remove'){
          $id_remove = $_POST['id_remove'];
          $id_remove = array_map('intval',$id_remove); // sanitise the retreived array
          $id = intval($id);
          //echo '<pre>' . var_dump($id_remove) . '</pre>';
          $i = 0;
          foreach($id_remove as $requirement_id){
            $i++;
            $data = [
              'exposures_id' => $id,
              'requirements_id' => $requirement_id
            ];
            $this->exposureModel->removeRequirementFromExp($data); 
          }
          // Redirect
          flash('exposure_message', $i . ' selected Requirement(s) removed');
          redirect('exposures/show', $id);
            
        }
        elseif($_POST['action'] == 'add'){
          $id_add = $_POST['id_add'];
          $id_add = array_map('intval',$id_add); // sanitise the retreived array
          $id = intval($id);
          $i = 0;
          foreach($id_add as $requirement_id){
            $i++;
            $data = [
              'exposures_id' => $id,
              'requirements_id' => $requirement_id
            ];
            $this->exposureModel->addRequirementToExp($data);
          }
          // Redirect
          flash('exposure_message', $i . ' selected Requirement(s) added');
          redirect('exposures/show', $id);
        }
      }
      else{
        exit;
      }
    }
    

    // Edit Exposure
    public function edit($id){
      if($_SERVER['REQUEST_METHOD'] == 'POST'){
        // Sanitize POST
        $_POST  = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
        
        $data = [
          'id' => $id,
          'exposure' => trim($_POST['exposure']),
          'description' => trim($_POST['description']),
          'category' => trim($_POST['category']),
          'exposure_err' => '',
          'description_err' => '',
          'category_err' => ''
        ];

         // Validate Exposure
         if(empty($data['exposure'])){
          $data['exposure_err'] = 'Please enter exposure';
         }
        // Validate Description
        if(empty($data['description'])){
          $data['description_err'] = 'Please enter description';
        }
        // Validate Category
        if(empty($data['category'])){
          $data['category_err'] = 'Please enter category';
        }
  

        // Make sure there are no errors
        if(empty($data['exposure_err']) && empty($data['description_err']) && empty($data['category_err'])){
          // Validation passed
          //Execute
          if($this->exposureModel->updateExposure($data)){
          // Redirect
          flash('exposure_message', 'Exposure Updated');
          redirect('exposures');
          } else {
            die('Something went wrong');
          }
        } else {
          // Load view with errors
          $this->view('exposures/edit', $data);
        }

      } else {
        // Get exposure from model
        $exposure = $this->exposureModel->getExposureById($id);

        $data = [
          'id' => $id,
          'exposure' => $exposure->Exposure,
          'description' => $exposure->Description,
          'category' => $exposure->Category
        ];

        $this->view('exposures/edit', $data);
      }
    }

    // Delete Exposures
    public function delete(){
      if($_SERVER['REQUEST_METHOD'] == 'POST'){

        $id = $_POST["id"];
        $id = array_map('intval',$id); // sanitise the retreived array
        $ids = implode(', ', $id); 

        $data = [
          'IDs' => $ids
        ];
        //Execute
        if($this->exposureModel->deleteExposure($data)){
          // Redirect to index
          flash('exposure_message', 'Exposure(s) Removed');
          redirect('exposures');
          } else {
            die('Something went wrong');
          }
      } else {
        redirect('exposures');
      }
    }
  }