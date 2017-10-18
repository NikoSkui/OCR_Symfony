<?php

namespace OC\PlatformBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Table(name="oc_advert")
 * @ORM\Entity(repositoryClass="OC\PlatformBundle\Repository\AdvertRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Advert
{
  /**
   * @ORM\Column(name="id", type="integer")
   * @ORM\Id
   * @ORM\GeneratedValue(strategy="AUTO")
   */
  private $id;

  /**
   * @ORM\Column(name="date", type="datetime")
   */
  private $date;

  /**
   * @ORM\Column(name="title", type="string", length=255)
   */
  private $title;

  /**
   * Unidirectionnal - Many Advert have one Author.
   *
   * @ORM\ManyToOne(targetEntity="OC\PlatformBundle\Entity\Society", cascade={"persist"})
   */
  private $author;

  /**
   * @ORM\Column(name="excerpt", type="string", length=255)
   */
  private $excerpt;

  /**
   * @ORM\Column(name="published", type="boolean")
   */
  private $published = true;

  /**
   * Unidirectionnal - Many Advert have many Categories.
   *
   * @ORM\ManyToMany(targetEntity="OC\PlatformBundle\Entity\Category", cascade={"persist"})
   * @ORM\JoinTable(name="oc_advert_category")
   */
  private $categories;

  /**
   * Bidirectionnal - One Advert has many Application. (INVERSE SIDE)
   *
   * @ORM\OneToMany(targetEntity="OC\PlatformBundle\Entity\Application",cascade={"persist"}, mappedBy="advert")
   */
  private $applications; // Notez le « s », une annonce est liée à plusieurs candidatures

  /**
   * Bidirectionnal - One Advert has one Contract. (INVERSE SIDE)
   *
   * @ORM\OneToOne(targetEntity="OC\PlatformBundle\Entity\AdvertContract", mappedBy="advert")
   */
  private $advertContract;

  /**
   * @ORM\Column(name="updated_at", type="datetime", nullable=true)
   */
  private $updatedAt;

  /**
   * @ORM\Column(name="nb_applications", type="integer")
   */
  private $nbApplications = 0;

  /**
   * @Gedmo\Slug(fields={"title"})
   * @ORM\Column(name="slug", type="string", length=255, unique=true)
   */
  private $slug;

  /**
   * Unidirectionnal - Many Advert has one Salary.
   *
   * @ORM\ManyToOne(targetEntity="OC\PlatformBundle\Entity\Salary", cascade={"persist"})
   */
  private $salary;

  public function __construct()
  {
    $this->date         = new \Datetime();
    $this->categories   = new ArrayCollection();
    $this->applications = new ArrayCollection();
  }

  /**
   * @ORM\PreUpdate
   */
  public function updateDate()
  {
    $this->setUpdatedAt(new \Datetime());
  }

  public function increaseApplication()
  {
    $this->nbApplications++;
  }

  public function decreaseApplication()
  {
    $this->nbApplications--;
  }

  /**
   * @return int
   */
  public function getId()
  {
    return $this->id;
  }

  /**
   * @param \DateTime $date
   */
  public function setDate($date)
  {
    $this->date = $date;
  }

  /**
   * @return \DateTime
   */
  public function getDate()
  {
    return $this->date;
  }

  /**
   * @param string $title
   */
  public function setTitle($title)
  {
    $this->title = $title;
  }

  /**
   * @return string
   */
  public function getTitle()
  {
    return $this->title;
  }

  /**
   * @param string $author
   */
  public function setAuthor($author)
  {
    $this->author = $author;
  }

  /**
   * @return string
   */
  public function getAuthor()
  {
    return $this->author;
  }

  /**
   * @param string $excerpt
   */
  public function setExcerpt($excerpt)
  {
    $this->excerpt = $excerpt;
  }

  /**
   * @return string
   */
  public function getExcerpt()
  {
    return $this->excerpt;
  }

  /**
   * @param bool $published
   */
  public function setPublished($published)
  {
    $this->published = $published;
  }

  /**
   * @return bool
   */
  public function getPublished()
  {
    return $this->published;
  }

  public function setImage(Image $image = null)
  {
    $this->image = $image;
  }

  public function getImage()
  {
    return $this->image;
  }

  /**
   * @param Category $category
   */
  public function addCategory(Category $category)
  {
    $this->categories[] = $category;
  }

  /**
   * @param Category $category
   */
  public function removeCategory(Category $category)
  {
    $this->categories->removeElement($category);
  }

  /**
   * @return ArrayCollection
   */
  public function getCategories()
  {
    return $this->categories;
  }

  /**
   * @param Application $application
   */
  public function addApplication(Application $application)
  {
    $this->applications[] = $application;

    // On lie l'annonce à la candidature
    $application->setAdvert($this);
  }

  /**
   * @param Application $application
   */
  public function removeApplication(Application $application)
  {
    $this->applications->removeElement($application);
  }

  /**
   * @return \Doctrine\Common\Collections\Collection
   */
  public function getApplications()
  {
    return $this->applications;
  }

  /**
   * @param \DateTime $updatedAt
   */
  public function setUpdatedAt(\Datetime $updatedAt = null)
  {
      $this->updatedAt = $updatedAt;
  }

  /**
   * @return \DateTime
   */
  public function getUpdatedAt()
  {
      return $this->updatedAt;
  }

  /**
   * @param integer $nbApplications
   */
  public function setNbApplications($nbApplications)
  {
      $this->nbApplications = $nbApplications;
  }

  /**
   * @return integer
   */
  public function getNbApplications()
  {
      return $this->nbApplications;
  }

  /**
   * @param string $slug
   */
  public function setSlug($slug)
  {
      $this->slug = $slug;
  }

  /**
   * @return string
   */
  public function getSlug()
  {
      return $this->slug;
  }

    /**
     * Set advertContract
     *
     * @param \OC\PlatformBundle\Entity\Application $advertContract
     *
     * @return Advert
     */
    public function setAdvertContract(\OC\PlatformBundle\Entity\Application $advertContract = null)
    {
        $this->advertContract = $advertContract;

        return $this;
    }

    /**
     * Get advertContract
     *
     * @return \OC\PlatformBundle\Entity\Application
     */
    public function getAdvertContract()
    {
        return $this->advertContract;
    }

    /**
     * Set salary
     *
     * @param \OC\PlatformBundle\Entity\Salary $salary
     *
     * @return Advert
     */
    public function setSalary(\OC\PlatformBundle\Entity\Salary $salary = null)
    {
        $this->salary = $salary;

        return $this;
    }

    /**
     * Get salary
     *
     * @return \OC\PlatformBundle\Entity\Salary
     */
    public function getSalary()
    {
        return $this->salary;
    }
}
