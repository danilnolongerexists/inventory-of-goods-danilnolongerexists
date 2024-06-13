<?php

namespace App\Orchid\Screens;

use App\Models\Supply;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\TextArea;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class SupplieEditScreen extends Screen
{
    public $supply;
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(Supply $supply_id): iterable
    {
        return [
            'supply' => $supply_id
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return $this->supply->exists ? 'Редактирование товара' : 'Создание товара';
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            Button::make('Создать')
                ->icon('bs.save')
                ->method('saveSupply')
                ->canSee(!$this->supply->exists),
            Button::make('Изменить')
                ->icon('bs.pencil')
                ->method('updateSupply')
                ->canSee($this->supply->exists),
            Button::make('Удалить')
                ->icon('bs.trash')
                ->method('removeSupply')
                ->canSee($this->supply->exists),
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
            Layout::rows([
                Input::make('supply.name')
                    ->title('Название')
                    ->placeholder('Введите название товара')
                    ->required(),
                TextArea::make('supply.description')
                    ->title('Описание')
                    ->required()
                    ->rows(5),
                Input::make('supply.price')
                    ->title('Цена (в копейках)')
                    ->placeholder('Введите цену товара')
                    ->required()
                    ->type('number'),
                Input::make('supply.amount')
                    ->title('Количество')
                    ->placeholder('Введите количество товара')
                    ->required()
                    ->type('number'),
            ])
        ];
    }

    public function saveSupply(Request $request)
    {
        $supply = new Supply();
        $supply->fill($request->get('supply'));
        $supply->save();
        Toast::success('Товар успешно создан');
        return redirect()->route('platform.supplies');
    }

    public function updateSupply(Request $request)
    {
        $this->supply->fill($request->get('supply'));
        $this->supply->save();
        Toast::success('Товар успешно изменен');
        return redirect()->route('platform.supplies');
    }

    public function removeSupply()
    {
        $this->supply->delete();
        Toast::info('Товар успешно удален');
        return redirect()->route('platform.supplies');
    }
}
