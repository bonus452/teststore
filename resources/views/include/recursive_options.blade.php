@php /** @var \App\Models\Shop\Category $category */ @endphp
@foreach($categories as $category)
    <option value="{{ $category->id }}" {{ $category->getCustomProp('selected') }}>
        @php echo str_repeat('.&nbsp;&nbsp;&nbsp;&nbsp;', $level); @endphp {{ $category->title }}
    </option>
    @include('include.recursive_options', ['categories' => $category->getSubCategories(), 'level' => $level + 1]);
@endforeach
