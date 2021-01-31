<?php if (!empty($_GET['action']) && $_GET['action'] == 'logout') { ?>
    <p class="info-tekst">U bent nu uitgelogd.</p>
<?php } else { ?>
    <a class="button-link" href="index.php?page=index">
        <div class="button-blue button-home">
            <img src="../../assets/img/icons/icon-arrow-white.svg" alt="Pijl naar links icoon">
            <p>Homegpage</p>
        </div>
    </a>
    <h1 class=" h1 login-header">Login</h1>
    <p class="login-sub">Enkel voor de <strong>beheerder</strong> of <strong>professionals</strong>.</p>

    <div class="login-form">
        <form class="form-grid" action="index.php?page=login" method="post">
            <div class="form-grid-items">
                <label for="login">E-mailadres</label>
                <input id="login" type="text" name="login" placeholder="Login" minlength="3" maxlength="64" required />
            </div>
            <div class="form-grid-items">
                <label for="password">Wachtwoord</label>
                <input id="password" type="password" name="password" placeholder="Wachtwoord" minlength="3" maxlength="64" required />
            </div>
            <div class="form-grid-items login-checkbox">
                <label class="login-checkbox" for="remember">Onthoud login</label>
                <input id="remember" type="checkbox" name="remember" />
            </div>
            <div class="form-grid-items login-grid-button">
                <button class="button-blue button-submit button-submit--login" type="submit" name="action" value="login">Login</button>
            </div>
        </form>
    </div>
<?php } ?>