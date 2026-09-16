
<nav aria-label="breadcrumb">
    <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0" dir="rtl">
        @foreach($data as $item)
            <li class="breadcrumb-item text-sm ps-2">
                <a href="{{$item['route']}}" class="{{!$item['active'] ? 'opacity-5':''}} text-white">{{$item['title']}}</a>
            </li>
        @endforeach
    </ol>
</nav>
