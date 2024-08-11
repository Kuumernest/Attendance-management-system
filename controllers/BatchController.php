
<?php
class BatchController {
    private $batch;

    public function __construct($pdo) {
        $this->batch = new Batch($pdo);
    }

    public function getAll() {
        return $this->batch->getAll();
    }
}