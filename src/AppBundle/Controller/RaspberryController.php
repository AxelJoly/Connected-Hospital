<?php
/**
 * Created by PhpStorm.
 * User: axel
 * Date: 30/03/2018
 * Time: 11:05
 */

namespace AppBundle\Controller;


use AppBundle\Entity\Configuration;
use AppBundle\Entity\EncryptedPatient;
use AppBundle\Entity\Patient;
use AppBundle\Forms\managePatientFormType;
use AppBundle\Forms\manageRaspberryFormType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;

class RaspberryController extends Controller
{
    /**
     * @Route("/listRaspberry", name="listRaspberry")
     */
    public function RaspberryListAction(Request $request) {

        $raspberries = $this->getDoctrine()->getRepository('AppBundle:Configuration')->findAll();
        foreach($raspberries as $raspberry) {
            $keyCrypted = $this->getDoctrine()->getRepository('AppBundle:EncryptedPatient')->findOneBy(array('patient' => $raspberry->getPatient()));
            $this->decrypt($raspberry->getPatient(), $keyCrypted);
        }
        return $this->render ( 'AppBundle:Patient:listRaspeberry.html.twig', array (
            'raspberries' => $raspberries
        ) );
    }

    /**
     * @Route("/modifyRaspberry/{id}", name="modifyRaspberry")
     */
    public function showProfileAction(Request $request, $id)
    {
        $config = $this->getDoctrine()->getRepository('AppBundle:Configuration')->find($id);
        $currentPatient = $config->getPatient();
        $keyCrypted = $this->getDoctrine()->getRepository('AppBundle:EncryptedPatient')->findOneBy(array('patient' => $config->getPatient()));
        $this->decrypt($config->getPatient(), $keyCrypted);
        //$form = $this->createForm ( manageRaspberryFormType::class, $config);

       // $form->handleRequest ( $request );

        $form = $this->createFormBuilder($config)
            ->add('name', TextType::class)
            ->add('interval', NumberType::class)
            ->add('patient', EntityType::class, array(
                'class' => 'AppBundle:Patient',
                'choice_label' => function ($patient) {
                    if (preg_match("/[0-9 | \\' ^ £$%&*()}{@#~?><>,|=_+¬]/", $patient->getLastName()))
                    {
                        $this->decrypt($patient, $this->getDoctrine()->getRepository('AppBundle:EncryptedPatient')->findOneBy(array('patient' => $patient->getId())));
                    }
                    return $patient->getLastName(). ' '. $patient->getFirstName();
                },
                'label' => 'patient',
                'empty_data'  => null,
                'required' => false,
                'attr' => ['class' => 'browser-default'],


            ))

            ->add('save', SubmitType::class, array(
                'attr' => ['class' => 'btn waves-effect waves-light center-align ']

            ))
            ->getForm();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine ()->getManager();

            if($currentPatient->getId() != $config->getPatient()->getId()){

                $newEncryptedPatient = new EncryptedPatient();
                $this->encrypt($currentPatient, $newEncryptedPatient);
                $newEncryptedPatient->setPatient($currentPatient);
                $oldEncrypted = $this->getDoctrine()->getRepository('AppBundle:EncryptedPatient')->findOneBy(array('patient' => $currentPatient));
                $oldEncrypted->setPatient(null);
                $em->persist($oldEncrypted);
                $em->flush();

                $em->persist( $newEncryptedPatient );
                $em->persist ( $config );
                $em->flush ();
            }




            return $this->redirectToRoute ( 'homepage' );
        }
        return $this->render('AppBundle:Patient:modifyRaspberry.html.twig', array (
            'form' => $form->createView (),
            'name' => $config->getName()
        ));
    }

    public function encrypt(Patient $patient, EncryptedPatient $encryptedPatient){


        $publicKeys[] = openssl_get_publickey(file_get_contents($this->get('kernel')->getRootDir(). '/config/public.pem'));

        // Encrypt the $fullText and return the $encryptedText and the $encryptedKeys
        $res1 = openssl_seal($patient->getLastName(), $encryptedText, $encryptedKeys1, $publicKeys);
        $patient->setLastName(base64_encode($encryptedText));
        $encryptedPatient->setLastName(base64_encode($encryptedKeys1[0]));

        $res2 = openssl_seal($patient->getFirstName(), $encryptedText, $encryptedKeys2, $publicKeys);
        $patient->setFirstName(base64_encode($encryptedText));
        $encryptedPatient->setFirstName(base64_encode($encryptedKeys2[0]));

        $res3 = openssl_seal($patient->getRelativePhone(), $encryptedText, $encryptedKeys3, $publicKeys);
        $patient->setRelativePhone(base64_encode($encryptedText));
        $encryptedPatient->setRelativePhone(base64_encode($encryptedKeys3[0]));

        $res4 = openssl_seal($patient->getDescription(), $encryptedText, $encryptedKeys4, $publicKeys);
        $patient->setDescription(base64_encode($encryptedText));
        $encryptedPatient->setDescription(base64_encode($encryptedKeys4[0]));


    }



    public function decrypt(Patient $user, EncryptedPatient $encryptedPatient){
        $privateKey = openssl_get_privatekey(file_get_contents($this->get('kernel')->getRootDir(). '/config/private.key'));

        $result = openssl_open(base64_decode($user->getFirstName()), $decryptedData, base64_decode($encryptedPatient->getFirstName()), $privateKey);
        $user->setFirstName($decryptedData);

        $result = openssl_open(base64_decode($user->getLastName()), $decryptedData, base64_decode($encryptedPatient->getLastName()), $privateKey);
        $user->setLastName($decryptedData);

        $result = openssl_open(base64_decode($user->getRelativePhone()), $decryptedData, base64_decode($encryptedPatient->getRelativePhone()), $privateKey);
        $user->setRelativePhone($decryptedData);

        $result = openssl_open(base64_decode($user->getDescription()), $decryptedData, base64_decode($encryptedPatient->getDescription()), $privateKey);
        $user->setDescription($decryptedData);

// Show if it was a success or failure

    }
}