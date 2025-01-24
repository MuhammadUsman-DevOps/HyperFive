// Define form element
const addTaxClassForm = document.getElementById('add_new_tax_class_modal_form');

// Init form validation rules. For more info check the FormValidation plugin's official documentation:https://formvalidation.io/
var addTaxClassValidator = FormValidation.formValidation(
    addTaxClassForm,
    {
        fields: {
            'name': {
                validators: {
                    notEmpty: {
                        message: 'Class name is required'
                    }
                }
            },
            'card_percentage': {
                validators: {
                    notEmpty: {
                        message: 'value is required'
                    }
                }
            },
            'cash_percentage': {
                validators: {
                    notEmpty: {
                        message: 'value is required'
                    },

                }
            },


        },

        plugins: {
            trigger: new FormValidation.plugins.Trigger(),
            bootstrap: new FormValidation.plugins.Bootstrap5({
                rowSelector: '.fv-row',
                eleInvalidClass: '',
                eleValidClass: ''
            })
        }
    }
);


// Submit button handler
const TaxClassSubmitButton = document.getElementById('add_new_tax_class_modal_submit');
TaxClassSubmitButton.addEventListener('click', function (e) {
    // Prevent default button action
    e.preventDefault();

    // Validate form before submit
    if (addTaxClassValidator) {
        addTaxClassValidator.validate().then(function (status) {
            console.log('validated!');

            if (status == 'Valid') {
                // Show loading indication
                TaxClassSubmitButton.setAttribute('data-kt-indicator', 'on');

                // Disable button to avoid multiple click
                TaxClassSubmitButton.disabled = true;

                // Simulate form submission. For more info check the plugin's official documentation: https://sweetalert2.github.io/
                addTaxClassForm.submit();
            }
        });
    }
});

/* Code to search and update result without ajax call*/

$(document).ready(function(){
    $("#searchTaxClass").on("keyup", function() {
        var value = $(this).val().toLowerCase();
        $(".row.mt-5 .col-xl-3").filter(function() {
            $(this).toggle($(this).find('a').text().toLowerCase().indexOf(value) > -1)
        });
    });
});

/* Code to search and update result with AJAX call*/
// $(document).ready(function () {
//     $("#searchTaxClassAjax").on("keyup", function () {
//         var value = $(this).val();
//
//         // Display the loader
//         $("#loader").show();
//
//         // Simulate AJAX call to server
//         $.ajax({
//             url: "/searchTaxClasses", // The backend endpoint
//             type: "GET",
//             data: {
//                 query: value // Search query
//             },
//             success: function (data) {
//                 // Process and display the fetched data
//                 // This will vary based on your data structure
//                 // For example, if data is an array of tax class names:
//                 var content = '';
//                 $.each(data, function (index, taxClass) {
//                     content += '<div class="col-xl-3 col-lg-3 col-md-3 col-sm-3">' +
//                         '<div class="card rounded ...">' +
//                         '<a href="#" class="...">' + taxClass.name + '</a>' +
//                         '</div>' +
//                         '</div>';
//                 });
//                 $(".row.mt-5").html(content);
//
//                 // Hide the loader
//                 $("#loader").hide();
//             },
//             error: function () {
//                 // Handle errors
//                 // Hide the loader
//                 $("#loader").hide();
//                 alert("Failed to fetch data. Please try again.");
//             }
//         });
//     });
// });




// Edit TaxClass Code


// Define form element
const editTaxClassForm = document.getElementById('edit_tax_class_modal_form');

// Init form validation rules. For more info check the FormValidation plugin's official documentation:https://formvalidation.io/
var editTaxClassFormValidator = FormValidation.formValidation(
    editTaxClassForm,
    {
        fields: {
            'name': {
                validators: {
                    notEmpty: {
                        message: ' name is required'
                    }
                }
            },
            'card_percentage': {
                validators: {
                    notEmpty: {
                        message: 'value is required'
                    }
                }
            },
            'cash_percentage': {
                validators: {
                    notEmpty: {
                        message: 'value is required'
                    },

                }
            },



        },

        plugins: {
            trigger: new FormValidation.plugins.Trigger(),
            bootstrap: new FormValidation.plugins.Bootstrap5({
                rowSelector: '.fv-row',
                eleInvalidClass: '',
                eleValidClass: ''
            })
        }
    }
);


// Submit button handler
const editTaxClassSubmitButton = document.getElementById('edit_tax_class_modal_submit');
editTaxClassSubmitButton.addEventListener('click', function (e) {
    // Prevent default button action
    e.preventDefault();

    // Validate form before submit
    if (editTaxClassFormValidator) {
        editTaxClassFormValidator.validate().then(function (status) {
            console.log('validated!');

            if (status == 'Valid') {
                // Show loading indication
                editTaxClassSubmitButton.setAttribute('data-kt-indicator', 'on');

                // Disable button to avoid multiple click
                editTaxClassSubmitButton.disabled = true;
                editTaxClassForm.submit();

            }
        });
    }
});

var target = document.querySelector("#kt_body");
var blockUI = new KTBlockUI(target, {
    message: '<div class="blockui-message"><span class="spinner-border text-primary"></span> Loading...</div>',
});

function editTaxClass(id) {
    blockUI.block();
    // Send AJAX request to server
    $.ajax({
        url: '/tax-class/edit/' + id,
        type: 'GET',
        dataType: 'json',
        success: function(response) {
            if(response.data){
                $('#edit_tax_class_modal_form input[name="name"]').val(response.data.name);
                $('#edit_tax_class_modal_form input[name="id"]').val(response.data.id);
                $('#edit_tax_class_modal_form input[name="cash_percentage"]').val(response.data.cash_percentage);
                $('#edit_tax_class_modal_form input[name="card_percentage"]').val(response.data.card_percentage);

                $('#edit_tax_class_modal_form input[name="is_active"]').prop('checked', response.data.is_active);
                blockUI.release();
                // Show the modal form
                $('#edit_tax_class_modal').modal('show');
            }else{
                blockUI.release();
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'No TaxClass data found!',
                    buttonsStyling: !1,
                    confirmButtonText: "Oh! ok :(",
                    customClass: {confirmButton: "btn btn-primary"}
                });
            }

        },
        error: function(xhr, status, error) {
            blockUI.release();
            console.error(error);
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Something went wrong',
            });
        }
    });
}


function deleteTaxClass(id) {
    Swal.fire({
        title: 'Are you sure?',
        text: 'You will not be able to recover this TaxClass!',
        icon: 'warning',
        confirmButtonText: 'Yes, delete it!',
        showCancelButton: true,
        buttonsStyling: !1,
        cancelButtonText: "No, return",
        customClass: {confirmButton: "btn btn-primary", cancelButton: "btn btn-active-light"}
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = '/tax-class/delete/' + id
        }
    });
}


function deactivateTaxClass(id) {
    Swal.fire({
        title: 'Are you sure?',
        text: 'customers wont be able to see this TaxClass',
        icon: 'warning',
        confirmButtonText: 'Yes, deactivate it!',
        showCancelButton: true,
        buttonsStyling: !1,
        cancelButtonText: "No, return",
        customClass: {confirmButton: "btn btn-primary", cancelButton: "btn btn-active-light"}
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = '/tax-class/deactivate/' + id
        }else {
            // If user cancels, check the checkbox again
            $('#taxid_' + id).prop('checked', true);
        }
    });
}

function activateTaxClass(id) {
    Swal.fire({
        title: 'Are you sure?',
        text: 'customers will be able to see this TaxClass',
        icon: 'warning',
        confirmButtonText: 'Yes, Activate it!',
        showCancelButton: true,
        buttonsStyling: !1,
        cancelButtonText: "No, return",
        customClass: {confirmButton: "btn btn-primary", cancelButton: "btn btn-active-light"}
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = '/tax-class/activate/' + id
        }else{
            // If user cancels, check the checkbox again
            $('#taxid_' + id).prop('checked', true);
        }
    });
}


$(document).ready(function() {

    $('[id^=taxid_]').change(function() {
        var id = $(this).attr('id').split('_')[1];
        if ($(this).is(':checked')) {
            activateTaxClass(id);

        } else {
            deactivateTaxClass(id);
        }
    });
});

