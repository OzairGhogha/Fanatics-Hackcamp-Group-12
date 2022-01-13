<?php
require_once("database.php");
class User
{

    private $db;
    public $username;


    public function __construct(){
        $this->db = new Database;
    }
    //check for the username value in the table
    public function findUserByUsername($username){
        $this->db->query('SELECT * FROM SellerInformation WHERE username = :username');
        $this->db->bind(':username', $username);
        $row = ($this->db->single());
        //check row
        if($this->db->rowCount()>0){
            return $row;}
        else{
            return false;
        }
    }
    //register the user using the data provided
    public function register($data){
        $this->db->query('INSERT INTO SellerInformation (firstname, lastname, username, password) 
        VALUES (:firstname, :lastname, :username, :password)');
        //Bind values
        $this->db->bind(':firstname', $data['firstname']);
        $this->db->bind(':lastname', $data['lastname']);
        $this->db->bind(':username', $data['username']);
        $this->db->bind(':password', $data['password']);

        //Execute
        if($this->db->execute()){
            return true;
        }else{
            return false;
        }
    }
    //Login user
    public function login($username, $password){
        $row = $this->findUserByUsername($username);
        if($row == false) return false;

        $hashedPassword = $row->password;
        if(password_verify($password, $hashedPassword)){
            return $row;
        }else{
            return false;
        }
    }
    //get the ID
    public function getUsersID($username){
        $this->db->query('SELECT id FROM SellerInformation WHERE username = :username');
        $this->db->bind(':username', $username);
        $row = ($this->db->single());
        //check row
        if($this->db->rowCount()>0){
            return $row;}
        else{
            return false;

        }
    }


}