<?php

declare(strict_types=1);

namespace byteforge88\authpe;

use pocketmine\event\Listener;
use pocketmine\event\player\PlayerLoginEvent;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\event\player\PlayerQuitEvent;

use byteforge88\authpe\password\Password;

class EventListener implements Listener {
    
    public function onLogin(PlayerLoginEvent $event) : void{
        $player = $event->getPlayer();
        
        Password::getInstance()->setFrozen($player);
        $player->setNoClientPredictions();
    }
    
    public function onJoin(PlayerJoinEvent $event) : void{
        $player = $event->getPlayer();
        $password_manager = Password::getInstance();
        
        if ($password_manager->isNew($player)) {
            $player->sendMessage("Please use the command /register to get access to the server!");
        } else {
            $player->sendMessage("Welcome back, use the command /login to continue!");
        }
    }
    
    public function onQuit(PlayerQuitEvent $event) : void{
        $player = $event->getPlayer();
        $password_manager = Password::getInstance();
        
        if ($password_manager->isFrozen($player)) {
            $password_manager->unfreeze($player);
        }
    }
}