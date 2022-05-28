<?php

namespace App\Http\Controllers\Crawl;

use App\Http\Controllers\Controller;
use App\Models\Crawl;
use Carbon\Carbon;
use Illuminate\Http\Request;

class GetList extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */

    private Crawl $crawl;
    private $fuzzyColumns = ["title", "description"];
    public function __construct(Crawl $crawl)
    {
        $this->crawl = $crawl;
    }


    public function __invoke(Request $request)
    {

        $crawl = $this->crawl::query();
        foreach ($this->fuzzyColumns as $column) {

            if($request->input($column)) {
                $crawl->where($column, 'like', implode('', ['%', $request->input($column), '%']));
            }
        }

        if($request->input("start_at"))
            $crawl->where("created_at", '>=', Carbon::parse($request->input('start_at'))->toDateTimeString());

        $crawls = $crawl->orderBy("created_at", "DESC")->paginate(2);
        return view('index', ['crawls' => $crawls]);
    }
}
