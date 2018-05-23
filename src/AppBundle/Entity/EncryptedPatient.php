<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * EncryptedPatient
 *
 * @ORM\Table(name="encrypted_patient")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\EncryptedPatientRepository")
 */
class EncryptedPatient
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="firstName", type="string", length=255)
     */
    private $firstName;

    /**
     * @var string
     *
     * @ORM\Column(name="lastName", type="string", length=255)
     */
    private $lastName;

    /**
     * @var string
     *
     * @ORM\Column(name="relativePhone", type="string", length=255)
     */
    private $relativePhone;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255)
     */
    private $description;

    /**
     *
     * @var string
     *
     * @ORM\OneToOne(targetEntity="Patient", inversedBy="encryptedKeys")
     * @ORM\JoinColumn(name="patient_id", referencedColumnName="id", nullable=true)
     */

    private $patient;

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set firstName
     *
     * @param string $firstName
     *
     * @return EncryptedPatient
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * Get firstName
     *
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Set lastName
     *
     * @param string $lastName
     *
     * @return EncryptedPatient
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * Get lastName
     *
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * Set birthday
     *
     * @param string $birthday
     *
     * @return EncryptedPatient
     */
    public function setBirthday($birthday)
    {
        $this->birthday = $birthday;

        return $this;
    }

    /**
     * Get birthday
     *
     * @return string
     */
    public function getBirthday()
    {
        return $this->birthday;
    }

    /**
     * Set relativePhone
     *
     * @param string $relativePhone
     *
     * @return EncryptedPatient
     */
    public function setRelativePhone($relativePhone)
    {
        $this->relativePhone = $relativePhone;

        return $this;
    }

    /**
     * Get relativePhone
     *
     * @return string
     */
    public function getRelativePhone()
    {
        return $this->relativePhone;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return EncryptedPatient
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set effectiveDate
     *
     * @param string $effectiveDate
     *
     * @return EncryptedPatient
     */
    public function setEffectiveDate($effectiveDate)
    {
        $this->effectiveDate = $effectiveDate;

        return $this;
    }

    /**
     * Get effectiveDate
     *
     * @return string
     */
    public function getEffectiveDate()
    {
        return $this->effectiveDate;
    }

    /**
     * Set releaseDate
     *
     * @param string $releaseDate
     *
     * @return EncryptedPatient
     */
    public function setReleaseDate($releaseDate)
    {
        $this->releaseDate = $releaseDate;

        return $this;
    }

    /**
     * Get releaseDate
     *
     * @return string
     */
    public function getReleaseDate()
    {
        return $this->releaseDate;
    }

    /**
     * @return mixed
     */
    public function getPatient()
    {
        return $this->patient;
    }

    /**
     * @param mixed $patient
     */
    public function setPatient($patient)
    {
        $this->patient = $patient;
    }


}

