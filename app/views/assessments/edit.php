<?php require APPROOT . '/views/inc/header.php'; ?>
  <?php flash('requirement_message'); ?>
  <?php //echo "<pre>", var_dump($data['answers']), "</pre>"; ?>
<div>
<div>
  <h1>Modify Assessment</h1>
</div>
<div>
<form action="<?php echo URLROOT; ?>/assessments/edit/<?php echo $data['id']; ?>" method="post">
    <label for="assessment">Assessment Title</label>
    <input type="text" class="form-control form-control-lg <?php echo (!empty($data['assessment_err'])) ? 'is-invalid' : ''; ?>" id="assessment" name="assessment" value="<?php echo $data['assessment']; ?>" placeholder="">
    <span class="invalid-feedback"><?php echo $data['assessment_err']; ?></span>

    <hr>
    <table id="dtBasicTab" class="table">
      <thead><tr>
        <th class="th-sm">applicable</th>
        <th class="th-sm">Exposure</th>
        <th class="th-sm">Description</th>
        <th class="th-sm">Category</th>
      </tr></thead>
      <tbody>
      <!-- https://www.tutorialrepublic.com/snippets/preview.php?topic=bootstrap&file=crud-data-table-for-database-with-modal-form -->
      <?php foreach($data['exposures'] as $exposure) : ?>
        <tr>
          <?php if (in_array($exposure->id, $data['answers'])): ?>
            <td><input type="checkbox" name="answers[]" value="<?php echo $exposure->id; ?>" checked></td>
          <?php else: ?>
            <td><input type="checkbox" name="answers[]" value="<?php echo $exposure->id; ?>"></td>
          <?php endif; ?>
          <td><?php echo $exposure->exposure; ?></td>
          <td><?php echo $exposure->description; ?></td>
          <td><?php echo $exposure->category; ?></td>
        </tr>
      <?php endforeach; ?>         
      </tbody>
    </table>
    <div class="btn-group btn-group-sm" role="group" aria-label="Basic">
      <input type="submit" class="btn btn-primary" value="submit">
    </div>
  </form>
  <hr>
</div>
<?php require APPROOT . '/views/inc/footer.php'; ?>