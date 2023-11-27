<?php

namespace App\Form;

use App\Entity\News;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class NewsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title',TextType::class,[
                'label' => 'Tytuł',
                'attr' => ['placeholder' => 'tytuł newsa'],
                'help' => 'Wpisz tytuł newsa',
            ])
            ->add('author',TextType::class,[
                'label' => 'Autor',
                'attr' => ['placeholder' => 'autor newsa'],
                'help' => 'Wpisz autora newsa',
            ])
            ->add('content',TextareaType::class,[
                'label' => 'Treść',
                'attr' => ['placeholder' => 'treść newsa'],
                'help' => 'Wpisz treść newsa',
            ])
//            ->add('publishDate')
//            ->add('editedDate')
            ->add('save', SubmitType::class, [
                'attr' => ['class' => 'btn btn-primary'],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => News::class,
        ]);
    }
}
