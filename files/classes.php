<?php
$class = '';
$classId = 0;
if(isset($_POST['submit'])) {
    $class = $_POST['class'];
    $classId = $_POST['classId'];
    $sql = "INSERT INTO classes (class) value('$class')";
    if($classId > 0) $sql = "UPDATE classes set class = '$class' where id = '$classId'";
    $db->query($sql);
    ?>
    <script> window.location = './?nav=classes'; </script>
    <?php
}
else if(isset($_GET['edit'])) {
    $classId = $_GET['edit'];
    $q = $db->query("SELECT * FROM classes where id = '$classId'");
    $d = $q->fetch_assoc();
    $class = $d['class'];
    $classId = $d['id'];
}
?>
<div class="wd mx-auto">
    <div style="border: 1px solid #f60; width: 600px; margin-top: 30px;" class="flex mx-auto">
        <div style="margin: 10px;" class="flex-grow">
            <table cellspacing="0" cellpadding="5" class="or_table">
                <tr class="thead">
                    <th>Class</th>
                    <th style="width: 10px;"></th>
                    <th style="width: 10px;"></th>
                </tr>
                <?php
                $q = $db->query("SELECT * FROM classes");
                while($d = $q->fetch_assoc()) {
                    ?>
                    <tr>
                        <td><?=$d['class']?></td>
                        <td>
                            <a href="./?nav=classes&edit=<?= $d['id'] ?>" class="ic ic_rounded ic_green f-jc-ic"><?= $svg['edit'] ?></a>
                        </td>
                        <td>
                            <a href="./?nav=classes&delete=<?= $d['id'] ?>" class="ic ic_rounded ic_red f-jc-ic"><?= $svg['delete'] ?></a>
                        </td>
                    </tr>
                    <?php
                }
                ?>
            </table>
        </div>
        <form action="<?= $_SERVER['REQUEST_URI'] ?>" method="post" style="width: 250px; padding: 10px;" class="mini-form">
            <p style="font-size: 15px; padding-bottom: 10px;">Classes</p>
            <input type="text" name="class" value="<?=$class?>" placeholder="e.g P.1">
            <input type="hidden" name="classId" value="<?=$classId?>">
            <button type="submit" name="submit">submit</button>
        </form>
    </div>
</div>