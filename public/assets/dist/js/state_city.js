$(document).ready(function () {

    // Populate States
    $.each(indianStatesAndCities, function (state, cities) {
        $('#state').append(
            $('<option>', {
                value: state,
                text: state
            })
        );
    });

    // Populate Cities based on State
    $('#state').change(function () {

        let selectedState = $(this).val();

        $('#city').html('<option value="">Select City</option>');

        if (selectedState !== '') {

            $.each(indianStatesAndCities[selectedState], function (index, city) {

                $('#city').append(
                    $('<option>', {
                        value: city,
                        text: city
                    })
                );

            });

        }

    });

});