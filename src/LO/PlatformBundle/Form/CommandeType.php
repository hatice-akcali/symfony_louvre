<?php

namespace LO\PlatformBundle\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;


class CommandeType extends AbstractType
{
    private $isDay = array(
                        'Journee' => 1,
                        'Demi-journee' => 0,
    );




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





                ->add('email', EmailType::class)

                ->add('isDay', ChoiceType::class, array(
                        'label' => 'Type de réservation',
                        'preferred_choices' => array('Demi-journée à partir de 14h'),
                        'choices' => $this->isDay,
                        'attr' => array('class' =>  'validate')))

                ->add('billets', CollectionType::class,array(
                            'entry_type' => BilletType::class,
                            'by_reference' => false,
                            'entry_options' => array(
                                'label' => false,
                                'attr' => array(
                                    'class' => "elementsDiv")),
                            'allow_add' => true,

                            'allow_delete' => true))

                ->add('save', SubmitType::class, array(
                            'attr' => array(
                            'class' => 'btn btn-secondary btn-lg btn-block'
                            ),
                            'label' => 'Valider la commande'))
                ->getForm();

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
