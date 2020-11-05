<?php require APPROOT . '/views/inc/header.php'; ?>
  <?php flash('requirement_message'); ?>
  <div class="row mb-3">
    <div class="col-md-6">
    <h1>Requirements</h1>
    </div>
    <div class="col-md-6">
      <a class="btn btn-primary pull-right" href="<?php echo URLROOT; ?>/requirements/add"><i class="fa fa-pencil" aria-hidden="true"></i> Add Requriement</a>
    </div>
  </div>
  <?php foreach($data['requirements'] as $requirement) : ?>
    <div class="card card-body mb-3">
      <h4 class="card-title"><?php echo $requirement->Requirement; ?></h4>
      <div class="bg-light p-2 mb-3">
        Area: <?php echo $requirement->Area; ?>
      </div>
      <p class="card-text"><?php echo $requirement->Description; ?></p>
      <a class="btn btn-dark" href="<?php echo URLROOT; ?>/requirements/show/<?php echo $requirement->ID; ?>">More</a>
    </div>
  <?php endforeach; ?>
<?php require APPROOT . '/views/inc/footer.php'; ?>