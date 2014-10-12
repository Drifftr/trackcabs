<!DOCTYPE html>
<html lang="en-US">
<head>
    <title>WSO2 Geo Dashboard</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author"
          content="WSO2,Inc"/>
    <meta name="description"
          content="Geo-Dashboard"/>
    <meta charset="UTF-8"/>
    <meta name="keywords"
          content="Wso2,CEP,complex event processor,dashboard,vehicle tracking system"/>

    <link rel="icon" type="image/x-icon" href="<?= base_url() ?>assets/img/favicon.ico">
    <link href="<?= base_url() ?>assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?= base_url() ?>assets/css/login.css" rel="stylesheet" type="text/css"/>

    <script src="<?= base_url() ?>assets/js/jquery-2.1.1.min.js"></script>
    <script src="<?= base_url() ?>assets/js/jquery-ui.min.js"></script>
    <script type="text/javascript" src="<?= base_url() ?>assets/js/login.js"></script>
    <script src="<?= base_url() ?>assets/js/bootstrap.min.js"></script>

</head>
<body id="body_first">
<div class="row fixer">
    <div class="col-md-6 col-md-offset-3 text-center">
        <h3> WSO2 Geo-Dashboard </h3>
    </div>
    <div class="row fixer">
        <div class="col-md-8 col-md-offset-2 effect8" style="background-color: #D9D9D9;">
            <!-- TODO: Implement jagger equelent -->
            <?php if (!is_user_logged_in()) { ?>
                <div class="alert alert-warning alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">
                        &times;
                    </button>
                    <?=
                    print($this->session->flashdata('erro'));
                    ?>
                </div>
            <?php } ?>
            <br/>

            <div class="row fixer">
                <div class="col-md-10">
                    <?php
                    $attributes = array('class' => "form-horizontal", 'name' => "login", 'id' => "login_form");
                    echo form_open('authenticate', $attributes);
                    ?>
                    <div class="form-group">
                    <label for="login" class="col-sm-2 control-label">Username</label>

                    <div class="col-sm-10">
                        <input class="form-control" onkeyup="check_computer_number(this)" type="text" id="login"
                               name="username" required="required" placeholder="Username" autofocus/>
                    </div>
                </div>
                <div class="form-group">
                    <label for="password" class="col-sm-2 control-label">Password</label>

                    <div class="col-sm-10">
                        <input class="form-control" type="password" name="password" id="password"
                               required="required" placeholder="Password"/>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        <button type="submit" class="btn btn-primary">
                            <i class="icon-user icon-white"></i> Sign in
                        </button>
                    </div>

                </div>
                </form>
                <!-- <img style="display: none" id="loading_image" src="<?= base_url() ?>assets/images/images/logins/login_loading.gif" /> -->
            </div>

            <div class="col-md-2">
                <img style="width: 100%" src="<?= base_url() ?>assets/img/wso2-logo.png" id="fit11"/>
            </div>

        </div>

    </div>

</div>

</div>

<nav class="navbar navbar-default navbar-fixed-bottom" role="navigation">
    <div class="container">
        <a class="navbar-brand" href="#">V 1.0.0</a>
    </div>
</nav>

</body>

</html>
