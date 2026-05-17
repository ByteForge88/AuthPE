<?php

declare(strict_types=1);

namespace byteforge88\authpe\command;

use pocketmine\command\Command;

use pocketmine\plugin\PluginOwned;

use byteforge88\authpe\AuthPE;

/**
 * @deprecated
 * TODO: use PM6 ugly and chopped command system
 * Perhaps we should use Commando instead?
 * For now we'll use the 'legacy' Command system.
 */
abstract class AuthCommand extends Command implements PluginOwned {
    
    protected AuthPE $plugin;
    
    public function __construct(string $name, AuthPE $plugin) {
        parent::__construct($name);
        $this->plugin = $plugin;
        $this->usageMessage = "";
    }
    
    public function getOwningPlugin() : AuthPE{
        return $this->plugin;
    }
}