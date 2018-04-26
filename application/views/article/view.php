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
            <h2 class="page-header mt-4">Data Article <a href="<?php echo base_url()?>index.php/article/add" style="float:right" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> Add</a></h2>
            <div id="message">
                    
            </div>
            <table id="table" class="table table-striped table-bordered" cellspacing="0" width="100%">
              <thead>
                <tr style="background-color:#e1e1e1;">
                  <th width="5%">No</th>
                  <th width="40%">Title</th>
                  <th width="20%">Publish Date</th>
                  <th width="15%">Action</th>
                </tr>
              </thead>
              <tbody>
              </tbody>
            </table>
        </div>
      </div>
    </div>

    <!-- Bootstrap core JavaScript -->
    <script src="<?php echo base_url()?>assets/js/jquery.min.js"></script>
    <script src="<?php echo base_url()?>assets/js/bootstrap.bundle.min.js"></script>

    <script src="<?php echo base_url()?>assets/datatables/js/jquery.dataTables.min.js"></script>
    <script src="<?php echo base_url()?>assets/datatables/js/dataTables.bootstrap4.min.js"></script>
    <script src="<?php echo base_url()?>assets/bootbox/bootbox.min.js"></script>

    <script type="text/javascript">
      var table;
      var base_url = "<?php echo base_url()?>";

      $(document).ready(function(){
          
          table = $('#table').DataTable({

              "processing": true, //Feature control the processing indicator.
              "serverSide": true, //Feature control DataTables' server-side processing mode.
              "order": [], //Initial no order.

              // Load data for the table's content from an Ajax source
              "ajax": {
                  "url": "<?php echo site_url('article/ajax_list')?>",
                  "type": "POST"
              },

              //Set column definition initialisation properties.
              "columnDefs": [
              { 
                  "targets": [ -1 ], //last column
                  "orderable": false, //set not orderable
              },
              ],
          });

          bootstrap_alert = function() {}
            bootstrap_alert.success = function(message) {
              $('#message').html('<div class="alert alert-success"><a class="close" data-dismiss="alert">×</a><span>'+message+'</span></div>');
            }
      });

      function reload_table()
      {
          table.ajax.reload(null,false); //reload datatable ajax 
      }

      function delete_post(id)
      {
              // bootbox alert
        bootbox.confirm({ 
            size: "small",
            title: "Alert!",
            message: "Are you sure to remove this data?", 
            buttons: {
                confirm: {
                    label: 'Yes',
                    className: 'btn-success'
                },
                cancel: {
                    label: 'No',
                    className: 'btn-danger'
                }
            },
            callback: function(result)
            { 
                if(result){

                    $.ajax({
                        url : "<?php echo site_url('article/ajax_delete')?>/"+id,
                        type: "POST",
                        dataType: "JSON",
                        success: function(data)
                        {
                          
                            reload_table();
                            bootstrap_alert.success('Data Berhasil di Hapus');

                        },
                        error: function (jqXHR, textStatus, errorThrown)
                        {
                            alert('Error Removing data');
                        }

                    });
                }
            }
         });
      }
    </script>

  </body>

</html>