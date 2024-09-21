<?php

namespace arrach\basicalts\listener;

use arrach\basicalts\Loader;
use arrach\basicalts\mgr\AliasMgr;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerJoinEvent;

class MainHandler implements Listener {

    public function __construct(protected Loader $main)    {
        $this->main->getServer()->getPluginManager()->registerEvents($this, $this->main);
    }

    public function onJoin(PlayerJoinEvent $event): void    {
        $player = $event->getPlayer();
        $datum = $player->getPlayerInfo()->getExtraData();

        $cid = $datum['ClientRandomId'];
        $did = $datum['DeviceId'];
        $ssid = $datum['SelfSignedId'];

        if($cid !== null && !empty($cid)){
            $this->main->getAliasManager()->save($player, AliasMgr::CID, $cid);
        }

        if($did !== null && !empty($did)){
            $this->main->getAliasManager()->save($player, AliasMgr::DID, $did);
        }

        if($ssid !== null && !empty($ssid)){
            $this->main->getAliasManager()->save($player, AliasMgr::SSID, $ssid);
        }
    }
}