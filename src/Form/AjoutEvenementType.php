<?php

namespace App\Form;

use App\Entity\Categorie;
use App\Entity\Evenement;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;


class AjoutEvenementType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom')
            ->add('datedebut')
            ->add('datefin')
            ->add('nbrparticipant')
            ->add('image',FileType::class, array('data_class' => null,'required' => false))
            ->add('categories', EntityType::class,['class'=>Categorie::class,'choice_label'=>'nomC'])


            ->add('ajouter', SubmitType::class,[
                'attr' => ['class' => 'btn btn-primary']])

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Evenement::class,
        ]);
    }
}
