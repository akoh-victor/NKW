<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\HttpFoundation\File\File;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @Vich\Uploadable
 * @ORM\Table(name="groups")
 * @ORM\HasLifecycleCallbacks
 * @ORM\Entity(repositoryClass="AppBundle\Repository\GroupRepository")
 */

class Group
{



    /**
     * Constructor
     */
    public function __construct()
    {
        $this->brand = new \Doctrine\Common\Collections\ArrayCollection();
        $this->product = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    /**
     * @ORM\Column(type="string", length=100)
     */
    protected $name;
    /**
     * @ORM\Column(type="text",nullable=true)
     */
    protected $description;
    /**
     * @ORM\Column(type="integer",nullable=true)
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $position;

    /**
     * @ORM\Column(type="smallint")
     *
     */
    protected $visible;
    /**
     * NOTE: This is not a mapped field of entity metadata, just a simple property.
     *
     * @Vich\UploadableField(mapping="group_logo", fileNameProperty="logo")
     *
     * @var File
     */
    private $logoFile;

    /**
     * @ORM\Column(type="string", length=255,nullable=true)
     *
     * @var string
     */
    private $logo;
    /**
     * @ORM\Column(type="datetime",nullable=true)
     *
     * @var \DateTime
     */
    private $updatedAt;
    
    
    //relationship definition
    /**
     * @ORM\ManyToOne(targetEntity="Category", inversedBy="group")
     * @ORM\JoinColumn(name="category_id", referencedColumnName="id")
     */
    protected $category;

    /**
     *  @ORM\OneToMany(targetEntity="Product", mappedBy="group")
     */
    protected $product;
    public function  construct()
    {
        $this->product = new ArrayCollection();
    }


//am including the group relationship with brand in case there is something wrong thanks
    /**
     * @ORM\ManyToMany(targetEntity="Brand", inversedBy="group")
     * @ORM\JoinTable(name="brand_groups")
     */
    private $brand;

   /* public function __con()
    {
        $this->brand = new ArrayCollection();
    }*/



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
     * Set name
     *
     * @param string $name
     * @return Group
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
     * Set description
     *
     * @param string $description
     * @return Group
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
     * Set category
     *
     * @param \AppBundle\Entity\Category $category
     * @return Group
     */
    public function setCategory(\AppBundle\Entity\Category $category = null)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category
     *
     * @return \AppBundle\Entity\Category 
     */
    public function getCategory()
    {
        return $this->category;
    }


    /**
     * Has brand
     *
     * @param \AppBundle\Entity\Brand $brand
     * @return boolean
     */
    public function hasBrand(\AppBundle\Entity\Brand   $brand)
    {
        if($this->brand->contains($brand)){
            return true;
        }
    }

    /**
     * Add brand
     *
     * @param \AppBundle\Entity\Brand $brand
     * @return Group
     */
    public function addBrand(\AppBundle\Entity\Brand $brand)
    {
        $this->brand[] = $brand;

        return $this;
    }

    /**
     * Remove brand
     *
     * @param \AppBundle\Entity\Brand $brand
     */
    public function removeBrand(\AppBundle\Entity\Brand $brand)
    {
        $this->brand->removeElement($brand);
    }

    /**
     * Get brand
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getBrand()
    {
        return $this->brand;
    }

    /**
     * Set position
     *
     * @param integer $position
     * @return Group
     */
    public function setPosition($position)
    {
        $this->position = $position;

        return $this;
    }

    /**
     * Get position
     *
     * @return integer 
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * Set visible
     *
     * @param integer $visible
     * @return Group
     */
    public function setVisible($visible)
    {
        $this->visible = $visible;

        return $this;
    }

    /**
     * Get visible
     *
     * @return integer 
     */
    public function getVisible()
    {
        return $this->visible;
    }

    /**
     * Add product
     *
     * @param \AppBundle\Entity\Product $product
     * @return Group
     */
    public function addProduct(\AppBundle\Entity\Product $product)
    {
        $this->product[] = $product;

        return $this;
    }

    /**
     * Remove product
     *
     * @param \AppBundle\Entity\Product $product
     */
    public function removeProduct(\AppBundle\Entity\Product $product)
    {
        $this->product->removeElement($product);
    }

    /**
     * Get product
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getProduct()
    {
        return $this->product;
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
     * Set logo
     *
     * @param string $logo
     * @return Group
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
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     * @return Group
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

}
