<?php
  class Risk {
    private $db;
    
    public function __construct(){
      $this->db = new Database;
    }

    // Get All Risks
    public function getRisks(){
      $this->db->query("SELECT * FROM Risks");

      $results = $this->db->resultset();

      return $results;
    }

    // Get Risk By ID
    public function getRiskById($id){
      $this->db->query("SELECT * FROM Risks WHERE ID = :id");

      $this->db->bind(':id', $id);
      
      $row = $this->db->single();

      return $row;
    }

    // Get Risks related to a Requirement
    public function getRiskByReq($id){
      $this->db->query("SELECT Risks.ID, Risks.Risk FROM Risks LEFT JOIN Requirement2Risk ON Risks.ID = Requirement2Risk.Risks_ID WHERE Requirement2Risk.Requirements_ID = :id");

      $this->db->bind(':id', $id);
      
      $results = $this->db->resultset();

      return $results;
    }

  
    // Get Risks NOT related to a Requirement
    public function getRiskByNotReq($id){
      $this->db->query("SELECT Risk, ID FROM Risks WHERE ID NOT IN (SELECT Risks_ID FROM Requirement2Risk WHERE Requirements_ID = :id)");

      $this->db->bind(':id', $id);
      
      $results = $this->db->resultset();

      return $results;
    }

    // Add Risks
    public function addRisk($data){
      // Prepare Query
      $this->db->query('INSERT INTO Risks (Risk, Description, Reference) 
      VALUES (:Risk, :Description, :Reference)');

      // Bind Values
      $this->db->bind(':Risk', $data['risk']);
      $this->db->bind(':Description', $data['description']);
      $this->db->bind(':Reference', $data['reference']);


      //Execute
      if($this->db->execute()){
        return true;
      } else {
        return false;
      }
    }

    // Update Risk
    public function updateRisk($data){
      echo '<pre>' . var_dump($data) . '</pre>';
      // Prepare Query
      $this->db->query('UPDATE Risks SET Risk = :Risk, Description = :Description, Reference = :Reference WHERE ID = :id');

      // Bind Values
      $this->db->bind(':id', $data['id']);
      $this->db->bind(':Risk', $data['risk']);
      $this->db->bind(':Description', $data['description']);
      $this->db->bind(':Reference', $data['reference']);
      
      //Execute
      if($this->db->execute()){
        return true;
      } else {
        return false;
      }
    }

    // Delete Risk
    public function deleteRisk($data){
      // Prepare Query
      $this->db->query("DELETE FROM Risks WHERE ID IN (" . $data['IDs'] . ")");

      // Bind Values
      //$this->db->bind(':id', $data['IDs']);
      
      //Execute
      if($this->db->execute()){
        return true;
      } else {
        return false;
      }
    }
  }