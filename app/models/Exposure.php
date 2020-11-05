<?php
  class Exposure {
    private $db;
    
    public function __construct(){
      $this->db = new Database;
    }

    // Get All Exposures
    public function getExposures(){
      $this->db->query("SELECT * FROM Exposures ORDER BY Category");

      $results = $this->db->resultset();

      return $results;
    }

    // Get All Exposure Categories
    public function getExposureCategories(){
      $this->db->query("SELECT Distinct Category FROM Exposures");

      $results = $this->db->resultset();

      return $results;
    }

    // Get Exposures by Category
    public function getExposureByCategory($category){
      $this->db->query("SELECT * FROM Exposures WHERE Category = :Category");

      $this->db->bind(':Category', $category);

      $results = $this->db->resultset();

      return $results;
    }

    // Get Exposure By ID
    public function getExposureById($id){
      $this->db->query("SELECT * FROM Exposures WHERE ID = :id");

      $this->db->bind(':id', $id);
      
      $row = $this->db->single();

      return $row;
    }

    

    


    // Get Exposures related to a requirement
    public function getExposuresByReq($id){
      $this->db->query("SELECT Exposures.ID, Exposures.Exposure FROM Exposures LEFT JOIN Requirement2Exposure ON Exposures.ID = Requirement2Exposure.Exposures_ID WHERE Requirement2Exposure.Requirements_ID = :id");

      $this->db->bind(':id', $id);
      
      $results = $this->db->resultset();

      return $results;
    }
    
      
    // Get Exposures unrelated to a requirement
    public function getExposuresByNotReq($id){
      $this->db->query("SELECT Exposure, ID FROM Exposures WHERE ID NOT IN (SELECT Exposures_ID FROM Requirement2Exposure WHERE Requirements_ID = :id)");

      $this->db->bind(':id', $id);
      
      $results = $this->db->resultset();

      return $results;
    }


    // Add Exposure
    public function addExposure($data){
      // Prepare Query
      $this->db->query('INSERT INTO Exposures (Exposure, Description, Category) 
      VALUES (:Exposure, :Description, :Category)');

      // Bind Values
      $this->db->bind(':Exposure', $data['exposure']);
      $this->db->bind(':Description', $data['description']);
      $this->db->bind(':Category', $data['category']);

      //Execute
      if($this->db->execute()){
        return true;
      } else {
        return false;
      }
    }

    // Update Exposure
    public function updateExposure($data){
      // Prepare Query
      $this->db->query('UPDATE Exposures SET Exposure = :Exposure, Description = :Description, Category = :Category WHERE ID = :ID');

      // Bind Values
      $this->db->bind(':ID', $data['id']);
      $this->db->bind(':Exposure', $data['exposure']);
      $this->db->bind(':Description', $data['description']);
      $this->db->bind(':Category', $data['category']);
      
      //Execute
      if($this->db->execute()){
        return true;
      } else {
        return false;
      }
    }

    // Add Requirement to Exposure
    public function addRequirementToExp($data){
      //echo '<pre>' . var_dump($data) . '</pre>';
      // Prepare Query
      $this->db->query('INSERT INTO Requirement2Exposure (Requirements_ID, Exposures_ID) VALUES (:Requirements_ID, :Exposures_ID)');

      // Bind Values
      $this->db->bind(':Requirements_ID', $data['requirements_id']);
      $this->db->bind(':Exposures_ID', $data['exposures_id']);

      //Execute
      if($this->db->execute()){
        return true;
      } else {
        return false;
      }

    }
    // Remove Requirement from Exposure
    public function removeRequirementFromExp($data){
      //echo '<pre>' . var_dump($data) . '</pre>';
      // Prepare Query
      $this->db->query('DELETE FROM Requirement2Exposure WHERE Requirements_ID = :Requirements_ID AND Exposures_ID = :Exposures_ID');

      // Bind Values
      $this->db->bind(':Requirements_ID', $data['requirements_id']);
      $this->db->bind(':Exposures_ID', $data['exposures_id']);

      //Execute
      if($this->db->execute()){
        return true;
      } else {
        return false;
      }

    }

    // Delete Exposure
    public function deleteExposure($data){
      // Prepare Query
      $this->db->query("DELETE FROM Exposures WHERE ID IN (" . $data['IDs'] . ")");

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