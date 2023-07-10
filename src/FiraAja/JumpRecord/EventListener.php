<?php

namespace FiraAja\JumpRecord;

use pocketmine\event\Listener;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\event\player\PlayerJumpEvent;

class EventListener implements Listener {

    public function __construct(JumpRecord $plugin){
        $this->plugin = $plugin;
    }

    /**
     * @param PlayerJoinEvent $event
     * @return void
     */
    public function onJoin(PlayerJoinEvent $event): void {
        $player = $event->getPlayer();
        if(!JumpRecord::getInstance()->getProvider()->isRegistered($player)){
            JumpRecord::getInstance()->getProvider()->register($player);
        }
    }

    /**
     * @param PlayerJumpEvent $event
     * @return void
    **/
    public function onJump(PlayerJumpEvent $event): void {
        $player = $event->getPlayer();
        JumpRecord::getInstance()->getProvider()->addJump($player);
    }
}
