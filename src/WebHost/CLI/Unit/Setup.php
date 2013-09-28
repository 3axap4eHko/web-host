<?php

namespace WebHost\CLI\Unit;


use Phalcon\Config;
use Zend\Code\Generator\ValueGenerator;

class Setup extends AbstractUnit
{
    /**
     * @var string
     */
    protected $fileName;
    /**
     * @var Config
     */
    protected $config;

    public function __construct($directory)
    {
        $this->fileName = $directory . '/local.config.php';
        $this->config = new Config(file_exists($this->fileName) ? include $this->fileName : []);
    }

    public function set($key, $value)
    {
        $this->config->offsetSet($key, $value);

        return $this;
    }

    public function save()
    {
        $config = new ValueGenerator($this->config->toArray());
        file_put_contents($this->fileName, "<?php\n/**\n * Auto generated config file\n */\nreturn {$config->generate()};");

        return $this;
    }
}