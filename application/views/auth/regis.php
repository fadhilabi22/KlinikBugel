<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Registrasi Akun Operator Klinik</title>
    
    <link href="<?php echo base_url().'assets/' ?>login_style.css" rel='stylesheet' type='text/css' />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <script type="application/x-javascript"> 
        addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); 
        function hideURLbar(){ window.scrollTo(0,1); } 
    </script>
    
    <script>
        function myFunction()
        {
            alert("Proses Registrasi...")
        }
    </script>
</head>
<body>
    <div class="main">
        
        
        
        <div class="login">
            <div class="inset">
                
                <?php 
                // Menampilkan error validasi form 
                echo validation_errors('<div style="color:red; background: #fee; padding: 10px; border-radius: 4px; margin-bottom: 10px;">', '</div>');
                
                // Menampilkan flashdata error 
                if ($this->session->flashdata('error')): ?>
                    <div style="color:red; background: #fee; padding: 10px; border-radius: 4px; margin-bottom: 10px;">
                        <?php echo $this->session->flashdata('error'); ?>
                    </div>
                <?php endif; ?>

                <?php echo form_open('auth/regis_proses'); ?> 
                
                    <div>
                        <span><label>Registrasi Akun Operator Klinik</label></span>
                        
                        <span><label>Nama Lengkap</label></span>
                        <span>
                            <input type="text" name="nama" class="textbox" id="active_nama" 
                                value="<?php echo set_value('nama'); ?>" 
                                placeholder="nama lengkap">
                        </span>
                    </div>
                    
                    <div>
                        <span><label>Username</label></span>
                        <span>
                            <input type="text" name="username" class="textbox" id="active_username" 
                                value="<?php echo set_value('username'); ?>" 
                                placeholder="username">
                        </span>
                    </div>
                    
                    <div>
                        <span><label>Password</label></span>
                        <span>
                            <input type="password" name="password" class="password" placeholder="password">
                        </span>
                    </div>
                    
                    <div class="sign">
                        <div class="submit">
                            <input type="submit" name="submit" onclick="myFunction()" value="DAFTAR">
                        </div>
                        
                        <span class="forget-pass">
                            <a href="<?php echo base_url('auth'); ?>">Kembali ke Login</a> 
                            <div class="clear"></div>
                        </span>
                        
                        <div class="clear"></div>
                    </div>
                    
                </form>
            </div>
        </div>
    </div>
    
    <div class="copy-right">
        <p>Sistem Klinik &copy; <?php echo date('Y'); ?></p>
    </div>
</body>
</html>