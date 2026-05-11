<?php

namespace App\Constants;

class Roles
{

    const ADMIN = 1;
    const USER = 2;
    const GUEST = 3;

    /**
     * Obtém uma forma legível por humanos de um determinado papel
     *
     * @param mixed $roleId O ID do role
     *
     * @return mixed
     */
    public static function man($roleId = 0)
    {
        $map = [
            [ 'id' => self::ADMIN, 'name' => 'Admin' ],
            [ 'id' => self::USER, 'name' => 'User' ],
            [ 'id' => self::GUEST, 'name' => 'Guest' ],
        ];

        if ($roleId == 0) {
            return $map;
        }

        if (!in_array($roleId, array_keys($map))) {
            return $roleId;
        }

        $selected = array_filter($map, function ($item) use ($roleId) {
            return $item['id'] == $roleId;
        });
        
        return array_shift($selected);
    }
}
