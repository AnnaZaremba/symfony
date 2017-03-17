<?php
namespace AppBundle\Controller;

use AppBundle\Entity\Osoba;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class DaneFormController extends Controller
{
    /**
     * @Route("/daneform", name="daneform")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function newAction(Request $request)
    {
        $osoba = new Osoba();

        $form = $this->createFormBuilder($osoba)
            ->add('imie', TextType::class)
            ->add('nazwisko', TextType::class)
            ->add('wiek', IntegerType::class)
            ->getForm();

        return $this->render('default/dane.html.twig', array(
            'form' => $form->createView(),
        ));
    }
}