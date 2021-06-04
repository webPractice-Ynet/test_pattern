<?php
namespace App\Domain\CardFactory\Components;
use App\Domain\CardFactory\Factory;

//Factory Method : Concrete Creator
class IDCardFactory extends Factory {
    private $card_table = [];
    private $serial = 100;

    public function createProduct ($owner) {
        return new IDCard($owner, $this->serial++);
    }
    
    public function registerProduct ($card) {
        $this->setCardTable($card);
    }

    private function setCardTable ($card) {
        $this->card_table[$card->getNumber()] = $card->getOwner();
    }

    public function getCardTable() {
        return $this->card_table;
    }
}