<?php

namespace App\Http\Controllers;

use App\Mail\BookingConfirmationMail;
use App\Mail\SendMail;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class globalCRUDController extends Controller
{

    public function save($payload, $tableName, $Oid = null, $request = null)
    {
        $modelClass = "\\App\\Models\\" . $tableName;
        if (class_exists($modelClass)) {
            if ($Oid) $data = $modelClass::where('Oid', $Oid)->first();
            else $data = new $modelClass;
            foreach ($payload as $key => $req) {
                if (str_contains($key, "Image")) {
                    $image = $request->file($key);
                    $imageName = time() . '_' . $image->getClientOriginalName();
                    $image->move(public_path('images'), $imageName);
                    $url = url('images/' . $imageName);
                    $data->$key = $url;
                } else {
                    $data->$key = $req;
                }
            }
            if (!$Oid) $data->Oid = (string) Str::uuid();
            try {
                $data->save();
            } catch (\Exception $e) {
                dd('Save failed:', $e->getMessage());
            }
            $data->save();
            return $data;
        } else throw new \Exception("Model doesn't exist.");
    }

    public function sendEmail($data, $bladeName, $type)
    {
        try {
            $emailData = [$data];
            Mail::to($emailData[0]['details'][0]['Email'])->send(new SendMail($emailData, $bladeName, "Booking $type from Batam Pesona Wisata"));
        } catch (\Exception $e) {
            return response()->json([
                $e->getMessage()
            ], 500);
        }
    }
}
