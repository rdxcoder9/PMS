<nav class="sidebar sidebar-offcanvas" id="sidebar">
  <ul class="nav">
    <li class="nav-item nav-profile">
      <a href="./" class="nav-link">
        <div class="nav-profile-image">
          <img src="<?php echo (!empty($_SESSION['photo'])) ? $_SESSION['photo'] : './assets/images/faces/face1.jpg'?>" alt="profile" />
          <span class="login-status online"></span>
          <!--change to offline or busy as needed-->
        </div>
        <div class="nav-profile-text d-flex flex-column">
          <span class="font-weight-bold mb-2"><?php echo ($_SESSION['name']); ?></span>
        </div>
        <i class="mdi mdi-bookmark-check text-success nav-profile-badge"></i>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="./dashboard.php">
        <span class="menu-title">Dashboard</span>
        <i class="mdi mdi-home menu-icon"></i>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="./edit-profile.php">
        <span class="menu-title">Edit Profile</span>
        <i class="mdi mdi-contacts menu-icon"></i>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="./personal_info.php">
        <span class="menu-title">Personal Information</span>
        <i class="mdi mdi-contacts menu-icon"></i>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="./education.php">
        <span class="menu-title">Education</span>
        <i class="mdi mdi-format-list-bulleted menu-icon"></i>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="./experience.php">
        <span class="menu-title">Experience</span>
        <i class="mdi mdi-format-list-bulleted menu-icon"></i>
      </a>
    </li>

    <li class="nav-item">
      <a class="nav-link" href="./skills.php">
        <span class="menu-title">Skills</span>
        <i class="mdi mdi-format-list-bulleted menu-icon"></i>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="./objective.php">
        <span class="menu-title">Objective</span>
        <i class="mdi mdi-format-list-bulleted menu-icon"></i>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="./project.php">
        <span class="menu-title">Project</span>
        <i class="mdi mdi-format-list-bulleted menu-icon"></i>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="./certifications.php">
        <span class="menu-title">Certification</span>
        <i class="mdi mdi-format-list-bulleted menu-icon"></i>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="./awards-achievements-form.php">
        <span class="menu-title">Award and Achievements</span>
        <i class="mdi mdi-format-list-bulleted menu-icon"></i>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="./volunteer-experience-form.php">
        <span class="menu-title">Volunteer Experience</span>
        <i class="mdi mdi-format-list-bulleted menu-icon"></i>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="./publications-research-form.php">
        <span class="menu-title">Publications / Research</span>
        <i class="mdi mdi-format-list-bulleted menu-icon"></i>
      </a>
    </li>
        <li class="nav-item">
      <a class="nav-link" href="./hobbies-interests-form.php">
        <span class="menu-title">Hobbies & Interests</span>
        <i class="mdi mdi-format-list-bulleted menu-icon"></i>
      </a>
    </li>
    </li>
        <li class="nav-item">
      <a class="nav-link" href="languages-form.php">
        <span class="menu-title">Language</span>
        <i class="mdi mdi-format-list-bulleted menu-icon"></i>
      </a>
    </li>

    <li class="nav-item">
      <a class="nav-link" href="template-page.php">
        <span class="menu-title">Template</span>
        <i class="mdi mdi-format-list-bulleted menu-icon"></i>
      </a>
    </li>
    
  </ul>
</nav>