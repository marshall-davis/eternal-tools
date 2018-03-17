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

class BackstoryController extends Controller
{
    public function index()
    {
        return response()->json([
            'skills' => BackstorySkill::select('text')->get(),
            'adjectives' => BackstoryAdjective::select('text')->get(),
            'nationalities' => BackstoryNationality::select('text')->get(),
            'traits' => BackstoryTrait::select('text')->get(),
        ]);
    }
}
