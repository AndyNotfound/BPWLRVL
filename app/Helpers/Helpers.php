<?php

use Carbon\Carbon;
use App\Models\Settings;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use App\Models\TravelTransactionDetail;

if (!function_exists('authPayment')) {
    function authPayment()
    {
        return base64_encode(Settings::select('SecretKey')->first()->SecretKey . ":");
    }
}

if (!function_exists('paymentProcess')) {
    function paymentProcess($data, $type, $request = null)
    {
        try {
            // $response = Http::withHeaders([
            //         'Authorization' => 'Basic ' . authPayment(),
            //         'api-version' => '2022-07-31',
            //         'Content-Type' => 'application/json',
            //     ])
            //     ->post('https://api.xendit.co/qr_codes', [
            //         'reference_id' => $data->Packages,
            //         'type' => 'DYNAMIC',
            //         "channel_code" => "ID_DANA",
            //         'currency' => 'IDR',
            //         'amount' => $data->PackagesObj ? $data->PackagesObj->Price : 0,
            //         'expires_at' => Carbon::now()->addDay()->toIso8601String(),
            //     ]);

            if (isset($request) && $request->has('Price')) {
                $amount = $request->Price;
            } else {
                $totalPax = $data->details[0] ? $data->details[0]->TotalPax : 1;
                $amount =  $data->PackagesObj ? $data->PackagesObj->Price * $totalPax : 0;
                if ($data->details[0]->Itineraries) {
                    $amount += $data->details[0]->Price;
                }
            }

            $response = Http::withHeaders([
                'Authorization' => 'Basic ' . authPayment(),
                'api-version' => '2022-07-31',
                'Content-Type' => 'application/json',
            ])
                ->post('https://api.xendit.co/v2/invoices', [
                    'external_id' => $data->Code,
                    'amount' => $amount,
                    'currency' => 'IDR',
                    "description" => isset($data->details[0]->Description) && !is_null($data->details[0]->Description) ? $data->details[0]->Description : " ",
                    "customer" => [
                        "given_names" => $data->details[0] ? $data->details[0]->Name : null,
                        "email" => $data->details[0] ? $data->details[0]->Email : null,
                    ],
                    "success_redirect_url" => config('server.web') . "/travel-packages/{$data->Packages}/book?success=true",
                    "failure_redirect_url" => config('server.web') . "/",
                    "items" => [[
                        "name" => $data->PackagesObj ? $data->PackagesObj->Name : null,
                        "quantity" => $data->details[0] ? $data->details[0]->TotalPax : 1,
                        "price" => $data->PackagesObj ? $data->PackagesObj->Price : 0,
                        "category" => "Travel Packages"
                    ]]
                    // 'type' => 'DYNAMIC',
                    // "channel_code" => "ID_DANA",
                    // 'expires_at' => Carbon::now()->addDay()->toIso8601String(),
                ]);

                $responseData = $response->json();
            if (isset($responseData['error_code'])) {
                throw new \Exception("Xendit API error: " . $responseData['error_code']);
            }

            DB::transaction(function () use ($responseData, $type, &$data) {
                $ExpiresAt = Carbon::parse($responseData['expiry_date'])->format('Y-m-d H:i:s');

                $trvTransationDetail = $data->details[0];
                $trvTransationDetail->Type = $type;
                $trvTransationDetail->PaymentID = $responseData['id'];
                $trvTransationDetail->Status = "Process";
                $trvTransationDetail->ExpiresAt = $ExpiresAt;

                $trvTransationDetail->save();
            });

            return $responseData;
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Payment process failed',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
