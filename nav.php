<!-- ######################     Main Navigation   ########################## -->
<nav>
    <ul class="small">
        <?php
        print '<li class="';
        if ($path_parts['filename'] == "Home") {
            print ' activePage ';
        }
        print '">';
        print '<a href="homepage.php">Home</a>';
        print '</li>';
        
        print '<li class="';
        if ($path_parts['filename'] == "Army") {
            print ' activePage ';
        }
        print '">';
        print '<a href="TerracottaArmy.php">Army</a>';
        print '</li>';
        
        print '<li class="';
        if ($path_parts['filename'] == "Garden") {
            print ' activePage ';
        }
        print '">';
        print '<a href="gardens.php">Gardens</a>';
        print '</li>';
        
        print '<li class="';
        if ($path_parts['filename'] == "Huangshan") {
            print ' activePage ';
        }
        print '">';
        print '<a href="Huangshan.php">Huangshan</a>';
        print '</li>';

        print '<li class="';
        if ($path_parts['filename'] == "Jiuzhaigou") {
            print ' activePage ';
        }
        print '">';
        print '<a href="jiuzhaigou.php">Jiuzhaigou</a>';
        print '</li>';
        
         print '<li class="';
        if ($path_parts['filename'] == "Lijiang") {
            print ' activePage ';
        }
        print '">';
        print '<a href="Lijiang.php">Lijiang</a>';
        print '</li>';
        
        print '<li class="';
        if ($path_parts['filename'] == "Join Us") {
            print ' activePage ';
        }
        print '">';
        print '<a href="form.php">Join Us</a>';
        print '</li>';
        ?>
    </ul>
</nav>