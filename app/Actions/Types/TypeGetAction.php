<?php

namespace App\Actions\Types;

use App\Models\Type;
use Illuminate\Database\Eloquent\Collection;

class TypeGetAction
{
    /**
     * @throws \Exception
     */
    public static function getType() : Collection
    {
        $types = Type::whereIn('id', Type::RETURN_TYPES)->get();
        if($types->isEmpty())
        {
            throw new \Exception('types not found');
        }

        return $types;
    }

    public static function getAllType() : Collection
    {
        $types = Type::all();
        if($types->isEmpty())
        {
            throw new \Exception('types not found');
        }

        return $types;
    }
}
