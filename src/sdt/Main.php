<?php
/*
該插件適用於 SDT - Prison(監獄)
*/
namespace sdt;

use pocketmine\plugin\PluginBase;
use pocketmine\level\Level;
use pocketmine\math\Vector3;
use pocketmine\event\Listener;
use pocketmine\inventory\Inventory;
use pocketmine\entity\Entity;
use pocketmine\item\{Item , enchantment\Enchantment , enchantment\EnchantmentInstance};
use pocketmine\utils\{Config, TextFormat as C};
use pocketmine\{Server, Player};
use sdt\jojoe77777\FormAPI\{CustomForm, Form, FormAPI, ModalForm, SimpleForm};
use pocketmine\event\player\{PlayerExhaustEvent, PlayerItemHeldEvent, PlayerKickEvent, PlayerMoveEvent, PlayerLoginEvent, PlayerQuitEvent, PlayerChatEvent, PlayerDeathEvent, PlayerJoinEvent, PlayerInteractEvent, PlayerDropItemEvent};
use pocketmine\command\{Command, CommandSender, ConsoleCommandSender};
use pocketmine\event\server\ServerCommandEvent;
use pocketmine\entity\Effect;
use pocketmine\entity\EffectInstance;
use onebone\economyapi\EconomyAPI;
use pocketmine\network\mcpe\protocol\AddActorPacket;
use pocketmine\network\mcpe\protocol\InventoryTransactionPacket;
use pocketmine\event\entity\{EntityDamageEvent, EntityDamageByEntityEvent};
use pocketmine\event\server\DataPacketReceiveEvent;
use pocketmine\network\mcpe\protocol\LoginPacket;

class Main extends PluginBase implements Listener{

    public function onEnable(){
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
        $this->getLogger()->info("ServerSelect已經載入");
    }

    public function onCommand(CommandSender $sender, Command $cmd, string $label, array $args) : bool
    {
        switch ($cmd->getName()) {
        case "server":
        $this->ServerUI($sender);
        return true;
        }
        return true;
}

    public function ServerUI(Player $player):bool{
        $form = new SimpleForm(function (Player $player, $data){
        $result = $data;
        if ($result == null) {
        }
            switch ($result) {
            case 0:
            break;
            
            case 1:
            $pk = new \pocketmine\network\mcpe\protocol\TransferPacket;
            $pk->address = "sur.sdtlist.top";
            $pk->port = "19133";
            $player->dataPacket($pk);
            $this->getServer()->broadcastMessage("§6[§5跨服傳送§6] >>> §a{$player->getName()}傳送到SEXD生存服");
            $this->getLogger()->info("§a{$player->getName()}傳送到SEXD生存服");
            break;

            case 2:
            $pk = new \pocketmine\network\mcpe\protocol\TransferPacket;
            $pk->address = "sb.sdtlist.top";
            $pk->port = "19134";
            $player->dataPacket($pk);
            $this->getServer()->broadcastMessage("§6[§5跨服傳送§6] >>> §a{$player->getName()}傳送到SEXD空島服");
            $this->getLogger()->info("§a{$player->getName()}傳送到SEXD空島服");
            break;

            case 3:
            $player->sendMessage("§c當前尚未推出小遊戲服~");
            break;

        }
        });
        $form->setTitle("§6> §d跨服傳送 §6<");
        $form->setContent("§6點擊以下的按鈕即可傳送");
        $form->addButton("§4關閉");
        $form->addButton("§l§6SEXD - 生存服");
        $form->addButton("§l§6SEXD - 空島服");	
        $form->addButton("§l§dSDT - 小遊戲服");							
        $form->sendToPlayer($player);
        return true;
        }

    public function onDisable(){
        $this->getLogger()->info("ServerSelect已經卸載");
        }
    }
