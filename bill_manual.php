<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Electricity Rates</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            color: #333;
            margin: 20px;
            display: flex;
            justify-content: space-between;
            flex-wrap: wrap;
        }
        

        h1 {
            width: 100%;
            text-align: center;
            color: #0066cc;
            margin-bottom: 20px;
        }

        .table-container {
            width: 30%;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #0066cc;
            color: white;
        }

        p {
            color: #777;
            font-size: 14px;
        }
        .button-container {
            width: 100%;
            text-align: center;
        }

        .button, .sbutton {
            padding: 10px 20px;
            margin: 10px;
            background-color: #0066cc;
            color: white;
            text-decoration: none;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .sbutton {
            background-color: #e74c3c
        }
    </style>
</head>
<body>
<div class="logo-container">
    <img class="logo" src="powerpay_img.png" alt="Logo">
</div>

<h1>Electricity Rates</h1>

<div class="table-container">
    <h2>Meter Type: Residential</h2>
    <table>
        <tr>
            <th>Unit Price Range</th>
            <th>Energy Rate (Taka/Unit)</th>
        </tr>
        <tr>
            <td>0-150</td>
            <td>5.50</td>
        </tr>
        <tr>
            <td>151-400</td>
            <td>6.50</td>
        </tr>
        <tr>
            <td>401-600</td>
            <td>7.10</td>
        </tr>
        <tr>
            <td>More than 600</td>
            <td>9.00</td>
        </tr>
    </table>
    <p>Late Penalty: 150 Taka</p>
</div>

<div class="table-container">
    <h2>Meter Type: Garments</h2>
    <table>
        <tr>
            <th>Unit Price Range</th>
            <th>Energy Rate (Taka/Unit)</th>
        </tr>
        <tr>
            <td>0-250</td>
            <td>9.40</td>
        </tr>
        <tr>
            <td>251-550</td>
            <td>10.57</td>
        </tr>
        <tr>
            <td>More than 551</td>
            <td>13.00</td>
        </tr>
    </table>
    <p>Late Penalty: 400 Taka</p>
</div>

<div class="table-container">
    <h2>Meter Type: Industry</h2>
    <table>
        <tr>
            <th>Unit Price Range</th>
            <th>Energy Rate (Taka/Unit)</th>
        </tr>
        <tr>
            <td>0-400</td>
            <td>11.65</td>
        </tr>
        <tr>
            <td>401-850</td>
            <td>13.45</td>
        </tr>
        <tr>
            <td>More than 851</td>
            <td>15.53</td>
        </tr>
    </table>
    <p>Late Penalty: 650 Taka</p>
</div>
<div class="button-container">
    <button class="button" onclick="location.href='user_dashboard.php'">Back to Dashboard</button>
    <button class="sbutton" onclick="location.href='user_logout.php'">Sign Out</button>
</div>

</body>
</html>
