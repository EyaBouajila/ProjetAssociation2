<?php

namespace App\Form;

use App\Entity\Demand;
use App\Entity\Patient;
use App\Entity\Project;
use App\Entity\Worker;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DemandType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('activityType')
            ->add('demandDate',DateType::class, [
                'widget' => 'choice',
            ])
            ->add('activityDueDate')
            ->add('activityGoal')
            ->add('activityFunder')//one funder to one demand
            ->add('workersInvolved',EntityType::class,[
                'class'=>Worker::class,
                'multiple'=>true,
                'attr'=>['class'=>'select2']
                ])
            ->add('targetPatient', EntityType::class,[
                'class'=>Patient::class,
                'multiple'=>true,
                'attr'=>['class'=>'select2']
            ])
            ->add('targetProject',EntityType::class,[
                'class'=>Project::class,
                'multiple'=>true,
                'attr'=>['class'=>'select2']
            ])
            ->add('state', ChoiceType::class, [
                'choices' => [
                    'pending' => 'pending',
                    'toReview' => 'toReview',
                    'acceptedAdmin' => 'acceptedAdmin',
                    'refusedAdmin' => 'refusedAdmin',
                    'acceptedToSA' => 'acceptedToSA',
                    'refusedCEO' => 'refusedCEO',
                    'acceptedToSG' => 'acceptedToSG',
                    'acceptedSG' => 'acceptedSG',
                    'refusedSG' => 'refusedSG',
                ],
            ])
            ->add('save',SubmitType::class)
            ->add('edit',SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Demand::class,
        ]);
    }
}