<?php

namespace App\Http\Middleware;

use Closure;
use Contus\Users\Models\Customer;
use Contus\Users\Models\Subscribers;
use Contus\Users\Traits\CustomerTrait as CustomerTrait;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;

class ApiCustomerAuthenticate
{
    // use CustomerTrait;

    /**
     * Class property to hold the request header
     *
     * @var obj
     */
    protected $header = null;
    /**
     * Class property the access token error
     *
     * @var int
     */
    protected $access_token_error = 0;
    /**
     * Class property the access token
     *
     * @var string
     */
    protected $access_token = null;
    /**
     * Class property the public access token
     *
     * @var string
     */
    protected $user_id = null;
    /**
     * Create a new filter instance.
     */
    protected $request_type = null;
    /**
     * It is used to differenciate the request type.
     */
    public function __construct()
    {
        $this->header = Request::header();
    }

    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $deviceId = $request->header('X-DEVICE-ID');
        $token = $request->header('authorization');
        $accessToken = ($token != '') ? str_replace('Bearer ', '', $token) : '';
        $this->access_token = $accessToken;
        $this->mobile_id = $deviceId;

        if ($accessToken != '') {
            $customerId = auth()->user()->id;
            $customer = Customer::where('access_token', $accessToken)->where('id', $customerId)->where('is_active', 1)->first();
            $subscribed = Subscribers::where('customer_id', $customerId)->where('is_active', 1)->first();

            if (empty($customer) && empty($subscribed)) {
                return Response::json(array('error' => true, 'statusCode' => 403, 'status' => 'error', 'message' => trans('base::general.otherdevice_login')), 403);
            }

            $customer = Customer::find($customerId);
            if ($customer && $subscribed && $this->deviceRegisterValidator($customer, $deviceId, $request) === false) {
                return Response::json(array('error' => true, 'statusCode' => 403, 'status' => 'error', 'message' => trans('base::general.device_restriction')), 403);
            }

            $request['user_id'] = $customerId;
        }

        return $next($request);
    }

    /**
     * Split header values based on the type
     *
     * @param
     * $type
     *
     * @return bool | string
     */
    public function splitHeaderTokens($type)
    {
        if (isset($this->header[$type][0]) && !empty($this->header[$type][0])) {
            return $this->header[$type][0];
        }
        return false;
    }
}
