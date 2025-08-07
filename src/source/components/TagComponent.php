<?php

namespace source\components;

use customiesdevs\customies\item\component\ItemComponent;

class TagComponent implements ItemComponent {

    private array $tags;

    public function __construct(array $tags = []) {
        $this->tags = array_merge($tags, ['first_person']);
    }

    public function getName(): string {
        return "minecraft:tags";
    }

    public function getValue(): array {
        return ['tags' => $this->tags];
    }

    public function isProperty(): bool {
        return false;
    }
}