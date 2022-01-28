<?php

declare(strict_types=1);

namespace NhanAZ\AntiFallDamage;

use pocketmine\event\Listener;
use pocketmine\plugin\PluginBase;
use pocketmine\event\entity\EntityDamageEvent;

class Main extends PluginBase implements Listener
{
	protected function onEnable(): void
	{
		$this->getServer()->getPluginManager()->registerEvents($this, $this);
	}

	public function onEntityDamage(EntityDamageEvent $event)
	{
		$getCause = $event->getCause();
		$causeFall = EntityDamageEvent::CAUSE_FALL;
		if ($getCause === $causeFall) {
			$event->cancel();
		}
	}
}
