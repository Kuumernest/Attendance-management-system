<?php
class Batch {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function fetchAllBatches() {
        $stmt = $this->pdo->query('SELECT * FROM batches');
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Student to Batch</title>
</head>
<body>
    <h1>Add Student to Batch</h1>
    <form action="./views/attendance.php" method= "POST">
        <label for="student_id">Select Student:</label>
        <select name="student_id" id="student_id" required> 
            <?php foreach($students as $student): ?>
                <option value="<?php echo $student['id']; ?>"><?php echo htmlspecialchars($student['name']); ?></option>
                <?php endforeach; ?>
        </select>
        <br>
        <label for="batch_id">Select Batch:</label>
        <select name="batch_id" id="batch_id" required>

        <?php foreach($batches as $batch): ?>
                <option value="<?php echo $batch['id']; ?>"><?php echo htmlspecialchars($batch['name']); ?></option>
                <?php endforeach; ?>
        </select>
        <br>
        <button type= "submit">Add to Batch</button>
    </form>
    
</body>
</html>