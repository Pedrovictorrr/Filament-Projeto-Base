<x-filament-panels::page>
    @foreach ($this->model as $model )
    <x-filament::section
    icon="heroicon-m-rocket-launch"
    icon-size="sm"
    icon-color='primary'
>
    <x-slot name="heading">
        {{$model->titulo}} -- {{ strftime('%d/%m/%Y',strtotime($model->data_release))}}
    </x-slot>
    <div class="text-sm">


    {!!$model->descricao!!}
    </div>
    {{-- Content --}}
</x-filament::section>

 @endforeach
</x-filament-panels::page>
