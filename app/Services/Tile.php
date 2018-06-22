<?php

namespace App\Services;

use Illuminate\Support\Collection;
use Spatie\Valuestore\Valuestore;

class Tile
{
    public static function createMap(): Collection
    {
        $objects = Valuestore::make(resource_path('data/objects.json'));

        $objects = collect($objects->all())->shuffle();

        $types = collect([])
            ->pad(12, collect(['type' => 'line']))
            ->pad(12 + 18, collect(['type' => 'tpoint']))
            ->pad(12 + 18 + 16, collect(['type' => 'corner']))
            ->toArray();

        for ($i = 0, $typeCount = count($types); $i < $typeCount; ++$i) {
            if ($objects->isNotEmpty() && ($types[$i]['type'] === 'tpoint' || $types[$i]['type'] === 'corner')) {
                array_push($types[$i], $objects->pop());
            }
        }

        $types = collect($types)->shuffle();

        $tiles = [];

        for ($y = 0; $y < 7; ++$y) {
            for ($x = 0; $x < 7; ++$x) {
                if (($y === 0 || $y === 6) && ($x === 0 || $x === 6)) {
                    $type = collect(['type' => 'corner']);
                } else {
                    $type = collect($types->pop());
                }

                $object = null;

                if ($type->has(0)) {
                    $object = $type->get(0);
                }

                $rotation = collect([0, 90, 180, 270])->random();

                if ($x === 0 && $y === 0) {
                    $rotation = 270;
                }
                if ($x === 0 && $y === 6) {
                    $rotation = 180;
                }
                if ($x === 6 && $y === 0) {
                    $rotation = 0;
                }
                if ($x === 6 && $y === 6) {
                    $rotation = 90;
                }

                $tiles[$x][$y] = [
                    'x' => $x,
                    'y' => $y,
                    'object' => collect($object)->get('name'),
                    'type' => $type->get('type'),
                    'rotation' => $rotation,
                ];
            }
        }

        $extraTile = collect($types->pop());

        $object = null;

        if ($extraTile->has(0)) {
            $object = $extraTile->get(0);
        }

        return collect($tiles)->flatten(1)->push(collect([
            'x' => -1,
            'y' => -1,
            'object' => collect($object)->get('name'),
            'type' => $extraTile->get('type'),
            'rotation' => 0,
        ]));
    }
}
