<?php

namespace App\Form;

use App\Entity\Oeuvre;
use App\Entity\Categorie;
use phpDocumentor\Reflection\Type;
use phpDocumentor\Reflection\Types\Array_;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Vich\UploaderBundle\Form\Type\VichImageType;
use Vich\UploaderBundle\VichUploaderBundle;

class OeuvreType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nomartiste')
            ->add('titre')
            ->add('image', HiddenType::class)
            ->add('duree')
//            ->add('categorie',ChoiceType::class, [
//                'choices'  => [
//                    new Categorie()
//                ]])
            ->add('categorie',EntityType::class, array('class'=>'App\Entity\Categorie','choice_label'=>'nomcategorie','multiple'=>false))
           /* ->add('imageFile', VichImageType::class, Array(
                'required' => false,
                'alllow_delete'=>true,
                'download_link'=> true))*/
           ->add('imageFile',VichImageType::class,[
               'required'=> false,
               'allow_delete'=> false,
               'download_link'=> false,
               'empty_data' => '',
               'data_class' => null
           ])
//            ->add('enregister', SubmitType::class)


        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Oeuvre::class,
        ]);
    }
}
