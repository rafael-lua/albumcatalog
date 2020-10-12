
<!-- MAIN COLUMN -->
<div class="columns my-5">
  <div class="column is-8 is-offset-2">
    <div class="box">

      <!-- HEADER COLUMN -->
      <div class="columns">
        <div class="column is-two-thirds">
          <h1 class="title is-size-5 has-text-weight-bold mb-2">Collection Name <small class="is-italic is-size-7 has-text-grey">(id:1)</small></h1>
          <nav class="breadcrumb has-bullet-separator is-small" aria-label="breadcrumbs">
            <ul>
                <li><a href="#">genre 1</a></li>
                <li><a href="#">genre 2</a></li>
            </ul>
          </nav>
        </div>

        <div class="column is-one-third has-text-right">
          <p class="is-size-5"><a>@user</a></p>
          <p class="is-size-6"><small>Público</small></p>
        </div>
      </div>

      <hr class="my-1">

      <table class="table is-striped is-hoverable is-fullwidth mt-1">

        <thead>
          <tr>
            <th>State</th>
            <th style="width:70%">Album name</th>
            <th style="width: 15%">OPTIONS</th>
          </tr>
        </thead>

        <tbody>
          <?php for($i = 1; $i <= 5; $i++) : ?>
            <tr>
              <th></th>
              <td>              
                <strong>Album name</strong> <small class="has-text-weight-normal">(9999)</small><br>
                <small class="has-text-grey is-italic">artist</small>            
              </td>
              <td></td>
            </tr>
          <?php endfor; ?>
        </tbody>

      </table>
      

    </div>
  </div>
</div>