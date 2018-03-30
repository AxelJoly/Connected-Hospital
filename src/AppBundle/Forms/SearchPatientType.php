<?php
/**
 * Created by PhpStorm.
 * User: axel
 * Date: 15/03/2018
 * Time: 12:53
 */

namespace AppBundle\Forms;


use AppBundle\Entity\Doctor;
use AppBundle\Entity\Patient;
use PUGX\AutocompleterBundle\Form\Type\AutocompleteType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SearchPatientType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('patients', AutocompleteType::class, ['class' => Patient::class])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array('user_class' => Doctor::class));
    }

}