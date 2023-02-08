<?php

namespace FiraAja\JumpRecord\provider;

use FiraAja\JumpRecord\JumpRecord;
use mysqli;
use pocketmine\player\Player;

class MysqlProvider extends Provider {

    /** @var JumpRecord $plugin */
    private JumpRecord $plugin;
    /** @var mysqli $connection */
    private mysqli $connection;

    public function __construct(JumpRecord $plugin){
        $this->plugin = $plugin;
        $this->init();
    }

    /**
     * @return string
     */
    public function getName(): string {
        return "MySQL";
    }

    /**
     * @return void
     */
    public function init(): void {
        $data = $this->plugin->getConfig()->getAll()["mysql-settings"];
        $this->connection = new mysqli($data["host"], $data["user"], $data["password"], $data["database"]);
        $this->connection->query("CREATE TABLE IF NOT EXISTS jumprecord (player VARCHAR(255) NOT NULL, jumps INT(11) NOT NULL);");
    }

    /**
     * @param Player $player
     * @return bool
     */
    public function isRegistered(Player $player): bool {
        $playerName = $player->getName();
        $result = $this->connection->query("SELECT * FROM jumprecord WHERE player='$playerName'");
        if($result->num_rows > 0){
            return true;
        }
        return false;
    }

    /**
     * @param Player $player
     * @return void
     */
    public function register(Player $player): void {
        $playerName = $player->getName();
        $this->connection->query("INSERT INTO jumprecord VALUES ('$playerName', '0');");
    }

    /**
     * @param Player $player
     * @return void
     */
    public function addJump(Player $player): void {
        $playerName = $player->getName();
        $this->connection->query("UPDATE jumprecord SET jumps = jumps + 1 WHERE player='$playerName'");
    }

    /**
     * @param Player $player
     * @return int
     */
    public function getJump(Player $player): int {
        $playerName = $player->getName();
        $result = $this->connection->query("SELECT * FROM jumprecord WHERE player='$playerName'")->fetch_assoc();
        return $result["jumps"] ?? 0;
    }

    /**
     * @return array
     */
    public function getAllJumps(): array {
        return $this->connection->query("SELECT * FROM jumprecord")->fetch_assoc();
    }
}