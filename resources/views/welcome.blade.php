        @extends('layout.app')
        @section('title') Home @endsection
        @section('content')
        <div class="container mt-5">
            <div class="row">
                <div class="col-md-12 ">                       
                    <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#staticBackdrop" >+ Add new</button>
                    <table id="example" class="display" style="width:100%">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Data will be loaded here dynamically -->
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </tfoot>
                    </table>                   
                </div>
            </div>
        </div>

        <!-- Add model Modal -->
        <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="staticBackdropLabel">Add new user</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="userForm">
                            @csrf
                            <div id="responseMessage" class="alert" style="display:none;"></div> <!-- Success/Error message -->
                            <div class="input-group mb-2">
                                <label class="p-2" for="name"> Name </label>
                                <input  type="text" id="name" name="name" required class="form-control" placeholder="type your name">
                            </div>
                            <div class="input-group mb-2">
                                <label class="p-2" for="email">Email</label>
                                <input type="email" id="email" name="email" required class="form-control" placeholder="type your email">
                            </div>
                            <div class="input-group mb-2">
                                <label class="p-2" for="phone">Phone</label>
                                <input type="text" id="phone" name="phone" required class="form-control" placeholder="type your phone number">
                            </div>
                            
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>


        <!-- Update Modal -->
        <div class="modal fade" id="updateUser" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="updateUserLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="updateUserLabel">Update user</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="updateUserForm">
                            @csrf
                            <input type="hidden" name="id" id="userId"> <!-- Hidden input for the user ID -->
                            <div class="input-group mb-2">
                                <label class="p-2" for="updateName">Name</label>
                                <input type="text" id="updateName" name="name" class="form-control" placeholder="type your name">
                            </div>
                            <div class="input-group mb-2">
                                <label class="p-2" for="updateEmail">Email</label>
                                <input type="email" id="updateEmail" name="email" class="form-control" placeholder="type your email">
                            </div>
                            <div class="input-group mb-2">
                                <label class="p-2" for="updatePhone">Phone</label>
                                <input type="text" id="updatePhone" name="phone" class="form-control" placeholder="type your phone number">
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" id="saveUpdate" class="btn btn-primary">Save</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Delete Modal -->
        <div class="modal fade" id="deleteUser" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="deleteUserLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="deleteUserLabel">Remove user</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <h6>Do you want to delete this user?</h6>
                        <form action=""></form>
                        <input type="hidden" id="deleteUserId"> <!-- Hidden input for the user ID -->
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
                        <button type="button" id="confirmDelete" class="btn btn-danger">Yes</button>
                    </div>
                </div>
            </div>
        </div>
        @endsection

