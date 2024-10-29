$(document).ready(function() {
    $('#example').DataTable({
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
});
