<?php

class Student
{
    public $name;
    public $age;
    public $score;

    public function __construct($name, $age, $score)
    {
        $this->name = $name;
        $this->age = $age;
        $this->score = $score;
    }

    public function getRank()
    {
        if ($this->score >= 8) {
            return "Gioi";
        } elseif ($this->score >= 6.5) {
            return "Kha";
        } elseif ($this->score >= 5) {
            return "Trung binh";
        } else {
            return "Yeu";
        }
    }

    public function isPassed()
    {
        return $this->score >= 5;
    }

    public function display()
    {
        echo "Ho ten: " . $this->name . "<br>";
        echo "Tuoi: " . $this->age . "<br>";
        echo "Diem: " . $this->score . "<br>";
        echo "Xep loai: " . $this->getRank() . "<br><br>";
    }
}

function findBestStudent($students)
{
    $bestStudent = $students[0];

    foreach ($students as $student) {
        if ($student->score > $bestStudent->score) {
            $bestStudent = $student;
        }
    }

    return $bestStudent;
}

function countPassedStudents($students)
{
    $count = 0;

    foreach ($students as $student) {
        if ($student->isPassed()) {
            $count++;
        }
    }

    return $count;
}

function calculateAverageScore($students)
{
    $total = 0;

    foreach ($students as $student) {
        $total += $student->score;
    }

    return $total / count($students);
}


$student1 = new Student("Nguyen Van An", 20, 8.5);
$student2 = new Student("Tran Thi Binh", 21, 6.5);
$student3 = new Student("Le Van Cuong", 19, 4.5);
$student4 = new Student("Pham Thi Dung", 20, 7.5);


$students = [
    $student1,
    $student2,
    $student3,
    $student4
];


echo "<h2>Danh sach sinh vien</h2>";

foreach ($students as $student) {
    $student->display();
}


$bestStudent = findBestStudent($students);

echo "<h2>Sinh vien diem cao nhat</h2>";
$bestStudent->display();


echo "<h2>Thong ke</h2>";

echo "So sinh vien dat: " . countPassedStudents($students) . "<br>";
echo "Diem trung binh: " . calculateAverageScore($students);

?>