$(document).ready(function() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    loadEmployees();

    $("#add_employee_link").click(function() {
        $.ajax({
            type: 'GET',
            url: 'employee/create',
            success: function (response) {
                $("#employee_modal_div").empty();
                $('#employee_modal_div').append(response);
                $('#add_employee').modal('show');
            },
            error: function(error) { 
                console.log(error);
            }
        });
    });

    $(document).on('click', '#create_employee_btn', function(e) {
        $(".employee-error-text").empty();
        var formData = new FormData();
        let hobbies = [];
        $('input[name="hobbies"]:checked').each(function() {
            hobbies.push(this.value);
        });

        formData.append('name', $("#name").val());
        formData.append('contact_no', $("#contact_no").val());
        formData.append('hobbies', hobbies);
        formData.append('category', $("#category").val());
        formData.append('profile_pic', $('#profile_pic')[0].files[0]);
    
        $.ajax({
            type: 'POST',
            url: 'employee',
            data: formData,
            contentType: false,
            processData: false,
            success: function (response) {
                if (response.success == true) {
                    $('#add_employee').modal('hide');
                    sweetAlertModal('success', 'Success');
                    loadEmployees();
                } else {
                    if (response.errors) {
                        showErrors(response.errors);
                    }
                }
            },
            error: function(error) {
                sweetAlertModal('error', 'Failed');
            }
        });
    });
});

function loadEmployees() {
    $.ajax({
        type: 'GET',
        url: 'employee/load-table',
        success: function (response) {
            $("#employee_list_table").empty();
            $('#employee_list_table').append(response);
            $(".edit_mode").hide();
        },
        error: function(error) { 
            console.log(error);
        }
    });
}

function deleteEmployee(employee_id) {
    destroyEmployees([employee_id]);
}

function bulkDeleteEmployees() {
    let employees = [];
    $('input[name="employees"]:checked').each(function() {
        employees.push(this.value);
    });
    destroyEmployees(employees);
}

function destroyEmployees(employee_ids = []) {
    swal.fire({
        title: 'Are you sure?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes'
        }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                type: 'POST',
                url: 'employee/bulk-delete',
                data: { 'employee_ids' : employee_ids},
                success: function (response) {
                    if (response.success == true) {
                        sweetAlertModal('success', 'Deleted');
                        loadEmployees();
                    } else {
                        sweetAlertModal('error', 'Failed to Delete');
                    }
                },
                error: function(error) { 
                    sweetAlertModal('error', 'Failed to Delete');
                }
            });
        }
    })
}

function update(employee_id) {
    $(".employee-error-text").empty();
        var formData = new FormData();
        let hobbies = [];
        $('input[name=hobbies_' + employee_id + ']:checked').each(function() {
            hobbies.push(this.value);
        });

        formData.append('name', $("#name_" + employee_id).val());
        formData.append('contact_no', $("#contact_no_" + employee_id).val());
        formData.append('hobbies', hobbies);
        formData.append('category', $("#category_" + employee_id).val());
        formData.append('profile_pic', $('#profile_pic_' + employee_id)[0].files[0]);
        formData.append('_method', 'PUT');
    
        $.ajax({
            type: 'POST',
            url: 'employee/' + employee_id,
            data: formData,
            contentType: false,
            processData: false,
            success: function (response) {
                if (response.success == true) {
                    sweetAlertModal('success', 'Updated');
                    loadEmployees();
                } else {
                    if (response.errors) {
                        showErrors(response.errors, employee_id);
                    }
                }
            },
            error: function(error) {
                sweetAlertModal('error', 'Failed');
            }
        });
}

function showErrors(errors, employee_id = null) {
    $.each(errors, function(field, error) {
        if (employee_id) {
            $("#error-" + field + '_' + employee_id).text(error);
        } else {
            $("#error-" + field).text(error);
        }
    });
}

function edit(employee_id) {
    $(".edit_mode-" + employee_id).show();
    $(".view_mode-" + employee_id).hide();
}

function sweetAlertModal(icon_type, title) {
    swal.fire({
        position: 'top-end',
        icon: icon_type,
        title: title,
        showConfirmButton: false,
        timer: 2000
    })
}