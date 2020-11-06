<?php

// call_user_func function with isset check and null coalescing operator (php 7 only)

function hello($details=[]) {
    echo isset($details["name"]) ? "Hello " . $details["name"] . ", how are you!" : "Hi, how are you!" ;
    echo isset($details["age"]) ? "<br />You are " . $details["age"] . " years old." : "<br />You have no age!" ;
    echo isset($details["birth-month"]) ? "<br />Your birthday is in " . $details["birth-month"]. "." : "<br />You have no birth month!" ;
    
    $name = $details["name"] ?? "Anon"; // PHP 7+ only
    echo "<br /> " . $name;
}

call_user_func(
    'hello',
    [   
        //"name" => "Joe",
        // "age" => 37,
        // "birth-month" => "March"
    ]
);
