<div class="wd mx-auto">
    <p style="font-size: 25px; padding: 10px 0 6px 0;">Find Student</p>
    <form action="<?=$_SERVER['REQUEST_URI']?>" method="POST" class="searchbar flex">
        <div class="flex-grow" style="padding: 3px 5px;border: 1px solid #ffe3d0;margin-right: 5px;border-radius: 3px;">
            <input type="text" name="query" class="txt" placeholder="Search by name or email ...">
        </div>
        <button type="submit" name="search" class="searchbtn">search</button>
    </form>
    <div style="margin-top: 20px">
    <table cellspacing="0" cellpadding="5" class="or_table">
        <tr>
            <th>ID</th>
            <th>FIRST NAME</th>
            <th>LAST NAME</th>
            <th>EMAIL</th>
            <th>CLASS</th>
            <th style="width: 10px;"></th>
        </tr>
        <?php
        $sql = "SELECT * FROM `user` where acc_type = 'teacher'";
        if(isset($_POST['search'])) {
            $query = $_POST['query'];
            $sql = "SELECT * FROM `user` where acc_type = 'teacher' and (fname like '%$query%' or lname like '%$query%')";
        }
        $q = $db->query($sql) or die($db->error);
        while($d = $q->fetch_assoc()) {
            ?>
            <tr>
                <td><?=$d['id']?></td>
                <td><?=$d['fname']?></td>
                <td><?=$d['lname']?></td>
                <td><?=$d['email']?></td>
                <td></td>
                <td>
                    <a href="./?nav=teachers&edit=<?= $d['id'] ?>" class="ic ic_rounded ic_green f-jc-ic"><?= $svg['edit'] ?></a>
                </td>
            </tr>
            <?php
        }
        ?>
        </table>
    </div>
</div>