<?php 
Class Counter {
  private $count = 0;

  public function countUp() {
    $this->$count++;
  }
  public function countDown() {
    $this->$count--;
  }
  public function displayCounter() {
    echo $this->$count . "<br />";
  }
}

$counter = new Counter;
$counter->countUp();
$counter->countUp();
$counter->countUp();
$counter->countUp();
$counter->countUp();
$counter->countUp();
$counter->countUp();
$counter->countUp();
$counter->countUp();
$counter->displayCounter();
$counter->countDown();
$counter->countDown();
$counter->countDown();
$counter->countDown();
$counter->countDown();
$counter->countDown();
$counter->displayCounter();
?>
