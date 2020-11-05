<?php
  class Universals extends Controller{
    public function __construct(){
      if(!isset($_SESSION['user_id'])){
        redirect('users/login');
      }
      // Load Models
      $this->universalModel = $this->model('Universal');
    }

    // Load All Requirements
    public function index(){
      $entries = $this->universalModel->getAll('Requirements');
      $colums = $this->universalModel->getTableColumns('Requirements');
      $columsWithoutID = array();

      foreach ($colums as $entry) {
        if($entry <> "ID") {
          array_push($columsWithoutID, $entry);
        }
      }

      $data = [
        'entries' => $entries,
        'colums' => $colums,
        'columsWithoutID' => $columsWithoutID
      ];
      
      $this->view('universals/index', $data);
    }

    // Show Single Requirement
    public function show($id){
      $requirement = $this->requirementModel->getRequirementById($id);

      $data = [
        'requirement' => $requirement
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
          'chapters_ID' => $_POST['chapters_ID'],
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
          'chapters_ID' => '',
          'relevant' => '',
          'chapters' => $chapters
          ];

        $this->view('requirements/add', $data);
      }
    }

    // Edit Requirement
    public function edit($id){
      if($_SERVER['REQUEST_METHOD'] == 'POST'){
        // Sanitize POST
        $_POST  = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

        if($_POST['Relevant'] == 1) {
          $relevant = 1;
        }
        else{
          $relevant = 0;
        }
        
        $data = [
          'ID' => $id,
          'Requirement' => trim($_POST['Requirement']),
          'Description' => trim($_POST['Description']),
          'Area' => trim($_POST['Area']),
          'Standard' => trim($_POST['Standard']),
          'Examples' => trim($_POST['Examples']),
          'Chapters_ID' => trim($_POST['Chapters_ID']),
          'Relevant' => $relevant,
          'requirement_err' => '',
          'description_err' => '',
          'area_err' => '',
          'standard_err' => '',
          'examples_err' => '',
          'chapters_id_err' => '',
          'relevant_err' => ''
        ];

         // Validate Requirement
         if(empty($data['Requirement'])){
          $data['requirement_err'] = 'Please enter requirement';
          // Validate Requirement
          if(empty($data['Requirement'])){
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
          'IDs' => $ids
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