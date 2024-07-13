<?php

namespace App\Services;

use App\Models\User;
use GuzzleHttp\{Exception\GuzzleException, Psr7\Request};
use Rp76\Guzzle\Client;
use Rp76\Guzzle\ResponseData;
use Illuminate\{Support\Collection, Support\Facades\Auth};
use Throwable;

class CoreServices
{
    public static ?string $userToken = null;
    private static self $instance;
    protected ?Client $client = null;
    protected ?ResponseData $responseData = null;
    protected ?array $panel = null;
    protected ?array $wallet = null;
    protected ?User $user = null;

    private function __construct($token)
    {
        $this->client = new Client([
            "base_uri" => config("app.core_url"),
            "headers" => [
                "Accept" => "application/json",
                "Content-Type" => "application/json",
                "secret" => config("app.core_secret"),
                "Authorization" => "Bearer " . $token
            ]
        ]);
    }

    /**
     * @return CoreServices
     * @throws Throwable
     */
    public static function instance(): CoreServices
    {
        throw_if(!self::$userToken, "token not set");
        return self::$instance ?? self::$instance = new self(self::$userToken);
    }

    /**
     * @param string $type
     * @param int $perPage
     * @return ResponseData
     * @throws GuzzleException
     */
    public function content(string $type = "news", int $perPage = 3): ResponseData
    {
        $service = Request()->has("sid") ? "&sid=" . Request()->input("sid") : "";

        $request = new Request("GET", "api/contentIndex?type=$type&perpage=$perPage" . $service);

        $response = $this->client->send($request);

        return new ResponseData($this->client, $response);
    }

    /**
     * @return bool
     */
    public function isUserExist(): bool
    {
        return (bool)$this->user;
    }

    /**
     * @return ?User
     * @throws GuzzleException
     */
    public function getUser(): ?User
    {
        return $this->user ?? $this->user = $this->setUser();
    }

    /**
     * @return ?User
     * @throws GuzzleException
     */
    protected function setUser(): ?User
    {
        $request = new Request('GET', '/api/user');

        $response = $this->client->send($request);

        $this->responseData = new ResponseData($this->client, $response);

        if (!$this->responseData->success())
            return null;

        Auth::setUser(new User($this->responseData->getJson()));
        return new User($this->responseData->getJson());
    }

    /**
     * @return array|null
     * @throws GuzzleException
     */
    public function getUserPanel(): ?array
    {
        //fixme: hes mikonam in bad az takmil kardane Core be moshkel mikhore

        if ($this->panel)
            return $this->panel;

        $request = new Request('GET', '/api/currentPack');

        $response = $this->client->send($request);

        $this->responseData = new ResponseData($this->client, $response);

        $json = $this->responseData->getJson();

        $panel = collect($json)->only([
            "id",
            "title",
            "price",
            "expire",
            "inline_features",
            "expired_at",
        ])->put("diff_day", now()->diffInDays(@$json['expired_at']));

        return $this->panel = $panel->toArray();
    }
    /**
     * @param array $data
     * @return ResponseData
     * @throws GuzzleException
     */
    public function withDraw(array $data): ResponseData
    {
        $request = new Request("POST", env("API_WALLET") . "/api/transactions/withdraw");

        $response = $this->client->send($request, [
            "json" => $data
        ]);

        return new ResponseData($this->client, $response);
    }

    /**
     * @return ResponseData
     * @throws GuzzleException
     */
    public function getUserAbilities(): ResponseData
    {
        $request = new Request("GET", "api/abilitiesType");

        $response = $this->client->send($request);

        return new ResponseData($this->client, $response);
    }

    /**
     * @param int $count
     * @return ResponseData
     * @throws GuzzleException
     */
    public function getUserTransactions(int $count = 3): ResponseData
    {
        $request = new Request("GET", "api/transactions/user?length=$count");

        $response = $this->client->send($request);

        return new ResponseData($this->client, $response);
    }

    /**
     * @param int $balance
     * @return ResponseData
     * @throws GuzzleException
     */
    public function charge(int $balance): ResponseData
    {
        $request = new Request("POST", "api/wallet/sharge");

        $response = $this->client->send($request, [
            "form_params" => [
                "balance" => $balance
            ]
        ]);

        return new ResponseData($this->client, $response);
    }

    /**
     * @return bool
     * @throws GuzzleException
     */
    public function logout(): bool
    {
        $request = new Request("DELETE", "api/logout");

        $response = $this->client->send($request);

        return (new ResponseData($this->client, $response))->success();
    }

    /**
     * @return ResponseData
     * @throws GuzzleException
     */
    public function allUsers(): ResponseData
    {
        $request = new Request("GET", "api/admin/users");

        $response = $this->client->send($request, [
            "query" => Request()->all()
        ]);

        return new ResponseData($this->client, $response);
    }

    /**
     * @param string $phone
     * @return ResponseData
     * @throws GuzzleException
     */
    public function invite(string $phone): ResponseData
    {
        $request = new Request("POST", "api/invite?phone=$phone");

        $response = $this->client->send($request);

        return new ResponseData($this->client, $response);
    }

    /**
     * @param int $page
     * @param array $data
     * @return mixed
     * @throws GuzzleException
     */
    public function invent(int $page = 1, array $data = [])
    {
        $request = new Request("GET", "api/admin/invent/code?page=$page");

        $response = $this->client->send($request);

        $res = new ResponseData($this->client, $response);

        if ($res->success()) {
            $data = array_merge(
                $res->object->data,
                $data
            );

            if ($res->object->meta->last_page >= $page)
                return $this->invent($page + 1, $data);
        }

        return $data;
    }

    private function __clone()
    {

    }
}
