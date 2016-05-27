<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="promo")
 * @ORM\HasLifecycleCallbacks
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PromoRepository")
 */

class Promo
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
     * @ORM\Column(type="integer", length=1)
     */
    protected $expire;
    /**
     * @ORM\Column(type="text")
     */
    protected $article;
    /**
     * @ORM\Column(type="datetime")
     *
     */
    protected $publishDate;
    /**
     * @ORM\Column(type="integer")
     *
     */
    protected $view;

    /**
     * @ORM\Column(type="string")
     * @Assert\File(
     *     maxSize = "2M",
     *     mimeTypes = {"image/jpeg", "image/gif", "image/png", "image/tiff"},
     *     maxSizeMessage = "The maxmimum allowed file size is 2MB.",
     *     mimeTypesMessage = "Only the filetypes image are allowed."
     * )
     */
    private $file;






    //image handling .....


    public function getFullImagePath() {
        return null === $this->file ? null : $this->getUploadRootDir(). $this->file;
    }

    protected function getUploadRootDir() {
        // the absolute directory path where uploaded documents should be saved
        return $this->getTmpUploadRootDir().$this->getId()."/";
    }

    protected function getTmpUploadRootDir() {
        // the absolute directory path where uploaded documents should be saved
        return __DIR__.'/../../../web/uploads/images/news';
    }






    /**
     * @ORM\PrePersist()
     *
     */
    public function uploadImage() {
        // the file property can be empty if the field is not required
        if (null === $this->file) {
            return;
        }
        if(!$this->id){
            $this->file->move($this->getTmpUploadRootDir(), $this->file->getClientOriginalName());
        }else{
            $this->file->move($this->getUploadRootDir(), $this->file->getClientOriginalName());
        }
        $this->setFile($this->file->getClientOriginalName());
    }








    /**
     * @ORM\PostPersist()
     */
    public function upload()
    {
        if (null === $this->file) {
            return;
        }
        if(!is_dir($this->getUploadRootDir())){
            mkdir($this->getUploadRootDir());
        }
        //copy($this->getTmpUploadRootDir().$this->file, $this->getFullImagePath());
       // unlink($this->getTmpUploadRootDir().$this->file);
    }


    /**
     * @ORM\PreRemove()
     */
    public function removeImage()
    {
        unlink($this->getFullImagePath());
        rmdir($this->getUploadRootDir());
    }







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
     *
     * @return News
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
     * Set expire
     *
     * @param integer $expire
     *
     * @return News
     */
    public function setExpire($expire)
    {
        $this->expire = $expire;

        return $this;
    }

    /**
     * Get expire
     *
     * @return integer
     */
    public function getExpire()
    {
        return $this->expire;
    }

    /**
     * Set article
     *
     * @param string $article
     *
     * @return News
     */
    public function setArticle($article)
    {
        $this->article = $article;

        return $this;
    }

    /**
     * Get article
     *
     * @return string
     */
    public function getArticle()
    {
        return $this->article;
    }

    /**
     * Set publishDate
     *
     * @param \DateTime $publishDate
     *
     * @return News
     */
    public function setPublishDate($publishDate)
    {
        $this->publishDate = $publishDate;

        return $this;
    }

    /**
     * Get publishDate
     *
     * @return \DateTime
     */
    public function getPublishDate()
    {
        return $this->publishDate;
    }

    /**
     * Set view
     *
     * @param integer $view
     *
     * @return News
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
     * Sets file.
     *
     * @param string $file
     */
    public function setFile($file)
    {
        $this->file = $file;
    }


    /**
     * Get file.
     *
     * @return string
     */
    public function getFile()
    {
        return $this->file;
    }





}
