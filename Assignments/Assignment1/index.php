<h2>Assignment 1.1</h2>

<h3>Challenge 1</h3>
<?php
$name = "Htet Aung Win"; //name
$age = 27; // integer
$favorite_color = "dark blue";

echo "My name is ", $name, ", I am ", $age, " years old and my favorite color is ", $favorite_color, ".";
?>
<br>

<h3>Challenge 2</h3>
<?php
echo "\"He said, \"PHP is fun!\" and left.\"";
?><br>
<?php
echo "First line<br>Second Line"; //cannot use escape \n for new line
?><br>

<h3>Challenge 3</h3>
<?php
$age = 25;
$greeting = 'Hello';
echo "Welcome to the PHP world!<br>";
echo "Your age is ", $age;
?><br>

<h3>Challenge 4</h3>
<?php
echo "Welcome to PHP!";
$name = 'John';
echo "Hello ", $name;
?>

<h3>Challenge 5</h3>
<?php
$price = 50; //declare the price
$discount = 10; #state discount
/*
calcalate final price by subtracting discount from the price
*/
$finalPrice = $price - $discount;
echo "Total price: $" ,$finalPrice;
?>
<br><br>

<h2>Assignment 1.2</h2>

<h3>Challenge 1</h3>
    <?php
    $number1 = 10;
    $number2 = 5;
    ?>
    
    <?php 
    echo "Number 1: ", $number1;?> 
<br>
    <?php echo "Number 2: ", $number2;?>
<br> 
    <?php
    echo "Addition: ", $number1 + $number2;
    ?>
<br> 
    <?php
    echo "Subtraction: ", $number1 - $number2;
    ?>
<br> 
    <?php
    echo "Division: ", $number1 / $number2;
    ?>
<br> 
    <?php
    echo "Multiplication: ", $number1 * $number2;
    ?>
<br> 
    <?php
    echo "Modulus: ", $number1 % $number2;
    ?>
<br>

<h3>Challenge 2</h3>
<?php
$input = 7;
?>
<?php
echo "Input: $input<br>";
if($input%2 == 0) {
    echo "Output: ", $input, " is an even number."; 
} else {
    echo "Output: ", $input, " is an odd number.";
}
?>
<br>

<h3>Challenge 3</h3>
<?php
$startNumber = 10;
echo "Starting number: ",$startNumber;
echo "<br>After increment: ",++$startNumber;
echo "<br>After decrement: ",--$startNumber;
?>

<h3>Challenge 4</h3>
<?php
$score = 85;
echo "Input:  $score<br>";
if ($score >= "90"){
    echo "Output: You got an A!";
} elseif ($score >= "80" || $score < "90"){
    echo "Output: You got a B!";
} elseif ($score >= "70" || $score < "80"){
    echo "Output: You got a C!";
} elseif ($score >= "60" || $score < "69"){
    echo "Output: You got a D!";
} else{
    echo "<Output: You got a F!";
}
?>

<h3>Challenge 5</h3>
<?php
$year = 2024;
echo "Input: $year<br>";
if (($year % 4 == 0 && $year % 100 != 0) || ($year % 400 == 0)) {
    echo "Output: $year is a leap year";
} else 
echo "Output: $year is not a leap year";