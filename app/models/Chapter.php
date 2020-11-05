<?php
  class Chapter {
    private $db;
    
    public function __construct(){
      $this->db = new Database;
    }

    // Get All Chapters
    public function getChapters(){
      //$this->db->query("SELECT *, Requirements.ID AS Requirements_ID, Chapters.ID AS Chapters_ID, Requirements.Description AS Requirements_Description, Chapters.Description AS Chapters_Description FROM Chapters LEFT JOIN Requirements ON Chapters_ID = Chapters.ID ORDER BY Sequenz");
      $this->db->query("SELECT * FROM Chapters ORDER BY Sequenz");
      $results = $this->db->resultset();

      return $results;
    }

    // Get relevant Chapters
    public function getRelevantChapters($exposures){
      $exposures = implode(', ', $exposures); 
      $query = "SELECT * FROM Chapters 
      WHERE Type < 3 OR ID IN (SELECT Chapters_ID FROM Requirements LEFT JOIN Requirement2Exposure ON Requirements.ID = Requirement2Exposure.Requirements_ID WHERE Exposures_ID IN (".$exposures.") ) 
      ORDER BY Sequenz";
      $this->db->query($query);
      
      //echo '<pre>' . var_dump($exposures) . '</pre>';

      $results = $this->db->resultset();
      return $results;
    }

    // Get Chapters joined with Requirements, relevant for a set of Exposures
    public function getChaptersIdByExposures($exposures){
      $exposures = implode(', ', $exposures); 
      $query = "SELECT DISTINCT Chapters.ID AS Chapters_ID FROM Chapters 
      LEFT JOIN Requirements ON Chapters_ID = Chapters.ID 
      WHERE Requirements.ID IN (SELECT ID FROM Requirements LEFT JOIN Requirement2Exposure ON Requirements.ID = Requirement2Exposure.Requirements_ID WHERE Exposures_ID IN (".$exposures.") ) 
      ORDER BY Sequenz";
      $this->db->query($query);
      
      //echo '<pre>' . var_dump($exposures) . '</pre>';

      $results = $this->db->resultset();
      return $results;
    }
  }