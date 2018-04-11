<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use Illuminate\Support\Facades\Route;

Route::get('/{view?}', function (\Illuminate\Http\Request $request, $view = 'welcome') {
    return view('layout')->with([
        'view'    => $view,
        'routeId' => $request->input('map'),
    ]);
})->middleware('password');

Route::post('/login', function (\Illuminate\Http\Request $request) {
    if (\Illuminate\Support\Facades\App::make('App\PasswordUser')->getAuthPassword() === $request->input('password')) {
        $response = response()->json([
            'loggedIn'   => true,
            'redirectTo' => session()->get('redirectTo'),
        ], \Illuminate\Http\Response::HTTP_ACCEPTED);
        session()->forget('redirectTo');
        session()->put('authenticated', true);
    } else {
        $response = response()->json([
            'loggedIn' => false,
        ], \Illuminate\Http\Response::HTTP_UNAUTHORIZED);
    }

    return $response;
});
