<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Author Pay System</title>
</head>
<body>
    <h1>Manila Authors' Pay System</h1>

    <!-- HTML Form -->
    <form action="pay_calculator.php" method="post">
        <label for="name">Author Name:</label>
        <input type="text" id="name" name="name" required><br><br>
        
        <label for="type">Author Type:</label>
        <select id="type" name="type" required>
            <option value="fiction">Fiction</option>
            <option value="nonfiction">Nonfiction</option>
        </select><br><br>
        
        <label for="years">Number of Years Writing:</label>
        <input type="number" id="years" name="years" min="0" required><br><br>
        
        <label for="books">Number of Books Written:</label>
        <input type="number" id="books" name="books" min="0" required><br><br>
        
        <label for="loan">Author's Loan:</label>
        <input type="number" id="loan" name="loan" min="0" step="0.01" required><br><br>
        
        <input type="submit" value="Calculate Pay">
    </form>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $name = htmlspecialchars($_POST['name']);
        $type = htmlspecialchars($_POST['type']);
        $years = intval($_POST['years']);
        $books = intval($_POST['books']);
        $loan = floatval($_POST['loan']);
        
        // Basic Pay
        $basicPay = ($type === 'fiction') ? 100 : 250;
        
        // Current Pay
        $currentPay = $basicPay * $books;
        
        // Royalty Pay
        if ($years < 5) {
            $royaltyRate = 0.025;
        } elseif ($years < 12) {
            $royaltyRate = 0.0525;
        } elseif ($years < 20) {
            $royaltyRate = 0.07;
        } elseif ($years < 27) {
            $royaltyRate = 0.085;
        } elseif ($years < 35) {
            $royaltyRate = 0.09;
        } else {
            $royaltyRate = 0.1025;
        }
        $royaltyPay = $basicPay * $royaltyRate;
        
        // Total Pay
        $totalPay = $currentPay + $royaltyPay;
        
        // Net Pay
        $netPay = $totalPay - $loan;
        
        // Report
        echo "<h2>Transaction Report</h2>";
        echo "<p><strong>Author Name:</strong> $name</p>";
        echo "<p><strong>Author Type:</strong> " . ucfirst($type) . "</p>";
        echo "<p><strong>Number of Years Writing:</strong> $years</p>";
        echo "<p><strong>Number of Books Written:</strong> $books</p>";
        echo "<p><strong>Author's Loan:</strong> OMR " . number_format($loan, 2) . "</p>";
        echo "<p><strong>Basic Pay:</strong> OMR " . number_format($basicPay, 2) . "</p>";
        echo "<p><strong>Current Pay:</strong> OMR " . number_format($currentPay, 2) . "</p>";
        echo "<p><strong>Royalty Pay:</strong> OMR " . number_format($royaltyPay, 2) . "</p>";
        echo "<p><strong>Total Pay:</strong> OMR " . number_format($totalPay, 2) . "</p>";
        echo "<p><strong>Net Pay:</strong> OMR " . number_format($netPay, 2) . "</p>";
    }
    ?>
</body>
</html>