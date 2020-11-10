<?php
  class Risks extends Controller{
    public function __construct(){
      if(!isset($_SESSION['user_id'])){
        redirect('users/login');
      }
      // Load Models
      $this->riskModel = $this->model('Risk');
      $this->requirementModel = $this->model('Requirement');
    }

    // Load All Risks
    public function index(){
      $risks = $this->riskModel->getRisks();

      $data = [
        'risks' => $risks
      ];
      
      $this->view('risks/index', $data);
    }

    // Show Single Risk
    public function show($id){
      $risk = $this->riskModel->getRiskById($id);
      $relatedRequirements = $this->requirementModel->getRequirementsByRisk($id);
      $notRelatedRequirements = $this->requirementModel->getRequirementsByNotRisk($id);

      $data = [
        'risk' => $risk,
        'relatedRequirements' => $relatedRequirements,
        'notRelatedRequirements' => $notRelatedRequirements

      ];

      $this->view('risks/show', $data);
    }

    // Add Risk
    public function add(){
      if($_SERVER['REQUEST_METHOD'] == 'POST'){
        // Sanitize POST
        $_POST  = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
        $data = [
          'risk' => trim($_POST['risk']),
          'description' => trim($_POST['description']),
          'reference' => trim($_POST['reference']),
          'risk_err' => '',
          'description_err' => '',
          'reference_err' => ''
        ];

         // Validate Risk
         if(empty($data['risk'])){
          $data['risk_err'] = 'Please enter Risk';
          // Validate Description
          if(empty($data['description'])){
            $data['description_err'] = 'Please enter Description';
          }
        }

        // Make sure there are no errors
        if(empty($data['risk_err']) && empty($data['description_err'])){
          // Validation passed
          //Execute
          if($this->riskModel->addRisk($data)){
            // Redirect
            flash('risk_added', 'Risk Added');
            redirect('risks');
          } else {
            die('Something went wrong');
          }
        } else {
          // Load view with errors
          $this->view('risks/add', $data);
        }

      } else {
        //$chapters = $this->riskModel->getRisks();
        $data = [
          'risk' => '',
          'description' => '',
          'reference' => ''
          ];

        $this->view('risks/add', $data);
      }
    }

    // Edit Risk
    public function edit($id){
      if($_SERVER['REQUEST_METHOD'] == 'POST'){
        // Sanitize POST
        $_POST  = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
        
        $data = [
          'id' => intval($id),
          'risk' => trim($_POST['risk']),
          'description' => trim($_POST['description']),
          'reference' => trim($_POST['reference']),
          'risk_err' => '',
          'description_err' => '',
          'reference_err' => ''
        ];

         // Validate Risk
         if(empty($data['risk'])){
          $data['risk_err'] = 'Please enter risk';
          // Validate Description
          if(empty($data['description'])){
            $data['description_err'] = 'Please enter description';
          }
        }

        // Make sure there are no errors
        if(empty($data['risk_err']) && empty($data['description_err'])){
          // Validation passed
          //Execute
          echo '<pre>' , var_dump($data) , '</pre>';
          if($this->riskModel->updateRisk($data)){
          // Redirect
          flash('requirement_message', 'Risk Updated');
          redirect('risks');
          } else {
            die('Something went wrong');
          }
        } else {
          // Load view with errors
          $this->view('risks/edit', $data);
        }

      } else {
        // Get requirement from model
        $risk = $this->riskModel->getRiskById($id);

        $data = [
          'risk' => $risk,
        ];

        $this->view('risks/edit', $data);
      }
    }

    // Update Risk, Requirement relationship
    public function relation($id){
      if($_SERVER['REQUEST_METHOD'] == 'POST'){
        if($_POST['action'] == 'remove'){
          $id_remove = $_POST['id_remove'];
          $id_remove = array_map('intval',$id_remove); // sanitise the retreived array
          $id = intval($id);
          echo '<pre>' . var_dump($id_remove) . '</pre>';
          $i = 0;
          foreach($id_remove as $req_id){
            $i++;
            $data = [
              'requirements_id' => $req_id,
              'risks_id' => $id
            ];
            $this->requirementModel->removeRiskFromReq($data); 
          }
          // Redirect
          flash('requirement_message', $i . ' selected Risk(s) removed');
          redirect('risks/show', $id);
        }
        elseif($_POST['action'] == 'add'){
          $id_add = $_POST['id_add'];
          $id_add = array_map('intval',$id_add); // sanitise the retreived array
          $id = intval($id);
          $i = 0;
          foreach($id_add as $req_id){
            $i++;
            $data = [
              'requirements_id' => $req_id,
              'risks_id' => $id
            ];
            $this->requirementModel->addRiskToReq($data);
          }
          // Redirect
          flash('requirement_message', $i . ' selected Risk(s) added');
          redirect('risks/show', $id);
        }
      }
      else{
        exit;
      }
    }

    // Delete Risk
    public function delete(){
      if($_SERVER['REQUEST_METHOD'] == 'POST'){

        $id = $_POST["id"];
        $id = array_map('intval',$id); // sanitise the retreived array
        $ids = implode(', ', $id); 

        $data = [
          'ids' => $ids
        ];
        //Execute
        if($this->riskModel->deleteRisk($data)){
          // Redirect to index
          flash('risk_message', 'Risk(s) Removed');
          redirect('risks');
          } else {
            die('Something went wrong');
          }
      } else {
        redirect('risks');
      }
    }
  }