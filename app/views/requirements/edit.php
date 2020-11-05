<?php require APPROOT . '/views/inc/header.php'; ?>
<?php //echo "<pre>", var_dump($data), "</pre>"; ?>
  <div class="pt-4">
    <form action="<?php echo URLROOT; ?>/requirements/edit/<?php echo $data['requirement']->ID; ?>" method="post"> 
      <div class="form-group">
        <label for="Requirement">Requirement</label>
        <input type="text" class="form-control form-control-lg" name="Requirement" id="Requirement" value="<?php echo $data['requirement']->Requirement; ?>">
      </div>
      <div class="form-group">
        <label for="Description">Description</label>
        <textarea class="form-control" name="Description" id="Description" rows="3"><?php echo $data['requirement']->Description; ?></textarea>
      </div>
      <div class="form-group">
        <label for="Chapters_ID">Chapter</label>
        <select class="form-control" name="Chapters_ID"  id="Chapter">
          <?php foreach($data['chapters'] as $chapter) : ?>
            <?php if($chapter->Chapter == $data['requirement']->Chapter): ?>
              <option value="<?php echo $chapter->ID; ?>" selected><?php echo $chapter->Chapter; ?></option>
            <?php else: ?>
              <option value="<?php echo $chapter->ID; ?>"><?php echo $chapter->Chapter; ?></option>
            <?php endif; ?>
          <?php endforeach; ?>
        </select>
      </div>
      <div class="form-group">
        <label for="Area">Area</label>
        <input type="text" class="form-control" name="Area" id="Area" value="<?php echo $data['requirement']->Area; ?>">
      </div>
      <div class="form-group">
        <label for="Standard">Standard</label>
        <input type="text" class="form-control" name="Standard"  id="Standard" value="<?php echo $data['requirement']->Standard; ?>">
      </div>
      <div class="form-group">
        <label for="Examples">Examples</label>
        <input type="text" class="form-control" name="Examples" id="Examples" value="<?php echo $data['requirement']->Examples; ?>">
      </div>
      <div class="form-group">
        <label for="Relevant">Relevant</label>
        <?php if($data['requirement']->Relevant == 1): ?>
        <input type="checkbox"class="form-control" name="Relevant" id="Relevant" value="1" checked>
        <?php else: ?>
          <input type="checkbox"class="form-control" name="Relevant" id="Relevant" value="1">
        <?php endif; ?>
      </div>
      <input type="submit" class="btn btn-success" value="Submit">
    </form>
  </div>
<?php require APPROOT . '/views/inc/footer.php'; ?>