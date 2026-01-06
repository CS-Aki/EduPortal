<?php

require('../fpdf/fpdf.php');

class PDF extends FPDF
{
    // Function to add the left side background with professor's details
    function AddBackgroundDiv()
    {
        $logoPath = 'images/combined-fixed.png';
        $this->SetFillColor(138, 201, 161); // Green background
        $this->Rect(0, 5, 500, 47, 'F'); // Draw a filled rectangle (x, y, width, height)
        $this->Image($logoPath, 63, 13, 70);
        $this->SetXY(50, 23);
        $this->SetFont('Arial', 'B', 52);
        $this->Cell(0, 25, 'Report Card', 0, 0);
    }

    function AddPersonalInfo($student, $imagePath)
    {
        $this->Image($imagePath, 10, 58, 40); // Add professor image
        $this->SetTextColor(0, 0, 0); // Black text color

        $this->SetXY(55, 60); 
        $this->SetFont('Arial', 'B', 14);
        $this->Cell(0, 5, 'Name: ', 0, 'L');
        $this->SetFont('Arial', '', 12);
        $this->SetXY(80, 60);
        $this->Cell(140, 5, $student['name'], 0, 'L');

        $this->SetXY(55, 68); 
        $this->SetFont('Arial', 'B', 14);
        $this->Cell(0, 5, 'Student Number: ', 0, 'L');
        $this->SetXY(105, 68);
        $this->SetFont('Arial', '', 12);
        $this->MultiCell(140, 5, $student['studentNumber'], 0, 'L');

        $this->SetXY(55, 76); 
        $this->SetFont('Arial', 'B', 14);
        $this->Cell(0, 5, 'Subject: ', 0, 'L');
        $this->SetFont('Arial', '', 12);
        $this->SetXY(85, 76);
        $this->MultiCell(140, 5, $student['subject'], 0, 'L');

        $this->SetXY(55, 84); 
        $this->SetFont('Arial', 'B', 14);
        $this->Cell(0, 5, 'Schedule: ', 0, 'L');
        $this->SetFont('Arial', '', 12);
        $this->SetXY(90, 84);
        $this->MultiCell(140, 5, $student['schedule'], 0, 'L');

        $this->SetXY(55, 92); 
        $this->SetFont('Arial', 'B', 14);
        $this->Cell(0, 5, 'Academic Year: ', 0, 'L');
        $this->SetFont('Arial', '', 12);
        $this->SetXY(103, 92);
        $this->MultiCell(140, 5, $student['academicYear'], 0, 'L');

        $this->SetY($this->GetY() + 7);
        $x1 = 10; // Starting X position
        $x2 = $this->GetPageWidth() - 10; // Ending X position (90% width with margins)
        $y = $this->GetY(); // Current Y position
        $this->SetLineWidth(0.5); // Set line thickness
        $this->Line($x1, $y, $x2, $y); // Draw the horizontal line

        $this->SetY($y + 5);
    }

    function AddGrades($activities, $quizzes, $exams, $finalGrade, $finalRemark)
    {
        $maxRows = max(count($activities), count($quizzes), count($exams));

        // Set table headers
        $this->SetXY(10, 110);
        $this->SetTextColor(0, 0, 0); 
        $this->SetFont('Arial', 'B', 12);

        $this->Cell(15, 10, 'No.', 1, 0, 'C');
        $this->Cell(30, 10, 'Activity', 1, 0, 'C');
        $this->Cell(30, 10, 'Quiz', 1, 0, 'C');
        $this->Cell(30, 10, 'Exam', 1, 1, 'C');

        // Set font for table content
        $this->SetFont('Arial', '', 12);
        $qcount = 0;
        for ($i = 0; $i < $maxRows; $i++) {
            $this->Cell(15, 10, $i + 1, 1, 0, 'C');
            $this->Cell(30, 10, isset($activities[$i]) ? $activities[$i] : '', 1, 0, 'C');
            $this->Cell(30, 10, isset($quizzes[$i]) ? $quizzes[$i] : '', 1, 0, 'C');
            $this->Cell(30, 10, isset($exams[$i]) ? $exams[$i] : '', 1, 1, 'C');
        }

        $qcount = 0; // Initialize quiz counter
        foreach ($quizzes as $quiz) {
            if ($quiz !== '') { // Make sure quiz is not empty
                $qcount++; // Increment count for each valid quiz
            }
        }

        $ecount = 0; // Initialize quiz counter
        foreach ($exams as $exam) {
            if ($exam !== '') { // Make sure quiz is not empty
                $ecount++; // Increment count for each valid quiz
            }
        }

        $totalItemsActivities = 20 * $maxRows;
        $totalItemsQuiz = 50 * $qcount;
        $totalItemsExam = 100 * $ecount;
        // For totals - Items
        $this->SetFont('Arial', 'B', 12); // Bold
        $this->Cell(15, 10, 'Items', 1, 0, 'C');
        $this->SetFont('Arial', 'I', 12); // Italic
        $this->Cell(30, 10, $totalItemsActivities, 1, 0, 'C');
        $this->Cell(30, 10, $totalItemsQuiz, 1, 0, 'C');
        $this->Cell(30, 10, $totalItemsExam, 1, 1, 'C');

        $this->SetFont('Arial', 'B', 12); // Bold
        $this->Cell(15, 10, 'Total', 1, 0, 'C');
        $this->SetFont('Arial', 'I', 12); // Italic
        $this->Cell(30, 10, array_sum($activities), 1, 0, 'C');
        $this->Cell(30, 10, array_sum($quizzes), 1, 0, 'C');
        $this->Cell(30, 10, array_sum($exams), 1, 1, 'C');

        $this->Cell(30, 5, '', 0, 1, 'C'); // For space

        $this->Cell(40, 10, "Final Grade", 1, 1, 'C');
        $this->Cell(15, 10, $finalGrade, 1, 0, 'C');
        $this->Cell(25, 10, $finalRemark, 1, 1, 'C');
    }

    function AddEquivalents()
    {
        $this->SetXY(120, 110);
        $this->SetTextColor(0, 0, 0); 

        // Set font for the table header
        $this->SetFont('Arial', 'B', 12);

        // Set table headers
        $this->Cell(0, 10, 'Grade Equivalents', 1, 1, 'C');
        
        // Set font for table content
        $this->SetFont('Arial', '', 12);

        $this->SetX(120);
        $this->Cell(26.5, 10, '1', 1, 0, 'C');
        $this->Cell(27, 10, 'A+', 1, 0, 'C');
        $this->Cell(26.5, 10, '> 98%', 1, 1, 'C');

        $this->SetX(120);
        $this->Cell(26.5, 10, '1.25', 1, 0, 'C');
        $this->Cell(27, 10, 'A', 1, 0, 'C');
        $this->Cell(26.5, 10, '96-98%', 1, 1, 'C');

        $this->SetX(120);
        $this->Cell(26.5, 10, '1.5', 1, 0, 'C');
        $this->Cell(27, 10, 'A-', 1, 0, 'C');
        $this->Cell(26.5, 10, '93-95%', 1, 1, 'C');

        $this->SetX(120);
        $this->Cell(26.5, 10, '1.75', 1, 0, 'C');
        $this->Cell(27, 10, 'B+', 1, 0, 'C');
        $this->Cell(26.5, 10, '90-92%', 1, 1, 'C');

        $this->SetX(120);
        $this->Cell(26.5, 10, '2', 1, 0, 'C');
        $this->Cell(27, 10, 'B', 1, 0, 'C');
        $this->Cell(26.5, 10, '87-89%', 1, 1, 'C');

        $this->SetX(120);
        $this->Cell(26.5, 10, '2.25', 1, 0, 'C');
        $this->Cell(27, 10, 'B-', 1, 0, 'C');
        $this->Cell(26.5, 10, '84-86%', 1, 1, 'C');

        $this->SetX(120);
        $this->Cell(26.5, 10, '2.5', 1, 0, 'C');
        $this->Cell(27, 10, 'C+', 1, 0, 'C');
        $this->Cell(26.5, 10, '81-83%', 1, 1, 'C');

        $this->SetX(120);
        $this->Cell(26.5, 10, '2.75', 1, 0, 'C');
        $this->Cell(27, 10, 'C', 1, 0, 'C');
        $this->Cell(26.5, 10, '78-80%', 1, 1, 'C');

        $this->SetX(120);
        $this->Cell(26.5, 10, '3', 1, 0, 'C');
        $this->Cell(27, 10, 'C-', 1, 0, 'C');
        $this->Cell(26.5, 10, '75-77%', 1, 1, 'C');

        $this->SetX(120);
        $this->Cell(26.5, 10, '4', 1, 0, 'C');
        $this->Cell(27, 10, 'D', 1, 0, 'C');
        $this->Cell(26.5, 10, '61-74%', 1, 1, 'C');

        $this->SetX(120);
        $this->Cell(26.5, 10, '5', 1, 0, 'C');
        $this->Cell(27, 10, 'F', 1, 0, 'C');
        $this->Cell(26.5, 10, '< 61%', 1, 1, 'C');

        $this->SetX(120);
        $this->Cell(26.5, 10, 'INC', 1, 0, 'C');
        $this->Cell(27, 10, '--', 1, 0, 'C');
        $this->Cell(26.5, 10, '--', 1, 1, 'C');
    }

    function AddAttendance()
    {
        $this->SetXY(120, 245);
        $this->SetTextColor(0, 0, 0); 

        // Set font for the table header
        $this->SetFont('Arial', 'B', 12);

        $this->Cell(40, 10, 'Attendance', 1, 0, 'C');
        $this->Cell(20, 10, 'Days', 1, 1, 'C');

        $this->SetFont('Arial', '', 12);
        $this->SetX(120);
        $this->Cell(40, 10, 'Absent', 1, 0, 'C');
        $this->Cell(20, 10, '1', 1, 1, 'C');
        
        $this->SetX(120);
        $this->Cell(40, 10, 'Present', 1, 0, 'C');
        $this->Cell(20, 10, '88', 1, 1, 'C');
    }
}

// Define the data for multiple students
$students = [
    [
        'name' => 'Kang Haerin',
        'studentNumber' => '20240001',
        'subject' => 'Java Programming',
        'schedule' => '(Wednesday) 02:00 PM - 03:00 PM',
        'academicYear' => '2024',
        'finalGrade' => 90,
        'activities' => [15, 15, 17, 17, 20, 20, 18, 15, 16, 20, 17],
        'quizzes' => [44, 36, 45, 50],
        'exams' => [93, 89]
    ],
    [
        'name' => 'Kim Min-ji',
        'studentNumber' => '20240002',
        'subject' => 'Java Programming',
        'schedule' => '(Thursday) 10:00 AM - 11:00 AM',
        'academicYear' => '2024',
        'finalGrade' => 88,
        'activities' => [10, 15, 12, 18, 16, 14, 20, 18, 19, 10, 17],
        'quizzes' => [50, 40, 45, 50],
        'exams' => [90, 85]
    ]
];


// Define the student to print
$toPrintStudent = 0; // Set to the index of the desired student (0-based index)

// Create the PDF object
$pdf = new PDF();
$pdf->AddPage();

$pdf->AddEquivalents();
$pdf->AddAttendance();

for ($i = 0; $i < count($students); $i++) {
    if ($i == $toPrintStudent) {
        $student = $students[$i];
        $pdf->AddBackgroundDiv();
        $pdf->AddPersonalInfo($student, '../profiles/2.png');

        $finalRemark = $student['finalGrade'] > 74 ? 'Passed' : 'Failed';
        $pdf->AddGrades($student['activities'], $student['quizzes'], $student['exams'], $student['finalGrade'], $finalRemark);
        break; // Exit the loop after generating the report for the desired student
    }
}

// Output the PDF
$pdf->Output();
ob_end_flush();
