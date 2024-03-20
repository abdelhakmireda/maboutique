<?php

class Wishlist
{
    private $id;
    private $id_customer;
    private $products;

    public function __construct($id_customer)
    {
        $this->id_customer = $id_customer;
        $this->products = array();

        $this->loadProducts();
    }

    public function addProduct($id_product, $quantity, $id_product_attribute)
    {
        $this->products[] = array(
            'id_product' => $id_product,
            'quantity' => $quantity,
            'id_product_attribute' => $id_product_attribute,
        );

        $this->saveProducts();
    }

    public function getProducts()
    {
        return $this->products;
    }

    private function loadProducts()
    {
        $this->id_customer = $id_customer;
        $this->products = $this->loadProducts();
    }

    private function loadProducts()
{
    // Requête SQL pour récupérer les produits de la liste d'envie du client
    $db = Db::getInstance();
    $sql = 'SELECT * FROM `' . _DB_PREFIX_ . 'wishlist` w
            LEFT JOIN `' . _DB_PREFIX_ . 'wishlist_product` wp ON w.id_wishlist = wp.id_wishlist
            WHERE w.id_customer = ' . (int)$this->id_customer;
    $results = $db->executeS($sql);

    $products = array();
    foreach ($results as $row) {
        $products[] = array(
            'id_product' => $row['id_product'],
            'quantity' => $row['quantity'],
            'id_product_attribute' => $row['id_product_attribute'],
        );
    }

    return $products;
}


    private function saveProducts()
    {
    if (!empty($this->products)) {
        $sql = 'INSERT INTO `' . _DB_PREFIX_ . 'wishlist` (`id_customer`) VALUES (' . (int)$this->id_customer . ')';
        $db->execute($sql);
        $id_wishlist = $db->Insert_ID();

        foreach ($this->products as $product) {
            $sql = 'INSERT INTO `' . _DB_PREFIX_ . 'wishlist_product` (`id_wishlist`, `id_product`, `quantity`, `id_product_attribute`)
                    VALUES (' . (int)$id_wishlist . ', ' . (int)$product['id_product'] . ', ' . (int)$product['quantity'] . ',';

            if (isset($product['id_product_attribute'])) {
                $sql .= (int)$product['id_product_attribute'];
            } else {
                $sql .= 'NULL';
            }

            $sql .= ')';
            $db->execute($sql);
        }
    }
}
    public function addProduct($id_product, $quantity, $id_product_attribute)
{
    $product = new Product($id_product);

    if ($id_product_attribute) {
        $combination = new Combination($id_product_attribute);
        $product->id_product_attribute = $combination->id;
    }

    $this->products[] = array(
        'id_product' => $product->id,
        'quantity' => $quantity,
        'id_product_attribute' => $product->id_product_attribute,
    );

    $this->saveProducts();
}
}

