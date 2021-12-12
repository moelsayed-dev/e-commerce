<div class="py-6 px-10 md:px-24 lg:px-52 border-b border-gray-300 bg-gray-100 shadow text-gray-bg font-semibold text-sm capitalize">
    @foreach ($pages as $page)
        <a href="{{'/' . $page }}">{{ $page }}</a>
        @if (!$loop->last)
            <i class="fa fa-chevron-right"></i>
        @endif
    @endforeach
</div>
