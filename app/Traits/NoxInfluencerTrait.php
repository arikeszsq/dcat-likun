<?php
namespace App\Traits;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

trait NoxInfluencerTrait
{
    /**
     * 频道基础信息
     * 说明: 调用“Channel Information ”，可以获得YouTube频道的基础信息。
     * 配额消耗: 每次请求消耗50配额
     * @param $platform
     * @param $channelId
     * @return mixed
     */
    public static function profile($platform, $channelId)
    {
        $url = (string) Str::of('https://service.noxinfluencer.com/nox/{platform}/v1/channel/profile?noxKey={api_key}&channelId={channel_id}')
            ->replace('{platform}', $platform)
            ->replace('{api_key}', env('NOX_INFLUENCER_KEY'))
            ->replace('{channel_id}', $channelId);

        return Arr::add(Http::get($url)->json(), 'url', $url);
    }

    /**
     * 受众分析
     * 说明: 受众分析可以生成YouTube频道的粉丝画像。
     * 配额消耗: 每次请求消耗20个配额
     * @param $platform
     * @param $channelId
     * @return mixed
     */
    public static function subscribersDataPortrait($platform, $channelId)
    {
        $url = (string) Str::of('https://service.noxinfluencer.com/nox/{platform}/v1/channel/subscribersDataPortrait?noxKey={api_key}&channelId={channel_id}')
            ->replace('{platform}', $platform)
            ->replace('{api_key}', env('NOX_INFLUENCER_KEY'))
            ->replace('{channel_id}', $channelId);

        return Arr::add(Http::get($url)->json(), 'url', $url);
    }

    /**
     * 历史数据
     * 说明: 仅限企业定制版会员用户; 使用“历史数据”，您可以获得某个YouTube频道的历史数据变化，如：粉丝数变化、观看量变化等。
     * 配额消耗: 无
     * @param $platform
     * @param $channelId
     * @return mixed
     */
    public function subscribersAndViewsTrend($platform, $channelId)
    {
        $url = (string) Str::of('https://service.noxinfluencer.com/nox/{platform}/v1/channel/subscribersAndViewsTrend?noxKey={api_key}&channelId={channel_id}')
            ->replace('{platform}', $platform)
            ->replace('{api_key}', env('NOX_INFLUENCER_KEY'))
            ->replace('{channel_id}', $channelId);

        return Arr::add(Http::get($url)->json(), 'url', $url);
    }
}
