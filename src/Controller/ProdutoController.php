<?php

namespace App\Controller;

use App\Entity\Produto;
use App\Repository\CategoriaRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProdutoController extends AbstractController
{
    #[Route('/produto', name: "produto_index")]
    public function index(EntityManagerInterface $em, CategoriaRepository $categoriaRepository) : Response
    {
        $categoria = $categoriaRepository->find(2); // 2 = Categoria Informática
        $produto = new Produto();
        $produto->setNomeproduto("Notebook");
        $produto->setValor(3000);
        $produto->setCategoria($categoria);

        $msg = "";

        try {
            $em->persist($produto); //Salvar a persistência em nível de memória
            $em->flush(); //Executa em definitivo no banco de dados
            $msg = "Produto cadastrada com sucesso";
        } catch (\Throwable $th) {
            $msg = "Erro ao cadastrar Produto";
        }

        return new Response("<h1>" .$msg. "</h1>");
    }
}