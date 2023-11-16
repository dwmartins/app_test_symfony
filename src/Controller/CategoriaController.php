<?php

namespace App\Controller;

use App\Entity\Categoria;
use App\Form\CategoriaType;
use App\Repository\CategoriaRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CategoriaController extends AbstractController
{
    #[Route("/categoria", name: "categoria_index")]
    public function index(CategoriaRepository $categoriaRepository) : Response
    {
        $data['categorias'] = $categoriaRepository->findAll();
        $data['titulo'] = 'Gerenciar Categorias';

        return $this->render('categoria/index.html.twig', $data);
    }

    #[Route("/categoria/adicionar", name: "categoria_adicionar")]
    public function adicionar(Request $request, EntityManagerInterface $em) : Response
    {
        $msg = "";
        $categoria = new Categoria();

        $form = $this->createForm(CategoriaType::class, $categoria);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            //Salvar a nova categoria no DB
            $em->persist($categoria); //Salva na memoria
            $em->flush();
            $msg = "Categoria adicionada com sucesso!";
        }

        $data['titulo'] = 'Adicionar nova categoria';
        $data['form'] = $form;
        $data['msg'] = $msg;

        return $this->renderForm('categoria/form.html.twig', $data);
    }
}