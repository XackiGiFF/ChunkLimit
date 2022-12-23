<?php

declare(strict_types=1);

namespace XackiGiFF8388\ChunkLimit;

use pocketmine\event\Listener;
use pocketmine\event\server\DataPacketReceiveEvent;
use pocketmine\network\mcpe\protocol\RequestChunkRadiusPacket;

use pocketmine\plugin\PluginBase;
use pocketmine\Server;
use pocketmine\utils\Config;

class Main extends PluginBase implements Listener{
    private static Main $instance;
    private static $config;


    public static function getInstance() : Main {
		return self::$instance;
	}

	public function onEnable() : void {
        self::$instance = $this;
        self::getInstance()->saveResource("config.yml");
        self::$config = new Config($this->getDataFolder() . "config.yml", Config::YAML);
        self::$settings = $this->getConfig()->getAll();
        self::getInstance()->getServer()->getPluginManager()->registerEvents($this, $this);
    }

    public function onReceive(DataPacketReceiveEvent $event) : void {
        $chunks = (int) self::settings['chunks'] ?? 16;
        if (($pk = $event->getPacket()) instanceof RequestChunkRadiusPacket )
            if($pk->radius > $chunks)
                $pk->radius = (int) self::settings['chunks'];
    }

}
