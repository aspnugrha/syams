@php
    $segments = request()->segments();
    $url = url('/');

    $lastSegment = request()->segment(count(request()->segments()));
    $preLastSegment = request()->segment(count(request()->segments()) -1);
    $titlePage = $lastSegment;
    if($lastSegment == 'create' || $lastSegment == 'Edit'){
        $titlePage = $lastSegment.' '.$preLastSegment;
    }

    if(strlen($lastSegment) > 15 && $preLastSegment == 'company-profile'){
        $titlePage = 'Edit Company Profile';
    }

    if(strlen($preLastSegment) > 15){
        $segment2 = request()->segment(2);
        $titlePage = $lastSegment.' '.$segment2;
    }
    
    if(strlen($lastSegment) > 15){
        $segment2 = request()->segment(2);
        $titlePage = 'Detail '.$segment2;
    }
@endphp

<!-- [ breadcrumb ] start -->
<div class="page-header">
    <div class="page-block">
        <div class="row align-items-center">
            <div class="col-md-12">
                <div class="page-header-title">
                    <h5 class="m-b-10">{{ ucwords(str_replace(['-', '_'], ' ', $titlePage)) }}</h5>
                </div>
                <ul class="breadcrumb">
                    @foreach ($segments as $key => $segment)
                        @if (strlen($segment) < 25)
                            @php
                                $url .= '/' . $segment;
                                $name = ucwords(str_replace(['-', '_'], ' ', $segment));
                            @endphp
                
                            @if ($loop->last)
                                <li class="breadcrumb-item active" aria-current="page">
                                    @if ($preLastSegment == 'company-profile')
                                        Edit
                                    @else
                                        {{ $name }}
                                    @endif
                                </li>
                            @else
                                <li class="breadcrumb-item">
                                    <a href="{{ $url }}">{{ $name }}</a>
                                </li>
                            @endif
                        @else
                            @if ($loop->last)
                                <li class="breadcrumb-item active" aria-current="page">Detail</li>
                            @endif
                        @endif
                    @endforeach
                    {{-- <li class="breadcrumb-item"><a href="{{ asset('assets/backend') }}/dashboard/index.html">Home</a></li>
                    <li class="breadcrumb-item"><a href="javascript: void(0)">Dashboard</a></li>
                    <li class="breadcrumb-item" aria-current="page">Home</li> --}}
                </ul>
            </div>
        </div>
    </div>
</div>
<!-- [ breadcrumb ] end -->
