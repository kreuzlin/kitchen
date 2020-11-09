<?php
  class Exposure {
    private $db;
    
    public function __construct(){
      $this->db = new Database;
    }

    // Get All Exposures
    public function getExposures(){
      $this->db->query("SELECT * FROM exposures ORDER BY category");

      $results = $this->db->resultset();

      return $results;
    }

    // Get All Exposure Categories
    public function getExposureCategories(){
      $this->db->query("SELECT DISTINCT category FROM exposures");

      $results = $this->db->resultset();

      return $results;
    }

    // Get Exposures by Category
    public function getExposureByCategory($category){
      $this->db->query("SELECT * FROM exposures WHERE category = :category");

      $this->db->bind(':category', $category);

      $results = $this->db->resultset();

      return $results;
    }

    // Get Exposure By ID
    public function getExposureById($id){
      $this->db->query("SELECT * FROM exposures WHERE id = :id");

      $this->db->bind(':id', $id);
      
      $row = $this->db->single();

      return $row;
    }

    

    


    // Get Exposures related to a requirement
    public function getExposuresByReq($id){
      $this->db->query("SELECT exposures.id, exposures.exposure FROM exposures LEFT JOIN requirement2exposure ON exposures.id = requirement2exposure.exposures_id WHERE requirement2exposure.requirements_id = :id");

      $this->db->bind(':id', $id);
      
      $results = $this->db->resultset();

      return $results;
    }
    
      
    // Get Exposures unrelated to a requirement
    public function getExposuresByNotReq($id){
      $this->db->query("SELECT exposure, id FROM exposures WHERE id NOT IN (SELECT exposures_id FROM requirement2exposure WHERE requirements_id = :id)");

      $this->db->bind(':id', $id);
      
      $results = $this->db->resultset();

      return $results;
    }


    // Add Exposure
    public function addExposure($data){
      // Prepare Query
      $this->db->query('INSERT INTO exposures (exposure, description, category) 
      VALUES (:exposure, :description, :category)');

      // Bind Values
      $this->db->bind(':exposure', $data['exposure']);
      $this->db->bind(':description', $data['description']);
      $this->db->bind(':category', $data['category']);

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
      $this->db->query('UPDATE exposures SET exposure = :exposure, description = :description, category = :category WHERE id = :id');

      // Bind Values
      $this->db->bind(':id', $data['id']);
      $this->db->bind(':exposure', $data['exposure']);
      $this->db->bind(':description', $data['description']);
      $this->db->bind(':category', $data['category']);
      
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
      $this->db->query('INSERT INTO requirement2exposure (requirements_id, exposures_id) VALUES (:requirements_id, :exposures_id)');

      // Bind Values
      $this->db->bind(':requirements_id', $data['requirements_id']);
      $this->db->bind(':exposures_id', $data['exposures_id']);

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
      $this->db->query('DELETE FROM requirement2exposure WHERE requirements_id = :requirements_id AND exposures_id = :exposures_id');

      // Bind Values
      $this->db->bind(':requirements_id', $data['requirements_id']);
      $this->db->bind(':exposures_id', $data['exposures_id']);

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
      $this->db->query("DELETE FROM exposures WHERE id IN (" . $data['ids'] . ")");

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