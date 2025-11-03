<?php
session_start();
require 'vendor/autoload.php';

use PhpOffice\PhpWord\TemplateProcessor;
use Dompdf\Dompdf;

// Connect to database
$pdo = new PDO("mysql:host=localhost;dbname=pms", "root", "");

// Use session variables
$user_id = $_SESSION['user_id'];
$name = $_SESSION['name'];
$email = $_SESSION['email'];

// Fetch data
$user = $pdo->query("SELECT * FROM users WHERE id = $user_id")->fetch();
$personal = $pdo->query("SELECT * FROM personal_info WHERE user_id = $user_id")->fetch();
$career = $pdo->query("SELECT * FROM career_objective WHERE user_id = $user_id")->fetch();
$skills = $pdo->query("SELECT * FROM skills WHERE user_id = $user_id")->fetchAll();
$experiences = $pdo->query("SELECT * FROM experience WHERE user_id = $user_id")->fetchAll();
$education = $pdo->query("SELECT * FROM education WHERE user_id = $user_id")->fetchAll();
$certifications = $pdo->query("SELECT * FROM certifications WHERE user_id = $user_id")->fetchAll();

// Load Word template
$templateProcessor = new TemplateProcessor('./templates/resume_template_with_clone_blocks.docx');

// Set basic values
$templateProcessor->setValue('first_name', $user['first_name'] ?? '');
$templateProcessor->setValue('last_name', $user['last_name'] ?? '');
$templateProcessor->setValue('email_address', $personal['email_address'] ?? $email);
$templateProcessor->setValue('phone_number', $personal['phone_number'] ?? '');
$templateProcessor->setValue('linkedin_url', $personal['linkedin_url'] ?? '');
$templateProcessor->setValue('address', $personal['address'] ?? '');
$templateProcessor->setValue('career_objective', $career['objective'] ?? '');

// Skills
$templateProcessor->cloneBlock('skills_block', count($skills), true, true);
foreach ($skills as $i => $skill) {
    $templateProcessor->setValue("skill_name#" . ($i + 1), $skill['skill_name'] . ' (' . $skill['skill_level'] . ')');
}

// Experience
$templateProcessor->cloneBlock('experience_block', count($experiences), true, true);
foreach ($experiences as $i => $exp) {
    $templateProcessor->setValue("experience_title#" . ($i + 1), $exp['job_title']);
    $templateProcessor->setValue("experience_company#" . ($i + 1), $exp['company_name']);
    $templateProcessor->setValue("experience_description#" . ($i + 1), $exp['job_description']);
}

// Education
$templateProcessor->cloneBlock('education_block', count($education), true, true);
foreach ($education as $i => $edu) {
    $templateProcessor->setValue("education_degree#" . ($i + 1), $edu['course_degree']);
    $templateProcessor->setValue("education_school#" . ($i + 1), $edu['school_university']);
    $templateProcessor->setValue("education_year#" . ($i + 1), $edu['year']);
}

// Certifications
$templateProcessor->cloneBlock('certifications_block', count($certifications), true, true);
foreach ($certifications as $i => $cert) {
    $templateProcessor->setValue("certification_name#" . ($i + 1), $cert['certification_name']);
    $templateProcessor->setValue("certification_date#" . ($i + 1), $cert['issue_date']);
}

// Save Word file
$wordFile = 'generated_resume.docx';
$templateProcessor->saveAs($wordFile);

// Convert to PDF using Dompdf
$phpWord = \PhpOffice\PhpWord\IOFactory::load($wordFile);
$xmlWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'HTML');
ob_start();
$xmlWriter->save('php://output');
$html = ob_get_clean();

$dompdf = new Dompdf();
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();

// Output PDF
$pdfFile = 'generated_resume.pdf';
file_put_contents($pdfFile, $dompdf->output());

// Force download
header('Content-Type: application/pdf');
header('Content-Disposition: attachment; filename="resume.pdf"');
readfile($pdfFile);
exit;
?>