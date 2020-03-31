<?php
    require("header.php");

    if($stmt = $con->prepare("SELECT u.`Username`, s.`Set_name`, s.`Creation_date`, s.`Set_id` FROM `users` u LEFT JOIN `sets` s ON (u.`User_id` = s.`Creator_id`) WHERE s.`Set_name` IS NOT NULL ORDER BY s.`Creation_date` DESC")){
        $stmt->execute();
        $stmt->store_result();

        if($stmt->num_rows() > 0){
            $stmt->bind_result($setAuthor, $setName, $creationDate, $setId);
            echo "<div class='list'>";
            while($stmt->fetch()){
                echo <<< list
                <div class="listItem setList">
                    <span class="itemName">$setName</span>
                    <span class="itemContent">Created by: $setAuthor</span>
                    <span class="itemContent">Created on: $creationDate</span>
                    <form action="set.php" method="post">
                        <input type="hidden" name="setId" value="$setId" />
                        <input type="submit" class="studySet studyListBtn" value="Study" />
                    </form>
                </div>
                list;
            }
            echo "</div>";
        }
        $stmt->close();
    }

    require("footer.php");
?>