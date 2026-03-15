@php $banners = \App\Models\Banner::visible()->get(); @endphp
@if($banners->isNotEmpty())
    <div class="border-b border-slate-200 bg-brand-teal/10 py-2">
        <div class="container mx-auto px-4">
            <div class="flex flex-wrap items-center justify-center gap-x-6 gap-y-1 text-center text-sm font-medium text-brand-teal-dark">
                @foreach($banners as $banner)
                    @if($banner->link)
                        <a href="{{ $banner->link }}" class="hover:underline">{{ $banner->title }}</a>
                    @else
                        <span>{{ $banner->title }}</span>
                    @endif
                @endforeach
            </div>
        </div>
    </div>
@endif
