<div class="btn-group" role="group">
    <a href="{{ route('bargains.edit', $bargain->id) }}" class="btn btn-sm btn-primary">Edit</a>
    <button type="button" class="btn btn-sm btn-warning toggle-status-btn" data-id="{{ $bargain->id }}">
        Toggle Status
    </button>
    <button type="button" class="btn btn-sm btn-danger delete-btn" data-id="{{ $bargain->id }}">
        Delete
    </button>
</div>
