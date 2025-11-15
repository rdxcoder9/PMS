<?php
require 'vendor/autoload.php'; // Make sure PHPWord is installed via Composer

use PhpOffice\PhpWord\PhpWord;

// Sample data from your input
$userData = [
    'first_name' => 'John',
    'last_name' => 'Doe',
    'email' => 'john.doe@example.com',
    'career_objective' => 'Seeking a challenging role in software development.',
    'skills' => ['PHP', 'JavaScript', 'MySQL'],
    'education' => [
        ['degree' => 'B.Tech Computer Science', 'year' => '2020', 'grade' => '8.5 CGPA'],
        ['degree' => 'M.Tech Software Engineering', 'year' => '2023', 'grade' => '9.0 CGPA']
    ]
];

// Create PHPWord object and a new section
$phpWord = new PhpWord();
$section = $phpWord->addSection();

// Add Title
$section->addTitle("Resume for {$userData['first_name']} {$userData['last_name']}", 1);

// Add email and career objective
$section->addText("Email: {$userData['email']}");
$section->addText("Career Objective: {$userData['career_objective']}");

// Add Skills
$section->addTitle("Skills:", 2);
foreach ($userData['skills'] as $skill) {
    $section->addListItem($skill);
}

// Add Education
$section->addTitle("Education:", 2);
foreach ($userData['education'] as $edu) {
    $section->addText("{$edu['degree']} ({$edu['year']}) - Grade: {$edu['grade']}");
}

// Save DOCX file
$filename = 'Resume_' . $userData['first_name'] . '.docx';
$phpWord->save($filename, 'Word2007');

echo "Resume created: $filename";
?>
