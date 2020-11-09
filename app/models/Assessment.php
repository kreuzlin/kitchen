<?php
  class Assessment {
    private $db;
    
    public function __construct(){
      $this->db = new Database;
    }

    // Get All Assessments
    public function getAssessments(){
      $this->db->query("SELECT * FROM Assessments LEFT JOIN users ON Assessments.Owner_ID = users.id");

      $results = $this->db->resultset();

      return $results;
    }

    // Get Assessment By ID
    public function getAssessmentById($id){
      $this->db->query("SELECT * FROM Assessments LEFT JOIN users ON Assessments.Owner_ID = users.id WHERE Assessments.ID = :id");

      // Bind Values
      $this->db->bind(':id', $id);
      
      //Execute
      $row = $this->db->single();

      return $row;
    }

    // Check if assessment exists
    public function assessmentExists($id){
      // Prepare Query
      $this->db->query("SELECT * FROM Assessments WHERE ID = :id");

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
      $this->db->query("INSERT INTO Assessments (Assessment, Answers, Owner_ID, Status) 
      VALUES (:Assessment, :Answers, :Owner_ID, 'open') ");

      // Bind Values
      $this->db->bind(':Assessment', $data['assessment']);
      $this->db->bind(':Answers', $data['answers']);
      $this->db->bind(':Owner_ID', $data['owner']);
      
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
      $this->db->query('UPDATE Assessments SET Assessment = :Assessment, Answers = :Answers WHERE ID = :ID');

      // Bind Values
      $this->db->bind(':Assessment', $data['assessment']);
      $this->db->bind(':Answers', $data['answers']);
      $this->db->bind(':ID', $data['id']);
      
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
      $this->db->query('UPDATE Assessments SET Content = :content_json WHERE ID = :ID');
      //UPDATE Assessments SET Content = '".$content_json."' WHERE ID = ".$aid;

      // Bind Values
      $this->db->bind(':content_json', $content_json);
      $this->db->bind(':ID', $id);
      
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
      $this->db->query('UPDATE Assessments SET ReqStatus = :reqStatus_json WHERE ID = :ID');
      //UPDATE Assessments SET ReqStatus = '".$reqStatus_json."' WHERE ID = ".$aid;

      // Bind Values
      $this->db->bind(':reqStatus_json', $status_json);
      $this->db->bind(':ID', $id);
      
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
      $this->db->query("DELETE FROM Assessments WHERE ID IN (" . $data['IDs'] . ")");
      
      //Execute
      if($this->db->execute()){
        return true;
      } else {
        return false;
      }
    }
  }