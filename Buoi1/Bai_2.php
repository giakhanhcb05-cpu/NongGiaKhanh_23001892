<?php

$students = [
    [
        "name" => "Nguyen Van An",
        "age" => 20,
        "score" => 8.5
    ],
    [
        "name" => "Tran Thi Binh",
        "age" => 21,
        "score" => 6.5
    ],
    [
        "name" => "Le Van Cuong",
        "age" => 19,
        "score" => 4.5
    ],
    [
        "name" => "Pham Thi Dung",
        "age" => 20,
        "score" => 7.5
    ]
];

function calculateAverageScore($students)
{
    $total = 0;

    foreach ($students as $student) {
        $total += $student["score"];
    }

    return $total / count($students);
}

function getRank($score)
{
    if ($score >= 8) {
        return "Gioi";
    } elseif ($score >= 6.5) {
        return "Kha";
    } elseif ($score >= 5) {
        return "Trung binh";
    } else {
        return "Yeu";
    }
}

function displayStudent($student)
{
    echo "Ho ten: " . $student["name"] . "<br>";
    echo "Tuoi: " . $student["age"] . "<br>";
    echo "Diem: " . $student["score"] . "<br>";
    echo "Xep loai: " . getRank($student["score"]) . "<br><br>";
}


foreach ($students as $student) {
    displayStudent($student);
}

echo "Diem trung binh: " . calculateAverageScore($students);

?>