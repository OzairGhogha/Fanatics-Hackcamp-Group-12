<?php
require("dashboard-products.phtml");
require_once("ProductsDataSet.php");
$view = new stdClass();
$productsDataSet = new ProductsDataSet();

// show the default of all records

//if search button is clicked
if (isset($_POST['search']))
{
    $searchTerm = $_POST["search"];
    // only show records that match the entered search term
    $view->productsDataSet=$productsDataSet->getSearchInfo($searchTerm);
}

else
{
    // show the default of all records
    $view->productsDataSet=$productsDataSet->getAllProducts();
}
var_dump($productsDataSet->getAllProducts());
