<div class="btn-group" role="group">
    <button type="button" id="button-edit" data-id="{{ $data->id }}" data-toggle="modal" data-target="#addMemberModal" title="Edit" class="btn btn-warning btn-sm button-edit">
        <i class="fa fa-edit"></i>
    </button>
    <button type="button" id="button-delete" data-id="{{ $data->id }}" data-toggle="modal" title="Remove" class="btn btn-danger btn-sm button-delete">
        <i class="fa fa-times"></i>
    </button>
</div>