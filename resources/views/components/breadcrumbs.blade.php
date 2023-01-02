@unless($breadcrumbs->isEmpty())
    <ul id="ibm-navigation-trail" class="ibm-padding-top-1 ibm-padding-bottom-1">
        @foreach($breadcrumbs as $breadcrumb)
            @if(!is_null($breadcrumb->url) && !$loop->last)
                <li itemscope="" itemtype="//data-vocabulary.org/Breadcrumb">
                    <a href="{{ $breadcrumb->url }}" itemprop="url">
                        <span itemprop="title">{{ $breadcrumb->title }}</span>
                    </a>
                </li>
            @else
                <li itemscope="" itemtype="//data-vocabulary.org/Breadcrumb">
                    <span itemprop="title">{{ $breadcrumb->title }}</span>
                </li>
            @endif
        @endforeach
    </ul>
@endunless
