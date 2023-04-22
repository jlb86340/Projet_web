<?php

namespace App\Form;

use App\Entity\Product;
use Doctrine\ORM\Mapping\Entity;
use PhpParser\Node\Expr\Array_;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
class ProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('libelle',null,
                [
                    'required'=>true,
                    'invalid_message'=>'Renseigner un libelle',
                    'help'=>'Nom du produit'
                ])
            ->add('price')
            ->add('quantStock');
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
        ]);
    }
}
