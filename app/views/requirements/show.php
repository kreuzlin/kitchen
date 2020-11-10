<?php require APPROOT . '/views/inc/header.php'; ?>
<?php flash('requirement_message'); ?>
  <div class="pt-4">
      <?php //echo "<pre>", var_dump($data['notRelatedRisks']), "</pre>"; ?>
      <h1 class><?php echo $data['requirement']->requirement; ?></h1>
      <p><?php echo $data['requirement']->description; ?></p>

      <form>
        <div class="form-group">
          <label for="chapter">Chapter</label>
          <input type="text" class="form-control"  id="chapter" value="<?php echo $data['requirement']->chapter; ?>" readonly>
        </div>
        <div class="form-group">
          <label for="area">Area</label>
          <input type="text" class="form-control"  id="area" value="<?php echo $data['requirement']->area; ?>" readonly>
        </div>
        <div class="form-group">
          <label for="standard">Standard</label>
          <input type="text" class="form-control"  id="standard" value="<?php echo $data['requirement']->standard; ?>" readonly>
        </div>
        <div class="form-group">
          <label for="examples">Examples</label>
          <input type="text" class="form-control"  id="examples" value="<?php echo $data['requirement']->examples; ?>" readonly>
        </div>
        <div class="form-group">
          <label for="relevant">Relevant</label>
          <?php if($data['requirement']->relevant == 1): ?>
              <input type="checkbox"class="form-control" name="relevant" id="relevant" value="1" checked>
            <?php else: ?>
              <input type="checkbox"class="form-control" name="relevant" id="relevant" value="1">
          <?php endif; ?>
        </div>
      </form>
  </div>

  <div class="container">
    <form action="<?php echo URLROOT; ?>/requirements/relation/<?php echo $data['requirement']->id; ?>" method="post"> 
      <div class="row">
        <div class="col-sm">
        <h4>releated risks:</h4>
        <select class="custom-select" multiple size="10" name="id_remove[]">
          <?php foreach($data['relatedRisks'] as $relatedRisk) : ?>
            <option value="<?php echo $relatedRisk->id; ?>"><?php echo $relatedRisk->risk; ?></option>
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
            <option value="<?php echo $notRelatedRisk->id; ?>"><?php echo $notRelatedRisk->risk; ?></option>
          <?php endforeach; ?> 
        </select>
        </div>
      </div>
    </form>
  </div>

  <div class="container">
    <form action="<?php echo URLROOT; ?>/requirements/relation/<?php echo $data['requirement']->id; ?>" method="post"> 
      <div class="row">
        <div class="col-sm">
        <h4>releated exposures:</h4>
        <select class="custom-select" multiple size="10" name="id_remove[]">
          <?php foreach($data['relatedExposures'] as $relatedExposure) : ?>
            <option value="<?php echo $relatedExposure->id; ?>"><?php echo $relatedExposure->exposure; ?></option>
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
            <option value="<?php echo $notRelatedExposure->id; ?>"><?php echo $notRelatedExposure->exposure; ?></option>
          <?php endforeach; ?> 
        </select>
        </div>
      </div>
    </form>
  </div>

<?php require APPROOT . '/views/inc/footer.php'; ?>