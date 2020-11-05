<?php require APPROOT . '/views/inc/header.php'; ?>
<?php echo "<pre>", var_dump($data), "</pre>"; ?>
  <div class="pt-4">
    <form action="<?php echo URLROOT; ?>/exposures/edit/<?php echo $data['id']; ?>" method="post"> 
      <div class="form-group">
        <label for="exposure">Exposure</label>
        <input type="text" class="form-control form-control-lg <?php echo (!empty($data['exposure_err'])) ? 'is-invalid' : ''; ?>" name="exposure" id="exposure" value="<?php echo $data['exposure']; ?>">
        <span class="invalid-feedback"><?php echo $data['exposure_err']; ?></span>
      </div>
      <div class="form-group">
        <label for="description">Description</label>
        <textarea class="form-control form-control-lg <?php echo (!empty($data['description_err'])) ? 'is-invalid' : ''; ?>" name="description" id="description" rows="3"><?php echo $data['description']; ?></textarea>
        <span class="invalid-feedback"><?php echo $data['description_err']; ?></span>
      </div>
      <div class="form-group">
        <label for="category">Category</label>
        <input type="text" class="form-control form-control-lg <?php echo (!empty($data['category_err'])) ? 'is-invalid' : ''; ?>" name="category" id="category" value="<?php echo $data['category']; ?>">
        <span class="invalid-feedback"><?php echo $data['category_err']; ?></span>
      </div>
      <input type="submit" class="btn btn-success" value="Submit">
    </form>
  </div>
<?php require APPROOT . '/views/inc/footer.php'; ?>