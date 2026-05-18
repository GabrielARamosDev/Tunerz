<?php

namespace App\DTO;

class TransmissionPartDTO
{
    public ?int $id = null;
    public ?int $transmissionId = null;
    public ?string $clutchType = null;
    public ?string $synchroType = null;
    public ?string $materialCase = null;

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
            'transmissionId' => $this->transmissionId,
            'clutchType' => $this->clutchType,
            'synchroType' => $this->synchroType,
            'materialCase' => $this->materialCase,
        ];
    }
}
