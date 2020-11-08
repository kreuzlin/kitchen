<?php
  class Requirement {
    private $db;
    
    public function __construct(){
      $this->db = new Database;
    }

    // Get All Requirements
    public function getRequirements(){
      $this->db->query("SELECT re.ID, re.Requirement, re.Area, re.Description, re.Examples, re.Relevant, re.Standard, ch.Chapter FROM Requirements AS re LEFT JOIN Chapters AS ch ON Chapters_ID = ch.ID");

      $results = $this->db->resultset();

      return $results;
    }

    // Get Requirement By ID
    public function getRequirementById($id){
      $this->db->query("SELECT re.ID, re.Requirement, re.Area, re.Description, re.Examples, re.Relevant, re.Standard, ch.Chapter FROM Requirements AS re LEFT JOIN Chapters AS ch ON Chapters_ID = ch.ID WHERE re.ID = :id");

      $this->db->bind(':id', $id);
      
      $row = $this->db->single();

      return $row;
    }

    // Get Requirement By Chapter ID
    public function getRequirementsByChapterId($id){
      $this->db->query("SELECT * FROM Requirements WHERE Chapters_ID = :id");

      $this->db->bind(':id', $id);
      
      $results = $this->db->resultset();

      return $results;
    }

    // Get Requirements related to a set of Exposures
    public function getRequirementsByExposures($exposures){
      $exposures = implode(', ', $exposures); 
      $query = "SELECT Requirements.ID, Requirements.Requirement, Requirements.Description FROM Requirements 
      LEFT JOIN Requirement2Exposure ON Requirements.ID = Requirement2Exposure.Requirements_ID 
      WHERE Requirement2Exposure.Exposures_ID IN (".$exposures.")";
      
      $this->db->query($query);
      
      $results = $this->db->resultset();

      return $results;
    }

    // Get Requirements related to a Chapter ID and related to a set of Exposures
    public function getRequirementsByExposuresAndChapter($exposures, $id){
      $exposures = implode(', ', $exposures); 
      $query = "SELECT Requirements.ID, Requirements.Requirement, Requirements.Description FROM Requirements 
      LEFT JOIN Requirement2Exposure ON Requirements.ID = Requirement2Exposure.Requirements_ID 
      WHERE Requirement2Exposure.Exposures_ID IN (".$exposures.") AND Chapters_ID = :id";
      
      $this->db->query($query);

      $this->db->bind(':id', $id);
      
      $results = $this->db->resultset();

      return $results;
    }
    
    // Get Requirements related to a set of exposures
    // public function getRequirementsByExposures($exposures){
    //   $this->db->query("SELECT Requirements.ID, Requirements.Requirement FROM Requirements LEFT JOIN Requirement2Exposure ON Requirements.ID = Requirement2Exposure.Requirements_ID WHERE Requirement2Exposure.Exposures_ID IN (:exposures)");

    //   $exposures = implode(', ', $exposures); 
    //   $this->db->bind(':exposures', $exposures);
      
    //   $results = $this->db->resultset();

    //   return $results;
    // }

    // Get Requirements related to a exposure
    public function getRequirementsByExp($id){
      $this->db->query("SELECT Requirements.ID, Requirements.Requirement FROM Requirements LEFT JOIN Requirement2Exposure ON Requirements.ID = Requirement2Exposure.Requirements_ID WHERE Requirement2Exposure.Exposures_ID = :id");

      $this->db->bind(':id', $id);
      
      $results = $this->db->resultset();

      return $results;
    }

    // Get Requirements related to a risk
    public function getRequirementsByRisk($id){
      $this->db->query("SELECT Requirements.ID, Requirements.Requirement FROM Requirements LEFT JOIN Requirement2Risk ON Requirements.ID = Requirement2Risk.Requirements_ID WHERE Requirement2Risk.Risks_ID = :id");

      $this->db->bind(':id', $id);
      
      $results = $this->db->resultset();

      return $results;
        }

    // Get Requirements not related to a exposure
    public function getRequirementsByNotExp($id){
      $this->db->query("SELECT Requirement, ID FROM Requirements WHERE ID NOT IN (SELECT Requirements_ID FROM Requirement2Exposure WHERE Exposures_ID = :id)");

      $this->db->bind(':id', $id);
      
      $results = $this->db->resultset();

      return $results;
    }

    // Get Requirements not related to a risk
    public function getRequirementsByNotRisk($id){
      $this->db->query("SELECT Requirement, ID FROM Requirements WHERE ID NOT IN (SELECT Requirements_ID FROM Requirement2Risk WHERE Risks_ID = :id)");

      $this->db->bind(':id', $id);
      
      $results = $this->db->resultset();

      return $results;
    }
    

    // Add Requirement
    public function addRequirement($data){
      // Prepare Query
      $this->db->query('INSERT INTO Requirements (Requirement, Description, Area, Standard, Examples, Chapters_ID, Relevant) 
      VALUES (:Requirement, :Description, :Area, :Standard, :Examples, :Chapters_ID, :Relevant)');

      // Bind Values
      $this->db->bind(':Requirement', $data['requirement']);
      $this->db->bind(':Description', $data['description']);
      $this->db->bind(':Area', $data['area']);
      $this->db->bind(':Standard', $data['standard']);
      $this->db->bind(':Examples', $data['examples']);
      $this->db->bind(':Chapters_ID', $data['chapters_ID']);
      $this->db->bind(':Relevant', $data['relevant']);

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
      $this->db->query('UPDATE Requirements SET Requirement = :Requirement, Description = :Description, Area = :Area, Standard = :Standard, Examples = :Examples, Chapters_ID = :Chapters_ID, Relevant = :Relevant WHERE ID = :id');

      // Bind Values
      $this->db->bind(':id', $data['ID']);
      $this->db->bind(':Requirement', $data['Requirement']);
      $this->db->bind(':Description', $data['Description']);
      $this->db->bind(':Area', $data['Area']);
      $this->db->bind(':Standard', $data['Standard']);
      $this->db->bind(':Examples', $data['Examples']);
      $this->db->bind(':Chapters_ID', $data['Chapters_ID']);
      $this->db->bind(':Relevant', $data['Relevant']);
      
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
      $this->db->query('INSERT INTO Requirement2Risk (Requirements_ID, Risks_ID) VALUES (:Requirements_ID, :Risks_ID)');

      // Bind Values
      $this->db->bind(':Requirements_ID', $data['requirements_id']);
      $this->db->bind(':Risks_ID', $data['risks_id']);

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
      $this->db->query('DELETE FROM Requirement2Risk WHERE Requirements_ID = :Requirements_ID AND Risks_ID = :Risks_ID');

      // Bind Values
      $this->db->bind(':Requirements_ID', $data['requirements_id']);
      $this->db->bind(':Risks_ID', $data['risks_id']);

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

    // Remove Exposure from Requirement
    public function removeExposureFromReq($data){
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

    // Delete Requirement
    public function deleteRequirement($data){
      // Prepare Query
      $this->db->query("DELETE FROM Requirements WHERE ID IN (" . $data['IDs'] . ")");

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