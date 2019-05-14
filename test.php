<?php
require "Student.php";
$student = new Student();
$student->name = '张三';
$student->age = '20';
$student->sex = '男';

$data = $student->toArray();
var_dump($data);