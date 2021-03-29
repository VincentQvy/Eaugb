<?php require_once "component/config.php"; ?>
<nav>
  <div >
    <ul >
      <li><a href="index.php">Home</a></li>
      <li><a href="projects.php">Projects</a></li>
      <li><a href="#modal1">Contact Us</a></li>
      <li>
        <form action="pays.php" method="post" >
          <select name='chooseCountry'>
            <option value="" disabled selected>Choose your country</option>
            <?php 
            $countries = CommandSQL($pdo, "SELECT * FROM countries");
            foreach ($countries as $country) {
              ?>
              <option value="<?php echo $country["id"] ?>"><?php echo $country["name"] ?></option>
              <?php
              }?>
          </select>
          <input type="submit" name="submit" value="Select Country">
        </form>
      </li>
    </ul>
  </div>
</nav>