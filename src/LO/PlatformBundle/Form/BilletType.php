<?php

namespace LO\PlatformBundle\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BilletType extends AbstractType
{
    private $country = array(
                            'France' => 'France',
                            'Royaumes-Unis' => 'Royaumes-Unis',
                            'Espagne' => 'Espagne',
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
                ->add('birthdate', BirthdayType::class, array(
                            'label' => 'Date de naissance',
                            'widget' => 'choice',
                            'format' => 'dd-MM-yyyy'))


                ->add('name',    TextType::class,  array(
                            'label' => 'Nom'))

                ->add('firstname', TextType::class, array(
                            'label' => 'Prénom'))

                ->add('country', ChoiceType::class, array(
                            'label'    => 'Pays',
                            'preferred_choices' => array('France'),
                            'choices' => $this->country,
                            'attr'=> array('class' => 'validate')))

                ->add('reducedPrice', CheckboxType::class, array(
                            'label'    => 'Tarif réduit (Un justificatif vous sera demandé, pour étudiant, militaire, handicapé etc..',
                            'required' => false,
                            'value' => 1))

                ->getForm();
        ;
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
