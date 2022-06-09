<?php

namespace App\Form;

use App\Entity\THoneyed;
use App\Entity\TApiaries;
use App\Form\THoneyedType;
use App\Entity\TUserAccount;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Security\Core\Security;

class TApiariesType extends AbstractType
{
    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {

        $builder
            ->add('name', TextType::class, [
                'attr' => ['class' => 'form-control'],
                'label' => 'Nom de l\'emplacement'
            ])
            ->add('siteName', TextType::class, [
                'attr' => ['class' => 'form-control'],
                'label' => 'Nom du lieu'
            ])
            // ->add('fkCoordinateGps')
            ->add('noteText', TextareaType::class, [
                'attr' => ['class' => 'form-control'],
                'label' => 'Note',
            ])
            // ->add('fkUser')
            ->add('fkHoneyed', EntityType::class, [
                'class' => THoneyed::class,
                'label' => 'Miellée',
                'attr' => ['class' => 'form-select'],
                // 'expanded' => true,
                'query_builder' => function (EntityRepository  $er) {
                    return $er->createQueryBuilder('honeyed')
                        ->where('honeyed.fkUser = :userId')
                        ->orderBy('honeyed.label', 'ASC')
                        ->setParameter('userId', $this->security->getUser()->getId());
                },
                'choice_label' => 'label'
            ]);
    }
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => TApiaries::class,
        ]);
    }
}
