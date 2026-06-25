<?php

namespace App\Http\Controllers;

use App\Models\Faq;
use App\Models\PortfolioItem;

class FaqController extends Controller
{
    public function index()
    {
        $faqs = Faq::active()->ordered()->get()->groupBy('category');
        return view('pages.faq', compact('faqs'));
    }

    public function portfolio()
    {
        $items = PortfolioItem::where('active', true)
            ->orderBy('order')
            ->get();
        $categories = $items->pluck('category')->unique()->values();
        return view('pages.portfolio', compact('items', 'categories'));
    }
}
