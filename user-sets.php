<?php
    require("header.php");

    if($stmt = $con->prepare("SELECT u.`Username`, s.`Set_name`, s.`Creation_date`, s.`Set_id` FROM `users` u LEFT JOIN `sets` s ON (u.`User_id` = s.`Creator_id`) WHERE s.`Set_name` IS NOT NULL ORDER BY s.`Creation_date` DESC")){
        $stmt->execute();
        $stmt->store_result();

        echo "<div class='list'>";
        if($stmt->num_rows() > 0){
            $stmt->bind_result($setAuthor, $setName, $creationDate, $setId);
            
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
            $stmt->close();
        }
        echo <<< addnew
            <div class="listItem addNew">
                <input type="button" id="addBtn" class="studySet addNewBtn" value="Add new set" />
                <form class="addNewTerm" action="addSet.php" method="post">
                    <input type="text" name="setName" placeholder="Set name.." required />
                    <input type="submit" class="studySet addNewBtn" value="Submit" />
                </form>
        addnew;
        echo "<div class='error'>";
        if(isset($_SESSION['error'])){
            echo $_SESSION['error'];
        }
        echo "</div>";
        echo "</div></div>";
    }

    require("footer.php");
?>