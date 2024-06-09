<?php

namespace App\Orchid\Screens;

use App\Models\Product;
use Orchid\Screen\Screen;
use Orchid\Screen\Actions\Link;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\TD;
use Orchid\Screen\Layouts\Table;

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
        return [
            Link::make('Create')
                ->icon('plus')
                ->route('platform.product.create'),
        ];
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
                TD::make('id', 'ID'),
                TD::make('name', 'Name'),
                TD::make('price', 'Price'),
                TD::make('quantity', 'Quantity'),
                TD::make('created_at', 'Created')->render(function ($product) {
                    return $product->created_at->toDateString();
                }),
                TD::make('action', 'Actions')->render(function ($product) {
                    return Link::make('Edit')
                        ->route('platform.product.edit', $product->id);
                }),
            ]),
        ];
    }
}
