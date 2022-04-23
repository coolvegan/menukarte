<?php

namespace App\Controller;

use App\Entity\Gericht;
use App\Entity\Bestellung;
use App\Repository\BestellungRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class BestellungController extends AbstractController
{
    #[Route('/bestellung', name: 'bestellung')]
    public function index(BestellungRepository $bestellungRepository): Response
    {
        $bestellung = $bestellungRepository->findBy(
            ['tisch' => 'tisch1']
        );

        return $this->render('bestellung/index.html.twig', [
            'bestellungen' => $bestellung
        ]);
    }
    
    #[Route('/bestellen/{id}', name: 'bestellen')]
    public function bestellen(Gericht $gericht)
    {
        $bestellung = new Bestellung();
        $bestellung->setTisch('tisch1');
        $bestellung->setName($gericht->getName());
        $bestellung->setBnummer($gericht->getId());
        $bestellung->setPreis($gericht->getPreis());
        $bestellung->setStatus("offen");

        $em = $this->getDoctrine()->getManager();
        $em->persist($bestellung);
        $em->flush();

        $this->addFlash('bestell', $bestellung->getName(). ' wurde zur Bestellung hinzugefügt.');

        return $this->redirect($this->generateUrl('menu'));
    }

        
    #[Route('/status/{id},{status}', name: 'status')]
    public function status($id, $status){
        $em = $this->getDoctrine()->getManager(); 
        $bestellung = $em->getRepository(Bestellung::class)->find($id);
        $bestellung->setStatus($status);
        $em->flush();
        return $this->redirect($this->generateUrl('bestellung'));
    }

    #[Route('/loeschen/{id}', name: 'loeschen')] 
    public function entfernen($id, BestellungRepository $br) {
        $em = $this->getDoctrine()->getManager();
        $bestellung = $br->find($id);
        $em->remove($bestellung);
        $em->flush();

        return $this->redirect($this->generateUrl('bestellung'));
    }
}
