<?php

namespace App\Constants;

class Workshop
{
    const ENGINE = [
        'architecture' => [
            'inline',
            'v (15º)',
            'v (30º)',
            'v (60º)',
            'flat',
            'flat (boxer)',
            'rotary',
        ], 
        'rotation_direction' => [
            'longitudinal',
            'transverse',
        ]
    ];

    public function get(string $const, string $key) {
        $u_const = strtoupper($const);
        return $this->$u_const[$key];
    }
}
