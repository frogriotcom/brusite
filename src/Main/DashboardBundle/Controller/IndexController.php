<?php

namespace Main\DashboardBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Main\UserBundle\Document\User;

class IndexController extends Controller
{
	public function indexAction()
	{
		/*$dm = $this->get('doctrine_mongodb')->getManager();
		$user = new User();
		$user->setEmail('ilya');
		$dm->persist($user);
		$dm->flush();*/

		$totalAmount   = 7500000;
		
		$mortageAmount = 3000000;
		$mortageTime   = 240;
		$mortagePercent= 0.1305;

		$amountPercent = 50;
		$amountPercent = $amountPercent / 100;
		$myAmount = $totalAmount * ($amountPercent);
		$amountPayed = 1500000;		
		$amountToPay = $myAmount - $amountPayed;
		$monthPercent = $mortagePercent / 12;
		$countedPayment = $mortageAmount * (($monthPercent) / (1 - pow((1 + $monthPercent),( -$mortageTime))));
		$countedPayment = $countedPayment/2;

		$extraPayment = 0;
		$totalAvailablePayment = 42000;
		$extraPayment = $totalAvailablePayment - $countedPayment;
		$realTime = 0;

		$monthReport = array();
		$monthReport[] = array(
			'month'            => $realTime,
			'amountToPay'      => $amountToPay,
			'nextPayment'      => $countedPayment,
			'nextExtraPayment' => $extraPayment
		);	
		do {
			$amountToPay = ($amountToPay + $amountToPay * $monthPercent) - ($countedPayment + $extraPayment);
			++$realTime;
			if ($extraPayment) {
				$countedPayment = $amountToPay * (($monthPercent) / (1 - pow((1 + $monthPercent),( -($mortageTime-$realTime) ) )));
				$extraPayment = $totalAvailablePayment - $countedPayment;				
			}		
			$monthReport[] = array(
				'month'            => $realTime,
				'amountToPay'      => $amountToPay,
				'nextPayment'      => $countedPayment,
				'nextExtraPayment' => $extraPayment
			);	
		} while ($amountToPay > 0);
		
		return $this->render('MainDashboardBundle:Index:index.html.twig', array(
			'totalAmount'    => $totalAmount,
			'amountPercent'  => $amountPercent,
			'mortageAmount'  => $mortageAmount,
			'myAmount'       => $myAmount,
			'amountPayed'    => $amountPayed,
			'amountToPay'    => $amountToPay,
			'countedPayment' => $countedPayment,
			'mortageTime'    => $mortageTime,
			'extraPayment'   => $extraPayment,
			'realTime'       => $realTime,
			'monthReport'    => $monthReport
		));
	}
}
