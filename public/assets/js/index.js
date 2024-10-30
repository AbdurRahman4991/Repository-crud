
/**Repository-crud user Create, show, edit, update, delete ajax operation */

// Display data //

$(document).ready(function() {
    
    var table = $('#example').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "/users", 
            type: 'GET', 
        },
        columns: [
            { data: 'name', name: 'name' },
            { data: 'email', name: 'email' },
            { data: 'phone', name: 'phone' },
            { data: 'status', name: 'status' },
            {
                data: null,
                name: 'action',
                render: function(data, type, row) {
                    return `
                        <i data-bs-toggle="modal" data-bs-target="#updateUser" class="fa-solid fa-pen-to-square"></i>
                        <i data-bs-toggle="modal" data-bs-target="#deleteUser" class="fa-solid fa-delete-left text-danger"></i>
                    `;
                },
                orderable: true,
                searchable: true
            }
        ]
    });

    // Add user data //

    $('#userForm').on('submit', function(e) {
        e.preventDefault(); 

        $.ajax({
            url: "/users",  
            type: 'POST',
            data: $(this).serialize(), 
            success: function(response) {
                $('#responseMessage')
                    .removeClass('alert-danger')
                    .addClass('alert-success')
                    .text(response.message)
                    .show(); 

                $('#userForm')[0].reset(); 

                // Reload the DataTable to show the new data
                table.ajax.reload(null, false); 

               
                setTimeout(function() {
                    $('#staticBackdrop').modal('hide'); 
                    $('#responseMessage').hide(); 
                }, 2000);
            },
            error: function(xhr) {                
                $('#responseMessage')
                    .removeClass('alert-success')
                    .addClass('alert-danger')
                    .html(''); 
                $('#responseMessage').text(xhr.responseJSON.message).show();

                if (xhr.responseJSON.errors) {
                    let errors = xhr.responseJSON.errors;
                    for (let field in errors) {
                        let errorMsg = errors[field].join(', ');
                        $('#responseMessage').append('<div>' + errorMsg + '</div>');
                    }
                }
            }
        });
    });

    // Edit User //

    $(document).ready(function() {
        
        $('#example').on('click', '.fa-pen-to-square', function() {
           
            var rowData = table.row($(this).parents('tr')).data();

            $('#userId').val(rowData.id); 
            $('#updateName').val(rowData.name);
            $('#updateEmail').val(rowData.email);
            $('#updatePhone').val(rowData.phone);
            
            $('#updateUser').modal('show');
        });
    
        // Handle the update form submission
        $('#saveUpdate').on('click', function() {
            
            var formData = $('#updateUserForm').serialize();
    
            $.ajax({
                url: "/users/" + $('#userId').val(), 
                type: 'PUT', 
                data: formData,
                success: function(response) {
                    
                    $('#updateUser').modal('hide');
                    table.ajax.reload(null, false); 
                   
                },
                error: function(xhr) {
                   //
                }
            });
        });
    });

    // Update user //

    $(document).ready(function() {
        
        $('#example').on('click', '.fa-pen-to-square', function() {
            
            var rowData = table.row($(this).parents('tr')).data();
    
            
            $('#userId').val(rowData.id); 
            $('#updateName').val(rowData.name);
            $('#updateEmail').val(rowData.email);
            $('#updatePhone').val(rowData.phone);
            
            // Show the modal
            $('#updateUser').modal('show');
        });
    
        
        $('#saveUpdate').on('click', function() {
           
            var formData = $('#updateUserForm').serialize();
    
            $.ajax({
                url: "/users/" + $('#userId').val(), 
                type: 'PUT', 
                data: formData,
                success: function(response) {
                    // Handle success
                    $('#updateUser').modal('hide'); 
                    table.ajax.reload(null, false); 
    
                    $('#responseMessage')
                        .removeClass('alert-danger')
                        .addClass('alert-success')
                        .text(response.message)
                        .show();
                },
                error: function(xhr) {
                    // Handle validation errors
                    $('#responseMessage')
                        .removeClass('alert-success')
                        .addClass('alert-danger')
                        .html(''); // Clear previous messages
                    $('#responseMessage').text(xhr.responseJSON.message).show();
    
                    if (xhr.responseJSON.errors) {
                        let errors = xhr.responseJSON.errors;
                        for (let field in errors) {
                            let errorMsg = errors[field].join(', ');
                            $('#responseMessage').append('<div>' + errorMsg + '</div>');
                        }
                    }
                }
            });
        });
    });

    // Delete User //

    $(document).ready(function() {
  
        $('#example').on('click', '.fa-delete-left', function() {
           
            var rowData = table.row($(this).parents('tr')).data();
                        
            $('#deleteUserId').val(rowData.id); 
                        
            $('#deleteUser').modal('show');
        });
    
        // Handle the confirmation of deletion
        $('#confirmDelete').on('click', function() {
            var userId = $('#deleteUserId').val(); // Get the user ID from the hidden input
    
            $.ajax({
                url: "/users/" + userId, // 
                type: 'DELETE', 
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content') 
                },
                success: function(response) {
                    // Handle success
                    $('#deleteUser').modal('hide'); 
                    table.ajax.reload(null, false); 
                        
                    $('#responseMessage')
                        .removeClass('alert-danger')
                        .addClass('alert-success')
                        .text(response.message)
                        .show();
                },
                error: function(xhr) {
                    
                    $('#responseMessage')
                        .removeClass('alert-success')
                        .addClass('alert-danger')
                        .text('An error occurred while trying to delete the user.')
                        .show();
                }
            });
        });
    });
});
