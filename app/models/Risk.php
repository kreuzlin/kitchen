<?php
  class Risk {
    private $db;
    
    public function __construct(){
      $this->db = new Database;
    }

    // Get All Risks
    public function getRisks(){
      $this->db->query("SELECT * FROM risks");

      $results = $this->db->resultset();

      return $results;
    }

    // Get Risk By ID
    public function getRiskById($id){
      $this->db->query("SELECT * FROM risks WHERE id = :id");

      $this->db->bind(':id', $id);
      
      $row = $this->db->single();

      return $row;
    }

    // Get Risks related to a set of Requirements
    public function countRiskByRequirements($ids){
      $ids = $ids ? $ids : array(0 => 0);
      $ids = implode(', ', $ids);
      $query = "SELECT risks.id AS risks_id, risk, COUNT(risks.id) AS amount FROM risks 
      LEFT JOIN requirement2risk ON risks.id = requirement2risk.risks_id
      LEFT JOIN requirements ON requirement2risk.requirements_id = requirements.id 
      WHERE requirement2risk.requirements_id IN (".$ids.")
      GROUP BY risks.id";
      $this->db->query($query);
      
      $results = $this->db->resultset();

      return $results;
    }

    // Get Risks related to a set of Requirements
    public function getRiskByRequirements($ids){
      $ids = $ids ? $ids : array(0 => 0);
      $ids = implode(', ', $ids);
      $query = "SELECT risks.id AS risks_id, risks.risk, requirements.id AS requirements_id, requirements.requirement FROM risks 
      LEFT JOIN requirement2risk ON risks.id = requirement2risk.risks_id 
      LEFT JOIN requirements ON requirement2risk.requirements_id = requirements.id 
      WHERE requirement2risk.requirements_id IN (".$ids.") ";
      $this->db->query($query);
      
      $results = $this->db->resultset();

      return $results;
    }

    // Get Risks related to a Requirement
    public function getRiskByReq($id){
      $this->db->query("SELECT risks.id, risks.risk FROM risks LEFT JOIN requirement2risk ON risks.id = requirement2risk.risks_id WHERE requirement2risk.requirements_id = :id");

      $this->db->bind(':id', $id);
      
      $results = $this->db->resultset();

      return $results;
    }
  
    // Get Risks NOT related to a Requirement
    public function getRiskByNotReq($id){
      $this->db->query("SELECT risk, id FROM risks WHERE id NOT IN (SELECT risks_id FROM requirement2risk WHERE requirements_id = :id)");

      $this->db->bind(':id', $id);
      
      $results = $this->db->resultset();

      return $results;
    }

    // Add Risks
    public function addRisk($data){
      // Prepare Query
      $this->db->query('INSERT INTO risks (risk, description, reference) 
      VALUES (:risk, :description, :reference)');

      // Bind Values
      $this->db->bind(':risk', $data['risk']);
      $this->db->bind(':description', $data['description']);
      $this->db->bind(':reference', $data['reference']);

      //Execute
      if($this->db->execute()){
        return true;
      } else {
        return false;
      }
    }

    // Update Risk
    public function updateRisk($data){

      // Prepare Query
      $this->db->query('UPDATE risks SET risk = :risk, description = :description, reference = :reference WHERE id = :id');

      // Bind Values
      $this->db->bind(':id', $data['id']);
      $this->db->bind(':risk', $data['risk']);
      $this->db->bind(':description', $data['description']);
      $this->db->bind(':reference', $data['reference']);
      
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
      $this->db->query("DELETE FROM risks WHERE id IN (" . $data['ids'] . ")");

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