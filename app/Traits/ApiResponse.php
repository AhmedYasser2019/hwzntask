<?php

namespace App\Traits;

trait ApiResponse
{

    public function apiResponse(string $message = '', int $code = 200, $data = [])
    {
        $array = [
            'status'  => $code,
            'message' => $message,
        ];
        if (in_array($code, $this->success())) {
            $array['status'] = 1;
            $array = array_merge($array, ['data' => $data]);
        } else {
            $array['status'] = 0;

            $array = array_merge($array, ['data' => $data]);
        }
        return response($array, $code);
    }

    public function success()
    {
        return [
            200, 201, 202
        ];
    }

    public function validation($validator)
    {
        return $this->apiResponse(__('invalid data'), 0, $validator->errors());
    }
    public function validation_exception($validator)
    {
        return $this->apiResponse(__('invalid data'), 0, $validator);
    }
    function api_response($data = null, $message = "", $status = "success", $status_code = 200)
    {

        $response = [
            'status'  => $status ? 1 : 0,
            'message' => $message,
            'data'    => $data,
        ];
        try {
            if ($data) {
                $pagination = $this->api_model_set_pagenation($data);
                if ($pagination) {
                    $response['pagination'] = $pagination;
                } else {
                    foreach ($data as $key => $row) {
                        if (is_string($key)) {
                            $pagination = $this->api_model_set_pagenation($row);
                            if ($pagination) {
                                $response['pagination'] = $pagination;
                                break;
                            }
                        }
                    }
                }
            }
        } catch
        (\Throwable $th) {
            //throw $th;
        }
        return response()->json($response, $status_code);
    }

    function api_model_set_pagenation($model)
    {
        if (is_object($model) && count((array)$model)) {
            try {
                $pagination['total'] = $model->total();
                $pagination['lastPage'] = $model->lastPage();
                $pagination['perPage'] = $model->perPage();
                $pagination['currentPage'] = $model->currentPage();
                return $pagination;
            } catch (\Exception$e) {
            }
        }
        return null;
    }

}
