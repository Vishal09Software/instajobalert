@props([
    'id' => null,
    'headers' => [],
    'class' => '',
    'searchable' => true,
    'orderable' => true,
    'paging' => true,
    'pageLength' => 10,
    'lengthMenu' => [10, 25, 50, 100],
    'responsive' => true,
    'scrollX' => false,
    'ajax' => null,
    'serverSide' => false,
])

@php
    $tableId = $id ?? 'datatable_' . uniqid();
@endphp

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table 
                id="{{ $tableId }}" 
                class="table table-striped table-bordered table-hover {{ $class }}"
                style="width:100%"
            >
                <thead>
                    <tr>
                        @foreach($headers as $header)
                            <th>{{ is_array($header) ? ($header['label'] ?? $header['title'] ?? '') : $header }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    {{ $slot }}
                </tbody>
            </table>
        </div>
    </div>
</div>

@push('scripts')
<script>
$(document).ready(function() {
    var tableConfig = {
        paging: {{ $paging ? 'true' : 'false' }},
        searching: {{ $searchable ? 'true' : 'false' }},
        ordering: {{ $orderable ? 'true' : 'false' }},
        pageLength: {{ $pageLength }},
        lengthMenu: @json($lengthMenu),
        @if($responsive)
        responsive: true,
        @endif
        @if($scrollX)
        scrollX: true,
        @endif
        @if($ajax)
        ajax: '{{ $ajax }}',
        @endif
        @if($serverSide)
        processing: true,
        serverSide: true,
        @endif
        language: {
            search: "_INPUT_",
            searchPlaceholder: "Search records...",
            lengthMenu: "Show _MENU_ entries",
            info: "Showing _START_ to _END_ of _TOTAL_ entries",
            infoEmpty: "Showing 0 to 0 of 0 entries",
            infoFiltered: "(filtered from _MAX_ total entries)",
            paginate: {
                first: "First",
                last: "Last",
                next: "Next",
                previous: "Previous"
            }
        },
        dom: '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>rt<"row"<"col-sm-12 col-md-5"i><"col-sm-12 col-md-7"p>>'
    };
    
    $('#{{ $tableId }}').DataTable(tableConfig);
});
</script>
@endpush

