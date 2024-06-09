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
            Link::make('Create')->route('platform.product.create'),
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
        $productId = $request->input('product.id');
        $quantity = (int) $request->input('quantity');

        $product = Product::find($productId);

        if (!$product) {
            dd("Product with ID $productId not found.");
        }

        $stock = Stock::where('product_id', $productId)->first();

        if (!$stock) {
            dd("Stock for product with ID $productId not found.");
        }

        if ($stock->quantity < $quantity) {
            dd("Not enough stock for product with ID $productId.");
        }

        // Все проверки пройдены, выпускаем продукт

        $stock->quantity -= $quantity;
        $stock->save();
        Toast::info('Product issued.');

        return redirect()->route('platform.product.edit', $product);
    }

}
