<?php
  class Universal {
    private $db;
    
    public function __construct(){
      $this->db = new Database;
    }

    public function getReferingTables($tablename){
      // returns table names and the respective column names that refer to a given table

      // Prepare Query
      $this->db->query('SELECT table_name, column_name FROM information_schema.KEY_COLUMN_USAGE WHERE REFERENCED_TABLE_NAME = :tablename');
     
      // Bind Values
      $this->db->bind(':tablename', $tablename);

      //Execute
      $results = $this->db->resultset();

      return $results;
  }

  public function getTableColumns($tablename) {
    //retruns the fileds (colum names) of a table as an array.

    $query = "SELECT * FROM " . $tablename . " LIMIT 1";

    // Prepare Query
    $this->db->query($query);

    //Execute
    $results = $this->db->resultset();

    if($results){
        $tabkeys = array_keys((array) $results[0]); //extract array keys into an array
        return $tabkeys;
    }
    else{
        return array();
    }
}

    // Get all entries of a given table
    public function getAll($table){
      $query = "SELECT * FROM " . $table;
      $this->db->query($query);

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