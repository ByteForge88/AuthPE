<?php

declare(strict_types=1);

namespace byteforge88\authpe\database;

use SQLite3;

use pocketmine\utils\SingletonTrait;

use byteforge88\authpe\AuthPE;

class Database {
    use SingeltonTrait;
    
    protected AuthPE $plugin;
    
    private function __construct(AuthPE $plugin) {
        $folder = AuthPE::getInstance()->getDataFolder() . "database/";
        
        @mkdir($folder);
        
        $this->sql = new SQLite3($folder . "database.db");
        
        $this->sql->exec("CREATE TABLE IF NOT EXISTS passwords (player TEXT PRIMARY KEY, password TEXT);");
    }
    
    public function close() : void{
        return $this->sql->close();
    }
    
    public function getSQL() : SQLite3{
        return $this->sql;
    }
}