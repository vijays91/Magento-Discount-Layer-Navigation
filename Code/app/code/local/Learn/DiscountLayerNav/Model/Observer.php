<?php
class Learn_DiscountLayerNav_Model_Observer
{
    public function updateCustomAttibute($observer) {
        $product = $observer->getEvent()->getProduct();
        $price = $product->getPrice();
        $specialPrice = $product->getSpecialPrice();

        if($specialPrice > 0 && $price) {
            $percentage = ($specialPrice / $price) * 100;
			$percentage = 100 - round($percentage);
        } else {
            $percentage = '';
        }
        $product->setDiscount($percentage);
    }

}
