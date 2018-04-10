<?php
/**
 * Date: 2018-03-19
 * Time: 23:33
 */

namespace App\Http\Controllers;


use App\Models\Map;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class MapsController extends Controller
{
    /**
     * @param string $slug
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function get(string $slug)
    {
        return response()->json(Map::where('slug', $slug)->first());
    }

    /**
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(Request $request)
    {
        /** @var Map $map */
        $map = Map::create([
            'steps' => $request->input('steps'),
            'slug'  => md5($request->input('steps') . Carbon::now()->timestamp),
        ]);

        return response()->json([
            'id' => $map->slug,
        ]);
    }

    /**
     * @param Request $request
     * @param string  $slug
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, string $slug)
    {
        /** @var Map $map */
        $map = Map::where('slug', $slug)->first();

        if ($map) {
            $map->steps = $request->input('steps');
            $map->save();
            $response = response()->json();
        } else {
            $response = response()->json([], Response::HTTP_NOT_FOUND);
        }

        return $response;
    }
}
