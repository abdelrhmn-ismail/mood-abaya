<?php

namespace Modules\Core\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\View\View;
use Modules\Core\Services\HomeService;

class HomeController extends Controller
{
    public function __construct(
        private HomeService $homeService
    ) {}

    public function __invoke(): View
    {
        $categories = $this->homeService->getFeaturedCategories();
        $products = $this->homeService->getLatestProducts();
        $featuredProducts = $this->homeService->getFeaturedProducts();

        return view('core::frontend.home', compact('categories', 'products', 'featuredProducts'));
    }
}
