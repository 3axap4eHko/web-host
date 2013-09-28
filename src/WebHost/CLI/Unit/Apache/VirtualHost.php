<?php

namespace WebHost\CLI\Unit\Apache;

use WebHost\CLI\Unit\AbstractUnit;
use WebHost\Common\Behavior\Renderer;

class VirtualHost extends AbstractUnit
{
    use Renderer;
    /**
     * @var string
     */
    protected $listenAddress = '*';
    /**
     * @var int
     */
    protected $listenPort = 80;
    /**
     * @var string
     */
    protected $serverName;
    /**
     * @var \ArrayObject
     */
    protected $serverAliases;
    /**
     * @var string
     */
    protected $documentRoot;
    /**
     * @var \ArrayObject
     */
    protected $scriptAlias;
    /**
     * @var \ArrayObject
     */
    protected $envVars;
    /**
     * @var string
     */
    protected $logDir = '${APACHE_LOG_DIR}';

    /**
     * @param string $templatePath
     */
    public function __construct($templatePath)
    {
        $this->serverAliases = new \ArrayObject();
        $this->scriptAlias = new \ArrayObject();
        $this->envVars = new \ArrayObject();
        $this->templatePath = $templatePath;
    }

    /**
     * @param string $documentRoot
     *
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
     * @param string $listenAddress
     *
     * @return $this
     */
    public function setListenAddress($listenAddress)
    {
        $this->listenAddress = $listenAddress;
        return $this;
    }

    /**
     * @return string
     */
    public function getListenAddress()
    {
        return $this->listenAddress;
    }

    /**
     * @param int $listenPort
     *
     * @return $this
     */
    public function setListenPort($listenPort)
    {
        $this->listenPort = $listenPort;
        return $this;
    }

    /**
     * @return int
     */
    public function getListenPort()
    {
        return $this->listenPort;
    }

    /**
     * @param string $logDir
     *
     * @return $this
     */
    public function setLogDir($logDir)
    {
        $this->logDir = $logDir;
        return $this;
    }

    /**
     * @return string
     */
    public function getLogDir()
    {
        return $this->logDir;
    }

    /**
     * @param string $serverName
     *
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

    /**
     * @param array $aliases
     * @return $this
     */
    public function setScriptAliases(array $aliases)
    {
        $this->scriptAlias->exchangeArray($aliases);

        return $this;
    }

    /**
     * @param string $url
     * @param string $file
     *
     * @return $this
     */
    public function setScriptAlias($url, $file)
    {
        $this->scriptAlias->offsetSet($url, $file);

        return $this;
    }

    /**
     * @param string $url
     *
     * @return string
     */
    public function getScriptAlias($url)
    {
        return $this->scriptAlias->offsetGet($url);
    }

    /**
     * @return array
     */
    public function getScriptAliases()
    {
        return $this->scriptAlias->getArrayCopy();
    }

    /**
     * @param array $envVars
     * @return $this
     */
    public function setEnvVars(array $envVars)
    {
        $this->envVars->exchangeArray($envVars);

        return $this;
    }

    /**
     * @param string $name
     * @param string|int|float $value
     *
     * @return $this
     */
    public function setEnvVar($name, $value)
    {
        $this->envVars->offsetSet($name, $value);

        return $this;
    }

    /**
     * @param string $name
     * @return string|int|float
     */
    public function getEnvVar($name)
    {
        return $this->envVars->offsetGet($name);
    }

    /**
     * @return array
     */
    public function getEnvVars()
    {
        return $this->envVars->getArrayCopy();
    }

    /**
     * @param array $aliases
     * @return $this
     */
    public function setServerAliases(array $aliases)
    {
        $this->serverAliases->exchangeArray($aliases);

        return $this;
    }

    /**
     * @param string $alias
     * @return $this
     */
    public function addServerAlias($alias)
    {
        $this->serverAliases->append($alias);

        return $this;
    }

    /**
     * @return array
     */
    public function getServerAliases()
    {
        return $this->serverAliases->getArrayCopy();
    }

    protected function isValid()
    {
        return !empty($this->documentRoot);
    }

}