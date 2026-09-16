<table class="table align-items-center mb-0">
    <thead>
        <tr>
            @foreach($headers as $header)
                <th class="text-center">{{ $header }}</th>
            @endforeach
        </tr>
    </thead>
    @if($isPaginate)
        <tbody>
        @if(count($items->items))
            {{ $slot }}
        @else
            <tr>
                <td colspan="{{ count($headers) }}" class="text-center">
                    <div class="alert" role="alert">
                        <span class="alert-text text-warning">اطلاعاتی یافت نشد!</span>
                    </div>
                </td>
            </tr>
        @endif
        </tbody>
    @else
        <tbody>
        @if(count($items))
            {{ $slot }}
        @else
            <tr>
                <td colspan="{{ count($headers) }}" class="text-center">
                    <div class="alert" role="alert">
                        <span class="alert-text text-warning">اطلاعاتی یافت نشد!</span>
                    </div>
                </td>
            </tr>
        @endif
        </tbody>
    @endif
</table>
@if($isPaginate)
    <div class="d-flex justify-content-center align-items-center gap-2 flex-wrap py-4">
        {{$items->appends(request()->query())->onEachSide(2)->render()}}
    </div>
@endif
