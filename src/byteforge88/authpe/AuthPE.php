<?php

declare(strict_types=1);

namespace byteforge88\authpe;

use pocketmine\plugin\PluginBase;

class AuthPE extends PluginBase {
    
    protected static self $instance;
    
    protected function onLoad() : void{
        self::$instance = $this;
    }
    
    protected function onEnable() : void{
        
    }
    
    protected function onDisable() : void{
        
    }
    
    public static function getInstance() : self{
        return self::$instance;
    }
}