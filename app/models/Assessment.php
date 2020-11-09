<?php
  class Assessment {
    private $db;
    
    public function __construct(){
      $this->db = new Database;
    }

    // Get All Assessments
    public function getAssessments(){
      $this->db->query("SELECT *, assessments.id AS assessments_id FROM assessments LEFT JOIN users ON assessments.owner_id = users.id");

      $results = $this->db->resultset();

      return $results;
    }

    // Get Assessment By ID
    public function getAssessmentById($id){
      $this->db->query("SELECT *, assessments.id AS assessments_id FROM assessments LEFT JOIN users ON assessments.owner_id = users.id WHERE assessments.id = :id");

      // Bind Values
      $this->db->bind(':id', $id);
      
      //Execute
      $row = $this->db->single();

      return $row;
    }

    // Check if assessment exists
    public function assessmentExists($id){
      // Prepare Query
      $this->db->query("SELECT * FROM assessments WHERE id = :id");

      // Bind Values
      $this->db->bind(':id', $id);
      
      //Execute
      $result = $this->db->resultset();

      //Execute
      if (count($result) > 0) {
        return true;
      } else {
        return false;
      }
    }

    // Add Assessment
    public function addAssessment($data){
      // Prepare Query
      $this->db->query("INSERT INTO assessments (assessment, answers, owner_id, status) 
      VALUES (:assessment, :answers, :owner_id, 'open') ");

      // Bind Values
      $this->db->bind(':assessment', $data['assessment']);
      $this->db->bind(':answers', $data['answers']);
      $this->db->bind(':owner_id', $data['owner']);
      
      //Execute
      if($this->db->execute()){
        return true;
      } else {
        return false;
      }
    }

    // Update Assessment
    public function updateAssessment($data){
      // Prepare Query
      $this->db->query('UPDATE assessments SET assessment = :assessment, answers = :answers WHERE id = :id');

      // Bind Values
      $this->db->bind(':assessment', $data['assessment']);
      $this->db->bind(':answers', $data['answers']);
      $this->db->bind(':id', $data['id']);
      
      //Execute
      if($this->db->execute()){
        return true;
      } else {
        return false;
      }
    }

    // Update Assessment Content (with XMLHttpRequest)
    public function updateAssessmentContent($content, $id){
      $content_json = json_encode($content);
      // Prepare Query
      $this->db->query('UPDATE assessments SET content = :content_json WHERE id = :id');
      //UPDATE Assessments SET Content = '".$content_json."' WHERE ID = ".$aid;

      // Bind Values
      $this->db->bind(':content_json', $content_json);
      $this->db->bind(':id', $id);
      
      //Execute
      if($this->db->execute()){
        return true;
      } else {
        return false;
      }
    }
    // Update Assessment Status (with XMLHttpRequest)
    public function updateAssessmentStatus($status, $id){
      $status_json = json_encode($status);
      // Prepare Query
      $this->db->query('UPDATE assessments SET reqstatus = :reqstatus_json WHERE id = :id');
      //UPDATE Assessments SET ReqStatus = '".$reqStatus_json."' WHERE ID = ".$aid;

      // Bind Values
      $this->db->bind(':reqstatus_json', $status_json);
      $this->db->bind(':id', $id);
      
      //Execute
      if($this->db->execute()){
        return true;
      } else {
        return false;
      }
    }

    // Delete Assessment
    public function deleteAssessments($data){
      // Prepare Query
      $this->db->query("DELETE FROM assessments WHERE id IN (" . $data['ids'] . ")");
      
      //Execute
      if($this->db->execute()){
        return true;
      } else {
        return false;
      }
    }
  }