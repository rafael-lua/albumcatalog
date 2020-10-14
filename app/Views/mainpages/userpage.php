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

  <div class="column px-5 py-5 is-5 is-offset-1">
      <h2 class="subtitle"><strong>Crítica Recente</strong></h2>
      
      <?php if(isset($lastReview) && !empty($lastReview)) : ?>
        <div class="level mb-1">
            <div class="level-left">
              <div class="level-item">
                <?php echo esc($lastReview["album"]["note"]); ?> <i class="fas fa-star fa-lg is-size-6 my-2 mx-1" style="color: #ffcc00;"></i>
              </div>          
            </div>
            <div class="level-right">
              <div class="level-item">
                <strong><?php echo esc($lastReview["album"]["name"]); ?></strong>
              </div> 
            </div>
        </div>

        <hr class="has-background-grey-lighter my-1">
        
        <div class="content">
          <p>
            <br>
            <!-- The link directs the user to the album page of the review -->
            <strong><a><?php echo esc($lastReview["title"]); ?></a></strong> <small class="mx-1"><?php echo esc($lastReview["creationDate"]); ?></small>
            <p style="margin: 0; padding: 0;">
              <?php echo esc($lastReview["wording"]); ?>
            </p>
          </p>
        </div>
			<?php else : ?>
        <div class="content has-text-centered">
          <p style="margin: 0; padding: 0;">
            Esse usuário não escreveu críticas...
          </p>          
        </div>
      <?php endif; ?>
  </div>

  <div class="column px-5 py-5 is-5">

    <h2 class="subtitle"><strong>Últimas Classificações</strong></h2> 

    <?php if(isset($lastRankings) && !empty($lastRankings)) : ?>    

      <table class="table is-striped is-hoverable is-fullwidth">

        <thead>
          <tr>
            <th style="width:75%">Álbum</th>
            <th style="width:25%">Nota</th>
          </tr>
        </thead>

        <tbody>
          <?php foreach($lastRankings as $rank) : ?>
            <tr>
              <th><a><?php echo esc($rank["name"]); ?></a></th>
              <th><?php echo esc($rank["note"]); ?></th>
            </tr>
          <?php endforeach; ?>
        </tbody>

      </table>
    
    <?php else : ?>
      <div class="content has-text-centered">
        <p style="margin: 0; padding: 0;">
          Esse usuário não avaliou nenhum álbum...
        </p>          
      </div>
    <?php endif; ?>

  </div>           
 

</div>

