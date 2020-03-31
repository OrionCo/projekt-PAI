<?php
require("header.php");
if(isset($_POST['setId'])){
    if($stmt = $con->prepare("SELECT u.`Username`, s.`Creation_date`, s.`Set_name` FROM `sets` s LEFT JOIN `users` u ON (s.`Creator_id` = u.`User_id`) WHERE s.`Set_id` = ?")){
        $stmt->bind_param('i', $_POST['setId']);
        $stmt->execute();
        $stmt->bind_result($setAuthor, $setDate, $setName);
        $stmt->fetch();
        $stmt->close();

        echo <<< setInfo
            <div class="setInfo">
                <div>
                    <h1 class="setInfoContent"><i class="icofont-notebook"></i> $setName</h1>
                </div>
                <div>
                    <span class="setInfoLabel">By:</span>
                    <span class="setInfoContent">$setAuthor</span>
                </div>
                <div>
                    <span class="setInfolabel">Creation date:</span>
                    <span class="setInfoContent">$setDate</span>
                </div>
            </div>
        setInfo;

        if($stmt = $con->prepare("SELECT t.`Term_name`, d.`Definition` FROM `sets` s LEFT JOIN `set_pairs` sp ON (s.`Set_id` = sp.`Set_id`) LEFT JOIN `terms` t ON (sp.`Term_id` = t.`Term_id`) LEFT JOIN `definitions` d ON (t.`Term_id` = d.`Term_id`) WHERE s.`Set_id` = ?")){
            $stmt->bind_param('i', $_POST['setId']);
            $stmt->execute();
            $stmt->store_result();
        
            if($stmt->num_rows() > 0){
                $stmt->bind_result($term, $definition);
                echo "<div class='list'>";
                while($stmt->fetch()){
                    echo <<< list
                    <div class="listItem">
                        <span class="termName">$term</span>
                        <div class="setLine"></div>
                        <span class="definition">$definition</span>
                    </div>
                    list;
                }
                echo "</div>";
            }
        }
    }
    
} else {
    header("location: user-panel.php");
}

require("footer.php");
?>