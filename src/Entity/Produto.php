<?php

namespace App\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use App\Repository\ProdutoRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: ProdutoRepository::class)]
class Produto
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups('api_list')]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    #[Assert\NotBlank]
    #[Assert\Length(
        min: 3,
        max: 50,
        minMessage: 'O campo nome do Produto deve conter mais de {{ limit }} caracteres.',
        maxMessage: 'O campo nome do Produto deve conter no máximo {{ limit }} caracteres',
    )]
    #[Groups('api_list')]
    private ?string $nomeproduto = null;

    #[ORM\Column]
    #[Assert\NotBlank]
    #[Assert\Positive(message: "O campo Valor deve conter um número positivo.")]
    #[Groups('api_list')]
    private ?float $valor = null;

    #[ORM\ManyToOne(inversedBy: 'produtos')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups('api_list')]
    private ?Categoria $categoria = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomeproduto(): ?string
    {
        return $this->nomeproduto;
    }

    public function setNomeproduto(string $nomeproduto): static
    {
        $this->nomeproduto = $nomeproduto;

        return $this;
    }

    public function getValor(): ?float
    {
        return $this->valor;
    }

    public function setValor(float $valor): static
    {
        $this->valor = $valor;

        return $this;
    }

    public function getCategoria(): ?Categoria
    {
        return $this->categoria;
    }

    public function setCategoria(?Categoria $categoria): static
    {
        $this->categoria = $categoria;

        return $this;
    }
}
