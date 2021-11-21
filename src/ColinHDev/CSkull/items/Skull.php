<?php

namespace ColinHDev\CSkull\items;

use ColinHDev\CSkull\blocks\Skull as SkullBlock;
use pocketmine\block\Block;
use pocketmine\block\BlockFactory;
use pocketmine\block\BlockLegacyIds;
use pocketmine\block\utils\SkullType;
use pocketmine\item\ItemFactory;
use pocketmine\item\ItemIds;
use pocketmine\item\Skull as PMMPSkull;
use pocketmine\player\Player;

class Skull extends PMMPSkull {

    public function getBlock(?int $clickedFace = null) : Block {
        /** @var SkullBlock $block */
        $block = BlockFactory::getInstance()->get(BlockLegacyIds::SKULL_BLOCK, 0);
        return $block->setSkullType($this->getSkullType());
    }

    public static function fromPlayer(Player $player) : Skull {
        return static::fromData($player->getUniqueId()->toString(), $player->getName(), base64_encode($player->getSkin()->getSkinData()));
    }

    public static function fromData(string $playerUUID, string $playerName, string $skinData) : Skull {
        /** @var Skull $item */
        $item = ItemFactory::getInstance()->get(ItemIds::SKULL, SkullType::PLAYER()->getMagicNumber());
        $nbt = $item->getNamedTag();
        $nbt->setString("PlayerUUID", $playerUUID);
        $nbt->setString("PlayerName", $playerName);
        $nbt->setByteArray("SkinData", $skinData);
        $item->setNamedTag($nbt);
        return $item;
    }
}