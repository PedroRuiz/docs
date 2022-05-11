<?= $this->extend('App\\Views\\layouts\\main');

/**
 * Modules/calendar main view
 * 
 * @property calendar
 * @package Modular
 * @author Pedro Ruiz Hidalgo <ruizhidalgopedro@gmail.com>
 * @license https://opensource.org/licenses/MIT MIT license
 */
?>

<?= $this->section('css') ?>
<!-- ckeditor NEEDS THE LOAD BEFORE RENDER HTML, SO I CALL IT HERE -->
<script src="<?= base_url('Modules/Docs/ThirdParty/ckeditor/ckeditor.js') ?>"></script>
<script src="<?= base_url('Modules/Docs/ThirdParty/ckeditor/config.js') ?>"></script>
<?= $this->endSection() ?>

<?= $this->section('js') ?>
<script src="<?=base_url('Modules/Docs/ThirdParty/sweetalert2/dist/sweetalert2.all.min.js')?>"></script>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<section class="content">
  <div class="row">
    <div class="col-md-12">
      <div class="card card-outline card-info">
        <div class="card-header">
          <h3 class="card-title">
            <?= lang('docsModule.textEditor', [ $hiden['title'] === '' ? lang('docsModule.noTitle') : "<strong>{$hiden['title']}</strong>" ]); ?>
          </h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body col-md-12">
          <?= form_open(current_url(),'',$hiden) ?>
            <textarea name="editor1" id="editor1" rows="10" cols="80"><?=$content ?? null?></textarea>          
          <?= form_close() ?>
        </div>        
      </div>
    </div>
    <!-- /.col-->
  </div>
  <!-- ./row -->

</section>
<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script>
'use strict'


  let flash = '<?= $_SESSION['flash'] ?? null ?>'

  switch (flash) {
      case 'u+':
        Swal.fire({
          title: '<?= lang('docsModule.moduleName') ?>',
          text: '<?= lang('docsModule.u+') ?>',
          icon: 'success',
          showConfirmButton: false,
          timer: 2000
        });
        break;
      case 'i+':
        Swal.fire({
          title: '<?= lang('docsModule.moduleName') ?>',
          text: '<?= lang('docsModule.i+') ?>',
          icon: 'success',
          showConfirmButton: false,
          timer: 2000
        });
        break;
      case 'i-':
        Swal.fire({
          title: '<?= lang('docsModule.moduleName') ?>',
          text: '<?= lang('docsModule.i-') ?>',
          icon: 'error',
          showConfirmButton: false,
          timer: 2000
        });
        break;
      case 'u-':
        Swal.fire({
          title: '<?= lang('docsModule.moduleName') ?>',
          text: '<?= lang('docsModule.u-') ?>',
          icon: 'error',
          showConfirmButton: false,
          timer: 2000
        });
        break;
    }

  // Replace the <textarea id="editor1"> with a CKEditor 4
  // instance, using default configuration.
  CKEDITOR.replace('editor1',{
    language: '<?=service('request')->getLocale()?>',
  });
</script>
<?= $this->endSection() ?>