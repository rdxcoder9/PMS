<?php
include './partials/_session.php';
include './partials/db.php';

$user_id = $_SESSION['user_id'];

// Fetch all data
function fetchData($conn, $table, $condition = '') {
    global $user_id;
    $query = "SELECT * FROM $table WHERE user_id = $user_id $condition";
    $result = mysqli_query($conn, $query);
    $data = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $data[] = $row;
    }
    return $data;
}

$personal_info = fetchData($conn, 'personal_info');
$career_objective = fetchData($conn, 'career_objective');
$education = fetchData($conn, 'education');
$experience = fetchData($conn, 'experience');
$skills = fetchData($conn, 'skills');
$certifications = fetchData($conn, 'certifications');
$projects = fetchData($conn, 'projects');
$publications = fetchData($conn, 'publications');
$awards = fetchData($conn, 'awards');
$hobbies = fetchData($conn, 'hobbies');
$languages = fetchData($conn, 'languages');
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>PMS Dashboard</title>
    <?php
    include './partials/head.php'
    ?>
  </head>
  <body>
    <div class="container-scroller">
      <!-- partial:../../partials/_navbar.php -->
      <?php
        include './partials/_navbar.php'
      ?>
      <!-- partial -->
      <div class="container-fluid page-body-wrapper">
        <!-- partial:../../partials/_sidebar.php -->
        <?php
        include './partials/_sidebar.php';
        ?>
        <!-- partial -->



        




        <div class="main-panel">
          <div class="content-wrapper">
            <div class="container my-4">
  <h2 class="text-center mb-4">Portfolio Dashboard</h2>

  <!-- Personal Info -->
  <div class="card mb-4">
    <div class="card-header">Personal Information</div>
    <div class="card-body">
      <?php if (!empty($personal_info)): ?>
        <?php $info = $personal_info[0]; ?>
        <p><strong>Name:</strong> <?= $_SESSION['name'] ?></p>
        <p><strong>Date of Birth:</strong> <?= $info['dob'] ?></p>
        <p><strong>Nationality:</strong> <?= $info['nationality'] ?></p>
        <p><strong>Phone:</strong> <?= $info['phone_number'] ?></p>
        <p><strong>Email:</strong> <?= $info['email_address'] ?></p>
        <p><strong>LinkedIn:</strong> <?= $info['linkedin_url'] ?></p>
        <p><strong>Gender:</strong> <?= $info['gender'] ?></p>
        <p><strong>Address:</strong> <?= $info['address'] ?></p>
      <?php else: ?>
        <p>No personal info available.</p>
      <?php endif; ?>
    </div>
  </div>

  <!-- Career Objective -->
  <div class="card mb-4">
    <div class="card-header">Career Objective</div>
    <div class="card-body">
      <?php if (!empty($career_objective)): ?>
        <p><?= $career_objective[0]['objective'] ?></p>
      <?php else: ?>
        <p>No career objective available.</p>
      <?php endif; ?>
    </div>
  </div>

  <!-- Education -->
  <div class="card mb-4">
    <div class="card-header">Education</div>
    <div class="card-body">
      <?php if (!empty($education)): ?>
        <ul class="list-group">
          <?php foreach ($education as $edu): ?>
            <li class="list-group-item">
              <strong><?= $edu['course_degree'] ?></strong> at <?= $edu['school_university'] ?> (<?= $edu['year'] ?>) - Grade: <?= $edu['grade_score'] ?>
            </li>
          <?php endforeach; ?>
        </ul>
      <?php else: ?>
        <p>No education records available.</p>
      <?php endif; ?>
    </div>
  </div>

  <!-- Experience -->
  <div class="card mb-4">
    <div class="card-header">Experience</div>
    <div class="card-body">
      <?php if (!empty($experience)): ?>
        <?php foreach ($experience as $exp): ?>
          <div class="mb-3">
            <h5><?= $exp['job_title'] ?> at <?= $exp['company_name'] ?></h5>
            <p><strong>From:</strong> <?= $exp['start_date'] ?> <strong>To:</strong> <?= $exp['end_date'] ?></p>
            <p><?= $exp['job_description'] ?></p>
          </div>
        <?php endforeach; ?>
      <?php else: ?>
        <p>No experience records available.</p>
      <?php endif; ?>
    </div>
  </div>

  <!-- Skills -->
  <div class="card mb-4">
    <div class="card-header">Skills</div>
    <div class="card-body">
      <?php if (!empty($skills)): ?>
        <ul class="list-group">
          <?php foreach ($skills as $skill): ?>
            <li class="list-group-item"><?= $skill['skill_name'] ?> - <?= $skill['skill_level'] ?></li>
          <?php endforeach; ?>
        </ul>
      <?php else: ?>
        <p>No skills available.</p>
      <?php endif; ?>
    </div>
  </div>

  <!-- Certifications -->
  <div class="card mb-4">
    <div class="card-header">Certifications</div>
    <div class="card-body">
      <?php if (!empty($certifications)): ?>
        <?php foreach ($certifications as $cert): ?>
          <div class="mb-3">
            <h5><?= $cert['certification_name'] ?> - <?= $cert['issuing_organization'] ?></h5>
            <p><strong>Issued:</strong> <?= $cert['issue_date'] ?> <strong>Expires:</strong> <?= $cert['expiry_date'] ?></p>
            <p><a href="<?= $cert['credential_url'] ?>" target="_blank"><?= $cert['credential_url'] ?></a></p>
          </div>
        <?php endforeach; ?>
      <?php else: ?>
        <p>No certifications available.</p>
      <?php endif; ?>
    </div>
  </div>

  <!-- Projects -->
  <div class="card mb-4">
    <div class="card-header">Projects</div>
    <div class="card-body">
      <?php if (!empty($projects)): ?>
        <?php foreach ($projects as $proj): ?>
          <div class="mb-3">
            <h5><?= $proj['project_title'] ?></h5>
            <p><strong>Technologies:</strong> <?= $proj['technology_used'] ?></p>
            <p><?= $proj['project_description'] ?></p>
          </div>
        <?php endforeach; ?>
      <?php else: ?>
        <p>No projects available.</p>
      <?php endif; ?>
    </div>
  </div>

  <!-- Publications -->
  <div class="card mb-4">
    <div class="card-header">Publications</div>
    <div class="card-body">
      <?php if (!empty($publications)): ?>
        <?php foreach ($publications as $pub): ?>
          <div class="mb-3">
            <h5><?= $pub['title'] ?></h5>
            <p><strong>Published In:</strong> <?= $pub['published_in'] ?> on <?= $pub['publication_date'] ?></p>
            <p><a href="<?= $pub['link_doi'] ?>" target="_blank"><?= $pub['link_doi'] ?></a></p>
            <p><?= $pub['abstract'] ?></p>
          </div>
        <?php endforeach; ?>
      <?php else: ?>
        <p>No publications available.</p>
      <?php endif; ?>
    </div>
  </div>

  <!-- Awards -->
  <div class="card mb-4">
    <div class="card-header">Awards & Achievements</div>
    <div class="card-body">
      <?php if (!empty($awards)): ?>
        <?php foreach ($awards as $award): ?>
          <div class="mb-3">
            <h5><?= $award['award_title'] ?> - <?= $award['presented_by'] ?></h5>
            <p><strong>Date:</strong> <?= $award['date_received'] ?></p>
            <p><?= $award['description'] ?></p>
          </div>
        <?php endforeach; ?>
      <?php else: ?>
        <p>No awards available.</p>
      <?php endif; ?>
    </div>
  </div>

  <!-- Hobbies -->
  <div class="card mb-4">
    <div class="card-header">Hobbies & Interests</div>
    <div class="card-body">
      <?php if (!empty($hobbies)): ?>
        <ul class="list-group">
          <?php foreach ($hobbies as $hobby): ?>
            <li class="list-group-item">
              <strong><?= $hobby['hobby_interest'] ?>:</strong> <?= $hobby['description'] ?>
            </li>
          <?php endforeach; ?>
        </ul>
      <?php else: ?>
        <p>No hobbies available.</p>
      <?php endif; ?>
    </div>
  </div>

  <!-- Languages -->
  <div class="card mb-4">
    <div class="card-header">Languages</div>
    <div class="card-body">
      <?php if (!empty($languages)): ?>
        <ul class="list-group">
          <?php foreach ($languages as $lang): ?>
            <li class="list-group-item"><?= $lang['language_name'] ?> - <?= $lang['proficiency_level'] ?></li>
          <?php endforeach; ?>
        </ul>
      <?php else: ?>
        <p>No languages available.</p>
      <?php endif; ?>
    </div>
  </div>

</div>

          </div>
          <!-- content-wrapper ends -->
          









          <!-- partial:../../partials/_footer.php -->
          <?php
            include './partials/_footer.php';
          ?>
          <!-- partial -->
        </div>
        <!-- main-panel ends -->
      </div>
      <!-- page-body-wrapper ends -->
    </div>
    <?php
     include './partials/scripts.php';
    ?>
  </body>
</html>