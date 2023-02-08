<?php

namespace FiraAja\JumpRecord;

use FiraAja\JumpRecord\provider\MysqlProvider;
use FiraAja\JumpRecord\provider\Provider;
use FiraAja\JumpRecord\provider\YamlProvider;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\SingletonTrait;

class JumpRecord extends PluginBase {
    use SingletonTrait;

    /** @var Provider $provider */
    private Provider $provider;

    public function onEnable(): void {
        self::setInstance($this);
        $this->saveDefaultConfig();
    }

    /**
     * @return void
     */
    private function initProvider(): void {
        match (strtolower($this->getConfig()->get("provider"))){
            "yaml" => $this->provider = new YamlProvider($this),
            "mysql" => $this->provider = new MysqlProvider($this)
        };
        $this->getLogger()->notice("Database was updated to: " . $this->provider->getName());
    }

    /**
     * @return Provider
     */
    public function getProvider(): Provider {
        return $this->provider;
    }
}