<?php
require_once 'Model/Product.php';

class Viewpage
{
    private $product;

    public function __construct(Product $product) {
        $this->product = $product;
    }

    public function showViewpage($product_id)
    {
        $product=$this->product->get_product_details($product_id);
        include 'View/Viewpage.php';
    }
}


?>