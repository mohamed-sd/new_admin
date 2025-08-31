<!-- الشريط الجانبي -->
<div class="sidebar" id="sidebar">
   <span class="menu-btn" onclick="toggleSidebar()">☰</span>
   <!-- Example: full sidebar logo (place inside sidebar) -->
<aside class="sidebar-logo" aria-label="Equipation logo">
<a href="#" title="Equipation" class="logo-accent" aria-hidden="false">
<span class="logo-text">
<span class="logo-name">Equipation</span>
<span class="logo-sub">حلول المعدات الذكية</span>
</span>
</a>
</aside>

   <ul>
      <?php 
      // Check the admin role
      if($_SESSION['role'] == "admin") { ?>
          <li><a href="dashbourd.php"> 🏠  الرئيسية </a></li>
          <li><a href="home.php"> ⏱️ التايم شييت </a></li>
          <li><a href="settings.php"> ⚙️ الاعدادات </a></li>

          <!-- المستهلكات -->
          <li class="has-submenu">
              <a href="#" onclick="toggleSubmenu(event)"> 📦 المستهلكات ▾</a>
              <ul class="submenu">
                  <li><a href="#"> ⛽ وقود </a></li>
                  <li><a href="#"> 🍽️ إعاشة </a></li>
                  <li><a href="#"> 🏠 سكن </a></li>
              </ul>
          </li>
      <?php } ?>
      
      <?php 
      // Check the user role
      if($_SESSION['role'] == "user") { ?>
         <li><a href="home.php"> ⏱️ التايم شييت </a></li>
         <li><a href="add_excavator.php"> ➕ ساعات حفار </a></li>
         <li><a href="add_tipper.php"> ➕ ساعات قلاب </a></li>
         <li><a href="add.php"> ➕ اضافة تايم شييت </a></li>
      <?php } ?>
      
      <li><a href="logout.php" style="font-weight:bold;"> 🚪 تسجيل الخروج</a></li>
   </ul>
</div>

<style>
   .submenu {
      display: none;
      list-style: none;
      padding-left: 20px;
   }
   .submenu li a {
      font-size: 14px;
      display: block;
   }
   .has-submenu.open > .submenu {
      display: block;
   }
</style>

<script>
   function toggleSubmenu(e) {
      e.preventDefault();
      let parent = e.target.closest(".has-submenu");
      parent.classList.toggle("open");
   }
</script>
