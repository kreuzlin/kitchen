<?php require APPROOT . '/views/inc/header.php'; ?>
  <?php flash('requirement_message'); ?>
  <?php //echo "<pre>", var_dump($data['answers']), "</pre>"; ?>
<div>
<div>
  <h1>Start new Assessment</h1>  <!--  there are problem with the error handling: 1. seleted answers are not remembered and 2. error notification if not checkbox is ticked-->
</div>
<div>
<form action="<?php echo URLROOT; ?>/assessments/add/" method="post">
    <label for="assessment">Assessment Title</label>
    <input type="text" class="form-control form-control-lg <?php echo (!empty($data['assessment_err'])) ? 'is-invalid' : ''; ?>" id="assessment" name="assessment" value="<?php echo $data['assessment']; ?>" placeholder="Add assessment title...">
    <span class="invalid-feedback"><?php echo $data['assessment_err']; ?></span>
    <p></p>
    <label for="assessment">Load details from Azure</label>
    <input type="text" class="form-control form-control <?php echo (!empty($data['assessment_err'])) ? 'is-invalid' : ''; ?>" id="rg" name="rg" value="" placeholder="Add Resource Group Name...">
    <span class="invalid-feedback"><?php echo $data['assessment_err']; ?></span>
    <a class="btn btn-primary" data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
    Query Azure
    </a>
    <div class="collapse" id="collapseExample">

    <img class="mx-auto d-block" src="<?php echo URLROOT . '/public/init.jpg'?>" alt="diagram">

</div>

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