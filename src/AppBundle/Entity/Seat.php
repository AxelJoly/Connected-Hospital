<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Seat
 *
 * @ORM\Table(name="seat")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\SeatRepository")
 */
class Seat
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
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="raspberry", type="string", length=255)
     */
    private $raspberry;

    /**
     * @ORM\OneToOne(targetEntity="Patient", mappedBy="seat")
     */
    private $patient;

    /**
     * @var string
     *
     * @ORM\Column(name="room", type="string", length=255)
     */
    private $room;

    /**
     * @var string
     *
     * @ORM\Column(name="floor", type="string", length=255)
     */
    private $floor;




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
     * Set name
     *
     * @param string $name
     *
     * @return Seat
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set raspberry
     *
     * @param string $raspberry
     *
     * @return Seat
     */
    public function setRaspberry($raspberry)
    {
        $this->raspberry = $raspberry;

        return $this;
    }

    /**
     * Get raspberry
     *
     * @return string
     */
    public function getRaspberry()
    {
        return $this->raspberry;
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

    /**
     * @return string
     */
    public function getRoom()
    {
        return $this->room;
    }

    /**
     * @param string $room
     */
    public function setRoom($room)
    {
        $this->room = $room;
    }

    /**
     * @return string
     */
    public function getFloor()
    {
        return $this->floor;
    }

    /**
     * @param string $floor
     */
    public function setFloor($floor)
    {
        $this->floor = $floor;
    }



}

