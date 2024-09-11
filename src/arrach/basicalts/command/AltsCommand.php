<?php

namespace arrach\basicalts\command;

use arrach\basicalts\Loader;
use arrach\basicalts\mgr\AliasMgr;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\Server;
use pocketmine\utils\TextFormat;

class AltsCommand extends Command {

    public function __construct(protected Loader $main)    {
        parent::__construct('alts', 'Get whatever alt can a player have registred in game!.', '/alts <playerName>', ['alias']);
        $this->setPermission('basicalts.command');
        $this->main->getServer()->getCommandMap()->register('BasicAlts', $this);
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args)    {
        if(!$this->testPermission($sender)){
            return;
        }

        if(count($args) < 1 || empty($args[0])) {
            $sender->sendMessage(TextFormat::RED . 'Provide a valid player.');
            return;
        }

        $target = Server::getInstance()->getPlayerByPrefix($args[0]);

        if($target === null) {
            $sender->sendMessage(TextFormat::RED . 'Provide a valid player.');
            return;
        }

        $cid = $this->main->getAliasManager()->getAlts(AliasMgr::CID, $target->getPlayerInfo()->getExtraData()['ClientRandomId']);
        $did = $this->main->getAliasManager()->getAlts(AliasMgr::DID, $target->getPlayerInfo()->getExtraData()['DeviceId']);
        $ssid = $this->main->getAliasManager()->getAlts(AliasMgr::SSID, $target->getPlayerInfo()->getExtraData()['SelfSignedId']);


        $message = ("&b---- &6{$target->getName()}'s Alts &b----") . "\n";
        $message .= ("&eCID: &a" . (empty($cid) ? "None" : implode('&f, &a', $cid))) . "\n";
        $message .= ("&eDID: &a" . (empty($did) ? "None" : implode('&f, &a', $did))) . "\n";
        $message .= ("&eSSID: &a" . (empty($ssid) ? "None" : implode('&f, &a', $ssid))) . "\n";
        $message .= ("&b----------------------------");

        $sender->sendMessage(TextFormat::colorize($message));
    }

}