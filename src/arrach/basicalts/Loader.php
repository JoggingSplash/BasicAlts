<?php

namespace arrach\basicalts;

use arrach\basicalts\command\AltsCommand;
use arrach\basicalts\mgr\AliasMgr;
use arrach\basicalts\listener\MainHandler;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\SingletonTrait;

final class Loader extends PluginBase {
    use SingletonTrait;

    protected AliasMgr $alias_manager;

    protected function onLoad(): void    {
        self::setInstance($this);
    }

    protected function onEnable(): void    {
        $this->alias_manager = new AliasMgr;
        $this->alias_manager->onEnable($this);

        new MainHandler($this);
        new AltsCommand($this);
    }

    protected function onDisable(): void    {
        $this->alias_manager->onDisable();
    }

    public function getAliasManager(): AliasMgr    {
        return $this->alias_manager;
    }

}