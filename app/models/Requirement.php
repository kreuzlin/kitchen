<?php
  class Requirement {
    private $db;
    
    public function __construct(){
      $this->db = new Database;
    }

    // Get All Requirements
    public function getRequirements(){
      $this->db->query("SELECT re.id, re.requirement, re.area, re.description, re.examples, re.relevant, re.standard, ch.chapter FROM requirements AS re LEFT JOIN chapters AS ch ON chapters_id = ch.id");

      $results = $this->db->resultset();

      return $results;
    }

    // Get Requirement By ID
    public function getRequirementById($id){
      $this->db->query("SELECT re.id, re.requirement, re.area, re.description, re.examples, re.relevant, re.standard, ch.chapter FROM requirements AS re LEFT JOIN chapters AS ch ON chapters_id = ch.id WHERE re.id = :id");

      $this->db->bind(':id', $id);
      
      $row = $this->db->single();

      return $row;
    }

    // Get Requirement By Chapter ID
    public function getRequirementsByChapterId($id){
      $this->db->query("SELECT * FROM requirements WHERE chapters_id = :id");

      $this->db->bind(':id', $id);
      
      $results = $this->db->resultset();

      return $results;
    }

    // Get Requirements related to a set of Exposures
    public function getRequirementsByExposures($exposures){
      $exposures = implode(', ', $exposures); 
      $query = "SELECT requirements.id, requirements.requirement, requirements.description FROM requirements 
      LEFT JOIN requirement2exposure ON requirements.id = requirement2exposure.requirements_id 
      WHERE requirement2exposure.exposures_id IN (".$exposures.")";
      
      $this->db->query($query);
      
      $results = $this->db->resultset();

      return $results;
    }

    // Get Requirements related to a Chapter ID and related to a set of Exposures
    public function getRequirementsByExposuresAndChapter($exposures, $id){
      $exposures = implode(', ', $exposures); 
      $query = "SELECT requirements.id, requirements.requirement, requirements.description FROM requirements 
      LEFT JOIN requirement2exposure ON requirements.id = requirement2exposure.requirements_id 
      WHERE requirement2exposure.exposures_id IN (".$exposures.") AND chapters_id = :id";
      
      $this->db->query($query);

      $this->db->bind(':id', $id);
      
      $results = $this->db->resultset();

      return $results;
    }
    
    // Get Requirements related to a exposure
    public function getRequirementsByExp($id){
      $this->db->query("SELECT requirements.id, requirements.requirement FROM requirements LEFT JOIN requirement2exposure ON requirements.id = requirement2exposure.requirements_id WHERE requirement2exposure.exposures_id = :id");

      $this->db->bind(':id', $id);
      
      $results = $this->db->resultset();

      return $results;
    }

    // Get Requirements related to a risk
    public function getRequirementsByRisk($id){
      $this->db->query("SELECT requirements.id, requirements.requirement FROM requirements LEFT JOIN requirement2risk ON requirements.id = requirement2risk.requirements_id WHERE requirement2risk.risks_id = :id");

      $this->db->bind(':id', $id);
      
      $results = $this->db->resultset();

      return $results;
        }

    // Get Requirements not related to a exposure
    public function getRequirementsByNotExp($id){
      $this->db->query("SELECT requirement, id FROM requirements WHERE relevant = TRUE AND id NOT IN (SELECT requirements_id FROM requirement2exposure WHERE exposures_id = :id)");

      $this->db->bind(':id', $id);
      
      $results = $this->db->resultset();

      return $results;
    }

    // Get Requirements not related to a risk
    public function getRequirementsByNotRisk($id){
      $this->db->query("SELECT requirement, id FROM requirements WHERE id NOT IN (SELECT requirements_id FROM requirement2risk WHERE risks_id = :id)");

      $this->db->bind(':id', $id);
      
      $results = $this->db->resultset();

      return $results;
    }
    

    // Add Requirement
    public function addRequirement($data){
      // Prepare Query
      $this->db->query('INSERT INTO requirements (requirement, description, area, standard, examples, chapters_id, relevant) 
      VALUES (:requirement, :description, :area, :standard, :examples, :chapters_id, :relevant)');

      // Bind Values
      $this->db->bind(':requirement', $data['requirement']);
      $this->db->bind(':description', $data['description']);
      $this->db->bind(':area', $data['area']);
      $this->db->bind(':standard', $data['standard']);
      $this->db->bind(':examples', $data['examples']);
      $this->db->bind(':chapters_id', $data['chapters_id']);
      $this->db->bind(':relevant', $data['relevant']);

      //Execute
      if($this->db->execute()){
        return true;
      } else {
        return false;
      }
    }

    // Update Requirement
    public function updateRequirement($data){
      // Prepare Query
      $this->db->query('UPDATE requirements SET requirement = :requirement, description = :description, area = :area, standard = :standard, examples = :examples, chapters_id = :chapters_id, relevant = :relevant WHERE id = :id');

      // Bind Values
      $this->db->bind(':id', $data['id']);
      $this->db->bind(':requirement', $data['requirement']);
      $this->db->bind(':description', $data['description']);
      $this->db->bind(':area', $data['area']);
      $this->db->bind(':standard', $data['standard']);
      $this->db->bind(':examples', $data['examples']);
      $this->db->bind(':chapters_id', $data['chapters_id']);
      $this->db->bind(':relevant', $data['relevant']);
      
      //Execute
      if($this->db->execute()){
        return true;
      } else {
        return false;
      }
    }

    // Add Risk to Requriement
    public function addRiskToReq($data){
      //echo '<pre>' . var_dump($data) . '</pre>';
      // Prepare Query
      $this->db->query('INSERT INTO requirement2risk (requirements_id, risks_id) VALUES (:requirements_id, :risks_id)');

      // Bind Values
      $this->db->bind(':requirements_id', $data['requirements_id']);
      $this->db->bind(':risks_id', $data['risks_id']);

      //Execute
      if($this->db->execute()){
        return true;
      } else {
        return false;
      }

    }
    // Remove Risks from Requirement
    public function removeRiskFromReq($data){
      //echo '<pre>' . var_dump($data) . '</pre>';
      // Prepare Query
      $this->db->query('DELETE FROM requirement2risk WHERE requirements_id = :requirements_id AND risks_id = :risks_id');

      // Bind Values
      $this->db->bind(':requirements_id', $data['requirements_id']);
      $this->db->bind(':risks_id', $data['risks_id']);

      //Execute
      if($this->db->execute()){
        return true;
      } else {
        return false;
      }
    }

    // Add Exposure to Requriement
    public function addExposureToReq($data){
      //echo '<pre>' . var_dump($data) . '</pre>';
      // Prepare Query
      $this->db->query('INSERT INTO requirement2exposure (requirements_id, exposures_id) VALUES (:requirements_id, :exposures_id)');

      // Bind Values
      $this->db->bind(':requirements_id', $data['requirements_id']);
      $this->db->bind(':exposures_ID', $data['exposures_id']);

      //Execute
      if($this->db->execute()){
        return true;
      } else {
        return false;
      }
    }

    // Remove Exposure from Requirement
    public function removeExposureFromReq($data){
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

    // Delete Requirement
    public function deleteRequirement($data){
      // Prepare Query
      $this->db->query("DELETE FROM requirements WHERE id IN (" . $data['ids'] . ")");

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