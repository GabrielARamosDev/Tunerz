<?php

namespace App\Base\Constants;

class RoleAbilities
{
    const SEE_MAP = 1;
    const MANAGER_MENU = 2;

    /**
     * Retorna um array com 'name' e 'ability'
     * de cada habilidade.
     * 
     * @param mixed $abilityId O ID da habilidade da role
     * @return mixed
     */
    public static function get($abilityId = 0)
    {
        $map = [
            self::SEE_MAP => [
                'id' => self::SEE_MAP,
                'name' => self::name(self::SEE_MAP),
                'ability' => self::ability(self::SEE_MAP),
                'enabled' => self::enabled(self::SEE_MAP),
            ],
            self::MANAGER_MENU => [
                'id' => self::MANAGER_MENU,
                'name' => self::name(self::MANAGER_MENU),
                'ability' => self::ability(self::MANAGER_MENU),
                'enabled' => self::enabled(self::MANAGER_MENU),
            ],
        ];

        if ($abilityId > 0) {
            if (!in_array($abilityId, array_keys($map))) {
                return $abilityId;
            }

            return $map[$abilityId];
        }
        if (0 == $abilityId) {
            return $map;
        }
    }

    /**
     * Obtém uma forma legível por humanos 
     * do nome da habilidade de um determinado papel
     *
     * @param mixed $abilityId O ID da habilidade da role
     *
     * @return mixed
     */
    public static function name($abilityId = 0)
    {
        $map = [
            self::SEE_MAP => 'Visualizar google maps',
            self::MANAGER_MENU => "Acessar menu de 'gestão'",
        ];

        if ($abilityId > 0) {
            if (!in_array($abilityId, array_keys($map))) {
                return $abilityId;
            }

            return $map[$abilityId];
        }
        if (0 == $abilityId) {
            return $map;
        }
    }

    /**
     * Obtém uma forma legível por humanos 
     * da habilidade de um determinado papel
     *
     * @param mixed $abilityId O ID da habilidade da role
     *
     * @return mixed
     */
    public static function ability($abilityId = 0)
    {
        $map = [
            self::SEE_MAP => 'ability_see_map',
            self::MANAGER_MENU => 'ability_manager_menu',
        ];

        if ($abilityId > 0) {
            if (!in_array($abilityId, array_keys($map))) {
                return $abilityId;
            }

            return $map[$abilityId];
        }
        if (0 == $abilityId) {
            return $map;
        }
    }

    /**
     * Manipula se a 'role_ability' está ativa
     * para uso ou não.
     *
     * @param mixed $abilityId O ID da habilidade da role
     * @return mixed
     */
    public static function enabled($abilityId = 0)
    {
        $map = [
            self::SEE_MAP => true,
            self::MANAGER_MENU => true,
        ];

        if ($abilityId > 0) {
            if (!in_array($abilityId, array_keys($map))) {
                return $abilityId;
            }

            return $map[$abilityId];
        }
        if (0 == $abilityId) {
            return $map;
        }
    }
}
