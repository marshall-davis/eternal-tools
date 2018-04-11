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
            'skills' => BackstorySkill::select(['id', 'text'])->get(),
            'adjectives' => BackstoryAdjective::select(['id', 'text'])->get(),
            'nationalities' => BackstoryNationality::select(['id', 'text'])->get(),
            'traits' => BackstoryTrait::select(['id', 'text'])->get(),
        ]);
    }
}
