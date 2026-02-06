<?php

namespace App\Base\Constants;

class Roles
{
    const ADMIN = 1;

    const WP_API = 2;

    const TEACHER = 3;

    const SCHOOL_MANAGER = 4;

    const STATE_AGENT = 5;

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
            self::ADMIN => 'Administrador',
            self::WP_API => 'API do Wordpress',
            self::TEACHER => 'Professor',
            self::SCHOOL_MANAGER => 'Coordenador de Escola',
            self::STATE_AGENT => 'Secretário de Educação',
        ];

        if ($roleId > 0) {
            if (!in_array($roleId, array_keys($map))) {
                return $roleId;
            }

            return $map[$roleId];
        }
        if (0 == $roleId) {
            return $map;
        }
    }
}
