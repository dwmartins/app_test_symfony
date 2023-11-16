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
use Symfony\Component\Security\Http\Attribute\IsGranted;

class CategoriaController extends AbstractController
{
    #[Route("/categoria", name: "categoria_index")]
    #[IsGranted("ROLE_USER")]
    public function index(CategoriaRepository $categoriaRepository) : Response
    {
        //Restringir a pagina apenas aos ROLE_USER
        $this->denyAccessUnlessGranted('ROLE_USER');
        $data['categorias'] = $categoriaRepository->findAll();
        $data['titulo'] = 'Gerenciar Categorias';

        return $this->render('categoria/index.html.twig', $data);
    }

    #[Route("/categoria/adicionar", name: "categoria_adicionar")]
    #[IsGranted("ROLE_USER")]
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

    #[Route("/categoria/editar/{id}", name: "categoria_editar")]
    #[IsGranted("ROLE_USER")]
    public function editar($id, Request $request, EntityManagerInterface $em, CategoriaRepository $categoriaRepository) : Response 
    {
        $msg = "";
        $categoria = $categoriaRepository->find($id); //Retorna a categoria pelo $id
        $form = $this->createForm(CategoriaType::class, $categoria);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $em->flush(); //Faz o UPDATE da categoria no DB
            $msg = 'Produto atualizado com sucesso!';
        }

        $data['titulo'] = 'Editar categoria';
        $data['form'] = $form;
        $data['msg'] = $msg;

        return $this->renderForm('categoria/form.html.twig', $data);
    }

    #[Route("/categoria/excluir/{id}", name: "categoria_excluir")]
    #[IsGranted("ROLE_USER")]
    public function excluir($id, EntityManagerInterface $em, CategoriaRepository $categoriaRepository ) : Response 
    {
        $categoria = $categoriaRepository->find($id); //Retorna a categoria a nível de memoria

        $em->remove($categoria); // Excluir a categoria do DB
        $em->flush(); // Efetivamente excluir do DB

        return $this->redirectToRoute('categoria_index');
    }
}