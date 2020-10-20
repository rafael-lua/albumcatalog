<script>

function collectionModal() 
{
  let element = document.getElementById("collection_modal");
  element.classList.toggle("is-active");
}

function collectionEditModal(collection_id, collection_title, collection_genres) 
{
  let element = document.getElementById("collection_edit");
  element.classList.toggle("is-active");

  let button_element = document.getElementById("edit_value");
  if(button_element.value == "0" && !isNaN(collection_id))
  {
    button_element.value = collection_id;
  }
  else
  {
    button_element.value = 0;
  }

  let title_input = document.getElementById("edit_title");
  if(collection_title != undefined && title_input.value == "")
  {
    title_input.value = collection_title;
  }
  else
  {
    title_input.value = "";
  }

  if(collection_genres != undefined)
  {
    let genres = document.getElementsByClassName("edit_genre");
    for (let i = 0; i < genres.length; i++) {
      if(collection_genres.includes(genres[i].id))
      {
        genres[i].checked = true;
      }
      else
      {
        genres[i].checked = false;
      }
    }
  }
 
  
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

        <button class="button is-rounded is-primary is-small mb-1" onclick="collectionModal()">CRIAR COLEÇÃO</button>
        
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
              <th class="has-text-grey-dark" style="width:15%; text-align: right;"><small>Opções</small></th>
            </tr>
          </thead>

          <tbody>
            <?php foreach($userCollections as $collection) : ?>
              <tr>
                <?php if($collection["visible"] == "show"){$color = "success";}else{$color = "danger";} ?>
                <th class="has-text-<?php echo esc($color); ?>"><?php if($collection["visible"] == "show"){echo esc("Público");}else{echo esc("Privado");} ?></th>
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
                <td class="has-text-right">

                  <?php if($collection["locked"] == "1") : # Can't change anything ?>
                    <button class="button is-small" disabled>
                      <span class="icon is-small">
                        <i class="fas fa-lock"></i>
                      </span>
                    </button>

                  <?php elseif($collection["locked"] == "2") : # Can change visibibility and in the future can be hidden from the user's collections ?>
                    <form method="post" action="<?php echo base_url('togglecollectionvisibility');?>" style="display: inline;">
                      <button class="button is-small" type="submit" name="collectionid" value="<?php echo esc($collection["id"]); ?>" onclick="return confirm('Tem certeza que deseja alterar a visibilidade?');">
                        <span class="icon is-small">
                          <i class="fas fa-eye"></i>
                        </span>
                      </button>
                    </form>

                  <?php else : # Can be fully modified ?>

                    <form method="post" action="<?php echo base_url('togglecollectionvisibility');?>" style="display: inline;" onclick="return confirm('Tem certeza que deseja alterar a visibilidade?');">
                        <button class="button is-small" type="submit" name="collectionid" value="<?php echo esc($collection["id"]); ?>">
                          <span class="icon is-small">
                            <i class="fas fa-eye"></i>
                          </span>
                        </button>
                    </form>

                    <?php 
                      $edit_collection_id = $collection['id'];
                      $edit_collection_title = "'".$collection['title']."'";
                      $edit_collection_genre = "[]";
                      if(!empty($collection["genres"]))
                      {
                        $edit_collection_genre = "[";
                        foreach($collection["genres"] as $genre)
                        {
                          $edit_collection_genre = $edit_collection_genre."'".$genre["name"]."', ";
                        }
                        $edit_collection_genre = $edit_collection_genre."]";
                      }
                    ?>
                    <button class="button is-small" onclick="collectionEditModal(<?php echo esc($edit_collection_id); ?>, <?php echo esc($edit_collection_title); ?>, <?php echo esc($edit_collection_genre); ?> )">
                      <span class="icon is-small">
                        <i class="fas fa-edit"></i>
                      </span>
                    </button>                    

                    <form method="post" action="<?php echo base_url('deletecollection');?>" style="display: inline;" onclick="return confirm('Tem certeza que deseja deletar essa coleção?');">
                      <button class="button is-small" type="submit" name="collectionid" value="<?php echo esc($collection["id"]); ?>">
                        <span class="icon is-small">
                          <i class="fas fa-trash-alt" style="color: red;"></i>
                        </span>
                      </button>
                    </form>
                    
                  <?php endif; ?>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>

        </table>

      </div>
    
    </div>
            
  </div>

</div>



<!-- Edit collection modal -->
<div class="modal" id="collection_edit">
  <div class="modal-background"></div>
  <div class="modal-card">
    <header class="modal-card-head">
      <p class="modal-card-title"><strong>MODIFICAR COLEÇÃO</strong></p>
      <button class="delete" aria-label="close" onclick="collectionEditModal()"></button>
    </header>
    <section class="modal-card-body">
      <form method="post" action="<?php echo base_url('updatecollection');?>" style="display: inline;" id="edit_collection_form">
        <div class="field">
          <label class="label">Título</label>
          <div class="control">
            <input id="edit_title" class="input" type="text" placeholder="Nome da coleção..." name="collectiontitle" value="">
          </div>
        </div>

        <div class="field">
          <label class="label">Gêneros</label>
          <div class="control">
            <label class="checkbox mx-1">
              <input type="checkbox" name="genres[]" value="rock" id="rock" class="edit_genre">
              Rock
            </label>
            <label class="checkbox mx-1">
              <input type="checkbox" name="genres[]" value="classical" id="classical" class="edit_genre">
              Classical
            </label>
            <label class="checkbox mx-1">
              <input type="checkbox" name="genres[]" value="jazz" id="jazz" class="edit_genre">
              Jazz
            </label>
            <label class="checkbox mx-1">
              <input type="checkbox" name="genres[]" value="pop" id="pop" class="edit_genre">
              Pop
            </label>
            <label class="checkbox mx-1">
              <input type="checkbox" name="genres[]" value="electronic" id="electronic" class="edit_genre">
              Eletronic
            </label>
          </div>
        </div>
      </form>
    </section>
    <footer class="modal-card-foot">
      <button class="button is-success" form="edit_collection_form" type="submit" name="collectionid" value="0" id="edit_value">Confirmar</button>
      <button class="button" onclick="collectionEditModal()">Cancelar</button>
    </footer>
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
            <strong><a href="<?php echo base_url("search/showalbum/".$lastReview["albumId"]); ?>"><?php echo esc($lastReview["title"]); ?></a></strong> <small class="mx-1"><?php echo esc($lastReview["creationDate"]); ?></small>
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
              <th><a href="<?php echo base_url("search/showalbum/".$rank["albumId"]); ?>"><?php echo esc($rank["name"]); ?></a></th>
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

