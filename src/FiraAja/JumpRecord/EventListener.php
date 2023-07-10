<?php

namespace FiraAja\JumpRecord;

use pocketmine\event\Listener;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\event\player\PlayerJumpEvent;
use Ifera\ScoreHud\event\TagsResolveEvent;
use pocketmine\player\Player;

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
        $this->sendUpdate($player);
    }

    /**
    * Send Update Jump
    **/
    private function sendUpdate(Player $player) : void {
        (new PlayerTagsUpdateEvent($player, [
            new ScoreTag("jumprecord.jump", $this->getPlayerJump($player))
        ]))->call();
    }

    /**
    * TagResolveEvent
    **/
    public function onTagResolve(TagResolveEvent $event){
        $player = $event->getPlayer();
        $tag = $event->getTag();
        $tags = explode('.', $tag->getName(), 2);
        $value = "";

        if($tags[0] !== 'jumprecord' || count($tags) < 2){
            return;
        }

        switch($tags[1]){
            case "jump":
              $value = $this->getPlayerJump($player);
            break;
        }
        $tag->setValue($value);
    }

    /**
    * Getting Player Jump
    **/
    public function getPlayerJump(Player $p){
        $jump = JumpRecord::getInstance()->getProvider()->getJump($player);
        return $jump ?? "No Jump";
    }
}
