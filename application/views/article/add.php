<!DOCTYPE html>
<html lang="en">

  <head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Ajax CRUD Codeigniter 3</title>

  	<?php $this->load->view('style');?>

  </head>

  <body>

  <!-- Navigation -->
  <?php $this->load->view('navbar');?>
  <!-- END Navigation -->

	<!-- Page Content -->
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          <h2 class="page-header mt-4">Form Article <a href="<?php echo base_url()?>index.php/article" style="float:right" class="btn btn-primary btn-sm"><i class="fa fa-chevron-left"></i> Back</a></h2>
          <div id="message">
                    
          </div>
          <form name="form1" id="form" action="#" method="post" enctype="multipart/form-data">
            <div class="row">
              <div class="col-md-9">
                  <div class="form-group">
                    <label>Title</label>
                    <input type="text" name="article_title" class="form-control">
                    <input type="hidden" name="article_createdate" value="<?php echo date('Y-m-d H:i:s')?>" class="form-control">
                  </div>
                  <div class="form-group">
                    <label>Teaser</label>
                    <textarea name="article_teaser" class="form-control" rows="3" cols="4"></textarea>
                  </div>
                  <div class="form-group">
                    <label>Content</label>
                    <textarea name="article_content" id="article_content" class="form-control" rows="3" cols="4"></textarea>
                  </div>
              </div>
              <div class="col-md-3">
                  <div class="form-group">
                    <label>Publish Date</label>
                    <div class="input-group date" id="datetimepicker1" data-target-input="nearest">
                      <input type="text" name="article_publishdate" class="form-control datetimepicker-input" data-target="#datetimepicker1"/>
                      <div class="input-group-append" data-target="#datetimepicker1" data-toggle="datetimepicker">
                          <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                      <label>Category</label>
                      <select name="article_category_id" class="form-control">
                        <option>Select</option>
                        <?php foreach($category as $data_category){?>
                        <option value="<?php echo $data_category->category_id?>"><?php echo $data_category->category_name?></option>
                        <?php } ?>
                      </select>
                  </div>
                  <div class="form-group">
                    <label>Image</label>
                    <input type="file" name="article_image">
                  </div>
                  <div class="form-group">
                    <button type="button" id="btnSave" onclick="insert()" class="btn btn-success">Save</button>
                    <button type="button" id="btnReset" onclick="reset_form()" class="btn btn-warning">Reset</button>
                  </div>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>

    <!-- Bootstrap core JavaScript -->
    <script src="<?php echo base_url()?>assets/js/jquery.min.js"></script>
    <script src="<?php echo base_url()?>assets/js/bootstrap.bundle.min.js"></script>
    <script src="<?php echo base_url()?>assets/datatables/js/jquery.dataTables.min.js"></script>
    <script src="<?php echo base_url()?>assets/datatables/js/dataTables.bootstrap4.min"></script>
    <script src="<?php echo base_url()?>assets/bootstrap-datetimepicker/js/moment.js"></script>
    <script src="<?php echo base_url()?>assets/bootstrap-datetimepicker/js/tempusdominus-bootstrap-4.min.js"></script>
    <script src="<?php echo base_url()?>assets/bootbox/bootbox.min.js"></script>

    <script src="<?php echo base_url(); ?>assets/tinymce/tinymce.min.js"></script>
    <script>
      tinymce.init({
        selector: '#article_content',
        height: 300,
        theme: 'modern',
        plugins: [
        'advlist autolink lists link image charmap print preview hr anchor pagebreak',
        'searchreplace wordcount visualblocks visualchars code fullscreen',
        'insertdatetime media nonbreaking save table contextmenu directionality',
        'emoticons template paste textcolor colorpicker textpattern imagetools'
        ],
        toolbar1: 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
        toolbar2: 'print preview media | forecolor backcolor emoticons',
        image_advtab: true
      });
    </script>

    <script type="text/javascript">
      var table;
      var base_url = "<?php echo base_url()?>";

      $(document).ready(function(){
          
        $(function () {
        $('#datetimepicker1').datetimepicker({
             format: 'YYYY-MM-DD H:mm:ss',
          });
        });

      //set input/textarea/select event when change value, remove class error and remove text help block 
        $("input").change(function(){
          $(this).parent().removeClass('has-error');
          $(this).next().empty();
        })
        $("textarea").change(function(){
          $(this).parent().removeClass('has-error');
          $(this).next().empty();
        })
        $("select").change(function(){
          $(this).parent().removeClass('has-error');
          $(this).next().empty();
        })

        bootstrap_alert = function() {}
            bootstrap_alert.success = function(message) {
              $('#message').html('<div class="alert alert-success"><a class="close" data-dismiss="alert">×</a><span>'+message+'</span></div>');
            }
      });

      function reset_form()
      {
          $('#form').each(function(){
            this.reset();
          });
      }

      function insert()
      {
        $('#btnSave').text('saving...');
        $('#btnSave').attr('disable',true);
        var url;

        url = "<?php echo site_url('article/ajax_add')?>";
        tinyMCE.triggerSave();
        // ajax adding data to database
        var formData = new FormData($('#form')[0]);
        $.ajax({
          url : url,
          type: "POST",
          data: formData,
          contentType: false,
          processData: false,
          dataType: "JSON",
          success: function(data)
          {

              if(data.status)
              {
                  reset_form();
                  bootstrap_alert.success('Data Berhasil di Simpan');
              }
              else
              {
                  for (var i = 0; i < data.inputerror.length; i++) 
                  {
                      $('[name="'+data.inputerror[i]+'"]').parent().addClass('has-error'); //select parent twice to select div form-group class and add has-error class
                      $('[name="'+data.inputerror[i]+'"]').next().text(data.error_string[i]); //select span help-block class set text error string
                  }
              }
                $('#btnSave').text('save'); //change button text
                $('#btnSave').attr('disabled',false); //set button enable 


          },
          error: function (jqXHR, textStatus, errorThrown)
          {
              alert('Error adding / update data');
              $('#btnSave').text('save'); //change button text
              $('#btnSave').attr('disabled',false); //set button enable 

          }
        });
      }
    </script>

  </body>

</html>