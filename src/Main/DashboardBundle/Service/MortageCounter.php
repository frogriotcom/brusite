<?php
namespace Main\DashboardBundle\Service;

class MortageCounter
{
    protected $_totalAmount           = 7500000;

    protected $_mortageAmount         = 3000000;
    protected $_mortageTime           = 240;
    protected $_mortagePercent        = 0.1305;

    protected $_amountPayed           = 1500000;
    protected $_amountPercent         = 100;
    protected $_totalAvailablePayment = 62000;
    
    protected $_countedPayment        = 0;
    protected $_realTime              = 0;
    protected $_amountToPay           = 0;
    protected $_extraPayment          = 0;
    protected $_monthPercent          = 0;
    protected $_mortageOverpayment    = 0;
    protected $_monthReport           = array();
    

    public function __construct($config = null)
    {

    }

    public function countMortage()
    {
        $this->_countAmountRate();
        $myAmount = $this->_totalAmount * ($this->_amountPercent);
        $this->_amountToPay = $myAmount - $this->_amountPayed;
        
        $this->_getMonthPercent();
        
        $this->_getCountedPayment($this->_mortageAmount);
        
        $this->_getExtraPayment();

        $this->_core();
    }

    public function getOutput()
    {
        return array(
            'totalAmount'        => $this->_totalAmount,
            'amountPercent'      => $this->_amountPercent,
            'mortageAmount'      => $this->_mortageAmount,
            'myAmount'           => $this->_totalAmount * ($this->_amountPercent),
            'amountPayed'        => $this->_amountPayed,
            'amountToPay'        => $this->_amountToPay,
            'countedPayment'     => $this->_countedPayment,
            'mortageTime'        => $this->_mortageTime,
            'extraPayment'       => $this->_extraPayment,
            'realTime'           => $this->_realTime,
            'monthReport'        => $this->_monthReport,
            'mortageOverpayment' => $this->_mortageOverpayment,            
        );
    }

    protected function _countAmountRate()
    {
        $this->_amountPercent = $this->_amountPercent / 100;
    }

    protected function _getMonthReport()
    {
        $this->_monthReport[] = array(
            'month'            => $this->_realTime,
            'amountToPay'      => $this->_amountToPay,
            'nextPayment'      => $this->_countedPayment,
            'nextExtraPayment' => $this->_extraPayment
        );  
    }

    protected function _getCountedPayment($amount)
    {
        $this->_countedPayment = $this->_amountPercent * $amount * (($this->_monthPercent) / (1 - pow((1 + $this->_monthPercent),( -$this->_mortageTime - $this->_realTime))));
    }

    protected function _getMonthPercent()
    {
        $this->_monthPercent = $this->_mortagePercent / 12;
    }

    protected function _getExtraPayment()
    {
        if (($extraPayment = ($this->_totalAvailablePayment - $this->_countedPayment)) < 0) {
            $extraPayment = $this->_countedPayment;
        }
        $this->_extraPayment = $extraPayment;
    }

    protected function _core()
    {
        $this->_getMonthReport();
        do {
            $this->_amountToPay = ($this->_amountToPay + $this->_amountToPay * $this->_monthPercent) - ($this->_countedPayment + $this->_extraPayment);
            $this->_mortageOverpayment += $this->_amountToPay * $this->_monthPercent;
            ++$this->_realTime;
            if ($this->_extraPayment) {
                $this->_getCountedPayment($this->_amountToPay);
                $this->_getExtraPayment();
            }       
            $this->_getMonthReport();
        } while ($this->_amountToPay > 0);
    }

}
