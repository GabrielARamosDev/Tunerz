<?php

namespace App\DTO;

class SuspensionPartDTO
{
    public ?int $id = null;
    public ?int $suspensionId = null;
    public ?string $springType = null;
    public ?string $springMaterial = null;
    public ?string $damperType = null;
    public ?string $damperMaterial = null;
    public ?bool $hasAbs = null;

    public function __construct(array $data = [])
    {
        foreach ($data as $key => $value) {
            if (property_exists($this, $key)) {
                $this->$key = $value;
            }
        }
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'suspensionId' => $this->suspensionId,
            'springType' => $this->springType,
            'springMaterial' => $this->springMaterial,
            'damperType' => $this->damperType,
            'damperMaterial' => $this->damperMaterial,
            'hasAbs' => $this->hasAbs,
        ];
    }
}
