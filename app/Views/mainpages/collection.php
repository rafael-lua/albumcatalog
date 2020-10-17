
<?php

/* -------------------------------------------------------------------------- */
/*      It needs to have a check for private/session user id in here too!     */
/* -------------------------------------------------------------------------- */

 if(isset($collectionData)) : 

?>


  <!-- MAIN COLUMN -->
  <div class="columns my-5">
    <div class="column is-8 is-offset-2">
      <div class="box">

        <!-- HEADER COLUMN -->
        <div class="columns">
          <div class="column is-two-thirds">
            <h1 class="title is-size-5 has-text-weight-bold mb-3"><?php echo esc($collectionData["title"]); ?> <small class="is-italic is-size-7 has-text-grey">(id:<?php echo esc($collectionData["id"]); ?>)</small></h1>
            <div class="tags are-small">
              <?php if(!empty($collectionData["genres"])) : ?>
                <?php foreach($collectionData["genres"] as $genre) : ?>
                  <span class="tag is-small is-info is-light"><?php echo esc($genre["name"]); ?></span>
                <?php endforeach; ?>
              <?php else : ?>
                <span class="tag is-small is-info is-light">todos</span>
              <?php endif; ?>
            </div>
          </div>

          <div class="column is-one-third has-text-right">
            <p class="is-size-5"><a>@<?php echo esc($collectionData["user"]["name"]); ?></a></p>
            <p class="is-size-6"><small><?php if($collectionData["visible"] == "show"){echo esc("Público");}else{echo esc("Privado");} ?></small></p>
            <p class="is-size-7"><small>Número de álbums: <?php echo esc(count($collectionData["albums"])); ?></small></p>
          </div>
        </div>

        <hr class="my-1">

        <table class="table is-striped is-hoverable is-fullwidth mt-1">

          <thead>
            <tr>
              <th>Status</th>
              <th style="width:70%">Álbum</th>
              <th style="width: 15%">Opções</th>
            </tr>
          </thead>

          <tbody>
            <?php foreach($collectionData["albums"] as $album) : ?>
              <tr>
                <th>
                  <?php 
                    if($album["state"] == "completed"){echo esc("Completo");}
                    elseif($album["state"] == "dumped"){echo esc("Abandonado");}
                    elseif($album["waiting"] == "waiting"){echo esc("Esperando");}
                  ?>
                  <br>
                  <small class="has-text-grey"><?php echo esc($album["rank"]["note"]); ?><i class="fas fa-star is-size-7 mx-1" style="color: #ffcc00;"></i></small>
                </th>
                <td>              
                  <strong><a href="<?php echo base_url("search/showalbum/".$album["id"]); ?>"><?php echo esc($album["name"]); ?></a></strong> <small class="has-text-weight-normal is-italic">(<?php echo esc($album["year"]); ?>)</small><br>
                  <small class="has-text-grey">
                    <?php foreach($album["artists"] as $artist){echo esc($artist["name"] . " | ");} ?>
                  </small>            
                </td>
                <td>xxxxxxx</td>
              </tr>
            <?php endforeach; ?>
          </tbody>

        </table>
        

      </div>
    </div>
  </div>

<?php else : ?>
  <div class="box mx-5 my-6 has-text-centered">
    <p class="has-text-danger is-size-5 my-6">Coleção não encontrada!</p>
    <a href="<?php echo base_url(); ?>">Retornar</a>
  </div>
<?php endif; ?>