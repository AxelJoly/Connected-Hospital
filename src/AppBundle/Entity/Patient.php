<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use AppBundle\Entity\Data;
use Doctrine\Common\Collections;
use JMS\Serializer\Annotation\Groups;
/**
 * Patient
 *
 * @ORM\Table(name="patient")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PatientRepository")
 */
class Patient
{


    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @Groups({"details"})
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="firstName", type="string", length=255)
     * @Groups({"details"})
     */
    private $firstName;

    /**
     * @var string
     *
     * @ORM\Column(name="lastName", type="string", length=255)
     * @Groups({"details"})
     */
    private $lastName;

    /**
     * @var \Date
     *
     * @ORM\Column(name="age", type="date")
     * @Groups({"details"})
     */
    private $birthday;

    /**
     * @var int
     *
     * @ORM\Column(name="relativePhone", type="string")
     * @Groups({"details"})
     */
    private $relativePhone;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=2048, nullable=true)
     * @Groups({"details"})
     */
    private $description;


    /**
     * @ORM\OneToMany(targetEntity="Data", mappedBy="patient", cascade={"persist", "remove"})
     * @Groups({"details"})
     */

    private $data;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="effectiveDate", type="datetime", nullable=true)
     * @Groups({"details"})
     */

    private $effectiveDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="releaseDate", type="datetime", nullable=true)
     * @Groups({"details"})
     */

    private $releaseDate;



    /**
     * @ORM\ManyToMany(targetEntity="Doctor", mappedBy="patients")
     * @Groups({"details"})
     */
    private $doctors;

    /**
     *
     * @ORM\OneToOne(targetEntity="Seat", inversedBy="patient")
     * @ORM\JoinColumn(name="seat_id", referencedColumnName="id", nullable=true)
     * @Groups({"details"})
     */
    private $seat;

    /**
     *
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\EncryptedPatient", mappedBy="patient")
     * @Groups({"details"})
     */
    private $encryptedKeys;





    public function __construct() {
        $this->doctors = new \Doctrine\Common\Collections\ArrayCollection();
    }



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
     * Set prenom
     *
     * @param string $prenom
     *
     * @return Patient
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * Get prenom
     *
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Set nom
     *
     * @param string $nom
     *
     * @return Patient
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * Get nom
     *
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * Set age
     *
     * @param \DateTime $age
     *
     * @return Patient
     */
    public function setBirthday(\DateTime $birthday)
    {
        $this->birthday = $birthday;

        return $this;
    }

    /**
     * Get age
     *
     * @return \DateTime
     */
    public function getBirthday()
    {
        return $this->birthday;
    }

    /**
     * Set relativePhone
     *
     * @param integer $relativePhone
     *
     * @return Patient
     */
    public function setRelativePhone($relativePhone)
    {
        $this->relativePhone = $relativePhone;

        return $this;
    }

    /**
     * Get relativePhone
     *
     * @return int
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
     * @return Patient
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
     * @return mixed
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @param mixed $data
     */
    public function setData($data)
    {
        $this->data = $data;
    }

    /**
     * @return \DateTime
     */
    public function getEffectiveDate()
    {
        return $this->effectiveDate;
    }

    /**
     * @param \DateTime $effectiveDate
     */
    public function setEffectiveDate(\DateTime $effectiveDate = null)
    {
        $this->effectiveDate = $effectiveDate;
    }

    /**
     * @return \DateTime
     */
    public function getReleaseDate()
    {
        return $this->releaseDate;
    }

    /**
     * @param \DateTime $releaseDate
     */
    public function setReleaseDate(\DateTime $releaseDate = null)
    {
        $this->releaseDate = $releaseDate;
    }

    /**
     * @return mixed
     */
    public function getDoctorList()
    {
        return $this->doctorList;
    }

    /**
     * @param mixed $doctorList
     */
    public function setDoctorList($doctorList)
    {
        $this->doctorList = $doctorList;
    }

    /**
     * @return mixed
     */
    public function getDoctors()
    {
        return $this->doctors;
    }

    /**
     * @param mixed $doctors
     */
    public function setDoctors($doctors)
    {
        $this->doctors = $doctors;
    }

    /**
     * @return mixed
     */
    public function getSeat()
    {
        return $this->seat;
    }

    /**
     * @param mixed $seat
     */
    public function setSeat($seat)
    {
        $this->seat = $seat;
    }

    /**
     * @return mixed
     */
    public function getEncryptedKeys()
    {
        return $this->encryptedKeys;
    }

    /**
     * @param mixed $encryptedKeys
     */
    public function setEncryptedKeys($encryptedKeys)
    {
        $this->encryptedKeys = $encryptedKeys;
    }


}

