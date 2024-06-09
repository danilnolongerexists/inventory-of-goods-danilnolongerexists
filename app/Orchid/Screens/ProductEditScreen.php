<?php

namespace App\Orchid\Screens;

use App\Models\Product;
use App\Models\Stock;
use Illuminate\Http\Request;
use Orchid\Screen\Screen;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\TextArea;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class ProductEditScreen extends Screen
{
    public $name = 'Edit Product';
    public $product;

    public function query(Product $product): array
    {
        return [
            'product' => $product
        ];
    }

    public function commandBar(): array
    {
        return [
            Button::make('Issue Product')
                ->icon('check')
                ->method('issueProduct')
        ];
    }

    public function layout(): array
    {
        return [
            Layout::rows([
                Input::make('product.name')->title('Name'),
                TextArea::make('product.description')->title('Description'),
                Input::make('product.price')->title('Price'),
                Input::make('quantity')->title('Quantity to issue')->type('number'),
            ])
        ];
    }

    public function save(Product $product, Request $request)
    {
        $product->fill($request->get('product'))->save();

        Toast::info('Product was saved.');
        return redirect()->route('platform.product.list');
    }

    public function issueProduct(Request $request)
    {
        $product = Product::find($request->get('product.id'));
        $quantity = (int)$request->get('quantity');

        $stock = Stock::where('product_id', $product->id)->first();

        if ($stock && $stock->quantity >= $quantity) {
            $stock->quantity -= $quantity;
            $stock->save();
            Toast::info('Product issued.');
        } else {
            Toast::error('Not enough stock.');
        }

        return redirect()->route('platform.product.edit', $product);
    }
}
