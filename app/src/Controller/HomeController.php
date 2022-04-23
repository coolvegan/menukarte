<?php

namespace App\Controller;

use App\Entity\Gericht;
use App\Repository\GerichtRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(GerichtRepository $gr): Response
    {
        $gerichte = $gr->findAll();
        if(sizeof($gerichte)< 2){
            $gericht1 = new Gericht();
            $gericht1->setBeschreibung('keine Gerichte vorhanden');
            $gericht1->setName('Kein Gericht1');
            $gericht2 = new Gericht();
            $gericht2->setBeschreibung('keine Gerichte vorhanden');
            $gericht2->setName('Kein Gericht2');
            $gerichte[] = $gericht1;
            $gerichte[] = $gericht2;
        }
     
     
        $zufall = array_rand($gerichte, 2);
        return $this->render('home/index.html.twig', [
            'gericht1' => $gerichte[$zufall[0]],
            'gericht2' => $gerichte[$zufall[1]]
        ]);
    }
}
