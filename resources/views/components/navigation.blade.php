<nav aria-labelledby="ibm-pagetitle-h1" role="navigation">
    <div class="ibm-parent" id="ibm-navigation">
         <ul aria-labelledby="ibm-pagetitle-h1" role="tree" id="ibm-primary-links">
            @foreach ($menuList as $key => $value)
            	@isset($value['route'])
                    @if (is_array($value['route']))
                    	<li role="presentation" @isset($value['expanded']) aria-expanded="true" @endisset>
                        	<span class="ibm-subnav-heading @isset($value['expanded']) ibm-textcolor-red-50 @endisset">{{ $key }}</span>
                        	<ul role="group">
                        		@foreach ($value['route'] as $subKey => $subValue)
                        			@isset($subValue['route'])
                        				@if (is_array($subValue['route']))
                            				<li role="presentation" @isset($subValue['expanded']) aria-expanded="true" @endisset>
                            					<span class="ibm-subnav-heading @isset($subValue['expanded']) ibm-textcolor-red-50 @endisset" style="padding-left: 10px;">{{ $subKey }}</span>
                            					<ul role="group">
                            						@foreach ($subValue['route'] as $subSubKey => $subSubValue)
                            							@isset($subSubValue['route'])
                                                        	<li role="presentation">
                                                                @if(isset($subSubValue['param']))
                                                                    <a href="{{ route($subSubValue['route'], $subSubValue['param']) }}" role="treeitem" @isset($subSubValue['selected']) aria-selected="true" @endisset>{{ $subSubKey }}</a>
                                                                @else
                                                                    <a href="{{ route($subSubValue['route']) }}" role="treeitem" @isset($subSubValue['selected']) aria-selected="true" @endisset>{{ $subSubKey }}</a>
                                                                @endif
                                                            </li>
                            							@endisset
                            						@endforeach
                            					</ul>
                            				</li>
                            			@else
                                            <li role="presentation">
                                                @if(isset($subValue['param']))
                                                    <a href="{{ route($subValue['route'], $subValue['param']) }}" role="treeitem" @isset($subValue['selected']) aria-selected="true" @endisset>{{ $subKey }}</a>
                                                @else
                                                    <a href="{{ route($subValue['route']) }}" role="treeitem" @isset($subValue['selected']) aria-selected="true" @endisset>{{ $subKey }}</a>
                                                @endif
                                            </li>
                            			@endif
                        			@endisset
                        		@endforeach
                        	</ul>
                        <li>
                    @else
                    	<li @if ($loop->first) id="ibm-overview" @endif role="presentation">
                            @if(isset($value['param']))
                                <a href="{{ route($value['route'], $value['param']) }}" role="treeitem" @isset($value['selected']) aria-selected="true" @endisset>{{ $key }}</a>
                            @else
                                <a href="{{ route($value['route']) }}" role="treeitem" @isset($value['selected']) aria-selected="true" @endisset>{{ $key }}</a>
                            @endif
                        </li>
                    @endif
                @endisset
            @endforeach
		</ul>
        <div id="ibm-secondary-navigation">
           	<h2>Related links</h2>
            <ul id="ibm-related-links">
                <li role="presentation"><a href="https://kyndryl.sharepoint.com/sites/ServiceAcceptanceChecklist">Service Acceptance Checklist Guidance</a></li>
            </ul>
        </div>
    </div>
</nav>
