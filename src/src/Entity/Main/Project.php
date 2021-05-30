<?php

namespace App\Entity\Main;


use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Scope\MainBundle\Entity\Image;

/**
 * @ORM\Entity(repositoryClass="Scope\MainBundle\Entity\ProjectRepository")
 * @ORM\Table(name="main_project")
 */
class Project
{
    const PHOTO_TYPE_ONE = 'image/gif';
    const PHOTO_TYPE_SECOND = 'image/jpeg';
    const PHOTO_TYPE_THIRD = 'image/pjpeg';
    const PHOTO_TYPE_FOURTH = 'image/png';
    const PHOTO_TYPE_FIFTH = 'image/svg+xml';
    const PHOTO_TYPE_SIXTH = 'image/tiff';
    const PHOTO_TYPE_SEVENTH = 'image/vnd.microsoft.icon';
    const PHOTO_TYPE_EIGHTH = 'image/vnd.wap.wbmp';
    const PHOTO_TYPE_NINTH = 'application/octet-stream';

    /**
     * @var array
     */
    static $allowedMimeTypes = array(
        self::PHOTO_TYPE_ONE,
        self::PHOTO_TYPE_SECOND,
        self::PHOTO_TYPE_THIRD,
        self::PHOTO_TYPE_FOURTH,
        self::PHOTO_TYPE_FIFTH,
        self::PHOTO_TYPE_SIXTH,
        self::PHOTO_TYPE_SEVENTH,
        self::PHOTO_TYPE_EIGHTH,
        self::PHOTO_TYPE_NINTH,
    );

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=100)
     */
    protected $title;

    /**
     * @Gedmo\Slug(fields={"title"}, updatable=false)
     * @ORM\Column(type="string", length=191, unique=true)
     */
    protected $slug;

    /**
     * @ORM\Column(type="string", length=1000)
     */
    protected $info;

    /**
     * @ORM\Column(type="string", length=7000)
     */
    protected $text;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $link;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @var string
     */
    protected $path;

    /**
     * Store old file path to remove file after update avatar
     * @var string
     */
    private $temp;

    /**
     * @ORM\Column(type="boolean")
     */
    protected $isPublished = false;

    /**
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $createdAt;

    /**
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $updatedAt;

    /**
     * @ORM\OneToMany(targetEntity="Image", mappedBy="page", cascade={"persist"}, orphanRemoval=true)
     */
    protected $images;

    public function __construct()
    {
        $this->images = new ArrayCollection();
    }

    /**
     * @Assert\File(
     *     maxSize = "10000M",
     *     mimeTypes = {"image/jpeg", "image/png", "image/gif"},
     *     mimeTypesMessage = "Недопустимый формат файла"
     * )
     * @inheritdoc
     */
    public function getPath()
    {
        return ($this->path instanceof UploadedFile) ? $this->path : null;
    }

    public function getSavedPath()
    {
        return $this->path;
    }

    public function setPath($path = null)
    {
        if (null !== $path) {
            $this->path = $path;
        }

        return $this;
    }

    public function setSavedPath($path)
    {
        $this->path = $path;

        return $this;
    }

    public function getTemp()
    {
        return $this->temp;
    }

    public function setTemp($temp)
    {
        $this->temp = $temp;
    }

    public static function getAllowedMimeTypes()
    {
        return self::$allowedMimeTypes;
    }

    public function getContainerName()
    {
        return 'main';
    }

    public function getId()
    {
        return $this->id;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function setTitle($title)
    {
        $this->title = $title;
    }

    public function getSlug()
    {
        return $this->slug;
    }

    public function setSlug($slug)
    {
        $this->slug = $slug;
    }

    public function getInfo()
    {
        return $this->info;
    }

    public function setInfo($info)
    {
        $this->info = $info;
    }

    public function getText()
    {
        return $this->text;
    }

    public function setText($text)
    {
        $this->text = $text;
    }

    public function getLink()
    {
        return $this->link;
    }

    public function setLink($link)
    {
        $this->link = $link;
    }

    public function getIsPublished()
    {
        return $this->isPublished;
    }

    public function setIsPublished($isPublished)
    {
        $this->isPublished = $isPublished;
    }

    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    }

    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;
    }

    public function setImages($images)
    {
        if (count($images) > 0) {
            foreach ($images as $i) {
                $this->addImage($i);
            }
        }

        return $this;
    }

    public function addImage(Image $image)
    {
        $image->setProject($this);

        $this->images->add($image);
    }

    public function removeImage(Image $image)
    {
        $this->images->removeElement($image);
    }

    public function getImages()
    {
        return $this->images;
    }

    public function __toString()
    {
        return $this->title ? $this->title : 'Новый Проект';
    }
}
