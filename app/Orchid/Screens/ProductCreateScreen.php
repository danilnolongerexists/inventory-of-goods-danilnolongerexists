<?php

namespace App\Orchid\Screens;

use App\Models\Product;
use Illuminate\Http\Request;
use Orchid\Screen\Screen;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\TextArea;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class ProductCreateScreen extends Screen
{
    public $name = 'Create Product';
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): array
    {
        return [];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'ProductCreateScreen';
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
            Layout::rows([
                Input::make('product.name')->title('Name'),
                TextArea::make('product.description')->title('Description'),
                Input::make('product.price')->title('Price'),
            ])
        ];
    }

    public function save(Request $request)
    {
        $product = new Product();
        $product->fill($request->get('product'))->save();

        Toast::info('Product was created.');
        return redirect()->route('platform.product.list');
    }
}
