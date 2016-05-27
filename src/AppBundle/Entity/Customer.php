<?php
namespace AppBundle\Entity;

use PUGX\MultiUserBundle\Validator\Constraints\UniqueEntity;
use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="customers")
 * @UniqueEntity(fields = "username", targetClass = "AppBundle\Entity\User", message="fos_user.username.already_used")
 * @UniqueEntity(fields = "email", targetClass = "AppBundle\Entity\User", message="fos_user.email.already_used")
 */
class Customer extends User
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    public function __construct()
    {
        parent::__construct();
        // your own logic
        $this->roles = array('ROLE_CUSTOMER');
    }

    /**
     * @ORM\Column(type="string", length=100)
     */
    protected $firstName;
    /**
     * @ORM\Column(type="string", length=100)
     */
    protected $lastName;
    /**
     * @ORM\Column(type="integer", length=100,nullable=false)
     */
    protected $phone;

    /**
     * @ORM\Column(type="text",nullable=true)
     */
    protected $billingAddress;
    /**
     * @ORM\Column(type="text",nullable=true)
     */
    protected $contactAddress;

    /**
     * @ORM\Column(type="string", length=100,nullable=true)
     */
    protected $state;
    /**
     * @ORM\Column(type="string", length=100,nullable=true)
     */
    protected $city;
    /**
     * @ORM\Column(type="smallint",nullable=true)
     */
    protected $receivePromo;
    /**
     * @ORM\Column(type="integer",nullable=true, options={"unsigned":true, "default":0})
     */
    protected $login_count;

    /**
     * @ORM\Column(type="smallint",nullable=true, options={"unsigned":true, "default":0})
     */
    protected $updated;

    /**
     * Set firstName
     *
     * @param string $firstName
     * @return Customer
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * Get firstName
     *
     * @return string 
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Set lastName
     *
     * @param string $lastName
     * @return Customer
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * Get lastName
     *
     * @return string 
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * Set phone
     *
     * @param \phone $phone
     * @return Customer
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * Get phone
     *
     * @return \phone 
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Set billingAddress
     *
     * @param string $billingAddress
     * @return Customer
     */
    public function setBillingAddress($billingAddress)
    {
        $this->billingAddress = $billingAddress;

        return $this;
    }

    /**
     * Get billingAddress
     *
     * @return string 
     */
    public function getBillingAddress()
    {
        return $this->billingAddress;
    }

    /**
     * Set contactAddress
     *
     * @param string $contactAddress
     * @return Customer
     */
    public function setContactAddress($contactAddress)
    {
        $this->contactAddress = $contactAddress;

        return $this;
    }

    /**
     * Get contactAddress
     *
     * @return string 
     */
    public function getContactAddress()
    {
        return $this->contactAddress;
    }

    /**
     * Set country
     *
     * @param string $country
     * @return Customer
     */
    public function setCountry($country)
    {
        $this->country = $country;

        return $this;
    }

    /**
     * Get country
     *
     * @return string 
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * Set state
     *
     * @param string $state
     * @return Customer
     */
    public function setState($state)
    {
        $this->state = $state;

        return $this;
    }

    /**
     * Get state
     *
     * @return string 
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * Set city
     *
     * @param string $city
     * @return Customer
     */
    public function setCity($city)
    {
        $this->city = $city;

        return $this;
    }

    /**
     * Get city
     *
     * @return string 
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Set receivePromo
     *
     * @param integer $receivePromo
     * @return Customer
     */
    public function setReceivePromo($receivePromo)
    {
        $this->receivePromo = $receivePromo;

        return $this;
    }

    /**
     * Get receivePromo
     *
     * @return integer 
     */
    public function getReceivePromo()
    {
        return $this->receivePromo;
    }

    /**
     * Set login_count
     *
     * @param integer $loginCount
     * @return Customer
     */
    public function setLoginCount($loginCount)
    {
        $this->login_count = $loginCount;

        return $this;
    }

    /**
     * Get login_count
     *
     * @return integer 
     */
    public function getLoginCount()
    {
        return $this->login_count;
    }

    /**
     * Set updated
     *
     * @param integer $updated
     * @return Customer
     */
    public function setUpdated($updated)
    {
        $this->updated = $updated;

        return $this;
    }

    /**
     * Get updated
     *
     * @return integer 
     */
    public function getUpdated()
    {
        return $this->updated;
    }
}
