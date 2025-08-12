@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Edit Task</h2>

    <form id="task-form" method="POST" action="{{ route('tasks.update', $task) }}">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label>Title</label>
            <input type="text" name="title" class="form-control" maxlength="255" required value="{{ $task->title }}">
            <div class="text-danger" id="error-title"></div>
        </div>

        <div class="mb-3">
            <label>Description</label>
            <textarea name="description" class="form-control" maxlength="1000">{{ $task->description }}</textarea>
            <div class="text-danger" id="error-description"></div>
        </div>

        <div class="mb-3">
            <label>Category</label>
            <select name="category_id" id="category" class="form-select" required>
                <option value="">Select Category</option>
                @foreach($categories as $cat)
                <option value="{{ $cat->id }}" {{ $task->category_id == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                @endforeach
            </select>
            <div class="text-danger" id="error-category_id"></div>
        </div>

        <div class="mb-3">
            <label>SubCategory</label>
            <select name="subcategory_id" id="subcategory" class="form-select" required>
                <option value="">Select SubCategory</option>
                {{-- SubCategories will be loaded dynamically --}}
            </select>
            <div class="text-danger" id="error-subcategory_id"></div>
        </div>

        <div class="mb-3">
            <label>Status</label>
            <select name="status" class="form-select" required>
                <option value="pending" {{ $task->status == 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="in-progress" {{ $task->status == 'in-progress' ? 'selected' : '' }}>In Progress</option>
                <option value="completed" {{ $task->status == 'completed' ? 'selected' : '' }}>Completed</option>
            </select>
            <div class="text-danger" id="error-status"></div>
        </div>

        <div class="mb-3">
            <label>Due Date</label>
            <input type="date" name="due_date" class="form-control" min="{{ date('Y-m-d') }}" required value="{{ $task->due_date->format('Y-m-d') }}">
            <div class="text-danger" id="error-due_date"></div>
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{ route('tasks.index') }}" class="btn btn-secondary">Back</a>
    </form>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(function() {
    function loadSubcategories(selectedId = null) {
        let catId = $('#category').val();
        if(!catId) {
            $('#subcategory').html('<option value="">Select SubCategory</option>');
            return;
        }
        $.get('/categories/' + catId + '/subcategories', function(data) {
            let options = '<option value="">Select SubCategory</option>';
            data.forEach(function(sub) {
                let selected = selectedId == sub.id ? 'selected' : '';
                options += `<option value="${sub.id}" ${selected}>${sub.name}</option>`;
            });
            $('#subcategory').html(options);
        });
    }

    // Load subcategories on page load with selected subcategory
    loadSubcategories({{ $task->subcategory_id }});

    // On category change
    $('#category').change(function() {
        loadSubcategories();
    });

    // AJAX form submit
    $('#task-form').submit(function(e) {
        e.preventDefault();

        $('.text-danger').text('');

        $.ajax({
            url: "{{ route('tasks.update', $task) }}",
            method: 'POST',
            data: $(this).serialize(),
            success: function(res) {
                alert('Task updated successfully!');
                window.location.href = "{{ route('tasks.index') }}";
            },
            error: function(xhr) {
                if(xhr.status === 422) {
                    let errors = xhr.responseJSON.errors;
                    for(let key in errors) {
                        $('#error-' + key).text(errors[key][0]);
                    }
                }
            }
        });
    });
});
</script>
@endsection
