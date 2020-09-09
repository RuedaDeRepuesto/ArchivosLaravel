<!doctype html>
<html lang="es">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/webapp.css') }}">
    <script src="https://kit.fontawesome.com/8b13a934b6.js" crossorigin="anonymous"></script>
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <title>Archivos front end</title>
  </head>
  <body style="background-image: url('{{ asset('img/catal.jpg') }}');">

  <div class="app-root">
  
    <nav class="navbar fixed-top navbar-app blurred-bg">
        <a class="navbar-brand" >Archivos</a>
        <div class="btn-group nav-bar-container">
          <a class="btn btn-app" role="button" onclick="fileSelector();" title="Agregar"><i class="fas fa-plus"></i></a>
          <a class="btn btn-app" role="button" onclick="refreshFiles();" title="Actualizar">
          <i class="fas fa-sync"></i>
          </a>
        </div>
    </nav>
    
    <div class="container-fluid app-container">
        <form id="form-upload">
        <input type="file" id="file-upload" name="file" style="display:none;">
        </form>
        <div class="files-container"  id="files"></div>
        <div class="loader" id="files-loader" style="display:none;"></div>
        <div class="fake-bottom"></div>
    </div>
    <nav class="navbar fixed-bottom navigation-bar blurred-bg">
      
    <a class="btn-nav"><i class="fas fa-home"></i> Inicio</a>
    <a class="btn-nav"><i class="fas fa-bars"></i> Tipos</a>
    <a class="btn-nav" data-toggle="modal" data-target="#modalOpciones"><i class="fas fa-cogs"></i> Opciones</a>
    </nav>

    <div id="context-menu" class="blurred-bg " data-file-id="">
    
    <a class="context-item" ><i class="fas fa-clone"></i> Duplicar</a>
    <a class="context-item" data-toggle="modal" data-target="#modalInfo"><i class="fas fa-info"></i> Información</a>
    <a class="context-item" id="delete" style="color:red;"><i class="fas fa-trash"></i> Eliminar</a>
    </div>


    

    <!-- Opciones -->
    <div class="modal fade" id="modalOpciones" tabindex="-1" role="dialog" aria-labelledby="titulo" aria-hidden="true">
      <div class="modal-dialog  modal-dialog-centered" role="document">
        <div class="modal-content blurred-bg">
          <div class="modal-header">
            <h5 class="modal-title mx-auto" >Opciones</h5>
            
          </div>
          <div class="modal-body">
            ...
          </div>
          <div class="modal-footer">
            <div class="btn-group">
              <a class="btn btn-app color">
                  Item1
              </a>
              <a class="btn btn-app color">
                  Item2
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- Info -->
    <div class="modal fade" id="modalInfo" tabindex="-1" role="dialog" aria-labelledby="titulo" aria-hidden="true">
      <div class="modal-dialog  modal-dialog-centered" role="document">
        <div class="modal-content blurred-bg">
          <div class="modal-body">
            
          </div>
          <div class="modal-footer">
            <a class="btn btn-app">
                Item1
            </a>
            <a class="btn btn-app">
                Item2
            </a>
          </div>
        </div>
      </div>
    </div>

    <!-- Tipos -->
    <div class="modal fade" id="modalTypes" tabindex="-1" role="dialog" aria-labelledby="titulo" aria-hidden="true">
      <div class="modal-dialog  modal-dialog-centered" role="document">
        <div class="modal-content blurred-bg">
          <div class="modal-body">
            
          </div>
        </div>
      </div>
    </div>

  </div>
  <div class="app-login">
    <div id="login-box" class="login-box blurred-bg">
    <h4>
      Entrar en Archivos
    </h4>
    <form id="login-form">
      <div class="form-group">
        <label for="userForm">Usuario</label>
        <input type="email" class="form-control" name="userForm" id="userForm" aria-describedby="emailHelp" placeholder="Usuario">

      </div>
      <div class="form-group">
        <label for="passForm">Contraseña</label>
        <input type="password" class="form-control" name="passForm" id="passForm" placeholder="contraseña">
      </div>
      
      <a id="submitForm" onclick="loginClick();" class="btn btn-app w-100 d-block">Entrar</a>
    </form>
    </div>
  </div>
  <div id="notification-panel">
        
    </div>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="{{ asset('js/jquery.js') }}">
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('js/file.js')}}"></script>
    <script src="{{ asset('js/utils.js')}}"></script>
    
    </body>
</html>