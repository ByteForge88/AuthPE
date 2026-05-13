<?php

declare(strict_types=1);

namespace byteforge88\authpe;

use pocketmine\plugin\PluginBase;

use byteforge88\authpe\command\LoginCommand;
use byteforge88\authpe\command\RegisterCommand;

use byteforge88\authpe\database\Database;

class AuthPE extends PluginBase {
    
    protected static self $instance;
    
    protected function onLoad() : void{
        self::$instance = $this;
    }
    
    protected function onEnable() : void{
        $server = $this->getServer();
        
        $server->getPluginManager()->registerEvents(new EventListener(), $this);
        
        $server->getCommandMap()->registerAll("AuthPE", [
            new LoginCommand($this),
            new RegisterCommand($this)
        ]);
    }
    
    protected function onDisable() : void{
        Database::getInstance()->close();
    }
    
    public static function getInstance() : self{
        return self::$instance;
    }
}