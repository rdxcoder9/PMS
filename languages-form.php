
<?php
include './partials/_session.php';
include './partials/db.php';

$user_id = $_SESSION['user_id'];
$languages_data = [];

$query = "SELECT * FROM languages WHERE user_id = $user_id";
$result = mysqli_query($conn, $query);

while ($row = mysqli_fetch_assoc($result)) {
    $languages_data[] = $row;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Languages Form - PMS Dashboard</title>
  <?php include './partials/head.php'; ?>
</head>
<body>
  <div class="container-scroller">
    <?php include './partials/_navbar.php'; ?>
    <div class="container-fluid page-body-wrapper">
      <?php include './partials/_sidebar.php'; ?>

      <div class="main-panel">
        <div class="content-wrapper">
          <div class="col-12 grid-margin stretch-card">
            <div class="card">
              <div class="card-body">
                <form class="forms-sample mb-5" action="save_languages.php" method="POST">
                  <h4>Languages Known</h4>
                  <div id="languageContainer">
                    <?php if (count($languages_data) > 0): ?>
                      <?php foreach ($languages_data as $index => $language): ?>
                        <div class="language-section">
                          <div class="d-flex justify-content-between align-items-center">
                            <div class="language-heading">Language-<?php echo $index + 1; ?></div>
                            <button type="submit" name="delete" value="<?php echo $language['id']; ?>" class="btn btn-sm btn-danger">Delete</button>
                          </div>
                          <hr>
                          <input type="hidden" name="language_id[]" value="<?php echo $language['id']; ?>">

                          <div class="form-group mb-3">
                            <label>Language Name</label>
                            <input type="text" class="form-control" name="languageName[]" value="<?php echo htmlspecialchars($language['language_name']); ?>" required>
                          </div>

                          <div class="form-group mb-3">
                            <label>Proficiency Level</label>
                            <select class="form-control" name="proficiencyLevel[]" required>
                              <?php
                              $levels = ['Basic', 'Intermediate', 'Fluent', 'Native'];
                              foreach ($levels as $level) {
                                $selected = ($language['proficiency_level'] == $level) ? 'selected' : '';
                                echo '<option value="' . $level . '" ' . $selected . '>' . $level . '</option>';
                              }
                              ?>
                            </select>
                          </div>
                        </div>
                      <?php endforeach; ?>
                    <?php else: ?>
                      <div class="language-section">
                        <div class="language-heading">Language-1</div>
                        <hr>
                        <input type="hidden" name="language_id[]" value="">

                        <div class="form-group mb-3">
                          <label>Language Name</label>
                          <input type="text" class="form-control" name="languageName[]" required>
                        </div>

                        <div class="form-group mb-3">
                          <label>Proficiency Level</label>
                          <select class="form-control" name="proficiencyLevel[]" required>
                            <option value="Basic">Basic</option>
                            <option value="Intermediate">Intermediate</option>
                            <option value="Fluent">Fluent</option>
                            <option value="Native">Native</option>
                          </select>
                        </div>
                      </div>
                    <?php endif; ?>
                  </div>

                  <button type="button" class="btn btn-gradient-primary me-2" onclick="addLanguage()">Add Language</button>
                  <button type="submit" name="save" class="btn btn-gradient-primary me-2">
                    <?php echo (count($languages_data) > 0) ? 'Update' : 'Submit'; ?>
                  </button>
                </form>
              </div>
            </div>
          </div>
        </div>

        <script>
          let languageCount = <?php echo count($languages_data) ?: 1; ?>;

          function addLanguage() {
            languageCount++;
            const container = document.getElementById('languageContainer');
            const newSection = document.createElement('div');
            newSection.classList.add('language-section');

            newSection.innerHTML = `
              <div class="d-flex justify-content-between align-items-center">
                <div class="language-heading">Language-${languageCount}</div>
                <button type="button" class="btn btn-sm btn-warning" onclick="removeLanguage(this)">Remove</button>
              </div>
              <hr>
              <input type="hidden" name="language_id[]" value="">
              <div class="form-group mb-3">
                <label>Language Name</label>
                <input type="text" class="form-control" name="languageName[]" required>
              </div>
              <div class="form-group mb-3">
                <label>Proficiency Level</label>
                <select class="form-control" name="proficiencyLevel[]" required>
                  <option value="Basic">Basic</option>
                  <option value="Intermediate">Intermediate</option>
                  <option value="Fluent">Fluent</option>
                  <option value="Native">Native</option>
                </select>
              </div>
            `;

            container.appendChild(newSection);
            updateLanguageHeadings();
          }

          function removeLanguage(button) {
            button.closest('.language-section').remove();
            updateLanguageHeadings();
          }

          function updateLanguageHeadings() {
            const sections = document.querySelectorAll('.language-section');
            sections.forEach((section, index) => {
              const heading = section.querySelector('.language-heading');
              if (heading) {
                heading.textContent = `Language-${index + 1}`;
              }
            });
          }
        </script>

        <?php include './partials/_footer.php'; ?>
      </div>
    </div>
  </div>
  <?php include './partials/scripts.php'; ?>
</body>
</html>
