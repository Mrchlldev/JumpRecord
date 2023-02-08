<?php

namespace FiraAja\JumpRecord\provider;

use FiraAja\JumpRecord\JumpRecord;
use JsonException;
use pocketmine\player\Player;
use pocketmine\utils\Config;

class YamlProvider extends Provider {

    /** @var JumpRecord $plugin */
    private JumpRecord $plugin;
    /** @var Config $jumps */
    private Config $jumps;

    public function __construct(JumpRecord $plugin){
        $this->plugin = $plugin;
        $this->init();
    }

    /**
     * @return void
     */
    public function init(): void {
        $this->jumps = new Config($this->plugin->getDataFolder() . "jumps.yml", Config::YAML, array());
    }

    /**
     * @return string
     */
    public function getName(): string {
        return "Yaml";
    }

    /**
     * @param Player $player
     * @return bool
     */
    public function isRegistered(Player $player): bool {
        if($this->jumps->exists($player->getName())){
            return true;
        }
        return false;
    }

    /**
     * @param Player $player
     * @return void
     * @throws JsonException
     */
    public function register(Player $player): void {
        $this->jumps->setNested($player->getName() . ".jumps", 0);
        $this->jumps->save();
    }

    /**
     * @param Player $player
     * @return void
     * @throws JsonException
     */
    public function addJump(Player $player): void {
        $this->jumps->setNested($player->getName() . ".jumps", $this->getJump($player) + 1);
        $this->jumps->save();
    }

    /**
     * @param Player $player
     * @return int
     */
    public function getJump(Player $player): int {
        return $this->jumps->get($player->getName()) ?? 0;
    }

    /**
     * @return array
     */
    public function getAllJumps(): array {
        return [];
    }
}