<?php
namespace AppBundle\Controller;

use AppBundle\Entity\Przepis as PrzepisEntity;
use AppBundle\Form\Model\Przepis;
use AppBundle\Form\Type\PrzepisType;
use AppBundle\Repository\Doctrine\KategoriaRepository;
use AppBundle\Repository\Doctrine\PrzepiRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class KsiazkaKucharskaPrzepisyController
 * @package AppBundle\Controller
 *
 * @Route("/ksiazkakucharska/dodajprzepis")
 */
class KsiazkaKucharskaDodajPrzepiController extends Controller
{
    /**
     * @Route("/", name="dodajprzepis")
     * @Template()
     */
    public function dodajPrzepisAction(Request $request)
    {
        $przepis = new Przepis();
        $form = $this->createForm(PrzepisType::class, $przepis);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $przepisBaza = new PrzepisEntity();
            $przepisBaza->setNazwa($przepis->getNazwa());
            $przepisBaza->setSkladniki($przepis->getSkladniki());
            $przepisBaza->setWykonanie($przepis->getWykonanie());
            $przepisBaza->setZrodlo($przepis->getZrodlo());
            $przepisBaza->setUwagi($przepis->getUwagi());
            $przepisBaza->setKategorie($przepis->getKategorie());

            $em->persist($przepisBaza);
            $em->flush();

            return $this->redirectToRoute('przepisdodany');
        }

        $find = $this->getDoctrine()
            ->getRepository('AppBundle:Przepis')
            ->findAll();

        return array(
            'form' => $form->createView(),
            'przepis' => $przepis,
            'find' => $find,
            'kategorie' => (new KategoriaRepository($this->getDoctrine()->getManager()))->getAllOrderByName(),
            'przepisy' => (new PrzepiRepository($this->getDoctrine()->getManager()))->getAllOrderByName(),
        );
    }

    /**
     * @return array
     *
     * @Route("/przepisdodany", name="przepisdodany")
     * @Template()
     */
    public function przepisDodanyAction()
    {
        return [
            'kategorie' => (new KategoriaRepository($this->getDoctrine()->getManager()))->getAllOrderByName(),
        ];
    }

    /**
     * @Route("/usun", name="usunprzepis")
     */
    public function deleteAction(Request $request)
    {
        $id = $request->get('id');

        $przepisBaza = $this->getDoctrine()
            ->getRepository('AppBundle:Przepis')
            ->find($id);

        $em = $this->getDoctrine()->getManager();
        $em->remove($przepisBaza);
        $em->flush();

        return $this->redirectToRoute("dodajprzepis");
    }

    /**
     * @Route("/edytuj", name="edytujprzepis")
     */
    public function editAction(Request $request)
    {
        $id = $request->get('id');
        $przepis = new Przepis();

        if (isset($id)) {
            /** @var PrzepisEntity $przepisBaza */
            $przepisBaza = $this->getDoctrine()
                ->getRepository('AppBundle:Przepis')
                ->find($id);

            $przepis->setId($przepisBaza->getId());
            $przepis->setNazwa($przepisBaza->getNazwa());
            $przepis->setSkladniki($przepisBaza->getSkladniki());
            $przepis->setWykonanie($przepisBaza->getWykonanie());
            $przepis->setZrodlo($przepisBaza->getZrodlo());
            $przepis->setUwagi($przepisBaza->getUwagi());
            $przepis->setKategorie($przepisBaza->getKategorie());
        }

        $form = $this->createForm(PrzepisType::class, $przepis);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $przepisBaza = $this->getDoctrine()
                ->getRepository('AppBundle:Przepis')
                ->find($przepis->getId());

            $em = $this->getDoctrine()->getManager();

            $przepisBaza->setNazwa($przepis->getNazwa());
            $przepisBaza->setSkladniki($przepis->getSkladniki());
            $przepisBaza->setWykonanie($przepis->getWykonanie());
            $przepisBaza->setZrodlo($przepis->getZrodlo());
            $przepisBaza->setUwagi($przepis->getUwagi());
            $przepisBaza->setKategorie($przepis->getKategorie());

            $em->persist($przepisBaza);
            $em->flush();

            return $this->redirectToRoute("dodajprzepis");
        }

        $dane = $this->getDoctrine()
            ->getRepository('AppBundle:Przepis')
            ->findAll();

        return $this->render('@App/KsiazkaKucharskaDodajPrzepi/dodajPrzepis.html.twig', array(
            'form' => $form->createView(),
            'isValid' => $form->isValid(),
            'przepis' => $przepis,
            'dane' => $dane,
            'kategorie' => (new KategoriaRepository($this->getDoctrine()->getManager()))->getAllOrderByName(),
            'przepisy' => (new PrzepiRepository($this->getDoctrine()->getManager()))->getAllOrderByName(),
        ));
    }
}