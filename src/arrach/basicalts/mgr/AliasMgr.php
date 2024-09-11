<?php

namespace arrach\basicalts\mgr;

use arrach\basicalts\Loader;
use pocketmine\player\Player;
use pocketmine\utils\Config;

final class AliasMgr  {
    public const CID = 'cid';
    public const DID = 'did';
    public const SSID = 'ssid';

    private array $aliases;

    private Config $cidConfig;
    private Config $didConfig;
    private Config $ssidConfig;

    public function __construct(){}

    public function onEnable(): void    {
        if(!is_dir(Loader::getInstance()->getDataFolder() . 'alts')) {
            @mkdir(Loader::getInstance()->getDataFolder() .  'alts');
        }

        $this->cidConfig = new Config(Loader::getInstance()->getDataFolder() . "alts" . DIRECTORY_SEPARATOR . self::CID . ".yml", Config::YAML);
        $this->didConfig = new Config(Loader::getInstance()->getDataFolder() . "alts" . DIRECTORY_SEPARATOR . self::DID . ".yml", Config::YAML);
        $this->ssidConfig = new Config(Loader::getInstance()->getDataFolder() . "alts" . DIRECTORY_SEPARATOR . self::SSID . ".yml", Config::YAML);

        $this->aliases[self::CID] = $this->cidConfig->getAll();
        $this->aliases[self::DID] = $this->didConfig->getAll();
        $this->aliases[self::SSID] = $this->ssidConfig->getAll();
    }

    public function getAlts(string $type, string|int $value) : array{
        return $this->aliases[$type][$value] ?? [];
    }

    public function save(Player $profile, string $type, string|int $value) : void{
        if(!isset($this->aliases[$type][$value])){
            $this->aliases[$type][$value] = [];
        }

        $name = $profile->getName();
        $names = $this->aliases[$type][$value];

        if(in_array($name, $names, true)){
            return;
        }

        $this->aliases[$type][$value][] = $name;
    }

    public function onDisable() : void{
        $this->cidConfig->setAll($this->aliases[self::CID]);
        $this->didConfig->setAll($this->aliases[self::DID]);
        $this->ssidConfig->setAll($this->aliases[self::SSID]);

        try {
            $this->cidConfig->save();
            $this->didConfig->save();
            $this->ssidConfig->save();
        } catch (\JsonException){
            //A
        }
    }
}