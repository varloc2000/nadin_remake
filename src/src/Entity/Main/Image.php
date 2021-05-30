<?php

namespace App\Entity\Main;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * @ORM\Entity
 * @ORM\Table(name="main_image")
 */
class Image
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
     * @ORM\Column(name="path", type="string", length=255, nullable=true)
     * @var string
     */
    protected $path;

    /**
     * Store old file path to remove file after update avatar
     * @var string
     */
    private $temp;

    /**
     * @ORM\Column(type="string", length=100)
     */
    protected $title;

    /**
     * @ORM\ManyToOne(targetEntity="Project", inversedBy="images")
     */
    protected $project;

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

    public function getTitle()
    {
        return $this->title;
    }

    public function setTitle($title)
    {
        $this->title = $title;
    }

    public function getProject()
    {
        return $this->project;
    }

    public function setProject(Project $project)
    {
        $this->project = $project;
    }

    public function __toString()
    {
        return $this->title ? $this->title : 'New Image';
    }
}
