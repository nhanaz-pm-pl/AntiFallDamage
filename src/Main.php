<?php

declare(strict_types=1);

namespace NhanAZ\AntiFallDamage;

use pocketmine\player\Player;
use pocketmine\event\Listener;
use pocketmine\plugin\PluginBase;
use pocketmine\event\entity\EntityDamageEvent;

class Main extends PluginBase implements Listener {

	protected function onEnable(): void {
		$this->getServer()->getPluginManager()->registerEvents($this, $this);
		$this->saveDefaultConfig();
	}

	private function cancelCauseFallDamage(EntityDamageEvent $event): void {
		$cause = $event->getCause();
		$entity = $event->getEntity();
		if ($cause === EntityDamageEvent::CAUSE_FALL) {
			if ($entity instanceof Player) {
				$event->cancel();
			}
		}
	}

	public function onEntityDamage(EntityDamageEvent $event) {
		$entity = $event->getEntity();
		$worldName = $entity->getWorld()->getDisplayName();
		$worlds = $this->getConfig()->get("Worlds", []);
		switch ($this->getConfig()->get("Mode", "all")) {
			case "all":
				$this->cancelCauseFallDamage($event);
				break;
			case "whitelist":
				if (in_array($worldName, $worlds)) {
					$this->cancelCauseFallDamage($event);
				}
				break;
			case "blacklist":
				if (!in_array($worldName, $worlds)) {
					$this->cancelCauseFallDamage($event);
				}
				break;
		}
	}
}
