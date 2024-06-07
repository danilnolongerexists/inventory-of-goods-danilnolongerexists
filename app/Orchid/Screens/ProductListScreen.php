<?php

namespace App\Orchid\Screens;

use App\Models\Product;
use Orchid\Screen\Screen;
use Orchid\Screen\Actions\Link;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\TD;
use Orchid\Screen\Layouts\Table;
use Orchid\Support\Facades\Toast;

class ProductListScreen extends Screen
{
    public $name = 'Products';
    /**
     * Fetch data to be displayed on the screen.
     *
     *
     */
    public function query(): array
    {
        return [
            'products' => Product::paginate()
        ];
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): array
    {
        return [];
    }

    /**
     * The screen's layout elements.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): array
    {
        return [
            Layout::table('products', [
                TD::set('id', 'ID'),
                TD::set('name', 'Name'),
                TD::set('price', 'Price'),
                TD::set('created_at', 'Created')->render(function ($product) {
                    return $product->created_at->toDateString();
                }),
            TD::set('action', 'Actions')->render(function ($product) {
                    return Link::make('Edit')->route('platform.product.edit', $product);
                }),
            ]),
        ];
    }
}
