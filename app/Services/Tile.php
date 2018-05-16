<?php

namespace App\Services;

use Spatie\Valuestore\Valuestore;
use Illuminate\Support\Collection;

class Tile
{
    public static function createMap(): Collection
    {
        $lineType = collect([
            'name' => 'line',
            'description' => 'een rechte lijn tegel',
        ]);

        $tpointType = collect([
            'name' => 'tpoint',
            'description' => 'een t-punt tegel',
        ]);

        $cornerType = collect([
            'name' => 'corner',
            'description' => 'een hoek tegel',
        ]);

        $objects = Valuestore::make(resource_path('data/objects.json'));

        $objects = collect($objects->all())->shuffle();

        $types = collect([])
            ->pad(12, collect($lineType))
            ->pad(12 + 18, collect($tpointType))
            ->pad(12 + 18 + 16, collect($cornerType))
            ->toArray();

        for ($i = 0, $typeCount = count($types); $i < $typeCount; ++$i) {
            if ($objects->isNotEmpty() && ($types[$i]['name'] === 'tpoint' || $types[$i]['name'] === 'corner')) {
                array_push($types[$i], $objects->pop());
            }
        }

        $types = collect($types)->shuffle();

        $tiles = [];

        for ($y = 0; $y < 7; ++$y) {
            for ($x = 0; $x < 7; ++$x) {
                if (($y === 0 || $y === 6) && ($x === 0 || $x === 6)) {
                    $type = $cornerType;
                } else {
                    $type = $types->pop();
                }

                $object = null;

                if (collect($type)->has(0)) {
                    $object = collect($type)->get(0);

                    collect($type)->forget(0);
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
                    'object' => $object,
                    'type' => $type,
                    'rotation' => $rotation,
                ];
            }
        }

        return collect($tiles)->flatten(1);
    }
}