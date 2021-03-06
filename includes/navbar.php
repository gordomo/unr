<section class="menu cid-qwfntnWL41" once="menu" id="menu1-g" data-rv-view="2594">
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
            <a href="index.php">
              <img src="assets/images/logo2-1630x1629.png" alt="" title="" media-simple="true" style="height: 3.8rem;">
            </a>
          </span>
        </div>
      </div>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav nav-dropdown nav-right" data-app-modern-menu="true">
          <li class="nav-item">
            <a class="nav-link link text-secondary display-4" href="index.php">
              <span class="mbri-home mbr-iconfont mbr-iconfont-btn"></span>&nbsp;Inicio
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link link text-secondary display-4" href="categorias.php">
              <span class="mbri-edit mbr-iconfont mbr-iconfont-btn"></span>&nbsp;Apuntes
            </a>
          </li>
          <?php if(!$logged) { ?>
          <li class="nav-item">
            <a class="nav-link link text-secondary display-4" href="javascript:openRegisterModal()">
              <span class="mbri-smile-face mbr-iconfont mbr-iconfont-btn"></span>Registrarme &nbsp;<br>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link link text-secondary display-4" href="javascript:openAccessModal()">
              <span class="mbri-user mbr-iconfont mbr-iconfont-btn"></span>Acceso&nbsp;<br>
            </a>
          </li>
          <?php } ?>
          <?php if($logged) { ?>
          <li class="nav-item">
            <a class="nav-link link text-secondary display-4" href="pedidoparticular.php">
              <span class="mbri-cloud mbr-iconfont mbr-iconfont-btn"></span>Enviar Apunte&nbsp;<br>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link link text-secondary display-4" href="mispedidos.php">
              <span class="mbri-file mbr-iconfont mbr-iconfont-btn"></span>Mis Pedidos&nbsp;<br>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link link text-secondary display-4" href="includes/process_login.php?action=logout">
              <span class="mbri-login mbr-iconfont mbr-iconfont-btn"></span>Salir&nbsp;<br>
            </a>
          </li>
          <?php } ?>  
        </ul>
      </div>
    </nav>

    <!-- Modal -->
    <div id="myModal" class="modal" role="dialog">
      <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Acceso / Registrarme</h4>
          </div>
          <div class="modal-body">
            <div class="container">
              <div class="row">
                <div class="col-md-12">
                  <div class="panel panel-login">
                    <div class="panel-heading">
                      <div class="row">
                        <div class="col-md-6">
                          <a href="#" class="active" id="login-form-link">Iniciar sesión</a>
                        </div>
                        <div class="col-md-6">
                          <a href="#" id="register-form-link">Regístrate ahora</a>
                        </div>
                      </div>
                      <hr>
                    </div>
                    <div class="panel-body">
                      <div class="row">
                        <div class="col-lg-12">
                          <form id="login-form" action="includes/process_login.php" method="post" role="form" style="display: block;">
                            <input type="hidden" name="action" value="login">
                            <div class="form-group">
                              <input type="text" name="emailUsuario" id="emailUsuario" tabindex="1" class="form-control" placeholder="Email" value="">
                            </div>
                            <div class="form-group">
                              <input type="password" name="passwordUsuario" id="passwordUsuario" tabindex="2" class="form-control" placeholder="Contraseña">
                            </div>
                            <div class="form-group">
                              <div class="row">

                                <input type="submit" name="login-submit" id="login-submit" tabindex="3" class="form-control btn btn-login" value="Iniciar sesión">

                              </div>
                            </div>
                            <div class="form-group">
                              <div class="row">
                                <div class="col-lg-12">
                                  <div class="text-center">
                                    <a href="javascript:olvideMiContraseña();" tabindex="4" class="forgot-password">¿Has olvidado tu contraseña?</a>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </form>
                          <form id="register-form" action="includes/process_login.php" method="post" role="form" style="display: none;">
                            <input type="hidden" name="action" value="register">
                            <div class="form-group">
                              <input type="email" name="email" id="email" tabindex="5" class="form-control" placeholder="Correo electronico" value="" required="true">
                            </div>
                            <div class="form-group">
                              <input type="password" name="password" id="password" tabindex="6" class="form-control pass" placeholder="Contraseña" required="true">
                            </div>
                            <div class="form-group">
                              <a href="javascript:verPass();" id="verPass" class="link" style="color: #686b7b;">ver contraseña</a>
                            </div>
                            <div class="form-group">
                              <input type="text" name="name" id="name" tabindex="7" class="form-control" placeholder="Nombre" value="" required="true">
                            </div>
                            <div class="form-group">
                              <input type="text" name="lastName" id="lastName" tabindex="8" class="form-control" placeholder="Apellido" value="" required="true">
                            </div>
                            <div class="form-group">
                              <input type="number" name="tel" id="tel" tabindex="9" class="form-control" placeholder="Teléfono" value="" required="true">
                            </div>
                            <div class="form-group">
                              <input type="number" name="dni" id="dni" tabindex="10" class="form-control" placeholder="Documento" value="" required="true">
                            </div>
                            <div class="form-group">
                              <input type="text" name="dir" id="dir" tabindex="11" class="form-control" placeholder="Dirección" value="" required="true">
                            </div>

                             
                            <div class="form-group">
                              <input type="submit" style="margin:0;" name="register-submit" id="register-submit" tabindex="12" class="form-control btn btn-register" value="Crear cuenta">
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