<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Pilih Kursi | HikmalAir</title>
  <link href="https://fonts.googleapis.com/css2?family=Lato&display=swap" rel="stylesheet" />
  <style>
    * {
      box-sizing: border-box;
      font-family: 'Lato', sans-serif;
    }
    body {
      margin: 0;
      padding: 0;
      background: #f9f9f9;
      min-height: 100vh;
      display: flex;
      flex-direction: column;
      align-items: center;
    }

    .seat-map {
      display: flex;
      justify-content: center;
      align-items: center;
      padding: 40px 20px;
    }

    .seats-layout {
      display: flex;
      align-items: center;
      gap: 30px;
    }

    .row-numbers {
      display: grid;
      grid-template-rows: repeat(17, 40px);
      gap: 10px;
      font-size: 14px;
      color: #333;
    }

    .row-numbers div {
    display: flex;
    align-items: flex-start;
    justify-content: center;
    height: 40px;
    width: 30px;
    padding-top: 12px;
    font-weight: 600;
    }

    .seat-section {
      display: flex;
      flex-direction: column;
      align-items: center;
    }

    .seat-labels {
      display: flex;
      gap: 10px;
      margin-bottom: 10px;
      font-size: 14px;
      font-weight: bold;
      color: #333;
    }

    .seat-labels div {
      width: 40px;
      text-align: center;
    }

    .seat-column {
      display: grid;
      grid-template-columns: repeat(3, 40px);
      grid-template-rows: repeat(17, 40px);
      gap: 10px;
    }

    .seat {
      background-color: #ccc;
      border-radius: 6px;
      width: 40px;
      height: 40px;
      cursor: pointer;
      transition: background-color 0.3s;
      display: flex;
      align-items: center;
      justify-content: center;
      user-select: none;
    }

    .seat.selected {
      background-color: #4CAF50;
      color: white;
      font-weight: bold;
    }

    .seat.booked {
      background-color: #D9534F;
      cursor: not-allowed;
      color: white;
      font-weight: bold;
    }

    .confirm-btn {
      display: block;
      margin: 30px auto;
      padding: 12px 24px;
      background-color: #4CAF50;
      color: white;
      border: none;
      border-radius: 5px;
      cursor: pointer;
      font-size: 16px;
    }
  </style>
</head>
<body>
  <div class="seat-map">
    <div class="seats-layout">
      <div class="row-numbers">
        <script>
          document.write([...Array(17)].map((_, i) => `<div>${i + 1}</div>`).join(''));
        </script>
      </div>

      <div class="seat-section">
        <div class="seat-labels">
          <div>A</div><div>B</div><div>C</div>
        </div>
        <div class="seat-column" id="left-seats"></div>
      </div>

      <div class="seat-section">
        <div class="seat-labels">
          <div>D</div><div>E</div><div>F</div>
        </div>
        <div class="seat-column" id="right-seats"></div>
      </div>
    </div>
  </div>

  <button class="confirm-btn" onclick="handleConfirm()">Konfirmasi Kursi</button>

  <script>
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
  </script>
</body>
</html>
