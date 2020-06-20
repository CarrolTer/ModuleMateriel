<?php

namespace App\Form;

use App\Entity\Materiel;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MaterielType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom', TextType::class, [
                'attr' => [
                    'autofocus' => true,
                    'class' => 'form-control'],
                ])
            ->add('prix', MoneyType::class, [
                'attr' => [
                    'autofocus' => true,
                    'class' => 'form-control'],
                'divisor' => 100])
            ->add('quantite', TextType::class, [
                'attr' => [
                    'autofocus' => true,
                    'class' => 'form-control',],
                ])
            ->add('Created_At')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Materiel::class,
        ]);
    }
}
