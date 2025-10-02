<?php

require_once 'Model/Product.php';

class Homepage
{ 
    private $product;

    public function __construct(Product $product) {
        $this->product = $product;
    }

    public function showHomepage()
    {
        $products=$this->product->get_latest_products();
        include 'View/Homepage.php';
    }

}

?>