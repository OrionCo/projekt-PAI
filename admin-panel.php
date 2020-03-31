<?php require("header.php") ?>
        <?php 
        if($stmt = $con->prepare("SELECT s.`Set_name`, count(sp.`Term_id`), u.`Username` FROM `sets` s LEFT JOIN `set_pairs` sp ON (s.`Set_id` = sp.`Set_id`) LEFT JOIN `users` u ON (s.`Creator_id` = u.`User_id`) GROUP BY s.`Set_name` ORDER BY s.`Creation_date` DESC LIMIT 4")){
            $stmt->execute();
            $stmt->store_result();

            if($stmt->num_rows() > 0){
                $stmt->bind_result($setName, $termNumber, $setCreator);
                echo <<< h2
                <h2 id="adminRecent"><i class="icofont-clock-time"></i> Recently created sets:</h2>
                <div id="setCards">
                h2;
                while($stmt->fetch()){
                    echo <<< setCard
                    <div class="setCard">
                        <h3>$setName</h3>
                        <p>$termNumber terms</p>
                        <h4><i class="icofont-ui-user"></i> $setCreator</h4>
                    </div>
                    setCard;
                }
                echo "</div>";
            } else {
                ?>
                <div id="jumpIn">
                    <h1><i class="icofont-flash"></i>Create a new set!</h1>
                    <a href="" id="studybtn">Create set</a>
                </div>
                <?php
            }
        }

        if($stmt = $con->prepare("SELECT u.`Username`, u.`Join_date`, ul.`Is_admin` FROM `users` u LEFT JOIN `user_level` ul ON (u.`User_id` = ul.`User_id`) ORDER BY `Join_date` DESC LIMIT 4")){
            $stmt->execute();
            $stmt->store_result();

            if($stmt->num_rows() > 0){
                $stmt->bind_result($accName, $creationDate, $permissionLevel);
                echo <<< h2
                <h2><i class="icofont-clock-time"></i> Recently created accounts:</h2>
                <div id="accCards">
                h2;
                while($stmt->fetch()){
                    echo <<< accCard
                    <div class="accCard">
                        <h3>$accName</h3>
                        <p>Date created: $creationDate</p>
                    accCard;
                    if($permissionLevel == 1){
                        echo "<h4><i class='icofont-flash'></i> Admin</h4></div>";
                    } else {
                        echo "<h4><i class='icofont-ui-user'></i> User</h4></div>";
                    }
                }
                echo "</div>";
            }
        }
        ?>
<?php require("footer.php") ?>