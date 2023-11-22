<?php

function calcGPA($mod_credit, $total_credits) {
    return ($mod_credit) / $total_credits;
}

function calcCredit($grade, $cu) {
    $grade_credit_array = ["A+"=>4.3, "A"=>4.0, "A-"=>3.7, "B+"=>3.3, "B"=>3.0, "B-"=>2.7, "C+"=>2.3, "C"=>2.0, "C-"=>1.7, "D+"=>1.3, "D"=>1.0, "F"=>0];
    $credit = $grade_credit_array[$grade] * $cu;
    return $credit;
}

if(isset($_POST['calculate'])) {
    $total_credit = $_POST['last_cu'] * $_POST["last_gpa"];
    $cu_taken = 0.00;
    $credit_taken = 0.00;
    for($j = 1; $j < 6; $j++) {
        $cu_taken += $_POST["cu$j"];
        $credit_taken += calcCredit($_POST["grade$j"], $_POST["cu$j"]);
    }
    $current_gpa = $_POST["last_gpa"];
    $current_cu = $_POST["last_cu"];
    $current_credit = $current_gpa * $current_cu;

    $total_credit = $current_credit + $credit_taken;
    $total_cu = $current_cu + $cu_taken;
    $total_gpa = calcGPA($total_credit, $total_cu);
    $gpa_taken = calcGPA($credit_taken, $cu_taken);
} else {
    $current_gpa = 0.00;
    $current_cu = 0.00;
}
echo "<h1 class='h1'>GPA Calculator v3</h1>";
?>

<html>
    <head>
        <title>GPA Calculator v3</title>
        <style>
            .table-header {
                background-color: black;
                color: white;
            }

        </style>
    </head>
    <body>
        <form method="post">
            <strong>cGPA thus far</strong>
            <input type='number' name='last_gpa' placeholder='Enter GPA' step='any' value='<?=$current_gpa?>'>
            <br><br>
            <strong>Course Units taken thus far</strong>
            <input type='number' name='last_cu' placeholder='Eneter CUs' step='any' value='<?=$current_cu?>'>
            <hr>
            <table border='1'>
                <tr class='table-header'>
                    <th>Course Name (Optional)</th>
                    <th>Course Units</th>
                    <th>Grade</th>
                </tr>
                
                <?php
                    for($i = 1; $i < 6; $i++) {
                        $course_value = "";
                        $cu_value = 0.00;
                        if(isset($_POST["calculate"])) {
                            $course_value = $_POST["course$i"];
                            $cu_value = $_POST["cu$i"];
                        }
                        echo "
                            <tr>
                            <td><input type='text' name='course$i' value='$course_value' placeholder='Enter course'></td>
                            <td><input type='number' name='cu$i' value='$cu_value' placeholder='Enter CU' step='any'></td>
                            <td><select name='grade$i'>";
                        $grade_array = ["A+", "A", "A-", "B+", "B", "B-", "C+", "C", "C-", "D+", "D", "F"];
                        foreach($grade_array as $g) {
                            $selected = "";
                            if(isset($_POST["grade$i"])) { 
                                if($_POST["grade$i"] == $g) {
                                    $selected = "selected";
                                }
                            }
                            echo "<option value='$g' {$selected}>$g</option>";
                        }
                        echo "
                            </select></td>
                            </tr>
                        ";
                    }
                ?>
                <tr><td class='table-header' colspan='3'><input type='submit' name='calculate' value='Calculate GPA'></td></tr>
            </table>
        </form>
    </body>
</html>

<?php
    if(isset($_POST["calculate"])) {
        echo "<strong>GPA this semester: </strong>" . $gpa_taken . "<br>";
        echo "<strong>Total cGPA: </strong>" . $total_gpa . "<br>";
    }
?>