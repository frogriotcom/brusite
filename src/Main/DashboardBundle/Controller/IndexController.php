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
		
		$mortageAmount = 4000000;
		$mortageTime   = 240;
		$mortagePercent= 0.1305;

		$amountPercent = 50;
		$amountPercent = $amountPercent / 100;
		$myAmount = $totalAmount * ($amountPercent);
		$amountPayed = 1100000;
		$amountToPay = $myAmount - $amountPayed;

		$monthPercent = $mortagePercent / 12;
		$countedPayment = $mortageAmount * (($monthPercent) / (1 - pow((1 + $monthPercent),( -$mortageTime))));

		$extraPayment = 20000;
		$realTime = 0;

		for ($i = 1; $i <= $mortageTime; ++$i) {

		}
		do {
			$amountToPay = ($amountToPay + $amountToPay * $monthPercent) - $countedPayment - $extraPayment;
			++$realTime;
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
		));
	}
}
