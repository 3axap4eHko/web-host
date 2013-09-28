<?php
/** @var \WebHost\CLI\Unit\Apache\VirtualHost $this */
?>
<VirtualHost <?php echo $this->getListenAddress() ?>:<?php echo $this->getListenPort() ?>>
    ServerName <?php echo $this->getServerName() ?>
    <?php if (count($aliases = $this->getServerAliases())) {
        echo PHP_EOL . '    ServerAlias';
        foreach($aliases as $alias) {
            echo ' ' . $alias;
        }
    }
    ?>

    DocumentRoot <?php echo $this->getDocumentRoot() ?>
    <?php if (count($aliases = $this->getScriptAliases())) {
        foreach($aliases as $key => $value) {
            echo PHP_EOL . '    ScriptAlias ' . $key . ' ' . dirname($this->getDocumentRoot()) . $value;
        }
    }
    ?>
    <?php if (count($envVars = $this->getEnvVars())) {
        foreach($envVars as $key => $value) {
            echo PHP_EOL . '    SetEnv ' . $key . ' "' . $value . '"';
        }
    }
    ?>

    <Directory <?php echo $this->getDocumentRoot() ?>>
        DirectoryIndex index.php index.html
        AllowOverride All
        Require all Granted
    </Directory>

    ErrorLog <?php echo $this->getLogDir() ?>/<?php echo $this->getServerName() ?>.errors
    CustomLog <?php echo $this->getLogDir() ?>/<?php echo $this->getServerName() ?>.access common
</VirtualHost>
