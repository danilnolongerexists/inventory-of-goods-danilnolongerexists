<?php

namespace App\Orchid\Screens;

use App\Models\Product;
use Illuminate\Http\Request;
use Orchid\Screen\Screen;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\TextArea;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\Actions\Button;

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
        return [
            Button::make('Create Product')
                ->method('createOrUpdate')
                ->icon('plus'),
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
            Layout::rows([
                Input::make('product.name')
                    ->title('Name')
                    ->placeholder('Product name')
                    ->required(),

                TextArea::make('product.description')
                    ->title('Description')
                    ->rows(3)
                    ->placeholder('Product description'),

                Input::make('product.price')
                    ->title('Price')
                    ->type('number')
                    ->required(),

                Input::make('product.quantity')
                    ->title('Quantity')
                    ->type('number')
                    ->required(),
            ]),
        ];
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function createOrUpdate(Request $request)
    {
        $request->validate([
            'product.name' => 'required|string|max:255',
            'product.description' => 'nullable|string',
            'product.price' => 'required|numeric',
            'product.quantity' => 'required|integer',
        ]);

        Product::create($request->get('product'));

        return redirect()->route('platform.product.list')
            ->with('success', 'Product created successfully.');
    }
}
