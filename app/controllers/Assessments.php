<?php
  class Assessments extends Controller{
    public function __construct(){
      if(!isset($_SESSION['user_id'])){
        redirect('users/login');
      }
      // Load Models
      //$this->riskModel = $this->model('Risk');
      $this->requirementModel = $this->model('Requirement');
      $this->exposureModel = $this->model('Exposure');
      $this->assessmentModel = $this->model('Assessment');
      $this->chapterModel = $this->model('Chapter');
    }

    //Load All Assessments
    public function index(){
      $assessments = $this->assessmentModel->getAssessments();

      $data = [
        'assessments' => $assessments
      ];
      
      $this->view('assessments/index', $data);
    }

    // Show Assessment
    public function show($id){
      
      $assessment = $this->assessmentModel->getAssessmentById($id);
      
      $chapters = $this->chapterModel->getChapters();
      $identifiedExposures = json_decode($assessment->Answers);
      $relevantChapters = $this->chapterModel->getRelevantChapters($identifiedExposures);

      $concept = array();

      foreach($relevantChapters as $chapter){
        if($chapter->Type == 1){
          $textItem = [
            'format' => 'h1',
            'text' => $chapter->Chapter
          ];
          array_push($concept, $textItem);
          $textItem = [
            'format' => 'chpaterDescription',
            'text' => $chapter->Description
          ];
          array_push($concept, $textItem);
          $thisRequirements = $this->requirementModel->getRequirementsByExposuresAndChapter($identifiedExposures, $chapter->ID);
          foreach($thisRequirements as $thisRequirement){
            $textItem = [
              'format' => 'requirement',
              'text' => $thisRequirement->Requirement,
              'id' => $thisRequirement->ID
            ];
            array_push($concept, $textItem);
            $textItem = [
              'format' => 'requirementDescription',
              'text' => $thisRequirement->Description,
              'id' => $thisRequirement->ID
            ];
            array_push($concept, $textItem);
          }
        }
        elseif($chapter->Type == 2){
          $textItem = [
            'format' => 'h2',
            'text' => $chapter->Chapter
          ];
          array_push($concept, $textItem);
          $textItem = [
            'format' => 'chpaterDescription',
            'text' => $chapter->Description
          ];
          array_push($concept, $textItem);
          $thisRequirements = $this->requirementModel->getRequirementsByExposuresAndChapter($identifiedExposures, $chapter->ID);
          foreach($thisRequirements as $thisRequirement){
            $textItem = [
              'format' => 'requirement',
              'text' => $thisRequirement->Requirement,
              'id' => $thisRequirement->ID
            ];
            array_push($concept, $textItem);
            $textItem = [
              'format' => 'requirementDescription',
              'text' => $thisRequirement->Description,
              'id' => $thisRequirement->ID
            ];
            array_push($concept, $textItem);
          }
        }
        elseif($chapter->Type == 3){
          $textItem = [
            'format' => 'h3',
            'text' => $chapter->Chapter
          ];
          array_push($concept, $textItem);
          $textItem = [
            'format' => 'chpaterDescription',
            'text' => $chapter->Description
          ];
          array_push($concept, $textItem);
          $thisRequirements = $this->requirementModel->getRequirementsByExposuresAndChapter($identifiedExposures, $chapter->ID);
          foreach($thisRequirements as $thisRequirement){
            $textItem = [
              'format' => 'requirement',
              'text' => $thisRequirement->Requirement,
              'id' => $thisRequirement->ID
            ];
            array_push($concept, $textItem);
            $textItem = [
              'format' => 'requirementDescription',
              'text' => $thisRequirement->Description,
              'id' => $thisRequirement->ID
            ];
            array_push($concept, $textItem);
          }
        }
      }

      $data = [
        'assessment' => $assessment, 
        'concept' => $concept,
      ];

      $this->view('assessments/show', $data);
    }

    // // Show Assessment
    // public function show($id){
    //   $assessment = $this->assessmentModel->getAssessmentById($id);
    //   //$chapters = $this->chapterModel->getChapters();
    //   $exposures =  json_decode($assessment->Answers);
    //   //echo '<pre>' . var_dump($exposures) . '</pre>';

    //   $chapters = $this->chapterModel->getChaptersByExposures($exposures);
    //   //$requirements = $this->requirementModel->getRequirements();
    //   //echo '<pre>' . var_dump()
      
    //   //$requirements = $this->requirementModel->getRequirementsByExposures($exposures);

    //   $data = [
    //     'assessment' => $assessment, 
    //     'chapters' => $chapters
    //   ];

    //   $this->view('assessments/show', $data);
    // }
    // Add Assessment
    public function add(){
      if($_SERVER['REQUEST_METHOD'] == 'POST'){
        // Sanitize POST
        $_POST  = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
        $exposures = $this->exposureModel->getExposures();
        $data = [
          'assessment' => trim($_POST['assessment']),
          'answers' => $_POST['answers'],
          'owner' => intval($_SESSION['user_id']),
          'assessment_err' => '',
          'exposures' => $exposures
        ];

        // Validate Assessment
        if(empty($data['assessment'])){
          $data['assessment_err'] = 'Please enter assessment name';
        }

        // Make sure there are no errors
        if(empty($data['assessment_err'])){
          // Validation passed
          //transform array into json
          $data['answers'] = json_encode($data['answers']);
          //Execute
          if($this->assessmentModel->addAssessment($data)){
            // Redirect
            flash('assessment_message', 'Assessment Added');
            redirect('assessments');
          } else {
            die('Something went wrong');
          }
        } else {
          // Load view with errors
          $this->view('assessments/add', $data);
        }

      } else {
        $exposures = $this->exposureModel->getExposures();

        $data = [
          'assessment' => '',
          'answers' => array(),
          'assessment_err' => '',
          'exposures' => $exposures
          ];

        $this->view('assessments/add', $data);
      }
    }

    // Edit Assessment
    public function edit($id){
      if($_SERVER['REQUEST_METHOD'] == 'POST'){
        // Sanitize POST
        $_POST  = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
        $exposures = $this->exposureModel->getExposures();
        $data = [
          'assessment' => trim($_POST['assessment']),
          'answers' => $_POST['answers'],
          'owner' => intval($_SESSION['user_id']),
          'assessment_err' => '',
          'exposures' => $exposures,
          'id' => $id
        ];

        // Validate Assessment
        if(empty($data['assessment'])){
          $data['assessment_err'] = 'Please enter assessment name';
        }

        // Make sure there are no errors
        if(empty($data['assessment_err'])){
          // Validation passed
          //transform array into json
          $data['answers'] = json_encode($data['answers']);
          //Execute
          if($this->assessmentModel->updateAssessment($data)){
            // Redirect
            flash('assessment_edited', 'Assessment edited');
            redirect('assessments');
          } else {
            die('Something went wrong');
          }
        } else {
          // Load view with errors
          $this->view('assessments/edit', $data);
        }

      } else {
        $exposures = $this->exposureModel->getExposures();
        $assessment = $this->assessmentModel->getAssessmentById($id);

        $data = [
          'assessment' => $assessment->Assessment,
          'answers' => json_decode($assessment->Answers),
          'assessment_err' => '',
          'exposures' => $exposures,
          'id' => $id
          ];

        $this->view('assessments/edit', $data);
      }
    }
    
    // Update Assessment with XMLHttpRequest
    public function update($id){
      if($_SERVER['REQUEST_METHOD'] == 'POST'){
        // Sanitize POST
        $_POST  = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
        if(isset($_POST['content'])){
          $aid = intval($_POST['AID']);
          $id = intval($_POST['ID']);

          //get ALL content
          $assessment = $this->assessmentModel->getAssessmentById($aid);
          $content_json = $assessment->Content;
          $content = json_decode($content_json, true);
          
          //update Content for a given requirement
          $newContent = htmlspecialchars($_POST['content'],ENT_QUOTES);
          $content[$id] = $newContent;

          //update content in DB
          if($this->assessmentModel->updateAssessmentContent($content,$aid)){
            echo "success";
          }
          else{
            echo "error";
          }
        }
        elseif(isset($_POST['reqStatus'])){
          $aid = intval($_POST['AID']);
          $id = intval($_POST['ID']);

          //get current status
          $assessment = $this->assessmentModel->getAssessmentById($aid);
          $reqStatus_json = $assessment->ReqStatus;
          $reqStatus = json_decode($reqStatus_json, true);

          //add new status to current set of status
          $newReqStatus = $_POST['reqStatus'];
          $reqStatus[$id] = $newReqStatus;

          //update status
          if($this->assessmentModel->updateAssessmentStatus($content,$aid)){
            echo "success";
          }
          else{
            echo "error";
          }
        }
      }
    } 

    // Delete Assessments
    public function delete(){
      if($_SERVER['REQUEST_METHOD'] == 'POST'){

        $id = $_POST["id"];
        $id = array_map('intval',$id); // sanitise the retreived array
        $ids = implode(', ', $id); 

        $data = [
          'IDs' => $ids
        ];
        //Execute
        if($this->assessmentModel->deleteAssessments($data)){
          // Redirect to index
          flash('assessment_message', 'Assessment(s) Removed');
          redirect('assessments');
          } else {
            die('Something went wrong');
          }
      } else {
        redirect('assessments');
      }
    }

  }