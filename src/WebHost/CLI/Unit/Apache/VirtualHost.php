<?php

namespace WebHost\CLI\Unit\Apache;

use WebHost\CLI\Arguments;
use WebHost\CLI\Unit\AbstractUnit;
use WebHost\Common\Behavior\Renderer;
use WebHost\Common\Exception;

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
     * @var string
     */
    protected $comment = '';

    public function __construct(Arguments $arguments)
    {
        $this->setServerName($arguments->get('serverName'));
        $this->setDocumentRoot($arguments->get('documentRoot'));

        $this->setServerAliases((array)$arguments->get('server'));
        $this->setScriptAliases((array)$arguments->get('script'));
        $this->setEnvVars((array)$arguments->get('env'));

        $this->setListenAddress($arguments->get('listenAddress', $this->getListenAddress()));
        $this->setListenPort($arguments->get('listenPort', $this->getListenPort()));
        $this->setLogDir($arguments->get('logDir', $this->getLogDir()));
        $this->setComment($arguments->get('listenPort', $this->getComment()));
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
        $this->scriptAlias = new \ArrayObject($aliases);;

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
        $this->envVars = new \ArrayObject($envVars);

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
        $this->serverAliases = new \ArrayObject($aliases);

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

    /**
     * @return bool
     */
    protected function isValid()
    {
        return !empty($this->documentRoot) && !file_exists($this->documentRoot)  && !empty($this->serverName);
    }

    /**
     * @param string $comment
     *
     * @return $this
     */
    public function setComment($comment)
    {
        $this->comment = $comment;
        return $this;
    }

    /**
     * @return string
     */
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * @throws \WebHost\Common\Exception
     */
    public function save($rewrite = false)
    {
        $config = $this->getDI()->getShared('config');
        $fileName = $config->get('apache')->directory . '/sites-available/'.$this->getServerName().'.conf';
        if (file_exists($fileName) && !$rewrite)
        {
            throw new Exception('Virtual host for '. $this->getServerName().' already exists!');
        }
        $this->fileWrite($fileName, $this->render($this->getViewPath('WebHost\CLI','apache/vhost.php')), true);
        if (!is_dir($this->getDocumentRoot()))
        {
            mkdir($this->getDocumentRoot(), 0775, true);
        }

        $cmd = 'chown -R ' . implode('.',array_fill(0,2, $config->get('apache')->owner)) . ' ' . dirname($this->getDocumentRoot());
        system($cmd);
        system('a2ensite ' . $this->getServerName());
        $this->getEventsManager()->fire('apache:graceful', null);
    }

    public function remove()
    {
        system('a2dissite ' . $this->getServerName());

        $config = $this->getDI()->getShared('config');
        $fileName = $config->get('apache')->directory . '/sites-available/'.$this->getServerName().'.conf';
        unlink($fileName);
        $this->getEventsManager()->fire('apache:graceful', null);
    }
}