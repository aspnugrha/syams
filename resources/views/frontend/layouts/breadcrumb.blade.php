@php
    $segments = request()->segments();
    $url = url('/');
@endphp

<div class="bg-light">
    <nav class="container py-4" aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item px-2">Panel</li>
            @foreach ($segments as $key => $segment)
                @php
                    $url .= '/' . $segment;
                    $name = ucwords(str_replace(['-', '_'], ' ', $segment));
                @endphp
    
                @if ($loop->last)
                    <li class="breadcrumb-item px-2 active" aria-current="page">{{ $name }}</li>
                @else
                    <li class="breadcrumb-item px-2">
                        <a href="{{ $url }}">{{ $name }}</a>
                    </li>
                @endif
            @endforeach
        </ol>
    </nav>
</div>
