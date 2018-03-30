<?php
/**
 * Created by PhpStorm.
 * User: axel
 * Date: 30/03/2018
 * Time: 13:32
 */

namespace AppBundle\Forms;


use AppBundle\Entity\Configuration;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class manageRaspberryFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            ->add('name', TextType::class)

            ->add('patient', EntityType::class, array(
                'class' => 'AppBundle:Patient',
                'choice_label' => 'lastName',
                'label' => 'patient',
                'empty_data'  => null,
                'required' => false,
                'attr' => ['class' => 'browser-default'],


            ))

            ->add('save', SubmitType::class, array(
                'attr' => ['class' => 'btn waves-effect waves-light center-align ']

            ));

    }


    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array('user_class' => Configuration::class));
    }
}