<?php

namespace FiraAja\JumpRecord\provider;

use pocketmine\player\Player;

abstract class Provider {

    /**
     * @return string
     */
    abstract public function getName(): string;

    /**
     * @return void
     */
    abstract public function init(): void;

    /**
     * @param Player $player
     * @return void
     */
    abstract public function addJump(Player $player): void;

    /**
     * @param Player $player
     * @return int
     */
    abstract public function getJump(Player $player): int;

    /**
     * @return array
     */
    abstract public function getAllJumps(): array;

    /**
     * @param Player $player
     * @return bool
     */
    abstract public function isRegistered(Player $player): bool;

    /**
     * @param Player $player
     * @return void
     */
    abstract public function register(Player $player): void;
}