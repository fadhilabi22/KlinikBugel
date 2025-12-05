<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login Sistem Klinik</title>
    
    <link href="<?php echo base_url().'assets/' ?>login_style.css" rel="stylesheet" type="text/css" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <script type="application/x-javascript"> 
        addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); 
        function hideURLbar(){ window.scrollTo(0,1); } 
    </script>


</head>
<body>
    <div class="main">
        <div class="login">
            <div class="inset">

                <!-- VALIDATION ERROR -->
                <?php if (validation_errors()): ?>
                    <div class="alert alert-error">
                        <?= validation_errors(); ?>
                    </div>
                <?php endif; ?>

                <!-- FLASHDATA ERROR -->
                <?php if ($this->session->flashdata('error')): ?>
                    <div class="alert alert-error">
                        <?= $this->session->flashdata('error'); ?>
                    </div>
                <?php endif; ?>

                <!-- FLASHDATA SUCCESS -->
                <?php if ($this->session->flashdata('success')): ?>
                    <div class="alert alert-success">
                        <?= $this->session->flashdata('success'); ?>
                    </div>
                <?php endif; ?>

                <?php echo form_open('auth/login_proses'); ?> 

                    <div>
                        <span><label>Username</label></span>
                        <input type="text" 
                               name="username"
                               value="<?= set_value('username'); ?>"
                               placeholder="Masukkan username Anda">
                        <small class="text-danger"><?= form_error('username'); ?></small>
                    </div>

                    <div>
                        <span><label>Password</label></span>
                        <input type="password" 
                               name="password"
                               placeholder="Masukkan password Anda">
                        <small class="text-danger"><?= form_error('password'); ?></small>
                    </div>

                    <div class="sign">
                        <div class="submit">
                            <input type="submit" name="submit" value="LOGIN">
                        </div>

                        <div class="forget">
                            <span class="forget-pass">
                                <a href="<?= base_url('auth/reset'); ?>">Lupa Password?</a>
                            </span>
                        </div>

                        <div class="clear"></div>
                    </div>

                    <div style="text-align: center; margin-top: 15px; padding-top: 15px; border-top: 1px solid #E2E8F0;">
                        <span style="color: #64748B; font-size: 0.9em;">
                            Belum punya akun? 
                            <a href="<?= base_url('auth/regis'); ?>" 
                               style="color: #0F766E; font-weight: 600; transition: 0.3s;">
                                Daftar di sini
                            </a>
                        </span>
                    </div>

                </form>
            </div>
        </div>
    </div>

    <div class="copy-right">
        <p>Sistem Klinik Bugel &copy; <?= date('Y'); ?> - 
            <a href="#">Kebijakan Privasi</a>
        </p>
    </div>
</body>
</html>
