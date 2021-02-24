<?php

namespace App\Form;


use App\Entity\Employ;
use App\Entity\Job;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EmployType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstName', TextType::class, ['label' => 'firstName'])
            ->add('lastName', TextType::class, ['label' => 'lastName'])
            ->add('email', EmailType::class, ['label' => 'email'])
            ->add('job', EntityType::class, [
                'class'=>Job::class,
                'choice_label'=>'name',
            ])
            ->add('hourlyCost', TextType::class, ['label' => 'hourlyCost'])
            ->add('hiringDate', DateType::class, [
                'widget' => 'single_text',
                'format' => 'yyyy-MM-dd',
                'input' => 'datetime'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Employ::class,
        ]);
    }
}
