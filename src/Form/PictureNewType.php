<?php

namespace App\Form;

use App\Entity\City;
use App\Entity\Country;
use App\Entity\Picture;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PictureNewType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('imageFile', FileType::class, ['required' => false])
            ->add('title', TextType::class, ['label' => 'Titre de la photo'])
            ->add('description', TextType::class,['required' => false])
            ->add('author', EntityType::class, ['class' => User::class, 'label' => 'Photographe'])
            ->add('dayOfTaking', TextType::class, ['label'=> 'Date de la prise'])
            ->add('country', EntityType::class, ['class'=>Country::class, 'label'=>'Pays associé'])
            ->add('city', EntityType::class, ['class' => City::class, 'label'=> 'Ville associée']);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Picture::class,
        ]);
    }
}
