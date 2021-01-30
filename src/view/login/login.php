<main>
    <?php if (!empty($_GET['action']) && $_GET['action'] == 'logout') { ?>
        <div>Je bent nu uitgelogd</div>
    <?php } else { ?>
        <form action="index.php?page=login" method="post">
            <div>
                <label for="login">Login</label>
                <input id="login" type="text" name="login" placeholder="Login" minlength="3" maxlength="64" required />
            </div>
            <div>
                <label for="password">Wachtwoord</label>
                <input id="password" type="text" name="password" placeholder="Wachtwoord" minlength="3" maxlength="64" required />
            </div>
            <div>
                <label for="remember">Onthoud login</label>
                <input id="remember" type="checkbox" name="remember" />
            </div>
            <button type="submit" name="action" value="login">Login</button>
        </form>
    <?php } ?>
</main>