@extends('layouts.master')
<style>
    table, th, td {
        border: 1px solid black;
        border-collapse: collapse;
        font-size: 12px;
    }
    table {
        border: 2px solid black;
    }
    th, td {
        padding: 2px;
        padding-top: 2px;
        padding-bottom: 2px;
        text-align: center;
    }
</style>
@section('content')
@push('scripts')
    <script>
        $(document).ready(function () {
            $('[data-toggle="tooltip"]').tooltip(); //Tooltip on icons top

            $('.popoverOption').each(function () {
                var $this = $(this);
                $this.popover({
                    trigger: 'hover',
                    placement: 'left',
                    container: $this,
                    html: true,

                });
            });
        });
    </script>
@endpush
    <div class="div">
        <div class="row">
            @include('partials.dashboardthree')
            @include('partials.dashboardfour')
        </div>
    </div>
@endsection
