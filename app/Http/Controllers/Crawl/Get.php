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


    public function __invoke(int $crawl_id)
    {
        $crawl = $this->crawl::whereId($crawl_id)->firstOrFail();
        return view('get', ['crawl' => $crawl]);
    }
}
