<?php

namespace App\Http\Service;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Storage;
use PHPHtmlParser\Dom;

class CrawlService {

    public static function crawlUrl($url) {

        $client = new Client();
        $res = $client->request('GET', $url);

        $body = $res->getBody()->getContents();

        $dom = new Dom;
        $dom->loadStr($body);

        $metas = $dom->find('meta');

        foreach ($metas as $meta) {
            switch ($meta->getAttribute("name")) {
                case "title":
                    $crawl["title"] = $meta->getAttribute("content");
                    break;
                case "description":
                    $crawl["description"] = $meta->getAttribute("content");
                    break;
            }
        }

        if(!isset($crawl["title"]))
            $crawl["title"] = $dom->find('title')->text;


        return $crawl;
    }

    public static function crawlImage($url, $crawlId) {

        $token = env('SCREENSHOT_TOKEN');
        $url = urlencode($url);
        $width = 1920;
        $height = 1080;
        $full_page = 1;

        $query = "https://www.screenshotmaster.com/api/v1/screenshot";
        $query .= "?token=$token&url=$url&width=$width&height=$height&full_page=$full_page";

        $image = file_get_contents($query);

        Storage::disk('public')->put("crawl{$crawlId}.png", $image);

        return asset("storage/crawl{$crawlId}.png");
    }
}
