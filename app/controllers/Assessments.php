<?php
  class Assessments extends Controller{
    public function __construct(){
      if(!isset($_SESSION['user_id'])){
        redirect('users/login');
      }
      // Load Models
      $this->riskModel = $this->model('Risk');
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
      $assessmentContent = json_decode($assessment->content, true);
      
      $assessmentStatus = json_decode($assessment->reqstatus, true);
      $assessmentStatus = $assessmentStatus ? $assessmentStatus : array();
      $gaps = array_keys($assessmentStatus, "gap");
      
      $chapters = $this->chapterModel->getChapters();
      $identifiedExposures = json_decode($assessment->answers);

      $applicableRequirements = $this->requirementModel->getRequirementsByExposures($identifiedExposures);

      $relevantChapters = $this->chapterModel->getRelevantChapters($identifiedExposures);

      $concept = array();

      foreach($relevantChapters as $chapter){
        if($chapter->type == 1){
          $textItem = [
            'format' => 'h1',
            'text' => $chapter->chapter
          ];
          array_push($concept, $textItem);
          $textItem = [
            'format' => 'chpaterDescription',
            'text' => $chapter->description
          ];
          array_push($concept, $textItem);
          $thisRequirements = $this->requirementModel->getRequirementsByExposuresAndChapter($identifiedExposures, $chapter->id);
          foreach($thisRequirements as $thisRequirement){
            $textItem = [
              'format' => 'requirement',
              'text' => $thisRequirement->requirement,
              'id' => $thisRequirement->id
            ];
            array_push($concept, $textItem);
            $thisContent = isset($assessmentContent[$thisRequirement->id]) ? $assessmentContent[$thisRequirement->id] : null;
            $thisStatus = isset($assessmentStatus[$thisRequirement->id]) ? $assessmentStatus[$thisRequirement->id] : null;
            $textItem = [
              'format' => 'requirementDescription',
              'text' => $thisRequirement->description,
              'id' => $thisRequirement->id,
              'content' => $thisContent,
              'status' => $thisStatus
            ];
            array_push($concept, $textItem);
          }
        }
        elseif($chapter->type == 2){
          $textItem = [
            'format' => 'h2',
            'text' => $chapter->chapter
          ];
          array_push($concept, $textItem);
          $textItem = [
            'format' => 'chpaterDescription',
            'text' => $chapter->description
          ];
          array_push($concept, $textItem);
          $thisRequirements = $this->requirementModel->getRequirementsByExposuresAndChapter($identifiedExposures, $chapter->id);
          foreach($thisRequirements as $thisRequirement){
            $textItem = [
              'format' => 'requirement',
              'text' => $thisRequirement->requirement,
              'id' => $thisRequirement->id
            ];
            array_push($concept, $textItem);
            $thisContent = isset($assessmentContent[$thisRequirement->id]) ? $assessmentContent[$thisRequirement->id] : null;
            $thisStatus = isset($assessmentStatus[$thisRequirement->id]) ? $assessmentStatus[$thisRequirement->id] : null;
            $textItem = [
              'format' => 'requirementDescription',
              'text' => $thisRequirement->description,
              'id' => $thisRequirement->id,
              'content' => $thisContent,
              'status' => $thisStatus
            ];
            array_push($concept, $textItem);
          }
        }
        elseif($chapter->type == 3){
          $textItem = [
            'format' => 'h3',
            'text' => $chapter->chapter
          ];
          array_push($concept, $textItem);
          $textItem = [
            'format' => 'chpaterDescription',
            'text' => $chapter->description
          ];
          array_push($concept, $textItem);
          $thisRequirements = $this->requirementModel->getRequirementsByExposuresAndChapter($identifiedExposures, $chapter->id);
          foreach($thisRequirements as $thisRequirement){
            $textItem = [
              'format' => 'requirement',
              'text' => $thisRequirement->requirement,
              'id' => $thisRequirement->id
            ];
            array_push($concept, $textItem);
            $thisContent = isset($assessmentContent[$thisRequirement->id]) ? $assessmentContent[$thisRequirement->id] : null;
            $thisStatus = isset($assessmentStatus[$thisRequirement->id]) ? $assessmentStatus[$thisRequirement->id] : null;
            $textItem = [
              'format' => 'requirementDescription',
              'text' => $thisRequirement->description,
              'id' => $thisRequirement->id,
              'content' => $thisContent,
              'status' => $thisStatus
            ];
            array_push($concept, $textItem);
          }
        }
      }

      foreach($applicableRequirements as $requirement){
        $reqIds[] = $requirement->id;
      }

      $inherentRisks = $this->riskModel->countRiskByRequirements($reqIds);
      $iRA['Advanced Persistent Threat (APT)'] = 1;
      $iRA['Data Leakage'] = 1;
      $iRA['Third Party Risk'] = 1;
      $iRA['Financial Fraud'] = 1;
      $iRA['Business Disruption'] = 1;
      $iRA['Extortion'] = 1;
      $iRA['Misuse of Infrastructure'] = 1;
      $iRA['Physical Threat'] = 1;
      $iRA['Brand Abuse'] = 1;
      $iRA['Lack of fundamental protection'] = 1;

      foreach($inherentRisks as $riskEntry){
        $iRA[$riskEntry->risk] = $riskEntry->amount +1;
      }
      //ATP, Data Leakage, 3rd party, Financial, Disruption, Extortion, Misuse, Physical, Brand, Fundamental
      $inherentRiskData = 'data: ['.$iRA['Advanced Persistent Threat (APT)'].', '.$iRA['Data Leakage'].', '.$iRA['Third Party Risk'].', '.$iRA['Financial Fraud'].', '.$iRA['Business Disruption'].', '.$iRA['Extortion'].', '.$iRA['Misuse of Infrastructure'].', '.$iRA['Physical Threat'].', '.$iRA['Brand Abuse'].', '.$iRA['Lack of fundamental protection'].']';
      
      $residualRisks = $this->riskModel->GetRiskByRequirements($gaps);
      $residualRisk = $this->riskModel->countRiskByRequirements($gaps);
      $rRA['Advanced Persistent Threat (APT)'] = 1;
      $rRA['Data Leakage'] = 1;
      $rRA['Third Party Risk'] = 1;
      $rRA['Financial Fraud'] = 1;
      $rRA['Business Disruption'] = 1;
      $rRA['Extortion'] = 1;
      $rRA['Misuse of Infrastructure'] = 1;
      $rRA['Physical Threat'] = 1;
      $rRA['Brand Abuse'] = 1;
      $rRA['Lack of fundamental protection'] = 1;

      foreach($residualRisk as $riskEntry){
        $rRA[$riskEntry->risk] = $riskEntry->amount + 1;
      }
      //ATP, Data Leakage, 3rd party, Financial, Disruption, Extortion, Misuse, Physical, Brand, Fundamental
      $residualRiskData = 'data: ['.$rRA['Advanced Persistent Threat (APT)'].', '.$rRA['Data Leakage'].', '.$rRA['Third Party Risk'].', '.$rRA['Financial Fraud'].', '.$rRA['Business Disruption'].', '.$rRA['Extortion'].', '.$rRA['Misuse of Infrastructure'].', '.$rRA['Physical Threat'].', '.$rRA['Brand Abuse'].', '.$rRA['Lack of fundamental protection'].']';
      
      $data = [
        'assessment' => $assessment, 
        'concept' => $concept,
        'residualRisks' => $residualRisks,
        'inherentRiskData' => $inherentRiskData,
        'residualRiskData' => $residualRiskData
      ];
      $this->view('assessments/show', $data);
    }

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
          'assessment' => $assessment->assessment,
          'answers' => json_decode($assessment->answers),
          'assessment_err' => '',
          'exposures' => $exposures,
          'id' => $id
          ];

        $this->view('assessments/edit', $data);
      }
    }
    
    // Update Assessment with XMLHttpRequest
    public function update(){
      if($_SERVER['REQUEST_METHOD'] == 'POST'){
        // Sanitize POST
        $_POST  = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
        if(isset($_POST['content'])){
          $aid = intval($_POST['aid']);
          $id = intval($_POST['id']);

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
          $aid = intval($_POST['aid']);
          $id = intval($_POST['id']);

          //get current status
          $assessment = $this->assessmentModel->getAssessmentById($aid);
          $reqStatus_json = $assessment->reqstatus;
          $reqStatus = json_decode($reqStatus_json, true);

          //add new status to current set of status
          $newReqStatus = $_POST['reqStatus'];
          $reqStatus[$id] = $newReqStatus;

          //update status
          if($this->assessmentModel->updateAssessmentStatus($reqStatus,$aid)){
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
          'ids' => $ids
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