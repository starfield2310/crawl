<?php

namespace App\Http\Controllers\Crawl;

use App\Http\Controllers\Controller;
use App\Http\Service\CrawlService;
use App\Models\Crawl;
use Illuminate\Http\Request;

class Post extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */


    public function __invoke(Request $request)
    {
        try {
            $crawl = new Crawl();

            $crawlService = CrawlService::crawlUrl($request->url);

            $crawl->title = $crawlService["title"];
            $crawl->description = $crawlService["description"];

            $crawl->url = $request->url;
            $crawl->save();

            $crawl->image = CrawlService::crawlImage($request->url, $crawl->id);
            $crawl->save();

            return response()->redirectToRoute('index')->with("result", "crawl success");
        } catch (\Exception $e) {
            return response()->redirectToRoute('index')->with("result", "crawl fail");
        }
    }
}
