<?php require APPROOT . '/views/inc/header.php'; ?>
<?php //echo "<pre>", var_dump($data), "</pre>"; ?>
  <div class="pt-4">
    <form action="<?php echo URLROOT; ?>/risks/edit/<?php echo $data['risk']->ID; ?>" method="post"> 
      <div class="form-group">
        <label for="Risk">Risk</label>
        <input type="text" class="form-control form-control-lg" name="Risk" id="Risk" value="<?php echo $data['risk']->Risk; ?>">
      </div>
      <div class="form-group">
        <label for="Description">Description</label>
        <textarea class="form-control" name="Description" id="Description" rows="3"><?php echo $data['risk']->Description; ?></textarea>
      </div>
      <div class="form-group">
        <label for="Reference">Reference</label>
        <input type="text" class="form-control" name="Reference" id="Reference" value="<?php echo $data['risk']->Reference; ?>">
      </div>
      <input type="submit" class="btn btn-success" value="Submit">
    </form>
  </div>
<?php require APPROOT . '/views/inc/footer.php'; ?>