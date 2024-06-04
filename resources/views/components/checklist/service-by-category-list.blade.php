@isset($mainCategories)
    @foreach ($mainCategories as $key => $category)
       <x-checklist.service-overview :record="$category" />
    @endforeach
@endisset
