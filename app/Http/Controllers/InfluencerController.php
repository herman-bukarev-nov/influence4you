<?php

namespace App\Http\Controllers;

use App\Influencer;
use Barryvdh\Snappy\PdfWrapper;
use Illuminate\View\Factory as View;

class InfluencerController extends Controller
{
    /**
     * Show an influencers list.
     *
     * @param \App\Influencer $influencer
     * @param \Illuminate\View\Factory $view
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index(Influencer $influencer, View $view)
    {
        /** @var \Illuminate\Pagination\Paginator $influencers */
        $influencers = $influencer::simplePaginate();
        $pages = $influencers->links();

        return $view->make('pages.influencers', compact('influencers', 'pages'));
    }

    /**
     * Download an influencers list.
     *
     * @param \App\Influencer $influencer
     * @param \Barryvdh\Snappy\PdfWrapper $pdfWrapper
     *
     * @return \Illuminate\Http\Response
     */
    public function downloadIndex(Influencer $influencer, PdfWrapper $pdfWrapper)
    {
        $influencers = $influencer::all();
        $pdfWrapper->loadView('components.influencers_index', compact('influencers'));

        return $pdfWrapper->download('influencers.pdf');
    }
}
