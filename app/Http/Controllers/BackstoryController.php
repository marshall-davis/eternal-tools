<?php
/**
 * Date: 2018-03-17
 * Time: 00:58
 */

namespace App\Http\Controllers;


use App\Models\BackstoryAdjective;
use App\Models\BackstoryNationality;
use App\Models\BackstorySkill;
use App\Models\BackstoryTrait;
use Illuminate\Http\Response;

/**
 * Class BackstoryController
 *
 * @package App\Http\Controllers
 */
class BackstoryController extends Controller
{
    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        return response()->json([
            'skills' => BackstorySkill::select(['id', 'text'])->get(),
            'adjectives' => BackstoryAdjective::select(['id', 'text'])->get(),
            'nationalities' => BackstoryNationality::select(['id', 'text'])->get(),
            'traits' => BackstoryTrait::select(['id', 'text'])->get(),
        ]);
    }

    public function portion(string $portion)
    {
        $model = 'App\Models\Backstory' . ucfirst($portion);

        if (class_exists($model)) {
            $result = response()->json([
                'options' => call_user_func_array("{$model}::select", [['id', 'text']])->get(),
            ]);
        } else {
            $result = response()->json([], Response::HTTP_NO_CONTENT);
        }

        return $result;
    }
}
