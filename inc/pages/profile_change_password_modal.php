<!-- Modal -->
<div class="modal fade" id="modalPassword" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="?p=profile_change_password_submit" method="post">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Change Password</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="text_password" class="form-label">New Password:</label>
                        <input type="password" name="text_password" id="text_password" class="form-control" placeholder="Insert your new password" required>
                    </div>
                    <div class="mb-3">
                        <label for="text_password2" class="form-label">Confirm you new password:</label>
                        <input type="password" name="text_password2" id="text_password2" class="form-control" placeholder="Insert your new password" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>