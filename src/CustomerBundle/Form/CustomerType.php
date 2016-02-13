<?php

namespace CustomerBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use CustomerBundle\Form\AddressType;

class CustomerType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'name',
                'text',
                [
                    'attr' => [
                        'class' => 'col-lg-2',
                    ],
                ]
            )
            ->add(
                'email',
                'email'
            )
            ->add(
                'address',
                AddressType::class,
                [
                    'data_class' => 'CustomerBundle\Entity\Address',
                ]
            );
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'CustomerBundle\Entity\Customer'
        ]);
    }
}
