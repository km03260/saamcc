<?php

namespace App\BuilderQuery;

use DataTables;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

/**
 * Trait Builder
 */
trait ModelBuilder
{


    /**
     * Build a JSON response for JQeuryDataTables using Yajra DataTables
     *
     * @param \Illuminate\Http\Request $request
     * @param \Illuminate\Database\Eloquent\Model $model
     * @return
     */
    protected function _dataTable(Request $request, $model, string $scope = 'Grid')
    {
        $data = $model::{$scope}($request->all());
        return DataTables::eloquent($data)->make();
    }

    /**
     * Clean request
     *
     * @param \Illuminate\Http\Request $request
     * @param Array $allows
     * @return Array
     */
    private function cleanRequest(Request $request, array $allows)
    {
        return array_intersect_key($request->all(), $allows);
    }

    /**
     * Validate Model request
     *
     * @param \Illuminate\Http\Request $request
     * @return String
     */
    private function ValidateRequest(Request $request, $model, String $ByOne = null)
    {
        $valid = [];
        $fieldsValid = ($ByOne == null) ? $valid = $model->RULES : $valid[$ByOne] = $model->RULES[$ByOne];
        $validator = Validator::make(
            $request->all(),
            $valid,
            (method_exists($model, 'messages')) ? $model->messages() : []
        );
        if ($validator->fails()) {
            return response()->json(
                [
                    'error' => 'Fail to store ' . class_basename($model),
                    'errors' => $validator->errors()->messages(),
                ]
            );
        } else {
            return "Validated";
        }
    }

    /**
     * return version data
     *
     * @return string
     */
    protected function vdata(): string
    {
        return Str::random(48);
    }

    /**
     * Get header component
     * 
     * @param Request $request
     * @param array $header
     * @return \Illuminate\Http\JsonResponse
     */
    public function GET_HEADER(Request $request, array $header)
    {
        $_data_head = array_merge(["columns" => $header], $request->all());

        return response()->json([
            "content" => view("components.includes.data-header")
                ->with($_data_head)
                ->render(),
            "js_columns" => $this->js_columns($header),
        ], 200);
    }


    /**
     * js columns
     *
     * @return array
     */
    protected function js_columns($columns)
    {
        $temp = [];
        foreach ($columns as $s) {
            $temp[] = [
                $s['name'] . "|"
                    . $s['data'] . "|"
                    . $s['column'] . "|"
                    . $s['render'] . "|"
                    . $s['className'] . "|"
                    . (key_exists('width', $s) ? $s['width'] : `auto`) . '|'
                    . (key_exists('edit', $s) ? $s['edit'] : "") . '|'
                    . (key_exists('visible', $s) ? $s['visible'] : true),
            ];
        }
        return $temp;
    }


    /**
     * Upload docteur Image
     *
     * @param UploadedFile $file
     * @param String|null $old_file
     * @return string
     */
    protected function _IMAGE_STORAGE(UploadedFile $file, String $path, String $old_file = null)
    {
        $extension = $file->getClientOriginalExtension();
        $new_file_name = Str::limit(Str::beforeLast($file->getClientOriginalName(), '.'), 25, '') . '__' . Str::random(47) . '.' . $extension;
        Storage::disk('datas')->putFileAs($path, $file, $new_file_name);
        if ($old_file) {
            Storage::disk('datas')->delete($old_file);
        }
        return "/$path/$new_file_name";
    }
}
