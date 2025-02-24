@props(['name', 'id', 'ariaLabel', 'options', 'selected', 'class' => ''])

<div class="custom-select-wrapper">
    <select
        name="{{ $name }}"
        id="{{ $id }}"
        aria-label="{{ $ariaLabel }}"
        class="custom-select {{ $class }}"
    >
        @foreach($options as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }}>
                {{ $label }}
            </option>
        @endforeach
    </select>
    <span class="custom-select-icon">
        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none"
             stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <polyline points="6 9 12 15 18 9"></polyline>
        </svg>
    </span>
</div>

@push('scripts')
    <script>
        $(function(){
            $(".custom-select").change(function(){
                if ($(this).attr('name') === 'pagesize') {
                    $("#size").val($(this).val());
                }
                $("#filter-form").submit();
            });
        })
    </script>
@endpush
