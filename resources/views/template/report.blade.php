<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Work Order Table</title>

    <style>
        @page {
            size: A4;
        }

        .container {
            margin: 10px auto;
            width: 100%;
        }

        .header {
            text-align: start;
        }

        .header img {
            width: 200px;
            float: left;
        }

        .header h3,
        .header p {
            margin: 2px;
            word-wrap: break-word;
        }

        .divider {
            border: 1px solid #000;
            margin: 20px 0;
            width: 100%;
        }

        .isi-body {
            margin: 10px;
        }

        .isi-header {
            text-align: center;
        }

        .underline-text {
            text-decoration: underline;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
        }

        .table th,
        .table td {
            border: 1px solid #000;
            padding: 8px;
        }

        .td-quantity {
            text-align: center;
        }

        .td-background {
            border: 1px solid #000;
            padding: 8px;
        }

        .table th {
            background-color: #f2f2f2;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h3>PT SIMaWom</h3>
            <p>Jl. Merdeka No.123, Kecamatan Periuk, Banten, Indonesia</p>
            <p>Telepon : +62 21 1234 5678 | E-mail : info@simawom.co.id</p>
        </div>
        <hr class="divider">
        <!-- Tambahkan konten work order Anda di sini -->

        <div class="isi-body">
            <h3 class="isi-header underline-text">WORK ORDER TABLE</h3>
            <table class="table">
                <thead>
                    <tr>
                        <th>Product Name</th>
                        <th colspan="2">Quantity</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $totalQuantity = 0;
                    @endphp
                    @foreach ($workOrders as $workOrder)
                                        @php
                                            $totalQuantity += $workOrder->quantity;
                                        @endphp
                                        <tr>
                                            <td class="td-quantity">{{ $workOrder->product_name }}</td>
                                            <td class="td-quantity" colspan="2">{{ $workOrder->quantity }}</td>
                                        </tr>
                    @endforeach
                    <tr>
                        <td style="border-right: none;"><strong>Total Quantity</strong></td>
                        <td class="td-quantity" colspan="2" style="border-left: none;">
                            <strong>{{ $totalQuantity }}</strong></td>
                    </tr>
                </tbody>
            </table>
        </div>

    </div>
</body>

</html>