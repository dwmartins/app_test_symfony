<?php

namespace App\Form;

use App\Entity\Categoria;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

Class ProdutoType extends AbstractType{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nomeproduto', TextType::class, ['label' => 'Nome do Produto: '])
            ->add('valor', TextType::class, ['label' => 'Valor do produto: '])
            ->add('categoria_id', EntityType::class, [
                'class' => Categoria::class,
                'choice_label' => 'descricaocategoria',
                'label' => 'Categoria: '
            ])
            ->add('Salvar', SubmitType::class);
    }
}