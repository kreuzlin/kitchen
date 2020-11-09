<?php require APPROOT . '/views/inc/header.php'; ?>
<?php //echo "<pre>", var_dump($data), "</pre>"; ?>
  <div class="pt-4">
    <form action="<?php echo URLROOT; ?>/requirements/edit/<?php echo $data['requirement']->id; ?>" method="post"> 
      <div class="form-group">
        <label for="requirement">Requirement</label>
        <input type="text" class="form-control form-control-lg" name="requirement" id="requirement" value="<?php echo $data['requirement']->requirement; ?>">
      </div>
      <div class="form-group">
        <label for="description">Description</label>
        <textarea class="form-control" name="description" id="description" rows="3"><?php echo $data['requirement']->description; ?></textarea>
      </div>
      <div class="form-group">
        <label for="chapters_id">Chapter</label>
        <select class="form-control" name="chapters_id"  id="chapter">
          <?php foreach($data['chapters'] as $chapter) : ?>
            <?php if($chapter->chapter == $data['requirement']->chapter): ?>
              <option value="<?php echo $chapter->id; ?>" selected><?php echo $chapter->chapter; ?></option>
            <?php else: ?>
              <option value="<?php echo $chapter->id; ?>"><?php echo $chapter->chapter; ?></option>
            <?php endif; ?>
          <?php endforeach; ?>
        </select>
      </div>
      <div class="form-group">
        <label for="area">Area</label>
        <input type="text" class="form-control" name="area" id="area" value="<?php echo $data['requirement']->area; ?>">
      </div>
      <div class="form-group">
        <label for="standard">Standard</label>
        <input type="text" class="form-control" name="standard"  id="standard" value="<?php echo $data['requirement']->standard; ?>">
      </div>
      <div class="form-group">
        <label for="examples">Examples</label>
        <input type="text" class="form-control" name="examples" id="examples" value="<?php echo $data['requirement']->examples; ?>">
      </div>
      <div class="form-group">
        <label for="relevant">Relevant</label>
        <?php if($data['requirement']->relevant == 1): ?>
        <input type="checkbox"class="form-control" name="relevant" id="relevant" value="1" checked>
        <?php else: ?>
          <input type="checkbox"class="form-control" name="relevant" id="relevant" value="1">
        <?php endif; ?>
      </div>
      <input type="submit" class="btn btn-success" value="Submit">
    </form>
  </div>
<?php require APPROOT . '/views/inc/footer.php'; ?>