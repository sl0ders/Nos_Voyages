<?php


namespace App\Form;


use App\Data\SearchData;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('cities', EntityType::class,[
                "class"=>"App\Entity\City",
                'required' => false
            ])
            ->add('countries', EntityType::class, [
                "class"=>"App\Entity\Country",
                'required' => false
            ])

        ;}

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => SearchData::class,
        ]);
    }
}