document.addEventListener('DOMContentLoaded', function () {
    const returnTripSwitch = document.getElementById('returnTripSwitch');
    const returnDateContainer = document.getElementById('returnDateContainer');
    const returnDateInput = document.getElementById('returnDate');

    function toggleReturnDateVisibility() {
        if (!returnDateContainer || !returnDateInput) return;

        if (returnTripSwitch && returnTripSwitch.checked) {
            returnDateContainer.style.display = '';
            returnDateInput.disabled = false;
        } else if (returnDateContainer) {
            returnDateContainer.style.display = 'none';
            returnDateInput.disabled = true;
            returnDateInput.value = '';
        }
    }

    if (returnTripSwitch) {
        toggleReturnDateVisibility();
        returnTripSwitch.addEventListener('change', toggleReturnDateVisibility);
    }

    const departureInput = document.getElementById('departureCity');
    const arrivalInput = document.getElementById('arrivalCity');
    const swapButton = document.getElementById('swapLocationsButton');

    if (swapButton && departureInput && arrivalInput) {
        swapButton.addEventListener('click', function () {
            const tempDepartureValue = departureInput.value;
            departureInput.value = arrivalInput.value;
            arrivalInput.value = tempDepartureValue;
        });
    }
});
