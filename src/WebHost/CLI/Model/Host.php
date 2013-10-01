<?php

namespace WebHost\CLI\Model;

class Host
{
    /**
     * @var string
     */
    protected $serverName;
    /**
     * @var string
     */
    protected $documentRoot;
    /**
     * @var \ArrayObject
     */
    protected $options;

    public function __construct()
    {
        $this->options = new \ArrayObject();
    }

    /**
     * @param \ArrayObject $options
     * @return $this
     */
    public function setOptions(\ArrayObject $options)
    {
        $this->options = $options;

        return $this;
    }

    /**
     * @return \ArrayObject
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * @param string $documentRoot
     * @return $this
     */
    public function setDocumentRoot($documentRoot)
    {
        $this->documentRoot = $documentRoot;

        return $this;
    }

    /**
     * @return string
     */
    public function getDocumentRoot()
    {
        return $this->documentRoot;
    }

    /**
     * @param string $serverName
     * @return $this
     */
    public function setServerName($serverName)
    {
        $this->serverName = $serverName;

        return $this;
    }

    /**
     * @return string
     */
    public function getServerName()
    {
        return $this->serverName;
    }



}