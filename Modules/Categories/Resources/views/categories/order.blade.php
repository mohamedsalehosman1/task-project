@extends('dashboard::layouts.default')

@section('title')
    @lang('categories::categories.actions.order')
@endsection

@section('content')
    @component('dashboard::layouts.components.page')
        @slot('title', trans('categories::categories.actions.order'))
        @slot('breadcrumbs', ['dashboard.categories.order'])

        <form method="POST" action="{{ route('dashboard.order.categories') }}" id="order-form">
            @csrf
            @component('dashboard::layouts.components.box')
                @slot('title')
                    <i class="fas fa-sort-amount-up-alt"></i>
                     {{ __('categories::categories.messages.drag_drop_title') }}
                @endslot

                <div class="alert alert-info">
                    <i class="fas fa-info-circle"></i>
                   {{ __('categories::categories.messages.drag_info') }}
                </div>

                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover text-center">
                        <thead>
                            <tr>
                                <th width="10%">{{ __('ID') }}</th>
                                <th width="50%">{{ __('categories::categories.attributes.name') }}</th>
                                <th width="30%">{{ __('categories::categories.attributes.type') }}</th>
                                <th width="10%">{{ __('Handle') }}</th>
                            </tr>
                        </thead>
                        <tbody id="sortable-categories">
                            @foreach ($categories as $index => $item)
                                <tr data-id="{{ $item->id }}" class="sortable-row">
                                    <td>{{ $item->id }}</td>
                                    <td>{{ $item->name }}</td>
                                    <td>{{ $item->type }}</td>
                                    <td>
                                        <i class="fas fa-grip-vertical drag-handle" style="cursor: move; color: #6c757d;"></i>
                                    </td>
                                    <input type="hidden" name="categories[]" value="{{ $item->id }}" class="category-order">
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                @slot('footer')
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i>
                          {{ __('categories::categories.actions.save_order') }}
                    </button>
                    <a href="{{ route('dashboard.categories.index') }}" class="btn btn-secondary">
                        {{ __('categories::categories.actions.cancel') }}
                    </a>
                @endslot
            @endcomponent
        </form>

    @endcomponent
@endsection

@push('css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.13.2/themes/ui-lightness/jquery-ui.min.css">
<style>
    .sortable-row {
        cursor: move;
        transition: background-color 0.2s ease;
    }
    
    .sortable-row:hover {
        background-color: #f8f9fa !important;
    }
    
    .ui-sortable-helper {
        background-color: #e3f2fd !important;
        box-shadow: 0 4px 12px rgba(0,0,0,0.15) !important;
        transform: rotate(2deg);
    }
    
    .ui-sortable-placeholder {
        background-color: #fff3cd !important;
        border: 2px dashed #ffc107 !important;
        height: 60px !important;
        visibility: visible !important;
    }
    
    .drag-handle {
        font-size: 18px;
        padding: 10px;
    }
    
    .drag-handle:hover {
        color: #007bff !important;
        cursor: move;
    }
    
    #sortable-categories {
        min-height: 100px;
    }
</style>
@endpush

@push('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.13.2/jquery-ui.min.js"></script>
<script>
$(document).ready(function() {
    console.log('Initializing sortable...');
    
    // Initialize sortable
    $("#sortable-categories").sortable({
        handle: ".drag-handle", // Only drag by the handle
        placeholder: "ui-sortable-placeholder",
        axis: "y", // Only allow vertical sorting
        containment: "parent",
        tolerance: "pointer",
        helper: function(e, ui) {
            // Preserve table width
            ui.children().each(function() {
                $(this).width($(this).width());
            });
            ui.addClass('ui-sortable-helper');
            return ui;
        },
        start: function(e, ui) {
            console.log('Sort started');
            ui.placeholder.height(ui.item.height());
        },
        update: function(event, ui) {
            console.log('Sort updated');
            updateCategoryInputs();
        },
        stop: function(e, ui) {
            console.log('Sort stopped');
            // Remove any temporary classes
            ui.item.removeClass('ui-sortable-helper');
        }
    }).disableSelection();

    // Function to update hidden inputs after sorting
    function updateCategoryInputs() {
        var newOrder = [];
        
        $('#sortable-categories tr').each(function(index) {
            var categoryId = $(this).data('id');
            newOrder.push(categoryId);
            
            // Update the hidden input value and name
            $(this).find('.category-order').val(categoryId);
            $(this).find('.category-order').attr('name', 'categories[' + index + ']');
        });
        
        console.log('New order:', newOrder);
    }

    // Test if sortable is working
    if ($("#sortable-categories").hasClass('ui-sortable')) {
        console.log('Sortable initialized successfully');
    } else {
        console.log('Sortable failed to initialize');
    }

    // Form submission handler
    $('#order-form').on('submit', function(e) {
        console.log('Form submitting...');
        
        // Make sure inputs are updated before submission
        updateCategoryInputs();
        
        // Log what's being sent
        var formData = $(this).serializeArray();
        console.log('Form data:', formData);
    });
});
</script>
@endpush