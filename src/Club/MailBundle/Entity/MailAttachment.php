<?php

namespace Club\MailBundle\Entity;

/**
 * @orm:Entity(repositoryClass="Club\MailBundle\Repository\MailAttachment")
 * @orm:Table(name="club_mail_attachment")
 */
class MailAttachment
{
    /**
     * @orm:Id
     * @orm:Column(type="integer")
     * @orm:GeneratedValue(strategy="AUTO")
     *
     * @var integer $id
     */
    private $id;

    /**
     * @orm:Column(type="string")
     *
     * @var string $file_path
     */
    private $file_path;

    /**
     * @orm:Column(type="string")
     *
     * @var string $file_name
     */
    private $file_name;

    /**
     * @orm:Column(type="string")
     *
     * @var string $file_type
     */
    private $file_type;

    /**
     * @orm:Column(type="string")
     * 
     * @var string $file_size
     */
    private $file_size;

    /**
     * @orm:Column(type="string")
     *
     * @var string $file_hash
     */
    private $file_hash;

    /**
     * @orm:ManyToOne(targetEntity="Mail")
     *
     * @var Club\MailBundle\Entity\Mail
     */
    private $mail;


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
     * Set mail
     *
     * @param Club\MailBundle\Entity\Mail $mail
     */
    public function setMail(\Club\MailBundle\Entity\Mail $mail)
    {
        $this->mail = $mail;
    }

    /**
     * Get mail
     *
     * @return Club\MailBundle\Entity\Mail $mail
     */
    public function getMail()
    {
        return $this->mail;
    }
}
