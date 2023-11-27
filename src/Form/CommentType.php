<?php

namespace App\Form;

use App\Entity\Comment;
use App\Entity\News;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class CommentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
             ->add('author',TextType::class,[
                'label' => 'Autor',
                'attr' => ['placeholder' => 'autor komentarza'],
                'help' => 'Wpisz autora komentarza',
            ])
            ->add('title',TextType::class,[
                'label' => 'Tytuł',
                'attr' => ['placeholder' => 'tytuł komentarza'],
                'help' => 'Wpisz tytuł komentarza',
            ])
            ->add('content',TextareaType::class,[
                'label' => 'Treść',
                'attr' => ['placeholder' => 'treść komentarza'],
                'help' => 'Wpisz treść komentarza',
            ])
            ->add('save', SubmitType::class, [
                'label' => 'Dodaj komentarz',
                'attr' => ['class' => 'btn btn-primary'],

            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Comment::class,
        ]);
    }
}
