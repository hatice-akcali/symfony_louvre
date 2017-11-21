<?php

namespace LO\PlatformBundle\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

use Symfony\Component\Form\Extension\Core\Type\ChoiceType;


use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BilletType extends AbstractType
{
    private $ReducedPrice = array(
                            'Handicape' =>  'Handicape',
                            'Etudiant' => 'Etudiant',
                            'Militaire' => 'Militaire',
                            'Employe de musee' => 'Employe de musee',
                            'Service ministère culture' => 'Service ministère culture',
                            'Sur justificatif' => 'Sur justificatif');

    private $isDay = array(
                            'Journee' => 'Journee',
                            'Demi-jounée' => 'Demi-journee',
                            'Demi-journée à partir de 14h'    =>  'Demi-journée à partir de 14h'
    );


    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
                ->add('birthdate', BirthdayType::class, array(
                            'label' => 'Date de naissance',
                            'widget' => 'choice',
                            'format' => 'dd-MM-yyyy'))


                ->add('name',    TextType::class,  array(
                            'label' => 'Nom'))

                ->add('firstname', TextType::class, array(
                            'label' => 'Prénom'))



                ->add('reducedPrice', ChoiceType::class, array(
                            'label'    => 'Tarif réduit',
                            'preferred_choices' => array('Sur justificatif'),
                            'choices' => $this->ReducedPrice,
                            'attr' => array('class' => 'validate')))

                ->add('isDay', ChoiceType::class, array(
                            'label' => 'Type de réservation',
                            'preferred_choices' => array('Demi-journée à partir de 14h'),
                            'choices' => $this->isDay,
                            'attr' => array('class' =>  'validate')))

                ->add('commande', CommandeType::class);
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'LO\PlatformBundle\Entity\Billet'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'lo_platformbundle_billet';
    }


}
