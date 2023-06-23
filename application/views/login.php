<div class="app-login p-0">
    <div class="row g-0 app-auth-wrapper">
        <div class="col-12 col-md-12 col-lg-12 auth-main-col text-center p-5">
            <div class="d-flex flex-column align-content-end">
                <div class="app-auth-body mx-auto">	
                    <div class="app-auth-branding mb-4">
                        <a class="app-logo" href="<?= base_url().'auth/login';?>">
                            <img class="logo-icon me-2" src="<?= base_url();?>assets/images/T-System.ico" alt="logo">
                        </a>
                    </div>
                    <h2 class="auth-heading text-center mb-5">ログイン</h2>
                    <div class="auth-form-container text-start">               
                        <?= form_open("", array('class' => 'auth-form login-form', 'method'=>'POST'));?>
                            <div class="email mb-3">
                                <label for="login_id">LoginID</label>
                                <input id="login_id" name="login_id" type="text" class="form-control signin-email" placeholder="ログインID" value="<?= set_value('login_id');?>" required="required">
                                <?= form_error('login_id');?>    
                            </div><!--//form-group-->
                            <div class="password mb-3">
                                <label for="signin-password">Password</label>
                                <input id="signin-password" name="password" type="password" class="form-control signin-password" placeholder="パスワード" value="<?= set_value('password');?>" required="required">
                                <?= form_error('password');?>
                            </div><!--//form-group-->

                            <div class="text-center">
                                <input type="submit" class="btn app-btn-primary w-100 theme-btn mx-auto" value="ログイン">
                            </div>
                            <div style="color:red;"><?= $error_message;?></div>
                            <!-- <span style="color: red;"></span> -->
                        <?= form_close();?>
                    </div><!--//auth-form-container-->	
                </div><!--//auth-body-->
            </div><!--//flex-column-->
        </div><!--//auth-main-col-->
    </div>
</div><!--//row-->
