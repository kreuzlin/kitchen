<?php require APPROOT . '/views/inc/header.php'; ?>
  <div class="card card-body bg-light mt-5">
    <h2>Add requirement</h2>
    <p>Create a new requirement with this form</p>
    <form action="<?php echo URLROOT; ?>/requirements/add" method="post">
      <div class="form-group">
        <label for="Requirement">Requirement</label>
        <input type="text" name="requirement" class="form-control <?php echo (!empty($data['requirement_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['requirement']; ?>" placeholder="Add a identification name for this requirement...">
        <span class="invalid-feedback"><?php echo $data['requirement_err']; ?></span>
      </div>
      <div class="form-group">
        <label for="description">Description</label>
        <input type="text" name="description" class="form-control <?php echo (!empty($data['description_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['description']; ?>" placeholder="Add the requirement text...">
        <span class="invalid-feedback"><?php echo $data['description_err']; ?></span>
      </div>
      <div class="form-group">
        <label for="chapters_id">Chapter</label>
        <select class="form-control" name="chapters_id">
          <?php foreach($data['chapters'] as $chapter) : ?>
            <?php if($chapter->id == $data['chapters_id']): ?>
              <option value="<?php echo $chapter->id; ?>" selected><?php echo $chapter->chapter; ?></option>
            <?php else: ?>
              <option value="<?php echo $chapter->id; ?>"><?php echo $chapter->chapter; ?></option>
            <?php endif; ?>
          <?php endforeach; ?>
        </select>
      </div>
      <div class="form-group">
        <label for="area">Area</label>
        <input type="text" name="area" class="form-control <?php echo (!empty($data['area_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['area']; ?>" placeholder="Add an area...">
        <span class="invalid-feedback"><?php echo $data['title_err']; ?></span>
      </div>
      <div class="form-group">
        <label for="standard">Standard</label>
        <input type="text" name="standard" class="form-control <?php echo (!empty($data['standard_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['standard']; ?>" placeholder="Name of related standard...">
        <span class="invalid-feedback"><?php echo $data['standard_err']; ?></span>
      </div>
      <div class="form-group">
        <label for="examples">Examples</label>
        <input type="text" name="examples" class="form-control <?php echo (!empty($data['examples_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['examples']; ?>" placeholder="Add examples of a succesful implementation of this control...">
        <span class="invalid-feedback"><?php echo $data['examples_err']; ?></span>
      </div>
      <div class="form-group">
        <label for="relevant">Relevant</label>
        <?php if($data['relevant'] == 1): ?>
        <input type="checkbox"class="form-control" name="relevant" id="relevant" value="1" checked>
        <?php else: ?>
          <input type="checkbox"class="form-control" name="relevant" id="relevant" value="1">
        <?php endif; ?>
      </div>
      <input type="submit" class="btn btn-success" value="Submit">
    </form>
  </div>
<?php require APPROOT . '/views/inc/footer.php'; ?>