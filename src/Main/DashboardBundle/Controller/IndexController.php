<?php

namespace Main\DashboardBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Main\UserBundle\Document\User;//its for datebase

use Symfony\Component\HttpFoundation\Request; //what for?

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
		$mortageOverpayment = 0;
		$mortageTime   = 240;
		$mortagePercent= 0.1305;

		$amountPercent = 50;
		$amountPercent = $amountPercent / 100;
		$myAmount = $totalAmount * ($amountPercent);
		$amountPayed = 1500000;		
		$amountToPay = $myAmount - $amountPayed;
		$monthPercent = $mortagePercent / 12;
		$countedPayment = $amountPercent * $mortageAmount * (($monthPercent) / (1 - pow((1 + $monthPercent),( -$mortageTime))));
		
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
			$mortageOverpayment += $amountToPay * $monthPercent;
			++$realTime;
			if ($extraPayment) {
				$countedPayment = $amountPercent * $amountToPay * (($monthPercent) / (1 - pow((1 + $monthPercent),( -($mortageTime-$realTime) ) )));
				$extraPayment = $totalAvailablePayment - $countedPayment;				
			}		
			$monthReport[] = array(
				'month'            => $realTime,
				'amountToPay'      => $amountToPay,
				'nextPayment'      => $countedPayment,
				'nextExtraPayment' => $extraPayment
			);	
		} while ($amountToPay > 0);

		$task = array();
		$form = $this->createFormBuilder($task)->getForm();

		
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
			'monthReport'    => $monthReport,
			'mortageOverpayment' => $mortageOverpayment,
			'form' => $form->createView(),
		));
	}
}
