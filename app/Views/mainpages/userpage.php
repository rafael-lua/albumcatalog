<script>

function collectionModal() 
{
  let element = document.getElementById("collection_modal");
  element.classList.toggle("is-active");
}

</script>



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
      <h1 class="title mx-5 mt-1"><strong>COLEÇÕES</strong></h1>
      <div class="box" style="max-height: 30em; overflow-y: scroll;">

        <button class="button is-rounded is-primary is-small my-1" onclick="collectionModal()">CRIAR COLEÇÃO</button>
        
        <div class="modal" id="collection_modal">
          <div class="modal-background"></div>
          <div class="modal-card">

            <header class="modal-card-head">
              <p class="modal-card-title"><strong>NOVA COLEÇÃO</strong></p>
              <button class="delete" onclick="collectionModal()" aria-label="close"></button>
            </header>

            <form action="<?php echo base_url('insertcollection');?>" method="post" id="collection_creation_form" method="post">
              <section class="modal-card-body">
                <div class="field">
                  <label class="label">Visibilidade</label>
                  <div class="control">
                    <label class="radio">
                      <input type="radio" name="visibility" value="show">
                      Público
                    </label>
                    <label class="radio">
                      <input type="radio" name="visibility" value="hide">
                      Privado
                    </label>
                  </div>
                </div>

                <div class="field">
                  <label class="label">Título</label>
                  <div class="control">
                    <input class="input" type="text" placeholder="Nome da coleção..." name="collectiontitle">
                  </div>
                </div>

                <div class="field">
                  <label class="label">Gêneros</label>
                  <div class="control">
                    <label class="checkbox mx-1">
                      <input type="checkbox" name="genres[]" value="rock">
                      Rock
                    </label>
                    <label class="checkbox mx-1">
                      <input type="checkbox" name="genres[]" value="classical">
                      Classical
                    </label>
                    <label class="checkbox mx-1">
                      <input type="checkbox" name="genres[]" value="jazz">
                      Jazz
                    </label>
                    <label class="checkbox mx-1">
                      <input type="checkbox" name="genres[]" value="pop">
                      Pop
                    </label>
                    <label class="checkbox mx-1">
                      <input type="checkbox" name="genres[]" value="electronic">
                      Eletronic
                    </label>
                  </div>
                </div>
              </section>
            </form>

            <footer class="modal-card-foot">
              <button class="button is-success" type="submit" form="collection_creation_form">Criar</button>
              <button class="button" onclick="collectionModal()">Cancelar</button>
            </footer>

          </div>
        </div>

        <!-- This should be through ajax interaction. -->
        <form>
          <?= csrf_field() ?>
          <div class="field">
            <div class="control ">
              <input type="text" name="collection_filter" class="input is-info my-1" placeholder="Filtrar por..." />
            </div>
          </div>
        </form>
        <table class="table is-striped is-hoverable is-fullwidth">

          <thead>
            <tr>
              <th class="has-text-grey-dark" style="width:10%"><small>Visibilidade</small></th>
              <th class="has-text-grey-dark" style="width:35%"><small>Coleção</small></th>
              <th class="has-text-grey-dark"><small>Gêneros</small></th>
              <th class="has-text-grey-dark" style="width:10%"><small>Opções</small></th>
            </tr>
          </thead>

          <tbody>
            <?php foreach($userCollections as $collection) : ?>
              <tr>
                <th><?php if($collection["visible"] == "show"){echo esc("Público");}else{echo esc("Privado");} ?></th>
                <th><a href="<?php echo base_url("collection/".$collection["id"]); ?>"><?php echo esc($collection["title"]); ?><a></th>
                <td>
                <?php if(!empty($collection["genres"])) : ?>
                  <div class="tags">
                    <?php foreach($collection["genres"] as $genre) : ?>
                        <span class="tag is-info is-light">
                          <?php echo esc($genre["name"]);?>
                        </span>
                    <?php endforeach; ?>
                  </div>
                <?php else : ?>
                  <span class="tag is-info is-light">
                    Todos
                  </span>
                <?php endif; ?>
                </td>
                <td>options</td>
              </tr>
            <?php endforeach; ?>
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
                <?php echo esc($lastReview["album"]["note"]); ?> <i class="fas fa-star is-size-6 my-2 mx-1" style="color: #ffcc00;"></i>
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
              <th><?php echo esc($rank["note"]); ?> <i class="fas fa-star is-size-7 my-1" style="color: #ffcc00;"></th>
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

