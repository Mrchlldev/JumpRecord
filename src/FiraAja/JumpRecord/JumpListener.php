<?php

namespace FiraAja\JumpRecord;

use FiraAja\JumpRecord\Main;
use Ifera\ScoreHud\event\PlayerTagsUpdateEvent;
use Ifera\ScoreHud\scoreboard\ScoreTag;

use pocketmine\player\Player;
use pocketmine\event\player\PlayerJumpEvent;
use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;

class JumpRecord implements Listener {

  private $plugin;

  public function __construct(Main $plugin){
		$this->plugin = $plugin;
	}
  
  public function onJump(PlayerJumpEvent $event){
      $this->sendUpdate($event->getPlayer());
  }

  private function sendUpdate(Player $player): void{
		(new PlayerTagsUpdateEvent($player, [
			new ScoreTag("jumprecord.jump", $this->plugin->getPlayerJump($player))
    ]))->call();
	}
}
