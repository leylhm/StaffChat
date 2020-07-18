<?php
namespace GuilhermePLUGNER\StaffChat;
use pocketmine\plugin\PluginBase as PB;
use pocketmine\event\Listener as LE;
use pocketmine\command\CommandSender;
use pocketmine\command\Command;
use pocketmine\event\player\PlayerChatEvent;
use pocketmine\utils\Config;
use pocketmine\Server;
class Main extends PB implements LE{
private $chat=[];
public function onEnable(){
Server::getInstance()->getPluginManager()->registerEvents($this,$this);
}
public function onCommand(CommandSender $sender,Command $command,$label,array $args){
switch($command->getName()){
case "staffchat":
if($sender->hasPermission("sc.chat")){
if(!isset($args[0])){
$sender->sendMessage("§8[§6SC§8] §f/sc §6« §fOn §6| §fOff §6»");
return true;
}
switch($args[0]){
case "on":
$this->chat[strtolower($sender->getName())] = $args[0];
$sender->sendMessage("§8[§6SC§8] §fO StaffChat Foi Ativado");
return true;
case "off":
unset($this->chat[strtolower($sender->getName())]);
$sender->sendMessage("§8[§6SC§8] §fO StaffChat Foi Desativado");
return true;
default:
$sender->sendMessage("§8[§6SC§8] §f/sc §6« §fOn §6| §fOff §6»");
}
}
}
}
public function onChat(PlayerChatEvent $event){
$player = $event->getPlayer();
if(isset($this->chat[strtolower($player->getName())])){
foreach(Server::getInstance()->getOnlinePlayers() as $players){
if($players->hasPermission("sc.chat")){
$players->sendMessage("§8[§6SC§8] §f{$player->getDisplayName()}§f: §a{$event->getMessage()}");
$event->setCancelled(true);
}
}
}
}
}