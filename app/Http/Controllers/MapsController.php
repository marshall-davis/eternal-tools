<?php
/**
 * Date: 2018-03-19
 * Time: 23:33
 */

namespace App\Http\Controllers;


use App\Models\Map;
use Illuminate\Http\Request;

class MapsController extends Controller
{
    public function get(Map $map) {
        return response()->json($map);
    }

    public function create(Request $request) {
        /** @var Map $map */
        $map = Map::create([
            'steps' => $request->input('steps')
        ]);

        return response()->json([
            'id' => $map->id,
        ]);
    }

    public function update(Request $request, Map $map)
    {
        $map->steps = $request->input('steps');
        $map->save();

        return response()->json();
    }
}
