<?php
  class Chapter {
    private $db;
    
    public function __construct(){
      $this->db = new Database;
    }

    // Get All Chapters
    public function getChapters(){
      $this->db->query("SELECT * FROM chapters ORDER BY sequenz");
      $results = $this->db->resultset();

      return $results;
    }

    // Get relevant Chapters
    public function getRelevantChapters($exposures){
      $exposures = implode(', ', $exposures); 
      $query = "SELECT * FROM chapters 
      WHERE type < 3 OR id IN (SELECT chapters_id FROM requirements LEFT JOIN requirement2exposure ON requirements.id = requirement2exposure.requirements_id WHERE exposures_id IN (".$exposures.") ) 
      ORDER BY sequenz";
      $this->db->query($query);
      
      //echo '<pre>' . var_dump($exposures) . '</pre>';

      $results = $this->db->resultset();
      return $results;
    }

    // Get Chapters joined with Requirements, relevant for a set of Exposures
    public function getChaptersIdByExposures($exposures){
      $exposures = implode(', ', $exposures); 
      $query = "SELECT DISTINCT chapters.id AS chapters_id FROM chapters 
      LEFT JOIN requirements ON chapters_id = chapters.id 
      WHERE requirements.id IN (SELECT id FROM requirements LEFT JOIN requirement2exposure ON requirements.id = requirement2exposure.Requirements_id WHERE exposures_id IN (".$exposures.") ) 
      ORDER BY sequenz";
      $this->db->query($query);
      
      //echo '<pre>' . var_dump($exposures) . '</pre>';

      $results = $this->db->resultset();
      return $results;
    }
  }