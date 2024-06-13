<?php

namespace App\Orchid\Screens;

use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use App\Models\Supply;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\TD;

class SuppliesScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [
            'supplies' => Supply::paginate()
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Товары';
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): array
    {
        return [
            Link::make('Добавить товар')
                ->icon('bs.plus')
                ->route('platform.supply'),
        ];
    }

    /**
     * The screen's layout elements.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): iterable
    {
        return [
            Layout::table('supplies', [
                TD::make('name', 'Название')
                    ->render(function (Supply $supply) {
                        return Link::make($supply->name)
                            ->route('platform.supply', $supply->id);
                    }),
                TD::make('description', 'Описание'),
                TD::make('price', 'Цена'),
                TD::make('amount', 'Количество'),
            ]),
        ];
    }
}
