<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pesan Paket Umrah</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 400px;
            margin: 50px auto;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 20px;
            text-align: center;
        }
        .card-header {
            background: #007bff;
            color: white;
            padding: 10px;
            font-size: 1.5em;
            font-weight: bold;
            border-radius: 8px 8px 0 0;
            margin-bottom: 20px;
        }
        .form-group {
            margin-bottom: 20px;
            text-align: left;
        }
        label {
            font-weight: bold;
            margin-bottom: 8px;
            display: block;
        }
        select, button {
            width: 100%;
            padding: 12px;
            border-radius: 4px;
            border: 1px solid #ccc;
            font-size: 1em;
        }
        .btn-primary {
            background-color: #007bff;
            color: white;
            border: none;
            margin-top: 20px;
            cursor: pointer;
        }
        .btn-primary:hover {
            background-color: #0056b3;
        }
        h5 {
            margin: 20px 0;
            font-size: 1.2em;
            color: #333;
        }
        #total-price {
            font-weight: bold;
            color: #007bff;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="card-header">Pesan Paket</div>
    <form method="POST">
        <div class="form-group">
            <label for="program">Program Hari</label>
            <select id="program" name="program" required>
                <option value="Umrah 12 Hari">Umrah 12 Hari</option>
                <option value="Umrah 9 Hari">Umrah 9 Hari</option>
                <option value="Umrah 7 Hari">Umrah 7 Hari</option>
            </select>
        </div>

        <div class="form-group">
            <label for="bandara">Bandara Keberangkatan</label>
            <select id="bandara" name="bandara" required>
                <option value="CGK">Soekarno-Hatta International Airport (CGK)</option>
                <option value="SUB">Juanda International Airport (SUB)</option>
                <option value="KNO">Kualanamu International Airport (KNO)</option>
            </select>
        </div>

        <div class="form-group">
            <label for="tanggal">Tanggal Keberangkatan</label>
            <select id="tanggal" name="tanggal" required>
                <option value="">Select an Option</option>
                <option value="2024-12-12">12 Desember 2024</option>
                <option value="2025-01-15">15 Januari 2025</option>
                <option value="2025-02-20">20 Februari 2025</option>
            </select>
        </div>

        <div class="form-group">
            <label for="kamar">Pilihan Kamar</label>
            <select id="kamar" name="kamar" required>
                <option value="1">Single Room</option>
                <option value="2">Double Room</option>
                <option value="3">Triple Room</option>
            </select>
        </div>

        <h5>Total : <span id="total-price">IDR 0,00</span></h5>
        <button type="submit" class="btn-primary">Konsultasi Paket</button>
    </form>
</div>

<script>
    document.getElementById('tanggal').addEventListener('change', function() {
        let selectedDate = this.value;
        let totalPrice = document.getElementById('total-price');

        let price = 0;

        let program = document.getElementById('program').value;
        let kamar = document.getElementById('kamar').value;

        if (program === "Umrah 12 Hari") {
            price = 25000000;
        } else if (program === "Umrah 9 Hari") {
            price = 22000000;
        } else {
            price = 20000000;
        }

        if (kamar == 2) {
            price -= 1000000;
        } else if (kamar == 3) {
            price -= 2000000;
        }

        totalPrice.textContent = "IDR " + price.toLocaleString();
    });
</script>

</body>
</html>
