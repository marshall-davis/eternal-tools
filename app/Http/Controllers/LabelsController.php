<?php
/**
 * Date: 2018-04-04
 * Time: 21:54
 */

namespace App\Http\Controllers;


use App\Github\Client;

class LabelsController extends Controller
{
    public function index(Client $github)
    {
        return response()->json([
            'labels' => $github->getLabels(),
        ]);
    }
}
