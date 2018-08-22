<?php

#╔═══╗╔═╗╔═╗╔═══╗╔═╗╔═╗╔═══╗╔═══╗╔═══╗╔════╗╔═══╗
#║╔═╗║║║╚╝║║║╔══╝╚╗╚╝╔╝║╔═╗║║╔══╝║╔═╗║║╔╗╔╗║║╔═╗║
#║╚═╝║║╔╗╔╗║║╚══╗─╚╗╔╝─║╚═╝║║╚══╗║╚═╝║╚╝║║╚╝║╚══╗
#║╔══╝║║║║║║║╔══╝─╔╝╚╗─║╔══╝║╔══╝║╔╗╔╝──║║──╚══╗║
#║║───║║║║║║║╚══╗╔╝╔╗╚╗║║───║╚══╗║║║╚╗──║║──║╚═╝║
#╚╝───╚╝╚╝╚╝╚═══╝╚═╝╚═╝╚╝───╚═══╝╚╝╚═╝──╚╝──╚═══╝

namespace MeCommand;

use pocketmine\Player;
use pocketmine\plugin\PluginBase;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\utils\Config;
use pocketmine\utils\TextFormat as SH;

class MeCommand extends PluginBase{
    public function onEnable()
    {
    	@mkdir($this->getDataFolder());
    	$this->saveResource("Config.yml");
        $this->Banner();
        $this->getLogger()->info(SH::GREEN . "Server-Helper was activated!");
    }

    public function onDisable(){
    	$this->saveResource("Config.yml");
        $this->Banner();
        $this->getLogger()->info("Server-Helper was stopped!");
    }

    private function Banner()
    {
        $banner = strval(
            "\n".
            "╔═══╗╔═╗╔═╗╔═══╗╔═╗╔═╗╔═══╗╔═══╗╔═══╗╔════╗╔═══╗\n".
            "║╔═╗║║║╚╝║║║╔══╝╚╗╚╝╔╝║╔═╗║║╔══╝║╔═╗║║╔╗╔╗║║╔═╗║\n".
            "║╚═╝║║╔╗╔╗║║╚══╗─╚╗╔╝─║╚═╝║║╚══╗║╚═╝║╚╝║║╚╝║╚══╗\n".
            "║╔══╝║║║║║║║╔══╝─╔╝╚╗─║╔══╝║╔══╝║╔╗╔╝──║║──╚══╗║\n".
            "║║───║║║║║║║╚══╗╔╝╔╗╚╗║║───║╚══╗║║║╚╗──║║──║╚═╝║\n".
            "╚╝───╚╝╚╝╚╝╚═══╝╚═╝╚═╝╚╝───╚═══╝╚╝╚═╝──╚╝──╚═══╝"
        );
        $this->getLogger()->info($banner);
    }

    public function onCommand(CommandSender $sender, Command $command, string $label, array $args): bool
    {
    	$this->myConfig = new Config($this->getDataFolder() . "Config.yml", Config::YAML);
        switch ($command->getName()){
            case "me":
                if($sender instanceof Player){
                    if($sender->hasPermission("mecommand.command.me")){
                        if(!empty($args[0])){
                        	$sender->getServer()->broadcastMessage($this->getConfig()->get("MePrefix") . SH::RESET . " ". $this->getConfig()->get("ColourName") . $sender->getName() . SH::RESET . " " . $this->getConfig()->get("ColourMSG") . implode(" ", $args));
                        }else{
                            $sender->sendMessage("Please specify a Message!");
                        }
                    }else{
                        $sender->sendMessage(SH::RED . "You dont have the Permission to use this Command!");
                    }
                }else{
                    $sender->sendMessage("This Command is Only for Players!");
                }
                return true;
        }
        return false;
    }
}