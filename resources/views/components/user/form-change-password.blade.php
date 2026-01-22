<div>
<!-- Modal -->
<div class="modal fade" id="formChangePassword" tabindex="-1" aria-labelledby="formChangePasswordLabel" aria-hidden="true">
  <form action="{{ route('users.change-password') }}" method="POST">
  @csrf
    <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="formChangePasswordLabel">Form Change Password</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="form-group my-1">
            <label for="">Current Password</label>
            <input type="password" name="current_password" id="current_password" class="form-control">
        </div>
        <div class="form-group my-1">
            <label for="">New Password</label>
            <input type="password" name="password" id="password" class="form-control">
        </div>
        <div class="form-group my-1">
            <label for="">New Password Confirmation</label>
            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control">
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Change Password</button>
      </div>
    </div>
  </div>
</div>
</div>