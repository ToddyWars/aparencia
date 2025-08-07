<?php

namespace source;

use customiesdevs\customies\item\CustomiesItemFactory;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\inventory\CreativeCategory;
use pocketmine\plugin\PluginBase;
use pocketmine\resourcepacks\ZippedResourcePack;
use pocketmine\utils\SingletonTrait;
use ReflectionException;
use source\itens\teste_item;
use Symfony\Component\Filesystem\Path;

class Aparencia extends PluginBase implements Listener
{
    private static array $cabelos = [
        'base',
        'ssj1',
        'ssj2',
        'ssj3',
    ];
    use SingletonTrait;

    /**
     * @throws ReflectionException
     */
    protected function onLoad(): void
    {
        $this->saveDefaultConfig();
        $this->saveResource("aparencia.mcpack");
        $rpManager = $this->getServer()->getResourcePackManager();
        $rpManager->setResourceStack(array_merge($rpManager->getResourceStack(), [new ZippedResourcePack(Path::join($this->getDataFolder(), "aparencia.mcpack"))]));
        (new \ReflectionProperty($rpManager, "serverForceResources"))->setValue($rpManager, true);
    }

    protected function onEnable(): void
    {
        self::setInstance($this);
        CustomiesItemFactory::getInstance()->registerItem(teste_item::class, "toddy:item", "cannot_touch", CreativeCategory::EQUIPMENT);
        foreach (self::$cabelos as $cabelo){
            CustomiesItemFactory::getInstance()->registerItem(teste_item::class, "toddy:$cabelo", "$cabelo", CreativeCategory::EQUIPMENT);
        }
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
    }

    function onJoin(PlayerJoinEvent $event):void
    {
        $p = $event->getPlayer();
        $inv = $p->getInventory();

        $item = CustomiesItemFactory::getInstance()->get('toddy:item');

        if(!$inv->contains($item)) $inv->addItem($item);
    }
}