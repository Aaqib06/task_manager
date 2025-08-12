@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Create Task</h2>

    <form id="task-form" method="POST" action="{{ route('tasks.store') }}">
        @csrf
        <div class="mb-3">
            <label>Title</label>
            <input type="text" name="title" class="form-control" maxlength="255" required>
            <div class="text-danger" id="error-title"></div>
        </div>

        <div class="mb-3">
            <label>Description</label>
            <textarea name="description" class="form-control" maxlength="1000"></textarea>
            <div class="text-danger" id="error-description"></div>
        </div>

        <div class="mb-3">
            <label>Category</label>
            <select name="category_id" id="category" class="form-select" required>
                <option value="">Select Category</option>
                @foreach($categories as $cat)
                <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                @endforeach
            </select>
            <div class="text-danger" id="error-category_id"></div>
        </div>

        <div class="mb-3">
            <label>SubCategory</label>
            <select name="subcategory_id" id="subcategory" class="form-select" required>
                <option value="">Select SubCategory</option>
            </select>
            <div class="text-danger" id="error-subcategory_id"></div>
        </div>

        <div class="mb-3">
            <label>Status</label>
            <select name="status" class="form-select" required>
                <option value="pending" selected>Pending</option>
                <option value="in-progress">In Progress</option>
                <option value="completed">Completed</option>
            </select>
            <div class="text-danger" id="error-status"></div>
        </div>

        <div class="mb-3">
            <label>Due Date</label>
            <input type="date" name="due_date" class="form-control" min="{{ date('Y-m-d') }}" required>
            <div class="text-danger" id="error-due_date"></div>
        </div>

        <button type="submit" class="btn btn-primary">Create</button>
        <a href="{{ route('tasks.index') }}" class="btn btn-secondary">Back</a>
    </form>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(function() {
    // Load subcategories on category change
    $('#category').change(function() {
        let catId = $(this).val();
        if(!catId) {
            $('#subcategory').html('<option value="">Select SubCategory</option>');
            return;
        }
        $.get('/categories/' + catId + '/subcategories', function(data) {
            let options = '<option value="">Select SubCategory</option>';
            data.forEach(function(sub) {
                options += `<option value="${sub.id}">${sub.name}</option>`;
            });
            $('#subcategory').html(options);
        });
    });

    // AJAX form submit
    $('#task-form').submit(function(e) {
        e.preventDefault();

        $('.text-danger').text('');

        $.ajax({
            url: "{{ route('tasks.store') }}",
            method: 'POST',
            data: $(this).serialize(),
            success: function(res) {
                alert('Task created successfully!');
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
