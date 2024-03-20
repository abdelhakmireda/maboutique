<?php

class WishlistFrontController extends ModuleFrontController
{
    public function init()
    {
        parent::init();

        $this->addMyAccountLink('wishlist', $this->l('Ma liste d\'envie'), 'my-wishlist');
    }

    public function postProcessAddProductToWishlist()
    {
        $productId = Tools::getValue('id_product');
        $quantity = Tools::getValue('quantity');
        $idCombination = Tools::getValue('id_product_attribute');

        if ($productId && $quantity) {
            $wishlist = $this->getWishlist();
            $wishlist->addProduct($productId, $quantity, $idCombination);

            $this->context->smarty->assign('confirmation', 'Produit ajouté à votre liste d\'envie');
        }

        $this->ajaxRender(array(
            'success' => true,
            'message' => 'Produit ajouté à votre liste d\'envie',
        ));
    }

    public function processDisplayMyWishlist()
    {
         $wishlist = $this->getWishlist();
        $products = $wishlist->getProducts();

        $this->context->smarty->assign('products', $products);
    }

    public function postProcessAddProductsToCart()
    {
        $products = $this->context->cookie->wishlist;

        if (!empty($products)) {
            foreach ($products as $product) {
                $idProduct = $product['id_product'];
                $quantity = $product['quantity'];
                $idCombination = $product['id_product_attribute'];

                Cart::addProduct($idProduct, $quantity, $idCombination);
            }

            $this->context->cookie->wishlist = array();
            $this->context->smarty->assign('confirmation', 'Produits ajoutés au panier');
        } else {
            $this->context->smarty->assign('error', 'Votre liste d\'envie est vide');
        }

        $this->redirectWithNotifications('my-account');
    }

    private function getWishlist()
    {
        $idCustomer = $this->context->customer->id;

        if (!$idCustomer) {
            return false;
        }

        $wishlist = new Wishlist($idCustomer);

        return $wishlist;
    }
    
    public function ajaxProcessAddProductToWishlist()
    {
    $productId = Tools::getValue('id_product');
    $quantity = Tools::getValue('quantity');
    $idCombination = Tools::getValue('id_product_attribute');

    $result = array(
        'success' => false,
        'message' => 'Une erreur est survenue.',
    );

    if ($productId && $quantity) {
        $wishlist = $this->getWishlist();
        $wishlist->addProduct($productId, $quantity, $idCombination);

        $result['success'] = true;
        $result['message'] = 'Produit ajouté à votre liste d\'envie';
    }

    $this->ajaxRender($result);
}
}