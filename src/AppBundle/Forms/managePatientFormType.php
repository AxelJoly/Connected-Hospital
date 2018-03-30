<?php
/**
 * Created by PhpStorm.
 * User: axel
 * Date: 19/02/2018
 * Time: 13:58
 */

namespace AppBundle\Forms;


use AppBundle\Entity\Patient;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;


class managePatientFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            ->add('firstName', TextType::class)
            ->add('lastName', TextType::class)
            ->add('birthday', DateType::class, array(
                'placeholder' => 'Date de naissance',
                'widget' => 'single_text',
                'html5' => false,
                'format' => 'yyyy-MM-dd',

            ))
            ->add('relativePhone', NumberType::class)
            ->add('description', TextType::class)

               ->add('effectiveDate', DateTimeType::class, array(
                   'date_widget' => "single_text",
                   'time_widget' => "single_text",
                   'label' => "Date d'occupation",

               ))
               ->add('releaseDate', DateTimeType::class, array(
                   'date_widget' => "single_text",
                   'time_widget' => "single_text",
                   'label' => "Date de libération",
               ))
            ->add('seat', EntityType::class, array(
                'class' => 'AppBundle:Seat',
                'choice_label' => 'name',
                'label' => 'name',
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
        $resolver->setDefaults(array('user_class' => Patient::class));
    }
}