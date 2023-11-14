<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TesteController extends AbstractController
{
    #[Route('/teste', name: 'teste')]
    public function index() : Response
    {
        $data['titulo'] = 'Pagina de teste';
        $data['mensagem'] = 'Aprendendo templates no symfony!';
        $data['frutas'] = [
            [
                'nome' => 'banana',
                'valor' => 1.99
            ],
            [
                'nome' => 'laranja',
                'valor' => 3.99
            ],
            [
                'nome' => 'morango',
                'valor' => 6.99
            ]
        ];

        return $this->render('teste/index.html.twig', $data);
    }

    #[Route('/teste/detalhe/{id}', name: 'detalhe')]
    public function detalhes($id) : Response
    {
        $data['titulo'] = 'Pagina de detalhes';
        $data['id'] = $id;
        return $this->render('teste/detalhes.html.twig', $data);
    }
}