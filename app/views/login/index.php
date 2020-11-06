<!DOCTYPE HTML>
<html>
	<head>
		<?php
        echo' <title>' . $v_title_page . '</title>';
        include_once 'app/views/public/adm_cabecalho.phtml';
        ?>
		<body>
        <div class="login">
        <h1>
            <a href="#">AUTENTICADOR <span class="fa fa-lock"></span> </a>
        </h1>
        <div class="login-bottom">
            <?php if (isset($v_erros) && !empty($v_erros)) { ?>
                <div class="alert alert-danger" role="alert">
                    <?php
                        print_r($v_erros);
                        unset($v_erros);
                    ?>
                </div>
            <?php } ?>
		<form action="/autenticador/Login/login" method="POST">
            <div class="col-md-6">
                <div class="login-mail">
                    <input type="text" placeholder="E-mail" required id="nome-utilizador" name="nome-utilizador">
                    <i class="fa fa-envelope"></i>
                </div>
                <div class="login-mail">
                    <input type="password" placeholder="Password" required id="password" name="password">
                        <i class="fa fa-lock"></i>
                    </div>
                </div>
                <div class="col-md-6 login-do">
                    <label class="hvr-shutter-in-horizontal login-sub">
                        <input type="submit" value="Login">
                    </label>
                <p></p>
                <a href="/autenticador/" class="hvr-shutter-in-horizontal">Ir ao site</a>
            </div>
        <div class="clearfix"></div>
    	</form>
    </div>
</div>
<div class="copy-right">
	<p> CCVF &copy; <?php echo date('Y');?> Todos os direitos reservados.</p><br>
</div>  
            <!---->
            <!--scrolling js-->
			<?php include_once 'app/views/public/adm_javascript.phtml'; ?>
            <!--//scrolling js-->
        </body>
</html>

