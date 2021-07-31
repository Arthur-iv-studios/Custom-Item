<?php

namespace arthur;

use pocketmine\event\Listener;
use pocketmine\event\server\DataPacketSendEvent;
use pocketmine\item\Item;
use pocketmine\item\ItemFactory;
use pocketmine\network\mcpe\convert\ItemTranslator;
use pocketmine\network\mcpe\protocol\StartGamePacket;
use pocketmine\plugin\PluginBase;
use ReflectionObject;

class Main extends PluginBase implements Listener {

	public function onEnable() : void{
		$this->getServer()->getPluginManager()->registerEvents($this, $this);
		$this->saveResource("config.json");

        ItemFactory::registerItem(new Item(CustomItems::<Item But In CAPS>, 0, "<item For The en_US.lang, Only First letter Is In CAPS>"));
        CustomItems::init($this);

	//"Injecting", lol
        $instance = ItemTranslator::getInstance();
        $ref = new ReflectionObject($instance);
        $r1 = $ref->getProperty("simpleCoreToNetMapping");
        $r2 = $ref->getProperty("simpleNetToCoreMapping");
        $r1->setAccessible(true);
        $r2->setAccessible(true);
        $r1->setValue($instance, CustomItems::$simpleCoreToNetMapping);
        $r2->setValue($instance, CustomItems::$simpleNetToCoreMapping);
	}

    public function onPacketReceve(DataPacketSendEvent $event){
        $packet = $event->getPacket();
        if ($packet instanceof StartGamePacket){
	    //Sending the custom items to the client ?? (Not sure lol)	
            $packet->itemTable = CustomItems::$entries;
        }
    }
}