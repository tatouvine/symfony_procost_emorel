<?php

namespace App\Form;


use App\Entity\Employ;
use App\Entity\ManagementWorkingHours;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AddTimeInProjectType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('employ', EntityType::class, [
                'class' => Employ::class,
                'choice_label' => 'lastName',
            ])
            ->add('hours', TextType::class, ['label' => 'hourlyCost']);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ManagementWorkingHours::class,
        ]);
    }
}
