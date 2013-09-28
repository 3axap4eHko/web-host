<?php

namespace WebHost\Common\Code\Generator;

use Zend\Code\Generator\ValueGenerator;

class ArrayConfig extends ValueGenerator
{
    public function generate()
    {
        return "<?php\n/**\n * Auto generated file\n */\nreturn " . parent::generate() . ";";
    }
}