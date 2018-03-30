<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Data_References
 *
 * @ORM\Table(name="data__references")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\Data_ReferencesRepository")
 */
class Data_References
{


    /**
     * @var int
     *
     * @ORM\Column(name="id_references", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $idReferences;

    /**
     * @var int
     *
     * @ORM\Column(name="min_bpm", type="integer")
     */
    private $minBpm;

    /**
     * @var int
     *
     * @ORM\Column(name="max_bpm", type="integer")
     */
    private $maxBpm;

    /**
     * @var int
     *
     * @ORM\Column(name="min_gly", type="integer")
     */
    private $minGly;

    /**
     * @var int
     *
     * @ORM\Column(name="max_gly", type="integer")
     */
    private $maxGly;

    /**
     * @var int
     *
     * @ORM\Column(name="min_temperature", type="integer")
     */
    private $minTemperature;

    /**
     * @var int
     *
     * @ORM\Column(name="max_temperature", type="integer")
     */
    private $maxTemperature;

    /**
     * @var int
     *
     * @ORM\Column(name="min_bloodp", type="integer")
     */
    private $minBloodp;

    /**
     * @var int
     *
     * @ORM\Column(name="max_bloodp", type="integer")
     */
    private $maxBloodp;


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
     * Set idReferences
     *
     * @param integer $idReferences
     *
     * @return Data_References
     */
    public function setIdReferences($idReferences)
    {
        $this->idReferences = $idReferences;

        return $this;
    }

    /**
     * Get idReferences
     *
     * @return int
     */
    public function getIdReferences()
    {
        return $this->idReferences;
    }

    /**
     * Set minBpm
     *
     * @param integer $minBpm
     *
     * @return Data_References
     */
    public function setMinBpm($minBpm)
    {
        $this->minBpm = $minBpm;

        return $this;
    }

    /**
     * Get minBpm
     *
     * @return int
     */
    public function getMinBpm()
    {
        return $this->minBpm;
    }

    /**
     * Set maxBpm
     *
     * @param integer $maxBpm
     *
     * @return Data_References
     */
    public function setMaxBpm($maxBpm)
    {
        $this->maxBpm = $maxBpm;

        return $this;
    }

    /**
     * Get maxBpm
     *
     * @return int
     */
    public function getMaxBpm()
    {
        return $this->maxBpm;
    }

    /**
     * Set minGly
     *
     * @param integer $minGly
     *
     * @return Data_References
     */
    public function setMinGly($minGly)
    {
        $this->minGly = $minGly;

        return $this;
    }

    /**
     * Get minGly
     *
     * @return int
     */
    public function getMinGly()
    {
        return $this->minGly;
    }

    /**
     * Set maxGly
     *
     * @param integer $maxGly
     *
     * @return Data_References
     */
    public function setMaxGly($maxGly)
    {
        $this->maxGly = $maxGly;

        return $this;
    }

    /**
     * Get maxGly
     *
     * @return int
     */
    public function getMaxGly()
    {
        return $this->maxGly;
    }

    /**
     * Set minTemperature
     *
     * @param integer $minTemperature
     *
     * @return Data_References
     */
    public function setMinTemperature($minTemperature)
    {
        $this->minTemperature = $minTemperature;

        return $this;
    }

    /**
     * Get minTemperature
     *
     * @return int
     */
    public function getMinTemperature()
    {
        return $this->minTemperature;
    }

    /**
     * Set maxTemperature
     *
     * @param integer $maxTemperature
     *
     * @return Data_References
     */
    public function setMaxTemperature($maxTemperature)
    {
        $this->maxTemperature = $maxTemperature;

        return $this;
    }

    /**
     * Get maxTemperature
     *
     * @return int
     */
    public function getMaxTemperature()
    {
        return $this->maxTemperature;
    }

    /**
     * Set minBloodp
     *
     * @param integer $minBloodp
     *
     * @return Data_References
     */
    public function setMinBloodp($minBloodp)
    {
        $this->minBloodp = $minBloodp;

        return $this;
    }

    /**
     * Get minBloodp
     *
     * @return int
     */
    public function getMinBloodp()
    {
        return $this->minBloodp;
    }

    /**
     * Set maxBloodp
     *
     * @param integer $maxBloodp
     *
     * @return Data_References
     */
    public function setMaxBloodp($maxBloodp)
    {
        $this->maxBloodp = $maxBloodp;

        return $this;
    }

    /**
     * Get maxBloodp
     *
     * @return int
     */
    public function getMaxBloodp()
    {
        return $this->maxBloodp;
    }
}

