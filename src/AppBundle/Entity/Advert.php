<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @Vich\Uploadable
 * @ORM\Table(name="adverts")
 * @ORM\HasLifecycleCallbacks
 * @ORM\Entity(repositoryClass="AppBundle\Repository\AdvertRepository")
 */

class Advert
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    /**
     * @ORM\Column(type="string", length=100)
     */
    protected $title;

    /**
     * @ORM\Column(type="text")
     */
    protected $comment;

    /**
     * @ORM\Column(type="string", length=100)
     */
    protected $advertiser;
    /**
     * NOTE: This is not a mapped field of entity metadata, just a simple property.
     *
     * @Vich\UploadableField(mapping="advert_logo", fileNameProperty="logo")
     *
     * @var File
     */
    private $logoFile;

    /**
     * @ORM\Column(type="string", length=255)
     *
     * @var string
     */
    private $logo;

    /**
     * @ORM\Column(type="string", length=100)
     */
    protected $displayLocation;
    /**
     * @ORM\Column(type="integer", length=1)
     */
    protected $enabled;

    /**
     * @ORM\Column(type="integer", length=1)
     */
    protected $expired;

    /**
     * @ORM\Column(type="datetime")
     */
    protected $expiresAt;
    /**
     * @ORM\Column(type="datetime")
     */
    protected $subscribeDate;
    /**
     * @ORM\Column(type="datetime",nullable = true)
     *
     * @var \DateTime
     */
    private $updatedAt;




    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set title
     *
     * @param string $title
     * @return Advert
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string 
     */
    public function getTitle()
    {
        return $this->title;
    }




    /**
     * Set logo
     *
     * @param string $logo
     * @return Department
     */
    public function setLogo($logo)
    {
        $this->logo = $logo;

        return $this;
    }

    /**
     * Get logo
     *
     * @return string
     */
    public function getLogo()
    {
        return $this->logo;
    }
    /**
     * If manually uploading a file (i.e. not using Symfony Form) ensure an instance
     * of 'UploadedFile' is injected into this setter to trigger the  update. If this
     * bundle's configuration parameter 'inject_on_load' is set to 'true' this setter
     * must be able to accept an instance of 'File' as the bundle will inject one here
     * during Doctrine hydration.
     *
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile $logo
     *
     * @return Brand
     */
    public function setLogoFile(File $logo = null)
    {
        $this->logoFile = $logo;

        if ($logo) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->updatedAt = new \DateTime('now');
        }

        return $this;
    }

    /**
     * @return File
     */
    public function logoFile()
    {
        return $this->logoFile;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     * @return Department
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }


    /**
     * Set comment
     *
     * @param string $comment
     * @return Advert
     */
    public function setComment($comment)
    {
        $this->comment = $comment;

        return $this;
    }

    /**
     * Get comment
     *
     * @return string 
     */
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * Set advertiser
     *
     * @param string $advertiser
     * @return Advert
     */
    public function setAdvertiser($advertiser)
    {
        $this->advertiser = $advertiser;

        return $this;
    }

    /**
     * Get advertiser
     *
     * @return string 
     */
    public function getAdvertiser()
    {
        return $this->advertiser;
    }

    /**
     * Set displayLocation
     *
     * @param string $displayLocation
     * @return Advert
     */
    public function setDisplayLocation($displayLocation)
    {
        $this->displayLocation = $displayLocation;

        return $this;
    }

    /**
     * Get displayLocation
     *
     * @return string 
     */
    public function getDisplayLocation()
    {
        return $this->displayLocation;
    }

    /**
     * Set enabled
     *
     * @param integer $enabled
     * @return Advert
     */
    public function setEnabled($enabled)
    {
        $this->enabled = $enabled;

        return $this;
    }

    /**
     * Get enabled
     *
     * @return integer 
     */
    public function getEnabled()
    {
        return $this->enabled;
    }

    /**
     * Set expired
     *
     * @param integer $expired
     * @return Advert
     */
    public function setExpired($expired)
    {
        $this->expired = $expired;

        return $this;
    }

    /**
     * Get expired
     *
     * @return integer 
     */
    public function getExpired()
    {
        return $this->expired;
    }

    /**
     * Set expiresAt
     *
     * @param \DateTime $expiresAt
     * @return Advert
     */
    public function setExpiresAt($expiresAt)
    {
        $this->expiresAt = $expiresAt;

        return $this;
    }

    /**
     * Get expiresAt
     *
     * @return \DateTime 
     */
    public function getExpiresAt()
    {
        return $this->expiresAt;
    }



    /**
     * Set subscribeDate
     *
     * @param \DateTime $subscribeDate
     * @return Advert
     */
    public function setSubscribeDate($subscribeDate)
    {
        $this->subscribeDate = $subscribeDate;

        return $this;
    }

    /**
     * Get subscribeDate
     *
     * @return \DateTime 
     */
    public function getSubscribeDate()
    {
        return $this->subscribeDate;
    }
}
