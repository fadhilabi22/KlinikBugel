<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Ubah Password Sistem Klinik</title>
    
    <link href="<?php echo base_url().'assets/' ?>login_style.css" rel='stylesheet' type='text/css' />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <script type="application/x-javascript"> 
        addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); 
        function hideURLbar(){ window.scrollTo(0,1); } 
    </script>
    
    <script>
        function myFunction()
        {
            alert("Proses Mengubah Password...")
        }
    </script>
</head>
<body>
    <div class="main">
        <div class="login">
            <div class="inset">
                
                <?php 
                // Menampilkan error validasi form (jika gagal input)
                echo validation_errors('<div style="color:red; background: #fee; padding: 10px; border-radius: 4px; margin-bottom: 10px;">', '</div>');
                
                // Menampilkan flashdata error (misalnya: password lama salah atau user tidak ditemukan)
                if ($this->session->flashdata('error')): ?>
                    <div style="color:red; background: #fee; padding: 10px; border-radius: 4px; margin-bottom: 10px;">
                        <?php echo $this->session->flashdata('error'); ?>
                    </div>
                <?php endif; ?>
                
                <?php echo form_open('auth/update_password'); ?> 
                
                    <div>
                        <span><label>Form Ubah Password Operator</label></span>
                        
                        <span><label>Username</label></span>
                        <span>
                            <input type="text" name="username" class="textbox" 
                                value="<?php echo set_value('username'); ?>" id="active">
                        </span>
                    </div>
                    
                    <div>
                        <span><label>Password Lama</label></span>
                        <span>
                            <input type="password" name="password_old" class="password" id="active">
                        </span>
                    </div>
                    
                    <div>
                        <span><label>Password Baru</label></span>
                        <span>
                            <input type="password" name="password_new" class="password_new" id="active">
                        </span>
                    </div>
                    
                    <div class="sign">
                        <div class="submit">
                            <input type="submit" name="submit" onclick="myFunction()" value="UBAH PASSWORD">
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