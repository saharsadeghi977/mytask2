<?php

use App\Http\Classes\CoreSuperAdmin;
use App\Services\CoreServices;
use Carbon\Carbon;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Psr7\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Rp76\Guzzle\Client;
use Rp76\Guzzle\ResponseData;
use App\Http\Classes\ConstProduction;
use Illuminate\Support\Facades\Auth;

/**
 * @param $permissionName
 * @return bool
 * @throws GuzzleException
 */
function checkPermission($permissionName): bool
{
    if (env("APP_DEBUG"))
        return true;

    if (!CoreServices::$userToken)
        return false;

    $client = new Client([
        "base_uri" => config('app.core_url'),
        "headers" => [
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
            'secret' => config('app.core_secret'),
            'Authorization' => 'Bearer ' . CoreServices::$userToken,
        ],
        "timeout" => 15
    ]);

    $request = new Request("POST", "api/abilitiesStatuss");

    return $client->easySend($request, [
        "json" => ["name" => $permissionName]
    ])->success();
}

/**
 * @param $permissionName
 * @throws GuzzleException
 */
function checkPermissionController($permissionName): void
{
    if (env("APP_DEBUG"))
        return;

    if (!CoreServices::$userToken)
        abort(403);

    $client = new Client([
        "base_uri" => config('app.core_url'),
        "headers" => [
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
            'secret' => config('app.core_secret'),
            'Authorization' => 'Bearer ' . CoreServices::$userToken,
        ],
        "timeout" => 15
    ]);

    $request = new Request("POST", "api/abilitiesStatuss");

    $response = $client->send($request, [
        "json" => ["name" => $permissionName]
    ]);

    abort_if(!(new ResponseData($client, $response))->success(), 403);
}

/**
 * @param $paginator
 * @param array $appends
 * @param bool $withOwner
 * @param bool $withPaginate
 * @return LengthAwarePaginator
 * @throws GuzzleException
 */
function appendUsersOnCollection($paginator, array $appends = [], bool $withOwner = true, bool $withPaginate = true): LengthAwarePaginator
{
    $total = 0;
    $perPage = 0;
    $currentPage = 0;
    $ids = $paginator->pluck("user_id")->toArray();

    if ($withPaginate) {
        $total = $paginator->total();
        $perPage = $paginator->perPage();
        $currentPage = $paginator->currentPage();
    }

    $paginator = $paginator->append($appends);

    $coreSuperAdmin = new CoreSuperAdmin();

    $users = $coreSuperAdmin->findUsersById((array_unique(array_filter($ids))));

    if (!$users->success())
        return new LengthAwarePaginator($paginator, $total, $perPage, $currentPage, ['path' => url(Route::current()->uri())]);

    $users = $users->json;

    $usersId = array_column($users, "id");

    $page = collect($paginator->toArray())->transform(function ($page) use ($users, $usersId) {
        $foundedIndex = array_search($page["user_id"], $usersId);

        return array_merge(
            $page,
            ["user" => $foundedIndex !== false ? $users[$foundedIndex] : null],
        );
    });

    if ($withOwner)
        $page->transform(function ($page) use ($users, $usersId) {
            $foundedIndex = array_search($page["user_id"], $usersId);

            return array_merge(
                $page,
                ["owner" => $foundedIndex !== false ? $users[$foundedIndex] : null],
            );
        });

    if ($withPaginate)
        $page = new LengthAwarePaginator($page, $total, $perPage, $currentPage, ['path' => url(Route::current()->uri())]);

    return $page;
}

/**
 * @param $data
 * @param array $appends
 * @param bool $withOwner
 * @return array
 * @throws GuzzleException
 */
function appendUsers($data, array $appends = [], bool $withOwner = true): array
{
    $data = $data->append($appends);

    $coreSuperAdmin = new CoreSuperAdmin();

    $user = [];

    if ($data->user_id)
        $user = $coreSuperAdmin->findUserById($data->user_id)->user;

    $data = array_merge(
        $data->toArray(),
        ["user" => (array)$user ?? null],
    );

    if ($withOwner)
        $data = array_merge(
            $data,
            ["owner" => (array)$user ?? null]
        );

    return $data;
}

/**
 * @param $data
 * @return array|void
 */
function jwt($data)
{
    if (!preg_match("/(ey.*?){2}/m", $data))
        return;

    list($header, $payload, $signature) = explode(".", $data);

    $response = [];
    foreach (json_decode(base64_decode($payload)) as $key => $res) {
        $response[$key] = $res;
        if (filter_var($res, FILTER_VALIDATE_INT))
            $response[$key] = Carbon::createFromTimestamp($res)->toDateTimeString();
    }

    ksort($response);

    return $response;
}
function payReport(int $count = 1): ResponseData
{
    $core = CoreServices::instance();
    $reportPack = CoreServices::instance()->getReportPanel();

    abort_if(!$reportPack, 406);

    ConstProduction::setFillable(
        "REPORT",
        '64bfd9fa2879f2007017d8e0',
        ConstProduction::PRODUCTION_TYPE_BUY,
        Auth::id(),
        $core->getUserPanel()['id'],
        $reportPack['price'],
        $count,
        $reportPack["title"] . " - " . $reportPack["id"],
        null,
        $reportPack['updated_at'],
        null,
        null,
        $reportPack['type'],
        null,
        null,
    );

    return $core->withDraw(ConstProduction::getFillable());
}

/**
 * @param int $price
 * @param string $refrence
 * @param string $productName
 * @param string $productId
 * @return ResponseData
 * @throws GuzzleException
 * @throws Throwable
 */
function pay(int $price, string $refrence, string $productName , string $productId): ResponseData
{
    $core = CoreServices::instance();

    ConstProduction::setFillable(
        $productName,
        $productId,
        ConstProduction::PRODUCTION_TYPE_BUY,
        Auth::id(),
        $core->getUserPanel()['id'],
        $price,
        1,
        $refrence,
        null,
        now(),
        null,
        null,
        "free_payment",
        null,
        null,
    );

    return $core->withDraw(ConstProduction::getFillable());
}
