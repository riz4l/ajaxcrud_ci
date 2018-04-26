    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
      <div class="container">
        <a class="navbar-brand" href="<?php echo base_url()?>index.php/welcome">AJAX CRUD CODEIGNITER</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
          <ul class="navbar-nav ml-auto">
            <li class="nav-item <?php if(isset($link_welcome)){ echo $link_welcome;}?>">
              <a class="nav-link" href="<?php echo base_url()?>index.php/welcome">Home
                <span class="sr-only">(current)</span>
              </a>
            </li>
            <li class="nav-item <?php if(isset($link_article)){ echo $link_article;}?>">
              <a class="nav-link" href="<?php echo base_url()?>index.php/article">Article</a>
            </li>
          </ul>
        </div>
      </div>
    </nav>