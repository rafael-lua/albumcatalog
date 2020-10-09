<?php 
/* -------------------------------------------------------------------------- */
/*                                  User view                                 */
/* -------------------------------------------------------------------------- */
?>


<nav class="level py-1 px-5 has-background-info-light">
  <!-- Left side -->
  <div class="level-left">
    <div class="level-item">
    </div>
  </div>

  <!-- Left side -->
  <div class="level-right">
    <div class="level-item">
      <a class="has-text-info"><strong><i class="fas fa-cog"></i> OPTIONS</strong></a>
    </div>
  </div>
</nav>


<div class="columns is-vcentered">

  <div class="column px-6 py-1 is-one-third">
    <div class="card">
      <div class="card-content">
        <div class="media">
          <div class="media-left">
            <i class="fas fa-user fa-4x"></i>
          </div>
          <div class="media-content">
            <p class="title is-4"><strong>Nome do usuário</strong></p>
            <p class="subtitle is-6 has-text-info"><em>@username</em></p>
          </div>
        </div>

        <div class="content">
          Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque aliquam mi lorem, nec lacinia 
          nisi accumsan nec. Praesent cursus orci varius pellentesque dapibus.
          <hr>
          <a><i class="fab fa-itunes-note fa-lg mr-1"></i>
          <i class="fab fa-twitter fa-lg mr-1"></i>
          <i class="fab fa-facebook fa-lg mr-1"></i>
          <i class="fab fa-google-plus-square fa-lg mr-1"></i>
          <i class="fab fa-spotify fa-lg mr-1"></i>
          <i class="fab fa-soundcloud fa-lg mr-1"></i>
          <i class="fab fa-bandcamp fa-lg mr-1"></i></a>
        </div>
      </div>
    </div>
  </div>

  <div class="column px-6 py-6">
    <div class="box">
      <div class="block mb-1"><strong>ATIVIDADES</strong></div>
      <table class="table is-striped is-hoverable is-fullwidth">

        <thead>
          <tr>
            <th style="width:15%"></th>
            <th></th>
          </tr>
        </thead>

        <tbody>
          <?php for($i = 1; $i <= 5; $i++) : ?>
            <tr>
              <th>07/09/0709</th>
              <td>Activity description goes here</td>
            </tr>
          <?php endfor; ?>
        </tbody>
      
      </table>

    </div>
  </div>

</div>

<hr>

<div class="columns">

  <div class="column px-6 py-3">

    <div class="container">
      <h1 class="title mx-5 mt-1"><strong>COLLECTIONS</strong></h1>
      <div class="box" style="max-height: 30em; overflow-y: scroll;">
        <!-- This should be through ajax interaction. -->
        <form>
          <?= csrf_field() ?>
          <div class="field">
            <div class="control ">
              <input type="text" name="collection_filter" class="input is-info" placeholder="Filtrar por..." />
            </div>
          </div>
        </form>
        <table class="table is-striped is-hoverable is-fullwidth">

          <thead>
            <tr>
            <th style="width:5%"></th>
              <th style="width:25%"></th>
              <th></th>
              <th style="width:10%"></th>
            </tr>
          </thead>

          <tbody>
            <?php for($i = 1; $i <= 10; $i++) : ?>
              <tr>
                <th>public</th>
                <th><a>Collection name<a></th>
                <td>Collection genres</td>
                <td>options</td>
              </tr>
            <?php endfor; ?>
          </tbody>

        </table>

      </div>
    
    </div>
            
  </div>

</div>


<div class="columns">

  <div class="column px-6 py-6 is-8 is-offset-2">
      <h2 class="subtitle"><strong>Crítica Recente</strong></h2>
      <div class="level mb-1">
          <div class="level-left">
            <div class="level-item">
                5 <i class="fas fa-star fa-lg is-size-6 my-2 mx-1" style="color: #ffcc00;"></i>
            </div>          
          </div>
          <div class="level-right">
            <div class="level-item">
              <strong>Album name</strong>
            </div> 
          </div>
      </div>

      <hr class="has-background-grey-lighter my-1">
      
      <div class="content">
        <p>
          <br>
          <!-- The link directs the user to the album page of the review -->
          <strong><a>Titulo da review</a></strong> <small>00/00/0000</small>
          <p style="margin: 0; padding: 0;">
            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut urna tellus, malesuada id odio in, 
            euismod pulvinar dui. Fusce fermentum eleifend scelerisque. Etiam consectetur 
            turpis ut odio lacinia, sed pulvinar nulla gravida. Proin iaculis lacus arcu, 
            viverra commodo erat sollicitudin nec. Ut pulvinar ipsum sit amet elit sodales finibus. 
            Ut ultrices sit amet turpis vel dictum. Nulla vel rutrum felis. Mauris nec iaculis arcu. 
            Etiam tristique pulvinar aliquet. Nullam tincidunt id velit vitae luctus. Proin vitae vehicula nunc. 
            Nullam eros nibh, lacinia ut felis in, auctor pharetra nulla. Maecenas ut lectus mauris. Donec sagittis 
            ornare mi.
          </p>
        </p>
      </div>
				
  </div>

 

</div>

