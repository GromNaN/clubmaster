<?php

namespace Club\MessageBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="Club\MessageBundle\Entity\MessageAttachmentRepository")
 * @ORM\Table(name="club_message_message_attachment")
 * @ORM\HasLifecycleCallbacks()
 */
class MessageAttachment
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     *
     * @var integer $id
     */
    protected $id;

    /**
     * @Assert\File(maxSize="6000000")
     * @Assert\NotBlank()
     *
     * @var string $file
     */
    public $file;

    /**
     * @ORM\Column(type="string")
     *
     * @var string $file_path
     */
    protected $file_path;

    /**
     * @ORM\Column(type="string")
     *
     * @var string $file_name
     */
    protected $file_name;

    /**
     * @ORM\Column(type="string")
     *
     * @var string $file_type
     */
    protected $file_type;

    /**
     * @ORM\Column(type="string")
     *
     * @var string $file_size
     */
    protected $file_size;

    /**
     * @ORM\Column(type="string")
     *
     * @var string $file_hash
     */
    protected $file_hash;

    /**
     * @ORM\ManyToOne(targetEntity="Message")
     *
     * @var Club\MessageBundle\Entity\Message
     */
    protected $message;


    /**
     * Get id
     *
     * @return integer $id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set file_path
     *
     * @param string $filePath
     */
    public function setFilePath($filePath)
    {
        $this->file_path = $filePath;
    }

    /**
     * Get file_path
     *
     * @return string $filePath
     */
    public function getFilePath()
    {
        return $this->file_path;
    }

    /**
     * Set file_name
     *
     * @param string $fileName
     */
    public function setFileName($fileName)
    {
        $this->file_name = $fileName;
    }

    /**
     * Get file_name
     *
     * @return string $fileName
     */
    public function getFileName()
    {
        return $this->file_name;
    }

    /**
     * Set file_type
     *
     * @param string $fileType
     */
    public function setFileType($fileType)
    {
        $this->file_type = $fileType;
    }

    /**
     * Get file_type
     *
     * @return string $fileType
     */
    public function getFileType()
    {
        return $this->file_type;
    }

    /**
     * Set file_size
     *
     * @param string $fileSize
     */
    public function setFileSize($fileSize)
    {
        $this->file_size = $fileSize;
    }

    /**
     * Get file_size
     *
     * @return string $fileSize
     */
    public function getFileSize()
    {
        return $this->file_size;
    }

    /**
     * Set file_hash
     *
     * @param string $fileHash
     */
    public function setFileHash($fileHash)
    {
        $this->file_hash = $fileHash;
    }

    /**
     * Get file_hash
     *
     * @return string $fileHash
     */
    public function getFileHash()
    {
        return $this->file_hash;
    }

    /**
     * Set message
     *
     * @param Club\MessageBundle\Entity\Message $message
     */
    public function setMessage(\Club\MessageBundle\Entity\Message $message)
    {
        $this->message = $message;
    }

    /**
     * Get message
     *
     * @return Club\MessageBundle\Entity\Message $message
     */
    public function getMessage()
    {
      return $this->message;
    }

    public function getAbsolutePath()
    {
      return null === $this->getFilePath() ? null : $this->getFSUploadPath().'/'.$this->getFilePath();
    }

    public function getWebPath()
    {
      return null === $this->getFilePath() ? null : $this->getUploadDir().'/'.$this->getFilePath();
    }

    protected function getFSUploadPath()
    {
      return __DIR__.'/../../../../web/'.$this->getUploadPath();
    }

    protected function getUploadPath()
    {
      return 'uploads/attachments';
    }

    /**
     * @ORM\PrePersist()
     */
    public function prePersist()
    {
      if (!$this->getFilePath()) {
        $this->setFilePath(uniqid().'.'.$this->file->getExtension());
        $this->setFileName($this->file->getClientOriginalName());
        $this->setFileSize(filesize($this->file->getPathName()));
        $this->setFileHash(hash_file('sha256', $this->file->getPathName()));

        $finfo = new \finfo(FILEINFO_MIME);
        $this->setFileType($finfo->file($this->file->getPathName()));
      }
    }

    /**
     * @ORM\PostPersist()
     */
    public function postPersist()
    {
      if (method_exists($this->file, 'move')) {
        $this->file->move($this->getFSUploadPath(), $this->getFilePath());
        unset($this->file);
      }
    }

    /**
     * @ORM\PostRemove()
     */
    public function postRemove()
    {
      if (file_exists($this->getAbsolutePath())) {
        unlink($this->getAbsolutePath());
      }
    }
}
