<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class TwigController extends Controller
{
    /**
     * @Route("/twigg", name="twig")
     * @Template()
     */
    public function indexAction(Request $request)
    {
        return [];
    }
}