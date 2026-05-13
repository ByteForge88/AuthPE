<?php

declare(strict_types=1);

namespace byteforge88\authpe\command;

use pocketmine\command\CommandSender;
use pocketmine\command\utils\InvalidCommandSyntaxException;

use pocketmine\player\Player;

use byteforge88\authpe\AuthPE;

use byteforge88\authpe\password\Password;

class LoginCommand extends AuthCommand {
    
    public function __construct(protected AuthPE $plugin) {
        parent::__construct("login", $this->plugin);
        $this->setDescription("Login in to play on this server");
        $this->setUsage("/login <password>");
        $this->setPermission("authpe.login");
    }
    
    public function execute(CommandSender $sender, string $commandLabel, array $args) : void{
        if (!$sender instanceof Player) {
            $sender->sendMessage("Run this command in-game!");
            return;
        }
        
        if (!isset($args[0])) {
            throw new InvalidCommandSyntaxException();
            return;
        }
        
        $password_manager = Password::getInstance();
        
        if ($password_manager->isNew($sender)) {
            $sender->sendMessage("You haven't registered yet, Register by doing /register!");
            return;
        }
        
        if ($password_manager->matchPassword($sender, $args[0]) === false) {
            $sender->sendMessage("Incorrect password!");
            return;
        }
        
        $sender->setNoClientPredictions(false);
        $sender->sendMessage("You have successfully logged in!");
    }
}