<?php

namespace App\Http\Classes;

use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Facades\Cache;
use Rp76\Guzzle\Client;
use Rp76\Guzzle\ResponseData;

/**
 * Use this class when you need to pay something, but you don't have user token.
 */
class CoreSuperAdmin
{
    //todo: make me singleton
    public ?object $superAdmin;
    public ?object $user = null;
    protected Client $client;

    /**
     * @throws GuzzleException
     */
    public function __construct()
    {
        $this->client = new Client([
            "base_uri" => config("app.core_url"),
            "headers" => [
                "Accept" => "application/json",
                "Content-Type" => "application/json",
                "secret" => config("app.core_secret"),
            ]
        ]);

        $this->superAdmin = @$this->login()->data->user;

        $this->checkToken();
    }

    /**
     * @return object
     */
    protected function login(): object
    {
        return Cache::rememberForever("core_super_admin_login", function () {
            $request = new Request("GET", "api/auth");

            $response = $this->client->send($request, [
                "query" => [
                    "via" => "pass",
                    "username" => config("app.core_admin_user"),
                    "password" => config("app.core_admin_password")
                ]
            ]);

            return (new ResponseData($this->client, $response))->object;
        });
    }

    /**
     * @param int $userId
     * @return $this
     * @throws GuzzleException
     */
    public function findUserById(int $userId): CoreSuperAdmin
    {
        $request = new Request("GET", "api/user/$userId");

        $response = $this->client->send($request, [
            "headers" => [
                "Authorization" => "Bearer " . $this->superAdmin->token
            ],
        ]);

        $this->user = (new ResponseData($this->client, $response))->object;

        return $this;
    }

    /**
     * @param array $ids
     * @return ResponseData
     * @throws GuzzleException
     */
    public function findUsersById(array $ids): ResponseData
    {
        $request = new Request("POST", "api/admin/user/listUserNames");

        $response = $this->client->send($request, [
            "headers" => [
                "Authorization" => "Bearer " . @$this->superAdmin->token
            ],
            "json" => [
                "user_id" => $ids
            ]
        ]);

        return new ResponseData($this->client, $response);
    }

    /**
     * @param array $data
     * @return ResponseData
     * @throws GuzzleException
     */
    protected function withDraw(array $data): ResponseData
    {
        $request = new Request("POST", env("API_WALLET") . "/api/transactions/admin/withdraw");

        $response = $this->client->send($request, [
            "headers" => [
                "Authorization" => "Bearer " . $this->superAdmin->token
            ],
            "json" => $data
        ]);

        return new ResponseData($this->client, $response);
    }

    /**
     * @param $production
     * @param int|null $count
     * @return bool
     * @throws GuzzleException
     */
    public function refund($production, int $count = null): bool
    {
        return $this->deposit(array_filter([
            'transactionId' => $production,
            'count' => $count
        ]));
    }

    /**
     * @param array $data
     * @return bool
     * @throws GuzzleException
     */
    protected function deposit(array $data): bool
    {
        $request = new Request("POST", env("API_WALLET") . "/api/transactions/refund");

        $response = $this->client->send($request, [
            "headers" => [
                "Authorization" => "Bearer " . $this->superAdmin->token
            ],
            "json" => $data
        ]);

        return (new ResponseData($this->client, $response))->success();
    }

    /**
     * @throws GuzzleException
     */
    private function checkToken(): void
    {
        if ($this->findUsersById([1])->success())
            return;

        Cache::forget("core_super_admin_login");
        $this->superAdmin = @$this->login()->data->user;
    }

    public function editPayment(string $payment, string $describe): bool
    {
        $request = new Request("POST", "api/admin/newWallet/transaction/update");

        $response = $this->client->send($request, [
            "headers" => [
                "Authorization" => "Bearer " . $this->superAdmin->token
            ],
            "json" => [
                'id' => $payment,
                'description' => $describe
            ]
        ]);

        return (new ResponseData($this->client, $response))->success();
    }
}
