<?php

namespace App\Controller;

use App\Repository\PlayerRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index(PlayerRepository $playerRepo)
    {
        $players = $playerRepo->findAll();
        return $this->render('index/index.html.twig', [
            'players' => $players,
        ]);
    }
}
