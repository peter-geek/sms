<div class="flex flex-col h-full">
    <div style="border-bottom: 1px solid #f60;">
        <div class="wd mx-auto flex items-center">
            <p style="font-size: 14px; font-weight: bold;">LAMERA PRIMARY SCHOOL</p>
            <?php
            $nav = 'stats';
            if (isset($_GET['nav'])) {
                $nav = $_GET['nav'];
            }
            $file = $nav . '.php';
            // if (!file_exists($file)) exit;
            ?>
            <nav class="flex-grow flex">
                <a href="./?nav=stats" <?= $nav == 'stats' ? 'class="active"' : '' ?>>Stats</a>
                <a href="./?nav=students" <?= $nav == 'students' ? 'class="active"' : '' ?>>Students</a>
                <a href="./?nav=classes" <?= $nav == 'classes' ? 'class="active"' : '' ?>>classes</a>
                <a href="./?nav=marksheet" <?= $nav == 'marksheet' ? 'class="active"' : '' ?>>Marksheet</a>
                <a href="./?nav=reports" <?= $nav == 'reports' ? 'class="active"' : '' ?>>Report cards</a>
                <a href="./?nav=teachers" <?= $nav == 'teachers' ? 'class="active"' : '' ?>>Teachers</a>
                <a href="./?nav=users" <?= $nav == 'users' ? 'class="active"' : '' ?>>Users</a>
                <a href="./?logout">Logout</a>
            </nav>
        </div>
    </div>
    <div class="flex-grow" style="overflow-y: auto;">
        <?php require $file; ?>
    </div>
</div>