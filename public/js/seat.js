const bookedSeats = ['3A', '7C', '10E', '15F'];

function createSeat(row, col) {
    const seat = document.createElement("div");
    seat.className = "seat";
    const seatCode = `${row}${col}`;
    seat.dataset.seatCode = seatCode;

    if(bookedSeats.includes(seatCode)) {
        seat.classList.add("booked");
    } else {
        seat.addEventListener("click", () => {
        seat.classList.toggle("selected");
    });
    }
    return seat;
}

const leftSeats = document.getElementById("left-seats");
const rightSeats = document.getElementById("right-seats");

for(let row = 1; row <= 17; row++) {
    ['A','B','C'].forEach(col => leftSeats.appendChild(createSeat(row, col)));
    ['D','E','F'].forEach(col => rightSeats.appendChild(createSeat(row, col)));
}

function handleConfirm() {
    const selectedSeats = Array.from(document.querySelectorAll('.seat.selected'))
        .map(seat => seat.dataset.seatCode);

    if(selectedSeats.length > 0) {
        alert(`Kursi terpilih: ${selectedSeats.join(', ')}`);
        } else {
        alert("Silakan pilih kursi terlebih dahulu!");
    }
}
