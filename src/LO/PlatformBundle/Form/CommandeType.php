<?php

namespace LO\PlatformBundle\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;


class CommandeType extends AbstractType
{
    private $country = array(
                            'France' => 'France',
                            'Royaumes-Unis' => 'Royaumes-Unis',
                            'Espagne' => '   Espagne',
                            'Italie' => 'Italie',
                            'Portugal' => 'Portugal',
                            'Allemagne' => 'Allemagne',
                            'Suisse' => 'Suisse',
                            'Belgique' => 'Belgique',
                            'Luxembourg' => 'Luxembourg',
                            'Europe' => 'Europe',
                            'Amérique du Nord' => 'Amérique du nord',
                            'Amérique du Sud' => 'Amérique du sud',
                            'Afrique' => 'Afrique',
                            'Asie' => 'Asie');



    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
                ->add('dateVisited',  DateType::class, array(
                            'label' => 'Date de réservation',
                            'widget' =>'single_text',
                            'required' => true))

                ->add('numberVisitor', IntegerType::class, array(
                            'label'    => 'Nombre(s) Visiteur(s)',
                            'attr'=> array('min' => 1 )
                           ))

                ->add('amountPaid', MoneyType::class, array(
                            'label' => 'Montant(s) payé(s)'))

                ->add('email', EmailType::class)

                ->add('codeCommande', TextType::class)

                ->add('country', ChoiceType::class, array(
                            'label'    => 'Pays',
                            'preferred_choices' => array('France'),
                            'choices' => $this->country,
                            'attr'=> array('class' => 'validate')))

                ->add('dateReservation', DateTimeType::class, array(
                            'label' => 'Date de réservation'
    ));


    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'LO\PlatformBundle\Entity\Commande'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'lo_platformbundle_commande';
    }


}
