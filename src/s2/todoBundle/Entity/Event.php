<?php

namespace s2\todoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Event
 *
 * @ORM\Table(name="todo_events")
 * @ORM\Entity(repositoryClass="s2\todoBundle\Entity\EventRepository")
 */
class Event {

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=500)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="adress", type="string", length=500)
     */
    private $adress;

    /**
     * @var string
     *
     * @ORM\Column(name="text", type="text", nullable=true)
     */
    private $text;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;

    /**
     * @var string
     *
     * @ORM\Column(name="document", type="string", length=500, nullable=true)
     */
    private $document;

    /**
     * @var integer
     *
     * @ORM\Column(name="public", type="integer")
     */
    private $public;

    /**
     * @var integer
     *
     * @ORM\ManyToMany(targetEntity="s2\todoBundle\Entity\Tag")
     */
    private $tags;

    /**
     * @Assert\File(maxSize="1024k",
     * mimeTypes = {"application/pdf", "application/x-pdf", "text/plain", "application/rtf", "application/x-rtf", "text/richtext","application/msword"},
     * mimeTypesMessage = "Choisissez un fichier valide (pdf, doc, rtf, txt)"
     * )
     */
    public $file;

    public function getAbsolutePath() {
        return null === $this->document ? null : $this->getUploadRootDir() . '/' . $this->document;
    }

    public function getWebPath() {
        return null === $this->document ? null : $this->getUploadDir() . '/' . $this->document;
    }

    protected function getUploadRootDir() {
        // le chemin absolu du répertoire où les documents uploadés doivent être sauvegardés
        return __DIR__ . '/../../../../web/' . $this->getUploadDir();
    }

    protected function getUploadDir() {
        // on se débarrasse de « __DIR__ » afin de ne pas avoir de problème lorsqu'on affiche
        // le document/image dans la vue.
        return 'uploads/documents';
    }

    public function upload() {
        // la propriété « file » peut être vide si le champ n'est pas requis
        if (null === $this->file) {
            return;
        }

        $this->file->move($this->getUploadRootDir(), $this->file->getClientOriginalName());


        $this->document = $this->file->getClientOriginalName();

        // « nettoie » la propriété « file » comme vous n'en aurez plus besoin
        $this->file = null;
    }

    public function deleteFile() {
        // la propriété « file » peut être vide si le champ n'est pas requis
        if (null === $this->document) {
            return;
        }

        unlink($this->getAbsolutePath());
    }

    /**
     * Constructor
     */
    public function __construct() {
        $this->tags = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set title
     *
     * @param string $title
     * @return Event
     */
    public function setTitle($title) {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string 
     */
    public function getTitle() {
        return $this->title;
    }

    /**
     * Set adress
     *
     * @param string $adress
     * @return Event
     */
    public function setAdress($adress) {
        $this->adress = $adress;

        return $this;
    }

    /**
     * Get adress
     *
     * @return string 
     */
    public function getAdress() {
        return $this->adress;
    }

    /**
     * Set text
     *
     * @param string $text
     * @return Event
     */
    public function setText($text) {
        $this->text = $text;

        return $this;
    }

    /**
     * Get text
     *
     * @return string 
     */
    public function getText() {
        return $this->text;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     * @return Event
     */
    public function setDate($date) {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime 
     */
    public function getDate() {
        return $this->date;
    }

    /**
     * Set document
     *
     * @param string $document
     * @return Event
     */
    public function setDocument($document) {
        $this->document = $document;

        return $this;
    }

    /**
     * Get document
     *
     * @return string 
     */
    public function getDocument() {
        return $this->document;
    }

    /**
     * Set public
     *
     * @param integer $public
     * @return Event
     */
    public function setPublic($public) {
        $this->public = $public;

        return $this;
    }

    /**
     * Get public
     *
     * @return integer 
     */
    public function getPublic() {
        return $this->public;
    }

    /**
     * Add tags
     *
     * @param \s2\todoBundle\Entity\Tag $tags
     * @return Event
     */
    public function addTag(\s2\todoBundle\Entity\Tag $tags) {
        $this->tags[] = $tags;

        return $this;
    }

    /**
     * Remove tags
     *
     * @param \s2\todoBundle\Entity\Tag $tags
     */
    public function removeTag(\s2\todoBundle\Entity\Tag $tags) {
        $this->tags->removeElement($tags);
    }

    /**
     * Get tags
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getTags() {
        return $this->tags;
    }

}
