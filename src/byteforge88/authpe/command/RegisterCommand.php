<?php

declare(strict_types=1);

namespace byteforge88\authpe\command;

use pocketmine\command\CommandSender;
use pocketmine\command\utils\InvalidCommandSyntaxException;

use pocketmine\player\Player;

use byteforge88\authpe\AuthPE;

use byteforge88\authpe\password\Password;

class RegisterCommand extends AuthCommand {
    
    public function __construct(protected AuthPE $plugin) {
        parent::__construct("register", $this->plugin);
        $this->setDescription("Register your account to get access to the server");
        $this->setPermission("authpe.register");
    }
    
    public function execute(CommandSender $sender, string $commandLabel, array $args) : void{
        if (!$sender instanceof Player) {
            $sender->sendMessage("Run this command in-game!");
            return;
        }
        
        
    }
}