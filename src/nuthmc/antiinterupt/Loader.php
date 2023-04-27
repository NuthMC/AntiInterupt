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
use pocketmine\Server;
use pocketmine\plugin\PluginBase;

class Loader extends PluginBase {
	
	public $targets = [];
	
	public $time = [];
	
	public function onEnable() : void 
	{
		@mkdir($this->getDataFolder());
		$this->saveDefaultConfig();
		$this->getScheduler()->scheduleRepeatingTask(new AntiInteruptTask($this), 20);
		$this->getServer()->getPluginManager()->registerEvents(new EventListener($this), $this);
	}
}
