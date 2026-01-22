<div>
    <button type="button" class="btn {{ $id ? 'btn-warning' : 'btn-primary' }}" data-toggle="modal" data-target="#formCategory{{ $id ?? '' }}">
           @if ($id)
              <i class="fas fa-edit"></i>  
              @else
              New Category
            @endif
    </button>
     <div class="modal fade" id="formCategory{{ $id ?? '' }}">
        <form action="{{ route('master-data.category.store') }}" method="POST">
            @csrf
            <input type="hidden" name="id" value="{{ $id }}">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">{{ $id ? 'Form Edit Category' : 'Form New Category' }}</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
             
                <div class="form-group">
                    <label for="">Category Name</label>
                    <input type="text" name="nama_category" id="nama_category" class="form-control" value="{{ $nama_category }}">
                </div>
                <div>
                    <label for="">Description</label>
                    <textarea name="description" id="description" cols="30" rows="10" class="form-control">{{ $description }}</textarea>
                </div>
             
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary">Save changes</button>
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
        </form>
      </div>
      <!-- /.modal -->
</div>