<?php require APPROOT . '/views/inc/header.php'; ?>
<?php //echo "<pre>", var_dump($data), "</pre>"; ?>
  <div class="pt-4">
    <form action="<?php echo URLROOT; ?>/risks/edit/<?php echo $data['risk']->id; ?>" method="post"> 
      <div class="form-group">
        <label for="risk">Risk</label>
        <input type="text" class="form-control form-control-lg" name="risk" id="risk" value="<?php echo $data['risk']->risk; ?>">
      </div>
      <div class="form-group">
        <label for="description">Description</label>
        <textarea class="form-control" name="description" id="description" rows="3"><?php echo $data['risk']->description; ?></textarea>
      </div>
      <div class="form-group">
        <label for="reference">Reference</label>
        <input type="text" class="form-control" name="reference" id="reference" value="<?php echo $data['risk']->reference; ?>">
      </div>
      <input type="submit" class="btn btn-success" value="Submit">
    </form>
  </div>
<?php require APPROOT . '/views/inc/footer.php'; ?>