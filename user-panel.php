<?php require("header.php"); ?>
<?php
    if($stmt = $con->prepare("SELECT s.`Set_id`, `Set_name`, count(sp.`Term_id`) FROM `sets` s LEFT JOIN `set_pairs` sp ON (s.`Set_id` = sp.`Set_id`) GROUP BY `Set_name` ORDER BY s.Creation_date DESC LIMIT 4")){
        $stmt->execute();
        $stmt->store_result();

        if($stmt->num_rows > 0){
            $stmt->bind_result($setId, $setName, $termNumber);

            if(isset($lastSet)){
                echo <<< jumpin
                <div id="jumpIn">
                    <h1><i class="icofont-flash"></i>Jump back in:</h1>
                    <h1 id="lastSetName">$lastSet</h1>
                    <form action="set.php" method="post">
                        <input type="hidden" name="setId" value="$setId" />
                        <input type="submit" id="studybtn" value="Study" />
                    </form>
                </div>
                jumpin;
            } else {
                ?>
            <div id="jumpIn">
                <h1><i class="icofont-flash"></i>Create a new set!</h1>
                <a href="" id="studybtn">Create</a>
            </div>
            <?php
            }
            ?>
            <h2><i class="icofont-clock-time"></i> Recent sets created by you:</h2>
            <div id="setCards">
            <?php
            while($stmt->fetch()){
                echo <<< setCard
                    <div class="setCard">
                        <h3>$setName</h3>
                        <p>$termNumber terms</p>
                        <form action="set.php" method="post">
                            <input type="hidden" name="setId" value="$setId" />
                            <input type="submit" class="studySet studyListBtn" value="Study" />
                        </form>
                    </div>
                setCard;
            }
            $stmt->close();
        }
    }
?>
</div>
<?php require("footer.php") ?>