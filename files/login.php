<div class="flex items-center justify-center h-full">
    <form class="login" method="post" action="<?= $_SERVER['REQUEST_URI'] ?>">
        <p style="padding: 10px; text-align: center; font-size: 21px;">User login</p>
        <div style="margin: 0 20px;">
            <p class="h">Your email</p>
            <input type="text" placeholder="Email">
            <p class="h">Enter password</p>
            <input type="password" placeholder="Password">
            <button type="submit">login</button>
        </div>
    </form>
</div>