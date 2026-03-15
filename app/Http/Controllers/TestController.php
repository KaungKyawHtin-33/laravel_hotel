<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TestController extends Controller
{
    public function index () 
    {
        $person = [
            "name" => "John Doe",
            "age"  => 23
        ];
        $fruits = ["apple", "orange", "mango", "banana"];
        return view("test.testone", compact([
            "person",
            "fruits"
        ]));
    }

    public function hello ()
    {
        $text = "Hello Laravel !!!";
        return view("hello", compact([
            "text"
        ]));
    }
}
