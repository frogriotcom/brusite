<?php

namespace Main\DashboardBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Main\UserBundle\Document\User;//its for datebase

use Symfony\Component\HttpFoundation\Request; //for requests

use Main\DashboardBundle\Service\MortageCounter; //mortage service

class IndexController extends Controller
{
	public function indexAction()
	{
		/*$dm = $this->get('doctrine_mongodb')->getManager();
		$user = new User();
		$user->setEmail('ilya');
		$dm->persist($user);
		$dm->flush();*/
		ini_set('memory_limit', '2048M');
		$service = new MortageCounter();

		if (($request = $this->getRequest()) && $request->isMethod('POST')) {
			//var_dump($this->getRequest()->request->all());die;
			//save and recount;
		}

		$service->countMortage();

		return $this->render('MainDashboardBundle:Index:index.html.twig', $service->getOutput());
	}
}
