"use strict";
var KTModalTrackOrderNumber = function () {
    var e, t, o, r;
    return {
        init: function () {
            o = KTModalTrackOrder.getForm(), r = KTModalTrackOrder.getStepperObj(), e = KTModalTrackOrder.getStepper().querySelector('[data-kt-element="type-next"]'), t = FormValidation.formValidation(o, {
                fields: {
                    order_number: {validators: {notEmpty: {message: "Please enter your order number"}}},
                },
                plugins: {
                    trigger: new FormValidation.plugins.Trigger,
                    bootstrap: new FormValidation.plugins.Bootstrap5({
                        rowSelector: ".fv-row",
                        eleInvalidClass: "",
                        eleValidClass: ""
                    })
                }
            }), e.addEventListener("click", function (o) {
                o.preventDefault();
                e.disabled = true;


                t && t.validate().then(function (t) {
                    console.log("validated!");
                    if ("Valid" == t) {
                        e.setAttribute("data-kt-indicator", "on");

                        $.ajax({
                            url: '/order/track',
                            method: 'GET',
                            data: {
                                order_number: $("#order_number").val()
                            },
                            success: function (response) {
                                // Handle response
                                console.log('AJAX call successful:', response);
                                var deliveryAddress = JSON.parse(response.order.delivery_address);
                                var date = new Date(response.order.order_date);
                                var options = {
                                    hour: 'numeric',
                                    minute: 'numeric',
                                    hour12: true
                                };

                                var formattedDate = date.toLocaleString('en-US', options);

                                $('#orderDate').text(formattedDate);

                                var deliveryDuration = 45;
                                var deliveryTime = new Date(date.getTime() + deliveryDuration * 60000);
                                var now = new Date();
                                var timeLeftMs = deliveryTime - now;
                                console.log(timeLeftMs);
                                if (timeLeftMs > 0) {
                                    var minutesLeft = Math.floor(timeLeftMs / 60000);
                                    $('#estimatedTimeLeft').text(minutesLeft + ' min ');
                                }


                                // Update order details
                                $('#orderNumber').text(response.order.order_number);
                                $('#totalAmount').text(response.order.amount_to_pay);
                                $('#location').text(deliveryAddress.location);
                                $('#houseNumber').text(deliveryAddress.house_number);
                                $('#streetNumber').text(deliveryAddress.street_number);
                                $('#landmark').text(deliveryAddress.landmark);
                                $('#phone').text(deliveryAddress.phone);
                                $('#name').text(deliveryAddress.name);

                                // Prepare and populate the timeline
                                var $timeline = $('#timeline');
                                $timeline.empty(); // Clear existing timeline items if any

                                var lastActiveStatus = null; // To store the last active status data

                                $.each(response.statuses, function (index, status) {
                                    if (status.name !== "Served" && status.name !== "Cancelled") {  // Skip appending the "Served" status
                                        var isActive = ''; // Default inactive class

                                        // Check if this status is the active one
                                        $.each(response.order.order_status, function (status_index, order_status) {
                                            if (status.id === order_status.status_id) {
                                                isActive = ' active';
                                                // Store the last active status data
                                                lastActiveStatus = {
                                                    name: status.name,
                                                    description: status.description
                                                };
                                            }
                                        });

                                        // Append to timeline once per status, not per order_status match
                                        $timeline.append(
                                            '<li class="' + isActive + '">' +
                                            '<h6 class="mb-20">' + status.name + '</h6>' +
                                            '<p class="mb-0 text-muted"></p>' +
                                            '</li>'
                                        );
                                    }
                                });

                                // Update the UI with the last active status found, if any
                                if (lastActiveStatus) {
                                    $("#status").text(lastActiveStatus.name);
                                    $("#comment").text(lastActiveStatus.description);
                                }


                                e.removeAttribute("data-kt-indicator");
                                e.disabled = false;
                                // initTrackingMap(Number(response.order.branch.latitude), Number(response.order.branch.longitude), Number(deliveryAddress.latitude), Number(deliveryAddress.longitude));
                                r.goNext();
                            },
                            error: function (xhr, status, error) {
                                // Handle errors
                                console.log('AJAX call failed:', status, error);
                                alert(error);
                                e.removeAttribute("data-kt-indicator");
                                e.disabled = false;
                            }
                        });

                    } else {
                        e.disabled = false;
                        Swal.fire({
                            text: "Sorry, looks like there are some errors detected, please try again.",
                            icon: "error",
                            buttonsStyling: false,
                            confirmButtonText: "Ok, got it!",
                            customClass: {confirmButton: "btn btn-primary"}
                        });
                    }
                });
            });

        }
    }
}();
"undefined" != typeof module && void 0 !== module.exports && (window.KTModalTrackOrderNumber = module.exports = KTModalTrackOrderNumber);


function initTrackingMap(branchLat, branchLong, lat, long) {
    var baseUrl = window.location.origin;
    var restaurantIcon = {
        url: baseUrl + '/static/media/icons/rider.png',
        scaledSize: new google.maps.Size(60, 60)
    };
    var customerIcon = {
        url: baseUrl + '/static/media/icons/house.png',
        scaledSize: new google.maps.Size(30, 30)
    };
    // Define the coordinates
    var start = {lat: branchLat, lng: branchLong};
    var end = {lat: lat, lng: long};
    // Initialize the map
    var trackingMap = new google.maps.Map(document.getElementById('tracking_map'), {
        zoom: 15,
        center: start,
        disableDefaultUI: true
    });

    // Define the path
    var path = [start, end];

    // Draw the line
    var polyline = new google.maps.Polyline({
        path: path,
        geodesic: true,
        strokeColor: '#FF0000',
        strokeOpacity: 1.0,
        strokeWeight: 2
    });

    polyline.setMap(trackingMap);

    // Add markers at start and end points
    var startMarker = new google.maps.Marker({
        position: start,
        map: trackingMap,
        title: 'Restaurant',
        icon: restaurantIcon
    });

    var endMarker = new google.maps.Marker({
        position: end,
        map: trackingMap,
        title: 'Delivery Point',
        icon: customerIcon
    });

// Add a moving marker for the rider
    var movingMarker = new google.maps.Marker({
        position: start,
        map: trackingMap,
        icon: restaurantIcon
    });

    // Animate the rider
    // var step = 0;
    // var numSteps = 200;
    // var timePerStep = 5000;
    // startMarker.setMap(null);
    //
    // var interval = setInterval(function() {
    //     step += 1;
    //     if (step > numSteps) {
    //         clearInterval(interval);
    //         return;
    //     }
    //     var lat = start.lat + (end.lat - start.lat) * (step / numSteps);
    //     var lng = start.lng + (end.lng - start.lng) * (step / numSteps);
    //     movingMarker.setPosition({lat: lat, lng: lng});
    // }, timePerStep);


    // Adjust the map bounds to fit both points
    var bounds = new google.maps.LatLngBounds();
    bounds.extend(start);
    bounds.extend(end);
    trackingMap.fitBounds(bounds);
}
