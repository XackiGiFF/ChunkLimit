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
    public $chunks;
    public $config;


    public function onEnable() : void {
        $this->saveResource("config.yml");
        $this->config = new Config($this->getDataFolder() . "config.yml", Config::YAML);
        $this->chunks = (int) $this->config->get('chunks');
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
    }

    public function onReceive(DataPacketReceiveEvent $event) : void {
        $chunks = $this->chunks ?? 16;
        if (($pk = $event->getPacket()) instanceof RequestChunkRadiusPacket )
            if($pk->radius > $chunks)
                $pk->radius = $this->chunks;
    }

}
