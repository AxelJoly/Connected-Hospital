<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\Groups;

/**
 * Data
 *
 * @ORM\Table(name="data")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\DataRepository")
 */
class Data
{


    /**
     * @var int
     *
     * @ORM\Column(name="idData", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @Groups({"details"})
     *
     */
    private $idData;

    /**
     * @var int
     *
     * @ORM\Column(name="bpm", type="integer")
     * @Groups({"details"})
     */
    private $bpm;

    /**
     * @var int
     *
     * @ORM\Column(name="glycemia", type="integer")
     * @Groups({"details"})
     */
    private $glycemia;

    /**
     * @var int
     *
     * @ORM\Column(name="temperature", type="integer")
     * @Groups({"details"})
     */
    private $temperature;

    /**
     * @var int
     *
     * @ORM\Column(name="bloodPressure", type="integer")
     * @Groups({"details"})
     */
    private $bloodPressure;

    /**
     *
     * @var string
     *
     * @ORM\ManyToOne(targetEntity="Patient", inversedBy="data")
     * @ORM\JoinColumn(name="idPatient", referencedColumnName="id")
     * @Groups({"details"})
     */

    private $patient;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     * @Groups({"details"})
     */
    private $date;



    /**
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param \DateTime $date
     */
    public function setDate(\DateTime $date)
    {
        $this->date = $date;
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
     * Set idData
     *
     * @param integer $idData
     *
     * @return Data
     */
    public function setIdData($idData)
    {
        $this->idData = $idData;

        return $this;
    }

    /**
     * Get idData
     *
     * @return int
     */
    public function getIdData()
    {
        return $this->idData;
    }

    /**
     * Set bpm
     *
     * @param integer $bpm
     *
     * @return Data
     */
    public function setBpm($bpm)
    {
        $this->bpm = $bpm;

        return $this;
    }

    /**
     * Get bpm
     *
     * @return int
     */
    public function getBpm()
    {
        return $this->bpm;
    }

    /**
     * Set glycemia
     *
     * @param integer $glycemia
     *
     * @return Data
     */
    public function setGlycemia($glycemia)
    {
        $this->glycemia = $glycemia;

        return $this;
    }

    /**
     * Get glycemia
     *
     * @return int
     */
    public function getGlycemia()
    {
        return $this->glycemia;
    }

    /**
     * Set temperature
     *
     * @param string $temperature
     *
     * @return Data
     */
    public function setTemperature($temperature)
    {
        $this->temperature = $temperature;

        return $this;
    }

    /**
     * Get temperature
     *
     * @return string
     */
    public function getTemperature()
    {
        return $this->temperature;
    }

    /**
     * Set bloodPressure
     *
     * @param integer $bloodPressure
     *
     * @return Data
     */
    public function setBloodPressure($bloodPressure)
    {
        $this->bloodPressure = $bloodPressure;

        return $this;
    }

    /**
     * Get bloodPressure
     *
     * @return int
     */
    public function getBloodPressure()
    {
        return $this->bloodPressure;
    }

    /**
     * @return string
     */
    public function getPatient()
    {
        return $this->patient;
    }



    /**
     * @param string $patient
     */
    public function setPatient( $patient)
    {
        $this->patient = $patient;
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
}

