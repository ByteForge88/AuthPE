<?php

declare(strict_types=1);

namespace byteforge88\authpe\password;

use pocketmine\player\Player;

use pocketmine\utils\SingletonTrait;

use byteforge88\authpe\database\Database;

class Password {
    use SingletonTrait;
    
    public array $frozen = [];
    
    public function isFrozen(Player $player) : bool{
        return isset($this->frozen[$player->getUniqueId()->getBytes()]);
    }
    
    public function setFrozen(Player $player) : void{
        $this->frozen[$player->getUniqueId()->getBytes()] = true;
    }
    
    public function unfreeze(Player $player) : void{
        unset($this->frozen[$player->getUniqueId()->getBytes()]);
    }
    
    public function isNew(Player $player) : bool{
        $stmt = Database::getInstance()->getSQL()->prepare("SELECT * FROM passwords WHERE player = :player;");
        
        try {
            $stmt->bindValue(":player", $player->getName(), SQLITE3_TEXT);
            
            $result = $stmt->execute();
            $data = $result->fetchArray(SQLITE3_ASSOC);
            
            $result->finalize();
            
            return $data === false ? true : false;
        } finally {
            $stmt->close();
        }
    }
    
    public function getPassword(Player $player) : ?string{
        $stmt = Database::getInstance()->getSQL()->prepare("SELECT password FROM passwords WHERE player = :player;");
        
        try {
            $stmt->bindValue(":player", $player->getName(), SQLITE3_TEXT);
            
            $result = $stmt->execute();
            $data = $result->fetchArray(SQLITE3_ASSOC);
            
            $result->finalize();
            
            return $data === null ? null : $data["password"];
        } finally {
            $stmt->close();
        }
    }
    
    public function register(Player $player, string $password) : void{
        $stmt = Database::getInstance()->getSQL()->prepare("INSERT INTO passwords (player, password) VALUES (:player, :password);");
        
        try {
            $stmt->bindValue(":player", $player->getName(), SQLITE3_TEXT);
            $stmt->bindValue(":password", $password, SQLITE3_TEXT);
            
            $result = $stmt->execute();
            
            $result->finalize();
        } finally {
            $stmt->close();
        }
    }
    
    public function matchPassword(Player $player, string $password) : bool{
        $stmt = Database::getInstance()->getSQL()->prepare("SELECT password FROM passwords WHERE player = :player;");
        
        try {
            $stmt->bindValue(":player", $player->getName(), SQLITE3_TEXT);
            
            $result = $stmt->execute();
            $data = $result->fetchArray(SQLITE3_ASSOC);
            
            if ($password === $data["password"]) {
                return true;
            }
            
            $result->finalize();
            
            return false;
        } finally {
            $stmt->close();
        }
    }
}