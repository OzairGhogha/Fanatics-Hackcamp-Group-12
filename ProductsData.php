<?php

class ProductsData {

    protected $_id, $_name, $_size, $_quantity, $_description, $_price, $_photoName;
    //setting database fields for use
    public function __construct($dbRow) {
        $this->_id = $dbRow['product_id'];
        $this->_name = $dbRow['product_name'];
        $this->_size = $dbRow['product_size'];
        $this->_quantity = $dbRow['product_quantity'];
        $this->_price = $dbRow['product_price'];
        $this->_photoName = $dbRow['product_image'];
        $this->_description = $dbRow['product_description'];

    }
    //accessor methods
    public function getProductID() {
        return $this->_id;
    }

    public function getProductName() {
        return $this->_name;
    }

    public function getProductSize() {
        return $this->_size;
    }

    public function getProductQuantity() {
        return $this->_quantity;
    }

    public function getProductPrice() {
        return $this->_price;
    }

    public function getProductPhotoName() {
        return $this->_photoName;
    }

    public function getProductDescription() {
        return $this->_description;
    }

}

