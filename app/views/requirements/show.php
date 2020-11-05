<?php require APPROOT . '/views/inc/header.php'; ?>
<?php flash('requirement_message'); ?>
  <div class="pt-4">
      <?php //echo "<pre>", var_dump($data['notRelatedRisks']), "</pre>"; ?>
      <h1 class><?php echo $data['requirement']->Requirement; ?></h1>
      <p><?php echo $data['requirement']->Description; ?></p>

      <form>
        <div class="form-group">
          <label for="Chapter">Chapter</label>
          <input type="text" class="form-control"  id="Chapter" value="<?php echo $data['requirement']->Chapter; ?>" readonly>
        </div>
        <div class="form-group">
          <label for="Area">Area</label>
          <input type="text" class="form-control"  id="Area" value="<?php echo $data['requirement']->Area; ?>" readonly>
        </div>
        <div class="form-group">
          <label for="Standard">Standard</label>
          <input type="text" class="form-control"  id="Standard" value="<?php echo $data['requirement']->Standard; ?>" readonly>
        </div>
        <div class="form-group">
          <label for="Examples">Examples</label>
          <input type="text" class="form-control"  id="Examples" value="<?php echo $data['requirement']->Examples; ?>" readonly>
        </div>
        <div class="form-group">
          <label for="Relevant">Relevant</label>
          <?php if($data['requirement']->Relevant == 1): ?>
              <input type="checkbox"class="form-control" name="Relevant" id="Relevant" value="1" checked>
            <?php else: ?>
              <input type="checkbox"class="form-control" name="Relevant" id="Relevant" value="1">
          <?php endif; ?>
        </div>
      </form>
  </div>

  <div class="container">
    <form action="<?php echo URLROOT; ?>/requirements/relation/<?php echo $data['requirement']->ID; ?>" method="post"> 
      <div class="row">
        <div class="col-sm">
        <h4>releated risks:</h4>
        <select class="custom-select" multiple size="10" name="id_remove[]">
          <?php foreach($data['relatedRisks'] as $relatedRisk) : ?>
            <option value="<?php echo $relatedRisk->ID; ?>"><?php echo $relatedRisk->Risk; ?></option>
          <?php endforeach; ?> 
        </select>
        </div>
        <div class="col-sm text-center align-self-center">
          <div class="btn-group-vertical" role="group" aria-label="Basic example">
            <button name="action" value="addRisk" type="submit" class="btn btn-secondary"><-</button>
            <button name="action" value="removeRisk" type="submit" class="btn btn-secondary">-></button>
          </div>
        </div>
        <div class="col-sm">
        <h4>unreleated risks:</h4>
        <select class="custom-select" multiple size="10" name="id_add[]">
          <?php foreach($data['notRelatedRisks'] as $notRelatedRisk) : ?>
            <option value="<?php echo $notRelatedRisk->ID; ?>"><?php echo $notRelatedRisk->Risk; ?></option>
          <?php endforeach; ?> 
        </select>
        </div>
      </div>
    </form>
  </div>

  <div class="container">
    <form action="<?php echo URLROOT; ?>/requirements/relation/<?php echo $data['requirement']->ID; ?>" method="post"> 
      <div class="row">
        <div class="col-sm">
        <h4>releated exposures:</h4>
        <select class="custom-select" multiple size="10" name="id_remove[]">
          <?php foreach($data['relatedExposures'] as $relatedExposure) : ?>
            <option value="<?php echo $relatedExposure->ID; ?>"><?php echo $relatedExposure->Exposure; ?></option>
          <?php endforeach; ?> 
        </select>
        </div>
        <div class="col-sm text-center align-self-center">
          <div class="btn-group-vertical" role="group" aria-label="Basic example">
            <button name="action" value="addExposure" type="submit" class="btn btn-secondary"><-</button>
            <button name="action" value="removeExposure" type="submit" class="btn btn-secondary">-></button>
          </div>
        </div>
        <div class="col-sm">
        <h4>unreleated exposures:</h4>
        <select class="custom-select" multiple size="10" name="id_add[]">
          <?php foreach($data['notRelatedExposures'] as $notRelatedExposure) : ?>
            <option value="<?php echo $notRelatedExposure->ID; ?>"><?php echo $notRelatedExposure->Exposure; ?></option>
          <?php endforeach; ?> 
        </select>
        </div>
      </div>
    </form>
  </div>

<?php require APPROOT . '/views/inc/footer.php'; ?>