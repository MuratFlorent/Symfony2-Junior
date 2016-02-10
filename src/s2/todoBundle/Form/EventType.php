<?php

namespace s2\todoBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

class EventType extends AbstractType {

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('title')
                ->add('adress')
                ->add('text')
                ->add('date')
                ->add('public', 'choice', array(
                    'choices' => array('0' => 'Non', '1' => 'Oui'),
                    'expanded' => true
                ))
                ->add('tags', 'entity', array(
                    'class' => 's2todoBundle:Tag',
                    'property' => 'name',
                    'multiple' => true,
                    'expanded' => true
                ))
                ->add("file", null, array("label" => "Document"))
                ->add("Save", "submit")
        ;

        $builder->addEventListener(FormEvents::PRE_SET_DATA, function(FormEvent $event) {
            $oEvent = $event->getData();
            $form = $event->getForm();

            if (!$oEvent || null === $oEvent->getId()) {
                $form->add('id', 'hidden');
            }
        });
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 's2\todoBundle\Entity\Event'
        ));
    }

    /**
     * @return string
     */
    public function getName() {
        return 's2_todobundle_event';
    }

}
