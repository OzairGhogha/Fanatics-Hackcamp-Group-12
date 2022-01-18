<?php
require_once("database.php");
require_once("ProductsData.php");

class ProductsDataSet {

    private $db;

    public function __construct()
    {
        $this->db = new Database;
        $this->db = $this->db->getdbConnection();
    }

    public function getAllProducts(){
        $sqlQuery = ('SELECT * FROM ProductInformation');
        $statement = $this->db->prepare($sqlQuery); // prepare a PDO statement
        $statement->execute(); // execute the PDO statement
        //creating an array to store the results
        $dataSet = [];
        //looping through results and storing them using an object
        while ($row = $statement->fetch()) {
            $dataSet[] = new ProductsData($row);
        }
        return $dataSet;

    }

    // used for search function to return values similar to users input
    public function getSearchInfo($searchText) {
        //filters by firstname or lastname or user id or username
        $sqlQuery = ("SELECT * FROM ProductInformation WHERE product_id LIKE '". $searchText . "' OR product_name LIKE '". $searchText . "' or product_description LIKE '". $searchText . "' or product_price LIKE '". $searchText . "'");
        $statement = $this->db->prepare($sqlQuery);// prepare a PDO statement
        $statement->execute();// execute the PDO statement
        //creating an array to store the results
        $dataSet = [];
        //looping through results and storing them using an object
        while ($row = $statement->fetch()) {
            $dataSet[] = new ProductsData($row);
        }
        return $dataSet;
    }
}


