<?= $this->extend('App\\Views\\layouts\\main');

/**
 * Modules/calendar list view
 * 
 * @property calendar
 * @package Modular
 * @author Pedro Ruiz Hidalgo <ruizhidalgopedro@gmail.com>
 * @license https://opensource.org/licenses/MIT MIT license
 */
?>

<?= $this->section('script') ?>
<script>
  'use strict'

  const modalDeleteButton = (id) => {
    Swal.fire({
      title: '<?= lang('docsModule.moduleName') ?>',
      text: '<?= lang('docsModule.deleteSure') ?>',      
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: '<?= lang('docsModule.deleteYes') ?>',
      cancelButtonText: '<?= lang('docsModule.deleteCancel') ?>',
    }).then((result) => {
      $.ajax({
        type: 'POST',
        url: '<?= base_locale('docs/delete') ?>',
        data: {
          documentId: id,
          <?= csrf_token() ?>: '<?= csrf_hash() ?>'
        }
      }).done((result) => {
        Swal.fire(
            '<?= lang('docsModule.moduleName') ?>',
            '<?= lang('docsModule.deleteDeleted') ?>',
            'success'
          )
          .then(() => {
            window.location.href = "<?= current_url() ?>"
          })
      })
    })
  };

  const modalRenameButton = (id, defaultValue) => {
    Swal.fire({
      title: "<?= lang('docsModule.moduleName') ?>",
      text: "<?= lang('docsModule.renameText') ?>",
      input: 'text',
      inputValue: defaultValue,
      showCancelButton: true
    }).then((result) => {
      
      if (result.value) {

        $.ajax({
          type: 'POST',
          url: '<?= base_locale('docs/rename') ?>',
          data: {
            documentId: id,
            newName: result.value,
            <?= csrf_token() ?>: '<?= csrf_hash() ?>'
          },
          success: (response) => {            
            window.location.href = "<?= current_url() ?>"
          },
          error: (response) => {
            
            if (response.responseJSON.code === 500) {
              Swal.fire({                
                icon: 'error',
                title: "<?= lang('docsModule.moduleName') ?>",
                text: "<?= lang('docsModule.renameDuplicate') ?>",
                showConfirmButton: false,
                timer: 1500
              })
            }
          }
        })
      }
    });    
  };

  $(function() {
    $('#documents').DataTable({
      paging: true,
      lengthChange: true,
      searching: true,
      ordering: true,
      info: true,
      autoWidth: true,
      responsive: true,
      language: {
        url: '<?= (service('request')->getLocale() === 'es') ? base_url('Modules/Docs/ThirdParty/datatables.spanish.json') : base_url('Modules/Docs/ThirdParty/datatables.english.json') ?>'
      }
    });

    let flash = '<?= $_SESSION['flash'] ?? null ?>'

    switch (flash) {
      case 'np':
        Swal.fire({
          title: '<?= lang('docsModule.moduleName') ?>',
          text: '<?= lang('docsModule.np') ?>',
          icon: 'error',
          showConfirmButton: false,
          timer: 2000
        });
        break;
      case 'r-':
        Swal.fire({
          title: '<?= lang('docsModule.moduleName') ?>',
          text: '<?= lang('docsModule.r-') ?>',
          icon: 'error',
          showConfirmButton: false,
          timer: 2000
        });
        break;
    }
  });
</script>
<?= $this->endSection() ?>

<?= $this->section('css') ?>
<!-- DataTables -->
<link rel="stylesheet" href="<?= template('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') ?>">
<link rel="stylesheet" href="<?= template('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') ?>">
<link rel="stylesheet" href="<?= template('plugins/datatables-buttons/css/buttons.bootstrap4.min.css') ?>">
<?= $this->endSection() ?>

<?= $this->section('js') ?>
<!-- DataTables  & Plugins -->
<script src="<?= template('plugins/datatables/jquery.dataTables.min.js') ?>"></script>
<script src="<?= template('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') ?>"></script>
<script src="<?= template('plugins/datatables-responsive/js/dataTables.responsive.min.js') ?>"></script>
<script src="<?= template('plugins/datatables-responsive/js/responsive.bootstrap4.min.js') ?>"></script>
<script src="<?= template('plugins/datatables-buttons/js/dataTables.buttons.min.js') ?>"></script>
<script src="<?= template('plugins/datatables-buttons/js/buttons.bootstrap4.min.js') ?>"></script>
<script src="<?= template('plugins/jszip/jszip.min.js') ?>"></script>
<script src="<?= template('plugins/pdfmake/pdfmake.min.js') ?>"></script>
<script src="<?= template('plugins/pdfmake/vfs_fonts.js') ?>"></script>
<script src="<?= template('plugins/datatables-buttons/js/buttons.html5.min.js') ?>"></script>
<script src="<?= template('plugins/datatables-buttons/js/buttons.print.min.js') ?>"></script>
<script src="<?= template('plugins/datatables-buttons/js/buttons.colVis.min.js') ?>"></script>
<!-- SweetAlert -->
<script src="<?= base_url('Modules/Docs/ThirdParty/sweetalert2/dist/sweetalert2.all.min.js') ?>"></script>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<section class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-header bg-info">
            <h3 class="card-title"><?= lang('docsModule.docsList') ?></h3>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <table id="documents" class="table table-bordered table-hover">
              <thead>
                <tr>
                  <th><?= lang('docsModule.tableId') ?></th>

                  <?php if ($_SESSION['user']['isAdmin']) : ?>
                    <th><?= lang('docsModule.tableUser') ?></th>
                  <?php endif; ?>

                  <th><?= lang('docsModule.tableDocumentName') ?></th>
                  <th><?= lang('docsModule.tableExcerpt') ?></th>
                  <th><?= lang('docsModule.tableCreatedAt') ?></th>
                  <th><?= lang('docsModule.tableUpdatedAt') ?></th>
                  <th><?= lang('docsModule.tableActions') ?></th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($documents as $document) : ?>
                  <tr>
                    <td><?= $document['id'] ?></td>

                    <?php if ($_SESSION['user']['isAdmin']) : ?>
                      <td><?= $document['username'] ?? null ?></td>
                    <?php endif; ?>

                    <td><?= $document['docname'] ?></td>
                    <td><?= substr(strip_tags($document['content']), 0, 50) . '...' ?></td>
                    <td><?= date('d-m-Y H:i', strtotime($document['created_at'])) ?></td>
                    <td><?= date('d-m-Y H:i', strtotime($document['updated_at'])) ?></td>
                    <td>
                      <div class="btn-group">
                        <a href="<?= base_locale("docs/list/{$document['id']}") ?>" role="button" class="btn btn-info" title="<?= lang('docsModule.altEdit') ?>"><i class="fas fa-pen"></i></a>
                        <button type="button" class="btn btn-warning" title="<?= lang('docsModule.altRename') ?>" onclick="modalRenameButton(<?= $document['id'] ?>,'<?= $document['docname'] ?>')"><i class="fas fa-file-signature"></i></buton>
                          <button type="button" class="btn btn-danger" title="<?= lang('docsModule.altDelete') ?>" onclick="modalDeleteButton(<?= $document['id'] ?>)"><i class="fas fa-trash"></i></buton>
                      </div>
                    </td>
                  </tr>
                <?php endforeach; ?>
              </tbody>
              <tfoot>
                <tr>
                  <th><?= lang('docsModule.tableId') ?></th>

                  <?php if ($_SESSION['user']['isAdmin']) : ?>
                    <th><?= lang('docsModule.tableUser') ?></th>
                  <?php endif; ?>

                  <th><?= lang('docsModule.tableDocumentName') ?></th>
                  <th><?= lang('docsModule.tableExcerpt') ?></th>
                  <th><?= lang('docsModule.tableCreatedAt') ?></th>
                  <th><?= lang('docsModule.tableUpdatedAt') ?></th>
                  <th><?= lang('docsModule.tableActions') ?></th>
                </tr>
              </tfoot>
            </table>
          </div>
          <!-- /.card-body -->
        </div>
        <!-- /.card -->
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->
  </div>
  <!-- /.container-fluid -->
</section>
<!-- /.content -->
<?= $this->endSection() ?>