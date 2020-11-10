<?php require APPROOT . '/views/inc/header.php'; ?>
  <div class="card card-body bg-light mt-5">
    <h2>Add Risks</h2>
    <p>Create a new risk with this form</p>
    <form action="<?php echo URLROOT; ?>/risks/add" method="post">
      <div class="form-group">
        <label for="risk">Risks</label>
        <input type="text" name="risk" class="form-control <?php echo (!empty($data['risk_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['risk']; ?>" placeholder="Add a identification name for this risk...">
        <span class="invalid-feedback"><?php echo $data['risk_err']; ?></span>
      </div>
      <div class="form-group">
        <label for="description">Description</label>
        <input type="text" name="description" class="form-control <?php echo (!empty($data['description_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['description']; ?>" placeholder="Add the requirement text...">
        <span class="invalid-feedback"><?php echo $data['description_err']; ?></span>
      </div>
      <div class="form-group">
        <label for="reference">Reference</label>
        <input type="text" name="reference" class="form-control <?php echo (!empty($data['reference_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['reference']; ?>" placeholder="Add a reference...">
        <span class="invalid-feedback"><?php echo $data['reference_err']; ?></span>
      </div>
      <input type="submit" class="btn btn-success" value="Submit">
    </form>
  </div>
<?php require APPROOT . '/views/inc/footer.php'; ?>