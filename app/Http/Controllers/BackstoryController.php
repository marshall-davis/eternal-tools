<?php
/**
 * Date: 2018-03-17
 * Time: 00:58
 */

namespace App\Http\Controllers;


use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

/**
 * Class BackstoryController
 *
 * @package App\Http\Controllers
 */
class BackstoryController extends Controller
{
    /**
     * @param string|null $portion
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(string $portion = null)
    {
        $status = Response::HTTP_OK;

        if (!is_null($portion)) {
            try {
                $data = $this->portion($portion);
            } catch (\BadMethodCallException $bad_method_call_exception) {
                $data = [];
                $status = Response::HTTP_NO_CONTENT;
            } catch (\Exception $exception) {
                $data = ['error' => $exception->getMessage()];
                $status = Response::HTTP_NO_CONTENT;
            }
        } else {
            $data = [
                'skills'        => $this->portion('skill'),
                'adjectives'    => $this->portion('adjective'),
                'nationalities' => $this->portion('nationality'),
                'traits'        => $this->portion('trait'),
            ];
        }

        return response()->json($data, $status);
    }

    /**
     * @param Request $request
     * @param string  $portion
     * @param int     $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, string $portion, int $id)
    {
        $model = $this->parseModel($portion);
        $status = Response::HTTP_OK;

        try {
            $option = call_user_func_array("{$model}::findOrFail", [$id]);
            $option->text = $request->input('text');
            $option->save();
            $data = $option->toArray();
        } catch (ModelNotFoundException $model_not_found) {
            $status = Response::HTTP_NOT_FOUND;
            $data = ['error' => "No {$portion} found with ID {$id}."];
        } catch (\Exception $exception) {
            $data = ['error' => $exception->getMessage()];
            $status = Response::HTTP_NO_CONTENT;
        }

        return response()->json($data, $status);
    }

    /**
     * @param Request $request
     * @param string  $portion
     *
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function create(Request $request, string $portion)
    {
        $model = $this->parseModel($portion);
        $status = Response::HTTP_OK;

        try {
            $data = call_user_func_array("{$model}::create", [['text' => $request->input('text')]])->toArray();
        } catch (\Exception $exception) {
            $status = Response::HTTP_BAD_REQUEST;
            $data = ['error' => $exception->getMessage()];
        }

        return response($data, $status);
    }

    /**
     * @param string $portion
     *
     * @return string
     */
    private function parseModel(string $portion)
    {
        return 'App\Models\Backstory' . ucfirst($portion);
    }

    /**
     * @param string $portion
     *
     * @return \Illuminate\Support\Collection
     * @throws \BadMethodCallException
     */
    private function portion(string $portion)
    {
        $model = $this->parseModel($portion);

        $data = call_user_func_array("{$model}::select", [['id', 'text']])->get();

        return $data;
    }
}
