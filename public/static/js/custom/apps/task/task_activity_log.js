//
//
// var target = document.querySelector("#kt_post");
// var blockUI = new KTBlockUI(target);
//
// function editActivityLog(id) {
//     blockUI.block();
//     $.ajax({
//         url: "/tasks/edit/" + id,
//         type: "GET",
//         success: function (data) {
//             console.log(data.activityLog, "hi");
//
//             if (data.activityLog && data.activityLog.length > 0) {
//                 var activityLog = data.activityLog[0];
//                 console.log(activityLog.task_id, "id");
//
//                 $("#id").val(activityLog.id);
//                 $("#task_id").val(activityLog.task_id);
//                 $("#task_note").val(activityLog.task_note);
//                 $("#task_date").val(activityLog.date);
//                 $("#task_attachment").text(activityLog.task_attachment);
//                 $("#edit_type").val(activityLog.task_action);
//                 $("#re_edit_activity_log").modal("show");
//             } else {
//                 // Handle case when activityLog is empty or not found
//             }
//
//             blockUI.release();
//         },
//         error: function () {
//             $("#re_edit_activity_log").modal("hide");
//             blockUI.release();
//         }
//     });
// }
//

function deleteActivityLog(id, task_id){

    Swal.fire({
        html: `Are you sure you want to delete this award?`,
        icon: "question",
        buttonsStyling: false,
        showCancelButton: true,
        confirmButtonText: "Yes!",
        cancelButtonText: 'Nope, cancel it',
        customClass: {
            confirmButton: "btn btn-danger",
            cancelButton: 'btn btn-primary'
        }
    }).then((result) =>{
        if (result.isConfirmed){
            window.location.replace("/task/delete/"+id+"/"+task_id);
        }
    });

}

// add code
// Define form element
const addActivityForm = document.getElementById('re_add_task_log_form');

// Init form validation rules. For more info check the FormValidation plugin's official documentation:https://formvalidation.io/
var addActivityValidator = FormValidation.formValidation(
    addActivityForm,
    {
        fields: {
            'task_note': {
                validators: {
                    notEmpty: {
                        message: 'Task note is required'
                    }
                }
            },
            'task_date': {
                validators: {
                    notEmpty: {
                        message: 'Task date is required '
                    }
                }
            },

            'task_action': {
                validators: {
                    notEmpty: {
                        message: 'Task action is required '
                    }
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
const ActivitySubmitButton = document.getElementById('re_add_task_log_submit');
ActivitySubmitButton.addEventListener('click', function (e) {
    // Prevent default button action
    e.preventDefault();

    // Validate form before submit
    if (addActivityValidator) {
        addActivityValidator.validate().then(function (status) {
            console.log('validated!');

            if (status == 'Valid') {
                // Show loading indication
                ActivitySubmitButton.setAttribute('data-kt-indicator', 'on');

                // Disable button to avoid multiple click
                ActivitySubmitButton.disabled = true;

                // Simulate form submission. For more info check the plugin's official documentation: https://sweetalert2.github.io/
                setTimeout(function () {
                    // Remove loading indication
                    ActivitySubmitButton.removeAttribute('data-kt-indicator');

                    // Enable button
                    ActivitySubmitButton.disabled = false;

                    // Show popup confirmation
                    // Swal.fire({
                    //     text: "Form has been successfully submitted!",
                    //     icon: "success",
                    //     buttonsStyling: false,
                    //     confirmButtonText: "Ok, got it!",
                    //     customClass: {
                    //         confirmButton: "btn btn-primary"
                    //     }
                    // });

                    addActivityForm.submit(); // Submit form
                }, 1500);
            }
        });
    }
});


// follow up
//
const followActivityForm = document.getElementById('re_follow_task_log_form');

// Init form validation rules. For more info check the FormValidation plugin's official documentation:https://formvalidation.io/
var followActivityValidator = FormValidation.formValidation(
    followActivityForm,
    {
        fields: {
            'task_note': {
                validators: {
                    notEmpty: {
                        message: 'Task note is required'
                    }
                }
            },
            'task_date': {
                validators: {
                    notEmpty: {
                        message: 'Task date is required '
                    }
                }
            },

            'task_action': {
                validators: {
                    notEmpty: {
                        message: 'Task action is required '
                    }
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
const FollowSubmitButton = document.getElementById('re_follow_task_log_submit');
FollowSubmitButton.addEventListener('click', function (e) {
    // Prevent default button action
    e.preventDefault();

    // Validate form before submit
    if (followActivityValidator) {
        followActivityValidator.validate().then(function (status) {
            console.log('validated!');

            if (status == 'Valid') {
                // Show loading indication
                FollowSubmitButton.setAttribute('data-kt-indicator', 'on');

                // Disable button to avoid multiple click
                FollowSubmitButton.disabled = true;

                // Simulate form submission. For more info check the plugin's official documentation: https://sweetalert2.github.io/
                setTimeout(function () {
                    // Remove loading indication
                    FollowSubmitButton.removeAttribute('data-kt-indicator');

                    // Enable button
                    FollowSubmitButton.disabled = false;

                    // Show popup confirmation
                    // Swal.fire({
                    //     text: "Form has been successfully submitted!",
                    //     icon: "success",
                    //     buttonsStyling: false,
                    //     confirmButtonText: "Ok, got it!",
                    //     customClass: {
                    //         confirmButton: "btn btn-primary"
                    //     }
                    // });

                    followActivityForm.submit(); // Submit form
                }, 1500);
            }
        });
    }
});


// Attach the onchange event handler to elements with the 'task-status' class
$('.task-status').on('change', function () {
    // Get the full ID from the selected option's ID attribute
    var fullId = $(this).attr('id');
    // Split the ID by the '-status' string to get the original ID
    var log_id = fullId.split('-status')[0];
    // Get the selected value
    var status = $(this).val();
    // Perform actions with the original ID and selected value
    // change status
    const lead_id = '{{$lead->id}}';

    if(status==="Completed"){
        $("#log_id").val(log_id)
        $("#re_complete_activity_modal").modal('show');

    }
    else {
        window.location.replace("/task/status/update/" + log_id + "/" + status + "/" + lead_id);
    }
    // load a modal with form do stuff
    // You can also make AJAX calls or perform other operations here based on the original ID and selected value
});

$('#add_follow_up').on('change', function () {
    if ($(this).is(':checked')) {
        $("#follow_up_div").removeClass('d-none');
        // add
        followActivityValidator.addField('task_date', {
            validators: {
                notEmpty: {
                    message: 'Task date is required'
                }
            }
        });
        followActivityValidator.addField('task_action', {
            validators: {
                notEmpty: {
                    message: 'Task action is required'
                }
            }
        });

    } else {
        $("#follow_up_div").addClass('d-none')
        try{
            followActivityValidator.removeField('task_date');
        }
        catch (err){

        }
        try{
            followActivityValidator.removeField('task_action');
        }
        catch (err){

        }
    }
});
