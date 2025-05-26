<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;

class globalCRUDController extends Controller
{

    public function save($payload, $tableName, $Oid = null)
    {
        $modelClass = "\\App\\Models\\" . $tableName;
        if (class_exists($modelClass)) {
            if ($Oid) $data = $modelClass::where('Oid', $Oid)->first();
            else $data = new $modelClass;
            foreach ($payload as $key => $req) $data->$key = $req;
            if (!$Oid) $data->Oid = (string) Str::uuid();
            $data->save();
            return $data;
        } else throw new \Exception("Model doesn't exist.");
    }
}
