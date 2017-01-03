<?php
class Learn_DiscountLayerNav_Model_Layer_Filter_Decimal extends Mage_Catalog_Model_Layer_Filter_Decimal
{
    protected $_discountLabel = 'Discount';
    protected $_percentageSymbol = '%';

    protected function _renderItemLabel($range, $value)
    {
        $from   = ($value - 1) * $range ;
        $to     = $value * $range;
		if($this->getName() == $this->_discountLabel)
            return Mage::helper('catalog')->__('%s - %s', $from.$this->_percentageSymbol, $to.$this->_percentageSymbol);
        else
            return Mage::helper('catalog')->__('%s - %s', $from, $to);
    }

    protected function _getItemsData()
    {
        $key = $this->_getCacheKey();

        $data = $this->getLayer()->getAggregator()->getCacheData($key);
        if ($data === null) {
            $data       = array();
            $range      = $this->getRange();
            $dbRanges   = $this->getRangeItemCounts($range);

			/*-  Reversed the discount order   -*/
			if($this->getName() == $this->_discountLabel)
				$dbRanges = array_reverse($dbRanges, true);
			
            foreach ($dbRanges as $index => $count) {
                $data[] = array(
                    'label' => $this->_renderItemLabel($range, $index),
                    'value' => $index . ',' . $range,
                    'count' => $count,
                );
            }
        }
        return $data;
    }
}
