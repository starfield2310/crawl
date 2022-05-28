<?php

namespace App\Http\Controllers\Crawl;

use App\Http\Controllers\Controller;
use App\Models\Crawl;

class Get extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */

    private Crawl $crawl;
    public function __construct(Crawl $crawl)
    {
        $this->crawl = $crawl;
    }


    public function __invoke(int $crawlId)
    {
        try {
            $crawl = $this->crawl::whereId($crawlId)->firstOrFail();
            return view('get', ['crawl' => $crawl]);
        } catch (\Exception $e) {
            return response()->redirectToRoute('index')->with("fail", "detail no exist.");
        }
    }
}
