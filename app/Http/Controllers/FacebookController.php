<?php

namespace App\Http\Controllers;


use App\Models\User;
use App\Models\StockDetails;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Socialite;
use Exception;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class FacebookController extends Controller
{
    
    const STOCK_URL = 'https://www.alphavantage.co/query';
    const QUERY_PARAM = '?function=GLOBAL_QUOTE&apikey=0O18XUJW9P8QVGQJ&symbol=';
    const STR_PATTERN = '/^([0-9]+\.\s)/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function redirectToFacebook()
    {
        return Socialite::driver('facebook')->redirect();
    }


    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function handleFacebookCallback()
    {
        try {
            $user = Socialite::driver('facebook')->user();
            $create['name'] = $user->getName();
            $create['email'] = $user->getEmail();
            $create['password'] = 'default';

            $createdUser = User::updateOrCreate($create, ['facebook_id' => $user->getId()]);

            Auth::loginUsingId($createdUser->id);

            return redirect('home');

        } catch (Exception $e) {
            return redirect('');
        }
    }

    public function getStockData(Request $request)
    {
        //try {
            $res = Http::get(self::STOCK_URL . self::QUERY_PARAM . $request->route('id'));
            $decodeRes = json_decode($res->getBody())->{'Global Quote'};
            $stockData = [];
            foreach ($decodeRes as $key => $val) {
                $newKey = Str::replace(' ', '_', preg_replace(self::STR_PATTERN, '', $key));
                $stockData[$newKey] = $val;
            }
            StockDetails::updateOrCreate($stockData, ['symbol' => $stockData['symbol']]);
            return $this->htmlTableData($stockData);

        /*} catch (Exception $e) {
            return 'something went wrong';
        }*/
    }

    public function htmlTableData($data)
    {
        $htmlResp = '<table class="table table-bordered">
        <thead>
          <tr>
            <th>Field Name</th>
            <th>Value</th>
          </tr>
        </thead>
        <tbody>';
        foreach ($data as $key => $val) {
            $htmlResp .= '<tr><td>' . $this->fieldNameCase($key) . '</td><td> ' .$val . '</td></tr>';
        }
        return $htmlResp .= '</tbody></table>';
    }

    public function fieldNameCase($fieldName)
    {
        return Str::title(Str::replace('_', ' ', $fieldName));
    }
}