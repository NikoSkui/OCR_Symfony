<?php

namespace OC\PlatformBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AdvertContract
 *
 * @ORM\Table(name="oc_advert_contract")
 * @ORM\Entity(repositoryClass="OC\PlatformBundle\Repository\AdvertContractRepository")
 */
class AdvertContract
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
     * @var bool
     *
     * @ORM\Column(name="teleworking", type="boolean")
     */
    private $teleworking;

    /**
     * Bidirectionnal - One AdvertContract has one Advert.
     *
     * @ORM\OneToOne(targetEntity="OC\PlatformBundle\Entity\Advert", inversedBy="advertContract")
     * @ORM\JoinColumn(nullable=false)
     */
    private $advert;

    /**
     * Unidirectionnal - Many AdvertContract have one Contract.
     *
     * @ORM\ManyToOne(targetEntity="OC\PlatformBundle\Entity\Contract")
     * @ORM\JoinColumn(nullable=false)
     */
    private $contract;


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
     * Set teleworking
     *
     * @param boolean $teleworking
     *
     * @return AdvertContract
     */
    public function setTeleworking($teleworking)
    {
        $this->teleworking = $teleworking;

        return $this;
    }

    /**
     * Get teleworking
     *
     * @return bool
     */
    public function getTeleworking()
    {
        return $this->teleworking;
    }

    /**
     * Set advert
     *
     * @param \OC\PlatformBundle\Entity\Advert $advert
     *
     * @return AdvertContract
     */
    public function setAdvert(\OC\PlatformBundle\Entity\Advert $advert)
    {
        $this->advert = $advert;

        return $this;
    }

    /**
     * Get advert
     *
     * @return \OC\PlatformBundle\Entity\Advert
     */
    public function getAdvert()
    {
        return $this->advert;
    }

    /**
     * Set contract
     *
     * @param \OC\PlatformBundle\Entity\Contract $contract
     *
     * @return AdvertContract
     */
    public function setContract(\OC\PlatformBundle\Entity\Contract $contract)
    {
        $this->contract = $contract;

        return $this;
    }

    /**
     * Get contract
     *
     * @return \OC\PlatformBundle\Entity\Contract
     */
    public function getContract()
    {
        return $this->contract;
    }
}
