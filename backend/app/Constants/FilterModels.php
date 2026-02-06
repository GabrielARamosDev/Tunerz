<?php

namespace App\Base\Constants;

use App\Models\v1\City;
use App\Models\v1\Classroom;
use App\Models\v1\Country;
use App\Models\v1\Game;
use App\Models\v1\League;
use App\Models\v1\School;
use App\Models\v1\Season;
use App\Models\v1\State;
use App\Models\v1\SubComponent;

class FilterModels
{
    const COUNTRY = 1;

    const STATE = 2;

    const CITY = 3;

    const SCHOOL = 4;

    const CLASSROOM = 5;

    const SEASON = 6;

    const LEAGUE = 7;

    const GAME = 8;

    const SUB_COMPONENT = 9;

    /**
     * @param mixed $filterId O ID do role
     *
     * @return mixed
     */
    public static function man($filterId = 0)
    {
        $map = [
            self::COUNTRY => Country::getInstance(),
            self::STATE => State::getInstance(),
            self::CITY => City::getInstance(),
            self::SCHOOL => School::getInstance(),
            self::CLASSROOM => Classroom::getInstance(),

            self::SEASON => Season::getInstance(),
            self::LEAGUE => League::getInstance(),
            self::GAME => Game::getInstance(),
            self::SUB_COMPONENT => SubComponent::getInstance(),
        ];

        if ($filterId > 0) {
            if (!in_array($filterId, array_keys($map))) {
                return $filterId;
            }

            return $map[$filterId];
        }
        if (0 == $filterId) {
            return $map;
        }
    }

    /**
     * Obtém os dados 'hasMany' para determinado filtro,
     * utilizando o ID da opção selecionada.
     *
     * @param [type] $type
     * @param [type] $model
     * @param [type] $options (additional parameters)
     * @param mixed $id
     *
     * @return array
     */
    public static function hmd($type, $id, $options = [])
    {
        switch ($type) {
            // locations
            case 'country':
                return Country::find($id)->states()->get();

            case 'state':
                return State::find($id)->cities()->get();

            case 'city':
                return City::find($id)->schools()->get();

            case 'school':
                return School::find($id)->classrooms()->get();

                // phases
            case 'league':
                return Game::whereHas('teachingPlans', function ($query) use ($options) {
                    if (!empty($options['applied']['season'])) {
                        $query->where('season_id', $options['applied']['season']['id']);
                    }
                    if (!empty($options['applied']['league'])) {
                        $query->where('league_id', $options['applied']['league']['id']);
                    }
                })->get();

            case 'game':
                return SubComponent::whereHas('knowledges.skills.teachingPlans', function ($query) use ($options) {
                    if (!empty($options['applied']['season'])) {
                        $query->where('season_id', $options['applied']['season']['id']);
                    }
                    if (!empty($options['applied']['league'])) {
                        $query->where('league_id', $options['applied']['league']['id']);
                    }
                    $query->where('game_id', $options['applied']['game']['id']);
                })->get();
        }
    }
}
