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

use pocketmine\Player;
use pocketmine\scheduler\Task;
use pocketmine\utils\TextFormat as TE;

class AntiInteruptTask extends Task {
	
	private $plugin;
	
	public function __construct(Loader $plugin)
	{
		$this->plugin = $plugin;
	}
	
	public function onRun(): void
	{
		foreach ($this->plugin->time as $player => $time) {
			$this->plugin->time[$player] = --$time;
			if ($time <= 0) {
				$p = $this->plugin->getServer()->getPlayerExact($player);
				unset ($this->plugin->time[$player]);
				unset ($this->plugin->targets[$player]);
				$p->sendMessage(TE::BLUE . "Your target was unset");
			}
		}
	}
	
}
