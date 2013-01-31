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
		
		return $this->render('MainDashboardBundle:Index:index.html.twig', array('name' => 1));
	}
}
