<?php

namespace OC\PlatformBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Society
 *
 * @ORM\Table(name="oc_society")
 * @ORM\Entity(repositoryClass="OC\PlatformBundle\Repository\SocietyRepository")
 */
class Society
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
		* @ORM\Column(name="name", type="string", length=55)
		*/
	private $name;

	/**
		* @var string
		*
		* @ORM\Column(name="email", type="string", length=55, unique=true)
		*/
	private $email;

	/**
		* @var string
		*
		* @ORM\Column(name="website", type="string", length=255)
		*/
	private $website;

	/**
		* @var string
		*
		* @ORM\Column(name="description", type="text")
		*/
	private $description;

	/**
		* @var string
		*
		* @ORM\Column(name="password", type="string", length=255)
		*/
	private $password;

  /**
   * Unidirectionnal - One User has One Address.
   *
   * @ORM\OneToOne(targetEntity="OC\PlatformBundle\Entity\Address", cascade={"persist"})
   */
  private $address;

  /**
   * Unidirectionnal - One User has one Image.
   *
   * @ORM\OneToOne(targetEntity="OC\PlatformBundle\Entity\Image", cascade={"persist"})
   */
  private $image;

  /**
   * Unidirectionnal - One User has one Logo.
   *
   * @ORM\OneToOne(targetEntity="OC\PlatformBundle\Entity\Image", cascade={"persist"})
   */
  private $logo;


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
		* @return Society
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
		* Set email
		*
		* @param string $email
		*
		* @return Society
		*/
	public function setEmail($email)
	{
			$this->email = $email;

			return $this;
	}

	/**
		* Get email
		*
		* @return string
		*/
	public function getEmail()
	{
			return $this->email;
	}

	/**
		* Set website
		*
		* @param string $website
		*
		* @return Society
		*/
	public function setWebsite($website)
	{
			$this->website = $website;

			return $this;
	}

	/**
		* Get website
		*
		* @return string
		*/
	public function getWebsite()
	{
			return $this->website;
	}

	/**
		* Set description
		*
		* @param string $description
		*
		* @return Society
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
		* Set password
		*
		* @param string $password
		*
		* @return Society
		*/
	public function setPassword($password)
	{
			$this->password = $password;

			return $this;
	}

	/**
		* Get password
		*
		* @return string
		*/
	public function getPassword()
	{
			return $this->password;
	}
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->address = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add address
     *
     * @param \OC\PlatformBundle\Entity\Address $address
     *
     * @return Society
     */
    public function addAddress(\OC\PlatformBundle\Entity\Address $address)
    {
        $this->address[] = $address;

        return $this;
    }

    /**
     * Remove address
     *
     * @param \OC\PlatformBundle\Entity\Address $address
     */
    public function removeAddress(\OC\PlatformBundle\Entity\Address $address)
    {
        $this->address->removeElement($address);
    }

    /**
     * Get address
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Set image
     *
     * @param \OC\PlatformBundle\Entity\Image $image
     *
     * @return Society
     */
    public function setImage(\OC\PlatformBundle\Entity\Image $image = null)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return \OC\PlatformBundle\Entity\Image
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Set logo
     *
     * @param \OC\PlatformBundle\Entity\Image $logo
     *
     * @return Society
     */
    public function setLogo(\OC\PlatformBundle\Entity\Image $logo = null)
    {
        $this->logo = $logo;

        return $this;
    }

    /**
     * Get logo
     *
     * @return \OC\PlatformBundle\Entity\Image
     */
    public function getLogo()
    {
        return $this->logo;
    }

    /**
     * Set address
     *
     * @param \OC\PlatformBundle\Entity\Address $address
     *
     * @return Society
     */
    public function setAddress(\OC\PlatformBundle\Entity\Address $address = null)
    {
        $this->address = $address;

        return $this;
    }
}
