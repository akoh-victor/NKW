<?php

namespace AppBundle\Entity;
use AppBundle\Entity\ProductRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Doctrine\Common\Collections\ArrayCollection;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 *  @Vich\Uploadable
 * @ORM\Table(name="products")
 * @ORM\HasLifecycleCallbacks
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ProductRepository")
 */

class Product
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    /**
     * @ORM\Column( type="integer")
     */
    protected $code;
    /**
     * @ORM\Column(type="string", length=100)
     */
    protected $name;
    /**
     * @ORM\Column(type="text",nullable=true)
     */
    protected $description;
    /**
     * NOTE: This is not a mapped field of entity metadata, just a simple property.
     *
     * @Vich\UploadableField(mapping="product_frontImage", fileNameProperty="frontImage")
     *
     * @var File
     */
    private $frontImageFile;

    /**
     * @ORM\Column(type="string", length=255)
     *
     * @var string
     */
    private $frontImage;
    /**
     * NOTE: This is not a mapped field of entity metadata, just a simple property.
     *
     * @Vich\UploadableField(mapping="product_rearImage", fileNameProperty="rearImage")
     *
     * @var File
     */
    private $rearImageFile;

    /**
     * @ORM\Column(type="string", length=255,nullable=true)
     *
     * @var string
     */
    private $rearImage;
    /**
     * @ORM\Column(name="`order`",type="integer")
     */
    protected $order;
    /**
     * @ORM\Column(type="integer")
     */
    protected $stock;
    /**
     * @ORM\Column(type="datetime")
     */
    protected $entry;
    /**
     * @ORM\Column(type="datetime")
     */
    protected $created;
    /**
     * @ORM\Column(type="date",nullable=true)
     */
    protected $manufactured;
    /**
     * @ORM\Column(type="date",nullable=true)
     */
    protected $expire;
    /**
     * @ORM\Column(type="integer")
     */
    protected $openingQuantity;
    /**
     * @ORM\Column(type="integer")
     */
    protected $purchasePrice;
    /**
     * @ORM\Column(type="integer")
     */
    protected $openingPrice;
    /**
     * @ORM\Column(type="integer")
     */
    protected $price;
    /**
     * @ORM\Column(type="smallint")
     */
    protected $visible;
    /**
     * @ORM\Column(type="smallint")
     */
    protected $discontinue;
    /**
     * @ORM\Column(type="integer")
     */
    protected $view;
    /**
     * @ORM\Column(type="text")
     */
    protected $about;


//relationships
    /**
     * @ORM\ManyToOne(targetEntity="Brand", inversedBy="product")
     * @ORM\JoinColumn(name="brand_id", referencedColumnName="id")
     */
    protected $brand;

    /**
     * @ORM\ManyToOne(targetEntity="Group", inversedBy="product")
     * @ORM\JoinColumn(name="groups_id", referencedColumnName="id")
     */
    protected $group;

    /**
     * @ORM\ManyToOne(targetEntity="Measurement", inversedBy="product")
     * @ORM\JoinColumn(name="measurement_id", referencedColumnName="id")
     */
    protected $measurement;
    /**
     * @ORM\ManyToOne(targetEntity="Gender", inversedBy="product")
     * @ORM\JoinColumn(name="gender_id", referencedColumnName="id")
     */
    protected $gender;

    /**
     * @ORM\ManyToOne(targetEntity="Orderitem", inversedBy="product")
     * @ORM\JoinColumn(name="orderitem_id", referencedColumnName="id")
     */
    protected $orderitem;

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
     * Set code
     *
     * @param integer $code
     * @return Product
     */
    public function setCode($code)
    {
        $this->code = $code;

        return $this;
    }

    /**
     * Get code
     *
     * @return integer 
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Product
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
     * @return Product
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
     * Set order
     *
     * @param integer $order
     * @return Product
     */
    public function setOrder($order)
    {
        $this->order = $order;

        return $this;
    }

    /**
     * Get order
     *
     * @return integer 
     */
    public function getOrder()
    {
        return $this->order;
    }

    /**
     * Set stock
     *
     * @param integer $stock
     * @return Product
     */
    public function setStock($stock)
    {
        $this->stock = $stock;

        return $this;
    }

    /**
     * Get stock
     *
     * @return integer 
     */
    public function getStock()
    {
        return $this->stock;
    }

    /**
     * Set entry
     *
     * @param \DateTime $entry
     * @return Product
     */
    public function setEntry($entry)
    {
        $this->entry = $entry;

        return $this;
    }

    /**
     * Get entry
     *
     * @return \DateTime 
     */
    public function getEntry()
    {
        return $this->entry;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     * @return Product
     */
    public function setCreated($created)
    {
        $this->created = $created;

        return $this;
    }

    /**
     * Get created
     *
     * @return \DateTime 
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Set manufactured
     *
     * @param \DateTime $manufactured
     * @return Product
     */
    public function setManufactured($manufactured)
    {
        $this->manufactured = $manufactured;

        return $this;
    }

    /**
     * Get manufactured
     *
     * @return \DateTime 
     */
    public function getManufactured()
    {
        return $this->manufactured;
    }

    /**
     * Set expire
     *
     * @param \DateTime $expire
     * @return Product
     */
    public function setExpire($expire)
    {
        $this->expire = $expire;

        return $this;
    }

    /**
     * Get expire
     *
     * @return \DateTime 
     */
    public function getExpire()
    {
        return $this->expire;
    }

    /**
     * Set openingQuantity
     *
     * @param integer $openingQuantity
     * @return Product
     */
    public function setOpeningQuantity($openingQuantity)
    {
        $this->openingQuantity = $openingQuantity;

        return $this;
    }

    /**
     * Get openingQuantity
     *
     * @return integer 
     */
    public function getOpeningQuantity()
    {
        return $this->openingQuantity;
    }

    /**
     * Set purchasePrice
     *
     * @param integer $purchasePrice
     * @return Product
     */
    public function setPurchasePrice($purchasePrice)
    {
        $this->purchasePrice = $purchasePrice;

        return $this;
    }

    /**
     * Get purchasePrice
     *
     * @return integer 
     */
    public function getPurchasePrice()
    {
        return $this->purchasePrice;
    }

    /**
     * Set openingPrice
     *
     * @param integer $openingPrice
     * @return Product
     */
    public function setOpeningPrice($openingPrice)
    {
        $this->openingPrice = $openingPrice;

        return $this;
    }

    /**
     * Get openingPrice
     *
     * @return integer 
     */
    public function getOpeningPrice()
    {
        return $this->openingPrice;
    }

    /**
     * Set price
     *
     * @param integer $price
     * @return Product
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return integer 
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set visible
     *
     * @param integer $visible
     * @return Product
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
     * Set discontinue
     *
     * @param integer $discontinue
     * @return Product
     */
    public function setDiscontinue($discontinue)
    {
        $this->discontinue = $discontinue;

        return $this;
    }

    /**
     * Get discontinue
     *
     * @return integer 
     */
    public function getDiscontinue()
    {
        return $this->discontinue;
    }

    /**
     * Set view
     *
     * @param integer $view
     * @return Product
     */
    public function setView($view)
    {
        $this->view = $view;

        return $this;
    }

    /**
     * Get view
     *
     * @return integer 
     */
    public function getView()
    {
        return $this->view;
    }

    /**
     * Set about
     *
     * @param string $about
     * @return Product
     */
    public function setAbout($about)
    {
        $this->about = $about;

        return $this;
    }

    /**
     * Get about
     *
     * @return string 
     */
    public function getAbout()
    {
        return $this->about;
    }

    /**
     * Set brand
     *
     * @param \AppBundle\Entity\Brand $brand
     * @return Product
     */
    public function setBrand(\AppBundle\Entity\Brand $brand = null)
    {
        $this->brand = $brand;

        return $this;
    }

    /**
     * Get brand
     *
     * @return \AppBundle\Entity\Brand 
     */
    public function getBrand()
    {
        return $this->brand;
    }

    /**
     * Set measurement
     *
     * @param \AppBundle\Entity\Measurement $measurement
     * @return Product
     */
    public function setMeasurement(\AppBundle\Entity\Measurement $measurement = null)
    {
        $this->measurement = $measurement;

        return $this;
    }

    /**
     * Get measurement
     *
     * @return \AppBundle\Entity\Measurement 
     */
    public function getMeasurement()
    {
        return $this->measurement;
    }

    /**
     * Set gender
     *
     * @param \AppBundle\Entity\Gender $gender
     * @return Product
     */
    public function setGender(\AppBundle\Entity\Gender $gender = null)
    {
        $this->gender = $gender;

        return $this;
    }

    /**
     * Get gender
     *
     * @return \AppBundle\Entity\Gender 
     */
    public function getGender()
    {
        return $this->gender;
    }

    /**
     * Set group
     *
     * @param \AppBundle\Entity\Group $group
     * @return Product
     */
    public function setGroup(\AppBundle\Entity\Group $group = null)
    {
        $this->group = $group;

        return $this;
    }

    /**
     * Get group
     *
     * @return \AppBundle\Entity\Group 
     */
    public function getGroup()
    {
        return $this->group;
    }
    /**
     * Set frontImage
     *
     * @param string $frontImage
     * @return Product
     */
    public function setFrontImage($frontImage)
    {
        $this->frontImage = $frontImage;

        return $this;
    }

    /**
     * Get frontImage
     *
     * @return string
     */
    public function getFrontImage()
    {
        return $this->frontImage;
    }
    /**
     * If manually uploading a file (i.e. not using Symfony Form) ensure an instance
     * of 'UploadedFile' is injected into this setter to trigger the  update. If this
     * bundle's configuration parameter 'inject_on_load' is set to 'true' this setter
     * must be able to accept an instance of 'File' as the bundle will inject one here
     * during Doctrine hydration.
     *
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile $frontImage
     *
     * @return Brand
     */
    public function setFrontImageFile(File $frontImage = null)
    {
        $this->frontImageFile = $frontImage;

        if ($frontImage) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->updatedAt = new \DateTime('now');
        }

        return $this;
    }

    /**
     * @return File
     */
    public function frontImageFile()
    {
        return $this->frontImageFile;
    }

/////////////////////////////////////////////////////////

    /**
     * Set rearImage
     *
     * @param string $rearImage
     * @return Product
     */
    public function setRearImage($rearImage)
    {
        $this->rearImage = $rearImage;

        return $this;
    }

    /**
     * Get rearImage
     *
     * @return string
     */
    public function getRearImage()
    {
        return $this->rearImage;
    }
    /**
     * If manually uploading a file (i.e. not using Symfony Form) ensure an instance
     * of 'UploadedFile' is injected into this setter to trigger the  update. If this
     * bundle's configuration parameter 'inject_on_load' is set to 'true' this setter
     * must be able to accept an instance of 'File' as the bundle will inject one here
     * during Doctrine hydration.
     *
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile $rearImage
     *
     * @return Brand
     */
    public function setRearImageFile(File $rearImage = null)
    {
        $this->rearImageFile = $rearImage;

        return $this;
    }

    /**
     * @return File
     */
    public function rearImageFile()
    {
        return $this->rearImageFile;
    }


//////////////////////////////////////////////////////////////////////////////////////////////////////

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
     * Set orderitem
     *
     * @param \AppBundle\Entity\Orderitem $orderitem
     * @return Product
     */
    public function setOrderitem(\AppBundle\Entity\Orderitem $orderitem = null)
    {
        $this->orderitem = $orderitem;

        return $this;
    }

    /**
     * Get orderitem
     *
     * @return \AppBundle\Entity\Orderitem 
     */
    public function getOrderitem()
    {
        return $this->orderitem;
    }
}
