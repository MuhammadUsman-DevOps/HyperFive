// Define form element
const addAreaForm = document.getElementById('add_new_area_form');

// Init form validation rules. For more info check the FormValidation plugin's official documentation:https://formvalidation.io/
var addAreaValidator = FormValidation.formValidation(
    addAreaForm,
    {
        fields: {
            'area_name': {
                validators: {
                    notEmpty: {
                        message: 'name is required'
                    }
                }
            },
            'approx_delivery_time': {
                validators: {
                    notEmpty: {
                        message: 'enter approx delivery time'
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
const AreaSubmitButton = document.getElementById('add_new_area_form_submit');
AreaSubmitButton.addEventListener('click', function (e) {
    // Prevent default button action
    e.preventDefault();

    // Validate form before submit
    if (addAreaValidator) {
        addAreaValidator.validate().then(function (status) {
            console.log('validated!');

            if (status == 'Valid') {
                var allPolygonsCoordinates = googleMapsPolygons.map(polygon => {
                    var path = polygon.getPath().getArray();
                    return path.map(point => ({
                        lat: point.lat(),
                        lng: point.lng(),
                    }));
                });

                var wktPolygon = toWktPolygon(allPolygonsCoordinates[0]); // Assuming allPolygonsCoordinates is an array of arrays
                $("#coordinates").val(wktPolygon);

                // Show loading indication
                AreaSubmitButton.setAttribute('data-kt-indicator', 'on');

                // Disable button to avoid multiple click
                AreaSubmitButton.disabled = true;

                // Simulate form submission. For more info check the plugin's official documentation: https://sweetalert2.github.io/
                addAreaForm.submit()
            }
        });
    }
});


var googleMapsPolygons = []; // To keep track of Google Maps Polygon objects
var turfPolygons = []; // To keep track of Turf.js Polygon objects for overlap checking

function initMap() {
    const map = new google.maps.Map(document.getElementById('map'), {
        center: {lat: -34.397, lng: 150.644},
        zoom: 8,
    });

    // Set up the search box
    const input = document.getElementById('area_location');
    const options = {
        fields: ["formatted_address", "geometry", "name"],
        strictBounds: false,
    };

    const searchBox = new google.maps.places.SearchBox(input);
    // map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

    const autocomplete = new google.maps.places.Autocomplete(
        input,
        options
    );

    // Bind the map's bounds (viewport) property to the autocomplete object,
    // so that the autocomplete requests use the current map bounds for the
    // bounds option in the request.
    autocomplete.bindTo("bounds", map);

    const infowindow = new google.maps.InfoWindow();
    const infowindowContent = document.getElementById("infowindow-content");

    infowindow.setContent(infowindowContent);

    const marker = new google.maps.Marker({
        map,
        anchorPoint: new google.maps.Point(0, -29),
    });


    autocomplete.addListener("place_changed", () => {
        infowindow.close();
        marker.setVisible(false);

        const place = autocomplete.getPlace();

        if (!place.geometry || !place.geometry.location) {
            // User entered the name of a Place that was not suggested and
            // pressed the Enter key, or the Place Details request failed.
            window.alert(
                "No details available for input: '" + place.name + "'"
            );
            return;
        }

        // If the place has a geometry, then present it on a map.
        if (place.geometry.viewport) {
            map.fitBounds(place.geometry.viewport);
        } else {
            map.setCenter(place.geometry.location);
            map.setZoom(17);
        }

        marker.setPosition(place.geometry.location);
        marker.setVisible(true);

    });


    map.addListener('bounds_changed', function () {
        searchBox.setBounds(map.getBounds());
    });

    searchBox.addListener('places_changed', function () {
        const places = searchBox.getPlaces();
        if (places.length == 0) return;

        const bounds = new google.maps.LatLngBounds();
        places.forEach(place => {
            if (!place.geometry || !place.geometry.location) return;
            if (place.geometry.viewport) {
                bounds.union(place.geometry.viewport);
            } else {
                bounds.extend(place.geometry.location);
            }
        });
        map.fitBounds(bounds);
    });

    const drawingManager = new google.maps.drawing.DrawingManager({
        drawingMode: google.maps.drawing.OverlayType.POLYGON,
        drawingControl: true,
        drawingControlOptions: {
            position: google.maps.ControlPosition.TOP_CENTER,
            drawingModes: ['polygon'],
        },
        polygonOptions: {
            fillColor: '#ffff00',
            fillOpacity: 0.2,
            strokeWeight: 5,
            clickable: true,
            editable: true,
            zIndex: 1,
        },
    });
    drawingManager.setMap(map);

    google.maps.event.addListener(drawingManager, 'polygoncomplete', function (polygon) {
        let path = polygon.getPath().getArray();
        let coordinates = path.map(point => [point.lng(), point.lat()]);
        coordinates.push(coordinates[0]); // Close the polygon by adding the first point at the end

        if (coordinates.length < 4) {
            console.error('Polygon must have at least 3 unique points plus one to close the path');
            polygon.setMap(null);
            return;
        }

        let newPolygon = turf.polygon([coordinates]);

        let overlap = turfPolygons.some(existingPolygon => turf.intersect(newPolygon, existingPolygon));
        if (overlap) {
            console.error('New polygon overlaps with an existing one!');
            polygon.setMap(null);
            return;
        }

        turfPolygons.push(newPolygon);
        googleMapsPolygons.push(polygon);
    });
}

// document.getElementById('add_new_area_form_submit').addEventListener('click', function (e) {
//     e.preventDefault();
//
//     var allPolygonsCoordinates = googleMapsPolygons.map(polygon => {
//         var path = polygon.getPath().getArray();
//         return path.map(point => ({
//             lat: point.lat(),
//             lng: point.lng(),
//         }));
//     });
//
//     var wktPolygon = toWktPolygon(allPolygonsCoordinates[0]); // Assuming allPolygonsCoordinates is an array of arrays
//     $("#coordinates").val(wktPolygon);
//
//
// });


function toWktPolygon(coordinates) {
    let wkt = 'POLYGON((';
    wkt += coordinates.map(coordinate => `${coordinate.lng} ${coordinate.lat}`).join(', ');
    wkt += `, ${coordinates[0].lng} ${coordinates[0].lat}`; // Close the polygon by repeating the first point
    wkt += '))';
    return wkt;
}


