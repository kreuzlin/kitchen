<?php require APPROOT . '/views/inc/header.php'; ?>
  <div class="card card-body bg-light mt-5">
    <h2>Add Exposure</h2>
    <p>Create a new exposure with this form</p>
    <form action="<?php echo URLROOT; ?>/exposures/add" method="post">
      <div class="form-group">
        <label for="exposure">Exposure</label>
        <input type="text" name="exposure" class="form-control <?php echo (!empty($data['exposure_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['exposure']; ?>" placeholder="Add a identification name for this exposure...">
        <span class="invalid-feedback"><?php echo $data['exposure_err']; ?></span>
      </div>
      <div class="form-group">
        <label for="description">Description</label>
        <input type="text" name="description" class="form-control <?php echo (!empty($data['description_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['description']; ?>" placeholder="Add the requirement text...">
        <span class="invalid-feedback"><?php echo $data['description_err']; ?></span>
      </div>
      <div class="form-group">
        <label for="category">Category</label>
        <input type="text" name="category" class="form-control <?php echo (!empty($data['category_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['category']; ?>" placeholder="Add a category...">
        <span class="invalid-feedback"><?php echo $data['category_err']; ?></span>
      </div>
      <input type="submit" class="btn btn-success" value="Submit">
    </form>
  </div>
<?php require APPROOT . '/views/inc/footer.php'; ?>