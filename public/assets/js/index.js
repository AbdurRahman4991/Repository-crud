$(document).ready(function() {
    // Initialize the DataTable and save it to a variable
    var table = $('#example').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "/users", // Ensure this is the correct URL for your route
            type: 'GET', // Use the correct request type
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
        e.preventDefault(); // Prevent the default form submission

        $.ajax({
            url: "/users",  // The URL to send the data to
            type: 'POST',
            data: $(this).serialize(), // Serialize the form data
            success: function(response) {
                $('#responseMessage')
                    .removeClass('alert-danger')
                    .addClass('alert-success')
                    .text(response.message)
                    .show(); // Show success message

                $('#userForm')[0].reset(); // Reset the form fields

                // Reload the DataTable to show the new data
                table.ajax.reload(null, false); // Pass `false` to not reset the paging

                // Close the modal after a short delay
                setTimeout(function() {
                    $('#staticBackdrop').modal('hide'); // Close the modal
                    $('#responseMessage').hide(); // Hide the message
                }, 2000);
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

    // Edit User //

    $(document).ready(function() {
        // Other existing code...
    
        // Handle the edit button click
        $('#example').on('click', '.fa-pen-to-square', function() {
            // Get user data from the clicked row
            var rowData = table.row($(this).parents('tr')).data();
    
            // Populate the modal fields
            $('#userId').val(rowData.id); // Assuming 'id' is part of your user data
            $('#updateName').val(rowData.name);
            $('#updateEmail').val(rowData.email);
            $('#updatePhone').val(rowData.phone);
            
            // Show the modal
            $('#updateUser').modal('show');
        });
    
        // Handle the update form submission
        $('#saveUpdate').on('click', function() {
            // Get the data from the form
            var formData = $('#updateUserForm').serialize();
    
            $.ajax({
                url: "/users/" + $('#userId').val(), // Adjust the URL according to your update route
                type: 'PUT', // Use PUT for update
                data: formData,
                success: function(response) {
                    // Handle success
                    $('#updateUser').modal('hide');
                    table.ajax.reload(null, false); // Reload the DataTable without resetting paging
                    // Show success message if needed
                },
                error: function(xhr) {
                    // Handle validation errors
                    // Similar to the add function error handling
                }
            });
        });
    });

    // Update user //

    $(document).ready(function() {
        // Other existing code...
    
        // Handle the edit button click
        $('#example').on('click', '.fa-pen-to-square', function() {
            // Get user data from the clicked row
            var rowData = table.row($(this).parents('tr')).data();
    
            // Populate the modal fields
            $('#userId').val(rowData.id); // Assuming 'id' is part of your user data
            $('#updateName').val(rowData.name);
            $('#updateEmail').val(rowData.email);
            $('#updatePhone').val(rowData.phone);
            
            // Show the modal
            $('#updateUser').modal('show');
        });
    
        // Handle the update form submission
        $('#saveUpdate').on('click', function() {
            // Get the data from the form
            var formData = $('#updateUserForm').serialize();
    
            $.ajax({
                url: "/users/" + $('#userId').val(), // Adjust the URL according to your update route
                type: 'PUT', // Use PUT for update
                data: formData,
                success: function(response) {
                    // Handle success
                    $('#updateUser').modal('hide'); // Hide the modal
                    table.ajax.reload(null, false); // Reload the DataTable without resetting paging
    
                    // Optionally, show a success message
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
        // Other existing code...
    
        // Handle the delete button click
        $('#example').on('click', '.fa-delete-left', function() {
            // Get user data from the clicked row
            var rowData = table.row($(this).parents('tr')).data();
            
            // Set the user ID to the hidden input in the modal
            $('#deleteUserId').val(rowData.id); 
            
            // Show the delete confirmation modal
            $('#deleteUser').modal('show');
        });
    
        // Handle the confirmation of deletion
        $('#confirmDelete').on('click', function() {
            var userId = $('#deleteUserId').val(); // Get the user ID from the hidden input
    
            $.ajax({
                url: "/users/" + userId, // Adjust the URL according to your delete route
                type: 'DELETE', // Use DELETE for the delete request
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content') // Manually add token
                },
                success: function(response) {
                    // Handle success
                    $('#deleteUser').modal('hide'); // Hide the modal
                    table.ajax.reload(null, false); // Reload the DataTable without resetting paging
    
                    // Optionally, show a success message
                    $('#responseMessage')
                        .removeClass('alert-danger')
                        .addClass('alert-success')
                        .text(response.message)
                        .show();
                },
                error: function(xhr) {
                    // Handle error, e.g., show an error message
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
