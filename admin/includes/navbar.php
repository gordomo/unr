<section class="menu cid-qwfntnWL41" once="menu" id="menu1-4h" data-rv-view="3281">

    <nav class="navbar navbar-expand beta-menu navbar-dropdown align-items-center navbar-fixed-top navbar-toggleable-sm">
      <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <div class="hamburger">
          <span></span>
          <span></span>
          <span></span>
          <span></span>
        </div>
      </button>
      <div class="menu-logo">
        <div class="navbar-brand">
          <span class="navbar-logo">
            <a href="padmin.php">
             <img src="../assets/images/logo2-1630x1629.png" alt="tusapuntes" title="" media-simple="true" style="height: 3.8rem;">
           </a>
         </span>
         
       </div>
     </div>
     <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav nav-dropdown nav-right" data-app-modern-menu="true">
       <li class="nav-item">
        <a class="nav-link link text-secondary display-4" href="padmin.php">
          <span class="mbri-home mbr-iconfont mbr-iconfont-btn"></span>&nbsp;Panel de Admin</a>
        </li>
        <?php if(!$logged) { ?>
        <li class="nav-item">
          <a class="nav-link link text-secondary display-4" data-toggle="modal" data-target="#adminLogin">
            <span class="mbri-user mbr-iconfont mbr-iconfont-btn"></span>Acceso&nbsp;<br>
          </a>
        </li>
        <?php } else { ?>
        <li class="nav-item">
          <a class="nav-link link text-secondary display-4" href="../includes/process_login.php?action=logout">
            <span class="mbri-login mbr-iconfont mbr-iconfont-btn"></span>Salir&nbsp;<br>
          </a>
        </li>
        <?php } ?>
      </ul>
      
    </div>
  </nav>



   <!-- Modal -->
    <div id="adminLogin" class="modal" role="dialog">
      <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Acceso</h4>
          </div>
          <div class="modal-body">
            <div class="container">
              <div class="row">
                <div class="col-md-12">
                  <div class="panel panel-login">
                    
                    <div class="panel-body">
                      <div class="row">
                        <div class="col-lg-12">
                          <form id="login-form" action="../includes/process_login.php" method="post" role="form" style="display: block;">
                            <input type="hidden" name="action" value="login">
                            <input type="hidden" name="type" value="admin">
                            <div class="form-group">
                              <input type="text" name="emailUsuario" id="emailUsuario" tabindex="1" class="form-control" placeholder="Email" value="">
                            </div>
                            <div class="form-group">
                              <input type="password" name="passwordUsuario" id="passwordUsuario" tabindex="2" class="form-control" placeholder="Contraseña">
                            </div>
                            <div class="form-group">
                              <div class="row">

                                <input type="submit" name="login-submit" id="login-submit" tabindex="4" class="form-control btn btn-login" value="Iniciar sesión">

                              </div>
                            </div>
                            <div class="form-group">
                              <div class="row">
                                <div class="col-lg-12">
                                  <div class="text-center">
                                    <a href="javascript:olvideMiContraseña();" tabindex="5" class="forgot-password">¿Has olvidado tu contraseña?</a>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </form>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>  
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          </div>
        </div>

      </div>
    </div>


</section>