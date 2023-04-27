<?php

/**
 *   _   _         _    _     ___  ___ _____ 
 *  | \ | |       | |  | |    |  \/  |/  __ \
 *  |  \| | _   _ | |_ | |__  | .  . || /  \/
 *  | . ` || | | || __|| '_ \ | |\/| || |    
 *  | |\  || |_| || |_ | | | || |  | || \__/\
 *  \_| \_/ \__,_| \__||_| |_|\_|  |_/ \____/
 *  
 * Copyright 2023 NuthMC
 * 
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *        http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.                                        
 */
 
declare(strict_types=1);
 
namespace nuthmc\antiinterupt;

use pocketmine\player\Player;
use pocketmine\event\Listener;
use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\event\entity\EntityDamageByEntityEvent;
use pocketmine\utils\TextFormat as TE;

class EventListener implements Listener {
	
	private $plugin;
	
	public function __construct(Loader $plugin) 
	{
		$this->plugin = $plugin;
	}
	
	public function onDamage(EntityDamageEvent $e) 
	{
		if ($e instanceof EntityDamageByEntityEvent) {
			$player = $e->getEntity();
			$damager = $e->getDamager();
			$targets = $this->plugin->targets;
			if (!$player instanceof Player && !$damager instanceof Player) {
				return;
			}
			if (!in_array($damager->getWorld()->getFolderName(), $this->plugin->getConfig()->get("worlds"))) {
				return;
			}
			if (in_array($damager->getName(), $targets)) {
				if ($targets[$damager->getName()] !== $player->getName()) {
					$damager->sendMessage(TE::RED . "Your target is {$targets[$damager->getName()]}");
					$e->cancel();
					return;
				}
			}
			if (in_array($player->getName(), $targets)) {
				if ($targets[$player->getName()] !== $damager->getName()) {
					$damager->sendMessage(TE::RED . "You cant interupt {$player->getName()}");
					$e->cancel();
					return;
				}
			}
			if (!in_array($damager->getName(), $targets) && !in_array($player->getName(), $targets)) {
				$this->plugin->targets[$damager->getName()] = $player->getName();
				$this->plugin->targets[$player->getName()] = $damager->getName();
				$this->plugin->time[$damager->getName()] = 8;
				$this->plugin->time[$player->getName()] = 8;
				$player->sendMessage(TE::GREEN . "Your target was set to {$damager->getName()}");
				$damager->sendMessage(TE::GREEN . "Your target was set to {$player->getName()}");
				return;
			}
			$this->plugin->time[$player->getName()] = 8;
			$this->plugin->time[$damager->getName()] = 8;
		}
	}
	
}
