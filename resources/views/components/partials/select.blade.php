@props(['size'])
<div class="custom-select-wrapper me-3">
    <select class="custom-select" aria-label="Page Size" id="pageSize" name="pagesize">
        <option value="" disabled selected>Show</option>
        <option value="12" {{ $size == '12' ? 'selected' : '' }}>12 items</option>
        <option value="24" {{ $size == '24' ? 'selected' : '' }}>24 items</option>
        <option value="48" {{ $size == '48' ? 'selected' : '' }}>48 items</option>
        <option value="102" {{ $size == '102' ? 'selected' : '' }}>102 items</option>
    </select>
    <span class="custom-select-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none"
                                     stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <polyline points="6 9 12 15 18 9"></polyline>
                                </svg>
                            </span>
</div>
