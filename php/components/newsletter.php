<?php
defined('SOLI_DEO') or die();

if (defined('NEWSLETTER_CLIENT_PATH')) {
    if (file_exists(NEWSLETTER_CLIENT_PATH))
        require_once NEWSLETTER_CLIENT_PATH;
}
if (defined('NEWSLETTER_SOLI_DEO')):
    ?>

    <?php
    $newsletterEmail = null;
    $newsletterName = null;
    $displayThanks = false;
    $verifyNewsletter = false;
    $error = "";

    if (!empty($_POST['email']) || !empty($_POST['name'])) {
        $newsletterEmail = filter_var(filter_input(INPUT_POST, "email"), FILTER_SANITIZE_STRING);
        $newsletterName = filter_var(filter_input(INPUT_POST, "name"), FILTER_SANITIZE_STRING);

        if (empty($newsletterEmail) || !filter_var($newsletterEmail, FILTER_VALIDATE_EMAIL)) {
            $error .= "&nbsp;Podałeś błędny adres e-mail.&nbsp;";
        }
        if (empty($newsletterName) || preg_match("/^([\p{L} ]+)$/ui", $newsletterName) !== 1) {
            $error .= "&nbsp;Podałeś błędne imię (może zawierać tylko litery).&nbsp;";
        }

        if (empty($error) && !empty($newsletterEmail) && !empty($newsletterName)) {
            $newsletterEmail = trim($newsletterEmail);
            $newsletterName = trim($newsletterName);
            $verifyNewsletter = true;
        }
    }

    if ($verifyNewsletter && !empty($_POST['g-recaptcha-response'])) {
        $options = array(
            'http' => array(
                'header' => "Content-type: application/x-www-form-urlencoded\r\n",
                'method' => 'POST',
                'content' => http_build_query(array(
                    "secret" => "6LfbHTAUAAAAAPdhKO-lKDzpSPexvbK_w5JKIcfB",
                    "response" => $_POST['g-recaptcha-response']
                ))
            )
        );
        $context = stream_context_create($options);
        $result = file_get_contents("https://www.google.com/recaptcha/api/siteverify", false, $context);
        if ($result !== FALSE) { /* Handle error */
            $data = json_decode($result, true);
            if ($data['success'] === true) {
                try {
                    $newsletterClient = new NewsletterClient();
                    $newsletterClient->subscribe($newsletterEmail, $newsletterName);
                    $displayThanks = true;
                    $verifyNewsletter = false;
                } catch (Exception $ex) {
                    $error = $ex->getMessage();
                    $verifyNewsletter = false;
                }
            } else {
                $error = "Przepraszamy – wystąpił błąd przy akceptacji reCAPTCHA..";
            }
        } else
            $error = "Błąd przy weryfikacji reCAPTCHA. Proszę spróbować jeszcze raz.";
    }
    ?>

    <?php
    if ($displayThanks):
        ?>
        <div class="alert alert-success" role="success">
            Adres <strong><?php echo $newsletterEmail; ?></strong> został dodany do bazy naszego newslettera. Dziękujemy za zapisanie 
            się! Obiecujemy, że nie będziemy wysyłać spamu, ogłoszeń, a jedynie niezbyt częste
            informacje o największych naszych wydarzeniach.<br />
            <small>Ponieważ nie przechowujemy ciasteczek – poniższy formularz nadal będzie Ci 
                się wyświetlał na naszej stronie.</small>
        </div>
        <?php
    endif;
    ?>



    <p  <?php if ($displayThanks) echo 'style="color: #bbb;"'; ?>>
    <?php echo (!empty($error) ? '<div class="alert alert-danger" role="alert">' . $error . '</div>' : 'Zapisz się na nasz newsletter!'); ?>
    </p>
    <p></p>
    <form action="?newsletter#newsletter" method="POST">
        <div class="form-group">
            <input type="text" name="email" class="form-control <?php if ($displayThanks) echo 'disabled'; ?>" id="input-email" placeholder="Twój e-mail" <?php echo($newsletterEmail == null ? "" : "value=\"" . $newsletterEmail . "\"") ?> <?php if ($displayThanks) echo 'style="color: #ccc;"'; ?>>
        </div>
        <div class="form-group">
            <input type="text" name="name" class="form-control <?php if ($displayThanks) echo 'disabled'; ?>" id="input-name" placeholder="Twoje imię" <?php echo($newsletterName == null ? "" : "value=\"" . $newsletterName . "\"") ?> <?php if ($displayThanks) echo 'style="color: #ccc;"'; ?>>
        </div>

    <?php if ($verifyNewsletter): ?>
        <script type="text/javascript">
            function g_captcha_done_callback() {
                $("#newsletter-click-submit-p").addClass('alert alert-warning');
                $("#newsletter-click-submit-p").css('font-weight', 'bold');
                $("#newsletter-captcha-alert").hide();
            }
        </script>
        <div class="form-group">
          <div class="alert alert-info" role="alert" id="newsletter-captcha-alert">Przepraszamy, ale ze względu na dużą ilość botów musimy weryfikować subskrypcje. Dziękujemy za wyrozumiałość!</div>
          <div class="g-recaptcha" data-callback="g_captcha_done_callback" data-sitekey="6LfbHTAUAAAAACMa5EpK8I3KW3gjXZxlkRD40ERs"></div>
        </div>
        <p id="newsletter-click-submit-p">Prosimy jeszcze raz kliknąć przycisk poniżej:</p>
    <?php endif; ?>
        
        <button type="submit" class="btn btn-success <?php if ($displayThanks) echo 'disabled'; ?>">Zapisuję się!</button>
    </form>
    <p></p>
    <?php
else:
    ?>
    <p><small>Nie można znaleźć klas newslettera.</small></p>
<?php
endif;
?>